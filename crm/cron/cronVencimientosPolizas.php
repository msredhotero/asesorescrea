<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesNotificaciones.php');
include ('../includes/funcionesMensajes.php');
include ('../includes/validadores.php');
include ('../includes/funcionesAlertas.php');

$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosMensajes	= new ServiciosMensajes();
$serviciosValidador        = new serviciosValidador();
$serviciosAlertas	= new ServiciosAlertas();

define("MAILQUEUE_BATCH_SIZE",0);

$res30 = $serviciosAlertas->alertaVencimiento30dias(30,2);
$res20 = $serviciosAlertas->alertaVencimiento30dias(20,3);
$res10 = $serviciosAlertas->alertaVencimiento30dias(10,4);
$res2 = $serviciosAlertas->alertaVencimiento30dias(2,5);
$res0 = $serviciosAlertas->alertaVencimiento30dias(0,6);

$resA = $serviciosAlertas->alertaVencimientoDiasDespues(-2,7);
$resB = $serviciosAlertas->alertaVencimientoDiasDespues(-10,8);
$resD = $serviciosAlertas->alertaVencimientoMarcarTabla(-11,9);


$resC = $serviciosAlertas->alertaVencimientoMarcarTabla(0,10);

$resI = $serviciosReferencias->insertarCron('Vencimientos Polizas y Recibos',date('Y-m-d H:i:s'));

$email = $serviciosReferencias->enviarEmail('msredhotero@gmail.com','CRON: 2','Vencimientos Polizas y Recibos');

?>
