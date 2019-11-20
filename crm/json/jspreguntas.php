<?php

session_start();

include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

$secuencia = trim($_GET['secuencia']);

$ar = array();

if ($secuencia != '') {

$res = $serviciosReferencias->traerPreguntasPorSecuencia($secuencia);


$cad = '';
	while ($row = mysql_fetch_array($res)) {

		array_push($ar,array('idpregunta'=>$row['idpregunta'],
                           'secuencia'=> $row['secuencia'],
                           'pregunta'=> utf8_encode($row['pregunta']),
                           'respuesta1'=> utf8_encode($row['respuesta1']),
                           'respuesta2'=> utf8_encode($row['respuesta2']),
                           'respuesta3'=> utf8_encode($row['respuesta3']),
                           'respuesta4'=> utf8_encode($row['respuesta4']),
                           'respuesta5'=> utf8_encode($row['respuesta5']),
                           'respuesta6'=> utf8_encode($row['respuesta6']),
                           'respuesta7'=> utf8_encode($row['respuesta7']),
                           'valor'=> ($row['valor']),
                           'depende'=> ($row['depende']),
                           'tiempo'=> ($row['tiempo'])
                        ));
	}

}
//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo json_encode($ar);

?>
