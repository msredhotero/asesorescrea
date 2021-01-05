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


	$id = $_POST['idpago'];
	$resultado 		= 	$serviciosReferencias->traerPagosPorId($id);

	$idcotizacion = mysql_result($resultado,0,'idreferencia');

	$idpagoestado = mysql_result($resultado,0,'refestado');

	if ($idpagoestado != 5) {

		// cotizacion
		$resCotizacion = $serviciosReferencias->traerCotizacionesPorId($idcotizacion);

		$resImagen = mysql_result($resultado,0,'archivos');

		$archivoAnterior = $resImagen;


		$imagen = $serviciosReferencias->sanear_string(basename($archivo['name']));
		$type = $archivo["type"];


		// desarrollo
		$dir_destino = '../../archivos/comprobantespago/'.$idcotizacion.'/';
		list($base,$extension) = explode('.',$name);
		$newname = implode('.', [ time(), $extension]);

		// produccion
		//$dir_destino = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.mysql_result($resFoto,0,'iddocumentacionjugadorimagen').'/';

		$imagen_subida = $dir_destino.'/'.$newname;

		// desarrollo
		$nuevo_noentrar = '../../archivos/index.php';

		// produccion
		// $nuevo_noentrar = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.$_SESSION['idclub_aif'].'/'.'index.php';


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

			$resInsertar = $serviciosReferencias->modificarPagosArchivo($id,$newname,$type);

			/**** creo la notificacion ******/
			$emailReferente = 'ruth-arana@asesorescrea.com'; //por ahora fijo

			$resCliente = $serviciosReferencias->traerClientesPorId(mysql_result($resCotizacion,0,'refclientes'));

			if ($idpagoestado == 1) {
				$mensaje = 'Se presento un comprobante de pago, por favor validar';
			} else {
				$mensaje = 'Se volvio a presentar un comprobante de pago, por favor validar';
			}
			$idpagina = 4;
			$autor = mysql_result($resCliente, 0, 'apellidopaterno').' '.mysql_result($resCliente, 0, 'apellidomaterno').' '.mysql_result($resCliente, 0, 'nombre');
			$destinatario = $emailReferente;
			$id1 = $id;
			$id2 = 0;
			$id3 = 0;
			$icono = 'cloud_upload';
			$estilo = 'bg-cyan';
			$fecha = date('Y-m-d H:i:s');
			$url = "listadopagos/ver.php?id=".$id;


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

	} else {
		echo "Error : El archivo se encuentra en estado aceptado, no se puede modificar";
	}



}

?>
