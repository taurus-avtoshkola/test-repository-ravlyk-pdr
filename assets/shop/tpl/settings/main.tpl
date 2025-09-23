<form action="<?=$url?>" method="post">
	<h3><?=$_lang["shop_common"]?></h3>
	<table class="table table-bordered table condensed">



		<tr>
			<td>
				<b>Время жизни memcache</b>
				<br><small class="text-muted">memcache_time</small>
			</td>
			<td><input type="text" name="memcache_time" id="" class="form-control span6" value="<?=$modx->config['memcache_time']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Сервер memcache</b>
				<br><small class="text-muted">memcache_server</small>
			</td>
			<td><input type="text" name="memcache_server" id="" class="form-control span6" value="<?=$modx->config['memcache_server']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Порт memcache</b>
				<br><small class="text-muted">memcache_port</small>
			</td>
			<td><input type="text" name="memcache_port" id="" class="form-control span6" value="<?=$modx->config['memcache_port']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Шаблони з навігацією</b>
				<br><small class="text-muted">templates_vs_paginate</small>
			</td>
			<td><input type="text" name="templates_vs_paginate" class="form-control span6" value="<?=$modx->config['templates_vs_paginate']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Номер телефона</b>
				<br><small class="text-muted">phone</small>
			</td>
			<td><input type="text" name="phone" class="form-control span6" value="<?=$modx->config['phone']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Почта</b>
				<br><small class="text-muted">mailpost</small>
			</td>
			<td><input type="text" name="mailpost" class="form-control span6" value="<?=$modx->config['mailpost']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Адрес</b>
				<br><small class="text-muted">address</small>
			</td>
			<td><input type="text" name="address" class="form-control span6" value="<?=$modx->config['address']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>API KEY - KEY CRM</b>
				<br><small class="text-muted">key_crm_api</small>
			</td>
			<td><input type="text" name="key_crm_api" class="form-control span6" value="<?=$modx->config['key_crm_api']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Джерело ID - KEY CRM</b>
				<br><small class="text-muted">source_key_crm</small>
			</td>
			<td><input type="text" name="source_key_crm" class="form-control span6" value="<?=$modx->config['source_key_crm']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Воронка ID - KEY CRM</b>
				<br><small class="text-muted">pipeline_key_crm</small>
			</td>
			<td><input type="text" name="pipeline_key_crm" class="form-control span6" value="<?=$modx->config['pipeline_key_crm']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Воронка ID 2 - KEY CRM</b>
				<br><small class="text-muted">pipeline_key_crm_2</small>
			</td>
			<td><input type="text" name="pipeline_key_crm_2" class="form-control span6" value="<?=$modx->config['pipeline_key_crm_2']?>" /></td>
		</tr>


		<tr>
			<td>
				<b>Воронка ID 3 - KEY CRM</b>
				<br><small class="text-muted">pipeline_key_crm_3</small>
			</td>
			<td><input type="text" name="pipeline_key_crm_3" class="form-control span6" value="<?=$modx->config['pipeline_key_crm_3']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>ID платіжної системи за замовченням</b>
				<br><small class="text-muted">shop_paysystem_default</small>
			</td>
			<td><input type="text" name="shop_paysystem_default" class="form-control span6" value="<?=$modx->config['shop_paysystem_default']?>" /></td>
		</tr>




		<tr>
			<td>
				<b>Час роботи</b>
				<br><small class="text-muted">worktime</small>
			</td>
			<td><input type="text" name="worktime" class="form-control span6" value="<?=$modx->config['worktime']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>instagram</b>
				<br><small class="text-muted">instagram</small>
			</td>
			<td><input type="text" name="instagram" class="form-control span6" value="<?=$modx->config['instagram']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Facebook</b>
				<br><small class="text-muted">facebook</small>
			</td>
			<td><input type="text" name="facebook" class="form-control span6" value="<?=$modx->config['facebook']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Twitter</b>
				<br><small class="text-muted">twitter</small>
			</td>
			<td><input type="text" name="twitter" class="form-control span6" value="<?=$modx->config['twitter']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Youtube</b>
				<br><small class="text-muted">youtube</small>
			</td>
			<td><input type="text" name="youtube" class="form-control span6" value="<?=$modx->config['youtube']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Tiktok</b>
				<br><small class="text-muted">tiktok</small>
			</td>
			<td><input type="text" name="tiktok" class="form-control span6" value="<?=$modx->config['tiktok']?>" /></td>
		</tr>


		<tr>
			<td>
				<b>Viber</b>
				<br><small class="text-muted">viber</small>
			</td>
			<td><input type="text" name="viber" class="form-control span6" value="<?=$modx->config['viber']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Telegram</b>
				<br><small class="text-muted">telegram</small>
			</td>
			<td><input type="text" name="telegram" class="form-control span6" value="<?=$modx->config['telegram']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Мапа</b>
				<br><small class="text-muted">map</small>
			</td>
			<td><textarea name="map" class="form-control span6"><?=$modx->config['map']?></textarea></td>
		</tr>


		<tr>
			<td>
				<b>Ціна підписки</b>
				<br><small class="text-muted">subscribe_cost</small>
			</td>
			<td><input type="text" name="subscribe_cost" class="form-control span6" value="<?=$modx->config['subscribe_cost']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Ціна покупки відео</b>
				<br><small class="text-muted">price_base_video</small>
			</td>
			<td><input type="text" name="price_base_video" class="form-control span6" value="<?=$modx->config['price_base_video']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Ціна курсу з лектором</b>
				<br><small class="text-muted">price_base_lector</small>
			</td>
			<td><input type="text" name="price_base_lector" class="form-control span6" value="<?=$modx->config['price_base_lector']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Ціна курсу онлайн</b>
				<br><small class="text-muted">price_base</small>
			</td>
			<td><input type="text" name="price_base" class="form-control span6" value="<?=$modx->config['price_base']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Ціна практика механіка</b>
				<br><small class="text-muted">price_mec</small>
			</td>
			<td><input type="text" name="price_mec" class="form-control span6" value="<?=$modx->config['price_mec']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Ціна практика автомат</b>
				<br><small class="text-muted">price_avt</small>
			</td>
			<td><input type="text" name="price_avt" class="form-control span6" value="<?=$modx->config['price_avt']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Дозволено скасування запису на практику (год)</b>
				<br><small class="text-muted">time_to_change_book</small>
			</td>
			<td><input type="text" name="time_to_change_book" class="form-control span6" value="<?=$modx->config['time_to_change_book']?>" /></td>
		</tr>


		<tr>
			<td>
				<b>Промокод для безкоштовного уроку</b>
				<br><small class="text-muted">firstlessonpromo</small>
			</td>
			<td><input type="text" name="firstlessonpromo" class="form-control span6" value="<?=$modx->config['firstlessonpromo']?>" /></td>
		</tr>


		<tr>
			<td>
				<b>Кількість днів Швидкий курс</b>
				<br><small class="text-muted">fastcourse_days</small>
			</td>
			<td><input type="text" name="fastcourse_days" class="form-control span6" value="<?=$modx->config['fastcourse_days']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Кількість місяців Онлайн курс</b>
				<br><small class="text-muted">course_month</small>
			</td>
			<td><input type="text" name="course_month" class="form-control span6" value="<?=$modx->config['course_month']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Esputnik автопідписка</b>
				<br><small class="text-muted">esputnik_subscribe</small>
			</td>
			<td>
				<div class="make-switch" data-on="success" data-off="danger">
					<input type="checkbox" name="esputnik_subscribe" <?=($modx->config['esputnik_subscribe'] ? "checked" : "")?>  value="1">
				</div>
			</td>
		</tr>
		<tr>
			<td>
				<b>Esputnik login</b>
				<br><small class="text-muted">esputnik_login</small>
			</td>
			<td><input type="text" name="esputnik_login" class="form-control span6" value="<?=$modx->config['esputnik_login']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Esputnik password</b>
				<br><small class="text-muted">esputnik_pass</small>
			</td>
			<td><input type="text" name="esputnik_pass" class="form-control span6" value="<?=$modx->config['esputnik_pass']?>" /></td>
		</tr>

		<tr>
			<td>
				<b>Esputnik group ID Реєстрація</b>
				<br><small class="text-muted">esputnik_group_id_registration</small>
			</td>
			<td><input type="text" name="esputnik_group_id_registration" class="form-control span6" value="<?=$modx->config['esputnik_group_id_registration']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Esputnik group ID Пробний урок</b>
				<br><small class="text-muted">esputnik_group_id_lesson</small>
			</td>
			<td><input type="text" name="esputnik_group_id_lesson" class="form-control span6" value="<?=$modx->config['esputnik_group_id_lesson']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Esputnik group ID Вебінар</b>
				<br><small class="text-muted">esputnik_group_id_webi</small>
			</td>
			<td><input type="text" name="esputnik_group_id_webi" class="form-control span6" value="<?=$modx->config['esputnik_group_id_webi']?>" /></td>
		</tr>
		<tr>
			<td>
				<b>Esputnik group ID Майстер-клас</b>
				<br><small class="text-muted">esputnik_group_id_master</small>
			</td>
			<td><input type="text" name="esputnik_group_id_master" class="form-control span6" value="<?=$modx->config['esputnik_group_id_master']?>" /></td>
		</tr>


		
		<tr>
			<td>
				<b>Esputnik group ID Онлайн курс</b>
				<br><small class="text-muted">esputnik_group_id_online</small>
			</td>
			<td><input type="text" name="esputnik_group_id_online" class="form-control span6" value="<?=$modx->config['esputnik_group_id_online']?>" /></td>
		</tr>
	</table>
	<input type="submit" value="Зберегти" class="btn btn-lg btn-primary">
</form>
<?=$tiny_mce;?>