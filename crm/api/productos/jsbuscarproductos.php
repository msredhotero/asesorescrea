<?php


include ('../../includes/funciones.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['ventaenlinea'])) && ($_GET['ventaenlinea'] == '1')) {
	$resProductos = $serviciosReferencias->traerProductosVentaEnLinea(0);
} else {
	if ((isset($_GET['cotizaenlinea'])) && ($_GET['cotizaenlinea'] == '1')) {
		$resProductos = $serviciosReferencias->traerProductosCotizaEnLinea();
	} else {
		if ((isset($_GET['nombre'])) && ($_GET['nombre'] != '')) {
			//die(var_dump($_GET['nombre']));
			$resProductos = $serviciosReferencias->traerProductosPorNombreCompleta($_GET['nombre']);
		} else {
			if ((isset($_GET['id'])) && ($_GET['id'] != '') && ($_GET['id'] > 0)) {
				$resProductos = $serviciosReferencias->traerProductosPorIdCompleta($_GET['id']);
			} else {
				$resProductos = $serviciosReferencias->traerProductosPorIdCompleta(0);
			}
		}
	}
}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resProductos)) {

		array_push($ar,array(
			'producto'=>$row['producto'],
			'precio'=>$row['precio'],
			'detalle'=>$row['detalle'],
			'id'=> $row[0]
			)
		);
	}


//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>
