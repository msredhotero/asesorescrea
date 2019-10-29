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

$busqueda = trim($_POST['busqueda']);

$ar = array();

if ($busqueda != '') {

$res = $serviciosReferencias->buscarPostal(utf8_decode($busqueda));


$cad = '';
	while ($row = mysql_fetch_array($res)) {

		array_push($ar,array('id'=>$row['id'], 'codigo'=> $row['codigo'], 'colonia'=> utf8_encode($row['colonia']), 'municipio'=> utf8_encode($row['municipio']), 'estado'=> utf8_encode($row['estado'])));
	}

}
//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo json_encode($ar);

?>
