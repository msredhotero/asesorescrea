<?php


include ('../../includes/funciones.php');
include ('../../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();

if ((isset($_GET['apellidopaterno'])) || (isset($_GET['apellidomaterno'])) || (isset($_GET['nombre']))) {
	$resAsesores = $serviciosReferencias->bAsesores($_GET['apellidopaterno'].' '.$_GET['apellidomaterno'].' '.$_GET['nombre']);
} else {
	if ((isset($_GET['clave']))) {
		$resAsesores = $serviciosReferencias->bAsesoresPorClave($_GET['clave']);
	} else {
		$resAsesores = $serviciosReferencias->traerAsesoresPorId(0);
	}

}

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();

$cad = '';
	while ($row = mysql_fetch_array($resAsesores)) {

		array_push($ar,array(
			'apellidopaterno'=>$row['apellidopaterno'],
			'apellidomaterno'=>$row['apellidomaterno'],
			'nombre'=>$row['nombre'],
			'razonsocial'=>$row['razonsocial'],
			'sexo'=>$row['sexo'],
			'email'=>$row['email'],
			'curp'=>$row['curp'],
			'fechanacimiento'=>$row['fechanacimiento'],
			'activoasesorescrea'=>$row['activoasesorescrea'],
			'activoinbursa'=>$row['activoinbursa'],
			'telefonomovil'=>$row['telefonomovil'],
			'telefonotrabajo'=>$row['telefonotrabajo'],
			'id'=> $row[0]
			)
		);
	}


//echo "[".substr($cad,0,-1)."]";
echo $token.'('.json_encode($ar).');';

?>
