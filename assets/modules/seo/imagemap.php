<?php
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

//signs
$pages = $modx->db->query("SELECT * FROM `new_pdr_road_sign_item`  ");
$modx->config['lang'] = 'ua';
$site_url_b = substr($modx->config['site_url'], 0, -1);
while ($p = $modx->db->getRow($pages)){
	echo '<url>
<loc>'.$site_url_b.$modx->makeUrl(67).'?sign='.$p['number'].'</loc>
<image:image>
<image:loc>'.$site_url_b .$p['image_new'].'</image:loc>
</image:image>
</url>'."\n";
}
//markings
$pages = $modx->db->query("SELECT * FROM `new_pdr_road_marking_item`  ");
$modx->config['lang'] = 'ua';
$site_url_b = substr($modx->config['site_url'], 0, -1);
while ($p = $modx->db->getRow($pages)){
	echo '<url>
<loc>'.$site_url_b.$modx->makeUrl(68).'?marking='.$p['number'].'</loc>
<image:image>
<image:loc>'.$site_url_b .$p['image_new'].'</image:loc>
</image:image>
</url>'."\n";
}


echo '</urlset>';








