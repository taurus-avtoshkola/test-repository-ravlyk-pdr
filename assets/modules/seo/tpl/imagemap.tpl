<form action="<?=$url?>&get=imagemap" method="post">
	<p>С помощью файла Sitemap веб-мастеры могут сообщать поисковым системам о веб-страницах, которые доступны для сканирования. Файл Sitemap представляет собой XML-файл, в котором перечислены URL-адреса веб-сайта в сочетании с метаданными, связанными с каждым URL-адресом (дата его последнего изменения; частота изменений; его приоритетность на уровне сайта), чтобы поисковые системы могли более грамотно сканировать этот сайт</p>
	<textarea name="post" class="span12"><?=file_get_contents(ROOT."/imagemap.php")?></textarea>
	<input type="submit" value="Обновить алгоритм построения sitemap-images.xml" class="btn btn-primary">
	<a href="<?=$url?>&get=imagemap&do=reconstruct" class="btn btn-info pull-right">Обновить <b> sitemap-images.xml</b></a>
</form>