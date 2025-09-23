<?php
// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(dirname(__FILE__)))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

$input = json_decode(file_get_contents("php://input"), true);

//$modx->db->query('INSERT INTO `modx_a_test` SET test_text = "'.$modx->db->escape(json_encode($input)).'" ');

function formatPhoneNumber($number) {
    // Удаление всех символов, кроме цифр
    $number = preg_replace('/\D/', '', $number);
    
    // Проверка длины номера
    if (strlen($number) != 12) {
        return "";
    }
    $countryCode = substr($number, 0, 2);
    $operatorCode = substr($number, 2, 3);
    $phoneNumber = substr($number, 5);
    $formattedNumber = "+$countryCode ($operatorCode) " . substr($phoneNumber, 0, 3) . "-" . substr($phoneNumber, 3, 2) . "-" . substr($phoneNumber, 5, 2);
    
    return $formattedNumber;
}
$formattedPhoneNumber = formatPhoneNumber($input['phone']);
if ($input["phone"] == NULL OR $input["phone"] == '') {
    $state = false;
    $result["payment"] = false;
    $result["error"]["message"][] = "'phone' is missing";
}
if ($state === false) {
    echo json_encode($result);
    exit;
}else{
    $q = $modx->db->query('SELECT * FROM `modx_a_video` WHERE phone = "'.$modx->db->escape($formattedPhoneNumber).'" ORDER BY status_pay DESC LIMIT 1');

    if($modx->db->getRecordCount($q) > 0){
        $r = $modx->db->getRow($q);
        if($r['status_pay'] == '1'){
            $result["payment"] = true;
        }else{
            $result["payment"] = false;
            $result["error"]["message"][] = "'user' not payd";
        }
    }else{
        $result["payment"] = false;
        $result["error"]["message"][] = "'user' not found";
    }
    echo json_encode($result);
}






