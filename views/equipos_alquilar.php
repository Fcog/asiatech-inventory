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
		element.setAttribute("id", 'cliente_id');
 
    var foo = document.getElementById("input_hidden");
 
    //Append the element in page (in span).
    foo.appendChild(element);	
}

function validar()
{
	var cliente       = document.getElementById("cliente_id");
	var fecha_inicial = document.getElementById("fecha_inicial").value;
	var fecha_final   = document.getElementById("fecha_final").value;
	var ubicacion     = document.getElementById("ubicacion").value;
	
	if (!cliente || fecha_inicial == "" || fecha_final == "" || ubicacion == "")
	{
		alert("Por favor llene todos los campos");
		return false;
	}
}
</script>

<h2><?php echo $titulo ?></h2>

<form name="equipos_ver" id="equipos_ver" method="post" action="<?php echo $enlace_confirmar ?>" onSubmit="return validar()">

	<p>&nbsp;
	</p>
	<table class="tabla_form">
		<tr>
			<td><label>Cliente:</label></td>
			<td>
				<input name="buscar" id="buscar" type="text" onkeyup="xajax_sugestion_clientes(this.value, 138, 202)" />
				<span id="sugestion_container"></span>
				<span id="contactos"></span>
			</td>
		</tr>
		<tr>
			<td><label>Fecha Inicial:</label></td>
			<td>
				<input name="fecha_inicial" id="fecha_inicial" type="text" />
				<script language="JavaScript"> 
					var fecha = new Date();
					var fecha_format = (fecha.getMonth() < 9 ? '0' : '') + (fecha.getMonth() + 1) + "/"
										+ (fecha.getDate() < 10 ? '0' : '') + fecha.getDate() + "/"
										+ fecha.getFullYear()
					document.getElementById('fecha_inicial').value = fecha_format;
				 
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
					
					new tcal ({'controlname': 'fecha_inicial','selected' : s_selected,'today' : s_selected}, A_CALTPL);
				</script>
			</td>
		</tr>
		<tr>
			<td><label>Fecha Final:</label></td>
			<td>
				<input name="fecha_final" id="fecha_final" type="text" />
				<script language="JavaScript"> 
					new tcal ({'controlname': 'fecha_final','selected' : s_selected,'today' : s_selected}, A_CALTPL); 
				</script> 	
			</td>
		</tr>
		<tr>
			<td><label>Ubicación</label></td>
			<td><input name="ubicacion" id="ubicacion" type="text"></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>
				<input name="cancelar" id="cancelar" type="button" value="Cancelar" onClick="window.location='<?php echo $enlace_cancelar ?>'">
				<input name="guardar" id="guardar" type="submit" value="Confirmar">
			</td>
		</tr>		
	</table>

	<span id="input_hidden"></span>
	
	<p>
		
	</p>	
</form>

<div id="cliente_info"></div>

<h4>Equipos:</h4>

<?php echo $equipos ?>
	
</body>
</html>