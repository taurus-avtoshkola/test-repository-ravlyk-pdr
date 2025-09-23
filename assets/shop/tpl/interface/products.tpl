<style>
.ord{
	display: inline-block;
	cursor: pointer;
	width: 15px;
	text-align: center;
	color: #428bca;
}
</style>

<table class="table">
	<tr>
		<td>
			<div class="input-group" style="margin-bottom:10px;">
				<span class="addon-input-group" style="margin-right: 30px;">Категорія</span>
			<select name="cat_select" id="cat_select" style="width:250px;" data-active="<?=$_GET['category']?>">
				<option value="0">Усі</option>
				<?foreach ($options as $key => $value):?>
					<option value="<?=$value['id']?>"><?=$value['parent_pagetitle']?> <?=$value['pagetitle']?> (<?=$value['id']?>)</options>
				<?endforeach;?>
			</select>
		</div>
			<div class="input-group">
				<span class="addon-input-group" style="margin-right: 4px;">Відображення </span>
			<select name="moderate_select" id="moderate_select" style="width:250px;" data-active="<?=$_GET['moderate']?>">
				<option value="-1">Усі товари</option>
				<option value="0">Не активні</option>
				<option value="1">Активні</option>
			</select>
		</div>
		</td>



		<td>
			<form action="index.php" method="get" role="form" class="pull-right form-inline">
				<? foreach ($_GET as $k => $v): if ($k != "s"): ?>
				<input type="hidden" name="<?=$k?>" value="<?=$v?>" />
			<? endif; endforeach ?>
			<div class="form-group">
				<input type="text" name="s" id="searching" class="form-control" placeholder="<?=$_lang["shop_search_by"];?>" value="<?=$_GET['s']?>" />
			</div>
			<button class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
		</form>
	</td>

	<td style="width:170px;">

		<a href="<?=$url?>b=items&filter=0" class="btn btn-warning" style="">
			<span class="glyphicon glyphicon glyphicon-off"></span> 
			Скинути фільтри
		</a>
	</td>	
</tr>
</table>
<a href="<?=$url?>b=items&c=add" class="btn btn-success">Додати товар</a>
<table style="width:100%;">
	<tr>
		<td style="width:50%">
			<ul class="pagination"><?=$pagin;?></ul>
		</td>
		<td style="width:50%">
			<div class="pull-right">
				<div class="input-group">

					<label class="label label-primary input-group-addon" style="font-size: 12px;">Виводити по:</label>
					<select style="width:60px;" name="limit" class="lim" data-active="<?=$_GET['limit']?>">
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="500">500</option>
					</select>
				</div>
			</div>
		</td>
	</tr>
</table>


<div class="clear"></div><br>
<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="100px">Артикул <nobr><span class="ord" data-order="ORDER BY p.product_article DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.product_article ASC">&darr;</span></nobr></th>
			<th style="width:150px;">Назва <nobr><span class="ord" data-order="ORDER BY p.product_name DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.product_name ASC">&darr;</span></nobr></th>			
			<th  style="width:120px;">Ціна <nobr><span class="ord" data-order="ORDER BY p.product_price DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.product_price ASC">&darr;</span></nobr></th>
			<th width="70px">Наявність<nobr><span class="ord" data-order="ORDER BY p.product_visible DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.product_visible ASC">&darr;</span></nobr></th>
			<th width="70px">Позиція<nobr><span class="ord" data-order="ORDER BY p.product_position DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.product_position ASC">&darr;</span></nobr></th>

			<th width="100px">Оплата на<nobr><span class="ord" data-order="ORDER BY p.product_paytype DESC">&uarr;</span><span class="ord" data-order="ORDER BY p.product_paytype ASC">&darr;</span></nobr></th>
			
			<th width="260px"></th>
		</tr>
	</thead>
	<tbody>
		<? 
			if ($modx->db->getRecordCount($items) == 0):
		?>
			<tr>
				<th colspan="8" class="text-center"><h4><?=$_lang["shop_on_request"];?> <i><u><?=$_GET['s']?></u></i> <?=$_lang["shop_not_found"];?></h4></th>
			</tr>
		<?
			else: 
			while ($pro = $modx->db->getRow($items)): 
			$i++;
		?>
			<tr>
				<td><?=$pro['product_article']?></td>
				<td>
					<?php
					echo '<img src="'.$modx->runSnippet("R", Array("img" => $pro['product_cover'], "opt" => "w=32&h=32&far=1")).'" class="img-thumbnail" alt="">';					
					?>
					<b><a href="<?=$url?>b=items&c=edit&i=<?=$pro['product_id']?>" ><?=$pro['product_name']?></a></b>
				</td>
				<td  style="width:120px;">					
					<div class="input-group">
					  <input type="text" class="form-control" disabled value="<?=$pro['product_price']?>" data-allow="[^0-9\.?]" placeholder="">					 
					  <span class="input-group-addon">₴</span>
					</div>
				</td>
				<td>
						<?php 						
							switch ($pro['product_visible']) {
								case '0':
									echo '<span class="label label-danger">Не активний</span>';
								break;
								case '1':
									echo '<span class="label label-success">Активний</span>';
								break;
							}
						?>
				</td>
				<td>
					<?=$pro['product_position'];?>
				</td>
				<td>
					<?=$payoptions[$pro['product_paytype']];?>
				</td>
				<td>
					<a href="<?=$url?>b=items&c=edit&i=<?=$pro['product_id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> <?=$_lang["shop_edit"]?> </a>
					<a data-confirm="Ви впевнені, що хочете видалити?" href="<?=$url?>b=items&c=delete&i=<?=$pro['product_id']?>&p=<?=$_GET['p']?>" class="btn btn-mini btn-danger"><span class="glyphicon glyphicon-remove-sign"></span> <?=$_lang["shop_delete"]?> </a>
				</td>
			</tr>
		<? endwhile;endif; ?>		
	</tbody>
</table>
<table style="width:100%;">
	<tr>
		<td style="width:50%">
			<ul class="pagination"><?=$pagin;?></ul>
		</td>
		<td style="width:50%">
			<div class="pull-right">
				<div class="input-group">

					<label class="label label-primary input-group-addon" style="font-size: 12px;">Виводити по:</label>
					<select style="width:60px;" name="limit" class="lim" data-active="<?=$_GET['limit']?>">
						<option value="20">20</option>
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="200">200</option>
						<option value="500">500</option>
					</select>
				</div>
			</div>
		</td>
	</tr>
</table>


<script type="text/javascript">
$(document).ready(function(){
	$("[data-product-amount]").on("blur", function(){
        _this = $(this);
        $.ajax({url:"index.php",data:"a=112&id=6&b=update_amount&pid="+_this.attr("data-product-amount")+"&amount="+_this.val(), success:function(ajax){

        }})
    });
 	$("[data-product-price]").on("blur", function(){
        _this = $(this);
        $.ajax({url:"index.php",data:"a=112&id=6&b=update_price&pid="+_this.attr("data-product-price")+"&price="+_this.val(), success:function(ajax){

        }})
    });


	$("[data-product-sorting]").on("blur", function(){
           _this = $(this);
           $.ajax({url:"index.php",data:"a=112&id=6&b=update_sorting&pid="+_this.attr("data-product-sorting")+"&sorting="+_this.val(), success:function(ajax){

           }})
        });

    $(document).on('change', '#cat_select', function(){

        <? $category = str_replace('&category='.$_GET['category'], '', $p_url); ?>
    	window.location.replace("<?=$category?>&category="+$(this).val());
    });
    $(document).on('change', '#moderate_select', function(){     

        <? $moderate = str_replace('&moderate='.$_GET['moderate'], '', $p_url); ?>
    	window.location.replace("<?=$moderate?>&moderate="+$(this).val());
    });
    $(document).on('click', '.ord', function(){

    	<? $orderby = str_replace('&orderby='.$_GET['orderby'], '', $p_url); ?>
    	window.location.replace("<?=$orderby?>&orderby="+$(this).data('order'));

    });
    $(document).on('change', '.lim', function(){
    	<? $limit = str_replace('&limit='.$_GET['limit'], '', $p_url); ?>
    	window.location.replace("<?=$limit?>&limit="+$(this).val());
        return false;
    });
    $(document).on('keyup','#searching',function(e){
if(e.keyCode == '13'){
$(this).parents('form').submit();
}
    });
});
</script>
