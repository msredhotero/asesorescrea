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
	include ('../../includes/funcionesComercio.php');
	include ('../../includes/financiera.class.php');

	$serviciosFunciones 	= new Servicios();
	$serviciosUsuario 		= new ServiciosUsuarios();
	$serviciosHTML 			= new ServiciosHTML();
	$serviciosReferencias 	= new ServiciosReferencias();
	$baseHTML = new BaseHTML();
	$serviciosComercio      = new serviciosComercio();
	$financiera = new financieraCrea();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../venta/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Venta",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resCobros = $serviciosReferencias->traerMetodopagoPorCotizacion($id);


if (mysql_num_rows($resCobros) > 0) {
	$idcobro = mysql_result($resCobros,0,0);
	$esDomiciliado = mysql_result($resCobros,0,'reftipocobranza');
	$existeMetodoPago = 1;
} else {
	// creo el cobro
	$idcobro = 0;
	$existeMetodoPago = 0;
}

$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');

$producto = mysql_result($resProducto,0,'producto');


if (mysql_num_rows($resCotizaciones)>0) {
	$precio = mysql_result($resCotizaciones,0,'primatotal');
	$lblPrecio = str_replace('.','',$precio);
	$lblPrecioAd = str_replace('.','',$precio * 1.2);
} else {
	header('Location: index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$refEstadoCotizacion = mysql_result($resultado,0,'refestadocotizaciones');

$puedeEntrar = 0;

if ($refEstadoCotizacion == 23) {

	$puedeEntrar = 0;
} else {
	return header('Location: ../cotizacionesvigentes/new.php?id='.$id);

}

$financiera->buscarCotizacionesFinancieraPorValor('refcotizaciones',$id);

//$financiera->setIdusuario($_SESSION['usuaid_sahilices']);
$financiera->setIdusuario(311);
$financiera->setPrecio($precio);
$financiera->setDescripcion($producto);
$financiera->setIdServicio($idProducto);

$financiera->setRefcotizaciones($id);
$financiera->setRefsolicitudes(0);

if ($financiera->getIdcotizacionfinanciera() == null) {
	$financiera->servicioSolicitud();


} else {
	$financiera->setError(0);
}

//die(var_dump($financiera->getError()));

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
				<div class="col-xs-12">
		        <div class="card">
		          <div class="header bg-blue">
		            <h4 class="my-0 font-weight-normal">Resumen del Pedido: <?php echo mysql_result($resultado,0,'producto'); ?></h4>
		          </div>
		          <div class="body table-responsive">
						 <div class="text-center">
							<?php
 							if ($financiera->getError() == 0) {
 							?>
							<h1 class="display-4">¡Finalizo correctamente la solicitud del producto, lo redireccionaremos a Financiera CREA!</h1>
						<?php } else { ?>
							<h4><?php echo $financiera->getDescripcionError(); ?>.</h4>
						<?php } ?>


						 </div>

		          </div>

					 <br>
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

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<script src="https://asesorescrea.com/desarrollo/crm/dashboard/ecommerce/assets/js/jquery.payform.min.js"></script>


<script>
	$(document).ready(function(){

		<?php if ($financiera->getError() == '0') { ?>
			<?php if ($financiera->getUrl() != '') { ?>
			setTimeout(function(){ $(location).attr('href', '<?php echo $financiera->getUrl(); ?>'); }, 1000);
			<?php } ?>
		<?php } ?>


	});
</script>








</body>
<?php } ?>
</html>
