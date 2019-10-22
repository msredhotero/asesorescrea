<?php

/**
 * @Usuarios clase en donde se accede a la base de datos
 * @ABM consultas sobre las tablas de usuarios y usarios-clientes
 */

date_default_timezone_set('America/Mexico_City');

class ServiciosUsuarios {

function GUID()
{
    if (function_exists('com_create_guid') === true)
    {
        return trim(com_create_guid(), '{}');
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
}

function traerPostulantesPorId($id) {
   $sql = "select idpostulante,refusuarios,nombre,apellidopaterno,apellidomaterno,email,curp,rfc,ine,fechanacimiento,sexo,codigopostal,refescolaridades,telefonomovil,telefonocasa,telefonotrabajo,refestadopostulantes,urlprueba,fechacrea,fechamodi,usuariocrea,usuariomodi,refasesores,comision,refsucursalesinbursa, refestadocivil from dbpostulantes where idpostulante =".$id;
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

function enviarCorreosEtapas( $etapa, $id) {

   $asunto = '';
   $cuerpo = '';

   $cuerpo .= '<img src="http://www.asesorescrea.com/desarrollo/crm/imagenes/logo.png" alt="asesorescrea" width="190">';

   $cuerpo .= '<h2>¡Asesores CREA!</h2>';

   $destinatario = 'rlinares@asesorescrea.com';

   $resPostulante = $this->traerPostulantesPorId($id);

   $asesor = mysql_result($resPostulante,0,'nombre').' '.mysql_result($resPostulante,0,'apellidopaterno').' '.mysql_result($resPostulante,0,'apellidomaterno');

   $emailAsesor = mysql_result($resPostulante,0,'email');

   $urlprueba = mysql_result($resPostulante,0,'urlprueba');

   switch ($etapa) {
      case 2:
         $asunto = 'Entrevista Examen VERITAS';
         $resEntrevista = $this->traerEntrevistasActivasPorPostulanteEstadoPostulante($id,$etapa);
         $cuerpo .= '<p>Tiene un Entrevista programada para la fecha: '.mysql_result($resEntrevista,0,'fecha').' con el entrevistador: '.mysql_result($resEntrevista,0,'entrevistador').' en la direccion: '.mysql_result($resEntrevista,0,'domicilio').' , '.mysql_result($resEntrevista,0,'postalcompleto');

         break;
      case 4:
         $asunto = 'Entrevista Regional I';
         $resEntrevista = $this->traerEntrevistasActivasPorPostulanteEstadoPostulante($id,$etapa);
         $cuerpo .= '<p>Felicitaciones!!, aprobo el examen VERITAS, Tiene un Entrevista programada para la fecha: '.mysql_result($resEntrevista,0,'fecha').' con el entrevistador: '.mysql_result($resEntrevista,0,'entrevistador').' en la direccion: '.mysql_result($resEntrevista,0,'domicilio').' , '.mysql_result($resEntrevista,0,'postalcompleto');

         break;
      case 5:
         $asunto = 'URL Prueba Psicometrica';
         $cuerpo .= 'Felicitaciones!!, continua en el proceso de Reclutamiento. Le enviamos la url para realizar el examen Psicometrico: <a href="'.$urlprueba.'">Examen Psicometrico</a>';
         break;
      case 6:
         $asunto = 'Entrevista Regional II';
         $resEntrevista = $this->traerEntrevistasActivasPorPostulanteEstadoPostulante($id,$etapa);
         $cuerpo .= '<p>Felicitaciones!!, continua en el proceso de Reclutamiento, Tiene un Entrevista programada para la fecha: '.mysql_result($resEntrevista,0,'fecha').' con el entrevistador: '.mysql_result($resEntrevista,0,'entrevistador').' en la direccion: '.mysql_result($resEntrevista,0,'domicilio').' , '.mysql_result($resEntrevista,0,'postalcompleto');
         break;

   }

   $resEmail = $this->enviarEmail($destinatario,$asunto,$cuerpo);

   return $resEmail;
}


function login($usuario,$pass) {

	$sqlusu = "select * from dbusuarios where email = '".$usuario."'";

	$error = '';

	if (trim($usuario) != '' and trim($pass) != '') {

	$respusu = $this->query($sqlusu,0);

	if (mysql_num_rows($respusu) > 0) {


		$idUsua = mysql_result($respusu,0,0);
		$sqlpass = "SELECT
                   u.nombrecompleto,
                   u.email,
                   u.usuario,
                   r.descripcion,
                   r.idrol
               FROM
                   dbusuarios u
                       INNER JOIN
                   tbroles r ON r.idrol = u.refroles
               WHERE
                   password = '".$pass."' AND u.activo = 1
                       AND idusuario = ".$idUsua;


		$resppass = $this->query($sqlpass,0);

		if (mysql_num_rows($resppass) > 0) {
			$error = '';
			} else {
				$error = 'Usuario o Password incorrecto';
			}

		}
		else

		{
			$error = 'Usuario o Password incorrecto';
		}

		if ($error == '') {
			//die(var_dump($error));
			session_start();
			$_SESSION['usua_sahilices'] = $usuario;
			$_SESSION['nombre_sahilices'] = mysql_result($resppass,0,0);
			$_SESSION['usuaid_sahilices'] = $idUsua;
			$_SESSION['email_sahilices'] = mysql_result($resppass,0,1);
			$_SESSION['idroll_sahilices'] = mysql_result($resppass,0,4);
			$_SESSION['refroll_sahilices'] = mysql_result($resppass,0,3);


			return 1;
		}

	}	else {
		$error = 'Usuario y Password son campos obligatorios';
	}


	return $error;

}

function loginFacebook($usuario) {

	$sqlusu = "select concat(apellido,' ',nombre),email,direccion,refroll from se_usuarios where email = '".$usuario."'";
	$error = '';


if (trim($usuario) != '') {

$respusu = $this->query($sqlusu,0);

	if (mysql_num_rows($respusu) > 0) {


		if ($error == '') {
			session_start();
			$_SESSION['usua_predio'] = $usuario;
			$_SESSION['nombre_predio'] = mysql_result($resppass,0,0);
			$_SESSION['email_predio'] = mysql_result($resppass,0,1);
			$_SESSION['refroll_predio'] = mysql_result($resppass,0,3);
			//$error = 'andube por aca'-$sqlusu;
		}

	}	else {
		$error = 'Usuario y Password son campos obligatorios';
	}

}

	return $error;

}




function loginUsuario($usuario,$pass) {

	$sqlusu = "select * from dbusuarios where email = '".$usuario."' activo = 1";



if (trim($usuario) != '' and trim($pass) != '') {

	$respusu = $this->query($sqlusu,0);

	if (mysql_num_rows($respusu) > 0) {
		$error = '';

		$idUsua = mysql_result($respusu,0,0);
		$sqlpass = "select concat(apellido,' ',nombre),email,refroles, refclientes from dbusuarios where password = '".$pass."' and IdUsuario = ".$idUsua;

		$resppass = $this->query($sqlpass,0);

			if (mysql_num_rows($resppass) > 0) {
				$error = '';

			} else {
				if (mysql_result($respusu,0,'activo') == 0) {
					$error = 'El usuario no fue activado, verifique su cuenta de email: '.$usuario;
				} else {
					$error = 'Usuario o Password incorrecto';
				}

			}

		}
		else

		{
			$error = 'Usuario o Password incorrecto';
		}

		if ($error == '') {
			session_start();
			$_SESSION['usua_sahilices'] = $usuario;
			$_SESSION['nombre_sahilices'] = mysql_result($resppass,0,0);
			$_SESSION['email_sahilices'] = mysql_result($resppass,0,1);
			$_SESSION['refroll_sahilices'] = mysql_result($resppass,0,2);
         $_SESSION['idcliente'] = mysql_result($resppass,0,3);
		}


	}	else {
		$error = 'Usuario y Password son campos obligatorios';
	}


	return $error;

}


function traerRoles() {
	$sql = "select * from tbroles";
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al traer datos';
	} else {
		return $res;
	}
}

function traerRolesSimple() {
	$sql = "select * from tbroles where idrol > 2";
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al traer datos';
	} else {
		return $res;
	}
}


function traerUsuario($email) {
	$sql = "select idusuario,usuario,nombrecompleto,email,password from dbusuarios where email = '".$email."'";
	$res = $this->query($sql,0);
	return $res;
}

function traerUsuarios() {
	$sql = "select u.idusuario,u.usuario, u.password, r.descripcion, u.email , u.nombrecompleto, u.refroles, u.reflocatarios
			from dbusuarios u
			inner join tbroles r on u.refroles = r.idrol
			order by nombrecompleto";
	$res = $this->query($sql,0);
	return $res;
}

function traerUsuariosajax($length, $start, $busqueda) {

   $where = '';

	$busqueda = str_replace("'","",$busqueda);
	if ($busqueda != '') {
		$where = "where u.usuario like '%".$busqueda."%' or r.descripcion like '%".$busqueda."%' or u.email like '%".$busqueda."%' or u.nombrecompleto like '%".$busqueda."%'";
	}


	$sql = "select u.idusuario,
                  u.usuario,
                  r.descripcion,
                  u.email ,
                  u.nombrecompleto,
                  (case when u.activo = 1 then 'Si' else 'No' end) as activo,
                  concat(l.cognom, ' ', l.nom) as locatario,
                  u.refroles
			from dbusuarios u
			inner join tbroles r on u.refroles = r.idrol
         left join dblocatarios l on l.idlocatario = u.reflocatarios
         ".$where."
      	order by u.nombrecompleto
      	limit ".$start.",".$length;

	$res = $this->query($sql,0);
	return $res;
}


function traerUsuariosSimple() {
	$sql = "select u.idusuario,u.usuario, u.password, r.descripcion, u.email , u.nombrecompleto, u.refroles
			from dbusuarios u
			inner join tbroles r on u.refroles = r.idrol
			where r.idrol <> 1
			order by nombrecompleto";
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al traer datos';
	} else {
		return $res;
	}
}

function traerTodosUsuarios() {
	$sql = "select u.idusuario,u.usuario,u.nombrecompleto,u.refroll,u.email,u.password
			from se_usuarios u
			order by nombrecompleto";
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al traer datos';
	} else {
		return $res;
	}
}

function traerUsuarioId($id) {
	$sql = "select
            idusuario,usuario,refroles,
            nombrecompleto,email,password,
            (case when activo = 1 then 'Si' else 'No' end) as activo
         from dbusuarios where idusuario = ".$id;
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al traer datos';
	} else {
		return $res;
	}
}

function existeUsuario($usuario, $id = 0) {

   if ($id == 0) {
      $sql = "select * from dbusuarios where email = '".$usuario."'";
   } else {
      $sql = "select * from dbusuarios where email = '".$usuario."' and idusuario <> ".$id;
   }

	$res = $this->query($sql,0);
	if (mysql_num_rows($res)>0) {
		return true;
	} else {
		return false;
	}
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


function insertarUsuario($usuario,$password,$refroles,$email,$nombrecompleto) {
	$sql = "INSERT INTO dbusuarios
				(idusuario,
				usuario,
				password,
				refroles,
				email,
				nombrecompleto)
			VALUES
				(null,
				'".($usuario)."',
				'".($password)."',
				".$refroles.",
				'".($email)."',
				'".($nombrecompleto)."')";
	if ($this->existeUsuario($email) == true) {
		return "Ya existe el usuario";
	}
	$res = $this->query($sql,1);
	if ($res == false) {
		return 'Error al insertar datos';
	} else {

		return $res;
	}
}


function modificarUsuario($id,$usuario,$password,$refroles,$email,$nombrecompleto,$activo) {
	$sql = "UPDATE dbusuarios
			SET
				usuario = '".($usuario)."',
				password = '".($password)."',
				email = '".($email)."',
				refroles = ".$refroles.",
				nombrecompleto = '".($nombrecompleto)."',
            activo = ".$activo."
			WHERE idusuario = ".$id;
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al modificar datos';
	} else {
		return '';
	}
}

function reenviarActivacion($idusuario,$email) {
   $token = $this->GUID();
	$cuerpo = '';

	$fecha = date_create(date('Y').'-'.date('m').'-'.date('d'));
	date_add($fecha, date_interval_create_from_date_string('5 days'));
	$fechaprogramada =  date_format($fecha, 'Y-m-d');

   $cuerpo .= '<img src="http://www.areariderz.es/imagenes/1PNGlogosRIDERZ.png" alt="RIDERZ" width="190">';

   $cuerpo .= '<h2>¡Bienvenido a RIDERZ!</h2>';


   $cuerpo .= '<p>Usa el siguente <a href="http://www.areariderz.es/activacion.php?token='.$token.'" target="_blank">enlace</a> para confirmar tu cuenta.</p>';

   $resToken = $this->insertarActivacionusuarios($idusuario,$token,'','');

   $resEmail = $this->enviarEmail($email,'Alta de Usuario',utf8_decode($cuerpo));

   return '';
}


function registrarSocio($email, $password,$apellido, $nombre,$refcliente) {

	$token = $this->GUID();
	$cuerpo = '';

	$fecha = date_create(date('Y').'-'.date('m').'-'.date('d'));
	date_add($fecha, date_interval_create_from_date_string('30 days'));
	$fechaprogramada =  date_format($fecha, 'Y-m-d');

   $cuerpo .= '<img src="http://asesorescrea.com/img/logo.png" alt="RIDERZ" width="190">';

   $cuerpo .= '<h2>¡Bienvenido a Asesores CREA!</h2>';


   $cuerpo .= '<p>Usa el siguente <a href="http://asesorescrea.com/crm/activacion.php?token='.$token.'" target="_blank">enlace</a> para confirmar tu cuenta.</p>';


	$sql = "INSERT INTO dbusuarios
				(idusuario,
				usuario,
				password,
				refroles,
				email,
				nombrecompleto,
				activo)
			VALUES
				(null,
				'".$apellido.' '.$nombre."',
				'".$password."',
				4,
				'".$email."',
				'".$apellido.' '.$nombre."',
				0)";

	$res = $this->query($sql,1);

   if ($res == false) {
		return 'Error al insertar datos ';
	} else {
		$this->insertarActivacionusuarios($res,$token,'','');

      $sqlUpdateRelacion = "update dbclientes set refusuarios = ".$res." where idcliente =".$refcliente;
      // actualizo la relacion cliente y usuario
      $resRelacion = $this->query($sqlUpdateRelacion,0);

		$retorno = $this->enviarEmail($email,'Alta de Usuario',utf8_decode($cuerpo));

		return $res;
	}
}


/* PARA Activacionusuarios */

function insertarActivacionusuarios($refusuarios,$token,$vigenciadesde,$vigenciahasta) {
$sql = "insert into dbactivacionusuarios(idactivacionusuario,refusuarios,token,vigenciadesde,vigenciahasta)
values (null,".$refusuarios.",'".($token)."',now(),ADDDATE(now(), INTERVAL 2 DAY))";
$res = $this->query($sql,1);
return $res;
}


function modificarActivacionusuarios($id,$refusuarios,$token,$vigenciadesde,$vigenciahasta) {
$sql = "update dbactivacionusuarios
set
refusuarios = ".$refusuarios.",token = '".($token)."',vigenciadesde = '".($vigenciadesde)."',vigenciahasta = '".($vigenciahasta)."'
where idactivacionusuario =".$id;
$res = $this->query($sql,0);
return $res;
}


function modificarActivacionusuariosConcretada($token) {
$sql = "update dbactivacionusuarios
set
vigenciadesde = 'NULL',vigenciahasta = 'NULL'
where token ='".$token."'";
$res = $this->query($sql,0);
return $res;
}


function modificarActivacionusuariosRenovada($refusuarios,$token,$vigenciadesde,$vigenciahasta) {
$sql = "update dbactivacionusuarios
set
vigenciadesde = now(),vigenciahasta = ADDDATE(now(), INTERVAL 15 DAY),token = '".($token)."'
where refusuarios =".$refusuarios;
$res = $this->query($sql,0);
return $res;
}


function eliminarActivacionusuarios($id) {
$sql = "delete from dbactivacionusuarios where idactivacionusuario =".$id;
$res = $this->query($sql,0);
return $res;
}

function eliminarActivacionusuariosPorUsuario($refusuarios) {
$sql = "delete from dbactivacionusuarios where refusuarios =".$refusuarios;
$res = $this->query($sql,0);
return $res;
}


function traerActivacionusuarios() {
$sql = "select
a.idactivacionusuario,
a.refusuarios,
a.token,
a.vigenciadesde,
a.vigenciahasta
from dbactivacionusuarios a
order by 1";
$res = $this->query($sql,0);
return $res;
}


function traerActivacionusuariosPorId($id) {
$sql = "select idactivacionusuario,refusuarios,token,vigenciadesde,vigenciahasta from dbactivacionusuarios where idactivacionusuario =".$id;
$res = $this->query($sql,0);
return $res;
}


function traerActivacionusuariosPorToken($token) {
$sql = "select idactivacionusuario,refusuarios,token,vigenciadesde,vigenciahasta from dbactivacionusuarios where token ='".$token."'";
$res = $this->query($sql,0);
return $res;
}


function traerActivacionusuariosPorTokenFechas($token) {
$sql = "select idactivacionusuario,refusuarios,token,vigenciadesde,vigenciahasta from dbactivacionusuarios where token ='".$token."' and now() between vigenciadesde and vigenciahasta ";
$res = $this->query($sql,0);
return $res;
}

function traerActivacionusuariosPorUsuarioFechas($usuario) {
$sql = "select idactivacionusuario,refusuarios,token,vigenciadesde,vigenciahasta from dbactivacionusuarios where refusuarios =".$usuario." and now() between vigenciadesde and vigenciahasta ";
$res = $this->query($sql,0);
return $res;
}


function activarUsuario($refusuario, $password) {
	$sql = "update dbusuarios
	set
		activo = 1, password = '".$password."'
	where idusuario =".$refusuario;
	$res = $this->query($sql,0);
	if ($res == false) {
		return 'Error al modificar datos';
	} else {
		return '';
	}
}

/* Fin */
/* /* Fin de la Tabla: dbactivacionusuarios*/



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
