<?php
  require MODX_BASE_PATH . "assets/shop/shop.class.php";
  $shop = new Shop($modx);
   $lang_content = ', pagetitle_'.$modx->config['lang'].' as pagetitle, 
                   longtitle_'.$modx->config['lang'].' as longtitle, 
                   introtext_'.$modx->config['lang'].' as introtext,
                   description_'.$modx->config['lang'].' as description,
                   link_attributes_'.$modx->config['lang'].' as link_attributes,
                   content_'.$modx->config['lang'].' as content
                   ';

/*
if(isset($_SESSION['webuser']['test_photo'])){
  if($_SESSION['webuser']['test_photo'] === 0){
    $ravlik_photo = false;
  }else{
    $ravlik_photo = true;
  }
}else{
  $ravlik_photo = true;
}
*/
$ravlik_photo = true;
switch($get) {
  case "form_price":
    $res =  number_format($price,'0','.',' ');
  break;
  case "ads":
    if($_SESSION['webuser']['user_type'] != '1'){
      $res = $modx->getChunk('ADS');
    }
  break;
  /*
  case "helper":
    if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
      $res = $modx->getChunk('HELPER');
    }
  break;
  */
  case "chat":
    if($_SESSION['chat_id'] != ''){
      $q = $modx->db->query('SELECT * FROM `modx_a_chat_history` WHERE chat_id = "'.$modx->db->escape($_SESSION['chat_id']).'" ORDER BY date ASC ');
      while($r = $modx->db->getRow($q)){
        if($r['type'] == '0'){
          $res .= $modx->parseChunk('tpl_chat_q', array('text' => $r['message']));
        }else{

          $answer_html = $shop->beutifyGptText($r['message']);
          $res .= $modx->parseChunk('tpl_chat_a', array('text' => $answer_html));
        }
      }
    }
  break;
  case "random_img":
    $ie = explode(',',$imgs);
    $ttl = count($ie)-1;
    $rr = rand(0,$ttl);
    $res = $ie[$rr];
  break;
  case "tsc_maps":
    if($tsc_map != ''){
      $exp_tsc_map = explode(',',$tsc_map);
      foreach($exp_tsc_map as $map){
        $inner .= $modx->parseChunk($tpl, array('map' => $map));
      }
      if($inner != ''){
        $res = $modx->parseChunk($tpl_outer, array('inner' => $inner,'tsc_map_text' => $tsc_map_text));
      }
    }
  break;
  case "instructors_city_block":
    if($instructors_block_type == 'insctructors'){
      $res = $modx->getChunk($tpl);
    }else{
      $res = $modx->getChunk($tpl_defautt);
    }
  break;
  case "full_study_city":
    if($parent != ''){
      $q = $modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($parent).'" AND template = "111" AND published = "1" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
        $r = $modx->db->getRow($q);


        $tvres2 = $modx->getTemplateVar(
                    $idname  = 'price_avt',
                    $fields = '*',
                    $docid =  $r['id']
                    );
        $r['price_avt'] = $tvres2['value'];
        $tvres2 = $modx->getTemplateVar(
                    $idname  = 'price_mec',
                    $fields = '*',
                    $docid =  $r['id']
                    );
        $r['price_mec'] = $tvres2['value'];

        $res = $modx->parseChunk($tpl,$r);
      }
    }
  break;
  case "locations":
    if($locations != ''){
      $exp_locations = explode(',',$locations);
      foreach($exp_locations as $location){
        $inner .= $modx->parseChunk($tpl, array('location' => $location));
      }
      if($inner != ''){
        $res = $modx->parseChunk($tpl_outer, array('inner' => $inner));
      }
    }
  break;
  case "road_marking_game":
    if($_SESSION['webuser']['user_type'] == '1'){
      $count = 0;
      $q = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` ORDER BY rand() LIMIT '.$limit);
      $right = array();
      while ($r = $modx->db->getRow($q)) {
        $r['count'] = $count;
        $res .= $modx->parseChunk($tpl,$r);
        $right[] = $modx->parseChunk($tpl2,$r);
        $count++;
      }
      shuffle($right);
      $modx->setPlaceholder('road_sign_game_right', implode('',$right));
    }else{
      $modx->setPlaceholder('road_sign_game_right',$modx->getChunk('test_game_sign_premium_only'));
    }
  break;
  case "road_sign_game":
    if($_SESSION['webuser']['user_type'] == '1'){
      $count = 0;
      $q = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` ORDER BY rand() LIMIT '.$limit);
      $right = array();
      while ($r = $modx->db->getRow($q)) {
        $r['count'] = $count;
        $res .= $modx->parseChunk($tpl,$r);
        $right[] = $modx->parseChunk($tpl2,$r);
        $count++;
      }
      shuffle($right);
      $modx->setPlaceholder('road_sign_game_right', implode('',$right));
    }else{
      $modx->setPlaceholder('road_sign_game_right',$modx->getChunk('test_game_sign_premium_only'));
    }
  break;
  case "test_theme_pk":
    if($_SESSION['webuser']['internalKey'] != ''){

      if(isset($_SESSION['webuser']['category_type']) AND $_SESSION['webuser']['category_type'] != '0'){
        $category_letter = $_SESSION['webuser']['category_type'];
      }else{
        $category_letter = 'b';
      }
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_category` WHERE category_letter = "'.$modx->db->escape($category_letter).'" LIMIT 1'));
      $category = $r['category_id'];

      $tickets = $modx->db->query('SELECT *, qt.id as id,
        (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_theme` qt 
         LEFT JOIN `new_category_2_theme` c2t ON c2t.theme = qt.id
         LEFT JOIN `new_theme_2_user_time` t2ut ON t2ut.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2ut.theme_id = qt.id
         WHERE c2t.category = "'.$modx->db->escape($category).'" ORDER BY qt.position ASC
         ');

      $ttl_done = 0;
      $ttl_correct = 0;
      $ttl_incorrect = 0;
      $ttl_all = 0;
      $ttl_usertime = 0;
      $ttl_minutes = 0;
      $ttl_seconds = 0;
      if($modx->db->getRecordCount($tickets) > 0){
        while($r = $modx->db->getRow($tickets)){
          $r['ttl_done'] = $r['correct']+$r['incorrect'];
          if($r['ttl_done'] > 0){
            $r['percent'] = round($r['ttl_done']/$r['questions']*100);
            $r['percent_correct'] = round($r['correct']/$r['ttl_done']*100);
            $r['percent_incorrect'] = round($r['incorrect']/$r['ttl_done']*100);
          }else{
            $r['percent'] = 0;
            $r['percent_correct'] = 0;
            $r['percent_incorrect'] = 0;
          }
          if($r['percent'] > 30){
            $r['percent_margin'] = $r['percent'] - 10;
          }else{
            $r['percent_margin'] = $r['percent'];
          }
          $ttl_done += $r['ttl_done'];
          $ttl_correct += $r['correct'];
          $ttl_incorrect += $r['incorrect'];
          $ttl_all += $r['questions'];
          if($r['usertime'] != '' AND $r['usertime'] != 0){
            $ms = explode(':',$r['usertime']);
            $ttl_minutes += $ms[0];
            $ttl_seconds += $ms[1];
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet',$r);
          }
        }
        if($ttl_done > 0){
            $percent_all = round($ttl_done/$ttl_all*100);
            $percent_correct = round($ttl_correct/$ttl_done*100);
            $percent_incorrect = round($ttl_incorrect/$ttl_done*100);
        }else{
          $percent_all = 0;
          $percent_correct = 0;
          $percent_incorrect = 0;
        }
        if($ttl_seconds > 60){
          $apminutes = floor($ttl_seconds/60);
          $ttl_minutes = $ttl_minutes+$apminutes;
          $ttl_seconds = $ttl_seconds-$apminutes*60;
        }
        if($ttl_minutes > 0 OR $ttl_seconds > 0){
          $ttl_usertime = $ttl_minutes.':'.$ttl_seconds;
        }
        $ttl_ss = $ttl_minutes*60+$ttl_seconds;
        $answered = $ttl_incorrect+$ttl_correct;
        if($ttl_all > 0 AND $answered > 0){
          $ttl_usertime_by_answer = round($ttl_ss/$answered);
        }
        $progress = $modx->parseChunk('tpl_progress_theme_pk', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime, 'ttl_usertime_by_answer' => $ttl_usertime_by_answer));
        $modx->setPlaceholder('progress_theme',$progress);


      }
    }
  break;
  case "test_ticket_pk":
    if($_SESSION['webuser']['internalKey'] != ''){
      $tickets = $modx->db->query('SELECT *, qt.id as id,
        (SELECT count(question_id) FROM `new_question_2_ticket` q2t WHERE q2t.ticket_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_ticket_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.ticket_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_ticket_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.ticket_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_ticket` qt 
         LEFT JOIN `new_ticket_2_user_time` t2ut ON t2ut.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2ut.ticket_id = qt.id
         WHERE 1 = 1 ORDER BY qt.position ASC LIMIT 40
         ');
      $ttl_done = 0;
      $ttl_correct = 0;
      $ttl_incorrect = 0;
      $ttl_all = 0;
      $ttl_usertime = 0;
      $ttl_minutes = 0;
      $ttl_seconds = 0;
      if($modx->db->getRecordCount($tickets) > 0){
        while($r = $modx->db->getRow($tickets)){
          $r['ttl_done'] = $r['correct']+$r['incorrect'];
          if($r['ttl_done'] > 0){
            $r['percent'] = round($r['ttl_done']/$r['questions']*100);
            $r['percent_correct'] = round($r['correct']/$r['ttl_done']*100);
            $r['percent_incorrect'] = round($r['incorrect']/$r['ttl_done']*100);
          }else{
            $r['percent'] = 0;
            $r['percent_correct'] = 0;
            $r['percent_incorrect'] = 0;
          }
          if($r['percent'] > 30){
            $r['percent_margin'] = $r['percent'] - 10;
          }else{
            $r['percent_margin'] = $r['percent'];
          }
          $ttl_done += $r['ttl_done'];
          $ttl_correct += $r['correct'];
          $ttl_incorrect += $r['incorrect'];
          $ttl_all += $r['questions'];
          if($r['usertime'] != '' AND $r['usertime'] != 0){
            $ms = explode(':',$r['usertime']);
            $ttl_minutes += $ms[0];
            $ttl_seconds += $ms[1];
            $res .= $modx->parseChunk('tpl_test_nav_ticket_cabinet',$r);
          }
        }
        if($ttl_done > 0){
            $percent_all = round($ttl_done/$ttl_all*100);
            $percent_correct = round($ttl_correct/$ttl_done*100);
            $percent_incorrect = round($ttl_incorrect/$ttl_done*100);
        }else{
          $percent_all = 0;
          $percent_correct = 0;
          $percent_incorrect = 0;
        }
        if($ttl_seconds > 60){
          $apminutes = floor($ttl_seconds/60);
          $ttl_minutes = $ttl_minutes+$apminutes;
          $ttl_seconds = $ttl_seconds-$apminutes*60;
        }
        if($ttl_minutes > 0 OR $ttl_seconds > 0){
          $ttl_usertime = $ttl_minutes.':'.$ttl_seconds;
        }
        $ttl_ss = $ttl_minutes*60+$ttl_seconds;
        $answered = $ttl_incorrect+$ttl_correct;
        if($ttl_all > 0 AND $answered > 0){
          $ttl_usertime_by_answer = round($ttl_ss/$answered);
        }
        $progress = $modx->parseChunk('tpl_progress_ticket_pk', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime, 'ttl_usertime_by_answer' => $ttl_usertime_by_answer));
        $modx->setPlaceholder('progress_ticket',$progress);
      }
    }else{
      $q = $modx->db->query('SELECT *, (SELECT count(question_id) FROM `new_question_2_ticket` q2t WHERE q2t.ticket_id = qt.id) as questions FROM `new_question_ticket` qt WHERE 1 = 1 ORDER BY qt.position ASC  LIMIT 40');
      while ($r = $modx->db->getRow($q)) {
        $res .= $modx->parseChunk('tpl_test_nav_ticket',$r);
      }
    }


  break;
  case "personal_statistics_chart":

    switch($type){
      case "ticket":
        $q = $modx->db->query('SELECT count(t2u.question_id) as ttl, t2u.user_id, t2u.answer_date, (SELECT count(tc.question_id) FROM `new_ticket_2_user` tc WHERE tc.user_id = t2u.user_id AND tc.status = "1" AND tc.answer_date = t2u.answer_date LIMIT 1) as correct
          FROM `new_ticket_2_user` t2u
          WHERE user_id = "'.$_SESSION['webuser']['internalKey'].'" AND t2u.answer_date != "0"
          GROUP BY t2u.answer_date
          ORDER BY answer_date DESC LIMIT '.$limit);

      break;
      case "theme":
        $q = $modx->db->query('SELECT count(t2u.question_id) as ttl, t2u.user_id, t2u.answer_date, (SELECT count(tc.question_id) FROM `new_theme_2_user` tc WHERE tc.user_id = t2u.user_id AND tc.status = "1" AND tc.answer_date = t2u.answer_date LIMIT 1) as correct
          FROM `new_theme_2_user` t2u
          WHERE user_id = "'.$_SESSION['webuser']['internalKey'].'" AND t2u.answer_date != "0"
          GROUP BY t2u.answer_date
          ORDER BY answer_date DESC LIMIT '.$limit);

      break;
    }
    $gr = array();
    while($r = $modx->db->getRow($q)){
      $date = explode('-',$r['answer_date']);
      $r['date'] = $date[2].'.'.$date[1];
      $r['incorrect'] = $r['ttl'] - $r['correct'];
      $gr[] = $r;
      
      if(!isset($ttl)){
        $ttl = $r['ttl'];
      }else{
        if($r['ttl'] > $ttl){
          $ttl = $r['ttl'];
        }
      } 
    }
    if(count($gr)>0){ 
      foreach($gr as $g){
        if($g['correct'] > 0){
          $g['size_correct'] = round($g['correct']/$ttl,2);
          if($g['size_correct'] == 0){
            $g['size_correct'] = 0.1;
          }
        }else{
          $g['size_correct'] = 0;
        }
        if($g['incorrect'] > 0){
          $g['size_incorrect'] = round($g['incorrect']/$ttl,2);
          if($g['size_incorrect'] == 0){
            $g['size_incorrect'] = 0.1;
          }
        }else{
          $g['size_incorrect'] = 0;
        }
        $res .= $modx->parseChunk($tpl, $g);
      }
    }
  break;
  case "personal_statistics":

    switch($type){
      case "ticket":
        $q = $modx->db->query('SELECT count(t2u.question_id) as ttl, t2u.user_id, t2u.answer_date, (SELECT count(tc.question_id) FROM `new_ticket_2_user` tc WHERE tc.user_id = t2u.user_id AND tc.status = "1" AND tc.answer_date = t2u.answer_date LIMIT 1) as correct
          FROM `new_ticket_2_user` t2u
          WHERE user_id = "'.$_SESSION['webuser']['internalKey'].'" AND t2u.answer_date != "0"
          GROUP BY t2u.answer_date
          ORDER BY answer_date DESC LIMIT '.$limit);

      break;
      case "theme":
        $q = $modx->db->query('SELECT count(t2u.question_id) as ttl, t2u.user_id, t2u.answer_date, (SELECT count(tc.question_id) FROM `new_theme_2_user` tc WHERE tc.user_id = t2u.user_id AND tc.status = "1" AND tc.answer_date = t2u.answer_date LIMIT 1) as correct
          FROM `new_theme_2_user` t2u
          WHERE user_id = "'.$_SESSION['webuser']['internalKey'].'" AND t2u.answer_date != "0"
          GROUP BY t2u.answer_date
          ORDER BY answer_date DESC LIMIT '.$limit);

      break;
    }

    while($r = $modx->db->getRow($q)){
      $date = explode('-',$r['answer_date']);
      $r['date'] = $date[2].'.'.$date[1].'.'.$date[0];
      $r['incorrect'] = $r['ttl'] - $r['correct'];
      $res .= $modx->parseChunk($tpl, $r);
    }
  break;
  case "stat_date":
    $res = date('d-m-Y');
  break;
  case "statistics":


    $mem = new Memcache;
    $mem->connect($modx->config['memcache_server'], $modx->config['memcache_port']);
    $cache_params = array('get' => $get,'type' => $type);
    $json_cache_params = md5(json_encode($cache_params));
    $flContent = $mem->get($json_cache_params);
    if($flContent){
      $res = $flContent;
    }else{

      $day = date('Y-m-d');
      switch($type){
        case "ticket":
          $q = $modx->db->query('SELECT count(t2u.question_id) as correct, t2u.user_id, wua.fullname, wua.lastname, wua.city, wua.user_type,
          (SELECT count(tc.question_id) FROM `new_ticket_2_user` tc WHERE tc.user_id = t2u.user_id  AND tc.answer_date = "'.$modx->db->escape($day).'"  LIMIT 1) as ttl
          FROM `new_ticket_2_user` t2u
          LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = t2u.user_id
          WHERE t2u.status = "1" AND t2u.answer_date = "'.$modx->db->escape($day).'" 
          GROUP BY t2u.user_id
          ORDER BY correct DESC
          LIMIT '.$limit);
        break;
        case "theme":
          $q = $modx->db->query('SELECT count(t2u.question_id) as correct, t2u.user_id, wua.fullname, wua.lastname, wua.city, wua.user_type,
          (SELECT count(tc.question_id) FROM `new_theme_2_user` tc WHERE tc.user_id = t2u.user_id AND tc.answer_date = "'.$modx->db->escape($day).'"  LIMIT 1) as ttl
          FROM `new_theme_2_user` t2u
          LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = t2u.user_id
          WHERE t2u.status = "1" AND t2u.answer_date = "'.$modx->db->escape($day).'" 
          GROUP BY t2u.user_id
          ORDER BY correct DESC
          LIMIT '.$limit);
        break;
      }
      $place = 1;
      while($r = $modx->db->getRow($q)){
        $ci = explode(',',$r['city']);
        $r['city'] = trim(array_pop($ci));
        $r['place'] = $place;
        $fn = explode(' ',$r['fullname']);
        $r['fullname'] = array_pop($fn);
        $r['lastname'] = $shop->maskStringHidden($r['lastname']);
        $r['incorrect'] = $r['ttl'] - $r['correct'];
        $res .= $modx->parseChunk($tpl, $r);
        $place++;
      }


      $mem->set($json_cache_params, $res, MEMCACHE_COMPRESSED, $modx->config['memcache_time']);
    }
  break;
  case "my_subscription":
      $user_id = $_SESSION['webuser']['internalKey'];
      if($user_id != ''){
        switch($_SESSION['webuser']['user_type']){
          case "0":
            $usertypename = '<span class="user_type_0">Standart</span>';
            $active_to = '';
          break;
          case "1":
            $usertypename = '<span class="user_type_1">Premium</span>';
            if($_SESSION['webuser']['subscribedate'] != ''){
              $active_to = '<div class="active_to"><span>Підписка активна до: </span><div>'.date('d.m.Y', ($_SESSION['webuser']['subscribedate']+$modx->config['server_offset_time'])).'</div></div>';
            }
          break;
        }
        $q = $modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          while($r = $modx->db->getRow($q)){
            $r['start'] = date('d-m-Y', ($r['start']+$modx->config['server_offset_time']));
            $r['next'] = '';
            switch($r['status']){
              case "0":
                $r['actions'] = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
              break;
              case "1":
                $r['actions'] = '<a href="#" class="subscribe_pause btn btn_main">Призупинити підписку</a>';
                $r['next'] = date('d-m-Y', ($r['next']+$modx->config['server_offset_time']));
              break;
              case "2":
                $r['actions'] = '<a href="#" class="subscribe_continue btn btn_main">Відновити підписку</a>';
              break;
              case "3":
                $r['actions'] = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
              break;
              case "4":
                $r['actions'] = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
              break;
            }
            $r['active_to'] = $active_to;
            $inner = $modx->parseChunk('tpl_subscripition',$r);
            $buy_btn = '';
          }
        }else{
          $inner = '';
          $buy_btn = '<div class="subscribe_block"><div class="subscribe_cost">Вартість підписки: <span>'.$modx->config['subscribe_cost'].' <span>грн.</span></span></div><a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a></div>';
          
        }
        $res = $modx->parseChunk('tpl_subscripition_outer', array('active_to' => $active_to, 'usertypename' => $usertypename, 'inner' => $inner, 'buy_btn' => $buy_btn));
      }
  break;
  case "subscribe_pay_btn":
    $user_id = $_SESSION['webuser']['internalKey'];
    if($user_id != ''){
      $q = $modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE user_id = "'.$modx->db->escape($user_id).'" AND archive = "0" LIMIT 1');
      if($modx->db->getRecordCount($q) == 0){
        $res = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
      }else{
        while($r = $modx->db->getRow($q)){
          switch($r['status']){
            case "0":
              $res = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
            break;
            case "1":
              $res = '<a href="#" class="subscribe_pause btn btn_main">Призупинити підписку</a>';
            break;
            case "2":
              $res = '<a href="#" class="subscribe_continue btn btn_main">Відновити підписку</a>';
            break;
            case "3":
              $res = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
            break;
            case "4":
              $res = '<a href="#" class="subscribe_pay btn btn_main">Оформити підписку</a>';
            break;
          }
        }
      }
    }else{
      $res = '<a href="#" class="subscribe_regpay btn btn_main">Оформити підписку</a>';
    }
  break;
  case "my_cabinet_new":
    switch($_SESSION['webuser']['cabinet_type']){
      case "0":
      default:
        //Користувач
        $res = '';
      break;
      case "1":
        //Інструктор
        $res = $modx->getChunk('tpl_cabinet_instructor_new');
      break;
      case "2":
        //Менеджер
        $res = $modx->getChunk('tpl_cabinet_manager_new');
      break;
      case "3":
        //Супер менеджер
        $res = $modx->getChunk('tpl_cabinet_supermanager_new');
      break;
    }
  break;
  case "my_cabinet":
    switch($_SESSION['webuser']['cabinet_type']){
      case "0":
      default:
        //Користувач
        $res = '';
      break;
      case "1":
        //Інструктор
        $res = $modx->getChunk('tpl_cabinet_instructor');
      break;
      case "2":
        //Менеджер
        $res = $modx->getChunk('tpl_cabinet_manager');
      break;
      case "3":
        //Супер менеджер
        $res = $modx->getChunk('tpl_cabinet_supermanager');
      break;
    }
  break;
  case "instructor_stat":
    switch($type){
      case "this":
        $from = date('Y-m-d', strtotime('monday this week'));
        $to = date('Y-m-d', strtotime('yesterday'));
      break;
      case "this_plan":
        $from = date('Y-m-d');
        $to = date('Y-m-d', strtotime('sunday this week'));
      break;
      case "prev":
        if(date('N') == 1){
          $from = date('Y-m-d', strtotime('monday -1 week'));
          $to = date('Y-m-d', strtotime('last Sunday'));
        }else{
          $from = date('Y-m-d', strtotime('monday -2 week'));
          $to = date('Y-m-d', strtotime('last Sunday'));
        }
      break;
    }
    $r = $modx->db->getRow($modx->db->query('SELECT count(isc.id) as total FROM `modx_a_instructor_schedule` isc
LEFT JOIN `modx_a_instructor_schedule_to_reserv` istr ON istr.schedule_id = isc.id 
WHERE (istr.status = "2" OR istr.status = "3") AND isc.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND day >= "'.$modx->db->escape($from).'" AND day <= "'.$modx->db->escape($to).'" LIMIT 1'));
    $res = $r['total'];
  break;
  case "lessons_done":
    $time = time()+$modx->config['server_offset_time'];
    $to = date('Y-m-d H:i:s',$time);

    /*
    $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
      LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
      LEFT JOIN `modx_web_user_attributes` wua ON wua.cabinet_syncname = itu.instructor_name
      LEFT JOIN `modx_a_instructors` i ON i.user_id = wua.internalKey
      WHERE ustr.client_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND isc.full < "'.$modx->db->escape($to).'"
      ORDER BY isc.full DESC, ustr.status ASC
    ');
    if($modx->db->getRecordCount($q) > 0){
      while($r = $modx->db->getRow($q)){
        switch($r['type']){
          default: 
          case "0":
            $r['lesson_type_text'] = 'Основне';
          break;
          case "1":
            $r['lesson_type_text'] = 'Додаткове';
          break;
          case "2":
            $r['lesson_type_text'] = 'Подача авто на іспит';
          break;
        }
        switch($r['status']){
          default: 
          case "2":
            $r['status_type_class'] = 's_warning';
            $r['status_type_text'] = 'Заброньовано';
          break;
          case "3":
            $r['status_type_class'] = 's_danger';
            $r['status_type_text'] = 'Скасовано';
          break;
        }
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
          $r['change'] = 1;
        }else{
          $r['change'] = 0;
        }
        $r['phone_p'] = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['phone'])))));
        $res .= $modx->parseChunk($tpl,$r);
      }
    }
    */


    $q2 = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove
      FROM `modx_a_instructor_schedule_to_reserv` istr
      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = istr.schedule_id
      LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = isc.user_id
      LEFT JOIN `modx_a_instructors` i ON i.user_id = wua.internalKey
      LEFT JOIN `modx_a_user_schedule_to_reserv` ustr ON ustr.schedule_id = isc.id
      WHERE istr.client_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND isc.full < "'.$modx->db->escape($to).'"
      ORDER BY isc.full DESC
    ');
    if($modx->db->getRecordCount($q2) > 0){
      while($r = $modx->db->getRow($q2)){
        switch($r['type']){
          default: 
          case "0":
            $r['lesson_type_text'] = 'Основне';
          break;
          case "1":
            $r['lesson_type_text'] = 'Додаткове';
          break;
          case "2":
            $r['lesson_type_text'] = 'Подача авто на іспит';
          break;
        }
        switch($r['status']){
          default: 
          case "2":
            $r['status_type_class'] = 's_warning';
            $r['status_type_text'] = 'Заброньовано';
          break;
          case "3":
            $r['status_type_class'] = 's_danger';
            $r['status_type_text'] = 'Скасовано';
          break;
        }
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
        if($r['start'] > $modx->config['time_to_change_book'] AND $r['reserv_id'] != ''){
          $r['change'] = 1;
        }else{
          $r['change'] = 0;
        }
        $r['phone_p'] = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['phone'])))));
        $res .= $modx->parseChunk($tpl,$r);
      }
    }

    if($res == ''){
      $res = $modx->getChunk($tpl_empty);
    }

  break;
  case "lessons_plan":

    $time = time()+$modx->config['server_offset_time'];
    $to = date('Y-m-d H:i:s',$time);

    /*
    $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
      LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
      LEFT JOIN `modx_web_user_attributes` wua ON wua.cabinet_syncname = itu.instructor_name
      LEFT JOIN `modx_a_instructors` i ON i.user_id = wua.internalKey
      WHERE ustr.client_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND isc.full > "'.$modx->db->escape($to).'"
      ORDER BY isc.full DESC, ustr.status ASC
    ');
    if($modx->db->getRecordCount($q) > 0){
      while($r = $modx->db->getRow($q)){
        switch($r['type']){
          default: 
          case "0":
            $r['lesson_type_text'] = 'Основне';
          break;
          case "1":
            $r['lesson_type_text'] = 'Додаткове';
          break;
          case "2":
            $r['lesson_type_text'] = 'Подача авто на іспит';
          break;
        }
        switch($r['status']){
          default: 
          case "2":
            $r['status_type_class'] = 's_warning';
            $r['status_type_text'] = 'Заброньовано';
          break;
          case "3":
            $r['status_type_class'] = 's_danger';
            $r['status_type_text'] = 'Скасовано';
          break;
        }
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
          $r['change'] = 1;
        }else{
          $r['change'] = 0;
        }
        $r['phone_p'] = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['phone'])))));
        $res .= $modx->parseChunk($tpl,$r);
      }
    }
    */
    $q2 = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove
      FROM `modx_a_instructor_schedule_to_reserv` istr
      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = istr.schedule_id
      LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = isc.user_id
      LEFT JOIN `modx_a_instructors` i ON i.user_id = wua.internalKey
      LEFT JOIN `modx_a_user_schedule_to_reserv` ustr ON ustr.schedule_id = isc.id
      WHERE istr.client_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND isc.full > "'.$modx->db->escape($to).'"
      ORDER BY isc.full DESC
    ');
    if($modx->db->getRecordCount($q2) > 0){
      while($r = $modx->db->getRow($q2)){
        switch($r['type']){
          default: 
          case "0":
            $r['lesson_type_text'] = 'Основне';
          break;
          case "1":
            $r['lesson_type_text'] = 'Додаткове';
          break;
          case "2":
            $r['lesson_type_text'] = 'Подача авто на іспит';
          break;
        }
        switch($r['status']){
          default: 
          case "2":
            $r['status_type_class'] = 's_warning';
            $r['status_type_text'] = 'Заброньовано';
          break;
          case "3":
            $r['status_type_class'] = 's_danger';
            $r['status_type_text'] = 'Скасовано';
          break;
        }
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


        if($r['start'] > $modx->config['time_to_change_book'] AND $r['reserv_id'] != ''){
          $r['change'] = 1;
        }else{
          $r['change'] = 0;
        }

        $r['phone_p'] = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['phone'])))));
        $res .= $modx->parseChunk($tpl,$r);
      }
    }


    if($res == ''){
      $res = $modx->getChunk($tpl_empty);
    }



  break;
  case "lessons_bought":
  
    $q = $modx->db->query('SELECT *, itu.type as lesson_type, i.user_id as instructor_id
    FROM `modx_a_instructor_to_user` itu
    LEFT JOIN `modx_web_user_attributes` wua ON wua.cabinet_syncname = itu.instructor_name
    LEFT JOIN `modx_a_instructors` i ON i.user_id = wua.internalKey
    WHERE itu.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ORDER BY itu.row_id ASC');
    if($modx->db->getRecordCount($q) > 0){
      while($r = $modx->db->getRow($q)){
        switch($r['lesson_type']){
          default: 
          case "0":
            $r['lesson_type_text'] = 'Основне заняття';
          break;
          case "1":
            $r['lesson_type_text'] = 'Додаткове заняття';
          break;
          case "2":
            $r['lesson_type_text'] = 'Подача авто на іспит';
          break;
        }
        if($r['lesson_total'] != '0'){
          $r['progress'] = 100-round($r['lesson_balance']/$r['lesson_total']*100);
        }else{
          $r['progress'] = 0;
        }
        $r['phone_p'] = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['phone'])))));
        $res .= $modx->parseChunk($tpl,$r);
      }
    }else{
      $res = $modx->getChunk($tpl_empty);
    }
  break;
  case "instructor_students_schedule":
    //З вчора з 23ої 
    $time = strtotime('yesterday 23:00');
    $to = date('Y-m-d H:i:s',$time);
    $q = $modx->db->query('SELECT *, ustr.id as reserv_id, isc.id as schedule_id, ustr.status as status, ustr.status_prove as status_prove FROM `modx_a_user_schedule_to_reserv` ustr
      LEFT JOIN `modx_a_instructor_schedule` isc ON isc.id = ustr.schedule_id 
      LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_id = ustr.client_id AND itu.type = isc.type
       WHERE isc.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND isc.full > "'.$modx->db->escape($to).'" AND ( ustr.status_prove = "0" OR ustr.status  != "3" )
       ORDER BY isc.full DESC, ustr.status ASC
    ');
    if($modx->db->getRecordCount($q) > 0){
      while($r = $modx->db->getRow($q)){
        switch($r['type']){
          default: 
          case "0":
            $r['lesson_type_text'] = 'Основне';
          break;
          case "1":
            $r['lesson_type_text'] = 'Додаткове';
          break;
          case "2":
            $r['lesson_type_text'] = 'Подача авто на іспит';
          break;
        }
        switch($r['status']){
          default: 
          case "2":
            $r['status_type_class'] = 's_warning';
            $r['status_type_text'] = 'Заброньовано';
          break;
          case "3":
            $r['status_type_class'] = 's_danger';
            $r['status_type_text'] = 'Скасовано';
          break;
        }
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
          $r['prove'] = 0;
        }else{
          $r['prove'] = 1;
          $r['start'] = $interval->days * 24 + $interval->h;
        }

        //З вчора з 23ої 
        $change_time = strtotime('today 00:00');
        $change_date = new DateTime(date('Y-m-d H:i:s',$change_time));

        if($date > $change_date){
          $r['change'] = 1;
        }else{
          $r['change'] = 0;
        }


        $r['user_phone_p'] = str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $r['user_phone'])))));
        $res .= $modx->parseChunk($tpl,$r);
      }
    }else{
      $res = $modx->getChunk($tpl_empty);
    }
  break;
  case "instructor_students":
    $q = $modx->db->query('SELECT *
    FROM `modx_a_instructor_to_user`
    WHERE instructor_name = "'.$modx->db->escape($_SESSION['webuser']['cabinet_syncname']).'" ORDER BY row_id ASC');
    while($r = $modx->db->getRow($q)){
      switch($r['type']){
        default: 
        case "0":
          $r['type_text'] = 'Основне';
        break;
        case "1":
          $r['type_text'] = 'Додаткове';
        break;
        case "2":
          $r['type_text'] = 'Подача авто на іспит';
        break;
      }
      $res .= $modx->parseChunk('tpl_instructor_students',$r);
    }
  break;
  case "instructor_zp":
    $q = $modx->db->query('SELECT * FROM `modx_a_instructor_to_zp` WHERE instructor_name = "'.$modx->db->escape($_SESSION['webuser']['cabinet_syncname']).'" LIMIT 1');
    if($modx->db->getRecordCount($q) > 0){
      $r = $modx->db->getRow($q);
      $res = $modx->parseChunk('tpl_instructor_zp', $r);
    }else{
      $res = '<span class="error_test_load">Данних не знайдено</span>';
    }
  break;
  case "instructor_setting_pickup":
    $q = $modx->db->query('SELECT * FROM `modx_a_instructor_settings_pickup` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ORDER BY id ASC');
    while($r = $modx->db->getRow($q)){
      $r['pickup_address'] = str_replace("'",'`',$r['pickup_address']);
      $res .= $modx->parseChunk('tpl_instructor_setting_pickup', $r);
    }

  break;
  case "instructor_setting":
    //modx_a_instructor_settings
    $q = $modx->db->query('SELECT * FROM `modx_a_instructor_settings` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ORDER BY day ASC, day_start ASC');
    while($r = $modx->db->getRow($q)){

      $r['option_pickup'] = '';
      $q_c = $modx->db->query('SELECT * FROM `modx_a_instructor_settings_pickup` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
      while($r_c = $modx->db->getRow($q_c)){
        $r_c['pickup_address'] = str_replace("'",'`',$r_c['pickup_address']);
        $r['option_pickup'] .= $modx->parseChunk('tpl_option', array('value' => $r_c['pickup_address'], 'name' => $r_c['pickup_address'], 'selected' => '', 'data' => ''));
      }

      $r['pickup_address'] = str_replace("'",'`',$r['pickup_address']);
      $res .= $modx->parseChunk('tpl_instructor_setting', $r);
    }
  break;
  case "instructor_linker":
    $school = $_SESSION['webuser']['school'];
    switch($type){
      case "school":
        if($school != "" AND $school != "0"){

          $school_base = $school;
          if($_SESSION['school'] != ''){
            $school = $_SESSION['school'];
          }

          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_content` WHERE id = "'.$modx->db->escape($school).'" LIMIT 1'));
          $tvres2 = $modx->getTemplateVar(
                      $idname  = 'img_ua',
                      $fields = '*',
                      $docid =  $r['id']
                      );
          $r['img'] = $tvres2['value'];
          $res = $modx->parseChunk('tpl_instructor_linker_school',$r);
          if($school_base == '446'){
            $school_ch = '';
            $q = $modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "121" ORDER BY menuindex ASC');
            while($r = $modx->db->getRow($q)){
              $r['selected'] = '';
              $r['data'] = '';
              $r['name'] = $r['pagetitle'];
              $r['value'] = $r['id'];
              $school_ch .= $modx->parseChunk('tpl_option',$r);
            }
            $modx->setPlaceholder('school_chooser', $modx->parseChunk('tpl_school_chooser',array('inner' => $school_ch, 'active' => $school)));
          }
        }else{
          $res = '<span class="error_test_load">Автошкола не вибрана</span>';
        }
      break;
      case "instructors":
        $school_base = $school;
        if($_SESSION['school'] != ''){
          $school = $_SESSION['school'];
        }
        $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE school = "'.$modx->db->escape($school).'" AND status = "1" ');
        while($r = $modx->db->getRow($q)){
          $name = array();
          $name[] = $r['lastname'];
          $name[] = $r['fullname'];
          $name[] = $r['patronymic'];
          $r['selected'] = '';
          $r['data'] = '';
          $r['name'] = implode(' ',$name);
          $r['value'] = $modx->config['site_url_b'].$modx->makeUrl('89').$r['instructor_url'].'/?lessons=';
          $res .= $modx->parseChunk('tpl_option',$r);

          $r['value'] = $r['user_id'];
          $instructor_list .= $modx->parseChunk('tpl_option',$r);
        }
        $modx->setPlaceholder('instructor_list',$instructor_list);
      break;
      case "products":

        $school_base = $school;
        if($_SESSION['school'] != ''){
          $school = $_SESSION['school'];
        }
        $q = $modx->db->query('SELECT * FROM `modx_a_products` WHERE product_to_school = "'.$modx->db->escape($school).'" AND product_visible = "1" AND product_to_instructor = "1" ORDER BY product_id ');
        while($r = $modx->db->getRow($q)){
          if($r['product_price_a'] != '0.00' AND $r['product_price'] != $r['product_price_a']){
            $price = $r['product_price_a'];
          }else{
            $price = $r['product_price'];
          }
          $name = array();
          $name[] = $r['product_name'];
          $r['selected'] = '';
          $r['data'] = 'data-product-count="'.$r['product_lesson'].'"';
          $r['name'] = $r['product_name'].' ('.$r['product_article'].') - '.$price.' грн.';
          $r['value'] = $r['product_id'];
          $res .= $modx->parseChunk('tpl_option',$r);
        }
      break;
      case "lessons":
        for($i = 1; $i <= 60; $i++){
          $r['selected'] = '';
          $r['data'] = '';
          $r['name'] = $i;
          $r['value'] = $i;
          $res .= $modx->parseChunk('tpl_option',$r);
        }
      break;
    }
  break;
  case "calendar_schedule_school":
    if($_SESSION['webuser']['cabinet_type'] == '2' OR $_SESSION['webuser']['cabinet_type'] == '3'){


        $school = $_SESSION['webuser']['school'];

        if($_SESSION['school'] != ''){
          $school_base = $school;
          $school = $_SESSION['school'];
        }
        
        if($ax_school){
          $school = $ax_school;
        }

        if($ax_date){
          $_GET['date'] = $ax_date;
        }
        if($ax_type){
          $_GET['type'] = $ax_type;
        }
        if($ax_instructor){
          $_GET['instructor'] = $ax_instructor;
        }


              //Вивід розкладу
              $modx->setPlaceholder('school_id', $school);

              if($_GET['date'] != ''){
                $date = strtotime($_GET['date']);
              }else{
                $date = time()+$modx->config['server_offset_time'];
              }

              switch($_GET['type']){
                case "month":
                  //вивід тип місяць

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');

                    //вивід календаря

                    $month = $start_date->format('m');
                    $year = $start_date->format('Y');


                    $headings = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
                    $calendar = '<div class="calendar">';
                    foreach ($headings as $heading) {
                        $calendar .= '<div class="calendar-day-head">' . $heading . '</div>';
                    }
                    $running_day = (date('N', mktime(0, 0, 0, $month, 1, $year)) % 7);
                    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                    $day_counter = 0;
                    for ($x = 1; $x < $running_day; $x++) {
                        $calendar .= '<div class="calendar-day-np"></div>';
                    }
                    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                        $calendar .= '<div class="calendar-day" data-calendar-date="'.$year.'-'.$month.'-'.str_pad($list_day, 2, "0", STR_PAD_LEFT).'">';
                        $calendar .= '<div class="day-number">' . $list_day . '</div>';
                        $calendar .= '</div>';
                        if (($running_day + $list_day - 1) % 7 == 0) {
                            $calendar .= '<div class="clearfix"></div>';
                        }
                        $day_counter++;
                    }
                    if (($running_day + $days_in_month - 1) % 7 != 0) {
                        for ($x = 0; $x < (7 - ($running_day + $days_in_month - 1) % 7); $x++) {
                            $calendar .= '<div class="calendar-day-np"></div>';
                        }
                    }
                    $calendar .= '<div class="clearfix"></div>';
                    $calendar .= '</div>';

                    $r['inner'] = $calendar;
                           

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatMYDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
                    $r['school'] = $school;
                    $res = $modx->parseChunk('tpl_manager_all_calendar_schedule_month',$r);

                break;
                case "day":
                default:
                  //вивід тип тиждень

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');
                  $end_date = clone $start_date;
                  $end_date->add(new DateInterval('P1D'));      
                  $end_day = $end_date->format('Y-m-d');
           

                  $ins = array();
                  $u = array();
                  $q_i = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE school = "'.$modx->db->escape($school).'" AND status = "1" AND user_id != "0" ORDER BY lastname ASC');
                  while($r_i = $modx->db->getRow($q_i)){
                    $ins[$r_i['user_id']] = $modx->parseChunk('tpl_ctw_header_m',$r_i);
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($r_i['user_id']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
     
                      $u[$r_i['user_id']][$rsch['full']] = $rsch;
                    }
                    


                  }

                  $idate = clone $start_date;
              
                  foreach($ins as $uid => $header){

                    $ctw_body_in = '';

                    for ($j = 6; $j < 23; $j++) {
                      $day = $idate->format('Y-m-d');
                      $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                      $full = $day.' '.$time;
                      $time = $j.':00';
                      $class = '';
                      $pickup_address = '';
                      if(isset($u[$uid][$full])){
                        $class = $shop->calendarStatus($u[$uid][$full]['status']);
                        $pickup_address = $u[$uid][$full]['pickup_address'];
                        if($u[$uid][$full]['offset'] != 0){
                          $time = $j.':'.$u[$uid][$full]['offset'];
                          $class .= ' offset_'.$u[$uid][$full]['offset'];
                        }
                      }
                      $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager_all', array('user_id' => $uid, 'time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                    }

                    $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body_manager_all', array('ctw_header_in' => $header, 'ctw_body_in' => $ctw_body_in));

                  }

                    
                




                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatFullDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                  $r['school'] = $school;
                  $res = $modx->parseChunk('tpl_manager_calendar_schedule_day',$r);

                break;
              }
              //кінець виводу
        
       






    }
  break;
  case "list_instructors_school":
    if($_SESSION['webuser']['cabinet_type'] == '2' OR $_SESSION['webuser']['cabinet_type'] == '3'){

        switch($_SESSION['webuser']['cabinet_type']){
          case "2":
            //manager
            $tpl = 'tpl_instructor_cabinet';
          break;
          case "3":
            //super
            $tpl = 'tpl_instructor_cabinet';
          break;
        }
        $school = $_SESSION['webuser']['school'];

        if($_SESSION['school'] != ''){
          $school_base = $school;
          $school = $_SESSION['school'];
        }
        
        if($ax_school){
          $school = $ax_school;
        }
        if($ax_search){
          $search_row = ' AND (i.phone LIKE "%'.$ax_search.'%" OR i.fullname LIKE "%'.$ax_search.'%" OR i.lastname LIKE "%'.$ax_search.'%") ';
        }
        $limit = 50;

        if($ax_page){
          $_GET['p'] = $ax_page;
        }

        $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
        if($page == -1){
          $page = 0;
        }
        
        $limitation = "LIMIT ".$page.", ".$limit;


        $archive_row = ' AND i.status = "1" ';
        if($ax_archive){
          if($ax_archive == 1){
            $archive_row = '';
          }
        }


    $q = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS * FROM `modx_a_instructors` i 
      WHERE 
       (i.school = "'.$modx->db->escape($school).'")
        '.$search_row.$archive_row.'
      ORDER BY i.id DESC
      '.$limitation.' ');



        $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
        while($r = $modx->db->getRow($q)){
         
          $r['instructor_url'] = $modx->makeUrl('89').$r['instructor_url'].'/';
          $r['type'] = $shop->getTrval('type',$r['type']);
          $r['transmission'] = $shop->getTrval('transmission',$r['transmission']);
          $res .= $modx->parseChunk($tpl,$r);
        }

        $paginate = $shop->getPaginateAX($pages['cnt'], $limit);
        $modx->setPlaceholder("paginate_list_instructors_school", $paginate);


    }
  break;
  case "list_order_school":
    if($_SESSION['webuser']['cabinet_type'] == '2' OR $_SESSION['webuser']['cabinet_type'] == '3'){

        switch($_SESSION['webuser']['cabinet_type']){
          case "2":
            //manager
            $tpl = 'tpl_order_school';
          break;
          case "3":
            //super
            $tpl = 'tpl_order_school_s';
          break;
        }
        $school = $_SESSION['webuser']['school'];

        if($_SESSION['school'] != ''){
          $school_base = $school;
          $school = $_SESSION['school'];
        }
        
        if($ax_school){
          $school = $ax_school;
        }

        if($ax_search){
          $search_row = ' AND (ituw.user_name LIKE "%'.$ax_search.'%" OR ituw.instructor_name LIKE "%'.$ax_search.'%" OR ituw.user_phone LIKE "%'.$ax_search.'%") ';
        }
        $archive_row = ' AND ituw.archived = "0" ';
        if($ax_archive){
          if($ax_archive == 1){
            $archive_row = '';
          }
        }
        if($ax_type){
          $_GET['type'] = $ax_type;
        }
        if($ax_instructor){
          $_GET['instructor'] = $ax_instructor;
        }
        $limit = 50;
        if($ax_page){
          $_GET['p'] = $ax_page;
        }
        $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
        if($page == -1){
          $page = 0;
        }
        $limitation = "LIMIT ".$page.", ".$limit;

        $q = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS *, ituw.id as id, ituw.user_id as user_id, ituw.type as type, ituw.order_school as order_school FROM `modx_a_instructor_to_user_web` ituw
          LEFT JOIN `modx_a_instructors` i ON i.id = ituw.instructor_id
          LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = ituw.user_id
          WHERE ituw.order_school = "'.$modx->db->escape($school).'" '.$search_row.$archive_row.' ORDER BY ituw.buy_date DESC '.$limitation);
        $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
        while($r = $modx->db->getRow($q)){
          switch($r['type']){
            default: 
            case "0":
              $r['type_text'] = 'Основне';
            break;
            case "1":
              $r['type_text'] = 'Додаткове';
            break;
            case "2":
              $r['type_text'] = 'Подача авто на іспит';
            break;
          }
          $r['user_phone_text'] = $r['user_phone'];
          if($ax_search){
            $pattern = '/' . preg_quote($ax_search, '/') . '/iu';
            $r['user_name'] = preg_replace($pattern, '<span class="highlight">$0</span>', $r['user_name']);
            $r['instructor_name'] = preg_replace($pattern, '<span class="highlight">$0</span>', $r['instructor_name']);
            $r['user_phone_text'] = preg_replace($pattern, '<span class="highlight">$0</span>', $r['user_phone_text']);
          }
          $r['order_date'] = date('d-m-Y H:i:s',$r['buy_date']);
          $res .= $modx->parseChunk($tpl,$r);
        }

        $paginate = $shop->getPaginateAX($pages['cnt'], $limit);
        $modx->setPlaceholder("paginate_list_order_school", $paginate);

    }
  break;
  case "list_schedule_school":
    if($_SESSION['webuser']['cabinet_type'] == '2' OR $_SESSION['webuser']['cabinet_type'] == '3'){

        switch($_SESSION['webuser']['cabinet_type']){
          case "2":
            //manager
            $tpl = 'tpl_list_schedule_school';
          break;
          case "3":
            //super
            $tpl = 'tpl_list_schedule_school_s';
          break;
        }
        $school = $_SESSION['webuser']['school'];

        if($_SESSION['school'] != ''){
          $school_base = $school;
          $school = $_SESSION['school'];
        }
        
        if($ax_school){
          $school = $ax_school;
        }
        if($ax_search){
          $search_row = ' AND (itug.user_name LIKE "%'.$ax_search.'%" OR itug.instructor_name LIKE "%'.$ax_search.'%" OR itug.user_phone LIKE "%'.$ax_search.'%") ';
        }
        $archive_row = ' AND itug.lesson_balance != "0" ';
        if($ax_archive){
          if($ax_archive == 1){
            $archive_row = '';
          }
        }

        if($ax_type){
          $_GET['type'] = $ax_type;
        }
        if($ax_instructor){
          $_GET['instructor'] = $ax_instructor;
        }



        $limit = 50;
        if($ax_page){
          $_GET['p'] = $ax_page;
        }
        $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
        if($page == -1){
          $page = 0;
        }
        
        $limitation = "LIMIT ".$page.", ".$limit;


        $q = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS *, itug.id as id, itug.user_id as user_id, itug.type as type, itug.order_school as order_school FROM `modx_a_instructor_to_user_g` itug 
          LEFT JOIN `modx_a_instructors` i ON i.id = itug.instructor_id
          LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = itug.user_id
          WHERE itug.order_school = "'.$modx->db->escape($school).'" '.$search_row.$archive_row.' ORDER BY itug.row_id DESC '.$limitation);
        $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
        while($r = $modx->db->getRow($q)){
          switch($r['type']){
            default: 
            case "0":
              $r['type_text'] = 'Основне';
            break;
            case "1":
              $r['type_text'] = 'Додаткове';
            break;
            case "2":
              $r['type_text'] = 'Подача авто на іспит';
            break;
          }
          $r['user_phone_text'] = $r['user_phone'];
          if($ax_search){
            $pattern = '/' . preg_quote($ax_search, '/') . '/iu';
            $r['user_name'] = preg_replace($pattern, '<span class="highlight">$0</span>', $r['user_name']);
            $r['instructor_name'] = preg_replace($pattern, '<span class="highlight">$0</span>', $r['instructor_name']);
            $r['user_phone_text'] = preg_replace($pattern, '<span class="highlight">$0</span>', $r['user_phone_text']);
          }
          $res .= $modx->parseChunk($tpl,$r);
        }
        $paginate = $shop->getPaginateAX($pages['cnt'], $limit);
        $modx->setPlaceholder("paginate_list_schedule_school", $paginate);
    }
  break;
  case "calendar_schedule":

    switch($_SESSION['webuser']['cabinet_type']){
      case "0":
      default:

        //Користувач
        if($ax_date){
          $_GET['date'] = $ax_date;
        }
        if($ax_type){
          $_GET['type'] = $ax_type;
        }
        if($ax_instructor){
          $_GET['instructor'] = $ax_instructor;
        }
        if($_GET['instructor'] == '' AND $_GET['instructor'] == '0'){
          // якщо не вибрано інструктора - пропуск
          $res = '<span class="error_test_load">Розклад не знайдено</span>';
        }else{


            //Перевірка чи є вибранний користувач інструктором
            $check = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($_GET['instructor']).'" AND cabinet_type = "1" LIMIT 1');
            if($modx->db->getRecordCount($check) == 0){
              //немає інструктора

              $res = '<span class="error_test_load">Розклад не знайдено</span>';

            }else{

              //Вивід розкладу
              $modx->setPlaceholder('instructor_id', $_GET['instructor']);
              $rch = $modx->db->getRow($check);
              $modx->setPlaceholder('instructor_name', $rch['fullname'].' '.$rch['lastname']);

              if($_GET['date'] != ''){
                $date = strtotime($_GET['date']);
              }else{
                $date = time()+$modx->config['server_offset_time'];
              }

              switch($_GET['type']){
                case "month":
                  //вивід тип місяць

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');

                    //вивід календаря

                    $month = $start_date->format('m');
                    $year = $start_date->format('Y');


                    $headings = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
                    $calendar = '<div class="calendar">';
                    foreach ($headings as $heading) {
                        $calendar .= '<div class="calendar-day-head">' . $heading . '</div>';
                    }
                    $running_day = (date('N', mktime(0, 0, 0, $month, 1, $year)) % 7);
                    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                    $day_counter = 0;
                    for ($x = 1; $x < $running_day; $x++) {
                        $calendar .= '<div class="calendar-day-np"></div>';
                    }
                    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                        $calendar .= '<div class="calendar-day" data-calendar-date="'.$year.'-'.$month.'-'.str_pad($list_day, 2, "0", STR_PAD_LEFT).'">';
                        $calendar .= '<div class="day-number">' . $list_day . '</div>';
                        $calendar .= '</div>';
                        if (($running_day + $list_day - 1) % 7 == 0) {
                            $calendar .= '<div class="clearfix"></div>';
                        }
                        $day_counter++;
                    }
                    if (($running_day + $days_in_month - 1) % 7 != 0) {
                        for ($x = 0; $x < (7 - ($running_day + $days_in_month - 1) % 7); $x++) {
                            $calendar .= '<div class="calendar-day-np"></div>';
                        }
                    }
                    $calendar .= '<div class="clearfix"></div>';
                    $calendar .= '</div>';

                    $r['inner'] = $calendar;
                           

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatMYDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_instructor_calendar_schedule_month',$r);

                break;
                case "week":
                default:
                  //вивід тип тиждень

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');
                    $end_date = clone $start_date;
                    $end_date->add(new DateInterval('P7D'));      
                    $end_day = $end_date->format('Y-m-d');
             
                    $u = array();
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
                      $u[$rsch['full']] = $rsch;
                    }

                    for ($i = 0; $i < 7; $i++) {
                      $idate = clone $start_date;
                      $idate->add(new DateInterval('P' . $i . 'D'));
                      $day_of_week = $idate->format('w');
                      $day_month = $idate->format('d.m.Y');
                      $full = $idate->format('Y-m-d');
                      if($full == $start_day){
                        $top_class = 'top_active';
                      }else{
                        $top_class = '';
                      }
                      $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                      $ctw_body_in = '';
                      for ($j = 6; $j < 23; $j++) {
                        $day = $idate->format('Y-m-d');
                        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                        $full = $day.' '.$time;
                        $time = $j.':00';
                        $class = '';
                        $pickup_address = '';
                        if(isset($u[$full])){
                          $class = $shop->calendarStatus($u[$full]['status']);
                          $pickup_address = $u[$full]['pickup_address'];
                          if($u[$full]['offset'] != 0){
                            $time = $j.':'.$u[$full]['offset'];
                            $class .= ' offset_'.$u[$full]['offset'];
                          }
                        }
                        $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_user', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                      }
                      $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                    }

                   // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatFullDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_instructor_calendar_schedule_week',$r);

                break;
                case "day":
                  //вивід тип день

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');
                  $end_date = clone $start_date;
                  $end_date->add(new DateInterval('P1D'));      
                  $end_day = $end_date->format('Y-m-d');
           
                  $u = array();
                  $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                  LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                  WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                  while($rsch = $modx->db->getRow($usch)){
                    $u[$rsch['full']] = $rsch;
                  }

                  for ($i = 0; $i < 1; $i++) {
                    $idate = clone $start_date;
                    $idate->add(new DateInterval('P' . $i . 'D'));
                    $day_of_week = $idate->format('w');
                    $day_month = $idate->format('d.m.Y');
                    $full = $idate->format('Y-m-d');
                    if($full == $start_day){
                      $top_class = 'top_active';
                    }else{
                      $top_class = '';
                    }
                    $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class, 'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                    $ctw_body_in = '';
                    for ($j = 6; $j < 23; $j++) {
                      $day = $idate->format('Y-m-d');
                      $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                      $full = $day.' '.$time;
                      $time = $j.':00';
                      $class = '';
                      $pickup_address = '';
                      if(isset($u[$full])){
                        $class = $shop->calendarStatus($u[$full]['status']);
                        $pickup_address = $u[$full]['pickup_address'];
                        if($u[$full]['offset'] != 0){
                          $time = $j.':'.$u[$full]['offset'];
                          $class .= ' offset_'.$u[$full]['offset'];
                        }
                      }
                      $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_user', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                    }
                    $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                  }

                 // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatFullDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                  $res = $modx->parseChunk('tpl_instructor_calendar_schedule_day',$r);
                break;
                case "list":
                  //вивід тип лист тиждень

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');
                    $end_date = clone $start_date;
                    $end_date->add(new DateInterval('P7D'));      
                    $end_day = $end_date->format('Y-m-d');
             
                    $u = array();
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
                      $u[$rsch['full']] = $rsch;
                    }

                    for ($i = 0; $i < 7; $i++) {
                      $idate = clone $start_date;
                      $idate->add(new DateInterval('P' . $i . 'D'));
                      $day_of_week = $idate->format('w');
                      $day_month = $idate->format('d.m.Y');
                      $full = $idate->format('Y-m-d');
                      if($full == $start_day){
                        $top_class = 'top_active';
                      }else{
                        $top_class = '';
                      }
                      $r['inner'] .= $modx->parseChunk('tpl_ctw_header_list', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                      $ctw_body_in = '';
                      for ($j = 6; $j < 23; $j++) {
                        $day = $idate->format('Y-m-d');
                        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                        $full = $day.' '.$time;
                        $time = $j.':00';
                        $class = '';
                        $pickup_address = '';
                        if(isset($u[$full])){
                          $class = $shop->calendarStatus($u[$full]['status']);
                          $pickup_address = $u[$full]['pickup_address'];
                          if($u[$full]['offset'] != 0){
                            $time = $j.':'.$u[$full]['offset'];
                            $class .= ' offset_'.$u[$full]['offset'];
                          }
                          $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_user', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                        }
                      }
                      $r['inner'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                    }

                   // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatFullDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_instructor_calendar_schedule_list',$r);

                break;
              }
              //кінець виводу
            }
          
        }


      break;
      case "1":
        if($ax_instructor != $_SESSION['webuser']['internalKey']){
          //Перегляд як
              //Користувач
                  if($ax_date){
                    $_GET['date'] = $ax_date;
                  }
                  if($ax_type){
                    $_GET['type'] = $ax_type;
                  }
                  if($ax_instructor){
                    $_GET['instructor'] = $ax_instructor;
                  }
                  if($_GET['instructor'] == '' AND $_GET['instructor'] == '0'){
                    // якщо не вибрано інструктора - пропуск
                    $res = '<span class="error_test_load">Розклад не знайдено</span>';
                  }else{


                      //Перевірка чи є вибранний користувач інструктором
                      $check = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($_GET['instructor']).'" AND cabinet_type = "1" LIMIT 1');
                      if($modx->db->getRecordCount($check) == 0){
                        //немає інструктора

                        $res = '<span class="error_test_load">Розклад не знайдено</span>';

                      }else{

                        //Вивід розкладу
                        $modx->setPlaceholder('instructor_id', $_GET['instructor']);
                        $rch = $modx->db->getRow($check);
                        $modx->setPlaceholder('instructor_name', $rch['fullname'].' '.$rch['lastname']);

                        if($_GET['date'] != ''){
                          $date = strtotime($_GET['date']);
                        }else{
                          $date = time()+$modx->config['server_offset_time'];
                        }

                        switch($_GET['type']){
                          case "month":
                            //вивід тип місяць

                              $start_date = new DateTime(date('Y-m-d',$date));
                              $start_day = $start_date->format('Y-m-d');

                              //вивід календаря

                              $month = $start_date->format('m');
                              $year = $start_date->format('Y');


                              $headings = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
                              $calendar = '<div class="calendar">';
                              foreach ($headings as $heading) {
                                  $calendar .= '<div class="calendar-day-head">' . $heading . '</div>';
                              }
                              $running_day = (date('N', mktime(0, 0, 0, $month, 1, $year)) % 7);
                              $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                              $day_counter = 0;
                              for ($x = 1; $x < $running_day; $x++) {
                                  $calendar .= '<div class="calendar-day-np"></div>';
                              }
                              for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                                  $calendar .= '<div class="calendar-day" data-calendar-date="'.$year.'-'.$month.'-'.str_pad($list_day, 2, "0", STR_PAD_LEFT).'">';
                                  $calendar .= '<div class="day-number">' . $list_day . '</div>';
                                  $calendar .= '</div>';
                                  if (($running_day + $list_day - 1) % 7 == 0) {
                                      $calendar .= '<div class="clearfix"></div>';
                                  }
                                  $day_counter++;
                              }
                              if (($running_day + $days_in_month - 1) % 7 != 0) {
                                  for ($x = 0; $x < (7 - ($running_day + $days_in_month - 1) % 7); $x++) {
                                      $calendar .= '<div class="calendar-day-np"></div>';
                                  }
                              }
                              $calendar .= '<div class="clearfix"></div>';
                              $calendar .= '</div>';

                              $r['inner'] = $calendar;
                                     

                              $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                              $r['today_date'] = $today_date->format('Y-m-d'); 
                              $r['today'] = $shop->formatMYDate($date);
                              $r['now'] = $start_day; 
                              $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                              $next_date = clone $start_date; 
                              $r['next'] = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');  
                              $prev_date = clone $start_date;
                              $r['prev'] = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
                              $res = $modx->parseChunk('tpl_instructor_calendar_schedule_month',$r);

                          break;
                          case "week":
                          default:
                            //вивід тип тиждень

                              $start_date = new DateTime(date('Y-m-d',$date));
                              $start_day = $start_date->format('Y-m-d');
                              $end_date = clone $start_date;
                              $end_date->add(new DateInterval('P7D'));      
                              $end_day = $end_date->format('Y-m-d');
                       
                              $u = array();
                              $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                              LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                              WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                              while($rsch = $modx->db->getRow($usch)){
                                $u[$rsch['full']] = $rsch;
                              }

                              for ($i = 0; $i < 7; $i++) {
                                $idate = clone $start_date;
                                $idate->add(new DateInterval('P' . $i . 'D'));
                                $day_of_week = $idate->format('w');
                                $day_month = $idate->format('d.m.Y');
                                $full = $idate->format('Y-m-d');
                                if($full == $start_day){
                                  $top_class = 'top_active';
                                }else{
                                  $top_class = '';
                                }
                                $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                                $ctw_body_in = '';
                                for ($j = 6; $j < 23; $j++) {
                                  $day = $idate->format('Y-m-d');
                                  $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                                  $full = $day.' '.$time;
                                  $time = $j.':00';
                                  $class = '';
                                  $pickup_address = '';
                                  if(isset($u[$full])){
                                    $class = $shop->calendarStatus($u[$full]['status']);
                                    $pickup_address = $u[$full]['pickup_address'];
                                    if($u[$full]['offset'] != 0){
                                      $time = $j.':'.$u[$full]['offset'];
                                      $class .= ' offset_'.$u[$full]['offset'];
                                    }
                                  }
                                  $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_user', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                                }
                                $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                              }

                             // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                              $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                              $r['today_date'] = $today_date->format('Y-m-d'); 
                              $r['today'] = $shop->formatFullDate($date);
                              $r['now'] = $start_day; 
                              $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                              $next_date = clone $start_date; 
                              $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                              $prev_date = clone $start_date;
                              $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                              $res = $modx->parseChunk('tpl_instructor_calendar_schedule_week',$r);

                          break;
                          case "day":
                            //вивід тип день

                            $start_date = new DateTime(date('Y-m-d',$date));
                            $start_day = $start_date->format('Y-m-d');
                            $end_date = clone $start_date;
                            $end_date->add(new DateInterval('P1D'));      
                            $end_day = $end_date->format('Y-m-d');
                     
                            $u = array();
                            $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                            LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                            WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                            while($rsch = $modx->db->getRow($usch)){
                              $u[$rsch['full']] = $rsch;
                            }

                            for ($i = 0; $i < 1; $i++) {
                              $idate = clone $start_date;
                              $idate->add(new DateInterval('P' . $i . 'D'));
                              $day_of_week = $idate->format('w');
                              $day_month = $idate->format('d.m.Y');
                              $full = $idate->format('Y-m-d');
                              if($full == $start_day){
                                $top_class = 'top_active';
                              }else{
                                $top_class = '';
                              }
                              $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class, 'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                              $ctw_body_in = '';
                              for ($j = 6; $j < 23; $j++) {
                                $day = $idate->format('Y-m-d');
                                $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                                $full = $day.' '.$time;
                                $time = $j.':00';
                                $class = '';
                                $pickup_address = '';
                                if(isset($u[$full])){
                                  $class = $shop->calendarStatus($u[$full]['status']);
                                  $pickup_address = $u[$full]['pickup_address'];
                                  if($u[$full]['offset'] != 0){
                                    $time = $j.':'.$u[$full]['offset'];
                                    $class .= ' offset_'.$u[$full]['offset'];
                                  }
                                }
                                $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_user', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                              }
                              $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                            }

                           // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                            $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                            $r['today_date'] = $today_date->format('Y-m-d'); 
                            $r['today'] = $shop->formatFullDate($date);
                            $r['now'] = $start_day; 
                            $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                            $next_date = clone $start_date; 
                            $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                            $prev_date = clone $start_date;
                            $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                            $res = $modx->parseChunk('tpl_instructor_calendar_schedule_day',$r);
                          break;
                          case "list":
                            //вивід тип лист тиждень

                              $start_date = new DateTime(date('Y-m-d',$date));
                              $start_day = $start_date->format('Y-m-d');
                              $end_date = clone $start_date;
                              $end_date->add(new DateInterval('P7D'));      
                              $end_day = $end_date->format('Y-m-d');
                       
                              $u = array();
                              $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                              LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                              WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                              while($rsch = $modx->db->getRow($usch)){
                                $u[$rsch['full']] = $rsch;
                              }

                              for ($i = 0; $i < 7; $i++) {
                                $idate = clone $start_date;
                                $idate->add(new DateInterval('P' . $i . 'D'));
                                $day_of_week = $idate->format('w');
                                $day_month = $idate->format('d.m.Y');
                                $full = $idate->format('Y-m-d');
                                if($full == $start_day){
                                  $top_class = 'top_active';
                                }else{
                                  $top_class = '';
                                }
                                $r['inner'] .= $modx->parseChunk('tpl_ctw_header_list', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                                $ctw_body_in = '';
                                for ($j = 6; $j < 23; $j++) {
                                  $day = $idate->format('Y-m-d');
                                  $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                                  $full = $day.' '.$time;
                                  $time = $j.':00';
                                  $class = '';
                                  $pickup_address = '';
                                  if(isset($u[$full])){
                                    $class = $shop->calendarStatus($u[$full]['status']);
                                    $pickup_address = $u[$full]['pickup_address'];

                                    if($u[$full]['offset'] != 0){
                                      $time = $j.':'.$u[$full]['offset'];
                                      $class .= ' offset_'.$u[$full]['offset'];
                                    }
                                    $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_user', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                                  }
                                }
                                $r['inner'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                              }

                             // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                              $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                              $r['today_date'] = $today_date->format('Y-m-d'); 
                              $r['today'] = $shop->formatFullDate($date);
                              $r['now'] = $start_day; 
                              $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                              $next_date = clone $start_date; 
                              $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                              $prev_date = clone $start_date;
                              $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                              $res = $modx->parseChunk('tpl_instructor_calendar_schedule_list',$r);

                          break;
                        }
                        //кінець виводу
                      }
                    
                  }


        }else{




            //Інструктор
            if($ax_date){
              $_GET['date'] = $ax_date;
            }
            if($ax_type){
              $_GET['type'] = $ax_type;
            }

            if($_GET['date'] != ''){
              $date = strtotime($_GET['date']);
            }else{
              $date = time()+$modx->config['server_offset_time'];
            }

            switch($_GET['type']){
              case "month":
                //вивід тип місяць

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');

                  //вивід календаря

                  $month = $start_date->format('m');
                  $year = $start_date->format('Y');


                  $headings = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
                  $calendar = '<div class="calendar">';
                  foreach ($headings as $heading) {
                      $calendar .= '<div class="calendar-day-head">' . $heading . '</div>';
                  }
                  $running_day = (date('N', mktime(0, 0, 0, $month, 1, $year)) % 7);
                  if($running_day == '0'){
                    $running_day = 7;
                  }
                  $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                  $day_counter = 0;
                  for ($x = 1; $x < $running_day; $x++) {
                      $calendar .= '<div class="calendar-day-np"></div>';
                  }
                  for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                      $calendar .= '<div class="calendar-day" data-calendar-date="'.$year.'-'.$month.'-'.str_pad($list_day, 2, "0", STR_PAD_LEFT).'">';
                      $calendar .= '<div class="day-number">' . $list_day . '</div>';
                      $calendar .= '</div>';
                      if (($running_day + $list_day - 1) % 7 == 0) {
                          $calendar .= '<div class="clearfix"></div>';
                      }
                      $day_counter++;
                  }
                  if (($running_day + $days_in_month - 1) % 7 != 0) {
                      for ($x = 0; $x < (7 - ($running_day + $days_in_month - 1) % 7); $x++) {
                          $calendar .= '<div class="calendar-day-np"></div>';
                      }
                  }
                  $calendar .= '<div class="clearfix"></div>';
                  $calendar .= '</div>';

                  $r['inner'] = $calendar;
                         

                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatMYDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
                  $res = $modx->parseChunk('tpl_instructor_calendar_schedule_month',$r);

              break;
              case "week":
              default:
                //вивід тип тиждень

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');
                  $end_date = clone $start_date;
                  $end_date->add(new DateInterval('P7D'));      
                  $end_day = $end_date->format('Y-m-d');
           
                  $u = array();
                  $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                  LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                  LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_name = str.client
                  WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
                  while($rsch = $modx->db->getRow($usch)){
                    $u[$rsch['full']] = $rsch;
                  }

                  for ($i = 0; $i < 7; $i++) {
                    $idate = clone $start_date;
                    $idate->add(new DateInterval('P' . $i . 'D'));
                    $day_of_week = $idate->format('w');
                    $day_month = $idate->format('d.m.Y');
                    $full = $idate->format('Y-m-d');
                    if($full == $start_day){
                      $top_class = 'top_active';
                    }else{
                      $top_class = '';
                    }
                    $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                    $ctw_body_in = '';
                    for ($j = 6; $j < 23; $j++) {
                      $day = $idate->format('Y-m-d');
                      $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                      $full = $day.' '.$time;
                      $time = $j.':00';
                      $class = '';
                      $pickup_address = '';
                      $user_name = '';
                      $user_phone = '';
                      if(isset($u[$full])){
                        $class = $shop->calendarStatus($u[$full]['status']);
                        $pickup_address = $u[$full]['pickup_address'];
                        $user_phone = $u[$full]['user_phone'];
                        $user_name = $u[$full]['client'];
                        if($u[$full]['offset'] != 0){
                          $time = $j.':'.$u[$full]['offset'];
                          $class .= ' offset_'.$u[$full]['offset'];
                        }
                      }
                      $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in', array('time' => $time, 'user_name' => $user_name, 'user_phone' => $user_phone, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                    }
                    $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                  }

                 // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatFullDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                  $res = $modx->parseChunk('tpl_instructor_calendar_schedule_week',$r);

              break;
              case "day":
                //вивід тип день

                $start_date = new DateTime(date('Y-m-d',$date));
                $start_day = $start_date->format('Y-m-d');
                $end_date = clone $start_date;
                $end_date->add(new DateInterval('P1D'));      
                $end_day = $end_date->format('Y-m-d');
         
                $u = array();
                $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_name = str.client
                WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
                while($rsch = $modx->db->getRow($usch)){
                  $u[$rsch['full']] = $rsch;
                }

                for ($i = 0; $i < 1; $i++) {
                  $idate = clone $start_date;
                  $idate->add(new DateInterval('P' . $i . 'D'));
                  $day_of_week = $idate->format('w');
                  $day_month = $idate->format('d.m.Y');
                  $full = $idate->format('Y-m-d');
                  if($full == $start_day){
                    $top_class = 'top_active';
                  }else{
                    $top_class = '';
                  }
                  $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header', array('top_class' => $top_class, 'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                  $ctw_body_in = '';
                  for ($j = 6; $j < 23; $j++) {
                    $day = $idate->format('Y-m-d');
                    $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                    $full = $day.' '.$time;
                    $time = $j.':00';
                    $class = '';
                    $pickup_address = '';
                    $user_phone = '';
                    $user_name = '';
                    if(isset($u[$full])){
                      $class = $shop->calendarStatus($u[$full]['status']);
                      $pickup_address = $u[$full]['pickup_address'];
                      $user_phone = $u[$full]['user_phone'];
                      $user_name = $u[$full]['client'];
                      if($u[$full]['offset'] != 0){
                        $time = $j.':'.$u[$full]['offset'];
                        $class .= ' offset_'.$u[$full]['offset'];
                      }
                    }
                    $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_instructor', array('time' => $time, 'user_name' => $user_name, 'user_phone' => $user_phone, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                  }
                  $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                }

               // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                $r['today_date'] = $today_date->format('Y-m-d'); 
                $r['today'] = $shop->formatFullDate($date);
                $r['now'] = $start_day; 
                $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                $next_date = clone $start_date; 
                $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                $prev_date = clone $start_date;
                $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                $res = $modx->parseChunk('tpl_instructor_calendar_schedule_day',$r);
              break;
              case "list":
                //вивід тип лист тиждень

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');
                  $end_date = clone $start_date;
                  $end_date->add(new DateInterval('P7D'));      
                  $end_day = $end_date->format('Y-m-d');
           
                  $u = array();
                  $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                  LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                  LEFT JOIN `modx_a_instructor_to_user` itu ON itu.user_name = str.client
                  WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
                  while($rsch = $modx->db->getRow($usch)){
                    $u[$rsch['full']] = $rsch;
                  }

                  for ($i = 0; $i < 7; $i++) {
                    $idate = clone $start_date;
                    $idate->add(new DateInterval('P' . $i . 'D'));
                    $day_of_week = $idate->format('w');
                    $day_month = $idate->format('d.m.Y');
                    $full = $idate->format('Y-m-d');
                    if($full == $start_day){
                      $top_class = 'top_active';
                    }else{
                      $top_class = '';
                    }
                    $r['inner'] .= $modx->parseChunk('tpl_ctw_header_list', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                    $ctw_body_in = '';
                    for ($j = 6; $j < 23; $j++) {
                      $day = $idate->format('Y-m-d');
                      $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                      $full = $day.' '.$time;
                      $time = $j.':00';
                      $class = '';
                      $pickup_address = '';
                      $user_phone = '';
                      $user_name = '';
                      if(isset($u[$full])){
                        $class = $shop->calendarStatus($u[$full]['status']);
                        $pickup_address = $u[$full]['pickup_address'];
                        $user_phone = $u[$full]['user_phone'];
                        $user_name = $u[$full]['client'];                        
                        if($u[$full]['offset'] != 0){
                          $time = $j.':'.$u[$full]['offset'];
                          $class .= ' offset_'.$u[$full]['offset'];
                        }
                        $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_instructor', array('time' => $time, 'user_name' => $user_name, 'user_phone' => $user_phone, 'pickup_address' => $pickup_address, 'full' => $full, 'class' => $class));
                      }
                    }
                    $r['inner'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                  }

                 // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatFullDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                  $res = $modx->parseChunk('tpl_instructor_calendar_schedule_list',$r);

              break;
            }

  
        }        

      break;
      case "2":
        //Менеджер

        if($ax_date){
          $_GET['date'] = $ax_date;
        }
        if($ax_type){
          $_GET['type'] = $ax_type;
        }
        if($ax_instructor){
          $_GET['instructor'] = $ax_instructor;
        }
        if($_GET['instructor'] == '' AND $_GET['instructor'] == '0'){
          // якщо не вибрано інструктора - пропуск
          $res = '<span class="error_test_load">Розклад не знайдено</span>';
        }else{


            //Перевірка чи є вибранний користувач інструктором
            $check = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($_GET['instructor']).'" AND cabinet_type = "1" LIMIT 1');
            if($modx->db->getRecordCount($check) == 0){
              //немає інструктора

              $res = '<span class="error_test_load">Розклад не знайдено</span>';

            }else{

              //Вивід розкладу
              $modx->setPlaceholder('instructor_id', $_GET['instructor']);
              $rch = $modx->db->getRow($check);
              $modx->setPlaceholder('instructor_name', $rch['fullname'].' '.$rch['lastname']);

              if($_GET['date'] != ''){
                $date = strtotime($_GET['date']);
              }else{
                $date = time()+$modx->config['server_offset_time'];
              }

              switch($_GET['type']){
                case "month":
                  //вивід тип місяць

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');

                    //вивід календаря

                    $month = $start_date->format('m');
                    $year = $start_date->format('Y');


                    $headings = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
                    $calendar = '<div class="calendar">';
                    foreach ($headings as $heading) {
                        $calendar .= '<div class="calendar-day-head">' . $heading . '</div>';
                    }
                    $running_day = (date('N', mktime(0, 0, 0, $month, 1, $year)) % 7);
                    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                    $day_counter = 0;
                    for ($x = 1; $x < $running_day; $x++) {
                        $calendar .= '<div class="calendar-day-np"></div>';
                    }
                    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                        $calendar .= '<div class="calendar-day" data-calendar-date="'.$year.'-'.$month.'-'.str_pad($list_day, 2, "0", STR_PAD_LEFT).'">';
                        $calendar .= '<div class="day-number">' . $list_day . '</div>';
                        $calendar .= '</div>';
                        if (($running_day + $list_day - 1) % 7 == 0) {
                            $calendar .= '<div class="clearfix"></div>';
                        }
                        $day_counter++;
                    }
                    if (($running_day + $days_in_month - 1) % 7 != 0) {
                        for ($x = 0; $x < (7 - ($running_day + $days_in_month - 1) % 7); $x++) {
                            $calendar .= '<div class="calendar-day-np"></div>';
                        }
                    }
                    $calendar .= '<div class="clearfix"></div>';
                    $calendar .= '</div>';

                    $r['inner'] = $calendar;
                           


                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatMYDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_manager_single_calendar_schedule_month',$r);

                break;
                case "week":
                default:
                  //вивід тип тиждень

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');
                    $end_date = clone $start_date;
                    $end_date->add(new DateInterval('P7D'));      
                    $end_day = $end_date->format('Y-m-d');
             
                    $u = array();
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
                      $u[$rsch['full']] = $rsch;
                    }

                    for ($i = 0; $i < 7; $i++) {
                      $idate = clone $start_date;
                      $idate->add(new DateInterval('P' . $i . 'D'));
                      $day_of_week = $idate->format('w');
                      $day_month = $idate->format('d.m.Y');
                      $full = $idate->format('Y-m-d');
                      if($full == $start_day){
                        $top_class = 'top_active';
                      }else{
                        $top_class = '';
                      }
                      $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                      $ctw_body_in = '';
                      for ($j = 6; $j < 23; $j++) {
                        $day = $idate->format('Y-m-d');
                        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                        $full = $day.' '.$time;
                        $time = $j.':00';
                        $class = '';
                        $pickup_address = '';
                        if(isset($u[$full])){
                          $class = $shop->calendarStatus($u[$full]['status']);
                          $pickup_address = $u[$full]['pickup_address'];                            
                          if($u[$full]['offset'] != 0){
                            $time = $j.':'.$u[$full]['offset'];
                            $class .= ' offset_'.$u[$full]['offset'];
                          }
                        }
                        $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'user_id' => $_GET['instructor'], 'class' => $class));
                      }
                      $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                    }


                   // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatFullDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_manager_single_calendar_schedule_week',$r);

                break;
                case "day":
                  //вивід тип день

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');
                  $end_date = clone $start_date;
                  $end_date->add(new DateInterval('P1D'));      
                  $end_day = $end_date->format('Y-m-d');
           
                  $u = array();
                  $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                  LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                  WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                  while($rsch = $modx->db->getRow($usch)){
                    $u[$rsch['full']] = $rsch;
                  }

                  for ($i = 0; $i < 1; $i++) {
                    $idate = clone $start_date;
                    $idate->add(new DateInterval('P' . $i . 'D'));
                    $day_of_week = $idate->format('w');
                    $day_month = $idate->format('d.m.Y');
                    $full = $idate->format('Y-m-d');
                    if($full == $start_day){
                      $top_class = 'top_active';
                    }else{
                      $top_class = '';
                    }
                    $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class, 'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                    $ctw_body_in = '';
                    for ($j = 6; $j < 23; $j++) {
                      $day = $idate->format('Y-m-d');
                      $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                      $full = $day.' '.$time;
                      $time = $j.':00';
                      $class = '';
                      $pickup_address = '';
                      if(isset($u[$full])){
                        $class = $shop->calendarStatus($u[$full]['status']);
                        $pickup_address = $u[$full]['pickup_address'];                            
                        if($u[$full]['offset'] != 0){
                          $time = $j.':'.$u[$full]['offset'];
                          $class .= ' offset_'.$u[$full]['offset'];
                        }
                      }
                      $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'user_id' => $_GET['instructor'], 'class' => $class));
                    }
                    $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                  }

                 // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatFullDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                  $res = $modx->parseChunk('tpl_instructor_calendar_schedule_day',$r);
                break;
                case "list":
                  //вивід тип лист тиждень

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');
                    $end_date = clone $start_date;
                    $end_date->add(new DateInterval('P7D'));      
                    $end_day = $end_date->format('Y-m-d');
             
                    $u = array();
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
                      $u[$rsch['full']] = $rsch;
                    }

                    for ($i = 0; $i < 7; $i++) {
                      $idate = clone $start_date;
                      $idate->add(new DateInterval('P' . $i . 'D'));
                      $day_of_week = $idate->format('w');
                      $day_month = $idate->format('d.m.Y');
                      $full = $idate->format('Y-m-d');
                      if($full == $start_day){
                        $top_class = 'top_active';
                      }else{
                        $top_class = '';
                      }
                      $r['inner'] .= $modx->parseChunk('tpl_ctw_header_list', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                      $ctw_body_in = '';
                      for ($j = 6; $j < 23; $j++) {
                        $day = $idate->format('Y-m-d');
                        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                        $full = $day.' '.$time;
                        $time = $j.':00';
                        $class = '';
                        $pickup_address = '';
                        if(isset($u[$full])){
                          $class = $shop->calendarStatus($u[$full]['status']);
                          $pickup_address = $u[$full]['pickup_address'];                            
                          if($u[$full]['offset'] != 0){
                            $time = $j.':'.$u[$full]['offset'];
                            $class .= ' offset_'.$u[$full]['offset'];
                          }
                          $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'user_id' => $_GET['instructor'], 'class' => $class));
                        }
                      }
                      $r['inner'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                    }

                   // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatFullDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_instructor_calendar_schedule_list',$r);

                break;
              }
              //кінець виводу
            }
          
        }
      break;
      case "3":
        //Супер менеджер

        if($ax_date){
          $_GET['date'] = $ax_date;
        }
        if($ax_type){
          $_GET['type'] = $ax_type;
        }
        if($ax_instructor){
          $_GET['instructor'] = $ax_instructor;
        }
        if($_GET['instructor'] == '' AND $_GET['instructor'] == '0'){
          // якщо не вибрано інструктора - пропуск
          $res = '<span class="error_test_load">Розклад не знайдено</span>';
        }else{


            //Перевірка чи є вибранний користувач інструктором
            $check = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE internalKey = "'.$modx->db->escape($_GET['instructor']).'" AND cabinet_type = "1" LIMIT 1');
            if($modx->db->getRecordCount($check) == 0){
              //немає інструктора

              $res = '<span class="error_test_load">Розклад не знайдено</span>';

            }else{

              //Вивід розкладу
              $modx->setPlaceholder('instructor_id', $_GET['instructor']);
              $rch = $modx->db->getRow($check);
              $modx->setPlaceholder('instructor_name', $rch['fullname'].' '.$rch['lastname']);

              if($_GET['date'] != ''){
                $date = strtotime($_GET['date']);
              }else{
                $date = time()+$modx->config['server_offset_time'];
              }

              switch($_GET['type']){
                case "month":
                  //вивід тип місяць

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');

                    //вивід календаря

                    $month = $start_date->format('m');
                    $year = $start_date->format('Y');


                    $headings = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
                    $calendar = '<div class="calendar">';
                    foreach ($headings as $heading) {
                        $calendar .= '<div class="calendar-day-head">' . $heading . '</div>';
                    }
                    $running_day = (date('N', mktime(0, 0, 0, $month, 1, $year)) % 7);
                    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
                    $day_counter = 0;
                    for ($x = 1; $x < $running_day; $x++) {
                        $calendar .= '<div class="calendar-day-np"></div>';
                    }
                    for ($list_day = 1; $list_day <= $days_in_month; $list_day++) {
                        $calendar .= '<div class="calendar-day" data-calendar-date="'.$year.'-'.$month.'-'.str_pad($list_day, 2, "0", STR_PAD_LEFT).'">';
                        $calendar .= '<div class="day-number">' . $list_day . '</div>';
                        $calendar .= '</div>';
                        if (($running_day + $list_day - 1) % 7 == 0) {
                            $calendar .= '<div class="clearfix"></div>';
                        }
                        $day_counter++;
                    }
                    if (($running_day + $days_in_month - 1) % 7 != 0) {
                        for ($x = 0; $x < (7 - ($running_day + $days_in_month - 1) % 7); $x++) {
                            $calendar .= '<div class="calendar-day-np"></div>';
                        }
                    }
                    $calendar .= '<div class="clearfix"></div>';
                    $calendar .= '</div>';

                    $r['inner'] = $calendar;
                           

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatMYDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1M'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1M'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_manager_single_calendar_schedule_month',$r);

                break;
                case "week":
                default:
                  //вивід тип тиждень

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');
                    $end_date = clone $start_date;
                    $end_date->add(new DateInterval('P7D'));      
                    $end_day = $end_date->format('Y-m-d');
             
                    $u = array();
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
                      $u[$rsch['full']] = $rsch;
                    }

                    for ($i = 0; $i < 7; $i++) {
                      $idate = clone $start_date;
                      $idate->add(new DateInterval('P' . $i . 'D'));
                      $day_of_week = $idate->format('w');
                      $day_month = $idate->format('d.m.Y');
                      $full = $idate->format('Y-m-d');
                      if($full == $start_day){
                        $top_class = 'top_active';
                      }else{
                        $top_class = '';
                      }
                      $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                      $ctw_body_in = '';
                      for ($j = 6; $j < 23; $j++) {
                        $day = $idate->format('Y-m-d');
                        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                        $full = $day.' '.$time;
                        $time = $j.':00';
                        $class = '';
                        $pickup_address = '';
                        if(isset($u[$full])){
                          $class = $shop->calendarStatus($u[$full]['status']);
                          $pickup_address = $u[$full]['pickup_address'];                            
                          if($u[$full]['offset'] != 0){
                            $time = $j.':'.$u[$full]['offset'];
                            $class .= ' offset_'.$u[$full]['offset'];
                          }
                        }
                        $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'user_id' => $_GET['instructor'], 'class' => $class));
                      }
                      $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                    }

                   // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatFullDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_manager_single_calendar_schedule_week',$r);

                break;
                case "day":
                  //вивід тип день

                  $start_date = new DateTime(date('Y-m-d',$date));
                  $start_day = $start_date->format('Y-m-d');
                  $end_date = clone $start_date;
                  $end_date->add(new DateInterval('P1D'));      
                  $end_day = $end_date->format('Y-m-d');
           
                  $u = array();
                  $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                  LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                  WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                  while($rsch = $modx->db->getRow($usch)){
                    $u[$rsch['full']] = $rsch;
                  }

                  for ($i = 0; $i < 1; $i++) {
                    $idate = clone $start_date;
                    $idate->add(new DateInterval('P' . $i . 'D'));
                    $day_of_week = $idate->format('w');
                    $day_month = $idate->format('d.m.Y');
                    $full = $idate->format('Y-m-d');
                    if($full == $start_day){
                      $top_class = 'top_active';
                    }else{
                      $top_class = '';
                    }
                    $r['ctw_header'] .= $modx->parseChunk('tpl_ctw_header_user', array('top_class' => $top_class, 'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                    $ctw_body_in = '';
                    for ($j = 6; $j < 23; $j++) {
                      $day = $idate->format('Y-m-d');
                      $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                      $full = $day.' '.$time;
                      $time = $j.':00';
                      $class = '';
                      $pickup_address = '';
                      if(isset($u[$full])){
                        $class = $shop->calendarStatus($u[$full]['status']);
                        $pickup_address = $u[$full]['pickup_address'];                            
                        if($u[$full]['offset'] != 0){
                          $time = $j.':'.$u[$full]['offset'];
                          $class .= ' offset_'.$u[$full]['offset'];
                        }
                      }
                      $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'user_id' => $_GET['instructor'], 'class' => $class));
                    }
                    $r['ctw_body'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                  }

                 // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                  $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                  $r['today_date'] = $today_date->format('Y-m-d'); 
                  $r['today'] = $shop->formatFullDate($date);
                  $r['now'] = $start_day; 
                  $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                  $next_date = clone $start_date; 
                  $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                  $prev_date = clone $start_date;
                  $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                  $res = $modx->parseChunk('tpl_instructor_calendar_schedule_day',$r);
                break;
                case "list":
                  //вивід тип лист тиждень

                    $start_date = new DateTime(date('Y-m-d',$date));
                    $start_day = $start_date->format('Y-m-d');
                    $end_date = clone $start_date;
                    $end_date->add(new DateInterval('P7D'));      
                    $end_day = $end_date->format('Y-m-d');
             
                    $u = array();
                    $usch = $modx->db->query('SELECT * FROM `modx_a_instructor_schedule` isc
                    LEFT JOIN `modx_a_instructor_schedule_to_reserv` str ON str.schedule_id = isc.id 
                    WHERE isc.day >= "'.$modx->db->escape($start_day).'" AND isc.day <= "'.$modx->db->escape($end_day).'" AND isc.user_id = "'.$modx->db->escape($_GET['instructor']).'" ');
                    while($rsch = $modx->db->getRow($usch)){
                      $u[$rsch['full']] = $rsch;
                    }

                    for ($i = 0; $i < 7; $i++) {
                      $idate = clone $start_date;
                      $idate->add(new DateInterval('P' . $i . 'D'));
                      $day_of_week = $idate->format('w');
                      $day_month = $idate->format('d.m.Y');
                      $full = $idate->format('Y-m-d');
                      if($full == $start_day){
                        $top_class = 'top_active';
                      }else{
                        $top_class = '';
                      }
                      $r['inner'] .= $modx->parseChunk('tpl_ctw_header_list', array('top_class' => $top_class,'day_n' => $shop->formatWeekShort($day_of_week), 'full' => $full, 'day_w' => $day_of_week,  'date' => $day_month));
                      $ctw_body_in = '';
                      for ($j = 6; $j < 23; $j++) {
                        $day = $idate->format('Y-m-d');
                        $time = str_pad($j, 2, "0", STR_PAD_LEFT).':00:00';
                        $full = $day.' '.$time;
                        $time = $j.':00';
                        $class = '';
                        $pickup_address = '';
                        if(isset($u[$full])){
                          $class = $shop->calendarStatus($u[$full]['status']);
                          $pickup_address = $u[$full]['pickup_address'];                            
                          if($u[$full]['offset'] != 0){
                            $time = $j.':'.$u[$full]['offset'];
                            $class .= ' offset_'.$u[$full]['offset'];
                          }
                          $ctw_body_in .= $modx->parseChunk('tpl_ctw_body_in_manager', array('time' => $time, 'pickup_address' => $pickup_address, 'full' => $full, 'user_id' => $_GET['instructor'], 'class' => $class));
                        }
                      }
                      $r['inner'] .= $modx->parseChunk('tpl_ctw_body', array('top_class' => $top_class, 'ctw_body_in' => $ctw_body_in, 'day_w' => $day_of_week));
                    }

                   // $r['schedule'] = $modx->parseChunk('tpl_schedule_day', $r2);

                    $today_date = new DateTime(date('Y-m-d',time()+$modx->config['server_offset_time']));
                    $r['today_date'] = $today_date->format('Y-m-d'); 
                    $r['today'] = $shop->formatFullDate($date);
                    $r['now'] = $start_day; 
                    $r['url'] = $modx->makeUrl($modx->documentIdentifier);
                    $next_date = clone $start_date; 
                    $r['next'] = $next_date->add(new DateInterval('P1D'))->format('Y-m-d');  
                    $prev_date = clone $start_date;
                    $r['prev'] = $prev_date->sub(new DateInterval('P1D'))->format('Y-m-d');
                    $res = $modx->parseChunk('tpl_instructor_calendar_schedule_list',$r);

                break;
              }
              //кінець виводу
            }
          
        }
      break;
    }
  break;
  case "my_statistics_new":
    $user_id = $_SESSION['webuser']['internalKey'];
    $user_type = $_SESSION['webuser']['user_type'];
    if($user_id != ''){
      if($user_type == '1'){
        $r_c = $modx->db->getRow($modx->db->query('SELECT count(question_id) as wrong FROM `new_question_2_user` WHERE user_id = "'.$modx->db->escape($user_id).'" LIMIT 1'));
        $r_f = $modx->db->getRow($modx->db->query('SELECT count(question_id) as favorite FROM `new_question_2_user_favorite` WHERE user_id = "'.$modx->db->escape($user_id).'" LIMIT 1'));
        $res = $modx->parseChunk('tpl_my_statistics_new', array( 'wrong' => $r_c['wrong'], 'favorite' => $r_f['favorite'] ));
      }else{
        $res = $modx->getChunk('tpl_my_statistics_standart_new');
      }
    }
  break;
  case "my_statistics":
    $user_id = $_SESSION['webuser']['internalKey'];
    $user_type = $_SESSION['webuser']['user_type'];
    if($user_id != ''){
      if($user_type == '1'){
        $r_c = $modx->db->getRow($modx->db->query('SELECT count(question_id) as wrong FROM `new_question_2_user` WHERE user_id = "'.$modx->db->escape($user_id).'" LIMIT 1'));
        $r_f = $modx->db->getRow($modx->db->query('SELECT count(question_id) as favorite FROM `new_question_2_user_favorite` WHERE user_id = "'.$modx->db->escape($user_id).'" LIMIT 1'));
        $res = $modx->parseChunk('tpl_my_statistics', array( 'wrong' => $r_c['wrong'], 'favorite' => $r_f['favorite'] ));
      }else{
        $res = $modx->getChunk('tpl_my_statistics_standart');
      }
    }
  break;
  case "my_practice":
    $phone = trim(str_replace('+', '', str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $_SESSION['webuser']['phone']))))));


    $q = $modx->db->query('SELECT i.id as instructor_id, itu.lesson_total, itu.lesson_balance, itu.type
    FROM `modx_a_instructor_to_user` itu
    LEFT JOIN `modx_web_user_attributes` wua ON wua.cabinet_syncname = itu.instructor_name
    LEFT JOIN `modx_a_instructors` i ON wua.internalKey = i.user_id
    WHERE itu.user_phone = "'.$modx->db->escape($phone).'" ');
    if($modx->db->getRecordCount($q) > 0){
      while($r = $modx->db->getRow($q)){
        switch($r['type']){
          default: 
          case "0":
            $r['type_text'] = 'Основне';
          break;
          case "1":
            $r['type_text'] = 'Додаткове';
          break;
          case "2":
            $r['type_text'] = 'Подача авто на іспит';
          break;
        }
        $res .= $modx->parseChunk('tpl_my_practice',$r);
        if($r['instructor_id'] != ''){
          if (!in_array($r['instructor_id'], $_SESSION['favorite_instructor'])){
            $_SESSION['favorite_instructor'][] = $r['instructor_id'];
            $shop->wishUI();
          }
        }
      }
    }else{
      $res = '<span class="error_test_load">Записів не знайдено.</span>';
    }
  break;
  case "firstlessonpromo":
    if($modx->config['firstlessonpromo'] != ''){
      $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($modx->config['firstlessonpromo']).'" AND available = "1" LIMIT 1');
      if($modx->db->getRecordCount($q) > 0){
        $r = $modx->db->getRow($q);
        $res = $modx->parseChunk($tpl, $r);
      }
    }
  break;
  case "online_lection":
    if($_SESSION['webuser']['online_course'] == '1'){
      $res = $modx->getChunk($tpl);
    }
  break;
  case "online_lection_new":
    if($_SESSION['webuser']['online_course'] == '1'){
      $res = $modx->getChunk($tpl);
      $modx->setPlaceholder('online_lection_nav',$modx->getChunk($tpl_nav));
    }
  break;
  case "online_main_page":
    if($_SESSION['webuser']['online_course'] == '1'){
      $res = $modx->getChunk($tpl_2);
    }else{
      $res = $modx->getChunk($tpl);
    }
  break;
   case "new_online_main_page":

    if($_SESSION['webuser']['online_course'] == '1'){
      $res = $modx->getChunk($tpl_2);
    }else{
      $res = $modx->getChunk($tpl);
    }
  break;
  case "lection_full_catalog":
    if($_SESSION['webuser']['online_course'] == '1'){

      if($_GET['lection'] != ''){
        $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "162" AND id = "'.$modx->db->escape($_GET['lection']).'" AND published = "1" AND deleted = "0" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          while($row = $modx->db->getRow($q)){
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'video',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['video'] = $tvres2['value'];
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'video_vimeo',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['video_vimeo'] = $tvres2['value'];
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'lection',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['lection'] = $tvres2['value'];
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'link',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['link'] = $tvres2['value'];
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'bonus',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['bonus'] = $tvres2['value'];
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'theme_id',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['theme_id'] = $tvres2['value'];

            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'title_lection',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['title_lection'] = $tvres2['value'];
            $tvres2 = $modx->getTemplateVar(
                        $idname  = 'meta_lection',
                        $fields = '*',
                        $docid =  $row['id']
                        );
            $row['meta_lection'] = $tvres2['value'];

            $row['lection_video'] = '';
            if($row['video'] != ''){
              $exp_video = explode(',',$row['video']);
              foreach($exp_video as $video){
                $row['lection_video'] .= $modx->parseChunk('tpl_lection_youtube', array('video' => $video));
              }
            }
            if($row['video_vimeo'] != ''){
              $exp_video = explode(',',$row['video_vimeo']);
              foreach($exp_video as $video){
                $row['lection_video'] .= $modx->parseChunk('tpl_lection_vimeo', array('video' => $video));
              }
            }

            $row['lection_bonus'] = '';
            if($row['bonus'] != ''){
              $exp_bonus = explode(',',$row['bonus']);
              foreach($exp_bonus as $bonus){
                $row['lection_bonus'] .= $modx->parseChunk('tpl_lection_youtube', array('video' => $bonus));
              }
            }

            $row['pdr_link'] = '';
            if($row['link'] != ''){
              $exp_link = explode('|',$row['link']);
              foreach($exp_link as $link){
                $exp_l = explode('==',$link);          
                $row['pdr_link'] .= $modx->parseChunk('tpl_lection_pdr_link', array('link' => $exp_l[1], 'title' => $exp_l[0]));
              }
            }
            $menuindex = $row['menuindex'] + 1;
            $next_q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "162" AND menuindex = "'.$modx->db->escape($menuindex).'" AND published = "1" AND deleted = "0" LIMIT 1');
            if($modx->db->getRecordCount($next_q) > 0){
              $next = $modx->db->getRow($next_q);
              $row['next'] = $modx->makeUrl('216').'?lection='.$next['id'];
            }else{
              $row['next'] = $modx->makeUrl('216');
            }
            $res .= $modx->parseChunk($tpl_in,$row);
            $cnt++;
          }
        }else{
          $res = $modx->getChunk($tpl_no);
        }
      }else{
        $progress = 0;
        $ttl = 0;
        $cnt = 1;
        $q = $modx->db->query('SELECT *,
          sc.pagetitle_'.$modx->config['lang'].' as pagetitle, 
          sc.longtitle_'.$modx->config['lang'].' as longtitle, 
          sc.introtext_'.$modx->config['lang'].' as introtext,
          sc.description_'.$modx->config['lang'].' as description,
          sc.link_attributes_'.$modx->config['lang'].' as link_attributes,
          sc.content_'.$modx->config['lang'].' as content, 
          sc.id as id 
          FROM `modx_site_content` sc 
          LEFT JOIN `modx_a_lection_to_user` ltu ON ltu.lection_id = sc.id AND ltu.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" 
          WHERE sc.parent = "'.$modx->db->escape($id).'" AND sc.published = "1" AND sc.deleted = "0"  ORDER BY menuindex ASC');
        while($row = $modx->db->getRow($q)){
          $tvres2 = $modx->getTemplateVar(
                      $idname  = 'img_ua',
                      $fields = '*',
                      $docid =  $row['id']
                      );
          $row['img_ua'] = $tvres2['value'];

          $tvres2 = $modx->getTemplateVar(
                      $idname  = 'title_lection',
                      $fields = '*',
                      $docid =  $row['id']
                      );
          $row['title_lection'] = $tvres2['value'];
          $tvres2 = $modx->getTemplateVar(
                      $idname  = 'meta_lection',
                      $fields = '*',
                      $docid =  $row['id']
                      );
          $row['meta_lection'] = $tvres2['value'];
          $row['link'] = $modx->makeUrl('216').'?lection='.$row['id'];
          if($row['status'] == ''){
            $row['status'] = 0;
          }
          if($row['status'] == 1){
            $progress++;
          }
          $res .= $modx->parseChunk($tpl,$row);
          $cnt++;
          $ttl++;
        }

          $prog['progress'] = $progress;
          $prog['total'] = $ttl;
          $prog['left'] = $ttl-$progress;
          if($progress == '0'){
            $prog['percent'] = $progress;
            $prog['percent_ravlik'] = $progress;
          }else{
            $prog['percent'] = round($progress/$ttl*100);
            $prog['percent_ravlik'] = round($progress/$ttl*97);
          }
          $prog['id'] = $id;
          if($ttl == $progress){
            $course_progress = $modx->parseChunk('tpl_course_progress_done',$prog);
          }else{
            $course_progress = $modx->parseChunk('tpl_course_progress',$prog);
          }
          $modx->setPlaceholder('course_progress',$course_progress);


      }
    }else{
      $res = $modx->getChunk($tpl_no);
    }

  break;
  case "lection_full": // наче не використовується вже
    $cnt = 1;
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND published = "1" AND deleted = "0"  ORDER BY menuindex ASC');
    while($row = $modx->db->getRow($q)){
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'video',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['video'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'lection',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['lection'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'link',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['link'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'bonus',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['bonus'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'theme_id',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['theme_id'] = $tvres2['value'];

      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'title_lection',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['title_lection'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'meta_lection',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['meta_lection'] = $tvres2['value'];

      $row['lection_video'] = '';
      if($row['video'] != ''){
        $exp_video = explode(',',$row['video']);
        foreach($exp_video as $video){
          $row['lection_video'] .= $modx->parseChunk('tpl_lection_youtube', array('video' => $video));
        }
      }

      $row['lection_bonus'] = '';
      if($row['bonus'] != ''){
        $exp_bonus = explode(',',$row['bonus']);
        foreach($exp_bonus as $bonus){
          $row['lection_bonus'] .= $modx->parseChunk('tpl_lection_youtube', array('video' => $bonus));
        }
      }

      $row['pdr_link'] = '';
      if($row['link'] != ''){
        $exp_link = explode('|',$row['link']);
        foreach($exp_link as $link){
          $exp_l = explode('==',$link);          
          $row['pdr_link'] .= $modx->parseChunk('tpl_lection_pdr_link', array('link' => $exp_l[1], 'title' => $exp_l[0]));
        }
      }

      

      if($cnt == 1){
        $row['class'] = 'active';
      }else{
        $row['class'] = '';
      }
      $res .= $modx->parseChunk($tpl,$row);
      $nav .= $modx->parseChunk($tpl_nav,$row);
      $cnt++;
    }
    $modx->setPlaceholder('nav', $nav);
  break;
  case "lection"://тестовий урок
    $cnt = 1;
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND published = "1" AND deleted = "0" ORDER BY menuindex ASC LIMIT 1');
    while($row = $modx->db->getRow($q)){
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'video',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['video'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'video_vimeo',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['video_vimeo'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'lection',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['lection'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'link',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['link'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'bonus',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['bonus'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'theme_id',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['theme_id'] = $tvres2['value'];


      $row['lection_video'] = '';
      if($row['video'] != ''){
        $exp_video = explode(',',$row['video']);
        foreach($exp_video as $video){
          $row['lection_video'] .= $modx->parseChunk('tpl_lection_youtube', array('video' => $video));
        }
      }
      if($row['video_vimeo'] != ''){
        $exp_video = explode(',',$row['video_vimeo']);
        foreach($exp_video as $video){
          $row['lection_video'] .= $modx->parseChunk('tpl_lection_vimeo', array('video' => $video));
        }
      }


      if($cnt == 1){
        $row['class'] = 'active';
      }else{
        $row['class'] = '';
      }
      $res = $modx->parseChunk($tpl,$row);
      $nav .= $modx->parseChunk($tpl_nav,$row);
      $cnt++;
    }
    $modx->setPlaceholder('nav', $nav);

  break;
  case "lection_nav_blocked":
    for($i = 2; $i <= 14; $i++){
      $res .= $modx->parseChunk($tpl,array('pagetitle' => 'Лекція '.$i));
    }
  break;
  case "price_format":
      $res = number_format($price, 0, '.', ' ');
  break;
  case "smart_course_price":
      $discount = '';
      $price_old = '';
      $promo = '';
      $price_base = $modx->config['price_base_video'];
      $price = number_format($price_base, 0, '.', ' ');
      if($_SESSION['promocode'] != ''){
        $promo = $_SESSION['promocode'];
        $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($promo).'" AND available = "1" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          $r = $modx->db->getRow($q);
          $price_new_base = $price_base-$r['discount'];
          $price_old = number_format($price_base, 0, '.', ' ');
          $price = number_format($price_new_base, 0, '.', ' ');
          $discount = number_format($r['discount'], 0, '.', ' ');
          $promo = $r['promocode'];
        }else{
          unset($_SESSION['promocode']);
          $modx->sendRedirect($modx->makeUrl($modx->documentIdentifier));
          die;
        }
      }
      $res = $modx->parseChunk($tpl, array('price' => $price, 'price_old' => $price_old, 'promo' => $promo, 'discount' => $discount));
  break;
  case "online_price":
      $discount = '';
      $price_old = '';
      $promo = '';
      $price_base = $modx->config['price_base'];
      $price = number_format($price_base, 0, '.', ' ');
      if($_SESSION['promocode'] != ''){
        $promo = $_SESSION['promocode'];
        $q = $modx->db->query('SELECT * FROM `modx_a_promo` WHERE promocode = "'.$modx->db->escape($promo).'" AND available = "1" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          $r = $modx->db->getRow($q);
          $price_new_base = $price_base-$r['discount'];
          $price_old = number_format($price_base, 0, '.', ' ');
          $price = number_format($price_new_base, 0, '.', ' ');
          $discount = number_format($r['discount'], 0, '.', ' ');
          $promo = $r['promocode'];
        }else{
          unset($_SESSION['promocode']);
          $modx->sendRedirect($modx->makeUrl($modx->documentIdentifier));
          die;
        }
      }
      $res = $modx->parseChunk($tpl, array('price' => $price, 'price_old' => $price_old, 'promo' => $promo, 'discount' => $discount));
  break;
  case "promocode_pop":
    if($_GET['promocode'] != ''){
      //$_SESSION['promocode'] = $_GET['promocode'];
      $res = $modx->getChunk('tpl_online_trigger');
    }
  break;
  case "promocode":
    if($_SESSION['promocode'] != ''){
      $res = $_SESSION['promocode'];
      $modx->setPlaceholder('promo_checkbox', 'checked="checked"');
      $modx->setPlaceholder('promo_check', 'active');
      $modx->setPlaceholder('promo_filled', 'ac_filed');
    }else{
      $res = '';
    }
  break;
  case "session_id":
    $res = session_id();
  break;
  case "status_pay_p":
    if(isset($order)){
      $ord = $order;
    }else{
      $ord = $_GET['order'];
    }

    if($ord != ''){
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_order` WHERE order_hash = "'.$modx->db->escape($ord).'" LIMIT 1'));
      if($r['order_status_pay'] == 1){
        if($r['order_from'] != '0'){
          //замовлення зі сторінки інструктора
          $r['order_data'] = 'instructor-lesson_success';
        }else{
          //Звичайне автошкола
          $r['order_data'] = 'instructor-lesson_taurus_success';
        }
        $res = $modx->parseChunk('order_success',$r,'[+','+]');
      }else{
        $res = $modx->parseChunk('order_waitpay',array('order'=> $ord));
      }
    }else{
      $res = '';
    }
  break;
  case "status_pay_s":
    if(isset($order)){
      $ord = $order;
    }else{
      $ord = $_GET['order'];
    }

    if($ord != ''){
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_subscribe` WHERE hash = "'.$modx->db->escape($ord).'" LIMIT 1'));
      if($r['status'] == 1){
        $res = $modx->parseChunk('subscribe_success',$r,'[+','+]');
      }else{
        $res = $modx->parseChunk('subscribe_waitpay',array('order'=> $ord));
      }
    }else{
      $res = '';
    }
  break;
  case "status_pay":
    if(isset($order)){
      $ord = $order;
    }else{
      $ord = $_GET['order'];
    }

    if($ord != ''){
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_online` WHERE hash = "'.$modx->db->escape($ord).'" LIMIT 1'));
      if($r['status_pay'] == 1){
        $_SESSION['webuser']['online_course'] = '1';
        $res = $modx->parseChunk('online_success',$r,'[+','+]');
      }else{
        $res = $modx->parseChunk('online_waitpay',array('order'=> $ord));
      }
      
    }else{
      $res = '';
    }
  break;
  case "status_pay_v":
    if(isset($order)){
      $ord = $order;
    }else{
      $ord = $_GET['order'];
    }

    if($ord != ''){
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_video` WHERE hash = "'.$modx->db->escape($ord).'" LIMIT 1'));
      if($r['status_pay'] == 1){
        $res = $modx->parseChunk('smart_success',$r,'[+','+]');
      }else{
        $res = $modx->parseChunk('smart_waitpay',array('order'=> $ord));
      }
    }else{
      $res = '';
    }
  break;
  case "pub_date_r":
    $res = date('c',$date);
  break;
  case "districts":
    $q = $modx->db->query('SELECT * FROM `modx_a_district` ORDER BY id ASC');
    while($r = $modx->db->getRow($q)){
      $r['selected'] = '';
      $r['data'] = '';
      $r['name'] = $r['district_name'];
      $r['value'] = $r['district_name'];
      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "cities":
    $q = $modx->db->query('SELECT * FROM `modx_a_city` ORDER BY id ASC');
    while($r = $modx->db->getRow($q)){
      $r['selected'] = '';
      $r['data'] = '';
      $r['name'] = $r['city_name'];
      $r['value'] = $r['city_name'];
      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "catalog_category":
    $q = $modx->db->query('SELECT DISTINCT(p.product_main_cat) as product_main_cat, sc.pagetitle as pagetitle FROM `modx_a_products` p LEFT JOIN `modx_site_content` sc ON sc.id = p.product_main_cat WHERE deleted = "0" AND published = "1" ORDER BY sc.pagetitle ASC ');
    while($r = $modx->db->getRow($q)){
      $r['selected'] = '';
      $r['data'] = '';
      $r['name'] = $r['pagetitle'];
      $r['value'] = $r['product_main_cat'];
      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "catalog_param":
    $res = $default;
    if(isset($_GET[$param])){
      if($_GET[$param] != ''){
        $res = $_GET[$param];
      }
    }
  break;
  case "instructor_param":
    if(isset($_GET[$param])){
      if($_GET[$param] != ''){
        $res = $_GET[$param];
      }
    }
  break;
  case "instructors_school":


    $uncheck = array();
    if(isset($_REQUEST['load_more']) AND $_REQUEST['load_more'] != ''){
      $page = $_REQUEST['load_more']*$limit;
    }else{
      $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
      if($page == -1){
        $page = 0;
      }
    }

    if(isset($_GET['city'])){
      if($_GET['city'] != ''){
        $q_c = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_city` WHERE city_slug = "'.$modx->db->escape($_GET['city']).'" LIMIT 1'));
        if($q_c['city_name'] != ''){
          $uncheck['city'] = $q_c['city_name'];
          $city = 'AND (i.city = "'.$modx->db->escape($q_c['city_name']).'")';
        }
      }
    }
    if(isset($_GET['district'])){
      if($_GET['district'] != ''){
        $q_c = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_district` WHERE district_slug = "'.$modx->db->escape($_GET['district']).'" LIMIT 1'));
        if($q_c['district_name'] != ''){
          $uncheck['district'] = $q_c['district_name'];
          $district = 'AND (i.district = "'.$modx->db->escape($q_c['district_name']).'")';
        }
      }
    }
    if(isset($_GET['transmission'])){
      if($_GET['transmission'] != ''){
        $transmission = 'AND (i.transmission IN ("'.$modx->db->escape($_GET['transmission']).'") OR FIND_IN_SET("'.$modx->db->escape($_GET['transmission']).'",i.transmission) )';
        $uncheck['transmission'] = $shop->getTrval('transmission',$_GET['transmission']);
      }
    }
    if(isset($_GET['type'])){
      if($_GET['type'] != ''){
        $type = 'AND (i.type IN ("'.$modx->db->escape($_GET['type']).'") OR FIND_IN_SET("'.$modx->db->escape($_GET['type']).'",i.type) )';
        $uncheck['type'] = $shop->getTrval('type',$_GET['type']);
      }
    }
    if(isset($_GET['duration'])){
      if($_GET['duration'] != ''){
        $duration = 'AND (i.duration = "'.$modx->db->escape($_GET['duration']).'")';
        $uncheck['duration'] = $_GET['duration'].' хвилин';
      }
    }
    if(isset($_GET['verify'])){
      if($_GET['verify'] != ''){
        $verify = 'AND (i.verify = "'.$modx->db->escape($_GET['verify']).'")';
        $uncheck['verify'] = $shop->getTrval('verify',$_GET['verify']);
      }
    }

    if(isset($id)){
      if($id != ''){
        $school = 'AND (i.school = "'.$modx->db->escape($id).'")';
      }
    }



    //SEARCH
    if($_GET['s'] != ''){
      $_REQUEST['s'] = $_GET['s'];
    }
    $search = strip_tags($_REQUEST['s']);  
    if($search != '' AND !is_array($search))  {
      if(mb_strlen($search,'UTF-8') > 1){  
        $s = $modx->db->escape($search);
        $where[] = "(i.fullname  LIKE '%$s%' OR i.lastname LIKE '%$s%' )";
        $where  = implode(" OR ", $where);
        $where  = ' AND ( '.$where.' )';
        $modx->setPlaceholder('search_text', $search);
        $uncheck['search'] = $search;
      }
    }    

    switch ($_GET['sort']) {
        case 'date':      $sort = "ORDER BY i.registration_date DESC "; break;
        case 'cheap':     $sort = "ORDER BY i.price ASC"; break;
        case 'expensive': $sort = "ORDER BY i.price DESC"; break;
        case 'rating':    $sort = "ORDER BY i.rating DESC"; break;
        case 'view':      $sort = "ORDER BY i.view DESC"; break;
        default:          $sort = "ORDER BY i.rating DESC "; break;
    }

    $limitation = "LIMIT ".$page.", ".$limit;

    $q = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS * FROM `modx_a_instructors` i 
      WHERE 
      i.status = "1"
      '.$school.' 
      '.$city.'
      '.$district.'
      '.$transmission.'
      '.$type.'
      '.$duration.'
      '.$verify.'
      '.$where.'
      '.$sort.'
      '.$limitation.' ');
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($r = $modx->db->getRow($q)){

      $r['instructor_url'] = $modx->makeUrl('89').$r['instructor_url'].'/';
      $r['type'] = $shop->getTrval('type',$r['type']);
      $r['transmission'] = $shop->getTrval('transmission',$r['transmission']);
      $r['wish_status'] = $shop->checkInstructorWish($r['id'],$_SESSION['webuser']['internalKey']); 

      $res .= $modx->parseChunk($tpl,$r);
    }  
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);

    if($res == ''){
      $res = $modx->getChunk('tpl_instructor_not_found');
      $load_more = '';
    }else{
      if($limit < $pages['cnt']){
        $load_more = $modx->parseChunk('tpl_load_more',array('type' => '1'));
      }else{
        $load_more = '';
      }
    }
    $modx->setPlaceholder("load_more", $load_more);
    $seo_name = array();
    if(count($uncheck) > 0){
      foreach($uncheck as $ch_k => $ch_v){
        $uncheck_block .= $modx->parseChunk('tpl_uncheck', array('key' => $ch_k, 'value' => $ch_v));
        $seo_name[] = $ch_v;
      }
      if($modx->getPlaceholder('seo_name_inactive') != '1'){
        $modx->setPlaceholder('seo_name', implode(', ',$seo_name));
      }
      $modx->setPlaceholder('uncheck',$uncheck_block);
    }
  break;  
  case "instructor_school_page_url":
    $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND (template = "96" OR template = "100") LIMIT 1'));
    if($r['id'] != ''){
      $res = $modx->makeUrl($r['id']);
      $modx->setPlaceholder('instructor_school_page_url', $res);
    }
  break;
  case "instructor_count_school":

    if($id != ''){
      $school = 'AND (i.school = "'.$modx->db->escape($id).'")';
    }

    $r = $modx->db->getRow($modx->db->query('SELECT count(i.id) as cnt FROM `modx_a_instructors` i WHERE i.status = "1" '.$school));
    $res = $r['cnt'];
  break;
  case "instructor_count":
    if($city != ''){
      $search_i = ' AND i.city = "'.$modx->db->escape($city).'" ';
    }
    $r = $modx->db->getRow($modx->db->query('SELECT count(i.id) as cnt FROM `modx_a_instructors` i WHERE i.status = "1" '.$search_i));
    $res = $r['cnt'];
  break;
  case "instructors_wish":
    if($_SESSION['webuser']['internalKey'] != ''){
      $q = $modx->db->query('SELECT *, i.id as id FROM  `modx_a_instructor_to_wish` itw
        LEFT JOIN `modx_a_instructors` i ON i.id = itw.instructor_id
      WHERE i.status = "1" AND itw.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'"  LIMIT '.$limit);
      $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      while($r = $modx->db->getRow($q)){
        $r['instructor_url'] = $modx->makeUrl('89').$r['instructor_url'].'/';
        $r['type'] = $shop->getTrval('type',$r['type']);
        $r['transmission'] = $shop->getTrval('transmission',$r['transmission']);

        $r['wish_status'] = $shop->checkInstructorWish($r['id'],$_SESSION['webuser']['internalKey']); 
        
        $res .= $modx->parseChunk($tpl,$r);
      }  
      if($res == ''){
        $res = '<span class="error_test_load">Інструкторів не знайдено. <a href="[~~89~~]">Додайте інструкторів</a></span>';
      }
    }
  break;  
  case "instructors_friends":

    if($school != ''){
      $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE status = "1" AND school = "'.$modx->db->escape($school).'" ORDER BY rand() LIMIT '.$limit);
    }else{
      if($district != '' OR $city != ''){
        $q = $modx->db->query('SELECT * FROM `modx_a_instructors` WHERE status = "1" AND ( district = "'.$modx->db->escape($district).'" OR city = "'.$modx->db->escape($city).'" ) ORDER BY rand() LIMIT '.$limit);
      }
    }

    if($modx->db->getRecordCount($q) > 0){

      while($r = $modx->db->getRow($q)){
        $r['instructor_url'] = $modx->makeUrl('89').$r['instructor_url'].'/';
        $r['type'] = $shop->getTrval('type',$r['type']);
        $r['transmission'] = $shop->getTrval('transmission',$r['transmission']);

        $r['wish_status'] = $shop->checkInstructorWish($r['id'],$_SESSION['webuser']['internalKey']); 
        
        $res .= $modx->parseChunk($tpl,$r);
      }  
    }
  break;
  case "instructors_city":

    if(isset($city)){
      if($city != ''){
        $q_c = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_city` WHERE city_slug = "'.$modx->db->escape($city).'" LIMIT 1'));
        if($q_c['city_name'] != ''){
          $uncheck['city'] = $q_c['city_name'];
          $city = 'AND (i.city = "'.$modx->db->escape($q_c['city_name']).'")';
        }
      }
    }
   
    $sort = "ORDER BY i.rating DESC ";
    $limitation = "LIMIT ".$limit;

    $q = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS *, i.id as id FROM `modx_a_instructors` i 
      WHERE 
      i.status = "1" AND i.verify = "1"
      '.$city.'
      '.$sort.'
      '.$limitation.' ');
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($r = $modx->db->getRow($q)){

      $r['instructor_url'] = $modx->makeUrl('89').$r['instructor_url'].'/';
      $r['type'] = $shop->getTrval('type',$r['type']);
      $r['transmission'] = $shop->getTrval('transmission',$r['transmission']);
      $r['wish_status'] = $shop->checkInstructorWish($r['id'],$_SESSION['webuser']['internalKey']); 

      $res .= $modx->parseChunk($tpl,$r);
    }  
  break;
  case "instructors":
    if($_GET['test'] = 'new'){
      $tpl = 'tpl_instructor_n2';
    }else{
      $tpl = 'tpl_instructor_n';
    }

    $uncheck = array();
    if(isset($_REQUEST['load_more']) AND $_REQUEST['load_more'] != ''){
      $page = $_REQUEST['load_more']*$limit;
    }else{
      $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
      if($page == -1){
        $page = 0;
      }
    }

    if(isset($_GET['city'])){
      if($_GET['city'] != ''){
        $q_c = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_city` WHERE city_slug = "'.$modx->db->escape($_GET['city']).'" LIMIT 1'));
        if($q_c['city_name'] != ''){
          $uncheck['city'] = $q_c['city_name'];
          $city = 'AND (i.city = "'.$modx->db->escape($q_c['city_name']).'")';
        }
      }
    }
    if(isset($_GET['district'])){
      if($_GET['district'] != ''){
        $q_c = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_district` WHERE district_slug = "'.$modx->db->escape($_GET['district']).'" LIMIT 1'));
        if($q_c['district_name'] != ''){
          $uncheck['district'] = $q_c['district_name'];
          $district = 'AND (i.district = "'.$modx->db->escape($q_c['district_name']).'")';
        }
      }
    }
    if(isset($_GET['transmission'])){
      if($_GET['transmission'] != ''){
        $transmission = 'AND (i.transmission IN ("'.$modx->db->escape($_GET['transmission']).'") OR FIND_IN_SET("'.$modx->db->escape($_GET['transmission']).'",i.transmission) )';
        $uncheck['transmission'] = $shop->getTrval('transmission',$_GET['transmission']);
      }
    }
    if(isset($_GET['type'])){
      if($_GET['type'] != ''){
        $type = 'AND (i.type IN ("'.$modx->db->escape($_GET['type']).'") OR FIND_IN_SET("'.$modx->db->escape($_GET['type']).'",i.type) )';
        $uncheck['type'] = $shop->getTrval('type',$_GET['type']);
      }
    }
    if(isset($_GET['duration'])){
      if($_GET['duration'] != ''){
        $duration = 'AND (i.duration = "'.$modx->db->escape($_GET['duration']).'")';
        $uncheck['duration'] = $_GET['duration'].' хвилин';
      }
    }
    if(isset($_GET['verify'])){
      if($_GET['verify'] != ''){
        $verify = 'AND (i.verify = "'.$modx->db->escape($_GET['verify']).'")';
        $uncheck['verify'] = $shop->getTrval('verify',$_GET['verify']);
      }
    }




    //SEARCH
    if($_GET['s'] != ''){
      $_REQUEST['s'] = $_GET['s'];
    }
    $search = strip_tags($_REQUEST['s']);  
    if($search != '' AND !is_array($search))  {
      if(mb_strlen($search,'UTF-8') > 1){  
        $s = $modx->db->escape($search);
        $where[] = "(i.fullname  LIKE '%$s%' OR i.lastname LIKE '%$s%' )";
        $where  = implode(" OR ", $where);
        $where  = ' AND ( '.$where.' )';
        $modx->setPlaceholder('search_text', $search);
        $uncheck['search'] = $search;
      }
    }    

    switch ($_GET['sort']) {
        case 'date':      $sort = "ORDER BY i.registration_date DESC "; break;
        case 'cheap':     $sort = "ORDER BY i.price ASC"; break;
        case 'expensive': $sort = "ORDER BY i.price DESC"; break;
        case 'rating':    $sort = "ORDER BY i.rating DESC"; break;
        case 'reviews':   $sort = "ORDER BY i.rating_reviews DESC"; break;
        case 'view':      $sort = "ORDER BY i.view DESC"; break;
        default:          $sort = "ORDER BY i.rating DESC "; break;
    }

    $limitation = "LIMIT ".$page.", ".$limit;

    $sql = 'SELECT SQL_CALC_FOUND_ROWS *, i.id as id FROM `modx_a_instructors` i 
      WHERE 
      i.status = "1" 
      '.$city.'
      '.$district.'
      '.$transmission.'
      '.$type.'
      '.$duration.'
      '.$verify.'
      '.$where.'
      '.$sort.'
      '.$limitation.' ';
    $q = $modx->db->query($sql);
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($r = $modx->db->getRow($q)){

      $r['instructor_url'] = $modx->makeUrl('89').$r['instructor_url'].'/';
      $r['type'] = $shop->getTrval('type',$r['type']);
      $r['transmission_new'] = $shop->getTrval('transmission_new',$r['transmission']);
      $r['transmission'] = $shop->getTrval('transmission',$r['transmission']);
      $r['wish_status'] = $shop->checkInstructorWish($r['id'],$_SESSION['webuser']['internalKey']); 
      $res .= $modx->parseChunk($tpl,$r);
    }  
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);

    if($res == ''){
      $res = $modx->getChunk('tpl_instructor_not_found');
      $load_more = '';
    }else{
      if($limit < $pages['cnt']){
        $load_more = $modx->parseChunk('tpl_load_more',array('type' => '1'));
      }else{
        $load_more = '';
      }
    }
    $modx->setPlaceholder("load_more", $load_more);
    $seo_name = array();
    if(count($uncheck) > 0){
      foreach($uncheck as $ch_k => $ch_v){
        $uncheck_block .= $modx->parseChunk('tpl_uncheck', array('key' => $ch_k, 'value' => $ch_v));
        $seo_name[] = $ch_v;
      }
      if($modx->getPlaceholder('seo_name_inactive') != '1'){
        $modx->setPlaceholder('seo_name', implode(', ',$seo_name));
      }
      $modx->setPlaceholder('uncheck',$uncheck_block);
    }
  break;
  case "lang_active":
    $res = strtoupper($modx->config['lang']);
  break;
  case "lang_class":
    if($modx->config['lang'] == $l){
      $res = 'active';
    }
  break;
  case "head_lang":
    if($modx->config['lang'] == 'ua'){
      $res = 'uk';
    }else{
      $res = $modx->config['lang'];
    }
  break;
  case "hreflang":
    $parts = explode("/", $_GET['q']);
    array_pop($parts);

    $url = $_GET['q'];
    if($url[0] == '/'){
      $url = substr($url, 1);
    }
    if($hreflang == 'ua'){
      $res = $modx->config['site_url'].$url;
    }else{
      $res = $modx->config['site_url'].$hreflang.'/'.$url;
    }
  
  break;
  case "callbtn":
    $pages = array('1','88','177','178','179','182','180','181');
    if(in_array($modx->documentIdentifier, $pages)){
      $res = $modx->getChunk('tpl_callbtn');
    }
  break;
  case "lang_link":

    $q = $_GET['q'];
    if($l == 'ua'){
      $res = '/'.$q;
    }else{
      $res = '/'.$l.'/'.$q;
    }
  break;
  case "parsephone":
  case "parsePhone":
    $res = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $phone))));
  break;
  case "rand":
    $res = uniqid();
  break;
  case "escaper":
    $res = trim(str_replace('"', '', $val));
  break;
  case "page_url":
    $parts = explode("/", $_GET['q']);
    array_pop($parts);
    if( preg_match("/(^page-)+[0-9]{1,}\$/",end($parts)) ){
      $page = end($parts);
      $page_num = preg_replace("/[^0-9]/", '', $page);
      $url = str_replace('page-'.$page_num.'/', '', $_GET['q']);
    }else{
      $url = $_GET['q'];
    }
    $modx->setPlaceholder('url',$url);
    $params = $_GET;
    unset($params['q'],$params['lang'],$params['city'],$params['district'],$params['transmission'],$params['type'],$params['duration'],$params['verify'],$params['sort'],$params['p']);
    if(count($params) > 0){
      $url .= '?'.http_build_query($params);
    }
    $res = $modx->config['site_url'].$url;
  break;
  case "dev":
    $stats = $modx->getTimerStats($modx->tstart);
    foreach ($stats as $key => $value) {
        $s .= '<p>' . $key . ' = ' . $value . '</p>';
    }
    $res = '<div class="dev" style="position: fixed;bottom: 0;z-index: 300;background: white;border: 2px solid black;padding: 10px;opacity: 0.5;">' . $s . '</div>';
  break;
  case "review_all":



    $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
    if($page == -1 OR $page == -2){
      $page = 0;
    }


    $query = $modx->db->query('
        SELECT SQL_CALC_FOUND_ROWS * '.$lang_content.' FROM `modx_site_content` 
        WHERE template = "76" AND published = 1 AND deleted = "0" AND parent = "137"
        LIMIT '.$modx->db->escape($page).', '.$modx->db->escape($limit).' 
        ');


    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($row = $modx->db->getRow($query)){       
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_'.$modx->config['lang'],
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'audio',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['audio'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'video_file',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['video_file'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_2',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img_2'] = $tvres2['value'];
      $res .= $modx->parseChunk($tpl,$row);
      
    }
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);
  break;
  case "review":
    $check_id = $modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($modx->documentIdentifier).'" AND template = "110" LIMIT 1');
    if($modx->db->getRecordCount($check_id) > 0){
      $ch = $modx->db->getRow($check_id);
      $id = $ch['id'];
    }
    if($id == ''){
      $id = $modx->documentIdentifier;
    }
    $query = $modx->db->query('
        SELECT * '.$lang_content.' FROM `modx_site_content` 
        WHERE parent = "'.$modx->db->escape($id).'" AND published = 1 AND deleted = "0"
        ORDER BY menuindex ASC
        LIMIT '.$modx->db->escape($limit).' 
        ');
    while($row = $modx->db->getRow($query)){       
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_'.$modx->config['lang'],
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'audio',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['audio'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'video_file',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['video_file'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_2',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img_2'] = $tvres2['value'];
      $res .= $modx->parseChunk($tpl,$row);
    }
  break;
  case "webi":

    if($id == ''){
      $id = $modx->documentIdentifier;
    }
    $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
    if($page < 0){
      $page = 0;
    }
    $query = $modx->db->query('
        SELECT 
        SQL_CALC_FOUND_ROWS
        * '.$lang_content.' FROM `modx_site_content` 
        WHERE parent = "'.$modx->db->escape($id).'" AND published = 1 AND deleted = "0"
        ORDER BY menuindex DESC
        LIMIT '.$modx->db->escape($page).', '.$modx->db->escape($limit).' 
        ');
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($row = $modx->db->getRow($query)){ 
      

      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'link',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['link'] = $tvres2['value'];
      if($row['link'] == ''){
        $row['link'] = $modx->makeUrl($row['id']);
      } 
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_'.$modx->config['lang'],
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'video_'.$modx->config['lang'],
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['video'] = $tvres2['value'];


      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'webi_date',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['webi_date'] = $tvres2['value'];

      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'webi_date',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['webi_date'] = $tvres2['value'];
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'webi_users',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['webi_users'] = $tvres2['value'];

      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'webi_status',
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['webi_status'] = $tvres2['value'];
      


      $row['date'] = date('d.m.Y', $row['pub_date']);
      $res .= $modx->parseChunk($tpl,$row);
    }
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);
  break;
  case "webi":

    if($id == ''){
      $id = $modx->documentIdentifier;
    }
    $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
    if($page == -1 OR $page == -2){
      $page = 0;
    }
    $query = $modx->db->query('
        SELECT 
        SQL_CALC_FOUND_ROWS
        * '.$lang_content.' FROM `modx_site_content` 
        WHERE parent = "'.$modx->db->escape($id).'" AND published = 1 AND deleted = "0"
        ORDER BY pub_date DESC
        LIMIT '.$modx->db->escape($page).', '.$modx->db->escape($limit).' 
        ');
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($row = $modx->db->getRow($query)){ 
      
      $row['link'] = $modx->makeUrl($row['id']);
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_'.$modx->config['lang'],
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img'] = $tvres2['value'];
      $row['date'] = date('d.m.Y', $row['pub_date']);
      $res .= $modx->parseChunk($tpl,$row);
    }
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);
  break;
  case "blog":

    if($id == ''){
      $id = $modx->documentIdentifier;
    }
    $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
    if($page == -1 OR $page == -2){
      $page = 0;
    }
    $query = $modx->db->query('
        SELECT 
        SQL_CALC_FOUND_ROWS
        * '.$lang_content.' FROM `modx_site_content` 
        WHERE parent = "'.$modx->db->escape($id).'" AND published = 1 AND deleted = "0"
        ORDER BY pub_date DESC
        LIMIT '.$modx->db->escape($page).', '.$modx->db->escape($limit).' 
        ');
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($row = $modx->db->getRow($query)){ 
      
      $row['link'] = $modx->makeUrl($row['id']);
      $tvres2 = $modx->getTemplateVar(
                  $idname  = 'img_'.$modx->config['lang'],
                  $fields = '*',
                  $docid =  $row['id']
                  );
      $row['img'] = $tvres2['value'];
      $row['date'] = date('d.m.Y', $row['pub_date']);
      $res .= $modx->parseChunk($tpl,$row);
    }
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);
  break;
  case "paginate_catalog":
    $tpl         = ($tpl != '') ? $tpl : 'tpl_paginate' ;
    $tpl_enable  = ($tpl_enable != '') ? $tpl_enable : 'tpl_page_enable';
    $tpl_disable = ($tpl_disable != '') ? $tpl_disable : 'tpl_page_disable';
    $classJS     = ($classJS != '') ? ' '.$classJS : '';
    $hash = ($hash != '') ? ' '.$hash : '';
    $res = $shop->getPaginateCatalog($tpl, $tpl_enable, $tpl_disable, $classJS,$hash);    
  break;
  case "paginate_instructor":
    $tpl         = ($tpl != '') ? $tpl : 'tpl_paginate' ;
    $tpl_enable  = ($tpl_enable != '') ? $tpl_enable : 'tpl_page_enable';
    $tpl_disable = ($tpl_disable != '') ? $tpl_disable : 'tpl_page_disable';
    $classJS     = ($classJS != '') ? ' '.$classJS : '';
    $hash = ($hash != '') ? ' '.$hash : '';
    $res = $shop->getPaginateInstructor($tpl, $tpl_enable, $tpl_disable, $classJS,$hash);    
  break;
  case "paginate_blog":
    $tpl         = ($tpl != '') ? $tpl : 'tpl_paginate' ;
    $tpl_enable  = ($tpl_enable != '') ? $tpl_enable : 'tpl_page_enable';
    $tpl_disable = ($tpl_disable != '') ? $tpl_disable : 'tpl_page_disable';
    $classJS     = ($classJS != '') ? ' '.$classJS : '';
    $hash = ($hash != '') ? ' '.$hash : '';
    $res = $shop->getPaginateBlog($tpl, $tpl_enable, $tpl_disable, $classJS,$hash);    
  break;
  case "year":
    $res = date('Y');
  break;
  case "tv":
      $tvres2 = $modx->getTemplateVar(
            $idname  = $type,
            $fields = '*',
            $docid =  $id
            );
      $res = $tvres2['value'];
  break;
  case "content":
      $r = $modx->db->getRow($modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE id = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" LIMIT 1'));
      $res = $r[$field];
  break;

  case "banner_top":
    if(!in_array($modx->documentIdentifier,array('88','162','89','118'))){
      if(!$_SESSION['close_top_banner']){
        $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE published = "1" AND deleted = "0" AND id = "'.$modx->db->escape($id).'" LIMIT 1');
        if($modx->db->getRecordCount($q) > 0){
          $r = $modx->db->getRow($q);
          $tvres2 = $modx->getTemplateVar(
                $idname  = 'link',
                $fields = '*',
                $docid =  $r['id']
                );
          $r['link'] = $tvres2['value'];
          $time = time()+$modx->config['server_offset_time'];
          $time_to = $r['unpub_date']-$time;
          $r['days'] = floor($time_to / (60 * 60 * 24));;
          $r['hours'] = date('H',$time_to);
          $r['minutes'] = date('i',$time_to);
          $r['seconds'] = date('s',$time_to);

          $res = $modx->parseChunk($tpl,$r);
          $modx->setPlaceholder('topbannerblock','topbannerblock');
        }
      }
    }
  break;
  case "current_page":
    $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) : 0;
    if($page == -1){
      $page = 0;
    }
    $res = $page;
  break;
  case "block_box_test":
    if(isset($exclude)){
      $ex = ' AND id NOT IN ('.$modx->db->escape($exclude).') ';
    }
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" '.$ex.' ORDER BY menuindex ASC');
    while ($r = $modx->db->getRow($q)) {
      $r['img'] = $shop->getTv($r['id'],'5');
      if($r['type'] == 'reference'){
        $r['link'] = $r['content'];
      }else{
        $r['link'] = $modx->makeUrl($r['id']);
      }
      $r['attr'] = '';
      if($r['link_attributes'] == 'regonly' AND $_SESSION['webuser']['internalKey'] == ''){
        $r['link'] = '#';
        $r['attr'] = 'class="call_continue regonly"';
        $r['longtitle'] = '<span class="regonly_text">Доступно тільки зареєстрованим користувачам</span><div class="lock"><svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7 7c0-2.762 2.238-5 5-5s5 2.238 5 5v3h.4c.88 0 1.6.72 1.6 1.6v7c0 1.32-1.08 2.4-2.4 2.4H7.4C6.08 21 5 19.92 5 18.6v-7c0-.88.72-1.6 1.6-1.6H7V7Zm8 0v3H9V7c0-1.658 1.342-3 3-3s3 1.342 3 3Zm-3 5.25a1.75 1.75 0 0 0-.75 3.332V18a.75.75 0 0 0 1.5 0v-2.418A1.75 1.75 0 0 0 12 12.25Z" fill="#fff"/></svg></div>';
      }else{
        if($r['link_attributes'] == 'regonly' AND $_SESSION['webuser']['user_type'] == '0'){
          $r['link'] = $modx->makeUrl('176');
          $r['attr'] = 'class="regonly"';
          $r['longtitle'] = '<span class="regonly_text">Доступно тільки з Premium підпискою</span><div class="lock"><svg width="30px" height="30px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M7 7c0-2.762 2.238-5 5-5s5 2.238 5 5v3h.4c.88 0 1.6.72 1.6 1.6v7c0 1.32-1.08 2.4-2.4 2.4H7.4C6.08 21 5 19.92 5 18.6v-7c0-.88.72-1.6 1.6-1.6H7V7Zm8 0v3H9V7c0-1.658 1.342-3 3-3s3 1.342 3 3Zm-3 5.25a1.75 1.75 0 0 0-.75 3.332V18a.75.75 0 0 0 1.5 0v-2.418A1.75 1.75 0 0 0 12 12.25Z" fill="#fff"/></svg></div>';
        }
      }
      switch($r['id']){
        case "93":
          if($_SESSION['webuser']['category_type'] != ''){
            $r['active_category'] = $r['link'].'?category='.$_SESSION['webuser']['category_type'];
            $r['active_category_letter'] = $_SESSION['webuser']['category_type'];
          }else{
            $r['active_category'] = $r['link'].'?category=b';
            $r['active_category_letter'] = 'b';
          }
          $res .= $modx->parseChunk($tpl_i,$r);
        break;
        case "75":
          $mass = array();
          $options = '';
          $q2 = $modx->db->query('SELECT * '.$lang_content.'  FROM `modx_site_content` WHERE parent = "152" AND published = "1" AND deleted = "0" ORDER BY menuindex ASC');
          while($r2 = $modx->db->getRow($q2)){
            $cat_link = $modx->makeUrl($r2['id']);
            $options .= '<option value="'.$cat_link.'">'.$r2['description'].'</option>';
            $ll = strtolower($r2['description']);
            $mass[$ll] = $cat_link;
          }
          if($_SESSION['webuser']['category_type'] != ''){
            $r['active_category'] = $mass[$_SESSION['webuser']['category_type']];
            $r['active_category_letter'] = $_SESSION['webuser']['category_type'];
          }else{
            $r['active_category'] = $mass['b'];
            $r['active_category_letter'] = 'b';
          }
          $r['options'] = $options;
          $res .= $modx->parseChunk($tpl_e,$r);
        break;
        default:
        $res .= $modx->parseChunk($tpl,$r);
        break;
      }
    }
  break;
  case "block_box":
    if(isset($exclude)){
      $ex = ' AND id NOT IN ('.$modx->db->escape($exclude).') ';
    }
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" '.$ex.'  ORDER BY menuindex ASC');
    while ($r = $modx->db->getRow($q)) {
      $tvres2 = $modx->getTemplateVar(
            $idname  = 'img_'.$modx->config['lang'],
            $fields = '*',
            $docid =  $r['id']
            );
      $r['img'] = $tvres2['value'];

      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "category_box":
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" AND (template = "94" OR template = "99")  ORDER BY menuindex ASC');
    while ($r = $modx->db->getRow($q)) {
      $tvres2 = $modx->getTemplateVar(
            $idname  = 'img_'.$modx->config['lang'],
            $fields = '*',
            $docid =  $r['id']
            );
      $r['img'] = $tvres2['value'];

      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "firstchildredirect":
    $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($modx->documentIdentifier).'" ORDER BY menuindex ASC LIMIT 1'));
    if($r['id'] != ''){
      $modx->sendRedirect($modx->makeUrl($r['id']));
      die;
    }
  break;
  case "faq":

    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND published = "1" AND deleted = "0" ORDER BY menuindex ASC LIMIT '.$limit);
    while($r = $modx->db->getRow($q)){

      $res .= $modx->parseChunk($tpl,$r);
    }

  break;
  case "faq_in":
    if($id != ''){
      $check = $modx->db->query('SELECT id FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND published = "1" AND deleted = "0" AND template = "113" LIMIT 1');
      if($modx->db->getRecordCount($check) > 0){
        $rcheck = $modx->db->getRow($check);

        $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($rcheck['id']).'" AND published = "1" AND deleted = "0" ORDER BY menuindex ASC LIMIT '.$limit);
        while($r = $modx->db->getRow($q)){

          $res .= $modx->parseChunk($tpl,$r);
        }
      }
    }

  break;
  case "questions_theory":

      if($_SESSION['webuser']['user_type'] == '1'){


        if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
          $chat_helper = $modx->getChunk('tpl_chat_why');
        }else{

        }

        if($_GET['category'] == ''){
          $category = 'b';
        }else{
          $category = $_GET['category'];
        }

        $array_question = array();
        $q = $modx->db->query('SELECT * FROM `new_theme_2_test` WHERE category = "'.$modx->db->escape($category).'" ');
        while($r = $modx->db->getRow($q)){
          $q2 = $modx->db->query('SELECT * FROM `new_question_2_theme` q2t 
            LEFT JOIN `new_question` q ON q.id = q2t.question_id
            WHERE q2t.theme_id IN ('.$modx->db->escape($r['themes']).')
            ORDER BY rand() LIMIT '.$modx->db->escape($r['questions_count']).' ');
          while($r2 = $modx->db->getRow($q2)){
            $array_question[] = $r2;
          }
        }
        shuffle($array_question);

        $count = 1;
        foreach($array_question as $r){
          $r['count'] = $count;
          if($count == 1){
            $r['class'] = 'active';
          }else{
            $r['class'] = '';
          }
          if($r['image_new_2'] != '' AND $ravlik_photo){
            $r['image_official'] = $r['image_new_2'];
          }
          $r['answers_block'] = '';

          $answers = json_decode($r['answers'],true);
          if(is_array($answers)){
            foreach($answers as $answer_num => $answer){
              $r['answer_description'] = $answer['description'];
              $r['answer_num'] = $answer_num;
              $r['answers_block'] .= $modx->parseChunk('tpl_answer', $r);
            }
          }

          if(in_array($r['id'], $_SESSION['favorite'])){
            $r['favorite'] = 'active';
          }else{
            $r['favorite'] = '';
          }

          /*
          $r['pdr_i'] = '';
          if($r['pdr'] != ''){
            $e_pdr = explode(',',$r['pdr']);
            foreach($e_pdr as $pdr_chapter){
              $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
              $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
            }
          }
          */
          if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
            $r['comment_call'] = 1;
          }else{
            $r['comment_call'] = 0;
          }


          $r['chat_helper'] = $chat_helper;

          $res .= $modx->parseChunk('tpl_questions', $r);
          $navigation_questions .= $modx->parseChunk('tpl_navigation_questions', $r);
          $count++;
        }


        $modx->setPlaceholder('navigation_questions',$navigation_questions);


      }else{
        $res = $modx->getChunk('tpl_questions_theory_premium_only'); 
      }

  break;
  case "questions_random":


      if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
        $chat_helper = $modx->getChunk('tpl_chat_why');
      }else{

      }

      $q = $modx->db->query('SELECT * FROM `new_question` 
        WHERE 1 = 1
        ORDER BY rand() LIMIT 20');
      $count = 1;
      while($r = $modx->db->getRow($q)){
        $r['count'] = $count;
        if($count == 1){
          $r['class'] = 'active';
        }else{
          $r['class'] = '';
        }
        if($r['image_new_2'] != '' AND $ravlik_photo){
          $r['image_official'] = $r['image_new_2'];
        }
        $r['answers_block'] = '';

        $answers = json_decode($r['answers'],true);
        if(is_array($answers)){
          foreach($answers as $answer_num => $answer){
            $r['answer_description'] = $answer['description'];
            $r['answer_num'] = $answer_num;
            $r['answers_block'] .= $modx->parseChunk('tpl_answer', $r);
          }
        }

        if(in_array($r['id'], $_SESSION['favorite'])){
          $r['favorite'] = 'active';
        }else{
          $r['favorite'] = '';
        }

        /*
        $r['pdr_i'] = '';
        if($r['pdr'] != ''){
          $e_pdr = explode(',',$r['pdr']);
          foreach($e_pdr as $pdr_chapter){
            $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
            $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
          }
        }
        */
        if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
          $r['comment_call'] = 1;
        }else{
          $r['comment_call'] = 0;
        }


        $r['chat_helper'] = $chat_helper;

        $res .= $modx->parseChunk('tpl_questions', $r);
        $navigation_questions .= $modx->parseChunk('tpl_navigation_questions', $r);
        $count++;
      }


      $modx->setPlaceholder('navigation_questions',$navigation_questions);

  break;
  case "questions_error_cabinet":


    if($_SESSION['webuser']['internalKey']){
      $q = $modx->db->query('SELECT * FROM `new_question_2_user` q2u 
       LEFT JOIN `new_question` q ON q.id = q2u.question_id 
       WHERE q2u.user_id ="'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
      $count = 1;
      while($r = $modx->db->getRow($q)){
        $r['count'] = $count;
        if(in_array($r['id'], $_SESSION['favorite'])){
          $r['favorite'] = 'active';
        }else{
          $r['favorite'] = '';
        }
        /*
        $r['pdr_i'] = '';
        if($r['pdr'] != ''){
          $e_pdr = explode(',',$r['pdr']);
          foreach($e_pdr as $pdr_chapter){
            $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
            $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
          }
        }
        */
        if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
          $r['comment_call'] = 1;
        }else{
          $r['comment_call'] = 0;
        }
        $res .= $modx->parseChunk('tpl_questions_error', $r);
        $count++;
      }
      if($res == ''){
        $res = '<span class="error_test_load">Немає помилок</span>';
      }else{
        $modx->setPlaceholder('questions_error_btn',$modx->getChunk('tpl_questions_error_btn'));
      }
    }else{
      $res = '<span class="error_test_load">Для роботи над помилками авторизуйтесь на сайті</span>';
    }
  break;
  case "questions_error":

    if($_SESSION['webuser']['user_type'] == '1'){

      if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
        $chat_helper = $modx->getChunk('tpl_chat_why');
      }else{

      }

      if($_SESSION['webuser']['internalKey']){
        $q = $modx->db->query('SELECT * FROM `new_question_2_user` q2u 
         LEFT JOIN `new_question` q ON q.id = q2u.question_id 
         WHERE q2u.user_id ="'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
        $count = 1;
        while($r = $modx->db->getRow($q)){
          $r['count'] = $count;
          if($count == 1){
            $r['class'] = 'active';
          }else{
            $r['class'] = '';
          }
          if($r['image_new_2'] != '' AND $ravlik_photo){
            $r['image_official'] = $r['image_new_2'];
          }

          $r['answers_block'] = '';

          $answers = json_decode($r['answers'],true);
          if(is_array($answers)){
            foreach($answers as $answer_num => $answer){
              $r['answer_description'] = $answer['description'];
              $r['answer_num'] = $answer_num;
              $r['answers_block'] .= $modx->parseChunk('tpl_answer', $r);
            }
          }


          if(in_array($r['id'], $_SESSION['favorite'])){
            $r['favorite'] = 'active';
          }else{
            $r['favorite'] = '';
          }
          /*
          $r['pdr_i'] = '';
          if($r['pdr'] != ''){
            $e_pdr = explode(',',$r['pdr']);
            foreach($e_pdr as $pdr_chapter){
              $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
              $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
            }
          }
          */
          if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
            $r['comment_call'] = 1;
          }else{
            $r['comment_call'] = 0;
          }


          $r['chat_helper'] = $chat_helper;

          $res .= $modx->parseChunk('tpl_questions', $r);
          $navigation_questions .= $modx->parseChunk('tpl_navigation_questions', $r);
          $count++;
        }


        $modx->setPlaceholder('navigation_questions',$navigation_questions);

      }else{
        $res = '<span class="error_test_load">Помилка завантаження тесту</span>';
      }

    }else{
      $res = $modx->getChunk('tpl_questions_theory_premium_only'); 
    }


  break;
  case "questions_favorite_cabinet":

    $shop->getUserWishList();
    $favorite = $_SESSION['favorite'];
    if(is_array($favorite) AND count($favorite) > 0){
      $q = $modx->db->query('SELECT * FROM `new_question` WHERE id IN ('.$modx->db->escape(implode(',', $favorite)).') ');
      $count = 1;
      while($r = $modx->db->getRow($q)){
        $r['count'] = $count;
        if(in_array($r['id'], $_SESSION['favorite'])){
          $r['favorite'] = 'active';
        }else{
          $r['favorite'] = '';
        }
        /*
        $r['pdr_i'] = '';
        if($r['pdr'] != ''){
          $e_pdr = explode(',',$r['pdr']);
          foreach($e_pdr as $pdr_chapter){
            $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
            $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
          }
        }
        */
        if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
          $r['comment_call'] = 1;
        }else{
          $r['comment_call'] = 0;
        }
        $res .= $modx->parseChunk('tpl_questions_favorite', $r);
        $count++;
      }
      $modx->setPlaceholder('questions_favorite_btn',$modx->getChunk('tpl_questions_favorite_btn'));

      
    }else{
      $res = '<span class="error_test_load">Немає вибраних</span>';
    }
  break;
  case "questions_favorite":

    if($_SESSION['webuser']['user_type'] == '1'){

      if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
        $chat_helper = $modx->getChunk('tpl_chat_why');
      }else{

      }


      $shop->getUserWishList();
      $favorite = $_SESSION['favorite'];

      if(is_array($favorite) AND count($favorite) > 0){
        $q = $modx->db->query('SELECT * FROM `new_question` WHERE id IN ('.$modx->db->escape(implode(',', $favorite)).') ');
        $count = 1;
        while($r = $modx->db->getRow($q)){
          $r['count'] = $count;
          if($count == 1){
            $r['class'] = 'active';
          }else{
            $r['class'] = '';
          }
          if($r['image_new_2'] != '' AND $ravlik_photo){
            $r['image_official'] = $r['image_new_2'];
          }

          $r['answers_block'] = '';

          $answers = json_decode($r['answers'],true);
          if(is_array($answers)){
            foreach($answers as $answer_num => $answer){
              $r['answer_description'] = $answer['description'];
              $r['answer_num'] = $answer_num;
              $r['answers_block'] .= $modx->parseChunk('tpl_answer', $r);
            }
          }


          if(in_array($r['id'], $_SESSION['favorite'])){
            $r['favorite'] = 'active';
          }else{
            $r['favorite'] = '';
          }
          /*
          $r['pdr_i'] = '';
          if($r['pdr'] != ''){
            $e_pdr = explode(',',$r['pdr']);
            foreach($e_pdr as $pdr_chapter){
              $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
              $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
            }
          }
          */
          if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
            $r['comment_call'] = 1;
          }else{
            $r['comment_call'] = 0;
          }


          $r['chat_helper'] = $chat_helper;

          $res .= $modx->parseChunk('tpl_questions', $r);
          $navigation_questions .= $modx->parseChunk('tpl_navigation_questions', $r);
          $count++;
        }


        $modx->setPlaceholder('navigation_questions',$navigation_questions);

      }else{
        $res = '<span class="error_test_load">Помилка завантаження тесту</span>';
      }

    }else{
      $res = $modx->getChunk('tpl_questions_theory_premium_only'); 
    }
  break;
  case "questions_ticket":
    if($ticket == ''){
      $ticket = $modx->db->escape((int)$_GET['ticket']);
    }
    $modx->setPlaceholder('test',$ticket);


    if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
      $chat_helper = $modx->getChunk('tpl_chat_why');
    }else{

    }

    $check = $modx->db->getRow($modx->db->query('SELECT * FROM `new_question_ticket` WHERE id = "'.$modx->db->escape($ticket).'" LIMIT 1'));

    if($_SESSION['webuser']['user_type'] == '0' AND $check['premium'] == '1'){
      $res = '<span class="error_test_load">Помилка завантаження тесту</span>';
    }else{
      $statuses = array();
      if($ticket != '' AND $ticket != '0'){
        if($_SESSION['webuser']['internalKey']){
          $q_u = $modx->db->query('SELECT * FROM `new_ticket_2_user` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND ticket_id = "'.$modx->db->escape($ticket).'" ');
          while($r_u = $modx->db->getRow($q_u)){
            $statuses[$r_u['question_id']] = $r_u['answer_id'];
          }
        }

        $q = $modx->db->query('SELECT * FROM `new_question_2_ticket` q2t 
          LEFT JOIN `new_question` q ON q.id = q2t.question_id
          WHERE q2t.ticket_id = "'.$modx->db->escape($ticket).'"
          ORDER BY q2t.position ASC');
        $count = 1;
        $total_correct = 0;
        $total_incorrect = 0;
        while($r = $modx->db->getRow($q)){
          $nav_a_status = '';
          $r['count'] = $count;
          if($count == 1){
            $r['class'] = 'active';
          }else{
            $r['class'] = '';
          }
          if($r['image_new_2'] != '' AND $ravlik_photo){
            $r['image_official'] = $r['image_new_2'];
          }

          $r['answers_block'] = '';

          if(isset($statuses[$r['id']])){
            $answered = $statuses[$r['id']];
            $correct = $r['correct'];
            if($answered == $correct){
              $nav_a_status = 'correct';
              $total_correct++;
            }else{
              $nav_a_status = 'incorrect';
              $total_incorrect++;
            }

            $answers = json_decode($r['answers'],true);
            if(is_array($answers)){
              foreach($answers as $answer_num => $answer){
                $r['status_answered'] = '';
                $r['answer_description'] = $answer['description'];
                $r['answer_num'] = $answer_num;
                if($answer_num == $answered){
                  $r['status_answered'] = 'incorrect';
                }
                if($answer_num == $correct){
                  $r['status_answered'] = 'correct';
                }
                $r['answers_block'] .= $modx->parseChunk('tpl_answer_answered', $r);
              }
            }
            $r['class'] .= ' answered';
          }else{
            $answers = json_decode($r['answers'],true);
            if(is_array($answers)){
              foreach($answers as $answer_num => $answer){
                $r['answer_description'] = $answer['description'];
                $r['answer_num'] = $answer_num;
                $r['answers_block'] .= $modx->parseChunk('tpl_answer', $r);
              }
            }
          }


          if(in_array($r['id'], $_SESSION['favorite'])){
            $r['favorite'] = 'active';
          }else{
            $r['favorite'] = '';
          }
          /*
          $r['pdr_i'] = '';
          if($r['pdr'] != ''){
            $e_pdr = explode(',',$r['pdr']);
            foreach($e_pdr as $pdr_chapter){
              $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
              $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
            }
          }
          */
          if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
            $r['comment_call'] = 1;
          }else{
            $r['comment_call'] = 0;
          }

          $r['chat_helper'] = $chat_helper;


          $res .= $modx->parseChunk('tpl_questions', $r);
          if($nav_a_status != ''){ 
            $r['class'] .= ' '.$nav_a_status;
          }
          $navigation_questions .= $modx->parseChunk('tpl_navigation_questions', $r);
          $count++;
        }


        $modx->setPlaceholder('total_correct',$total_correct);
        $modx->setPlaceholder('total_incorrect',$total_incorrect);
        $modx->setPlaceholder('navigation_questions',$navigation_questions);

      }else{
        $res = '<span class="error_test_load">Помилка завантаження тесту</span>';
      }
    }
  break;
  case "questions_ticket_cabinet":
    $tickets = $modx->db->query('SELECT *, 
      (SELECT number FROM `new_question_ticket` qt WHERE qt.id = t2u.ticket_id LIMIT 1) as number,
      (SELECT name FROM `new_question_ticket` qt WHERE qt.id = t2u.ticket_id LIMIT 1) as name,
      (SELECT COUNT(question_id) FROM `new_question_2_ticket` WHERE ticket_id = t2u.ticket_id LIMIT 1) as questions,
      (SELECT COUNT(q.id) FROM `new_ticket_2_user` q WHERE q.ticket_id = t2u.ticket_id AND q.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND q.status = 1 LIMIT 1) as correct, 
      (SELECT COUNT(q.id) FROM `new_ticket_2_user` q WHERE q.ticket_id = t2u.ticket_id AND q.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND q.status = 0 LIMIT 1) as incorrect
      FROM `new_ticket_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" GROUP BY t2u.ticket_id ');
    if($modx->db->getRecordCount($tickets) > 0){
      while($r = $modx->db->getRow($tickets)){
        $r['ttl_done'] = $r['correct']+$r['incorrect'];
        $r['percent'] = round($r['ttl_done']/$r['questions']*100);
        if($r['percent'] > 30){
          $r['percent_margin'] = $r['percent'] - 5;
        }else{
          $r['percent_margin'] = $r['percent'];
        }
        $res .= $modx->parseChunk('tpl_test_nav_ticket_cabinet',$r);
      }
    }
    if($res == ''){
      $res = '<span class="error_test_load">Немає прогресу</span>';
    }
  break;
  case "questions_theme_cabinet":
    $themes = $modx->db->query('SELECT *, 
      (SELECT number FROM `new_question_theme` qt WHERE qt.id = t2u.theme_id LIMIT 1) as number,
      (SELECT name FROM `new_question_theme` qt WHERE qt.id = t2u.theme_id LIMIT 1) as name,
      (SELECT COUNT(question_id) FROM `new_question_2_theme` WHERE theme_id = t2u.theme_id LIMIT 1) as questions,
      (SELECT COUNT(q.id) FROM `new_theme_2_user` q WHERE q.theme_id = t2u.theme_id AND q.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND q.status = 1 LIMIT 1) as correct, 
      (SELECT COUNT(q.id) FROM `new_theme_2_user` q WHERE q.theme_id = t2u.theme_id AND q.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND q.status = 0 LIMIT 1) as incorrect
      FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" GROUP BY t2u.theme_id ');
    if($modx->db->getRecordCount($themes) > 0){
      while($r = $modx->db->getRow($themes)){
        $r['ttl_done'] = $r['correct']+$r['incorrect'];
        $r['percent'] = round($r['ttl_done']/$r['questions']*100);
        if($r['percent'] > 30){
          $r['percent_margin'] = $r['percent'] - 5;
        }else{
          $r['percent_margin'] = $r['percent'];
        }
        $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet',$r);
      }
    }
    if($res == ''){
      $res = '<span class="error_test_load">Немає прогресу</span>';
    }
  break;
  case "test_time":
    if($_SESSION['webuser']['internalKey'] != ''){
      switch($type){
        case "1":
          if($theme == ''){
            $theme = $modx->db->escape((int)$_GET['theme']);
          }
          $q = $modx->db->query('SELECT * FROM `new_theme_2_user_time` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND theme_id = "'.$modx->db->escape($theme).'" LIMIT 1');
        break;
        case "2":
          if($ticket == ''){
            $ticket = $modx->db->escape((int)$_GET['ticket']);
          }
          $q = $modx->db->query('SELECT * FROM `new_ticket_2_user_time` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND ticket_id = "'.$modx->db->escape($ticket).'" LIMIT 1');
        break;
        case "3":
          $doc_id = $modx->db->escape($modx->documentIdentifier);
          $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_category` WHERE doc_id = "'.$modx->db->escape($doc_id).'" LIMIT 1'));
          $category = $r['category_id'];
          $q = $modx->db->query('SELECT * FROM `new_category_2_user_time` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND category_id = "'.$modx->db->escape($category).'" LIMIT 1');
        break;
      }
      if($modx->db->getRecordCount($q) > 0){
        $r = $modx->db->getRow($q);
        $res = $r['usertime'];
      }else{
        $res = '00:00';
      }
    }else{
      $res = '00:00';
    }
    $modx->setPlaceholder('test_time',$res);
  break;
  case "questions_theme":
    if($theme == ''){
      $theme = $modx->db->escape((int)$_GET['theme']);
    }
    $modx->setPlaceholder('test',$theme);


    if($_SESSION['webuser']['user_type'] == '1' AND $_SESSION['webuser']['user_type_p'] == '1'){
      $chat_helper = $modx->getChunk('tpl_chat_why');
    }else{

    }

    if($theme != '' AND $theme != '0'){
      if($_SESSION['webuser']['internalKey']){
        $q_u = $modx->db->query('SELECT * FROM `new_theme_2_user` WHERE user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND theme_id = "'.$modx->db->escape($theme).'" ');
        while($r_u = $modx->db->getRow($q_u)){
          $statuses[$r_u['question_id']] = $r_u['answer_id'];
        }
      }

      $q = $modx->db->query('SELECT * FROM `new_question_2_theme` q2t 
        LEFT JOIN `new_question` q ON q.id = q2t.question_id
        WHERE q2t.theme_id = "'.$modx->db->escape($theme).'"
        ORDER BY q2t.position ASC');
      $count = 1;
      $total_correct = 0;
      $total_incorrect = 0;
      while($r = $modx->db->getRow($q)){

        $nav_a_status = '';
        $r['count'] = $count;
        if($count == 1){
          $r['class'] = 'active';
        }else{
          $r['class'] = '';
        }
        if($r['image_new_2'] != '' AND $ravlik_photo){
          $r['image_official'] = $r['image_new_2'];
        }

        $r['answers_block'] = '';

        if(isset($statuses[$r['id']])){
          $answered = $statuses[$r['id']];
          $correct = $r['correct'];
          if($answered == $correct){
            $nav_a_status = 'correct';
            $total_correct++;
          }else{
            $nav_a_status = 'incorrect';
            $total_incorrect++;
          }

          $answers = json_decode($r['answers'],true);
          if(is_array($answers)){
            foreach($answers as $answer_num => $answer){
              $r['status_answered'] = '';
              $r['answer_description'] = $answer['description'];
              $r['answer_num'] = $answer_num;
              if($answer_num == $answered){
                $r['status_answered'] = 'incorrect';
              }
              if($answer_num == $correct){
                $r['status_answered'] = 'correct';
              }
              $r['answers_block'] .= $modx->parseChunk('tpl_answer_answered', $r);
            }
          }
          $r['class'] .= ' answered';
        }else{
          $answers = json_decode($r['answers'],true);
          if(is_array($answers)){
            foreach($answers as $answer_num => $answer){
              $r['answer_description'] = $answer['description'];
              $r['answer_num'] = $answer_num;
              $r['answers_block'] .= $modx->parseChunk('tpl_answer', $r);
            }
          }
        }


        if(in_array($r['id'], $_SESSION['favorite'])){
          $r['favorite'] = 'active';
        }else{
          $r['favorite'] = '';
        }
        /*
        $r['pdr_i'] = '';
        if($r['pdr'] != ''){
          $e_pdr = explode(',',$r['pdr']);
          foreach($e_pdr as $pdr_chapter){
            $r2 = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE id = "'.$modx->db->escape($pdr_chapter).'" LIMIT 1'));
            $r['pdr_i'] .= $modx->parseChunk('tpl_pdr_i', $r2);
          }
        }
        */
        if($r['comment'] != '' OR ( $r['pdr'] != '0' AND $r['pdr'] != '') ){
          $r['comment_call'] = 1;
        }else{
          $r['comment_call'] = 0;
        }

        $r['chat_helper'] = $chat_helper;

        $res .= $modx->parseChunk('tpl_questions', $r);
        if($nav_a_status != ''){ 
          $r['class'] .= ' '.$nav_a_status;
        }
        $navigation_questions .= $modx->parseChunk('tpl_navigation_questions', $r);
        $count++;

      }

      $modx->setPlaceholder('total_correct',$total_correct);
      $modx->setPlaceholder('total_incorrect',$total_incorrect);
      $modx->setPlaceholder('navigation_questions',$navigation_questions);

    }else{
      $res = '<span class="error_test_load">Помилка завантаження тесту</span>';
    }
  break;
  case "category_program":

    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND published = "1" AND deleted = "0" ORDER BY menuindex ASC');
    $cnt = 0;
    while($r = $modx->db->getRow($q)){
      $tvres2 = $modx->getTemplateVar(
            $idname  = 'img_'.$modx->config['lang'],
            $fields = '*',
            $docid =  $r['id']
            );
      $r['img'] = $tvres2['value'];
      if($cnt == 1){
        $r['class'] = 'active';
      }else{
        $r['class'] = '';
      }
      $res .= $modx->parseChunk($tpl,$r);
      $nav .= $modx->parseChunk($tpl_nav,$r);
      $cnt++;
    }
    $modx->setPlaceholder('category_program_nav',$nav);
  break;
  case "test_theme_category":
    
    $doc_id = $modx->db->escape($modx->documentIdentifier);
    $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_category` WHERE doc_id = "'.$modx->db->escape($doc_id).'" LIMIT 1'));
    $category = $r['category_id'];
    $cnt = 1;
    if($_SESSION['webuser']['internalKey'] != ''){
      $tickets = $modx->db->query('SELECT *, qt.id as id,
        (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_theme` qt 
         LEFT JOIN `new_category_2_theme` c2t ON c2t.theme = qt.id
         LEFT JOIN `new_theme_2_user_time` t2ut ON t2ut.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2ut.theme_id = qt.id
         WHERE c2t.category = "'.$modx->db->escape($category).'" ORDER BY qt.position ASC
         ');



      $ttl_done = 0;
      $ttl_correct = 0;
      $ttl_incorrect = 0;
      $ttl_all = 0;
      $ttl_usertime = 0;
      $ttl_minutes = 0;
      $ttl_seconds = 0;
      if($modx->db->getRecordCount($tickets) > 0){
        while($r = $modx->db->getRow($tickets)){
          if($cnt == 1){
            $theme_id = $r['theme'];
          }
          $r['ttl_done'] = $r['correct']+$r['incorrect'];
          if($r['ttl_done'] > 0){
            $r['percent'] = round($r['ttl_done']/$r['questions']*100);
            $r['percent_correct'] = round($r['correct']/$r['ttl_done']*100);
            $r['percent_incorrect'] = round($r['incorrect']/$r['ttl_done']*100);
          }else{
            $r['percent'] = 0;
            $r['percent_correct'] = 0;
            $r['percent_incorrect'] = 0;
          }
          if($r['percent'] > 30){
            $r['percent_margin'] = $r['percent'] - 10;
          }else{
            $r['percent_margin'] = $r['percent'];
          }


          $ttl_done += $r['ttl_done'];
          $ttl_correct += $r['correct'];
          $ttl_incorrect += $r['incorrect'];
          $ttl_all += $r['questions'];
          if($r['usertime'] != '' AND $r['usertime'] != 0){
            $ms = explode(':',$r['usertime']);
            $ttl_minutes += $ms[0];
            $ttl_seconds += $ms[1];
          }
          if($_SESSION['webuser']['user_type'] == '1'){
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet',$r);
          }else{
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet_standart',$r);
          }
        }
        if($ttl_done > 0){
            $percent_all = round($ttl_done/$ttl_all*100);
            $percent_correct = round($ttl_correct/$ttl_done*100);
            $percent_incorrect = round($ttl_incorrect/$ttl_done*100);
        }else{
          $percent_all = 0;
          $percent_correct = 0;
          $percent_incorrect = 0;
        }
        if($ttl_seconds > 60){
          $apminutes = floor($ttl_seconds/60);
          $ttl_minutes = $ttl_minutes+$apminutes;
          $ttl_seconds = $ttl_seconds-$apminutes*60;
        }
        if($ttl_minutes > 0 OR $ttl_seconds > 0){
          $ttl_usertime = $ttl_minutes.':'.$ttl_seconds;
        }

        if($_SESSION['webuser']['user_type'] == '1'){
          $progress = $modx->parseChunk('tpl_progress_theme', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }else{
          $progress = $modx->parseChunk('tpl_progress_theme_standart', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }

        $modx->setPlaceholder('progress',$progress);
        $cnt++;
      }
    }else{
      $q = $modx->db->query('SELECT *, qt.id as id, (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions 
        FROM `new_question_theme` qt 
        LEFT JOIN `new_category_2_theme` c2t ON c2t.theme = qt.id
        WHERE c2t.category = "'.$modx->db->escape($category).'" ORDER BY qt.position ASC');
      while ($r = $modx->db->getRow($q)) {

          if($cnt == 1){
            $theme_id = $r['theme'];
          }
        $res .= $modx->parseChunk('tpl_test_nav_theme',$r);
        $cnt++;
      }
    }
    if($_SESSION['webuser']['internalKey'] == '' AND $theme_id != ""){


      $test_po_temam_top = $modx->parseChunk('tpl_test_po_temam_top', array('theme' => $theme_id));

      $modx->setPlaceholder('test_po_temam_top',$test_po_temam_top);
    }
    //$theme_id//
  break;
  case "test_theme_lection":



    if($_SESSION['webuser']['internalKey'] != ''){

      $tickets = $modx->db->query('SELECT *, qt.id as id,
        (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_theme` qt 
         LEFT JOIN `new_theme_2_user_time` t2ut ON t2ut.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2ut.theme_id = qt.id
         WHERE qt.id IN ('.$modx->db->escape($id).') ORDER BY qt.position ASC 
      ');

/*
      $tickets = $modx->db->query('SELECT *, 
        (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_theme` qt WHERE 1 = 1 ORDER BY qt.position ASC
         ');
         */
      $ttl_done = 0;
      $ttl_correct = 0;
      $ttl_incorrect = 0;
      $ttl_all = 0;
      $ttl_usertime = 0;
      $ttl_minutes = 0;
      $ttl_seconds = 0;
      if($modx->db->getRecordCount($tickets) > 0){
        while($r = $modx->db->getRow($tickets)){
          $r['ttl_done'] = $r['correct']+$r['incorrect'];
          if($r['ttl_done'] > 0){
            $r['percent'] = round($r['ttl_done']/$r['questions']*100);
            $r['percent_correct'] = round($r['correct']/$r['ttl_done']*100);
            $r['percent_incorrect'] = round($r['incorrect']/$r['ttl_done']*100);
          }else{
            $r['percent'] = 0;
            $r['percent_correct'] = 0;
            $r['percent_incorrect'] = 0;
          }
          if($r['percent'] > 30){
            $r['percent_margin'] = $r['percent'] - 10;
          }else{
            $r['percent_margin'] = $r['percent'];
          }
          $ttl_done += $r['ttl_done'];
          $ttl_correct += $r['correct'];
          $ttl_incorrect += $r['incorrect'];
          $ttl_all += $r['questions'];
          if($r['usertime'] != '' AND $r['usertime'] != 0){
            $ms = explode(':',$r['usertime']);
            $ttl_minutes += $ms[0];
            $ttl_seconds += $ms[1];
          }

          if($_SESSION['webuser']['user_type'] == '1'){
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet',$r);
          }else{
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet_standart',$r);
          }

        }
        if($ttl_done > 0){
            $percent_all = round($ttl_done/$ttl_all*100);
            $percent_correct = round($ttl_correct/$ttl_done*100);
            $percent_incorrect = round($ttl_incorrect/$ttl_done*100);
        }else{
          $percent_all = 0;
          $percent_correct = 0;
          $percent_incorrect = 0;
        }
        if($ttl_seconds > 60){
          $apminutes = floor($ttl_seconds/60);
          $ttl_minutes = $ttl_minutes+$apminutes;
          $ttl_seconds = $ttl_seconds-$apminutes*60;
        }
        if($ttl_minutes > 0 OR $ttl_seconds > 0){
          $ttl_usertime = $ttl_minutes.':'.$ttl_seconds;
        }
        if($_SESSION['webuser']['user_type'] == '1'){
          $progress = $modx->parseChunk('tpl_progress_theme', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }else{
          $progress = $modx->parseChunk('tpl_progress_theme_standart', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }
        $modx->setPlaceholder('progress',$progress);


      }
    }else{
      $q = $modx->db->query('SELECT *, (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions FROM `new_question_theme` qt WHERE qt.id IN ('.$modx->db->escape($id).') ORDER BY qt.position ASC');
      while ($r = $modx->db->getRow($q)) {
        $res .= $modx->parseChunk('tpl_test_nav_theme',$r);
      }
    }
  break;
  case "test_theme":
    if($_SESSION['webuser']['internalKey'] != ''){

      if(isset($_GET['category'])){
        $category_letter = $_GET['category'];
      }else{
        $category_letter = 'b';
      }
      $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_category` WHERE category_letter = "'.$modx->db->escape($category_letter).'" LIMIT 1'));
      $category = $r['category_id'];

      $tickets = $modx->db->query('SELECT *, qt.id as id,
        (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_theme` qt 
         LEFT JOIN `new_category_2_theme` c2t ON c2t.theme = qt.id
         LEFT JOIN `new_theme_2_user_time` t2ut ON t2ut.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2ut.theme_id = qt.id
         WHERE c2t.category = "'.$modx->db->escape($category).'" ORDER BY qt.position ASC
         ');

/*
      $tickets = $modx->db->query('SELECT *, 
        (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_theme_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.theme_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_theme` qt WHERE 1 = 1 ORDER BY qt.position ASC
         ');
         */
      $ttl_done = 0;
      $ttl_correct = 0;
      $ttl_incorrect = 0;
      $ttl_all = 0;
      $ttl_usertime = 0;
      $ttl_minutes = 0;
      $ttl_seconds = 0;
      if($modx->db->getRecordCount($tickets) > 0){
        while($r = $modx->db->getRow($tickets)){
          $r['ttl_done'] = $r['correct']+$r['incorrect'];
          if($r['ttl_done'] > 0){
            $r['percent'] = round($r['ttl_done']/$r['questions']*100);
            $r['percent_correct'] = round($r['correct']/$r['ttl_done']*100);
            $r['percent_incorrect'] = round($r['incorrect']/$r['ttl_done']*100);
          }else{
            $r['percent'] = 0;
            $r['percent_correct'] = 0;
            $r['percent_incorrect'] = 0;
          }
          if($r['percent'] > 30){
            $r['percent_margin'] = $r['percent'] - 10;
          }else{
            $r['percent_margin'] = $r['percent'];
          }
          $ttl_done += $r['ttl_done'];
          $ttl_correct += $r['correct'];
          $ttl_incorrect += $r['incorrect'];
          $ttl_all += $r['questions'];
          if($r['usertime'] != '' AND $r['usertime'] != 0){
            $ms = explode(':',$r['usertime']);
            $ttl_minutes += $ms[0];
            $ttl_seconds += $ms[1];
          }

          if($_SESSION['webuser']['user_type'] == '1'){
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet',$r);
          }else{
            $res .= $modx->parseChunk('tpl_test_nav_theme_cabinet_standart',$r);
          }

        }
        if($ttl_done > 0){
            $percent_all = round($ttl_done/$ttl_all*100);
            $percent_correct = round($ttl_correct/$ttl_done*100);
            $percent_incorrect = round($ttl_incorrect/$ttl_done*100);
        }else{
          $percent_all = 0;
          $percent_correct = 0;
          $percent_incorrect = 0;
        }
        if($ttl_seconds > 60){
          $apminutes = floor($ttl_seconds/60);
          $ttl_minutes = $ttl_minutes+$apminutes;
          $ttl_seconds = $ttl_seconds-$apminutes*60;
        }
        if($ttl_minutes > 0 OR $ttl_seconds > 0){
          $ttl_usertime = $ttl_minutes.':'.$ttl_seconds;
        }
        if($_SESSION['webuser']['user_type'] == '1'){
          $progress = $modx->parseChunk('tpl_progress_theme', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }else{
          $progress = $modx->parseChunk('tpl_progress_theme_standart', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }
        $modx->setPlaceholder('progress',$progress);


      }
    }else{
      $q = $modx->db->query('SELECT *, (SELECT count(question_id) FROM `new_question_2_theme` q2t WHERE q2t.theme_id = qt.id) as questions FROM `new_question_theme` qt WHERE 1 = 1 ORDER BY qt.position ASC');
      while ($r = $modx->db->getRow($q)) {
        $res .= $modx->parseChunk('tpl_test_nav_theme',$r);
      }
    }
  break;
  case "test_ticket":
    if($_SESSION['webuser']['internalKey'] != ''){
      $tickets = $modx->db->query('SELECT *, qt.id as id, qt.premium as premium,
        (SELECT count(question_id) FROM `new_question_2_ticket` q2t WHERE q2t.ticket_id = qt.id) as questions,
        (SELECT count(question_id) FROM `new_ticket_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.ticket_id = qt.id AND t2u.status = "1" LIMIT 1) as correct,
        (SELECT count(question_id) FROM `new_ticket_2_user` t2u WHERE t2u.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2u.ticket_id = qt.id AND t2u.status = "0" LIMIT 1) as incorrect
         FROM `new_question_ticket` qt 
         LEFT JOIN `new_ticket_2_user_time` t2ut ON t2ut.user_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" AND t2ut.ticket_id = qt.id
         WHERE 1 = 1 ORDER BY qt.position ASC
         ');
      $ttl_done = 0;
      $ttl_correct = 0;
      $ttl_incorrect = 0;
      $ttl_all = 0;
      $ttl_usertime = 0;
      $ttl_minutes = 0;
      $ttl_seconds = 0;
      if($modx->db->getRecordCount($tickets) > 0){
        while($r = $modx->db->getRow($tickets)){
          $r['ttl_done'] = $r['correct']+$r['incorrect'];
          if($r['ttl_done'] > 0){
            $r['percent'] = round($r['ttl_done']/$r['questions']*100);
            $r['percent_correct'] = round($r['correct']/$r['ttl_done']*100);
            $r['percent_incorrect'] = round($r['incorrect']/$r['ttl_done']*100);
          }else{
            $r['percent'] = 0;
            $r['percent_correct'] = 0;
            $r['percent_incorrect'] = 0;
          }
          if($r['percent'] > 30){
            $r['percent_margin'] = $r['percent'] - 10;
          }else{
            $r['percent_margin'] = $r['percent'];
          }
          $ttl_done += $r['ttl_done'];
          $ttl_correct += $r['correct'];
          $ttl_incorrect += $r['incorrect'];
          $ttl_all += $r['questions'];
          if($r['usertime'] != '' AND $r['usertime'] != 0){
            $ms = explode(':',$r['usertime']);
            $ttl_minutes += $ms[0];
            $ttl_seconds += $ms[1];
          }


          if($_SESSION['webuser']['user_type'] == '1'){
            $res .= $modx->parseChunk('tpl_test_nav_ticket_cabinet',$r);
          }else{
            if($r['premium'] == '1'){
              $res .= $modx->parseChunk('tpl_test_nav_ticket_cabinet_premium_only', $r);
            }else{
              $res .= $modx->parseChunk('tpl_test_nav_ticket_cabinet_standart',$r);
            }
          }
        }
        if($ttl_done > 0){
            $percent_all = round($ttl_done/$ttl_all*100);
            $percent_correct = round($ttl_correct/$ttl_done*100);
            $percent_incorrect = round($ttl_incorrect/$ttl_done*100);
        }else{
          $percent_all = 0;
          $percent_correct = 0;
          $percent_incorrect = 0;
        }
        if($ttl_seconds > 60){
          $apminutes = floor($ttl_seconds/60);
          $ttl_minutes = $ttl_minutes+$apminutes;
          $ttl_seconds = $ttl_seconds-$apminutes*60;
        }
        if($ttl_minutes > 0 OR $ttl_seconds > 0){
          $ttl_usertime = $ttl_minutes.':'.$ttl_seconds;
        }
        if($_SESSION['webuser']['user_type'] == '1'){
          $progress = $modx->parseChunk('tpl_progress_ticket', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }else{
          $progress = $modx->parseChunk('tpl_progress_ticket_standart', array('percent' => $percent_all, 'percent_correct' => $percent_correct, 'percent_incorrect' => $percent_incorrect, 'ttl_correct' => $ttl_correct, 'ttl_incorrect' => $ttl_incorrect, 'ttl_usertime' => $ttl_usertime));
        }

      $modx->setPlaceholder('progress',$progress);
    
      }
    }else{
      $q = $modx->db->query('SELECT *, (SELECT count(question_id) FROM `new_question_2_ticket` q2t WHERE q2t.ticket_id = qt.id) as questions FROM `new_question_ticket` qt WHERE 1 = 1 ORDER BY qt.position ASC');
      while ($r = $modx->db->getRow($q)) {
        if($r['premium'] == '1'){
          $res .= $modx->parseChunk('tpl_test_nav_ticket_cabinet_premium_only', $r);
        }else{
          $res .= $modx->parseChunk('tpl_test_nav_ticket',$r);
        }
      }
    }


  break;
  case "fine":
    $q = $modx->db->query('SELECT * FROM `new_pdr_fine` WHERE 1 = 1 ORDER BY sort ASC');
    while ($r = $modx->db->getRow($q)) {
      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "info":
    $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_info` WHERE id = "'.$modx->db->escape($id).'" LIMIT 1'));
    $res .= $modx->parseChunk($tpl,$r);
  break;
  case "road_marking_single_new":
    if($_GET['marking'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE `number` = "'.$modx->db->escape($_GET['marking']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r2 = $modx->db->getRow($q2);
        $res = $modx->parseChunk($tpl,$r2);
      }
    }

    if($res ==''){
      $res = '<div class="error_test_load">Знак не знайдено</div>';
    }
  break;
  case "road_marking_new":
    $count = 0;
    if(isset($_GET['markings']) AND $_GET['markings'] != ""){
      $search_type = ' AND id = "'.$modx->db->escape($_GET['markings']).'" ';
      $class = 'active';
    }
    $q = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1 '.$search_type.' ORDER BY id ASC');
    while ($r = $modx->db->getRow($q)) {
      $r['class'] = $class;
      $r['inner'] = '';
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE type = "'.$modx->db->escape($r['id']).'" ORDER BY id ASC');
      while ($r2 = $modx->db->getRow($q2)) {
        $r['inner'] .= $modx->parseChunk($tpl,$r2);
      }
      $res .= $modx->parseChunk($tpl_outer,$r);
      $count++;
    }
  break;
  case "road_marking":
    $count = 0;
    $q = $modx->db->query('SELECT * FROM `new_pdr_road_marking` WHERE 1 = 1 ORDER BY id ASC');
    while ($r = $modx->db->getRow($q)) {
      if($count == '0'){
        $r['class'] = 'active';
      }else{
        $r['class'] = '';
      }
      $r['inner'] = '';
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_marking_item` WHERE type = "'.$modx->db->escape($r['id']).'" ORDER BY id ASC');
      while ($r2 = $modx->db->getRow($q2)) {
        $r['inner'] .= $modx->parseChunk($tpl,$r2);
      }
      $res .= $modx->parseChunk($tpl_outer,$r);
      $nav .= $modx->parseChunk($tpl_nav,$r);
      $count++;
    }
    $modx->setPlaceholder('navigation', $nav);
  break;
  case "road_sign_single_new":
    if($_GET['sign'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE `number` = "'.$modx->db->escape($_GET['sign']).'" LIMIT 1');
      if($modx->db->getRecordCount($q2) > 0){
        $r2 = $modx->db->getRow($q2);
        $res = $modx->parseChunk($tpl,$r2);
      }
    }
    if($res == ''){
      $res = '<div class="error_test_load">Знак не знайдено</div>';
    }
  break;
  case "road_sign_new":
    $count = 0;
    if(isset($_GET['signs']) AND $_GET['signs'] != ""){
      $search_type = ' AND id = "'.$modx->db->escape($_GET['signs']).'" ';
      $class = 'active';
    }
    $q = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE 1 = 1 '.$search_type.' ORDER BY id ASC');
    while ($r = $modx->db->getRow($q)) {
      $r['class'] = $class;
      $r['inner'] = '';
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE type = "'.$modx->db->escape($r['id']).'" ORDER BY id ASC');
      while ($r2 = $modx->db->getRow($q2)) {
        $r['inner'] .= $modx->parseChunk($tpl,$r2);
      }
      $res .= $modx->parseChunk($tpl_outer,$r);
      $count++;
    }
  break;
  case "road_sign":
    $count = 0;
    $q = $modx->db->query('SELECT * FROM `new_pdr_road_sign` WHERE 1 = 1 ORDER BY id ASC');
    while ($r = $modx->db->getRow($q)) {
      if($count == '0'){
        $r['class'] = 'active';
      }else{
        $r['class'] = '';
      }
      $r['inner'] = '';
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE type = "'.$modx->db->escape($r['id']).'" ORDER BY id ASC');
      while ($r2 = $modx->db->getRow($q2)) {
        $r['inner'] .= $modx->parseChunk($tpl,$r2);
      }
      $res .= $modx->parseChunk($tpl_outer,$r);
      $nav .= $modx->parseChunk($tpl_nav,$r);
      $count++;
    }
    $modx->setPlaceholder('navigation', $nav);
  break;
  case "pdr_chapter_nav":
    $count = 0;
    $q = $modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE 1 = 1 ORDER BY id ASC');
    while ($r = $modx->db->getRow($q)) {
      $rname = explode('. ', $r['name']);
      $r['name'] = $rname[1];
      $res .= $modx->parseChunk($tpl,$r);
      $count++;
    }
  break;
  case "pdr_chapter_in_number":
    $count = 0;
    if($_GET['chapter'] != '' AND $_GET['number'] != ''){
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE chapter = "'.$modx->db->escape($_GET['chapter']).'" ');
      if($modx->db->getRecordCount($q2) > 0){
        $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE chapter = "'.$modx->db->escape($_GET['chapter']).'" LIMIT 1'));
   
        while ($r2 = $modx->db->getRow($q2)) {
          $prev = '';
          if($r2['number'] === $_GET['number']){
            $res .= $modx->parseChunk($tpl,$r2);
            $num = $count;
          }
          $count++;
        }

      }else{
        $res = '<div class="error_test_load">Розділ не знайдено</div>';
      }
    }else{
      $res = '<div class="error_test_load">Розділ не вказано</div>';
    }
  break;
  case "pdr_chapter_in":
    $count = 0;
    if($_GET['chapter'] != ''){



      $q2 = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE chapter = "'.$modx->db->escape($_GET['chapter']).'" ');
      if($modx->db->getRecordCount($q2) > 0){

        $r = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE chapter = "'.$modx->db->escape($_GET['chapter']).'" LIMIT 1'));

        //prev
        if($r['chapter'] > '1'){
          $rp = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE chapter = "'.$modx->db->escape($_GET['chapter']-1).'" LIMIT 1'));
          $prev = $modx->parseChunk('tpl_pdr_chapter_item_nav_prev',$rp);
        }else{
          $prev = '<span></span>';
        }
        //next
        if($r['chapter'] < '34'){
          $rn = $modx->db->getRow($modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE chapter = "'.$modx->db->escape($_GET['chapter']+1).'" LIMIT 1'));
          $next = $modx->parseChunk('tpl_pdr_chapter_item_nav_next',$rn);
        }else{
          $next = '<span></span>';
        }
        $modx->setPlaceholder('chapter_prev',$prev);
        $modx->setPlaceholder('chapter_next',$next);

        while ($r2 = $modx->db->getRow($q2)) {
          $res .= $modx->parseChunk($tpl,$r2);
        }
      }else{
      $res = '<div class="error_test_load">Розділ не знайдено</div>';
      }
    }else{
      $res = '<div class="error_test_load">Розділ не вказано</div>';
    }
  break;
  case "pdr_chapter":
    $count = 0;
    $q = $modx->db->query('SELECT * FROM `new_pdr_chapter` WHERE 1 = 1 ORDER BY id ASC');
    while ($r = $modx->db->getRow($q)) {
      if($count == '0'){
        //$r['class'] = 'active';
        $r['class'] = '';
      }else{
        $r['class'] = '';
      }
      $rname = explode('. ', $r['name']);
      $r['name'] = $rname[1];
      $r['inner'] = '';
      $q2 = $modx->db->query('SELECT * FROM `new_pdr_chapter_item` WHERE chapter = "'.$modx->db->escape($r['chapter']).'" ORDER BY id ASC');
      while ($r2 = $modx->db->getRow($q2)) {
        $r['inner'] .= $modx->parseChunk($tpl,$r2);
      }
      $res .= $modx->parseChunk($tpl_outer,$r);
      $nav .= $modx->parseChunk($tpl_nav,$r);
      $count++;
    }
    $modx->setPlaceholder('navigation', $nav);
  break;
  case "inner":
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" ORDER BY menuindex ASC');
    while ($r = $modx->db->getRow($q)) {
      $tvres2 = $modx->getTemplateVar(
            $idname  = 'img_'.$modx->config['lang'],
            $fields = '*',
            $docid =  $r['id']
            );
      $r['img'] = $tvres2['value'];
      $res .= $modx->parseChunk($tpl,$r);
    }
  break; 
  case "inner_2":
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE parent = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" ORDER BY menuindex ASC');
    while ($r = $modx->db->getRow($q)) {
      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "full_block":
    $q = $modx->db->query('SELECT * '.$lang_content.' FROM `modx_site_content` WHERE id = "'.$modx->db->escape($id).'" AND deleted = "0" AND published = "1" ORDER BY menuindex ASC');
    while ($r = $modx->db->getRow($q)) {
      $tvres2 = $modx->getTemplateVar(
            $idname  = 'img_'.$modx->config['lang'],
            $fields = '*',
            $docid =  $r['id']
            );
      $r['img'] = $tvres2['value'];
      $res .= $modx->parseChunk($tpl,$r);
    }
  break;
  case "gallery":
    $r = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_site_tmplvar_contentvalues` WHERE contentid = "'.$modx->db->escape($id).'" AND tmplvarid = "53" '));
    $gallery = json_decode($r['value'],true);
    if(count($gallery['fieldValue'])>0){
      $gallery['fieldValue'] = array_reverse($gallery['fieldValue']);
      foreach ($gallery['fieldValue'] as $key => $image) {
      
        $r['img'] = $image['image'];
        $res .= $modx->parseChunk($tpl,$r);
      }
    }
  break;
  case "breadcrumbs":
    $id             = isset($id) ? $id : $modx->documentIdentifier;
    $showHomeCrumb  = isset($showHomeCrumb) ? $showHomeCrumb : true;
    $showLastCrumb  = isset($showLastCrumb) ? $showLastCrumb : true;
    $showHidden     = isset($showHidden) ? $showHidden : true;
    $separator      = isset($separator) ? $separator : '<li class="separator"><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.14258 17L13.9997 10.1429L7.14258 3.28571" stroke="#D7D7D7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></li>';
    $lastAsLink     = 0;
    $title          = isset($title) ? $title : 'pagetitle';
    $lastCrumbClass = "active";
    $documents      = Array();
    $outerTpl      = '<ul class="breadcrumbs" itemscope="" itemtype="http://schema.org/BreadcrumbList">[+crumbs+]</ul>';
    $crumbTpl      = '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="'.$exp_sitestart.'[~~[+url+]~~]" itemprop="item"><span itemprop="name">[+title+]</span></a><meta itemprop="position" content="[+num+]" /></li>'.$separator.'';
    $shopTpl       = '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a href="'.$exp_sitestart.'[~~[+url+]~~]" itemprop="item"><span itemprop="name">[+title+]</span></a><meta itemprop="position" content="[+num+]" /></li>'.$separator.'';    
    $lastCrumbTpl  = '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="active"><meta content="'.$exp_sitestart.'[~~[+url+]~~]" itemprop="item"><span itemprop="name">[+title+]</span><meta itemprop="position" content="[+num+]" /></li>';
    $shoplastTpl   = '<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem" class="active"><meta content="'.$exp_sitestart.'[+url+]" itemprop="item"><span itemprop="name">[+title+]</span><meta itemprop="position" content="[+num+]" /></li>';    
  
    if ($showHomeCrumb) $documents[] = $modx->getConfig('site_start');
    $documents     = array_merge($documents, array_reverse(array_values($modx->getParentIds($id))));
    if ($showLastCrumb) $documents[] = $id;
    if($name != ''){
      $documents[] = '193';
    }
    $document      = implode(',', $documents);
    $fields        = $modx->config['lang_enable'] ? "pagetitle_".$modx->config['lang']." as 'pagetitle', menutitle_".$modx->config['lang']." as 'menutitle'" : "pagetitle, menutitle";
    $query         = "select 
                            id, $fields
                      from `modx_site_content`
                      where id in (".$document.") ".($showHidden ? "" : "and hidemenu = 0")."
                      order by field(id, ".$document.")";

    $crumbs        =   $modx->db->makeArray($modx->db->query($query));

    if(isset($_GET['ticket']) OR isset($_GET['theme']) OR isset($_GET['test']) OR isset($_GET['chapter']) OR isset($_GET['signs']) OR isset($_GET['markings']) OR isset($_GET['sign']) OR isset($_GET['marking'])){
      $crumbs[] = end($crumbs);
    }

    $cnt = count($crumbs);
    $count = 1;

    foreach($crumbs as $crkey => $crumb){
      if($crumb['id'] == '1'){
        $parse[] = strtr($crumbTpl,
                         Array("[+url+]"   => $crumb['id'],
                               "[+num+]"   => $count,
                               "[+title+]" => $crumb['pagetitle']));



      }else{
        if($count == $cnt){
          if(isset($name)){
          $parse[] = strtr($lastCrumbTpl,
                           Array("[+url+]"   => $crumb['id'],
                                 "[+num+]"   => $count,
                                 "[+title+]" => $name));
          }else{
          $parse[] = strtr($lastCrumbTpl,
                           Array("[+url+]"   => $crumb['id'],
                                 "[+num+]"   => $count,
                                 "[+title+]" => $modx->documentObject['pagetitle']));
          }
        }else{
          $parse[] = strtr($crumbTpl,
                           Array("[+url+]"   => $crumb['id'],
                                 "[+num+]"   => $count,
                                 "[+title+]" => $crumb['pagetitle']));
        }


     
      }
      $count++;
    }


    $res = str_replace("[+crumbs+]", implode("", $parse), $outerTpl);

  break;
  case "telegram_connector":
    $q = $modx->db->query('SELECT * FROM `modx_a_telegram` WHERE modx_id = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" LIMIT 1');
    if($modx->db->getRecordCount($q) > 0){
      $r = $modx->db->getRow($q);
      $res = $modx->parseChunk($tpl_unreg,$r);
    }else{
      $res = $modx->getChunk($tpl_reg);
    }
  break;
  case "telegram_login":
    function checkTelegramAuthorization($auth_data,$token) {
      $check_hash = $auth_data['hash'];
      unset($auth_data['hash']);
      $data_check_arr = [];
      foreach ($auth_data as $key => $value) {
        $data_check_arr[] = $key . '=' . $value;
      }
      sort($data_check_arr);
      $data_check_string = implode("\n", $data_check_arr);
      $secret_key = hash('sha256', $token, true);
      $hash = hash_hmac('sha256', $data_check_string, $secret_key);

      if (strcmp($hash, $check_hash) !== 0) {
        return false;
      }
      if ((time() - $auth_data['auth_date']) > 86400) {
        return false;
      }
      return true;
    }
    unset($_GET['stay'],$_GET['lang'],$_GET['q'],$_GET['p']);
    $token = '6911261249:AAFrguBPMSILbXnGVytHWjeJ1_gnnGdZGNs';
    $check = checkTelegramAuthorization($_GET,$token);
    if($check){
      $data = $_GET;
      if($_SESSION['webuser']['internalKey'] != ''){
        $check_connect = $modx->db->query('SELECT * FROM `modx_a_telegram` WHERE telegram_id = "'.$modx->db->escape($data['id']).'" LIMIT 1');
        if($modx->db->getRecordCount($check_connect) > 0){
          $res = $modx->parseChunk('tpl_socregerror_t',array('text' => 'Телеграм бот вже підключено до акаунту ПДР онлайн'));
        }else{
          if($data['last_name'] == ''){
            $data['last_name'] = '';
          }
          if($data['username'] == ''){
            $data['username'] = '';
          }
          $res = $modx->parseChunk('tpl_registration_tg',$data);
        }
      }else{
        $res = $modx->getChunk('tpl_socregerror');
      }
    }else{
      $res = $modx->getChunk('tpl_socregerror');
    }
  break;
  case "registration_soc":
    if ($modx->documentIdentifier == '108'){
      if (isset($_GET['code'])) {
        switch ($_GET['provider']) {
          case 'fb':
            //FACEBOOK 
          /*

                'client_id'     => '555499551516919',
                'client_secret' => 'd5a2f303fe755daea979905e5e17b583',
          */

            require_once MODX_BASE_PATH.'assets/shop/php/auth/lib/SocialAuther/autoload.php';
            $facebookAdapterConfig = array(
                'client_id'     => '382069424180088',
                'client_secret' => 'a81624b47f48f5bce170ccf649c6bbc4',
                'redirect_uri'  => $modx->config['site_url_b'].$modx->makeUrl('108').'?provider=fb'
            );
            $facebookAdapter = new SocialAuther\Adapter\Facebook($facebookAdapterConfig);
            $auther = new SocialAuther\SocialAuther($facebookAdapter);

            if ($auther->authenticate()) {
                
                    
              $check = $shop->check_fb($auther->getSocialId());
              if($check['ack']){
                //автологин
                $modx->runSnippet("Auth", Array("email" => $check['email'], "autologin" => true));
                $modx->sendRedirect($modx->makeUrl('83'));
                die;
              }else{
                //регистрация
                $name = explode(' ', $auther->getName());
                $reg_fb['fullname'] = $name[0];
                $reg_fb['lastname'] = $name[1];
                $reg_fb['fb_id']    = $auther->getSocialId();
                $reg_fb['fb_link']  = 'https://www.facebook.com/profile.php?id='.$auther->getSocialId();
                $res = $modx->parseChunk('tpl_registration_fb',$reg_fb);
              }
              
            }else{
              $res = $modx->getChunk('tpl_socregerror');
            }
          break;
          case 'gp':
            //GOOGLE 
            require_once MODX_BASE_PATH.'assets/shop/php/auth/lib/SocialAuther/autoload.php';
            $googleAdapterConfig = array(
                'client_id'     => '1048089879163-if34tjqkqit358kocvth05gl27fevss6.apps.googleusercontent.com',
                'client_secret' => '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',
                'redirect_uri'  => $modx->config['site_url_b'].$modx->makeUrl('108').'?provider=gp'
            );
            $googleAdapter = new SocialAuther\Adapter\Google($googleAdapterConfig);
            $auther = new SocialAuther\SocialAuther($googleAdapter);

            if ($auther->authenticate()) {
                
              $check = $shop->check_gp($auther->getSocialId());
              if($check['ack']){
                //автологин
                $modx->runSnippet("Auth", Array("email" => $check['email'], "autologin" => true));
                $modx->sendRedirect($modx->makeUrl('83'));
                die;
              }else{
                if($_SESSION['webuser']['internalKey'] != ''){
                  $modx->db->query('UPDATE `modx_web_user_attributes` SET gp_id = "'.$modx->db->escape($auther->getSocialId()).'" WHERE internalKey = "'.$modx->db->escape($_SESSION['webuser']['internalKey']).'" ');
                  $res = $modx->getChunk('tpl_socconnected');
                }else{
                  //регистрация
                  //email  link id
                  $name = explode(' ', $auther->getName());
                  $reg_gp['fullname'] = $name[0];
                  $reg_gp['lastname'] = $name[1];
                  $reg_gp['email']    = $auther->getEmail();
                  $reg_gp['gp_id']    = $auther->getSocialId();
                  $reg_gp['gp_link']  = $auther->getSocialPage();
                  $res = $modx->parseChunk('tpl_registration_gp',$reg_gp);
                }
              }
              
            }else{
              $res = $modx->getChunk('tpl_socregerror');
            }
          break;    
          default:

            $res = $modx->getChunk('tpl_socregerror');
          break;
        }

      }else{
        $res = $modx->getChunk('tpl_socregerror');
      }
 
  }else{
    $res = $modx->getChunk('tpl_socregerror');
  }

  break;
  case "soc_link":
    switch ($type) {
      case "fb":
        require_once MODX_BASE_PATH.'assets/shop/php/auth/lib/SocialAuther/autoload.php';
        $facebookAdapterConfig = array(
            'client_id'     => '382069424180088',
            'client_secret' => 'a81624b47f48f5bce170ccf649c6bbc4',
            'redirect_uri'  => $modx->config['site_url_b'].$modx->makeUrl('108').'?provider=fb'
        );
        $facebookAdapter = new SocialAuther\Adapter\Facebook($facebookAdapterConfig);
        $auther = new SocialAuther\SocialAuther($facebookAdapter);
        $res = $auther->getAuthUrl();
      break;
      case "gp":
        require_once MODX_BASE_PATH.'assets/shop/php/auth/lib/SocialAuther/autoload.php';
        $googleAdapterConfig = array(
            'client_id'     => '1048089879163-if34tjqkqit358kocvth05gl27fevss6.apps.googleusercontent.com',
            'client_secret' => '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',
            'redirect_uri'  => $modx->config['site_url_b'].$modx->makeUrl('108').'?provider=gp'
        );
        $googleAdapter = new SocialAuther\Adapter\Google($googleAdapterConfig);
        $auther = new SocialAuther\SocialAuther($googleAdapter);
        $res = str_replace(' ', '%20', $auther->getAuthUrl());
      break;
    }
    
  break;
  case "test_po_biletam_top":
    if($_SESSION['webuser']['internalKey'] == ''){
      $res = $modx->getChunk('test_po_biletam_top');
    }
  break;
  case "test_po_biletam":
    if(isset($_GET['ticket'])){
      $res = $modx->getChunk('test_po_biletam_in');
    }else{
      $res = $modx->getChunk('test_po_biletam');
    }
  break;
  case "test_po_temam_top":
    if($_SESSION['webuser']['internalKey'] == ''){
      $res = $modx->getChunk('test_po_temam_top');
    }
  break;
  case "test_po_temam":
    if(isset($_GET['theme'])){
      $res = $modx->getChunk('test_po_temam_in');
    }else{
      $res = $modx->getChunk('test_po_temam');
    }
  break;
  case "test_po_pomulkam":
    if($_SESSION['webuser']['user_type'] == '1'){
      if(isset($_GET['test'])){
        $res = $modx->getChunk('test_po_pomulkam_in');
      }else{
        $res = $modx->getChunk('test_po_pomulkam');
      }
    }else{
      $res = $modx->getChunk('test_po_pomulkam_premium_only');
    }
  break;
  case "test_po_vubranim":
    if($_SESSION['webuser']['user_type'] == '1'){
      if(isset($_GET['test'])){
        $res = $modx->getChunk('test_po_vubranim_in');
      }else{
        $res = $modx->getChunk('test_po_vubranim');
      }
    }else{
      $res = $modx->getChunk('test_po_vubranim_premium_only');
    }
  break;
  case "pdr":
    if(isset($_GET['chapter'])){
      if(isset($_GET['number'])){
        $res = $modx->getChunk('pdr_in_number');
      }else{
        $res = $modx->getChunk('pdr_in');
      }
    }else{
      $res = $modx->getChunk('pdr');
    }
  break;
  case "get_road_sign":
    if(isset($_GET['sign'])){
      $res = $modx->getChunk('road_sign_in');
    }else{
      $res = $modx->getChunk('road_sign');
    }
  break;
  case "get_road_marking":
    if(isset($_GET['marking'])){
      $res = $modx->getChunk('road_marking_in');
    }else{
      $res = $modx->getChunk('road_marking');
    }
  break;

  case "item_recalls":

    $query = "
        SELECT 
          *
        FROM `modx_a_recall`
        WHERE recall_moderated = 1 and recall_content = '".$modx->db->escape($instructor_id)."' AND recall_type = '2'
        ORDER BY recall_pub_date DESC";
      $recalls = $modx->db->query($query);

      $count = $modx->db->getRecordCount($recalls);
      while ($p = $modx->db->getRow($recalls)){ 
        unset($mark);
        $stars = $p['recall_mark'];
        $stars_all += $stars;
        for($i=1;$i<=5;$i++){
          if($i <= $stars){
            $class = 'class="review_star_list_active"';
          }else{
            $class = '';
          }
          $mark .= $modx->parseChunk('tpl_star', array('class' => $class));
        }
        $p['mark'] = $mark;

        if($p['recall_mark'] > 2){
          $rating_positive++;
        }else{
          $rating_negative++;
        }
        $p['recall_date'] = date('d.m.Y', strtotime($p['recall_pub_date']));

        $p['recall_text'] = str_replace('
', '</br>',$p['recall_text']);
        $p['recall_answer'] = str_replace('
', '</br>',$p['recall_answer']);
        $res .= $modx->parseChunk($tpl, $p);
      }
      $modx->setPlaceholder("recalls_count", $count);

      if($res == ''){
        $res = $modx->getChunk($tpl_empty);
      }

  case 'instructor_recalls':
    $query = "
        SELECT 
          *
        FROM `modx_a_recall`
        WHERE recall_moderated = 1 and recall_content = '".$modx->db->escape($instructor_id)."' AND recall_type = '1'
        ORDER BY recall_pub_date DESC";
      $recalls = $modx->db->query($query);

      $count = $modx->db->getRecordCount($recalls);
      while ($p = $modx->db->getRow($recalls)){ 
        unset($mark);
        $stars = $p['recall_mark'];
        $stars_all += $stars;
        for($i=1;$i<=5;$i++){
          if($i <= $stars){
            $class = 'class="review_star_list_active"';
          }else{
            $class = '';
          }
          $mark .= $modx->parseChunk('tpl_star', array('class' => $class));
        }
        $p['mark'] = $mark;

        if($p['recall_mark'] > 2){
          $rating_positive++;
        }else{
          $rating_negative++;
        }
        $p['recall_date'] = date('d.m.Y', strtotime($p['recall_pub_date']));

        $p['recall_text'] = str_replace('
', '</br>',$p['recall_text']);
        $p['recall_answer'] = str_replace('
', '</br>',$p['recall_answer']);
        $res .= $modx->parseChunk($tpl, $p);
      }
      $modx->setPlaceholder("recalls_count", $count);

      if($res == ''){
        $res = $modx->getChunk($tpl_empty);
      }
  break;


  case "catalog_instructor":
  
    if($school != '' AND $school != '0'){

        switch($transmission){
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

      $q = $modx->db->query('SELECT * FROM `modx_a_products` p WHERE p.product_visible = "1" AND p.product_to_instructor = "1" AND p.product_to_school = "'.$modx->db->escape($school).'" '.$search_transmission.' ');
      while($r = $modx->db->getRow($q)){
        $r['product_name_seo'] = str_replace('"','',$r['product_name']);
        $r['product_url'] = $modx->makeUrl($modx->documentIdentifier).$r['product_url'].'/';
        $r['product_top'] = $shop->getProductTop($r['product_top']);
        if($r['product_lesson'] == '1' AND $_GET['lessons'] != ''){
          $r['lessons'] = (int)$_GET['lessons'];
        }else{
          $r['lessons'] = 1;
        }
        $inner .= $modx->parseChunk($tpl,$r);
      }  
      if($inner != ''){
        $modx->setPlaceholder('catalog_nav',$modx->getChunk($tpl_nav));
        $res = $modx->parseChunk($tpl_outer,array('inner' => $inner));
      }
    }
  break;
  case "catalog":

    $uncheck = array();
    if(isset($_REQUEST['load_more']) AND $_REQUEST['load_more'] != ''){
      $page = $_REQUEST['load_more']*$limit;
    }else{
      $page = ($_GET['p'] != 1) ? ($shop->number($_GET['p'])-1) * $limit: 0;
      if($page == -1){
        $page = 0;
      }
    }
    $type = ' AND p.product_main_cat = "'.$modx->db->escape($modx->documentIdentifier).'"  ';
    if(isset($_GET['type'])){
      if($_GET['type'] != ''){
        $type = 'AND (p.product_main_cat IN ("'.$modx->db->escape($_GET['type']).'") OR FIND_IN_SET("'.$modx->db->escape($_GET['type']).'",p.product_main_cat) )';
        $uncheck['type'] = $shop->getTrval('type',$_GET['type']);
      }
    }
    if($exclude != ''){
      $exclude_pro = 'AND p.product_id NOT IN ('.$modx->db->escape($exclude).')';
    }
    //SEARCH
    if($_GET['s'] != ''){
      $_REQUEST['s'] = $_GET['s'];
    }
    $search = strip_tags($_REQUEST['s']);  
    if($search != '' AND !is_array($search))  {
      if(mb_strlen($search,'UTF-8') > 1){  
        $s = $modx->db->escape($search);
        $where[] = "(p.product_name LIKE '%$s%' OR p.product_article LIKE '%$s%' )";
        $where  = implode(" OR ", $where);
        $where  = ' AND ( '.$where.' )';
        $modx->setPlaceholder('search_text', $search);
        $uncheck['search'] = $search;
      }
    }    

    switch ($_GET['sort']) {
        case 'new':       $sort = "ORDER BY p.product_created DESC "; break;
        case 'cheap':     $sort = "ORDER BY p.product_price ASC"; break;
        case 'expensive': $sort = "ORDER BY p.product_price DESC"; break;
        case 'hit':       $sort = "ORDER BY p.product_hit DESC"; break;
        case 'default':   $sort = "ORDER BY p.product_position ASC"; break;
        default:          $sort = "ORDER BY p.product_position ASC"; break;
    }

    $limitation = "LIMIT ".$page.", ".$limit;
    $q = $modx->db->query('SELECT SQL_CALC_FOUND_ROWS * FROM `modx_a_products` p
      WHERE 
      p.product_visible = "1" 
      '.$type.'
      '.$where.'
      '.$exclude_pro.'
      '.$sort.'
      '.$limitation.' ');
    $pages = $modx->db->getRow($modx->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
    while($r = $modx->db->getRow($q)){
      $r['product_name_seo'] = str_replace('"','',$r['product_name']);
      $r['product_url'] = $modx->makeUrl($modx->documentIdentifier).$r['product_url'].'/';
      $r['product_top'] = $shop->getProductTop($r['product_top']);
      $res .= $modx->parseChunk($tpl,$r);
    }  
    $modx->setPlaceholder("max_items", $pages['cnt']);
    $modx->setPlaceholder("limit_items", $limit);

    if($res == ''){
      $res = $modx->getChunk('tpl_product_not_found');
      $load_more = '';
    }else{
      if($limit < $pages['cnt']){
        $load_more = $modx->parseChunk('tpl_load_more',array('type' => '2'));
      }else{
        $load_more = '';
      }
    }
    $modx->setPlaceholder("load_more", $load_more);
  break;
}