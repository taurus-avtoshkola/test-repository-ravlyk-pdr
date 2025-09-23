<?php
die;
// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

$q = $modx->db->query('SELECT * FROM `modx_a_chat_history` WHERE question_id != "0"');

while ($r = $modx->db->getRow($q)) {

$r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_chat_history` WHERE chat_id = "'.$modx->db->escape($r['chat_id']).'" AND date > "'.$modx->db->escape($r['date']).'"  ORDER BY `date` LIMIT 1 '));

	$modx->db->query('INSERT IGNORE INTO `new_question_2_helper` SET question_id = "'.$modx->db->escape($r['question_id']).'", answer = "'.$modx->db->escape($r2['message']).'" ');
}
?>

