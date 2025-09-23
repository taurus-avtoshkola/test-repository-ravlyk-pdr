
<table class="table table-bordered table-condensed table-striped">
	<tr>
		<th>Категория</th>
		<td></td>
	</tr>
	
	<?foreach($categories as $key => $value): ?>
	<tr>
		<td><?=$value['pagetitle']?></td>
		<td><a href="<?=$url?>&get=seo_brand&i=<?=$value['id']?>" class="btn btn-primary">Редактировать</a></td>
	</tr>
	<?endforeach;?>
	
</table>
