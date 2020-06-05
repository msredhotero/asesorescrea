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
$asesor = $_POST['idasesor'];


//$busqueda = 'a';


//$arBusqueda = explode(" ", $busqueda);

//$cantidad = count($arBusqueda);

$ar = array();

if ($busqueda != '') {

	if ($asesor == 0) {
		$resTraerClientes = $serviciosReferencias->bAsesores($busqueda);
	} else {
		$resTraerClientes = $serviciosReferencias->traerAsesoresPorIdCompleto($idasesor);
	}



	$cad = '';
	while ($row = mysql_fetch_array($resTraerClientes)) {

		array_push($ar,array('id'=>$row['idasesor'], 'nombrecompleto'=> $row['nombrecompleto']));
	}

}
//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo json_encode($ar);
}
?>
