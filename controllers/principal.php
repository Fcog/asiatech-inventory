<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class principal extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		acceso();
		$this->db->query("SET lc_time_names = 'es_MX'");	
	}
	
	function index()
	{
		$data['usuario'] = $_SESSION['usuario']['nombre'];
		
		$equipo = new equipo;
		
		$data['solicitudes_traslado'] = $equipo->listar_solicitudes_traslado2();
		$data['en_traslado'] = $equipo->listar_en_traslado2();
		$data['alquileres'] = $equipo->listar_alquileres_vigentes2();
		$data['reparaciones_internas'] = $equipo->listar_reparaciones_internas('P');
		$data['reparaciones_externas'] = $equipo->listar_reparaciones_externas('P');
		$data['reparaciones_externas2'] = $equipo->listar_reparaciones_externas2('P');
		
		if (permiso('superadmin')) $data['dar_de_baja'] = $equipo->listar_solicitudes_de_baja2();
		
		$data['titulo'] = 'Principal';
		
		$this->load->view('encabezado', $data);		
		$this->load->view('principal_view', $data);
	}

}
?>