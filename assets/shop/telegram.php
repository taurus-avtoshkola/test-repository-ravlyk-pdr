<?php
// Подключаем
define('MODX_API_MODE', true);
require $_SERVER['DOCUMENT_ROOT'].'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);
include MODX_BASE_PATH . "assets/shop/telegram.class.php";
$telegram = new Telegram($modx);

$modx->config['lang'] = 'ua';
$_SESSION['lang'] = 'ua';
$telegram_data = file_get_contents('php://input');
$telegram_info = json_decode($telegram_data, TRUE);

//log
$modx->db->query('INSERT INTO `modx_a_telegram_log` SET info = "'.$modx->db->escape($telegram_data).'" ');

if(isset($telegram_info['message'])){
    $type = 'message';
    $message_id = $telegram_info['message']['message_id'];
    $chat_id = $telegram_info['message']['chat']['id'];
    $user_id = $telegram_info['message']['from']['id'];
    $user_name = $telegram_info['message']['from']['first_name'].' '.$telegram_info['message']['from']['last_name'];
    $user_nick = $telegram_info['message']['from']['username'];
    $user_text = trim($telegram_info['message']['text']);
}else{
    if(isset($telegram_info['callback_query'])){
        $type = 'callback_query';
        $message_id = $telegram_info['callback_query']['message']['message_id'];
        $chat_id = $telegram_info['callback_query']['message']['chat']['id'];
        $user_id = $telegram_info['callback_query']['message']['from']['id'];
        $user_name = $telegram_info['callback_query']['message']['from']['first_name'].' '.$telegram_info['callback_query']['message']['from']['last_name'];
        $user_nick = $telegram_info['callback_query']['message']['from']['username'];
        $user_text = trim($telegram_info['message']['text']);
    }else{
        $type = 'my_chat_member';
        $message_id = $telegram_info['message']['message_id'];
        $chat_id = $telegram_info['message']['chat']['id'];
        $user_id = $telegram_info['message']['from']['id'];
        $user_name = $telegram_info['message']['from']['first_name'].' '.$telegram_info['message']['from']['last_name'];
        $user_nick = $telegram_info['message']['from']['username'];
        $user_text = trim($telegram_info['message']['text']);
                
    }
}

//Головне меню користувач:
$keyboard[0][] = array(array('text' => 'Головна'), array('text' => 'Особисті дані'), array('text' => 'Моя підписка'));
$keyboard[0][] = array(array('text' => 'Моя практика'), array('text' => 'Онлайн навчання'));

//Головне меню Інструктор:
$keyboard[1][] = array(array('text' => 'Головна'), array('text' => 'Мій розклад'), array('text' => 'Мої студенти'));
$keyboard[1][] = array(array('text' => 'Моя статистика'), array('text' => 'Моя заробітня плата'), array('text' => 'Записи на заняття'));

//Головне меню менеджер:
$keyboard[2][] = array(array('text' => 'Головна'), array('text' => 'Мій кабінет'), array('text' => 'Кабінет менежера'));

//Головне меню Супер менеджер:
$keyboard[3][] = array(array('text' => 'Головна'), array('text' => 'Мій кабінет'), array('text' => 'Кабінет менежера'));

//✅ ❌  🐌 ❗🟢🔴🟠⚪⚫🟤🐌🚫⛔
//$modx->db->query('INSERT INTO `modx_test` SET test = "'.$modx->db->escape(json_encode($res)).'" ');
switch ($type) {
    case "callback_query":
        $resp = $telegram_info['callback_query']['data'];

        switch($resp){
            case "apply_booking":
                $q_message = $modx->db->query('SELECT * FROM `modx_a_telegram_actions` WHERE chat_id = "'.$modx->db->escape($chat_id).'" AND action_id = "book_schedule" AND message_id = "'.$modx->db->escape($message_id).'" AND archive = "0" LIMIT 1');
                if($modx->db->getRecordCount($q_message) > 0){
                    $find_message = $modx->db->getRow($q_message);
                    $book_id = $find_message['data'];
                    $action_id = $find_message['action_id'];
                    $keyboard = [[
                        ['text' => '✅ Запит підтверджено', 'callback_data' => '#']
                    ]];
                    $send_data['reply_markup'] = json_encode([
                        'inline_keyboard' => $keyboard
                    ]);
                    $send_data['message_id'] = $message_id;


                    $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
                      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
                      LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
                      LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = isc.user_id
                       WHERE ustr.id = "'.$modx->db->escape($book_id).'" LIMIT 1 ');
                    $r = $modx->db->getRow($q);

                    $date = new DateTime($r['full']);
                    if($r['offset'] > 0){
                      $date->modify("+".($r['offset']*60)." seconds");
                    }
                    setlocale(LC_TIME, 'uk_UA.UTF-8');
                    $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
                    $answer = '🐌 Клієнт '.$r['user_name'].' ('.$r['user_phone'].') заняття в '.$r['date'].'';
                    if($r['user_comment'] != ''){
                      $answer .= '; Коментар клієнта: '.$r['user_comment'];
                    }

                    $answer .='
*🟢 Заброньовано*';
                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->editMessage($send_data);
                    $modx->db->query('UPDATE `modx_a_telegram_actions` SET archive = "1" WHERE id = "'.$modx->db->escape($find_message['id']).'" LIMIT 1');

                    $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET status_prove = "1", tg_user = "0" WHERE id = "'.$modx->db->escape($book_id).'" LIMIT 1');
            

                }
            break;
            case "cancel_booking":
                $q_message = $modx->db->query('SELECT * FROM `modx_a_telegram_actions` WHERE chat_id = "'.$modx->db->escape($chat_id).'" AND action_id = "book_schedule" AND message_id = "'.$modx->db->escape($message_id).'" AND archive = "0" LIMIT 1');
                if($modx->db->getRecordCount($q_message) > 0){
                    $find_message = $modx->db->getRow($q_message);
                    $book_id = $find_message['data'];
                    $action_id = $find_message['action_id'];
                    $keyboard = [[
                        ['text' => '❌ Запит скасовано', 'callback_data' => '#']
                    ]];
                    $send_data['reply_markup'] = json_encode([
                        'inline_keyboard' => $keyboard
                    ]);
                    $send_data['message_id'] = $message_id;

                    $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
                      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
                      LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
                      LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = isc.user_id
                       WHERE ustr.id = "'.$modx->db->escape($book_id).'" LIMIT 1 ');
                    $r = $modx->db->getRow($q);

                    $date = new DateTime($r['full']);
                    if($r['offset'] > 0){
                      $date->modify("+".($r['offset']*60)." seconds");
                    }
                    setlocale(LC_TIME, 'uk_UA.UTF-8');
                    $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
                    $answer = '🐌 Клієнт '.$r['user_name'].' ('.$r['user_phone'].') заняття в '.$r['date'].'';
                    if($r['user_comment'] != ''){
                      $answer .= '; Коментар клієнта: '.$r['user_comment'];
                    }
                    $answer .='
*🔴 Скасовано*';
                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->editMessage($send_data);
                    $modx->db->query('UPDATE `modx_a_telegram_actions` SET archive = "1" WHERE id = "'.$modx->db->escape($find_message['id']).'" LIMIT 1');

                    $q = $modx->db->query('SELECT * FROM `modx_a_user_schedule_to_reserv` ustr 
                        LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id
                        WHERE ustr.id = "'.$modx->db->escape($book_id).'" AND ustr.status_prove = "0" LIMIT 1');
                    if($modx->db->getRecordCount($q) > 0){
                        $r = $modx->db->getRow($q);
                        $schedule_id = $r['schedule_id'];
                        $type = $r['type'];
                        $client_id = $r['client_id'];
                        $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance + 1 WHERE user_id = "'.$modx->db->escape($client_id).'" AND type = "'.$modx->db->escape($type).'" LIMIT 1');         
                        $modx->db->query('UPDATE `modx_a_instructor_schedule` SET type = "0" WHERE id = "'.$modx->db->escape($schedule_id).'" LIMIT 1');
                        $modx->db->query('UPDATE `modx_a_instructor_schedule_to_reserv` SET status = "1", client = "", client_id = "" WHERE schedule_id = "'.$modx->db->escape($schedule_id).'" LIMIT 1');
                        $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET status_prove = "1", status = "3", tg_user = "0" WHERE id = "'.$modx->db->escape($book_id).'" LIMIT 1');
                    }


                }
            break;
        }


    break;
    case 'message':
        $check_auth = $modx->db->query('SELECT * FROM `modx_a_telegram` v LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = v.modx_id WHERE v.telegram_id = "'.$modx->db->escape($user_id).'" AND v.proved = "1" LIMIT 1');
        if($modx->db->getRecordCount($check_auth) > 0){
            //Авторизированный клиент
            $user = $modx->db->getRow($check_auth);

            $exp = explode(':', $user_text);
            if($exp[0] == 'Попередній день' OR $exp[0] == 'Наступний день'){
                $exp[0] = 'Мій розклад';
                $date_e = explode('.',$exp[1]);
                $exp[1] = $date_e[2].'-'.$date_e[1].'-'.$date_e[0];
            }
            switch ($exp[0]) {
                case 'test':

//✅ ❌  🐌 ❗🟢🔴🟠⚪⚫🟤🐌🚫⛔💰⚡⭐🕓🗓️✏️🔎💡🗑️🔒
/*
$keyboard[1][] = array(array('text' => 'Головна'), array('text' => 'Мій розклад'), array('text' => 'Мої студенти'));
$keyboard[1][] = array(array('text' => 'Моя статистика'), array('text' => 'Моя заробітня плата'), array('text' => 'Записи на заняття'));
*/

                break;
                case "Додати робочий день":

                    if($user['cabinet_type'] != '1'){
                        //Невірний тип
                        $answer = '🔒Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
                        //ОК

                        $date_e = explode('.',$exp[1]);
                        $date = $date_e[2].'-'.$date_e[1].'-'.$date_e[0];

                        $date = new DateTime($date);
                        $dayOfWeek = $date->format('w');

                        $q = $modx->db->query('SELECT * FROM `modx_a_instructor_settings` WHERE user_id = "'.$modx->db->escape($user['internalKey']).'" AND day = "'.$modx->db->escape($dayOfWeek).'" ORDER BY day_start ASC');
                        if($modx->db->getRecordCount($q) > 0){
                          while($r = $modx->db->getRow($q)){
                            for ($j = $r['day_start']; $j < $r['day_end']; $j++) {
                              $time = $j.':00';
                              $class = $shop->calendarStatus('1');
                              $day = $date->format('Y-m-d');
                              $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                              $full = $day.' '.$time;
                              $duration = 60;
                              $type = $r['type'];
                              $offset = $r['offset'];

                              $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule` SET
                                user_id = "'.$modx->db->escape($user['internalKey']).'",
                                full = "'.$modx->db->escape($full).'",
                                day = "'.$modx->db->escape($day).'",
                                time = "'.$modx->db->escape($time).'",
                                type = "'.$modx->db->escape($type).'",
                                offset = "'.$modx->db->escape($offset).'",
                                duration = "'.$modx->db->escape($duration).'",
                                pickup_address = "'.$modx->db->escape($r['pickup_address']).'"
                              ');
                              $schedule_id = $modx->db->getInsertId();
                              if($schedule_id != ''){
                                $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule_to_reserv` SET schedule_id = "'.$modx->db->escape($schedule_id).'", status = "1"');
                              }
                            }
                            $answer = '🗓️Розклад на день додано';
                          }
                        }else{
                            $answer = '🚫Помилка!. Спочатку заповніть в налаштуваннях розклад для цього дня тижня!';
                        }

                        unset($keyboard);

                        $start_date = $date;


                        $today = $start_date->format('d.m.Y');
                        $next_date = clone $start_date; 
                        $next = $next_date->add(new DateInterval('P1D'))->format('d.m.Y');  
                        $prev_date = clone $start_date;
                        $prev = $prev_date->sub(new DateInterval('P1D'))->format('d.m.Y');
                        

                        $keyboard[] = array(array('text' => 'Головна'));
                        $keyboard[] = array(array('text' => 'Попередній день:'.$prev));
                        $keyboard[] = array(array('text' => 'Наступний день:'.$next));

                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);




                    }
                break;
                case 'Мій розклад':
                    if($user['cabinet_type'] != '1'){
                        //Невірний тип
                        $answer = '🔒Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
                        //ОК
                        $answer = '🗓️Розклад:';


                        if($exp[1] != ''){
                            $date = strtotime($exp[1]);
                        }else{
                            $date = time()+$modx->config['server_offset_time'];
                        }

                        $start_date = new DateTime(date('Y-m-d',$date));
                        $start_day = $start_date->format('Y-m-d');
                        $end_date = clone $start_date;
                        $end_date->add(new DateInterval('P1D'));      
                        $end_day = $end_date->format('Y-m-d');
           
                        $u = array();
                        $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                          LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                          LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_name = str.client 
                          WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($user['internalKey']).'" ');
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

                        $today = $start_date->format('d.m.Y');
                        $next_date = clone $start_date; 
                        $next = $next_date->add(new DateInterval('P1D'))->format('d.m.Y');  
                        $prev_date = clone $start_date;
                        $prev = $prev_date->sub(new DateInterval('P1D'))->format('d.m.Y');
            
                        unset($keyboard);

                        $keyboard[] = array(array('text' => 'Головна'));
                        $keyboard[] = array(array('text' => 'Попередній день:'.$prev));
                        $keyboard[] = array(array('text' => 'Додати робочий день:'.$today));
                        $keyboard[] = array(array('text' => 'Наступний день:'.$next));

                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }
                break;
                case "Мої студенти":
                    if($user['cabinet_type'] != '1'){
                        //Невірний тип
                        $answer = '🔒Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
                      $q = $modx->db->query('SELECT *
                        FROM `modx_a_instructor_to_user`
                        WHERE instructor_name = "'.$modx->db->escape($user['cabinet_syncname']).'" ORDER BY row_id ASC');
                      if($modx->db->getRecordCount($q) > 0){
                        $answer = '*Мої студенти:*';

                        while($r = $modx->db->getRow($q)){
                          switch($r['type']){
                            default: 
                            case "0":
                              $type_text = 'Осн';
                            break;
                            case "1":
                              $type_text = 'Доп';
                            break;
                            case "2":
                              $type_text = 'Под';
                            break;
                          }

                          $answer .= '
    🐌'.$r['user_name'].' ('.$r['user_phone'].') * 🗓'.$r['lesson_total'].'/'.$r['lesson_balance'].'* ('.$type_text.')';

                        }

                      }else{
                        $answer = '🚫Студентів не знайдено';
                      }


                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);

                   }
                break;
                case "Моя статистика":
                    if($user['cabinet_type'] != '1'){
                        //Невірний тип
                        $answer = '🔒Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
                        $answer = '*Моя статистика:*';
    if(date('N') == 1){
      $from = date('Y-m-d', strtotime('monday -1 week'));
      $to = date('Y-m-d', strtotime('last Sunday'));
    }else{
      $from = date('Y-m-d', strtotime('monday -2 week'));
      $to = date('Y-m-d', strtotime('last Sunday'));
    }
    $r = $modx->db->getRow($modx->db->query('SELECT count(isc.id) as total FROM `modx_a_instructor_schedule` isc
LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = isc.id 
WHERE (istr.status = "2" OR istr.status = "3") AND isc.user_id = "'.$modx->db->escape($user['internalKey']).'" AND day >= "'.$modx->db->escape($from).'" AND day <= "'.$modx->db->escape($to).'" LIMIT 1'));
    $answer  .= '
⚪Виконано на минулому тижні:*'.$r['total'].'*';

    $from = date('Y-m-d', strtotime('monday this week'));
    $to = date('Y-m-d', strtotime('yesterday'));
    $r = $modx->db->getRow($modx->db->query('SELECT count(isc.id) as total FROM `modx_a_instructor_schedule` isc
LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = isc.id 
WHERE (istr.status = "2" OR istr.status = "3") AND isc.user_id = "'.$modx->db->escape($user['internalKey']).'" AND day >= "'.$modx->db->escape($from).'" AND day <= "'.$modx->db->escape($to).'" LIMIT 1'));
    $answer  .= '
⚫Виконано на цьому тижні:*'.$r['total'].'*';


    $from = date('Y-m-d');
    $to = date('Y-m-d', strtotime('sunday this week'));
    $r = $modx->db->getRow($modx->db->query('SELECT count(isc.id) as total FROM `modx_a_instructor_schedule` isc
LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = isc.id 
WHERE (istr.status = "2" OR istr.status = "3") AND isc.user_id = "'.$modx->db->escape($user['internalKey']).'" AND day >= "'.$modx->db->escape($from).'" AND day <= "'.$modx->db->escape($to).'" LIMIT 1'));
    $answer  .= '
🟤Заплановано на цьому тижні:*'.$r['total'].'*';

                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);

                   }
                break;
                case "Моя заробітня плата":
                    if($user['cabinet_type'] != '1'){
                        //Невірний тип
                        $answer = '🔒Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
    
                        $q = $modx->db->query('SELECT * FROM `modx_a_instructor_to_zp` WHERE instructor_name = "'.$modx->db->escape($user['cabinet_syncname']).'" LIMIT 1');
                        if($modx->db->getRecordCount($q) > 0){
                          $r = $modx->db->getRow($q);
                          $answer = '*💰Моя заробітня плата:*';
                          $answer = '
Залишилось сплатити:*'.$r['sum_need_to_pay'].' грн.*';
                        }else{
                          $answer = '🚫Данних не знайдено';
                        }


                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                   }
                break;
                case "Записи на заняття":
                    if($user['cabinet_type'] != '1'){
                        //Невірний тип
                        $answer = '🔒Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
    


                        //З вчора з 23ої 
                        $time = strtotime('yesterday 23:00');
                        $to = date('Y-m-d H:i:s',$time);
                        $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
                          LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
                          LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
                           WHERE isc.user_id = "'.$modx->db->escape($user['internalKey']).'" AND isc.full > "'.$modx->db->escape($to).'" AND ( ustr.status_prove = "0" OR ustr.status  != "3" )
                           ORDER BY isc.full DESC, ustr.status ASC
                        ');
                        if($modx->db->getRecordCount($q) > 0){
                          while($r = $modx->db->getRow($q)){
                            switch($r['type']){
                              default: 
                              case "0":
                                $type_text = 'Осн';
                              break;
                              case "1":
                                $type_text = 'Доп';
                              break;
                              case "2":
                                $type_text = 'Под';
                              break;
                            }
                            switch($r['status']){
                              default: 
                              case "2":
                                $status = '🟠Заброньовано';
                              break;
                              case "3":
                                $status = '🔴Скасовано';
                              break;
                            }
                            $date = new DateTime($r['full']);
                            if($r['offset'] > 0){
                              $date->modify("+".($r['offset']*60)." seconds");
                            }
                            setlocale(LC_TIME, 'uk_UA.UTF-8');
                            $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());

                            $user_phone_p = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['user_phone'])))));
                            $answer .= '
🗓️'.$r['date'].' 🐌'.$r['user_name'].' ('.$user_phone_p.') '.$status.' - *'.$r['lesson_balance'].'/'.$r['lesson_total'].'* '.$type_text;
                          }
                        }else{
                          $answer = '🚫Запитів не знайдено';
                        }

                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                   }
                break;
                case 'Кабінет менежера':
                    if($user['cabinet_type'] != '2' OR $user['cabinet_type'] != '3'){
                        //Невірний тип
                        $answer = 'Цей розділ не доступний. Оберіть з меню';
                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }else{
                        //ОК
                        $answer = 'Кабінет Менеджера. Оберіть потрібний розділ';
                        unset($keyboard);

                        $keyboard[] = array(array('text' => 'Головна'));
                        //$keyboard[] = array(array('text' => 'Видалити мій аккаунт'));

                        $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);
                        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                        $send_data['chat_id'] = $chat_id;
                        $send_data['parse_mode'] = 'MarkdownV2';
                        $res = $telegram->sendMessage($send_data);
                    }
                break;
                case 'Особисті дані':
                    $answer = '*Ваші дані*:
Ім`я: *'.$user['fullname'].'*
Прізвище: *'.$user['lastname'].'*
По-батькові: *'.$user['patronymic'].'*
Телефон: *'.$user['phone'].'*
E-mail: *'.$user['email'].'*
Місто: *'.$user['city'].'*';

                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);
                break;
                case 'Моя підписка':
                    switch($user['user_type']){
                      case "0":
                        $answer = 'Тип акаунту:*⭐ Standart*';
                      break;
                      case "1":
                        $answer = 'Тип акаунту:*💰 Premium*
';
                        if($user['subscribedate'] != ''){
                          $answer .= 'Підписка активна до: *🕓'.date('d.m.Y', ($user['subscribedate']+$modx->config['server_offset_time'])).'*';
                        }
                      break;
                    }
                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);

                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);
                break;
                case 'Моя практика':
                    $answer = 'Перейдіть у розділ https://pdr-online.com.ua/instruktori/ та оберіть інструктора для запису на заняття';
                     
                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);

                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);
                break;
                case 'Онлайн навчання':        
                    $answer = 'Для навчання перейдіть у розділ https://pdr-online.com.ua/onlajn-navchannya/';
                     
                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);

                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);
                break;
                case 'Головна':
                default:
                    $answer = 'Вітаю, '.$user['fullname'].' '.$user['lastname'].'! Що вас цікавить?';
                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);
                break;
            }
        }else{
            //Не авторизированный
                if($telegram_info['message']['contact']['phone_number'] != ''){
                    //реєстрація
                    if($user_id == $telegram_info['message']['contact']['user_id']){
                        $phone_str = strval($telegram_info['message']['contact']['phone_number']);
                        $phone_r = '+'.substr($phone_str, 0, 2).' ('.substr($phone_str, 2, 3).') '.substr($phone_str, 5, 3).'-'.substr($phone_str, 8, 2).'-'.substr($phone_str, 10, 2);
                
                        $check_user = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE phone = "'.$modx->db->escape($phone_r).'" LIMIT 1');
                        if($modx->db->getRecordCount($check_user) > 0){
                            $user = $modx->db->getRow($check_user);
                            $modx_id = $user['internalKey'];
                            $email = $user['email'];
                            $modx->db->query('INSERT INTO `modx_a_telegram` SET 
                                chat_id   = "'.$modx->db->escape($chat_id).'",
                                telegram_id = "'.$modx->db->escape($user_id).'",
                                telegram_name = "'.$modx->db->escape($user_name).'",
                                telegram_nick = "'.$modx->db->escape($user_nick).'",
                                phone = "'.$modx->db->escape($phone_r).'",
                                email = "'.$modx->db->escape($email).'",
                                modx_id = "'.$modx->db->escape($modx_id).'",
                                proved = 1
                            ');
                            $answer = 'Вітаю, '.$user['fullname'].' '.$user['lastname'].'! Що вас цікавить?';
                            $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard[$user['cabinet_type']]);
                            $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                            $send_data['chat_id'] = $chat_id;
                            $send_data['parse_mode'] = 'MarkdownV2';
                            $res = $telegram->sendMessage($send_data);

                        }else{

                            $modx->config['site_url_b'] = substr($modx->config['site_url'], 0, -1);
                            $answer = 'Користувача за данним номером не знайдено. Для реєстрації перейдіть на сайт '.$modx->config['site_url_b'].' та зареєструйте Користувача';                            
                            $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                            $send_data['chat_id'] = $chat_id;
                            $send_data['parse_mode'] = 'MarkdownV2';
                            $res = $telegram->sendMessage($send_data);
                        }
                    }else{
                            $modx->config['site_url_b'] = substr($modx->config['site_url'], 0, -1);
                            $answer = 'Поділіться своїм номером. Натисність "Поділитись телефоном"';                            
                            $send_data['reply_markup'] = array(
                                'keyboard' => array(
                                    array(array('text'=>"Поділитись телефоном",'request_contact'=>true))
                                )
                            );
                            $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                            $send_data['chat_id'] = $chat_id;
                            $send_data['parse_mode'] = 'MarkdownV2';
                            $res = $telegram->sendMessage($send_data);
                    }
                }else{
                    //Вступне слово
                    $answer = "Вітаємо у чат-боті Равлик ПДР. Для продовження натисніть Поділитись телефоном";
                    $send_data['reply_markup'] = array(
                        'keyboard' => array(
                            array(array('text'=>"Поділитись телефоном",'request_contact'=>true))
                        )
                    );
                    $send_data['text'] = $telegram->escapeMarkdownV2($answer);
                    $send_data['chat_id'] = $chat_id;
                    $send_data['parse_mode'] = 'MarkdownV2';
                    $res = $telegram->sendMessage($send_data);
                    die;
                }
            }


    break;    
    case 'my_chat_member':
        $answer = "Вітаємо у чат-боті Равлик ПДР. Для продовження натисніть Поділитись телефоном";
        $send_data['reply_markup'] = array(
            'keyboard' => array(
                array(array('text'=>"Поділитись телефоном",'request_contact'=>true))
            )
        );
        $send_data['text'] = $telegram->escapeMarkdownV2($answer);
        $send_data['chat_id'] = $chat_id;
        $send_data['parse_mode'] = 'MarkdownV2';
        $res = $telegram->sendMessage($send_data);
		die;
    break;
}





die;

                /*





                    $keyboard = [
    [
        ['text' => 'Головна', 'callback_data' => 'main'],
        ['text' => 'Особисті дані', 'callback_data' => 'personal_data'],
        ['text' => 'Моя підписка', 'callback_data' => 'my_subscription'],
    ],
    [
        ['text' => 'Практичні заняття', 'callback_data' => 'practical_lessons'],
        ['text' => 'Онлайн навчання', 'callback_data' => 'online_learning'],
    ],
];

$send_data['reply_markup'] = json_encode([
    'inline_keyboard' => $keyboard
]);
                
                case "Так, видалити аккаунт":

                    $ra = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_telegram` WHERE chat_id = "'.$modx->db->escape($chat_id).'" LIMIT 1'));
                    
                    if($ra['modx_id'] != ''){
                        $modx->db->query('DELETE FROM `modx_a_telegram` WHERE chat_id = "'.$modx->db->escape($chat_id).'" LIMIT 1');
                        $modx->db->query('DELETE FROM `modx_web_users` WHERE id = "'.$modx->db->escape($ra['modx_id']).'" LIMIT 1');
                        $modx->db->query('DELETE FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($ra['modx_id']).'" LIMIT 1');
                        $modx->db->query('DELETE FROM `modx_web_groups` WHERE webuser = "'.$modx->db->escape($ra['modx_id']).'" LIMIT 1');
                    }

                    $answer = 'Ваш аккаунт видалено';
                    unset($keyboard);

                    $keyboard[] = array(array('text' => 'Головна'));
                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);
                    $send_data['text'] = $answer;
                    $send_data['chat_id'] = $chat_id;
                    $res = $telegram->sendMessage($send_data);
                break;
                case "Ні, я передумав":
                    $answer = 'Вітаю, '.$user['fullname'].' '.$user['lastname'].'! Що вас цікавить?';

                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);
                    $send_data['text'] = $answer;
                    $send_data['chat_id'] = $chat_id;
                    $res = $telegram->sendMessage($send_data);
                break;
                case "Видалити мій аккаунт":

                    $answer = 'Ви впевнені що хочете видалити аккаунт?';
                    unset($keyboard);

                    $keyboard[] = array(array('text' => 'Головна'));
                    $keyboard[] = array(array('text' => 'Так, видалити аккаунт'));
                    $keyboard[] = array(array('text' => 'Ні, я передумав'));

                    $send_data['reply_markup'] = array('resize_keyboard' => true, 'keyboard' => $keyboard);
                    $send_data['text'] = $answer;
                    $send_data['chat_id'] = $chat_id;
                    $res = $telegram->sendMessage($send_data);
                break;
                */
?>