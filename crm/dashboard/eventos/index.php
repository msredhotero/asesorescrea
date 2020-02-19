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
include ('../../includes/funcionesMensajes.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();
$serviciosMensajes 	= new ServiciosMensajes();

//$serviciosMensajes->msgAsesorNuevo(1);

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../eventos/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Eventos",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina filtros por perfil ///////////////////////////////////////////////

$resEntrevistasOportunidades = $serviciosReferencias->traerEntrevistaoportunidades();

if ($_SESSION['idroll_sahilices'] == 3) {
	$resRoles 	= $serviciosUsuario->traerUsuarioId($_SESSION['usuaid_sahilices']);
} else {
	$resRoles 	= $serviciosUsuario->traerUsuariosPorRol(3);
}

$cadRef1 = $serviciosFunciones->devolverSelectBox($resRoles,array(3),'');


if ($_SESSION['idroll_sahilices'] == 3) {
	$resAsesores 	= $serviciosReferencias->traerAsesoresPorGerente($_SESSION['usuaid_sahilices'])
} else {
	$resAsesores 	= $serviciosReferencias->traerAsesores();
}

$cadRef2 = $serviciosFunciones->devolverSelectBox($resAsesores,array(3,4,2),' ');

//////////////////////// Fin opciones ////////////////////////////////////////////////


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

	<link href="../../fullcalendar-3.6.0/fullcalendar.css" rel="stylesheet" />
	<link href="../../fullcalendar-3.6.0/fullcalendar.print.css" rel="stylesheet" media="print" />


	<script src='../../fullcalendar-3.6.0/lib/moment.min.js'></script>
	<script src='../../fullcalendar-3.6.0/lib/jquery.min.js'></script>
	<script src='../../fullcalendar-3.6.0/fullcalendar.min.js'></script>
	<script src='../../fullcalendar-3.6.0/lang/es.js'></script>
	<script src='../../fullcalendar-3.6.0/lib/jquery-ui.custom.min.js'></script>

	<style>
		.alert > i{ vertical-align: middle !important; }
	</style>

	<style>
  .popper,
  .tooltip {
    position: absolute;
    z-index: 9999;
    background: #FFC107;
    color: black;
    width: 150px;
    border-radius: 3px;
    box-shadow: 0 0 2px rgba(0,0,0,0.5);
    padding: 10px;
    text-align: center;
  }
  .style5 .tooltip {
    background: #1E252B;
    color: #FFFFFF;
    max-width: 200px;
    width: auto;
    font-size: .8rem;
    padding: .5em 1em;
  }
  .popper .popper__arrow,
  .tooltip .tooltip-arrow {
    width: 0;
    height: 0;
    border-style: solid;
    position: absolute;
    margin: 5px;
  }

  .tooltip .tooltip-arrow,
  .popper .popper__arrow {
    border-color: #FFC107;
  }
  .style5 .tooltip .tooltip-arrow {
    border-color: #1E252B;
  }
  .popper[x-placement^="top"],
  .tooltip[x-placement^="top"] {
    margin-bottom: 5px;
  }
  .popper[x-placement^="top"] .popper__arrow,
  .tooltip[x-placement^="top"] .tooltip-arrow {
    border-width: 5px 5px 0 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    bottom: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .popper[x-placement^="bottom"],
  .tooltip[x-placement^="bottom"] {
    margin-top: 5px;
  }
  .tooltip[x-placement^="bottom"] .tooltip-arrow,
  .popper[x-placement^="bottom"] .popper__arrow {
    border-width: 0 5px 5px 5px;
    border-left-color: transparent;
    border-right-color: transparent;
    border-top-color: transparent;
    top: -5px;
    left: calc(50% - 5px);
    margin-top: 0;
    margin-bottom: 0;
  }
  .tooltip[x-placement^="right"],
  .popper[x-placement^="right"] {
    margin-left: 5px;
  }
  .popper[x-placement^="right"] .popper__arrow,
  .tooltip[x-placement^="right"] .tooltip-arrow {
    border-width: 5px 5px 5px 0;
    border-left-color: transparent;
    border-top-color: transparent;
    border-bottom-color: transparent;
    left: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }
  .popper[x-placement^="left"],
  .tooltip[x-placement^="left"] {
    margin-right: 5px;
  }
  .popper[x-placement^="left"] .popper__arrow,
  .tooltip[x-placement^="left"] .tooltip-arrow {
    border-width: 5px 0 5px 5px;
    border-top-color: transparent;
    border-right-color: transparent;
    border-bottom-color: transparent;
    right: -5px;
    top: calc(50% - 5px);
    margin-left: 0;
    margin-right: 0;
  }

</style>

<style>
	#calendar {
		max-width: 98%;
		margin: 20px auto;
		padding: 0 10px;
	}

	#script-warning {
    display: none;
    background: #eee;
    border-bottom: 1px solid #ddd;
    padding: 0 10px;
    line-height: 40px;
    text-align: center;
    font-weight: bold;
    font-size: 12px;
    color: red;
  }

  #loading {
    display: none;
    position: absolute;
    top: 10px;
    right: 10px;
  }
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
							<h2 style="color:white;">
								EVENTOS
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
									<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
										<div class="button-demo">
											<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>CREA VISITA DE SEGUIMIENTO</span>
											</button>

										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-xs-3">
										<p>Filtros por Responsable Comercial</p>
									</div>
									<div class="col-lg-6 col-md-6 col-xs-6">
										<select class="form-control refgerentecomercial" name='refgerentecomercial' id='refgerentecomercial'>
											<option value='0'>-- Seleccionar --</option>
											<?php echo $cadRef1; ?>
										</select>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div id='loading'>loading...</div>

   									<div id='calendar'></div>
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

<form class="formulario frmNuevo" role="form" id="sign_in">
<div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header">
					 <h4 class="modal-title" id="largeModalLabel">EVENTO</h4>
				</div>
				<div class="modal-body">
					<div class="row frmAjaxNuevo">
						<div class="row">
							<div class="col-xs-12" align="center">
								<h4>CREAR VISITA DE SEGUIMIENTO</h4>
							</div>

						</div>
						<div class="row">
							<div class="col-lg-2 col-md-2 col-sm-3 col-xs-6" >
							<b>Fecha</b>
								<div class="input-group">
									<span class="input-group-addon">
										<i class="material-icons">date_range</i>
									</span>
									<div class="form-line">
										<input readonly="readonly" style="width:200px;" type="text" class="datepicker form-control" id="fechacreacion" name="fechacreacion" required />
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-xs-6">
								<label for="lblasesor" class="control-label" style="text-align:left">Asesor</label>
								<div class="form-group input-group">
									<select class="form-control refasesores" name='refasesores' id='refasesores' required>
										<option value='0'>-- Seleccionar --</option>
										<?php echo $cadRef2; ?>
									</select>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-6">
								<label class="form-label">Motivo</label>
								<div class="form-group input-group">
									<div class="form-line">
										<input type="text" class="form-control" id="motivo" name="motivo" required/>
										<input type="hidden" name="accion" id="accion" value="insertarAlertas"/>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-3 col-xs-6">
								<label for="lblasesor" class="control-label" style="text-align:left">Gerente Comercial</label>
								<div class="form-group input-group">
									<select class="form-control refusuarios" name='refusuarios' id='refusuarios' required>
										<option value=''>-- Seleccionar --</option>
										<?php echo $cadRef1; ?>
									</select>
								</div>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary waves-effect nuevo">GUARDAR</button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>
</form>


<div class="modal fade" id="lgmNuevo2" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header">
					 <h4 class="modal-title" id="largeModalLabel">EVENTO</h4>
				</div>
				<div class="modal-body">
					<div class="row frmAjaxNuevo2">

					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>

<?php echo $baseHTML->cargarArchivosJS2('../../'); ?>
<!-- Wait Me Plugin Js -->
<script src="../../plugins/waitme/waitMe.js"></script>

<!-- Custom Js -->
<script src="../../js/pages/cards/colored.js"></script>

<script src="../../plugins/jquery-validation/jquery.validate.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>

	$(document).ready(function() {

		var refgerentecomercial = 0;

		$('#fechacreacion').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : new Date()
		});

		function renderCalendar() {
			$('#calendar').fullCalendar({
				locale: 'es',
				header: {
					left: 'prev,next today',
					center: 'title',
					right: 'month,agendaWeek,agendaDay'
				},
				editable: true,
				navLinks: true,
				eventLimit: true,
				eventClick: function(calEvent, jsEvent, view) {
					$('#lgmNuevo2').modal();
					$('.frmAjaxNuevo2').html('<h4>' + calEvent.description + '</h4>');
					$('.frmAjaxNuevo2').append('<h5>Gerente Comercial: ' + calEvent.nombrecompleto + '</h5>');

				},
				events: {
					url: '../../calendarjs/get-events.php',
					method: 'POST',
					data: {
						start: 'start',
						end: 'end',
						timezone: 'timezone',
						refgerentecomercial: refgerentecomercial
					},
					error: function() {
						$('#script-warning').show();
					}
				},
				loading: function(bool) {
					$('#loading').toggle(bool);
				}
			});
		}

		$('#refgerentecomercial').change(function() {
			//refgerentecomercial = $(this).val();
			if ($(this).val()) {
				refgerentecomercial = $(this).val();
				$('#calendar').fullCalendar('destroy');
				renderCalendar();
			}
			//$('#calendar').fullCalendar('refetchEvents');
		});

		renderCalendar();

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
							swal("Ok!", 'Se guardo correctamente el seguimiento', "success");
							$('#calendar').fullCalendar('destroy');
							renderCalendar();
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
