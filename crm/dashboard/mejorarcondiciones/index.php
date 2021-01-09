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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../mejorarcondiciones/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Mejorar Condiciones",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Mejora Tus Condiciones de tu poliza";

$plural = "Mejorar Tus Condiciones";

$eliminar = "eliminarMejorarcondiciones";

$insertar = "insertarMejorarcondiciones";

$modificar = "modificarMejorarcondiciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbmejorarcondiciones";

$lblCambio	 	= array('refclientes','refasesores');
$lblreemplazo	= array('Clientes','Asesor');

if ($_SESSION['idroll_sahilices'] == 16) {
	$resVar1 = $serviciosReferencias->traerClientesPorUsuario($_SESSION['usuaid_sahilices']);
	$cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(3,4,2),' ');

	$resCliente = $serviciosReferencias->traerClientesPorUsuario($_SESSION['usuaid_sahilices']);

	$cantidad = $serviciosReferencias->traerMejorarcondicionesPorClienteEnElDia(mysql_result($resCliente,0,0));

	//die(var_dump($cantidad));

	if ($cantidad > 2) {
		$puedeCargar = 0;
		$lblExcedio = '<h4><i class="material-icons">report</i> <span>Ya excedio el limite diario para subir polizas.</span></h4>';
	} else {
		$puedeCargar = 1;
		$lblExcedio = '';
	}

} else {

	$puedeCargar = 0;
	$lblExcedio = '';


	$resVar1 = $serviciosReferencias->traerClientes();
	$cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(3,4,2),' ');

	$cantidad = 1;

}

if ($_SESSION['idroll_sahilices'] == 7) {
	$puedeCargar = 1;
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	$idasesor = mysql_result($resVar5,0,'idasesor');

	$resVar1 = $serviciosReferencias->traerClientesasesoresPorAsesorNuevo($idasesor);
	$cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(3,4,2),' ');
} else {
	$idasesor = 25;
}
$resVar2 = $serviciosReferencias->traerAsesoresPorId($idasesor);
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1),' ');

$refdescripcion = array(0=>$cadRef1,1=>$cadRef2);
$refCampo 	=  array('refclientes','refasesores');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
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

	<style>
		.alert > i{ vertical-align: middle !important; }
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

								<?php if ($puedeCargar == 1) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<form class="formulario frmNuevo" role="form" id="sign_in">
										<div class="row">
											<?php echo $frmUnidadNegocios; ?>
										</div>

										<div class="row" style="padding:20px 50px; ">
											<button type="submit" class="btn btn-lg btn-primary waves-effect frmNuevo btnEniviar">ENVIAR</button>
										</div>

										</form>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="card">
													<div class="header bg-cyan">
														<h2>
															CARGA TUS POLIZAS AQUI (MAX. 3)
														</h2>
														<ul class="header-dropdown m-r--5">
															<li class="dropdown">
																<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
																	<i class="material-icons">more_vert</i>
																</a>
															</li>
														</ul>
													</div>
													<div class="body contArchivos">

														<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
															<div class="dz-message">
																<div class="drag-icon-cph">
																	<i class="material-icons">touch_app</i>
																</div>
																<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
															</div>
															<div class="fallback">
																<input name="file" type="file" id="archivos" />
																<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $id; ?>" />
																<input type="hidden" id="idmejora" name="idmejora" value="0" />
															</div>

														</form>
														<button id="submit-files" style="display:none;">Upload</button>
													</div>
												</div>
											</div>
										</div>
									</div>

								</div>
							<?php } else { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<?php echo $lblExcedio; ?>
									</div>
								</div>
							<?php }  ?>

								<?php if (($_SESSION['idroll_sahilices'] != 16) && ($_SESSION['idroll_sahilices'] != 7)) { ?>
								<div class="row" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Clientes</th>
												<th>Observaciones</th>
												<th>Fecha Generado</th>
												<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
												<th>Asesor</th>
												<?php } ?>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Clientes</th>
												<th>Observaciones</th>
												<th>Fecha Generado</th>
												<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
												<th>Asesor</th>
												<?php } ?>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>
							<?php } ?>

							</div>
						</div>
					</div>
				</div>
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

<script src="../../plugins/dropzone/dropzone.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>


<script>
	Dropzone.autoDiscover = false;
	$(document).ready(function(){

		var idTabla = 0;

		$('.frmContrefasesores').hide();
		<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>

			$('.frmContrefclientes').hide();
		<?php } else { ?>

			$('.frmContrefclientes').show();
		<?php } ?>

		$('#observaciones').attr("placeholder", "Ingrese las observaciones necesarias");

		<?php if ($puedeCargar == 1) { ?>
		var myDropzone = new Dropzone("#frmFileUpload", {
			maxFilesize: 30,
			acceptedFiles: ".jpg,.jpeg,.pdf",
			maxFiles: 3,
			addRemoveLinks: true,
			autoQueue: false,
			url: 'subir.php',
			autoProcessQueue: false,
			uploadMultiple: true,
   		parallelUploads: 3,
			dictRemoveFile: 'Remover Archivo',
			dictInvalidFileType: 'No se puede subir este tipo de archivo',
			dictFileTooBig: 'El archivo excede el tamaño permitido',
			dictMaxFilesExceeded: 'Excede la cantidad de archivos',
			/*params: {
				 idasociado: <?php //echo $_SESSION['usuaid_sahilices']; ?>,
				 iddocumentacion: idTabla
			},*/
			url: 'subir.php',
			init: function() {
				this.on("sending", function(file, xhr, formData) {
					formData.append("idasociado", "<?php echo $_SESSION['usuaid_sahilices']; ?>");
					formData.append("data", idTabla);
					//console.log(formData)
				});

			}
		});


		$('#submit-files').click(function() {

			const acceptedFiles = myDropzone.getAcceptedFiles();
			for (let i = 0; i < acceptedFiles.length; i++) {

            setTimeout(function () {
            	myDropzone.processFile(acceptedFiles[i])
            }, i * 200)
         }

			swal({
					title: "Respuesta",
					text: "Su solicitud fue enviada con exito!! Lo antes posible un responsable se pondra en contacto con usted",
					type: "success",
					timer: 3500,
					showConfirmButton: false
			});

			$('.btnEniviar').hide();


		});
		<?php } ?>



		$('.maximizar').click(function() {
			if ($('.icomarcos').text() == 'web') {
				$('#marcos').show();
				$('.content').css('marginLeft', '315px');
				$('.icomarcos').html('aspect_ratio');
			} else {
				$('#marcos').hide();
				$('.content').css('marginLeft', '15px');
				$('.icomarcos').html('web');
			}

		});


		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=mejorarcondiciones",
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
							idTabla = data.dato;
							$('#idmejora').val(data.dato);

							$('#submit-files').click();

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
