<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DatosEscuela extends CI_Controller {

	   public function __construct(){
	 	 parent::__construct();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_DatosEscuela");
	 }

	public function index(){
		//$data = array();
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		 $this->load->view('admin/Vistas_administrativos/VistaAlumnosPorSemestre'); //,$data
		$this->load->view('layouts/footer');
	}


	public function verDatosEscuela(){
    $posts = $this->Modelo_DatosEscuela->verDatosEscuela();
    echo json_encode($posts);
	}

	public function editarDatos(){
		if ($this->input->is_ajax_request()) {
			$codigo = $this->input->post('codigo');
			if ($post = $this->Modelo_DatosEscuela->update_datos($codigo)) {
				$data = array('responce' => "success", "post" => $post);
			}else{
				$data = array('responce' => "error", "failed to fetch");
			}
			echo json_encode($data);
		}else {
			echo "No se permite este acceso directo...!!!";
		}
	}

	public function updateDatosEscuela(){
		if ($this->input->is_ajax_request()) {

			$this->form_validation->set_rules('nombre', 'nombre', 'required');
				$this->form_validation->set_rules('codigo', 'codigo', 'required');
				$this->form_validation->set_rules('turno', 'turno', 'required');
				$this->form_validation->set_rules('zona_escolar', 'zona_escolar', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
				$data['nombre'] = $this ->input->post('nombre');
				$data['codigo'] = $this ->input->post('codigo');
				$data['turno'] = $this ->input->post('turno');
				$data['zona_escolar'] = $this ->input->post('zona_escolar');

							if ($this->Modelo_DatosEscuela->updateRegistros($data)) {
						$data = array('responce' => "success", 'message' => "¡Datos actualizados!");
					} else {
						$data = array('responce' => "error", 'message' => "");
					}
			}
			echo json_encode($data);
		}else {
			echo "No se permite este acceso directo...!!!";
		}
	}




}  // Fin del controller
