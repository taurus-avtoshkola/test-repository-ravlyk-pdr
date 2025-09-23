<style>.chosen-container{min-width:100%!important;}</style>
<form action="<?=$url?>b=payments&c=update" method="post">
	
</br>

	<div class="panel-group" id="accordion2">

	 	<?if($modx->db->getRecordCount($q)>0):?>
		<?while($r = $modx->db->getRow($q)):?>
			<div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
				    <a data-toggle="collapse" data-parent="#accordion" href="#pay_<?=$r['pay_id'];?>">
				    	<?=$r['pay_id']?>. <?=$r['shop_payname'];?>
				    </a>
				  </h4>
				</div>
					<div id="pay_<?=$r['pay_id'];?>" class="panel-collapse collapse">
				  <div class="panel-body">
				    <table class="table table-condensed table-bordered">
				    	<tr>
				    		<th>Назва</th>
				    		<td><input type="text" name="upd[<?=$r['pay_id']?>][shop_payname]" value="<?=$r['shop_payname'];?>" class="form-control"></td>
				    	</tr>
				    	<tr>
				    		<th>Платіжна система</th>
				    		<td>
				    		<select name="upd[<?=$r['pay_id']?>][shop_paysystem]" data-active="<?=$r['shop_paysystem'];?>" class="form-control">
			    					<option value="wayforpay">WayForPay</option>
				    			</select>
				    		</td>
				    	</tr>
				    	<tr>
				    		<th>KEY</th>
				    		<td><input type="text" name="upd[<?=$r['pay_id']?>][shop_paymid]" value="<?=$r['shop_paymid'];?>" class="form-control"></td>
				    	</tr>
				    	<tr>
				    		<th>SECRET</th>
				    		<td><input type="text" name="upd[<?=$r['pay_id']?>][shop_paysig]" value="<?=$r['shop_paysig'];?>" class="form-control"></td>
				    	</tr>
				    	<tr>
				    		<th>PASSWORD</th>
				    		<td><input type="text" name="upd[<?=$r['pay_id']?>][shop_paypass]" value="<?=$r['shop_paypass'];?>" class="form-control"></td>
				    	</tr>
				    </table>
				  </div>
				</div>
			</div>
		<?endwhile;?>
		<?endif?>


			<div class="panel panel-default">
				<div class="panel-heading">
				  <h4 class="panel-title">
				    <a data-toggle="collapse" data-parent="#accordion" href="#pay_new">
				    	Додати нову
				    </a>
				  </h4>
				</div>
					<div id="pay_new" class="panel-collapse collapse">
				  <div class="panel-body">
				    <table class="table table-condensed table-bordered">
				    	<tr>
				    		<th>Назва</th>
				    		<td><input type="text" name="new[shop_payname]" value="" class="form-control"></td>
				    	</tr>
				    	<tr>
				    		<th>Платіжна система</th>
				    		<td>
				    			<select name="new[shop_paysystem]" class="form-control">
			    					<option value="wayforpay" selected>WayForPay</option>
				    			</select>
				    		</td>
				    	</tr>
				    	<tr>
				    		<th>KEY</th>
				    		<td><input type="text" name="new[shop_paymid]" value="" class="form-control"></td>
				    	</tr>
				    	<tr>
				    		<th>SECRET</th>
				    		<td><input type="text" name="new[shop_paysig]" value="" class="form-control"></td>
				    	</tr>
				    	<tr>
				    		<th>PASSWORD</th>
				    		<td><input type="text" name="new[shop_paypass]" value="" class="form-control"></td>
				    	</tr>
				    </table>
				  </div>
				</div>
			</div>


	</div>
	<br>








	<input type="submit" value="<?=$_lang["shop_save_settings"]?>" class="btn btn-lg btn-primary">
</form>