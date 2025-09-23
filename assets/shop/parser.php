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

include MODX_BASE_PATH."assets/shop/phpQuery/phpQuery.php";


function wrap_road_marking($text) {
    // Регулярний вираз для пошуку знаків у форматі 1.1, 1.2, 1.44.1 тощо
    $pattern = '/\b(\d+\.\d+(?:\.\d+)?)\b/';
    
    // Замінюємо знайдені знаки на тег <a>
    $replacement = '<a href="#" class="marking_link" data-marking-view="$1">$1</a>';
    
    return preg_replace($pattern, $replacement, $text);
}

function wrap_road_signs($text) {
    // Регулярний вираз для пошуку знаків у форматі 1.1, 1.2, 1.44.1 тощо
    $pattern = '/\b(\d+\.\d+(?:\.\d+)?)\b/';
    
    // Замінюємо знайдені знаки на тег <a>
    $replacement = '<a href="#" class="sign_link" data-sign-view="$1">$1</a>';
    
    return preg_replace($pattern, $replacement, $text);
}

function updateImageLinks($html) {
    return preg_replace_callback(
        '/(<a[^>]*href="([^"]+)"[^>]*>)\s*<img src="([^"]+)"([^>]*)>\s*(<\/a>)/i',
        function ($matches) {
            $aTag = $matches[1];  // Зберігаємо весь <a> тег
            $href = $matches[2];  // URL у href
            $imgAttributes = $matches[4];  // Інші атрибути img
            $closingATag = $matches[5];  // Закриваючий </a>

            // Оновлюємо src у <img> та додаємо стиль
            $newImgTag = '<img src="' . $href . '" ' . $imgAttributes . ' style="width:36px;height:36px;">';

            // Повертаємо оновлений код
            return $aTag . $newImgTag . $closingATag;
        },
        $html
    );
}




$q = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE chapter = 33');
while($r = $modx->db->getRow($q)){
	$description = $r['description'];
	
	
	
	$res = updateImageLinks($description);
	 $modx->db->query('UPDATE `new_pdr_chapter_item` SET description = "'.$modx->db->escape($res).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
}
die;

/*
$file = MODX_BASE_PATH.'assets/shop/pdr/seo_data.csv';


$handle = fopen($file,"r");
$count = 0;
while (($data = $shop->fgetcsv($handle,',')) !== FALSE) {

	if($count > 9){
		$url = str_replace('https://pdr-online.com.ua','',$data[2]);
		$h1 = trim($data[1]);
		$title = trim($data[3]);
		$description = trim($data[4]);
	
   	$h2 = str_replace('Інструктори ', '',$h1);

   	$search = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_city` WHERE city_name = "'.$modx->db->escape($h2).'" LIMIT 1'));

   	$slug = '/instruktori/city-'.$search['city_slug'].'/';
		$modx->db->query("insert into `modx_a_seo2url` set 
												seo_url         = '".$modx->db->escape($slug)."', 
												seo_pagetitle   = '".$modx->db->escape($shop->m_entities($h1))."', 
												seo_title       = '".$modx->db->escape($shop->m_entities($title))."', 
												seo_description = '".$modx->db->escape($shop->m_entities($description))."'
		");

	}
	$count++;
}
*/





die;

/*
$pattern = '/<img.*?src=["\'](.*?)["\'].*?>/i';

$q = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE 1 = 1');
while($r = $modx->db->getRow($q)){
	$description = $r['description'];
	preg_match_all($pattern, $r['description'], $matches);

	foreach($matches[1] as $k => $matche){
		$src = $matches[0][$k];
		$img_a = str_replace('/small/','/original/',$matche);
		$description = str_replace($src,'<a href="'.$img_a.'" class="fancybox">'.$src.'</a>',$description);

	}
	 $modx->db->query('UPDATE `new_pdr_chapter_item` SET description = "'.$modx->db->escape($description).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
}


die;
*/

//УДАЛИТЬ IMG старі
/*
$text = '';

$text2 = str_replace('https://web.testpdr.com/storage/','/assets/images/pdr/',$text);
// Вывод строки с новыми адресами изображений
*/





//УДАЛИТЬ <A HREF!
/*
$text = '';
$text2 = preg_replace('/<a\s.*?href=[\'"]([^\'"]*)[\'"].*?>(.*?)<\/a>/', '$2', $text);
*/



die;


/*
Проставити відповіді
  $ff = MODX_BASE_PATH . "assets/shop/pdr/answers_pdr.csv";


    $handle = fopen($ff,"r");
    while (($data = $shop->fgetcsv($handle)) !== FALSE) {
    	$chapter = trim($data[0]);
    	$question = trim($data[1]);
    	$correct = trim($data[2])-1;


    	$qc = $modx->db->getRow($modx->db->query('SELECT question_id FROM `new_question_2_theme` q2t 
LEFT JOIN `new_question` q ON q.id = q2t.question_id 
LEFT JOIN `new_question_theme` qt ON qt.id = q2t.theme_id
WHERE  q.number = "'.$modx->db->escape($question).'" AND qt.number = "'.$modx->db->escape($chapter).'" LIMIT 1'));
    	if($qc['question_id']){
   			$modx->db->query('UPDATE `new_question` SET correct = "'.$modx->db->escape($correct).'", parsed = "1" WHERE id = "'.$modx->db->escape($qc['question_id']).'" LIMIT 1');
   		}else{
   			var_dump($chapter,$question);die;
   			var_dump('error!');die;
   		}
    }
*/


die;

$q = $modx->db->query('SELECT * FROM `new_question` WHERE 1 = 1 ');
while($r = $modx->db->getRow($q)){
	$answers = json_decode($r['answers'],true);
	foreach($answers as $k => $v){
		$pos = mb_strpos($v['description'],'Відповіді');
		if($pos !== false){
			echo $r['id'].'</br>';
		}
	}
}

die;

 





/*
pdr parser
for($i = 1; $i <= 34; $i++){
	$pdr = 'https://pdr.infotech.gov.ua/theory/rules/'.$i;

	$page = $shop->get_page($pdr);


      $html = phpQuery::newDocument($page);
      
      $title = $html->find('.page-title h1')->html();

      $modx->db->query('INSERT INTO `new_pdr_chapter` SET `chapter` = "'.$modx->db->escape($i).'", `name` = "'.$modx->db->escape($title).'" ');

      foreach ($html->find('.MuiCardContent-root > div .MarkdownPage_contentWrap__jg5mr') as $chapter) {
       	$text = pq($chapter)->html();
       	$attr = pq($chapter)->attr('id');
       	$modx->db->query('INSERT INTO `new_pdr_chapter_item` SET `chapter` = "'.$modx->db->escape($i).'", `number` = "'.$modx->db->escape($attr).'", `description` = "'.$modx->db->escape($text).'" ');

       }
      


}

*/
/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE id = "7" LIMIT 1');
while ($r = $modx->db->getRow($q)) {

  $html = phpQuery::newDocument($r['text']);
	

  	foreach ($html->find('.TheoryAccordion_sign__kUZDB a') as $href) {
  		$image = pq($href)->find('img')->attr('src');
  		$number = trim(strip_tags(pq($href)->html()));
  		$url = 'https://pdr.infotech.gov.ua'.pq($href)->attr('href');

	$modx->db->query('INSERT INTO `new_pdr_road_sign_item` SET
		type = "'.$modx->db->escape($r['id']).'",
		number = "'.$modx->db->escape($number).'",
		image = "'.$modx->db->escape($image).'",
		url = "'.$modx->db->escape($url).'"

	');
  	}
}
*/
/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE parsed = "0" LIMIT 10');
while ($r = $modx->db->getRow($q)) {
	$page = $shop->get_page($r['url']);

    $html = phpQuery::newDocument($page);
      




    $title = trim(strip_tags(str_replace('знак '.$r['number'],'',$html->find('.MarkdownPage_titleWrap__KvY0S > div:eq(1)')->html())));

    $text = $html->find('.MarkdownPage_contentWrap__jg5mr')->html();


    $example = $html->find('.MarkdownPage_example__1tnaq img')->attr('src');



    $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
    	name = "'.$modx->db->escape($title).'",
    	description = "'.$modx->db->escape($text).'",
    	example = "'.$modx->db->escape($example).'",
    	parsed = "1"
    	WHERE id = "'.$modx->db->escape($r['id']).'"
    	');

}
*/

/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE id = "2" LIMIT 1');
while ($r = $modx->db->getRow($q)) {

  $html = phpQuery::newDocument($r['text']);
	
  	foreach ($html->find('.TheoryAccordion_sign__kUZDB a') as $href) {
  		$image = pq($href)->find('img')->attr('src');
  		$number = trim(strip_tags(pq($href)->html()));
  		$url = 'https://pdr.infotech.gov.ua'.pq($href)->attr('href');

	$modx->db->query('INSERT INTO `new_pdr_road_marking_item` SET
		type = "'.$modx->db->escape($r['id']).'",
		number = "'.$modx->db->escape($number).'",
		image = "'.$modx->db->escape($image).'",
		url = "'.$modx->db->escape($url).'"

	');
  	}
}
*/
/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE parsed = "0" LIMIT 20');
while ($r = $modx->db->getRow($q)) {
	$page = $shop->get_page($r['url']);

    $html = phpQuery::newDocument($page);
      




    $title = trim(strip_tags(str_replace('розмітка '.$r['number'],'',$html->find('.MarkdownPage_titleWrap__KvY0S > div:eq(1)')->html())));

    $text = $html->find('.MarkdownPage_contentWrap__jg5mr')->html();


    $example = $html->find('.MarkdownPage_example__1tnaq img')->attr('src');



    $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
    	name = "'.$modx->db->escape($title).'",
    	description = "'.$modx->db->escape($text).'",
    	example = "'.$modx->db->escape($example).'",
    	parsed = "1"
    	WHERE id = "'.$modx->db->escape($r['id']).'"
    	');

}
*/
 







/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE parsed = "1" LIMIT 30');
while ($r = $modx->db->getRow($q)) {

	$image = $r['image'];
	$exp_n = explode('/', $image);
	$folder = MODX_BASE_PATH.'assets/images/';
	$pre_f = 'pdr/road-markings/original/';

    $image_new = '/'.$pre_f.end($exp_n);
    $res = copy($r['image'], $folder.$pre_f.end($exp_n));
    if($res){
	    $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
	    	image_new = "'.$modx->db->escape($image_new).'",
	    	parsed = "0"
	    	WHERE id = "'.$modx->db->escape($r['id']).'"
	    	');
	}else{
		var_dump($r['id']);die;
	}

}
*/

/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE parsed = "1" LIMIT 50');
while ($r = $modx->db->getRow($q)) {

	$image = $r['image'];
	$exp_n = explode('/', $image);
	$folder = MODX_BASE_PATH.'assets/images/';
	$pre_f = 'pdr/road-signs/original/';

    $image_new = '/'.$pre_f.end($exp_n);
    $res = copy($r['image'], $folder.$pre_f.end($exp_n));
    if($res){
	    $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
	    	image_new = "'.$modx->db->escape($image_new).'",
	    	parsed = "0"
	    	WHERE id = "'.$modx->db->escape($r['id']).'"
	    	');
	}else{
		var_dump($r['id']);die;
	}

}
*/

/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE parsed = "0" LIMIT 100');
while ($r = $modx->db->getRow($q)) {
	if($r['example'] != ''){
		$image = $r['example'];
		$exp_n = explode('/', $image);
		$folder = MODX_BASE_PATH.'assets/images/';
		$pre_f = 'pdr/image-example/';

	    $image_new = '/'.$pre_f.end($exp_n);
	    $res = copy($r['example'], $folder.$pre_f.end($exp_n));
	    if($res){
		    $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
		    	example_new = "'.$modx->db->escape($image_new).'",
		    	parsed = "1"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
		}else{
			var_dump($r['id']);die;
		}
	}else{
	    $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
	    	parsed = "1"
	    	WHERE id = "'.$modx->db->escape($r['id']).'"
    	');
	}

}
*/


/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE parsed = "0" LIMIT 100');
while ($r = $modx->db->getRow($q)) {
	if($r['example'] != ''){
		$image = $r['example'];
		$exp_n = explode('/', $image);
		$folder = MODX_BASE_PATH.'assets/images/';
		$pre_f = 'pdr/image-example/';

	    $image_new = '/'.$pre_f.end($exp_n);
	    $res = copy($r['example'], $folder.$pre_f.end($exp_n));
	    if($res){
		    $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
		    	example_new = "'.$modx->db->escape($image_new).'",
		    	parsed = "1"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
		}else{
			var_dump($r['id']);die;
		}
	}else{
	    $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
	    	parsed = "1"
	    	WHERE id = "'.$modx->db->escape($r['id']).'"
    	');
	}

}
*/
/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE parsed = "1" AND `description` LIKE "%https:%" LIMIT 5');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];
	$text = str_replace('<button class="MuiTypography-root MuiLink-root MuiLink-underlineHover MarkdownParser_link__DZ4_2 MuiLink-button MuiTypography-colorPrimary">', '', $text);
	$text = str_replace('</button>', '', $text);


    $html = phpQuery::newDocument($text);
      

    foreach ($html->find('img') as $img) {
    	$img_s = pq($img)->attr('src');


		$folder = MODX_BASE_PATH.'assets/images';
	    $image_new = str_replace('https://web.testpdr.com/storage/', '/pdr/', $img_s);
    	
	    $text = str_replace($img_s, $image_new, $text);


	    copy($img_s,$folder.$image_new);
	 





    }

	
		    $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
		    	description = "'.$modx->db->escape($text).'",
		    	parsed = "0"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}

*/
/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE parsed = "1" AND `description` LIKE "%https:%" LIMIT 10');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];
	$text = str_replace('<button class="MuiTypography-root MuiLink-root MuiLink-underlineHover MarkdownParser_link__DZ4_2 MuiLink-button MuiTypography-colorPrimary">', '', $text);
	$text = str_replace('</button>', '', $text);


    $html = phpQuery::newDocument($text);
      
    foreach ($html->find('img') as $img) {
    	$img_s = pq($img)->attr('src');


		$folder = MODX_BASE_PATH.'assets/images';
	    $image_new = str_replace('https://web.testpdr.com/storage/', '/pdr/', $img_s);
    	
	    $text = str_replace($img_s, $image_new, $text);


	    copy($img_s,$folder.$image_new);
	 





    }

	
		    $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
		    	description = "'.$modx->db->escape($text).'",
		    	parsed = "0"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}

*/

/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['intro'];
	$text = str_replace('<button class="MuiTypography-root MuiLink-root MuiLink-underlineHover MarkdownParser_link__DZ4_2 MuiLink-button MuiTypography-colorPrimary">', '', $text);
	$text = str_replace('</button>', '', $text);


    $html = phpQuery::newDocument($text);
      

    foreach ($html->find('img') as $img) {
    	$img_s = pq($img)->attr('src');


		$folder = MODX_BASE_PATH.'assets/images';
	    $image_new = str_replace('https://web.testpdr.com/storage/', '/pdr/', $img_s);
    	
	    $text = str_replace($img_s, $image_new, $text);

	    copy($img_s,$folder.$image_new);
	 





    }

	
		    $modx->db->query('UPDATE `new_pdr_road_marking` SET 
		    	intro = "'.$modx->db->escape($text).'"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}
*/
/*
$q = $modx->db->query('SELECT * FROM `new_pdr_info` WHERE 1 = 1');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];
	$text = str_replace('<button class="MuiTypography-root MuiLink-root MuiLink-underlineHover MarkdownParser_link__DZ4_2 MuiLink-button MuiTypography-colorPrimary">', '', $text);
	$text = str_replace('</button>', '', $text);

    $html = phpQuery::newDocument($text);
      

    foreach ($html->find('img') as $img) {
    	$img_s = pq($img)->attr('src');


		$folder = MODX_BASE_PATH.'assets/images';
	    $image_new = str_replace('https://web.testpdr.com/storage/', '/pdr/', $img_s);
    	
	    $text = str_replace($img_s, $image_new, $text);

	    copy($img_s,$folder.$image_new);
	 





    }

	
		    $modx->db->query('UPDATE `new_pdr_info` SET 
		    	description = "'.$modx->db->escape($text).'"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}
*/




/*
$q = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE parsed = "0" LIMIT 1');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];
	$text = str_replace('<button class="MuiTypography-root MuiLink-root MuiLink-underlineHover MarkdownParser_link__DZ4_2 MuiLink-button MuiTypography-colorPrimary">', '', $text);
	$text = str_replace('</button>', '', $text);

    $html = phpQuery::newDocument($text);
      

    foreach ($html->find('img') as $img) {
    	$img_s = pq($img)->attr('src');


		$folder = MODX_BASE_PATH.'assets/images';
	    $image_new = str_replace('https://web.testpdr.com/storage/', '/pdr/', $img_s);
    	
	    $text = str_replace($img_s, $image_new, $text);

	    copy($img_s,$folder.$image_new);
	 





    }
	
		    $modx->db->query('UPDATE `new_pdr_chapter_item` SET 
		    	description = "'.$modx->db->escape($text).'",
		    	parsed = "1"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}
*/


/*
$q = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE parsed = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];

    $html = phpQuery::newDocument($text);
      

   

    $new_html = $html->find('.MarkdownParser_wrap__e2_P_')->html();

	
		    $modx->db->query('UPDATE `new_pdr_chapter_item` SET 
		    	description = "'.$modx->db->escape($new_html).'",
		    	parsed = "0"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}
*/

/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE parsed = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];

    $html = phpQuery::newDocument($text);
      

   

    $new_html = $html->find('.MarkdownParser_wrap__e2_P_')->html();

	
		    $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
		    	description = "'.$modx->db->escape($new_html).'",
		    	parsed = "0"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}
*/

/*
$q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE parsed = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$text = $r['description'];

    $html = phpQuery::newDocument($text);
      

   

    $new_html = $html->find('.MarkdownParser_wrap__e2_P_')->html();

	
		    $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
		    	description = "'.$modx->db->escape($new_html).'",
		    	parsed = "0"
		    	WHERE id = "'.$modx->db->escape($r['id']).'"
		    	');
	
	

}
*/

/*
$text = '<div  class="content"><div  class="fines-table ng-star-inserted" id="9fe8c5ba-56f9-40b8-aaa8-dd2076f6d6a8"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121^1 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Експлуатація водіями транспортних засобів, ідентифікаційні номери складових частин яких не відповідають записам у реєстраційних документах, знищені або підроблені;</span></p></div><div  class="amount"><p >Штраф 255  грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="9a62ae39-7be1-4a02-abd1-90361f8e4bf4"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121^2 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Перевезення водіями транспортних засобів, що працюють у режимі маршрутних таксі, пасажирів понад максимальну кількість, передбачену технічною характеристикою транспортного засобу або визначену в реєстраційних документах на цей транспортний засіб, а також перевезення водіями транспортних засобів, що здійснюють міжміські чи міжнародні перевезення, пасажирів, кількість яких перевищує кількість місць для сидіння, передбачену технічною характеристикою транспортного засобу або визначену в реєстраційних документах на цей транспортний засіб;</span></p></div><div  class="amount"><p >Штраф 170  грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="7319add1-8061-43bd-831f-7be5248d5b9f"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121^2 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Порушення водіями транспортних засобів, що працюють у режимі маршрутних таксі, правил зупинки під час здійснення посадки (висадки) пасажирів;</span></p></div><div  class="amount"><p >Штраф 255  грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="6314d5e0-9391-43b9-b05b-6882bae6bfef"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121^2 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Перевезення пасажирів на автобусному маршруті протяжністю понад п`ятсот кілометрів одним водієм;</span></p></div><div  class="amount"><p >Штраф 170 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="43b2ba97-b82f-4aaa-bedb-6c977b9cff08"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Керування водієм транспортним засобом, що має несправності системи гальмового або рульового керування, тягово-зчіпного пристрою, зовнішніх світлових приладів (темної пори доби) чи інші технічні несправності, з якими відповідно до встановлених правил експлуатація його забороняється, або переобладнаний з порушенням відповідних правил, норм і стандартів;</span></p></div><div  class="amount"><p >Штраф 340  грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="71f0925d-0ec4-4697-8c24-c357b13210de"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Керування водієм транспортним засобом, який використовується для надання послуг з перевезення пасажирів, що має несправності, передбачені ст. 121 ч.1, або технічний стан і обладнання якого не відповідають вимогам стандартів, правил дорожнього руху і технічної експлуатації;</span></p></div><div  class="amount"><p >Штраф 680 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="66d650e7-ba5a-46fc-b23a-bcf97ac60718"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Керування водієм транспортним засобом, що підлягає обов`язковому технічному контролю, але своєчасно його не пройшов;</span></p></div><div  class="amount"><p >Штраф 340 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="6bce3ad4-68a1-41e3-8941-6c667b1970b2"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.4</p></div><div  class="fines-table-name fr-view"><p><span >Повторне протягом року вчинення будь-якого з порушень, передбачених ст. 121 ч 1, 2, 3;</span></p><p><span >* Тягне за собою позбавлення права керування транспортними засобами на строк від трьох до шести місяців або адміністративний арешт на строк від п`яти до десяти діб.</span></p></div><div  class="amount"><p >Штраф * грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="92870602-61f4-4414-9556-9aa4e51c831a"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.5</p></div><div  class="fines-table-name fr-view"><p><span >Порушення правил користування ременями безпеки або мотошоломами;</span></p></div><div  class="amount"><p >Штраф 510 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="114b6559-6bd0-4836-8024-12fd7ffc8e2d"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.6</p></div><div  class="fines-table-name fr-view"><p><span >Керування водієм транспортним засобом, не зареєстрованим або не перереєстрованим в установленому порядку, без номерного знака або з номерним знаком, що не належить цьому засобу чи не відповідає вимогам стандартів, або з номерним знаком, закріпленим у не встановленому для цього місці, закритим іншими предметами чи забрудненим, що не дозволяє чітко визначити символи номерного знака з відстані двадцяти метрів, перевернутим чи неосвітленим;</span></p></div><div  class="amount"><p >Штраф 850 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="eb138eca-60e8-4735-b181-ec82d9763384"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.7</p></div><div  class="fines-table-name fr-view"><p><span >Повторне протягом року вчинення будь-якого з порушень, передбачених ст. 121 ч.6;</span></p><p><span >* Штраф або громадські роботи на строк від тридцяти до сорока годин, з оплатним вилученням транспортного засобу чи без такого.</span></p></div><div  class="amount"><p >Штраф 1700* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="a2055819-6efe-49dd-87f4-d7bb15b1fefe"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.10</p></div><div  class="fines-table-name fr-view"><p><span >Порушення правил перевезення дітей.</span><span>&nbsp;Коментар до статті</span><span >. &nbsp;Згідно п.&nbsp;</span><span> <a href="https://romdomdom.in.ua/home/tm/traffic-rules/traffic-rule/491556f0-7fdd-4ec7-86f9-4735b7f4e26a/9ae7113a-8390-4f64-88cd-d89a4810898f" target="_blank">21.11</a></span><span >&nbsp;"б" ПДР, забороняється перевозити дітей, зріст яких менше 145 см або тих, що не досягли 12-річного віку, — у транспортних засобах, обладнаних ременями безпеки, без використання спеціальних засобів, що дають змогу пристебнути дитину за допомогою ременів безпеки, передбачених конструкцією цього транспортного засобу; на передньому сидінні легкового автомобіля — без використання зазначених спеціальних засобів; на задньому сидінні мотоцикла та мопеда;</span></p></div><div  class="amount"><p >Штраф 510 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="3d845652-2e8a-4c43-8438-be65d5039b34"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 121 ч.11</p></div><div  class="fines-table-name fr-view"><p><span >Повторне протягом року вчинення порушення вимог ст. 121 ч.10 (порушення правил перевезення дітей);</span></p></div><div  class="amount"><p >Штраф 850 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="df8969e9-c290-450d-a79d-00d15284a4f5"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122^2</p></div><div  class="fines-table-name fr-view"><p><span >Невиконання водіями вимог поліцейського, а водіями військових транспортних засобів - вимог посадової особи військової інспекції безпеки дорожнього руху Військової служби правопорядку у Збройних Силах України про зупинку транспортного засобу;</span></p><p><span >* Штраф або позбавлення права керування транспортними засобами на строк від трьох до шести місяців.</span></p></div><div  class="amount"><p >Штраф 153* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="ee41074e-758d-4b32-ac8c-8d12e352ad9a"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122^4</p></div><div  class="fines-table-name fr-view"><p><span >Залишення водіями транспортних засобів, іншими учасниками дорожнього руху на порушення встановлених правил місця дорожньо-транспортної пригоди, до якої вони причетні;</span></p><p><span >* Штраф або позбавлення права керування транспортними засобами на строк від одного до двох років.</span></p></div><div  class="amount"><p >Штраф 3400* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="244a9f31-5129-4670-ab80-a7a170236bc8"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122^5</p></div><div  class="fines-table-name fr-view"><p><span >Порушення вимог законодавства щодо встановлення і використання на транспортному засобі спеціальних світлових або звукових сигнальних пристроїв;</span></p><p><span >* Штраф з конфіскацією спеціальних світлових або звукових сигнальних пристроїв.</span></p></div><div  class="amount"><p >Штраф 8500* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="cf954924-5afd-4c3d-9996-68e65354ddb6"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Перевищення водіями транспортних засобів встановлених обмежень швидкості руху транспортних засобів більш як на двадцять кілометрів на годину, порушення вимог дорожніх знаків та розмітки проїзної частини доріг, правил перевезення вантажів, буксирування транспортних засобів, зупинки, стоянки, проїзду пішохідних переходів, ненадання переваги у русі пішоходам на нерегульованих пішохідних переходах, а так само порушення встановленої для транспортних засобів заборони рухатися тротуарами чи пішохідними доріжками;</span></p></div><div  class="amount"><p >Штраф 340 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="0630aa3d-7a64-479f-8d1a-3bc41b925f2a"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Порушення водіями транспортних засобів правил проїзду перехресть, зупинок транспортних засобів загального користування, проїзд на заборонний сигнал світлофора або жест регулювальника, порушення правил обгону і зустрічного роз`їзду, безпечної дистанції або інтервалу, розташування транспортних засобів на проїзній частині, порушення правил руху автомагістралями, користування зовнішніми освітлювальними приладами або попереджувальними сигналами при початку руху чи зміні його напрямку, використання цих приладів та їх переобладнання з порушенням вимог відповідних стандартів, користування водієм під час руху транспортного засобу засобами зв`язку, не обладнаними технічними пристроями, що дозволяють вести перемови без допомоги рук (за винятком водіїв оперативних транспортних засобів під час виконання ними невідкладного службового завдання), а так само порушення правил навчальної їзди; &nbsp;</span></p><p><span >&nbsp;</span></p></div><div  class="amount"><p >Штраф 510 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="9650dd1c-80f8-44b6-9f8f-f49b41fd2c1a"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Ненадання переваги в русі транспортним засобам аварійно-рятувальних служб, швидкої медичної допомоги, пожежної охорони, поліції, що рухаються з увімкненими спеціальними світловими або звуковими сигнальними пристроями, ненадання переваги маршрутним транспортним засобам, у тому числі порушення правил руху і зупинки на смузі для маршрутних транспортних засобів, а так само порушення правил зупинки, стоянки, що створюють перешкоди дорожньому руху або загрозу безпеці руху;</span></p></div><div  class="amount"><p >Штраф 680 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="9d942534-bbac-43ca-b673-ea8eec7e015e"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.4</p></div><div  class="fines-table-name fr-view"><p><span >Перевищення водіями транспортних засобів встановлених обмежень швидкості руху транспортних засобів більш як на п`ятдесят кілометрів на годину.</span></p></div><div  class="amount"><p >Штраф 1700 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="750abf3b-9b63-4ff5-9133-d22ebe579fa7"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.5</p></div><div  class="fines-table-name fr-view"><p><span >Порушення, передбачені частинами першою – четвертою цієї статті, що спричинили створення аварійної обстановки, а саме: примусили інших учасників дорожнього руху різко змінити швидкість, напрямок руху або вжити інших заходів щодо забезпечення особистої безпеки або безпеки інших громадян, що підтверджені фактичними даними, а саме: поясненнями особи, яка притягається до адміністративної відповідальності, потерпілого, свідків, показань технічних приладів та засобів фото- і відеоспостереження та іншими документами;</span></p><p><span >* Штраф або позбавлення права керування транспортними засобами на строк від шести місяців до одного року.</span></p></div><div  class="amount"><p >Штраф 1445* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="3b7d03e5-f5ca-42cd-a989-675fb9f83179"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.6</p></div><div  class="fines-table-name fr-view"><p><span >Зупинка чи стоянка транспортних засобів на місцях, що позначені відповідними дорожніми знаками або дорожньою розміткою, на яких дозволено зупинку чи стоянку лише транспортних засобів, якими керують водії з інвалідністю або водії, які перевозять осіб з інвалідністю (крім випадків вимушеної стоянки), а так само створення перешкод водіям з інвалідністю або водіям, які перевозять осіб з інвалідністю, у зупинці чи стоянці керованих ними транспортних засобів, неправомірне використання на транспортному засобі розпізнавального знака "Водій з інвалідністю".</span></p></div><div  class="amount"><p >Штраф 1020 - 1700 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="134e8eb9-944a-4ec3-9a84-68a859fb2129"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 122 ч.7</p></div><div  class="fines-table-name fr-view"><p><span >Зупинка чи стоянка транспортних засобів на місцях, що позначені відповідними дорожніми знаками та/або дорожньою розміткою, на яких дозволено зупинку чи стоянку лише транспортних засобів, оснащених електричними двигунами (одним чи декількома), а так само створення перешкод водіям транспортних засобів, оснащених електричними двигунами (одним чи декількома), у зупинці або стоянці.</span></p></div><div  class="amount"><p >Штраф 340 - 680 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="c9889f43-f18a-4d0d-8b25-4092937005b4"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 123 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Порушення особою, яка керує транспортним засобом, правил руху через залізничний переїзд, крім порушень, передбачених частинами другою і третьою цієї статті;</span></p></div><div  class="amount"><p >Штраф 340 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="f6c7c978-12cd-4a8d-a2b4-0e6fed324b3c"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 123 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >В`їзд на залізничний переїзд особою, яка керує транспортним засобом, у випадках, коли рух через переїзд заборонений;</span></p><p><span >* Штраф з оплатним вилученням транспортного засобу у його власника чи без такого або позбавлення права керування транспортними засобами на строк від шести місяців до одного року з оплатним вилученням транспортного засобу у його власника чи без такого або адміністративний арешт на строк від семи до десяти діб з оплатним вилученням транспортного засобу у його власника чи без такого.</span></p></div><div  class="amount"><p >Штраф 850* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="12931601-bc55-40be-b41f-4720423e2805"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 123 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Порушення, передбачене частиною другою цієї статті, вчинене водієм транспортного засобу під час надання послуг з перевезення пасажирів або під час перевезення небезпечних вантажів;</span></p><p><span >* Тягне за собою позбавлення права керування транспортними засобами на строк від одного до трьох років з оплатним вилученням транспортного засобу у його власника чи без такого або адміністративний арешт на строк від десяти до п`ятнадцяти діб з оплатним вилученням транспортного засобу у його власника чи без такого.</span></p></div><div  class="amount"><p >Штраф * грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="d61ee56b-56a8-4607-b6be-90aa482049d2"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 124</p></div><div  class="fines-table-name fr-view"><p><span >Порушення учасниками дорожнього руху Правил дорожнього руху, що спричинило пошкодження транспортних засобів, вантажу, автомобільних доріг, вулиць, залізничних переїздів, дорожніх споруд чи іншого майна;</span></p><p><span >* Штраф або позбавлення права керування транспортними засобами на строк від шести місяців до одного року. Примітка. Особа, цивільно-правова відповідальність якої застрахована, звільняється від адміністративної відповідальності за порушення правил дорожнього руху, що спричинило пошкодження транспортних засобів, за умови, що учасники дорожньо-транспортної пригоди скористалися правом спільно скласти повідомлення про цю пригоду відповідно до Закону України "Про обов`язкове страхування цивільно-правової відповідальності власників наземних транспортних засобів".</span></p></div><div  class="amount"><p >Штраф 850* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="177ad7fb-506b-4cad-a4e6-0a7767938d32"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 124^1</p></div><div  class="fines-table-name fr-view"><p><span >Ненадання посадовими особами підприємств, установ, організацій і громадянами транспортних засобів, що їм належать, поліцейським та медичним працівникам, а також ненадання військових транспортних засобів посадовим особам Військової служби правопорядку у Збройних Силах України у встановлених законом невідкладних випадках;</span></p></div><div  class="amount"><p >Штраф 68 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="6e67bb3e-4135-4fe4-8c99-eefa35d9e59c"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 125</p></div><div  class="fines-table-name fr-view"><p><span >Інші порушення правил дорожнього руху, крім передбачених статтями 121-128, частинами першою і другою статті 129, статтями 139 і 140 Кодексу України про адміністративні правопорушення;</span></p><p><span >* Тягнуть за собою попередження.</span></p></div><div  class="amount"><p >Штраф * грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="3efff5dc-115c-4760-9a91-de6f61bcc6b5"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 126 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Керування транспортним засобом особою, яка не має при собі або не пред’явила у спосіб, який дає можливість поліцейському прочитати та зафіксувати дані, що містяться в посвідченні водія відповідної категорії, реєстраційному документі на транспортний засіб, а також полісі (договорі) обов’язкового страхування цивільно-правової відповідальності власників наземних транспортних засобів (страхового сертифіката "Зелена картка"), або не пред’явила електронне посвідчення водія та електронне свідоцтво про реєстрацію транспортного засобу, чинний внутрішній електронний договір зазначеного виду обов’язкового страхування у візуальній формі страхового поліса, а також інших документів, передбачених законодавством;</span></p></div><div  class="amount"><p >Штраф 425 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="b1249c81-ebb2-48c3-ac0b-41c049565d81"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 126 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Керування транспортним засобом особою, яка не має права керування таким транспортним засобом, або передача керування транспортним засобом особі, яка не має права керування таким транспортним засобом;</span></p><p><span >* Примітка: Положення частин першої та другої цієї статті не застосовуються до осіб, які у встановленому порядку навчаються водінню транспортного засобу.</span></p></div><div  class="amount"><p >Штраф 3400* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="851ac193-2c69-433e-9248-4f13b7ec093a"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 126 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Керування транспортним засобом особою, стосовно якої встановлено тимчасове обмеження у праві керування транспортними засобами;</span></p><p><span >* Позбавлення права керування транспортними засобами на строк від трьох до шести місяців.</span></p></div><div  class="amount"><p >Штраф * грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="a7fd8155-502e-4b66-857b-d7352d2faa4a"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 126 ч.4</p></div><div  class="fines-table-name fr-view"><p><span >Керування транспортним засобом особою, позбавленою права керування транспортними засобами;</span></p></div><div  class="amount"><p >Штраф 20400  грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="0f24b001-20c5-4284-b5da-18efe5c28ee8"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 126 ч.5</p></div><div  class="fines-table-name fr-view"><p><span >Повторне протягом року вчинення порушень, передбачених частинами другою – четвертою статті 126;</span></p><p><span >* Штраф з позбавленням права керування транспортним засобом на строк від п’яти до семи років та з оплатним вилученням транспортного засобу чи без такого.</span></p></div><div  class="amount"><p >Штраф 40800* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="97331893-a52d-4abe-acf1-79c982dab8b9"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 127 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Непокора пішоходів сигналам регулювання дорожнього руху, перехід ними проїзної частини у невстановлених місцях або безпосередньо перед транспортними засобами, що наближаються, невиконання інших правил дорожнього руху;</span></p></div><div  class="amount"><p >Штраф 255 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="0f8fe209-4d28-42a0-9e9e-4cebc71da933"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 127 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Порушення Правил дорожнього руху особами, які керують велосипедами, гужовим транспортом, і погоничами тварин;</span></p></div><div  class="amount"><p >Штраф 340 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="5e9c4871-1a50-456a-9f76-b249c66b1515"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 127 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Ті самі порушення, вчинені особами, зазначеними в частинах першій або другій цієї статті, які перебувають у стані сп`яніння;</span></p></div><div  class="amount"><p >Штраф 680 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="77c43928-377a-4299-b09e-2cd5812be853"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 127 ч.4</p></div><div  class="fines-table-name fr-view"><p><span >Порушення, передбачені частиною першою або другою цієї статті, що спричинили створення аварійної обстановки;</span></p></div><div  class="amount"><p >Штраф 850 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="975d5f01-56e9-4074-8400-aed4eac24f91"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 128^1 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Порушення або невиконання правил, норм і стандартів, що стосуються забезпечення безпеки дорожнього руху, на підприємствах, в установах та організаціях усіх форм власності під час виготовлення та ремонту транспортних засобів і деталей до них або встановлення на них інших предметів додаткового обладнання, не передбаченого конструкцією транспортного засобу, а також під час будівництва, реконструкції, ремонту та утримання автомобільних доріг, вулиць, залізничних переїздів і дорожніх споруд;</span></p></div><div  class="amount"><p >Штраф 1700 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="1090c4cf-5212-442a-bd12-b910f2eef0fd"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 128^1 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Порушення, передбачені частиною першою цієї статті, що спричинили пошкодження транспортних засобів, вантажів, автомобільних доріг, вулиць, залізничних переїздів, дорожніх споруд чи іншого майна;</span></p></div><div  class="amount"><p >Штраф 2550 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="a9d0059a-2659-48c8-a830-0240fa533d6b"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 130 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Керування транспортними засобами особами в стані алкогольного, наркотичного чи іншого сп`яніння або під впливом лікарських препаратів, що знижують їх увагу та швидкість реакції, а також передача керування транспортним засобом особі, яка перебуває в стані такого сп`яніння чи під впливом таких лікарських препаратів, а так само відмова особи, яка керує транспортним засобом, від проходження відповідно до встановленого порядку огляду на стан алкогольного, наркотичного чи іншого сп`яніння або щодо вживання лікарських препаратів, що знижують увагу та швидкість реакції;&nbsp;</span></p><p><span >* Тягнуть за собою накладення штрафу на водіїв з позбавленням права керування транспортними засобами на строк один рік і на інших осіб - накладення штрафу.</span></p></div><div  class="amount"><p >Штраф 17000* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="ba4095ab-e1b6-4d5c-ac44-11988d6584f6"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 130 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Повторне протягом року вчинення будь-якого з порушень, передбачених частиною першою статті 130 – * тягне за собою накладення штрафу (або адміністративний арешт на строк десять діб) на водіїв з позбавленням права керування транспортними засобами на строк три роки та з оплатним вилученням транспортного засобу чи без такого, і на інших осіб – накладення штрафу (або адміністративний арешт на строк десять діб) з оплатним вилученням транспортного засобу чи без такого.</span></p></div><div  class="amount"><p >Штраф 34000* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="480ea6e8-e29b-493c-8b2e-c0af992db4be"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 130 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Дії, передбачені частиною першою статті 130, вчинені особою, яка двічі протягом року піддавалась адміністративному стягненню за керування транспортними засобами у стані алкогольного, наркотичного чи іншого сп`яніння або під впливом лікарських препаратів, що знижують їх увагу та швидкість реакції, за відмову від проходження відповідно до встановленого порядку огляду на стан алкогольного, наркотичного чи іншого сп`яніння або щодо вживання лікарських препаратів, що знижують увагу та швидкість реакції –&nbsp;</span></p><p><span >* тягнуть за собою накладення штрафу (або адміністративний арешт на строк п’ятнадцять діб) на водіїв з позбавленням права керування транспортними засобами на строк десять років та з конфіскацією транспортного засобу, який є у приватній власності порушника і на інших осіб - накладення штрафу (або адміністративний арешт на строк п’ятнадцять діб) та з конфіскацією транспортного засобу, який є у приватній власності порушника.</span></p></div><div  class="amount"><p >Штраф 51000* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="cc5d63fe-3679-40dd-8c4d-42c281fc2135"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 130 ч.4</p></div><div  class="fines-table-name fr-view"><p><span >Вживання водієм транспортного засобу після дорожньо-транспортної пригоди за його участю алкоголю, наркотиків, а також лікарських препаратів, виготовлених на їх основі (крім тих, що входять до офіційно затвердженого складу аптечки або призначені медичним працівником), або після того, як транспортний засіб був зупинений на вимогу поліцейського, до проведення уповноваженою особою медичного огляду з метою встановлення стану алкогольного, наркотичного чи іншого сп`яніння або щодо вживання лікарських препаратів, що знижують його увагу та швидкість реакції, чи до прийняття рішення про звільнення від проведення такого огляду –</span></p><p><span >* тягне за собою накладення штрафу на водіїв або адміністративний арешт на строк п’ятнадцять діб, з позбавленням права керування транспортними засобами на строк три роки.</span></p></div><div  class="amount"><p >Штраф 34000* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="25a34513-0837-451b-a593-d0d53b290f4f"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 132^1</p></div><div  class="fines-table-name fr-view"><p><span >Порушення правил дорожнього перевезення небезпечних вантажів, правил проїзду великогабаритних і великовагових транспортних засобів автомобільними дорогами, вулицями або залізничними переїздами;</span></p><p>&nbsp;</p><p><span >* Штраф для водіїв: 510 грн, для відповідальних посадових осіб: 680 грн.</span></p></div><div  class="amount"><p >Штраф 510* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="f53ab348-a0a7-41e8-98d0-83b5fed6fb21"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 133^1 ч.1</p></div><div  class="fines-table-name fr-view"><p><span >Здійснення регулярних перевезень пасажирів на постійних маршрутах без укладення договору на перевезення пасажирів автомобільним транспортом або без паспорта маршруту;</span></p></div><div  class="amount"><p >Штраф 510 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="b5040767-1aa4-4813-ae4b-150b5514cdfe"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 133^1 ч.2</p></div><div  class="fines-table-name fr-view"><p><span >Порушення правил надання послуг з перевезення організованих груп дітей або туристів;</span></p><p><span >* Штраф для водіїв: 595 грн, для посадових осіб: 680 грн.</span></p></div><div  class="amount"><p >Штраф 595* грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="be4a425f-ade3-4bc0-bf38-a775aa731df9"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 133^1 ч.3</p></div><div  class="fines-table-name fr-view"><p><span >Відхилення від визначеного маршруту руху автобуса або маршрутного таксомотора, незаїзд на автостанцію (автовокзал), якщо такий заїзд передбачений розкладом руху автобуса або маршрутного таксомотора;</span></p><p>&nbsp;</p></div><div  class="amount"><p >Штраф 34 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="7a34d3a9-4689-4869-b695-e2e348bd02ee"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 133^1 ч.4</p></div><div  class="fines-table-name fr-view"><p><span >Здійснення перевезень пасажирів таксі, в яких не встановлено або не працює таксометр;</span></p></div><div  class="amount"><p >Штраф 51 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="abc6c4ba-8115-4262-a64a-d805ffcbf908"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 133^1 ч.5</p></div><div  class="fines-table-name fr-view"><p><span >Перевезення пасажирів чи вантажів водієм, який не пройшов щозмінного передрейсового медичного огляду водіїв транспортних засобів, або перевезення без проведення передрейсового контролю технічного стану транспортних засобів;</span></p></div><div  class="amount"><p >Штраф 510 грн</p></div></div></div><div  class="fines-table ng-star-inserted" id="99ff79ba-433a-4fd6-b031-9b285c9cb2ac"><div  class="fines-table-content"><div  class="fines-table-number"><p >Стаття 133^2</p></div><div  class="fines-table-name fr-view"><p><span >Здійснення внутрішніх автомобільних перевезень пасажирів і вантажів на території України транспортними засобами, зареєстрованими в інших державах, або міжнародних двосторонніх чи транзитних перевезень пасажирів і вантажів без відповідного дозволу, а також порушення особливих умов і правил, зазначених у ліцензії на здійснення міжнародних автомобільних перевезень пасажирів і вантажів;</span></p></div><div  class="amount"><p >Штраф 340 – 1700 грн</p></div></div></div><!----><div  class="empty-block"></div></div>';
$html = phpQuery::newDocument($text);
      
foreach($html->find('.fines-table') as $block){
	$name = trim(strip_tags(pq($block)->find('.fines-table-number')->html()));
	$description = trim(pq($block)->find('.fines-table-name')->html());
	$amount = trim(strip_tags(pq($block)->find('.amount')->html()));

	$modx->db->query('INSERT `new_pdr_fine` SET 
		name = "'.$modx->db->escape($name).'", 
		description = "'.$modx->db->escape($description).'", 
		amount = "'.$modx->db->escape($amount).'"
	');
}
*/


/*
$by_theme = '<a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/e70491d2-2f5c-4bfc-9fb5-9c5e187a15fc"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">1.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Загальні положення</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">79</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/0c63547b-dee6-4a89-9cd7-2c455edb4d4c"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">2.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Обов`язки і права водіїв автотранспортних засобів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">37</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/20f1da2a-40ed-4bed-94ac-f66d9852c83b"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">3.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Рух транспортних засобів із спеціальними сигналами</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">16</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/5d28e2e6-f125-4a3a-8f14-a2420041d5aa"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">4.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Обов`язки і права пішоходів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">26</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/8bdf93f7-5136-468d-b05b-cb1622f85fee"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">5.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Обов`язки і права пасажирів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">16</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/dcd2a1f5-ec6c-48f8-8662-805d23d35670"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">6.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Вимоги до велосипедистів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">22</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/ebd9753d-91da-40bf-b830-3e804f00cd82"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">7.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Вимоги до осіб, які керують гужовим транспортом і погоничів тварин</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">8</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/61f46a52-88cf-493a-a20e-072f503ba760"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">8.1.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name"> Регулювання дорожнього руху (регульовані перехрестя)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">84</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/dc99cbf0-5c24-43b5-8bdc-b89f43bafe01"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">8.2.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Регулювання дорожнього руху (нерегульовані перехрестя)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">7</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/24b4a82c-6c4f-4fc9-9c43-e776c473c13e"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">9.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name"> Попереджувальні сигнали </p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">60</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/18f9ba5a-c255-4a17-afe6-1fee1f58ff41"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">10.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Початок руху та зміна його напрямку</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">76</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/1d1eed0e-9cf1-4da1-94db-b580d1a1707a"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">11.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Розташування транспортних засобів на дорозі</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">39</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/ebe3e5ab-be1e-40ae-b325-2f3dfe92e1e0"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">12.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Швидкість руху</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">41</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/52bb4fa6-1474-4374-879c-38fc65be2d58"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">13.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Дистанція, інтервал, зустрічний роз`їзд</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">13</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/b6c2880e-47c4-454c-aa20-e5fee7f0190a"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">14.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Обгін</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">56</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/21f285d8-dfc2-46c1-b011-c55d5be6ffb0"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">15.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Зупинка і стоянка</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">97</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/7c898447-a534-4235-bc09-3744c5a37835"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">16.1.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Проїзд перехресть (регульовані перехрестя)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">34</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/5975a6eb-3532-4167-b248-87b79ddfde59"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">16.2.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Проїзд перехресть (нерегульовані перехрестя)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">108</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/9417f4c2-acb0-48d1-a9c1-2c016ed21853"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">17.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Переваги маршрутних транспортних засобів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">11</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/2049c727-d67f-418c-a062-35a84f23c856"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">18.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Проїзд пішохідних переходів і зупинок транспортних засобів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">19</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/3b084b0d-9fc5-4d8d-beb8-7690562c9eca"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">19.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Користування зовнішніми світловими приладами </p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">33</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/5730573c-36f2-4055-9fcd-adecfc777138"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">20.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Рух через залізничні переїзди </p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">31</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/6126bd30-2268-4c89-80d9-e0e7d2a94ce8"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">21.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Перевезення пасажирів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">12</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/e5364862-d4a5-4db3-bcb7-9797f6111184"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">22.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Перевезення вантажу</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">6</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/a5853e38-5f17-4b64-813b-dbd21ee885b8"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">23.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Буксирування та експлуатація транспортних составів </p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">20</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/e4ca89b8-ae45-4808-9b29-f6d53167f162"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">24.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Навчальна їзда</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">14</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/53bae117-251f-4dd2-8460-fc91fbc49c09"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">25.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Рух транспортних засобів у колонах</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">8</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/6a0b47a8-2d26-48ad-91aa-c84d06ef5119"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">26.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Рух у житловій та пішохідній зоні</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">13</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/ce945354-388f-4444-9e0d-e3cc97ddf135"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">27.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Рух по автомагістралях і дорогах для автомобілів</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">13</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/bb5d680c-a3c1-40ab-aba1-d29c38e47d73"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">28.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Рух по гірських дорогах і на крутих спусках</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">8</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/090ef06d-6e00-43f1-bd73-7a53847fcc8a"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">29.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Міжнародний рух</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">1</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/5175ca81-85bd-43e1-a4a1-c58af6ffd3ae"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">30.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Номерні, розпізнавальні знаки, написи і позначення</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">14</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/5f52e731-6369-452f-976c-16f4f30ab10d"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">31.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Технічний стан транспортних засобів та їх обладнання</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">18</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/aba558dc-afeb-4e6c-bf16-63c2f0327379"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">32.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Окремі питання дорожнього руху, що потребують узгодження</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">5</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/acc00c94-3b97-4af6-9143-2cb8a93f7390"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">33.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Дорожні знаки</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">357</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/ee3493d3-894d-4c64-bc7f-f89ff2711a33"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">34.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Дорожня розмітка</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">35</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/8b8d9366-402d-48fd-bd6c-2623ab13a729"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">35.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Основи безпечного водіння</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">171</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/3b55f062-778f-40aa-a42f-0e5c975459a6"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">36.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Основи права в області дорожнього руху</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">8</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/53ec9f38-ff99-49bf-902b-02366a324df8"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">37.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Надання першої медичної допомоги</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">35</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/3a5a0929-573f-4ee0-a17c-ead1351cfdca"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">38.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Етика водіння, культура та відпочинок водія</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">14</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/cb92f628-d3d3-4481-9bac-bb16f1b52055"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">39.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Європротокол</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">6</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/6a287f9e-c377-4767-a2fb-9cce8b99735e"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">40.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій АМ, А1, А2, А  (загальні)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">3</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/d00cd79e-b64a-4824-ae08-08ecb78502cf"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">44.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій B1, B (загальні)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">16</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/c67309f7-04c8-4cbf-9f82-98fe5d954996"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">45.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій B1, B (будова і терміни)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">33</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/44e83e7c-a096-4c58-afdf-ad05dd029795"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">46.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій В1, В (юридична відповідальність)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">9</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/4fad66f9-4823-42b6-97fa-21d8b38452a4"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">47.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій В1, В (безпека)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">7</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/32e16c8a-f1e0-494f-bcc3-1d2f6c7de9de"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">56.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій ВЕ, С1Е, СЕ, D1E, DE (загальні)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">21</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/4d0698da-b62b-4d1e-bc65-e9346557deba"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">57.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name"> Додаткові питання щодо категорій ВЕ, С1Е, СЕ, D1E, DE (будова і терміни)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">5</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/9db19a1a-1f93-4197-b5c1-71c094823786"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">58.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name">Додаткові питання щодо категорій BE, C1E, CE,  D1E, DE (юридична відповідальність)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">3</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c94="" class="item ng-star-inserted" href="/home/tests/test-on-theme/fafee50c-7be5-486f-a0b8-47e088931168"><div _ngcontent-jfn-c94="" class="item-content"><div _ngcontent-jfn-c94="" class="number"><p _ngcontent-jfn-c94="">59.</p></div><div _ngcontent-jfn-c94="" class="name"><p _ngcontent-jfn-c94="" class="name"> Додаткові питання щодо категорій ВЕ, С1Е, СЕ, D1E, DE (безпека)</p><p _ngcontent-jfn-c94="" class="count-question">Питань: <span _ngcontent-jfn-c94="">15</span></p></div><div _ngcontent-jfn-c94="" class="arrow"><img _ngcontent-jfn-c94="" src="../../../assets/icons/arrow-left.svg"></div></div></a>';



$html = phpQuery::newDocument($by_theme);

foreach ($html->find('.item') as $item) {
	

	$href = pq($item)->attr('href');

	$url = 'https://romdomdom.in.ua'.$href;

	$name = pq($item)->find('.name .name')->html();
	$questions = pq($item)->find('.name .count-question span')->html();


	$modx->db->query('INSERT INTO `new_question_theme` SET
			name = "'.$modx->db->escape($name).'",
			url = "'.$modx->db->escape($url).'"
	');

}
*/


/*
$by_ticket = '<div _ngcontent-jfn-c95="" class="test"><div _ngcontent-jfn-c95="" class="test-content"><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/9cbfb1cf-fc2b-428d-b0b2-57d376e5edd0"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">1.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №1</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/a9683d26-1df7-4d9b-a5bd-42eafe3dc21c"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">2.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №2</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/c60459a9-2a34-4fee-809e-9c75dd62bdbe"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">3.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №3</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/f7b77ba4-f16f-4476-9cb1-66c9b2097388"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">4.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №4</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/aacd5e0e-d504-4f59-9bac-74a4873ded40"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">5.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №5</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/7ef4c23e-2707-4af1-92f1-6e6d23df2564"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">6.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №6</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">18</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/dd7a29b2-4ca1-4588-995c-e0c3147c19e7"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">7.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №7</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/6607f42a-e0b3-4299-9219-a9ab7ec32242"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">8.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №8</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/8d20ce0b-6d06-4e9f-9cd7-80423040f072"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">9.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №9</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/0dbb6eaf-5408-4ef1-acdc-3ae79e0b9501"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">10.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №10</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/cefb0067-e534-4e4b-b73e-ddec2b4b35de"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">11.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №11</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/0ebcc234-e009-4a5b-b849-76be79779e25"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">12.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №12</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">18</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/d4f5d594-8602-4537-b38f-9e96a18eae92"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">13.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №13</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/3b462be3-edbf-4004-b50b-cd96c77f9be0"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">14.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №14</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/be679035-5446-4e53-9227-38291c7ba94d"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">15.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №15</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/bee1164a-bbd0-45b9-a093-c03e69978e19"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">16.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №16</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/67e5074e-1a9e-4f8f-9b1b-1e9638f253b4"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">17.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №17</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/b3d826c2-452e-41a5-864a-1997e6a18464"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">18.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №18</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">18</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/b5d05ecb-4cd9-495f-9d3f-db5d7c49781f"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">19.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №19</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/ba726795-95b8-4614-aa03-db86da505b60"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">20.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №20</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/57507227-d929-4bde-bb7c-9d2da6a07656"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">21.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №21</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/98b22a23-b4a5-4f1f-8211-534cd3d5cb16"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">22.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №22</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/00686e4d-61af-4ea1-8a85-742d993e8cee"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">23.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №23</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/ca6536a2-86d9-4b38-9bdb-94a1b2eec1da"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">24.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №24</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">17</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/424ea6eb-580f-419e-8bf8-1a01bb7869a7"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">25.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №25</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/69f1a7bd-553e-4ba2-9c9f-2888f63e0d57"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">26.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №26</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/db44f794-e7d5-4c03-bb65-3ee39ab6e73a"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">27.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №27</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/29f1d7f3-281e-47cf-a018-b042b8a28764"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">28.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет  №28</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">18</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/1f7115ee-ba4a-4bfd-8aa6-4748d5d0c631"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">29.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №29</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/3bb86657-4409-4da9-8e25-3be8394a4c5b"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">30.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №30</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/34b02ff8-8b19-46b7-b909-57cec78415d9"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">31.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №31</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/a4611aa2-a396-40f2-8e67-28932bd6e43a"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">32.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №32</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/20da0555-2a00-4bbc-a8e7-f7f0e77521e6"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">33.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №33</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">17</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/fddb31d8-b937-4aeb-acdb-364cf309c5e1"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">34.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №34</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/4bddcf1e-7ca6-4925-8700-74c21bdff8b8"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">35.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №35</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">19</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/ec99d33e-0ba7-47cb-bab0-b76361ac5483"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">36.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №36</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">18</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/c9d45da7-802e-4667-8b37-e5ff036f3d18"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">37.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №37</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/4143409d-d3d3-41ca-9c09-dbab153d04ff"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">38.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №38</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/148eccd9-5ab6-454c-901a-40e4344f8f2c"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">39.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №39</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><a _ngcontent-jfn-c95="" class="item ng-star-inserted" href="/home/tests/ticket-test/58e3ec0b-1c24-486d-999c-07e3b233466d"><div _ngcontent-jfn-c95="" class="item-content"><div _ngcontent-jfn-c95="" class="number"><p _ngcontent-jfn-c95="">40.</p></div><div _ngcontent-jfn-c95="" class="name"><p _ngcontent-jfn-c95="">Білет №40</p><div _ngcontent-jfn-c95=""><div _ngcontent-jfn-c95="" class="questions">Питань: <span _ngcontent-jfn-c95="">20</span></div></div></div><div _ngcontent-jfn-c95="" class="arrow"><img _ngcontent-jfn-c95="" src="../../../assets/icons/arrow-left.svg"></div></div></a><!----></div></div>';


$html = phpQuery::newDocument($by_ticket);

foreach ($html->find('.item') as $item) {
	

	$href = pq($item)->attr('href');

	$url = 'https://romdomdom.in.ua'.$href;

	$name = pq($item)->find('.name .name')->html();
	$questions = pq($item)->find('.name .count-question span')->html();


	$modx->db->query('INSERT INTO `new_question_ticket` SET
			name = "'.$modx->db->escape($name).'",
			url = "'.$modx->db->escape($url).'"
	');

}

*/


/*
парс по темам
$json = '[{"id":"e70491d2-2f5c-4bfc-9fb5-9c5e187a15fc","number":"1","testsCount":79,"name":"Загальні положення"},{"id":"0c63547b-dee6-4a89-9cd7-2c455edb4d4c","number":"2","testsCount":37,"name":"Обов`язки і права водіїв автотранспортних засобів"},{"id":"20f1da2a-40ed-4bed-94ac-f66d9852c83b","number":"3","testsCount":16,"name":"Рух транспортних засобів із спеціальними сигналами"},{"id":"5d28e2e6-f125-4a3a-8f14-a2420041d5aa","number":"4","testsCount":26,"name":"Обов`язки і права пішоходів"},{"id":"8bdf93f7-5136-468d-b05b-cb1622f85fee","number":"5","testsCount":16,"name":"Обов`язки і права пасажирів"},{"id":"dcd2a1f5-ec6c-48f8-8662-805d23d35670","number":"6","testsCount":22,"name":"Вимоги до велосипедистів"},{"id":"ebd9753d-91da-40bf-b830-3e804f00cd82","number":"7","testsCount":8,"name":"Вимоги до осіб, які керують гужовим транспортом і погоничів тварин"},{"id":"61f46a52-88cf-493a-a20e-072f503ba760","number":"8.1","testsCount":84,"name":" Регулювання дорожнього руху (регульовані перехрестя)"},{"id":"dc99cbf0-5c24-43b5-8bdc-b89f43bafe01","number":"8.2","testsCount":7,"name":"Регулювання дорожнього руху (нерегульовані перехрестя)"},{"id":"24b4a82c-6c4f-4fc9-9c43-e776c473c13e","number":"9","testsCount":60,"name":" Попереджувальні сигнали "},{"id":"18f9ba5a-c255-4a17-afe6-1fee1f58ff41","number":"10","testsCount":76,"name":"Початок руху та зміна його напрямку"},{"id":"1d1eed0e-9cf1-4da1-94db-b580d1a1707a","number":"11","testsCount":39,"name":"Розташування транспортних засобів на дорозі"},{"id":"ebe3e5ab-be1e-40ae-b325-2f3dfe92e1e0","number":"12","testsCount":41,"name":"Швидкість руху"},{"id":"52bb4fa6-1474-4374-879c-38fc65be2d58","number":"13","testsCount":13,"name":"Дистанція, інтервал, зустрічний роз`їзд"},{"id":"b6c2880e-47c4-454c-aa20-e5fee7f0190a","number":"14","testsCount":56,"name":"Обгін"},{"id":"21f285d8-dfc2-46c1-b011-c55d5be6ffb0","number":"15","testsCount":97,"name":"Зупинка і стоянка"},{"id":"7c898447-a534-4235-bc09-3744c5a37835","number":"16.1","testsCount":34,"name":"Проїзд перехресть (регульовані перехрестя)"},{"id":"5975a6eb-3532-4167-b248-87b79ddfde59","number":"16.2","testsCount":108,"name":"Проїзд перехресть (нерегульовані перехрестя)"},{"id":"9417f4c2-acb0-48d1-a9c1-2c016ed21853","number":"17","testsCount":11,"name":"Переваги маршрутних транспортних засобів"},{"id":"2049c727-d67f-418c-a062-35a84f23c856","number":"18","testsCount":19,"name":"Проїзд пішохідних переходів і зупинок транспортних засобів"},{"id":"3b084b0d-9fc5-4d8d-beb8-7690562c9eca","number":"19","testsCount":33,"name":"Користування зовнішніми світловими приладами "},{"id":"5730573c-36f2-4055-9fcd-adecfc777138","number":"20","testsCount":31,"name":"Рух через залізничні переїзди "},{"id":"6126bd30-2268-4c89-80d9-e0e7d2a94ce8","number":"21","testsCount":12,"name":"Перевезення пасажирів"},{"id":"e5364862-d4a5-4db3-bcb7-9797f6111184","number":"22","testsCount":6,"name":"Перевезення вантажу"},{"id":"a5853e38-5f17-4b64-813b-dbd21ee885b8","number":"23","testsCount":20,"name":"Буксирування та експлуатація транспортних составів "},{"id":"e4ca89b8-ae45-4808-9b29-f6d53167f162","number":"24","testsCount":14,"name":"Навчальна їзда"},{"id":"53bae117-251f-4dd2-8460-fc91fbc49c09","number":"25","testsCount":8,"name":"Рух транспортних засобів у колонах"},{"id":"6a0b47a8-2d26-48ad-91aa-c84d06ef5119","number":"26","testsCount":13,"name":"Рух у житловій та пішохідній зоні"},{"id":"ce945354-388f-4444-9e0d-e3cc97ddf135","number":"27","testsCount":13,"name":"Рух по автомагістралях і дорогах для автомобілів"},{"id":"bb5d680c-a3c1-40ab-aba1-d29c38e47d73","number":"28","testsCount":8,"name":"Рух по гірських дорогах і на крутих спусках"},{"id":"090ef06d-6e00-43f1-bd73-7a53847fcc8a","number":"29","testsCount":1,"name":"Міжнародний рух"},{"id":"5175ca81-85bd-43e1-a4a1-c58af6ffd3ae","number":"30","testsCount":14,"name":"Номерні, розпізнавальні знаки, написи і позначення"},{"id":"5f52e731-6369-452f-976c-16f4f30ab10d","number":"31","testsCount":18,"name":"Технічний стан транспортних засобів та їх обладнання"},{"id":"aba558dc-afeb-4e6c-bf16-63c2f0327379","number":"32","testsCount":5,"name":"Окремі питання дорожнього руху, що потребують узгодження"},{"id":"acc00c94-3b97-4af6-9143-2cb8a93f7390","number":"33","testsCount":357,"name":"Дорожні знаки"},{"id":"ee3493d3-894d-4c64-bc7f-f89ff2711a33","number":"34","testsCount":35,"name":"Дорожня розмітка"},{"id":"8b8d9366-402d-48fd-bd6c-2623ab13a729","number":"35","testsCount":171,"name":"Основи безпечного водіння"},{"id":"3b55f062-778f-40aa-a42f-0e5c975459a6","number":"36","testsCount":8,"name":"Основи права в області дорожнього руху"},{"id":"53ec9f38-ff99-49bf-902b-02366a324df8","number":"37","testsCount":35,"name":"Надання першої медичної допомоги"},{"id":"3a5a0929-573f-4ee0-a17c-ead1351cfdca","number":"38","testsCount":14,"name":"Етика водіння, культура та відпочинок водія"},{"id":"cb92f628-d3d3-4481-9bac-bb16f1b52055","number":"39","testsCount":6,"name":"Європротокол"},{"id":"6a287f9e-c377-4767-a2fb-9cce8b99735e","number":"40","testsCount":3,"name":"Додаткові питання щодо категорій АМ, А1, А2, А  (загальні)"},{"id":"d00cd79e-b64a-4824-ae08-08ecb78502cf","number":"44","testsCount":16,"name":"Додаткові питання щодо категорій B1, B (загальні)"},{"id":"c67309f7-04c8-4cbf-9f82-98fe5d954996","number":"45","testsCount":33,"name":"Додаткові питання щодо категорій B1, B (будова і терміни)"},{"id":"44e83e7c-a096-4c58-afdf-ad05dd029795","number":"46","testsCount":9,"name":"Додаткові питання щодо категорій В1, В (юридична відповідальність)"},{"id":"4fad66f9-4823-42b6-97fa-21d8b38452a4","number":"47","testsCount":7,"name":"Додаткові питання щодо категорій В1, В (безпека)"},{"id":"32e16c8a-f1e0-494f-bcc3-1d2f6c7de9de","number":"56","testsCount":21,"name":"Додаткові питання щодо категорій ВЕ, С1Е, СЕ, D1E, DE (загальні)"},{"id":"4d0698da-b62b-4d1e-bc65-e9346557deba","number":"57","testsCount":5,"name":" Додаткові питання щодо категорій ВЕ, С1Е, СЕ, D1E, DE (будова і терміни)"},{"id":"9db19a1a-1f93-4197-b5c1-71c094823786","number":"58","testsCount":3,"name":"Додаткові питання щодо категорій BE, C1E, CE,  D1E, DE (юридична відповідальність)"},{"id":"fafee50c-7be5-486f-a0b8-47e088931168","number":"59","testsCount":15,"name":" Додаткові питання щодо категорій ВЕ, С1Е, СЕ, D1E, DE (безпека)"}]';
$tickets = json_decode($json,true);

foreach ($tickets as $ticket) {
		$modx->db->query('INSERT INTO `new_question_theme` SET 
		`number` = "'.$modx->db->escape(trim($ticket['number'])).'",
		`name` = "'.$modx->db->escape(trim($ticket['name'])).'",
		`hash` = "'.$modx->db->escape(trim($ticket['id'])).'"


	');
}
*/

//парс по билетам

/*
$json = '[{"id":"9cbfb1cf-fc2b-428d-b0b2-57d376e5edd0","number":1,"testsCount":19,"name":"Білет №1"},{"id":"a9683d26-1df7-4d9b-a5bd-42eafe3dc21c","number":2,"testsCount":19,"name":"Білет №2"},{"id":"c60459a9-2a34-4fee-809e-9c75dd62bdbe","number":3,"testsCount":19,"name":"Білет №3"},{"id":"f7b77ba4-f16f-4476-9cb1-66c9b2097388","number":4,"testsCount":19,"name":"Білет №4"},{"id":"aacd5e0e-d504-4f59-9bac-74a4873ded40","number":5,"testsCount":20,"name":"Білет №5"},{"id":"7ef4c23e-2707-4af1-92f1-6e6d23df2564","number":6,"testsCount":18,"name":"Білет №6"},{"id":"dd7a29b2-4ca1-4588-995c-e0c3147c19e7","number":7,"testsCount":19,"name":"Білет №7"},{"id":"6607f42a-e0b3-4299-9219-a9ab7ec32242","number":8,"testsCount":19,"name":"Білет №8"},{"id":"8d20ce0b-6d06-4e9f-9cd7-80423040f072","number":9,"testsCount":19,"name":"Білет №9"},{"id":"0dbb6eaf-5408-4ef1-acdc-3ae79e0b9501","number":10,"testsCount":20,"name":"Білет №10"},{"id":"cefb0067-e534-4e4b-b73e-ddec2b4b35de","number":11,"testsCount":20,"name":"Білет №11"},{"id":"0ebcc234-e009-4a5b-b849-76be79779e25","number":12,"testsCount":18,"name":"Білет №12"},{"id":"d4f5d594-8602-4537-b38f-9e96a18eae92","number":13,"testsCount":20,"name":"Білет №13"},{"id":"3b462be3-edbf-4004-b50b-cd96c77f9be0","number":14,"testsCount":20,"name":"Білет №14"},{"id":"be679035-5446-4e53-9227-38291c7ba94d","number":15,"testsCount":19,"name":"Білет №15"},{"id":"bee1164a-bbd0-45b9-a093-c03e69978e19","number":16,"testsCount":19,"name":"Білет №16"},{"id":"67e5074e-1a9e-4f8f-9b1b-1e9638f253b4","number":17,"testsCount":20,"name":"Білет №17"},{"id":"b3d826c2-452e-41a5-864a-1997e6a18464","number":18,"testsCount":18,"name":"Білет №18"},{"id":"b5d05ecb-4cd9-495f-9d3f-db5d7c49781f","number":19,"testsCount":20,"name":"Білет №19"},{"id":"ba726795-95b8-4614-aa03-db86da505b60","number":20,"testsCount":20,"name":"Білет №20"},{"id":"57507227-d929-4bde-bb7c-9d2da6a07656","number":21,"testsCount":20,"name":"Білет №21"},{"id":"98b22a23-b4a5-4f1f-8211-534cd3d5cb16","number":22,"testsCount":19,"name":"Білет №22"},{"id":"00686e4d-61af-4ea1-8a85-742d993e8cee","number":23,"testsCount":20,"name":"Білет №23"},{"id":"ca6536a2-86d9-4b38-9bdb-94a1b2eec1da","number":24,"testsCount":17,"name":"Білет №24"},{"id":"424ea6eb-580f-419e-8bf8-1a01bb7869a7","number":25,"testsCount":19,"name":"Білет №25"},{"id":"69f1a7bd-553e-4ba2-9c9f-2888f63e0d57","number":26,"testsCount":20,"name":"Білет №26"},{"id":"db44f794-e7d5-4c03-bb65-3ee39ab6e73a","number":27,"testsCount":20,"name":"Білет №27"},{"id":"29f1d7f3-281e-47cf-a018-b042b8a28764","number":28,"testsCount":18,"name":"Білет  №28"},{"id":"1f7115ee-ba4a-4bfd-8aa6-4748d5d0c631","number":29,"testsCount":20,"name":"Білет №29"},{"id":"3bb86657-4409-4da9-8e25-3be8394a4c5b","number":30,"testsCount":20,"name":"Білет №30"},{"id":"34b02ff8-8b19-46b7-b909-57cec78415d9","number":31,"testsCount":20,"name":"Білет №31"},{"id":"a4611aa2-a396-40f2-8e67-28932bd6e43a","number":32,"testsCount":19,"name":"Білет №32"},{"id":"20da0555-2a00-4bbc-a8e7-f7f0e77521e6","number":33,"testsCount":17,"name":"Білет №33"},{"id":"fddb31d8-b937-4aeb-acdb-364cf309c5e1","number":34,"testsCount":19,"name":"Білет №34"},{"id":"4bddcf1e-7ca6-4925-8700-74c21bdff8b8","number":35,"testsCount":19,"name":"Білет №35"},{"id":"ec99d33e-0ba7-47cb-bab0-b76361ac5483","number":36,"testsCount":18,"name":"Білет №36"},{"id":"c9d45da7-802e-4667-8b37-e5ff036f3d18","number":37,"testsCount":20,"name":"Білет №37"},{"id":"4143409d-d3d3-41ca-9c09-dbab153d04ff","number":38,"testsCount":20,"name":"Білет №38"},{"id":"148eccd9-5ab6-454c-901a-40e4344f8f2c","number":39,"testsCount":20,"name":"Білет №39"},{"id":"58e3ec0b-1c24-486d-999c-07e3b233466d","number":40,"testsCount":20,"name":"Білет №40"}]';
$tickets = json_decode($json,true);

foreach ($tickets as $ticket) {
		$modx->db->query('INSERT INTO `new_question_ticket` SET 
		`number` = "'.$modx->db->escape(trim($ticket['number'])).'",
		`name` = "'.$modx->db->escape(trim($ticket['name'])).'",
		`hash` = "'.$modx->db->escape(trim($ticket['id'])).'"


	');
}
*/
/*

https://api.romdomdom.in.ua/api/v1/trafficrulestests/3ef50b5a-a142-41fd-8d32-29e0e0ed9ba0/rightanswer - результаты

https://api.romdomdom.in.ua/api/v1/trafficrulestests/ticketid/9cbfb1cf-fc2b-428d-b0b2-57d376e5edd0 - вопросы по билетам


https://api.romdomdom.in.ua/api/v1/trafficrulestests/licensecategoryid/97dbda2f-3501-4bde-bc96-75cabd4dba16/chapterid/e70491d2-2f5c-4bfc-9fb5-9c5e187a15fc	- по разделам 
*/
/*
$token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjViMzRmOTY2LWE1YTItNGRiYi1hMmEwLWEzOGNmMjY1MzBmMyIsInJvbGUiOiJTdHVkZW50IiwidXNlck5hbWUiOiJ4ZnJpa3N4QGdtYWlsLmNvbSIsImFjY291bnRMYW5ndWFnZSI6IlVrIiwic3ViIjoieGZyaWtzeEBnbWFpbC5jb20iLCJqdGkiOiJmOTc5MGNlYi0wZjY1LTRmZWQtOTIzMi1iMDU2MmFmZjNlYzgiLCJlbWFpbCI6Inhmcmlrc3hAZ21haWwuY29tIiwibmJmIjoxNjk2MTgyMDE4LCJleHAiOjE2OTYxODIzMTgsImlhdCI6MTY5NjE4MjAxOCwiaXNzIjoiY2UxYTE4ZDItNjBhZC00MjU3LWJhODgtMjNkMWMxYzkzYzFkIiwiYXVkIjoiMzRkMzljMjItYmVkZi00MGFjLTkzMWYtMTk3NjVhMzllNjllIn0.19UPysDyDX79WPHv1pn-PXOwJ9ikmM6U2BnTMSxXjwc';

$q = $modx->db->query('SELECT * FROM `new_question_theme` WHERE parsed = "0" LIMIT 1');

while ($r = $modx->db->getRow($q)) {


	$ticketid = $r['hash'];

	$url = 'https://api.romdomdom.in.ua/api/v1/trafficrulestests/licensecategoryid/97dbda2f-3501-4bde-bc96-75cabd4dba16/chapterid/'.$ticketid;

    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	$headers = array(
	'authority: api.romdomdom.in.ua',
	'path: /api/v1/trafficrulestests/licensecategoryid/97dbda2f-3501-4bde-bc96-75cabd4dba16/chapterid/'.$ticketid,
	'appid: 5b34f966-a5a2-4dbb-a2a0-a38cf26530f3',
	'authorization: '.$token,
	'origin: https://romdomdom.in.ua',
    'referer: https://romdomdom.in.ua/'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36");
    $result = curl_exec($ch);
    curl_close ($ch);

    if($result AND $result != ''){

	    $array = json_decode($result,true);



	    foreach ($array as $key => $q) {
	    	$answers = json_encode($q['questionAnswers']);


	    	if($q['imagePath'] != ''){
	    		$img = 'https://romdomdom-prod.s3.eu-central-1.amazonaws.com'.$q['imagePath'];
	    	}else{
	    		$img = '';
	    	}

	    	$modx->db->query('INSERT INTO `new_question` 
	    		SET 
	    		hash = "'.$modx->db->escape($q['id']).'",
	    		number = "'.$modx->db->escape($q['number']).'",
	    		image = "'.$modx->db->escape($img).'",
	    		question = "'.$modx->db->escape($q['question']).'",
	    		answers = "'.$modx->db->escape($answers).'"

			');
			$id = $modx->db->getInsertId();


			$modx->db->query('INSERT INTO `new_question_2_theme` SET 
		    		question_id = "'.$modx->db->escape($id).'",
		    		theme_id = "'.$modx->db->escape($r['id']).'",
		    		position = "'.$modx->db->escape($key).'"
			');


	    }

	    $modx->db->query('UPDATE `new_question_theme` SET parsed = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    	echo 'ok';
    	die;
	}else{
		echo "error";
	}








}

die;
*/

/*
$token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjViMzRmOTY2LWE1YTItNGRiYi1hMmEwLWEzOGNmMjY1MzBmMyIsInJvbGUiOiJTdHVkZW50IiwidXNlck5hbWUiOiJ4ZnJpa3N4QGdtYWlsLmNvbSIsImFjY291bnRMYW5ndWFnZSI6IlVrIiwic3ViIjoieGZyaWtzeEBnbWFpbC5jb20iLCJqdGkiOiIyMmNlNGVmNi01Nzc1LTQxYjYtOTBkMC03Nzg3OTdiYzk5ZGQiLCJlbWFpbCI6Inhmcmlrc3hAZ21haWwuY29tIiwibmJmIjoxNjk2MTgyMzMyLCJleHAiOjE2OTYxODI2MzIsImlhdCI6MTY5NjE4MjMzMiwiaXNzIjoiY2UxYTE4ZDItNjBhZC00MjU3LWJhODgtMjNkMWMxYzkzYzFkIiwiYXVkIjoiMzRkMzljMjItYmVkZi00MGFjLTkzMWYtMTk3NjVhMzllNjllIn0.HXEZsx64cV_PaMXo8ONpbzBvl0k16Lx3Yg2sZcE5rpk';


$q = $modx->db->query('SELECT * FROM `new_question_ticket` WHERE parsed = "0" LIMIT 1');

while ($r = $modx->db->getRow($q)) {


	$ticketid = $r['hash'];

	$url = 'https://api.romdomdom.in.ua/api/v1/trafficrulestests/ticketid/'.$ticketid;

    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	$headers = array(
	'authority: api.romdomdom.in.ua',
	'path: /api/v1/trafficrulestests/ticketid/97dbda2f-3501-4bde-bc96-75cabd4dba16/chapterid/'.$ticketid,
	'appid: 5b34f966-a5a2-4dbb-a2a0-a38cf26530f3',
	'authorization: '.$token,
	'origin: https://romdomdom.in.ua',
    'referer: https://romdomdom.in.ua/'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36");
    $result = curl_exec($ch);
    curl_close ($ch);

    if($result AND $result != ''){

	    $array = json_decode($result,true);


	    foreach ($array as $key => $q) {
	    

	    	$q_search = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question` WHERE hash = "'.$modx->db->escape($q['id']).'" LIMIT 1'));
	    	if($q_search['id'] != ''){
	    		$modx->db->query('INSERT INTO `new_question_2_ticket` SET
		    		question_id = "'.$modx->db->escape($q_search['id']).'",
		    		ticket_id = "'.$modx->db->escape($r['id']).'",
		    		position = "'.$modx->db->escape($key).'"
	    		');
	    	}
	    	

	    }

	    $modx->db->query('UPDATE `new_question_ticket` SET parsed = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
    	echo 'ok';
    	die;
	}else{
		echo "error";
	}








}

*/

/*
$token = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjViMzRmOTY2LWE1YTItNGRiYi1hMmEwLWEzOGNmMjY1MzBmMyIsInJvbGUiOiJTdHVkZW50IiwidXNlck5hbWUiOiJ4ZnJpa3N4QGdtYWlsLmNvbSIsImFjY291bnRMYW5ndWFnZSI6IlVrIiwic3ViIjoieGZyaWtzeEBnbWFpbC5jb20iLCJqdGkiOiJiNTAwMzJkYi02YjQ3LTQ5MTktYTJjYS1jNDZmYjQ2NmI3YjMiLCJlbWFpbCI6Inhmcmlrc3hAZ21haWwuY29tIiwibmJmIjoxNjk2MTgzMDcwLCJleHAiOjE2OTYxODMzNzAsImlhdCI6MTY5NjE4MzA3MCwiaXNzIjoiY2UxYTE4ZDItNjBhZC00MjU3LWJhODgtMjNkMWMxYzkzYzFkIiwiYXVkIjoiMzRkMzljMjItYmVkZi00MGFjLTkzMWYtMTk3NjVhMzllNjllIn0.R4NbhzpW4z1q5kDY6jgPUjssRaA9qNL6KJ3r24ISHd4';


$q = $modx->db->query('SELECT * FROM `new_question` WHERE parsed = "0" ORDER BY id ASC LIMIT 100');

while ($r = $modx->db->getRow($q)) {


	$question_id = $r['hash'];

	$url = 'https://api.romdomdom.in.ua/api/v1/trafficrulestests/'.$question_id.'/rightanswer';

    $ch     = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
	$headers = array(
	'authority: api.romdomdom.in.ua',
	'path: /api/v1/trafficrulestests/'.$question_id.'/rightanswer',
	'appid: 5b34f966-a5a2-4dbb-a2a0-a38cf26530f3',
	'authorization: '.$token,
	'origin: https://romdomdom.in.ua',
    'referer: https://romdomdom.in.ua/'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/109.0.0.0 Safari/537.36");
    $result = curl_exec($ch);
    curl_close ($ch);
    if($result AND $result != ''){

	    $answers = json_decode($r['answers'],true);
	    $correct = 99;
	    foreach ($answers as $key => $value) {

	    	if($result == $value['id']){
	    		$correct = $key;
	    	}
	    }


	    if($correct != '99'){
	    	$modx->db->query('UPDATE `new_question` SET parsed = "1", correct = "'.$modx->db->escape($correct).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
	    }


	    //
    	echo 'ok';
	}else{
		echo "error";
	}








}


*/

// парс фоточек


/*
$q = $modx->db->query('SELECT * FROM `new_question` WHERE parsed = "1" AND image != "" ORDER BY id ASC LIMIT 100');

while ($r = $modx->db->getRow($q)) {



	$image = $r['image'];
	$exp_n = explode('/', $image);
	$folder = MODX_BASE_PATH.'assets/images/';
	$pre_f = 'pdr/tests/';

    $image_new = '/'.$pre_f.end($exp_n);
    $res = copy($r['image'], $folder.$pre_f.end($exp_n));
    if($res){
	    $modx->db->query('UPDATE `new_question` SET 
	    	image_new = "/assets/images'.$modx->db->escape($image_new).'",
	    	parsed = "0"
	    	WHERE id = "'.$modx->db->escape($r['id']).'"
	    	');
	}else{
		var_dump($r['id']);die;
	}






}
*/

	die;
?>



