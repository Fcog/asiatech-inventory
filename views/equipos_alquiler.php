<script language="JavaScript" src="<?php echo base_url() ?>recursos/addons/calendar_us2.js"></script> 
<link rel="stylesheet" href="<?php echo base_url() ?>recursos/addons/calendar.css"> 
							
<h2><?php echo $titulo ?></h2>

<form action="<?php echo base_url() ?>equipos/alquiler/<?php echo $alquiler->id ?>" method="post">

	<div id="alquiler_botones">
		<input type="button" name="historial" id="historial" value="Ver Historial"
		onClick="window.location='<?php echo base_url() ?>equipos/alquiler_historial/<?php echo $alquiler->id ?>'">
		
		<?php if ($permiso): ?>
		<input name="cambios" id="cambios" type="button" value="Cambiar Equipos" 
		onClick="window.location='<?php echo base_url() ?>equipos/alquiler_cambios/<?php echo $alquiler->id ?>'">
		<input name="mostrar_fecha" id="mostrar_fecha" type="button" value="Prorrogar Alquiler" onClick="xajax_mostrar_fecha()">
		<input name="terminar" id="terminar" type="submit" value="Terminar Alquiler">
		<?php endif ?>
	</div>
	

	<div id="nota_container">
		<div id="datos">
			<p><label>Alquiler N° <?php echo $alquiler->id ?></label></p>
			<p><label>Fecha Inicial: </label><?php echo $alquiler->fecha_inicial ?></p>
			<p><label>Fecha Final: </label><span id="span_fecha"><?php echo $alquiler->fecha_final ?></span>
				<span id="mostrar_calendario">
					<script language="JavaScript"> 
						var fecha = new Date();
						var fecha_format = (fecha.getMonth() < 9 ? '0' : '') + (fecha.getMonth() + 1) + "/"
											+ (fecha.getDate() < 10 ? '0' : '') + fecha.getDate() + "/"
											+ fecha.getFullYear()
						//document.getElementById('fecha_final').value = fecha_format;
					 
						// sample of date calculations:
						// - set selected day to 3 days from now
						var d_selected = new Date();
						d_selected.setDate(d_selected.getDate());
						var s_selected = f_tcalGenerDate(d_selected);
					 
						// whole calendar template can be redefined per individual calendar
						var A_CALTPL = {
							'months' : ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							'weekdays' : ['do', 'lu', 'ma', 'mi', 'ju', 'vi', 'sa'],
							'yearscroll': true,
							'weekstart': 0,
							'centyear'  : 70,
							'imgpath' : '<?php echo base_url() ?>recursos/addons/img/'
						}
										
						new tcal ({'controlname': 'fecha_final','selected' : s_selected,'today' : s_selected}, A_CALTPL); 
					</script>
					<span id="mostrar_botones"></span>
				</span>
			</p>
			<p><label>Cliente: </label><?php echo isset($alquiler->empresa)?  $alquiler->empresa : $alquiler->persona ?></p>
			<p><?php echo isset($alquiler->empresa)? '<b>NIT: </b>'.$alquiler->nit : 'CC. '.$alquiler->cedula ?></p>
			<p><label>Direccion: </label><?php echo isset($alquiler->empresa)? $alquiler->direccion_empresa : $alquiler->direccion_persona ?></p>
			<p><?php if ($alquiler->telefono != ''): ?><label>Telefono: </label><?php echo $alquiler->telefono ?><?php endif ?></p>
			<?php if (isset($alquiler->empresa))
			{ 
				echo '<b>Contacto: </b>'.$alquiler->persona;
				echo ' <b>Tel: </b>'.$alquiler->telefono;
				echo ' <b>Email: </b>'.$alquiler->email;
				echo ' <b>Area: </b>'.$alquiler->area;
				echo ' <b>Cargo: </b>'.$alquiler->cargo;
			}
			 ?>
			<p><label>Ubicacion equipos: </label><?php echo $alquiler->ubicacion ?></label></p>

		<p><a href="<?php echo base_url() ?>notas/salida_equipos/<?php echo $alquiler->nota_salida_almacen_id ?>">Ver Remision</a></p>			
		</div>

		<p>&nbsp;</p>
		<h3>Equipos: </h3>
		<?php echo $equipos ?>
	</div>
</form>

</body>
</html>