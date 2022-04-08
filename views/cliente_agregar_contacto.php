<script type="text/javascript" src="<?php echo base_url() ?>recursos/js/javascript_agregar_cliente.js"></script>

<div id="bloqueo"></div>
<form id="agregar_cliente_contacto_form" method="post" action="<?php echo base_url() ?>clientes/agregar_contacto" onsubmit="return validar_agregar_contacto_form()">
<h2>Agregar Contacto a empresa</h2>

<p id="agregar_cliente_contacto_buscar">
	<label for="buscar">Empresa:</label>
	<input type="text" name="buscar" id="buscar" autocomplete="off" placeholder="Seleccione" 
	onkeyup="xajax_sugestion_empresa(this.value, 577, 153);"/>
	<div id="sugestion_container"></div>
	<span id="input_hidden">&nbsp;</span>
</p><br />
<table class="tabla_form">
	<tr>
		<th colspan="2">Datos del contacto:</th>
		<td></td>
	</tr>
	<tr>
		<td><label for="nombre">*Nombre:</label></td>
		<td><input type="text" name="nombre" id="nombre" class="input_obligatorio" autocomplete="off" maxlength="30"
			onkeyup="xajax_verificar_nombre_key(this.value)" 
			onkeypress="return bloqueo_teclado(event,letras)"/>
			<div id="nombre_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="cedula">*C.C:</label></td>
		<td><input type="text" name="cedula" id="cedula" class="input_obligatorio" autocomplete="off"  maxlength="12"
			onkeyup="xajax_verificar_cedula_key(this.value)" 
			onblur="xajax_verificar_cedula_blur(this.value)"
			onkeypress="return bloqueo_teclado(event,numeros)"/>
			<div id="cedula_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="tel">-Tel. fijo:</label></td>
		<td><input type="text" name="tel" id="tel" class="input_obligatorio2" autocomplete="off"  maxlength="15"
			onkeyup="xajax_verificar_tel_key(this.value)" 
			onblur="xajax_verificar_tel_blur(this.value)"
			onkeypress="return bloqueo_teclado(event,numeros2)"/>
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
	   <td><input type="text" name="email" id="email" class="input_obligatorio2" autocomplete="off" onblur="xajax_verificar_email(this.value)" maxlength="30"/>
			<div id="email_info"></div></td>
		<td></td>
	</tr>
	<tr>
		<td><label for="area">Area:</label></td>
		<td><input type="text" name="area" id="area" autocomplete="off" maxlength="30"/></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><label for="cargo">Cargo:</label></td>
		<td><input type="text" name="cargo" id="cargo" autocomplete="off" maxlength="30"/></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><?php
			$ficha = md5(uniqid(rand(), TRUE));
			$_SESSION['ficha'] = $ficha;
			echo '<input type="hidden" name="ficha" id="ficha" value="'.$ficha.'" />';
			?></td>
		<td><input type="submit" name="guardar" id="guardar" value="Guardar" />	
			<input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="window.location='../principal'"/></td>
		<td>&nbsp;</td>
	</tr>
</table>
<p>&nbsp;</p>
</form>
</body>
</html>