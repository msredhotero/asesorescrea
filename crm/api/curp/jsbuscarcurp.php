<?php

include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/validadores.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$serviciosValidador = new serviciosValidador();

$fecha = date('Y-m-d');

$token = $_GET['callback'];
header("content-type: Access-Control-Allow-Origin: *");

$resV['error'] = false;

$arDatos = array();

if ((isset($_GET['curp']))) {
   $curp = $_GET['curp'];

   if (strlen($curp) == 18) {
      $validarER = $serviciosValidador->validarCurp($curp);

      if ($validarER) {
         //hasta aca esta todo ok

         $ch = curl_init();
         $url = 'https://crea.signaturainnovacionesjuridicas.com/api/consultas/renapo?curp='.$curp;
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         //set the content type to application/json
         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

         //return response instead of outputting
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

         //execute the POST request
         $result = curl_exec($ch);
         curl_close($ch);

         if (!is_string($result) || !strlen($result)) {
            $resV['error'] = true;
            $resV['mensaje'] = 'El CURP es incorrecto';

         } else {

            $arFirmaFiel = json_decode($result, true);

            if ($arFirmaFiel['apellidoPaterno'] == 'null') {
               $resV['error'] = true;
               $resV['mensaje'] = 'CURP no encontrado';
            } else {
               $apellidoPaterno  = $arFirmaFiel['apellidoPaterno'];
               $apellidoMaterno  = $arFirmaFiel['apellidoMaterno'];
               $nombres          = $arFirmaFiel['nombres'];
               $nombreCompleto   = $arFirmaFiel['nombreCompleto'];
               $sexo             = $arFirmaFiel['sexo'];
               $nacionalidad     = $arFirmaFiel['nacionalidad'];
               $fechaNacimiento  = $arFirmaFiel['fechaNacimiento'];
               $cveEntidadNac    = $arFirmaFiel['cveEntidadNac'];

               array_push($arDatos,
                  array(
                     'apellidoPaterno'=>$apellidoPaterno,
                     'apellidoMaterno'=>$apellidoMaterno,
                     'nombres'=>$nombres,
                     'nombreCompleto'=>$nombreCompleto,
                     'sexo'=>$sexo,
                     'nacionalidad'=>$nacionalidad,
                     'fechaNacimiento'=> ($fechaNacimiento == '' ? '0000-00-00' : date('Y-m-d', strtotime(str_replace('/', '-', $fechaNacimiento)))),
                     'cveEntidadNac'=>$cveEntidadNac,
                  )
               );

               $resV['datos'] = $arDatos;
            }

         }
      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'El formato del CURP es incorrecto';
      }
   } else {
      $resV['error'] = true;
      $resV['mensaje'] = 'El CURP debe contener 18 caracteres alfanumericos';
   }
} else {
	$resV['error'] = true;
   $resV['mensaje'] = 'Debe ingresar 18 caracteres';
}

header('Content-type: application/json');
echo json_encode($resV);


?>
