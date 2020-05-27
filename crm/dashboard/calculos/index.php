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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../bonogestion/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Bono de Gestion",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Bono de Gestion";

$plural = "Bono de Gestion";

$eliminar = "eliminarBonogestion";

$insertar = "insertarBonogestion";

$modificar = "modificarBonogestion";

//////////////////////// Fin opciones ////////////////////////////////////////////////

/////////////////// valores bono de gestion /////////////////////////////////
$existe = $serviciosReferencias->existeBono();
if ($existe == 0) {
	$id = $serviciosReferencias->insertarBonogestion(0,0,0);
} else {
	$res = $serviciosReferencias->traerBonogestion();
	$id = mysql_result($res,0,0);
}

$resultado = $serviciosReferencias->traerBonogestionPorId($id);

$calcBonoSeguros = mysql_result($resultado,0,'bonoseguros');
$calcBonoBanca = mysql_result($resultado,0,'bonobanca');
$calcBonoAfore = mysql_result($resultado,0,'bonoafore');

/////////////////// fin valores bonos gestion /////////////////////////////////


/////////////////// valores bono de reclutamiento /////////////////////////////////

$resBR = $serviciosReferencias->calcularImporteBonoReclutamiento();

$calcBonoReclutamiento = mysql_result($resBR,0,0);

/////////////////// fin valores bonos gestion /////////////////////////////////


/////////////// basico Primas Netas y Bono Agente ////////////////////////////////

$calcPrimaNeta = $serviciosReferencias->calcularPrimasNetas();

$calcComisionAgente = $serviciosReferencias->calcularComisionAgente();

//////////////// fin basico PN y CA   ////////////////////////////////////////////


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
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="info-box bg-green hover-expand-effect">
						<div class="icon">
							<i class="material-icons">monetization_on</i>
						</div>
						<div class="content">
							<div class="text">PRIMA NETA</div>
							<div class="number count-to" data-from="0" data-to=20 data-speed="1000" data-fresh-interval="20"><?php echo number_format($calcPrimaNeta, 2, ',', '.'); ?></div>
						</div>
					</div>
				</div>

				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="info-box bg-blue hover-expand-effect">
						<div class="icon">
							<i class="material-icons">monetization_on</i>
						</div>
						<div class="content">
							<div class="text">COMISION AGENTE</div>
							<div class="number count-to" data-from="0" data-to=20 data-speed="1000" data-fresh-interval="20"><?php echo number_format($calcComisionAgente, 2, ',', '.'); ?></div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<h4 style="margin-left:20px;">Bono Reclutamiento</h4>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="info-box bg-cyan hover-expand-effect">
						<div class="icon">
							<i class="material-icons">monetization_on</i>
						</div>
						<div class="content">
							<div class="text">BONO RECLUTAMIENTO</div>
							<div class="number count-to" data-from="0" data-to=20 data-speed="1000" data-fresh-interval="20"><?php echo number_format($calcBonoReclutamiento, 2, ',', '.'); ?></div>
						</div>
					</div>
				</div>

			</div>

			<div class="row">
				<h4 style="margin-left:20px;">Bono Gestion</h4>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="info-box bg-purple hover-expand-effect">
						<div class="icon">
							<i class="material-icons">monetization_on</i>
						</div>
						<div class="content">
							<div class="text">SEGUROS <?php echo $calcBonoSeguros; ?> %</div>
							<div class="number count-to" data-from="0" data-to=20 data-speed="1000" data-fresh-interval="20"><?php echo number_format(($calcPrimaNeta * $calcBonoSeguros / 100), 2, ',', '.'); ?></div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="info-box bg-indigo hover-expand-effect">
						<div class="icon">
							<i class="material-icons">monetization_on</i>
						</div>
						<div class="content">
							<div class="text">BANCA <?php echo $calcBonoBanca; ?> %</div>
							<div class="number count-to" data-from="0" data-to=20 data-speed="1000" data-fresh-interval="20"><?php echo number_format(($calcComisionAgente * $calcBonoBanca / 100), 2, ',', '.'); ?></div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="info-box bg-blue-grey hover-expand-effect">
						<div class="icon">
							<i class="material-icons">monetization_on</i>
						</div>
						<div class="content">
							<div class="text">AFORE <?php echo $calcBonoAfore; ?> %</div>
							<div class="number count-to" data-from="0" data-to=20 data-speed="1000" data-fresh-interval="20"><?php echo number_format(($calcComisionAgente * $calcBonoAfore / 100), 2, ',', '.'); ?></div>
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

		$('#bonoseguros').number( true, 5 );
		$('#bonobanca').number( true, 5 );
		$('#bonoafore').number( true, 5 );


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


		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=especialidades",
			"language": {
				"emptyTable":     "No hay datos cargados",
				"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
				"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
				"infoFiltered":   "(filtrados del total de _MAX_ filas)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Mostrar _MENU_ filas",
				"loadingRecords": "Cargando...",
				"processing":     "Procesando...",
				"search":         "Buscar:",
				"zeroRecords":    "No se encontraron resultados",
				"paginate": {
					"first":      "Primero",
					"last":       "Ultimo",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			}
		});

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});


		function frmAjaxModificar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'frmAjaxModificar',tabla: '<?php echo $tabla; ?>', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxModificar').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxModificar').html(data);
					} else {
						swal("Error!", data, "warning");

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


		function frmAjaxEliminar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: '<?php echo $eliminar; ?>', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
						swal({
								title: "Respuesta",
								text: "Registro Eliminado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						$('#lgmEliminar').modal('toggle');
						table.ajax.reload();
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

		}

		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});

		$("#example").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar


		$('.frmNuevo').submit(function(e){

			e.preventDefault();
			if ($('#sign_in')[0].checkValidity()) {
				//información del formulario
				var formData = new FormData($(".formulario")[0]);
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

							$('#lgmNuevo').modal('hide');
							$('#unidadnegocio').val('');
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


		$('.frmModificar').submit(function(e){

			e.preventDefault();
			if ($('.frmModificar')[0].checkValidity()) {

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
