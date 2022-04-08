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

<div id="notas_container">

	<?php if (empty($alquileres)): ?>
	No hay alquileres vigentes
	<?php else: ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Sede Asiatech</th>
			<th scope="col">Cliente</th>
			<th scope="col">Fecha Inicial</th>
			<th scope="col">Fecha Final</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($alquileres as $alquiler): ?>
		<tr onClick="window.location='<?php echo base_url().'equipos/alquiler/'.$alquiler->id ?>'">
			<td><?php echo $alquiler->id ?></td>
			<td><?php echo $alquiler->sede ?></td>
			<td><?php echo ($alquiler->empresa != '')? $alquiler->empresa : $alquiler->persona ?></td>
			<td><?php echo $alquiler->fecha_inicial ?></td>
			<td><?php echo $alquiler->fecha_final ?></td>
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
			<option value="50">50</option>
			<option value="100">100</option>
		</select>
	</form>
</div>

<?php endif ?>

</body>
</html>