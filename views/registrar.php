<script type="text/javascript">
function validar_registro()
{
	var nombre = document.forms[0]["nombre"].value;
	var acceso = document.forms[0]["acceso"].selectedIndex
	var ubicacion = document.forms[0]["ubicacion"].selectedIndex;
	var usuario = document.forms[0]["usuario"].value;
	var clave1 = document.forms[0]["clave1"].value;
	var clave2 = document.forms[0]["clave2"].value;
	
	msg = '';
	
	if (nombre=='')
		msg = msg + 'No puso nombre.\n';	
		
	if (acceso==0)
		msg = msg + 'Escoja el tipo de acceso.\n';	
		
	if (ubicacion==0)
		msg = msg + 'Escoja la ubicacion del usuario.\n';					
	
	if (clave1=='' || clave2=='')
		msg = msg + 'No puso clave.\n';
	
	if (clave1 != clave2)
		msg = msg + 'Las claves no coinciden.\n';

	if (usuario.length < 4)
		msg = msg + 'El largo del nombre de usuario es menor que 4.\n';
		
	if (clave1.length < 6)
		msg = msg + 'El largo de la clave es menor que 6.';
		
	if 	((nombre=='') || (clave1 != clave2) || (usuario.length < 4) || (clave1.length < 6) || (acceso==0) || (ubicacion==0))
	{
		alert(msg);
		return false;
	}
	
}

function crear_hidden_id(name, select_id)
{
		var sel = document.getElementById(select_id);
		var valor = sel.options[sel.selectedIndex].id;
    var element = document.createElement("input");
 
    //Assign different attributes to the element.
    element.setAttribute("type", "hidden");
    element.setAttribute("value", valor);
    element.setAttribute("name", name);
		element.setAttribute("id", name);
 
    var foo = document.getElementById("input_" + name);
		foo.innerHTML='';
 
    //Append the element in page (in span).
    foo.appendChild(element);	
}
</script>
<h2><?php echo $titulo ?></h2>
<p><?php echo $aviso ?></p>
<div id="registro_container">
  <form id="registrar" name="registrar" action="<?php echo base_url() ?>admin/registrar_usuario" method="post" onsubmit="return validar_registro()">
		<span id="input_hidden_acceso"></span>
		<span id="input_hidden_ubicacion"></span>
    <table class="tabla_form">
      <tr>
        <td><label>Nombre y apellido:</label></td>
        <td><input type="text" id="nombre" name="nombre" autocomplete="off"/></td>
      </tr>
      <tr>
      	<td><label>Tipo de acceso</label></td>
      	<td>
      		<select name="acceso" id="acceso" onchange="crear_hidden_id('hidden_acceso', this.id)">
							<option id="null">Seleccione</option>
      				<option id="secretaria">Secretaria</option>    
							<option id="tecnico">Tecnico</option>   
							<option id="superadmin">Administrador</option>  			
     			</select>
      	</span></td>
     	</tr>
      <tr>
        <td><label>Ubicacion:</label></td>
        <td>
				<select name="ubicacion" id="ubicacion" onchange="crear_hidden_id('hidden_ubicacion', this.id)">
					<option id="null">Seleccione</option>
					<option id="1">Bogota</option>
					<option id="2">Cali</option>
				</select>
			</td>
      </tr>	  
      <tr>
        <td><label>Usuario:</label></td>
        <td><input type="text" id="usuario" name="usuario" autocomplete="off"/></td>
      </tr>
      <tr>
        <td><label>Clave:</label></td>
        <td><input type="password" id="clave1" name="clave1" /></td>
      </tr>
	   <tr>
        <td><label>Repita la clave:</label></td>
        <td><input type="password" id="clave2" name="clave2" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="guardar" id="guardar" value="Registrar"/></td>
      </tr>
    </table>
    <p><br />
    </p>
    <p>&nbsp;</p>
  </form>
</div>

</body>
</html>