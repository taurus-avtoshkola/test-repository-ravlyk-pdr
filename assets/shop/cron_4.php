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


$time = time()+$modx->config['server_offset_time'];

//вкл промокоди по даті
$modx->db->query('UPDATE `modx_a_promo` SET available = "1"  WHERE date_start <= "'.$modx->db->escape($time).'" AND date_end >= "'.$modx->db->escape($time).'" AND date_start != "" AND date_end  != "" AND available = "0" AND multicode = "1" ');
//викл промокоди по даті
$modx->db->query('UPDATE `modx_a_promo` SET available = "0" WHERE (date_start >= "'.$modx->db->escape($time).'" OR date_end <= "'.$modx->db->escape($time).'" ) AND date_start != "" AND date_end  != "" AND available = "1" ');
?>

