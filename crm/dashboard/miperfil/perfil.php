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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../miperfil/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Mi Perfil",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

$id = $_GET['id'];

$resAsesor = $serviciosReferencias->traerAsesoresPorId($id);

$idusuario = mysql_result($resAsesor,0,'refusuarios');

$resultado = $serviciosReferencias->traerAsesoresPorId($id);

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



/******************** fin *********************************/

$tabla 			= "dbasesores";

$lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad','afore','compania','cedula','refesquemareclutamiento','nss','claveinterbancaria','idclienteinbursa','claveasesor','fechaalta','urlprueba','vigdesdecedulaseguro','vighastacedulaseguro','vigdesdeafore','vighastaafore','nropoliza','reftipopersonas','razonsocial','vigdesderc','vighastarc','refestadoasesor','refestadoasesorinbursa','envioalcliente');
$lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad','¿Cuenta con cédula definitiva para venta de Afore?','¿Con que compañía vende actualmente?','¿Cuenta Con cedula definitiva para venta de Seguros?','Esquema de Reclutamiento','Nro de Seguro Social','Clave Interbancaria','ID Cliente Inbursa','Clave Asesor','Fecha de Alta','URL Prueba','Cedula Seg. Vig. Desde','Cedula Seg. Vig. Hasta','Afore Vig. Desde','Afore Vig. Hasta','N° Poliza','Tipo Persona','Razon Social','Vig. Desde RC','Vig. Hasta RC','Est. CREA','Est. INBURSA','Envia informacion al Cliente');



$modificar = "modificarAsesores";
$idTabla = "idasesor";

$resUsuario = $serviciosUsuario->traerUsuarioId(mysql_result($resultado,0,'refusuarios'));
$cadRef1 	= $serviciosFunciones->devolverSelectBox($resUsuario,array(1),'');

$resVar2	= $serviciosReferencias->traerEscolaridades();
$cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar2,array(1),'',mysql_result($resultado,0,'refescolaridades'));

if (mysql_result($resultado,0,'sexo') == '1') {
	$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1' selected>Femenino</option><option value='2'>Masculino</option>";
} else {
	$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1'>Femenino</option><option value='2' selected>Masculino</option>";
}

if (mysql_result($resultado,0,'codigopostal') == '') {
	$codigopostal = '';
} else {
	$resPostal = $serviciosReferencias->traerPostalPorId(mysql_result($resultado,0,'codigopostal'));

	$codigopostal = mysql_result($resPostal,0,'codigo');
}

$resVar8 = $serviciosReferencias->traerTipopersonas();
$cadRef8 = $serviciosFunciones->devolverSelectBoxActivo($resVar8,array(1),'',mysql_result($resultado,0,'reftipopersonas'));

$resVar9 = $serviciosReferencias->traerEstadoasesor();
$cadRef9 = $serviciosFunciones->devolverSelectBoxActivo($resVar9,array(1),'',mysql_result($resultado,0,'refestadoasesor'));

$resVar10 = $serviciosReferencias->traerEstadoasesor();
$cadRef10 = $serviciosFunciones->devolverSelectBoxActivo($resVar10,array(1),'',mysql_result($resultado,0,'refestadoasesorinbursa'));

if (mysql_result($resultado,0,'envioalcliente') == '1') {
	$cadRef55 = "<option value='0'>No</option><option value='1' selected>Si</option>";
} else {
	$cadRef55 = "<option value='0' selected>No</option><option value='1'>Si</option>";
}

$refdescripcion = array(0=> $cadRef1,1=> $cadRef2, 2=>$cadRef5,3=>$cadRef8,4=>$cadRef9,5=>$cadRef10,6=>$cadRef55);
$refCampo 	=  array('refusuarios','refescolaridades','sexo','reftipopersonas','refestadoasesor','refestadoasesorinbursa','envioalcliente');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaModificar($id,'idasesor','modificarAsesores',$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
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

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">

		<div class="row clearfix">
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								ASESOR
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
			
							<form class="form" id="sign_in" role="form">
								<div class="row">
									<?php echo $frmUnidadNegocios; ?>
								</div>
								<input type="hidden" name="codigopostalaux" id="codigopostalaux" value="<?php echo mysql_result($resultado,0,'codigopostal'); ?>" />

							</form>
							</div>
						</div>
					</div>
				</div>
			</div> <!-- fin del container entrevistas -->






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

	var arNoHabilita = [ 0];

	$(document).ready(function(){


		$('.frmContrefreferentes').hide();
		$('.frmContreforigenreclutamiento').hide();
		$('.frmContrefesquemareclutamiento').hide();
		$('.frmContreftipopersonas').hide();


		function presentarDocumentacionI(id) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {accion: 'presentarDocumentacionI',id: id},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('.btnPresentar').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data == '') {
						swal("Ok!", 'Ya presento su documentacion, sera evaluada para luego continuar con el proceso', "success");
						$('.btnPresentar').show();
						setTimeout(function(){ location.reload() }, 4000);
					} else {
						swal("Error!", data, "warning");


					}
				},
				//si ha ocurrido un error
				error: function(){
					$(".alert").html('<strong>Error!</strong> Actualice la pagina');
					$("#load").html('');
				}
			});
		}

		$('.btnPresentar').click(function() {
			presentarDocumentacionI(<?php echo $id; ?>);
		});

		$('.btnDocumentacion').click(function() {

			idTable =  $(this).attr("id");

			if (arNoHabilita.indexOf(parseInt(idTable))>=0) {
				swal("Error!", 'No puede modificarse una documentaciones Presentada o Aceptada', "warning");
			} else {
				url = "subirdocumentacioni.php?id=<?php echo $idusuario; ?>&documentacion=" + idTable;
				$(location).attr('href',url);
			}


		});

		$('#codigopostal').val('<?php echo $codigopostal; ?>');


		$('.img-responsive').click(function() {
			srcImg =  $(this).attr("src");
			window.open(srcImg,'_blank');
		});

		$('.img-responsive2').click(function() {
			srcImg =  $(this).attr("src");
			window.open(srcImg,'_blank');
		});

		$(".form-control").attr("disabled", true);
		/*
		$("#sexo").attr("disabled", true);
		$("#codigopostal").attr("disabled", true);
		$("#refestadocivil").attr("disabled", true);
		$("#refescolaridades").attr("disabled", true);
		$("#refestadopostulantes").attr("disabled", true);
		$("#refesquemareclutamiento").attr("disabled", true);
		$("#afore").attr("disabled", true);
		$("#cedula").attr("disabled", true);
		*/

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
