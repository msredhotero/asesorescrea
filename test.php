<?php

session_start();

include ('crm/includes/funcionesUsuarios.php');
include ('crm/includes/funciones.php');
include ('crm/includes/funcionesHTML.php');
include ('crm/includes/funcionesReferencias.php');
include ('crm/includes/funcionesNotificaciones.php');
include ('crm/includes/validadores.php');

$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias		= new ServiciosReferencias();
$serviciosNotificaciones	= new ServiciosNotificaciones();
$serviciosValidador        = new serviciosValidador();

function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
}

$ip = getRealIP();

$_SESSION['iptest'] = $ip;
$_SESSION['usua_sahilices_web'] = 'UsuarioWeb';

$intento = 0;

$existe = $serviciosReferencias->traerIpPorIPultimo($ip);

$yajugo = 0;

$token = '';

if (mysql_num_rows($existe)>0) {
	$secuencia = mysql_result($existe, 0,'secuencia');

   $_SESSION['token'] = mysql_result($existe, 0,'token');

   // verifico si ya se dio de alta en la tabla dbpostulantes //
   $resPostulante = $serviciosReferencias->traerPostulantePorToken($_SESSION['token']);
   if (mysql_num_rows($resPostulante) > 0) {
      $finalizarAlta = 1;
   } else {
      $finalizarAlta = 0;
   }

   // fin //

	if ($secuencia == 7) {
		$yajugo = 2;
      $arTest = $serviciosReferencias->determinaEstadoTest($_SESSION['token']);
	} else {
		$yajugo = 1;
	}
   $secuencia += 1;
} else {
	$yajugo = 0;
	$secuencia = 1;
}

$cadAnios = '';
for ($i=(date('Y') - 18);$i>= 1950;$i--) {
   $cadAnios .= '<option value="'.$i.'">'.$i.'</option>';
}

$cadMeses = '';

for ($i2 = 1; $i2 <= 12; $i2++) {
   $cadMeses .= '<option value="'.$i2.'">'.$i2.'</option>';
}

$cadDiasA = '';
for ($i3=1;$i3<= 31;$i3++) {
   $cadDiasA .= '<option value="'.$i3.'">'.$i3.'</option>';
}

$cadDiasB = '';
for ($i4=1;$i4<= 30;$i4++) {
   $cadDiasB = '<option value="'.$i4.'">'.$i4.'</option>';
}

$cadDiasC = '';
for ($i5=1;$i5<= 29;$i5++) {
   $cadDiasC = '<option value="'.$i5.'">'.$i5.'</option>';
}


?>
<!doctype html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<title>CREA | Fácil y Seguro | Asesores en Banca y Seguros</title>
	<meta name="description" content="Asesores en banca y seguros con cobertura nacional, ofreciendo el mejor servicio y condiciones" />
	<meta name="keywords" content="seguros, crédito, mejoría, crea, hipoteca, seguro automotriz, gastos médicos, seguro telmex, tpv, tarjeta de credito" />
	<link rel="shortcut icon" href="img/favicon.png">

   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

	<script src="crm/plugins/jquery/jquery.min.js"></script>
   <!-- Bootstrap Core Css -->
   <link href="crm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

   <script src="crm/plugins/bootstrap/js/bootstrap.min.js"></script>

   <!-- Waves Effect Css -->
   <link href="crm/plugins/node-waves/waves.css" rel="stylesheet" />

   <!-- Animation Css -->
   <link href="crm/plugins/animate-css/animate.css" rel="stylesheet" />

   <!-- Sweetalert Css -->
   <link href="crm/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

   <!-- Custom Css -->
   <link href="css/style.css" rel="stylesheet">

   <script src="js/progressbar.min.js"></script>

   <link rel="stylesheet" type="text/css" href="crm/css/classic.css"/>
	<link rel="stylesheet" type="text/css" href="crm/css/classic.date.css"/>

   <link rel="stylesheet" type="text/css" href="crm/plugins/bootstrap-select/css/bootstrap-select.css"/>

	<!-- CSS file -->
	<link rel="stylesheet" href="crm/css/easy-autocomplete.min.css">
	<!-- Additional CSS Themes file - not required-->
	<link rel="stylesheet" href="crm/css/easy-autocomplete.themes.min.css">

   <link href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
   <script src="crm/plugins/momentjs/moment.js"></script>
   <script src="crm/js/moment-with-locales.js"></script>
   <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

	<script type='text/javascript'>
		//document.oncontextmenu = function(){return false}

	</script>
   <style>
      .sinFondo {
         background-color: #fff !important;
         border: #fff !important;
      }
   </style>

</head>

<body>
   <div class="jumbotron text-center">
      <a href="index.html"><img src="img/logo.png" title="Inicio" alt="ASESORES CREA" width="15%"></a>
      <p>Bienvenido al Proceso de Reclutamiento de Asesores - Complete el "TEST AFINIDAD CON LA VACANTE DE ASESOR FINANCIERO"</p>
   </div>

   <div class="container">
		<?php if ($yajugo == 2) { ?>
         <div class="row">
            <?php if ($finalizarAlta == 0) { ?>
            <h4 style="line-height: 24px;">Un integrante de nuestro equipo profesional en desarrollo de talento, se contactará contigo muy pronto; únicamente te pedimos capturar la siguiente información básica de contacto.
Para cualquier información adicional, puedes contactarnos y con gusto te atenderemos.</h4>
            <br>
            <?php } ?>
            <div class="alert alert-<?php echo $arTest['color']; ?>">
               <p><?php echo $arTest['lbltest']; ?></p>
            </div>
            <?php if ($finalizarAlta == 1) { ?>
               <div class="list-group">
                  <button type="button" class="list-group-item list-group-item-action active">
                  <?php
                  echo '<b>Nombre Completo:</b> '.mysql_result($resPostulante,0,'nombre').' '.mysql_result($resPostulante,0,'apellidopaterno').' '.mysql_result($resPostulante,0,'apellidomaterno');
                  ?>
                  </button>
                  <button type="button" class="list-group-item list-group-item-action"><?php
                  echo '<b>Email:</b> '.mysql_result($resPostulante,0,'email');
                  ?></button>
                  <button type="button" class="list-group-item list-group-item-action"><?php
                  echo '<b>Estado:</b> '.mysql_result($resPostulante,0,'estadopostulante');
                  ?></button>
               </div>
            <?php } ?>
            <?php if (($arTest['test'] != 2) && ($finalizarAlta == 0)) { ?>
            <div class="contAlta">
            <form class="formulario frmNuevo" role="form" id="sign_in">
               <div class="row">

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">Nombre</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="nombre" name="nombre"  required />

								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">Apellido Paterno</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="apellidopaterno" name="apellidopaterno"  required />

								</div>
							</div>
						</div>
               </div>
               <div class="row">
						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">Apellido Materno</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="apellidomaterno" name="apellidomaterno"  required />

								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">Email</label>
							<div class="form-group">
								<div class="form-line">
									<input type="email" class="form-control" id="email" name="email"  required />

								</div>
							</div>
						</div>
               </div>
               <div class="row">

                  <div class="col-xs-6">

   						<b>Fecha De Nacimiento</b>
                     <div class="form-group">
                        <div class='input-group'>
                           <span class="input-group-addon">
                              <select class="form-control" id="anio" name="anio">
                                 <?php echo $cadAnios; ?>
                              </select>
                           </span>
                           <span class="input-group-addon">
                              <select class="form-control" id="mes" name="mes">
                                 <?php echo $cadMeses; ?>
                              </select>
                           </span>
                           <span class="input-group-addon">
                              <select class="form-control" id="dia" name="dia">
                                 <?php echo $cadDiasA; ?>
                              </select>
                           </span>
                        </div>

                     </div>

                  </div>


						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:block">
   						<b>Sexo</b>
   						<div class="input-group">
      						<div class="form-line">
      							<select class="form-control" id="sexo" name="sexo"  required >
                              <option value=''>-- Seleccionar --</option>
                              <option value='1'>Femenino</option>
                              <option value='2'>Masculino</option>
                           </select>
      						</div>
   						</div>
						</div>

                  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:block">
   						<b>Escolaridad</b>
   						<div class="input-group">
      						<div class="form-line">
      							<select class="form-control" id="refescolaridades" name="refescolaridades"  required >
                              <option value="1">Primaria</option>
                              <option value="2">Secundaria</option>
                              <option value="3">Preparatoria</option>
                              <option value="4">Licenciatura</option>
                              <option value="5">Postgrado</option>
                           </select>
      						</div>
   						</div>
						</div>

                  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:block">
   						<b>Estado Civil</b>
   						<div class="input-group">
      						<div class="form-line">
      							<select class="form-control" id="refestadocivil" name="refestadocivil"  required >
                              <option value="1">SOLTERO(A)</option>
                              <option value="2">CASADO(A)</option>
                              <option value="3">UNION LIBRE</option>
                              <option value="6">VIUDO(A)</option>
                           </select>
      						</div>
   						</div>
						</div>
               </div>

               <div class="row">

						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:block">
   						<b>Nacionalidad</b>
   						<div class="input-group">
      						<div class="form-line">
      							<select class="form-control" id="nacionalidad" name="nacionalidad"  required >
                              <option value='Mexico'>Mexico</option>
                           </select>
      						</div>
   						</div>
						</div>

                  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:block">
							<label class="form-label">Tel. Movil</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="telefonomovil" name="telefonomovil" maxlength="11" required />

								</div>
							</div>
						</div>

						<div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:none">
							<label class="form-label">Tel. Casa</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="telefonocasa" name="telefonocasa" maxlength="11" />

								</div>
							</div>
						</div>

                  <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6" style="display:none">
							<label class="form-label">Tel. Trabajo</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="telefonotrabajo" name="telefonotrabajo" maxlength="11" />

								</div>
							</div>
						</div>
               </div>

               <div class="row">

                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">Cod. Postal</label>
							<div class="form-group">

								<div class="form-line">
                           <div class="col-xs-9" style="display:block">
   									<input type="text" class="form-control" id="codigopostalbuscar" name="codigopostalbuscar" autocomplete="off" required />
                           </div>
                           <div class="col-xs-3" style="display:block">
                              <select class="form-control" id="codigopostal" name="codigopostal"  required readonly />
                              </select>
                           </div>
								</div>
							</div>
						</div>

						<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">¿Cuenta con cédula definitiva para venta de Afore?</label>
							<div class="form-group">
								<div class="form-line">
									<select class="form-control" id="afore" name="afore" />
                              <option value="1">Si</option>
                              <option value="0">No</option>
                           </select>
								</div>
							</div>
						</div>
               </div>
               <div class="row">
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 contCompania" style="display:block;">
							<label class="form-label">¿Con que compañía vende actualmente?</label>
							<div class="form-group">
								<div class="form-line">
									<input type="text" class="form-control" id="compania" name="compania" />

								</div>
							</div>
						</div>
                  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="display:block">
							<label class="form-label">¿Cuenta Con cedula definitiva para venta de Seguros?</label>
							<div class="form-group">
								<div class="form-line">
                           <select class="form-control" id="cedula" name="cedula" />
                              <option value="1">Si</option>
                              <option value="0">No</option>
                           </select>

								</div>
							</div>
						</div>
                  <input type="hidden" id="accion" name="accion" value="insertarPostulantes"/>
               </div>

               <div class="row" style="margin-bottom:50px;">
   					<div class="form-group" style="margin-top: 2%;">
   					<div class="col-md-3 col-xs-3">
   					</div>

   					<div class="col-md-6 col-xs-6" style="text-align: center;">
   						<button type="submit" class="btn btn-success nuevo" id="guardar">ENVIAR</button>
   					</div>

   					<div class="col-md-3 col-xs-3">
   					</div>
   					</div>
   		      </div>

            </div>
            </form>
            </div>
            <?php } ?>
         </div>
		<?php } else { ?>
      <div class="row">
         <div class='alert alert-info'><h4><b>Esta vacante es lo que buscas y se adpata a tus expactativas económicas? Te pedimo nos regales un máximo de 5 minutos de tu tiempo, para constetar 6 simples preguntas y sabremos si nuestra oferta de trabajo es compatible con tus intereses. Esto también nos apoya para ofrecerte un plan de carrera personalizado.</b></h4></div>
      </div>
		<form role="form" class="formulario">
      <div class="row">
         <?php if ($yajugo == 1) { ?>
         <button type="button" class="btn btn-success btnComenzar">CONTINUAR TEST</button>
         <?php } else { ?>
         <button type="button" class="btn btn-success btnComenzar">COMENZAR TEST</button>
         <?php } ?>
      </div>
      <div class="row">
			<div id="contenedorTiempoAgotado" style="display: none;">
				<h3>TIEMPO AGOTADO</h3>
			</div>
         <div class="alert infoTest">
            <p class="lblTest"></p>
         </div>

         <div class="contenedorPreguntas" style="display: none;">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h4 id="lblpregunta"></h4>
					</div>
				</div>
				<div class="row contRespuesta1">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta1 animated bounceInLeft" id="1" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta1" name="slctRespuesta1">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<div class="row contRespuesta2">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta2 animated bounceInLeft" id="2" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta2" name="slctRespuesta2">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<div class="row contRespuesta3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta3 animated bounceInLeft" id="3" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta3" name="slctRespuesta3">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<div class="row contRespuesta4">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta4 animated bounceInLeft" id="4" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta4" name="slctRespuesta4">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<div class="row contRespuesta5">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta5 animated bounceInLeft" id="5" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta5" name="slctRespuesta5">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<div class="row contRespuesta6">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta6 animated bounceInLeft" id="6" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta6" name="slctRespuesta6">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<div class="row contRespuesta7">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <div class="form-group" style="margin-bottom: -20px;">
                     <div class='input-group'>
                        <span class="input-group-addon sinFondo">
						         <button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta7 animated bounceInLeft" id="7" style="margin-right: 1%;"></button>
                        </span>
                        <span class="input-group-addon sinFondo contSlctRespuesta">
                           <select class="form-control" id="slctRespuesta7" name="slctRespuesta7">
                              <option value="1">0 - 300</option>
                              <option value="2">301 - 500</option>
                              <option value="3">501 - 900</option>
                              <option value="4"> > 901</option>
                           </select>
                        </span>
                     </div>
                  </div>
					</div>
				</div>
				<input type="hidden" id="idpregunta" name="idpregunta" value="0"/>
				<input type="hidden" id="idrespuesta" name="idrespuesta" value="0"/>

				<div class="row">
					<div class="form-group" style="margin-top: 2%;">
					<div class="col-md-3 col-xs-3">
					</div>

					<div class="col-md-6 col-xs-6" style="text-align: center;">
						<button type="button" class="btn btn-default enjoy-css-buttom-juego" id="responder">RESPONDER</button>
					</div>

					<div class="col-md-3 col-xs-3">
					</div>
					</div>
		      </div>

		      <div class="row">
		         <div class="form-group" style="margin-top: 1%;">
		            <div class="col-md-3 col-xs-3">
		            </div>

		            <div class="col-md-6 col-xs-6" style="text-align: center;">
		               <div id="barraprogreso"></div>
		            </div>

		            <div class="col-md-3 col-xs-3">
		            </div>
		         </div>
		      </div>

         </div>
      </div>


		</form>
		<?php } ?>
   </div>


   <!-- Modal -->
   <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">

         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h4 class="modal-title">Notificación</h4>
            </div>
            <div class="modal-body respuesta">

            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
         </div>

      </div>
   </div>
   <!-- fin modal -->

   <!-- Bootstrap Material Datetime Picker Plugin Js -->
   <script src="crm/plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
   <script src="crm/js/jquery.easy-autocomplete.min.js"></script>

	<script type="text/javascript">

		$(document).ready(function(){

         $('.contSlctRespuesta').hide();

         $('.infoTest').hide();

         $('#afore').change(function() {
            if ($(this).val() == 1) {
               $('.contCompania').show();
            } else {
               $('.contCompania').hide();
               $('#compania').val('');
            }
         });

         $('#telefonomovil').inputmask('999 9999999', { placeholder: '___ _______' });

         $('.frmNuevo').submit(function(e){

   			e.preventDefault();
   			if ($('#sign_in')[0].checkValidity()) {
   				//información del formulario
   				var formData = new FormData($(".formulario")[0]);
   				var message = "";
   				//hacemos la petición ajax
   				$.ajax({
   					url: 'crm/ajax/ajax.php',
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

   							$('.contAlta').hide();
                        $('.respuesta').html('Sus datos fueron ingresados correctamente, por favor revise su correo electronico, para seguir con el Proceso de Reclutamiento. Muchas Gracias.');
                        $('#myModal').modal();

   						} else {
                        $('.respuesta').html(data);
                        $('#myModal').modal();


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

         var options = {

   			url: "crm/json/jsbuscarpostal.php",

   			getValue: function(element) {
   				return element.colonia + ' ' + element.codigo;
   			},

   			ajaxSettings: {
   				dataType: "json",
   				method: "POST",
   				data: {
   					busqueda: $("#codigopostalbuscar").val()
   				}
   			},

   			preparePostData: function (data) {
   				data.busqueda = $("#codigopostalbuscar").val();
   				return data;
   			},

   			list: {
   				maxNumberOfElements: 20,
   				match: {
   					enabled: true
   				},
   				onClickEvent: function() {
   					var idpostal = $("#codigopostalbuscar").getSelectedItemData().id;
                  var value = $("#codigopostalbuscar").getSelectedItemData().codigo;
   					$("#codigopostal").html("<option value='" + idpostal + "'>" + value + "</option>");

   				}
   			}
   		};


   		$("#codigopostalbuscar").easyAutocomplete(options);


         $('#datetimepicker1').datetimepicker({
            locale: 'es',
            format: 'YYYY-MM-DD',
            maxDate: new Date()
         });

         <?php if (($yajugo == 1) || ($yajugo == 0)) { ?>

			$('.btnrespuesta').click(function() {
				$('.btnrespuesta').removeClass('enjoy-css-active');
				idResp =  $(this).attr("id");
				$('#idrespuesta').val(idResp);

			});

			$('.btnComenzar').click(function() {
				$('.contenedorPreguntas').show();
				$('.btnComenzar').hide();
				traerPregunta('<?php echo $secuencia; ?>');
			});

			var bar = new ProgressBar.Line(barraprogreso, {
				strokeWidth: 4,
				easing: 'easeInOut',
				duration: 7000,
				color: '#FFEA82',
				trailColor: '#eee',
				trailWidth: 1,
				svgStyle: {width: '100%', height: '100%'},
				from: {color: '#1b2646'},
				to: {color: '#1b2646'},
				step: (state, bar) => {
					bar.path.setAttribute('stroke', state.color);
				}
			});


			function traerPregunta(nivel) {
				$.ajax({
					dataType: 'json',
					url: 'crm/json/jspreguntas.php',
					data: {secuencia: nivel},
					beforeSend: function (XMLHttpRequest) {
                  $('#idrespuesta').val(0);
                  bar.set(0);
					},
					success: function(datos) {

						for (var clave in datos) {
							$('#lblpregunta').html('PREGUNTA: ' + datos[clave].pregunta);

							$('#idpregunta').val(datos[clave].idpregunta);

							if (datos[clave].respuesta1 != '') {
								$('.contRespuesta1').show();
								$('.respuesta1').html(datos[clave].respuesta1);
							} else {
								$('.contRespuesta1').hide();
								$('.respuesta1').html('');
							}

							if (datos[clave].respuesta2 != '') {
								$('.contRespuesta2').show();
								$('.respuesta2').html(datos[clave].respuesta2);
							} else {
								$('.contRespuesta2').hide();
								$('.respuesta2').html('');
							}

							if (datos[clave].respuesta3 != '') {
								$('.contRespuesta3').show();
								$('.respuesta3').html(datos[clave].respuesta3);
							} else {
								$('.contRespuesta3').hide();
								$('.respuesta3').html('');
							}


							if (datos[clave].respuesta4 != '') {
								$('.contRespuesta4').show();
								$('.respuesta4').html(datos[clave].respuesta4);
							} else {
								$('.contRespuesta4').hide();
								$('.respuesta4').html('');
							}

							if (datos[clave].respuesta5 != '') {
								$('.contRespuesta5').show();
								$('.respuesta5').html(datos[clave].respuesta5);
							} else {
								$('.contRespuesta5').hide();
								$('.respuesta5').html('');
							}

							if (datos[clave].respuesta6 != '') {
								$('.contRespuesta6').show();
								$('.respuesta6').html(datos[clave].respuesta6);
							} else {
								$('.contRespuesta6').hide();
								$('.respuesta6').html('');
							}

							if (datos[clave].respuesta7 != '') {
								$('.contRespuesta7').show();
								$('.respuesta7').html(datos[clave].respuesta7);
							} else {
								$('.contRespuesta7').hide();
								$('.respuesta7').html('');
							}

                     if (datos[clave].secuencia == 7) {
                        $('.contSlctRespuesta').show();
                     }

							$('#secuencia').val(datos[clave].secuencia + 1);

							bar.animate(1.0, {
								duration: datos[clave].tiempo * 1000
							}, function() {
								$('.contenedorPreguntas').hide();
								$('#contenedorTiempoAgotado').show();

							});

						}
					},
					error: function() { alert("Error leyendo fichero json"); }
				});
			}

			function cargarRespuesta(respuesta, pregunta) {
				$.ajax({
						data:  {id: '<?php echo $ip; ?>',
						respuesta: respuesta,
						pregunta: pregunta,
						accion:     'insertarIp'
					},
					url:   'crm/ajax/ajax.php',
					type:  'post',
					beforeSend: function () {

					},
					success:  function (response) {

						if (response.datos.respuesta == 'salir') {
							$('.contenedorPreguntas').hide();
                     $('.infoTest').show();
                     $('.infoTest').addClass('alert-' + response.datos.color);
                     $('.lblTest').html('<b>RESULTADO DEL TEST DE AFINIDAD: </b>' + response.datos.lbltest + ' haga click <b><a href="test.php">AQUI</a></b> para continuar con la carga de sus datos personales.');

						} else {
                     traerPregunta(response.datos.respuesta);
                  }

					}
				});
			}

         $('#responder').click(function() {

            $('.btnrespuesta').removeClass('enjoy-css-active');

            $('.respuesta').html('');
            if ($('#idrespuesta').val() == 0) {
               $('.respuesta').html('Debe elegir una respuesta para continuar.');
               $('#myModal').modal();
            } else {
               cargarRespuesta($('#idrespuesta').val(), $('#idpregunta').val());
            }

         });
         <?php } ?>
		});/* fin del document ready */
	</script>

</body>
</html>
