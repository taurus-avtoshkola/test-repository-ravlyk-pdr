<style>
	.images li .btn-success{
	    position: absolute;
	    bottom: 5px;
	    left: 5px;
	}
	.images li{
	    border: 5px solid transparent;
	}
	.images li.active{
	    border: 5px solid #2b669a;
	}
	.images li.active_2{
	    border: 5px solid #5cb85c;
	}
.group_i{
  display: flex;
  flex-direction: row;
  position:relative;
}
.group_i button{
  width: min-content;
  display: flex;
  flex-direction: column;
  white-space: nowrap;
  align-items: center;
  justify-content: center;
  border: none;
  position: absolute;
  top: 1px;
  right: 0px;
  height: calc(100% - 2px);
  background: #f5f5f5;
  border-left: 1px solid #ddd;
}
.group_i button:hover{
	background:#fff;
}
</style>
<form action="<?=$url?>b=instructors&c=update" method="post" enctype="multipart/form-data">
	<div class="pull-right">
		<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити</button>
		<button class="btn btn-success saveandclose"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити та закрити</button>
	</div>
	<input type="hidden" name="step" id="step" value="0"/>

	<br>
	<table class="table table-condensed table-bordered table-striped">
		<tr>
			<td>ID інструктора</td>
			<td><?=$user['id']?></td>
		</tr>
		<tr>
			<td>ID Користувача</td>
			<td><input type="text" name="edit[user_id]" class="form-control" value="<?=$user['user_id']?>" /></td>
		</tr>
		<tr>
			<td>Звідки</td>
			<td><?switch($user['source']){case "1": echo "OLX"; break; case "0": echo "Реєстрація на сайті"; break;}?></td>
		</tr>
		<?php if($user['source_url'] != '0'):?>	
		<tr>
			<td>OLX URL:</td>
			<td><a href="<?=$user['source_url']?>" target="_blank"><?=$user['source_url']?></a></td>
		</tr>
		<?endif;?>
		<?php if($user['source_id'] != '0'):?>	
		<tr>
			<td>OLXID:</td>
			<td><?=$user['source_id']?></td>
		</tr>
		<?endif;?>
		<tr>
			<td>Посилання</td>
			<td>
				<?php $iu = $modx->config['site_url_b'].$modx->makeUrl('89').$user['instructor_url'].'/';?>
				<a href="<?=$iu;?>" target="_blank">Посилання</a>
			</td>
		</tr>
			
		<tr>
			<td>URL</td>
			<td><input type="text" name="edit[instructor_url]" class="form-control" value="<?=$user['instructor_url']?>" />
			<p><small>(генерується автоматично, якщо видалити і записати)</small></p>
			</td>
		</tr>



		<tr>
			<td><b>Оплата на</b></td>
			<td>
				<div class="form-group">
					<select name="edit[product_paytype]" class="form-control" data-active="<?=$user['product_paytype']?>">	
						<option value="0">За замовченням</option>	
						<?while ($r = $modx->db->getRow($pay_options)):?>
							<option value="<?=$r['pay_id']?>"><?=$r['shop_payname']?> (<?=$r['pay_id']?>)</option>
						<?endwhile;?>
					</select>
				</div>
			</td>
		</tr>

		<tr>
			<td>Дата реєстрації</td>
			<td><?=$shop->formatDate($user['registration_date'])?></td>
		</tr>
		<tr>
			<td><b>Інструктор опублікований</b></td>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="edit[status]" <?=($user['status'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<tr>
			<td><b>Документи та особа перевірена</b></td>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="edit[verify]" <?=($user['verify'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<tr><th colspan="2"><b>Персональні дані</b></th></tr>






		<tr><th colspan="2"><b>Локація</b></th></tr>

		<tr>
			<td><b>Автошкола</b></td>
			<td>
				<select name="edit[school]" class="form-control" data-active="<?=$user['school']?>">	
					<option value="0">Не вказано</option>				
					<?php while($r = $modx->db->getRow($school)):?>
						<option value="<?=$r['id']?>"><?=$r['pagetitle']?></option>
					<?endwhile;?>
				</select>
			</td>
		</tr>

		<tr>
			<td><b>Заголовок</b></td>
			<td><input type="text" name="edit[title]" class="form-control" value="<?=$user['title']?>" /></td>
		</tr>

		<tr>
			<td><b>Ім`я</b></td>
			<td><input type="text" name="edit[fullname]" class="form-control" value="<?=$user['fullname']?>" /></td>
		</tr>
		<tr>
			<td><b>Прізвище</b></td>
			<td><input type="text" name="edit[lastname]" class="form-control" value="<?=$user['lastname']?>" /></td>
		</tr>
		<tr>
			<td><b>По-батькові</b></td>
			<td><input type="text" name="edit[patronymic]" class="form-control" value="<?=$user['patronymic']?>" /></td>
		</tr>
		<tr>
			<td><b>E-mail</b></td>
			<td><input type="text" name="edit[email]" class="form-control" value="<?=$user['email']?>" /></td>
		</tr>
		<tr>
			<td><b>Телефон</b></td>
			<td><input type="text" name="edit[phone]" class="form-control" value="<?=$user['phone']?>" /></td>
		</tr>

		<tr>
			<td><b>Дата народження ДД.ММ.ГГГГ</b></td>
			<td><input type="text" name="edit[birthday]" class="form-control" value="<?=$user['birthday']?>" /></td>
		</tr>

		<tr>
			<td><b>Стаж водіння</b></td>
			<td><input type="text" name="edit[experience]" class="form-control" value="<?=$user['experience']?>" /></td>
		</tr>

		<tr>
			<td><b>Дата закінчення атестації ДД.ММ.ГГГГ</b></td>
			<td><input type="text" name="edit[certificate_date]" class="form-control" value="<?=$user['certificate_date']?>" /></td>
		</tr>



		<tr><th colspan="2"><b>Локація</b></th></tr>

		<tr>
			<td><b>Місто</b></td>
			<td>
				<select name="edit[city]" class="form-control" data-active="<?=$user['city']?>">					
					<?php foreach($cities as $city):?>
						<option value="<?=$city['city_name']?>"><?=$city['city_name']?></option>
					<?endforeach;?>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Район</b></td>
			<td><input type="text" name="edit[district]" class="form-control" value="<?=$user['district']?>" /></td>
		</tr>
		<tr>
			<td><b>Місце посадки студента</b></td>
			<td><input type="text" name="edit[pickup_address]" class="form-control" value="<?=$user['pickup_address']?>" /></td>
		</tr>


		<tr><th colspan="2"><b>Автомобіль</b></th></tr>

		<tr>
			<td><b>Тип авто</b></td>
			<td>
				<select name="edit[type][]" multiple="multiple" class="form-control" data-active="<?=$user['type']?>">
					<option value="a">Мото (Категорія A)</option>
					<option value="b">Легковий (категорія B)</option>
					<option value="c">Грузовий (категорія C)</option>
					<option value="e">Грузовий (категорія CE)</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Коробка передач</b></td>
			<td>
				<select name="edit[transmission][]" multiple="multiple"  class="form-control" data-active="<?=$user['transmission']?>">
					<option value="manual">Механіка</option>
					<option value="automatic">Автомат</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Марка автомобіля</b></td>
			<td><input type="text" name="edit[brand]" class="form-control" value="<?=$user['brand']?>" /></td>
		</tr>
		<tr>
			<td><b>Модель автомобіля</b></td>
			<td><input type="text" name="edit[model]" class="form-control" value="<?=$user['model']?>" /></td>
		</tr>
		<tr>
			<td><b>Колір автомобіля</b></td>
			<td><input type="text" name="edit[color]" class="form-control" value="<?=$user['color']?>" /></td>
		</tr>
		<tr>
			<td><b>Рік випуску автомобіля</b></td>
			<td><input type="text" name="edit[year]" class="form-control" value="<?=$user['year']?>" /></td>
		</tr>
		<tr>
			<td><b>Номерний знак авто</b></td>
			<td><input type="text" name="edit[reg_number]" class="form-control" value="<?=$user['reg_number']?>" /></td>
		</tr>



		<tr><th colspan="2"><b>Додатково</b></th></tr>

		<tr>
			<td><b>Графік роботи з</b></td>
			<td><input type="text" name="edit[schedule_from]" class="form-control" value="<?=$user['schedule_from']?>" /></td>
		</tr>
		<tr>
			<td><b>Графік роботи по</b></td>
			<td><input type="text" name="edit[schedule_to]" class="form-control" value="<?=$user['schedule_to']?>" /></td>
		</tr>
		<tr>
			<td><b>Ціна від</b></td>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="edit[price_from]" <?=($user['price_from'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<tr>
			<td><b>Ціна уроку</b></td>
			<td><input type="text" name="edit[price]" class="form-control" value="<?=$user['price']?>" /></td>
		</tr>
		<tr>
			<td><b>Тривалість одного заняття</b></td>
			<td>
				<select name="edit[duration]" class="form-control" data-active="<?=$user['duration']?>">
					<option value="45">45 хвилин</option>
					<option value="60">60 хвилин</option>
					<option value="90">90 хвилин</option>
				</select>
			</td>
		</tr>



		<tr>
			<td><b>Додаткова інформація</b></td>
			<td><textarea name="edit[description]" id="description" class="form-control" ><?=$user['description']?></textarea></td>
		</tr>


		<tr>
			<td><b>Коментар</b></td>
			<td><textarea name="edit[comment]" id="comment" class="form-control" ><?=$user['comment']?></textarea></td>
		</tr>


		<tr><th colspan="2"><b>Документи</b></th></tr>
		<tr>
			<td><b>Вкладені документи</b></td>
			<td>
				<?php
					$certificate = explode(',',$user['certificate']);
					if(is_array($certificate)){
						foreach($certificate as $ph){
					?>
						<p><a href="<?=$ph?>" target="_blank"><?=$ph?></a></p>
					<?}
					}
				?>				
			</td>
		</tr>

		<tr>
			<th>Завантажити документи</th>
			<td>
				<div class="group_i">
					<input type="text" name="edit[certificate]" value="" id="certificate" class="form-control">
					<button type="button" onclick="BrowseServer();">Обрати документ</button>
				</div>
			</td>
		</tr>
		<tr>
			<th>Фото</th>
			<td>
				<a href="#" id="uploader" class="btn btn-warning">Завантажити фото</a>
				<ul id="img" class="images">
					<?php
					$photo = $user['main_photo'];
					$car_photo = $user['car_photo'];



					$images = explode(',',$user['photo']);
					if(count($images) > 0){
						foreach($images as $img){
							if($photo == $img){
								$class= 'class="active"';
							}else{
								if($car_photo == $img){
									$class= 'class="active_2"';
								}else{
									$class = '';
								}
							}
							echo '<li '.$class.'><span class="link_name"><img src="'.$img.'" style="width:200px;"/></span><input type="hidden" name="edit[photo][]" value="'.$img.'"/><a href="#" data-remove-file-photo="'.$img.'" class="remove_link btn btn-danger">×</a><a href="#" data-main-file-photo="'.$img.'" class="main_link btn btn-primary">Обкладинка</a><a href="#" data-car-file-photo="'.$img.'" class="main_link btn btn-success">Авто</a></li>';
						}
					}

					
					?>
				</ul>
				<div class="clearfix"></div>
				<input type="hidden" name="edit[main_photo]" id="cover" value="<?=$user['main_photo']?>" />
				<input type="hidden" name="edit[car_photo]" id="cover_car" value="<?=$user['car_photo']?>" />
			</td>
		</tr>

	</table>
		
		<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити</button>
		<button class="btn btn-success saveandclose"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити та закрити</button>
	<input type="hidden" name="edit[id]" value="<?=$user['id']?>" />
	<a href="<?=$url?>b=items" class="btn btn-warning"><span class="icon icon-white icon-hand-left"></span> <?=$_lang["shop_cancel"]?></a>
</form>

<script src="/assets/site/ajaxupload.js"></script>
<script>
    $(document).ready(function(){
    	$(".saveandclose").on('click', function(){
    		$('#step').val(1);
    		$(this).parents('form').submit();
    		return false;
    	});
    });




  	$(document).on('click','[data-remove-file-photo]',function(){
  		var _this = $(this);
  		var _photo = $(this).attr('data-remove-file-photo');
  		if(_photo == $('#cover').val()){
  			$('#cover').val('');
  		}
  		$.ajax({
            url: '<?=$url?>b=remove_photo',
			type: "POST",
            data:"photo="+_photo,
            success:function(json){
               _this.parents('li').remove();
            }
        });
  		return false;
  	});
  	$(document).on('click','[data-main-file-photo]',function(){
  		$('.images li').removeClass('active');
  		var _this = $(this);
  		var _photo = $(this).attr('data-main-file-photo');
  		_this.parents('li').removeClass('active_2');
  		_this.parents('li').addClass('active');
  		$('#cover').val(_photo);
  		return false;
  	});
  	$(document).on('click','[data-car-file-photo]',function(){
  		$('.images li').removeClass('active');
  		var _this = $(this);
  		var _photo = $(this).attr('data-car-file-photo');
  		_this.parents('li').removeClass('active');
  		_this.parents('li').addClass('active_2');
  		$('#cover_car').val(_photo);
  		return false;
  	});



	new AjaxUpload($("#uploader"), {
		action: "<?=$url?>b=upload_instuctor",
		multiple: true,
	    name: "uploader[]",
	    data: {
				"size"  : 20485760,
				"user_id": '<?=$user['id']?>'
	    },
	    onSubmit: function(file, ext){
	      if (! (ext && /^(GIF|gif|jpg|png|jpeg|JPG|PNG|JPEG)$/.test(ext))){ 
	          alert('<?=$_lang["shop_file_format"]?>');
	          return false;
	      }
	    },
	    onComplete: function(file, response){
	    	var _response = JSON.parse(response);
			$.each(_response.photos, function(key, value){

                var _html_li = '<li><span class="link_name"><img src="'+value+'" style="width:200px;"/></span><input type="hidden" name="edit[photo][]" value="'+value+'"/><a href="#" data-remove-file-photo="'+value+'" class="remove_link btn btn-danger">×</a><a href="#" data-main-file-photo="'+value+'" class="main_link btn btn-primary">Обкладинка</a><a href="#" data-car-file-photo="'+value+'" class="main_link btn btn-success">Авто</a></li>';
                $('#img').append(_html_li);

			});

	    }
	});

</script>
<script>
// Функція для відкриття медіа-браузера MODX
function BrowseServer() {
    var field = document.getElementById('certificate');
    window.open("<?= MODX_MANAGER_URL ?>media/browser/mcpuk/browser.php?&type=files", "MediaBrowser", "width=850,height=500,scrollbars=yes");
    
    // Функція для вибору зображення
    window.SetUrl = function(url) {
        field.value = url; // Записуємо URL вибраного зображення у поле
    }
}
</script>
<?=$tiny_mce?>
