<a href="<?=$url?>&b=filters&d=add" class="btn btn-success"><span class="glyphicon glyphicon-plus-sign"></span> Додати фільтр</a>
<br>
<table class="table table-bordered table-striped table-condensed table-hover">
    <thead>
        <tr>
            <th>Сортування</th>
            <th>Назва</th>
            <th width="270px"></th>
        </tr>
    </thead>
    <tbody>
        <? foreach($filters as $f): ?>
            <tr>
                <td width="100px" style="text-align:center;"><?=$f['filter_sort']?><input type="hidden" name="sorting[<?=$f['filter_id']?>]" class="form-control sort_pos" value="<?=$f['filter_sort']?>"></td>
                <td> 
                    <i><?=$f['filter_name']?></i> 
                    <? if ($f['filter_desc'] != ""): ?>
                        <div class="icon icon-question-sign text-muted" title="<?=$f['filter_desc']?>"></div>
                    <? endif ?>
                </td>
                <td>
                    <a href="<?=$url?>b=filters&d=edit&edit=<?=$f['filter_id']?>" class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати</a>
                    <a href="<?=$url?>b=filters&d=delete&delete=<?=$f['filter_id']?>" onclick="return confirm('Ви точно хочете видалити фільтр?')" class="btn btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Видалити</a>
                </td>
            </tr>
        <? endforeach; ?>
    </tbody>
</table>