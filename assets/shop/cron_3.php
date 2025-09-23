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



$algoritm = MODX_BASE_PATH . "assets/modules/seo/sitemap.php";
if (file_exists($algoritm)) {
    ob_start();
    include $algoritm;
    $xml = ob_get_contents();
    ob_end_clean();
    file_put_contents(MODX_BASE_PATH . "/sitemap.xml", $xml);
}


$q = $modx->db->query('SELECT *, sc.id as id FROM `modx_site_content` sc LEFT JOIN `modx_site_tmplvar_contentvalues` stc ON stc.tmplvarid = "56" AND stc.contentid = sc.id WHERE sc.parent = "123" AND sc.published = "1" AND stc.value IS NULL');

while ($r = $modx->db->getRow($q)) {
	$cn = rand(5,20);
	$modx->db->query('UPDATE `modx_site_tmplvar_contentvalues` SET value = value + '.$modx->db->escape($cn).' WHERE tmplvarid = "57" AND contentid = "'.$modx->db->escape($r['id']).'"  ');
}



$q = $modx->db->query('UPDATE `modx_a_instructors` SET rating = "0.0", rating_reviews = "0" ');
$q = $modx->db->query('SELECT COUNT(recall_id) as rating_reviews, SUM(recall_mark) as rating, recall_content
FROM `modx_a_recall`
WHERE recall_type = "1"
GROUP BY (recall_content) 
');

while ($r = $modx->db->getRow($q)) {
	if($r['rating_reviews'] != '0'){
		$rating = str_replace(',','.',round($r['rating']/$r['rating_reviews'],1));
	}else{
		$rating = '0';
	}
	$modx->db->query('UPDATE `modx_a_instructors` SET rating = "'.$modx->db->escape($rating).'",	rating_reviews = "'.$modx->db->escape($r['rating_reviews']).'" WHERE id = "'.$modx->db->escape($r['recall_content']).'" LIMIT 1');

}


$q = $modx->db->query('UPDATE `modx_a_products` SET product_rating = "0.0", product_rating_reviews = "0" ');
$q = $modx->db->query('SELECT COUNT(recall_id) as rating_reviews, SUM(recall_mark) as rating, recall_content
FROM `modx_a_recall`
WHERE recall_type = "2"
GROUP BY (recall_content) 
');

while ($r = $modx->db->getRow($q)) {
	if($r['rating_reviews'] != '0'){
		$rating = str_replace(',','.',round($r['rating']/$r['rating_reviews'],1));
	}else{
		$rating = '0';
	}
	$modx->db->query('UPDATE `modx_a_products` SET product_rating = "'.$modx->db->escape($rating).'",	product_rating_reviews = "'.$modx->db->escape($r['rating_reviews']).'" WHERE id = "'.$modx->db->escape($r['recall_content']).'" LIMIT 1');

}

echo "ok";
?>



