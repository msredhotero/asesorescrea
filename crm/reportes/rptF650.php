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

$pdf = new FPDF();

//$pdfi = new FPDI();

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


//$pdf =& new FPDI();
// add a page
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 9;
$yConstCuadrado1 = 55;

$pdf->Image('F650a.png' , 0 ,0, 210 , 0,'PNG');

//poliza
$pdf->SetXY(8, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//nro empleado
$pdf->SetXY(60, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//grupo asegurado
$pdf->SetXY(102, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//Demominacion o razon social contratante
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,150));

//suma asegurada o regla para determinarla
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 2) - 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//vig dd
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig mm
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig yyyy
$pdf->SetXY(134, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("2020",0,4));


//vig dd
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig mm
$pdf->SetXY(177, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("01",0,2));

//vig yyyy
$pdf->SetXY(189, $yConstCuadrado1 + ($yCuadrado1 * 2)+2.5);
$pdf->Write(0, substr("2022",0,4));


//primer nombre
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 4) - 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 4) - 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//apellido paterno
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 5) - 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 5) - 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//fecha nac dd
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("20",0,2));

//fecha nac mm
$pdf->SetXY(20, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("05",0,2));

//fecha nac yyyy
$pdf->SetXY(32, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("1985",0,4));


//genero masculino
$pdf->SetXY(49, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("X",0,1));

//genero femenino
$pdf->SetXY(49, $yConstCuadrado1 + ($yCuadrado1 * 6) - 1.5);
$pdf->Write(0, substr("X",0,1));


//categoria
$pdf->SetXY(73, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20)); //no mostrar informacion

//SUELDO MENSUAL
$pdf->SetXY(132, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12)); //no mostrar informacion

//fecha ingreso al grupo dd
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("05",0,2));

//fecha ingreso al grupo mm
$pdf->SetXY(177, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("12",0,2));

//fecha ingreso al grupo yyyy
$pdf->SetXY(189, $yConstCuadrado1 + ($yCuadrado1 * 6) - 5);
$pdf->Write(0, substr("2018",0,4));



//peso
$pdf->SetXY(25, $yConstCuadrado1 + ($yCuadrado1 * 10) - 7);
$pdf->Write(0, substr("95",0,2));

//altura
$pdf->SetXY(62, $yConstCuadrado1 + ($yCuadrado1 * 10) - 7);
$pdf->Write(0, substr("170",0,3));

//pregunta 1 si
$pdf->SetXY(191.5, $yConstCuadrado1 + ($yCuadrado1 * 10) - 3);
$pdf->Write(0, substr("X",0,1));
//pregunta 1 NO
$pdf->SetXY(196, $yConstCuadrado1 + ($yCuadrado1 * 10) - 3);
$pdf->Write(0, substr("X",0,1));

//pregunta 2 si
$pdf->SetXY(191.5, $yConstCuadrado1 + ($yCuadrado1 * 12) - 4);
$pdf->Write(0, substr("X",0,1));
//pregunta 2 NO
$pdf->SetXY(196, $yConstCuadrado1 + ($yCuadrado1 * 12) - 4);
$pdf->Write(0, substr("X",0,1));

//pregunta 3 si
$pdf->SetXY(191.5, $yConstCuadrado1 + ($yCuadrado1 * 12) +0.8);
$pdf->Write(0, substr("X",0,1));
//pregunta 3 NO
$pdf->SetXY(196, $yConstCuadrado1 + ($yCuadrado1 * 12) + 0.8);
$pdf->Write(0, substr("X",0,1));

//pregunta 4 si
$pdf->SetXY(191.5, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5.4);
$pdf->Write(0, substr("X",0,1));
//pregunta 4 NO
$pdf->SetXY(196, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5.4);
$pdf->Write(0, substr("X",0,1));


$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F650b.png' , 0 ,0, 210 , 0,'PNG');


//////////////////////////////////////// beneficiario 1 //////////////////////////////////
//beneficiario irrevocable
$pdf->SetXY(8, $yConstCuadrado1  );
$pdf->Write(0, substr("X",0,1));

//beneficiario revocable
$pdf->SetXY(57, $yConstCuadrado1 );
$pdf->Write(0, substr("X",0,1));

//porcentaje
$pdf->SetXY(128, $yConstCuadrado1 );
$pdf->Write(0, substr("X",0,1));

//primer nombre
$pdf->SetXY(8, $yConstCuadrado1 + $yCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + $yCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido paterno
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//relacion parentesco
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 3));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////// beneficiario 2 ///////////////////
//beneficiario irrevocable
$pdf->SetXY(8, $yConstCuadrado1  + ($yCuadrado1 * 4) + 4);
$pdf->Write(0, substr("X",0,1));

//beneficiario revocable
$pdf->SetXY(57, $yConstCuadrado1  + ($yCuadrado1 * 4) + 4);
$pdf->Write(0, substr("X",0,1));

//porcentaje
$pdf->SetXY(128, $yConstCuadrado1  + ($yCuadrado1 * 4) + 4);
$pdf->Write(0, substr("X",0,1));

//primer nombre
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 5) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 5) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido paterno
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 6) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 6) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//relacion parentesco
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//lugar
$pdf->SetXY(8, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//fecha ingreso al grupo dd
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("05",0,2));

//fecha ingreso al grupo mm
$pdf->SetXY(177, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("12",0,2));

//fecha ingreso al grupo yyyy
$pdf->SetXY(189, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("2018",0,4));

/************************** fin ********************************************************/


$pdf->Output('F650AC.pdf', 'I');


?>
