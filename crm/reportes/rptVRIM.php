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

$pdf->SetMargins(0,0,0);

//$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";

///********************* pagina 1 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('FVRIM-1.png' , 0 ,0, 210 , 0,'PNG');

//fecha de solicitud
$pdf->SetXY(144, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("20/05/1985",0,20));

//folio VI
$pdf->SetXY(179, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//tipo de tarjeta
$pdf->SetXY(62, $yConstCuadrado1 + ($yCuadrado1 * 6) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//cantidad
$pdf->SetXY(112.5, $yConstCuadrado1 + ($yCuadrado1 * 6) + 3);
$pdf->Write(0, substr("1",0,1));

//importe
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 6) + 3);
$pdf->Write(0, substr("MX 9.999,99",0,12));

//importe
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3);
$pdf->Write(0, substr("MX 9.999,99",0,12));


//dia
$pdf->SetXY(103, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("31",0,2));
//mes
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("Septiembre",0,15));
//anio
$pdf->SetXY(156, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("2020",0,4));

//clave del asesor
$pdf->SetXY(93, $yConstCuadrado1 + ($yCuadrado1 * 24));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

/************************** fin ********************************************************/
///********************* pagina 2 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 180;

$pdf->Image('FVRIM-2.png' , 0 ,0, 210 , 0,'PNG');

//dia
$pdf->SetXY(113, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("31",0,2));
//mes
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("Septiembre",0,15));
//anio
$pdf->SetXY(143, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("2020",0,4));

//autorizo a enviarme informacion (si)
$pdf->SetXY(170, $yConstCuadrado1 + ($yCuadrado1 * 14) - 0.5);
$pdf->Write(0, substr("X",0,1));
//autorizo a enviarme informacion (no)
$pdf->SetXY(180, $yConstCuadrado1 + ($yCuadrado1 * 14) - 0.5);
$pdf->Write(0, substr("X",0,1));

/************************** fin ********************************************************/
///********************* pagina 3 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('FVRIM-3.png' , 0 ,0, 210 , 0,'PNG');

//fecha de solicitud
$pdf->SetXY(144, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("20/05/1985",0,20));

//folio VI
$pdf->SetXY(179, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//cliente inbursa
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 2) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//rfc
$pdf->SetXY(45, $yConstCuadrado1 + ($yCuadrado1 * 2) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,13));

//persona fisica
$pdf->SetXY(184.6, $yConstCuadrado1 + ($yCuadrado1 * 2) - 1.5 );
$pdf->Write(0, substr("x",0,1));

//persona moral
$pdf->SetXY(184.6, $yConstCuadrado1 + ($yCuadrado1 * 2) + 2.5);
$pdf->Write(0, substr("x",0,1));

//denominacion o razon social
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 4) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//primer nombre
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 5) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 5) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido paterno
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 7) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 7) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//fecha nacimiento
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 10) );
$pdf->Write(0, substr("20/05/1985",0,10));

//genero femenino
$pdf->SetXY(60.3, $yConstCuadrado1 + ($yCuadrado1 * 10) - 4 );
$pdf->Write(0, substr("x",0,1));

//genero masculino
$pdf->SetXY(60.3, $yConstCuadrado1 + ($yCuadrado1 * 10) );
$pdf->Write(0, substr("x",0,1));

//estado civil casado
$pdf->SetXY(97.3, $yConstCuadrado1 + ($yCuadrado1 * 10) - 4 );
$pdf->Write(0, substr("x",0,1));

//estado civil soltero
$pdf->SetXY(97.3, $yConstCuadrado1 + ($yCuadrado1 * 10) );
$pdf->Write(0, substr("x",0,1));

//calle
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//num exterior
$pdf->SetXY(92, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//edificio
$pdf->SetXY(119, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//num interior
$pdf->SetXY(157, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//cp
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//colonia
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 14)+ 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//munucipio
$pdf->SetXY(112, $yConstCuadrado1 + ($yCuadrado1 * 14) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//ciudad
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 15) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//entidad federativa
$pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 15) + 4 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//pais
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 15) + 4 );
$pdf->Write(0, substr("MEXICO",0,20));

//TELEFONO FIJO
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 17) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//TELEFONO celular
$pdf->SetXY(87, $yConstCuadrado1 + ($yCuadrado1 * 17) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//email
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 19) );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//calle
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//num exterior
$pdf->SetXY(92, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//edificio
$pdf->SetXY(119, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//num interior
$pdf->SetXY(157, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//cp
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//colonia
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 23)+ 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//munucipio
$pdf->SetXY(112, $yConstCuadrado1 + ($yCuadrado1 * 23) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//ciudad
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 24) + 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//entidad federativa
$pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 24) + 5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//pais
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 24) + 5 );
$pdf->Write(0, substr("MEXICO",0,20));

//primer nombre
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 30) );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 30));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido paterno
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 32) - 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 32) - 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//fecha nacimiento
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 34) - 3 );
$pdf->Write(0, substr("20/05/1985",0,10));

//parentesco
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 34) - 3 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

/************************** fin ********************************************************/
///********************* pagina 4 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image('FVRIM-4.png' , 0 ,0, 210 , 0,'PNG');


/************************** fin ********************************************************/
///********************* pagina 5 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image('FVRIM-5.png' , 0 ,0, 210 , 0,'PNG');



/************************** fin ********************************************************/
///********************* pagina 6 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image('FVRIM-6.png' , 0 ,0, 210 , 0,'PNG');



/************************** fin ********************************************************/
///********************* pagina 7 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image('FVRIM-7.png' , 0 ,0, 210 , 0,'PNG');



/************************** fin ********************************************************/

$pdf->Output('F650AC.pdf', 'I');


?>
