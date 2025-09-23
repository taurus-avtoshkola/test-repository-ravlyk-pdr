<?php
if (!class_exists('Shop')) {
  /**
   * Class Shop
   */
  class Shop  {
    var $modx = null;
    var $db   = null;

    function __construct ($modx){
      $this->modx = $modx;
      $this->db   = $modx->db;
    }

    function makeMirrorPic($fileImg, $newFile){
        // загружаем картинку
        $source = imagecreatefromjpeg($fileImg);
        // получаем размеры картинки
        $size = getimagesize($fileImg);
        // создаем новое изображение
        $img = imagecreatetruecolor($size[0], $size[1]);
        // наносим попиксельно изображение в обратном порядке
        for ($x = 0; $x < $size[0]; $x++) {
            for ($y = 0; $y < $size[1]; $y++) {
                $color=imagecolorat($source, $x,$y);

                imagesetpixel($img, $size[0]-$x, $y, $color);
            }
        }
        for ($y = 0; $y<= $size[1]; $y++){
          imagesetpixel($img, 0, $y, 16777215);
        }
        // сохраняем изображение
        imagejpeg($img, $newFile);
        // очищаем память
        imagedestroy($img);
    }

    function d ($var) {
      echo "<pre>";
      var_dump($var);
      echo "</pre>";
    }

    function go($url){
      header("Location: ".$url);
      die;
    }

    function debug ($var) {
      $this->d($var);
    }

    function sanitar ($var) {
        return $this->db->escape(strip_tags($var));
    }

    function number ($var) {
        // echo "NUMBER";
        return preg_replace('/\D+/i', '', $var);
    }
  
    function sms_send($to,$text){

      $to = str_replace('+38', '', $to);
      $to = str_replace('+3', '', $to);
      $to = str_replace(' ', '', $to);
      $to = trim($to);
      // Все данные возвращаются в кодировке UTF-8 
      header ('Content-type: text/html; charset=utf-8'); 
      // Подключаемся к серверу 
      $client = new SoapClient ('http://turbosms.in.ua/api/wsdl.html'); 
      // Данные авторизации 
      $auth = Array ( 
        'login' => $this->modx->config['sms_login'], 
        'password' => $this->modx->config['sms_password'] 
        ); 
      
      // Авторизируемся на сервере 
      $result = $client->Auth ($auth); 

      // Результат авторизации 
      /*
      echo $result->AuthResult . '
      '; 
      */
      // Получаем количество доступных кредитов 
      /*
      $result = $client->GetCreditBalance (); 
      echo $result->GetCreditBalanceResult . '
      '; 
      */

      //$text = iconv ('windows-1251', 'utf-8', $text); 

      $sms = Array ( 
        'sender' => $this->modx->config['sms_user'], 
        'destination' => '+38'.$to, 
        'text' => $text 
        ); 

      // Отправляем сообщение на один номер. 
      // Подпись отправителя может содержать английские буквы и цифры. Максимальная длина - 11 символов. 
      // Номер указывается в полном формате, включая плюс и код страны 
      $result = $client->SendSMS ($sms); 

      // Отправляем сообщение с WAPPush ссылкой 
      /*
      $sms = Array ( 
      'sender' => 'Rassilka', 
      'destination' => '+380XXXXXXXXX', 
      'text' => $text, 
      'wappush' => 'http://super-site.com' 
      ); 
      */


    }



    function grab_image($url,$saveto){

        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($ch);
        curl_close ($ch);
        if(file_exists($saveto)){
            unlink($saveto);
        }
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    }

    function get_page($url) {
      $ch     = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
      $result = curl_exec($ch);
      curl_close ($ch);
      return $result;
    }
    function get_page_no_follow($url) {
      $ch     = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0); // следовать за редиректами
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36");
      $result = curl_exec($ch);
      curl_close ($ch);
      return $result;
    }
   
    function get_city($ip){
      $json = $this->get_page('http://api.sypexgeo.net/json/'.$ip);
      $page = json_decode($json);
      $padeg = $this->morpher($page->city->name_ru,'В');
      return $padeg;
    }
    function morpher($word,$p) {
      $word = str_replace(' ', '%20', $word);
      $body = $this->get_page('http://api.morpher.ru/WebService.asmx/GetXml?s='.$word);
      if($body){
        //var_dump('http://api.morpher.ru/WebService.asmx/GetXml?s='.$word);die;
        $xml = simplexml_load_string($body);
        $json = json_encode($xml);
        $array = json_decode($json,TRUE);
        return $array[$p];
      }
    }

    function gen_pass ($max = 12) {
        $chars = "qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP";
        $size  = StrLen($chars)-1; 
        $pass  = null; 
        while ($max--) $pass .= $chars[rand(0,$size)];
        return $pass;
    }

    function clearCache() {
      // global $modx;
      include_once MODX_BASE_PATH . "manager/processors/cache_sync.class.processor.php";
      $sync = new synccache();
      $sync->setCachepath(MODX_BASE_PATH . "assets/cache/");
      $sync->setReport(false);
      $sync->emptyCache(); // first empty the cache
      $this->modx->getSettings();
    }
    function generateUrl($name)
    {
        include_once MODX_BASE_PATH . "assets/plugins/transalias/transalias.class.php";
        $transalias = new TransAlias;

        $remove_periods = 'No';
        $table_name     = 'russian';
        $transalias->loadTable($table_name, $remove_periods);

        $char_restrict  = 'alphanumeric';
        $word_separator = 'dash';
        $alias          = $transalias->stripAlias($name, $char_restrict, $word_separator);

        $alias = strip_tags($alias);
        $alias = preg_replace('/[^\.A-Za-z0-9 _-]/', '', $alias); // strip non-alphanumeric characters
        $alias = preg_replace('/\s+/', '-', $alias); // convert white-space to dash
        $alias = preg_replace('/-+/', '-', $alias); // convert multiple dashes to one
        $alias = trim($alias, '-'); // trim excess

        $newAlias = strtolower($alias);
        return $newAlias;
    }
    function generateSlug($name)
    {
        include_once MODX_BASE_PATH . "assets/plugins/transalias/transalias.class.php";
        $transalias = new TransAlias;

        $remove_periods = 'No';
        $table_name     = 'russian';
        $transalias->loadTable($table_name, $remove_periods);

        $char_restrict  = 'alphanumeric';
        $word_separator = 'dash';
        $alias          = $transalias->stripAlias($name, $char_restrict, $word_separator);

        $alias = strip_tags($alias);
        $alias = preg_replace('/[^\.A-Za-z0-9 _-]/', '', $alias); // strip non-alphanumeric characters
        $alias = preg_replace('/\s+/', '', $alias); // convert white-space to dash
        $alias = preg_replace('/-+/', '', $alias); // convert multiple dashes to one
        $alias = str_replace('-','',$alias);
        $alias = trim($alias); // trim excess
        $alias = strtolower($alias);

        return $alias;
    }
    function calendarStatusSmile($id) {
      switch($id){
        case "0":
          $status = '⚪';
        break;
        case "1":
          $status = '🟢';
        break;
        case "2":
          $status = '🟠';
        break;
        case "3":
          $status = '🔴';
        break;
      }
      return $status;
    }
    function calendarStatus($id) {
      switch($id){
        case "0":
          $status = '';
        break;
        case "1":
          $status = 's_success';
        break;
        case "2":
          $status = 's_warning';
        break;
        case "3":
          $status = 's_danger';
        break;
      }
      return $status;
    }
    function formatWeekShort($week) {
      $days = array('1' => 'Пн', '2' => 'Вт', '3' => 'Ср', '4' => 'Чт', '5' => 'Пт', '6' => 'Сб', '0' => 'Нд');
      $res = $days[$week];
      return $res;
    }
    function formatMYDate($unix) {
      switch (date("m", $unix)) {
        case 1: $hd = "січень"; break;
        case 2: $hd = "лютий"; break;
        case 3: $hd = "березень"; break;
        case 4: $hd = "квітень"; break;
        case 5: $hd = "травень"; break;
        case 6: $hd = "червень"; break;
        case 7: $hd = "липень"; break;
        case 8: $hd = "серпень"; break;
        case 9: $hd = "вересень"; break;
        case 10: $hd = "жовтень"; break;
        case 11: $hd = "листопад"; break;
        case 12: $hd = "грудень"; break;
      }
      $res = $hd. date(' Y',$unix);
      return $res;
    }
    function formatFullDate($unix) {
      switch (date("m", $unix)) {
        case 1: $hd = "січня"; break;
        case 2: $hd = "лютого"; break;
        case 3: $hd = "березня"; break;
        case 4: $hd = "квітня"; break;
        case 5: $hd = "травня"; break;
        case 6: $hd = "червня"; break;
        case 7: $hd = "липня"; break;
        case 8: $hd = "серпня"; break;
        case 9: $hd = "вересня"; break;
        case 10: $hd = "жовтня"; break;
        case 11: $hd = "листопада"; break;
        case 12: $hd = "грудня"; break;
      }
      $res = date("j ", $unix) . $hd. date(' Y',$unix);
      return $res;
    }
    function formatDate($data, $time = false) {
      if($time == false){
        $unix = strtotime($data);
      }else{
        $unix = $data;
      }
      $unix = $unix+$this->modx->config['server_offset_time'];
      $time = time();
      $day  = mktime ( 0,0,0 ,date("m"), date("d"), date("Y") );
      $yday = mktime ( 0,0,0 ,date("m"), date("d") - 1, date("Y") );
      if ($unix > $day)
        $hd = date("Сегодня, H:i", $unix);
      elseif ($unix > $yday)
        $hd = date("Вчера, H:i", $unix);
      else {
        switch (date("m", $unix)) {
          case 1:  $hd = "января"; break;
          case 2:  $hd = "февраля"; break;
          case 3:  $hd = "марта"; break;
          case 4:  $hd = "апреля"; break;
          case 5:  $hd = "мая"; break;
          case 6:  $hd = "июня"; break;
          case 7:  $hd = "июля"; break;
          case 8:  $hd = "августа"; break;
          case 9:  $hd = "сентября"; break;
          case 10: $hd = "октября"; break;
          case 11: $hd = "ноября"; break;
          case 12: $hd = "декабря"; break;
        }
        $hd = date("j ", $unix) . $hd;
      }
      if (date("Y", $time) != date("Y", $unix) )
        $hd .= date(" Y", $unix);
      if($unix < $day AND $unix < $yday){
        $exp_data = explode(" ",$data);
        $res = $hd." в ".end($exp_data);
      }else{
        $res = $hd;
      }
      return $res;
    }
    function getUserName($user_id){
      $row = $this->db->getRow($this->db->query('SELECT fullname FROM `modx_web_user_attributes` WHERE internalKey = "'.$this->db->escape($user_id).'" LIMIT 1'));
      return $row['fullname'];
    }


    function deleteCallInstructor($id) {
      $this->db->query('DELETE FROM `modx_a_call_instructor` WHERE id = '.$id);
    }
    function getCallInstructor($search = '', $orderby = ' ORDER BY o.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_call_instructor` o
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( o.id = '".$this->db->escape($search)."' 
                          OR o.phone LIKE '%".$this->db->escape($search)."%'
                          OR o.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }



    function deleteLesson($id) {
      $this->db->query('DELETE FROM `modx_a_testlesson` WHERE id = '.$id);
    }
    function getLesson($search = '', $orderby = ' ORDER BY o.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_testlesson` o
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( o.id = '".$this->db->escape($search)."' 
                          OR o.phone LIKE '%".$this->db->escape($search)."%'
                          OR o.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }


    function deleteCityForm($id) {
      $this->db->query('DELETE FROM `modx_a_city_form` WHERE id = '.$id);
    }
    function getCityForm($search = '', $orderby = ' ORDER BY o.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_city_form` o
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( o.id = '".$this->db->escape($search)."' 
                          OR o.phone LIKE '%".$this->db->escape($search)."%'
                          OR o.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function deleteOnline($id) {
      $this->db->query('DELETE FROM `modx_a_online` WHERE id = '.$id);
    }
    function getOnline($search = '', $orderby = ' ORDER BY o.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_online` o
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( o.id = '".$this->db->escape($search)."' 
                          OR o.email LIKE '%".$this->db->escape($search)."%' 
                          OR o.phone LIKE '%".$this->db->escape($search)."%'
                          OR o.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }


    function deleteWebiIn($id) {
      $this->db->query('DELETE FROM `modx_a_webi_in` WHERE id = '.$id);
    }
    function getWebiIn($search = '', $orderby = ' ORDER BY w.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_webi_in` w
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( w.id = '".$this->db->escape($search)."' 
                          OR w.phone LIKE '%".$this->db->escape($search)."%'
                          OR w.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function deleteMater($id) {
      $this->db->query('DELETE FROM `modx_a_master` WHERE id = '.$id);
    }
    function getMaster($search = '', $orderby = ' ORDER BY w.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_master` w
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( w.id = '".$this->db->escape($search)."' 
                          OR w.email LIKE '%".$this->db->escape($search)."%' 
                          OR w.phone LIKE '%".$this->db->escape($search)."%'
                          OR w.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }


    function deleteWebi($id) {
      $this->db->query('DELETE FROM `modx_a_webi` WHERE id = '.$id);
    }
    function getWebi($search = '', $orderby = ' ORDER BY w.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_webi` w
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( w.id = '".$this->db->escape($search)."' 
                          OR w.email LIKE '%".$this->db->escape($search)."%' 
                          OR w.phone LIKE '%".$this->db->escape($search)."%'
                          OR w.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }
    function getSubscribers($search = '', $orderby = ' ORDER BY w.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_subscribe` w
            LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = w.user_id
            WHERE 1 = 1 AND w.archive = '0'
            ".(!empty($search) ? "AND ( w.id = '".$this->db->escape($search)."' 
                          OR w.hash = '".$this->db->escape($search)."' 
                          OR wua.email LIKE '%".$this->db->escape($search)."%' 
                          OR wua.phone LIKE '%".$this->db->escape($search)."%'
                          OR wua.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function getChats($search = '', $orderby = ' ORDER BY w.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *, (SELECT count(id) FROM `modx_a_chat_history` ch WHERE ch.chat_id = w.chat_id ) as message_cnt
            FROM `modx_a_chat_threads` w
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( w.id = '".$this->db->escape($search)."' 
                          OR w.chat_id = '".$this->db->escape($search)."' )" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }


    function deleteInstructor($id) {
      $this->db->query('DELETE FROM `modx_a_instructors` WHERE id = '.$id);
    }

    function getInstructor ($id){
      $query = "
            SELECT 
              *
            FROM `modx_a_instructors`
            WHERE id = '".$this->db->escape($id)."' ";
      $res = $this->db->getRow($this->db->query($query));
      return $res;
    }

    function getInstructors ($search = '', $orderby = ' ORDER BY wu.id DESC ', $city = '', $school = ''){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      if($city != ''){
        $city_s = ' AND wu.city = "'.$this->db->escape($city).'" ';
      }
      if($school != ''){
        $school_s = ' AND wu.school = "'.$this->db->escape($school).'" ';
      }
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_instructors` wu
            WHERE 1 = 1 
            ".$city_s."
            ".$school_s."
            ".(!empty($search) ? "AND ( wu.id = '".$this->db->escape($search)."' 
                          OR wu.email LIKE '%".$this->db->escape($search)."%' 
                          OR wu.phone LIKE '%".$this->db->escape($search)."%'
                          OR wu.lastname LIKE '%".$this->db->escape($search)."%'
                          OR wu.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function updateInstructor ($user) {
      if($user['instructor_url'] == ''){
        $user['instructor_url'] = $this->generateSlug($user['lastname'].'-'.$user['fullname']);
      }
      if($user['certificate'] != ''){
        $certificate = ' certificate = "'.$this->db->escape($user['certificate']).'", ';
      }
      $this->db->query('UPDATE `modx_a_instructors` SET 
        '.$certificate.'
        car_photo          = "'.$this->db->escape($user['car_photo']).'",
        main_photo         = "'.$this->db->escape($user['main_photo']).'",
        photo              = "'.$this->db->escape(implode(',',$user['photo'])).'",
        status             = "'.$this->db->escape($user['status']).'",
        verify             = "'.$this->db->escape($user['verify']).'",
        user_id            = "'.$this->db->escape($user['user_id']).'",
        school             = "'.$this->db->escape($user['school']).'",
        product_paytype    = "'.$this->db->escape($user['product_paytype']).'",
        instructor_url     = "'.$this->db->escape($user['instructor_url']).'", 
        duration           = "'.$this->db->escape($user['duration']).'",
        title              = "'.$this->db->escape($user['title']).'", 
        fullname           = "'.$this->db->escape($user['fullname']).'",
        lastname           = "'.$this->db->escape($user['lastname']).'",
        patronymic         = "'.$this->db->escape($user['patronymic']).'",
        email              = "'.$this->db->escape($user['email']).'",
        phone              = "'.$this->db->escape($user['phone']).'",
        birthday           = "'.$this->db->escape($user['birthday']).'",
        experience         = "'.$this->db->escape($user['experience']).'",
        certificate_date   = "'.$this->db->escape($user['certificate_date']).'",
        city               = "'.$this->db->escape($user['city']).'",
        district           = "'.$this->db->escape($user['district']).'",
        pickup_address     = "'.$this->db->escape($user['pickup_address']).'",
        type               = "'.$this->db->escape(implode(',',$user['type'])).'",
        brand              = "'.$this->db->escape($user['brand']).'",
        model              = "'.$this->db->escape($user['model']).'",
        color              = "'.$this->db->escape($user['color']).'",
        year               = "'.$this->db->escape($user['year']).'",
        reg_number         = "'.$this->db->escape($user['reg_number']).'",
        transmission       = "'.$this->db->escape(implode(',',$user['transmission'])).'",
        schedule_from      = "'.$this->db->escape($user['schedule_from']).'",
        schedule_to        = "'.$this->db->escape($user['schedule_to']).'",
        price_from         = "'.$this->db->escape($user['price_from']).'",
        price              = "'.$this->db->escape($user['price']).'",
        description        = "'.$this->db->escape($user['description']).'",
        comment            = "'.$this->db->escape($user['comment']).'"
        WHERE id  = "'.$this->db->escape($user['id']).'"');
    } 


  
    function deleteUser($id) {
      $this->db->query('DELETE FROM `modx_web_users` WHERE id = '.$id);
      $this->db->query('DELETE FROM `modx_web_user_attributes` WHERE internalKey = '.$id);
      $this->db->query('DELETE FROM `new_theme_2_user` WHERE user_id = '.$id);
      $this->db->query('DELETE FROM `new_theme_2_user_time` WHERE user_id = '.$id);
      $this->db->query('DELETE FROM `new_ticket_2_user` WHERE user_id = '.$id);
      $this->db->query('DELETE FROM `new_ticket_2_user_time` WHERE user_id = '.$id);
    }

    function getUser ($id){
      $query = "
            SELECT 
              *
            FROM `modx_web_users` wu
            LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = wu.id 
            WHERE wu.id = '".$this->db->escape($id)."' ";
      $res = $this->db->getRow($this->db->query($query));
      return $res;
    }
    function getUsers ($search = '', $orderby = ' ORDER BY wu.id DESC '){
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_web_users` wu
            LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = wu.id 
            WHERE 1 = 1 
            ".(!empty($search) ? "AND ( wu.id = '".$this->db->escape($search)."' 
                          OR wu.username LIKE '%".$this->db->escape($search)."%' 
                          OR wua.phone LIKE '%".$this->db->escape($search)."%'
                          OR wua.lastname LIKE '%".$this->db->escape($search)."%'
                          OR wua.fullname LIKE '%".$this->db->escape($search)."%')" : "")." 
             ".$orderby."  
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }
    function updateUserI($user){
      $id = $this->db->escape($user['id']);
      $subscribedate = strtotime($user['subscribedate']);
      $this->db->query('UPDATE `modx_web_user_attributes` SET 
        user_inner_comment = "'.$this->db->escape($user['user_inner_comment']).'",
        cabinet_type       = "'.$this->db->escape($user['cabinet_type']).'",
        school             = "'.$this->db->escape($user['school']).'",
        cabinet_syncname   = "'.$this->db->escape($user['cabinet_syncname']).'",
        blocked            = "'.$this->db->escape($user['blocked']).'",
        subscribedate      = "'.$this->db->escape($subscribedate).'",
        subscribefix       = "'.$this->db->escape($user['subscribefix']).'",
        user_type          = "'.$this->db->escape($user['user_type']).'",
        user_type_p        = "'.$this->db->escape($user['user_type_p']).'",
        cabinet_zp         = "'.$this->db->escape($user['cabinet_zp']).'"
        WHERE internalKey  = "'.$id.'"');
      if($user['blocked'] == '0'){
        $this->db->query('UPDATE `modx_web_user_attributes` SET blocked = "0", blockeduntil = "0", blockedafter = "0", failedlogincount = "0" WHERE internalKey = "'.$id.'" ');
      }

    }

    function updateUser ($user) {

      $subscribedate = strtotime($user['subscribedate']);

      if($user['free_premium'] == '1'){
        $start = time();
        $next = strtotime('+2 month', $start);
        $upd = ' user_type = "1", user_type_p = "0", subscribedate = "'.$this->db->escape($next).'", subscribefix = "1", free_premium = "1", ';
      }else{
        $upd = 'user_type = "'.$this->db->escape($user['user_type']).'", user_type_p = "'.$this->db->escape($user['user_type_p']).'", subscribedate = "'.$this->db->escape($subscribedate).'", subscribefix = "'.$this->db->escape($user['subscribefix']).'",';
      }

      if($user['newpass'] != ''){
        $pass = ' password = "'.md5($user['newpass']).'", ';
      }else{
        $pass = '';
      }

      $id = $this->db->escape($user['id']);
      $this->db->query('UPDATE `modx_web_users` SET '.$pass.' username = "'.$this->db->escape($user['username']).'" WHERE id = "'.$id.'"');
      $this->db->query('UPDATE `modx_web_user_attributes` SET 
        '.$upd.'
        email              = "'.$this->db->escape($user['username']).'",
        fullname           = "'.$this->db->escape($user['fullname']).'",
        lastname           = "'.$this->db->escape($user['lastname']).'",
        patronymic         = "'.$this->db->escape($user['patronymic']).'",
        phone              = "'.$this->db->escape($user['phone']).'",
        city               = "'.$this->db->escape($user['city']).'",
        school             = "'.$this->db->escape($user['school']).'",
        category_type      = "'.$this->db->escape($user['category_type']).'",
        transmission       = "'.$this->db->escape($user['transmission']).'",
        online_course      = "'.$this->db->escape($user['online_course']).'",
        test_photo         = "'.$this->db->escape($user['test_photo']).'",
        utm                = "'.$this->db->escape(json_encode($user['utm'])).'",
        user_inner_comment = "'.$this->db->escape($user['user_inner_comment']).'",
        cabinet_type       = "'.$this->db->escape($user['cabinet_type']).'",
        cabinet_syncname   = "'.$this->db->escape($user['cabinet_syncname']).'",
        cabinet_zp         = "'.$this->db->escape($user['cabinet_zp']).'",
        blocked            = "'.$this->db->escape($user['blocked']).'"
        WHERE internalKey  = "'.$id.'"');
      if($user['blocked'] == '0'){
        $this->db->query('UPDATE `modx_web_user_attributes` SET blocked = "0", blockeduntil = "0", blockedafter = "0", failedlogincount = "0" WHERE internalKey = "'.$id.'" ');
      }
    } 
   
    function CM($ids) {
      if (strpos($ids, "*") !== false) {
        $tmp = array();
        $langs = explode(",", $this->modx->config['lang_list']);
        foreach ($langs as $lang) 
          $tmp[] = str_replace("*", $lang, $ids);
      }
      if (is_array($tmp))
        foreach ($tmp as $value)
          $res .= implode("", $this->modx->invokeEvent("OnRichTextEditorInit", array('editor' => "CodeMirror", 'elements' => $value)));
      return $res;
    }
 

    /**
     *  tinyMCE
     *  генерирует код необходимый для подключения tinyMCE
     *  @ids - список id полей textarea через запятую, * меняется на все возможные переводы (ua, ru, en) берется из настроек lang_list
     */
    function tinyMCE($ids) {
      if (strpos($ids, "*") !== false) {
        $tmp = array();
        $langs = explode(",", $this->modx->config['lang_list']);
        foreach ($langs as $lang) 
          $tmp[] = str_replace("*", $lang, $ids);
        $ids = implode(",", $tmp);
      }
      return implode("", $this->modx->invokeEvent("OnRichTextEditorInit", array('editor' => "TinyMCE4", 'elements' => array($ids))));
    }
   
    /**
     *  Получить текущую языковую локаль
     */
    function getLang() {
      return in_array($_GET['lang'], explode(",", $this->modx->config['lang_list'])) ? $_GET['lang'] : $this->modx->config['lang_default'];
    }

   
    function pub_month($date){
      switch (date('m',$date)){
        case '01':
          $month = 'Января';
        break;
        case '02':
          $month = 'Февраля';
        break;
        case '03':
          $month = 'Марта';
        break;
        case '04':
          $month = 'Апреля';
        break;
        case '05':
          $month = 'Мая';
        break;
        case '06':
          $month = 'Июня';
        break;
        case '07':
          $month = 'Июля';
        break;
        case '08':
          $month = 'Августа';
        break;
        case '09':
          $month = 'Сентября';
        break;
        case '10':
          $month = 'Октября';
        break;
        case '11':
          $month = 'Ноября';
        break;
        case '12':
          $month = 'Декабря';
        break;
      }
      return $month;
    }




    function getRecallsC($date = '', $status = '') {
      //$status = ($status != '' ? $status : '');
      $limit = 10;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query ="
      SELECT SQL_CALC_FOUND_ROWS r.*
      FROM `modx_a_recall_content` r
      WHERE 0=0 ".$date.$status."
      ORDER BY recall_id DESC LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function getRecallC($recall_id) {
      return $this->db->getRow($this->db->query("
      SELECT r.*
      FROM `modx_a_recall_content` r
      WHERE recall_id = ".$this->db->escape($recall_id)));
    }
    function updateRecallC($recall){
      $this->db->query("UPDATE `modx_a_recall_content` SET 
            recall_mark = '".$this->db->escape($recall['mark'])."',
            recall_name = '".$this->db->escape($recall['name'])."',
            recall_email = '".$this->db->escape($recall['email'])."',
            recall_soclink = '".$this->db->escape($recall['soclink'])."',
            recall_text = '".$this->db->escape($recall['text'])."',
            recall_answer = '".$this->db->escape($recall['answer'])."',
            recall_moderated = '".$this->db->escape($recall['moderated'])."'
          WHERE recall_id = '".$this->db->escape($recall['id'])."'
          ");
    }
    function deleteRecallC($id){
      $this->db->query("DELETE FROM `modx_a_recall_content` WHERE recall_id = '".$this->db->escape($id)."' LIMIT 1");
    }

    function getRecalls($date = '', $status = '') {
      //$status = ($status != '' ? $status : '');
      $limit = 10;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query ="
      SELECT SQL_CALC_FOUND_ROWS r.*
      FROM `modx_a_recall` r
      WHERE 0=0 ".$date.$status."
      ORDER BY recall_id DESC LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function getRecall($recall_id) {
      return $this->db->getRow($this->db->query("
      SELECT r.*
      FROM `modx_a_recall` r
      WHERE recall_id = ".$this->db->escape($recall_id)));
    }
    function updateRecall($recall){
      $this->db->query("UPDATE `modx_a_recall` SET 
            recall_mark = '".$this->db->escape($recall['mark'])."',
            recall_name = '".$this->db->escape($recall['name'])."',
            recall_email = '".$this->db->escape($recall['email'])."',
            recall_text = '".$this->db->escape($recall['text'])."',
            recall_answer = '".$this->db->escape($recall['answer'])."',
            recall_moderated = '".$this->db->escape($recall['moderated'])."'
          WHERE recall_id = '".$this->db->escape($recall['id'])."'
          ");
    }
    function deleteRecall($id){
      $this->db->query("DELETE FROM `modx_a_recall` WHERE recall_id = '".$this->db->escape($id)."' LIMIT 1");
    }

    function getPaginateCatalog($tpl ='tpl_paginate', $tpl_enable = 'tpl_page_enable', $tpl_disable = 'tpl_page_disable', $classJS, $hash = ""){  
      if($this->modx->getPlaceholder("max_items") != '' && $this->modx->getPlaceholder("limit_items") != '')
        $pages['all']   = ceil($this->modx->getPlaceholder("max_items") / $this->modx->getPlaceholder("limit_items"));
      $classJS        = $classJS != '' ? $classJS : ' ';



      $prev           = $prev != '' ? $prev : '&laquo;';
      $next           = $next != '' ? $next : '&raquo;';
      $hash           = ($hash != '' ? "#".$hash : '');
      $classPrev      = ($classPrev != '' ? $classPrev : 'm_pagin_list_prev m_pagin_list_step').$classJS;
      $classNext      = ($classNext != '' ? $classNext : 'm_pagin_list_next m_pagin_list_step').$classJS;
      $classPage      = ($classPage != '' ? $classPage : 'pagenav').$classJS;
      $classCurrent   = $classCurrent != '' ? $classCurrent : 'active m_pagin_list--active';
      $classSeparator = $classSeparator != '' ? $classSeparator : 'separator';
      $separator      = $separator != '' ? $separator : '<li>...</li>';
//      $url            = $this->modx->makeUrl($this->modx->documentIdentifier);
      $url            = $this->modx->getPlaceholder("url") != '' ? $this->modx->getPlaceholder("url") : $this->modx->makeUrl($this->modx->documentIdentifier);

      if(isset($_GET['s'])){
        $dd = '?s='.$_GET['s'];
      }
      if($pages['all'] > 1){
        $limit_pagination = 2;
        $curent = isset($_GET['p']) ? $_GET['p'] : 0;
        $curent = $curent; //fix
        $start  = $curent - $limit_pagination;
        $end    = $curent + $limit_pagination;
        $start  = $start < 1 ? 1 : $start;
        $end    = $end > $pages['all'] ? $pages['all'] : $end;
        if($curent > 1){
          if($curent == 1){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));
            $this->modx->documentObject['prev_page'] = '<link rel="prev" href="'.$url.'/'.$dd.'"/>';
          }else{
            if($curent == 2){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));
              $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'/'.$dd.'"/>';
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($curent-1).'/'.$dd, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));

              $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($curent-1).'/'.$dd.'"/>';
            }
          }
        }
        if($curent > $limit_pagination+1){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.$dd, 'rel' => '', 'class' => $classPage, 'title' => '1'));
          $res .= $separator;
        }
        for($i=$start; $i<$end+1; $i++){                
          if($i==($curent)){
            $res .= $this->modx->parseChunk($tpl_disable, array('url' => $url.'page-'.($i).'/'.$dd, 'class' => $classCurrent, 'rel' => 'rel="canonical" ', 'title' => $i));
          }else{
            if( ($i - 1) == $curent OR ($i + 1) == $curent){
              if($i + 1 == $curent){
                $rel = 'rel="prev"';
              }
              if($i - 1 == $curent){
                $rel = 'rel="next"';
              }
            }else{
              $rel = '';
            }
            if($i == 1){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.$dd, 'class' => $classPage, 'rel' => $rel, 'title' => $i)); //fix -1
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($i).'/'.$dd, 'class' => $classPage, 'rel' => $rel, 'title' => $i)); //fix -1
            }
          }
        }
        if($curent < ($pages['all'] - $limit_pagination)){
          $res .= $separator; 
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($pages['all']).'/'.$dd, 'rel' => 'rel="next"', 'class' => $classPage, 'title' => $pages['all']));
          $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($pages['all']).'/'.$dd.'"/>';
        }
        if($curent != $pages['all']){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($curent+1).'/'.$dd, 'rel' => 'rel="next"', 'class' => $classNext, 'title' => $next));
            $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($curent+1).'/'.$dd.'"/>';
        }  
      }
      return $res;
    }
   
    function getPaginateInstructor($tpl ='tpl_paginate', $tpl_enable = 'tpl_page_enable', $tpl_disable = 'tpl_page_disable', $classJS, $hash = ""){  
      if($this->modx->getPlaceholder("max_items") != '' && $this->modx->getPlaceholder("limit_items") != '')
        $pages['all']   = ceil($this->modx->getPlaceholder("max_items") / $this->modx->getPlaceholder("limit_items"));
      $classJS        = $classJS != '' ? $classJS : ' ';



      $prev           = $prev != '' ? $prev : '&laquo;';
      $next           = $next != '' ? $next : '&raquo;';
      $hash           = ($hash != '' ? "#".$hash : '');
      $classPrev      = ($classPrev != '' ? $classPrev : 'm_pagin_list_prev m_pagin_list_step').$classJS;
      $classNext      = ($classNext != '' ? $classNext : 'm_pagin_list_next m_pagin_list_step').$classJS;
      $classPage      = ($classPage != '' ? $classPage : 'pagenav').$classJS;
      $classCurrent   = $classCurrent != '' ? $classCurrent : 'active m_pagin_list--active';
      $classSeparator = $classSeparator != '' ? $classSeparator : 'separator';
      $separator      = $separator != '' ? $separator : '<li>...</li>';
//      $url            = $this->modx->makeUrl($this->modx->documentIdentifier);
      $url            = $this->modx->getPlaceholder("url") != '' ? $this->modx->getPlaceholder("url") : $this->modx->makeUrl($this->modx->documentIdentifier);

      if(isset($_GET['s'])){
        $dd = '?s='.$_GET['s'];
      }
      if($pages['all'] > 1){
        $limit_pagination = 2;
        $curent = isset($_GET['p']) ? $_GET['p'] : 0;
        $curent = $curent; //fix
        $start  = $curent - $limit_pagination;
        $end    = $curent + $limit_pagination;
        $start  = $start < 1 ? 1 : $start;
        $end    = $end > $pages['all'] ? $pages['all'] : $end;
        if($curent > 1){
          if($curent == 1){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));
            $this->modx->documentObject['prev_page'] = '<link rel="prev" href="'.$url.'/'.$dd.'"/>';
          }else{
            if($curent == 2){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));
              $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'/'.$dd.'"/>';
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($curent-1).'/'.$dd, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));

              $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($curent-1).'/'.$dd.'"/>';
            }
          }
        }
        if($curent > $limit_pagination+1){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.$dd, 'rel' => '', 'class' => $classPage, 'title' => '1'));
          $res .= $separator;
        }
        for($i=$start; $i<$end+1; $i++){                
          if($i==($curent)){
            $res .= $this->modx->parseChunk($tpl_disable, array('url' => $url.'page-'.($i).'/'.$dd, 'class' => $classCurrent, 'rel' => 'rel="canonical" ', 'title' => $i));
          }else{
            if( ($i - 1) == $curent OR ($i + 1) == $curent){
              if($i + 1 == $curent){
                $rel = 'rel="prev"';
              }
              if($i - 1 == $curent){
                $rel = 'rel="next"';
              }
            }else{
              $rel = '';
            }
            if($i == 1){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.$dd, 'class' => $classPage, 'rel' => $rel, 'title' => $i)); //fix -1
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($i).'/'.$dd, 'class' => $classPage, 'rel' => $rel, 'title' => $i)); //fix -1
            }
          }
        }
        if($curent < ($pages['all'] - $limit_pagination)){
          $res .= $separator; 
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($pages['all']).'/'.$dd, 'rel' => 'rel="next"', 'class' => $classPage, 'title' => $pages['all']));
          $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($pages['all']).'/'.$dd.'"/>';
        }
        if($curent != $pages['all']){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($curent+1).'/'.$dd, 'rel' => 'rel="next"', 'class' => $classNext, 'title' => $next));
            $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($curent+1).'/'.$dd.'"/>';
        }  
      }
      return $res;
    }

    function getPaginateAX($max_items = "", $limit_items = ""){  
      if($max_items != '' && $limit_items != ''){
        $pages['all']   = ceil($max_items / $limit_items);
      }

      $tpl_enable = 'tpl_page_enable_ax';
      $tpl_disable = 'tpl_page_disable_ax';

      $prev           = $prev != '' ? $prev : '&laquo;';
      $next           = $next != '' ? $next : '&raquo;';
      $hash           = ($hash != '' ? "#".$hash : '');
      $classPrev      = ($classPrev != '' ? $classPrev : 'm_pagin_list_prev m_pagin_list_step').$classJS;
      $classNext      = ($classNext != '' ? $classNext : 'm_pagin_list_next m_pagin_list_step').$classJS;
      $classPage      = ($classPage != '' ? $classPage : 'pagenav').$classJS;
      $classCurrent   = $classCurrent != '' ? $classCurrent : 'active m_pagin_list--active';
      $classSeparator = $classSeparator != '' ? $classSeparator : 'separator';
      $separator      = $separator != '' ? $separator : '<li>...</li>';
      $url = '#';
      if($pages['all'] > 1){
        $limit_pagination = 2;
        $curent = isset($_GET['p']) ? $_GET['p'] : 0;
        $curent = $curent; //fix
        $start  = $curent - $limit_pagination;
        $end    = $curent + $limit_pagination;
        $start  = $start < 1 ? 1 : $start;
        $end    = $end > $pages['all'] ? $pages['all'] : $end;
        if($curent > 1){
          if($curent == 1){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => '1', 'class' => $classPrev, 'title' => $prev));
          }else{
            if($curent == 2){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => '1', 'class' => $classPrev, 'title' => $prev));
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => ($curent-1), 'class' => $classPrev, 'title' => $prev));
            }
          }
        }
        if($curent > $limit_pagination+1){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => '1', 'class' => $classPage, 'title' => '1'));
          $res .= $separator;
        }
        for($i=$start; $i<$end+1; $i++){                
          if($i==($curent)){
            $res .= $this->modx->parseChunk($tpl_disable, array('url' => $url, 'data' => ($i), 'class' => $classCurrent, 'title' => $i));
          }else{
            if( ($i - 1) == $curent OR ($i + 1) == $curent){
              if($i + 1 == $curent){
                $rel = 'rel="prev"';
              }
              if($i - 1 == $curent){
                $rel = 'rel="next"';
              }
            }else{
              $rel = '';
            }
            if($i == 1){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => '1', 'class' => $classPage, 'title' => $i)); //fix -1
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => $i, 'class' => $classPage, 'title' => $i)); //fix -1
            }
          }
        }
        if($curent < ($pages['all'] - $limit_pagination)){
          $res .= $separator; 
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => ($pages['all']), 'class' => $classPage, 'title' => $pages['all']));
        }
        if($curent != $pages['all']){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'data' => ($curent+1), 'class' => $classNext, 'title' => $next));
        }  
      }
      return $res;
    }
    function getPaginateBlog($tpl ='tpl_paginate', $tpl_enable = 'tpl_page_enable', $tpl_disable = 'tpl_page_disable', $classJS, $hash = ""){  
      if($this->modx->getPlaceholder("max_items") != '' && $this->modx->getPlaceholder("limit_items") != '')
        $pages['all']   = ceil($this->modx->getPlaceholder("max_items") / $this->modx->getPlaceholder("limit_items"));
      $classJS        = $classJS != '' ? $classJS : ' ';



      $prev           = $prev != '' ? $prev : '&laquo;';
      $next           = $next != '' ? $next : '&raquo;';
      $hash           = ($hash != '' ? "#".$hash : '');
      $classPrev      = ($classPrev != '' ? $classPrev : 'm_pagin_list_prev m_pagin_list_step').$classJS;
      $classNext      = ($classNext != '' ? $classNext : 'm_pagin_list_next m_pagin_list_step').$classJS;
      $classPage      = ($classPage != '' ? $classPage : 'pagenav').$classJS;
      $classCurrent   = $classCurrent != '' ? $classCurrent : 'active m_pagin_list--active';
      $classSeparator = $classSeparator != '' ? $classSeparator : 'separator';
      $separator      = $separator != '' ? $separator : '<li>...</li>';
      $url            = $this->modx->makeUrl($this->modx->documentIdentifier);
      if($pages['all'] > 1){
        $limit_pagination = 2;
        $curent = isset($_GET['p']) ? $_GET['p'] : 0;
        $curent = $curent; //fix
        $start  = $curent - $limit_pagination;
        $end    = $curent + $limit_pagination;
        $start  = $start < 1 ? 1 : $start;
        $end    = $end > $pages['all'] ? $pages['all'] : $end;
        if($curent > 1){
          if($curent == 1){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));
            $this->modx->documentObject['prev_page'] = '<link rel="prev" href="'.$url.'/'.'"/>';
          }else{
            if($curent == 2){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));
              $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'/'.'"/>';
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($curent-1).'/', 'rel' => 'rel="prev"', 'class' => $classPrev, 'title' => $prev));

              $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($curent-1).'/'.'"/>';
            }
          }
        }
        if($curent > $limit_pagination+1){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-0/', 'rel' => '', 'class' => $classPage, 'title' => '1'));
          $res .= $separator;
        }
        for($i=$start; $i<$end+1; $i++){                
          if($i==($curent)){
            $res .= $this->modx->parseChunk($tpl_disable, array('url' => $url.'page-'.($i).'/', 'class' => $classCurrent, 'rel' => 'rel="canonical" ', 'title' => $i));
          }else{
            if( ($i - 1) == $curent OR ($i + 1) == $curent){
              if($i + 1 == $curent){
                $rel = 'rel="prev"';
              }
              if($i - 1 == $curent){
                $rel = 'rel="next"';
              }
            }else{
              $rel = '';
            }
            if($i == 1){
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url, 'class' => $classPage, 'rel' => $rel, 'title' => $i)); //fix -1
            }else{
              $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($i).'/', 'class' => $classPage, 'rel' => $rel, 'title' => $i)); //fix -1
            }
          }
        }
        if($curent < ($pages['all'] - $limit_pagination)){
          $res .= $separator; 
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($pages['all']).'/', 'rel' => 'rel="next"', 'class' => $classPage, 'title' => $pages['all']));
          $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($pages['all']).'/'.'"/>';
        }
        if($curent != $pages['all']){
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'page-'.($curent+1).'/', 'rel' => 'rel="next"', 'class' => $classNext, 'title' => $next));
            $this->modx->documentObject['next_page'] = '<link rel="next" href="'.$url.'page-'.($curent+1).'/'.'"/>';
        }  
      }
      return $res;
    }
  
    function getContent($id,$field){
      $r = $this->db->getRow($this->db->query('SELECT * FROM `modx_site_content` WHERE id = "'.$this->db->escape($id).'" LIMIT 1'));
      return $r[$field];
    }
    function getPaginate($tpl ='tpl_paginate', $tpl_enable = 'tpl_page_enable', $tpl_disable = 'tpl_page_disable'){  
      if($this->modx->getPlaceholder("max_items") != '' && $this->modx->getPlaceholder("limit_items") != '')
        $pages['all']   = ceil($this->modx->getPlaceholder("max_items") / $this->modx->getPlaceholder("limit_items"));
      $classJS        = $classJS != '' ? $classJS : ' js_change_page';
      $prev           = $prev != '' ? $prev : '&laquo;';
      $next           = $next != '' ? $next : '&raquo;';
      $classPrev      = ($classPrev != '' ? $classPrev : 'prev prev-next pagenav').$classJS;
      $classNext      = ($classNext != '' ? $classNext : 'next prev-next pagenav').$classJS;
      $classPage      = ($classPage != '' ? $classPage : 'pagenav').$classJS;
      $classCurrent   = $classCurrent != '' ? $classCurrent : 'active pagin_list--active';
      $classSeparator = $classSeparator != '' ? $classSeparator : '';
      $separator      = $separator != '' ? $separator : '<li><span>...</span></li>';
      $url            = $this->modx->getPlaceholder("url") != '' ? $this->modx->getPlaceholder("url") : '';
      if(isset($_GET['orderby'])){
        $dd = '&orderby='.$_GET['orderby'];
      }
      if(isset($_GET['category'])){
        $dd .= '&category='.$_GET['category'];
      }
      if($pages['all'] > 1){
        $limit_pagination = 2;
        $curent = isset($_REQUEST['p']) ? $_REQUEST['p'] : 0;

        $curent = $curent + 1; //fix
        $start  = $curent - $limit_pagination;
        $end    = $curent + $limit_pagination;
        $start  = $start < 1 ? 1 : $start;
        $end    = $end > $pages['all'] ? $pages['all'] : $end;
        if($curent > 1){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.($curent-2).$dd, 'class' => $classPrev, 'title' => $prev));
        }
        if($curent > $limit_pagination+1){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.'0'.$dd, 'class' => $classPage, 'title' => '1'));
          $res .= $separator;
        }
        for($i=$start; $i<$end+1; $i++){                         
          if($i==($curent)){
            $res .= $this->modx->parseChunk($tpl_disable, array('class' => $classCurrent, 'title' => $i));
          }else{
            $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.($i-1).$dd, 'class' => $classPage, 'title' => $i)); //fix -1
          }
        }
        if($curent < ($pages['all'] - $limit_pagination)){
          $res .= $separator; 
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.($pages['all']-1).$dd, 'class' => $classPage, 'title' => $pages['all']));
        }
        if($curent != $pages['all']){
          $res .= $this->modx->parseChunk($tpl_enable , array('url' => $url.($curent).$dd, 'class' => $classNext, 'title' => $next));
        }  
      }
      return $res;
    }
   
    

    /**
     * Функция возвращает окончание для множественного числа слова на основании числа и массива окончаний
     * param  $number Integer Число на основе которого нужно сформировать окончание
     * param  $endingsArray  Array Массив слов или окончаний для чисел (1, 4, 5),
     *         например array('яблоко', 'яблока', 'яблок')
     * return String 
     */
      function getNumEnding($number, $endingArray)
      {
          $number = $number % 100;
          if ($number>=11 && $number<=19) {
              $ending=$endingArray[2];
          }
          else {
              $i = $number % 10;
              switch ($i)
              {
                  case (1): $ending = $endingArray[0]; break;
                  case (2):
                  case (3):
                  case (4): $ending = $endingArray[1]; break;
                  default: $ending=$endingArray[2];
              }
          }
          return $ending;
      }


    function removeSubscriber($email){
      $this->db->query('DELETE FROM `modx_a_mailer_users` WHERE user_email = "'.$this->db->escape($email).'" LIMIT 1');
    }
    function newSubscriber($email, $name = ''){
      $this->db->query('INSERT IGNORE INTO `modx_a_mailer_users` SET user_email = "'.$this->db->escape($email).'", user_name = "'.$this->db->escape($name).'"');
    }

  
    function getManagerListWithType($role = 1) {
      return $this->db->query("SELECT * FROM `modx_manager_users` mu JOIN `modx_user_attributes` ua ON mu.id = ua.internalKey WHERE role = '".$this->db->escape($role)."' ORDER BY mu.id ASC");
    }
    function getManagerList () {
      return $this->db->query("SELECT * FROM `modx_manager_users` ORDER BY id ASC");
    }
    function getClients() {
      return $this->db->query("SELECT * FROM `modx_web_user_attributes` ORDER BY id ASC");
    }
    function getClient($id) {
      return $this->db->getRow($this->db->query("SELECT * FROM `modx_web_user_attributes` WHERE internalKey = '".$this->db->escape($id)."' LIMIT 1"));
    }
   
    function getMailTemplates () {
      return $this->db->query("SELECT * FROM `modx_a_mail_templates` WHERE mail_name != 'meta' GROUP BY mail_name ORDER BY mail_title ASC");
    }
    function getMailTemplate($id) {
      $arr = $this->db->makeArray($this->db->query("SELECT * FROM `modx_a_mail_templates` WHERE mail_name = '".$this->db->escape($id)."'"));
      foreach ($arr as $value)
        $res[$value['mail_lang']] = $value;
      return $res;
    }

    function fgetcsv($f, $d=";", $q='"') {
        $list = array();
        $st = fgets($f);        
        if ($st === false || $st === null) return $st;
        if (trim($st) === "") return array("");
        while ($st !== "" && $st !== false) {
            if ($st[0] !== $q) {
                list ($field) = explode($d, $st, 2);
                $st = substr($st, strlen($field) + strlen($d));
            } else {
                $st = substr($st, 1);
                $field = "";
                while (1) {
                    preg_match("/^((?:[^$q]+|$q$q)*)/sx", $st, $p);
                    $part = $p[1];
                    $partlen = strlen($part);
                    $st = substr($st, strlen($p[0]));
                    $field .= str_replace($q.$q, $q, $part);
                    if (strlen($st) && $st[0] === $q) {
                        list ($dummy) = explode($d, $st, 2);
                        $st = substr($st, strlen($dummy) + strlen($d));
                        break;
                    } else {
                        $st = fgets($f);
                    }
                }
            }
            $list[] = $field;
        }
        return $list;
    }
    function getOrders($date = '') {
      $limit = 20;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query ="
      SELECT SQL_CALC_FOUND_ROWS *
      FROM `modx_a_writer` 
      WHERE 0=0 ".$date."
      ORDER BY id DESC LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }

    function getOrder($id) {
      return $this->db->getRow($this->db->query("
      SELECT *
      FROM `modx_a_writer`
      WHERE id = ".$this->db->escape($id)));
    }

    function mail ($to,$theme,$body) {


        if (!class_exists('PHPMailer')) {
          require_once MODX_BASE_PATH."assets/shop/php/mailer/class.phpmailer.php";
        }


        $mail =  new PHPMailer();
        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true; 
        $mail->SMTPSecure = "tls";  // none ssl tls StartTLS


        $mail->Host       = $this->modx->config['smtp_host'];
        $mail->Port       = $this->modx->config['smtp_port'];             
        $mail->Username   = $this->modx->config['smtp_username'];
        $mail->Password   = $this->modx->config['smtppw'];

        $mail->Subject    = $theme;
        $mail->SetFrom($mail->Username, $this->modx->config['site_name']);
        $mail->AddAddress($to);
        $mail->MsgHTML($body);
        $res = $mail->Send();

/*
      $param = array();
      $param['to']      = $to;
      $param['subject'] = $theme;
      $param['body']    = $body;
      $rs = $this->modx->sendmail($param);
*/


    }
    function sendMail($reciever, $template, $data) {
      $lang = $this->modx->config['lang'];
      $meta = $this->getMailTemplate("meta");
      $tpl  = $this->getMailTemplate($template);
      if (is_array($data)) foreach ($data as $key => $value) $parse["{".$key."}"] = $value;
      $body = strtr($tpl[$lang]['mail_template'], $parse);
      $body = str_replace('{body}', $body, $meta[$lang]['mail_template']);      
      $body = $this->modx->parseDocumentSource($this->modx->rewriteUrls($body));
      $this->modx->loadExtension('MODxMailer');
      $this->modx->mail->Subject = $tpl[$lang]['mail_subject'];
      $this->modx->mail->AddAddress($reciever);
      $this->modx->mail->MsgHTML($body);
      return $this->modx->mail->Send();
    }

    function getTV($id,$tv){
      $r = $this->db->getRow($this->db->query('SELECT * FROM `modx_site_tmplvar_contentvalues` WHERE contentid = "'.$this->db->escape($id).'" AND tmplvarid = "'.$this->db->escape($tv).'" LIMIT 1'));
      return $r['value'];
    }

    function check_fb($fbid){
      $q = $this->db->query('SELECT * FROM `modx_web_user_attributes` WHERE fb_id = "'.$this->db->escape($fbid).'" AND blocked = "0"  LIMIT 1');
      if($this->db->getRecordCount($q)){
        $r = $this->db->getRow($q);
        $res['email'] = $r['email'];
        $res['ack'] = true;
      }else{
        $res['ack'] = false;
      }
      return $res;
    }
    function check_gp($gpid){
      $q = $this->db->query('SELECT * FROM `modx_web_user_attributes` WHERE gp_id = "'.$this->db->escape($gpid).'" AND blocked = "0" LIMIT 1');
      if($this->db->getRecordCount($q)){
        $r = $this->db->getRow($q);
        $res['email'] = $r['email'];
        $res['ack'] = true;
      }else{
        $res['ack'] = false;
      }
      return $res;
    }

    function getTrval($type,$val){
      $value = array();
      switch($type){
        case "type":
          $exp = explode(',',$val);
          foreach($exp as $v){
            switch($v){
              case "a":
                $value[] = 'Мото (Категорія A)';
              break;
              case "b":
                $value[] = 'Легковий (категорія B)';
              break;
              case "c":
                $value[] = 'Грузовий (категорія C)';
              break;
              case "e":
                $value[] = 'Грузовий (категорія CE)';
              break;
            }
          }
        break;
        case "transmission_new":
          $exp = explode(',',$val);
          foreach($exp as $v){
            switch($v){
              case "manual":
                $value[] = '<span data-prop="Механіка"><svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.5999 5.80005V13H3.3999M12.9999 5.80005V20.2M3.3999 5.80005V20.2" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M25 3.4C25 4.03652 24.7471 4.64697 24.2971 5.09706C23.847 5.54714 23.2365 5.8 22.6 5.8C21.9635 5.8 21.353 5.54714 20.9029 5.09706C20.4529 4.64697 20.2 4.03652 20.2 3.4C20.2 2.76348 20.4529 2.15303 20.9029 1.70294C21.353 1.25286 21.9635 1 22.6 1C23.2365 1 23.847 1.25286 24.2971 1.70294C24.7471 2.15303 25 2.76348 25 3.4ZM15.4 3.4C15.4 4.03652 15.1471 4.64697 14.6971 5.09706C14.247 5.54714 13.6365 5.8 13 5.8C12.3635 5.8 11.753 5.54714 11.3029 5.09706C10.8529 4.64697 10.6 4.03652 10.6 3.4C10.6 2.76348 10.8529 2.15303 11.3029 1.70294C11.753 1.25286 12.3635 1 13 1C13.6365 1 14.247 1.25286 14.6971 1.70294C15.1471 2.15303 15.4 2.76348 15.4 3.4ZM5.8 3.4C5.8 4.03652 5.54714 4.64697 5.09706 5.09706C4.64697 5.54714 4.03652 5.8 3.4 5.8C2.76348 5.8 2.15303 5.54714 1.70294 5.09706C1.25286 4.64697 1 4.03652 1 3.4C1 2.76348 1.25286 2.15303 1.70294 1.70294C2.15303 1.25286 2.76348 1 3.4 1C4.03652 1 4.64697 1.25286 5.09706 1.70294C5.54714 2.15303 5.8 2.76348 5.8 3.4ZM15.4 22.6C15.4 23.2365 15.1471 23.847 14.6971 24.2971C14.247 24.7471 13.6365 25 13 25C12.3635 25 11.753 24.7471 11.3029 24.2971C10.8529 23.847 10.6 23.2365 10.6 22.6C10.6 21.9635 10.8529 21.353 11.3029 20.9029C11.753 20.4529 12.3635 20.2 13 20.2C13.6365 20.2 14.247 20.4529 14.6971 20.9029C15.1471 21.353 15.4 21.9635 15.4 22.6ZM5.8 22.6C5.8 23.2365 5.54714 23.847 5.09706 24.2971C4.64697 24.7471 4.03652 25 3.4 25C2.76348 25 2.15303 24.7471 1.70294 24.2971C1.25286 23.847 1 23.2365 1 22.6C1 21.9635 1.25286 21.353 1.70294 20.9029C2.15303 20.4529 2.76348 20.2 3.4 20.2C4.03652 20.2 4.64697 20.4529 5.09706 20.9029C5.54714 21.353 5.8 21.9635 5.8 22.6ZM22.6 25C23.2365 25 23.847 24.7471 24.2971 24.2971C24.7471 23.847 25 23.2365 25 22.6C25 21.9635 24.7471 21.353 24.2971 20.9029C23.847 20.4529 23.2365 20.2 22.6 20.2C21.9635 20.2 21.353 20.4529 20.9029 20.9029C20.4529 21.353 20.2 21.9635 20.2 22.6C20.2 23.2365 20.4529 23.847 20.9029 24.2971C21.353 24.7471 21.9635 25 22.6 25Z" fill="black" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>';
              break;
              case "automatic":
                $value[] = '<span data-prop="Автомат"><svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M18.5263 16.7996C19.4476 16.7996 20.3311 17.1789 20.9826 17.8541C21.634 18.5293 22 19.445 22 20.3998C22 21.3546 21.634 22.2704 20.9826 22.9455C20.3311 23.6207 19.4476 24 18.5263 24H17.3684C17.0613 24 16.7668 23.8736 16.5497 23.6485C16.3325 23.4235 16.2105 23.1182 16.2105 22.7999V17.9997C16.2105 17.6814 16.3325 17.3762 16.5497 17.1511C16.7668 16.9261 17.0613 16.7996 17.3684 16.7996H18.5263ZM18.5263 21.5999L18.6618 21.5915C18.9548 21.5554 19.2235 21.4046 19.413 21.1701C19.6024 20.9355 19.6982 20.6348 19.6809 20.3295C19.6636 20.0241 19.5345 19.7372 19.3199 19.5272C19.1053 19.3172 18.8214 19.2001 18.5263 19.1998V21.5999ZM19.1053 5.99909C19.873 5.99909 20.6093 6.31518 21.1522 6.87782C21.695 7.44046 22 8.20356 22 8.99925C22 9.79494 21.695 10.558 21.1522 11.1207C20.6093 11.6833 19.873 11.9994 19.1053 11.9994H18.5263V13.1995C18.5263 13.4934 18.4222 13.7771 18.2337 13.9967C18.0452 14.2164 17.7856 14.3567 17.5039 14.3911L17.3684 14.3995C17.0613 14.3995 16.7668 14.2731 16.5497 14.048C16.3325 13.823 16.2105 13.5177 16.2105 13.1995V7.19916C16.2105 6.88088 16.3325 6.57564 16.5497 6.35058C16.7668 6.12553 17.0613 5.99909 17.3684 5.99909H19.1053ZM18.5263 9.59928H19.1053C19.2588 9.59928 19.4061 9.53606 19.5146 9.42353C19.6232 9.311 19.6842 9.15838 19.6842 8.99925C19.6842 8.84011 19.6232 8.68749 19.5146 8.57496C19.4061 8.46243 19.2588 8.39922 19.1053 8.39922H18.5263V9.59928ZM12.7368 9.59928C13.0439 9.59928 13.3384 9.72571 13.5556 9.95077C13.7727 10.1758 13.8947 10.4811 13.8947 10.7993C13.8947 11.1176 13.7727 11.4229 13.5556 11.6479C13.3384 11.873 13.0439 11.9994 12.7368 11.9994H9.26316V19.1998H12.7368C13.0439 19.1998 13.3384 19.3262 13.5556 19.5512C13.7727 19.7763 13.8947 20.0815 13.8947 20.3998C13.8947 20.7181 13.7727 21.0233 13.5556 21.2484C13.3384 21.4734 13.0439 21.5999 12.7368 21.5999H9.26316C8.64897 21.5999 8.05994 21.347 7.62565 20.8969C7.19135 20.4468 6.94737 19.8363 6.94737 19.1998V11.9994H4.63158C4.04733 11.9996 3.48461 11.7709 3.05621 11.3592C2.62781 10.9474 2.3654 10.3831 2.32158 9.77929L2.31579 9.59928V6.99515C1.63824 6.74687 1.05167 6.28691 0.636907 5.67866C0.222149 5.0704 -0.00037627 4.34379 4.77601e-07 3.59897L0.00579008 3.38776C0.0428476 2.73796 0.2492 2.11072 0.602886 1.5728C0.956573 1.03489 1.44436 0.606419 2.01434 0.332998C2.58431 0.0595766 3.21515 -0.0485676 3.83972 0.0200738C4.46429 0.0887153 5.05922 0.331574 5.56119 0.722805C6.06316 1.11404 6.4534 1.639 6.69037 2.24183C6.92734 2.84466 7.00218 3.5028 6.90692 4.14621C6.81166 4.78962 6.54987 5.39423 6.14941 5.89569C5.74895 6.39715 5.2248 6.7767 4.63274 6.99395L4.63158 9.59928H12.7368Z" fill="black"/></svg></span>';
              break;
            }
          }
        break;
        case "transmission":
          $exp = explode(',',$val);
          foreach($exp as $v){
            switch($v){
              case "manual":
                $value[] = 'Механіка';
              break;
              case "automatic":
                $value[] = 'Автомат';
              break;
            }
          }
        break;
        case "verify":
          $exp = explode(',',$val);
          foreach($exp as $v){
            switch($v){
              case "0":
                $value[] = 'Не перевірені';
              break;
              case "1":
                $value[] = 'Тільки перевірені';
              break;
            }
          }
        break;
      }
      if(count($value) > 0){
        $rr = implode(', ',$value);
      }else{
        $rr = '-';
      }
      return $rr;
    }
    function random_promocode(){
      $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
      $randomString = substr(str_shuffle($str), 0, 8);
      return $randomString;
    }

    function m_entities( $string ) {
        $stringBuilder = "";
        $offset = 0;
        if ( empty( $string ) ) {
            return "";
        }
        while ( $offset >= 0 ) {
            $decValue = $this->ordutf8( $string, $offset );
            $char = $this->unichr($decValue);
            $htmlEntited = htmlentities( $char );
            if( $char != $htmlEntited ){
                $stringBuilder .= $htmlEntited;
            } elseif( $decValue >= 128 ){
                $stringBuilder .= "&#" . $decValue . ";";
            } else {
                $stringBuilder .= $char;
            }
        }

        return $stringBuilder;
    }
    function ordutf8($string, &$offset) {
        $code = ord(substr($string, $offset,1));
        if ($code >= 128) {        //otherwise 0xxxxxxx
            if ($code < 224) $bytesnumber = 2;                //110xxxxx
            else if ($code < 240) $bytesnumber = 3;        //1110xxxx
            else if ($code < 248) $bytesnumber = 4;    //11110xxx
            $codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
            for ($i = 2; $i <= $bytesnumber; $i++) {
                $offset ++;
                $code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
                $codetemp = $codetemp*64 + $code2;
            }
            $code = $codetemp;
        }
        $offset += 1;
        if ($offset >= strlen($string)) $offset = -1;
        return $code;
    }
    function unichr($u) {
        return mb_convert_encoding('&#' . intval($u) . ';', 'UTF-8', 'HTML-ENTITIES');
    }

    function mb_ucfirst($string, $encoding = 'UTF-8') {
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $upperFirstChar = mb_convert_case($firstChar, MB_CASE_UPPER, $encoding);
        return $upperFirstChar . mb_substr($string, 1, mb_strlen($string, $encoding), $encoding);
    }
    function wishUI(){
      $userId = $_SESSION['webuser']['internalKey'];
      $wish = $_SESSION['favorite_instructor'];
      if($userId != ''){
        $this->db->query('DELETE FROM `modx_a_instructor_to_wish` WHERE user_id = "'.$this->db->escape($userId).'" ');
        if(is_array($wish)){
          foreach ($wish as $key => $value) {
            $this->db->query('INSERT IGNORE INTO `modx_a_instructor_to_wish` SET user_id = "'.$this->db->escape($userId).'", instructor_id = "'.$this->db->escape($value).'" ');
          }
        }
      }
    }
    function getUserWishListI() {
      $user = $_SESSION['webuser']['internalKey'];
      if($user != ''){
        unset($_SESSION['favorite_instructor']);
        $q = $this->db->query("SELECT * FROM `modx_a_instructor_to_wish` WHERE user_id = ".$this->db->escape($user));
        while($r = $this->db->getRow($q)){
          $_SESSION['favorite_instructor'][] = $r['instructor_id'];
        }
      }
    }
    function wishU(){
      $userId = $_SESSION['webuser']['internalKey'];
      $wish = $_SESSION['favorite'];
      if($userId != ''){
        $this->db->query('DELETE FROM `new_question_2_user_favorite` WHERE user_id = "'.$this->db->escape($userId).'" ');
        if(is_array($wish)){
          foreach ($wish as $key => $value) {
            $this->db->query('INSERT INTO `new_question_2_user_favorite` SET user_id = "'.$this->db->escape($userId).'", question_id = "'.$this->db->escape($value).'" ');
          }
        }
      }
    }
    function getUserWishList() {
      $user = $_SESSION['webuser']['internalKey'];
      if($user != ''){
        unset($_SESSION['favorite']);
        $q = $this->db->query("SELECT * FROM `new_question_2_user_favorite` WHERE user_id = ".$this->db->escape($user));
        while($r = $this->db->getRow($q)){
          $_SESSION['favorite'][] = $r['question_id'];
        }
      }
    }


    function beutifyGptText($text) {        
        $text = preg_replace('/\*\*(.*?)\*\*/', '<b>$1</b>', $text);
        // Разбиваем текст на параграфы
        $text = '<p>'.implode('</p><p>', explode("\n\n", $text)).'</p>';

        // Используем регулярное выражение для поиска и замены ссылки в формате [текст ссылки](URL)
        $pattern = '/\[(.*?)\]\((.*?)\)/';
        $replacement = '<a href="$2" rel="nofollow">$1</a>';
        $text = preg_replace($pattern, $replacement, $text);


        return $text;
    }



    function priceListFacebookCSV(){
      $this->modx->config['lang'] = 'ua';
      $site_url = $this->modx->config['site_url'];
      $site_url_b = substr($this->modx->config['site_url'], 0, -1);
      header('Content-type: text/plain; charset=utf-8');
      //Экспорт товаров csv facebook
      $fp = fopen( MODX_BASE_PATH . '/facebook.csv', 'w' );
      fputcsv($fp,b"\xEF\xBB\xBF" );
      fputcsv($fp,
        array('id',
          'title',
          'description',
          'availability',
          'condition',
          'price',
          'link',
          'image_link',
          'brand'
        )
      );



      $query2 = $this->modx->db->query('SELECT *,
        (SELECT pagetitle_ua FROM `modx_site_content` sc WHERE sc.id IN (p.product_main_cat) LIMIT 1) as category_name
       FROM `modx_a_products` p 
       WHERE p.product_visible = 1');
      while ($row2 = $this->modx->db->getRow($query2)) {


        if($row2['product_price_a'] != '0.00' AND $row2['product_price'] != $row2['product_price_a']){
          $sale_price = round($row2['product_price_a'],2).' UAH';
          $price = round($row2['product_price'],2).' UAH';
        }else{
          $sale_price = '';
          $price = round($row2['product_price'],2).' UAH';
        }

        if($row2['product_amount'] > 0){
          $stock = 'in_stock';
        }else{
          $stock = 'out_of_stock';
        }

        $image = $site_url_b.$row2['product_cover'];    

        $description = trim(strip_tags(html_entity_decode($row2['product_description'])));
        if($description == ''){
          $description = str_replace('&', '&amp;',$row2['product_name']);
        }
        $brand = 'PDR-ONLINE';
        $url = $site_url_b.$this->modx->makeUrl($row2['product_main_cat']).$row2['product_url'].'/';


        fputcsv($fp,
          array($row2['product_id'],
            $this->toWindow(str_replace('&', '&amp;',$row2['product_name'])),
            $this->toWindow($description),
            $this->toWindow($stock),
            $this->toWindow('new'),
            $this->toWindow($price),
            $this->toWindow($url),
            $this->toWindow($image),
            $this->toWindow($brand)
          )
        );

        $cnt++;
      }
      fclose($fp);

    }

    function toWindow($ii){
      //return $ii;
      return iconv( "utf-8", "windows-1251",$ii);
    }
   function priceListFacebook(){
      $this->modx->config['lang'] = 'ua';
      $site_url = $this->modx->config['site_url'];
      $site_url_b = substr($this->modx->config['site_url'], 0, -1);
      $query2 = $this->modx->db->query('SELECT *,
        (SELECT pagetitle_ua FROM `modx_site_content` sc WHERE sc.id IN (p.product_main_cat) LIMIT 1) as category_name
       FROM `modx_a_products` p 
       WHERE p.product_visible = 1');
      while ($row2 = $this->modx->db->getRow($query2)) {
        if($row2['product_price_a'] != '0.00' AND $row2['product_price'] != $row2['product_price_a']){
          $sale_price = '<g:sale_price>'.round($row2['product_price_a'],2).' UAH</g:sale_price>';
          $price = '<g:price>'.round($row2['product_price'],2).' UAH</g:price>';
        }else{
          $sale_price = '';
          $price = '<g:price>'.round($row2['product_price'],2).' UAH</g:price>';
        }

        if($row2['product_amount'] > 0){
          $stock = 'in_stock';
        }else{
          $stock = 'out_of_stock';
        }


        $images_in = '<g:image_link>'.$site_url_b.$row2['product_cover'].'</g:image_link>';    
        $images2 = explode(',',$row2['product_photo']);
        if (is_array($images2)){
          if(count($images2) > 0){
            foreach($images2 as $image){
              if($image != ''){
                $images_in .= '<g:additional_image_link>'.$site_url_b.$image.'</g:additional_image_link>'; 
              }  
            }
          }
        }
        $description = trim(strip_tags(html_entity_decode($row2['product_description'])));
        if($description == ''){
          $description = str_replace('&', '&amp;',$row2['product_name']);
        }
        /*

        <product_type>'.str_replace('&','&amp;',$row2['category_name']).'</product_type>
        */
        $brand = 'PDR-ONLINE';
        $url = $site_url_b.$this->modx->makeUrl($row2['product_main_cat']).$row2['product_url'].'/';

        $items .= '<item>
<g:id>'.$row2['product_id'].'</g:id>
<g:title>'.str_replace('&', '&amp;',$row2['product_name']).'</g:title>
<g:description><![CDATA['.$description.']]></g:description>
<g:link>'.$url.'</g:link>
'.$images_in.'
<g:brand>'.$brand.'</g:brand>
<g:condition>new</g:condition>
<g:availability>'.$stock.'</g:availability>
'.$price.$sale_price.'
</item>';

      }
      $xml = '<?xml version="1.0"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
  <title>'.$this->modx->config['site_name'].'</title>
  <link>'.$site_url.'</link>
  <description>PDR-ONLINE товари</description>
  '.$items.'
</channel>
</rss>';

      file_put_contents(MODX_BASE_PATH . 'facebook.xml', $xml);
      file_put_contents(MODX_BASE_PATH . 'google.xml', $xml);

    }

    function deleteProduct($id) {
      $this->db->query('DELETE FROM `modx_a_products` WHERE product_id = "'.$this->db->escape($id).'" LIMIT 1');
    }
    function getProduct ($id) {
      return $this->db->query("
            SELECT * FROM `modx_a_products` p 
            WHERE p.product_id = '".$this->db->escape($id)."' LIMIT 1");
    }

    function getProductListWithOrder ($search = '', $category = 0, $orderby = ' ORDER BY p.product_created DESC ', $moderate = '-1', $limit = '20'){
      if($limit == ''){
        $limit = '20';
      }
      //var_dump($moderate);die;
      $page  = isset($_GET['p']) ? ($this->number($_GET['p'])) * $limit : 0;
      if($category != 0){
        $cat = ' AND FIND_IN_SET ('.$category.',product_main_cat ) ';
      }
      if($moderate == '-1' OR $moderate == ''){
        $mod = '';
      }else{
        $mod = 'AND p.product_visible = "'.$this->db->escape($moderate).'"';
      }
      if($orderby == ''){
        $orderby = ' ORDER BY p.product_created DESC ';
      }
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_products` p
            WHERE 0=0
            ".$mod."
            ".$cat." 
            ".(!empty($search) ? "AND ( p.product_id = '".$this->db->escape($search)."' 
                          OR p.product_id = '".$this->db->escape($search)."'
                          OR p.product_article LIKE '%".$this->db->escape($search)."%' 
                          OR p.product_name LIKE '%".$this->db->escape($search)."%' )" : "")." 
   
                 ".$orderby."
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }
    function getProductTop($top){
      switch($top){
        case "0":
        default:
          $res = '';
        break;
        case "1":
          $res = '<span class="label label_top">Топ продажів</span>';
        break;
        case "2":
          $res = '<span class="label label_sale">Акція</span>';
        break;
        case "3":
          $res = '<span class="label label_new">Новинка</span>';
        break;
      }
      return $res;
    }

    function checkInstructorWish($instructor,$user){
      $status = '';
      if($user != '' AND $user != '0'){
        if(in_array($instructor, $_SESSION['favorite_instructor'])){
          $status = 'active';
        }
      }
      return $status;
    }
    function maskStringHidden($input) {
        // Получаем первые две буквы
        $firstTwo = mb_substr($input, 0, 2);
        
        // Длина строки, которую нужно заменить на звёздочки
        $remainingLength = mb_strlen($input) - 2;
        
        // Создаём строку из звёздочек нужной длины
        $maskedPart = str_repeat('*', $remainingLength);
        
        // Конкатенируем первые две буквы и звёздочки
        $result = $firstTwo . $maskedPart;
        
        return $result;
    }

    function formatDateFrom($timestamp) {
        $minutes = floor($timestamp / 60);
        $hours = floor($minutes / 60);
        $days = floor($hours / 24);
        $months = floor($days / 30);
        $years = floor($months / 12);

        $months = $months % 12;
        $days = $days % 30;
        $hours = $hours % 24;
        $minutes = $minutes % 60;
        $out = '';
        if($years > 0){
          $out .= $years.' років ';
        }
        if($months > 0){
          $out .= $months.' місяців ';
        }
        if($days > 0){
          $out .= $days.' днів';
        }
        return $out;
    }

    function formatPhoneNumber($number) {
        // Удаляем все символы, кроме цифр
        $cleaned = preg_replace('/[^0-9]/', '', $number);

        // Форматируем номер
        $formatted = sprintf('+%s (%s) %s-%s-%s',
            substr($cleaned, 0, 2),  // +38
            substr($cleaned, 2, 3),  // (093)
            substr($cleaned, 5, 3),  // 668
            substr($cleaned, 8, 2),  // 68
            substr($cleaned, 10, 2)  // 40
        );

        return $formatted;
    }


    function getTelegram() {
     
      $limit = 50;
      $page  = isset($_REQUEST['p']) ? ($this->number($_REQUEST['p'])) * $limit : 0;
      $query ="
      SELECT SQL_CALC_FOUND_ROWS *
      FROM `modx_a_telegram` 
      WHERE 0=0
      ORDER BY id DESC
        LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }    

    function getScheduleListWithOrder ($search = '', $status = 0, $orderby = ' ORDER BY p.id ASC ', $limit = '50'){
      if($limit == ''){
        $limit = '50';
      }
      //var_dump($moderate);die;
      $page  = isset($_GET['p']) ? ($this->number($_GET['p'])) * $limit : 0;

      if($status == '-1' OR $status == ''){
        $sta = '';
      }else{
        $sta = 'AND p.status = "'.$this->db->escape($status).'"';
      }
      if($orderby == ''){
        $orderby = ' ORDER BY p.id ASC ';
      }
      $query = "
            SELECT SQL_CALC_FOUND_ROWS
              *
            FROM `modx_a_instructor_to_user` p
            WHERE 0=0
            ".$sta."
            ".(!empty($search) ? "AND ( p.row_id = '".$this->db->escape($search)."' 
                          OR p.instructor_name LIKE '%".$this->db->escape($search)."%'
                          OR p.user_name LIKE '%".$this->db->escape($search)."%' 
                          OR p.user_phone LIKE '%".$this->db->escape($search)."%' )" : "")." 
   
                 ".$orderby."
            LIMIT ".$page.", ".$limit;
      $res = $this->db->query($query);
      $pages = $this->db->getRow($this->db->query("SELECT FOUND_ROWS() AS 'cnt'"));
      $this->modx->setPlaceholder("max_items", $pages['cnt']);
      $this->modx->setPlaceholder("limit_items", $limit);
      return $res;
    }
    function setLog($type,$data){
      //1-manager_bill, 2-itu_update_row, 3-instructor_update
      $this->db->query('INSERT INTO `modx_a_manager_log` SET log_user = "'.$this->db->escape($_SESSION['webuser']['internalKey']).'", log_type = "'.$this->db->escape($type).'", log_info = "'.$this->db->escape($data).'" ');
    }

  } // end class
} // end if class exists