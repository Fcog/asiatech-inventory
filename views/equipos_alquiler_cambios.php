<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script language="JavaScript" src="<?php echo base_url() ?>recursos/addons/calendar_us2.js"></script> 
<script type="text/javascript">
$(document).ready(function(){
	$('table td input.delete').click(function(){
			$(this).parent().parent().remove();
	});
});
</script>
<link rel="stylesheet" href="<?php echo base_url() ?>recursos/addons/calendar.css"> 
							
<h2><?php echo $titulo ?></h2>

<div id="alquiler_cambios">

	<form action="<?php echo base_url() ?>equipos/alquiler_cambios/<?php echo $alquiler->id ?>" method="post" id="form1">
		<div id="alquiler_botones">
			<input name="cancelar" id="cancelar" type="button" value="Cancelar" 
			onClick="window.location='<?php echo base_url() ?>equipos/alquiler/<?php echo $alquiler->id ?>'">
			<input name="guardar" id="guardar" type="submit" value="Guardar">
		</div>
	</form>
	
	<div id="span_info"><?php echo $info ?></div>
	
	<?php echo $equipos ?>
	
</div>

</body>
</html>