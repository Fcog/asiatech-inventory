<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class empresa extends CI_Model
{
	public $id;
	public $history_id;
	public $nombre;
	public $nit;
	public $fecha_ingreso;
	public $telefono;
	public $direccion;
	public $ciudad;
	public $pagina_web;
	
	function __construct(){ parent::__construct(); $this->fecha_ingreso=date("Y-m-d"); }	
	
	function load($nombre, $nit, $telefono, $direccion, $ciudad, $pagina_web)
	{
		$this->nombre     = ucwords(mb_strtolower($nombre,'UTF-8'));
		$this->nit        = str_replace(" ", "",$nit); 
		$this->telefono   = str_replace(" ", "",$telefono); 
		$this->direccion  = ucwords(mb_strtolower($direccion,'UTF-8')); 
		$this->ciudad     = $ciudad;	
		$this->pagina_web = mb_strtolower($pagina_web,'UTF-8');
	}
	
	function select($id)
	{
		$query = $this->db->query("SELECT * FROM clientes_empresas WHERE id='$id'");
		
		$datos = $query->row_array();
		
		$this->id					= $id;
		$this->nombre			= $datos['nombre']; 
		$this->nit				= $datos['nit']; 
		$this->telefono		= $datos['telefono']; 
		$this->direccion  = $datos['direccion']; 
		$this->pagina_web = $datos['pagina_web']; 
		$this->ciudad			= $datos['ciudad']; 
	}
	
	function insert()
	{
		$q="INSERT INTO clientes_empresas 
				SET nombre				= '$this->nombre', 
						nit						= '$this->nit', 
						fecha_ingreso = '$this->fecha_ingreso', 
						direccion			= '$this->direccion',
			 			ciudad				= '$this->ciudad', 
						pagina_web		= '$this->pagina_web'";
		
		if ($this->telefono!='')
			$q .= ", telefono = '$this->telefono'";
			
		$this->db->query($q);	
		
		$this->id = $this->db->insert_id();
		
		$this->db->query("INSERT INTO clientes_empresas_history
											SET nombre							 = '$this->nombre', 
													nit									 = '$this->nit', 
													fecha_ingreso 			 = '$this->fecha_ingreso', 
													direccion						 = '$this->direccion',
													ciudad							 = '$this->ciudad', 
													pagina_web					 = '$this->pagina_web',
													clientes_empresas_id = $this->id");
		
		$this->history_id = $this->db->insert_id();
		
		$accion = new accion;
		$accion->load('Agregó un cliente', 'clientes/ver_empresa/'.$this->id);
		$accion->insert();			
	}
	
	function update()
	{
		$this->db->query("UPDATE clientes_empresas 
											SET nombre     = '$this->nombre', 
													nit        = '$this->nit', 
													telefono   = '$this->telefono', 
													direccion  = '$this->direccion', 
													ciudad     = '$this->ciudad', 
													pagina_web = '$this->pagina_web' 
											WHERE id = '$this->id'"); /*or die ("MySQL Error: ".mysql_error());*/
	}
	
	function history_id($empresa_id)
	{
		$q = $this->db->query("SELECT id FROM clientes_empresas_history WHERE clientes_empresas_id=$empresa_id ORDER BY id DESC LIMIT 1");
		
		return $q->row()->id;
	}
	
	function listar()
	{
		$query = $this->db->query("SELECT id, nombre FROM clientes_empresas ORDER BY nombre");
		return $query->result_array();
	}

	function listar_datos($empresa_id)
	{		
		$query = $this->db->query("SELECT * FROM clientes_empresas WHERE id=$empresa_id");																
		return $query->row();
	}	

	function listar_nea($empresa_id)
	{
		$empresa_id = $this->history_id($empresa_id);
		
		$res = $this->db->query("SELECT n.* 
														 FROM nota_entrada_almacen n
														 JOIN clientes_personas_history p ON p.id = n.clientes_personas_history_id 
														 WHERE p.clientes_empresas_history_id = $empresa_id");
		return $res->result();
	}
	
	function listar_nsa($empresa_id)
	{
		$empresa_id = $this->history_id($empresa_id);
		
		$res = $this->db->query("SELECT n.* 
														 FROM nota_salida_almacen n
														 JOIN clientes_personas_history p ON p.id = n.clientes_personas_history_id 
														 WHERE p.clientes_empresas_history_id = $empresa_id");
		return $res->result();
	}	

	//--------------------------------------------------------------------------------------------------------------------------------------------------------------
	//------------------------------------------------------------------------- VERIFICAR DATOS EMPRESA ------------------------------------------------------------
	
	function check($algo)
	{
		if ($this->$algo!="")
		{	
			switch ($algo)
			{
				case "nombre":
					$query = $this->db->query("SELECT nombre FROM clientes_empresas WHERE nombre='$this->nombre'");		
					break;
				case "nit":
					$query = $this->db->query("SELECT nit FROM clientes_empresas WHERE nit='$this->nit'");	
					break;
				case "telefono":
					$query = $this->db->query("SELECT telefono FROM clientes_empresas WHERE telefono='$this->telefono'");	
					break;					
				default:
					$salida = '';		
			}
			
			return ($query->num_rows() > 0);
		}
		else
			return false;			
	}	
	
	function validar_nit()
	{	
		$nit = substr($this->nit, 0, strlen($this->nit)-2);
		$dv = substr($this->nit,-1);
	
		//----------------------------------algoritmo de validacion del nit -------------------------------	
		$pesos = array(71,67,59,53,47,43,41,37,29,23,19,17,13,7,3);	
		$suma = 0;
		$relleno = '';
			
		for ($i=1; $i < 15; $i++)
		{
			$total_char = strlen($nit) + $i;
			if ($total_char <= 15)
				$relleno .= "0";
			else
				break;
		}
	
		$nit_fmt = $relleno.$nit;				
		
		for ($i=0; $i<=14; $i++)
			$suma += substr($nit_fmt, $i, 1) * $pesos[$i];
			
		$resto = $suma % 11;
		
		if ($resto == 0 || $resto == 1)
			$digitov = $resto;
		else
			$digitov = 11 - $resto;
		//-----------------------------------------------------------------------------------------------------		
	
		if ($digitov==$dv)
			return true;
		else
			return false;	
	}
	
	function verificar_nombre_empresa_key($entrada)
	{
		$this->nombre = $entrada;
		
		if ($this->check('nombre'))
		{
			$salida = 'Este nombre ya existe';
			$salida .= '<input type="hidden" name="error_nombre_empresa" id="error_nombre_empresa">';
		}
		else
			$salida = "";
				
		$respuesta = new xajaxResponse();
		$respuesta->assign("nombre_empresa_info","className","validacion");	
		$respuesta->assign('nombre_empresa_info',"innerHTML",$salida);
		
		return $respuesta;			
	}
	
	/*function verificar_nombre_empresa_blur($entrada)
	{	
		switch ($entrada)
		{
			case "":
				$salida = 'El nombre es obligatorio';
				$salida .= '<input type="hidden" name="error_nombre_empresa" id="error_nombre_empresa" value="1">';	
				$respuesta->assign("nombre_empresa_info","className","validacion");		
				break;
			default:
				$salida = '';		
		}
	
		$respuesta->assign('nombre_empresa_info',"innerHTML",$salida);
		
		return $respuesta;		
	}
	*/
	
	function verificar_nit_key($entrada)
	{
		$nit_largo = strlen(str_replace(" ", "",$entrada));
		$this->nit = $entrada;
		
		switch ($entrada)
		{	
			case "":
				$salida = "";
				break;		
			case $nit_largo == 11 && !$this->validar_nit():
				$salida = 'El NIT es incorrecto';
				$salida .= '<input type="hidden" name="error_nit" id="error_nit">';	
				break;				
			case $nit_largo == 11 && $this->check('nit'):
				$salida = 'Este NIT ya existe';
				$salida .= '<input type="hidden" name="error_nit" id="error_nit">';	
				break;			
			default:
				$salida = "";
				break;		
		}
		
		$respuesta = new xajaxResponse();
		$respuesta->assign("nit_info","className","validacion");
		$respuesta->assign('nit_info',"innerHTML",$salida);
		
		return $respuesta;	
	}
	
/*	function verificar_nit_blur($entrada)
	{
		$nit_largo = strlen(str_replace(" ", "",$entrada));
		$salida = '';
		
		if ($nit_largo != 0 && $nit_largo != 10)
		{
				$salida .= 'El largo del NIT es incorrecto';
				$salida .= '<input type="hidden" name="error_nit" id="error_nit">';						
		}
	
		$respuesta = new xajaxResponse();
		$respuesta->assign("nit_info","className","validacion");
		$respuesta->assign('nit_info',"innerHTML",$salida);
		
		return $respuesta;		
	}*/
	
	function verificar_tel_empresa_key($entrada)
	{
		$this->setTelefono($entrada);
		
		if ($this->check('telefono'))
		{
			$salida = 'Este telefono ya existe';
			$salida .= '<input type="hidden" name="error_tel_empresa" id="error_tel_empresa">';
		}
		else
			$salida = "";
		
		$respuesta = new xajaxResponse();
		$respuesta->assign("tel_empresa_info","className","validacion");
		$respuesta->assign('tel_empresa_info',"innerHTML",$salida);
	
		return $respuesta;		
	}
	
	function verificar_tel_empresa_blur($entrada)
	{	
		$tel_largo = strlen(str_replace(" ", "",$entrada));
	
		if ((0 < $tel_largo && $tel_largo < 7) || $tel_largo > 10)
		{
			$salida = 'El largo del telefono es incorrecto';
			$salida .= '<input type="hidden" name="error_tel_empresa" id="error_tel_empresa">';			
		
			$respuesta = new xajaxResponse();
			$respuesta->assign("tel_empresa_info","className","validacion");
			$respuesta->assign('tel_empresa_info',"innerHTML",$salida);
			
			return $respuesta;
		}		
	}
	
	
	//--------------------------------------------------------------------------------------------------------------------------------
	// Para agregar_cliente_contacto.php - Sugestion de empresa
	function sugestion_empresa($algo, $posx, $posy)
	{
		$resp=new xajaxResponse();
		
		if ($algo!='')
		{
			$query = $this->db->query("SELECT distinct(nombre) as empresa, id FROM clientes_empresas WHERE nombre like ('$algo%') ORDER BY nombre");
			
			$salida='';
	
			foreach ($query->result_array() as $row)
				$salida .= '<div class="sugestiones" 
							onclick="document.getElementById(\'buscar\').value = this.innerHTML; 
									document.getElementById(\'sugestion_container\').style.display=\'none\';
									e = document.getElementById(\'bloqueo\');
									e.parentNode.removeChild(e);
									guardar_id(\''.$row['id'].'\');">'.$row['empresa'].'</div>';
			
			if ($query->num_rows() > 0)
				$resp->assign('sugestion_container', "style.display", 'block');
			else
				$resp->assign('sugestion_container', "style.display", 'none');			
	
			$salida .= '<input type="hidden" name="empresa_id" id="empresa_id" value="'.$row['id'].'"';
	
			$resp->assign('sugestion_container', "innerHTML", $salida);	
		}
		else
			$resp->assign('sugestion_container', "style.display", 'none');
	
		$resp->assign('sugestion_container', "style.position", 'absolute');	
		$resp->assign('sugestion_container', "style.left", $posx.'px');
		$resp->assign('sugestion_container', "style.top", $posy.'px');
				
		return $resp;     	
	}
	
}
?>