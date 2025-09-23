<?php
if (!class_exists('Esputnik')) {
  /**
   * Class Esputnik
   */
  class Esputnik  {
    var $user = null;
    var $pass = null;
    var $url = 'https://esputnik.com/api';
    var $api_version = 'v1';

    function __construct ($user,$pass){
      $this->user = $user;
      $this->pass = $pass;
    }

    public function subscribe_contact($post){
        $contact = array();
        if($post['fullname'] != ''){
            $contact['firstName'] = $post['fullname'];
        }
        if($post['lastName'] != ''){
            $contact['lastName'] = $post['lastname'];
        }
        if($post['email'] != ''){
            $contact['channels'][] = array('type'=>'email', 'value' => $post['email']);
        }
        if($post['phone'] != ''){
            $contact['channels'][] = array('type' => 'sms', 'value' => $post['phone']);
        }
        if($post['city'] != ''){
            $contact['address']['town'] = $post['city'];
        }
        if($post['webi_date'] != ''){
            $contact['fields'][] = array('id' => 254532, 'value' => $post['webi_date']);
        }
        $params['contact'] = $contact;
        
        if($post['groups'] != ''){
            $groups = explode(',',$post['groups']);
            $params['groups'] = $groups;
        }

        return $this->go('contact/subscribe',$params);
    }


    public function subscribe($post){
        $contact = array();
        if($post['fullname'] != ''){
            $contact['firstName'] = $post['fullname'];
        }
        if($post['lastName'] != ''){
            $contact['lastName'] = $post['lastname'];
        }
        if($post['email'] != ''){
            $contact['channels'][] = array('type'=>'email', 'value' => $post['email']);
        }
        if($post['phone'] != ''){
            $contact['channels'][] = array('type' => 'sms', 'value' => $post['phone']);
        }
        if($post['city'] != ''){
            $contact['address']['town'] = $post['city'];
        }
        
        if($post['webi_date'] != ''){
            $contact['fields'][] = array('id' => 254532, 'value' => $post['webi_date']);
        }
        
        return $this->addContact($contact);
    }
    public function addContact($params){
        return $this->go('contact',$params);
    }
    public function getAddressBook(){
        return $this->go('addressbooks');
    }

    public function updateContact($post,$user_id){

        $contact = array();
        if($post['fullname'] != ''){
            $contact['firstName'] = $post['fullname'];
        }
        if($post['lastName'] != ''){
            $contact['lastName'] = $post['lastname'];
        }
        if($post['email'] != ''){
            $contact['channels'][] = array('type'=>'email', 'value' => $post['email']);
        }
        if($post['phone'] != ''){
            $contact['channels'][] = array('type' => 'sms', 'value' => $post['phone']);
        }
        if($post['city'] != ''){
            $contact['address']['town'] = $post['city'];
        }
        if($post['webi_date'] != ''){
            $contact['fields'][] = array('id' => 254532, 'value' => $post['webi_date']);
        }
        return $this->goPut('contact/'.$user_id,$contact);
    }

    public function addToGroup($group_id,$user_id){
        $params = array();
        if($user_id != ''){
            $params['contactIds'] = array($user_id);
        }
        return $this->go('group/'.$group_id.'/contacts/attach',$params);
    }


    public function getGroups($name){
        return $this->go('groups?name='.$name);
    }
    public function getBalance(){    
        return $this->go('balance');
    }
    function go($action, $params = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        if(count($params) > 0){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $this->url.'/'.$this->api_version.'/'.$action);
        curl_setopt($ch,CURLOPT_USERPWD, $this->user.':'.$this->pass);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);

        $output = curl_exec($ch);
        preg_match('/\{.*\}/', $output, $matches);
        $json_string = $matches[0];
        $data = json_decode($json_string, true);
        curl_close ($ch);
        return $data;
    }


    function goPut($action, $params = array()){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        if(count($params) > 0){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
        }
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json', 'Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $this->url.'/'.$this->api_version.'/'.$action);
        curl_setopt($ch,CURLOPT_USERPWD, $this->user.':'.$this->pass);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_SSLVERSION, 6);

        $output = curl_exec($ch);
        preg_match('/\{.*\}/', $output, $matches);
        $json_string = $matches[0];
        $data = json_decode($json_string, true);
        curl_close ($ch);
        return $data;
    }



  }
}