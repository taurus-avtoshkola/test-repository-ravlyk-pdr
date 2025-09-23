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
	$q = $modx->db->query('SELECT * FROM `new_question_theme` WHERE 1 = 1 ORDER BY id ASC ');

	while ($r = $modx->db->getRow($q)) {
		echo '<h2 style="text-align:center;text-transform:uppercase;">'.$r['number'].' '.$r['name'].'</h2>';
		$q2 = $modx->db->query('SELECT * FROM `new_question_2_theme` q2t LEFT JOIN `new_question` q ON q2t.question_id = q.id WHERE q2t.theme_id = "'.$modx->db->escape($r['id']).'" ORDER BY q2t.position ASC ');
		while ($r2 = $modx->db->getRow($q2)) {
				
			echo '<p style="text-align:left;"><b>'.$r2['number'].'. '.$r2['question'].'</b><p>';
			$answers = json_decode($r2['answers'],true);
			foreach($answers as $k => $v){
				echo '<p style="text-align:left;">'.($k+1).') '.$v['description'].'<p>';
			}
			echo '<p>&nbsp;</p>';

		}
	}
}
?>

