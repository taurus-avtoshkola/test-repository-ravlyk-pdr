</br>
<!--<a href="<?=$url?>b=test&c=add" class="btn btn-success">Додати</a>-->
<p></p>
<a href="<?=$url?>b=test&c=new_question" class="btn btn-primary">Створити Питання</a>
<a href="<?=$url?>b=test&c=vidpovidi_x" class="btn btn-warning">Питання з декількома правильними відповідями</a>
<p></p>
</br>
<div class="masthead">
    <ul class="nav nav-justified">
	    <li class="active"><a href="#" data-id="1">Теми</a></li>	
	    <li><a href="#" data-id="2">Білети</a></li>
    </ul>
</div>

</br>
<form action="<?=$url?>b=test&c=update_tt_position" method="POST">
	<input type="submit" class="btn btn-primary" value="Оновити позиції">

		<div class="tabs">
			<div class="tab active" data-tab="1">
			</br>
			<p><a href="<?=$url?>b=test&c=new_theme" class="btn btn-success">Створити Тему</a></p>
			</br>
				<table class="table table-condensed table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th width="50px">Позиція</th>
							<th width="50px">ID</th>
							<th width="50px">Номер</th>
							<th>Назва</th>
							<th width="50px">Кількість питань</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="sortable">	
						<?						
							while ($r2 = $modx->db->getRow($q2)): 
						?>
							<tr>				
								<td><span class="sort_i_span"><?=$r2['position']?></span><input type="hidden" class="sort_i" name="position_theme[<?=$r2['id']?>]" value="<?=$r2['position']?>"/></td>
								<td><?=$r2['id']?></td>
								<td><?=$r2['number']?></td>
								<td><?=$r2['name']?></td>
								<td><?=$r2['cnt']?></td>
								<td>
									<a href="<?=$url?>b=test&c=chapter&i=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Детальніше </a>
								</td>
							</tr>
						<? endwhile;?>		
					</tbody>
				</table>
			</div>

			<div class="tab" data-tab="2">

			</br>
			<p><a href="<?=$url?>b=test&c=new_ticket" class="btn btn-success">Створити Білет</a></p>
			</br>
				<table class="table table-condensed table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th width="50px">Позиція</th>
							<th width="50px">ID</th>
							<th width="50px">Номер</th>
							<th>Назва</th>
							<th width="50px">Кількість питань</th>
							<th></th>
						</tr>
					</thead>
					<tbody class="sortable_2">
						<?						
							while ($r2 = $modx->db->getRow($q3)): 
						?>
							<tr>				
								<td><span class="sort_i_span"><?=$r2['position']?></span><input type="hidden" class="sort_i" name="position_ticket[<?=$r2['id']?>]" value="<?=$r2['position']?>"/></td>
								<td><?=$r2['id']?></td>
								<td><?=$r2['number']?></td>
								<td><?=$r2['name']?></td>
								<td><?=$r2['cnt']?></td>
								<td>
									<a href="<?=$url?>b=test&c=ticket&i=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Детальніше </a>
								</td>
							</tr>
						<? endwhile;?>		
					</tbody>
				</table>
			</div>
		</div>
</form>

<style type="text/css">
	.tab{
		display: none;
	}
	.tab.active{
		display: block;
	}
</style>

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

    $(".sortable_2").sortable();
    $( ".sortable_2" ).on( "sortupdate", function( event, ui ) {
        $(".ui-sortable-handle").each(function(){
        	var _pos = $(this).context.rowIndex;
        	$(this).find('.sort_i').val(_pos);
        	$(this).find('.sort_i_span').html(_pos);
        });
    });

 	$(document).on('click','[data-id]',function(){
 		$('[data-id]').parent().removeClass('active');
 		$('[data-tab]').removeClass('active');
 		$(this).parent().addClass('active');
 		$('[data-tab="'+$(this).attr('data-id')+'"]').addClass('active');
 		return false;
 	});
 });
</script>