<h2><?php echo $titulo ?></h2>

<div id="modificar_equipo_container">

<p><label>Problema: </label><?php echo $reparacion->problema ?></p>

<form method="post" action="<?php echo base_url() ?>equipos/reparacion/<?php echo $reparacion->id ?>">
<table class="tablesorter">
	<tr>
		<th colspan="2" scope="col">&nbsp;</th>
	</tr>
	<tr>
		<td>Inventario</td>
		<td><?php echo $equipo->inventario ?></td>
	</tr>
	<tr>
		<td>Serial</td>
		<td><?php echo $equipo->serial ?></td>
	</tr>
	<tr>
		<td>Marca</td>
		<td><?php echo $equipo->marca ?></td>
	</tr>
	<tr>
		<td>Modelo</td>
		<td><?php echo $equipo->modelo ?></td>
	</tr>
	<tr>
		<td>CPU</td>
		<td><?php echo $equipo->cpu ?></td>
	</tr>
	<tr>
		<td>Memoria</td>
		<td><input type="text" name="memoria" id="memoria" value="<?php echo $equipo->memoria ?>"></td>
	</tr>
	<tr>
		<td>Memoria Inventario</td>
		<td><input type="text" name="memoria_inv" id="memoria_inv" value="<?php echo $equipo->memoria_inv ?>"></td>
	</tr>
	<tr>
		<td>Memoria Serial</td>
		<td><input type="text" name="memoria_serial" id="memoria_serial" value="<?php echo $equipo->memoria_serial ?>"></td>
	</tr>
	<tr>
		<td>Disco Duro</td>
		<td><input type="text" name="disco_duro" id="disco_duro" value="<?php echo $equipo->disco_duro ?>"></td>
	</tr>
	<tr>
		<td>Disco Duro Inventario</td>
		<td><input type="text" name="disco_duro_inv" id="disco_duro_inv" value="<?php echo $equipo->disco_duro_inv ?>"></td>
	</tr>
	<tr>
		<td>Disco Duro Serial</td>
		<td><input type="text" name="disco_duro_serial" id="disco_duro_serial" value="<?php echo $equipo->disco_duro_serial ?>"></td>
	</tr>
	<tr>
		<td>Unidad Optica</td>
		<td><input type="text" name="unidad_optica" id="unidad_optica" value="<?php echo $equipo->unidad_optica ?>"></td>
	</tr>
	<tr>
		<td>Unidad Optica Inventario</td>
		<td><input type="text" name="unidad_optica_inv" id="unidad_optica_inv" value="<?php echo $equipo->unidad_optica_inv ?>"></td>
	</tr>
	<tr>
		<td>Unidad Optica Serial</td>
		<td><input type="text" name="unidad_optica_serial" id="unidad_optica_serial" value="<?php echo $equipo->unidad_optica_serial ?>"></td>
	</tr>
	<tr>
		<td>Bateria Inventario</td>
		<td><input type="text" name="bateria_inv" id="bateria_inv" value="<?php echo $equipo->bateria_inv ?>"></td>
	</tr>
	<tr>
		<td>Wireless</td>
		<td><input type="checkbox" name="wireless" id="wireless" <?php if ($equipo->wireless == 1) echo 'checked' ?> />
			<label for="wireless"></label></td>
	</tr>
	<tr>
		<td>Webcam</td>
		<td><input type="checkbox" name="webcam" id="webcam" <?php if ($equipo->webcam == 1) echo 'checked' ?> />
			<label for="webcam"></label></td>
	</tr>
	<tr>
		<td>Observacion</td>
		<td><input type="text" name="observacion" id="observacion" value="<?php echo $equipo->observacion ?>"></td>
	</tr>		
</table>

<p><textarea name="reparacion" id="reparacion" placeholder="Describa los cambios hechos al equipo"></textarea></p>
<input type="button" name="cancelar" id="cancelar" value="Cancelar" 
onclick="window.location='<?php echo base_url() ?>equipos/reparaciones_pendientes/'">
<input type="submit" name="guardar" id="guardar" value="Reparar">

</form>

</div>
</body>
</html>