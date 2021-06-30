<?php

include ('includes/clientes.class.php');
include ('includes/validadores.php');

$cliente = new clienteCrea();
$validador = new serviciosValidador();

$reftipopersonas = 1;
$nombre = 'marcos';
$apellidopaterno = 'marcos';
$apellidomaterno = 'marcos';
$razonsocial = '';
$domicilio = 'marcos';
$telefonofijo = 'marcos';
$telefonocelular = 'marcos';
$email = 'marcos@marcos.com';
$rfc = 'marcos';
$ine = 'marcos';
$refusuarios = 0;
$usuariocrea = 'admin@admin.com';
$usuariomodi = 'admin@admin.com';
$emisioncomprobantedomicilio = '';
$emisionrfc = '';
$vencimientoine ='';
$idclienteinbursa = '';
$colonia = '';
$municipio = '';
$codigopostal = '';
$edificio = '';
$nroexterior = '';
$nrointerior = '';
$estado = '';
$ciudad = '';
$curp = '';
$genero = 'Masculino';
$refestadocivil = 7;
$reftipoidentificacion = 0;
$nroidentificacion = '';
$fechanacimiento = '1985-05-20';

//$cliente->guardar($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$refusuarios,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento);

//$cliente->usuario->buscarUsuarioPorId(1);

//echo $cliente->usuario->getNombrecompleto();


   $cliente->buscarClientePorValor('idcliente',28);

   echo '<pre>';
   echo $cliente->getApellidopaterno().'<br>';
   echo $cliente->usuario->getNombrecompleto();
   echo '</pre>';



?>
