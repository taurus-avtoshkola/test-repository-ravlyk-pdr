<form action="<?=$url?>b=filters&d=update" method="post">
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#filter" data-toggle="tab"><b>Фільтр</b></a></li>
		<li><a href="#sort" data-toggle="tab"><b>Значення фільтру</b></a></li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane fade in active" id="filter">

			<h3 class="muted">Редагувати фільтр</h3>
			<table class="table table-bordered" id="f_param">
				<tr style="height: 50px;">
					<th width="200px">Назва UA</th>
					<td><input type="text" name="filter[filter_name_ua]" class="form-control" value="<?=$filter['filter_name_ua']?>"></td>
				</tr>

				<tr style="height: 50px;">
					<th width="200px">URL</th>
					<td><input type="text" name="filter[filter_slug]" class="form-control" value="<?=$filter['filter_slug']?>"></td>
				</tr>


				<tr style="height: 50px;">
					<th width="200px">Опис</th>
					<td><textarea name="filter[desc]" id="description" class="form-control"><?=$filter['filter_desc']?></textarea></td>
				</tr>
			</table>
		</div>
		<div class="tab-pane" id="sort">
			<h3 class="muted"><?=$_lang["shop_filter_edit"]?></h2>
			<table class="table table-bordered" id="f_param">
				<tr>
					<table class="table table-condensed table-striped table-bordered table-hover">
						<thead>
							<tr>
								<td>Сортування</td>
								<td>Значення UA</td>
								<td>URL</td>
								<td></td>
							</tr>
						</thead>
						<tbody>
						<? while($value = $modx->db->getRow($values)):?>
							<tr>
								<td><input type="text" class="form-control" value="<?=$value['sort_ind']?>" name="sort[<?=$value['value_id']?>]"></td>
								<td><input type="text" class="form-control" name="val_ua[<?=$value['value_id']?>]" value="<?=$value['val_ua']?>"></td>
								<td><input type="text" class="form-control" name="slug[<?=$value['value_id']?>]" value="<?=$value['slug']?>"></td>
								<td><a href="<?=$url?>b=filters&filter_id=<?=$_REQUEST['edit']?>&d=delete_value&i=<?=$value['value_id']?>" class="btn btn-danger">Видалити</a></td>
							</tr>
						<? endwhile ?>
						</tbody>
					</table>
				</tr>
			</table>
		</div>
	</div>
	<input type="hidden" name="filter[id]" value="<?=$filter['filter_id']?>">
	<input type="submit" value="Оновити" class="btn btn-primary">
</form>