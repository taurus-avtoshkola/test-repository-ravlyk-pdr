<h3><?=$pagetitle['pagetitle']?></h3>
<table class="table table-bordered table-condensed table-striped">
	<tr>
		<th>Бренд</th>
		<td></td>
	</tr>
	
	<?foreach($brands as $key => $value): ?>
	<tr>
		<td><?=$value['value']?>
		<td><a href="<?=$url?>&get=seo_brand&i=<?=$_GET['i']?>&b=<?=$value['value_id']?>" class="btn btn-primary">Редактировать</a></td>
	</tr>
	<?endforeach;?>
	
</table>
