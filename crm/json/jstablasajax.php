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
	case 'solicitudes':
		if ($busqueda == '') {
			$colSort = 's.fechacrea';
			$colSortDir = 'desc';
		}

		$resAjax = $serviciosReferencias->traerSolicitudesajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerSolicitudes();
		$label = array('btnCliente','btnModificar','btnEliminar','btnPagar','btnContratos','btnAgregarPersonas');
		$class = array('bg-blue','bg-amber','bg-red','bg-green','bg-brown','bg-teal');
		$icon = array('Client','Modificar','Eliminar','Pagos','Contrats','Persones');
		$indiceID = 0;
		$empieza = 1;
		$termina = 8;

	break;
	case 'postulantes':
		if ($busqueda == '') {
			$colSort = 'p.fechacrea';
			$colSortDir = 'desc';
		}

		$filtro = "where p.nombre like '%_busqueda%' or p.apellidopaterno like '%_busqueda%' or p.apellidomaterno like '%_busqueda%' or p.email like '%_busqueda%' or p.telefonomovil like '%_busqueda%' or ep.estadopostulante like '%_busqueda%' or est.estadocivil like '%_busqueda%' or DATE_FORMAT( p.fechacrea, '%Y-%m-%d') like '%_busqueda%'";

		$consulta = 'select
			p.idpostulante,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.telefonomovil,
			p.codigopostal,
			p.fechacrea,
			ep.estadopostulante,
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
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes';

		$resAjax = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta);
		$res = $serviciosReferencias->traerPostulantes();
		$label = array('btnCliente','btnModificar','btnEliminar','btnPagar','btnContratos');
		$class = array('bg-blue','bg-amber','bg-red','bg-green','bg-brown');
		$icon = array('Ver','Modificar','Eliminar','Entrevistas','Archivos');
		$indiceID = 0;
		$empieza = 1;
		$termina = 8;

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
		e.codigopostal,
		est.estadoentrevista,
		e.fechacrea,
		e.refestadopostulantes,
		e.refestadoentrevistas,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi,
		e.refpostulantes
		from dbentrevistas e
		inner join dbpostulantes pos ON pos.idpostulante = '.$id.'
		inner join tbestadopostulantes ep ON ep.idestadopostulante = e.refestadopostulantes
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas';

		if ($idestado == '') {
			$filtro = "where e.entrevistador like '%_busqueda%' or cast(e.fecha as unsigned) like '%_busqueda%' or e.domicilio like '%_busqueda%' or e.codigopostal like '%_busqueda%' or est.estadoentrevista like '%_busqueda%'";

			$resAjax = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta);

			$res = $serviciosReferencias->traerEntrevistasPorPostulante($id);
		} else {
			$filtro = "where e.refestadopostulantes = ".$idestado." and (e.entrevistador like '%_busqueda%' or cast(e.fecha as unsigned) like '%_busqueda%' or e.domicilio like '%_busqueda%' or e.codigopostal like '%_busqueda%' or est.estadoentrevista like '%_busqueda%')";

			$pre = " where e.refestadopostulantes = ".$idestado;
			//die(var_dump($filtro));

			$resAjax = $serviciosReferencias->traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir,$filtro,$consulta,$pre);

			$res = $serviciosReferencias->traerEntrevistasPorEstadoPostulante(mysql_result($resultado,0,'refestadopostulantes'));
		}





		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 6;

		break;
	case 'locatarios':
		$resAjax = $serviciosReferencias->traerLocatariosajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerLocatarios();
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 6;

		break;
	case 'tipoubicacion':
		$resAjax = $serviciosReferencias->traerTipoubicacionajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerTipoubicacion();
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 1;

	break;
	case 'ubicaciones':
		$resAjax = $serviciosReferencias->traerUbicacionesajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerUbicaciones();
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 5;

	break;
	case 'tarifes':
		$resAjax = $serviciosReferencias->traerTarifasajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerTarifas();
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 4;

	break;
	case 'periodes':
		$resAjax = $serviciosReferencias->traerPeriodosajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosReferencias->traerPeriodos();
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
		$indiceID = 0;
		$empieza = 1;
		$termina = 4;

	break;
	case 'usuarios':
		$resAjax = $serviciosUsuarios->traerUsuariosajax($length, $start, $busqueda,$colSort,$colSortDir);
		$res = $serviciosUsuarios->traerUsuarios();
		$label = array('btnModificar','btnEliminar');
		$class = array('bg-amber','bg-red');
		$icon = array('create','delete');
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

		for ($i=$empieza;$i<=$termina;$i++) {
			array_push($arAux, utf8_encode($row[$i]));
		}

		if ($tabla == 'postulantes') {
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
