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

$shop->priceListFacebookCSV();
$shop->priceListFacebook();
/*
$q = $modx->db->query('SELECT * FROM `road_sign_item` WHERE parsed = "0" ');

$folder = MODX_BASE_PATH.'assets/images/new/';
echo '<table>';
while ($r = $modx->db->getRow($q)) {
	


    $exp = explode("/", $r['image']);
    $file_name = end($exp);
    $newfile = $folder.$file_name;


		echo '<tr><td>'.$r['number'].'</td><td><a href="'.$r['image'].'" target="_blank">'.$r['image'].'</a></td></tr>';

}
echo "</table>";

*/
?>

