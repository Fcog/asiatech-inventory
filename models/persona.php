<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class persona extends CI_Model
{
	public $id;
	public $history_id;
	public $nombre;
	public $cedula;
	public $direccion;
	public $email;
	public $fecha_ingreso;
	public $telefono;
	public $celular;
	public $ciudad;
	public $cargo;
	public $area;
	public $empresa_id;
	public $empresa_history_id;
	
	function __construct(){ parent::__construct(); $this->fecha_ingreso=date("Y-m-d"); }	
	
	function load_natural($nombre, $cedula, $direccion, $telefono, $celular, $email, $ciudad)
	{
		$this->nombre    = ucwords(mb_strtolower($nombre,'UTF-8')); 
		$this->cedula    = str_replace(" ", "",$cedula); 
		$this->direccion = $direccion; 
		$this->email     = mb_strtolower($email,'UTF-8'); 
		$this->telefono  = str_replace(" ", "",$telefono); 
		$this->celular   = str_replace(" ", "",$celular); 
		$this->ciudad = ucwords(mb_strtolower($ciudad,'UTF-8')); 
	}
	
	function load_contacto($nombre, $cedula, $telefono, $celular, $email, $area, $cargo, $empresa_id, $empresa_history_id)
	{
		$this->nombre     = ucwords(mb_strtolower($nombre,'UTF-8')); 
		$this->cedula     = str_replace(" ", "",$cedula); 
		$this->email      = mb_strtolower($email,'UTF-8'); 
		$this->telefono   = str_replace(" ", "",$telefono); 
		$this->celular    = str_replace(" ", "",$celular);
		$this->cargo      = ucwords(mb_strtolower($cargo,'UTF-8'));
		$this->area       = ucwords(mb_strtolower($area,'UTF-8'));	
		$this->empresa_id = $empresa_id;
		$this->empresa_history_id = $empresa_history_id;
	}
	
	function select($id)
	{
		$query = $this->db->query("SELECT * FROM clientes_personas WHERE id='$id'");
		
		$datos = $query->row_array();
		
		$this->id            = $id;
		$this->nombre        = $datos['nombre']; 
		$this->cedula        = $datos['cedula']; 
		$this->fecha_ingreso = $datos['fecha_ingreso'];
	 	$this->direccion     = $datos['direccion'];
	 	$this->email         = $datos['email']; 
	 	$this->telefono      = $datos['telefono']; 
	 	$this->celular       = $datos['celular']; 
		$this->ciudad        = $datos['ciudad']; 
		$this->cargo         = $datos['cargo']; 
		$this->area          = $datos['area'];
	}
	
	function insert_persona()
	{
		$this->db->trans_start();
		
		$this->db->query("INSERT INTO clientes_personas 
											SET nombre        = '$this->nombre', 
													cedula        = '$this->cedula', 
													direccion     = '$this->direccion', 
													email         = '$this->email',
													telefono      = '$this->telefono', 
													fecha_ingreso = '$this->fecha_ingreso', 
													celular       = '$this->celular', 
													ciudad        = '$this->ciudad',
													clientes_empresas_id   = null");
											
		$this->id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO clientes_personas_history
											SET nombre       					 = '$this->nombre', 
													cedula       					 = '$this->cedula', 
													direccion    					 = '$this->direccion', 
													email        				   = '$this->email',
													telefono      				 = '$this->telefono', 
													fecha_ingreso 				 = '$this->fecha_ingreso', 
													celular       				 = '$this->celular', 
													ciudad        				 = '$this->ciudad',
													clientes_empresas_history_id   = null,
													clientes_personas_id 	 = $this->id");		
		
		$accion = new accion;
		$accion->load('Agregó un cliente', 'clientes/ver_persona/'.$this->id);
		$accion->insert();
		
		$this->db->trans_complete();
	}
	
	function insert_contacto()
	{
		$this->db->query("INSERT INTO clientes_personas 
											SET nombre			        	= '$this->nombre',
													cedula 			          = '$this->cedula', 
													email 			         	= '$this->email', 
													telefono 			        = '$this->telefono',
													fecha_ingreso         = '$this->fecha_ingreso', 
													celular 			        = '$this->celular', 
													ciudad			          = null, 
													cargo 				        = '$this->cargo', 
													area 					        = '$this->area', 
													clientes_empresas_id 	= '$this->empresa_id'");

		$this->id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO clientes_personas_history
											SET nombre       									 = '$this->nombre', 
													cedula       									 = '$this->cedula', 
													direccion    									 = '$this->direccion', 
													email        				 				   = '$this->email',
													telefono      								 = '$this->telefono', 
													fecha_ingreso 								 = '$this->fecha_ingreso', 
													celular       								 = '$this->celular', 
													ciudad        								 = null,
													cargo 												 = '$this->cargo', 
													area 					  							 = '$this->area', 													
													clientes_empresas_history_id   = $this->empresa_history_id,
													clientes_personas_id 	         = $this->id");				

		$this->history_id = $this->db->insert_id();

		$accion = new accion;
		$accion->load('Agregó un contacto', 'clientes/ver_persona/'.$this->id);
		$accion->insert();		
	}
	
	function update_persona()
	{
		$this->db->query("UPDATE clientes_personas 
											SET direccion = '$this->direccion', 
													email     = '$this->email', 
													telefono  = '$this->telefono', 
													celular   = '$this->celular',
													ciudad    = '$this->ciudad' 
										  WHERE id='$this->id'");
	}
	
	function update_contacto()
	{
		$this->db->query("UPDATE clientes_personas 
											SET direccion='$this->direccion', 
												  email='$this->email', 
												  telefono='$this->telefono', 
												  celular='$this->celular',
												  cargo='$this->cargo', 
												  area='$this->area', 
												  empresas_id='$this->empresa_id' 
											WHERE id='$this->id'");
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------------------------------------------------
	// VER CLIENTES
	
	function listar()
	{
		$query = $this->db->query("SELECT id, nombre FROM clientes_personas WHERE ISNULL(clientes_empresas_id) ORDER BY nombre");
		return $query->result_array();
	}
	
	function listar_contactos($empresa_id)
	{
		$query = $this->db->query("SELECT id, nombre FROM clientes_personas WHERE clientes_empresas_id=$empresa_id ORDER BY nombre");
		return $query->result();
	}
		
	function listar_datos($persona_id)
	{
			$query = $this->db->query("SELECT p.*, e.nombre as empresa
														     FROM clientes_personas p
																 JOIN clientes_empresas e ON e.id = p.clientes_empresas_id
																 WHERE p.id='$persona_id'");
			return $query->row();
	}	
	
	function check($algo)
	{
		if ($this->$algo!="")
		{
			switch ($algo)
			{
				case "nombre":
					$query=$this->db->query("SELECT nombre FROM clientes_personas WHERE nombre='$this->nombre'");		
					break;
				case "cedula":
					$query=$this->db->query("SELECT cedula FROM clientes_personas WHERE cedula='$this->cedula'");	
					break;
				case "email":
					$query=$this->db->query("SELECT email FROM clientes_personas WHERE email='$this->email'");	
					break;
				case "telefono":
					$query=$this->db->query("SELECT telefono FROM clientes_personas WHERE telefono='$this->telefono'");	
					break;
				case "celular":
					$query=$this->db->query("SELECT celular FROM clientes_personas WHERE celular='$this->celular'");	
					break;						
				default:
					break;		
			}
			
			return ($query->num_rows() >0);
		}
		else
			return false;
	
	}
	
	//--------------------------------------------------------------------------------------------------------------------------------------------
	//--------------------------------------------------------------------------------------------------------------------------------------------
	// AGREGAR CLIENTE PERSONA
	
	//--------------------------------------------------------------------------------- NOMBRE PERSONA ---------------------------------------------
	function verificar_nombre_key($entrada)
	{
		$this->setNombre($entrada);
		
		if ($this->check('nombre'))
			$salida = 'Advertencia: Este nombre ya existe';
		else
			$salida = "";
				
		$respuesta = new xajaxResponse();
		$respuesta->assign("nombre_info","className","validacion2");
		$respuesta->assign('nombre_info',"innerHTML",$salida);
		
		return $respuesta;
	}
	
	/*function verificar_nombre_blur($entrada)
	{	
		switch ($entrada)
		{
			case "":
				$salida = 'El nombre es obligatorio';
				$salida .= '<input type="hidden" name="error_nombre" id="error_nombre">';	
				$respuesta->assign("nombre_info","className","validacion");		
				break;
			default:
				$salida = '';		
		}
	
		$respuesta->assign('nombre_info',"innerHTML",$salida);
		
		return $respuesta;		
	}*/
	
	//--------------------------------------------------------------------------------- CEDULA PERSONA ---------------------------------------------
	
	function verificar_cedula_key($entrada)
	{
		$this->setCedula($entrada);
		
		if ($this->check('cedula'))
		{
			$salida = 'Esta cedula ya existe';
			$salida .= '<input type="hidden" name="error_cedula" id="error_cedula">';		
		}
		else
			$salida = "";
		
		$respuesta = new xajaxResponse();
		$respuesta->assign('cedula_info',"innerHTML",$salida);
		$respuesta->assign("cedula_info","className","validacion");
			
		return $respuesta;	
	}
	
	function verificar_cedula_blur($entrada)
	{	
		$respuesta = new xajaxResponse();
		
		$cedula_largo = strlen(str_replace(" ", "",$entrada));
		
		if ((0 < $cedula_largo && $cedula_largo < 6) || $cedula_largo > 10)
		{
			$salida = 'El largo de la cedula es incorrecto';
			$salida .= '<input type="hidden" name="error_cedula" id="error_cedula">';
			
			$respuesta->assign('cedula_info',"innerHTML",$salida);
			$respuesta->assign("cedula_info","className","validacion");
			
			return $respuesta;								
		}
		else
			$respuesta->assign('cedula_info',"innerHTML",'');
			
		return $respuesta;	
	}
	
	//--------------------------------------------------------------------------------- TELEFONO ---------------------------------------------
	
	function verificar_tel_key($entrada)
	{
		$this->setTelefono($entrada);
		
		if ($this->check('telefono'))
			$salida = 'Advertencia: Este telefono ya existe';
		else
			$salida = "";
			
		$respuesta = new xajaxResponse();
		$respuesta->assign("tel_info","className","validacion2");
		$respuesta->assign('tel_info',"innerHTML",$salida);
			
		return $respuesta;		
	}
	
	function verificar_tel_blur($entrada)
	{	
		$respuesta = new xajaxResponse();
		
		$tel_largo = strlen(str_replace(" ", "",$entrada));
	
		if ((0 < $tel_largo && $tel_largo < 7) || $tel_largo > 10)
		{
			$salida = 'El largo del telefono es incorrecto';
			$salida .= '<input type="hidden" name="error_tel" id="error_tel">';			
	
			$respuesta->assign("tel_info","className","validacion");
			$respuesta->assign('tel_info',"innerHTML",$salida);
			
				
		}
		else
			$respuesta->assign('tel_info',"innerHTML",'');
			
		return $respuesta;
	}
	
	//--------------------------------------------------------------------------------- CELULAR ---------------------------------------------
	
	function verificar_cel_key($entrada)
	{
		$this->setCelular($entrada);
		
		if ($this->check('celular'))
			$salida = 'Advertencia: Este celular ya existe';
		else
			$salida = "";
	
		$respuesta = new xajaxResponse();
		$respuesta->assign("cel_info","className","validacion2");
		$respuesta->assign('cel_info',"innerHTML",$salida);
			
		return $respuesta;		
	}
	
	function verificar_cel_blur($entrada)
	{
		$cel_largo = strlen(str_replace(" ", "",$entrada));
		
		if ((0 < $cel_largo && $cel_largo < 7) || $cel_largo > 10)
		{
			$salida = 'El largo del celular es incorrecto';
			$salida .= '<input type="hidden" name="error_cel" id="error_cel">';			
	
			$respuesta = new xajaxResponse();
			$respuesta->assign("cel_info","className","validacion");
			$respuesta->assign('cel_info',"innerHTML",$salida);
		
			return $respuesta;
		}		
	}
	
	//--------------------------------------------------------------------------------- EMAIL ---------------------------------------------
	
	function verificar_email($entrada)
	{
		$this->setEmail($entrada);
		
		switch ($entrada)
		{
			case "":
				$salida = '';			
				break;			
			case !preg_match('/^([a-z0-9])(([-a-z0-9._])*([a-z0-9]))*\@([a-z0-9])*(\.([a-z0-9])([-a-z0-9_-])([a-z0-9])+)*$/i', $entrada):
				$salida = 'El email está mal escrito';
				$salida .= '<input type="hidden" name="error_email" id="error_email">';	
				break;
			case $this->check('email'):	
				$salida = 'Este email ya existe';
				$salida .= '<input type="hidden" name="error_email" id="error_email">';	
				break;
			default:
				$salida = '';	
		}
		
		$respuesta = new xajaxResponse();
		$respuesta->assign("email_info","className","validacion");	
		$respuesta->assign('email_info',"innerHTML",$salida);
		
		return $respuesta;		
	}	
}
?>