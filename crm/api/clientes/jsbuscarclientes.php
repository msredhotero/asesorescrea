<?php



include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

if ((isset($_GET['tipopersona']))) {
	$tipopersona = $_POST['tipopersona'];
} else {
	$tipopersona = 1;
}

if ((isset($_GET['idasesor']))) {
	$asesor = $_POST['idasesor'];
} else {
	$asesor = 0;
}


$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

if ((isset($_GET['busqueda'])) && ($_GET['busqueda'] != '')) {
	$busqueda = trim($_GET['busqueda']);

	if ($asesor == 0) {
		$resTraerClientes = $serviciosReferencias->bClientes($busqueda,$tipopersona);
	} else {
		$resTraerClientes = $serviciosReferencias->bClientesasesoresPorAsesor($busqueda,$tipopersona,$asesor);
	}

} else {
	$resTraerClientes = $serviciosReferencias->bClientes('*****',0);
}

	$cad = '';
	if ($tipopersona == 1) {
		while ($row = mysql_fetch_array($resTraerClientes)) {

			array_push($ar,array(
				'id'=>$row['idcliente'],
				'nombrecompleto'=> $row['nombrecompleto'],
				'idclienteinbursa'=>$row['idclienteinbursa'],
				'reftipopersonas' => $row['reftipopersonas']
				)
			);
		}
	} else {
		while ($row = mysql_fetch_array($resTraerClientes)) {

			array_push($ar,array(
				'id'=>$row['idcliente'],
				'nombrecompleto'=> $row['razonsocial'],
				'idclienteinbursa'=>$row['idclienteinbursa'],
				'reftipopersonas' => $row['reftipopersonas']
				)
			);
		}
	}



//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo $token.'('.json_encode($ar).');';


?>
