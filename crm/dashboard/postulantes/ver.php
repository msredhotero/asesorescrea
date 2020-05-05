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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../postulantes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Postulantes",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$id = $_GET['id'];

////////// validar solo que pueda ingrear los perfiles permitidos /////////////////////////


//////////////       FIN                  /////////////////////////////////////////////////

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Entrevista VERITA";

$plural = "Entrevista VERITA";

$eliminar = "eliminarEntrevistas";

$insertar = "insertarEntrevistas";

$modificar = "modificarEntrevistas";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$resultado 		= 	$serviciosReferencias->traerPostulantesPorId($id);

$observaciones = mysql_result($resultado,0,'observaciones');

/**************  alertas **********************************/
if (mysql_result($resultado,0,'edad') < 18) {
	$alertaEdad = '<div class="row"><div class="alert bg-red"><i class="material-icons">warning</i> El postulante es menor de edad!!!</div></div>';
} else {
	$alertaEdad = '';
}

if (mysql_result($resultado,0,'refescolaridades') < 3) {
	$alertaEscolaridad = '<div class="row"><div class="alert bg-red"><i class="material-icons">warning</i> El postulante no cumple con la Escolaridad Basica!!!</div></div>';
} else {
	$alertaEscolaridad = '';
}

if (mysql_result($resultado,0,'afore') == '1') {
	$alertaAfore = '<div class="row"><div class="alert bg-red"><i class="material-icons">warning</i><b>ATENCION</b> El postulante cuenta con cedula definitiva para venta de afore, verificar!!!</div></div>';
} else {
	$alertaAfore = '';
}

$resUsuario = $serviciosReferencias->traerUsuariosPorId(mysql_result($resultado,0,'refusuarios'));

if (mysql_result($resUsuario,0,'activo') == 'No') {
	$alertaUsuario = '<div class="row"><div class="alert bg-orange"><i class="material-icons">warning</i><b>ATENCION</b> El postulante aun no verifico su email!!!. Desea enviarle nuevamente la confirmación?
	<button type="button" class="btn bg-light-green waves-effect btnAlerta">
												<i class="material-icons">add</i>
												<span>ENVIAR</span>
											</button></div></div>';
} else {
	$alertaUsuario = '';
}


/******************** fin *********************************/

$tabla 			= "dbpostulantes";

$lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad','afore','compania','cedula','refesquemareclutamiento','nss','claveinterbancaria','idclienteinbursa','claveasesor','fechaalta','urlprueba','vigdesdecedulaseguro','vighastacedulaseguro','vigdesdeafore','vighastaafore','nropoliza','reftipopersonas','razonsocial','reforigenreclutamiento','email2','vigdesderc','vighastarc','refreferentes');
$lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad','¿Cuenta con cédula definitiva para venta de Afore?','¿Con que compañía vende actualmente?','¿Cuenta Con cedula definitiva para venta de Seguros?','Esquema de Reclutamiento','Nro de Seguro Social','Clave Interbancaria','ID Cliente Inbursa','Clave Asesor','Fecha de Alta','URL Prueba','Cedula Seg. Vig. Desde','Cedula Seg. Vig. Hasta','Afore Vig. Desde','Afore Vig. Hasta','N° Poliza','Tipo Persona','Razon Social','Origen de Reclutamiento','Email Adic.','Vig. Desde RC','Vig. Hasta RC','Promotor de Talento');

$resUsuario = $serviciosUsuario->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
$cadRef1 	= $serviciosFunciones->devolverSelectBox($resUsuario,array(1),'');

$resVar2	= $serviciosReferencias->traerEscolaridades();
$cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refescolaridades'));

$resVar3	= $serviciosReferencias->traerEstadocivil();
$cadRef3 = $serviciosFunciones->devolverSelectBoxActivo($resVar3,array(1),'',mysql_result($resultado,0,'refestadocivil'));

$resVar4	= $serviciosReferencias->traerEstadopostulantes();
$cadRef4 = $serviciosFunciones->devolverSelectBoxActivo($resVar4,array(1),'',mysql_result($resultado,0,'refestadopostulantes'));

if (mysql_result($resultado,0,'sexo') == '1') {
	$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1' selected>Femenino</option><option value='2'>Masculino</option>";
} else {
	$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1'>Femenino</option><option value='2' selected>Masculino</option>";
}

if (mysql_result($resultado,0,'afore') == '1') {
	$cadRef7 = "<option value='1' selected>Si</option><option value='0'>No</option>";
} else {
	$cadRef7 = "<option value='1'>Si</option><option value='0' selected>No</option>";
}

if (mysql_result($resultado,0,'cedula') == '1') {
	$cadRef8 = "<option value='1' selected>Si</option><option value='0'>No</option>";
} else {
	$cadRef8 = "<option value='1'>Si</option><option value='0' selected>No</option>";
}

$resVar8 = $serviciosReferencias->traerEsquemareclutamiento();
$cadRef9 = $serviciosFunciones->devolverSelectBoxActivo($resVar8,array(1),'',mysql_result($resultado,0,'refesquemareclutamiento'));

if (mysql_result($resultado,0,'codigopostal') != '') {
	$resPostal = $serviciosReferencias->traerPostalPorId(mysql_result($resultado,0,'codigopostal'));

	$codigopostal = mysql_result($resPostal,0,'codigo');
} else {
	$codigopostal = '';
}
$cadRef6 	= "<option value='Mexico'>Mexico</option>";

$tipoPersona = mysql_result($resultado,0,'reftipopersonas');
$resVar10 = $serviciosReferencias->traerTipopersonasPorId($tipoPersona);
$cadRef10 = $serviciosFunciones->devolverSelectBox($resVar10,array(1),'');

$resVar11 = $serviciosReferencias->traerOrigenreclutamiento();
$cadRef11 = $serviciosFunciones->devolverSelectBoxActivo($resVar11,array(1),'',mysql_result($resultado,0,'reforigenreclutamiento'));

if ($_SESSION['idroll_sahilices'] == 9) {
	$resVar12 = $serviciosReferencias->traerReferentesPorUsuario($_SESSION['usuaid_sahilices']);
	$cadRef12 	= "";
} else {
	$resVar12 = $serviciosReferencias->traerReferentes();
	$cadRef12 	= "<option value='0'>-- Seleccionar --</option>";
}

$cadRef12 .= $serviciosFunciones->devolverSelectBoxActivo($resVar12,array(1,2,3),' ',mysql_result($resultado,0,'refreferentes'));

$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6,6=>$cadRef7,7=>$cadRef8,8=>$cadRef9,9=> $cadRef10,10=>$cadRef11,11=>$cadRef12);
$refCampo 	=  array('refusuarios','refescolaridades','refestadocivil','refestadopostulantes','sexo','nacionalidad','afore','cedula','refesquemareclutamiento','reftipopersonas','reforigenreclutamiento','refreferentes');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaModificar($id,'idpostulante','modificarPostulantes',$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$path  = '../../archivos/postulantes/'.$id;

if (!file_exists($path)) {
	mkdir($path, 0777);
}

//////////////////////////////////////////////////////////////////////
$pathSIAP  = '../../archivos/postulantes/'.$id.'/siap';

if (!file_exists($pathSIAP)) {
	mkdir($pathSIAP, 0777);
}

$filesSIAP = array_diff(scandir($pathSIAP), array('.', '..'));
//////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////
$pathVeritas  = '../../archivos/postulantes/'.$id.'/veritas';

if (!file_exists($pathVeritas)) {
	mkdir($pathVeritas, 0777);
}

$filesVeritas = array_diff(scandir($pathVeritas), array('.', '..'));
//////////////////////////////////////////////////////////////////////

$resTest = $serviciosReferencias->traerRespuestasPorPostulante($id);

//die(var_dump(mysql_num_rows($resTest)));

$resDocumentaciones = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacionCompleta($id,mysql_result($resultado,0,'refestadopostulantes'));


// documentacion por documentacion //
$resDocumentacionAsesor1 = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacion($id, 2);

$resDocumentacion1 = $serviciosReferencias->traerDocumentacionesPorId(2);

$resEstados = $serviciosReferencias->traerEstadodocumentaciones();

if (mysql_num_rows($resDocumentacionAsesor1) > 0) {

	$cadRefEstados1 = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor1,0,'refestadodocumentaciones'));

	$iddocumentacionasesores1 = mysql_result($resDocumentacionAsesor1,0,'iddocumentacionasesor');

	$estadoDocumentacion1 = mysql_result($resDocumentacionAsesor1,0,'estadodocumentacion');

	$color1 = mysql_result($resDocumentacionAsesor1,0,'color');

	$span1 = '';
	switch (mysql_result($resDocumentacionAsesor1,0,'estadodocumentacion')) {
		case 1:
			$span1 = 'text-info glyphicon glyphicon-plus-sign';
		break;
		case 2:
			$span1 = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 3:
			$span1 = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 4:
			$span1 = 'text-danger glyphicon glyphicon-remove-sign';
		break;
		case 5:
			$span1 = 'text-success glyphicon glyphicon-remove-sign';
		break;
	}
} else {
	$cadRefEstados1 = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

	$iddocumentacionasesores1 = 0;

	$estadoDocumentacion1 = 'Falta Cargar';

	$color1 = 'blue';

	$span1 = 'text-info glyphicon glyphicon-plus-sign';
}

///////////////////////////////////////////////////////////////////////////////////////


// documentacion por documentacion //
$resDocumentacionAsesor2 = $serviciosReferencias->traerDocumentacionPorPostulanteDocumentacion($id, 1);

$resDocumentacion2 = $serviciosReferencias->traerDocumentacionesPorId(1);

if (mysql_num_rows($resDocumentacionAsesor2) > 0) {
	$resEstados = $serviciosReferencias->traerEstadodocumentaciones();
	$cadRefEstados2 = $serviciosFunciones->devolverSelectBoxActivo($resEstados,array(1),'', mysql_result($resDocumentacionAsesor2,0,'refestadodocumentaciones'));

	$iddocumentacionasesores2 = mysql_result($resDocumentacionAsesor2,0,'iddocumentacionasesor');

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
} else {
	$cadRefEstados2 = $serviciosFunciones->devolverSelectBox($resEstados,array(1),'');

	$iddocumentacionasesores2 = 0;

	$estadoDocumentacion2 = 'Falta Cargar';

	$color2 = 'blue';

	$span2 = 'text-info glyphicon glyphicon-plus-sign';
}

if (mysql_result($resultado,0,'reforigenreclutamiento') == 2) {
	$notId = 3;
} else {
	$notId = 0;
}
$resGuia = $serviciosReferencias->traerGuiasPorEsquemaEspecialJavelly(mysql_result($resultado,0,'refesquemareclutamiento'),$notId);

$resEstadoSiguiente = $serviciosReferencias->traerGuiasPorEsquemaSiguiente(mysql_result($resultado,0,'refesquemareclutamiento'), mysql_result($resultado,0,'refestadopostulantes'));

if (mysql_num_rows($resEstadoSiguiente) > 0) {
	$estadoSiguiente = mysql_result($resEstadoSiguiente,0,'refestadopostulantes');
} else {
	$estadoSiguiente = 1;
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
						<div class="header bg-blue">
							<h2>
								POSTULANTE
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
							<?php echo $alertaEdad; ?>
							<?php echo $alertaEscolaridad; ?>
							<?php echo $alertaAfore; ?>
							<?php echo $alertaUsuario; ?>
							<?php if ($_SESSION['idroll_sahilices'] != 9) { ?>
							<div class="row">
								<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
									<?php
									$lblEstado = 'complete';
									$i = 0;
									while ($rowG = mysql_fetch_array($resGuia)) {
										$i += 1;

										if ($rowG['refestadopostulantes'] == $estadoSiguiente) {
											$lblEstado = 'active';
										}

										if (($lblEstado == 'complete') || ($lblEstado == 'active')) {

											$urlAcceso = $rowG['url'].'?id='.$id;

										} else {
											if ($rowG['refestadopostulantes'] == 7) {
												$urlAcceso = $rowG['url'].'?id='.$id;
												$lblEstado = 'active';
											} else {
												$urlAcceso = 'javascript:void(0)';
											}
										}
									?>
									<div class="col-xs-2 bs-wizard-step <?php echo $lblEstado; ?>">
										<div class="text-center bs-wizard-stepnum">Paso <?php echo $i; ?></div>
										<div class="progress">
											<div class="progress-bar"></div>
										</div>
										<a href="<?php echo $urlAcceso; ?>" class="bs-wizard-dot"></a>
										<div class="bs-wizard-info text-center"><?php echo $rowG['estadopostulante']; ?></div>
									</div>
									<?php
										if ($lblEstado == 'active') {
											$lblEstado = 'disabled';
										}
									}
									?>

								</div>
							</div>
							<?php } ?>
							<form class="form" id="sign_in" role="form">
								<div class="row">
									<?php echo $frmUnidadNegocios; ?>
								</div>
								<input type="hidden" name="codigopostalaux" id="codigopostalaux" value="<?php echo mysql_result($resultado,0,'codigopostal'); ?>" />

								<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
								<div class="row"><div class="alert bg-orange"><i class="material-icons">warning</i> Recuerde que una vez cargada la Clave del Asesor, se guardara automaticamente la Fecha y Hora, y no se podrá modificar</div></div>
								<div class="button-demo">
									<button type="submit" class="btn bg-light-blue waves-effect modificarPostulante">
										<i class="material-icons">save</i>
										<span>GUARDAR</span>
									</button>
									<button type="button" class="btn bg-green waves-effect domicilioPostulante">
										<i class="material-icons">home</i>
										<span>DOMICILIO</span>
									</button>
								</div>
								<?php } ?>
							</form>


							</div>
						</div>
					</div>
				</div>
			</div> <!-- fin del container entrevistas -->


		<div class="row clearfix">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								TEST
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

							<div class="row" style="padding: 5px 20px;">
								<table class="table table-stripped table-bordered" style="width:100%">
									<thead>
										<tr>
											<th>Pregunta</th>
											<th>Respuesta</th>
										</tr>
									</thead>
									<tbody>
										<?php
										while ($rowTT = mysql_fetch_array($resTest)) {
											if ($rowTT['idpregunta'] != 7) {
										?>
										<tr>
											<td><?php echo $rowTT['pregunta']; ?></td>
											<td><?php echo $rowTT['respuesta']; ?></td>
										</tr>
										<?php
											} else {
												$resTestDetalle = $serviciosReferencias->traerRespuestasPorPostulanteDetalle($id);
												while ($rowTTD = mysql_fetch_array($resTestDetalle)) {
										?>
										<tr>
											<td><?php echo $rowTTD['pregunta']; ?></td>
											<td><?php echo '$ '.$rowTTD['valor']; ?></td>
										</tr>
										<?php
												}
											}
										}
										?>
									</tbody>

								</table>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div> <!-- fin del container entrevistas -->

		<div class="row clearfix">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								ENTREVISTAS
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
							<form class="form" id="formCountry">



								<div class="row" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Entrevistador</th>
												<th>Fecha</th>
												<th>Domicilio</th>
												<th>Codigo Postal</th>
												<th>Estado</th>
												<th>Est.Entrevista</th>
												<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
												<th>Fecha Crea</th>
												<th>Acciones</th>
												<?php } ?>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Entrevistador</th>
												<th>Fecha</th>
												<th>Domicilio</th>
												<th>Codigo Postal</th>
												<th>Estado</th>
												<th>Est.Entrevista</th>
												<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
												<th>Fecha Crea</th>
												<th>Acciones</th>
												<?php } ?>
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- fin del container entrevistas -->

			<div class="row clearfix subirImagen">
				<div class="row">
					<div class="col-xs-6 col-md-6 col-lg-6">
						<a href="javascript:void(0);" class="thumbnail timagen1">
							<img class="img-responsive">
						</a>
						<div id="example1"></div>



					</div>
					<div class="col-xs-6 col-md-6 col-lg-6">
						<a href="javascript:void(0);" class="thumbnail timagen2">
							<img class="img-responsive2">
						</a>
						<div id="example2"></div>

					</div>

				</div>



				<div class="row">

					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">

						<div class="card">
							<div class="header">
								<h2>
									CARGA/MODIFIQUE EL SIAP AQUI
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
									<div class="alert bg-<?php echo $color1; ?>">
										<h4>
											Estado: <b><?php echo $estadoDocumentacion1; ?></b>
										</h4>
									</div>
									<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
									<div class="col-xs-6 col-md-6" style="display:block">
										<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
										<div class="input-group col-md-12">
											<select class="form-control show-tick" id="refestados<?php echo $iddocumentacionasesores1; ?>" name="refestados">
												<?php echo $cadRefEstados1; ?>
											</select>
										</div>
										<button type="button" id="<?php echo $iddocumentacionasesores1; ?>" class="btn btn-primary guardarEstado" style="margin-left:0px;">Guardar Estado</button>
									</div>
									<?php } ?>
								</div>

								<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
								<form action="subir.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
									<div class="dz-message">
										<div class="drag-icon-cph">
											<i class="material-icons">touch_app</i>
										</div>
										<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>

									</div>
									<div class="fallback">

										<input name="file" type="file" id="archivos" />
										<input type="hidden" id="idpostulante" name="idpostulante" value="<?php echo $id; ?>" />



									</div>
								</form>
								<?php } ?>
							</div>
						</div>
					</div>
					<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<div class="card">
							<div class="header">
								<h2>
									CARGA/MODIFIQUE PRUEBA VERITA INBURSA AQUI
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
									<div class="alert bg-<?php echo $color2; ?>">
										<h4>
											Estado: <b><?php echo $estadoDocumentacion2; ?></b>
										</h4>
									</div>
									<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
									<div class="col-xs-6 col-md-6" style="display:block">
										<label for="reftipodocumentos" class="control-label" style="text-align:left">Modificar Estado</label>
										<div class="input-group col-md-12">
											<select class="form-control show-tick" id="refestados<?php echo $iddocumentacionasesores2; ?>" name="refestados">
												<?php echo $cadRefEstados2; ?>
											</select>
										</div>
										<button type="button" id="<?php echo $iddocumentacionasesores2; ?>" class="btn btn-primary guardarEstado" style="margin-left:0px;">Guardar Estado</button>
									</div>
									<?php } ?>
								</div>
								<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
								<form action="subir.php" id="frmFileUpload2" class="dropzone" method="post" enctype="multipart/form-data">
									<div class="dz-message">
										<div class="drag-icon-cph">
											<i class="material-icons">touch_app</i>
										</div>
										<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>

									</div>
									<div class="fallback">

										<input name="file" type="file" id="archivos2" />
										<input type="hidden" id="idpostulante" name="idpostulante" value="<?php echo $id; ?>" />



									</div>
								</form>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>

			</div> <!-- fin del container veritas -->
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
								<?php echo $frmUnidadNegociosEntrevistas; ?>
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
		                   <h4 class="modal-title" id="largeModalLabel">MODIFICAR ENTREVISTA</h4>
		               </div>
		               <div class="modal-body">
								<div class="row frmAjaxModificar">

								</div>
								<div class="row contObservacionesM">
									<div class="col-xs-12">
										<label class="label-control">Observaciones - Si cancela o rechaza la entrevista ingrese una observación</label>
										<textarea class="form-control" row="3" id="observacionesM" name="observaciones"><?php echo $observaciones; ?></textarea>
									</div>
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


<?php echo $baseHTML->cargarArchivosJS('../../'); ?>
<!-- Wait Me Plugin Js -->
<script src="../../plugins/waitme/waitMe.js"></script>

<!-- Custom Js -->
<script src="../../js/pages/cards/colored.js"></script>

<script src="../../plugins/jquery-validation/jquery.validate.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="../../js/datepicker-es.js"></script>

<script src="../../js/dateFormat.js"></script>
<script src="../../js/jquery.dateFormat.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script>

	function traerImagen(contenedorpdf, contenedor, iddocumentacion) {
		$.ajax({
			data:  {idpostulante: <?php echo $id; ?>,
					iddocumentacion: iddocumentacion,
					accion: 'traerDocumentacionPorPostulanteDocumentacion'},
			url:   '../../ajax/ajax.php',
			type:  'post',
			beforeSend: function () {

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
					$('.btnContinuar').hide();
				} else {
					$('.btnContinuar').show();
				}



			}
		});
	}

	traerImagen('example1','timagen1',2);
	traerImagen('example2','timagen2',1);

	<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
	Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

	Dropzone.options.frmFileUpload = {
		maxFilesize: 30,
		acceptedFiles: ".jpg,.jpeg,.pdf",
		accept: function(file, done) {
			done();
		},
		init: function() {
			this.on("sending", function(file, xhr, formData){
					formData.append("idpostulante", '<?php echo $id; ?>');
					formData.append("iddocumentacion", '2');
			});
			this.on('success', function( file, resp ){
				traerImagen('example1','timagen1',2);
				$('.lblPlanilla').hide();
				swal("Correcto!", resp.replace("1", ""), "success");

			});

			this.on('error', function( file, resp ){
				swal("Error!", resp.replace("1", ""), "warning");
			});
		}
	};


	Dropzone.options.frmFileUpload2 = {
			maxFilesize: 30,
			acceptedFiles: ".jpg,.jpeg,.pdf",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
					formData.append("idpostulante", '<?php echo $id; ?>');
					formData.append("iddocumentacion", '1');
	         });
				this.on('success', function( file, resp ){
					traerImagen('example2','timagen2',1);
					$('.lblComplemento').hide();
					swal("Correcto!", resp.replace("1", ""), "success");

				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};



	var myDropzone = new Dropzone("#archivos", {
		params: {
			idpostulante: <?php echo $id; ?>,
			iddocumentacion: 2
		},
		url: 'subir.php'
	});

	var myDropzone2 = new Dropzone("#archivos2", {
			params: {
				idpostulante: <?php echo $id; ?>,
				iddocumentacion: 1
	      },
			url: 'subir.php'
		});
	<?php } ?>

	$(document).ready(function(){

		<?php

		if ($tipoPersona == 2) {
		?>
		$('.frmContine').hide();
		$('.frmContcurp').hide();
		$('.frmContsexo').hide();
		$('.frmContrefescolaridades').hide();
		$('.frmContrefestadocivil').hide();
		$('.frmConttelefonocasa').hide();
		$('.frmContafore').hide();
		$('.frmContnss').hide();
		$('.frmContvigdesdeafore').hide();
		$('.frmContvighastaafore').hide();
		$('.frmContreftipopersonas').hide();
		<?php
		}
		?>


		$('#vigdesderc').pickadate({
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

		$('#vighastarc').pickadate({
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

		$('#vigdesdeafore').pickadate({
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

		$('#vighastaafore').pickadate({
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

		$('#vigdesdecedulaseguro').pickadate({
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

		$('#vighastacedulaseguro').pickadate({
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

		function enviarAlerta() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'enviarAlerta',
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se envio nuevamente la activacion al email: ' + data.leyenda, "success");
						$('.guardarEstado').show();
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

		$('.btnAlerta').click(function() {
			enviarAlerta();
		});

		$("#claveinterbancaria").attr('maxlength','18');
		$("#idclienteinbursa").attr('maxlength','8');
		$("#claveasesor").attr('maxlength','22');
		$("#nss").attr('maxlength','11');
		$("#ine").attr('maxlength','10');
		$("#curp").attr('maxlength','13');
		$("#rfc").attr('maxlength','18');


		$('.guardarEstado').click(function() {
			idTable =  $(this).attr("id");
			modificarEstadoDocumentacionPostulante($('#refestados' + idTable).val(),idTable);
		});

		function modificarEstadoDocumentacionPostulante(idestado, iddocumentacionasesores) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDocumentacionPostulante',
					iddocumentacionasesores: iddocumentacionasesores,
					idestado: idestado
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.guardarEstado').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal("Ok!", 'Se modifico correctamente el estado de la documentación', "success");
						$('.guardarEstado').show();
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

		$('#codigopostal').val('<?php echo $codigopostal; ?>');

		$(".frmAjaxModificar").on("change",'#refentrevistasucursales', function(){
			traerEntrevistasucursalesPorId($(this).val(), 'edit');
		});

		function traerEntrevistasucursalesPorId(id, contenedor) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerEntrevistasucursalesPorId',id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						if (contenedor == 'new') {
							$('.frmAjaxNuevo #domicilio').val(data.domicilio);
							$('.frmAjaxNuevo .codigopostalaux').val(data.refpostal);
							$('.frmAjaxNuevo #codigopostal').val(data.codigopostal);
						} else {
							$('.frmAjaxModificar #domicilio').val(data.domicilio);
							$('.frmAjaxModificar .codigopostalaux').val(data.refpostal);
							$('.frmAjaxModificar #codigopostal2').val(data.codigopostal);
						}

					} else {
						swal("Error!", 'Se genero un error al traer datos', "warning");

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

		$('.img-responsive').click(function() {
			srcImg =  $(this).attr("src");
			window.open(srcImg,'_blank');
		});

		$('.img-responsive2').click(function() {
			srcImg =  $(this).attr("src");
			window.open(srcImg,'_blank');
		});


		$('#fechanacimiento').pickadate({
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

		$('#fecha').bootstrapMaterialDatePicker({
			format: 'YYYY/MM/DD HH:mm',
			lang : 'mx',
			clearButton: true,
			weekStart: 1,
			time: true
		});

		<?php if ($_SESSION['idroll_sahilices'] == 1) { ?>

		$('#fechaalta').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD HH:mm:ss',
			lang : 'mx',
			clearButton: true,
			weekStart: 1,
			time: true
		});

		<?php } else { ?>
		$('#fechaalta').attr('disabled', true);
		<?php } ?>

		var options = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $("#codigopostal").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $("#codigopostal").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#codigopostal").getSelectedItemData().codigo;
					var id = $("#codigopostal").getSelectedItemData().id;
					$("#codigopostal").val(value);
					$("#codigopostalaux").val(id);

				}
			}
		};


		var options2 = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $("#codigopostal2").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $("#codigopostal2").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $("#codigopostal2").getSelectedItemData().codigo;
					$("#codigopostal2").val(value);

				}
			}
		};


		$("#codigopostal").easyAutocomplete(options);

		$('#usuariocrea').val('marcos');
		$('#usuariomodi').val('marcos');
		$('#ultimoestado').val(0);


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

		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=entrevistas&id=<?php echo $id; ?>&idestado=",
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

		$("#sign_in").submit(function(e){
			e.preventDefault();
		});

		$('#activo').prop('checked',true);

		function modificarEstadoPostulante(id, idestado) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'modificarEstadoPostulante',id: id, idestado: idestado},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnContinuar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$(location).attr('href',data);

					} else {
						swal("Error!", 'Se genero un error al modificar el estado del postulante', "warning");

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

		$('.btnContinuar').click(function() {
			modificarEstadoPostulante(<?php echo $id; ?>, 2);
		});

		function frmAjaxModificar(id, options2) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'frmAjaxModificar',tabla: 'dbentrevistas', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxModificar').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxModificar').html(data);
						$('.show-tick').selectpicker({
							liveSearch: true
						});
						$('.show-tick').selectpicker('refresh');

						$('#fecha').bootstrapMaterialDatePicker({
							format: 'YYYY/MM/DD HH:mm',
							lang : 'mx',
							clearButton: true,
							weekStart: 1,
							time: true
						});

						$("#codigopostal2").easyAutocomplete(options2);


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
						location.reload();
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

		$('.eliminar').click(function() {
			frmAjaxEliminar($('#ideliminar').val());
		});

		$("#example").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable, options2);
			$('#lgmModificar').modal();
		});//fin del boton modificar

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$('.domicilioPostulante').click(function(){
			$(location).attr('href','domicilio.php?id=<?php echo $id; ?>');
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
							swal({
									title: "Respuesta",
									text: "Registro Creado con exito!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

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


		$('.form').submit(function(e){

			e.preventDefault();
			if ($('.form')[0].checkValidity()) {


				//información del formulario
				var formData = new FormData($(".form")[0]);
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
