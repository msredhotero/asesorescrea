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

$resVentas = $serviciosReferencias->traerVentasPorCotizacion($id);

if (mysql_num_rows($resVentas) > 0) {
	$idventa = mysql_result($resVentas,0,0);
} else {
	$foliointerno = $serviciosReferencias->generaFolioInterno();
	$foliotys = '';
	$resIV = $serviciosReferencias->insertarVentas($id,1,0,0,'','',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],$foliotys,$foliointerno);

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
							<div class="text-center">
								<h1 class="display-4">¡Ya casi estás ahí! Completa tu Metodo de Pago</h1>
							</div>
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
								<?php
									if (mysql_result($resAux,0,'reftipocobranza') == 1) {
								?>
								<a href="javascript:void(0);" class="list-group-item">Solicitud de Cargo Automatico en Tarjeta de credito cuenta de deposito cuenta de cheques</a>
								<?php } ?>
							</div>

							<div class="row">
								<div class="col-xs-3"></div>
								<div class="col-xs-6">
									<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmar2" style="font-size:1.2em;">
										<i class="material-icons" style="font-size:1.2em;">save</i>
										<span>GUARDAR Y CONTINUAR</span>
									</button>
								</div>
								<div class="col-xs-3"></div>
							</div>
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

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://asesorescrea.com/desarrollo/crm/dashboard/ecommerce/assets/js/jquery.payform.min.js"></script>


<script>
	$(document).ready(function(){

		$('#accordion_18').hide();
		var cardNumberField1 = $('#card-number-field1');
		var cardNumberField2 = $('#card-number-field2');

		$('#cardnumber1').payform('formatCardNumber');
		$('#cardnumber2').payform('formatCardNumber');

		$('#cardnumber1').keyup(function() {


			if ($.payform.validateCardNumber($('#cardnumber1').val()) == false) {
				cardNumberField1.addClass('has-error');
			} else {
				cardNumberField1.removeClass('has-error');
				cardNumberField1.addClass('has-success');
			}

		});

		$('#cardnumber2').keyup(function() {


			if ($.payform.validateCardNumber($('#cardnumber2').val()) == false) {
				cardNumberField2.addClass('has-error');
			} else {
				cardNumberField2.removeClass('has-error');
				cardNumberField2.addClass('has-success');
			}

		});

		$('.with-gap').click(function() {

			$('.panelMP').removeClass('panel-col-green');
			$('.panelMP').removeClass('panel-col-cyan');
			$('.panelMP').addClass('panel-col-cyan');

			if ($(this).is(':checked')) {
				$('.panelMP' + $(this).val()).removeClass('panel-col-cyan');
				$('.panelMP' + $(this).val()).addClass('panel-col-green');
			}

		});

		$('#radio_5').click(function() {
			if ($(this).is(':checked')) {
				$('#accordion_18').show();
			}
		});

		$('#radio_6').click(function() {
			if ($(this).is(':checked')) {
				$('#accordion_18').hide();
				$('#banco1').val('');
				$('#banco2').val('');
				$('#cardnumber1').val('');
				$('#cardnumber2').val('');
				$('.panelD2').css("opacity", 1);
				$('.panelD1').css("opacity", 1);
				$('#radio_7').prop('checked', false);
				$('#radio_8').prop('checked', false);
				cardNumberField1.removeClass('has-error');
				cardNumberField2.removeClass('has-error');
			}
		});

		$('#radio_7').click(function() {
			if ($(this).is(':checked')) {
				$('.panelD1').css("opacity", 1);
				$('.panelD2').css("opacity", 0.2);
			}
		});

		$('#radio_8').click(function() {
			if ($(this).is(':checked')) {
				$('.panelD2').css("opacity", 1);
				$('.panelD1').css("opacity", 0.2);
			}
		});

		var btnConfirmar = $('#btnConfirmar');

		btnConfirmar.click(function(e) {
			guardarMetodoDePagoPorCotizacion();

		});

		function guardarMetodoDePagoPorCotizacion() {
			var errorGeneral = false;
			var bancoGeneral = '';
			var tarjetaGeneral = '';
			var domiciliado = 0;
			if ($('#radio_5').is(':checked')) {
				domiciliado = 1;
				if ($('#radio_7').is(':checked')) {
					var isCardValid = $.payform.validateCardNumber($('#cardnumber1').val());
					tarjetaGeneral = $('#cardnumber1').val();
					bancoGeneral = $('#banco1').val();

					if (bancoGeneral == '') {
						errorGeneral = true;
						swal({
							 title: "Error!!",
							 text: "Debe completar el Banco emisor",
							 type: "error",
							 timer: 2000,
							 showConfirmButton: false
						});
					}

				} else {
					if ($('#radio_8').is(':checked')) {
						var isCardValid = $.payform.validateCardNumber($('#cardnumber2').val());
						tarjetaGeneral = $('#cardnumber2').val();
						bancoGenera2 = $('#banco2').val();

						if (bancoGeneral == '') {
							errorGeneral = true;
							swal({
								 title: "Error!!",
								 text: "Debe completar el Banco emisor",
								 type: "error",
								 timer: 2000,
								 showConfirmButton: false
							});
						}
					} else {
						errorGeneral = true;
						swal({
							 title: "Error!!",
							 text: "Debe seleccionar si la dopmiciliacion es mediante la tarjeta de crédito o Cuenta de Deposito",
							 type: "error",
							 timer: 2000,
							 showConfirmButton: false
						});


					}
				}


			} else {
				domiciliado = 0;
				isCardValid = true;
			}

			if (errorGeneral == false) {
				if (!isCardValid) {
					swal({
						 title: "Error!!",
						 text: "Número de tarjeta invalido",
						 type: "error",
						 timer: 2000,
						 showConfirmButton: false
					});
				} else {
					if ($('.radioMetodo').is(':checked')) {
						$.ajax({
							url: '../../ajax/ajax.php',
							type: 'POST',
							// Form data
							//datos del formulario
							data: {
								accion: 'guardarMetodoDePagoPorCotizacion',
								id: <?php echo $id; ?>,
								refventas: <?php echo $idventa; ?>,
								metodopago: $('#metodopago').val(),
								banco: bancoGeneral,
								afiliacion: tarjetaGeneral,
								domiciliado: domiciliado
							},
							//mientras enviamos el archivo
							beforeSend: function(){

							},
							//una vez finalizado correctamente
							success: function(data){

								if (data.error) {
									swal({
											title: "Respuesta",
											text: 'Se genero un error al guardar el metodo de pago',
											type: "error",
											timer: 1000,
											showConfirmButton: false
									});


								} else {
									swal({
											title: "Respuesta",
											text: 'Se guardo correctamente el metodo de pago',
											type: "success",
											timer: 2000,
											showConfirmButton: false
									});

									$(location).attr('href', data.url);

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
					} else {
						swal({
								title: "Respuesta",
								text: 'Debe seleccionar un metodo de pago',
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
					}
				}
			}

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



	});
</script>








</body>
<?php } ?>
</html>
