<?php
date_default_timezone_set('America/Mexico_City');
include_once('PHPMailer.php');
include_once('SMTP.php');
class EnvioSMS{
	private $destinatario = 'sms@financieracrea.com'; // cuenta configurada en el telular 
	private $remitente = 'smsasesores@financieracrea.com'; // es una de las direcciones permitidas en la configuracion del telular

	static function enviarSMS($telefono, $mensaje = NULL){
		
		$envioCorrecto  = 1;
		$phpMailer = new PHPMailer();
		if(!empty($telefono) && !empty($mensaje)){			
			$arrayCAracteres = array("-","_",".",","," ");		 	
			$telefono= str_replace ( $arrayCAracteres , '' , $telefono );
			$server = $_SERVER['SERVER_NAME'];

			if(strlen($telefono) ==10 ){		
				$to = "sms@financieracrea.com";
				$header = "From:smsasesores@financieracrea.com";
				$subject = $telefono;	

				if($server=='localhost'){
					$subject = '5573634064';
				}
	 
			    

			    try {
					$phpMailer->IsSMTP();
					#$phpMailer->SMTPDebug = 2;
					$phpMailer->SMTPAuth = true;
					#$phpMailer->SMTPSecure = "ssl";
					//indico el servidor de hostinger para SMTP
					$phpMailer->Host = 'smtp.hostinger.mx';
					//indico el puerto que usa hostinger
					$phpMailer->Port = '587';
					//indico un usuario / clave de un usuario de gmail
					$phpMailer->Username = 'smsasesores@financieracrea.com';
					$phpMailer->Password = 'Enviosmsasesorescrea2021';
					$phpMailer->setFrom('smsasesores@financieracrea.com', 'Asesores CREA'); # Correo y nombre del remitente			
				
					$phpMailer->addAddress($to); # El destinatario
				
					$phpMailer->Subject =$subject; # Asunto, numero celular
					$phpMailer->Body =  $mensaje; # Cuerpo en texto plano
					$phpMailer->isHTML(false);
					
					if (!$phpMailer->send()) {
						echo "Error enviando correo: " . $phpMailer->ErrorInfo;
					}else{
						// registramos datos	

						#$query = new Query();
						$listaCampos = NULL;	
					
						$listaCampos['esreenvio'] = 0;
						#$query->insert('dbemailsenviados',$listaCampos);

						#$rs3 = $query->eject();					
					}

				} catch (Exception $e) {
					echo "<h1>Excepción: </h1> " . $e->getMessage();
					$error = 1;	
					$envioCorrecto = 0;
					
				}
			}// telefono 10
		}// telefono y mensaje
		return $envioCorrecto;
	}


	public function limpiarTelfono($telefono){
		$arrayCAracteres = array("-","_",".",","," ");
		 str_replace ( $arrayCAracteres , '' , $telefono );
	}

}
$celularCliente = '5573634064';
$msg = 'prueba proceso envio sms '.date("Y-m-d"). " ".date("G:i:s");
$x_envio = EnvioSMS::enviarSMS($celularCliente,$msg);

echo  $x_envio;


?>