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
	include ('../../includes/vrim.api.class.php');
	include ('../../includes/EnvioSMS.class.php');

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

if (!(isset($_GET['id']))) {
	header('Location: index.php');
} else {
	$id = $_GET['id'];
}

$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resMetodoPago = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

$idCliente = mysql_result($resCotizaciones,0,'refclientes');

$resCliente = $serviciosReferencias->traerClientesPorIdCompleto($idCliente);

$rfcCliente = strtoupper(mysql_result($resCliente,0,'rfc') == '' ? substr(mysql_result($resCliente,0,'curp'),0,10) : mysql_result($resCliente,0,'rfc'));

$lblCliente = mysql_result($resCotizaciones,0,'clientesolo');

$idProducto = mysql_result($resCotizaciones,0,'refproductos');

// verifico si ya guarde los datos de domicilio y telelfono en dbclientesbck
$resBckUpCliente = $serviciosReferencias->traerClientesbckPorId($idCliente);
if (mysql_num_rows($resBckUpCliente) > 0) {
	$existeBckUpCliente = 1;
} else {
	$existeBckUpCliente = 0;
}

if ((($idProducto == 41) || ($idProducto == 54)) && ($existeBckUpCliente==1)) {
	$pathSolcitud  = '../../archivos/solicitudes/cotizaciones/'.$id;

	if (!file_exists($pathSolcitud)) {
		mkdir($pathSolcitud, 0777);
	}

	$filesSolicitud = array_diff(scandir($pathSolcitud), array('.', '..'));
	if (count($filesSolicitud) < 1) {
		// switch para los solicitudes
		switch ($idProducto) {
			case 41:
				require ('../../reportes/rptVRIMcompletoR.php');
			break;
			case 28:
				require ('../../reportes/rptFTodos.php');
			break;
			case 54:
				require ('../../reportes/rptVida500R.php');
			break;
			case 55:
				require ('../../reportes/rptRCMedicosR.php');
			break;
		}
		//die(var_dump(__DIR__));
	}
}

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
	$resAsegurado = $serviciosReferencias->traerAseguradosPorIdPDF(mysql_result($resCotizaciones,0,'refasegurados'));


	if (mysql_num_rows($resAsegurado)>0) {
		$lblAsegurado = mysql_result($resAsegurado,0,'apellidopaterno').' '.mysql_result($resAsegurado,0,'apellidomaterno').' '.mysql_result($resAsegurado,0,'nombre');

		$idAsegurado = mysql_result($resAsegurado,0,0);

		$documentacionesrequeridasAsegurado = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacionCompletaIn(mysql_result($resAsegurado,0,0),'3,4');

		/*
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
		*/


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
	
} else {
	$existeMetodoPago = 0;
	// creo el archivo grande
	// pregunto rpimero si existe.
	$pathSolcitud  = '../../archivos/solicitudes/cotizaciones/'.$id;

	if (!file_exists($pathSolcitud)) {
		mkdir($pathSolcitud, 0777);
	}

	$filesSolicitud = array_diff(scandir($pathSolcitud), array('.', '..'));
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


$comoEnvioNIP = 0;

//////////////////// verifico en el proceso si firma con fiel, simple o autografa ////////////////

// verifico si necesita una solicitud
if (($consolicitud == 1) && ($existeBckUpCliente == 1)) {
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
		   $nuevafecha = strtotime ( '+2 minutes' , strtotime ( $fechacreac ) ) ;

		   $refestadotoken = 1;
		   $vigenciafin = $nuevafecha;

		   $res = $serviciosReferencias->insertarTokens($id,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin);

		   $telefono = mysql_result($resCliente,0,'telefonocelular');

    		$resUsuario = $serviciosReferencias->traerUsuariosPorId($_SESSION['usuaid_sahilices']);

			$lstNIPporUsuario = $serviciosUsuario->traerUsuariosnipPorIdUsuarioEventoDestino($_SESSION['usuaid_sahilices'],$id,0);


		   if ((integer)$res > 0) {

			
			// si valido si telefono movil, se lo envio al telefono
			if ((mysql_result($resUsuario,0,'validamovil') == '1') && (mysql_num_rows($lstNIPporUsuario) <= 3)) {

				$comoEnvioNIP = 1;
				
				$EnvioSMS = new EnvioSMS();
	   
				$msg = 'ASESORES CREA - NIP: '.$token ." Ingresa este numero para firmar tu solicitud";
	   
				$envio = $EnvioSMS->enviarSMS($telefono, $msg );
	   
				if ($envio == 1) {
				    $resMarca = $serviciosUsuario->insertarUsuariosnip($_SESSION['usuaid_sahilices'],$id,$token,date('Y-m-d H:i:s'),0);
				    if ((integer)$resMarca > 0) {
						$existeNIP = 1;
				    } else {
						echo 'Hubo un error al enviar el SMS';
						$resEliminar = $serviciosReferencias->eliminarTokens($res);
						$existeNIP = 0;
				    }
				   
				} else {
				   echo 'Hubo un error al enviar el SMS';
				   $resEliminar = $serviciosReferencias->eliminarTokens($res);
				   $existeNIP = 0;
				}
	   
	   
			} else {

				$comoEnvioNIP = 2;
				
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

			}

		      

		      
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
				$url = 'https://crea.signaturainnovacionesjuridicas.com/api/documentos/crear/';
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

	$resFirma = $serviciosReferencias->traerFirmarcontratosPorCotizacionAprobada($id);
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

if ($existeBckUpCliente == 0) {
	$puedeContinuar = 0;
	$existeNIP = 0;
}

if ($idProducto == 41) {
	$necesariasParaAprobar = 1;
	$cargados = 1;
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

	<!-- CSS file -->
	<link rel="stylesheet" href="../../css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="../../css/easy-autocomplete.themes.min.css">


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
		.easy-autocomplete-container { width: 400px; z-index:999999 !important; }
		.tscodigopostal { width: 400px; }

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
									<?php if ($idProducto == 41) { ?>
										<div class="bs-wizard-info text-center"><i class="material-icons">done</i> PASO 1 - FIRMAR LA SOLICITUD DE FORMA DIGITAL</div>
										<hr>
									<?php } else { ?>
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
									<?php } ?>
								
							<?php } else { ?>
								<div class="bs-wizard-info text-center"><i class="material-icons">done</i> PASO 1 - CARGA TUS DOCUMENTOS</div>
								<hr>
							<?php } ?>

								<?php

								//si es vrim platino, por ahora asi queda
								if ($idProducto == 41) {
									//api de vrim
									//busco el token
									$resBuscarToken = $serviciosReferencias->traerSolicitudvrimPorIdCotizacion($id);

									if (mysql_num_rows($resBuscarToken) > 0) {
										//existe ya se lo envie
									} else {
										//no existe
										///creo devuelta el token y la solicitud

										$vrimAPI = new ApiVrim('password', 'as350rcr3a', 'vr1m@2021_cr3a',$_SESSION['usua_sahilices']);

										$tokenVRIM = $vrimAPI->tokenVRIM();

										
										if ($vrimAPI->getError() == '') {
											//genero bien el token
											$tokenBear = $vrimAPI->getAccesstoken();

											$resItoken = $serviciosReferencias->insertarTokenvrim('password','as350rcr3a','vr1m@2021_cr3a',$tokenBear,'bearer',150000,date('Y-m-d'),'marcos',11,$id);

											if ($resItoken > 0) {
												$arCliente = [];

												$arCliente['tipoPersona'] = 1;
												$arCliente['razonSocial'] = '';
												$arCliente['nombre'] = mysql_result($resCliente,0,'nombre');
												$arCliente['apellidoPaterno'] = mysql_result($resCliente,0,'apellidopaterno');
												$arCliente['apellidoMaterno'] = mysql_result($resCliente,0,'apellidomaterno');
												$arCliente['fechaNacimiento'] = mysql_result($resCliente,0,'fechanacimientovrim');
												$arCliente['correo'] = $_SESSION['usua_sahilices'];
												$arCliente['TelefonoFijo'] = '';
												//lo dijo javier 14-05-2021
												$arCliente['Celular'] = '5551355135';

												$arPedidos = [];

												$arTarjeta = [];

												if (mysql_result($resCotizaciones,0,'tieneasegurado') == '1') {
													$arTarjeta['nombre'] = mysql_result($resAsegurado,0,'nombre');
													$arTarjeta['apellidoPaterno'] = mysql_result($resAsegurado,0,'apellidopaterno');
													$arTarjeta['apellidoMaterno'] = mysql_result($resAsegurado,0,'apellidomaterno');
													$arTarjeta['fechaNacimiento'] = mysql_result($resAsegurado,0,'fechanacimientovrim');
													$arTarjeta['correo'] = $_SESSION['usua_sahilices'];
													//lo dijo javier 14-05-2021
													$arTarjeta['Celular'] = '5551355135';
												} else {
													$arTarjeta['nombre'] = mysql_result($resCliente,0,'nombre');
													$arTarjeta['apellidoPaterno'] = mysql_result($resCliente,0,'apellidopaterno');
													$arTarjeta['apellidoMaterno'] = mysql_result($resCliente,0,'apellidomaterno');
													$arTarjeta['fechaNacimiento'] = mysql_result($resCliente,0,'fechanacimientovrim');
													$arTarjeta['correo'] = $_SESSION['usua_sahilices'];
													//lo dijo javier 14-05-2021
													$arTarjeta['Celular'] = '5551355135';
												}

												

												$arPedidos = array('cveProducto'=>'VD24','Tarjetas'=>$arTarjeta);

												$solicitudVRIM = $vrimAPI->solicitudVrim($arCliente, $arPedidos, $tokenBear);

												if ($vrimAPI->getError() == '') {
													//inserto la solicitud, salio todo bien, muestro mensaje
													$resIsolicitud = $serviciosReferencias->insertarSolicitudvrim($resItoken,'28222','1','1220','2','12','1','',mysql_result($resCliente,0,'nombre'),mysql_result($resCliente,0,'apellidopaterno'),mysql_result($resCliente,0,'apellidomaterno'),mysql_result($resCliente,0,'fechanacimientovrim'),$_SESSION['usua_sahilices'],'',mysql_result($resCliente,0,'telefonocelular'),'VD24',mysql_result($resCliente,0,'nombre'),mysql_result($resCliente,0,'apellidopaterno'),mysql_result($resCliente,0,'apellidomaterno'),mysql_result($resCliente,0,'fechanacimientovrim'),$_SESSION['usua_sahilices'],mysql_result($resCliente,0,'telefonocelular'),date('Y-m-d'),$vrimAPI->getMembresia());

													echo '<h3>Su poliza fue generada correctamente</h3><h5>Membresia: '.$vrimAPI->getMembresia().'</h5><h5>Titular: '.$vrimAPI->getTitular().'</h5>';

												} else {
													//algo salio mal, muestro mensaje
													echo '<div class="alert alert-danger"><p>'.$vrimAPI->getError().'</p></div>';
												}
											} else {
												echo '<div class="alert alert-danger"><p>'.$resItoken.'</p></div>';
											}

											
										} else {
											//se genero un error, que recargue la pagina o que se comunique con un asesor para obtener la membresia vrim
											echo '<div class="alert alert-danger"><p>'.$vrimAPI->getError().'</p></div>';
										}

									}
								}


								//si es vida 500 y tiene alguna pregunta que inhabilite, por ahora asi queda
								//id: 54
								$envioSolicitudParaAutorizar = 0;
								if ($idProducto == 54) {
									$resInhabilitaRespuesta = $serviciosReferencias->inhabilitaRespuestascuestionarioPorCotizacion($id);
									if (mysql_num_rows($resInhabilitaRespuesta)>0) {

										$envioSolicitudParaAutorizar = 1;

										//envio email a vidaseleccion@inbursa.com y a ruth
										$asunto = 'Emisión en VIDA 500';

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

										
										$cuerpo .= '<h3> Cliente: '.$lblCliente.' - Producto: VIDA 500 </h3>';

										$cuerpo .= '<p> Haga click <a href="https://asesorescrea.com/desarrollo/crm/dashboard/entradas/index.php?id='.$id.'">aqui</a> para acceder a la solicitud </p>';
										

										$cuerpo .= '</body>';

										$exito = $serviciosReferencias->enviarEmail('vidaseleccion@inbursa.com', utf8_decode( $asunto),utf8_decode($cuerpo));

										$exitoRuth = $serviciosReferencias->enviarEmail('ruth-arana@asesorescrea.com', utf8_decode( $asunto),utf8_decode($cuerpo));

										$resMensaje = $serviciosReferencias->insertarMensajes($cuerpo,$_SESSION['usua_sahilices'],'vidaseleccion@inbursa.com, ruth-arana@asesorescrea.com', date('Y-m-d H:i:s'));

									}
								}
								?>

								<div class="text-center">
									<h1 class="display-4"> ¡Muchas Gracias!</h1>
									<?php if ($idProducto != 41) { ?>
										<h3 class="display-4">En breve estaremos enviando tu póliza, a partir de ese momento estarás protegido .</h3>
									<?php } ?>
								</div>

								<div class="row">
									<div class="col-xs-3"></div>
									<div class="col-xs-6">
										<button type="button" class="btn btn-lg btn-block btn-success" style="font-size:1.2em;">
											<i class="material-icons" style="font-size:1.2em;">done</i>
											<span>PROCESO FINALIZADO CORRECTAMENTE</span>
										</button>


									</div>
									<div class="col-xs-3"></div>
								</div>

							<?php } else { ?>


							<div class="text-center">
								<h1 class="display-4">¡Firma de manera digital los documentos! </h1>
							</div>

							<?php if ($idProducto == 41) { ?>
								<hr>
								<div class="bs-wizard-info text-center"><i class="material-icons">done</i> PASO 1 - FIRMAR LA SOLICITUD DE FORMA DIGITAL</div>
								
							<?php } else { ?>
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
							<?php } ?>
							



			            <hr>

							<?php if ($tipoFirma == 2) { ?>
								<?php if ($existeNIP == 1) { ?>
							<div class="row">
								<div class="col-xs-12 text-center">
									<h4>INGRESE EL NIP</h4>
									<h5>
										<div class="demo-checkbox">

                              	<input type="checkbox" id="basic_checkbox_2" class="filled-in">
                              	<label for="basic_checkbox_2">al ingresar los dígitos confirmo mi consentimiento de firmar la solicitud</label>

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
									<br>
									<small>* Si aun no le ha llegado el NIP, actualice la pagina por favor</small>
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


<?php if (($puedeContinuar == 0) && ($tipoFirma == 2) && ($existeNIP == 1) && ($existeBckUpCliente == 1)) { ?>
<div class="modal fade" id="lgmNotificacion" tabindex="-1" role="dialog">
	 <div class="modal-dialog modal-lg" role="document">
		  <div class="modal-content">
				<div class="modal-header bg-blue">
					 <h4 class="modal-title" id="largeModalLabel">INFORMACIÓN IMPORTANTE</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<?php if ($comoEnvioNIP == 2) { ?>
						<h4>Te enviamos un correo electrónico con tu NIP para firmar digitalmente</h4>
						<?php } else { ?>
							<h4>Te enviamos un SMS con tu NIP para firmar digitalmente</h4>
						<?php } ?>
					</div>
				</div>
				<div class="modal-footer">

					 <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">CERRAR</button>
				</div>
		  </div>
	 </div>
</div>
<?php } ?>


<div class="modal fade" id="lgmDomicilioTelefono" tabindex="-1" role="dialog">
		 <div class="modal-dialog modal-xlg" role="document">
			  <div class="modal-content">
					<div class="modal-header">
						 <h4 class="modal-title" id="largeModalLabel">POR FAVOR CONFIRME O MODIFIQUE LA SIGUIENTE INFORMACIóN</h4>
					</div>
					<div class="modal-body">
						<div class="row">
							<p style="color:red;">* Si falta algun dato o un dato esta incorrecto, agregue o modifique.</p>
							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">CREAR CONTRASEÑA: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="password" minlength="8" maxlength="20" class="form-control" id="dcpassword" name="dcpassword" />
										</div>
									</div>
									<h6 style="color:red;">Tu PASSWORD debe contener (8 caracteres, al menos una mayúscula, al menos una minúscula y un numero).</h6>
								</div>
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">RFC: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" minlength="12" maxlength="13" class="form-control" id="dcrfc" name="dcrfc" value="<?php echo $rfcCliente; ?>" />
										</div>
									</div>
								</div>
								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display:block">
									<label class="form-label">Estado Civil</label>
									<div class="form-group input-group">
										<div class="form-line">
											<select class="form-control" name="dcrefestadocivil" id="dcrefestadocivil">
												<option value="7">No indico</option>
												<option value="1">Soltero</option>
												<option value="2">Casado</option>
											</select>

										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Tel. Movil: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" maxlength="10" class="form-control" id="dctelefonocelular" name="dctelefonocelular" value="<?php echo mysql_result($resCliente,0,'telefonocelular'); ?>" />
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:none;">
									<label class="form-label">Tel. Fijo: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dctelefonofijo" name="dctelefonofijo" value="<?php echo mysql_result($resCliente,0,'telefonofijo'); ?>" />
										</div>
									</div>
								</div>

								<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 frmContrfc" style="display:block;">
									<label class="form-label">Calle: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dccalle" name="dccalle" value="<?php echo mysql_result($resCliente,0,'domicilio'); ?>" />
										</div>
									</div>
								</div>

								<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Nro. Interior: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dcnrointerior" name="dcnrointerior" value="<?php echo mysql_result($resCliente,0,'nrointerior'); ?>" />
										</div>
									</div>
								</div>

								<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Nro. Exterior: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dcnroexterior" name="dcnroexterior" value="<?php echo mysql_result($resCliente,0,'nroexterior'); ?>" />
										</div>
									</div>
								</div>

								<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Edificio: </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dcedificio" name="dcedificio" value="<?php echo mysql_result($resCliente,0,'edificio'); ?>" />
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Cod. Postal: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dccodigopostal" name="dccodigopostal" value="<?php echo mysql_result($resCliente,0,'codigopostal'); ?>" />
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Estado: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dcestado" name="dcestado" value="<?php echo mysql_result($resCliente,0,'estado'); ?>" readonly/>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Colonia: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dccolonia" name="dccolonia" value="<?php echo mysql_result($resCliente,0,'colonia'); ?>" readonly/>
										</div>
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Alcaldía: <span style="color:red;">*</span>  </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dcmunicipio" name="dcmunicipio" value="<?php echo mysql_result($resCliente,0,'municipio'); ?>" readonly/>
										</div>
									</div>
								</div>
							</div>

							<div class="row">
								<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 frmContrfc" style="display:block">
									<label class="form-label">Ciudad: </label>
									<div class="form-group input-group">
										<div class="form-line">
											<input type="text" class="form-control" id="dcciudad" name="dcciudad" value="<?php echo mysql_result($resCliente,0,'ciudad'); ?>"/>
										</div>
									</div>
								</div>



							</div>




						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-success waves-effect btnModificarDC">CONTINUAR</button>
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

<script src="../../js/jquery.easy-autocomplete.min.js"></script>

<script src="../../js/pages/examples/sign-in.js"></script>

<!-- Bootstrap Material Datetime Picker Plugin Js -->
<script src="../../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

<script src="../../DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>

<script src="../../js/pdfobject.min.js"></script>

<script src="../../js/jquery.blockUI.js"></script>


<script>
	$(document).ready(function(){

		$('#dcrefestadocivil').val(<?php echo (mysql_result($resCliente,0,'refestadocivil') == '' ? 7 : mysql_result($resCliente,0,'refestadocivil')); ?>);

		function validarPASS(pass) {
				var re = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/,
				validado = pass.match(re);

			if (!validado)  //Coincide con el formato general?
				return false;

			return true; //Validado
		}

	

		$('.btnModificarDC').click(function() {
			if (($('#dctelefonocelular').val() == '') || ($('#dcrfc').val() == '') ||  ($('#dcpassword').val() == '') || ($('#dccalle').val() == '') || ($('#dcnrointerior').val() == '') || ($('#dcnroexterior').val() == '') || ($('#dccodigopostal').val() == '') || ($('#dcestado').val() == '') || ($('#dccolonia').val() == '') || ($('#dcmunicipio').val() == '') ) {
				swal({
					title: "Respuesta",
					text: 'Complete todos los campos obligatorios para modificar los datos',
					type: "error",
					timer: 2000,
					showConfirmButton: false
				});
			} else {
				if ((validarPASS($('#dcpassword').val()) == true)) {
					modificarDatosClientes( $('#dctelefonofijo').val(),$('#dctelefonocelular').val(),$('#dccalle').val(),$('#dcnrointerior').val(),$('#dcnroexterior').val(),$('#dcedificio').val(),$('#dccodigopostal').val(),$('#dcestado').val(),$('#dccolonia').val(),$('#dcmunicipio').val(),$('#dcciudad').val(),$('#dcrfc').val(),$('#dcpassword').val());
				} else {
					swal({
						title: "Respuesta",
						text: 'El PASSWORD debe contener (8 caracteres, al menos una mayúscula, al menos una minúscula y un numero).',
						type: "error",
						timer: 3000,
						showConfirmButton: false
					});
				}
				

			}

		});

		function modificarDatosClientes(telefonofijo,telefonocelular,calle,nrointerior,nroexterior,edificio,codigopostal,estado,colonia,municipio,ciudad,rfc,password) {
			$.ajax({
				url: '../../ajax/ajax.php',
				type: 'POST',
				// Form data
				//datos del formulario
				data: {
					accion: 'modificarDatosClientes',
					id: <?php echo $idCliente; ?>,
					telefonofijo: telefonofijo,
					telefonocelular:telefonocelular,
					calle:calle,
					nrointerior: nrointerior,
					nroexterior: nroexterior,
					edificio: edificio,
					codigopostal: codigopostal,
					estado: estado,
					colonia: colonia,
					municipio: municipio,
					ciudad: ciudad,
					rfc: rfc,
					password: password
				},
				//mientras enviamos el archivo
				beforeSend: function(){

				},
				//una vez finalizado correctamente
				success: function(data){

					if (data.error == false) {
						swal({
							title: "Respuesta",
							text: 'Datos actualizados',
							type: "success",
							timer: 2000,
							showConfirmButton: false
						});

						setTimeout(function(){ location.reload(); }, 2000);


					} else {
						swal({
							title: "Respuesta",
							text: 'No existe cuestionario para completar, continue',
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

		<?php if ($existeBckUpCliente == 0) { ?>
		$('#lgmDomicilioTelefono').modal({backdrop: 'static', keyboard: false});
		<?php } ?>
		

		<?php if (($puedeContinuar == 0) && ($tipoFirma == 2) && ($existeNIP == 1)) { ?>
			$('#lgmNotificacion').modal();
		<?php } ?>

		$('#btnConfirmarFE').click(function() {
			window.open("https://qafirma.signaturainnovacionesjuridicas.com/firmar/TOMG730101MDFLZM00" ,'_blank');
		});

		<?php if ($tipoFirma == 3) { ?>
		<?php if ($puedeContinuar == 0) { ?>
			//verificarFirmasPendientes();
		<?php } ?>
		<?php } ?>

		$('#btnConfirmarFEV').click(function() {
			//verificarFirmasPendientes();
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

		<?php if ($existeBckUpCliente == 1) { ?>
		PDFObject.embed('<?php echo $solicitudParaFirmar; ?>', "#example1");
		<?php } ?>

		var optionsDC = {

		url: "../../json/jsbuscarpostal.php",

		getValue: function(element) {
			return element.estado + ' ' + element.municipio + ' ' + element.colonia + ' ' + element.codigo;
		},

		ajaxSettings: {
			dataType: "json",
			method: "POST",
			data: {
				busqueda: $("#dccodigopostal").val()
			}
		},

		preparePostData: function (data) {
			data.busqueda = $("#dccodigopostal").val();
			return data;
		},

		list: {
			maxNumberOfElements: 20,
			match: {
				enabled: true
			},
			onClickEvent: function() {
				var value = $("#dccodigopostal").getSelectedItemData().codigo;
				$("#dccodigopostal").val(value);
				$("#dcmunicipio").val($("#dccodigopostal").getSelectedItemData().municipio);
				$("#dcestado").val($("#dccodigopostal").getSelectedItemData().estado);
				$("#dccolonia").val($("#dccodigopostal").getSelectedItemData().colonia);


			}
		}
		};

		$("#dccodigopostal").easyAutocomplete(optionsDC);

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
						setTimeout(function() {
							location.reload();
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

						if (data.tipo == 2) {
							insertarTokens();
						}

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



?>

<?php } ?>
