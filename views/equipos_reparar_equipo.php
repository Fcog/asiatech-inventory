<h2><?php echo $titulo ?></h2>

<div id="modificar_equipo_container2">
<p><label>Problema: </label><?php echo $reparacion->problema ?></p>
<br>
<p><?php echo $equipo ?></p>
<br>
<form method="post" action="<?php echo base_url() ?>equipos/reparacion/<?php echo $reparacion->id ?>">
	
<p><textarea id="reparacion" name="reparacion" placeholder="Describa los cambios hechos al equipo"></textarea></p>
<br>
<input type="button" name="cancelar" id="cancelar" value="Cancelar" 
onclick="window.location='<?php echo base_url() ?>equipos/reparaciones_pendientes/'">
<input type="submit" name="guardar" id="guardar" value="Reparar">

</form>
</div>
</body>
</html>