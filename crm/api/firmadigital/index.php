<?php

$folio = '123453';
$pin = '123453';
$usuario = 'marcos';
$url = 'https://qafirma.signaturainnovacionesjuridicas.com/api/firmasimple/crear';

$archivo = '../../reportes/F650AC.pdf';

$documento = hash_file('sha256', $archivo);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$data = array(
   'folio' => $folio,
   'pin' => $pin,
   'usuario' => $usuario,
   'sha256' => $documento,
);
//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//execute the POST request
$result = curl_exec($ch);

if ($result == false) {
   echo 'Error al procesar la solicitud al servidor Signatura';
} else {
   $result = trim($result,'"');

   echo '<p>Resultado: '.$result.'</p>';

   echo '<p>Documento Hashado: '.$documento.'</p>';

   echo '<h4>Se proceso</h4>';
}

curl_close($ch);


?>
