<?php
if (!class_exists('Gpt')) {
  /**
   * Class Gpt
   */
  class Gpt  {
    var $modx = null;
    var $db   = null;
    var $key = 'sk-wxyJQ8y2VMFHoBAUpvh26obkRXAiNT1Ctir8fM3blcT3BlbkFJ8Y5UFMSMIUig57CFRjtkkUVarJhFs3VezjOx6W8gEA';//'sk-proj-ALPTy4S3g7mMXPZUhqAlT3BlbkFJbEHazM6xo9HNUrtMW9Yq';
    var $url = 'https://api.openai.com/v1/';
    var $model = 'gpt-4o'; //'gpt-4-turbo'; //  'gpt-3.5-turbo';
    var $assistent_id = 'asst_NwHdSjlUDO8BE3zoXDQC30lA';
    var $organization_id = 'org-VHf5ZDcATiWVrmGYh1nFGSGr';
    var $max_tokens = 1024;
    var $temperature = 0.8;
    function __construct ($modx){
      $this->modx = $modx;
      $this->db   = $modx->db;
    }
    function assistents(){
      $limit = 20;
      $api = $this->key;

      $ch = curl_init();

      $header = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $api,
      'OpenAI-Beta: assistants=v2'
      ];

      curl_setopt($ch, CURLOPT_URL, $this->url.'assistants?order=desc&limit='.$limit);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

      if(curl_error($ch)) {
        $res = 'Щось пішло не так! Спробуйте пізніше';
      } else {
        $response = json_decode(curl_exec($ch), true);
        $res = $response;
      }
      curl_close($ch);
      return $res;
    }


    function sendCurlRequest($token, $url, $method = 'GET', $data = null) {
        $ch = curl_init();

        // Общие параметры для всех запросов
        $commonOptions = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST  => $method,
        ];

        // Установка общих параметров
        curl_setopt_array($ch, $commonOptions);

        // Установка URL
        curl_setopt($ch, CURLOPT_URL, $url);

        // Установка данных для POST-запросов
        if (($method === 'POST' || $method === 'PUT') && $data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        // Установка заголовков
        $headers = [
            'OpenAI-Beta: assistants=v2',
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json',
        ];
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }

        // Выполнение запроса
        $response = curl_exec($ch);

        // Закрытие дескриптора
        curl_close($ch);

        return $response;
    }

    function threadCreate(){
      $data = json_encode((object)[]);
      $response = $this->sendCurlRequest($this->key, $this->url.'threads', 'POST', $data);
      $responseData = json_decode($response, true);
      $threadId = $responseData['id'];
      return $threadId;
    }

    function threadDelete($threadId){
      $data = json_encode((object)[]);
      $response = $this->sendCurlRequest($this->key, $this->url."threads/".$threadId, 'DELETE', $data);
      $responseData = json_decode($response, true);

    }


    function threadMessageI($threadId, $message, $img = ''){


      $content[] = array('type' => 'text', 'text' => $message);
      $content[] = array('type' => 'image_url', 'image_url' => array('url' => $img));



      $data = json_encode([
          'role' => 'user',
          'content' => $content
      ]);
      //["role" => "system", "content" => $context]

      $response = $this->sendCurlRequest($this->key, $this->url."threads/".$threadId."/messages", 'POST', $data);
      $responseData = json_decode($response, true);
      return $responseData['id'];
    }

    function threadMessage($threadId, $message, $context = ''){


      $data = json_encode([
          'role' => 'user',
          'content' => $message
      ]);
      //["role" => "system", "content" => $context]

      $response = $this->sendCurlRequest($this->key, $this->url."threads/".$threadId."/messages", 'POST', $data);
      $responseData = json_decode($response, true);
      return $responseData['id'];
    }


    function threadRun($threadId, $instructions = ''){
    
      if($instructions and $instructions != '' and $instructions != 'no'){
        $data = json_encode(['assistant_id' => $this->assistent_id, 'instructions' => $instructions]);
      }else{
        $data = json_encode(['assistant_id' => $this->assistent_id]);
      }

      $creationResponse = $this->sendCurlRequest($this->key, $this->url."threads/".$threadId."/runs", 'POST', $data);
      $creationResponseData = json_decode($creationResponse, true);

      $runId = $creationResponseData['id'];

      return $runId;
    }

    function waitTillRunComplete($threadId, $runId) {

        do {
            $statusResponse = $this->sendCurlRequest($this->key, $this->url."/threads/".$threadId."/runs/".$runId);
            $statusResponseData = json_decode($statusResponse, true);
            $status = $statusResponseData['status'];
            if (!in_array($status, ['queued', 'in_progress'])) {
                return;
            }
            sleep(1);
        } while (true);
    }



    function threadMessages($threadId){
      $response = $this->sendCurlRequest($this->key, $this->url."threads/".$threadId."/messages", 'GET', null);
      $responseData = json_decode($response, true);
      $r['message_id'] = $responseData['data'][0]['id'];
      $r['answer'] = $responseData['data'][0]['content'][0]['text']['value'];
      return $r;
    }

    function askQuestion($question){

      $api = $this->key;
      $action = 'chat/completions';

      $ch = curl_init();
      $post_fields = array(
      "model" => $this->model,
      "messages" => array(
      array(
      "role" => "user",
      "content" => $question
      )
      ),
      "max_tokens" => $this->max_tokens,
      "temperature" => $this->temperature
      );
      $header = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $api
      ];
      curl_setopt($ch, CURLOPT_URL, $this->url.$action);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

      if(curl_error($ch)) {
        $res = 'Щось пішло не так! Спробуйте пізніше';
      } else {
        $response = json_decode(curl_exec($ch), true);
        $res = $response['choices'][0]['message']['content'];
      }
      curl_close($ch);
      return $res;
    }




/*
    function threadCreate(){

      $api = $this->key;
      $action = 'threads';

      $ch = curl_init();
      $post_fields = array(
      "model" => $this->model,
      "assistant_id" => $this->assistent_id,
      "messages" => array(
      array(
      "role" => "user",
      "content" => $question
      )
      ),
      "max_tokens" => $this->max_tokens,
      "temperature" => $this->temperature
      );
      $header = [
      'Content-Type: application/json',
      'Authorization: Bearer ' . $api,
      'OpenAI-Beta: assistants=v2'
      ];
      curl_setopt($ch, CURLOPT_URL, $this->url.$action);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_fields));
      curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

      if(curl_error($ch)) {
        $res = 'Щось пішло не так! Спробуйте пізніше';
      } else {
        $response = json_decode(curl_exec($ch), true);
        $res = $response['choices'][0]['message']['content'];
      }
      curl_close($ch);
      return $res;
    }
*/
/*

messages=[
    {
      "role": "user",
      "content": [
        {"type": "text", "text": "What’s in this image?"},
        {
          "type": "image_url",
          "image_url": {
            "url": "https://upload.wikimedia.org/wikipedia/commons/thumb/d/dd/Gfp-wisconsin-madison-the-nature-boardwalk.jpg/2560px-Gfp-wisconsin-madison-the-nature-boardwalk.jpg",
          },
        },
      ],
    }
  ],

*/








  } // end class
} // end if class exists