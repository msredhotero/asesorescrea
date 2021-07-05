<?php



include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/clientes.class.php');

$serviciosFunciones = new Servicios();
$serviciosUsuarios 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$cliente = new clienteCrea();

$fecha = date('Y-m-d');

$token = $_GET['callback'];

$resV['errores'] = array();

header("content-type: Access-Control-Allow-Origin: *");

if ((isset($_GET['reftipopersonas']))) {
	$reftipopersonas = $_GET['reftipopersonas'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el tipo de persona '));
}

if ((isset($_GET['nombre']))) {
	$nombre = $_GET['nombre'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el nombre '));
}

if ((isset($_GET['apellidopaterno']))) {
	$apellidopaterno = $_GET['apellidopaterno'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el apellido paterno '));
}

if ((isset($_GET['apellidomaterno']))) {
	$apellidomaterno = $_GET['apellidomaterno'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar el apellido materno '));
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


if ((isset($_GET['email'])) && ($_GET['email'] != '')) {
	if ((filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) === false)) {
		array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un email valido '));
	} else {
		$email = $_GET['email'];
	}

} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un email valido '));
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

if ((isset($_GET['fechanacimiento']))) {
	$fechanacimiento = $_GET['fechanacimiento'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar una Fecha de Nacimiento '));
}


if ((isset($_GET['curp']))) {
	$curp = $_GET['curp'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un curp '));
}

if ((isset($_GET['genero']))) {
	$genero = $_GET['genero'];
} else {
	$genero = '';
}

if ((isset($_GET['refestadocivil']))) {
	$refestadocivil = $_GET['refestadocivil'];
} else {
	$refestadocivil = '7';
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


/************ para el usuario ***************************/
if ((isset($_GET['usuario']))) {
	$usuario = $_GET['usuario'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un usuario '));
}

if ((isset($_GET['password']))) {
	$password = $_GET['password'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un password '));
}

if ((isset($_GET['nombrecompleto']))) {
	$nombrecompleto = $_GET['nombrecompleto'];
} else {
	array_push($resV['errores'],array('Mensaje'=>'Debe ingresar un nombre de usuario '));
}
/*********** fin usuario **************************************/

if (count($resV['errores'])<=0) {

	$existeEmail = $serviciosUsuarios->existeUsuario($email);

	if ($existeEmail == 1) {
		array_push($resV['errores'],array('Mensaje'=>'El email ya existe en la base de datos '));

	} else {

		$existeCurp = $cliente->buscarClientePorValor('curp',$curp);

		if ($existeCurp != null) {
			array_push($resV['errores'],array('Mensaje'=>'El cliente ya existe en la base de datos '));
		} else {

			//datos del usuario
			$refroles = 16;
			$activo = '1';
			$refsocios = 0;
			$validaemail = '1';
			$validamovil = '1';
			$validasignatura = '1';
			$usuarioexterno = '1';

			//inserto el usuario
			$cliente->usuario->guardar($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios,$validaemail,$validamovil,$validasignatura,$usuarioexterno);

			$refusuarios = $cliente->usuario->getIdusuario();
			/************* fin usuario ******************************/


			$res = $cliente->guardar($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$refusuarios,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento);

			if ($cliente->getIdcliente() == null) {
				array_push($resV['errores'],array('Mensaje'=> $res.' '));

			} else {

				$resV['estatus'] = 'ok';
				$resV['idusuario'] = $cliente->usuario->getIdusuario();
				$resV['idcliente'] = $cliente->getIdcliente();
			}
		}



	}
}

if (count($resV['errores'])>0) {
	$resV['estatus'] = 'error';
}

//echo "[".substr($cad,0,-1)."]";
//echo "[".json_encode($ar)."]";
//echo $token.'('.json_encode($ar).');';

header('Content-type: application/json');
echo json_encode($resV);


?>
