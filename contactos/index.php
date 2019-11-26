<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Acceder | ASESORES CREA</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

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

    <!-- Custom Css -->
    <link href="../crm/css/style.css" rel="stylesheet">
</head>

<body class="login-page" style="max-width: 66% !important;">
   <div class="row clearfix">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card ">
               <div class="header bg-blue">
                  <h2>
                     BIENVENIDOS A ASESORES CREA
                  </h2>

               </div>
               <div class="body table-responsive">

                  <div class="row" align="center" style="margin-bottom: 20px;">
                     <h2 style="color: #1b2646;">¿Usted está interesadoen el Proyecto?</h2>
                  </div>
                  <div class="row" align="center">
                     <button type="submit" class="btn bg-green btn-lg waves-effect respuestaSI animated bounceIn" style="font-size:18px !important;">
                        <i class="material-icons">thumb_up</i>
                        <span>Si</span>
                     </button>
                     <button type="submit" class="btn bg-red btn-lg waves-effect respuestaNO animated bounceInRight" style="font-size:18px !important;">
                        <i class="material-icons">thumb_down</i>
                        <span>No</span>
                     </button>
                     <button type="submit" class="btn bg-light-blue btn-lg waves-effect respuestaMI animated bounceInRight" style="font-size:18px !important;">
                        <i class="material-icons">touch_app</i>
                        <span>Me gustaría recibir más información</span>
                     </button>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> <!-- fin del container entrevistas -->

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


    <script type="text/javascript">

        $(document).ready(function(){


            $('body').keyup(function(e) {
                if(e.keyCode == 13) {
                    $("#login").click();
                }
            });


            $("#sign_in").submit(function(e){

                e.preventDefault();
                if ($('#sign_in')[0].checkValidity()) {

                   $.ajax({
                       data:  {email:		$("#email").val(),
                               pass:		$("#pass").val(),
                               accion:		'login'},
                       url:   'ajax/ajax.php',
                       type:  'post',
                       beforeSend: function () {
                               $("#load").html('<img src="imagenes/load13.gif" width="50" height="50" />');
                       },
                       success:  function (response) {

                               if (isNaN(response)) {

                                   swal({
                                       title: "Respuesta",
                                       text: "Usuario o Password Incorrectos",
                                       type: "error",
                                       timer: 2000,
                                       showConfirmButton: false
                                   });

                               } else {
                                   swal({
                                       title: "Respuesta",
                                       text: "Acceso Correcto",
                                       type: "success",
                                       timer: 1500,
                                       showConfirmButton: false
                                   });

                                   url = "dashboard/";
                                   $(location).attr('href',url);
                               }

                       }
                   });
                }


            });

        });/* fin del document ready */

    </script>
</body>

</html>
