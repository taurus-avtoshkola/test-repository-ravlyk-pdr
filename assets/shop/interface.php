<?php

//error_reporting(E_ALL);
//ini_set('display_errors',1);
if(!defined('IN_MANAGER_MODE') || IN_MANAGER_MODE != 'true') die("Доступ заборонено");
if($_SESSION['mgrRole'] != 1 AND $_SESSION['mgrRole'] != 2 AND $_SESSION['mgrRole'] != 5 AND $_SESSION['mgrRole'] != 6){die;}
define("ROOT", dirname(__FILE__));
define("TPLS", dirname(__FILE__)."/tpl/interface/");
$languages      = explode(",", $modx->config['lang_list']);

$modx->config['site_url_b'] = substr($modx->config['site_url'], 0, -1);
switch($_GET['id']){
  case "8":

    if(!in_array($_SESSION['mgrRole'],array(1))){ die("Доступ заборонено");}
  break;
  case "12":

    if(!in_array($_SESSION['mgrRole'],array(1,5))){ die("Доступ заборонено");}
  break;
  case "13":

    if(!in_array($_SESSION['mgrRole'],array(1,6))){ die("Доступ заборонено");}
  break;
  case "14":
    if(!in_array($_SESSION['mgrRole'],array(1,2))){ die("Доступ заборонено");}
  break;
}
$bootstrap = $_GET['b'];
$res['url']     = $url = "index.php?a=112&id=".$_GET['id']."&";
$controller     = isset($_GET['c']) ? $_GET['c'] : "";
$res            = Array();
$res['version'] = "v 1.0";

$search         = true;
$_SESSION['currency'] = "uah";
$modx->config['lang'] = $modx->config['lang_default'];
$messages       = Array(
  "deleted"     => 'Видалено',
  "added"       => 'Cтворено',
  "updated"     => 'Оновлено',
  "send"        => 'Надіслано'
);

include MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);
include MODX_BASE_PATH . "assets/shop/lang/russian.php";

switch ($bootstrap) {

  case "telegram":

    switch($_GET['c']){
      case "update":
        foreach($_REQUEST['edit'] as $chat_id => $values){
          if($chat_id != ''){
            $modx->db->query('UPDATE `modx_a_telegram` SET telegram_type = "'.$modx->db->escape($values['telegram_type']).'", telegram_notify = "'.$modx->db->escape($values['telegram_notify']).'" WHERE chat_id = "'.$modx->db->escape($chat_id).'" LIMIT 1');
          }
        }

        die(header("Location: ".$url."b=telegram&w=updated"));

      break;
      case "message_all":
        include MODX_BASE_PATH . "assets/shop/telegram.class.php";
        $telegram = new Telegram($modx);

        $modx->config['lang'] = 'ua';
        $_SESSION['lang'] = 'ua';

        $answer = $_REQUEST['new']['message'];
        $q = $modx->db->query('SELECT * FROM `modx_a_telegram` WHERE proved = "1" AND telegram_notify = "1" ');
        while($r = $modx->db->getRow($q)){
          $send_data = array();
          $send_data['text'] = $answer;
          $send_data['chat_id'] = $r['chat_id'];
          $send_data['parse_mode'] = 'MarkdownV2';
          $res = $telegram->sendMessage($send_data);
        }
        die(header("Location: ".$url."b=telegram&w=send"));
      break;
      case "private_message":
        include MODX_BASE_PATH . "assets/shop/telegram.class.php";
        $telegram = new Telegram($modx);

        $modx->config['lang'] = 'ua';
        $_SESSION['lang'] = 'ua';
        //log
        $chat_id = $_REQUEST['new']['chat_id'];
        $answer = $_REQUEST['new']['message'];
        $send_data['text'] = $answer;
        $send_data['chat_id'] = $chat_id;
        $send_data['parse_mode'] = 'MarkdownV2';
        $res = $telegram->sendMessage($send_data);
        die(header("Location: ".$url."b=telegram&w=send"));
      break;
      default: 

        $tg_users  = $shop->getTelegram();
        $modx->setPlaceholder('url', $url."b=telegram&p=");
        $pagin    = $shop->getPaginate(); 
        $tpl = "telegram.tpl";
      break;
    }
  break;
  case "remove_photo":
    if($_REQUEST['photo'] != ''){
      unlink(MODX_BASE_PATH.$_REQUEST['photo']);
    }
    die;
  break;
  case "upload_instuctor":
    $folder =  "assets/files/instructors/personal/";
    $photo_db = array();
    foreach ($_FILES['uploader']['tmp_name'] as $key => $value){
        $photo_name = $folder.preg_replace('/\D+/', '', microtime()).".".end(explode(".", $_FILES['uploader']['name'][$key]));
        $photo_db[] = '/'.$photo_name;
        move_uploaded_file($value, MODX_BASE_PATH.$photo_name);
    }
    $ajax['photos'] = $photo_db;
    die(json_encode($ajax));
  break;
  case "upload":
    $folder =  "assets/images/products/";
    $photo_db = array();
    foreach ($_FILES['uploader']['tmp_name'] as $key => $value){
        $photo_name = $folder.preg_replace('/\D+/', '', microtime()).".".end(explode(".", $_FILES['uploader']['name'][$key]));
        $photo_db[] = '/'.$photo_name;
        move_uploaded_file($value, MODX_BASE_PATH.$photo_name);
    }
    $ajax['photos'] = $photo_db;
    die(json_encode($ajax));
  break;
  case "items":
    switch ($_GET['c']) {
      case "add":
        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');
        // Список категорий к которым можно привязывать товар
        $options = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "94" OR sc.template = "99") AND sc.published = "1" '));

        $autoschool = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "67" OR sc.template = "98") AND sc.published = "1" AND sc.parent = "121" '));


        $tiny_mce   = $shop->tinyMCE("product_description, #product_introtext");
        $title      = "Створити товар";
        $tpl        = "product_add.tpl";
      break;
      case "edit":


        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');

        // Список категорий к которым можно привязывать товар
        $options = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "94" OR sc.template = "99") AND sc.published = "1" '));

        $autoschool = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "67" OR sc.template = "98") AND sc.published = "1" AND sc.parent = "121" '));
        // Данные о товаре
        $product_by_article = $shop->getProduct($_GET['i']);

        $total = $modx->db->getRecordCount($product_by_article);
        $product = $modx->db->makeArray($product_by_article);
      


        $tiny_mce   = $shop->tinyMCE("product_description, #product_introtext");
        $title      = "Редагувати товар";
        $tpl        = "product_edit.tpl";
      break;
      case "create":
        if($_POST['add']['url'] == ''){
          $_POST['add']['url'] = $shop->generateUrl($_POST['add']['product_name'].'-'.$_POST['add']['product_article']);
        }
        $p_url = $_POST['add']['url'];

        //product_cover , product_photo
        $query = "INSERT INTO `modx_a_products` SET
                  product_created        = '".$modx->db->escape(date('Y-m-d H:i:s',time()))."',
                  product_edited         = '".$modx->db->escape(date('Y-m-d H:i:s',time()))."',
                  product_cover          = '".$modx->db->escape($_POST['add']['product_cover'])."',
                  product_photo          = '".$modx->db->escape(implode(',',$_POST['add']['photo']))."',
                  product_position       = '".$modx->db->escape($_POST['add']['product_position'])."',
                  product_name           = '".$modx->db->escape($_POST['add']['product_name'])."',
                  product_description    = '".$modx->db->escape($_POST['add']['product_description'])."',
                  product_introtext      = '".$modx->db->escape($_POST['add']['product_introtext'])."',
                  product_to_school      = '".$modx->db->escape($_POST['add']['product_to_school'])."',
                  product_to_instructor  = '".$modx->db->escape($_POST['add']['product_to_instructor'])."',
                  product_transmission   = '".$modx->db->escape($_POST['add']['product_transmission'])."',
                  product_url            = '".$modx->db->escape($p_url)."',
                  product_top            = '".$modx->db->escape($_POST['add']['product_top'])."',
                  product_amount         = '".$modx->db->escape($_POST['add']['product_amount'])."',
                  product_lesson         = '".$modx->db->escape($_POST['add']['product_lesson'])."',
                  product_lesson_type    = '".$modx->db->escape($_POST['add']['product_lesson_type'])."',
                  product_brand          = '".$modx->db->escape($_POST['add']['product_brand'])."',
                  product_paytype        = '".$modx->db->escape($_POST['add']['product_paytype'])."',
                  product_article        = '".$modx->db->escape($_POST['add']['product_article'])."',
                  product_price          = '".$modx->db->escape($_POST['add']['product_price'])."',
                  product_price_a        = '".$modx->db->escape($_POST['add']['product_price_a'])."',
                  product_visible        = '".$modx->db->escape($_POST['add']['product_visible'])."',
                  product_seo_title      = '".$modx->db->escape($shop->m_entities($_POST['add']['product_seo_title']))."',
                  product_seo_description= '".$modx->db->escape($shop->m_entities($_POST['add']['product_seo_description']))."',
                  product_main_cat       = '".$modx->db->escape($_POST['add']['product_main_cat'])."'
                  ";

        $modx->db->query($query);              

        $id = $modx->db->getInsertId();

        $modx->db->query('INSERT INTO `modx_a_virtual` SET 
          type = "2",
          idv = "'.$modx->db->escape($id).'",
          url = "'.$modx->db->escape($p_url).'"
          ');



        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$id;
        }else{
          $par = '&w=item_updated';
        }
        die(header("Location: ".$url."b=items".$par));
      break;
      case "update":
        if($_POST['edit']['url'] == ''){
          $_POST['edit']['url'] = $shop->generateUrl($_POST['edit']['product_name'].'-'.$_POST['edit']['product_article']);
        }
        $p_url = $_POST['edit']['url'];

        


        //product_cover , product_photo
        $query = "UPDATE `modx_a_products` SET
                  product_edited         = '".$modx->db->escape(date('Y-m-d H:i:s',time()))."',
                  product_cover          = '".$modx->db->escape($_POST['edit']['product_cover'])."',
                  product_photo          = '".$modx->db->escape(implode(',',$_POST['edit']['photo']))."',
                  product_name           = '".$modx->db->escape($_POST['edit']['product_name'])."',
                  product_description    = '".$modx->db->escape($_POST['edit']['product_description'])."',
                  product_introtext      = '".$modx->db->escape($_POST['edit']['product_introtext'])."',
                  product_position       = '".$modx->db->escape($_POST['edit']['product_position'])."',
                  product_to_school      = '".$modx->db->escape($_POST['edit']['product_to_school'])."',
                  product_to_instructor  = '".$modx->db->escape($_POST['edit']['product_to_instructor'])."',
                  product_transmission   = '".$modx->db->escape($_POST['edit']['product_transmission'])."',
                  product_url            = '".$modx->db->escape($p_url)."',
                  product_top            = '".$modx->db->escape($_POST['edit']['product_top'])."',
                  product_amount         = '".$modx->db->escape($_POST['edit']['product_amount'])."',
                  product_lesson         = '".$modx->db->escape($_POST['edit']['product_lesson'])."',
                  product_lesson_type    = '".$modx->db->escape($_POST['edit']['product_lesson_type'])."',
                  product_brand          = '".$modx->db->escape($_POST['edit']['product_brand'])."',
                  product_hit            = '".$modx->db->escape($_POST['edit']['product_hit'])."',
                  product_paytype        = '".$modx->db->escape($_POST['edit']['product_paytype'])."',
                  product_article        = '".$modx->db->escape($_POST['edit']['product_article'])."',
                  product_price          = '".$modx->db->escape($_POST['edit']['product_price'])."',
                  product_price_a        = '".$modx->db->escape($_POST['edit']['product_price_a'])."',
                  product_visible        = '".$modx->db->escape($_POST['edit']['product_visible'])."',
                  product_seo_title      = '".$modx->db->escape($shop->m_entities($_POST['edit']['product_seo_title']))."',
                  product_seo_description= '".$modx->db->escape($shop->m_entities($_POST['edit']['product_seo_description']))."',
                  product_main_cat       = '".$modx->db->escape($_POST['edit']['product_main_cat'])."'
                  WHERE product_id       = '".$modx->db->escape($_POST['edit']['product_id'])."' 
                  ";

        $modx->db->query($query);              

        $id = $_POST['edit']['product_id'];

        $modx->db->query('DELETE FROM `modx_a_virtual` WHERE type = "2" AND idv = "'.$modx->db->escape($id).'" ');

        $modx->db->query('INSERT INTO `modx_a_virtual` SET 
          type = "2",
          idv = "'.$modx->db->escape($id).'",
          url = "'.$modx->db->escape($p_url).'"
        ');

        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$id;
        }else{
          $par = '&w=item_updated';
        }
        die(header("Location: ".$url."b=items".$par));
      break;
      case "delete":
        $shop->deleteProduct ($_GET['i']);
        die(header("Location: ".$url."b=items&p=".$_GET['p']));
      break;
      default:


        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');
        while ($r = $modx->db->getRow($pay_options)){
           $payoptions[$r['pay_id']] = $r['shop_payname'].' ('.$r['pay_id'].')';
        }

        $options = $modx->db->makeArray($modx->db->query('SELECT *, (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE sc.template = "94" AND sc.published = "1" '));
        
        if($_GET['filter'] == '0'){
          unset($_SESSION['items'],$_GET['s'],$_GET['category'],$_GET['orderby'],$_GET['p'],$_GET['moderate'],$_GET['limit']);
          die(header("Location: ".$url."b=items"));
        }

        if(isset($_SESSION['items']) AND $_GET['s'] == '' AND $_GET['category'] == '' AND $_GET['orderby'] == '' AND $_GET['p'] == '' AND $_GET['moderate'] == '' AND $_GET['limit'] == ''){
          $ses = json_decode($_SESSION['items'],true);
          $_GET['s'] = $ses['s'];
          $_GET['category'] = $ses['category'];
          $_GET['orderby'] = $ses['orderby'];
          $_GET['p'] = $ses['p'];
          $_REQUEST['p'] = $ses['p'];
          $_GET['moderate'] = $ses['moderate'];
          $_GET['limit'] = $ses['limit'];
        }

        $ses = array('s' => $_GET['s'], 'category' => $_GET['category'], 'orderby' => $_GET['orderby'], 'p' => $_GET['p'], 'moderate' => $_GET['moderate'], 'limit' => $_GET['limit']);
        $_SESSION['items'] = json_encode($ses);

        $items    = $shop->getProductListWithOrder($_GET['s'], $_GET['category'], $_GET['orderby'], $_GET['moderate'], $_GET['limit']);

        $orderby  = ($_GET['orderby']  != '') ? "&orderby=".$_GET['orderby'] : '';
        $category = ($_GET['category'] != '') ? "&category=".$_GET['category'] : '';
        $moderate = ($_GET['moderate'] != '') ? "&moderate=".$_GET['moderate'] : '';
        $limit = ($_GET['limit'] != '') ? "&limit=".$_GET['limit'] : '';
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $p_url = $url."b=items".$category.$s.$moderate.$limit.$orderby; 

        $modx->setPlaceholder('url',$url."b=items".$category.$s.$moderate.$limit.$orderby."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "products.tpl";
      break;

    }
  break;
  case "schedule":
    switch ($_GET['c']) {
      case "add":
      echo 'Error';
die;
/*
        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');
        // Список категорий к которым можно привязывать товар
        $options = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "94" OR sc.template = "99") AND sc.published = "1" '));

        $autoschool = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "67" OR sc.template = "98") AND sc.published = "1" AND sc.parent = "121" '));
*/

        $title      = "Створити";
        $tpl        = "schedule_add.tpl";
      break;
      case "edit":

      echo 'Error';
die;
/*
        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');

        // Список категорий к которым можно привязывать товар
        $options = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "94" OR sc.template = "99") AND sc.published = "1" '));

        $autoschool = $modx->db->makeArray($modx->db->query('SELECT *,  (SELECT pagetitle_ua FROM `modx_site_content` WHERE id = sc.parent) as parent_pagetitle, pagetitle_ua as pagetitle FROM `modx_site_content` sc WHERE (sc.template = "67" OR sc.template = "98") AND sc.published = "1" AND sc.parent = "121" '));

        $product_by_article = $shop->getProduct($_GET['i']);

        $total = $modx->db->getRecordCount($product_by_article);
        $product = $modx->db->makeArray($product_by_article);
      */


        $title      = "Редагувати ";
        $tpl        = "schedule_edit.tpl";
      break;
      case "create":
       
die;
        //product_cover , product_photo
        $query = "INSERT INTO `modx_a_products` SET
                  product_created        = '".$modx->db->escape(date('Y-m-d H:i:s',time()))."'
                  ";

        $modx->db->query($query);              

        $id = $modx->db->getInsertId();

        $modx->db->query('INSERT INTO `modx_a_virtual` SET 
          type = "2",
          idv = "'.$modx->db->escape($id).'",
          url = "'.$modx->db->escape($p_url).'"
          ');



        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$id;
        }else{
          $par = '&w=updated';
        }
        die(header("Location: ".$url."b=schedule".$par));
      break;
      case "update":
      echo 'Error';
die;
        //product_cover , product_photo
        $query = "UPDATE `modx_a_products` SET
                  product_edited         = '".$modx->db->escape(date('Y-m-d H:i:s',time()))."',
                  ";

        $modx->db->query($query);              

        $id = $_POST['edit']['id'];

        $modx->db->query('DELETE FROM `modx_a_virtual` WHERE type = "2" AND idv = "'.$modx->db->escape($id).'" ');

        $modx->db->query('INSERT INTO `modx_a_virtual` SET 
          type = "2",
          idv = "'.$modx->db->escape($id).'",
          url = "'.$modx->db->escape($p_url).'"
        ');

        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$id;
        }else{
          $par = '&w=updated';
        }
        die(header("Location: ".$url."b=schedule".$par));
      break;
      default:


        if($_GET['filter'] == '0'){
          unset($_SESSION['schedule'],$_GET['schedule_s'],$_GET['schedule_status'],$_GET['schedule_orderby'],$_GET['schedule_p'],$_GET['schedule_limit']);
          die(header("Location: ".$url."b=schedule"));
        }

        if(isset($_SESSION['schedule']) AND $_GET['s'] == '' AND $_GET['status'] == '' AND $_GET['orderby'] == '' AND $_GET['p'] == '' AND $_GET['limit'] == ''){
          $ses = json_decode($_SESSION['schedule'],true);
          $_GET['s'] = $ses['schedule_s'];
          $_GET['status'] = $ses['schedule_status'];
          $_GET['orderby'] = $ses['schedule_orderby'];
          $_GET['p'] = $ses['schedule_p'];
          $_REQUEST['p'] = $ses['schedule_p'];
          $_GET['limit'] = $ses['schedule_limit'];
        }

        $ses = array('schedule_s' => $_GET['s'], 'schedule_status' => $_GET['status'], 'schedule_orderby' => $_GET['orderby'], 'schedule_p' => $_GET['p'], 'schedule_limit' => $_GET['limit']);
        $_SESSION['schedule'] = json_encode($ses);

        $schedule    = $shop->getScheduleListWithOrder($_GET['s'], $_GET['status'], $_GET['orderby'], $_GET['limit']);

        $orderby  = ($_GET['orderby']  != '') ? "&orderby=".$_GET['orderby'] : '';
        $status = ($_GET['status'] != '') ? "&status=".$_GET['status'] : '';
        $limit = ($_GET['limit'] != '') ? "&limit=".$_GET['limit'] : '';
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $p_url = $url."b=schedule".$s.$status.$limit.$orderby; 

        $modx->setPlaceholder('url',$url."b=schedule".$s.$status.$limit.$orderby."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "schedule.tpl";
      break;

    }
  break;
  case "city_form":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteCityForm($_GET['i']);
        die(header("Location: ".$url."b=city_form&p=0"));
      break;
      default:
        $users    = $shop->getCityForm($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=city_form".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "city_form.tpl";
      break;
    }
  break;
  case "lesson":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteLesson ($_GET['i']);
        die(header("Location: ".$url."b=lesson&p=0"));
      break;
      default:
        $users    = $shop->getLesson($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=lesson".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "lesson.tpl";
      break;
    }
  break;
  case "call_instructor":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteCallInstructor ($_GET['i']);
        die(header("Location: ".$url."b=call_insrtuctor&p=0"));
      break;
      default:
        $users    = $shop->getCallInstructor($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=call_insrtuctor".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "call_instructor.tpl";
      break;
    }
  break;
  case "online":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteOnline ($_GET['i']);
        die(header("Location: ".$url."b=online&p=0"));
      break;
      default:
        $users    = $shop->getOnline($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=online".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "online.tpl";
      break;
    }
    
  break;
  case "webi_in":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteWebiIn ($_GET['i']);
        die(header("Location: ".$url."b=webi_in&p=0"));
      break;
      default:
        $users    = $shop->getWebiIn($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=webi_in".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "webi_in.tpl";
      break;
    }
  break;
  case "chats":
    switch ($_GET['c']) {
      case "chat_view":
        $chat_id = $_REQUEST['chat_id'];
        $history = $modx->db->query('SELECT * FROM `modx_a_chat_history` WHERE chat_id = "'.$modx->db->escape($chat_id).'" ORDER BY date ');
        $tpl      =  "chat_view.tpl";
      break;
      default:
        $chats    = $shop->getChats($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=chats".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "chats.tpl";
      break;
    }

  break;
  case "subscribers":
    switch ($_GET['c']) {
      default:
        $users    = $shop->getSubscribers($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=subscribers".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "subscribers.tpl";
      break;
    }
  break;
  case "master":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteMaster ($_GET['i']);
        die(header("Location: ".$url."b=master&p=0"));
      break;
      default:
        $users    = $shop->getMaster($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=master".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "master.tpl";
      break;
    }
  break;
  case "webi":
    switch ($_GET['c']) {
      case "delete":
        $shop->deleteWebi ($_GET['i']);
        die(header("Location: ".$url."b=webi&p=0"));
      break;
      default:
        $users    = $shop->getWebi($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=webi".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "webi.tpl";
      break;
    }
  break;
  case "instructors":

    switch ($_GET['c']) {
      case "edit":
        
        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');
        $cities = $modx->db->makeArray($modx->db->query('SELECT * FROM `modx_a_city` ORDER BY id ASC'));
        $school = $modx->db->query('SELECT *, pagetitle_ua as pagetitle FROM `modx_site_content` WHERE parent = "121" AND published = "1" AND deleted = "0" ');

        $user    = $shop->getInstructor($_GET['i']);
        $tiny_mce   = $shop->tinyMCE("description");

        $title      = "Редагувати інструктора";
        $tpl        = "instructor_edit.tpl";
      break;
      case "update":
        $shop->updateInstructor($_POST['edit']);


        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$_POST['edit']['id'];
        }else{
          $par = "&w=updated&i=".$_POST['edit']['id'];     
        }
        die(header("Location: ".$url."b=instructors".$par));
      break;
      case "delete":
        $shop->deleteInstructor ($_GET['i']);
        die(header("Location: ".$url."b=instructors&p=0"));
      break;
      default:

        $pays[0] = 'За замовченням';
        $pay_options = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1 ');
        while ($r = $modx->db->getRow($pay_options)){
           $pays[$r['pay_id']] = $r['shop_payname'].' ('.$r['pay_id'].')';
        }
        $cities = $modx->db->makeArray($modx->db->query('SELECT * FROM `modx_a_city` ORDER BY id ASC'));
        $schools = $modx->db->makeArray($modx->db->query('SELECT *, pagetitle_ua as pagetitle FROM `modx_site_content` WHERE parent = "121" AND published = "1" AND deleted = "0" '));

        $users    = $shop->getInstructors($_GET['s'], $_GET['orderby'],$_GET['city'], $_GET['school']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $orderby        = ($_GET['orderby'] != '') ? "&orderby=".$_GET['orderby'] : '';
        $city        = ($_GET['city'] != '') ? "&city=".$_GET['city'] : '';
        $school        = ($_GET['school'] != '') ? "&school=".$_GET['school'] : '';
        $modx->setPlaceholder('url',$url."b=instructors".$s.$orderby.$city.$school."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "instructors.tpl";
      break;
    }
  break;
  case "users":
    switch ($_GET['c']) {
      case "login":
        unset($_SESSION['webShortname']);
        unset($_SESSION['webFullname']);
        unset($_SESSION['webEmail']);
        unset($_SESSION['webValidated']);
        unset($_SESSION['webInternalKey']);
        unset($_SESSION['webValid']);
        unset($_SESSION['webUser']);
        unset($_SESSION['webFailedlogins']);
        unset($_SESSION['webLastlogin']);
        unset($_SESSION['webnrlogins']);
        unset($_SESSION['webUsrConfigSet']);
        unset($_SESSION['webUserGroupNames']);
        unset($_SESSION['webDocgroups']);
        unset($_SESSION['webuserid']);
        unset($_SESSION['webuser']);
        setcookie ("remember", '0',time()+2592000,'/');


        $modx->runSnippet("Auth", Array("email" => $_GET['i'], "autologin" => true));
        $modx->sendRedirect($modx->makeUrl('83'));
die;
      break;
      case "edit":

        $user    = $shop->getUser($_GET['i']);
        $utm     = json_decode($user['utm'],true);

        $school = $modx->db->query('SELECT *, pagetitle_ua as pagetitle FROM `modx_site_content` WHERE parent = "121" AND published = "1" AND deleted = "0" ');
        $title      = "Редагувати користувача";

        if($_SESSION['mgrRole'] == 6){
          $tpl        = "user_edit_i.tpl";
        }else{
          $tpl        = "user_edit.tpl";
        }
      break;

      case "update_i":
        $shop->updateUserI($_POST['edit']);


        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$_POST['edit']['id'];
        }else{
          $par = "&w=updated&i=".$_POST['edit']['id'];     
        }
        die(header("Location: ".$url."b=users".$par));
      break;
      case "update":
        $shop->updateUser($_POST['edit']);

        if($_POST['step'] == '0'){
          $par = '&c=edit&i='.$_POST['edit']['id'];
        }else{
          $par = "&w=updated&i=".$_POST['edit']['id'];     
        }
        die(header("Location: ".$url."b=users".$par));
      break;
      case "delete":
        $shop->deleteUser ($_GET['i']);
        die(header("Location: ".$url."b=users&p=0"));
      break;
      default:
        $users    = $shop->getUsers($_GET['s'], $_GET['orderby']);
        $s        = ($_GET['s'] != '') ? "&s=".$_GET['s'] : '';
        $modx->setPlaceholder('url',$url."b=users".$s."&p=");
        $pagin    = $shop->getPaginate();
        $tpl      =  "users.tpl";
      break;
    }
  break;
  case "pdr":
     switch ($_GET['c']) {

      case 'chapter':
        if($_REQUEST['item'] != ''){

            $tiny_mce   = $shop->tinyMCE("description");
            $chapters = $modx->db->query('SELECT * FROM `new_pdr_chapter` ORDER BY id ASC ');

            $item = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($_GET['item']).'" LIMIT 1'));
            $tpl = "pdr_item_edit.tpl";


        }else{
          $chapter_info = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
          $items = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE chapter = "'.$modx->db->escape($_GET['i']).'" ');
          $tpl = "pdr_items.tpl";
        }
      break;
      case "update":



        $modx->db->query('UPDATE `new_pdr_chapter_item` SET   
          `number`            = "'.$modx->db->escape($_REQUEST['number']).'",
          `chapter`           = "'.$modx->db->escape($_REQUEST['chapter']).'",
          `description`       = "'.$modx->db->escape($_REQUEST['description']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');
        foreach ($_REQUEST['option'] as $key => $value) {
          $modx->db->query('UPDATE `option_new` SET name = "'.$modx->db->escape($value).'" WHERE id = "'.$modx->db->escape($key).'" LIMIT 1');
        }

        die(header("Location: ".$url."b=pdr&c=chapter&i=".$_REQUEST['i']."&w=updated"));

      break;
      case "update_chapter":
        $modx->db->query('UPDATE `new_pdr_chapter` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          chapter          = "'.$modx->db->escape($_REQUEST['chapter']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=pdr&chapter=".$_REQUEST['id']."&w=updated"));
      break;
      default:
        $q2 = $modx->db->query('SELECT * FROM `new_pdr_chapter` c WHERE 1 = 1 ORDER BY c.id ASC ');      
        $tpl   = "pdr.tpl";
      break;
    }  
  break;



  case "test":
     switch ($_GET['c']) {
      case "new_question":
        $tiny_mce   = $shop->tinyMCE("comment");
        $chapters = $modx->db->query('SELECT * FROM `new_question_theme` ORDER BY id ASC ');
        $tickets = $modx->db->query('SELECT * FROM `new_question_ticket` ORDER BY id ASC ');
        $pdrs = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` ORDER BY id ASC ');

        $tpl = "new_question.tpl";
      break;
      case "create_question":

        $answers = json_encode($_REQUEST['option']);


        $modx->db->query('INSERT INTO `new_question` SET 
          question         = "'.$modx->db->escape($_REQUEST['question']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          correct          = "'.$modx->db->escape($_REQUEST['correct']).'",
          answers          = "'.$modx->db->escape($answers).'",
          comment          = "'.$modx->db->escape($_REQUEST['comment']).'",
          pdr              = "'.$modx->db->escape(implode(',',$_REQUEST['pdr'])).'"
        ');
        $question_id = $modx->db->getInsertId();

        if(is_array($_REQUEST['ticket_ids'])){
          foreach ($_REQUEST['ticket_ids'] as $ticket_id) {
            $modx->db->query('INSERT INTO `new_question_2_ticket` SET ticket_id = "'.$modx->db->escape($ticket_id).'", question_id = "'.$modx->db->escape($question_id).'" ');
          }
        }



        $modx->db->query('INSERT INTO `new_question_2_theme` SET theme_id = "'.$modx->db->escape($_REQUEST['theme_id']).'", question_id = "'.$modx->db->escape($question_id).'"');



        die(header("Location: ".$url."b=test&c=chapter&i=".$_REQUEST['theme_id']."&w=updated"));

      break;
      case "new_theme":
        $tpl = "new_theme.tpl";
      break;
      case "new_ticket":
        $tpl = "new_ticket.tpl";
      break;
      case "create_theme":
        $modx->db->query('INSERT INTO `new_question_theme` SET 
          number = "'.$modx->db->escape($_REQUEST['number']).'",
          name = "'.$modx->db->escape($_REQUEST['name']).'" ');
        die(header("Location: ".$url."b=test&w=updated"));
      break;
      case "create_ticket":
        $modx->db->query('INSERT INTO `new_question_ticket` SET 
          number = "'.$modx->db->escape($_REQUEST['number']).'",
          name = "'.$modx->db->escape($_REQUEST['name']).'" ');
        die(header("Location: ".$url."b=test&w=updated"));

      break;
      case "upload":

        $question_id = $_POST['question_id'];


    
        $newfilename = "/assets/images/pdr/tests/".preg_replace('/\D+/', '', microtime()).".".end(explode(".", $_FILES['uploader']['name']));
        $new = MODX_BASE_PATH.$newfilename;

        move_uploaded_file($_FILES['uploader']['tmp_name'], $new);

        $modx->db->query('UPDATE `new_question` SET image_new_2 = "'.$modx->db->escape($newfilename).'" WHERE id = "'.$modx->db->escape($question_id).'" LIMIT 1');
        
        die;

      break;
      case "upload2":
        $question_id = $_POST['question_id'];
        $newfilename = "/assets/images/pdr/base/".preg_replace('/\D+/', '', microtime()).".".end(explode(".", $_FILES['uploader']['name']));
        $new = MODX_BASE_PATH.$newfilename;

        move_uploaded_file($_FILES['uploader']['tmp_name'], $new);

        $modx->db->query('UPDATE `new_question` SET image_official = "'.$modx->db->escape($newfilename).'" WHERE id = "'.$modx->db->escape($question_id).'" LIMIT 1');
        
        die;
      break;
      case 'vidpovidi_x':


        $tpl = "vidpovidi_x_edit.tpl";
 
      break;

      case 'update_ticket_position':
        foreach($_REQUEST['position'] as $k => $v){
          $modx->db->query('UPDATE `new_question_2_ticket` SET position = "'.$modx->db->escape($v).'" WHERE question_id = "'.$modx->db->escape($k).'" AND ticket_id = "'.$modx->db->escape($_REQUEST['ticket_id']).'" LIMIT 1');
        }

        die(header("Location: ".$url."b=test&c=ticket&i=".$_REQUEST['ticket_id']."&w=updated"));
      break;
      case 'ticket':
        $chapter_info = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question_ticket` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
        $questions = $modx->db->query('SELECT * FROM `new_question` q  LEFT JOIN `new_question_2_ticket` q2t ON q2t.question_id = q.id WHERE q2t.ticket_id = "'.$modx->db->escape($_GET['i']).'" ORDER BY q2t.position ASC');
        $tpl = "ticket_edit.tpl";
 
      break;
      case "edit_question":

        if($_REQUEST['question'] != ''){
            $tiny_mce   = $shop->tinyMCE("comment, #video, #comment_gpt");
            $chapters = $modx->db->query('SELECT * FROM `new_question_theme` ORDER BY id ASC ');
            $tickets = $modx->db->query('SELECT * FROM `new_question_ticket` ORDER BY id ASC ');
            $pdrs = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` ORDER BY id ASC ');
            $question = $modx->db->getRow($modx->db->query('SELECT *, (SELECT theme_id FROM `new_question_2_theme` q2t WHERE q2t.question_id = q.id LIMIT 1) AS theme_id, (SELECT GROUP_CONCAT(q2ti.ticket_id) FROM `new_question_2_ticket` q2ti WHERE q2ti.question_id = q.id LIMIT 1) AS ticket_ids FROM `new_question` q WHERE q.id = "'.$modx->db->escape($_GET['question']).'" LIMIT 1'));
            $helper = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question_2_helper` WHERE question_id = "'.$modx->db->escape($_GET['question']).'" LIMIT 1'));

            $tpl = "question_edit_x.tpl";

        }

      break;
      case 'update_chapter_position':
        foreach($_REQUEST['position'] as $k => $v){
          $modx->db->query('UPDATE `new_question_2_theme` SET position = "'.$modx->db->escape($v).'" WHERE question_id = "'.$modx->db->escape($k).'" AND theme_id = "'.$modx->db->escape($_REQUEST['theme_id']).'" LIMIT 1');
        }

        die(header("Location: ".$url."b=test&c=chapter&i=".$_REQUEST['theme_id']."&w=updated"));
      break;
      case "copy_photo_new":
          $modx->db->query('UPDATE `new_question` SET image_new_2 = image_new WHERE id = "'.$modx->db->escape($_REQUEST['question_id']).'" LIMIT 1');
      
        die(true);
      break;
      case "copy_photo_official":
          $modx->db->query('UPDATE `new_question` SET image_new_2 = image_official WHERE id = "'.$modx->db->escape($_REQUEST['question_id']).'" LIMIT 1');
        die(true);
      break;
      case 'chapter':
        if($_REQUEST['question'] != ''){
            $tiny_mce   = $shop->tinyMCE("comment, #video, #comment_gpt");
            $chapters = $modx->db->query('SELECT * FROM `new_question_theme` ORDER BY id ASC ');
            $tickets = $modx->db->query('SELECT * FROM `new_question_ticket` ORDER BY id ASC ');
            $pdrs = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` ORDER BY id ASC ');
            $question = $modx->db->getRow($modx->db->query('SELECT *, (SELECT theme_id FROM `new_question_2_theme` q2t WHERE q2t.question_id = q.id LIMIT 1) AS theme_id, (SELECT GROUP_CONCAT(q2ti.ticket_id) FROM `new_question_2_ticket` q2ti WHERE q2ti.question_id = q.id LIMIT 1) AS ticket_ids FROM `new_question` q WHERE q.id = "'.$modx->db->escape($_GET['question']).'" LIMIT 1'));

            $helper = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question_2_helper` WHERE question_id = "'.$modx->db->escape($_GET['question']).'" LIMIT 1'));

            $tpl = "question_edit.tpl";

        }else{
          $chapter_info = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question_theme` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
          $questions = $modx->db->query('SELECT * FROM `new_question` q  LEFT JOIN `new_question_2_theme` q2t ON q2t.question_id = q.id WHERE q2t.theme_id = "'.$modx->db->escape($_GET['i']).'"  ORDER BY q2t.position ASC');
          $tpl = "question.tpl";
        }
      break;
      case "update_x":


        $modx->db->query('DELETE FROM `new_question_2_ticket` WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" ');
        if(is_array($_REQUEST['ticket_ids'])){
          foreach ($_REQUEST['ticket_ids'] as $ticket_id) {
            $modx->db->query('INSERT INTO `new_question_2_ticket` SET ticket_id = "'.$modx->db->escape($ticket_id).'", question_id = "'.$modx->db->escape($_REQUEST['pid']).'" ');
          }
        }
        $answers = json_encode($_REQUEST['option']);

        $modx->db->query('UPDATE `new_question` SET 
          question         = "'.$modx->db->escape($_REQUEST['question']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          correct          = "'.$modx->db->escape($_REQUEST['correct']).'",
          answers          = "'.$modx->db->escape($answers).'",
          comment          = "'.$modx->db->escape($_REQUEST['comment']).'",
          video            = "'.$modx->db->escape($_REQUEST['video']).'",
          pdr              = "'.$modx->db->escape(implode(',',$_REQUEST['pdr'])).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['pid']).'"
        ');


        $modx->db->query('UPDATE `new_question_2_theme` SET theme_id = "'.$modx->db->escape($_REQUEST['theme_id']).'" WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" LIMIT 1');


        if($_REQUEST['comment_gpt'] != ''){
          $q = $modx->db->query('SELECT * FROM `new_question_2_helper` WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" LIMIT 1');
          if($modx->db->getRecordCount($q) > 0){
            $modx->db->query('UPDATE `new_question_2_helper` SET answer = "'.$modx->db->escape($_REQUEST['comment_gpt']).'" WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" LIMIT 1');
          }else{
            $modx->db->query('INSERT INTO `new_question_2_helper` SET answer = "'.$modx->db->escape($_REQUEST['comment_gpt']).'", question_id = "'.$modx->db->escape($_REQUEST['pid']).'" ');
          }
        }

        die(header("Location: ".$url."b=test&c=vidpovidi_x&w=updated"));

      break;
      case "update":

        $modx->db->query('DELETE FROM `new_question_2_ticket` WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" ');
        if(is_array($_REQUEST['ticket_ids'])){
          foreach ($_REQUEST['ticket_ids'] as $ticket_id) {
            $modx->db->query('INSERT INTO `new_question_2_ticket` SET ticket_id = "'.$modx->db->escape($ticket_id).'", question_id = "'.$modx->db->escape($_REQUEST['pid']).'" ');
          }
        }
        $answers = json_encode($_REQUEST['option']);

        $modx->db->query('UPDATE `new_question` SET 
          question         = "'.$modx->db->escape($_REQUEST['question']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          correct          = "'.$modx->db->escape($_REQUEST['correct']).'",
          answers          = "'.$modx->db->escape($answers).'",
          comment          = "'.$modx->db->escape($_REQUEST['comment']).'",
          video            = "'.$modx->db->escape($_REQUEST['video']).'",
          pdr              = "'.$modx->db->escape(implode(',',$_REQUEST['pdr'])).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['pid']).'"
        ');


        $modx->db->query('UPDATE `new_question_2_theme` SET theme_id = "'.$modx->db->escape($_REQUEST['theme_id']).'" WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" LIMIT 1');


        if($_REQUEST['comment_gpt'] != ''){
          $q = $modx->db->query('SELECT * FROM `new_question_2_helper` WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" LIMIT 1');
          if($modx->db->getRecordCount($q) > 0){
            $modx->db->query('UPDATE `new_question_2_helper` SET answer = "'.$modx->db->escape($_REQUEST['comment_gpt']).'" WHERE question_id = "'.$modx->db->escape($_REQUEST['pid']).'" LIMIT 1');
          }else{
            $modx->db->query('INSERT INTO `new_question_2_helper` SET answer = "'.$modx->db->escape($_REQUEST['comment_gpt']).'", question_id = "'.$modx->db->escape($_REQUEST['pid']).'" ');
          }
        }



        die(header("Location: ".$url."b=test&c=chapter&i=".$_REQUEST['i']."&w=updated"));

      break;
      case "update_ticket":
        $modx->db->query('UPDATE `new_question_ticket` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['i']).'"
        ');

        die(header("Location: ".$url."b=test&ticket=".$_REQUEST['i']."&w=updated"));
      break;
      case "update_chapter":
        $modx->db->query('UPDATE `new_question_theme` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['i']).'"
        ');

        die(header("Location: ".$url."b=test&chapter=".$_REQUEST['i']."&w=updated"));
      break;
      case "update_tt_position":


        foreach($_REQUEST['position_theme'] as $k => $v){
          $modx->db->query('UPDATE `new_question_theme` SET position = "'.$modx->db->escape($v).'" WHERE id = "'.$modx->db->escape($k).'" LIMIT 1');
        }
        foreach($_REQUEST['position_ticket'] as $k => $v){
          $modx->db->query('UPDATE `new_question_ticket` SET position = "'.$modx->db->escape($v).'" WHERE id = "'.$modx->db->escape($k).'" LIMIT 1');
        }


        die(header("Location: ".$url."b=test&w=updated"));
      break;
      default:
        $q2 = $modx->db->query('SELECT *, (SELECT count(q2t.question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as cnt FROM `new_question_theme` qt WHERE 1 = 1 ORDER BY qt.position ASC ');    
        $q3 = $modx->db->query('SELECT *, (SELECT count(q2t.question_id) FROM `new_question_2_ticket` q2t WHERE q2t.ticket_id = qt.id) as cnt FROM `new_question_ticket` qt WHERE 1 = 1 ORDER BY qt.position ASC ');    
        $tpl   = "test.tpl";
      break;
    }  
  break;
  case "sign":
    switch ($_GET['c']) {
      case "upload":


        $folder = MODX_BASE_PATH . "assets/images/".$_POST['folder'];
 
        //$_FILES['uploader']['tmp_name'],$_FILES['uploader']['name']
        move_uploaded_file($_FILES['uploader']['tmp_name'], $folder.end(explode("/", $_FILES['uploader']['name'])));
        
        die;

      break;
      case 'delete':
        if($_GET['i'] != ''){
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
          unlink(MODX_BASE_PATH.$r['image_new']);


          $modx->db->query('DELETE FROM `new_pdr_road_sign_item` WHERE id = "'.$modx->db->escape($_GET['i']).'"');
        }
        die(header("Location: ".$url."b=sign&w=deleted"));
      break;
      case "add":
        $tiny_mce   = $shop->tinyMCE("description");
        $types = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE 1 = 1 ORDER BY id ASC ');
        $tpl = "sign_add.tpl";
      break;
      case 'edit':
        $tiny_mce   = $shop->tinyMCE("description");
        $types = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE 1 = 1 ORDER BY id ASC ');
        $sign = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
        $tpl = "sign_edit.tpl";
      break;
      case "update":


        $modx->db->query('UPDATE `new_pdr_road_sign_item` SET 
          type             = "'.$modx->db->escape($_REQUEST['type']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          name             = "'.$modx->db->escape($_REQUEST['name']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=sign&w=updated"));
      break;
      case "save":

        $folder = MODX_BASE_PATH."assets/images/tmp/road-signs/";      
        $files = glob ($folder."*");
        if (is_array($files) and count($files)>0){
          foreach ($files as $file) {
            $filename = explode('/', $file);

            $fshortname = explode('.', end($filename));
            $image_new = $_REQUEST['number'].'.'.end($fshortname);

            $newfile = MODX_BASE_PATH."assets/images/pdr/road-signs/original/".$image_new;
           
            copy($file, $newfile);
            unlink($file);
             
          }  
        }

        $modx->db->query('INSERT INTO `new_pdr_road_sign_item` SET 
          type             = "'.$modx->db->escape($_REQUEST['type']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          image_new        = "'.$modx->db->escape('/assets/images/pdr/road-signs/original/'.$image_new).'",
          name             = "'.$modx->db->escape($_REQUEST['name']).'"
        ');



        die(header("Location: ".$url."b=sign&w=added"));
      break;
      default:
        $signs  = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE 1 = 1 ORDER BY id ASC');

        $signs2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE 1 = 1 ORDER BY id ASC');
        $tpl   = "sign.tpl";
      break;
    }    
  break;
  
  case "marking":
    switch ($_GET['c']) {
      case "upload":


        $folder = MODX_BASE_PATH . "assets/images/".$_POST['folder'];
 
        //$_FILES['uploader']['tmp_name'],$_FILES['uploader']['name']
        move_uploaded_file($_FILES['uploader']['tmp_name'], $folder.end(explode("/", $_FILES['uploader']['name'])));
        
        die;

      break;
      case 'delete':
        if($_GET['i'] != ''){
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
          unlink(MODX_BASE_PATH.$r['image_new']);


          $modx->db->query('DELETE FROM `new_pdr_road_marking_item` WHERE id = "'.$modx->db->escape($_GET['i']).'"');
        }
        die(header("Location: ".$url."b=marking&w=deleted"));
      break;
      case "add":
        $tiny_mce   = $shop->tinyMCE("description");
        $types = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1 ORDER BY id ASC ');
        $tpl = "marking_add.tpl";
      break;
      case 'edit':
        $tiny_mce   = $shop->tinyMCE("description");
        $types = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1 ORDER BY id ASC ');
        $marking = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
        $tpl = "marking_edit.tpl";
      break;
      case "update":


        $modx->db->query('UPDATE `new_pdr_road_marking_item` SET 
          type             = "'.$modx->db->escape($_REQUEST['type']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          name             = "'.$modx->db->escape($_REQUEST['name']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=marking&w=updated"));
      break;
      case "save":

        $folder = MODX_BASE_PATH."assets/images/tmp/road-markings/";      
        $files = glob ($folder."*");
        if (is_array($files) and count($files)>0){
          foreach ($files as $file) {
            $filename = explode('/', $file);

            $fshortname = explode('.', end($filename));
            $image_new = $_REQUEST['number'].'.'.end($fshortname);

            $newfile = MODX_BASE_PATH."assets/images/pdr/road-markings/original/".$image_new;
           
            copy($file, $newfile);
            unlink($file);
             
          }  
        }

        $modx->db->query('INSERT INTO `new_pdr_road_marking_item` SET 
          type             = "'.$modx->db->escape($_REQUEST['type']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          image_new        = "'.$modx->db->escape('/assets/images/pdr/road-markings/original/'.$image_new).'",
          name             = "'.$modx->db->escape($_REQUEST['name']).'"
        ');



        die(header("Location: ".$url."b=marking&w=added"));
      break;
      default:
        $markings  = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1 ORDER BY id ASC');

        $markings2 = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1 ORDER BY id ASC');
        $tpl   = "marking.tpl";
      break;
    }    
  break;

  case "info":
    switch ($_GET['c']) {
    
      case "sort":
        foreach ($_REQUEST['sort'] as $k => $v) {
            $modx->db->query('UPDATE `new_pdr_info` SET sort = "'.$modx->db->escape($v).'" WHERE id = "'.$modx->db->escape($k).'" LIMIT 1');

        }
        die(header("Location: ".$url."b=info&w=updated"));
      break;
      case 'delete':
        if($_GET['i'] != ''){

          $modx->db->query('DELETE FROM `new_pdr_info` WHERE id = "'.$modx->db->escape($_GET['i']).'"');
        }
        die(header("Location: ".$url."b=info&w=deleted"));
      break;
      case "add":
        $tiny_mce   = $shop->tinyMCE("description");
        $tpl = "info_add.tpl";
      break;
      case 'edit':
        $tiny_mce   = $shop->tinyMCE("description");
        $info = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_info` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
        $tpl = "info_edit.tpl";
      break;
      case "update":


        $modx->db->query('UPDATE `new_pdr_info` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          intro            = "'.$modx->db->escape($_REQUEST['intro']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=info&w=updated"));
      break;
      case "save":


        $modx->db->query('INSERT INTO `new_pdr_info` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          intro            = "'.$modx->db->escape($_REQUEST['intro']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'"
        ');



        die(header("Location: ".$url."b=info&w=added"));
      break;
      default:
        $infos  = $modx->db->query('SELECT * FROM `new_pdr_info` WHERE 1 = 1 ORDER BY sort ASC');

        $tpl   = "info.tpl";
      break;
    }    
  break;
  case "recalls_content":
    switch ($_GET['c']) {
      case 'delete':
        $shop->deleteRecallC($_GET['i']);
        die(header("Location: ".$url."b=recalls_content&w=updated"));
        break;
      case 'update':
        $shop->updateRecallC($_POST['recall']);
        die(header("Location: ".$url."b=recalls_content&w=updated"));
        break;
      case 'edit':
        $recall = $shop->getRecallC($_GET['i']);      
        $tpl = "recall_content_edit.tpl";
        break;
      
      default:
        if($_REQUEST['date_to'] != ''){
          $_REQUEST['date_from'] = ($_REQUEST['date_from'] != '' ? $_REQUEST['date_from'] : '0000-00-00 00:00:00');
          $date     = ' AND (recall_pub_date between "'.$modx->db->escape($_REQUEST['date_from']).' 00:00:00'.'" and "'.$modx->db->escape($_REQUEST['date_to']).' 23:59:59'.'")  ';
          $date_url = '&date_from='.$_REQUEST['date_from'].'&date_to='.$_REQUEST['date_to'];
        }
        else
          $_REQUEST['date_to'] = date("Y-m-d");
        if($_REQUEST['status'] != '' AND $_REQUEST['status'] != '-1'){
          $status     = ' AND recall_moderated = '.$modx->db->escape($_REQUEST['status']);
          $status_url = '&status='.$_REQUEST['status'];
        }
        $recalls  = $shop->getRecallsC($date, $status);
        $modx->setPlaceholder('url', $url."b=recalls_content".$date_url.$status_url."&p=");
        $pagin = $shop->getPaginate(); 
        $tpl   = "recalls_content.tpl";
        break;
    }    
  break;
  case "recalls":
    switch ($_GET['c']) {
      case 'delete':
        $shop->deleteRecall($_GET['i']);
        die(header("Location: ".$url."b=recalls&w=updated"));
        break;
      case 'update':
        $shop->updateRecall($_POST['recall']);
        die(header("Location: ".$url."b=recalls&w=updated"));
        break;
      case 'edit':
        $recall = $shop->getRecall($_GET['i']);      
        $tpl = "recall_edit.tpl";
        break;
      
      default:
        if($_REQUEST['date_to'] != ''){
          $_REQUEST['date_from'] = ($_REQUEST['date_from'] != '' ? $_REQUEST['date_from'] : '0000-00-00 00:00:00');
          $date     = ' AND (recall_pub_date between "'.$modx->db->escape($_REQUEST['date_from']).' 00:00:00'.'" and "'.$modx->db->escape($_REQUEST['date_to']).' 23:59:59'.'")  ';
          $date_url = '&date_from='.$_REQUEST['date_from'].'&date_to='.$_REQUEST['date_to'];
        }
        else
          $_REQUEST['date_to'] = date("Y-m-d");
        if($_REQUEST['status'] != '' AND $_REQUEST['status'] != '-1'){
          $status     = ' AND recall_moderated = '.$modx->db->escape($_REQUEST['status']);
          $status_url = '&status='.$_REQUEST['status'];
        }
        $recalls  = $shop->getRecalls($date, $status);
        $modx->setPlaceholder('url', $url."b=recalls".$date_url.$status_url."&p=");
        $pagin = $shop->getPaginate(); 
        $tpl   = "recalls.tpl";
        break;
    }    
  break;

  case "fine":
    switch ($_GET['c']) {
      case "sort":
        foreach ($_REQUEST['sort'] as $k => $v) {
            $modx->db->query('UPDATE `new_pdr_fine` SET sort = "'.$modx->db->escape($v).'" WHERE id = "'.$modx->db->escape($k).'" LIMIT 1');

        }
        die(header("Location: ".$url."b=fine&w=updated"));
      break;
      case 'delete':
        if($_GET['i'] != ''){

          $modx->db->query('DELETE FROM `new_pdr_fine` WHERE id = "'.$modx->db->escape($_GET['i']).'"');
        }
        die(header("Location: ".$url."b=fine&w=deleted"));
      break;
      case "add":
        $tiny_mce   = $shop->tinyMCE("description");
        $tpl = "fine_add.tpl";
      break;
      case 'edit':
        $tiny_mce   = $shop->tinyMCE("description");
        $fine = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_fine` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
        $tpl = "fine_edit.tpl";
      break;
      case "update":


        $modx->db->query('UPDATE `new_pdr_fine` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          amount           = "'.$modx->db->escape($_REQUEST['amount']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=fine&w=updated"));
      break;
      case "save":


        $modx->db->query('INSERT INTO `new_pdr_fine` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          amount           = "'.$modx->db->escape($_REQUEST['amount']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'"
        ');



        die(header("Location: ".$url."b=fine&w=added"));
      break;

      default:
        $fines  = $modx->db->query('SELECT * FROM `new_pdr_fine` WHERE 1 = 1 ORDER BY sort ASC');

        $tpl   = "fine.tpl";
      break;
    }    
  break;
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


}




/*
old

switch ($bootstrap) {
  case "test":
     switch ($_GET['c']) {
      case "upload":

        $question_id = $_POST['question_id'];


        $folder = MODX_BASE_PATH . "assets/images";
    
        $newfilename = "/".$_POST['folder']."/".preg_replace('/\D+/', '', microtime()).".".end(explode(".", $_FILES['uploader']['name']));
        $new = $folder.$newfilename;

        move_uploaded_file($_FILES['uploader']['tmp_name'], $new);

        $modx->db->query('UPDATE `question` SET img = "'.$modx->db->escape($newfilename).'" WHERE id = "'.$modx->db->escape($question_id).'" LIMIT 1');
        
        die;

      break;

      case 'chapter':
        if($_REQUEST['question'] != ''){

            $chapters = $modx->db->query('SELECT * FROM `chapter` ORDER BY id ASC ');

            $question = $modx->db->getRow($modx->db->query('SELECT * FROM `question` WHERE id = "'.$modx->db->escape($_GET['question']).'" LIMIT 1'));
            $tpl = "question_edit.tpl";


        }else{
          $tiny_mce   = $shop->tinyMCE("seotext");
          $chapter_info = $modx->db->getRow($modx->db->query('SELECT * FROM `chapter` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
          $questions = $modx->db->query('SELECT * FROM `question` WHERE chapter_id = "'.$modx->db->escape($_GET['i']).'" ');
          $tpl = "question.tpl";
        }
      break;
      case "update":



        $modx->db->query('UPDATE `question` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          correct_option   = "'.$modx->db->escape($_REQUEST['correct_option']).'",
          chapter_id       = "'.$modx->db->escape($_REQUEST['chapter_id']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');
        foreach ($_REQUEST['option'] as $key => $value) {
          $modx->db->query('UPDATE `option_new` SET name = "'.$modx->db->escape($value).'" WHERE id = "'.$modx->db->escape($key).'" LIMIT 1');
        }

        die(header("Location: ".$url."b=test&c=chapter&i=".$_REQUEST['i']."&w=updated"));

      break;
      case "update_chapter":
        $modx->db->query('UPDATE `chapter` SET 
          name             = "'.$modx->db->escape($_REQUEST['name']).'",
          title            = "'.$modx->db->escape($_REQUEST['title']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          seotext          = "'.$modx->db->escape($_REQUEST['seotext']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=test&chapter=".$_REQUEST['id']."&w=updated"));
      break;
      default:
        $q2 = $modx->db->query('SELECT *, (SELECT count(q.id) FROM `question` q WHERE q.chapter_id = c.id) as cnt FROM `chapter` c WHERE 1 = 1 ORDER BY c.id ASC ');      
        $tpl   = "test.tpl";
      break;
    }  
  break;
  case "sign":
    switch ($_GET['c']) {
      case "upload":


        $folder = MODX_BASE_PATH . "assets/images/".$_POST['folder'];
 
        //$_FILES['uploader']['tmp_name'],$_FILES['uploader']['name']
        move_uploaded_file($_FILES['uploader']['tmp_name'], $folder.".".end(explode(".", $_FILES['uploader']['name'])));
        
        die;

      break;
      case 'delete':
        $modx->db->query('DELETE FROM `road_sign_item` WHERE id = "'.$modx->db->escape($_GET['i']).'"');
        die(header("Location: ".$url."b=sign&w=deleted"));
      break;
      case "add":
        $tiny_mce   = $shop->tinyMCE("description");
        $types = $modx->db->query('SELECT * FROM `road_sign` WHERE 1 = 1 ORDER BY id ASC ');
        $tpl = "sign_add.tpl";
      break;
      case 'edit':
        $tiny_mce   = $shop->tinyMCE("description");
        $types = $modx->db->query('SELECT * FROM `road_sign` WHERE 1 = 1 ORDER BY id ASC ');
        $sign = $modx->db->getRow($modx->db->query('SELECT * FROM `road_sign_item` WHERE id = "'.$modx->db->escape($_GET['i']).'" LIMIT 1'));
        $tpl = "sign_edit.tpl";
      break;
      case "update":


        $modx->db->query('UPDATE `road_sign_item` SET 
          id_rdd_road_sign = "'.$modx->db->escape($_REQUEST['id_rdd_road_sign']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          name             = "'.$modx->db->escape($_REQUEST['name']).'"
          WHERE            
          id               = "'.$modx->db->escape($_REQUEST['id']).'"
        ');

        die(header("Location: ".$url."b=sign&w=updated"));
      break;
      case "save":

        $folder = MODX_BASE_PATH."assets/images/new/tmp/";      
        $files = glob ($folder."*");
        if (is_array($files) and count($files)>0){
          foreach ($files as $file) {
            $filename = explode('/', $file);

            $fshortname = explode('.', end($filename));
            $image_new = $_REQUEST['number'].'.'.end($fshortname);

            $newfile = MODX_BASE_PATH."assets/images/new/".$image_new;
           
            copy($file, $newfile);
            unlink($file);
             
          }  
        }

        $modx->db->query('INSERT INTO `road_sign_item` SET 
          id_rdd_road_sign = "'.$modx->db->escape($_REQUEST['id_rdd_road_sign']).'",
          number           = "'.$modx->db->escape($_REQUEST['number']).'",
          description      = "'.$modx->db->escape($_REQUEST['description']).'",
          image_new        = "'.$modx->db->escape('/new/'.$image_new).'",
          name             = "'.$modx->db->escape($_REQUEST['name']).'"
        ');



        die(header("Location: ".$url."b=sign&w=added"));
      break;
      default:
        $signs  = $modx->db->query('SELECT * FROM `road_sign` WHERE 1 = 1 ORDER BY id ASC');

        $signs2 = $modx->db->query('SELECT * FROM `road_sign` WHERE 1 = 1 ORDER BY id ASC');
        $tpl   = "sign.tpl";
      break;
    }    
  break;
  
}

*/
/*

quiz - 1 раздел

chapter - разделы в квизе

Разделы пдд:
pdd_chapter
pdd_chapter_item


Вопросы
question


Варианты ответов:
option
option_new



Знаки:
road_sign - типы
road_sign_item - все знаки




*/
if (isset($tpl)) {
  ob_start();
  include TPLS . $tpl;
  $res['content'] = ob_get_contents();
  ob_end_clean();
}
/*
switch($_SESSION['mgrRole']){
  case "1":
    include TPLS . "index.tpl";
  break;
  case "2":
    include TPLS . "index_2.tpl";
  break;
  case "5":
    include TPLS . "index_3.tpl";
  break;
  case "6":
    include TPLS . "index_6.tpl";
  break;
}
*/

switch($_GET['id']){

  default:
  case "8":
    include TPLS . "index.tpl";
  break;
  case "14":
    include TPLS . "index_pdr.tpl";
  break;
  case "12":
    include TPLS . "index_order.tpl";
  break;
  case "13":
    include TPLS . "index_school.tpl";
  break;
}

die;