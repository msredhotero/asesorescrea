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


   case 'frmAjaxModificar':
      frmAjaxModificar($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios);
   break;
   case 'frmAjaxVer':
      frmAjaxVer($serviciosFunciones, $serviciosReferencias, $serviciosUsuarios);
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
   case 'insertarDocumentacionsolicitudesarchivos':
      insertarDocumentacionsolicitudesarchivos($serviciosReferencias);
   break;
   case 'modificarDocumentacionsolicitudesarchivos':
      modificarDocumentacionsolicitudesarchivos($serviciosReferencias);
   break;
   case 'eliminarDocumentacionsolicitudesarchivos':
      eliminarDocumentacionsolicitudesarchivos($serviciosReferencias);
   break;
   case 'traerDocumentacionsolicitudesarchivos':
      traerDocumentacionsolicitudesarchivos($serviciosReferencias);
   break;
   case 'traerDocumentacionsolicitudesarchivosPorId':
      traerDocumentacionsolicitudesarchivosPorId($serviciosReferencias);
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

   case 'traerUsuarios':
      traerUsuarios($serviciosReferencias);
   break;
   case 'traerUsuariosPorId':
      traerUsuariosPorId($serviciosReferencias);
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

   case 'generarCURP':
      generaCURP($serviciosReferencias, $serviciosUsuarios, $serviciosFunciones);
   break;

}
/* Fin */


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


   //pongo al usuario $activo
	$resUsuario = $serviciosUsuarios->activarUsuario($idusuario);

   // concreto la activacion
   $resConcretar = $serviciosUsuarios->eliminarActivacionusuarios($activacion);

   $resModUsuario = $serviciosReferencias->modificarClientesCorto($idcliente,$refestadocivil,$rfc,$curp,$nacionalidad,$refrolhogar,$refentidadnacimiento);

   if ($resModUsuario == true) {

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

   session_start();

   switch ($tabla) {
      case 'tbtipoubicacion':
         $modificar = "modificarTipoubicacion";
         $idTabla = "idtipoubicacion";

         $lblCambio	 	= array();
         $lblreemplazo	= array();

         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();
      break;

      case 'dbclientes':

         $modificar = "modificarClientes";
         $idTabla = "idcliente";

         $lblCambio	 	= array('codipostal','telefon2','email2');
         $lblreemplazo	= array('Cod Postal','Tel. 2','Email 2');


         $cadRef 	= '';

         $refdescripcion = array();
         $refCampo 	=  array();


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

      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   echo $formulario;
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


/* PARA Tiposolicitudes */

function insertarClientes($serviciosReferencias) {
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $email = $_POST['email'];
   $sexo = $_POST['sexo'];
   $refestadocivil = $_POST['refestadocivil'];
   $rfc = $_POST['rfc'];
   $curp = $_POST['curp'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $numerocliente = $_POST['numerocliente'];
   $nacionalidad = $_POST['nacionalidad'];
   $refpromotores = $_POST['refpromotores'];
   $refrolhogar = $_POST['refrolhogar'];
   $reftipoclientes = $_POST['reftipoclientes'];
   $refentidadnacimiento = $_POST['refentidadnacimiento'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
   $res = $serviciosReferencias->insertarClientes($nombre,$apellido,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarClientes($serviciosReferencias) {
   $id = $_POST['id'];
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
   $email = $_POST['email'];
   $sexo = $_POST['sexo'];
   $refestadocivil = $_POST['refestadocivil'];
   $rfc = $_POST['rfc'];
   $curp = $_POST['curp'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $numerocliente = $_POST['numerocliente'];
   $nacionalidad = $_POST['nacionalidad'];
   $refpromotores = $_POST['refpromotores'];
   $refrolhogar = $_POST['refrolhogar'];
   $reftipoclientes = $_POST['reftipoclientes'];
   $refentidadnacimiento = $_POST['refentidadnacimiento'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
   $res = $serviciosReferencias->modificarClientes($id,$nombre,$apellido,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
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


function insertarDocumentacionsolicitudes($serviciosReferencias) {
   $refsolicitudes = $_POST['refsolicitudes'];
   $documentacion = $_POST['documentacion'];
   $obligatoria = $_POST['obligatoria'];
   $cantidadarchivos = $_POST['cantidadarchivos'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
   $res = $serviciosReferencias->insertarDocumentacionsolicitudes($refsolicitudes,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarDocumentacionsolicitudes($serviciosReferencias) {
   $id = $_POST['id'];
   $refsolicitudes = $_POST['refsolicitudes'];
   $documentacion = $_POST['documentacion'];
   $obligatoria = $_POST['obligatoria'];
   $cantidadarchivos = $_POST['cantidadarchivos'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
   $res = $serviciosReferencias->modificarDocumentacionsolicitudes($id,$refsolicitudes,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
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


function insertarDocumentacionsolicitudesarchivos($serviciosReferencias) {
   $refsolicitudes = $_POST['refsolicitudes'];
   $refdocumentacionsolicitudes = $_POST['refdocumentacionsolicitudes'];
   $archivo = $_POST['archivo'];
   $type = $_POST['type'];
   $refestadoarchivos = $_POST['refestadoarchivos'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
   $res = $serviciosReferencias->insertarDocumentacionsolicitudesarchivos($refsolicitudes,$refdocumentacionsolicitudes,$archivo,$type,$refestadoarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}


function modificarDocumentacionsolicitudesarchivos($serviciosReferencias) {
   $id = $_POST['id'];
   $refsolicitudes = $_POST['refsolicitudes'];
   $refdocumentacionsolicitudes = $_POST['refdocumentacionsolicitudes'];
   $archivo = $_POST['archivo'];
   $type = $_POST['type'];
   $refestadoarchivos = $_POST['refestadoarchivos'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];
   $res = $serviciosReferencias->modificarDocumentacionsolicitudesarchivos($id,$refsolicitudes,$refdocumentacionsolicitudes,$archivo,$type,$refestadoarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
   if ($res == true) {
   echo '';
   } else {
   echo 'Hubo un error al modificar datos';
   }
}


function eliminarDocumentacionsolicitudesarchivos($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarDocumentacionsolicitudesarchivos($id);
   if ($res == true) {
   echo '';
   } else {
   echo 'Hubo un error al eliminar datos';
   }
}


function traerDocumentacionsolicitudesarchivos($serviciosReferencias) {
   $res = $serviciosReferencias->traerDocumentacionsolicitudesarchivos();
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


function insertarSolicitudes($serviciosReferencias) {
   $reftiposolicitudes = $_POST['reftiposolicitudes'];
   $refestadosolicitudes = $_POST['refestadosolicitudes'];
   $nombre = $_POST['nombre'];
   $apellido = $_POST['apellido'];
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
   $res = $serviciosReferencias->insertarSolicitudes($reftiposolicitudes,$refestadosolicitudes,$nombre,$apellido,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
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
   $apellido = $_POST['apellido'];
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
   $res = $serviciosReferencias->modificarSolicitudes($id,$reftiposolicitudes,$refestadosolicitudes,$nombre,$apellido,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
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

/* Fin */


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


      $res = $serviciosReferencias->insertarClientes($nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

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
