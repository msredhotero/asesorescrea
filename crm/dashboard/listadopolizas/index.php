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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../listadopolizas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Polizas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Listado Polizas";

$plural = "Listado Polizas";

if ($_SESSION['idroll_sahilices'] == 7) {

	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	$idasesor = mysql_result($resVar5,0,'idasesor');

	$resultados = $serviciosReferencias->traerVentasPorAsesorCompleto($idasesor);

	$resAsesores = $serviciosReferencias->traerClientesasesoresPorAsesorNuevoGroupBy($idasesor);
	$cadRef33 = '<option value="">-- Seleccionar --</option>';
	$cadRef33 .= $serviciosFunciones->devolverSelectBox($resAsesores,array(18),' ');
} else {
	$resultados = $serviciosReferencias->traerVentasPorUsuarioCompleto($_SESSION['usuaid_sahilices']);
}


//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbventas";

$lblCambio	 	= array('primaneta','primatotal','porcentajecomision','montocomision','fechavencimientopoliza','nropoliza','refestadoventa');
$lblreemplazo	= array('Prima Neta','Prima Total','% Comision','Monto Comision','Fecha Vencimiento de la Poliza','Nro Poliza','Estado Venta');

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
								POLIZAS
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
							<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="button-demo">

										<button type="button" class="btn bg-light-blue waves-effect btnValidacion">
											<i class="material-icons">alarm</i>
											<span>PARA VALIDAR</span>
										</button>
										<button type="button" class="btn bg-blue waves-effect btnActivas">
											<i class="material-icons">timeline</i>
											<span>ACTIVAS</span>
										</button>
										<button type="button" class="btn bg-grey waves-effect btnHistorico">
											<i class="material-icons">history</i>
											<span>HISTORICO</span>
										</button>

									</div>
								</div>
							</div>
							<?php } ?>

							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 14) || ($_SESSION['idroll_sahilices'] == 15) || ($_SESSION['idroll_sahilices'] == 7)) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<?php echo $serviciosFunciones->addInput('3,3,3,6','text','fechadesde_filtro','fechadesde_filtro','datepicker', 'Fecha Desde'); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','text','fechahasta_filtro','fechadesde_filtro','datepicker', 'Fecha Hasta'); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','select','cliente_filtro','cliente_filtro','', 'Clientes','',$cadRef33); ?>

									</div>
									<div class="col-lg-12 col-md-12">
										<button type="button" class="btn bg-red" id="filtrar">Filtrar</button>
									</div>
								</div>
							<?php } ?>



							<div class="row contActivas">
								<h4 style="text-align:center;">Activas</h4>
								<hr>
								<table id="example" class="display table dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
									<thead>
										<th>No Poliza</th>
										<th>Asegurado</th>
										<th>Vencimiento</th>
										<th>Producto</th>
										<th>Orden de Trabajo</th>
										<th>Acciones</th>
									</thead>
									<tfoot>
										<th>No Poliza</th>
										<th>Asegurado</th>
										<th>Vencimiento</th>
										<th>Producto</th>
										<th>Orden de Trabajo</th>
										<th>Acciones</th>
									</tfoot>

								</table>
							</div>

							<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
							<div class="row contValidacion">
								<h4 style="text-align:center;">Validación</h4>
								<hr>
								<table id="example2" class="display table dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
									<thead>
										<th>No Poliza</th>
										<th>Asegurado</th>
										<th>Vencimiento</th>
										<th>Producto</th>
										<th>Orden de Trabajo</th>
										<th>Acciones</th>
									</thead>
									<tfoot>
										<th>No Poliza</th>
										<th>Asegurado</th>
										<th>Vencimiento</th>
										<th>Producto</th>
										<th>Orden de Trabajo</th>
										<th>Acciones</th>
									</tfoot>

								</table>
							</div>

							<div class="row contHistorico">
								<h4 style="text-align:center;">Historico</h4>
								<hr>
								<table id="example3" class="display table dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
									<thead>
										<th>No Poliza</th>
										<th>Asegurado</th>
										<th>Vencimiento</th>
										<th>Producto</th>
										<th>Orden de Trabajo</th>
										<th>Acciones</th>
									</thead>
									<tfoot>
										<th>No Poliza</th>
										<th>Asegurado</th>
										<th>Vencimiento</th>
										<th>Producto</th>
										<th>Orden de Trabajo</th>
										<th>Acciones</th>
									</tfoot>

								</table>
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>



<div class="modal fade" id="lgmENVIAR" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-blue">
					 <h4 class="modal-title" id="largeModalLabel">MODIFICAR ESTADO DE LA POLIZA</h4>
				</div>
				<div class="modal-body">
				 <h3>¿Esta seguro que desea aceptar la poliza?</h3>
				 <input type="hidden" name="idpolizainiciada" id="idpolizainiciada" />

				</div>
				<div class="modal-footer">
					 <button type="button" class="btn waves-effect bg-green btnActivarPoliza" data-dismiss="modal">Aceptar</button>
					 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>


<div class="modal fade" id="lgmRECHAZAR" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-blue">
					 <h4 class="modal-title" id="largeModalLabel">MODIFICAR ESTADO DE LA POLIZA</h4>
				</div>
				<div class="modal-body">
				 <h3>¿Esta seguro que desea rechazar la poliza, esta se enviara al historial y la cotización volverá a emisión?</h3>
				 <input type="hidden" name="idpolizainiciadar" id="idpolizainiciadar" />

				</div>
				<div class="modal-footer">
					 <button type="button" class="btn waves-effect bg-red btnRechazarPoliza" data-dismiss="modal">Rechazar</button>
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

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>


<script>
	$(document).ready(function(){

		$("#example2").on("click",'.btnRechazar', function(){
			idTable =  $(this).attr("id");
			$('#idpolizainiciadar').val(idTable);
			$('#lgmRECHAZAR').modal();
		});

		$('.btnRechazarPoliza').click( function() {

			rechazarPolizarAgente($('#idpolizainiciadar').val());
		});

		function rechazarPolizarAgente(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'rechazarPolizarAgente',
					id: id
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: 'Rechazada correctamente',
								type: "success",
								timer: 1000,
								showConfirmButton: false
						});
						table.draw();
						table2.draw();
						table3.draw();

					} else {
						swal({
								title: "Respuesta",
								text: data.mensaje,
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


		$("#example2").on("click",'.btnAceptar', function(){
			idTable =  $(this).attr("id");
			$('#idpolizainiciada').val(idTable);
			$('#lgmENVIAR').modal();
		});

		$('.btnActivarPoliza').click( function() {

			aceptarPolizarAgente($('#idpolizainiciada').val());
		});

		function aceptarPolizarAgente(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'aceptarPolizarAgente',
					id: id
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "success",
								timer: 1000,
								showConfirmButton: false
						});
						table.draw();
						table2.draw();
						table3.draw();

					} else {
						swal({
								title: "Respuesta",
								text: data.mensaje,
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

		$('.contHistorico').hide();
		$('.contValidacion').hide();

		$('.btnActivas').click( function() {
			$('.contHistorico').hide();
			$('.contValidacion').hide();
			$('.contActivas').show();
		});

		$('.btnValidacion').click( function() {
			$('.contHistorico').hide();
			$('.contValidacion').show();
			$('.contActivas').hide();
		});

		$('.btnHistorico').click( function() {
			$('.contHistorico').show();
			$('.contValidacion').hide();
			$('.contActivas').hide();
		});

		$('#fechadesde_filtro').pickadate({
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

		$('#fechahasta_filtro').pickadate({
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
			"sAjaxSource": "../../json/jstablasajax.php?tabla=listadopolizas&estado=1",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "idcliente", "value": $('#cliente_filtro').val(), } );
				$.getJSON( sSource, aoData, function (json) {
				/* Do whatever additional processing you want on the callback, then tell DataTables */
				fnCallback(json)
				} );
			},
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

		<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
		var table2 = $('#example2').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=listadopolizas&estado=2",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "idcliente", "value": $('#cliente_filtro').val(), } );
				$.getJSON( sSource, aoData, function (json) {
				/* Do whatever additional processing you want on the callback, then tell DataTables */
				fnCallback(json)
				} );
			},
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


		var table3 = $('#example3').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=listadopolizas&estado=3",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "idcliente", "value": $('#cliente_filtro').val(), } );
				$.getJSON( sSource, aoData, function (json) {
				/* Do whatever additional processing you want on the callback, then tell DataTables */
				fnCallback(json)
				} );
			},
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

		<?php } ?>

		$('#filtrar').click( function() {
			table.draw();
			table2.draw();
			table3.draw();

		} );

		$("#example").on("click",'.btnPoliza', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','poliza.php?id=' + idTable);

		});//fin del boton modificar

		$("#example2").on("click",'.btnPoliza', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','poliza.php?id=' + idTable);

		});//fin del boton modificar

		$("#example3").on("click",'.btnPoliza', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','poliza.php?id=' + idTable);

		});//fin del boton modificar

		$(".btnRecibos").click( function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','recibos.php?id=' + idTable);

		});//fin del boton modificar

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example2").on("click",'.btnCrear', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','new.php?id=' + idTable + '&origen=1');

		});//fin del boton modificar

		$("#example3").on("click",'.btnCrear', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','new.php?id=' + idTable + '&origen=2');

		});//fin del boton modificar

		$("#example4").on("click",'.btnCrear', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','new.php?id=' + idTable + '&origen=3');

		});//fin del boton modificar




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




	});
</script>

</body>
<?php } ?>
</html>
