<style>
textarea{
  width: 95%;
  height: 125px;
}
</style>
<form action="<?=$url?>&get=template" method="post">
<table class="table table-bordered table-condensed table-striped">
	<tr>
		<th>Тип</th>
		<th>Title</th>
		<th>Description</th>
	</tr>
	<tr>
		<td>Товар</td>
		<td><textarea type="text" class="form-control" name="config[template_seo_product_title]" ><?=$modx->config['template_seo_product_title']?></textarea></td>
		<td><textarea class="form-control" name="config[template_seo_product_description]"><?=$modx->config['template_seo_product_description']?></textarea></td>
	</tr>
	<tr>
		<td>Категория</td>
		<td><textarea type="text" class="form-control" name="config[template_seo_category_title]" ><?=$modx->config['template_seo_category_title']?></textarea></td>
		<td><textarea class="form-control" name="config[template_seo_category_description]"><?=$modx->config['template_seo_category_description']?></textarea></td>
	</tr>
	<tr>
		<td>Категория/Бренд</td>
		<td><textarea type="text" class="form-control" name="config[template_seo_brand_title]" ><?=$modx->config['template_seo_brand_title']?></textarea></td>
		<td><textarea class="form-control" name="config[template_seo_brand_description]"><?=$modx->config['template_seo_brand_description']?></textarea></td>
	</tr>
	<tr>
		<td colspan="3"><input type="submit" class="btn btn-primary" value="Сохранить"/></td>
	</tr>
</table>
</form>
