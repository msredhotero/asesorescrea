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


if (mysql_result($resultado,0,'reforigenreclutamiento') == 2) {
	$notId = 3;
} else {
	$notId = 0;
}

$resGuia = $serviciosReferencias->traerGuiasPorEsquemaEspecialJavelly(mysql_result($resultado,0,'refesquemareclutamiento'),$notId);

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

/**** son 10 documentaciones */


$pathFOLIOC  = '../../archivos/postulantes/'.$id.'/foliocompleto';

if (!file_exists($pathFOLIOC)) {
	mkdir($pathFOLIOC, 0777);
}

$filesFOLIOC = array_diff(scandir($pathFOLIOC), array('.', '..'));

/***********************************************************************/

$pathINEf  = '../../archivos/postulantes/'.$id.'/inef';

if (!file_exists($pathINEf)) {
	mkdir($pathINEf, 0777);
}

$filesINEf = array_diff(scandir($pathINEf), array('.', '..'));

/****************************************************************/

$pathINEd  = '../../archivos/postulantes/'.$id.'/ined';

if (!file_exists($pathINEd)) {
	mkdir($pathINEd, 0777);
}

$filesINEd = array_diff(scandir($pathINEd), array('.', '..'));

/****************************************************************/

$pathAN  = '../../archivos/postulantes/'.$id.'/actanacimiento';

if (!file_exists($pathAN)) {
	mkdir($pathAN, 0777);
}

$filesAN = array_diff(scandir($pathAN), array('.', '..'));

/****************************************************************/

$pathCURP  = '../../archivos/postulantes/'.$id.'/curp';

if (!file_exists($pathCURP)) {
	mkdir($pathCURP, 0777);
}

$filesCURP = array_diff(scandir($pathCURP), array('.', '..'));

/****************************************************************/

$pathRFC  = '../../archivos/postulantes/'.$id.'/rfc';

if (!file_exists($pathRFC)) {
	mkdir($pathRFC, 0777);
}

$filesRFC = array_diff(scandir($pathRFC), array('.', '..'));

/****************************************************************/

$pathNSS  = '../../archivos/postulantes/'.$id.'/nss';

if (!file_exists($pathNSS)) {
	mkdir($pathNSS, 0777);
}

$filesNSS = array_diff(scandir($pathNSS), array('.', '..'));

/****************************************************************/

$pathCE  = '../../archivos/postulantes/'.$id.'/comprobanteestudio';

if (!file_exists($pathCE)) {
	mkdir($pathCE, 0777);
}

$filesCE = array_diff(scandir($pathCE), array('.', '..'));

/****************************************************************/

$pathCD  = '../../archivos/postulantes/'.$id.'/comprobantedomicilio';

if (!file_exists($pathCD)) {
	mkdir($pathCD, 0777);
}

$filesCD = array_diff(scandir($pathCD), array('.', '..'));

/****************************************************************/

$pathCV  = '../../archivos/postulantes/'.$id.'/cv';

if (!file_exists($pathCV)) {
	mkdir($pathCV, 0777);
}

$filesCV = array_diff(scandir($pathCV), array('.', '..'));

/****************************************************************/

$pathInfonavit  = '../../archivos/postulantes/'.$id.'/infonavit';

if (!file_exists($pathInfonavit)) {
	mkdir($pathInfonavit, 0777);
}

$filesInfonavit = array_diff(scandir($pathInfonavit), array('.', '..'));

/****************************************************************/

$pathCedulaseguros  = '../../archivos/postulantes/'.$id.'/cedulaseguros';

if (!file_exists($pathCedulaseguros)) {
	mkdir($pathCedulaseguros, 0777);
}

$filesCedulaseguros = array_diff(scandir($pathCedulaseguros), array('.', '..'));

/****************************************************************/

$pathRC  = '../../archivos/postulantes/'.$id.'/rc';

if (!file_exists($pathRC)) {
	mkdir($pathRC, 0777);
}

$filesRC = array_diff(scandir($pathRC), array('.', '..'));

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionCompleta($id,7);

$puedeAvanzar = $serviciosReferencias->permiteAvanzarDocumentacionI($id);
$permitePresentar = $serviciosReferencias->permitePresentarDocumentacionI($id);

if (mysql_result($resultado,0,'refesquemareclutamiento') == 5 || mysql_result($resultado,0,'refesquemareclutamiento') == 6) {
	if (mysql_result($resultado,0,'rfc') == '') {
		$alertaRFC = '<div class="alert bg-orange"><i class="material-icons">warning</i> Falta cargar el RFC!!!. Para cargarlo haga click <a style="color: white;" href="subirdocumentacioni.php?id='.$id.'&documentacion=7"><b>AQUI</b></a></div>';
	} else {
		$alertaRFC = '';
	}


	if (mysql_result($resultado,0,'ine') == '') {
		$alertaINE = '<div class="alert bg-orange"><i class="material-icons">warning</i> Falta cargar el INE!!!. Para cargarlo haga click <a style="color: white;" href="subirdocumentacioni.php?id='.$id.'&documentacion=3"><b>AQUI</b></a></div>';
	} else {
		$alertaINE = '';
	}

	$alertaCURP = '';
	$alertaNSS = '';

} else {
	if (mysql_result($resultado,0,'rfc') == '') {
		$alertaRFC = '<div class="alert bg-orange"><i class="material-icons">warning</i> Falta cargar el RFC!!!. Para cargarlo haga click <a style="color: white;" href="subirdocumentacioni.php?id='.$id.'&documentacion=7"><b>AQUI</b></a></div>';
	} else {
		$alertaRFC = '';
	}

	if (mysql_result($resultado,0,'curp') == '') {
		$alertaCURP = '<div class="alert bg-orange"><i class="material-icons">warning</i> Falta cargar el CURP!!!. Para cargarlo haga click <a style="color: white;" href="subirdocumentacioni.php?id='.$id.'&documentacion=6"><b>AQUI</b></a></div>';
	} else {
		$alertaCURP = '';
	}

	if (mysql_result($resultado,0,'ine') == '') {
		$alertaINE = '<div class="alert bg-orange"><i class="material-icons">warning</i> Falta cargar el INE!!!. Para cargarlo haga click <a style="color: white;" href="subirdocumentacioni.php?id='.$id.'&documentacion=3"><b>AQUI</b></a></div>';
	} else {
		$alertaINE = '';
	}

	if ((mysql_result($resultado,0,'nss') == '') && (mysql_result($resultado,0,'reforigenreclutamiento') == 1)) {
		$alertaNSS = '<div class="alert bg-orange"><i class="material-icons">warning</i> Falta cargar el Nro de Seguro Social!!!. Para cargarlo haga click <a style="color: white;" href="subirdocumentacioni.php?id='.$id.'&documentacion=8"><b>AQUI</b></a></div>';
	} else {
		$alertaNSS = '';
	}
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
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 10px;">
						<div class="alert alert-info">
							<p><b>Importante!</b> Recuerde que debe completar toda la documentacion para poder continuar con la carga de la siguiente documentación</p>
						</div>
						<div class="alert bg-teal">
							<p><b>Importante!</b> Descargue el archivo para Firmar una vez finalizado el proceso de <a style="color:black;" target="_blank" href="../../contratos/altaasesorescompleto.pdf"><b>AQUI</b></a></p>
						</div>
						<?php echo $alertaINE; ?>
						<?php echo $alertaCURP; ?>
						<?php echo $alertaRFC; ?>
						<?php echo $alertaNSS; ?>

						<div class="alert bg-blue">Postulante: <?php echo $postulante; ?></div>

						<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
							<?php if ($puedeAvanzar == true) { ?>
								<button type="button" class="btn bg-green waves-effect btnContinuar">
									<i class="material-icons">done_all</i>
									<span>CONTINUAR</span>
								</button>
								<button type="button" class="btn btn-lg bg-orange waves-effect btnGenerar">
									<i class="material-icons">class</i>
									<span>GENERAR FOLIO</span>
								</button>

							<?php } ?>
							<?php if ($permitePresentar == true) { ?>
								<button type="button" class="btn bg-amber waves-effect btnPresentar">
									<i class="material-icons">done_all</i>
									<span>PRESENTAR DOCUMENTACION</span>
								</button>

							<?php } ?>
						<?php } ?>
					</div>
					<?php
					while ($row = mysql_fetch_array($resDocumentaciones)) {
					?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="info-box-3 bg-<?php echo $row['color']; ?> hover-zoom-effect btnDocumentacion" id="<?php echo $row['iddocumentacion']; ?>">
							<div class="icon">
								<i class="material-icons">face</i>
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

		<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 6) || ($_SESSION['idroll_sahilices'] == 9) ) { ?>
		$('.btnDocumentacion').click(function() {
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&documentacion=" + idTable;
			$(location).attr('href',url);
		});

		$('.btnGenerar').click(function() {
			window.open("../../reportes/rptFolioParcial.php?id=<?php echo $id; ?>" ,'_blank');
		});
		<?php } ?>

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

		function presentarDocumentacionI(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'presentarDocumentacionI',id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnPresentar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
						swal("Ok!", 'Ya presento su documentacion, sera evaluada para luego continuar con el proceso', "success");
						$('.btnPresentar').show();
						setTimeout(function(){ location.reload() }, 5000);
					} else {
						swal("Error!", data, "warning");


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

		$('.btnPresentar').click(function() {
			presentarDocumentacionI(<?php echo $id; ?>);
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
