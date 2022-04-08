<script type="text/javascript" src="<?php echo base_url() ?>recursos/js/javascript_agregar_cliente.js"></script>

<form id="agregar_cliente_persona_form" method="post" action="<?php echo base_url() ?>clientes/agregar_persona" onsubmit="return validar_agregar_persona_form()">
<h2>Agregar Cliente Nuevo</h2>
<h3>Persona Natural</h3>

<table class="tabla_form">
	<tr>
		<th colspan="2">Datos del contacto:</th>
		<td></td>
	</tr>
	<tr>
		<td><label for="nombre2">*Nombre:</label></td>
		<td><input type="text" name="nombre" id="nombre" class="input_obligatorio" autocomplete="off" 
			onkeyup="xajax_verificar_nombre_key(this.value)" 
			onkeypress="return bloqueo_teclado(event,letras)"/>
			<div id="nombre_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="cedula">*C.C:</label></td>
		<td><input type="text" name="cedula" id="cedula" class="input_obligatorio" autocomplete="off" maxlength="12"
			onkeyup="xajax_verificar_cedula_key(this.value)" 
			onblur="xajax_verificar_cedula_blur(this.value)"
			onkeypress="return bloqueo_teclado(event,numeros)"/>
			<div id="cedula_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="direccion">*Direccion:</label></td>
		<td><input type="text" name="direccion" id="direccion" class="input_obligatorio2" autocomplete="off" maxlength="30"/>
			<div id="dir_info"></div></td>
		<td></td>
	</tr>	
	<tr>
		<td><label for="ciudad">*Ciudad:</label></td>
		<td><input type="text" name="ciudad" id="ciudad" autocomplete="on" maxlength="30" onkeypress="return bloqueo_teclado(event,letras)"/>
		</td>
		<td></td>	
	</tr>
	<tr>
		<td><label for="tel">-Tel. fijo:</label></td>
		<td><input type="text" name="tel" id="tel" class="input_obligatorio2" autocomplete="off" maxlength="10"
			onkeyup="xajax_verificar_tel_key(this.value)" 
			onblur="xajax_verificar_tel_blur(this.value)"
			onkeypress="return bloqueo_teclado(event,numeros)"/>
			<div id="tel_info"></div></td>
		<td></td>
	</tr>	
	<tr>
		<td><label for="cel">-Celular:</label></td>
		<td><input type="text" name="cel" id="cel" class="input_obligatorio2" autocomplete="off" maxlength="12"
			onkeyup="xajax_verificar_cel_key(this.value)" 
			onblur="xajax_verificar_cel_blur(this.value)"
			onkeypress="return bloqueo_teclado(event,numeros)"/>
			<div id="cel_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="email">-Email:</label></td>
		<td><input type="text" name="email" id="email" class="input_obligatorio2" autocomplete="off" onblur="xajax_verificar_email(this.value)"/>
			<div id="email_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td>
			<?php //echo token();	?>
		</td>
		<td><input type="submit" name="guardar" id="guardar" value="Guardar" />	
			<input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="window.location='../principal'"/></td>
		<td>&nbsp;</td>
	</tr>
</table>
<p>&nbsp;</p>
</form>
</body>
</html>