<?php


$DESARROLLO = 0;


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


if ($DESARROLLO == 0) {

	$EM_Response= $_POST["EM_Response"];
	$EM_Total= $_POST["EM_Total"];
	$EM_OrderID= $_POST["EM_OrderID"];
	$EM_Merchant= $_POST["EM_Merchant"];
	$EM_Store= $_POST["EM_Store"];
	$EM_Term= $_POST["EM_Term"];
	$EM_RefNum= $_POST["EM_RefNum"];
	$EM_Auth= $_POST["EM_Auth"];
	$EM_Digest= $_POST["EM_Digest"];

	$newdigest  = sha1($_POST["EM_Total"].$_POST["EM_OrderID"].$_POST["EM_Merchant"].$_POST["EM_Store"].$_POST["EM_Term"].$_POST["EM_RefNum"]+"-"+$_POST["EM_Auth"]);


} else {





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


	$newdigest  = sha1($_POST["total"].$_POST["order_id"].$_POST["merchant"].$_POST["store"].$_POST["term"].$EM_RefNum+"-"+$EM_Auth);
}



//die(var_dump($EM_OrderID));


$redireccionar = array('error'=> 0, 'url' => '');

$resultado = $serviciosComercio->traerComercioinicioPorOrderId($EM_OrderID);

if (mysql_num_rows($resultado)>0) {
	$token = mysql_result($resultado,0,'token');
	$idestado = mysql_result($resultado,0,'refestadotransaccion');
	$reforigencomercio = mysql_result($resultado,0,'reforigencomercio');
	$idcotizacion = mysql_result($resultado,0,'idreferencia');
} else {
	$redireccionar['error'] = 1;
	$redireccionar['url'] = 'error.php';
	//header('Location: error.php');
	$idestado = 1;
}

if ($idestado == 2) {
	$redireccionar['error'] = 1;
	$redireccionar['url'] = '../facturacion/index.php';
	//header('Location: ../facturacion/index.php');
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

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($idcotizacion);
$precioTotal = mysql_result($resCotizaciones,0,'primatotal');
$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idusuariocliente  = mysql_result($resCotizaciones,0,'idusuariocliente');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$reftipoproductorama = mysql_result($resProducto,0,'reftipoproductorama');

$consolicitud = mysql_result($resProducto,0,'consolicitud');

$resUsuario = $serviciosUsuario->traerUsuarioId($idusuariocliente);

// solo para
if (!isset($_SESSION['usua_sahilices']))
{
	$resLogin = $serviciosUsuario->login(mysql_result($resUsuario,0,'email'),mysql_result($resUsuario,0,'password'));
}


if (!isset($_SESSION['usua_sahilices']))
{
	//header('Location: ../../error.php');
	$redireccionar['error'] = 1;
	$redireccionar['url'] = '../../error.php';
} else {

	$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../venta/');
	$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Venta",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

	/******* fin  **************************************************************/


	if ($error == 0) {
		// modifico el estado a aprobado
		$resModificarEstado = $serviciosComercio->modificarComercioInicioEstado($token,2);

		$nroComprobante = $serviciosComercio->generaNroRecibo();

		$resNroRecibo = $serviciosComercio->modificarComercioInicioNroRecibo($token,$nroComprobante);

		// verifico el origen de la transaccion para saber que tabla modificar
		if ($reforigencomercio == 7) {

			$resModificarPN = $serviciosReferencias->modificarCotizacionesPorCampo($idcotizacion,'refestados',1,$_SESSION['usua_sahilices']);

			// este producto en especifico no carga INE
			if ($idProducto == 41) {
				$resModificarPM = $serviciosReferencias->modificarCotizacionesPorCampo($idcotizacion,'refestadocotizaciones',21,$_SESSION['usua_sahilices']);
			} else {
				$resModificarPM = $serviciosReferencias->modificarCotizacionesPorCampo($idcotizacion,'refestadocotizaciones',20,$_SESSION['usua_sahilices']);
			}
			

			// obstengo el lead que se genero en venta en linea
			$resLead = $serviciosReferencias->traerLeadPorCotizacion($idcotizacion);

			// se viene de ahi lo marco como vendido el estado del mismo
			if (mysql_num_rows($resLead)>0) {
				$resModificarLead = $serviciosReferencias->modificarLeadCotizacion(mysql_result($resLead,0,0),$idcotizacion,5);
			}



			///////////////// creo el pago para luego conciliarlo /////////////////////////////////
			$destino = 'Pago Online Venta Producto en Linea';
			$refcuentasbancarias = 0;
			$conciliado = '0';
			$fechacrea = date('Y-m-d H:i:s');
			$usuariocrea = $_SESSION['usua_sahilices'];
			$archivos = 'ReciboPago.pdf';
			$type = 'pdf';
			$refestado = 1;
			$resPago = $serviciosReferencias->insertarPagos(12,$idcotizacion,$precioTotal,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,5,'Inbursa',$lblCliente,$nroComprobante,'0');

			///////////////// fin del pago /////////////////////////////////

		}




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
		$resPago = $serviciosReferencias->insertarPagos(12,$idcotizacion,$precioTotal,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,2,'Inbursa',$lblCliente,'','0');

		///////////////// fin del pago /////////////////////////////////
	}


	//die(var_dump($redireccionar));


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
				<div class="col-xs-12">
		        <div class="card">
		          <div class="header bg-<?php echo ($error == 0 ? 'green' : 'red'); ?>">
		            <h4 class="my-0 font-weight-normal">Estado de la transaccion <?php echo ($error == 0 ? 'Aprobada' : 'Invalida'); ?></h4>
		          </div>
		          <div class="body table-responsive">

							<?php if ($error == 0) { ?>
								<div class="text-center">
									<h3 class="display-4">REALIZA LOS SIGUIENTES PASO PARA OBTENER TU POLIZA.</h3>
								</div>

								<?php if ($consolicitud == 1) { ?>
								<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
								   <div class="col-xs-6 bs-wizard-step complete">
										<div class="text-center bs-wizard-stepnum">Paso 1</div>

										<div class="progress">
											<div class="progress-bar"></div>
										</div>

										<a href="siap.php?id=13" class="bs-wizard-dot"></a>
										<div class="bs-wizard-info text-center">CARGA TUS DOCUMENTOS</div>
								   </div>

								   <div class="col-xs-6 bs-wizard-step complete">
										<div class="text-center bs-wizard-stepnum">Paso 2</div>
										<div class="progress">
											<div class="progress-bar"></div>
										</div>
										<a href="javascript:void(0)" class="bs-wizard-dot"></a>
										<div class="bs-wizard-info text-center">FIRMAR LA SOLICITUD DE FORMA DIGITAL</div>
								   </div>

							   </div>
							<?php } else { ?>
								<div class="bs-wizard-info text-center">PASO 1 - CARGA TUS DOCUMENTOS</div>
								<hr>
							<?php } ?>


							<div class="text-center">
								<div class="list-group">
									<a href="archivos.php?id=<?php echo $idcotizacion; ?>" class="list-group-item bg-green">CONTINUAR</a>
								</div>
							<?php } else { ?>
							<div class="text-center">
								<h1 class="display-4"><?php echo $lblError; ?></h1>
								<p class="lead">Desde Asesores CREA nos estaremos comunicando con usted para ayudarlo.</p>

								<?php if ($instanciaDelError != 3) { ?>

									<?php if ($DESARROLLO == 0) { ?>
					            	<?php if ($reftipoproductorama == 12) { ?>
										<form action="https://www.procom.prosa.com.mx/eMerchant/8418704_OperMedicaVrim.jsp" method="post" id="formFin">
									<?php } else { ?>
										<form action="https://www.procom.prosa.com.mx/eMerchant/8407825_SegInbursa.jsp" method="post" id="formFin">
									<?php } ?>
					            <?php } else { ?>
					            	<form action="8407825_asesorescrea.php" method="post" id="formFin">
					            <?php } ?>
					               <input type="hidden" name="total" value="<?php echo $EM_Total; ?>">
					               <input type="hidden" name="currency" value="<?php echo '484'; ?>">
					               <input type="hidden" name="address" value="<?php echo ''; ?>">
					               <input type="hidden" name="order_id" value="<?php echo $EM_OrderID; ?>">
					               <input type="hidden" name="merchant" value="<?php echo $EM_Merchant; ?>">
					               <input type="hidden" name="store" value="<?php echo $EM_Store; ?>">
					               <input type="hidden" name="term" value="<?php echo $EM_Term; ?>">
					               <input type="hidden" name="digest" value="<?php echo $newdigest; ?>">
					               <input type="hidden" name="return_target" value="">

					               <input type="hidden" name="urlBack" value="https://asesorescrea.com/desarrollo/crm/dashboard/venta/comercio_con.php">
										<div class="row">
										<div class="col-xs-1"></div>
					               <div class="col-xs-5">
											<button type="submit" class="btn btn-lg btn-block btn-success" id="btnConfirmar" style="font-size:1.5em;">
												<i class="material-icons" style="font-size:1.5em;">credit_card</i>
												<span>Intentar Nuevamente</span>
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
					id: <?php echo $idcotizacion; ?>,
					accion: 'cambiarMetodoDePago'
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
