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


$q = $modx->db->query('SELECT * FROM `road_sign_item` WHERE parsed = "1" ');

$folder = MODX_BASE_PATH.'assets/images/new/';
echo '<table>';
while ($r = $modx->db->getRow($q)) {
	




		echo '<tr><td>'.$r['number'].'</td><td><img src="/assets/images'.$r['image_new'].'"/></td></tr>';
/*

    $res = copy($r['image'], $newfile);

    if($res){
		$modx->db->query('UPDATE `road_sign_item` SET image_new = "'.$modx->db->escape('/new/'.$file_name).'", parsed = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	}else{
		echo $r['number'].'</br>';
	}
	*/
}
echo "</table>";
?>

