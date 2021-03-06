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
$singular = "FORMA de Pago";

$plural = "FORMA de Pago";

$eliminar = "eliminarPeriodicidadventas";

$insertar = "insertarPeriodicidadventas";

$modificar = "modificarPeriodicidadventas";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$id = $_GET['id'];

$resultado = $serviciosReferencias->traerVentasPorId($id);
/*
$serviciosReferencias->emailDePagoDirecto($id);

die();
*/

$idcotizacion = mysql_result($resultado,0,'refcotizaciones');

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($idcotizacion);

$resPeriodicidad = $serviciosReferencias->traerPeriodicidadventasPorVenta($id);

if (mysql_num_rows($resPeriodicidad) > 0) {
	$existe = 1;
} else {
	$existe = 0;
}

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbperiodicidadventas";

$lblCambio	 	= array('refventas','reftipoperiodicidad','reftipocobranza','afiliacionnumber','tipotarjeta','vigencia','tarjetanumber');
$lblreemplazo	= array('Venta','Periodicidad','Tipo de Cobranza','Clabe Interbancaria','Tipo de Cuenta','Vigencia','Nro de Tarjeta');

$resVar = $serviciosReferencias->traerVentasPorIdCompleto($id);
$cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(15),' ',$id);


$resVar2 = $serviciosReferencias->traerTipoperiodicidad();


$resVar3 = $serviciosReferencias->traerTipocobranza();


if ($existe == 1) {
	$cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resPeriodicidad,0,'reftipoperiodicidad'));
	$cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resPeriodicidad,0,'reftipocobranza'));

	$banco = mysql_result($resPeriodicidad,0,'banco');
	$tarjetanumber = mysql_result($resPeriodicidad,0,'tarjetanumber');
	//die(var_dump($tarjetanumber));
	$afiliacionnumber = mysql_result($resPeriodicidad,0,'afiliacionnumber');
	$vigencia = mysql_result($resPeriodicidad,0,'vigencia');
	$tipotarjeta = mysql_result($resPeriodicidad,0,'tipotarjeta');

	if ($tipotarjeta == '1') {

		$cadRef4 = "<option value='1'>Tarjeta de Credito</option>";
	} else {
		if ($tipotarjeta == '2') {

			$cadRef4 = "<option value='2' selected>Tarjeta de Debito</option>";
		} else {
			if ($tipotarjeta == '3') {

				$cadRef4 = "<option value='3'>Cuenta Bancaria</option>";
			} else {

				$cadRef4 = "<option value=''>-- Sin debito --</option>";
			}

		}
	}

} else {
	$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1),'');
	$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');

	$banco = '';
	$tarjetanumber = '';
	$afiliacionnumber = '';
	$vigencia = '';
	$tipotarjeta = '';

	$cadRef4 = "<option value=''>-- Sin debito --</option><option value='1'>Tarjeta de Credito</option><option value='2'>Tarjeta de Debito</option><option value='3'>Cuenta Bancaria</option>";
}



$refdescripcion = array(0=>$cadRef,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4);
$refCampo 	=  array('refventas','reftipoperiodicidad','reftipocobranza','tipotarjeta');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resPeriodicidad = $serviciosReferencias->traerPeriodicidadventasdetallePorVenta($id);

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
	<!-- Bootstrap Material Datetime Picker Css -->
	<link href="../../plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

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
								FORMA DE PAGO
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
							<form class="formulario frmModificar" role="form" id="sign_in">
								<div class="row">
									<div class="alert bg-cyan">
										<p><b>Importante:</b> Por unica vez debera de cargar la periodicidad para generar los cobros</p>
									</div>
									<?php echo $frmUnidadNegocios; ?>
								</div>
								<div class="row">
									<div class="button-demo">
										<?php if (array_search($_SESSION['idroll_sahilices'], $arRoles) >= 0) { ?>
										<?php if ($existe == 0) { ?>
										<button type="submit" class="btn bg-orange waves-effect modificar">
											<i class="material-icons">view_module</i>
											<span>GENERAR LOS COBROS</span>
										</button>
									<?php } else { ?>


										<button type="button" class="btn bg-green waves-effect btnCobros">
											<i class="material-icons">unarchive</i>
											<span>COBROS</span>
										</button>
										<?php if (mysql_num_rows($resPeriodicidad)<=0) { ?>
										<button type="button" class="btn bg-orange waves-effect btnCalcularRecibos">
											<i class="material-icons">unarchive</i>
											<span>CALCULAR Y GENERAR AUTOMATICAMENTE LOS RECIBOS</span>
										</button>
										<?php } ?>


										<?php } ?>
										<?php } ?>
										<button type="button" class="btn btn-default waves-effect btnVolver">
											<i class="material-icons">arrow_back</i>
											<span>VOLVER</span>
										</button>
									</div>
								</div>
								<div class="row">
									<div id="vistapreviaRecibos">

									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

	 <script src="../../js/picker.js"></script>
	 <script src="../../js/picker.date.js"></script>

<script src="https://asesorescrea.com/desarrollo/crm/dashboard/ecommerce/assets/js/jquery.payform.min.js"></script>
<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>
	$(document).ready(function(){

		$('.btnCalcularRecibos').click(function() {
			generarRecibosCalculados();
		});

		function generarRecibosCalculados() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'generarRecibosCalculados', id: <?php echo $id; ?>},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#vistapreviaRecibos').html('');
					$('.btnCalcularRecibos').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					$('#vistapreviaRecibos').html(data);
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});

		}

		$('#vigencia').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/01',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: false,
			minDate : new Date()
		});

		$('#tarjetanumber').payform('formatCardNumber');

		$('#afiliacionnumber').inputmask('999999999999999999', { placeholder: '__________________', "onincomplete": function(){
			swal("Error!", 'Complete los 18 digitos', "warning");
			$('#afiliacionnumber').focus();

		} });

		$('.frmContbanco').hide();
		$('.frmContafiliacionnumber').hide();
		$('.frmConttarjetanumber').hide();
		$('.frmContvigencia').hide();

		<?php
		if ($existe == 1) {
		if (($tipotarjeta == 1) || ($tipotarjeta == 2)) {
		?>
		$('.frmContbanco').hide();
		$('.frmContafiliacionnumber').hide();
		$('.frmConttarjetanumber').show();
		$('.frmContvigencia').show();
		<?php } else { ?>

			<?php if ($tipotarjeta == 3) { ?>
				$('.frmContbanco').show();
				$('.frmContafiliacionnumber').show();
				$('.frmConttarjetanumber').hide();
				$('.frmContvigencia').hide();
			<?php } else { ?>
				$('.frmConttipotarjeta').hide();
				$('.frmContbanco').hide();
				$('.frmContafiliacionnumber').hide();
				$('.frmConttarjetanumber').hide();
				$('.frmContvigencia').hide();
			<?php } ?>
		<?php } } else { ?>

		$("#reftipocobranza").change( function(){
			if ($(this)[0].selectedIndex == 0)  {
				$('.frmConttipotarjeta').show();
			} else {

				$('.frmConttipotarjeta').hide();
				$('.frmContbanco').hide();
				$('.frmContafiliacionnumber').hide();
				$('.frmConttarjetanumber').hide();
				$('.frmContvigencia').hide();

				$('#banco').val('');
				$('#afiliacionnumber').val('');
				$('#tarjetanumber').val('');
				$('#vigencia').val('');

			}
		});

		$("#tipotarjeta").change( function(){
			if (($(this)[0].selectedIndex == 1) || ($(this)[0].selectedIndex == 2)) {
				$('.frmContbanco').hide();
				$('.frmContafiliacionnumber').hide();
				$('.frmConttarjetanumber').show();
				$('.frmContvigencia').show();

				$('#banco').val('');
				$('#afiliacionnumber').val('');
			} else {
				if ($(this)[0].selectedIndex == 3)  {
					$('.frmContbanco').show();
					$('.frmContafiliacionnumber').show();
					$('.frmConttarjetanumber').hide();
					$('.frmContvigencia').hide();

					$('#tarjetanumber').val('');
					$('#vigencia').val('');
				} else {
					$('.frmContbanco').hide();
					$('.frmContafiliacionnumber').hide();
					$('.frmConttarjetanumber').hide();
					$('.frmContvigencia').hide();

					$('#banco').val('');
					$('#afiliacionnumber').val('');
					$('#tarjetanumber').val('');
					$('#vigencia').val('');
				}
			}

		});

		<?php } ?>

		$('#banco').val('<?php echo $banco; ?>');
		$('#afiliacionnumber').val('<?php echo $afiliacionnumber; ?>');
		$('#tipotarjeta').val('<?php echo $tipotarjeta; ?>');
		$('#vigencia').val('<?php echo $vigencia; ?>');
		$('#tarjetanumber').val('<?php echo $tarjetanumber; ?>');

		$('.btnArchivos').click(function() {
			url = "subirdocumentacioni.php?id=<?php echo $idcotizacion; ?>&documentacion=35";
			$(location).attr('href',url);
		});

		$('.btnVolver').click(function() {
			url = "ver.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});

		$('.btnCobros').click(function() {
			url = "cobros.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
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
	});
</script>








</body>
<?php } ?>
</html>
