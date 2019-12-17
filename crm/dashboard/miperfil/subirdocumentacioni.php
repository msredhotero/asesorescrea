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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../miperfil/');
//*** FIN  ****/

$fecha = date('Y-m-d');

$idusuario = $_SESSION['usuaid_sahilices'];

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Mi Perfil",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$resultado 		= 	$serviciosReferencias->traerPostulantesPorIdUsuario($idusuario);

$id = mysql_result($resultado,0,'idpostulante');

$iddocumentacion = $_GET['documentacion'];

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

/**** son 10 documentaciones */
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

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacion($id, $iddocumentacion);

$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

$resPostulante = $serviciosReferencias->traerPostulantesPorId($id);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

if (mysql_num_rows($resDocumentacionAsesor) > 0) {
	$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));

	$iddocumentacionasesores = mysql_result($resDocumentacionAsesor,0,'iddocumentacionasesor');

	$estadoDocumentacion = mysql_result($resDocumentacionAsesor,0,'estadodocumentacion');

	$color = mysql_result($resDocumentacionAsesor,0,'color');

	$span = '';
	switch (mysql_result($resDocumentacionAsesor,0,'estadodocumentacion')) {
		case 1:
			$span = 'text-info glyphicon glyphicon-plus-sign';
		break;
		case 2:
			$span = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 3:
			$span = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 4:
			$span = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 5:
			$span = 'text-success glyphicon glyphicon-remove-sign';
		break;
	}
} else {
	$cadRefEstados = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

	$iddocumentacionasesores = 0;

	$estadoDocumentacion = 'Falta Cargar';

	$color = 'blue';

	$span = 'text-info glyphicon glyphicon-plus-sign';
}

switch ($iddocumentacion) {
	case 3:
		// code...
		$dato = mysql_result($resPostulante,0,'ine');

		$input = '<input type="text" name="ine" maxlength="10" id="ine" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de INE';
		$campo = 'ine';
	break;
	case 4:
		// code...
		$dato = mysql_result($resPostulante,0,'ine');

		$input = '<input type="text" name="ine" maxlength="10" id="ine" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de INE';
		$campo = 'ine';
	break;
	case 5:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
	case 6:
		// code...
		$dato = mysql_result($resPostulante,0,'curp');

		$input = '<input type="text" name="curp" maxlength="18" id="curp" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de CURP';
		$campo = 'curp';
	break;
	case 7:
		// code...
		$dato = mysql_result($resPostulante,0,'rfc');

		$input = '<input type="text" maxlength="13" name="rfc" id="rfc" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de RFC';
		$campo = 'rfc';
	break;
	case 8:
		// code...
		$dato = mysql_result($resPostulante,0,'nss');

		$input = '<input type="text" maxlength="11" name="nss" id="nss" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de Seguro Social';
		$campo = 'nss';
	break;
	case 9:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
	case 10:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
	case 11:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
	case 12:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;

	default:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
}

$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionCompleta($id,7);

$puedeAvanzar = $serviciosReferencias->permiteAvanzarDocumentacionI($id);

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

			<div class="row">
				<?php
				while ($row = mysql_fetch_array($resDocumentaciones)) {
					if (($row['idestadodocumentacion'] != 5) && ($row['idestadodocumentacion'] != 6) && ($row['idestadodocumentacion'] != 7)) {
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
				<?php } } ?>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								DOCUMENTACION - <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?>
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
							<button type="button" class="btn bg-green waves-effect btnVolver">
								<i class="material-icons">undo</i>
								<span>VOLVER</span>
							</button>
							<form class="form" id="formCountry">

								<div class="row" style="padding: 5px 20px;">

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label"><?php echo $leyenda; ?></label>
										<div class="form-group input-group">
											<div class="form-line">
												<?php echo $input; ?>

											</div>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
										<label class="form-label"> </label>
										<div class="form-group input-group">
											<div class="form-line">
												<?php echo $boton; ?>

											</div>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div> <!-- fin del card -->

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								ARCHIVO CARGADO
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
							<div class="row">
								<button type="button" class="btn bg-red waves-effect btnEliminar">
									<i class="material-icons">remove</i>
									<span>ELIMINAR</span>
								</button>
							</div>
							<div class="row">
								<a href="javascript:void(0);" class="thumbnail timagen1">
									<img class="img-responsive">
								</a>
								<div id="example1"></div>
							</div>
							<div class="row">
								<div class="alert bg-<?php echo $color; ?>">
									<h4>
										Estado: <b><?php echo $estadoDocumentacion; ?></b>
									</h4>
								</div>

							</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								CARGA/MODIFIQUE LA DOCUMENTACIÓN <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?> AQUI
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

		$('.btnDocumentacion').click(function() {
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?documentacion=" + idTable;
			$(location).attr('href',url);
		});

		$('.btnModificar').click(function() {
			modificarPostulanteUnicaDocumentacion($('#<?php echo $campo; ?>').val());
		});

		$('.btnVolver').click(function() {
			url = "index.php";
			$(location).attr('href',url);
		});

		function modificarPostulanteUnicaDocumentacion(valor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarPostulanteUnicaDocumentacion',
					idpostulante: <?php echo $id; ?>,
					campo: '<?php echo $campo; ?>',
					valor: valor
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se guardo correctamente el <?php echo $campo; ?>', "success");

					} else {
						swal("Error!", data.leyenda, "warning");

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

		$('.guardarEstado').click(function() {
			modificarEstadoDocumentacionPostulante($('#refestados').val());
		});

		function modificarEstadoDocumentacionPostulante(idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionPostulante',
					iddocumentacionasesores: <?php echo $iddocumentacionasesores; ?>,
					idestado: idestado
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.guardarEstado').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se modifico correctamente el estado de la documentación <?php echo $campo; ?>', "success");
						$('.guardarEstado').show();
						location.reload();
					} else {
						swal("Error!", data.leyenda, "warning");

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

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idpostulante: <?php echo $id; ?>,
						iddocumentacion: <?php echo $iddocumentacion; ?>,
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
						$('.guardarEstado').hide();
					} else {
						$('.btnContinuar').show();
						$('.btnEliminar').show();
						$('.guardarEstado').show();
					}



				}
			});
		}

		traerImagen('example1','timagen1');

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
					formData.append("iddocumentacion", '<?php echo $iddocumentacion; ?>');
				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1');
					$('.lblPlanilla').hide();
					swal("Correcto!", resp.replace("1", ""), "success");
					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
					location.reload();
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};



		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idpostulante: <?php echo $id; ?>,
				 iddocumentacion: <?php echo $iddocumentacion; ?>
			},
			url: 'subir.php'
		});



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
			modificarEstadoPostulante(<?php echo $id; ?>, <?php echo $iddocumentacion; ?>);
		});

		$('.eliminar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarDocumentacionPostulante',idpostulante: <?php echo $id; ?>, iddocumentacion: <?php echo $iddocumentacion; ?>},
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
