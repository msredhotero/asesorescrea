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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cotizacionagente/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cotizaciones Recibidas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Especialidad";

$plural = "Especialidades";

$eliminar = "eliminarEspecialidades";

$insertar = "insertarEspecialidades";

$modificar = "modificarEspecialidades";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "tbespecialidades";

$lblCambio	 	= array();
$lblreemplazo	= array();


$refdescripcion = array();
$refCampo 	=  array();

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$token = $_SESSION['token_ac'];

$resultado = $serviciosReferencias->traerTokenasesoresPorTokenActivo($token);

$idcliente = mysql_result($resultado,0,'refclientes');

$resultado = $serviciosReferencias->traerTokenasesoresPorClienteActivoTipo($idcliente,'2');


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
								COTIZACIONES RECIBIDAS
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



								<div class="row" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Descripción</th>
												<th>Producto</th>
												<th>Vigencia</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tbody>
											<?php

												while ($row = mysql_fetch_array($resultado)) {
													$url_id = '0';
													if (strpos($row['accion'],"&id=") !== false) {
														$varCount1 = (integer)strpos($row['accion'],'&');
														$varCount2 =  (integer)strpos($row['accion'],'producto=')+9;
														$url_id = substr($row['accion'],strpos($row['accion'],'producto=')+9, $varCount1 - $varCount2);

														//die(var_dump($url_id));

													} else {

														$url_id = substr($row['accion'],strpos($row['accion'],'producto=')+9);
													}


													$res = $serviciosReferencias->traerProductosPorId((integer)$url_id);

													if (mysql_num_rows($res)>0) {
														$producto = mysql_result($res,0,'producto');
													} else {
														$producto = 'Paquete Crea En Linea';
													}

											?>
											<tr>
												<td><?php echo $row['descripcion']; ?></td>
												<td><?php echo $producto; ?></td>
												<td><?php echo $row['vigencia']; ?></td>
												<?php if ($row['refestados'] == 1) { ?>
												<td>
													<button type="button" id="<?php echo $row['token']; ?>" class="btn btn-primary waves-effect btnPagar">
														<i class="material-icons">monetization_on</i>
														<span>COTIZAR</span>
													</button>
												</td>
												<?php } ?>
												<?php if ($row['refestados'] == 2) { ?>
												<td>
													<button type="button" class="btn btn-success waves-effect">
														<i class="material-icons">done</i>
														<span>COMPLETO</span>
													</button>
												</td>
												<?php } ?>
												<?php if ($row['refestados'] == 3) { ?>
												<td>
													<button type="button" class="btn btn-danger waves-effect">
														<i class="material-icons">remove</i>
														<span>CANCELADO</span>
													</button>
												</td>
												<?php } ?>
											</tr>
											<?php
												}
											?>
										</tbody>

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


<script>
	$(document).ready(function(){




		$("#example").on("click",'.btnPagar', function(){
			idTable =  $(this).attr("id");
			url = "../../token.php?token=" + idTable;
			$(location).attr('href',url);
		});
	});
</script>








</body>
<?php } ?>
</html>
