<h2><?php echo $titulo ?></h2>

<div id="equipos_buscar">
<form action="<?php echo base_url() ?>equipos/buscar" method="post">
	<label>Buscar</label>
	<input name="equipo" id="equipo" type="text">
	<label>por</label>
	<select id="tipo" name="tipo">
		<option>Inventario</option>
		<option>Marca</option>
		<option>Modelo</option>
	</select>
	<input name="buscar" id="buscar" type="submit" value="Buscar">
</form>
</div>

<p>&nbsp;</p>
<?php echo $resultado ?>

</body>
</html>