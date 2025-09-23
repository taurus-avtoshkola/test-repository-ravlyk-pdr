</br>
<h2>Питання:</h2>

<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">ID</th>
			<th>Назва</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php
$q = $modx->db->query('SELECT * FROM `new_question` WHERE 1 = 1 ');
while($r = $modx->db->getRow($q)){
  $answers = json_decode($r['answers'],true);
  foreach($answers as $k => $v){
    $pos = mb_strpos($v['description'],'Відповіді');
    if($pos !== false){
?>


			<tr>				
				<td><?=$r['id']?></td>
				<td><?=$r['question']?></td>
				<td>
					<a href="<?=$url?>b=test&c=edit_question&question=<?=$r['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Редагувати </a>
				</td>
			</tr>	
	



      <?php
    }
  }
}
?>
</tbody>
</table>

