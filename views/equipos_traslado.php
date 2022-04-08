<h2><?php echo $titulo ?></h2>

<?php if ($permiso): ?>
	<form action="<?php echo base_url() ?>equipos/traslado/<?php echo $traslado_id ?>" method="post">
	<input name="guardar" id="guardar" type="submit" value="Recibidos">
	<input name="traslado_id" id="traslado_id" type="hidden" value="<?php echo $traslado_id ?>">
	</form>
<?php endif ?>

<p><b>Fecha Envío: </b><?php echo $datos->fecha_envio ?></p>
<?php if (isset($datos->fecha_recibido)): ?>
	<p><b>Fecha Recibido: </b><?php echo $datos->fecha_recibido ?></p>
<?php endif ?>	
<p><b>Sede Envío: </b><?php echo $datos->sede_envio ?></p>
<?php echo (isset($datos->fecha_recibido))? '<b>Sede Recibió: </b>' : '<b>Sede por Recibir: </b>'?> <?php echo $datos->sede_recibido ?></p>
<?php if (isset($datos->nota_entrada_almacen_id)): ?>
	<p><b><a href="<?php echo base_url() ?>notas/entrada_equipos/<?php echo $datos->nota_entrada_almacen_id ?>">Ver NEA</a></b></p>
<?php endif ?>
<p><b><a href="<?php echo base_url() ?>notas/salida_equipos/<?php echo $datos->nota_salida_almacen_id ?>">Ver NSA</a></b></p>

<p>&nbsp;</p>
<h3>Equipos:</h3>
<?php echo $equipos ?>

</body>
</html>