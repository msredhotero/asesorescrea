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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../invitacion/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Invitacion",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Enviar la liga de venta a tu cliente";

$plural = "Enviar la liga de venta a tu cliente";

$eliminar = "eliminarMejorarcondiciones";

$insertar = "insertarMejorarcondiciones";

$modificar = "modificarMejorarcondiciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$singular2 = "Cliente";

$tabla2 			= "dbclientes";

$lblCambio2	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonofijo','telefonocelular','reftipopersonas','numerocliente','razonsocial','emisioncomprobantedomicilio','emisionrfc','vencimientoine','idclienteinbursa','nroexterior','nrointerior','codigopostal','ine','rfc','curp','refestadocivil','reftipoidentificacion','nroidentificacion');
$lblreemplazo2	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Fijo','Tel. Celular','Tipo Persona','Nro Cliente','Razon Social','Fecha Emision Compr. Domicilio','Fecha Emision RFC','Vencimiento INE','ID Cliente Inbursa','Nro Exterior','No. Interior','Cod. Postal','INE','RFC','CURP','Estado Civil','Tipo de Identificación','No Identificación');


$resVar82 = $serviciosReferencias->traerTipopersonas();
$cadRef82 = $serviciosFunciones->devolverSelectBox($resVar82,array(1),'');

$resVar92 = $serviciosReferencias->traerEstadocivilPorIn('1,2');
$cadRef92 = $serviciosFunciones->devolverSelectBox($resVar92,array(1),'');



$cadRef102 = "<option value='Femenino'>Femenino</option><option value='Masculino'>Masculino</option>";

$resVar112 = $serviciosReferencias->traerTipoidentificacion();
$cadRef112 = $serviciosFunciones->devolverSelectBox($resVar112,array(1),'');

$refdescripcion = array(0=>$cadRef82,1=>$cadRef92,2=>$cadRef102,3=>$cadRef112);
$refCampo 	=  array('reftipopersonas','refestadocivil','genero','reftipoidentificacion');

$refdescripcion2 = array(0=>$cadRef82,1=>$cadRef92,2=>$cadRef102,3=>$cadRef112);
$refCampo2 	=  array('reftipopersonas','refestadocivil','genero','reftipoidentificacion');

$frmUnidadNegocios2 	= $serviciosFunciones->camposTablaViejo('insertarClientes' ,$tabla2,$lblCambio2,$lblreemplazo2,$refdescripcion2,$refCampo2);

/////////////////////// Opciones para la creacion del formulario  /////////////////////

if ($_SESSION['refroll_sahilices'] == 7) {
	
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	$idasesor = mysql_result($resVar5,0,'idasesor');
} else {
	$idasesor = 25;
}


$resProductos = $serviciosReferencias->traerProductosVentaEnLinea(0);
$cadRef1 = $serviciosFunciones->devolverSelectBox($resProductos,array(1),'');

$resLstClientes = $serviciosReferencias->traerClientesasesoresPorAsesor($_SESSION['usuaid_sahilices']);
$cadRef2 = $serviciosFunciones->devolverSelectBox($resLstClientes,array(18),'');

$resTipoProducto = $serviciosReferencias->traerTipoproductoPorIn('2,3');
$cadRef7 = $serviciosFunciones->devolverSelectBox($resTipoProducto,array(1),' ');

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

	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">

	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

	<style>
		.alert > i{ vertical-align: middle !important; }
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }

		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		#codigopostal { width: 400px; }

		  .thumbnail2 {
		    display: block;
		    padding: 4px;
		    margin-bottom: 20px;
		    line-height: 1.42857143;
		    background-color: #fff;
		    border: 1px solid #ddd;
		    border-radius: 4px;
		    -webkit-transition: border .2s ease-in-out;
		    -o-transition: border .2s ease-in-out;
		    transition: border .2s ease-in-out;
			 text-align: center;
		}
		.progress {
			background-color: #1b2646;
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

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<form class="formulario frmNuevo2" role="form" id="sign_in">
										<div class="row">
											<!-- para el cliente -->
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrfc" style="display:block">
												<label class="form-label">RFC <span class="erroresRFC"></span></label>
												<div class="form-group input-group">
													<div class="form-line">
														<input maxlength="13" type="text" class="form-control" id="rfc" name="rfc">

													</div>
													
												</div>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
												<div class="form-group input-group" style="martin-top:20px;">
													<button type="button" class="btn btn-lg btn-success waves-effect btnBuscarRFC">BUSCAR RFC</button>
												</div>
											</div>
										</div>
										<div class="row">
											<!-- para el cliente -->
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrfc" style="display:block">
												<label class="form-label">CURP <span style="color:red;">*</span> <span class="erroresCURP"></span></label>
												<div class="form-group input-group">
													<div class="form-line">
														<input maxlength="18" type="text" class="form-control" id="curp" name="curp" required="" aria-required="true">

													</div>
													<div class="elementor-text-editor elementor-clearfix">
														|<p>Puedes consultar tu CURP en el siguiente enlace: <a href="https://www.gob.mx/curp/" target="_blank">https://www.gob.mx/curp/</a></p>
													</div>
												</div>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContapellidopaterno" style="display:block">
												<div class="form-group input-group" style="martin-top:20px;">
													<button type="button" class="btn btn-lg btn-success waves-effect btnBuscarCURP">BUSCAR CURP</button>
												</div>
											</div>
										</div>
										<div class="row">

											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
												<label class="form-label">Email  <span style="color:red;">*</span></label>
												<div class="form-group input-group">
													<div class="form-line">
														<input type="email" class="form-control" id="email" name="email">

													</div>
												</div>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
												<label class="form-label">Teléfono Movil </label>
												<div class="form-group input-group">
													<div class="form-line">
														<input type="text" class="form-control" id="telefonomovil" name="telefonomovil">

													</div>
												</div>
											</div>

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contDatosCliente" style="display:block">
												<div class="row">
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Apellido Paterno</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="apellidopaterno" name="apellidopaterno" readonly>

															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Apellido Materno</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="apellidomaterno" name="apellidomaterno" readonly>

															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Nombre</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="nombre" name="nombre" readonly>

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Fecha Nacimiento</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="date" class="form-control" id="fechanacimiento" name="fechanacimiento" >

															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Genero</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="genero" name="genero" readonly>

															</div>
														</div>
													</div>
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Estado Civil</label>
														<div class="form-group input-group">
															<div class="form-line">
																<select class="form-control" name="refestadocivil" id="refestadocivil">
																	<option value="7">No indico</option>
																	<option value="1">Soltero</option>
																	<option value="2">Casado</option>
																</select>

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Calle</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="domicilio" name="domicilio" >

															</div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">No. Exterior</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="nroexterior" name="nroexterior" >

															</div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">No. Interior</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="nrointerior" name="nrointerior" >

															</div>
														</div>
													</div>
													<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Edificio</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="edificio" name="edificio" >

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Estado</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="estado" name="estado" >

															</div>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Colonia</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="colonia" name="colonia" >

															</div>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Municipio</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="municipio" name="municipio" >

															</div>
														</div>
													</div>
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Ciudad</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="ciudad" name="ciudad" >

															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Cod. Postal</label>
														<div class="form-group input-group">
															<div class="form-line">
																<input type="text" class="form-control" id="codigopostal" name="codigopostal" >

															</div>
														</div>
													</div>

													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">Tipo de Registro</label>
														<div class="form-group input-group">
															<div class="form-line">
																<select class="form-control" id="reftiporegistro" name="reftiporegistro">
																	<option value="1">Registro + Producto</option>
																	<option value="2">Registro Simple</option>
																</select>
															</div>
														</div>
													</div>

													<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
														<label class="form-label">PRODUCTO/SERVICIO <span class="valorproducto"></span></label>
														<div class="form-group input-group">
															<div class="form-line">
																<select class="form-control" id="refproductos" name="refproductos">
																	<option value="41">VRIM PLATINO - $ 1,501.00</option>
																	<option value="54">SEGURO DE VIDA 500</option>
																</select>
															</div>
														</div>
														
													</div>
												</div>
											</div>


										</div>

										<hr>
										<div class="row btnGenerar" style="padding:20px 50px; ">
											<div class="form-group input-group" style="martin-top:20px;">
												<button type="submit" class="btn btn-lg btn-success waves-effect btnGenerarEnviar">GENERAR LIGA Y ENVIAR</button>
											</div>


											<div class="form-group input-group" style="martin-top:20px;">
												<div class="form-line">
													<label class="form-label">URL:</label>
													<input type="text" readonly name="url" id="url" class="form-control"/>
												</div>
											</div>

										</div>

										<input type="hidden" name="accion" id="accion" value="registrarEnviarCotizadorAlCliente"/>

										</form>

									</div>

								</div>

								


							</div>
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
							 <h4 class="modal-title" id="largeModalLabel">ELIMINAR EL REGISTRO</h4>
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
		<input type="hidden" id="accion" name="accion" value="eliminarTokenasesores"/>
		<input type="hidden" name="ideliminar" id="ideliminar" value="0">
	</form>

<?php echo $baseHTML->cargarArchivosJS('../../'); ?>
<!-- Wait Me Plugin Js -->
<script src="../../plugins/waitme/waitMe.js"></script>

<!-- Custom Js -->
<script src="../../js/pages/cards/colored.js"></script>

<script src="../../plugins/jquery-validation/jquery.validate.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../js/jquery.blockUI.js"></script>

<script>

	$(document).ready(function(){

		$('#reftiporegistro').change(function() {
			if ($(this).val() == 1) {
				$('#refproductos').html('<option value="41">VRIM PLATINO - $ 1,501.00</option>');
			} else {
				$('#refproductos').html('<option value="1">VIDA</option><option value="2">AUTOS</option><option value="3">GASTOS MÉDICOS</option><option value="4">PROTECCIÓN HOGAR</option><option value="5">CRÉDITO HIPOTECARIO</option><option value="6">CUENTA DE AHORRO</option><option value="7">TARJETA DE CRÉDITO</option><option value="8">CRÉDITO TELMEX</option>');
			}
			
		});

		$('.btnGenerarEnviar').hide();

		function existeCliente(dato,tipo) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'existeClientePorTipo',
					dato: dato,
					tipo: tipo
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnGenerarEnviar').hide();

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {
						$('.btnGenerarEnviar').show();

					} else {
						$('.btnGenerarEnviar').hide();
						swal({
							title: "Respuesta",
							text: tipo + " ya existe en nuestro sistema!!",
							type: "error",
							timer: 1500,
							showConfirmButton: false
						});


					}
				},
				//si ha ocurrido un error
				error: function(){
					swal({
						title: "Respuesta",
						text: " Actualice la pagina!!",
						type: "error",
						timer: 1500,
						showConfirmButton: false
					});
					
				}
			});
		}

		$('.btnBuscarRFC').click(function() {
			existeCliente($('#rfc').val(),'rfc');
			traerRFC($('#rfc').val());
		});

		$('.btnBuscarCURP').click(function() {
			existeCliente($('#curp').val(),'curp');
			traerCURP($('#curp').val());
		});

		function traerRFC(rfc) {
			$.blockUI({ message: '<h4>Buscando...</h4>' });

			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'buscarRFC',
					rfc: rfc,
					tipopersona: 1
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.erroresRFC').html('');
					$('#domicilio').val('');
					$('#nroexterior').val('');
					$('#nrointerior').val('');
					$('#email').val('');
					$('#estado').val('');
					$('#colonia').val('');
					$('#municipio').val('');
					$('#codigopostal').val('');

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {

						$('.erroresRFC').html('<h4>RFC valido</h4>');
						$('#nombre').val(data.datos[0].nombres);
						$('#apellidopaterno').val(data.datos[0].apellidoPaterno);
						$('#apellidomaterno').val(data.datos[0].apellidoMaterno);
						$('#fechanacimiento').val(data.datos[0].fechaNacimiento);
						$('#telefonomovil').val(data.datos[0].desTelefono);
						$('#curp').val(data.datos[0].curp);
						if (data.datos[0].sexo == 'H') {
							$('#genero').val('Masculino');
						} else {
							$('#genero').val('Femenino');
						}
						
						$('#domicilio').val(data.datos[0].calle);
						$('#nroexterior').val(data.datos[0].numeroExterior);
						$('#nrointerior').val(data.datos[0].numeroInterior);
						$('#email').val(data.datos[0].correoElectronico);
						$('#estado').val(data.datos[0].entidadFederativa);
						$('#colonia').val(data.datos[0].colonia);
						$('#municipio').val(data.datos[0].municipio);
						$('#codigopostal').val(data.datos[0].codigoPostal);

						setTimeout($.unblockUI, 2000);
						

					} else {
						$('.erroresRFC').html('<h4 style="color:#F00 !important;">' + data.mensaje + '</h4>');

						setTimeout($.unblockUI, 2000);


					}
				},
				//si ha ocurrido un error
				error: function(){
					$('.erroresRFC').html('<h4>Actualice la pagina</h4>');
					setTimeout($.unblockUI, 2000);
				}
			});
		}


		function traerCURP(curp) {
			$.blockUI({ message: '<h4>Buscando...</h4>' });

			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'buscarCURP',
					curp: curp
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.erroresCURP').html('');
					$('#rfc').val('');
					$('#domicilio').val('');
					$('#nroexterior').val('');
					$('#nrointerior').val('');
					$('#email').val('');
					$('#estado').val('');
					$('#colonia').val('');
					$('#municipio').val('');
					$('#codigopostal').val('');
				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {

						$('.erroresCURP').html('<h4>CURP valido</h4>');
						
						$('#nombre').val(data.datos[0].nombres);
						$('#apellidopaterno').val(data.datos[0].apellidoPaterno);
						$('#apellidomaterno').val(data.datos[0].apellidoMaterno);
						$('#fechanacimiento').val(data.datos[0].fechaNacimiento);
						$('#telefonomovil').val(data.datos[0].desTelefono);
						
						if (data.datos[0].sexo == 'H') {
							$('#genero').val('Masculino');
						} else {
							$('#genero').val('Femenino');
						}
						$('#email').val(data.datos[0].email);

						setTimeout($.unblockUI, 2000);
			

					} else {
						$('.erroresCURP').html('<h4 style="color:#F00 !important;">' + data.mensaje + '</h4>');

						setTimeout($.unblockUI, 2000);

					}
				},
				//si ha ocurrido un error
				error: function(){
					$('.erroresCURP').html('<h4>Actualice la pagina</h4>');
					setTimeout($.unblockUI, 2000);

				}
			});
		}

		function frmAjaxEliminar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarTokenasesores', id: id},
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

		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=tokenasesores&idasesor=<?php echo $idasesor; ?>",
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

		/*
		$('.btnGenerarEnviar').click(function() {
			if ( ($('#apellidopaterno').val() == '') || ($('#email').val() == '')) {
				swal({
					title: "Error",
					text: 'Debe completar todos los campos',
					type: "error",
					timer: 2000,
					showConfirmButton: false
				});
			} else {
				traerRegistrarEnviarCotizadorAlCliente();
			}

		});
		*/

		function traerRegistrarEnviarCotizadorAlCliente() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'registrarEnviarCotizadorAlCliente',
					idasesor: <?php echo $idasesor; ?>,
					apellidopaterno: $('#apellidopaterno').val(),
					apellidomaterno: $('#apellidomaterno').val(),
					nombre: $('#nombre').val(),
					email: $('#email').val(),
					tipoaccion: '2'
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal({
							title: "Respuesta",
							text: 'Se genero correctamente la liga',
							type: "success",
							timer: 2000,
							showConfirmButton: false
						});
						$('#url').val(data.url);

						$('#apellidopaterno').val('');
						$('#apellidomaterno').val('');
						$('#nombre').val('');
						$('#email').val('');

						table.ajax.reload();

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


		var options2 = {
			url: "../../json/jsbuscarclientes.php",

			getValue: function(element) {
				return element.nombrecompleto;
			},

			ajaxSettings: {
		        dataType: "json",
		        method: "POST",
		        data: {
		            busqueda: $("#lstjugadores").val()
		        }
		    },

		    preparePostData: function (data) {
		        data.busqueda = $("#lstjugadores").val();
				  data.idasesor = <?php echo $idasesor; ?>;
				  data.tipopersona = $('#reftipopersonasaux').val();
		        return data;
		    },

			list: {
			   maxNumberOfElements: 15,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#lstjugadores").getSelectedItemData().id;

					$('#refclientes').val(value);
					$('.clienteSelect').html($("#lstjugadores").getSelectedItemData().nombrecompleto);
					$('#reftipopersonasaux').val($("#lstjugadores").getSelectedItemData().reftipopersonas);
					$('.btnGenerar').show();
					//traerClientescarteraPorCliente(value);
				}/*,
				onHideListEvent: function() {
					$('.clienteSelect').html('');
					$('#selction-ajax').hide();
					$('#refclientes').html('');
				}*/
			},
			theme: "square"
		};

		$("#lstjugadores").easyAutocomplete(options2);

		var options = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $("#frmClienteNuevo #codigopostal").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $("#frmClienteNuevo #codigopostal").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#frmClienteNuevo #codigopostal").getSelectedItemData().codigo;
					$("#frmClienteNuevo #codigopostal").val(value);
					$("#frmClienteNuevo #municipio").val($("#frmClienteNuevo #codigopostal").getSelectedItemData().municipio);
					$("#frmClienteNuevo #estado").val($("#frmClienteNuevo #codigopostal").getSelectedItemData().estado);
					$("#frmClienteNuevo #colonia").val($("#frmClienteNuevo #codigopostal").getSelectedItemData().colonia);


				}
			}
		};

		$("#codigopostal").easyAutocomplete(options);



		function traerClientesCotizador(asesor,tipopersona) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'traerClientesCotizador',
					asesor: <?php echo $idasesor; ?>,
					tipopersona: tipopersona
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#refclientes').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					$('#refclientes').html(data.datos);
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

		$('.frmNuevo2').submit(function(e){

			e.preventDefault();
			if ($('.frmNuevo2')[0].checkValidity()) {


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

						if (data.error == false) {
							swal({
								title: "Respuesta",
								text: "Registro Creado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
							});

							traerClientesCotizador(1,1);

						} else {
							swal({
								title: "Respuesta",
								text: data.mensaje,
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

		$('#refclientes').change(function() {
			if ($(this).val() != '') {
				$('.btnGenerar').show();
			} else {
				$('.btnGenerar').hide();
			}

		});



		$('.escondido3').hide();

		$('.btnCN').click(function() {
			$('.escondido3').hide();
			$('#lgmNuevo2 .frmContreftipopersonas').hide();

			$('#lgmNuevo2').modal();
			$('#lgmNuevo2 .frmContrazonsocial').hide();

			$('.btnCE').css("opacity", 0.2);
			$('.btnCN').css("opacity", 1);
		});

		$('.btnCE').click(function() {

			$('.escondido3').show();
			$('.btnCE').css("opacity", 1);
			$('.btnCN').css("opacity", 0.2);

			traerClientesCotizador(1,1);

		});

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);
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

						if (data.error) {

							swal({
								title: "Respuesta",
								text: data.msgerror,
								type: "error",
								timer: 2500,
								showConfirmButton: false
							});


						} else {
							swal({
								title: "Respuesta",
								text: 'Cargado correctamente',
								type: "success",
								timer: 2500,
								showConfirmButton: false
							});

							table.ajax.reload();

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
