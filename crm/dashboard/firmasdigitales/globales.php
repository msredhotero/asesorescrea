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
$singular = "Listado Polizas";

$plural = "Listado Polizas";

$id = $_GET['id'];
$tipo = $_GET['tipo'];

$resultado = $serviciosReferencias->traerCotizacionesPorId($id);

if (mysql_num_rows($resultado)<=0) {
	header('Location: index.php');
}

$carpeta = '';
$archivos = '';
$lblArchivo = '';

if ($tipo == 1) {
	$lblArchivo = 'Solicitud';
	$pathSolcitud  = '../../archivos/solicitudes/cotizaciones/'.$id;

	if (!file_exists($pathSolcitud)) {
		$filesSolicitud = 0;

		$file = '';

	} else {
		$filesSolicitud = array_diff(scandir($pathSolcitud), array('.', '..'));

		$file = $filesSolicitud[2];

		$archivos = $pathSolcitud.'/'.$file;

	}

	$carpeta = $id;


}

if ($tipo == 2) {

	$lblArchivo = 'Firma';

	$pathFirmas  = '../../archivos/firmas/cotizaciones/'.$id;

	if (!file_exists($pathFirmas)) {
		$filesFirmas = 0;

		$file = '';

	} else {
		$filesFirmasCarpeta = array_diff(scandir($pathFirmas), array('.', '..'));

		if ($filesFirmasCarpeta > 0) {
			//die(var_dump($filesFirmasCarpeta));

			$carpeta = $filesFirmasCarpeta[2];

			$filesFirmas = array_diff(scandir($pathFirmas.'/'.$filesFirmasCarpeta[2]), array('.', '..'));

			if ($filesFirmas > 0) {
				$file = $filesFirmas[2];

				$archivos = $pathFirmas.'/'.$carpeta.'/'.$file;
			} else {
				$file = '';
			}
		}

		//die(var_dump($filesFirmas));
	}
}


$pos = strpos( strtolower( $file ), 'pdf');

$posXml = strpos( strtolower( $file ), 'xml');

//$carpeta = $serviciosReferencias->encryptIt($carpeta);


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
							<?php echo strtoupper($lblArchivo); ?>
						</h2>

					</div>
					<div class="body table-responsive">
						<button type="button" class="btn btn-primary waves-effect btnVolver" style="margin-bottom:15px;">
							<i class="material-icons">arrow_back</i>
							<span>VOLVER</span>
						</button>
						<?php if ($posXml !== false) { ?>
							<a href="descargar.php?file=<?php echo $file; ?>&c=<?php echo $carpeta; ?>&ikey=<?php echo $id; ?>"><button type="button" class="btn bg-blue waves-effect" style="margin-bottom:15px;">
								<i class="material-icons">cloud_download</i>
								<span>DESCARGAR</span>
							</button></a>
						<?php } else { ?>
							<?php if ($pos !== false) { ?>
								<div id="example2"></div>
							<?php } else { ?>

						<?php } } ?>

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

<script src="../../js/pdfobject.min.js"></script>


<script>
	$(document).ready(function(){

		PDFObject.embed('<?php echo $archivos; ?>', "#example2");

		$('.btnVolver').click(function() {
			url = "index.php";
			$(location).attr('href',url);
		});

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});




	});
</script>

</body>
<?php } ?>
</html>
