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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../enproceso/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"En Proceso",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resVentas = $serviciosReferencias->traerVentasPorCotizacion($id);

if (mysql_num_rows($resVentas) > 0) {
	$idventa = mysql_result($resVentas,0,0);
} else {
	$foliointerno = $serviciosReferencias->generaFolioInterno();
	$foliotys = '';
	$resIV = $serviciosReferencias->insertarVentas($id,1,0,0,'','',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],$foliotys,$foliointerno,0);

	$idventa = $resIV;
}

$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');

if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencibleAsegurado(mysql_result($resCotizaciones,0,'refasegurados'),$idcuestionario);
	//asegurado
	$resAsegurado = $serviciosReferencias->traerAseguradosPorId(mysql_result($resCotizaciones,0,'refasegurados'));
	// asegurado nombre completo
	$lblAsegurado = mysql_result($resAsegurado,0,'apellidopaterno').' '.mysql_result($resAsegurado,0,'apellidomaterno').' '.mysql_result($resAsegurado,0,'nombre');
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
	$precio = mysql_result($resCotizaciones,0,'precio');
	$lblPrecio = str_replace('.','',$precio);
	$lblPrecioAd = str_replace('.','',$precio * 1.1);
} else {
	header('Location: index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$cuestionario = $serviciosReferencias->traerCuestionariodetallePorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id);

$resAux = $serviciosReferencias->traerPeriodicidadventasPorVenta($idventa);

if (mysql_num_rows($resAux)>0) {
	$existeMetodoPago = 1;
} else {
	$existeMetodoPago = 0;
}


if (isset($_GET['iddocumentacion'])) {
	$iddocumentacion = $_GET['iddocumentacion'];
} else {
	$iddocumentacion = 3;
}


$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorClienteDocumentacion($idCliente, $iddocumentacion);

$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

if (mysql_num_rows($resDocumentacionAsesor) > 0) {
	$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));

	$iddocumentacionasociado = mysql_result($resDocumentacionAsesor,0,'iddocumentacioncliente');

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

$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');

$documentacionesrequeridas2 = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');

$documentacionesrequeridas3 = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');

$cargados = 0;
while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {

	if (($rowD['archivo'] != '') && ($rowD['idestadodocumentacion'] == 5)) {
		$cargados += 1;
	}

}

// si es venta en linea solo dejo firmar con simple
if (mysql_result($resProducto,0,'ventaenlinea') == '1') {
	$puedeSeleccionarFirma = 0;
} else {
	// desarrollar como puede firmar
	$puedeSeleccionarFirma = 0;
}

$resNIP = $serviciosReferencias->traerTokensPorCotizacionVigente($id);

if (mysql_num_rows($resNIP) > 0) {
	$existeNIP = 1;
} else {
	$existeNIP = 0;
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

	<style>
		.alert > i{ vertical-align: middle !important; }
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }
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
						<?php if ($cargados != 2) { ?>
							<div>
								<div class="alert bg-orange">
									<i class="material-icons">report_problem</i> <b>Sus documentos no fueron verificados aun, se te enviara un email para poder continuar con el proceso.</b>
								</div>
							</div>

							<div class="col-xs-4">
							<?php
								$i = 0;
								$cargados2 = 0;
								while ($rowD = mysql_fetch_array($documentacionesrequeridas3)) {
									$i += 1;
									if ($rowD['archivo'] != '') {
										$cargados2 += 1;
									}
							?>

							<div class="form-group form-float">
								<button type="button" class="btn bg-<?php echo $rowD['color']; ?> waves-effect btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>"><i class="material-icons">unarchive</i><span><?php echo $rowD['documentacion']; ?></span></button>
								<input type="text" readonly="readonly" name="archivo<?php echo $i; ?>" id="archivo<?php echo $i; ?>" value="<?php echo $rowD['archivo']; ?>" required/>
							</div>

							<?php
								}

							?>
							</div>
							<div class="col-xs-8">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
												<a href="javascript:void(0);" class="thumbnail timagen1">
													<img class="img-responsive">
												</a>
												<div id="example1"></div>
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
						<?php } else { ?>

							<?php if ($puedeSeleccionarFirma == 0) { ?>
								<?php echo $detalleProducto; ?>
								<hr>
								<?php if ($lblCliente != $lblAsegurado) { ?>
									<h4>Asegurado: <?php echo $lblAsegurado; ?></h4>
								<?php } ?>
								<?php if ($lblCliente != $lblBeneficiario) { ?>
									<h4>Beneficiario: <?php echo $lblBeneficiario; ?></h4>
								<?php } ?>

								<hr>
								<h4>El metodo de pago ya fue cargado, continue con la seccion de Documentaciones por favor</h4>
								<div class="list-group">
									<a href="javascript:void(0);" class="list-group-item active">
									Método de Pago
									</a>
									<a href="javascript:void(0);" class="list-group-item">Tipo Cobranza: <?php echo mysql_result($resAux,0,'tipocobranza'); ?></a>
									<a href="javascript:void(0);" class="list-group-item">Tipo Pago: <?php echo mysql_result($resAux,0,'tipoperiodicidad'); ?></a>
								<?php
									if (mysql_result($resAux,0,'reftipocobranza') == 1) {
										if (mysql_result($resAux,0,'tipotarjeta') == 1) {
											$lblTipoTarjeta = 'Tarjeta de Crédito';
										} else {
											$lblTipoTarjeta = 'Cuenta de Deposito';
										}
										if (mysql_result($resAux,0,'afiliacionnumber') != '') {
											$tarjeta = $serviciosReferencias->decryptIt(mysql_result($resAux,0,'afiliacionnumber'));
											$tarjeta = $serviciosReferencias->hiddenString($tarjeta,0,4);
										} else {
											$tarjeta = 'Aun no fue cargada';
										}

								?>
									<a href="javascript:void(0);" class="list-group-item">Banco: <?php echo mysql_result($resAux,0,'tipoperiodicidad'); ?></a>
									<a href="javascript:void(0);" class="list-group-item"><?php echo $lblTipoTarjeta; ?>: <?php echo $tarjeta; ?></a>

								<?php } ?>
								</div>


								<div class="list-group">
									<a href="javascript:void(0);" class="list-group-item active">
									Documentos para Firmar
									</a>
									<a href="javascript:void(0);" class="list-group-item">F-650-8 AGOSTO 2018 Consentimiento Individual Seguro Grupo Vida</a>
									<a href="javascript:void(0);" class="list-group-item">F-2092-6 Poliza Seguros GMM Individual</a>
									<a href="javascript:void(0);" class="list-group-item">INE</a>
									<?php
										if (mysql_result($resAux,0,'reftipocobranza') == 1) {
									?>
									<a href="javascript:void(0);" class="list-group-item">Solicitud de Cargo Automatico en Tarjeta de credito cuenta de deposito cuenta de cheques</a>
									<?php } ?>
								</div>

								<?php if ($existeNIP == 0) { ?>
								<div class="row">
									<div class="col-xs-3"></div>
									<div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmar2" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">build</i>
											<span>GENERAR NIP</span>
										</button>
									</div>
									<div class="col-xs-3"></div>
								</div>
								<?php } else { ?>
									<div class="row">
										<div class="col-xs-3"></div>
										<div class="col-xs-6">
											<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmarR" style="font-size:1.2em;">
												<i class="material-icons" style="font-size:1.2em;">build</i>
												<span>REGENERAR NIP</span>
											</button>
										</div>
										<div class="col-xs-3"></div>
									</div>
								<?php } ?>



							<?php } ?>








						<?php } ?>
		          </div>
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
<script src="../../js/pdfobject.min.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>


<script>
	$(document).ready(function(){

		<?php

			while ($rowD = mysql_fetch_array($documentacionesrequeridas2)) {
		?>

		$('.btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "documentos.php?id=<?php echo $id; ?>&iddocumentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}

		?>

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idcliente: <?php echo $idCliente; ?>,
						iddocumentacion: <?php echo $iddocumentacion; ?>,
						accion: 'traerDocumentacionPorClienteDocumentacion'},
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

		$('.guardarEstado').click(function() {
			modificarEstadoDocumentacionClientes($('#refestados').val());
		});

		function modificarEstadoDocumentacionClientes(idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionClientes',
					iddocumentacioncliente: <?php echo $iddocumentacionasociado; ?>,
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


		$('.maximizar').click(function() {
			if ($('.icomarcos').text() == 'web') {
				$('#marcos').show();
				$('.content').css('marginLeft', '315px');
				$('.icomarcos').html('aspect_ratio');
			} else {
				$('#marcos').hide();
				$('.content').css('marginLeft', '15px');
				$('.icomarcos').html('web');
			}

		});


		$("#sign_in").submit(function(e){
			e.preventDefault();
		});



		$('#btnConfirmar2').click(function() {
			insertarTokens();
		});

		function insertarTokens() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'insertarTokens',
					refcotizaciones: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#btnConfirmar2').hide();
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
								text: 'Se genero correctamente el token y se envio al cliente',
								type: "success",
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


		$('#btnConfirmarR').click(function() {
			reenviarTokens();
		});

		function reenviarTokens() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'reenviarTokens',
					refcotizaciones: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#btnConfirmarR').hide();
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
								text: 'Se genero correctamente el token y se envio al cliente',
								type: "success",
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



	});
</script>








</body>
<?php } ?>
</html>
