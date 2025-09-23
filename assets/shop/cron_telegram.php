<?php
// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

include MODX_BASE_PATH . "assets/shop/telegram.class.php";
$telegram = new Telegram($modx);


//send booking to instructor
$time = strtotime('yesterday 23:00');
$to = date('Y-m-d H:i:s',$time);
$q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
  LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
  LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
  LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = isc.user_id
   WHERE ustr.tg_manager = "0" AND isc.full > "'.$modx->db->escape($to).'"
   ORDER BY isc.full DESC, ustr.status ASC
');

while($r = $modx->db->getRow($q)){

    $date = new DateTime($r['full']);
    if($r['offset'] > 0){
      $date->modify("+".($r['offset']*60)." seconds");
    }
    setlocale(LC_TIME, 'uk_UA.UTF-8');
    $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
    $answer = '🐌 Клієнт '.$r['user_name'].' ('.$r['user_phone'].') 🟢 забронював(ла) заняття в '.$r['date'].'';
    if($r['user_comment'] != ''){
      $answer .= '; Коментар клієнта: '.$r['user_comment'];
    }
//  $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
  
     $keyboard = [[
        ['text' => '✅ Підтвердити запис', 'callback_data' => 'apply_booking'],
        ['text' => '❌ Скасувати запис', 'callback_data' => 'cancel_booking'],
    ]];
    $send_data['reply_markup'] = json_encode([
        'inline_keyboard' => $keyboard
    ]);

    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
    $send_data['chat_id'] = $r['chat_id'];

    ///FIX!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!next remove
    //$send_data['chat_id'] = '362971380';
    $send_data['parse_mode'] = 'MarkdownV2';
    $res = $telegram->sendMessage($send_data);
    $message_id = $res['result']['message_id'];

    $modx->db->query('INSERT INTO `modx_a_telegram_actions` SET 
      message_id = "'.$modx->db->escape($message_id).'",
      chat_id = "'.$modx->db->escape($send_data['chat_id']).'",
      action_id = "book_schedule",
      data = "'.$modx->db->escape($r['reserv_id']).'"
    ');

    $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET tg_manager = "1" WHERE id = "'.$modx->db->escape($r['reserv_id']).'" LIMIT 1');
}


//send prove booking to user
$time = strtotime('yesterday 23:00');
$to = date('Y-m-d H:i:s',$time);
$q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove, wua.phone as phone FROM `modx_a_user_schedule_to_reserv` ustr
  LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
  LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
  LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = ustr.client_id
  LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = ustr.instructor_id
   WHERE ustr.tg_user = "0" AND isc.full > "'.$modx->db->escape($to).'"
   ORDER BY isc.full DESC, ustr.status ASC
');

while($r = $modx->db->getRow($q)){

    $date = new DateTime($r['full']);
    if($r['offset'] > 0){
      $date->modify("+".($r['offset']*60)." seconds");
    }
    setlocale(LC_TIME, 'uk_UA.UTF-8');
    $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
    if($r['status'] == '3'){
      $answer = '🐌 Ваш запис на заняття в '.$r['date'].' *❌ Скасовано!* Контакти інструктора: '.$r['phone'].'';
    }else{
      $answer = '🐌 Ваш запис на заняття в '.$r['date'].' *✅ Підтверджено!* Контакти інструктора: '.$r['phone'].'';
    }

    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
    $send_data['chat_id'] = $r['chat_id'];

    $send_data['parse_mode'] = 'MarkdownV2';
    $res = $telegram->sendMessage($send_data);
    $message_id = $res['result']['message_id'];

    $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET tg_user = "1" WHERE id = "'.$modx->db->escape($r['reserv_id']).'" LIMIT 1');

}