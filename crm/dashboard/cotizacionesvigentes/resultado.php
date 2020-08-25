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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cotizacionesvigentes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cotizaciones Vigentes",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Cotizacion";

$plural = "Cotizaciones";

$eliminar = "eliminarCotizaciones";

$insertar = "insertarCotizaciones";

$modificar = "modificarCotizaciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$id = $_GET['id'];

if ($id == 0) {
	header('Location: index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$idCliente = mysql_result($resultado,0,'refclientes');

$cliente = mysql_result($resultado,0,'cliente');
$producto = mysql_result($resultado,0,'producto');
$folio = mysql_result($resultado,0,'folio');
$idestado = mysql_result($resultado,0,'refestadocotizaciones');
$color = mysql_result($resultado,0,'color');
$estado = mysql_result($resultado,0,'estado');
$idestado2 = mysql_result($resultado,0,'refestados');
$monto = mysql_result($resultado,0,'primatotal') == '0' ? '(sin valor)' : mysql_result($resultado,0,'primatotal');

$tabla 			= "dbcotizaciones";

if ($idestado == 1) {
	header('Location: new.php?id='.$id);
} else {

}

switch ($idestado2) {
	case 1:
		header('Location: new.php?id='.$id);
	break;
	case 2:
		header('Location: ../index.php');
	break;
	case 4:
		header('Location: ../index.php');
	break;
}

switch ($idestado) {
	case 8:
		$color = 'bg-blue';
		$estado = 'Entregada';
	break;
	case 9:
		$color = 'bg-success';
		$estado = 'Aceptada';
	break;
	case 10:
		$color = 'bg-amber';
		$estado = 'En ajuste';
	break;
	case 11:
		$color = 'bg-red';
		$estado = 'Rechazada';
	break;
}

$resDocumentacionesCargadas = $serviciosReferencias->traerDocumentacioncotizacionesPorIdCompletoPorCotizacion($id);

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
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../', ''); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix">

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header <?php echo $color; ?>">
							<h2>
								COTIZACION FOLIO: <?php echo $folio; ?>
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
							<form class="formulario frmNuevo" role="form" id="sign_in">

								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label">PRODUCTO COTIZADO </label>
										<div class="form-group input-group">
											<div class="form-line">
												<p><?php echo $producto; ?></p>
											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label">MONTO </label>
										<div class="form-group input-group">
											<div class="form-line">
												<p>$MX <?php echo $monto; ?></p>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<ul class="list-group">
											<li class="list-group-item active">Lista de Archivos Cargados de la cotización</li>
										<?php while ($row = mysql_fetch_array($resDocumentacionesCargadas)) { ?>
											<li class="list-group-item"><?php echo $row['documentacion']; ?> <span class="badge bg-cyan"><a href="../../archivos/cotizaciones/<?php echo $id; ?>/<?php echo $row['carpeta']; ?>/<?php echo $row['archivo']; ?>" target="_blank" style="color:white; text-decoration:none;">VER</a></span></li>

										<?php } ?>
										</ul>
									</div>
								</div>

								<div class="row" style="margin-top:20px;">

									<div class="modal-footer btnacciones">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

											<?php if (($idestado == 8) && ($idestado2 == 3)) { ?>
											<button type="button" class="btn btn-success waves-effect btnAceptarCotizacion">ACEPTO COTIZACION</button>
											<button type="button" class="btn btn-warning waves-effect btnRequieroAjustes">REQUIERO AJUSTES</button>
											<button type="button" class="btn btn-danger waves-effect btnRechazarCotizacion">RECHAZAR</button>
											<?php
											} else {
											?>
											<button type="button" class="btn <?php echo  ($color); ?> waves-effect">USTED <?php echo  strtoupper($estado); ?> SU COTIZACION</button>
											<?php if ($idestado2 == 2) { ?>
											<button type="button" class="btn bg-blue waves-effect btnDocumentacion">SUBA LA DOCUMENTACION REQUERIDA</button>

											<?php }} ?>


										</div>
				               </div>
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

<div class="modal fade" id="lgmVigencias" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-orange">
					<p>IMPORTANTE</p>
				</div>
				<div class="modal-body">
				<div class="row">
					<h4>En breve nos contactaremos contigo!!</h4>
					<hr>
					<p>Puedes contactarnos en el Tel fijo: <b><span style="color:#5DC1FD;">55 51 35 02 59</span></b></p>
					<p>Correo: <a href="mailto:ventas@asesorescrea.com" style="color:#5DC1FD !important;"><b>ventas@asesorescrea.com</b></a></p>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>

		  </div>
	 </div>
</div>


<div class="modal fade" id="lgmRechazo" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-red">
					<p>IMPORTANTE</p>
				</div>
				<div class="modal-body">
				<div class="row">
					<h4>Por favor ingrese los motivos del rechazo, para poderte afrocer un mejor servicio!!</h4>
					<div class="row">
					<div class="col-xs-6">
						<select class="form-control" id="motivosrechazo" name="motivosrechazo">
							<option value="Precio">Precio</option>
							<option value="Mal Servicio">Mal Servicio</option>
							<option value="Otro">Otro</option>
						</select>
					</div></div>
					<hr>
					<p>Puedes contactarnos en el Tel fijo: <b><span style="color:#5DC1FD;">55 51 35 02 59</span></b></p>
					<p>Correo: <a href="mailto:ventas@asesorescrea.com" style="color:#5DC1FD !important;"><b>ventas@asesorescrea.com</b></a></p>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success waves-effect btnRechazaCotizacionCliente" data-dismiss="modal">ENVIAR</button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>

		  </div>
	 </div>
</div>

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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

	 <script src="../../js/picker.js"></script>
	 <script src="../../js/picker.date.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>
	$(document).ready(function(){

		$('.btnRequieroAjustes').click(function() {
			$('#lgmVigencias').modal();
			enviarNorificacion('cotizacionAjustes');
		});

		$('.btnRechazarCotizacion').click(function() {
			$('#lgmRechazo').modal();
			//enviarNorificacion('cotizacionRechazo');
		});

		function enviarNorificacion(interes) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'generaNotificacion',
					id: <?php echo $id; ?>,
					interes: interes
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					location.reload();
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



		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$("#example").on("click",'.btnEliminarDefinitivo', function(){
			idTable =  $(this).attr("id");
			$('#ideliminarDefinitivo').val(idTable);
			$('#lgmEliminarDefinitivo').modal();
		});//fin del boton eliminar


		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});

		$('.eliminarDefinitivo').click(function() {
			frmAjaxEliminarDefinitivo($('#ideliminarDefinitivo').val());
		});

		$(".btnModificar").click( function(){
			idTable =  $(this).attr("id");
			$('#estadoactual').val(idTable);
			$('.btnContinuar').click();
		});//fin del boton modificar

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$('.btnDocumentacion').click(function() {
			$(location).attr('href','subirdocumentacionie.php?id=<?php echo $id; ?>');
		});

		function refrescar(ruta){
	    //Actualiza la página
	    $(location).attr('href',ruta);
	  }

		$('.btnAceptarCotizacion').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'aceptarClienteCotizacion', id: <?php echo $id; ?>},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: "Cotizacion Aceptado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						setTimeout(refrescar(data.ruta), 2500);
					} else {
						swal({
								title: "Respuesta",
								text: data,
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
		});

		$('.btnRechazaCotizacionCliente').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'rechazaCotizacionCliente',
					motivosrechazo: $('#motivosrechazo').val(),
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnacciones').hide();
				},
				//una vez finalizado correctamente
				success: function(data){
					enviarNorificacion('cotizacionRechazo');

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
		});

	});
</script>

</body>
<?php } ?>
</html>
