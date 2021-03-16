<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Mexico_City');

class ServiciosReferencias {

   function traerCotizacionesFiltros($busqueda,$filtro) {

      $cadRolPorRama = '';
      if ($_SESSION['idroll_sahilices'] == 20) {
         $cadRolPorRama = ' and tr.idtipoproductorama = 8 ';
      }
      if ($_SESSION['idroll_sahilices'] == 21) {
         $cadRolPorRama = ' and tr.idtipoproductorama = 7 ';
      }
      if ($_SESSION['idroll_sahilices'] == 22) {
         $cadRolPorRama = ' and tr.idtipoproductorama = 8 ';
      }

      $sql = "select
   		c.idcotizacion,
         concat( cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as clientesolo,
         pro.producto,
   		concat( ase.apellidopaterno, ' ', ase.nombre) as asesor,
         c.fechacrea,
         c.folio,
         (case when ec.idestadocotizacion=26 then 'Aceptadas'
               when ec.idestadocotizacion=11 then 'Rechazadas' else est.etapacotizacion end) as estado,
         c.refestados,
         ec.idestadocotizacion
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos pro ON pro.idproducto = c.refproductos
      inner join tbtipoproductorama tr on tr.idtipoproductorama = pro.reftipoproductorama ".$cadRolPorRama."
		inner join dbasesores ase ON ase.idasesor = c.refasesores
      inner join tbestadocotizaciones ec on ec.idestadocotizacion = c.refestadocotizaciones
      left join dbasociados aso ON aso.idasociado = c.refasociados
      left join tbetapacotizacion est ON est.idetapacotizacion = c.refestados
      where (concat( cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%' or concat( ase.apellidopaterno, ' ', ase.nombre) like '%".$busqueda."%' or c.fechacrea like '%".$busqueda."%' or c.folio like '%".$busqueda."%' or est.etapacotizacion like '%".$busqueda."%') ".$filtro." limit 40";

      $res = array($this->query($sql,0) , $this->query($sql,0));
      return $res;
   }

   /* PARA Tipomoneda */

   function insertarTipomoneda($tipomoneda) {
      $sql = "insert into tbtipomoneda(idtipomoneda,tipomoneda)
      values ('','".$tipomoneda."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTipomoneda($id,$tipomoneda) {
      $sql = "update tbtipomoneda
      set
      tipomoneda = '".$tipomoneda."'
      where idtipomoneda =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTipomoneda($id) {
      $sql = "delete from tbtipomoneda where idtipomoneda =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipomoneda() {
      $sql = "select
      t.idtipomoneda,
      t.tipomoneda
      from tbtipomoneda t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipomonedaPorId($id) {
      $sql = "select idtipomoneda,tipomoneda from tbtipomoneda where idtipomoneda =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtipomoneda*/


   function traerCobrosTransferenciasPorAsesorAjax($length, $start, $busqueda,$colSort,$colSortDir,$idasesor) {
      $where = '';

      $cadAsesor = ' and ase.idasesor = '.$idasesor.' ';

      $busqueda = str_replace("'","",$busqueda);
      if ($busqueda != '') {
         $where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%')";
      }


      $sql = "select
                  p.idperiodicidadventadetalle,
                  (case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
                  ve.nropoliza,
                  p.fechavencimiento,
                  p.nrorecibo,
                  est.estadopago,
                  p.montototal,
                  p.primaneta,
                  p.porcentajecomision,
                  p.montocomision,
                  p.fechapago,
                  est.estadopago,
                  ea.estadoasesor,
                  p.refestadopago,
                  p.usuariocrea,
                  p.usuariomodi,
                  p.fechacrea,
                  p.fechamodi,
                  p.refperiodicidadventas
      from dbperiodicidadventasdetalle p
      inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
      inner join dbventas ve ON ve.idventa = per.refventas
        inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
        inner join dbclientes cli on cli.idcliente = co.refclientes
        inner join dbasesores ase on ase.idasesor = co.refasesores
        inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
      inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
      inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
      inner join tbestadopago est ON est.idestadopago = p.refestadopago

        where p.refestadopago in (1,3) ".$cadAsesor.$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
      $limit = "limit ".$start.",".$length;

      //die(var_dump($sql));

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
      return $res;
   }


/* PARA Transferencias */

function insertarTransferencias($nrotransferencia,$monto,$fechatransaccion,$fechacrea,$usuariocrea,$observaciones) {
$sql = "insert into dbtransferencias(idtransferencia,nrotransferencia,monto,fechatransaccion,fechacrea,usuariocrea,observaciones)
values ('','".$nrotransferencia."',".$monto.",'".$fechatransaccion."','".$fechacrea."','".$usuariocrea."','".$observaciones."')";
$res = $this->query($sql,1);
return $res;
}


function modificarTransferencias($id,$nrotransferencia,$monto,$fechatransaccion,$fechacrea,$usuariocrea,$observaciones) {
$sql = "update dbtransferencias
set
nrotransferencia = '".$nrotransferencia."',monto = ".$monto.",fechatransaccion = '".$fechatransaccion."',fechacrea = '".$fechacrea."',usuariocrea = '".$usuariocrea."',observaciones = '".$observaciones."'
where idtransferencia =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTransferencias($id) {
$sql = "delete from dbtransferencias where idtransferencia =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTransferencias() {
$sql = "select
t.idtransferencia,
t.nrotransferencia,
t.monto,
t.fechatransaccion,
t.fechacrea,
t.usuariocrea,
t.observaciones
from dbtransferencias t
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTransferenciasPorId($id) {
$sql = "select idtransferencia,nrotransferencia,monto,fechatransaccion,fechacrea,usuariocrea,observaciones from dbtransferencias where idtransferencia =".$id;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* /* Fin de la Tabla: dbtransferencias*/



/* PARA Transferenciarecibos */

function insertarTransferenciarecibos($reftransferencias,$refrecibos,$monto,$completo) {
$sql = "insert into dbtransferenciarecibos(idtransferenciarecibo,reftransferencias,refrecibos,monto,completo)
values ('',".$reftransferencias.",".$refrecibos.",".$monto.",'".$completo."')";
$res = $this->query($sql,1);
return $res;
}


function modificarTransferenciarecibos($id,$reftransferencias,$refrecibos,$monto,$completo) {
$sql = "update dbtransferenciarecibos
set
reftransferencias = ".$reftransferencias.",refrecibos = ".$refrecibos.",monto = ".$monto.",completo = '".$completo."'
where idtransferenciarecibo =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTransferenciarecibos($id) {
$sql = "delete from dbtransferenciarecibos where idtransferenciarecibo =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTransferenciarecibos() {
$sql = "select
t.idtransferenciarecibo,
t.reftransferencias,
t.refrecibos,
t.monto,
t.completo
from dbtransferenciarecibos t
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTransferenciarecibosPorId($id) {
$sql = "select idtransferenciarecibo,reftransferencias,refrecibos,monto,completo from dbtransferenciarecibos where idtransferenciarecibo =".$id;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* /* Fin de la Tabla: dbtransferenciarecibos*/

   /* PARA Eventos */


   function insertarEventos($ico,$nombre,$ponderacion,$tiempo,$refevento,$reftabla,$idreferencia,$principal,$enviaemailagestion,$enviaemailaagente,$enviaemailainbursa,$activo) {
   $sql = "insert into tbeventos(idevento,ico,nombre,ponderacion,tiempo,refevento,reftabla,idreferencia,principal,enviaemailagestion,enviaemailaagente,enviaemailainbursa,activo)
   values ('','".$ico."','".$nombre."',".$ponderacion.",".$tiempo.",".$refevento.",".$reftabla.",".$idreferencia.",'".$principal."','".$enviaemailagestion."','".$enviaemailaagente."','".$enviaemailainbursa."','".$activo."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarEventos($id,$ico,$nombre,$ponderacion,$tiempo,$refevento,$reftabla,$idreferencia,$principal,$enviaemailagestion,$enviaemailaagente,$enviaemailainbursa,$activo) {
   $sql = "update tbeventos
   set
   ico = '".$ico."',nombre = '".$nombre."',ponderacion = ".$ponderacion.",tiempo = ".$tiempo.",refevento = ".$refevento.",reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",principal = '".$principal."',enviaemailagestion = '".$enviaemailagestion."',enviaemailaagente = '".$enviaemailaagente."',enviaemailainbursa = '".$enviaemailainbursa."',activo = '".$activo."'
   where idevento =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarEventos($id) {
   $sql = "delete from tbeventos where idevento =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEventos() {
   $sql = "select
   e.idevento,
   e.ico,
   e.nombre,
   e.ponderacion,
   e.tiempo,
   e.refevento,
   e.reftabla,
   e.idreferencia,
   e.principal,
   e.enviaemailagestion,
   e.enviaemailaagente,
   e.enviaemailainbursa,
   e.activo
   from tbeventos e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEventosPorId($id) {
   $sql = "select idevento,ico,nombre,ponderacion,tiempo,refevento,reftabla,idreferencia,principal,enviaemailagestion,enviaemailaagente,enviaemailainbursa,activo from tbeventos where idevento =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerEventosPorReferencia($idtabla, $tabla, $idnombre, $id) {
      $sql = "select
         c.idevento,c.ico,c.nombre,c.ponderacion,c.tiempo,c.refevento,c.reftabla,c.idreferencia,c.principal,c.enviaemailagestion,c.enviaemailaagente,c.enviaemailainbursa,c.activo
      from tbeventos c
      inner join ".$tabla." v on v.".$idnombre." = c.idreferencia
		where c.reftabla = ".$idtabla." and c.idreferencia = ".$id;

      $res = $this->query($sql,0);
      return $res;
   }



   /* Fin */
   /* /* Fin de la Tabla: tbeventos*/
   /* PARA Trazabilidad */


   function insertarTrazabilidad($reftabla,$idreferencia,$fechacrea,$refevento,$usuariocrea,$idreferenciaaux1,$idreferenciaaux2,$idreferenciaaux3,$dato,$url) {

      $resEvento = $this->traerEventosPorId($refevento);

      if (mysql_num_rows($resEvento)>0) {
         if (mysql_result($resEvento,0,'activo') == '1') {
            $sql = "insert into dbtrazabilidad(idtrazabilidad,reftabla,idreferencia,fechacrea,refevento,usuariocrea,idreferenciaaux1,idreferenciaaux2,idreferenciaaux3,dato,url)
            values ('',".$reftabla.",".$idreferencia.",'".$fechacrea."',".$refevento.",'".$usuariocrea."',".$idreferenciaaux1.",".$idreferenciaaux2.",".$idreferenciaaux3.",'".$dato."','".$url."')";
            $res = $this->query($sql,1);

            if (((integer)$res > 0) && ($reftabla==12) && ((mysql_result($resEvento,0,'enviaemailagestion') == '1') || ($url != ''))) {
               $resMensaje = $this->enviarEmailModificacionCotizacion($idreferencia,mysql_result($resEvento,0,'nombre').' - '.$dato,$url);
            }
         } else {
            $res = 0;
         }
      } else {
         $res = 0;
      }





      return $res;
   }


   function modificarTrazabilidad($id,$reftabla,$idreferencia,$fechacrea,$refevento,$usuariocrea,$idreferenciaaux1,$idreferenciaaux2,$idreferenciaaux3,$dato,$url) {
      $sql = "update dbtrazabilidad
      set
      reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",fechacrea = '".$fechacrea."',refevento = ".$refevento.",usuariocrea = '".$usuariocrea."',idreferenciaaux1 = ".$idreferenciaaux1.",idreferenciaaux2 = ".$idreferenciaaux2.",idreferenciaaux3 = ".$idreferenciaaux3.",dato = '".$dato."',url = '".$url."'
      where idtrazabilidad =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTrazabilidad($id) {
      $sql = "delete from dbtrazabilidad where idtrazabilidad =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTrazabilidad() {
      $sql = "select
      t.idtrazabilidad,
      t.reftabla,
      t.idreferencia,
      t.fechacrea,
      t.refevento,
      t.usuariocrea,
      t.idreferenciaaux1,
      t.idreferenciaaux2,
      t.idreferenciaaux3,
      t.dato,
      t.url
      from dbtrazabilidad t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTrazabilidadPorCotizacion($id) {
      $sql = "select
      t.idtrazabilidad,
      t.reftabla,
      t.idreferencia,
      t.fechacrea,
      t.refevento,
      t.usuariocrea,
      t.idreferenciaaux1,
      t.idreferenciaaux2,
      t.idreferenciaaux3,
      t.dato,
      t.url,
      tt.ico,
      tt.nombre
      from dbtrazabilidad t
      inner join tbeventos tt on tt.idevento = t.refevento
      where t.reftabla=12 and t.idreferencia = ".$id."
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTrazabilidadPorId($id) {
      $sql = "select idtrazabilidad,reftabla,idreferencia,fechacrea,refevento,usuariocrea,idreferenciaaux1,idreferenciaaux2,idreferenciaaux3,dato,url from dbtrazabilidad where idtrazabilidad =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbtrazabilidad*/

   /* PARA Contactosperfiles */

   function insertarContactosperfiles($refroles,$refusuarios,$email,$nombrecompleto,$telefono) {
      $sql = "insert into dbcontactosperfiles(idcontactoperfil,refroles,refusuarios,email,nombrecompleto,telefono)
      values ('',".$refroles.",".$refusuarios.",'".$email."','".$nombrecompleto."','".$telefono."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarContactosperfiles($id,$refroles,$refusuarios,$email,$nombrecompleto,$telefono) {
      $sql = "update dbcontactosperfiles
      set
      refroles = ".$refroles.",refusuarios = ".$refusuarios.",email = '".$email."',nombrecompleto = '".$nombrecompleto."',telefono = '".$telefono."'
      where idcontactoperfil =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarContactosperfiles($id) {
      $sql = "delete from dbcontactosperfiles where idcontactoperfil =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerContactosperfiles() {
      $sql = "select
      c.idcontactoperfil,
      c.refroles,
      c.refusuarios,
      c.email,
      c.nombrecompleto,
      c.telefono
      from dbcontactosperfiles c
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerContactosperfilesPorRol($idrol) {
      $sql = "select
      c.idcontactoperfil,
      c.refroles,
      c.refusuarios,
      c.email,
      c.nombrecompleto,
      c.telefono
      from dbcontactosperfiles c
      where c.refroles = ".$idrol."
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerContactosperfilesPorUsuario($idusuario) {
      $sql = "select
      c.idcontactoperfil,
      c.refroles,
      c.refusuarios,
      c.email,
      c.nombrecompleto,
      c.telefono
      from dbcontactosperfiles c
      where c.refusuarios = ".$idusuario."
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerContactosUsuarioAjax($length, $start, $busqueda,$colSort,$colSortDir, $refrol,$idusuario) {

      $where = '';

      $busqueda = str_replace("'","",$busqueda);
      if ($busqueda != '') {
         $where = " and c.email like '%".$busqueda."%' or c.nombrecompleto like '%".$busqueda."%' or c.telefono like '%".$busqueda."%'";
      }


      $sql = "select
      c.idcontactoperfil,
      r.descripcion as rol,
      u.nombrecompleto as usuario,
      c.email,
      c.nombrecompleto,
      c.telefono,
      c.refroles,
      c.refusuarios
      from dbcontactosperfiles c
      left join tbroles r on r.idrol = c.refroles
      left join dbusuarios u on u.idusuario = c.refusuarios
      where (c.refroles = ".$refrol." or c.refusuarios = ".$idusuario.") ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
      $limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
      return $res;

   }


   function traerContactosperfilesPorId($id) {
      $sql = "select idcontactoperfil,refroles,refusuarios,email,nombrecompleto,telefono from dbcontactosperfiles where idcontactoperfil =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbcontactosperfiles*/

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

   // ahora va a depender de la tabla de productos, quien lo gestiona
   function devolverRolPorRamaProducto($idramaproducto) {
      $idrol = 0;
      switch ($idramaproducto) {
         case 8:
            $idrol = 20;
         break;
         case 7:
            $idrol = 21;
         break;

      }

      return $idrol;
   }


   function traerUsuariosPorRoles($idrol) {
      $sql = "select u.email, u.idusuario from dbusuarios u where u.refroles =".$idrol;
      $res = $this->query($sql,0);

      return $res;
   }

   function existeUsuarioSistema($email) {
      $sql = "select idusuario from dbusuarios where email = '".$email."' and activo = 1 and refroles not in (16,19)";

      $res = $this->query($sql,0);

      if (mysql_num_rows($res) > 0) {
         return 1;
      }

      return 0;
   }

   function enviarEmailModificacionCotizacion($id,$dato,$adcional,$enviaEmail=1) {

      $resCotizaciones = $this->traerCotizacionesPorIdCompleto($id);

      //determino el producto para avisar a quien corresponda, por ahora solo para los roles de areas tecnicas y sus contactos
      $refproductos = mysql_result($resCotizaciones,0,'refproductos');

      $resProduto = $this->traerProductosPorId($refproductos);

      $idrol = mysql_result($resProduto,0,'refgestion');

      $resUsuarios = $this->traerUsuariosPorRoles($idrol);
      $resContactos = $this->traerContactosperfilesPorRol($idrol);

      $cadDestino = '';

      while ($rowU = mysql_fetch_array($resUsuarios)) {
         $pos = strpos($cadDestino, $rowU['email']);
         if (($rowU['email'] != '') && ($pos === false)) {
            $cadDestino .= $rowU['email'].', ';
         }
      }

      while ($rowC = mysql_fetch_array($resUsuarios)) {
         $pos = strpos($cadDestino, $rowC['email']);
         if (($rowC['email'] != '') && ($pos === false)) {
            $cadDestino .= $rowC['email'].', ';
         }
      }

      if ($adcional != '') {
         $cadDestino = $adcional.', ';
      }


      ////// fin ////////////////////////////

      if ($cadDestino != '') {

         if ($this->existeUsuarioSistema($adcional) == 1) {
            // por ahora nada mas
            $token = $this->GUID();
            $resAutoLogin = $this->insertarAutologin(261,$token,'engestion/modificar.php?id='.$id,'0');
         }

         $asunto = 'Alerta Cotización, cotización: folio: '.mysql_result($resCotizaciones,0,'folio').' - Agente: '.mysql_result($resCotizaciones,0,'asesor');

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

         $cuerpo .= $dato;

         if ($adcional == '') {
            $cuerpo .= '<p>Haga click <a href="https://asesorescrea.com/desarrollo/crm/alogin.php?token='.$token.'">AQUI</a> para acceder</p>';
         }

         $cuerpo .= '</body>';

         if ($enviaEmail==1) {
            $exito = $this->enviarEmail(substr($cadDestino,0,-2), utf8_decode( $asunto),utf8_decode($cuerpo));
         } else {
            $exito = $this->enviarEmail(substr($cadDestino,0,-2), utf8_decode( $asunto),utf8_decode($cuerpo));
         }


         $gestor = fopen('logemails'.date('Y_m_d_H_i_s').'.txt', 'w');
         fwrite($gestor, $cadDestino.' '.date('Y-m-d H:i:s'));
         fclose($gestor);

         return '';
      }

   }

   function switchCotizacion($idestado, $tipo, $id) {
      $url = '';

      //1 'venta' , 2 'cotizacionagente' , 3 'cobranza'
      if ($tipo == 1) {
         switch ($idestado) {
            case 19:
               $url = 'comercio_fin.php?id='.$id;
            break;
            case 20:
               $url = 'archivos.php?id='.$id;
            break;
            case 19:
               $url = 'documentos.php?id='.$id;
            break;
            case 22:
               $url = 'comprobantepago.php?id='.$id;
            break;
         }
      }

      if ($tipo == 2) {
         switch ($idestado) {
            case 19:
               $url = 'comercio_fin.php?id='.$id;
            break;
            case 20:
               $url = 'archivos.php?id='.$id;
            break;
            case 19:
               $url = 'documentos.php?id='.$id;
            break;
            case 22:
               $url = 'comprobantepago.php?id='.$id;
            break;
         }
      }

      if ($tipo == 3) {
         switch ($idestado) {
            case 19:
               $url = 'comercio_fin.php?id='.$id;
            break;
            case 20:
               $url = 'archivos.php?id='.$id;
            break;
            case 19:
               $url = 'documentos.php?id='.$id;
            break;
            case 22:
               $url = 'comprobantepago.php?id='.$id;
            break;
         }
      }

      return $url;
   }

   function traerComercioinicioPorReferencia($idtabla, $tabla, $idnombre, $id) {
      $sql = "select c.idcomercioinicio,c.token,c.comtotal,c.comcurrency,c.comaddres,c.comorderid,c.commerchant,c.comstore,c.comterm,c.comdigest,c.urlback,c.reforigencomercio,c.refestadotransaccion,c.refafiliados,c.fechacrea,c.usuariocrea,c.vigencia,c.observaciones,c.fechamodi,c.usuariomodi,c.nrocomprobante,c.reftabla,c.idreferencia from dbcomercioinicio c
      inner join ".$tabla." v on v.".$idnombre." = c.idreferencia
		where c.reftabla = ".$idtabla." and c.idreferencia = ".$id;

      $res = $this->query($sql,0);
      return $res;
   }

   function verificarCondicionDelPagoEnLinea($id) {

      $res = $this->traerCotizacionesPorIdCompleto($id);

      $idestado = mysql_result($res,0,'refestadocotizaciones');

      // estado 19, en proceso de pago
      if ($idestado == 19) {

         // busco el inicio del comercio
         $resCI = $this->traerComercioinicioPorReferencia(12, 'dbcotizaciones', 'idcotizacion', $id);
         // si existe, veo su estado
         if (mysql_num_rows($resCI) > 0) {
            // estado 2 pagado
            if (mysql_result($resCI,0,'refestadotransaccion') == 2) {
               return array('error'=>true,'url'=>'comercio_fin.php?id='.$id);
            } else {
               return array('error'=>false,'url'=>'comercio_fin.php?id='.$id);
            }
         }
         return array('error'=>true,'url'=>'comercio_fin.php?id='.$id);
      } else {
         $urlSwicth = $this->switchCotizacion($idestado,1,$id);
         return array('error'=>true,'url'=>$$urlSwicth);
      }
   }

   function modificaEstadoCotizacionAutomatico($idcotizacion, $idestado, $usuario) {

      $id = $idcotizacion;
      $idestado = $idestado;

      // trai los valores del estado a modificar
      $resEstado = $this->traerEstadocotizacionesPorId($idestado);

      // verifico si me genera un cambio automatico y si finaliza
      if ((mysql_result($resEstado,0,'generaestado') > 0) && (mysql_result($resEstado,0,'finaliza') == '1')) {
         // obtengo la nueva etapa
         $resEstadoNuevo = $this->traerEstadocotizacionesPorId(mysql_result($resEstado,0,'generaestado'));

         // modifico el estado de la cotizacion
         $resModEstadoCot = $this->modificarCotizacionesPorCampo($id,'refestadocotizaciones',mysql_result($resEstado,0,'generaestado'), $usuario);

         // modifico la etapa
         $resModEstadoEtapa = $this->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstadoNuevo,0,'refetapacotizacion'), $usuario);

         $mensaje = 'SE MODIFICO CORRECTAMENTE';
      } else {
         if  (mysql_result($resEstado,0,'renueva') == '1') {
            // modifico el estado de la cotizacion
            $resModEstadoCot = $this->modificarCotizacionesPorCampo($id,'refestadocotizaciones',$idestado, $usuario);

            // modifico la etapa
            $resModEstadoEtapa = $this->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstado,0,'refetapacotizacion'), $usuario);

            $mensaje = 'SE MODIFICO CORRECTAMENTE';
         } else {
            // modifico la etapa
            $resModEstadoEtapa = $this->modificarCotizacionesPorCampo($id,'refestados',mysql_result($resEstado,0,'refetapacotizacion'), $usuario);

            $mensaje = 'SE MODIFICO CORRECTAMENTE';
         }

      }


      if ($resModEstadoEtapa) {
         $resV['error'] = false;
         $resV['mensaje'] = $mensaje;
         $resV['tipo'] = 'success';
      } else {
         $resV['error'] = true;
         $resV['mensaje'] = 'Se genero un error por favor vuelva a intentarlo';
         $resV['tipo'] = 'danger';
      }


      return $resV;

   }

   /* PARA Tokenasesores */

   function insertarTokenasesores($token,$refasesores,$refclientes,$generousuario,$fechacrea,$vigencia,$activo,$accion,$tipoaccion,$refestados,$refusuarios) {
      $sql = "insert into dbtokenasesores(idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios)
      values ('','".$token."',".$refasesores.",".$refclientes.",'".$generousuario."','".$fechacrea."','".$vigencia."','".$activo."','".$accion."','".$tipoaccion."',".$refestados.",".$refusuarios.")";
      $res = $this->query($sql,1);
      return $res;
   }

   function copiaTokenDeToken($token, $tokenNuevo) {

      $fecha_actual = date("d-m-Y");
      //sumo 30 días
      $vigencia = date("Y-m-d",strtotime($fecha_actual."+ 30 days"));

      $sql = "INSERT INTO dbtokenasesores
               (idtokenasesor,
               token,
               refasesores,
               refclientes,
               generousuario,
               fechacrea,
               vigencia,
               activo,
               accion,
               tipoaccion,
               refestados,
               refusuarios)
               SELECT '',
                   "."'".$tokenNuevo."'".",
                   refasesores,
                   refclientes,
                   generousuario,
                   now(),
                   "."'".$vigencia."'".",
                   '1',
                   'cotizacionagente/new.php?producto=46',
                   '2',
                   1,
                   refusuarios
               FROM dbtokenasesores where token = '".$token."'";

      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTokenasesores($id,$token,$refasesores,$refclientes,$generousuario,$fechacrea,$vigencia,$activo,$accion,$tipoaccion,$refestados,$refusuarios) {
      $sql = "update dbtokenasesores
      set
      token = '".$token."',refasesores = ".$refasesores.",refclientes = ".$refclientes.",generousuario = '".$generousuario."',fechacrea = '".$fechacrea."',vigencia = '".$vigencia."',activo = '".$activo."',accion = '".$accion."',tipoaccion = '".$tipoaccion."',refestados = ".$refestados.",refusuarios = ".$refusuarios."
      where idtokenasesor =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarTokenasesoresParcial($token,$refusuarios) {
      $sql = "update dbtokenasesores
      set
      generousuario = '1',activo = '0',refusuarios = ".$refusuarios."
      where token = '".$token."'";
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarTokenasesoresEstado($token,$refestados) {
      $sql = "update dbtokenasesores
      set
      refestados = ".$refestados."
      where token = '".$token."'";
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarTokenasesoresAccion($token,$accion) {
      $sql = "update dbtokenasesores
      set
      accion = '".$accion."'
      where token = '".$token."'";
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTokenasesores($id) {
      $sql = "delete from dbtokenasesores where token = '".$id."'";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTokenasesoresajax($length, $start, $busqueda,$colSort,$colSortDir, $idasesor) {

      $where = '';

      $busqueda = str_replace("'","",$busqueda);
      if ($busqueda != '') {
         $where = " and concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or (case when t.tipoaccion = '1' then 'Pago de Recibo' else 'Cotizacion' end) like '%".$busqueda."%' or (case when t.refestados = 1 then 'Iniciado' else 'Completo' end) like '%".$busqueda."%' or concat('https://asesorescrea.com/desarrollo/crm/token.php?token=',t.token) like '%".$busqueda."%'";
      }

      //http://localhost/asesorescrea_nuevo.git/trunk/crm/dashboard/
      //https://asesorescrea.com/desarrollo/crm/dashboard/
      $sql = "select
      t.token,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
      (case when t.tipoaccion = '1' then 'Pago de Recibo' else 'Cotizacion' end) as tipoaccion,
      concat('https://asesorescrea.com/desarrollo/crm/token.php?token=',t.token) as accion,
      t.fechacrea,
      (case when t.refestados = 1 then 'Iniciado' else 'Completo' end) as estado,
      t.vigencia,
      t.activo,
      t.refestados,
      t.refasesores,
      t.refclientes,
      t.generousuario,
      t.refusuarios
      from dbtokenasesores t
      inner join dbclientes cli ON cli.idcliente = t.refclientes
      where t.refasesores = ".$idasesor." ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
      $limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
      return $res;
   }

   function traerTokenasesores() {
      $sql = "select
      t.idtokenasesor,
      t.token,
      t.refasesores,
      t.refclientes,
      t.generousuario,
      t.fechacrea,
      t.vigencia,
      t.activo,
      t.accion,
      t.tipoaccion,
      t.refestados,
      t.refusuarios
      from dbtokenasesores t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTokenasesoresPorId($id) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios from dbtokenasesores where idtokenasesor =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokenasesoresPorToken($token) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios from dbtokenasesores where token = '".$token."'";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokenasesoresPorTokenActivo($token) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios from dbtokenasesores where token = '".$token."' and now() <= vigencia ";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokenasesoresPorAsesor($id) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios from dbtokenasesores where refasesores =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokenasesoresPorCliente($id) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios from dbtokenasesores where refclientes =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokenasesoresPorClienteActivoTipo($id,$tipo) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,
      vigencia,activo,accion,tipoaccion,refestados,refusuarios , (case when tipoaccion = '1' then 'Pagar Recibo' else 'Cotizacion' end) descripcion
      from dbtokenasesores where refclientes =".$id." and tipoaccion ='".$tipo."'";
      $res = $this->query($sql,0);
      return $res;
   }

   function existeTokenAsesores($refasesores,$refclientes) {
      $sql = "select idtokenasesor,token,refasesores,refclientes,generousuario,fechacrea,vigencia,activo,accion,tipoaccion,refestados,refusuarios from dbtokenasesores where refclientes =".$refclientes." and refasesores =".$refasesores." and generousuario = '1'";

      $res = $this->query($sql,0);

      if (mysql_num_rows($res) > 0) {
         return mysql_result($res,0,'refusuarios');
      }

      return 0;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbtokenasesores*/



   /* PARA Ventacontactos */

   function insertarVentacontactos($refventas,$apellidopaterno,$apellidomaterno,$nombre,$telefonofijo,$telefonocelular,$email,$titular) {
      $sql = "insert into dbventacontactos(idventacontacto,refventas,apellidopaterno,apellidomaterno,nombre,telefonofijo,telefonocelular,email,titular)
      values ('',".$refventas.",'".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$telefonofijo."','".$telefonocelular."','".$email."','".$titular."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarVentacontactos($id,$refventas,$apellidopaterno,$apellidomaterno,$nombre,$telefonofijo,$telefonocelular,$email,$titular) {
      $sql = "update dbventacontactos
      set
      refventas = ".$refventas.",apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',telefonofijo = '".$telefonofijo."',telefonocelular = '".$telefonocelular."',email = '".$email."',titular = '".$titular."'
      where idventacontacto =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarVentacontactos($id) {
      $sql = "delete from dbventacontactos where idventacontacto =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerVentacontactosajax($length, $start, $busqueda,$colSort,$colSortDir,$idventa) {



		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(v.apellidopaterno, ' ', v.apellidomaterno, ' ', v.nombre) like '%".$busqueda."%' or ve.poliza like '%".$busqueda."%' or v.telefonofijo like '%".$busqueda."%' or v.telefonocelular like '%".$busqueda."%' or v.email like '%".$busqueda."%' or (case when v.titular = '1' then 'Si' else 'No' end) like '%".$busqueda."%')";
		}


		$sql = "select
      v.idventacontacto,
      ve.nropoliza,
      v.apellidopaterno,
      v.apellidomaterno,
      v.nombre,
      v.telefonofijo,
      v.telefonocelular,
      v.email,
      (case when v.titular = '1' then 'Si' else 'No' end) as titular,
      v.refventas
      from dbventacontactos v
      inner join dbventas ve on ve.idventa = v.refventas or ve.refventas = v.refventas
		where v.refventas = ".$idventa." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerVentacontactos() {
      $sql = "select
      v.idventacontacto,
      v.refventas,
      v.apellidopaterno,
      v.apellidomaterno,
      v.nombre,
      v.telefonofijo,
      v.telefonocelular,
      v.email,
      v.titular
      from dbventacontactos v
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerVentacontactosPorId($id) {
      $sql = "select idventacontacto,refventas,apellidopaterno,apellidomaterno,nombre,telefonofijo,telefonocelular,email,titular from dbventacontactos where idventacontacto =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerVentacontactosPorVenta($id) {
      $sql = "select vc.idventacontacto,vc.refventas,vc.apellidopaterno,vc.apellidomaterno,vc.nombre,vc.telefonofijo,vc.telefonocelular,vc.email,vc.titular
      from dbventacontactos vc
      inner join dbventas v on v.idventa = vc.refventas or v.refventas = vc.refventas
      where vc.refventas =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerVentacontactosPorVentaActivo($id) {
      $sql = "select vc.idventacontacto,vc.refventas,vc.apellidopaterno,vc.apellidomaterno,vc.nombre,vc.telefonofijo,vc.telefonocelular,vc.email,vc.titular
      from dbventacontactos vc
      inner join dbventas v on v.idventa = vc.refventas or v.refventas = vc.refventas
      where vc.refventas =".$id." and vc.titular='1'";
      $res = $this->query($sql,0);
      return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: dbventacontactos*/

   /* PARA Etapacotizacion */

   function insertarEtapacotizacion($etapacotizacion) {
   $sql = "insert into tbetapacotizacion(idetapacotizacion,etapacotizacion)
   values ('','".$etapacotizacion."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarEtapacotizacion($id,$etapacotizacion) {
   $sql = "update tbetapacotizacion
   set
   etapacotizacion = '".$etapacotizacion."'
   where idetapacotizacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarEtapacotizacion($id) {
   $sql = "delete from tbetapacotizacion where idetapacotizacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEtapacotizacion() {
   $sql = "select
   e.idetapacotizacion,
   e.etapacotizacion
   from tbetapacotizacion e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEtapacotizacionPorId($id) {
   $sql = "select idetapacotizacion,etapacotizacion from tbetapacotizacion where idetapacotizacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbetapacotizacion*/

   function devolverEntidadNacimientoPorCURP($curp, $estado='') {
      $error = false;

      if ($curp == '') {
         return $estado;
      } else {
         if (strlen($curp) < 18) {
            return $estado;
         } else {
            $resEN = $this->traerEntidadnacimientoPorCodigo(substr($curp,11,2));
            if (mysql_num_rows($resEN)>0) {
               return mysql_result($resEN,0,0);
            } else {
               return $estado;
            }
         }
      }
   }

   function traerEntidadnacimientoPorCodigo($codigo) {
      $sql = "select entidadnacimiento from tbcodigoentidadnacimiento where codigo = '".$codigo."'";
      $res = $this->query($sql,0);

      return $res;
   }

   /* PARA Tipoidentificacion */

   function insertarTipoidentificacion($tipoidentificacion) {
      $sql = "insert into tbtipoidentificacion(idtipoidentificacion,tipoidentificacion)
      values ('','".$tipoidentificacion."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTipoidentificacion($id,$tipoidentificacion) {
      $sql = "update tbtipoidentificacion
      set
      tipoidentificacion = '".$tipoidentificacion."'
      where idtipoidentificacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTipoidentificacion($id) {
      $sql = "delete from tbtipoidentificacion where idtipoidentificacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipoidentificacion() {
      $sql = "select
      t.idtipoidentificacion,
      t.tipoidentificacion
      from tbtipoidentificacion t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipoidentificacionPorId($id) {
      $sql = "select idtipoidentificacion,tipoidentificacion from tbtipoidentificacion where idtipoidentificacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtipoidentificacion*/


   /* PARA Siniestros */

   function insertarSiniestros($refventas,$refestadosiniestro,$monto,$fechasiniestro,$fechaaplicacion) {
      if ($fechaaplicacion == '') {
         $sql = "insert into dbsiniestros(idsiniestro,refventas,refestadosiniestro,monto,fechasiniestro,fechaaplicacion)
         values ('',".$refventas.",".$refestadosiniestro.",".$monto.",'".$fechasiniestro."',NULL)";
         $res = $this->query($sql,1);
         return $res;
      } else {
         $sql = "insert into dbsiniestros(idsiniestro,refventas,refestadosiniestro,monto,fechasiniestro,fechaaplicacion)
         values ('',".$refventas.",".$refestadosiniestro.",".$monto.",'".$fechasiniestro."','".$fechaaplicacion."')";
         $res = $this->query($sql,1);
         return $res;
      }

   }


   function modificarSiniestros($id,$refventas,$refestadosiniestro,$monto,$fechasiniestro,$fechaaplicacion) {
      if ($fechaaplicacion == '') {
         $sql = "update dbsiniestros
         set
         refventas = ".$refventas.",refestadosiniestro = ".$refestadosiniestro.",monto = ".$monto.",fechasiniestro = '".$fechasiniestro."',fechaaplicacion = NULL
         where idsiniestro =".$id;
      } else {
         $sql = "update dbsiniestros
         set
         refventas = ".$refventas.",refestadosiniestro = ".$refestadosiniestro.",monto = ".$monto.",fechasiniestro = '".$fechasiniestro."',fechaaplicacion = '".$fechaaplicacion."'
         where idsiniestro =".$id;
      }


      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarSiniestros($id) {
   $sql = "delete from dbsiniestros where idsiniestro =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerSiniestrosajax($length, $start, $busqueda,$colSort,$colSortDir,$idestado) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and v.nropoliza like '%".$busqueda."%' or est.estadosiniestro like '%".$busqueda."%' or s.fechasiniestro like '%".$busqueda."%' or s.fechaaplicacion like '%".$busqueda."%' or s.pregunta like '%".$busqueda."%'";
		}


      $sql = "select
      s.idsiniestro,
      v.nropoliza,
      est.estadosiniestro,
      s.monto,
      s.fechasiniestro,
      s.fechaaplicacion,
      s.refventas,
      s.refestadosiniestro
      from dbsiniestros s
      inner join dbventas v on v.idventa = s.refventas
      inner join dbcotizaciones co on co.idcotizacion = v.refcotizaciones
      inner join dbclientes cli on cli.idcliente = co.refclientes
      inner join tbestadosiniestro est ON est.idestadosiniestro = s.refestadosiniestro
      where est.idestadosiniestro in (".$idestado.") ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      //die(var_dump($sql));

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerSiniestros() {
   $sql = "select
   s.idsiniestro,
   s.refventas,
   s.refestadosiniestro,
   s.monto,
   s.fechasiniestro,
   s.fechaaplicacion
   from dbsiniestros s
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerSiniestrosPorId($id) {
   $sql = "select idsiniestro,refventas,refestadosiniestro,monto,fechasiniestro,fechaaplicacion from dbsiniestros where idsiniestro =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbsiniestros*/

   /* PARA Estadosiniestro */

   function insertarEstadosiniestro($estadosiniestro) {
   $sql = "insert into tbestadosiniestro(idestadosiniestro,estadosiniestro)
   values ('','".$estadosiniestro."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarEstadosiniestro($id,$estadosiniestro) {
   $sql = "update tbestadosiniestro
   set
   estadosiniestro = '".$estadosiniestro."'
   where idestadosiniestro =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarEstadosiniestro($id) {
   $sql = "delete from tbestadosiniestro where idestadosiniestro =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEstadosiniestro() {
   $sql = "select
   e.idestadosiniestro,
   e.estadosiniestro
   from tbestadosiniestro e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEstadosiniestroPorId($id) {
   $sql = "select idestadosiniestro,estadosiniestro from tbestadosiniestro where idestadosiniestro =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbestadosiniestro*/

   /* PARA Formapago */

   function insertarFormapago($formapago) {
   $sql = "insert into tbformapago(idformapago,formapago)
   values ('','".$formapago."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarFormapago($id,$formapago) {
   $sql = "update tbformapago
   set
   formapago = '".$formapago."'
   where idformapago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarFormapago($id) {
   $sql = "delete from tbformapago where idformapago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerFormapago() {
   $sql = "select
   f.idformapago,
   f.formapago
   from tbformapago f
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerFormapagoPorId($id) {
   $sql = "select idformapago,formapago from tbformapago where idformapago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbformapago*/

   function alertaRenovacionPolizaCliente($idcliente) {
      $sql = "select cli.refusuarios, usu.email, v.nropoliza, v.fechavencimientopoliza, v.idventa
            from dbventas v
            inner join dbcotizaciones c on c.idcotizacion = v.refcotizaciones
            inner join dbclientes cli on cli.idcliente = c.refclientes
            inner join dbusuarios usu on usu.idusuario = cli.refusuarios
            where cli.idcliente =".$idcliente." and DATEDIFF(v.fechavencimientopoliza,CURDATE()) <= 9 ";

      $res = $this->query($sql,0);

      while ($row = mysql_fetch_array($res)) {
         $existeAlerta = $this->traerAlertasPorTablaReferencia(13,'dbventas','idventa', $row['idventa']);

         if (mysql_num_rows($existeAlerta)<1) {

            $nropoliza = $row['nropoliza'];
            $email = $row['email'];

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

            $cuerpo .= '<h3><small><p>En 5 días se renovara su poliza número: '.$nropoliza.'</small></h3><p>';


         	$cuerpo .='<p> No responda este mensaje, el remitente es una dirección de notificación</p>';

            $cuerpo .= '<p style="font-family: '."'Lato'".', serif; font-size:1.7em;">Saludos cordiales,</p>';

            $cuerpo .= '</body>';

            $resI = $this->insertarAlertas(1,13,$row['idventa'],$row['email'],'Información sobre la Poliza Nro: '.$nropoliza,'1');

            if ((integer)$resI > 0) {
               $retorno = $this->enviarEmail($email,utf8_decode('Información sobre la Poliza Nro: ').$nropoliza,utf8_decode($cuerpo));
            }

            //die(var_dump($resI));


         }
      }
   }



/* PARA Alertas */

function insertarAlertas($reftipoalerta,$reftabla,$idreferencia,$email,$mensaje,$esunico) {
$sql = "insert into dbalertas(idalerta,reftipoalerta,reftabla,idreferencia,email,mensaje,esunico)
values ('',".$reftipoalerta.",".$reftabla.",".$idreferencia.",'".$email."','".$mensaje."','".$esunico."')";
$res = $this->query($sql,1);
return $res;
}


function modificarAlertas($id,$reftipoalerta,$reftabla,$idreferencia,$email,$mensaje,$esunico) {
$sql = "update dbalertas
set
reftipoalerta = ".$reftipoalerta.",reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",email = '".$email."',mensaje = '".$mensaje."',esunico = '".$esunico."'
where idalerta =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarAlertas($id) {
$sql = "delete from dbalertas where idalerta =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerAlertas() {
$sql = "select
a.idalerta,
a.reftipoalerta,
a.reftabla,
a.idreferencia,
a.email,
a.mensaje,
a.esunico
from dbalertas a
order by 1";
$res = $this->query($sql,0);
return $res;
}

function traerAlertasPorTablaReferencia($idtabla, $tabla, $idnombre, $id) {
   $sql = "select
   a.idalerta,
   a.reftipoalerta,
   a.reftabla,
   a.idreferencia,
   a.email,
   a.mensaje,
   a.esunico
   from dbalertas a
   inner join ".$tabla." v on v.".$idnombre." = a.idreferencia
   where a.reftabla = ".$idtabla." and a.idreferencia = ".$id;
   $res = $this->query($sql,0);
   return $res;
}


function traerAlertasPorId($id) {
$sql = "select idalerta,reftipoalerta,reftabla,idreferencia,email,mensaje,esunico from dbalertas where idalerta =".$id;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* /* Fin de la Tabla: dbalertas*/


/* PARA Tipoalerta */

function insertarTipoalerta($tipoalerta) {
$sql = "insert into tbtipoalerta(idtipoalerta,tipoalerta)
values ('','".$tipoalerta."')";
$res = $this->query($sql,1);
return $res;
}


function modificarTipoalerta($id,$tipoalerta) {
$sql = "update tbtipoalerta
set
tipoalerta = '".$tipoalerta."'
where idtipoalerta =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarTipoalerta($id) {
$sql = "delete from tbtipoalerta where idtipoalerta =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerTipoalerta() {
$sql = "select
t.idtipoalerta,
t.tipoalerta
from tbtipoalerta t
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerTipoalertaPorId($id) {
$sql = "select idtipoalerta,tipoalerta from tbtipoalerta where idtipoalerta =".$id;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* /* Fin de la Tabla: tbtipoalerta*/

   /*
   *   funcion para determinar: si subio la cantidad de recibos, si subio el primero,
   *   , si cargo el archivo de la poliza , si cargo el xml global, si cargo periodicidad
   */
   function verificaPolizaDatosCargados($id) {
      $valores = array('cantidadrecibos'=>0,'archivossubidos'=>0,'primerrecibo'=>0,'nropoliza'=>0,'xml'=>0,'periodicidad'=>0);

      $resPeriodicidad = $this->traerPeriodicidadventasPorVenta($id);

      if (mysql_num_rows($resPeriodicidad)>0) {

         // periodicidad cargada
         $valores['periodicidad'] = 1;

         //consulta los recibos y archivos cargados a los recibos, complementando con el version
         $sqlRecibos = "SELECT
                      v.idventa, tp.meses,count(pvd.idperiodicidadventadetalle) as cantrecibos,
                      (v.version - 1) * 10 as version,
                      count(dv.iddocumentacionventa) as cantarchivos
                  FROM
                      dbventas v
                          INNER JOIN
                      dbperiodicidadventas pv ON pv.refventas = v.idventa
                  		inner join
                  	tbtipoperiodicidad tp on tp.idtipoperiodicidad = pv.reftipoperiodicidad
                  		left join
                  	dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
                  		left join
                  	dbdocumentacionventas dv on dv.refperiodicidadventas = pvd.idperiodicidadventadetalle and dv.refdocumentaciones = 38
                  where v.idventa = ".$id." group by v.idventa, tp.meses, v.version";

         $resResultadoRecibos = $this->query($sqlRecibos,0);

         $meses = mysql_result($resResultadoRecibos,0,'meses');
         $cantRecibos = mysql_result($resResultadoRecibos,0,'cantrecibos');
         $cantArchivos = mysql_result($resResultadoRecibos,0,'cantarchivos');
         $version = (integer)mysql_result($resResultadoRecibos,0,'version');

         if ($meses == $cantRecibos + $version) {
            $valores['cantidadrecibos'] = 1;
         }

         if ($meses == $cantArchivos + $version) {
            $valores['archivossubidos'] = 1;
         }

         if ($cantArchivos > 0) {
            $valores['primerrecibo'] = 1;
         }
         //// fin de recibos y archivos

         // para la poliza
         $sqlNropoliza = "SELECT v.idventa FROM dbventas v INNER JOIN dbperiodicidadventas pv ON pv.refventas = v.idventa
            inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
            where v.idventa = ".$id;

         $resResultadoPolizas = $this->query($sqlNropoliza,0);

         if (mysql_num_rows($resResultadoPolizas)>0) {
            $valores['nropoliza'] = 1;
         }
         // fin poliza


         // para la xml
         $sqlNropoliza = "SELECT count(v.idventa) FROM dbventas v INNER JOIN dbperiodicidadventas pv ON pv.refventas = v.idventa
            inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones in (147,148)
            where v.idventa = ".$id;

         $resResultadoPolizas = $this->query($sqlNropoliza,0);

         if (mysql_num_rows($resResultadoPolizas)>0) {
            if (mysql_num_rows($resResultadoPolizas) == 2) {
               $valores['xml'] = 1;
            }

         }
         // fin xml


      }

      return $valores;
   }

   /* PARA Motivorechazopoliza */

   function insertarMotivorechazopoliza($motivorechazopoliza) {
      $sql = "insert into tbmotivorechazopoliza(idmotivorechazopoliza,motivorechazopoliza)
      values ('','".$motivorechazopoliza."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarMotivorechazopoliza($id,$motivorechazopoliza) {
      $sql = "update tbmotivorechazopoliza
      set
      motivorechazopoliza = '".$motivorechazopoliza."'
      where idmotivorechazopoliza =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarMotivorechazopoliza($id) {
      $sql = "delete from tbmotivorechazopoliza where idmotivorechazopoliza =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMotivorechazopoliza() {
      $sql = "select
      m.idmotivorechazopoliza,
      m.motivorechazopoliza
      from tbmotivorechazopoliza m
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMotivorechazopolizaPorId($id) {
      $sql = "select idmotivorechazopoliza,motivorechazopoliza from tbmotivorechazopoliza where idmotivorechazopoliza =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbmotivorechazopoliza*/

   /* PARA Renovaciones */

   function insertarRenovaciones($refventas,$nuevaventa,$fechacreacion) {
   $sql = "insert into dbrenovaciones(idrenovacion,refventas,nuevaventa,fechacreacion)
   values ('',".$refventas.",".$nuevaventa.",'".$fechacreacion."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarRenovaciones($id,$refventas,$nuevaventa,$fechacreacion) {
   $sql = "update dbrenovaciones
   set
   refventas = ".$refventas.",nuevaventa = ".$nuevaventa.",fechacreacion = '".$fechacreacion."'
   where idrenovacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarRenovaciones($id) {
   $sql = "delete from dbrenovaciones where idrenovacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerRenovaciones() {
   $sql = "select
   r.idrenovacion,
   r.refventas,
   r.nuevaventa,
   r.fechacreacion
   from dbrenovaciones r
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerRenovacionesPorId($id) {
      $sql = "select idrenovacion,refventas,nuevaventa,fechacreacion from dbrenovaciones where idrenovacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerRenovacionesPorVentaVieja($id) {
      $sql = "select idrenovacion,refventas,nuevaventa,fechacreacion from dbrenovaciones where refventas =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbrenovaciones*/

   function traerCuestionariodetallePDFPorTablaReferencia($idtabla, $tabla, $idnombre, $id, $pagina) {
		$sql = "select
      c.idcuestionariodetalle,
      c.pregunta,
      c.respuesta,
      c.respuestavalor,
      sp.x,
      sp.y,
      sp.`default`,
      ti.idtiporespuesta
      from dbcuestionariodetalle c
      inner join dbpreguntascuestionario pre ON pre.idpreguntacuestionario = c.refpreguntascuestionario and (pre.refpreguntassencibles is null or pre.refpreguntassencibles = 0)
      inner join dbcuestionarios cu ON cu.idcuestionario = pre.refcuestionarios
      inner join tbtiporespuesta ti ON ti.idtiporespuesta = pre.reftiporespuesta
      inner join dbrespuestascuestionario res ON res.idrespuestacuestionario = c.refrespuestascuestionario
      inner join dbsolicitudesrespuestas sp on sp.idsolicituderespuesta = res.refsolicitudesrespuestas
		inner join ".$tabla." v on v.".$idnombre." = c.idreferencia
		where c.reftabla = ".$idtabla." and c.idreferencia = ".$id." and sp.pagina =".$pagina;
		$res = $this->query($sql,0);
		return $res;
	}


   /* PARA Solicitudesrespuestas */

   function insertarSolicitudesrespuestas($refsolicitudpdf,$pagina,$sector,$x,$y,$nombre,$default,$pregunta,$reftabla,$camporeferencia,$fijo) {
      $sql = "insert into dbsolicitudesrespuestas(idsolicituderespuesta,refsolicitudpdf,pagina,sector,x,y,nombre,`default`,pregunta,reftabla,camporeferencia,fijo)
      values ('',".$refsolicitudpdf.",".$pagina.",'".$sector."',".$x.",".$y.",'".$nombre."','".$default."','".$pregunta."',".$reftabla.",'".$camporeferencia."','".$fijo."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarSolicitudesrespuestas($id,$refsolicitudpdf,$pagina,$sector,$x,$y,$nombre,$default,$pregunta,$reftabla,$camporeferencia,$fijo) {
      $sql = "update dbsolicitudesrespuestas
      set
      refsolicitudpdf = ".$refsolicitudpdf.",pagina = ".$pagina.",sector = '".$sector."',x = ".$x.",y = ".$y.",nombre = '".$nombre."',`default` = '".$default."',pregunta = '".$pregunta."',reftabla = ".$reftabla.",camporeferencia = '".$camporeferencia."',fijo = '".$fijo."'
      where idsolicituderespuesta =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarSolicitudesrespuestas($id) {
      $sql = "delete from dbsolicitudesrespuestas where idsolicituderespuesta =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerSolicitudesrespuestasajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where tp.solicitudpdf like '%".$busqueda."%' or s.pagina like '%".$busqueda."%' or s.sector like '%".$busqueda."%' or s.nombre like '%".$busqueda."%' or s.pregunta like '%".$busqueda."%'";
		}


      $sql = "select
      s.idsolicituderespuesta,
      tp.solicitudpdf,
      s.pagina,
      s.sector,
      s.x,
      s.y,
      s.nombre,
      s.`default`,
      s.pregunta,
      tt.especifico,
      s.camporeferencia,
      s.refsolicitudpdf,
      s.reftabla
      from dbsolicitudesrespuestas s
      inner join tbsolicitudpdf tp on tp.idsolicitudpdf = s.refsolicitudpdf
      left join tbtabla tt on tt.idtabla = s.reftabla
      ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerSolicitudesrespuestas() {
      $sql = "select
      s.idsolicituderespuesta,
      s.refsolicitudpdf,
      s.pagina,
      s.sector,
      s.x,
      s.y,
      s.nombre,
      s.`default`,
      s.pregunta,
      s.reftabla,
      s.camporeferencia
      from dbsolicitudesrespuestas s
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerSolicitudesrespuestasCompletoPDF($pagina) {
      $sql = "select
         s.sector,
         s.x,
         s.y,
         tt.tabla,
         tt.nombreid,
         s.camporeferencia,
         s.nombre
      from dbsolicitudesrespuestas s
      inner join tbsolicitudpdf tp on tp.idsolicitudpdf = s.refsolicitudpdf
      inner join tbtabla tt on tt.idtabla = s.reftabla

      where s.pagina = ".$pagina."
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerSolicitudesrespuestasCompletoFijoPDF($pagina) {
      $sql = "select
         s.sector,
         s.x,
         s.y,
         tt.tabla,
         tt.nombreid,
         s.camporeferencia,
         s.`default`,
         s.nombre
      from dbsolicitudesrespuestas s
      inner join tbsolicitudpdf tp on tp.idsolicitudpdf = s.refsolicitudpdf
      left join tbtabla tt on tt.idtabla = s.reftabla

      where tt.idtabla is null and s.fijo = '1' and s.pagina = ".$pagina."
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerSolicitudesrespuestasCompleto($idcuestionario) {
      $sql = "select
      s.idsolicituderespuesta,
      concat(' Pagina: ',s.pagina, ' | Sector: ', s.sector, ' | Preg: ', s.pregunta, ' | Nombre: ', s.nombre, ' | pordefecto: ', s.`default`, ' | Fijo', (case when s.fijo = '1' then 'Si' else 'No' end), ' | T: ',coalesce(tt.especifico,''),' | CR: ', s.camporeferencia ) as completo,
      tp.solicitudpdf,
      s.pagina,
      s.sector,
      s.pregunta,
      s.nombre,
      s.`default`,
      s.x,
      s.y,
      tt.especifico,
      s.camporeferencia,
      s.refsolicitudpdf,
      s.reftabla,
      (case when s.fijo = '1' then 'Si' else 'No' end) as fijo

      from dbsolicitudesrespuestas s
      inner join tbsolicitudpdf tp on tp.idsolicitudpdf = s.refsolicitudpdf
      left join tbtabla tt on tt.idtabla = s.reftabla
      inner join dbrespuestascuestionario rr on rr.refsolicitudesrespuestas = s.idsolicituderespuesta
      inner join
	     dbpreguntascuestionario pr
        on pr.idpreguntacuestionario = rr.refpreguntascuestionario and pr.refcuestionarios = ".$idcuestionario."
      where tt.idtabla is null
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerSolicitudesrespuestasInCompleto($idcuestionario) {
      $sql = "select
      s.idsolicituderespuesta,
      concat(' Pagina: ',s.pagina, ' | Sector: ', s.sector, ' | Preg: ', s.pregunta, ' | Nombre: ', s.nombre ) as completo,
      tp.solicitudpdf,
      s.pagina,
      s.sector,
      s.pregunta,
      s.nombre,
      s.`default`,
      s.x,
      s.y,
      tt.especifico,
      s.camporeferencia,
      s.refsolicitudpdf,
      s.reftabla,
      (case when s.fijo = '1' then 'Si' else 'No' end) as fijo

      from dbsolicitudesrespuestas s
      inner join tbsolicitudpdf tp on tp.idsolicitudpdf = s.refsolicitudpdf
      left join tbtabla tt on tt.idtabla = s.reftabla
      left join (select idrespuestacuestionario,refsolicitudesrespuestas from dbrespuestascuestionario rr
   		inner join
   	dbpreguntascuestionario pr on pr.idpreguntacuestionario = rr.refpreguntascuestionario
                              and pr.refcuestionarios = ".$idcuestionario."
       ) rt ON rt.refsolicitudesrespuestas = s.idsolicituderespuesta
      where tt.idtabla is null and rt.idrespuestacuestionario is null
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerSolicitudesrespuestasPorId($id) {
      $sql = "select idsolicituderespuesta,refsolicitudpdf,pagina,sector,x,y,nombre,`default`,pregunta,reftabla,camporeferencia,fijo from dbsolicitudesrespuestas where idsolicituderespuesta =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbsolicitudesrespuestas*/

   /* PARA Tipofirma */

   function insertarTipoemision($tipoemision) {
      $sql = "insert into tbtipoemision(idtipoemision,tipoemision)
      values ('','".$tipoemision."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTipoemision($id,$tipoemision) {
      $sql = "update tbtipoemision
      set
      tipoemision = '".$tipoemision."'
      where idtipoemision =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTipoemision($id) {
      $sql = "delete from tbtipoemision where idtipoemision =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipoemision() {
      $sql = "select
      t.idtipoemision,
      t.tipoemision
      from tbtipoemision t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipoemisionPorId($id) {
      $sql = "select idtipoemision,tipoemision from tbtipoemision where idtipoemision =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtipoemision*/

   /* PARA Cuentasbancarias */

   function insertarCuentasbancarias($razonsocial,$apoderado,$clabeinterbancaria,$refbancos) {
      $sql = "insert into tbcuentasbancarias(idcuentabancaria,razonsocial,apoderado,clabeinterbancaria,refbancos)
      values ('','".$razonsocial."','".$apoderado."','".$clabeinterbancaria."',".$refbancos.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarCuentasbancarias($id,$razonsocial,$apoderado,$clabeinterbancaria,$refbancos) {
      $sql = "update tbcuentasbancarias
      set
      razonsocial = '".$razonsocial."',apoderado = '".$apoderado."',clabeinterbancaria = '".$clabeinterbancaria."',refbancos = ".$refbancos." where idcuentabancaria =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarCuentasbancarias($id) {
      $sql = "delete from tbcuentasbancarias where idcuentabancaria =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerCuentasbancarias() {
      $sql = "select
      c.idcuentabancaria,
      c.razonsocial,
      c.apoderado,
      c.clabeinterbancaria,
      c.refbancos
      from tbcuentasbancarias c
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerCuentasbancariasajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where c.razonsocial like '%".$busqueda."%' and c.apoderado like '%".$busqueda."%' and c.clabeinterbancaria like '%".$busqueda."%' and b.banco like '%".$busqueda."%'";
		}

      $sql = "select
      c.idcuentabancaria,
      c.razonsocial,
      c.apoderado,
      c.clabeinterbancaria,
      b.banco,
      c.refbancos
      from tbcuentasbancarias c
      inner join tbbancos b on c.refbancos = b.idbanco
      ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerCuentasbancariasPorId($id) {
      $sql = "select idcuentabancaria,razonsocial,apoderado,clabeinterbancaria,refbancos from tbcuentasbancarias where idcuentabancaria =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbcuentasbancarias*/

   /* PARA Pagos */

   function insertarPagos($reftabla,$idreferencia,$monto,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,$refestado,$razonsocial,$contratante,$nrorecibo,$avisoinbursa) {
   $sql = "insert into dbpagos(idpago,reftabla,idreferencia,monto,token,destino,refcuentasbancarias,conciliado,archivos,type,fechacrea,usuariocrea,refestado,razonsocial,contratante,nrorecibo,avisoinbursa)
   values ('',".$reftabla.",".$idreferencia.",".$monto.",'".$token."','".$destino."',".$refcuentasbancarias.",'".$conciliado."','".$archivos."','".$type."','".$fechacrea."','".$usuariocrea."',".$refestado.",'".$razonsocial."','".$contratante."','".$nrorecibo."','".$avisoinbursa."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarPagos($id,$reftabla,$idreferencia,$monto,$token,$destino,$refcuentasbancarias,$conciliado,$archivos,$type,$fechacrea,$usuariocrea,$refestado,$razonsocial,$contratante,$nrorecibo,$avisoinbursa) {
   $sql = "update dbpagos
   set
   reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",monto = ".$monto.",token = '".$token."',destino = '".$destino."',refcuentasbancarias = ".$refcuentasbancarias.",conciliado = '".$conciliado."',archivos = '".$archivos."',type = '".$type."',fechacrea = '".$fechacrea."',usuariocrea = '".$usuariocrea."',refestado = ".$refestado.",razonsocial = '".$razonsocial."',contratante = '".$contratante."',nrorecibo = '".$nrorecibo."',avisoinbursa = '".$avisoinbursa."' where idpago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function modificarPagosArchivo($id,$archivos,$type) {
   $sql = "update dbpagos
   set
   archivos = '".$archivos."',type = '".$type."' where idpago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function avisarPago($id,$avisoinbursa) {
   $sql = "update dbpagos
   set
   avisoinbursa = '".$avisoinbursa."' where idpago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function aplicarPago($id,$aplicar) {
   $sql = "update dbpagos
   set
   conciliado = '".$aplicar."' where idpago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarPagos($id) {
   $sql = "delete from dbpagos where idpago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerPagosPorTablaReferencia($idtabla, $tabla, $idnombre, $id) {
		$sql = "select
      p.idpago,
      p.reftabla,
      p.idreferencia,
      p.monto,
      p.token,
      p.destino,
      p.refcuentasbancarias,
      p.conciliado,
      p.archivos,
      p.type,
      p.fechacrea,
      p.usuariocrea,
      p.refestado
      from dbpagos p
		inner join ".$tabla." v on v.".$idnombre." = p.idreferencia
		where p.reftabla = ".$idtabla." and p.idreferencia = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerPagosCotizacionajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (tt.especifico like '%".$busqueda."%' or p.monto like '%".$busqueda."%' or p.destino like '%".$busqueda."%' or (case when p.conciliado = '1' then 'Si' else 'No' end) like '%".$busqueda."%' or e.estadodocumentacion like '%".$busqueda."%' or v.folio like '%".$busqueda."%')";
		}

      $sql = "select
      p.idpago,
      tt.especifico,
      p.monto,
      p.destino,
      (case when cc.idcuentabancaria is null then p.razonsocial else cc.razonsocial end) as razonsocial,
      cc.clabeinterbancaria,
      p.fechacrea,
      p.contratante,
      p.nrorecibo,
      v.folio,
      (case when p.conciliado = '1' then 'Si' else 'No' end) as conciliado,
      e.estadodocumentacion,
      p.usuariocrea,
      p.reftabla,
      p.idreferencia,
      p.refcuentasbancarias,
      p.archivos,
      p.type,
      p.token,
      p.refestado
      from dbpagos p
		inner join dbcotizaciones v on v.idcotizacion = p.idreferencia
      inner join tbtabla tt on tt.idtabla = p.reftabla
      inner join tbestadodocumentaciones e on e.idestadodocumentacion = p.refestado
      left join tbcuentasbancarias cc on cc.idcuentabancaria = p.refcuentasbancarias
		where p.reftabla = 12 ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      //die(var_dump($sql));

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerPagos() {
   $sql = "select
   p.idpago,
   p.reftabla,
   p.idreferencia,
   p.monto,
   p.token,
   p.destino,
   p.refcuentasbancarias,
   p.conciliado,
   p.archivos,
   p.type,
   p.fechacrea,
   p.usuariocrea,
   p.refestado
   from dbpagos p
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPagosPorId($id) {
   $sql = "select idpago,reftabla,idreferencia,monto,token,destino,refcuentasbancarias,conciliado,archivos,type,fechacrea,usuariocrea,refestado,razonsocial,contratante,nrorecibo from dbpagos where idpago =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerPagosPorCotizacion($id) {
   $sql = "select idpago,reftabla,idreferencia,monto,token,destino,refcuentasbancarias,conciliado,archivos,type,fechacrea,usuariocrea,refestado,razonsocial,contratante,nrorecibo from dbpagos where reftabla = 12 and idreferencia =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerPagosPorRecibo($id) {
   $sql = "select idpago,reftabla,idreferencia,monto,token,destino,refcuentasbancarias,conciliado,archivos,type,fechacrea,usuariocrea,refestado,razonsocial,contratante,nrorecibo from dbpagos where reftabla = 15 and idreferencia =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbpagos*/

   /* PARA Metodopago */

   function insertarMetodopago($refcotizaciones,$reftipoperiodicidad,$reftipocobranza,$banco,$afiliacionnumber,$tipotarjeta) {
      $sql = "insert into dbmetodopago(idmetodopago,refcotizaciones,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta)
      values ('',".$refcotizaciones.",".$reftipoperiodicidad.",".$reftipocobranza.",'".$banco."','".$afiliacionnumber."','".$tipotarjeta."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarMetodopago($id,$refcotizaciones,$reftipoperiodicidad,$reftipocobranza,$banco,$afiliacionnumber,$tipotarjeta) {
      $sql = "update dbmetodopago
      set
      refcotizaciones = ".$refcotizaciones.",reftipoperiodicidad = ".$reftipoperiodicidad.",reftipocobranza = ".$reftipocobranza.",banco = '".$banco."',afiliacionnumber = '".$afiliacionnumber."',tipotarjeta = '".$tipotarjeta."' where idmetodopago =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarMetodopago($id) {
      $sql = "delete from dbmetodopago where idmetodopago =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function eliminarMetodopagoPorCotizacion($id) {
      $sql = "delete from dbmetodopago where refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMetodopago() {
      $sql = "select
      m.idmetodopago,
      m.refcotizaciones,
      m.reftipoperiodicidad,
      m.reftipocobranza,
      m.banco,
      m.afiliacionnumber,
      m.tipotarjeta
      from dbmetodopago m
      inner join dbcotizaciones cot ON cot.idcotizacion = m.refcotizaciones
      inner join dbclientes cl ON cl.idcliente = cot.refclientes
      inner join tbproductos pr ON pr.idproducto = cot.refproductos
      inner join dbasesores as ON as.idasesor = cot.refasesores
      inner join tbestadocotizaciones es ON es.idestadocotizacion = cot.refestadocotizaciones
      inner join dbusuarios us ON us.idusuario = cot.refusuarios
      inner join tbtipoperiodicidad tip ON tip.idtipoperiodicidad = m.reftipoperiodicidad
      inner join tbtipocobranza tip ON tip.idtipocobranza = m.reftipocobranza
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMetodopagoPorId($id) {
      $sql = "select idmetodopago,refcotizaciones,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta from dbmetodopago where idmetodopago =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerMetodopagoPorCotizacion($id) {
      $sql = "select idmetodopago,refcotizaciones,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta from dbmetodopago where refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerMetodopagoPorCotizacionCompleto($id) {
      $sql = "select
         mp.idmetodopago,
         mp.refcotizaciones,
         mp.reftipoperiodicidad,
         mp.reftipocobranza,
         mp.banco,
         mp.afiliacionnumber,
         mp.tipotarjeta,
         t.tipocobranza,
         tp.tipoperiodicidad
      from dbmetodopago mp
      inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = mp.reftipoperiodicidad
      inner join tbtipocobranza t ON t.idtipocobranza = mp.reftipocobranza
      where mp.refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbmetodopago*/

   /*   para la firma digital */


   /* PARA Firmarcontratos */

   function insertarFirmarcontratos($refcotizaciones,$folio,$nip,$usuario,$sha256,$refestadofirma,$fechacrea,$fechamodi,$vigdesde,$vighasta,$xml) {
      $sql = "insert into dbfirmarcontratos(idfirmarcontrato,refcotizaciones,folio,nip,usuario,sha256,refestadofirma,fechacrea,fechamodi,vigdesde,vighasta,xml)
      values ('',".$refcotizaciones.",'".$folio."','".$nip."','".$usuario."','".$sha256."',".$refestadofirma.",'".$fechacrea."','".$fechamodi."','".$vigdesde."',DATE_ADD(now(),INTERVAL 10 year),'".$xml."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarFirmarcontratos($id,$refcotizaciones,$folio,$nip,$usuario,$sha256,$refestadofirma,$fechacrea,$fechamodi,$vigdesde,$vighasta) {
      $sql = "update dbfirmarcontratos
      set
      refcotizaciones = ".$refcotizaciones.",folio = '".$folio."',nip = '".$nip."',usuario = '".$usuario."',sha256 = ".$sha256.",refestadofirma = ".$refestadofirma.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',vigdesde = '".$vigdesde."',vighasta = '".$vighasta."' where idfirmarcontrato =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarFirmarcontratos($id) {
      $sql = "delete from dbfirmarcontratos where idfirmarcontrato =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerFirmarcontratos() {
      $sql = "select
      f.idfirmarcontrato,
      f.refcotizaciones,
      f.folio,
      f.nip,
      f.usuario,
      f.sha256,
      f.refestadofirma,
      f.fechacrea,
      f.fechamodi,
      f.vigdesde,
      f.vighasta
      from dbfirmarcontratos f
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerFirmarcontratosPorId($id) {
      $sql = "select idfirmarcontrato,refcotizaciones,folio,nip,usuario,sha256,refestadofirma,fechacrea,fechamodi,vigdesde,vighasta from dbfirmarcontratos where idfirmarcontrato =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerFirmarcontratosPorCotizacion($id) {
      $sql = "select idfirmarcontrato,refcotizaciones,folio,nip,usuario,sha256,refestadofirma,fechacrea,fechamodi,vigdesde,vighasta from dbfirmarcontratos where refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerFirmarcontratosPorCotizacionAprobada($id) {
      $sql = "select idfirmarcontrato,refcotizaciones,folio,nip,usuario,sha256,refestadofirma,fechacrea,fechamodi,vigdesde,vighasta from dbfirmarcontratos where refestadofirma=1 and refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerFirmarcontratosPorNIP($nip) {
      $sql = "select idfirmarcontrato,refcotizaciones,folio,nip,usuario,sha256,refestadofirma,fechacrea,fechamodi,vigdesde,vighasta from dbfirmarcontratos where nip ='".$nip."'";
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbfirmarcontratos*/


   /* PARA Tokens */
   function generarNIP() {
      return rand(100000, 999999);
   }

   function insertarTokens($refcotizaciones,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin) {
      $sql = "insert into dbtokens(idtoken,refcotizaciones,reftipo,token,fechacreac,refestadotoken,vigenciafin)
      values ('',".$refcotizaciones.",".$reftipo.",'".$token."','".$fechacreac."',".$refestadotoken.",DATE_ADD(now(),INTERVAL 15 hour))";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTokens($id,$refcotizaciones,$reftipo,$token,$fechacreac,$refestadotoken,$vigenciafin) {
      $sql = "update dbtokens
      set
      refcotizaciones = ".$refcotizaciones.",reftipo = ".$reftipo.",token = '".$token."',fechacreac = '".$fechacreac."',refestadotoken = ".$refestadotoken.",vigenciafin = '".$vigenciafin."' where idtoken =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarTokensTodosInhabilitar($refcotizaciones) {
      $sql = "update dbtokens
      set
      vigenciafin = '0000-00-00 00:00:00' where refcotizaciones =".$refcotizaciones;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTokens($id) {
      $sql = "delete from dbtokens where idtoken =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTokens() {
      $sql = "select
      t.idtoken,
      t.refcotizaciones,
      t.reftipo,
      t.token,
      t.fechacreac,
      t.refestadotoken,
      t.vigenciafin
      from dbtokens t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTokensPorId($id) {
      $sql = "select idtoken,refcotizaciones,reftipo,token,fechacreac,refestadotoken,vigenciafin from dbtokens where idtoken =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokensPorCotizacion($id) {
      $sql = "select idtoken,refcotizaciones,reftipo,token,fechacreac,refestadotoken,vigenciafin from dbtokens where refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerTokensPorCotizacionVigente($id) {
      $sql = "select idtoken,refcotizaciones,reftipo,token,fechacreac,refestadotoken,vigenciafin from dbtokens where refcotizaciones =".$id." and now() between fechacreac and vigenciafin";
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbtokens*/

   /* fin firma digital */

   /* PARA Tipofirma */

   function insertarTipofirma($tipofirma) {
      $sql = "insert into tbtipofirma(idtipofirma,tipofirma)
      values ('','".$tipofirma."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTipofirma($id,$tipofirma) {
      $sql = "update tbtipofirma
      set
      tipofirma = '".$tipofirma."'
      where idtipofirma =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTipofirma($id) {
      $sql = "delete from tbtipofirma where idtipofirma =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipofirma() {
      $sql = "select
      t.idtipofirma,
      t.tipofirma
      from tbtipofirma t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipofirmaPorId($id) {
      $sql = "select idtipofirma,tipofirma from tbtipofirma where idtipofirma =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtipofirma*/

   /* PARA Paquetedetalles */

   function insertarPaquetedetalles($refpaquetes,$refproductos,$secalcula,$unicomonto,$valor,$firmasimple,$firmafiel,$domiciliacion) {
      $sql = "insert into dbpaquetedetalles(idpaquetedetalle,refpaquetes,refproductos,secalcula,unicomonto,valor,firmasimple,firmafiel,domiciliacion)
      values ('',".$refpaquetes.",".$refproductos.",'".$secalcula."','".$unicomonto."',".$valor.",'".$firmasimple."','".$firmafiel."','".$domiciliacion."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarPaquetedetalles($id,$refpaquetes,$refproductos,$secalcula,$unicomonto,$valor,$firmasimple,$firmafiel,$domiciliacion) {
      $sql = "update dbpaquetedetalles
      set
      refpaquetes = ".$refpaquetes.",refproductos = ".$refproductos.",secalcula = '".$secalcula."',unicomonto = '".$unicomonto."',valor = ".$valor.",firmasimple = '".$firmasimple."',firmafiel = '".$firmafiel."',domiciliacion = '".$domiciliacion."'
      where idpaquetedetalle =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarPaquetedetalles($id) {
      $sql = "delete from dbpaquetedetalles where idpaquetedetalle =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerPaquetedetalles() {
      $sql = "select
      p.idpaquetedetalle,
      p.refpaquetes,
      p.refproductos,
      p.secalcula,
      p.unicomonto,
      p.valor,
      p.firmasimple,
      p.firmafiel,
      p.domiciliacion
      from dbpaquetedetalles p
      inner join dbpaquetes paq ON paq.idpaquete = p.refpaquetes
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerPaquetedetallesPorId($id) {
      $sql = "select idpaquetedetalle,refpaquetes,refproductos,secalcula,unicomonto,valor,firmasimple,firmafiel,domiciliacion from dbpaquetedetalles where idpaquetedetalle =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerPaquetedetallesPorPaquete($id) {
      $sql = "select
      pd.idpaquetedetalle,pd.refpaquetes,pd.refproductos,
      pd.secalcula,pd.unicomonto,pd.valor,pd.firmasimple,
      pd.firmafiel,pd.domiciliacion, pp.producto, tr.idtipoproductorama
      from dbpaquetedetalles pd
      inner join dbpaquetes p on p.idpaquete = pd.refpaquetes
      inner join tbproductos pp on pp.idproducto = pd.refproductos
      inner join tbtipoproductorama tr on tr.idtipoproductorama = pp.reftipoproductorama
      where p.refproductos =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbpaquetedetalles*/


   /* PARA Paquetes */

   function insertarPaquetes($refproductos,$cantidad) {
      $sql = "insert into dbpaquetes(idpaquete,refproductos,cantidad)
      values ('',".$refproductos.",".$cantidad.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarPaquetes($id,$refproductos,$cantidad) {
      $sql = "update dbpaquetes
      set
      refproductos = ".$refproductos.",cantidad = ".$cantidad."
      where idpaquete =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarPaquetes($id) {
      $sql = "delete from dbpaquetes where idpaquete =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerPaquetes() {
      $sql = "select
      p.idpaquete,
      p.refproductos,
      p.cantidad
      from dbpaquetes p
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerPaquetesPorId($id) {
      $sql = "select idpaquete,refproductos,cantidad from dbpaquetes where idpaquete =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbpaquetes*/

   function calculaedad($fechanacimiento){
      list($ano,$mes,$dia) = explode("-",$fechanacimiento);
      $ano_diferencia  = date("Y") - $ano;
      $mes_diferencia = date("m") - $mes;
      $dia_diferencia   = date("d") - $dia;
      if (($dia_diferencia < 0 || $mes_diferencia < 0) && ($ano != date("Y")))
         $ano_diferencia--;
      return $ano_diferencia;
   }
   /* PARA Valoredad */

   function insertarValoredad($refproductos,$desde,$hasta,$valor,$vigdesde,$vighasta,$fechacrea) {
      $sql = "insert into dbvaloredad(idvaloredad,refproductos,desde,hasta,valor,vigdesde,vighasta,fechacrea)
      values ('',".$refproductos.",".$desde.",".$hasta.",".$valor.",'".$vigdesde."','".$vighasta."','".$fechacrea."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarValoredad($id,$refproductos,$desde,$hasta,$valor,$vigdesde,$vighasta) {
      $sql = "update dbvaloredad
      set
      refproductos = ".$refproductos.",desde = ".$desde.",hasta = ".$hasta.",valor = ".$valor.",vigdesde = '".$vigdesde."',vighasta = '".$vighasta."'
      where idvaloredad =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarValoredad($id) {
      $sql = "delete from dbvaloredad where idvaloredad =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerValoredadjax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where p.producto like '%".$busqueda."%' and desde like '%".$busqueda."%' and hasta like '%".$busqueda."%'";
		}

      $sql = "select
      v.idvaloredad,
      p.producto,
      v.desde,
      v.hasta,
      v.vigdesde,
      v.vighasta,
      v.valor,
      v.refproductos,
      v.fechacrea
      from dbvaloredad v
      inner join tbproductos p on p.idproducto = v.refproductos
       ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }

   function traerValoredad() {
      $sql = "select
      v.idvaloredad,
      v.refproductos,
      v.desde,
      v.hasta,
      v.valor,
      v.vigdesde,
      v.vighasta,
      v.fechacrea
      from dbvaloredad v
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerValoredadPorId($id) {
      $sql = "select idvaloredad,refproductos,desde,hasta,valor,vigdesde,vighasta,fechacrea from dbvaloredad where idvaloredad =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerValoredadPorProducto($id) {
      $sql = "select idvaloredad,refproductos,desde,hasta,valor,vigdesde,vighasta,fechacrea from dbvaloredad where refproductos =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerValoredadPorProductoEdad($idproducto, $edad) {
      $sql = "select idvaloredad,refproductos,desde,hasta,valor,vigdesde,vighasta,fechacrea from dbvaloredad where refproductos =".$idproducto." and ".$edad." between desde and hasta";
      $res = $this->query($sql,0);
      return $res;
   }

   function existeCotizacionValorEdad($idproducto) {
      $sql = "select idvaloredad,refproductos,desde,hasta,valor,vigdesde,vighasta,fechacrea from dbvaloredad where refproductos =".$idproducto;
      $res = $this->query($sql,0);
      if (mysql_num_rows($res)>0) {
         return 1;
      }
      return 0;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbvaloredad*/

   function traerInformeDeDocumentaciones($id) {
      $resPostulante = $this->traerPostulantesPorId($id);

      $nombrecompleto = mysql_result($resPostulante,0,'apellidopaterno').' '.mysql_result($resPostulante,0,'apellidomaterno').' '.mysql_result($resPostulante,0,'nombre');

      $lblVeritas = 'Estado Veritas: ';
      $lblSiap = 'Estado SIAP: ';
      $lblDocumentaciones = 'Estado Documentaciones: ';
      $lblContratos = 'Estado Contratos: ';

      $sqlVeritas = "select
               de.estadodocumentacion
            from dbdocumentacionasesores da
            inner join tbestadodocumentaciones de on de.idestadodocumentacion = da.refestadodocumentaciones
            where da.refdocumentaciones = 1 and da.refpostulantes = ".$id;

      $resVeritas = $this->query($sqlVeritas,0);

      if (mysql_num_rows($resVeritas) > 0) {
         $lblVeritas .= mysql_result($resVeritas,0,0);
      } else {
         $lblVeritas .= 'No cargado';
      }

      $sqlSiap = "select
               de.estadodocumentacion
            from dbdocumentacionasesores da
            inner join tbestadodocumentaciones de on de.idestadodocumentacion = da.refestadodocumentaciones
            where da.refdocumentaciones = 2 and da.refpostulantes = ".$id;

      $resSiap = $this->query($sqlSiap,0);

      if (mysql_num_rows($resSiap) > 0) {
         $lblSiap .= mysql_result($resSiap,0,0);
      } else {
         $lblSiap .= 'No cargado';
      }

      return array('veritas'=>$lblVeritas, 'siap'=>$lblSiap, 'documentaciones'=>$lblDocumentaciones,'contratos'=>$lblContratos,'nombrecompleto'=>$nombrecompleto);
   }

   /* PARA Motivorechazocotizaciones */

   function insertarMotivorechazocotizaciones($refcotizaciones,$motivo,$nocompartioinformacion,$primatotalinbursa,$primatotalcompetencia,$aseguradora) {
      $sql = "insert into tbmotivorechazocotizaciones(idmotivorechazocotizacion,refcotizaciones,motivo,nocompartioinformacion,primatotalinbursa,primatotalcompetencia,aseguradora)
      values ('',".$refcotizaciones.",'".$motivo."','".$nocompartioinformacion."','".$primatotalinbursa."','".$primatotalcompetencia."','".$aseguradora."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarMotivorechazocotizaciones($id,$refcotizaciones,$motivo,$nocompartioinformacion,$primatotalinbursa,$primatotalcompetencia,$aseguradora) {
      $sql = "update tbmotivorechazocotizaciones
      set
      refcotizaciones = ".$refcotizaciones.",motivo = '".$motivo."',nocompartioinformacion = '".$nocompartioinformacion."',primatotalinbursa = '".$primatotalinbursa."',primatotalcompetencia = '".$primatotalcompetencia."',aseguradora = '".$aseguradora."'
      where idmotivorechazocotizacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarMotivorechazocotizaciones($id) {
      $sql = "delete from tbmotivorechazocotizaciones where idmotivorechazocotizacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMotivorechazocotizaciones() {
      $sql = "select
      m.idmotivorechazocotizacion,
      m.refcotizaciones,
      m.motivo,
      m.nocompartioinformacion,
      m.primatotalinbursa,
      m.primatotalcompetencia,
      m.aseguradora
      from tbmotivorechazocotizaciones m
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMotivorechazocotizacionesPorId($id) {
      $sql = "select idmotivorechazocotizacion,refcotizaciones,motivo,nocompartioinformacion,primatotalinbursa,primatotalcompetencia,aseguradora from tbmotivorechazocotizaciones where idmotivorechazocotizacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerMotivorechazocotizacionesPorCotizacion($id) {
      $sql = "select idmotivorechazocotizacion,refcotizaciones,motivo,nocompartioinformacion,primatotalinbursa,primatotalcompetencia,aseguradora from tbmotivorechazocotizaciones where refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbmotivorechazocotizaciones*/

   /* PARA Productosweb */

   function insertarProductosweb($producto,$tipo) {
   $sql = "insert into tbproductosweb(idproductosweb,producto,tipo)
   values ('','".$producto."',".$tipo.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarProductosweb($id,$producto,$tipo) {
   $sql = "update tbproductosweb
   set
   producto = '".$producto."',tipo = ".$tipo."
   where idproductosweb =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarProductosweb($id) {
   $sql = "delete from tbproductosweb where idproductosweb =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerProductosweb() {
   $sql = "select
   p.idproductosweb,
   p.producto,
   p.tipo
   from tbproductosweb p
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerProductoswebPorId($id) {
   $sql = "select idproductosweb,producto,tipo from tbproductosweb where idproductosweb =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function traerProductoswebPorTipo($id) {
   $sql = "select idproductosweb,producto,tipo from tbproductosweb where tipo =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbproductosweb*/

   /* PARA Lead */

   function insertarLead($refclientes,$refproductos,$fechacrea,$fechamodi,$contactado,$usuariocontacto,$usuarioresponsable,$cita,$refestadolead,$fechacreacita,$observaciones,$refproductosweb,$reforigencomercio) {
      $sql = "insert into dblead(idlead,refclientes,refproductos,fechacrea,fechamodi,contactado,usuariocontacto,usuarioresponsable,cita,refestadolead,fechacreacita,observaciones,refproductosweb,reforigencomercio)
      values ('',".$refclientes.",".$refproductos.",'".$fechacrea."','".$fechamodi."','".$contactado."','".$usuariocontacto."','".$usuarioresponsable."','".$cita."',".$refestadolead.",'".$fechacreacita."','".$observaciones."',".$refproductosweb.",".$reforigencomercio.")";
      $res = $this->query($sql,1);
      return $res;
   }

   function insertarLeadCompleto($refclientes,$refproductos,$fechacrea,$fechamodi,$contactado,$usuariocontacto,$usuarioresponsable,$cita,$refestadolead,$fechacreacita,$observaciones,$refproductosweb,$reforigencomercio,$refcotizaciones) {
      $sql = "insert into dblead(idlead,refclientes,refproductos,fechacrea,fechamodi,contactado,usuariocontacto,usuarioresponsable,cita,refestadolead,fechacreacita,observaciones,refproductosweb,reforigencomercio,refcotizaciones)
      values ('',".$refclientes.",".$refproductos.",'".$fechacrea."','".$fechamodi."','".$contactado."','".$usuariocontacto."','".$usuarioresponsable."','".$cita."',".$refestadolead.",'".$fechacreacita."','".$observaciones."',".$refproductosweb.",".$reforigencomercio.",".$refcotizaciones.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarLead($id,$refclientes,$refproductos,$fechamodi,$contactado,$usuariocontacto,$usuarioresponsable,$cita,$refestadolead,$fechacreacita,$observaciones,$refproductosweb) {
      $sql = "update dblead
      set
      refclientes = ".$refclientes.",refproductos = ".$refproductos.",fechamodi = '".$fechamodi."',contactado = '".$contactado."',usuariocontacto = '".$usuariocontacto."',usuarioresponsable = '".$usuarioresponsable."',cita = '".$cita."',refestadolead = ".$refestadolead.",fechacreacita = '".$fechacreacita."',observaciones = '".$observaciones."',refproductosweb = '".$refproductosweb."' where idlead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarLeadCotizacion($id,$refcotizaciones,$idestado) {
      $sql = "update dblead
      set
      refcotizaciones = ".$refcotizaciones.",refestadolead=".$idestado." where idlead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarLead($id) {
      $sql = "delete from dblead where idlead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function eliminarLeadBaja($id,$usuario) {

      $sql = "update dblead
      set
      fechamodi = '".date('Y-m-d H:i:s')."',usuarioresponsable = '".$usuario."',refestadolead = 4 where idlead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerLeadajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and tw.producto like '%".$busqueda."%') and concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%')";
		}

      $sql = "select
      l.idlead,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
      cli.telefonocelular,
      tw.producto as productoweb,
      pro.producto,
      l.fechacrea,
      oc.origencomercio,
      concat('LD',right(concat('00000000',l.idlead),8)) as folio,
      l.refproductos,
      l.fechamodi,
      l.contactado,
      l.usuariocontacto,
      l.usuarioresponsable,
      l.cita,
      l.refestadolead,
      l.fechacreacita,
      l.observaciones
      from dblead l
      inner join dbclientes cli ON cli.idcliente = l.refclientes
      inner join tbproductosweb tw on tw.idproductosweb = l.refproductosweb
      left join tbproductos pro ON pro.idproducto = l.refproductos
      left join tborigencomercio oc on oc.idorigencomercio = l.reforigencomercio
      where l.refestadolead = 1 ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerLeadhistoricosajax($length, $start, $busqueda,$colSort,$colSortDir,$idestado) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and tw.producto like '%".$busqueda."%') and concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%')";
		}

      $sql = "select
      l.idlead,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
      cli.telefonocelular,
      tw.producto as productoweb,
      pro.producto,
      l.fechacrea,
      l.cita,
      l.usuariocontacto,
      l.usuarioresponsable,
      oc.origencomercio,
      concat('LD',right(concat('00000000',l.idlead),8)) as folio,
      elt.estadolead,
      l.refproductos,
      l.fechamodi,
      l.contactado,

      l.refestadolead,
      l.fechacreacita,
      l.observaciones
      from dblead l
      inner join dbclientes cli ON cli.idcliente = l.refclientes
      inner join tbproductosweb tw on tw.idproductosweb = l.refproductosweb
      inner join tbestadolead elt on elt.idestadolead = l.refestadolead
      left join tbproductos pro ON pro.idproducto = l.refproductos
      left join tborigencomercio oc on oc.idorigencomercio = l.reforigencomercio
      where l.refestadolead in (".$idestado.") ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerLead() {
      $sql = "select
      l.idlead,
      l.refclientes,
      l.refproductos,
      l.fechacrea,
      l.fechamodi,
      l.contactado,
      l.usuariocontacto,
      l.usuarioresponsable,
      l.cita,
      l.refestadolead,
      l.fechacreacita,
      l.observaciones
      from dblead l
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerLeadPorId($id) {
      $sql = "select idlead,refclientes,refproductos,fechacrea,fechamodi,contactado,usuariocontacto,usuarioresponsable,cita,refestadolead,fechacreacita,observaciones,refproductosweb,reforigencomercio,refcotizaciones from dblead where idlead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerLeadPorCotizacion($id) {
      $sql = "select idlead,refclientes,refproductos,fechacrea,fechamodi,contactado,usuariocontacto,usuarioresponsable,cita,refestadolead,fechacreacita,observaciones,refproductosweb,reforigencomercio,refcotizaciones from dblead where refcotizaciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dblead*/

   /* PARA Estadolead */

   function insertarEstadolead($estadolead) {
      $sql = "insert into tbestadolead(idestadolead,estadolead)
      values ('','".$estadolead."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarEstadolead($id,$estadolead) {
      $sql = "update tbestadolead
      set
      estadolead = '".$estadolead."'
      where idestadolead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarEstadolead($id) {
      $sql = "delete from tbestadolead where idestadolead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerEstadolead() {
      $sql = "select
      e.idestadolead,
      e.estadolead
      from tbestadolead e
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerEstadoleadPorId($id) {
      $sql = "select idestadolead,estadolead from tbestadolead where idestadolead =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerEstadoleadPorIn($in) {
      $sql = "select idestadolead,estadolead from tbestadolead where idestadolead in (".$in.")";
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbestadolead*/

   function traerProductosVentaEnLinea($id) {
      $sql = "select idproducto, producto, precio, detalle from tbproductos p where activo = '1' and ventaenlinea = '1' ";
      $res = $this->query($sql,0);

      return $res;
   }

   function traerProductosVentaEnLineaPorId($id) {
      $sql = "select idproducto, producto, precio, detalle from tbproductos p where activo = '1' and ventaenlinea = '1' and idproducto = ".$id;
      $res = $this->query($sql,0);

      return $res;
   }

   function traerProductosCotizaEnLinea() {
      $sql = "select idproducto, producto,detalle from tbproductos p where activo = '1' and cotizaenlinea = '1'";
      $res = $this->query($sql,0);

      return $res;
   }

   function traerProductosPorIdCompletaPorSeguros() {
		$sql = "select
		p.idproducto,
		p.producto,
		p.prima,
      p.activo,
      p.reftipoproductorama,
      tp.reftipoproducto,
      p.reftipodocumentaciones,
      p.refcuestionarios,
      p.reftipopersonas,
      p.precio,p.detalle,p.ventaenlinea,p.cotizaenlinea,p.beneficiario,p.asegurado
		from tbproductos p
		inner join tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
      inner join tbtipoproducto t on t.idtipoproducto = tp.reftipoproducto
      left join tbtipopersonas tpp ON tpp.idtipopersona = p.reftipoproductorama
		where t.idtipoproducto = 3
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


   /* PARA Tipoparentesco */

   function insertarTipoparentesco($tipoparentesco) {
      $sql = "insert into tbtipoparentesco(idtipoparentesco,tipoparentesco)
      values ('','".$tipoparentesco."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTipoparentesco($id,$tipoparentesco) {
      $sql = "update tbtipoparentesco
      set
      tipoparentesco = '".$tipoparentesco."'
      where idtipoparentesco =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTipoparentesco($id) {
      $sql = "delete from tbtipoparentesco where idtipoparentesco =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipoparentesco() {
      $sql = "select
      t.idtipoparentesco,
      t.tipoparentesco
      from tbtipoparentesco t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTipoparentescoPorId($id) {
      $sql = "select idtipoparentesco,tipoparentesco from tbtipoparentesco where idtipoparentesco =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtipoparentesco*/

   /* PARA Mejorarcondicionesarchivos */

   function insertarMejorarcondicionesarchivos($refmejorarcondiciones,$archivo,$fechacrea) {
   $sql = "insert into dbmejorarcondicionesarchivos(idmejorarcondicionarchivos,refmejorarcondiciones,archivo,fechacrea)
   values ('',".$refmejorarcondiciones.",'".$archivo."','".$fechacrea."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarMejorarcondicionesarchivos($id,$refmejorarcondiciones,$archivo,$fechacrea) {
   $sql = "update dbmejorarcondicionesarchivos
   set
   refmejorarcondiciones = ".$refmejorarcondiciones.",archivo = '".$archivo."',fechacrea = '".$fechacrea."'
   where idmejorarcondicionarchivos =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarMejorarcondicionesarchivos($id) {
   $sql = "delete from dbmejorarcondicionesarchivos where idmejorarcondicionarchivos =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMejorarcondicionesarchivos() {
   $sql = "select
   m.idmejorarcondicionarchivos,
   m.refmejorarcondiciones,
   m.archivo,
   m.fechacrea
   from dbmejorarcondicionesarchivos m
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerUltimoIdMejorarcondicionesarchivos() {
   $sql = "select
   max(m.idmejorarcondicionarchivos)
   from dbmejorarcondicionesarchivos m";
   $res = $this->query($sql,0);
   return mysql_result($res,0,0);
   }


   function traerMejorarcondicionesarchivosPorId($id) {
      $sql = "select idmejorarcondicionarchivos,refmejorarcondiciones,archivo,fechacrea from dbmejorarcondicionesarchivos where idmejorarcondicionarchivos =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerMejorarcondicionesarchivosPorMejora($id) {
      $sql = "select idmejorarcondicionarchivos,refmejorarcondiciones,archivo,fechacrea from dbmejorarcondicionesarchivos where refmejorarcondiciones =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMejorarcondicionesarchivosPorCliente($id) {
      $sql = "select
               idmejorarcondicionarchivos,refmejorarcondiciones,archivo,fechacrea
            from
            dbmejorarcondicionesarchivos m
            inner join dbmejorarcondiciones mc on mc.idmejorarcondicion = m.refmejorarcondiciones
            inner join dbclientes cli ON cli.idcliente = mc.refclientes
            where cli.idcliente =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbmejorarcondicionesarchivos*/



   /* PARA Mejorarcondiciones */

   function insertarMejorarcondiciones($refclientes,$refasesores,$fechacrea,$fechamodi,$observaciones) {
      $sql = "insert into dbmejorarcondiciones(idmejorarcondicion,refclientes,refasesores,fechacrea,fechamodi,observaciones)
      values ('',".$refclientes.",".$refasesores.",'".$fechacrea."','".$fechamodi."','".$observaciones."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarMejorarcondiciones($id,$refclientes,$refasesores,$fechacrea,$fechamodi,$observaciones) {
      $sql = "update dbmejorarcondiciones
      set
      refclientes = ".$refclientes.",refasesores = ".$refasesores.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',observaciones = '".$observaciones."'
      where idmejorarcondicion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarMejorarcondiciones($id) {
      $sql = "delete from dbmejorarcondiciones where idmejorarcondicion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerMejorarcondiciones() {
      $sql = "select
      m.idmejorarcondicion,
      m.refclientes,
      m.refasesores,
      m.fechacrea,
      m.fechamodi,
      m.observaciones
      from dbmejorarcondiciones m
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerMejorarcondicionesajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where pro.producto like '%".$busqueda."%')";
		}

      $sql = "select
      m.idmejorarcondicion,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
      m.observaciones,
      m.fechacrea,
      concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
      m.fechamodi,
      m.refclientes
      from dbmejorarcondiciones m
      inner join dbclientes cli ON cli.idcliente =m.refclientes
      inner join dbasesores ase on ase.idasesor = m.refasesores
      ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerMejorarcondicionesPorId($id) {
      $sql = "select idmejorarcondicion,refclientes,refasesores,fechacrea,fechamodi,observaciones from dbmejorarcondiciones where idmejorarcondicion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerMejorarcondicionesPorClienteEnElDia($id) {
      $sql = "select count(idmejorarcondicion) from dbmejorarcondiciones where refclientes =".$id." and year(fechacrea) = ".date('Y')." and month(fechacrea) = ".date('m')." and day(fechacrea) = ".date('d');
      $res = $this->query($sql,0);
      return mysql_result($res,0,0);
      //return $sql;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbmejorarcondiciones*/

   function necesitoPreguntaSencible($idcliente, $idcuestionario) {
      $sql = "select
            ps.campo, p.idpreguntacuestionario, p.pregunta
            from		dbpreguntascuestionario p
            inner
            join		tbpreguntassencibles ps on ps.idpreguntassencibles = p.refpreguntassencibles
            where		p.refcuestionarios = ".$idcuestionario;

      $res = $this->query($sql,0);

      $arExiste = array();
      $arNoExiste = array();
      while ($row = mysql_fetch_array($res)) {
         $sqlCliente = "select ".$row['campo']." from dbclientes where idcliente =".$idcliente;
         $resCC = $this->query($sqlCliente,0,0);
         if (mysql_num_rows($resCC) > 0) {
            if (mysql_result($resCC,0,0) != '') {
               array_push($arExiste,array('idpreguntanecesario' => (integer)$row['idpreguntacuestionario'], 'valor'=> mysql_result($resCC,0,0), 'pregunta'=>$row['pregunta'] ));
            } else {
               array_push($arNoExiste,array('idpreguntanecesario' => (integer)$row['idpreguntacuestionario'], 'valor'=> '','campo'=>$row['campo'] ));
            }
         }

      }

      return array($arExiste,$arNoExiste);

   }


   function necesitoPreguntaSencibleAsegurado($idasegurado, $idcuestionario) {
      $sql = "select
            ps.campo, p.idpreguntacuestionario, p.pregunta
            from		dbpreguntascuestionario p
            inner
            join		tbpreguntassencibles ps on ps.idpreguntassencibles = p.refpreguntassencibles
            where		p.refcuestionarios = ".$idcuestionario;

      $res = $this->query($sql,0);

      $arExiste = array();
      $arNoExiste = array();
      while ($row = mysql_fetch_array($res)) {
         $sqlCliente = "select ".$row['campo']." from dbasegurados where idasegurado =".$idasegurado;
         $resCC = $this->query($sqlCliente,0,0);
         if (mysql_num_rows($resCC) > 0) {
            if (mysql_result($resCC,0,0) != '') {
               array_push($arExiste,array('idpreguntanecesario' => (integer)$row['idpreguntacuestionario'], 'valor'=> mysql_result($resCC,0,0), 'pregunta'=>$row['pregunta'] ));
            } else {
               array_push($arNoExiste,array('idpreguntanecesario' => (integer)$row['idpreguntacuestionario'], 'valor'=> '','campo'=>$row['campo'] ));
            }
         }

      }

      return array($arExiste,$arNoExiste);

   }

   function traerPreguntaSenciblePorId($id) {
      $sql = "select campo, tabla from tbpreguntassencibles where idpreguntassencibles = ".$id;

      $res = $this->query($sql,0);

      return $res;
   }

   function getOption($arraySuperior,$mValue){
      foreach ($arraySuperior as $subArray){
         foreach ($subArray as $k=>$v){
            if ($v==$mValue){
            /*
            Encontrado el valor, no seguimos iterando sobre el array
            retornando el dato que se encuentre en la clave
            siguiente a donde se encuentre a $mValue
            */
               return 1;
            }
         }
      }
      return 0;
   }

   function traerPreguntassenciblesPorCuestionario($id) {
      $sql = "select
             ps.idpreguntassencibles,ps.campo
            from		tbpreguntassencibles ps
            left join	dbpreguntascuestionario pc
            on			ps.idpreguntassencibles = pc.refpreguntassencibles and pc.refcuestionarios = ".$id."
            where		pc.idpreguntacuestionario is null
            group by    ps.pregunta";

      $res = $this->query($sql,0);
      return $res;
   }

   function traerPreguntassenciblesPorCuestionarioObligatorias($id) {
      $sql = "select
             ps.idpreguntassencibles,ps.campo
            from		tbpreguntassencibles ps
            inner join	dbpreguntascuestionario pc
            on			ps.idpreguntassencibles = pc.refpreguntassencibles and pc.refcuestionarios = ".$id."
            group by    ps.pregunta";

      $res = $this->query($sql,0);
      return $res;
   }

   function nuevoOrdenPreguntas($idcuestionario) {
      $sql = "select
               coalesce(max(orden),0) + 1 as orden
             from dbpreguntascuestionario
             where	refcuestionarios = ".$idcuestionario;

      $res = $this->query($sql,0);
      return mysql_result($res,0,0);
   }

   function vigenciasDocumentacionesClientes($idcliente) {
      $resCliente = $this->traerClientesPorIdCompleto($idcliente);

      $errorVCD = mysql_result($resCliente,0,'demisioncomprobantedomicilio');
      $errorVRFC = mysql_result($resCliente,0,'demisionrfc');
      $errorVINE = mysql_result($resCliente,0,'dvencimientoine');

      $vcd = mysql_result($resCliente,0,'emisioncomprobantedomicilio') == '' ? 'Falta completar' : mysql_result($resCliente,0,'emisioncomprobantedomicilio');
      $vrfc = mysql_result($resCliente,0,'emisionrfc') == '' ? 'Falta completar' : mysql_result($resCliente,0,'emisionrfc');
      $vine = mysql_result($resCliente,0,'vencimientoine') == '' ? 'Falta completar' : mysql_result($resCliente,0,'vencimientoine');


      return array('errorVCD' => $errorVCD, 'errorVRFC' => $errorVRFC, 'errorVINE' => $errorVINE, 'vcd' => $vcd, 'vrfc' => $vrfc, 'vine' => $vine);

   }



   /* PARA Productosexclusivos */

   function insertarProductosexclusivos($refproductos,$refasesores) {
      $sql = "insert into dbproductosexclusivos(idproductoexclusivo,refproductos,refasesores)
      values ('',".$refproductos.",".$refasesores.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarProductosexclusivos($id,$refproductos,$refasesores) {
      $sql = "update dbproductosexclusivos
      set
      refproductos = ".$refproductos.",refasesores = ".$refasesores."
      where idproductoexclusivo =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarProductosexclusivos($id) {
      $sql = "delete from dbproductosexclusivos where idproductoexclusivo =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerProductosexclusivosajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where ".$roles." concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%')";
		}

      $sql = "select
      p.idproductoexclusivo,
      concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
      pro.producto,
      p.refproductos,
      p.refasesores
      from dbproductosexclusivos p
      inner join dbasesores ase ON ase.idasesor = p.refasesores
      inner join tbproductos pro ON pro.idproducto = p.refproductos
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerProductosexclusivos() {
      $sql = "select
      p.idproductoexclusivo,
      p.refproductos,
      p.refasesores
      from dbproductosexclusivos p
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerProductosexclusivosPorId($id) {
      $sql = "select idproductoexclusivo,refproductos,refasesores from dbproductosexclusivos where idproductoexclusivo =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbproductosexclusivos*/


/* PARA Procesocotizacion */

function insertarProcesocotizacion($procesocotizacion) {
$sql = "insert into tbprocesocotizacion(idprocesocotizacion,procesocotizacion)
values ('','".$procesocotizacion."')";
$res = $this->query($sql,1);
return $res;
}


function modificarProcesocotizacion($id,$procesocotizacion) {
$sql = "update tbprocesocotizacion
set
procesocotizacion = '".$procesocotizacion."'
where idprocesocotizacion =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarProcesocotizacion($id) {
$sql = "delete from tbprocesocotizacion where idprocesocotizacion =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerProcesocotizacion() {
$sql = "select
p.idprocesocotizacion,
p.procesocotizacion
from tbprocesocotizacion p
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerProcesocotizacionPorId($id) {
$sql = "select idprocesocotizacion,procesocotizacion from tbprocesocotizacion where idprocesocotizacion =".$id;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* /* Fin de la Tabla: tbprocesocotizacion*/





   function traerDependencia($idcuestionario, $idpregunta, $idrespuesta) {

      $sql = "
         select
         	coalesce(r.idpreguntacuestionario,0) as idpreguntacuestionario
         from (
         		select
                     c.idcuestionario,
                     c.cuestionario,
                     (case when c.activo = '1' then 'Si' else 'No' end) as activo,
                     pre.pregunta,
                     (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
                     tr.idtiporespuesta,
                     tr.tiporespuesta,
                     pre.idpreguntacuestionario,
                     coalesce( pre.depende,0) as dependeaux,
                     coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
                     pre.obligatoria
                  from dbcuestionarios c
                  inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario
                  inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta

                  where c.idcuestionario =".$idcuestionario."
         	) r
         where r.dependeaux = ".$idpregunta." and r.dependerespuestaaux = ".$idrespuesta;

      if ($idpregunta > 0) {
         $res = $this->query($sql,0);
         if (mysql_num_rows($res) > 0 ) {
            return mysql_result($res,0,0);
         } else {
            return 0;
         }
      }  else {
         return 0;
      }
   }

   function traerRespuestaGuardada($idpregunta,$idrespuesta,$idcotizacion) {
      $sql = "SELECT
                cd.respuesta, cd.respuestavalor
            FROM
                dbcuestionariodetalle cd
            WHERE
                cd.reftabla = 11
                    AND cd.idreferencia = ".$idcotizacion."
                    AND cd.refpreguntascuestionario = ".$idpregunta."
                    AND cd.refrespuestascuestionario = ".$idrespuesta;

      $res = $this->query($sql,0);

      if (mysql_num_rows($res) > 0) {
         return array('respuesta'=> mysql_result($res,0,'respuesta'), 'respuestavalor' => mysql_result($res,0,'respuestavalor'),'error'=> true);
      }
      return array('respuesta'=> 0, 'respuestavalor' => 0,'error'=> false);
   }

   function existeRespuestaApreguntaGuardada($idpregunta,$idcotizacion) {
      $sql = "SELECT
                cd.respuesta, cd.respuestavalor
            FROM
                dbcuestionariodetalle cd
            WHERE
                cd.reftabla = 11
                    AND cd.idreferencia = ".$idcotizacion."
                    AND cd.refpreguntascuestionario = ".$idpregunta;

      $res = $this->query($sql,0);

      if (mysql_num_rows($res) > 0) {
         return array('respuesta'=> mysql_result($res,0,'respuesta'), 'respuestavalor' => mysql_result($res,0,'respuestavalor'),'error'=> true);
      }
      return array('respuesta'=> 0, 'respuestavalor' => 0,'error'=> false);
   }

   function resolverDuplicidadCuestionarioDetalle($reftabla, $idreferencia) {
      $sql = "SELECT max(idcuestionariodetalle) as idcuestionariodetalle,idreferencia,reftabla
               FROM u115752684_asesores.dbcuestionariodetalle
               where idreferencia = ".$idreferencia." and reftabla = ".$reftabla."
               group by refpreguntascuestionario,idreferencia,reftabla
               having count(refpreguntascuestionario)>1";

      $res = $this->query($sql,0);

      while ($row = mysql_fetch_array($res)) {
         $resEliminar = $this->eliminarCuestionariodetalle($row['idcuestionariodetalle']);
      }

      return '';
   }

   // cuestionario0
   function CuestionarioPreguntasSeleccionadas($idcuestionario,$idcotizacion,$idcliente=0,$preguntasseleccionadas) {
      //die(var_dump($idcuestionario));

      if ($preguntasseleccionadas != '') {
         $preguntasseleccionadas = substr($preguntasseleccionadas,0,-1);
      } else {
         $preguntasseleccionadas = '0';
      }

      $resultado = $this->traerCuestionariosPorIdCompletoRPreguntasSeleccionadas($idcuestionario,$idcotizacion,$preguntasseleccionadas);

      $preguntasSencibles = $this->necesitoPreguntaSencible($idcliente,$idcuestionario);
      $cad = '';
      $cad .= '<div class="row" style="padding: 5px 20px;">';


         $pregunta = '';
         $iRadio = 0;
         $iCheck = 0;
         $iCheckM = 0;
         $rules = array();

         $collapse = '';
         $collapseAux = '';
         $collapsePregunta = '';

         $primero = 0;

         // poner en local el utf8_encode

         while ($row = mysql_fetch_array($resultado)) {
            if ($this->getOption($preguntasSencibles[0],$row['idpreguntacuestionario'] ) == 0 ) {

            if ($pregunta != $row['pregunta']) {
               $pregunta = $row['pregunta'];

               $collapsePregunta = $collapseAux;

               $cantRadio = 0;
               $cantCheck = 0;

               $collapse2 = '';
               if ($primero == 1) {
                  $cad .= '</div>';
               }

               if ($row['dependeaux'] > 0) {

                  $primero = 1;

                  $cad .= '<div class="escondido" id="'.$collapsePregunta.'" style="margin-left:25px;color:#888;">';
               }

               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
                  <h4>'.($row['pregunta']).'</h4>
               </div>';

               if ($row['idtiporespuesta'] == 1) {
                  array_push($rules,
                        array('respuesta' => 'respuesta'.$row['idpreguntacuestionario'],
                        'pregunta' => ($row['pregunta']),
                        'tipo'=>1,
                        'idpregunta' => $row['idpreguntacuestionario'],
                        'idrespuesta' => $row['idrespuestacuestionario'],
                        'obligatoria' => $row['obligatoria'],
                        'depende' => $row['depende'],
                        'dependerespuesta' => $row['dependerespuesta'],
                        'dependeaux' => $row['dependeaux'],
                        'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }

               if ($row['idtiporespuesta'] == 2) {
                  array_push($rules,array('respuesta'=> 'respuesta'.$row['idpreguntacuestionario'],
                  'pregunta' => ($row['pregunta']),
                  'tipo'=>2,
                  'idpregunta'=>$row['idpreguntacuestionario'],
                  'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }
               if ($row['idtiporespuesta'] == 3) {
                  array_push($rules,array('respuesta'=> 'respuestamulti'.$row['idpreguntacuestionario'],
                  'pregunta' => ($row['pregunta']),
                  'tipo'=>3,
                  'idpregunta'=>$row['idpreguntacuestionario'],
                  'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }


            }

            if ($row['idtiporespuesta'] == 1) {

               if ($row['obligatoria'] == '1') {
                  $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="form-line">
                           <input type="text" autocomplete="off" class="form-control" id="respuesta" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false" value="'.($row['respuestacargada'] == '0' ? '' : $row['respuestacargada']).'">

                        </div>
                     </div>
                  </div>';
               } else {
                  $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="form-line">
                           <input type="text" autocomplete="off" class="form-control" id="respuesta" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.($row['respuestacargada'] == '0' ? '' : $row['respuestacargada']).'">

                        </div>
                     </div>
                  </div>';
               }

            }


            if ($row['idtiporespuesta'] == 2) {
               $iRadio += 1;

               $cantRadio += 1;

               if ($row['depende']>0) {
                  $collapse = 'onclick="document.getElementById('."'".'collapse_radio_'.$row['idpreguntacuestionario'].($iRadio + 1)."'".').style.display='."'".'block'."'".';"';
                  $collapse2 = 'onclick="document.getElementById('."'".'collapse_radio_'.$row['idpreguntacuestionario'].($iRadio + 1)."'".').style.display='."'".'none'."'".';"';

                  $collapseAux = "collapse_radio_".$row['idpreguntacuestionario'].($iRadio + 1);
               } else {
                  $collapse = '';
               }

               if ($cantRadio >= 2) {
                  $collapse = $collapse2;
               }


               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                  <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="radio" id="radio_'.$row['idpreguntacuestionario'].$iRadio.'" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').' '.$collapse.'>
                        <label for="radio_'.$row['idpreguntacuestionario'].$iRadio.'">'.($row['respuesta']).'</label>
                     </div>
                  </div>
               </div>';



            }


            if ($row['idtiporespuesta'] == 3) {
               $iCheck += 1;

               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                  <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="radio" id="radio_multi_'.$iCheck.'" name="respuestamulti'.$row['idpreguntacuestionario'].'" value="'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').'>
                        <label for="radio_multi_'.$iCheck.'">'.($row['respuesta']).'</label>
                     </div>
                  </div>
               </div>';



            }


            if ($row['idtiporespuesta'] == 4) {
               $iCheckM += 1;

               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

               <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="checkbox" class="filled-in respuestavarias'.$row['idpreguntacuestionario'].'" id="basic_checkbox_'.$row['idrespuestacuestionario'].'" name="respuestamultim'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').'>
                        <label for="basic_checkbox_'.$row['idrespuestacuestionario'].'">'.($row['respuesta']).'</label>
                     </div>
                  </div>
               </div>';

               if ($row['idtiporespuesta'] == 4) {
                  array_push($rules,array('respuesta'=> 'respuestamultim'.$row['idrespuestacuestionario'],
                  'pregunta' => ($row['pregunta']),
                  'tipo'=>4,
                  'idpregunta'=>$row['idpreguntacuestionario'],
                  'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }

            }


         }
      }

      $cad .= '</div>';

      return array('cuestionario'=>$cad,'rules'=>$rules);
   }

   // cuestionario1
   function Cuestionario($idcuestionario,$idcotizacion,$idcliente=0) {
      //die(var_dump($idcuestionario));

      $resultado = $this->traerCuestionariosPorIdCompletoR($idcuestionario,$idcotizacion);

      $preguntasSencibles = $this->necesitoPreguntaSencible($idcliente,$idcuestionario);
      $cad = '';
      $cad .= '<div class="row" style="padding: 5px 20px;">';


         $pregunta = '';
         $iRadio = 0;
         $iCheck = 0;
         $iCheckM = 0;
         $rules = array();

         $collapse = '';
         $collapseAux = '';
         $collapsePregunta = '';

         $primero = 0;

         // poner en local el utf8_encode

         while ($row = mysql_fetch_array($resultado)) {
            if ($this->getOption($preguntasSencibles[0],$row['idpreguntacuestionario'] ) == 0 ) {

            if ($pregunta != $row['pregunta']) {
               $pregunta = $row['pregunta'];

               $collapsePregunta = $collapseAux;

               $cantRadio = 0;
               $cantCheck = 0;

               $collapse2 = '';
               if ($primero == 1) {
                  $cad .= '</div>';
               }

               if ($row['dependeaux'] > 0) {

                  $primero = 1;

                  $cad .= '<div class="escondido" id="'.$collapsePregunta.'" style="margin-left:25px;color:#888;">';
               }

               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContpregunta" style="display:block">
                  <h4>'.($row['pregunta']).'</h4>
               </div>';

               if ($row['idtiporespuesta'] == 1) {
                  array_push($rules,
                        array('respuesta' => 'respuesta'.$row['idpreguntacuestionario'],
                        'pregunta' => ($row['pregunta']),
                        'tipo'=>1,
                        'idpregunta' => $row['idpreguntacuestionario'],
                        'idrespuesta' => $row['idrespuestacuestionario'],
                        'obligatoria' => $row['obligatoria'],
                        'depende' => $row['depende'],
                        'dependerespuesta' => $row['dependerespuesta'],
                        'dependeaux' => $row['dependeaux'],
                        'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }

               if ($row['idtiporespuesta'] == 2) {
                  array_push($rules,array('respuesta'=> 'respuesta'.$row['idpreguntacuestionario'],
                  'pregunta' => ($row['pregunta']),
                  'tipo'=>2,
                  'idpregunta'=>$row['idpreguntacuestionario'],
                  'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }
               if ($row['idtiporespuesta'] == 3) {
                  array_push($rules,array('respuesta'=> 'respuestamulti'.$row['idpreguntacuestionario'],
                  'pregunta' => ($row['pregunta']),
                  'tipo'=>3,
                  'idpregunta'=>$row['idpreguntacuestionario'],
                  'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }


            }

            if ($row['idtiporespuesta'] == 1) {

               if ($row['obligatoria'] == '1') {
                  $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="form-line">
                           <input type="text" autocomplete="off" class="form-control" id="respuesta" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false" value="'.($row['respuestacargada'] == '0' ? '' : $row['respuestacargada']).'">

                        </div>
                     </div>
                  </div>';
               } else {
                  $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="form-line">
                           <input type="text" autocomplete="off" class="form-control" id="respuesta" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.($row['respuestacargada'] == '0' ? '' : $row['respuestacargada']).'">

                        </div>
                     </div>
                  </div>';
               }

            }


            if ($row['idtiporespuesta'] == 2) {
               $iRadio += 1;

               $cantRadio += 1;

               if ($row['depende']>0) {
                  $collapse = 'onclick="document.getElementById('."'".'collapse_radio_'.$row['idpreguntacuestionario'].($iRadio + 1)."'".').style.display='."'".'block'."'".';"';
                  $collapse2 = 'onclick="document.getElementById('."'".'collapse_radio_'.$row['idpreguntacuestionario'].($iRadio + 1)."'".').style.display='."'".'none'."'".';"';

                  $collapseAux = "collapse_radio_".$row['idpreguntacuestionario'].($iRadio + 1);
               } else {
                  $collapse = '';
               }

               if ($cantRadio >= 2) {
                  $collapse = $collapse2;
               }


               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                  <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="radio" id="radio_'.$row['idpreguntacuestionario'].$iRadio.'" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').' '.$collapse.'>
                        <label for="radio_'.$row['idpreguntacuestionario'].$iRadio.'">'.($row['respuesta']).'</label>
                     </div>
                  </div>
               </div>';



            }


            if ($row['idtiporespuesta'] == 3) {
               $iCheck += 1;

               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                  <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="radio" id="radio_multi_'.$iCheck.'" name="respuestamulti'.$row['idpreguntacuestionario'].'" value="'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').'>
                        <label for="radio_multi_'.$iCheck.'">'.($row['respuesta']).'</label>
                     </div>
                  </div>
               </div>';



            }


            if ($row['idtiporespuesta'] == 4) {
               $iCheckM += 1;

               $cad .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

               <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="checkbox" class="filled-in respuestavarias'.$row['idpreguntacuestionario'].'" id="basic_checkbox_'.$row['idrespuestacuestionario'].'" name="respuestamultim'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').'>
                        <label for="basic_checkbox_'.$row['idrespuestacuestionario'].'">'.($row['respuesta']).'</label>
                     </div>
                  </div>
               </div>';

               if ($row['idtiporespuesta'] == 4) {
                  array_push($rules,array('respuesta'=> 'respuestamultim'.$row['idrespuestacuestionario'],
                  'pregunta' => ($row['pregunta']),
                  'tipo'=>4,
                  'idpregunta'=>$row['idpreguntacuestionario'],
                  'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }

            }


         }
      }

      $cad .= '</div>';

      return array('cuestionario'=>$cad,'rules'=>$rules);
   }

   // cuestionario2
   function CuestionarioAux($idcuestionario,$idcotizacion,$idcliente=0) {
      //die(var_dump($idcuestionario));


      $resultado = $this->traerPreguntasCuestionarioPorIdCompletoR($idcuestionario);



      $preguntasSencibles = $this->necesitoPreguntaSencible($idcliente,$idcuestionario);



      $arPreguntas = array();
      $arRespuestas = array();

      //$columna = array_column($preguntasSencibles, 'idpreguntanecesario');
      //die(var_dump(array_search( '24' , $columna ) ));

      while ($row = mysql_fetch_array($resultado)) {


         //if ($this->getOption($preguntasSencibles[0],$row['idpreguntacuestionario'] ) == 0 ) {


            $resRespuesta = $this->traerRespuestascuestionarioPorPregunta($row['idpreguntacuestionario']);

            $resPreguntaRespondida = $this->existeRespuestaApreguntaGuardada($row['idpreguntacuestionario'], $idcotizacion);

            $cadInput = '';
            $cadValorRespuesta = '';

            $dependenciaData = '';

            if (($row['dependeaux'] > 0) && ($resPreguntaRespondida['error']==false)) {
               $escondido = 'escondido escondido'.$row['dependeaux'];
            } else {
               $escondido = '';
            }

            $aparecer = '';

            while ($rowR = mysql_fetch_array($resRespuesta)) {

               $resDependencia = $this->traerDependencia($idcuestionario, $row['idpreguntacuestionario'], $rowR['idrespuestacuestionario']);
               $resValorRespuesta = $this->traerRespuestaGuardada($row['idpreguntacuestionario'],$rowR['idrespuestacuestionario'],$idcotizacion);

               //die(var_dump($row['idpreguntacuestionario'].'-'.$rowR['idrespuestacuestionario'].'-'.$resDependencia));

               if ($resDependencia > 0) {
                  $dependenciaData = ' data-pregunta="'.$resDependencia.'" data-respuesta="'.$rowR['idrespuestacuestionario'].'" ';
               } else {
                  $dependenciaData = '';
               }


               // tipo de pregunta simple
               if ($row['idtiporespuesta'] == 1) {
                  //traigo el valor de lo que cargo
                  if ($resValorRespuesta['error']) {
                     $cadValorRespuesta = $resValorRespuesta['respuestavalor'];
                  } else {
                     $cadValorRespuesta = '';
                  }

                  if ($row['obligatoria'] == '1') {
                     $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                        <div class="form-group input-group">
                           <div class="form-line">
                              <input type="text" autocomplete="off" class="form-control" id="respuesta'.str_replace(' ','',$row['pregunta']).'" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false" value="'.$cadValorRespuesta.'" >

                           </div>
                        </div>
                     </div>';
                  } else {
                     $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                        <div class="form-group input-group">
                           <div class="form-line">
                              <input type="text" autocomplete="off" class="form-control" id="respuesta'.str_replace(' ','',$row['pregunta']).'" value="'.$cadValorRespuesta.'" name="respuesta'.$row['idpreguntacuestionario'].'" >

                           </div>
                        </div>
                     </div>';
                  }
               }

               // tipo de pregu8nta binaria
               if ($row['idtiporespuesta'] == 2) {

                  //traigo el valor de lo que cargo
                  if ($resValorRespuesta['error']) {
                     $cadValorRespuesta = 'checked';
                  } else {
                     $cadValorRespuesta = '';
                  }

                  $cadInput .= '<div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="demo-radio-button">
                           <input class="aparecer" type="radio" id="radio_'.$rowR['idrespuestacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.$rowR['idrespuestacuestionario'].'" '.$dependenciaData.' data-idpregunta="'.$row['idpreguntacuestionario'].'" '.$cadValorRespuesta.' >
                           <label for="radio_'.$rowR['idrespuestacuestionario'].'">'.$rowR['respuesta'].'</label>
                        </div>
                     </div>
                  </div>';
               }

               // tipo de pregunta multiple
               if ($row['idtiporespuesta'] == 3) {

                  //traigo el valor de lo que cargo
                  if ($resValorRespuesta['error']) {
                     $cadValorRespuesta = 'checked';
                  } else {
                     $cadValorRespuesta = '';
                  }

                  $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="demo-radio-button">
                           <input class="aparecer" type="radio" id="radio_multi_'.$rowR['idrespuestacuestionario'].'" name="respuestamulti'.$row['idpreguntacuestionario'].'" value="'.$rowR['idrespuestacuestionario'].'" '.$dependenciaData.' data-idpregunta="'.$row['idpreguntacuestionario'].'" '.$cadValorRespuesta.' >
                           <label for="radio_multi_'.$rowR['idrespuestacuestionario'].'">'.$rowR['respuesta'].'</label>
                        </div>
                     </div>
                  </div>';
               }

               // tipo de pregunta multiple con nultiple seleccion
               if ($row['idtiporespuesta'] == 4) {

                  //traigo el valor de lo que cargo
                  if ($resValorRespuesta['error']) {
                     $cadValorRespuesta = 'checked';
                  } else {
                     $cadValorRespuesta = '';
                  }

                  $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="demo-radio-button">
                           <input type="checkbox" class="filled-in respuestavarias'.$row['idpreguntacuestionario'].'" id="basic_checkbox_'.$rowR['idrespuestacuestionario'].'" name="respuestamultim'.$rowR['idrespuestacuestionario'].'" '.$dependenciaData.' '.$cadValorRespuesta.' >
                           <label for="basic_checkbox_'.$rowR['idrespuestacuestionario'].'">'.$rowR['respuesta'].'</label>
                        </div>
                     </div>
                  </div>';
               }


            }

            array_push($arPreguntas,array(
               'divRow' => '<div class="row '.$escondido.' clcontPregunta'.$row['dependerespuestaaux'].'" style="padding: 5px 20px;" id="contPregunta'.$row['idpreguntacuestionario'].'">',
               'pregunta' => $row['pregunta'],
               'idpregunta'=>$row['idpreguntacuestionario'],
               'respuestas' => $cadInput,
               'leyenda' =>$row['leyenda']
            ));




         //}

      }


      return $arPreguntas;

   }


   function CuestionarioPersonas($idcuestionario,$idcotizacion,$idcliente=0,$idasegurado=0) {
      //die(var_dump($idcuestionario));

      $resultado = $this->traerCuestionariosPorIdCompletoRSencibles($idcuestionario,$idcotizacion);

      if ($idcliente != 0) {
         $preguntasSencibles = $this->necesitoPreguntaSencible($idcliente,$idcuestionario);
      } else {
         $preguntasSencibles = $this->necesitoPreguntaSencibleAsegurado($idasegurado,$idcuestionario);
      }



      $cad = '';
      $cad .= '<div class="row" style="padding: 5px 20px;">';


         $pregunta = '';
         $iRadio = 0;
         $iCheck = 0;
         $iCheckM = 0;
         $rules = array();

         $collapse = '';
         $collapseAux = '';
         $collapsePregunta = '';

         $primero = 0;

         while ($row = mysql_fetch_array($resultado)) {
            if ($this->getOption($preguntasSencibles[0],$row['idpreguntacuestionario'] ) == 0 ) {

            if ($pregunta != $row['pregunta']) {
               $pregunta = $row['pregunta'];

               $collapsePregunta = $collapseAux;

               $cantRadio = 0;
               $cantCheck = 0;

               $collapse2 = '';
               if ($primero == 1) {
                  $cad .= '</div>';
               }

               if ($row['dependeaux'] > 0) {

                  $primero = 1;

                  $cad .= '<div class="escondido" id="'.$collapsePregunta.'" style="margin-left:25px;color:#888;">';
               }

               $cad .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContpregunta" style="display:block">
                  <h4>'.$row['pregunta'].'</h4>
               </div>';

               if ($row['idtiporespuesta'] == 1) {
                  array_push($rules,
                        array('respuesta' => 'respuesta'.$row['idpreguntacuestionario'],
                        'pregunta' => $row['pregunta'],
                        'tipo'=>1,
                        'idpregunta' => $row['idpreguntacuestionario'],
                        'idrespuesta' => $row['idrespuestacuestionario'],
                        'obligatoria' => $row['obligatoria'],
                        'depende' => $row['depende'],
                        'dependerespuesta' => $row['dependerespuesta'],
                        'dependeaux' => $row['dependeaux'],
                        'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }

               if ($row['idtiporespuesta'] == 2) {
                  array_push($rules,array('respuesta'=> 'respuesta'.$row['idpreguntacuestionario'],'pregunta' => $row['pregunta'],'tipo'=>2,'idpregunta'=>$row['idpreguntacuestionario'],'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }
               if ($row['idtiporespuesta'] == 3) {
                  array_push($rules,array('respuesta'=> 'respuestamulti'.$row['idpreguntacuestionario'],'pregunta' => $row['pregunta'],'tipo'=>3,'idpregunta'=>$row['idpreguntacuestionario'],'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }


            }

            if ($row['idtiporespuesta'] == 1) {

               if ($row['obligatoria'] == '1') {
                  $cad .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="form-line">
                           <input type="text" autocomplete="off" class="form-control" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false" value="'.($row['respuestacargada'] == '0' ? '' : $row['respuestacargada']).'">

                        </div>
                     </div>
                  </div>';
               } else {
                  $cad .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrespuesta" style="display:block">

                     <div class="form-group input-group">
                        <div class="form-line">
                           <input type="text" autocomplete="off" class="form-control" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.($row['respuestacargada'] == '0' ? '' : $row['respuestacargada']).'">

                        </div>
                     </div>
                  </div>';
               }

            }


            if ($row['idtiporespuesta'] == 2) {
               $iRadio += 1;

               $cantRadio += 1;

               if ($row['depende']>0) {
                  $collapse = 'onclick="document.getElementById('."'".'collapse_radio_'.$row['idpreguntacuestionario'].($iRadio + 1)."'".').style.display='."'".'block'."'".';"';
                  $collapse2 = 'onclick="document.getElementById('."'".'collapse_radio_'.$row['idpreguntacuestionario'].($iRadio + 1)."'".').style.display='."'".'none'."'".';"';

                  $collapseAux = "collapse_radio_".$row['idpreguntacuestionario'].($iRadio + 1);
               } else {
                  $collapse = '';
               }

               if ($cantRadio >= 2) {
                  $collapse = $collapse2;
               }


               $cad .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrespuesta" style="display:block">

                  <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="radio" id="radio_'.$row['idpreguntacuestionario'].$iRadio.'" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').' '.$collapse.'>
                        <label for="radio_'.$row['idpreguntacuestionario'].$iRadio.'">'.$row['respuesta'].'</label>
                     </div>
                  </div>
               </div>';



            }


            if ($row['idtiporespuesta'] == 3) {
               $iCheck += 1;

               $cad .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrespuesta" style="display:block">

                  <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="radio" id="radio_multi_'.$iCheck.'" name="respuestamulti'.$row['idpreguntacuestionario'].'" value="'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').'>
                        <label for="radio_multi_'.$iCheck.'">'.$row['respuesta'].'</label>
                     </div>
                  </div>
               </div>';



            }


            if ($row['idtiporespuesta'] == 4) {
               $iCheckM += 1;

               $cad .= '<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 frmContrespuesta" style="display:block">

               <div class="form-group input-group">
                     <div class="demo-radio-button">
                        <input type="checkbox" class="filled-in respuestavarias'.$row['idpreguntacuestionario'].'" id="basic_checkbox_'.$row['idrespuestacuestionario'].'" name="respuestamultim'.$row['idrespuestacuestionario'].'" '.($row['respuestacargada'] == '1' ? 'checked' : '').'>
                        <label for="basic_checkbox_'.$row['idrespuestacuestionario'].'">'.$row['respuesta'].'</label>
                     </div>
                  </div>
               </div>';

               if ($row['idtiporespuesta'] == 4) {
                  array_push($rules,array('respuesta'=> 'respuestamultim'.$row['idrespuestacuestionario'],'pregunta' => $row['pregunta'],'tipo'=>4,'idpregunta'=>$row['idpreguntacuestionario'],'idrespuesta'=>$row['idrespuestacuestionario'],
                  'obligatoria' => $row['obligatoria'],
                  'depende' => $row['depende'],
                  'dependerespuesta' => $row['dependerespuesta'],
                  'dependeaux' => $row['dependeaux'],
                  'dependerespuestaaux' => $row['dependerespuestaaux'] ));
               }

            }


         }
      }

      $cad .= '</div>';

      return array('cuestionario'=>$cad,'rules'=>$rules);
   }


   function CuestionarioAuxPersonas($idcuestionario,$idcotizacion,$idcliente=0,$idasegurado=0) {
      //die(var_dump($idcuestionario));

      $resultado = $this->traerCuestionariosPorIdCompletoRSencibles($idcuestionario,$idcotizacion);

      if ($idcliente != 0) {
         $preguntasSencibles = $this->necesitoPreguntaSencible($idcliente,$idcuestionario);
      } else {
         $preguntasSencibles = $this->necesitoPreguntaSencibleAsegurado($idasegurado,$idcuestionario);
      }



      $arPreguntas = array();
      $arRespuestas = array();

      //$columna = array_column($preguntasSencibles, 'idpreguntanecesario');
      //die(var_dump(array_search( '24' , $columna ) ));

      while ($row = mysql_fetch_array($resultado)) {


         if ($this->getOption($preguntasSencibles[0],$row['idpreguntacuestionario'] ) == 0 ) {


            $resRespuesta = $this->traerRespuestascuestionarioPorPregunta($row['idpreguntacuestionario']);

            $resPreguntaRespondida = $this->existeRespuestaApreguntaGuardada($row['idpreguntacuestionario'], $idcotizacion);

            $cadInput = '';
            $cadValorRespuesta = '';

            $dependenciaData = '';

            if (($row['dependeaux'] > 0) && ($resPreguntaRespondida['error']==false)) {
               $escondido = 'escondido escondido'.$row['dependeaux'];
            } else {
               $escondido = '';
            }

            $aparecer = '';

            while ($rowR = mysql_fetch_array($resRespuesta)) {

               $resDependencia = $this->traerDependencia($idcuestionario, $row['idpreguntacuestionario'], $rowR['idrespuestacuestionario']);
               $resValorRespuesta = $this->traerRespuestaGuardada($row['idpreguntacuestionario'],$rowR['idrespuestacuestionario'],$idcotizacion);

               //die(var_dump($row['idpreguntacuestionario'].'-'.$rowR['idrespuestacuestionario'].'-'.$resDependencia));

               if ($resDependencia > 0) {
                  $dependenciaData = ' data-pregunta="'.$resDependencia.'" data-respuesta="'.$rowR['idrespuestacuestionario'].'" ';
               } else {
                  $dependenciaData = '';
               }


               if ($row['pregunta'] == 'genero') {
                  if ($row['obligatoria'] == '1') {
                     $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                        <div class="form-group input-group">
                           <div class="form-line">
                              <select class="form-control ts'.$row['campo'].'" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false">
                                 <option value="Femenino">Femenino</option>
                                 <option value="Masculino">Masculino</option>
                              </select>
                           </div>
                        </div>
                     </div>';
                  } else {
                     $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                        <div class="form-group input-group">
                           <div class="form-line">
                              <select class="form-control ts'.$row['campo'].'" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'">
                                 <option value="Femenino">Femenino</option>
                                 <option value="Masculino">Masculino</option>
                              </select>

                           </div>
                        </div>
                     </div>';
                  }
               } else {
                  if ($row['pregunta'] == 'refestadocivil') {
                     $resEstadoCivil = $this->traerEstadocivilPorIn('1,2');
                     $cadEC = $this->devolverSelectBox($resEstadoCivil,array(1),'');

                     if ($row['obligatoria'] == '1') {
                        $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                           <div class="form-group input-group">
                              <div class="form-line">
                                 <select class="form-control ts'.$row['campo'].'" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false">
                                    '.$cadEC.'
                                 </select>

                              </div>
                           </div>
                        </div>';
                     } else {
                        $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                           <div class="form-group input-group">
                              <div class="form-line">
                                 <select class="form-control ts'.$row['campo'].'" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'">
                                    '.$cadEC.'
                                 </select>

                              </div>
                           </div>
                        </div>';
                     }

                  } else {
                     // tipo de pregunta simple
                     if ($row['idtiporespuesta'] == 1) {
                        //traigo el valor de lo que cargo
                        if ($resValorRespuesta['error']) {
                           $cadValorRespuesta = $resValorRespuesta['respuestavalor'];
                        } else {
                           $cadValorRespuesta = '';
                        }

                        if ($row['obligatoria'] == '1') {
                           $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                              <div class="form-group input-group">
                                 <div class="form-line">
                                    <input type="text" autocomplete="off" class="form-control ts'.$row['campo'].'" id="respuesta'.$row['idpreguntacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" required="" aria-required="true" aria-invalid="false" value="'.$cadValorRespuesta.'" >

                                 </div>
                              </div>
                           </div>';
                        } else {
                           $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                              <div class="form-group input-group">
                                 <div class="form-line">
                                    <input type="text" autocomplete="off" class="form-control ts'.$row['campo'].'" id="respuesta'.$row['idpreguntacuestionario'].'" value="'.$cadValorRespuesta.'" name="respuesta'.$row['idpreguntacuestionario'].'" >

                                 </div>
                              </div>
                           </div>';
                        }
                     }

                     // tipo de pregu8nta binaria
                     if ($row['idtiporespuesta'] == 2) {

                        //traigo el valor de lo que cargo
                        if ($resValorRespuesta['error']) {
                           $cadValorRespuesta = 'checked';
                        } else {
                           $cadValorRespuesta = '';
                        }

                        $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                           <div class="form-group input-group">
                              <div class="demo-radio-button">
                                 <input class="aparecer" type="radio" id="radio_'.$rowR['idrespuestacuestionario'].'" name="respuesta'.$row['idpreguntacuestionario'].'" value="'.$rowR['idrespuestacuestionario'].'" '.$dependenciaData.' data-idpregunta="'.$row['idpreguntacuestionario'].'" '.$cadValorRespuesta.' >
                                 <label for="radio_'.$rowR['idrespuestacuestionario'].'">'.$rowR['respuesta'].'</label>
                              </div>
                           </div>
                        </div>';
                     }

                     // tipo de pregunta multiple
                     if ($row['idtiporespuesta'] == 3) {

                        //traigo el valor de lo que cargo
                        if ($resValorRespuesta['error']) {
                           $cadValorRespuesta = 'checked';
                        } else {
                           $cadValorRespuesta = '';
                        }

                        $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                           <div class="form-group input-group">
                              <div class="demo-radio-button">
                                 <input class="aparecer" type="radio" id="radio_multi_'.$rowR['idrespuestacuestionario'].'" name="respuestamulti'.$row['idpreguntacuestionario'].'" value="'.$rowR['idrespuestacuestionario'].'" '.$dependenciaData.' data-idpregunta="'.$row['idpreguntacuestionario'].'" '.$cadValorRespuesta.' >
                                 <label for="radio_multi_'.$rowR['idrespuestacuestionario'].'">'.$rowR['respuesta'].'</label>
                              </div>
                           </div>
                        </div>';
                     }

                     // tipo de pregunta multiple con nultiple seleccion
                     if ($row['idtiporespuesta'] == 4) {

                        //traigo el valor de lo que cargo
                        if ($resValorRespuesta['error']) {
                           $cadValorRespuesta = 'checked';
                        } else {
                           $cadValorRespuesta = '';
                        }

                        $cadInput .= '<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 frmContrespuesta" style="display:block">

                           <div class="form-group input-group">
                              <div class="demo-radio-button">
                                 <input type="checkbox" class="filled-in respuestavarias'.$row['idpreguntacuestionario'].'" id="basic_checkbox_'.$rowR['idrespuestacuestionario'].'" name="respuestamultim'.$rowR['idrespuestacuestionario'].'" '.$dependenciaData.' '.$cadValorRespuesta.' >
                                 <label for="basic_checkbox_'.$rowR['idrespuestacuestionario'].'">'.$rowR['respuesta'].'</label>
                              </div>
                           </div>
                        </div>';
                     }
                  }
               }



            }

            array_push($arPreguntas,array(
               'divRow' => '<div class="row col-xs-4 '.$escondido.' clcontPregunta'.$row['dependerespuestaaux'].'" style="padding: 5px 20px;" id="contPregunta'.$row['idpreguntacuestionario'].'">',
               'pregunta' => $row['pregunta'],
               'idpregunta'=>$row['idpreguntacuestionario'],
               'respuestas' => $cadInput
            ));




         }

      }


      return $arPreguntas;

   }

   /* PARA Respuestascuestionario */

   function insertarRespuestascuestionario($respuesta,$refpreguntascuestionario,$orden,$activo,$leyenda,$refpreguntassencibles,$inhabilita,$refsolicitudesrespuestas) {
      $sql = "insert into dbrespuestascuestionario(idrespuestacuestionario,respuesta,refpreguntascuestionario,orden,activo,leyenda,refpreguntassencibles,inhabilita,refsolicitudesrespuestas)
      values ('','".$respuesta."',".$refpreguntascuestionario.",".$orden.",'".$activo."','".$leyenda."',".$refpreguntassencibles.",'".$inhabilita."',".$refsolicitudesrespuestas.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarRespuestascuestionario($id,$respuesta,$refpreguntascuestionario,$orden,$activo,$leyenda,$inhabilita,$refsolicitudesrespuestas) {
      $sql = "update dbrespuestascuestionario
      set
      respuesta = '".$respuesta."',refpreguntascuestionario = ".$refpreguntascuestionario.",orden = ".$orden.",activo = '".$activo."',leyenda = '".$leyenda."',inhabilita = '".$inhabilita."',refsolicitudesrespuestas = ".$refsolicitudesrespuestas." where idrespuestacuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function modificarRespuestascuestionarioSolicitud($id,$refsolicitudesrespuestas) {
      $sql = "update dbrespuestascuestionario
      set
      refsolicitudesrespuestas = ".$refsolicitudesrespuestas."
      where idrespuestacuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarRespuestascuestionario($id) {
      $sql = "delete from dbrespuestascuestionario where idrespuestacuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerNotificacionesGridajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where (n.mensaje like '%".$busqueda."%' or n.autor like '%".$busqueda."%' or n.destinatario like '%".$busqueda."%')";
		}

      $sql = "select
      n.idnotificacion,
      n.mensaje,
      n.autor,
      n.destinatario,
      n.fecha,
      (case when n.leido = 1 then 'Si' else 'No' end) as leido,
      n.idpagina,
      n.id1,
      n.id2,
      n.id3,
      n.icono,
      n.estilo,
      n.url
      from dbnotificaciones n
      ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }

   function traerRespuestascuestionarioajax($length, $start, $busqueda,$colSort,$colSortDir,$idpregunta) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." r.respuesta like '%".$busqueda."%' or (case when r.activo = '1' then 'Si' else 'No' end) like '%".$busqueda."%')";
		}


		$sql = "select
         r.idrespuestacuestionario,
         r.respuesta,
         r.orden,
         (case when r.activo = '1' then 'Si' else 'No' end) as activo,
         r.refpreguntascuestionario
      from dbrespuestascuestionario r
      inner join dbpreguntascuestionario pre ON pre.idpreguntacuestionario = r.refpreguntascuestionario
      inner join dbcuestionarios cu ON cu.idcuestionario = pre.refcuestionarios
      inner join tbtiporespuesta ti ON ti.idtiporespuesta = pre.reftiporespuesta
      where pre.idpreguntacuestionario = ".$idpregunta." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerRespuestascuestionario() {
      $sql = "select
      r.idrespuestacuestionario,
      r.respuesta,
      r.refpreguntascuestionario,
      r.orden,
      r.activo
      from dbrespuestascuestionario r
      inner join dbpreguntascuestionario pre ON pre.idpreguntacuestionario = r.refpreguntascuestionario
      inner join dbcuestionarios cu ON cu.idcuestionario = pre.refcuestionarios
      inner join tbtiporespuesta ti ON ti.idtiporespuesta = pre.reftiporespuesta
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }

   function traerRespuestascuestionarioPorPregunta($idpregunta) {
      $sql = "select
      r.idrespuestacuestionario,
      r.respuesta,
      r.refpreguntascuestionario,
      r.orden,
      r.activo,
      r.leyenda,
      r.refpreguntassencibles,
      pe.tabla,
      pe.campo,
      r.inhabilita
      from dbrespuestascuestionario r
      inner join dbpreguntascuestionario pre ON pre.idpreguntacuestionario = r.refpreguntascuestionario
      inner join dbcuestionarios cu ON cu.idcuestionario = pre.refcuestionarios
      inner join tbtiporespuesta ti ON ti.idtiporespuesta = pre.reftiporespuesta
      left join tbpreguntassencibles pe on pe.idpreguntassencibles = r.refpreguntassencibles
      where pre.idpreguntacuestionario =".$idpregunta."
      order by r.orden";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerRespuestascuestionarioPorId($id) {
      $sql = "select idrespuestacuestionario,respuesta,refpreguntascuestionario,orden,activo,leyenda,refpreguntassencibles,inhabilita,refsolicitudesrespuestas from dbrespuestascuestionario where idrespuestacuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function inhabilitaRespuestascuestionarioPorCotizacion($id) {
      $sql = "select
               rc.inhabilita
            from dbcuestionarios c
            inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario and pre.activo='1'
            inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
            inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario and rc.activo='1'
            inner join dbcuestionariodetalle cd on cd.refpreguntascuestionario = pre.idpreguntacuestionario and cd.refrespuestascuestionario = rc.idrespuestacuestionario and cd.idreferencia = ".$id."
            where rc.inhabilita = '1'";
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbrespuestascuestionario*/


   /* PARA Preguntascuestionario */

   function insertarPreguntascuestionario($refcuestionarios,$reftiporespuesta,$pregunta,$orden,$valor,$depende,$tiempo,$activo,$dependerespuesta,$obligatoria,$leyenda,$refpreguntassencibles) {
      $sql = "insert into dbpreguntascuestionario(idpreguntacuestionario,refcuestionarios,reftiporespuesta,pregunta,orden,valor,depende,tiempo,activo,dependerespuesta,obligatoria,leyenda,refpreguntassencibles)
      values ('',".$refcuestionarios.",".$reftiporespuesta.",'".$pregunta."',".$orden.",".$valor.",".$depende.",".$tiempo.",'".$activo."',".$dependerespuesta.",'".$obligatoria."','".$leyenda."',".$refpreguntassencibles.")";

      $res = $this->query($sql,1);
      return $res;
   }


   function modificarPreguntascuestionario($id,$refcuestionarios,$reftiporespuesta,$pregunta,$orden,$valor,$depende,$tiempo,$activo,$dependerespuesta,$obligatoria,$leyenda) {
      $sql = "update dbpreguntascuestionario
      set
      refcuestionarios = ".$refcuestionarios.",reftiporespuesta = ".$reftiporespuesta.",pregunta = '".$pregunta."',orden = ".$orden.",valor = ".$valor.",depende = ".$depende.",tiempo = ".$tiempo.",activo = '".$activo."',dependerespuesta = ".$dependerespuesta.",obligatoria = '".$obligatoria."',leyenda = '".$leyenda."'
      where idpreguntacuestionario =".$id;

      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarPreguntascuestionario($id) {
      $sql = "update dbpreguntascuestionario set activo = '0' where idpreguntacuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function eliminarPreguntascuestionarioDefinitivo($id) {


      $sqlRespuestas = "delete from dbrespuestascuestionario where refpreguntascuestionario = ".$id;
      $res = $this->query($sqlRespuestas,0);

      $sql = "delete from dbpreguntascuestionario where idpreguntacuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerPreguntascuestionarioajax($length, $start, $busqueda,$colSort,$colSortDir,$idcuestionario) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and cue.cuestionario like '%".$busqueda."%' or tip.tiporespuesta like '%".$busqueda."%' or p.pregunta like '%".$busqueda."%' or (case when p.activo = '1' then 'Si' else 'No' end) like '%".$busqueda."%'";
		}


		$sql = "select
         p.idpreguntacuestionario,
         cue.cuestionario,
         tip.tiporespuesta,
         p.pregunta,
         p.orden,
         (case when p.activo = '1' then 'Si' else 'No' end) as activo,
         (case when p.obligatoria = '1' then 'Si' else 'No' end) as obligatoria,
         p.valor,
         p.depende,
         p.tiempo,
         p.refcuestionarios,
         p.reftiporespuesta
      from dbpreguntascuestionario p
      inner join dbcuestionarios cue ON cue.idcuestionario = p.refcuestionarios
      inner join tbtiporespuesta tip ON tip.idtiporespuesta = p.reftiporespuesta
      where cue.idcuestionario = ".$idcuestionario." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerPreguntascuestionario() {
      $sql = "select
      p.idpreguntacuestionario,
      p.refcuestionarios,
      p.reftiporespuesta,
      p.pregunta,
      p.orden,
      p.valor,
      p.depende,
      p.tiempo,
      p.activo
      from dbpreguntascuestionario p
      inner join dbcuestionarios cue ON cue.idcuestionario = p.refcuestionarios
      inner join tbtiporespuesta tip ON tip.idtiporespuesta = p.reftiporespuesta
      order by 1";

      $res = $this->query($sql,0);
      return $res;
   }

   function traerPreguntascuestionarioPorCuestionario($idcuestionario) {
      $sql = "select
      p.idpreguntacuestionario,
      p.refcuestionarios,
      p.reftiporespuesta,
      p.pregunta,
      p.orden,
      p.valor,
      p.depende,
      p.tiempo,
      p.activo,
      p.leyenda,
      p.refpreguntassencibles,
      pe.tabla,
      pe.campo
      from dbpreguntascuestionario p
      inner join dbcuestionarios cue ON cue.idcuestionario = p.refcuestionarios
      inner join tbtiporespuesta tip ON tip.idtiporespuesta = p.reftiporespuesta
      left join tbpreguntassencibles pe on pe.idpreguntassencibles = p.refpreguntassencibles
      where cue.idcuestionario = ".$idcuestionario."
      order by p.orden";

      $res = $this->query($sql,0);
      return $res;
   }


   function traerPreguntascuestionarioPorId($id) {
      $sql = "select idpreguntacuestionario,refcuestionarios,reftiporespuesta,pregunta,
      orden,valor,depende,tiempo,activo,dependerespuesta,obligatoria,leyenda,refpreguntassencibles
      from dbpreguntascuestionario where idpreguntacuestionario =".$id;

      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbpreguntascuestionario*/

   /* PARA Tiporespuesta */

   function insertarTiporespuesta($tiporespuesta) {
      $sql = "insert into tbtiporespuesta(idtiporespuesta,tiporespuesta)
      values ('','".$tiporespuesta."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarTiporespuesta($id,$tiporespuesta) {
      $sql = "update tbtiporespuesta
      set
      tiporespuesta = '".$tiporespuesta."'
      where idtiporespuesta =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarTiporespuesta($id) {
      $sql = "delete from tbtiporespuesta where idtiporespuesta =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTiporespuesta() {
      $sql = "select
      t.idtiporespuesta,
      t.tiporespuesta
      from tbtiporespuesta t
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerTiporespuestaPorId($id) {
      $sql = "select idtiporespuesta,tiporespuesta from tbtiporespuesta where idtiporespuesta =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtiporespuesta*/


   /* PARA Cuestionariodetalle */

   function insertarCuestionariodetalle($reftabla,$idreferencia,$refpreguntascuestionario,$refrespuestascuestionario,$pregunta,$respuesta,$respuestavalor,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
      $sql = "insert into dbcuestionariodetalle(idcuestionariodetalle,reftabla,idreferencia,refpreguntascuestionario,refrespuestascuestionario,pregunta,respuesta,respuestavalor,fechacrea,fechamodi,usuariocrea,usuariomodi)
      values ('',".$reftabla.",".$idreferencia.",".$refpreguntascuestionario.",".$refrespuestascuestionario.",'".$pregunta."','".$respuesta."','".$respuestavalor."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarCuestionariodetalle($id,$reftabla,$idreferencia,$refpreguntascuestionario,$refrespuestascuestionario,$pregunta,$respuesta,$respuestavalor,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
   $sql = "update dbcuestionariodetalle
   set
   reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",refpreguntascuestionario = ".$refpreguntascuestionario.",refrespuestascuestionario = ".$refrespuestascuestionario.",pregunta = '".$pregunta."',respuesta = '".$respuesta."',respuestavalor = '".$respuestavalor."',fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
   where idcuestionariodetalle =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarCuestionariodetalle($id) {
   $sql = "delete from dbcuestionariodetalle where idcuestionariodetalle =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerCuestionariodetalle() {
   $sql = "select
   c.idcuestionariodetalle,
   c.reftabla,
   c.idreferencia,
   c.refpreguntascuestionario,
   c.refrespuestascuestionario,
   c.pregunta,
   c.respuesta,
   c.respuestavalor,
   c.fechacrea,
   c.fechamodi,
   c.usuariocrea,
   c.usuariomodi
   from dbcuestionariodetalle c
   inner join dbpreguntascuestionario pre ON pre.idpreguntacuestionario = c.refpreguntascuestionario
   inner join dbcuestionarios cu ON cu.idcuestionario = pre.refcuestionarios
   inner join tbtiporespuesta ti ON ti.idtiporespuesta = pre.reftiporespuesta
   inner join dbrespuestascuestionario res ON res.idrespuestacuestionario = c.refrespuestascuestionario
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerCuestionariodetallePorTablaReferencia($idtabla, $tabla, $idnombre, $id) {
		$sql = "select
      c.idcuestionariodetalle,
      c.reftabla,
      c.idreferencia,
      c.refpreguntascuestionario,
      c.refrespuestascuestionario,
      c.pregunta,
      c.respuesta,
      c.respuestavalor,
      c.fechacrea,
      c.fechamodi,
      c.usuariocrea,
      c.usuariomodi,
      cu.idcuestionario
      from dbcuestionariodetalle c
      inner join dbpreguntascuestionario pre ON pre.idpreguntacuestionario = c.refpreguntascuestionario and (pre.refpreguntassencibles is null or pre.refpreguntassencibles = 0)
      inner join dbcuestionarios cu ON cu.idcuestionario = pre.refcuestionarios
      inner join tbtiporespuesta ti ON ti.idtiporespuesta = pre.reftiporespuesta
      inner join dbrespuestascuestionario res ON res.idrespuestacuestionario = c.refrespuestascuestionario
		inner join ".$tabla." v on v.".$idnombre." = c.idreferencia
		where c.reftabla = ".$idtabla." and c.idreferencia = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerCuestionariodetallePorId($id) {
   $sql = "select idcuestionariodetalle,reftabla,idreferencia,refpreguntascuestionario,refrespuestascuestionario,pregunta,respuesta,respuestavalor,fechacrea,fechamodi,usuariocrea,usuariomodi from dbcuestionariodetalle where idcuestionariodetalle =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbcuestionariodetalle*/


   /* PARA Cuestionarios */

   function insertarCuestionarios($cuestionario,$activo) {
   $sql = "insert into dbcuestionarios(idcuestionario,cuestionario,activo)
   values ('','".$cuestionario."','".$activo."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarCuestionarios($id,$cuestionario,$activo) {
   $sql = "update dbcuestionarios
   set
   cuestionario = '".$cuestionario."',activo = '".$activo."'
   where idcuestionario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarCuestionarios($id) {
      $sql = "update dbcuestionarios set activo = '0' where idcuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function eliminarCuestionariosDefinitivo($id) {
      $sql = "delete from dbcuestionarios where idcuestionario =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerCuestionariosajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where ".$roles." c.cuestionario like '%".$busqueda."%' or (case when c.activo = '1' then 'Si' else 'No' end) like '%".$busqueda."%')";
		}


		$sql = "select
         c.idcuestionario,
         c.cuestionario,
         (case when c.activo = '1' then 'Si' else 'No' end) as activo
      from dbcuestionarios c
       ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerCuestionarios() {
   $sql = "select
   c.idcuestionario,
   c.cuestionario,
   c.activo
   from dbcuestionarios c
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerCuestionariosPorId($id) {
   $sql = "select idcuestionario,cuestionario,activo from dbcuestionarios where idcuestionario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerCuestionariosPorIdCompletoSolicitudIncompleto($id) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            (case when rc.activo = '1' then 'Si' else 'No' end) as activorespuesta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            rc.respuesta,
            rc.idrespuestacuestionario,
            pre.idpreguntacuestionario,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.refpreguntassencibles
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario

         where c.idcuestionario =".$id." and (rc.refsolicitudesrespuestas is null or rc.refsolicitudesrespuestas=0) and rc.activo = '1' and pre.activo = '1'
         order by pre.orden,rc.orden ";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerCuestionariosPorIdCompletoSolicitudCompleto($id) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            (case when rc.activo = '1' then 'Si' else 'No' end) as activorespuesta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            rc.respuesta,
            rc.idrespuestacuestionario,
            pre.idpreguntacuestionario,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.refpreguntassencibles
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario
         where c.idcuestionario =".$id." and rc.refsolicitudesrespuestas > 0 and rc.activo = '1' and pre.activo = '1' order by pre.orden,rc.orden ";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerCuestionariosPorIdCompleto($id) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            (case when rc.activo = '1' then 'Si' else 'No' end) as activorespuesta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            rc.respuesta,
            rc.idrespuestacuestionario,
            pre.idpreguntacuestionario,
            coalesce( prer.depende,0) as depende,
            coalesce( prer.dependerespuesta,0) as dependerespuesta,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.refpreguntassencibles
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario
         left join dbpreguntascuestionario prer on prer.depende = pre.idpreguntacuestionario and prer.dependerespuesta = rc.idrespuestacuestionario
         where c.idcuestionario =".$id." order by pre.orden,rc.orden ";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerCuestionariosPorIdCompletoR($id, $idcotizacion) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            (case when rc.activo = '1' then 'Si' else 'No' end) as activorespuesta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            rc.respuesta,
            rc.idrespuestacuestionario,
            pre.idpreguntacuestionario,
            (case when cd.idcuestionariodetalle is null then '0' else (case when tr.idtiporespuesta = 1 then cd.respuestavalor else '1'end) end ) as respuestacargada,
            coalesce( prer.depende,0) as depende,
            coalesce( prer.dependerespuesta,0) as dependerespuesta,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.obligatoria
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario and pre.activo='1'
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario and rc.activo='1'
         left join dbcuestionariodetalle cd on cd.refpreguntascuestionario = pre.idpreguntacuestionario and cd.refrespuestascuestionario = rc.idrespuestacuestionario and cd.idreferencia = ".$idcotizacion."
         left join dbpreguntascuestionario prer on prer.depende = pre.idpreguntacuestionario and prer.dependerespuesta = rc.idrespuestacuestionario
         where c.idcuestionario =".$id." and (pre.refpreguntassencibles is null or pre.refpreguntassencibles = 0) order by pre.orden,rc.orden ";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerCuestionariosPorIdCompletoRPreguntasSeleccionadas($id, $idcotizacion, $preguntasseleccionadas) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            (case when rc.activo = '1' then 'Si' else 'No' end) as activorespuesta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            rc.respuesta,
            rc.idrespuestacuestionario,
            pre.idpreguntacuestionario,
            (case when cd.idcuestionariodetalle is null then '0' else (case when tr.idtiporespuesta = 1 then cd.respuestavalor else '1'end) end ) as respuestacargada,
            coalesce( prer.depende,0) as depende,
            coalesce( prer.dependerespuesta,0) as dependerespuesta,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.obligatoria
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario and pre.activo='1'
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario and rc.activo='1'
         left join dbcuestionariodetalle cd on cd.refpreguntascuestionario = pre.idpreguntacuestionario and cd.refrespuestascuestionario = rc.idrespuestacuestionario and cd.idreferencia = ".$idcotizacion."
         left join dbpreguntascuestionario prer on prer.depende = pre.idpreguntacuestionario and prer.dependerespuesta = rc.idrespuestacuestionario
         where c.idcuestionario =".$id." and (pre.refpreguntassencibles is null or pre.refpreguntassencibles = 0)
         and pre.idpreguntacuestionario in (".$preguntasseleccionadas.")
         order by pre.orden,rc.orden ";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerCuestionariosPorIdCompletoRSencibles($id, $idcotizacion) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            (case when rc.activo = '1' then 'Si' else 'No' end) as activorespuesta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            rc.respuesta,
            rc.idrespuestacuestionario,
            pre.idpreguntacuestionario,
            (case when cd.idcuestionariodetalle is null then '0' else (case when tr.idtiporespuesta = 1 then cd.respuestavalor else '1'end) end ) as respuestacargada,
            coalesce( prer.depende,0) as depende,
            coalesce( prer.dependerespuesta,0) as dependerespuesta,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.obligatoria,
            ts.campo
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario and pre.activo='1' and pre.refpreguntassencibles > 0
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbrespuestascuestionario rc ON rc.refpreguntascuestionario = pre.idpreguntacuestionario and rc.activo='1'
         left join dbcuestionariodetalle cd on cd.refpreguntascuestionario = pre.idpreguntacuestionario and cd.refrespuestascuestionario = rc.idrespuestacuestionario and cd.idreferencia = ".$idcotizacion."
         left join dbpreguntascuestionario prer on prer.depende = pre.idpreguntacuestionario and prer.dependerespuesta = rc.idrespuestacuestionario
         inner join tbpreguntassencibles ts ON ts.idpreguntassencibles = pre.refpreguntassencibles
         where c.idcuestionario =".$id." order by pre.orden,rc.orden ";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPreguntasCuestionarioPorIdCompletoR($id) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            pre.idpreguntacuestionario,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.obligatoria,
            pre.leyenda
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario and pre.activo='1'
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         where c.idcuestionario =".$id." and (pre.refpreguntassencibles is null or pre.refpreguntassencibles = 0) order by pre.orden ";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPreguntasCuestionarioPorIdCompletoRFijo($id,$idcotizacion) {
   $sql = "select
            c.idcuestionario,
            c.cuestionario,
            (case when c.activo = '1' then 'Si' else 'No' end) as activo,
            pre.pregunta,
            (case when pre.activo = '1' then 'Si' else 'No' end) as activopregunta,
            tr.idtiporespuesta,
            tr.tiporespuesta,
            pre.idpreguntacuestionario,
            coalesce( pre.depende,0) as dependeaux,
            coalesce( pre.dependerespuesta ,0) as dependerespuestaaux,
            pre.obligatoria
         from dbcuestionarios c
         inner join dbpreguntascuestionario pre ON pre.refcuestionarios = c.idcuestionario and pre.activo='1'
         inner join tbtiporespuesta tr ON tr.idtiporespuesta = pre.reftiporespuesta
         inner join dbcuestionariodetalle cd on cd.refpreguntascuestionario = pre.idpreguntacuestionario and cd.idreferencia = ".$idcotizacion."
         where c.idcuestionario =".$id." and (pre.refpreguntassencibles is null or pre.refpreguntassencibles = 0) order by pre.orden ";
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: dbcuestionarios*/

   /* PARA Aseguradora */

   function insertarAseguradora($razonsocial) {
      $sql = "insert into tbaseguradora(idaseguradora,razonsocial)
      values ('','".$razonsocial."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarAseguradora($id,$razonsocial) {
      $sql = "update tbaseguradora
      set
      razonsocial = '".$razonsocial."'
      where idaseguradora =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarAseguradora($id) {
      $sql = "delete from tbaseguradora where idaseguradora =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerAseguradora() {
      $sql = "select
      a.idaseguradora,
      a.razonsocial
      from tbaseguradora a
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerAseguradoraPorId($id) {
      $sql = "select idaseguradora,razonsocial from tbaseguradora where idaseguradora =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbaseguradora*/


	/* PARA Periodicidadventaspagos */

   function insertarPeriodicidadventaspagos($refperiodicidadventasdetalle,$monto,$nrorecibo,$fechapago,$usuariocrea,$usuariomodi,$fechacrea,$fechamodi,$nrofactura) {
      $sql = "insert into dbperiodicidadventaspagos(idperiodicidadventapago,refperiodicidadventasdetalle,monto,nrorecibo,fechapago,usuariocrea,usuariomodi,fechacrea,fechamodi,nrofactura)
         values ('',".$refperiodicidadventasdetalle.",".$monto.",'".$nrorecibo."','".$fechapago."','".$usuariocrea."','".$usuariomodi."','".$fechacrea."','".$fechamodi."','".$nrofactura."')";

      $res = $this->query($sql,1);
      return $res;
   }


   function modificarPeriodicidadventaspagos($id,$refperiodicidadventasdetalle,$monto,$nrorecibo,$fechapago,$usuariocrea,$usuariomodi,$fechacrea,$fechamodi,$nrofactura,$avisoinbursa) {
      $sql = "update dbperiodicidadventaspagos
      set
      refperiodicidadventasdetalle = ".$refperiodicidadventasdetalle.",monto = ".$monto.",nrorecibo = '".$nrorecibo."',fechapago = '".$fechapago."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."',fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',nrofactura = '".$nrofactura."',avisoinbursa = '".$avisoinbursa."'      where idperiodicidadventapago =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function avisarVentaPago($id,$avisoinbursa) {
   $sql = "update dbperiodicidadventaspagos
   set
   avisoinbursa = '".$avisoinbursa."' where refperiodicidadventasdetalle =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function marcarFechaPagoRealInbursa($id) {
   $sql = "update dbperiodicidadventasdetalle
   set
   fechapagoreal = now() where idperiodicidadventadetalle =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


	function eliminarPeriodicidadventaspagos($id) {
		$sql = "delete from dbperiodicidadventaspagos where idperiodicidadventapago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPeriodicidadventaspagos() {
		$sql = "select
		p.idperiodicidadventapago,
		p.refperiodicidadventasdetalle,
		p.monto,
		p.nrorecibo,
		p.fechapago,
		p.usuariocrea,
		p.usuariomodi,
		p.fechacrea,
		p.fechamodi,
      p.nrofactura
		from dbperiodicidadventaspagos p
		inner join dbperiodicidadventasdetalle per ON per.idperiodicidadventadetalle = p.refperiodicidadventasdetalle
		inner join dbperiodicidadventas pe ON pe.idperiodicidadventa = per.refperiodicidadventas
		inner join tbestadopago es ON es.idestadopago = per.refestadopago
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPeriodicidadventaspagosPorCobro($id) {
		$sql = "select
		p.idperiodicidadventapago,
		p.refperiodicidadventasdetalle,
		p.monto,
		p.nrorecibo,
		p.fechapago,
		p.usuariocrea,
		p.usuariomodi,
		p.fechacrea,
		p.fechamodi,
      p.nrofactura,
      p.avisoinbursa,
      per.fechapagoreal
		from dbperiodicidadventaspagos p
		inner join dbperiodicidadventasdetalle per ON per.idperiodicidadventadetalle = p.refperiodicidadventasdetalle
		inner join dbperiodicidadventas pe ON pe.idperiodicidadventa = per.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = pe.refventas
		inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
		inner join dbclientes cli ON cli.idcliente = co.refclientes
		inner join tbproductos pro ON pro.idproducto = co.refproductos
		inner join tbestadopago es ON es.idestadopago = per.refestadopago
		where per.idperiodicidadventadetalle = ".$id."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPeriodicidadventaspagosPorId($id) {
		$sql = "select idperiodicidadventapago,refperiodicidadventasdetalle,monto,nrorecibo,fechapago,usuariocrea,usuariomodi,fechacrea,fechamodi,nrofactura,avisoinbursa from dbperiodicidadventaspagos where idperiodicidadventapago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbperiodicidadventaspagos*/


	function traerCobranzaajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';

      $cadCliente = '';
      $cadAsesor = '';

      if ($_SESSION['idroll_sahilices'] == 16) {
   		$resCliente = $this->traerClientesPorUsuarioCompleto($_SESSION['usuaid_sahilices']);

   		$cadCliente = ' and cli.idcliente = '.mysql_result($resCliente,0,'idcliente').' ';
   	}

      if ($_SESSION['idroll_sahilices'] == 7) {

   		$cadAsesor = ' and ase.refusuarios = '.$_SESSION['usuaid_sahilices'].' ';
   	}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%')";
		}


		$sql = "select
						p.idperiodicidadventadetalle,
						(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
						ve.nropoliza,
						p.fechavencimiento,
						cli.numerocliente,
						cli.idclienteinbursa,
						p.nrorecibo,
						est.estadopago,
						p.montototal,
						p.primaneta,
						p.porcentajecomision,
						p.montocomision,
						p.fechapago,
						est.estadopago,
						p.nrorecibo,
						ea.estadoasesor,
						p.refestadopago,
						p.usuariocrea,
						p.usuariomodi,
						p.fechacrea,
						p.fechamodi,
						p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = per.refventas
        inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
        inner join dbclientes cli on cli.idcliente = co.refclientes
        inner join dbasesores ase on ase.idasesor = co.refasesores
        inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago

        where p.refestadopago in (1,3) ".$cadCliente.$cadAsesor.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

   function traerCobranzaVentaajax($length, $start, $busqueda,$colSort,$colSortDir,$idventa) {
		$where = '';

      $cadCliente = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%')";
		}


		$sql = "select
						p.idperiodicidadventadetalle,
						concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
						ve.nropoliza,
						p.fechavencimiento,
						cli.numerocliente,
						cli.idclienteinbursa,
						p.nrorecibo,
						est.estadopago,
						p.montototal,
						p.primaneta,
						p.porcentajecomision,
						p.montocomision,
						p.fechapago,
						p.fechavencimiento,
						est.estadopago,
						p.nrorecibo,
						ea.estadoasesor,
						p.refestadopago,
						p.usuariocrea,
						p.usuariomodi,
						p.fechacrea,
						p.fechamodi,
						p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = per.refventas
        inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
        inner join dbclientes cli on cli.idcliente = co.refclientes
        inner join dbasesores ase on ase.idasesor = co.refasesores
        inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago

        where p.refestadopago in (1,3) and ve.idventa = ".$idventa." ".$cadCliente.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerCobranzaPorEstadosajax($length, $start, $busqueda,$colSort,$colSortDir,$idestado) {
		$where = '';

      $cadCliente = '';
      $cadAsesor = '';

      $cadValidar = '';
      if ($idestado == 999) {
         $cadValidar = " inner join dbdocumentacionventas dv on dv.refperiodicidadventas = p.idperiodicidadventadetalle and dv.refdocumentaciones = 39 and dv.refestadodocumentaciones <> 5 ";
         $idestado = '1,3';
      }

      if ($_SESSION['idroll_sahilices'] == 16) {
   		$resCliente = $this->traerClientesPorUsuarioCompleto($_SESSION['usuaid_sahilices']);

   		$cadCliente = ' and cli.idcliente = '.mysql_result($resCliente,0,'idcliente').' ';
   	}

      if ($_SESSION['idroll_sahilices'] == 7) {

   		$cadAsesor = ' and ase.refusuarios = '.$_SESSION['usuaid_sahilices'].' ';
   	}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%' or est.estadopago like '%".$busqueda."%')";
		}


		$sql = "select
						p.idperiodicidadventadetalle,
						(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
						ve.nropoliza,
						p.fechavencimiento,
						cli.numerocliente,
						cli.idclienteinbursa,
						p.nrorecibo,
						est.estadopago,
						p.montototal,
						p.primaneta,
						p.porcentajecomision,
						p.montocomision,
						p.fechapago,
						p.fechavencimiento,
						est.estadopago,
						p.nrorecibo,
						ea.estadoasesor,
						p.refestadopago,
						p.usuariocrea,
						p.usuariomodi,
						p.fechacrea,
						p.fechamodi,
						p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = per.refventas
      inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
      inner join dbclientes cli on cli.idcliente = co.refclientes
      inner join dbasesores ase on ase.idasesor = co.refasesores
      inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago
      ".$cadValidar."
        where p.refestadopago in (".$idestado.") ".$cadCliente.$cadAsesor.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

   // todo lo aplicado
   function traerFacturacionajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';

      $cadCliente = '';

      $cadValidar = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%' or est.estadopago like '%".$busqueda."%')";
		}


		$sql = "select
						p.idperiodicidadventadetalle,
						concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
						ve.nropoliza,
						p.fechavencimiento,
						cli.numerocliente,
						cli.idclienteinbursa,
						p.nrorecibo,
						p.montototal,
                  p.fechapagoreal,
						p.primaneta,
						p.porcentajecomision,
						p.montocomision,
						p.fechapago,
                  est.estadopago,
						p.fechavencimiento,
						p.nrorecibo,
						ea.estadoasesor,
                  est.estadopago,
						p.refestadopago,
						p.usuariocrea,
						p.usuariomodi,
						p.fechacrea,
						p.fechamodi,
						p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = per.refventas
      inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
      inner join dbclientes cli on cli.idcliente = co.refclientes
      inner join dbasesores ase on ase.idasesor = co.refasesores
      inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago
      inner join dbperiodicidadventaspagos pp ON pp.refperiodicidadventasdetalle = p.idperiodicidadventadetalle
        where p.refestadopago in (5) ".$cadCliente.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   // todo lo aplicado
   function traerFacturacionRecibosajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';

      $cadCliente = '';

      $cadValidar = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%' or est.estadopago like '%".$busqueda."%')";
		}


		$sql = "
                select
            		p.idperiodicidadventadetalle,
            		concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
            		ve.nropoliza,
            		p.fechavencimiento,
            		cli.numerocliente,
            		cli.idclienteinbursa,
            		p.nrorecibo,
            		p.montototal,
            		p.fechapagoreal,
            		p.primaneta,
            		p.porcentajecomision,
            		p.montocomision,
            		p.fechapago,
            		est.estadopago,
            		p.fechavencimiento,
            		p.nrorecibo,
            		ea.estadoasesor,
            		est.estadopago,
            		p.refestadopago,
            		p.usuariocrea,
            		p.usuariomodi,
            		p.fechacrea,
            		p.fechamodi,
            		p.refperiodicidadventas
            	from dbperiodicidadventasdetalle p
            		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
            		inner join dbventas ve ON ve.idventa = per.refventas
            		inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
            		inner join dbclientes cli on cli.idcliente = co.refclientes
            		inner join dbasesores ase on ase.idasesor = co.refasesores
            		inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
            		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
            		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
            		inner join tbestadopago est ON est.idestadopago = p.refestadopago
            		inner join dbperiodicidadventaspagos pp ON pp.refperiodicidadventasdetalle = p.idperiodicidadventadetalle

        where p.refestadopago in (5) ".$cadCliente.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

   // todo lo aplicado
   function traerFacturacionGlobalesajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';

      $cadCliente = '';

      $cadValidar = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or doc.documentacion like '%".$busqueda."%')";
		}


		$sql = "select
               dvv.iddocumentacionventa,
               concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
               doc.documentacion,
               ve.nropoliza,
               cli.numerocliente,
               cli.idclienteinbursa,
               ve.fechavencimientopoliza

         from dbventas ve
         inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
         inner join dbclientes cli on cli.idcliente = co.refclientes
         inner join dbasesores ase on ase.idasesor = co.refasesores
         inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
         inner join dbdocumentacionventas dvv on dvv.refventas = ve.idventa
         inner join dbdocumentaciones doc on doc.iddocumentacion = dvv.refdocumentaciones and doc.iddocumentacion in (147,148)

        where 1=1 ".$cadCliente.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   // todo lo aplicado
   function traerFacturacionClienteRecibosajax($length, $start, $busqueda,$colSort,$colSortDir,$idcliente) {
		$where = '';

      $cadCliente = '';

      $cadValidar = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%' or est.estadopago like '%".$busqueda."%')";
		}


		$sql = "
                select
            		p.idperiodicidadventadetalle,
            		concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
            		ve.nropoliza,
            		p.fechapago,
            		cli.numerocliente,
            		cli.idclienteinbursa,
            		p.nrorecibo,
            		p.montototal,
            		p.fechapagoreal,
            		p.primaneta,
            		p.porcentajecomision,
            		p.montocomision,
            		p.fechapago,
            		est.estadopago,
            		p.fechavencimiento,
            		p.nrorecibo,
            		ea.estadoasesor,
            		est.estadopago,
            		p.refestadopago,
            		p.usuariocrea,
            		p.usuariomodi,
            		p.fechacrea,
            		p.fechamodi,
            		p.refperiodicidadventas
            	from dbperiodicidadventasdetalle p
            		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
            		inner join dbventas ve ON ve.idventa = per.refventas
            		inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
            		inner join dbclientes cli on cli.idcliente = co.refclientes
            		inner join dbasesores ase on ase.idasesor = co.refasesores
            		inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
            		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
            		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
            		inner join tbestadopago est ON est.idestadopago = p.refestadopago
            		inner join dbperiodicidadventaspagos pp ON pp.refperiodicidadventasdetalle = p.idperiodicidadventadetalle

        where cli.refusuarios = ".$idcliente." and p.refestadopago in (5) ".$cadCliente.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

   // todo lo aplicado
   function traerFacturacionClienteGlobalesajax($length, $start, $busqueda,$colSort,$colSortDir,$idcliente) {
		$where = '';

      $cadCliente = '';

      $cadValidar = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or doc.documentacion like '%".$busqueda."%')";
		}


		$sql = "select
               dvv.iddocumentacionventa,
               concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
               doc.documentacion,
               ve.nropoliza,
               cli.numerocliente,
               cli.idclienteinbursa,
               ve.fechavencimientopoliza

         from dbventas ve
         inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
         inner join dbclientes cli on cli.idcliente = co.refclientes
         inner join dbasesores ase on ase.idasesor = co.refasesores
         inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
         inner join dbdocumentacionventas dvv on dvv.refventas = ve.idventa
         inner join dbdocumentaciones doc on doc.iddocumentacion = dvv.refdocumentaciones and doc.iddocumentacion in (147,148)

        where cli.refusuarios = ".$idcliente." ".$cadCliente.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerCobranzaInbursaajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';


		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%')";
		}


		$sql = "select
						p.idperiodicidadventadetalle,
						(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
						ve.nropoliza,
						p.fechavencimiento,
						cli.numerocliente,
						cli.idclienteinbursa,
						p.nrorecibo,
						est.estadopago,
						p.montototal,
						p.primaneta,
						p.porcentajecomision,
						p.montocomision,
						p.fechapago,
						p.fechavencimiento,
						est.estadopago,
						p.nrorecibo,
						ea.estadoasesor,
						p.refestadopago,
						p.usuariocrea,
						p.usuariomodi,
						p.fechacrea,
						p.fechamodi,
						p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
      inner join dbperiodicidadventaspagos pg on pg.refperiodicidadventasdetalle = p.idperiodicidadventadetalle and pg.avisoinbursa = '1'
		inner join dbventas ve ON ve.idventa = per.refventas
      inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones
         inner join
   	tbproductos pp on (case when ve.refproductosaux = 0 then pp.idproducto = co.refproductos else pp.idproducto = ve.refproductosaux end)
   		inner join
   	tbtipoproductorama tr on tr.idtipoproductorama = pp.reftipoproductorama and tr.idtipoproductorama <> 12
      inner join dbclientes cli on cli.idcliente = co.refclientes
      inner join dbasesores ase on ase.idasesor = co.refasesores
      inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago

        where p.refestadopago in (2) ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerCobranzaVRIMajax($length, $start, $busqueda,$colSort,$colSortDir,$estados) {
		$where = '';


		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or ve.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or cli.numerocliente like '%".$busqueda."%' or cli.idclienteinbursa like '%".$busqueda."%' or p.nrorecibo like '%".$busqueda."%')";
		}

      $cadRR = '';
      if ($estados == '2,7') {
         //$cadRR = ' and ve.refproductosaux = 0 ';
      }


		$sql = "select
						p.idperiodicidadventadetalle,
						(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
						ve.nropoliza,
						p.fechavencimiento,
						cli.numerocliente,
						cli.idclienteinbursa,
						p.nrorecibo,
						est.estadopago,
						p.montototal,
						p.primaneta,
						p.porcentajecomision,
						p.montocomision,
						p.fechapago,
						p.fechavencimiento,
						est.estadopago,
						p.nrorecibo,
						ea.estadoasesor,
						p.refestadopago,
						p.usuariocrea,
						p.usuariomodi,
						p.fechacrea,
						p.fechamodi,
						p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
      inner join dbperiodicidadventaspagos pg on pg.refperiodicidadventasdetalle = p.idperiodicidadventadetalle and pg.avisoinbursa = '1'
		inner join dbventas ve ON ve.idventa = per.refventas
      inner join dbcotizaciones co on co.idcotizacion = ve.refcotizaciones";

      if ($_SESSION['idroll_sahilices'] == 17) {
         $sql .= " inner join
   	tbproductos pp on pp.idproducto = ve.refproductosaux ";
      } else {
         $sql .= " inner join
   	tbproductos pp on (case when ve.refproductosaux = 0 then pp.idproducto = co.refproductos else pp.idproducto = ve.refproductosaux end) ";
      }


      $sql .= "
   		inner join
   	tbtipoproductorama tr on tr.idtipoproductorama = pp.reftipoproductorama and tr.idtipoproductorama = 12
      inner join dbclientes cli on cli.idcliente = co.refclientes
      inner join dbasesores ase on ase.idasesor = co.refasesores
      inner join tbestadoasesor ea on ea.idestadoasesor = ase.refestadoasesor
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago

      where p.refestadopago in (".$estados.") ".$cadRR." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   /* PARA Documentacionpagos */

	function modificarPagoUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbperiodicidadventaspagos
		set
		".$campo." = '".$valor."'
		where idperiodicidadventapago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPagoDocumentacionCompleta($idpago,$iddocumentacion) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionpago,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionpagos da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refpagos = ".$idpago."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.iddocumentacion in (".$iddocumentacion.")

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionpagos($refpagos,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionpagos(iddocumentacionpago,refpagos,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refpagos.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionpagos($id,$refpagos,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechamodi,$usuariomodi) {
		$sql = "update dbdocumentacionpagos
		set
		refpagos = ".$refpagos.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionpago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionpagos($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionpagos
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionpago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionPagosPorDocumentacion($iddocumentacion,$idpago, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionpagos
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refpagos =".$idpago;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionpagos($id) {
		$sql = "delete from dbdocumentacionpagos where iddocumentacionpago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionpagosPorPagoDocumentacion($idpago,$iddocumentacion) {
		$sql = "delete from dbdocumentacionpagos where refpagos =".$idpago." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionpagosPorPagosDocumentacionEspecifico($idpago,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionpagos where refpagos =".$idpago =" and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionPago($idpago,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorPagoDocumentacion($idpago,$iddocumentacion);

		$resDocumentacion = $this->traerDocumentacionesPorId($iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
				$archivos = '../archivos/pagos/'.$idpago.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionpagos(mysql_result($resFoto,0,'iddocumentacionpago'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionpagos() {
		$sql = "select
		d.iddocumentacionpago,
		d.refpagos,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionpagos d
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionpagosPorId($id) {
		$sql = "select iddocumentacionpago,refpagos,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionpagos where iddocumentacionpago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPagoDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionpago,da.refpagos,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionpagos da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refpagos =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}


	/* fin para documentaciones de pagos */


	/* PARA Documentacionventas */

	function modificarVentaUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbperiodicidadventasdetalle
		set
		".$campo." = '".$valor."'
		where idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorVentaDocumentacionCompleta($idventa,$iddocumentacion) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionventa,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion

					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionventas da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refventas = ".$idventa." and da.refperiodicidadventas = 0
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.iddocumentacion in (".$iddocumentacion.")

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

   function traerDocumentacionPorVentaDocumentacionCompletaDetalle($idventa,$iddocumentacion) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionventa,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion

					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionventas da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refperiodicidadventas = ".$idventa."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.iddocumentacion in (".$iddocumentacion.")

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionventas($refventas,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refperiodicidadventas) {
		$sql = "insert into dbdocumentacionventas(iddocumentacionventa,refventas,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi,refperiodicidadventas)
		values ('',".$refventas.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$refperiodicidadventas.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionventas($id,$refventas,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechamodi,$usuariomodi,$refperiodicidadventas) {
		$sql = "update dbdocumentacionventas
		set
		refventas = ".$refventas.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',refperiodicidadventas = ".$refperiodicidadventas."
		where iddocumentacionventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionventas($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionventas
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionVentasPorDocumentacion($iddocumentacion,$idventa, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionventas
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refventas =".$idventa;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionventas($id) {
		$sql = "delete from dbdocumentacionventas where iddocumentacionventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionventasPorVentaDocumentacion($idventa,$iddocumentacion) {
		$sql = "delete from dbdocumentacionventas where refventas =".$idventa." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

   function eliminarDocumentacionventasPorVentaDocumentacionDetalle($idventa,$iddocumentacion) {
		$sql = "delete from dbdocumentacionventas where refperiodicidadventas =".$idventa." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionventasPorVentasDocumentacionEspecifico($idventa,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionventas where refventas =".$idventa =" and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

   function eliminarDocumentacionventasPorVentasDocumentacionEspecificoDetalle($idventa,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionventas where refperiodicidadventas =".$idventa =" and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionVenta($idventa,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorVentaDocumentacion($idventa,$iddocumentacion);

		$resDocumentacion = $this->traerDocumentacionesPorId($iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
				$archivos = '../archivos/ventas/'.$idventa.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionventas(mysql_result($resFoto,0,'iddocumentacionventa'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


   function eliminarDocumentacionVentaDetalle($idventa,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorVentaDocumentacionDetalle($idventa,$iddocumentacion);

		$resDocumentacion = $this->traerDocumentacionesPorId($iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
				$archivos = '../archivos/cobros/'.$idventa.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionventas(mysql_result($resFoto,0,'iddocumentacionventa'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionventas() {
		$sql = "select
		d.iddocumentacionventa,
		d.refventas,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionventas d
		inner join dbperiodicidadventasdetalle ase ON ase.idperiodicidadventadetalle = d.refventas
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionventasPorId($id) {
		$sql = "select iddocumentacionventa,refventas,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionventas where iddocumentacionventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorVentaDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionventa,da.refventas,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionventas da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refventas =".$id." and da.refperiodicidadventas=0 and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerDocumentacionPorVentaDocumentacionDetalle($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionventa,da.refventas,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta, da.refperiodicidadventas
		from dbdocumentacionventas da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refperiodicidadventas =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}


	/* fin para documentaciones de ventas */

   /* PARA Tipoproductorama */

	function insertarTipoproductorama($reftipoproducto,$tipoproductorama) {
		$sql = "insert into tbtipoproductorama(idtipoproductorama,reftipoproducto,tipoproductorama)
		values ('',".$reftipoproducto.",'".$tipoproductorama."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTipoproductorama($id,$reftipoproducto,$tipoproductorama) {
		$sql = "update tbtipoproductorama
		set
		reftipoproducto = ".$reftipoproducto.",tipoproductorama = '".$tipoproductorama."'
		where idtipoproductorama =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTipoproductorama($id) {
		$sql = "delete from tbtipoproductorama where idtipoproductorama =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoproductorama() {
		$sql = "select
		t.idtipoproductorama,
		t.reftipoproducto,
		t.tipoproductorama
		from tbtipoproductorama t
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoproductoramaPorId($id) {
		$sql = "select idtipoproductorama,reftipoproducto,tipoproductorama from tbtipoproductorama where idtipoproductorama =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerTipoproductoramaPorTipoProducto($id) {
		$sql = "select
		t.idtipoproductorama,
		t.tipoproductorama,
		t.reftipoproducto
		from tbtipoproductorama t
		inner join tbtipoproducto tp on tp.idtipoproducto = t.reftipoproducto
		where tp.idtipoproducto = ".$id."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtipoproductorama*/

	/* PARA Periodicidadventasdetalle */

   function generaNroRecibo() {
		$sql = "select max(idperiodicidadventadetalle) from dbperiodicidadventasdetalle";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0);
			return 'REC'.substr('0000000'.$idcliente,-7);
		}

		return 'REC0000001';
	}

	function insertarPeriodicidadventasdetalle($refperiodicidadventas,$montototal,$primaneta,$porcentajecomision,$montocomision,$fechapago,$fechavencimiento,$refestadopago,$usuariocrea,$usuariomodi,$fechacrea,$fechamodi,$nrorecibo,$fechapagoreal='',$refformapago=0) {
      if ($fechapagoreal == '') {
         $sql = "insert into dbperiodicidadventasdetalle(idperiodicidadventadetalle,refperiodicidadventas,montototal,primaneta,porcentajecomision,montocomision,fechapago,fechavencimiento,refestadopago,usuariocrea,usuariomodi,fechacrea,fechamodi,nrorecibo,fechapagoreal,refformapago)
   		values ('',".$refperiodicidadventas.",".$montototal.",".$primaneta.",".$porcentajecomision.",".$montocomision.",'".$fechapago."','".$fechavencimiento."',".$refestadopago.",'".$usuariocrea."','".$usuariomodi."','".$fechacrea."','".$fechamodi."','".$nrorecibo."',NULL,".$refformapago.")";
      } else {
         $sql = "insert into dbperiodicidadventasdetalle(idperiodicidadventadetalle,refperiodicidadventas,montototal,primaneta,porcentajecomision,montocomision,fechapago,fechavencimiento,refestadopago,usuariocrea,usuariomodi,fechacrea,fechamodi,nrorecibo,fechapagoreal,refformapago)
   		values ('',".$refperiodicidadventas.",".$montototal.",".$primaneta.",".$porcentajecomision.",".$montocomision.",'".$fechapago."','".$fechavencimiento."',".$refestadopago.",'".$usuariocrea."','".$usuariomodi."','".$fechacrea."','".$fechamodi."','".$nrorecibo."','".$fechapagoreal."',".$refformapago.")";
      }

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPeriodicidadventasdetalle($id,$refperiodicidadventas,$montototal,$primaneta,$porcentajecomision,$montocomision,$fechapago,$fechavencimiento,$refestadopago,$usuariomodi,$fechamodi,$nrorecibo,$fechapagoreal,$refformapago=0) {
		$sql = "update dbperiodicidadventasdetalle
		set
		refperiodicidadventas = ".$refperiodicidadventas.",montototal = ".$montototal.",primaneta = ".$primaneta.",porcentajecomision = ".$porcentajecomision.",montocomision = ".$montocomision.",fechapago = '".$fechapago."',fechavencimiento = '".$fechavencimiento."',refestadopago = ".$refestadopago.",usuariomodi = '".$usuariomodi."',fechamodi = '".$fechamodi."',nrorecibo = '".$nrorecibo."',fechapagoreal = '".$fechapagoreal."',refformapago=".$refformapago." where idperiodicidadventadetalle =".$id;
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

   function guardarMetodoDePagoPorRecibo($id, $formapago) {
      $sql = "update dbperiodicidadventasdetalle
		set
		refformapago = ".$formapago.",fechamodi = now() where idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
   }


	function eliminarPeriodicidadventasdetalle($id) {
		$sql = "delete from dbperiodicidadventasdetalle where idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function eliminarPeriodicidadventasdetallePorVenta($id) {
      $sql = "delete dp from dbperiodicidadventasdetalle dp
            inner join dbperiodicidadventas pv ON pv.idperiodicidadventa = dp.refperiodicidadventas
            inner join dbventas ve ON ve.idventa = pv.refventas
            where pv.refventas =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function eliminarPeriodicidadventasdetalleEndoso($id,$version) {
		$sql = "update dbperiodicidadventasdetalle dp
            inner join dbperiodicidadventas pv ON pv.idperiodicidadventa = dp.refperiodicidadventas
            inner join dbventas ve ON ve.idventa = pv.refventas and ve.version = ".$version."
            set dp.refestadopago = 4
            where pv.refventas =".$id." and dp.refestadopago not in (5,6)";
      //die(var_dump($sql));
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPeriodicidadventasdetalleajax($length, $start, $busqueda,$colSort,$colSortDir,$idventa) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " ";
		}


		$sql = "select
		p.idperiodicidadventadetalle,
		p.montototal,
		p.primaneta,
		p.porcentajecomision,
		p.montocomision,
		p.fechapago,
		p.fechavencimiento,
		concat(est.estadopago, ' ', (case when dv.iddocumentacionventa is null then '(*)' else '' end)) as estadopago,
		p.nrorecibo,
		p.refestadopago,
		p.usuariocrea,
		p.usuariomodi,
		p.fechacrea,
		p.fechamodi,
		p.refperiodicidadventas
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = per.refventas
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago
		left join dbdocumentacionventas dv on dv.refperiodicidadventas = p.idperiodicidadventadetalle and dv.refdocumentaciones = 38
		where ve.idventa = ".$idventa."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerPeriodicidadventasdetalle() {
		$sql = "select
		p.idperiodicidadventadetalle,
		p.refperiodicidadventas,
		p.montototal,
		p.primaneta,
		p.porcentajecomision,
		p.montocomision,
		p.fechapago,
		p.fechavencimiento,
		p.refestadopago,
		p.usuariocrea,
		p.usuariomodi,
		p.fechacrea,
		p.fechamodi,
		p.nrorecibo
		from dbperiodicidadventasdetalle p
		inner join dbperiodicidadventas per ON per.idperiodicidadventa = p.refperiodicidadventas
		inner join dbventas ve ON ve.idventa = per.refventas
		inner join tbtipoperiodicidad tp ON tp.idtipoperiodicidad = per.reftipoperiodicidad
		inner join tbtipocobranza ti ON ti.idtipocobranza = per.reftipocobranza
		inner join tbestadopago est ON est.idestadopago = p.refestadopago
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPeriodicidadventasdetallePorId($id) {
		$sql = "select idperiodicidadventadetalle,refperiodicidadventas,montototal,primaneta,porcentajecomision,montocomision,fechapago,fechavencimiento,refestadopago,usuariocrea,usuariomodi,fechacrea,fechamodi,nrorecibo,fechapagoreal,refformapago from dbperiodicidadventasdetalle where idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerVentaUnicaDocumentacion($campo,$id) {
		$sql = "select ".$campo." from dbperiodicidadventasdetalle where idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPeriodicidadventasdetallePorIdCompleto($id) {
		$sql = "select
		pvd.idperiodicidadventadetalle,
      concat('Cliente: ', cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
      concat( cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as clientesolo,
		concat('Producto: ', pro.producto) as producto,
      pvd.refperiodicidadventas,pvd.montototal,pvd.primaneta,
		pvd.porcentajecomision,pvd.montocomision,pvd.fechapago,pvd.fechavencimiento,
		pvd.refestadopago,
		pvd.usuariocrea,pvd.usuariomodi,pvd.fechacrea,pvd.fechamodi,
		pv.refventas,
		pvd.nrorecibo,
      v.nropoliza,tp.estadopago, pvd.fechapagoreal , pvd.refformapago , fp.formapago, v.refproductosaux,
      cli.refusuarios , ase.refusuarios as refusuariosasesor, usu.email, usua.email as emailasesor, co.refproductos
		from dbperiodicidadventasdetalle pvd
		inner join dbperiodicidadventas pv ON pv.idperiodicidadventa = pvd.refperiodicidadventas
         inner join dbventas v on v.idventa = pv.refventas
			inner join dbcotizaciones co on co.idcotizacion = v.refcotizaciones
         inner join dbasesores ase on ase.idasesor = co.refasesores
         inner join dbusuarios usua ON usua.idusuario = ase.refusuarios
			inner join dbclientes cli ON cli.idcliente = co.refclientes
         left join dbusuarios usu ON usu.idusuario = cli.refusuarios
			inner join tbproductos pro ON pro.idproducto = co.refproductos
         left join tbformapago fp on fp.idformapago = pvd.refformapago
      inner join tbestadopago tp ON tp.idestadopago = pvd.refestadopago
		where pvd.idperiodicidadventadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPeriodicidadventasdetallePorVenta($id) {
		$sql = "select
		pd.idperiodicidadventadetalle,pd.refperiodicidadventas,pd.montototal,
		pd.primaneta,pd.porcentajecomision,pd.montocomision,
		pd.fechapago,pd.fechavencimiento,pd.refestadopago,
		pd.usuariocrea,pd.usuariomodi,pd.fechacrea,pd.fechamodi, pd.nrorecibo,
      pv.reftipocobranza, pd.fechapagoreal, pd.refformapago , fp.formapago
		from dbperiodicidadventasdetalle pd
		inner join dbperiodicidadventas pv ON pv.idperiodicidadventa = pd.refperiodicidadventas
		inner join dbventas v on v.idventa = pv.refventas
      left join tbformapago fp on fp.idformapago = pd.refformapago
		where v.idventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerPeriodicidadventasdetallePorVentaPagados($idnuevo,$idviejo) {
		$sql = "select
		pd.idperiodicidadventadetalle,pd.refperiodicidadventas,pd.montototal,
		pd.primaneta,pd.porcentajecomision,pd.montocomision,
		pd.fechapago,pd.fechavencimiento,pd.refestadopago,
		pd.usuariocrea,pd.usuariomodi,pd.fechacrea,pd.fechamodi, pd.nrorecibo,
      pv.reftipocobranza , pd.fechapagoreal
		from dbperiodicidadventasdetalle pd
		inner join dbperiodicidadventas pv ON pv.idperiodicidadventa = pd.refperiodicidadventas
		inner join dbventas v on v.idventa = pv.refventas
		where ((v.idventa = ".$idviejo." and v.refventas = 0) or v.refventas = ".$idviejo.") and pd.refestadopago = 5";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerUltimoMes($id) {
		$sql = "select
		DATE_ADD(max(pd.fechapago), INTERVAL 1 MONTH) as fechapago,
		DATE_ADD(max(pd.fechavencimiento), INTERVAL 1 MONTH) as fechavencimiento,
		max(pd.montototal) as montototal,
		max(pd.primaneta) as primaneta,
		max(pd.porcentajecomision) as porcentajecomision,
		max(pd.montocomision) as montocomision
		from dbperiodicidadventasdetalle pd
		inner join dbperiodicidadventas pv ON pv.idperiodicidadventa = pd.refperiodicidadventas
		inner join dbventas v on v.idventa = pv.refventas
		where v.idventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbperiodicidadventasdetalle*/


	/* PARA Periodicidadventas */

   function insertarPeriodicidadventasPorVenta($refventas,$idventa) {
		$sql = "insert into dbperiodicidadventas(idperiodicidadventa,refventas,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta)
		select '',".$refventas.",reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta from dbperiodicidadventas where refventas =".$idventa;
		$res = $this->query($sql,1);
		return $res;
	}

	function insertarPeriodicidadventas($refventas,$reftipoperiodicidad,$reftipocobranza,$banco,$afiliacionnumber,$tipotarjeta) {
		$sql = "insert into dbperiodicidadventas(idperiodicidadventa,refventas,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta)
		values ('',".$refventas.",".$reftipoperiodicidad.",".$reftipocobranza.",'".$banco."','".$afiliacionnumber."','".$tipotarjeta."')";
		$res = $this->query($sql,1);
		return $res;
	}

   function insertarPeriodicidadventasPorMetodoPago($refventas,$refmetodopago) {
		$sql = "insert into dbperiodicidadventas(idperiodicidadventa,refventas,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta)
		select    '',
      ".$refventas.",
      m.reftipoperiodicidad,
      m.reftipocobranza,
      m.banco,
      m.afiliacionnumber,
      m.tipotarjeta
      from dbmetodopago m where m.idmetodopago = ".$refmetodopago."
      ";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPeriodicidadventas($id,$refventas,$reftipoperiodicidad,$reftipocobranza) {
		$sql = "update dbperiodicidadventas
		set
		refventas = ".$refventas.",reftipoperiodicidad = ".$reftipoperiodicidad.",reftipocobranza = ".$reftipocobranza."
		where idperiodicidadventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarPeriodicidadventas($id) {
		$sql = "delete from dbperiodicidadventas where idperiodicidadventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   function eliminarPeriodicidadventasPorVentas($id) {
      $sql = "delete from dbperiodicidadventas where refventas =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


	function traerPeriodicidadventas() {
		$sql = "select
		p.idperiodicidadventa,
		p.refventas,
		p.reftipoperiodicidad,
		p.reftipocobranza
		from dbperiodicidadventas p
		inner join dbventas ven ON ven.idventa = p.refventas
		inner join tbtipoperiodicidad tip ON tip.idtipoperiodicidad = p.reftipoperiodicidad
		inner join tbtipocobranza tip ON tip.idtipocobranza = p.reftipocobranza
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPeriodicidadventasPorId($id) {
		$sql = "select idperiodicidadventa,refventas,reftipoperiodicidad,reftipocobranza,banco,afiliacionnumber,tipotarjeta from dbperiodicidadventas where idperiodicidadventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPeriodicidadventasPorVenta($id) {
		$sql = "select
            pv.idperiodicidadventa,
            pv.refventas,
            pv.reftipoperiodicidad,
            pv.reftipocobranza,
            tp.meses,
            tp.tipoperiodicidad,
            tc.tipocobranza,
            pv.banco,
            pv.afiliacionnumber,
            pv.tipotarjeta
		from dbperiodicidadventas pv
		inner join
         tbtipoperiodicidad tp ON tp.idtipoperiodicidad = pv.reftipoperiodicidad
      inner join
	     tbtipocobranza tc on tc.idtipocobranza = pv.reftipocobranza
		where pv.refventas =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPeriodicidadventasPorIdCompleto($id) {
		$sql = "select
			pv.idperiodicidadventa,
			concat('Cliente: ', cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
			concat('Producto: ', pro.producto) as producto,
			pv.refventas,
			pv.reftipoperiodicidad,pv.reftipocobranza,
         pv.banco,
         pv.afiliacionnumber,
         pv.tipotarjeta
			from dbperiodicidadventas pv
			inner join dbventas v on v.idventa = pv.refventas
			inner join dbcotizaciones co on co.idcotizacion = v.refcotizaciones
			inner join dbclientes cli ON cli.idcliente = co.refclientes
			inner join tbproductos pro ON pro.idproducto = co.refproductos
			where pv.idperiodicidadventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbperiodicidadventas*/


	/* PARA Estadoventa */

	function insertarEstadoventa($estadoventa) {
		$sql = "insert into tbestadoventa(idestadoventa,estadoventa)
		values ('','".$estadoventa."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadoventa($id,$estadoventa) {
		$sql = "update tbestadoventa
		set
		estadoventa = '".$estadoventa."'
		where idestadoventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadoventa($id) {
		$sql = "delete from tbestadoventa where idestadoventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadoventa() {
		$sql = "select
		e.idestadoventa,
		e.estadoventa
		from tbestadoventa e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadoventaPorId($id) {
		$sql = "select idestadoventa,estadoventa from tbestadoventa where idestadoventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadoventa*/

	/* PARA Tipoperiodicidad */

	function insertarTipoperiodicidad($tipoperiodicidad,$meses) {
		$sql = "insert into tbtipoperiodicidad(idtipoperiodicidad,tipoperiodicidad,meses)
		values ('','".$tipoperiodicidad."',".$meses.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTipoperiodicidad($id,$tipoperiodicidad,$meses) {
		$sql = "update tbtipoperiodicidad
		set
		tipoperiodicidad = '".$tipoperiodicidad."',meses = ".$meses."
		where idtipoperiodicidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTipoperiodicidad($id) {
		$sql = "delete from tbtipoperiodicidad where idtipoperiodicidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoperiodicidad() {
		$sql = "select
		t.idtipoperiodicidad,
		t.tipoperiodicidad,
		t.meses
		from tbtipoperiodicidad t
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoperiodicidadPorId($id) {
		$sql = "select idtipoperiodicidad,tipoperiodicidad,meses from tbtipoperiodicidad where idtipoperiodicidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtipoperiodicidad*/

	/* PARA Tipocobranza */

	function insertarTipocobranza($tipocobranza) {
		$sql = "insert into tbtipocobranza(idtipocobranza,tipocobranza)
		values ('','".$tipocobranza."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTipocobranza($id,$tipocobranza) {
		$sql = "update tbtipocobranza
		set
		tipocobranza = '".$tipocobranza."'
		where idtipocobranza =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTipocobranza($id) {
		$sql = "delete from tbtipocobranza where idtipocobranza =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipocobranza() {
		$sql = "select
		t.idtipocobranza,
		t.tipocobranza
		from tbtipocobranza t
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipocobranzaPorId($id) {
		$sql = "select idtipocobranza,tipocobranza from tbtipocobranza where idtipocobranza =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtipocobranza*/

	/* PARA Estadopago */

	function insertarEstadopago($estadopago) {
		$sql = "insert into tbestadopago(idestadopago,estadopago)
		values ('','".$estadopago."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadopago($id,$estadopago) {
		$sql = "update tbestadopago
		set
		estadopago = '".$estadopago."'
		where idestadopago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadopago($id) {
		$sql = "delete from tbestadopago where idestadopago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadopago() {
		$sql = "select
		e.idestadopago,
		e.estadopago
		from tbestadopago e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadopagoPorId($id) {
		$sql = "select idestadopago,estadopago from tbestadopago where idestadopago =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadopago*/

	/* PARA Ventas */

   function generarEndoso($id,$version,$refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$versionvieja,$observaciones,$vigenciadesde) {
      $error = false;

      // pongo los recibos en cancelados.
      $resEliminarCobros = $this->eliminarPeriodicidadventasdetalleEndoso($id,$versionvieja);

      if ($resEliminarCobros) {

         //creo la venta con la nueva version
         $resI = $this->insertarVentas($refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$id,$version,0,$observaciones,$vigenciadesde);

         $resP = $this->insertarPeriodicidadventasPorVenta($resI,$id);
         return $resI;
      } else {
         $error = true;

         return '';
      }


   }

   function generarVersion($refventas) {

      if ($refventas == '') {
         return 1;
      } else {
         $sql = "select max(version) as version from dbventas where idventa =".$refventas;

         $res = $this->query($sql,0);

         if (mysql_num_rows($res)>0) {
            return mysql_result($res,0,'version') + 0.1;
         } else {
            return 1;
         }
      }
   }

   function traerVentasAuxPorId($id) {
      $sql = "select idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechacrea,fechamodi,usuariocrea,usuariomodi,nropoliza,fechavencimientopoliza,foliotys,foliointerno,refproductosaux, refventas,version,vigenciadesde from dbventas where refventas =".$id;
		$res = $this->query($sql,0);
		return $res;
   }

   function traerVentasPorVersion($version) {
      $sql = "select idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechacrea,fechamodi,usuariocrea,usuariomodi,nropoliza,fechavencimientopoliza,foliotys,foliointerno,refproductosaux, refventas,version,vigenciadesde from dbventas where version =".$version;
		$res = $this->query($sql,0);
		return $res;
   }


   function traerVentasPorVersionVenta($version,$idventa) {
      $sql = "select idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechacrea,fechamodi,usuariocrea,usuariomodi,nropoliza,fechavencimientopoliza,foliotys,foliointerno,refproductosaux, refventas,version,vigenciadesde from dbventas where version =".$version." and idventa=".$idventa;
		$res = $this->query($sql,0);
		return $res;
   }


	function insertarVentas($refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$refventas,$version,$observaciones='',$vigenciadesde,$fechaemision='',$reftipomoneda=1) {

      if ($fechaemision == '') {
         $sql = "insert into dbventas(idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechavencimientopoliza,nropoliza,fechacrea,fechamodi,usuariocrea,usuariomodi,foliotys,foliointerno,refproductosaux, refventas, version, observaciones,vigenciadesde,fechaemision,reftipomoneda)
   		values ('',".$refcotizaciones.",".$refestadoventa.",".$primaneta.",".$primatotal.",'".$fechavencimientopoliza."','".$nropoliza."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."','".$foliotys."','".$foliointerno."',".$refproductosaux.",".$refventas.",".$version.",'".$observaciones."','".$vigenciadesde."',NULL,".$reftipomoneda.")";
      } else {
         $sql = "insert into dbventas(idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechavencimientopoliza,nropoliza,fechacrea,fechamodi,usuariocrea,usuariomodi,foliotys,foliointerno,refproductosaux, refventas, version, observaciones,vigenciadesde,fechaemision,reftipomoneda)
   		values ('',".$refcotizaciones.",".$refestadoventa.",".$primaneta.",".$primatotal.",'".$fechavencimientopoliza."','".$nropoliza."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."','".$foliotys."','".$foliointerno."',".$refproductosaux.",".$refventas.",".$version.",'".$observaciones."','".$vigenciadesde."','".$fechaemision."',".$reftipomoneda.")";
      }


      //die(var_dump($sql));
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarVentas($id,$refcotizaciones,$refestadoventa,$primaneta,$primatotal,$fechavencimientopoliza,$nropoliza,$fechamodi,$usuariomodi,$foliotys,$foliointerno,$refproductosaux,$refventas,$version,$refmotivorechazopoliza,$observaciones,$vigenciadesde,$reftipomoneda) {
		$sql = "update dbventas
		set
		refcotizaciones = ".$refcotizaciones.",refestadoventa = ".$refestadoventa.",primaneta = ".$primaneta.",primatotal = ".$primatotal.",fechavencimientopoliza = '".$fechavencimientopoliza."',nropoliza = '".$nropoliza."',fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',foliotys = '".$foliotys."',foliointerno = '".$foliointerno."',refproductosaux = ".$refproductosaux.",refventas = ".$refventas.",version = ".$version.",refmotivorechazopoliza = ".$refmotivorechazopoliza.",observaciones = '".$observaciones."',vigenciadesde = '".$vigenciadesde."',reftipomoneda = ".$reftipomoneda." where idventa =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function cancelarVentas($id,$refestadoventa,$observaciones,$refmotivorechazopoliza) {
      $sql = "update dbventas
		set
		refestadoventa = ".$refestadoventa.",refmotivorechazopoliza = ".$refmotivorechazopoliza.",observaciones = '".$observaciones."' where idventa =".$id;

		$res = $this->query($sql,0);
		return $res;
   }


	function eliminarVentas($id) {
		$sql = "delete from dbventas where idventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function eliminarVentasDefinitivo($id) {

      $resEliminarCobros = $this->eliminarPeriodicidadventasdetallePorVenta($id);

      $resEliminarPeriodicidad = $this->eliminarPeriodicidadventasPorVentas($id);


      $sql = "delete from dbventas where idventa =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


	function traerVentas() {
		$sql = "select
		v.idventa,
		v.refcotizaciones,
		v.refestadoventa,
		v.primaneta,
		v.primatotal,
		v.fechacrea,
		v.foliotys,
		v.foliointerno,
		v.fechamodi
		from dbventas v
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerVentasActivos() {
		$sql = "select
      v.idventa,
		concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      DATEDIFF(CURDATE(),v.fechacrea) as dias,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux

		where v.refestadoventa in (1,2)
		order by concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre)";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerVentasRenovacionesHistoricoajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$idasesor) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

      $cadAsesor = '';
      if ($idasesor != '') {
         $cadAsesor = " and ase.idasesor = ".$idasesor." ";
      }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%')";
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      DATEDIFF(CURDATE(),v.fechacrea) as dias,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux
      inner join dbrenovaciones rn on rn.refventas = v.idventa

		where v.refestadoventa in (1,2,3,4,5) ".$where.$cadAsesor."

		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerVentasRenovacionesPendientesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$idasesor) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

      $cadAsesor = '';
      if ($idasesor != '') {
         $cadAsesor = " and ase.idasesor = ".$idasesor." ";
      }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%')";
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      DATEDIFF(CURDATE(),v.fechacrea) as dias,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux
      left join dbrenovaciones rn ON rn.refventas = v.idventa

		where v.refestadoventa = 1 and rn.idrenovacion is null and DATEDIFF(v.fechavencimientopoliza,CURDATE()) <= 29 ".$where.$cadAsesor."

		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

   function traerVentasRenovacionesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$refusuario='',$idasesor) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " and ase.refusuarios = ".$responsableComercial." ";
	   } else {
	      $roles = '';
	   }

      $rolesUsuario = '';
      $joinPoliza = '';

	   if ($refusuario != '') {
	      $rolesUsuario = " and cli.refusuarios = ".$refusuario." ";
         $joinPoliza = " inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35 ";
	   } else {
	      $rolesUsuario = '';
         $joinPoliza = '';
	   }

      $cadAsesor = '';
      if ($idasesor != '') {
         $cadAsesor = " and ase.idasesor = ".$idasesor." ";
      }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%')";
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      DATEDIFF(CURDATE(),v.fechacrea) as dias,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux
      inner join dbrenovaciones rn ON rn.nuevaventa = v.idventa
      ".$joinPoliza."
		where v.refestadoventa = 6 and v.vigenciadesde > CURDATE() ".$roles.$rolesUsuario." ".$where.$cadAsesor."

		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerVentasIniciadasajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max,$agente) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

      $cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and c.fechacrea between '".$min."' and '".$max."' ";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and c.fechacrea >= '".$min."' ";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and c.fechacrea <= '".$max."' ";
				}
			}
		}

		$cadAgente = '';
		if ($agente != '') {
			$cadAgente = " and ase.idasesor =".$agente.' ';
		}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " and ase.refusuarios = ".$responsableComercial." ";
	      }
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      DATEDIFF(CURDATE(),v.fechacrea) as dias,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux
      left join dbrenovaciones rn ON rn.refventas = v.idventa

		where v.refestadoventa = 6 and (rn.idrenovacion is null or (CURDATE() > v.vigenciadesde and rn.idrenovacion is not null)) ".$where.$cadFecha.$cadAgente."

		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerVentasRecibosajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " and ase.refusuarios = ".$responsableComercial." ";
	      }
		}


		$sql = "select
		v.idventa,
		concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      DATEDIFF(CURDATE(),v.fechacrea) as dias,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux

		where v.refestadoventa = 1 ".$where."

		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerVentasHistoricoajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max,$agente) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

      $cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and c.fechacrea between '".$min."' and '".$max."' ";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and c.fechacrea >= '".$min."' ";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and c.fechacrea <= '".$max."' ";
				}
			}
		}

		$cadAgente = '';
		if ($agente != '') {
			$cadAgente = " and ase.idasesor =".$agente.' ';
		}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or ev.estadoventa like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " and ase.refusuarios = ".$responsableComercial." ";
	      }
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
		ev.estadoventa,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux
      inner join tbestadoventa ev on ev.idestadoventa = v.refestadoventa

		where v.refestadoventa in (2,3,4,5) ".$where.$cadFecha.$cadAgente."

		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerVentasajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max,$agente) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

      $cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and c.fechacrea between '".$min."' and '".$max."' ";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and c.fechacrea >= '".$min."' ";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and c.fechacrea <= '".$max."' ";
				}
			}
		}

		$cadAgente = '';
		if ($agente != '') {
			$cadAgente = " and ase.idasesor =".$agente.' ';
		}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%'))";
		} else {
			if ($responsableComercial != '') {
	         $where = " and ase.refusuarios = ".$responsableComercial." ";
	      }
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
      tp.tipoperiodicidad,
      tcc.tipocobranza,
		est.estadocotizacion,
		v.foliointerno,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios,
      tp.meses,
      COUNT(pvd.idperiodicidadventadetalle) AS cantrecibos
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join (select
                     max(version) as version,refcotizaciones, refproductosaux
                     from		dbventas
                     group by refcotizaciones, refproductosaux) vf
               on vf.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = vf.refproductosaux
      inner join dbventas v on v.refcotizaciones = vf.refcotizaciones and v.version = vf.version and v.refproductosaux = vf.refproductosaux
            INNER JOIN
          dbperiodicidadventas pv ON pv.refventas = v.idventa
              INNER JOIN
          tbtipoperiodicidad tp ON tp.idtipoperiodicidad = pv.reftipoperiodicidad
            inner join tbtipocobranza tcc on tcc.idtipocobranza = pv.reftipocobranza
              left JOIN
          dbperiodicidadventasdetalle pvd ON pvd.refperiodicidadventas = pv.idperiodicidadventa
      where v.refestadoventa = 1 ".$where.$cadFecha.$cadAgente."
      GROUP BY v.idventa , cli.apellidopaterno , cli.apellidomaterno , cli.nombre , v.refproductosaux , pro.producto , ase.apellidopaterno , ase.apellidomaterno ,
      ase.nombre , aso.apellidopaterno , aso.apellidomaterno , aso.nombre , v.primaneta , v.primatotal , v.foliotys , v.fechavencimientopoliza , v.nropoliza ,
      est.estadocotizacion , v.foliointerno , c.refclientes , c.refproductos , c.refasesores , c.refasociados , c.refestadocotizaciones , c.observaciones ,
      c.fechacrea , c.fechamodi , c.usuariocrea , c.usuariomodi , c.refusuarios , tp.meses, v.refestadoventa


		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;
      //tp.meses
		//die(var_dump($sql));
      //having (case when max(v.version) > 1 then 13 else COUNT(pvd.idperiodicidadventadetalle) end) >= 1

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerVentasajaxPorUsuario($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or (case when v.refproductosaux > 0 then proa.producto else pro.producto end) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%')";
		}


		$sql = "select
		v.idventa,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		(case when v.refproductosaux > 0 then proa.producto else pro.producto end) as producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		v.primaneta,
		v.primatotal,
		v.foliotys,
		v.fechavencimientopoliza,
		v.nropoliza,
		est.estadocotizacion,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,

		v.foliointerno,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		inner join dbventas v on v.refcotizaciones = c.idcotizacion
      left join tbproductos proa ON proa.idproducto = v.refproductosaux
		where ase.refusuarios = ".$responsableComercial." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerVentasPorId($id) {
		$sql = "select idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechacrea,fechamodi,usuariocrea,usuariomodi,nropoliza,fechavencimientopoliza,foliotys,foliointerno,refproductosaux,refventas,version,refmotivorechazopoliza,observaciones,vigenciadesde,fechaemision,reftipomoneda from dbventas where idventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerVentasPorCotizacion($id) {
		$sql = "select idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechacrea,fechamodi,usuariocrea,usuariomodi,nropoliza,fechavencimientopoliza,foliotys,foliointerno,refproductosaux,refproductosaux,refventas,version,refmotivorechazopoliza,observaciones,vigenciadesde,fechaemision,reftipomoneda from dbventas where refcotizaciones =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerVentasPorCotizacionPaquetes($id, $refproductos) {
		$sql = "select idventa,refcotizaciones,refestadoventa,primaneta,primatotal,fechacrea,fechamodi,usuariocrea,usuariomodi,nropoliza,fechavencimientopoliza,foliotys,foliointerno,refproductosaux,refproductosaux,refventas,version,fechaemision,reftipomoneda from dbventas where refcotizaciones =".$id." and refproductosaux =".$refproductos;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerVentasPorCotizacionPaquetesUnico($id) {
		$sql = "select v.idventa,v.refcotizaciones,p.producto,v.primatotal, p.idproducto
      from dbventas v
      inner join tbproductos p on p.idproducto = v.refproductosaux
      where v.idventa not in (select rn.nuevaventa from dbventas v
      inner join dbrenovaciones rn on rn.refventas = v.idventa
      where v.refcotizaciones =".$id.") and v.refcotizaciones = ".$id." order by 1 desc";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerVentasPorIdCompleto($id) {
		$sql = "select
		v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      cli.refusuarios,
      ase.refusuarios as refusuariosasesor,
      cli.email, ase.email as emialasesor, v.refproductosaux, v.refventas, v.version, v.refmotivorechazopoliza, v.observaciones, v.vigenciadesde, ase.claveasesor, ase.envioalcliente, v.fechaemision , v.reftipomoneda
		from dbventas v
		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join dbasesores ase on ase.idasesor = c.refasesores
      inner join tbproductos p on p.idproducto = c.refproductos
		where v.idventa =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerFirmasDigitales() {
		$sql = "select
		c.idcotizacion,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as clientecompleto,
      p.producto,
      c.fechacrea,
      c.folio,
      v.nropoliza
		from dbcotizaciones c
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on p.idproducto = c.refproductos
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbventas v on v.refcotizaciones = c.idcotizacion and v.version = 1.0
      group by c.idcotizacion,
      cli.apellidopaterno, cli.apellidomaterno, cli.nombre,
      p.producto,
      c.fechacrea,
      c.folio
      order by c.fechacrea desc";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerVentasPorUsuarioCompletoAjax($length, $start, $busqueda,$colSort,$colSortDir,$idusuario,$min,$max) {

      $resCliente = $this->traerClientesPorUsuarioCompleto($idusuario);

		$idcliente = mysql_result($resCliente,0,0);

      $cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and v.fechavencimientopoliza between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and v.fechavencimientopoliza >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and v.fechavencimientopoliza <= '".$max."'";
				}
			}
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%'  )";
		}


		$sql = "select
		v.idventa,
      v.nropoliza,
      (case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
      v.fechavencimientopoliza,
      p.producto
		from dbventas v

		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on (case when v.refproductosaux = 0 then p.idproducto = c.refproductos else v.refproductosaux = p.idproducto end)
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
		where cli.idcliente =".$idcliente.$where.$cadFecha."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

   function traerVentasPorAsesorCompletoAjax($length, $start, $busqueda,$colSort,$colSortDir,$asesor,$idcliente,$min,$max,$estado) {

      $cadEstado = '';
      switch ($estado) {
         case 1:
            $cadEstado = ' and v.refestadoventa in (1,2) ';
         break;
         case 2:
            $cadEstado = ' and v.refestadoventa = 6 ';
         break;
         case 3:
            $cadEstado = ' and v.refestadoventa in (3,4,5,6,7,8) ';
         break;
      }

		if ($idcliente != '') {
			$cadCliente = " and cli.idcliente = ".$idcliente." ";
		} else {
			$cadCliente = '';
		}

      $cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and v.fechavencimientopoliza between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and v.fechavencimientopoliza >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and v.fechavencimientopoliza <= '".$max."'";
				}
			}
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%' or v.nropoliza like '%".$busqueda."%'  )";
		}


		$sql = "select
		v.idventa,
      v.nropoliza,
      (case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
      v.fechavencimientopoliza,
      p.producto
		from dbventas v

		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on (case when v.refproductosaux = 0 then p.idproducto = c.refproductos else v.refproductosaux = p.idproducto end)
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
		where c.refasesores =".$asesor.$where.$cadCliente.$cadFecha.$cadEstado."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerVentasPorAsesorCompleto($idasesor) {
		$sql = "select
		v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      (case when c.tieneasegurado = '1' then concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) else  concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) end) as asegurado,
      (case when v.fechavencimientopoliza > now() then 'green' else 'red' end) as color,
      pv.idperiodicidadventa , v.refproductosaux, v.refventas, v.version, v.refmotivorechazopoliza,
      v.observaciones , v.vigenciadesde ,v.fechaemision , v.reftipomoneda
		from dbventas v
      inner join dbperiodicidadventas pv on pv.refventas = v.idventa
      inner join tbtipocobranza tc on tc.idtipocobranza = pv.reftipocobranza
		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on p.idproducto = c.refproductos
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
      inner join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
		where c.refasesores =".$idasesor."
      group by v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      c.tieneasegurado,ase.apellidopaterno, ase.apellidomaterno, ase.nombre,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,
      v.fechavencimientopoliza,pv.idperiodicidadventa
      order by v.fechavencimientopoliza desc";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerVentasPorUsuarioCompleto($idusuario) {
		$sql = "select
		v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      (case when c.tieneasegurado = '1' then concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) else  concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) end) as asegurado,
      (case when v.fechavencimientopoliza > now() then 'green' else 'red' end) as color,
      pv.idperiodicidadventa , v.refproductosaux, v.refventas, v.version, v.refmotivorechazopoliza,
      v.observaciones , v.vigenciadesde , v.fechaemision , v.reftipomoneda
		from dbventas v
      inner join dbperiodicidadventas pv on pv.refventas = v.idventa
      inner join tbtipocobranza tc on tc.idtipocobranza = pv.reftipocobranza
		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on p.idproducto = c.refproductos
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
      inner join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
		where c.refusuarios =".$idusuario."
      group by v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      c.tieneasegurado,ase.apellidopaterno, ase.apellidomaterno, ase.nombre,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,
      v.fechavencimientopoliza,pv.idperiodicidadventa
      order by v.fechavencimientopoliza desc";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerVentasPorUsuarioVentaCompleto($idusuario,$idventa) {
		$sql = "select
		v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      (case when c.tieneasegurado = '1' then concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) else  concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) end) as asegurado,
      (case when v.fechavencimientopoliza > now() then 'green' else 'red' end) as color,
      pv.idperiodicidadventa , v.refproductosaux, v.refventas, v.version, v.refmotivorechazopoliza,
      v.observaciones , v.vigenciadesde , v.fechaemision , v.reftipomoneda
		from dbventas v
      inner join dbperiodicidadventas pv on pv.refventas = v.idventa
      inner join tbtipocobranza tc on tc.idtipocobranza = pv.reftipocobranza
		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on p.idproducto = c.refproductos
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
      left join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
		where c.refusuarios =".$idusuario." and v.idventa = ".$idventa."
      group by v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      c.tieneasegurado,ase.apellidopaterno, ase.apellidomaterno, ase.nombre,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,
      v.fechavencimientopoliza,pv.idperiodicidadventa
      order by v.fechavencimientopoliza desc";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerVentasPorAsesorVentaCompleto($idasesor,$idventa) {
		$sql = "select
		v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      (case when c.tieneasegurado = '1' then concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) else  concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) end) as asegurado,
      (case when v.fechavencimientopoliza > now() then 'green' else 'red' end) as color,
      pv.idperiodicidadventa , v.refproductosaux, v.refventas, v.version, v.refmotivorechazopoliza,
      v.observaciones , v.vigenciadesde, v.fechaemision , v.reftipomoneda
		from dbventas v
      inner join dbperiodicidadventas pv on pv.refventas = v.idventa
      inner join tbtipocobranza tc on tc.idtipocobranza = pv.reftipocobranza
		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on p.idproducto = c.refproductos
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
      left join dbperiodicidadventasdetalle pvd on pvd.refperiodicidadventas = pv.idperiodicidadventa
		where c.refasesores =".$idasesor." and v.idventa = ".$idventa."
      group by v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      tc.tipocobranza,
      c.tieneasegurado,ase.apellidopaterno, ase.apellidomaterno, ase.nombre,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,
      v.fechavencimientopoliza,pv.idperiodicidadventa
      order by v.fechavencimientopoliza desc";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerVentasPorAsesorVentaFundamental($idasesor,$idventa) {
		$sql = "select
		v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      (case when c.tieneasegurado = '1' then concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) else  concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) end) as asegurado,
      (case when v.fechavencimientopoliza > now() then 'green' else 'red' end) as color,
      v.refproductosaux, v.refventas, v.version, v.refmotivorechazopoliza,
      v.observaciones , v.vigenciadesde, v.fechaemision , v.reftipomoneda
		from dbventas v
		inner join dbcotizaciones c ON c.idcotizacion = v.refcotizaciones
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbproductos p on p.idproducto = c.refproductos
      left join dbasegurados ase ON ase.idasegurado = c.refasegurados
      left join dbasegurados ben ON ase.idasegurado = c.refbeneficiarios
      inner join dbdocumentacionventas dv on dv.refventas = v.idventa and dv.refdocumentaciones = 35
		where c.refasesores =".$idasesor." and v.idventa = ".$idventa."
      group by v.idventa,v.refcotizaciones,v.refestadoventa,v.primaneta,
		v.primatotal,v.fechacrea,v.fechamodi,v.usuariocrea,
		v.usuariomodi,v.nropoliza,v.fechavencimientopoliza,
		v.foliotys,v.foliointerno,
		c.refclientes,
		c.refproductos,
      p.producto,
      c.tieneasegurado,ase.apellidopaterno, ase.apellidomaterno, ase.nombre,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,
      v.fechavencimientopoliza
      order by v.fechavencimientopoliza desc";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbventas*/

	/* PARA Tipoproducto */

	function insertarTipoproducto($tipoproducto) {
		$sql = "insert into tbtipoproducto(idtipoproducto,tipoproducto)
		values ('','".$tipoproducto."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTipoproducto($id,$tipoproducto) {
		$sql = "update tbtipoproducto
		set
		tipoproducto = '".$tipoproducto."'
		where idtipoproducto =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTipoproducto($id) {
		$sql = "delete from tbtipoproducto where idtipoproducto =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoproducto() {
		$sql = "select
		t.idtipoproducto,
		t.tipoproducto
		from tbtipoproducto t
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoproductoPorId($id) {
		$sql = "select idtipoproducto,tipoproducto from tbtipoproducto where idtipoproducto =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerTipoproductoPorIn($in) {
		$sql = "select idtipoproducto,tipoproducto from tbtipoproducto where idtipoproducto in (".$in.")";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtipoproducto*/


	/* PARA Clientescartera */

	function insertarClientescartera($refclientes,$refproductos,$vigenciadesde,$vigenciahasta,$activo) {
		$sql = "insert into dbclientescartera(idclientecartera,refclientes,refproductos,vigenciadesde,vigenciahasta,activo)
		values ('',".$refclientes.",".$refproductos.",'".$vigenciadesde."','".$vigenciahasta."','".$activo."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarClientescartera($id,$refclientes,$refproductos,$vigenciadesde,$vigenciahasta,$activo) {
		$sql = "update dbclientescartera
		set
		refclientes = ".$refclientes.",refproductos = ".$refproductos.",vigenciadesde = '".$vigenciadesde."',vigenciahasta = '".$vigenciahasta."',activo = '".$activo."'
		where idclientecartera =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarClientescartera($id) {
		$sql = "delete from dbclientescartera where idclientecartera =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientescartera() {
		$sql = "select
		c.idclientecartera,
		c.refclientes,
		c.refproductos,
		c.vigenciadesde,
		c.vigenciahasta,
		c.activo
		from dbclientescartera c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientescarteraPorId($id) {
		$sql = "select idclientecartera,refclientes,refproductos,vigenciadesde,vigenciahasta,activo from dbclientescartera where idclientecartera =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerClientescarteraPorCliente($idcliente) {
		$sql = "select
		c.idclientecartera,
		concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		pro.producto,
		c.refclientes,
		c.refproductos,
		c.vigenciadesde,
		c.vigenciahasta,
		tp.tipoproducto,
		pro.reftipoproductorama,
      tr.reftipoproducto,
		c.activo
		from dbclientescartera c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbproductos pro ON pro.idproducto = c.refproductos
      inner join tbtipoproductorama tr on tr.idtipoproductorama = pro.reftipoproductorama
		inner join tbtipoproducto tp on tp.idtipoproducto = tr.reftipoproducto
		where cli.idcliente = ".$idcliente."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbclientescartera*/

	function traerGerenteDelAsesor($idasesor) {
		$sql = "select
			max(r.email) as gerentecomercial
			from (
				SELECT
					usu.email
				FROM
					dbasesores a
						INNER JOIN
					dbreclutadorasores rrr ON rrr.refasesores = a.idasesor
						INNER JOIN
					dbusuarios usu ON usu.idusuario = rrr.refusuarios
				WHERE
					a.idasesor = ".$idasesor."
				UNION ALL
				SELECT
					usu.email
				FROM
					dbasesores a
						INNER JOIN
					dbpostulantes p ON p.refusuarios = a.refusuarios
						INNER JOIN
					dbreclutadorasores rrr ON rrr.refpostulantes = p.idpostulante
						INNER JOIN
					dbusuarios usu ON usu.idusuario = rrr.refusuarios
				WHERE
					a.idasesor = ".$idasesor."
				) r";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			return mysql_result($res,0,0);
		}
		return '';
	}

	/* PARA Constanciasseguimiento */

	function insertarConstanciasseguimiento($refasesores,$meses,$cumplio,$fechacrea,$fechamodi,$base,$importe,$tipo,$informado,$refconstancias) {
		$sql = "insert into dbconstanciasseguimiento(idconstanciaseguimiento,refasesores,meses,cumplio,fechacrea,fechamodi,base,importe,tipo,informado,refconstancias)
		values ('',".$refasesores.",".$meses.",'".$cumplio."','".$fechacrea."','".$fechamodi."','".$base."',".$importe.",'".$tipo."','".$informado."',".$refconstancias.")";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarConstanciasseguimiento($id,$refasesores,$meses,$cumplio,$fechacrea,$fechamodi,$base,$importe,$tipo,$informado,$refconstancias) {
		$sql = "update dbconstanciasseguimiento
		set
		refasesores = ".$refasesores.",meses = ".$meses.",cumplio = '".$cumplio."',fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',base = '".$base."',importe = ".$importe.",tipo = '".$tipo."',informado = '".$informado."'
		where idconstanciaseguimiento =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function modificarConstanciasseguimientoFinalizar($id,$refconstancias) {
		$sql = "update dbconstanciasseguimiento
		set
		refconstancias = ".$refconstancias."
		where idconstanciaseguimiento =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function habilitarConstanciasseguimiento($refconstancias) {
		$sql = "update dbconstanciasseguimiento
		set
		refconstancias = NULL
		where refconstancias =".$refconstancias;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarConstanciasseguimiento($id) {
		$sql = "delete from dbconstanciasseguimiento where idconstanciaseguimiento =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerConstanciasseguimientoajax($length, $start, $busqueda,$colSort,$colSortDir,$asesor) {

		if ($asesor != '') {
			$cadAsesor = " ase.idasesor = ".$asesor." and ";
		} else {
			$cadAsesor = '';
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$cadAsesor." concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' )";
		} else {
			$where = " and ".$cadAsesor." 1=1 ";
		}


		$sql = "select
		c.idconstanciaseguimiento,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		ase.fechaalta,
		c.meses,
		(case when c.cumplio = '1' then 'Si'
				when c.cumplio = '0' then 'No' else 'No especifica' end) as cumplio,
		c.importe,
		(case when c.tipo = '1' then 'A'
				when c.tipo = '0' then 'B' else 'No especifica' end) as tipo,
		(case when c.informado = '1' then 'Si' else 'No' end) as informado,
		DATEDIFF(CURDATE(),c.fechacrea) as dias,
		c.fechacrea,
		c.base,
		c.refconstancias
		from dbconstanciasseguimiento c
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		where c.refconstancias is null ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerConstanciasseguimiento() {
		$sql = "select
		c.idconstanciaseguimiento,
		c.refasesores,
		c.meses,
		c.cumplio,
		c.fechacrea,
		c.fechamodi,
		c.base,
		c.importe,
		c.tipo,
		c.informado,
		c.refconstancias
		from dbconstanciasseguimiento c
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerConstanciasseguimientoPorId($id) {
		$sql = "select idconstanciaseguimiento,refasesores,meses,cumplio,fechacrea,fechamodi,base,importe,tipo,informado,refconstancias from dbconstanciasseguimiento where idconstanciaseguimiento =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbconstanciasseguimiento*/

	/***** para el calculo de las primas netas y de los bonos del reclutador ******/
	function calcularPrimasNetas() {
		$sql = "select sum(primaneta) from dbcotizaciones where refestadocotizaciones > 6";

		$res = $this->query($sql,0);

		return mysql_result($res,0,0);
	}

	function calcularComisionAgente() {
		$sql = "select sum(importecomisionagente) from dbcotizaciones where refestadocotizaciones > 6";

		$res = $this->query($sql,0);

		return mysql_result($res,0,0);
	}

	function calcularPrimasNetasSeguros() {
		$sql = "select sum(c.primaneta) from dbcotizaciones c
		inner join tbproductos p on p.idproducto = c.refproductos and p.reftipoproducto = 3
		where c.refestadocotizaciones > 6";

		$res = $this->query($sql,0);

		return mysql_result($res,0,0);
	}

	function calcularComisionAgenteAfore() {
		$sql = "select sum(c.importecomisionagente) from dbcotizaciones c
		inner join tbproductos p on p.idproducto = c.refproductos and p.reftipoproducto = 1
		where c.refestadocotizaciones > 6";

		$res = $this->query($sql,0);

		return mysql_result($res,0,0);
	}

	function calcularComisionAgenteBanca() {
		$sql = "select sum(c.importecomisionagente) from dbcotizaciones c
		inner join tbproductos p on p.idproducto = c.refproductos and p.reftipoproducto = 2
		where c.refestadocotizaciones > 6";

		$res = $this->query($sql,0);

		return mysql_result($res,0,0);
	}

	/**** fin del calculo *********************************************************/

	/* PARA Bonogestion */
	function existeBono() {
		$sql = 'select * from tbbonogestion';
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			return 1;
		}
		return 0;
	}

	function insertarBonogestion($bonoseguros,$bonoafore,$bonobanca) {
		$sql = "insert into tbbonogestion(idbonogestion,bonoseguros,bonoafore,bonobanca)
		values ('',".$bonoseguros.",".$bonoafore.",".$bonobanca.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarBonogestion($id,$bonoseguros,$bonoafore,$bonobanca) {
		$sql = "update tbbonogestion
		set
		bonoseguros = ".$bonoseguros.",bonoafore = ".$bonoafore.",bonobanca = ".$bonobanca."
		where idbonogestion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarBonogestion($id) {
		$sql = "delete from tbbonogestion where idbonogestion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerBonogestion() {
		$sql = "select
		b.idbonogestion,
		b.bonoseguros,
		b.bonoafore,
		b.bonobanca
		from tbbonogestion b
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerBonogestionPorId($id) {
		$sql = "select idbonogestion,bonoseguros,bonoafore,bonobanca from tbbonogestion where idbonogestion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbbonogestion*/

	/* PARA Constancias */
	function existeConstancia($refasesores,$meses,$accion,$id='') {

		if ($accion == 'M') {
			$sql = "select * from dbconstancias where refasesores = ".$refasesores." and meses = ".$meses." and idconstancia <> ".$id;
		} else {
			$sql = "select * from dbconstancias where refasesores = ".$refasesores." and meses = ".$meses;
		}

		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			return 1;
		}

		return 0;
	}

	function insertarConstancias($refasesores,$meses,$cumplio,$fechacrea,$fechamodi,$base,$importe,$tipo) {
		$sql = "insert into dbconstancias(idconstancia,refasesores,meses,cumplio,fechacrea,fechamodi,base,importe,tipo)
		values ('',".$refasesores.",".$meses.",'".$cumplio."','".$fechacrea."','".$fechamodi."','".$base."',".$importe.",'".$tipo."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarConstancias($id,$refasesores,$meses,$cumplio,$fechamodi,$base,$importe,$tipo) {
		$sql = "update dbconstancias
		set
		refasesores = ".$refasesores.",meses = ".$meses.",cumplio = '".$cumplio."',fechamodi = '".$fechamodi."',base = '".$base."',importe = ".$importe.",tipo = '".$tipo."'
		where idconstancia =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarConstancias($id) {
		$sql = "delete from dbconstancias where idconstancia =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerConstanciasajax($length, $start, $busqueda,$colSort,$colSortDir,$asesor) {

		if ($asesor != '') {
			$cadAsesor = " ase.idasesor = ".$asesor." and ";
		} else {
			$cadAsesor = '';
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where ".$cadAsesor." concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' )";
		} else {
			$where = " where ".$cadAsesor." 1=1 ";
		}


		$sql = "select
		c.idconstancia,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		c.meses,
		(case when c.cumplio = '1' then 'Si' else 'No' end) as cumplio,
		c.importe,
		(case when c.cumplio = '0' then '-' else (case when c.tipo = '1' then 'Bajo' else 'Alto' end) end) as tipo,
		c.fechacrea,
		c.fechamodi,
		c.base,
		c.refasesores
		from dbconstancias c
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function calcularImporteBonoReclutamiento() {
		$sql = "select
				sum(c.importe)
				from		dbconstancias c
				inner
				join		dbasesores ase on ase.idasesor = c.refasesores
				inner
				join		dbusuarios usu on usu.idusuario = ase.refusuarios
				left
				join		tborigenreclutamiento sc on sc.idorigenreclutamiento = usu.refsocios
				where		c.cumplio = '1'";

		$res = $this->query($sql,0);

		return $res;
	}


	function traerConstancias() {
		$sql = "select
		c.idconstancia,
		c.refasesores,
		c.meses,
		c.cumplio,
		c.fechacrea,
		c.fechamodi,
		c.base,
		c.importe,
		c.tipo
		from dbconstancias c
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerConstanciasPorAsesor($idasesor) {
		$sql = "select
		c.idconstancia,
		c.refasesores,
		c.meses,
		c.cumplio,
		c.fechacrea,
		c.fechamodi,
		c.base,
		c.importe,
		c.tipo
		from dbconstancias c
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		where ase.idasesor = ".$idasesor."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerConstanciasPorUsuario($idusuario) {
		$sql = "select
		c.idconstancia,
		c.refasesores,
		c.meses,
		c.cumplio,
		c.fechacrea,
		c.fechamodi,
		c.base,
		c.importe,
		c.tipo
		from dbconstancias c
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		inner join dbusuarios usu ON usu.idusuario = ase.refusuarios
		where usu.idusuario = ".$idusuario."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerConstanciasPorId($id) {
		$sql = "select idconstancia,refasesores,meses,cumplio,fechacrea,fechamodi,base,importe,tipo from dbconstancias where idconstancia =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbconstancias*/

	function traerCalcularConstanciasajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and r.nombrecompleto like '%".$busqueda."%' )";
		}


		$sql = "SELECT
				   concat(ase.idasesor,'-',r.meses) as id,
					concat( ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as nombrecompleto,
					ase.fechaalta,
					r.meses
				FROM
				    (SELECT
				        a.idasesor,
						coalesce( TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(a.fechaalta), '-', RIGHT(CONCAT('00', MONTH(a.fechaalta)), 2), '-', '01'), '%Y-%m-%d'), CURDATE()),0) AS meses,
						a.fechaalta
				    FROM
				        dbasesores a
				    INNER JOIN tbmesesconstacia tm ON TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(a.fechaalta), '-', RIGHT(CONCAT('00', MONTH(a.fechaalta)), 2), '-', '01'), '%Y-%m-%d'), CURDATE()) = tm.mes
				    WHERE
				        DAY(a.fechaalta) <= 16

				UNION ALL

					SELECT
				        a.idasesor,
						coalesce( TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH)), '-', RIGHT(CONCAT('00', MONTH(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH))), 2), '-', '01'), '%Y-%m-%d'), CURDATE()),0) AS meses,
						a.fechaalta
				    FROM
				        dbasesores a
				    INNER JOIN tbmesesconstacia tm ON TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH)), '-', RIGHT(CONCAT('00', MONTH(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH))), 2), '-', '01'), '%Y-%m-%d'), CURDATE()) = tm.mes
				    WHERE
				        DAY(a.fechaalta) > 15) r
						  INNER JOIN
						dbasesores ase ON ase.idasesor = r.idasesor
				        LEFT JOIN
				    dbconstancias co ON co.refasesores = r.idasesor
				        AND co.meses = r.meses
				WHERE
				    co.idconstancia IS NULL ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function calcularConstancias() {
		$sql = "SELECT
				   ase.idasesor,
					concat( ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as nombrecompleto,
					ase.fechaalta,
					r.meses
				FROM
				    (SELECT
				        a.idasesor,
						coalesce( TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(a.fechaalta), '-', RIGHT(CONCAT('00', MONTH(a.fechaalta)), 2), '-', '01'), '%Y-%m-%d'), CURDATE()),0) AS meses,
						a.fechaalta
				    FROM
				        dbasesores a
				    INNER JOIN tbmesesconstacia tm ON TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(a.fechaalta), '-', RIGHT(CONCAT('00', MONTH(a.fechaalta)), 2), '-', '01'), '%Y-%m-%d'), CURDATE()) = tm.mes
				    WHERE
				        DAY(a.fechaalta) <= 16

				UNION ALL

					SELECT
				        a.idasesor,
						coalesce( TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH)), '-', RIGHT(CONCAT('00', MONTH(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH))), 2), '-', '01'), '%Y-%m-%d'), CURDATE()),0) AS meses,
						a.fechaalta
				    FROM
				        dbasesores a
				    INNER JOIN tbmesesconstacia tm ON TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH)), '-', RIGHT(CONCAT('00', MONTH(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH))), 2), '-', '01'), '%Y-%m-%d'), CURDATE()) = tm.mes
				    WHERE
				        DAY(a.fechaalta) > 15) r
						  INNER JOIN
						dbasesores ase ON ase.idasesor = r.idasesor
				        LEFT JOIN
				    dbconstancias co ON co.refasesores = r.idasesor
				        AND co.meses = r.meses
				WHERE
				    co.idconstancia IS NULL";

		$res = $this->query($sql,0);

		return $res;
	}


	function calcularConstanciasAnticipadas() {
		$sql = "SELECT
				   ase.idasesor,
					concat( ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as nombrecompleto,
					ase.fechaalta,
					r.meses
				FROM
				    (SELECT
				        a.idasesor,
						coalesce( TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(a.fechaalta), '-', RIGHT(CONCAT('00', MONTH(a.fechaalta)), 2), '-', '01'), '%Y-%m-%d'), CURDATE()),0) AS meses,
						a.fechaalta
				    FROM
				        dbasesores a
				    INNER JOIN tbmesesconstacia tm ON TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(a.fechaalta), '-', RIGHT(CONCAT('00', MONTH(a.fechaalta)), 2), '-', '01'), '%Y-%m-%d'), CURDATE()) = tm.mes - 1
				    WHERE
				        DAY(a.fechaalta) <= 16

				UNION ALL

					SELECT
				        a.idasesor,
						coalesce( TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH)), '-', RIGHT(CONCAT('00', MONTH(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH))), 2), '-', '01'), '%Y-%m-%d'), CURDATE()),0) AS meses,
						a.fechaalta
				    FROM
				        dbasesores a
				    INNER JOIN tbmesesconstacia tm ON TIMESTAMPDIFF(MONTH, STR_TO_DATE(CONCAT(YEAR(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH)), '-', RIGHT(CONCAT('00', MONTH(DATE_ADD(a.fechaalta, INTERVAL 1 MONTH))), 2), '-', '01'), '%Y-%m-%d'), CURDATE()) = tm.mes - 1
				    WHERE
				        DAY(a.fechaalta) > 15) r
						  INNER JOIN
						dbasesores ase ON ase.idasesor = r.idasesor
				        LEFT JOIN
				    dbconstancias co ON co.refasesores = r.idasesor
				        AND co.meses = r.meses
				WHERE
				    co.idconstancia IS NULL";

		$res = $this->query($sql,0);

		return $res;
	}

	function traerPersonaPorTabla($tabla) {
		switch ($tabla) {
			case 1:
				$res 	 = $this->traerAsesores();
			break;
			case 2:
				$res	 = $this->traerAsociados();
			break;
			case 9:
				$res	 = $this->traerUsuariosPorRol(3);
			break;
			case 10:
				$res	 = $this->traerOrigenreclutamiento();
			break;
			default:
				$res = array();
		}

		return $res;
	}


	function insertarTabla($tabla,$especifico) {
		$sql = "insert into tbtabla(idtabla,tabla,especifico)
		values ('','".$tabla."','".$especifico."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTabla($id,$tabla,$especifico) {
		$sql = "update tbtabla
		set
		tabla = '".$tabla."',especifico = '".$especifico."'
		where idtabla =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTabla($id) {
		$sql = "delete from tbtabla where idtabla =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTabla() {
		$sql = "select
		t.idtabla,
		t.tabla,
		t.especifico,
		t.nombreid
		from tbtabla t
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTablaPorId($id) {
		$sql = "select idtabla,tabla,especifico,nombreid from tbtabla where idtabla =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerTablaPorIn($in) {
		$sql = "select idtabla,tabla,especifico,nombreid from tbtabla where idtabla in (".$in.")";
		$res = $this->query($sql,0);
		return $res;
	}

   function devolverCamposTabla($tabla) {
      $sql = "show columns from ".$tabla;
      $res = $this->query($sql,0);
		return $res;
   }


	/* Fin */
	/* /* Fin de la Tabla: tbtabla*/


/* PARA Solicitudpdf */

function insertarSolicitudpdf($solicitudpdf) {
$sql = "insert into tbsolicitudpdf(idsolicitudpdf,solicitudpdf)
values ('','".$solicitudpdf."')";
$res = $this->query($sql,1);
return $res;
}


function modificarSolicitudpdf($id,$solicitudpdf) {
$sql = "update tbsolicitudpdf
set
solicitudpdf = '".$solicitudpdf."'
where idsolicitudpdf =".$id;
$res = $this->query($sql,0);
return $res;
}


function eliminarSolicitudpdf($id) {
$sql = "delete from tbsolicitudpdf where idsolicitudpdf =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerSolicitudpdf() {
$sql = "select
s.idsolicitudpdf,
s.solicitudpdf
from tbsolicitudpdf s
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerSolicitudpdfPorId($id) {
$sql = "select idsolicitudpdf,solicitudpdf from tbsolicitudpdf where idsolicitudpdf =".$id;
$res = $this->query($sql,0);
return $res;
}


/* Fin */
/* /* Fin de la Tabla: tbsolicitudpdf*/


	/* PARA Comisiones */

	function insertarComisiones($reftabla,$idreferencia,$monto,$porcentaje,$fechacreacion) {
		$sql = "insert into dbcomisiones(idcomision,reftabla,idreferencia,monto,porcentaje,fechacreacion)
		values ('',".$reftabla.",".$idreferencia.",".$monto.",".$porcentaje.",'".$fechacreacion."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarComisiones($id,$reftabla,$idreferencia,$monto,$porcentaje) {
		$sql = "update dbcomisiones
		set
		reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",monto = ".$monto.",porcentaje = ".$porcentaje."
		where idcomision =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarComisiones($id) {
		$sql = "delete from dbcomisiones where idcomision =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerComisiones() {
		$sql = "select
		c.idcomision,
		c.reftabla,
		c.idreferencia,
		c.monto,
		c.porcentaje,
		c.fechacreacion
		from dbcomisiones c
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerComisionesPorTablaReferencia($idtabla, $tabla, $idnombre, $id) {
		$sql = "select
		c.idcomision,
		c.reftabla,
		c.idreferencia,
		c.monto,
		c.porcentaje,
		c.fechacreacion
		from dbcomisiones c
		inner join ".$tabla." v on v.".$idnombre." = c.idreferencia
		where c.reftabla = ".$idtabla." and c.idreferencia = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerComisionesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (tt.especifico '%".$busqueda."%' concat(a_1.apellidopaterno, ' ', a_1.apellidomaterno, ' ', a_1.nombre) like '%".$busqueda."%' or concat(a_2.apellidopaterno, ' ', a_2.apellidomaterno, ' ', a_2.nombre) like '%".$busqueda."%' or a_9.nombrecompleto like '%".$busqueda."%' or a_10.origenreclutamiento like '%".$busqueda."%' )";
		}

		$resTabla = $this->traerTablaPorIn('1,2,9,10');

		$cadInner = '';
		while ($row = mysql_fetch_array($resTabla)) {
			$cadInner .= ' left join '.$row['tabla'].' a_'.$row['idtabla'].' on a_'.$row['idtabla'].'.'.$row['nombreid']." = c.idreferencia and c.reftabla = '".$row['idtabla']."' ";
		}

		$sql = "select
		c.idcomision,
		tt.especifico,
    	(case when c.reftabla = 1 then concat(a_1.apellidopaterno, ' ', a_1.apellidomaterno, ' ', a_1.nombre)
		   when c.reftabla = 2 then concat(a_2.apellidopaterno, ' ', a_2.apellidomaterno, ' ', a_2.nombre)
         when c.reftabla = 9 then a_9.nombrecompleto
         when c.reftabla = 10 then a_10.origenreclutamiento end) as persona,
		c.monto,
		c.porcentaje,
		c.fechacreacion,
		c.reftabla,
		c.idreferencia
		from dbcomisiones c
		inner join tbtabla tt on tt.idtabla = c.reftabla
		".$cadInner."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerComisionesPorId($id) {
		$sql = "select idcomision,reftabla,idreferencia,monto,porcentaje,fechacreacion from dbcomisiones where idcomision =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbcomisiones*/


	/* PARA Perfilasesoresespecialidades */

	function insertarPerfilasesoresespecialidades($refperfilasesores,$refespecialidades) {
		$sql = "insert into dbperfilasesoresespecialidades(idperfilasesorespecialidad,refperfilasesores,refespecialidades)
		values ('',".$refperfilasesores.",".$refespecialidades.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPerfilasesoresespecialidades($id,$refperfilasesores,$refespecialidades) {
		$sql = "update dbperfilasesoresespecialidades
		set
		refperfilasesores = ".$refperfilasesores.",refespecialidades = ".$refespecialidades."
		where idperfilasesorespecialidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarPerfilasesoresespecialidades($id) {
		$sql = "delete from dbperfilasesoresespecialidades where idperfilasesorespecialidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarPerfilasesoresespecialidadesPorPerfil($id) {
		$sql = "delete from dbperfilasesoresespecialidades where refperfilasesores =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPerfilasesoresespecialidades() {
		$sql = "select
		p.idperfilasesorespecialidad,
		p.refperfilasesores,
		p.refespecialidades
		from dbperfilasesoresespecialidades p
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPerfilasesoresespecialidadesPorId($id) {
		$sql = "select idperfilasesorespecialidad,refperfilasesores,refespecialidades from dbperfilasesoresespecialidades where idperfilasesorespecialidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPerfilasesoresespecialidadesPorPerfil($idperfil) {
		$sql = "select
		p.idperfilasesorespecialidad,
		p.refperfilasesores,
		p.refespecialidades
		from dbperfilasesoresespecialidades p
		inner join tbespecialidades esp on esp.idespecialidad = p.refespecialidades
		where p.refperfilasesores =".$idperfil."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbperfilasesoresespecialidades*/


	/* PARA Tipofigura */

	function insertarTipofigura($tipofigura) {
	$sql = "insert into tbtipofigura(idtipofigura,tipofigura)
	values ('','".$tipofigura."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTipofigura($id,$tipofigura) {
	$sql = "update tbtipofigura
	set
	tipofigura = '".$tipofigura."'
	where idtipofigura =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTipofigura($id) {
	$sql = "delete from tbtipofigura where idtipofigura =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipofigura() {
	$sql = "select
	t.idtipofigura,
	t.tipofigura
	from tbtipofigura t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipofiguraPorId($id) {
	$sql = "select idtipofigura,tipofigura from tbtipofigura where idtipofigura =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtipofigura*/

	/* PARA Especialidades */

	function insertarEspecialidades($especialidad) {
		$sql = "insert into tbespecialidades(idespecialidad,especialidad)
		values ('','".$especialidad."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEspecialidades($id,$especialidad) {
		$sql = "update tbespecialidades
		set
		especialidad = '".$especialidad."'
		where idespecialidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEspecialidades($id) {
		$sql = "delete from tbespecialidades where idespecialidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEspecialidades() {
		$sql = "select
		e.idespecialidad,
		e.especialidad
		from tbespecialidades e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEspecialidadesajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';


		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where (e.especialidad like '%".$busqueda."%')";
		}


		$sql = "select
		e.idespecialidad,
		e.especialidad
		from tbespecialidades e
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerEspecialidadesPorId($id) {
		$sql = "select idespecialidad,especialidad from tbespecialidades where idespecialidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbespecialidades*/

	/* PARA Perfilasesores */

	function insertarPerfilasesores($reftabla,$idreferencia,$imagenperfil,$imagenfirma,$urllinkedin,$urlfacebook,$urlinstagram,$visible,$urloficial,$reftipofigura,$marcapropia) {
		$sql = "insert into dbperfilasesores(idperfilasesor,reftabla,idreferencia,imagenperfil,imagenfirma,urllinkedin,urlfacebook,urlinstagram,visible,token,urloficial,reftipofigura,marcapropia)
		values ('',".$reftabla.",".$idreferencia.",'".$imagenperfil."','".$imagenfirma."','".$urllinkedin."','".$urlfacebook."','".$urlinstagram."','".$visible."','".$this->GUID()."','".$urloficial."',".$reftipofigura.",'".$marcapropia."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPerfilasesores($id,$reftabla,$idreferencia,$imagenperfil,$imagenfirma,$urllinkedin,$urlfacebook,$urlinstagram,$visible,$urloficial,$reftipofigura,$marcapropia,$email,$emisoremail,$domicilio) {
		$sql = "update dbperfilasesores
		set
		reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",urllinkedin = '".$urllinkedin."',urlfacebook = '".$urlfacebook."',urlinstagram = '".$urlinstagram."',visible = '".$visible."',urloficial = '".$urloficial."',reftipofigura = ".$reftipofigura.",marcapropia = '".$marcapropia."',email = '".$email."',emisoremail = '".$emisoremail."',domicilio = '".$domicilio."'
		where idperfilasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarPerfilasesoresPorImagen($id,$imagen,$archivo) {
		$sql = "update dbperfilasesores
		set
		".$imagen." = '".$archivo."' where idperfilasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarPerfilasesores($id) {
		$sql = "delete from dbperfilasesores where idperfilasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPerfilasesores() {
		$sql = "select
		p.idperfilasesor,
		p.reftabla,
		p.idreferencia,
		p.imagenperfil,
		p.imagenfirma,
		p.urllinkedin,
		p.urlfacebook,
		p.urlinstagram,
		p.visible,
		p.token,
		p.urloficial,
		p.reftipofigura,
		p.marcapropia,
		p.imagenlogo,
		p.email,
		p.emisoremail,
		p.domicilio
		from dbperfilasesores p
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPerfilasesoresPorTablaReferencia($idtabla, $tabla, $idnombre, $id) {
		$sql = "select
		d.idperfilasesor,
		d.reftabla,
		d.idreferencia,
		d.imagenperfil,
		d.imagenfirma,
		d.urllinkedin,
		d.urlfacebook,
		d.urlinstagram,
		d.visible,
		d.token,
		d.urloficial,
		d.reftipofigura,
		d.marcapropia,
		d.imagenlogo,
		d.email,
		d.emisoremail,
		d.domicilio
		from dbperfilasesores d
		inner join ".$tabla." v on v.".$idnombre." = d.idreferencia
		where d.reftabla = ".$idtabla." and d.idreferencia = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPerfilasesoresPorId($id) {
		$sql = "select idperfilasesor,reftabla,idreferencia,imagenperfil,imagenfirma,urllinkedin,urlfacebook,urlinstagram,visible,token,urloficial,reftipofigura,marcapropia,imagenlogo,email,emisoremail,domicilio from dbperfilasesores where idperfilasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPerfilasesoresPorIdCompleto($id) {
		$sql = "select
		idperfilasesor,
		reftabla,
		idreferencia,
		concat('archivos/informacion/',idperfilasesor,'/', imagenperfil) as imagenperfil,
		concat('archivos/informacion/',idperfilasesor,'/', imagenfirma) as imagenfirma,
		concat('archivos/informacion/',idperfilasesor,'/', imagenlogo) as imagenlogo,
		urllinkedin,
		urlfacebook,
		urlinstagram,
		(case when visible = '1' then 'Si' else 'No' end) as visible,
		token,
		urloficial,
		reftipofigura,
		(case when marcapropia = '1' then 'Si' else 'No' end) as marcapropia,
		email,
		emisoremail,
		domicilio
		from dbperfilasesores where idperfilasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPerfilasesoresPorIdImagenCompleto($id,$imagen) {

		switch ($imagen) {
			case 'imagenperfil':
				$cad = " and imagenperfil != ''";
			break;
			case 'imagenfirma':
				$cad = " and imagenfirma != ''";
			break;
			case 'imagenlogo':
				$cad = " and imagenlogo != ''";
			break;
		}


		$sql = "select
		idperfilasesor,
		reftabla,
		idreferencia,
		concat('archivos/informacion/',idperfilasesor,'/', imagenperfil) as imagenperfil,
		concat('archivos/informacion/',idperfilasesor,'/', imagenfirma) as imagenfirma,
		concat('archivos/informacion/',idperfilasesor,'/', imagenlogo) as imagenlogo,
		urllinkedin,
		urlfacebook,
		urlinstagram,
		(case when visible = '1' then 'Si' else 'No' end) as visible,
		token,
		urloficial,
		reftipofigura,
		(case when marcapropia = '1' then 'Si' else 'No' end) as marcapropia,
		email,
		emisoremail,
		domicilio
		from dbperfilasesores where idperfilasesor =".$id.$cad;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbperfilasesores*/

   /* PARA Socios */

	function insertarSocios($razonsocial,$comision,$esreclutador) {
		$sql = "insert into tbsocios(idsocio,razonsocial,comision,esreclutador)
		values ('','".$razonsocial."',".$comision.",'".$esreclutador."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarSocios($id,$razonsocial,$comision,$esreclutador) {
		$sql = "update tbsocios
		set
		razonsocial = '".$razonsocial."',comision = ".$comision.",esreclutador = '".$esreclutador."'
		where idsocio =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarSocios($id) {
		$sql = "delete from tbsocios where idsocio =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerSocios() {
		$sql = "select
		s.idsocio,
		s.razonsocial,
		s.comision,
		s.esreclutador
		from tbsocios s
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerSociosPorId($id) {
		$sql = "select idsocio,razonsocial,comision,esreclutador from tbsocios where idsocio =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbsocios*/

   /* PARA Estadogeneraloportunidad */

	function insertarEstadogeneraloportunidad($estadogeneraloportunidad) {
		$sql = "insert into tbestadogeneraloportunidad(idestadogeneraloportunidad,estadogeneraloportunidad)
		values ('','".$estadogeneraloportunidad."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadogeneraloportunidad($id,$estadogeneraloportunidad) {
		$sql = "update tbestadogeneraloportunidad
		set
		estadogeneraloportunidad = '".$estadogeneraloportunidad."'
		where idestadogeneraloportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadogeneraloportunidad($id) {
		$sql = "delete from tbestadogeneraloportunidad where idestadogeneraloportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadogeneraloportunidad() {
		$sql = "select
		e.idestadogeneraloportunidad,
		e.estadogeneraloportunidad
		from tbestadogeneraloportunidad e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadogeneraloportunidadPorId($id) {
		$sql = "select idestadogeneraloportunidad,estadogeneraloportunidad from tbestadogeneraloportunidad where idestadogeneraloportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadogeneraloportunidad*/

	/* PARA Documentacioncotizaciones */

	function modificarAsesoresunicaUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbasesores
		set
		".$campo." = '".$valor."'
		where idasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorAsesoresunicaDocumentacionCompleta($idasesor) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionasesorunica,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionasesoresunica da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refasesores = ".$idasesor."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.iddocumentacion in (27,31)

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionasesoresunica($refasesores,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionasesoresunica(iddocumentacionasesorunica,refasesores,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refasesores.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionasesoresunica($id,$refasesores,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechamodi,$usuariomodi) {
		$sql = "update dbdocumentacionasesoresunica
		set
		refasesores = ".$refasesores.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasesorunica =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionasesoresunica($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionasesoresunica
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasesorunica =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionAsesoresunicaPorDocumentacion($iddocumentacion,$idasesor, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionasesoresunica
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refasesores =".$idasesor;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionasesoresunica($id) {
		$sql = "delete from dbdocumentacionasesoresunica where iddocumentacionasesorunica =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresunicaPorAsesoresunicaDocumentacion($idasesor,$iddocumentacion) {
		$sql = "delete from dbdocumentacionasesoresunica where refasesores =".$idasesor." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresunicaPorAsesoresunicaDocumentacionEspecifico($idasesor,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionasesoresunica where refasesores =".$idasesor =" and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionAsesoresunicas($idasesor,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorAsesoresunicaDocumentacion($idasesor,$iddocumentacion);

		$resDocumentacion = $this->traerDocumentacionesPorId($iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
				$archivos = '../archivos/asesores/'.$idasesor.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionasesoresunica(mysql_result($resFoto,0,'iddocumentacionasesorunica'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionasesoresunica() {
		$sql = "select
		d.iddocumentacionasesorunica,
		d.refasesores,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionasesoresunica d
		inner join dbasesores ase ON ase.idasesor = d.refasesores
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionasesoresunicaPorId($id) {
		$sql = "select iddocumentacionasesorunica,refasesores,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionasesoresunica where iddocumentacionasesorunica =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorAsesoresunicaDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionasesorunica,da.refasesores,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionasesoresunica da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasesores =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}


	/* fin para documentaciones de asesores unica */


	/* PARA Domicilios */

	function insertarDomicilios($reftabla,$idreferencia,$calle,$numeroext,$numeroint,$colonia,$estado,$delegacion,$codigopostal) {
		$sql = "insert into dbdomicilios(iddomicilio,reftabla,idreferencia,calle,numeroext,numeroint,colonia,estado,delegacion,codigopostal)
		values ('',".$reftabla.",".$idreferencia.",'".$calle."','".$numeroext."','".$numeroint."','".$colonia."','".$estado."','".$delegacion."','".$codigopostal."')";
		$res = $this->query($sql,1);
		return $res;
	}

	function insertarDomiciliosDe($reftabla,$idreferencia,$id) {
		$sql = "insert into dbdomicilios(iddomicilio,reftabla,idreferencia,calle,numeroext,numeroint,colonia,estado,delegacion,codigopostal)
		select
		'',1,".$id.",calle,numeroext,numeroint,colonia,estado,delegacion,codigopostal
		from dbdomicilios where reftabla = ".$reftabla." and idreferencia =".$idreferencia;
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDomicilios($id,$reftabla,$idreferencia,$calle,$numeroext,$numeroint,$colonia,$estado,$delegacion,$codigopostal) {
		$sql = "update dbdomicilios
		set
		reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",calle = '".$calle."',numeroext = '".$numeroext."',numeroint = '".$numeroint."',colonia = '".$colonia."',estado = '".$estado."',delegacion = '".$delegacion."',codigopostal = '".$codigopostal."'
		where iddomicilio =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDomicilios($id) {
		$sql = "delete from dbdomicilios where iddomicilio =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDomicilios() {
		$sql = "select
		d.iddomicilio,
		d.reftabla,
		d.idreferencia,
		d.calle,
		d.numeroext,
		d.numeroint,
		d.colonia,
		d.estado,
		d.delegacion,
		d.codigopostal
		from dbdomicilios d
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDomiciliosPorTablaReferencia($idtabla, $tabla, $idnombre, $id) {
		$sql = "select
		d.iddomicilio,
		d.reftabla,
		d.idreferencia,
		d.calle,
		d.numeroext,
		d.numeroint,
		d.colonia,
		d.estado,
		d.delegacion,
		d.codigopostal
		from dbdomicilios d
		inner join ".$tabla." v on v.".$idnombre." = d.idreferencia
		where d.reftabla = ".$idtabla." and d.idreferencia = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDomiciliosPorId($id) {
		$sql = "select iddomicilio,reftabla,idreferencia,calle,numeroext,numeroint,colonia,estado,delegacion,codigopostal from dbdomicilios where iddomicilio =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbdomicilios*/


	/* PARA Clientesasesores */

	function insertarClientesasesores($refclientes,$refasesores,$apellidopaterno,$apellidomaterno,$nombre,$razonsocial,$domicilio,$email,$rfc,$ine,$reftipopersonas,$telefonofijo,$telefonocelular,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion) {
		$sql = "insert into dbclientesasesores(idclienteasesor,refclientes,refasesores,apellidopaterno,apellidomaterno,nombre,razonsocial,domicilio,email,rfc,ine,reftipopersonas,telefonofijo,telefonocelular,genero,refestadocivil,reftipoidentificacion,nroidentificacion)
		values ('',".$refclientes.",".$refasesores.",'".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$razonsocial."','".$domicilio."','".$email."','".$rfc."','".$ine."',".$reftipopersonas.",'".trim($telefonofijo)."','".trim($telefonocelular)."','".$genero."',".$refestadocivil.",".$reftipoidentificacion.",'".$nroidentificacion."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarClientesasesores($id,$refclientes,$refasesores,$apellidopaterno,$apellidomaterno,$nombre,$razonsocial,$domicilio,$email,$rfc,$ine,$reftipopersonas,$telefonofijo,$telefonocelular,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion) {
		$sql = "update dbclientesasesores
		set
		refclientes = ".$refclientes.",refasesores = ".$refasesores.",apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',razonsocial = '".$razonsocial."',domicilio = '".$domicilio."',email = '".$email."',rfc = '".$rfc."',ine = '".$ine."',reftipopersonas = ".$reftipopersonas.",telefonofijo = '".trim($telefonofijo)."',telefonocelular = '".trim($telefonocelular)."',genero = '".$genero."',refestadocivil = ".$refestadocivil.", reftipoidentificacion = ".$reftipoidentificacion.",nroidentificacion = '".$nroidentificacion."' where idclienteasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarClientesasesores($id) {
		$sql = "delete from dbclientesasesores where idclienteasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesasesoresajax($length, $start, $busqueda,$colSort,$colSortDir,$idasesor) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (cl.apellidopaterno like '%".$busqueda."%' or cl.apellidomaterno like '%".$busqueda."%' or cl.nombre like '%".$busqueda."%' or cl.email like '%".$busqueda."%' or cl.razonsocial like '%".$busqueda."%' or cl.ine like '%".$busqueda."%')";
		}


		$sql = "select
		cl.idcliente,
      tpp.tipopersona,
		cl.apellidopaterno,
		cl.apellidomaterno,
		cl.nombre,
		cl.razonsocial,
      cl.telefonofijo,
		cl.telefonocelular,
      cl.email,
      cl.numerocliente,
		cl.domicilio,
		cl.rfc,
		cl.ine,
      cl.reftipopersonas,
      c.refclientes,
		c.refasesores
		from dbclientesasesores c
      inner join dbclientes cl ON cl.idcliente = c.refclientes
      inner join dbasesores ase on ase.idasesor = c.refasesores
      inner join tbtipopersonas tpp ON tpp.idtipopersona = cl.reftipopersonas
		where ase.idasesor = ".$idasesor." ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      //die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerClientesasesores() {
		$sql = "select
		c.idclienteasesor,
		c.refclientes,
		c.refasesores,
		c.apellidopaterno,
		c.apellidomaterno,
		c.nombre,
		c.razonsocial,
		c.domicilio,
		c.email,
		c.rfc,
		c.ine,
		c.reftipopersonas,
		c.telefonofijo,
		c.telefonocelular,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto
		from dbclientesasesores c
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientesasesoresPorId($id) {
		$sql = "select idclienteasesor,refclientes,refasesores,apellidopaterno,apellidomaterno,nombre,razonsocial,domicilio,email,rfc,ine,reftipopersonas,telefonofijo,telefonocelular,genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbclientesasesores where idclienteasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerClientesasesoresPorAsesor($refasesor) {
		$sql = "select
		c.idclienteasesor,
		c.refclientes,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.domicilio,
		c.email,
		c.rfc,
		c.ine,
		c.reftipopersonas,
		c.telefonofijo,
		c.telefonocelular,
		c.refasesores,
      c.genero,
      c.refestadocivil,
      c.reftipoidentificacion,
      c.nroidentificacion,
      (case when c.reftipopersonas = 1 then concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) else concat(c.razonsocial, ' - ', c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) end) as nombrecompleto
		from dbclientesasesores c
		inner join dbclientes cl ON cl.idcliente = c.refclientes
		inner join dbasesores ase on ase.idasesor = c.refasesores
		where ase.refusuarios = ".$refasesor;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerClientesasesoresPorAsesorNuevo($refasesor) {
		$sql = "select
      cl.idcliente,
		c.refclientes,
		cl.nombre,
		cl.apellidopaterno,
		cl.apellidomaterno,
		cl.razonsocial,
		cl.domicilio,
		cl.email,
		cl.rfc,
		cl.ine,
		cl.reftipopersonas,
		cl.telefonofijo,
		cl.telefonocelular,
		c.refasesores,
      cl.genero,
      cl.refestadocivil,
      cl.reftipoidentificacion,
      cl.nroidentificacion,
      (case when c.reftipopersonas = 1 then concat(cl.apellidopaterno, ' ', cl.apellidomaterno, ' ', cl.nombre) else concat(cl.razonsocial, ' - ', cl.apellidopaterno, ' ', cl.apellidomaterno, ' ', cl.nombre) end) as nombrecompleto
		from dbclientesasesores c
		inner join dbclientes cl ON cl.idcliente = c.refclientes
		inner join dbasesores ase on ase.idasesor = c.refasesores
		where ase.idasesor = ".$refasesor;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesasesoresPorAsesorNuevoGroupBy($refasesor) {
		$sql = "select
      cl.idcliente,
		c.refclientes,
		cl.nombre,
		cl.apellidopaterno,
		cl.apellidomaterno,
		cl.razonsocial,
		cl.domicilio,
		cl.email,
		cl.rfc,
		cl.ine,
		cl.reftipopersonas,
		cl.telefonofijo,
		cl.telefonocelular,
		c.refasesores,
      cl.genero,
      cl.refestadocivil,
      cl.reftipoidentificacion,
      cl.nroidentificacion,
      (case when c.reftipopersonas = 1 then concat(cl.apellidopaterno, ' ', cl.apellidomaterno, ' ', cl.nombre) else concat(cl.razonsocial, ' - ', cl.apellidopaterno, ' ', cl.apellidomaterno, ' ', cl.nombre) end) as nombrecompleto
		from dbclientesasesores c
		inner join dbclientes cl ON cl.idcliente = c.refclientes
		inner join dbasesores ase on ase.idasesor = c.refasesores
		where ase.idasesor = ".$refasesor."
      group by
      cl.idcliente,
		c.refclientes,
		cl.nombre,
		cl.apellidopaterno,
		cl.apellidomaterno,
		cl.razonsocial,
		cl.domicilio,
		cl.email,
		cl.rfc,
		cl.ine,
		cl.reftipopersonas,
		cl.telefonofijo,
		cl.telefonocelular,
		c.refasesores,
      cl.genero,
      cl.refestadocivil,
      cl.reftipoidentificacion,
      cl.nroidentificacion
      order by (case when c.reftipopersonas = 1 then concat(cl.apellidopaterno, ' ', cl.apellidomaterno, ' ', cl.nombre) else concat(cl.razonsocial, ' - ', cl.apellidopaterno, ' ', cl.apellidomaterno, ' ', cl.nombre) end)";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesasesoresPorAsesorTipoPersona($refasesor,$tipopersona) {
		$sql = "select
		cl.idcliente,
      concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto,
      c.razonsocial,
		c.refclientes
		from dbclientesasesores c
		inner join dbclientes cl ON cl.idcliente = c.refclientes
		inner join dbasesores ase on ase.idasesor = c.refasesores
		where ase.idasesor = ".$refasesor." and c.reftipopersonas =".$tipopersona;
		$res = $this->query($sql,0);
		return $res;
	}

	function bClientesasesoresPorAsesor($busqueda,$tipopersona,$refasesor) {
		$sql = "select
		c.idclienteasesor,
		c.refclientes,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.domicilio,
		c.email,
		c.rfc,
		c.ine,
		cl.reftipopersonas,
		c.telefonofijo,
		c.telefonocelular,
		c.refasesores,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto,
		cl.idclienteinbursa,
      cl.idcliente
		from dbclientesasesores c
		inner join dbclientes cl ON cl.idcliente = c.refclientes
		inner join dbasesores ase on ase.idasesor = c.refasesores";
      if ($tipopersona == 1) {
         $sql .= " where ase.idasesor = ".$refasesor." and concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) like '%".$busqueda."%' and c.reftipopersonas = ".$tipopersona." order by concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre)";
      } else {
         $sql .= " where ase.idasesor = ".$refasesor." and c.razonsocial like '%".$busqueda."%' and c.reftipopersonas = ".$tipopersona." order by c.razonsocial";
      }

		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbclientesasesores*/


	/* PARA Directorioasesores */

	function insertarDirectorioasesores($refasesores,$area,$razonsocial,$telefono,$email,$telefonocelular) {
		$sql = "insert into dbdirectorioasesores(iddirectorioasesor,refasesores,area,razonsocial,telefono,email,telefonocelular)
		values ('',".$refasesores.",'".$area."','".$razonsocial."','".$telefono."','".$email."','".$telefonocelular."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDirectorioasesores($id,$refasesores,$area,$razonsocial,$telefono,$email,$telefonocelular) {
		$sql = "update dbdirectorioasesores
		set
		refasesores = ".$refasesores.",area = '".$area."',razonsocial = '".$razonsocial."',telefono = '".$telefono."',email = '".$email."',telefonocelular = '".$telefonocelular."'
		where iddirectorioasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDirectorioasesores($id) {
		$sql = "delete from dbdirectorioasesores where iddirectorioasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDirectorioasesores() {
		$sql = "select
		d.iddirectorioasesor,
		d.refasesores,
		d.area,
		d.razonsocial,
		d.telefono,
		d.telefonocelular,
		d.email
		from dbdirectorioasesores d
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDirectorioasesoresajax($length, $start, $busqueda,$colSort,$colSortDir,$refasesores) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (d.area like '%".$busqueda."%' or d.razonsocial like '%".$busqueda."%' or d.telefono like '%".$busqueda."%' or d.email like '%".$busqueda."%' or d.telefonocelular like '%".$busqueda."%' )";
		}


		$sql = "select
		d.iddirectorioasesor,
		d.area,
		d.razonsocial,
		d.telefono,
		d.telefonocelular,
		d.email,
		d.refasesores
		from dbdirectorioasesores d
		where d.refasesores = ".$refasesores." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerDirectorioasesoresPorId($id) {
		$sql = "select iddirectorioasesor,refasesores,area,razonsocial,telefono,email,telefonocelular from dbdirectorioasesores where iddirectorioasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDirectorioasesoresPorAsesor($idasesor) {
		$sql = "select iddirectorioasesor,refasesores,area,razonsocial,telefono,email,telefonocelular from dbdirectorioasesores where refasesores =".$idasesor;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbdirectorioasesores*/

	/* PARA Estadoasesor */

	function insertarEstadoasesor($estadoasesor) {
		$sql = "insert into tbestadoasesor(idestadoasesor,estadoasesor)
		values ('','".$estadoasesor."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadoasesor($id,$estadoasesor) {
		$sql = "update tbestadoasesor
		set
		estadoasesor = '".$estadoasesor."'
		where idestadoasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadoasesor($id) {
		$sql = "delete from tbestadoasesor where idestadoasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadoasesor() {
		$sql = "select
		e.idestadoasesor,
		e.estadoasesor
		from tbestadoasesor e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadoasesorPorId($id) {
		$sql = "select idestadoasesor,estadoasesor from tbestadoasesor where idestadoasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */

	/* PARA Tipoasociado */

	function insertarTipoasociado($tipoasociado,$comision) {
		$sql = "insert into tbtipoasociado(idtipoasociado,tipoasociado,comision)
		values ('','".$tipoasociado."',".$comision.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTipoasociado($id,$tipoasociado,$comision) {
		$sql = "update tbtipoasociado
		set
		tipoasociado = '".$tipoasociado."',comision = ".$comision."
		where idtipoasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTipoasociado($id) {
		$sql = "delete from tbtipoasociado where idtipoasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoasociado() {
		$sql = "select
		t.idtipoasociado,
		t.tipoasociado,
		t.comision
		from tbtipoasociado t
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipoasociadoPorId($id) {
		$sql = "select idtipoasociado,tipoasociado,comision from tbtipoasociado where idtipoasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtipoasociado*/

	function graficoVentasPorGerentes() {
		$sql = "select
				u.nombrecompleto,
				sum(u.activo) as activo,
				count(u.asesores) as asesores
				from (
					SELECT
						gc.nombrecompleto,
						(CASE
							WHEN COALESCE(r.diffmeses, 99) > 6 THEN 0
							ELSE 1
						END) AS activo,
						a.idasesor AS asesores
					FROM
						(SELECT
							COALESCE(TIMESTAMPDIFF(MONTH, p.ultimafecha, CURDATE()), 99) AS diffmeses,
								p.idasesor
						FROM
							(SELECT
							MAX(c.fechaemitido) AS ultimafecha, a.idasesor
						FROM
							dbcotizaciones c
						INNER JOIN dbasesores a ON c.refasesores = a.idasesor
						LEFT JOIN dbasociados aso ON aso.idasociado = c.refasociados
						WHERE
							c.refestadocotizaciones >= 6
						GROUP BY a.idasesor) p) r
							RIGHT JOIN
						dbasesores a ON a.idasesor = r.idasesor
							LEFT JOIN
						dbpostulantes p ON p.refusuarios = a.refusuarios
							INNER JOIN
						dbreclutadorasores rrr ON (rrr.refasesores = a.idasesor
							OR rrr.refpostulantes = p.idpostulante)
							INNER JOIN
						dbusuarios gc ON gc.idusuario = rrr.refusuarios
				) u
				group by u.nombrecompleto
				";
		$res = $this->query($sql,0);

		$asesores = '';
		$activos = '';
		$gerentecomercial = '';

		$arGerente = array();
		$arGerentePorcentaje = array();

		while ($rowG = mysql_fetch_array($res)) {
			$asesores .= $rowG['asesores'].",";
			$activos .= $rowG['activo'].",";
			$gerentecomercial .= "'".$rowG['nombrecompleto']."',";
			array_push($arGerente,$rowG['nombrecompleto']);
			if ((integer)$rowG['asesores'] != 0) {
				array_push($arGerentePorcentaje,round(((integer)$rowG['activo'] * 100 / (integer)$rowG['asesores']),2));
			} else {
				array_push($arGerentePorcentaje,0);
			}

		}

		if (strlen($asesores) > 0 ) {
			$asesores = substr($asesores,0,-1);
		}

		if (strlen($activos) > 0 ) {
			$activos = substr($activos,0,-1);
		}

		if (strlen($gerentecomercial) > 0 ) {
			$gerentecomercial = substr($gerentecomercial,0,-1);
		}

		return array('asesores'=>$asesores, 'activo' => $activos, 'nombrecompleto' => $gerentecomercial,'arGerente' => $arGerente, 'arPorcentajes' => $arGerentePorcentaje);
	}

	function graficosVentasAnuales() {
		$sql = "select
					coalesce( r.cantidad,0) as cantidad,
					m.meses
				from	(
				    select
						count(*) as cantidad,
						month(c.fechaemitido) as mes
					from		dbcotizaciones c
					inner
					join		dbasesores a
					on			c.refasesores = a.idasesor
					left
					join		dbasociados aso
					on			aso.idasociado = c.refasociados

					where		c.refestadocotizaciones>=6
					group by    month(c.fechaemitido)
				    ) r
				    right
				    join 		tbmeses m
				    on			m.idmes = r.mes";
		$res = $this->query($sql,0);

		$meses = '';
		$cantidad = '';

		while ($rowG = mysql_fetch_array($res)) {
			$meses .= "'".$rowG['meses']."',";
			$cantidad .= $rowG['cantidad'].",";
		}

		if (strlen($meses) > 0 ) {
			$meses = substr($meses,0,-1);
		}

		if (strlen($cantidad) > 0 ) {
			$cantidad = substr($cantidad,0,-1);
		}

		return array('meses'=>$meses, 'cantidad' => $cantidad);
	}

	function traerOportunidadesAsociados() {
		$sql = "select
					o.idoportunidad, concat(o.apellidopaterno, ' ', o.apellidomaterno, ' ', o.nombre) as apyn
				from	dboportunidades o
				left
				join	dbasociados ast on ast.refoportunidades = o.idoportunidad
				where	ast.idasociado is null and o.refestadooportunidad = 7";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPostulantesAsociados() {
		$sql = "select
					o.idpostulante, concat(o.apellidopaterno, ' ', o.apellidomaterno, ' ', o.nombre) as apyn
				from	dbpostulantes o
				left
				join	dbasociados ast on ast.refpostulantes = o.idpostulante
				where	ast.idasociado is null and o.refestadopostulantes = 11";
		$res = $this->query($sql,0);
		return $res;
	}

	function enviarEmail($destinatario,$asunto,$cuerpo, $referencia='') {


		# Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
		# se deshabilita y los mensajes son enviados tan rápido como sea posible.
	   if ($referencia == '') {
	      $referencia = 'consulta@asesorescrea.com';
	   }
	   # Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
	   # se deshabilita y los mensajes son enviados tan rápido como sea posible.
	   //define("MAILQUEUE_BATCH_SIZE",0);

	   //para el envío en formato HTML
	   //$headers = "MIME-Version: 1.0\r\n";

	   // Cabecera que especifica que es un HMTL
	   $headers  = 'MIME-Version: 1.0' . "\r\n";
	   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	   //dirección del remitente
	   $headers .= utf8_decode("From: ASESORES CREA <consulta@asesorescrea.com>\r\n");

		mail($destinatario,$asunto,$cuerpo,$headers);
	}

	// cuando un asesor no vende en 6 meses pasa a inactivo
	function cronBajaAsesor() {

	}

	// si cotizo y el estado es pagado entonces pasa automaticamente a activo

	// notificacion vencer poliza rc rosa 5 dias
	function cronNotificarPoliza() {
		$sql = "select
					p.idpostulante, p.apellidopaterno, p.apellidomaterno, p.nombre
					from		dbpostulantes p
					where		DATE_SUB(p.vighastarc,INTERVAL 5 DAY) = CURDATE()";
		$res = $this->query($sql,0);

		while ($row = mysql_fetch_array($res)) {
			$destinatario = 'rlinares@asesorescrea.com';
	      $asunto = 'Se esta por vencer la Poliza RC del asesor';

	      $cuerpo = '';
	      $cuerpo .= '<h4>Nombre Completo: '.$row['nombre'].' '.$row['apellidopaterno'].' '.$row['apellidomaterno'].'</h4><br>';
	      $cuerpo .= "Acceda por este link: <a href='asesorescrea.com/desarrollo/crm/potulantes/ver.php?id=".$row['idpostulante']."'>ACCEDER</a>";

	      $res = $this->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
		}
	}
	// notificacion vencer poliza rc ruth 1 mes
	function cronNotificarPolizaRuth() {
		$sql = "select
					p.idpostulante, p.apellidopaterno, p.apellidomaterno, p.nombre
					from		dbpostulantes p
					where		DATE_SUB(p.vighastarc,INTERVAL 1 MONTH) = CURDATE()";
		$res = $this->query($sql,0);

		while ($row = mysql_fetch_array($res)) {
			$destinatario = 'ruth-arana@asesorescrea.com';
	      $asunto = 'Se esta por vencer la Poliza RC del asesor';

	      $cuerpo = '';
	      $cuerpo .= '<h4>Nombre Completo: '.$row['nombre'].' '.$row['apellidopaterno'].' '.$row['apellidomaterno'].'</h4><br>';
	      $cuerpo .= "Acceda por este link: <a href='asesorescrea.com/desarrollo/crm/potulantes/ver.php?id=".$row['idpostulante']."'>ACCEDER</a>";

	      $res = $this->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
		}
	}

	// notificacion a vencer cedula seguros 3 meses al asesor
	function cronNotificarSeguro() {
		$sql = "select
					p.idpostulante, p.apellidopaterno, p.apellidomaterno, p.nombre, p.email
					from		dbpostulantes p
					where		DATE_SUB(p.vighastacedulaseguro,INTERVAL 3 MONTH) = CURDATE()";
		$res = $this->query($sql,0);

		while ($row = mysql_fetch_array($res)) {
			$destinatario = $row['email'];
	      $asunto = 'Se esta por vencer la Cedula del seguro';

	      $cuerpo = '';
	      $cuerpo .= '<h4>Nombre Completo: '.$row['nombre'].' '.$row['apellidopaterno'].' '.$row['apellidomaterno'].'</h4><br>';
	      $cuerpo .= "Acceda por este link: <a href='asesorescrea.com/desarrollo/crm/potulantes/ver.php?id=".$row['idpostulante']."'>ACCEDER</a>";

	      $res = $this->enviarEmail($destinatario,$asunto,$cuerpo, $referencia='');
		}
	}


	// modificar oportunidad por 15 dias, estado sin atender
	function cronModificarEstadoOportunidades() {
		$sql = "update		dboportunidades p
				set p.refestadooportunidad = 5
				where		DATE_ADD(p.fechacrea,INTERVAL 15 DAY) >= CURDATE() and p.refestadooportunidad = 1";
		$res = $this->query($sql,0);

		$sql2 = "update		dboportunidades p
					inner
					join		dbentrevistaoportunidades eo on eo.refoportunidades = p.idoportunidad
					set p.refestadooportunidad = 5
					where		DATE_ADD(eo.fechacrea,INTERVAL 15 DAY) >= CURDATE() and p.refestadooportunidad = 2";
		$res2 = $this->query($sql2,0);
	}


	/* PARA Estadoasociado */

	function insertarEstadoasociado($estadoasociado) {
		$sql = "insert into tbestadoasociado(idestadoasociado,estadoasociado)
		values ('','".$estadoasociado."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadoasociado($id,$estadoasociado) {
		$sql = "update tbestadoasociado
		set
		estadoasociado = '".$estadoasociado."'
		where idestadoasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadoasociado($id) {
		$sql = "delete from tbestadoasociado where idestadoasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadoasociado() {
		$sql = "select
		e.idestadoasociado,
		e.estadoasociado
		from tbestadoasociado e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadoasociadoPorId($id) {
		$sql = "select idestadoasociado,estadoasociado from tbestadoasociado where idestadoasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadoasociado*/

	function asignarOportunidades($id,$refusuarios) {
		$resO = $this->traerOportunidadesPorId($id);

		$sql = "insert into dboportunidades(idoportunidad,nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,refusuarios,refreferentes,refestadooportunidad,fechacrea,refmotivorechazos,observaciones,refestadogeneraloportunidad,reforigenreclutamiento)
		select '',nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,".$refusuarios.",refreferentes,1,'".date('Y-m-d H-i-s')."',0,observaciones,1,reforigenreclutamiento
		from dboportunidades
		where idoportunidad =".$id;
		$res = $this->query($sql,1);

		$resReasignar = $this->insertarReasignaciones($id,mysql_result($resO,0,'refusuarios'));
		return $res;
	}

	/* PARA Reasignaciones */

	function insertarReasignaciones($refoportunidades,$refusuarios) {
		$sql = "insert into dbreasignaciones(idreasignacion,refoportunidades,refusuarios,fechacreacion)
		values ('',".$refoportunidades.",".$refusuarios.",'".date('Y-m-d H:i:s')."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarReasignaciones($id,$refoportunidades,$refusuarios) {
		$sql = "update dbreasignaciones
		set
		refoportunidades = ".$refoportunidades.",refusuarios = ".$refusuarios."
		where idreasignacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarReasignaciones($id) {
		$sql = "delete from dbreasignaciones where idreasignacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerReasignaciones() {
		$sql = "select
		r.idreasignacion,
		r.refoportunidades,
		r.refusuarios,
		r.fechacreacion
		from dbreasignaciones r
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerReasignacionesPorId($id) {
		$sql = "select idreasignacion,refoportunidades,refusuarios,fechacreacion from dbreasignaciones where idreasignacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReasignacionesPorUsuarios($id) {
		$sql = "select idreasignacion,refoportunidades,refusuarios,fechacreacion from dbreasignaciones where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReasignacionesPorOportunidad($id) {
		$sql = "select idreasignacion,refoportunidades,refusuarios,fechacreacion from dbreasignaciones where refoportunidades =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOrigenreclutamiento() {
			$sql = "select idorigenreclutamiento, origenreclutamiento from tborigenreclutamiento";
			$res = $this->query($sql,0);
			return $res;
	}

	function traerOrigenreclutamientoPorId($id) {
		$sql = "select idorigenreclutamiento, origenreclutamiento from tborigenreclutamiento where idorigenreclutamiento = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerTipocita() {
		$sql = "select idtipocita, tipocita from tbtipocita";
		$res = $this->query($sql,0);
		return $res;
	}


	/* PARA Documentacioncotizaciones */

   function modificarCotizacionUnicaDocumentacionCot($id, $campo, $valor) {
		$sql = "update dbcotizaciones
		set
		".$campo." = '".$valor."'
		where idcotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarCotizacionUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbventas
		set
		".$campo." = '".$valor."'
		where refcotizaciones =".$id;
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

	function traerDocumentacionPorCotizacionDocumentacionCompleta($idcotizacion) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacioncotizacion,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacioncotizaciones da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refcotizaciones = ".$idcotizacion."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.reftipodocumentaciones in (3)

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

   function traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacion($idcotizacion,$tipodocumentacion,$notin='', $in='' ) {

      if ($notin != '') {
         $cadNotIn = ' and d.iddocumentacion not in ('.$notin.') ';
      } else {
         $cadNotIn = '';
      }



      if ($in != '') {
         $cadIn = ' and d.iddocumentacion in ('.$in.') ';
      } else {
         $cadIn = '';
      }

		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacioncotizacion,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
                   d.carpeta
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacioncotizaciones da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refcotizaciones = ".$idcotizacion."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.reftipodocumentaciones in (".$tipodocumentacion.") and refprocesocotizacion = 1
                     and d.activo='1' ".$cadNotIn.$cadIn."
					order by d.obligatoria, d.orden";

		$res = $this->query($sql,0);
 		return $res;
	}

   function traerDocumentacionPorCotizacionDocumentacionCompletaPorTipoDocumentacionE($idcotizacion,$tipodocumentacion) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacioncotizacion,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
                   d.carpeta
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacioncotizaciones da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refcotizaciones = ".$idcotizacion."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.reftipodocumentaciones in (".$tipodocumentacion.") and d.activo = '1' and refprocesocotizacion = 2

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacioncotizaciones($refcotizaciones,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacioncotizaciones(iddocumentacioncotizacion,refcotizaciones,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refcotizaciones.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacioncotizaciones($id,$refcotizaciones,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechamodi,$usuariomodi) {
		$sql = "update dbdocumentacioncotizaciones
		set
		refcotizaciones = ".$refcotizaciones.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."'
		where iddocumentacioncotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function aceptarCotizacionInbursa($idcotizacion, $id) {
      $sqlC = "update dbdocumentacioncotizaciones set refestadodocumentaciones = 1 where refdocumentaciones in (82,83,84,85,86) and refcotizaciones =".$idcotizacion;

      $resC = $this->query($sqlC,0);

      $sql = "update dbdocumentacioncotizaciones set refestadodocumentaciones = 5 where refdocumentaciones in (82,83,84,85,86) and iddocumentacioncotizacion =".$id;

      $res = $this->query($sql,0);

      return $res;
   }

	function modificarEstadoDocumentacioncotizaciones($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacioncotizaciones
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacioncotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionCotizacionesPorDocumentacion($iddocumentacion,$idcotizacion, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacioncotizaciones
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refcotizaciones =".$idcotizacion;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacioncotizaciones($id) {
		$sql = "delete from dbdocumentacioncotizaciones where iddocumentacioncotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacioncotizacionesPorCotizacionDocumentacion($idcotizacion,$iddocumentacion) {
		$sql = "delete from dbdocumentacioncotizaciones where refcotizaciones =".$idcotizacion." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacioncotizacionesPorCotizacionDocumentacionEspecifico($idcotizacion,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacioncotizaciones where refcotizaciones =".$idcotizacion =" and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionCotizacion($idcotizacion,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorCotizacionDocumentacion($idcotizacion,$iddocumentacion);

		$resDocumentacion = $this->traerDocumentacionesPorId($iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
				$archivos = '../archivos/cotizaciones/'.$idcotizacion.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacioncotizaciones(mysql_result($resFoto,0,'iddocumentacioncotizacion'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacioncotizaciones() {
		$sql = "select
		d.iddocumentacioncotizacion,
		d.refcotizaciones,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacioncotizaciones d
		inner join dbcotizaciones ase ON ase.idcotizacion = d.refcotizaciones
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacioncotizacionesPorId($id) {
		$sql = "select iddocumentacioncotizacion,refcotizaciones,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacioncotizaciones where iddocumentacioncotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorCotizacionDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacioncotizacion,da.refcotizaciones,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacioncotizaciones da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refcotizaciones =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerDocumentacioncotizacionesPorIdCompleto($id) {
		$sql = "select
      dc.iddocumentacioncotizacion,dc.refcotizaciones,dc.refdocumentaciones,
      dc.archivo,dc.type,dc.refestadodocumentaciones,
      dc.fechacrea,dc.fechamodi,dc.usuariocrea,dc.usuariomodi ,
      co.refasesores
      from dbdocumentacioncotizaciones dc
      inner join dbcotizaciones co on co.idcotizacion = dc.refcotizaciones
      where dc.iddocumentacioncotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerDocumentacioncotizacionesPorIdCompletoPorCotizacion($id) {
		$sql = "select
      dc.iddocumentacioncotizacion,dc.refcotizaciones,dc.refdocumentaciones,
      dc.archivo,dc.type,dc.refestadodocumentaciones,
      dc.fechacrea,dc.fechamodi,dc.usuariocrea,dc.usuariomodi ,
      co.refasesores, d.documentacion, d.carpeta
      from dbdocumentacioncotizaciones dc
      inner join dbcotizaciones co on co.idcotizacion = dc.refcotizaciones
      inner join dbdocumentaciones d on d.iddocumentacion = dc.refdocumentaciones and d.reftipodocumentaciones = 3 and d.refprocesocotizacion = 1
      where co.idcotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   // traigo todas las documentaciones menos las cotizaciones de inbursa
   function traerDocumentacioncotizacionesPorCotizacionCopia($id) {
		$sql = "select
      dc.iddocumentacioncotizacion,
      dc.archivo,dc.refestadodocumentaciones,d.carpeta, dc.type, dc.refdocumentaciones
      from dbdocumentacioncotizaciones dc
      inner join dbcotizaciones co on co.idcotizacion = dc.refcotizaciones
      inner join dbdocumentaciones d on d.iddocumentacion = dc.refdocumentaciones
      where co.idcotizacion =".$id." and d.iddocumentacion not in (82,83,84,85,86)";
		$res = $this->query($sql,0);
		return $res;
	}


	/* fin para documentaciones de asociados temporales */


	/* PARA Asociados temporales */

	function insertarAsociadostemporales($refusuarios,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$nombredespacho,$refestadoasociado,$refoportunidades,$refpostulantes) {
		$sql = "insert into dbasociadostemporales(idasociadotemporal,refusuarios,apellidopaterno,apellidomaterno,nombre,ine,email,fechanacimiento,telefonomovil,telefonotrabajo,refbancos,claveinterbancaria,domicilio,nombredespacho,refestadoasociado,refoportunidades,refpostulantes)
		values ('',".$refusuarios.",'".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$ine."','".$email."','".$fechanacimiento."','".$telefonomovil."','".$telefonotrabajo."',".$refbancos.",'".$claveinterbancaria."','".$domicilio."','".$nombredespacho."',".$refestadoasociado.",".($refoportunidades == '' ? 0 : $refoportunidades).",".($refpostulantes == '' ? 0 : $refpostulantes).")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAsociadostemporales($id,$refusuarios,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$nombredespacho,$refestadoasociado,$refoportunidades,$refpostulantes) {
		$sql = "update dbasociadostemporales
		set
		refusuarios = ".$refusuarios.",apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',ine = '".$ine."',email = '".$email."',fechanacimiento = '".$fechanacimiento."',telefonomovil = '".$telefonomovil."',telefonotrabajo = '".$telefonotrabajo."',refbancos = ".$refbancos.",claveinterbancaria = '".$claveinterbancaria."',domicilio = '".$domicilio."',nombredespacho = '".$nombredespacho."',refestadoasociado = ".$refestadoasociado.",refoportunidades = ".($refoportunidades == '' ? 0 : $refoportunidades).",refpostulantes = ".($refpostulantes == '' ? 0 : $refpostulantes)." where idasociadotemporal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarAsociadostemporales($id) {
		$sql = "delete from dbasociadostemporales where idasociadotemporal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsociadostemporalesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where (a.apellidopaterno like '%".$busqueda."%' or a.apellidomaterno like '%".$busqueda."%' or p.nombre like '%".$busqueda."%' or p.email like '%".$busqueda."%' or p.ine like '%".$busqueda."%')";
		}


		$sql = "select
		a.idasociadotemporal,
		a.apellidopaterno,
		a.apellidomaterno,
		a.nombre,
		a.ine,
		a.email,
		a.fechanacimiento,
		a.telefonomovil,
		a.telefonotrabajo,
		a.refbancos,
		a.claveinterbancaria,
		a.domicilio,
		a.refusuarios,
		a.nombredespacho,
		a.refestadoasociado
		from dbasociadostemporales a
		inner join dbusuarios usu ON usu.idusuario = a.refusuarios
		inner join tbbancos ban ON ban.idbanco = a.refbancos
		".$where."
		ORDER BY ".$colSort." ".$colSortDir."
		limit ".$start.",".$length;

		$res = $this->query($sql,0);
		return $res;
	}

	function traerAsociadostemporales() {
		$sql = "select
		a.idasociadotemporal,
		a.refusuarios,
		a.apellidopaterno,
		a.apellidomaterno,
		a.nombre,
		a.ine,
		a.email,
		a.fechanacimiento,
		a.telefonomovil,
		a.telefonotrabajo,
		a.refbancos,
		a.claveinterbancaria,
		a.domicilio,
		a.nombredespacho,
		a.refestadoasociado,
		a.refoportunidades,
		a.refpostulantes
		from dbasociadostemporales a
		inner join dbusuarios usu ON usu.idusuario = a.refusuarios
		inner join tbbancos ban ON ban.idbanco = a.refbancos
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsociadostemporalesPorId($id) {
		$sql = "select idasociadotemporal,refusuarios,apellidopaterno,apellidomaterno,nombre,ine,email,fechanacimiento,telefonomovil,telefonotrabajo,refbancos,claveinterbancaria,domicilio,nombredespacho,refestadoasociado,refoportunidades,refpostulantes from dbasociadostemporales where idasociadotemporal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerAsociadostemporalesPorUsuario($id) {
		$sql = "select idasociadotemporal,refusuarios,apellidopaterno,apellidomaterno,nombre,ine,email,fechanacimiento,telefonomovil,telefonotrabajo,refbancos,claveinterbancaria,domicilio,nombredespacho,refestadoasociado,refoportunidades,refpostulantes from dbasociadostemporales where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbasociados*/

	/**********  para la base de datos
	ALTER TABLE `u115752684_asesores`.`dbpostulantes`
	ADD COLUMN `razonsocial` VARCHAR(150) NULL AFTER `observaciones`;


	*/

	/* PARA Productos */



   function insertarProductos($producto,$prima,$reftipoproductorama,$reftipodocumentaciones,$puntosporventa,$puntosporpesopagado,$activo,$refcuestionarios,$puntosporventarenovado,$puntosporpesopagadorenovado,$reftipopersonas,$precio,$detalle,$ventaenlinea,$cotizaenlinea,$beneficiario,$asegurado,$reftipofirma,$reftipoemision,$esdomiciliado,$consolicitud,$leyendabeneficiario,$refgestion=11) {
      $sql = "insert into tbproductos(idproducto,producto,prima,reftipoproductorama,reftipodocumentaciones,activo,puntosporventa,puntosporpesopagado,refcuestionarios,puntosporventarenovado,puntosporpesopagadorenovado,reftipopersonas,precio,detalle,ventaenlinea,cotizaenlinea,beneficiario,asegurado,reftipofirma,reftipoemision,esdomiciliado,consolicitud,leyendabeneficiario,refgestion)
      values ('','".$producto."','".$prima."',".$reftipoproductorama.",".$reftipodocumentaciones.",'".$activo."',".$puntosporventa.",".$puntosporpesopagado.",".$refcuestionarios.",".$puntosporventarenovado.",".$puntosporpesopagadorenovado.",".$reftipopersonas.",".$precio.",'".$detalle."','".$ventaenlinea."','".$cotizaenlinea."','".$beneficiario."','".$asegurado."',".$reftipofirma.",".$reftipoemision.",'".$esdomiciliado."','".$consolicitud."','".$leyendabeneficiario."',".$refgestion.")";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarProductos($id,$producto,$prima,$reftipoproductorama,$reftipodocumentaciones,$puntosporventa,$puntosporpesopagado,$activo,$refcuestionarios,$puntosporventarenovado,$puntosporpesopagadorenovado,$reftipopersonas,$precio,$detalle,$ventaenlinea,$cotizaenlinea,$beneficiario,$asegurado,$reftipofirma,$reftipoemision,$esdomiciliado,$consolicitud,$leyendabeneficiario,$refgestion) {
      $sql = "update tbproductos
      set
      producto = '".$producto."',prima = '".$prima."',reftipoproductorama = ".$reftipoproductorama.",reftipodocumentaciones = ".$reftipodocumentaciones.",activo = '".$activo."',puntosporventa = ".$puntosporventa.",puntosporpesopagado = ".$puntosporpesopagado.",refcuestionarios = ".$refcuestionarios.",puntosporventarenovado = ".$puntosporventarenovado.",puntosporpesopagadorenovado = ".$puntosporpesopagadorenovado.",reftipopersonas = ".$reftipopersonas.",precio = ".$precio.",detalle = '".$detalle."',ventaenlinea = '".$ventaenlinea."',cotizaenlinea = '".$cotizaenlinea."',beneficiario = '".$beneficiario."',asegurado = '".$asegurado."' ,reftipofirma = ".$reftipofirma." ,reftipoemision = ".$reftipoemision.",esdomiciliado = '".$esdomiciliado."',consolicitud = '".$consolicitud."',leyendabeneficiario = '".$leyendabeneficiario."',refgestion = ".$refgestion." where idproducto =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


	function eliminarProductos($id) {
		$sql = "update tbproductos set activo = '0' where idproducto =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerProductosajax($length, $start, $busqueda,$colSort,$colSortDir) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where p.producto like '%".$busqueda."%' or (case when p.prima = '1' then 'Si' else 'No' end) like '%".$busqueda."%' or td.tipodocumentacion like '%".$busqueda."%' or (case when p.activo = '1' then 'Si' else 'No' end) like '%".$busqueda."%'";
		}


		$sql = "select
		p.idproducto,
		p.producto,
		(case when p.prima = '1' then 'Si' else 'No' end) as prima,
      tp.tipoproductorama,
      td.tipodocumentacion,
      p.puntosporventa,
      p.puntosporpesopagado,
      tpp.tipopersona,
      (case when p.activo = '1' then 'Si' else 'No' end) as activo

		from tbproductos p
		inner join tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
      left join tbtipodocumentaciones td ON td.idtipodocumentacion = p.reftipodocumentaciones
      left join tbtipopersonas tpp on tpp.idtipopersona = p.reftipopersonas
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerProductos() {
		$sql = "select
		p.idproducto,
		p.producto,
		p.prima
		from tbproductos p
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerProductosPorTipo($reftipoproductorama,$reftipopersonas,$idasesor) {
		$sql = "SELECT
          r.idproducto,
          r.producto,
          r.prima,
          r.activo,
          r.reftipoproductorama,
          r.reftipoproducto
      FROM
          (SELECT
              p.idproducto,
                  p.producto,
                  p.prima,
                  p.activo,
                  p.reftipoproductorama,
                  tp.reftipoproducto
          FROM
              tbproductos p
          INNER JOIN tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
          INNER JOIN tbtipoproducto t ON t.idtipoproducto = tp.reftipoproducto
          INNER JOIN tbtipopersonas tpp ON tpp.idtipopersona = p.reftipopersonas
          INNER JOIN dbproductosexclusivos px ON px.refproductos = p.idproducto
              AND px.refasesores = ".$idasesor."
          WHERE
              tp.idtipoproductorama = ".$reftipoproductorama."
                  AND tpp.idtipopersona = ".$reftipopersonas."
         UNION ALL SELECT
              p.idproducto,
                  p.producto,
                  p.prima,
                  p.activo,
                  p.reftipoproductorama,
                  tp.reftipoproducto
          FROM
              tbproductos p
          INNER JOIN tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
          INNER JOIN tbtipoproducto t ON t.idtipoproducto = tp.reftipoproducto
          INNER JOIN tbtipopersonas tpp ON tpp.idtipopersona = p.reftipopersonas
          LEFT JOIN dbproductosexclusivos px ON px.refproductos = p.idproducto
              AND px.refasesores = ".$idasesor."
          WHERE
              tp.idtipoproductorama = ".$reftipoproductorama."
                  AND tpp.idtipopersona = ".$reftipopersonas."
                  AND px.idproductoexclusivo IS NULL) AS r
		order by r.producto";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerProductosPorIdCompleta($id) {
		$sql = "select
		p.idproducto,
		p.producto,
		p.prima,
      p.activo,
      p.reftipoproductorama,
      tp.reftipoproducto,
      p.reftipodocumentaciones,
      p.refcuestionarios,
      p.reftipopersonas,
      p.precio,p.detalle,p.ventaenlinea,p.cotizaenlinea,p.beneficiario,p.asegurado,p.reftipofirma,
      p.reftipoemision,
      p.esdomiciliado,
      p.consolicitud,
      p.leyendabeneficiario,
      p.refgestion
		from tbproductos p
		inner join tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
      inner join tbtipoproducto t on t.idtipoproducto = tp.reftipoproducto
      left join tbtipopersonas tpp ON tpp.idtipopersona = p.reftipoproductorama
		where p.idproducto = ".$id."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerProductosPorNombreCompleta($nombre) {
		$sql = "select
		p.idproducto,
		p.producto,
		p.prima,
      p.activo,
      p.reftipoproductorama,
      tp.reftipoproducto,
      p.reftipodocumentaciones,
      p.refcuestionarios,
      p.reftipopersonas,
      p.precio,p.detalle,p.ventaenlinea,p.cotizaenlinea,p.beneficiario,p.asegurado,p.reftipofirma,
      p.reftipoemision,
      p.esdomiciliado,
      p.consolicitud,
      p.leyendabeneficiario,
      p.refgestion
		from tbproductos p
		inner join tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
      inner join tbtipoproducto t on t.idtipoproducto = tp.reftipoproducto
      left join tbtipopersonas tpp ON tpp.idtipopersona = p.reftipoproductorama
		where p.producto like '%".$nombre."%' and p.activo = '1'
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerProductosPorIdCompletaTipo($tipo) {
		$sql = "select
		p.idproducto,
		p.producto,
		p.prima,
      p.activo,
      p.reftipoproductorama,
      tp.reftipoproducto,
      p.reftipodocumentaciones,
      p.refcuestionarios,
      p.reftipopersonas,
      p.precio,p.detalle,p.ventaenlinea,p.cotizaenlinea,p.beneficiario,p.asegurado,p.reftipofirma,
      p.reftipoemision,
      p.esdomiciliado,
      p.consolicitud,
      p.leyendabeneficiario,
      p.refgestion
		from tbproductos p
		inner join tbtipoproductorama tp ON tp.idtipoproductorama = p.reftipoproductorama
      inner join tbtipoproducto t on t.idtipoproducto = tp.reftipoproducto
      left join tbtipopersonas tpp ON tpp.idtipopersona = p.reftipoproductorama
		where tp.reftipoproducto = ".$tipo."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerProductosPorId($id) {
      $sql = "select idproducto,producto,prima,reftipoproductorama,reftipodocumentaciones,activo,
      puntosporventa,puntosporpesopagado,refcuestionarios,puntosporventarenovado,puntosporpesopagadorenovado,reftipopersonas,precio,detalle,ventaenlinea,cotizaenlinea,beneficiario,asegurado,reftipofirma, reftipoemision,esdomiciliado,consolicitud,leyendabeneficiario, refgestion
      from tbproductos where idproducto =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


	/* Fin */
	/* /* Fin de la Tabla: tbproductos*/

   /* PARA Documentacionclientes */

	function modificarFamiliarUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbasegurados
		set
		".$campo." = '".$valor."'
		where idasegurado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorFamiliarDocumentacionCompleta($idfamiliar) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionfamiliar,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
                   coalesce(cli.emisioncomprobantedomicilio,'') as emisioncomprobantedomicilio,
                   coalesce(cli.emisionrfc,'') as emisionrfc,
                   coalesce(cli.vencimientoine,'') as vencimientoine
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionfamiliares da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refasegurados = ".$idfamiliar."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
                     left JOIN
                  dbasegurados cli on cli.idasegurado = da.refasegurados
					where d.iddocumentacion in (3,4,7,10,29)

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

   function traerDocumentacionPorFamiliarDocumentacionCompletaIn($idfamiliar,$in) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionfamiliar,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
                   coalesce(cli.emisioncomprobantedomicilio,'') as emisioncomprobantedomicilio,
                   coalesce(cli.emisionrfc,'') as emisionrfc,
                   coalesce(cli.vencimientoine,'') as vencimientoine
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionfamiliares da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refasegurados = ".$idfamiliar."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
                     left JOIN
                  dbasegurados cli on cli.idasegurado = da.refasegurados
					where d.iddocumentacion in (".$in.")

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionfamiliares($refasegurados,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionfamiliares(iddocumentacionfamiliar,refasegurados,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refasegurados.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionfamiliares($id,$refasegurados,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbdocumentacionfamiliares
		set
		refasegurados = ".$refasegurados.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionfamiliar =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionFamiliares($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionfamiliares
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionfamiliar =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionFamiliaresPorDocumentacion($iddocumentacion,$idfamiliar, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionfamiliares
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refasegurados =".$idfamiliar;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionfamiliares($id) {
		$sql = "delete from dbdocumentacionfamiliares where iddocumentacionfamiliar =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionfamiliaresPorFamiliarDocumentacion($idfamiliar,$iddocumentacion) {
		$sql = "delete from dbdocumentacionfamiliares where refasegurados =".$idfamiliar." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionfamiliaresPorFamiliarDocumentacionEspecifico($idfamiliar,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionfamiliares where refasegurados =".$idfamiliar." and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionFamiliar($idfamiliar,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorFamiliarDocumentacion($idfamiliar,$iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
            switch ($iddocumentacion) {
               case 3:
                  $archivos = '../archivos/familiares/'.$idfamiliar.'/inef/';
               break;
               case 4:
                  $archivos = '../archivos/familiares/'.$idfamiliar.'/ined/';
               break;
               case 7:
                  $archivos = '../archivos/familiares/'.$idfamiliar.'/rfc/';
               break;
					case 10:
                  $archivos = '../archivos/familiares/'.$idfamiliar.'/comprobantedomicilio/';
               break;
					case 29:
                  $archivos = '../archivos/familiares/'.$idfamiliar.'/mercantil/';
               break;

            }

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionfamiliares(mysql_result($resFoto,0,'iddocumentacionfamiliar'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionfamiliares() {
		$sql = "select
		d.iddocumentacionfamiliar,
		d.refasegurados,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionfamiliares d
		inner join dbasegurados cli ON cli.idasegurado = d.refasegurados
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionfamiliaresPorId($id) {
		$sql = "select iddocumentacionfamiliar,refasegurados,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionfamiliares where iddocumentacionfamiliar =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorFamiliarDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionfamiliar,da.refasegurados,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionfamiliares da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasegurados =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorFamiliar($id) {
		$sql = "select
		da.iddocumentacionfamiliar,da.refasegurados,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, dd.carpeta
		from dbdocumentacionfamiliares da
		inner join dbdocumentaciones dd on dd.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasegurados =".$id." and dd.orden is not null order by dd.orden,da.archivo";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorFamiliarDocumentacionEspecifica($id, $iddocumentacion, $archivo) {
		$sql = "select
		da.iddocumentacionfamiliar,da.refasegurados,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color
		from dbdocumentacionfamiliares da
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasegurados =".$id." and da.refdocumentaciones = ".$iddocumentacion." and da.archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	/* fin para documentaciones de familiares que son la tabla asegurados */


	/* PARA Documentacionclientes */

	function modificarClienteUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbclientes
		set
		".$campo." = '".$valor."'
		where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorClienteDocumentacionCompleta($idcliente) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacioncliente,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
                   coalesce(cli.emisioncomprobantedomicilio,'') as emisioncomprobantedomicilio,
                   coalesce(cli.emisionrfc,'') as emisionrfc,
                   coalesce(cli.vencimientoine,'') as vencimientoine
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionclientes da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refclientes = ".$idcliente."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
                     left JOIN
                  dbclientes cli on cli.idcliente = da.refclientes
					where d.iddocumentacion in (3,4,7,10,29)

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

   function traerDocumentacionPorClienteDocumentacionCompletaIn($idcliente,$in) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacioncliente,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
                   coalesce(cli.emisioncomprobantedomicilio,'') as emisioncomprobantedomicilio,
                   coalesce(cli.emisionrfc,'') as emisionrfc,
                   coalesce(cli.vencimientoine,'') as vencimientoine,
                   d.carpeta
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionclientes da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refclientes = ".$idcliente."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
                     left JOIN
                  dbclientes cli on cli.idcliente = da.refclientes
					where d.iddocumentacion in (".$in.")

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionclientes($refclientes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionclientes(iddocumentacioncliente,refclientes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refclientes.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionclientes($id,$refclientes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbdocumentacionclientes
		set
		refclientes = ".$refclientes.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionClientes($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionclientes
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacioncliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionClientesPorDocumentacion($iddocumentacion,$idasociado, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionclientes
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refclientes =".$idasociado;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionclientes($id) {
		$sql = "delete from dbdocumentacionclientes where iddocumentacioncliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresPorClienteDocumentacion($idcliente,$iddocumentacion) {
		$sql = "delete from dbdocumentacionclientes where refclientes =".$idcliente." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresPorClienteDocumentacionEspecifico($idcliente,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionclientes where refclientes =".$idcliente." and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionCliente($idcliente,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorClienteDocumentacion($idcliente,$iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
            switch ($iddocumentacion) {
               case 3:
                  $archivos = '../archivos/clientes/'.$idcliente.'/inef/';
               break;
               case 4:
                  $archivos = '../archivos/clientes/'.$idcliente.'/ined/';
               break;
               case 7:
                  $archivos = '../archivos/clientes/'.$idcliente.'/rfc/';
               break;
					case 10:
                  $archivos = '../archivos/clientes/'.$idcliente.'/comprobantedomicilio/';
               break;
					case 29:
                  $archivos = '../archivos/clientes/'.$idcliente.'/mercantil/';
               break;

            }

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionclientes(mysql_result($resFoto,0,'iddocumentacioncliente'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionclientes() {
		$sql = "select
		d.iddocumentacioncliente,
		d.refclientes,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionclientes d
		inner join dbclientes cli ON cli.idcliente = d.refclientes
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionclientesPorId($id) {
		$sql = "select iddocumentacioncliente,refclientes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionclientes where iddocumentacioncliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorClienteDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacioncliente,da.refclientes,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionclientes da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refclientes =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPostulanteDocumentacionCliente($id) {
		$sql = "select
		da.iddocumentacioncliente,da.refclientes,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, dd.carpeta
		from dbdocumentacionclientes da
		inner join dbdocumentaciones dd on dd.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refclientes =".$id." and dd.orden is not null order by dd.orden,da.archivo";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorClienteDocumentacionEspecifica($id, $iddocumentacion, $archivo) {
		$sql = "select
		da.iddocumentacioncliente,da.refclientes,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color
		from dbdocumentacionclientes da
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refclientes =".$id." and da.refdocumentaciones = ".$iddocumentacion." and da.archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	/* fin para documentaciones de asociados */

	/* PARA Cotizaciones */

   function generaFolioInternoCotizaciones() {
		$sql = "select max(idcotizacion) from dbcotizaciones";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0) + 1;
			return 'FOL'.substr('0000000'.$idcliente,-7);
		}

		return 'COT0000001';
	}

	function generaFolioInterno() {
		$sql = "select max(idventa) from dbventas";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0) + 1;
			return 'VEN'.substr('0000000'.$idcliente,-7);
		}

		return 'VEN0000001';
	}

   function generarVersionCotizacion($idcotizacion) {

      if ($idcotizacion == '') {
         return 1;
      } else {
         $sql = "select max(version) as version from dbcotizaciones where idcotizacion =".$idcotizacion;

         $res = $this->query($sql,0);

         if (mysql_num_rows($res)>0) {
            return mysql_result($res,0,'version') + 1;
         } else {
            return 1;
         }
      }
   }

   function ajustarCotizacion($idcotizacion, $fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
      $version = $this->generarVersionCotizacion($idcotizacion);
      $folio = $this->generaFolioInternoCotizaciones();

      $fechacrea = date('Y-m-d H:i:s');
      $fechamodi = date('Y-m-d H:i:s');

      $sql = "INSERT INTO `dbcotizaciones`
                  (`idcotizacion`,`refclientes`,
                  `refproductos`,`refasesores`,
                  `refasociados`,`refestadocotizaciones`,
                  `cobertura`,`reasegurodirecto`,
                  `tiponegocio`,`presentacotizacion`,
                  `fechapropuesta`,`fecharenovacion`,
                  `fechaemitido`,`fechacrea`,
                  `fechamodi`,`usuariocrea`,
                  `usuariomodi`,`refusuarios`,
                  `fechavencimiento`,`coberturaactual`,
                  `existeprimaobjetivo`,`primaobjetivo`,
                  `tieneasegurado`,`refasegurados`,
                  `refbeneficiarios`,`folio`,
                  `version`,`refcotizaciones`,
                  `refestados`,`primaneta`,
                  `primatotal`,`bitacoracrea`,
                  `bitacorainbursa`,`bitacoraagente`,
                  `observaciones`)
                  SELECT '',
                      `refclientes`,
                      `refproductos`,
                      `refasesores`,
                      `refasociados`,
                      1,
                      `cobertura`,
                      `reasegurodirecto`,
                      `tiponegocio`,
                      `presentacotizacion`,
                      NULL,
                      `fecharenovacion`,
                      `fechaemitido`,
                      '".$fechacrea."',
                      '".$fechamodi."',
                      '".$usuariocrea."',
                      '".$usuariomodi."',
                      `refusuarios`,
                      `fechavencimiento`,
                      `coberturaactual`,
                      `existeprimaobjetivo`,
                      `primaobjetivo`,
                      `tieneasegurado`,
                      `refasegurados`,
                      `refbeneficiarios`,
                      '".$folio."',
                      ".$version.",
                      ".$idcotizacion.",
                      1,
                      `primaneta`,
                      `primatotal`,
                      `bitacoracrea`,
                      `bitacorainbursa`,
                      `bitacoraagente`,
                      `observaciones`
                  FROM `dbcotizaciones` where idcotizacion = ".$idcotizacion;

      $res = $this->query($sql,1);



      if ((integer)$res > 0) {

         //trazabilidad 1
         $resTZ = $this->insertarTrazabilidad(12,$res,$fechacrea,1,$usuariocrea,0,0,0,'Se genero una cotización nueva a partir de un ajuste','');

         if (!file_exists('../archivos/cotizaciones/'.$res)) {
   			mkdir('../archivos/cotizaciones/'.$res, 0777);
   		}

         // necesito recuperar los archivos
         $resArchivos = $this->traerDocumentacioncotizacionesPorCotizacionCopia($idcotizacion);

         while ($rowAr = mysql_fetch_array($resArchivos)) {

            $dir_origen = '../archivos/cotizaciones/'.$idcotizacion.'/'.$rowAr['carpeta'].'/';
            $dir_destino = '../archivos/cotizaciones/'.$res.'/'.$rowAr['carpeta'].'/';

            if (!file_exists('../archivos/cotizaciones/'.$res.'/')) {
      			mkdir('../archivos/cotizaciones/'.$res.'/', 0777);
      		}

            if (!file_exists($dir_destino)) {
      			mkdir($dir_destino, 0777);
      		}

            $resCopy = copy($dir_origen.$rowAr['archivo'] , $dir_destino.$rowAr['archivo']);

            //insert
            if ($resCopy) {
               $resInsertarArchivo = $this->insertarDocumentacioncotizaciones($res,$rowAr['refdocumentaciones'],$rowAr['archivo'],$rowAr['type'],$rowAr['refestadodocumentaciones'],$fechacrea,$fechamodi,$usuariocrea,$usuariomodi);
            }

         }

         //modifico la cotizacion anterior a historial
         $resMod = $this->modificarCotizacionesPorCampo($idcotizacion,'refestados',4,$usuariomodi);

         //modifico la cotizacion anterior a historial
         $resMod = $this->modificarCotizacionesPorCampo($idcotizacion,'refestadocotizaciones',10,$usuariomodi);


         //trazabilidad de finalidad de la cotizacion en ajuste
         $resTZ = $this->insertarTrazabilidad(12,$idcotizacion,$fechacrea,15,$usuariocrea,0,0,0,'Cotización finalizada en ajuste','');


         $resV['error'] = false;
         $resV['mensaje'] = 'Se genero correctamente';

      } else {

         $resV['error'] = true;
         $resV['mensaje'] = 'No se pudo insertar el registro';
      }

      return $resV;

   }


	function insertarCotizaciones($refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$existeprimaobjetivo,$primaobjetivo,$primaobjetivototal,$reftipomoneda) {
		$sql = "insert into dbcotizaciones(idcotizacion,refclientes,refproductos,refasesores,refasociados,refestadocotizaciones,cobertura,reasegurodirecto,tiponegocio,presentacotizacion,fechapropuesta,fecharenovacion,fechaemitido,fechacrea,fechamodi,usuariocrea,usuariomodi,refusuarios,observaciones,fechavencimiento,coberturaactual,existeprimaobjetivo,primaobjetivo,folio,primaobjetivototal, reftipomoneda)
		values ('',".$refclientes.",".$refproductos.",".$refasesores.",".$refasociados.",".$refestadocotizaciones.",'".$cobertura."','".$reasegurodirecto."','".$tiponegocio."','".$presentacotizacion."',".($fechapropuesta == '' ? 'NULL' : "'".$fechapropuesta ."'").",".($fecharenovacion == '' ? 'NULL' : "'".$fecharenovacion ."'").",".($fechaemitido == '' ? 'NULL' : "'".$fechaemitido ."'").",'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$usuariocrea."','".$usuariomodi."',".$refusuarios.",'".$observaciones."','".$fechavencimiento."','".$coberturaactual."','".$existeprimaobjetivo."',".$primaobjetivo.",'".$this->generaFolioInternoCotizaciones()."',".$primaobjetivototal.",".$reftipomoneda.")";

		$res = $this->query($sql,1);
		return $res;
	}

   function insertarCotizacionesSQL($refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$existeprimaobjetivo,$primaobjetivo,$primaobjetivototal,$reftipomoneda) {
		$sql = "insert into dbcotizaciones(idcotizacion,refclientes,refproductos,refasesores,refasociados,refestadocotizaciones,cobertura,reasegurodirecto,tiponegocio,presentacotizacion,fechapropuesta,fecharenovacion,fechaemitido,fechacrea,fechamodi,usuariocrea,usuariomodi,refusuarios,observaciones,fechavencimiento,coberturaactual,existeprimaobjetivo,primaobjetivo,primaobjetivototal,reftipomoneda)
		values ('',".$refclientes.",".$refproductos.",".$refasesores.",".$refasociados.",".$refestadocotizaciones.",'".$cobertura."','".$reasegurodirecto."','".$tiponegocio."','".$presentacotizacion."',".($fechapropuesta == '' ? 'NULL' : "'".$fechapropuesta ."'").",".($fecharenovacion == '' ? 'NULL' : "'".$fecharenovacion ."'").",".($fechaemitido == '' ? 'NULL' : "'".$fechaemitido ."'").",'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$usuariocrea."','".$usuariomodi."',".$refusuarios.",'".$observaciones."','".$fechavencimiento."','".$coberturaactual."','".$existeprimaobjetivo."',".$primaobjetivo.",".$primaobjetivototal.",".$reftipomoneda.")";

		return $sql;
	}

	function modificarCotizaciones($id,$refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$cobertura,$reasegurodirecto,$tiponegocio,$presentacotizacion,$fechapropuesta,$fecharenovacion,$fechaemitido,$fechamodi,$usuariomodi,$refusuarios,$observaciones,$fechavencimiento,$coberturaactual,$bitacoracrea,$bitacorainbursa,$bitacoraagente,$existeprimaobjetivo,$primaobjetivo,$primaobjetivototal,$reftipomoneda) {
		$sql = "update dbcotizaciones
		set
		refclientes = ".$refclientes.",refproductos = ".$refproductos.",refasesores = ".$refasesores.",refasociados = ".$refasociados.",refestadocotizaciones = ".$refestadocotizaciones.",cobertura = '".$cobertura."',reasegurodirecto = '".$reasegurodirecto."',tiponegocio = '".$tiponegocio."',presentacotizacion = '".$presentacotizacion."',fechapropuesta = ".($fechapropuesta == '' ? 'NULL' : "'".$fechapropuesta ."'").",fecharenovacion = ".($fecharenovacion == '' ? 'NULL' : "'".$fecharenovacion ."'").",fechaemitido = ".($fechaemitido == '' ? 'NULL' : "'".$fechaemitido ."'").",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',refusuarios = ".$refusuarios.",observaciones = '".$observaciones."',fechavencimiento = '".$fechavencimiento."',coberturaactual = '".$coberturaactual."',bitacoracrea = '".$bitacoracrea."',bitacorainbursa = '".$bitacorainbursa."',bitacoraagente = '".$bitacoraagente."',existeprimaobjetivo = '".$existeprimaobjetivo."',primaobjetivo = ".$primaobjetivo.",primaobjetivototal = ".$primaobjetivototal.",reftipomoneda = ".$reftipomoneda." where idcotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function modificarCotizacionesPorCampo($id,$campo,$valor,$usuariomodi) {
		$sql = "update dbcotizaciones
		set
		".$campo." = '".$valor."',
		fechamodi = '".date('Y-m-d H:i:s')."',
		usuariomodi = '".$usuariomodi."' where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function modificarCotizacionesRechazar($id,$observaciones,$usuariomodi) {
		$sql = "update dbcotizaciones
		set
		refestadocotizaciones = 4,
		observaciones = '".$observaciones."',
		fechamodi = '".date('Y-m-d H:i:s')."',
		usuariomodi = '".$usuariomodi."' where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function modificarCotizacionesAsegurado($id,$tieneasegurado,$refasegurados) {
		$sql = "update dbcotizaciones
		set
		tieneasegurado = '".$tieneasegurado."',
		refasegurados = ".$refasegurados.",
		fechamodi = '".date('Y-m-d H:i:s')."'
		 where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function modificarCotizacionesBeneficiario($id,$refbeneficiarios) {
		$sql = "update dbcotizaciones
		set
		refbeneficiarios = ".$refbeneficiarios.",
		fechamodi = '".date('Y-m-d H:i:s')."'
		 where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function modificarEstadoCotizacionResultado($id, $idestado) {
      $sql = "update dbcotizaciones
		set
		refestados = ".$idestado.",
		fechamodi = '".date('Y-m-d H:i:s')."'
		 where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
   }


	function eliminarCotizaciones($id) {
		$sql = "delete from dbcotizaciones where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function traerCotizaciones() {
		$sql = "select
		c.idcotizacion,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.cobertura,
		c.reasegurodirecto,
		c.tiponegocio,
		c.presentacotizacion,
		c.fechapropuesta,
		c.fecharenovacion,
		c.fechaemitido,
		c.fechavencimiento,
		c.coberturaactual,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios,
		c.observaciones
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerCotizacionesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$whereEstado,$filtroNuevo='') {

      $cadRolPorRama = '';
      if ($_SESSION['idroll_sahilices'] == 20) {
         $cadRolPorRama = ' and tr.idtipoproductorama = 8 ';
      }
      if ($_SESSION['idroll_sahilices'] == 21) {
         $cadRolPorRama = ' and tr.idtipoproductorama = 7 ';
      }
      if ($_SESSION['idroll_sahilices'] == 22) {
         $cadRolPorRama = ' and tr.idtipoproductorama = 8 ';
      }

		$where = '';

      $cadFiltroNuevo = '';

      $whereSinVenta = '';

      switch ($filtroNuevo) {
         case 'enlinea':
            $cadFiltroNuevo = " inner join dblead le on le.refcotizaciones = c.idcotizacion and le.reforigencomercio = 7 ";
            $whereSinVenta = ' and v.idventa is null ';
         break;
         case 'poragente':
            $cadFiltroNuevo = " inner join dbusuarios ua on ua.idusuario = c.refusuarios and ua.refroles in (1,2,3,4,6,8,11,13,14,15,7) and c.refestadocotizaciones not in (10)";
            $whereSinVenta = ' and v.idventa is null ';
         break;
         case 'poroficina':
            $cadFiltroNuevo = " inner join dbusuarios ua on ua.idusuario = c.refusuarios and ua.refroles in (1,2,3,4,6,8,11,13,14,15) and c.refestadocotizaciones not in (10)";
            $whereSinVenta = ' and v.idventa is null ';
         break;


      }

      $whereSinVenta = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or c.folio like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " where ase.refusuarios = ".$responsableComercial." ";
	      }
		}


		$sql = "select
		c.idcotizacion,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		pro.producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
      c.fechacrea,
      est.estadocotizacion,
      c.folio,
      DATEDIFF(CURDATE(),c.fechacrea) as dias,
      (case when c.version > 0 then 'En Ajuste' else 'Nueva' end) as gestion,
      max(DATE_FORMAT(tz.fechacrea, '%d-%m-%Y %H:%i:%s')) as fechaevento
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
      inner join tbtipoproductorama tr on tr.idtipoproductorama = pro.reftipoproductorama ".$cadRolPorRama."
		inner join dbasesores ase ON ase.idasesor = c.refasesores
      ".$cadFiltroNuevo."
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
      left join tbeventos ee on ee.reftabla=16 and ee.idreferencia=c.refestadocotizaciones
      left join dbtrazabilidad tz on tz.refevento = ee.idevento and tz.idreferencia = c.idcotizacion and tz.reftabla=12
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones

		where ".$whereEstado.$where." ".$whereSinVenta."
      group by c.idcotizacion,
		cli.reftipopersonas,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,cli.razonsocial,
		pro.producto,
		ase.apellidopaterno, ase.apellidomaterno, ase.nombre,
		aso.apellidopaterno, aso.apellidomaterno, aso.nombre,
      c.fechacrea,
      est.estadocotizacion,
      c.folio,
      c.version
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerCotizacionesajaxPorUsuarioCliente($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or c.folio like '%".$busqueda."%')";
		}


		$sql = "select
		c.idcotizacion,
		pro.producto,
      c.fechacrea,
		est.estadocotizacion,
      c.folio,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechavencimiento,
		c.coberturaactual,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
      concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
      concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = cli.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		left join dbventas v on v.refcotizaciones = c.idcotizacion
		where ((v.idventa IS NULL or c.refestadocotizaciones IN (19,20,21,22,23)) and c.refestadocotizaciones in (1,19,20,21,22,23) and us.idusuario = ".$responsableComercial.") ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerCotizacionesajaxPorUsuario($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$whereEstado) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%')";
		}


		$sql = "select
		c.idcotizacion,
		concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		pro.producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		est.estadocotizacion,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechavencimiento,
		c.coberturaactual,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		left join dbventas v on v.refcotizaciones = c.idcotizacion
		where ".$whereEstado." and ase.refusuarios = ".$responsableComercial." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerCotizacionesajaxPorAsesor($length, $start, $busqueda,$colSort,$colSortDir,$idasesor,$whereEstado) {
		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%' or cli.razonsocial like '%".$busqueda."%')";
		}


		$sql = "select
		c.idcotizacion,
		(case when cli.reftipopersonas = '1' then concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) else cli.razonsocial end) as cliente,
		pro.producto,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
      c.fechacrea,
      est.estadocotizacion,
      c.folio,
      DATEDIFF(CURDATE(),c.fechacrea) as dias,
      (case when c.version > 0 then 'En Ajuste' else 'Nueva' end) as gestion,
      max(DATE_FORMAT(tz.fechacrea, '%d-%m-%Y %H:%i:%s')) as fechaevento
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		left join dbusuarios us ON us.idusuario = c.refusuarios
		left join dbasociados aso ON aso.idasociado = c.refasociados
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
      left join tbeventos ee on ee.reftabla=16 and ee.idreferencia=c.refestadocotizaciones
      left join dbtrazabilidad tz on tz.refevento = ee.idevento and tz.idreferencia = c.idcotizacion and tz.reftabla=12

		where ".$whereEstado." and ase.idasesor = ".$idasesor." ".$where."
      group by c.idcotizacion,
		cli.reftipopersonas,cli.apellidopaterno, cli.apellidomaterno, cli.nombre,cli.razonsocial,
		pro.producto,
		ase.apellidopaterno, ase.apellidomaterno, ase.nombre,
		aso.apellidopaterno, aso.apellidomaterno, aso.nombre,
      c.fechacrea,
      est.estadocotizacion,
      c.folio,
      c.version
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerCotizacionesPorUsuario($idusuario) {
		$sql = "select
		c.idcotizacion,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios,
		c.cobertura,
		c.reasegurodirecto,
		c.tiponegocio,
		c.presentacotizacion,
		c.fechapropuesta,
		c.fecharenovacion
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		inner join dbusuarios us ON us.idusuario = c.refusuarios
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		where ase.refusuarios = ".$idusuario."
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}

	function traerCotizacionesGrid($responsableComercial) {

		if ($responsableComercial != '') {
	      $roles = "where ase.idasesor = ".$responsableComercial."  ";
	   } else {
	      $roles = '';
	   }

		$sql = "select
		c.idcotizacion,
		c.refclientes,
		c.refproductos,
		c.refasesores,
		c.refasociados,
		c.refestadocotizaciones,
		c.observaciones,
		c.fechavencimiento,
		c.coberturaactual,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.refusuarios
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join tbtipopersonas ti ON ti.idtipopersona = cli.reftipopersonas
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		inner join dbusuarios us ON us.idusuario = c.refusuarios
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		".$roles."
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerCotizacionesPorId($id) {
		$sql = "select idcotizacion,refclientes,refproductos,refasesores,refasociados,refestadocotizaciones,observaciones,fechacrea,fechamodi,usuariocrea,usuariomodi,refusuarios,fechaemitido,fechavencimiento,coberturaactual,cobertura,reasegurodirecto,tiponegocio,presentacotizacion,fechapropuesta,fecharenovacion,bitacoracrea,bitacorainbursa,bitacoraagente,existeprimaobjetivo,primaobjetivo,folio,version,refcotizaciones,refestados,primaneta,primatotal,ot,articulo,primaobjetivototal,reftipomoneda from dbcotizaciones where idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function traerCotizacionesPorIdCompleto($id) {
		$sql = "select
   		c.idcotizacion,
   		concat( pro.producto) as producto,
   		concat('Cliente: ', cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,

   		concat('Asesor: ', ase.apellidopaterno, ' ', ase.nombre) as asesor,
         concat('Asociado: ', aso.apellidopaterno, ' ', aso.nombre) as asociado,
         concat( cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as clientesolo,
   		c.refclientes,c.refproductos,c.refasesores,c.refasociados,
   		c.refestadocotizaciones,c.observaciones,
   		c.fechacrea,c.fechamodi,c.usuariocrea,c.usuariomodi,c.refusuarios,c.fechaemitido,c.fechavencimiento,
   		c.coberturaactual,c.cobertura,c.reasegurodirecto,c.tiponegocio,
   		c.presentacotizacion,c.fechapropuesta,c.fecharenovacion,
	      c.bitacoracrea,c.bitacorainbursa,c.bitacoraagente,c.existeprimaobjetivo,c.primaobjetivo, pro.precio ,
	      c.tieneasegurado, c.refasegurados, c.refbeneficiarios, ec.estadocotizacion          ,c.folio,c.version,c.refcotizaciones, c.refestados, est.etapacotizacion as estado, 'bg-blue' as color,c.primaneta,c.primatotal,
         pro.reftipodocumentaciones, cli.telefonocelular, cli.email, ase.email as emailasesor,
         ase.claveasesor, cli.refusuarios as idusuariocliente, ase.refusuarios as idusuarioasesor,
         ase.envioalcliente, pro.consolicitud, c.ot, c.articulo,
         concat(ase.apellidopaterno, ' ', ase.nombre) as asesorsolo,
         pro.reftipoproductorama, c.primaobjetivototal, c.reftipomoneda
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		inner join tbproductos pro ON pro.idproducto = c.refproductos
      inner join tbestadocotizaciones ec on ec.idestadocotizacion = c.refestadocotizaciones
      left join dbasociados aso ON aso.idasociado = c.refasociados
      left join tbetapacotizacion est ON est.idetapacotizacion = c.refestados
		where c.idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function traerCotizacionesPorIdCompletoV($id) {
		$sql = "select
		v.idventa,
		concat('Producto: ', pro.producto) as producto,
		concat('Cliente: ', cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		concat('Asesor: ', ase.apellidopaterno, ' ', ase.nombre) as asesor,
		c.refclientes,c.refproductos,c.refasesores,c.refasociados,
		c.refestadocotizaciones,c.observaciones,
		c.fechacrea,c.fechamodi,c.usuariocrea,c.usuariomodi,c.refusuarios,c.fechaemitido,c.fechavencimiento,
		c.coberturaactual,c.cobertura,c.reasegurodirecto,c.tiponegocio,
		c.presentacotizacion,c.fechapropuesta,c.fecharenovacion,
      c.bitacoracrea,c.bitacorainbursa,c.bitacoraagente,c.existeprimaobjetivo,c.primaobjetivo, pro.precio ,
	  c.tieneasegurado, c.refasegurados,c.folio,c.version,c.refcotizaciones, c.refestados,
     c.primaneta,c.primatotal, pro.reftipodocumentaciones, ase.envioalcliente, c.ot, c.articulo, c.primaobjetivototal, c.reftipomoneda
		from dbcotizaciones c
		inner join dbclientes cli ON cli.idcliente = c.refclientes
		inner join dbasesores ase ON ase.idasesor = c.refasesores
		inner join tbproductos pro ON pro.idproducto = c.refproductos
		inner join dbventas v on v.refcotizaciones = c.idcotizacion
		where c.idcotizacion =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbcotizaciones*/

	/* PARA Estadocotizaciones */

	function insertarEstadocotizaciones($estadocotizacion) {
		$sql = "insert into tbestadocotizaciones(idestadocotizacion,estadocotizacion)
		values ('','".$estadocotizacion."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadocotizaciones($id,$estadocotizacion) {
		$sql = "update tbestadocotizaciones
		set
		estadocotizacion = '".$estadocotizacion."'
		where idestadocotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadocotizaciones($id) {
		$sql = "delete from tbestadocotizaciones where idestadocotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadocotizaciones() {
		$sql = "select
		e.idestadocotizacion,
		e.estadocotizacion,
		e.orden
		from tbestadocotizaciones e
		order by e.orden";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadocotizacionesPorId($id) {
		$sql = "select idestadocotizacion,estadocotizacion,
		orden,refetapacotizacion,finaliza,renueva,generaestado from tbestadocotizaciones where idestadocotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEstadocotizacionesPorIn($in) {
		$sql = "select
		e.idestadocotizacion,
		e.estadocotizacion,
		e.orden,
      e.refetapacotizacion,
      e.finaliza,
      e.renueva,
      e.generaestado
		from tbestadocotizaciones e
		where  idestadocotizacion in (".$in.")
		order by e.orden";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerEstadocotizacionPorEtapa($idetapa) {
      $sql = "select idestadocotizacion,estadocotizacion,
		orden,refetapacotizacion,finaliza,renueva,generaestado from tbestadocotizaciones where refetapacotizacion =".$idetapa;
		$res = $this->query($sql,0);
		return $res;
   }


	/* Fin */
	/* /* Fin de la Tabla: tbestadocotizaciones*/

	/* PARA Alertas */
/*
	function insertarAlertas($reftiposeguimientos,$motivo,$id,$fechacreacion,$refusuarios) {
		$sql = "insert into dbalertas(idalerta,reftiposeguimientos,motivo,id,fechacreacion,refusuarios)
		values ('',".$reftiposeguimientos.",'".$motivo."',".$id.",'".$fechacreacion."',".$refusuarios.")";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAlertas($idalerta,$reftiposeguimientos,$motivo,$id,$fechacreacion,$refusuarios) {
		$sql = "update dbalertas
		set
		reftiposeguimientos = ".$reftiposeguimientos.",motivo = '".$motivo."',id = ".$id.",fechacreacion = '".$fechacreacion."',refusuarios = ".$refusuarios."
		where idalerta =".$idalerta;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarAlertas($id) {
		$sql = "delete from dbalertas where idalerta =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAlertas() {
		$sql = "select
		a.idalerta,
		a.reftiposeguimientos,
		a.motivo,
		a.id,
		a.fechacreacion,
		a.refusuarios
		from dbalertas a
		inner join tbtiposeguimientos tip ON tip.idtiposeguimiento = a.reftiposeguimientos
		inner join dbusuarios u on u.idusuario = a.refusuarios
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}

	function traerAlertasPorUsuarios($idusuario) {
		$sql = "select
		a.idalerta,
		a.reftiposeguimientos,
		a.motivo,
		a.id,
		a.fechacreacion,
		a.refusuarios
		from dbalertas a
		inner join tbtiposeguimientos tip ON tip.idtiposeguimiento = a.reftiposeguimientos
		inner join dbusuarios u on u.idusuario = a.refusuarios
		where a.refusuarios = ".$refusuarios."
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}

	function traerAlertasCalendario($refgerentecomercial) {
		if ($refgerentecomercial == 0) {
			$where = '';
		} else {
			$where = 'where u.idusuario = '.$refgerentecomercial;
		}
		$sql = "select
		a.idalerta,
		a.reftiposeguimientos,
		concat('Visita de seguimiento asesor: ', ase.apellidopaterno,' ',ase.apellidomaterno,' ', ase.nombre) as description,
		concat('Visita de seguimiento, motivo: ', a.motivo) as title,
		a.id,
		a.fechacreacion as start,
		'#FF5733' as color,
		a.refusuarios,
		u.nombrecompleto
		from dbalertas a
		inner join tbtiposeguimientos tip ON tip.idtiposeguimiento = a.reftiposeguimientos
		inner join dbusuarios u on u.idusuario = a.refusuarios
		inner join dbasesores ase on ase.idasesor = a.id
		".$where."
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}

	function traerAlertasPorUsuariosCalendario($idusuario) {
		$sql = "select
		a.idalerta,
		a.reftiposeguimientos,
		concat('Visita de seguimiento asesor: ', ase.apellidopaterno,' ',ase.apellidomaterno,' ', ase.nombre) as description,
		concat('Visita de seguimiento, motivo: ', a.motivo) as title,
		'#FF5733' as color,
		a.id,
		a.fechacreacion as start,
		a.refusuarios,
		u.nombrecompleto
		from dbalertas a
		inner join tbtiposeguimientos tip ON tip.idtiposeguimiento = a.reftiposeguimientos
		inner join dbusuarios u on u.idusuario = a.refusuarios
		inner join dbasesores ase on ase.idasesor = a.id
		where a.refusuarios = ".$refusuarios."
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerAlertasPorId($id) {
		$sql = "select idalerta,reftiposeguimientos,motivo,id,fechacreacion from dbalertas where idalerta =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

*/
	/* Fin */
	/* /* Fin de la Tabla: dbalertas*/

	/* PARA Tiposeguimientos */

	function insertarTiposeguimientos($tiposeguimiento) {
		$sql = "insert into tbtiposeguimientos(idtiposeguimiento,tiposeguimiento)
		values ('','".$tiposeguimiento."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarTiposeguimientos($id,$tiposeguimiento) {
		$sql = "update tbtiposeguimientos
		set
		tiposeguimiento = '".$tiposeguimiento."'
		where idtiposeguimiento =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarTiposeguimientos($id) {
		$sql = "delete from tbtiposeguimientos where idtiposeguimiento =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function traerTiposeguimientos() {
		$sql = "select
		t.idtiposeguimiento,
		t.tiposeguimiento
		from tbtiposeguimientos t
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerTiposeguimientosPorId($id) {
		$sql = "select idtiposeguimiento,tiposeguimiento from tbtiposeguimientos where idtiposeguimiento =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbtiposeguimientos*/

	function traerTipopersonas() {
		$sql = "select
		t.idtipopersona,
		t.tipopersona
		from tbtipopersonas t
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerTipopersonasPorId($id) {
		$sql = "select idtipopersona,tipopersona from tbtipopersonas where idtipopersona =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	/* PARA Documentacionasociados */

	function modificarAsociadoUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbasociados
		set
		".$campo." = '".$valor."'
		where idasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorAsociadoDocumentacionCompleta($idasociado) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionasociado,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionasociados da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refasociados = ".$idasociado."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.iddocumentacion in (3,4,10,29)

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionasociados($refasociados,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionasociados(iddocumentacionasociado,refasociados,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refasociados.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionasociados($id,$refasociados,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbdocumentacionasociados
		set
		refasociados = ".$refasociados.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionAsociados($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionasociados
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionAsociadosPorDocumentacion($iddocumentacion,$idasociado, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionasociados
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refasociados =".$idasociado;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionasociados($id) {
		$sql = "delete from dbdocumentacionasociados where iddocumentacionasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresPorAsociadoDocumentacion($idasociado,$iddocumentacion) {
		$sql = "delete from dbdocumentacionasociados where refasociados =".$idasociado." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresPorAsociadoDocumentacionEspecifico($idasociado,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionasociados where refasociados =".$idasociado." and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionAsociado($idasociado,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorAsociadoDocumentacion($idasociado,$iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo

         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
            switch ($iddocumentacion) {
               case 3:
                  $archivos = '../archivos/asociados/'.$idasociado.'/inef/';
               break;
               case 4:
                  $archivos = '../archivos/asociados/'.$idasociado.'/ined/';
               break;
					case 10:
                  $archivos = '../archivos/asociados/'.$idasociado.'/comprobantedomicilio/';
               break;
					case 29:
                  $archivos = '../archivos/asociados/'.$idasociado.'/mercantil/';
               break;

            }

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionasociados(mysql_result($resFoto,0,'iddocumentacionasociado'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionasociados() {
		$sql = "select
		d.iddocumentacionasociado,
		d.refasociados,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionasociados d
		inner join dbasociados ase ON ase.idasociado = d.refasociados
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionasociadosPorId($id) {
		$sql = "select iddocumentacionasociado,refasociados,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionasociados where iddocumentacionasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorAsociadoDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionasociado,da.refasociados,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionasociados da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasociados =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPostulanteDocumentacionAsociado($id) {
		$sql = "select
		da.iddocumentacionasociado,da.refasociados,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, dd.carpeta
		from dbdocumentacionasociados da
		inner join dbdocumentaciones dd on dd.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasociados =".$id." and dd.orden is not null order by dd.orden,da.archivo";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorAsociadoDocumentacionEspecifica($id, $iddocumentacion, $archivo) {
		$sql = "select
		da.iddocumentacionasociado,da.refasociados,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color
		from dbdocumentacionasociados da
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refasociados =".$id." and da.refdocumentaciones = ".$iddocumentacion." and da.archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	/* fin para documentaciones de asociados */
	/* PARA Bancos */

	function insertarBancos($banco) {
	$sql = "insert into tbbancos(idbanco,banco)
	values ('','".$banco."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarBancos($id,$banco) {
	$sql = "update tbbancos
	set
	banco = '".$banco."'
	where idbanco =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarBancos($id) {
	$sql = "delete from tbbancos where idbanco =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerBancos() {
	$sql = "select
	b.idbanco,
	b.banco
	from tbbancos b
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerBancosPorId($id) {
	$sql = "select idbanco,banco from tbbancos where idbanco =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbbancos*/

	/* PARA Asociados */

	function insertarAsociados($refusuarios,$reftipoasociado,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$refestadoasociado,$refoportunidades,$refpostulantes) {
		$sql = "insert into dbasociados(idasociado,refusuarios,reftipoasociado,nombredespacho,apellidopaterno,apellidomaterno,nombre,ine,email,fechanacimiento,telefonomovil,telefonotrabajo,refbancos,claveinterbancaria,domicilio,refestadoasociado,refoportunidades,refpostulantes)
		values ('',".$refusuarios.",".$reftipoasociado.",'".$nombredespacho."','".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$ine."','".$email."','".$fechanacimiento."','".$telefonomovil."','".$telefonotrabajo."',".$refbancos.",'".$claveinterbancaria."','".$domicilio."',".$refestadoasociado.",".($refoportunidades == '' ? 0 : $refoportunidades).",".($refpostulantes == '' ? 0 : $refpostulantes).")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAsociados($id,$refusuarios,$reftipoasociado,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$ine,$email,$fechanacimiento,$telefonomovil,$telefonotrabajo,$refbancos,$claveinterbancaria,$domicilio,$refestadoasociado,$refoportunidades,$refpostulantes) {
		$sql = "update dbasociados
		set
		refusuarios = ".$refusuarios.",reftipoasociado = ".$reftipoasociado.",nombredespacho = '".$nombredespacho."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',ine = '".$ine."',email = '".$email."',fechanacimiento = '".$fechanacimiento."',telefonomovil = '".$telefonomovil."',telefonotrabajo = '".$telefonotrabajo."',refbancos = ".$refbancos.",claveinterbancaria = '".$claveinterbancaria."',domicilio = '".$domicilio."',refestadoasociado = ".$refestadoasociado.",refoportunidades = ".($refoportunidades == '' ? 0 : $refoportunidades).",refpostulantes = ".($refpostulantes == '' ? 0 : $refpostulantes)." where idasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarAsociados($id) {
		$sql = "delete from dbasociados where idasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsociadosajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial) {

		$where = '';

		if ($responsableComercial != '') {
	      $roles = " (uo.idusuario = ".$responsableComercial." or upo.idusuario = ".$responsableComercial.") and ";
	   } else {
	      $roles = '';
	   }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where ".$roles." (a.apellidopaterno like '%".$busqueda."%' or a.apellidomaterno like '%".$busqueda."%' or p.nombre like '%".$busqueda."%' or p.email like '%".$busqueda."%' or p.ine like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " where (uo.idusuario = ".$responsableComercial." or upo.idusuario = ".$responsableComercial.") ";
	      }
		}


		$sql = "select
		a.idasociado,
		ta.tipoasociado,
		a.nombredespacho,
		a.apellidopaterno,
		a.apellidomaterno,
		a.nombre,
		coalesce(uo.nombrecompleto, upo.nombrecompleto) as gerente,
		a.email,
		a.fechanacimiento,
		a.telefonomovil,
		a.telefonotrabajo,
		a.refbancos,
		a.claveinterbancaria,
		a.domicilio,
		a.ine,
		a.refusuarios
		from dbasociados a
		inner join dbusuarios usu ON usu.idusuario = a.refusuarios
		inner join tbbancos ban ON ban.idbanco = a.refbancos
		inner join tbtipoasociado ta ON ta.idtipoasociado = a.reftipoasociado
		left join dbpostulantes pp ON pp.idpostulante = a.refpostulantes
      left join dboportunidades o ON o.idoportunidad = a.refoportunidades
      left join dbusuarios uo on uo.idusuario = o.refusuarios and o.refestadooportunidad = 7
      left join dbreclutadorasores rrr on rrr.refpostulantes = pp.idpostulante
      left join dbusuarios upo on upo.idusuario = rrr.refusuarios
		".$where."
		group by a.idasociado,
		ta.tipoasociado,
		a.nombredespacho,
		a.apellidopaterno,
		a.apellidomaterno,
		a.nombre,
		uo.nombrecompleto,
		upo.nombrecompleto,
		a.email,
		a.fechanacimiento,
		a.telefonomovil,
		a.telefonotrabajo,
		a.refbancos,
		a.claveinterbancaria,
		a.domicilio,
		a.ine,
		a.refusuarios
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traerAsociados() {
		$sql = "select
		a.idasociado,
		a.refusuarios,
		a.apellidopaterno,
		a.apellidomaterno,
		a.nombre,
		a.ine,
		a.email,
		a.fechanacimiento,
		a.telefonomovil,
		a.telefonotrabajo,
		a.refbancos,
		a.claveinterbancaria,
		a.domicilio
		from dbasociados a
		inner join dbusuarios usu ON usu.idusuario = a.refusuarios
		inner join tbbancos ban ON ban.idbanco = a.refbancos
		order by a.apellidopaterno,
		a.apellidomaterno,
		a.nombre";
		$res = $this->query($sql,0);
		return $res;
	}

	function bAsociados($busqueda, $tipo) {
		$sql = "select
		a.idasociado,
		a.refusuarios,
		a.apellidopaterno,
		a.apellidomaterno,
		a.nombre,
		a.ine,
		a.email,
		a.fechanacimiento,
		a.telefonomovil,
		a.telefonotrabajo,
		a.refbancos,
		a.claveinterbancaria,
		a.domicilio,
		concat(a.apellidopaterno, ' ', a.apellidomaterno, ' ', a.nombre) as nombrecompleto
		from dbasociados a
		inner join dbusuarios usu ON usu.idusuario = a.refusuarios
		inner join tbbancos ban ON ban.idbanco = a.refbancos
		where concat(a.apellidopaterno, ' ', a.apellidomaterno, ' ', a.nombre) like '%".$busqueda."%' and a.reftipoasociado = ".$tipo."
		order by a.apellidopaterno,
		a.apellidomaterno,
		a.nombre";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsociadosPorId($id) {
		$sql = "select idasociado,reftipoasociado,refusuarios,apellidopaterno,apellidomaterno,nombre,ine,email,fechanacimiento,telefonomovil,telefonotrabajo,refbancos,claveinterbancaria,domicilio,nombredespacho,refestadoasociado,refoportunidades,refpostulantes from dbasociados where idasociado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerAsociadosPorUsuario($id) {
		$sql = "select idasociado,reftipoasociado,refusuarios,apellidopaterno,apellidomaterno,nombre,ine,email,fechanacimiento,telefonomovil,telefonotrabajo,refbancos,claveinterbancaria,domicilio,nombredespacho,refestadoasociado,refoportunidades,refpostulantes from dbasociados where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbasociados*/

	/* PARA Motivorechazos */

	function insertarMotivorechazos($motivorechazo) {
		$sql = "insert into tbmotivorechazos(idmotivorechazo,motivorechazo)
		values ('','".$motivorechazo."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarMotivorechazos($id,$motivorechazo) {
		$sql = "update tbmotivorechazos
		set
		motivorechazo = '".$motivorechazo."'
		where idmotivorechazo =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarMotivorechazos($id) {
		$sql = "delete from tbmotivorechazos where idmotivorechazo =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerMotivorechazos() {
		$sql = "select
		m.idmotivorechazo,
		m.motivorechazo
		from tbmotivorechazos m
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerMotivorechazosPorId($id) {
		$sql = "select idmotivorechazo,motivorechazo from tbmotivorechazos where idmotivorechazo =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbmotivorechazos*/

	function graficoGerenteRendimiento($idusuario) {
		$sql = "select
					r.nombrecompleto,
					sum(r.completosoportunidades) as completosoportunidades,
					sum(r.completos) as completos,
					sum(r.abandonaron) as abandonaron
					from (
					    select
							usu.nombrecompleto,
					        count(*) as completosoportunidades,
					        0 as completos,
					        0 as abandonaron
							from dboportunidades o
							inner join dbusuarios usu ON usu.idusuario = o.refusuarios
							inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
							inner join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
					        inner join dbpostulantes pp on pp.idpostulante = r.refpostulantes and pp.refestadopostulantes = 10
							where o.refestadooportunidad = 3 and usu.idusuario = ".$idusuario."

					union all
						select
							usu.nombrecompleto,
					        0 as completosoportunidades,
					        count(*) as completos,
					        0 as abandonaron
							from dbpostulantes pp
					        inner join dbreclutadorasores r on r.refpostulantes = pp.idpostulante
					        inner join dbusuarios usu on usu.idusuario = r.refusuarios
							where pp.refestadopostulantes = 10 and usu.idusuario = ".$idusuario." and r.refoportunidades = 0

					union all
						select
							usu.nombrecompleto,
					        0 as completosoportunidades,
					        0 as completos,
					        count(*) as abandonaron
							from dbpostulantes pp
					        inner join dbreclutadorasores r on r.refpostulantes = pp.idpostulante
					        inner join dbusuarios usu on usu.idusuario = r.refusuarios
							where pp.refestadopostulantes = 9 and usu.idusuario = ".$idusuario."
						) r
					group by r.nombrecompleto";

		$res = $this->query($sql,0);
		return $res;

	}


	function graficoGerenteRendimientoTotal() {
		$sql = "select
					r.nombrecompleto,
					sum(r.completosoportunidades) as completosoportunidades,
					sum(r.completos) as completos,
					sum(r.abandonaron) as abandonaron,
					sum(r.encurso) as encurso
					from (
					    select
							'' as nombrecompleto,
					        count(*) as completosoportunidades,
					        0 as completos,
					        0 as abandonaron,
							  0 as encurso
							from dboportunidades o
							inner join dbusuarios usu ON usu.idusuario = o.refusuarios
							inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
							inner join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
					        inner join dbpostulantes pp on pp.idpostulante = r.refpostulantes and pp.refestadopostulantes = 10
							where o.refestadooportunidad = 3

					union all
						select
							'' as nombrecompleto,
					        0 as completosoportunidades,
					        count(*) as completos,
					        0 as abandonaron,
							  0 as encurso
							from dbpostulantes pp
							where pp.refestadopostulantes = 10

					union all
						select
							'' as nombrecompleto,
					        0 as completosoportunidades,
					        0 as completos,
					        count(*) as abandonaron,
							  0 as encurso
							from dbpostulantes pp
							where pp.refestadopostulantes = 9

					union all
						select
							'' as nombrecompleto,
					        0 as completosoportunidades,
					        0 as completos,
					        0 as abandonaron,
							  count(*) as encurso
							from dbpostulantes pp
							where pp.refestadopostulantes in (11)
						) r
					group by r.nombrecompleto";

		$res = $this->query($sql,0);
		return $res;

	}

	function graficoTotalFinalizados() {
		$sql = "SELECT
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 3 THEN 1
				    END),0) AS aceptado,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad in (4,8) THEN 1
				    END),0) AS rechazado,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 5 THEN 1
				    END),0) AS noatendido,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 6 THEN 1
				    END),0) AS nocontacto,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 7 THEN 1
				    END),0) AS asociado

				FROM
				    dboportunidades opo
				WHERE
				    opo.refestadooportunidad IN (3 , 4,5,6,7,8)";
		$res = $this->query($sql,0);
		return $res;
	}

	function graficoTotalMensual() {
		$sql = "SELECT
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 3 THEN 1
				    END),0) AS aceptado,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad in (4,8) THEN 1
				    END),0) AS rechazado,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 5 THEN 1
				    END),0) AS noatendido,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 6 THEN 1
				    END),0) AS nocontacto,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 7 THEN 1
				    END),0) AS asociado

				FROM
				    dboportunidades opo
				WHERE
				    opo.refestadooportunidad IN (3 , 4,5,6,7,8) and month(opo.fechacrea) = 3";
		$res = $this->query($sql,0);
		return $res;
	}

	function graficoTotalActuales() {
		$sql = "SELECT
					m.meses,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 1 THEN 1
				    END),0) AS poratender,
				    coalesce(sum(CASE
				        WHEN opo.refestadooportunidad = 2 THEN 1
				    END),0) AS citaprogramada
				FROM
					tbmeses m
				    left join dboportunidades opo on month(opo.fechacrea) = m.idmes and opo.refestadooportunidad IN (1 , 2)
				group by m.meses
				order by m.idmes";
		$res = $this->query($sql,0);
		return $res;
	}

	function graficoActualmente() {
		$sql = "select
						r.nombrecompleto,
						count(r.poratender) as poratender,
						count(r.citaprogramada) as citaprogramada
					from (
						SELECT
							usu.nombrecompleto,
							(case when opo.refestadooportunidad = 1 then 1 end) as poratender,
							(case when opo.refestadooportunidad = 2 then 1 end) as citaprogramada
						FROM
							dboportunidades opo
								INNER JOIN
							dbusuarios usu ON usu.idusuario = opo.refusuarios
						WHERE
							opo.refestadooportunidad IN (1 , 2)
					    ) r
					group by r.nombrecompleto
					order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function graficoIndiceAceptacion() {
		$sql = "select
						r.nombrecompleto,
						count(r.aceptado) as aceptado,
						count(r.rechazado) as rechazado,
						count(r.noatendido) as noatendido,
						count(r.nocontacto) as nocontacto,
						count(r.asociado) as asociado
					from (
						SELECT
							usu.nombrecompleto,
							(case when opo.refestadooportunidad = 3 then 1 end) as aceptado,
							(case when opo.refestadooportunidad in (4,8) then 1 end) as rechazado,
							(case when opo.refestadooportunidad in (5) then 1 end) as noatendido,
							(case when opo.refestadooportunidad in (6) then 1 end) as nocontacto,
							(case when opo.refestadooportunidad in (7) then 1 end) as asociado
						FROM
						dbusuarios usu
						 left JOIN dboportunidades opo ON usu.idusuario = opo.refusuarios
						 		and opo.refestadooportunidad IN (3 , 4,5,6,7,8)
						 where usu.refroles = 3
					    ) r
					group by r.nombrecompleto
					order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function graficoIndiceAceptacionMesual() {
		$sql = "select
						r.nombrecompleto,
						count(r.aceptado) as aceptado,
						count(r.rechazado) as rechazado,
						count(r.noatendido) as noatendido,
						count(r.nocontacto) as nocontacto,
						count(r.asociado) as asociado,
						count(r.iniciado) as iniciado
					from (
						SELECT
							usu.nombrecompleto,
							(case when opo.refestadooportunidad in (1,2) then 1 end) as iniciado,
							(case when opo.refestadooportunidad = 3 then 1 end) as aceptado,
							(case when opo.refestadooportunidad in (4,8) then 1 end) as rechazado,
							(case when opo.refestadooportunidad in (5) then 1 end) as noatendido,
							(case when opo.refestadooportunidad in (6) then 1 end) as nocontacto,
							(case when opo.refestadooportunidad in (7) then 1 end) as asociado
						FROM
						dbusuarios usu
						 left JOIN dboportunidades opo ON usu.idusuario = opo.refusuarios
						 		and opo.refestadooportunidad IN (1,2,3 , 4,5,6,7,8) and month(opo.fechacrea)=3
						 where usu.refroles = 3
					    ) r
					group by r.nombrecompleto
					order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReferentesPorUsuario($idusuario) {
		$sql = "select idreferente,apellidopaterno,apellidomaterno,nombre,telefono,email,observaciones,refusuarios from tbreferentes where refusuarios =".$idusuario;

		$res = $this->query($sql,0);
		return $res;
	}

	function traerComisionesReferentes($idreferente) {
		$sql = "SELECT
				r.idreferente,
			    p.apellidopaterno,
			    p.apellidomaterno,
			    p.nombre,
			    2000 AS comision
			FROM
			    tbreferentes r
			        INNER JOIN
			    dboportunidades opo ON opo.refreferentes = r.idreferente
			        INNER JOIN
			    dbreclutadorasores rr ON rr.refoportunidades = opo.idoportunidad
			        INNER JOIN
			    dbpostulantes p ON p.idpostulante = rr.refpostulantes
			WHERE
			    p.refestadopostulantes = 10 and r.idreferente = ".$idreferente;

		$res = $this->query($sql,0);
		return $res;
	}

	function traerComisionesReferentesajax($length, $start, $busqueda,$colSort,$colSortDir, $idreferente) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (p.apellidopaterno like '%".$busqueda."%' or p.apellidomaterno like '%".$busqueda."%' or p.nombre like '%".$busqueda."%')";
		}


		$sql = "SELECT
				r.idreferente,
			    p.apellidopaterno,
			    p.apellidomaterno,
			    p.nombre,
			    1000 AS comision
			FROM
			    tbreferentes r
			        INNER JOIN
			    dboportunidades opo ON opo.refreferentes = r.idreferente
			        INNER JOIN
			    dbreclutadorasores rr ON rr.refoportunidades = opo.idoportunidad
			        INNER JOIN
			    dbpostulantes p ON p.idpostulante = rr.refpostulantes
			WHERE
			    p.refestadopostulantes = 10 and r.idreferente = ".$idreferente."
		".$where."
		union all
			SELECT
				r.idreferente,
			    p.apellidopaterno,
			    p.apellidomaterno,
			    p.nombre,
			    1000 AS comision
			FROM
			    tbreferentes r
			        INNER JOIN
			    dbpostulantes p ON p.refreferentes = r.idreferente
			WHERE
			    p.refestadopostulantes in (10,11) and r.idreferente = ".$idreferente."
		".$where."
		union all

			SELECT
				r.idreferente,
				opo.apellidopaterno,
				opo.apellidomaterno,
				opo.nombre,
			    1000 AS comision
			FROM
			    tbreferentes r
			        INNER JOIN
			    dboportunidades opo ON opo.refreferentes = r.idreferente
			WHERE
			    opo.refestadooportunidad in (7) and r.idreferente = ".$idreferente."
		".$where."
		ORDER BY ".$colSort." ".$colSortDir."
		limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = $this->query($sql,0);
		return $res;
	}

	/* PARA Entrevistaoportunidades */

	function existeEntrevistaOportunidad($refoportunidades) {
		$sql = "select identrevistaoportunidad from dbentrevistaoportunidades where refoportunidades = ".$refoportunidades;
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			return 1;
		}

		return 0;
	}

	function insertarEntrevistaoportunidades($refoportunidades,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadoentrevistas,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$reftipocita) {
		$sql = "insert into dbentrevistaoportunidades(identrevistaoportunidad,refoportunidades,entrevistador,fecha,domicilio,codigopostal,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi,reftipocita)
		values ('',".$refoportunidades.",'".$entrevistador."','".$fecha."','".$domicilio."',".$codigopostal.",".$refestadoentrevistas.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$reftipocita.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEntrevistaoportunidades($id,$refoportunidades,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadoentrevistas,$fechamodi,$usuariomodi,$reftipocita) {
		$sql = "update dbentrevistaoportunidades
		set
		refoportunidades = ".$refoportunidades.",entrevistador = '".$entrevistador."',fecha = '".$fecha."',domicilio = '".$domicilio."',codigopostal = ".$codigopostal.",refestadoentrevistas = ".$refestadoentrevistas.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."', reftipocita = ".$reftipocita."
		where identrevistaoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEntrevistaoportunidades($id) {
		$sql = "delete from dbentrevistaoportunidades where identrevistaoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function cancelarEntrevistaoportunidades($id) {
		$sql = "update dbentrevistaoportunidades set refestadoentrevistas = 4 where identrevistaoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistaoportunidadesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where concat(opo.apellidopaterno, ' ', opo.apellidomaterno, ' ', opo.nombre) like '%".$busqueda."%' or e.entrevistador like '%".$busqueda."%' or cast(e.fecha as unsigned) like '%".$busqueda."%' or e.domicilio like '%".$busqueda."%' or pp.codigo like '%".$busqueda."%' or est.estadoentrevista like '%".$busqueda."%'";
		}


		$sql = "select
		e.identrevistaoportunidad,
		concat(opo.apellidopaterno, ' ', opo.apellidomaterno, ' ', opo.nombre) as persona,
		e.entrevistador,
		e.fecha,
		(case when est.idestadoentrevista = 3 then 'Re-Programado'
				when est.idestadoentrevista = 2 then 'Visitado con exito'
				when est.idestadoentrevista = 4 then 'Visitado sin exito'
				else est.estadoentrevista end) as estadoentrevista,
		e.domicilio,
		pp.codigo,
		e.fechamodi,
		e.codigopostal,
		e.refoportunidades,
		e.refestadoentrevistas,
		e.fechacrea,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistaoportunidades e
		inner join postal pp on pp.id = e.codigopostal
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerEntrevistaoportunidadesPorUsuarioajax($length, $start, $busqueda,$colSort,$colSortDir, $idusuario) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (concat(opo.apellidopaterno, ' ', opo.apellidomaterno, ' ', opo.nombre) like '%".$busqueda."%' or e.entrevistador like '%".$busqueda."%' or cast(e.fecha as unsigned) like '%".$busqueda."%' or e.domicilio like '%".$busqueda."%' or pp.codigo like '%".$busqueda."%' or est.estadoentrevista like '%".$busqueda."%')";
		}


		$sql = "select
		e.identrevistaoportunidad,
		concat(opo.apellidopaterno, ' ', opo.apellidomaterno, ' ', opo.nombre) as persona,
		e.entrevistador,
		e.fecha,

		(case when est.idestadoentrevista = 3 then 'Re-Programado'
				when est.idestadoentrevista = 2 then 'Visitado con exito'
				when est.idestadoentrevista = 4 then 'Visitado sin exito'
				else est.estadoentrevista end) as estadoentrevista,
		e.domicilio,
		pp.codigo,
		e.fechamodi,
		e.codigopostal,
		e.refoportunidades,
		e.refestadoentrevistas,
		e.fechacrea,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistaoportunidades e
		inner join postal pp on pp.id = e.codigopostal
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		where us.idusuario = ".$idusuario.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerEntrevistaoportunidades() {
		$sql = "select
		e.identrevistaoportunidad,
		e.refoportunidades,
		e.entrevistador,
		e.fecha,
		e.domicilio,
		e.codigopostal,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistaoportunidades e
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		order by e.fecha";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistaoportunidadesCalendar($refgerentecomercial) {

		if ($refgerentecomercial != 0) {
			$whereAd = ' where us.idusuario = '.$refgerentecomercial;
		} else {
			$whereAd = '';
		}

		$sql = "select
		e.identrevistaoportunidad,
		concat('Entrevista con ',' ',opo.apellidopaterno,' ',opo.apellidomaterno,' ',opo.nombre) as title,
		concat('Entrevista con ',' ',opo.apellidopaterno,' ',opo.apellidomaterno,' ',opo.nombre, ', Estado: ', est.estadoentrevista) as description,
		'#3FBF3F' as color,
		e.refoportunidades,
		e.entrevistador,
		e.fecha as start,
		e.domicilio,
		e.codigopostal,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi,
		us.nombrecompleto
		from dbentrevistaoportunidades e
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		".$whereAd."
		order by e.fecha";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistaoportunidadesPorOportunidad($id) {
		$sql = "select
		e.identrevistaoportunidad,
		e.refoportunidades,
		e.entrevistador,
		e.fecha,
		e.domicilio,
		e.codigopostal,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi,
		e.reftipocita
		from dbentrevistaoportunidades e
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		where opo.idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistaoportunidadesPorUsuario($id) {
		$sql = "select
		e.identrevistaoportunidad,
		e.refoportunidades,
		e.entrevistador,
		e.fecha,
		e.domicilio,
		e.codigopostal,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistaoportunidades e
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		where us.idusuario =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistaoportunidadesPorUsuarioCalendar($id) {

		$sql = "select
		e.identrevistaoportunidad,
		concat('Entrevista con ',' ',opo.apellidopaterno,' ',opo.apellidomaterno,' ',opo.nombre) as title,
		concat('Entrevista con ',' ',opo.apellidopaterno,' ',opo.apellidomaterno,' ',opo.nombre, ', Estado: ', est.estadoentrevista) as description,
		'#3FBF3F' as color,
		e.entrevistador,
		e.fecha as start,
		e.domicilio,
		e.codigopostal,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistaoportunidades e
		inner join dboportunidades opo ON opo.idoportunidad = e.refoportunidades
		inner join dbusuarios us ON us.idusuario = opo.refusuarios
		inner join tbestadooportunidad es ON es.idestadooportunidad = opo.refestadooportunidad
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		where us.idusuario =".$id.$whereAd;

		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistaoportunidadesPorId($id) {
		$sql = "select identrevistaoportunidad,refoportunidades,entrevistador,fecha,domicilio,codigopostal,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi from dbentrevistaoportunidades where identrevistaoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistaoportunidadesPorIdCompleto($id) {
		$sql = "select
		e.identrevistaoportunidad,e.codigopostal,e.entrevistador,e.fecha,
		e.domicilio,e.refestadoentrevistas,e.fechacrea,e.fechamodi,
		e.usuariocrea,e.usuariomodi , p.codigo,
		p.colonia,
		p.municipio,
		p.estado
		from dbentrevistaoportunidades  e
		inner join postal p on e.codigopostal = p.id
		where identrevistaoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbentrevistaoportunidades*/



	/* PARA Oportunidades */

	function existeOportunidad($apellidopaterno,$apellidomaterno,$nombre) {
		$sql = "select count(*) from dboportunidades
					where lower(apellidopaterno) = lower(trim('".$apellidopaterno."')) and
					lower(apellidomaterno) = lower(trim('".$apellidomaterno."')) and
					lower(nombre) = lower(trim('".$nombre."'))";

		$res = $this->query($sql,0);
		if (mysql_result($res,0,0) > 0) {
			return 1;
		}
		return 0;
	}

	function insertarOportunidades($nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$telefonomovil,$telefonotrabajo,$email,$refusuarios,$refreferentes,$refestadooportunidad,$refmotivorechazos,$observaciones,$refestadogeneraloportunidad,$reforigenreclutamiento) {
		$sql = "insert into dboportunidades(idoportunidad,nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,refusuarios,refreferentes,refestadooportunidad,fechacrea,refmotivorechazos,observaciones,refestadogeneraloportunidad,reforigenreclutamiento)
		values ('','".$nombredespacho."','".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$telefonomovil."','".$telefonotrabajo."','".$email."',".$refusuarios.",".$refreferentes.",".$refestadooportunidad.",'".date('Y-m-d H:i:s')."',".$refmotivorechazos.",'".$observaciones."',".$refestadogeneraloportunidad.",".$reforigenreclutamiento.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarOportunidades($id,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$telefonomovil,$telefonotrabajo,$email,$refusuarios,$refreferentes,$refestadooportunidad,$refmotivorechazos,$observaciones,$refestadogeneraloportunidad,$reforigenreclutamiento) {
		$sql = "update dboportunidades
		set
		nombredespacho = '".$nombredespacho."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',telefonomovil = '".$telefonomovil."',telefonotrabajo = '".$telefonotrabajo."',email = '".$email."',refusuarios = ".$refusuarios.",refreferentes = ".$refreferentes.",refestadooportunidad = ".$refestadooportunidad.",refmotivorechazos = ".$refmotivorechazos.",observaciones = '".$observaciones."',refestadogeneraloportunidad = ".$refestadogeneraloportunidad.",reforigenreclutamiento = ".$reforigenreclutamiento."
		where idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarOportunidadesEstado($id,$refestadooportunidad) {
		$sql = "update dboportunidades
		set
		refestadooportunidad = ".$refestadooportunidad."
		where idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function modificarOportunidadesEstadoGeneral($id,$refestadogeneraloportunidad) {
		$sql = "update dboportunidades
		set
		refestadogeneraloportunidad = ".$refestadogeneraloportunidad."
		where idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarOportunidades($id) {
		$sql = "delete from dboportunidades where idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerOportunidades() {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,
		o.observaciones,
		o.refestadogeneraloportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesGrid($responsableComercial) {

		if ($responsableComercial != '') {
	      $roles = "where usu.idusuario = ".$responsableComercial."  ";
	   } else {
	      $roles = '';
	   }

		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		".$roles."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesDisponibles() {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones,
		concat(o.apellidopaterno, ' ',o.apellidomaterno, ' ',o.nombre) as nombrecompleto
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and o.refestadooportunidad = 3
		order by o.apellidopaterno,o.apellidomaterno,o.nombre";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max, $estado) {

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}

		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " usu.idusuario = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and ".$roles." (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or o.fechacrea like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " and usu.idusuario = ".$responsableComercial." ";
	      }
		}


		$sql = "select
		o.idoportunidad,
		eo.fecha,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		est.estadooportunidad,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		(case when o.refestadooportunidad in (1,2) then DATEDIFF(CURDATE(),o.fechacrea) else 0 end) as dias,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbentrevistaoportunidades eo on eo.refoportunidades = o.idoportunidad
		where est.idestadooportunidad not in (3,4,5,6,7,8) ".$where." ".$cadFecha.$cadEstado."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = $this->query($sql.$limit,0);
		$resAux  = $this->query($sql,0);
		return array($res,$resAux);
	}


	function traerOportunidadesajaxPorUsuario($length, $start, $busqueda,$colSort,$colSortDir, $idusuario, $min, $max, $estado) {

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}


		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		}


		$sql = "select
		o.idoportunidad,
		eo.fecha,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		est.estadooportunidad,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		(case when o.refestadooportunidad in (1,2) then DATEDIFF(CURDATE(),o.fechacrea) else 0 end) as dias,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		left join dbentrevistaoportunidades eo on eo.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and est.idestadooportunidad not in (3,4,5,6,7,8) and usu.idusuario = ".$idusuario.$where." ".$cadFecha.$cadEstado."
		ORDER BY o.fechacrea desc ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traerOportunidadesajaxPorUsuarioHistorico($length, $start, $busqueda,$colSort,$colSortDir, $idusuario, $min, $max, $estado) {

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		}


		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		est.estadooportunidad,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where (est.idestadooportunidad in (3,4,5,6,7,8) or r.refoportunidades is not null) and usu.idusuario = ".$idusuario.$where."  ".$cadFecha.$cadEstado."
		ORDER BY o.fechacrea desc ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerOportunidadesajaxPorRecomendador($length, $start, $busqueda,$colSort,$colSortDir, $idusuario, $min, $max, $estado) {

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		}


		$sql = "select
		o.idoportunidad,
		eo.fecha,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		est.estadooportunidad,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		(case when o.refestadooportunidad in (1,2) then DATEDIFF(CURDATE(),o.fechacrea) else 0 end) as dias,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		left join dbentrevistaoportunidades eo on eo.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and est.idestadooportunidad not in (3,4,5,6,7,8) and o.refreferentes = ".$idusuario.$where." ".$cadFecha.$cadEstado."
		ORDER BY o.fechacrea desc ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traerOportunidadesajaxPorRecomendadorHistorico($length, $start, $busqueda,$colSort,$colSortDir, $idusuario, $min, $max, $estado) {

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		}


		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		est.estadooportunidad,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where  (est.idestadooportunidad in (3,4,5,6,7,8) or r.refoportunidades is not null) and o.refreferentes = ".$idusuario.$where." ".$cadFecha.$cadEstado."
		ORDER BY o.fechacrea desc ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerOportunidadesajaxPorHistorico($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max, $estado, $asignados) {

		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " usu.idusuario = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}

		$cadAsigandos = '';
		if ($asignados == '1') {
			$cadAsigandos = " inner join dbreasignaciones ra on ra.refoportunidades = o.idoportunidad ";
		} else {
			$cadAsigandos = " left join dbreasignaciones ra on ra.refoportunidades = o.idoportunidad ";
		}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " ".$roles." and (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		}


		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		concat(est.estadooportunidad, ' ', (case when ra.idreasignacion is null then '' else '** Reasignado' end)) as estadooportunidad ,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		".$cadAsigandos."
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where ".$roles." (est.idestadooportunidad in (3,4,5,6,7,8) or r.refoportunidades is not null) ".$where." ".$cadFecha.$cadEstado."
		ORDER BY o.fechacrea desc ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerOportunidadesajaxPorHistoricoJavelly($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial,$min,$max, $estado, $asignados) {

		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " usu.idusuario = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

		$cadFecha = '';
		if ($min != '' && $max != '') {
			$cadFecha = " and o.fechacrea between '".$min."' and '".$max."'";
		} else {
			if ($min != '' && $max == '') {
				$cadFecha = " and o.fechacrea >= '".$min."'";
			} else {
				if ($min == '' && $max != '') {
					$cadFecha = " and o.fechacrea <= '".$max."'";
				}
			}
		}

		$cadEstado = '';
		if ($estado != '') {
			$cadEstado = " and o.refestadooportunidad =".$estado;
		}

		$cadAsigandos = '';
		if ($asignados == '1') {
			$cadAsigandos = " inner join dbreasignaciones ra on ra.refoportunidades = o.idoportunidad ";
		} else {
			$cadAsigandos = " left join dbreasignaciones ra on ra.refoportunidades = o.idoportunidad ";
		}

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " ".$roles." and (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
		}


		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		concat(o.apellidopaterno,' ',	o.apellidomaterno,' ', o.nombre) as apyn,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		usu.nombrecompleto,
		concat(est.estadooportunidad, ' ', (case when ra.idreasignacion is null then '' else '** Reasignado' end)) as estadooportunidad ,
		concat(rr.apellidopaterno, ' ', rr.nombre) as referente,
		o.fechacrea,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		".$cadAsigandos."
		left join tbreferentes rr on rr.idreferente = o.refreferentes
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where o.refestadogeneraloportunidad = 3 and ".$roles." (est.idestadooportunidad in (4,5,6,7,8) or r.refoportunidades is not null) ".$where." ".$cadFecha.$cadEstado."
		ORDER BY o.fechacrea desc ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerOportunidadesPorUsuario($idusuario) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and usu.idusuario = ".$idusuario."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorRecomendador($idusuario) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and o.refreferentes = ".$idusuario."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorUsuarioEstadoH($idusuario, $idestado) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		inner join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where usu.idusuario = ".$idusuario." and o.refestadooportunidad in (".$idestado.")
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorRecomendadorEstadoH($idusuario, $idestado) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		inner join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where o.refreferentes = ".$idusuario." and o.refestadooportunidad in (".$idestado.")
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorEstadoH($idestado) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		inner join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and o.refestadooportunidad in (".$idestado.")
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorUsuarioDisponibles($idusuario) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		o.refmotivorechazos,o.observaciones,
		concat(o.apellidopaterno, ' ',o.apellidomaterno, ' ',o.nombre) as nombrecompleto
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		left join dbreclutadorasores r on r.refoportunidades = o.idoportunidad
		where r.idreclutadorasor is null and usu.idusuario = ".$idusuario." and o.refestadooportunidad = 3
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerOportunidadesPorIdCompleto($id) {
		$sql = "select
		o.idoportunidad,
		o.nombredespacho,
		o.apellidopaterno,
		o.apellidomaterno,
		o.nombre,
		o.telefonomovil,
		o.telefonotrabajo,
		o.email,
		o.refusuarios,
		o.refreferentes,
		o.refestadooportunidad,
		usu.nombrecompleto,
		o.refmotivorechazos,
		o.observaciones,
		o.refestadogeneraloportunidad,
		o.reforigenreclutamiento
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		where o.idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorId($id) {
		$sql = "select idoportunidad,nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,refusuarios,refreferentes,refestadooportunidad,refmotivorechazos,observaciones,refestadogeneraloportunidad,reforigenreclutamiento from dboportunidades where idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dboportunidades*/


	/* PARA Estadooportunidad */

	function insertarEstadooportunidad($estadooportunidad) {
		$sql = "insert into tbestadooportunidad(idestadooportunidad,estadooportunidad)
		values ('','".$estadooportunidad."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEstadooportunidad($id,$estadooportunidad) {
		$sql = "update tbestadooportunidad
		set
		estadooportunidad = '".$estadooportunidad."'
		where idestadooportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEstadooportunidad($id) {
		$sql = "delete from tbestadooportunidad where idestadooportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadooportunidad() {
		$sql = "select
		e.idestadooportunidad,
		e.estadooportunidad
		from tbestadooportunidad e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadooportunidadPorId($id) {
		$sql = "select idestadooportunidad,estadooportunidad from tbestadooportunidad where idestadooportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEstadooportunidadPorIn($in) {
		$sql = "select idestadooportunidad,estadooportunidad from tbestadooportunidad where idestadooportunidad in (".$in.")";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadooportunidad*/


	/* PARA Referentes */

	function insertarReferentes($apellidopaterno,$apellidomaterno,$nombre,$telefono,$email,$observaciones,$refusuarios) {
		$sql = "insert into tbreferentes(idreferente,apellidopaterno,apellidomaterno,nombre,telefono,email,observaciones,refusuarios)
		values ('','".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$telefono."','".$email."','".$observaciones."',".$refusuarios.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarReferentes($id,$apellidopaterno,$apellidomaterno,$nombre,$telefono,$email,$observaciones,$refusuarios) {
		$sql = "update tbreferentes
		set
		apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',telefono = '".$telefono."',email = '".$email."',observaciones = '".$observaciones."', refusuarios= ".$refusuarios."
		where idreferente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarReferentes($id) {
		$sql = "delete from tbreferentes where idreferente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReferentesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where r.apellidopaterno like '%".$busqueda."%' or r.apellidomaterno like '%".$busqueda."%' or r.nombre like '%".$busqueda."%' or r.telefono like '%".$busqueda."%' or r.email like '%".$busqueda."%'";
		}


		$sql = "select
		r.idreferente,
		r.apellidopaterno,
		r.apellidomaterno,
		r.nombre,
		r.telefono,
		r.email,
		usu.nombrecompleto,
		r.observaciones
		from tbreferentes r
		left join dbusuarios usu on usu.idusuario = r.refusuarios
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0),$this->query($sql,0));
		return $res;
	}


	function traerReferentes() {
		$sql = "select
		r.idreferente,
		r.apellidopaterno,
		r.apellidomaterno,
		r.nombre,
		r.telefono,
		r.email,
		r.observaciones,
		r.refusuarios
		from tbreferentes r
		left join dbusuarios usu on usu.idusuario = r.refusuarios
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReferentesUsuario() {
		$sql = "select
		r.refusuarios,
		r.apellidopaterno,
		r.apellidomaterno,
		r.nombre,
		r.telefono,
		r.email,
		r.observaciones,
		r.idreferente
		from tbreferentes r
		left join dbusuarios usu on usu.idusuario = r.refusuarios
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerReferentesPorId($id) {
		$sql = "select idreferente,apellidopaterno,apellidomaterno,nombre,telefono,email,observaciones,refusuarios from tbreferentes where idreferente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbreferentes*/

	/* PARA Reclutadorasores */

	function insertarReclutadorasores($refusuarios,$refpostulantes,$refoportunidades,$refasesores,$refasociados) {
		$sql = "insert into dbreclutadorasores(idreclutadorasor,refusuarios,refpostulantes,refoportunidades,refasesores,refasociados)
		values ('',".$refusuarios.",".$refpostulantes.",".$refoportunidades.",".$refasesores.",".$refasociados.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarReclutadorasores($id,$refusuarios,$refpostulantes,$refoportunidades,$refasesores,$refasociados) {
		$sql = "update dbreclutadorasores
		set
		refusuarios = ".$refusuarios.",refpostulantes = ".$refpostulantes.",refoportunidades = ".$refoportunidades.",refasesores = ".$refasesores.",refasociados = ".$refasociados."
		where idreclutadorasor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarReclutadorasores($id) {
		$sql = "delete from dbreclutadorasores where idreclutadorasor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReclutadorasoresajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where usu.nombrecompleto like '%".$busqueda."%' or concat(p.apellidopaterno, ' ', p.apellidomaterno, ' ', p.nombre) like '%".$busqueda."%' or concat(opo.apellidopaterno, ' ', opo.apellidomaterno, ' ', opo.nombre) like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%'";
		}


		$sql = "select
		r.idreclutadorasor,
		usu.nombrecompleto,
		concat(p.apellidopaterno, ' ', p.apellidomaterno, ' ', p.nombre) as postulantes,
		concat(opo.apellidopaterno, ' ', opo.apellidomaterno, ' ', opo.nombre) as persona,
		concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) as asesor,
		concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) as asociado,
		r.refusuarios,
		r.refpostulantes,
		r.refoportunidades
		from dbreclutadorasores r
		inner join dbusuarios usu ON usu.idusuario = r.refusuarios
		left join dbpostulantes p on p.idpostulante = r.refpostulantes
		left join dboportunidades opo on opo.idoportunidad = r.refoportunidades
		left join dbasesores ase on ase.idasesor = r.refasesores
		left join dbasociados aso ON aso.idasociado = r.refasociados
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerReclutadorasores() {
		$sql = "select
		r.idreclutadorasor,
		r.refusuarios,
		r.refpostulantes
		from dbreclutadorasores r
		inner join dbusuarios usu ON usu.idusuario = r.refusuarios
		left join dbpostulantes p on p.idpostulante = r.refpostulantes
		left join dboportunidades opo on opo.idoportunidad = r.refoportunidades
		left join dbasesores ase on ase.idasesor = r.refasesores
		left join dbasociados aso ON aso.idasociado = r.refasociados
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerReclutadorasoresPorId($id) {
		$sql = "select idreclutadorasor,refusuarios,refpostulantes,refoportunidades,refasesores,refasociados from dbreclutadorasores where idreclutadorasor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerReclutadorasoresPorPostulante($id) {
		$sql = "SELECT
				    r.idreclutadorasor, r.refusuarios, r.refpostulantes, u.email, u.refroles
				FROM
				    dbreclutadorasores r
				    inner join dbusuarios u on u.idusuario = r.refusuarios
				WHERE
				    r.refpostulantes =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbreclutadorasores*/

	/* PARA Seguimientos */

	function insertarSeguimientos($refpostulantes,$refguias,$usuariomodi,$refestados) {
		$sql = "insert into dbseguimientos(idseguimiento,refpostulantes,refguias,usuariomodi,fechamodi,refestados)
		values ('',".$refpostulantes.",".$refguias.",'".$usuariomodi."','".date('Y-m-d H:i:s')."',".$refestados.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarSeguimientos($id,$refpostulantes,$refguias,$usuariomodi,$fechamodi,$refestados) {
		$sql = "update dbseguimientos
		set
		refpostulantes = ".$refpostulantes.",refguias = ".$refguias.",usuariomodi = '".$usuariomodi."',fechamodi = '".$fechamodi."',refestados = ".$refestados."
		where idseguimiento =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarSeguimientos($id) {
		$sql = "delete from dbseguimientos where idseguimiento =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerSeguimientos() {
		$sql = "select
		s.idseguimiento,
		s.refpostulantes,
		s.refguias,
		s.usuariomodi,
		s.fechamodi,
		s.refestados
		from dbseguimientos s
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerSeguimientosPorId($id) {
		$sql = "select idseguimiento,refpostulantes,refguias,usuariomodi,fechamodi,refestados from dbseguimientos where idseguimiento =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerSeguimientosPorPostulanteGuia($idpostulante, $idguia) {
		$sql = "select idseguimiento,refpostulantes,refguias,usuariomodi,fechamodi,refestados
			from dbseguimientos where refpostulantes =".$idpostulante." and refguias = ".$idguia;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerSeguimientosPorPostulante($idpostulante) {
		$sql = "select idseguimiento,refpostulantes,refguias,usuariomodi,fechamodi,refestados
			from dbseguimientos where refpostulantes =".$idpostulante;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbseguimientos*/

	/* PARA Esquemadocumentosestados */

	function insertarEsquemadocumentosestados($refesquemareclutamiento,$refdocumentaciones,$refestadopostulantes) {
		$sql = "insert into dbesquemadocumentosestados(idesquemadocumentoestado,refesquemareclutamiento,refdocumentaciones,refestadopostulantes)
		values ('',".$refesquemareclutamiento.",".$refdocumentaciones.",".$refestadopostulantes.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEsquemadocumentosestados($id,$refesquemareclutamiento,$refdocumentaciones,$refestadopostulantes) {
		$sql = "update dbesquemadocumentosestados
		set
		refesquemareclutamiento = ".$refesquemareclutamiento.",refdocumentaciones = ".$refdocumentaciones.",refestadopostulantes = ".$refestadopostulantes."
		where idesquemadocumentoestado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEsquemadocumentosestados($id) {
		$sql = "delete from dbesquemadocumentosestados where idesquemadocumentoestado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEsquemadocumentosestados() {
		$sql = "select
		e.idesquemadocumentoestado,
		e.refesquemareclutamiento,
		e.refdocumentaciones,
		e.refestadopostulantes
		from dbesquemadocumentosestados e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEsquemadocumentosestadosPorId($id) {
		$sql = "select idesquemadocumentoestado,refesquemareclutamiento,refdocumentaciones,refestadopostulantes from dbesquemadocumentosestados where idesquemadocumentoestado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEsquemadocumentosestadosPorDocumentacionesEsquema($iddocumentacion, $idesquema) {
		$sql = "select idesquemadocumentoestado,refesquemareclutamiento,refdocumentaciones,refestadopostulantes from dbesquemadocumentosestados where refesquemareclutamiento =".$idesquema." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEsquemadocumentosestadosPorEsquema( $idesquema) {
		$sql = "select idesquemadocumentoestado,refesquemareclutamiento,refdocumentaciones,refestadopostulantes from dbesquemadocumentosestados where refesquemareclutamiento =".$idesquema;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbesquemadocumentosestados*/


	/* PARA Guias */

	function insertarGuias($refesquemareclutamiento,$refestadopostulantes) {
		$sql = "insert into dbguias(idguia,refesquemareclutamiento,refestadopostulantes)
		values ('',".$refesquemareclutamiento.",".$refestadopostulantes.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarGuias($id,$refesquemareclutamiento,$refestadopostulantes) {
		$sql = "update dbguias
		set
		refesquemareclutamiento = ".$refesquemareclutamiento.",refestadopostulantes = ".$refestadopostulantes."
		where idguia =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarGuias($id) {
		$sql = "delete from dbguias where idguia =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerGuias() {
		$sql = "select
		g.idguia,
		g.refesquemareclutamiento,
		g.refestadopostulantes
		from dbguias g
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerGuiasPorId($id) {
		$sql = "select idguia,refesquemareclutamiento,refestadopostulantes from dbguias where idguia =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerGuiasPorEsquema($idesquema) {
		$sql = "select
					g.idguia,
					g.refesquemareclutamiento,
					g.refestadopostulantes,
					ep.estadopostulante,
					ep.orden,
					ep.url
				from dbguias g
				inner join tbestadopostulantes ep on ep.idestadopostulante = g.refestadopostulantes
				where refesquemareclutamiento =".$idesquema." order by ep.orden";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerGuiasPorEsquemaEspecial($idesquema) {
		$sql = "select
					g.idguia,
					g.refesquemareclutamiento,
					g.refestadopostulantes,
					ep.estadopostulante,
					ep.orden,
					ep.url
				from dbguias g
				inner join tbestadopostulantes ep on ep.idestadopostulante = g.refestadopostulantes
				where refesquemareclutamiento =".$idesquema." and g.refestadopostulantes not in (1,9)
				order by ep.orden";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerGuiasPorEsquemaEspecialJavelly($idesquema,$noId=0) {
		$sql = "select
					g.idguia,
					g.refesquemareclutamiento,
					g.refestadopostulantes,
					ep.estadopostulante,
					ep.orden,
					ep.url
				from dbguias g
				inner join tbestadopostulantes ep on ep.idestadopostulante = g.refestadopostulantes
				where refesquemareclutamiento =".$idesquema." and g.refestadopostulantes not in (1,9) and g.refestadopostulantes not in (".$noId.")
				order by ep.orden";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerGuiasPorEsquemaSiguiente($idesquema, $idestado) {
		$sql = "SELECT
					    g.idguia,
					    g.refesquemareclutamiento,
					    g.refestadopostulantes,
					    ep.estadopostulante,
					    ep.orden,
					    ep.url
					FROM
					    dbguias g
					        INNER JOIN
					    tbestadopostulantes ep ON ep.idestadopostulante = g.refestadopostulantes
					WHERE
					    refesquemareclutamiento = ".$idesquema."
					        and ep.orden > (SELECT
									ep.orden
								FROM
									dbguias g
										INNER JOIN
									tbestadopostulantes ep ON ep.idestadopostulante = g.refestadopostulantes
								WHERE
									refesquemareclutamiento = ".$idesquema."
										AND g.refestadopostulantes = ".$idestado.")
					limit 1";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbguias*/


	/* PARA Postulanteseguros */

	function insertarPostulanteseguros($refpostulantes,$refsegurosempresas) {
	$sql = "insert into dbpostulanteseguros(idpostulanteseguro,refpostulantes,refsegurosempresas)
	values ('',".$refpostulantes.",".$refsegurosempresas.")";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarPostulanteseguros($id,$refpostulantes,$refsegurosempresas) {
	$sql = "update dbpostulanteseguros
	set
	refpostulantes = ".$refpostulantes.",refsegurosempresas = ".$refsegurosempresas."
	where idpostulanteseguro =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarPostulanteseguros($id) {
	$sql = "delete from dbpostulanteseguros where idpostulanteseguro =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerPostulanteseguros() {
	$sql = "select
	p.idpostulanteseguro,
	p.refpostulantes,
	p.refsegurosempresas
	from dbpostulanteseguros p
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerPostulantesegurosPorId($id) {
	$sql = "select idpostulanteseguro,refpostulantes,refsegurosempresas from dbpostulanteseguros where idpostulanteseguro =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbpostulanteseguros*/

	/* PARA Segurosempresas */
	//622-472
	function insertarSegurosempresas($razonsocial) {
	$sql = "insert into tbsegurosempresas(idseguroempresa,razonsocial)
	values ('','".$razonsocial."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarSegurosempresas($id,$razonsocial) {
	$sql = "update tbsegurosempresas
	set
	razonsocial = '".$razonsocial."'
	where idseguroempresa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarSegurosempresas($id) {
	$sql = "delete from tbsegurosempresas where idseguroempresa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerSegurosempresas() {
	$sql = "select
	s.idseguroempresa,
	s.razonsocial
	from tbsegurosempresas s
	order by s.razonsocial";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerSegurosempresasPorId($id) {
	$sql = "select idseguroempresa,razonsocial from tbsegurosempresas where idseguroempresa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbsegurosempresas*/

	/* PARA Respuestadetalles */

	function insertarRespuestadetalles($refrespuestas,$valor, $respuesta) {
		$sql = "insert into dbrespuestadetalles(idrespuestadetalle,refrespuestas,valor,respuesta)
		values ('',".$refrespuestas.",".$valor.",".$respuesta.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarRespuestadetalles($id,$refrespuestas,$valor) {
		$sql = "update dbrespuestadetalles
		set
		refrespuestas = ".$refrespuestas.",valor = '".$valor."'
		where idrespuestadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarRespuestadetalles($id) {
		$sql = "delete from dbrespuestadetalles where idrespuestadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerRespuestadetalles() {
		$sql = "select
		r.idrespuestadetalle,
		r.refrespuestas,
		r.valor
		from dbrespuestadetalles r
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerRespuestadetallesPorId($id) {
		$sql = "select idrespuestadetalle,refrespuestas,valor from dbrespuestadetalles where idrespuestadetalle =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerRespuestasPorPostulante($id) {
		$sql = "select
					r.respuesta,
					p.pregunta,
					p.idpregunta
				from dbrespuestas r
				inner join dbpreguntas p on p.idpregunta = r.idpregunta
				inner join dbpostulantes pp on pp.token = r.token
				where pp.idpostulante = ".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function traerRespuestasPorPostulanteDetalle($id) {
		$sql = "select
					rd.valor,
						  (case when rd.respuesta = 1 then p.respuesta1
						  when rd.respuesta = 2 then p.respuesta2
								  when rd.respuesta = 3 then p.respuesta3
								  when rd.respuesta = 4 then p.respuesta4
								  when rd.respuesta = 5 then p.respuesta5
								  when rd.respuesta = 6 then p.respuesta6
								  when rd.respuesta = 7 then p.respuesta7
					end) as pregunta
				from dbrespuestas r
				inner join dbpreguntas p on p.idpregunta = r.idpregunta
				inner join dbpostulantes pp on pp.token = r.token
				inner join dbrespuestadetalles rd on rd.refrespuestas = r.idrespuesta
				where pp.idpostulante =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbrespuestadetalles*/

	/* PARA Entrevistasucursales */

	function insertarEntrevistasucursales($refpostal,$telefono,$interno,$domicilio) {
		$sql = "insert into tbentrevistasucursales(identrevistasucursal,refpostal,telefono,interno,domicilio)
		values ('',".$refpostal.",'".$telefono."','".$interno."','".$domicilio."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEntrevistasucursales($id,$refpostal,$telefono,$interno,$domicilio) {
		$sql = "update tbentrevistasucursales
		set
		refpostal = ".$refpostal.",telefono = '".$telefono."',interno = '".$interno."',domicilio = '".$domicilio."'
		where identrevistasucursal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEntrevistasucursales($id) {
		$sql = "delete from tbentrevistasucursales where identrevistasucursal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistasucursales() {
		$sql = "select
		e.identrevistasucursal,
		e.refpostal,
		e.telefono,
		e.interno,
		e.domicilio,
		p.codigo,
		p.colonia,
		p.municipio,
		p.estado
		from tbentrevistasucursales e
		inner join postal p on p.id = e.refpostal
		order by p.estado, p.municipio,p.colonia,p.codigo";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistasucursalesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where p.municipio like '%".$busqueda."%' or p.colonia like '%".$busqueda."%' or p.codigo like '%".$busqueda."%' or e.telefono like '%".$busqueda."%' or e.interno like '%".$busqueda."%' or e.domicilio like '%".$busqueda."%'";
		}

		$sql = "select
		e.identrevistasucursal,
		p.municipio,
		p.colonia,
		p.codigo,
		e.telefono,
		e.interno,
		e.domicilio,
		e.refpostal
		from tbentrevistasucursales e
		inner join postal p on p.id = e.refpostal
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traerEntrevistasucursalesPorPostal($id) {
		$sql = "select
		e.identrevistasucursal,
		e.refpostal,
		e.telefono,
		e.interno,
		e.domicilio,
		p.codigo,
		p.colonia,
		p.municipio,
		p.estado
		from tbentrevistasucursales e
		inner join postal p on p.id = e.refpostal
		where p.id = ".$id."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistasucursalesPorId($id) {
		$sql = "select identrevistasucursal,refpostal,telefono,interno,domicilio from tbentrevistasucursales where identrevistasucursal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasucursalesPorIdCompleto($id) {
		$sql = "select
		e.identrevistasucursal,
		e.refpostal,
		e.telefono,
		e.interno,
		e.domicilio,
		p.codigo,
		p.colonia,
		p.municipio,
		p.estado
		from tbentrevistasucursales e
		inner join postal p on p.id = e.refpostal
		where e.identrevistasucursal =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbentrevistasucursales*/

	function traerEsquemareclutamiento() {
		$sql = "select idesquemareclutamiento, esquema from tbesquemareclutamiento";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEsquemareclutamientoPorId($id) {
		$sql = "select idesquemareclutamiento, esquema from tbesquemareclutamiento where idesquemareclutamiento = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEsquemareclutamientoPorIn($in) {
		$sql = "select idesquemareclutamiento, esquema from tbesquemareclutamiento where idesquemareclutamiento in (".$id.")";
		$res = $this->query($sql,0);
		return $res;
	}

	/* PARA Ip */

	function existeIP($ip, $secuencia) {
		$sql = "select * from dbrespuestas where ip = '".$ip."' and secuencia = ".$secuencia;
		//die(var_dump($sql));
		$res = $this->query($sql,0);
		if (mysql_num_rows($res)>0) {
			return true;
		}

		return false;

	}

	function insertarIp($ip,$activo,$secuencia,$verde,$amarillo,$rojo,$respuesta,$idpregunta,$token) {

		if ($this->existeIP($ip,$secuencia)) {
			return '';
		} else {
			$sql = "insert into dbrespuestas(idrespuesta,ip,activo,secuencia,verde,amarillo,rojo,respuesta,idpregunta,token)
			values ('','".$ip."','".$activo."',".$secuencia.",'".$verde."','".$amarillo."','".$rojo."','".$respuesta."',".$idpregunta.",'".$token."')";
			$res = $this->query($sql,1);
			return $res;
		}

	}


	function modificarIp($idrespuesta,$ip,$activo,$secuencia,$verde,$amarillo,$rojo,$respuesta,$idpregunta) {
		$sql = "update dbrespuestas
		set
		ip = '".$ip."',activo = '".$activo."',secuencia = ".$secuencia.",verde = '".$verde."',amarillo = '".$amarillo."',rojo = '".$rojo."',respuesta = '".$respuesta."',idpregunta = ".$idpregunta."
		where idrespuesta =".$idrespuesta;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarIpActivo($ip,$activo) {
		$sql = "update dbrespuestas
		set
		activo = '0'
		where ip =".$ip;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarIp($idrespuesta) {
		$sql = "delete from dbrespuestas where idrespuesta =".$idrespuesta;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerIp() {
		$sql = "select
		i.idrespuesta,
		i.ip,
		i.activo,
		i.secuencia,
		i.verde,
		i.amarillo,
		i.rojo,
		i.respuesta,
		i.idpregunta,
		i.token
		from dbrespuestas i
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerIpPorId($idrespuesta) {
		$sql = "select idrespuesta,ip,activo,secuencia,verde,amarillo,rojo,respuesta,idpregunta,token from dbrespuestas where idrespuesta =".$idrespuesta;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerIpPorSecuenciaIP($secuencia, $idrespuesta) {
		$sql = "select idrespuesta,ip,activo,secuencia,verde,amarillo,rojo,respuesta,idpregunta,token from dbrespuestas where secuencia =".$secuencia." and idrespuesta = '".$idrespuesta."'";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerIpPorIP($ip) {
		$sql = "select idrespuesta,ip,activo,secuencia,verde,amarillo,rojo,respuesta,idpregunta,token from dbrespuestas where ip = '".$ip."'";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerIpPorIPultimo($ip) {
		$sql = "select idrespuesta,ip,activo,secuencia,verde,amarillo,rojo,respuesta,idpregunta,token from dbrespuestas where ip = '".$ip."' order by idrespuesta desc limit 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function determinaEstadoTest($token) {
		$sql = "SELECT
		    token, MAX(verde) as verde, MAX(amarillo) as amarillo, MAX(rojo) as rojo
		FROM
		    dbrespuestas
		WHERE
		    token = '".$token."'
		GROUP BY token";

		$res = $this->query($sql,0);

		$ar['datos'] = '';

		if (mysql_num_rows($res) > 0 ) {

			if (mysql_result($res,0,'rojo') == '1') {
				$ar['datos'] = array('respuesta' => 'salir', 'test' => 2, 'lbltest' => ('NO SE ADECÚA A LO QUE ESTÁS BUSCANDO'), 'color' => 'danger');
			} else {
				if (mysql_result($res,0,'amarillo') == '1') {
					$ar['datos'] = array('respuesta' => 'salir', 'test' => 1, 'lbltest' => ('NO PUEDE OFRECERTE UN SUELDO FIJO, SIN EMBARGO SE ADAPTA A TUS EXPECTATIVAS ECONÓMICAS'), 'color' => 'warning');
				} else {
					$ar['datos'] = array('respuesta' => 'salir', 'test' => 0, 'lbltest' => ('SE ADECÚA A LO QUE ESTÁS BUSCANDO'), 'color' => 'success');
				}
			}
		}
		return $ar['datos'];
	}


	/* Fin */
	/* /* Fin de la Tabla: tbip*/

	/* PARA Preguntas */

	function insertarPreguntas($secuencia,$pregunta,$respuesta1,$respuesta2,$respuesta3,$respuesta4,$respuesta5,$respuesta6,$respuesta7,$valor,$depende,$tiempo) {
		$sql = "insert into dbpreguntas(idpregunta,secuencia,pregunta,respuesta1,respuesta2,respuesta3,respuesta4,respuesta5,respuesta6,respuesta7,valor,depende,tiempo)
		values ('',".$secuencia.",'".$pregunta."','".$respuesta1."','".$respuesta2."','".$respuesta3."','".$respuesta4."','".$respuesta5."','".$respuesta6."','".$respuesta7."',".$valor.",".$depende.",".$tiempo.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPreguntas($id,$secuencia,$pregunta,$respuesta1,$respuesta2,$respuesta3,$respuesta4,$respuesta5,$respuesta6,$respuesta7,$valor,$depende,$tiempo) {
		$sql = "update dbpreguntas
		set
		secuencia = ".$secuencia.",pregunta = '".$pregunta."',respuesta1 = '".$respuesta1."',respuesta2 = '".$respuesta2."',respuesta3 = '".$respuesta3."',respuesta4 = '".$respuesta4."',respuesta5 = '".$respuesta5."',respuesta6 = '".$respuesta6."',respuesta7 = '".$respuesta7."',valor = ".$valor.",depende = ".$depende.",tiempo = ".$tiempo."
		where idpregunta =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarPreguntas($id) {
		$sql = "delete from dbpreguntas where idpregunta =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPreguntas() {
		$sql = "select
		p.idpregunta,
		p.secuencia,
		p.pregunta,
		p.respuesta1,
		p.respuesta2,
		p.respuesta3,
		p.respuesta4,
		p.respuesta5,
		p.respuesta6,
		p.respuesta7,
		p.valor,
		p.depende,
		p.tiempo
		from dbpreguntas p
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPreguntasPorId($id) {
		$sql = "select idpregunta,secuencia,pregunta,respuesta1,respuesta2,respuesta3,respuesta4,respuesta5,respuesta6,respuesta7,valor,depende,tiempo from dbpreguntas where idpregunta =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPreguntasPorSecuencia($secuencia) {
		$sql = "select idpregunta,secuencia,pregunta,respuesta1,respuesta2,
		coalesce(respuesta3,'') as respuesta3,
		coalesce(respuesta4,'') as respuesta4,
		coalesce(respuesta5,'') as respuesta5,
		coalesce(respuesta6,'') as respuesta6,
		coalesce(respuesta7,'') as respuesta7,
		valor,depende,tiempo
		from dbpreguntas where secuencia =".$secuencia;

		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbpreguntas*/


	/* PARA Estadoentrevistas */

	function insertarEstadoentrevistas($estadoentrevista) {
	$sql = "insert into tbestadoentrevistas(idestadoentrevista,estadoentrevista)
	values ('','".$estadoentrevista."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEstadoentrevistas($id,$estadoentrevista) {
	$sql = "update tbestadoentrevistas
	set
	estadoentrevista = '".$estadoentrevista."'
	where idestadoentrevista =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarEstadoentrevistas($id) {
	$sql = "delete from tbestadoentrevistas where idestadoentrevista =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadoentrevistas() {
	$sql = "select
	e.idestadoentrevista,
	e.estadoentrevista
	from tbestadoentrevistas e
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadoentrevistasPorId($id) {
	$sql = "select idestadoentrevista,estadoentrevista from tbestadoentrevistas where idestadoentrevista =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	function traerEstadoentrevistasPorIn($in) {
	$sql = "select
					idestadoentrevista,
					(case when idestadoentrevista = 3 then 'Re-Programado'
					 		when idestadoentrevista = 2 then 'Visitado con exito'
							when idestadoentrevista = 4 then 'Visitado sin exito'
							else estadoentrevista end) as estadoentrevista
			from tbestadoentrevistas where idestadoentrevista in (".$in.")";
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadoentrevistas*/


	function traerPostal() {
		$sql = "select
				p.id,
				p.codigo,
				p.colonia,
				p.municipio,
				p.estado
			from postal p
			order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPostalPorId($id) {
		$sql = "select
				p.id,
				p.codigo,
				p.colonia,
				p.municipio,
				p.estado
			from postal p
			where p.id = ".$id."
			order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function buscarPostal($busqueda) {
		$sql = "select
				p.id,
				p.codigo,
				p.colonia,
				p.municipio,
				p.estado
			from postal p
			where SUBSTRING(concat('00000', cast(p.codigo as UNSIGNED)),-5,5) like '%".$busqueda."%'
			order by p.codigo,p.estado,p.municipio,p.colonia
         limit 20";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir, $filtros, $consulta, $pre='') {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = str_replace("_busqueda",$busqueda,$filtros);
		} else {
			$where = $pre;
		}

		$sql = $consulta.' '.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0),$this->query($sql,0));
		return $res;
	}

	function ComboBoxSelect($tabla, $opcional) {

		switch ($tabla) {
			case 'EstadoCivil':
				$res	 = $this->traerEstadocivil();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			case 'RolHogar':
				$res	 = $this->traerRolhogar();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			case 'TipoClientes':
				$res	 = $this->traerTipoclientes();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			case 'EntidadNacimiento':
				$res	 = $this->traerEntidadnacimiento();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			default:
				$cad = '';
				break;

		}

		if ($opcional == 1) {
			$cad = '<option value="0">-- Seleccionar --</option>'.$cad;
		}

		return $cad;
	}

	function ComboBoxSelectActivo() {
		switch ($tabla) {
			case 'EstadoCivil':
				$res	 = $this->traerEstadocivil();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			case 'RolHogar':
				$res	 = $this->traerRolhogar();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			case 'TipoClientes':
				$res	 = $this->traerTipoclientes();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			case 'EntidadNacimiento':
				$res	 = $this->traerEntidadnacimiento();
				$cad	 =	$this->devolverSelectBox($res,array(1),'');
			break;
			default:
				$cad = '';
				break;

		}

		if ($opcional == 1) {
			$cad = '<option value="0">-- Seleccionar --</option>'.$cad;
		}

		return $cad;
	}

	function devolverSelectBox($datos, $ar, $delimitador) {

		$cad		= '';
		while ($rowTT = mysql_fetch_array($datos)) {
			$contenido	= '';
			foreach ($ar as $i) {
				$contenido .= $rowTT[$i].$delimitador;
			}
			$cad .= '<option value="'.$rowTT[0].'">'.utf8_encode(substr($contenido,0,strlen($contenido)-strlen($delimitador))).'</option>';
		}
		return $cad;
	}


	/* PARA Entrevistas */

	function insertarEntrevistas($refpostulantes,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadopostulantes,$refestadoentrevistas,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refentrevistasucursales) {
		$sql = "insert into dbentrevistas(identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi,refentrevistasucursales)
		values ('',".$refpostulantes.",'".$entrevistador."','".$fecha."','".$domicilio."',".$codigopostal.",".$refestadopostulantes.",".$refestadoentrevistas.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$refentrevistasucursales.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEntrevistas($id,$refpostulantes,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadopostulantes,$refestadoentrevistas,$fechamodi,$usuariomodi,$refentrevistasucursales) {
		$sql = "update dbentrevistas
		set
		refpostulantes = ".$refpostulantes.",entrevistador = '".$entrevistador."',fecha = '".$fecha."',domicilio = '".$domicilio."',codigopostal = ".$codigopostal.",refestadopostulantes = ".$refestadopostulantes.",refestadoentrevistas = ".$refestadoentrevistas.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."', refentrevistasucursales = ".$refentrevistasucursales."
		where identrevista =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarEntrevistas($id) {
		$sql = "delete from dbentrevistas where identrevista =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistas() {
		$sql = "select
		e.identrevista,
		e.refpostulantes,
		e.entrevistador,
		e.fecha,
		e.domicilio,
		e.codigopostal,
		e.refestadopostulantes,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistas e
		inner join dbpostulantes pos ON pos.idpostulante = e.refpostulantes
		inner join tbestadopostulantes ep ON ep.idestadopostulante = e.refestadopostulante
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasCalendar($refgerentecomercial) {

		if ($refgerentecomercial != 0) {

			$sql = "select
			e.identrevista,
			e.refpostulantes,
			concat('Entrevista ', ep.estadopostulante, ' con Postulante: ', pos.apellidopaterno, ' ', pos.apellidomaterno, ' ', pos.nombre) as title,
			concat('Entrevista ', ep.estadopostulante, ' con Postulante: ', pos.apellidopaterno, ' ', pos.apellidomaterno, ' ', pos.nombre, ' - Estado: ', est.estadoentrevista) as description,
			'#F5B041' as color,
			e.entrevistador,
			e.fecha as start,
			e.domicilio,
			e.codigopostal,
			e.refestadopostulantes,
			e.refestadoentrevistas,
			e.fechacrea,
			e.fechamodi,
			e.usuariocrea,
			e.usuariomodi,
			coalesce(usu.nombrecompleto, e.entrevistador) as nombrecompleto
			from dbentrevistas e
			inner join dbpostulantes pos ON pos.idpostulante = e.refpostulantes
			inner join dbreclutadorasores rc on rc.refpostulantes = pos.idpostulante
			inner join dbusuarios usu on usu.idusuario = rc.refusuarios
			inner join tbestadopostulantes ep ON ep.idestadopostulante = e.refestadopostulantes
			inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
			where usu.idusuario = ".$refgerentecomercial."
			order by 1";
		} else {
			$sql = "select
			e.identrevista,
			e.refpostulantes,
			concat('Entrevista ', ep.estadopostulante, ' con Postulante: ', pos.apellidopaterno, ' ', pos.apellidomaterno, ' ', pos.nombre) as title,
			concat('Entrevista ', ep.estadopostulante, ' con Postulante: ', pos.apellidopaterno, ' ', pos.apellidomaterno, ' ', pos.nombre, ' - Estado: ', est.estadoentrevista) as description,
			'#F5B041' as color,
			e.entrevistador,
			e.fecha as start,
			e.domicilio,
			e.codigopostal,
			e.refestadopostulantes,
			e.refestadoentrevistas,
			e.fechacrea,
			e.fechamodi,
			e.usuariocrea,
			e.usuariomodi,
			coalesce(usu.nombrecompleto, e.entrevistador) as nombrecompleto
			from dbentrevistas e
			inner join dbpostulantes pos ON pos.idpostulante = e.refpostulantes
			left join dbreclutadorasores rc on rc.refpostulantes = pos.idpostulante
			left join dbusuarios usu on usu.idusuario = rc.refusuarios
			inner join tbestadopostulantes ep ON ep.idestadopostulante = e.refestadopostulantes
			inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
			order by 1";
		}

		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistasCalendarPorUsuario($refusuarios) {
		$sql = "select
		e.identrevista,
		e.refpostulantes,
		concat('Entrevista ', ep.estadopostulante, ' con Postulante: ', pos.apellidopaterno, ' ', pos.apellidomaterno, ' ', pos.nombre) as title,
		concat('Entrevista ', ep.estadopostulante, ' con Postulante: ', pos.apellidopaterno, ' ', pos.apellidomaterno, ' ', pos.nombre, ' - Estado: ', est.estadoentrevista) as description,
		'#F5B041' as color,
		e.entrevistador,
		e.fecha as start,
		e.domicilio,
		e.codigopostal,
		e.refestadopostulantes,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,
		e.usuariocrea,
		e.usuariomodi
		from dbentrevistas e
		inner join dbpostulantes pos ON pos.idpostulante = e.refpostulantes
		inner join tbestadopostulantes ep ON ep.idestadopostulante = e.refestadopostulantes
		inner join tbestadoentrevistas est ON est.idestadoentrevista = e.refestadoentrevistas
		inner join dbreclutadorasores r on r.refpostulantes = pos.idpostulante
		where r.refusuarios = ".$refusuarios."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEntrevistasPorId($id) {
		$sql = "select identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi,refentrevistasucursales from dbentrevistas where identrevista =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasPorEstadoPostulante($idestadopostulante) {
		$sql = "select identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi from dbentrevistas where refestadopostulantes =".$idestadopostulante;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasPorPostulanteEstado($id,$idestadopostulante) {
		$sql = "select identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi from dbentrevistas where refpostulantes = ".$id." and refestadopostulantes =".$idestadopostulante;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasPorPostulante($idpostulante) {
		$sql = "select identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi from dbentrevistas where refpostulantes =".$idpostulante;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasPorEstado($idestado) {
		$sql = "select identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi from dbentrevistas where refestadoentrevistas =".$idestado;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEntrevistasActivasPorPostulanteEstadoPostulante($id,$idestadopostulante) {
		$sql = "select e.identrevista,
		e.refpostulantes,
		e.entrevistador,
		e.fecha,
		e.domicilio,
		coalesce( pp.codigo, e.codigopostal) as codigopostal,
		e.refestadopostulantes,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,e.usuariocrea,e.usuariomodi,
		concat(pp.estado, ' ', pp.municipio, ' ', pp.colonia, ' ', pp.codigo) as postalcompleto,
		est.estadoentrevista
		from dbentrevistas e
		left join tbentrevistasucursales et on et.identrevistasucursal = e.refentrevistasucursales
		left join postal pp on pp.id = et.refpostal
		inner join tbestadoentrevistas est on est.idestadoentrevista = e.refestadoentrevistas
		where e.refestadopostulantes = ".$idestadopostulante." and e.refestadoentrevistas in (1,2,3) and e.refpostulantes =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbentrevistas*/


	/* PARA Escolaridades */

	function insertarEscolaridades($escolaridad) {
	$sql = "insert into tbescolaridades(idescolaridad,escolaridad)
	values ('','".$escolaridad."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEscolaridades($id,$escolaridad) {
	$sql = "update tbescolaridades
	set
	escolaridad = '".$escolaridad."'
	where idescolaridad =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarEscolaridades($id) {
	$sql = "delete from tbescolaridades where idescolaridad =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEscolaridades() {
	$sql = "select
	e.idescolaridad,
	e.escolaridad
	from tbescolaridades e
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEscolaridadesPorId($id) {
	$sql = "select idescolaridad,escolaridad from tbescolaridades where idescolaridad =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbescolaridades*/


	/* PARA Estadopostulantes */

	function insertarEstadopostulantes($estadopostulante,$orden,$url) {
	$sql = "insert into tbestadopostulantes(idestadopostulante,estadopostulante,orden,url)
	values ('','".$estadopostulante."',".$orden.",'".$url."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEstadopostulantes($id,$estadopostulante,$orden,$url) {
	$sql = "update tbestadopostulantes
	set
	estadopostulante = '".$estadopostulante."',orden = ".$orden.",url = '".$url."'
	where idestadopostulante =".$id;
	$res = $this->query($sql,0);
	return $res;
	}



	function eliminarEstadopostulantes($id) {
	$sql = "delete from tbestadopostulantes where idestadopostulante =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadopostulantes() {
		$sql = "select
		e.idestadopostulante,
		e.estadopostulante,
		e.orden,
		e.url
		from tbestadopostulantes e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEstadopostulantesEtapas($id) {
		$sql = "SELECT
			    e.idestadopostulante, e.estadopostulante, e.orden, e.url
			FROM
			    tbestadopostulantes e
			    where e.orden = (SELECT
			    orden
			FROM
			    tbestadopostulantes where idestadopostulante = ".$id.") + 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerEstadopostulantesPorId($id) {
		$sql = "select idestadopostulante,estadopostulante,orden,url from tbestadopostulantes where idestadopostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEstadopostulantesPorOrden($orden) {
		$sql = "select idestadopostulante,estadopostulante,orden,url from tbestadopostulantes where orden =".$orden;
		$res = $this->query($sql,0);
		return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbestadopostulantes*/


	/* PARA Postulantes */

	function insertarPostulantes($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$refesquemareclutamiento,$afore,$folio,$cedula,$token,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesdeafore,$vighastaafore,$reftipopersonas,$razonsocial,$reforigenreclutamiento,$email2,$vigdesderc,$vighastarc,$observaciones, $refreferentes) {
		$sql = "insert into dbpostulantes(idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,refestadocivil,nacionalidad,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa,ultimoestado,refesquemareclutamiento,afore,folio,cedula,token,vigdesdecedulaseguro,vighastacedulaseguro,vigdesdeafore,vighastaafore,reftipopersonas,razonsocial,reforigenreclutamiento,email2,vigdesderc,vighastarc, observaciones, refreferentes)
		values ('',".$refusuarios.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$curp."','".$rfc."','".$ine."','".$fechanacimiento."','".$sexo."','".$codigopostal."',".$refescolaridades.",".$refestadocivil.",'".$nacionalidad."','".$telefonomovil."','".$telefonocasa."','".$telefonotrabajo."',".$refestadopostulantes.",'".$urlprueba."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$refasesores.",".$comision.",".$refsucursalesinbursa.",".$ultimoestado.",".$refesquemareclutamiento.",'".$afore."','".$folio."','".$cedula."','".$token."',".($vigdesdecedulaseguro == '' ? 'null' : "'".$vigdesdecedulaseguro."'").",".($vighastacedulaseguro == '' ? 'null' : "'".$vighastacedulaseguro."'").",".($vigdesdeafore == '' ? 'null' : "'".$vigdesdeafore."'").",".($vighastaafore == '' ? 'null' : "'".$vighastaafore."'").",".$reftipopersonas.",'".$razonsocial."',".$reforigenreclutamiento.",'".$email2."',".($vigdesderc == '' ? 'null' : "'".$vigdesderc."'").",".($vighastarc == '' ? 'null' : "'".$vighastarc."'").",'".$observaciones."',".$refreferentes.")";

		//die(var_dump($sql));
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPostulantes($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$nss,$refesquemareclutamiento,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesdeafore,$vighastaafore,$nropoliza,$razonsocial,$reforigenreclutamiento,$email2,$vigdesderc,$vighastarc,$observaciones,$refreferentes) {
		$sql = "update dbpostulantes
		set
		refusuarios = ".$refusuarios.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',curp = '".$curp."',rfc = '".$rfc."',ine = '".$ine."',fechanacimiento = '".$fechanacimiento."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',refescolaridades = ".$refescolaridades.",refestadocivil = ".$refestadocivil.",nacionalidad = '".$nacionalidad."',telefonomovil = '".$telefonomovil."',telefonocasa = '".$telefonocasa."',telefonotrabajo = '".$telefonotrabajo."',refestadopostulantes = ".$refestadopostulantes.",urlprueba = '".$urlprueba."',fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."',refasesores = ".$refasesores.",comision = ".$comision.",refsucursalesinbursa = ".$refsucursalesinbursa.",ultimoestado = ".$ultimoestado.",nss = '".$nss."',refesquemareclutamiento = ".$refesquemareclutamiento.",claveinterbancaria = '".$claveinterbancaria."',idclienteinbursa = '".$idclienteinbursa."',claveasesor = '".$claveasesor."',fechaalta = ".($fechaalta == '' ? 'null' : "'".$fechaalta."'").",vigdesdecedulaseguro = ".($vigdesdecedulaseguro == '' ? 'null' : "'".$vigdesdecedulaseguro."'").",vighastacedulaseguro = ".($vighastacedulaseguro == '' ? 'null' : "'".$vighastacedulaseguro."'").",vigdesdeafore = ".($vigdesdeafore == '' ? 'null' : "'".$vigdesdeafore."'").",vighastaafore = ".($vighastaafore == '' ? 'null' : "'".$vighastaafore."'").",nropoliza = '".$nropoliza."',razonsocial = '".$razonsocial."',reforigenreclutamiento = ".$reforigenreclutamiento.",email2 = '".$email2."',vigdesderc = ".($vigdesderc == '' ? 'null' : "'".$vigdesderc."'").",vighastarc = ".($vighastarc == '' ? 'null' : "'".$vighastarc."'").",observaciones = '".$observaciones."', refreferentes = ".$refreferentes." where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarURLpostulante($id, $urlprueba, $fechamodi, $usuariomodi) {
		$sql = "update dbpostulantes
		set
		urlprueba = '".$urlprueba."',fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."'
		where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarPostulanteUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbpostulantes
		set
		".$campo." = '".$valor."', fechamodi = '".date('Y-m-d H:i:s')."'
		where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarPostulantes($id) {
		$sql = "update dbpostulantes set refestadopostulantes= 9 where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarPostulantesDefinitivo($id) {
		$sql = "delete from dbpostulantes where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPostulantePorToken($token) {
		$sql = "SELECT
			p.idpostulante,
			p.refusuarios,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.curp,
			p.rfc,
			p.ine,
			p.fechanacimiento,
			p.sexo,
			p.codigopostal,
			p.refescolaridades,
			p.telefonomovil,
			p.telefonocasa,
			p.telefonotrabajo,
			p.refestadopostulantes,
			p.urlprueba,
			p.fechacrea,
			p.fechamodi,
			p.usuariocrea,
			p.usuariomodi,
			p.refasesores,
			p.comision,
			p.refsucursalesinbursa,
			p.refestadocivil,
			p.refesquemareclutamiento,
			p.afore,
			p.cedula,
			p.folio,
			est.estadopostulante,
			p.nss,
			p.reforigenreclutamiento,
			p.email2
		FROM
			dbpostulantes p
			left JOIN
	   postal cp ON cp.id = p.codigopostal
			INNER JOIN
		tbestadopostulantes est ON est.idestadopostulante = p.refestadopostulantes
		WHERE
			token = '".$token."'
		";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerPostulantesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where p.nombre like '%".$busqueda."%' or p.apellidopaterno like '%".$busqueda."%' or p.apellidomaterno like '%".$busqueda."%' or p.email like '%".$busqueda."%' or p.telefonomovil like '%".$busqueda."%' or ep.estadopostulante like '%".$busqueda."%' or est.estadocivil like '%".$busqueda."%' or DATE_FORMAT( p.fechacrea, '%Y-%m-%d') like '%".$busqueda."%'";
		}

		$sql = "select
			p.idpostulante,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.telefonomovil,
			ep.estadopostulante,
			est.estadocivil,
			p.fechacrea,
			p.curp,
			p.rfc,
			p.ine,
			p.fechanacimiento,
			p.sexo,
			p.codigopostal,
			p.refescolaridades,
			p.refestadocivil,
			p.nacionalidad,
			p.telefonocasa,
			p.telefonotrabajo,
			p.refestadopostulantes,
			p.urlprueba,
			p.fechamodi,
			p.usuariocrea,
			p.usuariomodi,
			p.refasesores,
			p.comision,
			p.refusuarios,
			p.refsucursalesinbursa,
			p.nss,
			p.reforigenreclutamiento,
			p.email2
		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes
		left join tbreferentes rr on rr.idreferente = p.refreferentes
		".$where."
		ORDER BY ".$colSort." ".$colSortDir."
		limit ".$start.",".$length;

		$res = $this->query($sql,0);
		return $res;
	}

	function traerPostulantes() {
		$sql = "select
			p.idpostulante,
			p.refusuarios,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.curp,
			p.rfc,
			p.ine,
			p.fechanacimiento,
			p.sexo,
			p.codigopostal,
			p.refescolaridades,
			p.refestadocivil,
			p.nacionalidad,
			p.telefonomovil,
			p.telefonocasa,
			p.telefonotrabajo,
			p.refestadopostulantes,
			p.urlprueba,
			p.fechacrea,
			p.fechamodi,
			p.usuariocrea,
			p.usuariomodi,
			p.refasesores,
			p.comision,
			p.refsucursalesinbursa,
			p.nss,
			p.reforigenreclutamiento,
			p.email2
		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes
		order by p.apellidopaterno,
      p.apellidomaterno,
      p.nombre";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPostulantesPorGerente($id) {
		$sql = "select
			p.idpostulante,
			p.refusuarios,
			p.nombre,
			p.apellidopaterno,
			p.apellidomaterno,
			p.email,
			p.curp,
			p.rfc,
			p.ine,
			p.fechanacimiento,
			p.sexo,
			p.codigopostal,
			p.refescolaridades,
			p.refestadocivil,
			p.nacionalidad,
			p.telefonomovil,
			p.telefonocasa,
			p.telefonotrabajo,
			p.refestadopostulantes,
			p.urlprueba,
			p.fechacrea,
			p.fechamodi,
			p.usuariocrea,
			p.usuariomodi,
			p.refasesores,
			p.comision,
			p.refsucursalesinbursa,
			p.nss,
			p.reforigenreclutamiento,
			p.email2
		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes
		inner join dbreclutadorasores r on r.refpostulantes = p.idpostulante and r.refusuarios = ".$id."
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPostulantesPorId($id) {
		$sql = "select idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa, refestadocivil,nss,afore,cedula,folio,refesquemareclutamiento,
		datediff(now(),fechanacimiento)/365 as edad, fechaalta, observaciones, ultimoestado, nropoliza, vighastaafore, vigdesdeafore, vigdesdecedulaseguro,vighastacedulaseguro,reftipopersonas,razonsocial,reforigenreclutamiento,email2,vigdesderc,vighastarc,refreferentes from dbpostulantes where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function agregarObservacionPostulante($id, $observaciones) {
		$sql = "update dbpostulantes set observaciones = '".$observaciones."' where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPostulantesPorIdUsuario($idusuario) {
		$sql = "select idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa, refestadocivil,nss,afore,cedula,folio,refesquemareclutamiento,
		datediff(now(),fechanacimiento)/365 as edad, fechaalta, observaciones, ultimoestado, nropoliza, vighastaafore, vigdesdeafore, vigdesdecedulaseguro,vighastacedulaseguro,reftipopersonas,razonsocial,reforigenreclutamiento,email2,vigdesderc,vighastarc,refreferentes from dbpostulantes where refusuarios =".$idusuario;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoPostulante($id,$idestado) {
		$sql = 'update dbpostulantes set refestadopostulantes = '.$idestado.' where idpostulante = '.$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarUltimoEstadoPostulante($id,$idestado) {

		//$resEstado = $this->traerEstadopostulantesPorId($idestado);

		$resultado = $this->traerPostulantesPorId($id);
		$refesquemareclutamiento  = mysql_result($resultado,0,'refesquemareclutamiento');

		$resEstado = $this->traerGuiasPorEsquemaSiguiente($refesquemareclutamiento, $idestado);

		$sql = 'update dbpostulantes set ultimoestado = '.mysql_result($resEstado,0,'refestadopostulantes').' where idpostulante = '.$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoEntrevista($id,$idestado) {
		$sql = 'update dbentrevistas set refestadoentrevistas = '.$idestado.' where identrevista = '.$id;
		$res = $this->query($sql,0);
		return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbpostulantes*/



	/* PARA Documentacionasesores */

	function insertarDocumentacionasesores($refpostulantes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionasesores(iddocumentacionasesor,refpostulantes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refpostulantes.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionasesores($id,$refpostulantes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbdocumentacionasesores
		set
		refpostulantes = ".$refpostulantes.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionPostulante($id, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionasesores
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where iddocumentacionasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoDocumentacionPostulantePorDocumentacion($iddocumentacion,$idpostulante, $refestadodocumentaciones,$usuariomodi) {
		$sql = "update dbdocumentacionasesores
		set
		refestadodocumentaciones = ".$refestadodocumentaciones.",fechamodi = '".date('Y-m-d H:i:s')."',usuariomodi = '".$usuariomodi."'
		where refdocumentaciones =".$iddocumentacion." and refpostulantes =".$idpostulante;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentacionasesores($id) {
		$sql = "delete from dbdocumentacionasesores where iddocumentacionasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresPorPostulanteDocumentacion($idpostulante,$iddocumentacion) {
		$sql = "delete from dbdocumentacionasesores where refpostulantes =".$idpostulante." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionasesoresPorPostulanteDocumentacionEspecifico($idpostulante,$iddocumentacion, $archivo) {
		$sql = "delete from dbdocumentacionasesores where refpostulantes =".$idpostulante." and refdocumentaciones = ".$iddocumentacion." and archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function eliminarDocumentacionPostulante($idpostulante,$iddocumentacion) {
		/*** auditoria ****/

		/*** fin auditoria ***/

		$resFoto = $this->traerDocumentacionPorPostulanteDocumentacion($idpostulante,$iddocumentacion);

		$imagen = '';

      if (mysql_num_rows($resFoto) > 0) {
         /* produccion
         $imagen = 'https://www.saupureinconsulting.com.ar/aifzn/'.mysql_result($resFoto,0,'archivo').'/'.mysql_result($resFoto,0,'imagen');
         */

         //desarrollo



         if (mysql_result($resFoto,0,'type') == '') {

            $resV['error'] = true;
				$resV['leyenda'] = 'Archivo perdido';
         } else {
            switch ($iddocumentacion) {
               case 2:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/siap/';
               break;
               case 1:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/veritas/';
               break;
					case 3:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/inef/';
               break;
					case 4:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/ined/';
               break;
					case 5:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/actanacimiento/';
               break;
					case 6:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/curp/';
               break;
					case 7:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/rfc/';
               break;
					case 8:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/nss/';
               break;
					case 9:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/comprobanteestudio/';
               break;
					case 10:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/comprobantedomicilio/';
               break;
					case 11:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/cv/';
               break;
					case 12:
                  $archivos = '../archivos/postulantes/'.$idpostulante.'/infonavit/';
               break;
            }

            $resBorrar = $this->borrarDirecctorio($archivos);

				$resUpdate = $this->eliminarDocumentacionasesores(mysql_result($resFoto,0,'iddocumentacionasesor'));

            $resV['error'] = false;
				$resV['leyenda'] = 'Archivo eliminado correctamente';
         }



      } else {
         $resV['error'] = true;
			$resV['leyenda'] = 'Archivo no encontrado';
      }

		return $resV;

	}


	function traerDocumentacionasesores() {
		$sql = "select
		d.iddocumentacionasesor,
		d.refpostulantes,
		d.refdocumentaciones,
		d.archivo,
		d.type,
		d.refestadodocumentaciones,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentacionasesores d
		inner join dbpostulantes ase ON ase.idpostulante = d.refpostulantes
		inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
		inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
		inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerDocumentacionasesoresPorId($id) {
		$sql = "select iddocumentacionasesor,refpostulantes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionasesores where iddocumentacionasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPostulanteDocumentacion($id, $iddocumentacion) {
		$sql = "select
		da.iddocumentacionasesor,da.refpostulantes,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, d.carpeta
		from dbdocumentacionasesores da
		inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refpostulantes =".$id." and da.refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPostulanteDocumentacionPostulante($id) {
		$sql = "select
		da.iddocumentacionasesor,da.refpostulantes,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color, dd.carpeta
		from dbdocumentacionasesores da
		inner join dbdocumentaciones dd on dd.iddocumentacion = da.refdocumentaciones
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refpostulantes =".$id." and dd.orden is not null order by dd.orden,da.archivo";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPostulanteDocumentacionEspecifica($id, $iddocumentacion, $archivo) {
		$sql = "select
		da.iddocumentacionasesor,da.refpostulantes,da.refdocumentaciones,
		da.archivo,da.type,da.refestadodocumentaciones,da.fechacrea,da.fechamodi,
		da.usuariocrea,da.usuariomodi , e.estadodocumentacion, e.color
		from dbdocumentacionasesores da
		inner join tbestadodocumentaciones e on e.idestadodocumentacion = da.refestadodocumentaciones
		where da.refpostulantes =".$id." and da.refdocumentaciones = ".$iddocumentacion." and da.archivo like '%".$archivo."%'";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerDocumentacionPorPostulanteDocumentacionCompleta($idpostulante, $idestado) {

		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionasesor,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion,
						 d.carpeta
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionasesores da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refpostulantes = ".$idpostulante."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
						 	  inner join
						 dbesquemadocumentosestados ede on ede.refdocumentaciones = d.iddocumentacion
						 and ede.refesquemareclutamiento = (select refesquemareclutamiento from dbpostulantes where idpostulante = ".$idpostulante.") and ede.refestadopostulantes = ".$idestado."
						 inner
						 join dbpostulantes pp on pp.idpostulante = ".$idpostulante."
						 left
						 join dbexcluyedocumentaciones exd
						 on exd.refdocumentaciones = d.iddocumentacion
						 and exd.refesquemareclutamiento = ede.refesquemareclutamiento
						 and exd.reforigenreclutamiento = pp.reforigenreclutamiento
						 where exd.idexcluyedocumentacion is null

					order by 1";


		$res = $this->query($sql,0);
 		return $res;
	}


	function traerDocumentacionPorPostulanteDocumentacionCompleta2($idpostulante) {
		$sql = "SELECT
					    d.iddocumentacion,
					    d.documentacion,
					    d.obligatoria,
					    da.iddocumentacionasesor,
					    da.archivo,
					    da.type,
					    coalesce( ed.estadodocumentacion, 'Falta') as estadodocumentacion,
						 ed.color,
					    ed.idestadodocumentacion
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionasesores da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refpostulantes = ".$idpostulante."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					WHERE
					    d.iddocumentacion IN (13 , 14, 15, 16, 17, 18, 19, 20, 21, 22,23,24,25)
					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function presentarDocumentacionI($id) {
		$sql = "update dbdocumentacionasesores da
					inner join dbpostulantes p on p.idpostulante = da.refpostulantes
					inner join dbesquemadocumentosestados ese on ese.refdocumentaciones = da.refdocumentaciones
					and ese.refesquemareclutamiento = p.refesquemareclutamiento and ese.refestadopostulantes = 7
				set da.refestadodocumentaciones = 7
				where da.refpostulantes = ".$id." and da.refestadodocumentaciones = 1";

		$res = $this->query($sql,0);
 		return $res;
	}


	function permitePresentarDocumentacionI($idpostulante) {

		$apruebaSegundo = 0;

		$count = 0;

		$sqlcount = "SELECT
						COUNT(*) AS cantidad
					FROM
						dbpostulantes p
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento and p.idpostulante = ".$idpostulante."
						inner join dbdocumentaciones d on d.iddocumentacion = ese.refdocumentaciones
					WHERE
						ese.refestadopostulantes in (7)
						and d.obligatoria = '1'";
		$resCount = $this->query($sqlcount,0);

		$count = mysql_result($resCount,0,0);

		// compruebo que haya cargado las documentaciones
		$sqlSegundo = "SELECT
						COUNT(*) AS documentacionesaceptadas
					FROM
						dbdocumentacionasesores da
						inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
						inner join dbpostulantes p on p.idpostulante = da.refpostulantes
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento
						and ese.refdocumentaciones = d.iddocumentacion
					WHERE
						da.refpostulantes = ".$idpostulante."
						AND ese.refestadopostulantes in (7)
						and d.obligatoria = '1'
						AND da.refestadodocumentaciones in (1)";

		$resSegundo = $this->query($sqlSegundo,0);

  		if (mysql_num_rows($resSegundo) > 0) {
			$countSegundo = mysql_result($resSegundo,0,0);
			if (mysql_result($resSegundo,0,0) == $count) {
				$apruebaSegundo = 1;
			}
  		}


		// compruebo que haya cargado las documentaciones aceptadas
		$sqlTercero = "SELECT
						COUNT(*) AS documentacionesaceptadas
					FROM
						dbdocumentacionasesores da
						inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
						inner join dbpostulantes p on p.idpostulante = da.refpostulantes
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento
						and ese.refdocumentaciones = d.iddocumentacion
					WHERE
						da.refpostulantes = ".$idpostulante."
						AND ese.refestadopostulantes in (7)
						and d.obligatoria = '1'
						AND da.refestadodocumentaciones in (5,6)";

		$resTercero = $this->query($sqlTercero,0);

		$countTercero = mysql_result($resTercero,0,0);
		// compruebo que haya cargado las archivos de las documentaciones
		// falta

		if (($apruebaSegundo == 1) || (($countSegundo > 0) && ($countTercero > 0))) {
			return true;
		} else {
			return false;
		}

	}

	function permiteAvanzarDocumentacionI($idpostulante) {
		$apruebaPrimero = 0;
		$apruebaSegundo = 0;

		$count = 0;

		$sqlcount = "SELECT
						COUNT(*) AS cantidad
					FROM
						dbpostulantes p
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento and p.idpostulante = ".$idpostulante."
						inner join dbdocumentaciones d on d.iddocumentacion = ese.refdocumentaciones
					WHERE
						ese.refestadopostulantes in (7)
						and d.obligatoria = '1'";
		$resCount = $this->query($sqlcount,0);

		$count = mysql_result($resCount,0,0);

		// compruebo que haya cargado los datos en postulantes
		$sqlPrimero = "SELECT
				    p.idpostulante
				FROM
				    dbpostulantes p
				WHERE
				    p.idpostulante = ".$idpostulante." AND ine <> ''
				        AND curp <> '' and rfc <> '' and nss <> ''";

		$resPrimero = $this->query($sqlPrimero,0);

		if (mysql_num_rows($resPrimero) > 0) {
			$apruebaPrimero = 1;
		}

		// compruebo que haya cargado las documentaciones
		$sqlSegundo = "SELECT
						COUNT(*) AS documentacionesaceptadas
					FROM
						dbdocumentacionasesores da
						inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
						inner join dbpostulantes p on p.idpostulante = da.refpostulantes
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento
						and ese.refdocumentaciones = d.iddocumentacion
					WHERE
						da.refpostulantes = ".$idpostulante."
						AND ese.refestadopostulantes in (7)
						and d.obligatoria = '1'
						AND da.refestadodocumentaciones in (5,6)";

		$resSegundo = $this->query($sqlSegundo,0);

  		if (mysql_num_rows($resSegundo) > 0) {
			if (mysql_result($resSegundo,0,0) == $count) {
				$apruebaSegundo = 1;
			}
  		}

		// compruebo que haya cargado las archivos de las documentaciones
		// falta

		if (($apruebaPrimero == 1) && ($apruebaSegundo == 1)) {
			return true;
		} else {
			return false;
		}

	}


	function permiteAvanzarDocumentacionIII($idpostulante) {
		$apruebaPrimero = 0;
		$apruebaSegundo = 0;

		$count = 0;

      $resPostulante = $this->traerPostulantesPorId($idpostulante);




		// compruebo que haya cargado los datos en postulantes
		$sqlPrimero = "SELECT
				    p.idpostulante
				FROM
				    dbpostulantes p
				WHERE
				    p.idpostulante = ".$idpostulante." AND ine <> ''
				        and rfc <> ''
						  and claveinterbancaria <> ''
						  and idclienteinbursa <> ''
						  and claveasesor <> ''
						  and fechaalta <> ''";

		$resPrimero = $this->query($sqlPrimero,0);

		if (mysql_num_rows($resPrimero) > 0) {
			$apruebaPrimero = 1;
		}


      // si es origende javelly descarto codigo etica, carta laborar en gobierno, contrato firma 3, formato firma y carta consar
      if (mysql_result($resPostulante,0,'reforigenreclutamiento') == 2) {
         $sqlcount = "SELECT
   						COUNT(*) AS cantidad
   					FROM
   						dbpostulantes p
   						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento and p.idpostulante = ".$idpostulante."
   						inner join dbdocumentaciones d on d.iddocumentacion = ese.refdocumentaciones
   					WHERE
   						ese.refestadopostulantes in (8)
                     and d.iddocumentacion not in (17,18,15,16,24)
   						and d.obligatoria = '1'";
   		$resCount = $this->query($sqlcount,0);

   		$count = mysql_result($resCount,0,0);


   		// compruebo que haya cargado las documentaciones
   		$sqlSegundo = "SELECT
   						COUNT(*) AS documentacionesaceptadas
   					FROM
   						dbdocumentacionasesores da
   						inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
   						inner join dbpostulantes p on p.idpostulante = da.refpostulantes
   						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento
   						and ese.refdocumentaciones = d.iddocumentacion
   					WHERE
   						da.refpostulantes = ".$idpostulante."
   						AND ese.refestadopostulantes in (8)
   						and d.obligatoria = '1'
                     and d.iddocumentacion not in (17,18,15,16,24)
   						AND da.refestadodocumentaciones in (5,6)";

   		$resSegundo = $this->query($sqlSegundo,0);

     		if (mysql_num_rows($resSegundo) > 0) {
   			if (mysql_result($resSegundo,0,0) >= $count) {
   				$apruebaSegundo = 1;
   			}
     		}

      } else {
         $sqlcount = "SELECT
   						COUNT(*) AS cantidad
   					FROM
   						dbpostulantes p
   						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento and p.idpostulante = ".$idpostulante."
   						inner join dbdocumentaciones d on d.iddocumentacion = ese.refdocumentaciones
   					WHERE
   						ese.refestadopostulantes in (8)
   						and d.obligatoria = '1'";
   		$resCount = $this->query($sqlcount,0);

   		$count = mysql_result($resCount,0,0);


   		// compruebo que haya cargado las documentaciones
   		$sqlSegundo = "SELECT
   						COUNT(*) AS documentacionesaceptadas
   					FROM
   						dbdocumentacionasesores da
   						inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
   						inner join dbpostulantes p on p.idpostulante = da.refpostulantes
   						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento
   						and ese.refdocumentaciones = d.iddocumentacion
   					WHERE
   						da.refpostulantes = ".$idpostulante."
   						AND ese.refestadopostulantes in (8)
   						and d.obligatoria = '1'
   						AND da.refestadodocumentaciones in (5,6)";

   		$resSegundo = $this->query($sqlSegundo,0);

     		if (mysql_num_rows($resSegundo) > 0) {
   			if (mysql_result($resSegundo,0,0) >= $count) {
   				$apruebaSegundo = 1;
   			}
     		}
      }



		// compruebo que haya cargado las archivos de las documentaciones
		// falta

		if (($apruebaPrimero == 1) && ($apruebaSegundo == 1)) {
			return true;
		} else {
			return false;
		}

	}


	function permiteAvanzarDocumentacionII($idpostulante) {
		$apruebaPrimero = 0;
		$apruebaSegundo = 0;

		$count = 0;

		$sqlcount = "SELECT
						COUNT(*) AS cantidad
					FROM
						dbpostulantes p
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento and p.idpostulante = ".$idpostulante."
						inner join dbdocumentaciones d on d.iddocumentacion = ese.refdocumentaciones
					WHERE
						ese.refestadopostulantes in (8)
						and d.obligatoria = '1'";
		$resCount = $this->query($sqlcount,0);

		$count = mysql_result($resCount,0,0);

		// compruebo que haya cargado los datos en postulantes
		$apruebaPrimero = 1;

		// compruebo que haya cargado las documentaciones
		$sqlSegundo = "SELECT
						COUNT(*) AS documentacionesaceptadas
					FROM
						dbdocumentacionasesores da
						inner join dbdocumentaciones d on d.iddocumentacion = da.refdocumentaciones
						inner join dbpostulantes p on p.idpostulante = da.refpostulantes
						inner join dbesquemadocumentosestados ese on ese.refesquemareclutamiento = p.refesquemareclutamiento
						and ese.refdocumentaciones = d.iddocumentacion
					WHERE
						da.refpostulantes = ".$idpostulante."
						AND ese.refestadopostulantes in (8)
						and d.obligatoria = '1'
						AND da.refestadodocumentaciones in (5,6)";

		$resSegundo = $this->query($sqlSegundo,0);

  		if (mysql_num_rows($resSegundo) > 0) {
			if (mysql_result($resSegundo,0,0) >= $count) {
				$apruebaSegundo = 1;
			}
  		}

		// compruebo que haya cargado las archivos de las documentaciones
		// falta

		if (($apruebaPrimero == 1) && ($apruebaSegundo == 1)) {
			return true;
		} else {
			return false;
		}

	}

	/* Fin */
	/* /* Fin de la Tabla: dbdocumentacionasesores*/


	/* PARA Documentaciones */

   function insertarDocumentaciones($reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$orden,$carpeta,$activo,$refprocesocotizacion,$leyenda) {
      $sql = "insert into dbdocumentaciones(iddocumentacion,reftipodocumentaciones,documentacion,obligatoria,cantidadarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi,orden,carpeta,activo,refprocesocotizacion,leyenda)
      values ('',".$reftipodocumentaciones.",'".$documentacion."','".$obligatoria."',".$cantidadarchivos.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$orden.",'".$carpeta."','".$activo."',".$refprocesocotizacion.",'".$leyenda."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarDocumentaciones($id,$reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$orden,$carpeta,$activo,$refprocesocotizacion,$leyenda) {
      $sql = "update dbdocumentaciones
      set
      reftipodocumentaciones = ".$reftipodocumentaciones.",documentacion = '".$documentacion."',obligatoria = '".$obligatoria."',cantidadarchivos = ".$cantidadarchivos.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."',orden = ".$orden.",carpeta = '".$carpeta."',activo = '".$activo."',refprocesocotizacion = ".$refprocesocotizacion.",leyenda = '".$leyenda."'
      where iddocumentacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


	function eliminarDocumentaciones($id) {
		$sql = "update dbdocumentaciones set activo = '0' where iddocumentacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerDocumentacionesajax($length, $start, $busqueda,$colSort,$colSortDir,$proceso,$tipodocumentacion) {

		$where = '';

      $cadProceso = '';
      if ($proceso != '') {
         $cadProceso = " and tc.idprocesocotizacion = ".$proceso." ";
      }

      $cadTipodocumentacion = '';
      if ($tipodocumentacion != '') {
         $cadTipodocumentacion = " and d.reftipodocumentaciones = ".$tipodocumentacion." ";
      }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and tip.tipodocumentacion like '%".$busqueda."%' or d.documentacion like '%".$busqueda."%'";
		}

		$sql = "select
      d.iddocumentacion,
      tip.tipodocumentacion,
		d.documentacion,
		(case when d.obligatoria = '1' then 'Si' else 'No' end) as obligatoria,
      d.orden,
      (case when d.activo = '1' then 'Si' else 'No' end) as activo,
      tc.procesocotizacion,
      d.cantidadarchivos,
		d.fechacrea,
      d.carpeta,
		d.fechamodi,
		d.usuariocrea,
      d.reftipodocumentaciones,
		d.usuariomodi
		from dbdocumentaciones d
		inner join tbtipodocumentaciones tip ON tip.idtipodocumentacion = d.reftipodocumentaciones
      left join tbprocesocotizacion tc on tc.idprocesocotizacion = d.refprocesocotizacion
		where d.reftipodocumentaciones > 4 ".$cadProceso.$cadTipodocumentacion.$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerDocumentaciones() {
		$sql = "select
		d.iddocumentacion,
		d.reftipodocumentaciones,
		d.documentacion,
		d.obligatoria,
		d.cantidadarchivos,
		d.fechacrea,
		d.fechamodi,
		d.usuariocrea,
		d.usuariomodi
		from dbdocumentaciones d
		inner join tbtipodocumentaciones tip ON tip.idtipodocumentacion = d.reftipodocumentaciones
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerDocumentacionesPorId($id) {
      $sql = "select iddocumentacion,reftipodocumentaciones,documentacion,obligatoria,cantidadarchivos,
      fechacrea,fechamodi,usuariocrea,usuariomodi,orden,carpeta,activo,refprocesocotizacion,leyenda
      from dbdocumentaciones where iddocumentacion =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

	/* Fin */
	/* /* Fin de la Tabla: dbdocumentaciones*/


   /* PARA Tipodocumentaciones */

   function insertarTipodocumentaciones($tipodocumentacion) {
   $sql = "insert into tbtipodocumentaciones(idtipodocumentacion,tipodocumentacion)
   values ('','".$tipodocumentacion."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarTipodocumentaciones($id,$tipodocumentacion) {
   $sql = "update tbtipodocumentaciones
   set
   tipodocumentacion = '".$tipodocumentacion."'
   where idtipodocumentacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarTipodocumentaciones($id) {
   $sql = "delete from tbtipodocumentaciones where idtipodocumentacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }



   function traerTipodocumentacionesajax($length, $start, $busqueda,$colSort,$colSortDir) {

      $where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and t.tipodocumentacion like '%".$busqueda."%'";
		}

      $sql = "select
      t.idtipodocumentacion,
      t.tipodocumentacion
      from tbtipodocumentaciones t
      where t.idtipodocumentacion > 4 ".$where."
      ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      //die(var_dump($sql));

      $res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
   }


   function traerTipodocumentaciones() {
   $sql = "select
   t.idtipodocumentacion,
   t.tipodocumentacion
   from tbtipodocumentaciones t
   where t.idtipodocumentacion > 4
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerTipodocumentacionesPorId($id) {
   $sql = "select idtipodocumentacion,tipodocumentacion from tbtipodocumentaciones where idtipodocumentacion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbtipodocumentaciones*/


	/* PARA Documentacionsolicitudes */

	function insertarDocumentacionsolicitudes($refsolicitudes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionsolicitudes(iddocumentacionsolicitud,refsolicitudes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refsolicitudes.",".$refdocumentaciones.",'".$archivo."','".$type."',".$refestadodocumentaciones.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentacionsolicitudes($id,$refsolicitudes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "update dbdocumentacionsolicitudes
	set
	refsolicitudes = ".$refsolicitudes.",refdocumentaciones = ".$refdocumentaciones.",archivo = '".$archivo."',type = '".$type."',refestadodocumentaciones = ".$refestadodocumentaciones.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
	where iddocumentacionsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarDocumentacionsolicitudes($id) {
	$sql = "delete from dbdocumentacionsolicitudes where iddocumentacionsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerDocumentacionsolicitudes() {
	$sql = "select
	d.iddocumentacionsolicitud,
	d.refsolicitudes,
	d.refdocumentaciones,
	d.archivo,
	d.type,
	d.refestadodocumentaciones,
	d.fechacrea,
	d.fechamodi,
	d.usuariocrea,
	d.usuariomodi
	from dbdocumentacionsolicitudes d
	inner join dbsolicitudes sol ON sol.idsolicitud = d.refsolicitudes
	inner join dbdocumentaciones doc ON doc.iddocumentacion = d.refdocumentaciones
	inner join tbtipodocumentaciones ti ON ti.idtipodocumentacion = doc.reftipodocumentaciones
	inner join tbestadodocumentaciones est ON est.idestadodocumentacion = d.refestadodocumentaciones
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerDocumentacionsolicitudesPorId($id) {
	$sql = "select iddocumentacionsolicitud,refsolicitudes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionsolicitudes where iddocumentacionsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbdocumentacionsolicitudes*/



	/* PARA Asesores */
	function existeAsesor($rfc) {
		$sql = "select * from dbasesores where rfc = '".$rfc."'";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			return true;
		}

		return false;
	}

	function migrarPostulante($id,$usuario) {

		$resPostulante = $this->traerPostulantesPorId($id);

		if ($this->existeAsesor(mysql_result($resPostulante,0,'rfc')) == false) {


			$sql = "INSERT INTO dbasesores
						(idasesor,
						refusuarios,
						nombre,
						apellidopaterno,
						apellidomaterno,
						email,
						curp,
						rfc,
						ine,
						fechanacimiento,
						sexo,
						codigopostal,
						refescolaridades,
						telefonomovil,
						telefonocasa,
						telefonotrabajo,
						fechacrea,
						fechamodi,
						usuariocrea,
						usuariomodi,
						nss,
						claveinterbancaria,
						idclienteinbursa,
						claveasesor,
						fechaalta,
						observaciones,
						reftipopersonas,
						razonsocial,
						nropoliza,
						vigdesdecedulaseguro,
						vighastacedulaseguro,
						vigdesderc,
						vighastarc,
						refestadoasesor,
						refestadoasesorinbursa,
                  envioalcliente
						)
						select
						'',
						p.refusuarios,
						p.nombre,
						p.apellidopaterno,
						p.apellidomaterno,
						p.email,
						p.curp,
						p.rfc,
						p.ine,
						p.fechanacimiento,
						p.sexo,
						p.codigopostal,
						p.refescolaridades,
						p.telefonomovil,
						p.telefonocasa,
						p.telefonotrabajo,
						now(),
						now(),
						'".$usuario."',
						'".$usuario."',
						p.nss,
						p.claveinterbancaria,
						p.idclienteinbursa,
						p.claveasesor,
						p.fechaalta,
						p.observaciones,
						p.reftipopersonas,
						p.razonsocial,
						p.nropoliza,
						p.vigdesdecedulaseguro,
						p.vighastacedulaseguro,
						p.vigdesderc,
						p.vighastarc,
						2,
						2,
                  '0'
						from		dbpostulantes p where idpostulante =".$id;

			$res = $this->query($sql,1);

			if ((integer)$res > 0) {
				$resDomicilio = $this->insertarDomiciliosDe(8,$id,$res);
			}
			return $res;

		} else {
			return 'Ya existe el RFC';
		}
	}


	function insertarAsesores($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$reftipopersonas,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$nss,$razonsocial,$nropoliza,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesderc,$vighastarc,$refestadoasesor,$refestadoasesorinbursa,$envioalcliente) {
		$sql = "insert into dbasesores(idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi,reftipopersonas,claveinterbancaria,idclienteinbursa,claveasesor,fechaalta,nss,razonsocial,nropoliza,vigdesdecedulaseguro,vighastacedulaseguro,vigdesderc,vighastarc,refestadoasesor,refestadoasesorinbursa,envioalcliente)
		values ('',".$refusuarios.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$curp."','".$rfc."','".$ine."','".$fechanacimiento."','".$sexo."','".$codigopostal."',".$refescolaridades.",'".$telefonomovil."','".$telefonocasa."','".$telefonotrabajo."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$reftipopersonas.",'".$claveinterbancaria."','".$idclienteinbursa."','".$claveasesor."','".$fechaalta."','".$nss."','".$razonsocial."','".$nropoliza."',".($vigdesdecedulaseguro == '' ? 'null' : "'".$vigdesdecedulaseguro."'").",".($vighastacedulaseguro == '' ? 'null' : "'".$vighastacedulaseguro."'").",".($vigdesderc == '' ? 'null' : "'".$vigdesderc."'").",".($vighastarc == '' ? 'null' : "'".$vighastarc."'").",".$refestadoasesor.",".$refestadoasesorinbursa.",'".$envioalcliente."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAsesores($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechamodi,$usuariomodi,$reftipopersonas,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$nss,$razonsocial,$nropoliza,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesderc,$vighastarc,$refestadoasesor,$refestadoasesorinbursa,$envioalcliente) {
		$sql = "update dbasesores
		set
		refusuarios = ".$refusuarios.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',curp = '".$curp."',rfc = '".$rfc."',ine = '".$ine."',fechanacimiento = '".$fechanacimiento."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',refescolaridades = ".$refescolaridades.",telefonomovil = '".$telefonomovil."',telefonocasa = '".$telefonocasa."',telefonotrabajo = '".$telefonotrabajo."',fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',reftipopersonas = ".$reftipopersonas.",claveinterbancaria = '".$claveinterbancaria."',idclienteinbursa = '".$idclienteinbursa."',claveasesor = '".$claveasesor."',fechaalta = '".$fechaalta."',nss = '".$nss."',razonsocial = '".$razonsocial."',nropoliza = '".$nropoliza."',vigdesdecedulaseguro = ".($vigdesdecedulaseguro == '' ? 'null' : "'".$vigdesdecedulaseguro."'").",vighastacedulaseguro = ".($vighastacedulaseguro == '' ? 'null' : "'".$vighastacedulaseguro."'").",vigdesderc = ".($vigdesderc == '' ? 'null' : "'".$vigdesderc."'").",vighastarc = ".($vighastarc == '' ? 'null' : "'".$vighastarc."'").",refestadoasesor = ".$refestadoasesor.",refestadoasesorinbursa = ".$refestadoasesorinbursa.",envioalcliente = '".$envioalcliente."' where idasesor =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarAsesores($id) {
		$sql = "update dbasesores set fechaalta = '2099-01-01' where idasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function bAsesores($busqueda) {
		$sql = "select
			a.idasesor,
			a.refusuarios,
			a.nombre,
			a.apellidopaterno,
			a.apellidomaterno,
			a.email,
			a.curp,
			a.rfc,
			a.ine,
			a.fechanacimiento,
			a.sexo,
			a.codigopostal,
			a.refescolaridades,
			a.telefonomovil,
			a.telefonocasa,
			a.telefonotrabajo,
			a.fechacrea,
			a.fechamodi,
			a.usuariocrea,
			a.usuariomodi,
			a.reftipopersonas,
			a.razonsocial,
         (case when a.refestadoasesor = '1' then 'Si' else 'No' end) as activoasesorescrea,
         (case when a.refestadoasesorinbursa = '1' then 'Si' else 'No' end) as activoinbursa,
			concat(a.apellidopaterno, ' ', a.apellidomaterno, ' ', a.nombre) as nombrecompleto
			from dbasesores a
			inner join dbusuarios u ON u.idusuario = a.refusuarios
			where concat(a.apellidopaterno, ' ', a.apellidomaterno, ' ', a.nombre) like '%".$busqueda."%'
			order by a.apellidopaterno,
			a.apellidomaterno,a.nombre limit 50";
		$res = $this->query($sql,0);
		return $res;
	}

   function bAsesoresPorClave($clave) {
		$sql = "select
			a.idasesor,
			a.refusuarios,
			a.nombre,
			a.apellidopaterno,
			a.apellidomaterno,
			a.email,
			a.curp,
			a.rfc,
			a.ine,
			a.fechanacimiento,
			a.sexo,
			a.codigopostal,
			a.refescolaridades,
			a.telefonomovil,
			a.telefonocasa,
			a.telefonotrabajo,
			a.fechacrea,
			a.fechamodi,
			a.usuariocrea,
			a.usuariomodi,
			a.reftipopersonas,
			a.razonsocial,
         (case when a.refestadoasesor = '1' then 'Si' else 'No' end) as activoasesorescrea,
         (case when a.refestadoasesorinbursa = '1' then 'Si' else 'No' end) as activoinbursa,
			concat(a.apellidopaterno, ' ', a.apellidomaterno, ' ', a.nombre) as nombrecompleto
			from dbasesores a
			inner join dbusuarios u ON u.idusuario = a.refusuarios
			where a.claveasesor = '".$clave."'
			order by a.apellidopaterno,
			a.apellidomaterno,a.nombre";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsesores() {
		$sql = "select
			a.idasesor,
			a.refusuarios,
			a.nombre,
			a.apellidopaterno,
			a.apellidomaterno,
			a.email,
			a.curp,
			a.rfc,
			a.ine,
			a.fechanacimiento,
			a.sexo,
			a.codigopostal,
			a.refescolaridades,
			a.telefonomovil,
			a.telefonocasa,
			a.telefonotrabajo,
			a.fechacrea,
			a.fechamodi,
			a.usuariocrea,
			a.usuariomodi,
			a.reftipopersonas,
			a.razonsocial
			from dbasesores a
			inner join dbusuarios u ON u.idusuario = a.refusuarios
			order by a.apellidopaterno,
			a.apellidomaterno,a.nombre";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerAsesoresPorUsuario($idusuario) {
		$sql = "select
			a.idasesor,
			a.refusuarios,
			a.nombre,
			a.apellidopaterno,
			a.apellidomaterno,
			a.email,
			a.curp,
			a.rfc,
			a.ine,
			a.fechanacimiento,
			a.sexo,
			a.codigopostal,
			a.refescolaridades,
			a.telefonomovil,
			a.telefonocasa,
			a.telefonotrabajo,
			a.fechacrea,
			a.fechamodi,
			a.usuariocrea,
			a.usuariomodi,
			a.reftipopersonas,
			a.razonsocial
			from dbasesores a
			inner join dbusuarios u ON u.idusuario = a.refusuarios
			where u.idusuario = ".$idusuario."
			order by a.apellidopaterno,
			a.apellidomaterno,a.nombre";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerAsesoresPorGerente($idusuario) {
		$sql = "select
			a.idasesor,
			a.refusuarios,
			a.nombre,
			a.apellidopaterno,
			a.apellidomaterno,
			a.email,
			a.curp,
			a.rfc,
			a.ine,
			a.fechanacimiento,
			a.sexo,
			a.codigopostal,
			a.refescolaridades,
			a.telefonomovil,
			a.telefonocasa,
			a.telefonotrabajo,
			a.fechacrea,
			a.fechamodi,
			a.usuariocrea,
			a.usuariomodi,
			a.reftipopersonas,
			a.razonsocial
			from dbasesores a
			inner join dbusuarios u ON u.idusuario = a.refusuarios
			inner join dbpostulantes pp on pp.refusuarios = u.idusuario
		   inner join dbreclutadorasores rrr on rrr.refpostulantes = pp.idpostulante
			and rrr.refusuarios = ".$idusuario."
			order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsesoresPorId($id) {
	$sql = "select idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi,reftipopersonas,claveinterbancaria,idclienteinbursa,claveasesor,fechaalta,nss,razonsocial,nropoliza,vigdesdecedulaseguro,vighastacedulaseguro,vigdesderc,vighastarc,refestadoasesor,refestadoasesorinbursa,envioalcliente from dbasesores where idasesor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	function traerAsesoresPorIdCompleto($id) {
	$sql = "select idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi,reftipopersonas,claveinterbancaria,idclienteinbursa,claveasesor,fechaalta,nss,razonsocial,nropoliza,vigdesdecedulaseguro,vighastacedulaseguro,vigdesderc,vighastarc,refestadoasesor,refestadoasesorinbursa,concat(apellidopaterno, ' ', apellidomaterno, ' ', nombre) as nombrecompleto,envioalcliente from dbasesores where idasesor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbasesores*/

	/* PARA Clientes */

   function existeClienteAPYN($nombre,$apellidopaterno,$apellidomaterno) {
      $sql = "select * from dbclientes where nombre like '".$nombre."' and apellidopaterno like '".$apellidopaterno."' and apellidomaterno like '".$apellidomaterno."'";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			return 1;
		}

		return 0;
   }

	function generaNroCliente() {
		$sql = "select max(idcliente) from dbclientes";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0);
			return 'CLI'.substr('0000000'.$idcliente,-7);
		}

		return 'CLI0000001';
	}

	function insertarClientes($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion) {
		$sql = "insert into dbclientes(idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,emisioncomprobantedomicilio,emisionrfc,vencimientoine,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,genero,refestadocivil,reftipoidentificacion,nroidentificacion)
		values ('',".$reftipopersonas.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$razonsocial."','".$domicilio."','".trim($telefonofijo)."','".trim($telefonocelular)."','".$email."','".trim($rfc)."','".trim($ine)."','".$this->generaNroCliente()."',".$refusuarios.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."','".$emisioncomprobantedomicilio."','".$emisionrfc."','".$vencimientoine."','".$idclienteinbursa."','".$colonia."','".$municipio."','".$codigopostal."','".$edificio."','".$nroexterior."','".$nrointerior."','".$estado."','".$ciudad."','".$curp."','".$genero."',".$refestadocivil.",".$reftipoidentificacion.",'".$nroidentificacion."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarClientes($id,$reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechamodi,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion,$fechanacimiento) {
		$sql = "update dbclientes
		set
		reftipopersonas = ".$reftipopersonas.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',razonsocial = '".$razonsocial."',domicilio = '".$domicilio."',telefonofijo = '".trim($telefonofijo)."',telefonocelular = '".trim($telefonocelular)."',email = '".$email."',rfc = '".trim($rfc)."',ine = '".trim($ine)."',numerocliente = '".$numerocliente."',refusuarios = ".$refusuarios.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',emisioncomprobantedomicilio = '".$emisioncomprobantedomicilio."',emisionrfc = '".$emisionrfc."',vencimientoine = '".$vencimientoine."',idclienteinbursa = '".$idclienteinbursa."',colonia = '".$colonia."',municipio = '".$municipio."',codigopostal = '".$codigopostal."',edificio = '".$edificio."',nroexterior = '".$nroexterior."',nrointerior = '".$nrointerior."',estado = '".$estado."',ciudad = '".$ciudad."',curp = '".$curp."',genero = '".$genero."',refestadocivil = ".$refestadocivil.",reftipoidentificacion = ".$reftipoidentificacion.",nroidentificacion = '".$nroidentificacion."',fechanacimiento = '".$fechanacimiento."' where idcliente =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function modificarClientesInbursa($id,$idclienteinbursa) {
		$sql = "update dbclientes
		set
		idclienteinbursa = '".$idclienteinbursa."' where idcliente =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function modificarClientesDomicilio($id,$domicilio,$nroexterior,$nrointerior,$edificio,$estado,$delegacion,$colonia,$codigopostal,$ciudad) {
		$sql = "update dbclientes
		set
		domicilio = '".$domicilio."' ,nroexterior = '".$nroexterior."'
      ,nrointerior = '".$nrointerior."' , edificio = '".$edificio."',
      estado = '".$estado."', municipio = '".$delegacion."', colonia = '".$colonia."',
      codigopostal = '".$codigopostal."', ciudad = '".$ciudad."'
      where idcliente =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function modificarCampoParticularClientes($id,$campo,$valor) {
		$sql = "update dbclientes
		set
		".$campo." = '".$valor."' where idcliente =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarClientes($id) {
		$sql = "delete from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerClientesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where tip.tipopersona like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.apellidopaterno like '%".$busqueda."%' or c.apellidomaterno like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.email like '%".$busqueda."%' or c.razonsocial like '%".$busqueda."%' or c.telefonofijo like '%".$busqueda."%' or c.telefonocelular like '%".$busqueda."%' or c.numerocliente like '%".$busqueda."%'";
		}

		$sql = "select
		c.idcliente,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas
		from dbclientes c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traerClientes() {
		$sql = "select
		c.idcliente,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto
		from dbclientes c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


   function traerClientesAux() {
		$sql = "select
		c.idcliente,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		(case when reftipopersonas = 1 then concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) else concat(c.razonsocial, ' - ', c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) end) as nombrecompleto
		from dbclientes c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		order by (case when reftipopersonas = 1 then concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) else concat(c.razonsocial, ' - ', c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) end)";
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesPorTipoPersona($tipopersona) {
		$sql = "select
		c.idcliente,
      concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto,
      c.razonsocial,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,

		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente

		from dbclientes c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
      where tip.idtipopersona = ".$tipopersona."
		order by concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre)";
		$res = $this->query($sql,0);
		return $res;
	}

	function bClientes($busqueda,$tipopersona) {
		$sql = "select
		c.idcliente,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto,
		c.idclienteinbursa
		from dbclientes c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas";
      if ($tipopersona == 1) {
         $sql .= " where concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) like '%".$busqueda."%' and tip.idtipopersona = ".$tipopersona."
   		order by concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre)";
      } else {
         if ($tipopersona == 2) {
            $sql .= " where c.razonsocial like '%".$busqueda."%' and tip.idtipopersona = ".$tipopersona."
      		order by c.razonsocial";
         } else {
            $sql .= " where (concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) like '%".$busqueda."%') or (c.razonsocial like '%".$busqueda."%')
      		order by concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre),c.razonsocial";
         }
      }

		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientesPorId($id) {
		$sql = "select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,fechanacimiento,genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesPorIdPDF($id) {
		$sql = 'select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,DATE_FORMAT(fechanacimiento, "%d/%m/%Y") as fechanacimiento,genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbclientes where idcliente ='.$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerClientesPorUsuario($id) {
		$sql = "select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,fechanacimiento,genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbclientes where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesPorUsuarioCompleto($id) {
		$sql = "select
      idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,
      razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,
      numerocliente,refusuarios,
      fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa ,
      concat(apellidopaterno, ' ', apellidomaterno, ' ', nombre) as nombrecompleto,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,
      fechanacimiento,genero,refestadocivil,reftipoidentificacion,nroidentificacion
      from dbclientes where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerClientesPorIdCompleto($id) {
		$sql = "select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,
      (case when DATEDIFF(CURDATE(), coalesce( emisioncomprobantedomicilio,'1990-01-01')) > 90 then 'true' else 'false' end) as demisioncomprobantedomicilio,
      (case when DATEDIFF(CURDATE(),coalesce( emisionrfc,'1990-01-01')) > 90 then 'true' else 'false' end) as demisionrfc,
      (case when coalesce( vencimientoine,'1990-01-01') > CURDATE() then 'false' else 'true' end) as dvencimientoine,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp, fechanacimiento,genero,refestadocivil,reftipoidentificacion,nroidentificacion
      from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbclientes*/



   /* PARA Asegurados */

	function generaNroAsegurado() {
		$sql = "select max(idasegurado) from dbasegurados";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0);
			return 'ASG'.substr('0000000'.$idcliente,-7);
		}

		return 'ASG0000001';
	}

	function insertarAsegurados($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$refclientes,$reftipoparentesco,$fechanacimiento,$parentesco,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion) {
		$sql = "insert into dbasegurados(idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,emisioncomprobantedomicilio,emisionrfc,vencimientoine,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes,reftipoparentesco,fechanacimiento,parentesco,genero,refestadocivil,reftipoidentificacion,nroidentificacion)
		values ('',".$reftipopersonas.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$razonsocial."','".$domicilio."','".trim($telefonofijo)."','".trim($telefonocelular)."','".trim($email)."','".trim($rfc)."','".$ine."','".$this->generaNroAsegurado()."',".$refusuarios.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."','".$emisioncomprobantedomicilio."','".$emisionrfc."','".$vencimientoine."','".$idclienteinbursa."','".$colonia."','".$municipio."','".$codigopostal."','".$edificio."','".$nroexterior."','".$nrointerior."','".$estado."','".$ciudad."','".$curp."',".$refclientes.",".$reftipoparentesco.",'".($fechanacimiento == '' ? 'NULL' : $fechanacimiento)."','".$parentesco."','".$genero."',".$refestadocivil.",".$reftipoidentificacion.",'".$nroidentificacion."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAsegurados($id,$reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechamodi,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$refclientes,$reftipoparentesco,$fechanacimiento,$parentesco,$genero,$refestadocivil,$reftipoidentificacion,$nroidentificacion) {
		$sql = "update dbasegurados
		set
		reftipopersonas = ".$reftipopersonas.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',razonsocial = '".$razonsocial."',domicilio = '".$domicilio."',telefonofijo = '".trim($telefonofijo)."',telefonocelular = '".trim($telefonocelular)."',email = '".$email."',rfc = '".trim($rfc)."',ine = '".trim($ine)."',numerocliente = '".$numerocliente."',refusuarios = ".$refusuarios.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',emisioncomprobantedomicilio = '".$emisioncomprobantedomicilio."',emisionrfc = '".$emisionrfc."',vencimientoine = '".$vencimientoine."',idclienteinbursa = '".$idclienteinbursa."',colonia = '".$colonia."',municipio = '".$municipio."',codigopostal = '".$codigopostal."',edificio = '".$edificio."',nroexterior = '".$nroexterior."',nrointerior = '".$nrointerior."',estado = '".$estado."',ciudad = '".$ciudad."',curp = '".$curp."',refclientes = '".$refclientes."',reftipoparentesco = ".$reftipoparentesco.",fechanacimiento = '".$fechanacimiento."',parentesco = '".$parentesco."',genero = '".$genero."',refestadocivil = ".$refestadocivil.", reftipoidentificacion = ".$reftipoidentificacion.", nroidentificacion = '".$nroidentificacion."' where idasegurado =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function modificarAseguradosInbursa($id,$idclienteinbursa) {
		$sql = "update dbasegurados
		set
		idclienteinbursa = '".$idclienteinbursa."' where idasegurado =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function modificarCampoParticularAsegurados($id,$campo,$valor) {
		$sql = "update dbasegurados
		set
		".$campo." = '".$valor."' where idasegurado =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function copiarDatosDomicilioContratante($id,$idcliente) {
      $sql = "update dbasegurados a
               inner join dbclientes c on c.idcliente = a.refclientes
               set a.domicilio = c.domicilio,a.telefonocelular = c.telefonocelular,a.colonia = c.colonia,a.municipio = c.municipio,a.codigopostal = c.codigopostal,a.edificio = c.edificio,a.nroexterior = c.nroexterior,a.nrointerior = c.nrointerior,a.estado = c.estado,a.ciudad = c.ciudad
               where c.idcliente =".$idcliente." and a.idasegurado = ".$id;

      $res = $this->query($sql,0);
      return $res;
   }


	function eliminarAsegurados($id) {
		$sql = "delete from dbasegurados where idasegurado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerAseguradosClientesajax($length, $start, $busqueda,$colSort,$colSortDir,$idcliente) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (tip.tipopersona like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.apellidopaterno like '%".$busqueda."%' or c.apellidomaterno like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.rfc like '%".$busqueda."%' or c.razonsocial like '%".$busqueda."%' or c.nroidentificacion like '%".$busqueda."%' or c.curp like '%".$busqueda."%' or c.fechanacimiento like '%".$busqueda."%' or tp.tipoparentesco like '%".$busqueda."%')";
		}

		$sql = "select
		c.idasegurado,
		tip.tipopersona,
		c.apellidopaterno,
		c.apellidomaterno,
      c.nombre,
      c.rfc,
		c.nroidentificacion,
      c.curp,
      c.fechanacimiento,
      tp.tipoparentesco,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
      c.reftipoparentesco,
		c.reftipopersonas
		from dbasegurados c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
      inner join tbtipoparentesco tp ON tp.idtipoparentesco = c.reftipoparentesco
		where c.refclientes = ".$idcliente." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

      //die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerAseguradosajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or tip.tipopersona like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.apellidopaterno like '%".$busqueda."%' or c.apellidomaterno like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.email like '%".$busqueda."%' or c.razonsocial like '%".$busqueda."%' or c.telefonofijo like '%".$busqueda."%' or c.telefonocelular like '%".$busqueda."%' or c.numerocliente like '%".$busqueda."%' or tp.tipoparentesco like '%".$busqueda."%'";
		}

		$sql = "select
		c.idasegurado,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas
		from dbasegurados c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
      inner join dbclientes cli ON cli.idcliente = c.refclientes
      inner join tbtipoparentesco tp ON tp.idtipoparentesco = c.reftipoparentesco
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traeAsegurados() {
		$sql = "select
		c.idasegurado,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto
		from dbasegurados c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function bAsegurados($busqueda, $idcliente) {
		$sql = "select
		c.idasegurado,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto,
		c.idclienteinbursa
		from dbasegurados c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		where c.refclientes = ".$idcliente." and concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) like '%".$busqueda."%'
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAseguradosPorId($id) {
		$sql = "select idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes,reftipoparentesco,fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbasegurados where idasegurado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerAseguradosPorIdPDF($id) {
		$sql = 'select idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes,reftipoparentesco,DATE_FORMAT(fechanacimiento, "%d/%m/%Y") as fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbasegurados where idasegurado ='.$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerAseguradosPorUsuario($id) {
		$sql = "select idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes,reftipoparentesco,fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion from dbasegurados where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerAseguradosPorUsuarioCompleto($id) {
		$sql = "select
      idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,
      razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,
      numerocliente,refusuarios,
      fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa ,
      concat(apellidopaterno, ' ', apellidomaterno, ' ', nombre) as nombrecompleto,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes,
      reftipoparentesco,fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion
      from dbasegurados where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerAseguradosPorIdCompleto($id) {
		$sql = "select idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,
      (case when DATEDIFF(CURDATE(), coalesce( emisioncomprobantedomicilio,'1990-01-01')) > 90 then 'true' else 'false' end) as demisioncomprobantedomicilio,
      (case when DATEDIFF(CURDATE(),coalesce( emisionrfc,'1990-01-01')) > 90 then 'true' else 'false' end) as demisionrfc,
      (case when coalesce( vencimientoine,'1990-01-01') > CURDATE() then 'false' else 'true' end) as dvencimientoine,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp, refclientes,reftipoparentesco,fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion
      from dbasegurados where idasegurado =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerAseguradosPorClienteCompleto($id) {
		$sql = "select idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,
      (case when DATEDIFF(CURDATE(), coalesce( emisioncomprobantedomicilio,'1990-01-01')) > 90 then 'true' else 'false' end) as demisioncomprobantedomicilio,
      (case when DATEDIFF(CURDATE(),coalesce( emisionrfc,'1990-01-01')) > 90 then 'true' else 'false' end) as demisionrfc,
      (case when coalesce( vencimientoine,'1990-01-01') > CURDATE() then 'false' else 'true' end) as dvencimientoine,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp, refclientes,reftipoparentesco,fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion
      from dbasegurados where refclientes =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


   function traerBeneficiariosPorClienteCompleto($id,$idasegurado) {
		$sql = "select idasegurado,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,
      (case when DATEDIFF(CURDATE(), coalesce( emisioncomprobantedomicilio,'1990-01-01')) > 90 then 'true' else 'false' end) as demisioncomprobantedomicilio,
      (case when DATEDIFF(CURDATE(),coalesce( emisionrfc,'1990-01-01')) > 90 then 'true' else 'false' end) as demisionrfc,
      (case when coalesce( vencimientoine,'1990-01-01') > CURDATE() then 'false' else 'true' end) as dvencimientoine,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp, refclientes,reftipoparentesco,fechanacimiento,parentesco, genero,refestadocivil,reftipoidentificacion,nroidentificacion
      from dbasegurados where idasegurado not in (".$idasegurado.") and refclientes =".$id;
		$res = $this->query($sql,0);
      //die(var_dump($sql));
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbasegurados*/



   /* PARA Beneficiarios */

	function generaNroBeneficiario() {
		$sql = "select max(idbeneficiario) from dbbeneficiarios";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0);
			return 'BEN'.substr('0000000'.$idcliente,-7);
		}

		return 'BEN0000001';
	}

	function insertarBeneficiarios($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$refclientes) {
		$sql = "insert into dbbeneficiarios(idbeneficiario,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,emisioncomprobantedomicilio,emisionrfc,vencimientoine,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes)
		values ('',".$reftipopersonas.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$razonsocial."','".$domicilio."','".$telefonofijo."','".$telefonocelular."','".$email."','".$rfc."','".$ine."','".$this->generaNroBeneficiario()."',".$refusuarios.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."','".$emisioncomprobantedomicilio."','".$emisionrfc."','".$vencimientoine."','".$idclienteinbursa."','".$colonia."','".$municipio."','".$codigopostal."','".$edificio."','".$nroexterior."','".$nrointerior."','".$estado."','".$ciudad."','".$curp."',".$refclientes.")";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarBeneficiarios($id,$reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechamodi,$usuariomodi,$emisioncomprobantedomicilio,$emisionrfc,$vencimientoine,$idclienteinbursa,$colonia,$municipio,$codigopostal,$edificio,$nroexterior,$nrointerior,$estado,$ciudad,$curp,$refclientes) {
		$sql = "update dbbeneficiarios
		set
		reftipopersonas = ".$reftipopersonas.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',razonsocial = '".$razonsocial."',domicilio = '".$domicilio."',telefonofijo = '".$telefonofijo."',telefonocelular = '".$telefonocelular."',email = '".$email."',rfc = '".$rfc."',ine = '".$ine."',numerocliente = '".$numerocliente."',refusuarios = ".$refusuarios.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',emisioncomprobantedomicilio = '".$emisioncomprobantedomicilio."',emisionrfc = '".$emisionrfc."',vencimientoine = '".$vencimientoine."',idclienteinbursa = '".$idclienteinbursa."',colonia = '".$colonia."',municipio = '".$municipio."',codigopostal = '".$codigopostal."',edificio = '".$edificio."',nroexterior = '".$nroexterior."',nrointerior = '".$nrointerior."',estado = '".$estado."',ciudad = '".$ciudad."',curp = '".$curp."',refclientes = ".$refclientes." where idbeneficiario =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

	function modificarBeneficiariosInbursa($id,$idclienteinbursa) {
		$sql = "update dbbeneficiarios
		set
		idclienteinbursa = '".$idclienteinbursa."' where idbeneficiario =".$id;

		$res = $this->query($sql,0);
		return $res;
	}

   function modificarCampoParticularBeneficiarios($id,$campo,$valor) {
		$sql = "update dbbeneficiarios
		set
		".$campo." = '".$valor."' where idbeneficiario =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarBeneficiarios($id) {
		$sql = "delete from dbbeneficiarios where idbeneficiario =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerBeneficiariosClientesajax($length, $start, $busqueda,$colSort,$colSortDir, $idcliente) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " and (tip.tipopersona like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.apellidopaterno like '%".$busqueda."%' or c.apellidomaterno like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.email like '%".$busqueda."%' or c.razonsocial like '%".$busqueda."%' or c.telefonofijo like '%".$busqueda."%' or c.telefonocelular like '%".$busqueda."%' or c.numerocliente like '%".$busqueda."%')";
		}

		$sql = "select
		c.idbeneficiario,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas
		from dbbeneficiarios c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		where c.refclientes = ".$idcliente." ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


   function traerBeneficiariosajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or tip.tipopersona like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.apellidopaterno like '%".$busqueda."%' or c.apellidomaterno like '%".$busqueda."%' or c.nombre like '%".$busqueda."%' or c.email like '%".$busqueda."%' or c.razonsocial like '%".$busqueda."%' or c.telefonofijo like '%".$busqueda."%' or c.telefonocelular like '%".$busqueda."%' or c.numerocliente like '%".$busqueda."%'";
		}

		$sql = "select
		c.idbeneficiario,
      concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) as cliente,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas
		from dbbeneficiarios c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
      inner join dbclientes cli ON cli.idcliente = c.refclientes
		 ".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}

	function traeBeneficiarios() {
		$sql = "select
		c.idbeneficiario,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto
		from dbbeneficiarios c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function bBeneficiarios($busqueda,$idcliente) {
		$sql = "select
		c.idbeneficiario,
		tip.tipopersona,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.razonsocial,
		c.telefonofijo,
		c.telefonocelular,
		c.email,
		c.numerocliente,
		c.domicilio,
		c.rfc,
		c.ine,
		c.refusuarios,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi,
		c.reftipopersonas,
		concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) as nombrecompleto,
		c.idclienteinbursa
		from dbbeneficiarios c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		where c.refclientes = ".$idcliente." and concat(c.apellidopaterno, ' ', c.apellidomaterno, ' ', c.nombre) like '%".$busqueda."%'
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerBeneficiariosPorId($id) {
		$sql = "select idbeneficiario,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes from dbbeneficiarios where idbeneficiario =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerBeneficiariosPorUsuario($id) {
		$sql = "select idbeneficiario,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp,refclientes from dbbeneficiarios where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerBeneficiariosPorUsuarioCompleto($id) {
		$sql = "select
      idbeneficiario,reftipopersonas,nombre,apellidopaterno,apellidomaterno,
      razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,
      numerocliente,refusuarios,
      fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa ,
      concat(apellidopaterno, ' ', apellidomaterno, ' ', nombre) as nombrecompleto,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp, refclientes
      from dbbeneficiarios where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

   function traerBeneficiariosPorIdCompleto($id) {
		$sql = "select idbeneficiario,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi,idclienteinbursa,emisioncomprobantedomicilio,emisionrfc,vencimientoine,
      (case when DATEDIFF(CURDATE(), coalesce( emisioncomprobantedomicilio,'1990-01-01')) > 90 then 'true' else 'false' end) as demisioncomprobantedomicilio,
      (case when DATEDIFF(CURDATE(),coalesce( emisionrfc,'1990-01-01')) > 90 then 'true' else 'false' end) as demisionrfc,
      (case when coalesce( vencimientoine,'1990-01-01') > CURDATE() then 'false' else 'true' end) as dvencimientoine,
      colonia,municipio,codigopostal,edificio,nroexterior,nrointerior,estado,ciudad,curp, refclientes
      from dbbeneficiarios where idbeneficiario =".$id;
		$res = $this->query($sql,0);
		return $res;
	}



	/* Fin */
	/* /* Fin de la Tabla: dbbeneficiarios*/





	/* PARA Promotores */

	function insertarPromotores($reftipopromotores,$refusuarios,$nombre,$apellido,$rfc,$curp,$comision,$teloficina,$telparticular,$telmovil,$refpromotorestados,$refsucursales,$refsupervisorusuario,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "insert into dbpromotores(idpromotor,reftipopromotores,refusuarios,nombre,apellido,rfc,curp,comision,teloficina,telparticular,telmovil,refpromotorestados,refsucursales,refsupervisorusuario,fechacrea,fechamodi,usuariocrea,usuariomodi)
	values ('',".$reftipopromotores.",".$refusuarios.",'".$nombre."','".$apellido."','".$rfc."','".$curp."',".$comision.",'".$teloficina."','".$telparticular."','".$telmovil."',".$refpromotorestados.",".$refsucursales.",".$refsupervisorusuario.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarPromotores($id,$reftipopromotores,$refusuarios,$nombre,$apellido,$rfc,$curp,$comision,$teloficina,$telparticular,$telmovil,$refpromotorestados,$refsucursales,$refsupervisorusuario,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "update dbpromotores
	set
	reftipopromotores = ".$reftipopromotores.",refusuarios = ".$refusuarios.",nombre = '".$nombre."',apellido = '".$apellido."',rfc = '".$rfc."',curp = '".$curp."',comision = ".$comision.",teloficina = '".$teloficina."',telparticular = '".$telparticular."',telmovil = '".$telmovil."',refpromotorestados = ".$refpromotorestados.",refsucursales = ".$refsucursales.",refsupervisorusuario = ".$refsupervisorusuario.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."' where idpromotor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarPromotores($id) {
	$sql = "delete from dbpromotores where idpromotor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerPromotores() {
	$sql = "select
	p.idpromotor,
	p.reftipopromotores,
	p.refusuarios,
	p.nombre,
	p.apellido,
	p.rfc,
	p.curp,
	p.comision,
	p.teloficina,
	p.telparticular,
	p.telmovil,
	p.refpromotorestados,
	p.refsucursales,
	p.refsupervisorusuario,
	p.fechacrea,
	p.fechamodi,
	p.usuariocrea,
	p.usuariomodi
	from dbpromotores p
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerPromotoresPorId($id) {
	$sql = "select idpromotor,reftipopromotores,refusuarios,nombre,apellido,rfc,curp,comision,teloficina,telparticular,telmovil,refpromotorestados,refsucursales,refsupervisorusuario,fechacrea,fechamodi,usuariocrea,usuariomodi from dbpromotores where idpromotor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbpromotores*/


	/* PARA Solicitudes */

	function insertarSolicitudes($reftiposolicitudes,$refestadosolicitudes,$nombre,$apellidopaterno,$apellidomaterno,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "insert into dbsolicitudes(idsolicitud,reftiposolicitudes,refestadosolicitudes,nombre,apellidopaterno,apellidomaterno,email,fechanacimiento,telefono,sexo,codigopostal,reftipoingreso,refclientes,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi)
	values ('',".$reftiposolicitudes.",".$refestadosolicitudes.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$fechanacimiento."','".$telefono."','".$sexo."','".$codigopostal."',".$reftipoingreso.",".$refclientes.",".$refusuarios.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarSolicitudes($id,$reftiposolicitudes,$refestadosolicitudes,$nombre,$apellidopaterno,$apellidomaterno,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "update dbsolicitudes
	set
	reftiposolicitudes = ".$reftiposolicitudes.",refestadosolicitudes = ".$refestadosolicitudes.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',fechanacimiento = '".$fechanacimiento."',telefono = '".$telefono."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',reftipoingreso = ".$reftipoingreso.",refclientes = ".$refclientes.",refusuarios = ".$refusuarios.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."' where idsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarSolicitudes($id) {
	$sql = "delete from dbsolicitudes where idsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	function traerSolicitudesajax($length, $start, $busqueda,$colSort,$colSortDir) {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where tip.tiposolicitud like '%".$busqueda."%' or est.estadosolicitud like '%".$busqueda."%' or s.nombre like '%".$busqueda."%' or s.apellidopaterno like '%".$busqueda."%' or s.apellidomaterno like '%".$busqueda."%' or s.email like '%".$busqueda."%' or s.telefono like '%".$busqueda."%' or s.codigopostal like '%".$busqueda."%' or ti.tipoingreso like '%".$busqueda."%' or DATE_FORMAT(s.fechacrea, '%Y-%m-%d') like '%".$busqueda."%'";
		}

		$sql = "select
			s.idsolicitud,
			tip.tiposolicitud,
			est.estadosolicitud,
			s.nombre,
			s.apellidopaterno,
			s.apellidomaterno,
			s.email,
			s.telefono,
			s.codigopostal,
			ti.tipoingreso,
			s.fechacrea,
			s.fechamodi,
			s.usuariocrea,
			s.reftiposolicitudes,
			s.refestadosolicitudes,
			s.reftipoingreso,
			s.refclientes,
			s.refusuarios,
			s.usuariomodi
		from dbsolicitudes s
		inner join tbtiposolicitudes tip ON tip.idtiposolicitud = s.reftiposolicitudes
		inner join tbestadosolicitudes est ON est.idestadosolicitud = s.refestadosolicitudes
		inner join tbtipoingreso ti ON ti.idtipoingreso = s.reftipoingreso
		inner join dbusuarios usu ON usu.idusuario = s.refusuarios
		".$where."
		ORDER BY ".$colSort." ".$colSortDir."
		limit ".$start.",".$length;
		//die(var_dump($sql));
		$res = $this->query($sql,0);
		return $res;
	}

	function traerSolicitudes() {
		$sql = "select
		s.idsolicitud,
		s.reftiposolicitudes,
		s.refestadosolicitudes,
		s.nombre,
		s.apellidopaterno,
		s.apellidomaterno,
		s.email,
		s.fechanacimiento,
		s.telefono,
		s.sexo,
		s.codigopostal,
		s.reftipoingreso,
		s.refclientes,
		s.refusuarios,
		s.fechacrea,
		s.fechamodi,
		s.usuariocrea,
		s.usuariomodi
		from dbsolicitudes s
		inner join tbtiposolicitudes tip ON tip.idtiposolicitud = s.reftiposolicitudes
		inner join tbestadosolicitudes est ON est.idestadosolicitud = s.refestadosolicitudes
		inner join tbtipoingreso ti ON ti.idtipoingreso = s.reftipoingreso
		inner join dbusuarios usu ON usu.idusuario = s.refusuarios
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerSolicitudesPorId($id) {
	$sql = "select idsolicitud,reftiposolicitudes,refestadosolicitudes,nombre,apellido,email,fechanacimiento,telefono,sexo,codigopostal,reftipoingreso,refclientes,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi from dbsolicitudes where idsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbsolicitudes*/


	/* PARA Sucursales */

	function insertarSucursales($refentidades,$calle,$nombre,$colonia,$ciudad,$codigopostal,$lada,$telefono,$fax,$contacto,$email,$refpadre) {
	$sql = "insert into dbsucursales(idsucursal,refentidades,calle,nombre,colonia,ciudad,codigopostal,lada,telefono,fax,contacto,email,refpadre)
	values ('',".$refentidades.",'".$calle."','".$nombre."','".$colonia."','".$ciudad."','".$codigopostal."','".$lada."','".$telefono."','".$fax."','".$contacto."','".$email."',".$refpadre.")";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarSucursales($id,$refentidades,$calle,$nombre,$colonia,$ciudad,$codigopostal,$lada,$telefono,$fax,$contacto,$email,$refpadre) {
	$sql = "update dbsucursales
	set
	refentidades = ".$refentidades.",calle = '".$calle."',nombre = '".$nombre."',colonia = '".$colonia."',ciudad = '".$ciudad."',codigopostal = '".$codigopostal."',lada = '".$lada."',telefono = '".$telefono."',fax = '".$fax."',contacto = '".$contacto."',email = '".$email."',refpadre = ".$refpadre."
	where idsucursal =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarSucursales($id) {
	$sql = "delete from dbsucursales where idsucursal =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerSucursales() {
	$sql = "select
	s.idsucursal,
	s.refentidades,
	s.calle,
	s.nombre,
	s.colonia,
	s.ciudad,
	s.codigopostal,
	s.lada,
	s.telefono,
	s.fax,
	s.contacto,
	s.email,
	s.refpadre
	from dbsucursales s
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerSucursalesPorId($id) {
	$sql = "select idsucursal,refentidades,calle,nombre,colonia,ciudad,codigopostal,lada,telefono,fax,contacto,email,refpadre from dbsucursales where idsucursal =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* PARA Entidades */

	function insertarEntidades($nombre,$clave) {
	$sql = "insert into tbentidades(identidad,nombre,clave)
	values ('','".$nombre."','".$clave."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEntidades($id,$nombre,$clave) {
	$sql = "update tbentidades
	set
	nombre = '".$nombre."',clave = '".$clave."'
	where identidad =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarEntidades($id) {
	$sql = "delete from tbentidades where identidad =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEntidades() {
	$sql = "select
	e.identidad,
	e.nombre,
	e.clave
	from tbentidades e
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEntidadesPorId($id) {
	$sql = "select identidad,nombre,clave from tbentidades where identidad =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbentidades*/


	/* PARA Entidadnacimiento */

	function insertarEntidadnacimiento($entidadnacimiento,$clave) {
	$sql = "insert into tbentidadnacimiento(identidadnacimiento,entidadnacimiento,clave)
	values ('','".$entidadnacimiento."','".$clave."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEntidadnacimiento($id,$entidadnacimiento,$clave) {
	$sql = "update tbentidadnacimiento
	set
	entidadnacimiento = '".$entidadnacimiento."',clave = '".$clave."'
	where identidadnacimiento =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarEntidadnacimiento($id) {
	$sql = "delete from tbentidadnacimiento where identidadnacimiento =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEntidadnacimiento() {
	$sql = "select
	e.identidadnacimiento,
	e.entidadnacimiento,
	e.clave
	from tbentidadnacimiento e
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEntidadnacimientoPorId($id) {
	$sql = "select identidadnacimiento,entidadnacimiento,clave from tbentidadnacimiento where identidadnacimiento =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbentidadnacimiento*/


	/* PARA Estadocivil */

	function insertarEstadocivil($estadocivil) {
	$sql = "insert into tbestadocivil(idestadocivil,estadocivil)
	values ('','".$estadocivil."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEstadocivil($id,$estadocivil) {
	$sql = "update tbestadocivil
	set
	estadocivil = '".$estadocivil."'
	where idestadocivil =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarEstadocivil($id) {
	$sql = "delete from tbestadocivil where idestadocivil =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadocivil() {
	$sql = "select
	e.idestadocivil,
	e.estadocivil
	from tbestadocivil e
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadocivilPorId($id) {
	$sql = "select idestadocivil,estadocivil from tbestadocivil where idestadocivil =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	function traerEstadocivilPorIn($in) {
	$sql = "select idestadocivil,estadocivil from tbestadocivil where idestadocivil in (".$in.")";
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbestadocivil*/


	/* PARA Estadosolicitudes */

	function insertarEstadosolicitudes($estadosolicitud) {
	$sql = "insert into tbestadosolicitudes(idestadosolicitud,estadosolicitud)
	values ('','".$estadosolicitud."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEstadosolicitudes($id,$estadosolicitud) {
	$sql = "update tbestadosolicitudes
	set
	estadosolicitud = '".$estadosolicitud."'
	where idestadosolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarEstadosolicitudes($id) {
	$sql = "delete from tbestadosolicitudes where idestadosolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadosolicitudes() {
	$sql = "select
	e.idestadosolicitud,
	e.estadosolicitud
	from tbestadosolicitudes e
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerEstadosolicitudesPorId($id) {
	$sql = "select idestadosolicitud,estadosolicitud from tbestadosolicitudes where idestadosolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbestadosolicitudes*/


	/* PARA Promotorestados */

	function insertarPromotorestados($promotorestado) {
	$sql = "insert into tbpromotorestados(idpromotorestado,promotorestado)
	values ('','".$promotorestado."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarPromotorestados($id,$promotorestado) {
	$sql = "update tbpromotorestados
	set
	promotorestado = '".$promotorestado."'
	where idpromotorestado =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarPromotorestados($id) {
	$sql = "delete from tbpromotorestados where idpromotorestado =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerPromotorestados() {
	$sql = "select
	p.idpromotorestado,
	p.promotorestado
	from tbpromotorestados p
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerPromotorestadosPorId($id) {
	$sql = "select idpromotorestado,promotorestado from tbpromotorestados where idpromotorestado =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbpromotorestados*/


	/* PARA Rolhogar */

	function insertarRolhogar($rolhogar) {
	$sql = "insert into tbrolhogar(idrolhogar,rolhogar)
	values ('','".$rolhogar."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarRolhogar($id,$rolhogar) {
	$sql = "update tbrolhogar
	set
	rolhogar = '".$rolhogar."'
	where idrolhogar =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarRolhogar($id) {
	$sql = "delete from tbrolhogar where idrolhogar =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerRolhogar() {
	$sql = "select
	r.idrolhogar,
	r.rolhogar
	from tbrolhogar r
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerRolhogarPorId($id) {
	$sql = "select idrolhogar,rolhogar from tbrolhogar where idrolhogar =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbrolhogar*/


	/* PARA Tipoclientes */

	function insertarTipoclientes($tipocliente) {
	$sql = "insert into tbtipoclientes(idtipocliente,tipocliente)
	values ('','".$tipocliente."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTipoclientes($id,$tipocliente) {
	$sql = "update tbtipoclientes
	set
	tipocliente = '".$tipocliente."'
	where idtipocliente =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTipoclientes($id) {
	$sql = "delete from tbtipoclientes where idtipocliente =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipoclientes() {
	$sql = "select
	t.idtipocliente,
	t.tipocliente
	from tbtipoclientes t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipoclientesPorId($id) {
	$sql = "select idtipocliente,tipocliente from tbtipoclientes where idtipocliente =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbtipoclientes*/


	/* PARA Tipoingreso */

	function insertarTipoingreso($tipoingreso) {
	$sql = "insert into tbtipoingreso(idtipoingreso,tipoingreso)
	values ('','".$tipoingreso."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTipoingreso($id,$tipoingreso) {
	$sql = "update tbtipoingreso
	set
	tipoingreso = '".$tipoingreso."'
	where idtipoingreso =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTipoingreso($id) {
	$sql = "delete from tbtipoingreso where idtipoingreso =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipoingreso() {
	$sql = "select
	t.idtipoingreso,
	t.tipoingreso
	from tbtipoingreso t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipoingresoPorId($id) {
	$sql = "select idtipoingreso,tipoingreso from tbtipoingreso where idtipoingreso =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbtipoingreso*/


	/* PARA Tipopromotores */

	function insertarTipopromotores($tipopromotor) {
	$sql = "insert into tbtipopromotores(idtipopromotor,tipopromotor)
	values ('','".$tipopromotor."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTipopromotores($id,$tipopromotor) {
	$sql = "update tbtipopromotores
	set
	tipopromotor = '".$tipopromotor."'
	where idtipopromotor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTipopromotores($id) {
	$sql = "delete from tbtipopromotores where idtipopromotor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipopromotores() {
	$sql = "select
	t.idtipopromotor,
	t.tipopromotor
	from tbtipopromotores t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTipopromotoresPorId($id) {
	$sql = "select idtipopromotor,tipopromotor from tbtipopromotores where idtipopromotor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbtipopromotores*/


	/* PARA Tiposolicitudes */

	function insertarTiposolicitudes($tiposolicitud,$condocumentacion,$tope) {
	$sql = "insert into tbtiposolicitudes(idtiposolicitud,tiposolicitud,condocumentacion,tope)
	values ('','".$tiposolicitud."','".$condocumentacion."',".$tope.")";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTiposolicitudes($id,$tiposolicitud,$condocumentacion,$tope) {
	$sql = "update tbtiposolicitudes
	set
	tiposolicitud = '".$tiposolicitud."',condocumentacion = '".$condocumentacion."',tope = ".$tope."
	where idtiposolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTiposolicitudes($id) {
	$sql = "delete from tbtiposolicitudes where idtiposolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTiposolicitudes() {
	$sql = "select
	t.idtiposolicitud,
	t.tiposolicitud,
	t.condocumentacion,
	t.tope
	from tbtiposolicitudes t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}

	function traerTiposolicitudesIn($in) {
	$sql = "select
	t.idtiposolicitud,
	t.tiposolicitud,
	t.condocumentacion,
	t.tope
	from tbtiposolicitudes t
	where t.idtiposolicitud in (".$in.")
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTiposolicitudesPorId($id) {
	$sql = "select idtiposolicitud,tiposolicitud,condocumentacion,tope from tbtiposolicitudes where idtiposolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbtiposolicitudes*/

   function GUID()
   {
       if (function_exists('com_create_guid') === true)
       {
           return trim(com_create_guid(), '{}');
       }

       return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
   }


///**********  PARA SUBIR ARCHIVOS  ***********************//////////////////////////
	function borrarDirecctorio($dir) {
		array_map('unlink', glob($dir."/*.*"));

	}

	function borrarArchivo($id,$archivo) {
		$sql	=	"delete from images where idfoto =".$id;

		$res =  unlink("./../archivos/".$archivo);
		if ($res)
		{
			$this->query($sql,0);
		}
		return $res;
	}


	function existeArchivo($id,$nombre,$type) {
		$sql		=	"select * from images where refproyecto =".$id." and imagen = '".$nombre."' and type = '".$type."'";
		$resultado  =   $this->query($sql,0);

			   if(mysql_num_rows($resultado)>0){

				   return mysql_result($resultado,0,0);
			   }

			   return 0;
	}

	function sanear_string($string)
   {

       $string = trim($string);

       $string = str_replace(
           array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
           array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
           $string
       );

       $string = str_replace(
           array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
           array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
           $string
       );

       $string = str_replace(
           array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
           array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
           $string
       );

       $string = str_replace(
           array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
           array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
           $string
       );

       $string = str_replace(
           array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
           array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
           $string
       );

       $string = str_replace(
           array('ñ', 'Ñ', 'ç', 'Ç'),
           array('n', 'N', 'c', 'C',),
           $string
       );

       $string = str_replace(
           array('(', ')', '{', '}',' '),
           array('', '', '', '',''),
           $string
       );



       return $string;
   }

   function crearDirectorioPrincipal($dir) {
   	if (!file_exists($dir)) {
   		mkdir($dir, 0777);
   	}
   }



	function subirArchivo($file,$carpeta,$id,$token,$observacion, $refcategorias, $anio, $mes, $reftipoarchivos, $asunto) {


		$dir_destino_padre = '../archivos/'.$carpeta.'/';
		$dir_destino = '../archivos/'.$carpeta.'/'.$id.'/';
		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));

		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../archivos/'.$carpeta.'/'.$id.'/'.'index.php';

		//die(var_dump($dir_destino));
		if (!file_exists($dir_destino_padre)) {
			mkdir($dir_destino_padre, 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}


		if(!is_writable($dir_destino)){

			echo "no tiene permisos";

		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					//la carpeta de libros solo los piso
					if ($carpeta == 'galeria') {
						$this->eliminarFotoPorObjeto($id);
					}
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {

						$archivo = $this->sanear_string($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];

						$filename = $dir_destino.'descarga.zip';
						$zip = new ZipArchive();

						if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
						exit('cannot open <$filename>\n');
						}

						$zip->addFile($dir_destino.$archivo, $archivo);

						$zip->close();

                  copy($noentrar, $nuevo_noentrar);

						$this->insertarArchivos($carpeta,$token,str_replace(' ','',$archivo),$tipoarchivo, $observacion, $refcategorias, $anio, $mes,$reftipoarchivos,$asunto);

                  //$this->modificarClienteImagenPorId($carpeta,$archivo);

						echo "";

						copy($noentrar, $nuevo_noentrar);

					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}
	}


   function subirFoto($file,$carpeta,$id) {

      // carpeta = 'idcliente'
      // id = 'foto frente 1 o foto dorsal 2'


		$dir_destino_padre = '../data/'.$carpeta.'/';

		$dir_destino = '../data/'.$carpeta.'/'.$id.'/';

      $this->borrarDirecctorio($dir_destino);

		$imagen_subida = $dir_destino . $this->sanear_string(str_replace(' ','',basename($_FILES[$file]['name'])));

		$noentrar = '../imagenes/index.php';
		$nuevo_noentrar = '../data/'.$carpeta.'/'.$id.'/'.'index.php';

		//die(var_dump($dir_destino));
		if (!file_exists($dir_destino_padre)) {
			mkdir($dir_destino_padre, 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}


		if(!is_writable($dir_destino)){

			echo "no tiene permisos";

		}	else	{
			if ($_FILES[$file]['tmp_name'] != '') {
				if(is_uploaded_file($_FILES[$file]['tmp_name'])){
					//la carpeta de libros solo los piso
					if ($carpeta == 'galeria') {
						$this->eliminarFotoPorObjeto($id);
					}
					/*echo "Archivo ". $_FILES['foto']['name'] ." subido con éxtio.\n";
					echo "Mostrar contenido\n";
					echo $imagen_subida;*/
					if (move_uploaded_file($_FILES[$file]['tmp_name'], $imagen_subida)) {

						$archivo = $this->sanear_string($_FILES[$file]["name"]);
						$tipoarchivo = $_FILES[$file]["type"];

						$filename = $dir_destino.'descarga.zip';
						$zip = new ZipArchive();

						if ($zip->open($filename, ZipArchive::CREATE) !== TRUE) {
						exit('cannot open <$filename>\n');
						}

						$zip->addFile($dir_destino.$archivo, $archivo);

						$zip->close();

                  if ($id == 1) {
                     $resMod = $this->modificarClienteImagenFrentePorId($carpeta, $archivo);
                  } else {
                     $resMod = $this->modificarClienteImagenDorsalPorId($carpeta, $archivo);
                  }

						echo '';

						copy($noentrar, $nuevo_noentrar);

					} else {
						echo "Posible ataque de carga de archivos!\n";
					}
				}else{
					echo "Posible ataque del archivo subido: ";
					echo "nombre del archivo '". $_FILES[$file]['tmp_name'] . "'.";
				}
			}
		}
	}



	function TraerFotosRelacion($id) {
		$sql    =   "select 'galeria',s.idproducto,f.imagen,f.idfoto,f.type
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where s.idproducto = ".$id;
		$result =   $this->query($sql, 0);
		return $result;
	}


	function eliminarFoto($id)
	{

		$sql		=	"select concat('galeria','/',s.idproducto,'/',f.imagen) as archivo
							from dbproductos s

							inner
							join images f
							on	s.idproducto = f.refproyecto

							where f.idfoto =".$id;
		$resImg		=	$this->query($sql,0);

		if (mysql_num_rows($resImg)>0) {
			$res 		=	$this->borrarArchivo($id,mysql_result($resImg,0,0));
		} else {
			$res = true;
		}
		if ($res == false) {
			return 'Error al eliminar datos';
		} else {
			return '';
		}
	}


   function zerofill($valor, $longitud){
    $res = str_pad($valor, $longitud, '0', STR_PAD_LEFT);
    return $res;
   }

   function existeDevuelveId($sql) {

   	$res = $this->query($sql,0);

   	if (mysql_num_rows($res)>0) {
   		return mysql_result($res,0,0);
   	}
   	return 0;
   }



   /* PARA Estados */

   function insertarEstados($estado,$color,$icono) {
   $sql = "insert into tbestados(idestado,estado,color,icono)
   values (null,'".$estado."','".$color."','".$icono."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarEstados($id,$estado,$color,$icono) {
   $sql = "update tbestados
   set
   estado = '".$estado."',color = '".$color."',icono = '".$icono."'
   where idestado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarEstados($id) {
   $sql = "delete from tbestados where idestado =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerEstados() {
   $sql = "select
   e.idestado,
   e.estado,
   e.color,
   e.icono
   from tbestados e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

	function traerEstadosPorId($id) {
   $sql = "select
   e.idestado,
   e.estado,
   e.color,
   e.icono
   from tbestados e
	where e.idestado = ".$id."
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

	function traerEstadodocumentaciones() {
   $sql = "select
   e.idestadodocumentacion,
   e.estadodocumentacion,
   e.color
   from tbestadodocumentaciones e
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }

   function traerEstadodocumentacionesPorId($id) {
   $sql = "select
   e.idestadodocumentacion,
   e.estadodocumentacion,
   e.color
   from tbestadodocumentaciones e
   where e.idestadodocumentacion = ".$id."
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: tbestados*/

   /* PARA Meses */

   function insertarMeses($meses,$desde,$hasta) {
   $sql = "insert into tbmeses(idmes,meses,desde,hasta)
   values (null,'".$meses."',".$desde.",".$hasta.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarMeses($id,$meses,$desde,$hasta) {
   $sql = "update tbmeses
   set
   meses = '".$meses."',desde = ".$desde.",hasta = ".$hasta."
   where idmes =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarMeses($id) {
   $sql = "delete from tbmeses where idmes =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMeses() {
   $sql = "select
   m.idmes,
   m.meses,
   m.desde,
   m.hasta
   from tbmeses m
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMesesPorMes($mes) {
   $sql = "select
   m.idmes,
   m.meses,
   m.desde,
   m.hasta
   from tbmeses m
   where ".$mes." between m.desde and m.hasta
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerMesesPorId($id) {
   $sql = "select idmes,meses,desde,hasta from tbmeses where idmes =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: tbmeses*/



   /* PARA Clientes */

   function existeCliente($nrodocumento, $modifica = 0, $id = 0) {
      if ($modifica == 1) {
         $sql = "select * from dbclientes where curp = '".$nrodocumento."' and idcliente <> ".$id;
      } else {
         $sql = "select * from dbclientes where curp = '".$nrodocumento."'";
      }

   	$res = $this->query($sql,0);
   	if (mysql_num_rows($res)>0) {
   		return true;
   	} else {
   		return false;
   	}
   }



   /* PARA Usuarios */

   function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto,$activo, $refsocios) {
   $sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto,activo, refsocios)
   values (null,'".$usuario."','".$password."',".$refroles.",'".$email."','".$nombrecompleto."',".$activo.",".$refsocios.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto,$activo,$refsocios) {
   $sql = "update dbusuarios
   set
   usuario = '".$usuario."',password = '".$password."',refroles = ".$refroles.",email = '".$email."',nombrecompleto = '".$nombrecompleto."',activo = ".$activo." ,refsocios = ".($refsocios)."
   where idusuario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarUsuarios($id) {
   $sql = "update dbusuarios set activo = 0 where idusuario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

	function eliminarUsuariosDefinitivamente($id) {
   $sql = "delete from dbusuarios where idusuario =".$id;
   $res = $this->query($sql,0);
   return $sql;
   }


   function traerUsuarios() {
   $sql = "select
   u.idusuario,
   u.usuario,
   u.password,
   u.refroles,
   u.email,
   u.nombrecompleto,
   u.reflocatarios
   from dbusuarios u
   inner join tbroles rol ON rol.idrol = u.refroles
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerUsuariosPorId($id) {
   $sql = "select idusuario,usuario,password,refroles,email,nombrecompleto,(case when activo = 1 then 'Si' else 'No' end) as activo,refsocios from dbusuarios where idusuario =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   function modPassword($id, $pass) {
      $sql = "update dbusuarios set password = '".$pass."' where idusuario = ".$id;
      $res = $this->query($sql,0);
      return $res;
   }

	function traerUsuariosPorRol($idrol) {
		$sql = "select u.idusuario,u.usuario, u.email , u.nombrecompleto
				from dbusuarios u
				inner join tbroles r on u.refroles = r.idrol
				where r.idrol = ".$idrol."
				order by nombrecompleto";
		$res = $this->query($sql,0);
		if ($res == false) {
			return 'Error al traer datos';
		} else {
			return $res;
		}
	}

   /* Fin */
   /* /* Fin de la Tabla: dbusuarios*/

	/* PARA Correoselectronicos */

	function insertarCorreoselectronicos($refusuarios,$refpostulantes,$email,$cuerpo,$asunto) {
	$sql = "insert into dbcorreoselectronicos(iddcorreoelectronico,refusuarios,refpostulantes,email,cuerpo,asunto)
	values ('',".$refusuarios.",".$refpostulantes.",'".$email."',".$cuerpo.",'".$asunto."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarCorreoselectronicos($id,$refusuarios,$refpostulantes,$email,$cuerpo,$asunto) {
	$sql = "update dbcorreoselectronicos
	set
	refusuarios = ".$refusuarios.",refpostulantes = ".$refpostulantes.",email = '".$email."',cuerpo = ".$cuerpo.",asunto = '".$asunto."'
	where iddcorreoelectronico =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarCorreoselectronicos($id) {
	$sql = "delete from dbcorreoselectronicos where iddcorreoelectronico =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerCorreoselectronicos() {
	$sql = "select
	c.iddcorreoelectronico,
	c.refusuarios,
	c.refpostulantes,
	c.email,
	c.cuerpo,
	c.asunto
	from dbcorreoselectronicos c
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerCorreoselectronicosPorId($id) {
	$sql = "select iddcorreoelectronico,refusuarios,refpostulantes,email,cuerpo,asunto from dbcorreoselectronicos where iddcorreoelectronico =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbcorreoselectronicos*/


   /* PARA Predio_menu */

   function insertarPredio_menu($url,$icono,$nombre,$Orden,$hover,$permiso) {
   $sql = "insert into predio_menu(idmenu,url,icono,nombre,Orden,hover,permiso)
   values (null,'".$url."','".$icono."','".$nombre."',".$Orden.",'".$hover."','".$permiso."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarPredio_menu($id,$url,$icono,$nombre,$Orden,$hover,$permiso) {
   $sql = "update predio_menu
   set
   url = '".$url."',icono = '".$icono."',nombre = '".$nombre."',Orden = ".$Orden.",hover = '".$hover."',permiso = '".$permiso."'
   where idmenu =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarPredio_menu($id) {
   $sql = "delete from predio_menu where idmenu =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPredio_menu() {
   $sql = "select
   p.idmenu,
   p.url,
   p.icono,
   p.nombre,
   p.Orden,
   p.hover,
   p.permiso
   from predio_menu p
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerPredio_menuPorId($id) {
   $sql = "select idmenu,url,icono,nombre,Orden,hover,permiso from predio_menu where idmenu =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: predio_menu*/



   /* PARA Roles */

   function insertarRoles($descripcion,$activo) {
   $sql = "insert into tbroles(idrol,descripcion,activo)
   values (null,'".$descripcion."',".$activo.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarRoles($id,$descripcion,$activo) {
   $sql = "update tbroles
   set
   descripcion = '".$descripcion."',activo = ".$activo."
   where idrol =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarRoles($id) {
   $sql = "delete from tbroles where idrol =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerRoles() {
   $sql = "select
   r.idrol,
   r.descripcion,
   r.activo
   from tbroles r
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerRolesPorId($id) {
   $sql = "select idrol,descripcion,activo from tbroles where idrol =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: tbroles*/




   /* PARA Configuracion */

   function insertarConfiguracion($razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
   $sql = "insert into tbconfiguracion(idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email)
   values (null,'".$razonsocial."','".$empresa."','".$sistema."','".$direccion."','".$telefono."','".$email."')";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarConfiguracion($id,$razonsocial,$empresa,$sistema,$direccion,$telefono,$email) {
   $sql = "update tbconfiguracion
   set
   razonsocial = '".$razonsocial."',empresa = '".$empresa."',sistema = '".$sistema."',direccion = '".$direccion."',telefono = '".$telefono."',email = '".$email."'
   where idconfiguracion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function eliminarConfiguracion($id) {
   $sql = "delete from tbconfiguracion where idconfiguracion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }


   function traerConfiguracion() {
   $sql = "select
   c.idconfiguracion,
   c.razonsocial,
   c.empresa,
   c.sistema,
   c.direccion,
   c.telefono,
   c.email
   from tbconfiguracion c
   order by 1";
   $res = $this->query($sql,0);
   return $res;
   }


   function traerConfiguracionPorId($id) {
   $sql = "select idconfiguracion,razonsocial,empresa,sistema,direccion,telefono,email from tbconfiguracion where idconfiguracion =".$id;
   $res = $this->query($sql,0);
   return $res;
   }

   /* Fin */
   /* /* Fin de la Tabla: tbconfiguracion*/

	/* PARA Taxa */

	function insertarTaxa($taxaper,$taxaturistico,$maxtaxa) {
	$sql = "insert into tbtaxa(idtaxa,taxaper,taxaturistico,maxtaxa)
	values ('',".$taxaper.",".$taxaturistico.")";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarTaxa($id,$taxaper,$taxaturistico,$maxtaxa) {
	$sql = "update tbtaxa
	set
	taxaper = ".$taxaper.",taxaturistico = ".$taxaturistico.",maxtaxa = ".$maxtaxa."
	where idtaxa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarTaxa($id) {
	$sql = "delete from tbtaxa where idtaxa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTaxa() {
	$sql = "select
	t.idtaxa,
	t.taxaper,
	t.taxaturistico,
	t.maxtaxa
	from tbtaxa t
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerTaxaPorId($id) {
	$sql = "select idtaxa,taxaper,taxaturistico,maxtaxa from tbtaxa where idtaxa =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbtaxa*/

 /*******************   auditoria   **************************************************************/
 /* PARA Auditoria */

	function insertarAuditoria($tabla,$operacion,$campo,$valornuevo,$valorviejo,$id,$usuario,$token,$visible,$idpostulante) {
		$sql = "insert into dbauditoria(idauditoriapostulante,tabla,operacion,campo,valornuevo,valorviejo,id,usuario,fecha,token,idusuario,visible)
		values ('','".$tabla."','".$operacion."','".$campo."','".$valornuevo."','".$valorviejo."',".$id.",'".$usuario."',now(),'".$token."',".$_SESSION['id_usuariopredio'].",".$visible.",".$idpostulante.")";

		$res = $this->query($sql,1);
		return $res;
	}

	function insertAuditoria($tabla, $operacion,$id,$usuario, $ar=null,$token=null,$visible,$idpostulante) {
		$sql = "SHOW COLUMNS FROM ".$tabla;
		$res = $this->query($sql,0);
		$resAux = $this->query($sql,0);

		$idnombre = mysql_result($res,0,0);

		if ($token == null) {
			$token = $this->GUID();
		}


		$i = 0;

		while ($row = mysql_fetch_array($resAux)) {

		//$sqlValor = "SELECT ".$row[0].' from '.$tabla.' where '.$idnombre.' = '.$id;

			if (strpos($row[1],"bit") !== false) {
				$sqlValor = "SELECT (case when ".$row[0]." = 1 then 'Si' else 'No' end) as ".$row[0]." from ".$tabla.' where '.$idnombre.' = '.$id;
			} else {
				$sqlValor = "SELECT ".$row[0].' from '.$tabla.' where '.$idnombre.' = '.$id;
			}

			$resValor = $this->query($sqlValor,0);
			$valornuevo = mysql_result($resValor,0,0);


			$valorviejo = '';
			if (count($ar)>0) {
				$insert = $this->insertarAuditoria($tabla,$operacion,$row[0],$valornuevo,$ar[$i][$row[0]],$id,$usuario,$token,$visible,$idpostulante);
				$i += 1;
			} else {
				$insert = $this->insertarAuditoria($tabla,$operacion,$row[0],$valornuevo,$valorviejo,$id,$usuario,$token,$visible,$idpostulante);
			}


		//array_push($ar,array($row[0]=> $valornuevo));
		}

		return $insert;
	}

	function modiAuditoria($tabla, $operacion,$id,$usuario) {
		$sql = "SHOW COLUMNS FROM ".$tabla;
		$res = $this->query($sql,0);
		$resAux = $this->query($sql,0);

		$idnombre = mysql_result($res,0,0);

		$ar = array();

		while ($row = mysql_fetch_array($resAux)) {

			if (strpos($row[1],"bit") !== false) {
				$sqlValor = "SELECT (case when ".$row[0]." = 1 then 'Si' else 'No' end) as ".$row[0]." from ".$tabla.' where '.$idnombre.' = '.$id;
			} else {
				$sqlValor = "SELECT ".$row[0].' from '.$tabla.' where '.$idnombre.' = '.$id;
			}


			$resValor = $this->query($sqlValor,0);
			$valornuevo = '';

			$valorviejo = mysql_result($resValor,0,0);

			//$insert = $this->insertarAuditoria($tabla,$operacion,$row[0],$valornuevo,$valorviejo,$id,$usuario);
			array_push($ar,array($row[0]=> $valorviejo));

		}

		return $ar;
	}



   /* PARA Autologin */

   function insertarAutologin($refusuarios,$token,$url,$usado) {
      $sql = "insert into autologin(idautologin,refusuarios,token,url,usado)
      values ('',".$refusuarios.",'".$token."','".$url."','".$usado."')";
      $res = $this->query($sql,1);
      return $res;
   }


   function modificarAutologin($id,$refusuarios,$token,$url,$usado) {
      $sql = "update autologin
      set
      refusuarios = ".$refusuarios.",token = '".$token."',url = '".$url."',usado = '".$usado."'
      where idautologin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function eliminarAutologin($id) {
      $sql = "delete from autologin where idautologin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }


   function traerAutologin() {
      $sql = "select
      a.idautologin,
      a.refusuarios,
      a.token,
      a.url,
      a.usado
      from autologin a
      order by 1";
      $res = $this->query($sql,0);
      return $res;
   }


   function traerAutologinPorId($id) {
      $sql = "select idautologin,refusuarios,token,url,usado from autologin where idautologin =".$id;
      $res = $this->query($sql,0);
      return $res;
   }

   function traerAutologinPorToken($token) {
      $sql = "select idautologin,refusuarios,token,url,usado from autologin where token ='".$token."'";
      $res = $this->query($sql,0);
      return $res;
   }


   /* Fin */
   /* /* Fin de la Tabla: autologin*/

   function insertarCron($nombre,$fecha) {
      $sql = "insert into dbcron(idcron,nombre,fecha)
      values ('','".$nombre."','".$fecha."')";
      $res = $this->query($sql,1);
      return $res;
   }


 /*****************************       fin         ************************************************/

   function limpiar() {
      $sql = "delete from dbcomercioinicio;
            delete from dbcomerciofin;
            delete from dbclientesasesores;
            delete from dbclientescartera;
            delete from dblead;
            delete from dbasegurados;
            delete from dbdocumentacionventas;

            delete from dbperiodicidadventaspagos;
            delete from dbperiodicidadventasdetalle;
            delete from dbperiodicidadventas;
            delete from dbventas;
            delete from dbmetodopago;
            delete from dbtokens;
            delete from dbpagos;
            delete from dbfirmarcontratos;
            delete from dbventas;
            delete from dbcotizaciones;
            delete from dbdocumentacionclientes;
            ";
      $res = $this->query($sql,0);

      return $res;
   }

   function encryptIt( $q ) {
      $cryptKey  = 'asiu2837hFSDFef2#$23sd9823asesorescrea';
      $qEncoded      = base64_encode( mcrypt_encrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), $q, MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ) );
      return( $qEncoded );
   }

   function decryptIt( $q ) {
      $cryptKey  = 'asiu2837hFSDFef2#$23sd9823asesorescrea';
      $qDecoded      = rtrim( mcrypt_decrypt( MCRYPT_RIJNDAEL_256, md5( $cryptKey ), base64_decode( $q ), MCRYPT_MODE_CBC, md5( md5( $cryptKey ) ) ), "\0");
      return( $qDecoded );
   }

   function hiddenString($str, $start = 1, $end = 1)
   {
      $len = strlen($str);
      return substr($str, 0, $start) . str_repeat('*', $len - ($start + $end)) . substr($str, $len - $end, $end);
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
