<a href="<?=$url?>b=pdr&c=chapter&i=<?=$_REQUEST['i']?>" class="btn btn-warning">Назад</a>
</br>

<form action="<?=$url?>b=pdr&c=update&i=<?=$_REQUEST['i']?>" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>

		<tr>				
			<td>Номер</td>
			<td><textarea name="number" class="form-control" ><?=htmlspecialchars($item['number'],ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td>Глава</td>
			<td>
				<select name="chapter" data-active="<?=$item['chapter']?>" class="form-control">
					<? while ($chapter = $modx->db->getRow($chapters)):?>
					<option value="<?=$chapter['chapter']?>"><?=$chapter['name']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td>Текст</td>
			<td>
				<textarea name="description" id="description" class="form-control"><?=$item['description']?></textarea>
			</td>
		</tr>	
		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Оновити"></td>
		</tr>	
	</tbody>
	</table>
	<input type="hidden" name="id" value="<?=$item['id']?>"/>
</form>



<?=$tiny_mce;?>