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

$arRoles = array(1,4,11,7,10);
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Polizas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "POLIZA";

$plural = "POLIZA";

$eliminar = "eliminarVentas";

$insertar = "insertarVentas";

$modificar = "modificarVentas";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$id = $_GET['id'];

$origen = $_GET['origen'];

$resVenta = $serviciosReferencias->traerVentasPorCotizacion($id);

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbventas";

$lblCambio	 	= array('refcotizaciones','primaneta','primatotal','foliotys','foliointerno','fechavencimientopoliza','nropoliza','refestadoventa','refproductosaux','vigenciadesde','fechaemision','reftipomoneda','comisioncedida','gastosexpedicion','iva');
$lblreemplazo	= array('Venta','Prima Neta','Prima Total','Folio TYS','Folio Interno','Fecha Vencimiento de la Poliza','Nro Poliza','Estado Poliza','Producto Especifico','Vigencia Desde','Fecha de Emision','Tipo Moneda','Comision Cedida','Gastos de Expedición','IVA');


$resVar = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);
$cadRef = $serviciosFunciones->devolverSelectBox($resVar,array(1,2,3),' ');

$resVar1 = $serviciosReferencias->traerEstadoventaPorId(6);
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar1,array(1),' ');

$resTipoMoneda = $serviciosReferencias->traerTipomoneda();
$cadTipoMoneda = $serviciosFunciones->devolverSelectBox($resTipoMoneda,array(1),'');


$refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadTipoMoneda);
$refCampo 	=  array('refcotizaciones','refestadoventa','reftipomoneda');

$idproducto = mysql_result($resVar,0,'refproductos');

$resCliente = $serviciosReferencias->traerClientesPorId( mysql_result($resVar,0,'refclientes'));

if (mysql_result($resCliente,0,'fechanacimiento') == '' || mysql_result($resCliente,0,'fechanacimiento') == '0000-00-00') {
	$edad = 0;
} else {
	$edad = $serviciosReferencias->calculaedad(mysql_result($resCliente,0,'fechanacimiento'));
}


$resProducto = $serviciosReferencias->traerProductosPorId($idproducto);

$resPaquete = $serviciosReferencias->traerPaquetedetallesPorPaquete($idproducto);

$formularioAr = array();

if (mysql_num_rows($resPaquete) > 0) {
	while ($rowP = mysql_fetch_array($resPaquete)) {

		$existeCotizacionParaProducto = $serviciosReferencias->traerValoredadPorProductoEdad($rowP['refproductos'],$edad);

		if ($rowP['unicomonto'] == '1') {
			$acumPrecio = $rowP['valor'];
		} else {
			$acumPrecio = mysql_result($existeCotizacionParaProducto,0,'valor');
		}

		$resVar3 = $serviciosReferencias->traerProductosPorId($rowP['refproductos']);
		$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),' ');

		$refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadRef3,3=>$cadTipoMoneda);
		$refCampo 	=  array('refcotizaciones','refestadoventa','refproductosaux','reftipomoneda');

		$formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

		array_push($formularioAr, array('formulario' => $formulario, 'producto'=> $rowP['producto'], 'idproducto' => $rowP['refproductos'], 'monto' => $acumPrecio ));
	}


} else {

	$existeCotizacionParaProducto = $serviciosReferencias->traerValoredadPorProductoEdad($idproducto,$edad);

	if (mysql_num_rows($existeCotizacionParaProducto)>0) {
		$acumPrecio = mysql_result($existeCotizacionParaProducto,0,'valor');

	} else {
		$acumPrecio = mysql_result($resProducto,0,'precio');

	}

	$resTipoMoneda = $serviciosReferencias->traerTipomoneda();
	$cadTipoMoneda = $serviciosFunciones->devolverSelectBox($resTipoMoneda,array(1),'');


	$cadRef3 = "<option value='0'>Mismo de la cotización</option>";
	$refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadRef3,3=>$cadTipoMoneda);
	$refCampo 	=  array('refcotizaciones','refestadoventa','refproductosaux','reftipomoneda');



	$formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

	array_push($formularioAr, array('formulario' => $formulario, 'producto'=> mysql_result($resProducto,0,'producto'), 'idproducto' => 0, 'monto' => $acumPrecio));
}

//$formulario = $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resRenovacion = $serviciosReferencias->traerRenovacionesPorCotizacionNueva($id);

if (mysql_num_rows($resRenovacion) > 0) {
	$idrenovacion = mysql_result($resRenovacion,0,0);

	$existeRenovacion = 1;

	$resVentasVieja = $serviciosReferencias->traerVentasPorId(mysql_result($resRenovacion,0,'refventas'));

	$polizaVieja = mysql_result($resVentasVieja,0,'nropoliza');
	$fechavencimientoVieja = mysql_result($resVentasVieja,0,'fechavencimientopoliza');
} else {
	$existeRenovacion = 0;
	$idrenovacion = 0;
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

			<?php
				$formParticular = 'formAlta';
				$cantForm = 0;
				foreach ($formularioAr as $frm) {
					$formParticular = 'formAlta';
			?>
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								POLIZA - <?php echo $frm['producto']; ?><?php if ($frm['monto']>0) {?> - Precio: MX $ <?php echo $frm['monto']; ?><?php } ?>
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
							<?php if ($existeRenovacion == 1) { ?>
							<div class="alert alert-warning">
								<p>Esta Poliza es una renovación de la <b>Poliza: <?php echo $polizaVieja; ?></b> , fecha de vencimiento: <b><?php echo $fechavencimientoVieja; ?></p>
							</div>
							
							<?php } ?>
							
							<?php
								$resVenta = $serviciosReferencias->traerVentasPorCotizacionPaquetes($id,$frm['idproducto']);
								if (mysql_num_rows($resVenta) > 0) {

							?>

							<div class="row">
								<div class="button-demo">
									<button type="button" class="btn btn-black waves-effect btnVolver">
										<i class="material-icons">arrow_back</i>
										<span>VOLVER</span>
									</button>

									<button type="button" class="btn bg-red waves-effect">
										<i class="material-icons">save</i>
										<span>YA SE CARGO ESTA POLIZA</span>
									</button>
								</div>
							</div>
							<?php } else {
								$formParticular = $formParticular.$cantForm;

								?>
							<form class="formulario frmNuevo<?php echo $cantForm; ?> <?php echo $formParticular; ?>" role="form" id="sign_in">
								<div class="row">
									<?php echo $frm['formulario']; ?>
									<input type="hidden" id="reforigen" name="reforigen" value="<?php echo $origen; ?>"/>"
								</div>
								<div class="row">
									<div class="button-demo">
										<button type="button" class="btn btn-black waves-effect btnVolver">
											<i class="material-icons">arrow_back</i>
											<span>VOLVER</span>
										</button>


										<?php if (array_search($_SESSION['idroll_sahilices'], $arRoles) >= 0) { ?>
											<button type="submit" class="btn bg-light-blue waves-effect btnNuevo">
												<i class="material-icons">save</i>
												<span>GUARDAR</span>
											</button>

										<?php } ?>


									</div>
								</div>
								<input type="hidden" id="idrenovacion" name="idrenovacion" value="<?php echo $idrenovacion; ?>"/>
							</form>
							<?php
								$cantForm += 1;
								}
							?>

						</div>
					</div>
				</div>
			</div>
			<?php } ?>
		</div>
	</div>
</section>





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

		$('#iva').val('16');
		$('#comisioncedida').val('0');
		$('#financiamiento').val('0');
		$('#gastosexpedicion').val('0');

		$('#iva').number( true, 2 ,'.','');
		$('#comisioncedida').number( true, 2 ,'.','');
		$('#financiamiento').number( true, 2 ,'.','');
		$('#gastosexpedicion').number( true, 2 ,'.','');

		$('.btnVolver').click(function() {
			url = "index.php";
			$(location).attr('href',url);
		});

		$('.frmContfoliointerno').hide();
		$('.frmContrefmotivorechazopoliza').hide();



		$('.btnArchivos').click(function() {
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&documentacion=35";
			$(location).attr('href',url);
		});

		$('.btnPagos').click(function() {
			url = "periodicidad.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});







		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=ventas",
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



		$('.datepicker').pickadate({
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


		<?php
			$cantForm = 0;
			$formParticular = 'formAlta';
			foreach ($formularioAr as $frm) {
				$formParticular = 'formAlta';
				$formParticular = $formParticular.$cantForm;
		?>
		<?php
			$resVenta = $serviciosReferencias->traerVentasPorCotizacionPaquetes($id,$frm['idproducto']);
			if (mysql_num_rows($resVenta) <= 0) {
		?>

		$('.<?php echo $formParticular; ?> #primaneta').number( true, 2 ,'.','');
		$('.<?php echo $formParticular; ?> #primatotal').number( true, 2,'.','' );
		$('.<?php echo $formParticular; ?> #montocomision').number( true, 2,'.','' );
		$('.<?php echo $formParticular; ?> #porcentajecomision').number( true, 2,'.','' );

		$('.<?php echo $formParticular; ?> .btnCalcularM').click(function() {
			calcularBonoMonto();
		});

		$('.<?php echo $formParticular; ?> .btnCalcularP').click(function() {
			calcularBonoPorcentaje();
		});

		function calcularBonoPorcentaje() {
			if (($('.<?php echo $formParticular; ?> #montocomision').val() > 0) && $('.<?php echo $formParticular; ?> #primaneta').val() > 0) {
				$('.<?php echo $formParticular; ?> #porcentajecomision').val( parseFloat(parseFloat($('.<?php echo $formParticular; ?> #montocomision').val()) * 100 / parseFloat($('.<?php echo $formParticular; ?> #primaneta').val())) );
			} else {
				$('.<?php echo $formParticular; ?> #porcentajecomision').val( 0);
			}
		}

		function calcularBonoMonto() {
			if (($('.<?php echo $formParticular; ?> #porcentajecomision').val() > 0) && $('.<?php echo $formParticular; ?> #primaneta').val() > 0) {
				$('.<?php echo $formParticular; ?> #montocomision').val( parseFloat(parseFloat($('.<?php echo $formParticular; ?> #porcentajecomision').val()) / 100 * parseFloat($('.<?php echo $formParticular; ?> #primaneta').val())) );
			} else {
				$('.<?php echo $formParticular; ?> #montocomision').val( 0);
			}
		}

		$('.frmNuevo<?php echo $cantForm; ?>').submit(function(e){

			e.preventDefault();
			if ($('.frmNuevo<?php echo $cantForm; ?>')[0].checkValidity()) {
				//información del formulario
				var formData = new FormData($(".formulario")[<?php echo $cantForm; ?>]);
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
						$('.btnNuevo').hide();
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
							location.reload();
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
		<?php
			$cantForm += 1;
			}
		?>
		<?php } ?>

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
	});
</script>








</body>
<?php } ?>
</html>
