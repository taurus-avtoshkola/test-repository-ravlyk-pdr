<a href="<?=$url?>b=test&c=test" class="btn btn-warning">Назад</a>
</br>

<form action="<?=$url?>b=test&c=create_question" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>



		<tr>				
			<td>Номер</td>
			<td><textarea name="number" class="form-control" ></textarea></td>
		</tr>	
		<tr>				
			<td>Питання</td>
			<td><textarea name="question" class="form-control" ></textarea></td>
		</tr>	
		<tr>				
			<td>Глава</td>
			<td>
				<p><span class="label label-danger">Обов'язково прив'язати розділ. після створення в цьому розділі з'явиться питання</span></p>
				<select name="theme_id" class="form-control">
					<? while ($chapter = $modx->db->getRow($chapters)):?>
					<option value="<?=$chapter['id']?>"><?=$chapter['name']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td>Білети</td>
			<td>
				<select name="ticket_ids[]" multiple="multiple" class="form-control">
					<? while ($ticket = $modx->db->getRow($tickets)):?>
					<option value="<?=$ticket['id']?>"><?=$ticket['name']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td>Фото</td>
			<td>
				<span class="label label-warning">Фото можна додати до тесту тільки після створення (через редагування).</span>
			</td>
		</tr>


		<tr>				
			<td>Відповіді </td>
			<td>
				<table class="table table-condensed table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Номер</th>
						<th>Відповідь</th>
						<th></th>
					</tr>
				</thead>
				<tbody class="sortable">
					<tr class="answer">
						<td>
							<input type="radio" class="a_c" name="correct"  id="ch_0" value="0"/>
							<label class="a_c_l" for="ch_0">1</label>
						</td>
						<td>
							<input type="hidden" name="option[0][id]" class="a_h form-control" value=""/>
							<input type="text"  name="option[0][description]" class="a_t form-control" value="" placeholder="Відповідь"/>
						</td>
						<td><a href="#" class="btn btn-danger remove_answer">Видалити</a></td>
					</tr>		
				</tbody>		
				</table>
				<a href="#" class="btn btn-primary add_answer">Додати відповідь</a>
			</td>
		</tr>	
		<tr>				
			<td>Коментар</td>
			<td><textarea name="comment" id="comment" class="form-control" ></textarea></td>
		</tr>	
		<tr>				
			<td>Пункт ПДР</td>
			<td>
				<select name="pdr[]" multiple="multiple" class="form-control">
					<option value="">Не обрано</option>
					<? while ($pdr = $modx->db->getRow($pdrs)):?>
					<option value="<?=$pdr['id']?>">Розділ <?=$pdr['chapter']?>; Пункт: <?=$pdr['number']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Створити"></td>
		</tr>	
	</tbody>
	</table>
</form>


<style type="text/css">
.sp{
	display: none;
}
</style>
<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script src="/assets/site/ajaxupload.js"></script>
<script src="/assets/site/js/jquery-ui.js"></script>
<script>

    $(document).ready(function(){

	    $(".sortable").sortable();
	    $( ".sortable" ).on( "sortupdate", function( event, ui ) {
	        $(".ui-sortable-handle").each(function(){
	        	var _pos = $(this).context.rowIndex;
	        	var _num = parseInt(_pos)-1;
	            $(this).find('.a_c').val(_num);
	            $(this).find('.a_c').attr('id','ch_'+_num);
	            $(this).find('.a_c_l').attr('for','ch_'+_num);
	            $(this).find('.a_c_l').html(_pos);
	            $(this).find('.a_h').attr('name','option['+_num+'][id]');
	            $(this).find('.a_t').attr('name','option['+_num+'][description]');
	        });
	    });

	    $(document).on('click','.remove_answer', function(){
	    	$(this).parents('tr.answer').remove();
			$('.sortable').sortable('destroy');
			$('.sortable').sortable();
	    	return false;
	    });
	    $(document).on('click','.add_answer', function(){
	    	var _num = $('.sortable tr:last-child').find('.a_c_l').html();
        	var _pos = parseInt(_num)+1;


	    	$('.sortable').append('<tr class="answer"><td><input type="radio" class="a_c" name="correct" id="ch_'+_num+'" value="'+_num+'"/><label class="a_c_l" for="ch_'+_num+'">'+_pos+'</label></td><td><input type="hidden" name="option['+_num+'][id]" class="a_h form-control" value=""/><input type="text" name="option['+_num+'][description]" class="a_t form-control" value=""/></td><td><a href="#" class="btn btn-danger remove_answer">Видалити</a></td></tr>');
	    
			$('.sortable').sortable('destroy');
			$('.sortable').sortable();
	    	return false;
	    });


	    

    });

</script>
<?=$tiny_mce?>