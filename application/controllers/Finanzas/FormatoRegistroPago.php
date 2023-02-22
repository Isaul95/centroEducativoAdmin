<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FormatoRegistroPago extends CI_Controller {

		 private $permisos;
	   public function __construct(){
	 	 parent::__construct();
		 $this->permisos = $this->backend_lib->control();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
		  // $this->permisos = $this->backend_lib->control();
	 	 $this->load->model("Modelo_RegistrosPag");
	 }


	public function index(){

		$data  = array(
			'permisos' => $this->permisos,
		);

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_Finanzas/VistaRegistroDePago',$data);
		$this->load->view('layouts/footer');
	}


	/* -------------------------------------------------------------------------- */
	/*                               Insert Records                               */
	/* -------------------------------------------------------------------------- */

	public function insertarPagos(){

		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('nombre', 'Nombre Alumno', 'required');
			$this->form_validation->set_rules('numero_con', 'Número de control', 'required');
			$this->form_validation->set_rules('carrera', 'Carrera', 'required');
			$this->form_validation->set_rules('semestre', 'Semestre', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
				$config['upload_path'] = "./assets/template/dist/img/uploads";
				$config['allowed_types'] = 'gif|jpg|png|pdf';
				$config['max_size']     = '1000';
				// $config['max_width'] = '1024';
				// $config['max_height'] = '768';
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
		$ajax_data['img'] = $this->upload->data('file_name'); // name file

					if ($this->Modelo_RegistrosPag->insert_entry($ajax_data)) {
						$data = array('res' => "success", 'message' => "Datos agregados correctamente...!");
					} else {
						$data = array('res' => "error", 'message' => "Error al agregar datos...!");
					}
				}
			}
			echo json_encode($data);
		} else {
			echo "No se permite este acceso directo...!!!";
		}

	}








//  ?==========================  EDITARRRRRRRR INICIO  ======================================================

/* -------------------------------------------------------------------------- */
	/*                                Edit Records                                */
	/* -------------------------------------------------------------------------- */

	public function edit()
	{
		if ($this->input->is_ajax_request()) {

			$edit_id = $this->input->get('edit_id');

			if ($post = $this->Modelo_RegistrosPag->single_entry($edit_id)) {
				$data = array('res' => "success", 'post' => $post);
			} else {
				$data = array('res' => "error", 'message' => "Failed to fetch data");
			}

			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}




	/* -------------------------------------------------------------------------- */
	/*                               Update Records                               */
	/* -------------------------------------------------------------------------- */

	public function update()
	{
		if ($this->input->is_ajax_request()) {
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('mob', 'Mobile No.', 'required');

			if ($this->form_validation->run() == FALSE) {
				$data = array('res' => "error", 'message' => validation_errors());
			} else {
				if (isset($_FILES["edit_img"]["name"])) {
					$config['upload_path'] = APPPATH . '../assets/uploads/';
					$config['allowed_types'] = 'gif|jpg|png';
					$config['max_size']     = '1000';
					// $config['max_width'] = '1024';
					// $config['max_height'] = '768';
					$this->load->library('upload', $config);

					if (!$this->upload->do_upload("edit_img")) {
						$data = array('res' => "error", 'message' => $this->upload->display_errors());
					} else {
						$edit_id = $this->input->post('edit_id');
						if ($post = $this->crud_model->single_entry($edit_id)) {
							unlink(APPPATH . '../assets/uploads/' . $post->img);
							$ajax_data['img'] = $this->upload->data('file_name');
						}
					}
				}
				$id = $this->input->post('edit_id');
				$ajax_data['name'] = $this->input->post('name');
				$ajax_data['email'] = $this->input->post('email');
				$ajax_data['mob'] = $this->input->post('mob');
				if ($this->crud_model->update_entry($id, $ajax_data)) {
					$data = array('res' => "success", 'message' => "Data update successfully");
				} else {
					$data = array('res' => "error", 'message' => "Failed to update data");
				}
			}
			echo json_encode($data);
		} else {
			echo "No direct script access allowed";
		}
	}

//  ==========================================================================================









	/* -------------------------------------------------------------------------- */
	/*                                Fetch Records                               */
	/* -------------------------------------------------------------------------- */

	public function listarPagos()
	{
		$posts = $this->Modelo_RegistrosPag->obtenerListaPagos();
		echo json_encode($posts);
	}




	public function verArchivo($id){
		$consulta = $this->Modelo_RegistrosPag->getArchivoId($id);
		$archivo = $consulta['archivo'];
		$img = $consulta['img'];
		header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=$img.pdf");
		print_r($archivo);

	}


	/* -------------------------------------------------------------------------- */
/*                               Delete Records                               */
/* -------------------------------------------------------------------------- */

public function eliminarPagos()
{
	if ($this->input->is_ajax_request()) {

		$del_id = $this->input->post('del_id');

		$post = $this->Modelo_RegistrosPag->single_entry($del_id);

		unlink(APPPATH . '../assets/template/dist/img/uploads/' . $post->img);

		if ($this->Modelo_RegistrosPag->delete_entry($del_id)) {
			$data = array('res' => "success", 'message' => "Datos eliminados con éxito...!");
		} else {
			$data = array('res' => "error", 'message' => "No se pudo eliminar...!");
		}
		echo json_encode($data);
	} else {
		echo "No se permite este acceso directo...!!!";
	}
}



}  // Fin del controller
