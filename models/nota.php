<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class nota extends CI_Model
{
	public $id;
	public $fecha_compra;
	public $proveedor_nombre;
	
	function transformar_fecha($fecha)
	{
		list($mes, $dia, $ano) = explode("/", $fecha);
		$timestamp = implode("-", array($ano, $mes, $dia));
		$date = new DateTime($timestamp, new DateTimeZone('America/Bogota'));
		
		return $date->format('Y-m-d');
	}
	
	function crear_nea($equipos, $cliente_id, $estado_equipos, $descripcion, $info=NULL)
	{
		$fecha = date("Y-m-d");
		$equipo = new equipo;
		
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if ($cliente_id != NULL)
		{
			$cliente = new cliente;
			$cliente_id = $cliente->cliente_history_id($cliente_id);
			
			$this->db->query("INSERT INTO nota_entrada_almacen 
												SET fecha                        = '$fecha', 
														descripcion                  = '$descripcion', 
														otra_info										 = '$info',
														clientes_personas_history_id = $cliente_id, 
														sedes_id                     = $sede_id");
		}
		else
			$this->db->query("INSERT INTO nota_entrada_almacen 
												SET fecha       = '$fecha', 
														descripcion = '$descripcion', 
														otra_info		= '$info',
														sedes_id    = $sede_id");
				
		$nota_id = $this->db->insert_id();
		$this->id = $nota_id;
		
		foreach ($equipos as $equipo2)
		{
			$equipo_id = $equipo->equipo_history_id($equipo2['id']);
			$equipo->actualizar_estado($estado_equipos, $equipo2['id']);
			$this->db->query("INSERT INTO nota_entrada_almacen_has_equipos SET nota_entrada_almacen_id=$nota_id, equipos_history_id=$equipo_id");
		}	
	}	
	
	function crear_nsa($equipos, $cliente_id, $estado_equipos, $descripcion, $info=NULL)
	{
		$fecha = date("Y-m-d");
		$equipo = new equipo;
		
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if ($cliente_id != NULL)
		{
			$cliente = new cliente;
			$cliente_id = $cliente->cliente_history_id($cliente_id);			
			
			$this->db->query("INSERT INTO nota_salida_almacen 
												SET fecha                        = '$fecha', 
														descripcion                  = '$descripcion', 
														otra_info										 = '$info',
														clientes_personas_history_id = $cliente_id, 
														sedes_id                     = $sede_id");
		}
		else
			$this->db->query("INSERT INTO nota_salida_almacen 
												SET fecha       = '$fecha', 
														descripcion = '$descripcion', 
														otra_info		= '$info',
														sedes_id    = $sede_id");
		
		$nota_id = $this->db->insert_id();
		$this->id = $nota_id;
		
		foreach ($equipos as $equipo2)
		{
			$equipo_id = $equipo->equipo_history_id($equipo2['id']);
			$equipo->actualizar_estado($estado_equipos, $equipo2['id']);
			$this->db->query("INSERT INTO nota_salida_almacen_has_equipos SET nota_salida_almacen_id=$nota_id, equipos_history_id=$equipo_id");
		}		
	}
	
	function listar_equipos_nea($compra_id)
	{
		$res = $this->db->query("SELECT e.id, e.equipos_tipos_id 
														 FROM nota_entrada_almacen_has_equipos ne 
														 JOIN equipos_history e ON e.id = ne.equipos_history_id
														 WHERE ne.nota_entrada_almacen_id = $compra_id");
		
		$equipos = array();
		
		foreach ($res->result() as $equipo)
			$equipos[] = array('id' => $equipo->id, 'tipo_id' => $equipo->equipos_tipos_id);
		
		return $equipos;
	}	

	function listar_equipos_nsa($nota_id)
	{
		$res = $this->db->query("SELECT e.id, e.equipos_tipos_id 
														 FROM nota_salida_almacen_has_equipos ns 
														 JOIN equipos_history e ON e.id = ns.equipos_history_id
														 WHERE ns.nota_salida_almacen_id = $nota_id");
		
		$equipos = array();
		
		foreach ($res->result() as $equipo)
			$equipos[] = array('id' => $equipo->id, 'tipo_id' => $equipo->equipos_tipos_id);
		
		return $equipos;
	}
	
	function listar_nea()
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if (permiso('superadmin'))
			$res = $this->db->query("SELECT n.*, DATE_FORMAT(n.fecha, '%e de %M %Y') as fecha, s.ciudad 
															 FROM nota_entrada_almacen n
															 JOIN sedes s ON s.id = n.sedes_id
															 ORDER BY n.id DESC");
		else
			$res = $this->db->query("SELECT *, DATE_FORMAT(fecha, '%e de %M %Y') as fecha FROM nota_entrada_almacen WHERE sedes_id=$sede_id ORDER BY id DESC");
			
		return $res->result();
	}
	
	function listar_nsa()
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if (permiso('superadmin'))
			$res = $this->db->query("SELECT n.*, DATE_FORMAT(n.fecha, '%e de %M %Y') as fecha, s.ciudad 
															 FROM nota_salida_almacen n
															 JOIN sedes s ON s.id = n.sedes_id
															 ORDER BY n.id DESC");
		else
			$res = $this->db->query("SELECT *, DATE_FORMAT(fecha, '%e de %M %Y') as fecha FROM nota_salida_almacen WHERE sedes_id=$sede_id ORDER BY id DESC");
			
		return $res->result();
	}	
	
	function listar_datos_nea($nea_id)
	{
		$res = $this->db->query("SELECT nea.*, c.nombre as persona, c.telefono, c.cedula, e.nombre as empresa, e.nit, e.direccion, nea.id as id, s.nombre as sede, 
															s.ciudad as sede_ciudad, c.direccion as direccion_persona
														 FROM nota_entrada_almacen nea
														 LEFT JOIN clientes_personas_history c ON c.id=nea.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id=c.clientes_empresas_history_id
														 LEFT JOIN sedes s ON s.id=nea.sedes_id
														 WHERE nea.id = $nea_id");
		return $res->row();												 
	}
	
	function listar_datos_nsa($nsa_id)
	{
		$res = $this->db->query("SELECT nsa.*, c.nombre as persona, c.telefono, c.cedula, e.nombre as empresa, e.nit, e.direccion, nsa.id as id, s.nombre as sede, 
															s.ciudad as sede_ciudad, c.direccion as direccion_persona
														 FROM nota_salida_almacen nsa
														 LEFT JOIN clientes_personas_history c ON c.id=nsa.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id=c.clientes_empresas_history_id
														 LEFT JOIN sedes s ON s.id=nsa.sedes_id
														 WHERE nsa.id = $nsa_id");
		return $res->row();												 
	}
	
}

?>