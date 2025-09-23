<p><a href="<?=$url?>&get=seotext&action=publish" class="btn btn-success"><span class="icon icon-white icon-plus"></span> Додати SEO</a></p>

<table class="table table-condensed table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>id</th>
			<th>url</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? while ($r = $modx->db->getRow($seotext)): ?>
			<tr>
				<td><?=$r['seo_id']?></td>
				<td><?=$r['seo_url']?></td>
				<td>
					<a href="<?=$url?>&get=seotext&action=edit&i=<?=$r['seo_id']?>" title="<?=$_lang["seo_update"]?>" class="btn btn-small btn-success"><span class="icon icon-white icon-edit"></span> Редагувати</a>
					<a href="<?=$url?>&get=seotext&action=delete&i=<?=$r['seo_id']?>" title="<?=$_lang["seo_delete"]?>" class="btn btn-small btn-danger"><span class="icon icon-white icon-remove-sign"></span> Видалити</a>
				</td>
			</tr>
		<? endwhile ?>
	</tbody>

</table>