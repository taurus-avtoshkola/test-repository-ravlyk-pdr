</br>

<h2>Створити тему:</h2>

<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script src="/assets/site/ajaxupload.js"></script>
<form action="<?=$url?>b=test&c=create_theme" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>

		<tr>				
			<td>Номер</td>
			<td><textarea name="number" class="form-control" ></textarea></td>
		</tr>	
		<tr>				
			<td>Назва</td>
			<td><textarea name="name" class="form-control" ></textarea></td>
		</tr>	


		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Створити"></td>
		</tr>	
	</tbody>
	</table>
</form>


