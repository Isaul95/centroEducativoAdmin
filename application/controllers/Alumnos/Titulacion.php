<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Titulacion extends CI_Controller {
		 private $permisos;
         public function __construct(){
	 	 parent::__construct();
		 $this->permisos = $this->backend_lib->control();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_ProcesoFinal");
	 }

	public function index(){
		$numero_control =  $this->session->userdata('username');

		$data  = array(
			'permisos' => $this->permisos,
			'datosAlumnoProcesoFinal' => $this->Modelo_ProcesoFinal->obtenerDatosDelAlumnoProcFin($numero_control),
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_Alumno/VistaTitulacion',$data);
		$this->load->view('layouts/footer');
	}




	/* -------------------------------------------------------------------------- */
	/*                   Insert  OFICIO PARA Titulacion                           */
	/* -------------------------------------------------------------------------- */

	public function insertarOficioDeTitulacion(){

		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('alumno', 'Número de control', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
				$config['upload_path'] = "./assets/template/dist/img/uploads";
				$config['allowed_types'] = 'gif|jpg|docx|pdf';
				$config['max_size']     = '1000';

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload("archivo")) {
					$data = array('res' => "error", 'message' => $this->upload->display_errors());
				} else {
				  $file_name = $_FILES['archivo']['name'];
					$file_size = $_FILES['archivo']['size'];
					$file_tmp = $_FILES['archivo']['tmp_name'];
					$file_type = $_FILES['archivo']['type'];

					$imagen_temporal = $file_tmp;
					$tipo = $file_type;

					$fp = fopen($imagen_temporal, 'r+b');
					$binario = fread($fp, filesize($imagen_temporal));
					fclose($fp);

					$ajax_data = $this->input->post();
					$ajax_data['archivo'] = $binario; // Documento pdf
					$ajax_data['nombre_archivo'] = $this->upload->data('file_name'); // name file

					if ($this->Modelo_ProcesoFinal->insert_OficioPracticasProf($ajax_data)) {
						$data = array('res' => "success", 'message' => "Archivo guardado correctamente...!");
					} else {
						$data = array('res' => "error", 'message' => "Error al guardado el archivo...!");
					}
				}
			}
			echo json_encode($data);
		} else {
			echo "No se permite este acceso directo...!!!";
		}
	}




	public function mostrarOpcionSubirOficioTitulacion(){
		if ($this->input->is_ajax_request()) {
		 $numero_control = $this->input->post('numero_control');
				if ($this->Modelo_ProcesoFinal->opcionSubirOfiTitulacion($numero_control)) {
					$data = array('responce' => 'success', 'message' => "Ya puede realizar los tramites de Titulación...!!!");
				} else {
						$data = array('responce' => 'error');
				}
		echo json_encode($data);
	} else {
		echo "No se permite este acceso directo...!!!";
		}
	}




	public function obtenerComprobantesTitulacionxxx() {
				$alumno = $this->input->post('alumno');
				// $tipo_documento = $this->input->post('tipo_documento');
//  $alumno, $tipo_documento
		    $posts = $this->Modelo_ProcesoFinal->obtenerDocumentosDeTitulacionDelAlumnoXXX();
		    echo json_encode($posts);
		}


/*

public function verArchivoTitulacion($id_oficio , $alumno , $tipo_documento ){
	$consulta = $this->Modelo_ProcesoFinal->getArchivosTitulacion($id_oficio , $alumno , $tipo_documento);
	$archivo = $consulta['archivo'];
	$img = $consulta['nombre_archivo'];
	header("Content-type: application/docx");
	header("Content-Disposition: inline; filename=$img.docx");
	print_r($archivo);
}


*/

		public function verArchivoTitulacion($id_oficio , $alumno , $tipo_documento ){
			$consulta = $this->Modelo_ProcesoFinal->getArchivosTitulacion($id_oficio , $alumno , $tipo_documento);
			$archivo = $consulta['archivo'];
			$img = $consulta['nombre_archivo'];

			$extension = pathinfo($img, PATHINFO_EXTENSION);
			// echo $extension;

						if($extension == "pdf"){
									header("Content-type: application/pdf");
						} else {
									header("Content-type: application/docx");
						}
				header("Content-Disposition: inline; filename=$img");
				print_r($archivo);

		}


		public function eliminarRegistroTitulacion(){

		if ($this->input->is_ajax_request()) {
					$id_oficio = $this->input->post('id_oficio');
					$alumno = $this->input->post('alumno');
					$tipo_documento = $this->input->post('tipo_documento');

			if ($this->Modelo_ProcesoFinal->eliminarRegistroDeTitulacionXAlumno($id_oficio, $alumno, $tipo_documento)) {
				$data = array('responce' => 'success');
			} else {
				$data = array('responce' => 'error');
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}




}  // Fin del controller
