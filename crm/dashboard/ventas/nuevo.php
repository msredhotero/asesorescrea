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
$singular = "Venta";

$plural = "Ventas";

$eliminar = "eliminarVentas";

$insertar = "insertarVentasCompleto";

$modificar = "modificarVentas";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcotizaciones";

$lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor','cobertura','reasegurodirecto','fecharenovacion','fechapropuesta','tiponegocio','presentacotizacion','existeprimaobjetivo','primaobjetivo','tieneasegurado','refasegurados');
$lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor','Cobertura Requiere Reaseguro','Reaseguro Directo con Inbursa o Broker','Fecha renovación o presentación de propueta al cliente','Fecha en que se entrega propuesta','Tipo de negocio para agente','Presenta Cotizacion o Poliza de competencia','Existe Prima Objetivo','Prima Objetivo','Tiene Asegurado','Asegurado');


$cadRef1 	= "<option value='0'>Se genera automaticamente</option>";

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar2	= $serviciosReferencias->traerClientesasesoresPorAsesor($_SESSION['usuaid_sahilices']);
} else {
	$resVar2	= $serviciosReferencias->traerClientes();
}

if (mysql_num_rows($resVar2) > 0) {
	$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(3,4,2),' ');
} else {
	$cadRef2 = "<option value='0'>-- No cargo ningun cliente aun --</option>";
}


$resVar3	= $serviciosReferencias->traerProductos();
$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');


if ($_SESSION['idroll_sahilices'] != 7) {
	$resVar4	= $serviciosReferencias->traerAsociados();
	$cadRef4 = '<option value="0">-- Seleccionar --</option>';
	$cadRef4 .= $serviciosFunciones->devolverSelectBox($resVar4,array(4,2,3),' ');
} else {
	$cadRef4 = '<option value="0">-- Sin valor --</option>';
}

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	if (mysql_num_rows($resVar5)>0) {
		$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(4,2,3),' ');
	} else {
		header('Location: ../index.php');
	}

} else {
	$resVar5	= $serviciosReferencias->traerAsesores();
	$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(4,2,3),' ');
}



$resVar6 = $serviciosReferencias->traerEstadocotizacionesPorId(12);
$cadRef6 = $serviciosFunciones->devolverSelectBox($resVar6,array(1),'');


$cadRef7b = "<option value='Si'>Si</option><option value='No'>No</option><option value='No lo se' selected>No lo se</option>";
$cadRef8b = "<option value='Si'>Si</option><option value='No' selected>No</option>";
$cadRef9b = "<option value='Negocio nuevo' selected>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
$cadRef11b = "<option value='1'>Si</option><option value='0' selected>No</option>";

$cadAsegurado = "<option value='0'>No</option><option value='1'>Otra persona</option>";

$cadRefAsegurado = "<option value='0'>El Contratante</option>";

$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6,6=>$cadRef7b,7=>$cadRef8b,8=>$cadRef9b,9=>$cadRef11b,10=>$cadAsegurado,11=>$cadRefAsegurado);
$refCampo 	=  array('refusuarios','refclientes','refproductos','refasociados','refasesores','refestadocotizaciones','cobertura','presentacotizacion','tiponegocio','existeprimaobjetivo','tieneasegurado','refasegurados');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resEstadoCivil = $serviciosReferencias->traerEstadocivilPorIn('1,2');
$cadRefEstadoCivil = $serviciosFunciones->devolverSelectBox($resEstadoCivil,array(1),'');

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

	<link rel="stylesheet" href="../../css/materialDateTimePicker.css">

	<style>
		.alert > i{ vertical-align: middle !important; }

		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		.tscodigopostal { width: 400px; }

		.ui-autocomplete { position: absolute; cursor: default;z-index:30 !important;}

		.sectionC {
			height:360px;
			z-index:1 !important;
		}

		@media (min-width: 1200px) {
		   .modal-xlg {
		      width: 90%;
		   }
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
							<form class="formulario frmNuevo" role="form" id="sign_in">

								<div class="row" style="padding: 5px 20px;">
									<?php echo $frmUnidadNegocios; ?>
									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContnropoliza" style="display:block">
											<label class="form-label">Nro Poliza </label>
											<div class="form-group input-group">
												<div class="form-line">
													<input type="text" class="form-control" id="nropoliza" name="nropoliza">

												</div>
											</div>
										</div>

										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContfoliotys" style="display:block">
											<label class="form-label">Folio TYS </label>
											<div class="form-group input-group">
												<div class="form-line">
													<input type="text" class="form-control" id="foliotys" name="foliotys">

												</div>
											</div>
										</div>


									</div>

									<div class="row">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContvigenciadesde" style="display:block">
											<label for="vigenciadesde" class="control-label" style="text-align:left">Vigencia Desde </label>
											<div class="form-group input-group">

												<span class="input-group-addon">
													<i class="material-icons">date_range</i>
												</span>
	                                 <div class="form-line">

											   	<input readonly="" style="width:200px;" type="text" class="datepicker form-control" id="vigenciadesde" name="vigenciadesde">

	                                 </div>
	                              </div>
                              </div>

										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContfechavencimientopoliza" style="display:block">
											<label for="fechavencimientopoliza" class="control-label" style="text-align:left">Fecha Vencimiento Poliza </label>
											<div class="form-group input-group">

												<span class="input-group-addon">
													<i class="material-icons">date_range</i>
												</span>
	                                 <div class="form-line">

											   	<input readonly="" style="width:200px;" type="text" class="datepicker form-control" id="fechavencimientopoliza" name="fechavencimientopoliza">

	                                 </div>
	                              </div>
                              </div>

									</div>


									<div class="row" style="margin-top:150px;">
										<hr>
										<div class="button-demo">
											<button type="submit" class="btn bg-light-blue waves-effect btnGuardar">
												<i class="material-icons">save</i>
												<span>GUARDAR</span>
											</button>
										</div>
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



<!-- NUEVO -->
	<form class="formulario frmNuevoASG" role="form" id="sign_in">
	   <div class="modal fade" id="lgmNuevoASG" tabindex="-1" role="dialog">
	       <div class="modal-dialog modal-xlg" role="document">
	           <div class="modal-content">
	               <div class="modal-header">
	                   <h4 class="modal-title" id="largeModalLabel">CARGAR NUEVO ASEGURADO</h4>
	               </div>
	               <div class="modal-body">
							<div class="row">

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContnombre" style="display:block">
									<label class="form-label">Nombre Completo <span style="color:red;">*</span> </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="nombreASG" name="nombre"  required />

										</div>
									</div>
								</div>


								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
									<label class="form-label">Apellido Paterno  <span style="color:red;">*</span> </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="apellidopaternoASG" name="apellidopaterno"  required />

										</div>
									</div>
								</div>


								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContapellidomaterno" style="display:block">
									<label class="form-label">Apellido Materno  <span style="color:red;">*</span> </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="apellidomaternoASG" name="apellidomaterno"  required />

										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContreftipoparentesco" style="display:block">
									<label for="reftipoparentesco" class="control-label" style="text-align:left">Tipo de Parentesco  <span style="color:red;">*</span> </label>
									<div class="form-group input-group col-md-12">
										<div class="form-line">
											<select class="form-control" id="reftipoparentescoASG" name="reftipoparentesco"  required >
												<option value="">-- Seleccionar --</option>
												<option value="1">Padres</option>
												<option value="2">Conyuge</option>
												<option value="3">Hijos</option>
												<option value="4">Otro</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContparentescoASG" style="display:block">
									<label class="form-label">Ingrese el Parentesco  <span style="color:red;">*</span> </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="parentescoASG" name="parentesco" />
										</div>
									</div>
								</div>
							</div>
							<div class="row" style="margin-top:15px;">


								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContcurp" style="display:block">
									<label class="form-label">CURP <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="curpASG" name="curp" maxlength="18" required />
										</div>
									</div>
								</div>


								<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContfechanacimiento" style="display:block">
									<label class="form-label">Fecha De Nacimiento <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="fechanacimientoASG" name="fechanacimiento" required/>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContgenero" style="display:block">
									<label class="form-label">Genero <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<select class="form-control" id="generoASG" name="genero"  required >
												<option value="">-- Seleccionar --</option>
												<option value="Femenino">Femenino</option>
												<option value="Masculino">Masculino</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrefestadocivil" style="display:block">
									<label class="form-label">Estado Civil <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<select class="form-control" id="refestadocivilASG" name="refestadocivil"  required >
												<option value="">-- Seleccionar --</option>
												<?php echo $cadRefEstadoCivil; ?>
											</select>
										</div>
									</div>
								</div>

							</div>


							<div class="row" style="margin-top:15px;">


								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">RFC <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="rfcASG" name="rfc" maxlength="13" required />
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmConttipoidentificacion" style="display:block">
									<label class="form-label">Tipo Identificación <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<select class="form-control" id="reftipoidentificacionASG" name="reftipoidentificacion"  required >
												<option value="">-- Seleccionar --</option>
												<option value="1">INE</option>
												<option value="2">Pasaporte</option>
											</select>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContidentificacion" style="display:block">
									<label class="form-label">No. Identificación <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="identificacionASG" name="nroidentificacion" maxlength="13" required />
										</div>
									</div>
								</div>


							</div>

							<div class="row" style="margin-top:15px;">


								<input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
								<input type="hidden" id="refclientesASG" name="refclientes" value=""/>
							</div>

	               </div>
	               <div class="modal-footer">
	                   <button type="submit" class="btn btn-primary waves-effect nuevoAsegurado">GUARDAR</button>
	                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
	               </div>
	           </div>
	       </div>
	   </div>
		<input type="hidden" id="accion" name="accion" value="insertarAsegurados"/>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../../js/materialDateTimePicker.js"></script>

<script>
	$(document).ready(function(){

		$('#fechacrea').val('20/02/2020');
		$('#fechamodi').val('20/02/2020');
		$('#usuariocrea').val('20/02/2020');
		$('#usuariomodi').val('20/02/2020');

		$('#fechanacimientoASG').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: false
		});

		$('.frmContparentescoASG').hide();

		$('#reftipoparentescoASG').change(function() {
			if ($(this).val() == 4) {
				$('.frmContparentescoASG').show();
				$("#parentescoASG").prop('required',true);
			} else {
				$('.frmContparentescoASG').hide();
				$("#parentescoASG").prop('required',false);
			}
		});

		traerAseguradosPorCliente(0,$('#refclientes').val());

		$('.frmContrefasegurados').hide();
		$('#tieneasegurado').change(function() {
			if ($(this).val() == '1') {
				$('.frmContrefasegurados').show();
				traerAseguradosPorCliente(0,$('#refclientes').val());

			} else {


				$('.frmContrefasegurados').hide();
				$('#refasegurados').html('<option value="0">No</option>');
			}
		});

		$(".frmNuevo").on("change",'#refasegurados', function(){
			if ($('#refasegurados option:selected').text() == 'Nuevo') {
				$('#lgmNuevoASG').modal();
				$('#refclientesASG').val($('#refclientes').val());
			}
		});

		$(".frmNuevo").on("click",'#refasegurados', function(){
			if ($('#refasegurados option:selected').text() == 'Nuevo') {
				$('#lgmNuevoASG').modal();
				$('#refclientesASG').val($('#refclientes').val());
			}
		});

		function traerAseguradosPorCliente(idasegurado, idcliente) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerAseguradosPorCliente', refclientes: idcliente},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#refasegurados').html();
				},
				//una vez finalizado correctamente
				success: function(data){
					$('#refasegurados').html(data.dato);

					$('#refasegurados').val(idasegurado);
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

		$('.frmNuevoASG').submit(function(e){

			e.preventDefault();
			if ($('.frmNuevoASG')[0].checkValidity()) {
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
						$('.frmContparentescoASG').hide();
					},
					//una vez finalizado correctamente
					success: function(data){

						if (data.error == false) {
							swal("Ok!", 'Se guardo correctamente el asegurado', "success");

							$('#lgmNuevoASG').modal('hide');

							traerAseguradosPorCliente(data.id, $('#refclientes').val());

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

		$('.frmContfechavencimiento').hide();
		$('.frmContfecharenovacion').hide();
		$('.frmContfechaemitido').hide();
		$('.frmContrefusuarios').hide();
		$('.frmContfechavencimiento').hide();
		$('.frmContcoberturaactual').hide();
		$('.frmContbitacoracrea').hide();
		$('.frmContbitacorainbursa').hide();
		$('.frmContbitacoraagente').hide();
		$('.frmContversion').hide();
		$('.frmContfolio').hide();
		$('.frmContrefcotizaciones').hide();
		$('.frmContrefestados').hide();
		$('.frmContrefestadocotizaciones').hide();
		$('.frmContcobertura').hide();
		$('.frmContreasegurodirecto').hide();
		$('.frmConttiponegocio').hide();
		$('.frmContpresentacotizacion').hide();
		$('.frmContfechapropuesta').hide();
		$('.frmContrefbeneficiarios').hide();
		$('#refbeneficiarios').val(0);

		$('#primaneta').number( true, 2 ,'.','');
		$('#primatotal').number( true, 2 ,'.','');
		$('#primaobjetivo').number( true, 2 ,'.','');



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=especialidades",
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
