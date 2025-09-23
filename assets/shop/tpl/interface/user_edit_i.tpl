<form action="<?=$url?>b=users&c=update_i" method="post" enctype="multipart/form-data">
	<div class="pull-right">
		<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити</button>
		<button class="btn btn-success saveandclose"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити та закрити</button>
	</div>
	<input type="hidden" name="step" id="step" value="0"/>

	<br>
	<table class="table table-condensed table-bordered table-striped">
		<tr>
			<td><b>E-mail</b></td>
			<td><?=$user['username']?></td>
		</tr>
		<tr>
			<td><b>Ім`я</b></td>
			<td><?=$user['fullname']?></td>
		</tr>
		<tr>
			<td><b>Прізвище</b></td>
			<td><?=$user['lastname']?></td>
		</tr>
		<tr>
			<td><b>Телефон</b></td>
			<td><?=$user['phone']?></td>
		</tr>
		<tr>
			<td><b>Місто</b></td>
			<td><?=$user['city']?></td>
		</tr>
		<tr>
			<td><b>Користувач заблокований</b></td>
			<td>
				<div class="make-switch" data-on="danger" data-off="success">
					<input type="checkbox" name="edit[blocked]" <?=($user['blocked'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<tr>
			<td><b>Тип користувача(модуль інструктори)</b></td>
			<td>
				<select type="text" name="edit[cabinet_type]" class="form-control" data-active="<?=$user['cabinet_type']?>">
					<option value="0">Звичайний користувач</option>
					<option value="1">Інструктор</option>
					<option value="2">Менеджер</option>
					<option value="3">Супер-менеджер</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Тип користувача</b></td>
			<td>
				<select type="text" name="edit[user_type]" class="form-control" data-active="<?=$user['user_type']?>">
					<option value="0">Звичайний користувач</option>
					<option value="1">Premium користувач</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Не Trial версія</b></td>
			<td>
				<div class="make-switch" data-on="danger" data-off="success">
					<input type="checkbox" name="edit[user_type_p]" <?=($user['user_type_p'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<tr>
			<td><b>Дата закінчення преміум</b></td>
			<td><input type="text" name="edit[subscribedate]" class="form-control" value="<?=date('d.m.Y H:i:s',$modx->config['server_offset_time']+$user['subscribedate'])?>" /></td>
		</tr>
		<tr>
			<td><b>Зафіксувати дату</b></td>
			<td>
				<div class="make-switch" data-on="danger" data-off="success">
					<input type="checkbox" name="edit[subscribefix]" <?=($user['subscribefix'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>

		<tr>
			<td><b>Ім'я користувача в базі (модуль інструктори)</b></td>
			<td>
			<input type="text" name="edit[cabinet_syncname]" class="form-control" value="<?=$user['cabinet_syncname']?>" />
			</td>
		</tr>
		<tr>
			<td><b>ЗП за 1 заняття (модуль інструктори)</b></td>
			<td>
			<input type="text" name="edit[cabinet_zp]" class="form-control" value="<?=$user['cabinet_zp']?>" />
			</td>
		</tr>
		<tr>
			<td><b>Кабінет для запису/перегляду</b></td>
			<td>
				<a href="<?=substr($modx->config['site_url'], 0, -1)?><?=$modx->makeUrl('188')?>?instructor=<?=$user['internalKey']?>" target="_blank"><?=substr($modx->config['site_url'], 0, -1)?><?=$modx->makeUrl('188')?>?instructor=<?=$user['internalKey']?></a>
			</td>
		</tr>

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
			<td><b>Коментар (внутрішня інформація)</b></td>
			<td><textarea name="edit[user_inner_comment]" class="form-control" ><?=$user['user_inner_comment']?></textarea></td>
		</tr>


	</table>
		
		<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити</button>
		<button class="btn btn-success saveandclose"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити та закрити</button>
	<input type="hidden" name="edit[id]" value="<?=$user['internalKey']?>" />
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

</script>
<?=$tiny_mce?>
