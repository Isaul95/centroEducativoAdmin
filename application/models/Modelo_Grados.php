<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_Grados extends CI_Model { // INICIO DEL MODELO

  public function consultarGrados(){
    $this->db->select("id_grado_grupo,nombre,descripcion");
    $this->db->from("grado_grupo");
    $resultados = $this->db->get();
    return $resultados->result();
  }


  } // FIN / CIERRE DEL MODELO
