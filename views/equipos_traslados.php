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

	<?php if (empty($notas)): ?>
	No hay Notas de Salida de Equipos registradas
	<?php else: ?>
	<table class="tablesorter">
		<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">Sede envió</th>
			<th scope="col">Sede recibió</th>
			<th scope="col">Fecha envio</th>
			<th scope="col">Fecha recibido</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($notas as $nota): ?>
		<tr onClick="window.location='<?php echo base_url().$onclick.$nota->nsa_id ?>'">
			<td><?php echo $nota->nsa_id ?></td>
			<td><?php echo $nota->ciudad_envio ?></td>
			<td><?php echo $nota->ciudad_recibido ?></td>
			<td><?php echo $nota->fecha_envio ?></td>
			<td><?php echo $nota->fecha_recibido ?></td>
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
			<option selected="selected"  value="10">10</option>
			<option value="20">20</option>
			<option value="30">30</option>
			<option value="40">40</option>
			<option value="100">100</option>
		</select>
	</form>
</div>

<?php endif ?>

</body>
</html>