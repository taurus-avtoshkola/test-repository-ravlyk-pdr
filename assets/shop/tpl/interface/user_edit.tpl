
<form action="<?=$url?>b=users&c=update" method="post" enctype="multipart/form-data">
	<div class="pull-right">
		<button class="btn btn-primary" type="submit"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити</button>
		<button class="btn btn-success saveandclose"><span class="glyphicon glyphicon-floppy-disk"></span> Оновити та закрити</button>
	</div>
	<input type="hidden" name="step" id="step" value="0"/>

	<br>
	<table class="table table-condensed table-bordered table-striped">

		<tr>
			<td><b>Зміна паролю</b></br><small>заповнити новий пароль</small></td>
			<td><input type="text" name="edit[newpass]" class="form-control" value="" /></td>
		</tr>

		<tr>
			<td><b>E-mail</b></td>
			<td><input type="text" name="edit[username]" class="form-control" value="<?=$user['username']?>" /></td>
		</tr>
		<tr>
			<td><b>Ім`я</b></td>
			<td><input type="text" name="edit[fullname]" class="form-control" value="<?=$user['fullname']?>" /></td>
		</tr>
		<tr>
			<td><b>Прізвище</b></td>
			<td><input type="text" name="edit[lastname]" class="form-control" value="<?=$user['lastname']?>" /></td>
		</tr>
		<tr>
			<td><b>По-батькові</b></td>
			<td><input type="text" name="edit[patronymic]" class="form-control" value="<?=$user['patronymic']?>" /></td>
		</tr>
		<tr>
			<td><b>Телефон</b></td>
			<td><input type="text" name="edit[phone]" class="form-control" value="<?=$user['phone']?>" /></td>
		</tr>
		<tr>
			<td><b>Місто</b></td>
			<td><input type="text" name="edit[city]" class="form-control" value="<?=$user['city']?>" /></td>
		</tr>
		<tr>
			<td>Дата останнього візиту</td>
			<td><?=$shop->formatDate($user['lastlogin'], true)?></td>
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

		<?if($user['free_premium'] == '0'):?>
			<tr>
			<td><b>Активувати безкоштовний преміум на 2 місяці</b></td>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="edit[free_premium]" <?=($user['free_premium'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<?endif;?>
		<tr>
			<td><b>Доступний онлайн курс</b></td>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="edit[online_course]" <?=($user['online_course'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>



		<tr>
			<td><b>Категорія яку хочете отримати</b></td>
			<td>
				<select type="text" name="edit[category_type]" class="form-control" data-active="<?=$user['category_type']?>">
					<option value="">Оберіть категорію</option>
					<option value="a">Мотоцикли (Категорія A)</option>
					<option value="b">Легкові автомобілі (категорія B)</option>
					<option value="c">Вантажні автомобілі (категорія C)</option>
					<option value="d">Автобуси (категорія D)</option>
					<option value="e">Причепи (категорія E)</option>
				</select>
			</td>
		</tr>

		<tr>
			<td><b>Коробка передач</b></td>
			<td>
				<select type="text" name="edit[transmission]" class="form-control" data-active="<?=$user['transmission']?>">
					<option value="">Коробка передач</option>
					<option value="manual">Механіка</option>
					<option value="automatic">Автомат</option>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>Фото</b></td>
			<td>
				<select type="text" name="edit[test_photo]" class="form-control" data-active="<?=$user['test_photo']?>">
					<option value="1">Офіційні</option>
					<option value="0">Равлик ПДР</option>
				</select>
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
		<?if($user['cabinet_type'] == '1'):?>
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
		<?endif;?>

		<tr>
			<td><b>Автошкола</b></td>
			<td>
				<select name="edit[school]" class="form-control" data-active="<?=$user['school']?>" >	
					<option value="0">Не вказано</option>				
					<?php while($r = $modx->db->getRow($school)):?>
						<option value="<?=$r['id']?>"><?=$r['pagetitle']?></option>
					<?endwhile;?>
				</select>
			</td>
		</tr>
		<tr>
			<td><b>utm_source</b></td>
			<td><input type="text" name="edit[utm][utm_source]" class="form-control" value="<?=$utm['utm_source']?>" /></td>
		</tr>
		<tr>
			<td><b>utm_medium</b></td>
			<td><input type="text" name="edit[utm][utm_medium]" class="form-control" value="<?=$utm['utm_medium']?>" /></td>
		</tr>
		<tr>
			<td><b>utm_campaign</b></td>
			<td><input type="text" name="edit[utm][utm_campaign]" class="form-control" value="<?=$utm['utm_campaign']?>" /></td>
		</tr>
		<tr>
			<td><b>utm_content</b></td>
			<td><input type="text" name="edit[utm][utm_content]" class="form-control" value="<?=$utm['utm_content']?>" /></td>
		</tr>
		<tr>
			<td><b>utm_term</b></td>
			<td><input type="text" name="edit[utm][utm_term]" class="form-control" value="<?=$utm['utm_term']?>" /></td>
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
