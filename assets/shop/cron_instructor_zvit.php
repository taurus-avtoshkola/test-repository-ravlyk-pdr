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

if($_GET['pass'] == 'zvit'){
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
	$q = $modx->db->query('
SELECT *, count(isc.id) as total, isc.type as type FROM `modx_a_instructor_schedule` isc 
LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id
LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = isc.user_id 
WHERE (str.status = 2 OR str.status = 3) AND isc.day = "'.$modx->db->escape($day).'"
GROUP BY str.client,isc.type,isc.user_id
ORDER BY wua.cabinet_syncname ASC, isc.time ASC

	');
	while ($r = $modx->db->getRow($q)) {
        if($r['client'] != ''){
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

            $date = $r['regdate']+$modx->config['server_offset_time'];

            if($r['offset'] != '0'){
                $datetime = new DateTime($r['full']);
                $full_date = $datetime->format('d.m.Y H').':'.$r['offset'].':00';
            }else{
                $datetime = new DateTime($r['full']);
                $full_date = $datetime->format('d.m.Y H:i:s');
            }


            $values[] = array(
                $full_date,
                $r['cabinet_syncname'],
                $r['client'],
                $type,
                $r['total'],
                ($r['cabinet_zp']*$r['total'])
                );
        }

	}
    if(count($values)> 0){
        $body    = new Google_Service_Sheets_ValueRange( [ 'values' => $values ] );

        $options = array( 'valueInputOption' => 'RAW' );
    	$table_list = 'Отчет инструкторов (ПДР)';
        $result_v = $service->spreadsheets_values->append( $spreadsheetId, $table_list, $body, $options );
        echo 'Оновлено';
    }else{
        echo 'Немає нових';
    }


}

?>
