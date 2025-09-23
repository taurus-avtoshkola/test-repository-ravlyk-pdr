<p>
	<!--<a href="#myModal" role="button" data-toggle="modal" class="btn btn-primary"><span class="icon icon-white icon-plus-sign"></span> Добавить SEO фильтр</a>-->

	<a href="<?=$url?>&get=seo_t&b=add" class="btn btn-primary"><span class="icon icon-white icon-plus-sign"></span> Добавить SEO фильтр</a>
	
</p>

<table class="table table-condensed table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>№</th>
			<th>docid</th>
			<th>Язык</th>
			<th>Заголовок</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? while ($r = $modx->db->getRow($seo_t)): ?>
			<tr>
				<td><?=$r['id']?></td>
				<td><?=$r['docid']?></td>
				<td><?=$r['lang']?></td>
				<td><?=$r['params']?></td>
				<td><?=$r['title']?></td>
				<td>
					<a href="<?=$url?>&get=seo_t&b=edit&i=<?=$r['id']?>" title="<?=$_lang["seo_update"]?>" class="btn btn-small btn-success"><span class="icon icon-white icon-repeat"></span></a>
					<a href="<?=$url?>&get=seo_t&b=delete&i=<?=$r['id']?>" title="<?=$_lang["seo_delete"]?>" class="btn btn-small btn-danger"><span class="icon icon-white icon-remove-sign"></span></a>
				</td>
			</tr>
		<? endwhile ?>
	</tbody>

</table>

