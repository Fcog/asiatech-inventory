
<div id="principal_container">
	
	<h4>Bienvenid@ <?php echo $usuario ?></h4>
	<p>&nbsp;</p>
	<p>&nbsp;</p>

	<?php if (!empty($alquileres)): ?> 
		<p>
			<a href="<?php base_url()?>equipos/alquileres_vigentes" class="lupa">
				Hay <?php echo count($alquileres); echo (count($alquileres) > 1)? ' alquileres vigentes' : ' alquiler vigente' ?> 
			</a>
		</p>
	<?php endif ?>
	
	<?php if (!empty($solicitudes_traslado)): ?> 
		<p>
			<a href="<?php base_url()?>equipos/solicitudes_traslado" class="lupa">
				Tiene <?php echo count($solicitudes_traslado) ?> solicitud<?php if (count($solicitudes_traslado) > 1) echo 'es'?> de traslado de equipos
			</a>
		</p>
	<?php endif ?>
	
	<?php if (!empty($en_traslado)): ?> 
		<p>
			<a href="<?php base_url()?>equipos/en_traslado" class="lupa">
				Hay <?php echo count($en_traslado) ?> envio<?php if (count($en_traslado) > 1) echo 's' ?> de equipos
			</a>
		</p>	
	<?php endif ?>
	
	<?php if (!empty($reparaciones_internas)): ?> 
		<p>
			<a href="<?php base_url()?>equipos/reparaciones_pendientes" class="lupa">
				Hay <?php echo count($reparaciones_internas) ?> 
				<?php echo (count($reparaciones_internas) > 1)? 'reparaciones internas pendientes' : 'reparacion interna pendiente' ?> 
			</a>
		</p>	
	<?php endif ?>
	
	<?php if (!empty($reparaciones_externas) || !empty($reparaciones_externas2)): ?> 
		<p>
			<a href="<?php base_url()?>equipos/reparaciones_pendientes" class="lupa">
				Hay <?php echo count($reparaciones_externas)+count($reparaciones_externas2) ?> 
				<?php echo (count($reparaciones_externas)+count($reparaciones_externas2) > 1)? 'reparaciones externas pendientes' : 'reparacion externa pendiente' ?> 
			</a>
		</p>	
	<?php endif ?>

	<?php if (isset($dar_de_baja) && !empty($dar_de_baja)): ?> 
		<p>
			<a href="<?php base_url()?>admin/dar_de_baja_equipos" class="lupa">
				Hay <?php echo count($dar_de_baja) ?> solicitud<?php if (count($dar_de_baja) > 1) echo 'es' ?> para dar de baja equipos
			</a>
		</p>	
	<?php endif ?>		
	
</div>

</body>
</html>