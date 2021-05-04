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
$pdf->setSourceFile('SolicitudproductoVida500.pdf');
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
    $pdf->SetXY(106, 99.5);
    $resEF = $serviciosReferencias->devolverEntidadNacimientoPorCURP(mysql_result($resAsegurado,0,'curp'), mysql_result($resAsegurado,0,'estado'));
    $pdf->Write(0, $resEF);
    // fin de entidad federativa
 
    /// fijo para entidad federativa de nacimiento
    $pdf->SetXY(75, 185.5);
    $resEF = $serviciosReferencias->devolverEntidadNacimientoPorCURP(mysql_result($resCliente,0,'curp'), mysql_result($resCliente,0,'estado'));
    $pdf->Write(0, $resEF);
    // fin de entidad federativa
 
 } else {
    $idasegurado = 0;
 
    /// fijo para entidad federativa de nacimiento
 
    $pdf->SetXY(106, 99.5);
    $resEF = $serviciosReferencias->devolverEntidadNacimientoPorCURP(mysql_result($resCliente,0,'curp'), mysql_result($resCliente,0,'estado'));
    $pdf->Write(0, $resEF);
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
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1,3);

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

//------------------            fin pagina 1            ------------------------------------------------------


//------------------            pagina 2            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(2);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


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


//------------------            fin pagina 2            ------------------------------------------------------


//------------------            pagina 3            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(3);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


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


//------------------            fin pagina 3            ------------------------------------------------------


//------------------            pagina 4            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('SolicitudproductoVida500.pdf');
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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(4,3);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

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
$pdf->setSourceFile('SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(5);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);




//------------------            fin pagina 5            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('SolicitudproductoVida500.pdf');
// import page 1
$tplIdx = $pdf->importPage(4);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

//$pdf->Output('Vida500AC.pdf', 'I');


$pdf->Output( __DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/Vida500AC.pdf', 'F');


?>
