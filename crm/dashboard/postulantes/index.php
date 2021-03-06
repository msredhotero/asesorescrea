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

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Postulante";

$plural = "Postulantes";

$eliminar = "eliminarPostulantes";

$insertar = "insertarPostulantes";

$modificar = "modificarPostulantes";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbpostulantes";

$lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad','afore','compania','cedula','refesquemareclutamiento','vigdesdecedulaseguro','vighastacedulaseguro','vigdesdeafore','vighastaafore','nropoliza','reftipopersonas','razonsocial','reforigenreclutamiento','email2','vigdesderc','vighastarc','refreferentes');
$lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad','¿Cuenta con cédula definitiva para venta de Afore?','¿Con que compañía vende actualmente?','¿Cuenta Con cedula definitiva para venta de Seguros?','Esquema de Reclutamiento','Cedula Seg. Vig. Desde','Cedula Seg. Vig. Hasta','Afore Vig. Desde','Afore Vig. Hasta','N° Poliza','Tipo Persona','Razon Social','Origen de Reclutamiento','Email Adic.','Vig. Desde RC','Vig. Hasta RC','Promotor de Talento');


$cadRef1 	= "<option value='0'>Se genera automaticamente</option>";

$resVar2	= $serviciosReferencias->traerEscolaridades();
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1),'');

$resVar3	= $serviciosReferencias->traerEstadocivil();
$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');

$resVar4	= $serviciosReferencias->traerEstadopostulantesPorId(1);
$cadRef4 = $serviciosFunciones->devolverSelectBox($resVar4,array(1),'');

$cadOpcion = "<option value='0'>No</option><option value='1'>Si</option>";

$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1'>Femenino</option><option value='2'>Masculino</option>";

$cadRef6 	= "<option value='Mexico'>Mexico</option>";

$resVar7 = $serviciosReferencias->traerEsquemareclutamiento();
$cadRef7 = $serviciosFunciones->devolverSelectBox($resVar7,array(1),'');

$_SESSION['token'] = $serviciosReferencias->GUID();

$resVar8 = $serviciosReferencias->traerTipopersonas();
$cadRef8 = $serviciosFunciones->devolverSelectBox($resVar8,array(1),'');

$resVar9 = $serviciosReferencias->traerOrigenreclutamiento();
$cadRef9 = $serviciosFunciones->devolverSelectBox($resVar9,array(1),'');

if ($_SESSION['idroll_sahilices'] == 9) {
	$resVar10 = $serviciosReferencias->traerReferentesPorUsuario($_SESSION['usuaid_sahilices']);
	$cadRef10 	= "";
} else {
	$resVar10 = $serviciosReferencias->traerReferentes();
	$cadRef10 	= '<option value="0">-- Seleccionar --</option>';
}


$cadRef10 .= $serviciosFunciones->devolverSelectBox($resVar10,array(1,2,3),' ');

$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6,6=>$cadOpcion,7=>$cadOpcion,8=>$cadRef7,9=>$cadRef8,10=>$cadRef9,11=>$cadRef10);
$refCampo 	=  array('refusuarios','refescolaridades','refestadocivil','refestadopostulantes','sexo','nacionalidad','afore','cedula','refesquemareclutamiento','reftipopersonas','reforigenreclutamiento','refreferentes');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

if ($_SESSION['idroll_sahilices'] == 3 && ($_SESSION['usuaid_sahilices'] != 30)) {
	$resOportunidades = $serviciosReferencias->traerOportunidadesPorUsuarioDisponibles($_SESSION['usuaid_sahilices']);
	$cadRefOportunidades = $serviciosFunciones->devolverSelectBox($resOportunidades,array(1,13),' - ');

	$resGrafico = $serviciosReferencias->graficoGerenteRendimiento($_SESSION['usuaid_sahilices']);

	$completos = '';
	$completosoportunidad = '';
	$rechazados = '';
	while ($rowG = mysql_fetch_array($resGrafico)) {
		$completosoportunidad .= $rowG['completosoportunidades'].",";
		$completos .= $rowG['completos'].",";
		$rechazados .= $rowG['abandonaron'].",";
	}


	if (strlen($completosoportunidad) > 0 ) {
		$completosoportunidad = substr($completosoportunidad,0,-1);
	}

	if (strlen($completos) > 0 ) {
		$completos = substr($completos,0,-1);
	}

	if (strlen($rechazados) > 0 ) {
		$rechazados = substr($rechazados,0,-1);
	}

} else {
	$resOportunidades = $serviciosReferencias->traerOportunidadesDisponibles();
	$cadRefOportunidades = $serviciosFunciones->devolverSelectBox($resOportunidades,array(1,13),' - ');

	$resGrafico = $serviciosReferencias->graficoGerenteRendimientoTotal();

	$completos = '';
	$completosoportunidad = '';
	$rechazados = '';
	$encurso = '';
	while ($rowG = mysql_fetch_array($resGrafico)) {
		$completosoportunidad .= $rowG['completosoportunidades'].",";
		$completos .= $rowG['completos'].",";
		$rechazados .= $rowG['abandonaron'].",";
		$encurso .= $rowG['encurso'].",";
	}


	if (strlen($completosoportunidad) > 0 ) {
		$completosoportunidad = substr($completosoportunidad,0,-1);
	}

	if (strlen($completos) > 0 ) {
		$completos = substr($completos,0,-1);
	}

	if (strlen($rechazados) > 0 ) {
		$rechazados = substr($rechazados,0,-1);
	}

	if (strlen($encurso) > 0 ) {
		$encurso = substr($encurso,0,-1);
	}
}

if ($_SESSION['idroll_sahilices'] == 9) {
	$completos = '';
	$completosoportunidad = '';
	$rechazados = '';
	$encurso = '';
}

$resRoles 	= $serviciosUsuario->traerUsuariosPorRol(3);
$cadRef1 = $serviciosFunciones->devolverSelectBox($resRoles,array(3),'');

$cadRefFiltro = $cadRef1;


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
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../'); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix">

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								<?php echo strtoupper($plural); ?>
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
								<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 9) ) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="button-demo">
											<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>NUEVO - PERSONA FISICA</span>
											</button>
											<button type="button" class="btn bg-blue-grey waves-effect btnNuevoMoral" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>NUEVO - PERSONA MORAL</span>
											</button>
											<button type="button" class="btn bg-blue waves-effect btnVigente">
												<i class="material-icons">timeline</i>
												<span>VIGENTE</span>
											</button>
											<button type="button" class="btn bg-grey waves-effect btnHistorico">
												<i class="material-icons">history</i>
												<span>HISTORICO</span>
											</button>

										</div>
									</div>
								</div>
								<?php } ?>

								<div class="row contActuales" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Apellido P.</th>
												<th>Apellido M.</th>
												<th>Email</th>
												<th>Cod. Postal</th>
												<th>Fecha</th>
												<th>Dias de Gestion</th>
												<th>Estado</th>
												<?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
												<th>Tel.</th>
												<?php } ?>
												<th class="perfilS">Resp.Comercial</th>
												<th class="perfilT">Promotor</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Nombre</th>
												<th>Apellido P.</th>
												<th>Apellido M.</th>
												<th>Email</th>
												<th>Cod. Postal</th>
												<th>Fecha</th>
												<th>Dias de Gestion</th>
												<th>Estado</th>
												<?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
												<th>Tel.</th>
												<?php } ?>
												<th>Ger.Comercial</th>
												<th>Promotor</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>

								<div class="row contHistorico" style="padding: 5px 20px;">

									<table id="example2" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Apellido P.</th>
												<th>Apellido M.</th>
												<th>Email</th>
												<th>Cod. Postal</th>
												<th>Fecha</th>
												<th>Dias de Gestion</th>
												<th>Estado</th>
												<?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
												<th>Tel.</th>
												<?php } ?>
												<th class="perfilS">Resp.Comercial</th>
												<th class="perfilT">Promotor</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Nombre</th>
												<th>Apellido P.</th>
												<th>Apellido M.</th>
												<th>Email</th>
												<th>Cod. Postal</th>
												<th>Fecha</th>
												<th>Dias de Gestion</th>
												<th>Estado</th>
												<?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
												<th>Tel.</th>
												<?php } ?>
												<th>Ger.Comercial</th>
												<th>Promotor</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>

							</form>
							</div>
						</div>
					</div>

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									ESTADISTICA POSTULANTES COMPLETOS Y ABANDONADOS
								</h2>
								<ul class="header-dropdown m-r--5">
									<li class="dropdown">
										<a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
											<i class="material-icons">more_vert</i>
										</a>
										<ul class="dropdown-menu pull-right">
											<li><a href="javascript:void(0);" class="recargar">Recargar</a></li>
										</ul>
									</li>
								</ul>
							</div>
							<div class="body table-responsive">
								<canvas id="pie_chart" height="150"></canvas>
							</div>
						</div>
					</div>

				</div>
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
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
									<label for="oportunidades" class="control-label" style="text-align:left">Defina si el Prospecto proviene de una Oportunidad cargada</label>
									<div class="input-group col-md-12">
										<select class="form-control" id="refoportunidades" name="refoportunidades">
											<option value=''>-- Seleccionar --</option>
											<?php echo $cadRefOportunidades; ?>
										</select>
									</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<?php echo $frmUnidadNegocios; ?>
								<div class="col-xs-3" style="display:none">
									<select class="form-control" id="codigopostalaux" name="codigopostalaux"  required readonly />
									</select>
								</div>
								<input type="hidden" id="origen" name="origen" value="crm"/>
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


	<div class="modal fade" id="lgmDirectorio" tabindex="-1" role="dialog">
		 <div class="modal-dialog modal-lg" role="document">
			  <div class="modal-content">
					<div class="modal-header bg-blue">
						 <h4 class="modal-title" id="lblModalDirectorio"></h4>
					</div>
					<div class="modal-body">
						<div class="row contDirectorio">
						</div>
					</div>
					<div class="modal-footer">
						 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
					</div>
			  </div>
		 </div>
	</div>

	<div class="modal fade" id="lgmEstado" tabindex="-1" role="dialog">
		 <div class="modal-dialog modal-lg" role="document">
			  <div class="modal-content">
					<div class="modal-header bg-orange">
						 <h4 class="modal-title" id="lblModalEstado">MODIFICAR ESTADO POSTULANTE HISTORICO</h4>
					</div>
					<div class="modal-body">
						<div class="row contDirectorio">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrefusuarios" style="display:block">
								<label for="refusuarios" class="control-label" style="text-align:left">Seleccione un Nuevo Estado  <span style="color:red;">*</span> </label>
									<div class="form-group input-group col-md-12">
										<div class="form-line focused">
										<select class="form-control" id="refestadonuevo" name="refestadonuevo" required="" aria-required="true">
											<option value="9">Rechazado</option>
											<option value="12">Rechazo SIAP</option>
											<option value="13">Rechazo Veritas</option>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-warning waves-effect modificarEstadoRechazo" data-dismiss="modal">MODIFICAR</button>
						 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
					</div>
			  </div>
		 </div>
	</div>
	<input type="hidden" name="refpostulantesestado" id="refpostulantesestado" />

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

<!-- Chart Plugins Js -->
<script src="../../plugins/chartjs/Chart.bundle.js"></script>

<script>
	$(document).ready(function(){

		$('.modificarEstadoRechazo').click(function() {
			modificarEstadoDeRechazopostulantes();
		});

		function modificarEstadoDeRechazopostulantes() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarEstadoDeRechazopostulantes',
					id: $('#refpostulantesestado').val(),
					idestado: $('#refestadonuevo').val()
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error) {
						swal({
								title: "Respuesta",
								text: data,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});
					} else {
						swal({
								title: "Respuesta",
								text: 'Se modifico correctamente el estado',
								type: "success",
								timer: 2000,
								showConfirmButton: false
						});
						table2.ajax.reload();

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


		function traerInformeDeDocumentaciones(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerInformeDeDocumentaciones', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#lblModalDirectorio').html();
					$('.contDirectorio').html();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('#lgmDirectorio').modal();
						$('#lblModalDirectorio').html(data.titulo);
						$('.contDirectorio').html(data.contenido);
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

		$('.contHistorico').hide();

		$('.btnHistorico').click(function() {
			$('.contHistorico').show();
			$('.contActuales').hide();
		});

		$('.btnVigente').click(function() {
			$('.contActuales').show();
			$('.contHistorico').hide();
		});

		$('.btnNuevoMoral').click(function() {
			$('.frmContsexo').hide();
			$('.frmContrefescolaridades').hide();
			$('.frmContrefestadocivil').hide();
			$('.frmConttelefonocasa').hide();
			$('.frmContafore').hide();
			$('.frmContnss').hide();
			$('.frmContvigdesdeafore').hide();
			$('.frmContvighastaafore').hide();
			$('.frmContreftipopersonas').hide();
			$('#refescolaridades').val(6);
			$('#refestadocivil').val(7);
			$('#reftipopersonas').val(2);
			$('#refesquemareclutamiento option[value="1"]').prop("disabled","true");
			$('#refesquemareclutamiento option[value="2"]').prop("disabled","true");
			$('#refesquemareclutamiento option[value="3"]').prop("disabled","true");
			$('#refesquemareclutamiento option[value="4"]').prop("disabled","true");
			$('#refesquemareclutamiento option[value="5"]').removeAttr("disabled");
			$('#refesquemareclutamiento option[value="6"]').removeAttr("disabled");
			$('#refesquemareclutamiento').val(5);
			$('#sexo').val(1);
			$('.frmContrazonsocial').show();

		});

		$('.btnNuevo').click(function() {
			$('.frmContsexo').show();
			$('.frmContrefescolaridades').show();
			$('.frmContrefestadocivil').show();
			$('.frmConttelefonocasa').show();
			$('.frmContafore').show();
			$('.frmContnss').show();
			$('.frmContvigdesdeafore').show();
			$('.frmContvighastaafore').show();
			$('.frmContreftipopersonas').hide();
			$('#refescolaridades').val(6);
			$('#refestadocivil').val(7);
			$('#reftipopersonas').val(1);

			$('#refesquemareclutamiento option[value="1"]').removeAttr("disabled");
			$('#refesquemareclutamiento option[value="2"]').removeAttr("disabled");
			$('#refesquemareclutamiento option[value="3"]').removeAttr("disabled");
			$('#refesquemareclutamiento option[value="4"]').removeAttr("disabled");
			$('#refesquemareclutamiento option[value="5"]').prop("disabled","true");
			$('#refesquemareclutamiento option[value="6"]').prop("disabled","true");
			$('#refesquemareclutamiento').val(1);
			$('.frmContrazonsocial').hide();

		});


		new Chart(document.getElementById("pie_chart").getContext("2d"), getChartJs('pie'));

		<?php if ($_SESSION['idroll_sahilices'] == 3) { ?>
		function getChartJs(type) {
			 var config = null;

			 if (type === 'pie') {
				config = {
					 type: 'pie',
					 data: {
						  datasets: [{
							   data: [<?php echo $completosoportunidad; ?>,<?php echo $rechazados; ?>,<?php echo $completos; ?>],
							   backgroundColor: [
									 "rgb(12, 241, 8)",
									 "rgb(252, 12, 12)",
									 "rgb(5, 187, 5)",
									 "rgb(139, 195, 74)"
							   ],
						  }],
						  labels: [
							   "Concluidos x Oportunidad",
							   "Rechazados",
							   "Concluidos",
							   "Light Green"
						  ]
					 },
					 options: {
						  responsive: true,
						  legend: false
					 }
				}
			}
			return config;
		}

		<?php } else { ?>
			function getChartJs(type) {
				 var config = null;

				 if (type === 'pie') {
					config = {
						 type: 'pie',
						 data: {
							  datasets: [{
								   data: [<?php echo $rechazados; ?>,<?php echo ($completos + $completosoportunidad); ?>,<?php echo $encurso; ?>],
								   backgroundColor: [
										 "rgb(252, 12, 12)",
										 "rgb(5, 187, 5)",
										 "rgb(26, 213, 250)"
								   ],
							  }],
							  labels: [
								   "Rechazados",
								   "Concluidos",
								   "Agente Asociado"
							  ]
						 },
						 options: {
							  responsive: true,
							  legend: false
						 }
					}
				}
				return config;
			}
		<?php } ?>


		$('#refoportunidades').change(function() {
			traerOportunidadesPorId($(this).val());
		});

		function traerOportunidadesPorId(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerOportunidadesPorId',id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error === false) {
						$('#apellidopaterno').val(data.apellidopaterno);
						$('#apellidomaterno').val(data.apellidomaterno);
						$('#nombre').val(data.nombre);
						$('#telefonomovil').val(data.telefonomovil);
						$('#telefonotrabajo').val(data.telefonotrabajo);
						$('#email').val(data.email);
						$('#razonsocial').val(data.nombredespacho);


					} else {
						$('#apellidopaterno').val('');
						$('#apellidomaterno').val('');
						$('#nombre').val('');
						$('#telefonomovil').val('');
						$('#telefonotrabajo').val('');
						$('#email').val('');
						$('#razonsocial').val('');
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}

		$('#compania').prop('readOnly',true);

		$('#token').val('se genera automaticamente');
		$('#token').prop('readOnly',true);

		$('#afore').change(function() {
			if ($(this).val() == 1) {
				$('#compania').prop('readOnly',false);
			} else {
				$('#compania').prop('readOnly',true);
				$('#compania').val('');
			}
		});

		$('#telefonomovil').inputmask('999 9999999', { placeholder: '___ _______' });
		$('#telefonocasa').inputmask('999 9999999', { placeholder: '___ _______' });
		$('#telefonotrabajo').inputmask('999 9999999', { placeholder: '___ _______' });


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
					$("#codigopostal").val(value);

				}
			}
		};


		$("#codigopostal").easyAutocomplete(options);

		$('#usuariocrea').val('marcos');
		$('#usuariomodi').val('marcos');
		$('#ultimoestado').val(0);

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




		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=postulantes",
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
              },
				  <?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
				  { "orderable": false, "targets": 9 },
				  { "orderable": false, "targets": 10 }
				  <?php } else { ?>
					{ "orderable": false, "targets": 8 },
 				  { "orderable": false, "targets": 9 }
					<?php }  ?>
          ],
			"rowCallback": function( row, data, index ) {
				if (data[6] > 20) {
					$('td', row).css('background-color', '#F62121');
					$('td', row).css('color', 'white');
				}
			}
		});

		$("#example .perfilS").each( function ( i ) {
			<?php
			if ($_SESSION['idroll_sahilices'] == 3 && $_SESSION['usuaid_sahilices'] != 30) {
				$cadRefFiltro = '<option value="">'.$_SESSION['nombre_sahilices'].'</option>';
			}
			?>
			var select = $('<select><option value="">-- Seleccione Perfil --</option><?php echo $cadRefFiltro; ?></select>')
				.appendTo( $(this).empty() )
				.on( 'change', function () {
					table.column( i )
						.search( $(this).val() )
						.draw();
				} );
			table.column( i ).data().unique().sort().each( function ( d, j ) {
				select.append( '<option value="'+d+'">'+d+'</option>' )
			} );
		} );

		$('#example tbody').on('dblclick', 'tr', function () {
			var data = table.row( this ).data();
			<?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
			var str = data[11];
			<?php } else { ?>
			var str = data[10];
			<?php } ?>

			var indexId = str.indexOf('id=');

			var str2 = str.slice(indexId + 4, str.length);
			var indexId2 = str2.indexOf('"');
			var idTabla = str.slice(indexId + 4, indexId + 4 + indexId2);

			traerInformeDeDocumentaciones(idTabla);

		});


		var table2 = $('#example2').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=postulanteshistorico",
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
              },
				  <?php if ($_SESSION['idroll_sahilices'] == 1 || $_SESSION['idroll_sahilices'] == 4 || $_SESSION['idroll_sahilices'] == 8 || $_SESSION['idroll_sahilices'] == 3) { ?>
				  { "orderable": false, "targets": 9 },
				  { "orderable": false, "targets": 10 }
				  <?php } else { ?>
					{ "orderable": false, "targets": 8 },
 				  { "orderable": false, "targets": 9 }
					<?php }  ?>
          ],
			"rowCallback": function( row, data, index ) {
				if (data[6] > 20) {
					$('td', row).css('background-color', '#F62121');
					$('td', row).css('color', 'white');
				}
			}
		});

		$("#example2 .perfilS").each( function ( i ) {
			<?php
			if ($_SESSION['idroll_sahilices'] == 3 && $_SESSION['usuaid_sahilices'] != 30) {
				$cadRefFiltro = '<option value="">'.$_SESSION['nombre_sahilices'].'</option>';
			}
			?>
			var select = $('<select><option value="">-- Seleccione Perfil --</option><?php echo $cadRefFiltro; ?></select>')
				.appendTo( $(this).empty() )
				.on( 'change', function () {
					table2.column( i )
						.search( $(this).val() )
						.draw();
				} );
			table2.column( i ).data().unique().sort().each( function ( d, j ) {
				select.append( '<option value="'+d+'">'+d+'</option>' )
			} );
		} );

		$('#example2 tbody').on('click', '.btnEstado', function () {
			idTable =  $(this).attr("id");
			var rowT = $(this).closest('tr');

			var data = table2.row(rowT).data();

			var rowEstado = data[7];

			$('#refpostulantesestado').val(idTable);

			if (( rowEstado.trim() == 'Rechazado') || (rowEstado.trim() == 'Rechazo SIAP') || (rowEstado.trim() == 'Rechazo Veritas')) {
				$('#lgmEstado').modal();
			} else {
				swal({
						title: "Respuesta",
						text: 'Solo se pueden modificar los estados de Rechazado, Rechazo SIAP y Rechazo Veritas del historial. Estado Actual:' + rowEstado,
						type: "error",
						timer: 2000,
						showConfirmButton: false
				});
			}



		});//fin del boton eliminar



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
						if (data == 'index.php') {
							swal("Importante!", 'El proceso de reclutamiento ya concluyo en el estado actual.', "warning");
						} else {
							$(location).attr('href',data);
						}

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
			frmAjaxModificar(idTable);
		});//fin del boton modificar

		$("#example").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example2").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','ver.php?id=' + idTable);

		});//fin del boton modificar

		$("#example2").on("click",'.btnDocumentacion', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href','documentacioni.php?id=' + idTable);

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
							swal("Ok!", 'Se guardo correctamente el formulario, cuando el Prospecto para Asesor confirme su email podra continuar con el Proceso de Reclutamiento', "success");

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
