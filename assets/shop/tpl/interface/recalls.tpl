<div class="clear"></div><br>
<form action="<?=$url?>b=recalls" method="post" enctype="multipart/form-data" class="pull-right">
	<table class="table-condensed">
		<tr>
			<td class="text-right">з</td>
			<td>
				<div id="datetimepicker" class="input-append date">
				  <input data-format="yyyy-MM-dd" type="text" name="date_from" id="datetimepicker" class="form-control add-on" style="width: 100px;" value="<?=$_REQUEST['date_from']?>"></input>
				</div>
			</td>
			<td>по</td>
			<td>
				<div id="datetimepicker2" class="input-append date">
				  <input data-format="yyyy-MM-dd" type="text" name="date_to" id="datetimepicker2" class="form-control add-on" style="width: 100px;" value="<?=$_REQUEST['date_to']?>"></input>
				</div>
			</td>
		</tr>
		<tr>
			<td><?=$_lang["shop_status"]?></td>
			<td colspan="3">
				<select name="status" class="nc form-control">
					<option value="-1" <?php if($_REQUEST['status'] == -1) echo 'selected';?> >Всі</option>
					<option value="0" <?php if($_REQUEST['status'] == 0) echo 'selected';?> >Не опублікований</option>
					<option value="1" <?php if($_REQUEST['status'] == 1) echo 'selected';?> >Опублікований</option>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="4" class="text-right">
				<button name="b" value="recalls" class="btn btn-primary"><span class="glyphicon glyphicon-filter"></span> Фільтрувати</button>
			</td>
		</tr>
	</table>
</form>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">ID</th>
			<th>Ім'я</th>
			<th width="110px">E-mail</th>
			<th width="120px">Дата</th>
			<th width="120px">Статус</th>
			<th width="260px"></th>
		</tr>
	</thead>
	<tbody>
		<? 
			if ($modx->db->getRecordCount($recalls) == 0):
		?>
			<tr>
				<th colspan="7" class="text-center"><h4>За запитом <i><u><?=$_GET['s']?></u></i> Нічого не знайдено</h4></th>
			</tr>
		<?
			else: 
			while ($recall = $modx->db->getRow($recalls)): 
			$i++;
		?>
			<tr>				
				<td><?=$recall['recall_id']?></td>
				<td><?=$recall['recall_name']?></td>
				<td><?=$recall['recall_email']?></td>
				<td><?=$recall['recall_pub_date']?></td>
				<td>
					<b>
						<? if ($recall['recall_moderated'] == 0): ?><span class="label label-danger"><?=$_lang["shop_not_pub"]?></span><? endif ?>
						<? if ($recall['recall_moderated'] == 1): ?><span class="label label-success"><?=$_lang["shop_pub"]?></span><? endif ?>
					</b>
				</td>
				<td>
					<a href="<?=$url?>b=recalls&c=edit&i=<?=$recall['recall_id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
					<a data-confirm="Точно видалити?" href="<?=$url?>b=recalls&c=delete&i=<?=$recall['recall_id']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Видалити</a>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<ul class="pagination"><?=$pagin;?></ul>
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