<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Mexico_City');

class ServiciosReferencias {

	/* PARA Perfilasesores */

	function insertarPerfilasesores($reftabla,$idreferencia,$imagenperfil,$imagenfirma,$urllinkedin,$urlfacebook,$urlinstagram,$visible) {
		$sql = "insert into dbperfilasesores(idperfilasesor,reftabla,idreferencia,imagenperfil,imagenfirma,urllinkedin,urlfacebook,urlinstagram,visible,token)
		values ('',".$reftabla.",".$idreferencia.",'".$imagenperfil."','".$imagenfirma."','".$urllinkedin."','".$urlfacebook."','".$urlinstagram."','".$visible."','".$this->GUID()."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPerfilasesores($id,$reftabla,$idreferencia,$imagenperfil,$imagenfirma,$urllinkedin,$urlfacebook,$urlinstagram,$visible) {
		$sql = "update dbperfilasesores
		set
		reftabla = ".$reftabla.",idreferencia = ".$idreferencia.",urllinkedin = '".$urllinkedin."',urlfacebook = '".$urlfacebook."',urlinstagram = '".$urlinstagram."',visible = '".$visible."'
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
		p.token
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
		d.token
		from dbperfilasesores d
		inner join ".$tabla." v on v.".$idnombre." = d.idreferencia
		where d.reftabla = ".$idtabla." and d.idreferencia = ".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPerfilasesoresPorId($id) {
		$sql = "select idperfilasesor,reftabla,idreferencia,imagenperfil,imagenfirma,urllinkedin,urlfacebook,urlinstagram,visible,token from dbperfilasesores where idperfilasesor =".$id;
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
		urllinkedin,
		urlfacebook,
		urlinstagram,
		(case when visible = '1' then 'Si' else 'No' end) as visible,
		token
		from dbperfilasesores where idperfilasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerPerfilasesoresPorIdImagenCompleto($id,$imagen) {

		if ($imagen == 'imagenperfil') {
			$cad = " and imagenperfil != ''";
		} else {
			$cad = " and imagenfirma != ''";
		}
		$sql = "select
		idperfilasesor,
		reftabla,
		idreferencia,
		concat('archivos/informacion/',idperfilasesor,'/', imagenperfil) as imagenperfil,
		concat('archivos/informacion/',idperfilasesor,'/', imagenfirma) as imagenfirma,
		urllinkedin,
		urlfacebook,
		urlinstagram,
		(case when visible = '1' then 'Si' else 'No' end) as visible,
		token
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

	function insertarClientesasesores($refclientes,$refasesores,$apellidopaterno,$apellidomaterno,$nombre,$razonsocial,$domicilio,$email,$rfc,$ine,$reftipopersonas,$telefonofijo,$telefonocelular) {
		$sql = "insert into dbclientesasesores(idclienteasesor,refclientes,refasesores,apellidopaterno,apellidomaterno,nombre,razonsocial,domicilio,email,rfc,ine,reftipopersonas,telefonofijo,telefonocelular)
		values ('',".$refclientes.",".$refasesores.",'".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$razonsocial."','".$domicilio."','".$email."','".$rfc."','".$ine."',".$reftipopersonas.",'".$telefonofijo."','".$telefonocelular."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarClientesasesores($id,$refclientes,$refasesores,$apellidopaterno,$apellidomaterno,$nombre,$razonsocial,$domicilio,$email,$rfc,$ine,$reftipopersonas,$telefonofijo,$telefonocelular) {
		$sql = "update dbclientesasesores
		set
		refclientes = ".$refclientes.",refasesores = ".$refasesores.",apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',razonsocial = '".$razonsocial."',domicilio = '".$domicilio."',email = '".$email."',rfc = '".$rfc."',ine = '".$ine."',reftipopersonas = ".$reftipopersonas.",telefonofijo = '".$telefonofijo."',telefonocelular = '".$telefonocelular."'
		where idclienteasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarClientesasesores($id) {
		$sql = "delete from dbclientesasesores where idclienteasesor =".$id;
		$res = $this->query($sql,0);
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
		c.telefonocelular
		from dbclientesasesores c
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientesasesoresPorId($id) {
		$sql = "select idclienteasesor,refclientes,refasesores,apellidopaterno,apellidomaterno,nombre,razonsocial,domicilio,email,rfc,ine,reftipopersonas,telefonofijo,telefonocelular from dbclientesasesores where idclienteasesor =".$id;
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
		c.refasesores
		from dbclientesasesores c
		inner join dbclientes cl ON cl.idcliente = c.refclientes
		inner join dbasesores ase on ase.refusuarios = c.refasesores
		where ase.refusuarios = ".$refasesor;
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
							MAX(c.fechapago) AS ultimafecha, a.idasesor
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
						month(c.fechapago) as mes
					from		dbcotizaciones c
					inner
					join		dbasesores a
					on			c.refasesores = a.idasesor
					left
					join		dbasociados aso
					on			aso.idasociado = c.refasociados

					where		c.refestadocotizaciones>=6
					group by    month(c.fechapago)
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
	      $referencia = 'info@asesorescrea.com';
	   }
	   # Defina el número de e-mails que desea enviar por periodo. Si es 0, el proceso por lotes
	   # se deshabilita y los mensajes son enviados tan rápido como sea posible.
	   define("MAILQUEUE_BATCH_SIZE",0);

	   //para el envío en formato HTML
	   //$headers = "MIME-Version: 1.0\r\n";

	   // Cabecera que especifica que es un HMTL
	   $headers  = 'MIME-Version: 1.0' . "\r\n";
	   $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

	   //dirección del remitente
	   $headers .= utf8_decode("From: ASESORES CREA <info@asesorescrea.com>\r\n");

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

		$sql = "insert into dboportunidades(idoportunidad,nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,refusuarios,refreferentes,refestadooportunidad,fechacrea,refmotivorechazos,observaciones,refestadogeneraloportunidad)
		select '',nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,".$refusuarios.",refreferentes,1,'".date('Y-m-d H-i-s')."',0,observaciones,1
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

	function modificarCotizacionUnicaDocumentacion($id, $campo, $valor) {
		$sql = "update dbcotizaciones
		set
		".$campo." = '".$valor."'
		where idcotizacion =".$id;
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
					where d.iddocumentacion in (35,36,37)

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
				$archivos = '../archivos/cotizacion/'.$idasociadotemporal.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';

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

	function insertarProductos($producto) {
		$sql = "insert into tbproductos(idproducto,producto)
		values ('','".$producto."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarProductos($id,$producto) {
		$sql = "update tbproductos
		set
		producto = '".$producto."'
		where idproducto =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarProductos($id) {
		$sql = "delete from tbproductos where idproducto =".$id;
		$res = $this->query($sql,0);
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


	function traerProductosPorId($id) {
		$sql = "select idproducto,producto,prima from tbproductos where idproducto =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbproductos*/

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
					    ed.idestadodocumentacion
					FROM
					    dbdocumentaciones d
					        LEFT JOIN
					    dbdocumentacionclientes da ON d.iddocumentacion = da.refdocumentaciones
					        AND da.refclientes = ".$idcliente."
					        LEFT JOIN
					    tbestadodocumentaciones ed ON ed.idestadodocumentacion = da.refestadodocumentaciones
					where d.iddocumentacion in (3,4,7,10,29)

					order by 1";
		$res = $this->query($sql,0);
 		return $res;
	}

	function insertarDocumentacionclientes($refclientes,$refdocumentaciones,$archivo,$type,$refestadodocumentaciones,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentacionclientes(iddocumentacioncliente,refasociados,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi)
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

	function insertarCotizaciones($refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$observaciones,$fechaemitido,$primaneta,$primatotal,$recibopago,$fechapago,$nrorecibo,$importecomisionagente,$importebonopromotor,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios,$nropoliza,$cobertura,$reasegurodirecto,$fecharenovacion,$fechapropuesta,$tiponegocio,$presentacotizacion) {
		$sql = "insert into dbcotizaciones(idcotizacion,refclientes,refproductos,refasesores,refasociados,refestadocotizaciones,observaciones,fechaemitido,primaneta,primatotal,recibopago,fechapago,nrorecibo,importecomisionagente,importebonopromotor,fechacrea,fechamodi,usuariocrea,usuariomodi,refusuarios,nropoliza,cobertura,reasegurodirecto,fecharenovacion,fechapropuesta,tiponegocio,presentacotizacion)
		values ('',".$refclientes.",".$refproductos.",".$refasesores.",".$refasociados.",".$refestadocotizaciones.",'".$observaciones."',".($fechaemitido == '' ? 'NULL' : "'".$fechaemitido ."'").",".$primaneta.",".$primatotal.",'".$recibopago."',".($fechapago == '' ? 'NULL' : "'".$fechapago ."'").",'".$nrorecibo."',".$importecomisionagente.",".$importebonopromotor.",'".date('Y-m-d H:i:s')."','".date('Y-m-d H:i:s')."','".$usuariocrea."','".$usuariomodi."',".$refusuarios.",'".$nropoliza."','".$cobertura."','".$reasegurodirecto."',".($fecharenovacion == '' ? 'NULL' : "'".$fecharenovacion ."'").",".($fechapropuesta == '' ? 'NULL' : "'".$fechapropuesta ."'").",'".$tiponegocio."','".$presentacotizacion."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarCotizaciones($id,$refclientes,$refproductos,$refasesores,$refasociados,$refestadocotizaciones,$observaciones,$fechaemitido,$primaneta,$primatotal,$recibopago,$fechapago,$nrorecibo,$importecomisionagente,$importebonopromotor,$fechamodi,$usuariomodi,$refusuarios,$nropoliza,$cobertura,$reasegurodirecto,$fecharenovacion,$fechapropuesta,$tiponegocio,$presentacotizacion) {
		$sql = "update dbcotizaciones
		set
		refclientes = ".$refclientes.",refproductos = ".$refproductos.",refasesores = ".$refasesores.",refasociados = ".$refasociados.",refestadocotizaciones = ".$refestadocotizaciones.",observaciones = '".$observaciones."',fechaemitido = ".($fechaemitido == '' ? 'NULL' : "'".$fechaemitido ."'").",primaneta = ".$primaneta.",primatotal = ".$primatotal.",recibopago = '".$recibopago."',fechapago = ".($fechapago == '' ? 'NULL' : "'".$fechapago ."'").",nrorecibo = '".$nrorecibo."',importecomisionagente = ".$importecomisionagente.",importebonopromotor = ".$importebonopromotor.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',refusuarios = ".$refusuarios.",nropoliza = '".$nropoliza."',cobertura = '".$cobertura."',reasegurodirecto = '".$reasegurodirecto."',fecharenovacion = ".($fecharenovacion == '' ? 'NULL' : "'".$fecharenovacion ."'").",fechapropuesta = ".($fechapropuesta == '' ? 'NULL' : "'".$fechapropuesta ."'").",tiponegocio = '".$tiponegocio."',presentacotizacion = '".$presentacotizacion."' where idcotizacion =".$id;

		//die(var_dump($sql));

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
		c.observaciones,
		c.fechaemitido,
		c.primaneta,
		c.primatotal,
		c.recibopago,
		c.nropoliza,
		c.fechapago,
		c.nrorecibo,
		c.importecomisionagente,
		c.importebonopromotor,
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
		inner join tbestadocotizaciones est ON est.idestadocotizacion = c.refestadocotizaciones
		order by 1";

		$res = $this->query($sql,0);
		return $res;
	}


	function traerCotizacionesajax($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial) {
		$where = '';

		$roles = '';

	   if ($responsableComercial != '') {
	      $roles = " ase.refusuarios = ".$responsableComercial." and ";
	   } else {
	      $roles = '';
	   }

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = " where ".$roles." (concat(cli.apellidopaterno, ' ', cli.apellidomaterno, ' ', cli.nombre) like '%".$busqueda."%' or pro.producto like '%".$busqueda."%' or concat(ase.apellidopaterno, ' ', ase.apellidomaterno, ' ', ase.nombre) like '%".$busqueda."%' or concat(aso.apellidopaterno, ' ', aso.apellidomaterno, ' ', aso.nombre) like '%".$busqueda."%' or est.estadocotizacion like '%".$busqueda."%')";
		} else {
			if ($responsableComercial != '') {
	         $where = " where ase.refusuarios = ".$responsableComercial." ";
	      }
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
		c.fechaemitido,
		c.primaneta,
		c.primatotal,
		c.recibopago,
		c.nropoliza,
		c.fechapago,
		c.nrorecibo,
		c.importecomisionagente,
		c.importebonopromotor,
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
		".$where."
		ORDER BY ".$colSort." ".$colSortDir." ";
		$limit = "limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = array($this->query($sql.$limit,0) , $this->query($sql,0));
		return $res;
	}


	function traerCotizacionesajaxPorUsuario($length, $start, $busqueda,$colSort,$colSortDir,$responsableComercial) {
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
		c.fechaemitido,
		c.primaneta,
		c.primatotal,
		c.recibopago,
		c.nropoliza,
		c.fechapago,
		c.nrorecibo,
		c.importecomisionagente,
		c.importebonopromotor,
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
		where ase.refusuarios = ".$responsableComercial." ".$where."
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
		c.fechaemitido,
		c.primaneta,
		c.primatotal,
		c.recibopago,
		c.nropoliza,
		c.fechapago,
		c.nrorecibo,
		c.importecomisionagente,
		c.importebonopromotor,
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
		c.fechaemitido,
		c.primaneta,
		c.primatotal,
		c.recibopago,
		c.nropoliza,
		c.fechapago,
		c.nrorecibo,
		c.importecomisionagente,
		c.importebonopromotor,
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
		$sql = "select idcotizacion,refclientes,refproductos,refasesores,refasociados,refestadocotizaciones,observaciones,fechaemitido,primaneta,primatotal,recibopago,fechapago,nrorecibo,importecomisionagente,importebonopromotor,fechacrea,fechamodi,usuariocrea,usuariomodi,refusuarios,nropoliza,cobertura,reasegurodirecto,tiponegocio,presentacotizacion,fechapropuesta,fecharenovacion from dbcotizaciones where idcotizacion =".$id;

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
		orden from tbestadocotizaciones where idestadocotizacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEstadocotizacionesPorIn($in) {
		$sql = "select
		e.idestadocotizacion,
		e.estadocotizacion,
		e.orden
		from tbestadocotizaciones e
		where  idestadocotizacion in (".$in.")
		order by e.orden";
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: tbestadocotizaciones*/

	/* PARA Alertas */

	function insertarAlertas($reftiposeguimientos,$motivo,$id,$fechacreacion,$refusuarios) {
		$sql = "insert into dbalertas(idalerta,reftiposeguimientos,motivo,id,fechacreacion,refusuarios)
		values ('',".$reftiposeguimientos.",'".$motivo."',".$id.",'".$fechacreacion."',".$refusuarios.")";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAlertas($id,$reftiposeguimientos,$motivo,$id,$fechacreacion,$refusuarios) {
		$sql = "update dbalertas
		set
		reftiposeguimientos = ".$reftiposeguimientos.",motivo = '".$motivo."',id = ".$id.",fechacreacion = '".$fechacreacion."',refusuarios = ".$refusuarios."
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
		coalesce(uo.nombrecompleto, upo.nombrecompleto),
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
		order by 1";
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
			    p.refestadopostulantes = 10 and r.idreferente = ".$idreferente."
		".$where."
		ORDER BY ".$colSort." ".$colSortDir."
		limit ".$start.",".$length;

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

	function insertarOportunidades($nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$telefonomovil,$telefonotrabajo,$email,$refusuarios,$refreferentes,$refestadooportunidad,$refmotivorechazos,$observaciones,$refestadogeneraloportunidad) {
		$sql = "insert into dboportunidades(idoportunidad,nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,refusuarios,refreferentes,refestadooportunidad,fechacrea,refmotivorechazos,observaciones,refestadogeneraloportunidad)
		values ('','".$nombredespacho."','".$apellidopaterno."','".$apellidomaterno."','".$nombre."','".$telefonomovil."','".$telefonotrabajo."','".$email."',".$refusuarios.",".$refreferentes.",".$refestadooportunidad.",'".date('Y-m-d H:i:s')."',".$refmotivorechazos.",'".$observaciones."',".$refestadogeneraloportunidad.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarOportunidades($id,$nombredespacho,$apellidopaterno,$apellidomaterno,$nombre,$telefonomovil,$telefonotrabajo,$email,$refusuarios,$refreferentes,$refestadooportunidad,$refmotivorechazos,$observaciones,$refestadogeneraloportunidad) {
		$sql = "update dboportunidades
		set
		nombredespacho = '".$nombredespacho."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',nombre = '".$nombre."',telefonomovil = '".$telefonomovil."',telefonotrabajo = '".$telefonotrabajo."',email = '".$email."',refusuarios = ".$refusuarios.",refreferentes = ".$refreferentes.",refestadooportunidad = ".$refestadooportunidad.",refmotivorechazos = ".$refmotivorechazos.",observaciones = '".$observaciones."',refestadogeneraloportunidad = ".$refestadogeneraloportunidad."
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
			$where = " and ".$roles." (o.nombredespacho like '%".$busqueda."%' or o.apellidopaterno like '%".$busqueda."%' or o.apellidomaterno like '%".$busqueda."%' or o.nombre like '%".$busqueda."%' or o.telefonomovil like '%".$busqueda."%' or o.telefonotrabajo like '%".$busqueda."%' or o.email like '%".$busqueda."%' or usu.nombrecompleto like '%".$busqueda."%' or est.estadooportunidad like '%".$busqueda."%')";
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
		o.refestadogeneraloportunidad
		from dboportunidades o
		inner join dbusuarios usu ON usu.idusuario = o.refusuarios
		inner join tbestadooportunidad est ON est.idestadooportunidad = o.refestadooportunidad
		where o.idoportunidad =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerOportunidadesPorId($id) {
		$sql = "select idoportunidad,nombredespacho,apellidopaterno,apellidomaterno,nombre,telefonomovil,telefonotrabajo,email,refusuarios,refreferentes,refestadooportunidad,refmotivorechazos,observaciones,refestadogeneraloportunidad from dboportunidades where idoportunidad =".$id;
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
			order by p.codigo,p.estado,p.municipio,p.colonia";
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
		order by 1";
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
		datediff(now(),fechanacimiento)/365 as edad,reforigenreclutamiento,email2,vigdesderc,vighastarc from dbpostulantes where refusuarios =".$idusuario;
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

	function insertarDocumentaciones($reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbdocumentaciones(iddocumentacion,reftipodocumentaciones,documentacion,obligatoria,cantidadarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$reftipodocumentaciones.",'".$documentacion."','".$obligatoria."',".$cantidadarchivos.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarDocumentaciones($id,$reftipodocumentaciones,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbdocumentaciones
		set
		reftipodocumentaciones = ".$reftipodocumentaciones.",documentacion = '".$documentacion."',obligatoria = '".$obligatoria."',cantidadarchivos = ".$cantidadarchivos.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
		where iddocumentacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarDocumentaciones($id) {
		$sql = "delete from dbdocumentaciones where iddocumentacion =".$id;
		$res = $this->query($sql,0);
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
		$sql = "select iddocumentacion,reftipodocumentaciones,documentacion,obligatoria,cantidadarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi,carpeta from dbdocumentaciones where iddocumentacion =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbdocumentaciones*/


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
						refestadoasesorinbursa
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
						1,
						1
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


	function insertarAsesores($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$reftipopersonas,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$nss,$razonsocial,$nropoliza,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesderc,$vighastarc,$refestadoasesor,$refestadoasesorinbursa) {
		$sql = "insert into dbasesores(idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi,reftipopersonas,claveinterbancaria,idclienteinbursa,claveasesor,fechaalta,nss,razonsocial,nropoliza,vigdesdecedulaseguro,vighastacedulaseguro,vigdesderc,vighastarc,refestadoasesor,refestadoasesorinbursa)
		values ('',".$refusuarios.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$curp."','".$rfc."','".$ine."','".$fechanacimiento."','".$sexo."','".$codigopostal."',".$refescolaridades.",'".$telefonomovil."','".$telefonocasa."','".$telefonotrabajo."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$reftipopersonas.",'".$claveinterbancaria."','".$idclienteinbursa."','".$claveasesor."','".$fechaalta."','".$nss."','".$razonsocial."','".$nropoliza."',".($vigdesdecedulaseguro == '' ? 'null' : "'".$vigdesdecedulaseguro."'").",".($vighastacedulaseguro == '' ? 'null' : "'".$vighastacedulaseguro."'").",".($vigdesderc == '' ? 'null' : "'".$vigdesderc."'").",".($vighastarc == '' ? 'null' : "'".$vighastarc."'").",".$refestadoasesor.",".$refestadoasesorinbursa.")";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAsesores($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechamodi,$usuariomodi,$reftipopersonas,$claveinterbancaria,$idclienteinbursa,$claveasesor,$fechaalta,$nss,$razonsocial,$nropoliza,$vigdesdecedulaseguro,$vighastacedulaseguro,$vigdesderc,$vighastarc,$refestadoasesor,$refestadoasesorinbursa) {
		$sql = "update dbasesores
		set
		refusuarios = ".$refusuarios.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',curp = '".$curp."',rfc = '".$rfc."',ine = '".$ine."',fechanacimiento = '".$fechanacimiento."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',refescolaridades = ".$refescolaridades.",telefonomovil = '".$telefonomovil."',telefonocasa = '".$telefonocasa."',telefonotrabajo = '".$telefonotrabajo."',fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."',reftipopersonas = ".$reftipopersonas.",claveinterbancaria = '".$claveinterbancaria."',idclienteinbursa = '".$idclienteinbursa."',claveasesor = '".$claveasesor."',fechaalta = '".$fechaalta."',nss = '".$nss."',razonsocial = '".$razonsocial."',nropoliza = '".$nropoliza."',vigdesdecedulaseguro = ".($vigdesdecedulaseguro == '' ? 'null' : "'".$vigdesdecedulaseguro."'").",vighastacedulaseguro = ".($vighastacedulaseguro == '' ? 'null' : "'".$vighastacedulaseguro."'").",vigdesderc = ".($vigdesderc == '' ? 'null' : "'".$vigdesderc."'").",vighastarc = ".($vighastarc == '' ? 'null' : "'".$vighastarc."'").",refestadoasesor = ".$refestadoasesor.",refestadoasesorinbursa = ".$refestadoasesorinbursa." where idasesor =".$id;

		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarAsesores($id) {
		$sql = "update dbasesores set fechaalta = '2099-01-01' where idasesor =".$id;
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
			order by 1";
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
			order by 1";
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
	$sql = "select idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi,reftipopersonas,claveinterbancaria,idclienteinbursa,claveasesor,fechaalta,nss,razonsocial,nropoliza,vigdesdecedulaseguro,vighastacedulaseguro,vigdesderc,vighastarc,refestadoasesor,refestadoasesorinbursa from dbasesores where idasesor =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbasesores*/

	/* PARA Clientes */

	function generaNroCliente() {
		$sql = "select max(idcliente) from dbclientes";
		$res = $this->query($sql,0);

		if (mysql_num_rows($res) > 0) {
			$idcliente = mysql_result($res,0,0);
			return 'CLI'.substr('0000000'.$idcliente,-7);
		}

		return 'ASE0000001';
	}

	function insertarClientes($reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbclientes(idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$reftipopersonas.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$razonsocial."','".$domicilio."','".$telefonofijo."','".$telefonocelular."','".$email."','".$rfc."','".$ine."','".$this->generaNroCliente()."',".$refusuarios.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarClientes($id,$reftipopersonas,$nombre,$apellidopaterno,$apellidomaterno,$razonsocial,$domicilio,$telefonofijo,$telefonocelular,$email,$rfc,$ine,$numerocliente,$refusuarios,$fechamodi,$usuariomodi) {
		$sql = "update dbclientes
		set
		reftipopersonas = ".$reftipopersonas.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',razonsocial = '".$razonsocial."',domicilio = '".$domicilio."',telefonofijo = '".$telefonofijo."',telefonocelular = '".$telefonocelular."',email = '".$email."',rfc = '".$rfc."',ine = '".$ine."',numerocliente = '".$numerocliente."',refusuarios = ".$refusuarios.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."' where idcliente =".$id;

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
		c.reftipopersonas
		from dbclientes c
		inner join tbtipopersonas tip ON tip.idtipopersona = c.reftipopersonas
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientesPorId($id) {
		$sql = "select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerClientesPorUsuario($id) {
		$sql = "select idcliente,reftipopersonas,nombre,apellidopaterno,apellidomaterno,razonsocial,domicilio,telefonofijo,telefonocelular,email,rfc,ine,numerocliente,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi from dbclientes where refusuarios =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	/* Fin */
	/* /* Fin de la Tabla: dbclientes*/





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
	$sql = "select idestadocivil,estadocivil from tbestadocivil where idestadocivil in (".$id.")";
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


 /*****************************       fin         ************************************************/

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
