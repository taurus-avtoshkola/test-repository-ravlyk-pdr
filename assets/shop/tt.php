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

if($_GET['hash'] == 'Sm9eOnD2'){
	if($_GET['id'] != ''){
		$idsearch = ' AND id = "'.$modx->db->escape($_GET['id']).'" ';
	}
	$q = $modx->db->query('SELECT * FROM `new_question_theme` WHERE 1 = 1 '.$idsearch.' ORDER BY id ASC ');

		echo '<table style="max-width:100%;width:100%;"><tr><td>фото 1</td><td>фото 2</td><td>фото наше</td></tr>';
	while ($r = $modx->db->getRow($q)) {
		echo '<tr><td colspan="3"><h2 style="text-align:left;text-transform:uppercase;">'.$r['number'].' '.$r['name'].'</h2></td></tr>';
		$q2 = $modx->db->query('SELECT * FROM `new_question_2_theme` q2t LEFT JOIN `new_question` q ON q2t.question_id = q.id WHERE q2t.theme_id = "'.$modx->db->escape($r['id']).'" AND q.image_official != "" ORDER BY q2t.position ASC ');
		while ($r2 = $modx->db->getRow($q2)) {
				
			echo '<tr><td colspan="3"><p style="text-align:left;"><b>'.$r2['number'].'. '.$r2['question'].'</b><p></td></tr>';
		
			echo '<tr><td><img src="'.$r2['image_new'].'" style="width:100%;max-width:450px;"/></td><td><img src="'.$r2['image_official'].'" style="width:100%;max-width:450px;"/></td><td><img src="'.$r2['image_new_2'].'" style="width:100%;max-width:450px;"/></td></tr>';

		}
	}
	echo "</table>";
}



