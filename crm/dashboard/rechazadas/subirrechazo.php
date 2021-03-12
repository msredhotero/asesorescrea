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

		function deleteDirectory($dir) {
		    if(!$dh = @opendir($dir)) return;
		    while (false !== ($current = readdir($dh))) {
		        if($current != '.' && $current != '..') {
	
		            if (!@unlink($dir.'/'.$current))
		                deleteDirectory($dir.'/'.$current);
		        }
		    }
		    closedir($dh);

		    @rmdir($dir);
		}

		$name = $serviciosReferencias->sanear_string(str_replace(' ','',basename($archivo['name'])));


		if (!$templocation) {
		die('No ha seleccionado ningun archivo');
		}

		$noentrar = '../../imagenes/index.php';

		if ($_SESSION['idroll_sahilices'] == 10) {
			$idusuario = $_SESSION['usuaid_sahilices'];
			$resultado 		= 	$serviciosReferencias->traerCotizacionesPorUsuario($idusuario);
			$id = mysql_result($resultado,0,'idcotizacion');
		} else {
			$id = $_POST['idasociado'];
			$resultado 		= 	$serviciosReferencias->traerCotizacionesPorId($id);
		}


		$imagen = $serviciosReferencias->sanear_string(basename($archivo['name']));
		$type = $archivo["type"];


		// desarrollo
		$dir_destino = '../../archivos/rechazos/'.$id.'/';
		list($base,$extension) = explode('.',$name);
		$newname = implode('.', ['rechazo', time(), $extension]);

		// produccion
		//$dir_destino = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.mysql_result($resFoto,0,'iddocumentacionjugadorimagen').'/';

		$imagen_subida = $dir_destino.'/'.$newname;

		// desarrollo
		$nuevo_noentrar = '../../archivos/index.php';

		// produccion
		// $nuevo_noentrar = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.$_SESSION['idclub_aif'].'/'.'index.php';

		//unlink($dir_destino);
		deleteDirectory($dir_destino);

		if (!file_exists('../../archivos/cotizaciones/'.$id)) {
			mkdir('../../archivos/cotizaciones/'.$id, 0777);
		}

		if (!file_exists($dir_destino)) {
			mkdir($dir_destino, 0777);
		}

		if (!file_exists($dir_destino.'/')) {
			mkdir($dir_destino.'/', 0777);
		}

		//borro el archivo anterior




		if (move_uploaded_file($templocation, $imagen_subida)) {
			$pos = strpos( strtolower($type), 'pdf');

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
