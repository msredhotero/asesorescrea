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
include ('../../includes/funcionesPostal.php');


$serviciosFunciones 		= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML 					= new BaseHTML();
$serviciosPostal        = new serviciosPostal();

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

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Domicilio";

$plural = "Domicilio Asesor";

$eliminar = "eliminarDomicilios";

$insertar = "insertarDomicilios";

$modificar = "modificarDomicilios";

//////////////////////// Fin opciones ////////////////////////////////////////////////

$id = $_GET['id'];

$resultado = $serviciosReferencias->traerAsesoresPorId($id);

$resDomicilio = $serviciosReferencias->traerDomiciliosPorTablaReferencia(1, 'dbasesores', 'idasesor', $id);

if (mysql_num_rows($resDomicilio) <= 0) {
	$idDomicilio = $serviciosReferencias->insertarDomicilios(1,$id,'','','','','','','');
	$resDomicilio = $serviciosReferencias->traerDomiciliosPorId($idDomicilio);
}

//$resasdasd = $serviciosReferencias->migrarPostulante($id,'marcosborrar');
//die(var_dump($resasdasd));

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbdomicilios";

$lblCambio	 	= array('numeroext','numeroint','codigopostal');
$lblreemplazo	= array('Nro Ext.','Nro Int.','Cod. Postal');

$resEstado = $serviciosPostal->devolverComboHTML('estado', '');
$cadRef1 = "<option value=''>-- Seleccionar --</option>";
$cadRef1 .= $serviciosFunciones->devolverSelectBoxActivoText($resEstado,array(0),'', mysql_result($resDomicilio,0,'estado'));


$filtroM = array();
$filtroM["estado"] = mysql_result($resDomicilio,0,'estado');
$filtro = (object)$filtroM;

$resMunicipio = $serviciosPostal->devolverComboHTML('municipio', $filtro);
$cadRef2 = "<option value=''>-- Seleccionar --</option>";
$cadRef2 .= $serviciosFunciones->devolverSelectBoxActivoText($resMunicipio,array(0),'', mysql_result($resDomicilio,0,'delegacion'));

$filtroC = array();
$filtroC["municipio"] = mysql_result($resDomicilio,0,'delegacion');
$filtro = (object)$filtroC;

$resColonia = $serviciosPostal->devolverComboHTML('colonia', $filtro);
$cadRef3 = "<option value=''>-- Seleccionar --</option>";
$cadRef3 .= $serviciosFunciones->devolverSelectBoxActivoText($resColonia,array(0),'', mysql_result($resDomicilio,0,'colonia'));



$refdescripcion = array(0=>$cadRef1,1=>$cadRef2,2=>$cadRef3);
$refCampo 	=  array('estado','delegacion','colonia');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaModificar(mysql_result($resDomicilio,0,'iddomicilio'),'iddomicilio',$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
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

	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">

	<link rel="stylesheet" type="text/css" href="../../css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="../../css/classic.date.css"/>


	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

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

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2 style="color:white;">
								<?php echo strtoupper($plural).": ".mysql_result($resultado,0,'apellidopaterno')." ".mysql_result($resultado,0,'apellidomaterno')." ".mysql_result($resultado,0,'nombre'); ?>
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
							<form class="form" id="sign_in" role="form">

								<div class="row frmAjaxModificar">
									<?php echo $frmUnidadNegocios; ?>
								</div>
								<div class="button-demo">
									<button type="submit" class="btn bg-light-blue waves-effect modificarDomicilio">
										<i class="material-icons">save</i>
										<span>GUARDAR</span>
									</button>
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

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script>
	$(document).ready(function(){

		$('.frmContreftabla').hide();
		$('.frmContidreferencia').hide();

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});


		function llenarCombosGral(dato, filtro, contenedor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'llenarCombosGral',dato: dato, filtro: JSON.stringify(filtro)},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#'+contenedor).html('');
				},
				//una vez finalizado correctamente
				success: function(data){
					if (dato == 'codigopostal') {
						$('#'+contenedor).val(data);
					} else {
						$('#'+contenedor).html(data);
					}

				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});

		}

		function loadMunicipios() {
			var data = [{"estado": $('#estado').val()}];
			llenarCombosGral('municipio', data, 'delegacion');
		}

		function loadColonia() {
			var data = [{"municipio":$('#delegacion').val()}];
			llenarCombosGral('colonia', data, 'colonia');
		}

		function loadPostal() {
			var data = [{"municipio":$('#delegacion').val(),"colonia":$('#colonia').val()}];
			llenarCombosGral('codigopostal', data, 'codigopostal');
		}

		$('#estado').change(function() {
			loadMunicipios();
		});

		$('#delegacion').change(function() {
			loadColonia();
		});

		$('#colonia').change(function() {
			loadPostal();
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


		$('.nuevo').click(function(){

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
		});


		$('.form').submit(function(e){

			e.preventDefault();
			if ($('.form')[0].checkValidity()) {


				//información del formulario
				var formData = new FormData($(".form")[0]);
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
