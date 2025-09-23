<a href="<?=$url?>b=test&c=chapter&i=<?=$_REQUEST['i']?>" class="btn btn-warning">Назад</a>
</br>

<form action="<?=$url?>b=test&c=update&i=<?=$_REQUEST['i']?>" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>



		<tr>				
			<td>Номер</td>
			<td><textarea name="number" class="form-control" ><?=htmlspecialchars($question['number'],ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td>Питання</td>
			<td><textarea name="question" class="form-control" ><?=htmlspecialchars($question['question'],ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td>Глава</td>
			<td>
				<select name="theme_id" data-active="<?=$question['theme_id']?>" class="form-control">
					<? while ($chapter = $modx->db->getRow($chapters)):?>
					<option value="<?=$chapter['id']?>"><?=$chapter['name']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td>Білети</td>
			<td>
				<select name="ticket_ids[]" multiple="multiple" data-active="<?=$question['ticket_ids']?>" class="form-control">
					<? while ($ticket = $modx->db->getRow($tickets)):?>
					<option value="<?=$ticket['id']?>"><?=$ticket['name']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td>Фото ПДР</td>
			<td>
				<?if($question['image_official']):?>
				<img src="<?=$question['image_official']?>" style="max-width:400px; margin-bottom: 10px;"/>
				<?endif;?>
				</br>
				<a href="#" id="uploader2" class="btn btn-warning">Завантажити фото</a>
				<span class="label label-success sp2">Фото завантажено!</label>
			</td>
		</tr>	
		<tr>				
			<td>Фото (RDD)</td>
			<td>
				<?if($question['image_new']):?>
				<img src="<?=$question['image_new']?>" style="max-width:400px; margin-bottom: 10px;"/>
				<?endif;?>
			</td>
		</tr>	
		<tr>				
			<td>Фото наше</td>
			<td>
				<?if($question['image_new_2']):?>
				<img src="<?=$question['image_new_2']?>" style="max-width:400px; margin-bottom: 10px;"/>
				<?endif;?>
				</br>
				<a href="#" id="uploader" class="btn btn-warning">Завантажити фото</a>
				<span class="label label-success sp">Фото завантажено!</label>
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
				<? $answers = json_decode($question['answers'],true);
				foreach($answers as $k => $v):?>

					<tr class="answer">
						<td>
							<input type="radio" class="a_c" name="correct" <?if($k == $question['correct']){echo 'checked="checked"';}?> id="ch_<?=$k?>" value="<?=$k?>"/>
							<label class="a_c_l" for="ch_<?=$k?>"><?=$k+1?></label>
						</td>
						<td>
							<input type="hidden" name="option[<?=$k;?>][id]" class="a_h form-control" value="<?=$v['id']?>"/>
							<input type="text"  name="option[<?=$k;?>][description]" class="a_t form-control" value="<?=$v['description']?>"/>
						</td>
						<td><a href="#" class="btn btn-danger remove_answer">Видалити</a></td>
					</tr>		
				<?endforeach;?>
				</tbody>		
				</table>
				<a href="#" class="btn btn-primary add_answer">Додати відповідь</a>
			</td>
		</tr>	
		<tr>				
			<td>Коментар</td>
			<td><textarea name="comment" id="comment" class="form-control" ><?=htmlspecialchars($question['comment'],ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td>Відео</td>
			<td><textarea name="video" id="video" class="form-control" ><?=htmlspecialchars($question['video'],ENT_QUOTES)?></textarea></td>
		</tr>
		<tr>				
			<td>Коментар CHAT GPT</td>
			<td><textarea name="comment_gpt" id="comment_gpt" class="form-control" ><?=htmlspecialchars($shop->beutifyGptText($helper['answer']),ENT_QUOTES)?></textarea></td>
		</tr>	
		<tr>				
			<td>Пункт ПДР</td>
			<td>
				<select name="pdr[]" multiple="multiple" class="form-control" data-active="<?=$question['pdr']?>">
					<option value="">Не обрано</option>
					<? while ($pdr = $modx->db->getRow($pdrs)):?>
					<option value="<?=$pdr['id']?>">Розділ <?=$pdr['chapter']?>; Пункт: <?=$pdr['number']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Оновити"></td>
		</tr>	
	</tbody>
	</table>
	<input type="hidden" name="pid" value="<?=$question['id']?>"/>
</form>


<style type="text/css">
.sp2,
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


	    

		new AjaxUpload($("#uploader"), {
			action: "<?=$url?>b=test&c=upload",
			multiple: false,
		  	name: "uploader",
		  	data: {
					"size"  : 20485760,
					"question_id": "<?=$question['id']?>"
		  	},
		  	onSubmit: function(file, ext){
		      if (! (ext && /^(GIF|gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))){ 
		          alert('Невірний формат!');
		          return false;
		      }
		  	},
		  	onComplete: function(file, response){
		     
		  		$('.sp').fadeIn(0);
		  	}
		});


		new AjaxUpload($("#uploader2"), {
			action: "<?=$url?>b=test&c=upload2",
			multiple: false,
		  	name: "uploader",
		  	data: {
					"size"  : 20485760,
					"question_id": "<?=$question['id']?>"
		  	},
		  	onSubmit: function(file, ext){
		      if (! (ext && /^(GIF|gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))){ 
		          alert('Невірний формат!');
		          return false;
		      }
		  	},
		  	onComplete: function(file, response){
		     
		  		$('.sp2').fadeIn(0);
		  	}
		});


    });

</script>
<?=$tiny_mce?>