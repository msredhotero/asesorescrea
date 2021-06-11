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

	$serviciosFunciones 	= new Servicios();
	$serviciosUsuario 		= new ServiciosUsuarios();
	$serviciosHTML 			= new ServiciosHTML();
	$serviciosReferencias 	= new ServiciosReferencias();
	$baseHTML = new BaseHTML();
	$serviciosComercio      = new serviciosComercio();

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
	
	header('Location: ../cotizacionesvigentes/index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

/*
$resVentas = $serviciosReferencias->traerVentasPorCotizacion($id);

if (mysql_num_rows($resVentas) > 0) {
	$idventa = mysql_result($resVentas,0,0);
} else {
	$foliointerno = $serviciosReferencias->generaFolioInterno();
	$foliotys = '';
	$resIV = $serviciosReferencias->insertarVentas($id,1,0,0,'','',date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],$foliotys,$foliointerno);

	$idventa = $resIV;
}
*/

$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$resCliente = $serviciosReferencias->traerClientesPorIdCompleto($idCliente);

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');

$esDomiciliado = mysql_result($resProducto,0,'esdomiciliado');


if (mysql_num_rows($resCotizaciones)>0) {
	//$precio = mysql_result($resCotizaciones,0,'precio');
	//$lblPrecio = str_replace('.','',$precio);

} else {
	
	header('Location: ../cotizacionesvigentes/index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);


$resAux = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

if (mysql_num_rows($resAux)>0) {
	$existeMetodoPago = 1;
} else {
	$existeMetodoPago = 0;
}

/**************** validacion precio
* en base a la edad determino el precio del producto o si puede o no adquirirlo
* tambien si existe alguna pregunta que inhabilita
* $precio
* $resAsegurado
* $resCliente
* $id
* para el producto vida 500 verifico la estatura y peso , el peso no puede ser calculo: abs(altura - 100 - peso) > 20
*/
$inhabilitadoPorRespuesta = 0;
$nopuedeContinuar = 0;
$arErrorLbl = array();

/******************** para vida 500 nada mas id:54 *****************/
if ($idProducto == 54) {
	//peso id pregunta: 692
	//altura id: 693

	
	$pesoCliente = 0;
	$resRespuestaValorPeso = $serviciosReferencias->traerCuestionariodetallePorTablaReferenciaIdRespuesta(11, 'dbcotizaciones', 'idcotizacion', $id,'1077');

	if (mysql_num_rows($resRespuestaValorPeso)>0) {
		$pesoCliente = (integer)mysql_result($resRespuestaValorPeso,0,'respuestavalor');
		
	}

	$alturaCliente = 0;
	$resRespuestaValorAltura = $serviciosReferencias->traerCuestionariodetallePorTablaReferenciaIdRespuesta(11, 'dbcotizaciones', 'idcotizacion', $id,'1078');

	if (mysql_num_rows($resRespuestaValorAltura)>0) {
		$alturaCliente = (integer)mysql_result($resRespuestaValorAltura,0,'respuestavalor');
	}

	if (($pesoCliente == 0) || ($alturaCliente == 0)) {
		
		$inhabilitadoPorRespuesta = 1;
		$nopuedeContinuar = 1;
		array_push($arErrorLbl,array('error' => 'El peso o la altura no pueden ser igual a cero, esta cotización no puede ser aceptada, intente nuevamente'));
	} else {
		if (abs($alturaCliente - 100 - $pesoCliente) > 20) {
			$inhabilitadoPorRespuesta = 1;
			$nopuedeContinuar = 1;
			array_push($arErrorLbl,array('error' => 'El peso y la altura no no califican para este producto'));
		}
	}
}

//die(var_dump(abs(abs($alturaCliente - 100 - $pesoCliente))));

/*********************** fin */



$aplicaA = '';

if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {
	$resAsegurado = $serviciosReferencias->traerAseguradosPorId(mysql_result($resCotizaciones,0,'refasegurados'));
	// asegurada
	$edad = $serviciosReferencias->calculaedad(mysql_result($resAsegurado,0,'fechanacimiento'));
	$aplicaA = 'asegurado';

} else {
	// el contratante
	$edad = $serviciosReferencias->calculaedad(mysql_result($resCliente,0,'fechanacimiento'));
	$aplicaA = 'contratante';
}

$acumPrecio = 0;

$edadNoAplica = 0;

if ($edad >= 60) {
	$nopuedeContinuar = 1;
	$edadNoAplica = 1;
	array_push($arErrorLbl,array('error' => 'Lo sentimos para el Producto solicitado no es alcanzable para la edad del '.$aplicaA.' '.$edad.' años'));
} else {
	

	//para RC medicos por ahora
	if ($idProducto == 55) {
		$resCalculoMedico1 = $serviciosReferencias->traerCuestionariodetallePorTablaReferenciaIdRespuesta(11, 'dbcotizaciones', 'idcotizacion', $id,'1390,1392');
		$resCalculoMedico2 = $serviciosReferencias->traerCuestionariodetallePorTablaReferenciaIdRespuesta(11, 'dbcotizaciones', 'idcotizacion', $id,'1390,1393');
		$resCalculoMedico3 = $serviciosReferencias->traerCuestionariodetallePorTablaReferenciaIdRespuesta(11, 'dbcotizaciones', 'idcotizacion', $id,'1391,1392');
		$resCalculoMedico4 = $serviciosReferencias->traerCuestionariodetallePorTablaReferenciaIdRespuesta(11, 'dbcotizaciones', 'idcotizacion', $id,'1391,1393');
		$acumPrecio = 0;
		if (mysql_num_rows($resCalculoMedico1)==2) {
			$acumPrecio = 8124.4;
		}
		if (mysql_num_rows($resCalculoMedico2)==2) {
			$acumPrecio = 5677.2;
		}
		if (mysql_num_rows($resCalculoMedico3)==2) {
			$acumPrecio = 6118;
		}
		if (mysql_num_rows($resCalculoMedico4)==2) {
			$acumPrecio = 4278.8;
		}
		
	} else {
		// calculos
		$resProductosPaquete = $serviciosReferencias->traerPaquetedetallesPorPaquete($idProducto);

		// es un producto con paquete, son montos combinados
		if (mysql_num_rows($resProductosPaquete)>0) {

			// voy acumulando los valores
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

					$nopuedeContinuar = 1;
					break;
				}

			}
		} else {
			// obtengo el valor en base a los valores cargados
			$existeCotizacionParaProducto = $serviciosReferencias->traerValoredadPorProductoEdad($idProducto,$edad);

			if (mysql_num_rows($existeCotizacionParaProducto)>0) {
				//die(var_dump($rowP['refproductos']));
				$acumPrecio += mysql_result($existeCotizacionParaProducto,0,'valor');

			} else {
				$nopuedeContinuar = 1;
				array_push($arErrorLbl,array('error' => 'Lo sentimos para el Producto solicitado no es alcanzable para la edad del '.$aplicaA.' '.$edad.' años'));
			}

		}
	}
	
}

$precio = $acumPrecio;

$lblPrecioAd = $precio * 1.07;

$lblPrecioFC = str_replace('.','', $precio * 1.115 ) ;

$resInhabilitaRespuesta = $serviciosReferencias->inhabilitaRespuestascuestionarioPorCotizacion($id);

if (mysql_num_rows($resInhabilitaRespuesta)>0) {
	$nopuedeContinuar = 1;
	$inhabilitadoPorRespuesta = 1;
	//si es vida 500, lo dejo pasar, lo envio a cargar el INE, a firmar la solicitud y aviso a ruth y a vidaseleccion@inbursa.com con asunto emision vida 500
	//id: 54 vida 500
	if ($idProducto == 54) {
		$resModificar1 = $serviciosReferencias->modificarCotizacionesPorCampo($id,'refestadocotizaciones',20,$_SESSION['usua_sahilices']);

		header('Location: archivos.php?id='.$id);
	}
	array_push($arErrorLbl,array('error'=>'Lo sentimos las preguntas que respondio en el cuestionario, no superan lo necesario para acceder al Producto.'));
}

$resBancos = $serviciosReferencias->traerBancos();
$cadBancos = "<option value=''>-- Seleccionar --</option>";
$cadBancos .= $serviciosFunciones->devolverSelectBoxText($resBancos,array(1),'');

/********************** fin de las validaciones ********************************/

$esFinancieraCrea = 0;
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
		          <div class="header bg-blue">
		            <h4 class="my-0 font-weight-normal">Resumen del Pedido: <?php echo mysql_result($resultado,0,'producto'); ?></h4>
		          </div>
		         <div class="body table-responsive">

						<?php // verifico las validaciones
						if ($nopuedeContinuar == 0) {
						?>

							<div class="text-center">
								<h1 class="display-4">¡Elige tu método de pago!</h1>

							</div>
							<?php //echo $detalleProducto; ?>




			            <hr>
							<?php if ($existeMetodoPago == 0) { ?>
							<form method="POST" id="formFin">

								<div class="panel-group" id="accordion_17" role="tablist" aria-multiselectable="true">

									<?php if ($esFinancieraCrea == '1') { ?>
									<div class="panel panel-col-cyan panelMP panelMP3">
										<div class="panel-heading" role="tab" id="headingThree_17">
											<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseThree_17" aria-expanded="false" aria-controls="collapseThree_17">
											<i class="material-icons">credit_card</i> Pago Anual - Descuento por Nomina
											</a>
											</h4>
										</div>
										<div id="collapseThree_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree_17" aria-expanded="false">
											<div class="panel-body">
												<p>El cobro sera procesado por Financiera CREA.</p>

												<h5>16 cuotas de MX $<?php echo number_format( ceil(($precio * 1.115 / 16)) , 2, ',', '.'); ?></h5>
												<div class="right">
													<input name="metodopago" type="radio" value="3" class="with-gap radioMetodo" id="radio_3" require>
	                                 	<label for="radio_3">Seleccionar</label>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>

									<div class="panel panel-col-cyan panelMP panelMP1">
										<div class="panel-heading" role="tab" id="headingOne_17">
											<h4 class="panel-title">
											<a role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseOne_17" aria-expanded="true" aria-controls="collapseOne_17" class="">
											<i class="material-icons">credit_card</i> Pago Anual en linea con Tarjeta de Crédito o Débito
											</a>
											</h4>
										</div>
										<div id="collapseOne_17" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne_17" aria-expanded="true" style="">
											<div class="panel-body">
												<p>Pago anual con tarjeta de crédito o débito, a traves de nuestro procesador de pagos. Se admiten tarjetas Visa y Mastercard.</p>
												<p><small>1 pago de </small></p>
												<h4>Monto a pagar: MXN <?php echo number_format($precio, 2, ',', '.'); ?></h4>
												<div class="right">
													<input name="metodopago" type="radio" value="1" class="with-gap radioMetodo" id="radio_1" require>
	                                 	<label for="radio_1">Seleccionar</label>
												</div>
											</div>
										</div>
									</div>
									<div class="panel panel-col-cyan panelMP panelMP2">
										<div class="panel-heading" role="tab" id="headingTwo_17">
											<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseTwo_17" aria-expanded="false" aria-controls="collapseTwo_17">
											<i class="material-icons">credit_card</i> Pago Anual por Transferencia Electrónica
											</a>
											</h4>
										</div>
										<div id="collapseTwo_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo_17" aria-expanded="false">
											<div class="panel-body">
												<p>Debe adjuntarnos su comprobante de pago y activar el servicio.</p>
												<?php if ($idProducto == 41) { ?>
													<p>Clabe Interbancaria para transferencias: 036180500010368744</p>
												<?php } else { ?>
													<p>Clabe Interbancaria para transferencias: 036180500079200351</p>	
												<?php } ?>
												
												<p><small>1 pago de </small></p>
												<h4>Monto a pagar: MXN <?php echo number_format($precio, 2, ',', '.'); ?></h4>
												<div class="right">
													<input name="metodopago" type="radio" value="2" class="with-gap radioMetodo" id="radio_2" require>
	                                 	<label for="radio_2">Seleccionar</label>
												</div>
											</div>
										</div>
									</div>

									<?php if ($esDomiciliado == '1') { ?>
									<div class="panel panel-col-cyan panelMP panelMP4">
										<div class="panel-heading" role="tab" id="headingFour_17">
											<h4 class="panel-title">
											<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion_17" href="#collapseFour_17" aria-expanded="false" aria-controls="collapseFour_17">
											<i class="material-icons">credit_card</i> Pago domiciliado mensual a tu tarjeta crédito o débito
											</a>
											</h4>
										</div>
										<div id="collapseFour_17" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour_17" aria-expanded="false">
											<div class="panel-body">
												<p>Se le domiciliara el pago mensual del servicio.</p>
												<h5>12 cuotas de <?php echo number_format($lblPrecioAd / 12, 2, ',', '.'); ?></h5>

												<div class="right">
													<input name="metodopago" type="radio" value="4" class="with-gap radioMetodo" id="radio_4" require>
	                                 	<label for="radio_4">Seleccionar</label>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>



								</div>

								<div class="row">
									<div class="col-xs-12 hidden">
										<h4>¿Desea Domiciliar el pago?</h4>
										<input name="domiciliar" type="radio" value="1" id="radio_5" require>
										<label for="radio_5">Si</label>
										<input name="domiciliar" type="radio" value="0" id="radio_6" require>
										<label for="radio_6">No</label>
									</div>
								</div>

								<div class="row">
									<div class="panel-group" id="accordion_18" role="tablist" aria-multiselectable="true">
									<div class="col-xs-6">
										<div class="panel panel-col-pink panelD panelD1">
											<div class="panel-heading" role="tab" id="headingFour_18">
												<h4 class="panel-title">
												<a role="button" data-parent="#accordion_18">
												<i class="material-icons">credit_card</i> Tarjeta de Crédito
												</a>
												</h4>
											</div>
											<div id="collapseFour_18" class="panel" role="tabpanel" aria-labelledby="headingFour_18" aria-expanded="false">
												<div class="panel-body">
													<p>Se requeriran los datos del banco emisor de la tarjeta de crédito y el número que aparece en el tarjeta.</p>
													<label for="banco1" class="label-form">Banco</label>
													<select name="banco1" id="banco1" class="form-control">
														<?php echo $cadBancos; ?>
													</select>


													<label for="cardnumber1" class="label-form">Número de tarjeta</label>
													<div id="card-number-field1">
														<input type="text" id="cardnumber1" name="cardnumber1" class="form-control"/>
													</div>
													<div class="right">
														<input name="rdomiciliacion" type="radio" value="10" class="radio-col-pink" id="radio_7" require>
		                                 	<label for="radio_7">Seleccionar</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xs-6">
										<div class="panel panel-col-pink panelD panelD2">
											<div class="panel-heading" role="tab" id="headingFour_19">
												<h4 class="panel-title">
												<a role="button" data-parent="#accordion_18">
												<i class="material-icons">credit_card</i> Cuenta de Deposito
												</a>
												</h4>
											</div>
											<div id="collapseFour_19" class="panel" role="tabpanel" aria-labelledby="headingFour_19" aria-expanded="false">
												<div class="panel-body">
													<p>Se requeriran los datos del banco emisor de la cuenta depósito y el número de cuenta o CLABE.</p>
													<label for="banco2" class="label-form">Banco</label>
													<select name="banco2" id="banco2" class="form-control">
														<?php echo $cadBancos; ?>
													</select>


													<label for="cardnumber1" class="label-form">Número de cuenta o número de CLABE</label>
													<div id="card-number-field2">
														<input type="text" id="cardnumber2" name="cardnumber2" class="form-control"/>
													</div>
													<div class="right">
														<input name="rdomiciliacion" type="radio" value="11" class="radio-col-pink" id="radio_8" require>
		                                 	<label for="radio_8">Seleccionar</label>
													</div>
												</div>
											</div>
										</div>
									</div>
									</div>
								</div>


			               <input type="hidden" name="refcotizaciones" value="<?php echo $id; ?>">
			               <input type="hidden" name="reftipoperiodicidad" value="1">

								<div class="row">
									<div class="col-xs-3"></div>
				               <div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmar" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">save</i>
											<span>GUARDAR Y CONTINUAR</span>
										</button>
									</div>
									<div class="col-xs-3"></div>
								</div>
			            </form>
						<?php } else { ?>
							<h4>El metodo de pago ya fue cargado, continue con la seccion de Documentaciones por favor</h4>
							<div class="list-group">
								<a href="javascript:void(0);" class="list-group-item active">
								Método de Pago
								</a>
								<a href="javascript:void(0);" class="list-group-item">Tipo Cobranza: <?php echo mysql_result($resAux,0,'tipocobranza'); ?></a>
								<a href="javascript:void(0);" class="list-group-item">Tipo Pago: <?php echo mysql_result($resAux,0,'tipoperiodicidad'); ?></a>
							<?php
								if (mysql_result($resAux,0,'reftipocobranza') == 1) {
									if (mysql_result($resAux,0,'tipotarjeta') == 1) {
										$lblTipoTarjeta = 'Tarjeta de Crédito';
									} else {
										$lblTipoTarjeta = 'Cuenta de Deposito';
									}
									if (mysql_result($resAux,0,'afiliacionnumber') != '') {
										$tarjeta = $serviciosReferencias->decryptIt(mysql_result($resAux,0,'afiliacionnumber'));
										$tarjeta = $serviciosReferencias->hiddenString($tarjeta,0,4);
									} else {
										$tarjeta = 'Aun no fue cargada';
									}

							?>
								<a href="javascript:void(0);" class="list-group-item">Banco: <?php echo mysql_result($resAux,0,'tipoperiodicidad'); ?></a>
								<a href="javascript:void(0);" class="list-group-item"><?php echo $lblTipoTarjeta; ?>: <?php echo $tarjeta; ?></a>

							<?php } ?>
							<?php if (mysql_result($resultado,0,'refestadocotizaciones') == 19) { ?>
								<a href="comercio_fin.php?id=<?php echo $id; ?>" class="list-group-item bg-green">CONTINUAR CON EL PAGO ONLINE</a>
							<?php } ?>
							<?php if (mysql_result($resultado,0,'refestadocotizaciones') == 20) { ?>
								<a href="archivos.php?id=<?php echo $id; ?>" class="list-group-item bg-green">CONTINUAR CON LOS ARCHIVOS NECESARIOS</a>
							<?php } ?>
							<?php if (mysql_result($resultado,0,'refestadocotizaciones') == 21) { ?>
								<a href="documentos.php?id=<?php echo $id; ?>" class="list-group-item bg-green">CONTINUAR CON LA DOCUMENTACION</a>
							<?php } ?>
							<?php if (mysql_result($resultado,0,'refestadocotizaciones') == 22) { ?>
								<a href="archivos.php?id=<?php echo $id; ?>" class="list-group-item bg-green">CONTINUAR CON LA DOCUMENTACION</a>
							<?php } ?>
							</div>
						<?php } ?>

					<?php
						// sino valido salgo por aca
						} else {
					?>
					<div class="text-center">
						<?php
							foreach ($arErrorLbl as $value) {
								# code...
								echo '<h3>'.$value['error'].'</h3>';
							}
						?>
						<br>
						<h5>Por favor pongase en contacto con uno de nuestros representantes para solicitar asesoramiento, acerca del producto</h5>
						<p>Puedes contactarnos en el Teléfono: <b><span style="color:#5DC1FD;">55 51 35 02 59</span></b></p>
						<br>
						<br>
						<h4>Muchas Gracias!.</h4>
					</div>
					<?php } ?>
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
<script src="https://asesorescrea.com/desarrollo/crm/dashboard/ecommerce/assets/js/jquery.payform.min.js"></script>


<script>
	$(document).ready(function(){

		$('#accordion_18').hide();
		var cardNumberField1 = $('#card-number-field1');
		var cardNumberField2 = $('#card-number-field2');

		$('#cardnumber1').payform('formatCardNumber');
		$('#cardnumber2').payform('formatCardNumber');

		$('#cardnumber1').keyup(function() {


			if ($.payform.validateCardNumber($('#cardnumber1').val()) == false) {
				cardNumberField1.addClass('has-error');
			} else {
				cardNumberField1.removeClass('has-error');
				cardNumberField1.addClass('has-success');
			}

		});

		$('#cardnumber2').keyup(function() {


			if ($.payform.validateCardNumber($('#cardnumber2').val()) == false) {
				cardNumberField2.addClass('has-error');
			} else {
				cardNumberField2.removeClass('has-error');
				cardNumberField2.addClass('has-success');
			}

		});

		$('#radio_5').prop('disabled',true);

		$('.with-gap').click(function() {

			$('.panelMP').removeClass('panel-col-green');
			$('.panelMP').removeClass('panel-col-cyan');
			$('.panelMP').addClass('panel-col-cyan');

			if ($(this).is(':checked')) {
				$('.panelMP' + $(this).val()).removeClass('panel-col-cyan');
				$('.panelMP' + $(this).val()).addClass('panel-col-green');
			}

			if (($(this).val() == 1) || ($(this).val() == 2) || ($(this).val() == 3)) {
				$('#radio_6').prop('disabled',false);
				$('#radio_6').click();
				$('#radio_5').prop('disabled',true);

				borrarDomiciliacion();
			}

			if ($(this).val() == 4) {
				$('#radio_5').prop('disabled',false);
				$('#radio_5').click();
				$('#radio_6').prop('disabled',true);

				borrarDomiciliacion();

				$('#accordion_18').show();


			}

		});

		$('#radio_5').click(function() {
			if ($(this).is(':checked')) {
				$('#accordion_18').show();
			}
		});

		function borrarDomiciliacion() {
			$('#accordion_18').hide();
			$('#banco1').val('');
			$('#banco2').val('');
			$('#cardnumber1').val('');
			$('#cardnumber2').val('');
			$('.panelD2').css("opacity", 1);
			$('.panelD1').css("opacity", 1);
			$('#radio_7').prop('checked', false);
			$('#radio_8').prop('checked', false);
			cardNumberField1.removeClass('has-error');
			cardNumberField2.removeClass('has-error');
		}

		$('#radio_6').click(function() {
			if ($(this).is(':checked')) {
				borrarDomiciliacion();
			}
		});

		$('#radio_7').click(function() {
			if ($(this).is(':checked')) {
				$('.panelD1').css("opacity", 1);
				$('.panelD2').css("opacity", 0.2);
			}
		});

		$('#radio_8').click(function() {
			if ($(this).is(':checked')) {
				$('.panelD2').css("opacity", 1);
				$('.panelD1').css("opacity", 0.2);
			}
		});

		var btnConfirmar = $('#btnConfirmar');

		btnConfirmar.click(function(e) {
			guardarMetodoDePagoPorCotizacion();

		});

		function guardarMetodoDePagoPorCotizacion() {
			var errorGeneral = false;
			var bancoGeneral = '';
			var tarjetaGeneral = '';
			var domiciliado = 0;
			var tipotarjeta = 0;
			if ($('#radio_5').is(':checked')) {
				domiciliado = 1;
				if ($('#radio_7').is(':checked')) {
					var isCardValid = $.payform.validateCardNumber($('#cardnumber1').val());
					tarjetaGeneral = $('#cardnumber1').val();
					bancoGeneral = $('#banco1').val();
					tipotarjeta = 1;

					if (bancoGeneral == '') {
						errorGeneral = true;
						swal({
							 title: "Error!!",
							 text: "Debe completar el Banco emisor",
							 type: "error",
							 timer: 2000,
							 showConfirmButton: false
						});
					}

				} else {
					if ($('#radio_8').is(':checked')) {
						var isCardValid = $.payform.validateCardNumber($('#cardnumber2').val());
						tarjetaGeneral = $('#cardnumber2').val();
						bancoGeneral = $('#banco2').val();
						tipotarjeta = 2;

						if (bancoGeneral == '') {
							errorGeneral = true;
							swal({
								 title: "Error!!",
								 text: "Debe completar el Banco emisor",
								 type: "error",
								 timer: 2000,
								 showConfirmButton: false
							});
						}
					} else {
						errorGeneral = true;
						swal({
							 title: "Error!!",
							 text: "Debe seleccionar si la dopmiciliacion es mediante la tarjeta de crédito o Cuenta de Deposito",
							 type: "error",
							 timer: 2000,
							 showConfirmButton: false
						});


					}
				}


			} else {
				domiciliado = 0;
				isCardValid = true;
			}

			if (errorGeneral == false) {
				if (!isCardValid) {
					swal({
						 title: "Error!!",
						 text: "Número de tarjeta invalido",
						 type: "error",
						 timer: 2000,
						 showConfirmButton: false
					});
				} else {
					if ($('.radioMetodo').is(':checked')) {
						$.ajax({
							url: '../../ajax/ajax.php',
							type: 'POST',
							// Form data
							//datos del formulario
							data: {
								accion: 'guardarMetodoDePagoPorCotizacion',
								id: <?php echo $id; ?>,
								metodopago: $('input:radio[name=metodopago]:checked').val(),
								banco: bancoGeneral,
								afiliacion: tarjetaGeneral,
								precio: <?php echo $precio; ?>,
								domiciliado: domiciliado,
								tipotarjeta: tipotarjeta
							},
							//mientras enviamos el archivo
							beforeSend: function(){

							},
							//una vez finalizado correctamente
							success: function(data){

								if (data.error) {
									swal({
											title: "Respuesta",
											text: 'Se genero un error al guardar el metodo de pago',
											type: "error",
											timer: 1000,
											showConfirmButton: false
									});


								} else {
									swal({
											title: "Respuesta",
											text: 'Se guardo correctamente el metodo de pago',
											type: "success",
											timer: 2000,
											showConfirmButton: false
									});

									$(location).attr('href', data.url);

								}
							},
							//si ha ocurrido un error
							error: function(){
								swal({
										title: "Respuesta",
										text: 'Actualice la pagina',
										type: "error",
										timer: 2000,
										showConfirmButton: false
								});

							}
						});
					} else {
						swal({
								title: "Respuesta",
								text: 'Debe seleccionar un metodo de pago',
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
					}
				}
			}

		}


		$("#sign_in").submit(function(e){
			e.preventDefault();
		});



	});
</script>








</body>
<?php } ?>
</html>
