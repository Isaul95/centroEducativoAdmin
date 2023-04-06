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


	
    public function generaConstanciaFPDFIsa($id_detalle){

		require "./src/report-fpdf/fpdf.php";

		$pdf = new FPDF();
		$pdf->AddPage();

		$pdf->Image('src/gro.jpg', 3, 12, 48);
		$pdf->Image('src/amb.jpg', 160, 6, 38);

		$pdf->SetFont('Arial','B', 10);
		$pdf->SetY(12);
	  	$pdf->Cell(0,0, utf8_decode('GOBIERNO DEL ESTADO LIBRE Y SOBERANO DE'),0,0,'C');
		$pdf->Ln(4); // --> Salto de linea
		$pdf->Cell(0,0, utf8_decode('GUERRERO'),0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(0,0, utf8_decode('SECRETARIA DE EDUCACIÓN GUERRERO'),0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(0,0, utf8_decode('SUBSECRETARIA DE EDUCACIÓN BÁSICA'),0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(0,0, utf8_decode('DIRECCIÓN GENERAL DE EDUCACIÓN PRIMARIA'),0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(0,0, utf8_decode('DEPARTAMENTO DE PRIMARIA FORMAL'),0,0,'C');
		$pdf->Ln(6);


		$DatosEscuela = $this->Modelo_Reportes->datos_escuela();

	foreach($DatosEscuela as $d){
		$pdf->SetFont('Arial','B', 9);
		$pdf->Cell(0,0, utf8_decode('ESCUELA PRIMARIA "'.$d->nombre.'"'),0,0,'C');
		$pdf->Ln(3);
		$pdf->Cell(0,0, utf8_decode('TURNO '.$d->turno),0,0,'C');

		$pdf->Ln(3);
		$pdf->Cell(0,0, utf8_decode('CALLE. ÁLVAREZ  156.   COL. JUAN N. ÁLVAREZ    IGUALA, GRO.'),0,0,'C');
		$pdf->Ln(3);
		$pdf->Cell(0,0, utf8_decode('C.C.T. '.$d->codigo.'    ZONA ESCOLAR No.137    SECTOR No.14'),0,0,'C');
		$pdf->Ln(4);
		$pdf->SetX(120);
		$pdf->Cell(0,0, utf8_decode('EXPEDIENTE: 2022 - 2023'),0,0,'C');
		$pdf->Ln(12);
	}

		$pdf->SetFont('Arial','B', 12);
		$pdf->SetX(100);
		$pdf->Cell(0,0, utf8_decode('ASUNTO: CONSTANCIA DE ESTUDIOS.'),0,0,'C');
		$pdf->Ln(8);


		// consulta
		$DatosConstancia = $this->Modelo_Reportes->datos_alumno_constancia($id_detalle);

	foreach($DatosConstancia as $con){
		$pdf->SetFont('Arial','', 12);
		$pdf->SetX(80);
		$pdf->Cell(0,0, utf8_decode('Iguala de la Independencia Gro; '.$con->fecha_constancia),0,0,'C');
		$pdf->Ln(15);

		$pdf->SetFont('Arial','B', 12);
		//$pdf->SetX(3);
		$pdf->Cell(80,0, utf8_decode('A QUIEN CORRESPONDA:'),0,0,'C');
		$pdf->Ln(10);

		$pdf->SetFont('Arial','', 12);
		$pdf->Cell(190,0, utf8_decode('La que suscribe PROFRA. DELFINA RODRIGUEZ CALDERON directora de'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(180,0, utf8_decode('la Escuela Primaria "General Ambrosio Figueroa", con domicilio oficial en Álvarez'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(138,0, utf8_decode('No. 156 Col. Juan N. Álvarez de esta ciudad de Iguala Gro.'),0,0,'C');
		$pdf->Ln(15);

		$pdf->SetFont('Arial','', 22);
		$pdf->Cell(185,0, utf8_decode('HACE     CONSTAR'),0,0,'C');
		$pdf->Ln(18);

		$pdf->SetFont('Arial','', 12);
		$pdf->Cell(190,0, utf8_decode('Que el (a) alumno (a): '.$con->nombre_completo.' está inscrito'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(176,0, utf8_decode('(a) en el '.$con->grado.' grado, grupo "'.$con->grupo.'" obteniendo un promedio de: '.$con->promedio.' durante el primer'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(100,0, utf8_decode('trimestre del ciclo escolar 2022 - 2023.'),0,0,'C');
		$pdf->Ln(20);

		$pdf->SetFont('Arial','', 12);
		$pdf->Cell(194,0, utf8_decode('A petición de la interesada, se le extiende la presente constancia y para tramite'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(185,0, utf8_decode('de preinscripción a nivel secundaria, en la ciudad de Iguala de la Independencia, del'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(163,0, utf8_decode('Estado de Guerrero a los '.$con->fecha_letra),0,0,'C');
		$pdf->Ln(35);

		$alumno = $con->nombre_completo;
	}

		$pdf->SetFont('Arial','', 12);
		//$pdf->SetX(3);
		$pdf->Cell(185,0, utf8_decode('ATENTAMENTE'),0,0,'C');
		$pdf->Ln(4);
		$pdf->Cell(185,0, utf8_decode('DIRECTORA DE LA ESCUELA'),0,0,'C');
		$pdf->Ln(18);
		$pdf->Cell(185,0, utf8_decode('____________________________________'),0,0,'C');
		$pdf->Ln(5);
		$pdf->Cell(185,0, utf8_decode('PROFRA. DELFINA RODRIGUEZ CALDERON'),0,0,'C');
		$pdf->Ln(12);


		$pdf->Output("CONSTANCIA_".$alumno.".pdf", 'I');

	}


}  // Fin del controller
