<script language="JavaScript">
function guardar_id(name,id)
{
	//Create an input type dynamically.
    var element = document.createElement("input");
 
    //Assign different attributes to the element.
    element.setAttribute("type", "hidden");
    element.setAttribute("value", id);
    element.setAttribute("name", name);
		element.setAttribute("id", name);
 
    var foo = document.getElementById("input_hidden");
 
    //Append the element in page (in span).
    foo.appendChild(element);	
}
</script>

<h2><?php echo $titulo ?></h2>

<form action="<?php echo base_url() ?>equipos/reportes" method="post">

<select id="estados" name="estados" onChange="guardar_id('estado',this.options[this.selectedIndex].id)">
	<option id="0">Estado del equipo</option>
	<option id="1">Disponibles</option>
	<option id="2">Alquilados</option>
	<option id="4">En Reparacion</option>
	<option id="3">En Traslado</option>
	<option id="6">Dados de Baja</option>
</select>

<select id="tipos" name="tipos" onChange="guardar_id('tipo',this.options[this.selectedIndex].id)">
	<option id="0">Tipo de equipo</option>
	<option id="todos">Todos</option>
	<option id="1">PC Escritorio</option>
	<option id="2">Portatil</option>
	<option id="3">Monitor</option>
	<option id="4">Teclado</option>
	<option id="5">Mouse</option>
	<option id="6">Impresora</option>
	<option id="7">Otro</option>
</select>

<span id="input_hidden"></span>
<input name="guardar" id="guardar" type="submit" value="Generar Reporte">
</form>

</body>
</html>