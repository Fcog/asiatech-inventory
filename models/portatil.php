<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class portatil extends equipo
{
	public $cpu;
	public $memoria;
	public $memoria_inv;
	public $memoria_serial;
	public $disco_duro;
	public $disco_duro_inv;
	public $disco_duro_serial;
	public $unidad_optica;
	public $unidad_optica_inv;
	public $unidad_optica_serial;
	public $pantalla;
	public $bateria_inv;
	public $wireless;
	public $webcam;

	public function getWireless(){ return ($this->wireless==1) ? 'Si':'No'; }
	
	public function getWebcam(){ return ($this->webcam==1) ? 'Si':'No'; }	

	public function load($inventario, $serial, $marca, $modelo, $bodega_id, $estado_id, $empresa_id, $cpu, $memoria, $memoria_inv, $memoria_serial, $disco_duro, 
	$disco_duro_inv, $disco_duro_serial, $unidad_optica, $unidad_optica_inv, $unidad_optica_serial, $pantalla, $bateria_inv, $wireless, $webcam, $observacion)
	{ 
	  parent::load($inventario, $serial, 2, $marca, $modelo, $bodega_id, $estado_id, $empresa_id, $observacion);

		$this->cpu                  = $cpu; 
		$this->memoria              = $memoria;
		$this->memoria_inv          = $memoria_inv;
		$this->memoria_serial       = $memoria_serial;
		$this->disco_duro           = $disco_duro; 
		$this->disco_duro_inv       = $disco_duro_inv; 
		$this->disco_duro_serial    = $disco_duro_serial; 
		$this->unidad_optica        = ucwords($unidad_optica);
		$this->unidad_optica_inv    = $unidad_optica_inv;
		$this->unidad_optica_serial = $unidad_optica_serial;
		$this->pantalla             = $pantalla;
		$this->bateria_inv          = $bateria_inv;
		$this->wireless             = $wireless;
		$this->webcam               = $webcam;
	}
				
	public function select($id)
	{
		parent::select($id);
				
		$query = $this->db->query("SELECT * FROM equipos_portatiles WHERE equipos_id='$id'");
		$datos = $query->row();
		
		$this->cpu                  = $datos->cpu; 
		$this->memoria              = $datos->memoria; 
		$this->memoria_inv          = $datos->memoria_inv; 
		$this->memoria_serial       = $datos->memoria_serial; 
		$this->disco_duro           = $datos->disco_duro; 
		$this->disco_duro_inv       = $datos->disco_duro_inv; 
		$this->disco_duro_serial    = $datos->disco_duro_serial; 
		$this->unidad_optica        = $datos->unidad_optica;
		$this->unidad_optica_inv    = $datos->unidad_optica_inv;
		$this->unidad_optica_serial = $datos->unidad_optica_serial;
		$this->pantalla             = $datos->pantalla;
		$this->bateria_inv          = $datos->bateria_inv;
		$this->wireless             = $datos->wireless;
		$this->webcam               = $datos->webcam;
	}
	
	public function insert()
	{
		$res1 = parent::insert();
		
		$res2 = $this->db->query("INSERT INTO equipos_portatiles SET 
															equipos_id           = '$this->id',
															cpu                  = '$this->cpu', 
															memoria              = '$this->memoria', 
															memoria_inv          = '$this->memoria_inv', 
															memoria_serial       = '$this->memoria_serial',
								 							disco_duro           = '$this->disco_duro', 
															disco_duro_inv       = '$this->disco_duro_inv', 
															disco_duro_serial    = '$this->disco_duro_serial', 		
															unidad_optica        = '$this->unidad_optica', 
															unidad_optica_inv    = '$this->unidad_optica_inv', 
															unidad_optica_serial = '$this->unidad_optica_serial', 
															pantalla             = '$this->pantalla', 
															bateria_inv          = '$this->bateria_inv', 
															wireless             = '$this->wireless', 
															webcam               = '$this->webcam'");		

		$res3 = $this->db->query("INSERT INTO equipos_portatiles_history SET 
															equipos_history_id   = '$this->history_id',
															cpu                  = '$this->cpu', 
															memoria              = '$this->memoria', 
															memoria_inv          = '$this->memoria_inv', 
															memoria_serial       = '$this->memoria_serial',
								 							disco_duro           = '$this->disco_duro', 
															disco_duro_inv       = '$this->disco_duro_inv', 
															disco_duro_serial    = '$this->disco_duro_serial', 		
															unidad_optica        = '$this->unidad_optica', 
															unidad_optica_inv    = '$this->unidad_optica_inv', 
															unidad_optica_serial = '$this->unidad_optica_serial', 
															pantalla             = '$this->pantalla', 
															bateria_inv          = '$this->bateria_inv', 
															wireless             = '$this->wireless', 
															webcam               = '$this->webcam'");		

		
		return ($res1 && $res2 && $res3);
	}
	
	public function update()
	{
		$this->db->trans_start();
		
		parent::update();
		
		$this->db->query("UPDATE equipos_portatiles 
											SET cpu									 = '$this->cpu', 
													memoria            	 = '$this->memoria',
													memoria_inv					 = '$this->memoria_inv', 
													memoria_serial			 = '$this->memoria_serial',  
													disco_duro					 = '$this->disco_duro', 
													disco_duro_inv			 = '$this->disco_duro_inv', 
													disco_duro_serial		 = '$this->disco_duro_serial', 
													unidad_optica				 = '$this->unidad_optica', 
													unidad_optica_inv		 = '$this->unidad_optica_inv',
													unidad_optica_serial = '$this->unidad_optica_serial',
													pantalla  				   = '$this->pantalla', 
													bateria_inv					 = '$this->bateria_inv', 
													wireless						 = '$this->wireless', 
													webcam							 = '$this->webcam' 
											WHERE equipos_id='$this->id'");

		$this->db->query("INSERT INTO equipos_portatiles_history 
											SET equipos_history_id   = '$this->history_id',
													cpu                  = '$this->cpu', 
													memoria              = '$this->memoria', 
													memoria_inv          = '$this->memoria_inv', 
													memoria_serial       = '$this->memoria_serial',
													disco_duro           = '$this->disco_duro', 
													disco_duro_inv       = '$this->disco_duro_inv', 
													disco_duro_serial    = '$this->disco_duro_serial', 		
													unidad_optica        = '$this->unidad_optica', 
													unidad_optica_inv    = '$this->unidad_optica_inv', 
													unidad_optica_serial = '$this->unidad_optica_serial', 
													pantalla             = '$this->pantalla', 
													bateria_inv          = '$this->bateria_inv', 
													wireless             = '$this->wireless', 
													webcam               = '$this->webcam'");					

		$this->db->trans_complete();
	}


}
?>