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
include ('../../includes/funcionesPostal.php');


$serviciosFunciones 		= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML 					= new BaseHTML();
$serviciosPostal        = new serviciosPostal();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../postulantes/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Asesores",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Perfil Web";

$plural = "Perfil Web";

$eliminar = "eliminarPerfilasesores";

$insertar = "insertarPerfilasesores";

$modificar = "modificarPerfilasesores";

//////////////////////// Fin opciones ////////////////////////////////////////////////

$id = $_GET['id'];

$resultado = $serviciosReferencias->traerAsesoresPorId($id);

$tipopersona = mysql_result($resultado,0,'reftipopersonas');

$resInformacion = $serviciosReferencias->traerPerfilasesoresPorTablaReferencia(1, 'dbasesores', 'idasesor', $id);

if (mysql_num_rows($resInformacion) <= 0) {
	$idInformacion = $serviciosReferencias->insertarPerfilasesores(1,$id,'','','','','','1');
	$resInformacion = $serviciosReferencias->traerPerfilasesoresPorId($idInformacion);
} else {
	$idInformacion = mysql_result($resInformacion,0,'idperfilasesor');
}

//$resasdasd = $serviciosReferencias->migrarPostulante($id,'marcosborrar');
//die(var_dump($resasdasd));

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbperfilasesores";

$lblCambio	 	= array('urllinkedin','urlfacebook','urlinstagram','urloficial','marcapropia','reftipofigura');
$lblreemplazo	= array('URL Linkedin','URL Facebook','URL Instagram','URL Oficial','¿marca propia?','Tipo Figura');

if (mysql_result($resInformacion,0,'visible') == '1') {
	$cadRef5 = "<option value='1' selected>Si</option><option value='0'>No</option>";
} else {
	$cadRef5 = "<option value='1'>Si</option><option value='0' selected>No</option>";
}

if (mysql_result($resInformacion,0,'marcapropia') == '1') {
	$cadRef6 = "<option value='1' selected>Si</option><option value='0'>No</option>";
} else {
	$cadRef6 = "<option value='1'>Si</option><option value='0' selected>No</option>";
}

$resVar1 = $serviciosReferencias->traerTipoFigura();
$cadRef1 = $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1),'',mysql_result($resInformacion,0,'reftipofigura'));

$refdescripcion = array(0=>$cadRef5,1=>$cadRef6,2=>$cadRef1);
$refCampo 	=  array('visible','marcapropia','reftipofigura');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaModificar($idInformacion,'idperfilasesor',$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////////////////////////////  FIN de los opciones //////////////////////////


$lstContactos	= $serviciosFunciones->devolverSelectBox($serviciosReferencias->traerEspecialidades(),array(1),'');
$resContactos = $serviciosReferencias->traerEspecialidades();

$resContactosCountries = $serviciosReferencias->traerPerfilasesoresespecialidadesPorPerfil($idInformacion);


	while ($subrow = mysql_fetch_array($resContactosCountries)) {
			$arrayFS[] = $subrow;
	}



$cadUser = '<ul class="list-inline" id="lstContact">';
while ($rowFS = mysql_fetch_array($resContactos)) {
	$check = '';
	if (mysql_num_rows($resContactosCountries)>0) {
		foreach ($arrayFS as $item) {
			if (stripslashes($item['refespecialidades']) == $rowFS[0]) {
				$check = 'checked';
				$cadUser = $cadUser.'<li class="user'.$rowFS[0].'">'.'<input id="user'.$rowFS[0].'" '.$check.' class="filled-in checkLstContactos" type="checkbox" required="" name="user'.$rowFS[0].'"><label for="user'.$rowFS[0].'">'.$rowFS[1].'</label>'."</li>";
			}
		}
	}
}



$cadUser = $cadUser."</ul>";



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

	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">

	<link rel="stylesheet" type="text/css" href="../../css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="../../css/classic.date.css"/>


	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

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
								<?php echo strtoupper($plural).": ".mysql_result($resultado,0,'apellidopaterno')." ".mysql_result($resultado,0,'apellidomaterno')." ".mysql_result($resultado,0,'nombre'); ?>
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

								<div class="row frmAjaxModificar">
									<?php echo $frmUnidadNegocios; ?>
								</div>
								<div class="row" id="contContacto" style="margin-left:0px; margin-right:25px;">
									<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 margTop  frmContespecialidades" style="display:block">
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				                    <label for="buscarcontacto" class="control-label" style="text-align:left">Buscar Especialidades</label>

			                        <select id="buscarcontacto" name="buscarcontacto" class="form-control show-tick">
			                            <option value=""></option>
			                            <?php echo $lstContactos; ?>
			                        </select>
										</div>
										<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			                        <button style="margin-top:18px;" type="button" class="btn btn-success" id="asignarContacto"><span class="glyphicon glyphicon-share-alt"></span> Asignar Especialidad</button>
										</div>
				                </div>
								 <?php } ?>

				                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				                    <label for="contactosasignados" class="control-label" style="text-align:left">Especialidades Asignadas</label>
				                    <div class="input-group col-md-12">
				                        <?php echo $cadUser; ?>

				                    </div>
				                </div>

				            </div>
							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
								<div class="button-demo" style="margin-top:25px;">
									<button type="submit" class="btn bg-light-blue waves-effect modificarDomicilio">
										<i class="material-icons">save</i>
										<span>GUARDAR</span>
									</button>
								</div>
							<?php } ?>

							</form>

							<div class="row clearfix subirImagen">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<h4>IMAGEN DE PERFIL</h4>
										<a href="javascript:void(0);" class="thumbnail timagen1">
											<img class="img-responsive">
										</a>
										<div id="example1"></div>

									</div>
									<div class="col-xs-6 col-md-6 col-lg-6">
										<h4>FIRMA</h4>
										<a href="javascript:void(0);" class="thumbnail timagen2">
											<img class="img-responsive2">
										</a>
										<div id="example2"></div>

									</div>
								</div>
							</div> <!-- fin del container imagenes -->

							<div class="row clearfix subirImagen contImagenLogo">
								<div class="row">
									<div class="col-xs-6 col-md-6 col-lg-6">
										<h4>LOGO</h4>
										<a href="javascript:void(0);" class="thumbnail timagen3">
											<img class="img-responsive3">
										</a>
										<div id="example3"></div>

									</div>

								</div>
							</div> <!-- fin del container imagenes -->

						</div>
					</div>
				</div>
			</div>

			<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
			<div class="row">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
					<div class="card">
						<div class="header">
							<h2>
								CARGA/MODIFIQUE LA IMAGEN DE PERFIL
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

							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
							<form action="subirinformacion.php" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
								<div class="dz-message">
									<div class="drag-icon-cph">
										<i class="material-icons">touch_app</i>
									</div>
									<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>

								</div>
								<div class="fallback">

									<input name="file" type="file" id="archivos" />
									<input type="hidden" id="idinformacion" name="idinformacion" value="<?php echo $idInformacion; ?>" />


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
								CARGA/MODIFIQUE LA FIRMA
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


							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
							<form action="subirinformacion.php" id="frmFileUpload2" class="dropzone" method="post" enctype="multipart/form-data">
								<div class="dz-message">
									<div class="drag-icon-cph">
										<i class="material-icons">touch_app</i>
									</div>
									<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>

								</div>
								<div class="fallback">

									<input name="file" type="file" id="archivos2" />
									<input type="hidden" id="idinformacion" name="idinformacion" value="<?php echo $idInformacion; ?>" />



								</div>
							</form>
							<?php } ?>
						</div>
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 contSubirLogo">
					<div class="card">
						<div class="header">
							<h2>
								CARGA/MODIFIQUE EL LOGO
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


							<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>
							<form action="subirinformacion.php" id="frmFileUpload3" class="dropzone" method="post" enctype="multipart/form-data">
								<div class="dz-message">
									<div class="drag-icon-cph">
										<i class="material-icons">touch_app</i>
									</div>
									<h3>Arrastre y suelte una imagen O PDF aqui o haga click y busque una imagen en su ordenador.</h3>

								</div>
								<div class="fallback">

									<input name="file" type="file" id="archivos3" />
									<input type="hidden" id="idinformacion" name="idinformacion" value="<?php echo $idInformacion; ?>" />

								</div>
							</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
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

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../js/picker.js"></script>
<script src="../../js/picker.date.js"></script>

<script src="../../plugins/dropzone/dropzone.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<script>
	$(document).ready(function(){

		<?php if ($tipopersona == 1) { ?>
			$('.contImagenLogo').hide();
			$('.frmConturloficial').hide();
			$('.contSubirLogo').hide();
		<?php } ?>

		$('#asignarContacto').click(function(e) {
			//alert($('#buscarcontacto option:selected').html());
			if (existeAsiganado('user'+$('#buscarcontacto').val()) == 0) {
				$('#lstContact').prepend('<li class="user'+ $('#buscarcontacto').val() +'"><input type="checkbox" id="user'+ $('#buscarcontacto').val() +'" name="user'+ $('#buscarcontacto').val() +'" class="filled-in" checked ><label for="user'+ $('#buscarcontacto').val() +'">' + $('#buscarcontacto option:selected').html() + '</label></li>');
			}
		});




		function existeAsiganado(id) {
			var existe = 0;
			$('#lstContact li input').each(function (index, value) {
			  if (id == $(this).attr('id')) {
				return existe = 1;
			  }
			});

			return existe;
		}



		function traerImagen(contenedorpdf, contenedor, imagen) {
			$.ajax({
				data:  {idperfilasesor: <?php echo $idInformacion; ?>,
						imagen: imagen,
						accion: 'traerPerfilasesoresPorIdImagenCompleto'},
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

		traerImagen('example1','timagen1',1);
		traerImagen('example2','timagen2',2);
		traerImagen('example3','timagen3',3);



		<?php if (($_SESSION['idroll_sahilices'] == 1) || ($_SESSION['idroll_sahilices'] == 3) || ($_SESSION['idroll_sahilices'] == 4)) { ?>


		$("#lstContact").on("click",'.checkLstContactos', function(){
			usersid =  $(this).attr("id");

			if  (!($(this).prop('checked'))) {
				$('.'+usersid).remove();
			}
		});

		Dropzone.prototype.defaultOptions.dictFileTooBig = "Este archivo es muy grande ({{filesize}}MiB). Peso Maximo: {{maxFilesize}}MiB.";

		Dropzone.options.frmFileUpload = {
			maxFilesize: 10,
			acceptedFiles: ".jpg,.jpeg",
			accept: function(file, done) {
				done();
			},
			init: function() {
				this.on("sending", function(file, xhr, formData){
						formData.append("idinformacion", '<?php echo $idInformacion; ?>');
						formData.append("iddocumentacion", '88');
				});
				this.on('success', function( file, resp ){
					traerImagen('example1','timagen1',1);
					$('.lblPlanilla').hide();
					swal("Correcto!", resp.replace("1", ""), "success");

				});

				this.on('error', function( file, resp ){
					swal("Error!", resp.replace("1", ""), "warning");
				});
			}
		};


		Dropzone.options.frmFileUpload2 = {
				maxFilesize: 10,
				acceptedFiles: ".jpg,.jpeg",
				accept: function(file, done) {
					done();
				},
				init: function() {
					this.on("sending", function(file, xhr, formData){
						formData.append("idinformacion", '<?php echo $idInformacion; ?>');
						formData.append("iddocumentacion", '89');
		         });
					this.on('success', function( file, resp ){
						traerImagen('example2','timagen2',2);
						$('.lblComplemento').hide();
						swal("Correcto!", resp.replace("1", ""), "success");

					});

					this.on('error', function( file, resp ){
						swal("Error!", resp.replace("1", ""), "warning");
					});
				}
			};


			Dropzone.options.frmFileUpload3 = {
					maxFilesize: 10,
					acceptedFiles: ".jpg,.jpeg",
					accept: function(file, done) {
						done();
					},
					init: function() {
						this.on("sending", function(file, xhr, formData){
							formData.append("idinformacion", '<?php echo $idInformacion; ?>');
							formData.append("iddocumentacion", '90');
			         });
						this.on('success', function( file, resp ){
							traerImagen('example3','timagen3',3);
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
				idinformacion: <?php echo $idInformacion; ?>,
				iddocumentacion: 88
			},
			url: 'subirinformacion.php'
		});

		var myDropzone2 = new Dropzone("#archivos2", {
			params: {
				idinformacion: <?php echo $idInformacion; ?>,
				iddocumentacion: 89
	      },
			url: 'subirinformacion.php'
		});

		var myDropzone3 = new Dropzone("#archivos3", {
			params: {
				idinformacion: <?php echo $idInformacion; ?>,
				iddocumentacion: 90
	      },
			url: 'subirinformacion.php'
		});
		<?php } else { ?>
			$('.frmContvisible').hide();
		<?php } ?>

		$('.frmContreftabla').hide();
		$('.frmContidreferencia').hide();

		$("#sign_in").submit(function(e){
			e.preventDefault();
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


		$('.nuevo').click(function(){

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
