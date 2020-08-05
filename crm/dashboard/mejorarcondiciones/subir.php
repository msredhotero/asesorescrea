	<?php

	session_start();

	$servidorCarpeta = 'aifzn';

	if (!isset($_SESSION['usua_sahilices']))
	{
		header('Location: ../../error.php');
	} else {

		include ('../../includes/funciones.php');
		include ('../../includes/funcionesUsuarios.php');
		include ('../../includes/funcionesHTML.php');
		include ('../../includes/funcionesReferencias.php');
		include ('../../includes/funcionesNotificaciones.php');

		include '../../includes/ImageResize.php';
		include '../../includes/ImageResizeException.php';

		$serviciosFunciones 	= new Servicios();
		$serviciosUsuario 		= new ServiciosUsuarios();
		$serviciosHTML 			= new ServiciosHTML();
		$serviciosReferencias 	= new ServiciosReferencias();
		$serviciosNotificaciones	= new ServiciosNotificaciones();

		$archivo = $_FILES['file'];

		$templocation = $archivo['tmp_name'];

		//die(var_dump($archivo['name']));
		$name = $archivo['name'];


		if (!$templocation) {
			die('No ha seleccionado ningun archivo');
		}

		$noentrar = '../../imagenes/index.php';

		$idusuario = $_SESSION['usuaid_sahilices'];
		$resultado 		= 	$serviciosReferencias->traerClientesPorUsuario($idusuario);
		$id = mysql_result($resultado,0,'idcliente');

		$idmejora = $_POST['data'];

		$resCantidadExistente = $serviciosReferencias->traerMejorarcondicionesarchivosPorMejora($idmejora);

		$token = $serviciosReferencias->GUID();

		if (mysql_num_rows($resCantidadExistente) > 3) {
			echo 'No puede subir mas archivos';
		} else {
			//$imagen = $archivo['name'];
			$type = $archivo["type"][0];

			// desarrollo
			$dir_destino = '../../archivos/mejoras/'.$idmejora;


			list($base,$extension) = explode('.',$name[0]);
			$newname = implode('.', [ 'poliza', time().$token, $extension]);

			$imagen_subida = $dir_destino.'/'.$newname;

			//die(var_dump($type));

			// desarrollo
			$nuevo_noentrar = '../../archivos/index.php';

			if (!file_exists('../../archivos/mejoras/'.$idmejora)) {
				mkdir('../../archivos/mejoras/'.$idmejora, 0777);
			}

			if (!file_exists($dir_destino)) {
				mkdir($dir_destino, 0777);
			}

			if (!file_exists($dir_destino.'/')) {
				mkdir($dir_destino.'/', 0777);
			}

			if (move_uploaded_file($templocation[0], $imagen_subida)) {
				$pos = strpos( strtolower($type), 'pdf');


				$resInsertar = $serviciosReferencias->insertarMejorarcondicionesarchivos($idmejora,$newname,date('Y-m-d H:i:s'));


				/**** creo la notificacion ******/
				$emailReferente = 'rlinares@asesorescrea.com'; //por ahora fijo
				$mensaje = 'Se presento una solicitud de mejora de poliza ';
				$idpagina = 3;
				$autor = mysql_result($resultado, 0, 'apellidopaterno').' '.mysql_result($resultado, 0, 'apellidomaterno').' '.mysql_result($resultado, 0, 'nombre');
				$destinatario = $emailReferente;
				$id1 = $resInsertar;
				$id2 = 0;
				$id3 = 0;
				$icono = 'trending_up';
				$estilo = 'bg-cyan';
				$fecha = date('Y-m-d H:i:s');
				$url = "mejorarcondiciones/ver.php?id=".$resInsertar;

				$res = $serviciosNotificaciones->insertarNotificaciones($mensaje,$idpagina,$autor,$destinatario,$id1,$id2,$id3,$icono,$estilo,$fecha,$url);
				/*** fin de la notificacion ****/

				if ($pos === false) {
					$image = new \Gumlet\ImageResize($imagen_subida);
					$image->scale(50);
					$image->save($imagen_subida);
				}

				// update a la tabla dbplanillasarbitros
				//$resEstado = $serviciosReferencias->modificarEstadoPostulante($idpostulante,3);

				echo "Archivo guardado correctamente: ".$imagen_subida;

			} else {
				echo "Error al guardar el archivo";
			}


		}








	}

	?>
