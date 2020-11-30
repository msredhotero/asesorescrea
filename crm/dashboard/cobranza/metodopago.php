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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cobranza/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cobranza",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

if (mysql_result($resCotizaciones,0,'refproductosaux') == 0) {
	$lblProducto =mysql_result($resCotizaciones,0,'producto');
} else {
	$resProducto = $serviciosReferencias->traerProductosPorId(mysql_result($resCotizaciones,0,'refproductosaux'));
	$lblProducto =mysql_result($resProducto,0,'producto');
}


if (mysql_num_rows($resCotizaciones)>0) {
	//$precio = mysql_result($resCotizaciones,0,'precio');
	//$lblPrecio = str_replace('.','',$precio);

} else {
	header('Location: index.php');
}


if (mysql_result($resCotizaciones,0,'refformapago') > 0) {
	$existeMetodoPago = 1;
} else {
	$existeMetodoPago = 0;
}

/**************** validacion precio
* en base a la edad determino el precio del producto o si puede o no adquirirlo
* tambien si existe alguna pregunta que inhabilita
* $precio
* $resAsegurado
* $resCliente
* $id
*/

$inhabilitadoPorRespuesta = 0;
$nopuedeContinuar = 0;
$aplicaA = '';

$acumPrecio = mysql_result($resCotizaciones,0,'montototal');


$precio = $acumPrecio;







/********************** fin de las validaciones ********************************/
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
		            <h4 class="my-0 font-weight-normal">Resumen del Pedido: <?php echo $lblProducto; ?></h4>
		          </div>
		         <div class="body table-responsive">

						<?php // verifico las validaciones
						if ($nopuedeContinuar == 0) {
						?>

							<div class="text-center">
								<h1 class="display-4">¡Elige tu metodo de pago!</h1>
								<h4>Elige tu metodo de pago</h4>
							</div>
							<?php //echo $detalleProducto; ?>




			            <hr>
							<?php if ($existeMetodoPago == 0) { ?>
							<form method="POST" id="formFin">

								<div class="panel-group" id="accordion_17" role="tablist" aria-multiselectable="true">
									<div class="panel panel-col-cyan panelMP panelMP1">
										<div class="panel-heading" role="tab" id="headingOne_17">
											<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseOne_17" aria-expanded="true" aria-controls="collapseOne_17" class="">
											<i class="material-icons">credit_card</i> Pago Anual en linea con Tarjeta de Crédito
											</a>
											</h4>
										</div>
										<div id="collapseOne_17" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_17" aria-expanded="true" style="">
											<div class="panel-body">
												<p>Pago anual con tarjeta de credito, a traves de nuestro procesador de pagos. Se admiten tarjetas Visa y Mastercard.</p>
												<p><small>1 pago de </small></p>
												<h4>Monto a pagar: MXN <?php echo number_format($precio, 2, ',', '.'); ?></h4>
												<div class="right">
													<input name="metodopago" type="radio" value="1" class="with-gap radioMetodo" id="radio_1" require>
	                                 	<label for="radio_1">Seleccionar</label>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-col-cyan panelMP panelMP2">
										<div class="panel-heading" role="tab" id="headingTwo_17">
											<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseTwo_17" aria-expanded="false" aria-controls="collapseTwo_17">
											<i class="material-icons">credit_card</i> Pago Anual por Transferencia Electrónica
											</a>
											</h4>
										</div>
										<div id="collapseTwo_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_17" aria-expanded="false">
											<div class="panel-body">
												<p>Debe adjuntarnos su comprobante de pago y activar el servicio.</p>
												<p>Clabe Interbancaria para transferencias: 036180500079200351</p>
												<p><small>1 pago de </small></p>
												<h4>Monto a pagar: MXN <?php echo number_format($precio, 2, ',', '.'); ?></h4>
												<div class="right">
													<input name="metodopago" type="radio" value="2" class="with-gap radioMetodo" id="radio_2" require>
	                                 	<label for="radio_2">Seleccionar</label>
												</div>
											</div>
										</div>
									</div>




								</div>

			               <input type="hidden" name="idperiodicidadventadetalle" value="<?php echo $id; ?>">
			               <input type="hidden" name="reftipoperiodicidad" value="1">

								<div class="row">
									<div class="col-xs-3"></div>
				               <div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmar" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">save</i>
											<span>GUARDAR Y CONTINUAR</span>
										</button>
									</div>
									<div class="col-xs-3"></div>
								</div>
			            </form>
						<?php } else { ?>
							<h4>El metodo de pago ya fue cargado, ya podes pagar tu recibo.</h4>
							<div class="list-group">
								<a href="javascript:void(0);" class="list-group-item active">
								Método de Pago
								</a>
								<a href="javascript:void(0);" class="list-group-item">Forma de Pago: <?php echo mysql_result($resCotizaciones,0,'formapago'); ?></a>

							<?php if (mysql_result($resCotizaciones,0,'refformapago') == 1) { ?>
								<a href="comercio_fin.php?id=<?php echo $id; ?>" class="list-group-item bg-green">CONTINUAR CON EL PAGO ONLINE</a>
							<?php } ?>
							<?php if (mysql_result($resCotizaciones,0,'refformapago') == 2) { ?>
								<a href="subirdocumentacioni.php?id=<?php echo $id; ?>" class="list-group-item bg-green">SUBIR COMPROBANTE DE PAGO</a>
							<?php } ?>

							</div>
						<?php } ?>

					<?php
						// sino valido salgo por aca
						} else {
					?>
					<div class="text-center">
						<?php if ($aplicaA != '') { ?>
						<h3 class="display-4">Lo sentimos para el Producto solicitado no es alcanzable para la edad del <?php echo $aplicaA; ?> <?php echo $edad; ?> años</h3>
						<?php } ?>
						<?php if ($inhabilitadoPorRespuesta == 1) { ?>
						<h3 class="display-4">Lo sentimos las preguntas que respondio en el cuestionario, no superan lo necesario para acceder al Producto.</h3>
						<?php } ?>
						<h5>Por favor pongase en contacto con uno de nuestros representantes para solicitar asesoramiento, acerca del producto</h5>
						<p>Puedes contactarnos en el Teléfono: <b><span style="color:#5DC1FD;">55 51 35 02 59</span></b></p>
						<br>
						<br>
						<h4>Muchas Gracias!.</h4>
					</div>
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

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://asesorescrea.com/desarrollo/crm/dashboard/ecommerce/assets/js/jquery.payform.min.js"></script>


<script>
	$(document).ready(function(){

		$('#accordion_18').hide();
		var cardNumberField1 = $('#card-number-field1');
		var cardNumberField2 = $('#card-number-field2');



		$('.with-gap').click(function() {

			$('.panelMP').removeClass('panel-col-green');
			$('.panelMP').removeClass('panel-col-cyan');
			$('.panelMP').addClass('panel-col-cyan');

			if ($(this).is(':checked')) {
				$('.panelMP' + $(this).val()).removeClass('panel-col-cyan');
				$('.panelMP' + $(this).val()).addClass('panel-col-green');
			}

			if (($(this).val() == 1) || ($(this).val() == 2) || ($(this).val() == 3)) {
				$('#radio_6').prop('disabled',false);
				$('#radio_6').click();
				$('#radio_5').prop('disabled',true);

				borrarDomiciliacion();
			}

			if ($(this).val() == 4) {
				$('#radio_5').prop('disabled',false);
				$('#radio_5').click();
				$('#radio_6').prop('disabled',true);

				borrarDomiciliacion();

				$('#accordion_18').show();


			}

		});

		$('#radio_5').click(function() {
			if ($(this).is(':checked')) {
				$('#accordion_18').show();
			}
		});


		var btnConfirmar = $('#btnConfirmar');

		btnConfirmar.click(function(e) {
			guardarMetodoDePagoPorRecibo();

		});

		function guardarMetodoDePagoPorRecibo() {
			var errorGeneral = false;

			if ($('.radioMetodo').is(':checked')) {
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: {
						accion: 'guardarMetodoDePagoPorRecibo',
						id: <?php echo $id; ?>,
						metodopago: $('input:radio[name=metodopago]:checked').val()
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



		$("#sign_in").submit(function(e){
			e.preventDefault();
		});


	});
</script>


</body>
<?php } ?>
</html>
