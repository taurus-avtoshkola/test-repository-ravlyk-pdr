<?php
/*

*/
	define("ROOT", dirname(__FILE__));
	if($_SESSION['mgrRole'] != 1){die;}
	$get            = isset($_GET['get']) ? $_GET['get'] : "redirect";
	$res            = Array();
	$res['version'] = "v 1.0";
	$res['url']     = $table['url'] = $url = "index.php?a=112&id=".$_GET['id']."";
	$res['get']     = isset($_GET['get']) ? $_GET['get'] : "";

$messages       = Array(
	"exist"  => 'SEO URL вже існує №'.$_GET['n']
	);
	include MODX_BASE_PATH . "assets/shop/shop.class.php";
	$shop = new Shop($modx);
	switch ($get) {

		case "seotext":
			switch ($_REQUEST['action']) {
				case 'publish':
			        $tiny_mce = $shop->tinyMCE("seotext");

					$tpl = '/tpl/seotext_create.tpl';
				break;
				case 'edit':
			        $tiny_mce   = $shop->tinyMCE("seotext");
					$seotext = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_seo2url` WHERE seo_id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
					$tpl = '/tpl/seotext_update.tpl';
				break;
				case 'create':
					$urls = str_replace($modx->config['site_url'],'/',$_POST['add']['seo_url']);
					$check = $modx->db->query('SELECT * FROM `modx_a_seo2url` WHERE seo_url = "'.$modx->db->escape($urls).'" LIMIT 1');
					if($modx->db->getRecordCount($check) > 0){
						$check_r = $modx->db->getRow($check);
						$n = $check_r['seo_id'];
						header("Location: ".$url."&get=seotext&w=exist&n=".$n);die;
					}else{

						$modx->db->query("insert into `modx_a_seo2url` set 
																seo_url         = '".$modx->db->escape($urls)."', 
																seo_pagetitle   = '".$modx->db->escape($shop->m_entities($_POST['add']['seo_pagetitle']))."', 
																seo_title       = '".$modx->db->escape($shop->m_entities($_POST['add']['seo_title']))."', 
																seo_description = '".$modx->db->escape($shop->m_entities($_POST['add']['seo_description']))."', 
																seo_content     = '".$modx->db->escape($shop->m_entities($_POST['add']['seo_content']))."'

											");
						header("Location: ".$url."&get=seotext");die;
					}

				break;
				case 'update':
					$urls = str_replace($modx->config['site_url'],'/',$_POST['edit']['seo_url']);

					$modx->db->query("update `modx_a_seo2url` set 
									seo_url     	= '".$modx->db->escape($urls)."',  
									seo_pagetitle   = '".$modx->db->escape($shop->m_entities($_POST['edit']['seo_pagetitle']))."', 
									seo_title       = '".$modx->db->escape($shop->m_entities($_POST['edit']['seo_title']))."', 
									seo_description = '".$modx->db->escape($shop->m_entities($_POST['edit']['seo_description']))."', 
									seo_content     = '".$modx->db->escape($shop->m_entities($_POST['edit']['seo_content']))."'
									where seo_id 	= '".$modx->db->escape($_POST['edit']['seo_id'])."'");




					header("Location: ".$url."&get=seotext");die;
				
				break;
				case 'delete':
					$modx->db->query("delete from `modx_a_seo2url` where seo_id = '".$_GET['i']."'");
					header("Location: ".$url."&get=seotext");die;
				break;
				default:
					$seotext = $modx->db->query("select * from `modx_a_seo2url` order by seo_id desc");
					$tpl = '/tpl/seotext.tpl';
				break;
			}			
		break;
		case "sitemap":
			if (isset($_POST['post'])) {
				file_put_contents(ROOT."/sitemap.php", $_POST['post']);
				$res['alert'] = 'Алгоритм обновлен';
			}
			if ($_GET['do'] == "reconstruct"){

		        $algoritm = MODX_BASE_PATH . "assets/modules/seo/sitemap.php";
		        if (file_exists($algoritm)) {
		            ob_start();
		            include $algoritm;
		            $xml = ob_get_contents();
		            ob_end_clean();
		            file_put_contents(MODX_BASE_PATH . "/sitemap.xml", $xml);
					$res['alert'] = 'Файл sitemap.xml обновлен';
		        }

			}
			$tpl = "/tpl/sitemap.tpl";
		break;
		case "imagemap":
			if (isset($_POST['post'])) {
				file_put_contents(ROOT."/imagemap.php", $_POST['post']);
				$res['alert'] = 'Алгоритм обновлен';
			}
			if ($_GET['do'] == "reconstruct"){

		        $algoritm = MODX_BASE_PATH . "assets/modules/seo/imagemap.php";
		        if (file_exists($algoritm)) {
		            ob_start();
		            include $algoritm;
		            $xml = ob_get_contents();
		            ob_end_clean();
		            file_put_contents(MODX_BASE_PATH . "/sitemap-images.xml", $xml);
					$res['alert'] = 'Файл sitemap.xml обновлен';
		        }


			}
			$tpl = "/tpl/imagemap.tpl";
		break;
		case "robots":
			if (isset($_POST['post'])) {
				file_put_contents($_SERVER['DOCUMENT_ROOT']."/robots.txt", $_POST['post']);
				$res['alert'] = 'Файл robots.txt обновлен';
			}
			$tpl = "/tpl/robots.tpl";
		break;
		case "counters":
			if (count($_POST) > 0) {
				foreach ($_POST as $k => $v) 
					$modx->db->query("update `modx_system_settings` set setting_value = '".$modx->db->escape($v)."' where setting_name = '$k'");
				$res['alert'] = 'Настройки обновлены';
				include_once MODX_MANAGER_PATH . "processors/cache_sync.class.processor.php";
				$sync = new synccache();
				$sync->setCachepath(MODX_BASE_PATH . "assets/cache/");
				$sync->setReport(false);
				$sync->emptyCache(); // first empty the cache
				$modx->getSettings();
				header("Location: ".$url."&get=counters");
				die;
			}
			$tpl = "/tpl/counters.tpl";
		break;
		case "template":
			if (count($_POST['config']) > 0) {
				foreach ($_POST['config'] as $k => $v) 
					$modx->db->query("update `modx_system_settings` set setting_value = '".$modx->db->escape($v)."' where setting_name = '$k'");
				$res['alert'] = 'Настройки обновлены';
				include_once MODX_MANAGER_PATH . "processors/cache_sync.class.processor.php";
				$sync = new synccache();
				$sync->setCachepath(MODX_BASE_PATH . "assets/cache/");
				$sync->setReport(false);
				$sync->emptyCache(); // first empty the cache
				$modx->getSettings();
				header("Location: ".$url."&get=template");
				die;
			}
			$tpl = "/tpl/template.tpl";
		break;
		case "seo_brand":
			if(isset($_GET['i'])){
				$ids = $modx->getChildIds($_GET['i']);
				$ids[] = $_GET['i'];
				$all_ids = implode(',',array_values($ids));
				$pagetitle = $modx->db->getRow($modx->db->query('SELECT pagetitle FROM `modx_site_content` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
				$brands = $modx->db->makeArray($modx->db->query('SELECT DISTINCT(v.val) AS "value", v.value_id AS "value_id"
		            FROM `modx_a_pro2val` p 
		              JOIN `modx_a_values` v ON v.value_id = p.value_id
		              JOIN `modx_a_products` ap ON ap.product_id = p.product_id
		            WHERE ap.product_visible = 1 AND p.filter_id = "18" AND p.product_id IN (select product_id FROM `modx_a_pro2cat` WHERE modx_id IN ('.$modx->db->escape($all_ids).'))'));
				$tpl = "/tpl/seo_brand_edit.tpl";
			}else{
				$categories = $modx->db->makeArray($modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "5" ORDER BY menuindex ASC'));
				$tpl = "/tpl/seo_brand.tpl";
			}
		break;
		case "redirect":
			if (isset($_GET['delete'])){
				$modx->db->query("delete from `modx_a_redirect` where redirect_id = '".$_GET['delete']."'");
			}



			if (isset($_POST['add'])) {
				$modx->db->query('INSERT INTO `modx_a_redirect` SET 
					redirect_code   = "'.$modx->db->escape($_POST['add']['code']).'",
					redirect_source = "'.$modx->db->escape($_POST['add']['source']).'",
					redirect_target = "'.$modx->db->escape($_POST['add']['target']).'"
				');
			}
			if (isset($_POST['edit'])){

				$modx->db->query('UPDATE `modx_a_redirect` SET 
					redirect_code     = "'.$modx->db->escape($_POST['edit']['code']).'",
					redirect_source   = "'.$modx->db->escape($_POST['edit']['source']).'",
					redirect_target   = "'.$modx->db->escape($_POST['edit']['target']).'"
					WHERE redirect_id = "'.$modx->db->escape($_POST['edit']['redirect']).'"
				');

			}

			$redirects = $modx->db->query("select * from `modx_a_redirect` order by redirect_id desc limit 2000");
			$tpl = "/tpl/redirect.tpl";
		break;
		case "seo_t":
			switch ($_GET['b']) {
				case 'add':
    				$tiny_mce   = $shop->tinyMCE("content");
					$tpl = "/tpl/seo_t_add.tpl";
				break;
				case 'edit':
    				$tiny_mce   = $shop->tinyMCE("content");
    				$seo = $modx->db->getRow($modx->db->query('select * from `modx_a_seo` where id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
					$tpl = "/tpl/seo_t_edit.tpl";
				break;
				case 'save':
					$modx->db->query("insert into `modx_a_seo` set 
			 						lang            = '".$modx->db->escape($_POST['add']['lang'])."', 
			 						docid    		= '".$modx->db->escape($_POST['add']['docid'])."', 
			 						params    		= '".$modx->db->escape($_POST['add']['params'])."', 
									title           = '".$modx->db->escape($_POST['add']['title'])."', 
									content         = '".$modx->db->escape($_POST['add']['content'])."', 
									seo_title       = '".$modx->db->escape($_POST['add']['seo_title'])."', 
									seo_keywords    = '".$modx->db->escape($_POST['add']['seo_keywords'])."', 
									seo_description = '".$modx->db->escape($_POST['add']['seo_description'])."'
									");

					header("Location: ".$url."&get=seo_t");
					die;
				break;
				case 'update':

					$modx->db->query("update `modx_a_seo` set 
			 						lang            = '".$modx->db->escape($_POST['edit']['lang'])."', 
			 						docid    		= '".$modx->db->escape($_POST['edit']['docid'])."', 
			 						params    		= '".$modx->db->escape($_POST['edit']['params'])."', 
									title           = '".$modx->db->escape($_POST['edit']['title'])."', 
									content         = '".$modx->db->escape($_POST['edit']['content'])."', 
									seo_title       = '".$modx->db->escape($_POST['edit']['seo_title'])."', 
									seo_keywords    = '".$modx->db->escape($_POST['edit']['seo_keywords'])."', 
									seo_description = '".$modx->db->escape($_POST['edit']['seo_description'])."'
									where id = '".$modx->db->escape($_POST['edit']['id'])."'");
					header("Location: ".$url."&get=seo_t");
					die;
				break;
				case 'delete':
					$modx->db->query("delete from `modx_a_seo` where id = '".$_GET['i']."'");
				break;
				default:
					$seo_t = $modx->db->query("select * from `modx_a_seo` order by id desc");
					$tpl = "/tpl/seo_t.tpl";
				break;
			}
		break;
	}
	if (isset($tpl)) {
		ob_start();
		include ROOT . $tpl;
		$res['content'] = ob_get_contents();
		ob_end_clean();
	}
	include ROOT . "/tpl/index.tpl";
	die;
