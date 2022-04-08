<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class log_user extends CI_Controller
{
	public function index()
	{
		$data['aviso'] = '';
		
		if (count($_POST)) 
		{
			$username = mysql_escape_string(trim($_POST['login']));
			$clave = mysql_escape_string(trim($_POST['clave']));
			
			$query = $this->db->query("SELECT u.*, b.nombre as bodega
																 FROM usuarios u
																 JOIN equipos_bodegas b ON b.id = u.equipos_bodegas_id
																 WHERE username	= '$username'");
			
			if ($query->num_rows > 0)
			{
				$row = $query->row();
				$clave_correcta = $row->clave;
				$suciedad = $row->sal;
				$clave_dada = md5($clave.$suciedad);	
				
				if ($clave_correcta == $clave_dada)
				{
					$newdata = array(
										 'nombre'  => $row->nombre,
										 'id'      => $row->id,
										 'acceso'  => $row->acceso,
										 'sede_id' => $row->sedes_id,
										 'bodega_id' => $row->equipos_bodegas_id,
										 'bodega'  => $row->bodega
								 );
								 
					$_SESSION['usuario'] = $newdata;
					
					redirect('principal');
				}
				else
					$data['aviso'] = 'Clave incorrecta';
			}
			else
					$data['aviso'] = 'Usuario incorrecto';
		}
		
		$this->load->view('login_view', $data);
	}
	
	public function out()
	{
		session_destroy();
		$data['aviso'] = '';
		$this->load->view('login_view', $data);
	}
	
	function no_autorizado()
	{
		$data['titulo'] = 'No autorizado';
		
		$this->load->view('encabezado', $data);			
		$this->load->view('no_autorizado');
	}
}
?>