<?php
$parts = explode("/", $_GET['q']);
if (end($parts) == "") unset($parts[count($parts) - 1]);
require_once MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);
switch ($modx->event->name) {
  case "OnWebPageInit":
  case "OnPageNotFound":
    if($_GET['message'] != ''){
      switch($_GET['message']){
        case "recovery_success":
          $message = 'Вашу особу підтверджено! Змінити пароль ви можете в особистому кабінеті розділ "Змінити пароль"';
        break;
        case "reg_success":
          $message = 'Ваш акаунт успішно активовано! Приємного користування!';
        break;
      }
      $modx->setPlaceholder('message', $modx->parseDocumentSource($modx->parseChunk('tpl_message', array('message' => $message),'[+','+]')));
    }
    $modx->config['lang'] = 'ua';
    $_SESSION['lang'] = 'ua';
    if($modx->documentIdentifier == '162' AND $_SESSION['promocode'] == '' AND $modx->config['firstlessonpromo'] != ''){
      $_GET['promocode'] = $modx->config['firstlessonpromo'];
    }


    if($_GET['promocode'] != ''){
      $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($_GET['promocode']).'" AND available = "1" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
        $_SESSION['promocode'] = $_GET['promocode'];
      }
    }


    $modx->config['site_url_b'] = substr($modx->config['site_url'], 0, -1);

    //Редирект с заглавных на обычные url
    if($_GET['q'] != strtolower($_GET['q'])){
      $request_url = explode('?',$_SERVER['REQUEST_URI']);
      if($request_url[1] != ''){
        $get_params = '?'.$request_url[1];
      }
      $modx->sendRedirect($modx->config['site_url'].strtolower($_GET['q']).$get_params,0,'REDIRECT_HEADER','HTTP/1.1 301 Moved Permanently');
      die;
    }

    if(!isset($_SESSION['webuserid']) AND $_SESSION['webuserid'] == '' AND isset($_COOKIE['remember']) AND $_COOKIE['remember'] != ''){
      $check_user = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE sessionid = "'.$modx->db->escape($_COOKIE['remember']).'" LIMIT 1');
      if($modx->db->getRecordCount($check_user) > 0){
        $user_info = $modx->db->getRow($check_user);
        $modx->runSnippet("Auth", Array("email" => $user_info['email'], "autologin" => true));  
      }
    }



    if(isset($_GET['ref'])){
      $_SESSION['utm']['ref'] = $_GET['ref'];
    }
    if(isset($_GET['utm_source'])){
      $_SESSION['utm']['utm_source'] = $_GET['utm_source'];
    }
    if(isset($_GET['utm_medium'])){
      $_SESSION['utm']['utm_medium'] = $_GET['utm_medium'];
    }
    if(isset($_GET['utm_campaign'])){
      $_SESSION['utm']['utm_campaign'] = $_GET['utm_campaign'];
    }
    if(isset($_GET['utm_content'])){
      $_SESSION['utm']['utm_content'] = $_GET['utm_content'];
    }
    if(isset($_GET['utm_term'])){
      $_SESSION['utm']['utm_term'] = $_GET['utm_term'];
    }

    $currency = explode("|", $modx->config['shop_curr_code']);
    $signs    = explode("|", $modx->config['shop_curr_sign']);
    $_SESSION['currency']     = isset($_SESSION['currency']) ? $_SESSION['currency'] : $modx->config['shop_curr_default_code'];
    $modx->config['currcode'] = in_array($_SESSION['currency'], $currency) ? $_SESSION['currency'] : $modx->config['shop_curr_default_code'];
    $modx->config['currency'] = $signs[array_search($_SESSION['currency'], $currency)];
    
    if (!is_array($_SESSION['favorite'])) $_SESSION['favorite'] = Array();  
    if (!is_array($_SESSION['favorite_instructor'])) $_SESSION['favorite_instructor'] = Array();   

    // обработчик ajax запросов
    if (strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      require MODX_BASE_PATH . "/assets/shop/plugin.ajax.php";
      die;
    }
    // обработчик входящих данных с форм
    require MODX_BASE_PATH . "/assets/shop/plugin.data.php";



    if ("failed" != $modx->getPlaceholder("error")){
      $lp = basename(parse_url($_GET['q'], PHP_URL_PATH));
      $virtual_q = $modx->db->query('SELECT * FROM `modx_a_virtual` WHERE url = "'.$modx->db->escape($lp).'" LIMIT 1');
      if($modx->db->getRecordCount($virtual_q) > 0){
        $virtual_r = $modx->db->getRow($virtual_q);
        switch($virtual_r['type']){
          case "1":
            $modx->sendForward('118');
            die;
          break;
          case "2":
            $modx->sendForward('193');
            die;
          break;
        }
      }
    }

    if (isset($js)) $modx->regClientScript('<script>$(document).ready(function(){'.$js.'});</script>');


  break;
  case "OnLoadWebDocument":

    //Захист сторінки інструктора
    if ($modx->documentIdentifier == 187 AND $_SESSION['webuser']['cabinet_type'] != 1) {
      $modx->setPlaceholder('error', 'failed');
      $modx->sendErrorPage();
      die;
    }


    switch($modx->documentIdentifier){
      case "89":

        if($_GET['test'] == 'new'){
          $newTemplateId = 119;
          $templateContent = $modx->db->getValue($modx->db->select('content', $modx->getFullTableName('site_templates'), "id = {$newTemplateId}"));
          $modx->documentContent = $templateContent;

        }
      break;
      case "187":
        //instructor
        if($_SESSION['webuser']['cabinet_type'] != '1'){

            $modx->sendForward('3');
            die;
        }
      break;
      case "199":
        //manager
        if($_SESSION['webuser']['cabinet_type'] != '2'){

            $modx->sendForward('3');
            die;
        }
      break;
      case "469":
        //supermanager
        if($_SESSION['webuser']['cabinet_type'] != '3'){

            $modx->sendForward('3');
            die;
        }
      break;
      case "193":
        $lp = basename(parse_url($_GET['q'], PHP_URL_PATH));
        if($lp != ''){
          $item = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_products` WHERE product_url = "'.$this->db->escape($lp).'" AND product_visible = "1" LIMIT 1'));
        }
        
        if (!is_array($item)) {
          $modx->setPlaceholder('error', 'failed');
          $modx->sendErrorPage();
          die;
        } else {

          $modx->db->query('UPDATE `modx_a_products` SET product_hit = product_hit+1 WHERE product_id = "'.$modx->db->escape($item['id']).'" LIMIT 1');
          
          if($item['product_photo'] != ''){
            $photo = explode(',',$item['product_photo']);
            foreach($photo as $ph){
              $item['product_gallery'] .= $modx->parseChunk('tpl_product_gallery', array('photo' => $ph, 'cnt' => $cnt));
            }
          }


          $item['product_name_seo'] = str_replace('"','',$item['product_name']);
          $item['product_url'] = $modx->makeUrl($modx->documentIdentifier).$item['product_url'].'/';
          $item['product_top'] = $shop->getProductTop($item['product_top']);

          $item['tv_seo_image'] = $item['product_cover'];

          $modx->documentObject = array_merge($modx->documentObject, $item);

          $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_product']));
          $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_product']));

        }

      break;
      case "118":
        $lp = basename(parse_url($_GET['q'], PHP_URL_PATH));
        if($lp != ''){
          if($lp == 'pdrravlik'){
            $instructor = $modx->db->getRow($modx->db->query("SELECT * FROM `modx_a_instructors` WHERE instructor_url = '".$this->db->escape($lp)."' LIMIT 1"));
          }else{
            $instructor = $modx->db->getRow($modx->db->query("SELECT * FROM `modx_a_instructors` WHERE instructor_url = '".$this->db->escape($lp)."' AND status = '1' LIMIT 1"));
          }
        }
        if (!is_array($instructor)) {
          $modx->setPlaceholder('error', 'failed');
          $modx->sendErrorPage();
          die;
        } else {


          $modx->db->query('UPDATE `modx_a_instructors` SET view = view+1 WHERE id = "'.$modx->db->escape($instructor['id']).'" LIMIT 1');
          

          if($instructor['photo'] != ''){
            $photo = explode(',',$instructor['photo']);
            $cnt = 1;
            foreach($photo as $ph){
              $instructor['instructor_gallery'] .= $modx->parseChunk('tpl_instructor_gallery', array('photo' => $ph, 'cnt' => $cnt));
            }
            
          }
          $instructor['transmission_code'] = $instructor['transmission'];
          $instructor['instructor_id'] = $instructor['id'];
          $instructor['type'] = $shop->getTrval('type',$instructor['type']);
          $instructor['transmission'] = $shop->getTrval('transmission',$instructor['transmission']);

          $seot = array();
          if($instructor['lastname'] != ''){
            $seot[] = $instructor['lastname'];
          }
          if($instructor['fullname'] != ''){
            $seot[] = $instructor['fullname'];
          }
          if($instructor['patronymic'] != ''){
            $seot[] = $instructor['patronymic'];
          }
          if($instructor['city'] != ''){
            $instructor['seo_city'] = ' – місто '.$instructor['city'];
          }
          $instructor['wish_status'] = $shop->checkInstructorWish($instructor['id'],$_SESSION['webuser']['internalKey']); 
          
          $instructor['tv_seo_image'] = $instructor['photo'];
          $instructor['seo_title_block'] = implode(' ',$seot);
          $instructor['pagetitle'] = $instructor['seo_title_block'];


          $time = strtotime($instructor['registration_date']);
          $instructor['platform_date'] = $shop->formatDateFrom(time()-$time);
          
          $instructor['stat_lesson'] = '-';
          $instructor['clients'] = '-';
          if($instructor['user_id'] != '0'){
            $rsl = $modx->db->getRow($modx->db->query('SELECT count(s.id) as cnt FROM `modx_a_instructor_schedule` s LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = s.id WHERE s.user_id  = "'.$modx->db->escape($instructor['user_id']).'" AND istr.status = "2" '));
    
            $instructor['stat_lesson'] = $rsl['cnt'];

            $rsc = $modx->db->getRecordCount($modx->db->query('SELECT DISTINCT(client) as cnt FROM `modx_a_instructor_schedule` s LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = s.id WHERE s.user_id = "'.$modx->db->escape($instructor['user_id']).'"  AND istr.status = "2" '));
    
            $instructor['clients'] = $rsc;

            if($instructor['stat_lesson'] == 0){
              $instructor['stat_lesson'] = '-';
            }
            if($instructor['clients'] == 0){
              $instructor['clients'] = '-';
            }

          }
          $instructor['valid_date'] = date('Y-m-d');

          if($_GET['lessons'] != ''){

            if($instructor['school'] != '' AND $instructor['school'] != '0'){
              switch($instructor['transmission_code']){
                case "manual":
                  $search_transmission = ' AND (p.product_transmission = "0" OR p.product_transmission = "1" ) ';
                break;
                case "automatic":
                  $search_transmission = ' AND (p.product_transmission = "0" OR p.product_transmission = "2" ) ';
                break;
                default:
                  $search_transmission = ' AND (p.product_transmission = "0" OR p.product_transmission = "1" OR p.product_transmission = "2" ) ';
                break;
              }
              $lesson_id = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_products` p WHERE p.product_visible = "1" AND p.product_lesson = "1" AND ( product_lesson_type = "1" OR product_lesson_type = "0" )  AND p.product_to_instructor = "1" AND p.product_to_school = "'.$modx->db->escape($instructor['school']).'" '.$search_transmission.' ORDER BY p.product_price ASC LIMIT 1'));
              if($lesson_id['product_id'] != ''){
                $buy_trigger = $modx->parseChunk('tpl_instructor_buy_trigger',array('id' => $lesson_id['product_id']),'[+','+]');
              }
              $modx->setPlaceholder('trigger_js',$buy_trigger);
            }
          }

          $modx->documentObject = array_merge($modx->documentObject, $instructor);

          $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_instructor']));
          $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_instructor']));

        }
      break;
    }
    



    $modx->documentObject['content_b'] = strip_tags($modx->documentObject['content'], '');
    //регистрируем посещение контент страницы
    $modx->db->query('UPDATE `modx_site_content` SET hit = hit+1 WHERE id = "'.$modx->db->escape($modx->documentIdentifier).'" ');

    // устанавливаем знак текущей валюты
    $modx->documentObject['currency'] = $modx->config['shop_curr_default_sign'];


    if($_SESSION['webuser']['internalKey'] != ''){
      $check_usertype = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1'));
      $_SESSION['webuser']['user_type'] = $check_usertype['user_type'];
      $_SESSION['webuser']['user_type_p'] = $check_usertype['user_type_p'];
      $_SESSION['webuser']['subscribedate'] = $check_usertype['subscribedate'];

      switch($check_usertype['user_type']){
        case "0":
          $usertypename = 'Standart';
        break;
        case "1":
          $usertypename = 'Premium';
        break;
      }

    }
    
    // данные о пользователе в сессию
    if (is_array($_SESSION['webuser'])){
      foreach ($_SESSION['webuser'] as $k => $v){
        $modx->documentObject["u_".$k] = $v;
      }
    }


    if(isset($_GET['chapter']) AND $_GET['chapter'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE chapter = "'.$modx->db->escape($_GET['chapter']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = trim(str_replace($r['chapter'].'.','',$r['name']));
        $modx->documentObject['content'] = '';
        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_pdr_chapter']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_pdr_chapter']));
        if(isset($_GET['number']) AND $_GET['number'] != ''){
          $q2 = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE chapter = "'.$modx->db->escape($_GET['chapter']).'" AND number = "'.$modx->db->escape($_GET['number']).'" LIMIT 1');
          if($modx->db->getRecordCount($q2) > 0){
            $r2 = $modx->db->getRow($q2);
            $modx->documentObject['pagetitle'] = $r2['number'].' ПДР - '.trim(str_replace($r['chapter'].'.','',$r['name']));
            $modx->documentObject['content'] = '';
            $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_pdr_chapter_number']));
            $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_pdr_chapter_number']));
          }
        }
      }
    }
    if(isset($_GET['ticket']) AND $_GET['ticket'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_question_ticket` WHERE id = "'.$modx->db->escape($_GET['ticket']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = 'Тест ПДР: '.$r['name'];
        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_test_ticket']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_test_ticket']));
        $modx->documentObject['content'] = '';
      }
    }
    if(isset($_GET['theme']) AND $_GET['theme'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_question_theme` WHERE id = "'.$modx->db->escape($_GET['theme']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = 'Тест ПДР: '.$r['name'];
        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_test_theme']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_test_theme']));
        $modx->documentObject['content'] = '';
        $rozdil = explode('.',$r['number']);
        $check_chapter = $modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE chapter = "'.$modx->db->escape($rozdil[0]).'" LIMIT 1');
        if($modx->db->getRecordCount($check_chapter) > 0){
          $r_chapter = $modx->db->getRow($check_chapter);
          $modx->setPlaceholder('theme_result_learn',$modx->parseChunk('tpl_theme_result_learn',$r_chapter));
        }
      }
    }
    if(isset($_GET['test']) AND $_GET['test'] != ''){
      switch($_GET['test']){
        case "favorite":
          $modx->documentObject['pagetitle'] = 'Тест по вибраних';
        break;
        case "error":
          $modx->documentObject['pagetitle'] = 'Тест по помилкам';
        break;
      }
    }
    if(isset($_GET['signs']) AND $_GET['signs'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE id = "'.$modx->db->escape($_GET['signs']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = $r['name'];
        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_sign']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_sign']));
      }
    }
    if(isset($_GET['markings']) AND $_GET['markings'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE id = "'.$modx->db->escape($_GET['markings']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = $r['name'];
        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_marking']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_marking']));
      }
    }
    if(isset($_GET['sign']) AND $_GET['sign'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE number = "'.$modx->db->escape($_GET['sign']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = 'Знак '.$r['number'].' '.$r['name'];
        $modx->documentObject['content'] = '';

        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_sign']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_sign']));
      }
    }
    if(isset($_GET['marking']) AND $_GET['marking'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE number = "'.$modx->db->escape($_GET['marking']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($q2);
        $modx->documentObject['pagetitle'] = 'Розмітка '.$r['number'].' '.$r['name'];
        $modx->documentObject['content'] = '';
        
        $modx->documentObject['tv_seo_title'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_title_marking']));
        $modx->documentObject['tv_seo_description'] = html_entity_decode($modx->parseDocumentSource($modx->config['seo_description_marking']));
      }
    }
    if(isset($_GET['category']) AND $modx->documentIdentifier == '93'){
      $modx->documentObject['pagetitle'] = $modx->documentObject['pagetitle'].': категорія '.strtoupper($_GET['category']);
    }

    if(isset($_GET['category']) AND $modx->documentIdentifier == '75'){
      $modx->documentObject['pagetitle'] = $modx->documentObject['pagetitle'].': категорія '.strtoupper($_GET['category']);
    }


    if($_GET['hblock'] != ''){
      switch($_GET['hblock']){
        case "nl":
          $hide_block = $modx->getChunk('tpl_hide_block_trigger');

          $modx->setPlaceholder('script_js',$hide_block);
        break;
      }
    }
    

 
  break;
  case "OnCacheUpdate":

    if ($_GET['a'] == 26 && class_exists('Memcache')) {
      
      
      $mem = new Memcache;
      $mem->connect($modx->config['memcache_server'], $modx->config['memcache_port']);  
      $mem->flush();
      $mem->close();
       

    }
  break;
  case "OnManagerAuthentication":
  break;
  default:
    return;
    break;
}
