<style>
.ord{
	display: inline-block;
	cursor: pointer;
	width: 15px;
	text-align: center;
	color: #428bca;
}
</style>
<form action="<?=$url?>" method="get" role="form" class="pull-right form-inline" id="form_s">
	<select name="school" data-active="<?=$_GET['school']?>">
		<option value="">Всі</option>
		<?foreach($schools as $school):?>
			<option value="<?=$school['id'];?>"><?=$school['pagetitle'];?></option>
		<?endforeach;?>
	</select>

	<select name="city" data-active="<?=$_GET['city']?>">
			<option value="">Всі</option>
		<?foreach($cities as $city):?>
			<option value="<?=$city['city_name'];?>"><?=$city['city_name'];?></option>
		<?endforeach;?>
	</select>

		<div class="form-group">
			<input type="text" name="s" class="form-control" placeholder="<?=$_lang["shop_search_by"];?>" value="<?=$_GET['s']?>" />
		</div>
		<button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
</form>


<div class="clear"></div><br>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">ID <nobr><span class="ord" data-order="ORDER BY wu.id DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.id ASC">&darr;</span></nobr></th>
			<th>Звідки <nobr><span class="ord" data-order="ORDER BY wu.source DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.source ASC">&darr;</span></nobr></th>
			<th>Посилання</th>
			<th>E-mail <nobr><span class="ord" data-order="ORDER BY wu.email DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.email ASC">&darr;</span></nobr></th>
			<th>Ім`я <nobr><span class="ord" data-order="ORDER BY wu.fullname DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.fullname ASC">&darr;</span></nobr></th>
			<th>Прізвище <nobr><span class="ord" data-order="ORDER BY wu.lastname DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.lastname ASC">&darr;</span></nobr></th>
			<th>Телефон <nobr><span class="ord" data-order="ORDER BY wu.phone DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.phone ASC">&darr;</span></nobr></th>
			<th>Статус <nobr><span class="ord" data-order="ORDER BY wu.status DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.status ASC">&darr;</span></nobr></th>
			<th>Перевірено <nobr><span class="ord" data-order="ORDER BY wu.verify DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.verify ASC">&darr;</span></nobr></th>
			<th>Оплата на <nobr><span class="ord" data-order="ORDER BY wu.product_paytype DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.product_paytype ASC">&darr;</span></nobr></th>
			<th>Місто <nobr><span class="ord" data-order="ORDER BY wu.city DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.city ASC">&darr;</span></nobr></th>
			<th>Школа <nobr><span class="ord" data-order="ORDER BY wu.school DESC">&uarr;</span><span class="ord" data-order="ORDER BY wu.school ASC">&darr;</span></nobr></th>
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
			$iu = $modx->config['site_url_b'].$modx->makeUrl('89').$pro['instructor_url'].'/';
		?>
			<tr>
				<td><?=$pro['id']?></td>


				<td><?switch($pro['source']){case "1": echo "OLX"; break; case "0": echo "Реєстрація на сайті"; break;}?></td>
				<td><a href="<?=$iu?>" target="_blank">Посилання</a></td>
				<td><?=$pro['email']?></td>
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
					<?if($pro['status'] == 1):?><span class="label label-success">Опублікований</label><?else:?><span class="label label-danger">Скрито</label><?endif;?>
				</td>
				<td>
					<?if($pro['verify'] == 1):?><span class="label label-success">Перевірено</label><?endif;?>
				</td>
				<td><?=$pays[$pro['product_paytype']]?></td>
				<td><?=$pro['city']?></td>
				<td><?=$pro['school']?></td>
				<td>
					<a href="<?=$url?>b=instructors&c=edit&i=<?=$pro['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> <?=$_lang["shop_edit"]?> </a>
					<a data-confirm="Ви впевнені, що хочете видалити?" href="<?=$url?>b=instructors&c=delete&i=<?=$pro['id']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> <?=$_lang["shop_delete"]?> </a>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<ul class="pagination"><?=$pagin;?></ul>
<script type="text/javascript">
$(document).ready(function(){
    $(document).on('click', '.ord', function(){
    	window.location.replace("<?=$url?>b=instructors&orderby="+$(this).data('order'));
    });



    $(document).on('submit', '#form_s', function(){
    	window.location.replace("<?=$url?>b=instructors&"+$(this).serialize());
    	return false;
    });


});
</script>