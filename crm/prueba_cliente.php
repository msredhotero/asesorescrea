<?php

include ('includes/clientes.class.php');
include ('includes/validadores.php');
/*
$cliente = new clienteCrea();*/
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

/*
   $cliente->buscarClientePorValor('curp','BADD110313HCMLNS0');

   echo '<pre>';
   echo $cliente->getApellidopaterno().'<br>';
   echo $cliente->usuario->getNombrecompleto();
   echo '</pre>';
*/
$user_input = '123456';
//echo hash('sha256', $user_input,false);
$pass = urlencode($user_input);
$pass_crypt = '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92';
//if (sha256($str) === '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92') {
if ('8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92' === hash('sha256', $user_input,false)) {
 echo 'es';
} else {
   echo 'no es';
}


?>
