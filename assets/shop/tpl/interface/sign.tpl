</br>

<a href="<?=$url?>b=sign&c=add" class="btn btn-success">Додати</a>
<p></p>
	</br>
<div class="masthead">
    <ul class="nav nav-justified">
		<? while ($sign = $modx->db->getRow($signs)): ?>
		    <li><a href="#" data-id="<?=$sign['id']?>"><img src="<?=$sign['icon']?>" style="width:30px;"/> <span><?=$sign['name']?></span></a></li>	
		<? endwhile;?>	
    </ul>
</div>
		<div class="tabs">

		<? while ($sign = $modx->db->getRow($signs2)): ?>
			<div class="tab" data-tab="<?=$sign['id']?>">
				<div class="block_a">
					<h3><img src="<?=$sign['icon']?>" style="width:50px;"/> <?=$sign['name']?></h3>

					<div class="content_d">
						<?=$sign['intro'];?>
					</div>
					
				</div>

				<table class="table table-condensed table-striped table-bordered table-hover" style="margin-top: 20px;">
					<thead>
						<tr>
							<th width="50px">ID</th>
							<th width="160px">Номер</th>
							<th width="160px">Назва</th>
							<th width="110px">Фото</th>
							<th width="260px"></th>
						</tr>
					</thead>
					<tbody>
						<?
							$q2 = $modx->db->query('SELECT * FROM `new_pdr_road_sign_item` WHERE type = "'.$modx->db->escape($sign['id']).'" ORDER BY id ASC ');
							while ($r2 = $modx->db->getRow($q2)): 
						?>
							<tr>				
								<td><?=$r2['id']?></td>
								<td><?=$r2['number']?></td>
								<td><?=$r2['name']?></td>
								<td><img src="<?=$r2['image_new']?>" style="max-width:100px;"/></td>
								<td>
									<a href="<?=$url?>b=sign&c=edit&i=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
									<a data-confirm="Точно видалити?" href="<?=$url?>b=sign&c=delete&i=<?=$r2['id']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> Видалити </a>
								</td>
							</tr>
						<? endwhile;?>		
					</tbody>
				</table>
			</div>
		<? endwhile;?>	



<style type="text/css">
	.tab{
		display: none;
	}
	.tab.active{
		display: block;
	}
</style>
<script>
 $(document).ready(function(){
 	$(document).on('click','[data-id]',function(){
 		$('[data-id]').parent().removeClass('active');
 		$('[data-tab]').removeClass('active');
 		$(this).parent().addClass('active');
 		$('[data-tab="'+$(this).attr('data-id')+'"]').addClass('active');
 		return false;
 	});
 });
</script>