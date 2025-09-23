//<?php
/* 
* miltiphotos_custom
*
* @events OnDocFormRender
*
*/

$e = &$modx->Event;
if ($e->name == 'OnDocFormRender') {
	$output .= '<link href="/assets/plugins/multiphotos_custom/style.css" rel="stylesheet" type="text/css">';
	$output .= '<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>';
	$output .= "<script>
	jQuery.getScript('".$modx->config['base_url']."assets/plugins/multiphotos_custom/jquery.multiphotos.js',function(){
	  jQuery('#tv14').multiphotos({'baseUrl':'".$modx->config['base_url']."'});
	  });
	</script>";
	$e->output($output);
}
