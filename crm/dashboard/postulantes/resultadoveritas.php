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
$singular = "Resultado VERITAS";

$plural = "Resultado VERITAS";

$eliminar = "eliminarEntrevistas";

$insertar = "insertarEntrevistas";

$modificar = "modificarEntrevistas";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resultado 		= 	$serviciosReferencias->traerPostulantesPorId($id);

$postulante = mysql_result($resultado,0,'nombre').' '.mysql_result($resultado,0,'apellidopaterno').' '.mysql_result($resultado,0,'apellidomaterno');


//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$path  = '../../archivos/postulantes/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}

$pathVeritas  = '../../archivos/postulantes/'.$id.'/veritas';

if (!file_exists($pathVeritas)) {
	mkdir($pathVeritas, 0777);
}

$filesPlanilla = array_diff(scandir($pathVeritas), array('.', '..'));

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

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		#codigopostal { width: 400px; }
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }

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

			<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">

				<div class="col-xs-2 bs-wizard-step complete">
					<div class="text-center bs-wizard-stepnum">Paso 1</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Validación SIAP</div>
				</div>

				<div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
					<div class="text-center bs-wizard-stepnum">Paso 2</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Agendar Entrevista</div>
				</div>

				<div class="col-xs-2 bs-wizard-step complete"><!-- complete -->
					<div class="text-center bs-wizard-stepnum">Paso 3</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Entrevista y Pruebas Psicometricas</div>
				</div>

				<div class="col-xs-2 bs-wizard-step active"><!-- active -->
					<div class="text-center bs-wizard-stepnum">Paso 4</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Resultado Veritas</div>
				</div>

				<div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
					<div class="text-center bs-wizard-stepnum">Paso 5</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Documentación I</div>
				</div>

				<div class="col-xs-2 bs-wizard-step disabled"><!-- active -->
					<div class="text-center bs-wizard-stepnum">Paso 6</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Documentación II</div>
				</div>

			</div>


			</div>
		</div>
	</div>

	<div class="container-fluid">
		<div class="row clearfix subirImagen">
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12">
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
							<h4>Descargar pantallazo con aprobación o no acreditamiento de la prueba VERITAS INBURSA.</h4>
							<button type="button" class="btn bg-green waves-effect btnContinuar">
								<i class="material-icons">done_all</i>
								<span>ACEPTAR - CONTINUAR</span>
							</button>
							<button type="button" class="btn bg-orange waves-effect btnRechazaHabilita">
								<i class="material-icons">done</i>
								<span>RECHAZADA - CONTINUAR</span>
							</button>
							<button type="button" class="btn bg-red waves-effect btnRechazar">
								<i class="material-icons">close</i>
								<span>RECHARZAR</span>
							</button>


							<a href="javascript:void(0);" class="thumbnail timagen1">
								<img class="img-responsive">
							</a>
							<div id="example1"></div>
							<button type="button" class="btn bg-red waves-effect btnEliminar">
								<i class="material-icons">remove</i>
								<span>ELIMINAR</span>
							</button>
						</div>
				</div>
				</div>

			</div>
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								CARGA/MODIFIQUE PRUEBA VERITA INBURSA AQUI
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>

								</li>
							</ul>
						</div>
						<div class="body">

							<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
								<div class="dz-message">
									<div class="drag-icon-cph">
										<i class="material-icons">touch_app</i>
									</div>
									<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>

								</div>
								<div class="fallback">

									<input name="file" type="file" id="archivos" />
									<input type="hidden" id="idpostulante" name="idpostulante" value="<?php echo $id; ?>" />



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
							 <button type="button" class="btn btn-danger waves-effect eliminar" data-dismiss="modal">ELIMINAR</button>
							 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>
				  </div>
			 </div>
		</div>
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

<script src="../../js/pdfobject.min.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script>
	$(document).ready(function(){

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idpostulante: <?php echo $id; ?>,
						iddocumentacion: 1,
						accion: 'traerDocumentacionPorPostulanteDocumentacion'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("." + contenedor + " img").attr("src",'');
				},
				success:  function (response) {
					var cadena = response.datos.type.toLowerCase();

					if (response.datos.type != '') {
						if (cadena.indexOf("pdf") > -1) {
							PDFObject.embed(response.datos.imagen, "#"+contenedorpdf);
							$('#'+contenedorpdf).show();
							$("."+contenedor).hide();

						} else {
							$("." + contenedor + " img").attr("src",response.datos.imagen);
							$("."+contenedor).show();
							$('#'+contenedorpdf).hide();
						}
					}

					if (response.error) {
						$('.btnContinuar').hide();
						$('.btnEliminar').hide();
					} else {
						$('.btnContinuar').show();
						$('.btnEliminar').show();
					}



				}
			});
		}

		traerImagen('example1','timagen1');

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 30,
			acceptedFiles: ".png,.jpg,.gif,.bmp,.jpeg,.pdf",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
						formData.append("idpostulante", '<?php echo $id; ?>');
						formData.append("iddocumentacion", '1');
				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1');
					$('.lblPlanilla').hide();
					swal("Correcto!", resp.replace("1", ""), "success");
					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};



		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idpostulante: <?php echo $id; ?>,
				 iddocumentacion: 1
			},
			url: 'subir.php'
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
					var value = $("#codigopostal").getSelectedItemData().codigo;
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
					var value = $("#codigopostal2").getSelectedItemData().codigo;
					$("#codigopostal2").val(value);

				}
			}
		};

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


		$("#sign_in").submit(function(e){
			e.preventDefault();
		});


		$('.btnContinuar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 2, 5);
		});

		$('.btnRechazar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 2, 2);
		});

		$('.btnRechazaHabilita').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 2, 6);
		});

		function modificarEstadoPostulante(id, idestado, estadodocumentacion) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoPostulante',
					id: id,
					idestado: idestado,
					estadodocumentacion: estadodocumentacion,
					iddocumentacion: 2
				},
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



		$('.eliminar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarDocumentacionPostulante',idpostulante: <?php echo $id; ?>, iddocumentacion: 1},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnEliminar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", data.leyenda , "success");
						traerImagen('example1','timagen1');

					} else {
						swal("Error!", data.leyenda, "warning");

						$('.btnEliminar').show();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		});

		$(".body").on("click",'.btnEliminar', function(){
			$('#lgmEliminar').modal();

		});
	});
</script>








</body>
<?php } ?>
</html>
