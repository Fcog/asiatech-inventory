<h2><?php echo $titulo ?></h2>

<p><label>Nombre: </label><?php echo $usuario->nombre ?></p>
<p><label>Usuario: </label><?php echo $usuario->username ?></p>
<p><label>Tipo de Acceso: </label><?php echo $usuario->acceso ?></p>
<p><label>Sede: </label><?php echo $usuario->ciudad ?></p>
<p><label>Fecha de Ingreso: </label><?php echo $usuario->fecha_ingreso ?></p>

<h3>&nbsp;</h3>
<h3>Historial:</h3>

<?php if (empty($historial)): ?>
	No tiene historial
<?php else: ?>
	<table class="tablesorter">
	<thead>
		<tr>
			<th>Fecha</th>
			<th>Accion</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach($historial as $dato): ?>
		<tr>
			<td><?php echo $dato->fecha ?></td>
			<td><a href="<?php echo base_url().$dato->url ?>"><?php echo $dato->descripcion ?></a></td>
		</tr>
	<?php endforeach ?>
	</tbody>
	</table>
<?php endif ?>

</body>
</html>