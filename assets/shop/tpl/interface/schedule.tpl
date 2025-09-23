<style>
.ord{
	display: inline-block;
	cursor: pointer;
	width: 15px;
	text-align: center;
	color: #428bca;
}
</style>

<table class="table">
	<tr>
		<td>
			<div class="input-group">
				<span class="addon-input-group" style="margin-right: 4px;">Статус </span>
				<select name="status_select" id="status_select" style="width:250px;" data-active="<?=$_GET['status']?>">
					<option value="-1">Усі</option>
					<option value="0">Активно</option>
					<option value="1">Очікування</option>
					<option value="2">Не активно</option>
				</select>
			</div>
		</td>



		<td>
			<form action="index.php" method="get" role="form" class="pull-right form-inline">
				<? foreach ($_GET as $k => $v): if ($k != "s"): ?>
				<input type="hidden" name="<?=$k?>" value="<?=$v?>" />
			<? endif; endforeach ?>
			<div class="form-group">
				<input type="text" name="s" id="searching" class="form-control" placeholder="Пошук..." value="<?=$_GET['s']?>" />
			</div>
			<button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
		</form>
	</td>

	<td style="width:170px;">

		<a href="<?=$url?>b=schedule&filter=0" class="btn btn-warning" style="">
			<span class="glyphicon glyphicon glyphicon-off"></span> 
			Скинути фільтри
		</a>
	</td>	
</tr>
</table>
<a href="<?=$url?>b=schedule&c=add" class="btn btn-success">Додати новий</a>
<table style="width:100%;">
	<tr>
		<td style="width:50%">
			<ul class="pagination"><?=$pagin;?></ul>
		</td>
		<td style="width:50%">
			<div class="pull-right">
				<div class="input-group">

					<label class="label label-primary input-group-addon" style="font-size: 12px;">Виводити по:</label>
					<select style="width:60px;" name="limit" class="lim" data-active="<?=$_GET['limit']?>">
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="500">500</option>
					</select>
				</div>
			</div>
		</td>
	</tr>
</table>


<div class="clear"></div><br>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th>№<nobr><span class="ord" data-order="ORDER BY p.id DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.id ASC">&darr;</span></nobr></th>
			<th>Клієнт <nobr><span class="ord" data-order="ORDER BY p.user_name DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.user_name ASC">&darr;</span></nobr></th>	
			<th>Телефон<nobr><span class="ord" data-order="ORDER BY p.user_phone DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.user_phone ASC">&darr;</span></nobr></th>			
			<th>Інструктор <nobr><span class="ord" data-order="ORDER BY p.instructor_name DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.instructor_name ASC">&darr;</span></nobr></th>
			<th>Всього<nobr><span class="ord" data-order="ORDER BY p.lesson_total DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.lesson_total ASC">&darr;</span></nobr></th>
			<th>Залишок<nobr><span class="ord" data-order="ORDER BY p.lesson_balance DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.lesson_balance ASC">&darr;</span></nobr></th>
			<th>Статус<nobr><span class="ord" data-order="ORDER BY p.status DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.status ASC">&darr;</span></nobr></th>			
			<th>Оплата<nobr><span class="ord" data-order="ORDER BY p.status_pay DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.status_pay ASC">&darr;</span></nobr></th>		
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? 
			if ($modx->db->getRecordCount($schedule) == 0):
		?>
			<tr>
				<th colspan="8" class="text-center"><h4><?=$_lang["shop_on_request"];?> <i><u><?=$_GET['s']?></u></i> <?=$_lang["shop_not_found"];?></h4></th>
			</tr>
		<?
			else: 
			while ($pro = $modx->db->getRow($schedule)): 
			$i++;
		?>
			<tr>
				<td><?=$pro['id']?></td>
				<td><?=$pro['user_name']?></td>
				<td><?=$pro['user_phone']?></td>
				<td><?=$pro['instructor_name']?></td>
				<td>
					<?=$pro['lesson_total'];?>
				</td>
				<td>
					<?=$pro['lesson_balance'];?>
				</td>
				<td>
						<?php 						
							switch ($pro['status']) {
								case '0':
									echo '<span class="label label-success">Активно</span>';
								break;
								case '1':
									echo '<span class="label label-default">Очікування</span>';
								break;
								case '2':
									echo '<span class="label label-danger">Не активно</span>';
								break;
							}
						?>
				</td>
				<td>
						<?php 						
							switch ($pro['status_pay']) {
								case '0':
									echo '<span class="label label-danger">Не оплачено</span>';
								break;
								case '1':
									echo '<span class="label label-success">Оплачено</span>';
								break;
							}
						?>
				</td>
				<td>
					<a href="<?=$url?>b=schedule&c=edit&i=<?=$pro['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:50%">
			<ul class="pagination"><?=$pagin;?></ul>
		</td>
		<td style="width:50%">
			<div class="pull-right">
				<div class="input-group">

					<label class="label label-primary input-group-addon" style="font-size: 12px;">Виводити по:</label>
					<select style="width:60px;" name="limit" class="lim" data-active="<?=$_GET['limit']?>">
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="500">500</option>
					</select>
				</div>
			</div>
		</td>
	</tr>
</table>


<script type="text/javascript">
$(document).ready(function(){
	
    $(document).on('change', '#status_select', function(){     

        <? $status = str_replace('&status='.$_GET['status'], '', $p_url); ?>
    	window.location.replace("<?=$status?>&status="+$(this).val());
    });
    $(document).on('click', '.ord', function(){

    	<? $orderby = str_replace('&orderby='.$_GET['orderby'], '', $p_url); ?>
    	window.location.replace("<?=$orderby?>&orderby="+$(this).data('order'));

    });
    $(document).on('change', '.lim', function(){
    	<? $limit = str_replace('&limit='.$_GET['limit'], '', $p_url); ?>
    	window.location.replace("<?=$limit?>&limit="+$(this).val());
        return false;
    });
    $(document).on('keyup','#searching',function(e){
		if(e.keyCode == '13'){
		$(this).parents('form').submit();
		}
    });
});
</script>
