<?php


date_default_timezone_set('America/Mexico_City');

//include ('../includes/funcionesUsuarios.php');
//include ('../includes/funciones.php');
//include ('../includes/funcionesHTML.php');
//include ('../includes/funcionesReferencias.php');

/*
$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

$fecha = date('Y-m-d-H-i-s');
*/

require('fpdf.php');



$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$idCliente = mysql_result($resCotizacion,0,'refclientes');

$pdf = new FPDF();

//$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";
//die(var_dump($directorio));

/////////////////////////////////////// pagina 1 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 7.7;
$yConstCuadrado1 = 58;

$pdf->Image(__DIR__.'/'.'F20926-1.jpg' , 0 ,0, 210 , 0,'JPG');

//EMISOR
$pdf->SetXY(124, 25);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,7));

//clave agente
$pdf->SetXY(158, 25);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));


//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//masculino
$pdf->SetXY(18.5, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("x",0,1));

//femenino
$pdf->SetXY(27.5, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("x",0,1));

//fecha nacimiento
$pdf->SetXY(53, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("20/05/1985",0,10));

//nacionalidad
$pdf->SetXY(93, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("MEXICANO",0,20));

//RFC
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("AWEDFR126WS9A",0,13));


//CURP
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//FIRMA FIEL
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//tipo identificacion
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 4) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//numero de identificacion
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 4) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//pais de nacimiento
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 5) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//entidad federativa de nacimiento
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 5) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(135, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(155, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(168, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 9) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 9) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//lada
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//telefono
$pdf->SetXY(24, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//correo email
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//empleado publico
$pdf->SetXY(35.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
$pdf->Write(0, substr("x",0,1));

//empleado privado
$pdf->SetXY(35.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
$pdf->Write(0, substr("x",0,1));

//ingreso por honorarios
$pdf->SetXY(74.5, $yConstCuadrado1 + ($yCuadrado1 * 13) - 2.5);
$pdf->Write(0, substr("x",0,1));

//actividad
$pdf->SetXY(74.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//empleado
$pdf->SetXY(149.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
$pdf->Write(0, substr("x",0,1));

//comerciante
$pdf->SetXY(149.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
$pdf->Write(0, substr("x",0,1));

//comisionista
$pdf->SetXY(176.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
$pdf->Write(0, substr("x",0,1));

//indique
$pdf->SetXY(170.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//desemplado
$pdf->SetXY(30, $yConstCuadrado1 + ($yCuadrado1 * 15) +2);
$pdf->Write(0, substr("x",0,1));

//ama de casa
$pdf->SetXY(56, $yConstCuadrado1 + ($yCuadrado1 * 15) -1);
$pdf->Write(0, substr("x",0,1));

//estudiante
$pdf->SetXY(56, $yConstCuadrado1 + ($yCuadrado1 * 15) +4);
$pdf->Write(0, substr("x",0,1));

//arrendatario
$pdf->SetXY(78.5, $yConstCuadrado1 + ($yCuadrado1 * 15) +1.5);
$pdf->Write(0, substr("x",0,1));

//inversionista
$pdf->SetXY(115, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
$pdf->Write(0, substr("x",0,1));

//otro
$pdf->SetXY(142, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
$pdf->Write(0, substr("x",0,1));

//jubilado
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 15) +1.5);
$pdf->Write(0, substr("x",0,1));

//otro indique
$pdf->SetXY(153, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));


//desempeño funcion publica en el extranjero (no)
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//desempeño funcion publica en el extranjero (si)
$pdf->SetXY(28, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//que cargo
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 17) - 0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//fecha en que dejo el cargo
$pdf->SetXY(46, $yConstCuadrado1 + ($yCuadrado1 * 18) - 4);
$pdf->Write(0, substr("20/05/2020",0,10));

//familiar de persona que desempeño (no)
$pdf->SetXY(104.5, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//familiar de persona que desempeño (si)
$pdf->SetXY(125, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//que cargo
$pdf->SetXY(154, $yConstCuadrado1 + ($yCuadrado1 * 17) - 0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//fecha en que dejo el cargo
$pdf->SetXY(128, $yConstCuadrado1 + ($yCuadrado1 * 18) - 3.5);
$pdf->Write(0, substr("20/05/2020",0,10));

//fecha en que dejo el cargo
$pdf->SetXY(169, $yConstCuadrado1 + ($yCuadrado1 * 18) - 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

/****
aca va lo que falta

*****/


/////////////////////////////////// INE //////////////////////////////////////////////
$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');


while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
   $pdf->AddPage();

   $pdf->SetFont('Arial','',8);
   $pdf->SetTextColor(0,0,0);

   $yCuadrado1 = 5;
   $yConstCuadrado1 = 20;

   //$tipo =

   //die(var_dump())
   $pdf->Image(__DIR__.'/'.'../archivos/clientes/'.$idCliente.'/'.$rowD['carpeta'].'/'.$rowD['archivo'] , 0 ,0, 100 , 0,explode('/',$rowD['type'])[1]);

}


////////////////////////////// FIN DEL INE //////////////////////////////////////////

if (!file_exists(__DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/')) {
   mkdir(__DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/', 0777);
}

$pdf->Output( __DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/FSOLICITUDAC.pdf', 'F');


?>