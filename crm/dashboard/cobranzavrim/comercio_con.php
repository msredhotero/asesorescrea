<?php


	include ('../../includes/funciones.php');
	include ('../../includes/funcionesUsuarios.php');
	include ('../../includes/funcionesHTML.php');
	include ('../../includes/funcionesReferencias.php');
	include ('../../includes/base.php');
	include ('../../includes/funcionesComercio.php');

	$serviciosFunciones 	= new Servicios();
	$serviciosUsuario 		= new ServiciosUsuarios();
	$serviciosHTML 			= new ServiciosHTML();
	$serviciosReferencias 	= new ServiciosReferencias();
	$baseHTML = new BaseHTML();
	$serviciosComercio      = new serviciosComercio();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();

//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);


$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';


/*

$EM_Response= $_POST["EM_Response"];
$EM_Total= $_POST["EM_Total"];
$EM_OrderID= $_POST["EM_OrderID"];
$EM_Merchant= $_POST["EM_Merchant"];
$EM_Store= $_POST["EM_Store"];
$EM_Term= $_POST["EM_Term"];
$EM_RefNum= $_POST["EM_RefNum"];
$EM_Auth= $_POST["EM_Auth"];
$EM_Digest= $_POST["EM_Digest"];

*/



switch (trim(str_replace(' ','',$_POST['cc_number']))) {
	case '5062541600005232':
		$EM_Response= 'approved';
		$EM_RefNum= '123456789123';
		$EM_Auth= '123456';
	break;
	case '5105105105105100':
		$EM_Response= 'Incorrect Information is provided.';
		$EM_RefNum= '123456789123';
		$EM_Auth= '000000';
	break;
	case '5555555555554444':
		$EM_Response= 'denied';
		$EM_RefNum= '123456789123';
		$EM_Auth= '000000';
	break;
	case '4111111111111111':
		$EM_Response= 'Duplicated transaction';
		$EM_RefNum= '123456789123';
		$EM_Auth= '000000';
	break;
	default:
		$EM_Response= 'approved';
		$EM_RefNum= '123456789123';
		$EM_Auth= '123456';
	break;

}

if (!(isset($_POST["EM_RefNum"]))) {
	$EM_RefNum= '123456789123';
} else {
	$EM_RefNum= $_POST["EM_RefNum"];
}

if (!(isset($_POST["EM_Auth"]))) {
	$EM_Auth= '123456';
} else {
	$EM_Auth= $_POST["EM_RefNum"];
}


$EM_Total= $_POST["total"];
$EM_OrderID= $_POST["order_id"];
$EM_Merchant= $_POST["merchant"];
$EM_Store= $_POST["store"];
$EM_Term= $_POST["term"];

$EM_Digest= $_POST["digest"];


//$newdigest  = sha1($_POST["EM_Total"].$_POST["EM_OrderID"].$_POST["EM_Merchant"].$_POST["EM_Store"].$_POST["EM_Term"].$_POST["EM_RefNum"]+"-"+$_POST["EM_Auth"]);
$newdigest  = sha1($_POST["total"].$_POST["order_id"].$_POST["merchant"].$_POST["store"].$_POST["term"].$EM_RefNum+"-"+$EM_Auth);

$resultado = $serviciosComercio->traerComercioinicioPorOrderId($EM_OrderID);

//die(var_dump($EM_OrderID));

if (mysql_num_rows($resultado)>0) {
	$token = mysql_result($resultado,0,'token');
	$idestado = mysql_result($resultado,0,'refestadotransaccion');
	$reforigencomercio = mysql_result($resultado,0,'reforigencomercio');
	$idcotizacion = mysql_result($resultado,0,'idreferencia');
} else {
	header('Location: error.php');
	$idestado = 1;
}

if ($idestado == 2) {
	header('Location: ../facturacion/index.php');
}




$error = 0;
$lblError = '';

$instanciaDelError = 0;


switch ($EM_Response) {
   case 'Incorrect Information is provided.':
      $error = 1;
      $lblError = 'La informacion que proporciono de la tarjeta es incorrecta';
      $instanciaDelError = 1;
		$idestado = 3;
   break;
   case 'denied':
      $error = 1;
      $lblError = 'Su tarjeta fue rechazada';
      $instanciaDelError = 2;
		$idestado = 4;
   break;
   case 'Duplicated transaction':
      $error = 1;
      $lblError = 'Se genero un error, nos comunicaremos con usted en la brevedad';
      $instanciaDelError = 3;
		$idestado = 5;
   break;
   case 'approved':
      $error = 0;
      $lblError = '';
   break;
}

$resTransaccion = $serviciosComercio->insertarComerciofin($EM_Response,$EM_Total,$EM_OrderID,$EM_Merchant,$EM_Store,$EM_Term,$EM_RefNum,$EM_Auth,$EM_Digest,$token);


/********** dato de la cotizacion ******************************************/

$resCotizaciones = $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($idcotizacion);
$precioTotal = mysql_result($resCotizaciones,0,'montototal');
$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idusuariocliente  = mysql_result($resCotizaciones,0,'refusuarios');

$resUsuario = $serviciosUsuario->traerUsuarioId($idusuariocliente);

// solo para
if (!isset($_SESSION['usua_sahilices']))
{
	$resLogin = $serviciosUsuario->login(mysql_result($resUsuario,0,'email'),mysql_result($resUsuario,0,'password'));
}


if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../../error.php');

} else {
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cobranzavrim/');
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Recibos de Pago VRIM",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

/******* fin  **************************************************************/


if ($error == 0) {

	// MODIFICO EL RECIBO A PROCESO DE VALIDACION, COPIA EL RECIBO Y LO ADJUNTO AL COMPROBANTE DE PAGO
	$resME = $serviciosReferencias->modificarPeriodicidadventasdetalleEstado($idcotizacion,2,$_SESSION['usua_sahilices'],date('Y-m-d H:i:s'));


	$nroComprobante = $serviciosComercio->generaNroRecibo();


	// modifico el estado a aprobado
	$resModificarEstado = $serviciosComercio->modificarComercioInicioEstado($token,2);



	$resNroRecibo = $serviciosComercio->modificarComercioInicioNroRecibo($token,$nroComprobante);

	// verifico el origen de la transaccion para saber que tabla modificar
	if ($reforigencomercio == 7) {

		$resModificarPN = $serviciosReferencias->modificarPeriodicidadventasdetalleEstado($id,2,$_SESSION['usua_sahilices'],date('Y-m-d H:i:s'));

		///////////////// creo el pago para luego conciliarlo /////////////////////////////////
		$destino = 'Pago Online Venta Producto en Linea';
		$refcuentasbancarias = 0;
		$conciliado = '0';
		$fechacrea = date('Y-m-d H:i:s');
		$usuariocrea = $_SESSION['usua_sahilices'];
		$archivos = 'ReciboPago.pdf';
		$type = 'pdf';
		$refestado = 1;
		$resPago = $serviciosReferencias->insertarPagos(15,$EM_OrderID,$precioTotal,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,5,'Inbursa',$lblCliente,$nroComprobante,'0');

		///////////////// fin del pago /////////////////////////////////

	}

	if ($reforigencomercio == 8) {

		$resModificarPN = $serviciosReferencias->modificarPeriodicidadventasdetalleEstado($id,2,$_SESSION['usua_sahilices'],date('Y-m-d H:i:s'));

		///////////////// creo el pago para luego conciliarlo /////////////////////////////////
		$destino = 'Pago Online Recibo';
		$refcuentasbancarias = 0;
		$conciliado = '0';
		$fechacrea = date('Y-m-d H:i:s');
		$usuariocrea = $_SESSION['usua_sahilices'];
		$archivos = 'ReciboPago.pdf';
		$type = 'pdf';
		$refestado = 1;
		$resPago = $serviciosReferencias->insertarPagos(15,$EM_OrderID,$precioTotal,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,5,'Inbursa',$lblCliente,$nroComprobante,'0');

		///////////////// fin del pago /////////////////////////////////

	}

	require ('../../reportes/rptFacturaPagoReciboOnlineManual.php');


	////////////////// genero el insert del pago y copio el archivo ////////
	$resPP = $serviciosReferencias->insertarPeriodicidadventaspagos($idcotizacion,$precioTotal,$nroComprobante,date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),'');

	if ((integer)$resPP > 0) {
		$resPagoAux = $serviciosReferencias->traerPagosPorId($idcomprobantedepago);

		if (!file_exists('../archivos/cobros/'.$idcotizacion.'/')) {
			mkdir('../archivos/cobros/'.$idcotizacion.'/', 0777);
		}

		if (!file_exists('../archivos/cobros/'.$idcotizacion.'/'.'facturacliente/')) {
			mkdir('../archivos/cobros/'.$idcotizacion.'/'.'facturacliente/', 0777);
		}

		$resCopy = copy('../archivos/pagosonlinerecibos/'.mysql_result($resPagoAux,0,'idreferencia').'/'.mysql_result($resPagoAux,0,'archivos'), '../archivos/cobros/'.$idcotizacion.'/'.'facturacliente/'.mysql_result($resPagoAux,0,'archivos'));


		if ($resCopy) {
			$resEliminar = $serviciosReferencias->eliminarDocumentacionventasPorVentaDocumentacionDetalle($idcotizacion,39);

			$resInsertar = $serviciosReferencias->insertarDocumentacionventas(0,39,mysql_result($resPagoAux,0,'archivos'),mysql_result($resPagoAux,0,'type'),5,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],$idcotizacion);
		}

		$resAplicar = $serviciosReferencias->aplicarPago($idcomprobantedepago,'1');
	}

	/////// fin ////////////////////////////////////////////////////////////


} else {
	$resModificarEstado = $serviciosComercio->modificarComercioInicioEstado($token,$idestado);

	///////////////// creo el pago para luego conciliarlo /////////////////////////////////
	$destino = 'Pago Online Venta Producto en Linea';
	$refcuentasbancarias = 0;
	$conciliado = '0';
	$fechacrea = date('Y-m-d H:i:s');
	$usuariocrea = $_SESSION['usua_sahilices'];
	$archivos = '';
	$type = '';
	$resPago = $serviciosReferencias->insertarPagos(15,$EM_OrderID,$precioTotal,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,2,'Inbursa',$lblCliente,'','0');

	///////////////// fin del pago /////////////////////////////////
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
				<div class="col-xs-12">
		        <div class="card">
		          <div class="header bg-<?php echo ($error == 0 ? 'green' : 'red'); ?>">
		            <h4 class="my-0 font-weight-normal">Estado de la transaccion <?php echo ($error == 0 ? 'Aprobada' : 'Invalida'); ?></h4>
		          </div>
		          <div class="body table-responsive">

							<?php if ($error == 0) { ?>
								<div class="text-center">
									<h2 class="display-4">Hemos procesamos tu pago Correctamente.</h2>
									<h5>¡Muchas Gracias! en breve te enviaremos tu factura</h5>
								</div>



							<div class="text-center">

							<?php } else { ?>
							<div class="text-center">
								<h1 class="display-4"><?php echo $lblError; ?></h1>
								<p class="lead">Desde Asesores CREA nos estaremos comunicando con usted para ayudarlo.</p>

								<?php if ($instanciaDelError != 3) { ?>

									<form action="8407825_asesorescrea.php" method="post" id="formFin">
					               <input type="hidden" name="total" value="<?php echo $EM_Total; ?>">
					               <input type="hidden" name="currency" value="<?php echo '484'; ?>">
					               <input type="hidden" name="address" value="<?php echo ''; ?>">
					               <input type="hidden" name="order_id" value="<?php echo $EM_OrderID; ?>">
					               <input type="hidden" name="merchant" value="<?php echo $EM_Merchant; ?>">
					               <input type="hidden" name="store" value="<?php echo $EM_Store; ?>">
					               <input type="hidden" name="term" value="<?php echo $EM_Term; ?>">
					               <input type="hidden" name="digest" value="<?php echo $newdigest; ?>">
					               <input type="hidden" name="return_target" value="">
					               <input type="hidden" name="urlBack" value="../pay/comercio_con.php">
										<div class="row">
										<div class="col-xs-1"></div>
					               <div class="col-xs-5">
											<button type="submit" class="btn btn-lg btn-block btn-success" id="btnConfirmar" style="font-size:1.5em;">
												<i class="material-icons" style="font-size:1.5em;">credit_card</i>
												<span>Intenter Nuevamente</span>
											</button>
										</div>
										<div class="col-xs-5">
											<button type="button" class="btn btn-lg btn-block btn-primary" id="btnCambiar" style="font-size:1.5em;">
												<i class="material-icons" style="font-size:1.5em;">cached</i>
												<span>Cambiar Metodo de Pago</span>
											</button>
										</div>
										<div class="col-xs-1"></div>
										</div>
					            </form>
								<?php } ?>
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

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>


<script>
	$(document).ready(function(){

		var btnConfirmar = $('#btnConfirmar');

		btnConfirmar.click(function(e) {

			$( "#formPago" ).submit();
		});


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



		$("#sign_in").submit(function(e){
			e.preventDefault();
		});




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


		$('#btnCambiar').click(function(e){

			$.ajax({
				data:  {
					id: <?php echo $EM_OrderID; ?>,
					accion: 'cambiarMetodoDePagoRecibos'
				},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("#btnConfirmar").hide();
					$("#btnCambiar").hide();
				},
				success:  function (response) {


					if (response.error) {

						$("#btnConfirmar").show();
						$("#btnCambiar").show();
					} else {

						$(location).attr('href',response.url);
					}



				}
			});
		});



	});
</script>








</body>
<?php } ?>
</html>
