<?php

include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/clientes.class.php');

$serviciosFunciones = new Servicios();
$serviciosUsuario 	= new ServiciosUsuarios();
$serviciosHTML 		= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$cliente = new clienteCrea();

$resV['errores'] = array();

if ((isset($_GET['idcliente']))) {
	$idcliente = $_GET['idcliente'];
} else {
	$idcliente = '';
}

if ((isset($_GET['fechanacimiento']))) {
	$fechanacimiento = $_GET['fechanacimiento'];
} else {
	$fechanacimiento = '';
}

if ((isset($_GET['idproducto']))) {
	$idproducto = $_GET['idproducto'];
} else {
	array_push($resV['errores'],array('Mensaje'=> 'Debe ingresar un Id producto '));
}

if (count($resV['errores'])<= 0) {
   if ($idcliente != '') {
      $cliente->buscarClientePorId($idcliente);
      if ($cliente->getIdcliente() == null) {
         array_push($resV['errores'],array('Mensaje'=> 'El cliente no existe '));
      } else {
         if ($cliente->getFechanacimiento() == null) {
            array_push($resV['errores'],array('Mensaje'=> 'El cliente no tiene cargada su fecha de nacimiento '));
         } else {
            $edad = $cliente->calculaedad();

            if ($edad > 60) {
               array_push($resV['errores'],array('Mensaje'=> 'El producto no es alcanzable para su edad '));
            } else {
               $existeCotizacionParaProducto = $serviciosReferencias->traerValoredadPorProductoEdad($idproducto,$edad);

               if (mysql_num_rows($existeCotizacionParaProducto)>0) {
                  $resV['lblprecio'] = '$ '.number_format (mysql_result($existeCotizacionParaProducto,0,'valor'),2,'.',',');
                  $resV['precio'] = mysql_result($existeCotizacionParaProducto,0,'valor');
               } else {
                  array_push($resV['errores'],array('Mensaje'=> 'No existe un precio para el producto '));
               }
            }
         }

      }
   } else {
      //busco por la fecha de nacimiento nada mas
      if ($fechanacimiento != '') {
         $edad = $serviciosReferencias->calculaedad($fechanacimiento);

         $existeCotizacionParaProducto = $serviciosReferencias->traerValoredadPorProductoEdad($idproducto,$edad);

         if (mysql_num_rows($existeCotizacionParaProducto)>0) {
            $resV['lblprecio'] = '$ '.number_format (mysql_result($existeCotizacionParaProducto,0,'valor'),2,'.',',');
            $resV['precio'] = mysql_result($existeCotizacionParaProducto,0,'valor');
         } else {
            array_push($resV['errores'],array('Mensaje'=> 'No existe un precio para el producto '));
         }
      }
   }

}

if (count($resV['errores'])<= 0) {
   $resV['estatus'] = 'ok';
} else {
   $resV['estatus'] = 'error';
}

header('Content-type: application/json');
echo json_encode($resV);

?>
