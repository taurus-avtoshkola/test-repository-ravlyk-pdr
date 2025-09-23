<?php
// Подключаем
define('MODX_API_MODE', true);
define ('ROOT', dirname(dirname(dirname(dirname(__FILE__)))));
define ('MODX_BASE_PATH', ROOT.'/');
define ('MODX_BASE_URL', '/');
define ('MODX_SITE_URL', 'https://pdr-online.com.ua/');
require ROOT.'/index.php';
include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);
$r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "123" AND deleted = "0" AND published = "1" ORDER BY menuindex DESC LIMIT 1'));

$tvres2 = $modx->getTemplateVar(
    $idname  = 'webi_time',
    $fields = '*',
    $docid =  $r['id']
    );
$webi_time = $tvres2['value'];

$tvres2 = $modx->getTemplateVar(
    $idname  = 'webi_date',
    $fields = '*',
    $docid =  $r['id']
    );
$webi_date = $tvres2['value'];

$result['time'] = $webi_date.' '.$webi_time;
echo json_encode($result);
?>