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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../misclientes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Mis Clientes",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////

$resAsesores = $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);

if (mysql_num_rows($resAsesores)>0) {
	$id = mysql_result($resAsesores,0,0);
} else {
	$id = 0;
}

$singular = "Cliente";

$plural = "Clientes";

$eliminar = "eliminarClientes";

$insertar = "insertarClientes";

$modificar = "modificarClientes";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbclientes";

$lblCambio	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonofijo','telefonocelular','reftipopersonas','numerocliente','razonsocial','emisioncomprobantedomicilio','emisionrfc','vencimientoine','idclienteinbursa','nroexterior','nrointerior','codigopostal','ine','rfc','curp','refestadocivil','reftipoidentificacion','nroidentificacion');
$lblreemplazo	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Fijo','Tel. Celular','Tipo Persona','Nro Cliente','Razon Social','Fecha Emision Compr. Domicilio','Fecha Emision RFC','Vencimiento INE','ID Cliente Inbursa','Nro Exterior','No. Interior','Cod. Postal','INE','RFC','CURP','Estado Civil','Tipo de Identificación','No Identificación');


$resVar8 = $serviciosReferencias->traerTipopersonas();
$cadRef8 = $serviciosFunciones->devolverSelectBox($resVar8,array(1),'');

$resVar9 = $serviciosReferencias->traerEstadoCivil();
$cadRef9 = $serviciosFunciones->devolverSelectBox($resVar9,array(1),'');

$cadRef10 = "<option value='Femenino'>Femenino</option><option value='Masculino'>Masculino</option>";

$resVar11 = $serviciosReferencias->traerTipoidentificacion();
$cadRef11 = $serviciosFunciones->devolverSelectBox($resVar11,array(1),'');


$refdescripcion = array(0=>$cadRef8,1=>$cadRef9,2=>$cadRef10,3=>$cadRef11);
$refCampo 	=  array('reftipopersonas','refestadocivil','genero','reftipoidentificacion');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////

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

	<link rel="stylesheet" href="../../css/materialDateTimePicker.css">

	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">

	<style>
		.alert > i{ vertical-align: middle !important; }
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		.codigopostal { width: 400px; }

		.ui-autocomplete { position: absolute; cursor: default;z-index:30 !important;}

		.sectionC {
			height:360px;
			z-index:1 !important;
		}

		@media (min-width: 1200px) {
		   .modal-xlg {
		      width: 90%;
		   }
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


								<div class="row" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Tipo P.</th>
												<th>Ape. Paterno</th>
												<th>Ape. Materno</th>
												<th>Nombre</th>
												<th>Razon Social</th>
												<th>Tel. Fijo</th>
												<th>Tel. Celular</th>
												<th>Email</th>
												<th>Nro Cliente</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Tipo P.</th>
												<th>Ape. Paterno</th>
												<th>Ape. Materno</th>
												<th>Nombre</th>
												<th>Razon Social</th>
												<th>Tel. Fijo</th>
												<th>Tel. Celular</th>
												<th>Email</th>
												<th>Nro Cliente</th>
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

<!-- Moment Plugin Js -->
    <script src="../../plugins/momentjs/moment.js"></script>
	 <script src="../../js/moment-with-locales.js"></script>

<script src="../../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

<script src="../../js/materialDateTimePicker.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>


<script>
	$(document).ready(function(){

		var options2 = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $(".frmNuevo #codigopostal").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $(".frmNuevo #codigopostal").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $(".frmNuevo #codigopostal").getSelectedItemData().codigo;
					$(".frmNuevo #codigopostal").val(value);
					$(".frmNuevo #municipio").val($(".frmNuevo #codigopostal").getSelectedItemData().municipio);
					$(".frmNuevo #estado").val($(".frmNuevo #codigopostal").getSelectedItemData().estado);
					$(".frmNuevo #colonia").val($(".frmNuevo #codigopostal").getSelectedItemData().colonia);


				}
			}
		};


		var optionsMod = {

			url: "../../json/jsbuscarpostal.php",

			getValue: function(element) {
				return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
			},

			ajaxSettings: {
				dataType: "json",
				method: "POST",
				data: {
					busqueda: $(".frmAjaxModificar #codigopostal2").val()
				}
			},

			preparePostData: function (data) {
				data.busqueda = $(".frmAjaxModificar #codigopostal2").val();
				return data;
			},

			list: {
				maxNumberOfElements: 20,
				match: {
					enabled: true
				},
				onClickEvent: function() {
					var value = $(".frmAjaxModificar #codigopostal2").getSelectedItemData().codigo;
					$(".frmAjaxModificar #codigopostal2").val(value);
					$(".frmAjaxModificar #municipio").val($(".frmAjaxModificar #codigopostal2").getSelectedItemData().municipio);
					$(".frmAjaxModificar #estado").val($(".frmAjaxModificar #codigopostal2").getSelectedItemData().estado);
					$(".frmAjaxModificar #colonia").val($(".frmAjaxModificar #codigopostal2").getSelectedItemData().colonia);


				}
			}
		};

		$("#codigopostal").easyAutocomplete(options2);

		$('#fechanacimiento').bootstrapMaterialDatePicker({
			format: 'YYYY-MM-DD',
			lang : 'es',
			clearButton: true,
			weekStart: 1,
			time: false
		});

		$('#telefonofijo').inputmask('999 9999999', { placeholder: '___ _______' });
		$('#telefonocelular').inputmask('999 9999999', { placeholder: '___ _______' });

		$('#fechacrea').val('20/02/2020');
		$('#fechamodi').val('20/02/2020');
		$('#usuariocrea').val('20/02/2020');
		$('#usuariomodi').val('20/02/2020');


		$('.frmContnumerocliente').hide();
		$('.frmContrefusuarios').hide();

		$("#numerocliente").prop('readonly',true);

		$('#emisioncomprobantedomicilio').pickadate({
 			format: 'yyyy-mm-dd',
 			labelMonthNext: 'Siguiente mes',
 			labelMonthPrev: 'Previo mes',
 			labelMonthSelect: 'Selecciona el mes del año',
 			labelYearSelect: 'Selecciona el año',
 			selectMonths: true,
 			selectYears: 5,
 			today: 'Hoy',
 			clear: 'Borrar',
 			close: 'Cerrar',
 			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
 			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
 			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
 		});

		$('#emisionrfc').pickadate({
 			format: 'yyyy-mm-dd',
 			labelMonthNext: 'Siguiente mes',
 			labelMonthPrev: 'Previo mes',
 			labelMonthSelect: 'Selecciona el mes del año',
 			labelYearSelect: 'Selecciona el año',
 			selectMonths: true,
 			selectYears: 5,
 			today: 'Hoy',
 			clear: 'Borrar',
 			close: 'Cerrar',
 			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
 			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
 			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
 		});

		$('#vencimientoine').pickadate({
 			format: 'yyyy-mm-dd',
 			labelMonthNext: 'Siguiente mes',
 			labelMonthPrev: 'Previo mes',
 			labelMonthSelect: 'Selecciona el mes del año',
 			labelYearSelect: 'Selecciona el año',
 			selectMonths: true,
 			selectYears: 40,
 			today: 'Hoy',
 			clear: 'Borrar',
 			close: 'Cerrar',
 			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
 			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
 			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
 			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
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
			$("#razonsocial").prop('required',true);
			$("#nombre").prop('required',false);
			$("#apellidopaterno").prop('required',false);
			$("#apellidomaterno").prop('required',false);
			$('.frmContapellidomaterno label span').remove();
			$('.frmContapellidopaterno label span').remove();
			$('.frmContnombre label span').remove();

			$('#apellidopaterno-error').remove();
			$('#apellidomaterno-error').remove();
			$('#nombre-error').remove();


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

			$("#razonsocial").prop('required',false);
			$("#nombre").prop('required',true);
			$("#apellidopaterno").prop('required',true);
			$("#apellidomaterno").prop('required',true);
			$('.frmContapellidomaterno label span').remove();
			$('.frmContapellidopaterno label span').remove();
			$('.frmContnombre label span').remove();

			$('.frmContapellidomaterno label').append('<span style="color:red;">*</span>');
			$('.frmContapellidopaterno label').append('<span style="color:red;">*</span>');
			$('.frmContnombre label').append('<span style="color:red;">*</span>');


		});



		$("#example").on("click",'.btnDocumentacion', function(){
			idTable =  $(this).attr("id");
			url = "subirdocumentacioni.php?id=" + idTable + "&documentacion=3";
			$(location).attr('href',url);
		});//fin del boton eliminar

		$("#example").on("click",'.btnFamiliares', function(){
			idTable =  $(this).attr("id");
			url = "familiares.php?id=" + idTable ;
			$(location).attr('href',url);
		});//fin del boton eliminar



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"sAjaxSource": "../../json/jstablasajax.php?tabla=misclientes&idasesor=<?php echo $id; ?>",
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

						$(".frmAjaxModificar .frmContcodigopostal input").removeAttr("id");
   					$(".frmAjaxModificar .frmContcodigopostal input").attr("id","codigopostal2");

						$(".frmAjaxModificar #numerocliente").prop('readonly',true);

						$('.frmAjaxModificar #telefonofijo').inputmask('999 9999999', { placeholder: '___ _______' });
						$('.frmAjaxModificar #telefonocelular').inputmask('999 9999999', { placeholder: '___ _______' });

						$(".frmAjaxModificar #nombre").prop('required',false);
						$(".frmAjaxModificar #apellidopaterno").prop('required',false);
						$(".frmAjaxModificar #apellidomaterno").prop('required',false);
						$('.frmAjaxModificar .frmContapellidomaterno label span').remove();
						$('.frmAjaxModificar .frmContapellidopaterno label span').remove();
						$('.frmAjaxModificar .frmContnombre label span').remove();

						$(".frmAjaxModificar #codigopostal2").easyAutocomplete(optionsMod);

						$('.frmAjaxModificar #fechanacimiento').bootstrapMaterialDatePicker({
							format: 'YYYY-MM-DD',
							lang : 'es',
							clearButton: true,
							weekStart: 1,
							time: false
						});

						$('.frmAjaxModificar #emisioncomprobantedomicilio').pickadate({
				 			format: 'yyyy-mm-dd',
				 			labelMonthNext: 'Siguiente mes',
				 			labelMonthPrev: 'Previo mes',
				 			labelMonthSelect: 'Selecciona el mes del año',
				 			labelYearSelect: 'Selecciona el año',
				 			selectMonths: true,
				 			selectYears: 5,
				 			today: 'Hoy',
				 			clear: 'Borrar',
				 			close: 'Cerrar',
				 			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				 			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
				 			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
				 			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				 		});

						$('.frmAjaxModificar #emisionrfc').pickadate({
				 			format: 'yyyy-mm-dd',
				 			labelMonthNext: 'Siguiente mes',
				 			labelMonthPrev: 'Previo mes',
				 			labelMonthSelect: 'Selecciona el mes del año',
				 			labelYearSelect: 'Selecciona el año',
				 			selectMonths: true,
				 			selectYears: 5,
				 			today: 'Hoy',
				 			clear: 'Borrar',
				 			close: 'Cerrar',
				 			monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
				 			monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
				 			weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
				 			weekdaysShort: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
				 		});

						$('.frmAjaxModificar #vencimientoine').pickadate({
				 			format: 'yyyy-mm-dd',
				 			labelMonthNext: 'Siguiente mes',
				 			labelMonthPrev: 'Previo mes',
				 			labelMonthSelect: 'Selecciona el mes del año',
				 			labelYearSelect: 'Selecciona el año',
				 			selectMonths: true,
				 			selectYears: 40,
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
