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
$serviciosSeguridad->seguridadRuta($_SESSION['refroll_sahilices'], '../ecommerce/');
//*** FIN  ****/

$fecha = date('Y-m-d');

$comtotal = 0;
$comcurrency = '484';
$comaddress = '';
$comorder_id = 165189;
$commerchant = '123165';
$comstore = '0123';
$comterm = '123';

$comdigest=sha1($commerchant.$comstore.$comterm.$comtotal.$comcurrency.$comorder_id);

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>PAGOS - ASESORES CREA</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">

    <!-- Bootstrap core CSS -->
    <link href="../bootstrap-4.0.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../bootstrap-4.0.0/dist/css/pricing.css" rel="stylesheet">
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow" style="background-color:#1b2646 !important; color:white !important;">
      <h5 class="my-0 mr-md-auto font-weight-normal"><img src="../../imagenes/logo-blanco.png" width="220" alt="logo"></h5>

      <a class="btn btn-outline-primary" href="#">Sign in</a>
    </div>

    <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
      <h1 class="display-4">¡Ya casi estás ahí! Completa tu pedido</h1>
      <p class="lead">Alguna leyenda escrita para que el que va a pagar entiende porque esta en este lugar.</p>
    </div>

    <div class="container">
      <div class="card-deck mb-3 text-center">
        <div class="card mb-12 box-shadow">
          <div class="card-header">
            <h4 class="my-0 font-weight-normal">Resumen del Pedido: VRIM Tarjeta PLATINO</h4>
          </div>
          <div class="card-body">
            <h1 class="card-title pricing-card-title">MX$1600.00</h1>
            <ul class="list-unstyled mt-3 mb-4">
              <li>Seguro personal por muerte accidental de $500,000 pesos. (Aplica de 12 a 70 años)</li>
              <li>Reembolso de GMM por accidente hasta $50,000 pesos. (Aplica de 0 a 70 años)</li>
              <li>Seguro de pérdida de miembros escala “B” por accidente de $200,000 pesos. (Aplica de 0 a 70 años)</li>
            </ul>
            <hr>
            <p><small>Al realizar la compra, aceptas nuestros Terminos de uso. Procesaremos sus datos personales para el cumplimiento de su pedido y otros fines según nuestra Política de privacidad. Al concretar tu compra estarás aceptando nuestros Términos de servicio y Política de privacidad.</small></p>
            <ul class="d-flex flex-column flex-md-row">
               <li class="list-inline-item"><img src="../../imagenes/visa.png" width="90" height="63"></li>
               <li class="list-inline-item"><img src="../../imagenes/mastercard.png" width="90" height="63"></li>
               <li class="list-inline-item"><img src="../../imagenes/Carnet.png" width="90" height="63"></li>
            </ul>
            <form action="../pay/xxxxxx_comercio.php" method="post" id="formFin">
               <input type="hidden" name="total" value="<?php echo $comtotal; ?>">
               <input type="hidden" name="currency" value="<?php echo $comcurrency; ?>">
               <input type="hidden" name="address" value="<?php echo $comaddress; ?>">
               <input type="hidden" name="order_id" value="<?php echo $comorder_id; ?>">
               <input type="hidden" name="merchant" value="<?php echo $commerchant; ?>">
               <input type="hidden" name="store" value="<?php echo $comstore; ?>">
               <input type="hidden" name="term" value="<?php echo $comterm; ?>">
               <input type="hidden" name="digest" value="<?php echo $comdigest; ?>">
               <input type="hidden" name="return_target" value="">
               <input type="hidden" name="urlBack" value="../pay/comercio_con.php">
               <button type="button" class="btn btn-lg btn-block btn-success">Adquirir AHORA</button>
            </form>
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
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="../bootstrap-4.0.0/assets/js/vendor/popper.min.js"></script>
    <script src="../bootstrap-4.0.0/dist/js/bootstrap.min.js"></script>
    <script src="../bootstrap-4.0.0/assets/js/vendor/holder.min.js"></script>
    <script>
      Holder.addTheme('thumb', {
        bg: '#55595c',
        fg: '#eceeef',
        text: 'Thumbnail'
      });
    </script>
  </body>
</html>

<?php } ?>
