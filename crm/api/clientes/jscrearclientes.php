<?php



include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/clientes.class.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$cliente = new clienteCrea();

$fecha = date('Y-m-d');

$token = $_GET['callback'];

header("content-type: Access-Control-Allow-Origin: *");

if ((isset($_GET['reftipopersonas']))) {
	$reftipopersonas = $_GET['reftipopersonas'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el tipo de persona \n'));
}

if ((isset($_GET['nombre']))) {
	$nombre = $_GET['nombre'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el nombre \n'));
}

if ((isset($_GET['apellidopaterno']))) {
	$apellidopaterno = $_GET['apellidopaterno'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el apellido paterno \n'));
}

if ((isset($_GET['apellidomaterno']))) {
	$apellidomaterno = $_GET['apellidomaterno'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el apellido materno \n'));
}

if ((isset($_GET['razonsocial']))) {
	$razonsocial = $_GET['razonsocial'];
} else {
	$razonsocial = '';
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
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un email valido \n'));
}

if ((isset($_GET['rfc']))) {
	$rfc = $_GET['rfc'];
} else {
	$rfc = '';
}


if (isset($_GET['idclienteinbursa'])) {
	$idclienteinbursa = ( $_GET['idclienteinbursa'] == '' ? '' : $_GET['idclienteinbursa']);
} else {
	$idclienteinbursa = '';
}


if ((isset($_GET['curp']))) {
	$curp = $_GET['curp'];
} else {
	$curp = '';
}

if ((isset($_GET['genero']))) {
	$genero = $_GET['genero'];
} else {
	$genero = '';
}

if ((isset($_GET['refestadocivil']))) {
	$refestadocivil = $_GET['refestadocivil'];
} else {
	$refestadocivil = '';
}

if ((isset($_GET['reftipoidentificacion']))) {
	$reftipoidentificacion = $_GET['reftipoidentificacion'];
} else {
	$reftipoidentificacion = '';
}

if ((isset($_GET['nroidentificacion']))) {
	$nroidentificacion = $_GET['nroidentificacion'];
} else {
	$nroidentificacion = '';
}


/************** fijo por ahora ***********/
$ine = '';
$refusuarios = 0;
$fechacrea = date('Y-m-d H:i:s');
$fechamodi = date('Y-m-d H:i:s');
$usuariocrea = 'financieracrea@financieracrea.com';
$usuariomodi = 'financieracrea@financieracrea.com';
$emisioncomprobantedomicilio = '';
$emisionrfc 				= '';
$vencimientoine 			= '';
/*****************************************/

/*************** domicilio *********************************/
if ((isset($_GET['domicilio']))) {
	$domicilio = $_GET['domicilio'];
} else {
	$domicilio = '';
}

if ((isset($_GET['colonia']))) {
	$colonia = $_GET['colonia'];
} else {
	$colonia = '';
}

if ((isset($_GET['municipio']))) {
	$municipio = $_GET['municipio'];
} else {
	$municipio = '';
}

if ((isset($_GET['codigopostal']))) {
	$codigopostal = $_GET['codigopostal'];
} else {
	$codigopostal = '';
}

if ((isset($_GET['edificio']))) {
	$edificio = $_GET['edificio'];
} else {
	$edificio = '';
}

if ((isset($_GET['nroexterior']))) {
	$nroexterior = $_GET['nroexterior'];
} else {
	$nroexterior = '';
}

if ((isset($_GET['nrointerior']))) {
	$nrointerior = $_GET['nrointerior'];
} else {
	$nrointerior = '';
}

if ((isset($_GET['estado']))) {
	$estado = $_GET['estado'];
} else {
	$estado = '';
}

if ((isset($_GET['ciudad']))) {
	$ciudad = $_GET['ciudad'];
} else {
	$ciudad = '';
}

/*************** fin domicilio *********************************/


/************ para el suaurio ***************************/
$existeEmail = $serviciosUsuarios->existeUsuario($email);

if ($existeEmail == 1) {
	array_push($resV['errores'],array('Mensaje'=>'El email ya existe en la base de datos \n'));

} else {

	//inserto el usuario

	if ((isset($_GET['usuario']))) {
		$usuario = $_GET['usuario'];
	} else {
		array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un usuario \n'));
	}

	$cliente->usuario->guardar($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios,$validaemail,$validamovil,$validasignatura,$usuarioexterno);



	/************* fin usuario ******************************/

	$existeCurp = $cliente->buscarClientePorValor('curp',$curp);

	if ($existeCurp != null) {
		array_push($resV['errores'],array('Mensaje'=>'El cliente ya existe en la base de datos \n'));
	} else {
		$res = $cliente->guardar($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$refusuarios,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento);

		if ($cliente->getIdcliente() == null) {
			array_push($resV['errores'],array('Mensaje'=> $res.' \n'));

		} else {

			$resV['estatus'] = 'ok';

			array_push($resV['cliente'],array(
				'id'=>$row['idcliente'],
				'nombrecompleto'=> $row['nombrecompleto'],
				'idclienteinbursa'=>$row['idclienteinbursa'],
				'reftipopersonas' => $row['reftipopersonas']
				)
			);
		}
	}



}

if (isset($resV['error'])) {
	$resV['estatus'] = 'error';
}

//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
//echo $token.'('.json_encode($ar).');';

header('Content-type: application/json');
echo json_encode($resV);


?>
