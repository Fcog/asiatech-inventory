<?php if (!isset($mostrar_botones)): ?>
<h2><?php echo $titulo ?></h2>
	
<form action="<?php echo base_url().'notas/'.$enlace.'/'.$nota_datos->id ?>" method="post">
	<input type="submit" id="word" name="word" value="Pasar a word">
	<input type="submit" id="imprimir" name="imprimir" value="Imprimir">
</form>
<?php endif ?>

<style>
#nota_formato 
{ 
	background:none;
	-webkit-box-shadow:none;-moz-box-shadow:none;box-shadow:none;
	width:800px;
	margin-left:10px;
	/*border: solid 1px;*/
	border-collapse:collapse
}
#nota_formato td {/*border: solid 1px*/}
#datos_cliente p{ line-height:5px }
#datos_cliente { padding:160px 10px 100px 0px; width:550px}
#datos_numero { vertical-align:top; padding-top:75px; font-weight:bold}
#datos_equipos { padding-top:10px }
#datos_equipos table { border: solid 1px; border-collapse:collapse }
#datos_equipos table td { border:solid 1px; padding:2px }
#datos_equipos table th { border:solid 1px; padding:2px }
</style>

<table id="nota_formato">
	<tr>
		<td id="datos_cliente">
			<p><?php echo $cliente ?></p>
			<p><?php echo isset($nota_datos->empresa)? 'NIT '.$nota_datos->nit : isset($nota_datos->cedula)? 'C.C. '.$nota_datos->cedula : '' ?></p>
			<p><?php echo ($nota_datos->direccion != '')? $nota_datos->direccion : $nota_datos->direccion_persona ?></p>
			<p><?php if ($nota_datos->telefono != '') echo 'Tel: '.$nota_datos->telefono ?></p>
			<p><?php echo $nota_datos->otra_info ?></p>
		</td>
		<td id="datos_numero"><p>N° <?php echo $nota_datos->id ?></p><p><?php echo $nota_datos->fecha ?></p></td>
	</tr>
	<tr>
		<td colspan="2" id="datos_equipos"><?php echo $nota_equipos ?></td>
	</tr>
</table>

</body>
</html>