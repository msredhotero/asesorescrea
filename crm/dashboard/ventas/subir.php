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


	$id = $_POST['idasociado'];
	$iddocumentacion = $_POST['iddocumentacion'];

	$carpetaOpcion = '';
	$refperiodicidadventas = 0;
	$refventas = 0;

	switch ($iddocumentacion) {
		case 35:
			$resultado 		= 	$serviciosReferencias->traerVentasPorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id,$iddocumentacion);
			$carpetaOpcion = 'ventas';
		break;
		case 147:
			$resultado 		= 	$serviciosReferencias->traerVentasPorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id,$iddocumentacion);
			$carpetaOpcion = 'ventas';
		break;
		case 148:
			$resultado 		= 	$serviciosReferencias->traerVentasPorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id,$iddocumentacion);
			$carpetaOpcion = 'ventas';
		break;
		case 153:
			$resultado 		= 	$serviciosReferencias->traerVentasPorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id,$iddocumentacion);
			$carpetaOpcion = 'ventas';
		break;
		case 154:
			$resultado 		= 	$serviciosReferencias->traerVentasPorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id,$iddocumentacion);
			$carpetaOpcion = 'ventas';
		break;
		case 237:
			$resultado 		= 	$serviciosReferencias->traerVentasPorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacion($id,$iddocumentacion);
			$carpetaOpcion = 'ventas';
		break;
		default:
			$resultado 		= 	$serviciosReferencias->traerPeriodicidadventasdetallePorId($id);
			$resImagen = $serviciosReferencias->traerDocumentacionPorVentaDocumentacionDetalle($id,$iddocumentacion);
			$carpetaOpcion = 'cobros';
			$refperiodicidadventas = mysql_result($resultado,0,'refperiodicidadventas');
			$resPV = $serviciosReferencias->traerPeriodicidadventasPorId($refperiodicidadventas);
			$refventas = mysql_result($resPV,0,'refventas');
		break;
	}



	if (mysql_num_rows($resImagen)>0) {
		$archivoAnterior = mysql_result($resImagen,0,'archivo');
	} else {
		$archivoAnterior = '';
	}


	$imagen = $serviciosReferencias->sanear_string(basename($archivo['name']));
	$type = $archivo["type"];

	$resDocumentacion = $serviciosReferencias->traerDocumentacionesPorId($iddocumentacion);


	// desarrollo
	$dir_destino = '../../archivos/'.$carpetaOpcion.'/'.$id.'/'.mysql_result($resDocumentacion,0,'carpeta').'/';
	list($base,$extension) = explode('.',$name);
	$newname = implode('.', [mysql_result($resDocumentacion,0,'carpeta'), time(), $extension]);

	// produccion
	//$dir_destino = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.mysql_result($resFoto,0,'iddocumentacionjugadorimagen').'/';

	$imagen_subida = $dir_destino.'/'.$newname;

	// desarrollo
	$nuevo_noentrar = '../../archivos/index.php';

	// produccion
	// $nuevo_noentrar = 'https://www.saupureinconsulting.com.ar/aifzn/data/'.$_SESSION['idclub_aif'].'/'.'index.php';

	if (!file_exists('../../archivos/'.$carpetaOpcion.'/'.$id.'/')) {
		mkdir('../../archivos/'.$carpetaOpcion.'/'.$id.'/', 0777);
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



		if ($_SESSION['idroll_sahilices'] != 16) {
			$refestadodocumentacion = 5;
		} else {
			$refestadodocumentacion = 1;

		}

		if (($iddocumentacion == 35) || ($iddocumentacion == 147) || ($iddocumentacion == 148) || ($iddocumentacion == 153) || ($iddocumentacion == 154)|| ($iddocumentacion == 237)) {
			$resEliminar = $serviciosReferencias->eliminarDocumentacionventasPorVentaDocumentacion($id,$iddocumentacion);

			$resInsertar = $serviciosReferencias->insertarDocumentacionventas($id,$iddocumentacion,$newname,$type,$refestadodocumentacion,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],0);

		} else {
			$resEliminar = $serviciosReferencias->eliminarDocumentacionventasPorVentaDocumentacionDetalle($id,$iddocumentacion);

			$resInsertar = $serviciosReferencias->insertarDocumentacionventas(0,$iddocumentacion,$newname,$type,$refestadodocumentacion,date('Y-m-d H:i:s'),date('Y-m-d H:i:s'),$_SESSION['usua_sahilices'],$_SESSION['usua_sahilices'],$id);

			$verificar = $serviciosReferencias->verificaPolizaDatosCargados($refventas);

			if ($verificar['primerrecibo'] == 1 && $verificar['cantidadrecibos']<2) {
				// paso al estadi 1
				$resModEstado = $serviciosReferencias->modificarVentasUnicaDocumentacion($refventas, 'refestadoventa', 1);
			}
		}


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
