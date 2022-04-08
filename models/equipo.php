<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class equipo extends CI_Model
{
	public $id;
	public $history_id;
	public $inventario;
	public $serial;
	public $fecha_ingreso; 
	public $tipo_equipo_id;
	public $modelo;
	public $marca;
	public $observacion;
	public $bodega_id;
	public $estado_id;	
	public $empresa_id;
	
	function select($id)
	{
		$query = $this->db->query("SELECT *, DATE_FORMAT(fecha_ingreso, '%e de %M del %Y') as fecha FROM equipos WHERE id=$id");
		$datos = $query->row_array();
		
		$this->id 						= $id;
		$this->inventario 		= $datos['inventario'];
		$this->serial 				= $datos['serial'];
		$this->fecha_ingreso	= $datos['fecha'];
		$this->marca					= $datos['marca'];
		$this->modelo 				= $datos['modelo'];
		$this->empresa_id 		= $datos['equipos_empresas_id'];
		$this->bodega_id 			= $datos['equipos_bodegas_id'];
		$this->estado_id 			= $datos['equipos_estados_id']; 
		$this->tipo_equipo_id = $datos['equipos_tipos_id'];
		$this->fecha_ingreso  = $datos['fecha_ingreso'];
		$this->observacion 		= $datos['observacion'];
	}
	
	function select_history($id)
	{
		$query = $this->db->query("SELECT *, DATE_FORMAT(fecha_ingreso, '%e de %M del %Y') as fecha FROM equipos_history WHERE id=$id");
		$datos = $query->row_array();
		
		$this->id 						= $id;
		$this->inventario 		= $datos['inventario'];
		$this->serial 				= $datos['serial'];
		$this->fecha_ingreso	= $datos['fecha'];
		$this->marca					= $datos['marca'];
		$this->modelo 				= $datos['modelo'];
		$this->empresa_id 		= $datos['equipos_empresas_id'];
		$this->bodega_id 			= $datos['equipos_bodegas_id'];
		$this->estado_id 			= $datos['equipos_estados_id']; 
		$this->tipo_equipo_id = $datos['equipos_tipos_id'];
		$this->observacion 		= $datos['observacion'];
	}	
	
	function insert()
	{
		$query = $this->db->query("INSERT INTO equipos SET
															 inventario          = '$this->inventario', 
															 serial              = '$this->serial',
															 equipos_tipos_id    = '$this->tipo_equipo_id',
															 modelo              = '$this->modelo', 
															 marca               = '$this->marca', 
															 equipos_bodegas_id  = '$this->bodega_id', 
															 equipos_estados_id  = '$this->estado_id',
															 equipos_empresas_id = '$this->empresa_id', 
															 fecha_ingreso       = '$this->fecha_ingreso', 
															 observacion         = '$this->observacion'");
		
		$this->id = $this->db->insert_id();

		$query = $this->db->query("INSERT INTO equipos_history SET
															 equipos_id          = '$this->id',
															 inventario          = '$this->inventario', 
															 serial              = '$this->serial',
															 equipos_tipos_id    = '$this->tipo_equipo_id',
															 modelo              = '$this->modelo', 
															 marca               = '$this->marca', 
															 equipos_bodegas_id  = '$this->bodega_id', 
															 equipos_estados_id  = '$this->estado_id',
															 equipos_empresas_id = '$this->empresa_id', 
															 fecha_ingreso       = '$this->fecha_ingreso', 
															 observacion         = '$this->observacion'");
		
		$this->history_id = $this->db->insert_id();
		
		return $query;
	}	
	
	function load($inventario, $serial, $tipo_equipo_id, $marca, $modelo, $bodega_id, $estado_id, $empresa_id, $observacion)
	{ 
		$this->inventario     = $inventario; 
		$this->serial         = $serial; 
		$this->tipo_equipo_id = $tipo_equipo_id; 
		$this->marca          = $marca;
		$this->modelo         = $modelo; 
		$this->bodega_id      = $bodega_id; 
		$this->estado_id      = $estado_id; 
		$this->empresa_id     = $empresa_id; 
		$this->observacion    = $observacion;
		$this->fecha_ingreso  = date("Y-m-d");
	}	
	
	function update()
	{
		$this->db->trans_start();
		
		$this->db->query("UPDATE equipos 
											SET inventario  = '$this->inventario',
													serial      = '$this->serial',
													modelo      = '$this->modelo',
													marca       = '$this->marca',
													observacion = '$this->observacion'
											WHERE id = $this->id");
										 
		$this->db->query("INSERT INTO equipos_history 
											SET
											 equipos_id          = '$this->id',
											 inventario          = '$this->inventario', 
											 serial              = '$this->serial',
											 equipos_tipos_id    = '$this->tipo_equipo_id',
											 modelo              = '$this->modelo', 
											 marca               = '$this->marca', 
											 equipos_bodegas_id  = '$this->bodega_id', 
											 equipos_estados_id  = '$this->estado_id',
											 equipos_empresas_id = '$this->empresa_id', 
											 fecha_ingreso       = '$this->fecha_ingreso', 
											 observacion         = '$this->observacion'");	
											 
		$this->history_id = $this->db->insert_id();									 
											 
		$this->db->trans_complete();									 									 
	}
	
	function actualizar_estado($estado_id, $equipo_id)
	{
		$this->db->query("UPDATE equipos SET equipos_estados_id=$estado_id WHERE id=$equipo_id");
	}
	
	function actualizar_bodega($bodega_id, $equipo_id)
	{
		$this->db->query("UPDATE equipos SET equipos_bodegas_id=$bodega_id WHERE id=$equipo_id");
	}
	
	function transformar_fecha($fecha)
	{
		list($mes, $dia, $ano) = explode("/", $fecha);
		$timestamp = implode("-", array($ano, $mes, $dia));
		$date = new DateTime($timestamp, new DateTimeZone('America/Bogota'));
		
		return $date->format('Y-m-d');
	}	

	//-----------------------------------------------------------------------------------------------------------------------------------------
	// BUSCAR EQUIPO	
	
	function buscar($tipo, $valor)
	{
		$res = $this->db->query("SELECT id, equipos_tipos_id FROM equipos WHERE $tipo like '%$valor%'");
		return $res;
	}
	
	function query_2_array($query)
	{
		$array = array();
		
		foreach ($query->result() as $row)
			$array[] = array('id' => $row->id, 'tipo_id' => $row->equipos_tipos_id);
			
		return $array;	
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// CARGAR EQUIPO	
	
	function buscar_agregar_empresa($nombre)
	{
		$res = $this->db->query("SELECT id FROM equipos_empresas WHERE nombre='$nombre'");
		
		if ($res->num_rows() > 0) 
			return $res->row()->id;
		
		$this->db->query("INSERT INTO equipos_empresas SET nombre='$nombre'");
		
		return $this->db->insert_id();	
	}
	
	function cargar($dato, $cliente_id, $fecha_compra)
	{
		$this->db->trans_start();
		
		$sede_id = $_SESSION['usuario']['bodega_id'];						
		$error = '';
		$equipos = array();
						
		//--------------------------------------------------------------------------------------------------------------------------------------------------
		// PCS DE ESCRITORIO
		for ($j = 3; $j <= $dato->sheets[0]['numRows']; $j++)
		{	
			if ( (isset($dato->sheets[0]['cells'][$j][1]) && $dato->sheets[0]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[0]['cells'][$j][2]) && $dato->sheets[0]['cells'][$j][2] != '' ) )
			{
				$empresa 		             = $dato->sheets[0]['cells'][$j][1];
				$inventario              = $dato->sheets[0]['cells'][$j][2];
				$serial            = isset($dato->sheets[0]['cells'][$j][3])? $dato->sheets[0]['cells'][$j][3]:''; 
				$marca             = isset($dato->sheets[0]['cells'][$j][4])? $dato->sheets[0]['cells'][$j][4]:''; 
				$modelo            = isset($dato->sheets[0]['cells'][$j][5])? $dato->sheets[0]['cells'][$j][5]:'';
				$cpu               = isset($dato->sheets[0]['cells'][$j][6])? $dato->sheets[0]['cells'][$j][6]:'';
				$disco_duro        = isset($dato->sheets[0]['cells'][$j][7])? $dato->sheets[0]['cells'][$j][7]:'';
				$disco_duro_inv  	 = isset($dato->sheets[0]['cells'][$j][8])? $dato->sheets[0]['cells'][$j][8]:'';
				$disco_duro_serial = isset($dato->sheets[0]['cells'][$j][9])? $dato->sheets[0]['cells'][$j][9]:'';
				$memoria           = isset($dato->sheets[0]['cells'][$j][10])? $dato->sheets[0]['cells'][$j][10]:'';
				$memoria_inv       = isset($dato->sheets[0]['cells'][$j][11])? $dato->sheets[0]['cells'][$j][11]:'';
				$memoria_serial    = isset($dato->sheets[0]['cells'][$j][12])? $dato->sheets[0]['cells'][$j][12]:'';
				$u_optica          = isset($dato->sheets[0]['cells'][$j][13])? $dato->sheets[0]['cells'][$j][13]:'';
				$u_optica_inv      = isset($dato->sheets[0]['cells'][$j][14])? $dato->sheets[0]['cells'][$j][14]:'';
				$u_optica_serial   = isset($dato->sheets[0]['cells'][$j][15])? $dato->sheets[0]['cells'][$j][15]:'';
				$observacion       = isset($dato->sheets[0]['cells'][$j][16])? $dato->sheets[0]['cells'][$j][16]:'';
			
				$empresa_id = $this->buscar_agregar_empresa($empresa);
				
				$pc = new pc_escritorio;
				$pc->load($inventario,$serial,$marca,$modelo,$sede_id,1,$empresa_id,$cpu,$memoria,$memoria_inv,$memoria_serial,$disco_duro,$disco_duro_inv,
									$disco_duro_serial,$u_optica,$u_optica_inv,$u_optica_serial,$observacion);
				$q = $pc->insert();	
				
				if (!$q) 
					$error .= "Hubo un problema guardando los datos de PC de Escritorio: ".$this->db->_error_message()."<br>"; 
				
				$equipos[] = array('id' => $pc->id,	'tipo_id' => 1);
			}									   
		}
		
		//--------------------------------------------------------------------------------------------------------------------------------------------------
		// PORTATILES
		for ($j = 3; $j <= $dato->sheets[1]['numRows']; $j++)
		{
			if ( (isset($dato->sheets[1]['cells'][$j][1]) && $dato->sheets[1]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[1]['cells'][$j][2]) && $dato->sheets[1]['cells'][$j][2] != '' ) )
			{
				$empresa                 = $dato->sheets[1]['cells'][$j][1];
				$inventario              = $dato->sheets[1]['cells'][$j][2];
				$serial            = isset($dato->sheets[1]['cells'][$j][3])? $dato->sheets[1]['cells'][$j][3]:'';  
				$marca             = isset($dato->sheets[1]['cells'][$j][4])? $dato->sheets[1]['cells'][$j][4]:''; 
				$modelo 					 = isset($dato->sheets[1]['cells'][$j][5])? $dato->sheets[1]['cells'][$j][5]:'';
				$cpu							 = isset($dato->sheets[1]['cells'][$j][6])? $dato->sheets[1]['cells'][$j][6]:'';
				$disco_duro 			 = isset($dato->sheets[1]['cells'][$j][7])? $dato->sheets[1]['cells'][$j][7]:'';
				$disco_duro_inv		 = isset($dato->sheets[1]['cells'][$j][8])? $dato->sheets[1]['cells'][$j][8]:'';
				$disco_duro_serial = isset($dato->sheets[1]['cells'][$j][9])? $dato->sheets[1]['cells'][$j][9]:'';
				$memoria 					 = isset($dato->sheets[1]['cells'][$j][10])? $dato->sheets[1]['cells'][$j][10]:'';
				$memoria_inv       = isset($dato->sheets[1]['cells'][$j][11])? $dato->sheets[1]['cells'][$j][11]:'';
				$memoria_serial    = isset($dato->sheets[1]['cells'][$j][12])? $dato->sheets[1]['cells'][$j][12]:'';
				$u_optica          = isset($dato->sheets[1]['cells'][$j][13])? $dato->sheets[1]['cells'][$j][13]:'';
				$u_optica_inv      = isset($dato->sheets[1]['cells'][$j][14])? $dato->sheets[1]['cells'][$j][14]:'';
				$u_optica_serial   = isset($dato->sheets[1]['cells'][$j][15])? $dato->sheets[1]['cells'][$j][15]:'';
				$pantalla          = isset($dato->sheets[1]['cells'][$j][16])? $dato->sheets[1]['cells'][$j][16]:'';
				$bateria           = isset($dato->sheets[1]['cells'][$j][17])? $dato->sheets[1]['cells'][$j][17]:''; 
				$wireless          = isset($dato->sheets[1]['cells'][$j][18])? $dato->sheets[1]['cells'][$j][18]=='si'? 1: 0: ''; 
				$webcam            = isset($dato->sheets[1]['cells'][$j][19])? $dato->sheets[1]['cells'][$j][19]=='si'? 1: 0: '';  
				$observacion       = isset($dato->sheets[1]['cells'][$j][20])? $dato->sheets[1]['cells'][$j][20]:''; 
			
				$empresa_id = $this->buscar_agregar_empresa($empresa);
			
				$portatil = new portatil;
				$portatil->load($inventario,$serial,$marca,$modelo,$sede_id,1,$empresa_id,$cpu,$memoria,$memoria_inv,$memoria_serial,$disco_duro,$disco_duro_inv,
												$disco_duro_serial,$u_optica,$u_optica_inv,$u_optica_serial,$pantalla,$bateria,$wireless,$webcam,$observacion);
				$q = $portatil->insert(false,true);	
				
				if (!$q) 
					$error .= "Hubo un problema guardando los datos de Portatiles: ".$this->db->_error_message()."<br>"; 

				$equipos[] = array('id' => $portatil->id, 'tipo_id' => 2);
			}									   
		}	
		
		//--------------------------------------------------------------------------------------------------------------------------------------------------
		// MONITORES
		for ($j = 3; $j <= $dato->sheets[2]['numRows']; $j++)
		{
			if ( (isset($dato->sheets[2]['cells'][$j][1]) && $dato->sheets[2]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[2]['cells'][$j][2]) && $dato->sheets[2]['cells'][$j][2] != '' ) )
			{
				$empresa           = $dato->sheets[2]['cells'][$j][1];
				$inventario        = $dato->sheets[2]['cells'][$j][2];
				$serial      = isset($dato->sheets[2]['cells'][$j][3])? $dato->sheets[2]['cells'][$j][3]:''; 
				$marca       = isset($dato->sheets[2]['cells'][$j][4])? $dato->sheets[2]['cells'][$j][4]:''; 
				$modelo      = isset($dato->sheets[2]['cells'][$j][5])? $dato->sheets[2]['cells'][$j][5]:'';
				$tipo        = isset($dato->sheets[2]['cells'][$j][6])? $dato->sheets[2]['cells'][$j][6]:'';
				$pulgadas    = isset($dato->sheets[2]['cells'][$j][7])? $dato->sheets[2]['cells'][$j][7]:''; 
				$observacion = isset($dato->sheets[2]['cells'][$j][8])? $dato->sheets[2]['cells'][$j][8]:'';
		
				$empresa_id = $this->buscar_agregar_empresa($empresa);
		
				$monitor = new equipo;
				$monitor->load($inventario, $serial, 3, $marca, $modelo, $sede_id, 1, $empresa_id, $observacion);
				$q1 = $monitor->insert();
				
				$equipo_id = $monitor->id;
				
				$q2 = $this->db->query("INSERT INTO equipos_monitores (equipos_id, tipo, pulgadas) VALUES ('$equipo_id', '$tipo', '$pulgadas')");
												
				if (!$q1 || !$q2) 
					$error .= "Hubo un problema guardando los datos de Pantallas LCD: ".$this->db->_error_message()."<br>"; 												
												
				$equipos[] = array('id' => $monitor->id, 'tipo_id' => 3);	
			}									   
		}			
		
	//--------------------------------------------------------------------------------------------------------------------------------------------------
		// TECLADOS
		for ($j = 3; $j <= $dato->sheets[3]['numRows']; $j++)
		{
			if ( (isset($dato->sheets[3]['cells'][$j][1]) && $dato->sheets[3]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[3]['cells'][$j][2]) && $dato->sheets[3]['cells'][$j][2] != '' ) )
			{
				$empresa           = $dato->sheets[3]['cells'][$j][1];
				$inventario        = $dato->sheets[3]['cells'][$j][2];
				$serial      = isset($dato->sheets[3]['cells'][$j][3])? $dato->sheets[3]['cells'][$j][3]:''; 
				$marca       = isset($dato->sheets[3]['cells'][$j][4])? $dato->sheets[3]['cells'][$j][4]:''; 
				$modelo      = isset($dato->sheets[3]['cells'][$j][5])? $dato->sheets[3]['cells'][$j][5]:'';
				$idioma      = isset($dato->sheets[3]['cells'][$j][6])? $dato->sheets[3]['cells'][$j][6]:''; 
				$conexion    = isset($dato->sheets[3]['cells'][$j][7])? $dato->sheets[3]['cells'][$j][7]:''; 
				$observacion = isset($dato->sheets[3]['cells'][$j][8])? $dato->sheets[3]['cells'][$j][8]:'';
		
				$empresa_id = $this->buscar_agregar_empresa($empresa);
		
				$teclado = new equipo;
				$teclado->load($inventario, $serial, 4, $marca, $modelo, $sede_id, 1, $empresa_id, $observacion);
				$q1 = $teclado->insert();
				
				$equipo_id = $teclado->id;
				
				$q2 = $this->db->query("INSERT INTO equipos_teclados (equipos_id, idioma, conexion) VALUES ('$equipo_id','$idioma','$conexion')");
												
				if (!$q1 || !$q2) 
					$error .= "Hubo un problema guardando los datos de Teclados: ".$this->db->_error_message()."<br>"; 
				
				$id = $this->db->insert_id();
																		
				$equipos[] = array('id' => $teclado->id, 'tipo_id' => 4);			
			}								   
		}					


		//--------------------------------------------------------------------------------------------------------------------------------------------------
		// MOUSES
		for ($j = 3; $j <= $dato->sheets[4]['numRows']; $j++)
		{
			if ( (isset($dato->sheets[4]['cells'][$j][1]) && $dato->sheets[4]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[4]['cells'][$j][2]) && $dato->sheets[4]['cells'][$j][2] != '' ) )
			{
				$empresa           = $dato->sheets[4]['cells'][$j][1];
				$inventario        = $dato->sheets[4]['cells'][$j][2];
				$serial      = isset($dato->sheets[4]['cells'][$j][3])? $dato->sheets[4]['cells'][$j][3]:''; 
				$marca       = isset($dato->sheets[4]['cells'][$j][4])? $dato->sheets[4]['cells'][$j][4]:''; 
				$modelo      = isset($dato->sheets[4]['cells'][$j][5])? $dato->sheets[4]['cells'][$j][5]:'';
				$tipo        = isset($dato->sheets[4]['cells'][$j][6])? $dato->sheets[4]['cells'][$j][6]:''; 
				$conexion    = isset($dato->sheets[4]['cells'][$j][7])? $dato->sheets[4]['cells'][$j][7]:''; 
				$observacion = isset($dato->sheets[4]['cells'][$j][8])? $dato->sheets[4]['cells'][$j][8]:'';
		
				$empresa_id = $this->buscar_agregar_empresa($empresa);
				
				$mouse = new equipo;
				$mouse->load($inventario, $serial, 5,$marca, $modelo, $sede_id, 1, $empresa_id, $observacion);
				$q1 = $mouse->insert();
				
				$equipo_id = $mouse->id;
				
				$q2 = $this->db->query("INSERT INTO equipos_mouses (equipos_id, tipo, conexion) VALUES ('$equipo_id','$tipo','$conexion')");
												
				if (!$q1 || !$q2) 
					$error .= "Hubo un problema guardando los datos de Mouses: ".$this->db->_error_message()."<br>"; 
																					
				$equipos[] = array('id' => $mouse->id, 'tipo_id' => 5);		
			}									   
		}		
		

		//--------------------------------------------------------------------------------------------------------------------------------------------------
		// IMPRESORAS
		for ($j = 3; $j <= $dato->sheets[5]['numRows']; $j++)
		{
			if ( (isset($dato->sheets[5]['cells'][$j][1]) && $dato->sheets[5]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[5]['cells'][$j][2]) && $dato->sheets[5]['cells'][$j][2] != '' ) )
			{
				$empresa           = $dato->sheets[5]['cells'][$j][1];
				$inventario        = $dato->sheets[5]['cells'][$j][2];
				$serial      = isset($dato->sheets[5]['cells'][$j][3])? $dato->sheets[5]['cells'][$j][3]:''; 
				$marca       = isset($dato->sheets[5]['cells'][$j][4])? $dato->sheets[5]['cells'][$j][4]:''; 
				$modelo      = isset($dato->sheets[5]['cells'][$j][5])? $dato->sheets[5]['cells'][$j][5]:'';
				$tipo        = isset($dato->sheets[5]['cells'][$j][6])? $dato->sheets[5]['cells'][$j][6]:''; 
				$cartucho    = isset($dato->sheets[5]['cells'][$j][7])? $dato->sheets[5]['cells'][$j][7]=='si'? 1: 0: '';  
				$observacion = isset($dato->sheets[5]['cells'][$j][8])? $dato->sheets[5]['cells'][$j][8]:'';
		
				$empresa_id = $this->buscar_agregar_empresa($empresa);
				
				$impresora = new equipo;
				$impresora->load($inventario, $serial, 6, $marca, $modelo, $sede_id, 1, $empresa_id, $observacion);
				$q1 = $impresora->insert();
				
				$equipo_id = $impresora->id;
				
				$q2 = $this->db->query("INSERT INTO equipos_impresoras (equipos_id, tipo, cartucho) VALUES ('$equipo_id','$tipo', $cartucho)");
												
				if (!$q1 || !$q2) 
					$error .= "Hubo un problema guardando los datos de Impresoras: ".$this->db->_error_message()."<br>";  
																					
				$equipos[] = array('id' => $impresora->id, 'tipo_id' => 6);		
			}									   
		}				
					
		//--------------------------------------------------------------------------------------------------------------------------------------------------
		// OTROS
		for ($j = 3; $j <= $dato->sheets[6]['numRows']; $j++)
		{
			if ( (isset($dato->sheets[6]['cells'][$j][1]) && $dato->sheets[6]['cells'][$j][1] != '' ) && 
					 (isset($dato->sheets[6]['cells'][$j][2]) && $dato->sheets[6]['cells'][$j][2] != '' ) )
			{
				$empresa           = $dato->sheets[6]['cells'][$j][1];
				$inventario        = $dato->sheets[6]['cells'][$j][2];
				$serial      = isset($dato->sheets[6]['cells'][$j][3])? $dato->sheets[6]['cells'][$j][3]:''; 
				$marca       = isset($dato->sheets[6]['cells'][$j][4])? $dato->sheets[6]['cells'][$j][4]:''; 
				$modelo      = isset($dato->sheets[6]['cells'][$j][5])? $dato->sheets[6]['cells'][$j][5]:'';
				$tipo_equipo = isset($dato->sheets[6]['cells'][$j][6])? $dato->sheets[6]['cells'][$j][6]:''; 
				$observacion = isset($dato->sheets[6]['cells'][$j][7])? $dato->sheets[6]['cells'][$j][7]:'';
		
				$empresa_id = $this->buscar_agregar_empresa($empresa);
				
				$otro_equipo = new equipo;
				$otro_equipo->load($inventario, $serial, 7,$marca, $modelo, $sede_id, 1, $empresa_id, $observacion);
				$q1 = $otro_equipo->insert();
				
				$equipo_id = $otro_equipo->id;
				
				$q2 = $this->db->query("SELECT id FROM equipos_otros_tipos WHERE tipo='$tipo_equipo'");
					
				if ($q2->num_rows > 0)
				{	
					$otro_tipo_id = $q2->row()->id;
							
					$q3 = $this->db->query("INSERT INTO equipos_otros (equipos_id, equipos_otros_tipos_id) VALUES ($equipo_id, $otro_tipo_id)");
													
					if (!$q1 || !$q3) 
						$error .= "Hubo un problema guardando los datos de Otros Equipos: ".$this->db->_error_message()."<br>"; 
						
					$equipos[] = array('id' => $otro_equipo->id, 'tipo_id' => 7);	
				}
				else
				{
					$q4 = $this->db->query("INSERT INTO equipos_otros_tipos SET tipo='$tipo_equipo'");
					$otro_tipo_id = $this->db->insert_id();

					$q3 = $this->db->query("INSERT INTO equipos_otros (equipos_id, equipos_otros_tipos_id) VALUES ($equipo_id,$otro_tipo_id)");
													
					if (!$q1 || !$q3) 
						$error .= "Hubo un problema guardando los datos de Otros Equipos: ".$this->db->_error_message()."<br>"; 
						
					$equipos[] = array('id' => $otro_equipo->id, 'tipo_id' => 7);						
				}
			}								   
		}		
		
		// guardar datos de proveedor y del ingreso-------------------------------------------------------------------------------------------------------------------
		
		if (count($equipos) > 0)
		{				
			$nota = new nota;											
			$nota->crear_nea($equipos, $cliente_id, 1, 'Compra de equipos');
			$nota_id = $nota->id;
			
			
			$fecha_compra = $this->transformar_fecha($fecha_compra);
			
			$this->db->query("INSERT INTO equipos_ingresos2 
												SET fecha_compra      			     = '$fecha_compra', 
														clientes_personas_history_id = $cliente_id, 
														nota_entrada_almacen_id      = $nota_id");											
		}
		//------------------------------------------------------------------------------------------------------------------------------------------------------------
		
		$this->db->trans_complete();		
		
		return array($this->db->trans_status(), $equipos, $error, $nota->id);	
	}	
		
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// DIBUJAR EQUIPOS
	
	function contar_disponibles($tipo_equipo_id, $sql)
	{		
		$query = $this->db->query("SELECT count(e.inventario) as res FROM equipos e
															 WHERE e.equipos_tipos_id=$tipo_equipo_id AND $sql");
		$res = $query->row();
		return $res->res;
	}		
	
	function dibujar_menu($equipos='disponibles', $menu="todos", $onclick="''")
	{ 
		if ($equipos == 'disponibles')
			$equipos = 'e.equipos_estados_id=1';
	
		$opciones[] = 'xajax';
	
		$menu = addslashes($menu);
		$onclick = addslashes($onclick);
	
		$html =
		'<script type="text/javascript" src="'.base_url().'recursos/addons/jquery-1.5.2.min.js"></script> 
		<script type="text/javascript" src="'.base_url().'recursos/addons/jquery.tablesorter.min.js"></script> 
		<script type="text/javascript" src="'.base_url().'recursos/addons/jquery.tablefilter.js"></script> 
		<script type="text/javascript" src="'.base_url().'recursos/addons/ui/ui/jquery-ui-1.8.12.custom.js"></script> 
		<script type="text/javascript" src="'.base_url().'recursos/js/seleccionar_equipos.js"></script> 
		<link rel="stylesheet" type="text/css" media="screen" href="'.base_url().'recursos/addons/ui/css/smoothness/jquery-ui-1.8.12.custom.css">	
		<script type="text/javascript"> 
			$(document).ready(function() { $( "#radio" ).buttonset(); }); 
			function table_adds(name)
			{
				$(name).tablesorter(); 
				$(name).tableFilter();
			
				$("table tbody td").hover(function() {
				$(this).parents("tr").find("td").addClass("highlight");
				}, function() {
				$(this).parents("tr").find("td").removeClass("highlight");
				});	
			}
		</script>
		
		<div id="equipos_seleccionados_container">';
		
		if (isset($_SESSION['equipos_seleccionados'])) $html .= $this->info_seleccionados();
			
		$html .=
		'</div>
		
		<div id="seleccionar_equipos_container">
			<div id="radio">
		
				<input type="radio" name="radio" id="pc" 
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=1 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')">
				<label for="pc">PCs de Escritorio ('.$this->contar_disponibles(1, $equipos).')</label>
	
				<input type="radio" name="radio" id="portatil" 
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=2 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')">
				<label for="portatil">Portatiles ('.$this->contar_disponibles(2, $equipos).')</label>
	
				<input type="radio" name="radio" id="pantalla" 
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=3 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')">
				<label for="pantalla">Monitores ('.$this->contar_disponibles(3, $equipos).')</label>
	
				<input type="radio" name="radio" id="teclado" 
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=4 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')">
				<label for="teclado">Teclados ('.$this->contar_disponibles(4, $equipos).')</label>
		
				<input type="radio" name="radio" id="mouse"  
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=5 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')">
				<label for="mouse">Mouses ('.$this->contar_disponibles(5, $equipos).')</label>	
			
				<input type="radio" name="radio" id="impresora"  
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=6 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')"> 
				<label for="impresora">Impresoras ('.$this->contar_disponibles(6, $equipos).')</label>
	
				<input type="radio" name="radio" id="otro"  
				onclick="xajax_dibujar_equipos(\'e.equipos_tipos_id=7 AND '.$equipos.'\',\''.$menu.'\',\'xajax\',\''.$onclick.'\')">
				<label for="otro">Otros Equipos('.$this->contar_disponibles(7, $equipos).')</label>
		
				<div id="salida"></div>
				
			</div>
		</div>';
		
		return $html; 
	}	
	
	function dibujar_equipos($where, $menu='todos', $opciones=array(), $onclick='', $variable=NULL)
	{
		//$where = is_array($wh)? 'id IN ('.$equipos.')' : $equipos;
		
		if (!is_array($menu) && $menu == 'todos') $menu = array('empresa','bodega','inventario','serial','marca','modelo','caract');
		if (!is_array($menu) && $menu == 'sin bodega') $menu = array('empresa','inventario','serial','marca','modelo','caract');
		if (!is_array($opciones) && $opciones == 'xajax') $opciones= array($opciones);
		if (!is_array($menu) && $menu == 'alquilado')
		{
			 $menu = array('empresa','inventario','serial','marca','modelo','caract');
			 $opciones= array('xajax','alquilado');
		}		
		
		if (in_array('xajax', $opciones)) $resp=new xajaxResponse();
		
		$history = in_array('history', $opciones)? '_history' : '';
		$history2 = in_array('history', $opciones)? 'equipos_id' : 'id';
		$history3 = in_array('history', $opciones)? 'equipos_history_id' : 'equipos_id';
		
		$res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega 
														FROM equipos$history e 
														JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
														JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
														WHERE $where");
																				
		if ($res->num_rows() == 0)
			$html = 'No hay equipos';
		else								
		{
			$tipo_equipo_id = $res->row()->equipos_tipos_id;	
			
			$html = '';
			
			if (in_array('titulo', $opciones)) 
			{
				$html .= '<h4>';
				
				switch ($tipo_equipo_id) 
				{ 
					case 1: $html .= 'PCs escritorio'; break;
					case 2: $html .= 'Portatiles'; 		 break;
					case 3: $html .= 'Monitores'; 		 break; 
					case 4: $html .= 'Teclados'; 			 break; 
					case 5: $html .= 'Mouses'; 				 break; 
					case 6: $html .= 'Impresoras';		 break;
					case 7: $html .= 'Equipos'; 			 break; 
				}
				
				$html .= '</h4>';
			}
										
			$html .= '<table id="tabla_equipos" class="tablesorter"><thead><tr>';
			
			if (in_array('cambios', $opciones)) $html .= '<th></th><th></th>';
			if (in_array('empresa', $menu)) 		$html .= '<th>Empresa</th>';
			if (in_array('bodega', $menu)) 			$html .= '<th>Bodega</th>';
			if (in_array('inventario', $menu)) 	$html .= '<th>Inv</th>';
			if (in_array('serial', $menu)) 			$html .= '<th>Serial</th>';
			if (in_array('marca', $menu)) 			$html .= '<th>Marca</th>';
			if (in_array('modelo', $menu)) 			$html .= '<th>Modelo</th>';
			
			if (in_array('caract', $menu))
			{
				switch ($tipo_equipo_id)
				{
					case 1:
						$res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, pc.*, e.id as id
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_pcs$history pc ON pc.$history3 = e.id
																		 WHERE $where");
					
						$html .= '<th>CPU</th>';
						$html .= '<th>Disco Duro</th>';
						$html .= '<th>Disco Duro Inv</th>';
						$html .= '<th>Disco Duro Serial</th>';
						$html .= '<th>Memoria</th>';
						$html .= '<th>Memoria Inv</th>';
						$html .= '<th>Memoria Serial</th>';
						$html .= '<th>U.Optica</th>';
						$html .= '<th>U.Optica Inv</th>';
						$html .= '<th>U.Optica Serial</th>';
					break;
					
					case 2:
					  $res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, p.*, e.id as id
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_portatiles$history p ON p.$history3 = e.id
																		 WHERE $where");
																		 
						$html .= '<th>CPU</th>';
						$html .= '<th>Disco Duro</th>';
						$html .= '<th>Disco Duro Inv</th>';
						$html .= '<th>Disco Duro Serial</th>';
						$html .= '<th>Memoria</th>';
						$html .= '<th>Memoria Inv</th>';
						$html .= '<th>Memoria Serial</th>';
						$html .= '<th>U.Optica</th>';
						$html .= '<th>U.Optica Inv</th>';
						$html .= '<th>U.Optica Serial</th>';
						$html .= '<th>Pan talla</th>';
						$html .= '<th>Bateria Inv</th>';
						$html .= '<th>Wire less</th>';
						$html .= '<th>Web cam</th>';
					break;		
					
					case 3:
					  $res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, m.*, e.id as id
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_monitores m ON m.equipos_id = e.$history2
																		 WHERE $where");
																		 
						$html .= '<th>Tipo</th>';
						$html .= '<th>Pulgadas</th>';
					break;
					
					case 4:
					  $res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, t.*, e.id as id
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_teclados t ON t.equipos_id = e.$history2
																		 WHERE $where");
																		 
						$html .= '<th>Idioma</th>';
						$html .= '<th>Conexion</th>';
					break;					
					
					case 5:
					  $res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, m.*, e.id as id
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_mouses m ON m.equipos_id = e.$history2
																		 WHERE $where");
																		 
						$html .= '<th>Tipo</th>';
						$html .= '<th>Conexion</th>';									
					break;
					
					case 6:
					  $res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, i.*, e.id as id
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_impresoras i ON i.equipos_id = e.$history2
																		 WHERE $where");
																		 
						$html .= '<th>Tipo</th>';
						$html .= '<th>Cartucho</th>';		
					break;
					
					case 7:
					  $res = $this->db->query("SELECT e.*, ee.nombre as empresa, eb.nombre as bodega, o.*, e.id as id, t.tipo as tipo
																		 FROM equipos$history e
																		 JOIN equipos_empresas ee ON ee.id = e.equipos_empresas_id 
																		 JOIN equipos_bodegas eb ON eb.id = e.equipos_bodegas_id
																		 JOIN equipos_otros o ON o.equipos_id = e.$history2
																		 JOIN equipos_otros_tipos t ON t.id = o.equipos_otros_tipos_id 
																		 WHERE $where");
																		 
						$html .= '<th>Tipo Equipo</th>';	
					break;							
				}
			}
			
			if (in_array('observacion', $opciones))
				$html .= '<th>Observacion</th>';
				
			if (in_array('reparacion', $opciones))
				$html .= '<th>Problema</th>';
				
			if (in_array('estado', $opciones))
				$html .= '<th>Estado</th>';	
				
			if (in_array('alquilado', $opciones))
				$html .= '<th>Alquilado por</th>';					
			
			$html .= '</tr></thead><tbody>';
			
			foreach($res->result() as $equipo)
			{
				$flag = false;
				
				$html .= '<tr onclick=';
				
				switch ($onclick)
				{
					case 'seleccionar_varios':
						$html .= '"xajax_seleccionar_equipo('.$equipo->id.','.$equipo->equipos_tipos_id.')"';
					break;
					
					case 'cambiar':
						$html .= '"xajax_cambiar_equipo('.$equipo->id.','.$variable.')"';
					break;
					
					case 'historial':
						$html .= '"window.location=\''.base_url().'equipos/historial/'.$equipo->id.'\'"';
					break;
					
					case 'modificar':
						$html .= '"window.location=\''.base_url().'admin/modificar2/'.$equipo->id.'\'"';
					break;												
										
					default:
						$html .= '';
					break;
				}
				
				// mira si el equipo ya esta seleccionado para resaltarlo----------------------------
				if (isset($_SESSION['equipos_seleccionados']))
				{
					foreach ($_SESSION['equipos_seleccionados'] as $equipo_seleccionado)
						if ($equipo_seleccionado['id'] == $equipo->id)
						{
							$html .= ' style="background-color: lightgreen"';
							$flag = true;
							break;
						}
					
					$html .= ($flag)? ' id="'.$equipo->id.'_true" ' : ' id="'.$equipo->id.'_false" ';	
				}
				else
					$html .= ' id="'.$equipo->id.'_false" ';	
				//------------------------------------------------------------------------------------	
				
				$html .= '>';

				if (in_array('cambios', $opciones)) $html .= '<td><input type="button" class="delete" title="Retirar Equipo" id="retirar" name="retirar" value=""
																													 onclick="xajax_retirar_equipo('.$equipo->id.'); xajax_mostrar_info_cambio();"></td>
																											<td><input type="button" title="Cambiar Equipo" id="cambiar" name="cambiar" value=""
																													onclick="window.location=\''.base_url().'equipos/alquiler_cambiar_equipo/'.$variable.'/'.$equipo->id
																													.'\'"></td>';
																											
				if (in_array('empresa', $menu)) 		$html .= '<td>'.$equipo->empresa.'</td>';
				if (in_array('bodega', $menu)) 			$html .= '<td>'.$equipo->bodega.'</td>';
				if (in_array('inventario', $menu))	$html .= '<td>'.$equipo->inventario.'</td>';
				if (in_array('serial', $menu)) 			$html .= '<td>'.$equipo->serial.'</td>';
				if (in_array('marca', $menu))			 	$html .= '<td>'.$equipo->marca.'</td>';
				if (in_array('modelo', $menu)) 			$html .= '<td>'.$equipo->modelo.'</td>';

				if (in_array('caract', $menu))
				{
					switch ($tipo_equipo_id)
					{
						case 1:					
							$html .= '<td>'.$equipo->cpu.'</td>';
							$html .= '<td>'.$equipo->disco_duro.'</td>';
							$html .= '<td>'.$equipo->disco_duro_inv.'</td>';
							$html .= '<td>'.$equipo->disco_duro_serial.'</td>';
							$html .= '<td>'.$equipo->memoria.'</td>';
							$html .= '<td>'.$equipo->memoria_inv.'</td>';
							$html .= '<td>'.$equipo->memoria_serial.'</td>';
							$html .= '<td>'.$equipo->unidad_optica.'</td>';
							$html .= '<td>'.$equipo->unidad_optica_inv.'</td>';
							$html .= '<td>'.$equipo->unidad_optica_serial.'</td>';
						break;
						
						case 2:					
							$html .= '<td>'.$equipo->cpu.'</td>';
							$html .= '<td>'.$equipo->disco_duro.'</td>';
							$html .= '<td>'.$equipo->disco_duro_inv.'</td>';
							$html .= '<td>'.$equipo->disco_duro_serial.'</td>';
							$html .= '<td>'.$equipo->memoria.'</td>';
							$html .= '<td>'.$equipo->memoria_inv.'</td>';
							$html .= '<td>'.$equipo->memoria_serial.'</td>';
							$html .= '<td>'.$equipo->unidad_optica.'</td>';
							$html .= '<td>'.$equipo->unidad_optica_inv.'</td>';
							$html .= '<td>'.$equipo->unidad_optica_serial.'</td>';
							$html .= '<td>'.$equipo->pantalla.'</td>';
							$html .= '<td>'.$equipo->bateria_inv.'</td>';
							$html .= '<td>'; $html .= $equipo->wireless==0?'NO':'SI'; $html .='</td>';
							$html .= '<td>'; $html .= $equipo->webcam==0?'NO':'SI'; $html .='</td>';
						break;	
						
						case 3:					
							$html .= '<td>'.$equipo->tipo.'</td>';
							$html .= '<td>'.$equipo->pulgadas.'</td>';
						break;		
						
						case 4:					
							$html .= '<td>'.$equipo->idioma.'</td>';
							$html .= '<td>'.$equipo->conexion.'</td>';
						break;	
						
						case 5:					
							$html .= '<td>'.$equipo->tipo.'</td>';
							$html .= '<td>'.$equipo->conexion.'</td>';
						break;	
						
						case 6:					
							$html .= '<td>'.$equipo->tipo.'</td>';
							$html .= '<td>'; $html .= $equipo->cartucho==0?'NO':'SI'; $html .='</td>';
						break;
							
						case 7:					
							$html .= '<td>'.$equipo->tipo.'</td>';
						break;															
					}
				}

				if (in_array('observacion', $opciones))
					$html .= '<td>'.$equipo->observacion.'</td>';
			
				if (in_array('reparacion', $opciones))
					$html .= '<td><input type="text" id="problema_'.$equipo->id.'" name="problema_'.$equipo->id.'"></td>';

				if (in_array('estado', $opciones))
				{
					$estado_id = $equipo->equipos_estados_id;
					$q = $this->db->query("SELECT estado FROM equipos_estados WHERE id=$estado_id");
					$html .= '<td>'.$q->row()->estado.'</td>';
				}

				if (in_array('alquilado', $opciones))
				{
					$equipo_id = $equipo->id;
					$q = $this->db->query("SELECT p.nombre as persona, e.nombre as empresa
																 FROM equipos_alquileres a
																 JOIN equipos_alquileres_has_equipos ea ON ea.equipos_alquileres_id = a.id
																 JOIN clientes_personas_history p ON p.id = a.clientes_personas_history_id
																 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
																 WHERE ea.equipos_id = $equipo_id AND a.estado = 'A'");
					$html .= '<td>';
					$html .= ($q->row()->empresa == '')? $q->row()->persona : $q->row()->empresa;
					$html .= '</td>';
				}
				$html .= '</tr>';
			}
			
			$html .= '</tbody></table>';
		}
		
		if (in_array('xajax', $opciones))
		{
			$resp->assign("salida", "innerHTML", $html);
			$resp->call('table_adds(tabla_equipos)');
			
			return $resp;
		}
		
		return $html;
	}

	//array('id', 'tipo_id')
	function dibujar_equipos_array($array, $menu, $opciones=array(), $onclick='', $variable=NULL)
	{	
		$html = '';
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==1)
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
		
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);
		
		//----------------------------------------------------------------
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==2)
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
			
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);
			
		//----------------------------------------------------------------
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==3)
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
			
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);		  	 			
			
		//----------------------------------------------------------------	
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==4)
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
			
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);
		
		//----------------------------------------------------------------	
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==5)
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
			
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);
				
		//----------------------------------------------------------------	
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==6)	
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
			
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);
		
			
		//----------------------------------------------------------------	
		$flag_1er_ciclo = true;
		$id = '';
		foreach ($array as $value)
			if ($value['tipo_id']==7)
			{
				if ($flag_1er_ciclo)
				{
					$id .= 'e.id = '.$value['id'];
					$flag_1er_ciclo = false;
				}
				else
					$id .= ' OR e.id = '.$value['id'] .' ';
			}
			
		if (!$flag_1er_ciclo)	
			$html .= $this->dibujar_equipos($id,$menu,$opciones,$onclick,$variable);

		return $html;	
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// SELECCIONAR EQUIPOS	
	
	function seleccionar_equipo($id, $tipo_equipo_id)
	{
		$resp=new xajaxResponse();
		
		// flag : si el equipo no esta seleccionado
		$flag = true;
		
		// si hay elementos en el array
		if (isset($_SESSION['equipos_seleccionados']))
		{
			// quitar objeto de array: si el objeto seleccionado ya esta, entonces lo quita
			foreach($_SESSION['equipos_seleccionados'] as $key => $equipo)
			{
				if ($equipo['id'] == $id)
				{
					unset($_SESSION['equipos_seleccionados'][$key]);
					
					$resp->call('highlight', $id.'_true', 'lightgreen');
					$flag = false;
					break;
				}
			}
			
			// si no tiene elementos se borra el array
			if (count($_SESSION['equipos_seleccionados']) == 0)
			{
				unset($_SESSION['equipos_seleccionados']);
				$resp->assign('equipos_seleccionados_container', "innerHTML", '');	
			}
		}
		
		// agregar objeto en array: si el objeto seleccionado no esta, entonces lo agrega
		if ($flag)
		{			
			$_SESSION['equipos_seleccionados'][] = array('id' => $id, 'tipo_id'=> $tipo_equipo_id);							
			$resp->call('highlight', $id.'_false', 'lightgreen');
		}
	
		// Print tabla
		if (isset($_SESSION['equipos_seleccionados']))
		{
			$salida = $this->info_seleccionados();
			//$salida = $_SESSION['equipos_seleccionados'];
			$resp->assign('equipos_seleccionados_container', "innerHTML", $salida);	
		}

		return $resp;                              
	}		
	
	function info_seleccionados()
	{	
		$pcs = $portatiles = $monitores = $teclados = $mouses = $impresoras = $otros = 0;
		
		foreach ($_SESSION['equipos_seleccionados'] as $equipo)
		{
			$equipo_id = $equipo['id'];
			
			$q = $this->db->query("SELECT equipos_tipos_id AS tipo_id FROM equipos WHERE id=$equipo_id");
			
			if ($q->row()->tipo_id == 1)
				$pcs += 1;
			else if ($q->row()->tipo_id == 2)
				$portatiles += 1;			
			else if ($q->row()->tipo_id == 3)
				$monitores += 1;			
			else if ($q->row()->tipo_id == 4)
				$teclados += 1;			
			else if ($q->row()->tipo_id == 5)
				$mouses += 1;			
			else if ($q->row()->tipo_id == 6)
				$impresoras += 1;
			else if ($q->row()->tipo_id == 7)
				$otros += 1;																											
		}
		
		$html = '<h5>Equipos seleccionados</h5>';
		if ($pcs > 0)        $html .= '<p><label>PCs:</label> '.$pcs.'</p>';
		if ($portatiles > 0) $html .= '<p><label>Portatiles:</label> '.$portatiles.'</p>';
		if ($monitores > 0)  $html .= '<p><label>Monitores:</label> '.$monitores.'</p>';
		if ($teclados > 0)   $html .= '<p><label>Teclados:</label> '.$teclados.'</p>';
		if ($mouses > 0)     $html .= '<p><label>Mouses:</label> '.$mouses.'</p>';
		if ($impresoras > 0) $html .= '<p><label>Impresoras:</label> '.$impresoras.'</p>';
		if ($otros > 0)      $html .= '<p><label>Otros:</label> '.$otros.'</p>';
		
		switch ($_SESSION['boton'])
		{
			case 'dar_de_baja':
				$html .= '<input type="button" id="guardar" value="Dar de Baja" onClick="window.location=\''.base_url().'equipos/dar_de_baja2\'">';
			break;
				
			case 'trasladar':
				$html .= '<input type="button" id="guardar" value="Trasladar" onClick="window.location=\''.base_url().'equipos/trasladar2\'">';
			break;
				
			case 'solicitar_traslado':
				$html .= '<input type="button" id="guardar" value="Solicitar Traslado" onClick="window.location=\''.base_url().'equipos/solicitar_traslado2\'">';
			break;
				
			case 'alquilar':
				$html .= '<input type="button" id="guardar" value="Alquilar" onClick="window.location=\''.base_url().'equipos/alquilar2\'">';
			break;
				
			case 'reparar':
				$html .= '<input type="button" id="guardar" value="Reparar" onClick="window.location=\''.base_url().'equipos/solicitar_reparacion2\'">';
			break;
												
			default:
				$html .= '';
		}
		
		return $html;
	}
	
	function equipo_history_id($equipo_id)
	{
		$q = $this->db->query("SELECT id FROM equipos_history WHERE equipos_id=$equipo_id ORDER BY id DESC LIMIT 1");
		
		return $q->row()->id;		
	}
	
	function equipo_id($equipo_history_id)
	{
		$q = $this->db->query("SELECT equipos_id FROM equipos_history WHERE id=$equipo_history_id");
		
		return $q->row()->equipos_id;		
	}	
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// DAR DE BAJA EQUIPO		
	
	function solicitar_dar_de_baja($equipos, $cliente_id)
	{
		$fecha = date("Y-m-d");
		
		// si escogieron algun cliente
		if ($cliente_id != 0)
		{
			$cliente = new cliente;		
			$cliente_id = $cliente->cliente_history_id($cliente_id);
			
			$this->db->query("INSERT INTO equipos_salidas SET fecha='$fecha', clientes_personas_history_id=$cliente_id");
		}
		else
			$this->db->query("INSERT INTO equipos_salidas SET fecha='$fecha'");
			
		$salida_id = $this->db->insert_id();
					
		foreach ($equipos as $equipo)
		{
			$equipo_id = $equipo['id'];
			// estado de equipos = 5 (solicitado para dar de baja)
			$this->db->query("UPDATE equipos SET equipos_estados_id=5 WHERE id=$equipo_id");
			
			$this->db->query("INSERT INTO equipos_salidas_has_equipos SET equipos_id='$equipo_id', equipos_salidas_id=$salida_id");
		}

		$accion = new accion;
		$accion->load('Solicitó dar de baja equipos', 'admin/dar_de_baja_equipos2/'.$salida_id);
		$accion->insert();					
	}
	
	function listar_solicitudes_de_baja()
	{
		$res = $this->db->query("SELECT es.*, c.nombre as persona, e.nombre as empresa, DATE_FORMAT(fecha, '%e de %M %Y') as fecha
														 FROM equipos_salidas es
														 LEFT JOIN clientes_personas_history c ON c.id=es.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id=c.clientes_empresas_history_id
														 ORDER BY es.estado DESC");
		return $res->result();		
	}	
	
	// para la pagina principal
	function listar_solicitudes_de_baja2()
	{
		$res = $this->db->query("SELECT es.*, c.nombre as persona, e.nombre as empresa, DATE_FORMAT(fecha, '%e de %M %Y') as fecha
														 FROM equipos_salidas es
														 LEFT JOIN clientes_personas_history c ON c.id=es.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id=c.clientes_empresas_history_id
														 WHERE es.estado='P'");
		return $res->result();		
	}		
	
	function listar_datos_de_baja($salida_id)
	{
		$res = $this->db->query("SELECT n.*, c.nombre as persona, c.telefono, c.cedula, e.nombre as empresa, e.nit
														 FROM equipos_salidas n
														 LEFT JOIN clientes_personas_history c ON c.id=n.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id=c.clientes_empresas_history_id
														 WHERE n.id=$salida_id");
		return $res->row();			
	}
	
	function listar_equipos_de_baja($salida_id)
	{
		$res = $this->db->query("SELECT e.id, e.equipos_tipos_id 
														 FROM equipos_salidas_has_equipos es 
														 JOIN equipos e ON e.id = es.equipos_id
														 WHERE es.equipos_salidas_id = $salida_id");
		
		$equipos = array();
		
		foreach ($res->result() as $equipo)
			$equipos[] = array('id' => $equipo->id, 'tipo_id' => $equipo->equipos_tipos_id);
		
		return $equipos;		
	}	
	
	function dar_de_baja($salida_id, $equipos)
	{
		$this->db->trans_start();
		
		$res = $this->db->query("SELECT clientes_personas_history_id as cliente_id FROM equipos_salidas WHERE id=$salida_id");
		
		$cliente_id = ($res->num_rows() > 0)? $res->row()->cliente_id : NULL;
		
		$nota = new nota;
		// estado de equipos = 6 (dar de baja)
		$nota->crear_nsa($equipos, $cliente_id, 6, 'Baja de equipos');	
		
		$nota_id = $nota->id;
		
		$this->db->query("UPDATE equipos_salidas SET estado='A', nota_salida_almacen_id=$nota_id WHERE id=$salida_id");
	
		$accion = new accion;
		$accion->load('Dió de baja equipos', 'admin/dar_de_baja_equipos2/'.$salida_id);
		$accion->insert();		
		
		$this->db->trans_complete();
		
		return $nota->id;
	}
	
	function no_dar_de_baja($salida_id, $equipos)
	{
		$this->db->trans_start();
		
		foreach ($equipos as $equipo)
			$this->db->query("UPDATE equipos SET equipos_estados_id=1 WHERE id=$equipo[id]");

		$this->db->query("UPDATE equipos_salidas SET estado='X' WHERE id=$salida_id");
		
		$accion = new accion;
		$accion->load('Rechazó solicitud de baja de equipos', 'admin/dar_de_baja_equipos2/'.$salida_id);
		$accion->insert();	
		
		$this->db->trans_complete();		
	}	

	//-----------------------------------------------------------------------------------------------------------------------------------------
	// TRASLADAR EQUIPO		
		
	function trasladar($equipos)
	{
		$this->db->trans_start();
		
		$fecha = date("Y-m-d H:i:s");
		$sede_id_envio = $_SESSION['usuario']['sede_id'];
		$sede_id_recibido = ($sede_id_envio == 1)? 2 : 1;
		
		$nota = new nota;
		// estado de equipos = 3 (en traslado)
		$nota->crear_nsa($equipos, NULL, 3, 'Traslado de equipos');
		$nota_id = $nota->id;			
		
		$this->db->query("INSERT INTO equipos_traslados 
											SET estado='A', fecha_envio='$fecha', sede_id_envio=$sede_id_envio, sede_id_recibido=$sede_id_recibido, nota_salida_almacen_id=$nota_id");

		$traslado_id = $this->db->insert_id();
		
		foreach ($equipos as $equipo)
		{
			$equipo_id = $equipo['id'];
			// estado de equipos = 7 (solicitado para traslado)
			$this->db->query("UPDATE equipos SET equipos_estados_id=7 WHERE id=$equipo_id");
			
			$this->db->query("INSERT INTO equipos_traslados_has_equipos SET equipos_id='$equipo_id', equipos_traslados_id=$traslado_id");
		}
			
		$accion = new accion;
		$accion->load('Trasladó equipos', 'equipos/traslado/'.$traslado_id);
		$accion->insert();				
								
		$this->db->trans_complete();						
											
		return $nota->id;									
	}
	
	function solicitar_traslado($equipos)
	{
		$fecha = date("Y-m-d H:i:s");
		$sede_id_recibido = $_SESSION['usuario']['sede_id'];
		$sede_id_envio = ($sede_id_recibido == 1)? 2 : 1;
		
		$this->db->query("INSERT INTO equipos_traslados 
											SET estado='P', fecha_solicitud='$fecha', sede_id_envio=$sede_id_envio, sede_id_recibido=$sede_id_recibido");		
		
		$traslado_id = $this->db->insert_id();
		
		foreach ($equipos as $equipo)
		{
			$equipo_id = $equipo['id'];
			// estado de equipos = 7 (solicitado para traslado)
			$this->db->query("UPDATE equipos SET equipos_estados_id=7 WHERE id=$equipo_id");
			
			$this->db->query("INSERT INTO equipos_traslados_has_equipos SET equipos_id='$equipo_id', equipos_traslados_id=$traslado_id");
		}
	
		$accion = new accion;
		$accion->load('Solicitó Traslado', 'equipos/solicitud_traslado/'.$traslado_id);
		$accion->insert();		
	}
	
	function listar_solicitudes_traslado()
	{	
		$res = $this->db->query("SELECT et.id as id, s.ciudad, DATE_FORMAT(et.fecha_solicitud, '%W %e de %M %Y - %l:%i %p') as fecha_solicitud, et.estado
														 FROM equipos_traslados et
														 JOIN sedes s ON s.id = et.sede_id_recibido
														 WHERE et.fecha_solicitud IS NOT NULL
														 ORDER BY id DESC");
													 			
		return $res->result();
	}
	
	//para avisar que tiene solicitudes de traslado en la pagina principal
	function listar_solicitudes_traslado2()
	{	
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		$res = $this->db->query("SELECT id FROM equipos_traslados WHERE estado='P' AND sede_id_envio=$sede_id");
													 			
		return $res->result();
	}	

	function listar_datos_traslado($traslado_id)
	{
		$res = $this->db->query("SELECT t.*, s1.ciudad as sede_envio, s2.ciudad as sede_recibido,
														 DATE_FORMAT(t.fecha_solicitud, '%W %e de %M %Y - %l:%i %p') as fecha_solicitud,
														 DATE_FORMAT(t.fecha_envio, '%W %e de %M %Y - %l:%i %p') as fecha_envio,
														 DATE_FORMAT(t.fecha_recibido, '%W %e de %M %Y - %l:%i %p') as fecha_recibido
														 FROM equipos_traslados t
														 JOIN sedes s1 ON s1.id = t.sede_id_envio 
														 JOIN sedes s2 ON s2.id = t.sede_id_recibido 
														 WHERE t.id=$traslado_id");
		return $res->row();
	}

	function listar_equipos_traslado($traslado_id)
	{
		$res = $this->db->query("SELECT e.id, e.equipos_tipos_id 
														 FROM equipos_traslados_has_equipos et 
														 JOIN equipos e ON e.id = et.equipos_id
														 WHERE et.equipos_traslados_id = $traslado_id");
		
		$equipos = array();
		
		foreach ($res->result() as $equipo)
			$equipos[] = array('id' => $equipo->id, 'tipo_id' => $equipo->equipos_tipos_id);
		
		return $equipos;		
	}
	
	function aceptar_solicitud_traslado($traslado_id, $equipos)
	{
		$fecha = date("Y-m-d H:i:s");
		
		$nota = new nota;
		// estado de equipos = 3 (en traslado)
		$nota->crear_nsa($equipos, NULL, 3, 'Traslado de equipos');
		$nota_id = $nota->id;			
		
		$this->db->query("UPDATE equipos_traslados 
											SET estado='A', fecha_envio='$fecha', nota_salida_almacen_id=$nota_id WHERE id=$traslado_id");

		$accion = new accion;
		$accion->load('Aceptó solicitud de traslado', 'equipos/solicitud_traslado/'.$traslado_id);
		$accion->insert();	
											
		return $nota->id;									
	}
	
	function cancelar_solicitud_traslado($traslado_id)
	{
		$this->db->query("UPDATE equipos_traslados SET estado='C' WHERE id=$traslado_id");
		
		$equipos = $this->listar_equipos_traslado($traslado_id);
		
		foreach($equipos as $equipo)
			$this->actualizar_estado(1, $equipo['id']);
			
		$accion = new accion;
		$accion->load('Canceló solicitud de traslado', 'equipos/solicitud_traslado/'.$traslado_id);
		$accion->insert();				
	}
	
	function listar_traslados($estado)
	{
		$res = $this->db->query("SELECT et.id as id, s1.ciudad as ciudad_envio, s2.ciudad as ciudad_recibir, 
														 DATE_FORMAT(et.fecha_envio, '%W %e de %M %Y - %l:%i %p') as fecha_envio
														 FROM equipos_traslados et
														 JOIN sedes s1 ON s1.id = et.sede_id_envio
														 JOIN sedes s2 ON s2.id = et.sede_id_recibido
														 WHERE et.estado='$estado'");
		return $res->result();
	}
	
	//para avisar que tiene envio de equipos en la pagina principal
	function listar_en_traslado2()
	{		
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		$res = $this->db->query("SELECT id FROM equipos_traslados WHERE estado='A' AND sede_id_recibido=$sede_id");
		return $res->result();
	}	
	
	function recibir_traslado($traslado_id, $equipos)
	{
		$fecha = date("Y-m-d H:i:s");
		
		$nota = new nota;
		// estado de equipos = 1 (disponibles)
		$nota->crear_nea($equipos, NULL, 1, 'Traslado de equipos');
		$nota_id = $nota->id;		
		
		$bodega_id = $_SESSION['usuario']['bodega_id'];
		
		foreach($equipos as $equipo)
			$this->actualizar_bodega($bodega_id, $equipo['id']);
		
		$this->db->query("UPDATE equipos_traslados 
											SET estado='X', fecha_recibido='$fecha', nota_entrada_almacen_id=$nota_id WHERE id=$traslado_id");

		$accion = new accion;
		$accion->load('Recibió equipos en traslado', 'equipos/traslado/'.$traslado_id);
		$accion->insert();	
											
		return $nota->id;									
	}
	
	function permiso_aceptar_traslado($traslado_id)
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		$res = $this->db->query("SELECT sede_id_recibido FROM equipos_traslados WHERE id=$traslado_id");
		
		return $res->row()->sede_id_recibido == $sede_id;
	}

	function permiso_aceptar_solicitud_traslado($traslado_id)
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		$res = $this->db->query("SELECT sede_id_envio FROM equipos_traslados WHERE id=$traslado_id");
		
		return $res->row()->sede_id_envio == $sede_id;
	}		

	//-----------------------------------------------------------------------------------------------------------------------------------------
	// ALQUILAR EQUIPO		
			
	function alquilar($equipos, $cliente_id, $fecha_inicial, $fecha_final, $ubicacion)
	{
		$this->db->trans_start();
		
		$nota = new nota;
		$info = 'Ubicacion de los equipos: '.$ubicacion;
		$nota->crear_nsa($equipos, $cliente_id, 2, 'Remisión', $info);
		$nota_id = $nota->id;
		
		$cliente = new cliente;
		$cliente_id = $cliente->cliente_history_id($cliente_id);
		
		$fecha_inicial = $this->transformar_fecha($fecha_inicial);
		$fecha_final = $this->transformar_fecha($fecha_final);
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		$this->db->query("INSERT INTO equipos_alquileres
											SET fecha_inicial                = '$fecha_inicial',
													fecha_final                  = '$fecha_final',
													ubicacion                    = '$ubicacion',
													estado                       = 'A',
													clientes_personas_history_id = $cliente_id,
													nota_salida_almacen_id       = $nota_id,
													sedes_id                     = $sede_id");
													
		$alquiler_id = $this->db->insert_id();											
													
		$this->db->query("INSERT INTO equipos_alquileres_history
											SET fecha_inicial = '$fecha_inicial',
													fecha_final   = '$fecha_final',
													ubicacion     = '$ubicacion',
													estado        = 'A',
													alquileres_id = $alquiler_id");		
													
		foreach($equipos as $equipo)
			$this->db->query("INSERT INTO equipos_alquileres_has_equipos SET equipos_alquileres_id=$alquiler_id, equipos_id=$equipo[id]");																

		$accion = new accion;
		$accion->load('Alquiló equipos', 'equipos/alquiler/'.$alquiler_id);
		$accion->insert();	
		
		$this->db->trans_complete();
		
		return $nota_id;
	}
	
	function listar_alquileres_vigentes()
	{
		$res = $this->db->query("SELECT a.*, p.nombre as persona, e.nombre as empresa, DATE_FORMAT(a.fecha_inicial, '%e de %M %Y') as fecha_inicial, 
														 DATE_FORMAT(fecha_final, '%e de %M %Y') as fecha_final, s.ciudad as sede
														 FROM equipos_alquileres a
														 LEFT JOIN clientes_personas_history p ON p.id = a.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
														 JOIN sedes s ON s.id = a.sedes_id
														 WHERE a.estado='A' ORDER BY a.fecha_final DESC");
														 
		return $res->result();														 
	}
	
	//para avisar que tiene alquileres vigentes en la pagina principal
	function listar_alquileres_vigentes2()
	{	
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if (permiso('superadmin'))
			$res = $this->db->query("SELECT id FROM equipos_alquileres WHERE estado='A'");
		else
			$res = $this->db->query("SELECT id FROM equipos_alquileres WHERE estado='A' AND sedes_id=$sede_id");
														 
		return $res->result();														 
	}	
	
	function listar_alquileres_terminados()
	{
		$res = $this->db->query("SELECT a.*, p.nombre as persona, e.nombre as empresa, DATE_FORMAT(a.fecha_inicial, '%e de %M %Y') as fecha_inicial, 
														 DATE_FORMAT(fecha_final, '%e de %M %Y') as fecha_final, s.ciudad as sede
														 FROM equipos_alquileres a
														 LEFT JOIN clientes_personas_history p ON p.id = a.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
														 JOIN sedes s ON s.id = a.sedes_id
														 WHERE a.estado='X'");
														 
		return $res->result();														 
	}	
	
	function listar_datos_alquiler($alquiler_id)
	{
		$res = $this->db->query("SELECT a.*, p.nombre as persona, e.nombre as empresa, DATE_FORMAT(a.fecha_inicial, '%e de %M %Y') as fecha_inicial, 
														 DATE_FORMAT(fecha_final, '%e de %M %Y') as fecha_final, e.*, p.*, a.id as id, p2.id as cliente_id, p.direccion as direccion_persona,
														 e.direccion as direccion_empresa
														 FROM equipos_alquileres a
														 LEFT JOIN clientes_personas_history p ON p.id = a.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id		
														 LEFT JOIN clientes_personas p2 ON p2.id = p.clientes_personas_id												 
														 WHERE a.id=$alquiler_id");
		
		return $res->row();
	}
	
	function listar_equipos_alquiler($alquiler_id)
	{
		$res = $this->db->query("SELECT e.id, e.equipos_tipos_id 
														 FROM equipos_alquileres_has_equipos ea 
														 JOIN equipos e ON e.id = ea.equipos_id
														 WHERE ea.equipos_alquileres_id = $alquiler_id");
		
		$equipos = array();
		
		foreach ($res->result() as $equipo)
			$equipos[] = array('id' => $equipo->id, 'tipo_id' => $equipo->equipos_tipos_id);
		
		return $equipos;		
	}
	
	function terminar_alquiler($alquiler_id)
	{
		$this->db->trans_start();
		
		$res = $this->db->query("SELECT clientes_personas_history_id FROM equipos_alquileres WHERE id=$alquiler_id");
		$equipos = $this->listar_equipos_alquiler($alquiler_id);
		
		$cliente = new cliente;
		$cliente_id = $cliente->cliente_id($res->row()->clientes_personas_history_id);
		
		$nota = new nota;
		$nota->crear_nea($equipos, $cliente_id, 1, 'Finiquito');
		$nota_id = $nota->id;
		
		$this->db->query("UPDATE equipos_alquileres SET estado='X', nota_entrada_almacen_id=$nota_id WHERE id=$alquiler_id");

		$accion = new accion;
		$accion->load('Terminó alquiler', 'equipos/alquiler/'.$alquiler_id);
		$accion->insert();	
		
		$this->db->trans_complete();
		
		return $nota_id;
	}
	
	function permiso_alquiler($alquiler_id)
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		$res = $this->db->query("SELECT sedes_id FROM equipos_alquileres WHERE id=$alquiler_id");
		
		return $res->row()->sedes_id == $sede_id;
	}	
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// ALQUILAR EQUIPO - CAMBIOS	
	
	//para prorrogar contrato
	function mostrar_fecha()
	{
		$resp=new xajaxResponse();
		
		$html = '<input type="text" name="fecha_final" id="fecha_final">';
		
		$html2 = '<input type="submit" name="prorrogar" id="prorrogar" class="boton_guardar" value="Prorrogar">
							<input type="submit" name="cancelar" id="cancelar" value="Cancelar">';
		
		$resp->call('mostrar_calendario()');
		
		$resp->assign("span_fecha", "innerHTML", $html);
		$resp->assign("mostrar_calendario", "style.visibility", 'visible');
		$resp->assign("fecha_final", "style.width", '100px');
		$resp->assign("mostrar_botones", "innerHTML", $html2);
		
		return $resp;
	}
	
	function prorrogar_alquiler($alquiler_id, $fecha_final)
	{
		$this->db->trans_start();
		
		$fecha_final = $this->transformar_fecha($fecha_final);
		
		$this->db->query("UPDATE equipos_alquileres SET fecha_final='$fecha_final' WHERE id=$alquiler_id");
		
		$this->db->query("INSERT INTO equipos_alquileres_history
											SET fecha_final   = '$fecha_final',
													alquileres_id = $alquiler_id");		
													
		$accion = new accion;
		$accion->load('Prorrogó alquiler', 'equipos/alquiler/'.$alquiler_id);
		$accion->insert();	
		
		$this->db->trans_complete();													
	}
	
	function retirar_equipo($equipo_id)
	{
		$resp=new xajaxResponse();
		
		$_SESSION['equipos_in'][] = array('id' => $equipo_id);
		
		foreach ($_SESSION['equipos'] as $key => $equipo)
			if ($equipo['id'] == $equipo_id)
				unset($_SESSION['equipos'][$key]);
		
		$html = $this->mostrar_info_cambio();
		
		$resp->assign("span_info", "innerHTML", $html);
		
		return $resp;
	}
	
	function cambiar_equipo($equipo_out_id, $equipo_in_id)
	{
		$resp=new xajaxResponse();
		
		foreach ($_SESSION['equipos'] as $key => $equipo)
			if ($equipo['id'] == $equipo_in_id)
				unset($_SESSION['equipos'][$key]);
				
		$this->select($equipo_out_id);
	
		$_SESSION['equipos_in'][] = array('id' => $equipo_in_id);
		$_SESSION['equipos_out'][] = array('id' => $equipo_out_id);			
				
		$_SESSION['equipos'][] = array('id' => $equipo_out_id, 'tipo_id' => $this->tipo_equipo_id);		
		
		$resp->redirect(base_url().'equipos/alquiler_cambios/'.$_SESSION['alquiler_id']);
		
		return $resp;		
	}
	
	function mostrar_info_cambio()
	{
		$html = '<h4>Cambios:</h4>';
		
		$html .= '<p>Equipos salientes: '; 
		
		if (count($_SESSION['equipos_out']) == 0)
			$html .= '0' ;
		else												
			foreach ($_SESSION['equipos_out'] as $equipo)
			{
				$this->select($equipo['id']);
				$html .= $this->inventario.'-';
			}
				
		$html .= '</p>';
			
		$html .= '<p>Equipos entrantes: ';
		 
		if (count($_SESSION['equipos_in']) == 0)
			$html .= '0' ;
		else												
			foreach ($_SESSION['equipos_in'] as $equipo)
			{
				$this->select($equipo['id']);
				$html .= $this->inventario.'-';
			}
				
		$html .= '</p>';
		
		return $html;
	}	
	
	//equipos in: equipos que entran a la empresa, equipos out: equipos que salen de la empresa
	function guardar_cambios($alquiler_id, $equipos_in, $equipos_out)
	{
		$this->db->trans_start();
		
		$fecha = date("Y-m-d H:i:s");
		
		foreach($equipos_in as $equipo)
		{
			$this->actualizar_estado(1, $equipo['id']);
			$this->db->query("DELETE FROM equipos_alquileres_has_equipos WHERE equipos_id=$equipo[id]");
		}

		foreach($equipos_out as $equipo)
		{
			$this->actualizar_estado(2, $equipo['id']);
			$this->db->query("INSERT INTO equipos_alquileres_has_equipos SET equipos_id=$equipo[id], equipos_alquileres_id=$alquiler_id");
		}		
		
		$nota = new nota;
		$cliente = $this->listar_datos_alquiler($alquiler_id);
		
		if (count($equipos_in) > 0 && count($equipos_out) == 0)
		{
			$nota->crear_nea($equipos_in, $cliente->cliente_id, 1, 'Cambio de Equipos');
			$nea_id = $nota->id;
			$this->db->query("INSERT INTO equipos_alquileres_cambios 
												SET equipos_alquileres_id=$alquiler_id, nota_entrada_almacen_id=$nea_id, fecha='$fecha'");			
		}
		else if (count($equipos_out) > 0 && count($equipos_in) == 0)
		{
			$nota->crear_nsa($equipos_out, $cliente->cliente_id, 2, 'Cambio de Equipos');
			$nsa_id = $nota->id;
			$this->db->query("INSERT INTO equipos_alquileres_cambios 
												SET equipos_alquileres_id=$alquiler_id, nota_salida_almacen_id=$nsa_id, fecha='$fecha'");			
		}
		else
		{
			$nota->crear_nea($equipos_in, $cliente->cliente_id, 1, 'Cambio de Equipos');
			$nea_id = $nota->id;		
			
			$nota->crear_nsa($equipos_out, $cliente->cliente_id, 2, 'Cambio de Equipos');
			$nsa_id = $nota->id;			
				
			$this->db->query("INSERT INTO equipos_alquileres_cambios 
												SET equipos_alquileres_id=$alquiler_id, nota_entrada_almacen_id=$nea_id, nota_salida_almacen_id=$nsa_id, fecha='$fecha'");
		}

		$accion = new accion;
		$accion->load('Hizo cambio de equipos a alquiler', 'equipos/alquiler/'.$alquiler_id);
		$accion->insert();	
		
		$this->db->trans_complete();
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// ALQUILAR EQUIPO - HISTORIAL
	
	// cambios de equipos
	function listar_cambios_alquiler_historial($alquiler_id)
	{
		$res = $this->db->query("SELECT *, DATE_FORMAT(fecha, '%e de %M %Y') as fecha FROM equipos_alquileres_cambios WHERE equipos_alquileres_id=$alquiler_id");
		return $res->result();
	}
	
	// cambios de fecha (prorrogacion)
	function listar_cambios_alquiler_historial2($alquiler_id)
	{
		$res = $this->db->query("SELECT *, DATE_FORMAT(fecha_inicial, '%e de %M %Y') as fecha_inicial, DATE_FORMAT(fecha_final, '%e de %M %Y') as fecha_final 
														FROM equipos_alquileres_history 
														WHERE alquileres_id=$alquiler_id");
		return $res->result();
	}
	
	//-----------------------------------------------------------------------------------------------------------------------------------------
	// REPARAR EQUIPO 
	
	function listar_tecnicos()
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		$res = $this->db->query("SELECT id, nombre FROM usuarios WHERE acceso='tecnico' AND sedes_id=$sede_id");
		return $res->result();
	}
	
	function reparacion_interna($equipo_id, $problema)
	{
		$this->db->trans_start();
		
		$fecha = date("Y-m-d H:i:s");
		
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		$this->actualizar_estado(4, $equipo_id);
		
		$equipo_id = $this->equipo_history_id($equipo_id);
		
		$this->db->query("INSERT INTO equipos_reparaciones 
											SET equipos_history_id=$equipo_id, fecha_solicitud='$fecha', sedes_id=$sede_id, problema='$problema'");

		$reparacion_id = $this->db->insert_id();

		$accion = new accion;
		$accion->load('Envió equipo a reparación interna', 'equipos/reparacion/'.$reparacion_id);
		$accion->insert();	
		
		$this->db->trans_complete();
	}
	
	function reparacion_externa2($equipo_id, $cliente_id, $problema)
	{
		$this->db->trans_start();

		$fecha = date("Y-m-d H:i:s");
		
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		$this->actualizar_estado(4, $equipo_id);	

		$equipo_id = $this->equipo_history_id($equipo_id);

		$cliente = new cliente;
		$cliente_id = $cliente->cliente_history_id($cliente_id);
		
		$this->db->query("INSERT INTO equipos_reparaciones 
											SET equipos_history_id           = $equipo_id, 
													clientes_personas_history_id = $cliente_id, 
													fecha_solicitud              = '$fecha', 
													sedes_id                     = $sede_id, 
													problema                     = '$problema'");		
		
		$this->db->trans_complete();
	}
	
	function reparacion_externa($equipos, $cliente_id)
	{
		$nota = new nota;											
		$nota->crear_nsa($equipos, $cliente_id, 4, 'Reparación de equipos');
		$nota_id = $nota->id;		

		$cliente = new cliente;
		$cliente_id = $cliente->cliente_history_id($cliente_id);
		
		$fecha = date("Y-m-d H:i:s");
		
		$sede_id = $_SESSION['usuario']['sede_id'];		
		
		$this->db->query("INSERT INTO equipos_reparaciones_externas SET fecha_inicial='$fecha', sedes_id=$sede_id, nota_salida_almacen_id=$nota_id,
											clientes_personas_history_id=$cliente_id");

		$reparacion_id = $this->db->insert_id();

		$accion = new accion;
		$accion->load('Envió equipos a reparación externa', 'equipos/reparacion_externa/'.$reparacion_id);
		$accion->insert();	
		
		return $nota_id;
	}
	
	function listar_reparaciones_internas($estado)
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if (permiso('superadmin'))
			$res = $this->db->query("SELECT r.*, s.ciudad as sede, e.inventario, t.tipo, DATE_FORMAT(r.fecha_solicitud, '%W %e de %M %Y - %l:%i %p') as fecha_solicitud
															 FROM equipos_reparaciones r 
															 JOIN sedes s ON s.id = r.sedes_id
															 JOIN equipos_history e ON e.id = r.equipos_history_id
															 JOIN equipos_tipos	t ON t.id = e.equipos_tipos_id
															 WHERE r.estado = '$estado' AND ISNULL(r.clientes_personas_history_id)");
		else
			$res = $this->db->query("SELECT r.*, s.ciudad as sede, e.inventario, t.tipo, DATE_FORMAT(r.fecha_solicitud, '%W %e de %M %Y - %l:%i %p') as fecha_solicitud
															 FROM equipos_reparaciones r 
															 JOIN sedes s ON s.id = r.sedes_id
															 JOIN equipos_history e ON e.id = r.equipos_history_id
															 JOIN equipos_tipos	t ON t.id = e.equipos_tipos_id
															 WHERE r.estado = '$estado' AND ISNULL(r.clientes_personas_history_id) AND r.sedes_id=$sede_id");		
		
		return $res->result();
	}

	function listar_reparaciones_externas($estado)
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if (permiso('superadmin'))		
			$res = $this->db->query("SELECT r.*, e.nombre as empresa, p.nombre as persona, s.ciudad as sede, DATE_FORMAT(r.fecha_inicial, '%W %e de %M %Y - %l:%i %p') as fecha_inicial
															 FROM equipos_reparaciones_externas r 
															 JOIN sedes s ON s.id = r.sedes_id											 
															 JOIN clientes_personas_history p ON p.id = r.clientes_personas_history_id
															 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
															 WHERE r.estado = '$estado'");
		else
			$res = $this->db->query("SELECT r.*, e.nombre as empresa, p.nombre as persona, s.ciudad as sede, DATE_FORMAT(r.fecha_inicial, '%W %e de %M %Y - %l:%i %p') as fecha_inicial
															 FROM equipos_reparaciones_externas r 
															 JOIN sedes s ON s.id = r.sedes_id											 
															 JOIN clientes_personas_history p ON p.id = r.clientes_personas_history_id
															 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
															 WHERE r.estado = '$estado' AND r.sedes_id=$sede_id");		
		
		return $res->result();
	}
	
	function listar_reparaciones_externas2($estado)
	{
		$sede_id = $_SESSION['usuario']['sede_id'];
		
		if (permiso('superadmin'))			
			$res = $this->db->query("SELECT r.*, e.nombre as empresa, p.nombre as persona, s.ciudad as sede, eq.inventario, t.tipo, DATE_FORMAT(r.fecha_solicitud, '%W %e de %M %Y - %l:%i %p') as fecha_solicitud
															 FROM equipos_reparaciones r 
															 JOIN sedes s ON s.id = r.sedes_id
															 JOIN equipos_history eq ON eq.id = r.equipos_history_id
															 JOIN equipos_tipos	t ON t.id = eq.equipos_tipos_id									 
															 JOIN clientes_personas_history p ON p.id = r.clientes_personas_history_id
															 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
															 WHERE r.estado = '$estado'");
		else
			$res = $this->db->query("SELECT r.*, e.nombre as empresa, p.nombre as persona, s.ciudad as sede, eq.inventario, t.tipo, DATE_FORMAT(r.fecha_solicitud, '%W %e de %M %Y - %l:%i %p') as fecha_solicitud
														 FROM equipos_reparaciones r 
														 JOIN sedes s ON s.id = r.sedes_id
														 JOIN equipos_history eq ON eq.id = r.equipos_history_id
														 JOIN equipos_tipos	t ON t.id = eq.equipos_tipos_id									 
														 JOIN clientes_personas_history p ON p.id = r.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
														 WHERE r.estado = '$estado' AND r.sedes_id=$sede_id");
															 	
		return $res->result();
	}	
	
	function listar_datos_reparacion($reparacion_id)
	{
		$res = $this->db->query("SELECT r.*, u.nombre as tecnico, e.nombre as empresa, s.ciudad as sede
														 FROM equipos_reparaciones r 
														 JOIN sedes s ON s.id = r.sedes_id
														 LEFT JOIN usuarios u ON u.id = r.usuarios_id
														 LEFT JOIN clientes_personas_history p ON p.id = r.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
														 WHERE r.id=$reparacion_id");
		return $res->row();		
	}
	
	function listar_datos_reparacion_externa($reparacion_id)
	{
		$res = $this->db->query("SELECT r.*, e.nombre as empresa, p.nombre as persona, s.ciudad as sede
														 FROM equipos_reparaciones_externas r 
														 JOIN sedes s ON s.id = r.sedes_id
														 JOIN clientes_personas_history p ON p.id = r.clientes_personas_history_id
														 LEFT JOIN clientes_empresas_history e ON e.id = p.clientes_empresas_history_id
														 WHERE r.id=$reparacion_id");
		return $res->row();
	}
	
	function listar_equipos_reparacion_externa($reparacion_id)
	{
		$res = $this->db->query("SELECT e.equipos_id, e.equipos_tipos_id
														 FROM nota_salida_almacen n 
														 JOIN equipos_reparaciones_externas r ON r.nota_salida_almacen_id = n.id
														 JOIN nota_salida_almacen_has_equipos ne ON ne.nota_salida_almacen_id = n.id
														 JOIN equipos_history e ON e.id = ne.equipos_history_id
														 WHERE r.id = $reparacion_id");
		
		$equipos = array();
		
		foreach ($res->result() as $equipo)
			$equipos[] = array('id' => $equipo->equipos_id, 'tipo_id' => $equipo->equipos_tipos_id);
		
		return $equipos;			
	}
	
	function reparar($reparacion_id, $solucion)
	{
		$this->db->trans_start();
		
		$fecha = date("Y-m-d H:i:s");
		
		$datos = $this->listar_datos_reparacion($reparacion_id);
	
		$equipo_id = $this->equipo_id($datos->equipos_history_id);
		
		$equipo_history_id = $this->equipo_history_id($equipo_id);
		
		$this->actualizar_estado(1, $equipo_id);	
		
		$this->db->query("UPDATE equipos_reparaciones 
											SET fecha_final         = '$fecha', 
													estado              = 'X', 
													solucion            = '$solucion', 
													equipos_history_id1 = $equipo_history_id  
											WHERE id=$reparacion_id");
		
		$accion = new accion;
		if (isset($datos->clientes_personas_history_id))
			$accion->load('Guardó datos de reparación externa', 'equipos/reparacion/'.$reparacion_id);
		else
			$accion->load('Guardó datos de reparación interna', 'equipos/reparacion/'.$reparacion_id);
		$accion->insert();		

		$this->db->trans_complete();		
	}
	
	function terminar_reparacion_externa($reparacion_id)
	{
		$fecha = date("Y-m-d H:i:s");
		
		$equipos = $this->listar_equipos_reparacion_externa($reparacion_id);
		
		$datos = $this->listar_datos_reparacion_externa($reparacion_id);
				
		$cliente = new cliente;		
		$cliente_id = $cliente->cliente_id($datos->clientes_personas_history_id);		
				
		$nota = new nota;											
		$nota->crear_nea($equipos, $cliente_id, 4, 'Reparación de equipos');
		$nota_id = $nota->id;			
		
		$this->db->query("UPDATE equipos_reparaciones_externas SET fecha_final='$fecha', estado='X', nota_entrada_almacen_id=$nota_id WHERE id=$reparacion_id");
		
		$accion = new accion;
		$accion->load('Recibió equipos de reparación externa', 'equipos/reparacion_externa/'.$reparacion_id);
		$accion->insert();			
		
		return $nota_id;
	}

	//-----------------------------------------------------------------------------------------------------------------------------------------
	// HISTORIAL EQUIPO 
	
	function listar_reparaciones($equipo_id)
	{
		$res = $this->db->query("SELECT r.* 
															FROM equipos_reparaciones r
															JOIN equipos_history e ON e.id = r.equipos_history_id
															WHERE e.equipos_id=$equipo_id ORDER BY r.id DESC");
		return $res->result();		
	}

	function listar_alquileres($equipo_id)
	{
		$res = $this->db->query("SELECT a.* 
															FROM equipos_alquileres a
															LEFT JOIN equipos_alquileres_cambios c ON c.equipos_alquileres_id = a.id
															LEFT JOIN nota_salida_almacen_has_equipos e ON e.nota_salida_almacen_id = a.nota_salida_almacen_id OR 
																																				e.nota_salida_almacen_id = c.nota_salida_almacen_id
															JOIN equipos_history h ON h.id = e.equipos_history_id																					
															WHERE h.equipos_id=$equipo_id GROUP BY a.id ORDER BY a.id DESC");
		return $res->result();		
	}
	
	function listar_nsa($equipo_id)
	{
		$res = $this->db->query("SELECT n.*
														 FROM nota_salida_almacen n
														 JOIN nota_salida_almacen_has_equipos ne ON ne.nota_salida_almacen_id = n.id
														 JOIN equipos_history eh ON eh.id = ne.equipos_history_id
														 WHERE eh.equipos_id = $equipo_id");
												 
		return $res->result();												 
	}
		
	function listar_nea($equipo_id)
	{
		$res = $this->db->query("SELECT n.*
														 FROM nota_entrada_almacen n
														 JOIN nota_entrada_almacen_has_equipos ne ON ne.nota_entrada_almacen_id = n.id
														 JOIN equipos_history eh ON eh.id = ne.equipos_history_id
														 WHERE eh.equipos_id = $equipo_id");
												 
		return $res->result();												 
	}		
	
	function reporte($estado_id=1, $tipo_equipo='todos')
	{		
			$tipo_equipo = ($tipo_equipo == 'todos')? '' : 'AND e.equipos_tipos_id = '.$tipo_equipo;
			
			return $this->db->query("SELECT ee.estado, et.tipo as tipo , eot.tipo as detalle, e.inventario, e.marca, e.modelo 
															 FROM equipos e
															 JOIN equipos_estados ee ON ee.id = e.equipos_estados_id
															 JOIN equipos_tipos et ON et.id = e.equipos_tipos_id
															 LEFT JOIN equipos_otros eo ON eo.equipos_id = e.id
															 LEFT JOIN equipos_otros_tipos eot ON eot.id = eo.equipos_otros_tipos_id															 
															 WHERE e.equipos_estados_id = $estado_id
															 $tipo_equipo");
	
	}
	
			
}