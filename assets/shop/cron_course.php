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


//Скасування онлайн курсу


$t = time();
$f = strtotime('-'.$modx->config['fastcourse_days'].' day', $t);

$q = $modx->db->query('SELECT * FROM `modx_a_online_landing` WHERE reg_date < "'.$modx->db->escape($f).'" AND status = "1" AND status_pay = "1" ');
while($r = $modx->db->getRow($q)){

  if($r['email'] != ''){
    $modx->db->query('UPDATE `modx_a_online_landing` SET status = "0" WHERE id  = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    $modx->db->query('UPDATE `modx_web_user_attributes` SET online_course = "0"  WHERE email = "'.$modx->db->escape($r['email']).'" LIMIT 1');
  }
}


$t = time();
$f = strtotime('-'.$modx->config['course_month'].' month', $t);

$q = $modx->db->query('SELECT * FROM `modx_a_online` WHERE reg_date < "'.$modx->db->escape($f).'" AND status = "1" AND status_pay = "1" ');
while($r = $modx->db->getRow($q)){

  if($r['email'] != ''){
    $modx->db->query('UPDATE `modx_a_online` SET status = "0" WHERE id  = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    $modx->db->query('UPDATE `modx_web_user_attributes` SET online_course = "0"  WHERE email = "'.$modx->db->escape($r['email']).'" LIMIT 1');
  }
}
