<?php if (!isset($mostrar_botones)): ?>
	<h2><?php echo $titulo ?></h2>
	
	<form action="<?php echo base_url().'notas/salida_equipos/'.$nota_datos->id ?>" method="post">
	<input type="submit" id="imprimir" name="imprimir" value="Imprimir">
	</form>
<?php else: ?>
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url() ?>recursos/css/estilo.css">
<?php endif ?>

<div id="nota_container">
	<div id="encabezado">
	  <div id="numero"><p>N° <?php echo $nota_datos->id ?></p><p><?php echo $nota_datos->fecha ?></p></div>
		<div id="datos">
			<p><?php echo $cliente ?></p>
			<p><?php echo isset($nota_datos->empresa)? 'NIT '.$nota_datos->nit : isset($nota_datos->cedula)? 'C.C. '.$nota_datos->cedula : '' ?></p>
			<p><?php echo ($nota_datos->direccion != '')? $nota_datos->direccion : $nota_datos->direccion_persona ?></p>
			<p><?php if ($nota_datos->telefono != '') echo 'Tel: '.$nota_datos->telefono ?></p>
			<p><?php echo $nota_datos->otra_info ?></p>
		</div>
	</div>
	<div id="equipos"><?php echo $nota_equipos ?></div>
</div>

</body>
</html>