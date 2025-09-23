<form action="<?=$url?>b=filters&d=save" method="post">
	<h3 class="muted">Додати фільтр</h2>
	<table class="table table-bordered">
		<tr>
			<th width="200px">Назва UA</th>
			<td><input type="text" name="filter[filter_name_ua]" class="form-control"></td>
		</tr>
		<tr>
			<th width="200px">Опис</th>
			<td><textarea name="filter[desc]" class="form-control"></textarea></td>
		</tr>
	</table>
	<input type="submit" value="Створити" class="btn btn-primary">
</form>