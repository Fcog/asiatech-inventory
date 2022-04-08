<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $titulo ?></title>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo base_url() ?>recursos/css/estilo.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>recursos/css/menu.css" />
<?php if (isset($xajax)) echo $xajax; ?>
</head>
<body>
<div id="body2"></div>
<img src="<?php echo base_url() ?>recursos/imagenes/logout.png" name="logout" id="logout" onClick="window.location='<?php echo base_url() ?>log_user/out'">
<img src="<?php echo base_url() ?>recursos/imagenes/logo_asiatech_mini.PNG" name="mini_logo" id="mini_logo" 
onClick="window.location='<?php echo base_url(); ?>principal'">
<div id="wrap">
<!-- Start PureCSSMenu.com MENU -->
<ul class="pureCssMenu pureCssMenum">
	<li class="pureCssMenui0"><a class="pureCssMenui0" href="#"><span>Equipos</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul class="pureCssMenum">
		<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/cargar">Ingresar Equipos<![if gt IE 6]></a>
		<![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Ver Equipos</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos">Equipos Disponible</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/ver_alquilados">Equipos Alquilados</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/ver_en_reparacion">Equipos en Reparacion</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/buscar">Buscar</a></li>
		</ul>
		<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Alquiler</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/alquilar">Crear Alquiler</a></li>	
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/alquileres_vigentes">Ver Alquileres Vigentes</a></li>		
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/alquileres_terminados">Ver Alquileres Terminados</a></li>
		</ul>		
		<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Traslados</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/solicitar_traslado">Solicitar Equipos</a></li>	
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/trasladar">Trasladar Equipos</a></li>		
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/solicitudes_traslado">Ver Solicitudes de Traslado</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/en_traslado">Ver Equipos en Traslado</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/traslados_hechos">Ver Traslados Hechos</a></li>
		</ul>
		<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Reparacion</span><![if gt IE 6]></a>
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/solicitar_reparacion">Solicitar Reparacion</a></li>	
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/reparaciones_pendientes">Ver Reparaciones Pendientes</a></li>		
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/reparaciones_terminadas">Ver Reparaciones Terminadas</a></li>
		</ul>
		<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/dar_de_baja">Dar de Baja</a></li>	
		<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>equipos/reportes">Reportes</a></li>	
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
	<li class="pureCssMenui0"><a class="pureCssMenui0" href="#"><span>Clientes</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
	<ul class="pureCssMenum">
		<li class="pureCssMenui"><a class="pureCssMenui" href="#"><span>Cliente Nuevo</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>clientes/agregar_empresa">Empresa</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>clientes/agregar_persona">Persona Natural</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>clientes/agregar_contacto">Contacto a Empresa</a></li>
		</ul>
		<!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
		<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>clientes">Ver Clientes</a></li>
	</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]--></li>
	<li class="pureCssMenui0"><a class="pureCssMenui0" href="#"><span>Documentos</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/listar_nea">Ver Notas Entrada Equipos</a>
<!--			<ul class="pureCssMenum">
				<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/compras">Compras</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/traslados">Traslados</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/finiquito">Finiquitos</a></li>
			</ul>		</li>-->
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/listar_nsa">Ver Notas Salida Equipos</a>
<!--			<ul class="pureCssMenum">
				<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/ventas">Ventas/Baja</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/traslados">Traslados</a></li>
				<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>notas/remision">Remisiones</a></li>
			</ul>		</li>-->
		</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]--></li>	
	<?php if (permiso('superadmin')): ?>
	<li class="pureCssMenui0"><a class="pureCssMenui0" href="#"><span>Admin</span><![if gt IE 6]></a><![endif]><!--[if lte IE 6]><table><tr><td><![endif]-->
		<ul class="pureCssMenum">
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>admin/registrar_usuario">Registrar Usuario</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>admin/cambiar_bodega">Cambiar de Bodega</a></li>
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>admin/dar_de_baja_equipos">Dar de baja equipos</a></li>
			<!--<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>admin/modificar">Modificar Equipo</a></li>-->
			<li class="pureCssMenui"><a class="pureCssMenui" href="<?php echo base_url() ?>admin/usuarios">Ver Usuarios</a></li>
		</ul>
	<!--[if lte IE 6]></td></tr></table></a><![endif]--></li>		
	<?php endif ?>
</ul>

<!-- End PureCSSMenu.com MENU -->
<!-- (c) 2009, PureCSSMenu.com -->
</div>