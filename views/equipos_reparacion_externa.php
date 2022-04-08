<h2><?php echo $titulo ?></h2>

<?php if (isset($boton)): ?>
	<form action="" method="post">
	<input name="guardar" id="guardar" type="submit" value="Recibir Equipos">
	</form>
<?php endif ?>

<br>
<p><label>Fecha: </label><?php echo $reparacion->fecha_inicial ?></p>
<?php if (!isset($boton)): ?>
<p><label>Fecha Recibido: </label><?php echo $reparacion->fecha_final ?></p>
<?php endif ?>
<p><label>Cliente: </label><?php echo ($reparacion->empresa)? $reparacion->empresa : $reparacion->persona ?></p>

<h3>&nbsp;</h3>
<h3>Equipos:</h3>
<?php echo $equipos ?>

</body>
</html>