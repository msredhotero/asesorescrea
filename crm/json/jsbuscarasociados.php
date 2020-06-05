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
$tipo = $_POST['tipo'];


//$busqueda = 'a';


//$arBusqueda = explode(" ", $busqueda);

//$cantidad = count($arBusqueda);

$ar = array();

if ($busqueda != '') {

	$resTraerClientes = $serviciosReferencias->bAsociados($busqueda,$tipo);

	$cad = '';
	while ($row = mysql_fetch_array($resTraerClientes)) {

		array_push($ar,array('id'=>$row['idasociado'], 'nombrecompleto'=> $row['nombrecompleto']));
	}

}
//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo json_encode($ar);
}
?>
