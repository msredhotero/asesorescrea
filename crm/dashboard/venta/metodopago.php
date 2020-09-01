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
} else {
	header('Location: index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$cuestionario = $serviciosReferencias->traerCuestionariodetallePorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id);


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

							<h1 class="text-center">MX$<?php echo $precio; ?></h1>
							<?php echo $detalleProducto; ?>
							<hr>
							<?php if ($lblCliente != $lblAsegurado) { ?>
								<h4>Asegurado: <?php echo $lblAsegurado; ?></h4>
							<?php } ?>
							<?php if ($lblCliente != $lblBeneficiario) { ?>
								<h4>Beneficiario: <?php echo $lblBeneficiario; ?></h4>
							<?php } ?>
							<h5><a href="../../reportes/rptDomiciliacion.php?id=<?php echo $id; ?>" target="_blank">Domiciliacion</a></h5>
							<h5><a href="../../reportes/rptSolicitudCargoAutomatico.php?id=<?php echo $id; ?>" target="_blank">Solicitud de Cargo Automatico</a></h5>
							<h5><a href="../../reportes/rptF650.php?id=<?php echo $id; ?>" target="_blank">Formulario 650</a></h5>
							<h5><a href="../../reportes/rptF20926.php?id=<?php echo $id; ?>" target="_blank">Formulario F 2092-6</a></h5>

			            <hr>
			            <p><small>Al seleccionar el Método de Pago "Pago Anual por Transferencia Electronica" o "Pago Anual en sucursal Inbursa", se le enviara los datos por correo electronico para realizarlo por ventanilla, ademas de una URL a su correo electronico para que pueda adjuntarnos su comprobante de pago y activar el servicio.</small></p>

			            <form method="POST" id="formFin">
			               <input type="hidden" name="refventas" value="<?php echo $idventa; ?>">
			               <input type="hidden" name="reftipoperiodicidad" value="1">

								<div class="row">
									<div class="col-xs-3"></div>
				               <div class="col-xs-6">
										<div class="form-group">
											<label for="reftipocobranza">Seleccione el Métod de Pago</label>
											<div class="input-group">
												<select class="form-control" id="metodopago" name="metodopago">
													<option value="1">Pago Anual en linea con Tarjeta de Crédito</option>
													<option value="2">Pago Anual por Transferencia Electrónica</option>
													<option value="3">Pago anual en sucursal Inbursa</option>
													<option value="4">Pago mensual a Tarjeta de Crédito</option>
												</select>
											</div>
										</div>
									</div>
									<div class="col-xs-3"></div>
								</div>

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


<script>
	$(document).ready(function(){

		var btnConfirmar = $('#btnConfirmar');

		btnConfirmar.click(function(e) {
			guardarMetodoDePagoPorCotizacion();

		});

		function guardarMetodoDePagoPorCotizacion() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'guardarMetodoDePagoPorCotizacion',
					id: <?php echo $id; ?>,
					refventas: <?php echo $idventa; ?>,
					metodopago: $('#metodopago').val()
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
