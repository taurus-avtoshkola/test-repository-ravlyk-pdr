<?php
/**
 * Языковой плагин
 */

$modx->config['lang'] = in_array($_GET['lang'], explode(",", $modx->config['lang_list'])) ? $_GET['lang'] : $modx->config['lang_default'];

switch ($modx->event->name) {
	case "OnWebPageInit":

    if ($modx->config['lang_enable']) {

      if(!isset($_GET['lang'])){
        $_GET['lang'] = 'ua';
      }
      // $modx->config['lang'] = in_array($_GET['lang'], explode(",", $modx->config['lang_list'])) ? $_GET['lang'] : $modx->config['lang_default'];
      if (!in_array($_GET['lang'], explode(",", $modx->config['lang_list'])) ) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: /".$modx->config['lang']."/".$_GET['q']);
        die;
      }

    }

	break;
  case "OnLoadWebDocument":

    if (is_array($_POST)) foreach($_POST as $k => $v) if (!is_array($v)) $modx->documentObject['post_'.strip_tags($k)] = strip_tags($v);
    if (is_array($_GET)) foreach($_GET as $k => $v) if (!is_array($v)) $modx->documentObject['get_'.strip_tags($k)] = strip_tags($v);
    if (is_array($_SESSION)) foreach($_SESSION as $k => $v) if (!is_array($v)) $modx->documentObject['ses_'.strip_tags($k)] = strip_tags($v);
    if ($modx->config['lang_enable']) {
      // multilanguage fields
      $danger_fields = Array('pagetitle','longtitle','description','link_attributes','introtext','content','menutitle');
      foreach($danger_fields as $field)
        $modx->documentObject[$field] = $modx->documentObject[$field.'_'.$modx->config['lang']];
      // tv parameters
      foreach($modx->documentObject as $field)
        if (is_array($field))
          if (substr($field[0], -3) == "_".$modx->config['lang'])
            $modx->documentObject[str_replace(substr($field[0], -3), "", $field[0])] = $modx->documentObject[$field[0]];
    }

  break;
  case "OnParseDocument":
    if ($modx->config['lang_enable']) {
      // parse language strings
      preg_match_all('/\[#(\d+)#\]/', $modx->documentOutput, $match);
      $dump = $_SERVER['DOCUMENT_ROOT']."/assets/modules/lang/dump.php";
      if (file_exists($dump)) {
        require $dump;
        if ($match[0])
          foreach ($match[0] as $key => $value) 
            $modx->documentOutput = str_replace($value, $l[$match[1][$key]][$modx->config['lang']], $modx->documentOutput);
      }
      // parse language urls
      preg_match_all('/\[~~(\d+)~~\]/', $modx->documentOutput, $match);

      if ($match[0])
        foreach ($match[0] as $key => $value)
          if ($match[1][$key] == $modx->config['site_start']){ 
            if($modx->config['lang'] == 'ua'){
              $modx->documentOutput = str_replace($value, "/", $modx->documentOutput);
            }else{
              $modx->documentOutput = str_replace($value, "/".$modx->config['lang']."/", $modx->documentOutput);
            }
          }else{
            $modx->documentOutput = str_replace($value, $modx->makeUrl($match[1][$key], '', '', 'full'), $modx->documentOutput);
          }
    }
    // ditto 1st page pagination seo fix
    $modx->documentOutput = str_replace("?start=0", "", $modx->documentOutput);
    break;
}