<?php
if (!class_exists('Telegram')) {
  /**
   * Class Telegram
   */
  class Telegram  {
    var $modx = null;
    var $db   = null;

    var $from = 'PDR ONLINE';
	var $avatar = 'https://pdr-online.com.ua/assets/templates/default/img/logo.jpg';
	var $token = '7815070421:AAGw1lQkTdFW0m7NVBju50OJlCgSO6CbwSo';
	var $chat_id = '-1002785637264';
    function __construct ($modx){
      $this->modx = $modx;
      $this->db   = $modx->db;
    }


    function set_webhook($u){
    	$url = 'https://api.telegram.org/bot'.$this->token.'/setwebhook?url='.$u;
    	$r = $this->get_page($url);
    	return $r;
    }

    function remove_webhook(){
    	$url = 'https://api.telegram.org/bot'.$this->token.'/deleteWebhook';
    	$r = $this->get_page($url);
    	return $r;
    }

	function send_message($member, $text){
	    $url = "#";
	    $data['receiver']   = $member;
	    $data['sender'] = array('name' => $this->from, 'avatar' => $this->avatar);
	    $data['type']   = 'text';
	    $data['text']   = $text;
	    $data['min_api_version'] = '1';
	    $r = $this->call($this->token,$url,$data);
	    return $r;
	}


    function get_page($url) {
      $ch     = curl_init();
      curl_setopt($ch, CURLOPT_URL, $url);
      curl_setopt($ch, CURLOPT_HEADER, 0); // пустые заголовки
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // возвратить то что вернул сервер
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // следовать за редиректами
      curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);// таймаут4
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// просто отключаем проверку сертификата
      curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.154 Safari/537.36");
      $result = curl_exec($ch);
      curl_close ($ch);
      return $result;
    }

	function sendMessage($data){
		$method = 'sendMessage';
		$res = $this->sendTelegram($method,$data);
		return $res;
	}
	function escapeMarkdownV2($text) {
	    $specialChars = [
	        '_', '[', ']', '(', ')', '~', '`', '>', '#', '+', '-', '=', '|', '{', '}', '.', '!'
	    ];

	    // Додаємо перед кожним спеціальним символом зворотний слеш
	    foreach ($specialChars as $char) {
	        $text = str_replace($char, '\\' . $char, $text);
	    }

	    return $text;
	}

	function sendToBot($txt){	
		$data['text'] = $this->escapeMarkdownV2($txt);
		$data['parse_mode'] = 'MarkdownV2';//'MarkdownV2';//'html';
		$data['chat_id'] = $this->chat_id;
		$method = 'sendMessage';
		$res = $this->sendTelegram($method,$data);
		return $res;	
	}

	function sendTelegram($method, $data, $headers = []){
		$curl = curl_init();
		curl_setopt_array($curl, [
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'https://api.telegram.org/bot' . $this->token . '/' . $method,
			CURLOPT_POSTFIELDS => json_encode($data),
			CURLOPT_HTTPHEADER => array_merge(array("Content-Type: application/json"))
		]);
		$result = curl_exec($curl);
		curl_close($curl);
		return (json_decode($result, 1) ? json_decode($result, 1) : $result);
	}







  } // end class
} // end if class exists


?>