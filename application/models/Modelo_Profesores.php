<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modelo_Profesores extends CI_Model { // INICIO DEL MODELO


      	/* -------------------------------------------------------------------------- */
      	/*                                Fetch Records                               */
      	/* -------------------------------------------------------------------------- */


      public function get_entries()
        {
            $query = $this->db->get('cod');
            return $query->result();
        }

    public function obtenerprofesores($idGrado){
      $this->db->select("p.id_profesores, p.nombres, p.edad, p.sexo , p.direccion, p.ciudad_radicando,p.nacionalidad,
      p.telefono_celular, p.correo, p.estado_civil, p.nivel_de_estudios, p.titulado, p.cedula, p.ocupacion,
      p.tipo_de_trabajo,p.universidad_procedente, p.experiencia_docente, p.trabajos_anteriores, p.nombre_archivo,
      p.horario_asignado");
      $this->db->from("profesores p");
      //$this->db->join("calificaciones c","c.profesor = p.id_profesores");
      $this->db->where('p.grado_grupo', $idGrado);
      //$this->db->group_by('p.id_profesores');
      $resultados = $this->db->get();
      return $resultados->result();
    }

/***
 *
 *
 *  CONSULTA DE ARRIBA
 *  public function obtenerprofesores(){
      $this->db->select("p.id_profesores, p.nombres, p.edad, p.sexo , p.direccion, p.ciudad_radicando,p.nacionalidad,
      p.telefono_celular, p.correo, p.estado_civil, p.nivel_de_estudios, p.titulado, p.cedula, p.ocupacion,
      p.tipo_de_trabajo,p.universidad_procedente, p.experiencia_docente, p.trabajos_anteriores, p.nombre_archivo,
      c.estado_profesor, c.id_calificacion");
      $this->db->from("profesores p");
      $this->db->join("materias m","m.profesor = p.id_profesores", "LEFT");
      $this->db->join("calificaciones c","c.materia = m.id_materia","LEFT");
      $this->db->group_by('p.id_profesores');
      $resultados = $this->db->get();
      return $resultados->result();
    }
 *
 *
 *
 *
 *
 *
 *
 */
//  CONSULYTA DE LA PERRITA
        // public function obtenerprofesores(){
        //         $this->db->select("id_profesores, nombres, edad, sexo , direccion,ciudad_radicando,nacionalidad,telefono_celular,
        //         correo,estado_civil,nivel_de_estudios,titulado,cedula,ocupacion,tipo_de_trabajo,universidad_procedente,experiencia_docente,trabajos_anteriores, nombre_archivo");
        //     $this->db->from("profesores");
        //     $resultados = $this->db->get();
        //     return $resultados->result();
        // }


// ***************************  INICIO FUNCTION PARA INSRTAR  ************************************
public function insert_entry($data)
    {
        return $this->db->insert('profesores', $data);
    }

    // public function insertarDoc($data){  // SI INSERTa bien
    //   return $this->db->insert("cod", $data);
    //     // return $this->db->insert_id();
    //   }



    // public function getArchivoId($id){  //DE ESTA FORMA SOLO SE REGRESA EL PURO ARCHIVOI COMO BIANRIO
    //   $query = $this->db->query("select archivo FROM cod where id=?", array($id));
    //   $q =  $query->row_array();
    //    return $q['archivo'];
    //
    //   }


    public function getArchivoId($id){
      $query = $this->db->query("select * FROM profesores where id_profesores=?", array($id));
      return $query->row_array();
      }



    //   public function update($data){
    //     return $this->db->update('profesores', $data, array('id_profesores' => $data['id_profesores']));
    // }
    public function update_entry($id_profesores, $data)
    {
        return $this->db->update('profesores', $data, array('id_profesores' => $id_profesores));
    }

    public function update_habilitar_profesor($id_profesores, $data)
    {
        return $this->db->update('calificaciones', $data, array('profesor' => $id_profesores));
    }



      public function delete_entry($id)
          {
              return $this->db->delete('profesores', array('id_profesores' => $id));
          }

          public function getProfesorInfo($id_profesores)
          {
          $this->db->select("p.id_profesores as id_profesores, p.nombres as nombres, p.edad as edad, p.sexo as sexo, p.direccion as direccion, p.ciudad_radicando as ciudad_radicando,p.nacionalidad as nacionalidad,
          p.telefono_celular as telefono_celular, p.correo as correo, g.nombre as nombre, p.fecha_sep as fecha_sep, p.fecha_ct as fecha_ct, p.estado_civil as estado_civil, p.nivel_de_estudios as nivel_de_estudios, p.titulado as titulado, p.cedula as cedula, p.ocupacion as ocupacion,
          p.tipo_de_trabajo as tipo_de_trabajo,p.universidad_procedente as universidad_procedente, p.experiencia_docente as experiencia_docente, p.trabajos_anteriores as trabajos_anteriores, p.rfc as rfc, p.funcion as funcion");
          $this->db->from("profesores p");
          $this->db->join("grado_grupo g","g.id_grado_grupo = p.grado_grupo");
          $this->db->where('p.id_profesores', $id_profesores);
          $query = $this->db->get();
          if (count($query->result()) > 0) {
              return $query->row();
          }
        }
          public function single_entry($id_profesores)
          {
            $this->db->select('id_profesores, nombres, edad, sexo, direccion,ciudad_radicando,nacionalidad,telefono_celular,
            correo,grado_grupo,estado_civil,nivel_de_estudios,titulado,cedula,ocupacion,tipo_de_trabajo,universidad_procedente,
            experiencia_docente,trabajos_anteriores,rfc,funcion');
          $this->db->from('profesores');
              $this->db->where('id_profesores', $id_profesores);
              $query = $this->db->get();
              if (count($query->result()) > 0) {
                  return $query->row();
              }
          }




//  ===========  ACTUALIZA SIEMPRE EL ESTATUS DE LA TABLA DE calificaciones PARA HABILITAR Y DESHABILITAR  =============
            // public function updateHabProfesor($id_calificacion, $data){
            //   $this->db->where("id_calificacion",$id_calificacion);
            //    return $this->db->update("calificaciones", $data);
            //   }
// Actualiza en base a las materias asignadas al profesor. calificaciones => estado_profesor
    public function updateHabProfesor($id_profesores, $data){
      return $this->db->update("calificaciones cal", $data);
      $this->db->join("materias m","m.id_materia = cal.materia");
      $this->db->where(" m.profesor ",$id_profesores);
    }
// CONSULTA ORIGINAL
/*
      update calificaciones cal
      inner join materias m on m.id_materia = cal.materia
      set cal.estado_profesor=1
      where m.profesor=1

*/



public function obtDocumentosDeTitulacionXAlumnoToProfesores(){  // $alumno, $tipo_documento
        $this->db->select("ofic.id_oficio, ofic.alumno, ofic.nombre_archivo, ofic.tipo_documento, sta.estado, ofic.fecha_registro, ofic.comentarios");
    $this->db->from("oficios_procesofin ofic");
    $this->db->join("estatus sta","sta.estatus = ofic.estado_archivo ");
      // $this->db->where(" alumno =",$alumno);
     // $this->db->where(" tipo_documento =",$tipo_documento);
    $resultados = $this->db->get();
    return $resultados->result();
    }



    /* -------------------------------------------------------------------------- */
    /*                       INSERTAR OFICIO DE PRACTOCAS                         */
    /* -------------------------------------------------------------------------- */
      public function insert_OficioPracticasOfProfesores($data){
              return $this->db->insert('oficios_procesofin', $data);
          }

    public function getArchivosTitulacionOfProfesor($id_oficio , $alumno , $tipo_documento){
              $query = $this->db->query("select * FROM oficios_procesofin where id_oficio=? and alumno=? and tipo_documento=? ", array($id_oficio , $alumno , $tipo_documento));
              return $query->row_array();
          }

    public function eliminarRegistroDeTitulacionXAlumnoToProfesores($id_oficio, $alumno, $tipo_documento){
        return $this->db->delete('oficios_procesofin', array('id_oficio' => $id_oficio, 'alumno' => $alumno, 'tipo_documento' => $tipo_documento));
        }



  } // FIN / CIERRE DEL MODELO
