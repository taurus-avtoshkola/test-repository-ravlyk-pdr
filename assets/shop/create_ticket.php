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



for($num = 83; $num < 84; $num++){



	unset($questions);
	$hash = md5(uniqid());

	$name = 'Білет №'.$num;

	$modx->db->query('INSERT INTO `new_question_ticket` SET position = "'.$modx->db->escape($num).'", number = "'.$modx->db->escape($num).'",	name = "'.$modx->db->escape($name).'", hash = "'.$modx->db->escape($hash).'" ');
	$questions = array();

	$q = $modx->db->query('SELECT * FROM `new_theme_2_test` WHERE category = "b" ');
	while($r = $modx->db->getRow($q)){
		$q2 = $modx->db->query('SELECT * FROM `new_question_2_theme` q2t 
		  LEFT JOIN `new_question` q ON q.id = q2t.question_id
		  WHERE q2t.theme_id IN ('.$modx->db->escape($r['themes']).')
		  ORDER BY rand() LIMIT '.$modx->db->escape($r['questions_count']).' ');
		while($r2 = $modx->db->getRow($q2)){
		  $questions[] = $r2['question_id'];
		}
	}
	shuffle($questions);
	$cnt = 1;
	foreach($questions as $question){
		$modx->db->query('INSERT INTO `new_question_2_ticket` SET 
			question_id	= "'.$modx->db->escape($question).'",
			ticket_id = "'.$modx->db->escape($num).'",
			position = "'.$modx->db->escape($cnt).'"
		');
		$cnt++;
	}


}


die;