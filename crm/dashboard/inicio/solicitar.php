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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../inicio/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//die();

$token = $_SESSION['token_ac'];

if (!(isset($token))) {
	header('Location: index.php');
}

$resultadoToken = $serviciosReferencias->traerTokenasesoresPorTokenActivo($token);



$url_real = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],'inicio/')+10);

//die(var_dump(mysql_result($resultadoToken,0,'accion')));

$rCliente = $serviciosReferencias->traerClientesPorId(mysql_result($resultadoToken,0,'refclientes'));
//die(var_dump($_SESSION['usuaid_sahilices']));
$rIdCliente = mysql_result($rCliente,0,0);

$idcliente = mysql_result($resultadoToken,0,'refclientes');

$rTipoPersona = mysql_result($rCliente,0,'reftipopersonas');

$lblTelefonoCelular = mysql_result($rCliente,0,'telefonocelular');

if ($lblTelefonoCelular == '') {
	$existeCelular = 0;
} else {
	$existeCelular = 1;
}


//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Inicio",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';



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

	<link rel="stylesheet" href="../../css/materialDateTimePicker.css">

	<!-- noUISlider Css -->
   <link href="../../plugins/nouislider/nouislider.min.css" rel="stylesheet" />

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		.tscodigopostal { width: 400px; }

		.ui-autocomplete { position: absolute; cursor: default;z-index:30 !important;}

		.sectionC {
			height:360px;
			z-index:1 !important;
		}

		@media (min-width: 1200px) {
		   .modal-xlg {
		      width: 90%;
		   }
		}

		#respuestaPeso, #respuestaTalla, #respuestaAltura {
			font-size: 26px;
			font-weight: bold !important;
		}

		.frmContpregunta h4 span {
			text-decoration: none;
			font-weight: normal !important;
		}

		.number {
			font-size: 1.4em !important;
		}

		.btnCursor { cursor: pointer; }

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


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="body table-responsive">
							<div class="row">
								<div class"row imgCotiza button-container-img" style="margin-top:-20px; margin-left:-5px;">
									<img src="../../imagenes/cotiza_bck.jpg" width="105%"/>
								</div>
							</div>

							<div class="row">
								<h3 style="color: #C6AC83;font-size: 36px;line-height: 42px; text-align:center;">Solictar Información</h3>
							</div>

							<div class="row">
								<h5><b>* haga click para enviar<b/></h3>
							</div>

							<div class="row" style="margin-top:40px;">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-blue btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="VIDA" data-tipo="1">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">VIDA</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-blue btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="Autos" data-tipo="2">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">AUTOS</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-blue btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="GastosMedicos" data-tipo="3">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">GASTOS MÉDICOS</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-blue btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="ProteccionHogar" data-tipo="4">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">PROTECCIÓN HOGAR</div>
										</div>
									</div>
								</div>

							</div>


							<div class="row" style="margin-top:40px;">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-teal btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="Creditohipotecario" data-tipo="5">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">CRÉDITO HIPOTECARIO</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-teal btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="Cuentadeahorro" data-tipo="6">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">CUENTA DE AHORRO</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-teal btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="TarjetadeCredito" data-tipo="7">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Seguro</div>
											<div class="number">TARJETA DE CRÉDITO</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
									<div class="info-box-3 bg-teal btnCursor hover-zoom-effect btnEmailEnviarSeguro" id="CreditoTelmex" data-tipo="8">
										<div class="icon">
											<i class="material-icons">info</i>
										</div>
										<div class="content">
											<div class="text">Servicio</div>
											<div class="number">CRÉDITO TELMEX</div>
										</div>
									</div>
								</div>

							</div>


						</div>

					</div>
         	</div>
			</div>
		</div>
	</div>
</section>


<!-- enviar email -->
<div class="modal fade" id="lgmEnviarEmail" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		 <div class="modal-content">
			  <div class="modal-header">
					<h4 class="modal-title" id="largeModalLabel">SOLICITAR INFORMACION <span id="lblMasInformacion"></span></h4>
			  </div>
			  <div class="modal-body">
				  <h5>Gracias por confiar en la mejor</h5>
				  <?php if ($existeCelular == 1) { ?>
					  <p>En breve se pondrá en con Teléfono de cliente, si quieren más información sobre algún producto de la página debe de validar su numero de celular registrado , "te vamos a contactar a este número <span id="lblcel"><?php echo $lblTelefonoCelular; ?></span>" o editar el número.</p>
					  <label class="label-form">Editar Nro de Teléfono Celular</label>
					  <input class="form-control" name="celphone" id="celphone" value="<?php echo $lblTelefonoCelular; ?>" />
					  <button type="button" class="btn btn-success waves-effect btnModificarTelMovilCliente"><i class="material-icons">edit</i><span>EDITAR</span></button>
				  <?php }  else { ?>
					  <p>En breve se pondrá en con Teléfono de cliente, si quieren más información sobre algún producto de la página debe de validar si tiene celular registrado. Ingresa número de teléfono y valida tu codigo</p>
						  <label class="label-form">Ingresar Nro de Teléfono Celular</label>
						  <input class="form-control" name="celphone" id="celphone" value="" />
						  <button type="button" class="btn btn-success waves-effect btnModificarTelMovilCliente"><i class="material-icons">add_circle</i><span>AGREGAR</span></button>
				  <?php }  ?>

			  </div>
			  <div class="modal-footer">
				  <input type="hidden" id="tipoProducto" name="tipoProducto" value="0"/>
					<button type="button" class="btn bg-blue waves-effect btnEnviarEmailInfo"><i style="color:white;" class="material-icons">send</i><span style="color:white;">ENVIAR</span></button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
			  </div>
		 </div>
	</div>
</div>

<?php echo $baseHTML->cargarArchivosJS('../../'); ?>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>
<!-- Wait Me Plugin Js -->
<script src="../../plugins/waitme/waitMe.js"></script>

<script src="../../js/pages/ui/tooltips-popovers.js"></script>

<!-- Custom Js -->
<script src="../../js/pages/cards/colored.js"></script>

<script src="../../plugins/jquery-validation/jquery.validate.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../../js/materialDateTimePicker.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<!-- noUISlider Plugin Js -->
<script src="../../plugins/nouislider/nouislider.js"></script>


<!-- Chart Plugins Js -->


<script>
	$(document).ready(function(){
		$('.btnEmailEnviarSeguro').click(function() {
			idTable =  $(this).attr("id");

			$('#tipoProducto').val($('#'+idTable).data('tipo'));

			$('#lblMasInformacion').html(idTable);
			$('#lgmEnviarEmail').modal();
		});


		$('#celphone').inputmask('999 9999999', {
			placeholder: '___ _______'
		});


		<?php
		if (!(isset($idcliente))) {
			$idcliente = 0;
		}
		?>
		$('.btnModificarTelMovilCliente').click(function() {
			if ($('#celphone').inputmask("isComplete")){
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: {
						accion: 'ModificarTelMovilCliente',
						celphone: $('#celphone').val(),
						idcliente: <?php echo $idcliente; ?>
					},
					//mientras enviamos el archivo
					beforeSend: function(){

					},
					//una vez finalizado correctamente
					success: function(data){

						if (data.error) {
							swal("Error!", data.mensaje, "warning");
						} else {
							swal({
									title: "Respuesta",
									text: "Se modifico correctamente su numero de teléfono celular",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

							$('#lblcel').html($('#celphone').val());
						}
					},
					//si ha ocurrido un error
					error: function(){
						$(".alert").html('<strong>Error!</strong> Actualice la pagina');
						$("#load").html('');
					}
				});
			} else {
				swal("Error!", 'Por favor debe completar el Nro de Telefono', "warning");
			}

		});

		$('.btnEnviarEmailInfo').click(function() {
			if ($('#celphone').inputmask("isComplete")){
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: {
						accion: 'insertarLead',
						refproductos: 30,
						contactado: 0,
						observaciones: '',
						origen: 1,
						refclientes: <?php echo $idcliente; ?>,
						tipo: $('#tipoProducto').val()
					},
					//mientras enviamos el archivo
					beforeSend: function(){

					},
					//una vez finalizado correctamente
					success: function(data){

						if (data.error) {
							swal("Error!", data.mensaje, "warning");
						} else {
							swal({
									title: "Respuesta",
									text: "Su información se envio correctamente, un representante se pondra en contacto con usted!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

							$('#lgmEnviarEmail').modal('toggle');
						}
					},
					//si ha ocurrido un error
					error: function(){
						$(".alert").html('<strong>Error!</strong> Actualice la pagina');
						$("#load").html('');
					}
				});
			} else {
				swal("Error!", 'Por favor debe completar el Nro de Telefono', "warning");
			}
		});



	});
</script>

</body>
<?php } ?>
</html>
