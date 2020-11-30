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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../renovaciones/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Renovaciones",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

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

$resMotivoRechazos = $serviciosReferencias->traerMotivorechazopoliza();
$cadVar = $serviciosFunciones->devolverSelectBox($resMotivoRechazos,array(1),'');

$resEstadoVenta = $serviciosReferencias->traerEstadoventaPorId(3);
$cadVar2 = $serviciosFunciones->devolverSelectBox($resEstadoVenta,array(1),'');

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
								RENOVACIONES
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
								<?php if ($_SESSION['idroll_sahilices'] != 16) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="button-demo">

											<button type="button" class="btn bg-orange waves-effect btnPendiente">
												<i class="material-icons">alarm</i>
												<span>PENDIENTES</span>
											</button>

											<button type="button" class="btn bg-green waves-effect btnRenovada">
												<i class="material-icons">done_all</i>
												<span>RENOVADAS</span>
											</button>

											<button type="button" class="btn bg-grey waves-effect btnHistorico">
												<i class="material-icons">history</i>
												<span>HISTORICO</span>
											</button>




										</div>
									</div>
								</div>
								<?php } ?>

								<?php if ($_SESSION['idroll_sahilices'] != 16) { ?>
								<div class="row contPendiente" style="padding: 5px 20px;">
									<h4>RENOVACIONES PENDIENTES</h4>
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
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>


								<div class="row contHistorico" style="padding: 5px 20px;">
									<h4>RENOVACIONES HISTORICO</h4>
									<table id="example2" class="display table " style="width:100%">
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
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>
								<?php } ?>

								<div class="row contRenovada" style="padding: 5px 20px;">
									<h4>RENOVADAS</h4>
									<table id="example3" class="display table " style="width:100%">
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


<?php if ($_SESSION['idroll_sahilices'] != 16) { ?>
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
		                   <h4 class="modal-title" id="largeModalLabel">ELIMINAR RENOVACION</h4>
		               </div>
		               <div class="modal-body">
								<p>¿Esta seguro que desea eliminar el registro?</p>
								<div class="row">
									<?php echo $serviciosFunciones->addInput('6,6,6,12','select','estadoventa','estadoventa','', 'Estado de la Venta','',$cadVar2); ?>
									<div class="contmotivorechazo">

										<?php echo $serviciosFunciones->addInput('6,6,6,12','select','motivorechazo','motivorechazo','', 'Motivo de Rechazo','', '<option value="0">-- Seleccionar --</option>'.$cadVar); ?>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-6 frmContobservaciones" style="display:block">
										<label for="observaciones" class="control-label" style="text-align:left">Observaciones </label>
										<div class="input-group col-md-12">
											<textarea type="text" rows="2" cols="6" class="form-control" id="iobservaciones" name="iobservaciones" placeholder="Ingrese las Observaciones..."></textarea>
										</div>

									</div>
								</div>
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



		<div class="modal fade" id="lgmAvisar" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
						<div class="modal-header bg-yellow">
							 <h4 class="modal-title" id="largeModalLabel">ENVIAR RENOVACION AL CLIENTE</h4>
						</div>
						<div class="modal-body">
							<div class="row">

								<div class="errorVerificador">

								</div>
								<input type="hidden" id="idventaenvio" name="idventaenvio" value="0"/>

							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-warning waves-effect enviarRenovacionCliente">ENVIAR</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>
				  </div>
			 </div>
		</div>
<?php } ?>

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

		var table = $('#example3').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=renovaciones",
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

		$("#example3").on("click",'.btnPoliza', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','poliza.php?id=' + idTable);

		});//fin del boton modificar

		<?php if ($_SESSION['idroll_sahilices'] != 16) { ?>

			$('.enviarRenovacionCliente').click(function() {
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: {
						accion: 'enviarRenovacionCliente',
						id: $('#idventaenvio').val()
					},
					//mientras enviamos el archivo
					beforeSend: function(){

						$('.enviarRenovacionCliente').hide();
					},
					//una vez finalizado correctamente
					success: function(data){

						// verifico que cargo la poliza
						if (data.error) {
							swal("Error!", 'Se genero un error al enviar la informacion por favor verifique', "warning");

							$('.enviarRenovacionCliente').show();
						} else {
							swal({
									title: "Respuesta",
									text: "Se envio correctamente la poliza renovada al cliente!!",
									type: "success",
									timer: 1500,
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
			});

		$("#example3").on("click",'.btnEnviar', function(){
			idTable =  $(this).attr("id");
			$('#idventaenvio').val(idTable);
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'verificaPolizaDatosCargados',
					id: idTable
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.errorVerificador').html('');
					$('.enviarRenovacionCliente').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					// verifico que cargo la poliza
					if (data.verificador.nropoliza == 1) {
						$('.enviarRenovacionCliente').show();
						$('.errorVerificador').html('<h4>La Poliza ya fue cargada por la administración, ya puede enviar la renovacion al cliente</h4>');

						$('#lgmAvisar').modal();
					} else {
						swal("Error!", 'Aun no se cargo la poliza a la renovacion', "warning");

						$('.enviarRenovacionCliente').hide();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});

		});//fin del boton endoso

		$('.contHistorico').hide();
		$('.contRenovada').hide();

		$("#motivorechazo").prop('require',true);


		$('.btnPendiente').click(function() {
			$('.contHistorico').hide();
			$('.contPendiente').show();
			$('.contRenovada').hide();

		});

		$('.btnHistorico').click(function() {
			$('.contHistorico').show();
			$('.contPendiente').hide();
			$('.contRenovada').hide();
		});

		$('.btnRenovada').click(function() {
			$('.contHistorico').hide();
			$('.contPendiente').hide();
			$('.contRenovada').show();
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
			"order": [[ 7, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=renovacionespendientes",
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

		var table = $('#example2').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=renovacioneshistorico",
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

		$("#example3").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example").on("click",'.btnEndoso', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','endosos.php?id=' + idTable);

		});//fin del boton endoso

		$("#example").on("click",'.btnRenovaciones', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','renovaciones.php?id=' + idTable);

		});//fin del boton endoso



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

						if ($('#refmotivorechazopoliza').val() > 0) {
							$('.frmContrefmotivorechazopoliza').show();
						} else {
							$('.frmContrefmotivorechazopoliza').hide();
						}

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
			if ($('#motivorechazo').val() == 0) {
				swal({
						title: "Respuesta",
						text: 'Por favor ingrese un motivo de rechazo',
						type: "error",
						timer: 2000,
						showConfirmButton: false
				});
			} else {
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: {
						accion: '<?php echo $eliminar; ?>',
						id: id,
						observaciones: $('#iobservaciones').val(),
						estadoventa: $('#estadoventa').val(),
						motivorechazo: $('#motivorechazo').val()
					},
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
							table3.ajax.reload();
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
		}

		$("#example3").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});



		$("#example3").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar





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

		<?php } ?>
	});
</script>








</body>
<?php } ?>
</html>
