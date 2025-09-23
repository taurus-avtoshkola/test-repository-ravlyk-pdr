</br>

<h2>Редагувати:</h2>

<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script src="/assets/site/ajaxupload.js"></script>
<form action="<?=$url?>b=test&c=update_chapter" method="POST">
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


<form action="<?=$url?>b=test&c=update_chapter_position" method="POST">
	<input type="hidden" name="theme_id" value="<?=$chapter_info['id']?>"/>
	<input type="submit" class="btn btn-primary" value="Оновити позиції">
<h2>Питання:</h2>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">Позиція</th>
			<th width="50px">ID</th>
			<th width="50px">Номер</th>
			<th>Назва</th>
			<th width="300px">Фото ПДР</th>
			<th width="300px">Фото(RDD)</th>
			<th width="300px">Фото наше</th>
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
				<td><?if($r2['image_official'] != ''):?><a href="<?=$r2['image_official']?>" class="fancybox"><img src="<?=$r2['image_official']?>" style="max-width:100%;"/></a><?endif;?>
					</br>
					<a href="#" id="uploader2_<?=$r2['id']?>" class="btn btn-mini btn-warning">Завантажити фото</a>
					<a href="#" class="btn btn-info" data-copy-photo-official="<?=$r2['id']?>">Копіювати фото в наше</a>
					<span class="label label-success sp2_<?=$r2['id']?>" style="display: none;">Фото завантажено!</label>

					<script>

					    $(document).ready(function(){


							new AjaxUpload($("#uploader2_<?=$r2['id']?>"), {
								action: "<?=$url?>b=test&c=upload2",
								multiple: false,
							  	name: "uploader",
							  	data: {
										"size"  : 20485760,
										"question_id": "<?=$r2['id']?>"
							  	},
							  	onSubmit: function(file, ext){
							      if (! (ext && /^(GIF|gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))){ 
							          alert('Невірний формат!');
							          return false;
							      }
							  	},
							  	onComplete: function(file, response){
							     
							  		$('.sp2_<?=$r2['id']?>').fadeIn(0);
							  	}
							});
					    });

					</script>


				</td>
				<td><?if($r2['image_new'] != ''):?><a href="<?=$r2['image_new']?>" class="fancybox"><img src="<?=$r2['image_new']?>" style="max-width:100%;"/></a><?endif;?>
					<a href="#" class="btn btn-info" data-copy-photo-new="<?=$r2['id']?>">Копіювати фото в наше</a>
				</td>
				<td>
					<?if($r2['image_new_2'] != ''):?><a href="<?=$r2['image_new_2']?>" class="fancybox"><img src="<?=$r2['image_new_2']?>" style="max-width:100%;"/></a><?endif;?>
					</br>
					<a href="#" id="uploader_<?=$r2['id']?>" class="btn btn-mini btn-warning">Завантажити фото</a>
					<span class="label label-success sp_<?=$r2['id']?>" style="display: none;">Фото завантажено!</label>

					<script>

					    $(document).ready(function(){


							new AjaxUpload($("#uploader_<?=$r2['id']?>"), {
								action: "<?=$url?>b=test&c=upload",
								multiple: false,
							  	name: "uploader",
							  	data: {
										"size"  : 20485760,
										"question_id": "<?=$r2['id']?>"
							  	},
							  	onSubmit: function(file, ext){
							      if (! (ext && /^(GIF|gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))){ 
							          alert('Невірний формат!');
							          return false;
							      }
							  	},
							  	onComplete: function(file, response){
							     
							  		$('.sp_<?=$r2['id']?>').fadeIn(0);
							  	}
							});
					    });

					</script>

				</td>
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



	    $(document).on('click','[data-copy-photo-official]',function(){
	    	var _id = $(this).attr('data-copy-photo-official');
			   $.ajax({
		        url:"index.php",
		        dataType:"json",
		        data:"a=112&id=8&b=test&c=copy_photo_official&question_id="+_id,
		        success:function(_json){
		         
		          alert('Скопійовано!');
		        }
		      });
	    	return false;
	    });
	    $(document).on('click','[data-copy-photo-new]',function(){
	    	var _id = $(this).attr('data-copy-photo-new');
			   $.ajax({
		        url:"index.php",
		        dataType:"json",
		        data:"a=112&id=8&b=test&c=copy_photo_new&question_id="+_id,
		        success:function(_json){
		         
		          alert('Скопійовано!');
		        }
		      });
	    	return false;
	    });
    });
</script>