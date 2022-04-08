<script type="text/javascript" src="<?php echo base_url() ?>recursos/addons/jquery-1.5.2.min.js"></script> 
<script type="text/javascript"> 
	$(document).ready(function() { 
		$("#equipos table tbody td").hover(
		function() {
			$(this).parents("tr").find("td").addClass("highlight");
		}, function() {
			$(this).parents("tr").find("td").removeClass("highlight");
		});	});	
</script>

<h2><?php echo $titulo ?></h2>

<?php echo $equipo ?>

<h3>Cambiar por:</h3>

<div id="equipos"><?php echo $equipos ?></div>

</body>
</html>