<?php
$dom = 'https://pdr-online.com.ua';
echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
$pages = $modx->db->query("select * from `modx_site_content` where searchable = 1 and published = 1 and deleted = 0");
$modx->config['lang'] = 'ua';
while ($p = $modx->db->getRow($pages)){
        if ($p['id'] == '1') {
	    echo '<url><loc>'.$dom.'</loc></url>'."\n";        
	} else {
            echo '<url><loc>'.$dom.$modx->makeUrl($p['id']).'</loc></url>'."\n";
	}
}
// INSERT & amp; before number
$id = 96;
$pages = $modx->db->query("select * from `new_pdr_chapter` where 1 = 1 order by id asc");
while ($p = $modx->db->getRow($pages)){
        echo '<url><loc>'.$dom.$modx->makeUrl($id).'?chapter='.$p['chapter'].'</loc></url>'."\n";
        $pages2 = $modx->db->query("select * from `new_pdr_chapter_item` where chapter = '".$modx->db->escape($p['chapter'])."' order by id asc");
        while ($p2 = $modx->db->getRow($pages2)){
              echo '<url><loc>'.$dom.$modx->makeUrl($id).'?chapter='.$p2['chapter'].'&amp;number='.$p2['number'].'</loc></url>'."\n";
        }
}

//road sign 67
$id = 67;
$pages = $modx->db->query("select * from `new_pdr_road_sign` where 1 = 1 order by id asc");
while ($p = $modx->db->getRow($pages)){
        echo '<url><loc>'.$dom.$modx->makeUrl($id).'?signs='.$p['id'].'</loc></url>'."\n";
	$pages2 = $modx->db->query("select * from `new_pdr_road_sign_item` where type = '".$modx->db->escape($p['id'])."' order by id asc");
        while ($p2 = $modx->db->getRow($pages2)){
              echo '<url><loc>'.$dom.$modx->makeUrl($id).'?sign='.$p2['number'].'</loc></url>'."\n";
        }
}

//road marking 68
$id = 68;
$pages = $modx->db->query("select * from `new_pdr_road_marking` where 1 = 1 order by id asc");
while ($p = $modx->db->getRow($pages)){
        echo '<url><loc>'.$dom.$modx->makeUrl($id).'?markings='.$p['id'].'</loc></url>'."\n";
	$pages2 = $modx->db->query("select * from `new_pdr_road_marking_item` where type = '".$modx->db->escape($p['id'])."' order by id asc");
        while ($p2 = $modx->db->getRow($pages2)){
              echo '<url><loc>'.$dom.$modx->makeUrl($id).'?marking='.$p2['number'].'</loc></url>'."\n";
        }
}

//instructors 89
$id = 89;
$pages = $modx->db->query("select * from `modx_a_instructors` where status = 1 order by id asc");
while ($p = $modx->db->getRow($pages)){
      echo '<url><loc>'.$dom.$modx->makeUrl($id).$p['instructor_url'].'/'.'</loc></url>'."\n";
}

//seo urls
$seo_url = $modx->db->query('SELECT * FROM `modx_a_seo2url`  ');
while ($su = $modx->db->getRow($seo_url)){
        echo '<url><loc>'.$dom.$su['seo_url'].'</loc></url>'."\n";   
}

echo '</urlset>';