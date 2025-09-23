<p>
<a class="btn btn-primary" href="#" data-message-all="1"><span class="glyphicon glyphicon-envelope"></span> Нове повідомлення усім</a>
</p>
</br>
<form action="<?=$url?>b=telegram&c=update" method="post">
<table class="table table-condensed table-bordered table-striped">
<thead>
<tr>
<th><nobr>Чат ID</nobr></th>
<th><nobr>user ID</nobr></th>
<th><nobr>Ім`я телеграм</nobr></th>
<th><nobr>Нікнейм</nobr></th>
<th><nobr>Телефон</nobr></th>
<th><nobr>E-mail</nobr></th>
<th><nobr>Тип акаунту</nobr></th>
<th><nobr>Сповіщення</nobr></th>
<th></th>
</tr>

<tbody>
<?$o_n_v = 0;?>
<? while ($o = $modx->db->getRow($tg_users)): ?>
<tr>
<td><?=$o['chat_id']?></td>
<td><?=$o['modx_id']?></td>
<td><?=$o['telegram_name']?></td>
<td><?=$o['telegram_nick']?></td>
<td><?=$o['phone']?></td>
<td><?=$o['email']?></td>
<td>
	<select type="text" name="edit[<?=$o['chat_id']?>][telegram_type]" class="form-control" data-active="<?=$o['telegram_type']?>" style="max-width:120px;">
		<option value="0">Звичайний користувач</option>
		<option value="1">Інструктор</option>
		<option value="2">Менеджер</option>
		<option value="3">Супер-менеджер</option>
	</select>
</td>
<td>

						<label class="col-md-8"><input type="radio" <?=($o['telegram_notify'] == 0 ? "checked" : "")?> name="edit[<?=$o['chat_id']?>][telegram_notify]" value="0"> <span class="text-danger">Ні</span></label>
						<label class="col-md-8"><input type="radio" <?=($o['telegram_notify'] == 1 ? "checked" : "")?> name="edit[<?=$o['chat_id']?>][telegram_notify]" value="1"> <span class="text-success">Так</span></label>
</td>



<td><a href="#" data-private="<?=$o['chat_id']?>" class="btn btn-mini btn-info"><span class="glyphicon glyphicon-envelope"></span> Приватне повідомлення</a></td>
</tr>
<? endwhile; ?>
</tbody>
</table>

<input type="submit" class="btn btn-primary" value="Оновити"/>
</form>
<ul class="pagination"><?=$pagin;?></ul>

<div id="myModal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?=$url?>&b=telegram&c=private_message" method="post" ENCTYPE="multipart/form-data">
		<input type="hidden" name="new[chat_id]" id="chat_id" value=""/>	
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Нове приватне повідомлення</h3>
		</div>
		<div class="modal-body">
			<table class="table table-hover table-bordered table-striped table-condensed">
				
				<tbody class="new">
					<tr>
						<th>Текст повідомлення:</th>
						<td> 
							<textarea class="form-control" name="new[message]"></textarea>
						</td>
					</tr>
			</table>
			<br />
		</div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-primary" value="Надіслати"/>	
		</div>
	</form>
</div>

<div id="myModalAll" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="<?=$url?>&b=telegram&c=message_all" method="post" ENCTYPE="multipart/form-data">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Нове повідомлення для всіх</h3>
		</div>
		<div class="modal-body">
			<table class="table table-hover table-bordered table-striped table-condensed">
				
				<tbody class="new">
					<tr>
						<th>Текст повідомлення:</th>
						<td> 
							<textarea class="form-control" name="new[message]"></textarea>
						</td>
					</tr>
			</table>
			<br />
		</div>
		<div class="modal-footer">
			<input type="submit" class="btn btn-primary" value="Надіслати"/>	
		</div>
	</form>
</div>


<script type="text/javascript">
$(document).ready(function(){
	$(document).on("click", "[data-private]", function(){
        var _chat_id = $(this).attr('data-private');
        $('#chat_id').val(_chat_id);
       	$('#myModal').fadeIn(0);
        return false;
    });
	$(document).on("click", "[data-message-all]", function(){
       	$('#myModalAll').fadeIn(0);
        return false;
    });
	$(document).on("click", ".close", function(){
       	$('#myModal').fadeIn(0);
       	$('.modal').fadeOut(0);
        return false;
    });
});
</script>