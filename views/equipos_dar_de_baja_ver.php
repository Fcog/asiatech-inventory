<h2><?php echo $titulo ?></h2>

<?php if (isset($botones)): ?>
<form method="post" action="<?php echo base_url() ?>admin/dar_de_baja_equipos2/<?php echo $nota_datos->id ?>">
<input type="hidden" name="salida_id" id="salida_id" value="<?php echo $nota_datos->id ?>">
<input name="cancelar" id="cancelar" type="submit" value="Cancelar">
<input name="guardar" id="guardar" type="submit" value="Confirmar">
</form>
<?php endif ?>

<p>
	<?php if (isset($cancelado)) echo '<p style="color:red"><b>Solicitud Cancelada<b></p>'; ?>
	<?php if (isset($aceptado)) echo '<p style="color:darkgreen"><b>Solicitud Aceptada<b></p>'; ?>
</p>
<p><b>Fecha Solicitud: </b><?php echo $nota_datos->fecha ?></p>

<p>&nbsp;</p>
<h3>Equipos: </h3>
<div id="equipos"><?php echo $nota_equipos ?></div>

</body>
</html>