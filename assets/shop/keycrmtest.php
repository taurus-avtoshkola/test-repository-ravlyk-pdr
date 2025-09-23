<?php
die;
define ('ROOT', dirname(__FILE__));
include ROOT . "/php/keycrm.php";

$apikey = 'MjBmOGFmNzhjYzI2NjY1Zjc0OTVhMjMxOThkNjI5YmFmN2VlNWYxMg';


$keycrm = new Keycrm($apikey);



$data = [
	    "title" => $title,
	    "source_id" => '3', // ідентифікатор джерела
	    "pipeline_id" => '1', // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => 'ТЕСТ', // ПІБ покупця
		    "email" => 'xfriksx@gmail.com', // ПІБ покупця
		    "phone" => $r['phone'] // номер телефону покупця
	    ],
	    "manager_comment" => $utm['ref'],
	    "utm_source" => $utm['utm_source'], // джерело компанії
	    "utm_medium" => $utm['utm_medium'], // тип трафіку
	    "utm_campaign" => $utm['utm_campaign'], // назву компанії
	    "utm_term" => $utm['utm_term'], // ключове слово
	    "utm_content" => $utm['utm_content'], // ідентифікатор оголошення
		"products"=> [
		        [
		            "price"=> $price,
		            "quantity"=> 1, 
		            "name"=> $title,
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1004",
		      "value" => '123'
		    ]
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
var_dump($keycrm);die;

?>