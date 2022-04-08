<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class clientes extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		acceso();
			
		$this->db->query("SET lc_time_names = 'es_MX'");	
			
		$this->load->library('xajax');
		$this->xajax->configure("javascript URI", base_url());
	}
	
	// ver clientes
	function index()
	{
		$empresa = new empresa();
		$persona = new persona();
				
		$this->xajax->register(XAJAX_FUNCTION, array('ver_detalles_contacto', $persona,'ver_detalles_contacto'));
		$this->xajax->register(XAJAX_FUNCTION, array('ver_detalles_persona', $persona,'ver_detalles_persona'));	
		//$this->xajax->configure('debug', true); 
		//$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();
		
		$data['empresas'] = $empresa->listar();
		$data['personas'] = $persona->listar();

		$data['titulo'] = 'Ver clientes';
		
		$this->load->view('encabezado', $data);				
		$this->load->view('clientes_ver', $data);
	}
	
	function ver_empresa($empresa_id)
	{
		$empresa = new empresa();
		$persona = new persona();
		
		$data['empresa'] = $empresa->listar_datos($empresa_id);
		$data['contactos'] = $persona->listar_contactos($empresa_id);
		$data['nea'] = $empresa->listar_nea($empresa_id);
		$data['nsa'] = $empresa->listar_nsa($empresa_id);
		
		$data['titulo'] = 'Datos Empresa';
		
		$this->load->view('encabezado', $data);				
		$this->load->view('clientes_empresa', $data);		
	}
	
	function ver_persona($persona_id)
	{
		$persona = new persona();
		
		$data['persona'] = $persona->listar_datos($persona_id);
		
		$data['titulo'] = 'Datos Persona';
		
		$this->load->view('encabezado', $data);				
		$this->load->view('clientes_persona', $data);		
	}	
	
	function agregar_persona()
	{
		if (isset($_POST['guardar']))
		{
			//if($_SESSION['token'] == $_POST['token'])
			//{
			//	unset($_SESSION['token']);

				$persona = new persona;
				$persona->load_natural($_POST['nombre'], $_POST['cedula'], $_POST['direccion'], $_POST['tel'], $_POST['cel'], $_POST['email'], $_POST['ciudad']);
				$persona->insert_persona();
				
				//redirect('clientes/ver_persona/'.$persona->id);	
			//}
		}		
				
		acceso('secretaria');
		
		$persona = new persona();
		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_nombre_key', $persona,'verificar_nombre_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cedula_key', $persona,'verificar_cedula_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cedula_blur', $persona,'verificar_cedula_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_key', $persona,'verificar_tel_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_blur', $persona,'verificar_tel_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cel_key', $persona,'verificar_cel_key'));	
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cel_blur', $persona,'verificar_cel_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_email', $persona,'verificar_email'));
		//$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();

		$data['titulo'] = 'Agregar Persona';
		
		$this->load->view('encabezado', $data);			
		$this->load->view('cliente_agregar_persona', $data);
	}
	
	function agregar_empresa()
	{
		acceso('secretaria');
				
		$persona = new persona();
		$empresa = new empresa();
		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_nombre_key', $persona,'verificar_nombre_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cedula_key', $persona,'verificar_cedula_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cedula_blur', $persona,'verificar_cedula_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_key', $persona,'verificar_tel_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_blur', $persona,'verificar_tel_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cel_key', $persona,'verificar_cel_key'));	
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cel_blur', $persona,'verificar_cel_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_email', $persona,'verificar_email'));
		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_nombre_empresa_key', $empresa,'verificar_nombre_empresa_key'));		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_empresa_key', $empresa,'verificar_tel_empresa_key'));		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_empresa_blur', $empresa,'verificar_tel_empresa_blur'));		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_nit_key', $empresa,'verificar_nit_key'));	
		$this->xajax->register(XAJAX_FUNCTION, array('sugestion_empresa', $empresa,'sugestion_empresa'));					
		//$this->xajax->configure('debug', true); 							
		//$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();		
		
		if (isset($_POST['guardar']))
		{
			//if($_SESSION['ficha'] == $_POST['ficha'])
			//{
			//	unset($_SESSION['ficha']);
				
				$this->db->trans_start();
					
				$empresa = new empresa;
				$empresa->load($_POST['nombre_empresa'], $_POST['nit'], $_POST['tel_empresa'], $_POST['direccion'], $_POST['ciudad'], $_POST['pagina_web']);
				
				$empresa->insert();
				
				$persona = new persona;
				$persona->load_contacto($_POST['nombre'], $_POST['cedula'], $_POST['tel'], $_POST['cel'], $_POST['email'], $_POST['area'], $_POST['cargo'], $empresa->id,
																$empresa->history_id);		
					
				$persona->insert_contacto();

				$this->db->trans_complete();
				
				//redirect('clientes/ver_empresa/'.$empresa->id);
			//}
		}		
		$data['titulo'] = 'Agregar Empresa';
		
		$this->load->view('encabezado', $data);				
		$this->load->view('cliente_agregar_empresa', $data);
	}
	
	function agregar_contacto()
	{
		acceso('secretaria');
						
		$persona = new persona();
		$empresa = new empresa();
		
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_nombre_key', $persona,'verificar_nombre_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cedula_key', $persona,'verificar_cedula_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cedula_blur', $persona,'verificar_cedula_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_key', $persona,'verificar_tel_key'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_tel_blur', $persona,'verificar_tel_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cel_key', $persona,'verificar_cel_key'));	
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_cel_blur', $persona,'verificar_cel_blur'));
		$this->xajax->register(XAJAX_FUNCTION, array('verificar_email', $persona,'verificar_email'));
		$this->xajax->register(XAJAX_FUNCTION, array('sugestion_empresa', $empresa,'sugestion_empresa'));
		//$this->xajax->processRequest();		
		
		$data['xajax'] = $this->xajax->getJavascript();		
		
		if (isset($_POST['guardar']))
		{
			//if($_SESSION['ficha'] == $_POST['ficha'])
			//{
			//	unset($_SESSION['ficha']);
				
				$this->db->trans_start();
				
				$empresa = new empresa;
				$persona = new persona;
				$persona->load_contacto($_POST['nombre'], $_POST['cedula'], $_POST['tel'], $_POST['cel'], $_POST['email'], $_POST['area'], $_POST['cargo'], 
																$_POST['empresa_id'], $empresa->history_id($_POST['empresa_id']));
				$persona->insert_contacto();
							
				$this->db->trans_complete();
				
				//redirect('clientes/ver_persona/'.$persona->id);
			//}
		}		

		$data['titulo'] = 'Agregar Contacto';
		
		$this->load->view('encabezado', $data);				
		$this->load->view('cliente_agregar_contacto', $data);
	}
}

?>	