<form action="<?=$url?>b=recalls_content&c=update" method="post">
	<h3 class="muted"><?=$_lang["shop_recall_edit"]?></h2>
	<table class="table table-bordered">
		<tr>
			<th width="200px">Ім`я</th>
			<td><input type="text" name="recall[name]" class="form-control" value="<?=$recall['recall_name']?>"></td>
		</tr>
		<tr>
			<th width="200px">E-mail</th>
			<td><input type="text" name="recall[email]" class="form-control" value="<?=$recall['recall_email']?>"></td>
		</tr>
		<tr>
			<th width="200px">Посилання соц. мережі</th>
			<td><input type="text" name="recall[soclink]" class="form-control" value="<?=$recall['recall_soclink']?>"></td>
		</tr>
		<tr>
			<th width="200px">Відгук</th>
			<td><textarea name="recall[text]" class="form-control"><?=$recall['recall_text']?></textarea></td>
		</tr>


		<tr>
			<th width="200px">Відповідь адміністратора:</th>
			<td><textarea name="recall[answer]" class="form-control"><?=$recall['recall_answer']?></textarea></td>
		</tr>

		<tr>
			<th width="200px">Оцінка</th>
			<td><input type="text" name="recall[mark]" class="form-control" value="<?=$recall['recall_mark']?>"></td>
		</tr>
		<tr>
			<th>Статус</th>
			<td>
				<label><input type="radio" name="recall[moderated]" <?=($recall['recall_moderated'] == 0 ? 'checked' : '')?> value="0"> Не опубліковано </label><br>
				<label><input type="radio" name="recall[moderated]" <?=($recall['recall_moderated'] == 1 ? 'checked' : '')?> value="1"> Опубліковано </label><br>
			</td>
		</tr>
		<tr>
			<th>Дата</th>
			<td><?=$recall['recall_pub_date']?></td>
		</tr>
		<tr>
			<th>Сторінка ІD</th>
			<td><?=$recall['recall_contentid']?></td>
		</tr>
	</table>
	<input type="hidden" name="recall[id]" value="<?=$recall['recall_id']?>">
	<input type="submit" value="Оновити" class="btn btn-primary">
</form>
