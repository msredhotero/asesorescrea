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

//include('fpdi.php');

//require 'PDFMerger.php';

//$pdfi = new PDFMerger;



//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$pdf = new FPDF();

//$pdfi = new FPDI();

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


//$pdf =& new FPDI();
// add a page
$pdf->AddPage();
// set the sourcefile
//$pdf->setSourceFile('F650a_compressed_resized.pdf');
// import page 1
//$tplIdx = $pdf->importPage(2);
// use the imported page as the template
//$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page
//$pdf->SetFont('Arial');
//$pdf->SetTextColor(255,0,0);
//$pdf->SetXY(25, 25);
//$pdf->Write(0, "This is just a simple text");

// now write some text above the imported page
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 9;
$yConstCuadrado1 = 55;

$pdf->Image('F650a.png' , 0 ,0, 210 , 0,'PNG');

//poliza
$pdf->SetXY(8, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//nro empleado
$pdf->SetXY(60, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//grupo asegurado
$pdf->SetXY(102, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//Demominacion o razon social contratante
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,150));

//suma asegurada o regla para determinarla
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 2) - 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//vig dd
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig mm
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig yyyy
$pdf->SetXY(134, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("2020",0,4));


//vig dd
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig mm
$pdf->SetXY(177, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig yyyy
$pdf->SetXY(189, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("2022",0,4));


//primer nombre
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 4) - 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 4) - 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//apellido paterno
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 5) - 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 5) - 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//fecha nac dd
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("20",0,2));

//fecha nac mm
$pdf->SetXY(20, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("05",0,2));

//fecha nac yyyy
$pdf->SetXY(32, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("1985",0,4));


//genero masculino
$pdf->SetXY(49, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("X",0,1));

//genero femenino
$pdf->SetXY(49, $yConstCuadrado1 + ($yCuadrado1 * 6) - 1.5);
$pdf->Write(0, substr("X",0,1));


//categoria
$pdf->SetXY(73, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20)); //no mostrar informacion

//SUELDO MENSUAL
$pdf->SetXY(132, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12)); //no mostrar informacion

//fecha ingreso al grupo dd
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("05",0,2));

//fecha ingreso al grupo mm
$pdf->SetXY(177, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("12",0,2));

//fecha ingreso al grupo yyyy
$pdf->SetXY(189, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("2018",0,4));



//peso
$pdf->SetXY(25, $yConstCuadrado1 + ($yCuadrado1 * 10) - 7);
$pdf->Write(0, substr("95",0,2));

//altura
$pdf->SetXY(45, $yConstCuadrado1 + ($yCuadrado1 * 10) - 7);
$pdf->Write(0, substr("170",0,3));

$pdf->Output('F650AC.pdf', 'I');
//die(var_dump($ar));


//$nombreTurno = $_SERVER['DOCUMENT_ROOT'].'asesorescrea/trunk/crm/reportes/folioPrevio'.$fecha.".pdf";

//$nombreTurno = $_SERVER['DOCUMENT_ROOT']."asesorescrea.git/trunk/crm/reportes/folioPrevio".$fecha.".pdf";

//$pdf->Output($nombreTurno,'F');

//$pdf->Output($nombreTurno,'F');


if (count($ar)>0) {


   $pdfi->addPDF($nombreTurno, 'all');

   foreach ($ar as $value) {
      // code...
      //die(var_dump($ar));
      $pdfi->addPDF($value, 'all');
   }


   $pdfi->merge('browser', $directorio.'/archivos/postulantes/'.$id.'/foliocompleto/pagina3.pdf');

} else {
   $pdf->Output($nombreTurno,'I');
}

$pdfi->Output($nombreTurno,'I');

//$pdf->Output($nombreTurno,'I');


?>
