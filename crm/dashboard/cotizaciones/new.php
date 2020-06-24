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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cotizaciones/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cotizaciones",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Cotizacion";
$singular2 = "Cliente";

$plural = "Cotizaciones";

$eliminar = "eliminarCotizaciones";

$insertar = "insertarCotizaciones";

$modificar = "modificarCotizaciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

	$refCliente = mysql_result($resultado,0,'refclientes');
	$refAsesores = mysql_result($resultado,0,'refasesores');
	$refAsociados = mysql_result($resultado,0,'refasociados');
	$refProductos = mysql_result($resultado,0,'refproductos');

	$resCliente = $serviciosReferencias->traerClientesPorId($refCliente);
	$cadRef2 = $serviciosFunciones->devolverSelectBox($resCliente,array(3,4,2),' ');


	$resAsesor = $serviciosReferencias->traerAsesoresPorId($refAsesores);
	$cadRef3 = $serviciosFunciones->devolverSelectBox($resAsesor,array(2,3,4),' ');

	$resAsociado = $serviciosReferencias->traerAsociadosPorId(($refAsociados == '' ? 0 : $refAsociados) );
	$cadRef4 = $serviciosFunciones->devolverSelectBox($resAsociado,array(2,3,4),' ');

	$resProducto = $serviciosReferencias->traerProductosPorIdCompleta($refProductos);
	$cadRef5 = $serviciosFunciones->devolverSelectBox($resProducto,array(1),' ');

	$lblCliente = mysql_result($resultado,0,'cliente');
	$lblAsesor = mysql_result($resultado,0,'asesor');
	$lblAsociado = mysql_result($resultado,0,'asociado');
	$lblProducto = mysql_result($resultado,0,'producto');

	$resTipoProducto = $serviciosReferencias->traerTipoproductoPorId(mysql_result($resProducto,0,'reftipoproducto'));
	$cadRef7 = $serviciosFunciones->devolverSelectBox($resTipoProducto,array(1),' ');

	$resTipoProductoRama = $serviciosReferencias->traerTipoproductoramaPorId(mysql_result($resProducto,0,'reftipoproductorama'));
	$cadRef8 = $serviciosFunciones->devolverSelectBox($resTipoProductoRama,array(2),' ');


	if (mysql_result($resProducto,0,'reftipodocumentaciones') == '') {
		$refdoctipo = 0;
	} else {
		$refdoctipo = mysql_result($resProducto,0,'reftipodocumentaciones');
	}

	$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,$refdoctipo);
	$documentacionesrequeridas2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,$refdoctipo);
	$documentacionesrequeridas3 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,$refdoctipo);
	$documentacionesrequeridas4 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,$refdoctipo);

	if (isset($_GET['iddocumentacion'])) {
		$iddocumentacion = $_GET['iddocumentacion'];
	} else {
		if (mysql_num_rows($documentacionesrequeridas3)>0) {
			$iddocumentacion = mysql_result($documentacionesrequeridas3,0,'iddocumentacion');
		} else {
			$iddocumentacion = 0;
		}

	}

	$iDoc = 0;
	$verifarCargaPrincipal = 0;
	$conCargados = 0;

	while ($rowDD = mysql_fetch_array($documentacionesrequeridas4)) {
		if ($rowDD['obligatoria'] == '1') {
			$iDoc += 1;
		}

		if (($rowDD['archivo'] != '') && ($rowDD['obligatoria'] == '1')) {
			$conCargados += 1;
		}
	}

	if ($conCargados >= $iDoc) {
		$verifarCargaPrincipal = 1;
	}




	$documentacionesadicionales = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,3);
	$documentacionesadicionales2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,3);
	$documentacionesadicionales3 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($id,3);

	if (isset($_GET['iddocumentaciona'])) {
		$iddocumentacion2 = $_GET['iddocumentaciona'];
	} else {
		$iddocumentacion2 = mysql_result($documentacionesadicionales3,0,'iddocumentacion');
	}
	//die(var_dump($iddocumentacion2));


	switch (mysql_result($resultado,0,'cobertura')) {
		case 'Si':
			$cadRef7b = "<option value='Si' selected>Si</option><option value='No'>No</option><option value='No lo se'>No lo se</option>";
		break;
		case 'No':
			$cadRef7b = "<option value='Si'>Si</option><option value='No' selected>No</option><option value='No lo se'>No lo se</option>";
		break;
		case 'No lo se':
			$cadRef7b = "<option value='Si'>Si</option><option value='No'>No</option><option value='No lo se' selected>No lo se</option>";
		break;
	}

	//die(var_dump($ordenPosible));

	switch (mysql_result($resultado,0,'presentacotizacion')) {
		case 'Si':
			$cadRef8b = "<option value='Si' selected>Si</option><option value='No'>No</option>";
		break;
		case 'No':
			$cadRef8b = "<option value='Si'>Si</option><option value='No' selected>No</option>";
		break;
	}

	switch (mysql_result($resultado,0,'tiponegocio')) {
		case 'Negocio nuevo':
			$cadRef9b = "<option value='Negocio nuevo' selected>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
		break;
		case 'Renovación':
			$cadRef9b = "<option value='Negocio nuevo'>Negocio nuevo</option><option value='Renovación' selected>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
		break;
		case 'Renovación póliza con otro agente':
			$cadRef9b = "<option value='Negocio nuevo'>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente' selected>Renovación póliza con otro agente</option>";
		break;
		default:
			$cadRef9b = "<option value='Negocio nuevo'>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
		break;
	}

	$cadRef11 = '';
	switch (mysql_result($resultado,0,'existeprimaobjetivo')) {
		case '1':
			$cadRef11b = "<option value='1' selected>Si</option><option value='0'>No</option>";
		break;
		case '0':
			$cadRef11b = "<option value='1'>Si</option><option value='0' selected>No</option>";
		break;
	}

	$resVar10	= $serviciosReferencias->traerAseguradora();
	$cadRef10 = $serviciosFunciones->devolverSelectBoxActivo($resVar10,array(1),'',mysql_result($resultado,0,'coberturaactual'));

	$primaobjetivo = mysql_result($resultado,0,'primaobjetivo');
	$fechavencimiento = mysql_result($resultado,0,'fechavencimiento');
	$observaciones = mysql_result($resultado,0,'observaciones');



	$resDocumentacionAsesor = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacion($id, $iddocumentacion);

	$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);

	$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

	if (mysql_num_rows($resDocumentacionAsesor) > 0) {
		$cadRefEstados = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones'));

		$iddocumentacionasociado = mysql_result($resDocumentacionAsesor,0,'iddocumentacioncotizacion');

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

		$idestadodocumentacion = mysql_result($resDocumentacionAsesor,0,'refestadodocumentaciones');
	} else {
		$cadRefEstados = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

		$iddocumentacionasociado = 0;

		$estadoDocumentacion = 'Falta Cargar';

		$color = 'blue';

		$span = 'text-info glyphicon glyphicon-plus-sign';

		$idestadodocumentacion = 1;
	}



	////////////////////  2   ///////////////////////////
	$resDocumentacionAsesor2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacion($id, $iddocumentacion2);

	$resDocumentacion2 = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion2);

	$resEstados2 = $serviciosReferencias->traerEstadodocumentaciones();

	if (mysql_num_rows($resDocumentacionAsesor2) > 0) {
		$cadRefEstados2 = $serviciosFunciones->devolverSelectBoxActivo($resEstados2,array(1),'', mysql_result($resDocumentacionAsesor2,0,'refestadodocumentaciones'));

		$iddocumentacionasociado2 = mysql_result($resDocumentacionAsesor2,0,'iddocumentacioncotizacion');

		$estadoDocumentacion2 = mysql_result($resDocumentacionAsesor2,0,'estadodocumentacion');

		$color2 = mysql_result($resDocumentacionAsesor2,0,'color');

		$span2 = '';
		switch (mysql_result($resDocumentacionAsesor2,0,'estadodocumentacion')) {
			case 1:
				$span2 = 'text-info glyphicon glyphicon-plus-sign';
			break;
			case 2:
				$span2 = 'text-danger glyphicon glyphicon-remove-sign';
			break;
			case 3:
				$span2 = 'text-danger glyphicon glyphicon-remove-sign';
			break;
			case 4:
				$span2 = 'text-danger glyphicon glyphicon-remove-sign';
			break;
			case 5:
				$span2 = 'text-success glyphicon glyphicon-remove-sign';
			break;
		}

		$idestadodocumentacion2 = mysql_result($resDocumentacionAsesor2,0,'refestadodocumentaciones');
	} else {
		$cadRefEstados2 = $serviciosFunciones->devolverSelectBox($resEstados2,array(1),'');

		$iddocumentacionasociado2 = 0;

		$estadoDocumentacion2 = 'Falta Cargar';

		$color2 = 'blue';

		$span2 = 'text-info glyphicon glyphicon-plus-sign';

		$idestadodocumentacion2 = 1;
	}




	//////////////////////////////////////////////

	switch ($iddocumentacion) {
		case 35:
			// code...
			$dato = mysql_result($resultado,0,'nropoliza');

			$input = '<input type="text" name="nropoliza" maxlength="13" id="nropoliza" class="form-control" value="'.$dato.'"/> ';
			$boton = '<button type="button" class="btn btn-primary waves-effect btnModificar">GUARDAR</button>';
			$leyenda = 'Cargue el Nro de Poliza';
			$campo = 'nropoliza';
		break;
		case 36:
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

	if (mysql_num_rows($resDocumentacion)>0) {
		$documentacionNombre = mysql_result($resDocumentacion,0,'documentacion');
	} else {
		$documentacionNombre = '';
	}

	if (mysql_num_rows($resDocumentacion2)>0) {
		$documentacionNombre2 = mysql_result($resDocumentacion2,0,'documentacion');
	} else {
		$documentacionNombre2 = '';
	}

} else {

	$id = 0;

	$cadRef7b = "<option value='Si'>Si</option><option value='No'>No</option><option value='No lo se' selected>No lo se</option>";
	$cadRef8b = "<option value='Si'>Si</option><option value='No' selected>No</option>";
	$cadRef9b = "<option value='Negocio nuevo' selected>Negocio nuevo</option><option value='Renovación'>Renovación</option><option value='Renovación póliza con otro agente'>Renovación póliza con otro agente</option>";
	$cadRef11b = "<option value='1'>Si</option><option value='0' selected>No</option>";

	$primaobjetivo = 0;
	$fechavencimiento = '';
	$observaciones = '';

	$resVar10	= $serviciosReferencias->traerAseguradora();
	$cadRef10 = $serviciosFunciones->devolverSelectBox($resVar10,array(1),'');

	$cadRef2 = "<option value=''></option>";
	$cadRef3 = "<option value=''></option>";
	$cadRef4 = "<option value=''></option>";
	$cadRef5 = "<option value=''></option>";

	$lblCliente = 0;
	$lblAsesor = 0;
	$lblAsociado = 0;
	$lblProducto = 0;

	$resTipoProducto = $serviciosReferencias->traerTipoproducto();
	$cadRef7 = $serviciosFunciones->devolverSelectBox($resTipoProducto,array(1),' ');

	$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion(0,0);

	$documentacionesrequeridas2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion(0,0);

	$documentacionesadicionales = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion(0,3);

	$documentacionesadicionales2 = $serviciosReferencias->traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion(0,3);


	$documentacionNombre = '';

	$documentacionNombre2 = '';


}

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcotizaciones";

$lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor','cobertura','reasegurodirecto','fecharenovacion','fechapropuesta','tiponegocio','presentacotizacion','existeprimaobjetivo','primaobjetivo');
$lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor','Cobertura Requiere Reaseguro','Reaseguro Directo con Inbursa o Broker','Fecha renovación o presentación de propueta al cliente','Fecha en que se entrega propuesta','Tipo de negocio para agente','Presenta Cotizacion o Poliza de competencia','Existe Prima Objetivo','Prima Objetivo');


if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	if (mysql_num_rows($resVar5)>0) {
		$cadRef6 = $serviciosFunciones->devolverSelectBox($resVar5,array(3,4,2),' ');
	} else {
		header('Location: ../index.php');
	}

	$idasesor = mysql_result($resVar5,0,'idasesor');

} else {
	$resVar5	= $serviciosReferencias->traerAsesores();
	$cadRef6 = $serviciosFunciones->devolverSelectBox($resVar5,array(3,4,2),' ');
	$idasesor = 0;

}


//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$tabla2 			= "dbclientes";

$lblCambio2	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonofijo','telefonocelular','reftipopersonas','numerocliente','razonsocial','idclienteinbursa');
$lblreemplazo2	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Fijo','Tel. Celular','Tipo Persona','Nro Cliente','Razon Social','ID Cliente Inbursa');


$resVar82 = $serviciosReferencias->traerTipopersonas();
$cadRef82 = $serviciosFunciones->devolverSelectBox($resVar82,array(1),'');

$refdescripcion2 = array(0=>$cadRef82);
$refCampo2 	=  array('reftipopersonas');

$frmUnidadNegocios2 	= $serviciosFunciones->camposTablaViejo('insertarClientes' ,$tabla2,$lblCambio2,$lblreemplazo2,$refdescripcion2,$refCampo2);

if ($_SESSION['idroll_sahilices'] == 3) {


} else {

}

$resAseguradoras = $serviciosReferencias->traerAseguradora();
$cadRefAse = $serviciosFunciones->devolverSelectBox($resAseguradoras,array(1),'');





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

		.ui-autocomplete { position: absolute; cursor: default;z-index:30 !important;}

		.sectionC {
			height:360px;
			z-index:1 !important;
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
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>CARGAR COTIZACION</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                           <form id="wizard_with_validation" method="POST">
										<input type="hidden" name="accion" value="validarCuestionario"/>
                              <h3>Cliente</h3>
                              <fieldset>

                                    <div class="form-group form-float">
                                       <div class="form-line">

													<h4>Busqueda por Nombre Completo</h4>
													<input id="lstjugadores" style="width:75%;" />

													<h4 style="padding: 15px 0; ">Cliente Seleccionado: <span class="clienteSelect"><?php echo $lblCliente; ?></span></h4>
													<select style="margin-top:10px;" class="form-control" id="refclientes" name="refclientes" required readonly="readonly">
														<?php echo $cadRef2; ?>
													</select>


													<div id="selction-ajax" style="margin-top: 10px;">
													<h5>Lista de Productos</h5>
													<ul class="list-group lstCartera">

													</ul>
													</div>


                                       </div>
                                    </div>

												<div class="form-group form-float">
													<div class="alert alert-info">En caso de que no encuentre al cliente puede dar de alta uno nuevo</div>
													<hr>
													<div class="form-line">
														  <button type="button" class="btn bg-green waves-effect btnNuevo2" data-toggle="modal" data-target="#lgmNuevo2">
			  												<i class="material-icons">add</i>
			  												<span>NUEVO CLIENTE - PERSONA FISICA</span>
			  											</button>
			  											<button type="button" class="btn bg-blue-grey waves-effect btnNuevoMoral" data-toggle="modal" data-target="#lgmNuevo2">
			  												<i class="material-icons">add</i>
			  												<span>NUEVO CLIENTE - PERSONA MORAL</span>
			  											</button>
													</div>
											   </div>


                              </fieldset>
										<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
										<h3>Agente</h3>
                              <fieldset>
                                 <div class="form-group form-float">
                                     <div class="form-line">

														<h4>Busqueda por Nombre Completo</h4>
														<input id="lstagentes" style="width:75%;" />

														<h4 style="padding: 15px 0; ">Agente Seleccionado: <span class="agenteSelect"><?php echo $lblAsesor; ?></span></h4>
														<select style="margin-top:10px;" class="form-control" id="refasesores" name="refasesores" required readonly="readonly">
															<?php echo $cadRef3; ?>
														</select>


                                     </div>
                                 </div>
                              </fieldset>

										<h3>Asociados</h3>
                              <fieldset>
											<div class="form-group form-float frmContasociadocheck" style="margin-top:20px;">
												<div class="form-group">
													<input type="radio" name="asociado" id="sin" class="with-gap" value="0" checked>
													<label for="sin">No Lleva Asociado</label>

													<input type="radio" name="asociado" id="comun" class="with-gap" value="1">
													<label for="comun">Lleva Asociado</label>

													<input type="radio" name="asociado" id="temporal" class="with-gap" value="2" >
													<label for="temporal" class="m-l-20">Lleva Agente Temporal</label>
												</div>
											</div>
                                 <div class="form-group form-float">
                                     <div class="form-line">

														<h4>Busqueda por Nombre Completo</h4>
														<input id="lstasociados" class="contAsesores" style="width:75%;" />

														<h4 style="padding: 15px 0; ">Agente Seleccionado: <span class="asociadoSelect"><?php echo $lblAsociado; ?></span></h4>
														<select style="margin-top:10px;" class="form-control" id="refasociados" name="refasociados" readonly="readonly">
															<?php echo $cadRef4; ?>
														</select>

                                     </div>
                                 </div>
                              </fieldset>
										<?php } else { ?>
											<select style="display:none;" style="margin-top:10px;" class="form-control" id="refasesores" name="refasesores" required readonly="readonly">
												<?php echo $cadRef6; ?>
											</select>
										<?php } ?>

                              <h3>Producto</h3>
                                 <fieldset>
												<div class="form-group form-float">
													<label class="form-label" style="margin-top:20px;">Ramo de Negocio *</label>
                                       <div class="form-line">

							   						<select style="margin-top:10px;" class="form-control" id="reftipoproducto" name="reftipoproducto" required>
															<?php echo $cadRef7; ?>
														</select>

                                       </div>
                                    </div>
												<div class="form-group form-float">
													<label class="form-label" style="margin-top:20px;">Rama Producto *</label>
                                       <div class="form-line">

							   						<select style="margin-top:10px;" class="form-control" id="refproductosrama" name="refproductosrama" required>
															<?php echo $cadRef8; ?>
														</select>

                                       </div>
                                    </div>
												<div class="form-group form-float">
													<label class="form-label" style="margin-top:20px;">Producto *</label>
                                       <div class="form-line">

							   						<select style="margin-top:10px;" class="form-control" id="refproductos" name="refproductos" required>
															<?php echo $cadRef5; ?>
														</select>

                                       </div>
                                    </div>
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContexisteprimaobjetivo" style="display:block">
													<div class="contCuestionario">

													</div>
												</div>

                              </fieldset>

										<h3>Galeria Producto</h3>
                              <fieldset>
											<?php if ($documentacionNombre != '') { ?>
												<p>Archivos que debera cargar para continuar</p>
											<?php } else { ?>
												<p>No existen archivos solicitados para cargar</p>
											<?php } ?>
											<div class="col-xs-4">
											<?php
												$i = 0;
												$cargados = 0;
												while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
													$i += 1;
													if ($rowD['archivo'] != '') {
														$cargados += 1;
													}
											?>

											<div class="form-group form-float">
												<button type="button" class="btn bg-<?php echo $rowD['color']; ?> waves-effect btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>"><i class="material-icons">unarchive</i><span><?php echo $rowD['documentacion']; ?></span></button>
												<input type="text" readonly="readonly" name="archivo<?php echo $i; ?>" id="archivo<?php echo $i; ?>" value="<?php echo $rowD['archivo']; ?>" required/>
											</div>

											<?php
												}

											?>
											</div>
											<div class="col-xs-8">
												<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
													<div class="card">
														<div class="header bg-blue">
															<h2>
																ARCHIVO CARGADO
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
															<div class="row">
																<button type="button" class="btn bg-red waves-effect btnEliminar">
																	<i class="material-icons">remove</i>
																	<span>ELIMINAR</span>
																</button>
															</div>
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
																<div class="col-xs-6 col-md-6" style="display:block">
																	<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
																	<div class="input-group col-md-12">
																		<select class="form-control show-tick" id="refestados" name="refestados">
																			<?php echo $cadRefEstados; ?>
																		</select>
																	</div>
																	<?php
																	if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 11)) {
																	?>
																	<button type="button" class="btn btn-primary guardarEstado" style="margin-left:0px;">Guardar Estado</button>
																<?php } ?>
																</div>

															</div>
														</div>
													</div>
												</div>

											</div>
                              </fieldset>

                              <h3>Información del Negocio</h3>
                              <fieldset>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContexisteprimaobjetivo" style="display:block">
												<div class="form-group form-float">
													<label class="form-label" style="margin-top:20px;">Existe Prima Objetivo</label>
                                       <div class="form-line">

							   						<select style="margin-top:10px;" class="form-control" id="existeprimaobjetivo" name="existeprimaobjetivo" required>
															<?php echo $cadRef11b; ?>
														</select>

                                       </div>
                                    </div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContprimaobjetivo" style="display:block">
												<div class="form-group form-float">
													<label class="form-label" style="margin-top:30px;">Prima Objetivo</label>
		                                <div class="form-line">

												   	<input style="width:200px;" type="text" class="form-control" id="primaobjetivo" name="primaobjetivo" value="<?php echo $primaobjetivo; ?>" />


		                                </div>
		                              </div>
											</div>

										   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContcobertura" style="display:block">
												<div class="form-group form-float">
													<label class="form-label" style="margin-top:20px;">Cobertura Requiere Reaseguro</label>
                                       <div class="form-line">

							   						<select style="margin-top:10px;" class="form-control" id="cobertura" name="cobertura" required>
															<?php echo $cadRef7b; ?>
														</select>

                                       </div>
                                    </div>
											</div>
											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContcobertura" style="display:block">
												<input type="hidden" class="form-control" id="reasegurodirecto" name="reasegurodirecto">

												<div class="form-group form-float">
													<label class="form-label">Presenta Cotizacion O Poliza De Competencia</label>
                                       <div class="form-line">

							   						<select style="margin-top:10px;" class="form-control" id="presentacotizacion" name="presentacotizacion" required>
															<?php echo $cadRef8b; ?>
														</select>

                                       </div>
                                    </div>
										   </div>


											<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmConttiponegocio" style="display:block">

												<div class="form-group input-group">
													<label class="form-label">Tipo De Negocio Para Agente </label>
													<div class="form-line">
														<select style="margin-top:10px;" class="form-control" id="tiponegocio" name="tiponegocio" required>
															<?php echo $cadRef9b; ?>
														</select>
													</div>
												</div>
											</div>
											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContfechavencimiento" style="display:block">
												<b>Fecha de Vencimiento póliza Actual</b>
												<div class="input-group">

												<span class="input-group-addon">
													 <i class="material-icons">date_range</i>
												</span>
		                                <div class="form-line">

												   	<input style="width:200px;" type="text" class="datepicker form-control" id="fechavencimiento" name="fechavencimiento" value="<?php echo $fechavencimiento; ?>" />

		                                </div>
		                              </div>
											</div>

											<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContcoberturaactual" style="display:block">

												<div class="form-group input-group">
													<label class="form-label">Aseguradora con quien esta suscrita la póliza</label>
													<div class="form-line">
														<select class="form-control" id="coberturaactual" name="coberturaactual" required>
															<option value='0'>-- Seleccionar --</option>
															<?php echo $cadRef10; ?>
														</select>
													</div>
												</div>

												<input style="width:200px;" type="hidden" class="form-control" id="fecharenovacion" name="fecharenovacion" />
											</div>

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContobservaciones" style="display:block">
												<label class="form-label">Observaciones </label>
												<div class="form-group input-group">
													<div class="form-line">
														<textarea id="observaciones" name="observaciones"  rows="2" class="form-control no-resize"></textarea>

													</div>
												</div>
											</div>

											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContadjuntos" style="display:block">
												<div class="col-xs-4">
													<label class="form-label">Puede adjuntar los siguientes archivos </label>
													<?php
														while ($rowD = mysql_fetch_array($documentacionesadicionales)) {

													?>
													<div class="form-group form-float">
														<button type="button" class="btn bg-<?php echo $rowD['color']; ?> waves-effect btnA<?php echo str_replace(' ','',$rowD['documentacion']); ?>"><i class="material-icons">unarchive</i><span><?php echo $rowD['documentacion']; ?></span></button>
													</div>
													<?php
														}

													?>
												</div>
												<div class="col-xs-8">
													<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
														<div class="card">
															<div class="header bg-blue">
																<h2>
																	ARCHIVO CARGADO
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
																<div class="row">
																	<button type="button" class="btn bg-red waves-effect btnEliminar2">
																		<i class="material-icons">remove</i>
																		<span>ELIMINAR</span>
																	</button>
																</div>
																<div class="row">
																	<a href="javascript:void(0);" class="thumbnail timagen12">
																		<img class="img-responsive">
																	</a>
																	<div id="example12"></div>
																</div>
																<div class="row">
																	<div class="alert bg-<?php echo $color2; ?>">
																		<h4>
																			Estado: <b><?php echo $estadoDocumentacion2; ?></b>
																		</h4>
																	</div>
																	<div class="col-xs-6 col-md-6" style="display:block">
																		<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
																		<div class="input-group col-md-12">
																			<select class="form-control show-tick" id="refestados2" name="refestados2">
																				<?php echo $cadRefEstados2; ?>
																			</select>
																		</div>
																		<?php
																		if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 11)) {
																		?>
																		<button type="button" class="btn btn-primary guardarEstado2" style="margin-left:0px;">Guardar Estado</button>
																	<?php } ?>
																	</div>

																</div>
															</div>
														</div>
													</div>

												</div>
											</div>




                              </fieldset>


                           </form>



                     </div>

               </div>
					<?php if ($documentacionNombre != '') { ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contSubirArchivos1">
						<div class="card">
							<div class="header bg-blue">
								<h2>
									CARGA/MODIFIQUE LA DOCUMENTACIÓN <?php echo $documentacionNombre; ?> AQUI
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
				<?php if ($documentacionNombre2 != '') { ?>
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contSubirArchivos2">
						<div class="card">
							<div class="header bg-blue">
								<h2>
									CARGA/MODIFIQUE LA DOCUMENTACIÓN <?php echo $documentacionNombre2; ?> AQUI
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
								<form action="subir.php" id="frmFileUpload2" class="dropzone" method="post" enctype="multipart/form-data">
									<div class="dz-message">
										<div class="drag-icon-cph">
											<i class="material-icons">touch_app</i>
										</div>
										<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
									</div>
									<div class="fallback">
										<input name="file" type="file" id="archivos2" />
										<input type="hidden" id="idasociado2" name="idasociado" value="<?php echo $id; ?>" />
									</div>
								</form>
							</div>
						</div>
					</div>
				<?php } ?>

            </div>
		</div>
	</div>
</section>


<!-- NUEVO -->
	<form class="formulario frmNuevo" role="form" id="sign_in">
	   <div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
	       <div class="modal-dialog modal-lg" role="document">
	           <div class="modal-content">
	               <div class="modal-header">
	                   <h4 class="modal-title" id="largeModalLabel">CREAR <?php echo strtoupper($singular); ?></h4>
	               </div>
	               <div class="modal-body">
						<div class="row">
							<?php echo $frmUnidadNegocios; ?>
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
		                   <h4 class="modal-title" id="largeModalLabel">MODIFICAR <?php echo strtoupper($singular); ?></h4>
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
			<input type="hidden" id="accion" name="accion" value="<?php echo $modificar; ?>"/>
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
		                   <button type="button" class="btn btn-danger waves-effect eliminar">ELIMINAR</button>
		                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
		               </div>
		           </div>
		       </div>
		   </div>
			<input type="hidden" id="accion" name="accion" value="<?php echo $eliminar; ?>"/>
			<input type="hidden" name="ideliminar" id="ideliminar" value="0">
		</form>

	<!-- ELIMINAR DEFINITIVO -->
		<form class="formulario" role="form" id="sign_in">
		   <div class="modal fade" id="lgmEliminarDefinitivo" tabindex="-1" role="dialog">
		       <div class="modal-dialog modal-lg" role="document">
		           <div class="modal-content">
		               <div class="modal-header">
		                   <h4 class="modal-title" id="largeModalLabel">ELIMINAR DEFINITIVO <?php echo strtoupper($singular); ?></h4>
		               </div>
		               <div class="modal-body">
							 <p>¿Esta seguro que desea eliminar el registro?</p>
							 <small>* Si este registro esta relacionado con algun otro dato no se podría eliminar.</small>
		               </div>
		               <div class="modal-footer">
		                   <button type="button" class="btn btn-danger waves-effect eliminarDefinitivo">ELIMINAR</button>
		                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
		               </div>
		           </div>
		       </div>
		   </div>
			<input type="hidden" id="accion" name="accion" value="eliminarPostulantesDefinitivo"/>
			<input type="hidden" name="ideliminarDefinitivo" id="ideliminarDefinitivo" value="0">
		</form>


	<!-- NUEVO -->
	<form class="formulario frmNuevo2" role="form" id="sign_in">
	   <div class="modal fade" id="lgmNuevo2" tabindex="-1" role="dialog">
	       <div class="modal-dialog modal-lg" role="document">
	           <div class="modal-content">
	               <div class="modal-header">
	                   <h4 class="modal-title" id="largeModalLabel">CREAR <?php echo strtoupper($singular2); ?></h4>
	               </div>
	               <div class="modal-body">
							<div class="row">
								<?php echo $frmUnidadNegocios2; ?>
							</div>

	               </div>
	               <div class="modal-footer">
	                   <button type="submit" class="btn btn-primary waves-effect nuevo">GUARDAR</button>
	                   <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
	               </div>
	           </div>
	       </div>
	   </div>
		<input type="hidden" id="accion" name="accion" value="<?php echo 'insertarClientes'; ?>"/>
	</form>


<?php echo $baseHTML->cargarArchivosJS('../../'); ?>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>
<!-- Chart Plugins Js -->


<script>
	$(document).ready(function(){


		$('.frmContfechavencimiento').hide();
		$('.frmContcoberturaactual').hide();
		$('.frmContprimaobjetivo').hide();


		$('#selction-ajax').hide();

		function traerClientescarteraPorCliente(idcliente) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerClientescarteraPorCliente', id: idcliente},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.lstCartera').html('');
					$('#selction-ajax').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.lstCartera').html(data);
						$('#selction-ajax').show();
					} else {
						$('#selction-ajax').hide();
						swal({
								title: "Respuesta",
								text: 'El cliente no posee cartera actualmente',
								type: "error",
								timer: 500,
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

		function cuestionario(idproducto,idcotizacion) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'cuestionario', id: idproducto,idcotizacion:idcotizacion},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.contCuestionario').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.contCuestionario').html(data.datos.cuestionario);
					} else {
						swal({
								title: "Respuesta",
								text: 'No existe cuestionario para este producto',
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

		function validarCuestionario(idproducto) {
			var formData = new FormData($("#wizard_with_validation")[0]);

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

					if (data.error) {
						var caderror = '';
						$.each(data.errores, function(i,item){
						caderror += 'Debe Responder la pregunta:' + data.errores[i].pregunta + '\n';  // (o el campo que necesites)
						});
						swal({
								title: "Respuesta",
								text: caderror,
								type: "error",
								timer: 4000,
								showConfirmButton: false
						});
						form.steps("previous");
					} else {
						if (data.errorinsert) {
							swal({
									title: "Respuesta",
									text: data.mensaje,
									type: "error",
									timer: 4000,
									showConfirmButton: false
							});
						} else {
							swal({
	 								title: "Respuesta",
	 								text: 'Cotizacion Guardada',
	 								type: "success",
	 								timer: 2000,
	 								showConfirmButton: false
	 						});
							$(location).attr('href', 'new.php?id='+data.idcotizacion);
						}


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

		function traerProductosPorTipo(idtipoproducto) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerProductosPorTipo', id: idtipoproducto},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#refproductos').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('#refproductos').html(data);
						cuestionario($('#refproductos').val(),<?php echo $id; ?>);
					} else {
						swal({
								title: "Respuesta",
								text: 'No existen tipos de productos',
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

		function traerTipoproductoramaPorTipoProducto(idtipoproducto) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerTipoproductoramaPorTipoProducto', id: idtipoproducto},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#refproductosrama').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('#refproductosrama').html(data);

						traerProductosPorTipo($('#refproductosrama').val());
					} else {
						swal({
								title: "Respuesta",
								text: 'No existen tipos de productos',
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

		$("#wizard_with_validation").on("change",'#existeprimaobjetivo', function(){
			if ($(this).val() == 1) {
				$('.frmContprimaobjetivo').show();

				$("#primaobjetivo").prop('required',true);

			} else {
				$('.frmContprimaobjetivo').hide();

				$("#primaobjetivo").prop('required',false);

			}
		});

		$("#wizard_with_validation").on("change",'.with-gap', function(){
			if (($(this).val() == 1) || ($(this).val() == 2)) {

				$("#refasociados").prop('required',true);

			} else {
				$("#refasociados").prop('required',false);

			}
		});


		$("#wizard_with_validation").on("change",'#tiponegocio', function(){
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

		$("#wizard_with_validation").on("change",'#reftipoproducto', function(){
			traerTipoproductoramaPorTipoProducto($(this).val());

		});

		$("#wizard_with_validation").on("change",'#refproductos', function(){
			cuestionario($(this).val(),<?php echo $id; ?>);

		});

		$("#wizard_with_validation").on("change",'#refproductosrama', function(){
			traerProductosPorTipo($(this).val());
		});

		<?php if (!(isset($_GET['id']))) { ?>
		traerTipoproductoramaPorTipoProducto($('#reftipoproducto').val());
		<?php } ?>

		function setButtonWavesEffect(event) {
			$(event.currentTarget).find('[role="menu"] li a').removeClass('waves-effect');
			$(event.currentTarget).find('[role="menu"] li:not(.disabled) a').addClass('waves-effect');
		}

		//Advanced form with validation
	    var form = $('#wizard_with_validation').show();
	    form.steps({
	        headerTag: 'h3',
	        bodyTag: 'fieldset',
	        transitionEffect: 'slideLeft',
	        onInit: function (event, currentIndex) {
	            $.AdminBSB.input.activate();

	            //Set tab width
	            var $tab = $(event.currentTarget).find('ul[role="tablist"] li');
	            var tabCount = $tab.length;
	            $tab.css('width', (100 / tabCount) + '%');

	            //set button waves effect
	            setButtonWavesEffect(event);
	        },
	        onStepChanging: function (event, currentIndex, newIndex) {
	            if (currentIndex > newIndex) { return true; }

	            if (currentIndex < newIndex) {
	                form.find('.body:eq(' + newIndex + ') label.error').remove();
	                form.find('.body:eq(' + newIndex + ') .error').removeClass('error');
	            }

	            form.validate().settings.ignore = ':disabled,:hidden';
	            return form.valid();
	        },
	        onStepChanged: function (event, currentIndex, priorIndex) {
	            setButtonWavesEffect(event);
					<?php if (!(isset($_GET['id']))) { ?>
					<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
						if (currentIndex == 4) {
							validarCuestionario($('#refproductos').val());
							//guardarCotizacion(1);
						}

						if (currentIndex == 4) {
							$('.contSubirArchivos2').hide();
							$('.contSubirArchivos1').show();
						}

						if (currentIndex == 5) {
							$('.contSubirArchivos1').hide();
							$('.contSubirArchivos2').show();
						}

						if (currentIndex < 4) {
							$('.contSubirArchivos1').hide();
							$('.contSubirArchivos2').hide();
						}


					<?php } else { ?>
						if (currentIndex == 2) {
							validarCuestionario($('#refproductos').val());
							//guardarCotizacion(1);
						}

						if (currentIndex == 3) {
							$('.contSubirArchivos2').hide();
							$('.contSubirArchivos1').show();
						}

						if (currentIndex == 4) {
							$('.contSubirArchivos1').hide();
							$('.contSubirArchivos2').show();
						}

						if (currentIndex < 3) {
							$('.contSubirArchivos1').hide();
							$('.contSubirArchivos2').hide();
						}
					<?php } ?>
					<?php } else { ?>
						<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
							if (currentIndex == 4) {
								$('.contSubirArchivos2').hide();
								$('.contSubirArchivos1').show();
							}

							if (currentIndex == 5) {
								$('.contSubirArchivos1').hide();
								$('.contSubirArchivos2').show();
							}

							if (currentIndex < 4) {
								$('.contSubirArchivos1').hide();
								$('.contSubirArchivos2').hide();
							}
						<?php } else { ?>
							if (currentIndex == 2) {
								$('.contSubirArchivos2').hide();
								$('.contSubirArchivos1').show();
							}

							if (currentIndex == 3) {
								$('.contSubirArchivos1').hide();
								$('.contSubirArchivos2').show();
							}

							if (currentIndex < 2) {
								$('.contSubirArchivos1').hide();
								$('.contSubirArchivos2').hide();
							}
						<?php } ?>
					<?php } ?>



	        },
	        onFinishing: function (event, currentIndex) {
	            form.validate().settings.ignore = ':disabled';

	            return form.valid();
	        },
	        onFinished: function (event, currentIndex) {
	            modificarCotizacion(2);
	        }
	    });

		var esconde1 = 0;
		var esconde2 = 0;

		<?php if (isset($_GET['id'])) { ?>
			cuestionario($('#refproductos').val(),<?php echo $id; ?>);
			<?php if ($_SESSION['idroll_sahilices'] != 7) { ?>
				form.steps("next");
				form.steps("next");
				form.steps("next");
				form.steps("next");
					<?php if (($i == $cargados) && (!(isset($_GET['iddocumentacion'])))) { ?>

						form.steps("next");
						//esconde2 = 1;
					<?php } ?>
			<?php } else { ?>
				form.steps("next");
				form.steps("next");
					<?php if (($i == $cargados) && (!(isset($_GET['iddocumentacion'])))) { ?>
						form.steps("next");
						//esconde2 = 1;
					<?php } ?>
			<?php } ?>
		<?php } ?>


	    form.validate({
	        highlight: function (input) {
	            $(input).parents('.form-line').addClass('error');
	        },
	        unhighlight: function (input) {
	            $(input).parents('.form-line').removeClass('error');
	        },
	        errorPlacement: function (error, element) {
	            $(element).parents('.form-group').append(error);
	        },
	        rules: {
	            'confirm': {
	                equalTo: '#password'
	            }
	        }
	    });

		$("#wizard_with_validation").on("change",'.with-gap', function(){
 			$('#lstasociados').val('');
 			$('#refasociados').html('');
			$('.asociadoSelect').html('');
 		});

		<?php

			while ($rowD = mysql_fetch_array($documentacionesrequeridas2)) {
		?>

		$('#wizard_with_validation .btn<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "new.php?id=<?php echo $id; ?>&iddocumentacion=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}

		?>

		<?php

			while ($rowD = mysql_fetch_array($documentacionesadicionales2)) {
		?>

		$('#wizard_with_validation .btnA<?php echo str_replace(' ','',$rowD['documentacion']); ?>').click(function() {
			url = "new.php?id=<?php echo $id; ?>&iddocumentaciona=<?php echo $rowD['iddocumentacion']; ?>";
			$(location).attr('href',url);
		});
		<?php
			}

		?>


		function guardarCotizacion(refestadocotizaciones) {
			$.ajax({
 				url: '../../ajax/ajax.php',
 				type: 'POST',
 				// Form data
 				//datos del formulario
 				data: {
 					accion: 'insertarCotizaciones',
 					refclientes: $('#refclientes').val(),
 					refproductos: $('#refproductos').val(),
 					refasesores: $('#refasesores').val(),
					refasociados: $('#refasociados').val(),
 					observaciones: $('#observaciones').val(),
 					cobertura: $('#cobertura').val(),
 					reasegurodirecto: $('#reasegurodirecto').val(),
 					fecharenovacion: $('#fecharenovacion').val(),
 					tiponegocio: $('#tiponegocio').val(),
 					presentacotizacion: $('#presentacotizacion').val(),
					refestadocotizaciones: refestadocotizaciones,
					fechavencimiento: $('#fechavencimiento').val(),
					coberturaactual: $('#coberturaactual').val(),
					bitacoracrea: '',
					bitacorainbursa: '',
					bitacoraagente: '',
					existeprimaobjetivo: $('#existeprimaobjetivo').val(),
					primaobjetivo: $('#primaobjetivo').val()
 				},
 				//mientras enviamos el archivo
 				beforeSend: function(){
 					$('.lstCartera').html('');
 				},
 				//una vez finalizado correctamente
 				success: function(data){

 					if (data != '') {
						swal({
 								title: "Respuesta",
 								text: 'Cotizacion Guardada',
 								type: "success",
 								timer: 2000,
 								showConfirmButton: false
 						});
						if (refestadocotizaciones == 1) {
							$(location).attr('href', 'new.php?id='+data);
						} else {
							$(location).attr('href', 'modificar.php?id='+data);
						}

 					} else {
 						swal({
 								title: "Respuesta",
 								text: 'Se genero un error y no se guardo la cotizacion',
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


		function modificarCotizacion(refestadocotizaciones) {
			$.ajax({
 				url: '../../ajax/ajax.php',
 				type: 'POST',
 				// Form data
 				//datos del formulario
 				data: {
 					accion: 'modificarCotizaciones',
 					refclientes: $('#refclientes').val(),
 					refproductos: $('#refproductos').val(),
 					refasesores: $('#refasesores').val(),
					refasociados: $('#refasociados').val(),
 					observaciones: $('#observaciones').val(),
 					cobertura: $('#cobertura').val(),
 					reasegurodirecto: $('#reasegurodirecto').val(),
 					fecharenovacion: $('#fecharenovacion').val(),
 					tiponegocio: $('#tiponegocio').val(),
 					presentacotizacion: $('#presentacotizacion').val(),
					refestadocotizaciones: refestadocotizaciones,
					fechavencimiento: $('#fechavencimiento').val(),
					coberturaactual: $('#coberturaactual').val(),
					bitacoracrea: '',
					bitacorainbursa: '',
					bitacoraagente: '',
					existeprimaobjetivo: $('#existeprimaobjetivo').val(),
					primaobjetivo: $('#primaobjetivo').val(),
					id: <?php echo $id; ?>,
					estadoactual: 2,
					fechaemitido: '<?php echo date('Y-m-d'); ?>',
					fechapropuesta: '<?php echo date('Y-m-d'); ?>',
					foliotys: ''
 				},
 				//mientras enviamos el archivo
 				beforeSend: function(){
 					$('.lstCartera').html('');
 				},
 				//una vez finalizado correctamente
 				success: function(data){

 					if (data == '') {
						swal({
 								title: "Respuesta",
 								text: 'Cotizacion Guardada',
 								type: "success",
 								timer: 2000,
 								showConfirmButton: false
 						});
						$(location).attr('href', 'modificar.php?id=<?php echo $id; ?>');

 					} else {
 						swal({
 								title: "Respuesta",
 								text: 'Se genero un error y no se guardo la cotizacion',
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


		$('.btnGuardar').click(function() {
			guardarCotizacion(3);
 		});

		$('.btnRechazar').click(function() {
			guardarCotizacion(4);
		});


		 $('#fechavencimiento').pickadate({
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


		var options = {
			url: "../../json/jsbuscarclientes.php",

			getValue: function(element) {
				return element.nombrecompleto;
			},

			ajaxSettings: {
		        dataType: "json",
		        method: "POST",
		        data: {
		            busqueda: $("#lstjugadores").val()
		        }
		    },

		    preparePostData: function (data) {
		        data.busqueda = $("#lstjugadores").val();
				  data.idasesor = <?php echo $idasesor; ?>;
		        return data;
		    },

			list: {
			   maxNumberOfElements: 15,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#lstjugadores").getSelectedItemData().id;
					$('#refclientes').html("<option value='" + value + "'>" + $("#lstjugadores").getSelectedItemData().nombrecompleto + "</option>");
					$('.clienteSelect').html($("#lstjugadores").getSelectedItemData().nombrecompleto);
					traerClientescarteraPorCliente(value);
				}/*,
				onHideListEvent: function() {
					$('.clienteSelect').html('');
					$('#selction-ajax').hide();
					$('#refclientes').html('');
				}*/
			},
			theme: "square"
		};

		$("#lstjugadores").easyAutocomplete(options);


		var options2 = {
			url: "../../json/jsbuscarasesores.php",

			getValue: function(element) {
				return element.nombrecompleto;
			},

			ajaxSettings: {
		        dataType: "json",
		        method: "POST",
		        data: {
		            busqueda: $("#lstagentes").val()
		        }
		    },

		    preparePostData: function (data) {
		        data.busqueda = $("#lstagentes").val();
				  data.idasesor = <?php echo $idasesor; ?>;
		        return data;
		    },

			list: {
			    maxNumberOfElements: 15,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#lstagentes").getSelectedItemData().id;

					$('#refasesores').html("<option value='" + value + "'>" + $("#lstagentes").getSelectedItemData().nombrecompleto + "</option>");
					$('.agenteSelect').html($("#lstagentes").getSelectedItemData().nombrecompleto);
				}
			},
			theme: "square"
		};

		$("#lstagentes").easyAutocomplete(options2);


		var options3 = {
			url: "../../json/jsbuscarasociados.php",

			getValue: function(element) {
				return element.nombrecompleto;
			},

			ajaxSettings: {
		        dataType: "json",
		        method: "POST",
		        data: {
		            busqueda: $("#lstasociados").val()
		        }
		    },

		    preparePostData: function (data) {
		        data.busqueda = $("#lstasociados").val();
				  data.tipo = $('input:radio[name=asociado]:checked').val();
		        return data;
		    },

			list: {
			    maxNumberOfElements: 15,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#lstasociados").getSelectedItemData().id;

					$('#refasociados').html("<option value='" + value + "'>" + $("#lstasociados").getSelectedItemData().nombrecompleto + "</option>");
					$('.asociadoSelect').html($("#lstasociados").getSelectedItemData().nombrecompleto);

				}
			},
			theme: "square"
		};

		$("#lstasociados").easyAutocomplete(options3);

		$('#primaobjetivo').number( true, 2 ,'.','');

		$('.frmContnumerocliente').hide();
		$('.frmContrefusuarios').hide();

		$('.btnNuevoMoral').click(function() {

			$('.frmContreftipopersonas').hide();
			$('#reftipopersonas').val(2);
			$('.frmContrazonsocial').show();

		});

		$('.btnNuevo2').click(function() {
			$('.frmContreftipopersonas').hide();
			$('#reftipopersonas').val(1);

			$('.frmContrazonsocial').hide();

		});


		$('.frmContrefusuarios').hide();

		$('.frmNuevo #fechacrea').val('2020-02-02');
		$('.frmNuevo #fechamodi').val('2020-02-02');
		$('.frmNuevo #usuariocrea').val('2020-02-02');
		$('.frmNuevo #usuariomodi').val('2020-02-02');

		$('.frmNuevo2 #numerocliente').val('123456');
		$('.frmNuevo2 #fechacrea').val('2020-02-02');
		$('.frmNuevo2 #fechamodi').val('2020-02-02');
		$('.frmNuevo2 #usuariocrea').val('2020-02-02');
		$('.frmNuevo2 #usuariomodi').val('2020-02-02');



		<?php if ($_SESSION['idroll_sahilices'] == 7) { ?>
			$('.frmContrefasociados').hide();
			$('#refasociados').prepend('<option value="0">sin valor</option>');
			$('#refasociados').val(0);
		<?php } ?>


		$('#telefonofijo').inputmask('999 9999999', { placeholder: '___ _______' });
		$('#telefonocelular').inputmask('999 9999999', { placeholder: '___ _______' });


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
			}
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

		$("#example").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','modificar.php?id=' + idTable);
		});//fin del boton modificar

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

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
							swal("Ok!", 'Se guardo correctamente la cotizacion', "success");

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


		$('.frmNuevo2').submit(function(e){

			e.preventDefault();
			if ($('.frmNuevo2')[0].checkValidity()) {


				//información del formulario
				var formData = new FormData($(".formulario")[4]);
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
									text: "Registro Creado con exito!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

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


		<?php if (($id != 0)) { ?>
		$('.guardarEstado').click(function() {
			modificarEstadoDocumentacionCotizaciones($('#refestados').val());
		});

		function modificarEstadoDocumentacionCotizaciones(idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionCotizaciones',
					iddocumentacioncotizacion: <?php echo $iddocumentacionasociado; ?>,
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
						//location.reload();
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

		function traerImagen(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idcotizacion: <?php echo $id; ?>,
						iddocumentacion: <?php echo $iddocumentacion; ?>,
						accion: 'traerDocumentacionPorCotizacionDocumentacion'},
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
			acceptedFiles: ".jpg,.jpeg,.pdf",
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
					$('.lblPlanilla').hide();
					swal("Correcto!", resp.replace("1", ""), "success");
					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
					$('#<?php echo $iddocumentacion; ?>').addClass('bg-blue');
					$('#<?php echo $iddocumentacion; ?> .number').html('Cargada');

					location.reload();
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};


		<?php if ($documentacionNombre != '') { ?>
		<?php if (($idestadodocumentacion != 5)) { ?>
		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idasociado: <?php echo $id; ?>,
				 iddocumentacion: <?php echo $iddocumentacion; ?>
			},
			url: 'subir.php'
		});
		<?php } ?>
		<?php } ?>




		/////////////////////////////////////////////////////////////////////////////////////////////////


		$('.guardarEstado2').click(function() {
			modificarEstadoDocumentacionCotizaciones2($('#refestados2').val());
		});

		function modificarEstadoDocumentacionCotizaciones2(idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionCotizaciones',
					iddocumentacioncotizacion: <?php echo $iddocumentacionasociado2; ?>,
					idestado: idestado
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.guardarEstado2').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se modifico correctamente el estado de la documentación <?php echo $campo; ?>', "success");
						$('.guardarEstado2').show();
						//location.reload();
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

		function traerImagen2(contenedorpdf, contenedor) {
			$.ajax({
				data:  {idcotizacion: <?php echo $id; ?>,
						iddocumentacion: <?php echo $iddocumentacion2; ?>,
						accion: 'traerDocumentacionPorCotizacionDocumentacion'},
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

		traerImagen2('example12','timagen12');

		<?php if (($idestadodocumentacion2 != 5)) { ?>
		var myDropzone2 = new Dropzone("#archivos2", {
			params: {
				 idasociado: <?php echo $id; ?>,
				 iddocumentacion: <?php echo $iddocumentacion2; ?>
			},
			url: 'subir.php'
		});
		<?php } ?>

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload2 = {
			maxFilesize: 30,
			acceptedFiles: ".jpg,.jpeg,.pdf",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
					formData.append("idasociado", '<?php echo $id; ?>');
					formData.append("iddocumentacion", '<?php echo $iddocumentacion2; ?>');
				});
				this.on('success', function( file, resp ){
					traerImagen2('example12','timagen12');
					$('.lblPlanilla').hide();
					swal("Correcto!", resp.replace("1", ""), "success");
					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
					$('#<?php echo $iddocumentacion2; ?>').addClass('bg-blue');
					$('#<?php echo $iddocumentacion2; ?> .number').html('Cargada');

					location.reload();
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};







		<?php } ?>
		/*
		if (esconde2 == 1) {
			$('.contSubirArchivos2').hide();
		} else {
			$('.contSubirArchivos2').show();
		}

		if (esconde1 == 1) {
			$('.contSubirArchivos1').hide();
		} else {
			$('.contSubirArchivos1').show();
		}
		*/

	});
</script>

</body>
<?php } ?>
</html>
