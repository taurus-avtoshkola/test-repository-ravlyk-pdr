<?php

// Подключаем
define('MODX_API_MODE', true);
require $_SERVER['DOCUMENT_ROOT'].'/index.php';




include MODX_BASE_PATH . "assets/shop/telegram.class.php";
$telegram = new Telegram($modx);



$r = $telegram->set_webhook('https://pdr-online.com.ua/assets/shop/telegram.php');
var_dump($r);die;


/*
//remove_webhook
$r = $viber->remove_webhook();
var_dump($r);die;

*/




?>