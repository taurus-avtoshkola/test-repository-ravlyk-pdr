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


//step 1
/*
$row_id = 1;
$q = $modx->db->query('SELECT *, sum(lesson_total) as lesson_total_s, sum(lesson_balance) as lesson_balance_s FROM `modx_a_instructor_to_user` WHERE 1 = 1 GROUP BY user_phone ORDER BY row_id ASC');
while($r = $modx->db->getRow($q)){
  $modx->db->query('INSERT INTO `modx_a_instructor_to_user_g` SET 
    row_id = "'.$modx->db->escape($row_id).'",
    user_phone = "'.$modx->db->escape($r['user_phone']).'",
    user_name = "'.$modx->db->escape($r['user_name']).'",
    user_id = "'.$modx->db->escape($r['user_id']).'",
    instructor_id = "'.$modx->db->escape($r['instructor_id']).'",
    instructor_name = "'.$modx->db->escape($r['instructor_name']).'",
    lesson_total = "'.$modx->db->escape($r['lesson_total_s']).'",
    lesson_balance = "'.$modx->db->escape($r['lesson_balance_s']).'",
    type = "'.$modx->db->escape($r['type']).'",
    order_school = "'.$modx->db->escape($r['order_school']).'"
  ');
  $row_id++;
}
die;
*/
//step 2
/*
$q = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user_g` itug LEFT JOIN `modx_web_user_attributes` wua ON wua.cabinet_syncname = itug.instructor_name WHERE 1 = 1');
while($r = $modx->db->getRow($q)){

  $modx->db->query('UPDATE `modx_a_instructor_to_user_g` SET 
    instructor_id = "'.$modx->db->escape($r['internalKey']).'"
    WHERE 
    row_id = "'.$modx->db->escape($r['row_id']).'"
  ');
}
die;
*/
//step 3
/*
$q = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user_g`');
while($r = $modx->db->getRow($q)){
    $username =  preg_replace('/[0-9\/_]/', '', $r['user_name']);

  $modx->db->query('UPDATE `modx_a_instructor_to_user_g` SET 
    user_name = "'.$modx->db->escape($username).'"
    WHERE 
    row_id = "'.$modx->db->escape($r['row_id']).'"
  ');
}
die;
*/

/*
$q = $modx->db->query('SELECT *, ituw.id as id FROM `modx_a_instructor_to_user_web` ituw LEFT JOIN `modx_a_instructors` i ON i.id = ituw.instructor_id WHERE 1 = 1 AND ituw.instructor_id != 0 AND ituw.id < 6149 ');
while($r = $modx->db->getRow($q)){
    if($r['user_id'] != ''){
      $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET 
        instructor_id = "'.$modx->db->escape($r['user_id']).'"
        WHERE 
        id = "'.$modx->db->escape($r['id']).'"
        LIMIT 1
      ');
    }
}
*/

die;

$q = $modx->db->query('SELECT * FROM `new_question` WHERE 1 = 1');
while($r = $modx->db->getRow($q)){
   
    if($r['video'] != ''){
        $modx->db->query('UPDATE `new_question` SET video = "'.$modx->db->escape('<div style="padding:'.$r['video']).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1 ');
    
    }
}

echo 'ok';

die;



unset($_SESSION['chat_id']);
//https://pdr-online.com.ua/assets/images/pdr/base/0176452001707175449.jpg
$img = 'https://pdr-online.com.ua/assets/images/pdr/base/0110093001707175449.jpg';

$question = 'Згенеруй зображення таке саме як це зображення яке вкладено до повідомлення, на згернерованому фото мають бути всі об`єкти що і зараз, просто треба його унікалізувати';

$question = 'Як розшифрувати знак "Цегла"';
require_once MODX_BASE_PATH . "assets/shop/php/gpt_n.php";
$key = 'sk-proj-Ufc1jaONiChPazJx9xU8s_o2hDY_E1pTVyCQRkrkaQcp4mSkTeuFgn7oS921uG3xT551DbAm_7T3BlbkFJ7hca2kmKELqOAcMq4GTT8GpwmTbrrQlIq9phAh7VY4LJHCMlA_sZVDCl5svovowwAaaxQPJIkNMA';
$gpt = new Gpt();


// sk-proj-Ufc1jaONiChPazJx9xU8s_o2hDY_E1pTVyCQRkrkaQcp4mSkTeuFgn7oS921uG3xT551DbAm_7T3BlbkFJ7hca2kmKELqOAcMq4GTT8GpwmTbrrQlIq9phAh7VY4LJHCMlA_sZVDCl5svovowwAaaxQPJIkNMA

if(!isset($_SESSION['chat_id'])){
    $chat_id = $gpt->threadCreate();
    $_SESSION['chat_id'] = $chat_id;
}else{
    $chat_id = $_SESSION['chat_id'];  
}
  
$message_id = $gpt->threadMessage($chat_id,$question);



$runId = $gpt->threadRun($chat_id);
$gpt->waitTillRunComplete($chat_id, $runId);

$answer = $gpt->threadMessages($chat_id);

var_dump($answer);die;





/*
require ROOT.'/index.php';
require_once ROOT.'/core/vendor/autoload.php';
*/

/*
тут скрипт поиска и замени исправлений в таблице


$spreadsheetId = '11jOTYmRZj6CRDRCfkg9eGMbc-TUUhyRgVn0EJuGUlYw';



$googleAccountKeyFilePath = MODX_BASE_PATH . 'assets/shop/php/pdr-online-f49641863b8a.json';
putenv( 'GOOGLE_APPLICATION_CREDENTIALS=' . $googleAccountKeyFilePath );
$client = new Google_Client();

$client->useApplicationDefaultCredentials();
$client->addScope( 'https://www.googleapis.com/auth/spreadsheets' );

$service = new Google_Service_Sheets( $client );
$response = $service->spreadsheets->get($spreadsheetId);
$spreadsheetProperties = $response->getProperties();


//    $service = new Sheets($client);
    $kk = 26113;
    $end = 26173;
    // Получение данных из таблицыSheet2!A1:C4
    $table_list = 'Отчеты инструкторов';// (ПДР)
    $range =  $table_list.'!A'.$kk.':F'.$end; // диапазон для колонки A
    $response = $service->spreadsheets_values->get($spreadsheetId,$range);
    $values = $response->getValues();
    
    foreach ($values as $k => $v) {
        

        $q = $modx->db->query('
        SELECT *, isc.type as type FROM `modx_a_instructor_schedule` isc 
        LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id
        LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = isc.user_id 
        WHERE (str.status = 2 OR str.status = 3) AND isc.full = "'.$modx->db->escape(date('Y-m-d H',strtotime($v[0])).':00:00').'" AND wua.cabinet_syncname = "'.$modx->db->escape($v[1]).'" AND str.client = "'.$modx->db->escape($v[2]).'" 
        LIMIT 1
            ');

        if($modx->db->getRecordCount($q) == 0){
            //echo '----';
        }else{
            $r = $modx->db->getRow($q);

            switch($r['type']){
                default:
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
            if($v['3'] == $type){
                //echo '----';
            }else{
                echo 'found '.$kk.':'.$type.' from:'.$v['3'].'</br>';
               
                $range = $table_list.'!D'.$kk; // Укажите нужный лист и ячейку
                $values = array(array($type));
                $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );
                $options = array( 'valueInputOption' => 'RAW' );
                $result = $service->spreadsheets_values->update($spreadsheetId, $range, $body, $options);
                
            }
            



        }

        $kk++;
    }




die;  
*/



/*
$q = $modx->db->query('SELECT * FROM `modx_a_products` ');
while($r = $modx->db->getRow($q)){
	$url = $shop->generateUrl($r['product_name']);
	$modx->db->query('UPDATE `modx_a_products` SET product_url = "'.$modx->db->escape($url).'" WHERE product_id = "'.$modx->db->escape($r['product_id']).'" ');


        $modx->db->query('INSERT INTO `modx_a_virtual` SET 
          type = "2",
          idv = "'.$modx->db->escape($r['product_id']).'",
          url = "'.$modx->db->escape($url).'"
          ');


}
die;
*/
/*







$site_url_b= substr($modx->config['site_url'], 0, -1);

function toWindow($ii){
    //return iconv( "utf-8", "windows-1251",$ii);
    return $ii;
}

$fp = fopen( MODX_BASE_PATH . '/assets/shop/pdr/questionslist.csv', 'w' );
    fputcsv($fp, array('sep=,'));


$titles = array('id', 'question', 'image','image_official','comment','theme_number','theme_name','correct', 'answer 1', 'answer 2', 'answer 3', 'answer 4', 'answer 5', 'answer 6');
foreach ($titles as $key => $value) {
	$titlesW[] = toWindow($value);
}
fputcsv($fp, $titlesW);

$q = $modx->db->query('SELECT *, q.id as id, qt.number as theme_number, qt.name as theme_name FROM `new_question` q 
LEFT JOIN `new_question_2_theme` q2t ON q2t.question_id = q.id
LEFT JOIN `new_question_theme` qt ON qt.id = q2t.theme_id
');




while($r = $modx->db->getRow($q)){

$ansrs = array();
$answers = json_decode($r['answers'],true);
foreach($answers as $k => $answer){
	$ans = ($k+1).'. '.$answer['description'];
	$ansrs[] = toWindow($ans);
	if($k == $r['correct']){
		$correct = toWindow($ans);
	}
}

if($r['image_new_2'] != ''){
	$img = $site_url_b.$r['image_new_2'];
}else{
	$img = '';
}
if($r['image_official'] != ''){
	$img_official = $site_url_b.$r['image_official'];
}else{
	$img_official = '';
}
	$array = array(
            toWindow($r['id']),
            toWindow($r['question']),
            toWindow($img),
            toWindow($img_official),
            toWindow($r['comment']),
            toWindow($r['theme_number']),
            toWindow($r['theme_name']),
            $correct,
          );
$arr = array_merge($array,$ansrs);

          fputcsv($fp, $arr);
    $cnt++;

	

}
fclose($fp);

echo "ok";
*/