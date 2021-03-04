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

//if ((isset($_GET['tipopersona'])) && ($_GET['tipopersona'] != '') && (($_GET['tipopersona'] == 1) || ($_GET['tipopersona'] == 2))) {

   if ((isset($_GET['rfc']))) {
      $rfc = $_GET['rfc'];

      if ((strlen($rfc) == 13) || (strlen($rfc) == 12)) {
         $validarER = $serviciosValidador->validarRFC($rfc);

         if ($validarER) {
            //hasta aca esta todo ok

            $ch = curl_init();
            $url = 'https://crea.signaturainnovacionesjuridicas.com/api/consultas/sat?rfc='.$rfc;
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
               $resV['mensaje'] = 'El RFC es incorrecto';

            } else {

               $arFirmaFiel = json_decode($result, true);

               //die(var_dump($arFirmaFiel));

               $apellidoPaterno  = $arFirmaFiel['apellidoPaterno'];
               $apellidoMaterno  = $arFirmaFiel['apellidoMaterno'];
               $nombres          = $arFirmaFiel['nombres'];
               $nombreCompleto   = $arFirmaFiel['nombreCompleto'];
               $sexo             = $arFirmaFiel['sexo'];
               $nacionalidad     = $arFirmaFiel['nacionalidad'];
               $fechaNacimiento  = $arFirmaFiel['fechaNacimiento'];
               $cveEntidadNac    = $arFirmaFiel['cveEntidadNac'];
               $domicilio        = $arFirmaFiel['domicilio'];
               $desTelefono      = $arFirmaFiel['desTelefono'];
               $curp             = $arFirmaFiel['curp'];
               $correoElectronico= $arFirmaFiel['correoElectronico'];
               $numeroInterior   = $arFirmaFiel['numeroInterior'];
               $numeroExterior   = $arFirmaFiel['numeroExterior'];
               $municipio        = $arFirmaFiel['municipio'];
               $entidadFederativa= $arFirmaFiel['entidadFederativa'];
               $colonia          = $arFirmaFiel['colonia'];
               $codigoPostal     = $arFirmaFiel['codigoPostal'];
               $calle            = $arFirmaFiel['calle'];

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
         } else {
            $resV['error'] = true;
            $resV['mensaje'] = 'El formato del RFC es incorrecto';
         }
      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'El RFC debe contener 12 o 13 caracteres alfanumericos';
      }
   } else {
   	$resV['error'] = true;
      $resV['mensaje'] = 'Debe ingresar 13 caracteres';
   }

   /*
} else {

}
*/

header('Content-type: application/json');
echo json_encode($resV);


?>
