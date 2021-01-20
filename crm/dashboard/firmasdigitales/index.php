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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../firmasdigitales/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Firmas Digitales",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Firmas Digitales";

$plural = "Firmas Digitales";


switch ($_SESSION['idroll_sahilices']) {
	case 7:
		$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
		$idasesor = mysql_result($resVar5,0,'idasesor');

		$resultados = $serviciosReferencias->traerFirmasDigitales($idasesor);
	break;
	case 16:
		$resultados = $serviciosReferencias->traerFirmasDigitales($_SESSION['usuaid_sahilices']);
	break;
	case 19:
		$resultados = $serviciosReferencias->traerFirmasDigitales($_SESSION['usuaid_sahilices']);
	break;
	default:
		$resultados = $serviciosReferencias->traerFirmasDigitales();
	break;
}



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
								POLIZAS
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

							<table id="example" class="display table  dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
								<thead>
									<th>Cliente</th>
									<th>Producto</th>
									<th>Folio</th>
									<th>Fecha</th>
									<th>Acciones</th>
								</thead>
								<tbody>
							<?php
								$i = 0;
								while ($row = mysql_fetch_array($resultados)) {
									$i += 1;

									$id = $row['idcotizacion'];

									$pathSolcitud  = '../../archivos/solicitudes/cotizaciones/'.$id;

									if (!file_exists($pathSolcitud)) {
										$filesSolicitud = 0;

									} else {
										$filesSolicitud = array_diff(scandir($pathSolcitud), array('.', '..'));
									}

									$pathFirmas  = '../../archivos/firmas/cotizaciones/'.$id;

									if (!file_exists($pathFirmas)) {
										$filesFirmas = 0;

									} else {
										$filesFirmasCarpeta = array_diff(scandir($pathFirmas), array('.', '..'));

										if ($filesFirmasCarpeta > 0) {
											//die(var_dump($filesFirmasCarpeta));

											$filesFirmas = array_diff(scandir($pathFirmas.'/'.$filesFirmasCarpeta[2]), array('.', '..'));
										}

										//die(var_dump($filesFirmas));
									}

									if (($filesSolicitud > 0) || ($filesFirmas > 0)) {
							?>

								<tr>
									<td><?php echo strtoupper($row['clientecompleto']); ?></td>
									<td><?php echo strtoupper($row['producto']); ?></td>
									<td><?php echo strtoupper($row['folio']); ?></td>
									<td><?php echo strtoupper($row['fechacrea']); ?></td>
									<td>
										<?php if ($filesSolicitud > 0) { ?>
										<button type="button" id="<?php echo $row['idcotizacion']; ?>" class="btn btn-primary waves-effect btnSolicitud">
											<i class="material-icons">print</i>
											<span>SOLICITUD</span>
										</button>
										<?php } ?>
										<?php if ($filesFirmas > 0) { ?>
										<button type="button" id="<?php echo $row['idcotizacion']; ?>" class="btn btn-primary waves-effect btnFirma">
											<i class="material-icons">print</i>
											<span>FIRMA</span>
										</button>
										<?php } ?>
									</td>
								</tr>
								<?php } ?>
							<?php } ?>
							<?php if ($i == 0) { ?>
								<tr>
									<td colspan="5"><b>Actualmente no tiene Solicitudes o Firmas cargadas</b></td>
								</tr>

							<?php } ?>
								<tbody>
							</table>
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

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>


<script>
	$(document).ready(function(){

		$("#example").on("click",'.btnSolicitud', function(){
			idTable =  $(this).attr("id");
			url = "globales.php?id=" + idTable + "&tipo=1";
			$(location).attr('href',url);
		});

		$("#example").on("click",'.btnFirma', function(){
			idTable =  $(this).attr("id");
			url = "globales.php?id=" + idTable + "&tipo=2";
			$(location).attr('href',url);
		});


		$(".btnPoliza").click( function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','poliza.php?id=' + idTable);

		});//fin del boton modificar

		$(".btnRecibos").click( function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','recibos.php?id=' + idTable);

		});//fin del boton modificar

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
