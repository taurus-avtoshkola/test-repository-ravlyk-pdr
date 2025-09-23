<?php
// Подключаем
define('MODX_API_MODE', true);
require $_SERVER['DOCUMENT_ROOT'].'/index.php';

$lim   = $modx->config['mailer_smtp_limit'] == "" ? 10 : $modx->config['mailer_smtp_limit'];
$query = "select * 
		  from `modx_a_mailer` m 
		  join `modx_a_mailer_templates` t on t.template_id = m.tpl_id 
		  join `modx_a_mailer_users` 	 u on u.user_id = m.user_id 
		  where m.mailed = 0
		  limit $lim ";
		  // echo $query;
$list  = $modx->db->query($query);
$host  = $modx->config['site_url'];

while ($l = $modx->db->getRow($list)) {
	$letter = str_replace("{username}", $l['user_name'], $l['template_post']);
	$theme  = str_replace("{username}", $l['user_name'], $l['template_subject']);

	$letter = str_replace('<img src="', '<img src="'.$host, $letter);
	$letter = str_replace('<a href="', '<a href="'.$host, $letter);


	$message = $modx->parseDocumentSource($modx->parseChunk('mail_mailer',
	array(
	  'inner'             => $letter,
	  'site_url'          => $host, 
	  'site_name'         => $modx->config['site_name'])
	)
	);

	$shop->mail($l['user_email'], $theme, $message);

	$modx->db->query("update `modx_a_mailer` set mailed = 1 where user_id = '".$l['user_id']."' and tpl_id = '".$l['template_id']."'");
}
echo $modx->db->getRecordCount($list);

die(".");