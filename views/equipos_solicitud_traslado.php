<h2><?php echo $titulo ?></h2>

<?php if ($permiso): ?>
<form action="<?php echo base_url() ?>equipos/solicitud_traslado/<?php echo $traslado->id ?>" method="post">
<input name="cancelar" id="cancelar" type="submit" value="Rechazar">
<input name="guardar" id="guardar" type="submit" value="Aceptar">
<input name="traslado_id" id="traslado_id" type="hidden" value="<?php echo $traslado->id ?>">
</form>
<?php endif ?>

<?php if (isset($cancelado)) echo '<p style="color:red"><b>Solicitud Cancelada<b></p>'; ?>

<p><b>Fecha Solicitud: </b><?php echo $traslado->fecha_solicitud ?></p>
<p><b>Sede Solicitud: </b><?php echo $traslado->sede_recibido ?></p>

<p>&nbsp;</p>
<h3>Equipos:</h3>
<?php echo $equipos ?>

</body>
</html>