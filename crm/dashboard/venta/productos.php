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



$lblPrecioVRIM = '';
$lblPrecioSEVI = '';
$lblPrecioVIDA500 = '';


$existeCotizacionParaProductoVRIM = $serviciosReferencias->traerValoredadPorProductoEdad(41,$edad);

if (mysql_num_rows($existeCotizacionParaProductoVRIM)>0) {
   $lblPrecioVRIM = '$'.mysql_result($existeCotizacionParaProductoVRIM,0,'valor');
} else {
   $lblPrecioVRIM = 0;
}

$existeCotizacionParaProductoSEVI = $serviciosReferencias->traerValoredadPorProductoEdad(28,$edad);

if (mysql_num_rows($existeCotizacionParaProductoSEVI)>0) {
   $lblPrecioSEVI = '$'.mysql_result($existeCotizacionParaProductoSEVI,0,'valor');
} else {
   $lblPrecioSEVI = 0;
}


$existeCotizacionParaProductoS500 = $serviciosReferencias->traerValoredadPorProductoEdad(54,$edad);

if (mysql_num_rows($existeCotizacionParaProductoS500)>0) {
   $lblPrecioVIDA500 = '$'.mysql_result($existeCotizacionParaProductoS500,0,'valor');
} else {
   $lblPrecioVIDA500 = 0;
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


							<div class="row" style="margin-top:40px;">
								<div class="col-xs-12 col-md-6">
									<h4 style="color: #C6AC83;font-size: 32px;line-height: 36px;">Enfermedades Graves</h4>
									<h4 style="line-height: 1.5; "><b>Pagaremos 300 mil pesos en caso de que seas diagnosticado con cualquiera de las siguientes enfermedades graves:</b></h4>
									<ul style="font-size:20px !important;">
										<li style="margin-top:10px;">1.- Infarto agudo al miocardio.</li>
										<li style="margin-top:10px;">2.- Cualquier tipo de Cáncer.</li>
										<li style="margin-top:10px;">3.- Cualquier enfermedad vascular cerebral.</li>
										<li style="margin-top:10px;">4.- Afecciones de las arterias coronarias que requieran cirugía de bypass.</li>
										<li style="margin-top:10px;">5.- Insuficiencia renal.</li>
										<li style="margin-top:10px;">6.- Trasplante de órganos vitales.</li>
										<li style="margin-top:10px;">7.- Parálisis o Paraplejía.</li>

									</ul>
                           <?php if ($lblPrecioSEVI != 0) { ?>
                           <div class="row" style="margin-top:40px; text-align:center;">
      								<button type="button" id="btnCotizarSevi" class="btn bg-blue waves-effect btnCotizarSevi" style="padding:40px 80px; font-size:100%;">CONTRATAR PLAN ANUAL POR <?php echo $lblPrecioSEVI; ?></button>
      							</div>
                           <?php } ?>

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
									<h4 style="color: #C6AC83;font-size: 30px;line-height: 36px;">Paquete de Protección y Servicios médicos</h4>

									<ul style="font-size:20px !important;">
										<li style="margin-top:10px;">1.- Primera consulta de especialidad gratis con cualquier doctor de la red de VRIM, compuesta por más de 8 mil médicos a nivel nacional.</li>
										<li style="margin-top:10px;">2.- Reembolso de GMM por accidente hasta $50,000 pesos. </li>
										<li style="margin-top:10px;">3.- Seguro de vida por muerte accidental por $500,000 pesos.</li>
										<li style="margin-top:10px;">4.- Servicio funerario con cobertura nacional.</li>
										<li style="margin-top:10px;">5.- Atención médica, psicológica y nutricional telefónica 24/7.</li>
										<li style="margin-top:10px;">6.- 1 traslado de ambulancia sin costo.</li>
										<li style="margin-top:10px;">7.- Descuentos hasta el 50% en laboratorios, hospitales, cirugías, tratamientos dentales y visuales, enfermeras a domicilio, aparatos auditivos y más.</li>

									</ul>
                           <?php if ($lblPrecioVRIM != 0) { ?>
                           <div class="row" style="margin-top:40px; text-align:center;">
      								<button type="button" id="btnCotizarVrim" class="btn bg-blue waves-effect btnCotizarVrim" style="padding:40px 80px; font-size:100%;">CONTRATAR PLAN ANUAL POR <?php echo $lblPrecioVRIM; ?></button>
      							</div>
                           <?php } ?>
								</div>
							</div>


                     <div class="row" style="margin-top:40px;">
								<div class="col-xs-12 col-md-6">
									<h4 style="color: #C6AC83;font-size: 32px;line-height: 36px;">Vida 500</h4>
									<h4 style="line-height: 1.5; "><b>Contrata un Seguro de Vida y deja a tus beneficiarios $500,000 en caso de que faltes. También puedes cotizar suma asegurada de $1,000,000 de pesos.</b></h4>
                           <h4 style="line-height: 1.5; "><b>No hay pretexto para no estar asegurado; el trámite es sencillo y sin moverte de tu lugar.</b></h4>

                           <?php if ($lblPrecioVIDA500 != 0) { ?>
                           <div class="row" style="margin-top:40px; text-align:center;">
      								<button type="button" id="btnCotizarS500" class="btn bg-blue waves-effect btnCotizarS500" style="padding:40px 80px; font-size:100%;">CONTRATAR PLAN ANUAL POR <?php echo $lblPrecioVIDA500; ?></button>
      							</div>
                           <?php } ?>
                           <p><small>*El costo de este producto es variable de acuerdo a la edad de cada asegurado; $3,124 es un precio indicativo y hace referencia a la tarifa para personas de entre 40 y 44 años de edad que suscriben una protección por 500 mil pesos. Regístrate, cotiza y contrata en línea.</small></p>

								</div>
								<div class="col-xs-12 col-md-6">
									<img src="../../imagenes/vida-500-1000000_.jpg" width="100%"/>
								</div>

							</div>



                     <div class="row" style="margin-top:40px;">
								<div class="col-xs-12 col-md-6">
									<img src="../../imagenes/rc-medico___.jpg" width="100%"/>
								</div>
								<div class="col-xs-12 col-md-6">
									<h4 style="color: #C6AC83;font-size: 30px;line-height: 36px;">RC Médico</h4>

                           <h4 style="line-height: 1.5; "><b>Si eres doctor, contrata en línea protección de $2.5 o $5 Millones de Suma asegurada, para hacer frente a cualquier eventualidad derivado de un error o MALA PRAXIS.</b></h4>



                           <div class="row" style="margin-top:40px;">
      								<div class="col-xs-12 col-md-12">
                                 <label class="form-label">Con/Sin Cirugía</label>
                                 <div class="form-group input-group">
                                    <select class="form-control" id="cirugia" name="cirugia">
                                       <option value="1">Con Cirugía</option>
                                       <option value="2">Sin Cirugía</option>
                                    </select>
                                 </div>
                              </div>
                              <div class="col-xs-12 col-md-12">
                                 <label class="form-label">Limite de Responsabilidad</label>
                                 <div class="form-group input-group">
                                    <select class="form-control" id="limite" name="limite">
                                       <option value="1">$ 1,000,000.00 M.N.</option>
                                       <option value="2">$ 2,500,000.00 M.N.</option>
                                       <option value="3">$ 5,000,000.00 M.N.</option>
                                    </select>
                                 </div>
                              </div>
      							</div>
                           <div class="row" style="margin-top:40px; text-align:center;">
      								<button id="btnCotizarRD" type="button" class="btn bg-blue waves-effect btnCotizarRd" style="padding:40px 80px; font-size:100%;">CONTRATAR PLAN ANUAL POR <span class="valorRD"></span></button>
                              <input type="hidden" id="precioRD" name="precioRD" value=""/>
      							</div>


                           <p><small>*El costo de este producto es variable de acuerdo a la suma asegurada que solicite cada médico; $5,677 es un precio indicativo y hace referencia a la tarifa para médicos que practican cirugías y buscan una protección de 2.5M, que son las condiciones que más nos demandan. Regístrate elije las condiciones que mas te acomoden y suscribe en línea.</small></p>
								</div>
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
