<?php

date_default_timezone_set('America/Mexico_City');

class serviciosValidador {

   function validaRequerido($valor){
      if(trim($valor) == ''){
         return false;
      }else{
         return true;
      }
   }

   function validarEntero($valor){
      if(filter_var($valor, FILTER_VALIDATE_INT) === FALSE){
         return false;
      }else{
         return true;
      }
   }


   function validarEnteroRango($valor, $min, $max){
      if(filter_var($valor, FILTER_VALIDATE_INT, array("options" => array("min_range"=>$min, "max_range"=>$max))) === FALSE){
         return false;
      }else{
         return true;
      }
   }

   function validaEmail($valor){
      if(filter_var($valor, FILTER_VALIDATE_EMAIL) === FALSE){
         return false;
      }else{
         return true;
      }
   }

   function validaLongitud($valor, $longitud) {
      if (strlen($valor) != $longitud) {
         return false;
      } else {
         return true;
      }
   }

   function validar_fecha_espanol($fecha){
   	$valores = explode('-', str_replace('_','',$fecha));
   	//die(var_dump((integer)$valores[1].(integer)$valores[2].(integer)$valores[0]));
   	if(count($valores) == 3 &&
   		checkdate((integer)$valores[1], (integer)$valores[2], (integer)$valores[0] &&
   		strlen($valores[1]) == 2 &&
   		strlen($valores[2]) == 2 &&
   		strlen($valores[0]) == 4)){
   		return true;
       }
   	return false;
   }

   function validarCurp($string) {
      // TRANSFORMARMOS EN STRING EN MAYÚSCULAS RESPETANDO LAS Ñ PARA EVITAR ERRORES
        $string = mb_strtoupper($string, "UTF-8");
        // EL REGEX POR @MARIANO
        $pattern = "/^([A-Z][AEIOUX][A-Z]{2}\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])[HM](?:AS|B[CS]|C[CLMSH]|D[FG]|G[TR]|HG|JC|M[CNS]|N[ETL]|OC|PL|Q[TR]|S[PLR]|T[CSL]|VZ|YN|ZS)[B-DF-HJ-NP-TV-Z]{3}[A-Z\d])(\d)$/";
        $validate = preg_match($pattern, $string, $match);
        if( $validate === false ){
           // SI EL STRING NO CUMPLE CON EL PATRÓN REQUERIDO RETORNA FALSE
            return false;
        }

        return true;
   }

   function validarRFC($string) {
      // TRANSFORMARMOS EN STRING EN MAYÚSCULAS RESPETANDO LAS Ñ PARA EVITAR ERRORES
      $string = mb_strtoupper($string, "UTF-8");
      // EL REGEX POR @MARIANO
      $pattern = '/^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/';
      $validate = preg_match($pattern, $string, $match);
      if( $validate === false ){
         // SI EL STRING NO CUMPLE CON EL PATRÓN REQUERIDO RETORNA FALSE
         return false;
      }

      return true;
   }


}



?>
