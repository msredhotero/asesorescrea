<?php
session_start();

if (!isset($_SESSION['usua_sahilices']))
{
	header('Location: ../../error.php');
} else {

   include ('../../includes/funcionesReferencias.php');
   $serviciosReferencias 	= new ServiciosReferencias();

   if(!empty($_GET['file'])){
      //$carpeta = $serviciosReferencias->decryptIt($_GET['c']);
		$carpeta = $_GET['c'];
      $ikey = $_GET['ikey'];
       $fileName = basename($_GET['file']);
       $filePath = "../../archivos/firmas/cotizaciones/".$ikey.'/'.$carpeta.'/'.$_GET['file'];

       //die(var_dump($filePath));
       if(!empty($fileName) && file_exists($filePath)){
           // Define headers
           header("Cache-Control: public");
           header("Content-Description: File Transfer");
           header("Content-Disposition: attachment; filename=$fileName");
           header("Content-Type: application/zip");
           header("Content-Transfer-Encoding: binary");

           // Read the file
           readfile($filePath);
           exit;
       }else{
           echo 'The file does not exist.';
       }
   }

}
