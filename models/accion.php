<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class accion extends CI_Model
{
	private $id;
	private $fecha;
	private $usuario_id;
	private $descripcion;
	private $url;
	
	function __construct(){ parent::__construct(); $this->fecha=date("Y-m-d H:i:s"); }
	
	function load($descripcion, $url)
	{ 
		date_default_timezone_set('America/Bogota');
		
		$this->usuario_id  = $_SESSION['usuario']['id'];
		$this->descripcion = $descripcion;
		$this->url         = $url;
	}
	
	function select($id){
		$query = $this->db->query("SELECT * FROM usuarios_acciones WHERE id='$id'");
		$datos = $query->row_array();
		
		$this->id          = $id; 
		$this->fecha       = $datos['fecha']; 
		$this->usuario_id  = $datos['usuarios_id']; 
		$this->descripcion = $datos['descripcion'];
		$this->url         = $datos['url'];
	}
	
	function insert(){
		$this->db->query("INSERT INTO usuarios_acciones 
											SET fecha       = '$this->fecha', 
													usuarios_id = '$this->usuario_id', 
													descripcion = '$this->descripcion',
													url         = '$this->url'");
													
		$this->id = $this->db->insert_id();
	}

}
?>