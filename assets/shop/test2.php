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



/*
function getInstructorsData() {
    try {
        const response = await fetch(https://pdr-online.com.ua/assets/shop/plugin.api.php, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                apikey: 'gf65fa8773cfee03si8kd453',
                get: 'instructors',
            }),
        });

        const data = await response.json();
        console.log('Інструктори:', data);
        return data;
    } catch (error) {
        console.error('Помилка при отриманні інструкторів:', error);
    }
}

die;
*/


$url = 'https://pdr-online.com.ua/assets/shop/plugin.api.php'; 
$token = 'gf65fa8773cfee03si8kd453';
$postData = [
    'get' => 'instructors',
    'city' => 'Київ',
    'district' => 'Осокорки',
    'type' => 'b',
    'transmission' => 'manual',
    'limit' => '3',
    'page' => '1'
];
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $token",
    "Content-Type: application/json"
]);
$response = curl_exec($ch);
if(curl_errno($ch)) {
    echo 'Помилка: ' . curl_error($ch);
} else {
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if ($httpCode == 200) {
        $data = json_decode($response, true);
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    } else {
        echo "HTTP $httpCode: $response";
    }
}
curl_close($ch);
