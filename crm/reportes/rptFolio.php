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


//require('fpdf.php');

require 'PDFMerger.php';

$pdfi = new PDFMerger;

//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

$id         =  $_GET['id'];

$resFolio = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionPostulante($id);

$pdf = new FPDF();


#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(false,1);
$ar = array();
while ($row = mysql_fetch_array($resFolio)) {
   $pdf->AddPage();

   $pos = strpos( strtolower($row['type']), 'pdf');
   if ($pos === false) {
      $pdf->Image('../archivos/postulantes/'.$id.'/'.$row['carpeta'].'/'.$row['archivo'],10,10,190);
   } else {
      //array_push($ar,$_SERVER['DOCUMENT_ROOT'].'asesorescrea.git/trunk/crm/archivos/postulantes/'.$id.'/'.$row['carpeta'].'/'.$row['archivo']);
      $nombreTurno = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm/reportes/folioPrevio".$fecha.".pdf";
      $pdf->Output($nombreTurno,'F');

      array_push($ar,$nombreTurno);

      array_push($ar,$_SERVER['DOCUMENT_ROOT'].'desarrollo/crm/archivos/postulantes/'.$id.'/'.$row['carpeta'].'/'.$row['archivo']);
   }


}


//die(var_dump($ar));


//$nombreTurno = $_SERVER['DOCUMENT_ROOT'].'asesorescrea/trunk/crm/reportes/folioPrevio'.$fecha.".pdf";

//$nombreTurno = $_SERVER['DOCUMENT_ROOT']."asesorescrea.git/trunk/crm/reportes/folioPrevio".$fecha.".pdf";

//$pdf->Output($nombreTurno,'F');

if (count($ar)>0) {


   $pdfi->addPDF($nombreTurno, 'all');

   foreach ($ar as $value) {
      // code...
      //die(var_dump($ar));
      $pdfi->addPDF($value, 'all');
   }

   //C:/xampp/htdocs/asesorescrea.git/trunk/crm/archivos/postulantes/5/cf2/firma2.pdf

   /*
   $pdfi->addPDF("C:/xampp/htdocs/asesorescrea.git/trunk/crm/archivos/postulantes/5/cf2/firma2.pdf", 'all')
   ->merge('file', $_SERVER['DOCUMENT_ROOT'].'asesorescrea.git/trunk/crm/archivos/postulantes/'.$id.'/foliocompleto/pagina3.pdf');
   */

   //$pdfi->merge('browser', $_SERVER['DOCUMENT_ROOT'].'asesorescrea.git/trunk/crm/archivos/postulantes/'.$id.'/foliocompleto/pagina3.pdf');

   $pdfi->merge('browser', $_SERVER['DOCUMENT_ROOT'].'desarrollo/crm/archivos/postulantes/'.$id.'/foliocompleto/pagina3.pdf');

} else {
   $pdf->Output($nombreTurno,'I');
}


//$pdf->Output($nombreTurno,'I');


?>
