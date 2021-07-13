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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../financiera/');
//*** FIN  ****/

$fecha = date('Y-m-d');

$id = $_GET['id'];

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);


//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Financiera",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';


/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Documentación I";

$plural = "Documentaciones I";

$eliminar = "eliminarCotizaciones";

$insertar = "insertarCotizaciones";

$modificar = "modificarCotizaciones";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$refEstadoCotizacion = mysql_result($resCotizaciones,0,'refestadocotizaciones');

$resPagos = $serviciosReferencias->traerPagosPorTablaReferencia(12, 'dbcotizaciones', 'idcotizacion', $id);


$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');

$reftipoproductorama = mysql_result($resProducto,0,'reftipoproductorama');

$consolicitud = mysql_result($resProducto,0,'consolicitud');

if (mysql_num_rows($resCotizaciones)>0) {
	$precio = mysql_result($resCotizaciones,0,'primatotal');
	$lblPrecio = str_replace('.','',$precio);
	$lblPrecioAd = str_replace('.','',$precio * 1.2);
} else {
	header('Location: index.php');
}

if (mysql_num_rows($resPagos) > 0) {
	$idpago = mysql_result($resPagos,0,0);
	$idpagoestado = mysql_result($resPagos,0,'refestado');

	$archivo = mysql_result($resPagos,0,'archivos');

	$resEstadoDocumentacion = $serviciosReferencias->traerEstadodocumentacionesPorId($idpagoestado);

	if ($archivo == '') {
		$lblEstado = 'Falta';
		$lblColor = 'grey';
	} else {
		//$lblEstado = mysql_result($resEstadoDocumentacion,0,'estadodocumentacion');
		$lblEstado = 'Su comprobante se cargo correctamente';
		$lblColor = mysql_result($resEstadoDocumentacion,0,'color');
	}

} else {



	$conciliado = '0';
	$archivos = '';
	$type = '';

	if ($reftipoproductorama == 12) {
		// cuenta de vrim para transferencia
		$refcuentasbancarias = 3;
	} else {
		// cuenta de javier para transferencia
		$refcuentasbancarias = 1;
	}

	$resPagos = $serviciosReferencias->insertarPagos(12,$id,$precio,$serviciosReferencias->GUID(),'Pago por transferencia bancaria Financiera CREA',$refcuentasbancarias,$conciliado,$archivos,$type,date('Y-m-d H:i:s'),$_SESSION['nombre_sahilices'],1,'Financiera CREA',$lblCliente,'','0');


	$resPagos = $serviciosReferencias->traerPagosPorTablaReferencia(12, 'dbcotizaciones', 'idcotizacion', $id);

	$idpago = mysql_result($resPagos,0,0);

	$idpagoestado = 1;

	$archivo = mysql_result($resPagos,0,'archivos');

	$resEstadoDocumentacion = $serviciosReferencias->traerEstadodocumentacionesPorId($idpagoestado);

	if ($archivo == '') {
		$lblEstado = 'Falta';
		$lblColor = 'grey';
	} else {
		$lblEstado = mysql_result($resEstadoDocumentacion,0,'estadodocumentacion');

		$lblColor = mysql_result($resEstadoDocumentacion,0,'color');
	}
}



$puedeEntrar = 0;
//die(var_dump($refEstadoCotizacion));

if ($refEstadoCotizacion == 23) {

	$puedeEntrar = 1;
	if (($idpagoestado == 1) || ($idpagoestado == 2) || ($idpagoestado == 3) || ($idpagoestado == 4)) {
		$puedeSubirArchivos = 1;
	} else {
		$puedeSubirArchivos = 0;
	}
} else {
	return header('Location: index.php');

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
		.pdfobject-container { height: 50rem; border: 1rem solid rgba(0,0,0,.1); }

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

		.btnDocumentacion, .btnCursor {
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
		<div class="row clearfix subirImagen">

			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card">
						<div class="header bg-blue">
							<h2>
								CARGUE AQUI EL COMPROBANTE DE LA TRANSFERENCIA
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
							<?php if ($puedeSubirArchivos != 0) { ?>
                     <button type="button" class="btn btn-info waves-effect btnVolverFiltro" data-ir="transferencia" data-referencia="0"><i class="material-icons">reply</i><span>VOLVER</span></button>
							<?php if ($archivo != '') { ?>
								<button type="button" class="btn bg-green waves-effect btnFinalizar" ><i class="material-icons">done_all</i><span>FINALIZAR PROCESO</span></button>
							<?php } ?>


							<form action="subirrecibos.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
								<div class="dz-message">
									<div class="drag-icon-cph">
										<i class="material-icons">touch_app</i>
									</div>
									<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>
								</div>
								<div class="fallback">
									<input name="file" type="file" id="archivos" />
									<input type="hidden" id="idtransferencia" name="idtransferencia" value="<?php echo $id; ?>" />
								</div>
							</form>
						<?php } else { ?>
							<h4>Ya finalizo el proceso correctamente</h4>
						<?php } ?>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
					<div class="card ">
						<div class="header bg-blue">
							<h2>
								ARCHIVO CARGADO
							</h2>
						</div>
						<div class="body table-responsive">

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

<!-- JQuery Steps Plugin Js -->
<script src="../../plugins/jquery-steps/jquery.steps.js"></script>

<script>

	$(document).ready(function(){

		$('.btnFinalizar').click(function() {
			$.ajax({
				data:  {
					id: <?php echo $idpago; ?>,
					estado: 5,
					accion: 'finalizarComprobanteFinanciera'
				},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {

				},
				success:  function (response) {
					if (response.error == false) {
						swal("Correcto!", 'Se finalizo el proceso correctamente', "success");
						location.reload();
					} else {
						swal("Error!", 'Se genero un error, verifique', "error");
					}
				}
			});
		});

		$('.btnDocumentacion').click(function() {
			idTable =  $(this).attr("id");
			url = "subirdocumentacion.php?id=<?php echo $id; ?>&documentacion=" + idTable;
			$(location).attr('href',url);
		});




		var options = {
		    height: "400px",
		    page: '1',
		    pdfOpenParams: {
		        view: 'FitV',
		        pagemode: 'thumbs',
		        search: 'lorem ipsum'
		    }
		};
		function traerImagen(contenedorpdf, contenedor, options) {
			$.ajax({
				data:  {idpago: <?php echo $idpago; ?>,
						accion: 'traerPagosPorId'},
				url:   '../../ajax/ajax.php',
				type:  'post',
				beforeSend: function () {
					$("." + contenedor + " img").attr("src",'');
				},
				success:  function (response) {
					if (response.datos.type != '') {
						var cadena = response.datos.type.toLowerCase();

						if (cadena.indexOf("pdf") > -1) {
							PDFObject.embed(response.datos.imagen, "#example1",options);
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
					formData.append("idpago", '<?php echo $idpago; ?>');

				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1');
					$('.lblPlanilla').hide();

					$('.btnGuardar').show();
					$('.infoPlanilla').hide();
					if (resp.indexOf('Error')!== -1) {
						swal("Error!", resp.replace("1", ""), "error");
					} else {
						swal("Correcto!", resp.replace("1", ""), "success");

						location.reload();
					}
					//
				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};


		<?php if ($idpagoestado != 5) { ?>
		var myDropzone = new Dropzone("#archivos", {
			params: {
				 idpago: <?php echo $idpago; ?>
			},
			url: 'subirrecibos.php'
		});
		<?php } ?>



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


		$(".body").on("click",'.btnEliminar', function(){
			$('#lgmEliminar').modal();

		});



	});
</script>


</body>
<?php } ?>
</html>
