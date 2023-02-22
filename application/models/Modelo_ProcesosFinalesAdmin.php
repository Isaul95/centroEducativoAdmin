<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_ProcesosFinalesAdmin extends CI_Model {


// DCOUMENTACION TESIST OFICIO todo REFERENTE A Titulacion

    public function obtOficiosXAlumnoToAdmin($tipo_documento){  // $alumno, $tipo_documento
            $this->db->select("ofic.id_oficio, ofic.alumno, ofic.nombre_archivo, ofic.tipo_documento, sta.estado, ofic.fecha_registro, ofic.comentarios");
        $this->db->from("oficios_procesofin ofic");
        $this->db->join("estatus sta","sta.estatus = ofic.estado_archivo ");
          // $this->db->where(" alumno =",$alumno);
         $this->db->where("ofic.tipo_documento =",$tipo_documento);
        $resultados = $this->db->get();
        return $resultados->result();
        }



// servicio  SOXIAL
        public function obtOficiosXAlumnoToAdminServicio($tipo_documento){  // $alumno, $tipo_documento
                $this->db->select("ofic.id_oficio, ofic.alumno, ofic.nombre_archivo, ofic.tipo_documento, sta.estado, ofic.fecha_registro, ofic.comentarios");
            $this->db->from("oficios_procesofin ofic");
            $this->db->join("estatus sta","sta.estatus = ofic.estado_archivo ");
              // $this->db->where(" alumno =",$alumno);
             $this->db->where("ofic.tipo_documento =",$tipo_documento);
            $resultados = $this->db->get();
            return $resultados->result();
            }


    public function getArchivosOficiosToAdmin($id_oficio , $alumno , $tipo_documento){
              $query = $this->db->query("select * FROM oficios_procesofin where id_oficio=? and alumno=? and tipo_documento=? ", array($id_oficio , $alumno , $tipo_documento));
              return $query->row_array();
          }



  }  // FIN DE LA CLASE MODELO
