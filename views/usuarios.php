<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.min.js"></script> 
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
		$("table")
		.tablesorter()	
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<div id="usuarios_container">
	<table class="tablesorter">
		<thead>
		<tr>
			<th>Nombre</th>
			<th>Tipo de Acceso</th>
			<th>Sede Asiatech</th>
			<th>Nombre de Usuario</th>
			<th>Fecha de Ingreso</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach($usuarios as $usuario): ?>
		<tr onClick="window.location='<?php echo base_url() ?>admin/usuario/<?php echo $usuario->id ?>'">	
			<td><?php echo $usuario->nombre ?></td>
			<td><?php echo $usuario->acceso ?></td>
			<td><?php echo $usuario->ciudad ?></td>
			<td><?php echo $usuario->username ?></td>
			<td><?php echo $usuario->fecha_ingreso ?></td>
		</tr>	
		<?php endforeach ?>
		</tbody>
	</table>
</div>

</body>
</html>