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

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "SIAP";

$plural = "SIAP";

$eliminar = "eliminarPostulantes";

$insertar = "insertarPostulantes";

$modificar = "modificarPostulantes";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resultado 		= 	$serviciosReferencias->traerPostulantesPorId($id);

$postulante = mysql_result($resultado,0,'nombre').' '.mysql_result($resultado,0,'apellidopaterno').' '.mysql_result($resultado,0,'apellidomaterno');

$resGuia = $serviciosReferencias->traerGuiasPorEsquemaEspecial(mysql_result($resultado,0,'refesquemareclutamiento'));

$resEstadoSiguiente = $serviciosReferencias->traerGuiasPorEsquemaSiguiente(mysql_result($resultado,0,'refesquemareclutamiento'), mysql_result($resultado,0,'refestadopostulantes'));

if (mysql_num_rows($resEstadoSiguiente) > 0) {
	$estadoSiguiente = mysql_result($resEstadoSiguiente,0,'refestadopostulantes');
} else {
	$estadoSiguiente = 1;
}


$path  = '../../archivos/postulantes/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}

$pathSIAP  = '../../archivos/postulantes/'.$id.'/siap';

if (!file_exists($pathSIAP)) {
	mkdir($pathSIAP, 0777);
}

$filesPlanilla = array_diff(scandir($pathSIAP), array('.', '..'));

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
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }

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
		<div class="row clearfix subirImagen">
			<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
				<?php
				$lblEstado = 'complete';
				$i = 0;
				while ($rowG = mysql_fetch_array($resGuia)) {
					$i += 1;
					$urlAcceso = $rowG['url'].'?id='.$id;
					/*
					if ($rowG['refestadopostulantes'] == $estadoSiguiente) {
						$lblEstado = 'active';
					}

					if (($lblEstado == 'complete') || ($lblEstado == 'active')) {
						$urlAcceso = $rowG['url'].'?id='.$id;
					} else {
						if ($rowG['refestadopostulantes'] == 7) {
							$urlAcceso = $rowG['url'].'?id='.$id;
							$lblEstado = 'active';
						} else {
							$urlAcceso = 'javascript:void(0)';
						}
					}
					*/
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
				<div class="col-xs-12 col-md-12 col-lg-12">
					<h4>Postulante: <?php echo $postulante; ?> - Validar registros previos en SIAP, obtener pantallazo y guardar.</h4>
					<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
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
					<?php } ?>


					<a href="javascript:void(0);" class="thumbnail timagen1">
						<img class="img-responsive">
					</a>
					<div id="example1"></div>

					<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
					<button type="button" class="btn bg-red waves-effect btnEliminar">
						<i class="material-icons">delete</i>
						<span>ELIMINAR - IMAGEN</span>
					</button>
					<?php } ?>

				</div>

			</div>
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header">
							<h2>
								CARGA/MODIFIQUE EL SIAP AQUI
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
							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
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
							<?php } ?>

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

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<!-- JQuery Steps Plugin Js -->
<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script>

	$(document).ready(function(){

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idpostulante: <?php echo $id; ?>,
						iddocumentacion: 2,
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
						$('.btnRechazaHabilita').hide();
						$('.btnRechazar').hide();
						$('.btnEliminar').hide();
					} else {
						$('.btnContinuar').show();
						$('.btnRechazaHabilita').show();
						$('.btnRechazar').show();
						$('.btnEliminar').show();
					}



				}
			});
		}

		traerImagen('example1','timagen1');

		<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 30,
			acceptedFiles: ".jpg,.jpeg,.pdf",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
						formData.append("idpostulante", '<?php echo $id; ?>');
						formData.append("iddocumentacion", '2');
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
				 iddocumentacion: 2
			},
			url: 'subir.php'
		});

		<?php } ?>

		function setButtonWavesEffect(event) {
			$(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
			$(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
		}

		$('#wizard_horizontal').steps({
			headerTag: 'h2',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			onInit: function (event, currentIndex) {
				setButtonWavesEffect(event);
			}
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

		$('.btnContinuar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 3, 5);
		});

		$('.btnRechazar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 3, 2);
		});

		$('.btnRechazaHabilita').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 3, 6);
		});

		$('.eliminar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarDocumentacionPostulante',idpostulante: <?php echo $id; ?>, iddocumentacion: 2},
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


	});
</script>








</body>
<?php } ?>
</html>
