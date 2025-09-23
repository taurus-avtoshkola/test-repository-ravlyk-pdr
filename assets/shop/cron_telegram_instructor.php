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


$keyboard[] = array(array('text' => 'Головна'), array('text' => 'Мій розклад'), array('text' => 'Мої студенти'));
$keyboard[] = array(array('text' => 'Моя статистика'), array('text' => 'Моя заробітня плата'), array('text' => 'Записи на заняття'));
$today = date('Y-m-d');

$q = $modx->db->query('SELECT * FROM `modx_a_telegram` WHERE telegram_type = "1" AND telegram_notify = "1" ');
while($r = $modx->db->getRow($q)){

  $answer = '🗓️Ваш розклад на сьогодні:';

  $date = time()+$modx->config['server_offset_time'];
  $start_date = new DateTime(date('Y-m-d',$date));
  $start_day = $start_date->format('Y-m-d');
  $end_date = clone $start_date;
  $end_date->add(new DateInterval('P1D'));      
  $end_day = $end_date->format('Y-m-d');

  $u = array();
  $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
    LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_name = str.client 
    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($r['modx_id']).'" ');
  while($rsch = $modx->db->getRow($usch)){
      $u[$rsch['full']] = $rsch;
  }

  for ($i = 0; $i < 1; $i++) {
      $idate = clone $start_date;
      $idate->add(new DateInterval('P' . $i . 'D'));
      $day_of_week = $idate->format('w');
      $day_month = $idate->format('d.m.Y');
      $full = $idate->format('Y-m-d');
      $answer .= '
'.$shop->formatWeekShort($day_of_week).' '.$day_month;
      for ($j = 6; $j < 23; $j++) {
        $day = $idate->format('Y-m-d');
        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
        $full = $day.' '.$time;
        $time = $j.':00';
        $class = '';
        $pickup_address = '';
        if(isset($u[$full])){
          $class = $shop->calendarStatusSmile($u[$full]['status']);
          $pickup_address = $u[$full]['pickup_address'];
          if($u[$full]['offset'] != 0){
            $time = $j.':'.$u[$full]['offset'];
            $class .= ' offset_'.$u[$full]['offset'];
          }
        }else{
          $class = $shop->calendarStatusSmile('0');
        }
        if($u[$full]['user_name'] != ''){
          $client = ' 🐌 '.$u[$full]['user_name'].' ('.$u[$full]['user_phone'].')';
        }else{
          $client = '';
        }
        $answer .= '
'.$class.' '.$time.' ('.$pickup_address.')'.$client;
      }
  }


  $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);

  $send_data['text'] = $telegram->escapeMarkdownV2($answer);
  $send_data['chat_id'] = $r['chat_id'];

  ///FIX!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!next remove
  //$send_data['chat_id'] = '362971380';
  $send_data['parse_mode'] = 'MarkdownV2';
  $send_data['disable_notification'] = true;
  $res = $telegram->sendMessage($send_data);

}
