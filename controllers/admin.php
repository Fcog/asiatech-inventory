<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class admin extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		acceso('superadmin');

		$this->load->library('xajax');
		$this->xajax->configure("javascript URI", base_url());			
	}
	
	function registrar_usuario()
	{
		if ($_POST)
		{
			$usuario = new usuario;
			$usuario->load($_POST['nombre'], $_POST['hidden_acceso'], $_POST['hidden_ubicacion'], $_POST['usuario'], $_POST['clave1']);
			$usuario->insert();
			
			$data['aviso'] = '<div class="consulta_exitosa">Usuario creado</div>';			
		}
		else
		{
			$data['aviso'] = '';
		}
		
		$data['titulo'] = 'Registrar Usuario';
		
		$this->load->view('encabezado', $data);
		$this->load->view('registrar', $data);
	}
	
	function dar_de_baja_equipos()
	{
		$equipo = new equipo;
		
		$data['onclick'] = 'admin/dar_de_baja_equipos2/';
		$data['notas'] = $equipo->listar_solicitudes_de_baja();		
		
		$data['titulo'] = 'Dar Equipos de Baja';
		
		$this->load->view('encabezado', $data);
		$this->load->view('equipos_dar_de_baja', $data);
	}
	
	function dar_de_baja_equipos2($salida_id)
	{
		$nota = new nota;
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			$equipos = $equipo->listar_equipos_de_baja($_POST['salida_id']);
			$nota_id = $equipo->dar_de_baja($_POST['salida_id'], $equipos);
			
			redirect('notas/salida_equipos/'.$nota_id);
		}
		else if (isset($_POST['cancelar']))
		{
			$equipos = $equipo->listar_equipos_de_baja($_POST['salida_id']);
			$equipo->no_dar_de_baja($_POST['salida_id'], $equipos);
			redirect('admin/dar_de_baja_equipos');			
		}
		
		$data['nota_datos'] = $equipo->listar_datos_de_baja($salida_id);
		$data['nota_equipos'] = $equipo->dibujar_equipos_array($equipo->listar_equipos_de_baja($salida_id), 'todos', array('titulo'));
		
		if ($data['nota_datos']->estado == 'P')
			$data['botones'] = TRUE;
		else if ($data['nota_datos']->estado == 'X')
			$data['cancelado'] = TRUE;
		else if ($data['nota_datos']->estado == 'A')	
			$data['aceptado'] = TRUE;
		
		$data['titulo'] = 'Dar de baja equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_dar_de_baja_ver', $data);				
	}
	
	function usuarios()
	{
		$usuario = new usuario;
		
		$data['usuarios'] = $usuario->listar_usuarios();
		
		$data['titulo'] = 'Usuarios';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('usuarios', $data);			
	}
	
	function usuario($usuario_id)
	{
		$usuario = new usuario;
		
		$data['usuario'] = $usuario->listar_datos_usuario($usuario_id);
		
		$data['historial'] = $usuario->listar_historial_usuario($usuario_id);
		
		$data['titulo'] = 'Usuario';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('usuario', $data);				
	}	
	
	function modificar()
	{
		acceso();
		
		$equipo = new equipo;
		$bodega_id_usuario = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		$this->xajax->register(XAJAX_FUNCTION, array('seleccionar_equipo', $equipo,'seleccionar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados']) && !isset($_SESSION['no_borrar'])) unset($_SESSION['equipos_seleccionados']);
		if (isset($_SESSION['no_borrar'])) unset($_SESSION['no_borrar']); 
		$_SESSION['boton'] = 'reparar';
		
		$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id_usuario,'todos', 'modificar');
		
		$data['titulo'] = 'Modificar Equipo';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);				
	}
	
	// en creacion
	function modificar2($equipo_id)
	{
		acceso();
		
		$equipo = new equipo;
		$equipo->select($equipo_id);
		
		if ($equipo->tipo_equipo_id == 1)
		{
			$pc = new pc_escritorio;
			$pc->select($equipo_id);			
			
			if (isset($_POST['guardar']))
			{
				$pc->memoria 							= $_POST['memoria'];
				$pc->memoria_inv					= $_POST['memoria_inv'];
				$pc->memoria_serial 			= $_POST['memoria_serial'];
				$pc->disco_duro 					= $_POST['disco_duro'];
				$pc->disco_duro_inv 			= $_POST['disco_duro_inv'];
				$pc->disco_duro_serial 		= $_POST['disco_duro_serial'];
				$pc->unidad_optica 				= $_POST['unidad_optica'];
				$pc->unidad_optica_inv 		= $_POST['unidad_optica_inv'];
				$pc->unidad_optica_serial = $_POST['unidad_optica_serial'];
				$pc->observacion				  = $_POST['observacion'];
				
				$pc->update();
				
				redirect('equipos/modificar');	
			}
			
			$data['equipo'] = $pc;
			
			$data['titulo'] = 'Modificar PC de Escritorio';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_reparar_pc', $data);			
		}
	}	
	
	function cambiar_bodega()
	{
		$usuario = new usuario;
		
		if (isset($_POST['guardar']))
		{
			$usuario->actualizar_bodega($_SESSION['usuario']['id'], $_POST['bodegas']);
		}
		
		$data['bodegas'] = $usuario->listar_bodegas();
		
		$data['titulo'] = 'Cambiar de bodega';
		
		$this->load->view('encabezado', $data);
		$this->load->view('cambiar_bodega', $data);		
	}
	
}