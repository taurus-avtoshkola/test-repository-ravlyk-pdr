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
			<th width="50px">ID <nobr><span class="ord" data-order="ORDER BY wua.internalKey DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.internalKey ASC">&darr;</span></nobr></th>
			<th>E-mail <nobr><span class="ord" data-order="ORDER BY wu.username DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.username ASC">&darr;</span></nobr></th>
			<th>Ім`я <nobr><span class="ord" data-order="ORDER BY wua.fullname DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.fullname ASC">&darr;</span></nobr></th>
			<th>Прізвище <nobr><span class="ord" data-order="ORDER BY wua.lastname DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.lastname ASC">&darr;</span></nobr></th>
			<th>Телефон <nobr><span class="ord" data-order="ORDER BY wua.phone DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.phone ASC">&darr;</span></nobr></th>
			<th>Тип <nobr><span class="ord" data-order="ORDER BY wua.user_type DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.user_type ASC">&darr;</span></nobr></th>
			<th>Тип (оплата)<nobr><span class="ord" data-order="ORDER BY wua.user_type DESC, wua.user_type_p DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.user_type ASC, wua.user_type_p ASC">&darr;</span></nobr></th>
			<th>Дата закінчення Premium <nobr><span class="ord" data-order="ORDER BY wua.subscribedate DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.subscribedate ASC">&darr;</span></nobr></th>
			<th>UTM source<nobr><span class="ord" data-order="ORDER BY wua.utm DESC">&uarr;</span><span class="ord" data-order="ORDER BY wua.utm ASC">&darr;</span></nobr></th>
			<th width="260px"></th>
		</tr>
	</thead>
	<tbody>
		<? 
			if ($modx->db->getRecordCount($users) == 0):
		?>
			<tr>
				<th colspan="6" class="text-center"><h4><?=$_lang["shop_on_request"];?> <i><u><?=$_GET['s']?></u></i> <?=$_lang["shop_not_found"];?></h4></th>
			</tr>
		<?
			else: 
			while ($pro = $modx->db->getRow($users)): 
			$i++;
		?>
			<tr>
				<td><?=$pro['internalKey']?></td>
				<td><?=$pro['username']?> <?if($pro['cabinet_type'] == '1'){echo '</br><span class="label label-success">Інструктор</span>';}?><?if($pro['cabinet_type'] == '2'){echo '</br><span class="label label-success">Менеджер</span>';}?><?if($pro['cabinet_type'] == '3'){echo '</br><span class="label label-success">Супер-менеджер</span>';}?></td>
				<td>
					<?=$pro['fullname']?>
				</td>
				<td>
					<?=$pro['lastname']?>
				</td>
				<td>
					<?=$pro['phone']?>
				</td>
				<td>
					<?if($pro['user_type']=='1'){echo '<label class="label label-success">Преміум</label>';}else{echo '<label class="label label-default">Звичайний</label>';}?>
				</td>
				<td>
					<?if($pro['user_type_p']=='1'){echo '<label class="label label-success">Оплачено</label>';}else{if($pro['user_type']=='1'){echo '<label class="label label-default">TRIAL</label>';}}?>
				</td>

				<td>
					<?=date('d.m.Y H:i:s',$modx->config['server_offset_time']+$pro['subscribedate'])?>
				</td>
				<td>
					<?$utm = json_decode($pro['utm'],true);echo $utm['utm_source'];?>
				</td>

				<td>
				<nobr>
					<a href="<?=$url?>b=users&c=edit&i=<?=$pro['internalKey']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> <?=$_lang["shop_edit"]?> </a>
					<a href="<?=$url?>b=users&c=login&i=<?=$pro['email']?>" class="btn btn-mini btn-warning">Увійти в кабінет </a>
					<a data-confirm="Ви впевнені, що хочете видалити?" href="<?=$url?>b=users&c=delete&i=<?=$pro['internalKey']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> <?=$_lang["shop_delete"]?> </a>
				</nobr>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<ul class="pagination"><?=$pagin;?></ul>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.ord', function(){
    	window.location.replace("<?=$url?>b=users&orderby="+$(this).data('order'));
    });
});
</script>