<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require "vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportesMaestros extends CI_Controller {

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
		$this->load->view('admin/Vistas_administrativos/VistaReportesMaestros',$data);
		$this->load->view('layouts/footer');
	}


	public function contadorMaestros(){
		//$grado = $this->input->post('grado');
			$posts = $this->Modelo_Reportes->consultarAuxiliarMaestros();
			echo json_encode($posts);

	}


	public function reportMaestros($id_grado_grupo){

		$datosMaestros = $this->Modelo_Reportes->lista_maestros_reporte(); // $id_grado_grupo

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

				 $sheet->setCellValue('A3', 'NP');
			     $sheet->getColumnDimension('A')->setWidth(4); // add tamanio del recuadro
				 $sheet->setCellValue('B3', 'NOMBRE COMPLETO');
				 $sheet->getColumnDimension('B')->setWidth(40);
				 $sheet->setCellValue('C3', 'SEP');
				 $sheet->getColumnDimension('C')->setWidth(20);
				 $sheet->setCellValue('D3', 'CT');
				 $sheet->getColumnDimension('D')->setWidth(20);
				 $sheet->getStyle('A5:D3')->getFont()->setBold(true);//letras negritas
				 // color de fondo del recuadro
				 $sheet->getStyle('A5:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6DBDF');

				 $count = 1; // numero progresivo numeracion de los registros
				 $fila = 4; // inicia a pintar los datos a partir de la fila #6

				foreach($datosMaestros as $d){
					$sheet->mergeCells('C2:D2');
				 	$sheet->setCellValue('C2', 'FECHA DE INGRESO');

					$sheet->setCellValue('A' . $fila, $count);
					$sheet->setCellValue('B' . $fila, $d->nombre_completo);
					$sheet->setCellValue('C' . $fila, $d->fecha_sep);
					$sheet->setCellValue('D' . $fila, $d->fecha_ct);
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

				$sheet->getStyle('A3:D'.$ultimaFila)->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);

		 	$filename = 'LISTA DE MAESTROS';
		 	ob_end_clean();
		 	header('Content-Type: application/vnd.ms-excel');
		 	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		 	header('Cache-Control: max-age=0');

		 	$writer->save('php://output');

	}



	public function reportDirectorioMaestros($id_grado_grupo){

		$datosMaestros = $this->Modelo_Reportes->lista_maestros_reporte(); // $id_grado_grupo

			$spreadsheet = new Spreadsheet();
			$sheet = $spreadsheet->getActiveSheet();

			$sheet->mergeCells('A1:G2');
			$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
			$sheet->getStyle('A1')->getFont()->setSize(20);
			$sheet->getStyle('A1')->getFont()->setBold(true);//letras negritas
			$sheet->setCellValue('A1', 'DIRECTORIO DE PERSONAL DOCENTE');
			// color de fondo del recuadro
			$sheet->getStyle('A1:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('D6DBDF');

				 $sheet->setCellValue('A3', 'NP');
			     $sheet->getColumnDimension('A')->setWidth(4); // add tamanio del recuadro
				 $sheet->setCellValue('B3', 'NOMBRE DEL MAESTRO');
				 $sheet->getColumnDimension('B')->setWidth(35);
				 $sheet->setCellValue('C3', 'FUNCIÓN');
				 $sheet->getColumnDimension('C')->setWidth(15);
				 $sheet->setCellValue('D3', 'DIRECCIÓN');
				 $sheet->getColumnDimension('D')->setWidth(15);
				 $sheet->setCellValue('E3', 'CORREO');
				 $sheet->getColumnDimension('E')->setWidth(15);
				 $sheet->setCellValue('F3', 'TELEFONO');
				 $sheet->getColumnDimension('F')->setWidth(13);
				 $sheet->setCellValue('G3', 'RFC');
				 $sheet->getColumnDimension('G')->setWidth(15);

				 $sheet->getStyle('A3:G3')->getFont()->setBold(true);//letras negritas

				 $count = 1; // numero progresivo numeracion de los registros
				 $fila = 4; // inicia a pintar los datos a partir de la fila #6

				foreach($datosMaestros as $d){
					$sheet->setCellValue('A' . $fila, $count);
					$sheet->setCellValue('B' . $fila, $d->nombre_completo);
					$sheet->setCellValue('C' . $fila, $d->funcion);
					$sheet->setCellValue('D' . $fila, $d->direccion);
					$sheet->setCellValue('E' . $fila, $d->correo);
					$sheet->setCellValue('F' . $fila, $d->telefono_celular);
					$sheet->setCellValue('G' . $fila, $d->rfc);
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

				$sheet->getStyle('A3:G'.$ultimaFila)->applyFromArray($styleArray);

		$writer = new Xlsx($spreadsheet);

		 	$filename = 'DIRECTORIO PERSONAL DOCENTE';
		 	ob_end_clean();
		 	header('Content-Type: application/vnd.ms-excel');
		 	header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"');
		 	header('Cache-Control: max-age=0');

		 	$writer->save('php://output');

	}



}  // Fin del controller
