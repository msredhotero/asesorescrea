<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesNotificaciones.php');
include ('../includes/validadores.php');

$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosValidador        = new serviciosValidador();


$accion = $_POST['accion'];

$resV['error'] = '';
$resV['mensaje'] = '';



switch ($accion) {
    case 'login':
        enviarMail($serviciosUsuarios);
        break;
	case 'entrar':
		entrar($serviciosUsuarios);
		break;
	case 'insertarUsuario':
        insertarUsuario($serviciosUsuarios);
        break;
	case 'modificarUsuario':
        modificarUsuario($serviciosUsuarios);
        break;
	case 'registrar':
		registrar($serviciosUsuarios);
		break;
   case 'registrarme':
      registrarme($serviciosUsuarios, $serviciosReferencias, $serviciosValidador);
   break;
   case 'insertarUsuarios':
        insertarUsuarios($serviciosReferencias);
   break;
   case 'recuperar':
      recuperar($serviciosUsuarios);
   break;

   case 'eliminarUsuarios':
      eliminarUsuarios($serviciosUsuarios, $serviciosReferencias);
   break;

   case 'activarUsuario':
      activarUsuario($serviciosUsuarios, $serviciosReferencias);
   break;
   case 'activarUsuarioPostulante':
      activarUsuarioPostulante($serviciosUsuarios, $serviciosReferencias);
   break;


   case 'frmAjaxModificar':
      frmAjaxModificar($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios);
   break;
   case 'frmAjaxVer':
      frmAjaxVer($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios);
   break;



   case 'traerUsuarios':
      traerUsuarios($serviciosReferencias);
   break;
   case 'traerUsuariosPorId':
      traerUsuariosPorId($serviciosReferencias);
   break;
   case 'insertarAsesores':
   insertarAsesores($serviciosReferencias);
   break;
   case 'modificarAsesores':
   modificarAsesores($serviciosReferencias);
   break;
   case 'eliminarAsesores':
   eliminarAsesores($serviciosReferencias);
   break;
   case 'traerAsesores':
   traerAsesores($serviciosReferencias);
   break;
   case 'traerAsesoresPorId':
   traerAsesoresPorId($serviciosReferencias);
   break;
   case 'insertarClientes':
   insertarClientes($serviciosReferencias);
   break;
   case 'modificarClientes':
   modificarClientes($serviciosReferencias);
   break;
   case 'eliminarClientes':
   eliminarClientes($serviciosReferencias);
   break;
   case 'traerClientes':
   traerClientes($serviciosReferencias);
   break;
   case 'traerClientesPorId':
   traerClientesPorId($serviciosReferencias);
   break;
   case 'insertarDocumentacionasesores':
   insertarDocumentacionasesores($serviciosReferencias);
   break;
   case 'modificarDocumentacionasesores':
   modificarDocumentacionasesores($serviciosReferencias);
   break;
   case 'eliminarDocumentacionasesores':
   eliminarDocumentacionasesores($serviciosReferencias);
   break;
   case 'traerDocumentacionasesores':
   traerDocumentacionasesores($serviciosReferencias);
   break;
   case 'traerDocumentacionasesoresPorId':
   traerDocumentacionasesoresPorId($serviciosReferencias);
   break;
   case 'insertarDocumentaciones':
   insertarDocumentaciones($serviciosReferencias);
   break;
   case 'modificarDocumentaciones':
   modificarDocumentaciones($serviciosReferencias);
   break;
   case 'eliminarDocumentaciones':
   eliminarDocumentaciones($serviciosReferencias);
   break;
   case 'traerDocumentaciones':
   traerDocumentaciones($serviciosReferencias);
   break;
   case 'traerDocumentacionesPorId':
   traerDocumentacionesPorId($serviciosReferencias);
   break;
   case 'insertarDocumentacionsolicitudes':
   insertarDocumentacionsolicitudes($serviciosReferencias);
   break;
   case 'modificarDocumentacionsolicitudes':
   modificarDocumentacionsolicitudes($serviciosReferencias);
   break;
   case 'eliminarDocumentacionsolicitudes':
   eliminarDocumentacionsolicitudes($serviciosReferencias);
   break;
   case 'traerDocumentacionsolicitudes':
   traerDocumentacionsolicitudes($serviciosReferencias);
   break;
   case 'traerDocumentacionsolicitudesPorId':
   traerDocumentacionsolicitudesPorId($serviciosReferencias);
   break;
   case 'insertarEntrevistas':
   insertarEntrevistas($serviciosReferencias);
   break;
   case 'modificarEntrevistas':
   modificarEntrevistas($serviciosReferencias);
   break;
   case 'eliminarEntrevistas':
   eliminarEntrevistas($serviciosReferencias);
   break;
   case 'traerEntrevistas':
   traerEntrevistas($serviciosReferencias);
   break;
   case 'traerEntrevistasPorId':
   traerEntrevistasPorId($serviciosReferencias);
   break;
   case 'insertarPostulantes':
   insertarPostulantes($serviciosReferencias,$serviciosUsuarios);
   break;
   case 'modificarPostulantes':
   modificarPostulantes($serviciosReferencias);
   break;
   case 'eliminarPostulantes':
   eliminarPostulantes($serviciosReferencias);
   break;
   case 'traerPostulantes':
   traerPostulantes($serviciosReferencias);
   break;
   case 'traerPostulantesPorId':
   traerPostulantesPorId($serviciosReferencias);
   break;
   case 'insertarPromotores':
   insertarPromotores($serviciosReferencias);
   break;
   case 'modificarPromotores':
   modificarPromotores($serviciosReferencias);
   break;
   case 'eliminarPromotores':
   eliminarPromotores($serviciosReferencias);
   break;
   case 'traerPromotores':
   traerPromotores($serviciosReferencias);
   break;
   case 'traerPromotoresPorId':
   traerPromotoresPorId($serviciosReferencias);
   break;
   case 'insertarSolicituddetallecreditohipotecario':
   insertarSolicituddetallecreditohipotecario($serviciosReferencias);
   break;
   case 'modificarSolicituddetallecreditohipotecario':
   modificarSolicituddetallecreditohipotecario($serviciosReferencias);
   break;
   case 'eliminarSolicituddetallecreditohipotecario':
   eliminarSolicituddetallecreditohipotecario($serviciosReferencias);
   break;
   case 'traerSolicituddetallecreditohipotecario':
   traerSolicituddetallecreditohipotecario($serviciosReferencias);
   break;
   case 'traerSolicituddetallecreditohipotecarioPorId':
   traerSolicituddetallecreditohipotecarioPorId($serviciosReferencias);
   break;
   case 'insertarSolicituddetalleseguros':
   insertarSolicituddetalleseguros($serviciosReferencias);
   break;
   case 'modificarSolicituddetalleseguros':
   modificarSolicituddetalleseguros($serviciosReferencias);
   break;
   case 'eliminarSolicituddetalleseguros':
   eliminarSolicituddetalleseguros($serviciosReferencias);
   break;
   case 'traerSolicituddetalleseguros':
   traerSolicituddetalleseguros($serviciosReferencias);
   break;
   case 'traerSolicituddetallesegurosPorId':
   traerSolicituddetallesegurosPorId($serviciosReferencias);
   break;
   case 'insertarSolicituddetalletelmex':
   insertarSolicituddetalletelmex($serviciosReferencias);
   break;
   case 'modificarSolicituddetalletelmex':
   modificarSolicituddetalletelmex($serviciosReferencias);
   break;
   case 'eliminarSolicituddetalletelmex':
   eliminarSolicituddetalletelmex($serviciosReferencias);
   break;
   case 'traerSolicituddetalletelmex':
   traerSolicituddetalletelmex($serviciosReferencias);
   break;
   case 'traerSolicituddetalletelmexPorId':
   traerSolicituddetalletelmexPorId($serviciosReferencias);
   break;
   case 'insertarSolicitudes':
   insertarSolicitudes($serviciosReferencias);
   break;
   case 'modificarSolicitudes':
   modificarSolicitudes($serviciosReferencias);
   break;
   case 'eliminarSolicitudes':
   eliminarSolicitudes($serviciosReferencias);
   break;
   case 'traerSolicitudes':
   traerSolicitudes($serviciosReferencias);
   break;
   case 'traerSolicitudesPorId':
   traerSolicitudesPorId($serviciosReferencias);
   break;
   case 'insertarSucursales':
   insertarSucursales($serviciosReferencias);
   break;
   case 'modificarSucursales':
   modificarSucursales($serviciosReferencias);
   break;
   case 'eliminarSucursales':
   eliminarSucursales($serviciosReferencias);
   break;
   case 'traerSucursales':
   traerSucursales($serviciosReferencias);
   break;
   case 'traerSucursalesPorId':
   traerSucursalesPorId($serviciosReferencias);
   break;

   case 'insertarPostal':
   insertarPostal($serviciosReferencias);
   break;
   case 'modificarPostal':
   modificarPostal($serviciosReferencias);
   break;
   case 'eliminarPostal':
   eliminarPostal($serviciosReferencias);
   break;
   case 'traerPostal':
   traerPostal($serviciosReferencias);
   break;
   case 'traerPostalPorId':
   traerPostalPorId($serviciosReferencias);
   break;

   case 'insertarEntidades':
   insertarEntidades($serviciosReferencias);
   break;
   case 'modificarEntidades':
   modificarEntidades($serviciosReferencias);
   break;
   case 'eliminarEntidades':
   eliminarEntidades($serviciosReferencias);
   break;
   case 'traerEntidades':
   traerEntidades($serviciosReferencias);
   break;
   case 'traerEntidadesPorId':
   traerEntidadesPorId($serviciosReferencias);
   break;
   case 'insertarEntidadnacimiento':
   insertarEntidadnacimiento($serviciosReferencias);
   break;
   case 'modificarEntidadnacimiento':
   modificarEntidadnacimiento($serviciosReferencias);
   break;
   case 'eliminarEntidadnacimiento':
   eliminarEntidadnacimiento($serviciosReferencias);
   break;
   case 'traerEntidadnacimiento':
   traerEntidadnacimiento($serviciosReferencias);
   break;
   case 'traerEntidadnacimientoPorId':
   traerEntidadnacimientoPorId($serviciosReferencias);
   break;
   case 'insertarEscolaridades':
   insertarEscolaridades($serviciosReferencias);
   break;
   case 'modificarEscolaridades':
   modificarEscolaridades($serviciosReferencias);
   break;
   case 'eliminarEscolaridades':
   eliminarEscolaridades($serviciosReferencias);
   break;
   case 'traerEscolaridades':
   traerEscolaridades($serviciosReferencias);
   break;
   case 'traerEscolaridadesPorId':
   traerEscolaridadesPorId($serviciosReferencias);
   break;
   case 'insertarEstadocivil':
   insertarEstadocivil($serviciosReferencias);
   break;
   case 'modificarEstadocivil':
   modificarEstadocivil($serviciosReferencias);
   break;
   case 'eliminarEstadocivil':
   eliminarEstadocivil($serviciosReferencias);
   break;
   case 'traerEstadocivil':
   traerEstadocivil($serviciosReferencias);
   break;
   case 'traerEstadocivilPorId':
   traerEstadocivilPorId($serviciosReferencias);
   break;
   case 'insertarEstadodocumentaciones':
   insertarEstadodocumentaciones($serviciosReferencias);
   break;
   case 'modificarEstadodocumentaciones':
   modificarEstadodocumentaciones($serviciosReferencias);
   break;
   case 'eliminarEstadodocumentaciones':
   eliminarEstadodocumentaciones($serviciosReferencias);
   break;
   case 'traerEstadodocumentaciones':
   traerEstadodocumentaciones($serviciosReferencias);
   break;
   case 'traerEstadodocumentacionesPorId':
   traerEstadodocumentacionesPorId($serviciosReferencias);
   break;
   case 'insertarEstadoentrevistas':
   insertarEstadoentrevistas($serviciosReferencias);
   break;
   case 'modificarEstadoentrevistas':
   modificarEstadoentrevistas($serviciosReferencias);
   break;
   case 'eliminarEstadoentrevistas':
   eliminarEstadoentrevistas($serviciosReferencias);
   break;
   case 'traerEstadoentrevistas':
   traerEstadoentrevistas($serviciosReferencias);
   break;
   case 'traerEstadoentrevistasPorId':
   traerEstadoentrevistasPorId($serviciosReferencias);
   break;
   case 'insertarEstadopostulantes':
   insertarEstadopostulantes($serviciosReferencias);
   break;
   case 'modificarEstadopostulantes':
   modificarEstadopostulantes($serviciosReferencias);
   break;
   case 'eliminarEstadopostulantes':
   eliminarEstadopostulantes($serviciosReferencias);
   break;
   case 'traerEstadopostulantes':
   traerEstadopostulantes($serviciosReferencias);
   break;
   case 'traerEstadopostulantesPorId':
   traerEstadopostulantesPorId($serviciosReferencias);
   break;
   case 'insertarEstadosolicitudes':
   insertarEstadosolicitudes($serviciosReferencias);
   break;
   case 'modificarEstadosolicitudes':
   modificarEstadosolicitudes($serviciosReferencias);
   break;
   case 'eliminarEstadosolicitudes':
   eliminarEstadosolicitudes($serviciosReferencias);
   break;
   case 'traerEstadosolicitudes':
   traerEstadosolicitudes($serviciosReferencias);
   break;
   case 'traerEstadosolicitudesPorId':
   traerEstadosolicitudesPorId($serviciosReferencias);
   break;
   case 'insertarPromotorestados':
   insertarPromotorestados($serviciosReferencias);
   break;
   case 'modificarPromotorestados':
   modificarPromotorestados($serviciosReferencias);
   break;
   case 'eliminarPromotorestados':
   eliminarPromotorestados($serviciosReferencias);
   break;
   case 'traerPromotorestados':
   traerPromotorestados($serviciosReferencias);
   break;
   case 'traerPromotorestadosPorId':
   traerPromotorestadosPorId($serviciosReferencias);
   break;

   case 'insertarRolhogar':
   insertarRolhogar($serviciosReferencias);
   break;
   case 'modificarRolhogar':
   modificarRolhogar($serviciosReferencias);
   break;
   case 'eliminarRolhogar':
   eliminarRolhogar($serviciosReferencias);
   break;
   case 'traerRolhogar':
   traerRolhogar($serviciosReferencias);
   break;
   case 'traerRolhogarPorId':
   traerRolhogarPorId($serviciosReferencias);
   break;
   case 'insertarSucursalesinbursa':
   insertarSucursalesinbursa($serviciosReferencias);
   break;
   case 'modificarSucursalesinbursa':
   modificarSucursalesinbursa($serviciosReferencias);
   break;
   case 'eliminarSucursalesinbursa':
   eliminarSucursalesinbursa($serviciosReferencias);
   break;
   case 'traerSucursalesinbursa':
   traerSucursalesinbursa($serviciosReferencias);
   break;
   case 'traerSucursalesinbursaPorId':
   traerSucursalesinbursaPorId($serviciosReferencias);
   break;
   case 'insertarTipoclientes':
   insertarTipoclientes($serviciosReferencias);
   break;
   case 'modificarTipoclientes':
   modificarTipoclientes($serviciosReferencias);
   break;
   case 'eliminarTipoclientes':
   eliminarTipoclientes($serviciosReferencias);
   break;
   case 'traerTipoclientes':
   traerTipoclientes($serviciosReferencias);
   break;
   case 'traerTipoclientesPorId':
   traerTipoclientesPorId($serviciosReferencias);
   break;
   case 'insertarTipocredito':
   insertarTipocredito($serviciosReferencias);
   break;
   case 'modificarTipocredito':
   modificarTipocredito($serviciosReferencias);
   break;
   case 'eliminarTipocredito':
   eliminarTipocredito($serviciosReferencias);
   break;
   case 'traerTipocredito':
   traerTipocredito($serviciosReferencias);
   break;
   case 'traerTipocreditoPorId':
   traerTipocreditoPorId($serviciosReferencias);
   break;
   case 'insertarTipodocumentaciones':
   insertarTipodocumentaciones($serviciosReferencias);
   break;
   case 'modificarTipodocumentaciones':
   modificarTipodocumentaciones($serviciosReferencias);
   break;
   case 'eliminarTipodocumentaciones':
   eliminarTipodocumentaciones($serviciosReferencias);
   break;
   case 'traerTipodocumentaciones':
   traerTipodocumentaciones($serviciosReferencias);
   break;
   case 'traerTipodocumentacionesPorId':
   traerTipodocumentacionesPorId($serviciosReferencias);
   break;
   case 'insertarTipoingreso':
   insertarTipoingreso($serviciosReferencias);
   break;
   case 'modificarTipoingreso':
   modificarTipoingreso($serviciosReferencias);
   break;
   case 'eliminarTipoingreso':
   eliminarTipoingreso($serviciosReferencias);
   break;
   case 'traerTipoingreso':
   traerTipoingreso($serviciosReferencias);
   break;
   case 'traerTipoingresoPorId':
   traerTipoingresoPorId($serviciosReferencias);
   break;
   case 'insertarTipopromotores':
   insertarTipopromotores($serviciosReferencias);
   break;
   case 'modificarTipopromotores':
   modificarTipopromotores($serviciosReferencias);
   break;
   case 'eliminarTipopromotores':
   eliminarTipopromotores($serviciosReferencias);
   break;
   case 'traerTipopromotores':
   traerTipopromotores($serviciosReferencias);
   break;
   case 'traerTipopromotoresPorId':
   traerTipopromotoresPorId($serviciosReferencias);
   break;
   case 'insertarTiposeguros':
   insertarTiposeguros($serviciosReferencias);
   break;
   case 'modificarTiposeguros':
   modificarTiposeguros($serviciosReferencias);
   break;
   case 'eliminarTiposeguros':
   eliminarTiposeguros($serviciosReferencias);
   break;
   case 'traerTiposeguros':
   traerTiposeguros($serviciosReferencias);
   break;
   case 'traerTiposegurosPorId':
   traerTiposegurosPorId($serviciosReferencias);
   break;
   case 'insertarTiposolicitudes':
   insertarTiposolicitudes($serviciosReferencias);
   break;
   case 'modificarTiposolicitudes':
   modificarTiposolicitudes($serviciosReferencias);
   break;
   case 'eliminarTiposolicitudes':
   eliminarTiposolicitudes($serviciosReferencias);
   break;
   case 'traerTiposolicitudes':
   traerTiposolicitudes($serviciosReferencias);
   break;
   case 'traerTiposolicitudesPorId':
   traerTiposolicitudesPorId($serviciosReferencias);
   break;
   case 'traerDocumentacionPorPostulanteDocumentacion':
   traerDocumentacionPorPostulanteDocumentacion($serviciosReferencias);
   break;
   case 'modificarEstadoPostulante':
      modificarEstadoPostulante($serviciosReferencias, $serviciosUsuarios);
   break;
   case 'modificarURLpostulante':
      modificarURLpostulante($serviciosReferencias);
   break;
   case 'insertarIp':
      insertarIp($serviciosReferencias);
   break;

   case 'eliminarDocumentacionPostulante':
      eliminarDocumentacionPostulante($serviciosReferencias);
   break;
   case 'insertarEntrevistasucursales':
      insertarEntrevistasucursales($serviciosReferencias);
   break;
   case 'modificarEntrevistasucursales':
      modificarEntrevistasucursales($serviciosReferencias);
   break;
   case 'eliminarEntrevistasucursales':
      eliminarEntrevistasucursales($serviciosReferencias);
   break;
   case 'traerEntrevistasucursalesPorId':
      traerEntrevistasucursalesPorId($serviciosReferencias);
   break;

}
/* Fin */

function traerEntrevistasucursalesPorId($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerEntrevistasucursalesPorIdCompleto($id);

   if (mysql_num_rows($res) > 0) {
      $resV['error'] = false;
      $resV['domicilio'] = mysql_result($res,0,'domicilio');
      $resV['refpostal'] = mysql_result($res,0,'refpostal');
      $resV['codigopostal'] = mysql_result($res,0,'codigo');
      $resV['codigopostalcompleto'] = utf8_encode( mysql_result($res,0,'estado').' '.mysql_result($res,0,'municipio').' '.mysql_result($res,0,'colonia').' '.mysql_result($res,0,'codigo'));
   } else {
      $resV['error'] = true;
      $resV['domicilio'] = '';
      $resV['codigopostal'] = '';
      $resV['refpostal'] = 0;
      $resV['codigopostalcompleto'] = '';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEntrevistasucursales($serviciosReferencias) {
   $refpostal = $_POST['codigopostalaux'];
   $telefono = $_POST['telefono'];
   $interno = $_POST['interno'];
   $domicilio = $_POST['domicilio'];

   $res = $serviciosReferencias->insertarEntrevistasucursales($refpostal,$telefono,$interno,$domicilio);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarEntrevistasucursales($serviciosReferencias) {
   $id = $_POST['id'];
   $refpostal = $_POST['codigopostalaux2'];
   $telefono = $_POST['telefono'];
   $interno = $_POST['interno'];
   $domicilio = $_POST['domicilio'];

   $res = $serviciosReferencias->modificarEntrevistasucursales($id,$refpostal,$telefono,$interno,$domicilio);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarEntrevistasucursales($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarEntrevistasucursales($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function eliminarDocumentacionPostulante($serviciosReferencias) {
   $idpostulante = $_POST['idpostulante'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $res = $serviciosReferencias->eliminarDocumentacionPostulante($idpostulante, $iddocumentacion);

   header('Content-type: application/json');
   echo json_encode($res);
}

function insertarIp($serviciosReferencias) {
   session_start();

   $resV['datos'] = '';
   $resV['error'] = false;

   $ip = $_SESSION['iptest'];
   $respuesta = $_POST['respuesta'];
   $pregunta = $_POST['pregunta'];

   $activo = '1';
   $verde = '1';
   $amarillo = '0';
   $rojo = '0';

   $resPregunta = $serviciosReferencias->traerPreguntasPorId($pregunta);

   $lblRespuesta =mysql_result($resPregunta, 0,'respuesta'.$respuesta);

   $existe = $serviciosReferencias->traerIpPorIPultimo($ip);

   $token = '';

   if (mysql_num_rows($existe)>0) {

   	$secuencia = mysql_result($resPregunta, 0,'secuencia');
      $token = mysql_result($existe, 0,'token');

      if (($pregunta == 2) && ($respuesta == 3)) {
         $verde = '0';
         $amarillo = '0';
         $rojo = '1';
      } else {
         if (($pregunta == 4) && ($respuesta == 2)) {
            $verde = '0';
            $amarillo = '1';
            $rojo = '0';
         } else {
            $verde = '1';
            $amarillo = '0';
            $rojo = '0';
         }
      }

   	if ($secuencia == 7) {
         $res = $serviciosReferencias->insertarIp($ip,$activo,$secuencia,$verde,$amarillo,$rojo,$lblRespuesta, $pregunta, $token);

         $resV['datos'] = $serviciosReferencias->determinaEstadoTest($token);

         $activo = '0';
         $res = $serviciosReferencias->modificarIpActivo($ip,$activo);
   	} else {
         $activo = '1';

         $secuencia += 1;
         $res = $serviciosReferencias->insertarIp($ip,$activo,$secuencia,$verde,$amarillo,$rojo,$lblRespuesta, $pregunta, $token);

         if ((integer)$res > 0) {

            $resV['datos'] = array('respuesta' => $secuencia);
         } else {
            $resV['error'] = true;
            $resV['datos'] = array('respuesta' => 'Hubo un error al insertar datos');
         }
   	}


   } else {
      $secuencia = 2;

   	$res = $serviciosReferencias->insertarIp($ip,$activo,$secuencia,$verde,$amarillo,$rojo,$lblRespuesta, $pregunta, $serviciosReferencias->GUID());

      if ((integer)$res > 0) {
         if ($lblRespuesta == 'No') {
            $secuencia = 3;
         }

         $resV['datos'] = array('respuesta' => $secuencia);
      } else {
         $resV['error'] = true;
         $resV['datos'] = array('respuesta' => 'Hubo un error al insertar datos');
      }
   }

   header('Content-type: application/json');
   echo json_encode($resV);


}

function modificarURLpostulante($serviciosReferencias) {
   session_start();

   $id = $_POST['idpostulante'];
   $urlprueba = $_POST['urlprueba'];

   $fechamodi = date('Y-m-d H:i:s');
   $usuariomodi = $_SESSION['usua_sahilices'];

   $res = $serviciosReferencias->modificarURLpostulante($id, $urlprueba, $fechamodi, $usuariomodi);

   if ($res == true) {
      echo 'cargado';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function modificarEstadoPostulante($serviciosReferencias, $serviciosUsuarios) {
   $id  = $_POST['id'];
   $idestado      = $_POST['idestado'];

   $resUltimo = $serviciosReferencias->modificarUltimoEstadoPostulante($id,$idestado);

   $res = $serviciosReferencias->modificarEstadoPostulante($id,$idestado);

   if ($idestado == 6) {
      $idestado = 98;
   }



   $ruta = '';

   if ($res == true) {
      // envio email dependeiendo el estado

      $resEstado = $serviciosReferencias->traerEstadopostulantesEtapas($idestado);

      if (mysql_num_rows($resEstado) > 0) {
         $url = $ruta.mysql_result($resEstado,0,'url').'?id='.$id;
      } else {

         $url = 'index.php';
      }

      switch (mysql_result($resEstado,0,'orden')) {

         case 4:
            $resE = $serviciosUsuarios->enviarCorreosEtapas( $idestado, $id);
         break;
         case 5:
            $resE = $serviciosUsuarios->enviarCorreosEtapas( $idestado, $id);
         break;
         case 6:
            $resE = $serviciosUsuarios->enviarCorreosEtapas( $idestado, $id);
         break;
      }
      echo $url;
   } else {
      echo '';
   }
}


function traerDocumentacionPorPostulanteDocumentacion($serviciosArbitros) {

      $idpostulante = $_POST['idpostulante'];
      $iddocumentacion = $_POST['iddocumentacion'];

      $resV['datos'] = '';
      $resV['error'] = false;

      $resFoto = $serviciosArbitros->traerDocumentacionPorPostulanteDocumentacion($idpostulante,$iddocumentacion);

      $imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {
            $imagen = '../../imagenes/sin_img.jpg';

            $resV['datos'] = array('imagen' => $imagen, 'type' => 'imagen');
            $resV['error'] = true;
         } else {
            switch ($iddocumentacion) {
               case 2:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/siap/'.mysql_result($resFoto,0,'archivo');
                  break;
               case 1:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/veritas/'.mysql_result($resFoto,0,'archivo');
                  break;
            }

            $resV['datos'] = array('imagen' => $imagen, 'type' => mysql_result($resFoto,0,'type'));

            $resV['error'] = false;
         }



      } else {
         $imagen = '../../imagenes/sin_img.jpg';


         $resV['datos'] = array('imagen' => $imagen, 'type' => 'imagen');
         $resV['error'] = true;
      }


      header('Content-type: application/json');
      echo json_encode($resV);
   }

   function activarUsuario($serviciosUsuarios, $serviciosReferencias) {
      $idusuario = $_POST['idusuario'];
      $activacion = $_POST['activacion'];

      $rfc = $_POST['rfc'];
      $curp = $_POST['curp'];
      $nacionalidad = $_POST['nacionalidad'];
      $refrolhogar = $_POST['refrolhogar'];
      $refestadocivil = $_POST['refestadocivil'];
      $refentidadnacimiento = $_POST['refentidadnacimiento'];
      $idcliente = $_POST['idcliente'];

      $password = $_POST['password'];


      if ($refentidadnacimiento == 0) {
         echo 'Debe ingresar una Entidad de Nacimiento!.';
      } else {
         //pongo al usuario $activo
      	$resUsuario = $serviciosUsuarios->activarUsuario($idusuario,$password);

         // concreto la activacion
         $resConcretar = $serviciosUsuarios->eliminarActivacionusuarios($activacion);

         $resModUsuario = $serviciosReferencias->modificarClientesCorto($idcliente,$refestadocivil,$rfc,$curp,$nacionalidad,$refrolhogar,$refentidadnacimiento);

         if ($resModUsuario == true) {

            echo '';
         } else {
            echo 'Hubo un error al modificar datos';
         }
      }
   }

   function activarUsuarioPostulante($serviciosUsuarios, $serviciosReferencias) {
      $idusuario = $_POST['idusuario'];
      $activacion = $_POST['activacion'];

      $idpostulante = $_POST['idpostulante'];

      $password = $_POST['password'];

      //pongo al usuario $activo
   	$resUsuario = $serviciosUsuarios->activarUsuario($idusuario,$password);

      // concreto la activacion
      $resConcretar = $serviciosUsuarios->eliminarActivacionusuarios($activacion);

      if ($resUsuario == '') {
         echo '';
      } else {
         echo 'Hubo un error al modificar datos';
      }
   }

function generaCURP($serviciosReferencias, $serviciosUsuarios, $serviciosFunciones) {
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $diaNacimiento = $_POST['diaNacimientodiaNacimiento'];
   $mesNacimiento = $_POST['mesNacimiento'];
   $anioNacimiento = $_POST['anioNacimiento'];
   $sexo = $_POST['sexo'];
   $entidadnacimiento = $_POST['entidadnacimiento'];

   $resEN = $serviciosReferencias->traerEntidadnacimientoPorId($entidadnacimiento);
   $entidadnacimiento = mysql_result($resEN,0,'clave');

   $CURP = $serviciosFunciones->generaCURP($apellidopaterno, $apellidomaterno, $nombre, $diaNacimiento, $mesNacimiento, $anioNacimiento, $sexo, $entidadnacimiento);

   echo $CURP;
}

function frmAjaxVer($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   session_start();

   switch ($tabla) {
      case 'dbclientes':

         $idTabla = "idcliente";

         $lblCambio	 	= array('codipostal','telefon2','email2');
         $lblreemplazo	= array('Cod Postal','Tel. 2','Email 2');


         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();


      break;

      default:
         // code...
         break;
   }

   //$formulario = $serviciosFunciones->camposTablaViejo($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
   $formulario = $serviciosFunciones->camposTablaVer($id,$idTabla,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   echo $formulario;
}



function frmAjaxModificar($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   $url = '';

   session_start();

   switch ($tabla) {
      case 'dbpostulantes':

         $resultado = $serviciosReferencias->traerPostulantesPorId($id);

         $refestado = mysql_result($resultado,0,'refestadopostulantes');

         $resEstado = $serviciosReferencias->traerEstadopostulantesEtapas($refestado);

         $ruta = $_POST['ruta'];

         if (mysql_num_rows($resEstado) > 0) {
            $url = $ruta.mysql_result($resEstado,0,'url').'?id='.$id;
         } else {

            $url = 'index.php';
         }

         $modificar = "modificarPostulantes";
         $idTabla = "idpostulante";

         $lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad');
         $lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad');

         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();
      break;

      case 'dbentrevistas':

         $resultado = $serviciosReferencias->traerEntrevistasPorId($id);

         $modificar = "modificarEntrevistas";
         $idTabla = "identrevista";

         $lblCambio	 	= array('refpostulantes','codigopostal','refestadopostulantes','refestadoentrevistas','refentrevistasucursales');
         $lblreemplazo	= array('Postulante','Cod. Postal','Estado Postulante','Estado Entrevista','Entrev. Sucursales');


         $resVar2	= $serviciosReferencias->traerPostulantesPorId(mysql_result($resultado,0,'refpostulantes'));
         $cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(2,3,4),' ');

         $resVar3	= $serviciosReferencias->traerEstadopostulantesPorId(mysql_result($resultado,0,'refestadopostulantes'));
         $cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');

         $resVar4	= $serviciosReferencias->traerEstadoentrevistas();
         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(1),'',mysql_result($resultado,0,'refestadoentrevistas'));

         $resVar5 = $serviciosReferencias->traerEntrevistasucursales();
         if (mysql_result($resultado,0,'refentrevistasucursales') != 0) {

            $cadRef5 = $serviciosFunciones->devolverSelectBoxActivo($resVar5,array(4,5),' - CP: ',mysql_result($resultado,0,'refentrevistasucursales'));
            $cadRef5 .= "<option value='0'>Manual</option>";
         } else {
            $cadRef5 = "<option value='0'>Manual</option>";
            $cadRef5 .= $serviciosFunciones->devolverSelectBoxActivo($resVar5,array(4,5),' - CP: ',mysql_result($resultado,0,'refentrevistasucursales'));
         }



         $refdescripcion = array(0=> $cadRef2,1=> $cadRef3,2=> $cadRef4,3=>$cadRef5);
         $refCampo 	=  array('refpostulantes','refestadopostulantes','refestadoentrevistas','refentrevistasucursales');


      break;
      case 'dbusuarios':
         $resultado = $serviciosReferencias->traerUsuariosPorId($id);

         $modificar = "modificarUsuario";
         $idTabla = "idusuario";

         $lblCambio	 	= array('nombrecompleto','refclientes','refroles');
         $lblreemplazo	= array('Nombre Completo','Cliente','Perfil');

         $refClientes = $serviciosReferencias->traerClientesPorId(mysql_result($resultado,0,'refclientes'));
         $cadRef2 = $serviciosFunciones->devolverSelectBox($refClientes,array(2,3),' ');



         $resRoles 	= $serviciosUsuarios->traerRoles();


         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resRoles,array(1),'',mysql_result($resultado,0,'refroles'));

         $refdescripcion = array(0 => $cadRef, 1=>$cadRef2);
         $refCampo 	=  array("refroles","refclientes");
      break;
      case 'tbentrevistasucursales':
         $resultado = $serviciosReferencias->traerEntrevistasucursalesPorId($id);

         $modificar = "modificarEntrevistasucursales";
         $idTabla = "identrevistasucursal";

         $lblCambio	 	= array('refpostal');
         $lblreemplazo	= array('Cod. Postal');

         $cadRef2 = '';

         $refdescripcion = array();
         $refCampo 	=  array();
      break;

      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   if ($url != '') {
      echo $url;
   } else {
      switch ($tabla) {
         case 'dbentrevistas':
         echo str_replace('codigopostal','codigopostal2',$formulario);
         break;
         case 'tbentrevistasucursales':
         echo str_replace('refpostal','refpostal2',$formulario);
         break;
      }

   }

}


function frmAjaxNuevo($serviciosReferencias,$serviciosFunciones) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   switch ($tabla) {
      case 'dblloguersadicional':

         $insertar = "insertarLloguersadicional";
         $idTabla = "idllogueradicional";

         $lblCambio	 	= array("reflloguers",'personas');
         $lblreemplazo	= array("Lloguer",'Adultos');

         $resVar1 = $serviciosReferencias->traerLloguersPorIdAux($id);
         $cadRef1 	= $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(4,5),' - ', $id);


         $refdescripcion = array(0=>$cadRef1);
         $refCampo 	=  array('reflloguers');

         $resLA = $serviciosReferencias->traerLloguersadicionalPorLloguer($id);
         $cadTabla = "<table class='table table-hover'>
                     <thead>
                     <th>Adultos</th>
                     <th>Menores</th>
                     <th>Entrada</th>
                     <th>Sortida</th>
                     <th>Taxa Per</th>
                     <th>Taxa Tur.</th>
                     <th>Total</th>
                     <th>Accions</th>
                     </thead>
                     <tbody>";
         while ($row = mysql_fetch_array($resLA)) {
            $cadTabla .= "<tr>";
            $cadTabla .= "<td>".$row['personas']."</td>";
            $cadTabla .= "<td>".$row['menores']."</td>";
            $cadTabla .= "<td>".$row['entrada']."</td>";
            $cadTabla .= "<td>".$row['sortida']."</td>";
            $cadTabla .= "<td>".$row['taxapersona']."</td>";
            $cadTabla .= "<td>".$row['taxaturistica']."</td>";
            $cadTabla .= "<td>".($row['taxaturistica'] + $row['taxapersona'])."</td>";
            $cadTabla .= '<td><button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float btnEliminarLA" id="'.$row['idllogueradicional'].'">
				<i class="material-icons">delete</i>
			</button></td>';
            $cadTabla .= "</tr>";
         }
         $cadTabla .= "</tbody></table>";

         $resV['aux'] = array(
                        'desde' => mysql_result($resVar1,0,'entrada'),
                        'hasta' => mysql_result($resVar1,0,'sortida'),
                        'vista' => $cadTabla
                     );

      break;

      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   $resV['formulario'] = $formulario;

   header('Content-type: application/json');
   echo json_encode($resV);
}




function traerUsuarios($serviciosReferencias) {
      $res = $serviciosReferencias->traerUsuarios();
   $ar = array();
   while ($row = mysql_fetch_array($res)) {
   array_push($ar, $row);
   }
   $resV['datos'] = $ar;
   header('Content-type: application/json');
   echo json_encode($resV);
}



function insertarAsesores($serviciosReferencias) {
   $refusuarios = $_POST['refusuarios'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $curp = $_POST['curp'];
   $rfc = $_POST['rfc'];
   $ine = $_POST['ine'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $sexo = $_POST['sexo'];
   $codigopostal = $_POST['codigopostal'];
   $escolaridad = $_POST['escolaridad'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonocasa = $_POST['telefonocasa'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarAsesores($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$escolaridad,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarAsesores($serviciosReferencias) {
   $id = $_POST['id'];
   $refusuarios = $_POST['refusuarios'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $curp = $_POST['curp'];
   $rfc = $_POST['rfc'];
   $ine = $_POST['ine'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $sexo = $_POST['sexo'];
   $codigopostal = $_POST['codigopostal'];
   $escolaridad = $_POST['escolaridad'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonocasa = $_POST['telefonocasa'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarAsesores($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$escolaridad,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarAsesores($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarAsesores($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerAsesores($serviciosReferencias) {
   $res = $serviciosReferencias->traerAsesores();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarClientes($serviciosReferencias) {
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $sexo = $_POST['sexo'];
   $refestadocivil = $_POST['refestadocivil'];
   $rfc = $_POST['rfc'];
   $curp = $_POST['curp'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $numerocliente = $_POST['numerocliente'];
   $nacionalidad = $_POST['nacionalidad'];
   $refpromotores = $_POST['refpromotores'];
   $refasesores = $_POST['refasesores'];
   $refrolhogar = $_POST['refrolhogar'];
   $reftipoclientes = $_POST['reftipoclientes'];
   $refentidadnacimiento = $_POST['refentidadnacimiento'];
   $refusuarios = $_POST['refusuarios'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarClientes($nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refasesores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarClientes($serviciosReferencias) {
   $id = $_POST['id'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $sexo = $_POST['sexo'];
   $refestadocivil = $_POST['refestadocivil'];
   $rfc = $_POST['rfc'];
   $curp = $_POST['curp'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $numerocliente = $_POST['numerocliente'];
   $nacionalidad = $_POST['nacionalidad'];
   $refpromotores = $_POST['refpromotores'];
   $refasesores = $_POST['refasesores'];
   $refrolhogar = $_POST['refrolhogar'];
   $reftipoclientes = $_POST['reftipoclientes'];
   $refentidadnacimiento = $_POST['refentidadnacimiento'];
   $refusuarios = $_POST['refusuarios'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarClientes($id,$nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refasesores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarClientes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarClientes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerClientes($serviciosReferencias) {
   $res = $serviciosReferencias->traerClientes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarDocumentacionasesores($serviciosReferencias) {
   $refasesores = $_POST['refasesores'];
   $refdocumentaciones = $_POST['refdocumentaciones'];
   $archivo = $_POST['archivo'];
   $type = $_POST['type'];
   $refestadodocumentaciones = $_POST['refestadodocumentaciones'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarDocumentacionasesores($refasesores,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarDocumentacionasesores($serviciosReferencias) {
   $id = $_POST['id'];
   $refasesores = $_POST['refasesores'];
   $refdocumentaciones = $_POST['refdocumentaciones'];
   $archivo = $_POST['archivo'];
   $type = $_POST['type'];
   $refestadodocumentaciones = $_POST['refestadodocumentaciones'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarDocumentacionasesores($id,$refasesores,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarDocumentacionasesores($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarDocumentacionasesores($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerDocumentacionasesores($serviciosReferencias) {
   $res = $serviciosReferencias->traerDocumentacionasesores();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarDocumentaciones($serviciosReferencias) {
   $reftipodocumentaciones = $_POST['reftipodocumentaciones'];
   $documentacion = $_POST['documentacion'];
   $obligatoria = $_POST['obligatoria'];
   $cantidadarchivos = $_POST['cantidadarchivos'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarDocumentaciones($reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarDocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];
   $reftipodocumentaciones = $_POST['reftipodocumentaciones'];
   $documentacion = $_POST['documentacion'];
   $obligatoria = $_POST['obligatoria'];
   $cantidadarchivos = $_POST['cantidadarchivos'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarDocumentaciones($id,$reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarDocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarDocumentaciones($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerDocumentaciones($serviciosReferencias) {
   $res = $serviciosReferencias->traerDocumentaciones();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarDocumentacionsolicitudes($serviciosReferencias) {
   $refsolicitudes = $_POST['refsolicitudes'];
   $refdocumentaciones = $_POST['refdocumentaciones'];
   $archivo = $_POST['archivo'];
   $type = $_POST['type'];
   $refestadodocumentaciones = $_POST['refestadodocumentaciones'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarDocumentacionsolicitudes($refsolicitudes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarDocumentacionsolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
   $refsolicitudes = $_POST['refsolicitudes'];
   $refdocumentaciones = $_POST['refdocumentaciones'];
   $archivo = $_POST['archivo'];
   $type = $_POST['type'];
   $refestadodocumentaciones = $_POST['refestadodocumentaciones'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarDocumentacionsolicitudes($id,$refsolicitudes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarDocumentacionsolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarDocumentacionsolicitudes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerDocumentacionsolicitudes($serviciosReferencias) {
   $res = $serviciosReferencias->traerDocumentacionsolicitudes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEntrevistas($serviciosReferencias) {
   session_start();

   $refpostulantes = $_POST['refpostulantes'];
   $refestadopostulantes = $_POST['refestadopostulantes'];

   $resPostulante = $serviciosReferencias->traerPostulantesPorId($refpostulantes);

   $resEntrevista = $serviciosReferencias->traerEntrevistasActivasPorPostulanteEstadoPostulante($refpostulantes,$refestadopostulantes);

   if (mysql_num_rows($resEntrevista) > 0) {
      echo 'Ya existe una entrevista pendiente';
   } else {

      $entrevistador = $_POST['entrevistador'];
      $fecha = $_POST['fecha'];
      $domicilio = $_POST['domicilio'];
      $codigopostal = $_POST['codipostalaux'];

      $refestadoentrevistas = $_POST['refestadoentrevistas'];
      $refentrevistasucursales = $_POST['refentrevistasucursales'];
      $fechacrea = date('Y-m-d H:i:s');
      $fechamodi = date('Y-m-d H:i:s');
      $usuariocrea = $_SESSION['usua_sahilices'];
      $usuariomodi = $_SESSION['usua_sahilices'];

      $res = $serviciosReferencias->insertarEntrevistas($refpostulantes,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadopostulantes,$refestadoentrevistas,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refentrevistasucursales);

      if ((integer)$res > 0) {
         //$resCambioEstado = $serviciosReferencias->modificarEstadoPostulante($refpostulantes,2);
         echo '';
      } else {
         echo 'Hubo un error al insertar datos';
      }
   }
}


function modificarEntrevistas($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refpostulantes = $_POST['refpostulantes'];
   $entrevistador = $_POST['entrevistador'];
   $fecha = $_POST['fecha'];
   $domicilio = $_POST['domicilio'];
   $codigopostal = $_POST['codigopostal2'];
   $refestadopostulantes = $_POST['refestadopostulantes'];
   $refestadoentrevistas = $_POST['refestadoentrevistas'];
   $refentrevistasucursales = $_POST['refentrevistasucursales'];

   $fechamodi = date('Y-m-d H:i:s');

   $usuariomodi = $_SESSION['usua_sahilices'];

   $res = $serviciosReferencias->modificarEntrevistas($id,$refpostulantes,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadopostulantes,$refestadoentrevistas,$fechamodi,$usuariomodi,$refentrevistasucursales);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEntrevistas($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEntrevistas($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEntrevistas($serviciosReferencias) {
   $res = $serviciosReferencias->traerEntrevistas();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarPostulantes($serviciosReferencias, $serviciosUsuarios) {
   session_start();

   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];

   $apellido = $apellidopaterno.' '.$apellidomaterno;

   // primer creo el usuario

   $password = $apellidopaterno.$apellidomaterno.date('His');

   $resUsuario = $serviciosUsuarios->insertarUsuario($nombre,$password,7,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

   if ((integer)$resUsuario > 0) {
      $refusuarios = $resUsuario;

      // fin de crear usuario
      $curp = '';
      $rfc = '';
      $ine = '';
      $fechanacimiento = $_POST['fechanacimiento'];
      $sexo = $_POST['sexo'];
      $codigopostal = $_POST['codigopostal'];
      $refescolaridades = $_POST['refescolaridades'];
      $refestadocivil = $_POST['refestadocivil'];
      $nacionalidad = $_POST['nacionalidad'];
      $telefonomovil = $_POST['telefonomovil'];
      $telefonocasa = $_POST['telefonocasa'];
      $telefonotrabajo = $_POST['telefonotrabajo'];
      $refestadopostulantes = 1;
      $urlprueba = '';
      $fechacrea = date('Y-m-d H:i:s');
      $fechamodi = date('Y-m-d H:i:s');
      if (isset($_SESSION['usua_sahilices'])) {
         $usuariocrea = $_SESSION['usua_sahilices'];
         $usuariomodi = $_SESSION['usua_sahilices'];
      } else {
         $usuariocrea = $_SESSION['usua_sahilices_web'];
         $usuariomodi = $_SESSION['usua_sahilices_web'];
      }

      $refasesores = 0;
      $comision = 0;
      $refsucursalesinbursa = 0;
      $ultimoestado = 1;

      if (isset($_SESSION['token'])) {
         $token = $_SESSION['token'];
      } else {
         $token = $serviciosReferencias->GUID();
      }

      $afore = $_POST['afore'];
      $compania = $_POST['compania'];
      $cedula = $_POST['cedula'];

      if ($cedula == '1') {
         $refesquemareclutamiento = 1;
      } else {
         $refesquemareclutamiento = 2;
      }

      if ($afore == '1') {
         $refestadopostulantes = 99;
         // rechazo la solicitud
      } else {
         // envio email de confirmacion para validar cuenta de email. Correr a la noche un CRON
         // para dar de baja los usuarios basura
         $resActivacion = $serviciosUsuarios->confirmarEmail($email, $password,$apellido, $nombre, $refusuarios);
         //die(var_dump($resActivacion));
      }

      $res = $serviciosReferencias->insertarPostulantes($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$refesquemareclutamiento,$afore,$compania,$cedula,$token);

      if ((integer)$res > 0) {
         echo '';
      } else {
         echo 'Hubo un error al insertar datos ';
      }


   } else {
      echo 'Hubo un error al crear usuario, verificar que no existe ya ese email en la base de datos';
   }
}


function modificarPostulantes($serviciosReferencias) {

   session_start();

   $id = $_POST['id'];
   $refusuarios = $_POST['refusuarios'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $curp = $_POST['curp'];
   $rfc = $_POST['rfc'];
   $ine = $_POST['ine'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $sexo = $_POST['sexo'];
   $codigopostal = $_POST['codigopostal'];
   $refescolaridades = $_POST['refescolaridades'];
   $refestadocivil = $_POST['refestadocivil'];
   $nacionalidad = $_POST['nacionalidad'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonocasa = $_POST['telefonocasa'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $refestadopostulantes = $_POST['refestadopostulantes'];
   $urlprueba = $_POST['urlprueba'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $refasesores = 0;
   $comision = 0;
   $refsucursalesinbursa = 0;
   $ultimoestado = $_POST['ultimoestado'];

   $res = $serviciosReferencias->modificarPostulantes($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarPostulantes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarPostulantes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerPostulantes($serviciosReferencias) {
   $res = $serviciosReferencias->traerPostulantes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarPromotores($serviciosReferencias) {
   $reftipopromotores = $_POST['reftipopromotores'];
   $refusuarios = $_POST['refusuarios'];
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $rfc = $_POST['rfc'];
   $curp = $_POST['curp'];
   $comision = $_POST['comision'];
   $teloficina = $_POST['teloficina'];
   $telparticular = $_POST['telparticular'];
   $telmovil = $_POST['telmovil'];
   $refpromotorestados = $_POST['refpromotorestados'];
   $refsucursales = $_POST['refsucursales'];
   $refsupervisorusuario = $_POST['refsupervisorusuario'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
      $res = $serviciosReferencias->insertarPromotores($reftipopromotores,$refusuarios,$nombre,$apellido,$rfc,$curp,$comision,$teloficina,$telparticular,$telmovil,$refpromotorestados,$refsucursales,$refsupervisorusuario,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarPromotores($serviciosReferencias) {
   $id = $_POST['id'];
   $reftipopromotores = $_POST['reftipopromotores'];
   $refusuarios = $_POST['refusuarios'];
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $rfc = $_POST['rfc'];
   $curp = $_POST['curp'];
   $comision = $_POST['comision'];
   $teloficina = $_POST['teloficina'];
   $telparticular = $_POST['telparticular'];
   $telmovil = $_POST['telmovil'];
   $refpromotorestados = $_POST['refpromotorestados'];
   $refsucursales = $_POST['refsucursales'];
   $refsupervisorusuario = $_POST['refsupervisorusuario'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
      $res = $serviciosReferencias->modificarPromotores($id,$reftipopromotores,$refusuarios,$nombre,$apellido,$rfc,$curp,$comision,$teloficina,$telparticular,$telmovil,$refpromotorestados,$refsucursales,$refsupervisorusuario,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarPromotores($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarPromotores($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerPromotores($serviciosReferencias) {
   $res = $serviciosReferencias->traerPromotores();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarSolicituddetallecreditohipotecario($serviciosReferencias) {
   $reftipocredito = $_POST['reftipocredito'];
   $montoinicial = $_POST['montoinicial'];
   $cuotas = $_POST['cuotas'];
   $valorpropiedad = $_POST['valorpropiedad'];
   $importecuotaactual = $_POST['importecuotaactual'];
   $cuotaspendientes = $_POST['cuotaspendientes'];
   $saldocredito = $_POST['saldocredito'];
   $valorcuotanuevo = $_POST['valorcuotanuevo'];
      $res = $serviciosReferencias->insertarSolicituddetallecreditohipotecario($reftipocredito,$montoinicial,$cuotas,$valorpropiedad,$importecuotaactual,$cuotaspendientes,$saldocredito,$valorcuotanuevo);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarSolicituddetallecreditohipotecario($serviciosReferencias) {
   $id = $_POST['id'];
   $reftipocredito = $_POST['reftipocredito'];
   $montoinicial = $_POST['montoinicial'];
   $cuotas = $_POST['cuotas'];
   $valorpropiedad = $_POST['valorpropiedad'];
   $importecuotaactual = $_POST['importecuotaactual'];
   $cuotaspendientes = $_POST['cuotaspendientes'];
   $saldocredito = $_POST['saldocredito'];
   $valorcuotanuevo = $_POST['valorcuotanuevo'];
      $res = $serviciosReferencias->modificarSolicituddetallecreditohipotecario($id,$reftipocredito,$montoinicial,$cuotas,$valorpropiedad,$importecuotaactual,$cuotaspendientes,$saldocredito,$valorcuotanuevo);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarSolicituddetallecreditohipotecario($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarSolicituddetallecreditohipotecario($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerSolicituddetallecreditohipotecario($serviciosReferencias) {
   $res = $serviciosReferencias->traerSolicituddetallecreditohipotecario();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarSolicituddetalleseguros($serviciosReferencias) {
   $refsolicitudes = $_POST['refsolicitudes'];
   $reftiposeguros = $_POST['reftiposeguros'];
   $nombrecompleto = $_POST['nombrecompleto'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $entidadfederativanacimeinto = $_POST['entidadfederativanacimeinto'];
   $paisnacimiento = $_POST['paisnacimiento'];
   $genero = $_POST['genero'];
   $estadocivil = $_POST['estadocivil'];
   $nacionalidad = $_POST['nacionalidad'];
   $calidadmigratoria = $_POST['calidadmigratoria'];
   $curp = $_POST['curp'];
   $ocupacion = $_POST['ocupacion'];
   $domicilio = $_POST['domicilio'];
   $nroexterior = $_POST['nroexterior'];
   $edificio = $_POST['edificio'];
   $nrointerior = $_POST['nrointerior'];
   $codigopostal = $_POST['codigopostal'];
   $colonia = $_POST['colonia'];
   $delegacion = $_POST['delegacion'];
   $entidadfederativa = $_POST['entidadfederativa'];
   $pais = $_POST['pais'];
   $motivoextranjerocontrato = $_POST['motivoextranjerocontrato'];
   $telefonofijo = $_POST['telefonofijo'];
   $telefonomovil = $_POST['telefonomovil'];
   $correoelectronico = $_POST['correoelectronico'];
   $funcionpublica = $_POST['funcionpublica'];
   $quien = $_POST['quien'];
   $cargo = $_POST['cargo'];
   $fechafinalizacion = $_POST['fechafinalizacion'];
   $nombrecompletofuncionpublica = $_POST['nombrecompletofuncionpublica'];
   $seguropersonal = $_POST['seguropersonal'];
   $padeceenfermedadactual = $_POST['padeceenfermedadactual'];
   $tieneintervencionquirurgica = $_POST['tieneintervencionquirurgica'];
   $tienepruebas = $_POST['tienepruebas'];
   $poseeenfermedad = $_POST['poseeenfermedad'];
   $poseeprotesis = $_POST['poseeprotesis'];
   $tienetransplantes = $_POST['tienetransplantes'];
   $tienecancer = $_POST['tienecancer'];
   $tienetratamientocancer = $_POST['tienetratamientocancer'];
   $pendientecirugiacancer = $_POST['pendientecirugiacancer'];
   $consulta5porcancer = $_POST['consulta5porcancer'];
   $poseeviruspapiloma = $_POST['poseeviruspapiloma'];
   $antecedentesfamiliarescancer = $_POST['antecedentesfamiliarescancer'];
   $masinformacion = $_POST['masinformacion'];
   $peso = $_POST['peso'];
   $estatura = $_POST['estatura'];
   $fuma = $_POST['fuma'];
   $tomaalcohol = $_POST['tomaalcohol'];
   $cobrobancario = $_POST['cobrobancario'];
   $periodopago = $_POST['periodopago'];
   $tipopago = $_POST['tipopago'];
   $banco = $_POST['banco'];
   $nombrecompletotarjeta = $_POST['nombrecompletotarjeta'];
   $cuentacheques = $_POST['cuentacheques'];
   $nrotarjetacredito = $_POST['nrotarjetacredito'];
   $vencimiento = $_POST['vencimiento'];
      $res = $serviciosReferencias->insertarSolicituddetalleseguros($refsolicitudes,$reftiposeguros,$nombrecompleto,$fechanacimiento,$entidadfederativanacimeinto,$paisnacimiento,$genero,$estadocivil,$nacionalidad,$calidadmigratoria,$curp,$ocupacion,$domicilio,$nroexterior,$edificio,$nrointerior,$codigopostal,$colonia,$delegacion,$entidadfederativa,$pais,$motivoextranjerocontrato,$telefonofijo,$telefonomovil,$correoelectronico,$funcionpublica,$quien,$cargo,$fechafinalizacion,$nombrecompletofuncionpublica,$seguropersonal,$padeceenfermedadactual,$tieneintervencionquirurgica,$tienepruebas,$poseeenfermedad,$poseeprotesis,$tienetransplantes,$tienecancer,$tienetratamientocancer,$pendientecirugiacancer,$consulta5porcancer,$poseeviruspapiloma,$antecedentesfamiliarescancer,$masinformacion,$peso,$estatura,$fuma,$tomaalcohol,$cobrobancario,$periodopago,$tipopago,$banco,$nombrecompletotarjeta,$cuentacheques,$nrotarjetacredito,$vencimiento);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarSolicituddetalleseguros($serviciosReferencias) {
   $id = $_POST['id'];
   $refsolicitudes = $_POST['refsolicitudes'];
   $reftiposeguros = $_POST['reftiposeguros'];
   $nombrecompleto = $_POST['nombrecompleto'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $entidadfederativanacimeinto = $_POST['entidadfederativanacimeinto'];
   $paisnacimiento = $_POST['paisnacimiento'];
   $genero = $_POST['genero'];
   $estadocivil = $_POST['estadocivil'];
   $nacionalidad = $_POST['nacionalidad'];
   $calidadmigratoria = $_POST['calidadmigratoria'];
   $curp = $_POST['curp'];
   $ocupacion = $_POST['ocupacion'];
   $domicilio = $_POST['domicilio'];
   $nroexterior = $_POST['nroexterior'];
   $edificio = $_POST['edificio'];
   $nrointerior = $_POST['nrointerior'];
   $codigopostal = $_POST['codigopostal'];
   $colonia = $_POST['colonia'];
   $delegacion = $_POST['delegacion'];
   $entidadfederativa = $_POST['entidadfederativa'];
   $pais = $_POST['pais'];
   $motivoextranjerocontrato = $_POST['motivoextranjerocontrato'];
   $telefonofijo = $_POST['telefonofijo'];
   $telefonomovil = $_POST['telefonomovil'];
   $correoelectronico = $_POST['correoelectronico'];
   $funcionpublica = $_POST['funcionpublica'];
   $quien = $_POST['quien'];
   $cargo = $_POST['cargo'];
   $fechafinalizacion = $_POST['fechafinalizacion'];
   $nombrecompletofuncionpublica = $_POST['nombrecompletofuncionpublica'];
   $seguropersonal = $_POST['seguropersonal'];
   $padeceenfermedadactual = $_POST['padeceenfermedadactual'];
   $tieneintervencionquirurgica = $_POST['tieneintervencionquirurgica'];
   $tienepruebas = $_POST['tienepruebas'];
   $poseeenfermedad = $_POST['poseeenfermedad'];
   $poseeprotesis = $_POST['poseeprotesis'];
   $tienetransplantes = $_POST['tienetransplantes'];
   $tienecancer = $_POST['tienecancer'];
   $tienetratamientocancer = $_POST['tienetratamientocancer'];
   $pendientecirugiacancer = $_POST['pendientecirugiacancer'];
   $consulta5porcancer = $_POST['consulta5porcancer'];
   $poseeviruspapiloma = $_POST['poseeviruspapiloma'];
   $antecedentesfamiliarescancer = $_POST['antecedentesfamiliarescancer'];
   $masinformacion = $_POST['masinformacion'];
   $peso = $_POST['peso'];
   $estatura = $_POST['estatura'];
   $fuma = $_POST['fuma'];
   $tomaalcohol = $_POST['tomaalcohol'];
   $cobrobancario = $_POST['cobrobancario'];
   $periodopago = $_POST['periodopago'];
   $tipopago = $_POST['tipopago'];
   $banco = $_POST['banco'];
   $nombrecompletotarjeta = $_POST['nombrecompletotarjeta'];
   $cuentacheques = $_POST['cuentacheques'];
   $nrotarjetacredito = $_POST['nrotarjetacredito'];
   $vencimiento = $_POST['vencimiento'];
      $res = $serviciosReferencias->modificarSolicituddetalleseguros($id,$refsolicitudes,$reftiposeguros,$nombrecompleto,$fechanacimiento,$entidadfederativanacimeinto,$paisnacimiento,$genero,$estadocivil,$nacionalidad,$calidadmigratoria,$curp,$ocupacion,$domicilio,$nroexterior,$edificio,$nrointerior,$codigopostal,$colonia,$delegacion,$entidadfederativa,$pais,$motivoextranjerocontrato,$telefonofijo,$telefonomovil,$correoelectronico,$funcionpublica,$quien,$cargo,$fechafinalizacion,$nombrecompletofuncionpublica,$seguropersonal,$padeceenfermedadactual,$tieneintervencionquirurgica,$tienepruebas,$poseeenfermedad,$poseeprotesis,$tienetransplantes,$tienecancer,$tienetratamientocancer,$pendientecirugiacancer,$consulta5porcancer,$poseeviruspapiloma,$antecedentesfamiliarescancer,$masinformacion,$peso,$estatura,$fuma,$tomaalcohol,$cobrobancario,$periodopago,$tipopago,$banco,$nombrecompletotarjeta,$cuentacheques,$nrotarjetacredito,$vencimiento);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarSolicituddetalleseguros($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarSolicituddetalleseguros($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerSolicituddetalleseguros($serviciosReferencias) {
   $res = $serviciosReferencias->traerSolicituddetalleseguros();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarSolicituddetalletelmex($serviciosReferencias) {
   $refsolicitudes = $_POST['refsolicitudes'];
   $recibotelefonico = $_POST['recibotelefonico'];
   $reftipopersona = $_POST['reftipopersona'];
   $montootorgado = $_POST['montootorgado'];
   $cuotas = $_POST['cuotas'];
   $mensualidad = $_POST['mensualidad'];

   $res = $serviciosReferencias->insertarSolicituddetalletelmex($refsolicitudes,$recibotelefonico,$reftipopersona,$montootorgado,$cuotas,$mensualidad);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarSolicituddetalletelmex($serviciosReferencias) {
   $id = $_POST['id'];
   $refsolicitudes = $_POST['refsolicitudes'];
   $recibotelefonico = $_POST['recibotelefonico'];
   $reftipopersona = $_POST['reftipopersona'];
   $montootorgado = $_POST['montootorgado'];
   $cuotas = $_POST['cuotas'];
   $mensualidad = $_POST['mensualidad'];

   $res = $serviciosReferencias->modificarSolicituddetalletelmex($id,$refsolicitudes,$recibotelefonico,$reftipopersona,$montootorgado,$cuotas,$mensualidad);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarSolicituddetalletelmex($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarSolicituddetalletelmex($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerSolicituddetalletelmex($serviciosReferencias) {
   $res = $serviciosReferencias->traerSolicituddetalletelmex();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarSolicitudes($serviciosReferencias) {
   $reftiposolicitudes = $_POST['reftiposolicitudes'];
   $refestadosolicitudes = $_POST['refestadosolicitudes'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $telefono = $_POST['telefono'];
   $sexo = $_POST['sexo'];
   $codigopostal = $_POST['codigopostal'];
   $reftipoingreso = $_POST['reftipoingreso'];
   $refclientes = $_POST['refclientes'];
   $refusuarios = $_POST['refusuarios'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarSolicitudes($reftiposolicitudes,$refestadosolicitudes,$nombre,$apellidopaterno,$apellidomaterno,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarSolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
   $reftiposolicitudes = $_POST['reftiposolicitudes'];
   $refestadosolicitudes = $_POST['refestadosolicitudes'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $telefono = $_POST['telefono'];
   $sexo = $_POST['sexo'];
   $codigopostal = $_POST['codigopostal'];
   $reftipoingreso = $_POST['reftipoingreso'];
   $refclientes = $_POST['refclientes'];
   $refusuarios = $_POST['refusuarios'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarSolicitudes($id,$reftiposolicitudes,$refestadosolicitudes,$nombre,$apellidopaterno,$apellidomaterno,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarSolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarSolicitudes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerSolicitudes($serviciosReferencias) {
   $res = $serviciosReferencias->traerSolicitudes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarSucursales($serviciosReferencias) {
   $refentidades = $_POST['refentidades'];
   $calle = $_POST['calle'];
   $nombre = $_POST['nombre'];
   $colonia = $_POST['colonia'];
   $ciudad = $_POST['ciudad'];
   $codigopostal = $_POST['codigopostal'];
   $lada = $_POST['lada'];
   $telefono = $_POST['telefono'];
   $fax = $_POST['fax'];
   $contacto = $_POST['contacto'];
   $email = $_POST['email'];
   $refpadre = $_POST['refpadre'];

   $res = $serviciosReferencias->insertarSucursales($refentidades,$calle,$nombre,$colonia,$ciudad,$codigopostal,$lada,$telefono,$fax,$contacto,$email,$refpadre);

   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarSucursales($serviciosReferencias) {
   $id = $_POST['id'];
   $refentidades = $_POST['refentidades'];
   $calle = $_POST['calle'];
   $nombre = $_POST['nombre'];
   $colonia = $_POST['colonia'];
   $ciudad = $_POST['ciudad'];
   $codigopostal = $_POST['codigopostal'];
   $lada = $_POST['lada'];
   $telefono = $_POST['telefono'];
   $fax = $_POST['fax'];
   $contacto = $_POST['contacto'];
   $email = $_POST['email'];
   $refpadre = $_POST['refpadre'];
      $res = $serviciosReferencias->modificarSucursales($id,$refentidades,$calle,$nombre,$colonia,$ciudad,$codigopostal,$lada,$telefono,$fax,$contacto,$email,$refpadre);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarSucursales($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarSucursales($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerSucursales($serviciosReferencias) {
   $res = $serviciosReferencias->traerSucursales();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarPostal($serviciosReferencias) {
   $codigo = $_POST['codigo'];
   $colonia = $_POST['colonia'];
   $municipio = $_POST['municipio'];
   $estado = $_POST['estado'];
      $res = $serviciosReferencias->insertarPostal($codigo,$colonia,$municipio,$estado);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarPostal($serviciosReferencias) {
   $id = $_POST['id'];
   $codigo = $_POST['codigo'];
   $colonia = $_POST['colonia'];
   $municipio = $_POST['municipio'];
   $estado = $_POST['estado'];
      $res = $serviciosReferencias->modificarPostal($id,$codigo,$colonia,$municipio,$estado);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarPostal($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarPostal($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerPostal($serviciosReferencias) {
   $res = $serviciosReferencias->traerPostal();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarEntidades($serviciosReferencias) {
   $nombre = $_POST['nombre'];
   $clave = $_POST['clave'];
      $res = $serviciosReferencias->insertarEntidades($nombre,$clave);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEntidades($serviciosReferencias) {
   $id = $_POST['id'];
   $nombre = $_POST['nombre'];
   $clave = $_POST['clave'];
      $res = $serviciosReferencias->modificarEntidades($id,$nombre,$clave);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEntidades($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEntidades($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEntidades($serviciosReferencias) {
   $res = $serviciosReferencias->traerEntidades();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEntidadnacimiento($serviciosReferencias) {
   $entidadnacimiento = $_POST['entidadnacimiento'];
   $clave = $_POST['clave'];
      $res = $serviciosReferencias->insertarEntidadnacimiento($entidadnacimiento,$clave);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEntidadnacimiento($serviciosReferencias) {
   $id = $_POST['id'];
   $entidadnacimiento = $_POST['entidadnacimiento'];
   $clave = $_POST['clave'];
      $res = $serviciosReferencias->modificarEntidadnacimiento($id,$entidadnacimiento,$clave);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEntidadnacimiento($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEntidadnacimiento($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEntidadnacimiento($serviciosReferencias) {
   $res = $serviciosReferencias->traerEntidadnacimiento();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEscolaridades($serviciosReferencias) {
   $escolaridad = $_POST['escolaridad'];
      $res = $serviciosReferencias->insertarEscolaridades($escolaridad);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEscolaridades($serviciosReferencias) {
   $id = $_POST['id'];
   $escolaridad = $_POST['escolaridad'];
      $res = $serviciosReferencias->modificarEscolaridades($id,$escolaridad);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEscolaridades($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEscolaridades($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEscolaridades($serviciosReferencias) {
   $res = $serviciosReferencias->traerEscolaridades();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarEstadocivil($serviciosReferencias) {
   $estadocivil = $_POST['estadocivil'];
      $res = $serviciosReferencias->insertarEstadocivil($estadocivil);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEstadocivil($serviciosReferencias) {
   $id = $_POST['id'];
   $estadocivil = $_POST['estadocivil'];
      $res = $serviciosReferencias->modificarEstadocivil($id,$estadocivil);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEstadocivil($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEstadocivil($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEstadocivil($serviciosReferencias) {
   $res = $serviciosReferencias->traerEstadocivil();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEstadodocumentaciones($serviciosReferencias) {
   $estadodocumentacion = $_POST['estadodocumentacion'];
      $res = $serviciosReferencias->insertarEstadodocumentaciones($estadodocumentacion);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEstadodocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];
   $estadodocumentacion = $_POST['estadodocumentacion'];
      $res = $serviciosReferencias->modificarEstadodocumentaciones($id,$estadodocumentacion);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEstadodocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEstadodocumentaciones($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEstadodocumentaciones($serviciosReferencias) {
   $res = $serviciosReferencias->traerEstadodocumentaciones();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEstadoentrevistas($serviciosReferencias) {
   $estadoentrevista = $_POST['estadoentrevista'];
      $res = $serviciosReferencias->insertarEstadoentrevistas($estadoentrevista);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEstadoentrevistas($serviciosReferencias) {
   $id = $_POST['id'];
   $estadoentrevista = $_POST['estadoentrevista'];
      $res = $serviciosReferencias->modificarEstadoentrevistas($id,$estadoentrevista);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEstadoentrevistas($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEstadoentrevistas($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEstadoentrevistas($serviciosReferencias) {
   $res = $serviciosReferencias->traerEstadoentrevistas();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEstadopostulantes($serviciosReferencias) {
   $estadopostulante = $_POST['estadopostulante'];
   $orden = $_POST['orden'];
      $res = $serviciosReferencias->insertarEstadopostulantes($estadopostulante,$orden);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEstadopostulantes($serviciosReferencias) {
   $id = $_POST['id'];
   $estadopostulante = $_POST['estadopostulante'];
   $orden = $_POST['orden'];
      $res = $serviciosReferencias->modificarEstadopostulantes($id,$estadopostulante,$orden);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEstadopostulantes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEstadopostulantes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEstadopostulantes($serviciosReferencias) {
   $res = $serviciosReferencias->traerEstadopostulantes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarEstadosolicitudes($serviciosReferencias) {
   $estadosolicitud = $_POST['estadosolicitud'];
      $res = $serviciosReferencias->insertarEstadosolicitudes($estadosolicitud);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarEstadosolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
   $estadosolicitud = $_POST['estadosolicitud'];
      $res = $serviciosReferencias->modificarEstadosolicitudes($id,$estadosolicitud);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEstadosolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarEstadosolicitudes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerEstadosolicitudes($serviciosReferencias) {
   $res = $serviciosReferencias->traerEstadosolicitudes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarPromotorestados($serviciosReferencias) {
   $promotorestado = $_POST['promotorestado'];
      $res = $serviciosReferencias->insertarPromotorestados($promotorestado);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarPromotorestados($serviciosReferencias) {
   $id = $_POST['id'];
   $promotorestado = $_POST['promotorestado'];
      $res = $serviciosReferencias->modificarPromotorestados($id,$promotorestado);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarPromotorestados($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarPromotorestados($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerPromotorestados($serviciosReferencias) {
   $res = $serviciosReferencias->traerPromotorestados();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarRolhogar($serviciosReferencias) {
   $rolhogar = $_POST['rolhogar'];
      $res = $serviciosReferencias->insertarRolhogar($rolhogar);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarRolhogar($serviciosReferencias) {
   $id = $_POST['id'];
   $rolhogar = $_POST['rolhogar'];
      $res = $serviciosReferencias->modificarRolhogar($id,$rolhogar);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarRolhogar($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarRolhogar($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerRolhogar($serviciosReferencias) {
   $res = $serviciosReferencias->traerRolhogar();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarSucursalesinbursa($serviciosReferencias) {
   $sucursal = $_POST['sucursal'];
      $res = $serviciosReferencias->insertarSucursalesinbursa($sucursal);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarSucursalesinbursa($serviciosReferencias) {
   $id = $_POST['id'];
   $sucursal = $_POST['sucursal'];
      $res = $serviciosReferencias->modificarSucursalesinbursa($id,$sucursal);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarSucursalesinbursa($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarSucursalesinbursa($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerSucursalesinbursa($serviciosReferencias) {
   $res = $serviciosReferencias->traerSucursalesinbursa();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarTipoclientes($serviciosReferencias) {
   $tipocliente = $_POST['tipocliente'];
      $res = $serviciosReferencias->insertarTipoclientes($tipocliente);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarTipoclientes($serviciosReferencias) {
   $id = $_POST['id'];
   $tipocliente = $_POST['tipocliente'];
      $res = $serviciosReferencias->modificarTipoclientes($id,$tipocliente);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTipoclientes($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarTipoclientes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTipoclientes($serviciosReferencias) {
   $res = $serviciosReferencias->traerTipoclientes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarTipocredito($serviciosReferencias) {
   $tipocredito = $_POST['tipocredito'];
      $res = $serviciosReferencias->insertarTipocredito($tipocredito);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarTipocredito($serviciosReferencias) {
   $id = $_POST['id'];
   $tipocredito = $_POST['tipocredito'];
      $res = $serviciosReferencias->modificarTipocredito($id,$tipocredito);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTipocredito($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarTipocredito($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTipocredito($serviciosReferencias) {
   $res = $serviciosReferencias->traerTipocredito();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarTipodocumentaciones($serviciosReferencias) {
   $tipodocumentacion = $_POST['tipodocumentacion'];
      $res = $serviciosReferencias->insertarTipodocumentaciones($tipodocumentacion);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarTipodocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];
   $tipodocumentacion = $_POST['tipodocumentacion'];

      $res = $serviciosReferencias->modificarTipodocumentaciones($id,$tipodocumentacion);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTipodocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarTipodocumentaciones($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTipodocumentaciones($serviciosReferencias) {
   $res = $serviciosReferencias->traerTipodocumentaciones();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarTipoingreso($serviciosReferencias) {
   $tipoingreso = $_POST['tipoingreso'];
   $res = $serviciosReferencias->insertarTipoingreso($tipoingreso);
   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarTipoingreso($serviciosReferencias) {
   $id = $_POST['id'];
   $tipoingreso = $_POST['tipoingreso'];
   $res = $serviciosReferencias->modificarTipoingreso($id,$tipoingreso);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTipoingreso($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarTipoingreso($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTipoingreso($serviciosReferencias) {
   $res = $serviciosReferencias->traerTipoingreso();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarTipopromotores($serviciosReferencias) {
   $tipopromotor = $_POST['tipopromotor'];
   $res = $serviciosReferencias->insertarTipopromotores($tipopromotor);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarTipopromotores($serviciosReferencias) {
   $id = $_POST['id'];
   $tipopromotor = $_POST['tipopromotor'];
      $res = $serviciosReferencias->modificarTipopromotores($id,$tipopromotor);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTipopromotores($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarTipopromotores($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTipopromotores($serviciosReferencias) {
   $res = $serviciosReferencias->traerTipopromotores();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarTiposeguros($serviciosReferencias) {
   $tiposeguro = $_POST['tiposeguro'];
   $res = $serviciosReferencias->insertarTiposeguros($tiposeguro);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarTiposeguros($serviciosReferencias) {
   $id = $_POST['id'];
   $tiposeguro = $_POST['tiposeguro'];
   $res = $serviciosReferencias->modificarTiposeguros($id,$tiposeguro);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTiposeguros($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarTiposeguros($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTiposeguros($serviciosReferencias) {
   $res = $serviciosReferencias->traerTiposeguros();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarTiposolicitudes($serviciosReferencias) {
$tiposolicitud = $_POST['tiposolicitud'];
$condocumentacion = $_POST['condocumentacion'];
$tope = $_POST['tope'];
   $res = $serviciosReferencias->insertarTiposolicitudes($tiposolicitud,$condocumentacion,$tope);
if ((integer)$res > 0) {
echo '';
} else {
echo 'Hubo un error al insertar datos';
}
}


function modificarTiposolicitudes($serviciosReferencias) {
$id = $_POST['id'];
$tiposolicitud = $_POST['tiposolicitud'];
$condocumentacion = $_POST['condocumentacion'];
$tope = $_POST['tope'];
   $res = $serviciosReferencias->modificarTiposolicitudes($id,$tiposolicitud,$condocumentacion,$tope);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarTiposolicitudes($serviciosReferencias) {
$id = $_POST['id'];
   $res = $serviciosReferencias->eliminarTiposolicitudes($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function traerTiposolicitudes($serviciosReferencias) {
   $res = $serviciosReferencias->traerTiposolicitudes();

   $ar = array();
   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

////////////////////////// FIN DE TRAER DATOS ////////////////////////////////////////////////////////////

//////////////////////////  BASICO  /////////////////////////////////////////////////////////////////////////

function toArray($query)
{
       $res = array();
    while ($row = @mysql_fetch_array($query)) {
        $res[] = $row;
    }
    return $res;
}


function entrar($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	echo $serviciosUsuarios->loginUsuario($email,$pass);
}


function registrar($serviciosUsuarios) {
	$nombre			   =	$_POST['nombre'];
	$apellido		   =	$_POST['apellido'];
	$fechanacimiento	=	$_POST['fechanacimiento'];
   $telefono	      =	$_POST['telefono'];
	$email			   =	$_POST['email'];
	$sexo			      =	$_POST['sexo'];
   $codigopostal		=	$_POST['codigopostal'];

	   $res = $serviciosUsuarios->registrarSocio($nombre,$apellido,$fechanacimiento,$telefono,$email,$sexo,$codigopostal);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function insertarUsuario($serviciosUsuarios) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	   $res = $serviciosUsuarios->insertarUsuario($usuario,$password,$refroll,$email,$nombre);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function insertarUsuarios($serviciosReferencias) {
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

	   $res = $serviciosReferencias->insertarUsuarios($usuario,$password,$refroll,$email,$nombre,1);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function modificarUsuario($serviciosUsuarios) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];

   if (isset($_POST['activo'])) {
      $activo = 1;
   } else {
      $activo = 0;
   }



	echo $serviciosUsuarios->modificarUsuario($id,$usuario,$password,$refroll,$email,$nombre,$activo);
}


function enviarMail($serviciosUsuarios) {
	$email		=	$_POST['email'];
	$pass		=	$_POST['pass'];
	//$idempresa  =	$_POST['idempresa'];

	echo $serviciosUsuarios->login($email,$pass);
}

function registrarme($serviciosUsuarios, $serviciosReferencias, $serviciosValidador) {
   $error = '';

   $nombre			   =	trim($_POST['nombre']);
	$apellidopaterno  =  trim($_POST['apellidopaterno']);
   $apellidomaterno  =  trim($_POST['apellidomaterno']);
	$fechanacimiento	=	$_POST['fechanacimiento'];
   $telefono	      =	trim($_POST['telefono']);
	$email            =  trim($_POST['email']);
	$sexo			      =	$_POST['sexo'];
   $codigopostal		=	trim($_POST['codigopostal']);

   $aceptaterminos   = $_POST['terminos'];


   $pass       = $serviciosReferencias->GUID();

   $existeEmail = $serviciosUsuarios->existeUsuario($email);
   //$existeCliente = $serviciosReferencias->existeCliente($cuit);

   if ($existeEmail == 1) {
      $error .= 'El Email ingresado ya existe!
      ';
   }


   if ($aceptaterminos == 0) {
      $error .= 'Debe Aceptar los Terminos y Condiciones
      ';
   }

   if ($error == '') {
      // todo ok
      $refestadocivil = 1;
      $rfc = '0';
      $curp = '0';
      $numerocliente = '0000';
      $nacionalidad = 'Mexico';
      $refpromotores = 0;
      $refrolhogar = 1;
      $reftipoclientes = 1;
      $refentidadnacimiento = 1;
      $fechacrea = date('Y-m-d');
      $fechamodi = date('Y-m-d');
      $usuariocrea = 'Web';
      $usuariomodi = '';


         $res = $serviciosReferencias->insertarClientes($nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,0);

      // empiezo la activacion del usuarios
      $resActivacion = $serviciosUsuarios->registrarSocio($email, $pass, $apellidopaterno.' '.$apellidomaterno, $nombre, $res);

      if ((integer)$resActivacion > 0) {

         echo '';
      } else {
         echo 'Hubo un error al insertar datos ';
      }
   } else {
      // error
      echo $error;
   }
}


function devolverImagen($nroInput) {

	if( $_FILES['archivo'.$nroInput]['name'] != null && $_FILES['archivo'.$nroInput]['size'] > 0 ){
	// Nivel de errores
	  error_reporting(E_ALL);
	  $altura = 100;
	  // Constantes
	  # Altura de el thumbnail en píxeles
	  //define("ALTURA", 100);
	  # Nombre del archivo temporal del thumbnail
	  //define("NAMETHUMB", "/tmp/thumbtemp"); //Esto en servidores Linux, en Windows podría ser:
	  //define("NAMETHUMB", "c:/windows/temp/thumbtemp"); //y te olvidas de los problemas de permisos
	  $NAMETHUMB = "c:/windows/temp/thumbtemp";
	  # Servidor de base de datos
	  //define("DBHOST", "localhost");
	  # nombre de la base de datos
	  //define("DBNAME", "portalinmobiliario");
	  # Usuario de base de datos
	  //define("DBUSER", "root");
	  # Password de base de datos
	  //define("DBPASSWORD", "");
	  // Mime types permitidos
	  $mimetypes = array("image/jpeg", "image/pjpeg", "image/gif", "image/png");
	  // Variables de la foto
	  $name = $_FILES["archivo".$nroInput]["name"];
	  $type = $_FILES["archivo".$nroInput]["type"];
	  $tmp_name = $_FILES["archivo".$nroInput]["tmp_name"];
	  $size = $_FILES["archivo".$nroInput]["size"];
	  // Verificamos si el archivo es una imagen válida
	  if(!in_array($type, $mimetypes))
		die("El archivo que subiste no es una imagen válida");
	  // Creando el thumbnail
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  $img = imagecreatefromjpeg($tmp_name);
		  break;
		case $mimetypes[2]:
		  $img = imagecreatefromgif($tmp_name);
		  break;
		case $mimetypes[3]:
		  $img = imagecreatefrompng($tmp_name);
		  break;
	  }

	  $datos = getimagesize($tmp_name);

	  $ratio = ($datos[1]/$altura);
	  $ancho = round($datos[0]/$ratio);
	  $thumb = imagecreatetruecolor($ancho, $altura);
	  imagecopyresized($thumb, $img, 0, 0, 0, 0, $ancho, $altura, $datos[0], $datos[1]);
	  switch($type) {
		case $mimetypes[0]:
		case $mimetypes[1]:
		  imagejpeg($thumb, $NAMETHUMB);
			  break;
		case $mimetypes[2]:
		  imagegif($thumb, $NAMETHUMB);
		  break;
		case $mimetypes[3]:
		  imagepng($thumb, $NAMETHUMB);
		  break;
	  }
	  // Extrae los contenidos de las fotos
	  # contenido de la foto original
	  $fp = fopen($tmp_name, "rb");
	  $tfoto = fread($fp, filesize($tmp_name));
	  $tfoto = addslashes($tfoto);
	  fclose($fp);
	  # contenido del thumbnail
	  $fp = fopen($NAMETHUMB, "rb");
	  $tthumb = fread($fp, filesize($NAMETHUMB));
	  $tthumb = addslashes($tthumb);
	  fclose($fp);
	  // Borra archivos temporales si es que existen
	  //@unlink($tmp_name);
	  //@unlink(NAMETHUMB);
	} else {
		$tfoto = '';
		$type = '';
	}
	$tfoto = utf8_decode($tfoto);
	return array('tfoto' => $tfoto, 'type' => $type);
}


?>
