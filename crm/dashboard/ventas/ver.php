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
include ('../../includes/vrim.api.class.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();

//*** SEGURIDAD ****/
include ('../../includes/funcionesSeguridad.php');
$serviciosSeguridad = new ServiciosSeguridad();
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../ventas/');

$arRoles = array(1,4,11,7,10);
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Polizas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';

/////////////////////// Opciones pagina ///////////////////////////////////////////////
$singular = "Poliza";

$plural = "Polizas";

$eliminar = "eliminarVentas";

$insertar = "insertarVentas";

$modificar = "modificarVentas";

//////////////////////// Fin opciones ////////////////////////////////////////////////
$id = $_GET['id'];

$resultado = $serviciosReferencias->traerVentasPorId($id);

/////////////////////// Opciones para la creacion del formulario  /////////////////////
$tabla 			= "dbventas";

$lblCambio	 	= array('refcotizaciones','primaneta','primatotal','foliotys','foliointerno','fechavencimientopoliza','nropoliza','fechaemision','vigenciadesde','reftipomoneda','comisioncedida','gastosexpedicion','iva','refmotivorechazopoliza');
$lblreemplazo	= array('Venta','Prima Neta','Prima Total','Folio TYS','Folio Interno','Fecha Vencimiento de la Poliza','Nro Poliza','Fecha de Emision','Vigencia Desde','Tipo Moneda','Comision Cedida','Gastos de Expedición','IVA','Motivo de rechazo');

$modificar = "modificarVentas";
$idTabla = "idventa";

$resVar = $serviciosReferencias->traerCotizacionesPorIdCompleto(mysql_result($resultado,0,'refcotizaciones'));
$cadRef = $serviciosFunciones->devolverSelectBoxActivo($resVar,array(1,2,3),' ',mysql_result($resultado,0,'refcotizaciones'));

$resVar1 = $serviciosReferencias->traerEstadoventa();
$cadRef2 = $serviciosFunciones->devolverSelectBoxActivo($resVar1,array(1),' ',mysql_result($resultado,0,'refestadoventa'));

$resTipoMoneda = $serviciosReferencias->traerTipomoneda();
$cadTipoMoneda = $serviciosFunciones->devolverSelectBoxActivo($resTipoMoneda,array(1),'',mysql_result($resultado,0,'reftipomoneda'));

$resMotivoRechazo = $serviciosReferencias->traerMotivorechazopolizaPorId(mysql_result($resultado,0,'refmotivorechazopoliza'));
$cadMotivoRechazo = $serviciosFunciones->devolverSelectBox($resMotivoRechazo,array(1),'');

$refdescripcion = array(0=>$cadRef,1=>$cadRef2, 2=> $cadTipoMoneda, 3=>$cadMotivoRechazo);
$refCampo 	=  array('refcotizaciones','refestadoventa','reftipomoneda','refmotivorechazopoliza');

$formulario = $serviciosFunciones->camposTablaModificar($id, $idTabla,$modificar,$tabla,$lblCambio,$lblreemplazo,$refdescripcion,$refCampo);

//////////////////////////////////////////////  FIN de los opciones //////////////////////////

$resPeriodicidad = $serviciosReferencias->traerPeriodicidadventasPorVenta($id);


$resRenovacion = $serviciosReferencias->traerRenovacionesPorVentaNueva($id);

if (mysql_num_rows($resRenovacion) > 0) {
	$idrenovacion = mysql_result($resRenovacion,0,0);

	$existeRenovacion = 1;

	$resVentasVieja = $serviciosReferencias->traerVentasPorId(mysql_result($resRenovacion,0,'refventas'));

	$polizaVieja = mysql_result($resVentasVieja,0,'nropoliza');
	$fechavencimientoVieja = mysql_result($resVentasVieja,0,'fechavencimientopoliza');
} else {
	$existeRenovacion = 0;
	$idrenovacion = 0;
}

$resCotizacionesHuerfanas = $serviciosReferencias->traerCotizacionesHuerfanas(mysql_result($resVar,0,'refclientes'), mysql_result($resVar,0,'refproductos'), mysql_result($resVar,0,'refasesores'));

//die(var_dump($resCotizacionesHuerfanas));

$cadCotizacionesHuerfanas = $serviciosFunciones->devolverSelectBox($resCotizacionesHuerfanas,array(1),'');

/*
$vrimAPI = new ApiVrim('password', 'as350rcr3a', 'vr1m@2021_cr3a',$_SESSION['usua_sahilices']);

$token = $vrimAPI->tokenVRIM();

if ($vrimAPI->getError() == '') {
	echo $vrimAPI->getAccesstoken();
} else {
	echo $vrimAPI->getError();
}
*/

/*
$arCliente = [];

$arCliente['tipoPersona'] = 1;
$arCliente['razonSocial'] = '';
$arCliente['nombre'] = 'marcos';
$arCliente['apellidoPaterno'] = 'prueba';
$arCliente['apellidoMaterno'] = 'prueba';
$arCliente['fechaNacimiento'] = '1985/05/20';
$arCliente['correo'] = 'msredhotero@gmail.com';
$arCliente['TelefonoFijo'] = '';
$arCliente['Celular'] = '2216184415';

$arPedidos = [];

$arTarjeta = [];

$arTarjeta['nombre'] = 'marcos';
$arTarjeta['apellidoPaterno'] = 'prueba';
$arTarjeta['apellidoMaterno'] = 'prueba';
$arTarjeta['fechaNacimiento'] = '1985/05/20';
$arTarjeta['correo'] = 'msredhotero@gmail.com';
$arTarjeta['Celular'] = '2216184415';

$arPedidos = array('cveProducto'=>'VD20','Tarjetas'=>$arTarjeta);

//$arTotal = [$cveAsesor,$tipoAsesor,$cveOficina,$tipoOficina,$tipoSolicitud,$arCliente,$arPedidos];



$params = array(
	'cveAsesor' => '28222',
	'tipoAsesor' => '1',
	'cveOficina' => '1220',
	'tipoOficina' => '2',
	'tipoSolicitud' => 12,
	'Cliente' => $arCliente,
	'Pedidos' => $arPedidos,
);

$cadenaCURL = json_encode($params);

$cadenaFinalCURL = str_replace('}}}','}]}]}',str_replace('"Tarjetas":','"Tarjetas":[',str_replace(',"Pedidos":','],"Pedidos":[',str_replace('"Cliente":','"Cliente":[',$cadenaCURL))));


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://www.salud-interactiva.com/apisolicitudVRIM/API/SOLICITUD",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $cadenaFinalCURL,
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer Nd/a7b(twLCw:c.144tL}!3z1zZrs_svC.mOslrFWrha{8n{4s-AU3sl(C(Sea:o#5U-.=GANKKmXJc_,V7Q{qhnfUBH9L/xsI6B13W)V))*a=Nm6]JU!:apFdd[z}uUu2FFhBNBX*9Ag2F2$3h=W0(l1CAFGSVNp#d&5APub_([Gq,kN)O]dzT4)mkXFAPPvo69Fr-2zPZI:,rqqb*wRy([7/{Yb?Ld(8B!mJe,[swrq{!]CK,cC#YJn(",
    "Content-Type: application/json",
    "Postman-Token: 51b9d58e-36e1-4790-9476-e1daf4878520",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

*/


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
							<?php if ($existeRenovacion == 1) { ?>
								<div class="alert alert-warning">
									<p>Esta Poliza es una renovación de la <b>Poliza: <?php echo $polizaVieja; ?></b> , fecha de vencimiento: <b><?php echo $fechavencimientoVieja; ?></p>
								</div>

							<?php } ?>
							<form class="formulario frmModificar" role="form" id="sign_in">
								<div class="row">
									<?php echo $formulario; ?>
								</div>
								<div class="row">
									<div class="button-demo">
										<button type="button" class="btn btn-black waves-effect btnVolver">
											<i class="material-icons">arrow_back</i>
											<span>VOLVER</span>
										</button>
										<?php if (array_search($_SESSION['idroll_sahilices'], $arRoles) >= 0) { ?>
											<button type="submit" class="btn bg-light-blue waves-effect modificar">
												<i class="material-icons">save</i>
												<span>GUARDAR</span>
											</button>


										<button type="button" class="btn bg-green waves-effect btnArchivos">
											<i class="material-icons">unarchive</i>
											<span>SUBIR POLIZA</span>
										</button>
										<button type="button" class="btn bg-orange waves-effect btnPagos">
											<i class="material-icons">update</i>
											<span>FORMA DE PAGO</span>
										</button>
										<?php if (mysql_num_rows($resPeriodicidad)>0) { ?>
											<button type="button" class="btn bg-grey waves-effect btnRecibos">
												<i class="material-icons">format_list_numbered</i>
												<span>COBROS - RECIBOS</span>
											</button>
										<?php } ?>
										<button type="button" class="btn bg-cyan waves-effect btnContactos">
											<i class="material-icons">supervisor_account</i>
											<span>CONTACTOS</span>
										</button>
										<?php } ?>
										<?php if ((mysql_result($resultado,0,'refestadoventa') == 6) && (mysql_num_rows($resPeriodicidad)>0)) { ?>
										<button type="button" class="btn bg-black waves-effect btnActivar">
											<i class="material-icons">done_all</i>
											<span>ACTIVAR</span>
										</button>
										<?php } ?>


									</div>
								</div>
								<hr>
								<div class="row">
									<p>Cambiar la cotización por la que esta en entregadas para corregir cotizaciones huérfanas</p>
									<div class="button-demo">
										<select class="form-control" name="refcotizacioneshuerfanas" id="refcotizacioneshuerfanas">
											<?php echo $cadCotizacionesHuerfanas; ?>
										</select>
										<button type="button" class="btn bg-brown waves-effect btnCambiar">
											<i class="material-icons">compare_arrows</i>
											<span>CAMBIAR</span>
										</button>
									</div>
								</div>

							</form>

						</div>
					</div>
				</div>
			</div>
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


		<div class="modal fade" id="lgmENVIAR" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
						<div class="modal-header bg-green">
							<h4>IMPORTANTE</h4>
						</div>
						<div class="modal-body">
						<div class="row">
							<h4>¿Estas seguro que quieres ACTIVAR la poliza?.</h4>
						</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success waves-effect btnActivarPoliza" data-dismiss="modal">ACTIVAR</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>

				  </div>
			 </div>
		</div>


		<div class="modal fade" id="lgmCAMBIO" tabindex="-1" role="dialog">
			 <div class="modal-dialog modal-lg" role="document">
				  <div class="modal-content">
						<div class="modal-header bg-green">
							<h4>IMPORTANTE</h4>
						</div>
						<div class="modal-body">
						<div class="row">
							<h4>¿Estas seguro que quieres CAMBIAR la cotización?.</h4>
						</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success waves-effect btnCambiarCotizacion" data-dismiss="modal">CAMBIAR</button>
							<button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
						</div>

				  </div>
			 </div>
		</div>


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


<script>
	$(document).ready(function(){

		$('.btnCambiar').click(function() {
			$('#lgmCAMBIO').modal();
		});

		$('.btnCambiarCotizacion').click(function() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'cambiarCotizacionHuerfana',
					id: <?php echo $id; ?>,
					refcotizacioneshuerfanas: $('#refcotizacioneshuerfanas').val()
				},
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
							timer: 2000,
							showConfirmButton: false
						});

						location.reload();
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
		});

		$('#iva').number( true, 2 ,'.','');
		$('#comisioncedida').number( true, 2 ,'.','');
		$('#financiamiento').number( true, 2 ,'.','');
		$('#gastosexpedicion').number( true, 2 ,'.','');

		$('.btnActivar').click(function() {
			$('#lgmENVIAR').modal();
		});

		$('.btnActivarPoliza').click(function() {
			aceptarPolizarAgente();
		});

		//
		function tokenVRIM() {
			$.ajax({
				url: 'https://www.salud-interactiva.com/apisolicitudVRIM/API/TOKEN',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					grant_type: 'password',
					username: 'as350rcr3a',
					password: 'vr1m@2021_cr3a'
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					alert(data);
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

		//tokenVRIM();



		function solicitudVRIM() {

			var arCliente = [];

			arCliente['tipoPersona'] = 1;
			arCliente['razonSocial'] = '';
			arCliente['nombre'] = 'marcos';
			arCliente['apellidoPaterno'] = 'prueba';
			arCliente['apellidoMaterno'] = 'prueba';
			arCliente['fechaNacimiento'] = '1985/05/20';
			arCliente['correo'] = 'msredhotero@gmail.com';
			arCliente['TelefonoFijo'] = '2216184415';
			arCliente['Celular'] = '2216184415';

			var arPedidos = [];

			arPedidos['cveProducto'] = 'VD20';

			var arTarjeta = [];

			arTarjeta['nombre'] = 'marcos';
			arTarjeta['apellidoPaterno'] = 'prueba';
			arTarjeta['apellidoMaterno'] = 'prueba';
			arTarjeta['fechaNacimiento'] = '1985/05/20';
			arTarjeta['correo'] = 'msredhotero@gmail.com';
			arTarjeta['Celular'] = '2216184415';

			arPedidos['Tarjetas'] = arTarjeta;

			//console.log(arPedidos);

			$.ajax({
				"async": true,
				"crossDomain": true,
				"url": "https://www.salud-interactiva.com/apisolicitudVRIM/API/SOLICITUD",
				"method": "POST",
				"headers": {
					"Content-Type": "application/json",
					"Authorization": "Bearer ]1f%U]Ncs0.lqtf,%Mec,0-&mibD[Myg49TPvrihW-54aAx8Ax658o!S45D3BS7Dwa*vqrwo;=x}YNeg?]WMn8%X};a:J!L*XjqQC{y#KV%*?$Utq3/uAyl13mno_oKSm69z-eZ[gXIq__yJ(Uvl,(0*{6w1e-=%T1ZDTki{o,:*NJ70Zin==5K/-*cVWnjkiNBN5LDB3nAQ:*x#+bu.e+.topJH.S-(its+_iTWCqHZxK]IM(ViKxGie:",
					"cache-control": "no-cache",
					"Access-Control-Allow-Headers" : "Content-Type",
					"Access-Control-Allow-Origin": "http://localhost",
					"Access-Control-Allow-Methods": "OPTIONS,POST,GET"
				},
				"processData": false,
				// Form data
				//datos del formulario
				data: {
					cveAsesor: '28222',
					tipoAsesor: '1',
					cveOficina: '1220',
					tipoOficina: '2',
					tipoSolicitud: 12,
					Cliente: arCliente,
					Pedidos: arPedidos
				},
				method: 'POST',
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){
					alert(data);
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

		//solicitudVRIM();



		function aceptarPolizarAgente() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'aceptarPolizarAgente',
					id: <?php echo $id; ?>
				},
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
							timer: 1000,
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

		$('.btnVolver').click(function() {
			url = "index.php";
			$(location).attr('href',url);
		});

		$('.btnContactos').click(function() {
			url = "contactos.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});



		$('.frmContrefventas').hide();
		$('.frmContrefproductosaux').hide();
		<?php if (mysql_result($resultado,0,'refestadoventa') == 9) { ?>
			$('.frmContrefmotivorechazopoliza').show();
		<?php } else { ?>
			$('.frmContrefmotivorechazopoliza').hide();
		<?php } ?>

		$('.btnArchivos').click(function() {
			url = "subirdocumentacion.php?id=<?php echo $id; ?>&documentacion=35";
			$(location).attr('href',url);
		});

		$('.btnPagos').click(function() {
			url = "periodicidad.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});

		$('.btnRecibos').click(function() {
			url = "cobros.php?id=<?php echo $id; ?>";
			$(location).attr('href',url);
		});





		$('.btnCalcularM').click(function() {
			calcularBonoMonto();
		});

		$('.btnCalcularP').click(function() {
			calcularBonoPorcentaje();
		});

		function calcularBonoPorcentaje() {
			if (($('#montocomision').val() > 0) && $('#primaneta').val() > 0) {
				$('#porcentajecomision').val( parseFloat(parseFloat($('#montocomision').val()) * 100 / parseFloat($('#primaneta').val())) );
			} else {
				$('#porcentajecomision').val( 0);
			}
		}

		function calcularBonoMonto() {
			if (($('#porcentajecomision').val() > 0) && $('#primaneta').val() > 0) {
				$('#montocomision').val( parseFloat(parseFloat($('#porcentajecomision').val()) / 100 * parseFloat($('#primaneta').val())) );
			} else {
				$('#montocomision').val( 0);
			}
		}


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
			"sAjaxSource": "../../json/jstablasajax.php?tabla=ventas",
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

		$('#primaneta').number( true, 2 ,'.','');
		$('#primatotal').number( true, 2,'.','' );
		$('#montocomision').number( true, 2,'.','' );
		$('#porcentajecomision').number( true, 2,'.','' );

		$('#fechavencimientopoliza').pickadate({
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





		$('.frmModificar').submit(function(e){

			e.preventDefault();
			if ($('.frmModificar')[0].checkValidity()) {

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
