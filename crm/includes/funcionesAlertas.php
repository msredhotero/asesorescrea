<?php

date_default_timezone_set('America/Mexico_City');

/*
* DEBO VERIFICAR EN LAS ALERTAS SI LA POLIZA ES DE LA PROMOTORIA O DE UN AGENTE
*
*
*/
class serviciosAlertas
{

   const REF_TABLA = 15;

   public static function getRefTablaValue()
   {
      return self::REF_TABLA;
   }

   function alertaVencimientoPoliza($dias,$marca=0,$operador='') {

      $cadOperador = '=';
      $cadIsNull = ' and aa.idalerta is null ';

      if ($operador != '') {
         $cadOperador = $operador;
      }

      $cadOtroEstado = '(4,5)';
      if ($marca == 1) {
         $cadOtroEstado = '(3,4,5)';
         $cadIsNull = '';
      }

      if ($marca == 2) {
         $cadOtroEstado = '(4,5,1,2)';
         $cadIsNull = '';
      }
      $sql = "SELECT
                  p.idperiodicidadventadetalle,
                  p.montototal,
                  p.fechavencimiento,
                  p.nrorecibo,
                  DATEDIFF(p.fechavencimiento, CURDATE()) AS dias,
                  pp.producto,
                  cli.nombre as nombrecliente,
                  coalesce( usu.email,usua.email) as emailcliente,
                  ase.nombre as nombreasesor,
                  usua.email as emailasesor,
                  ve.nropoliza,
                  coalesce( usu.idusuario,usua.idusuario) as idusuariocliente,
                  usua.idusuario as idusuarioasesor,
                  ve.idventa,
                  ase.claveasesor,
                  ase.envioalcliente

               FROM
                  dbperiodicidadventasdetalle p
               INNER JOIN
                  dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
               INNER JOIN
                  dbventas ve ON ve.idventa = per.refventas
               INNER JOIN
                  dbcotizaciones co ON co.idcotizacion = ve.refcotizaciones
               inner join
                  dbclientes cli on cli.idcliente = co.refclientes
               left join
                  dbusuarios usu on usu.idusuario = cli.refusuarios
               inner join
                  dbasesores ase on ase.idasesor = co.refasesores
               left join
                  dbusuarios usua on usua.idusuario = ase.refusuarios
               INNER JOIN
                  tbproductos pp ON (CASE
                     WHEN ve.refproductosaux = 0 THEN pp.idproducto = co.refproductos
                     ELSE pp.idproducto = ve.refproductosaux
                     END)
               INNER JOIN
                  tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
               INNER JOIN
                  tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
               INNER JOIN
                  tbestadopago est ON est.idestadopago = p.refestadopago
               LEFT JOIN
                  dbalertas aa ON aa.reftabla = ".serviciosAlertas::REF_TABLA."
                  AND aa.idreferencia = p.idperiodicidadventadetalle
               where p.refestadopago not in ".$cadOtroEstado."
                     and DATEDIFF(p.fechavencimiento,CURDATE()) ".$cadOperador." ".$dias." ".$cadIsNull;

      //die(var_dump($sql));
      $res = $this->query($sql,0);

      return $res;
   }

   function alertaVencimiento30dias($dias,$reftipoalerta) {

      $res = $this->alertaVencimientoPoliza($dias);

      $cuerpo = '';

      $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

      $cuerpo .= "
      <style>
      	body { font-family: 'Lato', sans-serif; }
      	header { font-family: 'Prata', serif; }
      </style>";

      $cuerpo .= '<body>';

      $cuerpo .= '<h3><small><p>El pago de su servicio/producto: ********, se vencerá en '.$dias.' dias </small></h3><p>';


   	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

      $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

      $cuerpo .= '</body>';

      while ($row = mysql_fetch_array($res)) {

         // verifico si ya cree la liga para pagar
         $resCI = $this->traerComercioinicioPorReferencia(15, 'dbperiodicidadventasdetalle', 'idperiodicidadventadetalle', $row['idperiodicidadventadetalle']);

         if (mysql_num_rows($resCI) > 0) {
      		$tokenPago = mysql_result($resCI,0,'token');
      	} else {

            // total del valor a pagar //// por ahora un peso (1)
            //$comtotal = $lblPrecio;
            $comtotal = $row['montototal'];
            //moneda
            $comcurrency = '484';
            //direccion
            $comaddress = '';
            //el id de la cotizacion
            $comorder_id = 0;
            //numero proporcionado por el banco
            $commerchant = '8407825';
            //siempre va lo mismo
            $comstore = '0123';
            //siempre va lo mismo
            $comterm = '123';

            //url para devolver la pagina en la transaccion
            $urlback = 'comercio_con.php';
            //origen de donde salen los datos
            // en este casa sera "7 - Producto Venta en Linea CRM"
            $reforigencomercio = 7;

            // inicio el estado de la transaccion
            $refestadotransaccion = 1;
            // socio comercial
            $refafiliados = 1;
            //fecha que empezo
            $fechacrea = date('Y-m-d H:i:s');
            // usuario
            $usuariocrea = 'automatico';
            // vigencia un dia despues, es automatico
            $vigencia = '';
            //observaciones
            $observaciones = '';

            $comdigest=sha1($commerchant.$comstore.$comterm.$comtotal.$comcurrency.$comorder_id);

            $tokenPago = $this->GUID();

            $idComercio = $this->insertarComercioinicio($tokenPago,$comtotal,$comcurrency,'',$comorder_id,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones,$usuariocrea,15,$row['idperiodicidadventadetalle']);

         	$resModOrder = $this->modificarComercioInicioOrderID($idComercio);
      	}

         $cuerpoAux = '';

         // aca va a depender si es para el cliente o el asesor
         $email = $row['emailcliente'];

         $mensaje = 'En '.$dias.' es la fecha de vencimiento del recibo '.$row['nrorecibo'].' de la poliza: '.$row['nropoliza'];


         // datos para el pago online
         $url = "cobranza/comercio_fin.php?token=".$tokenPago;
         $token = $this->GUID();
         $resAutoLogin = $this->insertarAutologin($row['idusuariocliente'],$token,$url,'0');

         // datos para el pago por transferencia
         $urlTransferencia = 'cobranza/subirdocumentacioni.php?id='.$row['idperiodicidadventadetalle'].'&iddocumentacion=39';
         $tokenTransferencia = $this->GUID();
         $resAutoLoginTransferencia = $this->insertarAutologin($row['idusuariocliente'],$tokenTransferencia,$urlTransferencia,'0');


         // fin datos pago online //

         $cuerpoAux .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder y Pagar por el carrito de compras</h4>';

         $cuerpoAux .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder y adjuntar el comprobante de pago, nuestra administración, validara estos datos cargados.</h4><h5>Clabe Interbancaria para transferencias: 036180500079200351</h5>';


         $cuerpoAux .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

         $cuerpoAux .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

         $cuerpoAux .= '</body>';

         //$retorno = $this->enviarEmail($email,$mensaje,utf8_decode( str_replace('********',$row['producto'],$cuerpo.$cuerpoAux)));

         $resI = $this->insertarAlertas($reftipoalerta,serviciosAlertas::REF_TABLA,$row['idperiodicidadventadetalle'],$email,$mensaje,'1');

      }
   }

   function alertaVencimientoMarcarTabla($dias,$reftipoalerta) {
      if ($dias == 0) {
         $res = $this->alertaVencimientoPoliza($dias,1,"<=");

         while ($row = mysql_fetch_array($res)) {
            $resMod = $this->modificarPeriodicidadventasdetalleEstado($row['idperiodicidadventadetalle'],3,'automatico',date('Y-m-d H:i:s'));
         }
      }

      if ($dias == -11) {
         $res = $this->alertaVencimientoPoliza($dias,2);

         while ($row = mysql_fetch_array($res)) {
            $resMod = $this->modificarVentasUnicaDocumentacion($row['idventa'], 'refestadoventa', 4);
         }
      }



   }

   function alertaVencimientoDiasDespues($dias,$reftipoalerta) {

      $res = $this->alertaVencimientoPoliza($dias);

      $cuerpo = '';

      $cuerpo .= '<img src="https://asesorescrea.com/desarrollo/crm/imagenes/encabezado-Asesores-CREA.jpg" alt="ASESORESCREA" width="100%">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Prata&display=swap" rel="stylesheet">';

      $cuerpo .= '<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">';

      $cuerpo .= "
      <style>
      	body { font-family: 'Lato', sans-serif; }
      	header { font-family: 'Prata', serif; }
      </style>";

      $cuerpo .= '<body>';

      if ($dias == -2) {
         $cuerpo .= '<h3><small><p>El pago de su servicio/producto: ********, se vencio, podriamos reactivar tu poliza si haces el pago ahora. El estatus de tu poliza es vencido, al momento se encuentra sin cobertura </small></h3><p>';

      }

      if ($dias == -10) {
         $cuerpo .= '<h3><small><p>El pago de su servicio/producto: ********, se vencio, mañana cacelaremos tu poliza. </small></h3><p>';

      }


   	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

      $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

      $cuerpo .= '</body>';

      while ($row = mysql_fetch_array($res)) {
         if ($dias == -2) {
            // verifico si ya cree la liga para pagar
            $resCI = $this->traerComercioinicioPorReferencia(15, 'dbperiodicidadventasdetalle', 'idperiodicidadventadetalle', $row['idperiodicidadventadetalle']);

            if (mysql_num_rows($resCI) > 0) {
         		$tokenPago = mysql_result($resCI,0,'token');
         	} else {

               // total del valor a pagar //// por ahora un peso (1)
               //$comtotal = $lblPrecio;
               $comtotal = $row['montototal'];
               //moneda
               $comcurrency = '484';
               //direccion
               $comaddress = '';
               //el id de la cotizacion
               $comorder_id = 0;
               //numero proporcionado por el banco
               $commerchant = '8407825';
               //siempre va lo mismo
               $comstore = '0123';
               //siempre va lo mismo
               $comterm = '123';

               //url para devolver la pagina en la transaccion
               $urlback = 'comercio_con.php';
               //origen de donde salen los datos
               // en este casa sera "7 - Producto Venta en Linea CRM"
               $reforigencomercio = 7;

               // inicio el estado de la transaccion
               $refestadotransaccion = 1;
               // socio comercial
               $refafiliados = 1;
               //fecha que empezo
               $fechacrea = date('Y-m-d H:i:s');
               // usuario
               $usuariocrea = 'automatico';
               // vigencia un dia despues, es automatico
               $vigencia = '';
               //observaciones
               $observaciones = '';

               $comdigest=sha1($commerchant.$comstore.$comterm.$comtotal.$comcurrency.$comorder_id);

               $tokenPago = $this->GUID();

               $idComercio = $this->insertarComercioinicio($tokenPago,$comtotal,$comcurrency,'',$comorder_id,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones,$usuariocrea,15,$row['idperiodicidadventadetalle']);

            	$resModOrder = $this->modificarComercioInicioOrderID($idComercio);
         	}
         }

         $cuerpoAux = '';

         // aca va a depender si es para el cliente o el asesor
         $email = $row['emailcliente'];

         $mensaje = 'En '.$dias.' es la fecha de vencimiento del recibo '.$row['nrorecibo'].' de la poliza: '.$row['nropoliza'];

         if ($dias == -2) {
            // datos para el pago online
            $url = "cobranza/comercio_fin.php?token=".$tokenPago;
            $token = $this->GUID();
            $resAutoLogin = $this->insertarAutologin($row['idusuariocliente'],$token,$url,'0');

            // datos para el pago por transferencia
            $urlTransferencia = 'cobranza/subirdocumentacioni.php?id='.$row['idperiodicidadventadetalle'].'&iddocumentacion=39';
            $tokenTransferencia = $this->GUID();
            $resAutoLoginTransferencia = $this->insertarAutologin($row['idusuariocliente'],$tokenTransferencia,$urlTransferencia,'0');


            // fin datos pago online //

            $cuerpoAux .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder y Pagar por el carrito de compras</h4>';

            $cuerpoAux .= '<h4>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder y adjuntar el comprobante de pago, nuestra administración, validara estos datos cargados.</h4><h5>Clabe Interbancaria para transferencias: 036180500079200351</h5>';
         }

         $cuerpoAux .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

         $cuerpoAux .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

         $cuerpoAux .= '</body>';

         //$retorno = $this->enviarEmail($email,$mensaje,utf8_decode( str_replace('********',$row['producto'],$cuerpo.$cuerpoAux)));

         $resI = $this->insertarAlertas($reftipoalerta,serviciosAlertas::REF_TABLA,$row['idperiodicidadventadetalle'],$email,$mensaje,'1');

      }
   }




   function insertarAlertas($reftipoalerta,$reftabla,$idreferencia,$email,$mensaje,$esunico) {
      $sql = "insert into dbalertas(idalerta,reftipoalerta,reftabla,idreferencia,email,mensaje,esunico)
      values ('',".$reftipoalerta.",".$reftabla.",".$idreferencia.",'".$email."','".$mensaje."','".$esunico."')";
      $res = $this->query($sql,1);
      return $res;
   }

   function insertarComercioinicio($token,$comtotal,$comcurrency,$comaddres,$comorderid,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones,$usuariomodi,$reftabla,$idreferencia) {
      $sql = "insert into dbcomercioinicio(idcomercioinicio,token,comtotal,comcurrency,comaddres,comorderid,commerchant,comstore,comterm,comdigest,urlback,reforigencomercio,refestadotransaccion,refafiliados,fechacrea,usuariocrea,vigencia,observaciones,fechamodi,usuariomodi,reftabla,idreferencia)
      values ('','".$token."',".$comtotal.",'".$comcurrency."','".$comaddres."',".$comorderid.",'".$commerchant."','".$comstore."','".$comterm."','".$comdigest."','".$urlback."',".$reforigencomercio.",".$refestadotransaccion.",".$refafiliados.",'".$fechacrea."','".$usuariocrea."',adddate(current_date(),1),'".$observaciones."','".date('Y-m-d H:i:s')."','".$usuariomodi."',".$reftabla.",".$idreferencia.")";
      $res = $this->query($sql,1);
      return $res;
   }

   function modificarComercioInicioOrderID($id) {
      $sql = "update dbcomercioinicio set comorderid = '".$id."' where idcomercioinicio = ".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarPeriodicidadventasdetalleEstado($id,$refestadopago,$usuariomodi,$fechamodi) {
		$sql = "update dbperiodicidadventasdetalle
		set
		refestadopago = ".$refestadopago.",usuariomodi = '".$usuariomodi."',fechamodi = '".$fechamodi."' where idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function modificarVentasUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbventas
		set
		".$campo." = '".$valor."'
		where idventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function insertarAutologin($refusuarios,$token,$url,$usado) {
      $sql = "insert into autologin(idautologin,refusuarios,token,url,usado)
      values ('',".$refusuarios.",'".$token."','".$url."','".$usado."')";
      $res = $this->query($sql,1);
      return $res;
   }

   function traerComercioinicioPorReferencia($idtabla, $tabla, $idnombre, $id) {
      $sql = "select c.idcomercioinicio,c.token,c.comtotal,c.comcurrency,c.comaddres,c.comorderid,c.commerchant,c.comstore,c.comterm,c.comdigest,c.urlback,c.reforigencomercio,c.refestadotransaccion,c.refafiliados,c.fechacrea,c.usuariocrea,c.vigencia,c.observaciones,c.fechamodi,c.usuariomodi,c.nrocomprobante,c.reftabla,c.idreferencia from dbcomercioinicio c
      inner join ".$tabla." v on v.".$idnombre." = c.idreferencia
		where c.reftabla = ".$idtabla." and c.idreferencia = ".$id;

      $res = $this->query($sql,0);
      return $res;
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
