<?php
date_default_timezone_set('America/Mexico_City');
class EnvioSMS{
	private $destinatario = 'sms@financieracrea.com'; // cuenta configurada en el telular 
	private $remitente = 'smsasesores@financieracrea.com'; // es una de las direcciones permitidas en la configuracion del telular

	static function enviarSMS($telefono, $mensaje = NULL){
		

		if(!empty($telefono) && !empty($mensaje)){
			
			$envioCorrecto  = 1;
			$arrayCAracteres = array("-","_",".",","," ");		 	
			$telefono= str_replace ( $arrayCAracteres , '' , $telefono );
			$server = $_SERVER['SERVER_NAME'];

			if(strlen($telefono) ==10 && $telefono){		
				$to = "sms@financieracrea.com";
				$header = "From:smsasesores@financieracrea.com";
				$subject = $telefono;	

				if($server=='localhost')	{
					$subject = '5573634064';
				}
	 
			    if(!mail($to, $subject, $mensaje, $header)){			
			    	$envioCorrecto = 0;
			    }
			}
		}
		return $envioCorrecto;	


	}

	public function limpiarTelfono($telefono){
		$arrayCAracteres = array("-","_",".",","," ");
		 str_replace ( $arrayCAracteres , '' , $telefono );
	}

}


?>