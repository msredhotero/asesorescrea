<?php

session_start();

if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../error.php');
} else {


include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/base.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Dashboard",$_SESSION['refroll_sahilices'],'');

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';


/////////////////////// Opciones para la creacion del formulario  /////////////////////

if ($_SESSION['idroll_sahilices'] == 7) {
	$resultado = $serviciosReferencias->traerPostulantesPorIdUsuario($_SESSION['usuaid_sahilices']);

	if (mysql_num_rows($resultado) > 0) {
		$refestado = mysql_result($resultado,0,'refestadopostulantes');
		$refesquemareclutamiento  = mysql_result($resultado,0,'refesquemareclutamiento');

		$resEstado = $serviciosReferencias->traerGuiasPorEsquemaSiguiente($refesquemareclutamiento, $refestado);

		//die(var_dump($refestado));

		if (mysql_num_rows($resEstado) > 0) {
			$estadoSiguiente = mysql_result($resEstado,0,'refestadopostulantes');
			$idestado = mysql_result($resEstado,0,'refestadopostulantes');
		} else {
			$estadoSiguiente = 8;
			$idestado = 8;
		}

		$resGuia = $serviciosReferencias->traerGuiasPorEsquemaEspecial(mysql_result($resultado,0,'refesquemareclutamiento'));



		$leyendaDocumentacion = '';
		switch ($idestado) {
			case 7:
				$leyendaDocumentacion = '<div class="alert bg-light-green"><i class="material-icons">warning</i> Ya tiene habilitado el sistema para cargar su documentación, ingrese <a style="color: white;" href="miperfil/index.php"><b>AQUI</b></a></div>';
				break;

		}
	} else {
		$leyendaDocumentacion = '';
		$refestado = 10;
		$resGuia = array();
	}

} else {

	if ($_SESSION['idroll_sahilices'] == 3) {
		$singular = "Entrev. Oportnidad";

		$plural = "Entrev. Oportnidades";

		$eliminar = "eliminarEntrevistaoportunidades";

		$insertar = "insertarEntrevistaoportunidades";

		$modificar = "modificarOportunidades";

		$tabla 			= "dbentrevistaoportunidades";

		$lblCambio	 	= array('refoportunidades','codigopostal','refestadoentrevistas');
		$lblreemplazo	= array('Nombre Completo','CP','Estado');

		$resOportunidad = $serviciosReferencias->traerOportunidadesPorUsuario($_SESSION['usuaid_sahilices']);
		$cadRef1 = $serviciosFunciones->devolverSelectBox($resOportunidad,array(1),'');

		$resEstado = $serviciosReferencias->traerEstadoentrevistasPorId(1);
		$cadRef2 = $serviciosFunciones->devolverSelectBox($resEstado,array(1),'');

		$refdescripcion = array(0 => $cadRef1,1 => $cadRef2);
		$refCampo 	=  array('refoportunidades','refestadoentrevistas');

		$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
	}
	//////////////////////// Fin opciones ////////////////////////////////////////////////

}

$resGrafico = $serviciosReferencias->graficoTotalFinalizados();
$ar = array();

$aceptado = '';
$rechazado = '';
$noatendido = '';
$nocontacto = '';
$asociado = '';
$totalPie1 = 0;

$aceptadoCant1 = 0;
$rechazadoCant1 = 0;
$noatendidoCant1 = 0;
$nocontactoCant1 = 0;
$asociadoCant1 = 0;
while ($rowG = mysql_fetch_array($resGrafico)) {
	$aceptado .= $rowG['aceptado'].",";
	$rechazado .= $rowG['rechazado'].",";
	$noatendido .= $rowG['noatendido'].",";
	$nocontacto .= $rowG['nocontacto'].",";
	$asociado .= $rowG['asociado'].",";

	$aceptadoCant1 += (integer)$rowG['aceptado'];
	$rechazadoCant1 += (integer)$rowG['rechazado'];
	$noatendidoCant1 += (integer)$rowG['noatendido'];
	$nocontactoCant1 += (integer)$rowG['nocontacto'];
	$asociadoCant1 += (integer)$rowG['asociado'];

	$totalPie1 = (integer)$rowG['aceptado'] + (integer)$rowG['rechazado'] + (integer)$rowG['noatendido'] + (integer)$rowG['nocontacto'] + (integer)$rowG['asociado'];
}


if (strlen($aceptado) > 0 ) {
	$aceptado = substr($aceptado,0,-1);
}

if (strlen($rechazado) > 0 ) {
	$rechazado = substr($rechazado,0,-1);
}

if (strlen($noatendido) > 0 ) {
	$noatendido = substr($noatendido,0,-1);
}

if (strlen($nocontacto) > 0 ) {
	$nocontacto = substr($nocontacto,0,-1);
}

if (strlen($asociado) > 0 ) {
	$asociado = substr($asociado,0,-1);
}

/***************************************************************/

$resGraficoA = $serviciosReferencias->graficoTotalActuales();

$nombresA = '';
$poratender = '';
$citaprogramada = '';
$mayor = 5;
while ($rowG = mysql_fetch_array($resGraficoA)) {
	$nombresA .= "'".$rowG['meses']."',";
	$poratender .= $rowG['poratender'].",";
	$citaprogramada .= $rowG['citaprogramada'].",";
	if ($mayor < $rowG['poratender']) {
		$mayor = $rowG['poratender'];
	}
	if ($mayor < $rowG['citaprogramada']) {
		$mayor = $rowG['citaprogramada'];
	}
}

if (strlen($nombresA) > 0 ) {
	$nombresA = substr($nombresA,0,-1);
}

if (strlen($poratender) > 0 ) {
	$poratender = substr($poratender,0,-1);
}

if (strlen($citaprogramada) > 0 ) {
	$citaprogramada = substr($citaprogramada,0,-1);
}

/***************************************************************/

$resGraficoM = $serviciosReferencias->graficoTotalMensual();
$ar = array();

$aceptadoM = '';
$rechazadoM = '';
$noatendidoM = '';
$nocontactoM = '';
$asociadoM = '';

$aceptadoCant2 = 0;
$rechazadoCant2 = 0;
$noatendidoCant2 = 0;
$nocontactoCant2 = 0;
$asociadoCant2 = 0;

$totalPie2 = 0;
while ($rowG = mysql_fetch_array($resGraficoM)) {
	$aceptadoM .= $rowG['aceptado'].",";
	$rechazadoM .= $rowG['rechazado'].",";
	$noatendidoM .= $rowG['noatendido'].",";
	$nocontactoM .= $rowG['nocontacto'].",";
	$asociadoM .= $rowG['asociado'].",";

	$aceptadoCant2 += (integer)$rowG['aceptado'];
	$rechazadoCant2 += (integer)$rowG['rechazado'];
	$noatendidoCant2 += (integer)$rowG['noatendido'];
	$nocontactoCant2 += (integer)$rowG['nocontacto'];
	$asociadoCant2 += (integer)$rowG['asociado'];

	$totalPie2 = (integer)$rowG['aceptado'] + (integer)$rowG['rechazado'] + (integer)$rowG['noatendido'] + (integer)$rowG['nocontacto'] + (integer)$rowG['asociado'];
}


if (strlen($aceptadoM) > 0 ) {
	$aceptadoM = substr($aceptadoM,0,-1);
}

if (strlen($rechazadoM) > 0 ) {
	$rechazadoM = substr($rechazadoM,0,-1);
}

if (strlen($noatendidoM) > 0 ) {
	$noatendidoM = substr($noatendidoM,0,-1);
}

if (strlen($nocontactoM) > 0 ) {
	$nocontactoM = substr($nocontactoM,0,-1);
}

if (strlen($asociadoM) > 0 ) {
	$asociadoM = substr($asociadoM,0,-1);
}

/*
$poratender = '144,0,0,0,0,0,0,0,0,0,0,0';
$citaprogramada = '67,0,0,0,0,0,0,0,0,0,0,0';
$mayor = 144;
*/
///////////////////////////              fin                   ////////////////////////
$resComparativo = $serviciosReferencias->graficoIndiceAceptacion();

$aceptadoC = '';
$rechazadoC = '';
$noatendidoC = '';
$nocontactoC = '';
$asociadoC = '';

$nombresC = '';
while ($rowG = mysql_fetch_array($resComparativo)) {
	$aceptadoC .= $rowG['aceptado'].",";
	$rechazadoC .= $rowG['rechazado'].",";
	$noatendidoC .= $rowG['noatendido'].",";
	$nocontactoC .= $rowG['nocontacto'].",";
	$asociadoC .= $rowG['asociado'].",";

	$nombresC .= "'".$rowG['nombrecompleto']."',";
}

if (strlen($nombresC) > 0 ) {
	$nombresC = substr($nombresC,0,-1);
}

if (strlen($aceptadoC) > 0 ) {
	$aceptadoC = substr($aceptadoC,0,-1);
}

if (strlen($rechazadoC) > 0 ) {
	$rechazadoC = substr($rechazadoC,0,-1);
}

if (strlen($noatendidoC) > 0 ) {
	$noatendidoC = substr($noatendidoC,0,-1);
}

if (strlen($nocontactoC) > 0 ) {
	$nocontactoC = substr($nocontactoC,0,-1);
}

if (strlen($asociadoC) > 0 ) {
	$asociadoC = substr($asociadoC,0,-1);
}

//////////////////////////////////////////////////////////////
// grafica de ventas anuales
$resVentasAnuales = $serviciosReferencias->graficosVentasAnuales();

$resVentasGerentes = $serviciosReferencias->graficoVentasPorGerentes();

////////////////////////////////////////////////////////////////////////

$resComparativo2 = $serviciosReferencias->graficoIndiceAceptacionMesual();

$aceptadoC2 = '';
$rechazadoC2 = '';
$noatendidoC2 = '';
$nocontactoC2 = '';
$asociadoC2 = '';
$iniciadoC2 = '';

$nombresC2 = '';
while ($rowG = mysql_fetch_array($resComparativo2)) {
	$aceptadoC2 .= $rowG['aceptado'].",";
	$rechazadoC2 .= $rowG['rechazado'].",";
	$noatendidoC2 .= $rowG['noatendido'].",";
	$nocontactoC2 .= $rowG['nocontacto'].",";
	$asociadoC2 .= $rowG['asociado'].",";
	$iniciadoC2 .= $rowG['iniciado'].",";

	$nombresC2 .= "'".$rowG['nombrecompleto']."',";
}

if (strlen($nombresC2) > 0 ) {
	$nombresC2 = substr($nombresC2,0,-1);
}

if (strlen($aceptadoC2) > 0 ) {
	$aceptadoC2 = substr($aceptadoC2,0,-1);
}

if (strlen($rechazadoC2) > 0 ) {
	$rechazadoC2 = substr($rechazadoC2,0,-1);
}

if (strlen($iniciadoC2) > 0 ) {
	$iniciadoC2 = substr($iniciadoC2,0,-1);
}

if (strlen($noatendidoC2) > 0 ) {
	$noatendidoC2 = substr($noatendidoC2,0,-1);
}

if (strlen($nocontactoC2) > 0 ) {
	$nocontactoC2 = substr($nocontactoC2,0,-1);
}

if (strlen($asociadoC2) > 0 ) {
	$asociadoC2 = substr($asociadoC2,0,-1);
}

//////////////////////////////////////////////////////////////

/********************* fin ********************************************/


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $tituloWeb; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <?php echo $baseHTML->cargarArchivosCSS('../'); ?>

	 <!-- CSS file -->
	<link rel="stylesheet" href="../css/easy-autocomplete.min.css">

	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../css/easy-autocomplete.themes.min.css">



	 <!-- Morris Chart Css-->
    <link href="../plugins/morrisjs/morris.css" rel="stylesheet" />

	 <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

	 <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />
	 <link href="../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

	 <link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

	<!-- CSS file -->
	<link rel="stylesheet" href="../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../css/easy-autocomplete.themes.min.css">

    <style>
        .alert > i{ vertical-align: middle !important; }

		  .modal-header-ver {
				padding:9px 15px;
				border-bottom:1px solid #eee;
				background-color: #0480be;
				color: white;
				font-weight: bold;
        }

			.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
			#codigopostal { width: 400px; }

			.progress {
				background-color: #1b2646;
			}

			.arriba { z-index:999999 !important; }
    </style>

</head>

<body class="theme-blue">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-blue">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Cargando...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input type="text" placeholder="Ingrese palabras...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <?php echo $baseHTML->cargarNAV($breadCumbs,'','','..'); ?>
    <!-- #Top Bar -->
    <?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], str_replace('..','../dashboard',$resMenu),'../'); ?>

    <section class="content" style="margin-top:-75px;">

		<div class="container-fluid">
			<!-- Widgets -->
			<div class="row clearfix">
				<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>


					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									BIENVENIDO
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<form class="form" id="formFacturas">
									<h3>Bienvenido al CRM de Asesores Crea</h3>
									<p>Aqui usted encontrara avisos importantes sobre su estado en el Proceso de Reclutamiento</p>

								</form>
							</div>
						</div>
				</div>

				<?php if (($_SESSION['idroll_sahilices'] == 8) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11)) { ?>
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									ASIGNACION TOTAL DE OPORTUNIDADES INDICE DE ACEPTACION
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<canvas id="pie_chart" height="150"></canvas>
								<div class="row clearfix">
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn btn-success btn-xs btn-block waves-effect" type="button">ACEPTADO <span class="badge"><?php echo $aceptadoCant1; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn bg-red btn-xs btn-block waves-effect" type="button">RECHAZADO <span class="badge"><?php echo $rechazadoCant1; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn bg-purple btn-xs btn-block waves-effect" type="button">NO ATENDIDO <span class="badge"><?php echo $noatendidoCant1; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn bg-orange btn-xs btn-block waves-effect" type="button">NO CONTACTADO <span class="badge"><?php echo $nocontactoCant1; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
										<button class="btn bg-yellow btn-xs btn-block waves-effect" type="button">AGENTE TEMPORAL <span class="badge"><?php echo $asociadoCant1; ?></span></button>
									</div>

								</div>
								<h4>Total Oportunidades: <?php echo $totalPie1; ?></h4>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									ASIGNACION TOTAL DE OPORTUNIDADES MENSUAL
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<canvas id="pie_chart2" height="150"></canvas>
								<div class="row clearfix">
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn btn-success btn-xs btn-block waves-effect" type="button">ACEPTADO <span class="badge"><?php echo $aceptadoCant2; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn bg-red btn-xs btn-block waves-effect" type="button">RECHAZADO <span class="badge"><?php echo $rechazadoCant2; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn bg-purple btn-xs btn-block waves-effect" type="button">NO ATENDIDO <span class="badge"><?php echo $noatendidoCant2; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<button class="btn bg-orange btn-xs btn-block waves-effect" type="button">NO CONTACTADO <span class="badge"><?php echo $nocontactoCant2; ?></span></button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-5 col-lg-5">
										<button class="btn bg-yellow btn-xs btn-block waves-effect" type="button">AGENTE TEMPORAL <span class="badge"><?php echo $asociadoCant2; ?></span></button>
									</div>

								</div>
								<h4>Total Oportunidades: <?php echo $totalPie2; ?></h4>
							</div>
						</div>
					</div>
				</div>
					<?php } ?>
					<?php if (($_SESSION['idroll_sahilices'] == 8) || ($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									ASIGNACION TOTAL DE OPORTUNIDADES COMPARATIVO
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<div class="row clearfix">
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn btn-success btn-xs btn-block waves-effect" type="button">ACEPTADO </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn bg-red btn-xs btn-block waves-effect" type="button">RECHAZADO</button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn bg-purple btn-xs btn-block waves-effect" type="button">NO ATENDIDO</button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<button class="btn bg-orange btn-xs btn-block waves-effect" type="button">NO CONTACTADO </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<button class="btn bg-yellow btn-xs btn-block waves-effect" type="button">AGENTE TEMPORAL </button>
									</div>
								</div>
								<canvas id="bar_chart2" height="150"></canvas>
							</div>
						</div>
					</div>
				</div>
					<?php } ?>

					<?php if (($_SESSION['idroll_sahilices'] == 8) || ($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									ASIGNACION TOTAL DE OPORTUNIDADES COMPARATIVO MENSUAL
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<div class="row clearfix">
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn bg-light-blue btn-xs btn-block waves-effect" type="button">INICIADO </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn btn-success btn-xs btn-block waves-effect" type="button">ACEPTADO </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn bg-red btn-xs btn-block waves-effect" type="button">RECHAZADO</button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-2 col-lg-2">
										<button class="btn bg-purple btn-xs btn-block waves-effect" type="button">NO ATENDIDO</button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<button class="btn bg-orange btn-xs btn-block waves-effect" type="button">NO CONTACTADO </button>
									</div>
									<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
										<button class="btn bg-yellow btn-xs btn-block waves-effect" type="button">AGENTE TEMPORAL </button>
									</div>
								</div>
								<canvas id="bar_chart3" height="150"></canvas>
							</div>
						</div>
					</div>
				</div>
					<?php } ?>

				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									VENTAS POR MES
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<canvas id="bar_line" height="250"></canvas>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									HISTORICO VENTAS
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<canvas id="bar_line2" height="250"></canvas>
								<div class="list-group">
									<?php
									$i=0;
									foreach ($resVentasGerentes['arGerente'] as $valor) {
									?>

									<a href="javascript:void(0);" class="list-group-item">
										<span class="badge bg-pink"><?php echo $resVentasGerentes['arPorcentajes'][$i]; ?> %</span> <?php echo $valor; ?>
									</a>
								<?php
									$i += 1;
									}
								?>
								</div>
							</div>
						</div>
					</div>
				</div>


			<?php } else { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2 style="color:#fff">
								BIENVENIDO
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
									<ul class="dropdown-menu pull-right">
										<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
									</ul>
								</li>
							</ul>
						</div>
						<div class="body table-responsive">
							<form class="form" id="formFacturas">
								<h3>Bienvenido al CRM de Asesores Crea</h3>
								<h4>Gracias por tu interés en unirte a nuestra fuerza de ventas, espera una llamada en breve para continuar con el proceso de reclutamiento.</h4>
								<p>Puedes contactarnos en el Tel fijo: <b><span style="color:#5DC1FD;">55 51 35 02 59</span></b></p>
								<p>Correo: <a href="mailto:reclutamiento@asesorescrea.com" style="color:#5DC1FD !important;"><b>reclutamiento@asesorescrea.com</b></a></p>
								<br>
								<p>Aqui usted encontrara avisos importantes sobre su estado en el Proceso de Reclutamiento</p>
								<?php echo $leyendaDocumentacion; ?>

								<?php
								if ($refestado == 10) {
								?>
								<div class="alert bg-light-green"><i class="material-icons">done_all</i> Su Proceso de Reclutamiento finalizo correctamente.</div>

							<?php }  else { ?>
								<?php if ($refestado == 9) { ?>
									<div class="alert bg-red"><i class="material-icons">remove</i> Su Proceso de Reclutamiento fue rechazado.</div>

								<?php }  else { ?>
									<div class="row">
										<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
											<?php
											$lblEstado = 'complete';
											$i = 0;
											while ($rowG = mysql_fetch_array($resGuia)) {
												$i += 1;

												if ($rowG['refestadopostulantes'] == $estadoSiguiente) {
													$lblEstado = 'active';
												}

												if (($lblEstado == 'complete') || ($lblEstado == 'active')) {
													$urlAcceso = 'javascript:void(0)';
												} else {
													$urlAcceso = 'javascript:void(0)';
												}
											?>
											<div class="col-xs-2 bs-wizard-step <?php echo $lblEstado; ?>">
												<div class="text-center bs-wizard-stepnum">Paso <?php echo $i; ?></div>
												<div class="progress">
													<div class="progress-bar"></div>
												</div>
												<a href="<?php echo $urlAcceso; ?>" class="bs-wizard-dot"></a>
												<div class="bs-wizard-info text-center"><?php echo $rowG['estadopostulante']; ?></div>
											</div>
											<?php
												if ($lblEstado == 'active') {
													$lblEstado = 'disabled';
												}
											}
											?>

										</div>
									</div>
								<?php } ?>
							<?php } ?>

							</form>
						</div>
					</div>
				</div>
			<?php } ?>
			</div>
		</div>


    </section>

	 <?php 	if ($_SESSION['idroll_sahilices'] == 3) { ?>
		 <!-- NUEVO -->
 			<form class="formulario frmNuevo" role="form" id="sign_in">
 			   <div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
 			       <div class="modal-dialog modal-lg" role="document">
 			           <div class="modal-content">
 			               <div class="modal-header">
 			                   <h4 class="modal-title" id="largeModalLabel">CREAR <?php echo strtoupper($singular); ?></h4>
 			               </div>
 			               <div class="modal-body">
 									<div class="row frmAjaxNuevo">


 									</div>
									<input type="hidden" class="codipostalaux" id="codipostalaux" name="codipostalaux" value="0"/>
 			               </div>
 			               <div class="modal-footer">
 			                   <button type="submit" class="btn btn-primary waves-effect nuevo">GUARDAR</button>
 			                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
 			               </div>
 			           </div>
 			       </div>
 			   </div>
 				<input type="hidden" id="accion" name="accion" value="<?php echo $insertar; ?>"/>
 			</form>

		<!-- MODIFICAR -->
			<form class="formulario" role="form" id="sign_in">
			   <div class="modal fade" id="lgmModificar" tabindex="-1" role="dialog">
			       <div class="modal-dialog modal-lg" role="document">
			           <div class="modal-content">
			               <div class="modal-header">
			                   <h4 class="modal-title" id="largeModalLabel">MODIFICAR OPORTUNIDAD</h4>
			               </div>
			               <div class="modal-body">
									<div class="row frmAjaxModificar">
									</div>
			               </div>
			               <div class="modal-footer">
			                   <button type="button" class="btn btn-warning waves-effect modificar">MODIFICAR</button>
			                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
			               </div>
			           </div>
			       </div>
			   </div>
				<input type="hidden" id="accion" name="accion" value="<?php echo $modificar; ?>"/>
			</form>



	 <?php }  ?>


    <?php echo $baseHTML->cargarArchivosJS('../'); ?>

	 <script src="../js/jquery.easy-autocomplete.min.js"></script>

	 <script src="../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

	 <!-- Bootstrap Material Datetime Picker Plugin Js -->
	 <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

	 <script src="../plugins/momentjs/moment.js"></script>
	 <script src="../js/moment-with-locales.js"></script>

	 <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

	 <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	 <script src="../js/datepicker-es.js"></script>

	 <script src="../js/dateFormat.js"></script>
	 <script src="../js/jquery.dateFormat.js"></script>

	 <script src="../js/jquery.easy-autocomplete.min.js"></script>

	 <!-- Chart Plugins Js -->
    <script src="../plugins/chartjs/Chart.bundle.js"></script>



	<script>
		$(document).ready(function(){
			<?php if (($_SESSION['idroll_sahilices'] == 8) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11)) { ?>
			new Chart(document.getElementById("pie_chart").getContext("2d"), getChartJs('pie'));
			new Chart(document.getElementById("pie_chart2").getContext("2d"), getChartJs('pie2'));

			new Chart(document.getElementById("bar_line").getContext("2d"), getChartJs('lineVentas'));
			new Chart(document.getElementById("bar_line2").getContext("2d"), getChartJs('lineVentasGerentes'));


			<?php if (($_SESSION['idroll_sahilices'] == 8) || ($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
			new Chart(document.getElementById("bar_chart2").getContext("2d"), getChartJs('bar2'));
			new Chart(document.getElementById("bar_chart3").getContext("2d"), getChartJs('bar4'));
			<?php } ?>

			function getChartJs(type) {
			    var config = null;

			    if (type === 'line') {
			        config = {
			            type: 'line',
			            data: {
			                labels: [<?php echo $nombresA; ?>],
			                datasets: [{
			                    label: "Por Atender",
			                    data: [<?php echo $poratender; ?>],
			                    borderColor: 'rgba(0, 188, 212, 0.75)',
			                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
			                    pointBorderColor: 'rgba(0, 188, 212, 0)',
			                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
			                    pointBorderWidth: 1
			                }, {
			                        label: "Cita Programada",
			                        data: [<?php echo $citaprogramada; ?>],
			                        borderColor: 'rgba(252, 248, 12, 0.75)',
			                        backgroundColor: 'rgba(252, 248, 12, 0.3)',
			                        pointBorderColor: 'rgba(252, 248, 12, 0)',
			                        pointBackgroundColor: 'rgba(252, 248, 12, 0.9)',
			                        pointBorderWidth: 1
			                    }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
				 else if (type === 'lineVentas') {
			        config = {
			            type: 'line',
			            data: {
			                labels: [<?php echo $resVentasAnuales['meses']; ?>],
			                datasets: [{
			                    label: "Por Atender",
			                    data: [<?php echo $resVentasAnuales['cantidad']; ?>],
			                    borderColor: 'rgba(0, 188, 212, 0.75)',
			                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
			                    pointBorderColor: 'rgba(0, 188, 212, 0)',
			                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
			                    pointBorderWidth: 1
			                }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
				 else if (type === 'lineVentasGerentes') {
			        config = {
			            type: 'bar',
			            data: {
			                labels: [<?php echo $resVentasGerentes['nombrecompleto']; ?>],
			                datasets: [{
			                    label: "Activos",
			                    data: [<?php echo $resVentasGerentes['activo']; ?>],
			                    borderColor: 'rgba(0, 188, 212, 0.75)',
			                    backgroundColor: 'rgba(0, 188, 212, 0.3)',
			                    pointBorderColor: 'rgba(0, 188, 212, 0)',
			                    pointBackgroundColor: 'rgba(0, 188, 212, 0.9)',
			                    pointBorderWidth: 1
			                }, {
		                        label: "Asesores",
		                        data: [<?php echo $resVentasGerentes['asesores']; ?>],
		                        borderColor: 'rgba(233, 30, 99, 0.75)',
		                        backgroundColor: 'rgba(233, 30, 99, 0.3)',
		                        pointBorderColor: 'rgba(233, 30, 99, 0)',
		                        pointBackgroundColor: 'rgba(233, 30, 99, 0.9)',
		                        pointBorderWidth: 1
		                    }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
			    else if (type === 'bar') {
			        config = {
			            type: 'bar',
			            data: {
			                labels: [<?php echo $nombresA; ?>],
			                datasets: [{
			                    label: "Por Atender",
			                    data: [<?php echo $poratender; ?>],
			                    backgroundColor: 'rgba(0, 188, 212, 0.8)'
			                }, {
			                        label: "Cita Programada",
			                        data: [<?php echo $citaprogramada; ?>],
			                        backgroundColor: 'rgba(252, 248, 12, 0.8)'
			                    }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
				 else if (type === 'bar2') {
			        config = {
			            type: 'bar',
			            data: {
			                labels: [<?php echo $nombresC; ?>],
			                datasets: [{
			                    label: "Aceptados",
			                    data: [<?php echo $aceptadoC; ?>],
			                    backgroundColor: 'rgba(12, 241, 8, 0.8)'
			                }, {
			                        label: "Rechazados",
			                        data: [<?php echo $rechazadoC; ?>],
			                        backgroundColor: 'rgba(252, 12, 12, 0.8)'
			                    }, {
	 			                        label: "No Atendido",
	 			                        data: [<?php echo $noatendidoC; ?>],
	 			                        backgroundColor: 'rgba(138, 17, 222, 0.8)'
	 			                    }, {
		 			                        label: "No Contactado",
		 			                        data: [<?php echo $noatendidoC; ?>],
		 			                        backgroundColor: 'rgba(252, 142, 25, 0.8)'
		 			                    }, {
			 			                        label: "Agente Temporal",
			 			                        data: [<?php echo $asociadoC; ?>],
			 			                        backgroundColor: 'rgba(244, 250, 26, 0.8)'
			 			                    }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
				 else if (type === 'bar4') {
			        config = {
			            type: 'bar',
			            data: {
			                labels: [<?php echo $nombresC2; ?>],
			                datasets: [{
			                    label: "Aceptados",
			                    data: [<?php echo $aceptadoC2; ?>],
			                    backgroundColor: 'rgba(12, 241, 8, 0.8)'
			                }, {
			                        label: "Rechazados",
			                        data: [<?php echo $rechazadoC2; ?>],
			                        backgroundColor: 'rgba(252, 12, 12, 0.8)'
			                    }, {
	 			                        label: "Iniciado",
	 			                        data: [<?php echo $iniciadoC2; ?>],
	 			                        backgroundColor: 'rgba(62, 204, 246, 0.8)'
	 			                    }, {
		 			                        label: "No Atendido",
		 			                        data: [<?php echo $noatendidoC2; ?>],
		 			                        backgroundColor: 'rgba(138, 17, 222, 0.8)'
		 			                    }, {
			 			                        label: "No Contactado",
			 			                        data: [<?php echo $noatendidoC2; ?>],
			 			                        backgroundColor: 'rgba(252, 142, 25, 0.8)'
			 			                    }, {
				 			                        label: "Agente Temporal",
				 			                        data: [<?php echo $asociadoC2; ?>],
				 			                        backgroundColor: 'rgba(244, 250, 26, 0.8)'
				 			                    }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
			    else if (type === 'radar') {
			        config = {
			            type: 'radar',
			            data: {
			                labels: [<?php echo ''; ?>],
			                datasets: [{
			                    label: "Aceptados",
			                    data: [<?php echo $aceptado; ?>],
			                    borderColor: 'rgba(12, 241, 8, 0.8)',
			                    backgroundColor: 'rgba(12, 241, 8, 0.5)',
			                    pointBorderColor: 'rgba(12, 241, 8, 0)',
			                    pointBackgroundColor: 'rgba(12, 241, 8, 0.8)',
			                    pointBorderWidth: 1
			                }, {
			                        label: "Rechazados",
			                        data: [<?php echo $rechazado; ?>],
			                        borderColor: 'rgba(252, 12, 12, 0.8)',
			                        backgroundColor: 'rgba(252, 12, 12, 0.5)',
			                        pointBorderColor: 'rgba(252, 12, 12, 0)',
			                        pointBackgroundColor: 'rgba(252, 12, 12, 0.8)',
			                        pointBorderWidth: 1
			                    }]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
			    else if (type === 'pie2') {
			        config = {
			            type: 'pie',
			            data: {
			                datasets: [{
			                    data: [<?php echo $aceptadoM; ?>,<?php echo $rechazadoM; ?>,<?php echo $noatendidoM; ?>,<?php echo $nocontactoM; ?>,<?php echo $asociadoM; ?>],
			                    backgroundColor: [
			                        "rgb(12, 241, 8)",
			                        "rgb(252, 12, 12)",
			                        "rgb(138, 17, 222)",
			                        "rgb(252, 142, 25)",
			                        "rgb(244, 250, 26)"
			                    ],
			                }],
			                labels: [
			                    "Aceptados",
			                    "Rechazados",
			                    "No Atendido",
			                    "No Contacto",
			                    "Asociado Temporal"
			                ]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
				 else if (type === 'pie') {
			        config = {
			            type: 'pie',
			            data: {
			                datasets: [{
			                    data: [<?php echo $aceptado; ?>,<?php echo $rechazado; ?>,<?php echo $noatendido; ?>,<?php echo $nocontacto; ?>,<?php echo $asociado; ?>],
			                    backgroundColor: [
										  "rgb(12, 241, 8)",
										  "rgb(252, 12, 12)",
										  "rgb(138, 17, 222)",
										  "rgb(252, 142, 25)",
										  "rgb(244, 250, 26)"
			                    ],
			                }],
			                labels: [
			                    "Aceptados",
			                    "Rechazados",
			                    "No Atendido",
			                    "No Contacto",
			                    "Asociado Temporal"
			                ]
			            },
			            options: {
			                responsive: true,
			                legend: false
			            }
			        }
			    }
			    return config;
			}
			<?php } ?>

			<?php 	if ($_SESSION['idroll_sahilices'] == 3) { ?>


				$('.frmNuevo').submit(function(e){

					e.preventDefault();
					if ($('#sign_in')[0].checkValidity()) {
						//información del formulario
						var formData = new FormData($(".formulario")[0]);
						var message = "";
						//hacemos la petición ajax
						$.ajax({
							url: '../ajax/ajax.php',
							type: 'POST',
							// Form data
							//datos del formulario
							data: formData,
							//necesario para subir archivos via ajax
							cache: false,
							contentType: false,
							processData: false,
							//mientras enviamos el archivo
							beforeSend: function(){

							},
							//una vez finalizado correctamente
							success: function(data){

								if (data == '') {
									swal({
											title: "Respuesta",
											text: "Registro Creado con exito!!",
											type: "success",
											timer: 1500,
											showConfirmButton: false
									});

									$('#lgmNuevo').modal('hide');

									location.reload();
								} else {
									swal({
											title: "Respuesta",
											text: data,
											type: "error",
											timer: 2500,
											showConfirmButton: false
									});


								}
							},
							//si ha ocurrido un error
							error: function(){
								$(".alert").html('<strong>Error!</strong> Actualice la pagina');
								$("#load").html('');
							}
						});
					}
				});

				function frmAjaxNuevo(id, tabla) {
					$.ajax({
						url: '../ajax/ajax.php',
						type: 'POST',
						// Form data
						//datos del formulario
						data: {accion: 'frmAjaxNuevo',tabla: tabla, id: id},
						//mientras enviamos el archivo
						beforeSend: function(){

							$('.frmAjaxNuevo').html('');

						},
						//una vez finalizado correctamente
						success: function(data){

							if (data != '') {
								$('.frmAjaxNuevo').html(data.formulario);

								$('#fecha').bootstrapMaterialDatePicker({
									format: 'YYYY/MM/DD HH:mm',
									lang : 'mx',
									clearButton: true,
									weekStart: 1,
									time: true,
									minDate : new Date()
								});

								$(".frmAjaxNuevo #entrevistador").val('<?php echo $_SESSION['nombre_sahilices']; ?>');

								$('.frmAjaxNuevo #codipostalaux').val(547);
								$('.frmAjaxNuevo #codipostalaux').val(547);
								$('.frmAjaxNuevo #codigopostal').val(547);
								$('.frmAjaxNuevo #domicilio').val('javelly');

								$(".frmAjaxNuevo #codigopostal").easyAutocomplete(options);

								$('.frmAjaxNuevo #usuariocrea').val('marcos');
								$('.frmAjaxNuevo #usuariomodi').val('marcos');

							} else {
								swal("Error!", data, "warning");

								$("#load").html('');
							}
						},
						//si ha ocurrido un error
						error: function(){
							$(".alert").html('<strong>Error!</strong> Actualice la pagina');
							$("#load").html('');
						}
					});

				}


				function frmAjaxModificar(id) {
					$.ajax({
						url: '../ajax/ajax.php',
						type: 'POST',
						// Form data
						//datos del formulario
						data: {accion: 'frmAjaxModificar',tabla: 'dboportunidades', id: id},
						//mientras enviamos el archivo
						beforeSend: function(){
							$('.frmAjaxModificar').html('');
						},
						//una vez finalizado correctamente
						success: function(data){

							if (data != '') {
								$('.frmAjaxModificar').html(data);
							} else {
								swal("Error!", data, "warning");

								$("#load").html('');
							}
						},
						//si ha ocurrido un error
						error: function(){
							$(".alert").html('<strong>Error!</strong> Actualice la pagina');
							$("#load").html('');
						}
					});

				}


				$("#example").on("click",'.btnModificar', function(){
					idTable =  $(this).attr("id");
					frmAjaxModificar(idTable);
					$('#lgmModificar').modal();
				});//fin del boton modificar


				$('.modificar').click(function(){

					//información del formulario
					var formData = new FormData($(".formulario")[1]);
					var message = "";
					//hacemos la petición ajax
					$.ajax({
						url: '../ajax/ajax.php',
						type: 'POST',
						// Form data
						//datos del formulario
						data: formData,
						//necesario para subir archivos via ajax
						cache: false,
						contentType: false,
						processData: false,
						//mientras enviamos el archivo
						beforeSend: function(){

						},
						//una vez finalizado correctamente
						success: function(data){

							if (data == '') {
								swal({
										title: "Respuesta",
										text: "Registro Modificado con exito!!",
										type: "success",
										timer: 1500,
										showConfirmButton: false
								});

								$('#lgmModificar').modal('hide');
								table.ajax.reload();
							} else {
								swal({
										title: "Respuesta",
										text: data,
										type: "error",
										timer: 2500,
										showConfirmButton: false
								});


							}
						},
						//si ha ocurrido un error
						error: function(){
							$(".alert").html('<strong>Error!</strong> Actualice la pagina');
							$("#load").html('');
						}
					});
				});

				var options = {

					url: "../json/jsbuscarpostal.php",

					getValue: function(element) {
						return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
					},

					ajaxSettings: {
						dataType: "json",
						method: "POST",
						data: {
							busqueda: $("#codigopostal").val()
						}
					},

					preparePostData: function (data) {
						data.busqueda = $("#codigopostal").val();
						return data;
					},

					list: {
						maxNumberOfElements: 20,
						match: {
							enabled: true
						},
						onClickEvent: function() {
							var id = $("#codigopostal").getSelectedItemData().id;
							var value = $("#codigopostal").getSelectedItemData().codigo;
							$(".codipostalaux").val(id);
							$("#codigopostal").val(value);

						}
					}
				};




				traerEntrevistasucursalesPorId(0,'new');


				$(".frmAjaxNuevo").on("change",'#refentrevistasucursales', function(){

					traerEntrevistasucursalesPorId($(this).val(), 'new');

				});

				function traerEntrevistasucursalesPorId(id, contenedor) {
					$.ajax({
						url: '../ajax/ajax.php',
						type: 'POST',
						// Form data
						//datos del formulario
						data: {accion: 'traerEntrevistaoportunidadesPorId',id: id},
						//mientras enviamos el archivo
						beforeSend: function(){

						},
						//una vez finalizado correctamente
						success: function(data){

							if (data != '') {
								if (contenedor == 'new') {
									$('.frmAjaxNuevo #domicilio').val(data.domicilio);
									$('.frmAjaxNuevo .codigopostalaux').val(data.refpostal);
									$('.frmAjaxNuevo #codigopostal').val(data.codigopostal);

								}

							} else {
								swal("Error!", 'Se genero un error al traer datos', "warning");

								$("#load").html('');
							}
						},
						//si ha ocurrido un error
						error: function(){
							$(".alert").html('<strong>Error!</strong> Actualice la pagina');
							$("#load").html('');
						}
					});
				}

				$("#example").on("click",'.btnEntrevista', function(){

					var tabla =  'dbentrevistaoportunidades';
					var id = $(this).attr("id");
					$('.tituloNuevo').html('Entrevista');
					$('#accion').html('insertarEntrevistaoportunidades');
					$('#lgmNuevo').modal();
					frmAjaxNuevo(id, tabla);

				});//fin del boton nuevo planata

				var table = $('#example').DataTable({
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "../json/jstablasajax.php?tabla=oportunidades",
					"language": {
						"emptyTable":     "No hay datos cargados",
						"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
						"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
						"infoFiltered":   "(filtrados del total de _MAX_ filas)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Mostrar _MENU_ filas",
						"loadingRecords": "Cargando...",
						"processing":     "Procesando...",
						"search":         "Buscar:",
						"zeroRecords":    "No se encontraron resultados",
						"paginate": {
							"first":      "Primero",
							"last":       "Ultimo",
							"next":       "Siguiente",
							"previous":   "Anterior"
						},
						"aria": {
							"sortAscending":  ": activate to sort column ascending",
							"sortDescending": ": activate to sort column descending"
						}
					}
				});

				var table2 = $('#example2').DataTable({
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": "../json/jstablasajax.php?tabla=oportunidadeshistorico",
					"language": {
						"emptyTable":     "No hay datos cargados",
						"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
						"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
						"infoFiltered":   "(filtrados del total de _MAX_ filas)",
						"infoPostFix":    "",
						"thousands":      ",",
						"lengthMenu":     "Mostrar _MENU_ filas",
						"loadingRecords": "Cargando...",
						"processing":     "Procesando...",
						"search":         "Buscar:",
						"zeroRecords":    "No se encontraron resultados",
						"paginate": {
							"first":      "Primero",
							"last":       "Ultimo",
							"next":       "Siguiente",
							"previous":   "Anterior"
						},
						"aria": {
							"sortAscending":  ": activate to sort column ascending",
							"sortDescending": ": activate to sort column descending"
						}
					}
				});

				$('.contHistorico').hide();

				$('.btnHistorico').click(function() {
					$('.contHistorico').show();
					$('.contActuales').hide();
				});

				$('.btnVigente').click(function() {
					$('.contActuales').show();
					$('.contHistorico').hide();
				});
			<?php
				}
			?>




		});
	</script>



</body>
<?php } ?>
</html>
