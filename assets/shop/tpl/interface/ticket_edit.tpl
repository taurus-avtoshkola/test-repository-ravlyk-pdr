</br>

<h2>Редагувати:</h2>

<form action="<?=$url?>b=test&c=update_ticket" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>

		<tr>				
			<td>Номер</td>
			<td><textarea name="number" class="form-control" ><?=htmlspecialchars($chapter_info['number'],ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td>Назва</td>
			<td><textarea name="name" class="form-control" ><?=htmlspecialchars($chapter_info['name'],ENT_QUOTES)?></textarea></td>
		</tr>	


		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Оновити"></td>
		</tr>	
	</tbody>
	</table>
	<input type="hidden" name="i" value="<?=$chapter_info['id']?>"/>
</form>


<form action="<?=$url?>b=test&c=update_ticket_position" method="POST">
	<input type="hidden" name="ticket_id" value="<?=$chapter_info['id']?>"/>
	<input type="submit" class="btn btn-primary" value="Оновити позиції">
<h2>Питання:</h2>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">Позиція</th>
			<th width="50px">ID</th>
			<th width="50px">Номер</th>
			<th >Назва</th>
			<th></th>
		</tr>
	</thead>
	<tbody class="sortable">
		<?						
			while ($r2 = $modx->db->getRow($questions)): 
		?>
			<tr>				
				<td><span class="sort_i_span"><?=$r2['position']?></span><input type="hidden" name="position[<?=$r2['id']?>]" class="sort_i" value="<?=$r2['position']?>"/></td>
				<td><?=$r2['id']?></td>
				<td><?=$r2['number']?></td>
				<td><?=$r2['question']?></td>
				<td><?if($r2['image_new'] != ''):?><img src="<?=$r2['image_new']?>" style="max-width:100px;"/><?endif;?></td>
				<td>
					<a href="<?=$url?>b=test&c=chapter&i=<?=$_REQUEST['i']?>&question=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
				</td>
			</tr>
		<? endwhile;?>		
	</tbody>
</table>
</form>


<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script src="/assets/site/js/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
	    $(".sortable").sortable();
	    $( ".sortable" ).on( "sortupdate", function( event, ui ) {
	        $(".ui-sortable-handle").each(function(){
	        	var _pos = $(this).context.rowIndex;
	        	$(this).find('.sort_i').val(_pos);
	        	$(this).find('.sort_i_span').html(_pos);
	        });
	    });
    });
</script>