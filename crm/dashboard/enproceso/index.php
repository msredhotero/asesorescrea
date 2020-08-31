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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../enproceso/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"En Proceso",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

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


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbcotizaciones";

$lblCambio	 	= array('refusuarios','refclientes','refproductos','refasesores','refasociados','refestadocotizaciones','fechaemitido','primaneta','primatotal','recibopago','fechapago','nrorecibo','importecomisionagente','importebonopromotor','cobertura','reasegurodirecto','fecharenovacion','fechapropuesta','tiponegocio','presentacotizacion');
$lblreemplazo	= array('Usuario','Clientes','Productos','Asesores','Asociados','Estado','Fecha Emitido','Prima Neta','Prima Total','Recibo Pago','Fecha Pago','Nro Recibo','Importe Com. Agente','Importe Bono Promotor','Cobertura Requiere Reaseguro','Reaseguro Directo con Inbursa o Broker','Fecha renovación o presentación de propueta al cliente','Fecha en que se entrega propuesta','Tipo de negocio para agente','Presenta Cotizacion o Poliza de competencia');


$cadRef1 	= "<option value='0'>Se genera automaticamente</option>";

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar2	= $serviciosReferencias->traerClientesasesoresPorAsesor($_SESSION['usuaid_sahilices']);
} else {
	$resVar2	= $serviciosReferencias->traerClientes();
}

if (mysql_num_rows($resVar2) > 0) {
	$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(3,4,2),' ');
} else {
	$cadRef2 = "<option value='0'>-- No cargo ningun cliente aun --</option>";
}


$resVar3	= $serviciosReferencias->traerProductos();
$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');


if ($_SESSION['idroll_sahilices'] != 7) {
	$resVar4	= $serviciosReferencias->traerAsociados();
	$cadRef4 = '<option value="0">-- Seleccionar --</option>';
	$cadRef4 .= $serviciosFunciones->devolverSelectBox($resVar4,array(4,2,3),' ');
} else {
	$cadRef4 = '<option value="0">-- Sin valor --</option>';
}

if ($_SESSION['idroll_sahilices'] == 7) {
	$resVar5	= $serviciosReferencias->traerAsesoresPorUsuario($_SESSION['usuaid_sahilices']);
	if (mysql_num_rows($resVar5)>0) {
		$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(4,2,3),' ');
	} else {
		header('Location: ../index.php');
	}

} else {
	$resVar5	= $serviciosReferencias->traerAsesores();
	$cadRef5 = $serviciosFunciones->devolverSelectBox($resVar5,array(4,2,3),' ');
}



$resVar6 = $serviciosReferencias->traerEstadocotizacionesPorId(1);
$cadRef6 = $serviciosFunciones->devolverSelectBox($resVar6,array(1),'');


$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6);
$refCampo 	=  array('refusuarios','refclientes','refproductos','refasociados','refasesores','refestadocotizaciones');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$tabla2 			= "dbclientes";

$lblCambio2	 	= array('refusuarios','fechanacimiento','apellidopaterno','apellidomaterno','telefonofijo','telefonocelular','reftipopersonas','numerocliente','razonsocial');
$lblreemplazo2	= array('Usuario','Fecha de Nacimiento','Apellido Paterno','Apellido Materno','Tel. Fijo','Tel. Celular','Tipo Persona','Nro Cliente','Razon Social');


$resVar82 = $serviciosReferencias->traerTipopersonas();
$cadRef82 = $serviciosFunciones->devolverSelectBox($resVar82,array(1),'');

$refdescripcion2 = array(0=>$cadRef82);
$refCampo2 	=  array('reftipopersonas');

$frmUnidadNegocios2 	= $serviciosFunciones->camposTablaViejo('insertarClientes' ,$tabla2,$lblCambio2,$lblreemplazo2,$refdescripcion2,$refCampo2);

if ($_SESSION['idroll_sahilices'] == 3) {


} else {

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
<?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], $resMenu,'../../'); ?>

<section class="content" style="margin-top:-75px;">

	<div class="container-fluid">
		<div class="row clearfix">

			<div class="row">


				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								<?php echo strtoupper($plural); ?> EN PROCESO
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
								<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)|| ($_SESSION['idroll_sahilices'] == 7)) { ?>
								<div class="row">
									<div class="col-lg-12 col-md-12">
										<div class="button-demo">

											<button type="button" class="btn bg-light-green waves-effect btnNuevo">
												<i class="material-icons">add</i>
												<span>NUEVO</span>
											</button>

											<button type="button" class="btn bg-blue waves-effect btnVigente">
												<i class="material-icons">timeline</i>
												<span>VIGENTE</span>
											</button>
											<button type="button" class="btn bg-green waves-effect btnCotizacion">
												<i class="material-icons">history</i>
												<span>EN COTIZACION</span>
											</button>
											<button type="button" class="btn bg-grey waves-effect btnHistorico">
												<i class="material-icons">history</i>
												<span>HISTORICO</span>
											</button>

										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-lg-12 col-md-12">
										<?php
										$cadRefAsinados = '<option value="">-- Seleccionar --</option><option value="enlinea">Venta en Linea</option><option value="poragente">Por Agente</option><option value="poroficina">Por Oficina</option>';
										?>
										<?php echo $serviciosFunciones->addInput('3,3,3,6','select','asignados_filtro','asignados_filtro','', 'Filtros','',$cadRefAsinados); ?>
									</div>
									<div class="col-lg-12 col-md-12">
										<button type="button" class="btn bg-red" id="filtrar">Filtrar</button>
									</div>
								</div>
								<?php } ?>

								<div class="row contActuales" style="padding: 5px 20px;">
									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
												<th>Fecha</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Cliente</th>
												<th>Producto</th>
												<th>Asesor</th>
												<th>Asociado</th>
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

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<!-- Chart Plugins Js -->
<script src="../../plugins/chartjs/Chart.bundle.js"></script>

<script>
	$(document).ready(function(){

		function parseDate(str) {

			var mdy = str.split('-');
			return new Date(mdy[0], mdy[1]-1, mdy[2]);
		}

		function datediff(first, second) {
			// Take the difference between the dates and divide by milliseconds per day.
			// Round to nearest whole number to deal with DST.
			return Math.round((second-first)/(1000*60*60*24));
		}

		$('.btnNuevo').click(function() {
			idTable =  $(this).attr("id");
			$(location).attr('href', 'new.php');
		});



		var table = $('#example').DataTable({
			"bProcessing": true,
			"bServerSide": true,
			"order": [[ 5, "desc" ]],
			"sAjaxSource": "../../json/jstablasajax.php?tabla=cotizaciones&estado=1",
			"fnServerData": function ( sSource, aoData, fnCallback ) {
				/* Add some extra data to the sender */
				aoData.push( { "name": "start", "value": $('#fechadesde_filtro').val(), } );
				aoData.push( { "name": "end", "value": $('#fechahasta_filtro').val(), } );
				aoData.push( { "name": "filtroNuevo", "value": $('#asignados_filtro').val(), } );
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
				//alert(data[4].substring(0,10));
			  if (datediff(parseDate(data[4].substring(0,10)), parseDate('<?php echo date('Y-m-d'); ?>') )  > 1) {
				  $('td', row).css('background-color', '#F62121');
				  $('td', row).css('color', 'white');
			  }
		   }
		});

		$('#filtrar').click( function() {
			table.draw();
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
						table2.ajax.reload();
						table3.ajax.reload();
						table4.ajax.reload();
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
						table2.ajax.reload();
						table3.ajax.reload();
						table4.ajax.reload();
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
					table.ajax.reload();
					table2.ajax.reload();
					table3.ajax.reload();
					table4.ajax.reload();
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

		$("#example").on("click",'.btnAbandonada', function(){
			idTable =  $(this).attr("id");
			$('.lblModiEstado').html('ABANDONADA');
			$('.modificarEstadoCotizacionRechazo').html('ABANDONADA');
			$('#idmodificarestadorechazo').val(idTable);
			$('#estadomodificarestadorechazo').val(2);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar

		$("#example").on("click",'.btnBasura', function(){
			idTable =  $(this).attr("id");
			$('.lblModiEstado').html('BASURA');
			$('.modificarEstadoCotizacionRechazo').html('BASURA');
			$('#idmodificarestadorechazo').val(idTable);
			$('#estadomodificarestadorechazo').val(3);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar

		$("#example4").on("click",'.btnRechazarDefinitivamente', function(){
			idTable =  $(this).attr("id");
			$('.lblModiEstado').html('RECHAZAR DEFINITIVAMENTE');
			$('.modificarEstadoCotizacionRechazo').html('RECHAZAR DEFINITIVAMENTE');
			$('#idmodificarestadorechazo').val(idTable);
			$('#estadomodificarestadorechazo').val(3);
			$('#lgmModificarEstado').modal();

		});//fin del boton eliminar

		$("#example").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$("#example2").on("click",'.btnEliminar', function(){
			idTable =  $(this).attr("id");
			$('#ideliminar').val(idTable);
			$('#lgmEliminar').modal();
		});//fin del boton eliminar

		$("#example").on("click",'.btnEliminarDefinitivo', function(){
			idTable =  $(this).attr("id");
			$('#ideliminarDefinitivo').val(idTable);
			$('#lgmEliminarDefinitivo').modal();
		});//fin del boton eliminar

		$("#example2").on("click",'.btnEliminarDefinitivo', function(){
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
			$(location).attr('href','newfilter.php?id=' + idTable);
		});//fin del boton modificar

		$("#example2").on("click",'.btnModificar', function(){
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
							table2.ajax.reload();
							table3.ajax.reload();
							table4.ajax.reload();
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
	});
</script>

</body>
<?php } ?>
</html>
