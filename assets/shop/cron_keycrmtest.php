<?php
// die;
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(__FILE__))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

include MODX_BASE_PATH . "assets/shop/php/keycrm.php";
$keycrm = new Keycrm($modx->config['key_crm_api']);


$q = $modx->db->query('SELECT * FROM `modx_a_new_certificate` WHERE keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {
    // var_dump($r);

// die;
$title = 'Заявка на придбання сертифікату на навчання';


$data = [
	"title" => $title,
	"source_id" => $modx->config['source_key_crm'],
	"pipeline_id" => $modx->config['pipeline_key_crm'],
	"contact" => [
		"full_name" => $r['fullname'],
		"email" => $r['email'],
		"phone" => $r['phone']
	],
	"manager_comment" => $utm['ref'],
	"utm_source" => $utm['utm_source'],
	"utm_medium" => $utm['utm_medium'],
	"utm_campaign" => $utm['utm_campaign'],
	"utm_term" => $utm['utm_term'],
	"utm_content" => $utm['utm_content'],
	"products"=> [
		[
			"price"=> $modx->config['price_base'],
			"quantity"=> 1,
			"name"=> $title,
			"picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		]
	],
	"custom_fields" => [
		[
			"uuid" => "LD_1001",
			"value" => $r['city']
		]
	]
];
$res = $keycrm->go('pipelines/cards',$data);

// Оновити keycrmsent на 1 для поточного запису
 $modx->db->query('UPDATE `modx_a_new_certificate` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
}

//відправка запису на Теоретичний курс з лектором

$q = $modx->db->query('SELECT * FROM `modx_a_lector_package` WHERE keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {
    // var_dump($r);

// die;
$title = 'Заявка на придбання курсу Теорія з лектором';


$data = [
	"title" => $title,
	"source_id" => $modx->config['source_key_crm'],
	"pipeline_id" => $modx->config['pipeline_key_crm'],
	"contact" => [
		"full_name" => $r['fullname'],
		"email" => $r['email'],
		"phone" => $r['phone']
	],
	"manager_comment" => $utm['ref'],
	"utm_source" => $utm['utm_source'],
	"utm_medium" => $utm['utm_medium'],
	"utm_campaign" => $utm['utm_campaign'],
	"utm_term" => $utm['utm_term'],
	"utm_content" => $utm['utm_content'],
	"products"=> [
		[
			"price"=> $modx->config['price_base_lector'],
			"quantity"=> 1,
			"name"=> $title,
			"picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		]
	],
	"custom_fields" => [
		[
			"uuid" => "LD_1001",
			"value" => $r['city']
		]
	]
];
$res = $keycrm->go('pipelines/cards',$data);

// Оновити keycrmsent на 1 для поточного запису
 $modx->db->query('UPDATE `modx_a_lector_package` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
}

?>