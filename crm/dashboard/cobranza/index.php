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

$insertar = "insertarEspecialidades";

$modificar = "modificarPeriodicidadventasdetalle";

//////////////////////// Fin opciones ////////////////////////////////////////////////


$tabla 			= "dbperiodicidadventaspagos";

if (($_SESSION['idroll_sahilices'] == 17) || ($_SESSION['idroll_sahilices'] == 18)) {
	$jstabla = 'cobranzainbursa';
} else {
	$jstabla = 'cobranzaestados';
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
								<?php echo strtoupper($plural); ?>
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

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="button-demo">

										<?php if ($_SESSION['idroll_sahilices'] == 16) { ?>
											<button type="button" class="btn bg-blue waves-effect btnVigente">
												<i class="material-icons">timeline</i>
												<span>PENDIENTES DE PAGO</span>
											</button>
										<?php } else {  ?>
											<?php if (($_SESSION['idroll_sahilices'] == 17) || ($_SESSION['idroll_sahilices'] == 18)) { ?>
											<button type="button" class="btn bg-green waves-effect btnHistorico">
												<i class="material-icons">history</i>
												<span>PROCESO DE APLICACION</span>
											</button>
											<button type="button" class="btn bg-red waves-effect btnDevueltos">
												<i class="material-icons">assignment_late</i>
												<span>DEVOLUCIONES</span>
											</button>


										<?php } else { ?>

											<button type="button" class="btn bg-blue waves-effect btnVigente">
												<i class="material-icons">timeline</i>
												<span>PENDIENTES DE PAGO</span>
											</button>
											<button type="button" class="btn bg-green waves-effect btnHistorico">
												<i class="material-icons">history</i>
												<span>PROCESO DE APLICACION</span>
											</button>
											<button type="button" class="btn bg-red waves-effect btnDevueltos">
												<i class="material-icons">assignment_late</i>
												<span>DEVOLUCIONES</span>
											</button>

											<button type="button" class="btn bg-orange waves-effect btnValidar">
												<i class="material-icons">format_shapes</i>
												<span>PENDIENTES DE VALIDAR</span>
											</button>

										<?php } } ?>


										<?php
										//buscar el suuario de mas seguros
										//if ($_SESSION['usuaid_sahilices'] == 154) {
										?>
										<button type="button" class="btn bg-blue-grey waves-effect btnTransferencias btnVolverFiltro" data-ir="transferencia" data-referencia="0">
											<i class="material-icons">compare_arrows</i>
											<span>TRANSFERENCIAS</span>
										</button>
										<?php //} ?>


										</div>
									</div>
								</div>



								<?php if (($_SESSION['idroll_sahilices'] != 17) || ($_SESSION['idroll_sahilices'] != 18)) { ?>
								<div class="row contActuales" style="padding: 5px 20px;">
									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Nro Poliza</th>
												<th>Fecha Limite</th>
												<th>Nro Cliente</th>
												<th>Id Cliente Inbursa</th>
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
												<th>Fecha Limite</th>
												<th>Nro Cliente</th>
												<th>Id Cliente Inbursa</th>
												<th>Nro Recibo</th>
												<th>Estado</th>
												<th>Monto</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>
								<?php }  ?>

								<?php if ($_SESSION['idroll_sahilices'] != 16) { ?>
								<div class="row contPagados" style="padding: 5px 20px;">
									<table id="example2" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Nro Poliza</th>
												<th>Fecha Vencimiento</th>
												<th>Nro Cliente</th>
												<th>Id Cliente Inbursa</th>
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
												<th>Nro Cliente</th>
												<th>Id Cliente Inbursa</th>
												<th>Nro Recibo</th>
												<th>Estado</th>
												<th>Monto</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>
								<div class="row contDevueltos" style="padding: 5px 20px;">
									<table id="example3" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Nro Poliza</th>
												<th>Fecha Vencimiento</th>
												<th>Nro Cliente</th>
												<th>Id Cliente Inbursa</th>
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
												<th>Nro Cliente</th>
												<th>Id Cliente Inbursa</th>
												<th>Nro Recibo</th>
												<th>Estado</th>
												<th>Monto</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>
								<?php }  ?>

								<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 2) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 11) ) { ?>
									<div class="row contValidar" style="padding: 5px 20px;">
										<table id="example4" class="display table " style="width:100%">
											<thead>
												<tr>
													<th>Cliente</th>
													<th>Nro Poliza</th>
													<th>Fecha Vencimiento</th>
													<th>Nro Cliente</th>
													<th>Id Cliente Inbursa</th>
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
													<th>Nro Cliente</th>
													<th>Id Cliente Inbursa</th>
													<th>Nro Recibo</th>
													<th>Estado</th>
													<th>Monto</th>
													<th>Acciones</th>
												</tr>
											</tfoot>
										</table>
									</div>
									<?php }  ?>

							</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!-- MODIFICAR -->
	<form class="formulario frmModificar" role="form" id="sign_in">
		<div class="modal fade" id="lgmModificar" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
						<div class="modal-header">
							 <h4 class="modal-title" id="largeModalLabel">MODIFICAR <?php echo strtoupper($singular); ?></h4>
						</div>
						<div class="modal-body">
							<div class="row frmAjaxModificar">

							</div>
						</div>
						<div class="modal-footer">

							 <button type="submit" class="btn btn-success waves-effect modificar">MODIFICAR</button>
							 <button type="button" class="btn bg-orange waves-effect btnAvisar">
								 AVISAR PAGO A INBURSA
							 </button>
							 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>
				  </div>
			 </div>
		</div>
		<input type="hidden" id="accion" name="accion" value="<?php echo $modificar; ?>"/>
	</form>


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

		$('.btnAvisar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'avisarInbursa',
					idventa: $('.frmAjaxModificar #refperiodicidadventas').val()
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se genero la alerta correctamente', "success");

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
		});

		<?php if (($_SESSION['idroll_sahilices'] == 17) || ($_SESSION['idroll_sahilices'] == 18)) { ?>
			$('.contDevueltos').hide();
			$('.contActuales').hide();

		<?php } else {  ?>

			$('.contDevueltos').hide();
			$('.contPagados').hide();

		<?php } ?>

		$('.contValidar').hide();

		$('.btnDevueltos').click(function() {
			$('.contActuales').hide();
			$('.contPagados').hide();
			$('.contDevueltos').show();
			$('.contValidar').hide();
		});

		$('.btnHistorico').click(function() {
			$('.contActuales').hide();
			$('.contPagados').show();
			$('.contDevueltos').hide();
			$('.contValidar').hide();
		});

		$('.btnVigente').click(function() {
			$('.contActuales').show();
			$('.contPagados').hide();
			$('.contDevueltos').hide();
			$('.contValidar').hide();
		});

		$('.btnValidar').click(function() {
			$('.contActuales').hide();
			$('.contPagados').hide();
			$('.contDevueltos').hide();
			$('.contValidar').show();
		});

		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cobranza",
			"order": [[ 2, "asc" ]],
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

		var table2 = $('#example2').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=<?php echo $jstabla; ?>&estados=2,7",
			"order": [[ 2, "asc" ]],
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
			},
		   "rowCallback": function( row, data, index ) {

			  if (data[6] == 'Proceso de Aplicacion') {

				  $('td', row).css('background-color', '#F62121');
				  $('td', row).css('color', 'white');
			  }
		   }
		});


		var table3 = $('#example3').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cobranzaestados&estados=4,6",
			"order": [[ 2, "asc" ]],
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


		var table4 = $('#example4').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cobranzaestados&estados=999",
			"order": [[ 2, "asc" ]],
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


		$("#example").on("click",'.btnRecibo', function(){
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?id=" + idTable;
			$(location).attr('href',url);
		});

		$("#example").on("click",'.btnPagar', function(){
			idTable =  $(this).attr("id");
			url = "metodopago.php?id=" + idTable;
			$(location).attr('href',url);
		});



		$("#example2").on("click",'.btnRecibo', function(){
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?id=" + idTable;
			$(location).attr('href',url);
		});

		$("#example4").on("click",'.btnRecibo', function(){
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?id=" + idTable;
			$(location).attr('href',url);
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
				data: {accion: 'frmAjaxModificar',tabla: 'dbperiodicidadventasdetalle', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxModificar').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxModificar').html(data);


						$('.frmAjaxModificar .frmContusuariocrea').hide();
						$('.frmAjaxModificar .frmContusuariomodi').hide();
						$('.frmAjaxModificar .frmContfechacrea').hide();
						$('.frmAjaxModificar .frmContfechamodi').hide();
						$('.frmAjaxModificar .frmContrefformapago').hide();
						$('.frmAjaxModificar .frmContfechapagoreal').hide();

						$('.frmAjaxModificar .frmContfechapago').hide();

						$('.frmAjaxModificar #primaneta').number( true, 2 ,'.','');
						$('.frmAjaxModificar #montototal').number( true, 2,'.','' );
						$('.frmAjaxModificar #montocomision').number( true, 2,'.','' );
						$('.frmAjaxModificar #porcentajecomision').number( true, 2,'.','' );

						$('.frmAjaxModificar #fechapago').pickadate({
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

						$('.frmAjaxModificar #fechavencimiento').pickadate({
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

						$('.frmAjaxModificar #fechafinservicio').pickadate({
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


		$("#example2").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar

		$("#example4").on("click",'.btnModificar', function(){
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
									text: "Registro Creado con exito!!",
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

							$('#lgmModificar').modal('hide');
							table.ajax.reload();
							table2.ajax.reload();
							table3.ajax.reload();
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
