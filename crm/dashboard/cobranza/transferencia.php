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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cobranza/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Recibos de Pago",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Recibos de Pago";

$plural = "Recibos de Pagos";

$eliminar = "eliminarEspecialidades";

$insertar = "insertarTransferencias";

$modificar = "modificarPeriodicidadventasdetalle";

//////////////////////// Fin opciones ////////////////////////////////////////////////

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbtransferencias";

$lblCambio	 	= array('nrotransferencia','fechatransaccion');
$lblreemplazo	= array('Nro de Referencia','Fecha Transaccion');


$refdescripcion = array();
$refCampo 	=  array();

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

//asesor rosales david
$idasesor = 31;

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

	<link rel="stylesheet" type="text/css" href="../../css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="../../css/classic.date.css"/>


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
								CARGAR TRANSACCION DE MULTIPLES RECIBOS
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
									<?php echo $frmUnidadNegocios; ?>
								</div>

								<hr>
								<h4>Busqueda de Recibos</h4>
								<hr>
								<div class="row">
									<div class="col-xs-8">
										<h4>Seleccionar</h4>
										<table id="example" class="display table " style="width:100%">
											<thead>
												<tr>
													<th>Cliente</th>
													<th>Nro Poliza</th>
													<th>Fecha Vencimiento</th>
													<th>Nro Recibo</th>
													<th>Estado</th>
													<th>Monto</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Cliente</th>
													<th>Nro Poliza</th>
													<th>Fecha Vencimiento</th>
													<th>Nro Recibo</th>
													<th>Estado</th>
													<th>Monto</th>
													<th>Acciones</th>
												</tr>
											</tfoot>
										</table>
									</div>
									<div class="col-xs-4">
										<h4>Recibos Seleccionados</h4>
										<table id="example2" class="display table " style="width:100%">
											<thead>
												<tr>
													<th>Nro Poliza</th>
													<th>Nro Recibo</th>
													<th>Monto</th>
													<th>Acciones</th>
												</tr>
											</thead>
											<tbody id="lstRecibos">

											</tbody>
											<tfoot>
												<tr>
													<th>Nro Poliza</th>
													<th>Nro Recibo</th>
													<th>Monto</th>
													<th>Acciones</th>
												</tr>
												<tr>
													<th>Total:</th>
													<th><input class="form-control" type="text" name="totalRecibos" id="totalRecibos" readonly/></th>
													<th>Diferencia</th>
													<th><input class="form-control" type="text" name="diferencia" id="diferencia" readonly/></th>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>


								<div class="row">

									<div class="modal-footer">
										<button type="button" class="btn btn-info waves-effect btnVolverFiltro" data-ir="index" data-referencia="0"><i class="material-icons">reply</i><span>VOLVER</span></button>
										<button id="btnGuardar" type="submit" class="btn btn-success waves-effect nuevo">GUARDAR</button>
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

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>


<script>
	$(document).ready(function(){

		var puedeSeguir=1;

		$('#fechacrea').val('marcos');
		$('#usuariocrea').val('marcos');

		function buscarEnTabla(busqueda) {
			var buscar = 1;
			$( "#lstRecibos tr" ).each(function() {
				idTable =  $(this).attr("id");

				if (idTable == busqueda) {
					buscar = 0;
					return false;
				}

			});

			return buscar;
		}

		function sumarTabla() {
			var total = 0;
			$( "#lstRecibos tr td .inputtotal" ).each(function() {
				total += parseFloat($(this).val());
			});

			$('#totalRecibos').val(total);
			$('#diferencia').val( $('#monto').val() - total);

			if (($('#diferencia').val()==0) && ($('#totalRecibos').val()>0) && (puedeSeguir == 1)) {
				$('#btnGuardar').show();
			} else {
				$('#btnGuardar').hide();
			}
		}



		sumarTabla();

		$('#monto').change(function() {
			sumarTabla();
		});

		$("#example2").on("click",'.btnBorrar', function(){
			idTable3 =  $(this).data("id");

			$('.tr' + idTable3).remove();

			sumarTabla();
		});


		$("#example").on("click",'.btnCargar', function(){
			idTable2 =  $(this).attr("id");
			var puedeCargar = buscarEnTabla(idTable2);

			if (puedeCargar == 1) {
				traerPeriodicidadventasdetallePorId(idTable2);
			}
		});

		function traerPeriodicidadventasdetallePorId(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'traerPeriodicidadventasdetallePorId',
					id: id
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {

						$('#lstRecibos').append('<tr class="tr' + data.datos[0].id + '" id="' + data.datos[0].id + '"><td>' + data.datos[0].nropoliza + '</td><td>' + data.datos[0].nrorecibo + '</td><td><input type="text" class="form-control inputtotal" value="' + data.datos[0].monto + '"/></td><td><button type="button" class="btn bg-red btn-circle waves-effect waves-circle waves-float btnBorrar" data-id="' + data.datos[0].id + '"><i class="material-icons">remove</i></button></td><input type="hidden" name="recibo' + data.datos[0].id + '" value="' + data.datos[0].id + '"/></tr>');

						sumarTabla();
					} else {
						swal({
							title: "Respuesta",
							text: 'No se encontraron datos',
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

		$('#fechatransaccion').pickadate({
			format: 'yyyy-mm-dd',
			labelMonthNext: 'Siguiente mes',
			labelMonthPrev: 'Previo mes',
			labelMonthSelect: 'Selecciona el mes del año',
			labelYearSelect: 'Selecciona el año',
			selectMonths: true,
			selectYears: 100,
			today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		});

		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "asc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cobrostransferencias&idasesor=<?php echo $idasesor; ?>",
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
									text: "Registro Creado con exito!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

							puedeSeguir = 0;

							$('#btnGuardar').hide();
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
