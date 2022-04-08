<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript">
$(document).ready
(
	function() 	
	{ 
		$("table tbody td").hover
		(
			function() { $(this).parents('tr').find('td').addClass('highlight'); }, 
			function() { $(this).parents('tr').find('td').removeClass('highlight'); }
		);		
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<p><label>Nombre: </label><?php echo $empresa->nombre ?></p>
<p><label>NIT: </label><?php echo $empresa->nit ?></p>
<p><label>Direccion: </label><?php echo $empresa->direccion ?></p>
<p><label>Ciudad: </label><?php echo $empresa->ciudad ?></p>
<p><label>Telefono: </label><?php echo $empresa->telefono ?></p>
<p><label>Pagina Web: </label><?php echo $empresa->pagina_web ?></p>
<p><label>Fecha de Ingreso: </label><?php echo $empresa->fecha_ingreso ?></p>
		
<br>
<h3>Contactos:</h3>
<ul>
<?php foreach ($contactos as $contacto): ?>
<li><a href="<?php echo base_url() ?>clientes/ver_persona/<?php echo $contacto->id ?>" class="lupa"><?php echo $contacto->nombre ?></a></li>
<?php endforeach ?>
</ul>

<br>
<h3>Historial:</h3>

<h4>Notas de entrada de equipos:</h4>

	<?php if (empty($nea)): ?>
	No hay notas de entrada de equipos registradas para esta empresa
	<?php else: ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Fecha</th>
			<th scope="col">Descripción</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($nea as $nota): ?>
		<tr onClick="window.location='<?php echo base_url().'notas/entrada_equipos/'.$nota->id ?>'">
			<td><?php echo $nota->id ?></td>
			<td><?php echo $nota->fecha ?></td>
			<td><?php echo $nota->descripcion ?></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>


<h4>Notas de salida de equipos:</h4>

	<?php if (empty($nsa)): ?>
	No hay notas de salida de equipos registradas para esta empresa
	<?php else: ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Fecha</th>
			<th scope="col">Descripción</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($nsa as $nota): ?>
		<tr onClick="window.location='<?php echo base_url().'notas/salida_equipos/'.$nota->id ?>'">
			<td><?php echo $nota->id ?></td>
			<td><?php echo $nota->fecha ?></td>
			<td><?php echo $nota->descripcion ?></td>
		</tr>
		<?php endforeach ?>
		</tbody>
	</table>
	<?php endif ?>


</body>
</html>