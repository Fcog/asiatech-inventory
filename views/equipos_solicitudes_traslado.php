<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.min.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.cookie.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablefilter.js"></script> 
<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery.tablesorter.pager.js"></script> 
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
		.tablesorterPager({container: $("#pager")})
		.tableFilter();			
	} 
);  
</script>

<h2><?php echo $titulo ?></h2>

<?php if (empty($traslados_pendientes)): ?>
No hay solicitudes de traslado
<?php else: ?>
<div id="traslados_container">
<table class="tablesorter">
	<thead>
	<tr>
		<th scope="col">Id</th>
		<th scope="col">Fecha Solicitud</th>
		<th scope="col">Sede Solicitud</th>
		<th scope="col">Estado</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($traslados_pendientes as $traslado): ?>
	<tr onClick="window.location='<?php echo base_url() ?>equipos/solicitud_traslado/<?php echo $traslado->id ?>'">
		<td><?php echo $traslado->id ?></td>
		<td><?php echo $traslado->fecha_solicitud ?></td>
		<td><?php echo $traslado->ciudad ?></td>
		<td>
			<?php if ($traslado->estado == 'P')
							echo 'Pendiente';
						else if ($traslado->estado == 'C')
							echo 'Cancelado';
						else if ($traslado->estado == 'X')
							echo 'Aceptado';
			?>
		</td>
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
</div>

<div id="pager" class="pager">
	<form>
		<img src="<?php echo base_url() ?>recursos/addons/img/first.png" class="first"/>
		<img src="<?php echo base_url() ?>recursos/addons/img/prev.png" class="prev"/>

		<input type="text" class="pagedisplay"/>

		<img src="<?php echo base_url() ?>recursos/addons/img/next.png" class="next"/>
		<img src="<?php echo base_url() ?>recursos/addons/img/last.png" class="last"/>

		<select class="pagesize">
			<option selected="selected"  value="15">15</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="100">100</option>
		</select>
	</form>
</div>

<?php endif ?>
</body>
</html>