<?php

require 'vendor/autoload.php';



$email = new \SendGrid\Mail\Mail();

$email->setFrom("msredhotero@gmail.com", "Marcos S");
$email->setSubject("Sending with Twilio SendGrid is Fun");
$email->addTo("msredhotero@msn.com", "Marcos SS");
$email->addContent("text/plain", "and easy to do anywhere, even with PHP");


/*
$email->addContent(
    "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
);
*/


$apiKey = getenv('SENDGRID_API_KEY');
$sg = new \SendGrid($apiKey);

try {
    $response = $sg->client->suppression()->bounces()->get();
    echo '<pre>';
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
    echo '</pre>';
} catch (Exception $e) {
    echo 'Caught exception: '.  $e->getMessage(). "\n";
}




?>
