<form action="<?=$url?>b=info&c=save" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>
		<tr>				
			<td>Назва</td>
			<td><input type="text" name="name" class="form-control" value="<?=htmlspecialchars($info['name'],ENT_QUOTES)?>"/></td>
		</tr>
		<tr>				
			<td>Інфо</td>
			<td><textarea name="intro" id="intro" class="form-control"><?=$info['intro']?></textarea></td>
		</tr>	
		<tr>				
			<td>Опис</td>
			<td><textarea name="description" id="description" class="form-control"><?=$info['description']?></textarea></td>
		</tr>	
		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Оновити"></td>
		</tr>	
	</tbody>
	</table>
	<input type="hidden" name="id" value="<?=$info['id']?>"/>
</form>

<?=$tiny_mce?>

<style type="text/css">
.sp{
	display: none;
}
</style>
<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>