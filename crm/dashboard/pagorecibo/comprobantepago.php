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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../pagorecibo/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Pagar Recibos",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);


$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');


if (mysql_num_rows($resCotizaciones)>0) {
	$precio = mysql_result($resCotizaciones,0,'montototal');

} else {
	header('Location: index.php');
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

		.pdfobject-container {
		   max-width: 100%;
			height: 400px;
			border: 10px solid rgba(0,0,0,.2);
			margin: 0;
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
						 <div class="text-center">
							 <h1 class="display-4">¡Suba su comprobante de pago para ser validado por el area de cobranza!</h1>

						 </div>




						<ul class="nav nav-tabs tab-nav-right" role="tablist">

							<li role="presentation" class="activo"><a href="#tabrecibo" data-toggle="tab"></a></li>
						</ul>
						<!-- inicio del primer tab -->
						<div class="tab-content">



					<!-- inicio del tercer tab -->
					<?php if (($refEstadoCotizacion == 22)) { ?>

						<div role="tabpanel" class="tab-pane fade in active" id="tabrecibo">


						<div class="col-xs-12">
							<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
								<div class="card">
									<div class="header bg-blue">
										<h2>
											COMPROBANTE DE PAGO
										</h2>

									</div>
									<div class="body">

										<?php if ($puedeSubirArchivos == 1) { ?>
										<div class="row contDropbox">

											<form action="subirrecibos.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
												<div class="dz-message">
													<div class="drag-icon-cph">
														<i class="material-icons">touch_app</i>
													</div>
													<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
												</div>
												<div class="fallback">
													<input name="file" type="file" id="archivos" />
													<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $idpago; ?>" />
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
											<div class="alert bg-<?php echo ($lblColor == 'blue' ? 'green' : $lblColor); ?>">
												<h4>
													Estado: <b><?php echo $lblEstado; ?></b>
												</h4>
											</div>


										</div>

									</div>
								</div>
							</div>


						</div>

					</div>

					<!-- fin del tercer tab -->
					<?php } ?>
					</div>



		          </div>
					 <?php if (($idpagoestado == 1) && ($archivo != '')) { ?>



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

<script>
	$(document).ready(function(){

		var options = {
		    height: "400px",
		    page: '1',
		    pdfOpenParams: {
		        view: 'FitV',
		        pagemode: 'thumbs',
		        search: 'lorem ipsum'
		    }
		};
		function traerImagen(contenedorpdf, contenedor, options) {
			$.ajax({
				data:  {idpago: <?php echo $idpago; ?>,
						accion: 'traerPagosPorId'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("." + contenedor + " img").attr("src",'');
				},
				success:  function (response) {


					if (response.datos.type != '') {
						var cadena = response.datos.type.toLowerCase();

						if (cadena.indexOf("pdf") > -1) {
							PDFObject.embed(response.datos.imagen, "#example1",options);
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
					formData.append("idpago", '<?php echo $idpago; ?>');

				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1');
					$('.lblPlanilla').hide();

					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
					if (resp.indexOf('Error')!== -1) {
						swal("Error!", resp.replace("1", ""), "error");
					} else {
						swal("Correcto!", resp.replace("1", ""), "success");

						location.reload();
					}
					//
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};


		<?php if ($idpagoestado != 5) { ?>
		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idpago: <?php echo $idpago; ?>
			},
			url: 'subirrecibos.php'
		});
		<?php } ?>





		$("#sign_in").submit(function(e){
			e.preventDefault();
		});


	});
</script>








</body>
<?php } ?>
</html>
