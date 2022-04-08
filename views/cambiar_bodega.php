<h2><?php echo $titulo ?></h2>

<h3>Bodega actual:  <?php echo $_SESSION['usuario']['bodega'] ?>
</h3>
<form name="form1" method="post" action="<?php echo base_url() ?>admin/cambiar_bodega">
	<strong>
	<label for="bodegas">Seleccione la bodega:</label>
	<select name="bodegas" id="bodegas">
	<?php foreach($bodegas as $bodega): ?>
		<option value="<?php echo $bodega->id ?>"><?php echo $bodega->nombre ?></option>
	<?php endforeach ?>	
	</select>
	</strong>
	<input type="submit" name="guardar" id="guardar" value="Guardar">
</form>
<p>&nbsp;</p>
</body>
</html>