<?php

include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesUsuarios.php');
include ('../includes/usuarios.class.php');

$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosReferencias 	= new ServiciosReferencias();
$usuario = new usuarioCrea();

$resV['errores'] = array();

if ((isset($_GET['idusuario']))) {
	$idusuario = $_GET['idusuario'];
} else {
	array_push($resV['errores'],array('Mensaje'=> 'Se necesita el id del usuario '));
}

if ((isset($_GET['tipourl']))) {
	$tipourl = $_GET['tipourl'];
} else {
	array_push($resV['errores'],array('Mensaje'=> 'Debe ingresar el tipo de url '));
}


if (count($resV['errores'])<= 0) {

   $usuario->buscarUsuarioPorId($idusuario);

   if ($usuario->getIdusuario() == null) {
      array_push($resV['errores'],array('Mensaje'=> 'Usuario Incorrecto '));
      $resV['estatus'] = 'error';
   } else {
      switch ($tipourl) {
         case 1:
            $url = 'https://asesorescrea.com/desarrollo/crm/dashboard/venta/vrim.php';
            $urlcorto = 'venta/vrim.php';
         break;
         case 2:
            $url = 'https://asesorescrea.com/desarrollo/crm/dashboard/venta/vida500.php';
            $urlcorto = 'venta/vida500.php';
         break;
         case 3:
            $url = 'https://asesorescrea.com/desarrollo/crm/dashboard/mejorarcondiciones/';
            $urlcorto = 'mejorarcondiciones/index.php';
         break;
      }

      $token = $serviciosReferencias->generarNIP();
      $fechacreac = date('Y-m-d H:i:s');
      $nuevafecha = strtotime ( '+15 hour' , strtotime ( $fechacreac ) ) ;
      $refestadotoken = 1;
      $vigenciafin = $nuevafecha;

      $res = $serviciosReferencias->insertarTokens(0,3,$token,$fechacreac,$refestadotoken,$vigenciafin);

      $tokenL = $serviciosReferencias->GUID();
      $resAutoLogin = $serviciosReferencias->insertarAutologin($idusuario,$tokenL,$urlcorto,'0');

      $resV['acceso'] = 'https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$tokenL;
      $resV['estatus'] = 'ok';
   }

} else {
   $resV['estatus'] = 'error';
}


header('Content-type: application/json');
echo json_encode($resV);

?>
