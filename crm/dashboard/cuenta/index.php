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
/*
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cuenta/');
*/
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cuenta",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////

$resCliente = $serviciosReferencias->traerClientesPorUsuarioCompleto($_SESSION['usuaid_sahilices']);
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

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


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								INFORMACIÓN DE LA CUENTA
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
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" id="nombre" class="form-control" value="<?php echo mysql_result($resCliente,0,'nombre'); ?>" readonly>
												<label class="form-label">Nombre</label>
											</div>
										</div>
									</div>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" id="apellidopaterno" value="<?php echo mysql_result($resCliente,0,'apellidopaterno'); ?>" class="form-control" readonly>
												<label class="form-label">Apellido Paterno</label>
											</div>
										</div>

									</div>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" id="apellidomaterno" value="<?php echo mysql_result($resCliente,0,'apellidomaterno'); ?>" class="form-control" readonly>
												<label class="form-label">Apellido Materno</label>
											</div>
										</div>

									</div>

								</div>

								<div class="row" style="padding: 5px 20px;">
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="email" id="email" value="<?php echo mysql_result($resCliente,0,'email'); ?>" class="form-control" readonly>
												<label class="form-label">Email</label>
											</div>
										</div>

									</div>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="date" id="fechanacimiento" value="<?php echo mysql_result($resCliente,0,'fechanacimiento'); ?>" class="form-control" readonly>
												<label class="form-label">Fecha Nacimiento</label>
											</div>
										</div>

									</div>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="text" id="telefonocelular" value="<?php echo mysql_result($resCliente,0,'telefonocelular'); ?>" class="form-control" readonly>
												<label class="form-label">Teléfono Celular</label>
											</div>
										</div>


									</div>

								</div>
								<hr>
								<div class="row" style="padding: 5px 20px;">
									<h5>¿Desea modificar su contraseña?</h5>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="password" id="passa" class="form-control">
												<label class="form-label">Contraseña Actual</label>
											</div>
										</div>

									</div>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="password" id="passn" class="form-control">
												<label class="form-label">Contraseña Nueva</label>
											</div>
										</div>

									</div>
									<div class="col-xs-4">
										<div class="form-group form-float">
											<div class="form-line">
												<input type="password" id="passnn" class="form-control">
												<label class="form-label">Confirmar Contraseña</label>
											</div>
										</div>

									</div>

									<button class="btn bg-orange waves-effect" type="button" id="modPassword">MODIFICAR</button>

								</div>
							</form>
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


<script>
	$(document).ready(function(){


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

		$('#modPassword').click(function() {
			modPassword();
		});

		function modPassword() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modPassword',
					passa: $('#passa').val(),
					passn: $('#passn').val(),
					passnn: $('#passnn').val()
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: "Contraseña modificada con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
					} else {
						swal("Error!", data.mensaje, "warning");
						$('#passa').val('');
						$('#passn').val('');
						$('#passnn').val('');

					}
				},
				//si ha ocurrido un error
				error: function(){
					swal("Error!", 'Error! Actualice la pagina', "warning");
				}
			});

		}


	});
</script>








</body>
<?php } ?>
</html>
