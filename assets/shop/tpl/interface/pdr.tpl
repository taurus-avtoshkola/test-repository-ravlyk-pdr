</br>
<p></p>

<table class="table table-condensed table-striped table-bordered table-hover">
	<thead>
		<tr>
			<th width="50px">ID</th>
			<th>Назва</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?						
			while ($r2 = $modx->db->getRow($q2)): 
		?>
			<tr>				
				<td><?=$r2['id']?></td>
				<td><?=$r2['name']?></td>
				<td>
					<a href="<?=$url?>b=pdr&c=chapter&i=<?=$r2['id']?>" class="btn btn-mini btn-primary"><span class="glyphicon glyphicon-edit"></span> Детальніше </a>
				</td>
			</tr>
		<? endwhile;?>		
	</tbody>
</table>
