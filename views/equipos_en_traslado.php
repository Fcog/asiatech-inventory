<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.min.js"></script> 
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
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<?php if (empty($traslados)): ?>
No hay equipos en traslado
<?php else: ?>
<div id="traslados_container">
<table class="tablesorter">
	<thead>
	<tr>
		<th scope="col">Id</th>
		<th scope="col">Fecha Envio</th>
		<th scope="col">Sede Envio</th>
		<th scope="col">Sede por recibir</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($traslados as $traslado): ?>
	<tr onClick="window.location='<?php echo base_url() ?>equipos/traslado/<?php echo $traslado->id ?>'">
		<td><?php echo $traslado->id ?></td>
		<td><?php echo $traslado->fecha_envio ?></td>
		<td><?php echo $traslado->ciudad_envio ?></td>
		<td><?php echo $traslado->ciudad_recibir ?></td>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
</div>
<?php endif ?>
</body>
</html>