<?php


session_start();

date_default_timezone_set('America/Mexico_City');

$fecha = date('Y-m-d H:i:s');

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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../oportunidades/');
//*** FIN  ****/

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Oportunidades",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Oportunidad";

$plural = "Oportunidades";

$eliminar = "eliminarOportunidades";

$insertar = "insertarOportunidades";

$modificar = "modificarOportunidades";

//////////////////////// Fin opciones ////////////////////////////////////////////////

$resUsuarios = $serviciosReferencias->traerUsuariosPorId($_SESSION['usuaid_sahilices']);

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dboportunidades";

$lblCambio	 	= array('nombredespacho','refusuarios','refreferentes','refestadooportunidad','apellidopaterno','apellidomaterno','telefonomovil','telefonotrabajo','refmotivorechazos','reforigenreclutamiento');
$lblreemplazo	= array('Nombre del Despacho','Asignar a Gerente','Persona que Recomendo','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Trabajo','Motivos de Rechazos','Origen de Reclutamiento');


$resRoles 	= $serviciosUsuario->traerUsuariosPorRol(3);
$cadRef1 = $serviciosFunciones->devolverSelectBox($resRoles,array(3),'');


if (($_SESSION['idroll_sahilices'] == 9) || ($_SESSION['idroll_sahilices'] == 6)) {
	$resReferentes 	= $serviciosReferencias->traerReferentesPorUsuario($_SESSION['usuaid_sahilices']);
	$cadRef2 = "";
	$cadRefFiltro = '<option value="">'.$_SESSION['nombre_sahilices'].'</option>';
} else {

	$resReferentes 	= $serviciosReferencias->traerReferentes();
	$cadRef2 = '<option value="">-- Seleccionar --</option>';
	$resReferentesUsuarios = $serviciosReferencias->traerReferentesUsuario();
	$cadRefFiltro = $cadRef1;
}


$cadRef2 .= $serviciosFunciones->devolverSelectBox($resReferentes,array(1,2,3),' ');


$resEstado 	= $serviciosReferencias->traerEstadooportunidadPorId(1);
$cadRef3 = $serviciosFunciones->devolverSelectBox($resEstado,array(1),' ');

$resMotivos = $serviciosReferencias->traerMotivorechazos();
$cadRef4 = "<option value=''>-- Seleccionar --</option>";
$cadRef4 .= $serviciosFunciones->devolverSelectBox($resMotivos,array(1),' ');

$resGeneralEstado 	= $serviciosReferencias->traerEstadogeneraloportunidadPorId(1);
$cadRef5 = $serviciosFunciones->devolverSelectBox($resGeneralEstado,array(1),' ');

if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4)) {
	$resVar9 = $serviciosReferencias->traerOrigenreclutamiento();
} else {
	if (mysql_result($resUsuarios,0,'refsocios') == '') {
		$resVar9 = $serviciosReferencias->traerOrigenreclutamiento();
	} else {
		$resVar9 = $serviciosReferencias->traerOrigenreclutamientoPorId(mysql_result($resUsuarios,0,'refsocios'));
	}
}

$cadRef9 = $serviciosFunciones->devolverSelectBox($resVar9,array(1),'');

$refdescripcion = array(0 => $cadRef1,1=>$cadRef2,2=>$cadRef3,3=>$cadRef4,4=>$cadRef5,5=>$cadRef9);
$refCampo 	=  array('refusuarios','refreferentes','refestadooportunidad','refmotivorechazos','refestadogeneraloportunidad','reforigenreclutamiento');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resTipoCita 	= $serviciosReferencias->traerTipocita(1);
$cadRefTipoCita = $serviciosFunciones->devolverSelectBox($resTipoCita,array(1),' ');

$resEstadoCita = $serviciosReferencias->traerEstadoentrevistasPorId(1);
$cadRefCita = $serviciosFunciones->devolverSelectBox($resEstadoCita,array(1),'');

$resEstado2 	= $serviciosReferencias->traerEstadooportunidad();
$cadRef33 = '<option value="">-- Seleccionar --</option>';
$cadRef33 .= $serviciosFunciones->devolverSelectBox2($resEstado2,array(1),' ');

$cadRefAsinados = "<option value='0'>No</option><option value='1'>Si</option>"
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

	<link rel="stylesheet" type="text/css" href="../../css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="../../css/classic.date.css"/>


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


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2 style="color:white;">
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

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="button-demo">
											<?php if ($_SESSION['idroll_sahilices'] != 3) { ?>
											<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>NUEVO</span>
											</button>
											<?php } ?>
											<button type="button" class="btn bg-blue waves-effect btnVigente">
												<i class="material-icons">timeline</i>
												<span>VIGENTE</span>
											</button>
											<button type="button" class="btn bg-grey waves-effect btnHistorico">
												<i class="material-icons">history</i>
												<span>HISTORICO</span>
											</button>
											<?php if ($_SESSION['idroll_sahilices'] == 4) { ?>
											<button type="button" class="btn bg-blue-grey waves-effect btnSubirArchivo" onClick="document.location.href='subirexcel.php'">
												<i class="material-icons">unarchive</i>
												<span>SUBIR ARCHIVO</span>
											</button>
											<?php } ?>
											<?php if ($_SESSION['idroll_sahilices'] == 8) { ?>
												<button type="button" class="btn bg-deep-orange waves-effect btnPendientes">
													<i class="material-icons">assignment_late</i>
													<span>PENDIENTES DE REVISION</span>
												</button>
											<?php } ?>

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<?php echo $serviciosFunciones->addInput('3,3,3,6','text','fechadesde_filtro','fechadesde_filtro','datepicker', 'Fecha Desde'); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','text','fechahasta_filtro','fechadesde_filtro','datepicker', 'Fecha Hasta'); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','select','estado_filtro','estado_filtro','', 'Estado','',$cadRef33); ?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','select','asignados_filtro','asignados_filtro','', 'Asignados','',$cadRefAsinados); ?>
									</div>
									<div class="col-lg-12 col-md-12">
										<button type="button" class="btn bg-red" id="filtrar">Filtrar</button>
									</div>
								</div>


								<div class="row contActuales" style="padding: 5px 20px;">
									<h4>VIGENTE</h4>
									<hr>
									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cita</th>
												<th>Nombre Despacho</th>
												<th>Nombre Completo</th>
												<th>Tel. Movil</th>
												<th>Tel. Trabajo</th>
												<th>Email</th>
												<th class="perfilS">Resp.Comercial</th>
												<th>Estado</th>
												<th>Ref.</th>
												<th>Fecha</th>
												<th>Dias en Gestion</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Cita</th>
												<th>Nombre Despacho</th>
												<th>Nombre Completo</th>
												<th>Tel. Movil</th>
												<th>Tel. Trabajo</th>
												<th>Email</th>
												<th>Resp.Comercial</th>
												<th>Estado</th>
												<th>Ref.</th>
												<th>Fecha</th>
												<th>Dias en Gestion</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>

								</div>
								<div class="row contHistorico" style="padding: 5px 20px;">
									<h4>HISTORICO</h4>
									<hr>
									<table id="example2" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Nombre Despacho</th>
												<th>Nombre Completo</th>
												<th>Tel. Movil</th>
												<th>Tel. Trabajo</th>
												<th>Email</th>
												<th class="perfilSS">Resp.Comercial</th>
												<th>Estado</th>
												<th>Ref.</th>
												<th>Fecha</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Nombre Despacho</th>
												<th>Nombre Completo</th>
												<th>Tel. Movil</th>
												<th>Tel. Trabajo</th>
												<th>Email</th>
												<th>Resp.Comercial</th>
												<th>Estado</th>
												<th>Ref.</th>
												<th>Fecha</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>

								<div class="row contPendientes" style="padding: 5px 20px;">
									<h4>PENDIENTES DE REVISION</h4>
									<hr>
									<table id="example3" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Nombre Despacho</th>
												<th>Nombre Completo</th>
												<th>Tel. Movil</th>
												<th>Tel. Trabajo</th>
												<th>Email</th>
												<th class="perfilSS">Resp.Comercial</th>
												<th>Estado</th>
												<th>Ref.</th>
												<th>Fecha</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Nombre Despacho</th>
												<th>Nombre Completo</th>
												<th>Tel. Movil</th>
												<th>Tel. Trabajo</th>
												<th>Email</th>
												<th>Resp.Comercial</th>
												<th>Estado</th>
												<th>Ref.</th>
												<th>Fecha</th>
												<th>Acciones</th>
											</tr>
										</tfoot>
									</table>
								</div>
							</form>
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
	                  	<?php echo $frmUnidadNegocios; ?>
							</div>
							<div class="row">
								<div class="alert bg-orange">
									* El campo email no es requerido pero es un campo relevante
								</div>
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
								<div class="row frmEntrevistaoportunidad">

									<input type="hidden" class="form-control" id="refoportunidades" name="refoportunidades" >



									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContentrevistador" style="display:block">
										<label class="form-label">Entrevistador</label>
										<div class="form-group input-group">
											<div class="form-line">
												<input type="text" class="form-control" id="entrevistador" name="entrevistador" value="<?php echo $_SESSION['nombre_sahilices']; ?>">
											</div>
										</div>
									</div>


									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContfecha" style="display:block">
										<b>Fecha</b>
										<div class="input-group">
											<span class="input-group-addon">
												 <i class="material-icons">date_range</i>
											</span>
	                              <div class="form-line">
										   	<input readonly="readonly" style="width:200px;" type="text" class="datepicker form-control" id="fecha" name="fecha" data-dtp="dtp_PkrpV">
	                              </div>
	                           </div>
                           </div>

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrefestadoentrevistas" style="display:none;">
										<label for="refestadoentrevistas" class="control-label" style="text-align:left">Estado</label>
										<div class="input-group col-md-12">
											<select class="form-control" id="refestadoentrevistas" name="refestadoentrevistas">
												<?php echo $cadRefCita; ?>
											</select>
										</div>
									</div>

									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContreftipocita" style="display:block">
										<label class="form-label">Tipo Cita</label>
										<div class="form-group">
											<div class="form-line">
												<select class="form-control" id="reftipocita" name="reftipocita">
													<?php echo $cadRefTipoCita; ?>
												</select>

											</div>
										</div>
									</div>
								</div>
		               </div>
		               <div class="modal-footer">
								<?php if (($_SESSION['idroll_sahilices'] == 4) || ($_SESSION['idroll_sahilices'] == 1)) { ?>
								<button id="btnPendienteRevision" type="button" class="btn bg-deep-orange waves-effect btnPendienteRevision" data-accesible="no" data-dismiss="modal">PASAR A REVISION</button>
								<?php } ?>
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

		<!-- REASIGNAR -->
			<form class="formulario frmAsignar" role="form" id="sign_in">
				<div class="modal fade" id="lgmReasignar" tabindex="-1" role="dialog">
					 <div class="modal-dialog modal-lg" role="document">
						  <div class="modal-content">
								<div class="modal-header">
									 <h4 class="modal-title" id="largeModalLabel">REASIGNAR OPORTUNIDAD</h4>
								</div>
								<div class="modal-body">
									<div class="row frmAjaxReasignar">
									</div>
								</div>
								<div class="modal-footer">
									 <button type="submit" class="btn bg-deep-orange waves-effect reasignar">REASIGNAR</button>
									 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
								</div>
						  </div>
					 </div>
				</div>
				<input type="hidden" id="accion" name="accion" value="asinar"/>
				<input type="hidden" id="idasignar" name="idasignar" value=""/>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>


<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script>
	$(document).ready(function(){


		$('.frmContrefmotivorechazos').hide();

		$('#fechadesde_filtro').pickadate({
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

		$('#fechahasta_filtro').pickadate({
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

		$('.contHistorico').hide();
		$('.contPendientes').hide();
		$('.frmContAsignados').hide();

		$('.btnPendientes').click(function() {
			$('.contHistorico').hide();
			$('.contActuales').hide();
			$('.contPendientes').show();
			$('.frmContAsignados').hide();
		});

		$('.btnHistorico').click(function() {
			$('.contHistorico').show();
			$('.contActuales').hide();
			$('.contPendientes').hide();
			$('.frmContAsignados').show();
		});

		$('.btnVigente').click(function() {
			$('.contActuales').show();
			$('.contHistorico').hide();
			$('.contPendientes').hide();
			$('.frmContAsignados').hide();
		});


		function traerEntrevistasucursalesPorOportunidad(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'traerEntrevistaoportunidadesPorOportunidad',id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						if (data.error == false) {
							$('.frmEntrevistaoportunidad #fecha').val(data.fecha);
							$('.frmEntrevistaoportunidad #reftipocita').val(data.reftipocita);
							$('.frmEntrevistaoportunidad').show();
						} else {
							$('.frmEntrevistaoportunidad').hide();
							$('.frmEntrevistaoportunidad #fecha').val(data.fecha);
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



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=oportunidades",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "estado", "value": $('#estado_filtro').val(), } );
				$.getJSON( sSource, aoData, function (json) {
				/* Do whatever additional processing you want on the callback, then tell DataTables */
				fnCallback(json)
				} );
			},
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
		   "rowCallback": function( row, data, index ) {
			  if (data[10] > 15) {
				  $('td', row).css('background-color', '#F62121');
				  $('td', row).css('color', 'white');
			  }
		   },
			"columnDefs": [
		    { "orderable": false, "targets": 6 }
		 	],

		});

		$('#filtrar').click( function() {
			table.draw();
			table2.draw();
		} );

		var table2 = $('#example2').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=oportunidadeshistorico",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "estado", "value": $('#estado_filtro').val(), } );
				aoData.push( { "name": "asigandos", "value": $('#asignados_filtro').val(), } );
				$.getJSON( sSource, aoData, function (json) {
				/* Do whatever additional processing you want on the callback, then tell DataTables */
				fnCallback(json)
				} );
			},
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
		    { "orderable": false, "targets": 5 }
		 	],
		});


		var table3 = $('#example3').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=oportunidadespendientes",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "estado", "value": $('#estado_filtro').val(), } );
				$.getJSON( sSource, aoData, function (json) {
				/* Do whatever additional processing you want on the callback, then tell DataTables */
				fnCallback(json)
				} );
			},
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
		    { "orderable": false, "targets": 5 }
		 	],
		});

		<?php
		if ($_SESSION['idroll_sahilices'] == 3 ) {
			$cadRefFiltro = '<option value="">'.$_SESSION['nombre_sahilices'].'</option>';
		}
		?>
		$("#example .perfilS").each( function ( i ) {

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

		$("#example2 .perfilSS").each( function ( i ) {
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


		$("#example3 .perfilSS").each( function ( i ) {
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
				data: {accion: 'frmAjaxModificar',tabla: '<?php echo $tabla; ?>', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxModificar').html('');
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxModificar').html(data);

						<?php if ($_SESSION['idroll_sahilices'] == 8) { ?>
							$('.frmEntrevistaoportunidad').hide();

						<?php } else { ?>
						$('.frmEntrevistaoportunidad #entrevistador').val($('.frmAjaxModificar #refusuarios option:selected').html());

						$('#refoportunidades').val(id);

						traerEntrevistasucursalesPorOportunidad(id);

						$('.frmEntrevistaoportunidad #fecha').bootstrapMaterialDatePicker({
							format: 'YYYY/MM/DD HH:mm',
							lang : 'mx',
							clearButton: true,
							weekStart: 1,
							time: true,
							minDate : new Date()
						});



						<?php } ?>

						if ($('#refestadooportunidad option:selected').val() == 4) {
							$('.frmContrefmotivorechazos').show();
						} else {
							$('.frmContrefmotivorechazos').hide();
						}

						/*alert($('.frmAjaxModificar #refestadogeneraloportunidad option:selected').val());*/
						if (($('.frmAjaxModificar #refestadooportunidad option:selected').val() <= 2) || ($('.frmAjaxModificar #refestadooportunidad option:selected').val() == 3) || ($('.frmAjaxModificar #refestadooportunidad option:selected').val() == 7)) {
							$('.btnPendienteRevision').hide();
							$( "#btnPendienteRevision" ).data( "accesible",'No' );
						} else {
							if ($('.frmAjaxModificar #refestadooportunidad option:selected').val() == 8) {
								$('.btnPendienteRevision').hide();
								$( "#btnPendienteRevision" ).data( "accesible",'No' );
							} else {

								if ($('.frmAjaxModificar #refestadogeneraloportunidad option:selected').val() == 3) {
									$('.btnPendienteRevision').removeClass('bg-deep-orange');
									$('.btnPendienteRevision').addClass('bg-green');
									$('.btnPendienteRevision').html('REVISION ASIGNADA');
									$( "#btnPendienteRevision" ).data( "accesible",'No' );

								} else {
									if ($('.frmAjaxModificar #refestadogeneraloportunidad option:selected').val() == 2) {
										$('.btnPendienteRevision').hide();
										$( "#btnPendienteRevision" ).data( "accesible",'No' );
									} else {
										$('.btnPendienteRevision').show();
										$('.btnPendienteRevision').addClass('bg-deep-orange');
										$('.btnPendienteRevision').removeClass('bg-green');
										$('.btnPendienteRevision').html('PASAR A REVISION');
										$( "#btnPendienteRevision" ).data( 'accesible','Si' );
									}


								}
							}
						}


						<?php if ($_SESSION['idroll_sahilices'] == 3) { ?>
							$('.frmContrefusuarios').hide();
							$('.frmContrefreferentes').hide();
						<?php } ?>





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

		$('#btnPendienteRevision').click(function() {
			var idTablaMod = $('.frmAjaxModificar #id').val();
			if ($( "#btnPendienteRevision" ).data( "accesible") == 'Si') {
				Revision(idTablaMod);
			} else {
				swal({
						title: "Respuesta",
						text: 'No se puede pasar a revision verifique',
						type: "error",
						timer: 2000,
						showConfirmButton: false
				});
			}

		});


		function Revision(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'Revision', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
						swal({
								title: "Respuesta",
								text: 'Oportunidad enviada a revision',
								type: "success",
								timer: 1500,
								showConfirmButton: false
						});
						table.ajax.reload();
						table2.ajax.reload();
					} else {

						$(".frmAjaxReasignar").html('<h4>No es posible pasar a revision esta oportunidad (Verificar)</h4>');
						$('#idasignar').val('');
						$('.reasignar').hide();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});

		}

		function Reasignar(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'Reasignar', id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.frmAjaxReasignar').html('');
					$('.reasignar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data != '') {
						$('.frmAjaxReasignar').html(data);
						$('.reasignar').show();
					} else {

						$(".frmAjaxReasignar").html('<h4>No es posible reasignar esta oportunidad, debe estar en estado No Atendido o ya fue reasignada (Verificar)</h4>');
						$('#idasignar').val('');
						$('.reasignar').hide();
					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});

		}

		function reenviarActivacion(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'reenviarActivacion', idusuario: id},
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
								timer: 1500,
								showConfirmButton: false
						});

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

		$("#example").on("click",'.btnEnviar', function(){
			idTable =  $(this).attr("id");
			reenviarActivacion(idTable);
		});//fin del boton eliminar

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

		$("#example2").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar

		$("#example3").on("click",'.btnModificar', function(){
			idTable =  $(this).attr("id");
			frmAjaxModificar(idTable);
			$('#lgmModificar').modal();
		});//fin del boton modificar


		$("#example2").on("click",'.btnReasignar', function(){
			idTable =  $(this).attr("id");
			$('#idasignar').val(idTable);
			Reasignar(idTable);
			$('#lgmReasignar').modal();
		});//fin del boton modificar

		$("#example3").on("click",'.btnReasignar', function(){
			idTable =  $(this).attr("id");
			$('#idasignar').val(idTable);
			Reasignar(idTable);
			$('#lgmReasignar').modal();
		});//fin del boton modificar

		$(".frmAjaxModificar").on("change",'#refusuarios', function(){
			$('.frmEntrevistaoportunidad #entrevistador').val($('.frmAjaxModificar #refusuarios option:selected').html());
		});//fin del boton modificar

		$('.frmEntrevistaoportunidad').hide();



		$(".frmAjaxModificar").on("change",'#refestadooportunidad', function(){

			if ($('.frmAjaxModificar #refestadooportunidad option:selected').val() == 2) {
				$('.frmEntrevistaoportunidad').show();
			} else {
				$('.frmEntrevistaoportunidad').hide();
			}

			if ($('.frmAjaxModificar #refestadooportunidad option:selected').val() == 4) {
				$('.frmContrefmotivorechazos').show();
			} else {
				$('.frmContrefmotivorechazos').hide();
			}
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
							swal({
									title: "Respuesta",
									text: "Registro Creado con exito!!",
									type: "success",
									timer: 1500,
									showConfirmButton: false
							});

							$('#lgmNuevo').modal('hide');
							$('#unidadnegocio').val('');
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
							table2.ajax.reload();
							table3.ajax.reload();
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


		$('.frmAsignar').submit(function(e){

			e.preventDefault();
			if ($('.frmAsignar')[0].checkValidity()) {

				//información del formulario
				var formData = new FormData($(".formulario")[3]);
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

							$('#lgmReasignar').modal('hide');
							table.ajax.reload();
							table2.ajax.reload();
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
