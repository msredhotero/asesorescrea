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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../listadopolizas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Polizas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Listado Polizas";

$plural = "Listado Polizas";

$id = $_GET['id'];

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	$idasesor = mysql_result($resVar5,0,'idasesor');

	$resultados = $serviciosReferencias->traerVentasPorAsesorVentaFundamental($idasesor,$id);
} else {
	$resultados = $serviciosReferencias->traerVentasPorUsuarioVentaCompleto($_SESSION['usuaid_sahilices'],$id);
}


if (mysql_num_rows($resultados)<=0) {
	header('Location: index.php');
}

$idestado = mysql_result($resultados,0,'refestadoventa');

$resDocumentacionReciboExistente = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id, 35);

$resDocumentacionReciboExistenteXML = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id, 147);
$resDocumentacionReciboExistentePDF = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id, 148);

$resDocumentacionReciboExistenteCLAUSULAS = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id, 153);
$resDocumentacionReciboExistenteEXPEDIENTE = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id, 154);

if (mysql_num_rows($resDocumentacionReciboExistenteXML)>0) {
	$archivosXML = "../../archivos/ventas/".$id.'/'.mysql_result($resDocumentacionReciboExistenteXML,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistenteXML,0,'archivo');
} else {
	$archivosXML = '';
}

if (mysql_num_rows($resDocumentacionReciboExistenteCLAUSULAS)>0) {
	$archivosCLAUS = "../../archivos/ventas/".$id.'/'.mysql_result($resDocumentacionReciboExistenteCLAUSULAS,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistenteCLAUSULAS,0,'archivo');
} else {
	$archivosCLAUS = '';
}

if (mysql_num_rows($resDocumentacionReciboExistenteEXPEDIENTE)>0) {
	$archivosEXP = "../../archivos/ventas/".$id.'/'.mysql_result($resDocumentacionReciboExistenteEXPEDIENTE,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistenteEXPEDIENTE,0,'archivo');
} else {
	$archivosEXP = '';
}


if (mysql_num_rows($resDocumentacionReciboExistentePDF)>0) {
	$archivosPDF = "../../archivos/ventas/".$id.'/'.mysql_result($resDocumentacionReciboExistentePDF,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistentePDF,0,'archivo');
} else {
	$archivosPDF = '';
}

$archivos = "../../archivos/ventas/".$id.'/'.mysql_result($resDocumentacionReciboExistente,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistente,0,'archivo');

$pos = strpos( strtolower(mysql_result($resDocumentacionReciboExistente,0,'archivo')), 'pdf');



//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbventas";

$lblCambio	 	= array('primaneta','primatotal','porcentajecomision','montocomision','fechavencimientopoliza','nropoliza','refestadoventa');
$lblreemplazo	= array('Prima Neta','Prima Total','% Comision','Monto Comision','Fecha Vencimiento de la Poliza','Nro Poliza','Estado Venta');

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

	<link rel="stylesheet" type="text/css" href="../../css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="../../css/classic.date.css"/>


	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

	<style>
		.alert > i{ vertical-align: middle !important; }
		.pdfobject-container { height: 110rem; border: 1rem solid rgba(0,0,0,.1); }
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="card ">
					<div class="header bg-blue">
						<h2>
							No POLIZA: <?php echo strtoupper(mysql_result($resultados,0,'nropoliza')); ?>
						</h2>

					</div>
					<div class="body table-responsive">
						<button type="button" class="btn btn-primary waves-effect btnVolver" style="margin-bottom:15px;">
							<i class="material-icons">arrow_back</i>
							<span>VOLVER</span>
						</button>
						<?php if ($archivosXML != '') { ?>
							<button type="button" onClick="window.open('<?php echo $archivosXML; ?>')" class="btn bg-blue waves-effect btnXML" style="margin-bottom:15px;">
								<i class="material-icons">file_download</i>
								<span>XML</span>
							</button>
						<?php } ?>
						<?php if ($archivosCLAUS != '') { ?>
							<button type="button" onClick="window.open('<?php echo $archivosCLAUS; ?>')" class="btn bg-blue waves-effect btnCLAU" style="margin-bottom:15px;">
								<i class="material-icons">file_download</i>
								<span>CLAUSULAS</span>
							</button>
						<?php } ?>
						<?php if ($archivosEXP != '') { ?>
							<button type="button" onClick="window.open('<?php echo $archivosEXP; ?>')" class="btn bg-blue waves-effect btnEXP" style="margin-bottom:15px;">
								<i class="material-icons">file_download</i>
								<span>EXPEDIENTE</span>
							</button>
						<?php } ?>
						<?php
							//ver bien
							if ($idestado == 66) { ?>
							<button type="button" class="btn btn-success waves-effect btnAceptar" style="margin-bottom:15px;">
								<i class="material-icons">done</i>
								<span>ACEPTAR</span>
							</button>
							<button type="button" class="btn btn-danger waves-effect btnEndoso" style="margin-bottom:15px;">
								<i class="material-icons">remove</i>
								<span>ENDOSO</span>
							</button>
						<?php } ?>

						<div id="example2"></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>



<div class="modal fade" id="lgmEliminar" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-red">
					 <h4 class="modal-title" id="largeModalLabel">GENERAR ENDOSO</h4>
				</div>
				<div class="modal-body">
							 <p>¿Esta seguro que desea enviar a ENDOSO la poliza?</p>
							 <small>* La poliza se eliminará y se volverá al proceso de emisión.</small>
				</div>
				<div class="modal-footer">
					 <button type="button" class="btn btn-danger waves-effect eliminar">GENERAR ENDOSO</button>
					 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>


<div class="modal fade" id="lgmAceptar" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-green">
					 <h4 class="modal-title" id="largeModalLabel">ACEPTAR</h4>
				</div>
				<div class="modal-body">
							 <p>¿Esta seguro que desea ACEPTAR la poliza?</p>
				</div>
				<div class="modal-footer">
					 <button type="button" class="btn btn-success waves-effect modalAceptar">ACEPTAR</button>
					 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>


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

<script src="../../js/pdfobject.min.js"></script>


<script>
	$(document).ready(function(){

		function frmAjaxEliminar() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'endosarPolizarAgente',
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: "Registro Modificado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						$('#lgmEliminar').modal('toggle');
						$(location).attr('href','index.php');

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

		$('.btnEndoso').click(function() {
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$('.eliminar').click(function() {
			frmAjaxEliminar();
		});


		function frmAjaxAceptar() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'aceptarPolizarAgente',
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: "Registro Modificado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						$('#lgmAceptar').modal('toggle');
						$(location).attr('href','index.php');

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

		$('.modalAceptar').click(function() {
			frmAjaxAceptar();
		});


		$('.btnAceptar').click(function() {
			$('#lgmAceptar').modal();
		});//fin del boton eliminar

		PDFObject.embed('<?php echo $archivos; ?>', "#example2");

		$('.btnVolver').click(function() {
			url = "index.php";
			$(location).attr('href',url);
		});

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example2").on("click",'.btnCrear', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','new.php?id=' + idTable + '&origen=1');

		});//fin del boton modificar

		$("#example3").on("click",'.btnCrear', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','new.php?id=' + idTable + '&origen=2');

		});//fin del boton modificar

		$("#example4").on("click",'.btnCrear', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','new.php?id=' + idTable + '&origen=3');

		});//fin del boton modificar




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




	});
</script>

</body>
<?php } ?>
</html>
