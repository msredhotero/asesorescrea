<?php


class ApiVrim {

    private $granttype;
    private $username;
    private $password;
    private $accesstoken;
    private $tokentype;
    private $expiresin;
    public $fechacrea;
    private $usuariocrea;
    public $reftabla;
    public $idreferencia;
    public $error;

    private $membresia;
    private $titular;
    private $correo;


    public function __construct($granttype, $username, $password,$usuariocrea) {
        $this->granttype   =    $granttype;
        $this->username    =    $username;
        $this->password    =    $password;
        $this->usuariocrea =    $usuariocrea;
        $this->fechacrea = new DateTime();
    }

    public function solicitudVrim($arCliente, $arPedidos, $token) {
        
        $params = array(
            'cveAsesor' => '28222',
            'tipoAsesor' => '1',
            'cveOficina' => '1220',
            'tipoOficina' => '2',
            'tipoSolicitud' => 12,
            'Cliente' => $arCliente,
            'Pedidos' => $arPedidos,
        );

        $cadenaCURL = json_encode($params);

        $cadenaFinalCURL = str_replace('}}}','}]}]}',str_replace('"Tarjetas":','"Tarjetas":[',str_replace(',"Pedidos":','],"Pedidos":[',str_replace('"Cliente":','"Cliente":[',$cadenaCURL))));


        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://www.salud-interactiva.com/apisolicitudVRIM/API/SOLICITUD",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => $cadenaFinalCURL,
        CURLOPT_HTTPHEADER => array(
            "Authorization: Bearer ".$token,
            "Content-Type: application/json",
            "cache-control: no-cache"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->setError($err);
        } else {

            $arToken = json_decode($response, true);

            //die(var_dump($arToken));

            $this->setError('');

            $this->setMembresia($arToken[0]['membresia']);
            $this->setTitular($arToken[0]['titular']);
            $this->setCorreo($arToken[0]['correo']);
        }
    }

    public function tokenVrim() {

        $curl = curl_init();

        $params = array(
            'grant_type' => $this->getGranttype(),
            'username' => $this->getUsername(),
            'password' => $this->getPassword()
        );

        //die(var_dump(json_encode($params)));

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.salud-interactiva.com/apisolicitudVRIM/API/TOKEN",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => array(
              "Content-Type: application/json",
              "cache-control: no-cache"
            ),
        ));
          
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            $this->setError($err);
        } else {

            $arToken = json_decode($response, true);

            $this->setError('');
            //die($arToken['access_token']);
            $this->setAccesstoken($arToken['access_token']);
            $this->setExpiresin($arToken['expires_in']);
            $this->setTokentype($arToken['token_type']);
        
        }
    }


    public function getTitular() { 
        return $this->titular; 
    } 

    public function setTitular($titular) {  
       $this->titular = $titular; 
    } 


    public function getCorreo() { 
        return $this->correo; 
    } 

    public function setCorreo($correo) {  
       $this->correo = $correo; 
    } 


    public function getMembresia() { 
        return $this->membresia; 
    } 

    public function setMembresia($membresia) {  
       $this->membresia = $membresia; 
    } 


    public function getGranttype() { 
        return $this->granttype; 
    } 

    public function setGranttype($granttype) {  
       $this->granttype = $granttype; 
    } 

    public function getUsername() { 
        return $this->username; 
    } 

    public function setUsername($username) {  
       $this->username = $username; 
    } 

    public function getPassword() { 
        return $this->password; 
    } 

    public function setPassword($password) {  
       $this->password = $password; 
    } 

    public function getAccesstoken() { 
        return $this->accesstoken; 
    } 

    public function setAccesstoken($accesstoken) {  
       $this->accesstoken = $accesstoken; 
    } 

    public function getTokentype() { 
        return $this->tokentype; 
    } 

    public function setTokentype($tokentype) {  
       $this->tokentype = $tokentype; 
    } 

    public function getExpiresin() { 
        return $this->expiresin; 
    } 

    public function setExpiresin($expiresin) {  
       $this->expiresin = $expiresin; 
    } 

    public function getFechacrea() { 
        return $this->fechacrea; 
    } 

    public function setFechacrea($fechacrea) {  
       $this->fechacrea = $fechacrea; 
    } 

    public function getUsuariocrea() { 
        return $this->usuariocrea; 
    } 

    public function setUsuariocrea($usuariocrea) {  
       $this->usuariocrea = $usuariocrea; 
    } 

    public function getReftabla() { 
        return $this->reftabla; 
    } 

    public function setReftabla($reftabla) {  
       $this->reftabla = $reftabla; 
    } 

    public function getIdreferencia() { 
        return $this->idreferencia; 
    } 

    public function setIdreferencia($idreferencia) {  
       $this->idreferencia = $idreferencia; 
    } 


    public function getError() { 
        return $this->error; 
    } 

    function setError($error) {  
       $this->error = $error; 
    } 


}



	

	

	
?>