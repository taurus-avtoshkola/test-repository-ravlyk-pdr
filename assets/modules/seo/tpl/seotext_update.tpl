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
<form action="<?=$url?>&get=seotext&action=update" method="POST">
	<table class="table table-condensed table-striped table-hover table-bordered">
		<tbody>
			<tr>
				<th>ID</th><td><?=$seotext['seo_id']?></td>
			</tr>
			<tr>
				<th>URL</th><td><input type="text" name="edit[seo_url]" value="<?=$seotext['seo_url']?>" class="form-control" /></td>
			</tr>
			<tr>
				<td>SEO H1</td>
				<td><input type="text" name="edit[seo_pagetitle]" class="form-control"  value="<?=html_entity_decode($seotext['seo_pagetitle'])?>" /></td>
			</tr>
			<tr>
				<td>SEO Title</td>
				<td><input type="text" name="edit[seo_title]" class="form-control"  value="<?=html_entity_decode($seotext['seo_title'])?>" /></td>
			</tr>
			<tr>
				<td>SEO Description</td>
				<td><textarea name="edit[seo_description]" class="form-control"  rows="10"><?=html_entity_decode($seotext['seo_description'])?></textarea></td>
			</tr>

			<tr>
				<th>Текст</th><td><textarea name="edit[seo_content]" id="seotext" class="form-control"><?=html_entity_decode($seotext['seo_content'])?></textarea></td>
			</tr>
			<tr><th colspan="2">
		</tbody>

	</table>
	<input type="hidden" name="edit[seo_id]" value="<?=$seotext['seo_id']?>"/>
	<input type="submit" value="Оновити" class="btn btn-success"/>
</form>
<?=$tiny_mce?>