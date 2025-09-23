<?php
/**
 * Обработчик AJAX запросов
 */


switch ($_REQUEST['ajax']) { 
    case "itu_update_row":
      switch($_SESSION['webuser']['cabinet_type']){
        case "2":
          $post = $_REQUEST['itu_edit_row'];
          switch($post['type']){
            case 'itu':
              $check_instructor = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($post['instructor_id']).'" LIMIT 1'));
              if($check_instructor['cabinet_syncname'] != ''){
                $instructor_name = $check_instructor['cabinet_syncname'];
              }else{
                $name = array();
                $name[] = $check_instructor['lastname'];
                $name[] = $check_instructor['fullname'];
                $name[] = $check_instructor['patronymic'];
                $instructor_name = implode(' ',$name);
              }
              $modx->db->query('UPDATE `modx_a_instructor_to_user_g` SET
                instructor_name = "'.$modx->db->escape($instructor_name).'",
                instructor_id = "'.$modx->db->escape($post['instructor_id']).'",
                order_comment = "'.$modx->db->escape($post['order_comment']).'"
                WHERE
                id = "'.$modx->db->escape($post['id']).'"
              ');
              $ajax['ack'] = 'Success';
            break;
            case 'ituw':
              $check_instructor = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($post['instructor_id']).'" LIMIT 1'));
              if($check_instructor['cabinet_syncname'] != ''){
                $instructor_name = $check_instructor['cabinet_syncname'];
              }else{
                $name = array();
                $name[] = $check_instructor['lastname'];
                $name[] = $check_instructor['fullname'];
                $name[] = $check_instructor['patronymic'];
                $instructor_name = implode(' ',$name);
              }
              $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET
                instructor_name = "'.$modx->db->escape($instructor_name).'",
                bill_payd = "'.$modx->db->escape($post['bill_payd']).'", 
                instructor_id = "'.$modx->db->escape($post['instructor_id']).'",
                order_comment = "'.$modx->db->escape($post['order_comment']).'"
                WHERE
                id = "'.$modx->db->escape($post['id']).'"
              ');
              $ajax['type'] = $post['type'];
              $ajax['ack'] = 'Success';
            break;
          }
        break;
        case "3":
          $post = $_REQUEST['itu_edit_row'];
          switch($post['type']){
            case 'itu':

              $check_instructor = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($post['instructor_id']).'" LIMIT 1'));
              if($check_instructor['cabinet_syncname'] != ''){
                $instructor_name = $check_instructor['cabinet_syncname'];
              }else{
                $name = array();
                $name[] = $check_instructor['lastname'];
                $name[] = $check_instructor['fullname'];
                $name[] = $check_instructor['patronymic'];
                $instructor_name = implode(' ',$name);
              }
              $modx->db->query('UPDATE `modx_a_instructor_to_user_g` SET
                instructor_name = "'.$modx->db->escape($instructor_name).'",
                user_phone = "'.$modx->db->escape($post['user_phone']).'",
                user_name = "'.$modx->db->escape($post['user_name']).'",
                instructor_id = "'.$modx->db->escape($post['instructor_id']).'",
                lesson_total = "'.$modx->db->escape($post['lesson_total']).'",
                lesson_balance = "'.$modx->db->escape($post['lesson_balance']).'",
                order_comment = "'.$modx->db->escape($post['order_comment']).'"
                WHERE
                id = "'.$modx->db->escape($post['id']).'"
              ');
              $ajax['ack'] = 'Success';
            break;
            case 'ituw':
                
              $check_instructor = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($post['instructor_id']).'" LIMIT 1'));
              if($check_instructor['cabinet_syncname'] != ''){
                $instructor_name = $check_instructor['cabinet_syncname'];
              }else{
                $name = array();
                $name[] = $check_instructor['lastname'];
                $name[] = $check_instructor['fullname'];
                $name[] = $check_instructor['patronymic'];
                $instructor_name = implode(' ',$name);
              }
              $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET
                instructor_name = "'.$modx->db->escape($instructor_name).'",
                bill_payd = "'.$modx->db->escape($post['bill_payd']).'", 
                user_phone = "'.$modx->db->escape($post['user_phone']).'",
                user_name = "'.$modx->db->escape($post['user_name']).'",
                instructor_id = "'.$modx->db->escape($post['instructor_id']).'",
                lesson_total = "'.$modx->db->escape($post['lesson_total']).'",
                lesson_balance = "'.$modx->db->escape($post['lesson_balance']).'",
                order_comment = "'.$modx->db->escape($post['order_comment']).'"
                WHERE
                id = "'.$modx->db->escape($post['id']).'"
              ');
              $ajax['type'] = $post['type'];
              $ajax['ack'] = 'Success';
            break;
          }
        break;
        default:
          $ajax['ack'] = 'Failure';
          $ajax['message'] = 'Доступ заборонено!';
        break;
      }
      $shop->setLog('2',json_encode($post));
    break;
    case "instructor_update":

      switch($_SESSION['webuser']['cabinet_type']){
        case "2":
          $post = $_REQUEST['instructor_edit'];

          $ajax['ack'] = 'Success';
        break;
        case "3":
          $post = $_REQUEST['instructor_edit'];
        
          $ajax['ack'] = 'Success';
        break;
        default:
          $ajax['ack'] = 'Failure';
          $ajax['message'] = 'Доступ заборонено!';
        break;
      }
      $shop->setLog('3',json_encode($post));
    break;
    case "instructor_edit":  
      switch($_SESSION['webuser']['cabinet_type']){
        case "2":
          $id = $_REQUEST['id'];

          //$r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructors` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));

          //$ajax['row_edit'] = $modx->parseDocumentSource($modx->parseChunk('tpl_instructor_edit',$r));

          $ajax['ack'] = 'Success';
        break;
        case "3":
          $id = $_REQUEST['id'];

          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructors` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));

          $q = $modx->db->query('SELECT * FROM `modx_a_paysystems` WHERE 1 = 1');
          while($ri = $modx->db->getRow($q)){
            $ri['selected'] = '';
            $ri['data'] = '';
            $ri['value'] = $ri['pay_id']; 
            $ri['name'] = $ri['shop_payname'].'('.$ri['pay_id'].')';
            $r['pay_options'] .= $modx->parseChunk('tpl_option',$ri);
          }

          $ajax['row_edit'] = $modx->parseDocumentSource($modx->parseChunk('tpl_instructor_edit_s',$r));
          $ajax['ack'] = 'Success';
        break;
        default:
          $ajax['ack'] = 'Failure';
          $ajax['message'] = 'Доступ заборонено!';
        break;
      }
    break;
    case "ituw_edit_row":  
      switch($_SESSION['webuser']['cabinet_type']){
        case "2":
          $id = $_REQUEST['id'];
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_to_user_web` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));

          if($r['order_school'] != ''){
            $school = $r['order_school'];
          }else{
            $school = '122';
          }
          $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE school = "'.$modx->db->escape($school).'" AND status = "1" ');
          while($ri = $modx->db->getRow($q)){
            $name = array();
            $name[] = $ri['lastname'];
            $name[] = $ri['fullname'];
            $name[] = $ri['patronymic'];
            $ri['selected'] = '';
            $ri['data'] = '';
            $ri['name'] = implode(' ',$name);
            $ri['value'] = $ri['user_id'];
            $r['instructor_list'] .= $modx->parseChunk('tpl_option',$ri);
          }

          $ajax['row_edit'] = $modx->parseDocumentSource($modx->parseChunk('tpl_ituw_edit_row',$r));

          $ajax['ack'] = 'Success';
        break;
        case "3":
          $id = $_REQUEST['id'];
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_to_user_web` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));

          if($r['order_school'] != ''){
            $school = $r['order_school'];
          }else{
            $school = '122';
          }
          $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE school = "'.$modx->db->escape($school).'" AND status = "1" ');
          while($ri = $modx->db->getRow($q)){
            $name = array();
            $name[] = $ri['lastname'];
            $name[] = $ri['fullname'];
            $name[] = $ri['patronymic'];
            $ri['selected'] = '';
            $ri['data'] = '';
            $ri['name'] = implode(' ',$name);
            $ri['value'] = $ri['user_id'];
            $r['instructor_list'] .= $modx->parseChunk('tpl_option',$ri);
          }

          $ajax['row_edit'] = $modx->parseDocumentSource($modx->parseChunk('tpl_ituw_edit_row_s',$r));

          $ajax['ack'] = 'Success';

        break;
        default:
          $ajax['ack'] = 'Failure';
          $ajax['message'] = 'Доступ заборонено!';
        break;
      }
    break;
    case "itu_edit_row":  
      switch($_SESSION['webuser']['cabinet_type']){
        case "2":
          $id = $_REQUEST['id'];
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_to_user_g` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));

          if($r['order_school'] != ''){
            $school = $r['order_school'];
          }else{
            $school = '122';
          }
          $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE school = "'.$modx->db->escape($school).'" AND status = "1" ');
          while($ri = $modx->db->getRow($q)){
            $name = array();
            $name[] = $ri['lastname'];
            $name[] = $ri['fullname'];
            $name[] = $ri['patronymic'];
            $ri['selected'] = '';
            $ri['data'] = '';
            $ri['name'] = implode(' ',$name);
            $ri['value'] = $ri['user_id'];
            $r['instructor_list'] .= $modx->parseChunk('tpl_option',$ri);
          }

          $ajax['row_edit'] = $modx->parseDocumentSource($modx->parseChunk('tpl_itu_edit_row',$r));

          $ajax['ack'] = 'Success';
        break;
        case "3":
          $id = $_REQUEST['id'];
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_to_user_g` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));

          if($r['order_school'] != ''){
            $school = $r['order_school'];
          }else{
            $school = '122';
          }
          $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE school = "'.$modx->db->escape($school).'" AND status = "1" ');
          while($ri = $modx->db->getRow($q)){
            $name = array();
            $name[] = $ri['lastname'];
            $name[] = $ri['fullname'];
            $name[] = $ri['patronymic'];
            $ri['selected'] = '';
            $ri['data'] = '';
            $ri['name'] = implode(' ',$name);
            $ri['value'] = $ri['user_id'];
            $r['instructor_list'] .= $modx->parseChunk('tpl_option',$ri);
          }

          $ajax['row_edit'] = $modx->parseDocumentSource($modx->parseChunk('tpl_itu_edit_row_s',$r));

          $ajax['ack'] = 'Success';
        break;
        default:
          $ajax['ack'] = 'Failure';
          $ajax['message'] = 'Доступ заборонено!';
        break;
      }
    break;
    case "search_roww":
      $school = $_REQUEST['school'];
      $search = $_REQUEST['search'];
      $archive = $_REQUEST['archive'];
      $page = $_REQUEST['page'];
      $row_clientsw = $modx->parseDocumentSource($modx->runSnippet('Shop',array('get' => 'list_order_school', 'ax_school' => $school, 'ax_search' => $search, 'ax_archive' => $archive, 'ax_page' => $page)));
      $ajax['paginate_list_order_school'] = $modx->getPlaceholder('paginate_list_order_school');
      $ajax['ack'] = "Success";
      $ajax['row_clientsw'] = $row_clientsw;
    break; 
    case "search_instructor":

      $school = $_REQUEST['school'];
      $search = $_REQUEST['search'];
      $archive = $_REQUEST['archive'];
      $page = $_REQUEST['page'];
      $row_instructors = $modx->parseDocumentSource($modx->runSnippet('Shop',array('get' => 'list_instructors_school', 'ax_school' => $school, 'ax_search' => $search, 'ax_archive' => $archive, 'ax_page' => $page)));
      $ajax['paginate_list_instructors_school'] = $modx->getPlaceholder('paginate_list_instructors_school');
      $ajax['ack'] = "Success";
      $ajax['row_instructors'] = $row_instructors;
    break; 
    case "search_row":

      $school = $_REQUEST['school'];
      $search = $_REQUEST['search'];
      $archive = $_REQUEST['archive'];
      $page = $_REQUEST['page'];
      $row_clients = $modx->parseDocumentSource($modx->runSnippet('Shop',array('get' => 'list_schedule_school', 'ax_school' => $school, 'ax_search' => $search, 'ax_archive' => $archive, 'ax_page' => $page)));
      $ajax['paginate_list_schedule_school'] = $modx->getPlaceholder('paginate_list_schedule_school');
      $ajax['ack'] = "Success";
      $ajax['row_clients'] = $row_clients;
    break; 
    case "ituw_back_row":
      if($_SESSION['webuser']['cabinet_type'] == '3'){
        $id = $_REQUEST['id'];
        $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET archived = "0" WHERE id = "'.$modx->db->escape($id).'" LIMIT 1');
        $ajax['message'] = 'Оновлено!';
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['message'] = 'Доступ заборонено!';
      }
    break;
    case "ituw_remove_row":
      if($_SESSION['webuser']['cabinet_type'] == '3'){
        $id = $_REQUEST['id'];
        $modx->db->query('UPDATE `modx_a_instructor_to_user_web` SET archived = "1" WHERE id = "'.$modx->db->escape($id).'" LIMIT 1');
        $ajax['message'] = 'Оновлено!';
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['message'] = 'Доступ заборонено!';
      }
    break;
    case "change_school":
      if($_REQUEST['school'] != ''){
        $_SESSION['school'] = (int)$_REQUEST['school'];
      }
    break;
    case "sign_view":
      $id = $_REQUEST['id'];

      $q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE `number` = "'.$modx->db->escape($id).'" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
        $r = $modx->db->getRow($q);
        $sign = $modx->parseChunk('tpl_road_sign_item_popup',$r);        
        $ajax['sign'] = $sign;
        $ajax['ack'] = "Success";
      }else{
        $ajax['ack'] = "Failure";
      }

    break;
    case "marking_view":
      $id = $_REQUEST['id'];

      $q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE `number` = "'.$modx->db->escape($id).'" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
        $r = $modx->db->getRow($q);
        $marking = $modx->parseChunk('tpl_road_sign_item_popup',$r);        
        $ajax['marking'] = $marking;
        $ajax['ack'] = "Success";
      }else{
        $ajax['ack'] = "Failure";
      }

    break;
    case "get_sertificate":
      $id = $_REQUEST['id'];

      $check = $modx->db->query('SELECT *, sc.id as id 
          FROM `modx_site_content` sc 
          LEFT JOIN `modx_a_lection_to_user` ltu ON ltu.lection_id = sc.id AND ltu.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" 
          WHERE sc.parent = "'.$modx->db->escape($id).'" AND sc.published = "1" AND sc.deleted = "0" AND ltu.status = "0" ');
      if($modx->db->getRecordCount($check) == 0){

        $r = $modx->db->getRow($modx->db->query('SELECT max(updated) as updated_date
          FROM `modx_site_content` sc 
          LEFT JOIN `modx_a_lection_to_user` ltu ON ltu.lection_id = sc.id AND ltu.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" 
          WHERE sc.parent = "'.$modx->db->escape($id).'" AND sc.published = "1" AND sc.deleted = "0" AND ltu.status = "1" LIMIT 1'));

        $dd['fullname'] = $_SESSION['webuser']['fullname'];
        $dd['lastname'] = $_SESSION['webuser']['lastname'];
        $dd['date'] = date('d.m.Y р.',$r['updated_date']);
        $ajax['print'] = $modx->parseDocumentSource($modx->parseChunk('tpl_online_diplom',$dd));
        $ajax['ack'] = "Success";
      }else{
        $ajax['ack'] = "Failure";
      }
    break;
    case "lection_done":
      $lection_id = $_REQUEST['id'];
      $user_id = $_SESSION['webuser']['internalKey'];
      if($lection_id != '' AND $user_id != ''){
        $modx->db->query('INSERT IGNORE INTO `modx_a_lection_to_user` SET lection_id = "'.$modx->db->escape($lection_id).'", user_id = "'.$modx->db->escape($user_id).'", status = "1", updated = "'.$modx->db->escape(time()).'" ');
        $ajax['ack'] = 'Success';
      }
    break;
    case "fastbuy_form":
      $count = $_REQUEST['count'];
      if(!isset($count) OR $count == '' OR $count < 1){
        $count = 1;
      }
      $product_id = $_REQUEST['product_id'];
      $q = $modx->db->query('SELECT * FROM `modx_a_products` WHERE product_id = "'.$modx->db->escape($product_id).'" AND product_visible = "1" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
        $ajax['ack'] = 'Success';
        $r = $modx->db->getRow($q);
        $r['product_name_seo'] = str_replace('"','',$r['product_name']);
        if($r['product_price_a'] != $r['product_price'] AND $r['product_price_a'] != '0.00'){
          $price = $r['product_price_a'];
        }else{
          $price = $r['product_price'];
        }
        $r['product_count'] = $count;
        $r['product_sum'] = $price*$count;
        $ajax['product'] = $modx->parseDocumentSource($modx->parseChunk('pop_fastbuy_in',$r));
      }else{
        $ajax['ack'] = 'Failure';
      }
    break;
    case "fastbuy":

      $post = $_REQUEST['fastbuy'];
      $error = array();
      $req_fields = array('fullname', 'lastname', 'phone','email','city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'fastbuy['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if (count($error) == 0) {


          $order_full_info = $_REQUEST;
          $order_full_info['docid'] = $modx->documentIdentifier;
          $order_full_info['ip'] = $_SERVER['REMOTE_ADDR'];
          $order_full_info['uri'] = $_SERVER['SCRIPT_URI'];
          $count = $post['product_count'];

          $q = $modx->db->query('SELECT * FROM `modx_a_products` WHERE product_id = "'.$modx->db->escape($post['product_id']).'" LIMIT 1');
          if($modx->db->getRecordCount($q) > 0 ){
            $rproduct = $modx->db->getRow($q);
            if($rproduct['product_price_a'] != '0.00' AND $rproduct['product_price_a'] != $rproduct['product_price']){
              $price = $rproduct['product_price_a'];
            }else{
              $price = $rproduct['product_price'];
            }
            $order_school = $rproduct['product_to_school'];
            $sum = $price*$count;
            $utm = array();
            if(isset($_SESSION['utm']['ref'])){
              $utm['ref'] = $_SESSION['utm']['ref'];
            }
            if(isset($_SESSION['utm']['utm_source'])){
              $utm['utm_source'] = $_SESSION['utm']['utm_source'];
            }
            if(isset($_SESSION['utm']['utm_medium'])){
              $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
            }
            if(isset($_SESSION['utm']['utm_campaign'])){
              $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
            }
            if(isset($_SESSION['utm']['utm_content'])){
              $utm['utm_content'] = $_SESSION['utm']['utm_content'];
            }
            if(isset($_SESSION['utm']['utm_term'])){
              $utm['utm_term'] = $_SESSION['utm']['utm_term'];
            }
            $utm_j = json_encode($utm);
            $hash = uniqid();

            //test!!!
            //$sum = 1;
            
            $registration = false;
            $query = $modx->db->query('SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ');
            if($modx->db->getRecordCount($query) == 0){
              $reg = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'fullname' => $post['fullname'], 'lastname' => $post['lastname'], 'patronymic' => $post['patronymic'], 'city' => $post['city'], 'phone' => $post['phone']));
              $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
              $registration = true;
              $client = $reg;
            }else{
              if($_SESSION['webuser']['internalKey'] != ''){
                $client = $_SESSION['webuser']['internalKey'];
              }else{
                $rr = $modx->db->getRow($query);
                $client = $rr['id'];
              }
            }

            $order_user_info = json_encode(array('fullname' => $post['fullname'], 'lastname' => $post['lastname'], 'patronymic' => $post['patronymic'], 'email' => $post['email'], 'phone' => $post['phone'], 'city' => $post['city']));




            if(is_int($modx->documentIdentifier)){
              if($post['instructor'] != ""){
                $order_from = $post['instructor'];
              }else{
                $order_from = 0;
              }
            }else{
              $qf = $modx->db->getRow($modx->db->query('SELECT user_id,product_paytype FROM `modx_a_instructors` i WHERE i.instructor_url = "'.$modx->db->escape($modx->documentIdentifier).'" LIMIT 1'));
              $order_from_product_paytype = $qf['product_paytype'];
              $order_from = $qf['user_id'];
            }



            $modx->db->query('INSERT INTO `modx_a_order` SET 
              order_client     = "'.$modx->db->escape($client).'", 
              order_created    = "'.$modx->db->escape(time()).'",
              order_status     = "0",
              order_from       = "'.$modx->db->escape($order_from).'",
              order_status_pay = "0",
              order_cost       = "'.$modx->db->escape($sum).'",
              order_user_info  = "'.$modx->db->escape($order_user_info).'",
              order_hash       = "'.$modx->db->escape($hash).'",
              order_school     = "'.$modx->db->escape($order_school).'",
              order_full_info  = "'.$modx->db->escape(json_encode($order_full_info)).'",
              order_utm        = "'.$modx->db->escape($utm_j).'"

              ');
            $order_id = $modx->db->getInsertId();


            $fields = array();

            $modx->db->query('INSERT INTO `modx_a_order_products` SET
              order_id = "'.$modx->db->escape($order_id).'",
              product_id    = "'.$modx->db->escape($rproduct['product_id']).'",
              product_count = "'.$modx->db->escape($count).'",
              product_price = "'.$modx->db->escape($price).'"
            ');
            $fields['productName'][] = $rproduct['product_name'];
            $fields['productCount'][] = $count;
            $fields['productPrice'][] = $price;

            $payment_system_type = $rproduct['product_paytype'];
            if($order_from_product_paytype){
              $payment_system_type = $order_from_product_paytype;
             // $sum = 1;
            }

            $payment_system = json_decode($modx->config['shop_paysystem_'.$payment_system_type],true);
            require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
            $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);
            
            $fields['merchantAccount'] = $payment_system['shop_paymid'];
            $fields['merchantAuthType'] = 'SimpleSignature';
            $fields['merchantDomainName'] = 'pdr-online.com.ua';
            $fields['merchantTransactionSecureType'] = 'AUTO';
            $feilds['defaultPaymentSystem'] = 'card';
            $fields['language'] = 'UA';
            $fields['orderReference'] = $hash;
            $fields['orderDate'] = time();
            $fields['amount'] = $sum;
            $fields['currency'] = 'UAH';
            $fields['returnUrl'] = $modx->config['site_url_b'].$modx->makeUrl(196).'?order='.$hash;
            $fields['serviceUrl'] = $modx->config['site_url_b'].$modx->makeUrl(195);
            $fields['clientFirstName'] = $post['fullname'];
            $fields['clientEmail'] = $post['email'];
            $fields['clientPhone'] = $post['phone'];


            $fields['merchantSignature'] = $wayforpay->buildHash($wf_sig,$fields);

            $form = $wayforpay->buildForm($fields);

            $modx->db->query('UPDATE `modx_a_order` SET 
              payment_system_type = "'.$modx->db->escape($payment_system_type).'"
              WHERE order_id = "'.$modx->db->escape($order_id).'"
              ');


            $ajax['payform'] = $form;
            $ajax['ack'] = "Success";


            $theme = 'Нова покупка на сайті '.$modx->config['site_name'];

            $message = $modx->parseDocumentSource($modx->parseChunk('mail_fastbuy',
              array('fullname'      => $post['fullname'],
                'phone'             => $post['phone'],
                'city'              => $post['city'],
                'email'             => $post['email'],
                'sum'               => $sum,
                'url'               => $modx->config['site_url'], 
                'site_name'         => $modx->config['site_name'])));
            //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);

            /*
            if($modx->config['esputnik_subscribe'] == '1'){
              include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
              $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);

              $post['groups'] = $modx->config['esputnik_group_id_online'];
              $answer = $esputnik->subscribe_contact($post);
            }
            */

            $ajax['registration'] = $registration;
            $ajax['ack'] = 'Success';



          }else{
            $ajax['message'] = 'Помилка, зверніться до адміністратора';
            $ajax['ack'] = 'Failure';
          }
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "update_schedule_school":
      $ajax['calendar'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'calendar_schedule_school', 'ax_type' => $_GET['type'], 'ax_date' => $_GET['date'], 'ax_school' => $_GET['school'])));
    break;
    case "update_schedule":
      $ajax['calendar'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'calendar_schedule', 'ax_type' => $_GET['type'], 'ax_date' => $_GET['date'], 'ax_instructor' => $_GET['instructor'])));
    break;
    case "view_schedule":
      $instructor_id = $modx->db->escape($_REQUEST['instructor_id']);
      $calendar = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'calendar_schedule', 'ax_instructor' => $instructor_id)));

      $ajax['schedule'] = $modx->parseDocumentSource($modx->parseChunk('tpl_view_instructor_schedule',array('instructor_id' => $instructor_id, 'calendar' => $calendar)));
    break;
    case "cdi":
      if($_SESSION['webuser']['cabinet_type'] == '1'){

        $post = $_REQUEST['cdi'];
        switch($post['action']){
          case "0":
            //create
            $full = $post['daytime'];
            $type = $post['type'];
            $offset = $post['offset'];
            $comment = $post['comment'];
            $exp = explode(' ',$post['daytime']);
            $day = $exp[0];
            $time = $exp[1];
            $duration = 60;
            $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule` SET
              user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
              full = "'.$modx->db->escape($full).'",
              day = "'.$modx->db->escape($day).'",
              type = "'.$modx->db->escape($type).'",
              time = "'.$modx->db->escape($time).'",
              duration = "'.$modx->db->escape($duration).'",
              offset = "'.$modx->db->escape($offset).'",
              comment = "'.$modx->db->escape($comment).'",
              pickup_address = "'.$modx->db->escape($post['pickup_address']).'"
            ');
            $schedule_id = $modx->db->getInsertId();
            if($schedule_id != ''){
              $r_check_client_id = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_to_user` WHERE user_name = "'.$modx->db->escape($post['client']).'" AND type = "'.$modx->db->escape($type).'" LIMIT 1'));
              $client_id = $r_check_client_id['user_id'];
              $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule_to_reserv` SET schedule_id = "'.$modx->db->escape($schedule_id).'", status = "'.$modx->db->escape($post['status']).'", client = "'.$modx->db->escape($post['client']).'", client_id = "'.$modx->db->escape($client_id).'" ');
              //віднімаємо у клієнта уроки
              if($post['client'] != '' AND $post['status'] == '2'){
                $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance - 1 WHERE user_name = "'.$modx->db->escape($post['client']).'" AND type = "'.$modx->db->escape($post['type']).'" LIMIT 1');
              }
            }
          break;
          case "1":
            $sch = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_schedule` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND full = "'.$modx->db->escape($post['daytime']).'" LIMIT 1'));
            if($post['status'] == 0){
              //delete
              //повертаємо клієнту уроки
              $r_st = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_schedule_to_reserv` istr LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = istr.schedule_id WHERE istr.schedule_id = "'.$modx->db->escape($sch['id']).'" LIMIT 1'));
              if($r_st['status'] == '2' AND $r_st['client'] != ''){ 
                $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance + 1 WHERE user_name = "'.$modx->db->escape($r_st['client']).'" AND type = "'.$modx->db->escape($r_st['type']).'" LIMIT 1');
              }

              $modx->db->query('DELETE FROM `modx_a_instructor_schedule` WHERE id = "'.$modx->db->escape($sch['id']).'" LIMIT 1');
              $modx->db->query('DELETE FROM `modx_a_instructor_schedule_to_reserv` WHERE schedule_id = "'.$modx->db->escape($sch['id']).'" LIMIT 1');


              //here
            }else{
              //update
              $full = $post['daytime'];
              $type = $post['type'];
              $offset = $post['offset'];
              $comment = $post['comment'];
              $exp = explode(' ',$post['daytime']);
              $day = $exp[0];
              $time = $exp[1];
              $duration = 60;
              $modx->db->query('UPDATE `modx_a_instructor_schedule` SET
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
                full = "'.$modx->db->escape($full).'",
                day = "'.$modx->db->escape($day).'",
                type = "'.$modx->db->escape($type).'",
                time = "'.$modx->db->escape($time).'",
                duration = "'.$modx->db->escape($duration).'",
                offset = "'.$modx->db->escape($offset).'",
                comment = "'.$modx->db->escape($comment).'",
                pickup_address = "'.$modx->db->escape($post['pickup_address']).'"
                WHERE id = "'.$modx->db->escape($sch['id']).'"
                LIMIT 1
              ');

              $r_st = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_schedule_to_reserv` istr LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = istr.schedule_id WHERE istr.schedule_id = "'.$modx->db->escape($sch['id']).'" LIMIT 1')); 
              //якщо статус був 2 і був клієнт і статус змінився на інший               
              if($r_st['status'] == '2' AND $r_st['client'] != ''){
                switch($post['status']){
                  case "0":
                  case "1":
                  case "3":
                    //повертаємо клієнту уроки
                    $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance + 1 WHERE user_name = "'.$modx->db->escape($r_st['client']).'" AND type = "'.$modx->db->escape($r_st['type']).'" LIMIT 1');
                  break;
                }
              }
              //якщо змінився клієнт   
              if($r_st['client'] != $post['client']){
                //статус був 2 повертаємо гроші
                if($r_st['status'] == '2'){
                    $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance + 1 WHERE user_name = "'.$modx->db->escape($r_st['client']).'" AND type = "'.$modx->db->escape($r_st['type']).'" LIMIT 1');
                }
                //та якщо клієнт новий  та статус 2 то списуємо йому
                if($post['status'] == '2' AND $post['client'] != ''){
                  //списуємо клієнту уроки
                  $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance - 1 WHERE user_name = "'.$modx->db->escape($post['client']).'" AND type = "'.$modx->db->escape($r_st['type']).'" LIMIT 1');             
                }
              }
              //якщо статус став 2 і не був 2 і є клієнт
              if($post['status'] == '2' AND $post['client'] != ''){
                if($r_st['status'] != '2'){
                  //списуємо клієнту уроки
                  $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance - 1 WHERE user_name = "'.$modx->db->escape($post['client']).'" AND type = "'.$modx->db->escape($r_st['type']).'" LIMIT 1');             
                }
              }

              $r_check_client_id = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructor_to_user` WHERE user_name = "'.$modx->db->escape($post['client']).'" AND type = "'.$modx->db->escape($type).'" LIMIT 1'));
              $client_id = $r_check_client_id['user_id'];

              $modx->db->query('UPDATE `modx_a_instructor_schedule_to_reserv` SET status = "'.$modx->db->escape($post['status']).'", client = "'.$modx->db->escape($post['client']).'", client_id = "'.$modx->db->escape($client_id).'" WHERE schedule_id = "'.$modx->db->escape($sch['id']).'" LIMIT 1');
              //here
            }
          break;
        }
        $ajax['ack'] = 'Success';
      }else{
        $post = $_REQUEST['cdi_book'];

        $check = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND id = "'.$modx->db->escape($post['book_id']).'" LIMIT 1');
        if($modx->db->getRecordCount($check) > 0){
          $r = $modx->db->getRow($check);
          $schedule_id = $post['schedule_id'];
          $instructor_id = $post['instructor_id'];
          $comment = $post['comment'];
          //ТУТ ЗАПИС ВІД КЛІЄНТА!
/*
0 Не доступно
1 Доступно
2 Заброньовано
3 Скасовано
*/

          if($schedule_id != ''){
            //Букаємо в розкладі тип заняття
            $modx->db->query('UPDATE `modx_a_instructor_schedule` SET 
              type = "'.$modx->db->escape($r['type']).'"
              WHERE id = "'.$modx->db->escape($schedule_id).'"
            ');
            //Букаємо в розкладі тип заняття
            $modx->db->query('UPDATE `modx_a_instructor_schedule_to_reserv` SET 
              status = "2",
              client = "'.$modx->db->escape($r['user_name']).'",
              client_id = "'.$modx->db->escape($r['user_id']).'"
              WHERE schedule_id = "'.$modx->db->escape($schedule_id).'"
            ');
            //Додаємо запис в табличку клієнт резервів
            $modx->db->query('INSERT INTO `modx_a_user_schedule_to_reserv` SET
              schedule_id = "'.$modx->db->escape($post['schedule_id']).'",
              created = "'.$modx->db->escape(time()).'",
              status = "2",
              status_prove = "0",
              tg_manager = "0",
              tg_user = "1",
              instructor_id = "'.$modx->db->escape($instructor_id).'",
              client_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
              user_comment = "'.$modx->db->escape($comment).'"
            ');

            //віднімаємо у клієнта уроки
            if($r['user_name'] != ''){
              $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance - 1 WHERE user_name = "'.$modx->db->escape($r['user_name']).'" AND type = "'.$modx->db->escape($r['type']).'" LIMIT 1');
            }
          }




          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
        }
      }
    break;
    case "book_cancel_u":
      //скасування користувачем
      $book_id = $_REQUEST['book'];


      $q = $modx->db->query('SELECT * FROM `modx_a_user_schedule_to_reserv` ustr 
          LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id
          WHERE ustr.id = "'.$modx->db->escape($book_id).'" AND ustr.status = "2" AND ustr.client_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
          $r = $modx->db->getRow($q);
          $schedule_id = $r['schedule_id'];
          $type = $r['type'];
          $client_id = $r['client_id'];


          $date = new DateTime($r['full']);
          if($r['offset'] > 0){
            $date->modify("+".($r['offset']*60)." seconds");
          }
          setlocale(LC_TIME, 'uk_UA.UTF-8');
          $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());

          $now = new DateTime();
          $now->modify("+".$modx->config['server_offset_time']." seconds");
          $interval = $now->diff($date);
          if($now > $date){
            $r['start'] = '0';
          }else{
            $r['start'] = $interval->days * 24 + $interval->h;
          }
          if($r['start'] > $modx->config['time_to_change_book']){
           
            $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance + 1 WHERE user_id = "'.$modx->db->escape($client_id).'" AND type = "'.$modx->db->escape($type).'" LIMIT 1');         
            $modx->db->query('UPDATE `modx_a_instructor_schedule` SET type = "0" WHERE id = "'.$modx->db->escape($schedule_id).'" LIMIT 1');
            $modx->db->query('UPDATE `modx_a_instructor_schedule_to_reserv` SET status = "1", client = "", client_id = "" WHERE schedule_id = "'.$modx->db->escape($schedule_id).'" LIMIT 1');
            $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET status_prove = "1", status = "3", tg_user = "0" WHERE id = "'.$modx->db->escape($book_id).'" LIMIT 1');


            include_once MODX_BASE_PATH . "assets/shop/telegram.class.php";
            $telegram = new Telegram($modx);
            $q_message = $modx->db->query('SELECT * FROM `modx_a_telegram_actions` WHERE data = "'.$modx->db->escape($book_id).'" AND action_id = "book_schedule" LIMIT 1');
            if($modx->db->getRecordCount($q_message) > 0){


              $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
                LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
                LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
                LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = isc.user_id
                 WHERE ustr.id = "'.$modx->db->escape($book_id).'" LIMIT 1 ');
              $r = $modx->db->getRow($q);

              $find_message = $modx->db->getRow($q_message);
              $keyboard = [[
                  ['text' => '❌ Запит скасовано', 'callback_data' => '#']
              ]];
              $send_data['reply_markup'] = json_encode([
                  'inline_keyboard' => $keyboard
              ]);
              $send_data['message_id'] = $find_message['message_id'];

              $date = new DateTime($r['full']);
              if($r['offset'] > 0){
                $date->modify("+".($r['offset']*60)." seconds");
              }
              setlocale(LC_TIME, 'uk_UA.UTF-8');
              $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
              $answer = '🐌 Клієнт '.$r['user_name'].' ('.$r['user_phone'].') заняття в '.$r['date'].'';
              if($r['user_comment'] != ''){
                $answer .= '; Коментар клієнта: '.$r['user_comment'];
              }
              $answer .='
*🔴 Скасовано*';

              $send_data['text'] = $telegram->escapeMarkdownV2($answer);
              $send_data['chat_id'] = $find_message['chat_id'];
              $send_data['parse_mode'] = 'MarkdownV2';
              $res = $telegram->editMessage($send_data);
              $modx->db->query('UPDATE `modx_a_telegram_actions` SET archive = "1" WHERE id = "'.$modx->db->escape($find_message['id']).'" LIMIT 1');

              $answer = '🐌 *УВАГА! ЗАПИТ:* Клієнт '.$r['user_name'].' ('.$r['user_phone'].') на заняття в '.$r['date'].'';
              if($r['user_comment'] != ''){
                $answer .= '; Коментар клієнта: '.$r['user_comment'];
              }
              $answer .='
  *🔴 Було Скасовано*';

              $send_data['text'] = $telegram->escapeMarkdownV2($answer);
              $send_data['chat_id'] = $find_message['chat_id'];
              $send_data['parse_mode'] = 'MarkdownV2';
              $res = $telegram->sendMessage($send_data);


            }

            $ajax['plan_lessons'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'lessons_plan', 'tpl' => 'tpl_lesson_booked_user', 'tpl_empty' => 'tpl_lesson_plan_empty')));
            $ajax['ack'] = 'Success';


          }else{
            $ajax['ack'] = 'Failure';
          }

      }else{
        $ajax['ack'] = 'Failure';
      }
    break;
    case "book_apply":
      //Підтвердження броні інструктором
      $book_id = $_REQUEST['book'];

      $q = $modx->db->query('SELECT * FROM `modx_a_user_schedule_to_reserv` ustr 
          LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id
          WHERE ustr.id = "'.$modx->db->escape($book_id).'" AND ustr.status_prove = "0" AND ustr.instructor_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){

          include_once MODX_BASE_PATH . "assets/shop/telegram.class.php";
          $telegram = new Telegram($modx);
          $q_message = $modx->db->query('SELECT * FROM `modx_a_telegram_actions` WHERE data = "'.$modx->db->escape($book_id).'" AND action_id = "book_schedule" AND archive = "0" LIMIT 1');
          if($modx->db->getRecordCount($q_message) > 0){
            $find_message = $modx->db->getRow($q_message);
            $keyboard = [[
                ['text' => '✅ Запит підтверджено', 'callback_data' => '#']
            ]];

            $send_data['reply_markup'] = json_encode([
                'inline_keyboard' => $keyboard
            ]);
            $send_data['message_id'] = $find_message['message_id'];

            $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
              LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
              LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
              LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = isc.user_id
               WHERE ustr.id = "'.$modx->db->escape($book_id).'" LIMIT 1 ');
            $r = $modx->db->getRow($q);

            $date = new DateTime($r['full']);
            if($r['offset'] > 0){
              $date->modify("+".($r['offset']*60)." seconds");
            }
            setlocale(LC_TIME, 'uk_UA.UTF-8');
            $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
            $answer = '🐌 Клієнт '.$r['user_name'].' ('.$r['user_phone'].') заняття в '.$r['date'].'';
            if($r['user_comment'] != ''){
              $answer .= '; Коментар клієнта: '.$r['user_comment'];
            }

            $answer .='
*🟢 Заброньовано*';
            $send_data['text'] = $telegram->escapeMarkdownV2($answer);
            $send_data['chat_id'] = $find_message['chat_id'];
            $send_data['parse_mode'] = 'MarkdownV2';
            $res = $telegram->editMessage($send_data);
            $modx->db->query('UPDATE `modx_a_telegram_actions` SET archive = "1" WHERE id = "'.$modx->db->escape($find_message['id']).'" LIMIT 1');
          }

        $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET status_prove = "1", tg_user = "0" WHERE id = "'.$modx->db->escape($book_id).'" LIMIT 1');

        $ajax['plan_lessons'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'instructor_students_schedule', 'tpl' => 'tpl_lesson_booked_instructor', 'tpl_empty' => 'tpl_lesson_booked_instructor_empty')));
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
      }

    break;
    case "book_cancel":
      //Скасування інструктором
      $book_id = $_REQUEST['book'];

      $q = $modx->db->query('SELECT * FROM `modx_a_user_schedule_to_reserv` ustr 
          LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id
          WHERE ustr.id = "'.$modx->db->escape($book_id).'" AND ustr.status = "2" AND ustr.instructor_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
          $r = $modx->db->getRow($q);
          $schedule_id = $r['schedule_id'];
          $type = $r['type'];
          $client_id = $r['client_id'];
          $modx->db->query('UPDATE `modx_a_instructor_to_user` SET lesson_balance = lesson_balance + 1 WHERE user_id = "'.$modx->db->escape($client_id).'" AND type = "'.$modx->db->escape($type).'" LIMIT 1');         
          $modx->db->query('UPDATE `modx_a_instructor_schedule` SET type = "0" WHERE id = "'.$modx->db->escape($schedule_id).'" LIMIT 1');
          $modx->db->query('UPDATE `modx_a_instructor_schedule_to_reserv` SET status = "1", client = "", client_id = "" WHERE schedule_id = "'.$modx->db->escape($schedule_id).'" LIMIT 1');
          $modx->db->query('UPDATE `modx_a_user_schedule_to_reserv` SET status_prove = "1", status = "3", tg_user = "0" WHERE id = "'.$modx->db->escape($book_id).'" LIMIT 1');


          include_once MODX_BASE_PATH . "assets/shop/telegram.class.php";
          $telegram = new Telegram($modx);
          $q_message = $modx->db->query('SELECT * FROM `modx_a_telegram_actions` WHERE data = "'.$modx->db->escape($book_id).'" AND action_id = "book_schedule" AND archive = "0" LIMIT 1');
          if($modx->db->getRecordCount($q_message) > 0){
            $find_message = $modx->db->getRow($q_message);
            $keyboard = [[
                ['text' => '❌ Запит скасовано', 'callback_data' => '#']
            ]];
            $send_data['reply_markup'] = json_encode([
                'inline_keyboard' => $keyboard
            ]);
            $send_data['message_id'] = $find_message['message_id'];
      

            $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
              LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
              LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
              LEFT JOIN `modx_a_telegram` tg ON tg.modx_id = isc.user_id
               WHERE ustr.id = "'.$modx->db->escape($book_id).'" LIMIT 1 ');
            $r = $modx->db->getRow($q);

            $date = new DateTime($r['full']);
            if($r['offset'] > 0){
              $date->modify("+".($r['offset']*60)." seconds");
            }
            setlocale(LC_TIME, 'uk_UA.UTF-8');
            $r['date'] = strftime('%A, %d %B %Y, %H:%M', $date->getTimestamp());
            $answer = '🐌 Клієнт '.$r['user_name'].' ('.$r['user_phone'].') заняття в '.$r['date'].'';
            if($r['user_comment'] != ''){
              $answer .= '; Коментар клієнта: '.$r['user_comment'];
            }
            $answer .='
*🔴 Скасовано*';
            $send_data['text'] = $telegram->escapeMarkdownV2($answer);

            $send_data['chat_id'] = $find_message['chat_id'];
            $send_data['parse_mode'] = 'MarkdownV2';
            $res = $telegram->editMessage($send_data);
            $modx->db->query('UPDATE `modx_a_telegram_actions` SET archive = "1" WHERE id = "'.$modx->db->escape($find_message['id']).'" LIMIT 1');
          }

        $ajax['plan_lessons'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'instructor_students_schedule', 'tpl' => 'tpl_lesson_booked_instructor', 'tpl_empty' => 'tpl_lesson_booked_instructor_empty')));
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
      }


    break;
    case "cdi_daytime_manager":
      if($_SESSION['webuser']['cabinet_type'] == '2' OR $_SESSION['webuser']['cabinet_type'] == '3'){
        $user = $_REQUEST['user'];
        $daytime = $_REQUEST['daytime'];

        $q = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
          LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
          WHERE isc.full = "'.$modx->db->escape($daytime).'" AND isc.user_id = "'.$modx->db->escape($user).'"
          LIMIT 1
        ');
        if($modx->db->getRecordCount($q) > 0){
          //Є дата
          $r = $modx->db->getRow($q);
          $r['full_date'] = date('d-m-Y H:i',strtotime($r['full']));
          $r['daytime'] = $daytime;
          //$r['client'] = ''; pickup_address
          switch($r['status']){
            case "0":
              $r['status_class'] = 's_default';
              $r['status_text'] = 'Не доступно';
            break;
            case "1":
              $r['status_class'] = 's_success';
              $r['status_text'] = 'Доступно';
            break;
            case "2":
              $r['status_class'] = 's_warning';
              $r['status_text'] = 'Заброньовано';
            break;
            case "3":
              $r['status_class'] = 's_danger';
              $r['status_text'] = 'Скасовано';
            break;
          }
          switch($r['type']){
            case "":
              $r['type_text'] = 'Не вказано';
            break;
            case "0":
              $r['type_text'] = 'Звичайне заняття';
            break;
            case "1":
              $r['type_text'] = 'Додаткове заняття';
            break;
            case "2":
              $r['type_text'] = 'Подача авто на екзамен в ТСЦ';
            break;
          }
          $ajax['ack'] = 'Success';
          $ajax['form'] = $modx->parseChunk('tpl_pop_cdi_manager', $r);
        }else{
          $ajax['ack'] = 'Failure';
        }
      }else{
        $ajax['ack'] = 'Failure';
      }
    break;
    case "cdi_daytime_user":
      if($_SESSION['webuser']['cabinet_type'] == '0'){
        $daytime = $_REQUEST['daytime'];
        $instructor_id = $_REQUEST['instructor_id'];
        $q = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
          LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
          LEFT JOIN `modx_web_user_attributes` wua ON isc.user_id = wua.internalKey
          WHERE isc.full = "'.$modx->db->escape($daytime).'" AND isc.user_id = "'.$modx->db->escape($instructor_id).'"
          LIMIT 1
        ');
        if($modx->db->getRecordCount($q) > 0){
          //Є дата запис клієнта
          $r = $modx->db->getRow($q);

          $date = new DateTime($r['full']);
          $now = new DateTime();
          $now->modify("+".$modx->config['server_offset_time']." seconds");
          $interval = $now->diff($date);

          $hours = $interval->days * 24 + $interval->h;
          if($r['status'] == '1' AND $now < $date){
            $q2 = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user` WHERE instructor_name = "'.$modx->db->escape($r['cabinet_syncname']).'" AND user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND lesson_balance > 0');
            if($modx->db->getRecordCount($q2) > 0){
              //Є дата запис клієнта
              $cnt = 0;
              while($r2 = $modx->db->getRow($q2)){
               // var_dump($r2);die;  
                switch($r2['type']){
                  default:
                    $r2['type_text'] = 'Не вказано';
                  break;
                  case "0":
                    $r2['type_text'] = 'Звичайне заняття';
                  break;
                  case "1":
                    $r2['type_text'] = 'Додаткове заняття';
                  break;
                  case "2":
                    $r2['type_text'] = 'Подача авто на екзамен в ТСЦ';
                  break;
                }
                if($cnt == 0){
                  $r2['checked'] = 'checked';
                }else{
                  $r2['checked'] = '';
                }
                $r['lessons_list'] .= $modx->parseChunk('tpl_lessons_list', $r2);
                $cnt++;

              }
              $r['instructor_id'] = $r['user_id'];
              $r['full_date'] = date('d-m-Y H:i',strtotime($r['full']));
              $r['date_h'] = date('H',strtotime($r['full']));
              $r['daytime'] = $daytime;

              $full_day = strtotime(date('d-m-Y',strtotime($r['full'])));
              $today = strtotime(date('d-m-Y',time()+$modx->config['server_offset_time']));

              $r['action'] = '1';
              
              $ajax['form'] = $modx->parseChunk('tpl_pop_cdi_book', $r);
              $ajax['ack'] = 'Success';
              
            }else{
              $ajax['message'] = 'Недоступно для бронювання';
              $ajax['ack'] = 'Failure';
            }
          }else{
            $ajax['message'] = 'Недоступно для бронювання';
            $ajax['ack'] = 'Failure';
          }
        }else{
          //немає дати
          $ajax['message'] = 'Недоступно для бронювання';
          $ajax['ack'] = 'Failure';
        }
      }else{
        $ajax['message'] = 'Недоступно для бронювання';
        $ajax['ack'] = 'Failure';
      }
    break;
    case "cdi_daytime":
      if($_SESSION['webuser']['cabinet_type'] == '1'){
        $daytime = $_REQUEST['daytime'];

        $q = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
          LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
          WHERE isc.full = "'.$modx->db->escape($daytime).'" AND isc.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"
          LIMIT 1
        ');
        if($modx->db->getRecordCount($q) > 0){
          //Є дата

          $r = $modx->db->getRow($q);
          $r['full_date'] = date('d-m-Y H:i',strtotime($r['full']));
          $r['date_h'] = date('H',strtotime($r['full']));
          $r['daytime'] = $daytime;

          $full_day = strtotime(date('d-m-Y',strtotime($r['full'])));
          $today = strtotime(date('d-m-Y',time()+$modx->config['server_offset_time']));
          if($full_day < $today){
            //дата в минулому
            switch($r['status']){
              case "0":
                $r['status_class'] = 's_default';
                $r['status_text'] = 'Не доступно';
              break;
              case "1":
                $r['status_class'] = 's_success';
                $r['status_text'] = 'Доступно';
              break;
              case "2":
                $r['status_class'] = 's_warning';
                $r['status_text'] = 'Заброньовано';
              break;
              case "3":
                $r['status_class'] = 's_danger';
                $r['status_text'] = 'Скасовано';
              break;
            }
            switch($r['type']){
              default:
                $r['type_text'] = 'Не вказано';
              break;
              case "0":
                $r['type_text'] = 'Звичайне заняття';
              break;
              case "1":
                $r['type_text'] = 'Додаткове заняття';
              break;
              case "2":
                $r['type_text'] = 'Подача авто на екзамен в ТСЦ';
              break;
            }
            $ajax['ack'] = 'Success';
            $ajax['form'] = $modx->parseChunk('tpl_pop_cdi_info', $r);

          }else{
            //Дата сьогодні або в майбутньому

            $r['action'] = '1';
            $r['client_list'] = '';
            if($_SESSION['webuser']['cabinet_syncname'] != ''){
              $q_client_list = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user` WHERE instructor_name = "'.$modx->db->escape($_SESSION['webuser']['cabinet_syncname']).'" ');
              while($r_client_list = $modx->db->getRow($q_client_list)){
                switch($r_client_list['type']){
                  default: 
                  case "0":
                    $type = 'Осн';
                  break;
                  case "1":
                    $type = 'Доп';
                  break;
                  case "2":
                    $type = 'Под';
                  break;
                }
                $name = $r_client_list['user_name'].' '.$r_client_list['user_phone'].' ('.$r_client_list['lesson_total'].'/'.$r_client_list['lesson_balance'].') '.$type;
                $val = $r_client_list['user_name'];
                $r['client_list'] .= $modx->parseChunk('tpl_option',array('selected' => '', 'data' => 'data-lesson-type="'.$r_client_list['type'].'" data-lesson-name="'.$name.'"', 'value' => $val, 'name' => $name));
              }
            }
            $q_c = $modx->db->query('SELECT * FROM `modx_a_instructor_settings_pickup` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
            while($r_c = $modx->db->getRow($q_c)){

              $r_c['pickup_address'] = str_replace("'",'`',$r_c['pickup_address']);
              $r['option_pickup'] .= $modx->parseChunk('tpl_option', array('value' => $r_c['pickup_address'], 'name' => $r_c['pickup_address'], 'selected' => '', 'data' => ''));
            }
            $ajax['form'] = $modx->parseChunk('tpl_pop_cdi', $r);


          }
        }else{
          //немає дати

          $full_day = strtotime(date('d-m-Y',strtotime($daytime)));
          $full_day_h = strtotime(date('H',strtotime($daytime)));
          $today = strtotime(date('d-m-Y',time()+$modx->config['server_offset_time']));
          $today_h = date('H',time()+$modx->config['server_offset_time']);

          $edit = true;
          if($full_day == $today){
            if($today_h >= '23'){
              $edit = false;
            }else{
              $edit = true;
            }
          }else{
            if($full_day < $today){
              $edit = false;
            }else{
              $edit = true;
            }
          }
          if($edit){
            //Дата сьогодні або в майбутньому
            if($_SESSION['webuser']['cabinet_syncname'] != ''){
              $q_client_list = $modx->db->query('SELECT * FROM `modx_a_instructor_to_user` WHERE instructor_name = "'.$modx->db->escape($_SESSION['webuser']['cabinet_syncname']).'" ');
              while($r_client_list = $modx->db->getRow($q_client_list)){
                switch($r_client_list['type']){
                  default: 
                  case "0":
                    $type = 'Осн';
                  break;
                  case "1":
                    $type = 'Доп';
                  break;
                  case "2":
                    $type = 'Под';
                  break;
                }
                $name = $r_client_list['user_name'].' '.$r_client_list['user_phone'].' ('.$r_client_list['lesson_total'].'/'.$r_client_list['lesson_balance'].') '.$type;
                $val = $r_client_list['user_name'];

                $r['client_list'] .= $modx->parseChunk('tpl_option',array('selected' => '', 'data' => 'data-lesson-type="'.$r_client_list['type'].'" data-lesson-name="'.$name.'"', 'value' => $val, 'name' => $name));
              }
            }
            $r['pickup_address'] = '';
            $q_c = $modx->db->query('SELECT * FROM `modx_a_instructor_settings_pickup` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
            while($r_c = $modx->db->getRow($q_c)){
              if($r_c['pickup_default'] == '1'){
                $r['pickup_address'] = $r_c['pickup_address'];
              }
              $r_c['pickup_address'] = str_replace("'",'`',$r_c['pickup_address']);
              $r['option_pickup'] .= $modx->parseChunk('tpl_option', array('value' => $r_c['pickup_address'], 'name' => $r_c['pickup_address'], 'selected' => '', 'data' => ''));
            }
            $r['type'] = '1';
            $r['client'] = '';
            $r['status'] = '0';
            $r['action'] = '0';
            $r['offset'] = '0';
            $r['comment'] = '';
            $r['full_date'] = date('d-m-Y H:i',strtotime($daytime));
            $r['date_h'] = date('H',strtotime($daytime));
            $r['daytime'] = $daytime;
            $ajax['form'] = $modx->parseChunk('tpl_pop_cdi', $r);

          }else{
            //дата в минулому          
            $r['full_date'] = date('d-m-Y H:i',strtotime($daytime));
            $r['date_h'] = date('H',strtotime($daytime));
            $r['daytime'] = $daytime;

            $r['pickup_address'] = '-';
            $r['comment'] = '-';
            $r['client'] = '-';
            $r['offset'] = '0';
            $r['status_class'] = 's_default';
            $r['status_text'] = 'Не доступно';

            $r['type_text'] = '-';
            $ajax['form'] = $modx->parseChunk('tpl_pop_cdi_info', $r);

          }
        }
        $ajax['ack'] = 'Success';
      }else{
        $ajax['message'] = 'Щось пішло не так';
        $ajax['ack'] = 'Failure';
      }
    break;
    case "cdi_week":
    
      if($_SESSION['webuser']['cabinet_type'] == '1'){

        $next_monday = strtotime('next Monday');
        //$dd = date('N', $next_monday);

        $date = new DateTime();
        $date->setTimestamp($next_monday);

        for($d = 1; $d <= 7; $d++){
          if($d == 7){
            $day = 0;
          }else{
            $day = $d;
          }
          $q = $modx->db->query('SELECT * FROM `modx_a_instructor_settings` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND day = "'.$modx->db->escape($day).'" ORDER BY day_start ASC');
          if($modx->db->getRecordCount($q) > 0){
            $ajax['ack'] = 'Success';

            while($r = $modx->db->getRow($q)){
              for ($j = $r['day_start']; $j < $r['day_end']; $j++) {
                $time = $j.':00';
                $class = $shop->calendarStatus('1');
                $day = $date->format('Y-m-d');
                $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                $full = $day.' '.$time;
                $duration = 60;
                $type = $r['type'];
                $offset = $r['offset'];

                $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule` SET
                  user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
                  full = "'.$modx->db->escape($full).'",
                  day = "'.$modx->db->escape($day).'",
                  time = "'.$modx->db->escape($time).'",
                  type = "'.$modx->db->escape($type).'",
                  offset = "'.$modx->db->escape($offset).'",
                  duration = "'.$modx->db->escape($duration).'",
                  pickup_address = "'.$modx->db->escape($r['pickup_address']).'"
                ');
                $schedule_id = $modx->db->getInsertId();
                if($schedule_id != ''){
                  $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule_to_reserv` SET schedule_id = "'.$modx->db->escape($schedule_id).'", status = "1"');
                }
              }
            }
            
          }

          $date->modify('+1 day');

        }


      }else{
        $ajax['ack'] = 'Failure';
      }
      
    break;
    case "cdi_day":
      if($_SESSION['webuser']['cabinet_type'] == '1'){
        $q = $modx->db->query('SELECT * FROM `modx_a_instructor_settings` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND day = "'.$modx->db->escape($_REQUEST['day']).'" ORDER BY day_start ASC');
        if($modx->db->getRecordCount($q) > 0){
          $ajax['ack'] = 'Success';
          $date = new DateTime($_REQUEST['full']);
          while($r = $modx->db->getRow($q)){
            for ($j = $r['day_start']; $j < $r['day_end']; $j++) {
              $time = $j.':00';
              $class = $shop->calendarStatus('1');
              $day = $date->format('Y-m-d');
              $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
              $full = $day.' '.$time;
              $duration = 60;
              $type = $r['type'];
              $offset = $r['offset'];

              $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule` SET
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
                full = "'.$modx->db->escape($full).'",
                day = "'.$modx->db->escape($day).'",
                time = "'.$modx->db->escape($time).'",
                type = "'.$modx->db->escape($type).'",
                offset = "'.$modx->db->escape($offset).'",
                duration = "'.$modx->db->escape($duration).'",
                pickup_address = "'.$modx->db->escape($r['pickup_address']).'"
              ');
              $schedule_id = $modx->db->getInsertId();
              if($schedule_id != ''){
                $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_schedule_to_reserv` SET schedule_id = "'.$modx->db->escape($schedule_id).'", status = "1"');
              }
            }
          }
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['message'] = 'Помилка!. Спочатку заповніть в налаштуваннях розклад для цього дня тижня!';
        }
      }else{
        $ajax['ack'] = 'Failure';
      }
    break;
    case "instructor_setting_pickup":
      if($_SESSION['webuser']['cabinet_type'] == '1'){
        $post = $_REQUEST['instructor_setting_pickup'];
        $error = array();
        if (count($error) == 0) {
          $modx->db->query('DELETE FROM `modx_a_instructor_settings_pickup` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
          foreach($post['pickup_address'] as $k => $v){
            if($post['pickup_address'][$k] != ''){
              $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_settings_pickup` SET 
                pickup_default = "'.$modx->db->escape($post['pickup_default'][$k]).'",
                pickup_address = "'.$modx->db->escape($post['pickup_address'][$k]).'",
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"
              ');
            }
          }
          

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
      }else{
        $ajax['ack'] = 'Failure';
      }
    break;
    case "instructor_setting":
      if($_SESSION['webuser']['cabinet_type'] == '1'){
        $post = $_REQUEST['instructor_setting'];
        $error = array();
        /*
        $req_fields = array('');

        foreach ($req_fields as $key => $value) {
            if ($post[$value] == '') {
                $error[] = 'profile['.$value.']';
                $ajax['msg'] = 'Заповніть всі необхідні поля';
            }
        }
        */
        if (count($error) == 0) {
          $modx->db->query('DELETE FROM `modx_a_instructor_settings` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
          foreach($post['day'] as $k => $v){
            if($post['day'][$k] != ''){
              $modx->db->query('INSERT INTO `modx_a_instructor_settings` SET 
                day = "'.$modx->db->escape($post['day'][$k]).'", 
                duration = "'.$modx->db->escape($post['duration'][$k]).'", 
                day_start = "'.$modx->db->escape($post['day_start'][$k]).'",
                day_end = "'.$modx->db->escape($post['day_end'][$k]).'",
                offset = "'.$modx->db->escape($post['offset'][$k]).'",
                type = "'.$modx->db->escape($post['type'][$k]).'",
                pickup_address = "'.$modx->db->escape($post['pickup_address'][$k]).'",
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"
              ');

              $modx->db->query('INSERT IGNORE INTO `modx_a_instructor_settings_pickup` SET 
                pickup_default = "0",
                pickup_address = "'.$modx->db->escape($post['pickup_address'][$k]).'",
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"
              ');

            }
          }
          

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
      }else{
        $ajax['ack'] = 'Failure';
      }
    break;
    case "add_instructor_settings_pickup":
      if($_SESSION['webuser']['cabinet_type'] == '1'){
        $ajax['data'] = $modx->getChunk('tpl_instructor_setting_pickup_default');
      }
    break;
    case "add_instructor_settings":
      if($_SESSION['webuser']['cabinet_type'] == '1'){
        $r['option_pickup'] = '';
        $r['pickup_address'] = '';
        $q_c = $modx->db->query('SELECT * FROM `modx_a_instructor_settings_pickup` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
        while($r_c = $modx->db->getRow($q_c)){
          if($r_c['pickup_default'] == '1'){
            $r['pickup_address'] = $r_c['pickup_address'];
          }
          $r_c['pickup_address'] = str_replace("'",'`',$r_c['pickup_address']);
          $r['option_pickup'] .= $modx->parseChunk('tpl_option', array('value' => $r_c['pickup_address'], 'name' => $r_c['pickup_address'], 'selected' => '', 'data' => ''));
        }

        $ajax['data'] = $modx->parseChunk('tpl_instructor_setting_default',$r);
      }
    break;
    case "test2":
   
      $post = $_REQUEST['test2'];
      $error = array();
      $req_fields = array('fullname','email','phone','city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'test2['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if($post['politics'] != '1'){
        $error[] = 'test2[politics]';
        $ajax['msg'] = 'Ознайомтесь і погодьтесь з правилами платформи';
      }

      if (count($error) == 0) {

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            $post['groups'] = 'test_2_kru';
            $answer = $esputnik->subscribe_contact($post);
          }

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "promocode":
      if($_GET['promo'] != ''){
        $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($_GET['promo']).'" AND available = "1" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          $_SESSION['promocode'] = $_GET['promo'];
          $ajax['msg'] = $modx->parseDocumentSource('Промокод застосовано');
          $ajax['price_mid'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'online_price','tpl' => 'tpl_online_price')));
          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['msg'] = $modx->parseDocumentSource('Промокод не знайдено');
          $ajax['price_mid'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'online_price','tpl' => 'tpl_online_price')));
          unset($_SESSION['promocode']);
          $error = array();
          $error[] = 'online[promocode]';
          $ajax['errors'] = $error;
        }
      }else{
        $ajax['ack'] = 'Failure';
        unset($_SESSION['promocode']);
        $ajax['msg'] = $modx->parseDocumentSource('Введіть промокод');
        $ajax['price_mid'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'online_price','tpl' => 'tpl_online_price')));
      }
    break;
    case "close_top_banner":
      $_SESSION['close_top_banner'] = true;
    break;
    case "status_check":
      $ajax['status_check'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'status_pay', 'order' => $_GET['order'])));
    break;
    case "status_check_v":
      $ajax['status_check_v'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'status_pay_v', 'order' => $_GET['order'])));
    break;
    case "status_check_s":
      $ajax['status_check_s'] = $modx->parseDocumentSource($modx->runSnippet('Shop', array('get' => 'status_pay_s', 'order' => $_GET['order'])));
    break;
    case "city_form":

      $post = $_REQUEST['city_form'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'city_form['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);

          $modx->db->query('INSERT INTO `modx_a_city_form` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($post['email']).'",
            city      = "'.$modx->db->escape($post['city']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            type       = "1",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');
          $theme = 'Новий запис на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_city_form',
            array('fullname'      => $post['fullname'],
              'phone'             => $post['phone'],
              'email'             => $post['email'],
              'city'              => $post['city'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_lesson'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_lesson'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_lesson'];
            $answer = $esputnik->subscribe_contact($post);
          }


          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "online":

      $post = $_REQUEST['online'];
      $error = array();
      $req_fields = array('fullname','phone','email','city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'online['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {




          $sum = $modx->config['price_base'];
          if($_SESSION['promocode'] != ''){
            $promo = $_SESSION['promocode'];
            $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($promo).'" AND available = "1" LIMIT 1');
            if($modx->db->getRecordCount($q) > 0){
              $r = $modx->db->getRow($q);
              $sum = $sum-$r['discount'];
            }
          }

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);
          $hash = uniqid();

          //test!!!
          //$sum = 1;

          $registration = false;
          $query = $modx->db->query('SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ');
          if($modx->db->getRecordCount($query) == 0){
            $reg = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'fullname' => $post['fullname'], 'city' => $post['city'], 'phone' => $post['phone']));
            $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
            $registration = true;
          }else{
            if($_SESSION['webuser']['internalKey'] != ''){
              $reg = $_SESSION['webuser']['internalKey'];
            }else{
              $rr = $modx->db->getRow($query);
              $reg = $rr['id'];
            }
          }
          

          $modx->db->query('INSERT INTO `modx_a_online` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            user_id    = "'.$modx->db->escape($reg).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            email      = "'.$modx->db->escape($post['email']).'",
            city       = "'.$modx->db->escape($post['city']).'",
            promocode  = "'.$modx->db->escape($_SESSION['promocode']).'",
            pay_sum    = "'.$modx->db->escape($sum).'",
            hash       = "'.$modx->db->escape($hash).'",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');


          //Виключаємо одноразовий промокод
          $modx->db->query('UPDATE `modx_a_promo` SET available = "0" WHERE promocode = "'.$modx->db->escape($_SESSION['promocode']).'" AND multicode = "0" LIMIT 1');

          //wayforpay



          $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);

          require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
          $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

          $fields = array();
          $fields['merchantAccount'] = $payment_system['shop_paymid'];
          $fields['merchantAuthType'] = 'SimpleSignature';
          $fields['merchantDomainName'] = 'pdr-online.com.ua';
          $fields['merchantTransactionSecureType'] = 'AUTO';
          $feilds['defaultPaymentSystem'] = 'card';
          $fields['language'] = 'UA';
          $fields['orderReference'] = $hash;
          $fields['orderDate'] = time();
          $fields['amount'] = $sum;
          $fields['currency'] = 'UAH';
          $fields['returnUrl'] = $modx->config['site_url_b'].$modx->makeUrl(159).'?order='.$hash;
          $fields['serviceUrl'] = $modx->config['site_url_b'].$modx->makeUrl(173);
          $fields['clientFirstName'] = $post['fullname'];
          $fields['clientEmail'] = $post['email'];
          $fields['clientPhone'] = $post['phone'];
          $fields['productName'][] = 'Оплата онлайн навчання PDR-online';
          $fields['productCount'][] = 1;
          $fields['productPrice'][] = $sum;
          $fields['merchantSignature'] = $wayforpay->buildHash($payment_system['shop_paysig'],$fields);

          $form = $wayforpay->buildForm($fields);

          $ajax['payform'] = $form;
          $ajax['ack'] = "Success";



          $theme = 'Новий запис на онлайн курс на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_online',
            array('fullname'      => $post['fullname'],
              'phone'             => $post['phone'],
              'city'              => $post['city'],
              'email'             => $post['email'],
              'sum'               => $sum,
              'promocode'         => $_SESSION['promocode'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);


          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_online'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_online'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_online'];
            $answer = $esputnik->subscribe_contact($post);
          }

          if($_SESSION['promocode'] == 'GUIDE'){
            $ajax['event'] = 'paymentguide';
          }else{
            $ajax['event'] = 'online_course';
          }


          $ajax['registration'] = $registration;
          $ajax['ack'] = 'Success';

        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "buyvideo":

      $post = $_REQUEST['buyvideo'];
      $error = array();
      $req_fields = array('fullname','phone','email','city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'buyvideo['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }




      if (count($error) == 0) {




          $sum = $modx->config['price_base_video'];
          if($_SESSION['promocode'] != ''){
            $promo = $_SESSION['promocode'];
            $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($promo).'" AND available = "1" LIMIT 1');
            if($modx->db->getRecordCount($q) > 0){
              $r = $modx->db->getRow($q);
              $sum = $sum-$r['discount'];
            }
          }

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);
          $hash = uniqid();

          //test!!!
          //$sum = 1;

          $registration = false;
          $query = $modx->db->query('SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ');
          if($modx->db->getRecordCount($query) == 0){
            $reg = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'fullname' => $post['fullname'], 'city' => $post['city'], 'phone' => $post['phone']));
            $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
            $registration = true;
          }else{
            if($_SESSION['webuser']['internalKey'] != ''){
              $reg = $_SESSION['webuser']['internalKey'];
            }else{
              $rr = $modx->db->getRow($query);
              $reg = $rr['id'];
            }
          }
          

          $modx->db->query('INSERT INTO `modx_a_video` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            user_id    = "'.$modx->db->escape($reg).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            email      = "'.$modx->db->escape($post['email']).'",
            city       = "'.$modx->db->escape($post['city']).'",
            promocode  = "'.$modx->db->escape($_SESSION['promocode']).'",
            pay_sum    = "'.$modx->db->escape($sum).'",
            hash       = "'.$modx->db->escape($hash).'",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');


          //Виключаємо одноразовий промокод
          $modx->db->query('UPDATE `modx_a_promo` SET available = "0" WHERE promocode = "'.$modx->db->escape($_SESSION['promocode']).'" AND multicode = "0" LIMIT 1');

          //wayforpay



          $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);

          require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
          $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

          $fields = array();
          $fields['merchantAccount'] = $payment_system['shop_paymid'];
          $fields['merchantAuthType'] = 'SimpleSignature';
          $fields['merchantDomainName'] = 'pdr-online.com.ua';
          $fields['merchantTransactionSecureType'] = 'AUTO';
          $feilds['defaultPaymentSystem'] = 'card';
          $fields['language'] = 'UA';
          $fields['orderReference'] = $hash;
          $fields['orderDate'] = time();
          $fields['amount'] = $sum;
          $fields['currency'] = 'UAH';
          $fields['returnUrl'] = $modx->config['site_url_b'].$modx->makeUrl(460).'?order='.$hash;
          $fields['serviceUrl'] = $modx->config['site_url_b'].$modx->makeUrl(459);
          $fields['clientFirstName'] = $post['fullname'];
          $fields['clientEmail'] = $post['email'];
          $fields['clientPhone'] = $post['phone'];
          $fields['productName'][] = 'Оплата онлайн навчання PDR-online';
          $fields['productCount'][] = 1;
          $fields['productPrice'][] = $sum;
          $fields['merchantSignature'] = $wayforpay->buildHash($payment_system['shop_paysig'],$fields);

          $form = $wayforpay->buildForm($fields);

          $ajax['payform'] = $form;
          $ajax['ack'] = "Success";



          $theme = 'Новий запис на онлайн курс на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_online',
            array('fullname'      => $post['fullname'],
              'phone'             => $post['phone'],
              'city'              => $post['city'],
              'email'             => $post['email'],
              'sum'               => $sum,
              'promocode'         => $_SESSION['promocode'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);


          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_online'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_online'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_online'];
            $answer = $esputnik->subscribe_contact($post);
          }

          if($_SESSION['promocode'] == 'GUIDE'){
            $ajax['event'] = 'paymentguide';
          }else{
            $ajax['event'] = 'online_course';
          }


          $ajax['registration'] = $registration;
          $ajax['ack'] = 'Success';

        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "call_instructor":

      $post = $_REQUEST['call_instructor'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'call_instructor['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);

          $modx->db->query('INSERT INTO `modx_a_call_instructor` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            user_id   = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($_SESSION['webuser']['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            city       = "'.$modx->db->escape($post['city']).'",
            instructor_id = "'.$modx->db->escape($post['instructor_id']).'",
            instructor_name = "'.$modx->db->escape($post['instructor_name']).'", 
            utm        = "'.$modx->db->escape($utm_j).'"
            ');
          $theme = 'Новий запис на практичний урок на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_call_instructor',
            array('fullname'      => $post['fullname'],
              'phone'             => $post['phone'],
              'city'              => $post['city'],
              'instructor_id'     => $post['instructor_id'],
              'instructor_name'   => $post['instructor_name'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_lesson'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_lesson'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_lesson'];
            $answer = $esputnik->subscribe_contact($post);
          }


          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "webitestlesson":

      $post = $_REQUEST['webitestlesson'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'webitestlesson['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);

          $modx->db->query('INSERT INTO `modx_a_testlesson` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            user_id   = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($_SESSION['webuser']['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            type       = "1",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');
          $theme = 'Новий запис на тестовий урок на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_testlesson',
            array('fullname'      => $post['fullname'],
              'phone'             => $post['phone'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_lesson'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_lesson'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_lesson'];
            $answer = $esputnik->subscribe_contact($post);
          }

          $ajax['redirect'] = $modx->makeUrl('224').'?promocode=GUIDE';

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "testlesson":

      $post = $_REQUEST['testlesson'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'testlesson['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
// var_dump($post);
// die;
      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);

          $modx->db->query('INSERT INTO `modx_a_testlesson` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            user_id   = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($_SESSION['webuser']['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');
          $theme = 'Новий запис на тестовий урок на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_testlesson',
            array('fullname'      => $post['fullname'],
              'phone'             => $post['phone'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_lesson'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_lesson'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_lesson'];
            $answer = $esputnik->subscribe_contact($post);
          }

          if($modx->documentIdentifier == '217'){
            $event = 'testlesson_page';
          }else{
            $event = 'testlesson';
          }
          $ajax['event'] = $event;
          $ajax['redirect'] = $modx->makeUrl('162');
          $ajax['form_success'] = $modx->parseDocumentSource($modx->getChunk('testlesson_success'));

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;




    // -------------------------------Кейси для тестів---------------------------//

    case "gift_certificate":

      $post = $_REQUEST['gift_certificate'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'gift_certificate['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
// var_dump($post);
// die;
      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);

          $modx->db->query('INSERT INTO `modx_a_new_certificate` SET 
            cert_created   = "'.$modx->db->escape(time()).'",
            cert_code      = "'.$modx->db->escape(uniqid()).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($_SESSION['webuser']['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            cert_utm        = "'.$modx->db->escape($utm_j).'"
            ');
          

          //Відправка на пошту
          // $theme = 'Новий запис для купівлі сертифікату '.$modx->config['site_name'];
          // $message = $modx->parseDocumentSource($modx->parseChunk('mail_testlesson',
          //   array('fullname'      => $post['fullname'],
          //     'phone'             => $post['phone'],
          //     'url'               => $modx->config['site_url'], 
          //     'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_lesson'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_lesson'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_lesson'];
            $answer = $esputnik->subscribe_contact($post);
          }

          if($modx->documentIdentifier == '217'){
            $event = 'testlesson_page';
          }else{
            $event = 'testlesson';
          }
          $ajax['event'] = $event;
 

          $ajax['redirect'] = $modx->makeUrl('162');
          $ajax['form_success'] = $modx->parseDocumentSource($modx->getChunk('testlesson_success'));

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;

     case "lector_package":

      $post = $_REQUEST['lector_package'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'lector_package['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
// var_dump($post);
// die;
      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);
          $hash = uniqid();

          $modx->db->query('INSERT INTO `modx_a_lector_package` SET 
            order_created   = "'.$modx->db->escape(time()).'",
            order_status      = "'.$modx->db->escape(uniqid()).'",
            order_hash       = "'.$modx->db->escape($hash).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($_SESSION['webuser']['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            order_utm        = "'.$modx->db->escape($utm_j).'"
            ');
          

       

          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
      
            $post['groups'] = $modx->config['esputnik_group_id_lesson'];
            $answer = $esputnik->subscribe_contact($post);
          }

          if($modx->documentIdentifier == '217'){

            $event = 'testlesson_page';
          }else{
            $event = 'testlesson';
          }
          $ajax['event'] = $event;
 

          $ajax['redirect'] = $modx->makeUrl('162');
          $ajax['form_success'] = $modx->parseDocumentSource($modx->getChunk('testlesson_success'));

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;


  


    // -------------------------------Закінчення блоку Кейси для тестів---------------------------//
    case "webi_in":

      $post = $_REQUEST['webi_in'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'webi['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if (count($error) == 0) {

          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);


          $modx->db->query('INSERT INTO `modx_a_webi_in` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');

          $ajax['form_success'] = 'Дякуємо, найнижча ціна заброньована';

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "master":
   
      $post = $_REQUEST['master'];
      $error = array();
      $req_fields = array('fullname','email','phone','city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'master['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {

          $rinfo = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_content` WHERE id = "'.$modx->db->escape($post['webid']).'" LIMIT 1'));


          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);


          $modx->db->query('INSERT INTO `modx_a_master` SET 
            user_id   = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
            reg_date   = "'.$modx->db->escape(time()).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($post['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            city       = "'.$modx->db->escape($post['city']).'",
            utm        = "'.$modx->db->escape($utm_j).'"
            ');

          $theme = 'Новий запис на майстер-клас на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_master',
            array('fullname'      => $post['fullname'],
              'email'             => $post['email'],
              'phone'             => $post['phone'],
              'city'              => $post['city'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);


          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_webi'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_webi'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_master'];
            $answer = $esputnik->subscribe_contact($post);
          }



          $registration = false;
          $query = $modx->db->query('SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ');
          if($modx->db->getRecordCount($query) == 0){
            $reg = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'fullname' => $post['fullname'], 'city' => $post['city'], 'phone' => $post['phone']));
            $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
            $registration = true;
          }
          $ajax['registration'] = $registration;
          $ajax['redirect'] = $modx->makeUrl('184');

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "webi":
   
      $post = $_REQUEST['webi'];
      $error = array();
      $req_fields = array('fullname','email','phone','city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'webi['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {

          $rinfo = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_content` WHERE id = "'.$modx->db->escape($post['webid']).'" LIMIT 1'));


          $utm = array();
          if(isset($_SESSION['utm']['ref'])){
            $utm['ref'] = $_SESSION['utm']['ref'];
          }
          if(isset($_SESSION['utm']['utm_source'])){
            $utm['utm_source'] = $_SESSION['utm']['utm_source'];
          }
          if(isset($_SESSION['utm']['utm_medium'])){
            $utm['utm_medium'] = $_SESSION['utm']['utm_medium'];
          }
          if(isset($_SESSION['utm']['utm_campaign'])){
            $utm['utm_campaign'] = $_SESSION['utm']['utm_campaign'];
          }
          if(isset($_SESSION['utm']['utm_content'])){
            $utm['utm_content'] = $_SESSION['utm']['utm_content'];
          }
          if(isset($_SESSION['utm']['utm_term'])){
            $utm['utm_term'] = $_SESSION['utm']['utm_term'];
          }
          $utm_j = json_encode($utm);


          $tvres2 = $modx->getTemplateVar(
                      $idname  = 'webi_date',
                      $fields = '*',
                      $docid =  $rinfo['id']
                      );
          $webi_date = $tvres2['value'];

          $tvres2 = $modx->getTemplateVar(
                      $idname  = 'webi_time',
                      $fields = '*',
                      $docid =  $rinfo['id']
                      );
          $webi_time = $tvres2['value'];
          
          $ddb = $webi_date.' '.$webi_time.':'.'00';
          $time = strtotime($ddb);
          $post['webi_date'] = date('Y-m-d',$time).'T'.date('H:i',$time); ///YYYY-MM-DDTHH:mm 

          $modx->db->query('INSERT INTO `modx_a_webi` SET 
            reg_date   = "'.$modx->db->escape(time()).'",
            fullname   = "'.$modx->db->escape($post['fullname']).'",
            email      = "'.$modx->db->escape($post['email']).'",
            phone      = "'.$modx->db->escape($post['phone']).'",
            city       = "'.$modx->db->escape($post['city']).'",
            utm        = "'.$modx->db->escape($utm_j).'",
            webi_id    = "'.$modx->db->escape($rinfo['id']).'",
            webi_date  = "'.$modx->db->escape($time).'",
            webi_name  = "'.$modx->db->escape($rinfo['pagetitle_ua']).'"
            ');

          $theme = 'Новий запис на вебінар на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_webi',
            array('fullname'      => $post['fullname'],
              'email'             => $post['email'],
              'webi_name'         => $rinfo['pagetitle_ua'],
              'phone'             => $post['phone'],
              'city'              => $post['city'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          //$mail = $shop->mail($modx->config['emailsender'],$theme,$message);


          $modx->db->query('UPDATE `modx_site_tmplvar_contentvalues` SET value = value + 1 WHERE tmplvarid = "57" AND contentid = "'.$modx->db->escape($rinfo['id']).'"  ');
   




          if($modx->config['esputnik_subscribe'] == '1'){
            include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
            $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
            /*
            $answer = $esputnik->subscribe($post);
            if($answer['id'] != '' AND $modx->config['esputnik_group_id_webi'] != ''){
              $esputnik->addToGroup($modx->config['esputnik_group_id_webi'],$answer['id']);
            }
            */
            $post['groups'] = $modx->config['esputnik_group_id_webi'];
            $answer = $esputnik->subscribe_contact($post);
          }


          $registration = false;
          $query = $modx->db->query('SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ');
          if($modx->db->getRecordCount($query) == 0){
            $reg = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'fullname' => $post['fullname'], 'city' => $post['city'], 'phone' => $post['phone']));
            $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
            $registration = true;
          }
          $ajax['registration'] = $registration;

          $ajax['form_success'] = $modx->parseDocumentSource($modx->getChunk('webi_success'));

          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "instructor_contact":
      if($_SESSION['webuser']['internalKey'] != ''){
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_instructors` WHERE instructor_hash = "'.$modx->db->escape($_REQUEST['id']).'" LIMIT 1'));

      if(!in_array($r['school'],array('122','200'))){
        $ajax['ack'] = 'Success';
        $ajax['href'] = $modx->runSnippet('Shop', array('get' => 'parsephone', 'phone' => $modx->config['phone']));
        $ajax['phone'] = $modx->config['phone'];
      }else{
        if($r['phone'] != ''){
          $modx->db->query('UPDATE `modx_a_instructors` SET check_phone = check_phone+1 WHERE instructor_hash = "'.$modx->db->escape($_REQUEST['id']).'" LIMIT 1');
          $ajax['ack'] = 'Success';
          $ajax['href'] = $modx->runSnippet('Shop', array('get' => 'parsephone', 'phone' => $r['phone']));
          $ajax['phone'] = $r['phone'];
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['error_text'] = 'Перегляд контактів тимчасово недоступний';
        }
      }
    }else{
        $ajax['ack'] = 'Failure';
        $ajax['login'] = 'true';
        $ajax['error_text'] = 'Для перегляду контактів треба авторизуватись на сайті';
    }
    break;
    case "catalog_load_more":
      if(is_int($modx->documentIdentifier)){
        $params['get'] = 'catalog';
        $params['tpl'] = 'tpl_catalog';
        $params['limit'] = '9';
        $ajax['catalog']  = $modx->parseDocumentSource($modx->runSnippet("Shop", $params));
        if($ajax['catalog'] != $modx->getChunk('tpl_catalog_not_found')){
          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
        }
      }
    break;
    case "instructor_load_more":


      if(is_int($modx->documentIdentifier)){
        $params['get'] = 'instructors';
        $params['tpl'] = 'tpl_instructor_n';
        $params['limit'] = '20';
        $ajax['instructors']  = $modx->parseDocumentSource($modx->runSnippet("Shop", $params));
        if($ajax['instructors'] != $modx->getChunk('tpl_instructor_not_found')){
          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
        }
      }
    break;
    case "service":
    break;
    case "question_comment":
      $id = $_REQUEST['id'];
      $ajax['comment'] = '';
      if($id != ''){

        
        $q = $modx->db->query('SELECT * FROM `new_question` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          $r = $modx->db->getRow($q);

          $r['pdr_i'] = '';
          if($r['pdr'] != ''){
            $e_pdr = explode(',',$r['pdr']);
            foreach($e_pdr as $pdr_chapter){
              $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
              $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
            }
          }


          $comment = $modx->parseDocumentSource($modx->parseChunk('tpl_question_comment',$r));
          $ajax['comment'] = $comment;
          $ajax['ack'] = 'Success';
        }
      }
    break;
    case "close_test_time":
      if($_SESSION['webuser']['internalKey'] AND $_REQUEST['test'] != '' AND $_REQUEST['time'] != ''){
        switch($_REQUEST['type']){
          case "1":
            //theme
            $modx->db->query('INSERT INTO `new_theme_2_user_time` SET user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", theme_id = "'.$modx->db->escape($_REQUEST['test']).'", usertime = "'.$modx->db->escape($_REQUEST['time']).'" 
              ON DUPLICATE KEY UPDATE usertime = "'.$modx->db->escape($_REQUEST['time']).'" ');
          break;
          case "2":
            //ticket
            $modx->db->query('INSERT INTO `new_ticket_2_user_time` SET user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", ticket_id = "'.$modx->db->escape($_REQUEST['test']).'", usertime = "'.$modx->db->escape($_REQUEST['time']).'" 
              ON DUPLICATE KEY UPDATE usertime = "'.$modx->db->escape($_REQUEST['time']).'" ');
          break;
        }
      }

      $ajax['ack'] = 'Success';
    break;
    case "restart_test":

      if($_SESSION['webuser']['internalKey']){
        switch($_REQUEST['type']){
          case "1":
            //theme
            $modx->db->query('DELETE FROM `new_theme_2_user` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND theme_id = "'.$modx->db->escape($_REQUEST['test']).'" ');
            $modx->db->query('DELETE FROM `new_theme_2_user_time` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND theme_id = "'.$modx->db->escape($_REQUEST['test']).'" ');
          break;
          case "2":
            //ticket
            $modx->db->query('DELETE FROM `new_ticket_2_user` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND ticket_id = "'.$modx->db->escape($_REQUEST['test']).'" ');
            $modx->db->query('DELETE FROM `new_ticket_2_user_time` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND ticket_id = "'.$modx->db->escape($_REQUEST['test']).'" ');
          break;
        }
      }

      $ajax['ack'] = 'Success';
    break;
    case "remove_favorite":
        if (in_array($_REQUEST['id'], $_SESSION['favorite'])){
          $key = array_search($_REQUEST['id'], $_SESSION['favorite']);
          unset($_SESSION['favorite'][$key]);
          $shop->wishU();
        }
        $ajax['ack'] = 'Success';
    break;
    case "add_favorite":
        if (!in_array($_REQUEST['id'], $_SESSION['favorite'])){
          $_SESSION['favorite'][] = $_REQUEST['id'];
          $shop->wishU();
        }

        $ajax['ack'] = 'Success';
    break;
    case "remove_favorite_instructor":
        if (in_array($_REQUEST['id'], $_SESSION['favorite_instructor'])){
          $key = array_search($_REQUEST['id'], $_SESSION['favorite_instructor']);
          unset($_SESSION['favorite_instructor'][$key]);
          $shop->wishUI();
        }
        $ajax['ack'] = 'Success';
    break;
    case "add_favorite_instructor":
        if (!in_array($_REQUEST['id'], $_SESSION['favorite_instructor'])){
          $_SESSION['favorite_instructor'][] = $_REQUEST['id'];
          $shop->wishUI();
        }
        $ajax['ack'] = 'Success';
    break;
    case "end_isput":

      $time = explode(':', $_REQUEST['time']);

      $time_d = (20*60) - ($time[0]*60+$time[1]);

      $modx->db->query('INSERT INTO `new_exam_2_user` SET 
        user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", 
        category = "'.$modx->db->escape($_REQUEST['category']).'", 
        correct = "'.$modx->db->escape($_REQUEST['correct']).'", 
        incorrect = "'.$modx->db->escape($_REQUEST['incorrect']).'", 
        time = "'.$modx->db->escape($_REQUEST['time']).'", 
        time_d = "'.$modx->db->escape($time_d).'", 
        status = "'.$modx->db->escape($_REQUEST['status']).'",
        date = "'.$modx->db->escape(time()).'" 
        ');

    break;
    case "answer":
        $aid = $modx->db->escape($_GET['aid']);
        $qid = $modx->db->escape($_GET['qid']);
        $type = $modx->db->escape($_GET['type']);
        $test = $modx->db->escape($_GET['test']);
        if($aid != '' AND $qid != ''){
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question` WHERE id = "'.$modx->db->escape($qid).'" LIMIT 1'));

          if($r['correct'] == $aid){
            //correct
            $ajax['correct'] = $r['correct'];
            $ajax['comment'] = $r['comment'];
            $ajax['pdr'] = $r['pdr'];
            $ajax['ack'] = 'Success';

            if($_SESSION['webuser']['internalKey']){

              $modx->db->query('DELETE FROM `new_question_2_user` WHERE 
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND 
                question_id = "'.$modx->db->escape($qid).'"
                LIMIT 1
              ');
              switch($type){
                case "1":
                  //theme
                  $modx->db->query('INSERT INTO `new_theme_2_user` SET 
                    user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", 
                    theme_id = "'.$modx->db->escape($test).'",
                    question_id = "'.$modx->db->escape($qid).'",
                    answer_id = "'.$modx->db->escape($aid).'",
                    answer_time = "'.$modx->db->escape(time()).'",
                    answer_date = "'.$modx->db->escape(date('Y-m-d')).'",
                    status = "1"
                    ON DUPLICATE KEY UPDATE status = "1"
                  ');
                break;
                case "2":
                  //ticket
                  $modx->db->query('INSERT INTO `new_ticket_2_user` SET 
                    user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", 
                    ticket_id = "'.$modx->db->escape($test).'",
                    question_id = "'.$modx->db->escape($qid).'",
                    answer_id = "'.$modx->db->escape($aid).'",
                    answer_time = "'.$modx->db->escape(time()).'",
                    answer_date = "'.$modx->db->escape(date('Y-m-d')).'",
                    status = "1"
                    ON DUPLICATE KEY UPDATE status = "0"
                  ');
                break;
                case "3":
                  //isput
                break;
              }
            }else{
              $_SESSION['noreg'][$test][$qid][$aid] = array('type' => $type, 'time' => time(), 'date' => date('Y-m-d'), 'correct' => true);
            }
          }else{
            //incorrect
            $ajax['correct'] = $r['correct'];
            $ajax['comment'] = $r['comment'];
            $ajax['pdr'] = $r['pdr'];
            $ajax['ack'] = 'Failure';

            if($_SESSION['webuser']['internalKey']){

              $modx->db->query('INSERT IGNORE INTO `new_question_2_user` SET 
                user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", 
                question_id = "'.$modx->db->escape($qid).'"
              ');

              switch($type){
                case "1":
                  //theme
                  $modx->db->query('INSERT INTO `new_theme_2_user` SET 
                    user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", 
                    theme_id = "'.$modx->db->escape($test).'",
                    question_id = "'.$modx->db->escape($qid).'",
                    answer_id = "'.$modx->db->escape($aid).'",
                    answer_time = "'.$modx->db->escape(time()).'",
                    answer_date = "'.$modx->db->escape(date('Y-m-d')).'",
                    status = "0"
                    ON DUPLICATE KEY UPDATE status = "1"
                  ');
                break;
                case "2":
                  //ticket
                  $modx->db->query('INSERT INTO `new_ticket_2_user` SET 
                    user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'", 
                    ticket_id = "'.$modx->db->escape($test).'",
                    question_id = "'.$modx->db->escape($qid).'",
                    answer_id = "'.$modx->db->escape($aid).'",
                    answer_time = "'.$modx->db->escape(time()).'",
                    answer_date = "'.$modx->db->escape(date('Y-m-d')).'",
                    status = "0"
                    ON DUPLICATE KEY UPDATE status = "0"
                  ');
                break;
                case "3":
                  //isput
                break;
              }
            }else{
              $_SESSION['noreg'][$test][$qid][$aid] = array('type' => $type, 'time' => time(), 'date' => date('Y-m-d'), 'correct' => false);
            }
          }
        } 
        if($_SESSION['webuser']['user_type'] == '1'){
          $ajax['premium'] = true;
        }else{
          $ajax['premium'] = false;
        }

    break;
    case "forget": 
      $post = $_REQUEST['forget'];
      $error = array();
      $req_fields = array('email');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'forget['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'forget[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if(count($error) == 0){
        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'"';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count == 0){
          $error[] = 'forget[email]';
          $ajax['msg'] = 'Данної пошти не знайдено в базі';
        }else{

          $password = uniqid();
          $modx->db->query('UPDATE `modx_web_users` SET cachepwd = "'.md5($password).'" WHERE username = "'.$modx->db->escape($post['email']).'" ');
          $row['site_name'] = $modx->config['site_name'];
          $row['password'] = $password;
          $row['link'] = $modx->makeUrl(1).'?recovery='.md5($password);
          $row['email']= $post['email'];
          $row['url'] = $modx->config['site_url'];
          $row['url_b'] = $modx->config['site_url_b'];
          $message = $modx->parseDocumentSource($modx->parseChunk('mail_recovery', $row));
          $theme = $modx->parseDocumentSource('Відновлення паролю на сайті '.$modx->config['site_name']);
          $shop->mail($post['email'],$theme,$message);
        }
      }

      if (count($error) == 0) {
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "unreg_telegram":
        $check_connect = $modx->db->query('SELECT * FROM `modx_a_telegram` WHERE modx_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');
        if($modx->db->getRecordCount($check_connect) > 0){
          $modx->db->query('DELETE FROM `modx_a_telegram` WHERE modx_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');
          $modx->db->query('UPDATE `modx_web_user_attributes` SET tg_id = "", tg_link = "" WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');

          $ajax['ack'] = 'Success';
          $ajax['msg'] = 'Телеграм успішно відключено. Оновіть сторінку щоб підключити новий';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['msg'] = 'Щось пішло не так';
        }
    break;
    case "registration_tg":
      $post = $_REQUEST['registration_tg'];
      if($post['tg_id'] == $_REQUEST['id'] AND $_SESSION['webuser']['internalKey'] != ''){
        $check_connect = $modx->db->query('SELECT * FROM `modx_a_telegram` WHERE telegram_id = "'.$modx->db->escape($data['id']).'" LIMIT 1');
        if($modx->db->getRecordCount($check_connect) == 0){
          $modx->db->query('INSERT INTO `modx_a_telegram` SET 
            chat_id       = "'.$modx->db->escape($post['tg_id']).'",
            telegram_id   = "'.$modx->db->escape($post['tg_id']).'",
            telegram_name = "'.$modx->db->escape($post['tg_name']).'",
            telegram_nick = "'.$modx->db->escape($post['tg_link']).'",
            phone         = "'.$modx->db->escape($_SESSION['webuser']['phone']).'",
            email         = "'.$modx->db->escape($_SESSION['webuser']['email']).'",
            modx_id       = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'",
            prove_code    = "",
            proved        = "1"
          ');
          $modx->db->query('UPDATE `modx_web_user_attributes` SET tg_id = "'.$modx->db->escape($post['tg_id']).'", tg_link = "'.$modx->db->escape($post['tg_link']).'" WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');



          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['msg'] = 'Щось пішло не так';
        }
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['msg'] = 'Щось пішло не так';
      }
    break;
    case "registration_fb":
      $post = $_REQUEST['registration_fb'];
      $error = array();
      $req_fields = array('email', 'phone', 'fullname', 'password', 'city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'registration_fb['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'registration_fb[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if(count($error) == 0){
        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count>0){
          $error[] = 'registration_fb[email]';
          $ajax['msg'] = 'Цей E-mail вже зареєстрований. Будь ласка, авторизуйтесь або відновіть пароль.';
        }
      }
      if (count($error) == 0) {
        $reg = $modx->runSnippet('Registration', array(
            'email' => $post['email'], 
            'blocked' => '0', 
            'password' => $post['password'], 
            'fullname' => $post['fullname'], 
            'lastname' => $post['lastname'], 
            'category_type' => $post['category_type'], 
            'city' => $post['city'], 
            'phone' => $post['phone'], 
            'fb_id' => $post['fb_id'],
            'fb_link' => $post['fb_link']
            ));

        if($modx->config['esputnik_subscribe'] == '1'){
          include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
          $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
          /*
          $answer = $esputnik->subscribe($post);
          if($answer['id'] != '' AND $modx->config['esputnik_group_id_registration'] != ''){
            $esputnik->addToGroup($modx->config['esputnik_group_id_registration'],$answer['id']);
          }
          */
          $post['groups'] = $modx->config['esputnik_group_id_registration'];
          $answer = $esputnik->subscribe_contact($post);
        }


        $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));

        if($_SESSION['redirect_test'] != ''){
          $ajax['redirect'] = $_SESSION['redirect_test'];
        }else{
          $ajax['redirect'] = $modx->makeUrl(83);
        }
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "registration_gp":
      $post = $_REQUEST['registration_gp'];
      $error = array();
      $req_fields = array('email', 'phone', 'fullname', 'password', 'city');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'registration_gp['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'registration_gp[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if(count($error) == 0){
        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count>0){
          $error[] = 'registration_gp[email]';
          $ajax['msg'] = 'Цей E-mail вже зареєстрований. Будь ласка, авторизуйтесь або відновіть пароль.';
        }
      }
      if (count($error) == 0) {

        $reg = $modx->runSnippet('Registration', array(
            'email' => $post['email'], 
            'blocked' => '0', 
            'password' => $post['password'], 
            'fullname' => $post['fullname'], 
            'lastname' => $post['lastname'], 
            'category_type' => $post['category_type'], 
            'city' => $post['city'], 
            'phone' => $post['phone'], 
            'gp_id' => $post['gp_id'],
            'gp_link' => $post['gp_link']
            ));
        $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));

        if($modx->config['esputnik_subscribe'] == '1'){
          include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
          $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
          /*
          $answer = $esputnik->subscribe($post);
          if($answer['id'] != '' AND $modx->config['esputnik_group_id_registration'] != ''){
            $esputnik->addToGroup($modx->config['esputnik_group_id_registration'],$answer['id']);
          }
          */
          $post['groups'] = $modx->config['esputnik_group_id_registration'];
          $answer = $esputnik->subscribe_contact($post);
        }

        if($_SESSION['redirect_test'] != ''){
          $ajax['redirect'] = $_SESSION['redirect_test'];
        }else{
          $ajax['redirect'] = $modx->makeUrl(83);
        }
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "registration":
      $post = $_REQUEST['registration'];
      $error = array();
      $req_fields = array('email', 'phone', 'fullname', 'city', 'password');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'registration['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'registration[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if(count($error) == 0){
        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count>0){
          $error[] = 'registration[email]';
          $ajax['msg'] = 'Цей Email вже зареєстрований. Будь ласка, авторизуйтесь або відновіть пароль';
        }
      }
      if (count($error) == 0) {
        $rfi = 0;
        if(is_int($modx->documentIdentifier)){
          if($modx->documentIdentifier == '89'){
            $rfi = 1;
          }
        }else{
          $check_type = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_virtual` WHERE url = "'.$modx->db->escape($modx->documentIdentifier).'" LIMIT 1'));
          if($check_type['type'] == '1'){
            $rfi = 1;
          }
        }

        $reg = $modx->runSnippet('Registration', array(
          'email' => $post['email'], 
          'blocked' => '0', 
          'rfi' => $rfi,
          'password' => $post['password'], 
          'fullname' => $post['fullname'], 
          'city' => $post['city'], 
          'category_type' => $post['category_type'], 
          'lastname' => $post['lastname'], 
          'phone' => $post['phone']));

        $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
        //$ajax['redirect'] = $modx->makeUrl(83);

        if($modx->config['esputnik_subscribe'] == '1'){
          include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
          $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
          /*
          $answer = $esputnik->subscribe($post);
          if($answer['id'] != '' AND $modx->config['esputnik_group_id_registration'] != ''){
            $esputnik->addToGroup($modx->config['esputnik_group_id_registration'],$answer['id']);
          }
          */
          $post['groups'] = $modx->config['esputnik_group_id_registration'];
          $answer = $esputnik->subscribe_contact($post);
        }
        if($rfi == 1){
          $ajax['event'] = 'registration_from_instructor';
        }else{
          $ajax['event'] = 'registration';
        }
        if($_SESSION['redirect_test'] != ''){
          $ajax['redirect'] = $_SESSION['redirect_test'];
        }else{
          if(is_int($modx->documentIdentifier)){
            $ajax['redirect'] = $modx->makeUrl($modx->documentIdentifier);
          }else{
            $ajax['redirect'] = $_SERVER['SCRIPT_URL'];
          }
        }

        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    
    case "login":
      $post = $_REQUEST['login'];
      $error = array();

      $req_fields = array('email', 'password');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'login['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'login[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if(count($error) == 0){
        $user = $modx->runSnippet("Auth", Array("email" => trim($post['email']), "pass" => trim($post['password']), "remember" => $post['remember']));
        switch ($user) {
          case 11: 
            $error[] = 'login[email]';
            $ajax['msg'] = 'Данної пошти не знайдено в базі';
          break;
          case 13: 
            $error[] = 'login[password]';
            $ajax['msg'] = 'Невірний пароль';
          break;
          case 159263:
            $modx->db->query('UPDATE `modx_web_user_attributes` SET failedlogincount = 0 WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');

          break;
        }
      }

      if (count($error) == 0) {
        //$ajax['redirect'] = $modx->makeUrl('83');
        if(is_int($modx->documentIdentifier)){
          $ajax['redirect'] = $modx->makeUrl($modx->documentIdentifier);
        }else{
          $ajax['redirect'] = $modx->documentIdentifier;
        }
        //$ajax['redirect'] = $modx->makeUrl($modx->documentIdentifier);
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "remove_file_photo":
        $uploaddir = MODX_BASE_PATH .'/assets/files/instructors/personal/';
        $filename = $_REQUEST['file'];
        if($_REQUEST['file'] != ''){
          if(unlink($uploaddir.$filename)){
            $ajax['ack'] = 'Success';
          }else{
            $ajax['ack'] = 'Failure';
          }
        }else{
          $ajax['ack'] = 'Failure';
        }
    break;
    case "remove_file_car_photo":
        $uploaddir = MODX_BASE_PATH .'/assets/files/instructors/car/';
        $filename = $_REQUEST['file'];
        if($_REQUEST['file'] != ''){
          if(unlink($uploaddir.$filename)){
            $ajax['ack'] = 'Success';
          }else{
            $ajax['ack'] = 'Failure';
          }
        }else{
          $ajax['ack'] = 'Failure';
        }
    break;
    case "remove_certificate":
        $uploaddir = MODX_BASE_PATH .'/assets/files/instructors/certificate/';
        $filename = $_REQUEST['file'];
        if($_REQUEST['file'] != ''){
          if(unlink($uploaddir.$filename)){
            $ajax['ack'] = 'Success';
          }else{
            $ajax['ack'] = 'Failure';
          }
        }else{
          $ajax['ack'] = 'Failure';
        }
    break;
    case "instructor":
      $post = $_REQUEST['instructor'];
      $error = array();

      if(isset($_SESSION['webuser']['internalKey'])){
        $req_fields = array('fullname','lastname','patronymic','email', 'phone','experience','certificate_date','district','pickup_address','brand','duration','model','color','year','reg_number','schedule_from','schedule_to','price','city','type','transmission');
      }else{
        $req_fields = array('fullname','lastname','patronymic','email', 'password', 'phone','experience','certificate_date','district','pickup_address','brand','duration','model','color','year','reg_number','schedule_from','schedule_to','price','city','type','transmission');
      }

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'instructor['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'instructor[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }




      if(count($error) == 0 AND !isset($_SESSION['webuser']['internalKey'])){
        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count>0){
          $error[] = 'instructor[email]';
          $ajax['msg'] = 'Цей Email вже зареєстрований. Будь ласка, авторизуйтесь або відновіть пароль';
        }
      }



      if (count($error) == 0) {
        

        $registration = false;

        if(isset($_SESSION['webuser']['internalKey'])){
          $user_id = $_SESSION['webuser']['internalKey'];
        }else{
          $user_id = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'password' => $post['password'], 'phone' => $post['phone'], 'fullname' => $post['fullname'], 'city' => $post['city'], 'lastname' => $post['lastname'], 'patronymic' => $post['patronymic'], 'user_type' => '1'));
          $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
          $registration = true;
        }

        if(count($post['photo']) > 0){
          $pp = array();
          foreach($post['photo'] as $k => $v){
            $pp[] = '/assets/files/instructors/personal/'.$v;
          }
          $photo = implode(',',$pp);
        }
        if(count($post['car_photo']) > 0){
          $cp = array();
          foreach($post['car_photo'] as $k => $v){
            $cp[] = '/assets/files/instructors/car/'.$v;
          }
          $car_photo = implode(',',$cp);
        }
        if(count($post['certificate']) > 0){
          $cc = array();
          foreach($post['certificate'] as $k => $v){
            $cc[] = '/assets/files/instructors/certificate/'.$v;
          }
          $certificate = implode(',',$cc);
        }

        $instructor_url = $shop->generateSlug($post['lastname'].'-'.$post['fullname']);
        $modx->db->query('INSERT INTO `modx_a_instructors` SET 
          registration_date = "'.$modx->db->escape(date('Y-m-d H:i:s')).'",
          instructor_hash = "'.$modx->db->escape(uniqid()).'",
          user_id = "'.$modx->db->escape($user_id).'",
          fullname = "'.$modx->db->escape($post['fullname']).'",
          lastname = "'.$modx->db->escape($post['lastname']).'",
          patronymic = "'.$modx->db->escape($post['patronymic']).'",
          email = "'.$modx->db->escape($post['email']).'",
          school = "'.$modx->db->escape($post['school']).'",
          phone = "'.$modx->db->escape($post['phone']).'",
          birthday = "'.$modx->db->escape($post['birthday']).'",
          instructor_url = "'.$modx->db->escape($instructor_url).'",
          experience = "'.$modx->db->escape($post['experience']).'",
          certificate_date = "'.$modx->db->escape($post['certificate_date']).'",
          city = "'.$modx->db->escape($post['city']).'",
          district = "'.$modx->db->escape($post['district']).'",
          pickup_address = "'.$modx->db->escape($post['pickup_address']).'",
          type = "'.$modx->db->escape($post['type']).'",
          duration = "'.$modx->db->escape($post['duration']).'",
          brand = "'.$modx->db->escape($post['brand']).'",
          model = "'.$modx->db->escape($post['model']).'",
          color = "'.$modx->db->escape($post['color']).'",
          year = "'.$modx->db->escape($post['year']).'",
          transmission = "'.$modx->db->escape($post['transmission']).'",
          reg_number = "'.$modx->db->escape($post['reg_number']).'",
          schedule_from = "'.$modx->db->escape($post['schedule_from']).'",
          schedule_to = "'.$modx->db->escape($post['schedule_to']).'",
          price = "'.$modx->db->escape($post['price']).'",
          photo = "'.$modx->db->escape($photo).'",
          car_photo = "'.$modx->db->escape($car_photo).'",
          certificate = "'.$modx->db->escape($certificate).'"
        ');
        $id = $modx->db->getInsertId();
        if($id != '' AND $instructor_url != ''){
          $modx->db->query('INSERT INTO `modx_a_virtual` SET 
            type = "1",
            idv = "'.$modx->db->escape($id).'",
            url = "'.$modx->db->escape($instructor_url).'"
            ');
        }


        $theme = 'Реєстрація нового інструктора на сайті '.$modx->config['site_name'];

        $message = $modx->parseDocumentSource($modx->parseChunk('mail_instructor',
            array('email'          => $post['email'],
              'fullname'           => $post['fullname'],
              'lastname'           => $post['lastname'],
              'patronymic'         => $post['patronymic'],
              'phone'              => $post['phone'],
              'birthday'           => $post['birthday'],
              'experience'         => $post['experience'],
              'certificate_date'   => $post['certificate_date'],
              'city'               => $post['city'],
              'district'           => $post['district'],
              'pickup_address'     => $post['pickup_address'],
              'type'               => $post['type'],
              'duration'           => $post['duration'],
              'brand'              => $post['brand'],
              'model'              => $post['model'],
              'color'              => $post['color'],
              'year'               => $post['year'],
              'transmission'       => $post['transmission'],
              'reg_number'         => $post['reg_number'],
              'schedule_from'      => $post['schedule_from'],
              'schedule_to'        => $post['schedule_to'],
              'price'              => $post['price'],
              'url'                => $modx->config['site_url'], 
              'site_name'          => $modx->config['site_name'])));

        $mail = $shop->mail($modx->config['emailsender'],$theme,$message);
        $mail = $shop->mail('project.taurusgroup@gmail.com',$theme,$message);


        $ajax['registration'] = $registration;


        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }

    break;
    case "instructor_manager":
      $post = $_REQUEST['instructor'];
      $error = array();
      $req_fields = array('fullname','lastname','patronymic','email', 'password', 'phone','experience','certificate_date','district','pickup_address','brand','duration','model','color','year','reg_number','schedule_from','schedule_to','price','city','type','transmission');  
      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'instructor['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'instructor[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if (count($error) == 0) {
        

        $registration = false;

        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count>0){
          $user_check = $modx->db->getRow($query);
          $user_id = $user_check['id'];
        }else{
          $user_id = $modx->runSnippet('Registration', array('email' => $post['email'], 'blocked' => '0', 'password' => $post['password'], 'phone' => $post['phone'], 'fullname' => $post['fullname'], 'city' => $post['city'], 'lastname' => $post['lastname'], 'patronymic' => $post['patronymic'], 'user_type' => '1'));
          $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
          $registration = true;
        }

        if(count($post['photo']) > 0){
          $pp = array();
          foreach($post['photo'] as $k => $v){
            $pp[] = '/assets/files/instructors/personal/'.$v;
          }
          $photo = implode(',',$pp);
        }
        if(count($post['car_photo']) > 0){
          $cp = array();
          foreach($post['car_photo'] as $k => $v){
            $cp[] = '/assets/files/instructors/car/'.$v;
          }
          $car_photo = implode(',',$cp);
        }
        if(count($post['certificate']) > 0){
          $cc = array();
          foreach($post['certificate'] as $k => $v){
            $cc[] = '/assets/files/instructors/certificate/'.$v;
          }
          $certificate = implode(',',$cc);
        }

        $instructor_url = $shop->generateSlug($post['lastname'].'-'.$post['fullname']);
        $modx->db->query('INSERT INTO `modx_a_instructors` SET 
          registration_date = "'.$modx->db->escape(date('Y-m-d H:i:s')).'",
          instructor_hash = "'.$modx->db->escape(uniqid()).'",
          user_id = "'.$modx->db->escape($user_id).'",
          fullname = "'.$modx->db->escape($post['fullname']).'",
          lastname = "'.$modx->db->escape($post['lastname']).'",
          patronymic = "'.$modx->db->escape($post['patronymic']).'",
          email = "'.$modx->db->escape($post['email']).'",
          school = "'.$modx->db->escape($post['school']).'",
          phone = "'.$modx->db->escape($post['phone']).'",
          birthday = "'.$modx->db->escape($post['birthday']).'",
          instructor_url = "'.$modx->db->escape($instructor_url).'",
          experience = "'.$modx->db->escape($post['experience']).'",
          certificate_date = "'.$modx->db->escape($post['certificate_date']).'",
          city = "'.$modx->db->escape($post['city']).'",
          district = "'.$modx->db->escape($post['district']).'",
          pickup_address = "'.$modx->db->escape($post['pickup_address']).'",
          type = "'.$modx->db->escape($post['type']).'",
          duration = "'.$modx->db->escape($post['duration']).'",
          brand = "'.$modx->db->escape($post['brand']).'",
          model = "'.$modx->db->escape($post['model']).'",
          color = "'.$modx->db->escape($post['color']).'",
          year = "'.$modx->db->escape($post['year']).'",
          transmission = "'.$modx->db->escape($post['transmission']).'",
          reg_number = "'.$modx->db->escape($post['reg_number']).'",
          schedule_from = "'.$modx->db->escape($post['schedule_from']).'",
          schedule_to = "'.$modx->db->escape($post['schedule_to']).'",
          price = "'.$modx->db->escape($post['price']).'",
          photo = "'.$modx->db->escape($photo).'",
          car_photo = "'.$modx->db->escape($car_photo).'",
          certificate = "'.$modx->db->escape($certificate).'"
        ');
        $id = $modx->db->getInsertId();
        if($id != '' AND $instructor_url != ''){
          $modx->db->query('INSERT INTO `modx_a_virtual` SET 
            type = "1",
            idv = "'.$modx->db->escape($id).'",
            url = "'.$modx->db->escape($instructor_url).'"
            ');
        }


        $theme = 'Реєстрація нового інструктора на сайті '.$modx->config['site_name'];

        $message = $modx->parseDocumentSource($modx->parseChunk('mail_instructor',
            array('email'          => $post['email'],
              'fullname'           => $post['fullname'],
              'lastname'           => $post['lastname'],
              'patronymic'         => $post['patronymic'],
              'phone'              => $post['phone'],
              'birthday'           => $post['birthday'],
              'experience'         => $post['experience'],
              'certificate_date'   => $post['certificate_date'],
              'city'               => $post['city'],
              'district'           => $post['district'],
              'pickup_address'     => $post['pickup_address'],
              'type'               => $post['type'],
              'duration'           => $post['duration'],
              'brand'              => $post['brand'],
              'model'              => $post['model'],
              'color'              => $post['color'],
              'year'               => $post['year'],
              'transmission'       => $post['transmission'],
              'reg_number'         => $post['reg_number'],
              'schedule_from'      => $post['schedule_from'],
              'schedule_to'        => $post['schedule_to'],
              'price'              => $post['price'],
              'url'                => $modx->config['site_url'], 
              'site_name'          => $modx->config['site_name'])));

        $mail = $shop->mail($modx->config['emailsender'],$theme,$message);
        $mail = $shop->mail('project.taurusgroup@gmail.com',$theme,$message);


        $ajax['registration'] = $registration;


        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }

    break;
    case "review":
      $message = '';
      $post = $_REQUEST['review'];
      $error = array();
      $req_fields = array('fullname','email','text');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'review['.$value.']';
              $message = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {
          $modx->db->query('INSERT INTO `modx_a_recall_content` SET 
            recall_pub_date  = "'.date('Y-m-d H:i:s').'",
            recall_name      = "'.$modx->db->escape($post['fullname']).'",
            recall_email     = "'.$modx->db->escape($post['email']).'",
            recall_text      = "'.$modx->db->escape($post['text']).'",
            recall_mark      = "'.$modx->db->escape($post['mark']).'",
            recall_soclink   = "'.$modx->db->escape($post['soclink']).'",
            recall_contentid = "'.$modx->db->escape($post['page']).'",
            recall_moderated = 0
            ');
          $theme = 'Новий відгук на сайті '.$modx->config['site_name'];

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_new_review',
            array('fullname'      => $post['fullname'],
              'email'             => $post['email'],
              'page_url'    => $modx->config['site_url'].$modx->makeUrl($post['page']),
              'recall_mark'       => $post['mark'],
              'text'              => $post['text'],
              'soclink'           => $post['soclink'],
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name'])));
          $mail = $shop->mail($modx->config['emailsender'],$theme,$message);
          $ajax['msg'] = $message;
          $ajax['ack'] = 'Success';
        }else{
          $ajax['msg'] = $message;
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "a_recall":
   
      $post = $_REQUEST['recall'];
      $error = array();
      $req_fields = array('fullname','email','text');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'recall['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }


      if (count($error) == 0) {
          $recall_hash = uniqid();
          $modx->db->query('INSERT INTO `modx_a_recall` SET 
            recall_pub_date  = "'.date('Y-m-d H:i:s').'",
            recall_name      = "'.$modx->db->escape($post['fullname']).'",
            recall_email     = "'.$modx->db->escape($post['email']).'",
            recall_text      = "'.$modx->db->escape($post['text']).'",
            recall_mark      = "'.$modx->db->escape($post['mark']).'",
            recall_type      = "'.$modx->db->escape($post['recall_type']).'",
            recall_hash      = "'.$modx->db->escape($recall_hash).'",
            recall_content = "'.$modx->db->escape($post['instructor_id']).'",
            recall_moderated = 0
            ');
          $theme = 'Новий відгук на сайті '.$modx->config['site_name'];

          $pdata = array('fullname'      => $post['fullname'],
              'email'             => $post['email'],
              'instructor_url'    => $modx->config['site_url'].$_GET['q'],
              'recall_mark'       => $post['mark'],
              'text'              => $post['text'],
              'confirm'           => $modx->config['site_url'].'?confirm_recall='.$recall_hash,
              'url'               => $modx->config['site_url'], 
              'site_name'         => $modx->config['site_name']);

          $message = $modx->parseDocumentSource($modx->parseChunk('mail_new_recall',$pdata));
          $mail = $shop->mail($modx->config['emailsender'],$theme,$message);



          require MODX_BASE_PATH . "assets/shop/php/telegram.php";
          $telegram = new Telegram($modx);

          $tg_order_text = $modx->parseDocumentSource($modx->parseChunk('tg_new_recall',$pdata));
          $rr = $telegram->sendToBot($tg_order_text);




          $ajax['ack'] = 'Success';
        }else{
          $ajax['ack'] = 'Failure';
          $ajax['errors'] = $error;
        }
    break;
    case "profile_setting":
      $post = $_REQUEST['profile_setting'];
      $error = array();
      /*
      $req_fields = array('');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'profile['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      */
      if (count($error) == 0) {

        $modx->db->query('UPDATE `modx_web_user_attributes` SET 
          category_type = "'.$modx->db->escape($post['category_type']).'", 
          transmission = "'.$modx->db->escape($post['transmission']).'"
          WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"');

        $modx->runSnippet("Auth", Array("email" => $_SESSION['webuser']['email'], "autologin" => true));
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "search_client":
      if($_SESSION['webuser']['cabinet_type'] != '3' AND $_SESSION['webuser']['cabinet_type'] != '2'){
        $error[] = 'cabtype';
        $ajax['msg'] = 'Дію заборонено';
        $ajax['ack'] = 'Failure';
      }else{
        $search = $_REQUEST['search'];
        $school = $_REQUEST['school'];
        $q = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE cabinet_type = "0" AND (fullname LIKE "%'.$modx->db->escape($search).'%" OR lastname LIKE "%'.$modx->db->escape($search).'%" OR email LIKE "%'.$modx->db->escape($search).'%" OR phone LIKE "%'.$modx->db->escape($search).'%") AND (school = "'.$modx->db->escape($school).'" OR school = "0") LIMIT 20');

        while($r = $modx->db->getRow($q)){
          $name = array();
          $name[] = $r['fullname'];
          $name[] = $r['lastname'];
          $name[] = $r['patronymic'];
          $name[] = $r['phone'];
          $name[] = $r['email'];
          $r['name'] = implode(' ',$name);
          $clients .= $modx->parseChunk('tpl_client_check',$r);
        }
        $ajax['ack'] = 'Success';
        $ajax['clients'] = $clients;
      }
    break;
    case "manager_bill":
      $post = $_REQUEST['bill'];
      $error = array();


      if($_SESSION['webuser']['cabinet_type'] != '3' AND $_SESSION['webuser']['cabinet_type'] != '2'){
        $error[] = 'cabtype';
        $ajax['msg'] = 'Дію заборонено';
      }

      $req_fields = array('pay_type','pay_status','amount');
      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'bill['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if($post['client_type'] == '1'){
        $post['client_type'] = 1;
        $new_client = $post['client'];
        $req_fields = array('fullname','lastname','phone');
        foreach ($req_fields as $key => $value) {
            if ($new_client[$value] == '') {
                $error[] = 'bill[client]['.$value.']';
                $ajax['msg'] = 'Заповніть всі необхідні поля';
            }
        }
        if($new_client['email'] != ''){
          if(filter_var($new_client['email'], FILTER_VALIDATE_EMAIL) === false ){
            $error[] = 'bill[client][email]';
            $ajax['msg'] = 'Невірний формат E-mail';
          }
          if(count($error) == 0){
            $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($new_client['email']).'" ';
            $query = $modx->db->query($sql);
            $count = $modx->db->getRecordCount($query);
            if($count>0){
              $error[] = 'bill[client][email]';
              $ajax['msg'] = 'Цей Email вже зареєстрований. Будь ласка, авторизуйтесь або відновіть пароль';
            }
          }
        }
      }else{
        $post['client_type'] = 0;
        if($post['client_id'] == ''){
          $error[] = 'bill[client_search]';
          $ajax['msg'] = 'Оберіть клієнта';
        }
      }
      if($post['type'] == '1'){
        $post['type'] = 1;           
        $req_fields = array('sum','amount_2');
        foreach ($req_fields as $key => $value) {
            if ($post[$value] == '') {
                $error[] = 'bill['.$value.']';
                $ajax['msg'] = 'Заповніть всі необхідні поля';
            }
        }
      }else{
        $post['type'] = 0;   
        $req_fields = array('product','amount');
        foreach ($req_fields as $key => $value) {
            if ($post[$value] == '') {
                $error[] = 'bill['.$value.']';
                $ajax['msg'] = 'Заповніть всі необхідні поля';
            }
        }
      }


      //school_id

      if (count($error) == 0) {
       
        if($post['client_type'] == '1'){
          $new_client = $post['client'];
          if($new_client['email'] != ''){
            //reg
            $client_id = $modx->runSnippet('Registration', array(
              'email' => $new_client['email'], 
              'blocked' => '0', 
              'password' => $new_client['password'], 
              'fullname' => $new_client['fullname'], 
              'city' => $new_client['city'], 
              'lastname' => $new_client['lastname'], 
              'phone' => $new_client['phone'])
            );
            if($new_client['fullname'] != ''){$f_name[] = $new_client['fullname'];}
            if($new_client['lastname'] != ''){$f_name[] = $new_client['lastname'];}
            if($new_client['patronymic'] != ''){$f_name[] = $new_client['patronymic'];}
            $user_name = trim(implode(' ',$f_name));
            $phone = str_replace('+','',str_replace('-','',str_replace('(','',str_replace(')','',str_replace(' ','',$new_client['phone'])))));

          }else{
            //noreg 
            $client_id = 0;
            if($new_client['fullname'] != ''){$f_name[] = $new_client['fullname'];}
            if($new_client['lastname'] != ''){$f_name[] = $new_client['lastname'];}
            if($new_client['patronymic'] != ''){$f_name[] = $new_client['patronymic'];}
            $user_name = trim(implode(' ',$f_name));
            $phone = str_replace('+','',str_replace('-','',str_replace('(','',str_replace(')','',str_replace(' ','',$new_client['phone'])))));
          }
        }else{
          $client_id = $post['client_id'];
          $check_client = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($post['client_id']).'" LIMIT 1'));
          if($check_client['fullname'] != ''){$f_name[] = $check_client['fullname'];}
          if($check_client['lastname'] != ''){$f_name[] = $check_client['lastname'];}
          if($check_client['patronymic'] != ''){$f_name[] = $check_client['patronymic'];}
          $user_name = trim(implode(' ',$f_name));
          $phone = str_replace('+','',str_replace('-','',str_replace('(','',str_replace(')','',str_replace(' ','',$check_client['phone'])))));
        }
        if($post['instructor'] != ''){
          $check_instructor = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($post['instructor']).'" LIMIT 1'));
          if($check_instructor['cabinet_syncname'] != ''){
            $instructor_name = $check_instructor['cabinet_syncname'];
          }
        }

        if($post['type'] == '1'){
          $post['type'] = 1;           
          $req_fields = array('sum','amount_2');
          $lesson = $post['amount_2'];
          $bill_sum = $post['sum'];
          $product_lesson_type = 0;
        }else{
          $post['type'] = 0;   
          $req_fields = array('product','amount');
          $lesson = $post['amount'];
          $check_product = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_products` WHERE product_id = "'.$modx->db->escape($post['product']).'" LIMIT 1'));
          if($check_product['product_price'] != $check_product['product_price_a'] AND $check_product['product_price_a'] != '0.00'){
            $price = $check_product['product_price_a'];
          }else{
            $price = $check_product['product_price'];
          }
          $product_lesson_type = $check_product['product_lesson_type'];
          $bill_sum = $lesson*$price;
        }
        $modx->db->query('INSERT INTO `modx_a_instructor_to_user_web` SET 
          order_id        = "0",
          buy_date        = "'.$modx->db->escape(time()).'",
          user_phone      = "'.$modx->db->escape($phone).'",
          user_id         = "'.$modx->db->escape($client_id).'",
          user_name       = "'.$modx->db->escape($user_name).'",
          instructor_id   = "'.$modx->db->escape($post['instructor']).'",
          instructor_name = "'.$modx->db->escape($instructor_name).'",
          lesson_total    = "'.$modx->db->escape($lesson).'",
          lesson_balance  = "'.$modx->db->escape($lesson).'",
          bill_sum        = "'.$modx->db->escape($bill_sum).'",
          bill_payd       = "'.$modx->db->escape($post['pay_status']).'",
          bill_pay_type   = "'.$modx->db->escape($post['pay_type']).'",
          order_school    = "'.$modx->db->escape($post['school_id']).'",
          add_to_schedule = "0",
          type            = "'.$modx->db->escape($product_lesson_type).'"
        ');

        $shop->setLog('1',json_encode($post));
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "profile":
      $post = $_REQUEST['profile'];
      $error = array();
      $req_fields = array('fullname','phone');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'profile['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if (count($error) == 0) {
        $modx->db->query('UPDATE `modx_web_user_attributes` SET 
          fullname = "'.$modx->db->escape($post['fullname']).'", 
          lastname = "'.$modx->db->escape($post['lastname']).'", 
          phone = "'.$modx->db->escape($post['phone']).'", 
          city = "'.$modx->db->escape($post['city']).'", 
          patronymic = "'.$modx->db->escape($post['patronymic']).'"

          WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"');

        $theme = $modx->parseDocumentSource('Оновлення данних профілю на сайті '.$modx->config['site_name']);
        $message = $modx->parseDocumentSource($modx->parseChunk('mail_profile',
            array('fullname' => $post['fullname'],
                  'phone' => $post['phone'],
                  'city' => $post['city'],
                  'lastname' => $post['lastname'],
                  'patronymic' => $post['patronymic'],
                  'url' => $modx->config['site_url'], 
                  'site_name' => $modx->config['site_name'])));
        $shop->mail($_SESSION['webuser']['email'],$theme,$message);
        $modx->runSnippet("Auth", Array("email" => $_SESSION['webuser']['email'], "autologin" => true));
        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "changepwd":
      $post = $_REQUEST['changepwd'];
      $error = array();
      $req_fields = array('newpwd', 'newpwdcfm');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'changepwd['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      if($post['newpwd'] != $post['newpwdcfm']){
        $error[] = 'changepwd[newpwdcfm]';
      }
      if (count($error) == 0) {
        $modx->db->query('UPDATE `modx_web_users` SET 
          cachepwd = "'.$modx->db->escape(md5($post['newpwd'])).'"
          WHERE id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"');

        $theme = $modx->parseDocumentSource('Зміна паролю на сайті '.$modx->config['site_name']);
        $message = $modx->parseDocumentSource($modx->parseChunk('mail_change_pwd',
            array('password' => $post['newpwd'],
                  'link' => $modx->makeUrl(1).'?recovery='.md5($post['newpwd']),
                  'url' => $modx->config['site_url'], 
                  'url_b' => $modx->config['site_url_b'],
                  'site_name' => $modx->config['site_name'])));
        $shop->mail($_SESSION['webuser']['email'],$theme,$message);

        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "group":
      $post = $_REQUEST['group'];
      $error = array();
      $req_fields = array('phone', 'fullname');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'group['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      if (count($error) == 0) {

        $theme = $modx->parseDocumentSource('Новий запит в групу сайті '.$modx->config['site_name']);
        $message = $modx->parseDocumentSource($modx->parseChunk('mail_group',
            array('phone' => $post['phone'],
                  'fullname' => $post['fullname'],
                  'url' => $modx->config['site_url'], 
                  'url_b' => $modx->config['site_url_b'],
                  'site_name' => $modx->config['site_name'])));
        //$shop->mail($modx->config['emailsender'],$theme,$message);

        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "subscribe":
      $post = $_REQUEST['subscribe'];
      $error = array();
      $req_fields = array('phone', 'fullname');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'subscribe['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }
      if (count($error) == 0) {

        $theme = $modx->parseDocumentSource('Новий запит на сайті '.$modx->config['site_name']);
        $message = $modx->parseDocumentSource($modx->parseChunk('mail_subscribe',
            array('phone' => $post['phone'],
                  'fullname' => $post['fullname'],
                  'url' => $modx->config['site_url'], 
                  'url_b' => $modx->config['site_url_b'],
                  'site_name' => $modx->config['site_name'])));
        //$shop->mail($modx->config['emailsender'],$theme,$message);

        if($modx->config['esputnik_subscribe'] == '1'){
          include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
          $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);

          $answer = $esputnik->subscribe_contact($post);
        }



        $ajax['ack'] = 'Success';
      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }
    break;
    case "search_city":

      $desc_p = 'Description';
      $city = $_REQUEST['city'];

      $tpl = 'tpl_ac_city';
      $q = $modx->db->query('SELECT * FROM `modx_a_newpost_city` WHERE Description LIKE "'.$modx->db->escape($city).'%" OR DescriptionRu LIKE "'.$modx->db->escape($city).'%" ORDER BY '.$desc_p.' ASC LIMIT 30');
      $cnt = 0;
      while ($r = $modx->db->getRow($q)) {
        $r['value'] = str_replace("'", "’", $r[$desc_p]);
        $ajax['city'] .= $modx->parseChunk($tpl,$r);
        $cnt++;
      }
      if($ajax['city'] == ''){
        $ajax['ack'] = 'Failure';
      }else{
        $ajax['ack'] = 'Success';
      }

    break;
    case "restart_chat":
      require_once MODX_BASE_PATH . "assets/shop/php/gpt.php";
      $gpt = new Gpt($modx);
      if($_SESSION['chat_id'] != ''){
        $modx->db->query('UPDATE `modx_a_chat_threads` SET status = "1" WHERE  chat_id = "'.$modx->db->escape($_SESSION['chat_id']).'" LIMIT 1');
        $gpt->threadDelete($_SESSION['chat_id']);
        unset($_SESSION['chat_id']);
      }
      $ajax['ack'] = 'Success';
    break;
    case "helper_test":
      //Тимчасовов виключено



      if(isset($_SESSION['webuser']['test_photo'])){
        if($_SESSION['webuser']['test_photo'] === 0){
          $ravlik_photo = false;
        }else{
          $ravlik_photo = true;
        }
      }else{
        $ravlik_photo = true;
      }

      $user_id = $_SESSION['webuser']['internalKey'];
      $user_type = $_SESSION['webuser']['user_type'];
      $user_type_p = $_SESSION['webuser']['user_type_p'];

      if($user_type == "1" AND $user_type_p == "1"){
        $question_id = $_REQUEST['question_id'];


        $check = $modx->db->query('SELECT * FROM `new_question_2_helper` WHERE question_id = "'.$modx->db->escape($question_id).'" LIMIT 1');
        if($modx->db->getRecordCount($check) > 0 ){
          //відповідь з бази
          $answer = $modx->db->getRow($check);
          $answer_html = $shop->beutifyGptText($answer['answer']);
          $ajax['answer'] = $modx->parseDocumentSource($modx->parseChunk('tpl_chat_a', array('text' => $answer_html)));
          $ajax['ack'] = 'Success';

        }else{
          //новий запит до gpt


          $rq = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question` WHERE id = "'.$modx->db->escape($question_id).'" LIMIT 1'));
          $question = 'Поясни чому на це: Питання:'.$rq['question'].' і такі варіанти відповіді:
          ';
          $question_text = 'Пояснення питання тесту: "'.$rq['question'].'"';
          $qa = json_decode($rq['answers'],true);
          foreach($qa as $key => $qaa){
            $qnum = $key+1;
            if($rq['correct'] == $key){
              $question .= $qnum.'.'.$qaa['description'].' (Правильна відповідь);
            ';
            }else{
              $question .= $qnum.'.'.$qaa['description'].';
            ';
            }
            
          }
          $question .= ' вказана правильна відповідь №'.($rq['correct']+1);

          if($rq['image_new_2'] != '' AND $ravlik_photo){
            $rq['image_official'] = $rq['image_new_2'];
          }
          require_once MODX_BASE_PATH . "assets/shop/php/gpt.php";
          $gpt = new Gpt($modx);


          if($_SESSION['chat_id'] != ''){
            $chat_id = $_SESSION['chat_id'];
          }else{
            $chat_id = $gpt->threadCreate();
            $modx->db->query('INSERT INTO `modx_a_chat_threads` SET chat_id = "'.$modx->db->escape($chat_id).'", chat_date = "'.$modx->db->escape(time()).'" ');
            $_SESSION['chat_id'] = $chat_id;
          }
          if($rq['image_official'] != ''){
            $img = $modx->config['site_url_b'].$rq['image_official'];
            $message_id = $gpt->threadMessageI($chat_id,$question,$img);
          }else{
            $message_id = $gpt->threadMessage($chat_id,$question);
          }


          $modx->db->query('INSERT INTO `modx_a_chat_history` SET user_id = "'.$modx->db->escape($user_id).'", question_id = "'.$modx->db->escape($question_id).'", message = "'.$modx->db->escape($question_text).'", message_id = "'.$modx->db->escape($message_id).'", type = "0", date = "'.$modx->db->escape(time()).'", chat_id = "'.$modx->db->escape($chat_id).'" ');


          $runId = $gpt->threadRun($chat_id);

          $gpt->waitTillRunComplete($chat_id, $runId);

          $answer = $gpt->threadMessages($chat_id);

          $modx->db->query('INSERT INTO `modx_a_chat_history` SET user_id = "'.$modx->db->escape($user_id).'", message = "'.$modx->db->escape($answer['answer']).'", message_id = "'.$modx->db->escape($answer['message_id']).'", type = "1", date = "'.$modx->db->escape(time()).'", chat_id = "'.$modx->db->escape($chat_id).'" ');

          $modx->db->query('INSERT INTO `new_question_2_helper` SET question_id = "'.$modx->db->escape($question_id).'", answer = "'.$modx->db->escape($answer['answer']).'" ');



          $answer_html = $shop->beutifyGptText($answer['answer']);




          $ajax['answer'] = $modx->parseDocumentSource($modx->parseChunk('tpl_chat_a', array('text' => $answer_html)));
          $ajax['ack'] = 'Success';



        }

      }else{
        $answer = 'Послуга доступна тільки для premium користувачів';
        $ajax['answer'] = $modx->parseDocumentSource($modx->parseChunk('tpl_chat_a', array('text' => $answer)));
        $ajax['ack'] = 'Success';

      }
    break;
    case "helper":
    
      $user_id = $_SESSION['webuser']['internalKey'];
      $user_type = $_SESSION['webuser']['user_type'];
      $user_type_p = $_SESSION['webuser']['user_type_p'];

      if($user_type == "1" AND $user_type_p == "1"){
        $question = $_REQUEST['question'];

        if($question != ''){
          require_once MODX_BASE_PATH . "assets/shop/php/gpt.php";
          $gpt = new Gpt($modx);


          if($_SESSION['chat_id'] != ''){
            $chat_id = $_SESSION['chat_id'];
          }else{
            $chat_id = $gpt->threadCreate();
            $modx->db->query('INSERT INTO `modx_a_chat_threads` SET chat_id = "'.$modx->db->escape($chat_id).'", chat_date = "'.$modx->db->escape(time()).'" ');
            $_SESSION['chat_id'] = $chat_id;
          }

          $message_id = $gpt->threadMessage($chat_id,$question);


          $modx->db->query('INSERT INTO `modx_a_chat_history` SET user_id = "'.$modx->db->escape($user_id).'", message = "'.$modx->db->escape($question).'", message_id = "'.$modx->db->escape($message_id).'", type = "0", date = "'.$modx->db->escape(time()).'", chat_id = "'.$modx->db->escape($chat_id).'" ');


          $runId = $gpt->threadRun($chat_id);

          $gpt->waitTillRunComplete($chat_id, $runId);

          $answer = $gpt->threadMessages($chat_id);

          $modx->db->query('INSERT INTO `modx_a_chat_history` SET user_id = "'.$modx->db->escape($user_id).'", message = "'.$modx->db->escape($answer['answer']).'", message_id = "'.$modx->db->escape($answer['message_id']).'", type = "1", date = "'.$modx->db->escape(time()).'", chat_id = "'.$modx->db->escape($chat_id).'" ');


          $answer_html = $shop->beutifyGptText($answer['answer']);


          $ajax['answer'] = $modx->parseDocumentSource($modx->parseChunk('tpl_chat_a', array('text' => $answer_html)));
          $ajax['ack'] = 'Success';

        }else{
          $answer = 'Напишіть Ваше питання?';
          $ajax['answer'] = $modx->parseDocumentSource($modx->parseChunk('tpl_chat_a', array('text' => $answer)));
          $ajax['ack'] = 'Success';

        }

      }else{
        $answer = 'Послуга доступна тільки для premium користувачів';
        $ajax['answer'] = $modx->parseDocumentSource($modx->parseChunk('tpl_chat_a', array('text' => $answer)));
        $ajax['ack'] = 'Success';

      }
    break;
    case "regpay":


      $post = $_REQUEST['regpay'];
      $error = array();
      $req_fields = array('email', 'phone', 'fullname', 'city', 'password');

      foreach ($req_fields as $key => $value) {
          if ($post[$value] == '') {
              $error[] = 'regpay['.$value.']';
              $ajax['msg'] = 'Заповніть всі необхідні поля';
          }
      }

      if(filter_var($post['email'], FILTER_VALIDATE_EMAIL) === false ){
        $error[] = 'regpay[email]';
        $ajax['msg'] = 'Невірний формат E-mail';
      }

      if(count($error) == 0){
        $sql = 'SELECT * FROM `modx_web_users` WHERE username = "'.$modx->db->escape($post['email']).'" ';
        $query = $modx->db->query($sql);
        $count = $modx->db->getRecordCount($query);
        if($count>0){
          $error[] = 'regpay[email]';
          $ajax['msg'] = 'Цей Email вже зареєстрований. Будь ласка, авторизуйтесь або відновіть пароль';
        }
      }
      if (count($error) == 0) {
        
        $reg = $modx->runSnippet('Registration', array(
          'email' => $post['email'], 
          'blocked' => '0', 
          'password' => $post['password'], 
          'fullname' => $post['fullname'], 
          'city' => $post['city'], 
          'category_type' => $post['category_type'], 
          'lastname' => $post['lastname'], 
          'phone' => $post['phone']));

        $modx->runSnippet("Auth", Array("email" => $post['email'], "autologin" => true));
        //$ajax['redirect'] = $modx->makeUrl(83);

        if($modx->config['esputnik_subscribe'] == '1'){
          include MODX_BASE_PATH . "assets/shop/php/esputnik/esputnik.php";
          $esputnik = new Esputnik($modx->config['esputnik_login'],$modx->config['esputnik_pass']);
          /*
          $answer = $esputnik->subscribe($post);
          if($answer['id'] != '' AND $modx->config['esputnik_group_id_registration'] != ''){
            $esputnik->addToGroup($modx->config['esputnik_group_id_registration'],$answer['id']);
          }
          */
          $post['groups'] = $modx->config['esputnik_group_id_registration'];
          $answer = $esputnik->subscribe_contact($post);
        }

        $sum = $modx->config['subscribe_cost'];
        $user_id = $_SESSION['webuser']['internalKey'];

        if($user_id != ''){
          $user_info = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($user_id).'" LIMIT 1'));

          $hash = uniqid();
          $start = time();
          $end = time();
          $next = strtotime('+1 month', $start);
          $end = strtotime('+1 year', $start);

          $modx->db->query('UPDATE `modx_a_subscribe` SET archive = "1" WHERE user_id = "'.$modx->db->escape($user_id).'" ');

          $modx->db->query('INSERT INTO `modx_a_subscribe` SET user_id = "'.$modx->db->escape($user_id).'", cost = "'.$modx->db->escape($sum).'", start = "'.$modx->db->escape($start).'", next = "'.$modx->db->escape($next).'", end = "'.$modx->db->escape($end).'", hash = "'.$modx->db->escape($hash).'", status = "0", status_pay = "0" ');


          $fullname = $user_info['fullname'];
          $phone = $user_info['phone'];
          $email = $user_info['email'];


          $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
          require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
          $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

          $fields = array();
          $fields['merchantAccount'] = $payment_system['shop_paymid'];
          $fields['merchantAuthType'] = 'SimpleSignature';
          $fields['merchantDomainName'] = 'pdr-online.com.ua';
          $fields['merchantTransactionSecureType'] = 'AUTO';
          $feilds['defaultPaymentSystem'] = 'card';
          $fields['language'] = 'UA';
          $fields['orderReference'] = $hash;
          $fields['orderDate'] = time();
          $fields['amount'] = $sum;
          $fields['currency'] = 'UAH';
          $fields['returnUrl'] = $modx->config['site_url_b'].$modx->makeUrl(175).'?order='.$hash;
          $fields['serviceUrl'] = $modx->config['site_url_b'].$modx->makeUrl(174);
          if($fullname != ''){
            $fields['clientFirstName'] = $fullname;
          }
          if($email != ''){
            $fields['clientEmail'] = $email;
          }
          if($phone != ''){
            $fields['clientPhone'] = $phone;
          }
          $fields['productName'][] = 'Оплата підписки PDR-online';
          $fields['productCount'][] = 1;
          $fields['productPrice'][] = $sum;
          $fields['regularBehavior'] = 'preset';
          $fields['regularMode'] = 'monthly';
          $fields['regularAmount'] = $sum;
          $fields['dateNext'] = date('d.m.Y', $next);
          //$fields['dateEnd'] = date('d.m.Y', $next);
          //$fields['dateEnd'] = $end;
          $fields['regularCount'] = '12';  
          $fields['regularOn'] = '1';
          $fields['merchantSignature'] = $wayforpay->buildHash($payment_system['shop_paysig'],$fields);

          $form = $wayforpay->buildForm($fields);

          $ajax['payform'] = $form;
          $ajax['ack'] = "Success";

        }



      }else{
        $ajax['ack'] = 'Failure';
        $ajax['errors'] = $error;
      }

    break;
    case "subscribe_pay":
        $sum = $modx->config['subscribe_cost'];
        $user_id = $_SESSION['webuser']['internalKey'];

        if($user_id != ''){
          $user_info = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($user_id).'" LIMIT 1'));

          $hash = uniqid();
          $start = time();
          $end = time();
          $next = strtotime('+1 month', $start);
          $end = strtotime('+1 year', $start);

          $modx->db->query('UPDATE `modx_a_subscribe` SET archive = "1" WHERE user_id = "'.$modx->db->escape($user_id).'" ');

          $modx->db->query('INSERT INTO `modx_a_subscribe` SET user_id = "'.$modx->db->escape($user_id).'", cost = "'.$modx->db->escape($sum).'", start = "'.$modx->db->escape($start).'", next = "'.$modx->db->escape($next).'", end = "'.$modx->db->escape($end).'", hash = "'.$modx->db->escape($hash).'", status = "0", status_pay = "0" ');


          $fullname = $user_info['fullname'];
          $phone = $user_info['phone'];
          $email = $user_info['email'];

          require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";


          $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
          require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
          $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

          $fields = array();
          $fields['merchantAccount'] = $payment_system['shop_paymid'];          
          $fields['merchantAuthType'] = 'SimpleSignature';
          $fields['merchantDomainName'] = 'pdr-online.com.ua';
          $fields['merchantTransactionSecureType'] = 'AUTO';
          $feilds['defaultPaymentSystem'] = 'card';
          $fields['language'] = 'UA';
          $fields['orderReference'] = $hash;
          $fields['orderDate'] = time();
          $fields['amount'] = $sum;
          $fields['currency'] = 'UAH';
          $fields['returnUrl'] = $modx->config['site_url_b'].$modx->makeUrl(175).'?order='.$hash;
          $fields['serviceUrl'] = $modx->config['site_url_b'].$modx->makeUrl(174);
          if($fullname != ''){
            $fields['clientFirstName'] = $fullname;
          }
          if($email != ''){
            $fields['clientEmail'] = $email;
          }
          if($phone != ''){
            $fields['clientPhone'] = $phone;
          }
          $fields['productName'][] = 'Оплата підписки PDR-online';
          $fields['productCount'][] = 1;
          $fields['productPrice'][] = $sum;
          $fields['regularBehavior'] = 'preset';
          $fields['regularMode'] = 'monthly';
          $fields['regularAmount'] = $sum;
          $fields['dateNext'] = date('d.m.Y', $next);
          //$fields['dateEnd'] = date('d.m.Y', $next);
          //$fields['dateEnd'] = $end;
          $fields['regularCount'] = '12';  
          $fields['regularOn'] = '1';
          $fields['merchantSignature'] = $wayforpay->buildHash($payment_system['shop_paysig'],$fields);

          $form = $wayforpay->buildForm($fields);

          $ajax['payform'] = $form;
          $ajax['ack'] = "Success";

        }

    break;
    case "subscribe_continue":
        $user_id = $_SESSION['webuser']['internalKey'];

        if($user_id != ''){

          $sbs = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND status = "2" AND archive = "0" LIMIT 1'));

          if($sbs['hash'] != ''){

            $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
            require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
            $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

            $fields = array();
            $fields['requestType'] = 'RESUME';
            $fields['merchantAccount'] = $payment_system['shop_paymid'];
            $fields['merchantPassword'] = $payment_system['shop_paypass'];  
            $fields['orderReference'] = $sbs['hash'];
            $status = $wayforpay->regular($fields);
            
            if($status['reason'] == 'Ok'){
              $modx->db->query('UPDATE `modx_a_subscribe` SET status = "1" WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
              $ajax['ack'] = 'Success';
            }else{
              //Підписка застаріла
              $modx->db->query('UPDATE `modx_a_subscribe` SET archive = "1", status = "4" WHERE user_id = "'.$modx->db->escape($user_id).'" AND status = "2" AND archive = "0" LIMIT 1');
              $ajax['ack'] = 'Failure';
            }
          }
        }
    break;
    case "subscribe_pause":
        $user_id = $_SESSION['webuser']['internalKey'];

        if($user_id != ''){

          $sbs = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND status = "1" AND archive = "0" LIMIT 1'));

          if($sbs['hash'] != ''){


            $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
            require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
            $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

            $fields = array();
            $fields['requestType'] = 'SUSPEND';
            $fields['merchantAccount'] = $payment_system['shop_paymid'];
            $fields['merchantPassword'] = $payment_system['shop_paypass'];  
            $fields['orderReference'] = $sbs['hash'];
            $status = $wayforpay->regular($fields);

            if($status['status'] == 'Ok'){
              $modx->db->query('UPDATE `modx_a_subscribe` SET status = "2" WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
            }else{

              $fields['requestType'] = 'STATUS';

              $status = $wayforpay->regular($fields);

              if($status['status'] == 'Suspended' OR $status['status'] == 'Removed'){
                $modx->db->query('UPDATE `modx_a_subscribe` SET status = "2" WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
              }else{
                $modx->db->query('DELETE FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND hash = "'.$modx->db->escape($sbs['hash']).'" LIMIT 1');
              }
            }
          }
        }
    break;
    /*
    case "subscribe_cancel":
        $user_id = $_SESSION['webuser']['internalKey'];
        if($user_id != ''){

          $sbs = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND status = "1" LIMIT 1'));

          if($sbs['hash'] != ''){

            $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
            require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
            $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);

            $fields = array();
            $fields['requestType'] = 'REMOVE';
            $fields['merchantAccount'] = $payment_system['shop_paymid'];
            $fields['merchantPassword'] = $payment_system['shop_paypass'];  
            $fields['orderReference'] = $sbs['hash'];
            $status = $wayforpay->regular($fields);
          }
        }
    break;
    */
}
die($modx->parseDocumentSource(json_encode($ajax)));