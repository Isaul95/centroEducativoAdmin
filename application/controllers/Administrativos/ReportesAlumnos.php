<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesAlumnos extends CI_Controller {

	   public function __construct(){
	 	 parent::__construct();
		 $this->load->helper(array('form', 'url'));
	 	 $this->load->library(array('session', 'form_validation'));
	 	 $this->load->model("Modelo_Reportes");
	 }


	public function index(){
		$data = array(
			//'username' => $this->session->userdata('username'),
			'rol' => $this->session->userdata('rol'),
		);
		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
		$this->load->view('admin/Vistas_administrativos/VistaReportesAlumnos',$data);
		$this->load->view('layouts/footer');
	}


	public function contador(){
		$grado = $this->input->post('carrera');
			$posts = $this->Modelo_Reportes->consultarAuxiliar($grado);
			echo json_encode($posts);

	}


	public function reportAlumnos($id_grado_grupo){

		$datosEscuela = $this->Modelo_Reportes->lista_alumnos_reporte($id_grado_grupo);

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

				 $sheet->setCellValue('A5', 'NP');
			     $sheet->getColumnDimension('A')->setWidth(4); // add tamanio del recuadro
				 $sheet->setCellValue('B5', 'NOMBRE DEL ALUMNO');
				 $sheet->getColumnDimension('B')->setWidth(35);
				 $sheet->setCellValue('C5', 'GRADO GRUPO');
				 $sheet->getColumnDimension('C')->setWidth(15);
				 $sheet->setCellValue('D5', 'CURP');
				 $sheet->getColumnDimension('D')->setWidth(22);
				 $sheet->setCellValue('E5', 'TELEFONO');
				 $sheet->getColumnDimension('E')->setWidth(13);
				 $sheet->setCellValue('F5', 'OBSERVACIONES');
				 $sheet->getColumnDimension('F')->setWidth(15);
				 $sheet->getStyle('A5:F5')->getFont()->setBold(true);//letras negritas
				 // color de fondo del recuadro
				 $sheet->getStyle('A5:F5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6DBDF');

				 $count = 1; // numero progresivo numeracion de los registros
				 $fila = 6; // inicia a pintar los datos a partir de la fila #6

				foreach($datosEscuela as $d){
				 	$sheet->setCellValue('C2', 'ESC. PRIM. '.$d->nombre);
					$sheet->setCellValue('C3', 'C.C.T. '.$d->codigo);
					$sheet->setCellValue('C4', 'TURNO: '.$d->turno);

					$sheet->setCellValue('A' . $fila, $count);
					$sheet->setCellValue('B' . $fila, $d->nombre_completo);
					$sheet->setCellValue('C' . $fila, $d->nombre_grado);
					$sheet->setCellValue('D' . $fila, $d->curp_texto);
					$sheet->setCellValue('E' . $fila, utf8_decode($d->telefono));
					$count++;
					$fila++;

					$gradoConsulta = $d->nombre_grado;
				}

				$ultimaFila =  $fila - 1;

				$styleArray = [
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						]
					]
				];

				$sheet->getStyle('A5:F'.$ultimaFila)->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);

		 	$filename = 'ALUMNOS_'.$gradoConsulta;
		 	ob_end_clean();
		 	header('Content-Type: application/vnd.ms-excel');
		 	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		 	header('Cache-Control: max-age=0');

		 	$writer->save('php://output');

	}



	public function reportDirectorioAlumnos($id_grado_grupo){

		$datosEscuela = $this->Modelo_Reportes->lista_alumnos_reporte($id_grado_grupo);

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$sheet->mergeCells('A1:F2');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$sheet->getStyle('A1')->getFont()->setSize(20);
			$sheet->getStyle('A1')->getFont()->setBold(true);//letras negritas
			$sheet->setCellValue('A1', 'DIRECTORIO DEL GRUPO');
			// color de fondo del recuadro
			$sheet->getStyle('A1:F2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6DBDF');

				 $sheet->setCellValue('A3', 'NP');
			     $sheet->getColumnDimension('A')->setWidth(4); // add tamanio del recuadro
				 $sheet->setCellValue('B3', 'NOMBRE COMPLETO');
				 $sheet->getColumnDimension('B')->setWidth(35);
				 $sheet->setCellValue('C3', 'DIRECCIÓN');
				 $sheet->getColumnDimension('C')->setWidth(15);
				 $sheet->setCellValue('D3', 'TELEFONO');
				 $sheet->getColumnDimension('D')->setWidth(13);
				 $sheet->setCellValue('E3', 'CURP');
				 $sheet->getColumnDimension('E')->setWidth(22);
				 $sheet->setCellValue('F3', 'OBSERVACION');
				 $sheet->getColumnDimension('F')->setWidth(15);
				 $sheet->getStyle('A3:F3')->getFont()->setBold(true);//letras negritas

				 $count = 1; // numero progresivo numeracion de los registros
				 $fila = 4; // inicia a pintar los datos a partir de la fila #6

				foreach($datosEscuela as $d){
					$sheet->setCellValue('A' . $fila, $count);
					$sheet->setCellValue('B' . $fila, $d->nombre_completo);
					$sheet->setCellValue('C' . $fila, $d->direccion);
					$sheet->setCellValue('D' . $fila, utf8_decode($d->telefono));
					$sheet->setCellValue('E' . $fila, $d->curp_texto);
					$count++;
					$fila++;

					$gradoConsulta = $d->nombre_grado;
				}

				$ultimaFila =  $fila - 1;

				$styleArray = [
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						]
					]
				];

				$sheet->getStyle('A3:F'.$ultimaFila)->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);

		 	$filename = 'DIRECTORIO DE ALUMNOS_'.$gradoConsulta;
		 	ob_end_clean();
		 	header('Content-Type: application/vnd.ms-excel');
		 	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		 	header('Cache-Control: max-age=0');

		 	$writer->save('php://output');

	}


	
	public function reportListAlumnos($id_grado_grupo){

		$datosEscuela = $this->Modelo_Reportes->lista_alumnos_reporte($id_grado_grupo);

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

				 $sheet->setCellValue('A5', 'NP');
			     $sheet->getColumnDimension('A')->setWidth(4); // add tamanio del recuadro
				 $sheet->setCellValue('B5', 'NOMBRE DEL ALUMNO');
				 $sheet->getColumnDimension('B')->setWidth(40);
				 $sheet->setCellValue('C5', 'OBSERVACIONES');
				 $sheet->getColumnDimension('C')->setWidth(30);
				 $sheet->getStyle('A5:C5')->getFont()->setBold(true);//letras negritas
				 // color de fondo del recuadro
				 $sheet->getStyle('A5:C5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6DBDF');

				 $count = 1; // numero progresivo numeracion de los registros
				 $fila = 6; // inicia a pintar los datos a partir de la fila #6

				foreach($datosEscuela as $d){
				 	//$sheet->setCellValue('B2', 'ESC. PRIM. '.$d->nombre);
					//$sheet->setCellValue('B3', 'C.C.T. '.$d->codigo);
					//$sheet->setCellValue('B4', 'TURNO: '.$d->turno);

					$sheet->setCellValue('A' . $fila, $count);
					$sheet->setCellValue('B' . $fila, $d->nombre_completo);
					$count++;
					$fila++;

					$gradoConsulta = $d->nombre_grado;
				}

				$ultimaFila =  $fila - 1;

				$styleArray = [
					'borders' => [
						'allBorders' => [
							'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							'color' => ['rgb' => '000000'],
						]
					]
				];

				$sheet->getStyle('A5:C'.$ultimaFila)->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);

		 	$filename = 'LISTA DE ALUMNOS_'.$gradoConsulta;
		 	ob_end_clean();
		 	header('Content-Type: application/vnd.ms-excel');
		 	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		 	header('Cache-Control: max-age=0');

		 	$writer->save('php://output');

	}




/*
------------------- EXAMPLE  ------------------------------------
	public function reportExcell($numero_control){

		$spreadsheet = new Spreadsheet();
			 	$sheet = $spreadsheet->getActiveSheet();
			 	$sheet->setCellValue('A5', 'NP');
				$sheet->setCellValue('B5', 'NOMBRE DEL ALUMNO');
			 	$sheet->setCellValue('C5', 'GRADO GRUPO');
			 	$sheet->setCellValue('D5', 'CURP');
			 	$sheet->setCellValue('E5', 'TELEFONO');
				$sheet->setCellValue('F5', 'OBSERVACIONES');

			$data = $this->Modelo_Reportes->list_alumnos();
				$count = 1;

			  foreach($data as $d){
				$sheet->setCellValue('A5', $count);
		 		$sheet->setCellValue('B5', "RAFAEL ISAUL HERNANDEZ RAMIREZ"); // $d->numero_control
		 		$sheet->setCellValue('C5', "4-A");
		 		$sheet->setCellValue('D5', "HERRMF0109342");
		 		$sheet->setCellValue('E5', "7331170055");
				$sheet->setCellValue('F5', "Observaciòn");
			}

	
		$writer = new Xlsx($spreadsheet);
			
		 	$filename = 'LISTA DE ALUMNOS';
		 	ob_end_clean();
		 	header('Content-Type: application/vnd.ms-excel');
		 	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		 	header('Cache-Control: max-age=0');
		
		 	$writer->save('php://output');

	}

	// 15. Punto de venta con CI4, Genera reportes Excel -> 1.16.57

	*/

}  // Fin del controller
