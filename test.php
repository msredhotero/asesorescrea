<?php


function getRealIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        return $_SERVER['HTTP_CLIENT_IP'];

    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        return $_SERVER['HTTP_X_FORWARDED_FOR'];

    return $_SERVER['REMOTE_ADDR'];
}

$id = getRealIP();

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
	<link rel="stylesheet" href="css/style.css">
	<link href="css/navigation.css" rel="stylesheet">
	<script src="js/jquery.min.js"></script>
	<link rel="stylesheet" href="css/layerslider.css">
	<script src="js/greensock.js"></script>
	<script src="js/layerslider.transitions.js"></script>
	<script src="js/layerslider.kreaturamedia.jquery.js"></script>
	<link rel="stylesheet" href="css/layerslider.popup.css">
	<script src="js/layerslider.popup.js"></script>

	<!-- Waves Effect Css -->
	<link href="crm/plugins/node-waves/waves.css" rel="stylesheet" />

	<!-- Animation Css -->
	<link href="crm/plugins/animate-css/animate.css" rel="stylesheet" />

	<!-- Sweetalert Css -->
	<link href="crm/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

	<style>
	.selectBox {
		width: 140px !important;
		height: 36px !important;
		border: 0px !important;
		outline: none !important;
		border-radius: 35px;
		border: rgba(27,41,72,0.6) solid 1px !important;
	}



	.selectWrapperErr {
		border-radius: 36px !important;
		display: inline-block !important;
		overflow: hidden !important;
		background: #cccccc !important;
		border: 2px solid red !important;
	}

	.error input {
		border: 1px solid #F00 !important;
	}
	.error {
		color: red !important;
	}
	</style>
</head>

<body>
	<div class="content">
		<div class="container bg-log">
			<div class="log">
				<a href="#" id="iniciar">Iniciar sesión</a>
				<a href="registro.html">Regístrate</a>
				<p><i class="ion-person"></i> Usuario</p>
			</div>
		</div>
		<div class="container">
			<a href="chopo.html" class="chopo">
				<img src="img/logo-chopo.png" alt="" class="img100" />Si cuentas con un <br>descuento derivado de <br>un estudio clínico <br>entra <strong>aquí</strong>.
			</a>
			<header>
				<div class="bg-gris">
					<div class="tel">
						<div class="off1023"><i class="ion-android-call"></i> (55) 5135.0259 - 01800.8376.133</div>
						<div class="on1023"><i class="ion-android-call"></i> (55) 5135.0259<br><span class="transparent"><i class="ion-android-call"></i>&nbsp;</span>01800.8376.133</div>
					</div>
					<div class="redes">
						<ul>
							<li><a href="https://www.linkedin.com/company/18357646/" target="_blank"><i class="ion-social-linkedin"></i></a></li>
							<li><a href="https://www.facebook.com/Asesores-CREA-1633356073370079/" target="_blank"><i class="ion-social-facebook"></i></a></li>
							<li><a href="https://twitter.com/asesorescrea" target="_blank"><i class="ion-social-twitter"></i></a></li>
						</ul>
					</div>
					<div class="cobertura">
						<span>COBERTURA NACIONAL</span> <br class="on1023"><em>¡Siempre un asesor cerca para ti!</em>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="on767 slogan767">
					El mejor servicio y condiciones en crédito<br>y seguros con cobertura nacional
				</div>
				<div class="logo">
					<a href="index.html"><img src="img/logo.png" alt="" /></a>
					<div>Asesores en Banca y Seguros</div>
				</div>
				<div class="menu">
					<div class="slogan">El mejor servicio y condiciones en crédito y seguros</div>
					<div class="clearfix"></div>
					<ul class="off940">
						<li><a href="seguro-auto.html"><p>SEGURO<br><span>DE AUTO</span></p><i class="icon-icon1"></i></a></li>
						<li><a href="gastos-medicos-mayores.html"><p>GASTOS MÉDICOS<br><span>MAYORES</span></p><i class="icon-icon2"></i></a></li>
						<li><a href="servicios-telmex.html"><p>SERVICIOS<br><span>TELMEX</span></p><i class="icon-icon3"></i></a></li>
						<li><a href="gastos-medicos-bajo-costo.html"><p>GASTOS MÉDICOS<br><span>BAJO COSTO</span></p><i class="icon-icon4"></i></a></li>
						<li><a href="vida-express.html"><p>VIDA<br><span>EXPRESS</span></p><i class="icon-icon5"></i></a></li>
						<li><a href="tpv.html"><p>TERMINAL PUNTO<br><span>DE VENTA</span></p><i class="icon-icon6"></i></a></li>
						<li><a href="tarjeta-credito.html"><p>TARJETA DE<br><span>CRÉDITO</span></p><i class="icon-icon7"></i></a></li>
						<li><a href="credito-hipotecario.html"><p>CRÉDITO<br><span>HIPOTECARIO</span></p><i class="icon-icon8"></i></a></li>
					</ul>
					<div class="on940">
						<nav id="navigation1" class="navigation">
							<div class="nav-header">
								<div class="nav-toggle"></div>
							</div>
							<div class="nav-menus-wrapper">
								<ul class="nav-menu align-to-right">
									<li><a href="seguro-auto.html"><i class="icon-icon1"></i>Seguro <span>de Auto</span></a></li>
									<li><a href="gastos-medicos-mayores.html"><i class="icon-icon2"></i>Gastos Médicos <span>Mayores</span></a></li>
									<li><a href="servicios-telmex.html"><i class="icon-icon3"></i>Servicios <span>Telmex</span></a></li>
									<li><a href="gastos-medicos-bajo-costo.html"><i class="icon-icon4"></i>Gastos Médicos <span>Bajo Costo</span></a></li>
									<li><a href="vida-express.html"><i class="icon-icon5"></i>Vida <span>Express</span></a></li>
									<li><a href="tpv.html"><i class="icon-icon6"></i>Terminal <span>Punto de Venta</span></a></li>
									<li><a href="tarjeta-credito.html"><i class="icon-icon7"></i>Tarjeta de <span>Crédito</span></a></li>
									<li><a href="credito-hipotecario.html"><i class="icon-icon8"></i>Crédito <span>Hipotecario</span></a></li>
								</ul>
							</div>
						</nav>
					</div>
				</div>
				<div class="clearfix"></div>
			</header>

			<section class="tech">
				<form id="sign_in" method="POST">
				<div class="col1">
					<h2 class="titulos">Crea tu cuenta</h2>
					<div class="linea"></div>
					<div class="clearfix height-20"></div>
					<div class="col50">
						<p>Nombre</p>
						<div class="input-group">
							<div class="form-line">
								<input type="text" name="txtnombre" id="txtnombre" required />
							</div>
						</div>
						<p>Email</p>
						<div class="input-group">
							<div class="form-line">
								<input type="email" name="txtemail" id="txtemail"required />
							</div>
						</div>
						<p>Teléfono</p>
						<div class="input-group">
							<div class="form-line">
								<input type="tel" name="txttelefono" id="txttelefono"required />
							</div>
						</div>
						<p>Código postal</p>
						<div class="input-group">
							<div class="form-line">
								<input type="number" name="txtcodigopostal" id="txtcodigopostal"required />
							</div>
						</div>
					</div>
					<div class="col50-2">
						<p>Apellido Paterno</p>
						<div class="input-group">
							<div class="form-line">
								<input type="text" name="txtapellidopaterno" id="txtapellidopaterno"required />
							</div>
						</div>
						<p>Apellido Materno</p>
						<div class="input-group">
							<div class="form-line">
								<input type="text" name="txtapellidomaterno" id="txtapellidomaterno"required />
							</div>
						</div>
						<p>Fecha de nacimiento</p>
						<div class="input-group">
							<div class="form-line">
								<input type="date" name="dtpfechanacimiento" id="dtpfechanacimiento"required />
							</div>
						</div>
						<p>Sexo</p>

						<div id="div_dia" class="selectWrapper">
							<select name="cbsexo" id="cbsexo" class="selectBox" required >
								<option value="0">Seleccione</option>
								<option value="M">Masculino</option>
								<option value="F">Femenino</option>
							</select>
						</div>
						<p style="font-weight: normal; margin-top:25px;">Acepto los <a href="aviso-privacidad.html" target="_blank" style="font-weight: bold; text-decoration: underline;">Términos del servicio y la Política de privacidad</a>, incluido el uso de cookies.</p>
						<div class="input-group">
							<div class="form-line">
								<input type="checkbox" name="cbxterminos" id="cbxterminos" required />
							</div>
						</div>

					</div>
					<div class="clearfix"></div>
					<p class="right">*Todos los campos son obligatorios.</p>
					<button type="submit" id="login" class="btn1">REGISTRARSE</button>
					<p>Si te registras, significa que aceptas los Términos del servicio y la Política de privacidad, incluido el Uso de cookies.</p>
					<p class="font21"><strong>¡Gracias!</strong>, te hemos enviado un correo para que confirmes tu cuenta de correo electrónico.</p>
				</div>
				</form>
			</section>

			<div class="clearfix"></div>

			<footer class="bg-gris">
				<div class="inner">
					<div class="col-1-footer">
						<h3>NUESTRA CULTURA</h3>
						<div class="linea"></div>
						<ul class="cultura">
							<li>Trascendencia</li>
							<li>Clientes primero</li>
							<li>Tratar el negocio como nuestro</li>
							<li>Transparencia</li>
							<li>Confidencialidad</li>
						</ul>
						<a href="nuestra-cultura.html" class="btn2">Leer más</a>
					</div>
					<div class="col-2-footer">
						<h3>LO QUE NUESTROS CLIENTES PIENSAN</h3>
						<div class="linea"></div>
						<i class="ion-android-star"></i>
						<i class="ion-android-star"></i>
						<i class="ion-android-star"></i>
						<i class="ion-android-star"></i>
						<i class="ion-android-star-half"></i>
						<p class="puntuacion">4</p>
						<div class="clearfix"></div>
						<p class="numero-opiniones">3 opiniones</p>
						<a href="opiniones.html" class="btn-opinion">Leer opiniones</a>
					</div>
					<div class="col-3-footer">
						<h3>SOCIOS COMERCIALES</h3>
						<div class="linea"></div>
						<p>Si eres agente consolidado y actualmente no ofreces servicios de Grupo Financiero Inbursa; ofrece más y mejores alternativas a tus clientes. Intégrate con nosotros o escríbenos a: <a href="mailto:socioscomerciales@asesorescrea.com" class="btn-mail">socioscomerciales@asesorescrea.com</a>.</p>
						<p><a href="pdf/socios-comerciales-asesores-crea.pdf" target="_blank" class="btn-negocio">Conoce nuestra<br><strong>propuesta de negocio</strong></a></p>
					</div>
					<div class="clearfix"></div>
					<div class="copy off767">
						<p><strong>Asesores Crea 2018</strong> © Todos los Derechos Reservados.</p>
					</div>
					<div class="final-btns">
						<ul>
							<li><a href="aviso-privacidad.html">Aviso de Privacidad</a></li>
							<li><a href="preguntas-frecuentes.html">Preguntas Frecuentes</a></li>
							<li><a href="acerca-Inbursa.html">Acerca de Inbursa</a></li>
						</ul>
					</div>
					<div class="clearfix"></div>
				</div>
			</footer>
			<div class="copy on767">
				<p><strong>Asesores Crea 2018</strong> © Todos los Derechos Reservados.</p>
			</div>
		</div>
	</div>
	<div class="ls-popup">
		<div id="slider" style="width:350px;height:340px;margin:0 auto;margin-bottom: 0px;">
			<div class="ls-slide" data-ls="bgcolor:#fafaf8; kenburnsscale:1.2;">
				<p style="top:20px; left:20px; font-size:26px; font-weight: 700;" class="ls-l" data-ls="offsetyin:100;">Iniciar sesión</p>
				<p style="top:70px; left:20px; font-size:16px;" class="ls-l" data-ls="offsetyin:100;">Correo o usuario</p>
				<input type="text" style="top:100px; left:20px; font-size:16px; border-radius: 35px; width: 300px; height: 25px; border: rgba(27,41,72,0.6) solid 1px; background: rgba(255,255,255,0.4); outline: none; padding: 4px;" class="ls-l" data-ls="offsetyin:100;">
				<p style="top:150px; left:20px; font-size:16px; " class="ls-l" data-ls="offsetyin:100;">Contraseña</p>
				<input type="text" style="top:180px; left:20px; font-size:16px; border-radius: 35px; width: 300px; height: 25px; border: rgba(27,41,72,0.6) solid 1px; background: rgba(255,255,255,0.4); outline: none; padding: 4px;" class="ls-l" data-ls="offsetyin:100;">
				<a style="" class="ls-l" href="#closepopup" target="_self" data-ls="offsetyin:100; delayin:100; hover:true; hoverbgcolor:#008AD1;"><span style="top:230px; left:20px; text-align:center; padding: 10px;	border-radius: 25px; background: rgba(27,41,72,1); color: #fff;	text-transform: uppercase; letter-spacing: 4px;	width: 290px;" class="">Iniciar sesión</span></a>
				<a style="" class="ls-l" href="contrasena-olvidada.html" target="_self" data-ls="offsetyin:100lh; delayin:500; fadein:false; hover:true; hovercolor:#1B2948;">
					<p style="top:290px; left:20px; font-size:16px; color:#008AD1;" class="">¿Olvidáste tu contraseña?</p>
				</a>
			</div>
		</div>
	</div>


	<script type="text/javascript" src="js/navigation.js"></script>
	<script type="text/javascript" src="js/examples.js"></script>


	<script src="crm/plugins/jquery-validation/jquery.validate.js"></script>
	<script src="crm/plugins/sweetalert/sweetalert.min.js"></script>

	<script src="crm/js/pages/ui/dialogs.js"></script>

	<script src="crm/js/pages/examples/sign-in.js"></script>

	<script type="text/javascript">
		$(document).ready(function() {
			$('#slider').layerSlider({
				createdWith: '6.5.7',
				sliderVersion: '6.6.4',
				autoStart: false,
				popupShowOnClick:'#iniciar',
				pauseOnHover: 'disabled',
				globalBGSize: 'cover',
				hoverPrevNext: false,
				navButtons: false,
				navStartStop: false,
				hoverBottomNav: false,
				showCircleTimer: false,
				thumbnailNavigation: 'disabled',
				popupShowOnTimeout: 'disabled',
				popupShowOnce: false,
				popupCloseButtonStyle: 'border: 0; left: auto; right: 0; top:0; border-radius: 0px; text-align:center; color:black;',
				popupResetOnClose: 'disabled',
				popupDistanceLeft: 20,
				popupDistanceRight: 20,
				popupDistanceTop: 20,
				popupDistanceBottom: 20,
				popupDurationIn: 500,
				popupDelayIn: 500,
				popupTransitionIn: 'scale',
				popupTransitionOut: 'fade',
				popupOverlayBackground: 'rgba(0,0,0,.8)',
				plugins: ["popup"]
			});

			$('body').keyup(function(e) {
				 if(e.keyCode == 13) {
					  $("#login").click();
				 }
			});


			$("#sign_in").submit(function(e){

				e.preventDefault();
				if ($('#sign_in')[0].checkValidity()) {
					if ($("#cbsexo").val() != 0) {
						$.ajax({
							data: {	email:				$("#txtemail").val(),
										apellidopaterno:	$("#txtapellidopaterno").val(),
										nombre:				$("#txtnombre").val(),
										telefono:			$("#txttelefono").val(),
										apellidomaterno:	$("#txtapellidomaterno").val(),
										sexo: 				$('#cbsexo').val(),
										codigopostal:		$("#txtcodigopostal").val(),
										fechanacimiento:	$("#dtpfechanacimiento").val(),
										terminos:				$("#cbxterminos").prop('checked') == true ? 1 : 0,
										accion:		'registrarme'
									},
							url:   'crm/ajax/ajax.php',
							type:  'post',
							beforeSend: function () {
								$("#load").html('<img src="imagenes/load13.gif" width="50" height="50" />');
								$('#login').hide();
								$('#sign_in').hide();
							},
							success:  function (response) {

								if ((response == '')) {

									swal({
										 title: "Respuesta",
										 text: "Se Registro Correctamente, le enviamos un email a su correo, por favor verifiquelo para continuar con la activación de su cuenta!. Muchas Gracias.",
										 type: "success",
										 timer: 5500,
										 showConfirmButton: true
									});
									$('#login').hide();

								} else {
									swal({
										title: "Respuesta",
										text: response,
										type: "error",
										timer: 2000,
										showConfirmButton: false
									});
									$('#login').show();
									$('#sign_in').show();

								}

							}
						});
					} else {
						swal({
							title: "Respuesta",
							text: 'Debe seleccionar un sexo',
							type: "error",
							timer: 2000,
							showConfirmButton: false
						});
					}
				}

			});
		});

	</script>
</body>
</html>
