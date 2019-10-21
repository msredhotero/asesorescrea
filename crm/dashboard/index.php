<?php

session_start();

if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../error.php');
} else {


include ('../includes/funcionesUsuarios.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funciones.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/base.php');

$serviciosUsuario = new ServiciosUsuarios();
$serviciosHTML = new ServiciosHTML();
$serviciosFunciones = new Servicios();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Dashboard",$_SESSION['refroll_sahilices'],'');

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';



/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Postulante";

$plural = "Postulantes";

$eliminar = "eliminarPostulantes";

$insertar = "insertarPostulantes";

$modificar = "modificarPostulantes";

//$tituloWeb = "Gestión: Talleres";

$tabla 			= "dbpostulantes";

$lblCambio	 	= array('refusuarios','refescolaridades','fechanacimiento','codigopostal','refestadocivil','refestadopostulantes','apellidopaterno','apellidomaterno','telefonomovil','telefonocasa','telefonotrabajo','sexo','nacionalidad');
$lblreemplazo	= array('Usuario','Escolaridad','Fecha de Nacimiento','Cod. Postal','Estado Civil','Estado','Apellido Paterno','Apellido Materno','Tel. Movil','Tel. Casa','Tel. Trabajo','Sexo','Nacionalidad');


$cadRef1 	= "<option value='0'>Se genera automaticamente</option>";

$resVar2	= $serviciosReferencias->traerEscolaridades();
$cadRef2 = $serviciosFunciones->devolverSelectBox($resVar2,array(1),'');

$resVar3	= $serviciosReferencias->traerEstadocivil();
$cadRef3 = $serviciosFunciones->devolverSelectBox($resVar3,array(1),'');

$resVar4	= $serviciosReferencias->traerEstadopostulantesPorId(1);
$cadRef4 = $serviciosFunciones->devolverSelectBox($resVar4,array(1),'');

$cadRef5 = "<option value=''>-- Seleccionar --</option><option value='1'>Femenino</option><option value='2'>Masculino</option>";

$cadRef6 	= "<option value='Mexico'>Mexico</option>";

$refdescripcion = array(0=> $cadRef1,1=> $cadRef2,2=> $cadRef3,3=> $cadRef4 , 4=>$cadRef5,5=>$cadRef6);
$refCampo 	=  array('refusuarios','refescolaridades','refestadocivil','refestadopostulantes','sexo','nacionalidad');

$frmUnidadNegocios 	= $serviciosFunciones->camposTablaViejo($insertar ,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);
//////////////////////// Fin opciones ////////////////////////////////////////////////


/////////////////////// Opciones para la creacion del formulario  /////////////////////

if ($_SESSION['idroll_sahilices'] == 1) {

} else {


}

///////////////////////////              fin                   ////////////////////////

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?php echo $tituloWeb; ?></title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <?php echo $baseHTML->cargarArchivosCSS('../'); ?>

	 <!-- CSS file -->
	<link rel="stylesheet" href="../css/easy-autocomplete.min.css">

	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../css/easy-autocomplete.themes.min.css">



	 <!-- Morris Chart Css-->
    <link href="../plugins/morrisjs/morris.css" rel="stylesheet" />

	 <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

	 <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />

	 <link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
 	<link rel="stylesheet" href="../DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

    <style>
        .alert > i{ vertical-align: middle !important; }
		  .contDisponibilidad table { table-layout: fixed !important; }
		  .contDisponibilidad table tbody tr td { border: 1px solid #444; padding: 0 !important; width: 100px !important;overflow: auto !important; text-align: center;}
		  .contDisponibilidad table thead tr th { border: 1px solid #222 !important;width: 100px !important; overflow: auto !important;}
		  .tablaInterna tbody tr td { padding: 0; width: 100px !important; height: 20px; text-align: center;}
		  .disponibilidadLloguer { cursor: pointer; }
		  .modal-header-ver {
				padding:9px 15px;
				border-bottom:1px solid #eee;
				background-color: #0480be;
				color: white;
				font-weight: bold;
        }
    </style>

</head>

<body class="theme-blue">

    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-blue">
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
    <?php echo $baseHTML->cargarSECTION($_SESSION['usua_sahilices'], $_SESSION['nombre_sahilices'], str_replace('..','../dashboard',$resMenu),'../'); ?>

    <section class="content" style="margin-top:-35px;">

		<div class="container-fluid">
			<!-- Widgets -->
			<div class="row clearfix">

					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card ">
							<div class="header bg-blue">
								<h2 style="color:#fff">
									POSTULANTES
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
								<form class="form" id="formFacturas">

								<div class="row" style="padding: 5px 20px;">
									<table id="example" class="display table " style="width:100%">
										<thead>
											<tr>
												<th>Nombre</th>
												<th>Apellido P.</th>
												<th>Apellido M.</th>
												<th>Email</th>
												<th>Tel.</th>
												<th>Cod. Postal</th>
												<th>Fecha</th>
												<th>Estado</th>
												<th>Acciones</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<th>Nombre</th>
												<th>Apellido P.</th>
												<th>Apellido M.</th>
												<th>Email</th>
												<th>Tel.</th>
												<th>Cod. Postal</th>
												<th>Fecha</th>
												<th>Estado</th>
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


    </section>




    <?php echo $baseHTML->cargarArchivosJS('../'); ?>

	 <script src="../js/jquery.easy-autocomplete.min.js"></script>

	 <script src="../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

	 <!-- Bootstrap Material Datetime Picker Plugin Js -->
	 <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>



	<script>
		$(document).ready(function(){

			var table = $('#example').DataTable({
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "../json/jstablasajax.php?tabla=postulantes",
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

			function frmAjaxModificar(id) {
				$.ajax({
					url: '../ajax/ajax.php',
					type: 'POST',
					// Form data
					//datos del formulario
					data: {accion: 'frmAjaxModificar',tabla: '<?php echo $tabla; ?>', id: id,ruta:'postulantes/'},
					//mientras enviamos el archivo
					beforeSend: function(){
						$('.frmAjaxModificar').html('');
					},
					//una vez finalizado correctamente
					success: function(data){

						if (data != '') {
							$(location).attr('href', data);

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

			$("#example").on("click",'.btnModificar', function(){
				idTable =  $(this).attr("id");
				frmAjaxModificar(idTable);

			});//fin del boton modificar

			$('.maximizar').click(function() {
				if ($('.icomarcos').text() == 'web') {
					$('#marcos').show();
					$('.content').css('marginLeft', '275px');
					$('.icomarcos').html('aspect_ratio');
				} else {
					$('#marcos').hide();
					$('.content').css('marginLeft', '15px');
					$('.icomarcos').html('web');
				}

			});

			$("#example").on("click",'.btnDescargar', function(){
				usersid =  $(this).attr("id");

				url = "descargaradmin.php?token=" + usersid;
				$(location).attr('href',url);

			});//fin del boton modificar

			$('.guardar').click(function(e){

				e.preventDefault();
		      if ($('.formulario')[0].checkValidity()) {
				//información del formulario
				var formData = new FormData($(".formulario")[0]);
				var message = "";
				//hacemos la petición ajax
				$.ajax({
					url: '../ajax/ajax.php',
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
