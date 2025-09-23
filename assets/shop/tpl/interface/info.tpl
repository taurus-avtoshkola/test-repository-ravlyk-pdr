</br>

<a href="<?=$url?>b=info&c=add" class="btn btn-success">Додати</a>
<p></p>
	
	<form action="<?=$url?>b=info&c=sort" method="POST" id="sort_t">

		<table class="table table-condensed table-striped table-bordered table-hover" style="margin-top: 20px;">
			<thead>
				<tr>
					<th width="50px">ID</th>
					<th width="80px">Сортування</th>
					<th width="160px">Назва</th>
					<th width="260px"></th>
				</tr>
			</thead>
			<tbody class="sortable">
				
<? while ($r2 = $modx->db->getRow($infos)): ?>
					<tr>				
						<td><?=$r2['id']?></td>
						<td>
							<?=$r2['sort']?>
							<input type="hidden" class="form-control sort_pos" value="<?=$r2['sort']?>" name="sort[<?=$r2['id']?>]" />
						</td>
						<td><?=$r2['name']?></td>
						<td>
							<a href="<?=$url?>b=info&c=edit&i=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
							<a data-confirm="Точно видалити?" href="<?=$url?>b=info&c=delete&i=<?=$r2['id']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Видалити </a>
						</td>
					</tr>
				<? endwhile;?>		
			</tbody>
		</table>
	</form>
	

<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
<script type="text/javascript">

$(document).ready(function(){

    $(".sortable").sortable();
    $( ".sortable" ).on( "sortupdate", function( event, ui ) {
        $(".ui-sortable-handle").each(function(){
            $(this).find('.sort_pos').val($(this).context.rowIndex);
        });
        $('#sort_t').submit();
    });


});

</script>