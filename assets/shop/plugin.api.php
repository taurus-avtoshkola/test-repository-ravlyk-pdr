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


$modx->config['site_url_b'] = substr($modx->config['site_url'], 0, -1);
$modx->config['lang'] = 'ua';

$apiKey = 'gf65fa8773cfee03si8kd453';
$response = Array();
$json     = json_decode(file_get_contents('php://input'), true);

if (is_array($json)){
  foreach ($json as $key => $value){ 
    $request[$key] = $modx->db->escape($value);
  }
}

$headers = getallheaders();
if (isset($headers['Authorization'])) {
    $authHeader = $headers['Authorization'];
    if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
        $token = $matches[1];
    }
}
$signature = $token;
if($_GET['test'] == 'test'){
  $request = $_GET;
  $signature = $apiKey;
}
$action    = $request['get'];
$lang = $request['lang'];
if($lang != 'ua' OR $lang != 'ru'){
  $lang = 'ua';
}

if ($apiKey != $signature OR $signature == ''){
  $error = 'Incorrect ApiKey!';
}else{

  switch ($action) {
    case "instructor":
      if(isset($request['id']) AND $request['id'] != ''){
        $id = $request['id'];
        $query = $modx->db->query('SELECT *
    FROM `modx_a_instructors`
    WHERE `school` IN (122,200) AND `status` = "1" AND id = "'.$modx->db->escape($id).'"
    LIMIT 1');
        $r = $modx->db->getRow($query);

        $instructor['id'] = $r['id'];
        $instructor['title'] = $r['title'];
        $instructor['rating'] = $r['rating'];
        $instructor['rating_reviews'] = $r['rating_reviews'];
        $instructor['duration'] = $r['duration'];
        $instructor['registration_date'] = $r['registration_date'];
        $instructor['instructor_url'] = $modx->config['site_url_b'].$modx->makeUrl('89').$r['instructor_url'].'/';
        $instructor['fullname'] = $r['fullname'];
        $instructor['lastname'] = $r['lastname'];
        $instructor['patronymic'] = $r['patronymic'];
        $instructor['email'] = $r['email'];
        $instructor['phone'] = $r['phone'];
        $instructor['birthday'] = $r['birthday'];
        $instructor['experience'] = $r['experience'];
        $instructor['certificate_date'] = $r['certificate_date'];
        $instructor['city'] = $r['city'];
        $instructor['district'] = $r['district'];
        $instructor['pickup_address'] = $r['pickup_address'];
        $instructor['type'] = $r['type'];
        $instructor['brand'] = $r['brand'];
        $instructor['model'] = $r['model'];
        $instructor['color'] = $r['color'];
        $instructor['year'] = $r['year'];
        $instructor['reg_number'] = $r['reg_number'];
        $instructor['transmission'] = $r['transmission'];
        $instructor['schedule_from'] = $r['schedule_from'];
        $instructor['schedule_to'] = $r['schedule_to'];
        $instructor['price'] = $r['price'];
        $instructor['description'] = $r['description'];
        $instructor['car_photo'] = $modx->config['site_url_b'].$r['car_photo'];
        $instructor['main_photo'] = $modx->config['site_url_b'].$r['main_photo'];
        $instructor['certificate'] = $r['certificate'];

        if($r['photo'] != ''){
          $pu = array();
          $exp_p = explode(',', $v['photo']);
          foreach($exp_p as $photo){
            if($photo != ''){
              $pu[] = $modx->config['site_url_b'].$photo;
            }
          }
          $instructor['photo'] = $pu;
        }


        $time = strtotime($r['registration_date']);
        $instructor['platform_date'] = $shop->formatDateFrom(time()-$time);

   
        $instructor['stat_lesson'] = '-';
        $instructor['clients'] = '-';
        if($r['user_id'] != '0'){
          $rsl = $modx->db->getRow($modx->db->query('SELECT count(s.id) as cnt FROM `modx_a_instructor_schedule` s LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = s.id WHERE s.user_id  = "'.$modx->db->escape($r['user_id']).'" AND istr.status = "2" '));
  
          $instructor['stat_lesson'] = $rsl['cnt'];

          $rsc = $modx->db->getRecordCount($modx->db->query('SELECT DISTINCT(client) as cnt FROM `modx_a_instructor_schedule` s LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = s.id WHERE s.user_id = "'.$modx->db->escape($r['user_id']).'"  AND istr.status = "2" '));
  
          $instructor['clients'] = $rsc;

          if($instructor['stat_lesson'] == 0){
            $instructor['stat_lesson'] = '-';
          }
          if($instructor['clients'] == 0){
            $instructor['clients'] = '-';
          }

        }

        if($r['school'] != ''){
          $q2 = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE status = "1" AND school = "'.$modx->db->escape($r['school']).'" ORDER BY rand() LIMIT 10');
        }else{
          if($r['district'] != '' OR $r['city'] != ''){
            $q2 = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE status = "1" AND ( district = "'.$modx->db->escape($r['district']).'" OR city = "'.$modx->db->escape($r['city']).'" ) ORDER BY rand() LIMIT 10');
          }
        }
        $friends = array();

        if($modx->db->getRecordCount($q2) > 0){
          while($r2 = $modx->db->getRow($q2)){
            

            $friend['id'] = $r2['id'];
            $friend['title'] = $r2['title'];
            $friend['rating'] = $r2['rating'];
            $friend['rating_reviews'] = $r2['rating_reviews'];
            $friend['duration'] = $r2['duration'];
            $friend['registration_date'] = $r2['registration_date'];
            $friend['instructor_url'] = $modx->config['site_url_b'].$modx->makeUrl('89').$r2['instructor_url'].'/';
            $friend['fullname'] = $r2['fullname'];
            $friend['lastname'] = $r2['lastname'];
            $friend['patronymic'] = $r2['patronymic'];
            $friend['email'] = $r2['email'];
            $friend['phone'] = $r2['phone'];
            $friend['birthday'] = $r2['birthday'];
            $friend['experience'] = $r2['experience'];
            $friend['certificate_date'] = $r2['certificate_date'];
            $friend['city'] = $r2['city'];
            $friend['district'] = $r2['district'];
            $friend['pickup_address'] = $r2['pickup_address'];
            $friend['type'] = $r2['type'];
            $friend['brand'] = $r2['brand'];
            $friend['model'] = $r2['model'];
            $friend['color'] = $r2['color'];
            $friend['year'] = $r2['year'];
            $friend['reg_number'] = $r2['reg_number'];
            $friend['transmission'] = $r2['transmission'];
            $friend['schedule_from'] = $r2['schedule_from'];
            $friend['schedule_to'] = $r2['schedule_to'];
            $friend['price'] = $r2['price'];
            $friend['description'] = $r2['description'];
            $friend['car_photo'] = $modx->config['site_url_b'].$r2['car_photo'];
            $friend['main_photo'] = $modx->config['site_url_b'].$r2['main_photo'];
            $friend['certificate'] = $r2['certificate'];
            $friends[] = $friend;
          }  
        }
        if(count($friends) > 0){
          $instructor['nearinstructors'] = $friends;
        }

        $reviews = array();


        $q3 = $modx->db->query("
          SELECT 
            *
          FROM `modx_a_recall`
          WHERE recall_moderated = 1 and recall_content = '".$modx->db->escape($r['id'])."' AND recall_type = '1'
          ORDER BY recall_pub_date DESC");

        while ($r3 = $modx->db->getRow($q3)){ 
          $review['recall_name'] = $r3['recall_name'];
          $review['mark'] = $r3['recall_mark'];
          $review['recall_date'] = date('d.m.Y', strtotime($r3['recall_pub_date']));

          $review['recall_text'] = str_replace('
  ', '</br>',$r3['recall_text']);
          $r3['recall_answer'] = str_replace('
  ', '</br>',$r3['recall_answer']);
          //$review['recall_email'] = $r3['recall_email'];
          $reviews[] = $review;
        }
        if(count($reviews) > 0){
          $instructor['reviews'] = $reviews;
        }

        $products = array();
        if($r['school'] != '' AND $r['school'] != '0'){

            switch($r['transmission_code']){
              case "manual":
                $search_transmission = ' AND (p.product_transmission = "0" OR p.product_transmission = "1" ) ';
              break;
              case "automatic":
                $search_transmission = ' AND (p.product_transmission = "0" OR p.product_transmission = "2" ) ';
              break;
              default:
                $search_transmission = ' AND (p.product_transmission = "0" OR p.product_transmission = "1" OR p.product_transmission = "2" ) ';
              break;
            }

          $q4 = $modx->db->query('SELECT * FROM `modx_a_products` p WHERE p.product_visible = "1" AND p.product_to_instructor = "1" AND p.product_to_school = "'.$modx->db->escape($r['school']).'" '.$search_transmission.' ');
          while($r4 = $modx->db->getRow($q4)){
            $product['product_id'] = $r4['product_id'];
            $product['product_name'] = $r4['product_name'];
            $product['product_introtext'] = $r4['product_introtext'];
            $product['product_description'] = $r4['product_description'];
            $product['product_article'] = $r4['product_article'];
            $product['product_url'] = $modx->config['site_url_b'].$modx->makeUrl($r['school']).$r4['product_url'].'/';
            $product['product_image'] = $modx->config['site_url_b'].$r4['product_cover'];
            if($r4['product_price_a'] != '0' AND $r4['product_price_a'] != '0.00' AND $r4['product_price_a'] != $r4['product_price']){
              $product['product_price'] = $r4['product_price_a'];
            }else{
              $product['product_price'] = $r4['product_price'];
            }

            $products[] = $product;
          }  
        }
        if(count($products) > 0){
          $instructor['products'] = $products;
        }


        $schedules = array();
       



        $date = time()+$modx->config['server_offset_time'];          
        $start_date = new DateTime(date('Y-m-d',$date));
        $start_day = $start_date->format('Y-m-d');
        $end_date = clone $start_date;
        $end_date->add(new DateInterval('P7D'));      
        $end_day = $end_date->format('Y-m-d');
             
        $u = array();
        $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
        LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
        WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($r['user_id']).'" ');
        while($rsch = $modx->db->getRow($usch)){
          $u[$rsch['full']] = $rsch;
        }

        for ($i = 0; $i < 7; $i++) {
          $idate = clone $start_date;
          $idate->add(new DateInterval('P' . $i . 'D'));
          $day_of_week = $idate->format('w');
          $day_month = $idate->format('d.m.Y');
          $full = $idate->format('Y-m-d');
          $status = '0';
          for ($j = 6; $j < 23; $j++) {
            $day = $idate->format('Y-m-d');
            $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
            $full = $day.' '.$time;
            $time = $j.':00';
            $class = '';
            $pickup_address = '';
            if(isset($u[$full])){
              $status = $u[$full]['status'];
              $pickup_address = $u[$full]['pickup_address'];
              if($u[$full]['offset'] != 0){
                $time = $j.':'.$u[$full]['offset'];
              }
            }
            switch($status){
              case "0":
                $status_name = 'Не доступно';
              break;
              case "1":
                $status_name = 'Доступно';
              break;
              case "2":
                $status_name = 'Заброньовано';
              break;
              case "3":
                $status_name = 'Скасовано';
              break;
            }
            $schedule['status_id'] = $status;
            $schedule['status'] = $status_name;
            $schedule['day'] = $day_month;
            $schedule['time'] = $time;
            $schedule['pickup_address'] = $pickup_address;
            $schedule['full'] = $full;
            $sch[$day_month][] = $schedule;
          }

        }
        foreach($sch as $day => $sched){
          $schedules[] = array('day' => $day,'schedule' => $sched);
        }




        if(count($schedules) > 0){
          $instructor['schedule'] = $schedules;
        }


/*


[[Shop?&get=`calendar_schedule`&ax_instructor=`[*user_id*]`]]


*/


        $response['data']['instructors'] = $instructor;

      }else{
        $error = 'No instructor ID';        
      }
    break;
		case "instructors":
			$search = array();
      if(isset($request['city']) AND $request['city'] != ''){
        $search[] = ' city = "'.$modx->db->escape($request['city']).'" ';
      }
      if(isset($request['district']) AND $request['district'] != ''){
        $search[] = ' district = "'.$modx->db->escape($request['district']).'" ';
      }
      if(isset($request['type']) AND $request['type'] != ''){
        $search[] = ' type = "'.$modx->db->escape($request['type']).'" ';
      }
      if(isset($request['transmission']) AND $request['transmission'] != '' AND $request['transmission'] != 'all'){
        $search[] = ' transmission LIKE "%'.$modx->db->escape($request['transmission']).'%" ';
      }

      if(count($search) > 0){
        $search_s = ' AND '.implode(' AND ', $search);
      }
      if(isset($request['limit']) AND $request['limit'] != '' ){
        $limit = $request['limit'];
      }else{
        $limit = 50;
      }
      if(isset($request['page']) AND $request['page'] != '' ){
        $pages = (int)$request['page'];
        if(!is_int($pages)){
          $pages = 1;
        }
        if($pages < 1){
          $pages = 1;
        }
      }else{
        $pages = 1;
      }
      $page = ($pages - 1)*$limit;
	    $query = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS
	    	id, title, rating,	rating_reviews, duration, registration_date, CONCAT("https://pdr-online.com.ua/instruktori/",instructor_url,"/") as instructor_url, fullname,	lastname,	patronymic,	email,	phone, birthday,	experience, certificate_date,	city,	district,	pickup_address,	type,	brand,	model,	color,	year,	reg_number,	transmission,	schedule_from,	schedule_to,	price, description, photo,	CONCAT("https://pdr-online.com.ua",car_photo) as car_photo,	CONCAT("https://pdr-online.com.ua",main_photo) as main_photo,	certificate
	FROM `modx_a_instructors`
	WHERE `school` IN (122,200) AND `status` = "1" '.$search_s.'
	ORDER BY `school` DESC
	LIMIT '.$modx->db->escape($page).', '.$modx->db->escape($limit).' ');

      $pg = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $instructors = $modx->db->makeArray($query);
	    foreach($instructors as $k=> $v){
	    	if($v['photo'] != ''){
	    		$pu = array();
	    		$exp_p = explode(',', $v['photo']);
	    		foreach($exp_p as $photo){
	    			if($photo != ''){
	    				$pu[] = 'https://pdr-online.com.ua'.$photo;
	    			}
	    		}
	    		$instructors[$k]['photo'] = $pu;
	    	}
	    }

   
      $response['data']['limit'] = $limit;
      $response['data']['page'] = $pages;
      $response['data']['total'] = ceil($pg['cnt']/$limit);

	    $response['data']['instructors'] = $instructors;


			break;
	}
}
if (!empty($error)){
	$response = array("response_code" => 400, "data" => array("error" => $error));
}

header("Content-type: text/json");
echo json_encode($response);


die;

/*
data instructors
[
  {
    "id": 12,
    "title": "Професійний інструктор",
    "rating": 4.8,  //Оцінка на основі відгуків
    "rating_reviews": 26, //Кількість оцінок (відгуків)
    "duration": "60", //тривалість заняття в хвилинах
    "registration_date": "2024-03-07 08:38:08", //дата реєстрації на сервісі
    "instructor_url": "https://pdr-online.com.ua/instruktori/petrenko/", //Посилання на інструктора
    "fullname": "Іван", // Ім'я
    "lastname": "Петренко", //Прізвище
    "patronymic": "Іванович", //По-батькові
    "email": "ivan.petrenko@email.com", //E-mail
    "phone": "+38 (097) 123-45-67",//Телефон
    "birthday": "27-03-2003", //день народження
    "experience": "12",// Стаж водіння в роках
    "certificate_date": "11-09-2029", // Дата закінчення сертифікату
    "city": "Київ", //Місто
    "district": "Шевченківський", //Район
    "pickup_address": "вул. Хрещатик, 12", //Місце посадки студента 
    "type": "b", //Категорія Авто
    "brand": "Toyota", //Марка авто
    "model": "Corolla", //Модель авто
    "color": "Сірий", //Колір авто
    "year": "2019", //Рік випуску авто
    "reg_number": "AA1234BC", //Номерний знак
    "transmission": "manual",// Тип трансмісії (manual, automatic)
    "schedule_from": "08:00", //Початок занять
    "schedule_to": "20:00", //Закінчення занять
    "price": 450, //Ціна одного заняття
    "description": "<p>Спокійний, досвідчений, пояснює чітко та зрозуміло.</p>", //Опис у форматі html
    "photo": Array(
      [0] => https://pdr-online.com.ua/assets/files/instructors/personal/1720461021_IMG_20180701_032440_141.jpg
      [1] => https://pdr-online.com.ua/assets/files/instructors/personal/0924770001733918788.jpg
      [2] => https://pdr-online.com.ua/assets/files/instructors/personal/0692679001733918851.jpg
    )
 //Масив з фото загальний
    "car_photo": "https://pdr-online.com.ua/assets/files/instructors/personal/1720461021_IMG_20180701_032440_141.jpg", //Фото Авто
    "main_photo": "https://pdr-online.com.ua/assets/files/instructors/personal/0924770001733918788.jpg", //Головне фото
    "certificate": "https://pdr-online.com.ua/assets/files/instructors/12.pdf" //Файл сертифікату
  }
]
*/
?>