<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class usuario extends CI_Model
{
	public $id;
	public $username;
	public $clave;
	public $sal;	
	public $nombre;
	public $acceso;
	public $fecha_ingreso;
	public $sede_id;
	public $bodega_id;
	
	function load($nombre, $acceso, $sede_id, $username, $clave)
	{
		$this->nombre=$nombre; $this->acceso=$acceso; $this->sede_id=$sede_id; $this->username=$username; $this->clave=$clave; $this->bodega_id=$this->sede_id;
	}
	
	function select($id)
	{
		$q = $this->db->query("SELECT * FROM usuarios WHERE id=$id");
		$datos = $q->row();
		
		$this->id = $id; $this->username = $datos->username; $this->clave = $datos->clave; $this->sal = $datos->sal; $this->nombre = $datos->nombre; 
		$this->acceso = $datos->acceso; $this->fecha_ingreso = $datos->fecha_ingreso; $this->sede_id = $datos->bodegas_id;  
	}
	
	function insert()
	{
		$fecha = date("Y-m-d");
		$suciedad = uniqid(mt_rand());
		$clave_nueva = md5($this->clave.$suciedad);
		$nombre = ucwords(mb_strtolower($this->nombre,'UTF-8'));
		$usuario = ucwords(mb_strtolower($this->username,'UTF-8'));
		
		$this->db->query("INSERT INTO usuarios SET username='$usuario', clave='$clave_nueva', nombre='$nombre', sal='$suciedad', fecha_ingreso='$fecha', 
		acceso='$this->acceso', sedes_id='$this->sede_id', equipos_bodegas_id=$this->bodega_id");
		
		$this->id = $this->db->insert_id();
	}
	
	function listar_usuarios()
	{
		$res = $this->db->query("SELECT u.*, s.*, u.nombre as nombre, u.id as id
														 FROM usuarios u
														 JOIN sedes s ON s.id = u.sedes_id");
		return $res->result();
	}
	
	function listar_datos_usuario($usuario_id)
	{
		$res = $this->db->query("SELECT u.*, s.*, u.nombre as nombre
														 FROM usuarios u
														 JOIN sedes s ON s.id = u.sedes_id
														 WHERE u.id=$usuario_id");
		return $res->row();
	}
	
	function listar_historial_usuario($usuario_id)
	{
		$res = $this->db->query("SELECT *,DATE_FORMAT(fecha, '%W %e de %M %Y - %l:%i %p') as fecha 
														 FROM usuarios_acciones 
														 WHERE usuarios_id=$usuario_id 
														 ORDER BY id DESC");
		return $res->result();
	}	
	
	function listar_bodegas()
	{
		$q = $this->db->query("SELECT * FROM equipos_bodegas");
		return $q->result();
	}
	
	function actualizar_bodega($user_id, $bodega_id)
	{
		$q = $this->db->query("SELECT * FROM equipos_bodegas WHERE id=$bodega_id");
		
		$_SESSION['usuario']['bodega'] = $q->row()->nombre;
		$_SESSION['usuario']['bodega_id'] = $q->row()->id;	
			
		$this->db->query("UPDATE usuarios SET equipos_bodegas_id=$bodega_id WHERE id=$user_id");
	}
}