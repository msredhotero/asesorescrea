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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../aceptadas/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Aceptadas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$id = $_GET['id'];
$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$trazabilidad = $serviciosReferencias->traerTrazabilidadPorCotizacion($id);

$Cliente = mysql_result($resultado,0,'clientesolo');
$Asesor = mysql_result($resultado,0,'asesorsolo');
$Producto = mysql_result($resultado,0,'producto');


if ($id == 0) {
	header('Location: index.php');
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
      .lblPolizasActivas, .lblPrimaNeta, .lblPrimaTotal  { font-size:0.8em !important;}

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
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../', ''); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix">

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								TRAZABILIDAD
							</h2>

						</div>
						<div class="body table-responsive">
							<button type="button" class="btn btn-info waves-effect btnVolverFiltro" data-ir="modificar" data-referencia="<?php echo $id; ?>"><i class="material-icons">reply</i><span>VOLVER</span></button>

                     <div class="row" style="padding: 5px 20px;">


                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      								<div class="info-box bg-green hover-expand-effect">
      									<div class="icon">
      										<i class="material-icons">people_outline</i>
      									</div>
      									<div class="content">
      										<div class="text">CLIENTE</div>
      										<div class="number"><span class="lblPolizasActivas"><?php echo $Cliente; ?></span></div>
      									</div>
      								</div>
      							</div>


      							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      								<div class="info-box bg-blue hover-expand-effect">
      									<div class="icon">
      										<i class="material-icons">account_box</i>
      									</div>
      									<div class="content">
      										<div class="text">ASESOR</div>
      										<div class="number"><span class="lblPrimaNeta"><?php echo $Asesor; ?></span></div>
      									</div>
      								</div>
      							</div>

      							<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
      								<div class="info-box bg-light-blue hover-expand-effect">
      									<div class="icon">
      										<i class="material-icons">add_shopping_cart</i>
      									</div>
      									<div class="content">
      										<div class="text">PRODUCTO</div>
      										<div class="number"><span class="lblPrimaTotal"><?php echo $Producto; ?></span></div>
      									</div>
      								</div>
      							</div>

      						</div>
                     </div>
							<div class="row" style="padding: 5px 20px;">

                        <ul class="timeline">
                           <?php
                              $i=0;
                              $lado = '';
                              while ($row = mysql_fetch_array($trazabilidad)) {
                                 $i += 1;
                                 if (($i%2) == 0) {
                                    $lado = 'class="timeline-inverted"';
                                 } else {
                                    $lado = '';
                                 }
                           ?>
                           <li <?php echo $lado; ?>>
                              <div class="timeline-badge info"><i class="material-icons"><?php echo $row['ico']; ?></i></div>
                              <div class="timeline-panel">
                                 <div class="timeline-heading">
                                    <h4 class="timeline-title"><?php echo $row['nombre']; ?></h4>
                                    <p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> <?php echo $row['fechacrea']; ?> - <?php echo $row['usuariocrea']; ?></small></p>
                                 </div>
                                 <div class="timeline-body">
                                    <p><?php echo $row['dato']; ?></p>
                                 </div>
                              </div>
                           </li>

                           <?php } ?>


                        </ul>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

	 <script src="../../js/picker.js"></script>
	 <script src="../../js/picker.date.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>
	$(document).ready(function(){



	});
</script>

</body>
<?php } ?>
</html>
