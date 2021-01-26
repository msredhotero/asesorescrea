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
$singular = "Cobro";

$plural = "Cobros";

$eliminar = "eliminarPeriodicidadventasdetalle";

$insertar = "insertarPeriodicidadventasdetalle";

$modificar = "modificarPeriodicidadventasdetalle";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$id = $_GET['id'];

$resultado = $serviciosReferencias->traerVentasPorId($id);

$idcotizacion = mysql_result($resultado,0,'refcotizaciones');

$nropoliza = mysql_result($resultado,0,'nropoliza');

$idproductoaux = mysql_result($resultado,0,'refproductosaux');

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($idcotizacion);

$resPeriodicidad = $serviciosReferencias->traerPeriodicidadventasPorVenta($id);

$resPeriodicidadVenta = $serviciosReferencias->traerPeriodicidadventasdetallePorVenta($id);

$cantidadRecivos = mysql_num_rows($resPeriodicidadVenta);

$resPeriodicidadVentaAux = $serviciosReferencias->traerPeriodicidadventasdetallePorVentaPagados($id,mysql_result($resultado,0,'refventas'));

$cantidadRecivosAux = mysql_num_rows($resPeriodicidadVentaAux);

if (mysql_result($resultado,0,'refventas') == 0) {
	$stockMeses = mysql_result($resPeriodicidad,0,'meses') - $cantidadRecivos;
} else {
	$stockMeses = mysql_result($resPeriodicidad,0,'meses') - $cantidadRecivosAux - $cantidadRecivos;
}


if (mysql_num_rows($resPeriodicidadVenta) > 0) {
	$resFechas = $serviciosReferencias->traerUltimoMes($id);

	$fechapago = mysql_result($resFechas,0,0);
	$fechavencimiento = mysql_result($resFechas,0,1);
	$montototal = mysql_result($resFechas,0,2);
	$primaneta = mysql_result($resFechas,0,3);
	$porcentajecomision = mysql_result($resFechas,0,4);
	$montocomision = mysql_result($resFechas,0,5);
} else {
	$fechapago = date('Y-m-d');
	$fechavencimiento = date('Y-m-d');
	$montototal = 0;
	$primaneta = 0;
	$porcentajecomision = 0;
	$montocomision = 0;
}




/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbperiodicidadventasdetalle";

$lblCambio	 	= array('refperiodicidadventas','montototal','primaneta','porcentajecomision','montocomision','fechapago','fechavencimiento','refestadopago','nrorecibo');
$lblreemplazo	= array('Venta','Monto Total','Prima Neta','% Comision','Monto Comision','Fecha Pago','Fecha Vencimiento','Estado Pago','Nro Recibo');

$resVar = $serviciosReferencias->traerPeriodicidadventasPorVenta($id);
$cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(1),' ',$id);


$resVar2 = $serviciosReferencias->traerEstadopagoPorId(1);
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1),'');

$refdescripcion = array(0=>$cadRef,1=>$cadRef2);
$refCampo 	=  array('refperiodicidadventas','refestadopago');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

//////////////////////////////////////////////  FIN de los opciones //////////////////////////



/////////////// ver de las ventas  ////////////////////////////////////////////////////
if ($idproductoaux == 0) {
	$resProductos = $serviciosReferencias->traerProductosPorIdCompleta(mysql_result($resCotizacion,0,'refproductos'));
} else {
	$resProductos = $serviciosReferencias->traerProductosPorIdCompleta($idproductoaux);
}

if (mysql_result($resProductos,0,'reftipoproductorama') == 12) {
	$lblRecibo = $serviciosReferencias->generaNroRecibo();
} else {
	$lblRecibo = '';
}

///////////////////////////// fin del ver //////////////////////////////////////////////

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
								<?php echo strtoupper($plural); ?> - No POLIZA: <?php echo strtoupper($nropoliza); ?>
							</h2>

						</div>
						<div class="body table-responsive">
							<form class="form" id="formCountry">

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="button-demo">
										<?php //if ($stockMeses > 0) { ?>
											<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>NUEVO</span>
											</button>
										<?php //} ?>
											<button type="button" class="btn bg-deep-orange waves-effect">
												<i class="material-icons">build</i>
												<span>FALTAN CARGAR <?php echo $stockMeses; ?></span>
											</button>
											<button type="button" class="btn btn-primary waves-effect btnVolver">
												<i class="material-icons">arrow_back</i>
												<span>VOLVER</span>
											</button>


										</div>
									</div>
								</div>

								<div class="row" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Monto Total</th>
												<th>Prima Neta</th>
												<th>% Comision</th>
												<th>Monto Comision</th>
												<th>Fecha Pago</th>
												<th>Fecha Venc.</th>
												<th>Estado</th>
												<th>Nro Recibo</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Monto Total</th>
												<th>Prima Neta</th>
												<th>% Comision</th>
												<th>Monto Comision</th>
												<th>Fecha Pago</th>
												<th>Fecha Venc.</th>
												<th>Estado</th>
												<th>Nro Recibo</th>
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
</section>


<!-- NUEVO -->
	<form class="formulario frmNuevo" role="form" id="sign_in">
	   <div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
	       <div class="modal-dialog modal-lg" role="document">
	           <div class="modal-content">
	               <div class="modal-header">
	                   <h4 class="modal-title" id="largeModalLabel">CREAR <?php echo strtoupper($singular); ?></h4>
	               </div>
	               <div class="modal-body">
							<div class="row frmAjaxNuevo">
								<?php echo $frmUnidadNegocios; ?>
							</div>

	               </div>
	               <div class="modal-footer">
							 <button type="button" class="btn bg-black waves-effect btnCalcularM">CALCULAR $</button>
							 <button type="button" class="btn bg-black waves-effect btnCalcularP">CALCULAR %</button>
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
								<button type="button" class="btn bg-black waves-effect btnCalcularM">CALCULAR $</button>
							   <button type="button" class="btn bg-black waves-effect btnCalcularP">CALCULAR %</button>
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

		$('#nrorecibo').val('<?php echo $lblRecibo; ?>');

		$('.btnVolver').click(function() {
			url = "ver.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});

		$("#example").on("click",'.btnRecibo', function(){
			idTable =  $(this).attr("id");
			url = "subirdocumentacionic.php?id=" + idTable;
			$(location).attr('href',url);
		});

		$("#example").on("click",'.btnPagos', function(){
			idTable =  $(this).attr("id");
			url = "subirdocumentacionip.php?id=" + idTable;
			$(location).attr('href',url);
		});

		$('.frmContfechapagoreal').hide();
		$('.frmContrefformapago').hide();
		$('#refformapago').val(0);


		$('.frmAjaxNuevo #fechacrea').val('2020-01-01');
		$('.frmAjaxNuevo #fechamodi').val('2020-01-01');
		$('.frmAjaxNuevo #usuariocrea').val('2020-01-01');
		$('.frmAjaxNuevo #usuariomodi').val('2020-01-01');

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

			if (($('.frmAjaxNuevo #montocomision').val() > 0) && $('.frmAjaxNuevo #primaneta').val() > 0) {
				$('.frmAjaxNuevo #porcentajecomision').val( parseFloat(parseFloat($('.frmAjaxNuevo #montocomision').val()) * 100 / parseFloat($('.frmAjaxNuevo #primaneta').val())) );
			} else {
				$('.frmAjaxNuevo #porcentajecomision').val( 0);
			}
		}

		function calcularBonoMonto() {
			if (($('.frmAjaxModificar #porcentajecomision').val() > 0) && $('.frmAjaxModificar #primaneta').val() > 0) {
				$('.frmAjaxModificar #montocomision').val( parseFloat(parseFloat($('.frmAjaxModificar #porcentajecomision').val()) / 100 * parseFloat($('.frmAjaxModificar #primaneta').val())) );
			} else {
				$('.frmAjaxModificar #montocomision').val( 0);
			}

			if (($('.frmAjaxNuevo #porcentajecomision').val() > 0) && $('.frmAjaxNuevo #primaneta').val() > 0) {
				$('.frmAjaxNuevo #montocomision').val( parseFloat(parseFloat($('.frmAjaxNuevo #porcentajecomision').val()) / 100 * parseFloat($('.frmAjaxNuevo #primaneta').val())) );
			} else {
				$('.frmAjaxNuevo #montocomision').val( 0);
			}
		}

		$('.frmContrefcotizaciones').hide();
		$('.frmContrefperiodicidadventas').hide();


		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "asc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cobros&id=<?php echo $id; ?>",
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


		$('.frmAjaxNuevo #primaneta').number( true, 2 ,'.','');
		$('.frmAjaxNuevo #montototal').number( true, 2,'.','' );
		$('.frmAjaxNuevo #montocomision').number( true, 2,'.','' );
		$('.frmAjaxNuevo #porcentajecomision').number( true, 2,'.','' );

		$('.frmAjaxNuevo .frmContfechapago').hide();
		$('.frmAjaxNuevo #fechapago').val('');
		$('.frmAjaxNuevo #fechavencimiento').val('<?php echo $fechavencimiento; ?>');

		$('.frmAjaxNuevo #primaneta').val('<?php echo $primaneta; ?>');
		$('.frmAjaxNuevo #montototal').val('<?php echo $montototal; ?>');
		$('.frmAjaxNuevo #montocomision').val('<?php echo $montocomision; ?>');
		$('.frmAjaxNuevo #porcentajecomision').val('<?php echo $porcentajecomision; ?>');

		$('.frmAjaxNuevo #fechapago').pickadate({
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

		$('.frmAjaxNuevo #fechavencimiento').pickadate({
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

					$('#primaneta').number( true, 2 ,'.','');
					$('#montototal').number( true, 2,'.','' );
					$('#montocomision').number( true, 2,'.','' );
					$('#porcentajecomision').number( true, 2,'.','' );

					$('#fechapago').pickadate({
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

					$('#fechavencimiento').pickadate({
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
