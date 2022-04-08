<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.cookie.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablefilter.js"></script> 
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
		.tableFilter();		
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<div id="reparaciones_container">

	<h3>Reparaciones internas </h3>
	
	<p>
		<?php if (empty($reparaciones_internas)): ?>
	No hay <?php echo $titulo ?>
	<?php else: ?>
	</p>
	
	<table class="tablesorter">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Fecha Solicitud</th>
			<?php if (permiso('superadmin')): ?> <th scope="col">Sede Asiatech</th> <?php endif ?>
			<th scope="col">Equipo Inventario</th>
			<th scope="col">Tipo de Equipo</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($reparaciones_internas as $reparacion): ?>
		<tr onClick="window.location='<?php echo base_url().'equipos/reparacion/'.$reparacion->id ?>'">
			<td><?php echo $reparacion->id ?></td>
			<td><?php echo $reparacion->fecha_solicitud ?></td>
			<?php if (permiso('superadmin')): ?> <td><?php echo $reparacion->sede ?></td>  <?php endif ?>
			<td><?php echo $reparacion->inventario ?></td>
			<td><?php echo $reparacion->tipo ?></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<p>
		<?php endif ?>
		
	<h3>Reparaciones externas</h3>	
				
		<?php if (empty($reparaciones_externas) && empty($reparaciones_externas2)): ?>
			No hay <?php echo $titulo ?>
		<?php else: ?>
		</p>
			
			<?php if (!empty($reparaciones_externas)): ?>
			 <?php if ($titulo == 'Reparaciones Pendientes'): ?> <h4>Reparaciones pendientes de cliente</h4> <?php endif ?>
				<table class="tablesorter">
					<thead>
					<tr>
						<th scope="col">No</th>
						<th scope="col">Fecha</th>
						<?php if (permiso('superadmin')): ?> <th scope="col">Sede Asiatech</th> <?php endif ?>
						<th scope="col">Cliente</th>					
					</tr>
					</thead>
					<tbody>
					<?php foreach ($reparaciones_externas as $reparacion): ?>
					<tr onClick="window.location='<?php echo base_url().'equipos/reparacion_externa/'.$reparacion->id ?>'">
						<td><?php echo $reparacion->id ?></td>
						<td><?php echo $reparacion->fecha_inicial ?></td>
						<?php if (permiso('superadmin')): ?> <td><?php echo $reparacion->sede ?></td> <?php endif ?>
						<td><?php echo isset($reparacion->empresa)? $reparacion->empresa : $reparacion->persona ?></td>
					</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>	

			<?php if (!empty($reparaciones_externas2)): ?>

			</p>
			<h4>Reparaciones pendientes por actualizar datos</h4> 
			
			<table class="tablesorter">
				<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">Fecha</th>
					<?php if (permiso('superadmin')): ?> <th scope="col">Sede Asiatech</th> <?php endif ?>
					<th scope="col">Cliente</th>	
					<th scope="col">Equipo Inventario</th>
					<th scope="col">Tipo de Equipo</th>						
				</tr>
				</thead>
				<tbody>
				<?php foreach ($reparaciones_externas2 as $reparacion): ?>
				<tr onClick="window.location='<?php echo base_url().'equipos/reparacion/'.$reparacion->id ?>'">
					<td><?php echo $reparacion->id ?></td>
					<td><?php echo $reparacion->fecha_solicitud ?></td>
					<?php if (permiso('superadmin')): ?> <td><?php echo $reparacion->sede ?></td> <?php endif ?>
					<td><?php echo isset($reparacion->empresa)? $reparacion->empresa : $reparacion->persona ?></td>		
					<td><?php echo $reparacion->inventario ?></td>
					<td><?php echo $reparacion->tipo ?></td>							
				</tr>
				<?php endforeach ?>
				</tbody>
			</table>	
			<?php endif ?>
			
	<?php endif ?>
	
</div>

</body>
</html>