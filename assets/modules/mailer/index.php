<?php

	define("ROOT", dirname(__FILE__));
	$get            = isset($_GET['get']) ? $_GET['get'] : "";
	$res            = Array();
	$res['version'] = "v 1.0";
	$res['url']     = $table['url'] = $url = "index.php?a=112&id=".$_GET['id']."";
	$res['get']     = $_GET['get'];
	error_reporting(0);


include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);

	switch ($get) {		
		case "preview":
		  $text = str_replace('<img src="', '<img src="'.$modx->config['site_url'], $_REQUEST['text']);
		  $text = str_replace('<a href="', '<a href="'.$modx->config['site_url'], $text);

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_mailer',
            array(
              'inner'             => $text,
              'site_url'          => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])
            )
          );
          $shop->mail($modx->config['emailsender'],$_REQUEST['theme'],$message);

          die;
		break;
		case "fast_view":
		  $text = str_replace('<img src="', '<img src="'.$modx->config['site_url'], $_REQUEST['text']);
		  $text = str_replace('<a href="', '<a href="'.$modx->config['site_url'], $text);
          $message = $modx->parseDocumentSource($modx->parseChunk('mail_mailer',
            array(
              'inner'             => $text,
              'site_url'          => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])
            )
          );
          echo $message;
          die;
		break;
		case "templates":
			switch ($_GET['do']) {
				case "add":
        			$tiny_mce   = $shop->tinyMCE("post_text");	
					$tpl = "/tpl/templates_add.tpl";
				break;
				case "edit":
        			$tiny_mce   = $shop->tinyMCE("post_text");	
					$template = $modx->db->getRow($modx->db->query("select * from `modx_a_mailer_templates` where template_id = ".$_GET['t']));
					$tpl      = "/tpl/template_edit.tpl";
				break;
				default:
					if (isset($_POST['post']) && !isset($_POST['tpl'])) {

					 	$modx->db->query("insert into `modx_a_mailer_templates` set 
											template_subject = '".$modx->db->escape($_POST['theme'])."', 
											template_post    = '".$modx->db->escape($_POST['post'])."'");
					 	$id = $modx->db->getInsertId();
					 	$modx->db->query("insert into `modx_a_mailer` (tpl_id, user_id) select '".$id."' as 'tpl_id', u.user_id from `modx_a_mailer_users` u on duplicate key update user_id = u.user_id");
					 	$res['alert'] = "Шаблон добавлен";
					} elseif (isset($_POST['post']) && isset($_POST['tpl'])) {


					 	$modx->db->query("update `modx_a_mailer_templates` set 
											template_subject  = '".$modx->db->escape($_POST['theme'])."', 
											template_post     = '".$modx->db->escape($_POST['post'])."'
											where template_id = '".$modx->db->escape($_POST['tpl'])."'");
					 	$res['alert'] = "Шаблон обновлен";
					}
					if (isset($_GET['delete'])) {
						$modx->db->query("delete from `modx_a_mailer` where tpl_id = '".$_GET['delete']."'");
						$modx->db->query("delete from `modx_a_mailer_templates` where template_id = '".$_GET['delete']."'");
					 	$res['alert'] = "Шаблон удален";
					}
					$templates = $modx->db->query("select * from `modx_a_mailer_templates` order by template_id desc");
					$tpl       = "/tpl/templates.tpl";
				break;
			}
		break;
		case "config":
			if (count($_POST) > 0) {
				if(!isset($_POST['mailer_smtp_tls'])){
					$_POST['mailer_smtp_tls'] = 0;
				}
				if(!isset($_POST['mailer_smtp_ssl'])){
					$_POST['mailer_smtp_ssl'] = 0;
				}


				foreach ($_POST as $key => $value) 
					$modx->db->query("update `modx_system_settings` set setting_value = '$value' where setting_name = '$key'");
				// empty cache
				include_once MODX_BASE_PATH . "manager/processors/cache_sync.class.processor.php";
				$sync = new synccache();
				$sync->setCachepath(MODX_BASE_PATH . "assets/cache/");
				$sync->setReport(false);
				$sync->emptyCache(); // first empty the cache
				die(header("Location: ".$url."&get=config&i=yes"));
			}
			if (!empty($_GET['i'])) $res['alert'] = "Конфигурация успешно обновлена!";
			$tpl          = "/tpl/config.tpl";
		break;
		case 'add_email':
				$modx->db->query('INSERT INTO `modx_a_mailer_users` SET user_email = "'.$_POST['email'].'", user_name = "'.$_POST['name'].'"');
				header("Location: ".$url."&get=userlist");
		break;
		case 'red':
			$post = $_POST['red'];
			foreach ($post as $key => $value) {
				$modx->db->query('UPDATE `modx_a_mailer_users` SET user_email = "'.$value['user_email'].'" , user_name = "'.$value['user_name'].'" WHERE user_id= "'.$key.'"');
			}
	
			header("Location: ".$url."&get=userlist");
		break;
		case "userlist":
			if (isset($_GET['i']))
				$modx->db->query("insert into `modx_a_mailer_users` (user_email, user_name) select email as 'user_email', fullname as 'user_name' from `modx_web_user_attributes` on duplicate key update user_name = user_name");
			if (isset($_GET['d'])) {
				$modx->db->query("delete from `modx_a_mailer_users` where user_id =".$_GET['d']);
				$res['alert'] = "Пользователь удален из списка рассылки";
			}
			$users = $modx->db->query("select * from `modx_a_mailer_users` order by user_id desc limit 0, 10000");
			$tpl   = "/tpl/userlist.tpl";
			$table['email']   .= '<tr><th>Имя:</th><td><input class="span3" name="name"></input></td></tr>';  
			$table['email']   .= '<tr><th>E-mail:</th><td><input class="span3" name="email"></input></td></tr>';
		break;
		default:
			$stats = $modx->db->query("
						select 
							t.*,
							(select count(*) from `modx_a_mailer` where tpl_id = t.template_id) as 'all',
							(select count(*) from `modx_a_mailer` where tpl_id = t.template_id and mailed = 1) as 'mailed'
						from `modx_a_mailer_templates` t
						order by t.template_date desc
						");
			$tpl   = "/tpl/stat.tpl";
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

