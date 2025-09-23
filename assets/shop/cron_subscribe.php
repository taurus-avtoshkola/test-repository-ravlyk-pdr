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


/*
status upd
require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
$wayforpay = new WayForPay($modx->config['shop_wayforpay_mid'], $modx->config['shop_wayforpay_sig']);

$q = $modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE checked = "0" AND archive = "0" LIMIT 100 ');//668badc99759d
while($r = $modx->db->getRow($q)){



  $fields = array();
  $fields['requestType'] = 'STATUS';
  $fields['merchantAccount'] = $modx->config['shop_wayforpay_mid'];
  $fields['merchantPassword'] = $modx->config['shop_wayforpay_pas'];
  $fields['orderReference'] = $r['hash'];

  $status = $wayforpay->regular($fields);

  $ss = false;
  if($status['reason'] == 'Ok'){
    switch($status['status']){
      case "Created":
        $sdb = 0;
        $ss = false;
      break;
      case "Confirmed":

      break;
      case "Active":
        //+++
        $sdb = 1;
        $ss = true;

      break;
      case "Suspended":
        $sdb = 2;
        $ss = true;

        if($ss){
          $t = time();
          $f = strtotime('+1 month', $t);
          $d = $status['lastPayedDate'];
          $n = $status['nextPaymentDate'];
          if($t > $n){
            $ss = false;
          }
        }
      break;
      case "Removed":
        $sdb = 3;
        $ss = true;
        if($ss){
          $t = time();
          $f = strtotime('+1 month', $t);
          $d = $status['lastPayedDate'];
          $n = $status['nextPaymentDate'];
          if($t > $n){
            $ss = false;
          }
        }
      break;
      case "Completed":
        $sdb = 4;
        $ss = true;

        if($ss){
          $t = time();
          $f = strtotime('+1 month', $t);
          $d = $status['lastPayedDate'];
          $n = $status['nextPaymentDate'];
          if($t > $n){
            $ss = false;
          }
        }


      break;
      default:
        $ss = false;
      break;
    }
  }

  $modx->db->query('UPDATE `modx_a_subscribe` SET checked = "1", status = "'.$modx->db->escape($sdb).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
  


}
echo 'ok';

die;
*/


/*
require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
$wayforpay = new WayForPay($modx->config['shop_wayforpay_mid'], $modx->config['shop_wayforpay_sig']);

$q = $modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE checked = "0" AND archive = "0" LIMIT 10 ');//668badc99759d
while($r = $modx->db->getRow($q)){




  $fields = array();
  $fields['requestType'] = 'STATUS';
  $fields['merchantAccount'] = $modx->config['shop_wayforpay_mid'];
  $fields['merchantPassword'] = $modx->config['shop_wayforpay_pas'];
  $fields['orderReference'] = $r['hash'];

  $status = $wayforpay->regular($fields);

  $ss = false;
  if($status['reason'] == 'Ok'){
    switch($status['status']){
      case "Created":
        $sdb = 0;
        $ss = false;
      break;
      case "Confirmed":

      break;
      case "Active":
        //+++
        $sdb = 1;
        $ss = true;

      break;
      case "Suspended":
        $sdb = 2;
        $ss = true;

        if($ss){
          $t = time();
          $f = strtotime('+1 month', $t);
          $d = $status['lastPayedDate'];
          $n = $status['nextPaymentDate'];
          if($t > $n){
            $ss = false;
          }
        }
      break;
      case "Removed":
        $sdb = 3;
        $ss = true;
        if($ss){
          $t = time();
          $f = strtotime('+1 month', $t);
          $d = $status['lastPayedDate'];
          $n = $status['nextPaymentDate'];
          if($t > $n){
            $ss = false;
          }
        }
      break;
      case "Completed":
        $sdb = 4;
        $ss = true;

        if($ss){
          $t = time();
          $f = strtotime('+1 month', $t);
          $d = $status['lastPayedDate'];
          $n = $status['nextPaymentDate'];
          if($t > $n){
            $ss = false;
          }
        }


      break;
      default:
        $ss = false;
      break;
    }
  }else{

    //not found

  }

  //if($status['lastPayedStatus'] != 'Approved'){$ss = false;}
  
  //lastPayedStatus
  //Declined
  //Approved
  if($ss){
    $pay_s = '1';
    $sdate = ' , subscribedate = "'.$modx->db->escape($status['nextPaymentDate']).'" ';
  }else{
    $pay_s = '0';
    $sdate = '';
  }
  $modx->db->query('UPDATE `modx_a_subscribe` SET checked = "1", status = "'.$modx->db->escape($sdb).'", status_pay = "'.$modx->db->escape($pay_s).'", next = "'.$modx->db->escape($status['nextPaymentDate']).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
  $modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "'.$modx->db->escape($pay_s).'", user_type_p = "'.$modx->db->escape($pay_s).'"  '.$sdate.'  WHERE internalKey = "'.$modx->db->escape($r['user_id']).'" LIMIT 1');



echo $status['lastPayedStatus'].'</br>';


}
echo 'ok';

die;
*/


$t = time();
$f = strtotime('-1 day', $t);
$q = $modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE next > "'.$modx->db->escape($f).'" AND next < "'.$modx->db->escape($t).'" AND archive = "0" ');
while($r = $modx->db->getRow($q)){


  require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
  $wayforpay = new WayForPay($modx->config['shop_wayforpay_mid'], $modx->config['shop_wayforpay_sig']);

  $fields = array();
  $fields['requestType'] = 'STATUS';
  $fields['merchantAccount'] = $modx->config['shop_wayforpay_mid'];
  $fields['merchantPassword'] = $modx->config['shop_wayforpay_pas'];
  $fields['orderReference'] = $r['hash'];

  $status = $wayforpay->regular($fields);

  $ss = false;
  if($status['reason'] == 'Ok')
  switch($status['status']){
    case "Created":
      $sdb = 0;
      $ss = false;
    break;
    case "Confirmed":

    break;
    case "Active":
      //+++
      $sdb = 1;
      $ss = true;

    break;
    case "Suspended":
      $sdb = 2;
      $ss = true;

      if($ss){
        $t = time();
        $f = strtotime('+1 month', $t);
        $d = $status['lastPayedDate'];
        $n = $status['nextPaymentDate'];
        if($t > $n){
          $ss = false;
        }
      }
    break;
    case "Removed":
      $sdb = 3;
      $ss = true;
      if($ss){
        $t = time();
        $f = strtotime('+1 month', $t);
        $d = $status['lastPayedDate'];
        $n = $status['nextPaymentDate'];
        if($t > $n){
          $ss = false;
        }
      }
    break;
    case "Completed":
      $sdb = 4;
      $ss = true;

      if($ss){
        $t = time();
        $f = strtotime('+1 month', $t);
        $d = $status['lastPayedDate'];
        $n = $status['nextPaymentDate'];
        if($t > $n){
          $ss = false;
        }
      }


    break;
  }
 // if($status['lastPayedStatus'] != 'Approved'){
   // $ss = false;
  //}
//lastPayedStatus
//Declined
  //Approved

  if($ss){
    $pay_s = '1';
    $sdate = ' , subscribedate = "'.$modx->db->escape($status['nextPaymentDate']).'" ';
  }else{
    $pay_s = '0';
    $sdate = '';
  }
  $modx->db->query('UPDATE `modx_a_subscribe` SET status = "'.$modx->db->escape($sdb).'", status_pay = "'.$modx->db->escape($pay_s).'", next = "'.$modx->db->escape($status['nextPaymentDate']).'" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');
  $modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "'.$modx->db->escape($pay_s).'", user_type_p = "'.$modx->db->escape($pay_s).'"  '.$sdate.'  WHERE internalKey = "'.$modx->db->escape($r['user_id']).'" AND subscribefix = "0" LIMIT 1');


}

$modx->db->query('UPDATE `modx_web_user_attributes` SET user_type = "0", user_type_p = "0" WHERE subscribedate < "'.$modx->db->escape(time()).'" AND subscribefix = "0" ');



/*

Active - регулярний платіж активний, працює
Suspended - регулярний платіж призупинено
Created - регулярний платіж створений, але не активований
Removed - регулярний платіж видалений
Confirmed - службовий статус
Completed - регулярний платіж завершено

*/

/*
///продление на 1 месяц
    case "subscribe_edit":
        $user_id = $_SESSION['webuser']['internalKey'];

        if($user_id != ''){

          $sbs = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND status = "1" AND archive = "0" LIMIT 1'));

          if($sbs['hash'] != ''){
            $sum = $modx->config['subscribe_cost'];

            require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
            $wayforpay = new WayForPay($modx->config['shop_wayforpay_mid'], $modx->config['shop_wayforpay_sig']);

            $fields = array();
            $fields['requestType'] = 'CHANGE';
            $fields['merchantAccount'] = $modx->config['shop_wayforpay_mid'];
            $fields['merchantPassword'] = $modx->config['shop_wayforpay_pas'];          
            $fields['regularMode'] = 'monthly';
            $fields['currency'] = 'UAH';
  
            $fields['orderReference'] = $sbs['hash'];
            $fields['amount'] = $sum;


            $old_start = $sbs['start'];
            $start = strtotime('+1 month', $old_start);
            $end = $start;

            $fields['dateBegin'] = date('d.m.Y', $start);
            $fields['dateEnd'] = date('d.m.Y', $start);





            $status = $wayforpay->regular($fields);
            if($status['reason'] == 'Ok'){
              $modx->db->query('UPDATE `modx_a_subscribe` SET status = "2" WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
            }
          }
        }
    break;

        */




/*


  require_once MODX_BASE_PATH . "assets/shop/php/wayforpay/wayforpay.php";
  $wayforpay = new WayForPay($modx->config['shop_wayforpay_mid'], $modx->config['shop_wayforpay_sig']);

  $fields = array();
  $fields['requestType'] = 'CHANGE';
  $fields['merchantAccount'] = $modx->config['shop_wayforpay_mid'];
  $fields['merchantPassword'] = $modx->config['shop_wayforpay_pas'];
  $fields['orderReference'] = '66844afbb5b6b';

    $sum = 1;

    $fields['regularMode'] = 'monthly';
    $fields['currency'] = 'UAH';

    $fields['amount'] = $sum;


    $old_start = time();
    $start = strtotime('+1 day', $old_start);
    $end = strtotime('+1 month', $start);
    $fields['dateBegin'] = date('d.m.Y', $start);
    $fields['dateEnd'] = date('d.m.Y', $end);




    $status = $wayforpay->regular($fields);
var_dump($status);die;
    if($status['reason'] == 'Ok'){
      $modx->db->query('UPDATE `modx_a_subscribe` SET status = "2" WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
    }




die;
*/