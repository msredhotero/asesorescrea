<?php


date_default_timezone_set('America/Mexico_City');


/*
include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();

$fecha = date('Y-m-d-H-i-s');
*/

require('fpdf.php');



$id         =  $_GET['id'];

$resCotizacion = $serviciosReferencias->traerCotizacionesPorIdCompleto($id);

$resCliente = $serviciosReferencias->traerClientesPorIdPDF(mysql_result($resCotizacion,0,'refclientes'));

$resAsesor = $serviciosReferencias->traerAsesoresPorId(mysql_result($resCotizacion,0,'refasesores'));

$metodopago = $serviciosReferencias->traerMetodopagoPorCotizacionCompleto($id);

$resPago = $serviciosReferencias->traerPagosPorTablaReferencia(12, 'dbcotizaciones', 'idcotizacion', $id);

$idCliente = mysql_result($resCotizacion,0,'refclientes');

$idProducto = mysql_result($resCotizacion,0,'refproductos');

$total = mysql_result($resCotizacion,0,'primatotal');

$pdf = new FPDF();

$pdf->SetMargins(0,0,0);

//$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";


if (mysql_result($resCotizacion,0,'tieneasegurado') == '1') {
    $idasegurado = mysql_result($resCotizacion,0,'refasegurados');
    $resAsegurado = $serviciosReferencias->traerAseguradosPorIdPDF($idasegurado);
 
 } else {
    $idasegurado = 0;
 
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

$pdf->Image(__DIR__.'/'.'SolicitudAfiliacionVrim-1.png' , 0 ,0, 210 , 0,'PNG');



// fecha solicitud
$pdf->SetXY(142.40, 43.90);
$pdf->Write(0, date('d/m/Y'));

$resVRIMoficial = $serviciosReferencias->devolverCodigoProductoOficial($idProducto);
//tipo tarjeta configurar
$pdf->SetXY(55.40, 214.00);
$pdf->Write(0, $resVRIMoficial['nombre']);

//codigo producto
$pdf->SetXY(111.40, 214.00);
$pdf->Write(0, $resVRIMoficial['codigoproducto']);

//dividir segundo nombre - ver

//domicilio fiscal, solo si quiere facturar y lo saco del rfc.


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
   $pdf->Write(0, strtoupper( utf8_decode( $row['default'])));

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(1,4);

while ($row = mysql_fetch_array($resReferencias)) {
   $pdf->SetXY($row['x'], $row['y']);
   if ($row['sector'] == 'generales') {
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
                     $pdf->Write(0,strtoupper( utf8_decode( mysql_result($resCliente,0,$row['camporeferencia'])) ));
                     
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

$pdf->Image(__DIR__.'/'.'SolicitudAfiliacionVrim-2.png' , 0 ,0, 210 , 0,'PNG');


$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 2,4);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(2,4);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(2,4);

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

$pdf->Image(__DIR__.'/'.'SolicitudAfiliacionVrim-3.png' , 0 ,0, 210 , 0,'PNG');

//forma de pago
if (mysql_num_rows($resPago) > 0) {
   if (mysql_result($resPago,0,'refcuentasbancarias') == 0) {
      $pdf->SetXY(73.00, 42.50);
      $pdf->Write(0, 'x');
   } else {
      $pdf->SetXY(73.00, 33.00);
      $pdf->Write(0, 'x');
   }
} else {
   $pdf->SetXY(73.00, 42.50);
   $pdf->Write(0, 'x');
}


//tipo tarjeta
$pdf->SetXY(7, 99.50);
$pdf->Write(0, $resVRIMoficial['nombre']);

//cod producto
$pdf->SetXY(48.40, 99.50);
$pdf->Write(0, $resVRIMoficial['codigoproducto']);

//cantidad
$pdf->SetXY(64.40, 99.50);
$pdf->Write(0, '1');

//importe
$pdf->SetXY(82.40, 99.50);
$pdf->Write(0, $total);

//sub total
$pdf->SetXY(117.40, 99.50);
$pdf->Write(0, $total);

//total
$pdf->SetXY(117.40, 122.50);
$pdf->Write(0, $total);


$resCuestionarioDetalle = $serviciosReferencias->traerCuestionariodetallePDFPorTablaReferencia(11, 'dbcotizaciones', 'idcotizacion', $id, 3,4);

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

$resReferenciasFijo = $serviciosReferencias->traerSolicitudesrespuestasCompletoFijoPDF(3,4);
while ($row = mysql_fetch_array($resReferenciasFijo)) {
   $pdf->SetXY($row['x'], $row['y']);
   $pdf->Write(0, $row['default']);

}


$resReferencias = $serviciosReferencias->traerSolicitudesrespuestasCompletoPDF(3,4);

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

$pdf->Image(__DIR__.'/'.'SolicitudAfiliacionVrim-4.png' , 0 ,0, 210 , 0,'PNG');




///********************* fin pagina 4 **********************************************/


///********************* pagina 5 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image(__DIR__.'/'.'SolicitudAfiliacionVrim-5.png' , 0 ,0, 210 , 0,'PNG');

setlocale(LC_TIME,"es_MX");
setlocale(LC_ALL, 'es_MX');

// dia
$pdf->SetXY(158, 151);
$pdf->Write(0, date('d'));
//echo "4,3,'fecha de la solicitud',".$pdf->GetX().",".$pdf->GetY().",'dia','','dia'".'<br>';

// mes
$pdf->SetXY(177, 151);
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

//echo "4,3,'fecha de la solicitud',".$pdf->GetX().",".$pdf->GetY().",'mes','','mes'".'<br>';

// anio
$pdf->SetXY(198.4, 151);
$pdf->Write(0, date('y'));
//echo "4,3,'fecha de la solicitud',".$pdf->GetX().",".$pdf->GetY().",'anio','','anio'".'<br>';




///********************* fin pagina 5 **********************************************/



//$pdf->Output('VRIMcompletoAC.pdf', 'I');

$pdf->Output( __DIR__.'/'.'../archivos/solicitudes/cotizaciones/'.$id.'/FSOLICITUDAC.pdf', 'F');



?>
