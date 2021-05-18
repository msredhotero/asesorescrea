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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../mesacontrol/');
//*** FIN  ****/

$fecha = date('Y-m-d');

if ($_SESSION['idroll_sahilices'] == 10) {
	$idusuario = $_SESSION['usuaid_sahilices'];
	$resultado 		= 	$serviciosReferencias->traerCotizacionesPorUsuario($idusuario);
} else {
	$id = $_GET['id'];
	$resultado 		= 	$serviciosReferencias->traerCotizacionesPorId($id);
}


//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Mesa de Control",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$resProducto = $serviciosReferencias->traerProductosPorId(mysql_result($resultado,0,'refproductos'));

$refdoctipo = mysql_result($resProducto,0,'reftipodocumentaciones');

$id = mysql_result($resultado,0,'idcotizacion');

$idasesor  = mysql_result($resultado,0,'refasesores');

$refDoc = '3,'.$refdoctipo;

//die(var_dump($refDoc));

$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacionE($id, $refDoc);
$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacionE($id,$refDoc);


if (!(isset($_GET['documentacion']))) {
	if (mysql_num_rows($resDocumentacionesAux)>0) {
		$iddocumentacion = mysql_result($resDocumentacionesAux,0,'iddocumentacion');
	} else {
		$iddocumentacion = 0;
	}

} else {
	$iddocumentacion = $_GET['documentacion'];
}


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Documentación I";

$plural = "Documentaciones I";

$eliminar = "eliminarCotizaciones";

$insertar = "insertarCotizaciones";

$modificar = "modificarCotizaciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////

$resCliente = $serviciosReferencias->traerClientesPorId(mysql_result($resultado,0,'refclientes'));

$cliente = mysql_result($resCliente,0,'nombre').' '.mysql_result($resCliente,0,'apellidopaterno').' '.mysql_result($resCliente,0,'apellidomaterno');


$path  = '../../archivos/cotizaciones/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}


//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacion($id, $iddocumentacion);

$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

if (mysql_num_rows($resDocumentacionAsesor) > 0) {

	$lblNombreDocumentacion = mysql_result($resDocumentacion,0,'documentacion');

	$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));

	$iddocumentacionasociado = mysql_result($resDocumentacionAsesor,0,'iddocumentacioncotizacion');

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
			$span = 'text-success glyphicon glyphicon-remove-sign';
		break;
	}

	$idestadodocumentacion = mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones');
} else {
	$lblNombreDocumentacion = '';

	$cadRefEstados = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

	$iddocumentacionasociado = 0;

	$estadoDocumentacion = 'Falta Cargar';

	$color = 'blue';

	$span = 'text-info glyphicon glyphicon-plus-sign';

	$idestadodocumentacion = 1;
}

switch (mysql_result($resDocumentacion,0,'documentacion')) {
	case 'Orden de trabajo22':
		// code...
		$dato = mysql_result($resultado,0,'ot');

		$input = '<input type="text" name="ot" maxlength="13" id="ot" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue la Orden de Trabajo';
		$campo = 'ot';
	break;
	case 36:
		// code...
		$dato = mysql_result($resultado,0,'nrorecibo');

		$input = '<input type="text" name="nrorecibo" maxlength="20" id="nrorecibo" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de Recibo';
		$campo = 'nrorecibo';
	break;


	default:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
}

$puedeCargarDocumentacion = 0;

if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 7)) {
	$puedeCargarDocumentacion = 1;
}


$resCobranza = $serviciosReferencias->traerDirectorioasesoresPorAsesorNecesariosArea($idasesor,4);

if (mysql_num_rows($resCobranza)>0) {
	$existeCobranzaPerfil = 1;

} else {
	$existeCobranzaPerfil = 0;

}

$resCobranzaCargada = $serviciosReferencias->traerCotizacionesdirectorioPorCotizacionArea($id,4);
if (mysql_num_rows($resCobranzaCargada)>0) {
	$puedeSeguirAux = 1;
} else {
	$puedeSeguirAux = 0;
}
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

	<!--<link rel="stylesheet" href="../../css/touch_multiselect.css">-->
	<link href="../../plugins/multi-select/css/multi-select.css" rel="stylesheet">

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		#codigopostal { width: 400px; }
		.pdfobject-container { height: 50rem; border: 1rem solid rgba(0,0,0,.1); }

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

		.btnDocumentacion, .btnAbandonada {
			cursor: pointer;
		}

		.cssActive {
			border: 3px solid #ffd900 !important;
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

			<div class="row">
				<?php
				$activaLbl = '';
				$puedeEnviar = 0;
				$archivosObligatorios = 0;
				$archivosCargadosObligatorios = 0;
				$lblObligatorio = '';
				while ($row = mysql_fetch_array($resDocumentaciones)) {



					if ($row['iddocumentacion'] == $iddocumentacion) {
						$activaLbl = ' cssActive ';
					} else {
						$activaLbl = '';
					}
					if ($row['archivo'] != '') {
						$puedeEnviar = 1;
					}

					//3=aceptadas , 4=Entregadas, 5=emision, 6=mesa de control
					$cambiaObligatoriedad = $serviciosReferencias->existeDocumentacionprocesosPorDocumentacionesProceso($row['iddocumentacion'],3);

					if (($row['obligatoria'] == '1') || $cambiaObligatoriedad==1) {
						$archivosObligatorios += 1;
						$lblObligatorio = ' <span style="color:red;">(*)</span>';
					} else {
						$lblObligatorio = '';
					}

					if (($row['archivo'] != '') && ($row['obligatoria'] == '1')) {
						$archivosCargadosObligatorios += 1;
					}
				?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="info-box-3 bg-<?php echo $row['color'].$activaLbl; ?> hover-zoom-effect btnDocumentacion" id="<?php echo $row['iddocumentacion']; ?>">
							<div class="icon">
								<i class="material-icons">face</i>
							</div>
							<div class="content">
								<div class="text"><?php echo $row['documentacion'].$lblObligatorio; ?></div>
								<div class="number"><?php echo $row['estadodocumentacion']; ?></div>
							</div>
						</div>
					</div>
				<?php }  ?>
				<?php if (($archivosCargadosObligatorios == $archivosObligatorios) && (($existeCobranzaPerfil==0) || ($existeCobranzaPerfil==1 && $puedeSeguirAux==1))) { ?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="info-box-3 bg-green hover-zoom-effect btnAceptarMesaDeControl">
							<div class="icon">
								<i class="material-icons">done_all</i>
							</div>
							<div class="content">
								<div class="text">Finalizar Proceso</div>
								<div class="number">FINALIZAR</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="row" style="margin-bottom:20px !important;">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button type="button" class="btn btn-info waves-effect btnVolverFiltro" data-ir="modificar" data-referencia="<?php echo $id; ?>"><i class="material-icons">reply</i><span>VOLVER</span></button>
					<button type="button" class="btn btn-success waves-effect btnCobranzaModal"><i class="material-icons">account_balance</i><span>SELECCIONE LOS PERFILES DE COBRANZA</span></button>
				</div>
			</div>



			<div class="row">
				<?php if ($puedeCargarDocumentacion == 1) { ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								DOCUMENTACION - <?php echo $lblNombreDocumentacion; ?>
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



							<form class="form" id="formCountry">

								<div class="row" style="padding: 5px 20px;">

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label"><?php echo $leyenda; ?></label>
										<div class="form-group input-group">
											<div class="form-line">
												<?php echo $input; ?>

											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label"> </label>
										<div class="form-group input-group">
											<div class="form-line">
												<?php echo $boton; ?>

											</div>
										</div>
									</div>
								</div>
							</form>

							<?php if (($idestadodocumentacion != 5)) { ?>
							<div class="row">

								<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
									<div class="dz-message">
										<div class="drag-icon-cph">
											<i class="material-icons">touch_app</i>
										</div>
										<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
									</div>
									<div class="fallback">
										<input name="file" type="file" id="archivos" />
										<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $id; ?>" />
									</div>
								</form>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			<?php } ?>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								ARCHIVO CARGADO
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
								<a href="javascript:void(0);" class="thumbnail timagen1">
									<img class="img-responsive">
								</a>
								<div id="example1"></div>
								<div id="contExcel" style="margin:15px;">
									<button type="button" class="btn btn-lg btn-success btnVerArchivo" style="margin-left:0px;"><i class="material-icons">search</i>VER ARCHIVO</button>
									<input type="hidden" id="verarchivo" name="verarchivo" value=""/>
								</div>
							</div>
							<div class="row">
								<div class="alert bg-<?php echo $color; ?>">
									<h4>
										Estado: <b><?php echo $estadoDocumentacion; ?></b>
									</h4>
								</div>
								<div class="col-xs-6 col-md-6" style="display:block">
									<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
									<div class="input-group col-md-12">
										<select class="form-control show-tick" id="refestados" name="refestados">
											<?php echo $cadRefEstados; ?>
										</select>
									</div>
									<?php
									if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 11)) {
									?>
									<button type="button" class="btn btn-primary guardarEstado" style="margin-left:0px;">Guardar Estado</button>
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


	<!-- perfiles de cobranza -->
	<div class="modal fade" id="lgmPerfiles" tabindex="-1" role="dialog">
		 <div class="modal-dialog modal-lg" role="document">
			  <div class="modal-content">
					<div class="modal-header">
						 <h4 class="modal-title" id="largeModalLabel">Perfiles de Cobranza</h4>
					</div>
					<div class="modal-body">
						<div class="row clearfix" style="margin-top:15px; padding: 0 20px;">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
								<select required id="suscriptor_select" name="suscriptor_select[]" class="js-example-basic-multiple" multiple="multiple">
							<?php
							while ($rowD = mysql_fetch_array($resCobranza)) {
							?>
									<option value="<?php echo $rowD['iddirectorioasesor']; ?>"><?php echo $rowD['razonsocial']; ?></option>
							<?php
							}
							?>
								</select>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
								<h5>Cargados</h5>
								<ul>
									<?php
									while ($rowD = mysql_fetch_array($resCobranzaCargada)) {
									?>
									<li><?php echo $rowD['razonsocial']; ?></li>
									<?php } ?>
								</ul>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						 <button type="button" class="btn btn-success waves-effect btnGuardarPerfiles" data-dismiss="modal">GUARDAR</button>
						 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
					</div>
			  </div>
		 </div>
	</div>




	<div class="modal fade" id="lgmModificarEstado" tabindex="-1" role="dialog">
		 <div class="modal-dialog modal-lg" role="document">
			  <div class="modal-content">
					<div class="modal-header bg-blue">
						 <h4 class="modal-title" id="largeModalLabel">MODIFICAR ESTADO DE LA COTIZACION</h4>
					</div>
					<div class="modal-body">
					 <h3>¿Esta seguro que desea <span class="lblModiEstado"></span> la cotizacion?</h3>

					 <div class="row contFrmRechazoDefinitivo">
	 					<h4>Por favor ingrese los motivos del rechazo, para poderte afrocer un mejor servicio!!</h4>
	 					<div class="row">
		 					<div class="col-xs-6">
								<div class="form-group input-group">
									<label class="label-form">Motivo</label>
			 						<select class="form-control" id="motivo" name="motivo">
			 							<option value="Precio">Precio</option>
			 							<option value="Mal Servicio">Mal Servicio</option>
			 							<option value="Otro">Otro</option>
			 						</select>
			 					</div>
							</div>
						</div>
						<div class="contMotivosPrecio">

							<div class="row">
								<div class="col-xs-3">
									<div class="form-group input-group">
										<label class="label-form">No se compartió información</label>
				 						<select class="form-control" id="nocompartioinformacion" name="nocompartioinformacion">
				 							<option value="1">Si</option>
				 							<option value="0">No</option>
				 						</select>
									</div>
			 					</div>

			 					<div class="col-xs-3">
									<div class="form-group input-group">
										<label class="label-form">Prima total Inbursa</label>
				 						<input type="text" class="form-control" id="primatotalinbursa" name="primatotalinbursa" />
									</div>
			 					</div>
								<div class="col-xs-3">
									<div class="form-group input-group">
										<label class="label-form">Prima total Competencia</label>
				 						<input type="text" class="form-control" id="primatotalcompetencia" name="primatotalcompetencia" />
									</div>
			 					</div>
								<div class="col-xs-3">
									<div class="form-group input-group">
										<label class="label-form">Aseguradora que se queda negocio</label>
				 						<select class="form-control" id="aseguradora" name="aseguradora">
											<?php while ($rowA = mysql_fetch_array($resVar10m)) {
												echo '<option value="'.$rowA['razonsocial'].'">'.$rowA['razonsocial'].'</option>';
											}
											?>
											<option value="Otra">Otra</option>
				 						</select>
									</div>
			 					</div>
							</div>
						</div>
	 					<hr>
	 					<p>Puedes contactarnos en el Tel fijo: <b><span style="color:#5DC1FD;">55 51 35 02 59</span></b></p>
	 					<p>Correo: <a href="mailto:ventas@asesorescrea.com" style="color:#5DC1FD !important;"><b>ventas@asesorescrea.com</b></a></p>
	 				</div>
					</div>
					<div class="modal-footer">
						 <button type="button" class="btn waves-effect modificarEstadoCotizacionRechazo"></button>
						 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
					</div>
			  </div>
		 </div>
	</div>
	<input type="hidden" name="idmodificarestadorechazo" id="idmodificarestadorechazo" value="0">
	<input type="hidden" name="estadomodificarestadorechazo" id="estadomodificarestadorechazo" value="0">


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

<script src="../../plugins/multi-select/js/jquery.multi-select.js"></script>

<script>

	$(document).ready(function(){

		$('.btnGuardarPerfiles').click(function() {
			$("#suscriptor_select option").each(function()
			{
				if ($(this).prop('selected')) {
					insertarCotizacionesdirectorioUnico($(this).val());
					location.reload();
				}
			});
		});


		function insertarCotizacionesdirectorioUnico(refdirectorioasesores) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'insertarCotizacionesdirectorioUnico',
					refcotizaciones: <?php echo $id; ?>,
					refdirectorioasesores: refdirectorioasesores,
					area:4
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

				},
				//si ha ocurrido un error
				error: function(){
					swal({
							title: "Respuesta",
							text: 'Actualice la pagina',
							type: "error",
							timer: 2000,
							showConfirmButton: false
					});

				}
			});
		}

		$('.js-example-basic-multiple').selectpicker();

		$('.btnCobranzaModal').click(function() {
			$('#lgmPerfiles').modal();
		});

		$('.btnAceptarMesaDeControl').click(function() {

			$('#lgmModificarEstado').modal();

			$('.lblModiEstado').html('aceptar');
			$('.modificarEstadoCotizacionRechazo').html('ACEPTAR');

			$('.modificarEstadoCotizacionRechazo').addClass('bg-green');
			$('.modificarEstadoCotizacionRechazo').removeClass('bg-amber');
			$('.modificarEstadoCotizacionRechazo').removeClass('bg-red');

			$('.contFrmRechazoDefinitivo').hide();

			$('#idmodificarestadorechazo').val(<?php echo $id; ?>);
			$('#estadomodificarestadorechazo').val(27);
			

		});//fin del boton eliminar

		$('.modificarEstadoCotizacionRechazo').click(function() {
			if ($('#estadomodificarestadorechazo').val() == 13) {
				modificarCotizacionesPorCampoRechazoDefinitivo();
			} else {
				if ($('#estadomodificarestadorechazo').val() == 10) {
					ajustarCotizacion();

				} else {
					modificarCotizacionesPorCampo();

				}
			}

		});

		function modificarCotizacionesPorCampo() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarCotizacionesPorCampo',
					id: $('#idmodificarestadorechazo').val(),
					idestado: $('#estadomodificarestadorechazo').val()
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					swal({
							title: "Respuesta",
							text: data.mensaje,
							type: data.tipo,
							timer: 1500,
							showConfirmButton: false
					});
					$('#lgmModificarEstado').modal('toggle');

					$(location).attr('href','../emision/index.php');
				},
				//si ha ocurrido un error
				error: function(){
					swal({
							title: "Respuesta",
							text: 'Actualice la pagina',
							type: "error",
							timer: 2000,
							showConfirmButton: false
					});

				}
			});
		}

		$('.btnAbandonada').click(function() {

			$('.lblModiEstado').html('enviar a emisión');
			$('.modificarEstadoCotizacionRechazo').html('ENVIAR');

			$('.modificarEstadoCotizacionRechazo').addClass('bg-green');
			$('.modificarEstadoCotizacionRechazo').removeClass('bg-amber');
			$('.modificarEstadoCotizacionRechazo').removeClass('bg-red');

			$('.contFrmRechazoDefinitivo').hide();

			$('#idmodificarestadorechazo').val(<?php echo $id; ?>);
			$('#estadomodificarestadorechazo').val(30);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar

		$('.btnLstEnviar').click(function() {
			$('#lgmENVIAR').modal();
		});

		$('.btnEnviarCotizacionCliente').click(function() {
			enviarCotizacion();
		});

		function enviarCotizacion() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'enviarCotizacion',
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "success",
								timer: 1000,
								showConfirmButton: false
						});

						$(location).attr('href','index.php');
					} else {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
					}
				},
				//si ha ocurrido un error
				error: function(){
					swal({
							title: "Respuesta",
							text: 'Actualice la pagina',
							type: "error",
							timer: 2000,
							showConfirmButton: false
					});

				}
			});
		}

		$('.btnDocumentacion').click(function() {
			idTable =  $(this).attr("id");
			url = "adjuntarcotizacionese.php?id=<?php echo $id; ?>&documentacion=" + idTable;
			$(location).attr('href',url);
		});

		$('.btnModificar').click(function() {
			modificarCotizacionUnicaDocumentacion($('#<?php echo $campo; ?>').val());
		});

		<?php if (mysql_result($resultado,0,'refestadocotizaciones') == 1) { ?>
		$('.btnVolver').click(function() {
			url = "new.php?id=" + <?php echo $id; ?>;
			$(location).attr('href',url);
		});
		<?php } else { ?>
		$('.btnVolver').click(function() {
			url = "modificar.php?id=" + <?php echo $id; ?>;
			$(location).attr('href',url);
		});
		<?php } ?>

		function modificarCotizacionUnicaDocumentacion(valor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarCotizacionUnicaDocumentacionCot',
					idcotizacion: <?php echo $id; ?>,
					campo: '<?php echo $campo; ?>',
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
			modificarEstadoDocumentacionCotizaciones($('#refestados').val());
		});

		function modificarEstadoDocumentacionCotizaciones(idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionCotizaciones',
					iddocumentacioncotizacion: <?php echo $iddocumentacionasociado; ?>,
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
						//location.reload();
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

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idcotizacion: <?php echo $id; ?>,
						iddocumentacion: <?php echo $iddocumentacion; ?>,
						accion: 'traerDocumentacionPorCotizacionDocumentacion'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("." + contenedor + " img").attr("src",'');
					$('#contExcel').val('');
					$('#contExcel').hide();
				},
				success:  function (response) {
					var cadena = response.datos.type.toLowerCase();

					if (response.datos.type != '') {
						if (cadena.indexOf("pdf") > -1) {
							PDFObject.embed(response.datos.imagen, "#"+contenedorpdf);
							$('#'+contenedorpdf).show();
							$("."+contenedor).hide();

						} else {
							if ((cadena.indexOf("officedocument") > -1) || (cadena.indexOf("sheet") > -1)) {
								$('#'+contenedorpdf).hide();
								$("."+contenedor).hide();
								$('#contExcel').show();

								$('#verarchivo').val(response.datos.imagen);

							} else {
								$("." + contenedor + " img").attr("src",response.datos.imagen);
								$("."+contenedor).show();
								$('#'+contenedorpdf).hide();
							}
						}
					}

					if (response.error) {

						$('.btnEliminar').hide();
						$('.guardarEstado').hide();
					} else {

						$('.btnEliminar').show();
						$('.guardarEstado').show();
					}



				}
			});
		}

		traerImagen('example1','timagen1');

		$('.btnVerArchivo').click(function() {
			window.open($('#verarchivo').val(),'_blank');
		});

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 30,
			acceptedFiles: ".jpg,.jpeg,.pdf,.xls,.xlsx,.csv",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
					formData.append("idasociado", '<?php echo $id; ?>');
					formData.append("iddocumentacion", '<?php echo $iddocumentacion; ?>');
				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1');
					$('.lblPlanilla').hide();
					swal("Correcto!", resp.replace("1", ""), "success");
					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
					$('#<?php echo $iddocumentacion; ?>').addClass('bg-blue');
					$('#<?php echo $iddocumentacion; ?> .number').html('Cargada');
					location.reload();
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};


		<?php if (($idestadodocumentacion != 5) && ($puedeCargarDocumentacion == 1)) { ?>
		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idasociado: <?php echo $id; ?>,
				 iddocumentacion: <?php echo $iddocumentacion; ?>
			},
			url: 'subir.php'
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


		$('.eliminar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarDocumentacionCotizacion',idcotizacion: <?php echo $id; ?>, iddocumentacion: <?php echo $iddocumentacion; ?>},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnEliminar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", data.leyenda , "success");
						traerImagen('example1','timagen1');

						//location.reload();

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


		$('.frmPerfiles').submit(function(e){

			e.preventDefault();
			if ($('.frmPerfiles')[0].checkValidity()) {

				//información del formulario
				var formData = new FormData($(".formulario")[1]);
				var message = "";
				//hacemos la petición ajax
				$.ajax({
					url: '../../ajax/ajax.php',
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
			}
		});

	});
</script>


</body>
<?php } ?>
</html>
