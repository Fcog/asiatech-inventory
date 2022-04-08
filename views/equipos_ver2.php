<script language="JavaScript" src="<?php echo base_url() ?>recursos/addons/calendar_us2.js"></script> 
<link rel="stylesheet" href="<?php echo base_url() ?>recursos/addons/calendar.css"> 
<script type="text/javascript">
function guardar_id(id)
{
	//Create an input type dynamically.
    var element = document.createElement("input");
 
    //Assign different attributes to the element.
    element.setAttribute("type", "hidden");
    element.setAttribute("value", id);
    element.setAttribute("name", 'cliente_id');
 
    var foo = document.getElementById("input_hidden");
 
    //Append the element in page (in span).
    foo.appendChild(element);	
}
</script>

<h2><?php echo $titulo ?></h2>

<form name="equipos_ver" id="equipos_ver" method="post" action="<?php echo $enlace_confirmar ?>">
<?php if (!isset($sin_cliente)): ?>	
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
		<input name="buscar" id="buscar" type="text" onKeyUp="xajax_sugestion_clientes(this.value, 390, 167)">
		<span id="sugestion_container"></span>
	</span>
		<span id="contactos"></span>
	</p>
	<span id="input_hidden"></span>
	<p>
<?php endif ?>	
		<input name="cancelar" id="cancelar" type="button" value="Cancelar" onClick="window.location='<?php echo $enlace_cancelar ?>'">
		<input name="guardar" id="guardar" type="submit" value="Confirmar">
	</p>	
</form>

<div id="cliente_info"></div>

<h4>Equipos:</h4>

<?php echo $equipos ?>
	
</body>
</html>