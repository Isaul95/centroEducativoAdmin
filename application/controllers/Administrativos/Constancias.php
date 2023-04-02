<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Constancias extends CI_Controller {

	   public function __construct(){
	 	 parent::__construct();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_Reportes");
		 $this->load->model("Modelo_Alumnos");
	 }


	public function index(){
		$data = array(
			//'username' => $this->session->userdata('username'),
			//'rol' => $this->session->userdata('rol'),
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_administrativos/VistaHacerConstancias',$data);
		$this->load->view('layouts/footer');
	}

	public function obtenerAlumnos(){
		$carrera = $this->input->post('carrera');
		$posts = $this->Modelo_Alumnos->obteneralumnos($carrera);
		echo json_encode($posts);
	}


	// capturar promedio y fecha con letra para constancia alumno
	public function capturaPromedioConstanciaAlumno(){
		$id_detalle = $this->input->post('id_detalle');
	 	$ajax_data = $this->input->post();

		if ($this->Modelo_Reportes->capturaPromedioConstancias($ajax_data)) {
			$data = array('responce' => 'success', 'message' => 'Ya puede generar la constancia del alumno...!');
		} else {
			$data = array('responce' => 'error', 'message' => 'Fallo al generar la constancia del alumno...!');
		}
				echo json_encode($data);
		}



/* -------------------------------------------------------------------------- */
/*                     Generar constancia de alumnos                         */
/* --------------------------------------- ---------------------------------- */

public function generaConstancia($detalle){ // ,$detalle - numero_control

	error_reporting(0);

	include_once('src/phpjasperxml_0.9d/class/tcpdf/tcpdf.php');
	include_once("src/phpjasperxml_0.9d/class/PHPJasperXML.inc.php");

	// SE HACE LA CONECION PARA CADA HOJA DE ESTAS
	$server = "localhost";
	$user = "root";
	$pass = "";
	$db = "escuela";

	$PHPJasperXML = new PHPJasperXML();
	$PHPJasperXML->arrayParameter=array("id_detalle"=>$detalle);

	$PHPJasperXML->load_xml_file("src/ReportesPDF_Cesvi_jrxml/constancia_alumnos.jrxml");

	$PHPJasperXML->transferDBtoArray($server,$user,$pass,$db);
	$PHPJasperXML->outpage('I','Constancia'.$numero_control.'.pdf');

	}


}  // Fin del controller
