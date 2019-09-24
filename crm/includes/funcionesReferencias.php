<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('Europe/Madrid');

class ServiciosReferencias {

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

	function insertarClientes($nombre,$apellidopaterno,$apellidomaterno,$email,$sexo,$refestadocivil,$rfc,$curp,$fechanacimiento,$numerocliente,$nacionalidad,$refpromotores,$refrolhogar,$reftipoclientes,$refentidadnacimiento,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
		$sql = "insert into dbclientes(idcliente,nombre,apellidopaterno,apellidomaterno,email,sexo,refestadocivil,rfc,curp,fechanacimiento,numerocliente,nacionalidad,refpromotores,refrolhogar,reftipoclientes,refentidadnacimiento,fechacrea,fechamodi,usuariocrea,usuariomodi)
		values ('','".$nombre."','".$apellidopaterno."','".$apellidomaterno."','".$email."','".$sexo."',".$refestadocivil.",'".$rfc."','".$curp."','".$fechanacimiento."','".$numerocliente."','".$nacionalidad."',".$refpromotores.",".$refrolhogar.",".$reftipoclientes.",".$refentidadnacimiento.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
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


	/* PARA Documentacionsolicitudes */

	function insertarDocumentacionsolicitudes($refsolicitudes,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "insert into dbdocumentacionsolicitudes(iddocumentacionsolicitud,refsolicitudes,documentacion,obligatoria,cantidadarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi)
	values ('',".$refsolicitudes.",'".$documentacion."','".$obligatoria."',".$cantidadarchivos.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarDocumentacionsolicitudes($id,$refsolicitudes,$documentacion,$obligatoria,$cantidadarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "update dbdocumentacionsolicitudes
	set
	refsolicitudes = ".$refsolicitudes.",documentacion = '".$documentacion."',obligatoria = '".$obligatoria."',cantidadarchivos = ".$cantidadarchivos.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
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
	d.documentacion,
	d.obligatoria,
	d.cantidadarchivos,
	d.fechacrea,
	d.fechamodi,
	d.usuariocrea,
	d.usuariomodi
	from dbdocumentacionsolicitudes d
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerDocumentacionsolicitudesPorId($id) {
	$sql = "select iddocumentacionsolicitud,refsolicitudes,documentacion,obligatoria,cantidadarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionsolicitudes where iddocumentacionsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbdocumentacionsolicitudes*/


	/* PARA Documentacionsolicitudesarchivos */

	function insertarDocumentacionsolicitudesarchivos($refsolicitudes,$refdocumentacionsolicitudes,$archivo,$type,$refestadoarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "insert into dbdocumentacionsolicitudesarchivos(iddocumentacionsolicitudarchivo,refsolicitudes,refdocumentacionsolicitudes,archivo,type,refestadoarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi)
	values ('',".$refsolicitudes.",".$refdocumentacionsolicitudes.",'".$archivo."','".$type."',".$refestadoarchivos.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarDocumentacionsolicitudesarchivos($id,$refsolicitudes,$refdocumentacionsolicitudes,$archivo,$type,$refestadoarchivos,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "update dbdocumentacionsolicitudesarchivos
	set
	refsolicitudes = ".$refsolicitudes.",refdocumentacionsolicitudes = ".$refdocumentacionsolicitudes.",archivo = '".$archivo."',type = '".$type."',refestadoarchivos = ".$refestadoarchivos.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."'
	where iddocumentacionsolicitudarchivo =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarDocumentacionsolicitudesarchivos($id) {
	$sql = "delete from dbdocumentacionsolicitudesarchivos where iddocumentacionsolicitudarchivo =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerDocumentacionsolicitudesarchivos() {
	$sql = "select
	d.iddocumentacionsolicitudarchivo,
	d.refsolicitudes,
	d.refdocumentacionsolicitudes,
	d.archivo,
	d.type,
	d.refestadoarchivos,
	d.fechacrea,
	d.fechamodi,
	d.usuariocrea,
	d.usuariomodi
	from dbdocumentacionsolicitudesarchivos d
	order by 1";
	$res = $this->query($sql,0);
	return $res;
	}


	function traerDocumentacionsolicitudesarchivosPorId($id) {
	$sql = "select iddocumentacionsolicitudarchivo,refsolicitudes,refdocumentacionsolicitudes,archivo,type,refestadoarchivos,fechacrea,fechamodi,usuariocrea,usuariomodi from dbdocumentacionsolicitudesarchivos where iddocumentacionsolicitudarchivo =".$id;
	$res = $this->query($sql,0);
	return $res;
	}

	/* Fin */
	/* /* Fin de la Tabla: dbdocumentacionsolicitudesarchivos*/


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

	function insertarSolicitudes($reftiposolicitudes,$refestadosolicitudes,$nombre,$apellido,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "insert into dbsolicitudes(idsolicitud,reftiposolicitudes,refestadosolicitudes,nombre,apellido,email,fechanacimiento,telefono,sexo,codigopostal,reftipoingreso,refclientes,refusuarios,fechacrea,fechamodi,usuariocrea,usuariomodi)
	values ('',".$reftiposolicitudes.",".$refestadosolicitudes.",'".$nombre."','".$apellido."','".$email."','".$fechanacimiento."','".$telefono."','".$sexo."','".$codigopostal."',".$reftipoingreso.",".$refclientes.",".$refusuarios.",'".$fechacrea."','".$fechamodi."','".$usuariocrea."','".$usuariomodi."')";
	$res = $this->query($sql,1);
	return $res;
	}


	function modificarSolicitudes($id,$reftiposolicitudes,$refestadosolicitudes,$nombre,$apellido,$email,$fechanacimiento,$telefono,$sexo,$codigopostal,$reftipoingreso,$refclientes,$refusuarios,$fechacrea,$fechamodi,$usuariocrea,$usuariomodi) {
	$sql = "update dbsolicitudes
	set
	reftiposolicitudes = ".$reftiposolicitudes.",refestadosolicitudes = ".$refestadosolicitudes.",nombre = '".$nombre."',apellido = '".$apellido."',email = '".$email."',fechanacimiento = '".$fechanacimiento."',telefono = '".$telefono."',sexo = '".$sexo."',codigopostal = '".$codigopostal."',reftipoingreso = ".$reftipoingreso.",refclientes = ".$refclientes.",refusuarios = ".$refusuarios.",fechacrea = '".$fechacrea."',fechamodi = '".$fechamodi."',usuariocrea = '".$usuariocrea."',usuariomodi = '".$usuariomodi."' where idsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function eliminarSolicitudes($id) {
	$sql = "delete from dbsolicitudes where idsolicitud =".$id;
	$res = $this->query($sql,0);
	return $res;
	}


	function traerSolicitudes() {
	$sql = "select
	s.idsolicitud,
	s.reftiposolicitudes,
	s.refestadosolicitudes,
	s.nombre,
	s.apellido,
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

   function insertarUsuarios($usuario,$password,$refroles,$email,$nombrecompleto,$activo,$reflocatarios) {
   $sql = "insert into dbusuarios(idusuario,usuario,password,refroles,email,nombrecompleto,activo,reflocatarios)
   values (null,'".$usuario."','".$password."',".$refroles.",'".$email."','".$nombrecompleto."',".$activo.",".$reflocatarios.")";
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
