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
	include ('../../includes/funcionesComercio.php');

	$serviciosFunciones 	= new Servicios();
	$serviciosUsuario 		= new ServiciosUsuarios();
	$serviciosHTML 			= new ServiciosHTML();
	$serviciosReferencias 	= new ServiciosReferencias();
	$baseHTML = new BaseHTML();
	$serviciosComercio      = new serviciosComercio();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../venta/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Venta",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';



/*
$EM_Response= $_POST["EM_Response"];
$EM_Total= $_POST["EM_Total"];
$EM_OrderID= $_POST["EM_OrderID"];
$EM_Merchant= $_POST["EM_Merchant"];
$EM_Store= $_POST["EM_Store"];
$EM_Term= $_POST["EM_Term"];
$EM_RefNum= $_POST["EM_RefNum"];
$EM_Auth= $_POST["EM_Auth"];
$EM_Digest= $_POST["EM_Digest"];
*/




switch (trim(str_replace(' ','',$_POST['cc_number']))) {
	case '5062541600005232':
		$EM_Response= 'approved';
		$EM_RefNum= '123456789123';
		$EM_Auth= '123456';
	break;
	case '5105105105105100':
		$EM_Response= 'Incorrect Information is provided.';
		$EM_RefNum= '123456789123';
		$EM_Auth= '000000';
	break;
	case '5555555555554444':
		$EM_Response= 'denied';
		$EM_RefNum= '123456789123';
		$EM_Auth= '000000';
	break;
	case '4111111111111111':
		$EM_Response= 'Duplicated transaction';
		$EM_RefNum= '123456789123';
		$EM_Auth= '000000';
	break;
	default:
		$EM_Response= 'approved';
		$EM_RefNum= '123456789123';
		$EM_Auth= '123456';
	break;

}

if (!(isset($_POST["EM_RefNum"]))) {
	$EM_RefNum= '123456789123';
} else {
	$EM_RefNum= $_POST["EM_RefNum"];
}

if (!(isset($_POST["EM_Auth"]))) {
	$EM_Auth= '123456';
} else {
	$EM_Auth= $_POST["EM_RefNum"];
}


$EM_Total= $_POST["total"];
$EM_OrderID= $_POST["order_id"];
$EM_Merchant= $_POST["merchant"];
$EM_Store= $_POST["store"];
$EM_Term= $_POST["term"];

$EM_Digest= $_POST["digest"];


//$newdigest  = sha1($_POST["EM_Total"].$_POST["EM_OrderID"].$_POST["EM_Merchant"].$_POST["EM_Store"].$_POST["EM_Term"].$_POST["EM_RefNum"]+"-"+$_POST["EM_Auth"]);
$newdigest  = sha1($_POST["total"].$_POST["order_id"].$_POST["merchant"].$_POST["store"].$_POST["term"].$EM_RefNum+"-"+$EM_Auth);

$resultado = $serviciosComercio->traerComercioinicioPorOrderId($EM_OrderID);

if (mysql_num_rows($resultado)>0) {
	$token = mysql_result($resultado,0,'token');
	$idestado = mysql_result($resultado,0,'refestadotransaccion');
} else {
	header('Location: error.php');
	$idestado = 1;
}

if ($idestado == 2) {
	header('Location: ../facturacion/index.php');
}


$error = 0;
$lblError = '';

$instanciaDelError = 0;


switch ($EM_Response) {
   case 'Incorrect Information is provided.':
      $error = 1;
      $lblError = 'La informacion que proporciono de la tarjeta es incorrecta, vuelva a intentarlo';
      $instanciaDelError = 1;
		$idestado = 3;
   break;
   case 'denied':
      $error = 1;
      $lblError = 'Su tarjeta fue rechazada, intente con otra tarjeta';
      $instanciaDelError = 2;
		$idestado = 4;
   break;
   case 'Duplicated transaction':
      $error = 1;
      $lblError = 'Se genero un error, nos comunicaremos con usted en la brevedad';
      $instanciaDelError = 3;
		$idestado = 5;
   break;
   case 'approved':
      $error = 0;
      $lblError = '';
   break;
}

$resTransaccion = $serviciosComercio->insertarComerciofin($EM_Response,$EM_Total,$EM_OrderID,$EM_Merchant,$EM_Store,$EM_Term,$EM_RefNum,$EM_Auth,$EM_Digest,$token);


if ($error == 0) {
	// modifico el estado a aprobado
	$resModificarEstado = $serviciosComercio->modificarComercioInicioEstado($token,2);
} else {
	$resModificarEstado = $serviciosComercio->modificarComercioInicioEstado($token,$idestado);
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
				<div class="col-xs-12">
		        <div class="card">
		          <div class="header bg-<?php echo ($error == 0 ? 'green' : 'red'); ?>">
		            <h4 class="my-0 font-weight-normal">Estado de la transaccion <?php echo ($error == 0 ? 'Correcto' : 'Invalida'); ?></h4>
		          </div>
		          <div class="body table-responsive">
							<div class="text-center">
							<?php if ($error == 0) { ?>
								<h1 class="display-4">Ya procesamos tu pago Correctamente</h1>
								<p class="lead">Desde Asesores CREA nos estaremos comunicando con usted para concluir el servicio.</p>
							<?php } else { ?>
								<h1 class="display-4"><?php echo $lblError; ?></h1>
								<p class="lead">Desde Asesores CREA nos estaremos comunicando con usted para ayudarlo.</p>

								<?php if ($instanciaDelError != 3) { ?>
								<h5>Vuelve a intentar la transaccion</h5>
									<form action="8407825_asesorescrea.php" method="post" id="formFin">
					               <input type="hidden" name="total" value="<?php echo $EM_Total; ?>">
					               <input type="hidden" name="currency" value="<?php echo '484'; ?>">
					               <input type="hidden" name="address" value="<?php echo ''; ?>">
					               <input type="hidden" name="order_id" value="<?php echo $EM_OrderID; ?>">
					               <input type="hidden" name="merchant" value="<?php echo $EM_Merchant; ?>">
					               <input type="hidden" name="store" value="<?php echo $EM_Store; ?>">
					               <input type="hidden" name="term" value="<?php echo $EM_Term; ?>">
					               <input type="hidden" name="digest" value="<?php echo $newdigest; ?>">
					               <input type="hidden" name="return_target" value="">
					               <input type="hidden" name="urlBack" value="../pay/comercio_con.php">
										<div class="row">
										<div class="col-xs-3"></div>
					               <div class="col-xs-6">
											<button type="submit" class="btn btn-lg btn-block btn-success" id="btnConfirmar" style="font-size:1.5em;">
												<i class="material-icons" style="font-size:1.5em;">verified_user</i>
												<span>Adquirir AHORA</span>
											</button>
										</div>
										<div class="col-xs-3"></div>
										</div>
					            </form>
								<?php } ?>
							<?php } ?>
							</div>


		          </div>
		        </div>
			  </div>




			</div>
		</div>
	</div>

</section>




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

		var btnConfirmar = $('#btnConfirmar');

		btnConfirmar.click(function(e) {

			$( "#formPago" ).submit();
		});


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
			"sAjaxSource": "../../json/jstablasajax.php?tabla=especialidades",
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
