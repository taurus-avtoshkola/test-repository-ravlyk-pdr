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



    $spreadsheetId = '1apRRq71gyZwKy02Do4EqCElFLZXbhNwQkqcKbNmizIM';



    $googleAccountKeyFilePath = MODX_BASE_PATH . 'assets/shop/php/pdr-online-f49641863b8a.json';
    putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );
    $client = new Google_Client();

    $client->useApplicationDefaultCredentials();
    $client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

    $service = new Google_Service_Sheets( $client );
    $response = $service->spreadsheets->get($spreadsheetId);
    $spreadsheetProperties = $response->getProperties();





	$values = array();
	$q = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE googlesent = "0" ORDER BY internalKey ASC LIMIT 500');
	while ($r = $modx->db->getRow($q)) {

      	$utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
		$utm = json_decode($r['utm'],true);
		foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
		}
      		
      	if($r['test_photo'] == '1'){
      		$test_photo = 'Равлик ПДР';
      	}else{
      		$test_photo = 'Офіційні';
      	}
      	if($r['category_type'] == '0'){
      		$r['category_type'] = '-';
      	}
      	if($r['transmission'] == NULL){
      		$r['transmission'] = '-';
      	}
        $date = $r['regdate']+$modx->config['server_offset_time'];
        $values[] = array(
            $r['internalKey'],
            $r['fullname'],
            $r['lastname'],
            $r['patronymic'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $r['category_type'],
            $r['transmission'],
            $test_photo,
            date('d.m.Y H:i:s ',$date),
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        if($r['reg_from_instructors'] == '1'){
            $values_rfi[] = array(
                $r['internalKey'],
                $r['fullname'],
                $r['lastname'],
                $r['patronymic'],
                $r['phone'],
                $r['email'],
                $r['city'],
                $r['category_type'],
                $r['transmission'],
                $test_photo,
                date('d.m.Y H:i:s ',$date),
                $utm_source,
                $utm_medium,
                $utm_campaign,
                $utm_content,
                $utm_term
                );
        }
        $modx->db->query('UPDATE `modx_web_user_attributes` SET googlesent = "1" WHERE internalKey = "'.$modx->db->escape($r['internalKey']).'" LIMIT 1');


	}
    if(count($values)> 0){
        $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Користувачі v2';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }
    if(count($values_rfi)> 0){
        $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Потрібен інструктор';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }






	$values2 = array();
	$q = $modx->db->query('SELECT * FROM `modx_a_webi` WHERE googlesent = "0" ORDER BY id ASC LIMIT 50');
	while ($r = $modx->db->getRow($q)) {

      	$utm_p = '';
		$utm = json_decode($r['utm'],true);
		foreach($utm as $k => $v){
			if($v != ''){
			$utm_p .= $k.':'.$v.';
';
			}
		}
      		
 
  		$webi_date = date('d-m-Y H:i:s',$r['webi_date']+$modx->config['server_offset_time']);
  		$reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values2[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $r['webi_name'],
            $webi_date,
            $reg_date,
            $utm_p
            );
        $modx->db->query('UPDATE `modx_a_webi` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	

	}
    if(count($values2)> 0){
        $body2    = new Google_Service_Sheets_ValueRange( [ 'values' => $values2 ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Вебінари';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body2, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }



	$values3 = array();
	$q = $modx->db->query('SELECT * FROM `modx_a_webi_in` WHERE googlesent = "0" ORDER BY id ASC LIMIT 50');
	while ($r = $modx->db->getRow($q)) {

      	$utm_p = '';
		$utm = json_decode($r['utm'],true);
		foreach($utm as $k => $v){
			if($v != ''){
			$utm_p .= $k.':'.$v.';
';
			}
		}
      		
 
  		$reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values3[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $reg_date,
            $utm_p
            );
        $modx->db->query('UPDATE `modx_a_webi_in` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	

	}
    if(count($values3)> 0){
        $body3    = new Google_Service_Sheets_ValueRange( [ 'values' => $values3 ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Вебінари(W)';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body3, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }
	$values4 = array();
	$q = $modx->db->query('SELECT * FROM `modx_a_testlesson`  WHERE googlesent = "0" ORDER BY id ASC LIMIT 500');
	while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
      		
 
  		$reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values4[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $reg_date,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        $modx->db->query('UPDATE `modx_a_testlesson` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	
	}
    if(count($values4)> 0){
        $body4    = new Google_Service_Sheets_ValueRange( [ 'values' => $values4 ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Тестовий урок 2';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body4, $options );

        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }



	$values5 = array();
	$q = $modx->db->query('SELECT * FROM `modx_a_online` WHERE googlesent = "0" ORDER BY id ASC LIMIT 50');
	while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
      		
      	if($r['status_pay'] == '1'){
      		$status_pay = 'Сплачено';
      	}else{
      		$status_pay = 'Не сплачено';
      	}
 
  		$reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values5[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $r['promocode'],
            $r['pay_sum'],
            $status_pay,
            $reg_date,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        $modx->db->query('UPDATE `modx_a_online` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	

	}
    if(count($values5)> 0){
        $body5    = new Google_Service_Sheets_ValueRange( [ 'values' => $values5 ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Онлайн курс 2';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body5, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }


    $values6 = array();
    $q = $modx->db->query('SELECT *, w.id as id FROM `modx_a_subscribe` w LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = w.user_id WHERE w.googlesent = "0" ORDER BY w.id ASC LIMIT 300');
    while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
            
 
        $start = date('d-m-Y H:i:s',$r['start']+$modx->config['server_offset_time']);
        $next = date('d-m-Y H:i:s',$r['next']+$modx->config['server_offset_time']);
        $end = date('d-m-Y H:i:s',$r['end']+$modx->config['server_offset_time']);


        switch($r['status_pay']){
            case '0':
                $status_pay = 'Не сплачено';
            break;
            case '1':
                $status_pay = 'Оплачено';
            break;
        }


        switch($r['status']){
            case '0':
                $status = 'Не активно';
            break;
            case '1':
                $status = 'Активно';
            break;
            case '2':
                $status = 'Призупинено';
            break;
            case '3':
                $status = 'Скасовано';
            break;
            case '4':
                $status = 'Завершено';
            break;
        }





        $values6[] = array(
            $r['id'],
            $r['hash'],
            $r['email'],
            $r['phone'],
            $r['fullname'],
            $status_pay,
            $status,
            $start,
            $next,
            $end,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        $modx->db->query('UPDATE `modx_a_subscribe` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    

    }
    if(count($values6)> 0){
        $body6    = new Google_Service_Sheets_ValueRange( [ 'values' => $values6 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Підписки 2';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body6, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }











    $values7 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_master` WHERE googlesent = "0" ORDER BY id ASC LIMIT 500');
    while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        } 
 
        $reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values7[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $reg_date,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        $modx->db->query('UPDATE `modx_a_master` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    

    }
    if(count($values7)> 0){
        $body7    = new Google_Service_Sheets_ValueRange( [ 'values' => $values7 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Майстер-класи 2';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body7, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }





    $values8 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_order` WHERE order_googlesent = "0" ORDER BY order_id ASC LIMIT 50');
    while ($r = $modx->db->getRow($q)) {
        $pro = $modx->db->getRow($modx->db->query('SELECT *, op.product_price as price FROM `modx_a_order_products` op LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id WHERE op.order_id = "'.$modx->db->escape($r['order_id']).'" LIMIT 1'));
        $oui = json_decode($r['order_user_info'],true);
        $utm_p = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($v != ''){
            $utm_p .= $k.':'.$v.';
';
            }
        }
            
        if($r['order_status_pay'] == '1'){
            $status_pay = 'Сплачено';
        }else{
            $status_pay = 'Не сплачено';
        }
 
        $date = date('d-m-Y H:i:s',$r['order_created']+$modx->config['server_offset_time']);


        $values8[] = array(
            $r['order_id'],
            $oui['fullname'],
            $oui['phone'],
            $oui['email'],
            $oui['city'],
            $date,
            $pro['product_name'],
            $pro['product_count'],
            $pro['price'],
            $r['order_client'],
            $status_pay,
            $utm_p
            );
        $modx->db->query('UPDATE `modx_a_order` SET order_googlesent = "1" WHERE order_id = "'.$modx->db->escape($r['order_id']).'" LIMIT 1');
    

    }
    if(count($values8)> 0){
        $body8    = new Google_Service_Sheets_ValueRange( [ 'values' => $values8 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Замовлення';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body8, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }


    $values9 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_city_form` WHERE googlesent = "0" ORDER BY id ASC LIMIT 50');
    while ($r = $modx->db->getRow($q)) {

        $utm_p = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($v != ''){
            $utm_p .= $k.':'.$v.';
';
            }
        }
            
 
        $reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values9[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $reg_date,
            $utm_p
            );
        $modx->db->query('UPDATE `modx_a_city_form` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    

    }
    if(count($values9)> 0){
        $body9    = new Google_Service_Sheets_ValueRange( [ 'values' => $values9 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Заявки міста';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body9, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }



    $values5 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_video` WHERE googlesent = "0" ORDER BY id ASC LIMIT 50');
    while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
            
        if($r['status_pay'] == '1'){
            $status_pay = 'Сплачено';
        }else{
            $status_pay = 'Не сплачено';
        }
 
        $reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values5[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $r['promocode'],
            $r['pay_sum'],
            $status_pay,
            $reg_date,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        $modx->db->query('UPDATE `modx_a_video` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    

    }
    if(count($values5)> 0){
        $body5    = new Google_Service_Sheets_ValueRange( [ 'values' => $values5 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Смарт курс';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body5, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }



    $values10 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_call_instructor`  WHERE googlesent = "0" ORDER BY id ASC LIMIT 500');
    while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
            
 
        $reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values10[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['city'],
            $reg_date,
            $r['user_id'],
            $r['instructor_id'],
            $r['instructor_name'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term
            );
        $modx->db->query('UPDATE `modx_a_call_instructor` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    
    }
    if(count($values10)> 0){
        $body10    = new Google_Service_Sheets_ValueRange( [ 'values' => $values10 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Запит на практичні';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body10, $options );

        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }





    $values11 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_online_landing` WHERE googlesent = "0" ORDER BY id ASC LIMIT 50');
    while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
            
        if($r['status_pay'] == '1'){
            $status_pay = 'Сплачено';
        }else{
            $status_pay = 'Не сплачено';
        }
        if($r['landing'] == '1'){
            $landing = 'fastlearning';
        }else{
            $landing = 'easylearning';
        }
 
        $reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values11[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $r['promocode'],
            $r['pay_sum'],
            $status_pay,
            $reg_date,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term,
            $landing
            );
        $modx->db->query('UPDATE `modx_a_online_landing` SET googlesent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    

    }
    if(count($values11)> 0){
        $body11    = new Google_Service_Sheets_ValueRange( [ 'values' => $values11 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Онлайн курс лендінг';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body11, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }












    $spreadsheetId = '1-r4YxQCTg9u7CbAz1JM0EGin4kLC1t0lqPTmlFnaLKQ';

    $response = $service->spreadsheets->get($spreadsheetId);
    $spreadsheetProperties = $response->getProperties();

    

    $values12 = array();
    $q = $modx->db->query('SELECT * FROM `modx_a_online_landing` WHERE googlesent = "1" ORDER BY id ASC LIMIT 50');
    while ($r = $modx->db->getRow($q)) {

        $utm_source = '';
        $utm_medium = '';
        $utm_campaign = '';
        $utm_content = '';
        $utm_term = '';
        $utm = json_decode($r['utm'],true);
        foreach($utm as $k => $v){
            if($k == 'utm_source'){
                $utm_source = $v;
            }
            if($k == 'utm_medium'){
                $utm_medium = $v;
            }
            if($k == 'utm_campaign'){
                $utm_campaign = $v;
            }
            if($k == 'utm_content'){
                $utm_content = $v;
            }
            if($k == 'utm_term'){
                $utm_term = $v;
            }
        }
            
        if($r['status_pay'] == '1'){
            $status_pay = 'Сплачено';
        }else{
            $status_pay = 'Не сплачено';
        }
        if($r['landing'] == '1'){
            $landing = 'fastlearning';
        }else{
            $landing = 'easylearning';
        }
 
        $reg_date = date('d-m-Y H:i:s',$r['reg_date']+$modx->config['server_offset_time']);


        $values12[] = array(
            $r['id'],
            $r['fullname'],
            $r['phone'],
            $r['email'],
            $r['city'],
            $r['promocode'],
            $r['pay_sum'],
            $status_pay,
            $reg_date,
            $r['user_id'],
            $utm_source,
            $utm_medium,
            $utm_campaign,
            $utm_content,
            $utm_term,
            $landing
            );
        $modx->db->query('UPDATE `modx_a_online_landing` SET googlesent = "2" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    

    }
    if(count($values12)> 0){
        $body12    = new Google_Service_Sheets_ValueRange( [ 'values' => $values12 ] );

        $options = array( 'valueInputOption' => 'RAW' );
        $table_list = 'Онлайн курс лендінг';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body12, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }





?>
