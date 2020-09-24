<?php
date_default_timezone_set('America/Mexico_City');
class Token
{

	private $idtoken = '';
	private $refcontratoglobal = '';
	private $reftipo = '';
	private $token = '';
	private $fecha = '';
	private $hora = '';
	private $refstatustoken ='';
	private $tipoToken = '';
	private $arrayTablas = array();
	private $arrayIdTablas = array();



	

	public function __construct($tokenId=NULL){
		$query = new Query();
	
 		if(!empty($tokenId)){
 			$sqlToken = "SELECT *					   
	               FROM
	                   dbtokens 	                      
	               WHERE
	                   idtoken = ".$tokenId;	                   
			$query->setQuery($sqlToken);
			$rs = $query->eject();
			$objToken = $query->fetchObject($rs);
			$this->idtoken = $objToken->idtoken;
			$this->refcontratoglobal = $objToken->refcontratoglobal;
			$this->reftipo = $objToken->reftipo;
			$this->token = $objToken->token;
			$this->fecha = $objToken->fecha;
			$this->hora = $objToken->hora;
			$this->refstatustoken = $objToken->refstatustoken;
 		}

 		

 		$this->arrayTablas = array(1=>'dbsolicitudesautorizacioncirculocredito', 
								 2=>'dbfirmascontratosglobales',
								 3=>'',
								 4=>'dbfirmasdisposiciones',
								 5=>'',
								 6=>'',);
		$this->arrayIdTablas = array(1=>'idsolicitudautorizacioncirculocredito', 
								 2=>'idfirmacontratoglobal',
								 3=>'',
								 4=>'idfirmadisposicion',
								 5=>'',
								 6=>'',);

	}

	private function setTokenId($idToken){		
		$this->tokenId = $idToken;
	}

	public function getTokenId(){

		return $this->tokenId;		
	}

	private function setContratoGlobal($idCG){
		$this->refcontratoglobal = $idCG;
	}

	public function getContratoGlobal(){
		return $this->refcontratoglobal;		
	}

	private function setRefTipo($reftipo){
		$this->reftipo = $reftipo;
	}

	public function getRefTipo(){
		return $this->reftipo;		
	}

	private function setToken($token){
		$this->token = $token;
	}

	public function getToken(){
		return $this->token;		
	}

	public	function generarToken($idContratoGlobal, $idTipoToken){
		$query = new Query();
		$random = rand (10000, 99999);
		$token = $idTipoToken.$random;
		$vigenciaToken = '';

		// status token = 1 ; Activo
		$insertToken = "INSERT INTO `dbtokens`
		 (`idtoken`, `refcontratoglobal`, `reftipo`, `token`, `fecha`, `hora`, `refstatustoken` , `vigenciafin`) 
		 VALUES (NULL, '".$idContratoGlobal."', '".$idTipoToken."', '".$token."', CURDATE(), now(), '1', now());";
		 $query->setQuery($insertToken);
		 $refToken = $query->eject(1);		 

		 // actualizamos la fecha de vigenciafin del token que se genero basados en la tabla de 
		 $condicion = 'idtipotoken ='.$idTipoToken;
		 $vigenciaToken = $query->selectCampo('horasvalidas', 'tbtipotoken', $condicion  );
		 $updateSql = "  UPDATE dbtokens SET vigenciafin = (SELECT DATE_ADD(`vigenciainicio`, INTERVAL $vigenciaToken HOUR)) WHERE `idtoken` =".$refToken."";	
		 
		  $query->setQuery($updateSql);
		  $query->eject();
	
		 return $refToken;
	}

	public function generarNuevoTokenParaCliente($idContratoGlobal, $tipoToken){
		$query = new Query();
		$usuario = new Usuario();
		$funcionesUsuario = new ServiciosUsuarios();
		$usuarioId = $usuario->getUsuarioId();
		$usuarioMAil =  $usuario->getUsuario();
		$this->tipoToken = $tipoToken;
		$condicion =  "	idcontratoglobal =".$idContratoGlobal." ";


		$usuarioContrato =  $query->selectCampo('usuario_id', 'dbcontratosglobales', $condicion  );	
		$msg =  array();
		$msg['error'] = "";
		$msg['errorMensaje'] = "";		
		$msg['consola'] = '';
		$txtConsola = '';

		// verificacmos que no exista un NIP de este tipo que este en status 1
		$sqlSelect = "SELECT * FROM dbtokens WHERE refcontratoglobal= ".$idContratoGlobal ." AND reftipo =".$tipoToken." AND refstatustoken = 1";
		#ECHO $sqlSelect ;
		$query->setQuery($sqlSelect);
		$resExiste = $query->eject();
		$existeRegistro = ($query->numRows($resExiste)>0);
		if(!$existeRegistro){
			$idTokenNuevo = $this->generarToken($idContratoGlobal, $tipoToken);
			// ACTUALIZAMOS LA TABLA DE TOKEN CON EL NUEVO ID
			$tabla = $this->arrayTablas[$tipoToken];
			$idT = $this->arrayIdTablas[$tipoToken];
			$condicion =  "	refcontratoglobal =".$idContratoGlobal." ";
			$numeroDisposicion = 0;
			if($tipoToken == 4){
			// buscamos el numero de disposicion
				$condicionT = $condicion." ORDER BY numerodisposicion DESC LIMIT 0,1 ";
				$numeroDisposicion = $query->selectCampo('numerodisposicion',$tabla, $condicionT);	
				$condicion .= " AND  numerodisposicion = ".$numeroDisposicion; 	
			}

			$SqlUpdateT = " UPDATE ".$tabla ." SET  reftoken =".$idTokenNuevo.", status = 1 WHERE ".$condicion;
			$query->setQuery($SqlUpdateT);
			$resUp = $query->eject();
			$refAutorizacion = $query->selectCampo($idT, $tabla, $condicion);	
			if(!$resUp){
				$msg['error'] = 1;
				$msg['errorMensaje'] = "No se pudo actualizar valor en ".$tabla;
			}else{
				// se envia el mail al cliente con el token nuevo
				$cuerpoMail = '';
	    		$servidor = $_SERVER['SERVER_NAME'];
	    		$liga_servidor = ($servidor=='localhost')?SERVIDOR_LOCAL:SERVIDOR;	
	    		// formamos la URL
            		$url = trim('idCG='.$idContratoGlobal.'&idA='.$refAutorizacion.'&token='.$idTokenNuevo.'&idU='.$usuarioContrato);

            		if($numeroDisposicion>0){
            				$url = trim('idCG='.$idContratoGlobal.'&idA='.$refAutorizacion.'&token='.$idTokenNuevo.'&idU='.$usuarioContrato.'&nd='.$numeroDisposicion);
            		}
		 			$url = urlencode(base64_encode($url));
	    		if($tipoToken==1){   	
	    			


					$cuerpoMail .= '<h3><small><p>Este es el nuevo NIP generado para la autorización, por favor ingrese al siguiente <a href="'.$liga_servidor.'dashboard/contrato/cliente/autorizarConsultaHistorial.php?achid='.$url.'" target="_blank"> enlace </a> para autorizar la consulta de su historial crediticio. </p><br> La consulta del historial crediticio en financieraCREA se realiza con el fin de confirmar los datos de identidad, no es necesario contar con un buen historial crediticio para obtener un crédito. </small></h3><p>';
					$cuerpoMail .= "<center>NIP:<b>".$this->getTokenPorId($idTokenNuevo)."</b></center><p> ";
					$cuerpoMail .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';
	   				$cuerpoMail .= '<br><img width="393" height="131"  src="http://financieracrea.com/esfdesarrollo/images/firmaCREA24.jpg" alt="Financiera CREA" >';
	   				 $titulo = 'Autorizar';
	    		}

	    		if($tipoToken==2){
	    			$cuerpoMail .= '<h2 class=\"p3\"> Firmar contrato</h2>';
	    			$cuerpoMail .= '<h3><small><p>Este es el nuevo NIP generado para la firma del contrato, por favor ingrese al siguiente <a href="'.$liga_servidor.'dashboard/contrato/cliente/firmaDigitalDocumentos.php?fddid='.$url.'" target="_blank"> enlace </a> para firmar su contrato. </p> </small></h3><p>';
					$cuerpoMail .= "<center>NIP:<b>".$this->getTokenPorId($idTokenNuevo)."</b></center><p> ";
					$cuerpoMail .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';
		   			$cuerpoMail .= '<br><img width="393" height="131"  src="http://financieracrea.com/esfdesarrollo/images/firmaCREA24.jpg" alt="Financiera CREA" >';
		   			 $titulo = 'Nuevo NIP firma contrato';

	    		}
	    		if($tipoToken==3){
	    			$cuerpoMail .= '<h2 class=\"p3\"> TOKEN TIPO 3</h2>';
	    			 $titulo = 'Nuevo NIP TIPO 3';
	    		}

	    		if($tipoToken==4){
	    			$cuerpoMail .= '<h2 class=\"p3\"> Firmar Disposicion</h2>';
	    			$cuerpoMail .= '<h3><small><p>Este es el nuevo NIP generado para la firma del pagaré, por favor ingrese al siguiente <a href="'.$liga_servidor.'dashboard/contrato/cliente/firmaDigitalDisposicion.php?fddid='.$url.'" target="_blank"> enlace </a> para firmar su disposicion. </p> </small></h3><p>';
					$cuerpoMail .= "<center>NIP:<b>".$this->getTokenPorId($idTokenNuevo)."</b></center><p> ";
					$cuerpoMail .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';
		   			$cuerpoMail .= '<br><img width="393" height="131"  src="http://financieracrea.com/esfdesarrollo/images/firmaCREA24.jpg" alt="Financiera CREA" >';
		   			 $titulo = 'Nuevo NIP firma disposicion';
	    		}

	    		if($tipoToken==5){
	    			$cuerpoMail .= '<h2 class=\"p3\"> TOKEN TIPO 5</h2>';
	    			 $titulo = 'Nuevo NIP TIPO 5';
	    		}
				
		   		   		
	            $emailUsuario = $funcionesUsuario->traerEmailUsuario($usuarioContrato);            
	            $emailUsuario = 'zuoran_17@hotmail.com';	           
				$funcionesUsuario->enviarEmail($emailUsuario,utf8_decode($titulo),utf8_decode($cuerpoMail));
				#echo "<h1> se nevia el correo al cliente </h1>";

			}


		}else{
			$msg['error'] = 2;
			$msg['errorMensaje'] = "No se puede generar nuevamente un NIP, ya se generó uno previamente, por favor revise su correo y siga las instrucciones ";

		}


		

		
	   	$msg['consola']  = "termina el proceso";

	   	if($msg['error'] == 0){
	   			#$query->commitTrans();
	   	}


		return 	json_encode($msg);


	}

	public	function getTokenTipoContrato($idContratoGlobal, $idTipoToken, $idStausToken){
		$query = new Query();
		$sqlToken = "SELECT *					   
	               FROM
	                   dbtokens 	                      
	               WHERE
	                   refcontratoglobal = ".$idContratoGlobal." AND 
					   reftipo = ".$reftipo." AND 
					   refstatustoken = ".$idStausToken."  ";	

			$query->setQuery($sqlToken);
			$rs = $query->eject();
			$objToken = $query->fetchObject($rs);
			$this->idtoken = $objToken->idtoken;
			$this->refcontratoglobal = $objToken->refcontratoglobal;
			$this->reftipo = $objToken->reftipo;
			$this->token = $objToken->token;
			$this->fecha = $objToken->fecha;
			$this->hora = $objToken->hora;
			$this->refstatustoken = $objToken->refstatustoken;
	}


	public	function getTokenPorId($idToken){
		$query = new Query();
		$sqlToken = "SELECT *					   
	               FROM
	                   dbtokens 	                      
	               WHERE
	                   idtoken = ".$idToken;	                    
			$query->setQuery($sqlToken);			
			$rs = $query->eject();
			$objToken = $query->fetchObject($rs);			
			$this->idtoken = $objToken->idtoken;
			$this->refcontratoglobal = $objToken->refcontratoglobal;
			$this->reftipo = $objToken->reftipo;
			$this->token = $objToken->token;
			$this->fecha = $objToken->fecha;
			$this->hora = $objToken->hora;
			$this->refstatustoken = $objToken->refstatustoken;
			return $this->token;
	}

	public function validarVigenciaToken($idToken, $idContratoGlobal){
		$query = new Query();
		$tokenValido = false;
		$sqlToken = "SELECT vigenciafin, UNIX_TIMESTAMP(vigenciafin) as vigencia, NOW() as hoy, UNIX_TIMESTAMP(NOW()) as today , (UNIX_TIMESTAMP(vigenciafin) - UNIX_TIMESTAMP(NOW())) as diferencia FROM dbtokens WHERE idtoken = ".$idToken." ";		
		$query->setQuery($sqlToken);
		$resT = $query->eject();
		$ObjToken = $query->fetchObject($resT);		
		$fechaFinToken = $ObjToken->vigenciafin;
		$fechaHoy = $ObjToken->hoy;
		$diferenciaFechas = $ObjToken->diferencia;		
		if($diferenciaFechas >= 0){
			$tokenValido = true;
			// cambiar el status del token
		}else{
			// se pone como vencido el token, se cambia el staus a 3; TOKEN vencido
			$sqlUpdateToken = "UPDATE dbtokens SET 	refstatustoken = 3 WHERE idtoken = ".$idToken." ";
			$query->setQuery($sqlUpdateToken);
			$query->eject();
			
		}		
		return $tokenValido;
	}

	public function rollbackToken($idTipoToken, $idContratoGlobal){
		$query = new Query();
		$usuario = new Usuario();
		$usuarioId = $usuario->getUsuarioId();
		$this->tipoToken = $idTipoToken;
		$msg =  array();
		$msg['error'] = "";
		$msg['errorMensaje'] = "";
		$msg['tokenValido'] = 0;
		$msg['consola'] = '';
		$msg['rollBackToquenCorrecto'] = 0;
		$txtConsola = '';
		$idToken =  $this->getTokenId();		

		$tablaAsociada = $this->arrayTablas[$idTipoToken];
		$idTablaAsociada = $this->arrayIdTablas[$idTipoToken];
		if($idToken>0){
			$updateAutorizacion = " UPDATE ". $tablaAsociada."
			SET 	fechafirma = NULL,
			horafirma = NULL,
			token = NULL,
			status = 1,
			refusuario = NULL
			WHERE reftoken = ".$idToken." ";
			$query->setQuery($updateAutorizacion);
			$res = $query->eject();
						
			if(!$res){
				$msg['error'] = "1"; // error al actulizar la autorizacion
			}else{
				$updateTS = "UPDATE dbtokens 
				SET refstatustoken = 1,
				constanciaxml = NULL,
				fechasignatura = NULL										
				WHERE idtoken = ".$idToken;
				$query->setQuery($updateTS);				
				$resTS = $query->eject();
				if(!$resTS){
					$msg['error'] = "1";
					$msg['errorMensaje'] = "Error al actualiza el status del token";
				}else{
					$msg['rollBackToquenCorrecto'] = 1;
				}					
			}

		}
		

		return $msg;


	}
	public function validarToken($idTipoToken, $idContratoGlobal, $nip, $numeroDisposicion = 0){
		// validamos que el token exista para el con contrato global y que ese token 
		$query = new Query();
		$usuario = new Usuario();
		$usuarioId = $usuario->getUsuarioId();
		$this->tipoToken = $idTipoToken;
		$msg =  array();
		$msg['error'] = "";
		$msg['errorMensaje'] = "";
		$msg['tokenValido'] = 0;
		$msg['consola'] = '';
		$txtConsola = '';
		$andDisposicion = '';

		if($numeroDisposicion>0){
			$andDisposicion =' AND numerodisposicion = '.$numeroDisposicion;
		}
		 
		 // buscamos en la base de datos el token que se generó para ese ID
		// 1=>activo ;2=>usado;3=vencido
		if(array_key_exists($idTipoToken, $this->arrayTablas) && $this->arrayTablas[$idTipoToken] != ''){
			$sqlToken = "SELECT * FROM dbtokens WHERE  refcontratoglobal =".$idContratoGlobal." AND  reftipo = ".$idTipoToken." AND refstatustoken IN (1,3) ORDER BY  refstatustoken ASC LIMIT 0,1 ";

			
			$query->setQuery($sqlToken);
			$resToken = $query->eject();
			$objToken = $query->fetchObject($resToken);
			$idtoken = $objToken->idtoken;

			
			$token = $objToken->token;
			$statusToken =  $objToken->refstatustoken;
			$txtConsola .= "IdToken => ".$idtoken;
			// buscamos el registro que genero el tipo de token
			$tablaAsociada = $this->arrayTablas[$idTipoToken];
			$idTablaAsociada = $this->arrayIdTablas[$idTipoToken];
			$idAutorizacio = 0;
			$statusDelToken = '';
			if($idtoken > 0){
				$sqlGT =  "SELECT * FROM ". $tablaAsociada."  WHERE 	refcontratoglobal= ".$idContratoGlobal." AND 	reftoken =  ".$idtoken."  ".$andDisposicion; // AND status = 1
				$query->setQuery($sqlGT);				
				$resAutorizacion = $query->eject();
				$objAutorizacion = $query->fetchObject($resAutorizacion);
				$idAutorizacion =  $objAutorizacion->$idTablaAsociada;
				$statusDelToken = $objAutorizacion->status;
			}
			$txtConsola .= $sqlToken;
			$txtConsola .= "idAutorizacion".$idAutorizacion ."...";

			if($idAutorizacion > 0){
				
				// verificamos que los datos del usuario sean los mismos de la base de datos
				if($statusDelToken ==2){
					$msg['error'] = "1";
					$msg['errorMensaje'] = "Esta autorizacion ya esta firmada";
					$msg['consola'] = $txtConsola;

				}
				if($token == $nip && $statusDelToken== 1){
					// el nip del usuario coincide con la base de datos
					//verificamos la vigencia del NIP
					$this->setTokenId($idtoken);					
					$tokenValido = $this->validarVigenciaToken($idtoken, $idContratoGlobal);
					$txtConsola .="TOKEN VALIDO =>".$tokenValido; 
					if($tokenValido ){

						if(!empty($usuarioId)){

							$msg['tokenValido'] = 1; 
							// grabamos la fecha de autorizacion
							$updateAutorizacion = " UPDATE ". $tablaAsociada."
													SET 	fechafirma = CURDATE(),
													horafirma = now(),
													token = $token,
													status = 2,
												    refusuario = $usuarioId
													WHERE $idTablaAsociada = ".$idAutorizacion." ";
							$query->setQuery($updateAutorizacion);
							$res = $query->eject();
							
							if(!$res){
								$msg['error'] = "4"; // error al actulizar la autorizacion
							}else{
								$updateTS = "UPDATE dbtokens 
											 SET refstatustoken = 2										
											 WHERE idtoken = ".$idtoken;
								$query->setQuery($updateTS);
								$resTS = $query->eject();
								if(!$resTS){
									$msg['error'] = "5";
									$msg['errorMensaje'] = "Error al actualiza el status del token";
								}

								

								if($idtipotoken== 1){
									$updateCG = "UPDATE dbcontratosglobales
														SET burocredito = 1										
														WHERE idcontratoglobal = ".$idContratoGlobal;
									$query->setQuery($updateCG);
									$res2 = $query->eject();
									if(!$res2){
										$msg['error'] = "6"; 
										$msg['errorMensaje'] = "Error al actualizar el contrato global";
									}
								}
								
							}
						// usuario !empty	
						}else{
							$msg['error'] = "8";
							$msg['errorMensaje'] = "LA SESION CADUCÓ VUELVA A ENTRAR PARA FIRMAR EL CONTRATO";

						}
					}else{

						// se debe cambiar el status del token a 3 ya esta vencido
						// se cambia a 3 para que se pueda generar uno nuevo
						$msg['error'] = "3"; 
						$msg['errorMensaje'] = " el NIP ha caducado, es nesesario solicitar uno nuevo";
						$txtConsola .= "NIP caduco";
					}// token Invalido Necesario  solicitar uno nuevo					
				}else{
					if($statusDelToken== 3){
						$msg['error'] = "3";
						$msg['errorMensaje'] = "El NIP ha caducado, es nesesario solicitar uno nuevo";

					}else{
						$msg['error'] = "2";
						$msg['errorMensaje'] = "Verifique el NIP y vuelva a Intentarlo";
					}

						
					
				}
			}else{
				$msg['error'] = "1";
				$msg['errorMensaje'] = "No existe autorizacion pendiente de firma";
				$msg['consola'] = $txtConsola;
				
				
			}
		}else{
			$msg['error'] = "7";
			$msg['errorMensaje'] = "Esta tabla no esta categorizada en los arreglos"; // esta tabla no esta categorizada en los arreglos
		} // else key_exists

		//$msg['consola']  = $txtConsola;

		return $msg;
	}


}

?>