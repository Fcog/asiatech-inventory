<script language="JavaScript" src="<?php echo base_url() ?>recursos/addons/calendar_us2.js"></script> 
<link rel="stylesheet" href="<?php echo base_url() ?>recursos/addons/calendar.css"> 
							
<h2><?php echo $titulo ?></h2>

<div id="nota_container">
	<div id="datos">
			<p><label>Alquiler N° <?php echo $alquiler->id ?></label></p>
			<p><label>Fecha Inicial: </label><?php echo $alquiler->fecha_inicial ?></p>
			<p><label>Fecha Final: </label><?php echo $alquiler->fecha_final ?></p>
			<p><label>Cliente: </label><?php echo isset($alquiler->empresa)?  $alquiler->empresa : $alquiler->persona ?></p>
			<p><label>NIT: </label><?php echo isset($alquiler->empresa)? $alquiler->nit : $alquiler->cedula ?></p>
			<p><label>Direccion: </label><?php echo isset($alquiler->empresa)? $alquiler->direccion_empresa : $alquiler->direccion_persona ?></p>
			<p><?php if ($alquiler->telefono != ''): ?><label>Telefono: </label><?php echo $alquiler->telefono ?><?php endif ?></p>
			<p><label>Ubicacion equipos: </label><?php echo $alquiler->ubicacion ?></label></p>
	</div>
	
	<h3>&nbsp;</h3>
	<h3>Historial</h3>
	
	<p><a href="<?php echo base_url() ?>notas/salida_equipos/<?php echo $alquiler->nota_salida_almacen_id ?>">Ver Remision</a></p>
	<p><a href="<?php echo base_url() ?>notas/entrada_equipos/<?php echo $alquiler->nota_entrada_almacen_id ?>">Ver Finiquito</a></p>
	
	<?php foreach($cambios as $cambio): ?>
		<p>
			<label>Cambio de Equipos: </label>
			<?php if ($cambio->nota_entrada_almacen_id != ''): ?>
			<a href="<?php echo base_url() ?>notas/entrada_equipos/<?php echo $cambio->nota_entrada_almacen_id ?>">Ver NEA</a>
			<?php endif ?>
			<?php if ($cambio->nota_entrada_almacen_id != '' && $cambio->nota_salida_almacen_id != ''): ?> - <?php endif ?>
			<?php if ($cambio->nota_salida_almacen_id != ''): ?>
			<a href="<?php echo base_url() ?>notas/salida_equipos/<?php echo $cambio->nota_salida_almacen_id ?>">Ver NSA</a>
			<?php endif ?>
		</p>
	<?php endforeach ?>
	
	<?php foreach($cambios2 as $cambio): ?>
		<p><label>Fecha final: </label><?php echo $cambio->fecha_final ?></p>
	<?php endforeach ?>
	
</div>


</body>
</html>