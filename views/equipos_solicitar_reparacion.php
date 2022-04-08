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
		<p>
		<span id="equipos_ver_empresa">
	<label for="empresa">Cliente: </label>
			<input name="buscar" id="buscar" type="text" onKeyUp="xajax_sugestion_clientes(this.value, 80, 167)">
			<span id="sugestion_container"></span>
		</span>
			<span id="contactos"></span>
		</p>
		<span id="input_hidden"></span>
		<span id="input_hidden2"></span>
		<p>
		<input name="cancelar" id="cancelar" type="button" value="Cancelar" onClick="window.location='<?php echo $enlace_cancelar ?>'">
		<input name="guardar" id="guardar" type="submit" value="Confirmar">
	</p>	

	<div id="cliente_info"></div>
	
	<h4>Equipos:</h4>
	
	<?php echo $equipos ?>

</form>
	
</body>
</html>