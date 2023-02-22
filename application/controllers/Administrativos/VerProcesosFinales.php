<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class VerProcesosFinales extends CI_Controller {
		 private $permisos;
         public function __construct(){
	 	 parent::__construct();
		 $this->permisos = $this->backend_lib->control();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_ProcesosFinalesAdmin");
	 }

	public function index(){
		// $numero_control =  $this->session->userdata('username');

		$data  = array(
			'permisos' => $this->permisos,
			// 'datosAlumnoProcesoFinal' => $this->Modelo_ProcesoFinal->obtenerDatosDelAlumnoProcFin($numero_control),
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_administrativos/VerOficios',$data);
		$this->load->view('layouts/footer');
	}


//  TITULACIONes
	public function obtenerOficiosOfAlumnosToAdmin() {
				// $alumno = $this->input->post('alumno');
				$tipo_documento = $this->input->post('tipo_documento');
				//  $alumno, $tipo_documento
		    $posts = $this->Modelo_ProcesosFinalesAdmin->obtOficiosXAlumnoToAdmin($tipo_documento);
		    echo json_encode($posts);
		}

//  SERVICIO SOCIAL
	public function obtenerOficiosOfAlumnosToAdminServicio() {
				// $alumno = $this->input->post('alumno');
				$tipo_documento = $this->input->post('tipo_documento');
				//  $alumno, $tipo_documento
		    $posts = $this->Modelo_ProcesosFinalesAdmin->obtOficiosXAlumnoToAdminServicio($tipo_documento);
		    echo json_encode($posts);
		}

//  PRACTICAS PROFESIONALES
	public function obtenerOficiosOfAlumnosToAdminPracticas() {
				// $alumno = $this->input->post('alumno');
				$tipo_documento = $this->input->post('tipo_documento');
				//  $alumno, $tipo_documento
		    $posts = $this->Modelo_ProcesosFinalesAdmin->obtOficiosXAlumnoToAdmin($tipo_documento);
		    echo json_encode($posts);
		}






		public function verOficiosDeAlumnosToAdmin($id_oficio , $alumno , $tipo_documento ){
			$consulta = $this->Modelo_ProcesosFinalesAdmin->getArchivosOficiosToAdmin($id_oficio , $alumno , $tipo_documento);
			$archivo = $consulta['archivo'];
			$img = $consulta['nombre_archivo'];
			header("Content-type: application/pdf");
			header("Content-Disposition: inline; filename=$img.pdf");
			print_r($archivo);
		}




}  // Fin del controller
