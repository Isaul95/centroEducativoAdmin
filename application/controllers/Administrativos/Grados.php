<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grados extends CI_Controller {

	   public function __construct(){
	 	 parent::__construct();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_Grados");
	 }


	public function index(){
		$data = array(
			// 'tipoDePagos' => $this->Modelo_DarAccesoAlumnos->getTipoDePagos(),
			'username' => $this->session->userdata('username'),
			'rol' => $this->session->userdata('rol'),
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_administrativos/VistaHacerHorarioProfesor',$data);
		$this->load->view('layouts/footer');
	}

	public function consultarGrados(){
		$posts = $this->Modelo_Grados->consultarGrados();
		echo json_encode($posts);

	}



}  // Fin del controller
