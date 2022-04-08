<script type="text/javascript" src="<?php echo base_url() ?>recursos/js/javascript_agregar_cliente.js"></script>
<!--onsubmit="return validar_agregar_empresa_form()"-->
<form id="agregar_cliente_empresa_form" method="post" action="<?php echo base_url() ?>clientes/agregar_empresa" onsubmit="return validar_agregar_empresa_form()">
<h2>Agregar Empresa Nueva</h2>
<h3>Empresa y Contacto</h3>

	<table id="agregar_cliente_empresa_tabla_empresa" class="tabla_form">
		<tr>
			<th colspan="2">Datos de la empresa:</th>
		</tr>
		<tr>
			<td><label for="nombre_empresa">*Nombre:</label></td>
			<td><input type="text" name="nombre_empresa" id="nombre_empresa" class="input_obligatorio" autocomplete="off" 
			onkeyup="xajax_verificar_nombre_empresa_key(this.value)"/>
			<div id="nombre_empresa_info"></div></td>
		</tr>
		<tr>
			<td><label for="nit">*N.I.T:</label></td>
			<td><input type="text" name="nit" id="nit" class="input_obligatorio" autocomplete="off"  maxlength="11"
			onkeyup="xajax_verificar_nit_key(this.value)"
			onKeyPress="return bloqueo_teclado(event,'1234567890-')"/>
			<div id="nit_info"></div></td>
		</tr>
		<tr>
			<td><label for="direccion">*Dirección:</label></td>
			<td><input type="text" name="direccion" id="direccion" class="input_obligatorio"  autocomplete="off"/></td>
		</tr>
		<tr>
			<td><label for="ciudad">*Ciudad:</label></td>
			<td><div id="div_ciudad"><input type="text" name="ciudad" id="ciudad" autocomplete="on" /></div>
			<div id="sugestion_ciudad_container"></div>
			</td>
			<span id="input_hidden_ciudad_id">&nbsp;</span>		</tr>
		<tr>
			<td><label for="tel_empresa">Teléfono:</label></td>
			<td><input type="text" name="tel_empresa" id="tel_empresa" class="input_obligatorio" autocomplete="off"  maxlength="10"
			onKeyPress="return bloqueo_teclado(event,numeros)"
			onkeyup="xajax_verificar_tel_empresa_key(this.value)"
			onblur="xajax_verificar_tel_empresa_blur(this.value)"/>
			<div id="tel_empresa_info"></div></td>
		</tr>		
		<tr>
			<td><label for="pagina_web">Página Web:</label></td>
			<td><input type="text" name="pagina_web" id="pagina_web" autocomplete="off"/></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table id="agregar_cliente_empresa_tabla_contacto" class="tabla_form">
		<tr>
			<th colspan="2">Datos del contacto:</th>
		</tr>
		<tr>
			<td><label for="nombre">*Nombre:</label></td>
			<td><input type="text" name="nombre" id="nombre" class="input_obligatorio" autocomplete="off" 
			onkeyup="xajax_verificar_nombre_key(this.value)" 
			onKeyPress="return bloqueo_teclado(event,letras)"/>
			<div id="nombre_info"></div></td>
		</tr>
		<tr>
			<td><label for="cedula">*C.C:</label></td>
			<td><input type="text" name="cedula" id="cedula" class="input_obligatorio" autocomplete="off" maxlength="15"
			onkeyup="xajax_verificar_cedula_key(this.value)" 
			onblur="xajax_verificar_cedula_blur(this.value)"
			onKeyPress="return bloqueo_teclado(event,numeros)"/>
			<div id="cedula_info"></div></td>
		</tr>
		<tr>
			<td><label for="tel">-Tel. fijo:</label></td>
			<td><input type="text" name="tel" id="tel" class="input_obligatorio2" autocomplete="off" maxlength="10"
			onkeyup="xajax_verificar_tel_key(this.value)"
			onblur="xajax_verificar_tel_blur(this.value)"
			onKeyPress="return bloqueo_teclado(event,numeros)"/>
			<div id="tel_info"></div></td>
		</tr>
		<tr>
			<td><label for="cel">-Celular:</label></td>
			<td><input type="text" name="cel" id="cel" class="input_obligatorio2" autocomplete="off" maxlength="15"
			onkeyup="xajax_verificar_cel_key(this.value)" 
			onblur="xajax_verificar_cel_blur(this.value)"
			onKeyPress="return bloqueo_teclado(event,numeros)"/>
			<div id="cel_info"></div></td>
		</tr>
		<tr>
			<td><label for="email">-Email:</label></td>
			<td><input type="text" name="email" id="email" class="input_obligatorio2" autocomplete="off" maxlength="45"
			onblur="xajax_verificar_email(this.value)"/>
			<div id="email_info"></div></td>		
		</tr>
		<tr>
			<td><label for="area">Area:</label></td>
			<td><input type="text" name="area" id="area" autocomplete="off" maxlength="45"/></td>
		</tr>
		<tr>
			<td><label for="cargo">Cargo:</label></td>
			<td><input type="text" name="cargo" id="cargo" autocomplete="off" maxlength="45"></td>
		</tr>
		<tr>
			<td>
			<?php
			$ficha = md5(uniqid(rand(), TRUE));
			$_SESSION['ficha'] = $ficha;
			echo '<input type="hidden" name="ficha" id="ficha" value="'.$ficha.'" />';
			?>
			
			</td>
			<td>
			</td>
		</tr>
	</table>
	<div id="agregar_cliente_empresa_submit">
		<input type="submit" name="guardar" id="guardar" value="Guardar" />
			<input type="button" name="cancelar" id="cancelar" value="Cancelar" onclick="window.location='../principal'"/>
	</div>
	<p>&nbsp;</p>
</form>
</body>
</html>