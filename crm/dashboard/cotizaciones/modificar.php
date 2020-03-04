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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cotizaciones/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cotizaciones",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

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
$resultado = $serviciosReferencias->traerCotizacionesPorId($id);
/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcotizaciones";

$lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor','nropoliza');
$lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor','Nro Poliza');


$modificar = "modificarCotizaciones";
$idTabla = "idcotizacion";


$idestado = mysql_result($resultado,0,'refestadocotizaciones');

$resEstados = $serviciosReferencias->traerEstadocotizacionesPorId($idestado);

$orden = mysql_result($resEstados,0,'orden');

switch ($orden) {
	case 1:
		$ordenPosible = 2;
		$ordenRechazo = 0;
		$lblOrden = 'En proceso';
	break;
	case 2:
		$ordenPosible = 3;
		$ordenRechazo = 0;
		$lblOrden = 'Cotizacion en valoracion del cliente';
	break;
	case 3:
		$ordenPosible = 5;
		$ordenRechazo = 4;
		$lblOrden = 'Emitido';
	break;
	case 4:
		$ordenPosible = 0;
		$ordenRechazo = 0;
		$lblOrden = 'Finalizado Rechazado';
	break;
	case 5:
		$ordenPosible = 6;
		$ordenRechazo = 4;
		$lblOrden = 'Pagado';
	break;
	case 6:
		$ordenPosible = 7;
		$ordenRechazo = 0;
		$lblOrden = 'Comisionado Agente';
	break;
	case 7:
		$ordenPosible = 8;
		$ordenRechazo = 0;
		$lblOrden = 'Bono Promotor';
	break;
	case 8:
		$ordenPosible = 0;
		$ordenRechazo = 0;
		$lblOrden = 'Finalizado';
	break;

	default:
		// code...
		break;
}

$resUsuario = $serviciosUsuario->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
$cadRef1 	= $serviciosFunciones->devolverSelectBox($resUsuario,array(1),'');

$resVar2	= $serviciosReferencias->traerClientes();
$cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(4,2,3),' ',mysql_result($resultado,0,'refclientes'));

$resVar3	= $serviciosReferencias->traerProductos();
$cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resultado,0,'refproductos'));

if ($_SESSION['idroll_sahilices'] != 7) {
	$resVar4	= $serviciosReferencias->traerAsociados();
	$cadRef4 = '<option value="0">-- Seleccionar --</option>';
	$cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(4,2,3),' ',mysql_result($resultado,0,'refasociados'));
} else {
	$cadRef4 = '<option value="0">-- Seleccionar --</option>';
}

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(4,2,3),' ');
} else {
	$resVar5	= $serviciosReferencias->traerAsesores();
	$cadRef5 = $serviciosFunciones->devolverSelectBoxActivo($resVar5,array(4,2,3),' ',mysql_result($resultado,0,'refasesores'));
}

$resVar6 = $serviciosReferencias->traerEstadocotizacionesPorId($ordenPosible);
$cadRef6 = $serviciosFunciones->devolverSelectBoxActivo($resVar6,array(1),'',$idestado);


$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6);
$refCampo 	=  array('refusuarios','refclientes','refproductos','refasociados','refasesores','refestadocotizaciones');

$frmUnidadNegocios = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resProducto = $serviciosReferencias->traerProductosPorId(mysql_result($resultado,0,'refproductos'));

$resGuia = $serviciosReferencias->traerEstadocotizaciones();

$prima = mysql_result($resProducto, 0,'prima');

if ($_SESSION['idroll_sahilices'] == 3) {


} else {

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
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../'); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix">

			<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">

				<?php
				$lblEstado = 'complete';
				$i = 0;
				while ($rowG = mysql_fetch_array($resGuia)) {
					$i += 1;
					$urlAcceso = 'javascript:void(0)';
					
					if ($rowG['idestadocotizacion'] == $idestado) {
						$lblEstado = 'active';
					}
					if (($rowG['idestadocotizacion'] == 4) && ($idestado>4)) {
						$lblEstado = 'disabled';
					} else {
						$lblEstado = 'complete';
					}

					if ($rowG['idestadocotizacion'] > $idestado) {
						$lblEstado = 'disabled';
					}

				?>
				<div class="col-xs-1 bs-wizard-step <?php echo $lblEstado; ?>">
					<div class="text-center bs-wizard-stepnum">Paso <?php echo $i; ?></div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="<?php echo $urlAcceso; ?>" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center"><?php echo $rowG['estadocotizacion']; ?></div>
				</div>
				<?php
					if ($lblEstado == 'active') {
						$lblEstado = 'disabled';
					}
				}
				?>

			</div>

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								MODIFICAR <?php echo strtoupper($plural); ?>
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


								<div class="row" style="padding: 5px 20px;">

									<?php echo utf8_decode($frmUnidadNegocios); ?>

								</div>
								<div class="row">
									<div class="modal-footer">
										<?php
										if ($ordenPosible == 0) {
										?>
										<button type="button" class="btn btn-success waves-effect"><?php echo $lblOrden; ?></button>
										<?php
										} else {
										?>
										<button type="submit" class="btn btn-success waves-effect"><?php echo $lblOrden; ?></button>
										<?php
										}
										?>

										<?php
										if ($ordenRechazo > 0) {
										?>
										<button type="button" class="btn btn-danger waves-effect btnRechazar">RECHAZAR</button>
										<?php
										}
										?>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>
	$(document).ready(function(){

		<?php
		if ($lblOrden == 'Finalizado') {
		?>
		$('.frmContfechaemitido').show();
		$('.frmContprimaneta').show();
		$('.frmContprimatotal').show();
		$('.frmContrecibopago').show();
		$('.frmContfechapago').show();
		$('.frmContnrorecibo').show();
		$('.frmContimportecomisionagente').show();
		$('.frmContimportebonopromotor').show();
		$('.frmContrefusuarios').hide();
		$('.frmContrefestadocotizaciones').hide();
		$('.frmContnropoliza').show();
		<?php } else {?>
		$('.frmContfechaemitido').hide();
		$('.frmContprimaneta').hide();
		$('.frmContprimatotal').hide();
		$('.frmContrecibopago').hide();
		$('.frmContfechapago').hide();
		$('.frmContnrorecibo').hide();
		$('.frmContimportecomisionagente').hide();
		$('.frmContimportebonopromotor').hide();
		$('.frmContnropoliza').hide();

		$('.frmContrefusuarios').hide();
		$('.frmContrefestadocotizaciones').hide();

		<?php
		if ($ordenPosible == 5) {
		?>
		$('.frmContprimaneta').show();
		$('.frmContprimatotal').show();
		$('.frmContrecibopago').show();
		$('.frmContfechaemitido').show();
		$('.frmContnropoliza').show();

		<?php if ($prima == '1') { ?>
		$("#primaneta").prop('required',true);
		$("#primatotal").prop('required',true);
		<?php } ?>
		$("#recibopago").prop('required',true);
		$("#fechaemitido").prop('required',true);
		<?php
		}
		?>

		<?php
		if ($ordenPosible == 6) {
		?>
		$('.frmContprimaneta').show();
		$('.frmContprimatotal').show();
		$('.frmContrecibopago').show();
		$('.frmContfechaemitido').show();
		$('.frmContnropoliza').show();

		$('.frmContfechapago').show();
		$('.frmContnrorecibo').show();

		<?php if ($prima == '1') { ?>
		$("#primaneta").prop('required',true);
		$("#primatotal").prop('required',true);
		<?php } ?>
		$("#recibopago").prop('required',true);
		$("#fechaemitido").prop('required',true);

		$("#fechapago").prop('required',true);
		$("#nropoliza").prop('required',true);
		<?php
		}
		?>

		<?php
		if ($ordenPosible == 7) {
		?>
		$('.frmContprimaneta').show();
		$('.frmContprimatotal').show();
		$('.frmContrecibopago').show();
		$('.frmContfechaemitido').show();
		$('.frmContnropoliza').show();

		$('.frmContfechapago').show();
		$('.frmContnrorecibo').show();

		$('.frmContimportecomisionagente').show();

		<?php if ($prima == '1') { ?>
		$("#primaneta").prop('required',true);
		$("#primatotal").prop('required',true);
		<?php } ?>
		$("#recibopago").prop('required',true);
		$("#fechaemitido").prop('required',true);

		$("#fechapago").prop('required',true);
		$("#nropoliza").prop('required',true);

		$("#importecomisionagente").prop('required',true);
		<?php
		}
		?>

		<?php
		if ($ordenPosible == 8) {
		?>
		$('.frmContprimaneta').show();
		$('.frmContprimatotal').show();
		$('.frmContrecibopago').show();
		$('.frmContfechaemitido').show();
		$('.frmContnropoliza').show();

		$('.frmContfechapago').show();
		$('.frmContnrorecibo').show();

		$('.frmContimportecomisionagente').show();
		$('.frmContimportebonopromotor').show();

		<?php if ($prima == '1') { ?>
		$("#primaneta").prop('required',true);
		$("#primatotal").prop('required',true);
		<?php } ?>
		$("#recibopago").prop('required',true);
		$("#fechaemitido").prop('required',true);

		$("#fechapago").prop('required',true);
		$("#nropoliza").prop('required',true);

		$("#importecomisionagente").prop('required',true);
		$("#importebonopromotor").prop('required',true);
		<?php
		}
		?>

		<?php
		if ($ordenRechazo > 0) {
		?>
		$('.frmContobservaciones').show();
		<?php
		} else {
		?>
		$('.frmContobservaciones').hide();
		<?php
		}
		?>

		<?php
		}
		?>

		$('.frmContfechacrea').hide();
		$('.frmContfechamodi').hide();
		$('.frmContusuariocrea').hide();
		$('.frmContusuariomodi').hide();

		$('#fechacrea').val('2020-02-02');
		$('#fechamodi').val('2020-02-02');
		$('#usuariocrea').val('2020-02-02');
		$('#usuariomodi').val('2020-02-02');



		<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
			$('.frmContrefasociados').hide();
			$('#refasociados').prepend('<option value="0">sin valor</option>');
			$('#refasociados').val(0);
		<?php } ?>


		$('#telefonofijo').inputmask('999 9999999', { placeholder: '___ _______' });
		$('#telefonocelular').inputmask('999 9999999', { placeholder: '___ _______' });


		$('#fechaemitido').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'mx',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : new Date()
		});

		$('#fechapago').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'mx',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : new Date()
		});



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cotizaciones",
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
			"columnDefs": [
              {
                  "targets": [ 4 ],
                  "visible": false,
                  "searchable": false
              }
          ]
		});

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$('#activo').prop('checked',true);

		function frmAjaxModificar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'frmAjaxModificar',tabla: '<?php echo $tabla; ?>', id: id,ruta:''},
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

		function frmAjaxEliminarDefinitivo(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarPostulantesDefinitivo', id: id},
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
						$('#lgmEliminarDefinitivo').modal('toggle');
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

		$("#example").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		function refrescar(){
	    //Actualiza la página
	    location.reload();
	  }

	$('.btnRechazar').click(function() {
		$.ajax({
			url: '../../ajax/ajax.php',
			type: 'POST',
			// Form data
			//datos del formulario
			data: {accion: 'rechazarCotizacion', id: <?php echo $id; ?>, observaciones: $('#observaciones').val()},
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
					setTimeout(refrescar, 2500);
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

		<?php
		if ($idestado != 4) {
		?>
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
							swal("Ok!", 'Se guardo correctamente la cotizacion', "success");

							setTimeout(refrescar, 1500);
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
		}
		?>


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
