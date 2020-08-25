<?php


include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/base.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();


$preguntasSencibles = $serviciosReferencias->necesitoPreguntaSencible(5,5);

foreach ($preguntasSencibles[1] as $item) {
   $resPP = $serviciosReferencias->traerPreguntascuestionarioPorId($item['idpreguntanecesario']);
   $resPS = $serviciosReferencias->traerPreguntaSenciblePorId(mysql_result($resPP,0,'refpreguntassencibles'));

   echo mysql_result($resPS,0,'campo').'<br>';
   echo $item['idpreguntanecesario'].'<br>';
   echo $item['valor'].'<br>';
   echo $item['campo'].'<br>';
}


?>
