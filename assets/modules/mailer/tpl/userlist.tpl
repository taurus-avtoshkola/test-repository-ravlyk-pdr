<p>
	<a href="<?=$url?>&get=userlist&i=import" class="btn btn-success"><span class="icon icon-white icon-repeat"></span> Импортировать из списка веб-пользователей</a>

	<a href="#myModal" class="btn btn-primary" href="#myModal" role="button" data-toggle="modal"><span class="icon icon-white icon-plus"></span> Добавить E-mail в список рассылки</a>
	<a href="#" class="btn btn-info" id="save"><span class="icon icon-white icon-edit"></span> Сохранить изменения</a>
</p>
<form action="<?=$url?>&get=red" method="post">
<table class="table table-bordered table-striped table-hover table-condensed">
	<thead>
		<tr>
			<th>ID</th>
			<th>Имя</th>
			<th>Email</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? while($u = $modx->db->getRow($users)): ?>
		<tr>
			<td><?=$u['user_id']?></td>
			<td><input type="text" name="red[<?=$u['user_id']?>][user_name]" value="<?=$u['user_name']?>"></input></td>
			<td><input type="text" name="red[<?=$u['user_id']?>][user_email]" value="<?=$u['user_email']?>"></input></td>
			<td>
				<a href="<?=$url?>&get=userlist&d=<?=$u['user_id']?>" class="btn btn-mini btn-danger"><span class="icon icon-white icon-remove"></span> Удалить из рассылки</a>
			</td>
		</tr>
		<? endwhile ?>
	</tbody>
</table>
</form>

<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?=$url?>&get=add_email" method="post" ENCTYPE="multipart/form-data">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Добавить E-mail в список рассылки</h3>
    </div>
    <div class="modal-body">
      <table class="table table-hover table-bordered table-striped table-condensed">
      <?=$table['email']?>

      </table>
      <br />

    </div>
    <div class="modal-footer">
      <input type="submit" class="btn btn-primary" value="Добавить">
    </div>
  </form>
</div>
<div id="myModal1" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?=$url?>&get=red_user" method="post" ENCTYPE="multipart/form-data">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h3>Редактировать пользователя</h3>
    </div>
    <div class="modal-body">
      <table class="table table-hover table-bordered table-striped table-condensed">
      <?=$table['email']?>

      </table>
      <br />

    </div>
    <div class="modal-footer">
      <input type="submit" class="btn btn-primary" value="Добавить">
    </div>
  </form>
</div>