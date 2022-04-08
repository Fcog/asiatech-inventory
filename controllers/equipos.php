<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class equipos extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		acceso();
		
		$this->db->query("SET lc_time_names = 'es_MX'");	
		
		$this->load->library('xajax');
		$this->xajax->configure("javascript URI", base_url());		
	}
	
	// ver equipos disponibles
	function index()
	{
		$equipo = new equipo;
		
		$bodega_id = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados'])) unset($_SESSION['equipos_seleccionados']);
		
		if (permiso('superadmin'))
			$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1','todos', 'historial');
		else
			$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id,'todos', 'historial');
		
		$data['titulo'] = 'Ver equipos disponibles';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);		
	}
	
	function ver_alquilados()
	{
		$equipo = new equipo;
		
		$bodega_id = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados'])) unset($_SESSION['equipos_seleccionados']);
		
		if (permiso('superadmin'))
			$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=2', 'alquilado', 'historial');		
		else
			$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=2 AND e.equipos_bodegas_id='.$bodega_id, 'alquilado', 'historial');
		
		$data['titulo'] = 'Ver equipos alquilados';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);		
	}	
	
	function ver_en_reparacion()
	{
		$equipo = new equipo;
		
		$bodega_id = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados'])) unset($_SESSION['equipos_seleccionados']);
		
		if (permiso('superadmin'))
			$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=4','sin bodega', 'historial');
		else
			$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=4 AND e.equipos_bodegas_id='.$bodega_id,'sin bodega', 'historial');
		
		$data['titulo'] = 'Ver equipos en reparacion';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);		
	}		
	
	function buscar()
	{
		$data['resultado'] = '';
		
		if (isset($_POST['buscar']))
		{
			$equipo = new equipo;
			$query = $equipo->buscar($_POST['tipo'], $_POST['equipo']);
			
			if ($query->num_rows() > 0)
			{
				$equipos = $equipo->query_2_array($query);
				$data['resultado'] = $equipo->dibujar_equipos_array($equipos, 'todos', array('observacion','titulo','estado'));
			}
			else if ($query->num_rows() == 1)
			{
				$equipo_id = $query->row()->id;
				$data['resultado'] = $equipo->dibujar_equipos('e.id='.$equipo_id, 'todos', array('observacion','titulo','estado'));
			}
			else
				$data['resultado'] = '0 resultados';
		}
		
		$data['titulo'] = 'Buscar Equipo';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_buscar', $data);			
	}
	
	function historial($equipo_id)
	{
		$equipo = new equipo;
		
		$data['reparaciones'] = $equipo->listar_reparaciones($equipo_id);
		$data['alquileres'] = $equipo->listar_alquileres($equipo_id);
		$data['equipos'] = $equipo;
		$data['nsa'] = $equipo->listar_nsa($equipo_id);
		$data['nea'] = $equipo->listar_nea($equipo_id);
		
		$data['titulo'] = 'Historial del Equipo';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_historial', $data);				
	}
	
	function cargar()
	{		
		acceso('secretaria');
			
		if (isset($_POST['guardar']))
		{	
			$fecha_ingreso=date("Y-m-d-H-i-s");		
			$archivo_renombrado = $_SERVER['DOCUMENT_ROOT']."/CodeIgniter2/uploads/equipos_".$fecha_ingreso.".xls";
			
			if(!move_uploaded_file($_FILES['archivo']['tmp_name'], $archivo_renombrado)) 
			{
				$data['mensaje'] = "Hubo un error cargando el archivo, por favor intentelo de nuevo!";
			} 
			else
			{
				@include_once 'reader2.php';
				
				$dato = new Spreadsheet_Excel_Reader();
				$dato->setOutputEncoding('utf-8');
				$dato->read($archivo_renombrado);
				
				$cliente_id   = $_POST['cliente_id'];
				$fecha_compra = $_POST['fecha'];		
				
				$equipo = new equipo;	
				$res = $equipo->cargar($dato, $cliente_id, $fecha_compra);
					
				if ($res[0] === FALSE || count($res[1]) == 0 || $res[2] != '')
				{
					$data['mensaje'] = 'Hubo un error guardando los equipos. Corrija el error y cargue el archivo nuevamente: <br><br>'.$res[2];
					unlink($archivo_renombrado);
				}
				else
					//$data['mensaje'] = $equipo->dibujar_equipos_array($res[1], array('empresa','bodega','inventario','serial','marca','modelo','caract'), array('titulo'));
					$data['mensaje'] = 'Equipos cargados correctamente al sistema. <a href="'.base_url().'notas/entrada_equipos/'.$res[3].'">
															Ver Nota de Entrada de Equipos</a>';
			
			}// endif cargo archivo
		}
		else
		{
			$cliente = new cliente;	
				
			$this->xajax->register(XAJAX_FUNCTION, array('sugestion_clientes', $cliente,'sugestion_clientes'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_contactos', $cliente,'mostrar_contactos'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_persona', $cliente,'mostrar_info_persona'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_empresa', $cliente,'mostrar_info_empresa'));			
			$this->xajax->processRequest();		
			
			$data['xajax'] = $this->xajax->getJavascript();			
			$data['mensaje'] = '';
		}
		
		$data['titulo'] = 'Cargar equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_cargar', $data);
	}
	
	function dar_de_baja()
	{
		acceso('secretaria');
		
		$equipo = new equipo;
		$bodega_id_usuario = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		$this->xajax->register(XAJAX_FUNCTION, array('seleccionar_equipo', $equipo,'seleccionar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados']) && !isset($_SESSION['no_borrar'])) unset($_SESSION['equipos_seleccionados']);
		if (isset($_SESSION['no_borrar'])) unset($_SESSION['no_borrar']); 
		$_SESSION['boton'] = 'dar_de_baja';
		
		$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id_usuario,'todos', 'seleccionar_varios');
		
		$data['titulo'] = 'Dar de baja equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);				
	}
	
	function dar_de_baja2()
	{
		acceso('secretaria');
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			$cliente_id = isset($_POST['cliente_id'])? $_POST['cliente_id'] : 0;
			
			$equipo->solicitar_dar_de_baja($_SESSION['equipos_seleccionados'], $cliente_id);
			
			unset($_SESSION['no_borrar']);
			
			redirect('equipos/dar_de_baja');
		}
		else
		{
			$cliente = new cliente;	
				
			$this->xajax->register(XAJAX_FUNCTION, array('sugestion_clientes', $cliente,'sugestion_clientes'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_contactos', $cliente,'mostrar_contactos'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_persona', $cliente,'mostrar_info_persona'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_empresa', $cliente,'mostrar_info_empresa'));
			//$this->xajax->configure('debug', true); 
			$this->xajax->processRequest();		
			
			$data['xajax'] = $this->xajax->getJavascript();		
			
			$data['equipos'] = $equipo->dibujar_equipos_array($_SESSION['equipos_seleccionados'], 'todos', array('titulo'));
			
			$data['enlace_confirmar'] = base_url().'equipos/dar_de_baja2';
			$data['enlace_cancelar'] = base_url().'equipos/dar_de_baja';
			
			$_SESSION['no_borrar'] = TRUE;
			
			$data['titulo'] = 'Dar de baja equipos';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_ver2', $data);		
		}
	}
	
	function trasladar()
	{
		acceso('secretaria');
		
		$equipo = new equipo;
		$bodega_id_usuario = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		$this->xajax->register(XAJAX_FUNCTION, array('seleccionar_equipo', $equipo,'seleccionar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados']) && !isset($_SESSION['no_borrar'])) unset($_SESSION['equipos_seleccionados']);
		if (isset($_SESSION['no_borrar'])) unset($_SESSION['no_borrar']); 
		$_SESSION['boton'] = 'trasladar';
		
		$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id_usuario,'todos', 'seleccionar_varios');
		
		$data['titulo'] = 'Trasladar equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);				
	}

	function trasladar2()
	{
		acceso('secretaria');
		
		$equipo = new equipo;

		if (isset($_POST['guardar']))
		{
			$nota_id = $equipo->trasladar($_SESSION['equipos_seleccionados']);
			unset($_SESSION['no_borrar']);
			redirect('notas/salida_equipos/'.$nota_id);
		}
		else
		{		
			$data['equipos'] = $equipo->dibujar_equipos_array($_SESSION['equipos_seleccionados'], 'todos', array('titulo'));
		
			$data['enlace_confirmar'] = base_url().'equipos/trasladar2';
			$data['enlace_cancelar'] = base_url().'equipos/trasladar';	
			$data['sin_cliente'] = TRUE;
			
			$_SESSION['no_borrar'] = TRUE;
			
			$data['titulo'] = 'Trasladar equipos';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_ver2', $data);		
		}
	}
	
	function solicitar_traslado()
	{
		acceso('secretaria');
		
		$equipo = new equipo;
		$bodega_id_usuario = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		$this->xajax->register(XAJAX_FUNCTION, array('seleccionar_equipo', $equipo,'seleccionar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados']) && !isset($_SESSION['no_borrar'])) unset($_SESSION['equipos_seleccionados']);
		if (isset($_SESSION['no_borrar'])) unset($_SESSION['no_borrar']); 
		$_SESSION['boton'] = 'solicitar_traslado';
		
		$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id<>'.$bodega_id_usuario,'todos', 'seleccionar_varios');
		
		$data['titulo'] = 'Solicitar Traslado de Equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);				
	}

	function solicitar_traslado2()
	{
		acceso('secretaria');
		
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			$equipo->solicitar_traslado($_SESSION['equipos_seleccionados']);
			unset($_SESSION['no_borrar']);
			redirect('equipos/solicitudes_traslado');
		}
		else
		{				
			$data['equipos'] = $equipo->dibujar_equipos_array($_SESSION['equipos_seleccionados'], 'todos', array('titulo'));
		
			$data['enlace_confirmar'] = base_url().'equipos/solicitar_traslado2';
			$data['enlace_cancelar'] = base_url().'equipos/solicitar_traslado';	
			$data['sin_cliente'] = TRUE;
			$_SESSION['no_borrar'] = TRUE;
			
			$data['titulo'] = 'Solicitar Traslado de Equipos';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_ver2', $data);					
		}
	}
	
	function solicitudes_traslado()
	{
		$equipo = new equipo;
		
		$data['traslados_pendientes'] = $equipo->listar_solicitudes_traslado();
		$data['titulo'] = 'Solicitudes de Traslado';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_solicitudes_traslado', $data);		
	}
	
	function solicitud_traslado($traslado_id)
	{
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			$equipos = $equipo->listar_equipos_traslado($traslado_id);
			
			$nota_id = $equipo->aceptar_solicitud_traslado($traslado_id, $equipos);
			
			redirect('notas/salida_equipos/'.$nota_id);
		}
		else if (isset($_POST['cancelar']))
		{
			$equipo->cancelar_solicitud_traslado($_POST['traslado_id']);
			
			redirect('equipos/solicitudes_traslado');
		}
		else
		{
			$data['traslado'] = $equipo->listar_datos_traslado($traslado_id);
			$data['equipos'] = $equipo->dibujar_equipos_array($equipo->listar_equipos_traslado($traslado_id), 'todos', array('titulo'));
			
			if ($data['traslado']->estado == 'P')
				$data['permiso'] = $equipo->permiso_aceptar_solicitud_traslado($traslado_id) && permiso('secretaria');
			else
				$data['permiso'] = FALSE;
				
			if ($data['traslado']->estado == 'C')
				$data['cancelado'] = TRUE;
	
			$data['titulo'] = 'Solicitud de Traslado';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_solicitud_traslado', $data);			
		}
	}
	
	function en_traslado()
	{
		$equipo = new equipo;
		
		$data['traslados'] = $equipo->listar_traslados('A');
		$data['titulo'] = 'Equipos en Traslado';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_en_traslado', $data);		
	}
	
	function traslados_hechos()
	{
		$equipo = new equipo;
		
		$data['traslados'] = $equipo->listar_traslados('X');
		$data['titulo'] = 'Traslados hechos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_en_traslado', $data);		
	}	
	
	function traslado($traslado_id)
	{
		$equipo = new equipo;
		
		$data['datos'] = $equipo->listar_datos_traslado($traslado_id);
		
		if ($data['datos']->estado == 'A')
		{
			if (isset($_POST['guardar']))
			{
				$equipos = $equipo->listar_equipos_traslado($traslado_id);
				
				$nota_id = $equipo->recibir_traslado($traslado_id, $equipos);
				
				redirect('notas/entrada_equipos/'.$nota_id);
			}
			else
			{
				$data['traslado_id'] = $traslado_id;
				$data['equipos'] = $equipo->dibujar_equipos_array($equipo->listar_equipos_traslado($traslado_id), 'todos', array('titulo'));
				$data['permiso'] = $equipo->permiso_aceptar_traslado($traslado_id) && permiso('secretaria');
				
				$data['titulo'] = 'Equipos en Traslado';
				
				$this->load->view('encabezado', $data);		
				$this->load->view('equipos_traslado', $data);			
			}	
		}
		else
		{
				$data['traslado_id'] = $traslado_id;
				$data['equipos'] = $equipo->dibujar_equipos_array($equipo->listar_equipos_traslado($traslado_id), 'todos', array('titulo'));
				$data['permiso'] = FALSE;
				
				if ($data['datos']->estado == 'X')
					$data['titulo'] = 'Traslado Hecho';
				else if ($data['datos']->estado == 'C')	
					$data['titulo'] = 'Traslado Cancelado';
				
				$this->load->view('encabezado', $data);		
				$this->load->view('equipos_traslado', $data);					
		}
	}
	
	function alquilar()
	{
		acceso('secretaria');
		
		$equipo = new equipo;
		$bodega_id_usuario = $_SESSION['usuario']['bodega_id'];
		
		$this->xajax->register(XAJAX_FUNCTION, array('dibujar_equipos', $equipo,'dibujar_equipos'));
		$this->xajax->register(XAJAX_FUNCTION, array('seleccionar_equipo', $equipo,'seleccionar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		if (isset($_SESSION['equipos_seleccionados']) && !isset($_SESSION['no_borrar'])) unset($_SESSION['equipos_seleccionados']);
		if (isset($_SESSION['no_borrar'])) unset($_SESSION['no_borrar']); 
		$_SESSION['boton'] = 'alquilar';
		
		$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id_usuario,'todos', 'seleccionar_varios');
		
		$data['titulo'] = 'Alquilar equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);				
	}

	function alquilar2()
	{
		acceso('secretaria');
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			$nota_id = $equipo->alquilar($_SESSION['equipos_seleccionados'], $_POST['cliente_id'], $_POST['fecha_inicial'], $_POST['fecha_final'], $_POST['ubicacion']);
			
			unset($_SESSION['no_borrar']);
			
			redirect('notas/salida_equipos/'.$nota_id);
		}
		else
		{
			$cliente = new cliente;	
				
			$this->xajax->register(XAJAX_FUNCTION, array('sugestion_clientes', $cliente,'sugestion_clientes'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_contactos', $cliente,'mostrar_contactos'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_persona', $cliente,'mostrar_info_persona'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_empresa', $cliente,'mostrar_info_empresa'));
			//$this->xajax->configure('debug', true); 
			$this->xajax->processRequest();		
			
			$data['xajax'] = $this->xajax->getJavascript();		
			
			$data['equipos'] = $equipo->dibujar_equipos_array($_SESSION['equipos_seleccionados'], 'todos', array('titulo'));
			
			$data['enlace_confirmar'] = base_url().'equipos/alquilar2';
			$data['enlace_cancelar'] = base_url().'equipos/alquilar';
			
			$_SESSION['no_borrar'] = TRUE;
			
			$data['titulo'] = 'Alquilar Equipos';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_alquilar', $data);		
		}
	}
	
	function alquileres_vigentes()
	{
		$equipo = new equipo;
		
		$data['alquileres'] = $equipo->listar_alquileres_vigentes();
		
		$data['titulo'] = 'Alquileres Vigentes';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_alquileres_vigentes', $data);			
	}
	
	function alquileres_terminados()
	{
		$equipo = new equipo;
		
		$data['alquileres'] = $equipo->listar_alquileres_terminados();
		
		$data['titulo'] = 'Alquileres Terminados';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_alquileres_terminados', $data);			
	}		
	
	function alquiler($alquiler_id)
	{
		$equipo = new equipo;
		
		$data['equipos'] = $equipo->dibujar_equipos_array($equipo->listar_equipos_alquiler($alquiler_id), 
																										  array('empresa','inventario','modelo','marca','caract'), 
																											array('titulo'));
		
		$data['alquiler'] = $equipo->listar_datos_alquiler($alquiler_id);
		
		if ($data['alquiler']->estado == 'A')
		{
			if (isset($_POST['prorrogar']))
			{
				$equipo->prorrogar_alquiler($alquiler_id, $_POST['fecha_final']);
			}		
			else if (isset($_POST['terminar']))
			{
				$nota_id = $equipo->terminar_alquiler($alquiler_id);
				redirect('notas/entrada_equipos/'.$nota_id);
			}	
	
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_fecha', $equipo,'mostrar_fecha'));
			//$this->xajax->configure('debug', true); 
			$this->xajax->processRequest();		
			
			$data['xajax'] = $this->xajax->getJavascript();		
			
			$data['permiso'] = $equipo->permiso_alquiler($alquiler_id) && permiso('secretaria');
			
			$_SESSION['equipos'] = $equipo->listar_equipos_alquiler($alquiler_id);
			$_SESSION['equipos_out'] = array();	
			$_SESSION['equipos_in'] = array();	
			$_SESSION['alquiler_id'] = $alquiler_id;	
	
			$data['titulo'] = 'Alquiler Vigente';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_alquiler', $data);	
		}
		else
		{
			$data['cambios'] = $equipo->listar_cambios_alquiler_historial($alquiler_id);
			
			$data['cambios2'] = $equipo->listar_cambios_alquiler_historial2($alquiler_id);
	
			$data['titulo'] = 'Alquiler Terminado';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_alquiler_terminado', $data);					
		}
	}
	
	function alquiler_cambios($alquiler_id)
	{
		$equipo = new equipo;	
		
		if (isset($_POST['guardar']))
		{
			if (count($_SESSION['equipos_out']) > 0 || count($_SESSION['equipos_in']) > 0)
				$equipo->guardar_cambios($alquiler_id, $_SESSION['equipos_in'], $_SESSION['equipos_out']);
				
			redirect('equipos/alquiler_historial/'.$alquiler_id);
		}
		
		$this->xajax->register(XAJAX_FUNCTION, array('retirar_equipo', $equipo,'retirar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();	

		$data['alquiler'] = $equipo->listar_datos_alquiler($alquiler_id);
		
		$data['info'] = $equipo->mostrar_info_cambio();
		
		$data['equipos'] = $equipo->dibujar_equipos_array($_SESSION['equipos'], 'todos', array('titulo','cambios'), NULL, $alquiler_id);

		$data['titulo'] = 'Cambiar Equipos al Alquiler';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_alquiler_cambios', $data);		
	}
	
	function alquiler_cambiar_equipo($alquiler_id, $equipo_id)
	{
		$equipo = new equipo;	

		$this->xajax->register(XAJAX_FUNCTION, array('cambiar_equipo', $equipo,'cambiar_equipo'));
		//$this->xajax->configure('debug', true); 
		$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();	
		
		$equipo->select($equipo_id);
		
		$bodega_id = $_SESSION['usuario']['bodega_id'];
		
		$data['equipo'] = $equipo->dibujar_equipos('e.id='.$equipo_id, 'todos', array('titulo'));
		
		$equipos_seleccionados = '';
		$primer_ciclo = TRUE;
		
		foreach($_SESSION['equipos_out'] as $equipo2)
			if ($primer_ciclo)
			{
				$equipos_seleccionados .= ' AND e.id<>'.$equipo2['id'];
				$primer_ciclo = FALSE;
			}
			else
				$equipos_seleccionados .= ' AND e.id<>'.$equipo2['id'];
		
		$data['equipos'] = $equipo->dibujar_equipos('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id.$equipos_seleccionados.'
																					 			AND e.equipos_tipos_id='.$equipo->tipo_equipo_id, 'todos', array('titulo'), 'cambiar', $equipo_id);

		$data['titulo'] = 'Cambiar Equipo al Alquiler';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_alquiler_cambiar_equipo', $data);				
	}
	
	function alquiler_historial($alquiler_id)
	{
		$equipo = new equipo;
		
		$data['cambios'] = $equipo->listar_cambios_alquiler_historial($alquiler_id);
		$data['cambios2'] = $equipo->listar_cambios_alquiler_historial2($alquiler_id);
		
		$data['titulo'] = 'Historial';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_alquiler_historial', $data);				
	}

	function solicitar_reparacion()
	{
		acceso('secretaria');
		
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
		
		$data['menu'] = $equipo->dibujar_menu('e.equipos_estados_id=1 AND e.equipos_bodegas_id='.$bodega_id_usuario,'todos', 'seleccionar_varios');
		
		$data['titulo'] = 'Solicitar Reparacion de Equipos';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_ver', $data);				
	}
	
	function solicitar_reparacion2()
	{
		acceso('secretaria');
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			unset($_SESSION['no_borrar']);
			
			if (!isset($_POST['cliente_id']))
			{
				foreach($_SESSION['equipos_seleccionados'] as $equipo2)
					$equipo->reparacion_interna($equipo2['id'], $_POST['problema_'.$equipo2['id']]);
					
				redirect('equipos/reparaciones_pendientes');
			}
			else
			{
				foreach($_SESSION['equipos_seleccionados'] as $equipo2)
				{
					$equipo->select($equipo2['id']);
					
					if ($equipo->tipo_equipo_id == 1)
					{
						$pc = new pc_escritorio;
						$pc->select($equipo2['id']);
						$pc->observacion = $_POST['problema_'.$equipo2['id']];
						$pc->update();
					}
					else if ($equipo->tipo_equipo_id == 2)
					{
						$portatil = new portatil;
						$portatil->select($equipo2['id']);
						$portatil->observacion = $_POST['problema_'.$equipo2['id']];
						$portatil->update();
					}					
					else
					{
						$equipo->observacion = $_POST['problema_'.$equipo2['id']];
						$equipo->update();
					}
				}
				
				$nota_id = $equipo->reparacion_externa($_SESSION['equipos_seleccionados'], $_POST['cliente_id']);
				
				redirect('notas/salida_equipos/'.$nota_id);
			}		
		}
		else
		{
			$cliente = new cliente;	
				
			$this->xajax->register(XAJAX_FUNCTION, array('sugestion_clientes', $cliente,'sugestion_clientes'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_contactos', $cliente,'mostrar_contactos'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_persona', $cliente,'mostrar_info_persona'));
			$this->xajax->register(XAJAX_FUNCTION, array('mostrar_info_empresa', $cliente,'mostrar_info_empresa'));
			//$this->xajax->configure('debug', true); 
			$this->xajax->processRequest();		
			
			$data['xajax'] = $this->xajax->getJavascript();		
			
			$data['tecnicos'] = $equipo->listar_tecnicos();
			
			$data['equipos'] = $equipo->dibujar_equipos_array($_SESSION['equipos_seleccionados'], array('empresa','bodega','inventario','marca','modelo'), 
																												array('titulo','reparacion'));
			
			$data['enlace_confirmar'] = base_url().'equipos/solicitar_reparacion2';
			$data['enlace_cancelar'] = base_url().'equipos/solicitar_reparacion';
			
			$_SESSION['no_borrar'] = TRUE;
			
			$data['titulo'] = 'Solicitar Reparacion de Equipos';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_solicitar_reparacion', $data);		
		}
	}	
	
	function reparaciones_pendientes()
	{
		$equipo = new equipo;
		
		$data['reparaciones_internas'] = $equipo->listar_reparaciones_internas('P');
		$data['reparaciones_externas'] = $equipo->listar_reparaciones_externas('P');
		$data['reparaciones_externas2'] = $equipo->listar_reparaciones_externas2('P');
		
		$data['titulo'] = 'Reparaciones Pendientes';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_reparaciones', $data);			
	}
	
	function reparaciones_terminadas()
	{
		$equipo = new equipo;
		
		$data['reparaciones_internas'] = $equipo->listar_reparaciones_internas('X');
		$data['reparaciones_externas'] = $equipo->listar_reparaciones_externas('X');
		$data['reparaciones_externas2'] = $equipo->listar_reparaciones_externas2('X');
		
		$data['titulo'] = 'Reparaciones Terminadas';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_reparaciones', $data);			
	}	
	
	function reparacion($reparacion_id)
	{
		acceso('secretaria');
				
		$equipo = new equipo;
		
		$datos = $equipo->listar_datos_reparacion($reparacion_id);
		
		if ($datos->estado == 'P')
		{
			$equipo_id = $equipo->equipo_id($datos->equipos_history_id);
			
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
					
					$equipo->reparar($reparacion_id, $_POST['reparacion']);
					
					redirect('equipos/reparacion/'.$reparacion_id);	
				}
				
				$data['equipo'] = $pc;
				
				$data['reparacion'] = $equipo->listar_datos_reparacion($reparacion_id);
				
				$data['titulo'] = 'Reparar PC de Escritorio';
				
				$this->load->view('encabezado', $data);		
				$this->load->view('equipos_reparar_pc', $data);			
			}		
			else if ($equipo->tipo_equipo_id == 2)
			{
				$portatil = new portatil;
				$portatil->select($equipo_id);
				
				if (isset($_POST['guardar']))
				{
					$portatil->memoria 							= $_POST['memoria'];
					$portatil->memoria_inv					= $_POST['memoria_inv'];
					$portatil->memoria_serial 			= $_POST['memoria_serial'];
					$portatil->disco_duro 					= $_POST['disco_duro'];
					$portatil->disco_duro_inv 			= $_POST['disco_duro_inv'];
					$portatil->disco_duro_serial 		= $_POST['disco_duro_serial'];
					$portatil->unidad_optica 				= $_POST['unidad_optica'];
					$portatil->unidad_optica_inv 		= $_POST['unidad_optica_inv'];
					$portatil->unidad_optica_serial = $_POST['unidad_optica_serial'];
					$portatil->bateria_inv					= $_POST['bateria_inv'];
					$portatil->wireless							= isset($_POST['wireless'])? 1 : 0;
					$portatil->webcam								= isset($_POST['webcam'])? 1 : 0;
					$portatil->observacion				  = $_POST['observacion'];
					
					$portatil->update();
									
					$equipo->reparar($reparacion_id, $_POST['reparacion']);
					
					redirect('equipos/reparacion/'.$reparacion_id);	
				}
				
				$data['equipo'] = $portatil;
				
				$data['reparacion'] = $equipo->listar_datos_reparacion($reparacion_id);
				
				$data['titulo'] = 'Reparar Portatil';
				
				$this->load->view('encabezado', $data);		
				$this->load->view('equipos_reparar_portatil', $data);					
			}
			else
			{			
				if (isset($_POST['guardar']))
				{
					$equipo->reparar($reparacion_id, $_POST['reparacion']);
					redirect('equipos/reparacion/'.$reparacion_id);	
				}
				
				$data['reparacion'] = $equipo->listar_datos_reparacion($reparacion_id);
				
				$data['equipo'] = $equipo->dibujar_equipos('e.id='.$equipo_id, 'todos', array('observacion'));
				
				$data['equipo_id'] = $equipo_id;
				
				$data['titulo'] = 'Reparar Equipo';
				
				$this->load->view('encabezado', $data);		
				$this->load->view('equipos_reparar_equipo', $data);							
			}
		}
		else
		{
			$data['reparacion'] = $equipo->listar_datos_reparacion($reparacion_id);
			
			$equipo_id = $data['reparacion']->equipos_history_id;
			$equipo_id2 = $data['reparacion']->equipos_history_id1;
			
			$data['equipo'] = $equipo->dibujar_equipos('e.id='.$equipo_id, 'todos', array('history','observacion'));
			$data['equipo2'] = $equipo->dibujar_equipos('e.id='.$equipo_id2, 'todos', array('history','observacion'));
			
			$data['titulo'] = 'Reparacion';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_reparacion', $data);					
		}
	}
	
	function reparacion_externa($reparacion_id)
	{
		$equipo = new equipo;
		
		if (isset($_POST['guardar']))
		{
			$equipos = $equipo->listar_equipos_reparacion_externa($reparacion_id);

			$datos = $equipo->listar_datos_reparacion_externa($reparacion_id);
					
			$cliente = new cliente;		
			$cliente_id = $cliente->cliente_id($datos->clientes_personas_history_id);					
			
			foreach($equipos as $equipo2)
				$equipo->reparacion_externa2($equipo2['id'], $cliente_id, '');			
			
			$nota_id = $equipo->terminar_reparacion_externa($reparacion_id);
			
			redirect('notas/entrada_equipos/'.$nota_id);
		}	
		
		$data['reparacion'] = $equipo->listar_datos_reparacion_externa($reparacion_id);
		
		if ($data['reparacion']->estado == 'P')
			$data['boton'] = TRUE;
		
		$data['equipos'] = $equipo->dibujar_equipos_array($equipo->listar_equipos_reparacion_externa($reparacion_id), 'todos', array('titulo','observacion'));

		$data['titulo'] = 'Reparacion Externa';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('equipos_reparacion_externa', $data);		
	}
	
	function reportes()
	{
		$equipo = new equipo;
		
		if (isset($_POST['guardar']) && isset($_POST['estado']) && isset($_POST['tipo']))
		{
			$fecha = date("Y-m-d H:i:s");
			
			$this->load->dbutil();
			//$this->load->helper('file');
			
			$query = $equipo->reporte($_POST['estado'],$_POST['tipo']);
			
/*			if (!write_file('uploads/reporte.csv', $data))
				echo 'Unable to write the file';
			else
			  echo 'File written!';*/
				
			header("Content-Type: application/vnd.ms-excel; charset=utf-8");
			header("Expires: 0");
			header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
			header("Content-disposition: attachment; filename=\"reporte_".$fecha.".csv\"");				
			
			echo $this->dbutil->csv_from_result($query,",","\r\n");	
		}
		else
		{
			$data['titulo'] = 'Reportes';
			
			$this->load->view('encabezado', $data);		
			$this->load->view('equipos_reportes', $data);		
		}
	}
	
}