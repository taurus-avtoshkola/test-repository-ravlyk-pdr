<?php
	define("ROOT", dirname(__FILE__));
	if($_SESSION['mgrRole'] != 1){die;}
	$get            = isset($_GET['get']) ? $_GET['get'] : ($modx->config['lang_enable'] ? "" : "settings");
	$res            = Array();
	$res['version'] = "v 1.0";
	$res['url']     = $table['url'] = $url = "index.php?a=112&id=".$_GET['id']."";
	$res['get']     = $_GET['get'];
	error_reporting(0);
	$get = file_exists(ROOT."/dump.php") ? $get : "settings";
    include MODX_BASE_PATH . 'assets/plugins/translate/translate.class.php';
    $translate = new Translate($modx);
	switch ($get) {
		
		default:
			function update_lang_file () {
			  global $modx;
			  $strings = $modx->db->query("select * from `modx_a_lang` order by lang_id asc");
			  $f       = fopen(ROOT . "/dump.php", "w");
			  fwrite($f, '<?php '."\n".'$l=Array(');
			  while ($string = $modx->db->getRow($strings)) {
			     $write = Array();
			     $list  = explode(",", $modx->config['lang_list']);
			     foreach ($list as $value)
			              $write[] = "'".$value."'=>'".addslashes($string[$value])."'";
			     fwrite  ($f, $string['lang_id']."=>Array(".implode(",", $write)."),");
			  }
			  fwrite($f, ");");
			  fclose($f);
			}		
			$action = isset($_GET['action']) ? $_GET['action'] : "";
			switch ($action) {
			    case "search":
			    	$config = explode(",", $modx->config['lang_list']);
			    	foreach ($config as $key)
			    	         $where[] = $key . " LIKE '%".$_POST['search']."%'";
			    	$items = $modx->db->query("SELECT
			    	                            *
			    	                           FROM `modx_a_lang`
			    	                           WHERE lang_id LIKE '".$_POST['search']."%' OR ".implode(" OR ", $where)."
			    	                           ORDER BY lang_id ASC");
			    	while ($su = $modx->db->getRow($items)) {
			    	       $tmp = '<tr><td><b>'.$su['lang_id'].'</b></td>';
			    	       foreach ($config as $value)
			    	                $tmp .= '<td><input type="text" name="lang['.$su['lang_id'].']['.$value.']" value="'.$su[$value].'" /></td>';
							$tmp    .= '</tr>';
							$result .= $tmp;
			    	}
			    	die( $result );
			    break;
			    case "save":
			    	$config = explode(",", $modx->config['lang_list']);
			    	//die($modx->ex->d($_POST['lang']));
			    	if (is_array($_POST['lang'])) 
			            foreach ($_POST['lang'] as $key => $val) {
			              $update = Array();
			              foreach ($config as $value)
			                       $update[] = $value. " = '".$modx->db->escape($val[$value])."'";
			              $modx->db->query( "update `modx_a_lang` set ".implode(",", $update)." where lang_id = '".$key."'");
			            }
			        update_lang_file();
			    default:
			    	$config = explode(",", $modx->config['lang_list']);
			    	if ($action == "add" && $_SESSION['hash']['tongue']['add'] != md5(serialize($_POST))) {
			    		$_SESSION['hash']['tongue']['add'] = md5(serialize($_POST));
						$data   = Array();
				        foreach ($config as $v)
				                 $data[] = "'".$modx->db->escape($_POST['add'][$v])."'";
				        $modx->db->query("INSERT INTO `modx_a_lang`(`lang_id`, ".$modx->config['lang_list'].") VALUES (null, ".implode(",", $data).")");
				        update_lang_file();
			    	}
			    	// add + thead
			    	foreach ($config as $lng){
			    		$table['thead'] .= '<th>'.$lng.'</th>';
			    		$table['add']   .= '<tr> <td>'.$lng.' вариант</td> <td> <input type="text" name="add['.$lng.']" value="" /> </td></tr>'; 
			    	}
			    	// tbody
					$items          = $modx->db->query("SELECT * FROM `modx_a_lang` ORDER BY lang_id DESC "); 
					$table['tbody'] = "";
					while ($su = $modx->db->getRow($items)) {
					      $tmp = '<tr><td><b>'.$su['lang_id'].'</b></td>';
					      foreach ($config as $key)
					               $tmp .= '<td><input type="text" style="width:95%" name="lang['.$su['lang_id'].']['.$key.']" value="'.$su[$key].'" /></td>';
					      $tmp .= '</tr>';
					      $table['tbody'] .= $tmp;
					}
					$table['col'] = count($config) + 1;
					$subtpl = 'tongue_tpl_translator';
			    break;
			  }
			  $tpl = "/tpl/module_trans.tpl";
		break;
		case "settings":
			if (count($_POST) > 0) {
				/*
				if ($_POST['lang_enable'] == 0) 
					$copy = ROOT . "/htaccess_single";
				else 
					$copy = ROOT . "/htaccess_multi";

				unlink($_SERVER['DOCUMENT_ROOT'] ."/.htaccess");
				copy($copy, $_SERVER['DOCUMENT_ROOT'] ."/.htaccess");
				*/
				foreach ($_POST as $key => $value) $modx->db->query("update `modx_system_settings` set setting_value = '$value' where setting_name = '$key'");


				if ($_POST['lang_list'] != $modx->config['lang_list']) {
					$columns = Array();
					$needed  = Array();
					$fields  = $modx->db->query("describe `modx_site_content`");
					while ($f = $modx->db->getRow($fields))
					    $columns[] = $f['Field'];

					$langs  = explode(",", $_POST['lang_list']);

					foreach ($langs as $lng)
					    if (!in_array("pagetitle_".$lng, $columns))
					        $needed[] = $lng;   
					foreach ($needed as $lng) 
						if (!empty($lng))
					    $modx->db->query("ALTER TABLE `modx_site_content`
					    ADD `pagetitle_".$lng."` 		varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'pagetitle ".$lng." version',
					    ADD `longtitle_".$lng."` 		varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'longtitle ".$lng." version',
					    ADD `description_".$lng."` 		varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'description ".$lng." version',
					    ADD `link_attributes_".$lng."`  varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'link_attributes ".$lng." version',
					    ADD `introtext_".$lng."` 		text COLLATE 'utf8_general_ci' NOT NULL COMMENT 'introtext ".$lng." version',
					    ADD `menutitle_".$lng."` 		varchar(255) COLLATE 'utf8_general_ci' NOT NULL COMMENT 'menutitle ".$lng." version',
					    ADD `content_".$lng."` 			mediumtext COLLATE 'utf8_general_ci' NOT NULL COMMENT 'content ".$lng." version';");	
					
					// dump 
					$columns = Array();
					$needed  = Array();
					$fields  = $modx->db->query("describe `modx_a_lang`");
					while ($f = $modx->db->getRow($fields)) $columns[] = $f['Field'];

					$langs  = explode(",", $_POST['lang_list']);

					foreach ($langs as $lng)
					    if (!in_array($lng, $columns))
					        $needed[] = $lng;   
					foreach ($needed as $lng) 
						if (!empty($lng))
					    	$modx->db->query("ALTER TABLE `modx_a_lang` ADD `".$lng."` text NOT NULL COMMENT '".$lng."'	");
					
				}

				// empty cache
				include_once MODX_MANAGER_PATH . "processors/cache_sync.class.processor.php";
				$sync = new synccache();
				$sync->setCachepath(MODX_BASE_PATH . "assets/cache/");
				$sync->setReport(false);
				$sync->emptyCache(); // first empty the cache
				die(header("Location: ".$url."&get=settings"));
			}
			$tpl = "/tpl/module_settings.tpl";
		break;
		case "about":
		break;
	}
	if (isset($tpl)) {
		ob_start();
		include ROOT . $tpl;
		$res['content'] = ob_get_contents();
		ob_end_clean();
	}
	include ROOT . "/tpl/module_index.tpl";
	die;

