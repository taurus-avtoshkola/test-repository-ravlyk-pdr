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
			<th>E-mail <nobr><span class="ord" data-order="ORDER BY w.email DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.email ASC">&darr;</span></nobr></th>
			<th>Ім`я <nobr><span class="ord" data-order="ORDER BY w.fullname DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.fullname ASC">&darr;</span></nobr></th>
			<th>Телефон <nobr><span class="ord" data-order="ORDER BY w.phone DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.phone ASC">&darr;</span></nobr></th>
			<th>Місто <nobr><span class="ord" data-order="ORDER BY w.city DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.city ASC">&darr;</span></nobr></th>
			<th>Дата запису <nobr><span class="ord" data-order="ORDER BY w.reg_date DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.reg_date ASC">&darr;</span></nobr></th>
			<th>UTM <nobr><span class="ord" data-order="ORDER BY w.utm DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.utm ASC">&darr;</span></nobr></th>
			<th width="130px"></th>
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
				<td><?=$pro['email']?></td>
				<td><?=$pro['fullname']?></td>
				<td><?=$pro['phone']?></td>
				<td><?=$pro['city']?></td>
				<td><?=date('d-m-Y H:i:s', ($pro['reg_date']+$modx->config['server_offset_time']));?></td>
				<td><div style="max-width:300px; word-break: break-all;"><?print_r(json_decode($pro['utm'],true));?></div></td>
				<td>
					<a data-confirm="Ви впевнені, що хочете видалити?" href="<?=$url?>b=master&c=delete&i=<?=$pro['id']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> <?=$_lang["shop_delete"]?> </a>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<ul class="pagination"><?=$pagin;?></ul>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.ord', function(){
    	window.location.replace("<?=$url?>b=master&orderby="+$(this).data('order'));
    });
});
</script>