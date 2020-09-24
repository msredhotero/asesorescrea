<?php
date_default_timezone_set('America/Mexico_City');
#include ('../../class_include.php');
class FirmaDigitalSimpleSignatura{
	protected $contratoGlogalId = '';
	protected $numeroDisposicion = '';
	protected $solicitud_id = '';
	protected $cadenaDocto = '';
	protected $tokenId = '';
	protected $token = '';
	protected $curp = '';
	protected $usr = '';
	protected $error = '';
	protected $respuesta = '';
	private $url = '';

	public function __construct($idContratoGlobal,  $tokenId, $token , $numeroDisposicion = 0, $usuario){
		$this->contratoGlogalId = $idContratoGlobal;
		#echo "Entra a firma digital signatura valores =>".$idContratoGlobal."-". $tokenId."-" .$token ."-". $numeroDisposicion."-".$usuario;
		$this->url = 'https://qafirma.signaturainnovacionesjuridicas.com/api/firmasimple/crear';
		$this->tokenId = $tokenId;
		$this->token = $token;
		$this->numeroDisposicion = $numeroDisposicion;
		$this->usr = $usuario;




	}
	public function getUrl(){
		return $this->url;
	}

	public function getContratoGlogalId(){
		return $this->contratoGlogalId;
	}

	public function getNumeroDisposicion(){
		return $this->numeroDisposicion;
	}

	public function getSolicitud_id(){
		return $this->solicitud_id;
	}
	public function getCadenaDocto(){
		return $this->cadenaDocto;
	}
	public function getTokenId(){
		return $this->tokenId;
	}

	public function getToken(){
		return $this->token;
	}
	public function getCurp(){
		return $this->curp;
	}
	public function getUsr(){
		return $this->usr;
	}
	public function getRespuesta(){
		return $this->respuesta;
	}

	public function setCadenaDocto($sha256){
		return $this->cadenaDocto = $sha256;
	}



	public function firmaContrato(){
		$query = new Query();
		$aMsg =  array();
		$aMsg['error'] = '0';
		$aMsg['firmaSignaturaCorrecta'] = 0;
		$errorEnTrasaccion = 0;
		$this->sha265Contrato();
		$ch = curl_init();
        $url = $this->getUrl();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = array(
            'folio' => $this->getTokenId(),
            'pin' => $this->getToken(),
            'usuario' => $this->getUsr(),
            'sha256' => $this->getCadenaDocto(),
        );
        //attach encoded JSON string to the POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
         //set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        //return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute the POST request
        $result = curl_exec($ch);
        if($result == false){
        	$aMsg['error'] = '1';
			$aMsg['error_desc'] = 'Error al procesar la solicitud al servidor Signatura';
			$aMsg['error_desc_cliente'] = 'Por el momento no esta posible firmar el contrato, por favor intente mas tarde';
			$sqlInsertErrorFirma =  "INSERT INTO `dbtokenserroresfirmas`";
			$sqlInsertErrorFirma .= " (`idtokenerrorfirma`, `reftoken`, `refusuario`, `error`, `fecha`) VALUES";
			$sqlInsertErrorFirma .= "  (NULL, '".$this->getTokenId()."', '".$this->getUsr()."', '1', CURRENT_TIMESTAMP);";
			$query->setQuery($sqlInsertErrorFirma);
			$resI = $query->eject();
			if(!$resI){
				$errorEnTrasaccion = 1;
				$aMsg['error_db'] = '1';
				$aMsg['error_db_desc'] = $sqlInsertErrorFirma;
				$aMsg['error_desc_cliente'] = 'Error al insertar en registro errores';
			}

        }else{
        	// la conexion con signatura fue OK, se debe registrar el xml de respuesta en la base de datos
        	$result = trim($result,'"');

        	$sqlUpdateFirma =  "UPDATE  dbtokens SET sha256docto =  '".$this->getCadenaDocto()."',
        	 constanciaxml ='".$result."', fechasignatura = CURRENT_TIMESTAMP WHERE idtoken =".$this->getTokenId();
        	 $query->setQuery($sqlUpdateFirma);
        	 $rstUp = $query->eject();
        	 if(!$rstUp){
				$errorEnTrasaccion = 1;
				$aMsg['error_db'] = '1';
				$aMsg['error_db_desc'] = $sqlUpdateFirma;
				$aMsg['error_desc_cliente'] = 'Error al actualizar registro del NIP';
			}else{
				$aMsg['firmaSignaturaCorrecta'] = 1;
			}
        }
        curl_close($ch);
        return $aMsg;
	}

	public function sha265Contrato(){
		$sha256Documento = '';
		$query =  new Query();
		$swhere = '';
		$idContrato = $this->contratoGlogalId;
		if($this->numeroDisposicion > 0){
				$swhere = ' AND refdisposicion = '.$this->numeroDisposicion;
		}
		$sqlExpediente =  "SELECT * FROM dbcontratosglobalesexpedientes WHERE refcontratoglobal = ".$idContrato.$swhere;
		$query->setQuery($sqlExpediente);
		$resultExp = $query->eject();
		$objExpediente =  $query->fetchObject($resultExp);
		$ruta = $objExpediente->ruta;
		$documento = $objExpediente->documento;
 		// se ejecuta desde el archivo ajax.php
		$archivo = "../".$ruta."/".$documento;
		$sha256Documento =  hash_file('sha256', $archivo);		
		$this->setCadenaDocto($sha256Documento);
	}




}


?>
