</br>

<h2>Редагувати:</h2>

<form action="<?=$url?>b=pdr&c=update_chapter" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>

		<tr>				
			<td>Назва</td>
			<td><textarea name="name" class="form-control" ><?=htmlspecialchars($chapter_info['name'],ENT_QUOTES)?></textarea></td>
		</tr>	

		<tr>				
			<td>Номер</td>
			<td><textarea name="chapter" class="form-control" ><?=htmlspecialchars($chapter_info['chapter'],ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Оновити"></td>
		</tr>	
	</tbody>
	</table>
	<input type="hidden" name="id" value="<?=$chapter_info['id']?>"/>
</form>


<h2>Текст:</h2>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">ID</th>
			<th >Номер</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?						
			while ($r2 = $modx->db->getRow($items)): 
		?>
			<tr>				
				<td><?=$r2['id']?></td>
				<td><?=$r2['number']?></td>
				<td>
					<a href="<?=$url?>b=pdr&c=chapter&i=<?=$_REQUEST['i']?>&item=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
				</td>
			</tr>
		<? endwhile;?>		
	</tbody>
</table>

<?=$tiny_mce?>