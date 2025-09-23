<?php

ini_set('max_execution_time', '1700');
set_time_limit(1700);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json; charset=utf-8');
http_response_code(200);
ini_set('display_errors', '1');
error_reporting(E_ERROR);

$server = "bp489156.mysql.tools";
$username = "bp489156_pdrplaned";
$password = "+3yGe3^U5i";
$database = "bp489156_pdrplaned";
$table = "planed";

function send_forward($inputJSON, $link){
    $request = 'POST';	
    $descriptor = curl_init($link);
     curl_setopt($descriptor, CURLOPT_POSTFIELDS, $inputJSON);
     curl_setopt($descriptor, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($descriptor, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
     curl_setopt($descriptor, CURLOPT_CUSTOMREQUEST, $request);
    $itog = curl_exec($descriptor);
    curl_close($descriptor);
    return $itog;
}
function send_bearer($url, $token, $type = "GET", $param = []){
    $descriptor = curl_init($url);
     curl_setopt($descriptor, CURLOPT_POSTFIELDS, json_encode($param));
     curl_setopt($descriptor, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($descriptor, CURLOPT_HTTPHEADER, array('User-Agent: M-Soft Integration', 'Content-Type: application/json', 'Authorization: Bearer '.$token)); 
     curl_setopt($descriptor, CURLOPT_CUSTOMREQUEST, $type);
    $itog = curl_exec($descriptor);
    curl_close($descriptor);
    return $itog;
}
function send_request($url, $header = [], $type = 'GET', $param = [], $raw = "json") {
    $descriptor = curl_init($url);
    if ($type != "GET") {
        if ($raw == "json") {
             curl_setopt($descriptor, CURLOPT_POSTFIELDS, json_encode($param));
            $header[] = 'Content-Type: application/json';
        } else if ($raw == "form") {
             curl_setopt($descriptor, CURLOPT_POSTFIELDS, http_build_query($param));
            $header[] = 'Content-Type: application/x-www-form-urlencoded';
        } else {
             curl_setopt($descriptor, CURLOPT_POSTFIELDS, $param);
        }
    }
    $header[] = 'User-Agent: M-Soft Integration(https://mufiksoft.com)';
     curl_setopt($descriptor, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($descriptor, CURLOPT_HTTPHEADER, $header); 
     curl_setopt($descriptor, CURLOPT_CUSTOMREQUEST, $type);
    $itog = curl_exec($descriptor);
    //$itog["code"] = curl_getinfo($descriptor, CURLINFO_RESPONSE_CODE);
    curl_close($descriptor);
    return $itog;
}
function generate_string($strength = 10) {
    $symbols = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $input_length = strlen($symbols);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $symbols[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }
    return $random_string;
}

$sqlConnect = mysqli_connect($server, $username, $password, $database);
mysqli_set_charset($sqlConnect, "utf8mb4");
if ($sqlConnect === false) {
    $result["state"] = false;
    $result["error"]["message"] = "error connecting to MySQL";
    echo json_encode($result);
    exit;
}
