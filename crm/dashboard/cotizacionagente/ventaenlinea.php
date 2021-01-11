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

//die();

$token = $_SESSION['token_ac'];

if (!(isset($token))) {
	header('Location: index.php');
}

$resultadoToken = $serviciosReferencias->traerTokenasesoresPorTokenActivo($token);



$url_real = substr($_SERVER['REQUEST_URI'],strpos($_SERVER['REQUEST_URI'],'dashboard/')+10);

//die(var_dump(mysql_result($resultadoToken,0,'accion')));

if ($url_real !== mysql_result($resultadoToken,0,'accion')) {
	header('Location: ../index.php');
}



$rCliente = $serviciosReferencias->traerClientesPorId(mysql_result($resultadoToken,0,'refclientes'));
//die(var_dump($_SESSION['usuaid_sahilices']));
$rIdCliente = mysql_result($rCliente,0,0);

$rTipoPersona = mysql_result($rCliente,0,'reftipopersonas');


if (mysql_result($rCliente,0,'fechanacimiento') == null || mysql_result($rCliente,0,'fechanacimiento') == '0000-00-00') {
	$edad = 0;
} else {
	$edad = $serviciosReferencias->calculaedad(mysql_result($rCliente,0,'fechanacimiento'));
}

if ($edad > 60) {
	$mayoredad = 1;
} else {
	$mayoredad = 0;
}

$resProductosPaquete = $serviciosReferencias->traerPaquetedetallesPorPaquete(46);

$lblPrecio = '';

$acumPrecio = 0;

//die(var_dump($edad));

if ($edad == 0) {
	$lblPrecio = '$3,240';
} else {
	while ($rowP = mysql_fetch_array($resProductosPaquete)) {

		$existeCotizacionParaProducto = $serviciosReferencias->traerValoredadPorProductoEdad($rowP['refproductos'],$edad);

		if (mysql_num_rows($existeCotizacionParaProducto)>0) {
			//die(var_dump($rowP['refproductos']));
			if ($rowP['unicomonto'] == '1') {
				$acumPrecio += $rowP['valor'];
			} else {
				$acumPrecio += mysql_result($existeCotizacionParaProducto,0,'valor');
			}

		} else {
			$lblPrecio = '$3,240';
		}

		$lblPrecio = '$'.$acumPrecio;
	}
}


//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cotizaciones Recibidas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';



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

	<link rel="stylesheet" href="../../css/materialDateTimePicker.css">

	<!-- noUISlider Css -->
   <link href="../../plugins/nouislider/nouislider.min.css" rel="stylesheet" />

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		.tscodigopostal { width: 400px; }

		.ui-autocomplete { position: absolute; cursor: default;z-index:30 !important;}

		.sectionC {
			height:360px;
			z-index:1 !important;
		}

		@media (min-width: 1200px) {
		   .modal-xlg {
		      width: 90%;
		   }
		}

		#respuestaPeso, #respuestaTalla, #respuestaAltura {
			font-size: 26px;
			font-weight: bold !important;
		}

		.frmContpregunta h4 span {
			text-decoration: none;
			font-weight: normal !important;
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
						<div class="body table-responsive">
							<div class="row">
								<h3 style="color: #C6AC83;font-size: 36px;line-height: 42px; text-align:center;">Nuestro Paquete de Protección incluye los siguientes beneficios:</h3>
							</div>

							<div class="row" style="margin-top:40px; text-align:center;">
								<button type="button" class="btn bg-blue waves-effect btnCotizar" style="padding:40px 80px; font-size:22px;">CONTRATAR PLAN ANUAL POR <?php echo $lblPrecio; ?></button>
							</div>

							<div class="row" style="margin-top:40px;">
								<div class="col-xs-12 col-md-6">
									<h4 style="color: #C6AC83;font-size: 36px;line-height: 42px;">Enfermedades Graves</h4>
									<h4><b>Pagaremos 300 mil pesos en caso de que seas diagnosticado con cualquiera de las siguientes enfermedades graves:</b></h4>
									<ul style="font-size:20px !important;">
										<li style="margin-top:10px;">1.- Infarto agudo al miocardio.</li>
										<li style="margin-top:10px;">2.- Cualquier tipo de Cáncer.</li>
										<li style="margin-top:10px;">3.- Cualquier enfermedad vascular cerebral.</li>
										<li style="margin-top:10px;">4.- Afecciones de las arterias coronarias que requieran cirugía de bypass.</li>
										<li style="margin-top:10px;">5.- Insuficiencia renal.</li>
										<li style="margin-top:10px;">6.- Trasplante de órganos vitales.</li>
										<li style="margin-top:10px;">7.- Parálisis o Paraplejía.</li>

									</ul>
								</div>
								<div class="col-xs-12 col-md-6">
									<img src="../../imagenes/infarto__.jpg" width="100%"/>
								</div>

							</div>

							<div class="row" style="margin-top:40px;">
								<div class="col-xs-12 col-md-6">
									<img src="../../imagenes/doctor.jpg" width="100%"/>
								</div>
								<div class="col-xs-12 col-md-6">
									<h4 style="color: #C6AC83;font-size: 36px;line-height: 42px;">Beneficios VRIM</h4>

									<ul style="font-size:20px !important;">
										<li style="margin-top:10px;">1.- Primera consulta de especialidad gratis con cualquier doctor de la red de VRIM, compuesta por más de 8 mil médicos a nivel nacional.</li>
										<li style="margin-top:10px;">2.- Reembolso de GMM por accidente hasta $50,000 pesos. </li>
										<li style="margin-top:10px;">3.- Seguro de vida por muerte accidental por $500,000 pesos.</li>
										<li style="margin-top:10px;">4.- Servicio funerario con cobertura nacional.</li>
										<li style="margin-top:10px;">5.- Atención médica, psicológica y nutricional telefónica 24/7.</li>
										<li style="margin-top:10px;">6.- 1 traslado de ambulancia sin costo.</li>
										<li style="margin-top:10px;">7.- Descuentos hasta el 50% en laboratorios, hospitales, cirugías, tratamientos dentales y visuales, enfermeras a domicilio, aparatos auditivos y más.</li>

									</ul>
								</div>
							</div>

							<div class="row" style="margin-top:40px; text-align:center;">
								<button type="button" class="btn bg-blue waves-effect btnCotizar" style="padding:40px 80px; font-size:100%;">CONTRATAR PLAN ANUAL POR <?php echo $lblPrecio; ?></button>
							</div>

						</div>

					</div>
         	</div>
			</div>
		</div>
	</div>
</section>




<?php echo $baseHTML->cargarArchivosJS('../../'); ?>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>
<!-- Wait Me Plugin Js -->
<script src="../../plugins/waitme/waitMe.js"></script>

<script src="../../js/pages/ui/tooltips-popovers.js"></script>

<!-- Custom Js -->
<script src="../../js/pages/cards/colored.js"></script>

<script src="../../plugins/jquery-validation/jquery.validate.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../../js/materialDateTimePicker.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<!-- noUISlider Plugin Js -->
<script src="../../plugins/nouislider/nouislider.js"></script>


<!-- Chart Plugins Js -->


<script>
	$(document).ready(function(){
		$('.btnCotizar').click(function() {
			$(location).attr('href','new.php');
		});

	});
</script>

</body>
<?php } ?>
</html>
