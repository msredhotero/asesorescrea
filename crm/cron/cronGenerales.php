<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesNotificaciones.php');
include ('../includes/funcionesMensajes.php');
include ('../includes/validadores.php');

$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosMensajes	= new ServiciosMensajes();
$serviciosValidador        = new serviciosValidador();

$res1 = $serviciosReferencias->cronNotificarPoliza();
$res2 = $serviciosReferencias->cronNotificarPolizaRuth();
$res3 = $serviciosReferencias->cronNotificarSeguro();

$res4 = $serviciosReferencias->cronModificarEstadoOportunidades();

$resI = $serviciosReferencias->insertarCron('Notificaciones Generales',date('Y-m-d H:i:s'));


?>
