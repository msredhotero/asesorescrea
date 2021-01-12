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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../listadofacturacion/');
//*** FIN  ****/

$fecha = date('Y-m-d');

if ($_SESSION['idroll_sahilices'] == 10) {
	$idusuario = $_SESSION['usuaid_sahilices'];
} else {
	$id = $_GET['id'];
}

$resultado 		= 	$serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);


//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Facturacion",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';



$idventa = mysql_result($resultado,0,'refventas');

$nrorecibo = mysql_result($resultado,0,'nrorecibo');

$estadoRecibo = mysql_result($resultado,0,'estadopago');

$monto = mysql_result($resultado,0,'montototal');



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



$idCotizacion = mysql_result($resVenta,0,'refcotizaciones');

$resPagoCotizacion = $serviciosReferencias->traerPagosPorCotizacion($idCotizacion);
$urlArchivo = '';
$selectPago = '';
if (mysql_num_rows($resPagoCotizacion) > 0) {
	if (mysql_result($resPagoCotizacion,0,'refcuentasbancarias') == 0) {
		$resComercio = $serviciosComercio->traerComercioinicioPorOrderId($idCotizacion);
		if (mysql_num_rows($resComercio)>0) {
			$urlArchivo = '../../reportes/rptFacturaPagoOnline.php?token='.mysql_result($resComercio,0,'token');
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
		$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '40,41');
		$resDocumentacionesAux = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionCompletaDetalle($id, '40,41');
		$resDocumentacionReciboExistente = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id, 39);
		$puedeBorrar = 0;
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

$tabla 			= "dbperiodicidadventaspagos";

$lblCambio	 	= array('refperiodicidadventasdetalle','nrorecibo','fechapago','nrofactura','avisoinbursa','fechapagoreal');
$lblreemplazo	= array('Venta','Nro de Operacion','Fecha Pago','Nro Factura','Notifacacion a Inbursa','Fecha Pago Real');

if (mysql_num_rows($resResultado)>0) {

	$idPagoDelRecibo = mysql_result($resResultado,0,0);
	//modificar
	$resVar	= $serviciosReferencias->traerPeriodicidadventasPorIdCompleto($id);
	$cadRef = $serviciosFunciones->devolverSelectBox($resVar,array(1,2),' ');

	if (mysql_result($resResultado,0,'avisoinbursa') == '1') {
		$cadRef2 = "<option value='0'>No</option><option value='1' selected>Si</option>";
	} else {
		$cadRef2 = "<option value='0' selected>No</option><option value='1'>Si</option>";
	}



	$refdescripcion = array(0=>$cadRef,1=>$cadRef2);
	$refCampo 	=  array('refperiodicidadventasdetalle','avisoinbursa');

	$apareceaviso = 0;


	$frmUnidadNegocios 	= $serviciosFunciones->camposTablaModificar(mysql_result($resResultado,0,0), 'idperiodicidadventapago','modificarPeriodicidadventaspagos',$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);


} else {
	$idPagoDelRecibo = 0;
	//insertar
	$resVar	= $serviciosReferencias->traerPeriodicidadventasdetallePorIdCompleto($id);
	$cadRef = $serviciosFunciones->devolverSelectBox($resVar,array(1,2),' ');

	$cadRef2 = "<option value='0'>No</option><option value='1'>Si</option>";

	$refdescripcion = array(0=>$cadRef,1=>$cadRef2);
	$refCampo 	=  array('refperiodicidadventasdetalle','avisoinbursa');

	$apareceaviso = 1;

	$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo('insertarPeriodicidadventaspagos' ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

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
		.pdfobject-container { height: 30rem; border: 1rem solid rgba(0,0,0,.1); }

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
						<li class="list-group-item active">INFORMACION DEL PAGO</li>
						<li class="list-group-item"><?php echo 'No de Poliza: <b>'.strtoupper( $nropoliza).'</b>'; ?></li>
						<li class="list-group-item"><?php echo 'No de Recibo: <b>'.strtoupper($nrorecibo).'</b>'; ?></li>
						<li class="list-group-item"><?php echo 'Estado: <b>'.strtoupper($estadoRecibo).'</b>'; ?></li>
						<li class="list-group-item"><?php echo 'Monto: <b>$ '.number_format($monto,2,'.',',').'</b>'; ?></li>
						<li class="list-group-item">
							<button type="button" class="btn btn-primary waves-effect btnVolver" style="margin-bottom:15px;">
								<i class="material-icons">arrow_back</i>
								<span>VOLVER</span>
							</button>
						</li>

						<li class="list-group-item" style="height:60px;"></li>

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
					}
				?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<div class="info-box-3 bg-<?php echo $row['color']; ?> hover-zoom-effect btnDocumentacion<?php echo $row['iddocumentacion']; ?>" id="<?php echo $row['iddocumentacion']; ?>">
							<div class="icon">
								<i class="material-icons">unarchive</i>
							</div>
							<div class="content">
								<div class="text"><?php echo $row['documentacion']; ?> (seleccionar)</div>
								<div class="number"><?php echo $row['estadodocumentacion']; ?></div>
							</div>
						</div>
					</div>
				<?php }  ?>

			</div>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="margin-bottom:15px;">
				<?php if (($i == $completos) && ($_SESSION['idroll_sahilices'] == 17)) { ?>
					<button type="button" class="btn bg-orange enviarFactura" style="margin-left:0px;">ENVIAR FACTURA AL CLIENTE</button>
				<?php } ?>
				</div>
			</div>

			<?php if (($iddocumentacion == 39) && ($_SESSION['idroll_sahilices'] != 16)) { ?>
			<div class="row">

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card">
						<div class="header bg-blue">

						</div>
						<div class="body table-responsive">
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



							<?php if ($urlArchivo != '') { ?>
							<div class="col-xs-3">
								<div class="alert bg-orange">
									<p>Comprobante de pago cargado por el cliente: <b><a style="color:white;" target="_blank" href="<?php echo $urlArchivo; ?>">Descargar</a></b></p>
								</div>
							</div>
							<?php } ?>

							<form class="formulario frmNuevo" role="form" id="sign_in">
								<div class="row">
		                  	<?php echo $frmUnidadNegocios; ?>
									<?php echo $selectPago; ?>
								</div>

								<div class="modal-footer">
			                  <button type="submit" class="btn btn-primary waves-effect nuevo">GUARDAR</button>
									<button type="button" class="btn bg-orange waves-effect btnAvisar">
			 							AVISAR PAGO A INBURSA
		 							</button>
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
								AQUI TIENE SU FACTURA PARA DESCARGAR
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
			<div class="row">
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





		</div>
	</div>
</section>


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

		$('.enviarFactura').click(function() {
			enviarFacturaAlCliente();
		});

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
					idpago: <?php echo $idPagoDelRecibo; ?>
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
			modificarVentaUnicaDocumentacion($('#<?php echo $campo; ?>').val());
		});

		function modificarVentaUnicaDocumentacion(valor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarVentaUnicaDocumentacion',
					idventa: <?php echo $id; ?>,
					campo: '<?php echo $campo; ?>',
					valor: valor
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se guardo correctamente el <?php echo $campo; ?>', "success");

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
		}

		traerImagen('example1','timagen1');

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 30,
			acceptedFiles: ".pdf,.xml",
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



		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idasociado: <?php echo $id; ?>,
				 iddocumentacion: <?php echo $iddocumentacion; ?>
			},
			url: 'subir.php'
		});



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


		$('.maximizar').click(function() {
			if ($('.icomarcos').text() == 'web') {
				$('#marcos').show();
				$('.content').css('marginLeft', '265px');
				$('.icomarcos').html('aspect_ratio');
			} else {
				$('#marcos').hide();
				$('.content').css('marginLeft', '15px');
				$('.icomarcos').html('web');
			}

		});

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

							table.ajax.reload();
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
