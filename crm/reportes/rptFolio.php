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

$fecha = date('Y-m-d');


require('fpdf.php');


//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

$id         =  $_GET['id'];

$resFolio = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionPostulante($id);

$pdf = new FPDF();


#Establecemos el margen inferior:
$pdf->SetAutoPageBreak(false,1);

while ($row = mysql_fetch_array($resFolio)) {
   $pdf->AddPage();

   $pos = strpos( strtolower($row['type']), 'pdf');
   if ($pos === false) {
      $pdf->Image('../archivos/postulantes/'.$id.'/'.$row['carpeta'].'/'.$row['archivo'],10,10,190);
   } else {

   }


}





$nombreTurno = "FOLIO-".$fecha.".pdf";

$pdf->Output($nombreTurno,'I');


?>
