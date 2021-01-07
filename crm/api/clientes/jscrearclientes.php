<?php



include ('../includes/funciones.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();

$fecha = date('Y-m-d');

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

$ar = array();
$arErrores = array();

if ((isset($_GET['reftipopersonas']))) {
	$reftipopersonas = $_GET['reftipopersonas'];
} else {
	array_push($arErrores,array('Mensaje'=>'Debe ingresar el tipo de persona'));
}

if ((isset($_GET['nombre']))) {
	$nombre = $_GET['nombre'];
} else {
	array_push($arErrores,array('Mensaje'=>'Debe ingresar el nombre'));
}

if ((isset($_GET['apellidopaterno']))) {
	$apellidopaterno = $_GET['apellidopaterno'];
} else {
	array_push($arErrores,array('Mensaje'=>'Debe ingresar el apellido paterno'));
}

if ((isset($_GET['apellidomaterno']))) {
	$apellidomaterno = $_GET['apellidomaterno'];
} else {
	array_push($arErrores,array('Mensaje'=>'Debe ingresar el apellido materno'));
}

if ((isset($_GET['razonsocial']))) {
	$razonsocial = $_GET['razonsocial'];
} else {
	$razonsocial = '';
}

if ((isset($_GET['domicilio']))) {
	$domicilio = $_GET['domicilio'];
} else {
	$domicilio = '';
}

if ((isset($_GET['telefonofijo']))) {
	$telefonofijo = $_GET['telefonofijo'];
} else {
	$telefonofijo = '';
}

if ((isset($_GET['telefonocelular']))) {
	$telefonocelular = $_GET['telefonocelular'];
} else {
	$telefonocelular = '';
}

if ((isset($_GET['telefonocelular']))) {
	$telefonocelular = $_GET['telefonocelular'];
} else {
	$telefonocelular = '';
}

if ((isset($_GET['email'])) && ($_GET['email'] != '') && (filter_var($email, FILTER_VALIDATE_EMAIL))) {
	$email = $_GET['email'];
} else {
	array_push($arErrores,array('Mensaje'=>'Debe ingresar un email valido'));
}

if ((isset($_GET['rfc']))) {
	$rfc = $_GET['rfc'];
} else {
	$rfc = '';
}

if ((isset($_GET['ine']))) {
	$ine = $_GET['ine'];
} else {
	$ine = '';
}


$numerocliente = $serviciosReferencias->generaNroCliente();
$refusuarios = 0;
$fechacrea = date('Y-m-d H:i:s');
$fechamodi = date('Y-m-d H:i:s');
$usuariocrea = $_SESSION['usua_sahilices'];
$usuariomodi = $_SESSION['usua_sahilices'];

$idclienteinbursa = ( $_GET['idclienteinbursa'] == '' ? '' : $_GET['idclienteinbursa']);

$emisioncomprobantedomicilio = $_GET['emisioncomprobantedomicilio'];
$emisionrfc = $_GET['emisionrfc'];
$vencimientoine = $_GET['vencimientoine'];

$colonia = $_GET['colonia'];
$municipio = $_GET['municipio'];
$codigopostal = $_GET['codigopostal'];
$edificio = $_GET['edificio'];
$nroexterior = $_GET['nroexterior'];
$nrointerior = $_GET['nrointerior'];

$estado = $_GET['estado'];
$ciudad = $_GET['ciudad'];
$curp = $_GET['curp'];

$genero = $_GET['genero'];
$refestadocivil = $_GET['refestadocivil'];

$reftipoidentificacion = $_GET['reftipoidentificacion'];
$nroidentificacion = $_GET['nroidentificacion'];

$existe = $serviciosReferencias->existeClienteAPYN($nombre,$apellidopaterno,$apellidomaterno);

if (($existe == 1) && ($reftipopersonas == 1)) {
	echo 'El cliente ya existe en la base de datos';
} else {
	$res = $serviciosReferencias->insertarClientes($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion);

	if ((integer)$res > 0) {
		if ($_SESSION['idroll_sahilices'] == 7) {
			$resAsesores = $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);

			$resClienteAsedor = $serviciosReferencias->insertarClientesasesores($res,mysql_result($resAsesores,0,0),$apellidopaterno,$apellidomaterno,$nombre,$razonsocial,$domicilio,$email,$rfc,$ine,$reftipopersonas,$telefonofijo,$telefonocelular,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion);
		}
		echo '';
	} else {
		echo 'Hubo un error al insertar datos';
	}
}

		array_push($ar,array(
			'id'=>$row['idcliente'],
			'nombrecompleto'=> $row['nombrecompleto'],
			'idclienteinbursa'=>$row['idclienteinbursa'],
			'reftipopersonas' => $row['reftipopersonas']
			)
		);





//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
echo $token.'('.json_encode($ar).');';


?>
