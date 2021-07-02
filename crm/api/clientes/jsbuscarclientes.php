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

if ((isset($_GET['idcliente']))) {
	$idcliente = $_GET['idcliente'];
} else {
	$idcliente = '';
}

if ((isset($_GET['idusuario']))) {
	$idusuario = $_GET['idusuario'];
} else {
	$idusuario = '';
}

if ((isset($_GET['curp']))) {
	$curp = $_GET['curp'];
} else {
	$curp = '';
}

if ((isset($_GET['rfc']))) {
	$rfc = $_GET['rfc'];
} else {
	$rfc = '';
}

//https://financieracrea.com
header("content-type: Access-Control-Allow-Origin: *");

$resV['errores'] = array();

//die(var_dump($idcliente));

if (($idcliente != '') || ($idusuario != '') || ($curp != '') || ($rfc != '')) {
	if ($idcliente != '') {
		$cliente->buscarClientePorValor('idcliente',$idcliente);

	} else {
		if ($idusuario != '') {
			if ($idusuario != 0) {
				$cliente->buscarClientePorValor('refusuarios',$idusuario);
			} else {
				$resV['estatus'] = 'error';
				array_push($resV['errores'],array('Mensaje'=> 'Dato invalido '));
			}
		} else {
			if ($curp != '') {
				$cliente->buscarClientePorCurp($curp);
			} else {
				$cliente->buscarClientePorRfc($curp);
			}
		}
	}

	if (count($resV['errores'])<= 0) {
		if ($cliente->getIdcliente() == null) {
			$resV['estatus'] = 'error';
			array_push($resV['errores'],array('Mensaje'=> 'Dato invalido '));
		} else {
			$resV['estatus'] = 'ok';
			$resV['cliente'] = array(
				'idcliente' => $cliente->getIdcliente(),
				'refusuarios' => $cliente->getRefusuarios(),
				'curp' => $cliente->getCurp(),
				'rfc' => $cliente->getRfc(),
				'apellidopaterno' => $cliente->getApellidopaterno(),
				'apellidomaterno' => $cliente->getApellidomaterno(),
				'nombre' => $cliente->getNombre(),
			);
		}
	}

} else {
	$resV['estatus'] = 'error';
	array_push($resV['errores'],array('Mensaje'=> 'Debe enviar algun parametro (idcliente, idusuario, rfc o curp) para hacer la busqueda '));
}




header('Content-type: application/json');
echo json_encode($resV);


?>
