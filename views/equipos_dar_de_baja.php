<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.cookie.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablefilter.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.pager.js"></script> 
<script type="text/javascript">
$(document).ready
(
	function() 	
	{ 
		$("table tbody td").hover
		(
			function() { $(this).parents('tr').find('td').addClass('highlight'); }, 
			function() { $(this).parents('tr').find('td').removeClass('highlight'); }
		);		
		$("table")
		.tablesorter()
		.tablesorterPager({container: $("#pager")})
		.tableFilter();		
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<div id="notas_container">

	<?php if (empty($notas)): ?>
	No hay solicitudes
	<?php else: ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Cliente</th>
			<th scope="col">Fecha</th>
			<th scope="col">Estado</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($notas as $nota): ?>
		<tr onClick="window.location='<?php echo base_url().$onclick.$nota->id ?>'">
			<td><?php echo $nota->id ?></td>
			<td><?php echo isset($nota->empresa)?  $nota->empresa.', '.$nota->persona : $nota->persona ?></td>
			<td><?php echo $nota->fecha ?></td>
			<td>
				<?php if ($nota->estado == 'P')
					echo 'Pendiente';
				else if ($nota->estado == 'X')
					echo 'Cancelado';
				else if ($nota->estado == 'A')
					echo 'Aceptado';
				?>
			</td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>

</div>

<div id="pager" class="pager">
	<form>
		<img src="<?php echo base_url() ?>recursos/addons/img/first.png" class="first"/>
		<img src="<?php echo base_url() ?>recursos/addons/img/prev.png" class="prev"/>

		<input type="text" class="pagedisplay"/>

		<img src="<?php echo base_url() ?>recursos/addons/img/next.png" class="next"/>
		<img src="<?php echo base_url() ?>recursos/addons/img/last.png" class="last"/>

		<select class="pagesize">
			<option selected="selected"  value="15">15</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="100">100</option>
		</select>
	</form>
</div>

<?php endif ?>

</body>
</html>