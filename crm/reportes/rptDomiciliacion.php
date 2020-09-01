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

include('fpdi.php');

//require 'PDFMerger.php';

//$pdfi = new PDFMerger;



//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$pdf = new FPDF();

$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";
//die(var_dump($directorio));

/* local  **************************
$directorio = $_SERVER['DOCUMENT_ROOT']."asesorescrea.git/trunk/crm";
*/


/***** produccion  ******
$directorio = $_SERVER['DOCUMENT_ROOT']."crm";
*/

//rrmdir($directorio.'/archivos/postulantes/'.$id.'/foliocompleto');

#Establecemos el margen inferior:


$pdf =& new FPDI();
// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('Domiciliacion.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 6;
$yConstCuadrado1 = 28;

//Nombre
$pdf->SetXY(18, $yConstCuadrado1);
$pdf->Write(0, "SAUPUREIN SAFAR MARCOS DANIEL");

//Calle
$pdf->SetXY(27, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,25));

//Colonia
$pdf->SetXY(95, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,25));

//CP
$pdf->SetXY(170, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,6));

//Ciudad
$pdf->SetXY(18, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//Telefono
$pdf->SetXY(127, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("SAUPUREIN SAFARasd MARCOS DANIEL",0,20));

//Telefono Celular
$pdf->SetXY(27, $yConstCuadrado1 + ($yCuadrado1 * 3));
$pdf->Write(0, substr("SAUPUREIN SAFARasd MARCOS DANIEL",0,20));

//Email
$pdf->SetXY(120, $yConstCuadrado1 + ($yCuadrado1 * 3));
$pdf->Write(0, substr("SAUPUREIN SAFARasd MARCOS DANIEL",0,30));



//Emisor
$pdf->SetXY(14, $yConstCuadrado1 + ($yCuadrado1 * 5) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,14));

//Carpeta
$pdf->SetXY(57, $yConstCuadrado1 + ($yCuadrado1 * 5) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFARasd MARCOS DANIEL",0,20));

//Poliza
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 5) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFARasd MARCOS DANIEL",0,20));

//CIS
$pdf->SetXY(159, $yConstCuadrado1 + ($yCuadrado1 * 5) + 1);
$pdf->Write(0, substr("SAUPUREIN",0,20));




//Banco
$pdf->SetXY(16, $yConstCuadrado1 + ($yCuadrado1 * 8) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,14));

$pdf->SetFont('Arial','',12);
//Nro Tarjeta
$pdf->SetXY(33, $yConstCuadrado1 + ($yCuadrado1 * 9) + 4);
$pdf->Write(0, substr("5555 5555 5555 4444",0,20));

//Fecha Vencimiento
$pdf->SetXY(45, $yConstCuadrado1 + ($yCuadrado1 * 10) + 5);
$pdf->Write(0, substr("01-02-2021",0,20));


$pdf->SetFont('Arial','',8);
//Banco
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 8) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,14));

$pdf->SetFont('Arial','',12);
//Nro Tarjeta
$pdf->SetXY(132, $yConstCuadrado1 + ($yCuadrado1 * 9) + 3);
$pdf->Write(0, substr("0143548963485632145223",0,20));

//plaza
$pdf->SetXY(115, $yConstCuadrado1 + ($yCuadrado1 * 10) + 5);
$pdf->Write(0, substr("156",0,20)); //no llevan informacion

//sucursal
$pdf->SetXY(172, $yConstCuadrado1 + ($yCuadrado1 * 10) + 5);
$pdf->Write(0, substr("6547",0,20)); //no llevan informacion



$pdf->Output('DomiciliacionAC.pdf', 'I');





?>
