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
$tipopersona = $_POST['tipopersona'];

//$busqueda = 'a';


//$arBusqueda = explode(" ", $busqueda);

//$cantidad = count($arBusqueda);

$ar = array();

if ($busqueda != '') {

	if ($asesor == 0) {
		$resTraerClientes = $serviciosReferencias->bClientes($busqueda,$tipopersona);
	} else {
		$resTraerClientes = $serviciosReferencias->bClientesasesoresPorAsesor($busqueda,$tipopersona,$asesor);
	}



	$cad = '';
	if ($tipopersona == 1) {
		while ($row = mysql_fetch_array($resTraerClientes)) {

			array_push($ar,array('id'=>$row['idcliente'], 'nombrecompleto'=> $row['nombrecompleto'], 'idclienteinbursa'=>$row['idclienteinbursa'], 'reftipopersonas' => $row['reftipopersonas']));
		}
	} else {
		if ($tipopersona == 2) {
			while ($row = mysql_fetch_array($resTraerClientes)) {

				array_push($ar,array('id'=>$row['idcliente'], 'nombrecompleto'=> $row['razonsocial'], 'idclienteinbursa'=>$row['idclienteinbursa'], 'reftipopersonas' => $row['reftipopersonas']));
			}
		} else {
			while ($row = mysql_fetch_array($resTraerClientes)) {

				array_push($ar,array('id'=>$row['idcliente'], 'nombrecompleto'=> 'Nombre Completo: '.$row['nombrecompleto'].' - Razon social: '.$row['razonsocial'], 'idclienteinbursa'=>$row['idclienteinbursa'], 'reftipopersonas' => $row['reftipopersonas']));
			}
		}

	}


}
//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo json_encode($ar);
}
?>
