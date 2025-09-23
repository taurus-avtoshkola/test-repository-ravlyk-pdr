<?php

$parts = explode("/", $_GET['q']);
if (end($parts) == "") unset($parts[count($parts) - 1]);
require_once MODX_BASE_PATH . "assets/shop/shop.class.php";
$shop = new Shop($modx);
switch ($modx->event->name) {
 	case "OnWebPageInit":
 	case "OnPageNotFound":
	    if( preg_match("/(^page-)+[0-9]{1,}\$/",end($parts)) ){
	      $page = end($parts);
	      $page_num = preg_replace("/[^0-9]/", '', $page);
	      if($page_num == 1 OR $page_num == 0){
	        $docIdentifier = str_replace('page-'.$page_num, '', $docIdentifier);
	        array_pop($parts);
	        $redirect_url = $modx->config['site_url'].implode('/',$parts).'/';

	        $modx->sendRedirect($redirect_url,0,'REDIRECT_HEADER','HTTP/1.1 301 Moved Permanently');
	        die;
	      }
	    }


	break;
	case "OnLoadWebDocument":

		if( preg_match("/(^page-)+[0-9]{1,}\$/",end($parts)) ){
	      $page = end($parts);
	      $page_num = preg_replace("/[^0-9]/", '', $page);
	      if(in_array($modx->documentObject['template'], explode(',',$modx->config['templates_vs_paginate']))){
	        if($page_num > 1){
	          $modx->documentObject['pagetitle'] = 'Сторінка '.$page_num.' - '.$modx->documentObject['pagetitle'];
	        }
	      }else{
	        $modx->sendRedirect($modx->makeUrl($modx->documentIdentifier));
	        die;
	      }
	    }

		$search_url = '/'.$_GET['q'];

	    $params = $_GET;
	    unset($params['q'],$params['lang'],$params['city'],$params['district'],$params['transmission'],$params['type'],$params['duration'],$params['sort'],$params['p']);
	    if(count($params) > 0){
	      $search_url .= '?'.http_build_query($params);
	    }

		$seo_url = $modx->db->query('SELECT * FROM `modx_a_seo2url` WHERE seo_url = "'.$modx->db->escape($search_url).'" LIMIT 1');
	    if($modx->db->getRecordCount($seo_url) > 0){
			$seo_url_r = $modx->db->getRow($seo_url);
			$modx->documentObject['pagetitle'] = html_entity_decode($seo_url_r['seo_pagetitle']);
			$modx->documentObject['tv_seo_title'] = html_entity_decode($seo_url_r['seo_title']);
			$modx->documentObject['tv_seo_description'] = html_entity_decode($seo_url_r['seo_description']);
			$modx->documentObject['content'] = html_entity_decode($seo_url_r['seo_content']);
			$modx->setPlaceholder('seo_name_inactive', '1');
	    }



    break;
  	default:
    return;
    break;
}
?>