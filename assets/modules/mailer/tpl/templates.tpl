<p>
	<a href="<?=$url?>&get=templates&do=add" class="btn btn-success"><span class="icon icon-white icon-plus-sign"></span> Создать шаблон рассылки</a>
</p>

<table class="table table-condensed table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>id</th>
			<th>Название шаблона (тема рассылки)</th>
			<th>Дата создания шаблона</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<? while ($r = $modx->db->getRow($templates)): ?>
			<tr>
				<td><?=$r['template_id']?></td>
				<td><?=$r['template_subject']?></td>
				<td><?=$r['template_date']?></td>
				<td>
					<a href="<?=$url?>&get=templates&do=edit&t=<?=$r['template_id']?>" title="Редактировать" class="btn btn-small btn-success update"><span class="icon icon-white icon-edit"></span> Редактировать</a>
					<a href="<?=$url?>&get=templates&delete=<?=$r['template_id']?>" title="Удалить" class="btn btn-small btn-danger"><span class="icon icon-white icon-remove-sign"></span> Удалить</a>
				</td>
			</tr>
		<? endwhile ?>
	</tbody>

</table>