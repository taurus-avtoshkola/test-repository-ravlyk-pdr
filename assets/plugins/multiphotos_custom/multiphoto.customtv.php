<link href='<?=$modx->config['base_url']?>assets/tvs/morephoto/style.css' rel='stylesheet' type='text/css'>
<style>
.mpTv>div,.item div{float:left;width:<?=$modx->config['thumbWidth']?>px;height:<?=$modx->config['thumbHeight']?>px;line-height:<?=$modx->config['thumbHeight']?>px;text-align:center;background-color:#fff}
.item img {display:inline-block;vertical-align:middle;max-height:<?=$modx->config['thumbHeight']?>px;max-width:<?=$modx->config['thumbWidth']?>px; width: auto; height: auto;margin:0}
</style>
<!--<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js"></script>-->
<script>
/*if (typeof jQuery == 'undefined') {
	document.write(unescape('<script type="text/javascript" src="http://code.jquery.com/jquery-1.8.3.min.js">%3C/script%3E'));
}*/
//$j = jQuery.noConflict();
$j.getScript('<?=$modx->config['base_url']?>assets/tvs/morephoto/jquery.multiphotos.js',function(){
	$j('#tv<?=$field_id?>').multiphotos({'baseUrl':'<?=$modx->config['base_url']?>'});
});
</script>
<input type='text' style="width:100%;display:none;" name='tv<?=$field_id?>' id='tv<?=$field_id?>' value='<?=$field_value?>' />
