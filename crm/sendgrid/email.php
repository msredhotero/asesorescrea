<?php

require 'vendor/autoload.php';



$email = new \SendGrid\Mail\Mail();

$email->setFrom("consulta@asesorescrea.com", "Marcos Asesores Crea");
$email->setSubject("Envio de correo con SendGrid");
$email->addTo("msredhotero@msn.com", "Marcos SS");
$email->addContent("text/plain", "es facil e enviar pero tengo que ver que no caigan en el spam");

$email->addContent(
    "text/html", "<strong>Hola Javier</strong>"
);



//$sendgrid = new \SendGrid(getenv('SENDGRID_API_KEY'));
//$sendgrid = getenv('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');
$sendgrid = new \SendGrid('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');
//$sg = new \SendGrid($apiKey);

try {
    $response = $sendgrid->send($email);
    echo '<pre>';
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
    echo '</pre>';
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}




?>
