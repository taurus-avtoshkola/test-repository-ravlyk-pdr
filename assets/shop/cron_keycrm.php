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

include MODX_BASE_PATH . "assets/shop/php/keycrm.php";
$keycrm = new Keycrm(token: $modx->config['key_crm_api']);


//відправка Практичні уроки з ім‘ям заявка на практичні уроки
$q = $modx->db->query('SELECT * FROM `modx_a_call_instructor` WHERE keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);

	$title = 'Заявка на практичні уроки';
	

	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm_3'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "phone" => $r['phone'] // номер телефону покупця
	    ],
	    "manager_comment" => $utm['ref'],
	    "utm_source" => $utm['utm_source'], // джерело компанії
	    "utm_medium" => $utm['utm_medium'], // тип трафіку
	    "utm_campaign" => $utm['utm_campaign'], // назву компанії
	    "utm_term" => $utm['utm_term'], // ключове слово
	    "utm_content" => $utm['utm_content'], // ідентифікатор оголошення
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		    	"uuid" => "LD_1003",
		    	"value" => $r['instructor_name']
		    ]
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);

    $modx->db->query('UPDATE `modx_a_call_instructor` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//відправка безкоштовного уроку
$q = $modx->db->query('SELECT * FROM `modx_a_testlesson` WHERE keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	switch($r['type']){
		case "1":
			$price = round($modx->config['price_base']-500);
			$title = 'Гайд';
		break;
		case "0":
		default:
			$price = $modx->config['price_base'];
			$title = 'Безкоштовний урок';
		break;
	}

	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		    ]
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);

    $modx->db->query('UPDATE `modx_a_testlesson` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//відправка Заявки сторінка міста
$q = $modx->db->query('SELECT * FROM `modx_a_city_form` WHERE keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	switch($r['type']){
		default:
		case "1":
			$title = 'Заявка зі сторінки міста';
		break;
	}

	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
		    "phone" => $r['phone'] // номер телефону покупця
	    ],
	    "manager_comment" => $utm['ref'],
	    "utm_source" => $utm['utm_source'], // джерело компанії
	    "utm_medium" => $utm['utm_medium'], // тип трафіку
	    "utm_campaign" => $utm['utm_campaign'], // назву компанії
	    "utm_term" => $utm['utm_term'], // ключове слово
	    "utm_content" => $utm['utm_content'], // ідентифікатор оголошення
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ]
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);

    $modx->db->query('UPDATE `modx_a_city_form` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}


//відправка запису на майстер клас
$q = $modx->db->query('SELECT * FROM `modx_a_master` WHERE keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);

	$data = [
	    "title" => 'Майстер-клас',
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> 1,
		            "quantity"=> 1, 
		            "name"=> 'Майстер-клас',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ]
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);

    $modx->db->query('UPDATE `modx_a_master` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}


//відправка запису підписки і не оплата. (через 30 хвилин після запису)


$time = time()-30*60;
$q = $modx->db->query('SELECT *, m.id as id FROM `modx_a_subscribe` m LEFT JOIN `modx_web_user_attributes` wua ON wua.internalKey = m.user_id WHERE m.keycrmsent = "0" AND m.start < "'.$modx->db->escape($time).'"  ');

while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);

	if($r['status_pay'] == 1){
		$status = 'Сплачено';
	}else{
		$status = 'Не сплачено';
	}

	$data = [
	    "title" => 'ПДР підписка:'.$status,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm_2'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['cost'],
		            "quantity"=> 1, 
		            "name"=> 'ПДР підписка',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ]
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_subscribe` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}




//відправка онлайн курс Оплачених:
$q = $modx->db->query('SELECT * FROM `modx_a_online` m WHERE m.keycrmsent = "0" AND m.status_pay = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	if($r['status_pay'] == '1'){
		$title = 'Сплачений онлайн курс';
	}else{
		$title = 'Не сплачений онлайн курс';
	}
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Онлайн курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_online` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//відправка онлайн курс НЕ оплачених більше 15 хв:
$timeplus = (time()-(15*60));
$q = $modx->db->query('SELECT * FROM `modx_a_online` m WHERE m.keycrmsent = "0" AND m.status_pay = "0" AND reg_date < "'.$modx->db->escape($timeplus).'" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	if($r['status_pay'] == '1'){
		$title = 'Сплачений онлайн курс';
	}else{
		$title = 'Не сплачений онлайн курс';
	}
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Онлайн курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_online` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//Отправка в воронку 2 только оплаченых
$q = $modx->db->query('SELECT * FROM `modx_a_online` m WHERE m.keycrmsent_2 = "0" AND m.status_pay = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	$title = 'Сплачений онлайн курс';
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm_3'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Онлайн курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_online` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent_2 = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');

}


//Відправка людей які зареєструвались на сторінці автоінструктори.
$q = $modx->db->query('SELECT * FROM `modx_web_user_attributes` WHERE keycrmsent = "0" AND reg_from_instructors = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	$title = 'Потрібен інструктор';
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm_3'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
		    "phone" => $r['phone'] // номер телефону покупця
	    ],
	    "manager_comment" => $utm['ref'],
	    "utm_source" => $utm['utm_source'], // джерело компанії
	    "utm_medium" => $utm['utm_medium'], // тип трафіку
	    "utm_campaign" => $utm['utm_campaign'], // назву компанії
	    "utm_term" => $utm['utm_term'], // ключове слово
	    "utm_content" => $utm['utm_content'], // ідентифікатор оголошення
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ]		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_web_user_attributes` SET keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');

}










//відправка смарт курс Оплачених:
$q = $modx->db->query('SELECT * FROM `modx_a_video` m WHERE m.keycrmsent = "0" AND m.status_pay = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	if($r['status_pay'] == '1'){
		$title = 'Сплачений смарт курс';
	}else{
		$title = 'Не сплачений смарт курс';
	}
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum_'],
		            "quantity"=> 1, 
		            "name"=> 'Смарт курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_video` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//відправка смарт курс НЕ оплачених більше 15 хв:
$timeplus = (time()-(15*60));
$q = $modx->db->query('SELECT * FROM `modx_a_video` m WHERE m.keycrmsent = "0" AND m.status_pay = "0" AND reg_date < "'.$modx->db->escape($timeplus).'" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	if($r['status_pay'] == '1'){
		$title = 'Сплачений смарт курс';
	}else{
		$title = 'Не сплачений смарт курс';
	}
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Смарт курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_video` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//Отправка в воронку 2 только оплаченых
$q = $modx->db->query('SELECT * FROM `modx_a_video` m WHERE m.keycrmsent_2 = "0" AND m.status_pay = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	$title = 'Сплачений смарт курс';
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => $modx->config['pipeline_key_crm_3'], // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Смарт курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_video` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent_2 = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');

}













//відправка онлайн курс лендінг Оплачених:
$q = $modx->db->query('SELECT * FROM `modx_a_online_landing` m WHERE m.keycrmsent = "0" AND m.status_pay = "1" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	if($r['status_pay'] == '1'){
		$title = 'Сплачений онлайн курс';
	}else{
		$title = 'Не сплачений онлайн курс';
	}
	if($r['landing'] == '1'){
		$landing = 'fastlearning';
	}else{
		$landing = 'easylearning';
	}
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => '9', // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Онлайн курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ],
		    [
		      "uuid" => "LD_1004",
		      "value" => $landing
		    ]

		    


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_online_landing` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}

//відправка онлайн курс НЕ оплачених більше 15 хв:
$timeplus = (time()-(15*60));
$q = $modx->db->query('SELECT * FROM `modx_a_online_landing` m WHERE m.keycrmsent = "0" AND m.status_pay = "0" AND reg_date < "'.$modx->db->escape($timeplus).'" ');
while ($r = $modx->db->getRow($q)) {
	
	$utm = json_decode($r['utm'], true);
	if($r['status_pay'] == '1'){
		$title = 'Сплачений онлайн курс';
	}else{
		$title = 'Не сплачений онлайн курс';
	}
	if($r['landing'] == '1'){
		$landing = 'fastlearning';
	}else{
		$landing = 'easylearning';
	}
	$data = [
	    "title" => $title,
	    "source_id" => $modx->config['source_key_crm'], // ідентифікатор джерела
	    "pipeline_id" => '9', // ідентифікатор воронки (за відсутності параметра буде використана перша воронка у списку)
	    "contact" => [
		    "full_name" => $r['fullname'], // ПІБ покупця
		    "email" => $r['email'], // ПІБ покупця
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
		            "price"=> $r['pay_sum'],
		            "quantity"=> 1, 
		            "name"=> 'Онлайн курс',
		            "picture"=> 'https://pdr-online.com.ua/assets/templates/default/img/no_photo.jpg'
		       ]
		],
		"custom_fields" => [
		    [
		      "uuid" => "LD_1001",
		      "value" => $r['city']
		    ],
		    [
		      "uuid" => "LD_1002",
		      "value" => $r['promocode']
		    ],
		    [
		      "uuid" => "LD_1004",
		      "value" => $landing
		    ]


		    
		]
	];
    $res = $keycrm->go('pipelines/cards',$data);
    $modx->db->query('UPDATE `modx_a_online_landing` SET keycrm = "'.$modx->db->escape($res['id']).'", keycrmsent = "1" WHERE id = "'.$modx->db->escape($r['id']).'" LIMIT 1');


}











/*

$modx->config['site_url_b'] = substr($modx->config['site_url'], 0, -1);
//відправка оплаченого замовлення
$q = $modx->db->query('SELECT * FROM `modx_a_order` WHERE order_status_pay = "1" AND order_keycrmsent = "0" ');

while ($r = $modx->db->getRow($q)) {

	//тут перевірка якщо було вже замовлення за цим клієнтом і чи це частина оплати - тоді його відправляти в гілку того ж замовлення
	$products = $modx->db->makeArray($modx->db->query('SELECT *, op.product_price as price FROM `modx_a_order_products` op LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id WHERE op.order_id = "'.$modx->db->escape($r['order_id']).'" '));
	$pro_m = false;
	foreach($products as $pro){
		if($pro['product_main_product'] != 0){
			$pro_m = true;
		}
	}

	$q_check = $modx->db->query('SELECT *
		FROM `modx_a_order_products` op 
		LEFT JOIN `modx_a_order` o ON op.order_id = o.order_id
		LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id
		WHERE 
		p.product_main_product != "0" AND
		o.order_status_pay = "1" AND 
		o.order_client = "'.$modx->db->escape($r['order_client']).'" AND 
		o.order_client != "0" AND 
		o.order_keycrm != "" 
		ORDER BY o.order_created ASC LIMIT 1');
		
	if($modx->db->getRecordCount($q_check) > 0 AND $pro_m){
		// не перше замовлення відправка оплати в стару гілку
		$r_check = $modx->db->getRow($q_check);
		$crm_id = $r_check['order_keycrm'];

		//додаєм оплату зараз:
		$date = date('Y-m-d H:i:s',$r['order_created']+$modx->config['server_offset_time']);
		$payments = array(
			      "payment_method_id" => 3,
			      "payment_method" => "Банківський переказ",
			      "amount" => $r['order_cost'],
			      "description" => "Оплата на сайті PDR-online",
			      "payment_date" => $date,
			      "status" => "paid"
		);

		$comment = 'Замовлення оновлено сайтом. В замовленні додано оплату';

	    $res = $keycrm->go('order/'.$crm_id.'/payment',$payments);

	    $modx->db->query('UPDATE `modx_a_order` SET order_keycrm = "'.$modx->db->escape($res['destination_id']).'", order_keycrmsent = "1" WHERE order_id = "'.$modx->db->escape($r['order_id']).'" LIMIT 1');




	}else{
		//Нове замовлення відправка:
		$utm = json_decode($r['order_utm'], true);
		$oui = json_decode($r['order_user_info'], true);
		$pro_ar = array();
		$products = $modx->db->query('SELECT *, op.product_price as price FROM `modx_a_order_products` op LEFT JOIN `modx_a_products` p ON p.product_id = op.product_id WHERE op.order_id = "'.$modx->db->escape($r['order_id']).'" ');
		while($pro = $modx->db->getRow($products)){
			if($pro['product_main_product'] != 0){
				//якщо товар груповий (з оплатою частинами)
				$comment = $pro['product_name'];
				$pro_name = $modx->db->getRow($modx->db->query('SELECT * FROM `modx_a_products` WHERE product_id = "'.$modx->db->escape($pro['product_main_product']).'" LIMIT 1'));
				if($pro_name['product_price'] != $pro_name['product_price_a'] AND $pro_name['product_price_a'] != '0.00'){
					$price = $pro_name['product_price_a'];
				}else{
					$price = $pro_name['product_price'];
				}
				$pro_ar[] = array(
					'price'=> $price, 
					'quantity' => $pro['product_count'], 
					'name' => $pro_name['product_name'],
					'sku' => $pro['product_article'],
					'comment' => $comment,
					'picture' => $modx->config['site_url_b'].$pro['product_cover']
				);
			}else{
				//інші товари
				$comment = '';
				$pro_ar[] = array(
					'price'=> $pro['price'], 
					'quantity' => $pro['product_count'], 
					'name' => $pro['product_name'],
					'sku' => $pro['product_article'],
					'comment' => $comment,
					'picture' => $modx->config['site_url_b'].$pro['product_cover']
				);
			}
		}

		$phone = str_replace(' ', '', str_replace(')', '', str_replace('(', '', str_replace('-', '', $oui['phone']))));
   		$user_search = $keycrm->go_get('buyer?limit=15&page=1&filter%5Bbuyer_phone%5D='.$phone);
   		if($user_search['data'][0]['manager_id'] != ''){
   			$manager_id = $user_search['data'][0]['manager_id'];
   		}else{
   			$manager_id = '3';
   		}
		$date = date('Y-m-d H:i:s',$r['order_created']+$modx->config['server_offset_time']);
		$data = [
		      "source_id" => 15, // до якого джерела в KeyCRM додавати замовлення
		      "buyer" => [
		            "full_name"=> $oui['fullname'],
		            "phone"=> $oui['phone'],
			    	"email" => $oui['email'], // ПІБ покупця
		      ],     
    		  "manager_comment" => $utm['ref'],
		      "utm_source" => $utm['utm_source'], // джерело компанії
		      "utm_medium" => $utm['utm_medium'], // тип трафіку
		      "utm_campaign" => $utm['utm_campaign'], // назву компанії
		      "utm_term" => $utm['utm_term'], // ключове слово
		      "utm_content" => $utm['utm_content'], // ідентифікатор оголошення
		      "products"=> $pro_ar,
		      "manager_id" => $manager_id,
			  "payments" => [
			  	[
			      "payment_method_id" => 3,
			      "payment_method" => "Банківський переказ",
			      "amount" => $r['order_cost'],
			      "description" => "Оплата на сайті PDR-online",
			      "payment_date" => $date,
			      "status" => "paid"
			    ]
			  ],
		];
	    $res = $keycrm->go('order',$data);



	    $modx->db->query('UPDATE `modx_a_order` SET order_keycrm = "'.$modx->db->escape($res['id']).'", order_keycrmsent = "1" WHERE order_id = "'.$modx->db->escape($r['order_id']).'" LIMIT 1');

	}

}

*/


?>

