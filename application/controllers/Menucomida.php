<?php

include '/../../autoload.php';
use  Mike42\Escpos\Printer;
use  Mike42\Escpos\EscposImage;
use  Mike42\Escpos\PrintConnectors\FilePrintConnector;
use  Mike42\Escpos\PrintConnectors\WindowsPrintConnector;




defined('BASEPATH') OR exit('No direct script access allowed');

class Menucomida extends CI_Controller {

	public function __construct(){ // crear constructor
	 	 parent::__construct();   // hereda
	 	 $this->load->model("consultamenu");
	
	 }
	public function index(){
	}

function ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes){
  $estadoenturno="enturno";

$data = array
    ('mesa' =>$mesa, 
      'numerodeclientes' => $numerodeclientes, 
      'totalesdeclientes' => $this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodecliente($mesa, $numerodeclientes),
      'cuentaparcial' => $this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodemesa($mesa, $estadoenturno), 
      'ventadiariabebidas' => $this->consultamenu->detalledeventadiariobebidapormesa($mesa), 
    'ventadiariaextras' => $this->consultamenu->detalledeventadiarioextraspormesa($mesa), 
    'ventadiariacomida' => $this->consultamenu->detalledeventadiariocomidapormesa($mesa), 
  'mostrarmenu' => $this->consultamenu->getmenu(),  
      'mostrarbebidas' => $this->consultamenu->bebidas(), 
      'extras'=> $this->consultamenu->extras(), 
      'preciotacos' => $this->consultamenu->preciotacos(), 
      'precioquekas' => $this->consultamenu->precioquekas(), 
      'precioalhorno' => $this->consultamenu->precioalhorno(), 
      'preciomulas' => $this->consultamenu->preciomulas(), 
      'precioburritos' => $this->consultamenu->precioburritos(), 
      'precioaguanatural' => $this->consultamenu->precioaguanatural(), 
      'preciocerveza' => $this->consultamenu->preciocerveza(), 
      'preciochesco' => $this->consultamenu->preciochesco(), 
      'precioaguadeldia' => $this->consultamenu->precioaguadeldia(), 
      'preciomediaaguadeldia' => $this->consultamenu->preciomediaaguadeldia(), 
      'precioguacamole' => $this->consultamenu->precioguacamole(), 
      'preciobirria' => $this->consultamenu->preciobirria(), 
      'preciomediabirria' => $this->consultamenu->preciomediabirria());

    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
     $this->load->view('admin/elegir_cliente', $data);
    $this->load->view('layouts/footer');
}


function iralavista_elegirmesa(){
  $estadoenturno ="enturno";
  $vermesaenturno = array('mesadisponible' => $this->consultamenu->versilamesaestadisponible($estadoenturno));

     /* $this->load->view('admin/login');*/
    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('admin/elegir_mesa', $vermesaenturno);
    $this->load->view('layouts/footer'); 
}

public function cobrarporcliente($mesa, $numerodeclientes){ //cobrar invidualmente por cliente
  //ESTOS DATOS NECESITAS PARA EL TICKET
  //SON DATOS INFORMATIVOS

 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());//1
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());//2

  $mesa=$mesa;//3
  $numerodeclientes=$numerodeclientes;
  $estadoenturno="enturno";
  $numerodecliente=$this->input->post("numerodecliente");//4
  $totaldelcliente=$this->input->post("totaldelcliente");//5
  $pago=$this->input->post("pago");//6
  $cambio=$pago-$totaldelcliente;//7
  /*
  1.-FECHA
  2.-HORA
  3.-NUMERO DE MESA
  4.-NUMERO DE CLIENTE
  5.-TOTAL DEL CLIENTE
  6.-PAGO
  7.-CAMBIO*/
    //ESTOS DATOS NECESITAS PARA EL TICKET
  //SON DATOS INFORMATIVOS

 

//ESTA LINEA SIGNIFICA QUE LLAMAS A UN METODO DE ÉSTE MISMO CONTROLADOR Y LE PUEDES PASAR PARAMETROS
    //NO SE SI LE PUEDAS PASAR EL ARREGLO QUE ESTA AQUI ARRIBA AL METODO DEL CONTROLADOR, SINO
    $this->ticketclienteindividual($mesa, $numerodecliente, $totaldelcliente, $pago, $cambio);//ESTE METODO AÚN NO ESTA CREADO, PERO VA EN ESTE CONTROLADOR




  if(!empty($pago) && $pago>=$totaldelcliente){ //SI EL PAGO DEL CLIENTE ES DIFERENTE DE VACIO

$totalpagoycambiocliente =array('total' => $totaldelcliente, 'pago' => $pago, 'cambio' => $cambio, 'Fecha_venta' =>$Fecha_venta, 
'Hora_de_venta' => date('g:i:s a', strtotime($Hora_de_venta)));

$this->consultamenu->cobraracliente($totalpagoycambiocliente, $mesa);
$this->consultamenu->actualizararealizadoalcliente($mesa, $numerodecliente);
//AGREGANDO EL ESTADO REALIZADO AL CLIENTE, CONCLUYENDO ASÍ LA VENTA
$seagotoelimportedelamesa=$this->consultamenu->/*OBTENEMOS EL TOTAL DE LA MESA Y SI ES 0...*/sumadeimportesenlatabladescripciondeventasegunelnumerodemesa($mesa, $estadoenturno);

if(!empty($seagotoelimportedelamesa->importe) ){ //SI AUN HAY IMPORTE EN LA MESA SE DEBERA INCRMENTAR OTRO ID, YA SEA PARA EL PROXIMO QUE DECIDA PAGAR A PARTE O TODA LA MESA 
$mesero=3;
$datosdelatablaventa = array( //EL NUEVO ID
       'id_usuario'=> $mesero
      );
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);//AQUI SE INCREMENTA
$this->consultamenu->actualizarnuevoidventaenlatabladescripciondeventa($mesa);//ACTUALIZA EL NUEVO ID A TODO EL RESTANTE DE LA MESA PARA QUE NO SE QUEDEN SIN ID

//VUELVE NUEVAMENTE A LA VISTA DE ELEGIR CLIENTE
$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);




}//SI AUN HAY IMPORTE EN LA MESA SE DEBERA INCRMENTAR OTRO ID, YA SEA PARA EL PROXIMO QUE DECIDA PAGAR A PARTE O TODA LA MESA 

else{ //CUANDO YA NO QUEDA NINGUN IMPORTE EN LA MESA
  $this->iralavista_elegirmesa();

}//CUANDO YA NO QUEDA NINGUN IMPORTE EN LA MESA

}//SI EL PAGO DEL CLIENTE ES DIFERENTE DE VACIO

else{//CUANDO EL PAGO ES IGUAL A 0  VUELVE TODO A LA VISTA DE ELEGIR CLIENTE
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);


}//CUANDO EL PAGO ES IGUAL A 0 VUELVE TODO A LA VISTA DE ELEGIR CLIENTE

}


public function cancelartodalamesa($mesa, $importe, $numerodeclientes){//CANCELAR TODA LA MESA
//ESTOS DATOS OCUPAS PARA LA CANCELACION

ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());//1
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());//2
$mesa = $mesa;//3
$importe = $importe;//4
$numerodeclientes =$numerodeclientes;//5

$estadoenturno="enturno";
$clavedecancelacion=$this->input->post("codigodecancelacion");
$codigoaprobado= $this->consultamenu->validarcodigodecancelacion($clavedecancelacion);

$ticket_cancelarmesa_datos = array
    ('Hora' =>$Hora_de_venta, 
      'Fecha' => $Fecha_venta, 
      'Mesa' => $mesa, 
      'Numeroclientes' => $numerodeclientes, 
      'Totalcliente' => $importe,  
      'comidas' => $this->consultamenu->detalledeventadiariocomidapormesa($mesa), 
      'bebidas' => $this->consultamenu->detalledeventadiariobebidapormesa($mesa), 
      'extras' => $this->consultamenu->detalledeventadiarioextraspormesa($mesa));

//ESTA LINEA SIGNIFICA QUE LLAMAS A UN METODO DE ÉSTE MISMO CONTROLADOR Y LE PUEDES PASAR PARAMETROS
    //NO SE SI LE PUEDAS PASAR EL ARREGLO QUE ESTA AQUI ARRIBA AL METODO DEL CONTROLADOR, SINO
    //$this->ticketpormesa(); //ESTE METODO AÚN NO ESTA CREADO

//SINO PUEDES ENVIAR EL ARREGLO A UNA VISTA, EN ÉSTE CASO TICKET
    //EN LA TERCER LINEA ES LA VISTA, BUENO EL ARCHIVO TICKET
     /*$this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('admin/ticket', $ticket_cobroindividual_datos); //EL ARCHIVO TICKET TU LO CREAS
    $this->load->view('layouts/footer'); 
*/  
//ESTOS DATOS OCUPAS PARA LA CANCELACION

if(empty($clavedecancelacion)){
$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);
}
else{

if($codigoaprobado['password']=="pineda12"){//CONFIRMANDO QUE LA CONTRASEÑA COINCIDA EN LA BASE
  $cancelarmesa =array('estado' => "cancelado", 
    'tipo_venta' => "Mesa cancelada", 
    'Fecha' => $Fecha_venta, 
    'Hora' => date('g:i:s a', strtotime($Hora_de_venta)));
  
  $totalporcancelarmesa =array('total' => $importe, 'pago' => "0", 'cambio' => "0", 'Fecha_venta' => $Fecha_venta, 
    'Hora_de_venta' => date('g:i:s a', strtotime($Hora_de_venta)));

$this->consultamenu->cancelarmesa($mesa, $cancelarmesa);
$idnull=$this->consultamenu->obteneridnull($mesa);
$this->consultamenu->definirtotalporcancelaciondemesa($totalporcancelarmesa, $idnull['id_venta']);
 $this->iralavista_elegirmesa();
 

}//CONFIRMANDO QUE LA CONTRASEÑA COINCIDA EN LA BASE CON LA DEL GERENTE
 
 else{
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

 }

}

}//CANCELAR TODA LA MESA


  public function cancelacionesindividuales($mesa, $numerodeclientes){
    //CANCELACIONES INDIVIDUALES

    //ESTOS DATOS NECESITAS PARA LA CANCELACION INDIVIDUAL
    ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());//1
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());//2

    $mesa=$mesa;//3
    $numerodeclientes=$numerodeclientes;


$estadoenturno="enturno";
$clavedecancelacion=$this->input->post("codigodecancelacion");

//4.- AQUI SON LOS DATOS QUE CONTIENEN LA COMIDA BEBIDA O EXTRA, PUEDEN IR TODOS LLENOS O SOLO ALUNGOS
$id_comida=$this->input->post("id_comida");
$nombre_comida=$this->input->post("nombre_comida");//4.1
$cantidad_comida=$this->input->post("cantidad_comida");//4.2
$precio_comida=$this->input->post("precio_comida");//4.3
$num_cliente_comida=$this->input->post("num_cliente_comida");//4.4

//IGUAL CON LOS DATOS DE ABAJO
$id_bebida=$this->input->post("id_bebida");
$nombre_bebida=$this->input->post("nombre_bebida");
$cantidad_bebida=$this->input->post("cantidad_bebida");
$precio_bebida=$this->input->post("precio_bebida");
$num_cliente_bebida=$this->input->post("num_cliente_bebida");

$id_extra=$this->input->post("id_extra");
$nombre_extra=$this->input->post("nombre_extra");
$cantidad_extra=$this->input->post("cantidad_extra");
$precio_extra=$this->input->post("precio_extra");
$num_cliente_extra=$this->input->post("num_cliente_extra");

//4.- AQUI SON LOS DATOS QUE CONTIENEN LA COMIDA BEBIDA O EXTRA, PUEDEN IR TODOS LLENOS O SOLO ALGUNOS
 $ticket_cobroindividual_datos = array
    ('Hora' =>$Hora_de_venta, 
      'Fecha' => $Fecha_venta, 
      'Mesa' => $mesa, 
      'nombre_comida' => $nombre_comida, 
      'cantidad_comida'=>$cantidad_comida, 
      'precio_comida'=> $precio_comida, 
      'num_cliente_comida'=>$num_cliente_comida, 
      'nombre_bebida' => $nombre_bebida, 
      'cantidad_bebida'=>$cantidad_bebida, 
      'precio_bebida'=> $precio_bebida, 
      'num_cliente_bebida'=>$num_cliente_bebida, 
      'nombre_extra' => $nombre_extra, 
      'cantidad_extra'=>$cantidad_extra, 
      'precio_extra'=> $precio_extra, 
      'num_cliente_extra'=>$num_cliente_extra);

//ESTA LINEA SIGNIFICA QUE LLAMAS A UN METODO DE ÉSTE MISMO CONTROLADOR Y LE PUEDES PASAR PARAMETROS
    //NO SE SI LE PUEDAS PASAR EL ARREGLO QUE ESTA AQUI ARRIBA AL METODO DEL CONTROLADOR, SINO...
    //$this->ticketcancelacionindividual();//ESTE METODO AÚN NO ESTA CREADO

//...SINO PUEDES ENVIAR EL ARREGLO A UNA VISTA, EN ÉSTE CASO TICKET
    //EN LA TERCER LINEA ES LA VISTA, BUENO EL ARCHIVO TICKET
    /* $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('admin/ticket', $ticket_cobroindividual_datos);//EL ARCHIVO TICKET TU LO CREAS
    $this->load->view('layouts/footer'); 
*/
    //ESTOS DATOS NECESITAS PARA LA CANCELACION INDIVIDUAL
// DE AQUI EN ADELANTE NO LE MUEVAS
$cancelaciondeproducto =array('estado' => "cancelado",
'tipo_venta' => "Orden cancelada", 
'Fecha' => $Fecha_venta, 
'Hora' => date('g:i:s a', strtotime($Hora_de_venta)));

$codigoaprobado= $this->consultamenu->validarcodigodecancelacion($clavedecancelacion);


if(empty($clavedecancelacion)){ //si la clave se encuentra vacia no pasa nada y vuelve a cargar la pagina

$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

}


else{// cuando no esta vacia hace lo posible por hacer la cancelacion

if($codigoaprobado['password']=="pineda12"){ //COMPROBANDO QUE EL RESULTADO DE LA CONSULTA COINCIDA CON LA CONTRASEÑA DEL GERENTE

  if(!empty($id_comida) && !empty($precio_comida) ){//ELIMINAR COMIDA
 $this->consultamenu->cancelacioncomida($id_comida, $precio_comida, $cancelaciondeproducto, $num_cliente_comida);

$seagotoelimportedelamesa=$this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodemesa($mesa, $estadoenturno);

if(empty($seagotoelimportedelamesa->importe)  ){ //SI SE RESTO EL ULTIMO ARTICULO EL IMPORTE LLEGARÁ A CERO Y DEBE DE TOMARSE COMO ANULADO DICHO ID VENTA
$idacancelar=
$this->consultamenu->obtenerelidapartirdelaultimacomidacancelada($id_comida, $precio_comida);

$ventacancelada =array('total' => "0", 'pago' =>"0", 'cambio'=> "0", 
'Fecha_venta' => $Fecha_venta, 
'Hora_de_venta' => date('g:i:s a', strtotime($Hora_de_venta)));

$this->consultamenu->definirtotalpagoycambioen0($idacancelar['id_venta'], $ventacancelada);
 $this->iralavista_elegirmesa();
  
} //SI SE RESTO EL ULTIMO ARTICULO EL IMPORTE LLEGARÁ A CERO Y DEBE DE TOMARSE COMO ANULADO DICHO ID VENTA


else{//DADO CASO QUE LOS IMPORTES NO LLEGUEN A CERO IRA A L VISTA ELEGIR CLIENTE
$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);



}//DADO CASO QUE LOS IMPORTES NO LLEGUEN A CERO IRA A L VISTA ELEGIR CLIENTE

 
}//ELIMINAR COMIDA

if(!empty($id_bebida) && !empty($precio_bebida) ){//ELIMINACION DE BEBIDAS
$this->consultamenu->cancelacionbebida($id_bebida, $precio_bebida, $cancelaciondeproducto, $num_cliente_bebida);

$seagotoelimportedelamesa=$this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodemesa($mesa, $estadoenturno);

if(empty($seagotoelimportedelamesa->importe)  ){//SI EL IMPORTE LLEGA A CERO DICHO ID VENTA SE CANCELARA Y SE IRA A LA VISTA ELEGIR MESA
$idacancelar=
$this->consultamenu->obtenerelidapartirdelaultimabebidacancelada($id_bebida, $precio_bebida);

$ventacancelada =array('total' => "0", 'pago' =>"0", 'cambio'=> "0", 
  'Fecha_venta' => $Fecha_venta, 
'Hora_de_venta' => date('g:i:s a', strtotime($Hora_de_venta)));

$this->consultamenu->definirtotalpagoycambioen0($idacancelar['id_venta'], $ventacancelada);
 $this->iralavista_elegirmesa(); 

}//SI EL IMPORTE LLEGA A CERO DICHO ID VENTA SE CANCELARA Y SE IRA A LA VISTA ELEGIR MESA

else{//DAOD CASO QUE NO, SE VOLVERA A LA VISTA ELEGIR CLIENTE
$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);


}//DAOD CASO QUE NO, SE VOLVERA A LA VISTA ELEGIR CLIENTE


}//ELIMINACION DE BEBIDAS

if(!empty($id_extra) && !empty($precio_extra) ){//ELIMINACION DE EXTRAS

$this->consultamenu->cancelacionextra($id_extra, $precio_extra, $cancelaciondeproducto, $num_cliente_extra);

$seagotoelimportedelamesa=$this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodemesa($mesa, $estadoenturno);

if(empty($seagotoelimportedelamesa->importe)  ){//SI EL VALOR DEL IMPORTE LLEGA A CERO SE IRA A LA VISTA ELEGIR MESA Y SE CANCELARA DICHO ID VENTA
$idacancelar=
$this->consultamenu->obtenerelidapartirdelaultimaextracancelado($id_extra, $precio_extra);

$ventacancelada =array('total' => "0", 'pago' =>"0", 'cambio'=> "0", 
  'Fecha_venta' => $Fecha_venta, 
'Hora_de_venta' => date('g:i:s a', strtotime($Hora_de_venta)));

$this->consultamenu->definirtotalpagoycambioen0($idacancelar['id_venta'], $ventacancelada);
 $this->iralavista_elegirmesa();



}//SI EL VALOR DEL IMPORTE LLEGA A CERO SE IRA A LA VISTA ELEGIR MESA Y SE CANCELARA DICHO ID VENTA

else{//EN CASO CONTRARIO ENTRARA A LA VISTA ELEGIR CLIENTE

$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

  
}//EN CASO CONTRARIO ENTRARA A LA VISTA ELEGIR CLIENTE


}//ELIMINACION DE EXTRAS

}//COMPROBANDO QUE EL RESULTADO DE LA CONSULTA COINCIDA CON LA CONTRASEÑA DEL GERENTE

else{//CUANDO LA CLAVE NO COINCIDE CON EL CODIGO DE CANCELACION
$this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);


}//CUANDO LA CLAVE NO COINCIDE CON EL CODIGO DE CANCELACION

}// cuando no esta vacia hace lo posible por hacer la cancelacion



}   //FIN DE CANCELACIONES INDIVIDUALES



//metodo obsoleto, pero dejarlo
	public function numerodemesa($clienteenturno, $numerodemesa, $numerodeclientes){
		$mesa=$numerodemesa;
    $estadoenturno="enturno";
    $clienteenturno =$clienteenturno;
    $numerodeclientes=$numerodeclientes;
		$data = array
		( 
      'cuentaparcial' => $this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodecliente($mesa, $estadoenturno, $clienteenturno),  //cambiar la cuenta parcial a cuenta individual del cliente
      
    'ventadiariabebidas' => $this->consultamenu->detalledeventadiariobebida($clienteenturno, $numerodemesa), 
    'ventadiariaextras' => $this->consultamenu->detalledeventadiarioextras($clienteenturno, $numerodemesa), 
    'ventadiariacomida' => $this->consultamenu->detalledeventadiariocomida($clienteenturno, $numerodemesa));

		$this->load->view('layouts/header');
		$this->load->view('layouts/aside');
	   $this->load->view('admin/opcionesdelcliente', $data);
		$this->load->view('layouts/footer');
		
		
	}	

  public function mesalibre(){
    if($this->input->post("cantidaddeclientes")==0){
$this->iralavista_elegirmesa();
//ESTO COMPRUEBA QUE EL NUMERO DE CLIENTES SEA VACIO, SI LO ES, NO TE DEJA AVANZAR
    }
    else {
//EN CASO QUE EL NUMERO DE CLIENTES NO SEA VACIO
       $numerodeclientesfinal=$this->input->post("cantidaddeclientes");
       $mesa=$this->input->post("numerodemesa");
           //LLAMAR AQUI
           $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientesfinal);
    }
  }

  public function mesaocupada($numerodemesa, $numerodeclientesporestadoenturno){
//EN CASO QUE EL NUMERO DE CLIENTES NO SEA VACIO
       $numerodeclientesfinal=$numerodeclientesporestadoenturno;
       $mesa=$numerodemesa;
           //LLAMAR AQUI
           $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientesfinal);
  }






public function pagoporeltotaldelamesa($mesa, $total, $numerodeclientes){ //cobrar a toda la mesa
//ESTOS SON LOS DATOS QUE OCUPAS PARA EL TICKET
  //ESTO SIRVE PARA OBTENER LA FECHA Y HORA DEL SISTEMA ACTUALMENTE
 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());//1
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());//2

$mesa = $mesa;//3
$total = $total;//4
$numerodeclientes = $numerodeclientes;//5
  $estadoenturno="enturno";
   $estadorealizado="realizado";
  $pago= $this->input->post("pago");//6
  $cambio= $pago-$total;//7

   $ticket_cobropormesa_datos = array
    ('Hora' =>$Hora_de_venta, 
      'Fecha' => $Fecha_venta, 
      'Mesa' => $mesa, 
      'Numerocliente' => $numerodeclientes, 
      'Totalcliente' => $total, 
      'Pago' => $pago, 
      'Cambio' => $cambio,  
      //ESTAS 3 LINEAS TE TRAERAN LAS COMIDAS, BEBIDAS Y EXTRAS EN BASE A DICHA MESA
      'comidas' => $this->consultamenu->detalledeventadiariocomidapormesa($mesa), 
      'bebidas' => $this->consultamenu->detalledeventadiariobebidapormesa($mesa), 
      'extras' => $this->consultamenu->detalledeventadiarioextraspormesa($mesa));

//ESTA LINEA SIGNIFICA QUE LLAMAS A UN METODO DE ÉSTE MISMO CONTROLADOR Y LE PUEDES PASAR PARAMETROS
    //NO SE SI LE PUEDAS PASAR EL ARREGLO QUE ESTA AQUI ARRIBA AL METODO DEL CONTROLADOR, SINO
    //$this->ticketpormesa(); //ESTE METODO AÚN NO ESTA CREADO, PERO IRA EN ESTE CONTROLADOR

//SINO PUEDES ENVIAR EL ARREGLO A UNA VISTA, EN ÉSTE CASO TICKET
    //EN LA TERCER LINEA ES LA VISTA, BUENO EL ARCHIVO TICKET
     /*$this->load->view('layouts/header');
    $this->load->view('layouts/aside');
    $this->load->view('admin/as', $ticket_cobropormesa_datos); //EL ARCHIVO TICKET TU LO CREAS
    $this->load->view('layouts/footer'); 
*/
//ESTOS SON LOS DATOS QUE OCUPAS PARA EL TICKET

  //NO ENTRES A ESTE IF 

if(!empty($pago) && $pago>=$total){//SI EL VALOR PAGO NO ESTA VACIO

$datosparaelupdatetablaventa =array('total' => $total, 'pago' =>$pago, 'cambio'=> $cambio, 'Fecha_venta' =>$Fecha_venta, 
'Hora_de_venta' => date('g:i:s a', strtotime($Hora_de_venta)));

  $dataparaupdateaestadorealizado =array('estado' => $estadorealizado, 'tipo_venta' => "Mesa", 'Fecha' =>$Fecha_venta, 
'Hora' => date('g:i:s a', strtotime($Hora_de_venta)));

$id_venta = $this->consultamenu->revisarelidventaenturno();

       $idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); 
      if(empty($idventayaasignadoaunamesa['id_venta'])){
         $idventadefinitivo=$id_venta['id_venta'];
      }
      else{
        $idventadefinitivo=$idventayaasignadoaunamesa['id_venta'];
      }
$this->consultamenu->cerrarventapormesaenlatablaventa($idventadefinitivo, $datosparaelupdatetablaventa);

$this->consultamenu->agregarestadorealizadoalatabladescripciondeventa($idventadefinitivo, $dataparaupdateaestadorealizado);

 $this->iralavista_elegirmesa();
 

} //SI EL VALOR PAGO ESTA VACIO
else{
   $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);



}
  
}//cobrar a toda la mesa


public function pagodelcliente($mesa, $clienteenturno, $numerodeclientes){
  //LE PERTENECE A LA VISTA OPCIONES DEL CLIENTE
  $estadorealizado="realizado";
  $data = array('estado'=>$estadorealizado);
  $estadoenturno="enturno";
  $mesa=$mesa;
  $id_venta = $this->consultamenu->revisarelidventaenturno();

       $idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); 
      if(empty($idventayaasignadoaunamesa['id_venta'])){
         $idventadefinitivo=$id_venta['id_venta'];
      }
      else{
        $idventadefinitivo=$idventayaasignadoaunamesa['id_venta'];
      }
  $this->consultamenu->cerrarventaporclienteenlatabladescripcionventa($idventadefinitivo, $mesa, $clienteenturno, $data);
 

$datas = array
  ('mesa' =>$mesa, 
    'numerodeclientes' =>$numerodeclientes, 
  'cuentaparcial' => $this->consultamenu->sumadeimportesenlatabladescripciondeventasegunelnumerodemesa($mesa, $estadoenturno));


    $this->load->view('layouts/header');
    $this->load->view('layouts/aside');
     $this->load->view('admin/elegir_cliente', $datas);
    $this->load->view('layouts/footer');
}




	public function Agregaradescripciondeventa($asada, $chorizo, $campechano, $barbacha, $costilla, 
		$sencilla, $id, $numerodemesa, $numerodeclientes){//INICIO DE AGREGAR DESCRIPCION DE VENTA
          /*
          EL PRECIO DE CADA COMIDA
                 */
	              $precioasada= $asada;
	               $preciochorizo= $chorizo;
                $preciocampechano= $campechano;
                $preciobarbacha= $barbacha;
                 $preciocostilla= $costilla; 
                 $preciosencilla= $sencilla;
                 $idcomida= $id;
                 /*
          FIN DEL PRECIO DE CADA COMIDA
                 */

/*
LAS CANTIDADES DE LAS COMIDAS ANTERIORES
*/
		$cantidadasada = $this->input->post("asada");
		$cantidachorizo = $this->input->post("chorizo");
		$cantidacampechano = $this->input->post("campechano");
		$cantidabarbacha = $this->input->post("barbacha");
		$cantidacostilla = $this->input->post("costilla");
		$cantidasencilla = $this->input->post("sencilla");
/*
FIN DE LAS CANTIDADES DE LAS COMIDAS ANTERIORES
*/


/*
LOS IMPORTES
*/
$importeasada=$cantidadasada*$precioasada;
$importechorizo=$cantidachorizo*$preciochorizo;
$importecampechano=$cantidacampechano*$preciocampechano;
$importebarbacha=$cantidabarbacha*$preciobarbacha;
$importecostilla=$cantidacostilla*$preciocostilla;
$importesencilla=$cantidasencilla*$preciosencilla;
/*
FIN DE LOS IMPORTES
*/


/*
NUM CLIENTE
MESA 
ESTADO
*/
 $clienteenturno = $this->input->post("elegircliente");
 $numerodeclientes=$numerodeclientes;
 $mesa=$numerodemesa;
 $estadorealizado="realizado";
 $estadocancelado="cancelado";
  $estadoenturno="enturno";
 $mesero=3;

  
if(!empty($clienteenturno) && !empty($cantidadasada)
|| !empty($cantidachorizo)
|| !empty($cantidacampechano)
|| !empty($cantidabarbacha)
|| !empty($cantidacostilla)
|| !empty($cantidasencilla) ){//LA CONDICIÓN QUE COMPRUEBA QUE POR LO MENOS ESTE UNA CANTIDAD DE CUALQUIERA Y EL ID CLIENTE, SINO HAY NINGUNA CANTIDAD Y EL CLIENTE, NO AGREGA, SI NO HAY NI CANTIDADES NI CLIENTES, NO AGREGA
/*
NUM CLIENTE
MESA 
ESTADO
*/
//echo "PASO LA PRUEBA DE CLIENTE NO VACIO Y AL MENOS UNA CANTIDAD";
      $id_venta = $this->consultamenu->revisarelidventaenturno();

  //*******************************************************************************************************
  if(empty($id_venta['id_venta'])){      //SINO HAY NINGUN ID VENTA
$datosdelatablaventa = array(
       'id_usuario'=> $mesero
);
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);


$this->datosdelatabladescripciondeventa( $precioasada, $preciochorizo, $preciocampechano, $preciobarbacha, $preciocostilla, $preciosencilla, $idcomida, $cantidadasada, $cantidachorizo, $cantidacampechano, $cantidabarbacha, $cantidacostilla, $cantidasencilla, $importeasada, $importechorizo, $importecampechano, $importebarbacha, $importecostilla, $importesencilla, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);



//echo "NO HAY NIGUN ID VENTA, SE CREA NUEVO ID Y SE INSERTA DIRECTAMENTE SOBRE ESE";
  }//FIN DE SINO HAY NINGUN ID VENTA


  //***********************************************************************************************************
  else{ //EN CASO QUE SI HAYA UN ID VENTA
    $id_venta = $this->consultamenu->revisarelidventaenturno();//OBTENIENDO EL ID MAXIMO
    $estado = $this->consultamenu->obtenerelestadodelidventaenturno($id_venta['id_venta']);//EL ESTADO DEL ID VENTA LO OBTENEMOS DEL RESULTADO DE LA CONSULTA DEL ID MAXIMO
//echo "ID_MAXIMO DEL ID ANTERIOR".$id_venta['id_venta'];
//echo "SU ESTADO DEL ID ANTERIOR".$estado['estado'];


    if($estado['estado']=="realizado"||$estado['estado']=="cancelado"){ //CUANDO HAY UN ID VENTA VERIFICAMOS EL ESTADO DEL ID, YA SEA QUE SEA REALIZADO O CANCELADO
   //echo " QUIERE DECIR QUE SE EFECTUO UNA VENTA O QUE DE PLANO SE CANCELOY SE PROCEDE A HACER UN NEUVO ID";
      //SIENDO ASÍ, QUIERE DECIR QUE SE EFECTUO UNA VENTA O QUE DE PLANO SE CANCELOY SE PROCEDE A HACER UN NEUVO ID
      $datosdelatablaventa = array(
       'id_usuario'=> $mesero
      );
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);//DICHO ID SE AGREGA ALA TABLA VENTA PARA QUE GENERE UNO NUEVO
//echo "SE CREA NUEVO ID YA QUE EL PREVIO TIENE UNA VENTA R O C";
$this->datosdelatabladescripciondeventa( $precioasada, $preciochorizo, $preciocampechano, $preciobarbacha, $preciocostilla, $preciosencilla, $idcomida, $cantidadasada, $cantidachorizo, $cantidacampechano, $cantidabarbacha, $cantidacostilla, $cantidasencilla, $importeasada, $importechorizo, $importecampechano, $importebarbacha, $importecostilla, $importesencilla, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
      ///////////////////////////////////////
  }
  else if($estado['estado']=="enturno"){//EN CASO DE QUE EL ESTADO DEL ID MAXIMO SEA DETERMINADO COMO "ENTURNO"
//echo "cuando el estado es en turno ".$estado['estado'];

   $mesaconelestadoenturno= $this->consultamenu->obtenerelnumerodemesadependiendoelidventa($id_venta['id_venta'], $estadoenturno); //OBTENEMOS EL NUMERO DE LA MESA EN BASE AL ID VENTA MAXIMO
  
   

    if($mesaconelestadoenturno['mesa']!=$mesa){//CUANDO LA MESA OBTENIDA DEL ID MAXIMO NO COINCIDE CON LA MESA ACTUAL EN LA QUE QUEREMOS INSERTAR
    //echo "LA MESA DEL ID MAXIMO NO COINCIDE CON LA MESA QUE QUEREMOS INSERTAR";

      $idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); //COMO LA MESA ACTUAL NO COINCIDE CON LA MESA DEL ID MAXIMO, BUSCAMOS UN ID EL CUAL COINCIDA CON LA MESA ACTUAL Y EL ESTATUS "ENTURNO" LA QUE QUEREMOS INSERTAR COMIDA, BEBIDAS, EXTRAS
      if(empty($idventayaasignadoaunamesa['id_venta'])){//COMO NO SE ENCONTRO NINGUN ID RELACIONADO CON LA MESA ACTUAL NI CON EL ESTADO EN TURNO, PUES SE TIENE QUE AGREGAR UN NUEVO ID
$datosdelatablaventa = array(
       'id_usuario'=> $mesero
      );
//echo "NO HAY UN VALOR NULO EN CAMPO TOTAL Y SE DEBE DE HACER OTRO ID";
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);

$this->datosdelatabladescripciondeventa( $precioasada, $preciochorizo, $preciocampechano, $preciobarbacha, $preciocostilla, $preciosencilla, $idcomida, $cantidadasada, $cantidachorizo, $cantidacampechano, $cantidabarbacha, $cantidacostilla, $cantidasencilla, $importeasada, $importechorizo, $importecampechano, $importebarbacha, $importecostilla, $importesencilla, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
      }
        
   else{

//echo "NO HAY UN VALOR NULO EN CAMPO TOTAL Y SE DEBE DE HACER OTRO ID";

$this->datosdelatabladescripciondeventa( $precioasada, $preciochorizo, $preciocampechano, $preciobarbacha, $preciocostilla, $preciosencilla, $idcomida, $cantidadasada, $cantidachorizo, $cantidacampechano, $cantidabarbacha, $cantidacostilla, $cantidasencilla, $importeasada, $importechorizo, $importecampechano, $importebarbacha, $importecostilla, $importesencilla, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
    }
    }
    else{ //SI AMBOS NUMEROS DE MESAS COINCIDEN, INSERTAMOS CON EL MISMO ID_vENTA
      //echo "SI AMBOS NUMEROS DE MESAS COINCIDEN, INSERTAMOS CON EL MISMO ID_vENTA";
      $this->datosdelatabladescripciondeventa( $precioasada, $preciochorizo, $preciocampechano, $preciobarbacha, $preciocostilla, $preciosencilla, $idcomida, $cantidadasada, $cantidachorizo, $cantidacampechano, $cantidabarbacha, $cantidacostilla, $cantidasencilla, $importeasada, $importechorizo, $importecampechano, $importebarbacha, $importecostilla, $importesencilla, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
    }
 
}
  }//FIN DE EN CASO QUE SI HAYA UN ID VENTA


}//FIN DE LA CONDICIÓN QUE COMPRUEBA QUE POR LO MENOS ESTE UNA CANTIDAD DE CUALQUIERA Y EL ID CLIENTE, SINO HAY NINGUNA CANTIDAD Y EL CLIENTE, NO AGREGA, SI NO HAY NI CANTIDADES NI CLIENTES, NO AGREGA

else{//COMO NO SE INSERTO NADA YA QUE LAS VARIABLES CANTIDAD Y NUM CLIENTE ESTAN VACIAS PUES SIMPLEMENTE SE RETORNA LOS DATOA A LA VISTA DE ELEGIR CLIENTE
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);


}//COMO NO SE INSERTO NADA YA QUE LAS VARIABLES CANTIDAD Y NUM CLIENTE ESTAN VACIAS PUES SIMPLEMENTE SE RETORNA LOS DATOA A LA VISTA DE ELEGIR CLIENTE

       

	}//FIN DE AGREGAR DESCRIPCION DE VENTA

	
public function datosdelatabladescripciondeventa( $precioasada, $preciochorizo, $preciocampechano, $preciobarbacha, $preciocostilla, $preciosencilla, $idcomida, $cantidadasada, $cantidachorizo, $cantidacampechano, $cantidabarbacha, $cantidacostilla, $cantidasencilla, $importeasada, $importechorizo, $importecampechano, $importebarbacha, $importecostilla, $importesencilla, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes){//INICIO DE LA FUNCION
$contador=0;
$id_venta = $this->consultamenu->revisarelidventaenturno();


$idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); 
      if(empty($idventayaasignadoaunamesa['id_venta'])){
         $idventadefinitivo=$id_venta['id_venta'];
      }
      else{
        $idventadefinitivo=$idventayaasignadoaunamesa['id_venta'];
      }



  
   //INSERTAR LOS VALORES A LA TABLA DESCRICIÓN DE VENTA, DEPENDIENDO DE SI ES, ASADA, CHORIZO, CAMPECHANO
//BARBACHA, COSTILLA O SENCILLA.
//NO TE DEJA INSERTAR SI EL NUMERO DE CLIENTE Y LA CANTIDAD DE CADA COSA ESTAN VACIAS
  if(!empty($cantidadasada) && !empty($clienteenturno)){ //AGREGANDO EN CASO DE QUE FUERA ASADA
  //echo "cantidad de asada";
     ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());

  $datosdelatabladescripciondeventa = array(
    'id_comida'=>$idcomida,
        'cantidad'=> $cantidadasada,
        'precio_unitario'=>$precioasada,
        'importe'=>$importeasada,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
 $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $precioasada, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $precioasada, $mesa, $clienteenturno);
 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $precioasada, $mesa, $clienteenturno);

//echo "CLIENTE DE LA BASE ".$cliente['num_cliente'];
//echo "CLIENTE EN TURNO".$clienteenturno;


if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario']) ){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base


if($cliente['num_cliente']==$clienteenturno){
  //echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddecomida($idcomida, $precioasada, $cantidadasada, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
    
   }
   else{
    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
      

  }//AGREGANDO EN CASO DE QUE FUERA ASADA


  if(!empty($cantidachorizo)  && !empty($clienteenturno) ){//AGREGANDO EN CASO DE QUE FUERA CHORIZO
 //echo "cantidad de chorizo";
 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());
  $datosdelatabladescripciondeventa = array(
    'id_comida'=>$idcomida,
        'cantidad'=> $cantidachorizo,
        'precio_unitario'=>$preciochorizo,
        'importe'=>$importechorizo,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
 $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciochorizo, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciochorizo, $mesa, $clienteenturno);
 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciochorizo, $mesa, $clienteenturno);

if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario'])){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base
//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddecomida($idcomida, $preciochorizo, $cantidachorizo, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
  
   }
   else{
    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
      

  }//AGREGANDO EN CASO DE QUE FUERA CHORIZO

  if(!empty($cantidacampechano) && !empty($clienteenturno) ){//AGREGANDO EN CASO DE QUE FUERA  CAMPECHANO
 //echo "cantidad de campechano";
 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());
  $datosdelatabladescripciondeventa = array(
    'id_comida'=>$idcomida,
        'cantidad'=> $cantidacampechano,
        'precio_unitario'=>$preciocampechano,
        'importe'=>$importecampechano,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
  $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciocampechano, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciocampechano, $mesa, $clienteenturno);

 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciocampechano, $mesa, $clienteenturno);

if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario'])){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base
//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddecomida($idcomida, $preciocampechano, $cantidacampechano, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
  
   }
     else{
    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA

  }//AGREGANDO EN CASO DE QUE FUERA  CAMPECHANO

  if(!empty($cantidabarbacha) && !empty($clienteenturno) ){//AGREGANDO EN CASO DE QUE FUERA BARBACHA
 //echo "cantidad de barbacha";
 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());
  $datosdelatabladescripciondeventa = array(
    'id_comida'=>$idcomida,
        'cantidad'=> $cantidabarbacha,
        'precio_unitario'=>$preciobarbacha,
        'importe'=>$importebarbacha,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
     $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciobarbacha, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciobarbacha, $mesa, $clienteenturno);
 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciobarbacha, $mesa, $clienteenturno);


if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario']) ){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base
//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddecomida($idcomida, $preciobarbacha, $cantidabarbacha, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
  
 
   }
   else{
    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
      
  }//AGREGANDO EN CASO DE QUE FUERA BARBACHA

  if(!empty($cantidacostilla) && !empty($clienteenturno) ){//AGREGANDO EN CASO DE QUE FUERA COSTILLA
 //echo "cantidad de costilla";
 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());
  $datosdelatabladescripciondeventa = array(
    'id_comida'=>$idcomida,
        'cantidad'=> $cantidacostilla,
        'precio_unitario'=>$preciocostilla,
        'importe'=>$importecostilla,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
$cantidadbase=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciocostilla, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciocostilla, $mesa, $clienteenturno);
 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciocostilla, $mesa, $clienteenturno);




if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario'])){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base
//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddecomida($idcomida, $preciocostilla, $cantidacostilla, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
  
   }
   else{
    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
      
    }//AGREGANDO EN CASO DE QUE FUERA COSTILLA

  if(!empty($cantidasencilla) && !empty($clienteenturno) ){//AGREGANDO EN CASO DE QUE FUERA SENCILLA
 //echo "cantidad de sencilla";
 ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());
  $datosdelatabladescripciondeventa = array(
    'id_comida'=>$idcomida,
        'cantidad'=> $cantidasencilla,
        'precio_unitario'=>$preciosencilla,
        'importe'=>$importesencilla,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
    $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciosencilla, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciosencilla, $mesa, $clienteenturno);
 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoencomida($idcomida, $preciosencilla, $mesa, $clienteenturno);


if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario'])){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base
//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddecomida($idcomida, $preciosencilla, $cantidasencilla, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA

   }
   else{
    //echo "solo se inserta en base";
        $this->consultamenu->agregaralatabladescripciondeventa($datosdelatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
   }

//Lo que pasa aqui es que se le envia el total de la mesa a la vista opciones del cliente
//el total de la mesa se puede deducir de la suma de los importes de la mesa en turno que se obtiene al enviar
//el valor de la mesa en turno
//los datos de la mesa, el menu que incluye, las bebidas, comida y los extras nuevamente se envia a la vista
//para que el usuario/seguir agregando platillos a la cuenta
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);


 }//FIN DE LA FUNCION



public function Agregar_las_bebidas_ala_tabla_descripciondeventa(
  $preciodelabebida, $id_bebida, $mesa, $numerodeclientes){

	$preciodelabebida = $preciodelabebida;
	$id_bebida=$id_bebida;
  $numerodeclientes=$numerodeclientes;

	$cantidaddebebidas = $this->input->post("cantidaddebebidas");
    $mesa=$mesa;
    $clienteenturno=$this->input->post("elegircliente");

    $importedelabebida=$preciodelabebida*$cantidaddebebidas;

     $estadorealizado="realizado";
 $estadocancelado="cancelado";
 $estadoenturno="enturno";
 $mesero=3;
/*
    echo "PRECIO".$preciodelabebida;
    echo "ID".$id_bebida;
    echo "CANTIDAD".$cantidaddebebidas;
    echo "MESA".$mesa;
    echo "CLIENTE".$clienteenturno;
    echo "IMPORTE".$importedelabebida;
*/

    if(!empty($clienteenturno) && !empty($cantidaddebebidas) ){//LA CONDICIÓN QUE COMPRUEBA QUE POR LO MENOS ESTE UNA CANTIDAD DE CUALQUIERA Y EL ID CLIENTE, SINO HAY NINGUNA CANTIDAD Y EL CLIENTE, NO AGREGA, SI NO HAY NI CANTIDADES NI CLIENTES, NO AGREGA
//echo " NO HAY CLIENTE NI CANTIDAD VACIO";

    $id_venta = $this->consultamenu->revisarelidventaenturno();

  //*******************************************************************************************************
  if(empty($id_venta['id_venta'])){//SINO HAY NINGUN ID VENTA
$datosdelatablaventa = array(
       'id_usuario'=> $mesero
);
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);


$this->datosdelasbebidasparalatabladescripciondeventa($preciodelabebida, $id_bebida, $cantidaddebebidas, $importedelabebida, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);


//echo "NO HAY NIGUN ID VENTA";
  }//FIN DE SINO HAY NINGUN ID VENTA


  //***********************************************************************************************************



  //***********************************************************************************************************
  else{ //EN CASO QUE SI HAYA UN ID VENTA
    $id_venta = $this->consultamenu->revisarelidventaenturno();//OBTENIENDO EL ID MAXIMO
    $estado = $this->consultamenu->obtenerelestadodelidventaenturno($id_venta['id_venta']);//EL ESTADO DEL ID VENTA LO OBTENEMOS DEL RESULTADO DE LA CONSULTA DEL ID MAXIMO
//echo " ID_VENTA ".$id_venta['id_venta'];
//echo " ID_VENTA ".$estado['estado'];
//echo "SI HAY UN ID VENTA";
    if($estado['estado']=="realizado"||$estado['estado']=="cancelado"){ //CUANDO HAY UN ID VENTA VERIFICAMOS EL ESTADO DEL ID, YA SEA QUE SEA REALIZADO O CANCELADO
   
      //SIENDO ASÍ, QUIERE DECIR QUE SE EFECTUO UNA VENTA O QUE DE PLANO SE CANCELOY SE PROCEDE A HACER UN NEUVO ID
      $datosdelatablaventa = array(
       'id_usuario'=> $mesero
      );
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);//DICHO ID SE AGREGA ALA TABLA VENTA PARA QUE GENERE UNO NUEVO


  $this->datosdelasbebidasparalatabladescripciondeventa($preciodelabebida, $id_bebida, $cantidaddebebidas, $importedelabebida, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
      ///////////////////////////////////////
  }
  else if($estado['estado']=="enturno"){//EN CASO DE QUE EL ESTADO DEL ID MAXIMO SEA DETERMINADO COMO "ENTURNO"

   $mesaconelestadoenturno= $this->consultamenu->obtenerelnumerodemesadependiendoelidventa($id_venta['id_venta'], $estadoenturno); //OBTENEMOS EL NUMERO DE LA MESA EN BASE AL ID VENTA MAXIMO
  //echo " id maximo en turno";
  //echo "mesa ".$mesaconelestadoenturno['mesa'];
   

    if($mesaconelestadoenturno['mesa']!=$mesa){//CUANDO LA MESA OBTENIDA DEL ID MAXIMO NO COINCIDE CON LA MESA ACTUAL EN LA QUE QUEREMOS INSERTAR
    //echo "LA MESA NO COINCIDE OBTENIDA DEL ID MAXIMO";
      $idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); //COMO LA MESA ACTUAL NO COINCIDE CON LA MESA DEL ID MAXIMO, BUSCAMOS UN ID EL CUAL COINCIDA CON LA MESA ACTUAL Y EL ESTATUS "ENTURNO" LA QUE QUEREMOS INSERTAR COMIDA, BEBIDAS, EXTRAS
      if(empty($idventayaasignadoaunamesa['id_venta'])){//COMO NO SE ENCONTRO NINGUN ID RELACIONADO CON LA MESA ACTUAL NI CON EL ESTADO EN TURNO, PUES SE TIENE QUE AGREGAR UN NUEVO ID
        //echo " IDVENTA YA ASIGNADO A UNA MESA".$idventayaasignadoaunamesa['id_venta'];
$datosdelatablaventa = array(
       'id_usuario'=> $mesero
      );
//echo "NO HAY UN VALOR NULO EN CAMPO TOTAL Y SE DEBE DE HACER OTRO ID";
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);
//echo "se crea nuevo id";

  $this->datosdelasbebidasparalatabladescripciondeventa($preciodelabebida, $id_bebida, $cantidaddebebidas, $importedelabebida, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
      }
        
   else{

//echo "NO HAY UN VALOR NULO EN CAMPO TOTAL Y SE DEBE DE HACER OTRO ID";


  $this->datosdelasbebidasparalatabladescripciondeventa($preciodelabebida, $id_bebida, $cantidaddebebidas, $importedelabebida, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
    }
    }
    else{ //SI AMBOS NUMEROS DE MESAS COINCIDEN, INSERTAMOS CON EL MISMO ID_vENTA
      //echo "SI AMBOS NUMEROS DE MESAS COINCIDEN, INSERTAMOS CON EL MISMO ID_vENTA";

  $this->datosdelasbebidasparalatabladescripciondeventa($preciodelabebida, $id_bebida, $cantidaddebebidas, $importedelabebida, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
    }
 
}
  }//FIN DE EN CASO QUE SI HAYA UN ID VENTA

    }//LA CONDICIÓN QUE COMPRUEBA QUE POR LO MENOS ESTE UNA CANTIDAD DE CUALQUIERA Y EL ID CLIENTE, SINO HAY NINGUNA CANTIDAD Y EL CLIENTE, NO AGREGA, SI NO HAY NI CANTIDADES NI CLIENTES, NO AGREGA

else{//COMO NO SE INSERTO NADA YA QUE LAS VARIABLES CANTIDAD Y NUM CLIENTE ESTAN VACIAS PUES SIMPLEMENTE SE RETORNA LOS DATOA A LA VISTA DE ELEGIR CLIENTE
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

  

}//COMO NO SE INSERTO NADA YA QUE LAS VARIABLES CANTIDAD Y NUM CLIENTE ESTAN VACIAS PUES SIMPLEMENTE SE RETORNA LOS DATOA A LA VISTA DE ELEGIR CLIENTE




    
}//FIN DE AGREGAR LAS BEBIDAS A LA DESCRIPCION DE VENTA


public function datosdelasbebidasparalatabladescripciondeventa($preciodelabebida, $id_bebida, $cantidaddebebidas, $importedelabebida, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes){

$id_venta = $this->consultamenu->revisarelidventaenturno();

$idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); 
      if(empty($idventayaasignadoaunamesa['id_venta'])){
         $idventadefinitivo=$id_venta['id_venta'];
         //echo "ID VENTA EN TURNO ".$idventadefinitivo;

      }
      else{
        $idventadefinitivo=$idventayaasignadoaunamesa['id_venta'];
          //echo "ID VENTA YA ASIGNADO A MESA NO VACIO ".$idventadefinitivo;

      }

	if(!empty($cantidaddebebidas) && !empty($clienteenturno) ){ 
    //echo "NI CANTIDAD DE BEBDIA VACIA NI CLIENTE".$idventadefinitivo;

ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());

	$datosdelasbebidasparalatabladescripciondeventa = array(
		'id_bebida'=>$id_bebida,
        'cantidad'=> $cantidaddebebidas,
        'precio_unitario'=>$preciodelabebida,
        'importe'=>$importedelabebida,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );

   $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoenbebida($id_bebida, $preciodelabebida, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoenbebida($id_bebida, $preciodelabebida, $mesa, $clienteenturno);

 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoenbebida($id_bebida, $preciodelabebida, $mesa, $clienteenturno);

 //echo " CANTIDAD EN BASE".$cantidadbase['cantidad'];
 //echo " PRECIO EN BASE".$precio_unitario['precio_unitario'];
 

   if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario'])){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base


//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddebebida($id_bebida, $preciodelabebida, $cantidaddebebidas, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregarlasbebidasalatabladescripciondeventa($datosdelasbebidasparalatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
  

  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

 
   }
      
else{
        //echo "solo se inserta en base";
        $this->consultamenu->agregarlasbebidasalatabladescripciondeventa($datosdelasbebidasparalatabladescripciondeventa);
          $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

              

          //echo "CONTADOR DESPUES DE ASADA".$contador;
      }
  
   

	}
  //Lo que pasa aqui es que se le envia el total de la mesa a la vista opciones del cliente
//el total de la mesa se puede deducir de la suma de los importes de la mesa en turno que se obtiene al enviar
//el valor de la mesa en turno
//los datos de la mesa, el menu que incluye, las bebidas, comida y los extras nuevamente se envia a la vista
//para que el usuario/seguir agregando platillos a la cuenta
  else{
      $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

    

  }



}


public function Agregar_los_extras_ala_tabla_descripciondeventa($preciodelextra, $id_extra
, $mesa, $numerodeclientes){
	$preciodelextra = $preciodelextra;
	$id_extra=$id_extra;
  $numerodeclientes=$numerodeclientes;

	$cantidaddeextra = $this->input->post("cantidaddeextra");
    $mesa=$mesa;
    $clienteenturno=$this->input->post("elegircliente");

    $importedelextra=$preciodelextra*$cantidaddeextra;
     $estadorealizado="realizado";
 $estadocancelado="cancelado";
  $estadoenturno="enturno";
 $mesero=3;
/*
    echo "PRECIO".$preciodelextra;
    echo "ID".$id_extra;
    echo "CANTIDAD".$cantidaddeextra;
    echo "MESA".$mesa;
    echo "CLIENTE".$clienteenturno;
    echo "IMPORTE".$importedelextra;
  */  
    if(!empty($clienteenturno) && !empty($cantidaddeextra) ){//LA CONDICIÓN QUE COMPRUEBA QUE POR LO MENOS ESTE UNA CANTIDAD DE CUALQUIERA Y EL ID CLIENTE, SINO HAY NINGUNA CANTIDAD Y EL CLIENTE, NO AGREGA, SI NO HAY NI CANTIDADES NI CLIENTES, NO AGREGA


     $id_venta = $this->consultamenu->revisarelidventaenturno();

  //*******************************************************************************************************
  if(empty($id_venta['id_venta'])){//SINO HAY NINGUN ID VENTA
$datosdelatablaventa = array(
       'id_usuario'=> $mesero
);
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);


$this->datosdelosextrasparalatabladescripciondeventa($preciodelextra, $id_extra, $cantidaddeextra, $importedelextra, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);


//echo "NO HAY NIGUN ID VENTA";
  }//FIN DE SINO HAY NINGUN ID VENTA


  //***********************************************************************************************************



  //***********************************************************************************************************
  else{ //EN CASO QUE SI HAYA UN ID VENTA
    $id_venta = $this->consultamenu->revisarelidventaenturno();//OBTENIENDO EL ID MAXIMO
    $estado = $this->consultamenu->obtenerelestadodelidventaenturno($id_venta['id_venta']);//EL ESTADO DEL ID VENTA LO OBTENEMOS DEL RESULTADO DE LA CONSULTA DEL ID MAXIMO

//echo "SI HAY UN ID VENTA";
    if($estado['estado']=="realizado"||$estado['estado']=="cancelado"){ //CUANDO HAY UN ID VENTA VERIFICAMOS EL ESTADO DEL ID, YA SEA QUE SEA REALIZADO O CANCELADO
   
      //SIENDO ASÍ, QUIERE DECIR QUE SE EFECTUO UNA VENTA O QUE DE PLANO SE CANCELOY SE PROCEDE A HACER UN NEUVO ID
      $datosdelatablaventa = array(
       'id_usuario'=> $mesero
      );
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);//DICHO ID SE AGREGA ALA TABLA VENTA PARA QUE GENERE UNO NUEVO

$this->datosdelosextrasparalatabladescripciondeventa($preciodelextra, $id_extra, $cantidaddeextra, $importedelextra, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
      ///////////////////////////////////////
  }
  else if($estado['estado']=="enturno"){//EN CASO DE QUE EL ESTADO DEL ID MAXIMO SEA DETERMINADO COMO "ENTURNO"

   $mesaconelestadoenturno= $this->consultamenu->obtenerelnumerodemesadependiendoelidventa($id_venta['id_venta'], $estadoenturno); //OBTENEMOS EL NUMERO DE LA MESA EN BASE AL ID VENTA MAXIMO
  
   

    if($mesaconelestadoenturno['mesa']!=$mesa){//CUANDO LA MESA OBTENIDA DEL ID MAXIMO NO COINCIDE CON LA MESA ACTUAL EN LA QUE QUEREMOS INSERTAR
    
      $idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); //COMO LA MESA ACTUAL NO COINCIDE CON LA MESA DEL ID MAXIMO, BUSCAMOS UN ID EL CUAL COINCIDA CON LA MESA ACTUAL Y EL ESTATUS "ENTURNO" LA QUE QUEREMOS INSERTAR COMIDA, BEBIDAS, EXTRAS
      if(empty($idventayaasignadoaunamesa['id_venta'])){//COMO NO SE ENCONTRO NINGUN ID RELACIONADO CON LA MESA ACTUAL NI CON EL ESTADO EN TURNO, PUES SE TIENE QUE AGREGAR UN NUEVO ID
$datosdelatablaventa = array(
       'id_usuario'=> $mesero
      );
//echo "NO HAY UN VALOR NULO EN CAMPO TOTAL Y SE DEBE DE HACER OTRO ID";
$this->consultamenu->agregaralatablaventasoloelid($datosdelatablaventa);

$this->datosdelosextrasparalatabladescripciondeventa($preciodelextra, $id_extra, $cantidaddeextra, $importedelextra, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
      }
        
   else{

//echo "NO HAY UN VALOR NULO EN CAMPO TOTAL Y SE DEBE DE HACER OTRO ID";

$this->datosdelosextrasparalatabladescripciondeventa($preciodelextra, $id_extra, $cantidaddeextra, $importedelextra, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
    }
    }
    else{ //SI AMBOS NUMEROS DE MESAS COINCIDEN, INSERTAMOS CON EL MISMO ID_vENTA
$this->datosdelosextrasparalatabladescripciondeventa($preciodelextra, $id_extra, $cantidaddeextra, $importedelextra, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes);
    }
 
}
  }//FIN DE EN CASO QUE SI HAYA UN ID VENTA

    }//LA CONDICIÓN QUE COMPRUEBA QUE POR LO MENOS ESTE UNA CANTIDAD DE CUALQUIERA Y EL ID CLIENTE, SINO HAY NINGUNA CANTIDAD Y EL CLIENTE, NO AGREGA, SI NO HAY NI CANTIDADES NI CLIENTES, NO AGREGA


else{//COMO NO SE INSERTO NADA YA QUE LAS VARIABLES CANTIDAD Y NUM CLIENTE ESTAN VACIAS PUES SIMPLEMENTE SE RETORNA LOS DATOA A LA VISTA DE ELEGIR CLIENTE
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);

  

}//COMO NO SE INSERTO NADA YA QUE LAS VARIABLES CANTIDAD Y NUM CLIENTE ESTAN VACIAS PUES SIMPLEMENTE SE RETORNA LOS DATOA A LA VISTA DE ELEGIR CLIENTE


}//FIN DE AGREGAR LOS EXTRAS A LA TABLA VENTA


public function datosdelosextrasparalatabladescripciondeventa($preciodelextra, $id_extra, $cantidaddeextra, $importedelextra, $clienteenturno, $mesa, $mesero, $estadoenturno, $numerodeclientes){

$id_venta = $this->consultamenu->revisarelidventaenturno();

$idventayaasignadoaunamesa= $this->consultamenu->verificar_queno_haya_un_id_venta_ya_conmesa_asignada($mesa, $estadoenturno); 
      if(empty($idventayaasignadoaunamesa['id_venta'])){
         $idventadefinitivo=$id_venta['id_venta'];
      }
      else{
        $idventadefinitivo=$idventayaasignadoaunamesa['id_venta'];
      }
	if(!empty($cantidaddeextra) && !empty($clienteenturno) ){ 

ini_set('date.timezone', 'America/Mexico_City');
 $Hora_de_venta=date('H:i:s', time());
 date('g:i:s a', strtotime($Hora_de_venta));
$Fecha_venta=date('Y-m-d', time());

	$datosdelosextrasparalatabladescripciondeventa = array(
		'id_extra'=>$id_extra,
        'cantidad'=> $cantidaddeextra,
        'precio_unitario'=>$preciodelextra,
        'importe'=>$importedelextra,
        'id_venta'=>$idventadefinitivo,
        'num_cliente'=>$clienteenturno,
        'mesa'=>$mesa,
        'estado'=>$estadoenturno,
        'numero_de_clientes'=>$numerodeclientes, 
        'tipo_venta' =>"Mesa", 
        'Fecha' =>$Fecha_venta, 
        'Hora' => date('g:i:s a', strtotime($Hora_de_venta))
        );
  $cantidadbase=
 $this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoenextra($id_extra, $preciodelextra, $mesa, $clienteenturno);

 $precio_unitario=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoenextra($id_extra, $preciodelextra, $mesa, $clienteenturno);

 $cliente=$this->consultamenu->solosumarlacantidadsielproductoyaseencuentragregadoenextra($id_extra, $preciodelextra, $mesa, $clienteenturno);

 

   if(!empty($cantidadbase['cantidad']) && !empty($precio_unitario['precio_unitario'])){//llamando al metodo que verifica si el id comida a agregar se encuentra en la base

//echo "SOLO SUMAR CANTIDAD SI EL PRODUCTO YA ESYA AGREGADO ".$idventadefinitivo;
if($cliente['num_cliente']==$clienteenturno){
 //echo "CLiente en la base es igual al cliente en turno";

 $this->consultamenu->actualizarcantidaddeextra($id_extra, $preciodelextra, $cantidaddeextra, $estadoenturno, $mesa, $clienteenturno);//si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base
     //echo "si el id comida se encuentra en la base se suma la nueva cantidad con la cantidad que esta en base".$idventadefinitivo;


}
    
 else{
   //echo "CLiente en la base no es igual al cliente en turno";

    //echo "solo se inserta en base";
        $this->consultamenu->agregarlosextrasalatabladescripciondeventa($datosdelosextrasparalatabladescripciondeventa);
      
  }//AGREGANDO EN CASO DE QUE FUERA SENCILLA
  
  $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);
   }
      else{
        //echo "solo se inserta en base";
        $this->consultamenu->agregarlosextrasalatabladescripciondeventa($datosdelosextrasparalatabladescripciondeventa);
          $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);
          //echo "CONTADOR DESPUES DE ASADA".$contador;
      }
  }
  //Lo que pasa aqui es que se le envia el total de la mesa a la vista opciones del cliente
//el total de la mesa se puede deducir de la suma de los importes de la mesa en turno que se obtiene al enviar
//el valor de la mesa en turno
//los datos de la mesa, el menu que incluye, las bebidas, comida y los extras nuevamente se envia a la vista
//para que el usuario/seguir agregando platillos a la cuenta
  else{
      $this->ir_a_la_vista_elegir_cliente($mesa, $numerodeclientes);
  }
  	
  //Lo que pasa aqui es que se le envia el total de la mesa a la vista opciones del cliente
//el total de la mesa se puede deducir de la suma de los importes de la mesa en turno que se obtiene al enviar
//el valor de la mesa en turno
//los datos de la mesa, el menu que incluye, las bebidas, comida y los extras nuevamente se envia a la vista
//para que el usuario/seguir agregando platillos a la cuenta

}










public function ticketclienteindividual($mesa, $numerodecliente, $totaldelcliente, $pago, $cambio){
  //ESTOS TRES SON LAS CONSULTAS DE BEBIDAS COMIDAS Y EXTRAS
  $comidas = $this->consultamenu->detalledeventadiariocomida($numerodecliente, $mesa);
      $bebidas = $this->consultamenu->detalledeventadiariobebida($numerodecliente, $mesa);
      $extras = $this->consultamenu->detalledeventadiarioextras($numerodecliente, $mesa);
//ESTOS TRES SON LAS CONSULTAS DE BEBIDAS COMIDAS Y EXTRAS

 //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
//include('classes/*'); 
   
/*         Este ejemplo imprime un
  ticket de venta desde una impresora térmica      */

/*      Aquí, en lugar de "POS" (que es el nombre de mi impresora)
  escribe el nombre de la tuya. Recuerda que debes compartirla
  desde el panel de control  POS-58
*/
/* $nombre_impresora = "Star SP500 Tear Bar (SP512)";  */
$nombre_impresora = "POS-58";

$connector = new WindowsPrintConnector($nombre_impresora);
$printer = new Printer($connector);
#Mando un numero de respuesta para saber que se conecto correctamente.
echo 1;

$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("COMPROBANTE DE VENTA" . "\n");


$printer->text("\n"."Restaurante 'El TOLOACHE'" . "\n");
$printer->text("Direccion: Periferico Sur #151" . "\n");
$printer->text("Iguala de la Independencia" . "\n");
$printer->text("Tel: 733-117-0055" . "\n");
        #La fecha también  ============== INICIA FECHA X DEFAULT
date_default_timezone_set("America/Mexico_City");
$printer->text(date("Y-m-d  H:i:s") . "\n");
        #La fecha también  ============== TERMINA FECHA X DEFAULT
      $printer->text("Lo Atendio: ISAUL NO EN DB". "\n"); // EL IDE USEER 
      $printer->text("No. Cliente: " . $numerodecliente . "\n"); // EL no del cliente
      $printer->text("No. Mesa: " . $mesa . "\n"); // MESAA
      $printer->text("Tipo Venta: POR CLIENTE " . "\n"); // tipo de venta k se hace referenciado
$printer->text("==========================================" . "\n");
$printer->setJustification(Printer::JUSTIFY_LEFT);
$printer->text("CANT   DESCRIPCION        Precio $    IMP.\n");
$printer->text("=========================================="."\n");
/*
  Ahora vamos a imprimir los
  productos
*/
  /*Alinear a la izquierda para la cantidad y el nombre*/
  $printer->setJustification(Printer::JUSTIFY_LEFT);
  if (!empty($comidas)){
      foreach($comidas as $comidas)
        $printer->text($comidas->cantidad ."   "); // CANTIDAD en piezas de comida
      $condiciondenombre=$comidas->precio_unitario;
        if ($comidas->nombre_de_categoria=="Tacos"){
          if ($condiciondenombre==15){
              $printer->text($comidas->nombre_de_categoria ." de asada" ."   "); // NOMBRE COMIDA
          }
          if ($condiciondenombre==13){
              $printer->text($comidas->nombre_de_categoria ." de chorizo" ."   "); // NOMBRE COMIDA
          }
          if ($condiciondenombre==17){
              $printer->text($comidas->nombre_de_categoria ." de campechano" ."   "); // NOMBRE COMIDA --> ASI PARA DAR  SALTO -- ." de"."\n"."campechano" ." "
          }
          if ($condiciondenombre==14){
              $printer->text($comidas->nombre_de_categoria ." de barbacha" ."   "); // NOMBRE COMIDA
          }
          if ($condiciondenombre==35){
              $printer->text($comidas->nombre_de_categoria ." de costilla" ."   "); // NOMBRE COMIDA
          }
          if ($comidas->nombre_de_categoria=="Quekas"){
             if ($condiciondenombre==45){
              $printer->text($comidas->nombre_de_categoria ." de asada" ." "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==40){
              $printer->text($comidas->nombre_de_categoria ." de chorizo" ." "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==50){
              $printer->text($comidas->nombre_de_categoria ." de campechano" ." "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==46){
              $printer->text($comidas->nombre_de_categoria ." de barbacha" ." "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==70){
              $printer->text($comidas->nombre_de_categoria ." de costilla" ." "); // NOMBRE COMIDA
              }
          }
          if ($comidas->nombre_de_categoria=="Al horno"){
             if ($condiciondenombre==45){
              $printer->text($comidas->nombre_de_categoria ." de asada" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==40){
              $printer->text($comidas->nombre_de_categoria ." de chorizo" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==50){
              $printer->text($comidas->nombre_de_categoria ." de campechano" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==46){
              $printer->text($comidas->nombre_de_categoria ." de barbacha" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==70){
              $printer->text($comidas->nombre_de_categoria ." de costilla" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==35){
              $printer->text($comidas->nombre_de_categoria ." de sencilla" ."  "); // NOMBRE COMIDA
              }
          }
          if ($comidas->nombre_de_categoria=="Mulas"){
             if ($condiciondenombre==19){
              $printer->text($comidas->nombre_de_categoria ." de asada" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==17){
              $printer->text($comidas->nombre_de_categoria ." de chorizo" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==21){
              $printer->text($comidas->nombre_de_categoria ." de campechano" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==18){
              $printer->text($comidas->nombre_de_categoria ." de barbacha" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==45){
              $printer->text($comidas->nombre_de_categoria ." de costilla" ."  "); // NOMBRE COMIDA
              }
              
          }
          if ($comidas->nombre_de_categoria=="Burritos"){
             if ($condiciondenombre==45){
              $printer->text($comidas->nombre_de_categoria ." de asada" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==40){
              $printer->text($comidas->nombre_de_categoria ." de chorizo" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==50){
              $printer->text($comidas->nombre_de_categoria ." de campechano"); // NOMBRE COMIDA
              }
              if ($condiciondenombre==46){
              $printer->text($comidas->nombre_de_categoria ." de barbacha" ."  "); // NOMBRE COMIDA
              }
              if ($condiciondenombre==70){
              $printer->text($comidas->nombre_de_categoria ." de costilla" ."  "); // NOMBRE COMIDA
              }
              
          }

    }       
        $printer->text($comidas->precio_unitario ."       "); // PRECIO UNITARIO       --- . "\n"
        $printer->text($comidas->importe . "\n"); // IMPORTE
    }
    if (!empty($bebidas)){   //  BEBIDASSSS
      foreach($bebidas as $bebidas)
        $printer->text($bebidas->cantidad ."   "); // CANTIDAD piesas
        $printer->text($bebidas->nombre_bebida ."   "); // NOMREB BEBIDA
        $printer->text($bebidas->precio_unitario ."    "); // PRECIO_UNITARIO
        $printer->text($bebidas->importe . "\n"); // IMPORTE
    }
    if (!empty($extras)){   // EXTRASSS
      foreach($extras as $extras)
        $printer->text($extras->cantidad ."   "); // CANTIDAD
        $printer->text($extras->nombre ."   "); // NOMREB EXTRA  
        $printer->text("$" . $extras->precio_unitario ."       "); // PRECIO_UNITARIO
        $printer->text($extras->importe . "\n"); // IMPORTE
    }              
//  ESPASCIOOSSS ---> $printer->text($pago ." ". $cambio ." ". $totaldelcliente ." ". $mesa . "\n"); 
  /*  Terminamos de imprimir
  los productos, ahora va el total    */
$printer->text("=========================================="."\n");
$printer->setJustification(Printer::JUSTIFY_RIGHT);
$printer->text("TOTAL: $" . $totaldelcliente . "\n");
$printer->text("PAGO: $" . $pago . "\n");
$printer->text("CAMBIO: $" . $cambio . "\n");
          /*         Podemos poner también un pie de página      */
$printer->setJustification(Printer::JUSTIFY_CENTER);
$printer->text("Muchas gracias por su preferencia\n");

$printer->feed(3);
$printer->cut();

/*
  Por medio de la impresora mandamos un pulso.
  Esto es útil cuando la tenemos conectada
  por ejemplo a un cajón
*/
$printer->pulse();

/*
  Para imprimir realmente, tenemos que "cerrar"
  la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
*/
$printer->close();

}






















}//EL METODO CONTROLLER



