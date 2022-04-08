<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class cliente extends CI_Model
{
	function sugestion_clientes($algo, $posx, $posy)
	{
		$resp=new xajaxResponse();
		
		if ($algo!='')
		{
			$salida = '';
			
			$q1 = $this->db->query("SELECT nombre, id FROM clientes_personas WHERE nombre like '%$algo%' AND ISNULL(clientes_empresas_id) ORDER BY nombre LIMIT 35");
			
			if ($q1->num_rows() > 0)
				$salida .= '<span class="sugestiones_titulo">Personas</span>';
			
			foreach ($q1->result_array() as $row1)
			{
				$salida .= '<div class="sugestiones" id="persona_'.$row1['id'].'"
				onclick="document.getElementById(\'buscar\').value = this.innerHTML; 
						document.getElementById(\'sugestion_container\').style.display=\'none\';
						guardar_id(\''.$row1['id'].'\');
						xajax_mostrar_info_persona('.$row1['id'].');" 
						>'.$row1['nombre'].'</span>';
			}
			
			$q2 = $this->db->query("SELECT distinct(nombre) as empresa, id FROM clientes_empresas WHERE nombre like '%$algo%' ORDER BY nombre LIMIT 35");
			
			if ($q2->num_rows() > 0)
				$salida .= '<span class="sugestiones_titulo">Empresas</span>';
			
			foreach ($q2->result_array() as $row2)
			{
				$salida .= '<span class="sugestiones" id="empresa_'.$row2['id'].'"
										onclick="document.getElementById(\'buscar\').value = this.innerHTML; 
															document.getElementById(\'sugestion_container\').style.display=\'none\';
															xajax_mostrar_contactos('.$row2['id'].');" 		
										>'.$row2['empresa'].'</span>';
			}		
			
			if ($q1->num_rows() > 0 || $q2->num_rows() > 0)
				$resp->assign('sugestion_container', "style.display", 'block');
			else
				$resp->assign('sugestion_container', "style.display", 'none');			
	
			$resp->assign('sugestion_container', "innerHTML", $salida);	
		}
		else
			$resp->assign('sugestion_container', "style.display", 'none');
		
		$resp->assign('sugestion_container', "style.position", 'absolute');		
		$resp->assign('sugestion_container', "style.left", $posx.'px');
		$resp->assign('sugestion_container', "style.top", $posy.'px');	
		
		return $resp;     	
	}

	function mostrar_contactos($empresa_id)
	{	
		$resp=new xajaxResponse();
		
		$contenido = '<select name="select_contacto" id="select_contacto" 
								onChange="guardar_id(this.options[this.selectedIndex].value); xajax_mostrar_info_empresa(this.options[this.selectedIndex].value);">
									 <option value="null" select="selected">Seleccione el contacto</option>';
		 
		$q = $this->db->query("SELECT id, nombre FROM clientes_personas WHERE clientes_empresas_id=$empresa_id");
	
		foreach ($q->result_array() as $row)
			$contenido .= '<option value="'.$row['id'].'">'.$row['nombre'].'</option>';
	
		$contenido .= '</select>';
	
		$resp->assign('contactos', "innerHTML", $contenido);
		
		return $resp; 	
	}
	
	function mostrar_info_persona($persona_id)
	{
		$resp=new xajaxResponse();
		 
		$q = $this->db->query("SELECT * FROM clientes_personas WHERE id=$persona_id");
		
		$contenido = '<p><b>'.$q->row()->nombre.'</b></p>
									<p><b>C.C. '.$q->row()->cedula.'</b></p>
									<p><b>Tel. '.$q->row()->telefono.'</b></p>';
	
		$resp->assign('cliente_info', "innerHTML", $contenido);
		
		return $resp; 		
	}

	function mostrar_info_empresa($contacto_id)
	{
		$resp=new xajaxResponse();
		 
		$q = $this->db->query("SELECT e.* FROM clientes_empresas e, clientes_personas p WHERE p.id=$contacto_id AND p.clientes_empresas_id=e.id");
		
		$contenido = '<p><b>'.$q->row()->nombre.'</b></p>
									<p><b>NIT '.$q->row()->nit.'</b></p>
									<p><b>Tel. '.$q->row()->telefono.'</b></p>';
	
		$resp->assign('cliente_info', "innerHTML", $contenido);
		
		return $resp; 		
	}
	
	function cliente_history_id($persona_id)
	{
		$q = $this->db->query("SELECT id FROM clientes_personas_history WHERE clientes_personas_id=$persona_id ORDER BY id DESC LIMIT 1");
		
		return $q->row()->id;
	}
	
	function cliente_id($persona_history_id)
	{
		$q = $this->db->query("SELECT clientes_personas_id FROM clientes_personas_history WHERE id=$persona_history_id");
		
		return $q->row()->clientes_personas_id;		
	}		
	
}