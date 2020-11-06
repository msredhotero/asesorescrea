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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../engestion/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"En Gestion",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Cotizacion";

$plural = "Cotizaciones";

$eliminar = "eliminarCotizaciones";

$insertar = "insertarCotizaciones";

$modificar = "modificarCotizaciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$id = $_GET['id'];
$resultado = $serviciosReferencias->traerCotizacionesPorId($id);

$cuestionario = $serviciosReferencias->traerCuestionariodetallePorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id);

$idCliente = mysql_result($resultado,0,'refclientes');

$vigenciasCliente = $serviciosReferencias->vigenciasDocumentacionesClientes($idCliente);

if ($id == 0) {
	header('Location: index.php');
}

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcotizaciones";

$lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor','cobertura','reasegurodirecto','fecharenovacion','fechapropuesta','tiponegocio','presentacotizacion','fechavencimiento','coberturaactual','bitacoracrea','bitacorainbursa','bitacoraagente','existeprimaobjetivo','primaobjetivo');
$lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor','Cobertura Requiere Reaseguro','Reaseguro Directo con Inbursa o Broker','Fecha renovación o presentación de propueta al cliente','Fecha en que se entrega propuesta','Tipo de negocio para agente','Presenta Cotizacion o Poliza de competencia','Fecha Vencimiento póliza Actual','Aseguradora con quien esta suscrita la póliza','Bitacora CREA','Bitacora Inbursa','Bitacora Agente','Existe Prima Objetivo','Prima Objetivo');


$modificar = "modificarCotizaciones";
$idTabla = "idcotizacion";


$idestado = mysql_result($resultado,0,'refestadocotizaciones');

if ($idestado == 1) {
	header('Location: newfilter.php?id='.$id);
}

$resEstados = $serviciosReferencias->traerEstadocotizacionesPorId($idestado);

$orden = mysql_result($resEstados,0,'orden');
$ordenAux = $orden;

switch ($orden) {
	case 1:
		$ordenPosible = 2;
		$ordenRechazo = 0;
		$lblOrden = 'En proceso';
	break;
	case 2:
		$ordenPosible = 3;
		$ordenRechazo = 0;
		$lblOrden = 'Entrega de Propuesta INBURSA';
	break;
	case 3:
		$ordenPosible = 5;
		$ordenRechazo = 4;
		$lblOrden = 'Aceptado';
	break;
	case 4:
		$ordenPosible = 0;
		$ordenRechazo = 0;
		$lblOrden = 'Finalizado Rechazado';
	break;
	case 5:
		$ordenPosible = 0;
		$ordenRechazo = 0;
		$lblOrden = 'Vendido';
	break;

	case 9:
		$ordenPosible = 0;
		$ordenRechazo = 0;
		$lblOrden = 'Finalizado';
	break;

	default:
		// code...
		break;
}

$ordenPosible = 0;
if ($_SESSION['idroll_sahilices'] == 7) {
	if ($orden >= 3) {
		$ordenPosible = 0;
		$ordenRechazo = 0;
		$lblOrden = 'Finalizado';
	}
}

$resUsuario = $serviciosUsuario->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
$cadRef1 	= $serviciosFunciones->devolverSelectBox($resUsuario,array(1),'');

$resVar2	= $serviciosReferencias->traerClientesPorId(mysql_result($resultado,0,'refclientes'));
$cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(3,4,2),' ',mysql_result($resultado,0,'refclientes'));

$idclienteinbursa = mysql_result($resVar2,0,'idclienteinbursa');

$resVar3	= $serviciosReferencias->traerProductosPorId(mysql_result($resultado,0,'refproductos'));
$cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resultado,0,'refproductos'));

if ($_SESSION['idroll_sahilices'] != 7) {
	$resVar4	= $serviciosReferencias->traerAsociados();
	$cadRef4 = '<option value="0">-- Seleccionar --</option>';
	$cadRef4 .= $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(4,2,3),' ',mysql_result($resultado,0,'refasociados'));
} else {
	$cadRef4 = '<option value="0">-- Seleccionar --</option>';
}

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(2,3,4),' ');

	$resGuia = $serviciosReferencias->traerEstadocotizacionesPorIn('1,2');
} else {
	$resVar5	= $serviciosReferencias->traerAsesores();
	$cadRef5 = $serviciosFunciones->devolverSelectBoxActivo($resVar5,array(2,3,4),' ',mysql_result($resultado,0,'refasesores'));

	$resGuia = $serviciosReferencias->traerEstadocotizacionesPorIn('1,2,3,4,5');
}

$resVar6 = $serviciosReferencias->traerEstadocotizacionesPorId($ordenPosible);
$cadRef6 = $serviciosFunciones->devolverSelectBoxActivo($resVar6,array(1),'',$idestado);



switch (mysql_result($resultado,0,'cobertura')) {
	case 'Si':
		$cadRef7 = "<option value='Si' selected>Si</option><option value='No'>No</option><option value='No lo se'>No lo se</option>";
	break;
	case 'No':
		$cadRef7 = "<option value='Si'>Si</option><option value='No' selected>No</option><option value='No lo se'>No lo se</option>";
	break;
	case 'No lo se':
		$cadRef7 = "<option value='Si'>Si</option><option value='No'>No</option><option value='No lo se' selected>No lo se</option>";
	break;
}

//die(var_dump($ordenPosible));

switch (mysql_result($resultado,0,'presentacotizacion')) {
	case 'Si':
		$cadRef8 = "<option value='Si' selected>Si</option><option value='No'>No</option>";
	break;
	case 'No':
		$cadRef8 = "<option value='Si'>Si</option><option value='No' selected>No</option>";
	break;
}

switch (mysql_result($resultado,0,'tiponegocio')) {
	case 'Negocio nuevo':
		$cadRef9 = "<option value='Negocio nuevo' selected>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
	break;
	case 'Renovación':
		$cadRef9 = "<option value='Negocio nuevo'>Negocio nuevo</option><option value='Renovación' selected>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
	break;
	case 'Renovación póliza con otro agente':
		$cadRef9 = "<option value='Negocio nuevo'>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente' selected>Renovación póliza con otro agente</option>";
	break;
	default:
		$cadRef9 = "<option value='Negocio nuevo'>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
	break;
}

$cadRef11 = '';
switch (mysql_result($resultado,0,'existeprimaobjetivo')) {
	case '1':
		$cadRef11 = "<option value='1' selected>Si</option><option value='0'>No</option>";
	break;
	case '0':
		$cadRef11 = "<option value='1'>Si</option><option value='0' selected>No</option>";
	break;
}

$resVar10	= $serviciosReferencias->traerAseguradora();
$cadRef10 = $serviciosFunciones->devolverSelectBoxActivo($resVar10,array(1),'',mysql_result($resultado,0,'coberturaactual'));


$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6,6=>$cadRef7,7=>$cadRef8,8=>$cadRef9,9=>$cadRef10,10=>$cadRef11);
$refCampo 	=  array('refusuarios','refclientes','refproductos','refasociados','refasesores','refestadocotizaciones','cobertura','presentacotizacion','tiponegocio','coberturaactual','existeprimaobjetivo');

$frmUnidadNegocios = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resProducto = $serviciosReferencias->traerProductosPorId(mysql_result($resultado,0,'refproductos'));


$prima = mysql_result($resProducto, 0,'prima');

if ($_SESSION['idroll_sahilices'] == 3) {


} else {

}

if (mysql_result($resProducto,0,'reftipodocumentaciones') == '') {
	$refdoctipo = 0;
} else {
	$refdoctipo = mysql_result($resProducto,0,'reftipodocumentaciones');
}

$documentacionesadicionales = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,3);
$documentacionesadicionales2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,3);
$documentacionesadicionales3 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,3);

$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,$refdoctipo);
$documentacionesrequeridas2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,$refdoctipo);

$resDocumentacionesCliente = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompleta(mysql_result($resultado,0,'refclientes'));
$resDocumentacionesCliente2 = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompleta(mysql_result($resultado,0,'refclientes'));

$documentacionesrequeridasE = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacionE($id,$refdoctipo);
$documentacionesrequeridasE2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacionE($id,$refdoctipo);


$rightsidebar = '';
//die(var_dump($vigenciasCliente));

$cadArProd = '';

if (($ordenPosible >= 3) || ($ordenPosible == 0)) {
	while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
		$cadArProd .= '<li>
			 <span>'.substr($rowD['documentacion'],0,18).'</span>
			 <div class="switch">
				  <label class="btn bg-'.($rowD['color'] == '' ? 'grey' : $rowD['color']).' btn'.str_replace(' ','',$rowD['documentacion']).'" style="margin-top:-6px; margin-right:5px;">'.$rowD['estadodocumentacion'].'</label>
			 </div>
		</li>';
	}
}

$cadArProdE = '';

if (($ordenPosible >= 3) || ($ordenPosible == 0)) {
	while ($rowD = mysql_fetch_array($documentacionesrequeridasE)) {
		$cadArProdE .= '<li>
			 <span>'.substr($rowD['documentacion'],0,18).'</span>
			 <div class="switch">
				  <label class="btn bg-'.($rowD['color'] == '' ? 'grey' : $rowD['color']).' btnE'.str_replace(' ','',$rowD['documentacion']).'" style="margin-top:-6px; margin-right:5px;">'.$rowD['estadodocumentacion'].'</label>
			 </div>
		</li>';
	}
}


$cadArCotizacion = '';


while ($rowD = mysql_fetch_array($documentacionesadicionales3)) {
	$cadArCotizacion .= '<li>
		 <span>'.substr($rowD['documentacion'],0,18).'</span>
		 <div class="switch">
			  <label class="btn bg-'.($rowD['color'] == '' ? 'grey' : $rowD['color']).' btnA'.str_replace(' ','',$rowD['documentacion']).'" style="margin-top:-6px; margin-right:5px;">'.$rowD['estadodocumentacion'].'</label>
		 </div>
	</li>';
}

$cadArCliente = '';


while ($rowD = mysql_fetch_array($resDocumentacionesCliente)) {
	$cadArCliente .= '<li>
		 <span>'.substr($rowD['documentacion'],0,18).'</span>
		 <div class="switch">
			  <label class="btn bg-'.($rowD['color'] == '' ? 'grey' : $rowD['color']).' btnC'.str_replace(' ','',$rowD['documentacion']).'" style="margin-top:-6px; margin-right:5px;">'.$rowD['estadodocumentacion'].'</label>
		 </div>
	</li>';
}


$rightsidebar = '<ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">CLIENTE</a></li>
                <li role="presentation"><a href="#settings" data-toggle="tab">DOCUMENTACIONES</a></li>
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li>
                            <div class="'.($vigenciasCliente['errorVCD'] == 'true' ? 'red' : 'green').'"></div>
                            <span>Comp. de Domicilio: '.($vigenciasCliente['vcd']).'</span>
                        </li>
                        <li>
									<div class="'.($vigenciasCliente['errorVRFC'] == 'true' ? 'red' : 'green').'"></div>
									<span>Emision RFC: '.($vigenciasCliente['vrfc']).'</span>
                        </li>
								<li>
									<div class="'.($vigenciasCliente['errorVINE'] == 'true' ? 'red' : 'green').'"></div>
									<span>Venc. INE: '.($vigenciasCliente['vine']).'</span>
                        </li>
                    </ul>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="settings">
                    <div class="demo-settings">
                        <p>PRODUCTOS</p>
                        <ul class="setting-list">
                           '.$cadArProd.'
                        </ul>
								<p>EMISION</p>
                        <ul class="setting-list">
                           '.$cadArProdE.'
                        </ul>
                        <p>CLIENTES</p>
                        <ul class="setting-list">
                           '.$cadArCliente.'
                        </ul>

								<p>ADICIONALES</p>
                        <ul class="setting-list">
                           '.$cadArCotizacion.'
                        </ul>
                    </div>
                </div>
            </div>';

$lblModal ='';
$modalVigencias = 0;
if ($vigenciasCliente['errorVCD'] == 'true') {
	$lblModal .= '<h5>* Ya pasaron 90 dias de la emision del comprobante de domicilio, por favor, solicitelo nuevamente. Fecha de Emision: '.$vigenciasCliente['vcd'].'</h5><br>';
	$modalVigencias = 1;
}

if ($vigenciasCliente['errorVRFC'] == 'true') {
	$lblModal .= '<h5>* Ya pasaron 90 dias de la emision del RFC, por favor, solicitelo nuevamente. Fecha de Emision: '.$vigenciasCliente['vrfc'].'</h5><br>';
	$modalVigencias = 1;
}

if ($vigenciasCliente['errorVINE'] == 'true') {
	$lblModal .= '<h5>* Tiene vencido el INE, por favor, solicitelo nuevamente. Fecha de Emision: '.$vigenciasCliente['vine'].'</h5><br>';
	$modalVigencias = 1;
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
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../', $rightsidebar); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix">

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								MODIFICAR <?php echo strtoupper($plural); ?> <button type="button" class="btn bg-cyan waves-effect btnLstDocumentaciones"><i class="material-icons">unarchive</i><span class="js-right-sidebar" data-close="true">DOCUMENTACIONES</span></button> <button type="button" class="btn bg-green waves-effect btnLstEnviar"><i class="material-icons">send</i><span>ENVIAR COTIZACION A CLIENTE</span></button>
							</h2>
							<ul class="header-dropdown m-r--5">
								<li class="dropdown">
									<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
										<i class="material-icons">more_vert</i>
									</a>
									<ul class="dropdown-menu pull-right">

									</ul>
								</li>
							</ul>
						</div>
						<div class="body table-responsive">
							<form class="formulario frmNuevo" role="form" id="sign_in">


								<div class="row" style="padding: 5px 20px;">

									<?php echo $frmUnidadNegocios; ?>
									<input type="hidden" id="estadoactual" name="estadoactual" value=""/>
								</div>
								<div class="row">
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContidclienteinbursa" style="display:block">
										<label class="form-label">ID Cliente Inbursa </label>
										<div class="form-group input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="idclienteinbursa" name="idclienteinbursa" value="<?php echo $idclienteinbursa; ?>">

											</div>
										</div>
									</div>
									<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContfoliotys" style="display:block">
										<label class="form-label">Folio TYS </label>
										<div class="form-group input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="foliotys" name="foliotys">

											</div>
										</div>
									</div>
								</div>
								<div class="row" style="padding: 5px 20px;">
									<table class="display table table-border" style="border:1px solid #333;">
										<thead>
											<th colspan="2">CUESTIONARIO</th>
										</thead>
										<tbody>
											<tr>
												<th>Pregunta</th>
												<th>Respuesta</th>
											</tr>
									<?php
									$pregunta = '';
									$idcuestionario = 0;

									while ($rowC = mysql_fetch_array($cuestionario)) {
										$idcuestionario = $rowC['idcuestionario'];
										echo '<tr><td>';
										if ($pregunta != $rowC['pregunta']) {
											$pregunta = $rowC['pregunta'];
											echo $pregunta.'</td>';
										} else {
											echo '</td>';
										}
									?>
										<td><h5 style="color:green;">* <?php echo ($rowC['respuesta'] == 'Lo que el ususario ingrese' ? $rowC['respuestavalor'] : $rowC['respuesta']); ?></h5></td>
									</tr>
									<?php
									}

									//die(var_dump($idcuestionario.'-'.$idCliente));
									$resClienteDatos = $serviciosReferencias->necesitoPreguntaSencible($idCliente,$idcuestionario);
									$pregunta = '';
									foreach ($resClienteDatos[0] as $rowCC) {
										echo '<tr><td>';
										if ($pregunta != $rowCC['pregunta']) {
											$pregunta = $rowCC['pregunta'];
											echo $pregunta.'</td>';
										} else {
											echo '</td>';
										}

									?>
									<td><h5 style="color:green;">* <?php echo $rowCC['valor']; ?></h5></td>
								</tr>
								<?php } ?>
										</tbody>
									</table>
								</div>
								<div class="row">
									<p>Acciones</p>
									<div class="modal-footer">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
											<?php if ($idestado == 4 ) { ?>
											<button id="4" type="submit" class="btn btn-success waves-effect btnContinuar">MODIFICAR</button>

											<button type="button" class="btn bg-orange waves-effect btnAbandonada">ABANDONADA</button>
											<button type="button" class="btn bg-amber waves-effect btnDenegada">DENEGADA POR INBURSA</button>
											<button type="button" class="btn bg-deep-orange waves-effect btnInsuficiente">PRIMA DE REFERENCIA INSUFICIENTE</button>
										<?php } ?>


										</div>
				               </div>
								</div>
								<input type="hidden" id="refestadocotizaciones" name="refestadocotizaciones" value="4"/>
								<input type="hidden" id="refestados" name="refestados" value="2"/>
							</form>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="lgmVigencias" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-red">
					 <h4 class="modal-title" id="largeModalLabel">IMPORTANTE</h4>
				</div>
				<div class="modal-body">
				<div class="row">
					<?php echo $lblModal; ?>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>

		  </div>
	 </div>
</div>

<div class="modal fade" id="lgmENVIAR" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-green">
					<h4>IMPORTANTE</h4>
				</div>
				<div class="modal-body">
				<div class="row">
					<h5>Recuerde cargar la cotizacion en los documentos adicionales, en el apartado "Cotizacion 1" o "Cotizacion 2" o "Cotizacion 3"</h5>
				</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-success waves-effect btnEnviarCotizacionCliente" data-dismiss="modal">ENVIAR</button>
					<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>

		  </div>
	 </div>
</div>



<div class="modal fade" id="lgmModificarEstado" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-blue">
					 <h4 class="modal-title" id="largeModalLabel">MODIFICAR ESTADO DE LA COTIZACION</h4>
				</div>
				<div class="modal-body">
				 <p>¿Esta seguro que desea <span class="lblModiEstado"></span> la cotizacion?</p>
				</div>
				<div class="modal-footer">
					 <button type="button" class="btn bg-green waves-effect modificarEstadoCotizacionRechazo"></button>
					 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>
<input type="hidden" name="idmodificarestadorechazo" id="idmodificarestadorechazo" value="0">
<input type="hidden" name="estadomodificarestadorechazo" id="estadomodificarestadorechazo" value="0">

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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

	 <script src="../../js/picker.js"></script>
	 <script src="../../js/picker.date.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script>
	$(document).ready(function(){


		$('.modificarEstadoCotizacionRechazo').click(function() {
			modificarCotizacionesPorCampo();
		});

		function modificarCotizacionesPorCampo() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarCotizacionesPorCampo',
					id: $('#idmodificarestadorechazo').val(),
					idestado: $('#estadomodificarestadorechazo').val()
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					swal({
							title: "Respuesta",
							text: data.mensaje,
							type: data.tipo,
							timer: 1500,
							showConfirmButton: false
					});
					$('#lgmModificarEstado').modal('toggle');
					location.reload();
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
		}

		$('.btnAbandonada').click(function() {

			$('.lblModiEstado').html('ABANDONADA');
			$('.modificarEstadoCotizacionRechazo').html('ABANDONADA');
			$('#idmodificarestadorechazo').val(<?php echo $id; ?>);
			$('#estadomodificarestadorechazo').val(5);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar

		$('.btnDenegada').click(function() {

			$('.lblModiEstado').html('DENEGADA POR INBURSA');
			$('.modificarEstadoCotizacionRechazo').html('DENEGADA POR INBURSA');
			$('#idmodificarestadorechazo').val(<?php echo $id; ?>);
			$('#estadomodificarestadorechazo').val(6);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar


		$('.btnInsuficiente').click(function() {

			$('.lblModiEstado').html('PRIMA DE REFERENCIA INSUFICIENTE');
			$('.modificarEstadoCotizacionRechazo').html('PRIMA DE REFERENCIA INSUFICIENTE');
			$('#idmodificarestadorechazo').val(<?php echo $id; ?>);
			$('#estadomodificarestadorechazo').val(7);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar

		$('.frmConttieneasegurado').hide();
		$('.frmContrefasegurados').hide();
		$('.frmContrefbeneficiarios').hide();
		$('.frmContversion').hide();
		$('.frmContrefcotizaciones').hide();
		$('.frmContrefestados').hide();

		$('.btnLstEnviar').click(function() {
			$('#lgmENVIAR').modal();
		});

		$('.btnEnviarCotizacionCliente').click(function() {
			enviarCotizacion();
		});

		function enviarCotizacion() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'enviarCotizacion',
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data.error == false) {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "success",
								timer: 1000,
								showConfirmButton: false
						});

						$(location).attr('href','../entregadas/index.php');
					} else {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
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
		}

		$('.frmContbitacorainbursa').hide();


		<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
			$("#bitacoracrea").prop('readonly',true);
			$("#bitacorainbursa").prop('readonly',true);
		<?php } ?>

		<?php if ($_SESSION['idroll_sahilices'] == 17) { ?>
			$("#bitacoracrea").prop('readonly',true);
			$("#bitacorainbursa").prop('readonly',true);
		<?php } ?>



		$('.frmContreasegurodirecto').hide();
		$('.frmContfechapropuesta').hide();
		$('.frmContfechaemitido').hide();
		$('.frmContfecharenovacion').hide();
		//$('.frmContfoliotys').hide();


		<?php if (mysql_result($resultado,0,'tiponegocio') == 'Negocio nuevo') { ?>
			$('.frmContfechavencimiento').hide();
			$('.frmContcoberturaactual').hide();
			$('#fechavencimiento').val('');
			$('#coberturaactual').val('');

			$("#fechavencimiento").prop('required',false);
			$("#coberturaactual").prop('required',false);
		<?php } ?>

		$("#tiponegocio").change( function(){
			if (($(this)[0].selectedIndex == 1) || ($(this)[0].selectedIndex == 2)) {
				$('.frmContfechavencimiento').show();
				$('.frmContcoberturaactual').show();

				$("#fechavencimiento").prop('required',true);
				$("#coberturaactual").prop('required',true);
			} else {
				$('.frmContfechavencimiento').hide();
				$('.frmContcoberturaactual').hide();
				$('#fechavencimiento').val('');
				$('#coberturaactual').val('');

				$("#fechavencimiento").prop('required',false);
				$("#coberturaactual").prop('required',false);

			}
		});


		function traerClientescarteraPorCliente(idcliente) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerClientescarteraPorCliente', id: idcliente},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('#a')
					} else {
						swal({
								title: "Respuesta",
								text: data,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});

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

		}

		<?php

			while ($rowD = mysql_fetch_array($resDocumentacionesCliente2)) {
		?>

		$('.btnC<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "subirdocumentacionic.php?id=<?php echo $id; ?>&documentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}

		?>

		<?php

			while ($rowD = mysql_fetch_array($documentacionesadicionales2)) {
		?>

		$('.btnA<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&documentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}

		?>

		<?php
		if (($ordenPosible >= 3) || ($ordenPosible == 0)) {
			while ($rowD = mysql_fetch_array($documentacionesrequeridas2)) {
		?>

		$('.btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "subirdocumentacionip.php?id=<?php echo $id; ?>&documentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}
		}
		?>

		<?php
		if (($ordenPosible >= 3) || ($ordenPosible == 0)) {
			while ($rowD = mysql_fetch_array($documentacionesrequeridasE2)) {
		?>

		$('.btnE<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "subirdocumentacionie.php?id=<?php echo $id; ?>&documentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}
		}
		?>

		$('.btnPolizaVigente').click(function() {
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&documentacion=45";
			$(location).attr('href',url);
		});

		$('.btnCotizacion1').click(function() {
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&documentacion=46";
			$(location).attr('href',url);
		});

		$('.btnCotizacion2').click(function() {
			url = "subirdocumentacioni.php?id=<?php echo $id; ?>&documentacion=47";
			$(location).attr('href',url);
		});


		$('.frmContrefusuarios').hide();
		$('.frmContrefestadocotizaciones').hide();



		<?php
		if ($ordenPosible == 3) {
		?>

		$('.frmContidclienteinbursa').hide();
		$('.frmContfoliotys').hide();

		$("#idclienteinbursa").prop('required',false);
		$("#foliotys").prop('required',false);

		<?php
		}
		if ($ordenPosible == 5) {
		?>

		$('.frmContidclienteinbursa').show();
		$('.frmContfoliotys').show();

		$("#idclienteinbursa").prop('required',true);
		$("#foliotys").prop('required',true);
		<?php
		}
		?>


		$('.frmContfechacrea').hide();
		$('.frmContfechamodi').hide();
		$('.frmContusuariocrea').hide();
		$('.frmContusuariomodi').hide();

		$('#fechacrea').val('2020-02-02');
		$('#fechamodi').val('2020-02-02');
		$('#usuariocrea').val('2020-02-02');
		$('#usuariomodi').val('2020-02-02');

		$('#fecharenovacion').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: false,
			minDate : new Date()
		});


		$('#fechapropuesta').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: false,
			minDate : new Date()
		});

		$('#fechavencimiento').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: false,
			minDate : new Date()
		});



		<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
			$('.frmContrefasociados').hide();
			$('#refasociados').prepend('<option value="0">sin valor</option>');
			$('#refasociados').val(0);
		<?php } ?>


		$('#telefonofijo').inputmask('999 9999999', { placeholder: '___ _______' });
		$('#telefonocelular').inputmask('999 9999999', { placeholder: '___ _______' });


		$('#fechaemitido').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : new Date()
		});

		$('#fechapago').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: true,
			minDate : new Date()
		});



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cotizaciones",
			"language": {
				"emptyTable":     "No hay datos cargados",
				"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
				"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
				"infoFiltered":   "(filtrados del total de _MAX_ filas)",
				"infoPostFix":    "",
				"thousands":      ",",
				"lengthMenu":     "Mostrar _MENU_ filas",
				"loadingRecords": "Cargando...",
				"processing":     "Procesando...",
				"search":         "Buscar:",
				"zeroRecords":    "No se encontraron resultados",
				"paginate": {
					"first":      "Primero",
					"last":       "Ultimo",
					"next":       "Siguiente",
					"previous":   "Anterior"
				},
				"aria": {
					"sortAscending":  ": activate to sort column ascending",
					"sortDescending": ": activate to sort column descending"
				}
			},
			"columnDefs": [
              {
                  "targets": [ 4 ],
                  "visible": false,
                  "searchable": false
              }
          ]
		});

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$('#activo').prop('checked',true);

		function frmAjaxModificar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'frmAjaxModificar',tabla: '<?php echo $tabla; ?>', id: id,ruta:''},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxModificar').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxModificar').html(data);
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


		function frmAjaxEliminar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: '<?php echo $eliminar; ?>', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data == '') {
						swal({
								title: "Respuesta",
								text: "Registro Eliminado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						$('#lgmEliminar').modal('toggle');
						table.ajax.reload();
					} else {
						swal({
								title: "Respuesta",
								text: data,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
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
		}

		function frmAjaxEliminarDefinitivo(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'eliminarPostulantesDefinitivo', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					if (data == '') {
						swal({
								title: "Respuesta",
								text: "Registro Eliminado con exito!!",
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						$('#lgmEliminarDefinitivo').modal('toggle');
						table.ajax.reload();
					} else {
						swal({
								title: "Respuesta",
								text: data,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
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
		}

		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$("#example").on("click",'.btnEliminarDefinitivo', function(){
			idTable =  $(this).attr("id");
			$('#ideliminarDefinitivo').val(idTable);
			$('#lgmEliminarDefinitivo').modal();
		});//fin del boton eliminar


		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});

		$('.eliminarDefinitivo').click(function() {
			frmAjaxEliminarDefinitivo($('#ideliminarDefinitivo').val());
		});

		$(".btnModificar").click( function(){

			idTable =  $(this).attr("id");
			$('#estadoactual').val(idTable);
			$('.btnContinuar').click();
		});//fin del boton modificar

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		function refrescar(){
	    //Actualiza la página
	    location.reload();
	  }

	$('.btnRechazar').click(function() {
		$.ajax({
			url: '../../ajax/ajax.php',
			type: 'POST',
			// Form data
			//datos del formulario
			data: {accion: 'rechazarCotizacion', id: <?php echo $id; ?>, observaciones: $('#observaciones').val()},
			//mientras enviamos el archivo
			beforeSend: function(){

			},
			//una vez finalizado correctamente
			success: function(data){
				if (data == '') {
					swal({
							title: "Respuesta",
							text: "Registro Eliminado con exito!!",
							type: "success",
							timer: 1500,
							showConfirmButton: false
					});
					setTimeout(refrescar, 2500);
				} else {
					swal({
							title: "Respuesta",
							text: data,
							type: "error",
							timer: 2000,
							showConfirmButton: false
					});
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
	});

	$('.btnRechazarValidacion').click(function() {
		$.ajax({
			url: '../../ajax/ajax.php',
			type: 'POST',
			// Form data
			//datos del formulario
			data: {
				accion: 'rechazarCotizacionValidacion',
				id: <?php echo $id; ?>,
				idagente: <?php echo mysql_result($resultado,0,'refasesores'); ?>,
				bitacoracrea: $('#bitacoracrea').val()
			},
			//mientras enviamos el archivo
			beforeSend: function(){

			},
			//una vez finalizado correctamente
			success: function(data){
				if (data == '') {
					swal({
							title: "Respuesta",
							text: "Registro Eliminado con exito!!",
							type: "success",
							timer: 1500,
							showConfirmButton: false
					});
					setTimeout(refrescar, 2000);
				} else {
					swal({
							title: "Respuesta",
							text: data,
							type: "error",
							timer: 2000,
							showConfirmButton: false
					});
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
	});


		$('.frmNuevo').submit(function(e){
			$('#refestadocotizaciones').val(4);
			$('#refestados').val(2);
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
							swal("Ok!", 'Se guardo correctamente la cotizacion', "success");

							setTimeout(refrescar, 1500);
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
