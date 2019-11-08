<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Mexico_City');

class ServiciosReferencias {

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

	function insertarIp($ip,$activo,$secuencia,$verde,$amarillo,$rojo,$respuesta,$idpregunta,$token) {
		$sql = "insert into dbrespuestas(idrespuesta,ip,activo,secuencia,verde,amarillo,rojo,respuesta,idpregunta,token)
		values ('','".$ip."','".$activo."',".$secuencia.",'".$verde."','".$amarillo."','".$rojo."','".$respuesta."',".$idpregunta.",'".$token."')";
		$res = $this->query($sql,1);
		return $res;
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
		$sql = "select idpregunta,secuencia,pregunta,respuesta1,respuesta2,respuesta3,respuesta4,respuesta5,respuesta6,respuesta7,valor,depende,tiempo from dbpreguntas where secuencia =".$secuencia;
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

	function buscarPostal($busqueda) {
		$sql = "select
				p.id,
				p.codigo,
				p.colonia,
				p.municipio,
				p.estado
			from postal p
			where cast(p.codigo as UNSIGNED) like '%".$busqueda."%' or p.colonia like '%".$busqueda."%' or p.municipio like '%".$busqueda."%' or p.estado like '%".$busqueda."%'
			order by p.codigo,p.estado,p.municipio,p.colonia";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerGrillaAjax($length, $start, $busqueda,$colSort,$colSortDir, $filtros, $consulta, $pre='') {

		$where = '';

		$busqueda = str_replace("'","",$busqueda);
		if ($busqueda != '') {
			$where = str_replace("\$busqueda",$busqueda,$filtros);
		} else {
			$where = $pre;
		}

		$sql = $consulta.$where."
		ORDER BY ".$colSort." ".$colSortDir."
		limit ".$start.",".$length;

		//die(var_dump($sql));

		$res = $this->query($sql,0);
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

	function insertarEntrevistas($refpostulantes,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadopostulantes,$refestadoentrevistas,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbentrevistas(identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refpostulantes.",'".$entrevistador."','".$fecha."','".$domicilio."',".$codigopostal.",".$refestadopostulantes.",".$refestadoentrevistas.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarEntrevistas($id,$refpostulantes,$entrevistador,$fecha,$domicilio,$codigopostal,$refestadopostulantes,$refestadoentrevistas,$fechamodi,$usuariomodi) {
		$sql = "update dbentrevistas
		set
		refpostulantes = ".$refpostulantes.",entrevistador = '".$entrevistador."',fecha = '".$fecha."',domicilio = '".$domicilio."',codigopostal = ".$codigopostal.",refestadopostulantes = ".$refestadopostulantes.",refestadoentrevistas = ".$refestadoentrevistas.",fechamodi = '".$fechamodi."',usuariomodi = '".$usuariomodi."'
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


	function traerEntrevistasPorId($id) {
		$sql = "select identrevista,refpostulantes,entrevistador,fecha,domicilio,codigopostal,refestadopostulantes,refestadoentrevistas,fechacrea,fechamodi,usuariocrea,usuariomodi from dbentrevistas where identrevista =".$id;
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
		e.codigopostal,
		e.refestadopostulantes,
		e.refestadoentrevistas,
		e.fechacrea,
		e.fechamodi,e.usuariocrea,e.usuariomodi,
		concat(pp.estado, ' ', pp.municipio, ' ', pp.colonia, ' ', pp.codigo) as postalcompleto
		from dbentrevistas e
		inner join postal pp on pp.codigo = e.codigopostal
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

	function insertarEstadopostulantes($estadopostulante,$orden) {
	$sql = "insert into tbestadopostulantes(idestadopostulante,estadopostulante,orden)
	values ('','".$estadopostulante."',".$orden.")";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarEstadopostulantes($id,$estadopostulante,$orden) {
	$sql = "update tbestadopostulantes
	set
	estadopostulante = '".$estadopostulante."',orden = ".$orden."
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
		e.orden
		from tbestadopostulantes e
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}

	function traerEstadopostulantesEtapas($id) {
		$sql = "SELECT
			    e.idestadopostulante, e.estadopostulante, e.orden
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
		$sql = "select idestadopostulante,estadopostulante,orden from tbestadopostulantes where idestadopostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: tbestadopostulantes*/


	/* PARA Postulantes */

	function insertarPostulantes($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa,$ultimoestado,$refesquemareclutamiento,$afore,$compania,$cedula,$token) {
		$sql = "insert into dbpostulantes(idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,refestadocivil,nacionalidad,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa,ultimoestado,refesquemareclutamiento,afore,compania,cedula,token)
		values ('',".$refusuarios.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$curp."','".$rfc."','".$ine."','".$fechanacimiento."','".$sexo."','".$codigopostal."',".$refescolaridades.",".$refestadocivil.",'".$nacionalidad."','".$telefonomovil."','".$telefonocasa."','".$telefonotrabajo."',".$refestadopostulantes.",'".$urlprueba."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$refasesores.",".$comision.",".$refsucursalesinbursa.",".$ultimoestado.",".$refesquemareclutamiento.",'".$afore."','".$compania."','".$cedula."','".$token."')";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarPostulantes($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$refescolaridades,$refestadocivil,$nacionalidad,$telefonomovil,$telefonocasa,$telefonotrabajo,$refestadopostulantes,$urlprueba,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refasesores,$comision,$refsucursalesinbursa) {
		$sql = "update dbpostulantes
		set
		refusuarios = ".$refusuarios.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',curp = '".$curp."',rfc = '".$rfc."',ine = '".$ine."',fechanacimiento = '".$fechanacimiento."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',refescolaridades = ".$refescolaridades.",refestadocivil = ".$refestadocivil.",nacionalidad = '".$nacionalidad."',telefonomovil = '".$telefonomovil."',telefonocasa = '".$telefonocasa."',telefonotrabajo = '".$telefonotrabajo."',refestadopostulantes = ".$refestadopostulantes.",urlprueba = '".$urlprueba."',fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."',refasesores = ".$refasesores.",comision = ".$comision.",refsucursalesinbursa = ".$refsucursalesinbursa." where idpostulante =".$id;
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


	function eliminarPostulantes($id) {
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
			p.compania,
			est.estadopostulante
		FROM
			dbpostulantes p
			INNER JOIN
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
			p.refsucursalesinbursa
		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes
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
			p.refsucursalesinbursa
		from dbpostulantes p
		inner join dbusuarios usu ON usu.idusuario = p.refusuarios
		inner join tbescolaridades esc ON esc.idescolaridad = p.refescolaridades
		inner join tbestadocivil est ON est.idestadocivil = p.refestadocivil
		inner join tbestadopostulantes ep ON ep.idestadopostulante = p.refestadopostulantes
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPostulantesPorId($id) {
		$sql = "select idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa, refestadocivil from dbpostulantes where idpostulante =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerPostulantesPorIdUsuario($idusuario) {
		$sql = "select idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa, refestadocivil from dbpostulantes where refusuarios =".$idusuario;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarEstadoPostulante($id,$idestado) {
		$sql = 'update dbpostulantes set refestadopostulantes = '.$idestado.' where idpostulante = '.$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function modificarUltimoEstadoPostulante($id,$idestado) {
		$sql = 'update dbpostulantes set ultimoestado = '.$idestado.' where idpostulante = '.$id;
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
		$sql = "select iddocumentacionasesor,refpostulantes,refdocumentaciones,archivo,type,refestadodocumentaciones,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionasesores where refpostulantes =".$id." and refdocumentaciones = ".$iddocumentacion;
		$res = $this->query($sql,0);
		return $res;
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
		$sql = "select iddocumentacion,reftipodocumentaciones,documentacion,obligatoria,cantidadarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentaciones where iddocumentacion =".$id;
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

	function insertarAsesores($refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$escolaridad,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into 		dbasesores(idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigoposta	l,escolaridad,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('',".$refusuarios.",'".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$curp."','".$rfc."','".$ine."','".$fechanacimiento."','".$sexo."','".$codigopostal."','".$escolaridad."','".$telefonomovil."','".$telefonocasa."','".$telefonotrabajo."','".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";

		$res = $this->query($sql,1);
		return $res;
	}


	function modificarAsesores($id,$refusuarios,$nombre,$apellidopaterno,$apellidomaterno,$email,$curp,$rfc,$ine,$fechanacimiento,$sexo,$codigopostal,$escolaridad,$telefonomovil,$telefonocasa,$telefonotrabajo,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbasesores
		set
		refusuarios = ".$refusuarios.",nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',curp = '".$curp."',rfc = '".$rfc."',ine = '".$ine."',fechanacimiento = '".$fechanacimiento."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',escolaridad = '".$escolaridad."',telefonomovil = '".$telefonomovil."',telefonocasa = '".$telefonocasa."',telefonotrabajo = '".$telefonotrabajo."',fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."' where idasesor =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarAsesores($id) {
		$sql = "delete from dbasesores where idasesor =".$id;
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
			a.escolaridad,
			a.telefonomovil,
			a.telefonocasa,
			a.telefonotrabajo,
			a.fechacrea,
			a.fechamodi,
			a.usuariocrea,
			a.usuariomodi
			from dbasesores a
			inner join usu ON usu. = a.refusuarios
			order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerAsesoresPorId($id) {
	$sql = "select idasesor,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,escolaridad,telefonomovil,telefonocasa,telefonotrabajo,fechacrea,fechamodi,usuariocrea,usuariomodi from dbasesores where idasesor =".$id;
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
			return 'ASE'.substr('0000000'.$idcliente,-7);
		}

		return 'ASE0000001';
	}

	function insertarClientes($nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi,$refusuarios) {
		$sql = "insert into dbclientes(idcliente,nombre,apellidopaterno,apellidomaterno,email,sexo,refestadocivil,rfc,curp,fechanacimiento,numerocliente,nacionalidad,refpromotores,refrolhogar,reftipoclientes,refentidadnacimiento,fechacrea,fechamodi,usuariocrea,usuariomodi,refusuarios)
		values ('','".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$sexo."',".$refestadocivil.",'".$rfc."','".$curp."','".$fechanacimiento."','".$numerocliente."','".$nacionalidad."',".$refpromotores.",".$refrolhogar.",".$reftipoclientes.",".$refentidadnacimiento.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."',".$refusuarios.")";
		$res = $this->query($sql,1);
		return $res;
	}


	function modificarClientes($id,$nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "update dbclientes
		set
		nombre = '".$nombre."',apellidopaterno = '".$apellidopaterno."',apellidomaterno = '".$apellidomaterno."',email = '".$email."',sexo = '".$sexo."',refestadocivil = ".$refestadocivil.",rfc = '".$rfc."',curp = '".$curp."',fechanacimiento = '".$fechanacimiento."',numerocliente = '".$numerocliente."',nacionalidad = '".$nacionalidad."',refpromotores = ".$refpromotores.",refrolhogar = ".$refrolhogar.",reftipoclientes = ".$reftipoclientes.",refentidadnacimiento = ".$refentidadnacimiento.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."' where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function modificarClientesCorto($id,$refestadocivil,$rfc,$curp,$nacionalidad,$refrolhogar,$refentidadnacimiento) {
		$sql = "update dbclientes
		set
		refestadocivil = ".$refestadocivil.",rfc = '".$rfc."',curp = '".$curp."',numerocliente = '".$this->generaNroCliente()."',nacionalidad = '".$nacionalidad."',refrolhogar = ".$refrolhogar.",refentidadnacimiento = ".$refentidadnacimiento." where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function eliminarClientes($id) {
		$sql = "delete from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientes() {
		$sql = "select
		c.idcliente,
		c.nombre,
		c.apellidopaterno,
		c.apellidomaterno,
		c.email,
		c.sexo,
		c.refestadocivil,
		c.rfc,
		c.curp,
		c.fechanacimiento,
		c.numerocliente,
		c.nacionalidad,
		c.refpromotores,
		c.refrolhogar,
		c.reftipoclientes,
		c.refentidadnacimiento,
		c.fechacrea,
		c.fechamodi,
		c.usuariocrea,
		c.usuariomodi
		from dbclientes c
		order by 1";
		$res = $this->query($sql,0);
		return $res;
	}


	function traerClientesPorId($id) {
		$sql = "select idcliente,nombre,apellidopaterno,apellidomaterno,email,sexo,refestadocivil,rfc,curp,fechanacimiento,numerocliente,nacionalidad,refpromotores,refrolhogar,reftipoclientes,refentidadnacimiento,fechacrea,fechamodi,usuariocrea,usuariomodi from dbclientes where idcliente =".$id;
		$res = $this->query($sql,0);
		return $res;
	}

	function traerClientesPorIdUsuario($idusuario) {
		$sql = 'select
		idcliente,
		nombre,
		apellidopaterno,
		apellidomaterno,
		email,
		sexo,
		refestadocivil,
		rfc,
		curp,
		fechanacimiento,
		numerocliente,
		nacionalidad,
		refpromotores,
		refrolhogar,
		reftipoclientes,
		refentidadnacimiento,
		fechacrea,fechamodi,usuariocrea,usuariomodi,
		DATE_FORMAT(fechanacimiento, "%Y") as anioNacimiento,
		DATE_FORMAT(fechanacimiento, "%m") as mesNacimiento,
		DATE_FORMAT(fechanacimiento, "%d") as diaNacimiento
		from dbclientes where refusuarios ='.$idusuario;

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
   $sql = "select idestado,estado,color,icono from tbestados where idestado =".$id;
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

   function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto,$activo) {
   $sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto,activo)
   values (null,'".$usuario."','".$password."',".$refroles.",'".$email."','".$nombrecompleto."',".$activo.")";
   $res = $this->query($sql,1);
   return $res;
   }


   function modificarUsuarios($id,$usuario,$password,$refroles,$email,$nombrecompleto,$activo,$reflocatarios) {
   $sql = "update dbusuarios
   set
   usuario = '".$usuario."',password = '".$password."',refroles = ".$refroles.",email = '".$email."',nombrecompleto = '".$nombrecompleto."',activo = ".$activo." ,reflocatarios = ".($reflocatarios)."
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
   return $res;
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
   $sql = "select idusuario,usuario,password,refroles,email,nombrecompleto,(case when activo = 1 then 'Si' else 'No' end) as activo,reflocatarios from dbusuarios where idusuario =".$id;
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
