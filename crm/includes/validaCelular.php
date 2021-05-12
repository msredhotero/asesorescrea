<?php

include('../includes/class/EnvioSMS.class.php');
include('../class_include.php');
$arraRespuesta =array();

#print_r($_POST);selectCampo
$celularCliente = $_POST["celular"];
$refusuario = $_POST["duid"];

$tipoToken =  "8";
$token = '84545515';
$ran = rand (1, 99999);
$token = $tipoToken.$ran;

if(strlen($token)<6){
	$x_lon = strlen($token);
	for($i=$x_lon;$i<6;$i++){
		$token = $token."0";
	}
}

$query = new Query();
$celularValidado = $query->selectCampo('celularValidado','dbusuariosdatos','refusuario='.$refusuario);
$intentoValidacion = $query->selectCampo('intento','dbusuariosdatos','refusuario='.$refusuario);

if(!empty($celularCliente)){
	if($celularValidado != 1 and $intentoValidacion <= 2){
		$msg = ' NIP: '.$token ." Ingresa este numero para validar tu validar tu celular";
		$x_envio = EnvioSMS::enviarSMS($celularCliente,$msg );
		 if($x_envio){
		 	$arraRespuesta["status"]= 1;
		 	$arraRespuesta["mensaje"]= "Te enviamos un NIP a tu celular";
		 	//$arraRespuesta["token"] = $token; 	
		 	$sql = "UPDATE dbusuariosdatos SET token = $token, celular = $celularCliente, intento = (COALESCE(`intento`, 0)+1) WHERE  refusuario =  $refusuario";
		 	$query->setQuery($sql);
		 	$query->eject();

		 }else{
		 	$arraRespuesta["status"]= 0;
		 }
		 
	}else{

		//$arraRespuesta["token"] = $token; 
		$email = $query->selectCampo('usuario','usuario','usuario_id='.$refusuario);	
		$sql = "UPDATE dbusuariosdatos SET token = $token, intento = (COALESCE(`intento`, 0)+1) WHERE  refusuario =  $refusuario";
		$query->setQuery($sql);
		$query->eject();

		#$cuerpo = ' NIP: '.$token ." Ingresa este número en la pantalla";

		$cuerpo .= '<h2 class=\"p3\">NIP para activacion</h2>';
	   	$cuerpo .= '<h3><small><p>Por favor ingresa el siguiente NIP: '.$token.'  para activar tu cuenta.</p></small></h3>';
		$cuerpo .= '<br><img width="393" height="131"  src="http://financieracrea.com/esfdesarrollo/images/firmaCREA24.jpg" alt="Financiera CREA" >';
		$mail = new MailerFinancieraCrea();
		$mail->sendEmail(27, $email,  $cuerpo);



		$arraRespuesta["status"]= 2;
		$arraRespuesta["mensaje"]= "Te enviamos un NIP a tu correo electrónico";
	}
}else{
	$arraRespuesta["status"]= 0;
	$arraRespuesta["error"]= " Requerido el número de celular";

}

echo json_encode($arraRespuesta);
?>