<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GradosGrupos extends CI_Controller {
		 private $permisos;
         public function __construct(){
	 	 parent::__construct();
		 $this->permisos = $this->backend_lib->control();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_GradosGrupos");
	 }

	public function index(){
		$data  = array(
			'permisos' => $this->permisos,
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_administrativos/VistaGradosGrupos',$data);
		$this->load->view('layouts/footer');
	}
	////////////  VISUALIZACIÓN DE LOS PERIODOS ESCOLARES /////////////////////////////
public function vergradosgrupos()
{
    $posts = $this->Modelo_GradosGrupos->obtenergrados();
    echo json_encode($posts);
}

////////////  INSERCIÓON DE LOS PERIODOS ESCOLARES /////////////////////////////
	public function insertarcarrera(){
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('carrera_descripcion', 'ciclo', 'required');
			$this->form_validation->set_rules('clave', 'clave', 'required');
			$this->form_validation->set_rules('fecha', 'fecha', 'required');
			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
        $ajax_data = $this->input->post();
        					if ($this->Modelo_GradosGrupos->insert_entry($ajax_data)) {
						$data = array('res' => "success", 'message' => "¡Periodo agregado!");
					} else {
						$data = array('res' => "error", 'message' => "");
					}
				
			}
			echo json_encode($data);
		} else {
			echo "No se permite este acceso directo...!!!";
		}

	}

////////////  ELIMINACIÓN DE LOS PERIODOS ESCOLARES /////////////////////////////
public function eliminarcarrera(){
	if ($this->input->is_ajax_request()) {
		$del_id = $this->input->post('del_id');
	if ($this->Modelo_GradosGrupos->delete_entry($del_id)) {
			$data = array('responce' => "success");
	} else {
			$data = array('responce' => "error", "No se pudo eliminar...!");
	}
		echo json_encode($data);
	} else {
		echo "No se permite este acceso directo...!!!";
	}
}

public function editarcarrera(){
	if ($this->input->is_ajax_request()) {
		$edit_id = $this->input->post('edit_id');
		if ($post = $this->Modelo_GradosGrupos->single_entry($edit_id)) {
			$data = array('responce' => "success", "post" => $post);
		}else{
			$data = array('responce' => "error", "failed to fetch");
		}
		echo json_encode($data);
	}else {
		echo "No se permite este acceso directo...!!!";
	}
}

public function updatecarrera(){
	if ($this->input->is_ajax_request()) {
		$this->form_validation->set_rules('licenciatura_update', 'licenciatura', 'required');
		$this->form_validation->set_rules('clave_licenciatura_update', 'clave', 'required');
		$this->form_validation->set_rules('datepicker_fecha_licenciatura_update', 'fecha', 'required');
		if ($this->form_validation->run() == FALSE) {
			$data = array('res' => "error", 'message' => validation_errors());
		} else {
			$data['id_carrera'] = $this ->input->post('id_carrera');
			$data['carrera_descripcion'] = $this ->input->post('licenciatura_update');
			$data['clave'] = $this ->input->post('clave_licenciatura_update');
			$data['fecha'] = $this ->input->post('datepicker_fecha_licenciatura_update');
	
						if ($this->Modelo_GradosGrupos->update($data)) {
					$data = array('responce' => "success", 'message' => "¡Periodo actualizado!");
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