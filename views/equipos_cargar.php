<script language="JavaScript" src="<?php echo base_url() ?>recursos/addons/calendar_us2.js"></script> 
<link rel="stylesheet" href="<?php echo base_url() ?>recursos/addons/calendar.css"> 
<script language="JavaScript">
function guardar_id(id)
{
	//Create an input type dynamically.
    var element = document.createElement("input");
 
    //Assign different attributes to the element.
    element.setAttribute("type", "hidden");
    element.setAttribute("value", id);
    element.setAttribute("name", 'cliente_id');
		element.setAttribute("id", 'cliente_id');
 
    var foo = document.getElementById("input_hidden");
 
    //Append the element in page (in span).
    foo.appendChild(element);	
}

function validar()
{
	var cliente       = document.getElementById("cliente_id");
	
	if (!cliente)
	{
		alert("Por favor escoja un cliente");
		return false;
	}
}
</script>

<h2>Cargar equipos al sistema</h2>

<div id="cargar_equipos">
	<?php if ($mensaje != ''): ?>
		<p><?php echo $mensaje ?></p>
	<?php else: ?>
	<p><b>Los equipos se ingresan en la bodega de <?php echo $_SESSION['usuario']['bodega'] ?></b></p>
	<p>&nbsp;</p>
	<form method="post" action="<?php echo base_url() ?>equipos/cargar"  enctype="multipart/form-data" onSubmit="return validar()" >
		<p>
			<span id="equipos_ver_fecha">
				<label for="empresa">Fecha: </label>
				<input name="fecha" id="fecha" type="text">
				<script language="JavaScript"> 
						var fecha = new Date();
						var fecha_format = (fecha.getMonth() < 9 ? '0' : '') + (fecha.getMonth() + 1) + "/"
											+ (fecha.getDate() < 10 ? '0' : '') + fecha.getDate() + "/"
											+ fecha.getFullYear()
						document.getElementById('fecha').value = fecha_format;
					 
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
						
						new tcal ({'controlname': 'fecha','selected' : s_selected,'today' : s_selected}, A_CALTPL);
				</script>
			</span>
			
			<span id="equipos_ver_empresa">
				<label for="empresa">Cliente: </label>
				<input name="buscar" id="buscar" type="text" onKeyUp="xajax_sugestion_clientes(this.value, 390, 238)">
				<span id="sugestion_container"></span>
			</span>
			
			<span id="contactos"></span>
			
		</p>
		<span id="input_hidden"></span>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		
		<input type="file" id="archivo" name="archivo" /> <input type="submit" id="guardar" name="guardar" value="Cargar archivo">
		
	</form>
	<div id="cliente_info"></div>
	
	<p><a href="../recursos/planilla_equipos.xls">Descargar plantilla</a></p>
	
	<?php endif ?>
	
</div>

</body>
</html>