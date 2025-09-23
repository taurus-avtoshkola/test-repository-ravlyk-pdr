<?php
if (!class_exists('keycrm')) {
  /**
   * Class keycrm
   */
  class Keycrm  {
    var $token = null;
    var $url = 'https://openapi.keycrm.app';
    var $api_version = 'v1';

    function __construct ($token){
      $this->token = $token;
    }

    public function go($action, $params = array()){
        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->api_version."/".$action);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            'Authorization:  Bearer ' . $this->token)
        );
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        return $data;
    }
    public function go_get($action, $params = array()){
        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->api_version."/".$action);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            'Authorization:  Bearer ' . $this->token)
        );
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        return $data;
    }


    public function go_put($action, $params = array()){
        $data_string = json_encode($params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->url."/".$this->api_version."/".$action);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-type: application/json",
            "Accept: application/json",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            'Authorization:  Bearer ' . $this->token)
        );
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result, true);
        return $data;
    }


  }
}