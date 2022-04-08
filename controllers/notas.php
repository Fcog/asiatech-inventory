<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notas extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->db->query("SET lc_time_names = 'es_MX'");	
	}
	
	function listar_nea()
	{
		$nota = new nota;
		
		$data['notas'] = $nota->listar_nea();
		$data['onclick'] = base_url().'notas/nea/';
		
		$data['titulo'] = 'Notas Entrada Almacen';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('nea', $data);			
	}

	function listar_nsa()
	{
		$nota = new nota;
		
		$data['notas'] = $nota->listar_nsa();
		$data['onclick'] = base_url().'notas/nea/';
		
		$data['titulo'] = 'Notas Salida Almacen';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('nsa', $data);			
	}
	
	function entrada_equipos($nea_id)
	{
		$nota = new nota;
		$equipos = new equipo;
		
		$data['nota_datos'] = $nota->listar_datos_nea($nea_id);
		$data['nota_equipos'] = $equipos->dibujar_equipos_array($nota->listar_equipos_nea($nea_id), 
																														array('inventario','serial','marca','modelo','caract'), 
																														array('titulo','history'));

		$data['cliente'] = isset($data['nota_datos']->persona)? isset($data['nota_datos']->empresa)?  $data['nota_datos']->empresa : $data['nota_datos']->persona :
											 $data['nota_datos']->sede;
		if (!isset($data['nota_datos']->persona)) $data['cliente'] .= ($data['nota_datos']->sede_ciudad == 'Cali')? ' Bogotá' : ' Cali';
		
		$data['enlace'] = 'entrada_equipos';
		
		$data['titulo'] = 'Nota Entrada Almacen';
		
		if (isset($_POST['word']))
		{
			$data['mostrar_botones'] = false;
					
			header("Content-Type: application/vnd.ms-word; charset=utf-8");
			header("Expires: 0");
			header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
			header("Content-disposition: attachment; filename=\"nota_entrada_equipos_".$nea_id.".doc\"");
		
			$this->load->view("metatag");					
		}
		else if (isset($_POST['imprimir']))
		{
			$data['mostrar_botones'] = false;
			$this->load->view("metatag");	
		}
		else			
			$this->load->view('encabezado', $data);		
			
		$this->load->view('nota_formato', $data);			
	}
	
	function salida_equipos($nsa_id)
	{
		$nota = new nota;
		$equipos = new equipo;
			
		$data['nota_datos'] = $nota->listar_datos_nsa($nsa_id);
		$data['nota_equipos'] = $equipos->dibujar_equipos_array($nota->listar_equipos_nsa($nsa_id), 
																														array('inventario','serial','marca','modelo','caract'),
																														array('titulo','history','observacion'));
		
		if ($data['nota_datos']->descripcion != 'Baja de equipos' || isset($data['nota_datos']->persona))
		{
			$data['cliente'] = isset($data['nota_datos']->persona)? isset($data['nota_datos']->empresa)?  $data['nota_datos']->empresa : $data['nota_datos']->persona :
												 $data['nota_datos']->sede;
			if (!isset($data['nota_datos']->persona)) $data['cliente'] .= ($data['nota_datos']->sede_ciudad == 'Cali')? ' Bogotá' : ' Cali';
		}
		else $data['cliente'] = 'Equipos dados de baja';

		$data['enlace'] = 'salida_equipos';

		$data['titulo'] = 'Nota Salida Almacen';

		if (isset($_POST['word']))
		{
			$data['mostrar_botones'] = false;
					
			header("Content-Type: application/vnd.ms-word; charset=utf-8");
			header("Expires: 0");
			header("Cache-Control:  must-revalidate, post-check=0, pre-check=0");
			header("Content-disposition: attachment; filename=\"nota_salida_equipos_".$nsa_id.".doc\"");
		
			$this->load->view("metatag");					
		}
		else if (isset($_POST['imprimir']))
		{
			$data['mostrar_botones'] = false;
			$this->load->view("metatag");	
		}
		else			
			$this->load->view('encabezado', $data);		
			
		$this->load->view('nota_formato', $data);			
	}	
	
	
}

?>