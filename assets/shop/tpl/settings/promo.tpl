<div class="container-fluid">
<h3>Промокоди</h3>

<form action="<?=$url?>b=promo&c=new" method="post">
	<table class="table table-bordered table condensed">
		<tr>
			<th width="200px">Промокод *(якщо порожньо - система створить рандомний)</th>
			<td>
				<input type="text" name="promocode"  class="form-control" placeholder="" />
			</td>
		</tr>


		<tr>
			<th width="200px">Сума знижки</th>
			<td>
				<input type="text" name="discount" class="form-control" placeholder=""/>
			</td>
		</tr>
		<tr>
			<th width="200px">Багаторазовий код?</th>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="multicode" id="multicode" value="1">
				</div>
			</td>
		</tr>

		<tr>
			<th width="200px">Дата початку промокоду у форматі ДД-ММ-ГГГГ ЧЧ:ММ:СС</th>
			<td>
				<div class="input-append date" id="datetimepicker">
					<input data-format="dd-MM-yyyy hh:mm:ss" id="datetimepicker" type="text" name="date_start" class="form-control add-on" autocomplete="off" value="">
				</div>
			</td>
		</tr>
		<tr>
			<th width="200px">Дата кінця промокоду у форматі ДД-ММ-ГГГГ ЧЧ:ММ:СС</th>
			<td>
				<div class="input-append date" id="datetimepicker2">
					<input data-format="dd-MM-yyyy hh:mm:ss" id="datetimepicker2" type="text" name="date_end" class="form-control add-on" autocomplete="off" value="">
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<input type="submit" value="Створити" class="btn btn-mini btn-info">
			</td>
		</tr>
	</table>
</form>

<h2>Активні промокоди</h2>


<table class="table table-bordered table condensed">
	<tr >
		<th>
			<b>Промокод</b>
		</th>
		<th>
			Сума знижки
		</th>
		<th>
			Багаторазовий код
		</th>
		<th>
			Початок
		</th>
		<th>
			Кінець
		</th>
		<th>
			
		</th>
	</tr>
<?foreach ($promos as $key => $value):?>
<tr <?php if($value['available'] == '0'){echo 'class="danger";';}?>>
<td><?=$value['promocode']?></td>
<td><?=$value['discount']?></td>
<td><?if($value['multicode'] == '1'){echo 'Так';}else{echo 'Ні';}?></td>
<td><?=date('d-m-Y H:i:s',$value['date_start'])?></td>
<td><?=date('d-m-Y H:i:s',$value['date_end'])?></td>
<td><a href="<?=$url?>b=promo&c=removepromocode&i=<?=$value['id']?>" class="btn btn-danger">Видалити промокод</a></td>
</tr>
<?endforeach;?>
	
</table>

<script type="text/javascript">
$(document).ready(function(){
	$('#datetimepicker').datetimepicker({
	language: 'ru'
	});	
	$('#datetimepicker2').datetimepicker({
	language: 'ru'
	});	
});
</script>