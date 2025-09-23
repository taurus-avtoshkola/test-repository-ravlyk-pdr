<?php

// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('HTML_ROOT', dirname(dirname(dirname(dirname(__FILE__)))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');

require ROOT.'/index.php';
require_once ROOT.'/core/vendor/autoload.php';

include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);


//При изменении статуса оплати счета добавлять уроки // modx_a_instructor_to_user_g to modx_a_instructor_to_user

$q = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user_web` WHERE add_to_schedule = "0" AND bill_payd = "1" ');
while($r = $modx->db->getRow($q)){

    $check = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user_g` WHERE (user_id = "'.$modx->db->escape($r['user_id']).'" AND user_id != "0") OR user_phone = "'.$modx->db->escape($r['user_phone']).'" LIMIT 1');
    if($modx->db->getRecordCount($check) > 0){
        //Є учень додаємо
        $row = $modx->db->getRow($check);
        if($r['instructor_id'] != ''){
            $instructor_upd = ' 
            instructor_id   = "'.$modx->db->escape($r['instructor_id']).'",
            instructor_name = "'.$modx->db->escape($r['instructor_name']).'", ';
        }
        if($r['order_school'] != ''){
            $school_upd = ' 
            order_school    = "'.$modx->db->escape($r['order_school']).'", '; 
        }
        if($r['order_school'] != ''){
            $comment_upd = ' 
            order_comment    = "'.$modx->db->escape($r['order_comment']).'", '; 
        }
        $modx->db->query('UPDATE `modx_a_instructor_to_user_g` SET 
            '.$instructor_upd.$school_upd.$comment_upd.'
            lesson_total    = "'.$modx->db->escape($row['lesson_total']+$r['lesson_total']).'",
            lesson_balance  = "'.$modx->db->escape($row['lesson_balance']+$r['lesson_balance']).'"
            WHERE (user_id = "'.$modx->db->escape($r['user_id']).'" AND user_id != "0") OR user_phone = "'.$modx->db->escape($r['user_phone']).'" LIMIT 1
        ');
    }else{
        //Немає створюємо новий запис
        $modx->db->query('INSERT INTO `modx_a_instructor_to_user_g` SET 
            user_phone      = "'.$modx->db->escape($r['user_phone']).'", 
            user_name       = "'.$modx->db->escape($r['user_name']).'",
            user_id         = "'.$modx->db->escape($r['user_id']).'",
            instructor_id   = "'.$modx->db->escape($r['instructor_id']).'",
            instructor_name = "'.$modx->db->escape($r['instructor_name']).'",
            lesson_total    = "'.$modx->db->escape($r['lesson_total']).'",
            lesson_balance  = "'.$modx->db->escape($r['lesson_balance']).'",
            type            = "'.$modx->db->escape($r['type']).'",
            order_school    = "'.$modx->db->escape($r['order_school']).'", 
            order_comment   = "'.$modx->db->escape($r['order_comment']).'"
        ');
    }
    $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET add_to_schedule = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
}



//ТАУРУС КИЇВ:
    $spreadsheetId = '11jOTYmRZj6CRDRCfkg9eGMbc-TUUhyRgVn0EJuGUlYw';

    $googleAccountKeyFilePath = MODX_BASE_PATH . 'assets/shop/php/pdr-online-f49641863b8a.json';
    putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );
    $client = new Google_Client();

    $client->useApplicationDefaultCredentials();
    $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

    $service = new Google_Service_Sheets( $client );
    $response = $service->spreadsheets->get($spreadsheetId);
    $spreadsheetProperties = $response->getProperties();



    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
    $day = $today_date->format('Y-m-d'); 

	$values = array();
    $values2 = array();


    $q = $modx->db->query('SELECT *, ituw.id as id FROM `modx_a_instructor_to_user_web` ituw 
        LEFT JOIN `modx_a_order` o ON o.order_id = ituw.order_id
        LEFT JOIN `modx_a_order_products` op ON op.order_id = o.order_id
        LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id
        LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = ituw.user_id
     WHERE ituw.sheet = 0 AND ituw.order_school = "122" AND ituw.bill_payd = "1" ORDER BY ituw.buy_date ASC');

	//$q = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user_web` WHERE sheet = 0 AND order_school = "122" ORDER BY buy_date ASC');
	while ($r = $modx->db->getRow($q)) {


        $order_user_info = json_decode($r['order_user_info'],true);
        if($r['fullname'] == ''){
            $r['fullname'] = $order_user_info['fullname'];
        }
        if($r['lastname'] == ''){
            $r['lastname'] = $order_user_info['lastname'];
        }
        if($r['patronymic'] == ''){
            $r['patronymic'] = $order_user_info['patronymic'];
        }

        $paytype = $r['payment_system_type'];
        $payment_system = json_decode($modx->config['shop_paysystem_'.$paytype],true);

        $date = $r['buy_date']+$modx->config['server_offset_time'];
		switch($r['type']){
			case "0":
				$type = 'Осн';
			break;
			case "1":
				$type = 'Доп';
			break;
			case "2":
				$type = 'Под';
			break;
		}
        $date = $r['buy_date']+$modx->config['server_offset_time'];
        $values[] = array(
            $r['instructor_name'],
            $r['user_phone'],
            $r['user_name'],
            $r['lesson_total'],
            $type,
            date('d.m.Y H:i:s',$date),
            $r['user_id']
            );
        $values2[] = array(
            $r['order_id'],
            date('d.m.Y H:i:s',$date),
            $r['lastname'],
            $r['fullname'],
            $r['patronymic'],
            $r['user_phone'],
            $r['order_cost'],
            $r['product_name'],
            $r['lesson_total'],
            $r['user_id'],
            $r['instructor_name'],
            $payment_system['shop_payname']
            );
        $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET sheet = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	}
    if(count($values)> 0){
        $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Назначение ПДР онлайн';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }

    if(count($values2)> 0){
        $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values2 ] );
        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Закази ПДР 2.0';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }






//ТАУРУС ЛЬВІВ:
$spreadsheetId = '1ceHUfzzJzGGTRazWMInDxI-BFsWMav3plpMyolLdFWY';

    $googleAccountKeyFilePath = MODX_BASE_PATH . 'assets/shop/php/pdr-online-f49641863b8a.json';
    putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );
    $client = new Google_Client();

    $client->useApplicationDefaultCredentials();
    $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

    $service = new Google_Service_Sheets( $client );
    $response = $service->spreadsheets->get($spreadsheetId);
    $spreadsheetProperties = $response->getProperties();


    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
    $day = $today_date->format('Y-m-d'); 

    $values = array();
    $q = $modx->db->query('SELECT *, ituw.id as id FROM `modx_a_instructor_to_user_web` ituw 
        LEFT JOIN `modx_a_order` o ON o.order_id = ituw.order_id
        LEFT JOIN `modx_a_order_products` op ON op.order_id = o.order_id
        LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id
        LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = ituw.user_id
     WHERE ituw.sheet = 0 AND ituw.order_school = "200" AND ituw.bill_payd = "1" ORDER BY ituw.buy_date ASC');
    while ($r = $modx->db->getRow($q)) {



        $paytype = $r['payment_system_type'];
        $payment_system = json_decode($modx->config['shop_paysystem_'.$paytype],true);

        $date = $r['buy_date']+$modx->config['server_offset_time'];
        $values[] = array(
            $r['order_id'],
            date('d.m.Y H:i:s',$date),
            $r['lastname'],
            $r['fullname'],
            $r['patronymic'],
            $r['user_phone'],
            $r['order_cost'],
            $r['product_name'],
            $r['lesson_total'],
            $r['user_id'],
            $r['instructor_name'],
            $payment_system['shop_payname']
            );
        $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET sheet = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    }
    if(count($values)> 0){
        $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Оплати з РАВЛИКА';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }



?>


