<?php

$EM_Response= '';
$comtotal= $_POST["total"];
$comorder_id= $_POST["order_id"];
$commerchant= $_POST["merchant"];
$comstore= $_POST["store"];
$comterm= $_POST["term"];
$EM_RefNum= '';
$EM_Auth= '';
$comdigest= $_POST["digest"];

$comcurrency = '484';
$comaddress = '';


?>
<!doctype html>
<html lang="en">

<head>
   <TITLE>ASESORES CREA</TITLE>
   <META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=ISO-8859-1">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="icon" href="https://asesorescrea.com/desarrollo/crm/favicon.ico">

   <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
   <link rel="stylesheet" type="text/css" href="assets/css/styles.css">
   <link rel="stylesheet" type="text/css" href="assets/css/demo.css">

   <!-- Waves Effect Css -->
   <link href="https://asesorescrea.com/desarrollo/crm/plugins/node-waves/waves.css" rel="stylesheet" />

   <!-- Animation Css -->
   <link href="https://asesorescrea.com/desarrollo/crm/plugins/animate-css/animate.css" rel="stylesheet" />

   <!-- Sweetalert Css -->
   <link href="https://asesorescrea.com/desarrollo/crm/plugins/sweetalert/sweetalert.css" rel="stylesheet" />
</head>

<body>

   <div class="container-fluid">
        <header>
            <div class="limiter">

                <img src="../../imagenes/logo-blanco.png" width="220" alt="logo">
            </div>
        </header>
        <div class="creditCardForm">
            <form METHOD="POST" AUTOCOMPLETE="OFF" ACTION="comercio_con.php" id="formPago">
            <div class="heading">
                <h1>Confirme el Pago</h1>
            </div>
            <div class="row" align="center">
               <img class="imagenCard" src="../../imagenes/numbercard_1.png" width="300" />
            </div>
            <div class="payment">

                  <div class="form-group owner">
                     <label for="owner">Nombre que aparece en la Tarjeta</label>
                     <input type="text" class="form-control" id="owner" name="cc_name" MAXLENGTH="30">
                  </div>
                  <div class="form-group" id="card-number-field">
                     <label for="cardNumber">Número de Tarjeta</label>
                     <input type="text" class="form-control" id="cardNumber" name="cc_number" MAXLENGTH="19">
                  </div>


                    <div class="form-group" id="expiration-date">
                        <label>Fecha de Vencimiento</label>
                        <select name="_cc_expmonth" class="mesCard">
                            <option value="01">Enero</option>
                            <option value="02">Febrero</option>
                            <option value="03">Marzo</option>
                            <option value="04">Abril</option>
                            <option value="05">Mayo</option>
                            <option value="06">Junio</option>
                            <option value="07">Julio</option>
                            <option value="08">Agosto</option>
                            <option value="09">Septiembrer</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
                        <select name="_cc_expyear" class="anioCard">
                            <option value="20"> 2020</option>
                            <option value="21"> 2021</option>
                            <option value="22"> 2022</option>
                            <option value="23"> 2023</option>
                            <option value="24"> 2024</option>
                            <option value="25"> 2025</option>
                        </select>
                    </div>
                    <div class="form-group" id="credit_typecards" style="display:block;">
                       <label>Tipo de Tarjeta</label>
                       <select name="cc_type" id="tipotarjeta">
                          <!-- Modificacion: Marca de inicio C-04-2761-10 Acriter NAC -->
                           <option VALUE="Visa">VISA</option>
                           <option VALUE="Mastercard">MasterCard</option>
                           <!-- Modificacion: Marca de inicio C-04-2761-10 Acriter NAC -->
                       </select>
                    </div>

                    <div class="form-group CVV">
                       <label for="cvv">CVC</label>
                       <input type="text" class="form-control" id="cvv" name="cc_cvv2" MAXLENGTH="3">
                    </div>

                    <div class="form-group" id="pay-now">
                        <button type="submit" class="btn btn-default" id="confirm-purchase">Pagar</button>
                    </div>

            </div>
            <input type="hidden" name="total" value="<?php echo $comtotal; ?>">
            <input type="hidden" name="currency" value="<?php echo $comcurrency; ?>">
            <input type="hidden" name="address" value="<?php echo $comaddress; ?>">
            <input type="hidden" name="order_id" value="<?php echo $comorder_id; ?>">
            <input type="hidden" name="merchant" value="<?php echo $commerchant; ?>">
            <input type="hidden" name="store" value="<?php echo $comstore; ?>">
            <input type="hidden" name="term" value="<?php echo $comterm; ?>">
            <input type="hidden" name="digest" value="<?php echo $comdigest; ?>">
            <input type="hidden" name="return_target" value="">
            <input type="hidden" name="urlBack" value="comercio_con.php">
            </form>
        </div>


    </div>

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.2/sweetalert.min.js" integrity="sha512-bQTg0yQoJONPPP2GJpVEWYayw5y7LmCrN+VMCr3l3jl1mn8a2yjYLDBkvt4TkQCJjLaI3kprfiJ2ivEUOw63ow==" crossorigin="anonymous"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

   <script>
   $(function() {
      var mesCard = $('.mesCard');
      var anioCard = $('.anioCard');
       var owner = $('#owner');
       var cardNumber = $('#cardNumber');
       var cardNumberField = $('#card-number-field');
       var CVV = $("#cvv");
       var mastercard = $("#mastercard");
       var confirmButton = $('#confirm-purchase');
       var visa = $("#visa");

       owner.focus();

      owner.focusin(function() {
         $('.imagenCard').attr('src', '../../imagenes/namecard.png');
      });

      cardNumber.focusin(function() {
         $('.imagenCard').attr('src', '../../imagenes/numbercard_1.png');
      });

      mesCard.focusin(function() {
         $('.imagenCard').attr('src', '../../imagenes/validthrucard.png');
      });
      anioCard.focusin(function() {
         $('.imagenCard').attr('src', '../../imagenes/validthrucard.png');
      });

      CVV.focusin(function() {
         $('.imagenCard').attr('src', '../../imagenes/cvccard2.png');
      });


      owner.focusout(function() {
         $('.imagenCard').attr('src', '../../imagenes/cardonly.png');
      });

      cardNumber.focusout(function() {
         $('.imagenCard').attr('src', '../../imagenes/cardonly.png');
      });

      mesCard.focusout(function() {
         $('.imagenCard').attr('src', '../../imagenes/cardonly.png');
      });
      anioCard.focusout(function() {
         $('.imagenCard').attr('src', '../../imagenes/cardonly.png');
      });

      CVV.focusout(function() {
         $('.imagenCard').attr('src', '../../imagenes/cardonly.png');
      });





       confirmButton.click(function(e) {

           e.preventDefault();

           if(owner.val().length < 5){
              swal({
                  title: "Error!!",
                  text: "Complete Nombre que aparece en la Tarjeta",
                  type: "error",
                  timer: 2000,
                  showConfirmButton: false
              });
           } else if (cardNumber.val().length < 14) {
              swal({
                  title: "Error!!",
                  text: "Número de tarjeta invalido",
                  type: "error",
                  timer: 2000,
                  showConfirmButton: false
              });
           } else if (CVV.val().length < 3) {
              swal({
                  title: "Error!!",
                  text: "Complete el CVV",
                  type: "error",
                  timer: 2000,
                  showConfirmButton: false
              });
           } else {
               // Everything is correct. Add your form submission code here.
               swal({
                  title: "Respuesta",
                  text: "Datos Correctos, vamos a procesar su pago",
                  type: "success",
                  timer: 1500,
                  showConfirmButton: false
               });
               $( "#formPago" ).submit();
           }
       });
   });
   </script>


<!-- Modificacion: Marca de inicio Acriter NAC C-04-2761-10 Fase2 -->

<!-- Modificacion: Marca de fin Acriter NAC C-04-2761-10 Fase2 -->

</body>
</html>
