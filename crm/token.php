<?php

require 'includes/funcionesUsuarios.php';
require 'includes/funcionesReferencias.php';
require 'includes/funciones.php';
require 'includes/validadores.php';

session_start();

$serviciosUsuario = new ServiciosUsuarios();
$serviciosReferencias = new ServiciosReferencias();
$serviciosFunciones 	= new Servicios();
$serviciosValidador = new serviciosValidador();



if (isset($_SESSION['usua_sahilices'])) {
   $token = $_SESSION['token_ac'];

   $resultado = $serviciosReferencias->traerTokenasesoresPorTokenActivo($token);

   if (mysql_num_rows($resultado)>0) {
      header('Location: dashboard/'.mysql_result($resultado,0,'accion'));
   } else {
      header('Location: error.php');
   }
} else {

   $arInput = array();

   $error = false;

   if (isset($_GET['token'])) {
      $token           = $_GET['token'];
   } else {
      header('Location: error.php');
   }

   $resultado = $serviciosReferencias->traerTokenasesoresPorTokenActivo($token);

   // verifico el token valido y que este vigente
   if (mysql_num_rows($resultado)>0) {
      $idcliente = mysql_result($resultado,0,'refclientes');
      $idasesor = mysql_result($resultado,0,'refasesores');




      // busco si el cliente tiene ya un usuario asignado, de ser asi es ROL: clientes / del sistema
      $resClientes = $serviciosReferencias->traerClientesPorId($idcliente);

      $refusuario = mysql_result($resClientes,0,'refusuarios');

      if ($refusuario > 0) {
         $error = true;
         array_push($arInput,array('mensaje' => 'Ya tienes un usuario creado en el sistema para ingresar'));
      } else {
         // verifico si ya creo su usuario en algun otro token
         $existeUsuarioToken = $serviciosReferencias->existeTokenAsesores($idasesor,$idcliente);



         if ($existeUsuarioToken > 0) {
            // aca ya tengo el usuario para ingresar al sistema automaticamente.
            $resUsuario = $serviciosUsuario->traerUsuarioIdAutoLogin(mysql_result($resultado,0,'refusuarios'));
            if (mysql_num_rows($resUsuario) > 0) {


               $_SESSION['idcliente_sahilices'] = $idcliente;

               $_SESSION['token_ac'] = $token;

      			$_SESSION['usua_sahilices'] = mysql_result($resUsuario,0,'email');
      			$_SESSION['nombre_sahilices'] = mysql_result($resUsuario,0,'nombrecompleto');
      			$_SESSION['usuaid_sahilices'] = mysql_result($resUsuario,0,0);
      			$_SESSION['email_sahilices'] = mysql_result($resUsuario,0,'email');
      			$_SESSION['idroll_sahilices'] = mysql_result($resUsuario,0,'refroles');
      			$_SESSION['refroll_sahilices'] = mysql_result($resUsuario,0,'descripcion');

               //die(var_dump(mysql_result($resultado,0,'accion')));
               header('Location: dashboard/'.mysql_result($resultado,0,'accion'));
            } else {
               $error = true;
               array_push($arInput,array('mensaje' => 'El usuario no pudo ser creado, contactese con la administración'));
            }
         } else {
            // aca se tiene que dar de alta como usuario
            array_push($arInput,array('mensaje' => 'Por favor ingresa tus datos para darte de alta al sistema'));

         }

      }
   } else {
      $error = true;
      array_push($arInput,array('mensaje' => 'Vencio el plazo de esta URL'));
   }





}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Acceder | Asesores CREA</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />

	 <!-- Bootstrap Material Datetime Picker Css -->
    <link href="plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="css/style.css" rel="stylesheet">

	 <script type='text/javascript'>
 		document.oncontextmenu = function(){return false}

       window.addEventListener("keypress", function(event){
          if (event.keyCode == 13){
             event.preventDefault();
          }
       }, false);

 	</script>
</head>

<body class="login-page">
    <div class="login-box">
        <div class="logo" style="border: 1px solid #8c6f40; background-color:#c6ac83; padding:10px 10px; color: #1c2a47;">
			   <h4 style="color:#1c2a47 ; text-align:center;">Activación</h4>
				<a href="javascript:void(0);" style="color:#1c2a47 ;"><b>Asesores CREA</b></a>

            <small style="color:#1c2a47 ;"><b>Fácil y Seguro (Afore, Banca y Seguro)</b></small>
        </div>
        <div class="card">
            <div class="body demo-masked-input">

					 <?php if ($error == false) { ?>
                  <form id="sign_in" method="POST">
						<div align="center">
							<h3><?php echo mysql_result($resClientes,0,'nombre').' '.mysql_result($resClientes,0,'apellidopaterno').' '.mysql_result($resClientes,0,'apellidomaterno'); ?></h3>
							<div class="alert bg-green">Por favor cargue una password para completar el alta de usuario.</div>
							<div class="alert bg-red">Recuerde que el PASSWORD debe contener (10 caracteres, al menos una mayuscula, al menos una minuscula y un numero).</div>
						</div>

						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">account_box</i>
							</span>
							<div class="form-line">
								<input type="text" class="form-control" name="nombre" id="nombre" data-toggle="tooltip" data-placement="top" title="Ingresa el nombre de usuario" placeholder="USUARIO" value="<?php echo mysql_result($resClientes,0,'apellidopaterno').mysql_result($resClientes,0,'apellidomaterno').mysql_result($resClientes,0,'nombre'); ?>" required/>

							</div>
						</div>


						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">account_circle</i>
							</span>
							<div class="form-line">
								<input type="text" class="form-control" name="email" id="email" data-toggle="tooltip" data-placement="top" title="Ingresa tu email" value="<?php echo mysql_result($resClientes,0,'email'); ?>" placeholder="EMAIL" maxlength="120" required/>

							</div>
						</div>


						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">lock</i>
							</span>
							<div class="form-line">
								<input type="password" class="form-control" name="password" id="password" data-toggle="tooltip" data-placement="top" title="Ingresa un password" maxlength="8" placeholder="Ingrese un Password" required/>

							</div>

						</div>

						<div class="input-group">
							<span class="input-group-addon">
								<i class="material-icons">lock</i>
							</span>
							<div class="form-line">
								<input type="password" class="form-control" name="passwordaux" id="passwordaux" maxlength="8" placeholder="Confirme su Password" required/>

							</div>

						</div>

						<div class="row js-sweetalert">
							<div class="col-xs-7 p-t-5">
								<a href="index.html">Iniciar sesión</a>
							</div>
							<div class="col-xs-5">
								<button class="btn btn-block bg-blue waves-effect" data-type="" type="submit" id="login">ACTIVARSE</button>
							</div>
						</div>

						<input type="hidden" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>" />
						<input type="hidden" name="accion" id="accion" value="crearUsuarioClienteAgente" />
                  <input type="hidden" name="token" id="token" value="<?php echo $token; ?>" />

               </form>
               <?php } else { ?>
                  <h4><?php echo $arInput[0]['mensaje']; ?></h4>

                  <div class="row m-t-15 m-b--20">
                     <div class="col-xs-6">
                        <a href="index.html">Iniciar Sessión!!</a>
                     </div>
                     <div class="col-xs-6 align-right">

                     </div>
                  </div>
               <?php } ?>
            </div>
        </div>
    </div>

	 <div class="modal fade" id="lgmNuevo" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header bg-riderz">
                    <h4 class="modal-title" id="largeModalLabel">ASESORES CREA ACTIVACION</h4>
                </div>
                <div class="modal-body">
                   <div class="">
                      <div class="row">
                        <h4>Su usuario fue activado con Exito.</h4>
                      </div>

                   </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-blue waves-effect"><a href="index.html" style="color:white; text-decoration:none;">Iniciar sesión</a></button>

                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="js/admin.js"></script>
    <script src="js/pages/examples/sign-in.js"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="plugins/sweetalert/sweetalert.min.js"></script>

    <script src="js/pages/ui/dialogs.js"></script>

	 <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

	 <script src="plugins/momentjs/moment.js"></script>

	 <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <script src="js/pages/ui/tooltips-popovers.js"></script>


    <script type="text/javascript">

        $(document).ready(function(){
			  var $demoMaskedInput = $('.demo-masked-input');

           $('#wizard_with_validation [data-toggle="tooltip"]').tooltip();


				$('.datepicker').bootstrapMaterialDatePicker({
					format: 'YYYY-MM-DD',
					clearButton: true,
					weekStart: 1,
					time: false
				});


				function validarPASS(pass) {
						var re = /(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.{8,})/,
						validado = pass.match(re);

				    if (!validado)  //Coincide con el formato general?
				    	return false;

				    return true; //Validado
				}

				function validaIgualdad(pass, passaux) {
					if (pass != passaux) {
						return false;
					}

					return true;
				}


				$('#passwordaux').focusout(function() {
					if (validaIgualdad($('#password').val(),$('#passwordaux').val()) == false) {
						swal({
							title: "Error",
							text: "Los PASSWORDs no coinciden",
							type: "error",
							timer: 10000,
							showConfirmButton: true
						});

						$('#login').hide();
					} else {
						$('#login').show();
					}
				});

				$('#password').focusout(function() {
					if (validarPASS($('#password').val()) == false) {
						swal({
							title: "Respuesta",
							text: "PASSWORD no valido. Recuerde que el PASSWORD debe contener (8 caracteres, al menos una mayuscula, al menos una minuscula y un numero)",
							type: "error",
							timer: 10000,
							showConfirmButton: true
						});

						$(this).focus();
					} else {
						if (validaIgualdad($('#password').val(),$('#passwordaux').val()) == false) {
							swal({
								title: "Error",
								text: "Los PASSWORDs no coinciden",
								type: "error",
								timer: 10000,
								showConfirmButton: true
							});

							$('#login').hide();
						} else {
							$('#login').show();
						}
					}
				});


            $("#sign_in").submit(function(e){

                e.preventDefault();
                if ($('#sign_in')[0].checkValidity()) {
						 var formData = new FormData($("#sign_in")[0]);

                   $.ajax({
								data: formData,
								//necesario para subir archivos via ajax
								cache: false,
								contentType: false,
								processData: false,
                       url:   'ajax/ajax.php',
                       type:  'post',
                       beforeSend: function () {
                               $("#load").html('<img src="imagenes/load13.gif" width="50" height="50" />');
										 $('#login').hide();
                       },
                       success:  function (response) {

                            if (isNaN(response)) {

                                swal({
                                    title: "Respuesta",
                                    text: response,
                                    type: "error",
                                    timer: 2000,
                                    showConfirmButton: false
                                });
										  $('#login').show();

                            } else {
                                $('#lgmNuevo').modal();

										  $('#login').hide();

                                //url = "dashboard/";
                                //$(location).attr('href',url);
                            }

                       }
                   });
                }


            });


        });/* fin del document ready */

    </script>
</body>

</html>
