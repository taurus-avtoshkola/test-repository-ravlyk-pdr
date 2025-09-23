<style>
.follow{
	position: absolute!important;
}
.droppable li{
	display: block;
}
.droppable .draggable .img-thumbnail.cover{
	background: none;
}
.droppable .draggable .btn-primary{
	display: none;
}
.label{
	text-shadow: 0px 0px 5px #000;
}
.typeahead, .tt-query, .tt-hint{
width:auto;
}
.images li{
    border: 5px solid transparent;
}
.images li.active{
    border: 5px solid #2b669a;
}
#sortModal{
  position: absolute;
  top: 10%;
  left: 10%;
  z-index: 1050;
  width: 80%;
  background-color: #ffffff;
  border: 1px solid #999;
  border: 1px solid rgba(0,0,0,0.3);
  -webkit-border-radius: 6px;
  -moz-border-radius: 6px;
  border-radius: 6px;
  outline: none;
  -webkit-box-shadow: 0 3px 7px rgba(0,0,0,0.3);
  -moz-box-shadow: 0 3px 7px rgba(0,0,0,0.3);
  box-shadow: 0 3px 7px rgba(0,0,0,0.3);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding-box;
  background-clip: padding-box;
  display: none;
}
#overflow{
	display: none;
  position: fixed;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  z-index: 1030;
  background-color: rgba(0,0,0,0.5);
}
.and_filter .twitter-typeahead{
	width: 100%!important;
}
</style>
<h4 class="text-muted">
	Додати товар
</h4>
<form action="<?=$url?>b=items&c=create" method="post" enctype="multipart/form-data" id="product_form">

	<input type="hidden" name="step" id="step" value="0"/>
			<table class="table table-condensed table-bordered table-striped">
				<tr>
					<th width="100px">Назва</th>
					<td><input type="text" name="add[product_name]" value="" id="product_name" class="form-control"></td>
				</tr>
				<tr>
					<td><b>Артикул</b></td>
					<td><input type="text" name="add[product_article]" value="" id="product_article" class="form-control"></td>
				</tr>
				<tr>
					<th>Опис</th>
					<td><textarea name="add[product_description]" id="product_description" class="form-control"></textarea></td>
				</tr>
				<tr>
					<th>Короткий опис</th>
					<td><textarea name="add[product_introtext]" id="product_introtext" class="form-control"></textarea></td>
				</tr>
				<tr>
					<th >SEO Title</th>
					<td><input type="text" name="add[product_seo_title]" value="" class="form-control"></td>
				</tr>
				<tr>
					<th>SEO Description</th>
					<td><textarea name="add[product_seo_description]" class="form-control"></textarea></td>
				</tr>
				<tr>
					<td><b><?=$_lang["shop_categories"]?></b></td>
					<td>
						<div class="form-group">
							<select name="add[product_main_cat]" id="product_category" class="form-control" data-placeholder="<?=$_lang["shop_categories_p"]?>">
								<?foreach ($options as $key => $value):?>
									<option value="<?=$value['id']?>"><?=$value['parent_pagetitle']?> <?=$value['pagetitle']?> (<?=$value['id']?>)</options>
								<?endforeach;?>
							</select>
						</div>
					</td>
				</tr>
				<tr>
					<td><b>URL</b></td>
					<td>
				 		<input type="text" class="form-control" name="add[product_url]" value="" id="alias" placeholder="<?=$_lang["shop_url_product"]?>">
						<p class="text-warning">URL товару формується автоматично. Також ви можете змінити його вручну</p>
					</td>
				</tr>
				<tr>
					<td><b>Виробник</b></td>
					<td>
						<input type="text" name="add[product_brand]" id="product_manufacturer" class="form-control" autocomplete="off" value="" />

					</td>
				</tr>
				<tr>
					<td><b>Ціна</b></td>
					<td>
						<input type="text" name="add[product_price]" id="product_price" class="form-control" autocomplete="off" value="" />

					</td>
				</tr>
				<tr>
					<td><b>Ціна акційна</b></td>
					<td>
						<input type="text" name="add[product_price_a]" id="product_price_a" class="form-control" autocomplete="off" value="" />

					</td>
				</tr>

				<tr>
					<td><b>Кількість занять (шт)</b></td>
					<td>
						<input type="text" name="add[product_lesson]" id="product_lesson" class="form-control" autocomplete="off" value="1" />
					</td>
				</tr>
				<tr>
					<td><b>Тип занять</b></td>
					<td>
						<label class="col-md-8"><input type="radio" checked name="add[product_lesson_type]" value="0"> <span class="text-primary">Основне</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_lesson_type]" value="1"> <span class="text-success">Додаткове</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_lesson_type]" value="2"> <span class="text-warning">Подача на іспит</span></label>
					</td>
				</tr>
				<tr>
					<td><b>Наявність (шт)</b></td>
					<td>
						<input type="text" name="add[product_amount]" id="product_amount" class="form-control" autocomplete="off" value="" />

					</td>
				</tr>


				<tr>
					<td><b><?=$_lang["shop_status"]?></b></td>
					<td>
						<label class="col-md-8"><input type="radio" name="add[product_visible]" value="0"> <span class="text-danger">Не активний</span></label>
						<label class="col-md-8"><input type="radio" checked name="add[product_visible]" id="go_status" value="1"> <span class="text-success">Активний</span></label>
					</td>
				</tr>

				<tr>
					<td><b>Оплата на</b></td>
					<td>
						<div class="form-group">
							<select name="add[product_paytype]" class="form-control" data-active="<?=$product[0]['product_paytype']?>">	
								<?while ($r = $modx->db->getRow($pay_options)):?>
									<option value="<?=$r['pay_id']?>"><?=$r['shop_payname']?> (<?=$r['pay_id']?>)</options>
								<?endwhile;?>
							</select>
						</div>
					</td>
				</tr>


				<tr>
					<td><b>Тип трансмісії (товари практики)</b></td>
					<td>
						<label class="col-md-8"><input type="radio" checked name="add[product_transmission]" value="0"> <span class="text-warning">Усі</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_transmission]" value="1"> <span class="text-primary">Механіка</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_transmission]" value="2"> <span class="text-success">Автомат</span></label>
					</td>
				</tr>


				<tr>
					<td><b>Виводити в інструкторах</b></td>
					<td>
						<label class="col-md-8"><input type="radio" checked name="add[product_to_instructor]" value="0"> <span class="text-danger">Не виводити</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_to_instructor]" value="1"> <span class="text-success">Виводити</span></label>
					</td>
				</tr>
				<tr>
					<td><b>Зв`язок з автошколою</b></td>
					<td>
						<div class="form-group">
							<select name="add[product_to_school]" id="product_to_school" class="form-control">
								<?foreach ($autoschool as $key => $value):?>
									<option value="<?=$value['id']?>"><?=$value['pagetitle']?> (<?=$value['id']?>)</options>
								<?endforeach;?>
							</select>
						</div>
					</td>
				</tr>

				<tr>
					<td><b>Позиція у списку</b></td>
					<td>
						<input type="text" name="add[product_position]" id="product_position" class="form-control" autocomplete="off" value="0" />

					</td>
				</tr>
				<tr>
					<td><b>Тип товару</b></td>
					<td>
						<label class="col-md-8"><input type="radio" checked name="add[product_top]" value="0"> <span class="text-default">Звичайний</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_top]" value="1"> <span class="text-success">Топ продажів</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_top]" value="2"> <span class="text-warning">Акція</span></label>
						<label class="col-md-8"><input type="radio" name="add[product_top]" value="3"> <span class="text-primary">Новинка</span></label>
					</td>
				</tr>
				<tr>
					<th>Фото</th>
					<td>
						<a href="#" id="uploader" class="btn btn-warning">Завантажити фото</a>
						<ul id="img" class="images">
							
						</ul>
						<div class="clearfix"></div>
						<input type="hidden" name="add[product_cover]" id="cover" value="<?=$product[0]['product_cover']?>" />
					</td>
				</tr>
			</table>
		
		
	</div>
	<div class="pull-right">
		<button class="btn btn-success saveandclose"><span class="glyphicon glyphicon-floppy-disk"></span> Зберегти та закрити</button>
		<button class="btn btn-primary updateproduct" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> <?=$_lang["shop_update_product"]?></button>
	</div>


	<a href="<?=$url?>b=items" class="btn btn-warning"><span class="icon icon-white icon-hand-left"></span> <?=$_lang["shop_cancel"]?></a>
</form>


<div id="overflow"></div>

<script src="//ajax.aspnetcdn.com/ajax/jquery.ui/1.10.3/jquery-ui.min.js"></script>
<script src="/assets/site/ajaxupload.js"></script>
<script>


    $(document).ready(function(){


    	$(".saveandclose").on('click', function(){
    		$('#step').val(1);
    		$('#product_form').submit();
    		return false;
    	});
    	$(".updateproduct").on('click', function(){
    		$('#step').val(0);
    		$('#product_form').submit();
    		return false;
    	});



	  	$("[data-allow]").on("keyup", function(){
  			$(this).val($(this).val().replace(new RegExp($(this).attr("data-allow")), ''));
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
	  		_this.parents('li').addClass('active');
	  		$('#cover').val(_photo);
	  		return false;
	  	});



		new AjaxUpload($("#uploader"), {
			action: "<?=$url?>b=upload",
			multiple: true,
		    name: "uploader[]",
		    data: {
					"size"  : 20485760,
					"product_id": '<?=$product[0]['product_id']?>'
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

	                var _html_li = '<li><span class="link_name"><img src="'+value+'" style="width:200px;"/></span><input type="hidden" name="add[photo][]" value="'+value+'"/><a href="#" data-remove-file-photo="'+value+'" class="remove_link btn btn-danger">×</a><a href="#" data-main-file-photo="'+value+'" class="main_link btn btn-primary">+</a></li>';
	                $('#img').append(_html_li);

				});

		    }
		});
		
    });

</script>
<?=$tiny_mce?>
