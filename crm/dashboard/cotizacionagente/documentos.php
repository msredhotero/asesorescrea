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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../cotizacionagente/');
//*** FIN  ****/

$fecha = date('Y-m-d');

//$resProductos = $serviciosProductos->traerProductosLimite(6);
$resMenu = $serviciosHTML->menu($_SESSION['nombre_sahilices'],"Cotizaciones Recibidas",$_SESSION['refroll_sahilices'],$_SESSION['email_sahilices']);

$configuracion = $serviciosReferencias->traerConfiguracion();

$tituloWeb = mysql_result($configuracion,0,'sistema');

$breadCumbs = '<a class="navbar-brand" href="../index.php">Dashboard</a>';


$token = $_SESSION['token_ac'];

if (!(isset($token))) {
	header('Location: index.php');
}

$resultadoToken = $serviciosReferencias->traerTokenasesoresPorTokenActivo($token);


if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resMetodoPago = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

$refEstadoCotizacion = mysql_result($resCotizaciones,0,'refestadocotizaciones');

$resProducto = $serviciosReferencias->traerProductosPorId($idProducto);

$idcuestionario = mysql_result($resProducto,0,'refcuestionarios');

$detalleProducto = mysql_result($resProducto,0,'detalle');

$tipoFirma = mysql_result($resProducto,0,'reftipofirma');

$consolicitud = mysql_result($resProducto,0,'consolicitud');

$cargados = 0;
$necesariasParaAprobar = 0;

$arDocumentacionRechazadas = array();

if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencibleAsegurado(mysql_result($resCotizaciones,0,'refasegurados'),$idcuestionario);
	//asegurado
	$resAsegurado = $serviciosReferencias->traerAseguradosPorId(mysql_result($resCotizaciones,0,'refasegurados'));


	if (mysql_num_rows($resAsegurado)>0) {
		$lblAsegurado = mysql_result($resAsegurado,0,'apellidopaterno').' '.mysql_result($resAsegurado,0,'apellidomaterno').' '.mysql_result($resAsegurado,0,'nombre');

		$idAsegurado = mysql_result($resAsegurado,0,0);

		$documentacionesrequeridasAsegurado = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacionCompletaIn(mysql_result($resAsegurado,0,0),'3,4');

		while ($rowD = mysql_fetch_array($documentacionesrequeridasAsegurado)) {
			//if (($rowD['archivo'] != '') && ($rowD['idestadodocumentacion'] == 5)) {
			if (($rowD['archivo'] != '')) {
				$cargados += 1;
			}

			if (($rowD['idestadodocumentacion'] == 2) || ($rowD['idestadodocumentacion'] == 3) || ($rowD['idestadodocumentacion'] == 4)) {
				array_push($arDocumentacionRechazadas,array(
					'iddocumentacion' =>$rowD['iddocumentacion'],
					'quien' => 'Asegurado',
					'documentacion' => $rowD['documentacion'],
					'estado'=>$rowD['estadodocumentacion']
					)
				);
			}

			$necesariasParaAprobar += 1;
			//$necesariasParaAprobar += 0;
		}


	}

} else {
	$lblAsegurado = mysql_result($resCotizaciones,0,'clientesolo');
}

if (mysql_result($resCotizaciones,0,'tieneasegurado') == '0') {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencible($idCliente,$idcuestionario);
}


if (mysql_result($resCotizaciones,0,'refbeneficiarios') > 0) {
	// beneficiario
	$resBeneficiario = $serviciosReferencias->traerAseguradosPorId(mysql_result($resCotizaciones,0,'refbeneficiarios'));
	// beneficiario nombre completo
	$lblBeneficiario = mysql_result($resBeneficiario,0,'apellidopaterno').' '.mysql_result($resBeneficiario,0,'apellidomaterno').' '.mysql_result($resBeneficiario,0,'nombre');
} else {
	$lblBeneficiario = mysql_result($resCotizaciones,0,'clientesolo');
}

if (!(isset($resDatosSencibles))) {
	$resDatosSencibles = $serviciosReferencias->necesitoPreguntaSencibleAsegurado(0,$idcuestionario);
}

if (mysql_num_rows($resCotizaciones)>0) {
	$precio = mysql_result($resCotizaciones,0,'primatotal');
	$lblPrecio = str_replace('.','',$precio);
	$lblPrecioAd = str_replace('.','',$precio * 1.2);
} else {
	header('Location: index.php');
}


$resultado = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$cuestionario = $serviciosReferencias->traerCuestionariodetallePorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id);


if (mysql_num_rows($resMetodoPago)>0) {
	$existeMetodoPago = 1;

	// creo el archivo grande
	// pregunto rpimero si existe.
	$pathSolcitud  = '../../archivos/solicitudes/cotizaciones/'.$id;

	if (!file_exists($pathSolcitud)) {
		mkdir($pathSolcitud, 0777);
	}

	$filesSolicitud = array_diff(scandir($pathSolcitud), array('.', '..'));
	if (count($filesSolicitud) < 1) {
		//die(var_dump(__DIR__));

		require ('../../reportes/rptFTodos.php');

	}
} else {
	$existeMetodoPago = 0;
}

$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');


while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
	//if (($rowD['archivo'] != '') && ($rowD['idestadodocumentacion'] == 5)) {
	if (($rowD['archivo'] != '')) {
		$cargados += 1;
	}

	if (($rowD['idestadodocumentacion'] == 2) || ($rowD['idestadodocumentacion'] == 3) || ($rowD['idestadodocumentacion'] == 4)) {
		array_push($arDocumentacionRechazadas,array(
			'iddocumentacion' =>$rowD['iddocumentacion'],
			'quien' => 'Contratante',
			'documentacion' => $rowD['documentacion'],
			'estado'=>$rowD['estadodocumentacion']
			)
		);
	}

	$necesariasParaAprobar += 1;
}




//////////////////// verifico en el proceso si firma con fiel, simple o autografa ////////////////

// verifico si necesita una solicitud
if ($consolicitud == 1) {
	$generoFirmaAlFinal = 0;

	$solicitudParaFirmar = '../../archivos/solicitudes/cotizaciones/'.$id.'/FSOLICITUDAC.pdf';
	if ($tipoFirma == 2) {
		$resNIP = $serviciosReferencias->traerTokensPorCotizacionVigente($id);

		if (mysql_num_rows($resNIP) > 0) {
			$existeNIP = 1;
			$nip = mysql_result($resNIP,0,'token');
		} else {

			$reftipo = 1;
		   $token = $serviciosReferencias->generarNIP();

		   $fechacreac = date('Y-m-d H:i:s');
		   $nuevafecha = strtotime ( '+15 hour' , strtotime ( $fechacreac ) ) ;

		   $refestadotoken = 1;
		   $vigenciafin = $nuevafecha;

		   $res = $serviciosReferencias->insertarTokens($id,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin);

		   if ((integer)$res > 0) {

		      $resCliente = $serviciosReferencias->traerClientesPorId($idCliente);

		      $email = mysql_result($resCliente,0,'email');

		      $cuerpo = '';

		      $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

		      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

		      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

		      $cuerpo .= "
		      <style>
		      	body { font-family: 'Lato', sans-serif; }
		      	header { font-family: 'Prata', serif; }
		      </style>";



		      $cuerpo .= '<body>';

		      $cuerpo .= '<h3><small><p>Este es el nuevo NIP generado para firmar digitalmente el servicio solicitado, por favor ingrese al siguiente <a href="https://asesorescrea.com/desarrollo/crm/dashboard/venta/documentos.php?id='.$id.'" target="_blank"> enlace </a> para finalizar el proceso de venta. </small></h3><p>';

				$cuerpo .= "<center>NIP:<b>".$token."</b></center><p> ";

				$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

		      $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

		      $cuerpo .= '</body>';

		   	$fecha = date_create(date('Y').'-'.date('m').'-'.date('d'));
		   	date_add($fecha, date_interval_create_from_date_string('30 days'));
		   	$fechaprogramada =  date_format($fecha, 'Y-m-d');

		   	//$res = $this->insertarActivacionusuarios($refusuarios,$token,'','');

		   	$retorno = $serviciosReferencias->enviarEmail($email,'NIP para firma',utf8_decode($cuerpo));

		      echo '';

				$existeNIP = 1;
		   } else {
				$existeNIP = 0;
			}

		}

	} else {
		if ($tipoFirma == 3) {




			$resNIP = $serviciosReferencias->traerTokensPorCotizacionVigente($id);

			if (mysql_num_rows($resNIP) > 0) {
				$existeNIP = 1;
				$nip = mysql_result($resNIP,0,'token');


			} else {
				///////////// firma fiel, creo los documentos a firmar //////////////////
				// convierto el documento a base64

				//die(var_dump($solicitudParaFirmar));

				$generoFirmaAlFinal = 1;

				$arFile = file_get_contents($solicitudParaFirmar);
				//$b64Doc = chunk_split(base64_encode($arFile));
				$b64Doc = base64_encode($arFile);

				//die(var_dump($b64Doc));

				$ch = curl_init();
				$url = 'https://qafirma.signaturainnovacionesjuridicas.com/api/documentos/crear/';
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

				$data = array(
				   'b64documento'=> $b64Doc,
					'firmantes'=> array(array('curp'=> 'TOMG730101MDFLZM00')),
					'nombreDocumento' => 'FSOLICITUDAC.pdf'
				);

				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
				//set the content type to application/json
				curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

				//return response instead of outputting
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				//execute the POST request
				$result = curl_exec($ch);
				curl_close($ch);

				$arEFirma = json_decode($result, true);

				//die(var_dump($arEFirma));

				if (isset($arEFirma)) {
					$nuevoToken = $arEFirma['urls']['url'][0];
				} else {
					$nuevoToken = '';
				}

				////////////////////////// fin de la firma fiel //////////////////////////

				$reftipo = 2;
				// aca va la url que me genero para firmar
			   $token = $nuevoToken;

			   $fechacreac = date('Y-m-d H:i:s');
			   $nuevafecha = strtotime ( '+48 hour' , strtotime ( $fechacreac ) ) ;

			   $refestadotoken = 1;
			   $vigenciafin = $nuevafecha;

				if ($token != '') {
					$res = $serviciosReferencias->insertarTokens($id,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin);

					if ((integer)$res > 0) {
						$existeNIP = 1;
					} else {
						$existeNIP = 0;
					}
				} else {
					$existeNIP = 2;
				}


			}


		} else {

		}
	}


	$puedeContinuar = 0;

	$resFirma = $serviciosReferencias->traerFirmarcontratosPorCotizacion($id);
	if (mysql_num_rows($resFirma) > 0) {
		$existeFirma = 1;
		$refestadofirma = mysql_result($resFirma,0,'refestadofirma');
		if ($refestadofirma == 1) {
			$puedeContinuar = 1;
		} else {
			$puedeContinuar = 0;
		}
	} else {
		$existeFirma = 0;
	}

	// fin de if de con solicitud
} else {
	$puedeContinuar = 1;
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
		.pdfobject-container {
		   max-width: 100%;
			height: 600px;
			border: 10px solid rgba(0,0,0,.2);
			margin: 0;
		}
		.numero {
			font-size:2.6em;
			height:80px;
			text-align:center;
			font-family: arial;
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
				<div class="col-xs-12">
		        <div class="card">
		          <div class="header bg-blue">
		            <h4 class="my-0 font-weight-normal">Resumen del Pedido: <?php echo mysql_result($resultado,0,'producto'); ?></h4>
		          </div>
		          <div class="body table-responsive">



						<?php if ($cargados != $necesariasParaAprobar) { ?>
							<?php if (count($arDocumentacionRechazadas) > 0) { ?>
								<div>
									<div class="alert bg-orange">
										<i class="material-icons">report_problem</i> <b>Alguno de de los documentos fue rechazado, vuela a subir los siguientes archivos.</b>
									</div>
									<ul class="list-group">
										<?php foreach ($arDocumentacionRechazadas as $item) { ?>
										<li class="list-group-item"><?php echo $item['documentacion']; ?> <span class="badge bg-red"><?php echo $item['estado']; ?></span></li>
										<?php } ?>
										<li class="list-group-item"><a href="archivos.php?id=<?php echo $id; ?>">SUBIR ARCHIVOS</a></li>
									</ul>
								</div>
							<?php } else { ?>
							<div>
								<div class="alert bg-orange">
									<i class="material-icons">report_problem</i> <b>Sus documentos no fueron verificados aun, se te enviara un email para poder continuar con el proceso.</b>
								</div>
							</div>
							<?php } ?>
						<?php } else { ?>
							<?php if ($puedeContinuar == 1) { ?>
								<?php if ($consolicitud == 1) { ?>
								<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
								   <div class="col-xs-6 bs-wizard-step complete">
										<div class="text-center bs-wizard-stepnum">Paso 1</div>

										<div class="progress">
											<div class="progress-bar"></div>
										</div>

										<a href="siap.php?id=13" class="bs-wizard-dot"></a>
										<div class="bs-wizard-info text-center">CARGA TUS DOCUMENTOS</div>
								   </div>

								   <div class="col-xs-6 bs-wizard-step complete">
										<div class="text-center bs-wizard-stepnum">Paso 2</div>
										<div class="progress">
											<div class="progress-bar"></div>
										</div>
										<a href="javascript:void(0)" class="bs-wizard-dot"></a>
										<div class="bs-wizard-info text-center">FIRMAR LA SOLICITUD DE FORMA DIGITAL</div>
								   </div>

							   </div>
							<?php } else { ?>
								<div class="bs-wizard-info text-center"><i class="material-icons">done</i> PASO 1 - CARGA TUS DOCUMENTOS</div>
								<hr>
							<?php } ?>

								<?php
									// marco como finalizado el proceso de cotizacion del token
									$resModToken = $serviciosReferencias->modificarTokenasesoresEstado($_SESSION['token_ac'],2);
								?>

								<div class="text-center">
									<h1 class="display-4"> ¡Muchas Gracias!</h1>
									<h3 class="display-4">En breve estaremos enviando tu póliza, a partir de ese momento estarás protegido .</h3>
								</div>

								<div class="row">
									<div class="col-xs-12 col-md-3"></div>
									<div class="col-xs-12 col-md-6">
										<button type="button" class="btn btn-lg btn-block btn-success" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">done</i>
											<span>PROCESO FINALIZADO CORRECTAMENTE</span>
										</button>


									</div>
									<div class="col-xs-12 col-md-3"></div>
								</div>

							<?php } else { ?>


							<div class="text-center">
								<h1 class="display-4">¡Firma de manera digital los documentos! </h1>
							</div>

							<div class="row bs-wizard" style="border-bottom:0;margin-left:25px; margin-right:25px;">
							   <div class="col-xs-6 bs-wizard-step complete">
									<div class="text-center bs-wizard-stepnum">Paso 1</div>
									<div class="progress">
										<div class="progress-bar"></div>
									</div>
									<a href="siap.php?id=13" class="bs-wizard-dot"></a>
									<div class="bs-wizard-info text-center">CARGA TUS DOCUMENTOS</div>
							   </div>
							   <div class="col-xs-6 bs-wizard-step active">
									<div class="text-center bs-wizard-stepnum">Paso 2</div>
									<div class="progress">
										<div class="progress-bar"></div>
									</div>
									<a href="javascript:void(0)" class="bs-wizard-dot"></a>
									<div class="bs-wizard-info text-center">FIRMAR LA SOLICITUD DE FORMA DIGITAL</div>
							   </div>
						   </div>



			            <hr>

							<?php if ($tipoFirma == 2) { ?>
								<?php if ($existeNIP == 1) { ?>
							<div class="row">
								<div class="col-xs-12 text-center">
									<h4>INGRESE EL NIP</h4>
									<h5>
										<div class="demo-checkbox">

                              	<input type="checkbox" id="basic_checkbox_2" class="filled-in">
                              	<label for="basic_checkbox_2">al ingresar los dígitos confirmo mi consentimiento de firmar la solicitud F-2092-6 Solicitud de SEVI</label>

                           	</div>
									</h5>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control numero" placeholder="0" id="numero1" name="numero1" MAXLENGTH="1"/>
										</div>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control numero" placeholder="0" id="numero2" name="numero2" MAXLENGTH="1"/>
										</div>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control numero" placeholder="0" id="numero3" name="numero3" MAXLENGTH="1"/>
										</div>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control numero" placeholder="0" id="numero4" name="numero4" MAXLENGTH="1"/>
										</div>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control numero" placeholder="0" id="numero5" name="numero5" MAXLENGTH="1"/>
										</div>
									</div>
								</div>
								<div class="col-xs-2">
									<div class="form-group">
										<div class="form-line">
											<input type="text" class="form-control numero" placeholder="0" id="numero6" name="numero6" MAXLENGTH="1"/>
										</div>
									</div>
								</div>

							</div>
							<div class="row">
								<div class="col-xs-3"></div>
								<div class="col-xs-6">
									<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmarF" style="font-size:1.2em;">
										<i class="material-icons" style="font-size:1.2em;">save</i>
										<span>FIRMAR</span>
									</button>
								</div>
								<div class="col-xs-3"></div>
							</div>
						<?php } } ?>

						<div class="list-group">
							<a href="javascript:void(0);" class="list-group-item active">
							Documentos para Firmar
							</a>
							<a href="javascript:void(0);" class="list-group-item"><div id="example1"></div></a>
						</div>





						<?php if ($tipoFirma == 3) { ?>
						<?php if ($existeNIP == 2) { ?>
								<div class="row">
									<div class="col-xs-3"></div>
									<div class="col-xs-6">
										<h5>Por favor reinicie la pagina</h5>
									</div>
									<div class="col-xs-3"></div>
								</div>
								<div class="row">
									<div class="col-xs-3"></div>
									<div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" id="btnReiniciar" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">save</i>
											<span>REINICIAR</span>
										</button>
									</div>
									<div class="col-xs-3"></div>
								</div>
						<?php } else { ?>
							<?php if ($existeNIP == 1) { ?>
							<div class="row">
								<div class="col-xs-3"></div>
								<div class="col-xs-6">
									<h5>Una vez firmados por favor actualice la pagina</h5>
								</div>
								<div class="col-xs-3"></div>
							</div>
							<div class="row">
								<div class="col-xs-3"></div>
								<div class="col-xs-6">
									<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmarFE" style="font-size:1.2em;">
										<i class="material-icons" style="font-size:1.2em;">save</i>
										<span>FIRMAR</span>
									</button>
								</div>
								<div class="col-xs-3"></div>
							</div>
							<?php } else { ?>
								<div class="row">
									<div class="col-xs-3"></div>
									<div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" id="btnConfirmarFEV" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">save</i>
											<span>VERIFICAR</span>
										</button>
									</div>
									<div class="col-xs-3"></div>
								</div>
							<?php } ?>
						<?php } ?>
						<?php } ?>
						<?php if ($tipoFirma == 2) { ?>
							<?php if ($existeNIP == 1) { ?>


							<?php } else { ?>
								<div class="row">
									<div class="col-xs-3"></div>
									<div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" id="btnGenerarNIP" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">save</i>
											<span>GENERAR NIP</span>
										</button>
									</div>
									<div class="col-xs-3"></div>
								</div>
							<?php } ?>
						<?php } ?>

							<?php } ?>
						<?php } ?>
		          </div>
		        </div>
			  </div>




			</div>
		</div>
	</div>

</section>


<?php if (($puedeContinuar == 0) && ($tipoFirma == 2) && ($existeNIP == 1)) { ?>
<div class="modal fade" id="lgmNotificacion" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-blue">
					 <h4 class="modal-title" id="largeModalLabel">INFORMACIÓN IMPORTANTE</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<h4>Te enviamos un correo electrónico con tu NIP para firmar digitalmente
					</div>
				</div>
				<div class="modal-footer">

					 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>
<?php } ?>

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

<script src="../../js/pdfobject.min.js"></script>

<script src="../../js/jquery.blockUI.js"></script>


<script>
	$(document).ready(function(){

		<?php if (($puedeContinuar == 0) && ($tipoFirma == 2) && ($existeNIP == 1)) { ?>
			$('#lgmNotificacion').modal();
		<?php } ?>

		$('#btnConfirmarFE').click(function() {
			window.open("https://qafirma.signaturainnovacionesjuridicas.com/firmar/TOMG730101MDFLZM00" ,'_blank');
		});

		<?php if ($tipoFirma == 3) { ?>
		<?php if ($puedeContinuar == 0) { ?>
			verificarFirmasPendientes();
		<?php } ?>
		<?php } ?>

		$('#btnConfirmarFEV').click(function() {
			verificarFirmasPendientes();
		});

		$('#btnReiniciar').click(function() {
			location.reload();
		});

		function verificarFirmasPendientes() {
			$.blockUI({ message: '<h4>Estamos procesando la solicitud...</h4>' });

			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'verificarFirmasPendientes',
					id: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error) {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "error",
								timer: 1800,
								showConfirmButton: false
						});

						setTimeout($.unblockUI, 2000);


					} else {
						swal({
								title: "Respuesta",
								text: 'Ya firmo sus documentos correctamente',
								type: "success",
								timer: 2000,
								showConfirmButton: false
						});

						setTimeout(function() {
							$.unblockUI({
								onUnblock: function(){ location.reload(); }
							});
						}, 2000);


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

		$('#btnGenerarNIP').click(function() {
			insertarTokens();
		});

		PDFObject.embed('<?php echo $solicitudParaFirmar; ?>', "#example1");

		$('.numero').keypress(function() {
			idnumber =  $(this).attr("id");

			switch (idnumber) {
				case 'numero1':
					$('#numero2').focus();
				break;
				case 'numero2':
					$('#numero3').focus();
				break;
				case 'numero3':
					$('#numero4').focus();
				break;
				case 'numero4':
					$('#numero5').focus();
				break;
				case 'numero5':
					$('#numero6').focus();
				break;
			}
		});

		function insertarTokens() {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'insertarTokens',
					refcotizaciones: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#btnGenerarNIP').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error) {
						swal({
								title: "Respuesta",
								text: 'Se genero un error al guardar el paso',
								type: "error",
								timer: 1000,
								showConfirmButton: false
						});


					} else {
						swal({
								title: "Respuesta",
								text: 'Se genero correctamente el token y se envio al cliente',
								type: "success",
								timer: 2000,
								showConfirmButton: false
						});
						location.reload();

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


		$('#btnConfirmarF').click(function() {
			if ($('#basic_checkbox_2').is(':checked')) {
				if (($('#numero1').val() != '') && ($('#numero2').val() != '') && ($('#numero3').val() != '') && ($('#numero4').val() != '') && ($('#numero5').val() != '') && ($('#numero6').val() != '')) {
					insertarFirmarcontratos();
				} else {
					swal({
						title: "Respuesta",
						text: 'Debe completar los 6 digitos',
						type: "error",
						timer: 2000,
						showConfirmButton: false
					});
				}
			} else {
				swal({
					title: "Respuesta",
					text: 'Debes confirmar tu consentimiento',
					type: "error",
					timer: 2000,
					showConfirmButton: false
				});
			}


		});

		function insertarFirmarcontratos() {
			$.blockUI({ message: '<h4>Estamos procesando la solicitud, por favor no cierres el navegador...</h4>' });

			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'insertarFirmarcontratos',
					nip: $('#numero1').val() + $('#numero2').val() + $('#numero3').val() + $('#numero4').val() + $('#numero5').val() + $('#numero6').val(),
					refcotizaciones: <?php echo $id; ?>
				},
				//mientras enviamos el archivo
				beforeSend: function(){
					$('#btnConfirmarF').hide();
				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error) {
						swal({
								title: "Respuesta",
								text: data.mensaje,
								type: "error",
								timer: 2000,
								showConfirmButton: false
						});

						$('#btnConfirmarF').show();

						setTimeout($.unblockUI, 2000);


					} else {
						swal({
								title: "Respuesta",
								text: 'Se firmo correctamente LA SOLICIUTD!',
								type: "success",
								timer: 2000,
								showConfirmButton: false
						});

						setTimeout(function() {
							$.unblockUI({
								onUnblock: function(){ location.reload(); }
							});
						}, 2000);



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



		$("#sign_in").submit(function(e){
			e.preventDefault();
		});



	});
</script>








</body>

</html>

<?php

if ($generoFirmaAlFinal == 1) {

}

?>

<?php } ?>
