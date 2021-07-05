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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cobranza/');
//*** FIN  ****/

$fecha = date('Y-m-d');

if ($_SESSION['idroll_sahilices'] == 10) {
	$idusuario = $_SESSION['usuaid_sahilices'];
} else {
	$id = $_GET['id'];
}

$resultado 		= 	$serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);

$resTransferencia = $serviciosReferencias->traerTransferenciarecibosPorRecibo($id);

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Recibos de Pago",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$urlArchivo = '';

$idventa = mysql_result($resultado,0,'refventas');

$nrorecibo = mysql_result($resultado,0,'nrorecibo');

$estadoRecibo = mysql_result($resultado,0,'estadopago');

$monto = mysql_result($resultado,0,'montototal');

$idestadopago = mysql_result($resultado,0,'refestadopago');



/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Recibos";

$plural = "Documentaciones I";

$eliminar = "eliminarCotizaciones";

$insertar = "insertarCotizaciones";

$modificar = "modificarCotizaciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////

$resVenta = $serviciosReferencias->traerVentasPorIdCompleto($idventa);

$nropoliza = mysql_result($resVenta,0,'nropoliza');

$resCliente = $serviciosReferencias->traerClientesPorId(mysql_result($resVenta,0,'refclientes'));

$idcliente = mysql_result($resVenta,0,'refclientes');

$cliente = mysql_result($resCliente,0,'nombre').' '.mysql_result($resCliente,0,'apellidopaterno').' '.mysql_result($resCliente,0,'apellidomaterno');

$emailCliente = mysql_result($resCliente,0,'email');

$resProducto = $serviciosReferencias->traerProductosPorId(mysql_result($resVenta,0,'refproductos'));

$producto = mysql_result($resProducto,0,'producto');

$idproductoventa = mysql_result($resVenta,0,'refproductosaux');



$resProductoAux = $serviciosReferencias->traerProductosPorIdCompleta($idproductoventa);

$puedeCargarDocumentaciones = 0;
$puedeConcluir = 0;
// $pertenceaVRIM identifica tres factores importantes, (2)si es un producto de vrim de un paquete, carga inbursa y finaliza vrim, (1) si es un producto vrim individual, carga vrim y no inbursa, (0) sino es un producto vrim, carga y finaliza inbursa.
if (mysql_result($resVenta,0,'refproductosaux') == 0) {
	if (mysql_result($resProducto,0,'reftipoproductorama') == 12) {
		$pertenceaVRIM = 2;
	} else {
		$pertenceaVRIM = 0;
	}
} else {
	if (mysql_result($resProductoAux,0,'reftipoproductorama') == 12) {
		$pertenceaVRIM = 1;
	} else {
		$pertenceaVRIM = 0;
	}
}

if ($_SESSION['idroll_sahilices'] == 17) {
	switch ($pertenceaVRIM) {
		case 0:
			$idestadonuevo = 5;
			$puedeCargarDocumentaciones = 1;
			$puedeConcluir = 1;
		break;
		case 1:
			$idestadonuevo = 2;
			$puedeCargarDocumentaciones = 0;
			$puedeConcluir = 0;
		break;
		case 2:
			$idestadonuevo = 2;
			$puedeCargarDocumentaciones = 0;
			$puedeConcluir = 0;
		break;
	}
}


if ($_SESSION['idroll_sahilices'] == 18) {
	switch ($pertenceaVRIM) {
		case 0:
			$idestadonuevo = 2;
			$puedeCargarDocumentaciones = 0;
			$puedeConcluir = 0;
		break;
		case 1:
			$idestadonuevo = 2;
			$puedeCargarDocumentaciones = 0;
			$puedeConcluir = 0;
		break;
		case 2:
			$idestadonuevo = 2;
			$puedeCargarDocumentaciones = 0;
			$puedeConcluir = 0;
		break;
	}
}

if ( ($idestadopago == 5)) {
	$puedeConcluir = 0;
}

if ($_SESSION['idroll_sahilices'] == 16) {
	$idestadonuevo = $idestadopago;
	$puedeCargarDocumentaciones = 0;
	$puedeConcluir = 0;
}

if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 11)) {
	$idestadonuevo = $idestadopago;
	$puedeCargarDocumentaciones = 1;
	$puedeConcluir = 1;
}



$idCotizacion = mysql_result($resVenta,0,'refcotizaciones');

//die(var_dump($idCotizacion));

$resPagoRecibos = $serviciosReferencias->traerPagosPorRecibo($id);

$noPuedeSubirComprobante = 0;

if (mysql_num_rows($resTransferencia)>0) {
	$noPuedeSubirComprobante = 1;

	if (mysql_result($resTransferencia,0,'archivo') != '') {
		$archivoTransferencia = '../../archivos/transferencias/'.mysql_result($resTransferencia,0,'reftransferencias').'/'.mysql_result($resTransferencia,0,'archivo');
		$typeTransferencia = mysql_result($resTransferencia,0,'type');
	} else {
		$archivoTransferencia = '';
		$typeTransferencia = '';
	}

}

// para el pago por venta online
if (mysql_num_rows($resPagoRecibos) > 0) {


	if (mysql_result($resultado,0,'refformapago') == 1) {
		$resComercio = $serviciosComercio->traerComercioinicioPorOrderId($id);
		if (mysql_num_rows($resComercio)>0) {
			$urlArchivo = '../../reportes/rptFacturaPagoRecibosOnline.php?token='.mysql_result($resComercio,0,'token');
			$token = mysql_result($resComercio,0,'token');
			require ('../../reportes/rptFacturaPagoReciboOnlineManual.php');
		} else {
			$urlArchivo = '';
		}
	} else {
		if (mysql_result($resultado,0,'refformapago') == 2) {
			$urlArchivo = '../../archivos/comprobantespagorecibos/'.$id.'/'.mysql_result($resPagoRecibos,0,'archivos');
		}
	}


	$datosDelPago = mysql_result($resPagoRecibos,0,'destino').' - Monto: '.mysql_result($resPagoRecibos,0,'monto');
	$idDelPago = mysql_result($resPagoRecibos,0,0);

	$selectPago = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrefdatopago" style="display:block">
									<label for="avisoinbursa" class="control-label" style="text-align:left">Aplicar Comprobante de Pago </label>
									<div class="form-group input-group col-md-12">
									<div class="form-line"><select class="form-control" name="refdatopago" id="refdatopago"><option value="'.mysql_result($resPagoRecibos,0,'idpago').'">'.$datosDelPago.'</option></select></div></div></div>';
} else {
	// para el pago por cobranza
	$resPagoCotizacion = $serviciosReferencias->traerPagosPorCotizacion($idCotizacion);
	$urlArchivo = '';
	$selectPago = '';
	if (mysql_num_rows($resPagoCotizacion) > 0) {
		if (mysql_result($resPagoCotizacion,0,'refcuentasbancarias') == 0) {
			$resComercio = $serviciosComercio->traerComercioinicioPorOrderId($idCotizacion);
			if (mysql_num_rows($resComercio)>0) {
				$urlArchivo = '../../reportes/rptFacturaPagoOnline.php?token='.mysql_result($resComercio,0,'token');
				$token = mysql_result($resComercio,0,'token');
				require ('../../reportes/rptFacturaPagoOnlineManual.php');
			} else {
				$urlArchivo = '';
			}



		}
		if (mysql_result($resPagoCotizacion,0,'refcuentasbancarias') == 1) {
			$urlArchivo = '../../archivos/comprobantespago/'.$idCotizacion.'/'.mysql_result($resPagoCotizacion,0,'archivos');


		}

		$datosDelPago = mysql_result($resPagoCotizacion,0,'destino').' - Monto: '.mysql_result($resPagoCotizacion,0,'monto');
		$idDelPago = mysql_result($resPagoCotizacion,0,0);

		$selectPago = '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrefdatopago" style="display:block">
										<label for="avisoinbursa" class="control-label" style="text-align:left">Aplicar Comprobante de Pago </label>
										<div class="form-group input-group col-md-12">
										<div class="form-line"><select class="form-control" name="refdatopago" id="refdatopago"><option value="'.mysql_result($resPagoCotizacion,0,'idpago').'">'.$datosDelPago.'</option></select></div></div></div>';
	} else {
		$selectPago = "<input type='hidden' name='refdatopago' id='refdatopago' value='0'>";
	}
}





$pathPagos  = '../../archivos/pagos/'.$id;

if (!file_exists($pathPagos)) {
	mkdir($pathPagos, 0777);
}


$path  = '../../archivos/cobros/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}

if (isset($_GET['iddocumentacion'])) {
	$iddocumentacion = $_GET['iddocumentacion'];
} else {
	switch ($_SESSION['idroll_sahilices']) {
		case 16:
			$iddocumentacion = 39;
		break;
		case 17:
			$iddocumentacion = 40;
		break;
		case 18:
			$iddocumentacion = 40;
		break;
		default:
			$iddocumentacion = 38;
		break;
	}
}

//////////////////////////////////////////////  FIN de los opciones //////////////////////////


if (($iddocumentacion == 35) || ($iddocumentacion == 147) || ($iddocumentacion == 148) || ($iddocumentacion == 153) || ($iddocumentacion == 154)) {
	$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($idventa, $iddocumentacion);
} else {
	$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id, $iddocumentacion);
}


$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

if (mysql_num_rows($resDocumentacionAsesor) > 0) {
	$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));

	$iddocumentacionasociado = mysql_result($resDocumentacionAsesor,0,'iddocumentacionventa');

	$estadoDocumentacion = mysql_result($resDocumentacionAsesor,0,'estadodocumentacion');

	$color = mysql_result($resDocumentacionAsesor,0,'color');

	$span = '';
	switch (mysql_result($resDocumentacionAsesor,0,'estadodocumentacion')) {
		case 1:
			$span = 'text-info glyphicon glyphicon-plus-sign';
		break;
		case 2:
			$span = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 3:
			$span = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 4:
			$span = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 5:
			$span = 'text-success glyphicon glyphicon-remove-sign';
		break;
	}
} else {
	$cadRefEstados = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

	$iddocumentacionasociado = 0;

	$estadoDocumentacion = 'Falta Cargar';

	$color = 'blue';

	$span = 'text-info glyphicon glyphicon-plus-sign';
}

switch ($iddocumentacion) {
	case 35:
		// code...
		$dato = mysql_result($resultadoV,0,'nropoliza');

		$input = '<input type="text" name="nropoliza" maxlength="13" id="nropoliza" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de Poliza';
		$campo = 'nropoliza';
	break;
	case 38:
		// code...
		$dato = mysql_result($resultado,0,'nrorecibo');

		$input = '<input type="text" name="nrorecibo" maxlength="20" id="nrorecibo" class="form-control" value="'.$dato.'"/> ';
		$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
		$leyenda = 'Cargue el Nro de Recibo';
		$campo = 'nrorecibo';
	break;


	default:
		// code...
		$input = '';
		$boton = '';
		$leyenda = '';
		$campo = '';
	break;
}

switch ($_SESSION['idroll_sahilices']) {
	case 16:

		$resDocumentacionReciboExistente = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id, 39);

		if (mysql_num_rows($resDocumentacionReciboExistente)>0) {
			$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '39,40');
			$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '39,40');
		} else {
			$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '39,40');
			$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '39,40');
		}
		$puedeBorrar = 0;
	break;
	case 17:
		$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '38,40,41');
		$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '38,40,41');
		$resDocumentacionReciboExistente = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id, 39);
		$puedeBorrar = 0;

		IF ($iddocumentacion == 38) {
			$puedeCargarDocumentaciones = 0;
		}
	break;
	case 18:
		$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '38,40,41');
		$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '38,40,41');
		$resDocumentacionReciboExistente = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id, 39);
		$puedeBorrar = 0;

		IF ($iddocumentacion == 38) {
			$puedeCargarDocumentaciones = 0;
		}
	break;
	default:

		$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '38,39,40,41');
		$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '38,39,40,41');

		$resDocumentacionReciboExistente = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id, 39);
		$puedeBorrar = 1;
	break;
}



/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resResultado = $serviciosReferencias->traerPeriodicidadventaspagosPorCobro($id);

$resResultadoAux = $serviciosReferencias->traerPeriodicidadventaspagosPorCobro($id);

$insertar = "insertarPeriodicidadventaspagos";

$modificar = "modificarPeriodicidadventaspagos";

$tabla 			= "dbperiodicidadventaspagos";

$lblCambio	 	= array('refperiodicidadventasdetalle','nrorecibo','fechapago','nrofactura','avisoinbursa','fechapagoreal');
$lblreemplazo	= array('Poliza','Folio de Pago Asesores Crea','Fecha Pago','Nro Factura','Notifacacion a Inbursa','Fecha Pago Real');

//insertar
$resVar	= $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);
$cadRef = $serviciosFunciones->devolverSelectBox($resVar,array(1,2),' ');

$cadRef2 = "<option value='0'>No</option><option value='1'>Si</option>";

$refdescripcion = array(0=>$cadRef,1=>$cadRef2);
$refCampo 	=  array('refperiodicidadventasdetalle','avisoinbursa');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo('insertarPeriodicidadventaspagos' ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

$montoPagado = 0;

$apareceaviso = 1;
$idPagoDelRecibo = 0;

while ($rowPP = mysql_fetch_array($resResultado)) {
	$montoPagado += $rowPP['monto'];
	$apareceaviso = 0;
}




//////////////////////////////////////////////  FIN de los opciones //////////////////////////



if (mysql_num_rows($resDocumentacionReciboExistente)>0) {
	$archivos = "../../archivos/cobros/".mysql_result($resDocumentacionReciboExistente,0,'refperiodicidadventas').'/'.mysql_result($resDocumentacionReciboExistente,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistente,0,'archivo');

	$recibo = "<div class='alert bg-pink'><p>Descargue el Comprobante de Pago!, haciendo click <a style='color:black;' href='"."../../archivos/cobros/".mysql_result($resDocumentacionReciboExistente,0,'refperiodicidadventas').'/'.mysql_result($resDocumentacionReciboExistente,0,'carpeta').'/'.mysql_result($resDocumentacionReciboExistente,0,'archivo')."' target='_blank'>AQUI</a></div>";

	$lblEstadoComprobante = "(".mysql_result($resDocumentacionReciboExistente,0,'estadodocumentacion').')';
} else {
	$recibo = "<div class='alert alert-warning'><p><b>Importante! </b> Todavia no se cargo el Comprobante de Pago</div>";
	$archivos = '';
	$lblEstadoComprobante = "(FALTA CARGAR)";
}


/**** para discriminar los productos *****///
//die(var_dump($idCotizacion));
$idCotizacion = mysql_result($resVenta,0,'refcotizaciones');
$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($idCotizacion);

$resPaquete = $serviciosReferencias->traerPaquetedetallesPorPaquete(mysql_result($resCotizacion,0,'refproductos'));

$formularioAr = array();

$lblProducto = '';

$pertenceaVRIM = 0;

//die(var_dump($idCotizacion));
if (mysql_num_rows($resPaquete) > 0) {
	$lblProducto = '<li class="list-group-item">'.mysql_result($resCotizacion,0,'producto').' $ '.mysql_result($resCotizacion,0,'primatotal').'</li>';

	if ($_SESSION['idroll_sahilices'] != 16) {
		$resPV = $serviciosReferencias->traerVentasPorCotizacionPaquetesUnico($idCotizacion);

		while ($rowPV = mysql_fetch_array($resPV)) {
			if ($idproductoventa == $rowPV['idproducto']) {
				$lblProducto .= ' <li class="list-group-item">'.'<b>'.$rowPV['producto'].' $ '.$rowPV['primatotal'].' (Aplicar)'.'</b>'.'</li>';
			} else {
				$lblProducto .= ' <li class="list-group-item"> '.$rowPV['producto'].' $ '.$rowPV['primatotal'].'</li>';
			}

		}
	}
} else {

	$lblProducto = '<li class="list-group-item">'.mysql_result($resCotizacion,0,'producto').' $ '.mysql_result($resCotizacion,0,'primatotal').'</li>';
}


// cuando es un paquete, inbursa carga factura y envia a vrim para concluir el proceso.


////*** fin discriminar los productos *****///

if (($_SESSION['idroll_sahilices'] == 7) && ($iddocumentacion == 39)) {
	$puedeCargarDocumentaciones = 1;
}


//die(var_dump($archivoTransferencia));

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
		.pdfobject-container { height: 40rem; border: 1rem solid rgba(0,0,0,.1); }

		  .thumbnail2 {
		    display: block;
		    padding: 4px;
		    margin-bottom: 20px;
		    line-height: 1.42857143;
		    background-color: #fff;
		    border: 1px solid #ddd;
		    border-radius: 4px;
		    -webkit-transition: border .2s ease-in-out;
		    -o-transition: border .2s ease-in-out;
		    transition: border .2s ease-in-out;
			 text-align: center;
		}
		.progress {
			background-color: #1b2646;
		}

		.btnDocumentacion {
			cursor: pointer;
		}

		.btnCursor {
			cursor: pointer;
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

<section class="content" style="margin-top:-115px;">

	<div class="container-fluid">
		<div class="row clearfix subirImagen">



			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<ul class="list-group">
						<li class="list-group-item active">INFORMACION DEL RECIBO</li>
						<li class="list-group-item"><?php echo 'No de Poliza: <b>'.strtoupper( $nropoliza).'</b>'; ?></li>
						<li class="list-group-item"><?php echo 'No de Recibo: <b>'.strtoupper($nrorecibo).'</b>'; ?></li>
						<li class="list-group-item"><?php echo 'Estado: <b>'.strtoupper($estadoRecibo).'</b>'; ?></li>
						<li class="list-group-item"><?php echo 'Monto: <b>$ '.number_format($monto,2,'.',',').'</b>'; ?></li>
						<?php echo $lblProducto; ?>

						<li class="list-group-item" style="height:24px;"></li>

					</ul>

				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<ul class="list-group">
						<li class="list-group-item active">COMPROBANTE DE PAGO <?php echo $lblEstadoComprobante; ?></li>
						<li><div id="example2"></div></li>
					</ul>
				</div>

			</div>

			<div class="row">
				<?php
				$i = 0;
				$completos = 0;
				while ($row = mysql_fetch_array($resDocumentaciones)) {
					$i += 1;
					if ($row['idestadodocumentacion'] == 5) {
						$completos += 1;
					} else {
						if (($archivoTransferencia != '') && ($row['iddocumentacion'] == 39)) {
							$completos += 1;
						}
					}
				?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<?php if (($archivoTransferencia != '') && ($row['iddocumentacion'] == 39)) { ?>
							<div class="info-box-3 bg-green btnCursor hover-zoom-effect btnDocumentacion39" id="39">
								<div class="icon">
									<i class="material-icons">unarchive</i>
								</div>
								<div class="content">
									<div class="text"><?php echo $row['documentacion']; ?> (seleccionar)</div>
									<div class="number">Aceptada</div>
								</div>
							</div>
						<?php } else { ?>
							<div class="info-box-3 bg-<?php echo $row['color']; ?> btnCursor hover-zoom-effect btnDocumentacion<?php echo $row['iddocumentacion']; ?>" id="<?php echo $row['iddocumentacion']; ?>">
								<div class="icon">
									<i class="material-icons">unarchive</i>
								</div>
								<div class="content">
									<div class="text"><?php echo $row['documentacion']; ?> (seleccionar)</div>
									<div class="number"><?php echo $row['estadodocumentacion']; ?></div>
								</div>
							</div>
						<?php } ?>


					</div>
				<?php }  ?>

				<?php if (($i == $completos) && ($puedeConcluir == 1) && (($_SESSION['idroll_sahilices'] == 17) || ($_SESSION['idroll_sahilices'] == 18))) { ?>

				<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
					<div class="info-box-3 bg-teal hover-zoom-effect btnCursor concluirProceso">
						<div class="icon">
							<i class="material-icons">done_all</i>
						</div>
						<div class="content">
							<div class="text">DAR CLICK PARA CONCLUIR</div>
							<div class="number" style="font-size:1.2em !important;">CONCLUIR PROCESO</div>
						</div>
					</div>
				</div>
				<?php } ?>

			</div>


			<?php if (($iddocumentacion == 39) && ($_SESSION['idroll_sahilices'] != 16)) { ?>
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header bg-blue">

						</div>
						<div class="body table-responsive">

							<div class="row">
								<div class="col-xs-3">
									<div class="alert alert-info">
										<p><?php echo '<b>Cliente: </b>'.$cliente; ?></p>
									</div>
								</div>
								<div class="col-xs-3">
									<div class="alert alert-success">
										<p><?php echo '<b>No Recibo: </b>'.$nrorecibo; ?></p>
									</div>
								</div>
								<div class="col-xs-3">
									<div class="alert alert-success">
										<p><?php echo '<b>Poliza: </b>'.$nropoliza; ?></p>
									</div>
								</div>

							<?php if ($apareceaviso == 1) { ?>
								<div class="col-xs-3">
									<div class="alert bg-blue">
										<p><?php echo '<b>Monto: </b>'.$monto; ?></p>
									</div>
								</div>
							<?php } else { ?>
								<?php if ($monto < $montoPagado) { ?>
									<div class="col-xs-3">
										<div class="alert bg-red">
											<p><?php echo '<b>Monto: </b>'.$monto; ?> ** Se pago demás <?php echo '<b>'.($montoPagado - $monto)."</b>"; ?></p>
										</div>
									</div>
								<?php } else { ?>
									<?php if ($monto > $montoPagado) { ?>
										<div class="col-xs-3">
											<div class="alert bg-red">
												<p><?php echo '<b>Monto: </b>'.$monto; ?> ** Se pago de menos <?php echo '<b>'.($monto - $montoPagado)."</b>"; ?></p>
											</div>
										</div>
									<?php } else { ?>
										<div class="col-xs-3">
											<div class="alert bg-blue">
												<p><?php echo '<b>Monto: </b>'.$monto; ?></p>
											</div>
										</div>
									<?php }} ?>
							<?php } ?>

								<?php if ($urlArchivo != '') { ?>
								<div class="col-xs-3">
									<div class="alert bg-orange">
										<p>Comprobante de pago cargado por el cliente: <b><a style="color:white;" target="_blank" href="<?php echo $urlArchivo; ?>">Descargar</a></b></p>
									</div>
								</div>
								<?php } ?>
							</div>

							<form class="forrmm" role="form" id="sign_in">

								<?php if ($puedeBorrar == 1) { ?>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 frmContfechapagorecibo" >
										<label for="fechapagorecibo" class="control-label" style="text-align:left">Fecha Pago del Recibo</label>
										<div class="form-group input-group">
											<span class="input-group-addon">
												<i class="material-icons">date_range</i>
											</span>
										   <div class="form-line">
												<input readonly="readonly" style="width:200px;" type="text" class="datepicker form-control" id="fechapagorecibo" name="fechapagorecibo" />


										   </div>
										</div>

									</div>
									<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 frmContguardar" >
										<button type="button" class="btn bg-blue waves-effect btnGuardarFechaPago">
											<i class="material-icons">save</i>
											<span>GUARDAR</span>
										</button>
									</div>
								</div>
								<?php } ?>

								<div class="row">
									<?php if (($monto > $montoPagado)) { ?>
										<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
											<i class="material-icons">add</i>
											<span>CARGAR PAGO</span>
										</button>
									<?php } ?>
								</div>

								<div class="row">
									<table id="example" class="display table  dataTable" style="width: 100%;" role="grid" aria-describedby="example_info">
										<thead>
											<th>Monto</th>
											<th>Folio De Pago Asesores Crea</th>
											<th>Fecha Pago</th>

											<th>Acciones</th>
										</thead>
										<tbody>
									<?php

									while ($rowPagos = mysql_fetch_array($resResultadoAux)) {
									?>
									<tr>
										<td><?php echo $rowPagos['monto']; ?></td>
										<td><?php echo $rowPagos['nrorecibo']; ?></td>
										<td><?php echo $rowPagos['fechapago']; ?></td>

										<td>
											<button type="button" class="btn bg-orange waves-effect btnModificarPago" id="<?php echo $rowPagos['idperiodicidadventapago']; ?>">
					 							MODIFICAR
				 							</button>

										</td>
									</tr>
									<?php



									}
									?>
										</tbody>
									</table>
								</div>

								<div class="modal-footer">
									<?php
								if (($_SESSION['idroll_sahilices'] == 7) && ($iddocumentacion == 39) && ($estadoDocumentacion == 'Aceptada')) {
									?>
									<button type="button" class="btn bg-amber waves-effect btnAvisar" id="<?php echo $id; ?>">
										AVISAR PAGO A INBURSA
									</button>
								<?php } ?>
								<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
									<button type="button" class="btn bg-amber waves-effect btnAvisar" id="<?php echo $id; ?>">
										AVISAR PAGO A INBURSA
									</button>
								<?php } ?>

									<button type="button" class="btn bg-defualt waves-effect btnVolver">
			 							VOLVER
		 							</button>
			               </div>

							</form>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>

		<?php if ($_SESSION['idroll_sahilices'] == 16) { ?>
			<div class="row">

				<?php
				$mitad = 0;
				if (((mysql_num_rows($resDocumentacionReciboExistente)>0) && ($iddocumentacion == 39) && ((mysql_result($resDocumentacionReciboExistente,0,'refestadodocumentaciones') != 5))) || ((mysql_num_rows($resDocumentacionReciboExistente)<=0) && ($iddocumentacion == 39))) {
					$mitad = 1;
				?>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
						<div class="card">
							<div class="header bg-blue">
								<h2>
									<?php echo mysql_result($resDocumentacion,0,'documentacion'); ?> (Cargue Aqui)
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
									</li>
								</ul>
							</div>
							<div class="body">
								<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
									<div class="dz-message">
										<div class="drag-icon-cph">
											<i class="material-icons">touch_app</i>
										</div>
										<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
									</div>
									<div class="fallback">
										<input name="file" type="file" id="archivos" />
										<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $id; ?>" />
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php }  ?>

				<?php if ($mitad == 1) { ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<?php } else { ?>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<?php } ?>

					<div class="card ">
						<div class="header bg-blue">
							<h2>
								AQUI TIENE SU <?php echo mysql_result($resDocumentacion,0,'documentacion'); ?> PARA DESCARGAR
							</h2>
						</div>
						<div class="body table-responsive">

							<?php if ($puedeBorrar == 1) { ?>
							<div class="row">
								<button type="button" class="btn bg-red waves-effect btnEliminar">
									<i class="material-icons">remove</i>
									<span>ELIMINAR</span>
								</button>
							</div>
						<?php } ?>
							<div class="row">
								<a href="javascript:void(0);" class="thumbnail timagen1">
									<img class="img-responsive">
								</a>
								<div id="example1"></div>
							</div>


						</div>
					</div>
				</div>

			</div> <!-- fin del card -->

		<?php } else { ?>
			<?php if ($noPuedeSubirComprobante == 0) { ?>
			<div class="row">
			<?php if ($puedeCargarDocumentaciones == 1) { ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								<?php echo mysql_result($resDocumentacion,0,'documentacion'); ?> (Cargue Aqui)
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
								</li>
							</ul>
						</div>
						<div class="body">
							<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
								<div class="dz-message">
									<div class="drag-icon-cph">
										<i class="material-icons">touch_app</i>
									</div>
									<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
								</div>
								<div class="fallback">
									<input name="file" type="file" id="archivos" />
									<input type="hidden" id="idasociado" name="idasociado" value="<?php echo $id; ?>" />
								</div>
							</form>
						</div>
					</div>
				</div>
			<?php } ?>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								<?php echo mysql_result($resDocumentacion,0,'documentacion'); ?>
							</h2>
						</div>
						<div class="body table-responsive">

							<?php if ($puedeBorrar == 1) { ?>
							<div class="row">
								<button type="button" class="btn bg-red waves-effect btnEliminar">
									<i class="material-icons">remove</i>
									<span>ELIMINAR</span>
								</button>
							</div>
						<?php } ?>
							<div class="row">
								<a href="javascript:void(0);" class="thumbnail timagen1">
									<img class="img-responsive">
								</a>
								<div id="example1"></div>
							</div>
							<div class="row">
								<div class="alert bg-<?php echo $color; ?>">
									<h4>
										Estado: <b><?php echo $estadoDocumentacion; ?></b>
									</h4>
								</div>
								<?php
								if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 11)) {
								?>
								<div class="col-xs-6 col-md-6" style="display:block">
									<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
									<div class="input-group col-md-12">
										<select class="form-control show-tick" id="refestados" name="refestados">
											<?php echo $cadRefEstados; ?>
										</select>
									</div>

									<button type="button" class="btn btn-primary guardarEstado" style="margin-left:0px;">Guardar Estado</button>

								</div>
								<?php } ?>

							</div>

						</div>
					</div>
				</div>
			</div> <!-- fin del card -->
			<?php } ?>
		<?php } ?>





		</div>
	</div>
</section>



<!-- NUEVO -->
	<form class="formulario frmNuevo" role="form" id="sign_in">
	   <div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
	       <div class="modal-dialog modal-lg" role="document">
	           <div class="modal-content">
	               <div class="modal-header">
	                   <h4 class="modal-title" id="largeModalLabel">CARGAR PAGO</h4>
	               </div>
	               <div class="modal-body">
							<div class="row">
								<?php echo $frmUnidadNegocios; ?>
								<?php echo $selectPago; ?>
							</div>

	               </div>
	               <div class="modal-footer">
	                   <button type="submit" class="btn btn-primary waves-effect nuevo">GUARDAR</button>
	                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
	               </div>
	           </div>
	       </div>
	   </div>
		<input type="hidden" id="accion" name="accion" value="<?php echo $insertar; ?>"/>
	</form>

	<!-- MODIFICAR -->
		<form class="formulario frmModificar" role="form" id="sign_in">
		   <div class="modal fade" id="lgmModificar" tabindex="-1" role="dialog">
		       <div class="modal-dialog modal-lg" role="document">
		           <div class="modal-content">
		               <div class="modal-header">
		                   <h4 class="modal-title" id="largeModalLabel">MODIFICAR PAGO</h4>
		               </div>
		               <div class="modal-body">
								<div class="row frmAjaxModificar">

								</div>
		               </div>
		               <div class="modal-footer">
		                   <button type="submit" class="btn btn-warning waves-effect modificar">MODIFICAR</button>
		                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
		               </div>
		           </div>
		       </div>
		   </div>
			<input type="hidden" id="accion" name="accion" value="modificarPeriodicidadventaspagos"/>
		</form>

<!-- ELIMINAR -->
	<form class="formulario" role="form" id="sign_in">
		<div class="modal fade" id="lgmEliminar" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
						<div class="modal-header">
							 <h4 class="modal-title" id="largeModalLabel">ELIMINAR <?php echo strtoupper($singular); ?></h4>
						</div>
						<div class="modal-body">
									 <p>¿Esta seguro que desea eliminar el registro?</p>
									 <small>* Si este registro esta relacionado con algun otro dato no se podría eliminar.</small>
						</div>
						<div class="modal-footer">
							 <button type="button" class="btn btn-danger waves-effect eliminar" data-dismiss="modal">ELIMINAR</button>
							 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>
				  </div>
			 </div>
		</div>
	</form>


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

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<!-- JQuery Steps Plugin Js -->
<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script>

	$(document).ready(function(){

		$('.frmContnrofactura').hide();
		$('.frmContavisoinbursa').hide();

		$('#monto').number( true, 2 ,'.','');


		<?php if ($apareceaviso == 1) { ?>
		$('#avisoinbursa').prop('disabled',true);
		<?php } ?>
		$('.btnAvisar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'avisarInbursa',
					idventa: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se genero la alerta correctamente', "success");

					} else {
						swal("Error!", data.leyenda, "warning");

						$("#load").html('');
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		});

		$('#fechapago').val('<?php echo date('Y-m-d'); ?>');

		$('.frmContfechacrea').hide();
		$('.frmContfechamodi').hide();
		$('.frmContusuariocrea').hide();
		$('.frmContusuariomodi').hide();

		<?php if ($_SESSION['idroll_sahilices'] == 16) { ?>
			$('.frmContrefperiodicidadventasdetalle').hide();
			$('.frmContnrofactura').hide();

		<?php } ?>

		$('#fechacrea').val('<?php echo date('Y-m-d'); ?>');
		$('#fechamodi').val('<?php echo date('Y-m-d'); ?>');
		$('#usuariocrea').val('<?php echo 'marcos'; ?>');
		$('#usuariomodi').val('<?php echo 'marcos'; ?>');

		$('#fechapago').pickadate({
			format: 'yyyy-mm-dd',
			labelMonthNext: 'Siguiente mes',
			labelMonthPrev: 'Previo mes',
			labelMonthSelect: 'Selecciona el mes del año',
			labelYearSelect: 'Selecciona el año',
			selectMonths: true,
			selectYears: 100,
			today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		});

		$('#fechapagoreal').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD HH:mm',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : new Date()
		});

		<?php if ($_SESSION['idroll_sahilices'] != 16) { ?>

		<?php if (($puedeConcluir == 1)) { ?>
		$('.concluirProceso').click(function() {
			concluirProceso();
		});

		function concluirProceso() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'concluirProceso',
					idrecibo: <?php echo $id; ?>,
					idestado: <?php echo $idestadonuevo; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.concluirProceso').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Ya concluimos el proceso correctamente', "success");
						<?php if (($idestadonuevo == 5)) { ?>
						enviarFacturaAlCliente();
						<?php } ?>

					} else {
						swal("Error!", data.leyenda, "warning");
						$('.concluirProceso').show();


					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}

		<?php } ?>



		function enviarFacturaAlCliente() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'enviarFacturaAlCliente',
					email: '<?php echo $emailCliente; ?>',
					idcliente: <?php echo $idcliente; ?>,
					nropoliza: '<?php echo $nropoliza; ?>',
					url: "cobranza/subirdocumentacioni.php?id=<?php echo $id; ?>&iddocumentacion=40",
					idpago: <?php echo $id; ?>,
					idventa: <?php echo $idventa; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.enviarFactura').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se envio la información correctamente al cliente', "success");
						$('.enviarFactura').show();

					} else {
						swal("Error!", data.leyenda, "warning");

						$('.enviarFactura').show();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}

		<?php } ?>

		$('#fechapago').val('<?php echo date('Y-m-d'); ?>');
		<?php if ($_SESSION['idroll_sahilices'] == 16) { ?>
			$('.frmContrefperiodicidadventasdetalle').hide();
			$('.frmContnrofactura').hide();

		<?php } ?>

		$('#fechacrea').val('<?php echo date('Y-m-d'); ?>');
		$('#fechamodi').val('<?php echo date('Y-m-d'); ?>');
		$('#usuariocrea').val('<?php echo 'marcos'; ?>');
		$('#usuariomodi').val('<?php echo 'marcos'; ?>');

		$('#fechapago').pickadate({
			format: 'yyyy-mm-dd',
			labelMonthNext: 'Siguiente mes',
			labelMonthPrev: 'Previo mes',
			labelMonthSelect: 'Selecciona el mes del año',
			labelYearSelect: 'Selecciona el año',
			selectMonths: true,
			selectYears: 100,
			today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		});


		$('.btnModificar').click(function() {
			modificarVentaUnicaDocumentacion('<?php echo $campo; ?>',$('#<?php echo $campo; ?>').val());
		});

		$('.btnGuardarFechaPago').click(function() {
			modificarVentaUnicaDocumentacion('fechapago',$('#fechapagorecibo').val());
		});

		function modificarVentaUnicaDocumentacion(campo,valor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarVentaUnicaDocumentacion',
					idventa: <?php echo $id; ?>,
					campo: campo,
					valor: valor
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se guardo correctamente el ' + campo, "success");

					} else {
						swal("Error!", data.leyenda, "warning");

						$("#load").html('');
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}


		function traerVentaUnicaDocumentacion(campo,contenedor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'traerVentaUnicaDocumentacion',
					id: <?php echo $id; ?>,
					campo: campo
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						$('#'+contenedor).val(data.valor);

					} else {
						$('#'+contenedor).val('');
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}

		traerVentaUnicaDocumentacion('fechapago','fechapagorecibo');

		$('#fechapagorecibo').pickadate({
			format: 'yyyy-mm-dd',
			labelMonthNext: 'Siguiente mes',
			labelMonthPrev: 'Previo mes',
			labelMonthSelect: 'Selecciona el mes del año',
			labelYearSelect: 'Selecciona el año',
			selectMonths: true,
			selectYears: 100,
			today: 'Hoy',
			clear: 'Borrar',
			close: 'Cerrar',
			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
		});

		<?php while ($rowD = mysql_fetch_array($resDocumentacionesAux)) { ?>
		$('.btnDocumentacion<?php echo $rowD['iddocumentacion']; ?>').click(function() {
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&iddocumentacion=<?php echo $rowD['iddocumentacion']; ?>" ;
			$(location).attr('href',url);
		});
		<?php } ?>


		$('.btnVolver').click(function() {
			url = "index.php";
			$(location).attr('href',url);
		});


		$('.guardarEstado').click(function() {
			modificarEstadoDocumentacionVentas($('#refestados').val());
		});

		function modificarEstadoDocumentacionVentas(idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionVentas',
					iddocumentacionventa: <?php echo $iddocumentacionasociado; ?>,
					idestado: idestado
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.guardarEstado').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se modifico correctamente el estado de la documentación <?php echo $campo; ?>', "success");
						$('.guardarEstado').show();
						location.reload();
					} else {
						swal("Error!", data.leyenda, "warning");

						$("#load").html('');
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}

		PDFObject.embed('<?php echo $archivos; ?>', "#example2");

		function traerImagen(contenedorpdf, contenedor) {
			<?php
				if (($iddocumentacion == 39) && ($noPuedeSubirComprobante == 1)) {
			?>
			var archivoT = '<?php echo $archivoTransferencia; ?>';
         var typeT = '<?php echo $typeTransferencia; ?>';

         if (archivoT != '') {
            var cadena = typeT.toLowerCase();

				PDFObject.embed('<?php echo $archivoTransferencia; ?>', "#example2");
            if (cadena.indexOf("pdf") > -1) {
               PDFObject.embed(archivoT, "#"+contenedorpdf);
               $('#'+contenedorpdf).show();
               $("."+contenedor).hide();

            } else {
               $("." + contenedor + " img").attr("src",archivoT);
               $("."+contenedor).show();
               $('#'+contenedorpdf).hide();
            }
         }
			<?php } else { ?>
			$.ajax({
				data:  {idventa: <?php echo $id; ?>,
						iddocumentacion: <?php echo $iddocumentacion; ?>,
						accion: 'traerDocumentacionPorVentaDocumentacion'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("." + contenedor + " img").attr("src",'');
				},
				success:  function (response) {
					var cadena = response.datos.type.toLowerCase();

					if (response.datos.type != '') {
						if (cadena.indexOf("pdf") > -1) {
							PDFObject.embed(response.datos.imagen, "#"+contenedorpdf);
							$('#'+contenedorpdf).show();
							$("."+contenedor).hide();

						} else {
							$("." + contenedor + " img").attr("src",response.datos.imagen);
							$("."+contenedor).show();
							$('#'+contenedorpdf).hide();
						}
					}

					if (response.error) {

						$('.btnEliminar').hide();
						$('.guardarEstado').hide();
					} else {

						$('.btnEliminar').show();
						$('.guardarEstado').show();
					}



				}
			});
			<?php } ?>

		}

		traerImagen('example1','timagen1');

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 30,
			acceptedFiles: ".pdf,.xml,.png,.jpg",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
					formData.append("idasociado", '<?php echo $id; ?>');
					formData.append("iddocumentacion", '<?php echo $iddocumentacion; ?>');
				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1');

					swal("Correcto!", resp.replace("1", ""), "success");

					location.reload();
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};


		<?php if (($puedeCargarDocumentaciones == 1) && ($noPuedeSubirComprobante == 0)) { ?>

		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idasociado: <?php echo $id; ?>,
				 iddocumentacion: <?php echo $iddocumentacion; ?>
			},
			url: 'subir.php'
		});

		<?php } ?>



		function setButtonWavesEffect(event) {
			$(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
			$(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
		}

		$('#wizard_horizontal').steps({
			headerTag: 'h2',
			bodyTag: 'section',
			transitionEffect: 'slideLeft',
			onInit: function (event, currentIndex) {
				setButtonWavesEffect(event);
			}
		});


		$('.eliminar').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarDocumentacionVenta',idventa: <?php echo $id; ?>, iddocumentacion: <?php echo $iddocumentacion; ?>},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnEliminar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", data.leyenda , "success");
						traerImagen('example1','timagen1');

					} else {
						swal("Error!", data.leyenda, "warning");

						$('.btnEliminar').show();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		});


		$(".body").on("click",'.btnEliminar', function(){
			$('#lgmEliminar').modal();

		});


		$("#example").on("click",'.btnModificarPago', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar


		function frmAjaxModificar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'frmAjaxModificar',tabla: '<?php echo $tabla; ?>', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxModificar').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxModificar').html(data);
						$('.frmAjaxModificar .frmContnrofactura').hide();
						$('.frmAjaxModificar .frmContusuariocrea').hide();
						$('.frmAjaxModificar .frmContusuariomodi').hide();
						$('.frmAjaxModificar .frmContfechacrea').hide();
						$('.frmAjaxModificar .frmContfechamodi').hide();
						$('.frmAjaxModificar .frmContfechamodi').hide();
						$('.frmAjaxModificar .frmContavisoinbursa').hide();

						$('.frmAjaxModificar #monto').number( true, 2 ,'.','');

						$('.frmAjaxModificar #fechapago').pickadate({
							format: 'yyyy-mm-dd',
							labelMonthNext: 'Siguiente mes',
							labelMonthPrev: 'Previo mes',
							labelMonthSelect: 'Selecciona el mes del año',
							labelYearSelect: 'Selecciona el año',
							selectMonths: true,
							selectYears: 100,
							today: 'Hoy',
							clear: 'Borrar',
							close: 'Cerrar',
							monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
							monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
							weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
							weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
						});
					} else {
						swal("Error!", data, "warning");

						$("#load").html('');
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});

		}



		$('.frmNuevo').submit(function(e){

			e.preventDefault();
			if ($('#sign_in')[0].checkValidity()) {
				//información del formulario
				var formData = new FormData($(".formulario")[0]);
				var message = "";
				//hacemos la petición ajax
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: formData,
					//necesario para subir archivos via ajax
					cache: false,
					contentType: false,
					processData: false,
					//mientras enviamos el archivo
					beforeSend: function(){

					},
					//una vez finalizado correctamente
					success: function(data){

						if (data == '') {
							swal("Ok!", 'Se guardo correctamente los datos del pago', "success");

							$('#lgmNuevo').modal('hide');
							location.reload();


						} else {
							swal({
									title: "Respuesta",
									text: data,
									type: "error",
									timer: 2500,
									showConfirmButton: false
							});


						}
					},
					//si ha ocurrido un error
					error: function(){
						$(".alert").html('<strong>Error!</strong> Actualice la pagina');
						$("#load").html('');
					}
				});
			}
		});


		$('.frmModificar').submit(function(e){

			e.preventDefault();
			if ($('.frmModificar')[0].checkValidity()) {

				//información del formulario
				var formData = new FormData($(".formulario")[1]);
				var message = "";
				//hacemos la petición ajax
				$.ajax({
					url: '../../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: formData,
					//necesario para subir archivos via ajax
					cache: false,
					contentType: false,
					processData: false,
					//mientras enviamos el archivo
					beforeSend: function(){

					},
					//una vez finalizado correctamente
					success: function(data){

						if (data == '') {
							swal({
									title: "Respuesta",
									text: "Registro Modificado con exito!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

							$('#lgmModificar').modal('hide');
							location.reload();
						} else {
							swal({
									title: "Respuesta",
									text: data,
									type: "error",
									timer: 2500,
									showConfirmButton: false
							});


						}
					},
					//si ha ocurrido un error
					error: function(){
						$(".alert").html('<strong>Error!</strong> Actualice la pagina');
						$("#load").html('');
					}
				});
			}
		});



	});
</script>


</body>
<?php } ?>
</html>
