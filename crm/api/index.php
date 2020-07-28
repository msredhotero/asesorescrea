<?php

session_start();

// es alguien externo al sistema
$externo = 0;
if (!isset($_SESSION['usua_sahilices']))
{
   $externo = 1;

} else {
   $externo = 0;
}


?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>PRODUCTOS - ASESORES CREA</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="bootstrap-4.0.0/dist/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" style="background-color:#1b2646 !important; color:white !important;">
      <h5 class="my-0 mr-md-auto font-weight-normal"><img src="../imagenes/logo-blanco.png" width="220" alt="logo"></h5>

      <a class="btn btn-outline-primary" href="#">Sign in</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">¡Ya casi estás ahí! Completa tu pedido</h1>
      <p class="lead">Alguna leyenda escrita para que el que va a pagar entiende porque esta en este lugar.</p>
    </div>

    <div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Tarjeta VRIM</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$600 <small class="text-muted">/al año</small></h1>
            <h5>Red de descuentos TDConsentido y servicios dentales y visuales con tu tarjeta de descuentos</h5>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Consultas de especialidad hasta $450 pesos.</li>
              <li>Consultas telefónicas 24/7.</li>
              <li>Consultas a domicilio desde $450 pesos.</li>
              <li>Atención psicológica y nutricional telefónica 24/7.</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-outline-success" onclick="window.location='cart/'">COMPRAR</button>
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Tarjeta BLACK</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$800 <small class="text-muted">/al año</small></h1>
            <h5>¡Se incluyen todos los beneficios de la Tarjeta VRIM!</h5>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Seguro personal por muerte accidental de $200,000 pesos. Aplica de 12 a 70 años</li>
              <li>Reembolso de GMM por accidente hasta $20,000 pesos. Aplica de 0 a 70 años</li>
              <li>Seguro de pérdida de miembros escala “B” por accidente de $30,000 pesos.</li>
              <li>Reembolso de gastos funerarios en muerte accidental hasta $30,000.</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-success" onclick="window.location='cart/'">COMPRAR</button>
          </div>
        </div>
        <div class="card mb-4 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Tarjeta PLATINO</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">$1600 <small class="text-muted">/al año</small></h1>
            <h5>¡Se incluyen todos los beneficios de la Tarjeta VRIM y Tarjeta BLACK!</h5>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Seguro personal por muerte accidental de $500,000 pesos.</li>
              <li>Reembolso de GMM por accidente hasta $50,000 pesos.</li>
              <li>Seguro de pérdida de miembros escala “B” por accidente de $200,000 pesos.</li>
            </ul>
            <button type="button" class="btn btn-lg btn-block btn-success" onclick="window.location='cart/'">COMPRAR</button>
          </div>
        </div>
      </div>

      <footer class="pt-4 my-md-5 pt-md-5 border-top">
        <div class="row">
          <div class="col-12 col-md">
            <div style="font-weight:normal;font-style:normal">© CREA | Asesores en Banca y Seguros 2020</div>
          </div>

        </div>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="bootstrap-4.0.0/assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="bootstrap-4.0.0/assets/js/vendor/popper.min.js"></script>
    <script src="bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="bootstrap-4.0.0/assets/js/vendor/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
    <script>
    	$(document).ready(function(){


         function iniciarProceso(id) {
   			$.ajax({
   				url: '../ajax/ajax.php',
   				type: 'POST',
   				// Form data
   				//datos del formulario
   				data: {
                  accion: 'iniciarProceso',
                  comtotal: comtotal,
                  idusuario: id,
                  idusuario: id,
                  idusuario: id,
                  idusuario: id,
                  idusuario: id,
                  idusuario: id,
                  idusuario: id,
                  idusuario: id
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
   								timer: 1500,
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
      });
   </script>
  </body>
</html>
