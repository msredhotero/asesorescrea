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


   $id = $_POST['idtransferencia'];
   $resultado 		= 	$serviciosReferencias->traerTransferenciasPorId($id);




   if (mysql_num_rows($resultado)>0) {
      $archivoAnterior = mysql_result($resultado,0,'archivo');
   } else {
      $archivoAnterior = '';
   }


   $imagen = $serviciosReferencias->sanear_string(basename($archivo['name']));
   $type = $archivo["type"];




   // desarrollo
   $dir_destino = '../../archivos/transferencias/'.$id;
   list($base,$extension) = explode('.',$name);
   $newname = implode('.', ['transferencias', time(), $extension]);

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

      $resEliminar = $serviciosReferencias->modificarTransferenciasArchivo($id,$newname,$type);


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
