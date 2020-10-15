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

		$name = $serviciosReferencias->sanear_string(str_replace(' ','',basename($archivo['name'])));


		if (!$templocation) {
		die('No ha seleccionado ningun archivo');
		}

		$noentrar = '../../imagenes/index.php';

		$id = $_POST['idfamiliar'];
		$resultado 		= 	$serviciosReferencias->traerAseguradosPorId($id);


		$iddocumentacion = $_POST['iddocumentacion'];

		$resImagen = $serviciosReferencias->traerDocumentacionPorFamiliarDocumentacion($id,$iddocumentacion);

		if (mysql_num_rows($resImagen)>0) {
			$archivoAnterior = mysql_result($resImagen,0,'archivo');
		} else {
			$archivoAnterior = '';
		}


		$imagen = $serviciosReferencias->sanear_string(basename($archivo['name']));
		$type = $archivo["type"];

		$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);


		// desarrollo
		$dir_destino = '../../archivos/familiares/'.$id.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';
		list($base,$extension) = explode('.',$name);
		$newname = implode('.', [mysql_result($resDocumentacion,0,'carpeta'), time(), $extension]);

		// produccion
		//$dir_destino = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.mysql_result($resFoto,0,'iddocumentacionjugadorimagen').'/';

		$imagen_subida = $dir_destino.'/'.$newname;

		// desarrollo
		$nuevo_noentrar = '../../archivos/index.php';

		// produccion
		// $nuevo_noentrar = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.$_SESSION['idclub_aif'].'/'.'index.php';

		if (!file_exists('../../archivos/familiares/'.$id.'/')) {
			mkdir('../../archivos/familiares/'.$id.'/', 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}

		if (!file_exists($dir_destino.'/')) {
			mkdir($dir_destino.'/', 0777);
		}

		//borro el archivo anterior
		if ($archivoAnterior != '') {
			unlink($dir_destino.'/'.$archivoAnterior);
		}

		if (move_uploaded_file($templocation, $imagen_subida)) {
			$pos = strpos( strtolower($type), 'pdf');

			$resEliminar = $serviciosReferencias->eliminarDocumentacionfamiliaresPorFamiliarDocumentacion($id,$iddocumentacion);

			$resInsertar = $serviciosReferencias->insertarDocumentacionfamiliares($id,$iddocumentacion,$newname,$type,1,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices']);

			/**** creo la notificacion ******/
			$emailReferente = 'ruth-arana@asesorescrea.com'; //por ahora fijo
			$mensaje = 'Se presento una documentacion: '.mysql_result($resDocumentacion,0,'documentacion');
			$idpagina = 3;
			$autor = mysql_result($resultado, 0, 'apellidopaterno').' '.mysql_result($resultado, 0, 'apellidomaterno').' '.mysql_result($resultado, 0, 'nombre');
			$destinatario = $emailReferente;
			$id1 = $id;
			$id2 = 0;
			$id3 = 0;
			$icono = 'person_add';
			$estilo = 'bg-light-green';
			$fecha = date('Y-m-d H:i:s');
			$url = "enproceso/subirdocumentacionif.php?id=".$id."&documentacion=".$iddocumentacion;

			$res = $serviciosNotificaciones->insertarNotificaciones($mensaje,$idpagina,$autor,$destinatario,$id1,$id2,$id3,$icono,$estilo,$fecha,$url);
			/*** fin de la notificacion ****/

			if ($pos === false) {
				$image = new \Gumlet\ImageResize($imagen_subida);
				$image->scale(50);
				$image->save($imagen_subida);
			}

			// update a la tabla dbplanillasarbitros
			//$resEstado = $serviciosReferencias->modificarEstadoPostulante($idpostulante,3);

			echo "Archivo guardado correctamente";

		} else {
			echo "Error al guardar el archivo";
		}



	}

	?>
