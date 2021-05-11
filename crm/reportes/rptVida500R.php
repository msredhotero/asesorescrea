<?php


date_default_timezone_set('America/Mexico_City');

include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

$fecha = date('Y-m-d-H-i-s');


require('fpdf.php');

include('fpdi.php');

//require 'PDFMerger.php';

//$pdfi = new PDFMerger;



//$header = array("Hora", "Cancha 1", "Cancha 2", "Cancha 3");

////***** Parametros ****////////////////////////////////

$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resCliente = $serviciosReferencias->traerClientesPorIdPDF(mysql_result($resCotizacion,0,'refclientes'));

$resAsesor = $serviciosReferencias->traerAsesoresPorId(mysql_result($resCotizacion,0,'refasesores'));

$metodopago = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

$idCliente = mysql_result($resCotizacion,0,'refclientes');

$pdf = new FPDF();

$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";
//die(var_dump($directorio));

/* local  **************************
$directorio = $_SERVER['DOCUMENT_ROOT']."asesorescrea.git/trunk/crm";
*/


/***** produccion  ******
$directorio = $_SERVER['DOCUMENT_ROOT']."crm";
*/

//rrmdir($directorio.'/archivos/postulantes/'.$id.'/foliocompleto');

#Establecemos el margen inferior:


$pdf =& new FPDI();
// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile(__DIR__.'/'.'SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 6;
$yConstCuadrado1 = 28;



if (mysql_result($resCotizacion,0,'tieneasegurado') == '1') {
    $idasegurado = mysql_result($resCotizacion,0,'refasegurados');
    $resAsegurado = $serviciosReferencias->traerAseguradosPorIdPDF($idasegurado);
 
    /// fijo para entidad federativa de nacimiento
    $pdf->SetXY(54.40, 142.00);
    $resEF = $serviciosReferencias->devolverEntidadNacimientoPorCURP(mysql_result($resAsegurado,0,'curp'), mysql_result($resAsegurado,0,'estado'));
    $pdf->Write(0, strtoupper( utf8_decode($resEF)));
    // fin de entidad federativa
 
 
 } else {
    $idasegurado = 0;
 
    /// fijo para entidad federativa de nacimiento
 
    $pdf->SetXY(54.40, 142.00);
    $resEF = $serviciosReferencias->devolverEntidadNacimientoPorCURP(mysql_result($resCliente,0,'curp'), mysql_result($resCliente,0,'estado'));
    $pdf->Write(0, strtoupper( utf8_decode($resEF)));
    // fin de entidad federativa
 }
 
 if (mysql_result($resCotizacion,0,'refbeneficiarios') > 0) {
    $idbeneficiario = mysql_result($resCotizacion,0,'refbeneficiarios');
    $resBeneficiario = $serviciosReferencias->traerAseguradosPorIdPDF($idbeneficiario);
 } else {
    $idbeneficiario = 0;
    $resBeneficiario = $serviciosReferencias->traerAseguradosPorIdPDF($idbeneficiario);
 }

 




//------------------            pagina 1            ------------------------------------------------------ 
//------------------ datos generales del solicitante ------------------------------------------------------

//emisor
$pdf->SetXY(183.2, 56.2);
$pdf->Write(0, "18118");

$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 1,3);

while ($row = mysql_fetch_array($resCuestionarioDetalle)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['default'] == '') {
      if ($row['idtiporespuesta'] == 1) {
         $pdf->Write(0, $row['respuestavalor']);
      } else {
         $pdf->Write(0, $row['respuesta']);
      }

   } else {
      $pdf->Write(0, $row['default']);
   }

}

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(1,3);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, strtoupper( utf8_decode($row['default'])));

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1,3);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == '1.1 generales') {
      if ($idasegurado > 0) {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resAsegurado,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resAsegurado,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resAsegurado,0,$row['camporeferencia']))));
               }
            }
         }

      } else {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               //die(var_dump($row['nombre']));
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resCliente,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode(mysql_result($resCliente,0,$row['camporeferencia']))));
               }


            }
         }

      }

   } else {
      if ($row['sector'] == 'beneficiario') {
         if (mysql_num_rows($resBeneficiario)>0) {

            if ($row['camporeferencia']== 'genero') {
               if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'refestadocivil') {
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {
                  if ($row['camporeferencia']== 'reftipoidentificacion') {
                     $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resBeneficiario,0,$row['camporeferencia']));

                     $pdf->Write(0, mysql_result($resTI,0,1));

                  } else {
                     $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
                  }


               }
            }
         }

      } else {
         switch ($row['tabla']) {
            case 'dbasesores':
               $pdf->Write(0, mysql_result($resAsesor,0,$row['camporeferencia']));
            break;
            case 'dbclientes':
               if ($row['camporeferencia']== 'genero') {
                  if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {

                  if ($row['camporeferencia']== 'refestadocivil') {
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                  } else {
                     $pdf->Write(0,strtoupper( utf8_decode( mysql_result($resCliente,0,$row['camporeferencia'])) ));
                     
                  }
               }

            break;
         }

      }

   }

}

//------------------            fin pagina 1            ------------------------------------------------------


//------------------            pagina 2            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile(__DIR__.'/'.'SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(2);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

//emisor = 10118

//producto a contratar = ''

//plan = 'nada por ahora'




$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 2,3);

while ($row = mysql_fetch_array($resCuestionarioDetalle)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['default'] == '') {
      if ($row['idtiporespuesta'] == 1) {
         $pdf->Write(0, $row['respuestavalor']);
      } else {
         $pdf->Write(0, $row['respuesta']);
      }

   } else {
      $pdf->Write(0, $row['default']);
   }

}

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(2,3);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(2,3);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == '1.1 generales') {
      if ($idasegurado > 0) {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resAsegurado,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resAsegurado,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resAsegurado,0,$row['camporeferencia']))));
               }
            }
         }

      } else {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resCliente,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode(mysql_result($resCliente,0,$row['camporeferencia']))));
               }


            }
         }

      }

   } else {
      if ($row['sector'] == 'beneficiario') {
         if (mysql_num_rows($resBeneficiario)>0) {

            if ($row['camporeferencia']== 'genero') {
               if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'refestadocivil') {
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {
                  if ($row['camporeferencia']== 'reftipoidentificacion') {
                     $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resBeneficiario,0,$row['camporeferencia']));

                     $pdf->Write(0, mysql_result($resTI,0,1));

                  } else {
                     $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
                  }


               }
            }
         }

      } else {
         switch ($row['tabla']) {
            case 'dbasesores':
               $pdf->Write(0, mysql_result($resAsesor,0,$row['camporeferencia']));
            break;
            case 'dbclientes':
               if ($row['camporeferencia']== 'genero') {
                  if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {

                  if ($row['camporeferencia']== 'refestadocivil') {
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                  } else {
                     $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
                  }
               }

            break;
         }

      }

   }

}


//------------------            fin pagina 2            ------------------------------------------------------


//------------------            pagina 3            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile(__DIR__.'/'.'SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(3);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

//cambiar rebeneficiario irrevocable a irrevocable

//forma de pago


$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 3,3);

while ($row = mysql_fetch_array($resCuestionarioDetalle)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['default'] == '') {
      if ($row['idtiporespuesta'] == 1) {
         $pdf->Write(0, $row['respuestavalor']);
      } else {
         $pdf->Write(0, $row['respuesta']);
      }

   } else {
      $pdf->Write(0, $row['default']);
   }

}

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(3,3);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(3,3);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante') {
      if ($idasegurado > 0) {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resAsegurado,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resAsegurado,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resAsegurado,0,$row['camporeferencia']))));
               }
            }
         }

      } else {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resCliente,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode(mysql_result($resCliente,0,$row['camporeferencia']))));
               }


            }
         }

      }

   } else {
      if ($row['sector'] == 'beneficiario') {
         if (mysql_num_rows($resBeneficiario)>0) {

            if ($row['camporeferencia']== 'genero') {
               if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'refestadocivil') {
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {
                  if ($row['camporeferencia']== 'reftipoidentificacion') {
                     $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resBeneficiario,0,$row['camporeferencia']));

                     $pdf->Write(0, mysql_result($resTI,0,1));

                  } else {
                     if ($row['camporeferencia']== 'reftipoparentesco') {
                        $resTI = $serviciosReferencias->traerTipoparentescoPorId(mysql_result($resBeneficiario,0,$row['camporeferencia']));

                        $pdf->Write(0, mysql_result($resTI,0,1));
                     } else {
                        $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
                     }
                  }


               }
            }
         }

      } else {
         switch ($row['tabla']) {
            case 'dbasesores':
               $pdf->Write(0, mysql_result($resAsesor,0,$row['camporeferencia']));
            break;
            case 'dbclientes':
               if ($row['camporeferencia']== 'genero') {
                  if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {

                  if ($row['camporeferencia']== 'refestadocivil') {
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                  } else {
                     $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
                  }
               }

            break;
         }

      }

   }

}


//------------------            fin pagina 3            ------------------------------------------------------


//------------------            pagina 4            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile(__DIR__.'/'.'SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(4);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);



$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 4,3);

while ($row = mysql_fetch_array($resCuestionarioDetalle)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['default'] == '') {
      if ($row['idtiporespuesta'] == 1) {
         $pdf->Write(0, $row['respuestavalor']);
      } else {
         $pdf->Write(0, $row['respuesta']);
      }

   } else {
      $pdf->Write(0, $row['default']);
   }

}

$municipioCliente = mysql_result($resCliente,0,'municipio');
$estadoCliente = mysql_result($resCliente,0,'estado');

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(4,3);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   switch ($row['default']) {
      case 'fecha':
         $pdf->Write(0, date('d/m/Y'));
      break;
      case 'lugar y fecha de solicitud':
         $pdf->Write(0, utf8_decode($municipioCliente).' - '.utf8_decode($estadoCliente));
      break;
      default:
         $pdf->Write(0, $row['default']);
      break;
   }


}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(4,3);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante') {
      if ($idasegurado > 0) {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resAsegurado,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resAsegurado,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resAsegurado,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resAsegurado,0,$row['camporeferencia']))));
               }
            }
         }

      } else {
         if ($row['camporeferencia']== 'genero') {
            if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
               $pdf->Write(0, 'x');
            }
         } else {

            if ($row['camporeferencia']== 'refestadocivil') {
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
               if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'reftipoidentificacion') {
                  $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resCliente,0,$row['camporeferencia']));

                  $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode(mysql_result($resCliente,0,$row['camporeferencia']))));
               }


            }
         }

      }

   } else {
      if ($row['sector'] == 'beneficiario') {
         if (mysql_num_rows($resBeneficiario)>0) {

            if ($row['camporeferencia']== 'genero') {
               if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == $row['nombre']) {
                  $pdf->Write(0, 'x');
               }
            } else {

               if ($row['camporeferencia']== 'refestadocivil') {
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
                  if (mysql_result($resBeneficiario,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {
                  if ($row['camporeferencia']== 'reftipoidentificacion') {
                     $resTI = $serviciosReferencias->traerTipoidentificacionPorId(mysql_result($resBeneficiario,0,$row['camporeferencia']));

                     $pdf->Write(0, mysql_result($resTI,0,1));

                  } else {
                     $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
                  }


               }
            }
         }

      } else {
         switch ($row['tabla']) {
            case 'dbasesores':
               $pdf->Write(0, mysql_result($resAsesor,0,$row['camporeferencia']));
            break;
            case 'dbclientes':
               if ($row['camporeferencia']== 'genero') {
                  if (mysql_result($resCliente,0,$row['camporeferencia']) == $row['nombre']) {
                     $pdf->Write(0, 'x');
                  }
               } else {

                  if ($row['camporeferencia']== 'refestadocivil') {
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 1 && 'soltero' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                     if (mysql_result($resCliente,0,$row['camporeferencia']) == 2 && 'casado' == $row['nombre']) {
                        $pdf->Write(0, 'x');
                     }
                  } else {
                     $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
                  }
               }

            break;
         }

      }

   }

}


//------------------            fin pagina 4            ------------------------------------------------------

//------------------            pagina 5          ------------------------------------------------------
// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile(__DIR__.'/'.'SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(5);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

//participacion = 100%

//nombre =  Javier A. Foncerrada

// numero condusef = 'falta'

//clave
//$pdf->SetXY(18.1, 86.6);
//$pdf->Write(0, "x");
//echo "3,4,'comisiones',".$pdf->GetX().",".$pdf->GetY().",'clave','','clave'".'<br>';


//participacion = 100%
//clave
$pdf->SetXY(27.6, 92.2);
$pdf->Write(0, "100");
//echo "3,4,'comisiones',".$pdf->GetX().",".$pdf->GetY().",'clave','','clave'".'<br>';



//nombre =  Javier A. Foncerrada
//nombre y firma
$pdf->SetXY(45.6, 92.2);
$pdf->Write(0, "Javier A. Foncerrada");
//echo "3,4,'comisiones',".$pdf->GetX().",".$pdf->GetY().",'nombre y firma','','nombre y firma'".'<br>';


//dia
$pdf->SetXY(138.8, 258.9);
$pdf->Write(0, data('d'));
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'dia','','dia'".'<br>';
//condusef
$pdf->SetXY(152.9, 258.9);
switch (date('m')) {
   case '01':
      $pdf->Write(0, 'Enero');
   break;
   case '02':
      $pdf->Write(0, 'Febrero');
   break;
   case '03':
      $pdf->Write(0, 'Marzo');
   break;
   case '04':
      $pdf->Write(0, 'Abril');
   break;
   case '05':
      $pdf->Write(0, 'Mayo');
   break;
   case '06':
      $pdf->Write(0, 'Junio');
   break;
   case '07':
      $pdf->Write(0, 'Julio');
   break;
   case '08':
      $pdf->Write(0, 'Agosto');
   break;
   case '09':
      $pdf->Write(0, 'Septiembre');
   break;
   case '10':
      $pdf->Write(0, 'Octubre');
   break;
   case '11':
      $pdf->Write(0, 'Noviembre');
   break;
   case '12':
      $pdf->Write(0, 'Diciembre');
   break;
}
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'mes','','mes'".'<br>';
//condusef
$pdf->SetXY(163.4, 258.9);
$pdf->Write(0, date('Y'));
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'anio','','anio'".'<br>';

// numero condusef = 'falta'
//condusef
$pdf->SetXY(7, 262,6);
$pdf->Write(0, "000");
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'condusef','','condusef'".'<br>';


//------------------            fin pagina 5            ------------------------------------------------------





$pdf->Output( __DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/FSOLICITUDAC.pdf', 'F');


?>
