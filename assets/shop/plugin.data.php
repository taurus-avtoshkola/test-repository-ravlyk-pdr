<?php
/**
 * Обработчик входящих данных
 */




  //Підтвердження відновлення паролю на сайті
  if(isset($_GET['recovery'])){
    if($_GET['recovery'] != ''){
      $sql = 'SELECT * FROM `modx_web_users` WHERE cachepwd = "'.$modx->db->escape($_GET['recovery']).'" LIMIT 1';
      $query = $modx->db->query($sql);
      $row = $modx->db->getRow($query);
      if(isset($row['username'])){
        $modx->db->query('UPDATE `modx_web_users` SET password = cachepwd, cachepwd = "" WHERE cachepwd = "'.$modx->db->escape($_GET['recovery']).'" LIMIT 1');
        $modx->db->query('UPDATE `modx_web_user_attributes` SET blocked = "0", blockeduntil = "0", blockedafter = "0", failedlogincount = "0" WHERE internalKey = "'.$modx->db->escape($row['id']).'" ');
        
        $modx->runSnippet("Auth", Array("email" => $row['username'], "autologin" => true));
        $modx->sendRedirect($modx->makeUrl(83).'?message=recovery_success');
      }
    }
  }
  //Підтвердження реєстрації на сайті
  if(isset($_GET['reg'])){
    $sql = 'SELECT * FROM `modx_web_user_attributes` WHERE uniqid = "'.$modx->db->escape($_GET['reg']).'" LIMIT 1';
    $query = $modx->db->query($sql);
    $row = $modx->db->getRow($query);
    if(isset($row['email'])){
      $modx->db->query('UPDATE `modx_web_user_attributes` SET blocked = 0 WHERE uniqid = "'.$modx->db->escape($_GET['reg']).'" ');
      $modx->runSnippet("Auth", Array("email" => $row['email'], "autologin" => true));
      $modx->sendRedirect($modx->makeUrl(83).'?message=reg_success');
    }
  }

  //Підтвердження відгуку на сайті
  if(isset($_GET['confirm_recall'])){
    $modx->db->query('UPDATE `modx_a_recall` SET recall_moderated = 1 WHERE recall_hash = "'.$modx->db->escape($_GET['confirm_recall']).'" '); 
  }



  /**
   * Вихід з кабінету
   */
  if (isset($_GET['logout'])) {
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
    die(header("Location: /"));
  }



  if(isset($_REQUEST['ajax'])){
    if($_REQUEST['ajax'] == 'instructor_photo'){
      $uploaddir = MODX_BASE_PATH .'/assets/files/instructors/personal/';
      $exp_dir = explode('.',$_FILES['Filedata']['name']);
      if(in_array(end($exp_dir), array('gif','jpg','png','jpeg','JPG','PNG','JPEG'))){
        $new_name = time().'_'.$_FILES['Filedata']['name'];
        $uploadfile = $uploaddir . $new_name;

        move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile);
      }
      die($new_name);
    }
  }

  if(isset($_REQUEST['ajax'])){
    if($_REQUEST['ajax'] == 'instructor_car_photo'){
      $uploaddir = MODX_BASE_PATH .'/assets/files/instructors/car/';
      $exp_dir = explode('.',$_FILES['Filedata']['name']);
      if(in_array(end($exp_dir), array('gif','jpg','png','jpeg','JPG','PNG','JPEG'))){
        $new_name = time().'_'.$_FILES['Filedata']['name'];
        $uploadfile = $uploaddir . $new_name;

        move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile);
      }
      die($new_name);
    }
  }

  if(isset($_REQUEST['ajax'])){
    if($_REQUEST['ajax'] == 'instructor_certificate'){
      $uploaddir = MODX_BASE_PATH .'/assets/files/instructors/certificate/';
      $exp_dir = explode('.',$_FILES['Filedata']['name']);
      if(in_array(end($exp_dir), array('pdf','PDF','gif','jpg','png','jpeg','JPG','PNG','JPEG'))){
        $new_name = time().'_'.$_FILES['Filedata']['name'];
        $uploadfile = $uploaddir . $new_name;

        move_uploaded_file($_FILES['Filedata']['tmp_name'], $uploadfile);
      }
      die($new_name);
    }
  }




  if ($modx->documentIdentifier == '195'){
    $json = file_get_contents('php://input');

    $modx->db->query('INSERT INTO `modx_a_test` SET test_text = "'.$modx->db->escape($json).'" ');
    $array = json_decode($json, true);
    if($array['orderReference'] != ''){


      $ch = $modx->db->query('SELECT * FROM `modx_a_order` WHERE order_hash = "'.$modx->db->escape($array['orderReference']).'" AND order_status_pay = "1" LIMIT 1');
      if($array['transactionStatus'] == 'Approved' AND $modx->db->getRecordCount($ch) == 0){      
        $modx->db->query('UPDATE `modx_a_order` SET order_status_pay = "1" WHERE order_hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');



        //Інформація до таблиці уроків: modx_a_instructor_to_user_web
        $r_ua = $modx->db->getRow($modx->db->query('SELECT o.order_id as order_id, o.order_user_info as order_user_info, wua.fullname, wua.lastname, wua.phone, o.order_client as order_client,
(SELECT cabinet_syncname FROM `modx_web_user_attributes` wi WHERE wi.internalKey = o.order_from LIMIT 1) as instructor_name,
(SELECT internalKey FROM `modx_web_user_attributes` wi WHERE wi.internalKey = o.order_from LIMIT 1) as instructor_ik
FROM `modx_a_order` o
LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = o.order_client
WHERE o.order_hash = "'.$modx->db->escape($array['orderReference']).'"
LIMIT 1'));
        //$r_ua_id = $modx->db->getRow($modx->db->query('SELECT id FROM `modx_a_instructors` WHERE user_id = "'.$modx->db->escape($r_ua['instructor_ik']).'" LIMIT 1'));
        $q_l = $modx->db->query('SELECT op.product_count, op.product_price, p.product_lesson, p.product_lesson_type, p.product_to_school, op.product_id
FROM `modx_a_order_products` op 
LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id
WHERE op.order_id = "'.$modx->db->escape($r_ua['order_id']).'" AND p.product_lesson > 0
');
        if($modx->db->getRecordCount($q_l) > 0){


          
          while($r_l = $modx->db->getRow($q_l)){
            $order_info = json_decode($r_ua['order_user_info'],true);
            $f_name = array();
            $f_name[] = $order_info['lastname'];
            $f_name[] = $order_info['fullname'];
            $f_name[] = $order_info['patronymic'];
            $phone = trim(str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r_ua['phone']))))));
            $lesson = $r_l['product_count']*$r_l['product_lesson'];

            //changed $r_ua_id['id'] to $r_ua['instructor_ik']
            //Тут додавання в рахунок
            $modx->db->query('INSERT INTO `modx_a_instructor_to_user_web` SET 
              order_id        = "'.$modx->db->escape($r_ua['order_id']).'",
              buy_date        = "'.$modx->db->escape(time()).'",
              user_phone      = "'.$modx->db->escape($phone).'",
              user_id         = "'.$modx->db->escape($r_ua['order_client']).'",
              user_name       = "'.$modx->db->escape(trim(implode(' ',$f_name))).'",
              instructor_id   = "'.$modx->db->escape($r_ua['instructor_ik']).'",
              instructor_name = "'.$modx->db->escape($r_ua['instructor_name']).'",
              lesson_total    = "'.$modx->db->escape($lesson).'",
              lesson_balance  = "'.$modx->db->escape($lesson).'",
              bill_sum        = "'.$modx->db->escape($r_ua['order_cost']).'",
              bill_payd       = "1",
              bill_pay_type   = "3",
              add_to_schedule = "0",
              order_school    = "'.$modx->db->escape($r_l['product_to_school']).'",
              type            = "'.$modx->db->escape($r_l['product_lesson_type']).'"
            ');


          }
        }

        //free_premium
        $r_fp = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_order` o LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = o.order_client WHERE o.order_hash = "'.$modx->db->escape($array['orderReference']).'" AND wua.user_type = "0" AND wua.free_premium = "0" LIMIT 1'));
        if($r_fp['free_premium'] == '0' AND $r_fp['internalKey'] != '0' AND $r_fp['internalKey'] != ''){        
          $start = time();
          $next = strtotime('+2 month', $start);
          $modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "1", user_type_p = "0", subscribedate = "'.$modx->db->escape($next).'", subscribefix = "1", free_premium = "1" WHERE internalKey = "'.$modx->db->escape($r_fp['internalKey']).'" LIMIT 1');
        }

      }

      $rid = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_order` WHERE order_hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1'));
      if($rid['order_id'] != ''){
        $paytype = $rid['payment_system_type'];
        $payment_system = json_decode($modx->config['shop_paysystem_'.$paytype],true);
        require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
        $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);
        
      }



      $modx->db->query('UPDATE `modx_a_order` SET order_pay_info = "'.$modx->db->escape($json).'" WHERE order_hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
      $answer["orderReference"] =  $array['orderReference'];
      $answer["status"] = "accept";
      $answer["time"] = time();
      $answer["signature"] = $wayforpay->buildHash($payment_system['shop_paysig'],$answer);
      echo json_encode($answer);
    }
    die;
  }


  if ($modx->documentIdentifier == '173'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);
    if($array['orderReference'] != ''){
      $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
      require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
      $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);
      if($array['transactionStatus'] == 'Approved'){     
        $ch = $modx->db->query('SELECT * FROM `modx_a_online` WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
        $chr = $modx->db->getRow($ch); 
        $modx->db->query('UPDATE `modx_web_user_attributes` SET online_course = "1" WHERE internalKey = "'.$modx->db->escape($chr['user_id']).'" LIMIT 1');

        $modx->db->query('UPDATE `modx_a_online` SET status_pay = "1", status = "1" WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
        


        //free_premium
        $r_fp = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($chr['user_id']).'" AND free_premium = "0" LIMIT 1'));
        if($r_fp['free_premium'] == '0' AND $r_fp['internalKey'] != '0' AND $r_fp['internalKey'] != ''){        
          $start = time();
          $next = strtotime('+2 month', $start);
          $modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "1", user_type_p = "0", subscribedate = "'.$modx->db->escape($next).'", subscribefix = "1", free_premium = "1" WHERE internalKey = "'.$modx->db->escape($r_fp['internalKey']).'" LIMIT 1');
        }

        

      }
      $modx->db->query('UPDATE `modx_a_online` SET pay_info = "'.$modx->db->escape($json).'" WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
      $answer["orderReference"] =  $array['orderReference'];
      $answer["status"] = "accept";
      $answer["time"] = time();
      $answer["signature"] = $wayforpay->buildHash($payment_system['shop_paysig'],$answer);
      echo json_encode($answer);
    }
    die;
  }

  if ($modx->documentIdentifier == '174'){
    $json = file_get_contents('php://input');
    $modx->db->query('INSERT INTO `modx_a_test` SET test_text = "'.$modx->db->escape($json).'" ');
    $array = json_decode($json, true);
    if($array['orderReference'] != ''){
      $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
      require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
      $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);
      $ch = $modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE hash = "'.$modx->db->escape($array['orderReference']).'" AND status_pay = "1" LIMIT 1');
      if($array['transactionStatus'] == 'Approved' AND $modx->db->getRecordCount($ch) == 0){      
        $modx->db->query('UPDATE `modx_a_subscribe` SET status = "1", status_pay = "1" WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');

        $sbs = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1'));
        $modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "1", user_type_p = "1", subscribedate = "'.$modx->db->escape($sbs['next']).'" WHERE internalKey = "'.$modx->db->escape($sbs['user_id']).'" LIMIT 1');
      }
      $modx->db->query('UPDATE `modx_a_subscribe` SET pay_info = "'.$modx->db->escape($json).'" WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
      $answer["orderReference"] =  $array['orderReference'];
      $answer["status"] = "accept";
      $answer["time"] = time();
      $answer["signature"] = $wayforpay->buildHash($payment_system['shop_paysig'],$answer);
      echo json_encode($answer);
    }
    die;
  }


  if ($modx->documentIdentifier == '459'){
    $json = file_get_contents('php://input');
    $array = json_decode($json, true);
    if($array['orderReference'] != ''){
      $payment_system = json_decode($modx->config['shop_paysystem_'.$modx->config['shop_paysystem_default']],true);
      require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
      $wayforpay = new WayForPay($payment_system['shop_paymid'], $payment_system['shop_paysig']);
      if($array['transactionStatus'] == 'Approved'){     
        $ch = $modx->db->query('SELECT * FROM `modx_a_video` WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
        $chr = $modx->db->getRow($ch); 
        
        $modx->db->query('UPDATE `modx_a_video` SET status_pay = "1" WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
        
        //free_premium
        /*
        $r_fp = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($chr['user_id']).'" AND free_premium = "0" LIMIT 1'));
        if($r_fp['free_premium'] == '0' AND $r_fp['internalKey'] != '0' AND $r_fp['internalKey'] != ''){        
          $start = time();
          $next = strtotime('+2 month', $start);
          $modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "1", user_type_p = "0", subscribedate = "'.$modx->db->escape($next).'", subscribefix = "1", free_premium = "1" WHERE internalKey = "'.$modx->db->escape($r_fp['internalKey']).'" LIMIT 1');
        }
        */        

      }
      $modx->db->query('UPDATE `modx_a_video` SET pay_info = "'.$modx->db->escape($json).'" WHERE hash = "'.$modx->db->escape($array['orderReference']).'" LIMIT 1');
      $answer["orderReference"] =  $array['orderReference'];
      $answer["status"] = "accept";
      $answer["time"] = time();
      $answer["signature"] = $wayforpay->buildHash($payment_system['shop_paysig'],$answer);
      echo json_encode($answer);
    }
    die;
  }