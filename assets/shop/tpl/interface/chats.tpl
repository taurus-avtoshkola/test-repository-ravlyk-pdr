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
			<th>Код<nobr><span class="ord" data-order="ORDER BY w.chat_id DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.chat_id ASC">&darr;</span></nobr></th>
			<th>Статус <nobr><span class="ord" data-order="ORDER BY w.status DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.status ASC">&darr;</span></nobr></th>
			<th>Дата початку <nobr><span class="ord" data-order="ORDER BY w.chat_date DESC">&uarr;</span><span class="ord" data-order="ORDER BY w.chat_date ASC">&darr;</span></nobr></th>


			<th>Повідомлень</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? 
			if ($modx->db->getRecordCount($chats) == 0):
		?>
			<tr>
				<th colspan="5" class="text-center"><h4><?=$_lang["shop_on_request"];?> <i><u><?=$_GET['s']?></u></i> <?=$_lang["shop_not_found"];?></h4></th>
			</tr>
		<?
			else: 
			while ($pro = $modx->db->getRow($chats)): 
			$i++;
		?>
			<tr>
				<td><?=$pro['id']?></td>
				<td><?=$pro['chat_id']?></td>
				<td><?
				switch($pro['status']){
						case '1':
							echo '<span class="label label-danger">Закрито</span>';
						break;
						case '0':
							echo '<span class="label label-success">Створено</span>';
						break;
				}?></td>
				<td><?=date('d-m-Y H:i:s', ($pro['chat_date']+$modx->config['server_offset_time']));?></td>
				<td><?=$pro['message_cnt']?></td>
				<td><a href="<?=$url?>b=chats&c=chat_view&chat_id=<?=$pro['chat_id']?>" class="btn btn-primary">Читати</a></td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<ul class="pagination"><?=$pagin;?></ul>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.ord', function(){
    	window.location.replace("<?=$url?>b=chat&orderby="+$(this).data('order'));
    });
});
</script>