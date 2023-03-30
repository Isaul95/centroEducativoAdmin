<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_Reportes extends CI_Model { // INICIO DEL MODELO

  public function consultarAuxiliar($grado){
    $this->db->select(" COUNT(*) As conteo, gr.id_grado_grupo
    ,(select COUNT(*) from alumnos al where al.sexo = 'Masculino') As hombres
    ,(select COUNT(*) from alumnos al where al.sexo = 'Femenino') As mujeres");
            $this->db->from("alumnos al");
            $this->db->join("detalles","al.numero_control = detalles.alumno");
            $this->db->join("grado_grupo gr","detalles.carrera = gr.id_grado_grupo");
           $this->db->where_in('al.estatus', ['0','1']);
           $this->db->where("al.estatus_alumno_activo", 1);
            $this->db->where("detalles.carrera", $grado);
    $resultados = $this->db->get();
    return $resultados->result();
  }


/*

SELECT d.nombre, d.codigo, d.turno, concat(al.nombres,' ',al.apellido_paterno,' ',al.apellido_materno) as nombre_completo, detalles.id_detalle, gr.nombre as nombre_grado, al.curp_texto, al.telefono
  FROM datos_escuela d, alumnos al
  inner join detalles on al.numero_control = detalles.alumno
  inner join grado_grupo gr on detalles.carrera = gr.id_grado_grupo
  where al.estatus_alumno_activo = 1 and al.estatus in (0,1) and detalles.carrera = 7;

  */


  public function datos_escuela(){
    $this->db->select("d.nombre, d.codigo, d.turno");
    $this->db->from("datos_escuela d");
    $resultados = $this->db->get();
    return $resultados->result();
  }


  public function lista_alumnos_reporte($grado){
    $this->db->select(" d.nombre, d.codigo, d.turno, concat(al.nombres,' ',al.apellido_paterno,' ',al.apellido_materno) as nombre_completo, detalles.id_detalle, gr.nombre as nombre_grado, al.curp_texto, al.telefono, al.direccion");
            $this->db->from("datos_escuela d, alumnos al ");
            $this->db->join("detalles","al.numero_control = detalles.alumno");
            $this->db->join("grado_grupo gr","detalles.carrera = gr.id_grado_grupo");
           $this->db->where_in('al.estatus', ['0','1']);
           $this->db->where("al.estatus_alumno_activo", 1);
            $this->db->where("detalles.carrera", $grado);
    $resultados = $this->db->get();
    return $resultados->result();
  }





  // Maestros

  public function lista_maestros_reporte($grado){
    $this->db->select("pr.nombres As nombre_completo, pr.fecha_sep, pr.fecha_ct, pr.funcion, pr.direccion, pr.correo, pr.telefono_celular, pr.rfc");
            $this->db->from("profesores pr");
            $this->db->where("pr.grado_grupo", $grado);
    $resultados = $this->db->get();
    return $resultados->result();
  }

  public function consultarAuxiliarMaestros($grado){
    $this->db->select(" COUNT(*) As conmaestro, gr.id_grado_grupo");
            $this->db->from("profesores pr");
            $this->db->join("grado_grupo gr","pr.grado_grupo = gr.id_grado_grupo");
            $this->db->where("pr.grado_grupo", $grado);
    $resultados = $this->db->get();
    return $resultados->result();
  }


  } // FIN / CIERRE DEL MODELO
