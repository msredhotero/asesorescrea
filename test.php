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

   <!-- Google Fonts -->
   <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
   <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

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

   <style>
      .jumbotron {
         padding-top: 18px;
         padding-bottom: 18px;
      }

      #barraprogreso {
         margin: 20px;
         width: 90%;
         height: 15px;
      }

   </style>



</head>

<body>
   <div class="jumbotron text-center">
      <a href="index.html"><img src="img/logo.png" title="Inicio" alt="ASESORES CREA" width="15%"></a>
      <p>Bienvenido al Proceso de Reclutamiento de Asesores - Complete el "TEST AFINIDAD CON LA VACANTE DE ASESOR FINANCIERO"</p>
   </div>

   <div class="container">
      <div class="row">
         <p>Esta vacante es lo que buscas y se adpata a tus expactativas económicas? Te pedimo nos regales un máximo de 5 minutos de tu tiempo, para constetar 6 simples preguntas y sabremos si nuestra oferta de trabajo es compatible con tus intereses. Esto también nos apoya para ofrecerte un plan de carrera personalizado.</p>
      </div>
      <div class="row">
         <button type="button" class="btn btn-success">COMENZAR TEST</button>
      </div>
      <div class="row">
         <div class="contenedorPreguntas">

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
</body>
</html>
