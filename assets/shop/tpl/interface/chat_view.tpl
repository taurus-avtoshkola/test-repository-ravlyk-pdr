<div class="chat_history">

	<?while($r = $modx->db->getRow($history)):?>

	<?php if($r['type'] == '0'){?>
	<p><b>Користувач:</b> <?=$r['message']?>  <?php if($r['question_id'] != '0'){ echo "Питання <b style='color:red;'>".$r['question_id']."</b>";}?></p>
	<?php }else{?>
	<p><b>CHAT GPT:</b> <?=$r['message']?></p>
<?php }?>

<?endwhile?>
</div>
