<?php


date_default_timezone_set('America/Mexico_City');

//include ('../includes/funcionesUsuarios.php');
//include ('../includes/funciones.php');
//include ('../includes/funcionesHTML.php');
//include ('../includes/funcionesReferencias.php');

/*
$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

$fecha = date('Y-m-d-H-i-s');
*/

require('fpdf.php');

include('fpdi.php');

$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resCliente = $serviciosReferencias->traerClientesPorIdPDF(mysql_result($resCotizacion,0,'refclientes'));

$resAsesor = $serviciosReferencias->traerAsesoresPorId(mysql_result($resCotizacion,0,'refasesores'));

$metodopago = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

$idCliente = mysql_result($resCotizacion,0,'refclientes');

$pdf = new FPDF();

$pdfi = new FPDI();

$pdf =& new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";
//die(var_dump($directorio));

/////////////////////////////////////// pagina 1 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 7.7;
$yConstCuadrado1 = 58;

$pdf->Image(__DIR__.'/'.'F20926_0001.png' , 0 ,0, 210 , 0,'PNG');


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



////*************** datos **********************************/
$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 1);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(1);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante titular') {
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

////*************** fin datos **********************************/

/////////////////////////////////////// pagina 2 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 148.5;

$pdf->Image(__DIR__.'/'.'F20926_0002.png' , 0 ,0, 210 , 0,'PNG');

////*************** datos **********************************/

if ($idasegurado > 0) {

   $resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 2);

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

   $resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(2);
   while ($row = mysql_fetch_array($resReferenciasFijo)) {
      $pdf->SetXY($row['x'], $row['y']);
      $pdf->Write(0, $row['default']);

   }

   $resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(2);

   while ($row = mysql_fetch_array($resReferencias)) {
      $pdf->SetXY($row['x'], $row['y']);
      if ($row['sector'] == 'datos generales del contratante') {

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

                  $pdf->Write(0, strtoupper( utf8_decode(mysql_result($resTI,0,1))));

               } else {
                  $pdf->Write(0, strtoupper( utf8_decode(mysql_result($resCliente,0,$row['camporeferencia']))));
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
                     $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
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
}

////*************** fin datos **********************************/


/////////////////////////////////////// pagina 3 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 32.5;

$pdf->Image(__DIR__.'/'.'F20926_0003.png' , 0 ,0, 210 , 0,'PNG');


////*************** datos **********************************/
$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 3);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(3);
while ($row = mysql_fetch_array($resReferenciasFijo)) {

   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}

$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(3);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante titular') {
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
               $pdf->Write(0, mysql_result($resAsegurado,0,$row['camporeferencia']));
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
               $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
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
                  $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
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

////*************** fin datos **********************************/



/*************** IMPORTANTE: lo resulevo yo *********************************************************************/
//SECCION cobro bancario


switch (mysql_result($metodopago,0,'reftipoperiodicidad')) {
   case 1:
      $pdf->SetXY(109.5, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
      $pdf->Write(0, substr("x",0,1));
   break;
   case 2:
      $pdf->SetXY(129.5, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
      $pdf->Write(0, substr("x",0,1));
   break;
   case 3:
      $pdf->SetXY(154, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
      $pdf->Write(0, substr("x",0,1));
   break;
   case 4:
      $pdf->SetXY(178, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
      $pdf->Write(0, substr("x",0,1));
   break;

}

if (mysql_result($metodopago,0,'reftipocobranza') == 1) {
   //cobro bancario (si)
   $pdf->SetXY(35, $yConstCuadrado1 + ($yCuadrado1 * 9) - 1 );
   //echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
   $pdf->Write(0, substr("x",0,1));


   //SECCION seleccione debito y credito

   if (mysql_result($metodopago,0,'tipotarjeta') == 1) {
      //banco
      $pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 11) );
      //echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
      $pdf->Write(0, mysql_result($metodopago,0,'banco'));

      //nro tarjeta
      $pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 11) + 0.2);
      //echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
      $pdf->Write(0, $serviciosReferencias->decryptIt( mysql_result($metodopago,0,'afiliacionnumber')));

      //fecha vencimiento
      $pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 11) );
      //echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
      $pdf->Write(0, '');
   } else {

      //cuenta cheques banco
      $pdf->SetXY(42, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4);
      //echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
      $pdf->Write(0, mysql_result($metodopago,0,'banco'));

      //nro cuenta cheques
      $pdf->SetXY(116, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4);
      //echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
      $pdf->Write(0, $serviciosReferencias->decryptIt( mysql_result($metodopago,0,'afiliacionnumber')));
   }
} else {
   //cobro bancario (no)
   $pdf->SetXY(64, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
   //echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
   $pdf->Write(0, substr("x",0,1));
}

//SECCION forma de pago
//forma de pago (anual)

//echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';



/*************** FIN IMPORTANTE: lo resulevo yo *********************************************************************/



/////////////////////////////////////// pagina 4 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image(__DIR__.'/'.'F20926_0004.png' , 0 ,0, 210 , 0,'PNG');


////*************** datos **********************************/
$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 4);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(4);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   if ($idbeneficiario == 0) {
      if (($row['nombre'] != 'porcentaje (simpre 100%)') && ($row['nombre'] != 'pais de nacimiento') && ($row['nombre'] != 'revocable') && ($row['nombre'] != 'nacionalidad')) {
         $pdf->SetXY($row['x'], $row['y']);
         $pdf->Write(0, $row['default']);
      }
   } else {
      $pdf->SetXY($row['x'], $row['y']);
      $pdf->Write(0, $row['default']);
   }
}

$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(4);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante titular') {
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
               $pdf->Write(0, mysql_result($resAsegurado,0,$row['camporeferencia']));
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
               $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
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
                  if ($row['camporeferencia']== 'reftipoparentesco') {
                     $resParentesco = $serviciosReferencias->traerTipoparentescoPorId(mysql_result($resBeneficiario,0,$row['camporeferencia']));

                     $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resParentesco,0,1))));
                  } else {
                     $pdf->Write(0, strtoupper( utf8_decode( mysql_result($resBeneficiario,0,$row['camporeferencia']))));
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

////*************** fin datos **********************************/

/////////////////////////////////////// pagina 5 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 3.8;
$yConstCuadrado1 = 51.7;

$pdf->Image(__DIR__.'/'.'F20926_0005.png' , 0 ,0, 210 , 0,'PNG');


////*************** datos **********************************/
$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 5);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(5);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}

$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(5);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante titular') {
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
               $pdf->Write(0, mysql_result($resAsegurado,0,$row['camporeferencia']));
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
               $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
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
                  $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
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

////*************** fin datos **********************************/



/////////////////////////////////////// pagina 6 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 126;

$pdf->Image(__DIR__.'/'.'F20926_0006.png' , 0 ,0, 210 , 0,'PNG');


////*************** datos **********************************/
$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 6);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(6);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}

$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(6);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante titular') {
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
               $pdf->Write(0, mysql_result($resAsegurado,0,$row['camporeferencia']));
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
               $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
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
                  $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
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

////*************** fin datos **********************************/


/////////////////////////////////////// pagina 7 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 112;

$pdf->Image(__DIR__.'/'.'F20926_0007.png' , 0 ,0, 210 , 0,'PNG');



////*************** datos **********************************/

///// fijo nombre del asesor ////
$pdf->SetXY(50, 189.5);
$pdf->Write(0, strtoupper( utf8_decode( mysql_result($resAsesor,0,'apellidopaterno').' '.mysql_result($resAsesor,0,'apellidomaterno').' '.mysql_result($resAsesor,0,'nombre'))));
///////////////

$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 7);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(7);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   switch ($row['default']) {
      case 'fecha':
         $pdf->Write(0, date('d-m-Y'));
      break;
      default:
         $pdf->Write(0, $row['default']);
      break;
   }


}

$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(7);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'datos generales del solicitante titular') {
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
               $pdf->Write(0, mysql_result($resAsegurado,0,$row['camporeferencia']));
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
               $pdf->Write(0, mysql_result($resCliente,0,$row['camporeferencia']));
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
                  $pdf->Write(0, mysql_result($resBeneficiario,0,$row['camporeferencia']));
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

////*************** fin datos **********************************/


/////////////////////////////////// INE //////////////////////////////////////////////
$documentacionesrequeridas = $serviciosReferencias->traerDocumentacionPorClienteDocumentacionCompletaIn($idCliente,'3,4');


while ($rowD = mysql_fetch_array($documentacionesrequeridas)) {
   $pdf->AddPage();

   $pdf->SetFont('Arial','',8);
   $pdf->SetTextColor(0,0,0);

   $yCuadrado1 = 5;
   $yConstCuadrado1 = 20;

   //$tipo =

   //die(var_dump())

   if (strpos( strtolower($rowD['type']),"pdf") !== false) {
      // set the sourcefile
      $pdf->setSourceFile(__DIR__.'/'.'../archivos/clientes/'.$idCliente.'/'.$rowD['carpeta'].'/'.$rowD['archivo']);


      // import page 1
      $tplIdx = $pdf->importPage(1);

      $pdf->useTemplate($tplIdx, 0, 0);
   } else {
      $pdf->Image(__DIR__.'/'.'../archivos/clientes/'.$idCliente.'/'.$rowD['carpeta'].'/'.$rowD['archivo'] , 0 ,0, 100 , 0,explode('/',$rowD['type'])[1]);
   }


}


////////////////////////////// FIN DEL INE //////////////////////////////////////////

if (!file_exists(__DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/')) {
   mkdir(__DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/', 0777);
}

$pdf->Output( __DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/FSOLICITUDAC.pdf', 'F');


?>
