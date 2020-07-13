<?php

date_default_timezone_set('America/Mexico_City');

class seviciosComercio
{

   /* PARA Comerciofin */

   function insertarComerciofin($emresponse,$emtotal,$emordenid,$emmerchant,$emstore,$emterm,$emrefnum,$emauth,$emdigest,$token) {
      $sql = "insert into dbcomerciofin(idcomerciofin,emresponse,emtotal,emordenid,emmerchant,emstore,emterm,emrefnum,emauth,emdigest,token)
      values ('','".$emresponse."','".$emtotal."','".$emordenid."','".$emmerchant."','".$emstore."','".$emterm."','".$emrefnum."','".$emauth."','".$emdigest."','".$token."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarComerciofin($id,$emresponse,$emtotal,$emordenid,$emmerchant,$emstore,$emterm,$emrefnum,$emauth,$emdigest,$token) {
      $sql = "update dbcomerciofin
      set
      emresponse = '".$emresponse."',emtotal = '".$emtotal."',emordenid = '".$emordenid."',emmerchant = '".$emmerchant."',emstore = '".$emstore."',emterm = '".$emterm."',emrefnum = '".$emrefnum."',emauth = '".$emauth."',emdigest = '".$emdigest."',token = '".$token."' where idcomerciofin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarComerciofin($id) {
      $sql = "delete from dbcomerciofin where idcomerciofin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerComerciofin() {
      $sql = "select
      c.idcomerciofin,
      c.emresponse,
      c.emtotal,
      c.emordenid,
      c.emmerchant,
      c.emstore,
      c.emterm,
      c.emrefnum,
      c.emauth,
      c.emdigest,
      c.token
      from dbcomerciofin c
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerComerciofinPorId($id) {
      $sql = "select idcomerciofin,emresponse,emtotal,emordenid,emmerchant,emstore,emterm,emrefnum,emauth,emdigest,token from dbcomerciofin where idcomerciofin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbcomerciofin*/


   /* PARA Comercioinicio */

   function insertarComercioinicio($token,$comtotal,$comcurrency,$comaddres,$comorderid,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones) {
      $sql = "insert into dbcomercioinicio(idcomercioinicio,token,comtotal,comcurrency,comaddres,comorderid,commerchant,comstore,comterm,comdigest,urlback,reforigencomercio,refestadotransaccion,refafiliados,fechacrea,usuariocrea,vigencia,observaciones)
      values ('','".$token."',".$comtotal.",'".$comcurrency."','".$comaddres."',".$comorderid.",'".$commerchant."','".$comstore."','".$comterm."','".$comdigest."','".$urlback."',".$reforigencomercio.",".$refestadotransaccion.",".$refafiliados.",'".$fechacrea."','".$usuariocrea."',adddate(current_date(),1),'".$observaciones."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarComercioinicio($id,$token,$comtotal,$comcurrency,$comaddres,$comorderid,$commerchant,$comstore,$comterm,$comdigest,$urlback,$reforigencomercio,$refestadotransaccion,$refafiliados,$fechacrea,$usuariocrea,$vigencia,$observaciones) {
      $sql = "update dbcomercioinicio
      set
      token = '".$token."',comtotal = ".$comtotal.",comcurrency = '".$comcurrency."',comaddres = '".$comaddres."',comorderid = ".$comorderid.",commerchant = '".$commerchant."',comstore = '".$comstore."',comterm = '".$comterm."',comdigest = '".$comdigest."',urlback = '".$urlback."',reforigencomercio = ".$reforigencomercio.",refestadotransaccion = ".$refestadotransaccion.",refafiliados = ".$refafiliados.",fechacrea = '".$fechacrea."',usuariocrea = '".$usuariocrea."',vigencia = '".$vigencia."',observaciones = '".$observaciones."' where idcomercioinicio =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarComercioinicio($id) {
      $sql = "delete from dbcomercioinicio where idcomercioinicio =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerComercioinicio() {
      $sql = "select
      c.idcomercioinicio,
      c.token,
      c.comtotal,
      c.comcurrency,
      c.comaddres,
      c.comorderid,
      c.commerchant,
      c.comstore,
      c.comterm,
      c.comdigest,
      c.urlback,
      c.reforigencomercio,
      c.refestadotransaccion,
      c.refafiliados,
      c.fechacrea,
      c.usuariocrea,
      c.vigencia,
      c.observaciones
      from dbcomercioinicio c
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerComercioinicioPorId($id) {
      $sql = "select idcomercioinicio,token,comtotal,comcurrency,comaddres,comorderid,commerchant,comstore,comterm,comdigest,urlback,reforigencomercio,refestadotransaccion,refafiliados,fechacrea,usuariocrea,vigencia,observaciones from dbcomercioinicio where idcomercioinicio =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbcomercioinicio*/


   /* PARA Afiliados */

   function insertarAfiliados($razonsocial,$key,$numeroafiliado) {
   $sql = "insert into tbafiliados(idafiliado,razonsocial,key,numeroafiliado)
   values ('','".$razonsocial."','".$key."','".$numeroafiliado."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarAfiliados($id,$razonsocial,$key,$numeroafiliado) {
   $sql = "update tbafiliados
   set
   razonsocial = '".$razonsocial."',key = '".$key."',numeroafiliado = '".$numeroafiliado."'
   where idafiliado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarAfiliados($id) {
   $sql = "delete from tbafiliados where idafiliado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerAfiliados() {
   $sql = "select
   a.idafiliado,
   a.razonsocial,
   a.key,
   a.numeroafiliado
   from tbafiliados a
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerAfiliadosPorId($id) {
   $sql = "select idafiliado,razonsocial,key,numeroafiliado from tbafiliados where idafiliado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbafiliados*/


   /* PARA Origencomercio */

   function insertarOrigencomercio($origencomercio) {
   $sql = "insert into tborigencomercio(idorigencomercio,origencomercio)
   values ('','".$origencomercio."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarOrigencomercio($id,$origencomercio) {
   $sql = "update tborigencomercio
   set
   origencomercio = '".$origencomercio."'
   where idorigencomercio =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarOrigencomercio($id) {
   $sql = "delete from tborigencomercio where idorigencomercio =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerOrigencomercio() {
   $sql = "select
   o.idorigencomercio,
   o.origencomercio
   from tborigencomercio o
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerOrigencomercioPorId($id) {
   $sql = "select idorigencomercio,origencomercio from tborigencomercio where idorigencomercio =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tborigencomercio*/


   /* PARA Estadotransaccion */

   function insertarEstadotransaccion($estadotransaccion) {
   $sql = "insert into tbestadotransaccion(idestadotransaccion,estadotransaccion)
   values ('','".$estadotransaccion."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarEstadotransaccion($id,$estadotransaccion) {
   $sql = "update tbestadotransaccion
   set
   estadotransaccion = '".$estadotransaccion."'
   where idestadotransaccion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarEstadotransaccion($id) {
   $sql = "delete from tbestadotransaccion where idestadotransaccion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEstadotransaccion() {
   $sql = "select
   e.idestadotransaccion,
   e.estadotransaccion
   from tbestadotransaccion e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEstadotransaccionPorId($id) {
   $sql = "select idestadotransaccion,estadotransaccion from tbestadotransaccion where idestadotransaccion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbestadotransaccion*/


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
