<h2><?php echo $titulo ?></h2>

<div id="alquiler_historial_container">

	<?php if (empty($cambios2)): ?>
	Este alquiler no tiene historial de cambio de fecha
	<?php else: ?>
	
	<h3>Fechas:</h3>
		<table class="tablesorter">
			<tr>
				<th scope="col">Fecha Incial</th>
				<th scope="col">Fecha Final</th>
			</tr>
			<?php foreach($cambios2 as $cambio): ?>
			<tr>
				<td><?php echo $cambio->fecha_inicial ?></td>
				<td><?php echo $cambio->fecha_final ?></td>
			</tr>
			<?php endforeach ?>
		</table>
	
	<?php endif ?>

	<?php if (empty($cambios)): ?>
	Este alquiler no tiene historial de cambio de equipos
	<?php else: ?>
	<h3>Cambios de Equipos:</h3>
		<table class="tablesorter">
			<tr>
				<th scope="col">Fecha</th>
				<th scope="col">Descripcion</th>
			</tr>
			<?php foreach($cambios as $cambio): ?>
			<tr>
				<td><?php echo $cambio->fecha ?></td>
				<td>
						<?php if ($cambio->nota_entrada_almacen_id != ''): ?>
						<a href="<?php echo base_url() ?>notas/entrada_equipos/<?php echo $cambio->nota_entrada_almacen_id ?>">Ver NEA</a>
						<?php endif ?>
						<?php if ($cambio->nota_entrada_almacen_id != '' && $cambio->nota_salida_almacen_id != ''): ?> - <?php endif ?>
						<?php if ($cambio->nota_salida_almacen_id != ''): ?>
						<a href="<?php echo base_url() ?>notas/salida_equipos/<?php echo $cambio->nota_salida_almacen_id ?>">Ver NSA</a>
						<?php endif ?>
				</td>
			</tr>
			<?php endforeach ?>
		</table>
	
	<?php endif ?>

</div>

</body>
</html>