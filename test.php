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

$intento = 0;

$existe = $serviciosReferencias->traerIpPorIP($ip);

$yajugo = 0;

if (mysql_num_rows($existe)>0) {
	$secuencia = mysql_result($existe, 0,'secuencia');
	if ($secuencia == 7) {
		$yajugo = 2;
	} else {
		$yajugo = 1;
	}
} else {
	$yajugo = 0;
	$secuencia = 1;
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

   <!-- Waves Effect Css -->
   <link href="crm/plugins/node-waves/waves.css" rel="stylesheet" />

   <!-- Animation Css -->
   <link href="crm/plugins/animate-css/animate.css" rel="stylesheet" />

   <!-- Sweetalert Css -->
   <link href="crm/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

   <!-- Custom Css -->
   <link href="css/style.css" rel="stylesheet">

   <script src="js/progressbar.min.js"></script>

	<script type='text/javascript'>
		//document.oncontextmenu = function(){return false}
	</script>

   <style>
      .jumbotron {
         padding-top: 18px;
         padding-bottom: 18px;
      }

      #barraprogreso {
         margin: 20px;
         width: 90%;
         height: 20px;
			border: 1px solid rgba(27,41,72,1);
      }

		.contRespuesta1, .contRespuesta2, .contRespuesta3, .contRespuesta4, .contRespuesta5, .contRespuesta6 {
			text-align: center;
		}

		.enjoy-css {
		  display: inline-block;
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box;
		  width: 90%;
		  padding: 5px 20px;
		  border: 2px solid rgba(27,41,72,1);
		  background: rgba(27,41,72,1);
		  -webkit-border-radius: 22px;
		  border-radius: 22px;
		  font: normal 15px/normal Arial Black, Gadget, sans-serif;
		  color: #fff;
		  -o-text-overflow: clip;
		  text-overflow: clip;
		  -webkit-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
		  -moz-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
		  -o-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
		  transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1);
		  margin-bottom: 15px;
		}

		.enjoy-css-buttom3 {
		  display: inline-block;
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box;
		  cursor: pointer;
		  padding: 1px 25px;
		  border: 1px solid #382d99;
		  -webkit-border-radius: 23px;
		  border-radius: 20px;
		  font: normal 20px BebasNeueRegular;
		  color: rgba(255,255,255,1);
		  -o-text-overflow: clip;
		  text-overflow: clip;
		  background: rgba(53,42,151,1);
		  -webkit-box-shadow: 4px 5px 40px -10px rgba(53,42,151,1.8);
		   -moz-box-shadow: 4px 5px 40px -10px rgba(53,42,151,1.8);
		   box-shadow: 5px 40px -10px rgba(53,42,151,1.8);
		}

		.enjoy-css:hover {
		  color: #FFF;
		  background: rgba(27,41,72,0.7);
		}

		.enjoy-css:active {
		  color: #0f0559;
		  background: #fff;
		  border: 2px solid rgba(27,41,72,1);
		}

		.enjoy-css-active {
		  color: #0f0559;
		  background: #fff;
		  border: 2px solid rgba(27,41,72,1);
		}

		.enjoy-css:focus {
		  color: #0f0559;
		  background: #fff;
		  border: 2px solid rgba(27,41,72,1);
		}

		.enjoy-css-buttom {
		  display: inline-block;
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box;
		  cursor: pointer;
		  padding: 3px 20px;
		  border: 1px solid #9298ba;
		  -webkit-border-radius: 23px;
		  border-radius: 23px;
		  font: normal 30px BebasNeueRegular;
		  color: rgba(255,255,255,1);
		  -o-text-overflow: clip;
		  text-overflow: clip;
		  background: rgba(146,152,186,1);
		}

		.enjoy-css-buttom-juego {
		  display: inline-block;
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box;
		  cursor: pointer;
		  padding: 6px 40px;
		  border: 1px solid rgba(34,153,84,1);
		  -webkit-border-radius: 23px;
		  border-radius: 23px;
		  font: normal 20px Arial;
		  color: rgba(255,255,255,1);
		  -o-text-overflow: clip;
		  text-overflow: clip;
		  background: rgba(34,153,84,1);
		  -webkit-box-shadow: 0px 0px 0px 12px rgba(35,158,82,1);
		   -moz-box-shadow: 0px 0px 0px 12px rgba(35,158,82,1);
		   box-shadow: 0px 0px 12px rgba(35,158,82,1);
		}

		.enjoy-css-buttom:hover {
			background: rgba(146,152,186,1);
			color: rgba(255,255,255,1);
		}

		.enjoy-css:focus{
			outline:0px;
		}

		#lblpregunta {
			padding: 12px;
			border: 1px solid rgba(53,42,151,1);
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

		<?php } else { ?>
      <div class="row">
         <p>Esta vacante es lo que buscas y se adpata a tus expactativas económicas? Te pedimo nos regales un máximo de 5 minutos de tu tiempo, para constetar 6 simples preguntas y sabremos si nuestra oferta de trabajo es compatible con tus intereses. Esto también nos apoya para ofrecerte un plan de carrera personalizado.</p>
      </div>
		<form role="form" class="formulario">
      <div class="row">
         <button type="button" class="btn btn-success btnComenzar">COMENZAR TEST</button>
      </div>
      <div class="row">
			<div id="contenedorTiempoAgotado" style="display: none;">

            <h3>TIEMPO AGOTADO</h3>

        </div>

         <div class="contenedorPreguntas" style="display: none;">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<h4 id="lblpregunta"></h4>
					</div>
				</div>
				<div class="row contRespuesta1">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta1 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<div class="row contRespuesta2">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta2 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<div class="row contRespuesta3">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta3 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<div class="row contRespuesta4">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta4 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<div class="row contRespuesta5">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta5 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<div class="row contRespuesta6">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta6 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<div class="row contRespuesta7">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<button type="button" class="btnrespuesta btn btn-default enjoy-css respuesta7 animated bounceInLeft" id="" style="margin-right: 1%;"></button>
					</div>
				</div>
				<input type="hidden" id="idpregunta" name="idpregunta" value="0"/>

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

	<script type="text/javascript">

		$(document).ready(function(){

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
				from: {color: '#0FF354'},
				to: {color: '#FF0000'},
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

					},
					success: function(datos) {

						for (var clave in datos) {
							$('#lblpregunta').html('PREGUNTA: ' + datos[clave].pregunta);

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

			function volver(){
				$('#contenedorFinalizo').show();
				$('#contenedorGanaBotella').hide();
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
						if (response == 'salir') {
							volver();
						}

					}
				});
			}
		});/* fin del document ready */
	</script>

</body>
</html>
