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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../productos/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Productos",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Producto";

$plural = "Productos";

$eliminar = "eliminarProductos";

$insertar = "insertarProductos";

$modificar = "modificarProductos";

//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "tbproductos";

$lblCambio	 	= array('reftipoproductorama','reftipodocumentaciones','puntosporventa','puntosporpesopagado','refcuestionarios','puntosporventarenovado','puntosporpesopagadorenovado','reftipopersonas','ventaenlinea','cotizaenlinea','beneficiario','asegurado','reftipofirma');
$lblreemplazo	= array('Ramo de Producto','Tipo de Documentaciones','Punto x Venta','Puntos x Peso Pagado','Cuestionario','Punto x Venta Renovacion','Puntos x Peso Pagado Renovacion','Tipo Personas','Es de venta en linea','Es para cotizar','Podría tener beneficiario ','Podría tener asegurado distinto al contratante','Firmas');

$resVar1 = $serviciosReferencias->traerTipoproductorama();
$cadRef1 = $serviciosFunciones->devolverSelectBox($resVar1,array(2),'');

$resVar2 = $serviciosReferencias->traerTipodocumentaciones();
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1),'');

$cadRef3 = "<option value='1'>Si</option><option value='0'>No</option>";

$resCuest = $serviciosReferencias->traerCuestionarios();
$cadRef4 = '<option value="">-- Seleccionar --</option>';
$cadRef4 .= $serviciosFunciones->devolverSelectBox($resCuest,array(1),'');

$resVar8 = $serviciosReferencias->traerTipopersonas();
$cadRef8 = $serviciosFunciones->devolverSelectBox($resVar8,array(1),'');

$cadRef9 = "<option value='1' selected>Si</option><option value='0'>No</option>";

$resVar10 = $serviciosReferencias->traerTipofirma();
$cadRef10 = $serviciosFunciones->devolverSelectBox($resVar10,array(1),'');

$refdescripcion = array(0=>$cadRef1,1=>$cadRef2,2=>$cadRef3,3=>$cadRef3,4=>$cadRef4,5=>$cadRef8,6=>$cadRef9,7=>$cadRef9,8=>$cadRef9,9=>$cadRef9,10=>$cadRef10);
$refCampo 	=  array('reftipoproductorama','reftipodocumentaciones','activo','prima','refcuestionarios','reftipopersonas','ventaenlinea','cotizaenlinea','beneficiario','asegurado','reftipofirma');

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


	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

	<script src="https://cdn.tiny.cloud/1/250yr8s6bkp1q3322lambprpw1glcn1b50hpg2hm8knawsa0/tinymce/5/tinymce.min.js" referrerpolicy="origin"/></script>
	<script>

	</script>

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
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 contHistorico">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								PRODUCTOS
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
											<button type="button" class="btn bg-light-green waves-effect btnNuevo" data-toggle="modal" data-target="#lgmNuevo">
												<i class="material-icons">add</i>
												<span>NUEVO</span>
											</button>

										</div>
									</div>
								</div>

								<div class="row" style="padding: 5px 20px;">

									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Producto</th>
												<th>Prima</th>
												<th>Ramo Producto</th>
												<th>Tipo Documentacion</th>
												<th>Pt x Venta</th>
												<th>Pts x Peso Pagado</th>
												<th>Tipo Persona</th>
												<th>Activo</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Producto</th>
												<th>Prima</th>
												<th>Ramo Producto</th>
												<th>Tipo Documentacion</th>
												<th>Pt x Venta</th>
												<th>Pts x Peso Pagado</th>
												<th>Tipo Persona</th>
												<th>Activo</th>
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


<script>
	$(document).ready(function(){

		tinymce.init({
		 selector: "#detalle",
		  height:"350px",
		  mode: "exact",
		  plugins: [
				 "advlist autolink image lists charmap print preview hr anchor pagebreak spellchecker",
				 "link searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				 "save table contextmenu directionality emoticons template paste textcolor"
		 ],
		 toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
		 style_formats: [
				{title: 'Bold text', inline: 'b'},
				{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
				{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
				{title: 'Example 1', inline: 'span', classes: 'example1'},
				{title: 'Example 2', inline: 'span', classes: 'example2'},
				{title: 'Table styles'},
				{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		  ]
	 });

		$('#puntosporventa').number( true, 2,'.','' );
		$('#puntosporpesopagado').number( true, 2,'.','' );
		$('#puntosporventarenovado').number( true, 2,'.','' );
		$('#puntosporpesopagadorenovado').number( true, 2,'.','' );

		$('.maximizar').click(function() {
			if ($('.icomarcos').text() == 'web') {
				$('#marcos').show();
				$('.content').css('marginLeft', '315px');
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
			"sAjaxSource": "../../json/jstablasajax.php?tabla=productos",
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

		$('.btnNuevo').click(function() {
			tinyMCE.remove('.modDetalle');

			tinymce.init({
				 selector: "#detalle",
				  height:"350px",
				  mode: "exact",
				  plugins: [
						 "advlist autolink image lists charmap print preview hr anchor pagebreak spellchecker",
						 "link searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
						 "save table contextmenu directionality emoticons template paste textcolor"
				 ],
				 toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
				 style_formats: [
						{title: 'Bold text', inline: 'b'},
						{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
						{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
						{title: 'Example 1', inline: 'span', classes: 'example1'},
						{title: 'Example 2', inline: 'span', classes: 'example2'},
						{title: 'Table styles'},
						{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
				  ]
			 });
		});


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
						$('.frmAjaxModificar #puntosporventa').number( true, 2,'.','' );
						$('.frmAjaxModificar #puntosporpesopagado').number( true, 2,'.','' );
						$('.frmAjaxModificar #puntosporventarenovado').number( true, 2,'.','' );
						$('.frmAjaxModificar #puntosporpesopagadorenovado').number( true, 2,'.','' );
						tinyMCE.remove('#detalle');
						tinymce.init({
					  		 selector: ".modDetalle",
					  	     height:"350px",
					  	     plugins: [
					  	          "advlist autolink image lists charmap print preview hr anchor pagebreak spellchecker",
					  	          "link searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
					  	          "save table contextmenu directionality emoticons template paste textcolor"
					  	    ],
					  	    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
					  	    style_formats: [
					  	         {title: 'Bold text', inline: 'b'},
					  	         {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
					  	         {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
					  	         {title: 'Example 1', inline: 'span', classes: 'example1'},
					  	         {title: 'Example 2', inline: 'span', classes: 'example2'},
					  	         {title: 'Table styles'},
					  	         {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
					  	     ]
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


		$("#example2").on("click",'.btnGenerar', function(){
			idTable =  $(this).attr("id");
			var arId = idTable.split('-');

			$('#refasesores').val(arId[0]);
			$('#meses').val(arId[1]);
			$('#lgmNuevo').modal();
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


		$("#example3").on("click",'.btnVer', function(){
			idTable =  $(this).attr("id");
			$(location).attr('href', 'modificar.php?id=' + idTable);
		});//fin del boton modificar


		$('.frmNuevo').submit(function(e){
			var ed = tinyMCE.get('detalle');

			$('#detalle').val(ed.getContent());

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

			var ed = tinyMCE.get('detalle');

			$('.modDetalle').val(ed.getContent());

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
