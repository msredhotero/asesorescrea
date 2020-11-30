<?php

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesNotificaciones.php');
include ('../includes/funcionesMensajes.php');
include ('../includes/validadores.php');
include ('../includes/funcionesPostal.php');
include ('../includes/funcionesComercio.php');

$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosMensajes	= new ServiciosMensajes();
$serviciosValidador        = new serviciosValidador();
$serviciosPostal        = new serviciosPostal();
$serviciosComercio      = new serviciosComercio();

$accion = $_POST['accion'];

$resV['error'] = '';
$resV['mensaje'] = '';

date_default_timezone_set('America/Mexico_City');



switch ($accion) {
   case 'llenarCombosGral':
      llenarCombosGral($serviciosReferencias, $serviciosUsuarios,$serviciosFunciones,$serviciosPostal);
   break;

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
        modificarUsuario($serviciosReferencias);
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
   case 'activarUsuarioCliente':
      activarUsuarioCliente($serviciosUsuarios, $serviciosReferencias);
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
   insertarAsesores($serviciosReferencias, $serviciosUsuarios);
   break;
   case 'modificarAsesores':
   modificarAsesores($serviciosReferencias, $serviciosUsuarios);
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
   case 'eliminarPostulantesDefinitivo':
   eliminarPostulantesDefinitivo($serviciosReferencias);
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
   case 'traerDocumentacionPorPostulanteDocumentacionEspecifica':
   traerDocumentacionPorPostulanteDocumentacionEspecifica($serviciosReferencias);
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
   case 'modificarPostulanteUnicaDocumentacion':
      modificarPostulanteUnicaDocumentacion($serviciosReferencias);
   break;
   case 'modificarEstadoDocumentacionPostulante':
      modificarEstadoDocumentacionPostulante($serviciosReferencias);
   break;

   case 'presentarDocumentacionI':
      presentarDocumentacionI($serviciosReferencias, $serviciosUsuarios);
   break;

   case 'migrarPostulante':
      migrarPostulante($serviciosReferencias, $serviciosMensajes);
   break;

   case 'enviarAlerta':
      enviarAlerta($serviciosReferencias, $serviciosUsuarios);
   break;
   /* nuevo 15/01/2020 */
   case 'insertarReferentes':
      insertarReferentes($serviciosReferencias);
   break;
   case 'modificarReferentes':
      modificarReferentes($serviciosReferencias);
   break;
   case 'eliminarReferentes':
      eliminarReferentes($serviciosReferencias);
   break;
   case 'insertarOportunidades':
      insertarOportunidades($serviciosReferencias);
   break;
   case 'modificarOportunidades':
      modificarOportunidades($serviciosReferencias,$serviciosNotificaciones,$serviciosUsuarios);
   break;
   case 'eliminarOportunidades':
      eliminarOportunidades($serviciosReferencias);
   break;
   case 'insertarEntrevistaoportunidades':
      insertarEntrevistaoportunidades($serviciosReferencias);
   break;
   case 'modificarEntrevistaoportunidades':
      modificarEntrevistaoportunidades($serviciosReferencias);
   break;
   case 'eliminarEntrevistaoportunidades':
      eliminarEntrevistaoportunidades($serviciosReferencias);
   break;
   case 'traerEntrevistaoportunidadesPorId':
      traerEntrevistaoportunidadesPorId($serviciosReferencias);
   break;

   case 'frmAjaxNuevo':
      frmAjaxNuevo($serviciosReferencias, $serviciosFunciones);
   break;

   case 'traerOportunidadesPorId':
      traerOportunidadesPorId($serviciosReferencias);
   break;

   case 'insertarReclutadorasores':
      insertarReclutadorasores($serviciosReferencias);
   break;
   case 'modificarReclutadorasores':
      modificarReclutadorasores($serviciosReferencias);
   break;
   case 'eliminarReclutadorasores':
      eliminarReclutadorasores($serviciosReferencias);
   break;
   case 'insertarAsociados':
      insertarAsociados($serviciosReferencias,$serviciosUsuarios);
   break;
   case 'modificarAsociados':
      modificarAsociados($serviciosReferencias,$serviciosUsuarios);
   break;
   case 'eliminarAsociados':
      eliminarAsociados($serviciosReferencias);
   break;

   case 'eliminarDocumentacionAsociado':
      eliminarDocumentacionAsociado($serviciosReferencias);
   break;
   case 'traerDocumentacionPorAsociadoDocumentacion':
      traerDocumentacionPorAsociadoDocumentacion($serviciosReferencias);
   break;
   case 'modificarEstadoDocumentacionAsociados':
      modificarEstadoDocumentacionAsociados($serviciosReferencias);
   break;
   case 'modificarAsociadoUnicaDocumentacion':
      modificarAsociadoUnicaDocumentacion($serviciosReferencias);
   break;

   /****   	notificaciones * *************/
   case 'marcarNotificacion':
   	marcarNotificacion($serviciosNotificaciones);
	break;
   case 'generarNotificacion':
   	generarNotificacion($serviciosNotificaciones);
	break;
   /****			fin 				******/

   case 'insertarAlertas':
      insertarAlertas($serviciosReferencias);
   break;
   case 'modificarAlertas':
      modificarAlertas($serviciosReferencias);
   break;
   case 'eliminarAlertas':
      eliminarAlertas($serviciosReferencias);
   break;

   case 'insertarCotizaciones':
      insertarCotizaciones($serviciosReferencias);
   break;
   case 'modificarCotizaciones':
      modificarCotizaciones($serviciosReferencias);
   break;
   case 'eliminarCotizaciones':
      eliminarCotizaciones($serviciosReferencias);
   break;
   case 'rechazarCotizacion':
      rechazarCotizacion($serviciosReferencias);
   break;
   case 'rechazarCotizacionValidacion':
      rechazarCotizacionValidacion($serviciosReferencias, $serviciosMensajes);
   break;


   case 'insertarAsociadostemporales':
      insertarAsociadostemporales($serviciosReferencias,$serviciosUsuarios);
   break;
   case 'modificarAsociadostemporales':
      modificarAsociadostemporales($serviciosReferencias,$serviciosUsuarios);
   break;
   case 'eliminarAsociadostemporales':
      eliminarAsociadostemporales($serviciosReferencias);
   break;

   case 'eliminarDocumentacionCotizacion':
      eliminarDocumentacionCotizacion($serviciosReferencias);
   break;
   case 'traerDocumentacionPorCotizacionDocumentacion':
      traerDocumentacionPorCotizacionDocumentacion($serviciosReferencias);
   break;
   case 'modificarEstadoDocumentacionCotizaciones':
      modificarEstadoDocumentacionCotizaciones($serviciosReferencias, $serviciosMensajes);
   break;
   case 'modificarCotizacionUnicaDocumentacion':
      modificarCotizacionUnicaDocumentacion($serviciosReferencias);
   break;

   case 'traerEntrevistaoportunidadesPorOportunidad':
      traerEntrevistaoportunidadesPorOportunidad($serviciosReferencias);
   break;

   case 'Reasignar':
      Reasignar($serviciosReferencias,$serviciosUsuarios,$serviciosFunciones);
   break;
   case 'asinar':
      asinar($serviciosReferencias);
   break;

   case 'insertarDirectorioasesores':
      insertarDirectorioasesores($serviciosReferencias);
   break;
   case 'modificarDirectorioasesores':
      modificarDirectorioasesores($serviciosReferencias);
   break;
   case 'eliminarDirectorioasesores':
      eliminarDirectorioasesores($serviciosReferencias);
   break;

   case 'insertarDomicilios':
      insertarDomicilios($serviciosReferencias);
   break;
   case 'modificarDomicilios':
      modificarDomicilios($serviciosReferencias);
   break;
   case 'eliminarDomicilios':
      eliminarDomicilios($serviciosReferencias);
   break;
   case 'traerDomiciliosPorTablaReferencia':
   traerDomiciliosPorTablaReferencia($serviciosReferencias);
   break;

   case 'modificarAsesoresunicaUnicaDocumentacion':
      modificarAsesoresunicaUnicaDocumentacion($serviciosReferencias);
   break;
   case 'modificarEstadoDocumentacionasesoresunica':
      modificarEstadoDocumentacionasesoresunica($serviciosReferencias);
   break;
   case 'traerDocumentacionPorAsesoresunicaDocumentacion':
      traerDocumentacionPorAsesoresunicaDocumentacion($serviciosReferencias);
   break;
   case 'eliminarDocumentacionasesoresunica':
      eliminarDocumentacionasesoresunica($serviciosReferencias);
   break;
   case 'traerDirectorio':
      traerDirectorio($serviciosReferencias);
   break;

   case 'Revision':
      Revision($serviciosReferencias);
   break;

   case 'insertarPerfilasesores':
      insertarPerfilasesores($serviciosReferencias);
   break;
   case 'modificarPerfilasesores':
      modificarPerfilasesores($serviciosReferencias);
   break;
   case 'eliminarPerfilasesores':
      eliminarPerfilasesores($serviciosReferencias);
   break;

   case 'traerPerfilasesoresPorIdImagenCompleto':
      traerPerfilasesoresPorIdImagenCompleto($serviciosReferencias);
   break;

   case 'insertarEspecialidades':
      insertarEspecialidades($serviciosReferencias);
   break;
   case 'modificarEspecialidades':
      modificarEspecialidades($serviciosReferencias);
   break;
   case 'eliminarEspecialidades':
      eliminarEspecialidades($serviciosReferencias);
   break;

   case 'insertarComisiones':
      insertarComisiones($serviciosReferencias);
   break;
   case 'modificarComisiones':
      modificarComisiones($serviciosReferencias);
   break;
   case 'eliminarComisiones':
      eliminarComisiones($serviciosReferencias);
   break;

   case 'traerPersonaPorTabla':
      traerPersonaPorTabla($serviciosReferencias, $serviciosFunciones);
   break;

   case 'insertarConstancias':
      insertarConstancias($serviciosReferencias);
   break;
   case 'modificarConstancias':
      modificarConstancias($serviciosReferencias);
   break;
   case 'eliminarConstancias':
      eliminarConstancias($serviciosReferencias);
   break;

   case 'insertarBonogestion':
      insertarBonogestion($serviciosReferencias);
   break;
   case 'modificarBonogestion':
      modificarBonogestion($serviciosReferencias);
   break;
   case 'eliminarBonogestion':
      eliminarBonogestion($serviciosReferencias);
   break;

   case 'insertarConstanciasseguimiento':
      insertarConstanciasseguimiento($serviciosReferencias);
   break;
   case 'modificarConstanciasseguimiento':
      modificarConstanciasseguimiento($serviciosReferencias,$serviciosMensajes);
   break;
   case 'eliminarConstanciasseguimiento':
      eliminarConstanciasseguimiento($serviciosReferencias);
   break;
   case 'modificarConstanciasseguimientoFinalizar':
      modificarConstanciasseguimientoFinalizar($serviciosReferencias);
   break;

   case 'traerClientescarteraPorCliente':
      traerClientescarteraPorCliente($serviciosReferencias);
   break;
   case 'traerProductosPorTipo':
      traerProductosPorTipo($serviciosReferencias,$serviciosFunciones);
   break;

   case 'modificarVentas':
      modificarVentas($serviciosReferencias);
   break;
   case 'eliminarVentas':
      eliminarVentas($serviciosReferencias);
   break;

   case 'insertarPeriodicidadventas':
      insertarPeriodicidadventas($serviciosReferencias);
   break;
   case 'modificarPeriodicidadventas':
      modificarPeriodicidadventas($serviciosReferencias);
   break;
   case 'eliminarPeriodicidadventas':
      eliminarPeriodicidadventas($serviciosReferencias);
   break;

   case 'insertarPeriodicidadventasdetalle':
      insertarPeriodicidadventasdetalle($serviciosReferencias);
   break;
   case 'modificarPeriodicidadventasdetalle':
      modificarPeriodicidadventasdetalle($serviciosReferencias);
   break;
   case 'eliminarPeriodicidadventasdetalle':
      eliminarPeriodicidadventasdetalle($serviciosReferencias);
   break;

   case 'traerTipoproductoramaPorTipoProducto':
      traerTipoproductoramaPorTipoProducto($serviciosReferencias, $serviciosFunciones);
   break;

   case 'modificarEstadoDocumentacionVentas':
      modificarEstadoDocumentacionVentas($serviciosReferencias);
   break;
   case 'modificarEstadoDocumentacionPagos':
      modificarEstadoDocumentacionPagos($serviciosReferencias);
   break;
   case 'traerDocumentacionPorVentaDocumentacion':
      traerDocumentacionPorVentaDocumentacion($serviciosReferencias);
   break;
   case 'traerDocumentacionPorPagoDocumentacion':
      traerDocumentacionPorPagoDocumentacion($serviciosReferencias);
   break;
   case 'eliminarDocumentacionVenta':
      eliminarDocumentacionVenta($serviciosReferencias);
   break;
   case 'modificarVentaUnicaDocumentacion':
      modificarVentaUnicaDocumentacion($serviciosReferencias);
   break;

   case 'insertarProductos':
      insertarProductos($serviciosReferencias);
   break;
   case 'modificarProductos':
      modificarProductos($serviciosReferencias);
   break;
   case 'eliminarProductos':
      eliminarProductos($serviciosReferencias);
   break;

   case 'insertarCuestionariodetalle':
      insertarCuestionariodetalle($serviciosReferencias);
   break;
   case 'modificarCuestionariodetalle':
      modificarCuestionariodetalle($serviciosReferencias);
   break;
   case 'eliminarCuestionariodetalle':
      eliminarCuestionariodetalle($serviciosReferencias);
   break;
   case 'traerCuestionariodetalle':
      traerCuestionariodetalle($serviciosReferencias);
   break;
   case 'traerCuestionariodetallePorId':
      traerCuestionariodetallePorId($serviciosReferencias);
   break;
   case 'insertarCuestionarios':
      insertarCuestionarios($serviciosReferencias);
   break;
   case 'modificarCuestionarios':
      modificarCuestionarios($serviciosReferencias);
   break;
   case 'eliminarCuestionarios':
      eliminarCuestionarios($serviciosReferencias);
   break;
   case 'eliminarCuestionariosDefinitivo':
      eliminarCuestionariosDefinitivo($serviciosReferencias);
   break;
   case 'insertarPreguntascuestionario':
      insertarPreguntascuestionario($serviciosReferencias);
   break;
   case 'modificarPreguntascuestionario':
      modificarPreguntascuestionario($serviciosReferencias);
   break;
   case 'eliminarPreguntascuestionario':
      eliminarPreguntascuestionario($serviciosReferencias);
   break;
   case 'eliminarPreguntascuestionarioDefinitivo':
      eliminarPreguntascuestionarioDefinitivo($serviciosReferencias);
   break;
   case 'traerPreguntascuestionario':
      traerPreguntascuestionario($serviciosReferencias);
   break;
   case 'traerPreguntascuestionarioPorId':
      traerPreguntascuestionarioPorId($serviciosReferencias);
   break;
   case 'insertarRespuestascuestionario':
      insertarRespuestascuestionario($serviciosReferencias);
   break;
   case 'modificarRespuestascuestionario':
      modificarRespuestascuestionario($serviciosReferencias);
   break;
   case 'eliminarRespuestascuestionario':
      eliminarRespuestascuestionario($serviciosReferencias);
   break;
   case 'traerRespuestascuestionario':
      traerRespuestascuestionario($serviciosReferencias);
   break;
   case 'traerRespuestascuestionarioPorId':
      traerRespuestascuestionarioPorId($serviciosReferencias);
   break;

   case 'cuestionario':
      cuestionario($serviciosReferencias);
   break;
   case 'validarCuestionario':
      validarCuestionario($serviciosReferencias);
   break;
   case 'traerRespuestascuestionarioPorPregunta':
      traerRespuestascuestionarioPorPregunta($serviciosReferencias,$serviciosFunciones);
   break;
   case 'traerPreguntascuestionarioPorCuestionario':
      traerPreguntascuestionarioPorCuestionario($serviciosReferencias,$serviciosFunciones);
   break;

   case 'insertarProductosexclusivos':
      insertarProductosexclusivos($serviciosReferencias);
   break;
   case 'modificarProductosexclusivos':
      modificarProductosexclusivos($serviciosReferencias);
   break;
   case 'eliminarProductosexclusivos':
      eliminarProductosexclusivos($serviciosReferencias);
   break;
   case 'modificarClienteUnicaDocumentacion':
      modificarClienteUnicaDocumentacion($serviciosReferencias);
   break;

   case 'modificarEstadoDocumentacionClientes':
      modificarEstadoDocumentacionClientes($serviciosReferencias);
   break;
   case 'traerDocumentacionPorClienteDocumentacion':
      traerDocumentacionPorClienteDocumentacion($serviciosReferencias);
   break;

   case 'insertarComerciofin':
      insertarComerciofin($serviciosComercio);
   break;
   case 'modificarComerciofin':
      modificarComerciofin($serviciosComercio);
   break;
   case 'eliminarComerciofin':
      eliminarComerciofin($serviciosComercio);
   break;
   case 'traerComerciofin':
      traerComerciofin($serviciosComercio);
   break;
   case 'traerComerciofinPorId':
      traerComerciofinPorId($serviciosComercio);
   break;
   case 'insertarComercioinicio':
      insertarComercioinicio($serviciosComercio);
   break;
   case 'modificarComercioinicio':
      modificarComercioinicio($serviciosComercio);
   break;
   case 'eliminarComercioinicio':
      eliminarComercioinicio($serviciosComercio);
   break;
   case 'traerComercioinicio':
      traerComercioinicio($serviciosComercio);
   break;
   case 'traerComercioinicioPorId':
      traerComercioinicioPorId($serviciosComercio);
   break;

   case 'traerPreguntassenciblesPorCuestionario':
      traerPreguntassenciblesPorCuestionario($serviciosReferencias, $serviciosFunciones);
   break;
   case 'nuevoOrdenPreguntas':
      nuevoOrdenPreguntas($serviciosReferencias);
   break;

   case 'insertarMejorarcondiciones':
      insertarMejorarcondiciones($serviciosReferencias);
   break;

   case 'traerAseguradosPorCliente':
      traerAseguradosPorCliente($serviciosReferencias, $serviciosFunciones);
   break;
   case 'traerBeneficiariosPorCliente':
      traerBeneficiariosPorCliente($serviciosReferencias, $serviciosFunciones);
   break;
   case 'insertarAsegurados':
      insertarAsegurados($serviciosReferencias);
   break;
   case 'modificarAsegurados':
      modificarAsegurados($serviciosReferencias);
   break;
   case 'eliminarAsegurados':
      eliminarAsegurados($serviciosReferencias);
   break;
   case 'cuestionarioPersonas':
      cuestionarioPersonas($serviciosReferencias);
   break;
   case 'validarCuestionarioPersona':
      validarCuestionarioPersona($serviciosReferencias);
   break;
   case 'traerAseguradosPorId':
      traerAseguradosPorId($serviciosReferencias,$serviciosFunciones);
   break;

   case 'EnviarEmailInfo':
      EnviarEmailInfo($serviciosReferencias, $serviciosUsuarios);
   break;
   case 'ModificarTelMovilCliente':
      ModificarTelMovilCliente($serviciosReferencias);
   break;

   case 'insertarLead':
      insertarLead($serviciosReferencias);
   break;
   case 'modificarLead':
      modificarLead($serviciosReferencias);
   break;
   case 'eliminarLead':
      eliminarLead($serviciosReferencias);
   break;
   case 'rutaCotizar':
      rutaCotizar($serviciosReferencias);
   break;
   case 'aceptarClienteCotizacion':
      aceptarClienteCotizacion($serviciosReferencias, $serviciosMensajes);
   break;
   case 'generaNotificacion':
      generaNotificacion($serviciosReferencias, $serviciosMensajes, $serviciosNotificaciones,$serviciosUsuarios);
   break;

   case 'rechazaCotizacionCliente':
      rechazaCotizacionCliente($serviciosReferencias);
   break;
   case 'enviarCotizacion':
      enviarCotizacion($serviciosReferencias, $serviciosUsuarios, $serviciosMensajes);
   break;
   case 'traerClientesCotizador':
      traerClientesCotizador($serviciosReferencias, $serviciosFunciones);
   break;
   case 'modificarCotizacionesPorCampo':
      modificarCotizacionesPorCampo($serviciosReferencias);
   break;
   case 'modificarCotizacionesPorCampoRechazoDefinitivo':
      modificarCotizacionesPorCampoRechazoDefinitivo($serviciosReferencias);
   break;
   case 'traerInformeDeDocumentaciones':
      traerInformeDeDocumentaciones($serviciosReferencias);
   break;
   case 'modificarEstadoDeRechazopostulantes':
     modificarEstadoDeRechazopostulantes($serviciosReferencias);
   break;

   case 'modificoAseguradoPorCotizacion':
      modificoAseguradoPorCotizacion($serviciosReferencias);
   break;
   case 'guardarMetodoDePagoPorCotizacion':
      guardarMetodoDePagoPorCotizacion($serviciosReferencias);
   break;

   case 'insertarValoredad':
      insertarValoredad($serviciosReferencias);
   break;
   case 'modificarValoredad':
      modificarValoredad($serviciosReferencias);
   break;
   case 'eliminarValoredad':
      eliminarValoredad($serviciosReferencias);
   break;

   case 'modPassword':
      modPassword($serviciosReferencias);
   break;
   case 'modDomicilio':
      modDomicilio($serviciosReferencias);
   break;
   case 'ineCargadoCotizacion':
      ineCargadoCotizacion($serviciosReferencias);
   break;
   case 'insertarTokens':
      insertarTokens($serviciosReferencias);
   break;
   case 'reenviarTokens':
      reenviarTokens($serviciosReferencias);
   break;
   case 'insertarFirmarcontratos':
      insertarFirmarcontratos($serviciosReferencias);
   break;
   case 'traerDocumentacionPorFamiliarDocumentacion':
      traerDocumentacionPorFamiliarDocumentacion($serviciosReferencias);
   break;
   case 'modificarFamiliarUnicaDocumentacion':
      modificarFamiliarUnicaDocumentacion($serviciosReferencias);
   break;
   case 'modificarEstadoDocumentacionFamiliares':
      modificarEstadoDocumentacionFamiliares($serviciosReferencias);
   break;
   case 'eliminarDocumentacionFamiliar':
      eliminarDocumentacionFamiliar($serviciosReferencias);
   break;

   case 'insertarCuentasbancarias':
      insertarCuentasbancarias($serviciosReferencias);
   break;
   case 'modificarCuentasbancarias':
      modificarCuentasbancarias($serviciosReferencias);
   break;
   case 'eliminarCuentasbancarias':
      eliminarCuentasbancarias($serviciosReferencias);
   break;
   case 'traerPagosPorId':
      traerPagosPorId($serviciosReferencias);
   break;
   case 'modificarPagos':
      modificarPagos($serviciosReferencias);
   break;
   case 'insertarVentas':
      insertarVentas($serviciosReferencias);
   break;
   case 'cambiarMetodoDePago':
      cambiarMetodoDePago($serviciosReferencias);
   break;
   case 'verificarFirmasPendientes':
      verificarFirmasPendientes($serviciosReferencias);
   break;
   case 'insertarPeriodicidadventaspagos':
      insertarPeriodicidadventaspagos($serviciosReferencias);
   break;
   case 'modificarPeriodicidadventaspagos':
      modificarPeriodicidadventaspagos($serviciosReferencias);
   break;
   case 'eliminarPeriodicidadventaspagos':
      eliminarPeriodicidadventaspagos($serviciosReferencias);
   break;
   case 'avisarInbursa':
      avisarInbursa($serviciosReferencias, $serviciosUsuarios);
   break;

   case 'devolverCamposTabla':
      devolverCamposTabla($serviciosReferencias, $serviciosFunciones);
   break;

   case 'insertarSolicitudesrespuestas':
      insertarSolicitudesrespuestas($serviciosReferencias);
   break;
   case 'modificarSolicitudesrespuestas':
      modificarSolicitudesrespuestas($serviciosReferencias);
   break;
   case 'eliminarSolicitudesrespuestas':
      eliminarSolicitudesrespuestas($serviciosReferencias);
   break;
   case 'modificarRespuestascuestionarioSolicitud':
      modificarRespuestascuestionarioSolicitud($serviciosReferencias);
   break;
   case 'mostrarComprobanteDePago':
      mostrarComprobanteDePago($serviciosReferencias);
   break;
   case 'enviarFacturaAlCliente':
      enviarFacturaAlCliente($serviciosReferencias);
   break;
   case 'modificarPeriodicidadventasdetalleEstado':
      modificarPeriodicidadventasdetalleEstado($serviciosReferencias);
   break;

   case 'avisarClientePoliza':
      avisarClientePoliza($serviciosReferencias, $serviciosUsuarios);
   break;
   case 'concluirProceso':
      concluirProceso($serviciosReferencias);
   break;
   case 'generarEndoso':
      generarEndoso($serviciosReferencias);
   break;
   case 'generarRenovacion':
      generarRenovacion($serviciosReferencias);
   break;
   case 'verificaPolizaDatosCargados':
      verificaPolizaDatosCargados($serviciosReferencias);
   break;
   case 'enviarRenovacionCliente':
      enviarRenovacionCliente($serviciosReferencias);
   break;

   case 'guardarMetodoDePagoPorRecibo':
      guardarMetodoDePagoPorRecibo($serviciosReferencias);
   break;

   case 'cambiarMetodoDePagoRecibos':
      cambiarMetodoDePagoRecibos($serviciosReferencias);
   break;

   case 'insertarSiniestros':
   insertarSiniestros($serviciosReferencias);
   break;
   case 'modificarSiniestros':
   modificarSiniestros($serviciosReferencias);
   break;
   case 'eliminarSiniestros':
   eliminarSiniestros($serviciosReferencias);
   break;
}
/* FinFinFin */

function insertarSiniestros($serviciosReferencias) {
   $refventas = $_POST['refventas'];
   $refestadosiniestro = $_POST['refestadosiniestro'];
   $monto = $_POST['monto'];
   $fechasiniestro = $_POST['fechasiniestro'];
   $fechaaplicacion = $_POST['fechaaplicacion'];
   $res = $serviciosReferencias->insertarSiniestros($refventas,$refestadosiniestro,$monto,$fechasiniestro,$fechaaplicacion);
   if ((integer)$res > 0) {
   echo '';
   } else {
   echo 'Hubo un error al insertar datos';
   }
}

function modificarSiniestros($serviciosReferencias) {
   $id = $_POST['id'];
   $refventas = $_POST['refventas'];
   $refestadosiniestro = $_POST['refestadosiniestro'];
   $monto = $_POST['monto'];
   $fechasiniestro = $_POST['fechasiniestro'];
   $fechaaplicacion = $_POST['fechaaplicacion'];
   $res = $serviciosReferencias->modificarSiniestros($id,$refventas,$refestadosiniestro,$monto,$fechasiniestro,$fechaaplicacion);
   if ($res == true) {
   echo '';
   } else {
   echo 'Hubo un error al modificar datos';
   }
}

function eliminarSiniestros($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarSiniestros($id);
   if ($res == true) {
   echo '';
   } else {
   echo 'Hubo un error al eliminar datos';
   }
}

function cambiarMetodoDePagoRecibos($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->guardarMetodoDePagoPorRecibo($id,0);

   if ($res) {
      $resV['error'] = false;
      $resV['url'] = 'metodopago.php?id='.$id;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo cambiar el metodo de pago, intente nuevamente';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}


function guardarMetodoDePagoPorRecibo($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $metodopago = $_POST['metodopago'];

   $resRecibo = $serviciosReferencias->guardarMetodoDePagoPorRecibo($id,$metodopago);

   $url = '';
   switch ($metodopago) {
      case 1:
         $url = 'comercio_fin.php?id='.$id;
      break;
      case 2:
         $url = 'subirdocumentacioni.php?id='.$id.'&iddocumentacion=39';
      break;
   }

   if ($resRecibo) {
      $resV['error'] = false;
      $resV['url'] = $url;

   } else {
      $resV['error'] = true;

   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function enviarRenovacionCliente($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerVentasPorIdCompleto($id);


   $url = 'listadopolizas/poliza.php?id='.$id;

   $nropoliza = mysql_result($res,0,'nropoliza');

   $email = mysql_result($res,0,'email');

   $refusuarios = mysql_result($res,0,'refusuarios');

   $token = $serviciosReferencias->GUID();
   $resAutoLogin = $serviciosReferencias->insertarAutologin($refusuarios,$token,$url,'0');

   $cuerpo = '';

   $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

   $cuerpo .= "
   <style>
   	body { font-family: 'Lato', sans-serif; }
   	header { font-family: 'Prata', serif; }
   </style>";

   $cuerpo .= '<body>';

   $cuerpo .= '<h3><small><p>Aqui tienes tu Poliza Renovada '.$nropoliza.'</small></h3><p>';

   $cuerpo .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</h4>';

	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

   $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

   $cuerpo .= '</body>';



   $retorno = $serviciosReferencias->enviarEmail($email,utf8_decode('Renovación de Poliza Nro: ').$nropoliza,utf8_decode($cuerpo));

   if ((integer)$resAutoLogin > 0) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function verificaPolizaDatosCargados($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->verificaPolizaDatosCargados($id);

   $resV['verificador'] = $res;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function generarRenovacion($serviciosReferencias) {
   session_start();

   $refcotizaciones = $_POST['refcotizaciones'];
   $refestadoventa = 6; // fijo porque recien empieza
   $primaneta = ($_POST['primaneta'] == '' ? 0 : $_POST['primaneta']);
   $primatotal = ($_POST['primatotal'] == '' ? 0 : $_POST['primatotal']);
   $fechavencimientopoliza = $_POST['fechavencimientopoliza'];
   $nropoliza = $_POST['nropoliza'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $foliotys = $_POST['foliotys'];
   $foliointerno = $serviciosReferencias->generaFolioInterno();

   if (isset($_POST['refproductosaux'])) {
      $refproductosaux = $_POST['refproductosaux'];
   } else {
      $refproductosaux = 0;
   }

   $refventas = 0;

   $refventaviejo = $_POST['refventaviejo'];

   $version = $serviciosReferencias->generarVersion($refventas);

   $observaciones = $_POST['observaciones'];
   $vigenciadesde = $_POST['vigenciadesde'];

   $res = $serviciosReferencias->insertarVentas($refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$refventas,$version,$observaciones,$vigenciadesde);


   if ((integer)$res > 0) {
      $resRenovacion = $serviciosReferencias->insertarRenovaciones($refventaviejo,$res,date('Y-m-d H:i:s'));
      $resP = $serviciosReferencias->insertarPeriodicidadventasPorVenta($res,$refventaviejo);
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'Se genero un problema el crear el endoso, verifique';

   }


   header('Content-type: application/json');
   echo json_encode($resV);

}

function generarEndoso($serviciosReferencias) {
   session_start();
   $id = $_POST['id'];

   $resVenta = $serviciosReferencias->traerVentasPorId($id);
   $versionvieja = mysql_result($resVenta,0,'version');

   $refcotizaciones = $_POST['refcotizaciones'];
   $refestadoventa = $_POST['refestadoventa'];
   $primaneta = ($_POST['primaneta'] == '' ? 0 : $_POST['primaneta']);
   $primatotal = ($_POST['primatotal'] == '' ? 0 : $_POST['primatotal']);
   $fechavencimientopoliza = $_POST['fechavencimientopoliza'];
   $nropoliza = $_POST['nropoliza'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $foliotys = $_POST['foliotys'];
   $foliointerno = $serviciosReferencias->generaFolioInterno();


   if (isset($_POST['refproductosaux'])) {
      $refproductosaux = $_POST['refproductosaux'];
   } else {
      $refproductosaux = 0;
   }

   $refventas = $id;

   $version = $_POST['versionnueva'];

   $observaciones = $_POST['observaciones'];
   $vigenciadesde = $_POST['vigenciadesde'];

   $res = $serviciosReferencias->generarEndoso($id,$version,$refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$versionvieja,$observaciones,$vigenciadesde);

   if ((integer)$res > 0) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'Se genero un problema el crear el endoso, verifique';

   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function concluirProceso($serviciosReferencias) {
   session_start();
   $id = $_POST['idrecibo'];
   $idestado = $_POST['idestado'];

   $res = $serviciosReferencias->modificarPeriodicidadventasdetalleEstado($id,$idestado,$_SESSION['usua_sahilices'],date('Y-m-d H:i:s'));

   $resV['error'] = false;


   header('Content-type: application/json');
   echo json_encode($resV);
}

function avisarClientePoliza($serviciosReferencias, $serviciosUsuarios) {
   $id  = $_POST['idventa'];

   $resultado 		= 	$serviciosReferencias->traerVentasPorIdCompleto($id);

   $nropoliza = mysql_result($resultado,0,'nropoliza');

   $refusuarios = mysql_result($resultado,0,'refusuarios');

   $email = mysql_result($resultado,0,'email');

   $url = "listadopolizas/poliza.php?id=".$id;
   $token = $serviciosReferencias->GUID();
   $resAutoLogin = $serviciosReferencias->insertarAutologin($refusuarios,$token,$url,'0');


   $cuerpo = '';

   $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

   $cuerpo .= "
   <style>
   	body { font-family: 'Lato', sans-serif; }
   	header { font-family: 'Prata', serif; }
   </style>";

   $cuerpo .= '<body>';

   $cuerpo .= '<h3><small><p>Ya cargamos tu poliza a la plataforma, tú poliza es: <b>'.$nropoliza.'</b></small></h3><p>';

   $cuerpo .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</h4>';

	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

   $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

   $cuerpo .= '</body>';

   // por ahora corregir email
   //$email = 'msredhotero@gmail.com';

   $retorno = $serviciosReferencias->enviarEmail($email,'Ya cargamos tú poliza: '.$nropoliza,utf8_decode($cuerpo));


   $resV['error'] = false;


   header('Content-type: application/json');
   echo json_encode($resV);


}

function modificarPeriodicidadventasdetalleEstado($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refestadopago = $_POST['refestadopago'];

   $res = $serviciosReferencias->modificarPeriodicidadventasdetalleEstado($id,$refestadopago,$_SESSION['usua_sahilices'],date('Y-m-d H:m:s'));

   if ($res) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
   }


   header('Content-type: application/json');
   echo json_encode($resV);

}

function enviarFacturaAlCliente($serviciosReferencias) {
   $email = $_POST['email'];
   $url = $_POST['url'];
   $idcliente = $_POST['idcliente'];
   $nropoliza = $_POST['nropoliza'];
   $idpago = $_POST['idpago'];

   $resFechaReal = $serviciosReferencias->marcarFechaPagoRealInbursa($idpago);

   $resCliente = $serviciosReferencias->traerClientesPorId($idcliente);

   $refusuarios = mysql_result($resCliente,0,'refusuarios');

   $token = $serviciosReferencias->GUID();
   $resAutoLogin = $serviciosReferencias->insertarAutologin($refusuarios,$token,$url,'0');

   $cuerpo = '';

   $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

   $cuerpo .= "
   <style>
   	body { font-family: 'Lato', sans-serif; }
   	header { font-family: 'Prata', serif; }
   </style>";

   $cuerpo .= '<body>';

   $cuerpo .= '<h3><small><p>Aqui tienes tu Factura Digital de la poliza '.$nropoliza.'</small></h3><p>';

   $cuerpo .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</h4>';

	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

   $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

   $cuerpo .= '</body>';



   $retorno = $serviciosReferencias->enviarEmail($email,'Factura Poliza Nro: '.$nropoliza,utf8_decode($cuerpo));

   if ((integer)$resAutoLogin > 0) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function mostrarComprobanteDePago($serviciosReferencias) {
   $id = $_POST['id'];

   $resultado = $serviciosReferencias->traerPagosPorId($id);

   if (mysql_result($resultado,0,'archivos') == '') {
   	$resV['error'] = true;
   } else {
   	$resV['error'] = false;

   	if (mysql_result($resultado,0,'refcuentasbancarias') == 0) {

   		$urlArchivo = '../../reportes/rptFacturaPagoOnline.php?token='.mysql_result($resultado,0,'token');


   	}
   	if (mysql_result($resultado,0,'refcuentasbancarias') == 1) {
   		$urlArchivo = '../../archivos/comprobantespago/'.mysql_result($resultado,0,'idreferencia').'/'.mysql_result($resultado,0,'archivos');
   	}

      $resV['url'] = $urlArchivo;
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarRespuestascuestionarioSolicitud($serviciosReferencias) {
   $id = $_POST['id'];
   $idsolicitud = $_POST['idsolicitud'];

   $res = $serviciosReferencias->modificarRespuestascuestionarioSolicitud($id, $idsolicitud);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function insertarSolicitudesrespuestas($serviciosReferencias) {
   $refsolicitudpdf = $_POST['refsolicitudpdf'];
   $pagina = $_POST['pagina'];
   $sector = $_POST['sector'];
   $x = $_POST['x'];
   $y = $_POST['y'];
   $nombre = $_POST['nombre'];
   $default = $_POST['default'];
   $pregunta = $_POST['pregunta'];
   $reftabla = $_POST['reftabla'];
   $camporeferencia = $_POST['camporeferencia'];
   $fijo = $_POST['fijo'];

   $res = $serviciosReferencias->insertarSolicitudesrespuestas($refsolicitudpdf,$pagina,$sector,$x,$y,$nombre,$default,$pregunta,$reftabla,$camporeferencia);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos ';
   }
}

function modificarSolicitudesrespuestas($serviciosReferencias) {
   $id = $_POST['id'];
   $refsolicitudpdf = $_POST['refsolicitudpdf'];
   $pagina = $_POST['pagina'];
   $sector = $_POST['sector'];
   $x = $_POST['x'];
   $y = $_POST['y'];
   $nombre = $_POST['nombre'];
   $default = $_POST['default'];
   $pregunta = $_POST['pregunta'];
   $reftabla = $_POST['reftabla'];
   $camporeferencia = $_POST['camporeferencia'];
   $fijo = $_POST['fijo'];

   $res = $serviciosReferencias->modificarSolicitudesrespuestas($id,$refsolicitudpdf,$pagina,$sector,$x,$y,$nombre,$default,$pregunta,$reftabla,$camporeferencia,$fijo);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarSolicitudesrespuestas($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarSolicitudesrespuestas($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function devolverCamposTabla($serviciosReferencias, $serviciosFunciones) {
   $tabla = $_POST['tabla'];

   $resTabla = $serviciosReferencias->traerTablaPorId($tabla);

   $cad = '<option value="0">-- Seleccionar --</option>';
   if (mysql_num_rows($resTabla)>0) {
      $res = $serviciosReferencias->devolverCamposTabla(mysql_result($resTabla,0,1));

      $cad .= $serviciosFunciones->devolverSelectBox($res,array(0),'');
   }


   echo $cad;


}

function avisarInbursa($serviciosReferencias, $serviciosUsuarios) {
   $id  = $_POST['idventa'];

   $resultado 		= 	$serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);

   $nropoliza = mysql_result($resultado,0,'nropoliza');

   $nrorecibo = mysql_result($resultado,0,'nrorecibo');

   $url = "cobranza/subirdocumentacioni.php?id=".$id;
   $token = $serviciosReferencias->GUID();
   $resAutoLogin = $serviciosReferencias->insertarAutologin(56,$token,$url,'0');

   $resAvisar = $serviciosReferencias->avisarVentaPago($id,'1');

   $resmodificar = $serviciosReferencias->modificarVentaUnicaDocumentacion($id,'refestadopago',2);

   $resmodificar = $serviciosReferencias->modificarVentaUnicaDocumentacion($id,'fechamodi',date('Y-m-d H:m:s'));

   $cuerpo = '';

   $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

   $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

   $cuerpo .= "
   <style>
   	body { font-family: 'Lato', sans-serif; }
   	header { font-family: 'Prata', serif; }
   </style>";

   $cuerpo .= '<body>';

   $cuerpo .= '<h3><small><p>Se genero un pago del recibo: <b>'.$nrorecibo.'</b> cuya poliza es: <b>'.$nropoliza.'</b></small></h3><p>';

   $cuerpo .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</h4>';

	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

   $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

   $cuerpo .= '</body>';

   // por ahora corregir email
   $email = 'msredhotero@gmail.com';

   $retorno = $serviciosReferencias->enviarEmail($email,'Se genero un pago, poliza: '.$nropoliza,utf8_decode($cuerpo));


   $resV['error'] = false;


   header('Content-type: application/json');
   echo json_encode($resV);


}

   function insertarPeriodicidadventaspagos($serviciosReferencias) {
      session_start();

      $refperiodicidadventasdetalle = $_POST['refperiodicidadventasdetalle'];
      $monto = $_POST['monto'];
      $nrorecibo = $_POST['nrorecibo'];
      $fechapago = $_POST['fechapago'];
      $usuariocrea = $_POST['usuariocrea'];
      $usuariomodi = $_POST['usuariomodi'];
      $fechacrea = $_POST['fechacrea'];
      $fechamodi = $_POST['fechamodi'];
      $nrofactura = $_POST['nrofactura'];




      $res = $serviciosReferencias->insertarPeriodicidadventaspagos($refperiodicidadventasdetalle,$monto,$nrorecibo,$fechapago,$usuariocrea,$usuariomodi,$fechacrea,$fechamodi,$nrofactura);

      if ((integer)$res > 0) {
         echo '';

         if (isset($_POST['refdatopago'])) {
            $idcomprobantedepago = $_POST['refdatopago'];
            if ($idcomprobantedepago != 0) {
               $resPago = $serviciosReferencias->traerPagosPorId($idcomprobantedepago);

               if (!file_exists('../archivos/cobros/'.$refperiodicidadventasdetalle.'/')) {
         			mkdir('../archivos/cobros/'.$refperiodicidadventasdetalle.'/', 0777);
         		}

               if (!file_exists('../archivos/cobros/'.$refperiodicidadventasdetalle.'/'.'facturacliente/')) {
         			mkdir('../archivos/cobros/'.$refperiodicidadventasdetalle.'/'.'facturacliente/', 0777);
         		}

               if (mysql_result($resPago,0,'reftabla') == 15) {
                  if (mysql_result($resPago,0,'archivos') == 'ReciboPago.pdf') {
                     $resCopy = copy('../archivos/pagosonlinerecibos/'.mysql_result($resPago,0,'idreferencia').'/'.mysql_result($resPago,0,'archivos'), '../archivos/cobros/'.$refperiodicidadventasdetalle.'/'.'facturacliente/'.mysql_result($resPago,0,'archivos'));
                  } else {
                     $resCopy = copy('../archivos/comprobantespagorecibos/'.mysql_result($resPago,0,'idreferencia').'/'.mysql_result($resPago,0,'archivos'), '../archivos/cobros/'.$refperiodicidadventasdetalle.'/'.'facturacliente/'.mysql_result($resPago,0,'archivos'));
                  }
               } else {
                  if (mysql_result($resPago,0,'archivos') == 'ReciboPago.pdf') {
                     $resCopy = copy('../archivos/pagosonline/'.mysql_result($resPago,0,'idreferencia').'/'.mysql_result($resPago,0,'archivos'), '../archivos/cobros/'.$refperiodicidadventasdetalle.'/'.'facturacliente/'.mysql_result($resPago,0,'archivos'));
                  } else {
                     $resCopy = copy('../archivos/comprobantespago/'.mysql_result($resPago,0,'idreferencia').'/'.mysql_result($resPago,0,'archivos'), '../archivos/cobros/'.$refperiodicidadventasdetalle.'/'.'facturacliente/'.mysql_result($resPago,0,'archivos'));
                  }
               }


               if ($resCopy) {
                  $resEliminar = $serviciosReferencias->eliminarDocumentacionventasPorVentaDocumentacionDetalle($refperiodicidadventasdetalle,39);

                  $resInsertar = $serviciosReferencias->insertarDocumentacionventas(0,39,mysql_result($resPago,0,'archivos'),mysql_result($resPago,0,'type'),5,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],$refperiodicidadventasdetalle);
               }

               $resAplicar = $serviciosReferencias->aplicarPago($idcomprobantedepago,'1');
            }
         }

         $resPV = $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($refperiodicidadventasdetalle);

         $montoCargado = mysql_result($resPV,0,'montototal');

         if ($monto < $montoCargado) {
            $resmodificar = $serviciosReferencias->modificarVentaUnicaDocumentacion($refperiodicidadventasdetalle,'refestadopago',7);
         } else {
            $resmodificar = $serviciosReferencias->modificarVentaUnicaDocumentacion($refperiodicidadventasdetalle,'refestadopago',2);
         }


      } else {
         echo 'Hubo un error al insertar datos';
      }
   }


   function modificarPeriodicidadventaspagos($serviciosReferencias) {
      $id = $_POST['id'];
      $refperiodicidadventasdetalle = $_POST['refperiodicidadventasdetalle'];
      $monto = $_POST['monto'];
      $nrorecibo = $_POST['nrorecibo'];
      $fechapago = $_POST['fechapago'];
      $usuariocrea = $_POST['usuariocrea'];
      $usuariomodi = $_POST['usuariomodi'];
      $fechacrea = $_POST['fechacrea'];
      $fechamodi = $_POST['fechamodi'];
      $nrofactura = $_POST['nrofactura'];

      $avisoinbursa = $_POST['avisoinbursa'];


      if (isset($_POST['refdatopago'])) {
         $idcomprobantedepago = $_POST['refdatopago'];
         if ($idcomprobantedepago != 0) {
            $resAplicar = $serviciosReferencias->aplicarPago($idcomprobantedepago,'1');
         }
      }

      $res = $serviciosReferencias->modificarPeriodicidadventaspagos($id,$refperiodicidadventasdetalle,$monto,$nrorecibo,$fechapago,$usuariocrea,$usuariomodi,$fechacrea,$fechamodi,$nrofactura,$avisoinbursa);

      if ($res == true) {

         $resPV = $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($refperiodicidadventasdetalle);

         $montoCargado = mysql_result($resPV,0,'montototal');

         if ($monto < $montoCargado) {
            $resmodificar = $serviciosReferencias->modificarVentaUnicaDocumentacion($refperiodicidadventasdetalle,'refestadopago',7);
         } else {
            $resmodificar = $serviciosReferencias->modificarVentaUnicaDocumentacion($refperiodicidadventasdetalle,'refestadopago',2);
         }

         echo '';

      } else {
         echo 'Hubo un error al modificar datos';
      }
   }


   function eliminarPeriodicidadventaspagos($serviciosReferencias) {
      $id = $_POST['id'];

      $res = $serviciosReferencias->eliminarPeriodicidadventaspagos($id);

      if ($res == true) {
         echo '';
      } else {
         echo 'Hubo un error al eliminar datos';
      }
   }

function verificarFirmasPendientes($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];

   $resNIP = $serviciosReferencias->traerTokensPorCotizacionVigente($id);

   $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

   $idCliente = mysql_result($resCotizaciones,0,'refclientes');

   $resCliente = $serviciosReferencias->traerClientesPorId($idCliente);

   $email = mysql_result($resCliente,0,'email');

   $nombrecompleto = mysql_result($resCliente,0,'apellidopaterno').' '.mysql_result($resCliente,0,'apellidomaterno').' '.mysql_result($resCliente,0,'nombre');

   if (mysql_num_rows($resNIP) > 0) {

      $ch = curl_init();
   	$url = 'https://qafirma.signaturainnovacionesjuridicas.com/api/documentos/pendientes?CURPoRFC=TOMG730101MDFLZM00';
   	curl_setopt($ch, CURLOPT_URL, $url);
   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
   	//set the content type to application/json
   	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

   	//return response instead of outputting
   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

   	//execute the POST request
   	$result = curl_exec($ch);
   	curl_close($ch);

   	$arFirmaFiel = json_decode($result, true);

      if (isset($arFirmaFiel)) {
         if ($arFirmaFiel['urlXmlSinFirmar'] == '') {
            $refestadofirma = 1;
         } else {
            $refestadofirma = 2;

            $resV['error'] = true;
            $resV['mensaje'] = 'Tiene Pendientes archivos para firmar';

         }
      } else {
         $refestadofirma = 2;

         $resV['error'] = true;
         $resV['mensaje'] = 'Se genero un inconveniente con la firma, por favor vuelva a intentarlo en unos minutos '.$arFirmaFiel['urlXmlSinFirmar'];
      }




      if ($refestadofirma == 1) {
         $usuario = $nombrecompleto;
         $fechacrea = date('Y-m-d H:i:s');
         $fechamodi = date('Y-m-d H:i:s');
         $vigdesde = date('Y-m-d H:i:s');
         $vighasta = date('Y-m-d H:i:s');

         $folio = 'TOMG730101MDFLZM00';
         $nip = 'https://qafirma.signaturainnovacionesjuridicas.com/firmar/TOMG730101MDFLZM00';
         $sha256 = 'firmae';
         $xml = 'nada';

         $res = $serviciosReferencias->insertarFirmarcontratos($id,$folio,$nip,$usuario,$sha256,$refestadofirma,$fechacrea,$fechamodi,$vigdesde,$vighasta,$xml);

         if ((integer)$res > 0) {
            $resV['error'] = false;

            $resEstado = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',12,$_SESSION['usua_sahilices']);

            $resEstado = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',4,$_SESSION['usua_sahilices']);
         } else {
            $resV['error'] = true;
            $resV['mensaje'] = 'Se genero un error al modificar los datos, vuelva a intentarlo '.$res;
         }
      }


   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo firmar el documento, el NIP esta vencido, necesita volver a crear uno';
   }

   header('Content-type: application/json');
   echo json_encode($resV);

}

function cambiarMetodoDePago($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarMetodopagoPorCotizacion($id);

   if ($res) {
      $resV['error'] = false;
      $resV['url'] = 'metodopago.php?id='.$id;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo cambiar el metodo de pago, intente nuevamente';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarVentas($serviciosReferencias) {
   session_start();

   $refcotizaciones = $_POST['refcotizaciones'];
   $refestadoventa = $_POST['refestadoventa'];
   $primaneta = ($_POST['primaneta'] == '' ? 0 : $_POST['primaneta']);
   $primatotal = ($_POST['primatotal'] == '' ? 0 : $_POST['primatotal']);
   $fechavencimientopoliza = $_POST['fechavencimientopoliza'];
   $nropoliza = $_POST['nropoliza'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $foliotys = $_POST['foliotys'];
   $foliointerno = $serviciosReferencias->generaFolioInterno();

   $origen = $_POST['reforigen'];

   if (isset($_POST['refproductosaux'])) {
      $refproductosaux = $_POST['refproductosaux'];
   } else {
      $refproductosaux = 0;
   }

   if (isset($_POST['refventas'])) {
      $refventas = ($_POST['refventas'] == '' ? 0 : $_POST['refventas']);
   } else {
      $refventas = 0;
   }

   $version = $serviciosReferencias->generarVersion($refventas);

   $observaciones = $_POST['observaciones'];
   $vigenciadesde = $_POST['vigenciadesde'];

   $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($refcotizaciones);

   /*
   $idproducto = mysql_result($resCotizaciones,0,'refproductos');
   $resProducto = $serviciosReferencias->traerProductosPorId($idproducto);

   $resPaquete = $serviciosReferencias->traerPaquetedetallesPorPaquete($idproducto);

   if (mysql_num_rows($resPaquete) > 0) {

   }
   */



   $res = $serviciosReferencias->insertarVentas($refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$foliotys,$foliointerno,$refproductosaux, $refventas,$version, $observaciones,$vigenciadesde);

   if ((integer)$res > 0) {
      if ($origen == 1) {
         $resMetodoPago = $serviciosReferencias->traerMetodopagoPorCotizacion($refcotizaciones);

         if (mysql_num_rows($resMetodoPago) > 0) {
            $resMP = $serviciosReferencias->insertarPeriodicidadventasPorMetodoPago($res,mysql_result($resMetodoPago,0,0));
         }
      }
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarPagos($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $monto = $_POST['monto'];
   $token = $_POST['token'];
   $destino = $_POST['destino'];
   $refcuentasbancarias = $_POST['refcuentasbancarias'];
   $conciliado = $_POST['conciliado'];
   $archivos = $_POST['archivos'];
   $type = $_POST['type'];
   $fechacrea = $_POST['fechacrea'];
   $usuariocrea = $_POST['usuariocrea'];
   $refestado = $_POST['refestado'];
   $razonsocial = $_POST['razonsocial'];
   $contratante = $_POST['contratante'];
   $nrorecibo = $_POST['nrorecibo'];

   $res = $serviciosReferencias->modificarPagos($id,$reftabla,$idreferencia,$monto,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,$refestado,$razonsocial,$contratante,$nrorecibo,'0');
   if ($res == true) {
      if ($refestado == 5) {
         $resModCotizacion = $serviciosReferencias->modificarCotizacionesPorCampo($idreferencia,'refestadocotizaciones',20, $_SESSION['usua_sahilices']);
      }
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function traerPagosPorId($serviciosReferencias) {
   $id = $_POST['idpago'];
   $res = $serviciosReferencias->traerPagosPorId($id);

   if (mysql_num_rows($res) > 0) {
      $resV['error'] = false;

      $idcotizacion = mysql_result($res,0,'idreferencia');

      $imagen = '../../imagenes/sin_img.jpg';

      if (mysql_result($res,0,'archivos') == '') {
         $resV['datos'] = array('imagen' => $imagen, 'type' => 'imagen');
      } else {
         $resV['datos'] = array('imagen' => '../../archivos/comprobantespago/'.$idcotizacion.'/'.mysql_result($res,0,'archivos'), 'type' => mysql_result($res,0,'type'));
      }


   } else {
      $imagen = '../../imagenes/sin_img.jpg';

      $resV['datos'] = array('imagen' => $imagen, 'type' => 'imagen');
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarCuentasbancarias($serviciosReferencias) {
   $razonsocial = $_POST['razonsocial'];
   $apoderado = $_POST['apoderado'];
   $clabeinterbancaria = $_POST['clabeinterbancaria'];
   $refbancos = $_POST['refbancos'];

   $res = $serviciosReferencias->insertarCuentasbancarias($razonsocial,$apoderado,$clabeinterbancaria,$refbancos);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarCuentasbancarias($serviciosReferencias) {
   $id = $_POST['id'];
   $razonsocial = $_POST['razonsocial'];
   $apoderado = $_POST['apoderado'];
   $clabeinterbancaria = $_POST['clabeinterbancaria'];
   $refbancos = $_POST['refbancos'];

   $res = $serviciosReferencias->modificarCuentasbancarias($id,$razonsocial,$apoderado,$clabeinterbancaria,$refbancos);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarCuentasbancarias($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarCuentasbancarias($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function insertarFirmarcontratos($serviciosReferencias) {
   session_start();
   $refcotizaciones = $_POST['refcotizaciones'];
   $nip = $_POST['nip'];

   $resNIP = $serviciosReferencias->traerTokensPorCotizacionVigente($refcotizaciones);



   if (mysql_num_rows($resNIP) > 0) {

      if ($nip !== mysql_result($resNIP,0,'token')) {
         $resV['error'] = true;
         $resV['mensaje'] = 'El NIP no coincide con el que le enviamos por email, verifiquelo';
      } else {
         $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($refcotizaciones);

         $idCliente = mysql_result($resCotizaciones,0,'refclientes');

         $resCliente = $serviciosReferencias->traerClientesPorId($idCliente);

         $email = mysql_result($resCliente,0,'email');

         $nombrecompleto = mysql_result($resCliente,0,'apellidopaterno').' '.mysql_result($resCliente,0,'apellidomaterno').' '.mysql_result($resCliente,0,'nombre');

         $folio = mysql_result($resCliente,0,'curp');

         $nip = mysql_result($resNIP,0,'token');

         /***** api para la firma *****/
         $url = 'https://qafirma.signaturainnovacionesjuridicas.com/api/firmasimple/crear';
         $archivo = '../reportes/F20926AC.pdf';
         $sha256 = hash_file('sha256', $archivo);

         $ch = curl_init();

         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

         $data = array(
            'folio' => $folio,
            'pin' => $nip,
            'usuario' => $nombrecompleto,
            'sha256' => $sha256,
         );
         //attach encoded JSON string to the POST fields
         curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
         //set the content type to application/json
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
         //return response instead of outputting
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         //execute the POST request
         $result = curl_exec($ch);

         if ($result == false) {
            $refestadofirma = 2;
         } else {

            if (!file_exists('../archivos/firmas/cotizaciones/'.$refcotizaciones.'/')) {
      			mkdir('../archivos/firmas/cotizaciones/'.$refcotizaciones.'/', 0777);
      		}

            if (!file_exists('../archivos/firmas/cotizaciones/'.$refcotizaciones.'/'.$sha256.'/')) {
      			mkdir('../archivos/firmas/cotizaciones/'.$refcotizaciones.'/'.$sha256.'/', 0777);
      		}

            $result = trim($result,'"');

            //echo '<p>Resultado: '.$result.'</p>';

            //echo '<p>Documento Hashado: '.$documento.'</p>';

            $textoXML = mb_convert_encoding($result, "UTF-8");

            $xml = $textoXML;

            $gestor = fopen('../archivos/firmas/cotizaciones/'.$refcotizaciones.'/'.$sha256.'/firma.xml', 'w');
         	fwrite($gestor, $textoXML);
         	fclose($gestor);

            $refestadofirma = 1;
         }

         curl_close($ch);

         /***** fin api **************/

         $usuario = $nombrecompleto;
         $fechacrea = date('Y-m-d H:i:s');
         $fechamodi = date('Y-m-d H:i:s');
         $vigdesde = date('Y-m-d H:i:s');
         $vighasta = date('Y-m-d H:i:s');

         $res = $serviciosReferencias->insertarFirmarcontratos($refcotizaciones,$folio,$nip,$usuario,$sha256,$refestadofirma,$fechacrea,$fechamodi,$vigdesde,$vighasta,$xml);

         if ($refestadofirma == 1) {
            if ((integer)$res > 0) {
               $resV['error'] = false;

               $resEstado = $serviciosReferencias->modificarCotizacionesPorCampo($refcotizaciones,'refestadocotizaciones',12,$_SESSION['usua_sahilices']);

               $resEstado = $serviciosReferencias->modificarCotizacionesPorCampo($refcotizaciones,'refestados',4,$_SESSION['usua_sahilices']);
            } else {
               $resV['error'] = true;
               $resV['mensaje'] = 'Se genero un error al modificar los datos, vuelva a intentarlo '.$res;
            }
         } else {
            $resV['error'] = true;
            $resV['mensaje'] = 'Se genero un inconveniente con la firma, por favor vuelva a intentarlo en unos minutos';
         }
      }


   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo firmar el documento, el NIP esta vencido, necesita volver a crear uno';
   }


   header('Content-type: application/json');
   echo json_encode($resV);


}

function reenviarTokens($serviciosReferencias) {

   $refcotizaciones = $_POST['refcotizaciones'];
   $reftipo = 1;
   $token = $serviciosReferencias->GUID();

   $fechacreac = date('Y-m-d H:i:s');
   $nuevafecha = strtotime ( '+15 hour' , strtotime ( $fechacreac ) ) ;

   $refestadotoken = 1;
   $vigenciafin = $nuevafecha;

   $resMod = $serviciosReferencias->modificarTokensTodosInhabilitar($refcotizaciones);

   $res = $serviciosReferencias->insertarTokens($refcotizaciones,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin);

   if ((integer)$res > 0) {

      $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($refcotizaciones);

      $idCliente = mysql_result($resCotizaciones,0,'refclientes');

      $resCliente = $serviciosReferencias->traerClientesPorId($idCliente);

      $email = mysql_result($resCliente,0,'email');

      $idusuario = mysql_result($resCliente,0,'refusuarios');

      $url = "https://asesorescrea.com/desarrollo/crm/dashboard/venta/documentos.php?id=".$refcotizaciones;

      $cuerpo = '';

      $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

      $cuerpo .= "
      <style>
      	body { font-family: 'Lato', sans-serif; }
      	header { font-family: 'Prata', serif; }
      </style>";

      $tokenL = $serviciosReferencias->GUID();
      $resAutoLogin = $serviciosReferencias->insertarAutologin($idusuario,$tokenL,$url,'0');

      $cuerpo .= '<body>';

      $cuerpo .= '<h3><small><p>Este es el nuevo NIP generado para firmar de forma digital</small></h3><p>';

      $cuerpo .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</h4>';

		$cuerpo .= "<center>NIP:<b>".$token."</b></center><p> ";

		$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

      $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

      $cuerpo .= '</body>';

   	$fecha = date_create(date('Y').'-'.date('m').'-'.date('d'));
   	date_add($fecha, date_interval_create_from_date_string('30 days'));
   	$fechaprogramada =  date_format($fecha, 'Y-m-d');

   	//$res = $this->insertarActivacionusuarios($refusuarios,$token,'','');

   	$retorno = $serviciosReferencias->enviarEmail($email,'NIP para firma',utf8_decode($cuerpo));

      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function insertarTokens($serviciosReferencias) {

   $refcotizaciones = $_POST['refcotizaciones'];
   $reftipo = 1;
   $token = $serviciosReferencias->generarNIP();

   $fechacreac = date('Y-m-d H:i:s');
   $nuevafecha = strtotime ( '+15 hour' , strtotime ( $fechacreac ) ) ;

   $refestadotoken = 1;
   $vigenciafin = $nuevafecha;

   $res = $serviciosReferencias->insertarTokens($refcotizaciones,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin);

   if ((integer)$res > 0) {

      $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($refcotizaciones);

      $idCliente = mysql_result($resCotizaciones,0,'refclientes');

      $resCliente = $serviciosReferencias->traerClientesPorId($idCliente);

      $email = mysql_result($resCliente,0,'email');

      $cuerpo = '';

      $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

      $cuerpo .= "
      <style>
      	body { font-family: 'Lato', sans-serif; }
      	header { font-family: 'Prata', serif; }
      </style>";



      $cuerpo .= '<body>';

      $cuerpo .= '<h3><small><p>Este es el nuevo NIP generado para firmar de forma digital, por favor ingrese al siguiente <a href="https://asesorescrea.com/desarrollo/crm/dashboard/venta/documentos.php?id='.$refcotizaciones.'" target="_blank"> enlace </a> para finalizar el proceso de venta. </small></h3><p>';

		$cuerpo .= "<center>NIP:<b>".$token."</b></center><p> ";

		$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

      $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

      $cuerpo .= '</body>';

   	$fecha = date_create(date('Y').'-'.date('m').'-'.date('d'));
   	date_add($fecha, date_interval_create_from_date_string('30 days'));
   	$fechaprogramada =  date_format($fecha, 'Y-m-d');

   	//$res = $this->insertarActivacionusuarios($refusuarios,$token,'','');

   	$retorno = $serviciosReferencias->enviarEmail($email,'NIP para firma',utf8_decode($cuerpo));

      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function ineCargadoCotizacion($serviciosReferencias) {
   session_start();
   $id = $_POST['id'];

   $resEstado = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',21,$_SESSION['usua_sahilices']);

   if ($resEstado) {
      $resV['error'] = false;

   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'Se genero un error al modificar los datos, vuelva a intentarlo';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modDomicilio($serviciosReferencias) {
   session_start();

   $domicilio = $_POST['domicilio'];
   $nroexterior = $_POST['nroexterior'];
   $nrointerior = $_POST['nrointerior'];
   $edificio = $_POST['edificio'];
   $estado = $_POST['estado'];
   $ciudad = $_POST['ciudad'];
   $delegacion = $_POST['delegacion'];
   $colonia = $_POST['colonia'];
   $codigopostal = $_POST['codigopostal'];

   $resCliente = $serviciosReferencias->traerClientesPorUsuarioCompleto($_SESSION['usuaid_sahilices']);

   $error = '';

   if ($domicilio == '') {
      $error = 'Por favor ingrese un domicilio
      ';
   }

   if ($nroexterior == '') {
      $error .= 'Por favor ingrese el Nro Exterior del domicilio
      ';
   }

   if ($estado == '') {
      $error .= 'Es necesario el Estado
      ';
   }

   if ($delegacion == '') {
      $error .= 'Es necesario la Delegación
      ';
   }

   if ($colonia == '') {
      $error .= 'Es necesario la Colonia
      ';
   }

   if ($codigopostal == '') {
      $error .= 'Es necesario el Codigo Postal ';
   }

   if ($ciudad == '') {
      $error .= 'Es necesario la Ciudad
      ';
   }

   if ($error == '') {
      $res = $serviciosReferencias->modificarClientesDomicilio(mysql_result($resCliente,0,0),$domicilio,$nroexterior,$nrointerior,$edificio,$estado,$delegacion,$colonia,$codigopostal,$ciudad);
      if ($res) {
         $resV['error'] = false;

      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'Se genero un error al modificar los datos, vuelva a intentarlo'.$res;
      }
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = $error;
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modPassword($serviciosReferencias) {
   session_start();

   $passa = $_POST['passa'];
   $passn = $_POST['passn'];
   $passnn = $_POST['passnn'];

   $resUsuario = $serviciosReferencias->traerUsuariosPorId($_SESSION['usuaid_sahilices']);

   $error = '';
   if (mysql_result($resUsuario,0,'password') !== $passa) {
      $error = 'La contraseña actual es erronea';
   }

   if ($passn !== $passnn) {
      $error = 'La contraseña nueva difiere de la confirmación de la contraseña';
   }

   if (($passn == '') || ($passnn == '')) {
      $error = 'La contraseña nueva es obligatoria';
   }

   if ($passn === $passa) {
      $error = 'La contraseña nueva no puede ser igual a la actual';
   }

   if(!preg_match('/^(?=\w*\d)(?=\w*[A-Z])(?=\w*[a-z])\S{8,16}$/', $passn)) {
      $error = 'La contraseña debe tener al entre 8 y 16 caracteres, al menos un dígito, al menos una minúscula y al menos una mayúscula.';
   }

   if ($error == '') {
      $res = $serviciosReferencias->modPassword($_SESSION['usuaid_sahilices'],$passn);
      if ($res) {
         $resV['error'] = false;

      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'Se genero un error al modificar los datos, vuelva a intentarlo';
      }
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = $error;
   }




   header('Content-type: application/json');
   echo json_encode($resV);

}

function insertarValoredad($serviciosReferencias) {
   $refproductos = $_POST['refproductos'];
   $desde = $_POST['desde'];
   $hasta = $_POST['hasta'];
   $valor = $_POST['valor'];
   $vigdesde = $_POST['vigdesde'];
   $vighasta = $_POST['vighasta'];
   $fechacrea = date('Y-m-d H:i:s');

   $res = $serviciosReferencias->insertarValoredad($refproductos,$desde,$hasta,$valor,$vigdesde,$vighasta,$fechacrea);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarValoredad($serviciosReferencias) {
   $id = $_POST['id'];
   $refproductos = $_POST['refproductos'];
   $desde = $_POST['desde'];
   $hasta = $_POST['hasta'];
   $valor = $_POST['valor'];
   $vigdesde = $_POST['vigdesde'];
   $vighasta = $_POST['vighasta'];

   $res = $serviciosReferencias->modificarValoredad($id,$refproductos,$desde,$hasta,$valor,$vigdesde,$vighasta,$fechacrea);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarValoredad($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarValoredad($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function guardarMetodoDePagoPorCotizacion($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];

   $resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

   $metodopago = $_POST['metodopago'];
   $banco = $_POST['banco'];
   $afiliacionnumber = $_POST['afiliacion'];
   $domiciliado = $_POST['domiciliado'];
   $tipotarjeta = $_POST['tipotarjeta']; //1 = tarjeta de credito 2 = cuenta debito
   $precio = $_POST['precio'];

   //datos cotizacion ////////
   $montototal = $precio;
   $primaneta = mysql_result($resCotizacion,0,'primaneta');
   /////////////////////////////

   if ($afiliacionnumber != '') {
      $afiliacionnumber = $serviciosReferencias->encryptIt($afiliacionnumber);
   }

   $url = 'documentos.php?id='.$id;

   $nuevoEstadocotizacion = 0;

   switch ($metodopago) {
      case 1:
         $reftipoperiodicidad = 1;
         $reftipocobranza = 1;
         $url = 'comercio_fin.php?id='.$id;
         $nuevoEstadocotizacion = 19;

      break;
      case 2:
         $reftipoperiodicidad = 1;
         $reftipocobranza = 1;
         $nuevoEstadocotizacion = 22;
         $url = 'comprobantepago.php?id='.$id;

      break;
      case 3:
         $reftipoperiodicidad = 1;
         $reftipocobranza = 1;
         $url = 'descuentopornomina.php?id='.$id;
         $nuevoEstadocotizacion = 23;

      break;
      case 4:
         $reftipoperiodicidad = 4;
         $reftipocobranza = 2;
         $nuevoEstadocotizacion = 20;
         $url = 'archivos.php?id='.$id;
         $montototal = $montototal * 1.2;

      break;
   }

   $resAux = $serviciosReferencias->traerMetodopagoPorCotizacion($id);



   // defino por el radio del html si lo domicilio o no
   if ($domiciliado == 0) {
      $banco = '';
      $afiliacionnumber = '';
      $tipotarjeta = 0;
      $reftipocobranza = 2;
   } else {
      $reftipocobranza = 1;
   }

   if (mysql_num_rows($resAux) > 0) {

   } else {
      $resMetodoPago = $serviciosReferencias->insertarMetodopago($id,$reftipoperiodicidad,$reftipocobranza,$banco,$afiliacionnumber,$tipotarjeta);
   }

   $resEstado = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',$nuevoEstadocotizacion,$_SESSION['usua_sahilices']);

   $resPrimaNeta = $serviciosReferencias->modificarCotizacionesPorCampo($id,'primaneta',$precio,$_SESSION['usua_sahilices']);

   $resPrimaTotal = $serviciosReferencias->modificarCotizacionesPorCampo($id,'primatotal',$precio,$_SESSION['usua_sahilices']);

   if ($resEstado) {
      $resV['error'] = false;
      $resV['url'] = $url;

   } else {
      $resV['error'] = true;

   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificoAseguradoPorCotizacion($serviciosReferencias) {
   $id = $_POST['id'];
   $tieneasegurado = $_POST['tieneasegurado'];
   $refaseguradaaux = $_POST['refaseguradaaux'];


   if ($tieneasegurado == 1) {
      $resMCA = $serviciosReferencias->modificarCotizacionesAsegurado($id,'1',$refaseguradaaux);
   } else {
      $resMCA = $serviciosReferencias->modificarCotizacionesAsegurado($id,'0',0);
   }

   if ($resMCA) {
      $resV['error'] = false;

   } else {
      $resV['error'] = true;

   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarEstadoDeRechazopostulantes($serviciosReferencias) {
  $id = $_POST['id'];
  $idestado = $_POST['idestado'];

  $res = $serviciosReferencias->modificarPostulanteUnicaDocumentacion($id, 'refestadopostulantes', $idestado);

  if ($res) {
     $resV['error'] = false;

  } else {
     $resV['error'] = true;

  }

  header('Content-type: application/json');
  echo json_encode($resV);
}

function traerInformeDeDocumentaciones($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerInformeDeDocumentaciones($id);

   $resV['titulo'] = $res['nombrecompleto'];
   $contenido = '';
   $contenido .= '<h4>'.$res['siap'].'</h4>';
   $contenido .= '<h4>'.$res['veritas'].'</h4>';
   $contenido .= '<h4>'.$res['documentaciones'].'</h4>';
   $contenido .= '<h4>'.$res['contratos'].'</h4>';
   $resV['contenido'] = $contenido;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarCotizacionesPorCampo($serviciosReferencias) {
   session_start();
   $id = $_POST['id'];
   $idestado = $_POST['idestado'];

   // trai los valores del estado a modificar
   $resEstado = $serviciosReferencias->traerEstadocotizacionesPorId($idestado);

   // verifico si me genera un cambio automatico y si finaliza
   if ((mysql_result($resEstado,0,'generaestado') > 0) && (mysql_result($resEstado,0,'finaliza') == '1')) {
      // obtengo la nueva etapa
      $resEstadoNuevo = $serviciosReferencias->traerEstadocotizacionesPorId(mysql_result($resEstado,0,'generaestado'));

      // modifico el estado de la cotizacion
      $resModEstadoCot = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',mysql_result($resEstado,0,'generaestado'), $_SESSION['usua_sahilices']);

      // modifico la etapa
      $resModEstadoEtapa = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstadoNuevo,0,'refetapacotizacion'), $_SESSION['usua_sahilices']);

      $mensaje = 'SE MODIFICO CORRECTAMENTE';
   } else {
      if  (mysql_result($resEstado,0,'renueva') == '1') {
         // modifico el estado de la cotizacion
         $resModEstadoCot = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',$idestado, $_SESSION['usua_sahilices']);

         // modifico la etapa
         $resModEstadoEtapa = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstado,0,'refetapacotizacion'), $_SESSION['usua_sahilices']);

         $mensaje = 'SE MODIFICO CORRECTAMENTE';
      } else {
         // modifico la etapa
         $resModEstadoEtapa = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstado,0,'refetapacotizacion'), $_SESSION['usua_sahilices']);

         $mensaje = 'SE MODIFICO CORRECTAMENTE';
      }

   }


   if ($resModEstadoEtapa) {
      $resV['error'] = false;
      $resV['mensaje'] = $mensaje;
      $resV['tipo'] = 'success';
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'Se genero un error por favor vuelva a intentarlo';
      $resV['tipo'] = 'danger';
   }




   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarCotizacionesPorCampoRechazoDefinitivo($serviciosReferencias) {
   session_start();
   $id = $_POST['id'];
   $idestado = $_POST['idestado'];
   $motivo = $_POST['motivo'];
   $error = '';
   if ($motivo == 'Precio') {
      $nocompartioinformacion = $_POST['nocompartioinformacion'];
      $primatotalinbursa = $_POST['primatotalinbursa'];
      $primatotalcompetencia = $_POST['primatotalcompetencia'];
      $aseguradora = $_POST['aseguradora'];

      if (($primatotalinbursa == '') || ($primatotalcompetencia == '')) {
         $error = 'Debe completar los campos Prima Total Inbursa y Prima Total Campotencia';
      }
   } else {
      $nocompartioinformacion = '';
      $primatotalinbursa = '';
      $primatotalcompetencia = '';
      $aseguradora = '';
   }

   if ($error == '') {
      // trai los valores del estado a modificar
      $resEstado = $serviciosReferencias->traerEstadocotizacionesPorId($idestado);

      // verifico si me genera un cambio automatico y si finaliza
      if ((mysql_result($resEstado,0,'generaestado') > 0) && (mysql_result($resEstado,0,'finaliza') == '1')) {
         // obtengo la nueva etapa
         $resEstadoNuevo = $serviciosReferencias->traerEstadocotizacionesPorId(mysql_result($resEstado,0,'generaestado'));

         // modifico el estado de la cotizacion
         $resModEstadoCot = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',mysql_result($resEstado,0,'generaestado'), $_SESSION['usua_sahilices']);

         // modifico la etapa
         $resModEstadoEtapa = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstadoNuevo,0,'refetapacotizacion'), $_SESSION['usua_sahilices']);

         $mensaje = 'SE MODIFICO CORRECTAMENTE';
      } else {
         if  (mysql_result($resEstado,0,'renueva') == '1') {
            // modifico el estado de la cotizacion
            $resModEstadoCot = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',$idestado, $_SESSION['usua_sahilices']);

            // modifico la etapa
            $resModEstadoEtapa = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstado,0,'refetapacotizacion'), $_SESSION['usua_sahilices']);

            $mensaje = 'SE MODIFICO CORRECTAMENTE';
         } else {
            // modifico la etapa
            $resModEstadoEtapa = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstado,0,'refetapacotizacion'), $_SESSION['usua_sahilices']);

            // modifico el estado de la cotizacion
            $resModEstadoCot = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',$idestado, $_SESSION['usua_sahilices']);


            $mensaje = 'SE MODIFICO CORRECTAMENTE';
         }

      }

      $res = $serviciosReferencias->insertarMotivorechazocotizaciones($id,$motivo,$nocompartioinformacion,$primatotalinbursa,$primatotalcompetencia,$aseguradora);


      if ($resModEstadoEtapa) {
         $resV['error'] = false;
         $resV['mensaje'] = $mensaje;
         $resV['tipo'] = 'success';
      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'Se genero un error por favor vuelva a intentarlo';
         $resV['tipo'] = 'error';
      }

   } else {
      $resV['error'] = true;
      $resV['mensaje'] = $error;
      $resV['tipo'] = 'error';
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function enviarCotizacion($serviciosReferencias, $serviciosUsuarios, $serviciosMensajes) {
   session_start();

   $id = $_POST['id'];

   $noenviar = 0;

   $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

   if (mysql_num_rows($resCotizaciones) > 0) {
      $resV['error'] = false;

      if ((mysql_result($resCotizaciones,0,'claveasesor') != '28222') && (mysql_result($resCotizaciones,0,'envioalcliente') == '0')) {
         // destinatario del email
         $destinatario = mysql_result($resCotizaciones,0,'emailasesor');
         // url para ingreso
         $url = "cotizaciones/modificar.php?id=".mysql_result($resCotizaciones,0,0);
         // usuario
         $idusuario = mysql_result($resCotizaciones,0,'idusuarioasesor');
      } else {
         // destinatario del email
         $destinatario = mysql_result($resCotizaciones,0,'email');
         // url para ingreso
         $url = "cotizacionesvigentes/resultado.php?id=".mysql_result($resCotizaciones,0,0);

         if (mysql_result($resCotizaciones,0,'idusuariocliente') >0) {
            // usuario
            $idusuario = mysql_result($resCotizaciones,0,'idusuariocliente');
         } else {
            // usuario
            $noenviar = 1;
         }

      }

      if ($noenviar == 0) {
         ///// para el auto login ///////////////
         // usuario 30 fabiola

         $token = $serviciosReferencias->GUID();
         $resAutoLogin = $serviciosReferencias->insertarAutologin($idusuario,$token,$url,'0');
         ////// fin ////////////////////////////

         $asunto = 'Se le envio una cotizacion desde la plataforma, folio: '.mysql_result($resCotizaciones,0,'folio');

         $cuerpo = '';

         $cuerpo .= "<p>El cliente ".mysql_result($resCotizaciones,0,'clientesolo')." - Email: ".mysql_result($resCotizaciones,0,'email')." - Telefono: ".mysql_result($resCotizaciones,0,'telefonocelular')."</p>";

         $cuerpo .= '<p>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</p>';



         $exito = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo);

         $resV['mensaje'] = 'Se envio con exito la cotizacion';

         // modifico la cotizacion a la primer etapa
         $resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',3,$_SESSION['usua_sahilices']);

         // modifico la cotizacion a la primer estado
         $resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',8,$_SESSION['usua_sahilices']);



      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'El cliente aun no tiene un usuario generado';
      }

   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No exite el registro, verifique';
   }




   header('Content-type: application/json');
   echo json_encode($resV);

}

function rechazaCotizacionCliente($serviciosReferencias) {
   session_start();
   $id = $_POST['id'];
   $motivosrechazo = $_POST['motivosrechazo'];

   $usuariomodi = $_SESSION['usua_sahilices'];

   $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

   $resModificarEstadoGralCotizacion = $serviciosReferencias->modificarEstadoCotizacionResultado($id,3);

   $resModificarEstadoCotizacion = $serviciosReferencias->modificarCotizacionesRechazar($id,'rechazado por el cliente por: '.$motivosrechazo,$usuariomodi);

   echo '';

}

function generaNotificacion($serviciosReferencias, $serviciosMensajes, $serviciosNotificaciones,$serviciosUsuarios) {
   $id = $_POST['id'];
   $interes = $_POST['interes'];

   session_start();

   $resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

   $lblMensajeNot = '';
   $lblAsunto = '';

   switch ($interes) {
      case 'cotizacionAjustes':
         $lblMensajeNot = 'Ajuste Cotizacion: ';
         $lblAsunto = 'Solicitaron ajustes sobre la cotizacion: ';
         //$resMod = $serviciosReferencias->modificarEstadoCotizacionResultado($id, 2);
         $resMod = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',10,$_SESSION['usua_sahilices']);
      break;
      case 'cotizacionRechazo':
         $lblMensajeNot = 'Rechaza Cotizacion: ';
         $lblAsunto = 'Rechazaron la cotizacion: ';
         //$resMod = $serviciosReferencias->modificarEstadoCotizacionResultado($id, 3);
         $resMod = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',11,$_SESSION['usua_sahilices']);
      break;
   }

   $emailReferente = 'fsegovia@asesorescrea.com'; //por ahora fijo
   $mensaje = $lblMensajeNot.mysql_result($resCotizaciones,0,'folio');
   $idpagina = 1;
   $autor = $_SESSION['usua_sahilices'];
   $destinatario = $emailReferente;
   $id1 = $id;
   $id2 = 0;
   $id3 = 0;
   $icono = 'monetization_on';
   $estilo = 'bg-light-green';
   $fecha = date('Y-m-d H:i:s');
   $url = "cotizaciones/modificar.php?id=".mysql_result($resCotizaciones,0,0);

   $resNotificaciones = $serviciosNotificaciones->insertarNotificaciones($mensaje,$idpagina,$autor,$destinatario,$id1,$id2,$id3,$icono,$estilo,$fecha,$url);

   ///// para el auto login ///////////////
   // usuario 30 fabiola
   $token = $serviciosReferencias->GUID();
   $resAutoLogin = $serviciosReferencias->insertarAutologin(30,$token,$url,'0');
   ////// fin ////////////////////////////

   $asunto = $lblAsunto.mysql_result($resCotizaciones,0,'folio');

   $cuerpo = '';

   $cuerpo .= "<p>El cliente ".mysql_result($resCotizaciones,0,'clientesolo')." - Email: ".mysql_result($resCotizaciones,0,'email')." - Telefono: ".mysql_result($resCotizaciones,0,'telefonocelular')."</p>";

   $cuerpo .= '<p>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</p>';

   $destinatario = 'fsegovia@asesorescrea.com';

   $exito = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo);

   if ($exito) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo enviar el mensaje, vuelva a intentarlo en unos momentos';
   }
   header('Content-type: application/json');
   echo json_encode($resV);

}

function aceptarClienteCotizacion($serviciosReferencias, $serviciosMensajes) {
   $id = $_POST['id'];
   session_start();

   //$res = $serviciosReferencias->modificarEstadoCotizacionResultado($id,2);

   $res = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',9,$_SESSION['usua_sahilices']);

   if ($res) {
      $resV['error'] = false;

      $resV['ruta'] = "subirdocumentacionie.php?id=".$id;

   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No exite el registro, verifique';

   }


   header('Content-type: application/json');
   echo json_encode($resV);

}

function rutaCotizar($serviciosReferencias) {
   $id = $_POST['id'];
   $tipo = $_POST['tipo'];

   switch ($tipo) {
      case 1:
         $res = $serviciosReferencias->traerLeadPorId($id);
      break;
   }

   if (mysql_num_rows($res)>0) {
      $resV['error'] = false;

      $resV['ruta'] = "../cotizaciones/newfilter.php?idcliente=".mysql_result($res,0,'refclientes')."&idproducto=".mysql_result($res,0,'refproductos')."&lead=".$id;

   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No exite el registro, verifique';

   }


   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarLead($serviciosReferencias) {
   session_start();

   $refclientes = $_POST['refclientes'];
   $refproductos = 0;
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $contactado = $_POST['contactado'];
   $usuariocontacto = '';
   $usuarioresponsable = '';
   $cita = '';
   $refestadolead = 1;
   $fechacreacita = '';
   $observaciones = $_POST['observaciones'];
   $refproductosweb = $_POST['tipo'];
   $reforigencomercio = $_POST['origen'];

   $res = $serviciosReferencias->insertarLead($refclientes,$refproductos,$fechacrea,$fechamodi,$contactado,$usuariocontacto,$usuarioresponsable,$cita,$refestadolead,$fechacreacita,$observaciones,$refproductosweb,$reforigencomercio);

   if ((integer)$res > 0) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'Hubo un error al insertar datos, vuelva a intentarlo';
   }
   header('Content-type: application/json');
   echo json_encode($resV);
}


function modificarLead($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refclientes = $_POST['refclientes'];
   $refproductos = $_POST['refproductos'];

   $fechamodi = date('Y-m-d H:i:s');
   $contactado = $_POST['contactado'];

   if ($contactado == '1') {
      $usuariocontacto = $_SESSION['usua_sahilices'];
   } else {
      $usuariocontacto = '';
   }


   $cita = $_POST['cita'];
   $refestadolead = $_POST['refestadolead'];

   if ($refestadolead > 1) {
      $usuarioresponsable = $_SESSION['usua_sahilices'];
   } else {
      $usuarioresponsable = '';
   }

   if ($cita != '0000-00-00 00:00:00') {
      $fechacreacita = date('Y-m-d H:i:s');
   } else {
      $fechacreacita = '0000-00-00 00:00:00';
   }

   $observaciones = $_POST['observaciones'];
   $refproductosweb = $_POST['refproductosweb'];

   if ($refestadolead == 2) {
      $refestadolead = 1;
      $resV['ruta'] = "../cotizaciones/newfilter.php?idcliente=".$refclientes."&idproducto=".$refproductos."&lead=".$id;
   } else {
      $resV['ruta'] = "";
   }

   $res = $serviciosReferencias->modificarLead($id,$refclientes,$refproductos,$fechamodi,$contactado,$usuariocontacto,$usuarioresponsable,$cita,$refestadolead,$fechacreacita,$observaciones,$refproductosweb);


   if ($res) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo modificar su numero de telefono celular, vuelva a intentarlo';
   }
   header('Content-type: application/json');
   echo json_encode($resV);
}

function eliminarLead($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarLeadBaja($id, $_SESSION['usua_sahilices']);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function ModificarTelMovilCliente($serviciosReferencias) {
   $idcliente = $_POST['idcliente'];
   $celphone = $_POST['celphone'];

   $res = $serviciosReferencias->modificarCampoParticularClientes($idcliente,'telefonocelular',$celphone);

   if ($res) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo modificar su numero de telefono celular, vuelva a intentarlo';
   }
   header('Content-type: application/json');
   echo json_encode($resV);
}


function EnviarEmailInfo($serviciosReferencias,$serviciosUsuarios) {
   session_start();

   $producto = $_POST['producto'];
   $observaciones = $_POST['observaciones'];

   $resCliente = $serviciosReferencias->traerClientesPorUsuario($_SESSION['usuaid_sahilices']);

   $asunto = "Solicitan asesoramiento sobre el producto: ".$producto.", el cliente ".mysql_result($resCliente,0,'nombre').' '.mysql_result($resCliente,0,'apellidopaterno').' '.mysql_result($resCliente,0,'apellidomaterno')." - Email: ".mysql_result($resCliente,0,'email')." - Telefono: ".mysql_result($resCliente,0,'telefonocelular');

   $cuerpo = "Observaciones: ".$observaciones;

   $destinatario = 'fsegovia@asesorescrea.com';

   $exito = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo);

   if ($exito) {
      $resV['error'] = false;
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'No se pudo enviar el mensaje, vuelva a intentarlo en unos momentos';
   }
   header('Content-type: application/json');
   echo json_encode($resV);
}

function recuperar($serviciosUsuarios) {
   $email = $_POST['email'];

   $res = $serviciosUsuarios->traerUsuario($email);


   $destinatario = $email;
   $asunto = "ASESORES CREA - Recupero de credenciales";

   if (mysql_num_rows($res)>0) {
      $cuerpo = 'Su password es: '.mysql_result($res,0,'password');

      $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo);
      echo '';
   } else {
      echo 'El email no existe';
   }

}

function validarCuestionarioPersona($serviciosReferencias) {
   $id = $_POST['refproductos'];
   $refclientes = $_POST['refclientes'];
   if (isset($_POST['refaseguradaaux'])) {
      $refasegurados = $_POST['refaseguradaaux'];
   } else {
      $refasegurados = 0;
   }

   $tieneasegurado = $_POST['tieneasegurado'];
   $idcotizacion = $_POST['idcotizacion'];

   $actualizacliente = $_POST['actualizacliente'];

   $resP = $serviciosReferencias->traerProductosPorId($id);
   $idcuestionario = mysql_result($resP,0,'refcuestionarios');

   $arRespuestas = array();
   $arErrores = array();

   $resV['errorinsert'] = false;

   //echo die(var_dump($idcuestionario));

   if ($idcuestionario == null) {
      $ar = array('cuestionario'=>'','rules'=>'');
   } else {
      if ($actualizacliente == 1) {
         $res = $serviciosReferencias->cuestionarioPersonas($idcuestionario,$idcotizacion,$_POST['refclientes'],0);
         $resAux = $serviciosReferencias->CuestionarioAuxPersonas($idcuestionario,$idcotizacion,$_POST['refclientes'],0);
      } else {
         $res = $serviciosReferencias->cuestionarioPersonas($idcuestionario,$idcotizacion,0,$refasegurados);
         $resAux = $serviciosReferencias->CuestionarioAuxPersonas($idcuestionario,$idcotizacion,0,$refasegurados);
      }


      if ($refclientes == 0) {
         $preguntasSencibles = $serviciosReferencias->necesitoPreguntaSencibleAsegurado($refasegurados,$idcuestionario);
      } else {
         $preguntasSencibles = $serviciosReferencias->necesitoPreguntaSencible($_POST['refclientes'],$idcuestionario);
      }


      $pregunta = '';
      $iRadio = 0;
      $cantRadio = 0;
      $iCheck = 0;
      $iCheckM = 0;
      $collapse = '';
      $collapseAux = '';
      $collapsePregunta = '';

      $primero = 0;
      $cad = '';

      foreach ($resAux as $valor) {
         $cad .= $valor['divRow'];
         $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
            <h4>'.$valor['pregunta'].'</h4>
         </div>';
         $cad .= $valor['respuestas'];
         $cad .= '</div>';

      }

      $ar = array('cuestionario'=>$cad,'rules'=>$res['rules']);
   }

   //die(var_dump($cad));

   $resV['error'] = false;

   $bandera = 0;
   $idpregunta = 0;
   $evaluoVerdadero = 1;
   $errorGeneral = 0;
   $tipo = '';
   $pregunta = '';
   $existio4 = 0;

   /*
   refpreguntascuestionario
   refrespuestascuestionario
   pregunta
   respuesta
   respuestavalor
   */

   $dependePreguntaID = '';
   $dependeRespuestaID = '';
   $dependeValor = '';
   $ultimaDependeAux = '';


   foreach ($ar['rules'] as $valor) {
      $pregunta = $valor['pregunta'];



      // $array[3] se actualizará con cada valor de $array...
      if ($valor['tipo'] == 1) {
         if (!(isset($_POST[$valor['respuesta']]))) {
            if ($valor['obligatoria'] == '1') {
               if ($dependeValor == '') {
                  $resV['error'] = true;
                  array_push($arErrores,array('error' => 'Debe completar la respuesta','pregunta'=>$pregunta));
               } else {
                  if ($dependeValor == $valor['dependerespuestaaux']) {
                     array_push($arErrores,array('error' => 'Debe completar la respuesta','pregunta'=>$pregunta));
                  }
               }

            }

         } else {
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $valor['idrespuesta'],
                  'pregunta' => $pregunta,
                  'respuesta' => 'Lo que el ususario ingrese',
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }
      }

      if ($valor['tipo'] == 2) {
         if (!(isset($_POST[$valor['respuesta']]))) {
            if ($valor['obligatoria'] == '1') {
               if ($dependeValor == '') {
                  $resV['error'] = true;
                  array_push($arErrores,array('error' => 'Debe elegir una respuesta','pregunta'=>$pregunta));
               } else {
                  if ($dependeValor == $valor['dependerespuestaaux']) {
                     $resV['error'] = true;
                     array_push($arErrores,array('error' => 'Debe elegir una respuesta','pregunta'=>$pregunta));
                  }
               }

            }
         } else {
            $rRespuesta = $serviciosReferencias->traerRespuestascuestionarioPorId($_POST[$valor['respuesta']]);
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $_POST[$valor['respuesta']],
                  'pregunta' => $pregunta,
                  'respuesta' => mysql_result($rRespuesta,0,'respuesta'),
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }
      }

      if ($valor['tipo'] == 3) {
         if (!(isset($_POST[$valor['respuesta']]))) {
            if ($valor['obligatoria'] == '1') {
               if ($dependeValor == '') {
                  $resV['error'] = true;
                  array_push($arErrores,array('error' => 'Debe elegir una respuesta','pregunta'=>$pregunta));
               } else {
                  if ($dependeValor == $valor['dependerespuestaaux']) {
                     $resV['error'] = true;
                     array_push($arErrores,array('error' => 'Debe elegir una respuesta','pregunta'=>$pregunta));
                  }
               }

            }
         } else {
            $rRespuesta = $serviciosReferencias->traerRespuestascuestionarioPorId($_POST[$valor['respuesta']]);
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $_POST[$valor['respuesta']],
                  'pregunta' => $pregunta,
                  'respuesta' => mysql_result($rRespuesta,0,'respuesta'),
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }
      }

      if ($valor['tipo'] == 4) {
         $existio4 = 1;
         if ($idpregunta != $valor['idpregunta']) {
            $idpregunta = $valor['idpregunta'];


            if (($bandera == 1) && ($evaluoVerdadero == 1)) {
               if ($valor['obligatoria'] == '1') {
                  if ($dependeValor == '') {
                     $errorGeneral = 1;
                     array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
                     $resV['error'] = true;
                  } else {
                     if ($dependeValor == $valor['dependerespuestaaux']) {
                        $errorGeneral = 1;
                        array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
                        $resV['error'] = true;
                     }
                  }

               }

               $evaluoVerdadero = 1;

            }


            $bandera = 0;

         }
         if ((isset($_POST[$valor['respuesta']]))) {
            $evaluoVerdadero = 0;
            //// ya lo inserto porque seria el primero
            $rRespuesta = $serviciosReferencias->traerRespuestascuestionarioPorId($valor['idrespuesta']);
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $valor['idrespuesta'],
                  'pregunta' => $pregunta,
                  'respuesta' => mysql_result($rRespuesta,0,'respuesta'),
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }


         $bandera = 1;
      }


      if ((integer)$valor['depende'] > 0) {
         if (isset($_POST[$valor['respuesta']])) {
            $dependePreguntaID = $valor['depende'];
            $dependeRespuestaID = $valor['dependerespuesta'];
            $dependeValor = $_POST[$valor['respuesta']];
         } else {
            $dependePreguntaID = $valor['depende'];
            $dependeRespuestaID = $valor['dependerespuesta'];
            $dependeValor = 0;
         }

      }

      if ((integer)($valor['depende'] == 0) && (integer)($valor['dependeaux'] == 0)) {
         $dependePreguntaID = '';
         $dependeRespuestaID = '';
         $dependeValor = '';
      }

      $ultimaDependeAux = $valor['dependerespuestaaux'];
   }

   //die(var_dump($arRespuestas));

   if (($bandera == 1) && ($evaluoVerdadero == 1) && ($existio4 == 1)) {
      if ($dependeValor == '') {
         $errorGeneral = 1;
         array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
         $resV['error'] = true;
      } else {
         if ($dependeValor == $ultimaDependeAux) {
            $errorGeneral = 1;
            array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
            $resV['error'] = true;
         }
      }

   }

   $resV['errores'] = $arErrores;

   if ($resV['error'] == false) {

      if ((integer)$idcotizacion > 0) {
         /**** toda la perta del cuestionario ***/
         $resP = $serviciosReferencias->traerProductosPorId($id);
         $idcuestionario = mysql_result($resP,0,'refcuestionarios');

         $resI = '';

         foreach ($arRespuestas as $item) {
            foreach ($preguntasSencibles[1] as $itemsencibles) {
               if ($itemsencibles['idpreguntanecesario'] == $item['refpreguntascuestionario']) {
                  $resPP = $serviciosReferencias->traerPreguntascuestionarioPorId($item['refpreguntascuestionario']);
                  $resPS = $serviciosReferencias->traerPreguntaSenciblePorId(mysql_result($resPP,0,'refpreguntassencibles'));

                  if (mysql_num_rows($resPS)>0) {
                     if ($refclientes == 0) {
                        $resMC = $serviciosReferencias->modificarCampoParticularAsegurados($refasegurados,mysql_result($resPS,0,'campo'),$item['respuestavalor']);
                     } else {
                        $resMC = $serviciosReferencias->modificarCampoParticularClientes($refclientes,mysql_result($resPS,0,'campo'),$item['respuestavalor']);
                     }

                  }
               }
            }


         }

         if ($actualizacliente == 0) {
            if ($refclientes == 0) {
               $resMCA = $serviciosReferencias->modificarCotizacionesAsegurado($idcotizacion,'1',$refasegurados);
            } else {
               $resMCA = $serviciosReferencias->modificarCotizacionesAsegurado($idcotizacion,'0',0);
            }
         } else {
            if ($_POST['tieneasegurado'] != '') {
               $resMCA = $serviciosReferencias->modificarCotizacionesAsegurado($idcotizacion,'0',0);
            }

         }



         //die(var_dump($resI));
         /**** fin cuestionario     ****/

         $resV['idcotizacion']= $idcotizacion;
      } else {
         $resV['errorinsert'] = true;
         $resV['mensaje'] = 'Ocurrio un error al insertar los datos, intente nuevamente '.$sqlC;

      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarAsegurados($serviciosReferencias) {
   session_start();

   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $razonsocial = '';

   $ine = '';
   $curp = $_POST['curp'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $numerocliente = '';
   $refusuarios = 0;
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $reftipopersonas = 1;

   $idclienteinbursa = '';
   $emisioncomprobantedomicilio = '';
   $emisionrfc = '';
   $vencimientoine = '';


   $refclientes = $_POST['refclientes'];
   $reftipoparentesco = $_POST['reftipoparentesco'];

   /*
   $domicilio = $_POST['domicilio'];
   $email = $_POST['email'];
   $rfc = $_POST['rfc'];
   $colonia = $_POST['colonia'];
   $municipio = $_POST['municipio'];
   $codigopostal = $_POST['codigopostal'];
   $edificio = $_POST['edificio'];
   $nroexterior = $_POST['nroexterior'];
   $nrointerior = $_POST['nrointerior'];
   $estado = $_POST['estado'];
   $ciudad = '';
   $telefonofijo = $_POST['telefonofijo'];
   $telefonocelular = $_POST['telefonocelular'];
   */

   $domicilio = '';
   $email = '';
   $rfc = '';
   $colonia = '';
   $municipio = '';
   $codigopostal = '';
   $edificio = '';
   $nroexterior = '';
   $nrointerior = '';
   $estado = '';
   $ciudad = '';
   $telefonofijo = '';
   $telefonocelular = '';

   $parentesco = $_POST['parentesco'];

   $resCliente = $serviciosReferencias->traerClientesPorId($refclientes);

   $genero = $_POST['genero'];
   $refestadocivil = $_POST['refestadocivil'];

   $res = $serviciosReferencias->insertarAsegurados($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$refclientes,$reftipoparentesco,$fechanacimiento,$parentesco,$genero,$refestadocivil);

   if ((integer)$res > 0) {
      $resV['error'] = false;
      $resV['id'] = $res;
      $resM1 = $serviciosReferencias->modificarCampoParticularAsegurados($res,'email',mysql_result($resCliente,0,'email'));
      $resM2 = $serviciosReferencias->modificarCampoParticularAsegurados($res,'telefonofijo',mysql_result($resCliente,0,'telefonofijo'));
      echo '';
   } else {
      $resV['error'] = true;
      $resV['id'] = 0;
      echo 'Hubo un error al insertar datos ';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarAsegurados($serviciosReferencias) {
   $id = $_POST['id'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $razonsocial = '';
   $domicilio = $_POST['domicilio'];
   $email = $_POST['email'];
   $rfc = $_POST['rfc'];
   $ine = '';
   $curp = $_POST['curp'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $numerocliente = '';
   $refusuarios = 0;
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $reftipopersonas = 1;
   $telefonofijo = $_POST['telefonofijo'];
   $telefonocelular = $_POST['telefonocelular'];
   $idclienteinbursa = '';
   $emisioncomprobantedomicilio = '';
   $emisionrfc = '';
   $vencimientoine = '';
   $colonia = $_POST['colonia'];
   $municipio = $_POST['municipio'];
   $codigopostal = $_POST['codigopostal'];
   $edificio = $_POST['edificio'];
   $nroexterior = $_POST['nroexterior'];
   $nrointerior = $_POST['nrointerior'];
   $estado = $_POST['estado'];
   $ciudad = '';
   $refclientes = $_POST['refclientes'];
   $reftipoparentesco = $_POST['reftipoparentesco'];

   $parentesco = $_POST['parentesco'];

   $genero = $_POST['genero'];
   $refestadocivil = $_POST['refestadocivil'];

   $res = $serviciosReferencias->modificarAsegurados($id,$reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechamodi,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$refclientes,$reftipoparentesco,$parentesco,$genero, $refestadocivil);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarAsegurados($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarAsegurados($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}



function traerBeneficiariosPorCliente($serviciosReferencias, $serviciosFunciones) {
   $refclientes = $_POST['refclientes'];
   $idcotizacion = $_POST['idcotizacion'];

   if ($idcotizacion > 0) {
      $resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($idcotizacion);
      $idnot = mysql_result($resCotizacion,0,'refasegurados');
   } else {
      $idnot = 0;
   }

   $res = $serviciosReferencias->traerBeneficiariosPorClienteCompleto($refclientes,$idnot);

   if ((integer)$res > 0) {
      $resV['error'] = false;
      $resV['dato'] = $serviciosFunciones->devolverSelectBox($res,array(3,4,2),' ')."<option value=''>Nuevo</option>";
   } else {
      $resV['error'] = true;
      $resV['dato'] = "<option value=''>-- Seleccionar --</option><option value=''>Nuevo</option>";
   }

   header('Content-type: application/json');
   echo json_encode($resV);


}

function traerAseguradosPorCliente($serviciosReferencias, $serviciosFunciones) {
   $refclientes = $_POST['refclientes'];

   $res = $serviciosReferencias->traerAseguradosPorClienteCompleto($refclientes);

   if ((integer)$res > 0) {
      $resV['error'] = false;
      $resV['dato'] = "<option value=''>-- Seleccionar --</option>".$serviciosFunciones->devolverSelectBox($res,array(3,4,2),' ')."<option value=''>Nuevo</option>";
   } else {
      $resV['error'] = true;
      $resV['dato'] = "<option value=''>-- Seleccionar --</option><option value=''>Nuevo</option>";
   }

   header('Content-type: application/json');
   echo json_encode($resV);


}


function traerAseguradosPorId($serviciosReferencias, $serviciosFunciones) {
   $refclientes = $_POST['id'];

   $res = $serviciosReferencias->traerAseguradosPorId($refclientes);

   if ((integer)$res > 0) {
      $resV['error'] = false;
      $resV['dato'] = $serviciosFunciones->devolverSelectBox($res,array(3,4,2),' ');
   } else {
      $resV['error'] = true;
      $resV['dato'] = "<option value=''>-- Seleccionar --</option><option value=''>Nuevo</option>";
   }

   header('Content-type: application/json');
   echo json_encode($resV);


}


function insertarMejorarcondiciones($serviciosReferencias) {
   $refclientes = $_POST['refclientes'];
   $refproductos = $_POST['refproductos'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $observaciones = $_POST['observaciones'];
   $res = $serviciosReferencias->insertarMejorarcondiciones($refclientes,$refproductos,$fechacrea,$fechamodi,$observaciones);

   if ((integer)$res > 0) {
      $resV['error'] = false;
      $resV['dato'] = $res;
   } else {
      $resV['error'] = true;
      $resV['msgerror'] = 'Hubo un error al insertar datos';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}


function nuevoOrdenPreguntas($serviciosReferencias) {
   $idcuestionario = $_POST['idcuestionario'];

   $res = $serviciosReferencias->nuevoOrdenPreguntas($idcuestionario);

   $ar = array();

   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);

}

function traerPreguntassenciblesPorCuestionario($serviciosReferencias, $serviciosFunciones) {
   $idcuestionario = $_POST['idcuestionario'];

   $res = $serviciosReferencias->traerPreguntassenciblesPorCuestionario($idcuestionario);
   $cadRef = $serviciosFunciones->devolverSelectBox($res,array(1),'');

   echo $cadRef;

}


function insertarComerciofin($serviciosReferencias) {
   $emresponse = $_POST['emresponse'];
   $emtotal = $_POST['emtotal'];
   $emordenid = $_POST['emordenid'];
   $emmerchant = $_POST['emmerchant'];
   $emstore = $_POST['emstore'];
   $emterm = $_POST['emterm'];
   $emrefnum = $_POST['emrefnum'];
   $emauth = $_POST['emauth'];
   $emdigest = $_POST['emdigest'];
   $token = $_POST['token'];

   $res = $serviciosReferencias->insertarComerciofin($emresponse,$emtotal,$emordenid,$emmerchant,$emstore,$emterm,$emrefnum,$emauth,$emdigest,$token);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarComerciofin($serviciosReferencias) {
   $id = $_POST['id'];
   $emresponse = $_POST['emresponse'];
   $emtotal = $_POST['emtotal'];
   $emordenid = $_POST['emordenid'];
   $emmerchant = $_POST['emmerchant'];
   $emstore = $_POST['emstore'];
   $emterm = $_POST['emterm'];
   $emrefnum = $_POST['emrefnum'];
   $emauth = $_POST['emauth'];
   $emdigest = $_POST['emdigest'];
   $token = $_POST['token'];

   $res = $serviciosReferencias->modificarComerciofin($id,$emresponse,$emtotal,$emordenid,$emmerchant,$emstore,$emterm,$emrefnum,$emauth,$emdigest,$token);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarComerciofin($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarComerciofin($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerComerciofin($serviciosReferencias) {
   $res = $serviciosReferencias->traerComerciofin();
   $ar = array();

   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarComercioinicio($serviciosReferencias) {
   session_start();

   $token = $_POST['token'];
   $comtotal = $_POST['comtotal'];
   $comcurrency = $_POST['comcurrency'];
   $comaddres = $_POST['comaddres'];
   $comorderid = $_POST['comorderid'];
   $commerchant = $_POST['commerchant'];
   $comstore = $_POST['comstore'];
   $comterm = $_POST['comterm'];
   $comdigest = $_POST['comdigest'];
   $urlback = $_POST['urlback'];
   $reforigencomercio = $_POST['reforigencomercio'];
   $refestadotransaccion = 1;
   $refafiliados = $_POST['refafiliados'];
   $fechacrea = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $vigencia = $_POST['vigencia'];
   $observaciones = $_POST['observaciones'];

   $usuariomodi = $_SESSION['usua_sahilices'];

   $res = $serviciosReferencias->insertarComercioinicio($token,$comtotal,$comcurrency,$comaddres,$comorderid,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarComercioinicio($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $token = $_POST['token'];
   $comtotal = $_POST['comtotal'];
   $comcurrency = $_POST['comcurrency'];
   $comaddres = $_POST['comaddres'];
   $comorderid = $_POST['comorderid'];
   $commerchant = $_POST['commerchant'];
   $comstore = $_POST['comstore'];
   $comterm = $_POST['comterm'];
   $comdigest = $_POST['comdigest'];
   $urlback = $_POST['urlback'];
   $reforigencomercio = $_POST['reforigencomercio'];
   $refestadotransaccion = $_POST['refestadotransaccion'];
   $refafiliados = $_POST['refafiliados'];
   $fechacrea = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $vigencia = $_POST['vigencia'];
   $observaciones = $_POST['observaciones'];

   $usuariomodi = $_SESSION['usua_sahilices'];

   $res = $serviciosReferencias->modificarComercioinicio($id,$token,$comtotal,$comcurrency,$comaddres,$comorderid,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarComercioinicio($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarComercioinicio($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerComercioinicio($serviciosReferencias) {
   $res = $serviciosReferencias->traerComercioinicio();
   $ar = array();

   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;
   header('Content-type: application/json');
   echo json_encode($resV);
}



function traerDocumentacionPorFamiliarDocumentacion($serviciosReferencias) {

   $idasociado = $_POST['idfamiliar'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacion($idasociado,$iddocumentacion);

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
         $imagen = '../../archivos/familiares/'.$idasociado.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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


function modificarEstadoDocumentacionFamiliares($serviciosReferencias) {
   session_start();

   $iddocumentacionasociado = $_POST['iddocumentacionfamiliar'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionasociado == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionFamiliares($iddocumentacionasociado,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarFamiliarUnicaDocumentacion($serviciosReferencias) {
   $idpostulante = $_POST['idasociado'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarFamiliarUnicaDocumentacion($idpostulante, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}


function traerDocumentacionPorClienteDocumentacion($serviciosReferencias) {

   $idasociado = $_POST['idcliente'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosReferencias->traerDocumentacionPorClienteDocumentacion($idasociado,$iddocumentacion);

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
         $imagen = '../../archivos/clientes/'.$idasociado.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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


function modificarEstadoDocumentacionClientes($serviciosReferencias) {
   session_start();

   $iddocumentacionasociado = $_POST['iddocumentacioncliente'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionasociado == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionClientes($iddocumentacionasociado,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarClienteUnicaDocumentacion($serviciosReferencias) {
   $idpostulante = $_POST['idasociado'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarClienteUnicaDocumentacion($idpostulante, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}



function insertarProductosexclusivos($serviciosReferencias) {
   $refproductos = $_POST['refproductos'];
   $refasesores = $_POST['refasesores'];

   $res = $serviciosReferencias->insertarProductosexclusivos($refproductos,$refasesores);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarProductosexclusivos($serviciosReferencias) {
   $id = $_POST['id'];
   $refproductos = $_POST['refproductos'];
   $refasesores = $_POST['refasesores'];

   $res = $serviciosReferencias->modificarProductosexclusivos($id,$refproductos,$refasesores);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarProductosexclusivos($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarProductosexclusivos($id);
   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerClientesPorId($serviciosReferencias) {
   $idcliente = $_POST['idcliente'];

   $resC = $serviciosReferencias->traerClientesPorId($idcliente);

   if (mysql_num_rows($resC) > 0) {
      $resV['cliente'] = $resC[0];
      $resV['error'] = false;
   } else {
      $resV['cliente'] = array('reftipopersonas' => 0);
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}

function traerPreguntascuestionarioPorCuestionario($serviciosReferencias, $serviciosFunciones) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerPreguntascuestionarioPorCuestionario($id);
   $varCad = '<option value="0">-- Seleccionar --</option>';
   $varCad .= $serviciosFunciones->devolverSelectBox($res,array(3),'');

   echo $varCad;
}

function traerRespuestascuestionarioPorPregunta($serviciosReferencias, $serviciosFunciones) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerRespuestascuestionarioPorPregunta($id);
   if (mysql_num_rows($res)>0) {
      $varCad = $serviciosFunciones->devolverSelectBox($res,array(1),'');
   } else {
      $varCad = '<option value="0">-- Seleccionar --</option>';
   }


   echo $varCad;
}

// valida primer cuestionario cuestionario1
function validarCuestionario($serviciosReferencias) {
   $id = $_POST['refproductos'];
   $refclientes = $_POST['refclientes'];
   $lead = $_POST['lead'];


   $preguntasSeleccionadas = '';
   foreach($_POST as $nombre_campo => $valor){
      //$asignacion .= "\$" . $nombre_campo . "='" . $valor . "';<br>";
      if (strpos($nombre_campo,"rulesPregunta") !== false) {
         $preguntasSeleccionadas .= $valor.',';
      }
      //eval($asignacion);
   }




   $resP = $serviciosReferencias->traerProductosPorId($id);
   $idcuestionario = mysql_result($resP,0,'refcuestionarios');

   $arRespuestas = array();
   $arErrores = array();

   $resV['errorinsert'] = false;

   //echo die(var_dump($idcuestionario));

   if ($idcuestionario == null) {
      $ar = array('cuestionario'=>'','rules'=>'');
   } else {
      $res = $serviciosReferencias->CuestionarioPreguntasSeleccionadas($idcuestionario,0,$refclientes,$preguntasSeleccionadas);
      $resAux = $serviciosReferencias->CuestionarioAux($idcuestionario,0,$refclientes);

      $preguntasSencibles = $serviciosReferencias->necesitoPreguntaSencible($refclientes,$idcuestionario);

      $pregunta = '';
      $iRadio = 0;
      $cantRadio = 0;
      $iCheck = 0;
      $iCheckM = 0;
      $collapse = '';
      $collapseAux = '';
      $collapsePregunta = '';

      $primero = 0;
      $cad = '';

      foreach ($resAux as $valor) {
         $cad .= $valor['divRow'];
         $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
            <h4>'.$valor['pregunta'].'</h4>
         </div>';
         $cad .= $valor['respuestas'];
         $cad .= '</div>';

      }

      $ar = array('cuestionario'=>$cad,'rules'=>$res['rules']);
   }

   $resV['error'] = false;

   $bandera = 0;
   $idpregunta = 0;
   $evaluoVerdadero = 1;
   $errorGeneral = 0;
   $tipo = '';
   $pregunta = '';
   $existio4 = 0;

   /*
   refpreguntascuestionario
   refrespuestascuestionario
   pregunta
   respuesta
   respuestavalor
   */

   $dependePreguntaID = '';
   $dependeRespuestaID = '';
   $dependeValor = '';
   $ultimaDependeAux = '';


   foreach ($ar['rules'] as $valor) {
      $pregunta = $valor['pregunta'];



      // $array[3] se actualizará con cada valor de $array...
      if ($valor['tipo'] == 1) {
         if (!(isset($_POST[$valor['respuesta']]))) {
            if ($valor['obligatoria'] == '1') {
               if ($dependeValor == '') {
                  $resV['error'] = true;
                  array_push($arErrores,array('error' => 'Debe completar la respuesta','pregunta'=>$pregunta));
               } else {
                  if ($dependeValor == $valor['dependerespuestaaux']) {
                     array_push($arErrores,array('error' => 'Debe completar la respuesta ','pregunta'=>$pregunta));
                  }
               }

            }

         } else {
            if ($_POST[$valor['respuesta']] != '') {
               array_push($arRespuestas,
                     array('refpreguntascuestionario' => $valor['idpregunta'],
                     'refrespuestascuestionario' => $valor['idrespuesta'],
                     'pregunta' => $pregunta,
                     'respuesta' => 'Lo que el ususario ingrese',
                     'respuestavalor' => $_POST[$valor['respuesta']])
                  );
            }

         }
      }

      if ($valor['tipo'] == 2) {
         if (!(isset($_POST[$valor['respuesta']]))) {
            if ($valor['obligatoria'] == '1') {
               if ($dependeValor == '') {
                  $resV['error'] = true;
                  array_push($arErrores,array('error' => 'Debe elegir una respuesta','pregunta'=>$pregunta));
               } else {
                  if ($dependeValor == $valor['dependerespuestaaux']) {
                     $resV['error'] = true;
                     array_push($arErrores,array('error' => 'Debe elegir una respuesta','pregunta'=>$pregunta));
                  }
               }

            }
         } else {
            $rRespuesta = $serviciosReferencias->traerRespuestascuestionarioPorId($_POST[$valor['respuesta']]);
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $_POST[$valor['respuesta']],
                  'pregunta' => $pregunta,
                  'respuesta' => mysql_result($rRespuesta,0,'respuesta'),
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }
      }

      if ($valor['tipo'] == 3) {
         if (!(isset($_POST[$valor['respuesta']]))) {
            if ($valor['obligatoria'] == '1') {
               if ($dependeValor == '') {
                  $resV['error'] = true;
                  array_push($arErrores,array('error' => 'Debe elegir una respuesta'.$valor['idpregunta'],'pregunta'=>$pregunta));
               } else {
                  if ($dependeValor == $valor['dependerespuestaaux']) {
                     $resV['error'] = true;
                     array_push($arErrores,array('error' => 'Debe elegir una respuesta'.$valor['idpregunta'],'pregunta'=>$pregunta));
                  }
               }

            }
         } else {
            $rRespuesta = $serviciosReferencias->traerRespuestascuestionarioPorId($_POST[$valor['respuesta']]);
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $_POST[$valor['respuesta']],
                  'pregunta' => $pregunta,
                  'respuesta' => mysql_result($rRespuesta,0,'respuesta'),
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }
      }

      if ($valor['tipo'] == 4) {
         $existio4 = 1;
         if ($idpregunta != $valor['idpregunta']) {
            $idpregunta = $valor['idpregunta'];


            if (($bandera == 1) && ($evaluoVerdadero == 1)) {
               if ($valor['obligatoria'] == '1') {
                  if ($dependeValor == '') {
                     $errorGeneral = 1;
                     array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
                     $resV['error'] = true;
                  } else {
                     if ($dependeValor == $valor['dependerespuestaaux']) {
                        $errorGeneral = 1;
                        array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
                        $resV['error'] = true;
                     }
                  }

               }

               $evaluoVerdadero = 1;

            }


            $bandera = 0;

         }
         if ((isset($_POST[$valor['respuesta']]))) {
            $evaluoVerdadero = 0;
            //// ya lo inserto porque seria el primero
            $rRespuesta = $serviciosReferencias->traerRespuestascuestionarioPorId($valor['idrespuesta']);
            array_push($arRespuestas,
                  array('refpreguntascuestionario' => $valor['idpregunta'],
                  'refrespuestascuestionario' => $valor['idrespuesta'],
                  'pregunta' => $pregunta,
                  'respuesta' => mysql_result($rRespuesta,0,'respuesta'),
                  'respuestavalor' => $_POST[$valor['respuesta']])
               );
         }


         $bandera = 1;
      }


      if ((integer)$valor['depende'] > 0) {
         if (isset($_POST[$valor['respuesta']])) {
            $dependePreguntaID = $valor['depende'];
            $dependeRespuestaID = $valor['dependerespuesta'];
            $dependeValor = $_POST[$valor['respuesta']];
         } else {
            $dependePreguntaID = $valor['depende'];
            $dependeRespuestaID = $valor['dependerespuesta'];
            $dependeValor = 0;
         }

      }

      if ((integer)($valor['depende'] == 0) && (integer)($valor['dependeaux'] == 0)) {
         $dependePreguntaID = '';
         $dependeRespuestaID = '';
         $dependeValor = '';
      }

      $ultimaDependeAux = $valor['dependerespuestaaux'];
   }

   //die(var_dump($arRespuestas));

   if (($bandera == 1) && ($evaluoVerdadero == 1) && ($existio4 == 1)) {
      if ($dependeValor == '') {
         $errorGeneral = 1;
         array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
         $resV['error'] = true;
      } else {
         if ($dependeValor == $ultimaDependeAux) {
            $errorGeneral = 1;
            array_push($arErrores,array('error' => 'Debe elegir al menos una respuesta','pregunta'=>$pregunta));
            $resV['error'] = true;
         }
      }

   }

   $resV['errores'] = $arErrores;

   //die(var_dump($arErrores));

   if ($resV['error'] == false) {
      session_start();


      $refproductos = $_POST['refproductos'];
      $refasesores = $_POST['refasesores'];
      $refasociados = ($_POST['refasociados'] == '' ? 'NULL' : $_POST['refasociados']);
      if ($_SESSION['idroll_sahilices'] != 7) {
         $refestadocotizaciones = 1;
      } else {
         $refestadocotizaciones = 1;
      }

      $observaciones = $_POST['observaciones'];

      $fechacrea = date('Y-m-d H:i:s');
      $fechamodi = date('Y-m-d H:i:s');
      $usuariocrea = $_SESSION['usua_sahilices'];
      $usuariomodi = $_SESSION['usua_sahilices'];
      $refusuarios = $_SESSION['usuaid_sahilices'];

      $tiponegocio = $_POST['tiponegocio'];

      if ($tiponegocio != 'Negocio nuevo') {
         $fechavencimiento = $_POST['fechavencimiento'];
         $coberturaactual = $_POST['coberturaactual'];
      } else {
         $fechavencimiento = '';
         $coberturaactual = '';
      }


      $cobertura = $_POST['cobertura'];
      $reasegurodirecto = $_POST['reasegurodirecto'];
      $fecharenovacion = $_POST['fecharenovacion'];
      $fechapropuesta = $fechacrea;

      $presentacotizacion = $_POST['presentacotizacion'];
      $fechaemitido = $fechacrea;

      $existeprimaobjetivo = $_POST['existeprimaobjetivo'];
      $primaobjetivo = ($_POST['primaobjetivo'] == '' ? 0 : $_POST['primaobjetivo']);

      $res = $serviciosReferencias->insertarCotizaciones($refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$existeprimaobjetivo,$primaobjetivo);

      $sqlC = $serviciosReferencias->insertarCotizacionesSQL($refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$existeprimaobjetivo,$primaobjetivo);

      if ((integer)$res > 0) {

         // modifico la cotizacion a la primer etapa
         $resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($res,'refestados',1,$usuariomodi);

         /**** toda la perta del cuestionario ***/
         $resP = $serviciosReferencias->traerProductosPorId($refproductos);
         $idcuestionario = mysql_result($resP,0,'refcuestionarios');

         $resI = '';

         foreach ($arRespuestas as $item) {
            foreach ($preguntasSencibles[1] as $itemsencibles) {
               if ($itemsencibles['idpreguntanecesario'] == $item['refpreguntascuestionario']) {
                  $resPP = $serviciosReferencias->traerPreguntascuestionarioPorId($item['refpreguntascuestionario']);
                  $resPS = $serviciosReferencias->traerPreguntaSenciblePorId(mysql_result($resPP,0,'refpreguntassencibles'));

                  if (mysql_num_rows($resPS)>0) {

                     $resMC = $serviciosReferencias->modificarCampoParticularClientes($refclientes,mysql_result($resPS,0,'campo'),$item['respuestavalor']);
                  }
               }
            }

            $resI .= $serviciosReferencias->insertarCuestionariodetalle(11,$res,$item['refpreguntascuestionario'],$item['refrespuestascuestionario'],$item['pregunta'],$item['respuesta'],$item['respuestavalor'],$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
         }


         //die(var_dump($resI));
         /**** fin cuestionario     ****/

         // cuando inserto una cotizacion nueva, veo si llega desde un lead y lo relaciono
         if ($lead > 0) {
            $resModificarLead = $serviciosReferencias->modificarLeadCotizacion($lead,$res,2);
         } else {
            if ($lead == -1) {
               $resInsertarLead = $serviciosReferencias->insertarLeadCompleto($refclientes,$refproductos,$fechacrea,$fechamodi,'0','','','',1,'','',1,7,$res);
            }
         }

         // hago esto porque todavia no tengo en claro porque me inserta dos veces una misma respuesta y pregunta
         $resResuelvoDuplicidad = $serviciosReferencias->resolverDuplicidadCuestionarioDetalle(11, $res);



         $resV['idcotizacion']= $res;
      } else {
         $resV['errorinsert'] = true;
         // acordate de sacar el sqlc
         $resV['mensaje'] = 'Ocurrio un error al insertar los datos, intente nuevamente '.$sqlC;

      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function cuestionario($serviciosReferencias) {
   $id = $_POST['id'];
   $idcotizacion = $_POST['idcotizacion'];
   $idcliente = $_POST['idcliente'];

   $resP = $serviciosReferencias->traerProductosPorId($id);
   $idcuestionario = mysql_result($resP,0,'refcuestionarios');

   //echo die(var_dump($idcuestionario));

   if ($idcuestionario == null) {
      $ar = array('cuestionario'=>'','rules'=>'');
   } else {
      $res = $serviciosReferencias->Cuestionario($idcuestionario,$idcotizacion);
      $resAux = $serviciosReferencias->CuestionarioAux($idcuestionario,$idcotizacion,$idcliente);


      $cad = '';
      //poner en local utf8_decode
      foreach ($resAux as $valor) {
         $cad .= $valor['divRow'];

         if ($valor['leyenda'] != '') {
           $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
              <h4><span>'.($valor['pregunta']).'</span> <i class="material-icons" style="color:grey;" data-toggle="tooltip" data-placement="top" title="'.($valor['leyenda']).'">help</i></h4>
              <input type="hidden" value="'.$valor['idpregunta'].'" name="rulesPregunta'.$valor['idpregunta'].'" id="rulesPregunta'.$valor['idpregunta'].'"/>
           </div>';
         } else {
           $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
              <h4>'.($valor['pregunta']).'</h4>
              <input type="hidden" value="'.$valor['idpregunta'].'" name="rulesPregunta'.$valor['idpregunta'].'" id="rulesPregunta'.$valor['idpregunta'].'"/>
           </div>';
         }

         $cad .= ($valor['respuestas']);

         /*$cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
            <h4>Pregunta</h4>
         </div>';
         $cad .= 'Respuesta';*/
         $cad .= '</div>';

      }
      //echo die(var_dump($res['rules']));

      $ar = array('cuestionario'=>$cad,'rules'=>$res['rules']);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode( $resV);

}


function cuestionarioPersonas($serviciosReferencias) {
   $id = $_POST['id'];
   $idcotizacion = $_POST['idcotizacion'];
   $idcliente = $_POST['idcliente'];
   $idasegurado = $_POST['idasegurado'];

   $resP = $serviciosReferencias->traerProductosPorId($id);
   $idcuestionario = mysql_result($resP,0,'refcuestionarios');

   //echo die(var_dump($idcuestionario));

   if ($idcuestionario == null) {
      $ar = array('cuestionario'=>'','rules'=>'');
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->CuestionarioPersonas($idcuestionario,$idcotizacion,$idcliente,$idasegurado);
      $resAux = $serviciosReferencias->CuestionarioAuxPersonas($idcuestionario,$idcotizacion,$idcliente,$idasegurado);

      //die(var_dump($resAux));
      $cad = '';

      $resV['error'] = false;
      $resV['sigue'] = true;

      foreach ($resAux as $valor) {
         $resV['sigue'] = false;
         $cad .= $valor['divRow'];
         $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
            <h4>'.$valor['pregunta'].'</h4>
         </div>';
         $cad .= $valor['respuestas'];
         $cad .= '</div>';

      }

      $ar = array('cuestionario'=>$cad,'rules'=>$res['rules']);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);

}


function insertarRespuestascuestionario($serviciosReferencias) {
   $respuesta = $_POST['respuesta'];
   $refpreguntascuestionario = $_POST['refpreguntascuestionario'];
   $orden = $_POST['orden'];
   $activo = $_POST['activo'];
   $leyenda = $_POST['leyenda'];
   $inhabilita = $_POST['inhabilita'];
   $refsolicitudesrespuestas = ($_POST['refsolicitudesrespuestas'] == '' ? 0 : $_POST['refsolicitudesrespuestas']);

   $res = $serviciosReferencias->insertarRespuestascuestionario($respuesta,$refpreguntascuestionario,$orden,$activo,$leyenda,0,$inhabilita,$refsolicitudesrespuestas);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarRespuestascuestionario($serviciosReferencias) {
   $id = $_POST['id'];
   $respuesta = $_POST['respuesta'];
   $refpreguntascuestionario = $_POST['refpreguntascuestionario'];
   $orden = $_POST['orden'];
   $activo = $_POST['activo'];
   $leyenda = $_POST['leyenda'];
   $inhabilita = $_POST['inhabilita'];
   $refsolicitudesrespuestas = ($_POST['refsolicitudesrespuestas'] == '' ? 0 : $_POST['refsolicitudesrespuestas']);

   $res = $serviciosReferencias->modificarRespuestascuestionario($id,$respuesta,$refpreguntascuestionario,$orden,$activo,$leyenda,$inhabilita,$refsolicitudesrespuestas);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarRespuestascuestionario($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarRespuestascuestionario($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerRespuestascuestionario($serviciosReferencias) {
   $res = $serviciosReferencias->traerRespuestascuestionario();
   $ar = array();

   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarPreguntascuestionario($serviciosReferencias) {
   $refcuestionarios = $_POST['refcuestionarios'];
   $reftiporespuesta = $_POST['reftiporespuesta'];
   $pregunta = $_POST['pregunta'];
   $orden = $_POST['orden'];
   $valor = $_POST['valor'];
   $depende = ( $_POST['depende'] == '' ? 0 :$_POST['depende']);
   $tiempo = $_POST['tiempo'];
   $activo = $_POST['activo'];

   if (isset($_POST['dependerespuesta'])) {
      $dependerespuesta = ($_POST['dependerespuesta'] == '' ? 0 : $_POST['dependerespuesta']);
   } else {
      $dependerespuesta = 0;
   }


   $obligatoria = $_POST['obligatoria'];
   $leyenda = $_POST['leyenda'];

   if ($valor == 1) {
      $orden = $serviciosReferencias->nuevoOrdenPreguntas($refcuestionarios);
   }

   if (isset($_POST['idps'])) {
      $idps = $_POST['idps'];
   } else {
      $idps = 0;
   }

   $res = $serviciosReferencias->insertarPreguntascuestionario($refcuestionarios,$reftiporespuesta,$pregunta,$orden,$valor,$depende,$tiempo,$activo,$dependerespuesta,$obligatoria,$leyenda,$idps);

   if ((integer)$res > 0) {
      if ($reftiporespuesta == 1) {
         $resRespuesta = $serviciosReferencias->insertarRespuestascuestionario('Respuesta escrita',$res,1,'1','',$idps,'0',0);
      }
      if ($reftiporespuesta == 2) {
         $resRespuesta1 = $serviciosReferencias->insertarRespuestascuestionario('Si',$res,1,'1','',$idps,'0',0);
         $resRespuesta2 = $serviciosReferencias->insertarRespuestascuestionario('No',$res,2,'1','',$idps,'0',0);
      }
      echo '';
   } else {
      echo 'Hubo un error al insertar datos '.$res;
   }
}

function modificarPreguntascuestionario($serviciosReferencias) {
   $id = $_POST['id'];
   $refcuestionarios = $_POST['refcuestionarios'];
   $reftiporespuesta = $_POST['reftiporespuesta'];
   $pregunta = $_POST['pregunta'];
   $orden = $_POST['orden'];
   $valor = $_POST['valor'];
   $depende = ($_POST['depende'] == '' ? 0 : $_POST['depende']);
   $tiempo = $_POST['tiempo'];
   $activo = $_POST['activo'];
   $dependerespuesta = ($_POST['dependerespuesta'] == '' ? 0 : $_POST['dependerespuesta']);
   $obligatoria = $_POST['obligatoria'];
   $leyenda = $_POST['leyenda'];

   $res = $serviciosReferencias->modificarPreguntascuestionario($id,$refcuestionarios,$reftiporespuesta,$pregunta,$orden,$valor,$depende,$tiempo,$activo,$dependerespuesta,$obligatoria,$leyenda);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarPreguntascuestionario($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarPreguntascuestionario($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function eliminarPreguntascuestionarioDefinitivo($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarPreguntascuestionarioDefinitivo($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerPreguntascuestionario($serviciosReferencias) {
   $res = $serviciosReferencias->traerPreguntascuestionario();
   $ar = array();

   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}


function insertarCuestionariodetalle($serviciosReferencias) {
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $refpreguntascuestionario = $_POST['refpreguntascuestionario'];
   $refrespuestascuestionario = $_POST['refrespuestascuestionario'];
   $pregunta = $_POST['pregunta'];
   $respuesta = $_POST['respuesta'];
   $respuestavalor = $_POST['respuestavalor'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->insertarCuestionariodetalle($reftabla,$idreferencia,$refpreguntascuestionario,$refrespuestascuestionario,$pregunta,$respuesta,$respuestavalor,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarCuestionariodetalle($serviciosReferencias) {
   $id = $_POST['id'];
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $refpreguntascuestionario = $_POST['refpreguntascuestionario'];
   $refrespuestascuestionario = $_POST['refrespuestascuestionario'];
   $pregunta = $_POST['pregunta'];
   $respuesta = $_POST['respuesta'];
   $respuestavalor = $_POST['respuestavalor'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_POST['usuariomodi'];

   $res = $serviciosReferencias->modificarCuestionariodetalle($id,$reftabla,$idreferencia,$refpreguntascuestionario,$refrespuestascuestionario,$pregunta,$respuesta,$respuestavalor,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarCuestionariodetalle($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarCuestionariodetalle($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerCuestionariodetalle($serviciosReferencias) {
   $res = $serviciosReferencias->traerCuestionariodetalle();
   $ar = array();

   while ($row = mysql_fetch_array($res)) {
      array_push($ar, $row);
   }

   $resV['datos'] = $ar;

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarCuestionarios($serviciosReferencias) {
   $cuestionario = $_POST['cuestionario'];
   $activo = $_POST['activo'];

   $res = $serviciosReferencias->insertarCuestionarios($cuestionario,$activo);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarCuestionarios($serviciosReferencias) {
   $id = $_POST['id'];
   $cuestionario = $_POST['cuestionario'];
   $activo = $_POST['activo'];

   $res = $serviciosReferencias->modificarCuestionarios($id,$cuestionario,$activo);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarCuestionarios($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarCuestionarios($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function eliminarCuestionariosDefinitivo($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarCuestionariosDefinitivo($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}



function insertarProductos($serviciosReferencias) {
   $producto = $_POST['producto'];
   $prima = $_POST['prima'];
   $reftipoproductorama = $_POST['reftipoproductorama'];
   $reftipodocumentaciones = $_POST['reftipodocumentaciones'];
   $puntosporventa = ( $_POST['puntosporventa'] == '' ? 0 : $_POST['puntosporventa']);
   $puntosporpesopagado = ( $_POST['puntosporpesopagado'] == '' ? 0 : $_POST['puntosporpesopagado']);
   $activo = $_POST['activo'];
   $refcuestionarios = ( $_POST['refcuestionarios'] == '' ? 0 : $_POST['refcuestionarios']);

   $puntosporventarenovado = ($_POST['puntosporventarenovado'] == '' ? 0 : $_POST['puntosporventarenovado']);
   $puntosporpesopagadorenovado = ($_POST['puntosporpesopagadorenovado'] == '' ? 0 : $_POST['puntosporpesopagadorenovado']);
   $reftipopersonas = ($_POST['reftipopersonas'] == '' ? 0 : $_POST['reftipopersonas']);

   $precio = ($_POST['precio'] == '' ? 0 : $_POST['precio']);
   $detalle = $_POST['detalle'];
   $ventaenlinea = $_POST['ventaenlinea'];
   $cotizaenlinea = $_POST['cotizaenlinea'];
   $beneficiario = $_POST['beneficiario'];
   $asegurado = $_POST['asegurado'];
   $reftipofirma = $_POST['reftipofirma'];
   $reftipoemision = $_POST['reftipoemision'];

   $esdomiciliado = $_POST['esdomiciliado'];
   $consolicitud = $_POST['consolicitud'];

   $res = $serviciosReferencias->insertarProductos($producto,$prima,$reftipoproductorama,$reftipodocumentaciones,$puntosporventa,$puntosporpesopagado,$activo,$refcuestionarios,$puntosporventarenovado,$puntosporpesopagadorenovado,$reftipopersonas,$precio,$detalle,$ventaenlinea,$cotizaenlinea,$beneficiario,$asegurado,$reftipofirma,$reftipoemision,$esdomiciliado,$consolicitud);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }


}

function modificarProductos($serviciosReferencias) {
   $id = $_POST['id'];
   $producto = $_POST['producto'];
   $prima = $_POST['prima'];
   $reftipoproductorama = $_POST['reftipoproductorama'];
   $reftipodocumentaciones = $_POST['reftipodocumentaciones'];
   $puntosporventa = ( $_POST['puntosporventa'] == '' ? 0 : $_POST['puntosporventa']);
   $puntosporpesopagado = ( $_POST['puntosporpesopagado'] == '' ? 0 : $_POST['puntosporpesopagado']);
   $activo = $_POST['activo'];
   $refcuestionarios = ( $_POST['refcuestionarios'] == '' ? 0 : $_POST['refcuestionarios']);

   $puntosporventarenovado = ($_POST['puntosporventarenovado'] == '' ? 0 : $_POST['puntosporventarenovado']);
   $puntosporpesopagadorenovado = ($_POST['puntosporpesopagadorenovado'] == '' ? 0 : $_POST['puntosporpesopagadorenovado']);

   $reftipopersonas = ($_POST['reftipopersonas'] == '' ? 0 : $_POST['reftipopersonas']);

   $precio = ($_POST['precio'] == '' ? 0 : $_POST['precio']);
   $detalle = $_POST['detalle'];
   $ventaenlinea = $_POST['ventaenlinea'];
   $cotizaenlinea = $_POST['cotizaenlinea'];
   $beneficiario = $_POST['beneficiario'];
   $asegurado = $_POST['asegurado'];
   $reftipofirma = $_POST['reftipofirma'];
   $reftipoemision = $_POST['reftipoemision'];

   $esdomiciliado = $_POST['esdomiciliado'];
   $consolicitud = $_POST['consolicitud'];

   $res = $serviciosReferencias->modificarProductos($id,$producto,$prima,$reftipoproductorama,$reftipodocumentaciones,$puntosporventa,$puntosporpesopagado,$activo,$refcuestionarios,$puntosporventarenovado,$puntosporpesopagadorenovado,$reftipopersonas,$precio,$detalle,$ventaenlinea,$cotizaenlinea,$beneficiario,$asegurado,$reftipofirma,$reftipoemision,$esdomiciliado,$consolicitud);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarProductos($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarProductos($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function modificarVentaUnicaDocumentacion($serviciosReferencias) {
   $idventa = $_POST['idventa'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarVentaUnicaDocumentacion($idventa, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);

}


function eliminarDocumentacionVenta($serviciosReferencias) {
   $idventa = $_POST['idventa'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $res = $serviciosReferencias->eliminarDocumentacionVenta($idventa, $iddocumentacion);

   header('Content-type: application/json');
   echo json_encode($res);
}


function traerDocumentacionPorVentaDocumentacion($serviciosReferencias) {

   $idventa = $_POST['idventa'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   if (($iddocumentacion == 35) || ($iddocumentacion == 147) || ($iddocumentacion == 148)) {
      $resFoto = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($idventa,$iddocumentacion);
      $carpetaDetalle = 'ventas';
   } else {
      $resFoto = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($idventa,$iddocumentacion);
      $carpetaDetalle = 'cobros';
   }


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
         $imagen = '../../archivos/'.$carpetaDetalle.'/'.$idventa.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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


function traerDocumentacionPorPagoDocumentacion($serviciosReferencias) {

   $idventa = $_POST['idventa'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosReferencias->traerDocumentacionPorPagoDocumentacion($idventa,$iddocumentacion);

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
         $imagen = '../../archivos/pagos/'.$idventa.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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


function modificarEstadoDocumentacionVentas($serviciosReferencias) {
   session_start();

   $iddocumentacionventa = $_POST['iddocumentacionventa'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionventa == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionVentas($iddocumentacionventa,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}


function modificarEstadoDocumentacionPagos($serviciosReferencias) {
   session_start();

   $iddocumentacionventa = $_POST['iddocumentacionventa'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionventa == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionPagos($iddocumentacionventa,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}


function traerTipoproductoramaPorTipoProducto($serviciosReferencias, $serviciosFunciones) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerTipoproductoramaPorTipoProducto($id);
   $cad = $serviciosFunciones->devolverSelectBox($res,array(1),'');

   echo $cad;

}


function insertarPeriodicidadventasdetalle($serviciosReferencias) {
   session_start();

   $refperiodicidadventas = $_POST['refperiodicidadventas'];
   $montototal = $_POST['montototal'];
   $primaneta = $_POST['primaneta'];
   $porcentajecomision = $_POST['porcentajecomision'];
   $montocomision = $_POST['montocomision'];
   $fechapago = $_POST['fechapago'];
   $fechavencimiento = $_POST['fechavencimiento'];
   $refestadopago = $_POST['refestadopago'];
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');

   $nrorecibo = $_POST['nrorecibo'];

   $fechapagoreal = $_POST['fechapagoreal'];

   $res = $serviciosReferencias->insertarPeriodicidadventasdetalle($refperiodicidadventas,$montototal,$primaneta,$porcentajecomision,$montocomision,$fechapago,$fechavencimiento,$refestadopago,$usuariocrea,$usuariomodi,$fechacrea,$fechamodi,$nrorecibo,$fechapagoreal);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarPeriodicidadventasdetalle($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refperiodicidadventas = $_POST['refperiodicidadventas'];
   $montototal = $_POST['montototal'];
   $primaneta = $_POST['primaneta'];
   $porcentajecomision = $_POST['porcentajecomision'];
   $montocomision = $_POST['montocomision'];
   $fechapago = $_POST['fechapago'];
   $fechavencimiento = $_POST['fechavencimiento'];
   $refestadopago = $_POST['refestadopago'];
   $nrorecibo = $_POST['nrorecibo'];

   $usuariomodi = $_SESSION['usua_sahilices'];

   $fechamodi = date('Y-m-d H:i:s');

   $fechapagoreal = $_POST['fechapagoreal'];

   $res = $serviciosReferencias->modificarPeriodicidadventasdetalle($id,$refperiodicidadventas,$montototal,$primaneta,$porcentajecomision,$montocomision,$fechapago,$fechavencimiento,$refestadopago,$usuariomodi,$fechamodi,$nrorecibo,$fechapagoreal);



   if ($res == true) {

      if ($refestadopago == 6) {
         ///aca

         $url = "cobranza/subirdocumentacioni.php?id=".$id;
         $token = $serviciosReferencias->GUID();
         $resAutoLogin = $serviciosReferencias->insertarAutologin(56,$token,$url,'0');

         $resultado 		= 	$serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);

         $nropoliza = mysql_result($resultado,0,'nropoliza');

         $nrorecibo = mysql_result($resultado,0,'nrorecibo');

         $cuerpo = '';

         $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

         $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

         $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

         $cuerpo .= "
         <style>
         	body { font-family: 'Lato', sans-serif; }
         	header { font-family: 'Prata', serif; }
         </style>";

         $cuerpo .= '<body>';

         $cuerpo .= '<h3><small><p>Un pago del recibo: <b>'.$nrorecibo.'</b> cuya poliza es: <b>'.$nropoliza.'</b> fue devuelto</small></h3><p>';

         $cuerpo .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</h4>';

      	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

         $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

         $cuerpo .= '</body>';

         // por ahora corregir email
         $email = 'msredhotero@gmail.com';

         $retorno = $serviciosReferencias->enviarEmail($email,'Se genero un pago, poliza: '.$nropoliza,utf8_decode($cuerpo));

      }
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarPeriodicidadventasdetalle($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarPeriodicidadventasdetalle($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function insertarPeriodicidadventas($serviciosReferencias) {
   $refventas = $_POST['refventas'];
   $reftipoperiodicidad = $_POST['reftipoperiodicidad'];
   $reftipocobranza = $_POST['reftipocobranza'];

   $banco = $_POST['banco'];
   $afiliacionnumber = $_POST['afiliacionnumber'];
   $tipotarjeta = $_POST['tipotarjeta'];

   $res = $serviciosReferencias->insertarPeriodicidadventas($refventas,$reftipoperiodicidad,$reftipocobranza,$banco,$afiliacionnumber,$tipotarjeta);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarVentas($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refcotizaciones = $_POST['refcotizaciones'];
   $refestadoventa = $_POST['refestadoventa'];
   $primaneta = ($_POST['primaneta'] == '' ? 0 : $_POST['primaneta']);
   $primatotal = ($_POST['primatotal'] == '' ? 0 : $_POST['primatotal']);

   $fechavencimientopoliza = $_POST['fechavencimientopoliza'];
   $nropoliza = $_POST['nropoliza'];

   $foliotys = $_POST['foliotys'];
   $foliointerno = $_POST['foliointerno'];

   $fechamodi = date('Y-m-d H:i:s');

   $usuariomodi = $_SESSION['usua_sahilices'];

   $error = '';

   if ($primatotal < $primaneta) {
      $error = ' La prima total no puede ser menor que la neta ';
   }

   if ($primatotal == 0 || $primaneta == 0) {
      $error .= '- La prima total o la neta no pueden ser igual a cero ';
   }

   // agregado el 13/11/2020 para los endosos y renovaciones, y los paquetes con mas de un producto
   $refproductosaux  = ($_POST['refproductosaux'] == '' ? 0 : $_POST['refproductosaux']);
   $refventas        = ($_POST['refventas'] == '' ? 0 : $_POST['refventas']);
   $version          = $_POST['version'];

   $refmotivorechazopoliza = ($_POST['refmotivorechazopoliza'] == '' ? 0 : $_POST['refmotivorechazopoliza']);
   $observaciones = $_POST['observaciones'];

   $vigenciadesde = $_POST['vigenciadesde'];

   if ($error == '') {
      $res = $serviciosReferencias->modificarVentas($id,$refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechamodi,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$refventas,$version,$refmotivorechazopoliza,$observaciones,$vigenciadesde);

      if ($res == true) {
         echo '';
      } else {
         echo 'Hubo un error al modificar datos';
      }
   } else {
      echo $error;
   }

}

function eliminarVentas($serviciosReferencias) {
   $id = $_POST['id'];
   $observaciones = $_POST['observaciones'];
   $estadoventa = $_POST['estadoventa'];
   $motivorechazo = $_POST['motivorechazo'];

   $res = $serviciosReferencias->cancelarVentas($id,$estadoventa,$observaciones,$motivorechazo);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerProductosPorTipo($serviciosReferencias, $serviciosFunciones) {
   $id = $_POST['id'];
   $reftipopersonas = $_POST['reftipopersonasaux'];
   $idasesor = $_POST['idasesor'];

   $res = $serviciosReferencias->traerProductosPorTipo($id,$reftipopersonas,$idasesor);
   $cad = $serviciosFunciones->devolverSelectBox($res,array(1),'');

   echo $cad;

}

function traerClientescarteraPorCliente($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerClientescarteraPorCliente($id);

   $cad = '';
   $bg = '';
   while ($row = mysql_fetch_array($res)) {
      if ($row['activo'] == '1') {
         switch ($row['reftipoproducto']) {
            case 1:
               $bg = 'teal';
            break;
            case 2:
               $bg = 'brown';
            break;
            case 3:
               $bg = 'indigo';
            break;
         }
         $cad .= '<li class="list-group-item">'.$row['producto'].' <span class="badge bg-'.$bg.'">'.$row['tipoproducto'].'</span></li>';
      }

   }

   echo $cad;
}

function modificarConstanciasseguimientoFinalizar($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerConstanciasseguimientoPorId($id);

   $resASesores = $serviciosReferencias->traerAsesoresPorId(mysql_result($res,0,'refasesores'));

   if ((mysql_result($res,0,'informado') == '1') && (mysql_result($res,0,'cumplio') != '')) {
      $resC = $serviciosReferencias->insertarConstancias(mysql_result($res,0,'refasesores'),mysql_result($res,0,'meses'),mysql_result($res,0,'cumplio'),date('Y-m-d H-i-s'),date('Y-m-d H-i-s'),mysql_result($resASesores,0,'fechaalta'),mysql_result($res,0,'importe'),mysql_result($res,0,'tipo'));

      if ((integer)$resC > 0) {
         $resM = $serviciosReferencias->modificarConstanciasseguimientoFinalizar($id,$resC);
         echo '';
      } else {
         echo 'Hubo un error al insertar datos';
      }
   } else {
      echo 'Faltan cargar datos para poder generar el bono';
   }
}


function insertarConstanciasseguimiento($serviciosReferencias) {
   $refasesores = $_POST['refasesores'];
   $meses = $_POST['meses'];
   $cumplio = $_POST['cumplio'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $base = $_POST['base'];
   $importe = ($_POST['importe'] == '' ? 0 : $_POST['importe']);
   $tipo = $_POST['tipo'];
   $informado = $_POST['informado'];
   $refconstancias = $_POST['refconstancias'];

   $res = $serviciosReferencias->insertarConstanciasseguimiento($refasesores,$meses,$cumplio,$fechacrea,$fechamodi,$base,$importe,$tipo,$informado,$refconstancias);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarConstanciasseguimiento($serviciosReferencias, $serviciosMensajes) {
   $id = $_POST['id'];
   $refasesores = $_POST['refasesores'];
   $meses = $_POST['meses'];
   $cumplio = $_POST['cumplio'];
   $fechacrea = $_POST['fechacrea'];
   $fechamodi = $_POST['fechamodi'];
   $base = $_POST['base'];
   $importe = ($_POST['importe'] == '' ? 0 : $_POST['importe']);
   $tipo = $_POST['tipo'];
   $informado = $_POST['informado'];
   $refconstancias = $_POST['refconstancias'];

   $error = '';

   if ($informado == '1') {
      if ($cumplio == '') {
         $error = 'Debe elegir si CUMPLIO o no ';
      }
      if (($cumplio == '1') && ($tipo == '')) {
         $error .= '- Debe elegir el Tipo de Bono ';
      }
   }

   if ($error == '') {
      $res = $serviciosReferencias->modificarConstanciasseguimiento($id,$refasesores,$meses,$cumplio,$fechacrea,$fechamodi,$base,$importe,$tipo,$informado,$refconstancias);

      if ($res == true) {

         if (($informado == '1') && ($cumplio == '1') && ($tipo == '0')) {
            $resC = $serviciosReferencias->insertarConstancias($refasesores,$meses,$cumplio,date('Y-m-d H-i-s'),date('Y-m-d H-i-s'),$base,$importe,$tipo);
            if ((integer)$resC > 0) {
               $resM = $serviciosReferencias->modificarConstanciasseguimientoFinalizar($id,$resC);
               echo '1';
            } else {
               echo 'Se modifico correctamente pero fallo al crear el bono';
            }
         } else {
            /* se saca por ahora
            if ($informado == '1') {
               $gerentecomercial = $serviciosReferencias->traerGerenteDelAsesor($refasesores);
               $mensaje = $serviciosMensajes->msgBonoReclutamiento($refasesores, $cumplio,$meses, $gerentecomercial);
            }
            */

            echo '';
         }


      } else {
         echo 'Hubo un error al modificar datos';
      }
   } else {
      echo $error;
   }
}



function insertarBonogestion($serviciosReferencias) {
   $bonoseguros = $_POST['bonoseguros'];
   $bonoafore = $_POST['bonoafore'];
   $bonobanca = $_POST['bonobanca'];

   $res = $serviciosReferencias->insertarBonogestion($bonoseguros,$bonoafore,$bonobanca);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarBonogestion($serviciosReferencias) {
   $id = $_POST['id'];
   $bonoseguros = $_POST['bonoseguros'];
   $bonoafore = $_POST['bonoafore'];
   $bonobanca = $_POST['bonobanca'];

   $res = $serviciosReferencias->modificarBonogestion($id,$bonoseguros,$bonoafore,$bonobanca);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarBonogestion($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarBonogestion($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function insertarConstancias($serviciosReferencias) {
   $refasesores = $_POST['refasesores'];
   $meses = $_POST['meses'];
   $cumplio = $_POST['cumplio'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $importe = ($_POST['importe'] == '' ? 0 : $_POST['importe']);
   $tipo = $_POST['tipo'];

   $resAsesor = $serviciosReferencias->traerAsesoresPorId($refasesores);

   $base = mysql_result($resAsesor,0,'fechaalta');

   $existe = $serviciosReferencias->existeConstancia($refasesores,$meses,'',0);

   if ($existe == 0) {
      $res = $serviciosReferencias->insertarConstancias($refasesores,$meses,$cumplio,$fechacrea,$fechamodi,$base,$importe,$tipo);

      if ((integer)$res > 0) {
         echo '';
      } else {
         echo 'Hubo un error al insertar datos';
      }
   } else {
      echo 'Hubo un error ya fue cargado este mes para este agente';
   }
}


function modificarConstancias($serviciosReferencias) {
   $id = $_POST['id'];
   $refasesores = $_POST['refasesores'];
   $meses = $_POST['meses'];
   $cumplio = $_POST['cumplio'];

   $fechamodi = date('Y-m-d H:i:s');

   $importe = ($_POST['importe'] == '' ? 0 : $_POST['importe']);
   $tipo = $_POST['tipo'];

   $resAsesor = $serviciosReferencias->traerAsesoresPorId($refasesores);

   $base = mysql_result($resAsesor,0,'fechaalta');

   $existe = $serviciosReferencias->existeConstancia($refasesores,$meses,'M',$id);

   if ($existe == 0) {
      $res = $serviciosReferencias->modificarConstancias($id,$refasesores,$meses,$cumplio,$fechamodi,$base,$importe,$tipo);

      if ($res == true) {
         echo '';
      } else {
         echo 'Hubo un error al modificar datos';
      }
   } else {
      echo 'Hubo un error ya fue cargado este mes para este agente';
   }
}

function eliminarConstancias($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarConstancias($id);

   if ($res == true) {
      $resCs = $serviciosReferencias->habilitarConstanciasseguimiento($id);
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerPersonaPorTabla($serviciosReferencias, $serviciosFunciones) {
   $tabla = $_POST['tabla'];

   $res = $serviciosReferencias->traerPersonaPorTabla($tabla);

   $resV['datos'] = '';
   $resV['error'] = false;

   switch ($tabla) {
      case 1:
         $cadRef = $serviciosFunciones->devolverSelectBox($res,array(3,4,2),' ');
      break;
      case 2:
         $cadRef = $serviciosFunciones->devolverSelectBox($res,array(2,3,4),' ');
      break;
      case 9:
         $cadRef = $serviciosFunciones->devolverSelectBox($res,array(3),'');
      break;
      case 10:
         $cadRef = $serviciosFunciones->devolverSelectBox($res,array(1),'');
      break;
      default:
         $cadRef = '<option value="">Sin Datos</option>';
   }

   $resV['datos'] = array('select' => $cadRef);

   header('Content-type: application/json');
   echo json_encode($resV);
}

function insertarComisiones($serviciosReferencias) {
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $monto = $_POST['monto'] == '' ? 0 : $_POST['monto'];
   $porcentaje = $_POST['porcentaje'] == '' ? 0 : $_POST['porcentaje'];
   $fechacreacion = date('Y-m-d H:i:s');

   $res = $serviciosReferencias->insertarComisiones($reftabla,$idreferencia,$monto,$porcentaje,$fechacreacion);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarComisiones($serviciosReferencias) {
   $id = $_POST['id'];
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $monto = $_POST['monto'] == '' ? 0 : $_POST['monto'];
   $porcentaje = $_POST['porcentaje'] == '' ? 0 : $_POST['porcentaje'];

   $res = $serviciosReferencias->modificarComisiones($id,$reftabla,$idreferencia,$monto,$porcentaje);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarComisiones($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarComisiones($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function insertarEspecialidades($serviciosReferencias) {
   $especialidad = $_POST['especialidad'];

   $res = $serviciosReferencias->insertarEspecialidades($especialidad);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarEspecialidades($serviciosReferencias) {
   $id = $_POST['id'];
   $especialidad = $_POST['especialidad'];

   $res = $serviciosReferencias->modificarEspecialidades($id,$especialidad);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}


function eliminarEspecialidades($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarEspecialidades($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerPerfilasesoresPorIdImagenCompleto($serviciosReferencias) {

   $id = $_POST['idperfilasesor'];
   $imagenbuscada = $_POST['imagen'];

   switch ($imagenbuscada) {
      case 1:
         $imagenbuscada = 'imagenperfil';
      break;
      case 2:
         $imagenbuscada = 'imagenfirma';
      break;
      case 3:
         $imagenbuscada = 'imagenlogo';
      break;
   }


   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosReferencias->traerPerfilasesoresPorIdImagenCompleto($id,$imagenbuscada);

   $imagen = '';

   if (mysql_num_rows($resFoto) > 0) {

      if (mysql_result($resFoto,0,$imagenbuscada) == '') {
         $imagen = '../../imagenes/sin_img.jpg';

         $resV['datos'] = array('imagen' => $imagen, 'type' => 'imagen');
         $resV['error'] = true;
      } else {

         $imagen = '../../'.mysql_result($resFoto,0,$imagenbuscada);

         $resV['datos'] = array('imagen' => $imagen, 'type' => 'jpg');

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


function insertarPerfilasesores($serviciosReferencias) {
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $imagenperfil = $_POST['imagenperfil'];
   $imagenfirma = $_POST['imagenfirma'];
   $urllinkedin = $_POST['urllinkedin'];
   $urlfacebook = $_POST['urlfacebook'];
   $urlinstagram = $_POST['urlinstagram'];
   $visible = $_POST['visible'];

   $urloficial = $_POST['urloficial'];
   $reftipofigura = $_POST['reftipofigura'];
   $marcapropia = $_POST['marcapropia'];

   $res = $serviciosReferencias->insertarPerfilasesores($reftabla,$idreferencia,$imagenperfil,$imagenfirma,$urllinkedin,$urlfacebook,$urlinstagram,$visible,$urloficial,$reftipofigura,$marcapropia);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarPerfilasesores($serviciosReferencias) {
   $id = $_POST['id'];
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $imagenperfil = $_POST['imagenperfil'];
   $imagenfirma = $_POST['imagenfirma'];
   $urllinkedin = $_POST['urllinkedin'];
   $urlfacebook = $_POST['urlfacebook'];
   $urlinstagram = $_POST['urlinstagram'];
   $visible = $_POST['visible'];

   $urloficial = $_POST['urloficial'];
   $reftipofigura = $_POST['reftipofigura'];
   $marcapropia = $_POST['marcapropia'];

   $email = $_POST['email'];
   $emisoremail = $_POST['emisoremail'];
   $domicilio = $_POST['domicilio'];

   $res = $serviciosReferencias->modificarPerfilasesores($id,$reftabla,$idreferencia,$imagenperfil,$imagenfirma,$urllinkedin,$urlfacebook,$urlinstagram,$visible,$urloficial,$reftipofigura,$marcapropia,$email,$emisoremail,$domicilio);

   if ($res == true) {
      $resEliminar = $serviciosReferencias->eliminarPerfilasesoresespecialidadesPorPerfil($id);
      $resUser = $serviciosReferencias->traerEspecialidades();
		$cad = 'user';
		while ($rowFS = mysql_fetch_array($resUser)) {
			if (isset($_POST[$cad.$rowFS[0]])) {
				$serviciosReferencias->insertarPerfilasesoresespecialidades($id,$rowFS[0]);
			}
		}
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarPerfilasesores($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarPerfilasesores($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function Revision($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->modificarOportunidadesEstadoGeneral($id,3);

   echo '';
}

function traerDirectorio($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerDirectorioasesoresPorId($id);
   $resAsesores = $serviciosReferencias->traerAsesoresPorId($id);


   $titulo = "Asesor: ".mysql_result($resAsesores,0,'apellidopaterno').' '.mysql_result($resAsesores,0,'apellidomaterno').' '.mysql_result($resAsesores,0,'nombre');

   $data['titulo'] = $titulo;

   $cad = '';
   $cad .= '<table class="table table-striped table-bordered">';
   $cad .= '<thead>';
   $cad .= '<th>Area</th>
            <th>Nombre</th>
            <th>Tel.</th>
            <th>Tel. Movil</th>
            <th>Email</th>';
   $cad .= '</thead>';
   $cad .= '<tbody>';

   while ($row = mysql_fetch_array($res))
	{
      $cad .= '<tr>';
      $cad .= '<td>'.$row['area'].'</td>';
      $cad .= '<td>'.$row['razonsocial'].'</td>';
      $cad .= '<td>'.$row['telefono'].'</td>';
      $cad .= '<td>'.$row['telefonocelular'].'</td>';
      $cad .= '<td>'.$row['email'].'</td>';
      $cad .= '</tr>';
   }

   $cad .= '</tbody></table';

   $data['contenido'] = $cad;


   header('Content-type: application/json');
   echo json_encode($data);
}

function eliminarDocumentacionasesoresunica($serviciosReferencias) {
   $idasesor = $_POST['idasesor'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $res = $serviciosReferencias->eliminarDocumentacionasesoresunicas($idasesor, $iddocumentacion);

   header('Content-type: application/json');
   echo json_encode($res);
}


function traerDocumentacionPorAsesoresunicaDocumentacion($serviciosArbitros) {

   $idasesor = $_POST['idasesor'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosArbitros->traerDocumentacionPorAsesoresunicaDocumentacion($idasesor,$iddocumentacion);

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

         $imagen = '../../archivos/asesores/'.$idasesor.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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


function modificarEstadoDocumentacionasesoresunica($serviciosReferencias) {
   session_start();

   $iddocumentacionasesorunica = $_POST['iddocumentacionasesoresunica'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionasesorunica == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionasesoresunica($iddocumentacionasesorunica,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}


function modificarAsesoresunicaUnicaDocumentacion($serviciosReferencias) {
   $idasesor = $_POST['idasesor'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarAsesoresunicaUnicaDocumentacion($idasesor, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);

}

function llenarCombosGral($serviciosReferencias, $serviciosUsuarios,$serviciosFunciones,$serviciosPostal) {
   //$id = $_POST['id'];
   $dato = $_POST['dato'];
   $filtro = json_decode($_POST['filtro']);

   //die(var_dump($filtro));

   $res = $serviciosPostal->devolverComboHTML($dato, $filtro[0]);
   if ($dato == 'codigopostal') {
      if (mysql_num_rows($res)>0) {
         $cadRef = mysql_result($res,0,0);
      } else {
         $cadRef = '';
      }
   } else {
      $cadRef = "<option value=''>-- Seleccionar --</option>";
      $cadRef .= $serviciosFunciones->devolverSelectBox($res,array(0),'');
   }


   echo $cadRef;
}

function insertarDomicilios($serviciosReferencias) {
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $calle = $_POST['calle'];
   $numeroext = $_POST['numeroext'];
   $numeroint = $_POST['numeroint'];
   $colonia = $_POST['colonia'];
   $estado = $_POST['estado'];
   $delegacion = $_POST['delegacion'];
   $codigopostal = $_POST['codigopostal'];

   $res = $serviciosReferencias->insertarDomicilios($reftabla,$idreferencia,$calle,$numeroext,$numeroint,$colonia,$estado,$delegacion,$codigopostal);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarDomicilios($serviciosReferencias) {
   $id = $_POST['id'];
   $reftabla = $_POST['reftabla'];
   $idreferencia = $_POST['idreferencia'];
   $calle = $_POST['calle'];
   $numeroext = $_POST['numeroext'];
   $numeroint = $_POST['numeroint'];
   $colonia = $_POST['colonia'];
   $estado = $_POST['estado'];
   $delegacion = $_POST['delegacion'];
   $codigopostal = $_POST['codigopostal'];

   $res = $serviciosReferencias->modificarDomicilios($id,$reftabla,$idreferencia,$calle,$numeroext,$numeroint,$colonia,$estado,$delegacion,$codigopostal);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarDomicilios($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarDomicilios($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


function insertarDirectorioasesores($serviciosReferencias) {
   $refasesores = $_POST['refasesores'];
   $area = $_POST['area'];
   $razonsocial = $_POST['razonsocial'];
   $telefono = $_POST['telefono'];
   $email = $_POST['email'];
   $telefonocelular = $_POST['telefonocelular'];

   $res = $serviciosReferencias->insertarDirectorioasesores($refasesores,$area,$razonsocial,$telefono,$email,$telefonocelular);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarDirectorioasesores($serviciosReferencias) {
   $id = $_POST['id'];
   $refasesores = $_POST['refasesores'];
   $area = $_POST['area'];
   $razonsocial = $_POST['razonsocial'];
   $telefono = $_POST['telefono'];
   $email = $_POST['email'];
   $telefonocelular = $_POST['telefonocelular'];

   $res = $serviciosReferencias->modificarDirectorioasesores($id,$refasesores,$area,$razonsocial,$telefono,$email,$telefonocelular);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarDirectorioasesores($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarDirectorioasesores($id);

   if ($res == true) {
   echo '';
   } else {
   echo 'Hubo un error al eliminar datos';
   }
}

function asinar($serviciosReferencias) {
   $id = $_POST['idasignar'];
   $asignarusuario = $_POST['asignarusuario'];

   $res = $serviciosReferencias->asignarOportunidades($id,$asignarusuario);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function Reasignar($serviciosReferencias,$serviciosUsuarios,$serviciosFunciones) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerOportunidadesPorId($id);
   $cad = '';

   if (mysql_result($res,0,'refestadooportunidad') == 5 || mysql_result($res,0,'refestadooportunidad') == 6 || mysql_result($res,0,'refestadooportunidad') == 4) {
      //die(var_dump(mysql_result($res,0,'refestadooportunidad')));
      $resAsignacion = $serviciosReferencias->traerReasignacionesPorOportunidad($id);

      if (mysql_num_rows($resAsignacion) > 0) {
         echo '';
      } else {
         $resUsuario = $serviciosUsuarios->traerUsuariosPorRolMenosOportunidad(3,mysql_result($res,0,'refusuarios'),$id);
         $cadVar = $serviciosFunciones->devolverSelectBox2($resUsuario,array(3),'');
         $cad = $serviciosFunciones->addInput('6,6,6,12','select','asignarusuario','asignarusuario','', 'Selecciona el Gerente Comercial','',$cadVar);

         //die(var_dump($cadVar));

         echo $cad;
      }


   } else {
      echo '';
   }
}

function traerEntrevistaoportunidadesPorOportunidad($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerEntrevistaoportunidadesPorOportunidad($id);

   if (mysql_num_rows($res) > 0) {
      $resV['error'] = false;
      $resV['fecha'] = mysql_result($res,0,'fecha');
      $resV['reftipocita'] = mysql_result($res,0,'reftipocita');
   } else {
      $resV['error'] = true;
      $resV['fecha'] = '';
      $resV['reftipocita'] = '';
   }

   header('Content-type: application/json');
   echo json_encode($resV);
}


function modificarCotizacionUnicaDocumentacion($serviciosReferencias) {
   $idcotizacion = $_POST['idcotizacion'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarCotizacionUnicaDocumentacion($idcotizacion, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);

}

function modificarEstadoDocumentacionCotizaciones($serviciosReferencias, $serviciosMensajes) {
   session_start();

   $iddocumentacioncotizacion = $_POST['iddocumentacioncotizacion'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacioncotizacion == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionCotizaciones($iddocumentacioncotizacion,$idestado,$usuariomodi);

      if ($res == true) {
         // se rechaza se notifica al agente
         if (($idestado == 2) || ($idestado == 3) || ($idestado == 4)) {
            $resCotizacion = $serviciosReferencias->traerDocumentacioncotizacionesPorIdCompleto($iddocumentacioncotizacion);

            $idasesor = mysql_result($resCotizacion,0,'refasesores');
            $iddocumentacion = mysql_result($resCotizacion,0,'refdocumentaciones');
            $idcotizacion = mysql_result($resCotizacion,0,'refcotizaciones');

            $resMensaje = $serviciosMensajes->msgCotizacionDocumentacion($idasesor, $iddocumentacion, $idcotizacion, 'R');
         }
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function traerDocumentacionPorCotizacionDocumentacion($serviciosReferencias) {

   $idcotizacion = $_POST['idcotizacion'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacion($idcotizacion,$iddocumentacion);

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
         $imagen = '../../archivos/cotizaciones/'.$idcotizacion.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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



function eliminarDocumentacionCotizacion($serviciosReferencias) {
   $idcotizacion = $_POST['idcotizacion'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $res = $serviciosReferencias->eliminarDocumentacionCotizacion($idcotizacion, $iddocumentacion);

   header('Content-type: application/json');
   echo json_encode($res);
}

function insertarAsociadostemporales($serviciosReferencias,$serviciosUsuarios) {

   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $ine = $_POST['ine'];
   $email = $_POST['email'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $refbancos = $_POST['refbancos'];
   $claveinterbancaria = $_POST['claveinterbancaria'];
   $domicilio = $_POST['domicilio'];
   $nombredespacho = $_POST['nombredespacho'];
   $refestadoasociado = $_POST['refestadoasociado'];
   $refoportunidades = $_POST['refoportunidades'];

   $password = $apellidopaterno.$apellidomaterno.date('His');

   $refusuarios = $serviciosUsuarios->insertarUsuario($nombre,$password,12,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

   $res = $serviciosReferencias->insertarAsociadostemporales($refusuarios,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$nombredespacho,$refestadoasociado,$refoportunidades,0);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarAsociadostemporales($serviciosReferencias) {
   $id = $_POST['id'];
   $refusuarios = $_POST['refusuarios'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $ine = $_POST['ine'];
   $email = $_POST['email'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $refbancos = $_POST['refbancos'];
   $claveinterbancaria = $_POST['claveinterbancaria'];
   $domicilio = $_POST['domicilio'];
   $nombredespacho = $_POST['nombredespacho'];
   $refestadoasociado = $_POST['refestadoasociado'];
   $refoportunidades = $_POST['refoportunidades'];

   $res = $serviciosReferencias->modificarAsociadostemporales($id,$refusuarios,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$nombredespacho,$refestadoasociado,$refoportunidades);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarAsociadostemporales($serviciosReferencias) {
   $id = $_POST['id'];

   $resAT = $serviciosReferencias->traerAsociadostemporalesPorId($id);

   $refusuarios = mysql_result($resAT, 0,'refusuarios');

   $res = $serviciosReferencias->eliminarAsociadostemporales($id);

   if ($res == true) {
      $resEliminar = $serviciosReferencias->eliminarUsuariosDefinitivamente($refusuarios);
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }

}

function rechazarCotizacion($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $observaciones = $_POST['observaciones'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($observaciones == '') {
      echo 'Debe cargar una observacion para poder Rechazar la cotizacion';
   } else {
      $res = $serviciosReferencias->modificarCotizacionesRechazar($id,$observaciones,$usuariomodi);
      echo '';
   }

}

function rechazarCotizacionValidacion($serviciosReferencias, $serviciosMensajes) {
   session_start();

   $id = $_POST['id'];
   $idagente = $_POST['idagente'];
   $bitacoracrea = $_POST['bitacoracrea'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   $sql = "update dbcotizaciones set bitacoracrea = '".$bitacoracrea."' where idcotizacion =".$id;
   $res = $serviciosReferencias->query($sql,0);

   $res = $serviciosMensajes->msgCotizacionechazaValidacion($id,$idagente,$bitacoracrea);
   echo '';

}


function insertarCotizaciones($serviciosReferencias) {
   session_start();

   $refclientes = $_POST['refclientes'];
   $refproductos = $_POST['refproductos'];
   $refasesores = $_POST['refasesores'];
   $refasociados = ($_POST['refasociados'] == '' ? 'NULL' : $_POST['refasociados']);
   $refestadocotizaciones = $_POST['refestadocotizaciones'];
   $observaciones = $_POST['observaciones'];

   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];
   $refusuarios = $_SESSION['usuaid_sahilices'];

   $tiponegocio = $_POST['tiponegocio'];

   if ($tiponegocio != 'Negocio nuevo') {
      $fechavencimiento = $_POST['fechavencimiento'];
      $coberturaactual = $_POST['coberturaactual'];
   } else {
      $fechavencimiento = '';
      $coberturaactual = '';
   }


   $cobertura = $_POST['cobertura'];
   $reasegurodirecto = $_POST['reasegurodirecto'];
   $fecharenovacion = $_POST['fecharenovacion'];
   $fechapropuesta = $fechacrea;

   $presentacotizacion = $_POST['presentacotizacion'];
   $fechaemitido = $fechacrea;

   $existeprimaobjetivo = $_POST['existeprimaobjetivo'];
   $primaobjetivo = ($_POST['primaobjetivo'] == '' ? 0 : $_POST['primaobjetivo']);

   $res = $serviciosReferencias->insertarCotizaciones($refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$existeprimaobjetivo,$primaobjetivo);

   if ((integer)$res > 0) {

      $resModificarEST = $serviciosReferencias->modificarCotizacionesPorCampo($res,'refestados',1,$usuariomodi);

      /**** toda la perta del cuestionario ***/
      $resP = $serviciosReferencias->traerProductosPorId($refproductos);
      $idcuestionario = mysql_result($resP,0,'refcuestionarios');

      //echo die(var_dump($idcuestionario));

      if ($idcuestionario != null) {
         $resC = $serviciosReferencias->traerCuestionariosPorIdCompleto($idcuestionario);


      }



      /**** fin cuestionario     ****/

      echo $res;
   } else {
      echo 'Hubo un error al insertar datos ';
   }
}


function modificarCotizaciones($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refclientes = $_POST['refclientes'];
   $refproductos = $_POST['refproductos'];
   $refasesores = $_POST['refasesores'];
   $refasociados = ($_POST['refasociados'] == '' ? 'NULL' : $_POST['refasociados']);
   $estadoactual = $_POST['estadoactual'];
   if ($estadoactual != '') {
      $refestadocotizaciones = $estadoactual;
   } else {
      $refestadocotizaciones = $_POST['refestadocotizaciones'];
   }

   $observaciones = $_POST['observaciones'];
   $fechaemitido = ($_POST['fechaemitido'] == '' ? 'NULL' : $_POST['fechaemitido']);

   $fechamodi = date('Y-m-d H:i:s');

   $usuariomodi = $_SESSION['usua_sahilices'];
   $refusuarios = $_SESSION['usuaid_sahilices'];
   if (isset($_POST['foliotys'])) {
      $foliotys = $_POST['foliotys'];
   } else {
      $foliotys = 'completar';
   }


   $tiponegocio = $_POST['tiponegocio'];

   if ($tiponegocio != 'Negocio nuevo') {
      $fechavencimiento = $_POST['fechavencimiento'];
      $coberturaactual = $_POST['coberturaactual'];
   } else {
      $fechavencimiento = '';
      $coberturaactual = '';
   }

   $cobertura = $_POST['cobertura'];
   $reasegurodirecto = $_POST['reasegurodirecto'];
   $fecharenovacion = $_POST['fecharenovacion'];
   $fechapropuesta = $_POST['fechapropuesta'];

   $presentacotizacion = $_POST['presentacotizacion'];

   $bitacoracrea = $_POST['bitacoracrea'];
   $bitacorainbursa = $_POST['bitacorainbursa'];
   $bitacoraagente = $_POST['bitacoraagente'];

   $existeprimaobjetivo = $_POST['existeprimaobjetivo'];
   $primaobjetivo = ($_POST['primaobjetivo'] == '' ? 0 : $_POST['primaobjetivo']);


   if ($refestadocotizaciones == 12) {

      // modifico la cotizacion a la ultima etapa
      $resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',4,$usuariomodi);

      $foliointerno = $serviciosReferencias->generaFolioInterno();
      $resIV = $serviciosReferencias->insertarVentas($id,1,0,0,'','',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$usuariomodi,$usuariomodi,$foliotys,$foliointerno,0,'',date('Y-m-d'));


      // generada la venta lo guardo en la cartera del cliente
      $resIC = $serviciosReferencias->insertarClientescartera($refclientes,$refproductos,$fechaemitido,'','1');

      //generada la venta solicito el idcliente inbursa
      if (isset($_POST['idclienteinbursa'])) {
         $idclienteinbursa = $_POST['idclienteinbursa'];
         $resModC = $serviciosReferencias->modificarClientesInbursa($refclientes, $idclienteinbursa);
      } else {
         $idclienteinbursa = 0;
      }

      // busco si existe un lead para updetear
      $resLead = $serviciosReferencias->traerLeadPorCotizacion($id);
      if (mysql_num_rows($resLead) > 0) {
         //$resModLead = $serviciosReferencias->modificarLeadCotizacion(mysql_result($resLead,0,0),$id,5);
      }
   } else {
      $foliointerno = '';
   }

   if ($refestadocotizaciones == 4) {
      // modifico la cotizacion a la ultima etapa
      $resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestados',2,$usuariomodi);
   }
   /*
   if ($refestadocotizaciones == 4) {
      // busco si existe un lead para updetear
      $resLead = $serviciosReferencias->traerLeadPorCotizacion($id);
      if (mysql_num_rows($resLead) > 0) {
         $resModLead = $serviciosReferencias->modificarLeadCotizacion(mysql_result($resLead,0,0),$id,3);
      }
   }
   */


   $res = $serviciosReferencias->modificarCotizaciones($id,$refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechamodi,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$bitacoracrea,$bitacorainbursa,$bitacoraagente,$existeprimaobjetivo,$primaobjetivo);

   if ($res == true) {
      if (isset($_POST['refbeneficiarioaux'])) {
         $resModificarCB = $serviciosReferencias->modificarCotizacionesBeneficiario($id,$_POST['refbeneficiarioaux']);
      }

      if (isset($_POST['primaneta'])) {
         $resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($id,'primaneta',$_POST['primaneta'],$usuariomodi);
      }
      if (isset($_POST['primatotal'])) {
         $resModificarPT = $serviciosReferencias->modificarCotizacionesPorCampo($id,'primatotal',$_POST['primatotal'],$usuariomodi);
      }

      echo '';
   } else {
      echo 'Hubo un error al modificar datos ';
   }
}

function eliminarCotizaciones($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarCotizaciones($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function insertarAlertas($serviciosReferencias) {
   $reftiposeguimientos = 1;
   $motivo = $_POST['motivo'];
   $id = $_POST['refasesores'];
   $fechacreacion = $_POST['fechacreacion'];
   $refusuarios = $_POST['refusuarios'];

   $res = $serviciosReferencias->insertarAlertas($reftiposeguimientos,$motivo,$id,$fechacreacion,$refusuarios);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarAlertas($serviciosReferencias) {
   $id = $_POST['id'];
   $reftiposeguimientos = $_POST['reftiposeguimientos'];
   $motivo = $_POST['motivo'];
   $id = $_POST['id'];
   $fechacreacion = $_POST['fechacreacion'];
   $refusuarios = $_POST['refusuarios'];

   $res = $serviciosReferencias->modificarAlertas($id,$reftiposeguimientos,$motivo,$id,$fechacreacion,$refusuarios);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarAlertas($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarAlertas($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

/****   	notificaciones * *************/
function marcarNotificacion($serviciosNotificaciones) {
	$id = $_POST['id'];

	$res = $serviciosNotificaciones->marcarNotificacion($id);

	if ($res == true) {
      $resNotificacion = $serviciosNotificaciones->traerNotificacionesPorId($id);
      $resV['mensaje'] = mysql_result($resNotificacion,0,'url');
      $resV['error'] = false;
	} else {
      $resV['mensaje'] = 'Hubo un error al insertar datos';
      $resV['error'] = true;
	}

   header('Content-type: application/json');
   echo json_encode($resV);

}

/* nuevo 31/01/2020 */

function modificarAsociadoUnicaDocumentacion($serviciosReferencias) {
   $idasociado = $_POST['idasociado'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarAsociadoUnicaDocumentacion($idasociado, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);

}

function modificarEstadoDocumentacionAsociados($serviciosReferencias) {
   session_start();

   $iddocumentacionasociado = $_POST['iddocumentacionasociado'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionasociado == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionAsociados($iddocumentacionasociado,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function traerDocumentacionPorAsociadoDocumentacion($serviciosReferencias) {

   $idasociado = $_POST['idasociado'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $resV['datos'] = '';
   $resV['error'] = false;

   $resFoto = $serviciosReferencias->traerDocumentacionPorAsociadoDocumentacion($idasociado,$iddocumentacion);

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
         $imagen = '../../archivos/asociados/'.$idasociado.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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



function eliminarDocumentacionAsociado($serviciosReferencias) {
   $idasociado = $_POST['idasociado'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $res = $serviciosReferencias->eliminarDocumentacionAsociado($idasociado, $iddocumentacion);

   header('Content-type: application/json');
   echo json_encode($res);
}

function eliminarDocumentacionFamiliar($serviciosReferencias) {
   $idasociado = $_POST['idasociado'];
   $iddocumentacion = $_POST['iddocumentacion'];

   $res = $serviciosReferencias->eliminarDocumentacionFamiliar($idasociado, $iddocumentacion);

   header('Content-type: application/json');
   echo json_encode($res);
}

function insertarAsociados($serviciosReferencias,$serviciosUsuarios) {

   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $ine = $_POST['ine'];
   $email = $_POST['email'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $refbancos = $_POST['refbancos'];
   $claveinterbancaria = $_POST['claveinterbancaria'];
   $domicilio = $_POST['domicilio'];

   $reftipoasociado = $_POST['reftipoasociado'];

   $nombredespacho = $_POST['nombredespacho'];
   $refestadoasociado = $_POST['refestadoasociado'];
   $refoportunidades = $_POST['refoportunidades'];
   $refpostulantes = $_POST['refpostulantes'];

   if ($email == '') {
      $email = $apellidopaterno.$apellidomaterno.date('His').'@modificar.com';
   }

   $password = $apellidopaterno.$apellidomaterno.date('His');

   $refusuarios = $serviciosUsuarios->insertarUsuario($nombre,$password,10,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

   $res = $serviciosReferencias->insertarAsociados($refusuarios,$reftipoasociado,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$refestadoasociado,$refoportunidades,$refpostulantes);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}

function modificarAsociados($serviciosReferencias) {
   $id = $_POST['id'];
   $refusuarios = $_POST['refusuarios'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $ine = $_POST['ine'];
   $email = $_POST['email'];
   $fechanacimiento = $_POST['fechanacimiento'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $refbancos = $_POST['refbancos'];
   $claveinterbancaria = $_POST['claveinterbancaria'];
   $domicilio = $_POST['domicilio'];
   $nombredespacho = $_POST['nombredespacho'];
   $refestadoasociado = $_POST['refestadoasociado'];
   $refoportunidades = $_POST['refoportunidades'];
   $refpostulantes = $_POST['refpostulantes'];

   $reftipoasociado = $_POST['reftipoasociado'];

   $res = $serviciosReferencias->modificarAsociados($id,$refusuarios,$reftipoasociado,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$refestadoasociado,$refoportunidades,$refpostulantes);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarAsociados($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarAsociados($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

/* nuevo 16/01/2020 */

function insertarReclutadorasores($serviciosReferencias) {
   $refusuarios = $_POST['refusuarios'];
   $refpostulantes = $_POST['refpostulantes'];
   $refoportunidades = $_POST['refoportunidades'];
   $refasesores = $_POST['refasesores'];
   $refasociados = $_POST['refasociados'];

   $res = $serviciosReferencias->insertarReclutadorasores($refusuarios,$refpostulantes,$refoportunidades,$refasesores,$refasociados);

   if ((integer)$res > 0) {
      echo '';
   } else {
      echo 'Hubo un error al insertar datos - verifique las relaciones seleccionadas';
   }
}

function modificarReclutadorasores($serviciosReferencias) {
   $id = $_POST['id'];
   $refusuarios = $_POST['refusuarios'];
   $refpostulantes = $_POST['refpostulantes'];
   $refoportunidades = $_POST['refoportunidades'];
   $refasesores = $_POST['refasesores'];
   $refasociados = $_POST['refasociados'];

   $res = $serviciosReferencias->modificarReclutadorasores($id,$refusuarios,$refpostulantes,$refoportunidades,$refasesores,$refasociados);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarReclutadorasores($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarReclutadorasores($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function traerOportunidadesPorId($serviciosReferencias) {
   $id = $_POST['id'];

   if ($id != '') {
      $res = $serviciosReferencias->traerOportunidadesPorIdCompleto($id);

      if (mysql_num_rows($res) > 0) {
         $resV['error'] = false;
         $resV['persona'] = mysql_result($res,0,'nombrecompleto');
         $resV['apellidopaterno'] = mysql_result($res,0,'apellidopaterno');
         $resV['apellidomaterno'] = mysql_result($res,0,'apellidomaterno');
         $resV['nombre'] = mysql_result($res,0,'nombre');
         $resV['telefonomovil'] = mysql_result($res,0,'telefonomovil');
         $resV['telefonotrabajo'] = mysql_result($res,0,'telefonotrabajo');
         $resV['email'] = mysql_result($res,0,'email');
         $resV['nombredespacho'] = mysql_result($res,0,'nombredespacho');

      } else {
         $resV['error'] = true;
         $resV['persona'] = '';
         $resV['apellidopaterno'] = '';
         $resV['apellidomaterno'] = '';
         $resV['nombre'] = '';
         $resV['telefonomovil'] = '';
         $resV['telefonotrabajo'] = '';
         $resV['email'] = '';
         $resV['nombredespacho'] = '';
      }
   } else {
      $resV['error'] = true;
      $resV['persona'] = '';
      $resV['apellidopaterno'] = '';
      $resV['apellidomaterno'] = '';
      $resV['nombre'] = '';
      $resV['telefonomovil'] = '';
      $resV['telefonotrabajo'] = '';
      $resV['email'] = '';
      $resV['nombredespacho'] = '';
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function traerEntrevistaoportunidadesPorId($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerEntrevistaoportunidadesPorIdCompleto($id);

   if (mysql_num_rows($res) > 0) {
      $resV['error'] = false;
      $resV['domicilio'] = mysql_result($res,0,'domicilio');
      $resV['refpostal'] = mysql_result($res,0,'codigopostal');
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


function insertarEntrevistaoportunidades($serviciosReferencias) {
   session_start();

   $refoportunidades = $_POST['refoportunidades'];
   $entrevistador = $_POST['entrevistador'];
   $fecha = $_POST['fecha'];
   $domicilio = 'sin domicilio';
   $codigopostal = 547;
   $refestadoentrevistas = $_POST['refestadoentrevistas'];
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   $existe = $serviciosReferencias->existeEntrevistaOportunidad($refoportunidades);

   if ($fecha == '' || $fecha == '0000-00-00 00:00:00') {
      echo 'Es obligatorio el campo Fecha de la entrevista';
   } else {
      if ($existe == 0) {
         $res = $serviciosReferencias->insertarEntrevistaoportunidades($refoportunidades,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadoentrevistas,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);

         if ((integer)$res > 0) {
            $resOpo = $serviciosReferencias->modificarOportunidadesEstado($refoportunidades,2);
            echo '';
         } else {
            echo 'Hubo un error al insertar datos';
         }
      } else {
         echo 'Ya existe una entrevista';
      }
   }


}

function modificarEntrevistaoportunidades($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $refoportunidades = $_POST['refoportunidades'];
   $entrevistador = $_POST['entrevistador'];
   $fecha = $_POST['fecha'];
   $domicilio = 'sin domicilio';
   $codigopostal = 547;
   $refestadoentrevistas = $_POST['refestadoentrevistas'];
   $fechamodi = date('Y-m-d H:i:s');
   $usuariomodi = $_SESSION['usua_sahilices'];

   $res = $serviciosReferencias->modificarEntrevistaoportunidades($id,$refoportunidades,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadoentrevistas,$fechamodi,$usuariomodi);

   if ($res == true) {
      switch ($refestadoentrevistas) {
         case 1:
            $resOpo = $serviciosReferencias->modificarOportunidadesEstado($refoportunidades,2);
         break;
         case 2:
            $resOpo = $serviciosReferencias->modificarOportunidadesEstado($refoportunidades,3);
         break;
         case 3:
            $resOpo = $serviciosReferencias->modificarOportunidadesEstado($refoportunidades,2);
         break;
         case 4:
            $resOpo = $serviciosReferencias->modificarOportunidadesEstado($refoportunidades,4);
         break;
         case 5:
            $resOpo = $serviciosReferencias->modificarOportunidadesEstado($refoportunidades,4);
         break;
      }
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarEntrevistaoportunidades($serviciosReferencias) {
   $id = $_POST['id'];
   session_start();

   $res = $serviciosReferencias->traerEntrevistaoportunidadesPorId($id);
   $idoportunidad = mysql_result($res,0,'refoportunidades');

   if ($_SESSION['idroll_sahilices'] == 3) {

      $res = $serviciosReferencias->cancelarEntrevistaoportunidades($id);
   } else {
      $res = $serviciosReferencias->eliminarEntrevistaoportunidades($id);
   }
   if ($res == true) {
      $resOpo = $serviciosReferencias->modificarOportunidadesEstado($idoportunidad,4);
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function insertarOportunidades($serviciosReferencias) {

   $nombredespacho = $_POST['nombredespacho'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $email = $_POST['email'];
   $refusuarios = $_POST['refusuarios'];
   $refreferentes = ($_POST['refreferentes'] == '' ? 'null' : $_POST['refreferentes']);
   $refestadooportunidad = $_POST['refestadooportunidad'];
   $refmotivorechazos = ($_POST['refmotivorechazos'] == '' ? 'null' : $_POST['refmotivorechazos']);
   $observaciones = $_POST['observaciones'];
   $refestadogeneraloportunidad = 1;

   $reforigenreclutamiento = $_POST['reforigenreclutamiento'];

   if (($telefonotrabajo == '') && ($telefonomovil == '')) {
      echo 'Hubo un error al insertar datos - Debe cargar por lo menos un telefono';
   } else {
      $existe = $serviciosReferencias->existeOportunidad($apellidopaterno,$apellidomaterno,$nombre);
      if ($existe == 0) {
         $res = $serviciosReferencias->insertarOportunidades($nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$telefonomovil,$telefonotrabajo,$email,$refusuarios,$refreferentes,$refestadooportunidad,$refmotivorechazos,$observaciones,$refestadogeneraloportunidad,$reforigenreclutamiento);

         if ((integer)$res > 0) {
            echo '';
         } else {
            echo 'Hubo un error al insertar datos';
         }
      } else {
         echo 'Hubo un error al insertar datos - Ya existe esta persona';
      }

   }

}

function modificarOportunidades($serviciosReferencias, $serviciosNotificaciones,$serviciosUsuarios) {
   session_start();

   $id = $_POST['id'];

   // voy a buscar el estado anterior de la oportunidad, si era pendiente de revision y lo pasan a por atender genero asignacion nueva
   $resO = $serviciosReferencias->traerOportunidadesPorId($id);
   $refEstadoAux = mysql_result($resO,0,'refestadooportunidad');

   $nombredespacho = $_POST['nombredespacho'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonotrabajo = $_POST['telefonotrabajo'];
   $email = $_POST['email'];
   $refusuarios = $_POST['refusuarios'];
   $refreferentes = ($_POST['refreferentes'] == '' ? 'null' : $_POST['refreferentes']);
   $refestadooportunidad = $_POST['refestadooportunidad'];
   $refmotivorechazos = ($_POST['refmotivorechazos'] == '' ? 'null' : $_POST['refmotivorechazos']);
   $observaciones = $_POST['observaciones'];
   $refestadogeneraloportunidad = $_POST['refestadogeneraloportunidad'];

   $reforigenreclutamiento = $_POST['reforigenreclutamiento'];

   $error = '';
   if ($refestadooportunidad == 2) {
      $resEntrevistas = $serviciosReferencias->traerEntrevistaoportunidadesPorOportunidad($id);
      if ($_POST['fecha'] == '') {
         $error = 'Debe cargar la fecha de la cita - ';
      }
      if ($_POST['entrevistador'] == '') {
         $error .= 'Debe cargar el entrevistador de la cita - ';
      }
   }

   if ($error != '') {
      echo 'Hubo un error al insertar datos - '.$error;
   } else {
      if (($telefonotrabajo == '') && ($telefonomovil == '')) {
         echo 'Hubo un error al insertar datos - Debe cargar por lo menos un telefono';
      } else {
         if ($refestadooportunidad == 8) {
            $refestadogeneraloportunidad = 2; // lo dejo en rechazo definitivo
         }
         if (($refestadogeneraloportunidad == 3) && ($refestadooportunidad == 1)) {
            $refestadooportunidad = $refEstadoAux; // le dejo el estado con el que finalizo
            $refestadogeneraloportunidad = 2; // lo dejo en rechazo definitivo
            $resAsignacion = $serviciosReferencias->asignarOportunidades($id,$refusuarios);
         }

         $res = $serviciosReferencias->modificarOportunidades($id,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$telefonomovil,$telefonotrabajo,$email,$refusuarios,$refreferentes,$refestadooportunidad,$refmotivorechazos,$observaciones,$refestadogeneraloportunidad,$reforigenreclutamiento);

         if ($res == true) {
            if ($refestadooportunidad == 3) {
               /**** creo la notificacion ******/
      			$emailReferente = 'rlinares@asesorescrea.com'; //por ahora fijo
      			$mensaje = 'Se acepto una oportunidad: '.$apellidopaterno.' '.$apellidomaterno.' '.$nombre;
      			$idpagina = 1;
      			$autor = $_SESSION['usua_sahilices'];
      			$destinatario = $emailReferente;
      			$id1 = $id;
      			$id2 = 0;
      			$id3 = 0;
      			$icono = 'person_add';
      			$estilo = 'bg-light-green';
      			$fecha = date('Y-m-d H:i:s');
      			$url = "oportunidades/index.php";

      			$res = $serviciosNotificaciones->insertarNotificaciones($mensaje,$idpagina,$autor,$destinatario,$id1,$id2,$id3,$icono,$estilo,$fecha,$url);
      			/*** fin de la notificacion ****/
            }
            if ($refestadooportunidad == 2) {
               if (mysql_num_rows($resEntrevistas) > 0) {
                  //modifico la entrevista

                  $idEntrevista = mysql_result($resEntrevistas,0,0);
                  $refoportunidades = $_POST['refoportunidades'];
                  $entrevistador = $_POST['entrevistador'];
                  $fecha = $_POST['fecha'];
                  $domicilio = 'sin domicilio';
                  $codigopostal = 547;
                  $refestadoentrevistas = 1;
                  $fechamodi = date('Y-m-d H:i:s');
                  $usuariomodi = $_SESSION['usua_sahilices'];
                  $reftipocita = $_POST['reftipocita'];

                  $res = $serviciosReferencias->modificarEntrevistaoportunidades($idEntrevista,$refoportunidades,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadoentrevistas,$fechamodi,$usuariomodi,$reftipocita);

               } else {
                  //inserto la entrevista
                  $refoportunidades = $_POST['refoportunidades'];
                  $entrevistador = $_POST['entrevistador'];
                  $fecha = $_POST['fecha'];
                  $domicilio = 'sin domicilio';
                  $codigopostal = 547;
                  $refestadoentrevistas = 1;
                  $fechacrea = date('Y-m-d H:i:s');
                  $fechamodi = date('Y-m-d H:i:s');
                  $usuariocrea = $_SESSION['usua_sahilices'];
                  $usuariomodi = $_SESSION['usua_sahilices'];
                  $reftipocita = $_POST['reftipocita'];

                  $res = $serviciosReferencias->insertarEntrevistaoportunidades($refoportunidades,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadoentrevistas,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$reftipocita);

               }
            }

            // si es asociado temporal o agente asociado id=8 lo genero automatico
            if ($refestadooportunidad == 7) {

               $cuerpo = '';
      	      $cuerpo .= '<h4>Nombre Completo: '.$nombre.' '.$apellidopaterno.' '.$apellidomaterno.'</h4><br>';

               if ($email != '') {
                  $password = $apellidopaterno.$apellidomaterno.date('His');

                  $refusuarios = $serviciosUsuarios->insertarUsuario($nombre,$password,12,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

                  $resAT = $serviciosReferencias->insertarAsociados($refusuarios,2,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,'',$email,'null',$telefonomovil,$telefonotrabajo,1,'','',1,$id,0);

                  $asunto = 'Se genero un Agente Temporal';

                  $cuerpo .= "Acceda por este link: <a href='http://asesorescrea.com/desarrollo/crm/dashboard/asociados/index.php?id=".$resAT."'>ACCEDER</a>";
               } else {
                  $asunto = 'No se pudo generar un Agente Temporal por falta de email';
               }

               $destinatario = 'rlinares@asesorescrea.com';

      	      $res = $serviciosReferencias->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');

            }
            echo '';
         } else {
            echo 'Hubo un error al modificar datos';
         }
      }
   }

}

function eliminarOportunidades($serviciosReferencias) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->eliminarOportunidades($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}

function insertarReferentes($serviciosReferencias) {
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $telefono = $_POST['telefono'];
   $email = $_POST['email'];
   $observaciones = $_POST['observaciones'];
   $refusuarios = $_POST['refusuarios'];

   if (isset($_POST['generar_usuario'])) {
      $password = $apellidopaterno.$apellidomaterno.date('His');

      if ($email == '') {
         $email = $apellidopaterno.'.'.$apellidomaterno.date('His').'@crearemail.com';
      }

      $resUsuario = $serviciosReferencias->insertarUsuarios($nombre,$password,9,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1,$_POST['refsocios']);

      $refusuarios = $resUsuario;
   }

   if ($apellidopaterno == '' || $apellidomaterno == '' || $nombre == '') {
      echo 'Los campos Apellido Paterno y Materno, y el Nombre son obligatorios';
      $resElimiar = $serviciosReferencias->eliminarUsuariosDefinitivamente($resUsuario);
   } else {
      $res = $serviciosReferencias->insertarReferentes($apellidopaterno,$apellidomaterno,$nombre,$telefono,$email,$observaciones,$refusuarios);

      if ((integer)$res > 0) {
         echo '';
      } else {
         echo 'Hubo un error al insertar datos';
         $resElimiar = $serviciosReferencias->eliminarUsuariosDefinitivamente($resUsuario);
      }
   }

}

function modificarReferentes($serviciosReferencias) {
   $id = $_POST['id'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $nombre = $_POST['nombre'];
   $telefono = $_POST['telefono'];
   $email = $_POST['email'];
   $observaciones = $_POST['observaciones'];
   $refusuarios = $_POST['refusuarios'];

   $res = $serviciosReferencias->modificarReferentes($id,$apellidopaterno,$apellidomaterno,$nombre,$telefono,$email,$observaciones,$refusuarios);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
}

function eliminarReferentes($serviciosReferencias) {
   $id = $_POST['id'];
   $res = $serviciosReferencias->eliminarReferentes($id);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al eliminar datos';
   }
}


/* fin nuevo 16/01/2020 */

function enviarAlerta($serviciosReferencias,$serviciosUsuarios) {
   $id = $_POST['id'];

   $res = $serviciosReferencias->traerPostulantesPorId($id);

   if (mysql_num_rows($res) > 0) {
      $email = mysql_result($res,0,'email');
      $refusuarios = mysql_result($res,0,'refusuarios');
      $resActivacion = $serviciosUsuarios->confirmarEmail($email, '','', '', $refusuarios);

      $resV['leyenda'] = $email;
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   }



   header('Content-type: application/json');
   echo json_encode($resV);
}

function migrarPostulante($serviciosReferencias, $serviciosMensajes) {
   session_start();
   $id = $_POST['id'];
   $usuario = $_SESSION['usua_sahilices'];

   $res = $serviciosReferencias->migrarPostulante($id,$usuario);

   if ((integer)$res > 0) {
      $resMensaje = $serviciosMensajes->msgAsesorNuevo($res);

      $res = $serviciosReferencias->modificarEstadoPostulante($id,10);



      echo '';
   } else {
      echo 'Hubo un error al insertar datos: '.$res;
   }
}

function presentarDocumentacionI($serviciosReferencias, $serviciosUsuarios) {
   session_start();

   $id = $_POST['id'];

   $res = $serviciosReferencias->presentarDocumentacionI($id);

   if ($res == true) {
      $destinatario = 'rlinares@asesorescrea.com';
      $asunto = 'Se presento la documentacion completa de un postulante';

      $resPostulante = $serviciosReferencias->traerPostulantesPorId($id);

      $cuerpo = '';
      $cuerpo .= '<h4>Nombre Completo: '.mysql_result($resPostulante,0,'nombre').' '.mysql_result($resPostulante,0,'apellidopaterno').' '.mysql_result($resPostulante,0,'apellidomaterno').'</h4><br>';
      $cuerpo .= "Acceda por este link: <a href='asesorescrea.com/desarrollo/crm/potulantes/documentacioni.php?id=".$id."'>ACCEDER</a>";

      $res = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
      echo '';
   } else {
      echo 'Hubo un error al presentar la documentación';
   }
}

function modificarEstadoDocumentacionPostulante($serviciosReferencias) {
   session_start();

   $iddocumentacionasesor = $_POST['iddocumentacionasesores'];
   $idestado = $_POST['idestado'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   if ($iddocumentacionasesor == 0) {
      $resV['leyenda'] = 'Todavia no cargo el archivo, no podra modificar el estado de la documentación';
      $resV['error'] = true;
   } else {
      $res = $serviciosReferencias->modificarEstadoDocumentacionPostulante($iddocumentacionasesor,$idestado,$usuariomodi);

      if ($res == true) {
         $resV['leyenda'] = '';
         $resV['error'] = false;
      } else {
         $resV['leyenda'] = 'Hubo un error al modificar datos';
         $resV['error'] = true;
      }
   }


   header('Content-type: application/json');
   echo json_encode($resV);
}

function modificarPostulanteUnicaDocumentacion($serviciosReferencias) {
   $idpostulante = $_POST['idpostulante'];
   $campo = $_POST['campo'];
   $valor = $_POST['valor'];

   $res = $serviciosReferencias->modificarPostulanteUnicaDocumentacion($idpostulante, $campo, $valor);

   if ($res == true) {
      $resV['leyenda'] = '';
      $resV['error'] = false;
   } else {
      $resV['leyenda'] = 'Hubo un error al modificar datos';
      $resV['error'] = true;
   }

   header('Content-type: application/json');
   echo json_encode($resV);

}

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

         // cargo las repuestas de los gastos ///////////////////
         $gasto1 = $_POST['gasto1'];
         $gasto2 = $_POST['gasto2'];
         $gasto3 = $_POST['gasto3'];
         $gasto4 = $_POST['gasto4'];
         $gasto5 = $_POST['gasto5'];
         $gasto6 = $_POST['gasto6'];
         $gasto7 = $_POST['gasto7'];

         $resGasto1 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto1,1);
         $resGasto2 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto2,2);
         $resGasto3 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto3,3);
         $resGasto4 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto4,4);
         $resGasto5 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto5,5);
         $resGasto6 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto6,6);
         $resGasto7 = $serviciosReferencias->insertarRespuestadetalles($res,$gasto7,7);
         // fin de respuestas de gastos /////////////////

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

   session_start();
   if (isset($_POST['estadodocumentacion'])) {
      $estadoDocumentacion = $_POST['estadodocumentacion'];
      $iddocumentacion     = $_POST['iddocumentacion'];
      $usuariomodi         = $_SESSION['usua_sahilices'];

      if (($estadoDocumentacion == 2) || ($estadoDocumentacion == 3) || ($estadoDocumentacion == 4)) {
         $idestado = 9; // finalizo el proceso de reclutamiento
      }

      //modifico el estado de la documentacion
      $resUpdate = $serviciosReferencias->modificarEstadoDocumentacionPostulantePorDocumentacion($iddocumentacion,$id, $estadoDocumentacion,$usuariomodi);
   }

   $resUltimo = $serviciosReferencias->modificarUltimoEstadoPostulante($id,$idestado);

   $res = $serviciosReferencias->modificarEstadoPostulante($id,$idestado);

   if ($idestado == 6) {
      $idestado = 9;
   }



   $ruta = '';

   if ($res == true) {
      // envio email dependeiendo el estado
      $resultado = $serviciosReferencias->traerPostulantesPorId($id);
		$refesquemareclutamiento  = mysql_result($resultado,0,'refesquemareclutamiento');

      //$resEstado = $serviciosReferencias->traerEstadopostulantesEtapas($idestado);
      $resEstado = $serviciosReferencias->traerGuiasPorEsquemaSiguiente($refesquemareclutamiento, $idestado);

      if (mysql_num_rows($resEstado) > 0) {
         $url = $ruta.mysql_result($resEstado,0,'url').'?id='.$id;

         switch ($idestado) {

            case 2:
               $resE = $serviciosMensajes->msgExamenVeritas($id);
            break;
            case 4:
               $resE = $serviciosMensajes->msgEntrevistaRegional($id);
            break;
            case 5:
               $resE = $serviciosMensajes->msgURL($id);
            break;
            case 6:
               $resE = $serviciosMensajes->msgFirmarContratos($id);
            break;
            case 8:
               $resE = $serviciosMensajes->msgAsesor($id);
            break;
         }
      } else {

         $url = 'index.php';
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

            $imagen = '../../archivos/postulantes/'.$idpostulante.'/'.mysql_result($resFoto,0,'carpeta').'/'.mysql_result($resFoto,0,'archivo');

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


   function traerDocumentacionPorPostulanteDocumentacionEspecifica($serviciosArbitros) {

      $idpostulante = $_POST['idpostulante'];
      $iddocumentacion = $_POST['iddocumentacion'];
      $archivo = $_POST['archivo'];

      $resV['datos'] = '';
      $resV['error'] = false;

      $resFoto = $serviciosArbitros->traerDocumentacionPorPostulanteDocumentacionEspecifica($idpostulante,$iddocumentacion,$archivo);

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
               case 3:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/inef/'.mysql_result($resFoto,0,'archivo');
               break;
               case 4:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/ined/'.mysql_result($resFoto,0,'archivo');
               break;
               case 5:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/actanacimiento/'.mysql_result($resFoto,0,'archivo');
               break;
               case 6:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/curp/'.mysql_result($resFoto,0,'archivo');
               break;
               case 7:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/rfc/'.mysql_result($resFoto,0,'archivo');
               break;
               case 8:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/nss/'.mysql_result($resFoto,0,'archivo');
               break;
               case 9:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/comprobanteestudio/'.mysql_result($resFoto,0,'archivo');
               break;
               case 10:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/comprobantedomicilio/'.mysql_result($resFoto,0,'archivo');
               break;
               case 11:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/cv/'.mysql_result($resFoto,0,'archivo');
               break;
               case 12:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/infonavit/'.mysql_result($resFoto,0,'archivo');
               break;
               case 13:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/caratula/'.mysql_result($resFoto,0,'archivo');
               break;
               case 14:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/solicitud/'.mysql_result($resFoto,0,'archivo');
               break;
               case 15:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/formatofirma/'.mysql_result($resFoto,0,'archivo');
               break;
               case 16:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/consar/'.mysql_result($resFoto,0,'archivo');
               break;
               case 17:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/nolaborargobierno/'.mysql_result($resFoto,0,'archivo');
               break;
               case 18:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/codigoetica/'.mysql_result($resFoto,0,'archivo');
               break;
               case 19:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/aceptacionpoliticas/'.mysql_result($resFoto,0,'archivo');
               break;
               case 20:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/cuentaclave/'.mysql_result($resFoto,0,'archivo');
               break;
               case 21:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/banco/'.mysql_result($resFoto,0,'archivo');
               break;
               case 22:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/cf1/'.mysql_result($resFoto,0,'archivo');
               break;
               case 23:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/cf2/'.mysql_result($resFoto,0,'archivo');
               break;
               case 24:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/cf3/'.mysql_result($resFoto,0,'archivo');
               break;
               case 25:
                  $imagen = '../../archivos/postulantes/'.$idpostulante.'/compromiso/'.mysql_result($resFoto,0,'archivo');
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

      $resPostulante = $serviciosReferencias->traerPostulantesPorId($idpostulante);

      if (mysql_num_rows($resPostulante) > 0) {
         $nombre           = mysql_result($resPostulante,0,'nombre');
         $apellidopaterno  = mysql_result($resPostulante,0,'apellidopaterno');
         $apellidomaterno  = mysql_result($resPostulante,0,'apellidomaterno');
      } else {
         $nombre           = '';
         $apellidopaterno  = '';
         $apellidomaterno  = '';
      }

      $password = $_POST['password'];

      //pongo al usuario $activo
   	$resUsuario = $serviciosUsuarios->activarUsuario($idusuario,$password);

      // concreto la activacion
      $resConcretar = $serviciosUsuarios->eliminarActivacionusuarios($activacion);

      if ($resUsuario == '') {
         /* email base */
         $destinatario = 'rlinares@asesorescrea.com';
         $asunto = 'Activacion de Usuario';
         $cuerpo = 'El usuario '.$nombre.' '.$apellidopaterno.' '.$apellidomaterno.' se dio de alta al sistema';

         $resEmail = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
         /* email referencte si existiera */
         $resReferente = $serviciosReferencias->traerReclutadorasoresPorPostulante($idpostulante);
         if (mysql_num_rows($resReferente) > 0) {
            $destinatario = mysql_result($resReferente,0,'email');
            $resEmailReferente = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
         }
         echo '';
      } else {
         echo 'Hubo un error al modificar datos';
      }
   }


   function activarUsuarioCliente($serviciosUsuarios, $serviciosReferencias) {
      //usuario del form
      $idusuario = $_POST['idusuario'];
      $activacion = $_POST['activacion'];

      // cliente del form
      $idcliente = $_POST['idcliente'];
      //token del form
      $token = $_POST['token'];

      $restoken = $serviciosUsuarios->traerActivacionusuariosPorToken($token);

      // si el token existe
      if (mysql_num_rows($restoken) > 0) {
          // usuario del token
          $idusuarioaux = mysql_result($restoken,0,'refusuarios');

          $resClienteAux = $serviciosReferencias->traerClientesPorUsuarioCompleto($idusuarioaux);
          // cliente del token del susuario
          $idclienteaux = mysql_result($resClienteAux,0,0);

          // si el cliente del token del susuario existe
          if (mysql_num_rows($resClienteAux) > 0) {
              //verifico que tanto el cliente y el usuario del form, sean iguales a los del token.
              if (($idclienteaux == $idcliente) && ($idusuarioaux == $idusuario)) {


                  if (mysql_num_rows($resClienteAux) > 0) {
                     $nombre           = mysql_result($resClienteAux,0,'nombre');
                     $apellidopaterno  = mysql_result($resClienteAux,0,'apellidopaterno');
                     $apellidomaterno  = mysql_result($resClienteAux,0,'apellidomaterno');
                     $email            = mysql_result($resClienteAux,0,'email');
                  } else {
                     $nombre           = '';
                     $apellidopaterno  = '';
                     $apellidomaterno  = '';
                     $email            = '';
                  }

                  $password = $_POST['password'];

                  //pongo al usuario $activo
                  $resUsuario = $serviciosUsuarios->activarUsuario($idusuario,$password);

                  // concreto la activacion
                  $resConcretar = $serviciosUsuarios->eliminarActivacionusuarios($activacion);

                  if ($resUsuario == '') {
                     /* email base */
                     $destinatario = 'msaupurein@asesorescrea.com';
                     $asunto = 'Activacion de Usuario';
                     $cuerpo = 'El usuario '.$nombre.' '.$apellidopaterno.' '.$apellidomaterno.' se dio de alta al sistema';

                     //$resEmail = $serviciosUsuarios->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
                     /* email envio un email para darle las indicaciones de como entrar */
                     $resActivacion = $serviciosUsuarios->registrarCliente($email, $apellidopaterno.' '.$apellidomaterno, $nombre, $idcliente, $idusuario,$password);

                     echo '';
                  } else {
                     echo 'Hubo un error al modificar datos';
                  }
              } else {
                  echo 'Se genero un error con el token, por favor verifique los datos';
              }


          } else {
              echo 'Se genero un error con el token, por favor verifique los datos';
          }


      } else {
          echo 'Se genero un error con el token, por favor verifique los datos';
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
      case 'dbsiniestros':
         $resultado = $serviciosReferencias->traerSiniestrosPorId( $id);

         $modificar = "modificarSiniestros";
         $idTabla = "idsiniestro";


         $lblCambio	 	= array('refventas','refestadosiniestro','fechasiniestro','fechaaplicacion');
         $lblreemplazo	= array('Poliza','Estado','Fecha del Siniestro','Fecha de Aplicacion o solucion');

         $resVar1 = $serviciosReferencias->traerVentasActivos();
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1,2,9),' - ',mysql_result($resultado,0,'refventas'));

         $resVar2 = $serviciosReferencias->traerEstadoSiniestro();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refestadosiniestro'));


         $refdescripcion = array(0=>$cadRef1,1=>$cadRef2);
         $refCampo 	=  array('refventas','refestadosiniestro');
      break;
      case 'dbperiodicidadventasdetalle':
         $resultado = $serviciosReferencias->traerPeriodicidadventasdetallePorId( $id);

         $modificar = "modificarPeriodicidadventasdetalle";
         $idTabla = "idperiodicidadventadetalle";


         $lblCambio	 	= array('refperiodicidadventas','montototal','primaneta','porcentajecomision','montocomision','fechapago','fechavencimiento','refestadopago','nrorecibo');
         $lblreemplazo	= array('Venta','Monto Total','Prima Neta','% Comision','Monto Comision','Fecha Pago','Fecha Vencimiento','Estado Pago','Nro Recibo');

         $resVar = $serviciosReferencias->traerPeriodicidadventasPorIdCompleto(mysql_result($resultado,0,'refperiodicidadventas'));
         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(1,2,3),' ',mysql_result($resultado,0,'refperiodicidadventas'));


         $resVar2 = $serviciosReferencias->traerEstadopago();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refestadopago'));


         $refdescripcion = array(0=>$cadRef,1=>$cadRef2);
         $refCampo 	=  array('refperiodicidadventas','refestadopago');
      break;
      case 'dbsolicitudesrespuestas':
         $resultado = $serviciosReferencias->traerSolicitudesrespuestasPorId( $id);

         $modificar = "modificarSolicitudesrespuestas";
         $idTabla = "idsolicituderespuesta";

         $lblCambio	 	= array('refsolicitudpdf','reftabla','camporeferencia');
         $lblreemplazo	= array('Solicitud','Tabla','Información');


         $resVar1 = $serviciosReferencias->traerSolicitudpdf();
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1),'',mysql_result($resultado,0,'refsolicitudpdf'));

         $resTabla = $serviciosReferencias->traerTablaPorId(mysql_result($resultado,0,'reftabla'));
         if (mysql_num_rows($resTabla) > 0) {
            $tablaAux = mysql_result($resTabla,0,'tabla');
         } else {
            $tablaAux = '';
         }
         $resVar2 = $serviciosReferencias->traerTablaPorIn('1,2,3,12,13,14');
         $cadRef2 = '<option value="0">Ninguno</option>';
         $cadRef2 .= $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(2),'',mysql_result($resultado,0,'reftabla'));


         if ($tablaAux != '') {
            $resVar3 	= $serviciosReferencias->devolverCamposTabla($tablaAux);
            $cadRef3 = '<option value="0">Ninguno</option>';
            $cadRef3 .= $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(0),'',mysql_result($resultado,0,'camporeferencia'));
         } else {

            $cadRef3 = '<option value="0">Ninguno</option>';

         }

         if (mysql_result($resultado,0,'fijo') == '1') {
            $cadRef4 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef4 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $refdescripcion = array(0=>$cadRef1,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4);
         $refCampo 	=  array('refsolicitudpdf','reftabla','camporeferencia','fijo');
      break;
      case 'dbpagos':
         $resultado = $serviciosReferencias->traerPagosPorId( $id);

         $modificar = "modificarPagos";
         $idTabla = "idpago";

         $lblCambio	 	= array('refestado','razonsocial','nrorecibo');
         $lblreemplazo	= array('Estado','Razon Social','Folio de pago Asesores Crea');

         $res = $serviciosReferencias->traerEstadodocumentaciones();
         $cad = $serviciosFunciones->devolverSelectBoxActivo($res,array(1),'',mysql_result($resultado,0,'refestado'));


         $refdescripcion = array(0=>$cad);
         $refCampo 	=  array('refestado');
      break;
      case 'tbcuentasbancarias':
         $resultado = $serviciosReferencias->traerCuentasbancariasPorId($id);

         $modificar = "modificarCuentasbancarias";
         $idTabla = "idcuentabancaria";

         $lblCambio	 	= array('razonsocial','clabeinterbancaria','refbancos');
         $lblreemplazo	= array('Razon Social','Clabe Interbancaria','Banco');

         $res = $serviciosReferencias->traerBancos();
         $cad = $serviciosFunciones->devolverSelectBoxActivo($res,array(1),'',mysql_result($resultado,0,'refbancos'));


         $refdescripcion = array(0=>$cad);
         $refCampo 	=  array('refbancos');
      break;
      case 'dbvaloredad':
         $resultado = $serviciosReferencias->traerValoredadPorId($id);

         $modificar = "modificarValoredad";
         $idTabla = "idvaloredad";

         $lblCambio	 	= array('refproductos','desde','hasta','vigdesde','vighasta');
         $lblreemplazo	= array('Producto','Edad desde','Edad hasta','Vig. Desde','Vig. Hasta');

         $res = $serviciosReferencias->traerProductos();
         $cad = $serviciosFunciones->devolverSelectBoxActivo($res,array(1),'',mysql_result($resultado,0,'refproductos'));


         $refdescripcion = array(0=>$cad);
         $refCampo 	=  array('refproductos');
      break;
      case 'dblead':
         $resultado = $serviciosReferencias->traerLeadPorId($id);

         $modificar = "modificarLead";
         $idTabla = "idlead";

         $lblCambio	 	= array('refclientes','refproductos','fechacrea','fechamodi','contactado','usuariocontacto','usuarioresponsable','refestadolead','fechacreacita','tipo','refproductosweb');
         $lblreemplazo	= array('Cliente','Producto','Fecha Alta','Fecha Ultima','Fue contactado?','Quien contacto','Responsable','Estado','Fecha Cita','Tipo de Producto','Producto Solicitado');

         $resClientes = $serviciosReferencias->traerClientes();
         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resClientes,array(3,4,2),' ',mysql_result($resultado,0,'refclientes'));


         $resProductosWeb = $serviciosReferencias->traerProductoswebPorId(mysql_result($resultado,0,'refproductosweb'));
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resProductosWeb,array(1),'',mysql_result($resultado,0,'refproductosweb'));

         $resProductos = $serviciosReferencias->traerProductosPorIdCompletaTipo(mysql_result($resProductosWeb,0,'tipo'));
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resProductos,array(1),'',mysql_result($resultado,0,'refproductos'));

         if (mysql_result($resultado,0,'contactado') == '1') {
            $cadRef3 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef3 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'refestadolead') == 1) {
            $resEstado 	= $serviciosReferencias->traerEstadoleadPorIn('1,2,3,4,6');
         } else {
            $resEstado 	= $serviciosReferencias->traerEstadoleadPorId(mysql_result($resultado,0,'refestadolead'));
         }

         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resEstado,array(1),'',mysql_result($resultado,0,'refestadolead'));

         $refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4,4=>$cadRef1);
         $refCampo 	=  array('refclientes','refproductos','contactado','refestadolead','refproductosweb');
      break;

      case 'dbproductosexclusivos':
         $resultado = $serviciosReferencias->traerProductosexclusivosPorId($id);

         $modificar = "modificarProductosexclusivos";
         $idTabla = "idproductoexcluisvo";

         $lblCambio	 	= array('refasesores','refproductos');
         $lblreemplazo	= array('Asesores','Productos');

         $resAsesores = $serviciosReferencias->traerAsesores();
         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resAsesores,array(3,4,2),' ',mysql_result($resultado,0,'refasesores'));

         $resProductos = $serviciosReferencias->traerProductos();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resProductos,array(1),'',mysql_result($resultado,0,'refproductos'));

         $refdescripcion = array(0=>$cadRef,1=>$cadRef2);
         $refCampo 	=  array('refasesores','refproductos');
      break;
      case 'tbtipodocumentaciones':
         $resultado = $serviciosReferencias->traerTipodocumentacionesPorId($id);

         $modificar = "modificarTipodocumentaciones";
         $idTabla = "idtipodocumentacion";

         $lblCambio	 	= array('tipodocumentacion');
         $lblreemplazo	= array('Tipo Documentacion');



         $refdescripcion = array();
         $refCampo 	=  array();
      break;
      case 'dbrespuestascuestionario':
         $resultado = $serviciosReferencias->traerRespuestascuestionarioPorId($id);

         $modificar = "modificarRespuestascuestionario";
         $idTabla = "idrespuestacuestionario";

         $lblCambio	 	= array('refpreguntascuestionario','activo');
         $lblreemplazo	= array('Pregunta','Activo');

         $resVar1 = $serviciosReferencias->traerPreguntascuestionarioPorId(mysql_result($resultado,0,'refpreguntascuestionario'));
         $cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(3),'');

         if (mysql_result($resultado,0,'activo') == '1') {
            $cadRef3 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef3 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'inhabilita') == '1') {
            $cadRef4 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef4 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $refdescripcion = array(0=>$cadRef1,1=>$cadRef3,2=>$cadRef4);
         $refCampo 	=  array('refpreguntascuestionario','activo','inhabilita');
      break;
      case 'dbpreguntascuestionario':
         $resultado = $serviciosReferencias->traerPreguntascuestionarioPorId($id);

         $modificar = "modificarPreguntascuestionario";
         $idTabla = "idpreguntacuestionario";

         $lblCambio	 	= array('refcuestionarios','reftiporespuesta','activo','depende','dependerespuesta');
         $lblreemplazo	= array('Cuestionario','Tipo Respuesta','Activo','Depende','Respuesta');

         $resVar1 = $serviciosReferencias->traerCuestionarios();
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1),'',mysql_result($resultado,0,'refcuestionarios'));

         $resVar2 = $serviciosReferencias->traerTiporespuestaPorId(mysql_result($resultado,0,'reftiporespuesta'));
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'reftiporespuesta'));

         if (mysql_result($resultado,0,'activo') == '1') {
            $cadRef3 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef3 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $resP = $serviciosReferencias->traerPreguntascuestionarioPorCuestionario(mysql_result($resultado,0,'refcuestionarios'));
         $cadRef4 = "<option value='0'>-- Seleccionar --</option>";
         $cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($resP,array(3),'',mysql_result($resultado,0,'depende'));

         if (mysql_result($resultado,0,'depende') > 0) {
            $resR = $serviciosReferencias->traerRespuestascuestionarioPorPregunta(mysql_result($resultado,0,'depende'));
            $cadRef5 = $serviciosFunciones->devolverSelectBoxActivo($resR,array(1),'',mysql_result($resultado,0,'dependerespuesta'));

         } else {
            $cadRef5 = '<option value="0">-- Seleccionar --</option>';
         }

         if (mysql_result($resultado,0,'obligatoria') == '1') {
            $cadRef6 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef6 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $refdescripcion = array(0=>$cadRef1,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4,4=>$cadRef5,5=>$cadRef6);
         $refCampo 	=  array('refcuestionarios','reftiporespuesta','activo','depende','dependerespuesta','obligatoria');
      break;

      case 'dbcuestionarios':
         $resultado = $serviciosReferencias->traerCuestionariosPorId($id);

         $modificar = "modificarCuestionarios";
         $idTabla = "idcuestionario";

         $lblCambio	 	= array('activo');
         $lblreemplazo	= array('Activo');

         if (mysql_result($resultado,0,'activo') == '1') {
            $cadRef = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $refdescripcion = array(0=>$cadRef);
         $refCampo 	=  array('activo');
      break;

      case 'tbproductos':
         $resultado = $serviciosReferencias->traerProductosPorId($id);

         $modificar = "modificarProductos";
         $idTabla = "idproducto";

         $lblCambio	 	= array('reftipoproductorama','reftipodocumentaciones','puntosporventa','puntosporpesopagado','refcuestionarios','puntosporventarenovado','puntosporpesopagadorenovado','reftipopersonas','ventaenlinea','cotizaenlinea','beneficiario','asegurado','reftipofirma','reftipoemision','esdomiciliado','consolicitud');
         $lblreemplazo	= array('Ramo de Producto','Tipo de Documentaciones','Punto x Venta','Puntos x Peso Pagado','Cuestionario','Punto x Venta Renovacion','Puntos x Peso Pagado Renovacion','Tipo Personas','Es de venta en linea','Es para cotizar','Podría tener beneficiario ','Podría tener asegurado distinto al contratante','Firmas','Tipo de Emision','Es Domiciliado','Necesita Firmar Solicitud');

         $resVar1 = $serviciosReferencias->traerTipoproductorama();
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(2),'',mysql_result($resultado,0,'reftipoproductorama'));

         if (mysql_result($resultado,0,'activo') == '1') {
            $cadRef2 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef2 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'prima') == '1') {
            $cadRef3 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef3 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $resVar4 = $serviciosReferencias->traerTipodocumentaciones();
         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(1),'',mysql_result($resultado,0,'reftipodocumentaciones'));

         $resCuest = $serviciosReferencias->traerCuestionarios();
         $cadRef5 = '<option value="">-- Seleccionar --</option>';
         $cadRef5 .= $serviciosFunciones->devolverSelectBoxActivo($resCuest,array(1),'',mysql_result($resultado,0,'refcuestionarios'));

         $resVar8 = $serviciosReferencias->traerTipopersonas();
         $cadRef8 = $serviciosFunciones->devolverSelectBoxActivo($resVar8,array(1),'',mysql_result($resultado,0,'reftipopersonas'));

         if (mysql_result($resultado,0,'ventaenlinea') == '1') {
            $cadRef9 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef9 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'cotizaenlinea') == '1') {
            $cadRef99 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef99 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'beneficiario') == '1') {
            $cadRef999 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef999 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'asegurado') == '1') {
            $cadRef9999 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef9999 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $resVar10 = $serviciosReferencias->traerTipofirma();
         $cadRef10 = $serviciosFunciones->devolverSelectBoxActivo($resVar10,array(1),'',mysql_result($resultado,0,'reftipofirma'));

         $resVar11 = $serviciosReferencias->traerTipoemision();
         $cadRef11 = $serviciosFunciones->devolverSelectBoxActivo($resVar11,array(1),'',mysql_result($resultado,0,'reftipoemision'));

         if (mysql_result($resultado,0,'esdomiciliado') == '1') {
            $cadRef12 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef12 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'consolicitud') == '1') {
            $cadRef13 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef13 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $refdescripcion = array(0=>$cadRef1,1=>$cadRef4,2=>$cadRef2,3=>$cadRef3,4=>$cadRef5,5=>$cadRef8,6=>$cadRef9,7=>$cadRef99,8=>$cadRef999,9=>$cadRef9999,10=>$cadRef10,11=>$cadRef11,12=>$cadRef12,13=>$cadRef13);
         $refCampo 	=  array('reftipoproductorama','reftipodocumentaciones','activo','prima','refcuestionarios','reftipopersonas','ventaenlinea','cotizaenlinea','beneficiario','asegurado','reftipofirma','reftipoemision','esdomiciliado','consolicitud');
      break;

      case 'dbdocumentaciones':
         $resultado = $serviciosReferencias->traerDocumentacionesPorId($id);

         $modificar = "modificarDocumentaciones";
         $idTabla = "iddocumentacion";

         $lblCambio	 	= array('reftipodocumentaciones','refprocesocotizacion');
         $lblreemplazo	= array('Tipo Documentacion','Proceso');

         $resVar = $serviciosReferencias->traerTipodocumentaciones();
         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(1),'',mysql_result($resultado,0,'reftipodocumentaciones'));

         if (mysql_result($resultado,0,'obligatoria') == '1') {
            $cadRef2 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef2 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         if (mysql_result($resultado,0,'activo') == '1') {
            $cadRef3 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef3 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }

         $resVar4 = $serviciosReferencias->traerProcesocotizacion();
         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(1),'',mysql_result($resultado,0,'refprocesocotizacion'));

         $refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4);
         $refCampo 	=  array('reftipodocumentaciones','obligatoria','activo','refprocesocotizacion');
      break;
      case 'dbventas':
         $resultado = $serviciosReferencias->traerVentasPorId($id);

         $lblCambio	 	= array('refcotizaciones','primaneta','primatotal','foliotys','foliointerno','fechavencimientopoliza','nropoliza','refproductosaux','vigenciadesde');
         $lblreemplazo	= array('Venta','Prima Neta','Prima Total','Folio TYS','Folio Interno','Fecha Vencimiento de la Poliza','Nro Poliza','Producto Especifico','Vigencia Desde');

         $modificar = "modificarVentas";
         $idTabla = "idventa";

         $resVar = $serviciosReferencias->traerCotizacionesPorIdCompleto(mysql_result($resultado,0,'refcotizaciones'));
         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(1,2,3),' ',mysql_result($resultado,0,'refcotizaciones'));

         $resVar2 = $serviciosReferencias->traerEstadoventa();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),' ',mysql_result($resultado,0,'refestadoventa'));

         if (mysql_result($resultado,0,'refproductosaux')>0) {
            $resVar3 = $serviciosReferencias->traerProductosPorId(mysql_result($resultado,0,'refproductosaux'));
            $cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),' ',mysql_result($resultado,0,'refproductosaux'));
         } else {
            $cadRef3 = "<option value='0'>Mismo de la cotización</option>";
         }


         $refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadRef3);
      	$refCampo 	=  array('refcotizaciones','refestadoventa','refproductosaux');
      break;
      case 'dbconstancias':
         $resultado = $serviciosReferencias->traerConstanciasPorId($id);

         $lblCambio	 	= array('refasesores','tipo');
         $lblreemplazo	= array('Asesor','Tipo de Bono');

         $modificar = "modificarConstancias";
         $idTabla = "idconstancia";

         $resVar = $serviciosReferencias->traerAsesores();
         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(3,4,2),' ',mysql_result($resultado,0,'refasesores'));

         if (mysql_result($resultado,0,'cumplio') == '1') {
            $cadRef2 = "<option value='1' selected>Si</option><option value='0'>No</option>";
         } else {
            $cadRef2 = "<option value='1'>Si</option><option value='0' selected>No</option>";
         }


         $arMeses = array(6,9,12,18,21,24);

         $cadMeses = '';
         foreach ($arMeses as $valor) {
            if (mysql_result($resultado,0,'meses') == $valor) {
               $cadMeses .= "<option value='".$valor."' selected>".$valor."</option>";
            } else {
               $cadMeses .= "<option value='".$valor."'>".$valor."</option>";
            }

         }

         if (mysql_result($resultado,0,'cumplio') == '1') {
         	$cadRef3 = "<option value='1' selected>Bajo</option><option value='0'>Alto</option>";
         } else {
         	$cadRef3 = "<option value='1'>Bajo</option><option value='0' selected>Alto</option>";
         }


         $refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadMeses,3=>$cadRef3);
         $refCampo 	=  array('refasesores','cumplio','meses','tipo');
      break;
      case 'dbcomisiones':
         $resultado = $serviciosReferencias->traerComisionesPorId($id);

         $lblCambio	 	= array('reftabla','idreferencia');
         $lblreemplazo	= array('Puesto','Persona');

         $modificar = "modificarComisiones";
         $idTabla = "idcomision";

         $resRoles 	= $serviciosReferencias->traerTablaPorIn('1,2,9,10');
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resRoles,array(2),'',mysql_result($resultado,0,'reftabla'));

         $resPersonas = $serviciosReferencias->traerPersonaPorTabla(mysql_result($resultado,0,'reftabla'));
         switch (mysql_result($resultado,0,'reftabla')) {
            case 1:
               $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resPersonas,array(3,4,2),' ',mysql_result($resultado,0,'idreferencia'));
            break;
            case 2:
               $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resPersonas,array(2,3,4),' ',mysql_result($resultado,0,'idreferencia'));
            break;
            case 9:
               $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resPersonas,array(3),'',mysql_result($resultado,0,'idreferencia'));
            break;
            case 10:
               $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resPersonas,array(1),'',mysql_result($resultado,0,'idreferencia'));
            break;
            default:
               $cadRef = '<option value="">Sin Datos</option>';
         }

         $refdescripcion = array(0=>$cadRef1,1=>$cadRef);
         $refCampo 	=  array('reftabla','idreferencia');
      break;
      case 'tbespecialidades':
         $resultado = $serviciosReferencias->traerEspecialidadesPorId($id);

         $lblCambio	 	= array();
         $lblreemplazo	= array();

         $modificar = "modificarEspecialidades";
         $idTabla = "idespecialidad";

         $refdescripcion = array();
         $refCampo 	=  array();
      break;
      case 'dbclientes':
         $resultado = $serviciosReferencias->traerClientesPorId($id);

         $lblCambio	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonofijo','telefonocelular','reftipopersonas','numerocliente','razonsocial','emisioncomprobantedomicilio','emisionrfc','vencimientoine','idclienteinbursa','nroexterior','nrointerior','codigopostal','ine','rfc','curp');
         $lblreemplazo	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Fijo','Tel. Celular','Tipo Persona','Nro Cliente','Razon Social','Fecha Emision Compr. Domicilio','Fecha Emision RFC','Vencimiento INE','ID Cliente Inbursa','Nro Exterior','Nro Interior','Cod. Postal','INE','RFC','CURP');

         $modificar = "modificarClientes";
         $idTabla = "idcliente";

         $resVar8 = $serviciosReferencias->traerTipopersonas();
         $cadRef8 = $serviciosFunciones->devolverSelectBoxActivo($resVar8,array(1),'',mysql_result($resultado,0,'reftipopersonas'));

         $resVar9 = $serviciosReferencias->traerUsuariosPorRol(16);
         $cadRef9 = $serviciosFunciones->devolverSelectBoxActivo($resVar9,array(1),'',mysql_result($resultado,0,'refusuarios'));

         $refdescripcion = array(0=>$cadRef8,1=>$cadRef9);
         $refCampo 	=  array('reftipopersonas','refusuarios');
      break;
      case 'dbdirectorioasesores':
         $resultado = $serviciosReferencias->traerDirectorioasesoresPorId($id);

         $lblCambio	 	= array('refasesores','razonsocial','telefonocelular');
         $lblreemplazo	= array('Asesores','Nombre','Tel. Movil');



         $modificar = "modificarDirectorioasesores";
         $idTabla = "iddirectorioasesor";

         $resAsesores = $serviciosReferencias->traerAsesoresPorId(mysql_result($resultado,0,'refasesores'));

         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resAsesores,array(3,4,2),' ',mysql_result($resultado,0,'refasesores'));

         $refdescripcion = array(0=> $cadRef2);
         $refCampo 	=  array('refasesores');
      break;
      case 'dbcotizaciones':
         $resultado = $serviciosReferencias->traerCotizacionesPorId($id);

         $lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor');
         $lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor');



         $modificar = "modificarCotizaciones";
         $idTabla = "idcotizacion";

         $resUsuario = $serviciosUsuarios->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
         $cadRef1 	= $serviciosFunciones->devolverSelectBox($resUsuario,array(1),'');

         $resVar2	= $serviciosReferencias->traerClientes();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(4,2,3),' ',mysql_result($resultado,0,'refclientes'));

         $resVar3	= $serviciosReferencias->traerProductos();
         $cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resultado,0,'refclientes'));


         $resVar4	= $serviciosReferencias->traerAsesores();
         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(4,2,3),' ',mysql_result($resultado,0,'refclientes'));

         if ($_SESSION['idroll_sahilices'] == 7) {
         	$resVar5	= $serviciosReferencias->traerAsociadosPorUsuario($_SESSION['usuaid_sahilices']);
         	$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(4,2,3),' ');
         } else {
         	$resVar5	= $serviciosReferencias->traerAsociados();
         	$cadRef5 = $serviciosFunciones->devolverSelectBoxActivo($resVar5,array(4,2,3),' ',mysql_result($resultado,0,'refclientes'));
         }



         $resVar6 = $serviciosReferencias->traerEstadocotizaciones();
         $cadRef6 = $serviciosFunciones->devolverSelectBoxActivo($resVar6,array(1),'',mysql_result($resultado,0,'refclientes'));


         $refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6);
         $refCampo 	=  array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones');
      break;

      case 'dbasesores':
         $resultado = $serviciosReferencias->traerAsesoresPorId($id);

         $lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad','afore','compania','cedula','refesquemareclutamiento','nss','claveinterbancaria','idclienteinbursa','claveasesor','fechaalta','urlprueba','vigdesdecedulaseguro','vighastacedulaseguro','vigdesdeafore','vighastaafore','nropoliza','reftipopersonas','razonsocial','vigdesderc','vighastarc','refestadoasesor','refestadoasesorinbursa','envioalcliente');
         $lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad','¿Cuenta con cédula definitiva para venta de Afore?','¿Con que compañía vende actualmente?','¿Cuenta Con cedula definitiva para venta de Seguros?','Esquema de Reclutamiento','Nro de Seguro Social','Clave Interbancaria','ID Cliente Inbursa','Clave Asesor','Fecha de Alta','URL Prueba','Cedula Seg. Vig. Desde','Cedula Seg. Vig. Hasta','Afore Vig. Desde','Afore Vig. Hasta','N° Poliza','Tipo Persona','Razon Social','Vig. Desde RC','Vig. Hasta RC','Est. CREA','Est. INBURSA','Envia informacion al Cliente');



         $modificar = "modificarAsesores";
         $idTabla = "idasesor";

         $resUsuario = $serviciosUsuarios->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
         $cadRef1 	= $serviciosFunciones->devolverSelectBox($resUsuario,array(1),'');

         $resVar2	= $serviciosReferencias->traerEscolaridades();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refescolaridades'));

         if (mysql_result($resultado,0,'sexo') == '1') {
         	$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1' selected>Femenino</option><option value='2'>Masculino</option>";
         } else {
         	$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1'>Femenino</option><option value='2' selected>Masculino</option>";
         }

         if (mysql_result($resultado,0,'codigopostal') == '') {
            $codigopostal = '';
         } else {
            $resPostal = $serviciosReferencias->traerPostalPorId(mysql_result($resultado,0,'codigopostal'));

            $codigopostal = mysql_result($resPostal,0,'codigo');
         }

         $resVar8 = $serviciosReferencias->traerTipopersonas();
         $cadRef8 = $serviciosFunciones->devolverSelectBoxActivo($resVar8,array(1),'',mysql_result($resultado,0,'reftipopersonas'));

         $resVar9 = $serviciosReferencias->traerEstadoasesor();
         $cadRef9 = $serviciosFunciones->devolverSelectBoxActivo($resVar9,array(1),'',mysql_result($resultado,0,'refestadoasesor'));

         $resVar10 = $serviciosReferencias->traerEstadoasesor();
         $cadRef10 = $serviciosFunciones->devolverSelectBoxActivo($resVar10,array(1),'',mysql_result($resultado,0,'refestadoasesorinbursa'));

         if (mysql_result($resultado,0,'envioalcliente') == '1') {
         	$cadRef55 = "<option value='0'>No</option><option value='1' selected>Si</option>";
         } else {
         	$cadRef55 = "<option value='0' selected>No</option><option value='1'>Si</option>";
         }

         $refdescripcion = array(0=> $cadRef1,1=> $cadRef2, 2=>$cadRef5,3=>$cadRef8,4=>$cadRef9,5=>$cadRef10,6=>$cadRef55);
         $refCampo 	=  array('refusuarios','refescolaridades','sexo','reftipopersonas','refestadoasesor','refestadoasesorinbursa','envioalcliente');
      break;
      case 'dbpostulantes':

         $resultado = $serviciosReferencias->traerPostulantesPorId($id);

         $refestado = mysql_result($resultado,0,'refestadopostulantes');
         $refesquemareclutamiento  = mysql_result($resultado,0,'refesquemareclutamiento');

         $resEstado = $serviciosReferencias->traerGuiasPorEsquemaSiguiente($refesquemareclutamiento, $refestado);

         $ruta = $_POST['ruta'];

         if (mysql_num_rows($resEstado) > 0) {
            $url = $ruta.mysql_result($resEstado,0,'url').'?id='.$id;
         } else {

            $url = 'index.php';
         }

         $modificar = "modificarPostulantes";
         $idTabla = "idpostulante";

         $lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad','razonsocial');
         $lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad','Razon Social');

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

         $lblCambio	 	= array('nombrecompleto','refroles','refsocios');
         $lblreemplazo	= array('Nombre Completo','Perfil','Socio');


         $resRoles 	= $serviciosUsuarios->traerRoles();


         $cadRef = $serviciosFunciones->devolverSelectBoxActivo($resRoles,array(1),'',mysql_result($resultado,0,'refroles'));

         $resSocio = $serviciosReferencias->traerOrigenreclutamiento();
         $cadRef3 = '<option value="0">-- Seleccionar --</option>';
         $cadRef3 .= $serviciosFunciones->devolverSelectBoxActivo($resSocio,array(1),'',mysql_result($resultado,0,'refsocios'));

         $refdescripcion = array(0 => $cadRef,1=>$cadRef3);
         $refCampo 	=  array('refroles','refsocios');
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
      case 'dbasociados':
         $resultado = $serviciosReferencias->traerAsociadosPorId($id);

         $modificar = "modificarAsociados";
         $idTabla = "idasociado";

         $lblCambio	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonomovil','telefonotrabajo','refbancos','claveinterbancaria','reftipoasociado','nombredespacho','refestadoasociado','refoportunidades','refpostulantes');
         $lblreemplazo	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Trabajo','Sucursal Bancaria','Clave Interbancaria','Tipo Asociado','Nombre del Despacho','Est. Asociado','Oportunidad Aso.','Postulante Aso.');

         $resVar1 = $serviciosUsuarios->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
         $cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(1),'');

         $resVar2	= $serviciosReferencias->traerBancos();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refbancos'));

         $resVar4	= $serviciosReferencias->traerTipoasociado();
         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(1),'',mysql_result($resultado,0,'reftipoasociado'));

         $resVar3	= $serviciosReferencias->traerEstadoasociado();
         $cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resultado,0,'refestadoasociado'));

         $oportunidades = $serviciosReferencias->traerOportunidadesAsociados();
         $cadRef5 = "<option value=''>-- Seleccionar --</option>";
         if (mysql_result($resultado,0,'refoportunidades') != 0) {
            $cadRef5 .= $serviciosFunciones->devolverSelectBoxActivo($serviciosReferencias->traerOportunidadesPorId(mysql_result($resultado,0,'refoportunidades')),array(3,4,2),' ',mysql_result($resultado,0,'refoportunidades'));
         }
         $cadRef5 .= $serviciosFunciones->devolverSelectBoxActivo($oportunidades,array(1),'',mysql_result($resultado,0,'refoportunidades'));

         $postulantes = $serviciosReferencias->traerPostulantesAsociados();
         $cadRef6 = "<option value=''>-- Seleccionar --</option>";
         if (mysql_result($resultado,0,'refpostulantes') != 0) {
            $cadRef6 .= $serviciosFunciones->devolverSelectBoxActivo($serviciosReferencias->traerPostulantesPorId(mysql_result($resultado,0,'refpostulantes')),array(3,4,2),' ',mysql_result($resultado,0,'refpostulantes'));
         }
         $cadRef6 .= $serviciosFunciones->devolverSelectBoxActivo($postulantes,array(1),'',mysql_result($resultado,0,'refpostulantes'));

         $refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=>$cadRef4,3=>$cadRef3,4=>$cadRef5,5=>$cadRef6);
         $refCampo 	=  array('refusuarios','refbancos','reftipoasociado','refestadoasociado','refoportunidades','refpostulantes');
      break;
      case 'dbasociadostemporales':
         $resultado = $serviciosReferencias->traerAsociadostemporalesPorId($id);

         $modificar = "modificarAsociadostemporales";
         $idTabla = "idasociadotemporal";

         $lblCambio	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonomovil','telefonotrabajo','refbancos','claveinterbancaria','nombredespacho','refestadoasociado','refoportunidades');
         $lblreemplazo	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Trabajo','Sucursal Bancaria','Clave Interbancaria','Nombre Despacho','Estado Asociado','Oportunidades');

         $resVar1 = $serviciosUsuarios->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
         $cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(1),'');

         $resVar2	= $serviciosReferencias->traerBancos();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refbancos'));

         $resVar3	= $serviciosReferencias->traerEstadoasociado();
         $cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resultado,0,'refestadoasociado'));

         $oportunidades = $serviciosReferencias->traerOportunidadesAsociadosTemporales();
         $oportunidadesUnica = $serviciosReferencias->traerOportunidadesPorId(mysql_result($resultado,0,'refoportunidades'));

         $cadRef4 = "<option value=''>-- Seleccionar --</option>";
         $cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($oportunidades,array(1),'',mysql_result($resultado,0,'refoportunidades'));
         $cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($oportunidadesUnica,array(2,3,4),' ',mysql_result($resultado,0,'refoportunidades'));

         $refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4);
         $refCampo 	=  array('refusuarios','refbancos','refestadoasociado','refoportunidades');
      break;
      case 'dbreclutadorasores':
         $resultado = $serviciosReferencias->traerReclutadorasoresPorId($id);

         $modificar = "modificarReclutadorasores";
         $idTabla = "idreclutadorasor";

         $lblCambio	 	= array('refusuarios','refpostulantes','refoportunidades','refasesores','refasociados');
         $lblreemplazo	= array('Usuarios','Postulantes','Oportunidades','Asesores','Asociados');

         $resRoles 	= $serviciosUsuarios->traerUsuariosPorRol(3);
         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resRoles,array(3),'',mysql_result($resultado,0,'refusuarios'));

         $resPostulantes = $serviciosReferencias->traerPostulantes();
         $cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resPostulantes,array(3,4,2),' ',mysql_result($resultado,0,'refpostulantes'));

         $resOportunidades 	= $serviciosReferencias->traerOportunidades();
         $cadRef3 = "<option value='0'>-- Seleccionar --</option>";
         $cadRef3 .= $serviciosFunciones->devolverSelectBoxActivo($resOportunidades,array(2,3,4),' ',mysql_result($resultado,0,'refoportunidades'));


         $resAsesores = $serviciosReferencias->traerAsesores();
         $cadRef4 = "<option value='0'>-- Seleccionar --</option>";
         $cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($resAsesores,array(3,4,2),' ',mysql_result($resultado,0,'refasesores'));

         $resAsociados = $serviciosReferencias->traerAsociados();
         $cadRef5 = "<option value='0'>-- Seleccionar --</option>";
         $cadRef5 .= $serviciosFunciones->devolverSelectBoxActivo($resAsociados,array(3,4,2),' ',mysql_result($resultado,0,'refasociados'));

         $refdescripcion = array(0=>$cadRef1,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4,4=>$cadRef5);
         $refCampo 	=  array('refusuarios','refpostulantes','refoportunidades','refasesores','refasociados');
      break;
      case 'tbreferentes':
         $resultado = $serviciosReferencias->traerReferentesPorId($id);

         $modificar = "modificarReferentes";
         $idTabla = "idreferente";

         $lblCambio	 	= array('apellidopaterno','apellidomaterno','refusuarios');
         $lblreemplazo	= array('Apellido Paterno','Apellido Materno','Usuario Asignado');

         $resUsuario = $serviciosUsuarios->traerUsuariosPorRol(9);
         $cadRef3 = "<option value='0'>-- Seleccionar --</option>";
         $cadRef3 .= $serviciosFunciones->devolverSelectBoxActivo($resUsuario,array(2),'',mysql_result($resultado,0,'refusuarios'));

         $refdescripcion = array(0=>$cadRef3);
         $refCampo 	=  array('refusuarios');
      break;
      case 'dbentrevistaoportunidades':
         $resultado = $serviciosReferencias->traerEntrevistaoportunidadesPorId($id);

         $modificar = "modificarEntrevistaoportunidades";
         $idTabla = "identrevistaoportunidad";

         $lblCambio	 	= array('refoportunidades','codigopostal','refestadoentrevistas');
         $lblreemplazo	= array('Persona','Cod. Postal','Estado Entrevista');


         $resVar2	= $serviciosReferencias->traerOportunidadesPorId(mysql_result($resultado,0,'refoportunidades'));
         $cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1,2),' - ');

         $resVar4	= $serviciosReferencias->traerEstadoentrevistasPorIn('1,2,3,4');
         $cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(1),'',mysql_result($resultado,0,'refestadoentrevistas'));


         $refdescripcion = array(0=> $cadRef2,1=> $cadRef4);
         $refCampo 	=  array('refoportunidades','refestadoentrevistas');

      break;
      case 'dboportunidades':
         $resultado = $serviciosReferencias->traerOportunidadesPorId($id);

         $modificar = "modificarOportunidades";
         $idTabla = "idoportunidad";

         $lblCambio	 	= array('nombredespacho','refusuarios','refreferentes','refestadooportunidad','apellidopaterno','apellidomaterno','telefonomovil','telefonotrabajo','refmotivorechazos','reforigenreclutamiento');
         $lblreemplazo	= array('Nombre del Despacho','Asignar a Gerente Comercial','Persona que Recomendo','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Trabajo','Motivos de Rechazos','Origen de Reclutamiento');


         if ($_SESSION['idroll_sahilices'] == 3) {
            $resRoles 	= $serviciosUsuarios->traerUsuarioId($_SESSION['usuaid_sahilices']);
         } else {
            $resRoles 	= $serviciosUsuarios->traerUsuariosPorRol(3);
         }

         $cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resRoles,array(3),'',mysql_result($resultado,0,'refusuarios'));


         if ($_SESSION['idroll_sahilices'] == 3) {
            $resReferentes 	= $serviciosReferencias->traerReferentesPorId(mysql_result($resultado,0,'refreferentes'));
            $cadRef2 = "";
         } else {
            $resReferentes 	= $serviciosReferencias->traerReferentes();
            $cadRef2 = "<option value=''>-- Seleccionar --</option>";
         }


         $cadRef2 .= $serviciosFunciones->devolverSelectBoxActivo($resReferentes,array(1,2,3),' ',mysql_result($resultado,0,'refreferentes'));

         if ($_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 1) {
            $resEstado 	= $serviciosReferencias->traerEstadooportunidad();
         } else {
            if ($_SESSION['idroll_sahilices'] == 8) {
               $resEstado 	= $serviciosReferencias->traerEstadooportunidadPorIn('1,8');
            } else {
               $resEstado 	= $serviciosReferencias->traerEstadooportunidadPorIn('1,2,3,4,6');
            }

         }

         $cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resEstado,array(1),' ',mysql_result($resultado,0,'refestadooportunidad'));

         $resMotivos = $serviciosReferencias->traerMotivorechazos();
         $cadRef4 = "<option value=''>-- Seleccionar --</option>";
         $cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($resMotivos,array(1),' ',mysql_result($resultado,0,'refmotivorechazos'));

         $resGeneralEstado 	= $serviciosReferencias->traerEstadogeneraloportunidadPorId(mysql_result($resultado,0,'refestadogeneraloportunidad'));
         $cadRef5 = $serviciosFunciones->devolverSelectBox($resGeneralEstado,array(1),' ');

         if (mysql_result($resultado,0,'reforigenreclutamiento') == '') {
            $resVar9 = $serviciosReferencias->traerOrigenreclutamiento();
         } else {
            $resVar9 = $serviciosReferencias->traerOrigenreclutamientoPorId(mysql_result($resultado,0,'reforigenreclutamiento'));
         }

         $cadRef9 = $serviciosFunciones->devolverSelectBox($resVar9,array(1),'');

         $refdescripcion = array(0 => $cadRef1,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4,4=>$cadRef5,5=>$cadRef9);
         $refCampo 	=  array('refusuarios','refreferentes','refestadooportunidad','refmotivorechazos','refestadogeneraloportunidad','reforigenreclutamiento');
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
         case 'dbentrevistaoportunidades':
         echo str_replace('codigopostal','codigopostal2',$formulario);
         break;
         case 'tbentrevistasucursales':
         echo str_replace('refpostal','refpostal2',$formulario);
         break;
         case 'dbasesores':
         echo str_replace('codigopostal','codigopostal2',$formulario);
         break;
         default:
            echo $formulario;
         break;
      }

   }

}


function frmAjaxNuevo($serviciosReferencias,$serviciosFunciones) {
   $tabla = $_POST['tabla'];
   $id = $_POST['id'];

   //die(var_dump($tabla));

   switch ($tabla) {
      case 'dbentrevistaoportunidades':

         $insertar = "insertarEntrevistaoportunidades";
         $idTabla = "identrevistaoportunidad";

         $lblCambio	 	= array('refoportunidades','codigopostal','refestadoentrevistas');
   		$lblreemplazo	= array('Nombre Completo','CP','Estado');

   		$resOportunidad = $serviciosReferencias->traerOportunidadesPorId($id);
   		$cadRef1 = $serviciosFunciones->devolverSelectBox($resOportunidad,array(1),'');

   		$resEstado = $serviciosReferencias->traerEstadoentrevistasPorId(1);
   		$cadRef2 = $serviciosFunciones->devolverSelectBox($resEstado,array(1),'');

   		$refdescripcion = array(0 => $cadRef1,1 => $cadRef2);
   		$refCampo 	=  array('refoportunidades','refestadoentrevistas');

      break;

      default:
         // code...
         break;
   }

   $formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

   //die(var_dump($formulario));
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



function insertarAsesores($serviciosReferencias, $serviciosUsuarios) {
   session_start();

   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];

   $apellido = $apellidopaterno.' '.$apellidomaterno;

   $password = $apellidopaterno.$apellidomaterno.date('His');

   $resUsuario = $serviciosUsuarios->insertarUsuario($nombre,$password,7,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

   if ((integer)$resUsuario > 0) {
      $refusuarios = $resUsuario;
      $curp = $_POST['curp'];
      $rfc = $_POST['rfc'];
      $ine = $_POST['ine'];
      $fechanacimiento = $_POST['fechanacimiento'];
      $sexo = $_POST['sexo'];
      $codigopostal = $_POST['codigopostalaux'];
      $refescolaridades = $_POST['refescolaridades'];
      $telefonomovil = $_POST['telefonomovil'];
      $telefonocasa = $_POST['telefonocasa'];
      $telefonotrabajo = $_POST['telefonotrabajo'];

      $fechacrea = date('Y-m-d H:i:s');
      $fechamodi = date('Y-m-d H:i:s');

      $usuariocrea = $_SESSION['usua_sahilices'];
      $usuariomodi = $_SESSION['usua_sahilices'];

      $reftipopersonas = $_POST['reftipopersonas'];
      $claveinterbancaria = $_POST['claveinterbancaria'];
      $idclienteinbursa = $_POST['idclienteinbursa'];
      $claveasesor = $_POST['claveasesor'];
      $fechaalta = $_POST['fechaalta'];
      $nss = $_POST['nss'];
      $razonsocial = $_POST['razonsocial'];

      $nropoliza = $_POST['nropoliza'];
      $vigdesdecedulaseguro = $_POST['vigdesdecedulaseguro'];
      $vighastacedulaseguro = $_POST['vighastacedulaseguro'];
      $vigdesderc = $_POST['vigdesderc'];
      $vighastarc = $_POST['vighastarc'];

      $refestadoasesor = $_POST['refestadoasesor'];
      $refestadoasesorinbursa = $_POST['refestadoasesorinbursa'];

      $envioalcliente = $_POST['envioalcliente'];

      $res = $serviciosReferencias->insertarAsesores($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$reftipopersonas,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$nss,$razonsocial,$nropoliza,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesderc, $vighastarc , $refestadoasesor,$refestadoasesorinbursa,$envioalcliente);

      if ((integer)$res > 0) {
         echo '';
      } else {
         echo 'Hubo un error al insertar datos';
      }
   } else {
      echo 'EL usuario ya existe';
   }
}


function modificarAsesores($serviciosReferencias) {
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
   $codigopostal = $_POST['codigopostalaux2'];
   $refescolaridades = $_POST['refescolaridades'];
   $telefonomovil = $_POST['telefonomovil'];
   $telefonocasa = $_POST['telefonocasa'];
   $telefonotrabajo = $_POST['telefonotrabajo'];

   $fechamodi = date('Y-m-d H:i:s');

   $usuariomodi = $_SESSION['usua_sahilices'];

   $reftipopersonas = $_POST['reftipopersonas'];
   $claveinterbancaria = $_POST['claveinterbancaria'];
   $idclienteinbursa = $_POST['idclienteinbursa'];
   $claveasesor = $_POST['claveasesor'];
   $fechaalta = $_POST['fechaalta'];
   $nss = $_POST['nss'];
   $razonsocial = $_POST['razonsocial'];

   $nropoliza = $_POST['nropoliza'];
   $vigdesdecedulaseguro = $_POST['vigdesdecedulaseguro'];
   $vighastacedulaseguro = $_POST['vighastacedulaseguro'];
   $vigdesderc = $_POST['vigdesderc'];
   $vighastarc = $_POST['vighastarc'];

   $refestadoasesor = $_POST['refestadoasesor'];
   $refestadoasesorinbursa = $_POST['refestadoasesorinbursa'];

   $envioalcliente = $_POST['envioalcliente'];

   $res = $serviciosReferencias->modificarAsesores($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechamodi,$usuariomodi,$reftipopersonas,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$nss,$razonsocial,$nropoliza,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesderc, $vighastarc,$refestadoasesor,$refestadoasesorinbursa,$envioalcliente);

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
   session_start();

   $reftipopersonas = $_POST['reftipopersonas'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $razonsocial = $_POST['razonsocial'];
   $domicilio = $_POST['domicilio'];
   $telefonofijo = $_POST['telefonofijo'];
   $telefonocelular = $_POST['telefonocelular'];
   $email = $_POST['email'];
   $rfc = $_POST['rfc'];
   $ine = $_POST['ine'];
   $numerocliente = $_POST['numerocliente'];
   $refusuarios = 0;
   $fechacrea = date('Y-m-d H:i:s');
   $fechamodi = date('Y-m-d H:i:s');
   $usuariocrea = $_SESSION['usua_sahilices'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   $idclienteinbursa = ( $_POST['idclienteinbursa'] == '' ? '' : $_POST['idclienteinbursa']);

   $emisioncomprobantedomicilio = $_POST['emisioncomprobantedomicilio'];
   $emisionrfc = $_POST['emisionrfc'];
   $vencimientoine = $_POST['vencimientoine'];

   $colonia = $_POST['colonia'];
   $municipio = $_POST['municipio'];
   $codigopostal = $_POST['codigopostal'];
   $edificio = $_POST['edificio'];
   $nroexterior = $_POST['nroexterior'];
   $nrointerior = $_POST['nrointerior'];

   $estado = $_POST['estado'];
   $ciudad = $_POST['ciudad'];
   $curp = $_POST['curp'];

   $genero = $_POST['genero'];
   $refestadocivil = $_POST['refestadocivil'];

   $res = $serviciosReferencias->insertarClientes($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil);

   if ((integer)$res > 0) {
      if ($_SESSION['idroll_sahilices'] == 7) {
         $resClienteAsedor = $serviciosReferencias->insertarClientesasesores($res,$_SESSION['usuaid_sahilices'],$apellidopaterno,$apellidomaterno,$nombre,$razonsocial,$domicilio,$email,$rfc,$ine,$reftipopersonas,$telefonofijo,$telefonocelular,$genero,$refestadocivil);
      }
      echo '';
   } else {
      echo 'Hubo un error al insertar datos';
   }
}


function modificarClientes($serviciosReferencias) {
   session_start();

   $id = $_POST['id'];
   $reftipopersonas = $_POST['reftipopersonas'];
   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $razonsocial = $_POST['razonsocial'];
   $domicilio = $_POST['domicilio'];
   $telefonofijo = $_POST['telefonofijo'];
   $telefonocelular = $_POST['telefonocelular'];
   $email = $_POST['email'];
   $rfc = $_POST['rfc'];
   $ine = $_POST['ine'];
   $numerocliente = $_POST['numerocliente'];
   $refusuarios = $_POST['refusuarios'];
   //$fechacrea = $_POST['fechacrea'];
   $fechamodi = date('Y-m-d H:i:s');
   //$usuariocrea = $_POST['usuariocrea'];
   $usuariomodi = $_SESSION['usua_sahilices'];

   $idclienteinbursa = ( $_POST['idclienteinbursa'] == '' ? '' : $_POST['idclienteinbursa']);

   $emisioncomprobantedomicilio = $_POST['emisioncomprobantedomicilio'];
   $emisionrfc = $_POST['emisionrfc'];
   $vencimientoine = $_POST['vencimientoine'];

   $colonia = $_POST['colonia'];
   $municipio = $_POST['municipio'];
   $codigopostal = $_POST['codigopostal'];
   $edificio = $_POST['edificio'];
   $nroexterior = $_POST['nroexterior'];
   $nrointerior = $_POST['nrointerior'];

   $estado = $_POST['estado'];
   $ciudad = $_POST['ciudad'];
   $curp = $_POST['curp'];

   $genero = $_POST['genero'];
   $refestadocivil = $_POST['refestadocivil'];

   $res = $serviciosReferencias->modificarClientes($id,$reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechamodi,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil);

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

function traerClientesCotizador($serviciosReferencias, $serviciosFunciones) {
   $tipopersona = $_POST['tipopersona'];
   $asesor = $_POST['asesor'];

   if ($asesor == 0) {
      $res = $serviciosReferencias->traerClientesPorTipoPersona($tipopersona);
   } else {
      $res = $serviciosReferencias->traerClientesasesoresPorAsesorTipoPersona($asesor,$tipopersona);
   }

   if ($tipopersona == 1) {
      $cad = "<option value=''>-- Seleccionar --</option>";
      $cad .= $serviciosFunciones->devolverSelectBox($res,array(1),'');
   } else {
      $cad = "<option value=''>-- Seleccionar --</option>";
      $cad .= $serviciosFunciones->devolverSelectBox($res,array(2),'');
   }


   $resV['datos'] = $cad;

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
   $orden = $_POST['orden'];
   $carpeta = strtolower(str_replace(' ','', $_POST['documentacion']));
   $activo = $_POST['activo'];
   $refprocesocotizacion = ( $_POST['refprocesocotizacion'] == '' ? 0 : $_POST['refprocesocotizacion']);
   $leyenda = $_POST['leyenda'];

   $res = $serviciosReferencias->insertarDocumentaciones($reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$orden,$carpeta,$activo,$refprocesocotizacion,$leyenda);

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
   $orden = $_POST['orden'];
   $carpeta = strtolower(str_replace(' ','', $_POST['documentacion']));
   $activo = $_POST['activo'];
   $refprocesocotizacion = ( $_POST['refprocesocotizacion'] == '' ? 0 : $_POST['refprocesocotizacion']);
   $leyenda = $_POST['leyenda'];

   $res = $serviciosReferencias->modificarDocumentaciones($id,$reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$orden,$carpeta,$activo,$refprocesocotizacion,$leyenda);

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

   $resPostulante = $serviciosReferencias->traerPostulantesPorId($refpostulantes);
   $estadoUltimo = mysql_result($resPostulante,0,'ultimoestado');
   $estadoActual = mysql_result($resPostulante,0,'refestadopostulantes');

   $entrevistador = $_POST['entrevistador'];
   $fecha = $_POST['fecha'];
   $domicilio = $_POST['domicilio'];
   $codigopostal = $_POST['codigopostal2'];
   $refestadopostulantes = $_POST['refestadopostulantes'];
   $refestadoentrevistas = $_POST['refestadoentrevistas'];
   $refentrevistasucursales = $_POST['refentrevistasucursales'];

   if (($refestadoentrevistas == 4) || ($refestadoentrevistas == 5)) {
      if (isset($_POST['observaciones'])) {
         $resObservaciones = $serviciosReferencias->agregarObservacionPostulante($refpostulantes, $_POST['observaciones']);
      }

      $resEstadoPostulante = $serviciosReferencias->modificarEstadoPostulante($refpostulantes,9);
   } else {
      if ($estadoActual == 9) { // estado rechazado, lo vuelvo al estado que estaba cuando fue rechazado
         $resEstadoPostulante = $serviciosReferencias->modificarEstadoPostulante($refpostulantes,$estadoUltimo);

         $resObservaciones = $serviciosReferencias->agregarObservacionPostulante($refpostulantes, $_POST['observaciones']);
      }
   }

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

function validar_fecha_espanol($fecha){
	$valores = explode('/', $fecha);
	if(count($valores) == 3 && checkdate($valores[1], $valores[0], $valores[2])){
		return true;
    }
	return false;
}

function insertarPostulantes($serviciosReferencias, $serviciosUsuarios) {
   session_start();

   $nombre = $_POST['nombre'];
   $apellidopaterno = $_POST['apellidopaterno'];
   $apellidomaterno = $_POST['apellidomaterno'];
   $email = $_POST['email'];

   $apellido = $apellidopaterno.' '.$apellidomaterno;

   if (isset($_POST['fechanacimiento'])) {
      $password = $apellidopaterno.$apellidomaterno.date('His');

      $resUsuario = $serviciosUsuarios->insertarUsuario($nombre,$password,7,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

      //$resUsuario = 6;

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
         $folio = '';
         $cedula = $_POST['cedula'];

         if ($_POST['origen'] == 'web') {
            if ($cedula == '1') {
               $refesquemareclutamiento = 4;
            } else {
               $refesquemareclutamiento = 1;
            }
         } else {
            $refesquemareclutamiento = $_POST['refesquemareclutamiento'];
         }

         $reforigenreclutamiento = $_POST['reforigenreclutamiento'];


         if ($afore == '1') {
            //$refestadopostulantes = 9; // lo saco por orden de javier 19/12/2019

            // rechazo la solicitud

            // envio email de confirmacion para validar cuenta de email. Correr a la noche un CRON
            // para dar de baja los usuarios basura
            $resActivacion = $serviciosUsuarios->confirmarEmail($email, $password,$apellido, $nombre, $refusuarios);
         } else {
            // envio email de confirmacion para validar cuenta de email. Correr a la noche un CRON
            // para dar de baja los usuarios basura
            $resActivacion = $serviciosUsuarios->confirmarEmail($email, $password,$apellido, $nombre, $refusuarios);
            //die(var_dump($resActivacion));
         }

         if (isset($_POST['vigdesdecedulaseguro'])) {
            $vigdesdecedulaseguro = $_POST['vigdesdecedulaseguro'];
         } else {
            $vigdesdecedulaseguro = '';
         }

         if (isset($_POST['vighastacedulaseguro'])) {
            $vighastacedulaseguro = $_POST['vighastacedulaseguro'];
         } else {
            $vighastacedulaseguro = '';
         }

         if (isset($_POST['vigdesdeafore'])) {
            $vigdesdeafore = $_POST['vigdesdeafore'];
         } else {
            $vigdesdeafore = '';
         }

         if (isset($_POST['vighastaafore'])) {
            $vighastaafore = $_POST['vighastaafore'];
         } else {
            $vighastaafore = '';
         }

         if (isset($_POST['vigdesderc'])) {
            $vigdesderc = $_POST['vigdesderc'];
         } else {
            $vigdesderc = '';
         }

         if (isset($_POST['vighastarc'])) {
            $vighastarc = $_POST['vighastarc'];
         } else {
            $vighastarc = '';
         }

         // para la persona fisica o moral
         $reftipopersonas = $_POST['reftipopersonas'];
         $razonsocial = $_POST['razonsocial'];
         $email2 = $_POST['email2'];

         $observaciones = $_POST['observaciones'];
         $refreferentes = $_POST['refreferentes'];

         // desde el crm
         $res = $serviciosReferencias->insertarPostulantes($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$refesquemareclutamiento,$afore,$folio,$cedula,$token,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesdeafore,$vighastaafore,$reftipopersonas,$razonsocial,$reforigenreclutamiento,$email2,$vigdesderc,$vighastarc,$observaciones,$refreferentes);

         //die(var_dump($res));

         if ((integer)$res > 0) {


            if (isset($_SESSION['idroll_sahilices'])) {
               if (($_SESSION['idroll_sahilices'] == 2) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 5) || ($_SESSION['idroll_sahilices'] == 6)) {
                  if (isset($_POST['refoportunidades'])) {

                     $resRelacionRP = $serviciosReferencias->insertarReclutadorasores($_SESSION['usuaid_sahilices'],$res,($_POST['refoportunidades'] == '' ? 0 : $_POST['refoportunidades']),0,0);
                  } else {
                     $resRelacionRP = $serviciosReferencias->insertarReclutadorasores($_SESSION['usuaid_sahilices'],$res,0,0,0);
                  }

               }
            }


            /* marco el primer seguimiento */
            $resGuia = $serviciosReferencias->traerGuiasPorEsquema($refesquemareclutamiento);
            if ($refestadopostulantes == 9) {
               $resSeguimiento = $serviciosReferencias->insertarSeguimientos($res,mysql_result($resGuia,0,0),$usuariomodi,3);
            } else {
               $resSeguimiento = $serviciosReferencias->insertarSeguimientos($res,mysql_result($resGuia,0,0),$usuariomodi,2);
            }
            /* fin del seguimiento */
            echo '';
         } else {
            echo 'Hubo un error al insertar datos ';
         }


      } else {
         $resEliminar = $serviciosReferencias->eliminarUsuariosDefinitivamente($refusuarios);

         echo 'Hubo un error al crear usuario, verificar que no existe ya ese email en la base de datos';
      }
   } else {
      if (validar_fecha_espanol(substr(('00'.$_POST['dia']),-2).'/'.substr(('00'.$_POST['mes']),-2).'/'.$_POST['anio'])) {

         // primer creo el usuario

         $password = $apellidopaterno.$apellidomaterno.date('His');

         $resUsuario = $serviciosUsuarios->insertarUsuario($nombre,$password,7,$email,$nombre.' '.$apellidopaterno.' '.$apellidomaterno,1);

         //$resUsuario = 6;

         if ((integer)$resUsuario > 0) {
            $refusuarios = $resUsuario;

            // fin de crear usuario
            $curp = '';
            $rfc = '';
            $ine = '';
            $fechanacimiento = $_POST['anio'].'-'.substr(('00'.$_POST['mes']),-2).'-'.substr(('00'.$_POST['dia']),-2);
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
            $folio = '';
            $cedula = $_POST['cedula'];

            if ($cedula == '1') {
               $refesquemareclutamiento = 1;
            } else {
               $refesquemareclutamiento = 2;
            }

            if ($afore == '1') {
               $resActivacion = $serviciosUsuarios->confirmarEmail($email, $password,$apellido, $nombre, $refusuarios);
               // rechazo la solicitud
            } else {
               // envio email de confirmacion para validar cuenta de email. Correr a la noche un CRON
               // para dar de baja los usuarios basura
               $resActivacion = $serviciosUsuarios->confirmarEmail($email, $password,$apellido, $nombre, $refusuarios);
               //die(var_dump($resActivacion));
            }

            $vigdesdecedulaseguro = '';
            $vighastacedulaseguro = '';
            $vigdesdeafore = '';
            $vighastaafore = '';
            $vigdesderc = '';
            $vighastarc = '';

            // como la asignacion viene desde el test, la persona se considera fisica.
            $reftipopersonas = 1;
            $razonsocial = '';

            $reforigenreclutamiento = 1;
            $email2 = '';

            $observaciones = '';
            $refreferentes = 0;

            // desde el test
            $res = $serviciosReferencias->insertarPostulantes($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$refesquemareclutamiento,$afore,$folio,$cedula,$token,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesdeafore,$vighastaafore,$reftipopersonas,$razonsocial,$reforigenreclutamiento,$email2,$vigdesderc,$vighastarc,$observaciones,$refreferentes);

            //die(var_dump($res));

            if ((integer)$res > 0) {
               if ($cedula == '1') {
                  foreach ($_POST['lstseguros'] as $seguros) {
                     $resSeguro = $serviciosReferencias->insertarPostulanteseguros($res,$seguros);
                  }
               }
               echo '';
            } else {
               echo 'Hubo un error al insertar datos ';
            }


         } else {
            echo 'Hubo un error al crear usuario, verificar que no existe ya ese email en la base de datos';
         }
      } else {
         echo 'Hubo un error la fecha de nacimiento es invalida';
      }
   }

}


function modificarPostulantes($serviciosReferencias) {

   session_start();

   $id = $_POST['id'];

   $resPostulante = $serviciosReferencias->traerPostulantesPorId($id);

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
   $nss = $_POST['nss'];
   $refesquemareclutamiento = $_POST['refesquemareclutamiento'];

   $claveinterbancaria = $_POST['claveinterbancaria'];
   $idclienteinbursa = $_POST['idclienteinbursa'];
   $claveasesor = $_POST['claveasesor'];

   $vigdesdeafore = $_POST['vigdesdeafore'];
   $vighastaafore = $_POST['vighastaafore'];
   $vigdesdecedulaseguro = $_POST['vigdesdecedulaseguro'];
   $vighastacedulaseguro = $_POST['vighastacedulaseguro'];
   $nropoliza = $_POST['nropoliza'];

   if ($_SESSION['idroll_sahilices'] == 1) {
      $fechaalta = $_POST['fechaalta'];
   } else {
      if ($claveasesor != '') {

         if (mysql_result($resPostulante,0,'fechaalta') == '') {
            $fechaalta = date('Y-m-d H:i:s');
         } else {
            $fechaalta = mysql_result($resPostulante,0,'fechaalta');
         }

      } else {
         $fechaalta = '';
      }
   }


   $razonsocial = $_POST['razonsocial'];

   $reforigenreclutamiento = $_POST['reforigenreclutamiento'];
   $email2 = $_POST['email2'];

   $vigdesderc = $_POST['vigdesderc'];
   $vighastarc = $_POST['vighastarc'];

   $observaciones = $_POST['observaciones'];
   $refreferentes = $_POST['refreferentes'];

   $error = '';

   if ($refestadopostulantes == 11 && ($refesquemareclutamiento == 4 || $refesquemareclutamiento == 5 || $refesquemareclutamiento == 6) ) {
      if ($refesquemareclutamiento == 4) {
         $resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacion($id, 26);
      } else {
         $resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacion($id, 31);
      }

      // verificar dependeiendo el tipo de esquema de reclutamiento
      if (mysql_num_rows($resDocumentacionAsesor) <= 0 ) {
         $error = 'Debe Cargar la Cedula de Seguro para confirmar Agente Temporal';
      }
   }

   if ($error != '') {
      echo $error;
   } else {
      $res = $serviciosReferencias->modificarPostulantes($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$nss,$refesquemareclutamiento,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesdeafore,$vighastaafore,$nropoliza,$razonsocial,$reforigenreclutamiento,$email2,$vigdesderc,$vighastarc,$observaciones,$refreferentes);

      if ($res == true) {
         // si es asociado temporal o agente asociado id=8 lo genero automatico
         if ($refestadopostulantes == 11) {

            $resExiste = $serviciosReferencias->traerAsociadosPorUsuario($refusuarios);

            if (mysql_num_rows($resExiste) <= 0) {

               $cuerpo = '';
               $cuerpo .= '<h4>Nombre Completo: '.$nombre.' '.$apellidopaterno.' '.$apellidomaterno.'</h4><br>';

               if ($email != '') {


                  $resAT = $serviciosReferencias->insertarAsociados($refusuarios,2,$razonsocial,$apellidopaterno,$apellidomaterno,$nombre,'',$email,'null',$telefonomovil,$telefonotrabajo,1,'','',1,0,$id);
                  $asunto = 'Se genero un Agente Temporal';

                  $cuerpo .= "Acceda por este link: <a href='http://asesorescrea.com/desarrollo/crm/dashboard/asociados/index.php?id=".$resAT."'>ACCEDER</a>";


               } else {
                  $asunto = 'No se pudo generar un Agente Temporal por falta de email';
               }

               $destinatario = 'rlinares@asesorescrea.com';

               $res = $serviciosReferencias->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
            }

         }
         echo '';
      } else {
         echo 'Hubo un error al modificar datos';
      }
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

function eliminarPostulantesDefinitivo($serviciosReferencias) {
   $id = $_POST['id'];
      $res = $serviciosReferencias->eliminarPostulantesDefinitivo($id);
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
   $refsocios = $_POST['refsocios'];

	   $res = $serviciosReferencias->insertarUsuarios($usuario,$password,$refroll,$email,$nombre,1,$refsocios);
	if ((integer)$res > 0) {
		echo '';
	} else {
		echo $res;
	}
}


function modificarUsuario($serviciosReferencias) {
	$id					=	$_POST['id'];
	$usuario			=	$_POST['usuario'];
	$password			=	$_POST['password'];
	$refroll			=	$_POST['refroles'];
	$email				=	$_POST['email'];
	$nombre				=	$_POST['nombrecompleto'];
   $refsocios = $_POST['refsocios'];

   if (isset($_POST['activo'])) {
      $activo = 1;
   } else {
      $activo = 0;
   }

	$res = $serviciosReferencias->modificarUsuarios($id,$usuario,$password,$refroll,$email,$nombre,$activo,$refsocios);

   if ($res == true) {
      echo '';
   } else {
      echo 'Hubo un error al modificar datos';
   }
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
