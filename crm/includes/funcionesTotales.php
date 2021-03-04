<?php

date_default_timezone_set('America/Mexico_City');

/*
* DEBO VERIFICAR EN LAS ALERTAS SI LA POLIZA ES DE LA PROMOTORIA O DE UN AGENTE
*
*
*/
class serviciosTotales
{

   const REF_TABLA = 15;

   public static function getRefTablaValue()
   {
      return self::REF_TABLA;
   }

   function devolverRamaProductoPorRol($idrol) {
      $idramaproducto = 0;
      switch ($idrol) {
         case 20:
            $idramaproducto = 8;
         break;
         case 21:
            $idramaproducto = 7;
         break;

      }

      return $idramaproducto;
   }

   function devolverTotalPolizasActivas($refasesor=0,$refperfil=0) {
      if ($refasesor != 0) {
         $sql = "select count(v.idventa) as polizas, sum(v.primaneta) as primaneta, sum(v.primatotal) as primatotal
                  from dbventas v
                  inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones and c.refasesores = ".$refasesor."
                  where v.refestadoventa = 1";
      } else {
         if ($refperfil != 0) {
            $sql = "select count(v.idventa) as polizas, sum(v.primaneta) as primaneta, sum(v.primatotal) as primatotal
                     from dbventas v
                     inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones
                     inner join tbproductos p on
                     (case when v.refproductosaux = 0 then p.idproducto = c.refproductos else v.refproductosaux = p.idproducto end)
                      and p.reftipoproductorama = ".$this->devolverRamaProductoPorRol($refperfil)."
                     where v.refestadoventa = 1";

         } else {
            $sql = "select count(v.idventa) as polizas, sum(v.primaneta) as primaneta, sum(v.primatotal) as primatotal
                     from dbventas v
                     inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones
                     where v.refestadoventa = 1";
         }
      }

      $res = $this->query($sql,0);

      return array(
         'polizas'=> mysql_result($res,0,0),
         'primaneta'=> mysql_result($res,0,1),
         'primatotal'=> mysql_result($res,0,2)
      );
   }


   function devolverCobranzaPendiente($refasesor=0,$refperfil=0) {
      if ($refasesor != 0) {
         $sql = "select count(pvd.idperiodicidadventadetalle) as idperiodicidadventadetalle
                  from dbventas v
                  inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones and c.refasesores = ".$refasesor."
                  inner join dbperiodicidadventas pv on pv.refventas = v.idventa
                  inner join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
                  where v.refestadoventa = 1 and pvd.refestadopago in (1,3)";
      } else {
         if ($refperfil != 0) {
            $sql = "select count(pvd.idperiodicidadventadetalle) as idperiodicidadventadetalle
                     from dbventas v
                     inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones
                     inner join tbproductos p on
                     (case when v.refproductosaux = 0 then p.idproducto = c.refproductos else v.refproductosaux = p.idproducto end)
                      and p.reftipoproductorama = ".$this->devolverRamaProductoPorRol($refperfil)."
                      inner join dbperiodicidadventas pv on pv.refventas = v.idventa
                     inner join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
                     where v.refestadoventa = 1 and pvd.refestadopago in (1,3)";

         } else {
            $sql = "select count(pvd.idperiodicidadventadetalle) as idperiodicidadventadetalle
                     from dbventas v
                     inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones
                     inner join dbperiodicidadventas pv on pv.refventas = v.idventa
                     inner join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
                     where v.refestadoventa = 1 and pvd.refestadopago in (1,3)";
         }
      }

      $res = $this->query($sql,0);

      return mysql_result($res,0,0);
   }

   function GUID()
   {
       if (function_exists('com_create_guid') === true)
       {
           return trim(com_create_guid(), '{}');
       }

       return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
   }



   function enviarEmail($destinatario,$asunto,$cuerpo, $referencia='') {


		# Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
		# se deshabilita y los mensajes son enviados tan rápido como sea posible.
	   if ($referencia == '') {
	      $referencia = 'consulta@asesorescrea.com';
	   }
	   # Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
	   # se deshabilita y los mensajes son enviados tan rápido como sea posible.


	   //para el envío en formato HTML
	   //$headers = "MIME-Version: 1.0\r\n";

	   // Cabecera que especifica que es un HMTL
	   $headers  = 'MIME-Version: 1.0' . "\r\n";
	   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	   //dirección del remitente
	   $headers .= utf8_decode("From: ASESORES CREA <consulta@asesorescrea.com>\r\n");

		mail($destinatario,$asunto,$cuerpo,$headers);
	}

   function query($sql,$accion) {



		require_once 'appconfig.php';

		$appconfig	= new appconfig();
		$datos		= $appconfig->conexion();
		$hostname	= $datos['hostname'];
		$database	= $datos['database'];
		$username	= $datos['username'];
		$password	= $datos['password'];

		$conex = mysql_connect($hostname,$username,$password) or die ("no se puede conectar".mysql_error());

		mysql_select_db($database);

		        $error = 0;
		mysql_query("BEGIN");
		$result=mysql_query($sql,$conex);
		if ($accion && $result) {
			$result = mysql_insert_id();
		}
		if(!$result){
			$error=1;
		}
		if($error==1){
			mysql_query("ROLLBACK");
			return false;
		}
		 else{
			mysql_query("COMMIT");
			return $result;
		}

	}


}



?>
