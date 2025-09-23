<?php
if($_SESSION['mgrRole'] != 1){die;}
define("ROOT", dirname(__FILE__));
define("TPLS", dirname(__FILE__)."/tpl/settings/");
$languages 			= explode(",", $modx->config['lang_list']);

$bootstrap      = isset($_GET['b']) ? $_GET['b'] : "main";

$controller     = isset($_GET['c']) ? $_GET['c'] : "";
$res            = Array();
$res['version'] = "v 1.0";
$res['url']     = $url = "index.php?a=112&id=9&";
$search         = true;
$messages       = Array(
	"updated"  => 'Оновлено'
	);

include MODX_BASE_PATH . "/assets/shop/shop.class.php";
$shop = new Shop($modx);
include MODX_BASE_PATH . "assets/shop/lang/ukrainian.php";

switch ($bootstrap) {
	case "promo":
		switch ($_REQUEST['c']) {
			case 'new':
			  
			   	if($_POST['multicode'] == '1'){
			   		$multicode = 1;
			   	}else{
			   		$multicode = 0;
			   	}
			    if($_POST['promocode'] == ''){
			    	$_POST['promocode'] = $shop->random_promocode();
			    }
				if($_POST['date_start'] != ''){
			    	$date_start = strtotime($_POST['date_start']);
				}
				if($_POST['date_end'] != ''){
			    	$date_end = strtotime($_POST['date_end']);
				}
				$sql = 'INSERT IGNORE INTO `modx_a_promo` SET 
				promocode = "'.$modx->db->escape($_POST['promocode']).'", 
				discount = "'.$modx->db->escape($_POST['discount']).'", 
				multicode = "'.$modx->db->escape($multicode).'",
				date_start = "'.$modx->db->escape($date_start).'",
				date_end = "'.$modx->db->escape($date_end).'"
				';

				$modx->db->query($sql);

				$time = time()+$modx->config['server_offset_time'];
				//вкл промокоди по даті
				$modx->db->query('UPDATE `modx_a_promo` SET available = "1" WHERE date_start <= "'.$modx->db->escape($time).'" AND date_end >= "'.$modx->db->escape($time).'" AND date_start != "" AND date_end  != "" AND available = "0" ');
				//викл промокоди по даті
				$modx->db->query('UPDATE `modx_a_promo` SET available = "0" WHERE (date_start >= "'.$modx->db->escape($time).'" OR date_end <= "'.$modx->db->escape($time).'" ) AND date_start != "" AND date_end  != "" AND available = "1" ');

				
				
				die(header("Location: ".$url."b=promo&w=updated"));
			break;
			case "removepromocode":
				$modx->db->query('DELETE FROM `modx_a_promo` WHERE id = "'.$modx->db->escape($_REQUEST['i']).'" ');
				die(header("Location: ".$url."b=promo&w=updated"));
			break;
			default:
				$promos = $modx->db->makeArray($modx->db->query('SELECT * FROM `modx_a_promo` WHERE 1 = 1'));
				$tpl = "promo.tpl";
			break;
		}
	break;
	case 'payments':
			if (count($_POST) > 0) {
				$key = '1';
				foreach($_POST['upd'] as $key => $value){
					$modx->db->query('UPDATE `modx_a_paysystems` SET 
						shop_payname = "'.$modx->db->escape($_POST['upd'][$key]['shop_payname']).'",
						shop_paysystem = "'.$modx->db->escape($_POST['upd'][$key]['shop_paysystem']).'",
						shop_paymid = "'.$modx->db->escape($_POST['upd'][$key]['shop_paymid']).'",
						shop_paysig = "'.$modx->db->escape($_POST['upd'][$key]['shop_paysig']).'",
						shop_paypass = "'.$modx->db->escape($_POST['upd'][$key]['shop_paypass']).'"
						WHERE pay_id = "'.$modx->db->escape($key).'"
					');
					$modx->db->query('UPDATE `modx_system_settings` SET setting_value = "'.$modx->db->escape(json_encode($_POST['upd'][$key])).'" WHERE setting_name = "'.$modx->db->escape('shop_paysystem_'.$key).'" LIMIT 1');
				}

				if($_POST['new']['shop_payname'] != '' AND $_POST['new']['shop_paymid'] != '' AND $_POST['new']['shop_paysig'] != '' AND $_POST['new']['shop_paysystem'] != ''){

					$modx->db->query('INSERT INTO `modx_a_paysystems` SET 
						shop_payname = "'.$modx->db->escape($_POST['new']['shop_payname']).'",
						shop_paysystem = "'.$modx->db->escape($_POST['new']['shop_paysystem']).'",
						shop_paymid = "'.$modx->db->escape($_POST['new']['shop_paymid']).'",
						shop_paysig = "'.$modx->db->escape($_POST['new']['shop_paysig']).'",
						shop_paypass = "'.$modx->db->escape($_POST['new']['shop_paypass']).'"
					');
					$id = $modx->db->getInsertId();
					$modx->db->query('INSERT INTO `modx_system_settings` SET setting_name = "'.$modx->db->escape('shop_paysystem_'.$id).'", setting_value = "'.$modx->db->escape(json_encode($_POST['new'])).'" ');

				}
				$shop->clearCache();
				die(header("Location: ".$url."b=payments&w=updated"));
	    }
	    $q = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');
		$tpl = "payment.tpl";
	break;
	case "seo":
		if (count($_POST) > 0) {
			/*
			if($_POST['sms_on'] == ''){
				$modx->db->query('UPDATE `modx_system_settings` SET setting_value = "0" WHERE setting_name = "sms_on"');
			}
			*/
			
	    foreach($_POST as $key => $value)
				$modx->db->query("replace into `modx_system_settings` (setting_value, setting_name) values  ('".$modx->db->escape($value)."', '".$key."')");
			$shop->clearCache();
			die(header("Location: ".$url."b=seo&w=updated"));
	    }
		$tpl = "seo.tpl";
	break;
	
	default:
		if (count($_POST) > 0) {
			
			if($_POST['esputnik_subscribe'] == ''){
				$modx->db->query('UPDATE `modx_system_settings` SET setting_value = "0" WHERE setting_name = "esputnik_subscribe"');
			}
			
			
	    foreach($_POST as $key => $value)
				$modx->db->query("replace into `modx_system_settings` (setting_value, setting_name) values  ('".$modx->db->escape($value)."', '".$key."')");
			$shop->clearCache();
			die(header("Location: ".$url."w=updated"));
	    }
		$tpl = "main.tpl";
	break;
}


if (isset($tpl)) {
  ob_start();
  include TPLS . $tpl;
  $res['content'] = ob_get_contents();
  ob_end_clean();
}
switch($_SESSION['mgrRole']){
  case "1":
    include TPLS . "index.tpl";
  break;
  case "5":
    include TPLS . "index_3.tpl";
  break;
  case "6":
    include TPLS . "index_8.tpl";
  break;
}
die;