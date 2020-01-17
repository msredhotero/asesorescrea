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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../postulantes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Postulantes",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$id = $_GET['id'];
$iddocumentacion = $_GET['documentacion'];

if (($_SESSION['idroll_sahilices'] == 2) || ($_SESSION['idroll_sahilices'] == 6) || ($_SESSION['idroll_sahilices'] == 7)) {
	header('Location: documentacionii.php?id='.$id);
}

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Documentación I";

$plural = "Documentaciones I";

$eliminar = "eliminarPostulantes";

$insertar = "insertarPostulantes";

$modificar = "modificarPostulantes";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resultado 		= 	$serviciosReferencias->traerPostulantesPorId($id);

$postulante = mysql_result($resultado,0,'nombre').' '.mysql_result($resultado,0,'apellidopaterno').' '.mysql_result($resultado,0,'apellidomaterno');


$resGuia = $serviciosReferencias->traerGuiasPorEsquemaEspecial(mysql_result($resultado,0,'refesquemareclutamiento'));

$resEstadoSiguiente = $serviciosReferencias->traerGuiasPorEsquemaSiguiente(mysql_result($resultado,0,'refesquemareclutamiento'), mysql_result($resultado,0,'refestadopostulantes'));

if (mysql_num_rows($resEstadoSiguiente) > 0) {
	$estadoSiguiente = mysql_result($resEstadoSiguiente,0,'refestadopostulantes');
} else {
	$estadoSiguiente = 1;
}

$path  = '../../archivos/postulantes/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}

/**** son 13 documentaciones */
$pathCARATULA  = '../../archivos/postulantes/'.$id.'/caratula';

if (!file_exists($pathCARATULA)) {
	mkdir($pathCARATULA, 0777);
}

$filesCARATULA = array_diff(scandir($pathCARATULA), array('.', '..'));

/****************************************************************/

$pathSA  = '../../archivos/postulantes/'.$id.'/solicitud';

if (!file_exists($pathSA)) {
	mkdir($pathSA, 0777);
}

$filesSA = array_diff(scandir($pathSA), array('.', '..'));

/****************************************************************/

$pathFF  = '../../archivos/postulantes/'.$id.'/formatofirma';

if (!file_exists($pathFF)) {
	mkdir($pathFF, 0777);
}

$filesFF = array_diff(scandir($pathFF), array('.', '..'));

/****************************************************************/

$pathCC  = '../../archivos/postulantes/'.$id.'/consar';

if (!file_exists($pathCC)) {
	mkdir($pathCC, 0777);
}

$filesCC = array_diff(scandir($pathCC), array('.', '..'));

/****************************************************************/

$pathNLG  = '../../archivos/postulantes/'.$id.'/nolaborargobierno';

if (!file_exists($pathNLG)) {
	mkdir($pathNLG, 0777);
}

$filesNLG = array_diff(scandir($pathNLG), array('.', '..'));

/****************************************************************/

$pathCE  = '../../archivos/postulantes/'.$id.'/codigoetica';

if (!file_exists($pathCE)) {
	mkdir($pathCE, 0777);
}

$filesCE = array_diff(scandir($pathCE), array('.', '..'));

/****************************************************************/

$pathAP  = '../../archivos/postulantes/'.$id.'/aceptacionpoliticas';

if (!file_exists($pathAP)) {
	mkdir($pathAP, 0777);
}

$filesAP = array_diff(scandir($pathAP), array('.', '..'));

/****************************************************************/

$pathCCC  = '../../archivos/postulantes/'.$id.'/cuentaclave';

if (!file_exists($pathCCC)) {
	mkdir($pathCCC, 0777);
}

$filesCCC = array_diff(scandir($pathCCC), array('.', '..'));

/****************************************************************/

$pathB  = '../../archivos/postulantes/'.$id.'/banco';

if (!file_exists($pathB)) {
	mkdir($pathB, 0777);
}

$filesB = array_diff(scandir($pathB), array('.', '..'));

/****************************************************************/

$pathCF1  = '../../archivos/postulantes/'.$id.'/cf1';

if (!file_exists($pathCF1)) {
	mkdir($pathCF1, 0777);
}

$filesCF1 = array_diff(scandir($pathCF1), array('.', '..'));


/****************************************************************/

$pathCF2  = '../../archivos/postulantes/'.$id.'/cf2';

if (!file_exists($pathCF2)) {
	mkdir($pathCF2, 0777);
}

$filesCF2 = array_diff(scandir($pathCF2), array('.', '..'));

/****************************************************************/

$pathCF3  = '../../archivos/postulantes/'.$id.'/cf3';

if (!file_exists($pathCF3)) {
	mkdir($pathCF3, 0777);
}

$filesCF3 = array_diff(scandir($pathCF3), array('.', '..'));

/****************************************************************/

$pathC  = '../../archivos/postulantes/'.$id.'/compromiso';

if (!file_exists($pathC)) {
	mkdir($pathC, 0777);
}

$filesC = array_diff(scandir($pathC), array('.', '..'));

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacion($id, $iddocumentacion);

$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

$resPostulante = $serviciosReferencias->traerPostulantesPorId($id);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

$cantidadarchivos = mysql_result($resDocumentacion,0,'cantidadarchivos');

if ($cantidadarchivos == 0) {
	if (mysql_num_rows($resDocumentacionAsesor) > 0) {
		$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));

		$iddocumentacionasesores = mysql_result($resDocumentacionAsesor,0,'iddocumentacionasesor');

		$estadoDocumentacion = mysql_result($resDocumentacionAsesor,0,'estadodocumentacion');

		$color = mysql_result($resDocumentacionAsesor,0,'color');

		$span = '';
		switch (mysql_result($resDocumentacionAsesor,0,'estadodocumentacion')) {
			case 1:
				$span = 'text-info glyphicon glyphicon-plus-sign';
			break;
			case 2:
				$span = 'text-danger glyphicon glyphicon-remove-sign';
			break;
			case 3:
				$span = 'text-danger glyphicon glyphicon-remove-sign';
			break;
			case 4:
				$span = 'text-danger glyphicon glyphicon-remove-sign';
			break;
			case 5:
				$span = 'text-success glyphicon glyphicon-ok';
			break;
			case 6:
				$span = 'text-success glyphicon glyphicon-ok';
			break;
		}
	} else {
		$cadRefEstados = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

		$iddocumentacionasesores = 0;

		$estadoDocumentacion = 'Falta Cargar';

		$color = 'blue';

		$span = 'text-info glyphicon glyphicon-plus-sign';
	}
}

switch ($iddocumentacion) {
	case 13:
		// code...
		$dato = mysql_result($resPostulante,0,'folio');

		$archivo = '';
		$update = '';

		$input = '<input type="text" name="folio" maxlength="15" id="folio" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de FOLIO';
		$campo = 'folio';
	break;
	case 14:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
		$archivo = '';
		$update = 'solicitud';
	break;
	case 15:
		// code...
		$input = 'Descargue el archivo para completar';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnDescargar"><i class="material-icons">cloud_download</i><span>Descargar</span></button>';
		$leyenda = '';
		$archivo = 'formatofirma.pdf';
		$campo = 'Formato Firma';
		$update = '';
	break;
	case 16:
		// code...
		$input = 'Descargue el archivo para completar';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnDescargar"><i class="material-icons">cloud_download</i><span>Descargar</span></button>';
		$leyenda = '';
		$archivo = 'cartaaforeunificada.pdf';
		$campo = 'Carta CONSAR';
		$update = '';
	break;
	case 17:
		// code...
		$input = 'Descargue el archivo para completar';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnDescargar"><i class="material-icons">cloud_download</i><span>Descargar</span></button>';
		$leyenda = '';
		$archivo = 'nolaborarengorbierno.pdf';
		$campo = 'Carta no laborar en gobierno';
		$update = '';
	break;
	case 18:
		// code...
		$input = 'Descargue el archivo para completar';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnDescargar"><i class="material-icons">cloud_download</i><span>Descargar</span></button>';
		$leyenda = '';
		$archivo = 'codigoetica.pdf';
		$campo = 'Codigo de Etica';
		$update = '';
	break;
	case 19:
		// code...
		$input = 'Descargue el archivo para completar';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnDescargar"><i class="material-icons">cloud_download</i><span>Descargar</span></button>';
		$leyenda = '';
		$archivo = 'conocimientopoliticas.pdf';
		$campo = 'Carta de aceptación de políticas';
		$update = '';
	break;
	case 20:
		// code...
		$dato = mysql_result($resPostulante,0,'claveinterbancaria');

		$input = '<input type="text" name="claveinterbancaria" maxlength="18" id="claveinterbancaria" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue la Clave Interbancaria';
		$campo = 'claveinterbancaria';

		$archivo = 'cuentainterbancaria.pdf';
		$update = '';
	break;
	case 21:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$archivo = '';
		$campo = '';
		$update = '';
	break;
	case 22:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$archivo = '';
		$campo = '';
		$update = 'contratofirmado1';
	break;
	case 23:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$archivo = '';
		$campo = '';
		$update = 'contratofirmado2';
	break;
	case 24:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$archivo = '';
		$campo = '';
		$update = 'contratofirmado3';
	break;
	case 25:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$archivo = '';
		$campo = '';
		$update = '';
	break;

	default:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$archivo = '';
		$campo = '';
		$update = '';
	break;
}

$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionCompleta($id,$estadoSiguiente);

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<title><?php echo $tituloWeb; ?></title>
	<!-- Favicon-->
	<link rel="icon" href="../../favicon.ico" type="image/x-icon">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

	<?php echo $baseHTML->cargarArchivosCSS('../../'); ?>

	<link href="../../plugins/waitme/waitMe.css" rel="stylesheet" />
	<link href="../../plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">

	<!-- Bootstrap Material Datetime Picker Css -->
	<link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

	<!-- Dropzone Css -->
	<link href="../../plugins/dropzone/dropzone.css" rel="stylesheet">


	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

	<link rel="stylesheet" type="text/css" href="../../css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="../../css/classic.date.css"/>

	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		#codigopostal { width: 400px; }
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }

		  .thumbnail2 {
		    display: block;
		    padding: 4px;
		    margin-bottom: 20px;
		    line-height: 1.42857143;
		    background-color: #fff;
		    border: 1px solid #ddd;
		    border-radius: 4px;
		    -webkit-transition: border .2s ease-in-out;
		    -o-transition: border .2s ease-in-out;
		    transition: border .2s ease-in-out;
			 text-align: center;
		}
		.progress {
			background-color: #1b2646;
		}

		.btnDocumentacion {
			cursor: pointer;
		}

	</style>


</head>



<body class="theme-blue">

<!-- Page Loader -->
<div class="page-loader-wrapper">
	<div class="loader">
		<div class="preloader">
			<div class="spinner-layer pl-red">
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
<?php echo $baseHTML->cargarNAV($breadCumbs); ?>
<!-- #Top Bar -->
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../'); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix subirImagen">
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
						$urlAcceso = $rowG['url'].'?id='.$id;
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

			<div class="row">
				<?php
				while ($row = mysql_fetch_array($resDocumentaciones)) {
				?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="info-box-3 bg-<?php echo $row['color']; ?> hover-zoom-effect btnDocumentacion" id="<?php echo $row['iddocumentacion']; ?>">
							<div class="icon">
								<i class="material-icons">description</i>
							</div>
							<div class="content">
								<div class="text"><?php echo $row['documentacion']; ?></div>
								<div class="number"><?php echo $row['estadodocumentacion']; ?></div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								DOCUMENTACION - <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?>
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
									<ul class="dropdown-menu pull-right">

									</ul>
								</li>
							</ul>
						</div>
						<div class="body table-responsive">
							<button type="button" class="btn bg-green waves-effect btnVolver">
								<i class="material-icons">undo</i>
								<span>GUARDAR</span>
							</button>
							<form class="form" id="formCountry">

								<div class="row" style="padding: 5px 20px;">

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label"><?php echo $leyenda; ?></label>
										<?php echo $input; ?>
										<?php echo $boton; ?>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div> <!-- fin del card -->

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								ARCHIVO/S CARGADO/S
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
								</li>
							</ul>
						</div>
						<div class="body">
							<div class="row">
								<button type="button" class="btn bg-red waves-effect btnEliminar">
									<i class="material-icons">remove</i>
									<span>ELIMINAR</span>
								</button>
							</div>
							<div class="row">
								<?php for ($i=1;$i<=$cantidadarchivos;$i++) { ?>
								<div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
									<a href="javascript:void(0);" class="thumbnail timagen<?php echo $i; ?>">
										<img class="img-responsive">
									</a>
									<div id="example<?php echo $i; ?>"></div>
								</div>
							<?php } ?>
							</div>
							<div class="row">
								<?php
								while ($rowEstados = mysql_fetch_array($resDocumentacionAsesor)) {
									$resEstados = $serviciosReferencias->traerEstadodocumentaciones();
									$cadRefEstados = '';

									$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', $rowEstados['refestadodocumentaciones']);

									$iddocumentacionasesores = $rowEstados['iddocumentacionasesor'];

									$estadoDocumentacion = $rowEstados['estadodocumentacion'];

									$color = $rowEstados['color'];

									$span = '';
									switch ($rowEstados['estadodocumentacion']) {
										case 1:
											$span = 'text-info glyphicon glyphicon-plus-sign';
										break;
										case 2:
											$span = 'text-danger glyphicon glyphicon-remove-sign';
										break;
										case 3:
											$span = 'text-danger glyphicon glyphicon-remove-sign';
										break;
										case 4:
											$span = 'text-danger glyphicon glyphicon-remove-sign';
										break;
										case 5:
											$span = 'text-success glyphicon glyphicon-ok';
										break;
										case 6:
											$span = 'text-success glyphicon glyphicon-ok';
										break;
									}

								?>
								<div class="col-xs-6 col-md-4" style="display:block">
									<div class="alert bg-<?php echo $color; ?>">
										<h4>
											Estado: <b><?php echo $estadoDocumentacion; ?></b>
										</h4>
									</div>
					            <div class="col-xs-6 col-md-6" style="display:block">
										<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
										<div class="input-group col-md-12">
											<select class="form-control show-tick" id="refestados<?php echo $rowEstados['iddocumentacionasesor']; ?>" name="refestados">
												<?php echo $cadRefEstados; ?>
											</select>
										</div>
										<button type="button" id="<?php echo $rowEstados['iddocumentacionasesor']; ?>" class="btn btn-primary guardarEstado" style="margin-left:0px;">Guardar Estado</button>
									</div>
								</div>
								<?php } ?>
							</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								CARGA/MODIFIQUE LA DOCUMENTACIÓN <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?> AQUI
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
								</li>
							</ul>
						</div>
						<div class="body">
							<div class="row">
							<?php if ($cantidadarchivos > 1) { ?>
								<?php for ($i=1;$i<=$cantidadarchivos;$i++) { ?>

									<div class="col-xs-6 col-sm-4">
										<h5>Ingrese el archivo <?php echo $i; ?></h5>
										<form action="subirespecifico.php" id="frmFileUpload<?php echo $i; ?>" class="dropzone" method="post" enctype="multipart/form-data">
											<div class="dz-message">
												<div class="drag-icon-cph">
													<i class="material-icons">touch_app</i>
												</div>
												<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
											</div>
											<div class="fallback">
												<input name="file" type="file" id="archivos<?php echo $i; ?>" />
												<input type="hidden" id="idpostulante<?php echo $i; ?>" name="idpostulante" value="<?php echo $id; ?>" />
												<input type="hidden" id="nombrearchivo<?php echo $i; ?>" name="nombrearchivo" value="<?php echo $update.$i; ?>"/>
											</div>
										</form>
									</div>

								<?php } ?>
							<?php } else { ?>
								<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
									<div class="dz-message">
										<div class="drag-icon-cph">
											<i class="material-icons">touch_app</i>
										</div>
										<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
									</div>
									<div class="fallback">
										<input name="file" type="file" id="archivos" />
										<input type="hidden" id="idpostulante" name="idpostulante" value="<?php echo $id; ?>" />

									</div>
								</form>
							<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- ELIMINAR -->
	<form class="formulario" role="form" id="sign_in">
		<div class="modal fade" id="lgmEliminar" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
						<div class="modal-header">
							 <h4 class="modal-title" id="largeModalLabel">ELIMINAR <?php echo strtoupper($singular); ?></h4>
						</div>
						<div class="modal-body">
									 <p>¿Esta seguro que desea eliminar el registro?</p>
									 <small>* Si este registro esta relacionado con algun otro dato no se podría eliminar.</small>
						</div>
						<div class="modal-footer">
							 <button type="button" class="btn btn-danger waves-effect eliminar" data-dismiss="modal">ELIMINAR</button>
							 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>
				  </div>
			 </div>
		</div>
	</form>


<?php echo $baseHTML->cargarArchivosJS('../../'); ?>
<!-- Wait Me Plugin Js -->
<script src="../../plugins/waitme/waitMe.js"></script>

<!-- Custom Js -->
<script src="../../js/pages/cards/colored.js"></script>

<script src="../../plugins/jquery-validation/jquery.validate.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<!-- JQuery Steps Plugin Js -->
<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script>

	$(document).ready(function(){

		$('.btnDocumentacion').click(function() {
			idTable =  $(this).attr("id");
			url = "subirdocumentacionii.php?id=<?php echo $id; ?>&documentacion=" + idTable;
			$(location).attr('href',url);
		});

		$('.btnModificar').click(function() {
			modificarPostulanteUnicaDocumentacion($('#<?php echo $campo; ?>').val());
		});

		$('.btnDescargar').click(function() {
			window.open("../../contratos/<?php echo $archivo; ?>",'_blank');
		});

		$('.btnVolver').click(function() {
			url = "documentacionii.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});

		function modificarPostulanteUnicaDocumentacion(valor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarPostulanteUnicaDocumentacion',
					idpostulante: <?php echo $id; ?>,
					campo: '<?php echo strtolower($campo); ?>',
					valor: valor
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se guardo correctamente el <?php echo $campo; ?>', "success");

					} else {
						swal("Error!", data.leyenda, "warning");

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

		$('.guardarEstado').click(function() {
			idTable =  $(this).attr("id");
			modificarEstadoDocumentacionPostulante($('#refestados' + idTable).val(),idTable);
		});

		function modificarEstadoDocumentacionPostulante(idestado, id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionPostulante',
					iddocumentacionasesores: id,
					idestado: idestado
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.guardarEstado').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se modifico correctamente el estado de la documentación <?php echo $campo; ?>', "success");
						$('.guardarEstado').show();
						location.reload();
					} else {
						swal("Error!", data.leyenda, "warning");


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

		<?php if ($cantidadarchivos > 1) { ?>
		function traerImagenEspecifica(contenedorpdf, contenedor, archivo) {
			$.ajax({
				data:  {idpostulante: <?php echo $id; ?>,
						iddocumentacion: <?php echo $iddocumentacion; ?>,
						archivo: archivo,
						accion: 'traerDocumentacionPorPostulanteDocumentacionEspecifica'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("." + contenedor + " img").attr("src",'');
				},
				success:  function (response) {
					var cadena = response.datos.type.toLowerCase();

					if (response.datos.type != '') {
						if (cadena.indexOf("pdf") > -1) {
							PDFObject.embed(response.datos.imagen, "#"+contenedorpdf);
							$('#'+contenedorpdf).show();
							$("."+contenedor).hide();

						} else {
							$("." + contenedor + " img").attr("src",response.datos.imagen);
							$("."+contenedor).show();
							$('#'+contenedorpdf).hide();
						}
					}

					if (response.error) {
						$('.btnContinuar').hide();
						$('.btnEliminar').hide();
						$('.guardarEstado').hide();
					} else {
						$('.btnContinuar').show();
						$('.btnEliminar').show();
						$('.guardarEstado').show();
					}



				}
			});
		}

		<?php for ($i=1;$i<=$cantidadarchivos;$i++) { ?>
			traerImagenEspecifica('example<?php echo $i; ?>','timagen<?php echo $i; ?>','<?php echo $update.$i; ?>');
		<?php } ?>

		<?php } else { ?>
			function traerImagen(contenedorpdf, contenedor) {
				$.ajax({
					data:  {idpostulante: <?php echo $id; ?>,
							iddocumentacion: <?php echo $iddocumentacion; ?>,
							accion: 'traerDocumentacionPorPostulanteDocumentacion'},
					url:   '../../ajax/ajax.php',
					type:  'post',
					beforeSend: function () {
						$("." + contenedor + " img").attr("src",'');
					},
					success:  function (response) {
						var cadena = response.datos.type.toLowerCase();

						if (response.datos.type != '') {
							if (cadena.indexOf("pdf") > -1) {
								PDFObject.embed(response.datos.imagen, "#"+contenedorpdf);
								$('#'+contenedorpdf).show();
								$("."+contenedor).hide();

							} else {
								$("." + contenedor + " img").attr("src",response.datos.imagen);
								$("."+contenedor).show();
								$('#'+contenedorpdf).hide();
							}
						}

						if (response.error) {
							$('.btnContinuar').hide();
							$('.btnEliminar').hide();
							$('.guardarEstado').hide();
						} else {
							$('.btnContinuar').show();
							$('.btnEliminar').show();
							$('.guardarEstado').show();
						}



					}
				});
			}

			traerImagen('example1','timagen1');
		<?php } ?>

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		<?php if ($cantidadarchivos > 1) { ?>
			<?php for ($i=1;$i<=$cantidadarchivos;$i++) { ?>
			Dropzone.options.frmFileUpload<?php echo $i; ?> = {
				maxFilesize: 30,
				acceptedFiles: ".jpg,.jpeg,.pdf",
				accept: function(file, done) {
					done();
				},
				init: function() {
					this.on("sending", function(file, xhr, formData){
						formData.append("idpostulante", '<?php echo $id; ?>');
						formData.append("iddocumentacion", '<?php echo $iddocumentacion; ?>');
						formData.append("archivo", '<?php echo $update.$i; ?>');
					});
					this.on('success', function( file, resp ){
						traerImagenEspecifica('example<?php echo $i; ?>','timagen<?php echo $i; ?>','<?php echo $update.$i; ?>');
						$('.lblPlanilla').hide();
						swal("Correcto!", resp.replace("1", ""), "success");
						$('.btnGuardar').show();
						$('.infoPlanilla').hide();
						location.reload();
					});

					this.on('error', function( file, resp ){
						swal("Error!", resp.replace("1", ""), "warning");
					});
				}
			};



			var myDropzone = new Dropzone("#archivos<?php echo $i; ?>", {
				params: {
					 idpostulante: <?php echo $id; ?>,
					 iddocumentacion: <?php echo $iddocumentacion; ?>,
					 archivo: '<?php echo $update.$i; ?>'
				},
				url: 'subirespecifico.php'
			});
			<?php } ?>
		<?php } else { ?>
			Dropzone.options.frmFileUpload = {
				maxFilesize: 30,
				acceptedFiles: ".jpg,.jpeg,.pdf",
				accept: function(file, done) {
					done();
				},
				init: function() {
					this.on("sending", function(file, xhr, formData){
						formData.append("idpostulante", '<?php echo $id; ?>');
						formData.append("iddocumentacion", '<?php echo $iddocumentacion; ?>');
					});
					this.on('success', function( file, resp ){
						traerImagen('example1','timagen1');
						$('.lblPlanilla').hide();
						swal("Correcto!", resp.replace("1", ""), "success");
						$('.btnGuardar').show();
						$('.infoPlanilla').hide();
						location.reload();
					});

					this.on('error', function( file, resp ){
						swal("Error!", resp.replace("1", ""), "warning");
					});
				}
			};



			var myDropzone = new Dropzone("#archivos", {
				params: {
					 idpostulante: <?php echo $id; ?>,
					 iddocumentacion: <?php echo $iddocumentacion; ?>
				},
				url: 'subirespecifico.php'
			});

		<?php } ?>



		function setButtonWavesEffect(event) {
			$(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
			$(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
		}

		$('#wizard_horizontal').steps({
			headerTag: 'h2',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			onInit: function (event, currentIndex) {
				setButtonWavesEffect(event);
			}
		});



		function modificarEstadoPostulante(id, idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'modificarEstadoPostulante',id: id, idestado: idestado},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$(location).attr('href',data);

					} else {
						swal("Error!", 'Se genero un error al modificar el estado del postulante', "warning");

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

		$('.btnContinuar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, <?php echo $iddocumentacion; ?>);
		});

		$('.eliminar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarDocumentacionPostulante',idpostulante: <?php echo $id; ?>, iddocumentacion: <?php echo $iddocumentacion; ?>},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnEliminar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", data.leyenda , "success");
						traerImagen('example1','timagen1');

					} else {
						swal("Error!", data.leyenda, "warning");

						$('.btnEliminar').show();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		});


		$(".body").on("click",'.btnEliminar', function(){
			$('#lgmEliminar').modal();

		});


		$('.maximizar').click(function() {
			if ($('.icomarcos').text() == 'web') {
				$('#marcos').show();
				$('.content').css('marginLeft', '265px');
				$('.icomarcos').html('aspect_ratio');
			} else {
				$('#marcos').hide();
				$('.content').css('marginLeft', '15px');
				$('.icomarcos').html('web');
			}

		});


	});
</script>








</body>
<?php } ?>
</html>
