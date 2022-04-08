<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript">
$(document).ready
(
	function() 	
	{ 
		$("#table tbody td").hover
		(
			function() { $(this).parents('tr').find('td').addClass('highlight'); }, 
			function() { $(this).parents('tr').find('td').removeClass('highlight'); }
		);		
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<h3>Reparaciones:</h3>
<?php if (empty($reparaciones)): ?>
	Este equipo no ha tenido reparaciones
<?php else: ?>	
	<?php foreach($reparaciones as $dato): ?>
		<p><a href="<?php echo base_url().'equipos/reparacion/'.$dato->id ?>"><b>Reparacion No: </b><?php echo $dato->id ?></a>
		<b> - Fecha: </b><?php echo $dato->fecha_solicitud ?> </p>
		<p><b>Problema: </b><?php echo $dato->problema ?><b> - Solucion: </b><?php echo $dato->solucion ?></p>
		<p><?php echo $equipos->dibujar_equipos('e.id='.$dato->equipos_history_id, 'sin bodega',array('history','observacion'))  ?></p>
	<?php endforeach ?>
<?php endif ?>
			
<h3>Alquileres:</h3>
<?php if (empty($alquileres)): ?>
	Este equipo no ha tenido alquileres
<?php else: ?>	
	<?php foreach($alquileres as $dato): ?>
		<p><a href="<?php echo base_url().'equipos/alquiler/'.$dato->id ?>"><b>Alquiler No: </b><?php echo $dato->id ?></a>
	<?php endforeach ?>
<?php endif ?>
			
<p>&nbsp; </p>
<h3>Notas de entrada del equipo:</h3>

	<?php if (empty($nea)): ?>
	No hay notas de entrada de equipos registradas para este equipo
	<?php else: ?>
	<table class="tablesorter" id="table">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Fecha</th>
			<th scope="col">Descripción</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($nea as $nota): ?>
		<tr onClick="window.location='<?php echo base_url().'notas/entrada_equipos/'.$nota->id ?>'">
			<td><?php echo $nota->id ?></td>
			<td><?php echo $nota->fecha ?></td>
			<td><?php echo $nota->descripcion ?></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>


<h3>Notas de salida del equipo:</h3>

	<?php if (empty($nsa)): ?>
	No hay notas de salida de equipos registradas para este equipo
	<?php else: ?>
	<table class="tablesorter" id="table">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Fecha</th>
			<th scope="col">Descripción</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($nsa as $nota): ?>
		<tr onClick="window.location='<?php echo base_url().'notas/salida_equipos/'.$nota->id ?>'">
			<td><?php echo $nota->id ?></td>
			<td><?php echo $nota->fecha ?></td>
			<td><?php echo $nota->descripcion ?></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>

</body>
</html>