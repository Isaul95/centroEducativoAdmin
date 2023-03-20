<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_DatosEscuela extends CI_Model {

  public function verDatosEscuela(){
    $this->db->select("nombre,codigo, turno, zona_escolar");
    $this->db->from("datos_escuela");
  $resultados = $this->db->get();
  return $resultados->result();
}

  public function update_datos($codigo){
    $this->db->select('*');
    $this->db->from('datos_escuela');
    $this->db->where('codigo', $codigo);
    $query = $this->db->get();
    if (count($query->result()) > 0) {
        return $query->row();
    }
}


  public function updateRegistros($data){

    return $this->db->update('datos_escuela', $data);
    //return $this->db->update('datos_escuela', $data, array('codigo' => $data['codigo']));
  }


  } // FIN / CIERRE DEL MODELO
