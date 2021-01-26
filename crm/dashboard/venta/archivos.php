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
	include ('../../includes/funcionesComercio.php');

	$serviciosFunciones 	= new Servicios();
	$serviciosUsuario 		= new ServiciosUsuarios();
	$serviciosHTML 			= new ServiciosHTML();
	$serviciosReferencias 	= new ServiciosReferencias();
	$baseHTML = new BaseHTML();
	$serviciosComercio      = new serviciosComercio();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../venta/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Venta",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resMetodoPago = $serviciosReferencias->traerMetodopagoPorCotizacion($id);




if (mysql_num_rows($resMetodoPago) > 0) {
	$idcobro = mysql_result($resMetodoPago,0,0);
	$esDomiciliado = mysql_result($resMetodoPago,0,'reftipocobranza');
	$existeMetodoPago = 1;
} else {
	// creo el cobro
	$idcobro = 0;
	$existeMetodoPago = 0;
}

$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');

$reftipoproductorama = mysql_result($resProducto,0,'reftipoproductorama');

$consolicitud = mysql_result($resProducto,0,'consolicitud');

if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencibleAsegurado(mysql_result($resCotizaciones,0,'refasegurados'),$idcuestionario);
	//asegurado
	$resAsegurado = $serviciosReferencias->traerAseguradosPorId(mysql_result($resCotizaciones,0,'refasegurados'));

	if (mysql_num_rows($resAsegurado)>0) {
		$lblAsegurado = mysql_result($resAsegurado,0,'apellidopaterno').' '.mysql_result($resAsegurado,0,'apellidomaterno').' '.mysql_result($resAsegurado,0,'nombre');

		$idAsegurado = mysql_result($resAsegurado,0,0);

		$documentacionesrequeridasAsegurado = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacionCompletaIn(mysql_result($resAsegurado,0,0),'3,4');

		$documentacionesrequeridasAsegurado2 = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacionCompletaIn($idAsegurado,'3,4');
	}
	// asegurado nombre completo

} else {
	$lblAsegurado = mysql_result($resCotizaciones,0,'clientesolo');
}

if (mysql_result($resCotizaciones,0,'tieneasegurado') == '0') {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencible($idCliente,$idcuestionario);
}


if (mysql_result($resCotizaciones,0,'refbeneficiarios') > 0) {
	// beneficiario
	$resBeneficiario = $serviciosReferencias->traerAseguradosPorId(mysql_result($resCotizaciones,0,'refbeneficiarios'));
	// beneficiario nombre completo
	$lblBeneficiario = mysql_result($resBeneficiario,0,'apellidopaterno').' '.mysql_result($resBeneficiario,0,'apellidomaterno').' '.mysql_result($resBeneficiario,0,'nombre');
} else {
	$lblBeneficiario = mysql_result($resCotizaciones,0,'clientesolo');
}

if (!(isset($resDatosSencibles))) {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencibleAsegurado(0,$idcuestionario);
}

if (mysql_num_rows($resCotizaciones)>0) {
	$precio = mysql_result($resCotizaciones,0,'primatotal');
	$lblPrecio = str_replace('.','',$precio);
	$lblPrecioAd = str_replace('.','',$precio * 1.2);
} else {
	header('Location: index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$cuestionario = $serviciosReferencias->traerCuestionariodetallePorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id);


$iddocumentacionase = 0;
$iddocumentacion = 0;
$iddocumentacionrecibo = 0;

$docuContratante = 0;
$docuAsegurado = 0;
$docuRecibo = 0;

$jqueryactivocliente = '';
$jqueryactivoasegurado = '';
$jqueryactivorecibo = '';

$jqueryactivocliente2 = '';
$jqueryactivoasegurado2 = '';
$jqueryactivorecibo2 = '';


if (isset($_GET['iddocumentacion'])) {
	$iddocumentacion = $_GET['iddocumentacion'];

	$docuContratante = 1;

	$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorClienteDocumentacion($idCliente, $iddocumentacion);

	$iddocumentacionasociado = $_GET['iddocumentacion'];

	$jqueryidcliente = $idCliente;
   $jqueryiddocumentacion = $iddocumentacion;
   $jqueryaccion = 'traerDocumentacionPorClienteDocumentacion';
   $jqueryurl = 'subircli.php';
	$jqueryidnombre = 'idasociado';
	$jqueryidnombreI = 'idcliente';
	$jqueryactivocliente = 'activo';
	$jqueryactivocliente2 = 'in active';
} else {
	if (isset($_GET['iddocumentacionase'])) {
		$iddocumentacion = $_GET['iddocumentacionase'];

		$docuAsegurado = 1;

		$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacion($idAsegurado, $iddocumentacion);

		if (mysql_num_rows($resDocumentacionAsesor)>0) {
			$iddocumentacionasociado = mysql_result($resDocumentacionAsesor,0,'iddocumentacionfamiliar');
		} else {
			$iddocumentacionasociado = 3;
		}


		$jqueryidcliente = $idAsegurado;
	   $jqueryiddocumentacion = $iddocumentacion;
	   $jqueryaccion = 'traerDocumentacionPorFamiliarDocumentacion';
	   $jqueryurl = 'subirase.php';
		$jqueryidnombre = 'idfamiliar';
		$jqueryidnombreI = 'idfamiliar';
		$jqueryactivoasegurado = 'activo';
		$jqueryactivoasegurado2 = 'in active';
	} else {

		$iddocumentacion = 3;

		$docuContratante = 1;

		$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorClienteDocumentacion($idCliente, $iddocumentacion);


		$iddocumentacionasociado = $iddocumentacion;

		$jqueryidcliente = $idCliente;
	   $jqueryiddocumentacion = $iddocumentacion;
	   $jqueryaccion = 'traerDocumentacionPorClienteDocumentacion';
	   $jqueryurl = 'subircli.php';
		$jqueryidnombre = 'idasociado';
		$jqueryidnombreI = 'idcliente';
		$jqueryactivocliente = 'activo';
		$jqueryactivocliente2 = 'in active';

	}

}




$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

if (mysql_num_rows($resDocumentacionAsesor) > 0) {
	$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));



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
} else {
	$cadRefEstados = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

	$iddocumentacionasociado = 0;

	$estadoDocumentacion = 'Falta Cargar';

	$color = 'blue';

	$span = 'text-info glyphicon glyphicon-plus-sign';
}


$input2 = '';
$boton2 = '';
$leyenda2 = '';
$campo2 = '';

$input3 = '';
$boton3 = '';
$leyenda3 = '';
$campo3 = '';

switch ($iddocumentacion) {

	default:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
}

$refEstadoCotizacion = mysql_result($resultado,0,'refestadocotizaciones');

$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');

$documentacionesrequeridas2 = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');




$puedeEntrar = 0;
if (($refEstadoCotizacion == 20)) {
	$puedeEntrar = 1;
} else {
	if ($refEstadoCotizacion == 21) {


		while ($rowD = mysql_fetch_array($documentacionesrequeridasAux)) {
			if (($rowD['idestadodocumentacion'] == 2) || ($rowD['idestadodocumentacion'] == 3) || ($rowD['idestadodocumentacion'] == 4)) {
				$puedeEntrar = 1;
			}
		}

		if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {

			$documentacionesrequeridasAseguradoAux = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacionCompletaIn($idAsegurado,'3,4');

			while ($rowD = mysql_fetch_array($documentacionesrequeridasAseguradoAux)) {
				if (($rowD['idestadodocumentacion'] == 2) || ($rowD['idestadodocumentacion'] == 3) || ($rowD['idestadodocumentacion'] == 4)) {
					$puedeEntrar = 1;
				}
			}

		}

		if ($puedeEntrar == 0 ) {
			return header('Location: ../cotizacionesvigentes/new.php?id='.$id);
		}
	} else {
		return header('Location: ../cotizacionesvigentes/new.php?id='.$id);
	}

}


$resClientes = $serviciosReferencias->traerClientesPorId($idCliente);


/// creo el documento pdf
// creo el archivo grande
// pregunto rpimero si existe.
$pathSolcitud  = '../../archivos/solicitudes/cotizaciones/'.$id;

if (!file_exists($pathSolcitud)) {
	mkdir($pathSolcitud, 0777);
}

$filesSolicitud = array_diff(scandir($pathSolcitud), array('.', '..'));
if (count($filesSolicitud) < 1) {
	//die(var_dump(__DIR__));
	require ('../../reportes/rptFTodos.php');
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

	<script src="https://unpkg.com/pdf-lib@1.4.0"></script>
	<script src="https://unpkg.com/downloadjs@1.4.7"></script>

	<style>
		.alert > i{ vertical-align: middle !important; }
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
		.progress {
			background-color: #1b2646;
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
		<div class="row clearfix">

			<div class="row">
				<div class="col-xs-12">
		        <div class="card">
		          <div class="header bg-blue">
		            <h4 class="my-0 font-weight-normal">Resumen del Pedido: <?php echo mysql_result($resultado,0,'producto'); ?></h4>
		          </div>
		          <div class="body table-responsive">
						<input type="hidden" name="merge_solicitud" id="merge_solicitud" value="" />
						 <div class="text-center">
							 <!-- <h1 class="display-4">Adjunta los archivos solicitados</h1> -->

						 </div>
						 <?php if ($consolicitud == 1) { ?>
						 <div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
							 <div class="col-xs-6 bs-wizard-step complete">
								 <div class="text-center bs-wizard-stepnum">Paso 1</div>

								 <div class="progress">
									 <div class="progress-bar"></div>
								 </div>

								 <a href="siap.php?id=13" class="bs-wizard-dot"></a>
								 <div class="bs-wizard-info text-center">CARGA TUS DOCUMENTOS</div>
							 </div>

							 <div class="col-xs-6 bs-wizard-step complete">
								 <div class="text-center bs-wizard-stepnum">Paso 2</div>
								 <div class="progress">
									 <div class="progress-bar"></div>
								 </div>
								 <a href="javascript:void(0)" class="bs-wizard-dot"></a>
								 <div class="bs-wizard-info text-center">FIRMAR LA SOLICITUD DE FORMA DIGITAL</div>
							 </div>

						 </div>
					 <?php } else { ?>
						 <div class="bs-wizard-info text-center">PASO 1 - CARGA TUS DOCUMENTOS</div>
						 <hr>
					 <?php } ?>


						<ul class="nav nav-tabs tab-nav-right" role="tablist">
							<li role="presentation" class="<?php echo $jqueryactivocliente; ?>"><a href="#tabcontratente" data-toggle="tab">CONTRATANTE</a></li>
						<?php if ($lblCliente != $lblAsegurado) { ?>
							<li role="presentation" class="<?php echo $jqueryactivoasegurado; ?>"><a href="#tabasegurado" data-toggle="tab">ASEGURADO</a></li>
						<?php } ?>

						</ul>
						<!-- inicio del primer tab -->
						<div class="tab-content">
                     <div role="tabpanel" class="tab-pane fade <?php echo $jqueryactivocliente2; ?>" id="tabcontratente">
								<?php if (mysql_result($resClientes,0,'nroidentificacion') == '') { ?>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmConttipoidentificacion" style="display:block">
										<label class="form-label">Tipo Identificación <span style="color:red;">*</span>  </label>
										<div class="form-group input-group">
											<div class="form-line">
												<select class="form-control" id="reftipoidentificacion" name="reftipoidentificacion"  required >
													<option value="">-- Seleccionar --</option>
													<option value="1">INE</option>
													<option value="2">Pasaporte</option>
												</select>
											</div>
										</div>
									</div>

									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContidentificacion" style="display:block">
										<label class="form-label">No. Identificación <span style="color:red;">*</span>  </label>
										<div class="form-group input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="nroidentificacion" name="nroidentificacion" maxlength="13" required />
											</div>
										</div>
									</div>
								</div>
							<?php } else { ?>
								<input type="hidden" name="nroidentificacion" id="nroidentificacion" value="<?php echo mysql_result($resClientes,0,'nroidentificacion'); ?>" />
								<input type="hidden" name="reftipoidentificacion" id="reftipoidentificacion" value="<?php echo mysql_result($resClientes,0,'reftipoidentificacion'); ?>" />
							<?php } ?>

							<div class="col-xs-12">
							<?php
								$i = 0;
								$cargados = 0;
								while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
									$i += 1;
									if ($rowD['archivo'] != '') {
										$cargados += 1;
									}
							?>

							<div class="form-group form-float" align="center">
								<div class="col-xs-4">
									<button type="button" class="btn btn-block bg-<?php echo ($rowD['color'] == 'blue' ? 'green' : $rowD['color']); ?> waves-effect btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>"><i class="material-icons">unarchive</i><span><?php echo $rowD['documentacion']; ?> (click para cargar)</span></button>
									<div class="hidden">
										<input type="text" readonly="readonly" name="archivo<?php echo $i; ?>" id="archivo<?php echo $i; ?>" value="<?php echo $rowD['archivo']; ?>" required/>
									</div>
								</div>
							</div>

							<?php
								}

							?>


							</div>
							<?php if ($docuContratante > 0) { ?>
							<div class="col-xs-12">
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="card">
										<div class="header bg-blue">

											<h2>DOCUMENTACIÓN: <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?> </h2>

										</div>
										<div class="body">


											<?php if ($estadoDocumentacion != 'Aceptada') { ?>
											<div class="row contDropbox">

												<form action="subircli.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
													<div class="dz-message">
														<div class="drag-icon-cph">
															<i class="material-icons">touch_app</i>
														</div>
														<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
													</div>
													<div class="fallback">
														<input name="file" type="file" id="archivos" />
														<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $idCliente; ?>" />
													</div>
												</form>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
									<div class="card">
										<div class="header bg-blue">
											<h2>
												ARCHIVO CARGADO
											</h2>

										</div>
										<div class="body">

											<div class="row">
												<a href="javascript:void(0);" class="thumbnail timagen1">
													<img class="img-responsive">
												</a>
												<div id="example1"></div>
											</div>
											<div class="row">
												<div class="alert bg-<?php echo ($color == 'blue' ? 'green' : $color); ?>">
													<h4>
														Estado: <b><?php echo $estadoDocumentacion; ?></b>
													</h4>
												</div>


											</div>

										</div>
									</div>
								</div>


							</div>
							<?php } ?>
						</div>

					<!-- fin del primer tab -->
					<!-- inicio del segundo tab -->
					<?php if ($lblCliente != $lblAsegurado) { ?>

						<div role="tabpanel" class="tab-pane fade <?php echo $jqueryactivoasegurado2; ?>" id="tabasegurado">

						<h4>Cargue la documentación solicitada, si necesita modificar el documento, repetita el mismo paso y se reemplazara el archivo con el nuevo.</h4>

						<div class="col-xs-12">

						<?php
							$k=0;
							while ($rowD = mysql_fetch_array($documentacionesrequeridasAsegurado)) {
								$i += 1;
								if ($rowD['archivo'] != '') {
									$cargados += 1;
								}
						?>

						<div class="form-group form-float">
							<div class="col-xs-4">
								<button type="button" class="btn btn-block bg-<?php echo ($rowD['color'] == 'blue' ? 'green' : $rowD['color']); ?> waves-effect btna<?php echo str_replace(' ','',$rowD['documentacion']); ?>"><i class="material-icons">unarchive</i><span><?php echo $rowD['documentacion']; ?> (click para cargar)</span></button>
								<div class="hidden">
									<input type="text" readonly="readonly" name="archivo<?php echo $i; ?>" id="archivo<?php echo $i; ?>" value="<?php echo $rowD['archivo']; ?>" required/>
								</div>
							</div>
						</div>

						<?php
							}

						?>
						</div>
						<?php if ($docuAsegurado > 0) { ?>
						<div class="col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="card">
									<div class="header bg-blue">
										<h2>
											DOCUMENTACIÓN: <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?>
										</h2>

									</div>
									<div class="body">

										<?php if ($estadoDocumentacion != 'Aceptada') { ?>
										<div class="row contDropbox">

											<form action="subirase.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
												<div class="dz-message">
													<div class="drag-icon-cph">
														<i class="material-icons">touch_app</i>
													</div>
													<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
												</div>
												<div class="fallback">
													<input name="file" type="file" id="archivos" />
													<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $idAsegurado; ?>" />
												</div>
											</form>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="card">
									<div class="header bg-blue">
										<h2>
											ARCHIVO CARGADO
										</h2>

									</div>
									<div class="body">

										<div class="row">
											<a href="javascript:void(0);" class="thumbnail timagen1">
												<img class="img-responsive">
											</a>
											<div id="example1"></div>
										</div>
										<div class="row">
											<div class="alert bg-<?php echo ($color == 'blue' ? 'green' : $color); ?>">
												<h4>
													Estado: <b><?php echo $estadoDocumentacion; ?></b>
												</h4>
											</div>


										</div>

									</div>
								</div>
							</div>


						</div>
						<?php } ?>

					</div>
					<!-- fin del segundo tab -->
					<?php } ?>

					</div>



		          </div>
					 <?php if ($cargados == $i) { ?>

						<div class="row">
							<div class="col-xs-3"></div>
							<div class="col-xs-6">
								<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmar3" style="font-size:1.2em;">
									<i class="material-icons" style="font-size:1.2em;">save</i>
									<span>GUARDAR Y CONTINUAR</span>
								</button>
							</div>
							<div class="col-xs-3"></div>
						</div>
					 <?php } ?>
					 <br>
					 <br>
		        </div>
			  </div>




			</div>
		</div>
	</div>

</section>




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

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<script src="https://asesorescrea.com/desarrollo/crm/dashboard/ecommerce/assets/js/jquery.payform.min.js"></script>


<script>
	const { PDFDocument } = PDFLib
	$(document).ready(function(){

		<?php

			if ($cargados == $i) { ?>
			async function copyPages() {
				const url1 = '<?php echo '../../archivos/solicitudes/cotizaciones/'.$id.'/FSOLICITUDAC.pdf'; ?>'

				const firstDonorPdfBytes = await fetch(url1).then(res => res.arrayBuffer())

				const pdfA = await PDFDocument.load(firstDonorPdfBytes);

				const pdfDoc = await PDFDocument.create();

				const copiedPagesA = await pdfDoc.copyPages(pdfA, pdfA.getPageIndices());
		      copiedPagesA.forEach((page) => pdfDoc.addPage(page));

			<?php
				$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');
				$ii = 1;
				while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
					$ii += (integer)1;
					if (strpos( strtolower($rowD['type']),"pdf") !== false) {
						echo "const url".$ii." = '".'../../archivos/clientes/'.$idCliente.'/'.$rowD['carpeta'].'/'.$rowD['archivo']."'\n";

						echo "const firstDonorPdfBytes".$ii." = await fetch(url".$ii.").then(res => res.arrayBuffer())\n";
						echo "const pdfA".$ii." = await PDFDocument.load(firstDonorPdfBytes".$ii.")\n";

						echo "const copiedPagesA".$ii." = await pdfDoc.copyPages(pdfA".$ii.", pdfA".$ii.".getPageIndices());
				      copiedPagesA".$ii.".forEach((page) => pdfDoc.addPage(page));\n";

					} else {

						if (strpos( strtolower($rowD['type']),"png") !== false) {

						} else {
							echo "const jpgUrl".$ii." = '".'../../archivos/clientes/'.$idCliente.'/'.$rowD['carpeta'].'/'.$rowD['archivo']."'\n";

							echo "const jpgImageBytes".$ii." = await fetch(jpgUrl".$ii.").then((res) => res.arrayBuffer())\n";

							echo "const jpgImage".$ii." = await pdfDoc.embedJpg(jpgImageBytes".$ii.")\n";

							echo "const jpgDims".$ii." = jpgImage".$ii.".scale(0.5)\n";

					      echo "const page".$ii." = pdfDoc.addPage()\n";

							echo "page".$ii.".drawImage(jpgImage".$ii.", {
					         x: page".$ii.".getWidth() / 2 - jpgDims".$ii.".width / 2,
					         y: page".$ii.".getHeight() / 2 - jpgDims".$ii.".height / 2 + 100,
					         width: jpgDims".$ii.".width,
					         height: jpgDims".$ii.".height,
					      })\n";


						}

					}

				}

		?>
				const pdfBytes = await pdfDoc.save()

				const pdfDataUri = await pdfDoc.saveAsBase64();
				document.getElementById('merge_solicitud').value = await pdfDataUri;
			}
			copyPages()
		<?php } ?>

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {<?php echo $jqueryidnombreI; ?>: <?php echo $jqueryidcliente; ?>,
						iddocumentacion: <?php echo $jqueryiddocumentacion; ?>,
						accion: '<?php echo $jqueryaccion; ?>'},
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

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 30,
			acceptedFiles: ".jpg,.jpeg,.pdf",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
					formData.append("<?php echo $jqueryidnombre; ?>", '<?php echo $jqueryidcliente; ?>');
					formData.append("iddocumentacion", '<?php echo $jqueryiddocumentacion; ?>');
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


		<?php if ($estadoDocumentacion != 'Aceptada') { ?>
		var myDropzone = new Dropzone("#archivos", {
			params: {
				 <?php echo $jqueryidnombre; ?>: <?php echo $jqueryidcliente; ?>,
				 iddocumentacion: <?php echo $jqueryiddocumentacion; ?>
			},
			url: '<?php echo $jqueryurl; ?>'
		});
		<?php } ?>

		<?php

			while ($rowD = mysql_fetch_array($documentacionesrequeridas2)) {
		?>

		$('.btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "archivos.php?id=<?php echo $id; ?>&iddocumentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}

		?>

		<?php
		if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {
			while ($rowD = mysql_fetch_array($documentacionesrequeridasAsegurado2)) {
		?>

		$('.btna<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "archivos.php?id=<?php echo $id; ?>&iddocumentacionase=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}
		}
		?>

		<?php
		if ($refEstadoCotizacion == 22) {
			while ($rowD = mysql_fetch_array($documentacionesCobros2)) {
		?>

		$('.btnr<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "archivos.php?id=<?php echo $id; ?>&iddocumentacionrecibo=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}
		}
		?>




		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$('#btnConfirmar3').click(function() {
			if (($('#reftipoidentificacion').val() != 0) && ($('#nroidentificacion').val().length > 6)) {
				if ($('#merge_solicitud').val() == '') {
					swal({
							title: "Respuesta",
							text: 'Por favor ingrese espere unos segundos y vuelva a intentarlo',
							type: "error",
							timer: 2500,
							showConfirmButton: false
					});
				} else {
					ineCargadoCotizacion();
				}

			} else {

				swal({
						title: "Respuesta",
						text: 'Por favor ingrese el Tipo de Identificación y un No. de Identificación válido',
						type: "error",
						timer: 2500,
						showConfirmButton: false
				});
			}

		});

		function ineCargadoCotizacion() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'ineCargadoCotizacion',
					id: <?php echo $id; ?>,
					reftipoidentificacion: $('#reftipoidentificacion').val(),
					nroidentificacion: $('#nroidentificacion').val(),
					merge_solicitud: $('#merge_solicitud').val()
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#btnConfirmar3').hide();
					$('.contDropbox').remove();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error) {
						swal({
								title: "Respuesta",
								text: 'Se genero un error al guardar el paso',
								type: "error",
								timer: 1000,
								showConfirmButton: false
						});


					} else {
						swal({
								title: "Respuesta",
								text: 'Se guardaron correctamente los datos y se envio a revisión, nuestro equipo verificará los datos. Muchas Gracias',
								type: "success",
								timer: 2000,
								showConfirmButton: false
						});

						url = "documentos.php?id=<?php echo $id; ?>";
						$(location).attr('href',url);

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

	});
</script>








</body>
<?php } ?>
</html>
