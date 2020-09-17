<?php


date_default_timezone_set('America/Mexico_City');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

$fecha = date('Y-m-d-H-i-s');


require('fpdf.php');



$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

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

$pdf->Image('F20926-1.jpg' , 0 ,0, 210 , 0,'JPG');

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

/////////////////////////////////////// pagina 2 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-2.jpg' , 0 ,0, 210 , 0,'JPG');



/////////////////////////////////////// pagina 3 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-3.jpg' , 0 ,0, 210 , 0,'JPG');



/////////////////////////////////////// pagina 4 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-4.jpg' , 0 ,0, 210 , 0,'JPG');



/////////////////////////////////////// pagina 5 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-5.jpg' , 0 ,0, 210 , 0,'JPG');




/////////////////////////////////////// pagina 6 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-6.jpg' , 0 ,0, 210 , 0,'JPG');



/////////////////////////////////////// pagina 7 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-7.jpg' , 0 ,0, 210 , 0,'JPG');





/************************** fin ********************************************************/


$pdf->Output('F20926AC.pdf', 'I');


?>
