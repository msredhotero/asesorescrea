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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../postulantes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Postulantes",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$id = $_GET['id'];

////////// validar solo que pueda ingrear los perfiles permitidos /////////////////////////


//////////////       FIN                  /////////////////////////////////////////////////

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular2 = "URL Prueba Psicometrica";

$plural2 = "URL Prueba Psicometrica";

$singular = "Evaluación VERITAS";

$plural = "Evaluación VERITAS";

$eliminar = "eliminarEntrevistas";

$insertar = "insertarEntrevistas";

$modificar = "modificarEntrevistas";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resultado 		= 	$serviciosReferencias->traerPostulantesPorId($id);

$urlprueba = mysql_result($resultado,0,'urlprueba');

$postulante = mysql_result($resultado,0,'nombre').' '.mysql_result($resultado,0,'apellidopaterno').' '.mysql_result($resultado,0,'apellidomaterno');

$resGuia = $serviciosReferencias->traerGuiasPorEsquemaEspecial(mysql_result($resultado,0,'refesquemareclutamiento'));

$resEstadoSiguiente = $serviciosReferencias->traerGuiasPorEsquemaSiguiente(mysql_result($resultado,0,'refesquemareclutamiento'), mysql_result($resultado,0,'refestadopostulantes'));

if (mysql_num_rows($resEstadoSiguiente) > 0) {
	$estadoSiguiente = mysql_result($resEstadoSiguiente,0,'refestadopostulantes');
} else {
	$estadoSiguiente = 1;
}

$tabla 			= "dbentrevistas";

$lblCambio	 	= array('refpostulantes','codigopostal','refestadopostulantes','refestadoentrevistas','refentrevistasucursales');
$lblreemplazo	= array('Postulante','Cod. Postal','Estado Postulante','Estado Entrevista','Entrev. Sucursales');

$resVar2	= $serviciosReferencias->traerPostulantesPorId($id);
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(2,3,4),' ');

$resVar3	= $serviciosReferencias->traerEstadopostulantesPorId(2);
$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');

$resVar4	= $serviciosReferencias->traerEstadoentrevistasPorId(1);
$cadRef4 = $serviciosFunciones->devolverSelectBox($resVar4,array(1),'');

$resVar5 = $serviciosReferencias->traerEntrevistasucursales();
$cadRef5 = "<option value='0'>Manual</option>";
$cadRef5 .= $serviciosFunciones->devolverSelectBox($resVar5,array(4,5),' - CP: ');

$refdescripcion = array(0=> $cadRef2,1=> $cadRef3,2=> $cadRef4,3=> $cadRef5);
$refCampo 	=  array('refpostulantes','refestadopostulantes','refestadoentrevistas','refentrevistasucursales');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resEntrevista = $serviciosReferencias->traerEntrevistasActivasPorPostulanteEstadoPostulante($id,2);

if (mysql_num_rows($resEntrevista) > 0) {
	$existe = 1;
} else {
	$existe = 0;
}

$resEntrevistaRegional = $serviciosReferencias->traerEntrevistasActivasPorPostulanteEstadoPostulante($id,4);

if (mysql_num_rows($resEntrevistaRegional) > 0) {
	$primerEntrevistaDia = substr(str_replace('-','/', mysql_result($resEntrevistaRegional,0,'fecha')),0,10);
	$fechaPE = date($primerEntrevistaDia);
	$nuevafecha = strtotime ( '+0 day' , strtotime ( $fechaPE ) ) ;
	$primerEntrevistaDia = date ( 'Y-m-d' , $nuevafecha );
	//die(var_dump($primerEntrevistaDia));
	if (mysql_result($resEntrevistaRegional,0,'refestadoentrevistas') != 2) {
		$leyendaPrimerEntrevista = 'Recuerde que tiene la Entrevista Regional en estado de :<b> '.mysql_result($resEntrevistaRegional,0,'estadoentrevista').'</b>';
	} else {
		$leyendaPrimerEntrevista = 'Entrevista Regional <b>'.mysql_result($resEntrevistaRegional,0,'estadoentrevista').'</b>';
	}

} else {
	$primerEntrevistaDia = 'new Date()';
	$leyendaPrimerEntrevista = 'No se cargo la Entrevista Regional';
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


	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		#codigopostal { width: 400px; }
		.arriba { z-index:999999 !important; }
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

					if ($rowG['refestadopostulantes'] == $estadoSiguiente) {
						$lblEstado = 'active';
					}

					if (($lblEstado == 'complete') || ($lblEstado == 'active')) {
						$urlAcceso = $rowG['url'].'?id='.$id;
					} else {
						$urlAcceso = 'javascript:void(0)';
					}
				?>
				<div class="col-xs-2 bs-wizard-step <?php echo $lblEstado; ?>">
					<div class="text-center bs-wizard-stepnum">Paso <?php echo $i; ?></div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="<?php echo $urlAcceso; ?>" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center"><?php echo $rowG['estadopostulante']; ?></div>
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
								<?php echo strtoupper($plural2); ?> - POSTULANTE: <?php echo $postulante; ?>
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
											<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
											<?php if ($existe == 1) { ?>
											<button type="button" class="btn bg-green waves-effect btnContinuar">
												<i class="material-icons">add</i>
												<span>CONTINUAR</span>
											</button>
											<?php } ?>
											<?php } ?>
										</div>
									</div>
								</div>

								<div class="row" style="padding: 5px 20px;">

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label">URL</label>
										<div class="form-group input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="urlprueba" name="urlprueba" required="" aria-required="true" value="<?php echo $urlprueba; ?>">

											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label"> </label>
										<div class="form-group input-group">
											<div class="form-line">
												<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
												<button type="button" class="btn btn-primary waves-effect modificarURL">GUARDAR</button>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>

				<div class="row">

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2>
									<?php echo strtoupper($plural); ?> - POSTULANTE: <?php echo $postulante; ?>
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
												<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
												<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
													<i class="material-icons">add</i>
													<span>NUEVO</span>
												</button>
												<?php } ?>
												<div class="row">
													<div class="alert alert-info">
														<?php echo $leyendaPrimerEntrevista; ?>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="row" style="padding: 5px 20px;">

										<table id="example" class="display table " style="width:100%">
											<thead>
												<tr>
													<th>Entrevistador</th>
													<th>Fecha</th>
													<th>Domicilio</th>
													<th>Codigo Postal</th>
													<th>Estado</th>
													<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
													<th>Fecha Crea</th>
													<th>Acciones</th>
													<?php } ?>
												</tr>
											</thead>
											<tfoot>
												<tr>
													<th>Entrevistador</th>
													<th>Fecha</th>
													<th>Domicilio</th>
													<th>Codigo Postal</th>
													<th>Estado</th>
													<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
													<th>Fecha Crea</th>
													<th>Acciones</th>
													<?php } ?>
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
								<input type="hidden" class="codipostalaux" id="codipostalaux" name="codipostalaux" value="0"/>
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
								<input type="hidden" class="codipostalaux" id="codipostalaux" name="codipostalaux" value="0"/>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../../js/datepicker-es.js"></script>

<script src="../../js/dateFormat.js"></script>
<script src="../../js/jquery.dateFormat.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script>
	$(document).ready(function(){

		$('#fecha').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'mx',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : '<?php echo $primerEntrevistaDia; ?>'
		});

		var options = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $("#codigopostal").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $("#codigopostal").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var id = $("#codigopostal").getSelectedItemData().id;
					var value = $("#codigopostal").getSelectedItemData().codigo;
					$(".codipostalaux").val(id);
					$("#codigopostal").val(value);

				}
			}
		};


		var options2 = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $("#codigopostal2").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $("#codigopostal2").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var id = $("#codigopostal2").getSelectedItemData().id;
					var value = $("#codigopostal2").getSelectedItemData().codigo;
					$(".codipostalaux").val(id);
					$("#codigopostal2").val(value);

				}
			}
		};

		$("#codigopostal").easyAutocomplete(options);

		$('#usuariocrea').val('marcos');
		$('#usuariomodi').val('marcos');
		$('#ultimoestado').val(0);

		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=entrevistas&id=<?php echo $id; ?>&idestado=2",
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

		traerEntrevistasucursalesPorId(0,'new');

		$(".frmAjaxNuevo").on("change",'#refentrevistasucursales', function(){
			traerEntrevistasucursalesPorId($(this).val(), 'new');
		});

		$(".frmAjaxModificar").on("change",'#refentrevistasucursales', function(){
			traerEntrevistasucursalesPorId($(this).val(), 'edit');
		});

		function traerEntrevistasucursalesPorId(id, contenedor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerEntrevistasucursalesPorId',id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						if (contenedor == 'new') {
							$('.frmAjaxNuevo #domicilio').val(data.domicilio);
							$('.frmAjaxNuevo .codigopostalaux').val(data.refpostal);
							$('.frmAjaxNuevo #codigopostal').val(data.codigopostal);
						} else {
							$('.frmAjaxModificar #domicilio').val(data.domicilio);
							$('.frmAjaxModificar .codigopostalaux').val(data.refpostal);
							$('.frmAjaxModificar #codigopostal2').val(data.codigopostal);
						}

					} else {
						swal("Error!", 'Se genero un error al traer datos', "warning");

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

		function frmAjaxModificar(id, options2) {
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
						$('.show-tick').selectpicker({
							liveSearch: true
						});
						$('.show-tick').selectpicker('refresh');

						$('#fecha').bootstrapMaterialDatePicker({
							format: 'YYYY/MM/DD HH:mm',
							lang : 'mx',
							clearButton: true,
							weekStart: 1,
							time: true
						});

						$("#codigopostal2").easyAutocomplete(options2);

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
						location.reload();
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
			frmAjaxModificar(idTable, options2);
			$('#lgmModificar').modal();
		});//fin del boton modificar

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

						if (data == '') {
							swal({
									title: "Respuesta",
									text: "Registro Creado con exito!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

							$('#lgmNuevo').modal('hide');

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

		<?php if ($urlprueba == '') { ?>
		$('.btnContinuar').hide();
		<?php } ?>

		$('.maximizar').click(function() {
			if ($('.icomarcos').text() == 'web') {
				$('#marcos').show();
				$('.content').css('marginLeft', '265px');
				$('.icomarcos').html('aspect_ratio');
			} else {
				$('#marcos').hide();
				$('.content').css('marginLeft', '15px');
				$('.icomarcos').html('web');
			}

		});

		function modificarEstadoPostulante(id, idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'modificarEstadoPostulante',id: id, idestado: idestado},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$(location).attr('href',data);

					} else {
						swal("Error!", 'Se genero un error al modificar el estado del postulante', "warning");

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


		function modificarURLpostulante(id, urlprueba) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'modificarURLpostulante',idpostulante: id, urlprueba: urlprueba},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.modificarURL').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					var var2=data.replace("\n","");

					if (var2 == 'cargado') {
						swal({
								title: "Respuesta",
								text: "Registro Cargado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});

						$('.modificarURL').show();

						if ($('#urlprueba').val() != '') {
							$('.btnContinuar').show();
						} else {
							$('.btnContinuar').hide();
						}


					} else {
						swal("Error!", 'Se genero un error al modificar el estado del postulante', "warning");

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

		$('.btnContinuar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 5);
		});

		$('.modificarURL').click(function() {
			modificarURLpostulante(<?php echo $id; ?>, $('#urlprueba').val());
		});


	});
</script>








</body>
<?php } ?>
</html>
