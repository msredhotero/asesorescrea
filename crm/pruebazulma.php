
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Jekyll v3.8.6">
    <title>Fiananciera CREA</title>

  <!-- Bootstrap Core Css -->

    <link href="plugins/sweetalert/sweetalert.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">


  <!-- ALERTAS -->
  <meta name="theme-color" content="#563d7c">
  <style>

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }


        .jumbotron {
  padding-top: 3rem;
  padding-bottom: 3rem;
  margin-bottom: 0;
  background-color: #fff;
}
@media (min-width: 768px) {
  .jumbotron {
    padding-top: 6rem;
    padding-bottom: 6rem;
  }
}

.jumbotron p:last-child {
  margin-bottom: 0;
}

.jumbotron h1 {
  font-weight: 300;
}

.jumbotron .container {
  max-width: 40rem;
}

footer {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

footer p {
  margin-bottom: .25rem;
}
      }
    </style>

    <!-- Custom styles for this template -->
    <!--<link href="css/stylejj.css" rel="stylesheet">
   -->

  </head>
  <body class="bg-light">
    <header id="header">

    </header>
<div class="container bg-light d-none d-sm-block">
  <section class="w-100 justify-content-center p-3">
  <div class="row justify-content-center text-center">
        <img src='imagenes/arbolCreabgliht.png' class="rounded">
      </div>
</section>

</div>

  <section class="bg-light ">
    <div class="container col-12 col-sm-10 col-md-6  col-lg-4 col-xl-4 py-sm-2 ">
      <div class="card rounded shadow-sm ">

        <h2 class="text-center  text-muted pt-3 "><small> Registrar usuario</small></h2>
        <hr>
        <div class="body">
           <form id="register_form1" class="register_form1" method="POST">

           <div class="form-group px-2">
            <h6 id="usuarioHelp" class="form-text ">Nombre</h6>
            <div class="input-group flex-nowrap">
              <input type="text" id='nombre' name='nombre' value="" class="form-control" placeholder="Nombre completo" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
          </div>
          <div class="form-group px-2">
            <h6 id="usuarioHelp" class="form-text ">Usuario</h6>
            <div class="input-group flex-nowrap">
              <input type="email" id='usuario' name='usuario' value="" class="form-control" placeholder="Correo electrónico" aria-label="Username" aria-describedby="addon-wrapping">
            </div>
            <span class="text-info h5"><small>Asegurese de tener acceso al correo que nos proporciona</small></span>
          </div>

          <div class="form-group px-2">
            <h6 id="usuarioHelp" class="form-text ">Contraseña</h6>
            <div class="input-group flex-nowrap">
              <input type="password" id='clave' name='clave' value="" class="form-control" placeholder="Contraseña" aria-label="password" aria-describedby="addon-wrapping">
            </div>
            <div class="text-info h5"><small>Por lo menos 6 caracteres</small></div>
          </div>

          <div class="form-group px-2">
            <h6 id="usuarioHelp" class="form-text ">Repetir contraseña</h6>
            <div class="input-group flex-nowrap">
              <input type="password" id='clave2' name='clave2' value="" class="form-control" placeholder="Contraseña" aria-label="password" aria-describedby="addon-wrapping">
            </div>
            <div class="text-info h5"><small>Ingresa la misma contraseña</small></div>
          </div>

          <div class="form-group row">
            <div class="offset-sm-1 col-sm-10">
              <div class="form-check ">
                <input type="checkbox" class="form-check-input form-control-sm " id="terminosycondiciones" name="terminosycondiciones">
                 <label for="terminosycondiciones" class="h5 text-muted text-center"><small> Acepto expresament el <a href="#" class="alert-link" data-toggle="modal" data-target="#aviso_privacidad" >aviso de privacidad</a>  y los <a href="#" class="alert-link" data-toggle="modal" data-target="#terminos_condiciones" > términos y condiciones </a> de Financiera CREA</small></label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <input type="hidden" name="accion" id="accion" value="register" >
          </div>

           <!--<div class="form-group pt-3 d-flex justify-content-between">

             <span class="h5 text-muted text-center"><small>Para crear una cuenta debes aceptar el <a href="#" class="alert-link" data-toggle="modal" data-target="#aviso_privacidad" >aviso de privacidad</a>  y los <a href="#" class="alert-link" data-toggle="modal" data-target="#terminos_condiciones" > terminos y condiciones </a> de Financiera CREA </small></span>

           </div>-->




           </form>
           <div class="form-group d-flex justify-content-center">
            <button class="btn btn-primary float-none"  id="iniciarSesion">Crear cuenta</button>
           </div>
          <hr>

        </div>

      <div class="d-flex justify-content-center pt-2">
         <h6 class="text-muted d-block "> ¿Ya tienes un usuario?</h6>
      </div>
      <div class="d-flex justify-content-center pb-3">
        <a href="index.html" class="alert-link">Inicia sesión</a>
      </div>






    </div>
      </div>


    </div>
  </section>

<br><br>

<footer class="text-muted bg-white">
  <div class="container">
    <p class="float-right">
      <a href="#">Financieracrea.com</a>
    </p>
    <p>&copy; 2020 Financiera CREA</p>
  </div>
</footer>

<div id="carga_aviso_privacidad"></div>
<div id="carga_terminos_condiciones"></div>
<!--<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>-->

<!-- Jquery Core Js -->
<script src="plugins/jquery/jquery.min.js"></script>

<!--<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>-->
<!--Our bootstrap.bundle.js and bootstrap.bundle.min.js include Popper, but not jQuery.-->

<!-- SweetAlert Plugin Js -->
<script src="plugins/sweetalert/sweetalert.min.js"></script>



<script type="text/javascript">

  $(document).ready(function(){


     $('#iniciarSesion').click(function() {
        registrarUsuario();
     });

function registrarUsuario(){
     console.log("Entramos a la funcion apara inicar sesion");
     var formData = new FormData($(".register_form")[0]);
     var message = "";
    $.ajax({
       url:   'ajax/ajax.php',
       data: formData,
       type:  'post',
       processData: false,
       contentType: false,
        beforeSend: function () {
         $("#load").html('<img src="imagenes/load13.gif" width="50" height="50" />');
       },
       success:  function (response) {
         if (isNaN(response)) {
           swal({
             title: "Respuesta",
             text: "ERROR AL REGISTRAR AL USUARIO"+response,
             type: "error",
             timer: 5000,
             showConfirmButton: false
           });
         } else {
           swal({
             title: "Respuesta",
             text: "Usuario registrado",
             type: "success",
             timer: 3000,
             showConfirmButton: false
           });


           url = "registroExitoso.html";

         }
       }
     });
   }
});/* fin del document ready */


    </script>
</body>
</html>
