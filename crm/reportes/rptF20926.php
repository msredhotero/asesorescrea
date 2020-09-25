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

/////////////////////////////////////// pagina 1 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 7.7;
$yConstCuadrado1 = 58;

$pdf->Image('F20926-1.jpg' , 0 ,0, 210 , 0,'JPG');

//EMISOR
$pdf->SetXY(124, 25);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,7));

//clave agente
$pdf->SetXY(158, 25);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));


//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//masculino
$pdf->SetXY(18.5, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("x",0,1));

//femenino
$pdf->SetXY(27.5, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("x",0,1));

//fecha nacimiento
$pdf->SetXY(53, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("20/05/1985",0,10));

//nacionalidad
$pdf->SetXY(93, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("MEXICANO",0,20));

//RFC
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("AWEDFR126WS9A",0,13));


//CURP
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//FIRMA FIEL
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//tipo identificacion
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 4) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//numero de identificacion
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 4) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//pais de nacimiento
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 5) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//entidad federativa de nacimiento
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 5) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(135, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(155, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(168, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 9) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 9) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//lada
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//telefono
$pdf->SetXY(24, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//correo email
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//empleado publico
$pdf->SetXY(35.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
$pdf->Write(0, substr("x",0,1));

//empleado privado
$pdf->SetXY(35.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
$pdf->Write(0, substr("x",0,1));

//ingreso por honorarios
$pdf->SetXY(74.5, $yConstCuadrado1 + ($yCuadrado1 * 13) - 2.5);
$pdf->Write(0, substr("x",0,1));

//actividad
$pdf->SetXY(74.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//empleado
$pdf->SetXY(149.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
$pdf->Write(0, substr("x",0,1));

//comerciante
$pdf->SetXY(149.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
$pdf->Write(0, substr("x",0,1));

//comisionista
$pdf->SetXY(176.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
$pdf->Write(0, substr("x",0,1));

//indique
$pdf->SetXY(170.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//desemplado
$pdf->SetXY(30, $yConstCuadrado1 + ($yCuadrado1 * 15) +2);
$pdf->Write(0, substr("x",0,1));

//ama de casa
$pdf->SetXY(56, $yConstCuadrado1 + ($yCuadrado1 * 15) -1);
$pdf->Write(0, substr("x",0,1));

//estudiante
$pdf->SetXY(56, $yConstCuadrado1 + ($yCuadrado1 * 15) +4);
$pdf->Write(0, substr("x",0,1));

//arrendatario
$pdf->SetXY(78.5, $yConstCuadrado1 + ($yCuadrado1 * 15) +1.5);
$pdf->Write(0, substr("x",0,1));

//inversionista
$pdf->SetXY(115, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
$pdf->Write(0, substr("x",0,1));

//otro
$pdf->SetXY(142, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
$pdf->Write(0, substr("x",0,1));

//jubilado
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 15) +1.5);
$pdf->Write(0, substr("x",0,1));

//otro indique
$pdf->SetXY(153, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));


//desempeño funcion publica en el extranjero (no)
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//desempeño funcion publica en el extranjero (si)
$pdf->SetXY(28, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//que cargo
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 17) - 0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//fecha en que dejo el cargo
$pdf->SetXY(46, $yConstCuadrado1 + ($yCuadrado1 * 18) - 4);
$pdf->Write(0, substr("20/05/2020",0,10));

//familiar de persona que desempeño (no)
$pdf->SetXY(104.5, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//familiar de persona que desempeño (si)
$pdf->SetXY(125, $yConstCuadrado1 + ($yCuadrado1 * 17) );
$pdf->Write(0, substr("x",0,1));

//que cargo
$pdf->SetXY(154, $yConstCuadrado1 + ($yCuadrado1 * 17) - 0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//fecha en que dejo el cargo
$pdf->SetXY(128, $yConstCuadrado1 + ($yCuadrado1 * 18) - 3.5);
$pdf->Write(0, substr("20/05/2020",0,10));

//fecha en que dejo el cargo
$pdf->SetXY(169, $yConstCuadrado1 + ($yCuadrado1 * 18) - 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));


/////////////////////////////////////// pagina 2 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 148.5;

$pdf->Image('F20926-2.jpg' , 0 ,0, 210 , 0,'JPG');

//tipo de persona fisica
$pdf->SetXY(19, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("x",0,1));

//tipo de persona moral
$pdf->SetXY(36, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("x",0,1));

//razon social
$pdf->SetXY(50, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 1) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 1) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//rfc
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,13));

//curp
$pdf->SetXY(55, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//estado civil soltero
$pdf->SetXY(124, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
$pdf->Write(0, substr("x",0,1));

//estado civil casado
$pdf->SetXY(124, $yConstCuadrado1 + ($yCuadrado1 * 3) + 3.4);
$pdf->Write(0, substr("x",0,1));

//masculino
$pdf->SetXY(136, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
$pdf->Write(0, substr("x",0,1));

//femenino
$pdf->SetXY(136, $yConstCuadrado1 + ($yCuadrado1 * 3) + 3.4);
$pdf->Write(0, substr("x",0,1));

//edad
$pdf->SetXY(146, $yConstCuadrado1 + ($yCuadrado1 * 3) + 1);
$pdf->Write(0, substr("35",0,2));

//fecha ancmimeinto
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 3) + 1);
$pdf->Write(0, substr("20/05/1985",0,10));

//pais nacimiento
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 4) + 5);
$pdf->Write(0, substr("MEXICO",0,20));

//entidad federativa
$pdf->SetXY(75, $yConstCuadrado1 + ($yCuadrado1 * 4) + 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//nacionalidad
$pdf->SetXY(138, $yConstCuadrado1 + ($yCuadrado1 * 4) + 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(135, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(155, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(168, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 8) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 8) + 4.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 9) + 4.2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 9) + 4.2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//lada
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//telefono
$pdf->SetXY(24, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//correo email
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));


//firma fiel
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 11) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//foco mercantil solo en caso de ser persona moral
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 11) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//identificacion
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5);
$pdf->Write(0, substr("MEXICO",0,20));

//tipo de identificacion
$pdf->SetXY(75, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//numero de identificacion
$pdf->SetXY(138, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));



/////////////////////////////////////// pagina 3 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 32.5;

$pdf->Image('F20926-3.jpg' , 0 ,0, 210 , 0,'JPG');


//desaempaña funcion publica en mexico (no)
$pdf->SetXY(18, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("x",0,1));

/*
//desaempaña funcion publica en mexico (si)
$pdf->SetXY(29.5, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("x",0,1));

//cargo
$pdf->SetXY(53, $yConstCuadrado1 + ($yCuadrado1 * 0) -0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,17));

//fecha en que dejo el cargo
$pdf->SetXY(49, $yConstCuadrado1 + ($yCuadrado1 * 1) -4);
$pdf->Write(0, substr("20/05/2020",0,10));


//familiar funcion publica en mexico (no)
$pdf->SetXY(105.5, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("x",0,1));

//familiar funcion publica en mexico (si)
$pdf->SetXY(125.5, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("x",0,1));

//cargo
$pdf->SetXY(155.5, $yConstCuadrado1 + ($yCuadrado1 * 0) -0.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,17));

//fecha en que dejo el cargo
$pdf->SetXY(130, $yConstCuadrado1 + ($yCuadrado1 * 1) -4);
$pdf->Write(0, substr("20/05/2020",0,10));

//parentesco
$pdf->SetXY(170, $yConstCuadrado1 + ($yCuadrado1 * 1) -4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));
*/

//sociedad mercantil
$pdf->SetXY(44.3, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5);
$pdf->Write(0, substr("x",0,1));

//con fines de lucro
$pdf->SetXY(44.3, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2.2);
$pdf->Write(0, substr("x",0,1));

//donataria
$pdf->SetXY(44.3, $yConstCuadrado1 + ($yCuadrado1 * 3) +6.5);
$pdf->Write(0, substr("x",0,1));


//banco mexico
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5);
$pdf->Write(0, substr("x",0,1));

//banca desarrollo
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 1));
$pdf->Write(0, substr("x",0,1));

//banca multiple
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 2));
$pdf->Write(0, substr("x",0,1));

//financiera publica
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 3));
$pdf->Write(0, substr("x",0,1));

//financiera privada
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 4));
$pdf->Write(0, substr("x",0,1));


//gobierno federal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5);
$pdf->Write(0, substr("x",0,1));

//gobierno estatal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 1));
$pdf->Write(0, substr("x",0,1));

//gobierno municipal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 2));
$pdf->Write(0, substr("x",0,1));

//organismo desentralizado
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 3));
$pdf->Write(0, substr("x",0,1));

//participacion estatal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 4));
$pdf->Write(0, substr("x",0,1));


//financieras
$pdf->SetXY(184.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 1));
$pdf->Write(0, substr("x",0,1));

//no financieras
$pdf->SetXY(184.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 3));
$pdf->Write(0, substr("x",0,1));


//info adic amigo, etc, funcion publica (no)
$pdf->SetXY(19, $yConstCuadrado1 + ($yCuadrado1 * 6) + 2);
$pdf->Write(0, substr("x",0,1));

//info adic amigo, etc, funcion publica (si)
$pdf->SetXY(35, $yConstCuadrado1 + ($yCuadrado1 * 6) + 2 );
$pdf->Write(0, substr("x",0,1));

//nombre completo de la persona
$pdf->SetXY(48, $yConstCuadrado1 + ($yCuadrado1 * 6) + 4 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//cargo
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 8) - 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//fecha en que dejo el cargo
$pdf->SetXY(109, $yConstCuadrado1 + ($yCuadrado1 * 8) - 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//cobro bancario (si)
$pdf->SetXY(35, $yConstCuadrado1 + ($yCuadrado1 * 9) - 1 );
$pdf->Write(0, substr("x",0,1));

//cobro bancario (no)
$pdf->SetXY(64, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
$pdf->Write(0, substr("x",0,1));

//forma de pago (anual)
$pdf->SetXY(109.5, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
$pdf->Write(0, substr("x",0,1));

//forma de pago (semestral)
$pdf->SetXY(129.5, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
$pdf->Write(0, substr("x",0,1));

//forma de pago (trimestral)
$pdf->SetXY(154, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
$pdf->Write(0, substr("x",0,1));

//forma de pago (mensual)
$pdf->SetXY(178, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
$pdf->Write(0, substr("x",0,1));

//banco
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 11) );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//nro tarjeta
$pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 11) + 0.2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//fecha vencimiento
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 11) );
$pdf->Write(0, substr("20/05/2020",0,10));

//cuenta cheques banco
$pdf->SetXY(42, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//nro cuenta cheques
$pdf->SetXY(116, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));


//con restriccion hospitalaria
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 24) + 2 );
$pdf->Write(0, substr("x",0,1));

//sin restriccion hospitalaria
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 24) + 7.2 );
$pdf->Write(0, substr("x",0,1));

//inburmedic
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 24) + 12.3 );
$pdf->Write(0, substr("x",0,1));

//con restriccion hospitalaria
$pdf->SetXY(51, $yConstCuadrado1 + ($yCuadrado1 * 24) + 1 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));

//con restriccion hospitalaria
$pdf->SetXY(51, $yConstCuadrado1 + ($yCuadrado1 * 24) + 9 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));

//coseguro por enfermedad
$pdf->SetXY(59, $yConstCuadrado1 + ($yCuadrado1 * 27)  );
$pdf->Write(0, substr("100",0,3));

//cobertura basica
$pdf->SetXY(91, $yConstCuadrado1 + ($yCuadrado1 * 24) + 7.6 );
$pdf->Write(0, substr("x",0,1));

//con tabulador
$pdf->SetXY(117, $yConstCuadrado1 + ($yCuadrado1 * 24) + 7.4 );
$pdf->Write(0, substr("x",0,1));

//honorarios con tabulador
$pdf->SetXY(142, $yConstCuadrado1 + ($yCuadrado1 * 24) + 7.8 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//sin tabulador
$pdf->SetXY(117, $yConstCuadrado1 + ($yCuadrado1 * 24) + 12.5 );
$pdf->Write(0, substr("x",0,1));

//honorarios sin tabulador
$pdf->SetXY(142, $yConstCuadrado1 + ($yCuadrado1 * 24) + 13.2 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//amplio
$pdf->SetXY(117, $yConstCuadrado1 + ($yCuadrado1 * 24) + 17.5 );
$pdf->Write(0, substr("x",0,1));


//con tabulador y ambulancia aerea
$pdf->SetXY(169.5, $yConstCuadrado1 + ($yCuadrado1 * 24) + 7.7 );
$pdf->Write(0, substr("x",0,1));

//sin tabulador y ambulancia aerea
$pdf->SetXY(169.5, $yConstCuadrado1 + ($yCuadrado1 * 24) + 13 );
$pdf->Write(0, substr("x",0,1));




/////////////////////////////////////// pagina 4 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-4.jpg' , 0 ,0, 210 , 0,'JPG');

//emergencia internacional
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) - 3.2 );
$pdf->Write(0, substr("x",0,1));

//cobertura internacional
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 2 );
$pdf->Write(0, substr("x",0,1));

//emergencia catastroficas en el extranjero
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 6.8 );
$pdf->Write(0, substr("x",0,1));

//maternidad
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 11.6 );
$pdf->Write(0, substr("x",0,1));

//gastos funerarios
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 17.4 );
$pdf->Write(0, substr("x",0,1));

//gastos funerarios suma asegurada
$pdf->SetXY(55.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 17.5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//prevision familiar
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 22.9 );
$pdf->Write(0, substr("x",0,1));

//enfermedades graves
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 31.5 );
$pdf->Write(0, substr("x",0,1));

//enfermedades graves (sevi)
$pdf->SetXY(55.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 32 );
$pdf->Write(0, substr("300.000",0,10));

//titular
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 39.5 );
$pdf->Write(0, substr("x",0,1));

//titular conyuge
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 44.5 );
$pdf->Write(0, substr("x",0,1));

//todos asegurados mayores a 19 años
$pdf->SetXY(11.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 49.5 );
$pdf->Write(0, substr("x",0,1));


//muerte accidental
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 9.6 );
$pdf->Write(0, substr("x",0,1));

//titular
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 15 );
$pdf->Write(0, substr("x",0,1));

//titular y conyuge
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 20 );
$pdf->Write(0, substr("x",0,1));

//todos los asegurados mayores a 12 años
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 25.2 );
$pdf->Write(0, substr("x",0,1));

//muerte accidental y perdido de mienbros
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 31.6 );
$pdf->Write(0, substr("x",0,1));

//titular
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 36.8 );
$pdf->Write(0, substr("x",0,1));

//titular y conyuge
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 42 );
$pdf->Write(0, substr("x",0,1));

//todos asegurados mayores a 12 años
$pdf->SetXY(85.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 46.8 );
$pdf->Write(0, substr("x",0,1));


//emergencia internacional
$pdf->SetXY(153.5, $yConstCuadrado1 + ($yCuadrado1 * 0) - 1.2 );
$pdf->Write(0, substr("x",0,1));

//emergencia internacional
$pdf->SetXY(153.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 15.3 );
$pdf->Write(0, substr("x",0,1));

//emergencia internacional
$pdf->SetXY(153.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 26 );
$pdf->Write(0, substr("x",0,1));

//emergencia internacional
$pdf->SetXY(153.5, $yConstCuadrado1 + ($yCuadrado1 * 0) +42.5 );
$pdf->Write(0, substr("x",0,1));

//enfermedades graves
$pdf->SetXY(11.6, $yConstCuadrado1 + ($yCuadrado1 * 8) + 3 );
$pdf->Write(0, substr("x",0,1));

//suma asegurada
$pdf->SetXY(104, $yConstCuadrado1 + ($yCuadrado1 * 8) + 3 );
$pdf->Write(0, substr("300.000",0,10));

//star medica
$pdf->SetXY(11.8, $yConstCuadrado1 + ($yCuadrado1 * 9) + 5.7 );
$pdf->Write(0, substr("x",0,1));

//1
$pdf->SetXY(44, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9 );
$pdf->Write(0, substr("x",0,1));

//2
$pdf->SetXY(58.4, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9 );
$pdf->Write(0, substr("x",0,1));

//3
$pdf->SetXY(72.2, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9 );
$pdf->Write(0, substr("x",0,1));

//4
$pdf->SetXY(86, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9 );
$pdf->Write(0, substr("x",0,1));

//5
$pdf->SetXY(100, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9 );
$pdf->Write(0, substr("x",0,1));

//6
$pdf->SetXY(114.6, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9 );
$pdf->Write(0, substr("x",0,1));

//gastos funerarios
$pdf->SetXY(132.5, $yConstCuadrado1 + ($yCuadrado1 * 9) + 9.2 );
$pdf->Write(0, substr("x",0,1));

//enfermedades graves sevi
$pdf->SetXY(132.5, $yConstCuadrado1 + ($yCuadrado1 * 9) + 14.2 );
$pdf->Write(0, substr("x",0,1));

/////////////////////////////////////// pagina 5 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-5.jpg' , 0 ,0, 210 , 0,'JPG');




/////////////////////////////////////// pagina 6 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-6.jpg' , 0 ,0, 210 , 0,'JPG');



/////////////////////////////////////// pagina 7 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926-7.jpg' , 0 ,0, 210 , 0,'JPG');





/************************** fin ********************************************************/


$pdf->Output('F20926AC.pdf', 'I');


?>
