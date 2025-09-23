
<form action="<?=$url?>&get=seo_t&b=save" method="post">
	<table class="table table-condensed table-bordered table-hover table-striped">
		<tr>
			<td>docid</td>
			<td><input type="text" name="add[docid]" class="span4" value="" /></td>
		</tr>
		<tr>
			<td>Параметры</td>
			<td><input type="text" name="add[params]" class="span4" value="" /></td>
		</tr>
		<tr>
			<td>Язык</td>
			<td><select name="add[lang]" class="span4"><option value="ru">RU</option><option value="ua">UA</option><option value="en">EN</option></select></td>
		</tr>
		<tr>
			<td>Заголовок</td>
			<td><textarea name="add[title]" class="span4"></textarea></td>
		</tr>
		<tr>
			<td>Контент</td>
			<td><textarea name="add[content]" id="content" class="span4"></textarea></td>
		</tr>
		<tr>
			<td>SEO title</td>
			<td><textarea name="add[seo_title]" class="span4"></textarea></td>
		</tr>
		<tr>
			<td>SEO keywords</td>
			<td><textarea name="add[seo_keywords]" class="span4"></textarea></td>
		</tr>
		<tr>
			<td>SEO description</td>
			<td><textarea name="add[seo_description]" class="span4"></textarea></td>
		</tr>
	</table>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn btn-warning" data-dismiss="modal" aria-hidden="true">Отмена</a>
	  <input type="submit" value="Добавить" class="btn btn-success">

</form>
<?=$tiny_mce?>