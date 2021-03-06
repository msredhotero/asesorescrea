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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../venta/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//die();




$rCliente = $serviciosReferencias->traerClientesPorUsuarioCompleto($_SESSION['usuaid_sahilices']);
//die(var_dump($_SESSION['usuaid_sahilices']));
$rIdCliente = mysql_result($rCliente,0,0);

$rTipoPersona = mysql_result($rCliente,0,'reftipopersonas');

$fechanacimiento = mysql_result($rCliente,0,'fechanacimiento');


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

//die(var_dump($edad));

$lblPrecioVRIM = '';
$lblPrecioSEVI = '';
$lblPrecioVIDA500 = '';




$existeCotizacionParaProductoS500 = $serviciosReferencias->traerValoredadPorProductoEdad(54,$edad);

if (mysql_num_rows($existeCotizacionParaProductoS500)>0) {
   $lblPrecioVIDA500 = '$ '.number_format (mysql_result($existeCotizacionParaProductoS500,0,'valor'),2,'.',',');
} else {
   $lblPrecioVIDA500 = '';
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
								<h3 style="color: #C6AC83;font-size: 36px;line-height: 42px; text-align:center;">Nuestros Productos</h3>
							</div>


					</div>

					<?php if ($_SESSION['usuaid_sahilices'] != 0) { ?>
					<div class="row" style="margin-top:40px;">
							<div class="col-xs-12 col-md-6">
								<img src="../../imagenes/vida-500-1000000_.jpg" width="100%"/>
							</div>
							<div class="col-xs-12 col-md-6">
								<h4 style="color: #C6AC83;font-size: 32px;line-height: 36px;">Vida 500</h4>
								<h4 style="line-height: 1.5; "><b>Contrata un Seguro de Vida y deja a tus beneficiarios $500,000 en caso de que faltes. También puedes cotizar suma asegurada de $1,000,000 de pesos.</b></h4>
                           		<h4 style="line-height: 1.5; "><b>No hay pretexto para no estar asegurado; el trámite es sencillo y sin moverte de tu lugar.</b></h4>

                           <?php if (($lblPrecioVIDA500 != '') && ($serviciosReferencias->verificoExistenciaProductoPorCliente(54,$rIdCliente)==0)) { ?>
                           <div class="row" style="margin-top:40px; text-align:center;">
      							<button type="button" id="btnCotizarS500" class="btn bg-blue waves-effect btnCotizarS500" style="padding:40px 80px; font-size:100%;">CONTRATAR PLAN ANUAL POR <?php echo $lblPrecioVIDA500; ?></button>
      							</div>
                           <?php } ?>
                           <p style="margin-top:15px;"><small>*El costo de este producto esta conciderado respecto a tu edad, de acuerdo a los datos de registro y una protección por 500 mil pesos.</small></p>

							</div>


					</div>
				 <?php } ?>
         		</div><!-- fin del contenedor -->


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

      function calcularRD() {
         if ($('#cirugia').val() == 1) {

            switch ($('#limite').val()) {
               case '1':

                  $('.valorRD').html('$ 4.309,20');

                  $('#precioRD').val(4309.20);
               break;
               case '2':
                  $('.valorRD').html('$ 5.677,20');
                  $('#precioRD').val(5677.2);
               break;
               case '3':
                  $('.valorRD').html('$ 8.124,40');
                  $('#precioRD').val(8124.4);
               break;
            }
         } else {
            switch ($('#limite').val()) {
               case '1':
                  $('.valorRD').html('$ 3.245,20');
                  $('#precioRD').val(3245.2);
               break;
               case '2':
                  $('.valorRD').html('$ 4.278,8');
                  $('#precioRD').val(4278.8);
               break;
               case '3':
                  $('.valorRD').html('$ 6.118,00');
                  $('#precioRD').val(6118);
               break;
            }
         }
      }

      calcularRD();

      $('#limite').change(function() {
         calcularRD();
      });

      $('#cirugia').change(function() {
         calcularRD();
      });
	  /* 41 */
		$('#btnCotizarVrim').click(function() {
			$(location).attr('href','new.php?producto=41');
		});

      $('#btnCotizarSevi').click(function() {
			$(location).attr('href','new.php?producto=28');
		});

      $('#btnCotizarS500').click(function() {
			$(location).attr('href','new.php?producto=54');
		});

      $('#btnCotizarRD').click(function() {

			$(location).attr('href','new.php?producto=55');
		});

	});
</script>

</body>
<?php } ?>
</html>
