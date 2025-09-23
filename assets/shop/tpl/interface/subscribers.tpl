<style>
.ord{
	display: inline-block;
	cursor: pointer;
	width: 15px;
	text-align: center;
	color: #428bca;
}
</style>
<form action="index.php" method="get" role="form" class="pull-right form-inline">
	<? foreach ($_GET as $k => $v): if ($k != "s"): ?>
		<input type="hidden" name="<?=$k?>" value="<?=$v?>" />
	<? endif; endforeach ?>
		<div class="form-group">
			<input type="text" name="s" class="form-control" placeholder="<?=$_lang["shop_search_by"];?>" value="<?=$_GET['s']?>" />
		</div>
		<button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
</form>


<div class="clear"></div><br>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">ID <nobr><span class="ord" data-order="ORDER BY w.id DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.id ASC">&darr;</span></nobr></th>
			<th>Замовлення<nobr><span class="ord" data-order="ORDER BY w.hash DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.hash ASC">&darr;</span></nobr></th>
			<th>E-mail <nobr><span class="ord" data-order="ORDER BY wua.email DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.email ASC">&darr;</span></nobr></th>
			<th>Телефон <nobr><span class="ord" data-order="ORDER BY wua.phone DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.phone ASC">&darr;</span></nobr></th>
			<th>Ім`я <nobr><span class="ord" data-order="ORDER BY wua.fullname DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.fullname ASC">&darr;</span></nobr></th>
			<th>Статус оплати <nobr><span class="ord" data-order="ORDER BY w.status_pay DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.status_pay ASC">&darr;</span></nobr></th>
			<th>Статус підписки <nobr><span class="ord" data-order="ORDER BY w.status DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.status ASC">&darr;</span></nobr></th>
			<th>Дата початку <nobr><span class="ord" data-order="ORDER BY w.start DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.start ASC">&darr;</span></nobr></th>
			<th>Дата наступної оплати <nobr><span class="ord" data-order="ORDER BY w.next DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.next ASC">&darr;</span></nobr></th>
			<th>Дата кінця <nobr><span class="ord" data-order="ORDER BY w.end DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.end ASC">&darr;</span></nobr></th>
			<th>UTM source<nobr><span class="ord" data-order="ORDER BY wua.utm DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.utm ASC">&darr;</span></nobr></th>
		</tr>
	</thead>
	<tbody>
		<? 
			if ($modx->db->getRecordCount($users) == 0):
		?>
			<tr>
				<th colspan="8" class="text-center"><h4><?=$_lang["shop_on_request"];?> <i><u><?=$_GET['s']?></u></i> <?=$_lang["shop_not_found"];?></h4></th>
			</tr>
		<?
			else: 
			while ($pro = $modx->db->getRow($users)): 
			$i++;
		?>
			<tr>
				<td><?=$pro['id']?></td>
				<td><?=$pro['hash']?></td>
				<td><?=$pro['email']?></td>
				<td><?=$pro['phone']?></td>
				<td><?=$pro['fullname']?></td>
				<td><?
				switch($pro['status_pay']){
						case '0':
							echo '<span class="label label-danger">Не сплачено</span>';
						break;
						case '1':
							echo '<span class="label label-success">Оплачено</span>';
						break;
				}?></td>
				<td><?
				switch($pro['status']){
						case '0':
							echo '<span class="label label-danger">Не активно</span>';
						break;
						case '1':
							echo '<span class="label label-success">Активно</span>';
						break;
						case '2':
							echo '<span class="label label-warning">Призупинено</span>';
						break;
						case '3':
							echo '<span class="label label-danger">Скасовано</span>';
						break;
						case '4':
							echo '<span class="label label-warning">Завершено</span>';
						break;
				}?></td>
				<td><?=date('d-m-Y H:i:s', ($pro['start']+$modx->config['server_offset_time']));?></td>
				<td><?=date('d-m-Y H:i:s', ($pro['next']+$modx->config['server_offset_time']));?></td>
				<td><?=date('d-m-Y H:i:s', ($pro['end']+$modx->config['server_offset_time']));?></td>
				<td>
					<?$utm = json_decode($pro['utm'],true);echo $utm['utm_source'];?>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<ul class="pagination"><?=$pagin;?></ul>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.ord', function(){
    	window.location.replace("<?=$url?>b=subscribers&orderby="+$(this).data('order'));
    });
});
</script>