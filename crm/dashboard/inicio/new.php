<?php


session_start();

if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../../error.php');
} else {


   include ('../../includes/funciones.php');
   include ('../../includes/funcionesUsuarios.php');
   include ('../../includes/funcionesHTML.php');
   include ('../../includes/funcionesReferencias.php');
   include ('../../includes/base.php');

   $serviciosFunciones 	= new Servicios();
   $serviciosUsuario 		= new ServiciosUsuarios();
   $serviciosHTML 			= new ServiciosHTML();
   $serviciosReferencias 	= new ServiciosReferencias();
   $baseHTML = new BaseHTML();

   //*** SEGURIDAD ****/
   include ('../../includes/funcionesSeguridad.php');
   $serviciosSeguridad = new ServiciosSeguridad();
   //$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../inicio/');

   $token = $_SESSION['token_ac'];


   if (!(isset($token))) {
   	//header('Location: index.php');
   }

   $tokenNuevo = $serviciosReferencias->GUID();

   $resultadoToken = $serviciosReferencias->copiaTokenDeToken($token,$tokenNuevo);

   $_SESSION['token_ac'] = $tokenNuevo;
   //$token = $tokenNuevo;

   //die(var_dump($resultadoToken));

   header('Location: ../cotizacionagente/new.php?producto=46');


}

?>
