<?php

session_start();

include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesUsuarios.php');

$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosUsuarios  		= new ServiciosUsuarios();

$tabla = $_GET['tabla'];
$draw = $_GET['sEcho'];
$start = $_GET['iDisplayStart'];
$length = $_GET['iDisplayLength'];
$busqueda = $_GET['sSearch'];


$idcliente = 0;

if (isset($_GET['idcliente'])) {
	$idcliente = $_GET['idcliente'];
} else {
	$idcliente = 0;
}


$referencia1 = 0;

if (isset($_GET['referencia1'])) {
	$referencia1 = $_GET['referencia1'];
} else {
	$referencia1 = 0;
}

$colSort = (integer)$_GET['iSortCol_0'] + 2;
$colSortDir = $_GET['sSortDir_0'];

function armarAcciones($id,$label='',$class,$icon) {
	$cad = "";

	for ($j=0; $j<count($class); $j++) {
		$cad .= '<button type="button" class="btn '.$class[$j].' btn-circle waves-effect waves-circle waves-float '.$label[$j].'" id="'.$id.'">
				<i class="material-icons">'.$icon[$j].'</i>
			</button> ';
	}

	return $cad;
}

function armarAccionesDropDown($id,$label='',$class,$icon) {
	$cad = '<div class="btn-group">
					<button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
						 Accions <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">';

	for ($j=0; $j<count($class); $j++) {
		$cad .= '<li><a href="javascript:void(0);" id="'.$id.'" class=" waves-effect waves-block '.$label[$j].'">'.$icon[$j].'</a></li>';

	}

	$cad .= '</ul></div>';

	return $cad;
}

switch ($tabla) {

	case 'constanciasseguimiento':

		$asesor = $_GET['sSearch_0'];

		$datos = $serviciosReferencias->traerConstanciasseguimientoajax($length, $start, $busqueda,$colSort,$colSortDir,$asesor);

		//die(var_dump($datos));

		$resAjax = $datos[0];
		$res = $datos[1];


		$label = array('btnVer');
		$class = array('bg-yellow');
		$icon = array('report_problem');


		$indiceID = 0;
		$empieza = 1;
		$termina = 8;

	break;

	case 'constanciasactuales':

		$datos = $serviciosReferencias->traerCalcularConstanciasajax($length, $start, $busqueda,$colSort,$colSortDir);

		//die(var_dump($datos));

		$resAjax = $datos[0];
		$res = $datos[1];


		$label = array('btnGenerar');
		$class = array('bg-green');
		$icon = array('add');


		$indiceID = 0;
		$empieza = 1;
		$termina = 3;

	break;

	case 'constancias':

		$asesor = $_GET['sSearch_0'];

		$datos = $serviciosReferencias->traerConstanciasajax($length, $start, $busqueda,$colSort,$colSortDir,$asesor);

		//die(var_dump($datos));

		$resAjax = $datos[0];
		$res = $datos[1];


		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');


		$indiceID = 0;
		$empieza = 1;
		$termina = 5;

	break;

	case 'comisiones':

		$datos = $serviciosReferencias->traerComisionesajax($length, $start, $busqueda,$colSort,$colSortDir);

		//die(var_dump($datos));

		$resAjax = $datos[0];
		$res = $datos[1];


		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');


		$indiceID = 0;
		$empieza = 1;
		$termina = 4;

	break;
	case 'especialidades':

		$datos = $serviciosReferencias->traerEspecialidadesajax($length, $start, $busqueda,$colSort,$colSortDir);

		$resAjax = $datos[0];
		$res = $datos[1];


		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');


		$indiceID = 0;
		$empieza = 1;
		$termina = 1;

	break;
	case 'directorio':

		$datos = $serviciosReferencias->traerDirectorioasesoresajax($length, $start, $busqueda,$colSort,$colSortDir,$_SESSION['idasesor_aux']);

		$resAjax = $datos[0];
		$res = $datos[1];


		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');


		$indiceID = 0;
		$empieza = 1;
		$termina = 5;

	break;

	case 'cotizaciones':

		if ($_SESSION['idroll_sahilices'] == 7) {

			$datos = $serviciosReferencias->traerCotizacionesajaxPorUsuario($length, $start, $busqueda,$colSort,$colSortDir,$_SESSION['usuaid_sahilices']);

			$resAjax = $datos[0];
			$res = $datos[1];

			$label = array('btnModificar','btnEliminar');
			$class = array('bg-amber','bg-red');
			$icon = array('create','delete');
		} else {

			$responsableComercial = $_GET['sSearch_0'];

			$datos = $serviciosReferencias->traerCotizacionesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial);

			$resAjax = $datos[0];
			$res = $datos[1];

			$label = array('btnModificar','btnEliminar');
			$class = array('bg-amber','bg-red');
			$icon = array('create','delete');

		}

		$indiceID = 0;
		$empieza = 1;
		$termina = 5;

	break;
	case 'asesores':
		$filtro = "where p.nombre like '%_busqueda%' or p.apellidopaterno like '%_busqueda%' or p.apellidomaterno like '%_busqueda%' or p.email like '%_busqueda%' or p.idclienteinbursa like '%_busqueda%' or p.razonsocial like '%_busqueda%' or p.claveasesor like '%_busqueda%' or  DATE_FORMAT( p.fechaalta, '%Y-%m-%d') like '%_busqueda%'";

		$consulta = 'select
			p.idasesor,
			p.razonsocial,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.idclienteinbursa,
			p.claveasesor,
			p.fechaalta,
			usur.nombrecompleto,
			tea.estadoasesor,
			teai.estadoasesor,
			p.claveinterbancaria
		from dbasesores p
		inner join tbestadoasesor tea on tea.idestadoasesor = p.refestadoasesor
		inner join tbestadoasesor teai on teai.idestadoasesor = p.refestadoasesorinbursa

		';
		if ($_SESSION['idroll_sahilices'] == 3) {
			$consulta .= ' inner join dbusuarios usu ON usu.idusuario = p.refusuarios
			inner join dbpostulantes pp on pp.refusuarios = usu.idusuario
			inner join dbreclutadorasores rrr on (rrr.refasesores = p.idasesor
			OR rrr.refpostulantes = pp.idpostulante) and rrr.refusuarios = '.$_SESSION['usuaid_sahilices'].'
			left join dbusuarios usur ON usur.idusuario = rrr.refusuarios';
			//$res = $serviciosReferencias->traerAsesoresPorGerente($_SESSION['usuaid_sahilices']);
		} else {
			if ($_SESSION['idroll_sahilices'] == 7) {
				$consulta .= ' inner join dbusuarios usur ON p.refusuarios = '.$_SESSION['usuaid_sahilices'].' ';
				//$res = $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
			} else {
				$responsableComercial = $_GET['sSearch_0'];
				if ($responsableComercial == '') {
					//$res = $serviciosReferencias->traerAsesores();
					$consulta .= ' inner join dbusuarios usu ON usu.idusuario = p.refusuarios
					left join dbpostulantes pp on pp.refusuarios = usu.idusuario
					left join dbreclutadorasores rrr on (rrr.refasesores = p.idasesor
					OR rrr.refpostulantes = pp.idpostulante)
					left join dbusuarios usur ON usur.idusuario = rrr.refusuarios';
				} else {

					//$res = $serviciosReferencias->traerAsesoresPorGerente($responsableComercial);
					$consulta .= ' inner join dbusuarios usu ON usu.idusuario = p.refusuarios
					LEFT join dbpostulantes pp on pp.refusuarios = usu.idusuario
					inner join dbreclutadorasores rrr on (rrr.refasesores = p.idasesor
					OR rrr.refpostulantes = pp.idpostulante) and rrr.refusuarios = '.$responsableComercial.'
					inner join dbusuarios usur ON usur.idusuario = rrr.refusuarios';
				}

			}

		}

		//die(var_dump($consulta));

		$datos = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta,'');

		$resAjax = $datos[0];
		$res = $datos[1];

		switch ($_SESSION['idroll_sahilices']) {
			case 1:
				$label = array('btnModificar','btnEliminar','btnPerfil','btnDirectorio','btnDomicilio','btnInformacion');
				$class = array('bg-amber','bg-red','bg-orange','bg-lime','bg-green','bg-green');
				$icon = array('Modificar','Eliminar','Expediente','Directorio','Domicilio','Informacion');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 2:
				$label = array('btnModificar','btnPerfil','btnDirectorio','btnDomicilio','btnInformacion');
				$class = array('bg-amber','bg-orange','bg-lime','bt-green','bg-green');
				$icon = array('Modificar','Expediente','Directorio','Domicilio','Informacion');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 3:
				$label = array('btnModificar','btnPerfil','btnDirectorio','btnDomicilio','btnInformacion');
				$class = array('bg-amber','bg-orange','bg-lime','bt-green','bg-green');
				$icon = array('Modificar','Expediente','Directorio','Domicilio','Informacion');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 4:
				$label = array('btnModificar','btnPerfil','btnDirectorio','btnDomicilio','btnInformacion');
				$class = array('bg-amber','bg-orange','bg-lime','Directorio','bt-green','bg-green');
				$icon = array('Modificar','Expediente','Directorio','Domicilio','Informacion');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 5:
				$label = array('btnModificar','btnPerfil','btnDirectorio','btnDomicilio','btnInformacion');
				$class = array('bg-amber','bg-orange','bg-lime','bt-green','bg-green');
				$icon = array('Modificar','Expediente','Directorio','Domicilio','Informacion');
				$indiceID = 0;
				$empieza = 1;
				$termina =11;
			break;
			case 6:
				$label = array('btnModificar','btnPerfil','btnDirectorio','btnDomicilio','btnInformacion');
				$class = array('bg-amber','bg-orange','bg-lime','bt-green','bg-green');
				$icon = array('Modificar','Expediente','Directorio','Domicilio','Informacion');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;

			default:
				$label = array();
				$class = array();
				$icon = array();
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
		}
	break;

	case 'asociados':

		if ($_SESSION['idroll_sahilices'] == 3 ) {
			$responsableComercial = $_SESSION['usuaid_sahilices'];
		} else {
			$responsableComercial = $_GET['sSearch_0'];
		}


		$datos = $serviciosReferencias->traerAsociadosajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial);

		$resAjax = $datos[0];
		$res = $datos[1];

		$label = array('btnModificar','btnEliminar','btnDocumentacion');
		$class = array('bg-amber','bg-red','bg-blue');
		$icon = array('Modificar','Eliminar','Documentaciones');
		$indiceID = 0;
		$empieza = 1;
		$termina = 9;

	break;
	case 'asociadostemporales':


		$resAjax = $serviciosReferencias->traerAsociadostemporalesajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerAsociadostemporales();
		$label = array('btnModificar','btnEliminar','btnDocumentacion');
		$class = array('bg-amber','bg-red','bg-blue');
		$icon = array('Modificar','Eliminar','Documentaciones');
		$indiceID = 0;
		$empieza = 1;
		$termina = 7;

	break;
	case 'clientes':


		$datos = $serviciosReferencias->traerClientesajax($length, $start, $busqueda,$colSort,$colSortDir);

		$resAjax = $datos[0];
		$res = $datos[1];

		$label = array('btnModificar','btnEliminar','btnDocumentacion');
		$class = array('bg-amber','bg-red','bg-blue');
		$icon = array('Modificar','Eliminar','Documentaciones');
		$indiceID = 0;
		$empieza = 1;
		$termina = 9;

	break;
	case 'postulantes':


		$filtro = "where rr.idasesor is null and (p.nombre like '%_busqueda%' or p.apellidopaterno like '%_busqueda%' or p.apellidomaterno like '%_busqueda%' or p.email like '%_busqueda%' or p.telefonomovil like '%_busqueda%' or ep.estadopostulante like '%_busqueda%' or est.estadocivil like '%_busqueda%' or DATE_FORMAT( p.fechacrea, '%Y-%m-%d') like '%_busqueda%')";

		$pre = "where rr.idasesor is null";

		$consulta = "select
			p.idpostulante,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.codigopostal,
			p.fechacrea,
			(case when p.refestadopostulantes < 9 then DATEDIFF(CURDATE(),p.fechacrea) else 0 end) as dias,
			ep.estadopostulante,
			p.telefonomovil,
			usur.nombrecompleto,
			concat(re.apellidopaterno, ' ', re.apellidomaterno, ' ', re.nombre) as promotor,
			est.estadocivil,
			p.curp,
			p.rfc,
			p.ine,
			p.fechanacimiento,
			p.sexo,
			p.refescolaridades,
			p.refestadocivil,
			p.nacionalidad,
			p.telefonocasa,
			p.telefonotrabajo,
			p.refestadopostulantes,
			p.urlprueba,
			p.fechamodi,
			p.usuariocrea,
			p.usuariomodi,
			p.refasesores,
			p.comision,
			p.refusuarios,
			p.refsucursalesinbursa

		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes and ep.idestadopostulante not in (9,11)
		left join dbasesores rr on rr.refusuarios = p.refusuarios ";
		if ($_SESSION['idroll_sahilices'] == 9) {
			$consulta .= 'left join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante
			left join dbusuarios usur on usur.idusuario = rrr.refusuarios
			inner join tbreferentes re on re.idreferente = p.refreferentes
			inner join dbusuarios usurf on usurf.idusuario = '.$_SESSION['usuaid_sahilices'].' and re.refusuarios =  usurf.idusuario ';
		} else {
			if ($_SESSION['idroll_sahilices'] == 3) {
				$consulta .= 'inner join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante and rrr.refusuarios = '.$_SESSION['usuaid_sahilices'].'
				inner join dbusuarios usur on usur.idusuario = rrr.refusuarios
				left join tbreferentes re on re.idreferente = p.refreferentes ';
				//$res = $serviciosReferencias->traerPostulantesPorGerente($_SESSION['usuaid_sahilices']);
			} else {
				$responsableComercial = $_GET['sSearch_0'];
				if ($responsableComercial == '') {
					//$res = $serviciosReferencias->traerPostulantes();
					$consulta .= 'left join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante
					left join dbusuarios usur on usur.idusuario = rrr.refusuarios
					left join tbreferentes re on re.idreferente = p.refreferentes';
				} else {
					//$res = $serviciosReferencias->traerPostulantesPorGerente($responsableComercial);
					$consulta .= 'inner join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante and rrr.refusuarios = '.$responsableComercial.'
					inner join dbusuarios usur on usur.idusuario = rrr.refusuarios
					left join tbreferentes re on re.idreferente = p.refreferentes ';
				}

			}
		}

		//die(var_dump($consulta));

		$datos = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta,$pre);

		$resAjax = $datos[0];
		$res = $datos[1];

		//die(var_dump());


		switch ($_SESSION['idroll_sahilices']) {
			case 1:
				$label = array('btnVer','btnModificar','btnEliminar','btnEliminarDefinitivo');
				$class = array('bg-blue','bg-amber','bg-red','bg-red');
				$icon = array('Ver','Modificar','Eliminar','Eliminar Def.');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 2:
				$label = array('btnVer','btnModificar');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Modificar');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 3:
				$label = array('btnVer','btnModificar');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Modificar');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 4:
				$label = array('btnVer','btnModificar');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Modificar');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 5:
				$label = array('btnVer','btnModificar');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Modificar');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 6:
				$label = array('btnVer','btnModificar');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Modificar');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 9:
				$label = array('btnVer');
				$class = array('bg-blue');
				$icon = array('Ver');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;

			default:
				// code...
				break;
		}


	break;
	case 'postulanteshistorico':


		$filtro = "where rr.idasesor is null and (p.nombre like '%_busqueda%' or p.apellidopaterno like '%_busqueda%' or p.apellidomaterno like '%_busqueda%' or p.email like '%_busqueda%' or p.telefonomovil like '%_busqueda%' or ep.estadopostulante like '%_busqueda%' or est.estadocivil like '%_busqueda%' or DATE_FORMAT( p.fechacrea, '%Y-%m-%d') like '%_busqueda%')";

		$pre = "where rr.idasesor is null";

		$consulta = "select
			p.idpostulante,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.codigopostal,
			p.fechacrea,
			(case when p.refestadopostulantes < 9 then DATEDIFF(CURDATE(),p.fechacrea) else 0 end) as dias,
			ep.estadopostulante,
			p.telefonomovil,
			usur.nombrecompleto,
			concat(re.apellidopaterno, ' ', re.apellidomaterno, ' ', re.nombre) as promotor,
			est.estadocivil,
			p.curp,
			p.rfc,
			p.ine,
			p.fechanacimiento,
			p.sexo,
			p.refescolaridades,
			p.refestadocivil,
			p.nacionalidad,
			p.telefonocasa,
			p.telefonotrabajo,
			p.refestadopostulantes,
			p.urlprueba,
			p.fechamodi,
			p.usuariocrea,
			p.usuariomodi,
			p.refasesores,
			p.comision,
			p.refusuarios,
			p.refsucursalesinbursa

		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes and ep.idestadopostulante in (9,11)
		left join dbasesores rr on rr.refusuarios = p.refusuarios ";
		if ($_SESSION['idroll_sahilices'] == 9) {
			$consulta .= 'left join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante
			left join dbusuarios usur on usur.idusuario = rrr.refusuarios
			inner join tbreferentes re on re.idreferente = p.refreferentes
			inner join dbusuarios usurf on usurf.idusuario = '.$_SESSION['usuaid_sahilices'].' and re.refusuarios =  usurf.idusuario ';
		} else {
			if ($_SESSION['idroll_sahilices'] == 3) {
				$consulta .= 'inner join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante and rrr.refusuarios = '.$_SESSION['usuaid_sahilices'].'
				inner join dbusuarios usur on usur.idusuario = rrr.refusuarios
				left join tbreferentes re on re.idreferente = p.refreferentes ';
				//$res = $serviciosReferencias->traerPostulantesPorGerente($_SESSION['usuaid_sahilices']);
			} else {
				$responsableComercial = $_GET['sSearch_0'];
				if ($responsableComercial == '') {
					//$res = $serviciosReferencias->traerPostulantes();
					$consulta .= 'left join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante
					left join dbusuarios usur on usur.idusuario = rrr.refusuarios
					left join tbreferentes re on re.idreferente = p.refreferentes';
				} else {
					//$res = $serviciosReferencias->traerPostulantesPorGerente($responsableComercial);
					$consulta .= 'inner join dbreclutadorasores rrr on rrr.refpostulantes = p.idpostulante and rrr.refusuarios = '.$responsableComercial.'
					inner join dbusuarios usur on usur.idusuario = rrr.refusuarios
					left join tbreferentes re on re.idreferente = p.refreferentes ';
				}

			}
		}

		//die(var_dump($consulta));

		$datos = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta,$pre);

		$resAjax = $datos[0];
		$res = $datos[1];

		//die(var_dump());


		switch ($_SESSION['idroll_sahilices']) {
			case 1:
				$label = array('btnVer','btnDocumentacion');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Documentaciones');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 2:
				$label = array('btnVer','btnDocumentacion');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Documentaciones');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 3:
				$label = array('btnVer','btnDocumentacion');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Documentaciones');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 4:
				$label = array('btnVer','btnDocumentacion');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Documentaciones');
				$indiceID = 0;
				$empieza = 1;
				$termina = 11;
			break;
			case 5:
				$label = array('btnVer','btnDocumentacion');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Documentaciones');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 6:
				$label = array('btnVer','btnDocumentacion');
				$class = array('bg-blue','bg-amber');
				$icon = array('Ver','Documentaciones');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;
			case 9:
				$label = array('btnVer');
				$class = array('bg-blue');
				$icon = array('Ver');
				$indiceID = 0;
				$empieza = 1;
				$termina = 10;
			break;

			default:
				// code...
				break;
		}


	break;
	case 'entrevistas':

		$id = $_GET['id'];
		$idestado = $_GET['idestado'];

		$resultado = $serviciosReferencias->traerPostulantesPorId($id);

		if ($busqueda == '') {
			$colSort = 'e.fechacrea';
			$colSortDir = 'desc';
		}

		$consulta = 'select
		e.identrevista,
		e.entrevistador,
		e.fecha,
		e.domicilio,
		coalesce( pp.codigo, e.codigopostal) as codigo,
		ep.estadopostulante,
		est.estadoentrevista,
		e.fechacrea,

		e.refestadopostulantes,
		e.refestadoentrevistas,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi,
		e.refpostulantes
		from dbentrevistas e
		inner join dbpostulantes pos ON e.refpostulantes = pos.idpostulante and pos.idpostulante = '.$id.'
		inner join tbestadopostulantes ep ON ep.idestadopostulante = e.refestadopostulantes
		left join tbentrevistasucursales et on et.identrevistasucursal = e.refentrevistasucursales
		left join postal pp on pp.id = et.refpostal
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas';

		if ($idestado == '') {
			$filtro = "where e.entrevistador like '%_busqueda%' or cast(e.fecha as unsigned) like '%_busqueda%' or e.domicilio like '%_busqueda%' or e.codigopostal like '%_busqueda%' or est.estadoentrevista like '%_busqueda%'";

			$datos = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta,'');

			$resAjax = $datos[0];
			$res = $datos[1];

			$termina = 7;
		} else {
			$filtro = "where e.refestadopostulantes = ".$idestado." and (e.entrevistador like '%_busqueda%' or cast(e.fecha as unsigned) like '%_busqueda%' or e.domicilio like '%_busqueda%' or e.codigopostal like '%_busqueda%' or est.estadoentrevista like '%_busqueda%')";

			$pre = " where e.refestadopostulantes = ".$idestado;
			//die(var_dump($filtro));

			$datos = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta,$pre);

			$resAjax = $datos[0];
			$res = $datos[1];

			$termina = 6;

		}



		switch ($_SESSION['idroll_sahilices']) {
			case 1:
				$label = array('btnModificar','btnEliminar');
				$class = array('bg-amber','bg-red');
				$icon = array('create','delete');
				$indiceID = 0;
				$empieza = 1;
			break;
			case 2:
				$label = array();
				$class = array();
				$icon = array();
				$indiceID = 0;
				$empieza = 1;
				$termina = 6;
			break;
			case 3:
				$label = array('btnModificar','btnEliminar');
				$class = array('bg-amber','bg-red');
				$icon = array('create','delete');
				$indiceID = 0;
				$empieza = 1;
			break;
			case 4:
				$label = array('btnModificar','btnEliminar');
				$class = array('bg-amber','bg-red');
				$icon = array('create','delete');
				$indiceID = 0;
				$empieza = 1;
			break;
			case 5:
				$label = array('btnModificar','btnEliminar');
				$class = array('bg-amber','bg-red');
				$icon = array('create','delete');
				$indiceID = 0;
				$empieza = 1;
			break;
			case 6:
				$label = array();
				$class = array();
				$icon = array();
				$indiceID = 0;
				$empieza = 1;
				$termina = 6;
			break;
			case 7:
				$label = array();
				$class = array();
				$icon = array();
				$termina = 6;
				$indiceID = 0;
				$empieza = 1;
			break;

			default:
				// code...
				break;
		}


		break;
	case 'referentes':
		$datos = $serviciosReferencias->traerReferentesajax($length, $start, $busqueda,$colSort,$colSortDir);
		$resAjax = $datos[0];
		$res = $datos[1];
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 6;

	break;
	case 'referentescomisiones':
		$resReferente = $serviciosReferencias->traerReferentesPorUsuario($_SESSION['usuaid_sahilices']);

		if (mysql_num_rows($resReferente) > 0) {
			$idreferente = mysql_result($resReferente,0,'idreferente');
		} else {
			$idreferente = 0;
		}

		$resAjax = $serviciosReferencias->traerComisionesReferentesajax($length, $start, $busqueda,$colSort,$colSortDir,$idreferente);
		$res = $serviciosReferencias->traerComisionesReferentes($idreferente);
		$label = array();
		$class = array();
		$icon = array();
		$indiceID = 0;
		$empieza = 1;
		$termina = 4;

	break;
	case 'oportunidades':

		$min = $_GET['start'];
		$max = $_GET['end'];
		$estado = $_GET['estado'];

		if ($_SESSION['idroll_sahilices'] == 3) {

			$datos = $serviciosReferencias->traerOportunidadesajaxPorUsuario($length, $start, $busqueda,$colSort,$colSortDir,$_SESSION['usuaid_sahilices'],$min,$max,$estado);

			$resAjax = $datos[0];
			$res = $datos[1];

			$label = array('btnModificar');
			$class = array('bg-amber');
			$icon = array('create');
		} else {
			if ($_SESSION['idroll_sahilices'] == 9) {
				$resReferentes 	= $serviciosReferencias->traerReferentesPorUsuario($_SESSION['usuaid_sahilices']);
				// traigo el recomendador o referente a traves del usuario para filtrar
				$datos = $serviciosReferencias->traerOportunidadesajaxPorRecomendador($length, $start, $busqueda,$colSort,$colSortDir, mysql_result($resReferentes,0,0),$min,$max,$estado);

				$resAjax = $datos[0];
				$res = $datos[1];

				$label = array('btnModificar','btnEliminar');
				$class = array('bg-amber','bg-red');
				$icon = array('create','delete');
			} else {
				$responsableComercial = $_GET['sSearch_0'];

				$datos = $serviciosReferencias->traerOportunidadesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max,$estado);

				$resAjax = $datos[0];
				$res = $datos[1];
				$label = array('btnModificar','btnEliminar');
				$class = array('bg-amber','bg-red');
				$icon = array('create','delete');
			}

		}

		$indiceID = 0;
		$empieza = 1;
		$termina = 11;

	break;
	case 'oportunidadeshistorico':

		$min = $_GET['start'];
		$max = $_GET['end'];
		$estado = $_GET['estado'];

		if ($_SESSION['idroll_sahilices'] == 3) {

			$datos = $serviciosReferencias->traerOportunidadesajaxPorUsuarioHistorico($length, $start, $busqueda,$colSort,$colSortDir,$_SESSION['usuaid_sahilices'],$min,$max,$estado);

			$resAjax = $datos[0];
			$res = $datos[1];

			$label = array();
			$class = array();
			$icon = array();
		} else {
			if ($_SESSION['idroll_sahilices'] == 9) {
				$resReferentes 	= $serviciosReferencias->traerReferentesPorUsuario($_SESSION['usuaid_sahilices']);
				// traigo el recomendador o referente a traves del usuario para filtrar
				$datos = $serviciosReferencias->traerOportunidadesajaxPorRecomendadorHistorico($length, $start, $busqueda,$colSort,$colSortDir,mysql_result($resReferentes,0,0),$min,$max,$estado);

				$resAjax = $datos[0];
				$res = $datos[1];

				$label = array();
				$class = array();
				$icon = array();
			} else {
				$responsableComercial = $_GET['sSearch_0'];
				$asigandos = $_GET['asigandos'];

				$datos = $serviciosReferencias->traerOportunidadesajaxPorHistorico($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max,$estado,$asigandos);

				$resAjax = $datos[0];
				$res = $datos[1];

				if ($_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 1) {
					$label = array('btnReasignar','btnModificar');
					$class = array('bg-deep-orange','bg-amber');
					$icon = array('cached','edit');
				} else {
					$label = array();
					$class = array();
					$icon = array();
				}

			}

		}


		$indiceID = 0;
		$empieza = 1;
		$termina = 9;
	break;
	case 'oportunidadespendientes':

		$min = $_GET['start'];
		$max = $_GET['end'];
		$estado = $_GET['estado'];;

		$responsableComercial = $_GET['sSearch_0'];
		$datos = $serviciosReferencias->traerOportunidadesajaxPorHistoricoJavelly($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max,$estado,0);

		$resAjax = $datos[0];
		$res = $datos[1];

		if ($_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 8) {
			$label = array('btnModificar');
			$class = array('bg-amber');
			$icon = array('edit');
		}

		$indiceID = 0;
		$empieza = 1;
		$termina = 9;
	break;
	case 'relaciones':
		$datos = $serviciosReferencias->traerReclutadorasoresajax($length, $start, $busqueda,$colSort,$colSortDir);

		$resAjax = $datos[0];
		$res = $datos[1];

		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');

		$indiceID = 0;
		$empieza = 1;
		$termina = 5;
	break;
	case 'entrevistaoportunidades':
		if ($_SESSION['idroll_sahilices'] == 3) {
			$datos = $serviciosReferencias->traerEntrevistaoportunidadesPorUsuarioajax($length, $start, $busqueda,$colSort,$colSortDir,$_SESSION['usuaid_sahilices']);

		} else {
			$datos = $serviciosReferencias->traerEntrevistaoportunidadesajax($length, $start, $busqueda,$colSort,$colSortDir);

		}

		$resAjax = $datos[0];
		$res = $datos[1];

		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 4;

		break;
	case 'entrevistasucursales':
		$datos = $serviciosReferencias->traerEntrevistasucursalesajax($length, $start, $busqueda,$colSort,$colSortDir);

		$resAjax = $datos[0];
		$res = $datos[1];

		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 6;

	break;
	case 'usuarios':

		//die(var_dump($_GET['sSearch_0']));

		$datos = $serviciosUsuarios->traerUsuariosajax($length, $start, $busqueda,$colSort,$colSortDir, $_GET['sSearch_0']);

		$resAjax = $datos[0];
		$res = $datos[1];

		$label = array('btnModificar','btnEliminar','btnInformacion');
		$class = array('bg-amber','bg-red','bg-teal');
		$icon = array('create','delete','add_a_photo');
		$indiceID = 0;
		$empieza = 1;
		$termina = 6;

	break;

	default:
		// code...
		break;
}


$cantidadFilas = mysql_num_rows($res);


header("content-type: Access-Control-Allow-Origin: *");

$ar = array();
$arAux = array();
$cad = '';
$id = 0;
	while ($row = mysql_fetch_array($resAjax)) {
		//$id = $row[$indiceID];
		// forma local utf8_decode
		for ($i=$empieza;$i<=$termina;$i++) {
			array_push($arAux, ($row[$i]));
		}

		if (($tabla == 'postulantes') || ($tabla == 'postulanteshistorico') || ($tabla == 'asesores') || ($tabla == 'asociadostemporales') || ($tabla == 'asociados') || ($tabla == 'clientes')) {
			array_push($arAux, armarAccionesDropDown($row[0],$label,$class,$icon));
		} else {
			array_push($arAux, armarAcciones($row[0],$label,$class,$icon));
		}


		array_push($ar, $arAux);

		$arAux = array();
		//die(var_dump($ar));
	}

$cad = substr($cad, 0, -1);

$data = '{ "sEcho" : '.$draw.', "iTotalRecords" : '.$cantidadFilas.', "iTotalDisplayRecords" : 10, "aaData" : ['.$cad.']}';

//echo "[".substr($cad,0,-1)."]";
echo json_encode(array(
			"draw"            => $draw,
			"recordsTotal"    => $cantidadFilas,
			"recordsFiltered" => $cantidadFilas,
			"data"            => $ar
		));

?>
