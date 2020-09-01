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
$pdf->setSourceFile('F20926.pdf');
// import page 1
$tplIdx = $pdf->importPage(7);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page
$pdf->SetFont('Arial');
$pdf->SetTextColor(255,0,0);
$pdf->SetXY(25, 25);
$pdf->Write(0, "This is just a simple text");

$pdf->Output('F20926AC.pdf', 'I');
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
