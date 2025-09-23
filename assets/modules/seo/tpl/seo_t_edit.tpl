
<form action="<?=$url?>&get=seo_t&b=update" method="post">
	<table class="table table-condensed table-bordered table-hover table-striped">
		<tr>
			<td>№</td>
			<td><input type="hidden" name="edit[id]" value="<?=$seo['id']?>"/><?=$seo['id']?></td>
		</tr>
		<tr>
			<td>docid</td>
			<td><input type="text" name="edit[docid]" class="span4" value="<?=$seo['docid']?>" /></td>
		</tr>
		<tr>
			<td>Параметры</td>
			<td><input type="text" name="edit[params]" class="span4" value="<?=$seo['params']?>" /></td>
		</tr>
		<tr>
			<td>Язык</td>
			<td><select name="edit[lang]" class="span4" data-active="<?=$seo['lang']?>"><option value="ru">RU</option><option value="ua">UA</option><option value="en">EN</option></select></td>
		</tr>
		<tr>
			<td>Заголовок</td>
			<td><textarea name="edit[title]" class="span4"><?=$seo['title']?></textarea></td>
		</tr>
		<tr>
			<td>Контент</td>
			<td><textarea name="edit[content]" id="content" class="span4"><?=$seo['content']?></textarea></td>
		</tr>
		<tr>
			<td>SEO title</td>
			<td><textarea name="edit[seo_title]" class="span4"><?=$seo['seo_title']?></textarea></td>
		</tr>
		<tr>
			<td>SEO keywords</td>
			<td><textarea name="edit[seo_keywords]" class="span4"><?=$seo['seo_keywords']?></textarea></td>
		</tr>
		<tr>
			<td>SEO description</td>
			<td><textarea name="edit[seo_description]" class="span4"><?=$seo['seo_description']?></textarea></td>
		</tr>
	</table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Отмена</a>
	  <input type="submit" value="Обновить" class="btn btn-success">

</form>
<?=$tiny_mce?>