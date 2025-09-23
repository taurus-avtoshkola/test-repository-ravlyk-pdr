<form action="<?=$url?>&get=config" method="post">
	<table class="table table-bordered table-striped table-hover table-condensed">
		<tr>
			<td>Сервер</td>
			<td><input type="text" name="mailer_smtp_server" value="<?=$modx->config['mailer_smtp_server']?>" class="span4"></td>
		</tr>
		<tr>
			<td>Порт</td>
			<td><input type="text" name="mailer_smtp_port" value="<?=$modx->config['mailer_smtp_port']?>" class="span1"></td>
		</tr>
		<tr>
			<td>Шифрование</td>
			<td>
				<label class="pull-left span1"><input type="checkbox" name="mailer_smtp_tls" value="1" <?=$modx->config['mailer_smtp_tls'] ? "checked='checked'" : ""?>> TLS</label>
				<label class="pull-left span1"><input type="checkbox" name="mailer_smtp_ssl" value="1" <?=$modx->config['mailer_smtp_ssl'] ? "checked='checked'" : ""?>> SSL</label>
			</td>
		</tr>
		<tr>
			<td>Логин</td>
			<td><input type="text" name="mailer_smtp_login" value="<?=$modx->config['mailer_smtp_login']?>" class="span4"></td>
		</tr>
		<tr>
			<td>Пароль</td>
			<td><input type="text" name="mailer_smtp_pass" value="<?=$modx->config['mailer_smtp_pass']?>" class="span4"></td>
		</tr>
		<tr>
			<td>Отправитель</td>
			<td><input type="text" name="mailer_smtp_name" value="<?=$modx->config['mailer_smtp_name']?>" class="span4"></td>
		</tr>
		<tr>
			<td>Сколько писем отправлять за один заход</td>
			<td><input type="text" name="mailer_smtp_limit" value="<?=$modx->config['mailer_smtp_limit']?>" class="span2"></td>
		</tr>
	</table>
	<input type="submit" value="Сохранить" class="btn btn-large btn-primary">
</form>