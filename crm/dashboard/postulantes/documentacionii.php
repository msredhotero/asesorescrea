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
$singular = "Documentación I";

$plural = "Documentaciones I";

$eliminar = "eliminarPostulantes";

$insertar = "insertarPostulantes";

$modificar = "modificarPostulantes";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resultado 		= 	$serviciosReferencias->traerPostulantesPorId($id);

$postulante = mysql_result($resultado,0,'nombre').' '.mysql_result($resultado,0,'apellidopaterno').' '.mysql_result($resultado,0,'apellidomaterno');


$path  = '../../archivos/postulantes/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}

/**** son 13 documentaciones */
$pathCARATULA  = '../../archivos/postulantes/'.$id.'/caratula';

if (!file_exists($pathCARATULA)) {
	mkdir($pathCARATULA, 0777);
}

$filesCARATULA = array_diff(scandir($pathCARATULA), array('.', '..'));

/****************************************************************/

$pathSA  = '../../archivos/postulantes/'.$id.'/solicitud';

if (!file_exists($pathSA)) {
	mkdir($pathSA, 0777);
}

$filesSA = array_diff(scandir($pathSA), array('.', '..'));

/****************************************************************/

$pathFF  = '../../archivos/postulantes/'.$id.'/formatofirma';

if (!file_exists($pathFF)) {
	mkdir($pathFF, 0777);
}

$filesFF = array_diff(scandir($pathFF), array('.', '..'));

/****************************************************************/

$pathCC  = '../../archivos/postulantes/'.$id.'/consar';

if (!file_exists($pathCC)) {
	mkdir($pathCC, 0777);
}

$filesCC = array_diff(scandir($pathCC), array('.', '..'));

/****************************************************************/

$pathNLG  = '../../archivos/postulantes/'.$id.'/nolaborargobierno';

if (!file_exists($pathNLG)) {
	mkdir($pathNLG, 0777);
}

$filesNLG = array_diff(scandir($pathNLG), array('.', '..'));

/****************************************************************/

$pathCE  = '../../archivos/postulantes/'.$id.'/codigoetica';

if (!file_exists($pathCE)) {
	mkdir($pathCE, 0777);
}

$filesCE = array_diff(scandir($pathCE), array('.', '..'));

/****************************************************************/

$pathAP  = '../../archivos/postulantes/'.$id.'/aceptacionpoliticas';

if (!file_exists($pathAP)) {
	mkdir($pathAP, 0777);
}

$filesAP = array_diff(scandir($pathAP), array('.', '..'));

/****************************************************************/

$pathCCC  = '../../archivos/postulantes/'.$id.'/cuentaclave';

if (!file_exists($pathCCC)) {
	mkdir($pathCCC, 0777);
}

$filesCCC = array_diff(scandir($pathCCC), array('.', '..'));

/****************************************************************/

$pathB  = '../../archivos/postulantes/'.$id.'/banco';

if (!file_exists($pathB)) {
	mkdir($pathB, 0777);
}

$filesB = array_diff(scandir($pathB), array('.', '..'));

/****************************************************************/

$pathCF1  = '../../archivos/postulantes/'.$id.'/cf1';

if (!file_exists($pathCF1)) {
	mkdir($pathCF1, 0777);
}

$filesCF1 = array_diff(scandir($pathCF1), array('.', '..'));


/****************************************************************/

$pathCF2  = '../../archivos/postulantes/'.$id.'/cf2';

if (!file_exists($pathCF2)) {
	mkdir($pathCF2, 0777);
}

$filesCF2 = array_diff(scandir($pathCF2), array('.', '..'));

/****************************************************************/

$pathCF3  = '../../archivos/postulantes/'.$id.'/cf3';

if (!file_exists($pathCF3)) {
	mkdir($pathCF3, 0777);
}

$filesCF3 = array_diff(scandir($pathCF3), array('.', '..'));

/****************************************************************/

$pathC  = '../../archivos/postulantes/'.$id.'/compromiso';

if (!file_exists($pathC)) {
	mkdir($pathC, 0777);
}

$filesC = array_diff(scandir($pathC), array('.', '..'));

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionCompleta2($id);

$puedeAvanzar = $serviciosReferencias->permiteAvanzarDocumentacionII($id);

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

		.btnDocumentacion {
			cursor: pointer;
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

				<div class="col-xs-2 bs-wizard-step complete"><!-- active -->
					<div class="text-center bs-wizard-stepnum">Paso 4</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Resultado Veritas</div>
				</div>

				<div class="col-xs-2 bs-wizard-step complete"><!-- active -->
					<div class="text-center bs-wizard-stepnum">Paso 5</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Firmar Contratos</div>
				</div>

				<div class="col-xs-2 bs-wizard-step active"><!-- active -->
					<div class="text-center bs-wizard-stepnum">Paso 6</div>
					<div class="progress">
						<div class="progress-bar"></div>
					</div>
					<a href="#" class="bs-wizard-dot"></a>
					<div class="bs-wizard-info text-center">Documentación II</div>
				</div>

			</div>

			<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
						<div class="alert alert-info">
							<p><b>Importante!</b> Recuerde que debe completar toda la documentacion para poder continuar con la carga de la siguiente documentación</p>
						</div>
						<?php if ($puedeAvanzar == true) { ?>
							<button type="button" class="btn bg-green waves-effect btnContinuar">
								<i class="material-icons">add</i>
								<span>CONTINUAR</span>
							</button>

						<?php } ?>
					</div>
					<?php
					while ($row = mysql_fetch_array($resDocumentaciones)) {
					?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="info-box-3 bg-<?php echo $row['color']; ?> hover-zoom-effect btnDocumentacion" id="<?php echo $row['iddocumentacion']; ?>">
							<div class="icon">
								<i class="material-icons">description</i>
							</div>
							<div class="content">
								<div class="text"><?php echo $row['documentacion']; ?></div>
								<div class="number"><?php echo $row['estadodocumentacion']; ?></div>
							</div>
						</div>
					</div>
				<?php } ?>


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

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<!-- JQuery Steps Plugin Js -->
<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script>

	$(document).ready(function(){

		$('.btnDocumentacion').click(function() {
			idTable =  $(this).attr("id");
			url = "subirdocumentacionii.php?id=<?php echo $id; ?>&documentacion=" + idTable;
			$(location).attr('href',url);
		});

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
						$('.btnEliminar').hide();
					} else {
						$('.btnContinuar').show();
						$('.btnEliminar').show();
					}



				}
			});
		}



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

		$('.btnContinuar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 7);
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
