<?php

session_start();

if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../../error.php');
} else {


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

$res = $serviciosReferencias->buscarPostal($busqueda);


$cad = '';
	while ($row = mysql_fetch_array($res)) {

		array_push($ar,array('id'=>$row['id'], 'codigo'=> $row['codigo'], 'colonia'=> ($row['colonia']), 'municipio'=> ($row['municipio']), 'estado'=> ($row['estado'])));
	}

}
//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo json_encode($ar);
}
?>
