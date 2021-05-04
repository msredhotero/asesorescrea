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



$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resCliente = $serviciosReferencias->traerClientesPorIdPDF(mysql_result($resCotizacion,0,'refclientes'));

$resAsesor = $serviciosReferencias->traerAsesoresPorId(mysql_result($resCotizacion,0,'refasesores'));

$metodopago = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

$idCliente = mysql_result($resCotizacion,0,'refclientes');

$pdf = new FPDF();

$pdf->SetMargins(0,0,0);

//$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";


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

///********************* pagina 1 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-1.png' , 0 ,0, 210 , 0,'PNG');


//fecha solicitud
$pdf->SetXY(142.4, 43.9);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'fecha solicitud',".$pdf->GetX().",".$pdf->GetY().",'fecha solicitud','','fecha solicitud'".'<br>';


$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 1,4);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(1,4);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1,4);

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

///********************* fin pagina 1 **********************************************/


///********************* pagina 2 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-2.png' , 0 ,0, 210 , 0,'PNG');


$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 1,4);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(1,4);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1,4);

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

///********************* fin pagina 2 **********************************************/


///********************* pagina 3 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-3.png' , 0 ,0, 210 , 0,'PNG');


$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 1,4);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(1,4);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1,4);

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


///********************* fin pagina 3 **********************************************/


///********************* pagina 4 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-4.png' , 0 ,0, 210 , 0,'PNG');




///********************* fin pagina 4 **********************************************/


///********************* pagina 5 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-5.png' , 0 ,0, 210 , 0,'PNG');


// dia
$pdf->SetXY(158, 151);
//$pdf->Write(0, date('d'));
echo "4,3,'fecha de la solicitud',".$pdf->GetX().",".$pdf->GetY().",'dia','','dia'".'<br>';

// mes
$pdf->SetXY(181, 151);
//$pdf->Write(0, date('M'));
echo "4,3,'fecha de la solicitud',".$pdf->GetX().",".$pdf->GetY().",'mes','','mes'".'<br>';

// anio
$pdf->SetXY(198.4, 151);
//$pdf->Write(0, date('y'));
echo "4,3,'fecha de la solicitud',".$pdf->GetX().",".$pdf->GetY().",'anio','','anio'".'<br>';




///********************* fin pagina 5 **********************************************/



//$pdf->Output('VRIMcompletoAC.pdf', 'I');

$pdf->Output( __DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/VRIMcompletoAC.pdf', 'F');



?>
