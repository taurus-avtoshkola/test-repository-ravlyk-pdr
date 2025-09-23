<style>
textarea{
	width: 100%;
    max-width: calc(100% - 15px);
}
input{
	width: 100%;
    max-width: calc(100% - 15px);
}
</style>
<form action="<?=$url?>&get=seotext&action=create" method="POST">
	<table class="table table-condensed table-striped table-hover table-bordered">
		<tbody>
			<tr>
				<th>URL</th><td><input type="text" name="add[seo_url]" value="" class="form-control" /></td>
			</tr>
			<tr>
				<td>SEO H1</td>
				<td><input type="text" name="add[seo_pagetitle]" class="form-control"  value="" /></td>
			</tr>
			<tr>
				<td>SEO Title</td>
				<td><input type="text" name="add[seo_title]" class="form-control"  value="" /></td>
			</tr>
			<tr>
				<td>SEO Description</td>
				<td><textarea name="add[seo_description]" class="form-control"  rows="10"></textarea></td>
			</tr>

			<tr>
				<th>Текст</th><td><textarea name="add[seo_content]" id="seotext" class="form-control"></textarea></td>
			</tr>
		</tbody>

	</table>
	<input type="submit" value="Додати" class="btn btn-success"/>
</form>
<?=$tiny_mce?>