<form action="<?=$url?>b=sign&c=update" method="POST">
	<table class="table table-condensed table-striped table-bordered table-hover">
	<tbody>
		<tr>				
			<td>Номер</td>
			<td><input type="text" name="number" class="form-control" value="<?=htmlspecialchars($sign['number'],ENT_QUOTES)?>"/></td>
		</tr>	
		<tr>				
			<td>Тип</td>
			<td>
				<select name="type" data-active="<?=$sign['type']?>" class="form-control">
					<? while ($type = $modx->db->getRow($types)):?>
					<option value="<?=$type['id']?>"><?=$type['name']?></option>
					<? endwhile;?>
				</select>
			</td>
		</tr>	
		<tr>				
			<td>Назва</td>
			<td><input type="text" name="name" class="form-control" value="<?=htmlspecialchars($sign['name'],ENT_QUOTES)?>"/></td>
		</tr>	
		<tr>				
			<td>Фото</td>
			<td>
				<img src="<?=$sign['image_new']?>" style="max-width:400px; margin-bottom: 10px;"/>
				</br>
				<a href="#" id="uploader" class="btn btn-warning">Завантажити фото</a>
				<span class="label label-success sp">Фото завантажено!</label>
			</td>
		</tr>	
		<tr>				
			<td>Опис</td>
			<td><textarea name="description" id="description" class="form-control"><?=$sign['description']?></textarea></td>
		</tr>	
		<?if($sign['example_new'] != ''):?>
		<tr>				
			<td>Приклад</td>
			<td><img src="<?=$sign['example_new']?>" style="max-width:700px;"/></td>
		</tr>	
		<?endif;?>
		<?if($sign['url'] != ''):?>
		<tr>				
			<td>Посилання звідки скопійовано</td>
			<td><a href="<?=$sign['url']?>" target="_blank"><?=$sign['url']?></a></td>
		</tr>	
		<?endif;?>
		<tr>				
			<td colspan="2"><input type="submit" class="btn btn-primary" value="Оновити"></td>
		</tr>	
	</tbody>
	</table>
	<input type="hidden" name="id" value="<?=$sign['id']?>"/>
</form>

<?=$tiny_mce?>

<style type="text/css">
.sp{
	display: none;
}
</style>
<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script src="/assets/site/ajaxupload.js"></script>
<script>

    $(document).ready(function(){


		new AjaxUpload($("#uploader"), {
			action: "<?=$url?>b=sign&c=upload",
			multiple: false,
		  	name: "uploader",
		  	data: {
					"size"  : 20485760,
					"folder": 'pdr/road-signs/original/<?=$sign["number"]?>'
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
    });

</script>