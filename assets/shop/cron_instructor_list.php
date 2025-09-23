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


switch($_GET['action']){

	case "hour":

		//$feed = 'https://script.googleusercontent.com/macros/echo?user_content_key=lzJ3k2ajzVQk7_Uyfac6EkFXqiF9ToWzgLezNe79VaMWwrenwiGy_pP6QP_nm7zwrsuVDeT0S41BFUi1LDmjE_JQw3nV_RJBm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnHx7TMEiGuXBt_9E9uiCxQZ3DcmeuPAm-b20woQ4afXP9XkUvYMlx-cA9il7cSnN_yw36NrFvKs8GM05GLYcz59lOnwZOtit6Q&lib=MPxnI_SzOLW22or7Z9IBNWExzvpP3hh6O';
		//$feed = 'https://script.googleusercontent.com/macros/echo?user_content_key=jFVxI70plWovphIUeIxWRhypECdMMJtQur5RxnZRtmNlH5CFnZ_RyTVAnIDKtGSboV9DoIKRQm8ty81kOsOpS2Q6gjHEJskLm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnHx7TMEiGuXBt_9E9uiCxQZ3DcmeuPAm-b20woQ4afXP9XkUvYMlx-cA9il7cSnN_yw36NrFvKs8GM05GLYcz59lOnwZOtit6QE&lib=MPxnI_SzOLW22or7Z9IBNWExzvpP3hh6O';
		$feed = 'https://script.google.com/macros/s/AKfycbzAoUg2qz2h0jJ3IYf4tOumPnmIKy64c2KmU1FVqo0xJZF6Juj3iBnLBKmv11ZvIOHH/exec';


		$r = json_decode($shop->get_page($feed),true);
		foreach($r as $k => $v){
			if($k > 0){
				$ar = array_values($v);
				if($ar[7] > 0){
					switch($ar[4]){
						default:
						case "Осн":
							$type = '0';
						break;
						case "Доп":
							$type = '1';
						break;
						case "Под":
							$type = '2';
						break;
					}
		    		$phone = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $ar[1]))));
					if(trim($ar[2]) != '' AND $phone != ''){
						$modx->db->query('INSERT IGNORE INTO `modx_a_instructor_to_user` SET 
							row_id = "'.$modx->db->escape(trim($ar[8])).'",
							user_phone = "'.$modx->db->escape(trim($phone)).'",
							user_name = "'.$modx->db->escape(trim($ar[2])).'",
							instructor_name = "'.$modx->db->escape(trim($ar[0])).'",
							lesson_total = "'.$modx->db->escape(trim($ar[3])).'",
							lesson_balance = "'.$modx->db->escape(trim($ar[7])).'",
							user_id = "'.$modx->db->escape(trim($ar[9])).'",
							type = "'.$modx->db->escape($type).'",
							order_school = "122"
						');
					}
				}
			}
		}


	break;
	default:
	case "day":

		//$feed = 'https://script.googleusercontent.com/macros/echo?user_content_key=lzJ3k2ajzVQk7_Uyfac6EkFXqiF9ToWzgLezNe79VaMWwrenwiGy_pP6QP_nm7zwrsuVDeT0S41BFUi1LDmjE_JQw3nV_RJBm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnHx7TMEiGuXBt_9E9uiCxQZ3DcmeuPAm-b20woQ4afXP9XkUvYMlx-cA9il7cSnN_yw36NrFvKs8GM05GLYcz59lOnwZOtit6Q&lib=MPxnI_SzOLW22or7Z9IBNWExzvpP3hh6O';
		//$feed = 'https://script.googleusercontent.com/macros/echo?user_content_key=jFVxI70plWovphIUeIxWRhypECdMMJtQur5RxnZRtmNlH5CFnZ_RyTVAnIDKtGSboV9DoIKRQm8ty81kOsOpS2Q6gjHEJskLm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnHx7TMEiGuXBt_9E9uiCxQZ3DcmeuPAm-b20woQ4afXP9XkUvYMlx-cA9il7cSnN_yw36NrFvKs8GM05GLYcz59lOnwZOtit6QE&lib=MPxnI_SzOLW22or7Z9IBNWExzvpP3hh6O';
		$feed = 'https://script.google.com/macros/s/AKfycbzAoUg2qz2h0jJ3IYf4tOumPnmIKy64c2KmU1FVqo0xJZF6Juj3iBnLBKmv11ZvIOHH/exec';

		$modx->db->query('TRUNCATE `modx_a_instructor_to_user` ');

		$r = json_decode($shop->get_page($feed),true);
		foreach($r as $k => $v){
			if($k > 0){
				$ar = array_values($v);

				if($ar[7] > 0){
					switch($ar[4]){
						default:
						case "Осн":
							$type = '0';
						break;
						case "Доп":
							$type = '1';
						break;
						case "Под":
							$type = '2';
						break;
					}
		    		$phone = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $ar[1]))));

				echo $ar[8].'</br>';
					if(trim($ar[2]) != '' AND $phone != ''){
						$modx->db->query('INSERT IGNORE INTO `modx_a_instructor_to_user` SET 
							row_id = "'.$modx->db->escape(trim($ar[8])).'",
							user_phone = "'.$modx->db->escape(trim($phone)).'",
							user_name = "'.$modx->db->escape(trim($ar[2])).'",
							instructor_name = "'.$modx->db->escape(trim($ar[0])).'",
							lesson_total = "'.$modx->db->escape(trim($ar[3])).'",
							lesson_balance = "'.$modx->db->escape(trim($ar[7])).'",
							user_id = "'.$modx->db->escape(trim($ar[9])).'",
							type = "'.$modx->db->escape($type).'",
							order_school = "122"
						');
					}
				}
					
			}
		}



//		$feed = 'https://script.googleusercontent.com/macros/echo?user_content_key=dhZASztm2MfWD5i4xDrxpF92NxCLfKdNkMgtWu1Locs-8UM0-C4m_O0scAp2oYZIl0SmTpHXYtRTv3FDGrVdfN_R8gudqTM4m5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnBSivBAVbuz8PxERuvv14adm6-wjMwUIjuXOaw1zP32clOY0YySdxKACAXen1vLyfk8vkSJK26TL2_fhcsXl_U1EHz9XbAu58tz9Jw9Md8uu&lib=Mpy2BrHIAUszkUARxF55ENT8Z3PI73CBe';
		//$feed = 'https://script.googleusercontent.com/macros/echo?user_content_key=R8po1gtjOPYDkUcYzfXTrj1gGHjR_bOu50dG1stfLTCYqt9Ev8Auy9V4quftQ7p6v6zRUW_StV4ty81kOsOpS0bFn3CH9PjCm5_BxDlH2jW0nuo2oDemN9CCS2h10ox_1xSncGQajx_ryfhECjZEnBSivBAVbuz8PxERuvv14adm6-wjMwUIjuXOaw1zP32clOY0YySdxKACAXen1vLyfk8vkSJK26TL2_fhcsXl_U1EHz9XbAu58tz9Jw9Md8uuAQ&lib=Mpy2BrHIAUszkUARxF55ENT8Z3PI73CBe';
		$feed = 'https://script.google.com/macros/s/AKfycby232irlZs5mxij6icqu8LkPkjfovQy5wt9rEzxNwGMJxs7m7kjXSNdEGCsMJHxbkQH6g/exec';

		$modx->db->query('TRUNCATE `modx_a_instructor_to_zp` ');

		$r = json_decode($shop->get_page($feed),true);
		foreach($r as $k => $v){
			//if($k > 0){
				$ar = array_values($v);
				if(trim($ar[0]) != ''){
					$modx->db->query('INSERT INTO `modx_a_instructor_to_zp` SET 
						instructor_name = "'.$modx->db->escape(trim($ar[0])).'",
						sum_osn = "'.$modx->db->escape(trim($ar[1])).'",
						sum_dop = "'.$modx->db->escape(trim($ar[2])).'",
						sum_pod = "'.$modx->db->escape(trim($ar[3])).'",
						sum_total = "'.$modx->db->escape(trim($ar[4])).'",
						sum_payd = "'.$modx->db->escape(trim($ar[5])).'",
						sum_need_to_pay = "'.$modx->db->escape(trim($ar[6])).'"
					');
				}
			//}
		}



	break;
}



?>



