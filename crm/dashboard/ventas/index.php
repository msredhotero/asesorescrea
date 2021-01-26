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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../ventas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Polizas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Poliza";

$plural = "Polizas";

$eliminar = "eliminarVentas";

$insertar = "insertarVentas";

$modificar = "modificarVentas";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbventas";

$lblCambio	 	= array('primaneta','primatotal','porcentajecomision','montocomision','fechavencimientopoliza','nropoliza','refestadoventa');
$lblreemplazo	= array('Prima Neta','Prima Total','% Comision','Monto Comision','Fecha Vencimiento de la Poliza','Nro Poliza','Estado Venta');

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resAsesores = $serviciosReferencias->traerAsesores();
$cadRef33 = '<option value="">-- Seleccionar --</option>';
$cadRef33 .= $serviciosFunciones->devolverSelectBox($resAsesores,array(3,4,2),' ');

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
											<button type="button" class="btn bg-teal waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>CARGAR A PARTIR DE UNA COTIZACION</span>
											</button>
											<button type="button" class="btn bg-green waves-effect btnNuevoAux">
												<i class="material-icons">add</i>
												<span>CARGAR DIRECTAMENTE</span>
											</button>
											<button type="button" class="btn bg-light-blue waves-effect btnIniciada">
												<i class="material-icons">alarm</i>
												<span>INICIADA</span>
											</button>
											<button type="button" class="btn bg-blue waves-effect btnVigente">
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

							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 11) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 14) || ($_SESSION['idroll_sahilices'] == 15)) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<?php echo $serviciosFunciones->addInput('3,3,3,6','text','fechadesde_filtro','fechadesde_filtro','datepicker', 'Fecha Desde'); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','text','fechahasta_filtro','fechadesde_filtro','datepicker', 'Fecha Hasta'); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','select','agente_filtro','agente_filtro','', 'Agente','',$cadRef33); ?>

									</div>
									<div class="col-lg-12 col-md-12">
										<button type="button" class="btn bg-red" id="filtrar">Filtrar</button>
									</div>
								</div>
							<?php } ?>


								<div class="row contIniciada" style="padding: 5px 20px;">
									<h4>POLIZAS INICIADAS</h4>
									<table id="example5" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>P. Neta</th>
												<th>P. Total</th>
												<th>Folio TYS</th>
												<th>Fecha Venc.</th>
												<th>Nro Poliza</th>
												<th>Dias Gestión</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>P. Neta</th>
												<th>P. Total</th>
												<th>Folio TYS</th>
												<th>Fecha Venc.</th>
												<th>Nro Poliza</th>
												<th>Dias Gestión</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>

								<div class="row contActuales" style="padding: 5px 20px;">
									<h4>POLIZAS ACTIVAS</h4>
									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>P. Neta</th>
												<th>P. Total</th>
												<th>Folio TYS</th>
												<th>Fecha Venc.</th>
												<th>Nro Poliza</th>
												<th>Periodicidad Pago</th>
												<th>Metodo de Pago</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>P. Neta</th>
												<th>P. Total</th>
												<th>Folio TYS</th>
												<th>Fecha Venc.</th>
												<th>Nro Poliza</th>
												<th>Periodicidad Pago</th>
												<th>Metodo de Pago</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>

								<div class="row contHistorico" style="padding: 5px 20px;">
									<h4>HISTORICO POLIZAS</h4>
									<table id="example6" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>P. Neta</th>
												<th>P. Total</th>
												<th>Folio TYS</th>
												<th>Fecha Venc.</th>
												<th>Nro Poliza</th>
												<th>Estado</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>P. Neta</th>
												<th>P. Total</th>
												<th>Folio TYS</th>
												<th>Fecha Venc.</th>
												<th>Nro Poliza</th>
												<th>Estado</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
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


<!-- NUEVO -->
	<form class="formulario" role="form" id="sign_in">
	   <div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
	       <div class="modal-dialog modal-lg" role="document">
	           <div class="modal-content">
	               <div class="modal-header">
	                   <h4 class="modal-title" id="largeModalLabel">CREAR <?php echo strtoupper($singular); ?></h4>
	               </div>
	               <div class="modal-body">
							<div class="row">
	                  	<h4>Seleccione el origen de la Venta</h4>
								<ul class="nav nav-tabs tab-nav-right" role="tablist">
									<li role="presentation" class="activo"><a href="#tabventaonline" data-toggle="tab">VENTA ONLINE</a></li>
									<li role="presentation"><a href="#tabcotizacionesagentes" data-toggle="tab">COTIZACIONES</a></li>

								</ul>

								<div class="tab-content">
									<div role="tabpanel" class="tab-pane fade in active" id="tabventaonline">
										<div class="row contVentaOnline" style="padding: 5px 20px;">
											<table id="example2" class="display table " style="width:100%">
												<thead>
													<tr>
														<th>Cliente</th>
														<th>Producto</th>
														<th>Asesor</th>
														<th>Asociado</th>
														<th>Fecha</th>
														<th>Estado</th>
														<th>Folio</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Cliente</th>
														<th>Producto</th>
														<th>Asesor</th>
														<th>Asociado</th>
														<th>Fecha</th>
														<th>Estado</th>
														<th>Folio</th>
														<th>Acciones</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>

									<div role="tabpanel" class="tab-pane fade" id="tabcotizacionesagentes">
										<div class="row contCotizacionesAgentes" style="padding: 5px 20px;">
											<table id="example3" class="display table " style="width:100%">
												<thead>
													<tr>
														<th>Cliente</th>
														<th>Producto</th>
														<th>Asesor</th>
														<th>Asociado</th>
														<th>Fecha</th>
														<th>Estado</th>
														<th>Folio</th>
														<th>Acciones</th>
													</tr>
												</thead>
												<tfoot>
													<tr>
														<th>Cliente</th>
														<th>Producto</th>
														<th>Asesor</th>
														<th>Asociado</th>
														<th>Fecha</th>
														<th>Estado</th>
														<th>Folio</th>
														<th>Acciones</th>
													</tr>
												</tfoot>
											</table>
										</div>
									</div>



									<div role="tabpanel" class="tab-pane fade" id="tabrenovaciones">

									</div>

								</div><!-- FIN DEL TABCONTONT -->

							</div>
	               </div>
	               <div class="modal-footer">
	                   <button type="submit" class="btn btn-primary waves-effect nuevo">GUARDAR</button>
	                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
	               </div>
	           </div>
	       </div>
	   </div>
		<input type="hidden" id="accion" name="accion" value="<?php echo $insertar; ?>"/>
	</form>

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
		                  <button type="submit" class="btn btn-warning waves-effect modificar">MODIFICAR</button>
		                  <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
		               </div>
		           </div>
		       </div>
		   </div>
			<input type="hidden" id="accion" name="accion" value="<?php echo $modificar; ?>"/>
		</form>


	<!-- ELIMINAR -->
		<form class="formulario" role="form" id="sign_in">
		   <div class="modal fade" id="lgmEliminar" tabindex="-1" role="dialog">
		       <div class="modal-dialog modal-lg" role="document">
		           <div class="modal-content">
		               <div class="modal-header">
		                   <h4 class="modal-title" id="largeModalLabel">ELIMINAR <?php echo strtoupper($singular); ?></h4>
		               </div>
		               <div class="modal-body">
										 <p>¿Esta seguro que desea eliminar el registro?</p>
										 <small>* Si este registro esta relacionado con algun otro dato no se podría eliminar.</small>
		               </div>
		               <div class="modal-footer">
		                   <button type="button" class="btn btn-danger waves-effect eliminar">ELIMINAR</button>
		                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
		               </div>
		           </div>
		       </div>
		   </div>
			<input type="hidden" id="accion" name="accion" value="<?php echo $eliminar; ?>"/>
			<input type="hidden" name="ideliminar" id="ideliminar" value="0">
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

		$('.frmContrefmotivorechazopoliza').hide();

		$('.contHistorico').hide();
		$('.contIniciada').hide();

		$('.btnIniciada').click(function() {
			$('.contHistorico').hide();
			$('.contIniciada').show();
			$('.contActuales').hide();
		});

		$('.btnHistorico').click(function() {
			$('.contHistorico').show();
			$('.contIniciada').hide();
			$('.contActuales').hide();
		});

		$('.btnVigente').click(function() {
			$('.contHistorico').hide();
			$('.contIniciada').hide();
			$('.contActuales').show();
		});

		$('.btnCalcularM').click(function() {
			calcularBonoMonto();
		});

		$('.btnCalcularP').click(function() {
			calcularBonoPorcentaje();
		});

		function calcularBonoPorcentaje() {
			if (($('.frmAjaxModificar #montocomision').val() > 0) && $('.frmAjaxModificar #primaneta').val() > 0) {
				$('.frmAjaxModificar #porcentajecomision').val( parseFloat(parseFloat($('.frmAjaxModificar #montocomision').val()) * 100 / parseFloat($('.frmAjaxModificar #primaneta').val())) );
			} else {
				$('.frmAjaxModificar #porcentajecomision').val( 0);
			}
		}

		function calcularBonoMonto() {
			if (($('.frmAjaxModificar #porcentajecomision').val() > 0) && $('.frmAjaxModificar #primaneta').val() > 0) {
				$('.frmAjaxModificar #montocomision').val( parseFloat(parseFloat($('.frmAjaxModificar #porcentajecomision').val()) / 100 * parseFloat($('.frmAjaxModificar #primaneta').val())) );
			} else {
				$('.frmAjaxModificar #montocomision').val( 0);
			}
		}



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=ventas",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "agente", "value": $('#agente_filtro').val(), } );
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

		var table5 = $('#example5').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=ventasiniciadas",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "agente", "value": $('#agente_filtro').val(), } );
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

		var table6 = $('#example6').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=ventashistorico",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "agente", "value": $('#agente_filtro').val(), } );
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

		$('#filtrar').click( function() {
			table.draw();
			table5.draw();
			table6.draw();
		} );


		var table2 = $('#example2').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cotizaciones&estado=5",
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
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cotizaciones&estado=6",
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
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cotizaciones&estado=7",
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

		$('.btnNuevoAux').click(function() {
			$(location).attr('href','nuevo.php');
		});

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example").on("click",'.btnEndoso', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','endosos.php?id=' + idTable);

		});//fin del boton endoso

		$("#example5").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example5").on("click",'.btnEndoso', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','endosos.php?id=' + idTable);

		});//fin del boton endoso



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
						$('#primaneta').number( true, 2 ,'.','');
						$('#primatotal').number( true, 2,'.','' );
						$('#montocomision').number( true, 2,'.','' );
						$('#porcentajecomision').number( true, 2,'.','' );
						$('.frmContrefmotivorechazopoliza').hide();

						$('.frmContrefventas').hide();
						$('#version').prop('readonly',true);

						$('#fechavencimientopoliza').pickadate({
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

						$('#vigenciadesde').pickadate({
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



		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});

		$("#example").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar

		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$("#example5").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar

		$("#example5").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar





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
