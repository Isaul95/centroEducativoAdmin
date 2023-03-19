<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_GradosGrupos extends CI_Model { // INICIO DEL MODELO

////////////////////////////// PERIODO ESCOLAR //////////////////////////////////////////
public function obtenergrados(){
    $this->db->select("id_grado_grupo,nombre,descripcion");
$this->db->from("grado_grupo");
 // $this->db->where("Cantidad !=0");
$resultados = $this->db->get();
return $resultados->result();
}
///////////////////////////////BORRAR PERIODOS //////////////////////////////////////////

public function delete_entry($id)
{
    return $this->db->delete('grado_grupo', array('id_grado_grupo' => $id));
}

//////////////////////////////  INSERTAR PERIODOS ///////////////////////////////////////
public function insert_entry($data)
    {
        return $this->db->insert('grado_grupo', $data);
    }

///////////////////////////// OBTENER PERIODOS POR ID //////////////////////////////////
public function single_entry($id)
          {
              $this->db->select('*');
              $this->db->from('grado_grupo');
              $this->db->where('id_grado_grupo', $id);
              $query = $this->db->get();
              if (count($query->result()) > 0) {
                  return $query->row();
              }
          }
//////////////////////////////  ACTUALIZAR PERIODOS ///////////////////////////////////////
public function update($data){

    return $this->db->update('grado_grupo', $data, array('id_grado_grupo' => $data['id_grado_grupo']));
}

public function getArchivoId($id){
      $query = $this->db->query("select * FROM cod where id=?", array($id));
      return $query->row_array();
}


public function obtenergradogrupo(){
    $this->db->distinct();
    $this->db->select("id_grado_grupo,nombre");
    $this->db->from("grado_grupo");
    $resultados = $this->db->get();
    return $resultados->result();
    }



          



  } // FIN / CIERRE DEL MODELO
