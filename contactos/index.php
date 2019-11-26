<?php

include ('../crm/includes/funciones.php');

include ('../crm/includes/funcionesHTML.php');
include ('../crm/includes/funcionesContactos.php');

$serviciosFunciones 	= new Servicios();

$serviciosHTML 			= new ServiciosHTML();
$serviciosContactos 	= new ServiciosContactos();

$resVar = $serviciosContactos->traerProductos();
$cadVar = utf8_decode( $serviciosFunciones->devolverSelectBox($resVar,array(1),''));


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Acceder | ASESORES CREA</title>
    <!-- Favicon-->
    <link rel="icon" href="../crm/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../crm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../crm/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../crm/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="../crm/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <link href="../crm/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../crm/css/style.css" rel="stylesheet">
</head>

<body class="login-page" style="max-width: 66% !important;">
   <div class="row clearfix" style="margin-top: -40px !important;">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card ">
               <div class="header bg-blue">
                  <h2>
                     BIENVENIDOS A ASESORES CREA
                  </h2>
               </div>
               <div class="body table-responsive">
                  <form class="formulario" role="form" id="sign_in">

                  <div class="row" align="center" style="margin-top: -20px !important;">
                     <h2 style="color: #1b2646;">¿Estás interesado en participar del Proyecto?</h2>
                  </div>

                  <div class="row" align="center">
                     <button type="button" class="btn bg-green btn-lg waves-effect respuestaSI animated bounceIn" style="font-size:22px !important;">
                        <i class="material-icons">thumb_up</i>
                        <span>Si</span>
                     </button>

                     <button type="button" class="btn bg-light-blue btn-lg waves-effect respuestaMI animated bounceInRight" style="font-size:22px !important;">
                        <i class="material-icons">touch_app</i>
                        <span>Me gustaría recibir más información</span>
                     </button>
                     <button type="button" class="btn bg-red btn-lg waves-effect respuestaNO animated bounceInRight" style="font-size:22px !important;">
                        <i class="material-icons">thumb_down</i>
                        <span>No</span>
                     </button>
                  </div>

                  <div class="row contDatos1" style="margin-top:3% !important; padding: 10px 25px;">
                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="input-group">
                           <span class="input-group-addon">
                              <i class="material-icons">person</i>
                           </span>
                           <div class="form-line emailInput">
                              <input type="text" class="form-control" maxlength="120" name="nombre" id="nombre" placeholder="Nombre" />
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <div class="input-group">
                           <span class="input-group-addon">
                              <i class="material-icons">person</i>
                           </span>
                           <div class="form-line emailInput">
                              <input type="text" class="form-control" maxlength="120" name="apellido" id="apellido" placeholder="Apellido"  />
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="input-group">
                           <span class="input-group-addon">
                              <i class="material-icons">work</i>
                           </span>
                           <div class="form-line emailInput">
                              <input type="text" class="form-control" maxlength="120" name="agencia" id="agencia" placeholder="Nombre de la/s Agencia/s"  />
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h4>Elije los productos en los que estes más interesado comercializar</h4>
                        <hr>
                     </div>
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="input-group">
                           <span class="input-group-addon">
                              <i class="material-icons">star_rate</i>
                           </span>
                           <div class="form-line">
                              <select class="form-control show-tick" name="refproductos[]" id="refproductos" multiple />
                                 <?php echo $cadVar; ?>
                              </select>
                           </div>
                        </div>
                     </div>

                  </div>

                  <div class="row contDatos2" style="padding: 10px 25px;">
                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:15px !important;">
                        <div class="input-group">
                           <span class="input-group-addon">
                              <b>Observaciones</b>
                           </span>
                           <span class="input-group-addon">
                              <i class="material-icons">info</i>
                           </span>
                           <div class="form-line">
                              <textarea class="form-control" name="observaciones" id="observaciones" row="3" /></textarea>
                           </div>
                        </div>
                     </div>

                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top:15px !important;">
                        <button type="button" class="btn bg-green waves-effect btnEnviar">
         						<i class="material-icons">send</i>
         						<span>ENVIAR</span>
         					</button>
                     </div>

                     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top:15px !important;">
                        <button type="button" class="btn bg-ORANGE waves-effect btnReiniciar">
         						<i class="material-icons">autorenew</i>
         						<span>REINICIAR</span>
         					</button>
                     </div>
                  </div>
                  <input type="hidden" name="pregunta" id="pregunta" vallue="0"/>
               </form>
               </div>
            </div>
         </div>
      </div>
   </div> <!-- fin del container entrevistas -->

    <!-- Jquery Core Js -->
    <script src="../crm/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../crm/plugins/bootstrap/js/bootstrap.js"></script>

    <script src="../crm/plugins/bootstrap-select/js/bootstrap-select.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../crm/plugins/node-waves/waves.js"></script>

    <!-- Validation Plugin Js -->
    <script src="../crm/plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Custom Js -->
    <script src="../crm/js/admin.js"></script>
    <script src="../crm/js/pages/examples/sign-in.js"></script>

    <!-- SweetAlert Plugin Js -->
    <script src="../crm/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="../crm/js/pages/ui/dialogs.js"></script>


   <script type="text/javascript">

      $(document).ready(function(){

         $('.btnReiniciar').click(function() {
            location.reload();
         });

         $('.btnEnviar').click(function() {

            if ($('#pregunta').val() == 3) {
               if ($('#observaciones').val() != '') {
                  traerImagen($('#pregunta').val(), $('#nombre').val(), $('#apellido').val(), $('#agencia').val(), $('#refproductos').val(), $('#observaciones').val());
               } else {
                  swal("Error!", 'Por favor completa las Observaciones', "warning");
               }
            } else {
               if (($('#nombre').val() != '') && ($('#apellido').val() != '') && ($('#observaciones').val() != '')) {
                  traerImagen($('#pregunta').val(), $('#nombre').val(), $('#apellido').val(), $('#agencia').val(), $('#refproductos').val(), $('#observaciones').val());
               } else {
                  swal("Error!", 'Por favor completa los campos Nombre, Apellido y Observaciones', "warning");
               }
            }


         });

         $('.contDatos1').hide();
         $('.contDatos2').hide();

         function traerImagen(pregunta, nombre, apellido, agencia, productos, observaciones) {
   			$.ajax({
   				data:  {
                  pregunta: pregunta,
                  nombre: nombre,
                  apellido: apellido,
                  agencia: agencia,
                  productos: productos,
                  observaciones: observaciones,
   					accion: 'insertarContactos'
               },
   				url:   '../crm/ajax/ajaxcontactos.php',
   				type:  'post',
   				beforeSend: function () {

   				},
   				success:  function (response) {
   					if (response.error) {
                     swal("Error!", 'Se genero un error al guardar los datos', "warning");
                  } else {
                     swal("Ok!", 'Se enviaron los datos correctamente', "success");
                     $('.contDatos1').hide();
                     $('.contDatos2').hide();
                     $('.respuestaSI').show();
                     $('.respuestaMI').show();
                     $('.respuestaNO').show();

                     $('#nombre').val('');
                     $('#apellido').val('');
                     $('#agencia').val('');
                     $('#refproductos').val('');
                     $('.show-tick').selectpicker('refresh');
                     $('#observaciones').val('');

                     $('#pregunta').val(0);
                  }
   				}
   			});
   		}


         $('.respuestaSI').click(function() {
            $('#pregunta').val(1);

            $('.contDatos1').show();
            $('.contDatos2').show();

            $('.respuestaMI').hide();
            $('.respuestaNO').hide();
         });

         $('.respuestaMI').click(function() {
            $('#pregunta').val(2);

            $('.contDatos1').show();
            $('.contDatos2').show();

            $('.respuestaSI').hide();
            $('.respuestaNO').hide();
         });

         $('.respuestaNO').click(function() {
            $('#pregunta').val(3);

            $('.contDatos2').show();

            $('.respuestaMI').hide();
            $('.respuestaSI').hide();
         });



      });/* fin del document ready */

   </script>
</body>

</html>
