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

$pdf->Image('F20926_0001.png' , 0 ,0, 210 , 0,'PNG');

//SECCION datos generales del solicitante titular
//EMISOR
$pdf->SetXY(124, 25);
//echo "1,'EMISOR',".$pdf->GetX().",".$pdf->GetY().",'EMISOR','','EMISOR'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,7));


//clave agente
$pdf->SetXY(158, 25);
//echo "1,'clave agente',".$pdf->GetX().",".$pdf->GetY().",'clave agente','','clave agente'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));


//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 1));
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 1));
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//masculino
$pdf->SetXY(18.5, $yConstCuadrado1 + ($yCuadrado1 * 2));
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'masculino','','masculino'".'<br>';
$pdf->Write(0, substr("x",0,1));

//femenino
$pdf->SetXY(27.5, $yConstCuadrado1 + ($yCuadrado1 * 2));
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'femenino','','femenino'".'<br>';
$pdf->Write(0, substr("x",0,1));

//fecha nacimiento
$pdf->SetXY(53, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';
$pdf->Write(0, substr("20/05/1985",0,10));

//nacionalidad
$pdf->SetXY(93, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'nacionalidad','MEXICANA','nacionalidad'".'<br>';
$pdf->Write(0, substr("MEXICANO",0,20));

//RFC
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'RFC','','RFC'".'<br>';
$pdf->Write(0, substr("AWEDFR126WS9A",0,13));


//CURP
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'CURP','','CURP'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//FIRMA FIEL
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'FIRMA FIEL','','FIRMA FIEL'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//tipo identificacion
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 4) + 3);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'tipo identificacion','','tipo identificacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//numero de identificacion
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 4) + 3);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'numero de identificacion','','numero de identificacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//pais de nacimiento
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 5) + 3);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'pais de nacimiento','MEXICO','pais de nacimiento'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//entidad federativa de nacimiento
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 5) + 3);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa de nacimiento','','entidad federativa de nacimiento'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));


//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'domicilio','','domicilio'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(135, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(155, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'nro ext','','nro ext'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(168, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'nro int','','nro int'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 8) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'cod postal','','cod postal'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 9) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 9) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'delegacion','','delegacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'estado','','estado'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//lada
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'lada','','lada'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//telefono
$pdf->SetXY(24, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'telefono','','telefono'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//correo email
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 11) + 1.5);
//echo "1,'datos generales del solicitante titular',".$pdf->GetX().",".$pdf->GetY().",'correo email','','correo email'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//SECCION indique principal ocupacion
//empleado publico
$pdf->SetXY(35.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'empleado publico','x','empleado publico'".'<br>';
$pdf->Write(0, substr("x",0,1));

//empleado privado
$pdf->SetXY(35.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'empleado privado','x','empleado privado'".'<br>';
$pdf->Write(0, substr("x",0,1));

//ingreso por honorarios
$pdf->SetXY(74.5, $yConstCuadrado1 + ($yCuadrado1 * 13) - 2.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'ingreso por honorarios','x','ingreso por honorarios'".'<br>';
$pdf->Write(0, substr("x",0,1));

//actividad
$pdf->SetXY(74.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'actividad','','actividad'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//empleado
$pdf->SetXY(149.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'empleado','x','empleado'".'<br>';
$pdf->Write(0, substr("x",0,1));

//comerciante
$pdf->SetXY(149.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'comerciante','x','comerciante'".'<br>';
$pdf->Write(0, substr("x",0,1));

//comisionista
$pdf->SetXY(176.5, $yConstCuadrado1 + ($yCuadrado1 * 13) + 1.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'comisionista','x','comisionista'".'<br>';
$pdf->Write(0, substr("x",0,1));

//indique
$pdf->SetXY(170.5, $yConstCuadrado1 + ($yCuadrado1 * 14) - 2);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'indique','','indique'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//desemplado
$pdf->SetXY(30, $yConstCuadrado1 + ($yCuadrado1 * 15) +2);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'desemplado','x','desemplado'".'<br>';
$pdf->Write(0, substr("x",0,1));

//ama de casa
$pdf->SetXY(56, $yConstCuadrado1 + ($yCuadrado1 * 15) -1);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'ama de casa','x','ama de casa'".'<br>';
$pdf->Write(0, substr("x",0,1));

//estudiante
$pdf->SetXY(56, $yConstCuadrado1 + ($yCuadrado1 * 15) +4);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'estudiante','x','estudiante'".'<br>';
$pdf->Write(0, substr("x",0,1));

//arrendatario
$pdf->SetXY(78.5, $yConstCuadrado1 + ($yCuadrado1 * 15) +1.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'arrendatario','x','arrendatario'".'<br>';
$pdf->Write(0, substr("x",0,1));

//inversionista
$pdf->SetXY(115, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'inversionista','x','inversionista'".'<br>';
$pdf->Write(0, substr("x",0,1));

//otro
$pdf->SetXY(142, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'otro','x','otro'".'<br>';
$pdf->Write(0, substr("x",0,1));

//jubilado
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 15) +1.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'jubilado','x','jubilado'".'<br>';
$pdf->Write(0, substr("x",0,1));

//otro indique
$pdf->SetXY(153, $yConstCuadrado1 + ($yCuadrado1 * 15) -4);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'otro indique','','otro indique'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));


//desempeño funcion publica en el extranjero (no)
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 17) );
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'no','x','desempeño funcion publica en el extranjero'".'<br>';
$pdf->Write(0, substr("x",0,1));

//desempeño funcion publica en el extranjero (si)
$pdf->SetXY(28, $yConstCuadrado1 + ($yCuadrado1 * 17) );
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'si','x','desempeño funcion publica en el extranjero'".'<br>';
$pdf->Write(0, substr("x",0,1));

//que cargo
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 17) - 0.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'que cargo','','que cargo'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//fecha en que dejo el cargo
$pdf->SetXY(46, $yConstCuadrado1 + ($yCuadrado1 * 18) - 4);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'fecha en que dejo el cargo','','fecha en que dejo el cargo'".'<br>';
$pdf->Write(0, substr("20/05/2020",0,10));

//familiar de persona que desempeño (no)
$pdf->SetXY(104.5, $yConstCuadrado1 + ($yCuadrado1 * 17) );
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'no','x','familiar de persona que desempeño'".'<br>';
$pdf->Write(0, substr("x",0,1));

//familiar de persona que desempeño (si)
$pdf->SetXY(125, $yConstCuadrado1 + ($yCuadrado1 * 17) );
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'si','x','familiar de persona que desempeño'".'<br>';
$pdf->Write(0, substr("x",0,1));

//que cargo
$pdf->SetXY(154, $yConstCuadrado1 + ($yCuadrado1 * 17) - 0.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'que cargo','','que cargo'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//fecha en que dejo el cargo
$pdf->SetXY(128, $yConstCuadrado1 + ($yCuadrado1 * 18) - 3.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'fecha en que dejo el cargo','','fecha en que dejo el cargo'".'<br>';
$pdf->Write(0, substr("20/05/2020",0,10));

//parentezco
$pdf->SetXY(169, $yConstCuadrado1 + ($yCuadrado1 * 18) - 3.5);
//echo "1,'indique principal ocupacion',".$pdf->GetX().",".$pdf->GetY().",'parentezco','','parentezco'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));


/////////////////////////////////////// pagina 2 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 148.5;

$pdf->Image('F20926_0002.png' , 0 ,0, 210 , 0,'PNG');

//SECCION datos generales del contratante
//tipo de persona fisica
$pdf->SetXY(19, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'persona fisica','x','tipo de persona'".'<br>';
$pdf->Write(0, substr("x",0,1));

//tipo de persona moral
$pdf->SetXY(36, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'persona moral','x','tipo de persona'".'<br>';
$pdf->Write(0, substr("x",0,1));

//razon social
$pdf->SetXY(50, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'razon social','','razon social'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 1) + 1);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 1) + 1);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 2) + 1);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//rfc
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'rfc','','rfc'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,13));

//curp
$pdf->SetXY(55, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'curp','','curp'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

//estado civil soltero
$pdf->SetXY(124, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'soltero','x','estado civil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//estado civil casado
$pdf->SetXY(124, $yConstCuadrado1 + ($yCuadrado1 * 3) + 3.4);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'casado','x','estado civil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//masculino
$pdf->SetXY(136, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'masculino','x','masculino'".'<br>';
$pdf->Write(0, substr("x",0,1));

//femenino
$pdf->SetXY(136, $yConstCuadrado1 + ($yCuadrado1 * 3) + 3.4);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'femenino','x','femenino'".'<br>';
$pdf->Write(0, substr("x",0,1));

//edad
$pdf->SetXY(146, $yConstCuadrado1 + ($yCuadrado1 * 3) + 1);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'edad','','edad'".'<br>';
$pdf->Write(0, substr("35",0,2));

//fecha nacimiento
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 3) + 1);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';
$pdf->Write(0, substr("20/05/1985",0,10));

// FIJO
//pais nacimiento
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 4) + 5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'pais nacimiento','MEXICO','pais nacimiento'".'<br>';
$pdf->Write(0, substr("MEXICO",0,20));

//entidad federativa
$pdf->SetXY(75, $yConstCuadrado1 + ($yCuadrado1 * 4) + 5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

// FIJO
//nacionalidad
$pdf->SetXY(138, $yConstCuadrado1 + ($yCuadrado1 * 4) + 5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'nacionalidad','MEXICANA','nacionalidad'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));

//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'domicilio','','domicilio'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(135, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(155, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'nro ext','','nro ext'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(168, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'nro int','','nro int'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 7) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'cod postal','','cod postal'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 8) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 8) + 4.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'delegacion','','delegacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 9) + 4.2);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 9) + 4.2);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'estado','','estado'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//lada
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'lada','','lada'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//telefono
$pdf->SetXY(24, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'telefono','','telefono'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,8));

//correo email
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3.5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'correo email','','correo email'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));


//firma fiel
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 11) + 4);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'firma fiel','','firma fiel'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//foco mercantil solo en caso de ser persona moral
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 11) + 4);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'foco mercantil solo en caso de ser persona moral','','foco mercantil solo en caso de ser persona moral'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//identificacion
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'identificacion','','identificacion'".'<br>';
$pdf->Write(0, substr("MEXICO",0,20));

//tipo de identificacion
$pdf->SetXY(75, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'tipo de identificacion','','tipo de identificacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//numero de identificacion
$pdf->SetXY(138, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5);
//echo "2,'datos generales del contratante',".$pdf->GetX().",".$pdf->GetY().",'numero de identificacion','','numero de identificacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,20));



/////////////////////////////////////// pagina 3 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 32.5;

$pdf->Image('F20926_0003.png' , 0 ,0, 210 , 0,'PNG');

// va FIJO
//desaempaña funcion publica en mexico (no)
$pdf->SetXY(18, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "3,'desaempaña funcion publica en mexico',".$pdf->GetX().",".$pdf->GetY().",'desaempaña funcion publica en mexico','x','desaempaña funcion publica en mexico'".'<br>';
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

//SECCION seleccione al sector que pertenece
//sociedad mercantil
$pdf->SetXY(44.3, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5);
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'sector privado','x','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//con fines de lucro
$pdf->SetXY(44.3, $yConstCuadrado1 + ($yCuadrado1 * 3) + 2.2);
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'con fines de lucro','x','con fines de lucro'".'<br>';
$pdf->Write(0, substr("x",0,1));

//donataria
$pdf->SetXY(44.3, $yConstCuadrado1 + ($yCuadrado1 * 3) +6.5);
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'donataria','x','donataria'".'<br>';
$pdf->Write(0, substr("x",0,1));


//banco mexico
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5);
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'banco mexico','x','banco mexico'".'<br>';
$pdf->Write(0, substr("x",0,1));

//banca desarrollo
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 1));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'banca desarrollo','x','banca desarrollo'".'<br>';
$pdf->Write(0, substr("x",0,1));

//banca multiple
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 2));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'banca multiple','x','banca multiple'".'<br>';
$pdf->Write(0, substr("x",0,1));

//financiera publica
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 3));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'financiera publica','x','financiera publica'".'<br>';
$pdf->Write(0, substr("x",0,1));

//financiera privada
$pdf->SetXY(84, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 4));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'financiera privada','x','financiera privada'".'<br>';
$pdf->Write(0, substr("x",0,1));


//gobierno federal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5);
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'gobierno federal','x','gobierno federal'".'<br>';
$pdf->Write(0, substr("x",0,1));

//gobierno estatal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 1));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'gobierno estatal','x','gobierno estatal'".'<br>';
$pdf->Write(0, substr("x",0,1));

//gobierno municipal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 2));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'gobierno municipal','x','gobierno municipal'".'<br>';
$pdf->Write(0, substr("x",0,1));

//organismo desentralizado
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 3));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'organismo desentralizado','x','organismo desentralizado'".'<br>';
$pdf->Write(0, substr("x",0,1));

//participacion estatal
$pdf->SetXY(136.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 4));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'participacion estatal','x','participacion estatal'".'<br>';
$pdf->Write(0, substr("x",0,1));


//financieras
$pdf->SetXY(184.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 1));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'financieras','x','financieras'".'<br>';
$pdf->Write(0, substr("x",0,1));

//no financieras
$pdf->SetXY(184.5, $yConstCuadrado1 + ($yCuadrado1 * 3) -5.5 + (4 * 3));
//echo "3,'seleccione al sector que pertenece',".$pdf->GetX().",".$pdf->GetY().",'no financieras','x','no financieras'".'<br>';
$pdf->Write(0, substr("x",0,1));

//SECCION informacion adicional
//info adic amigo, etc, funcion publica (no)
$pdf->SetXY(19, $yConstCuadrado1 + ($yCuadrado1 * 6) + 2);
//echo "3,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'no','x','info adic amigo, etc, funcion publica'".'<br>';
$pdf->Write(0, substr("x",0,1));

//info adic amigo, etc, funcion publica (si)
$pdf->SetXY(35, $yConstCuadrado1 + ($yCuadrado1 * 6) + 2 );
//echo "3,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'si','x','info adic amigo, etc, funcion publica'".'<br>';
$pdf->Write(0, substr("x",0,1));

//nombre completo de la persona
$pdf->SetXY(48, $yConstCuadrado1 + ($yCuadrado1 * 6) + 4 );
//echo "3,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'nombre completo de la persona','','nombre completo de la persona'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//cargo
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 8) - 3);
//echo "3,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'cargo','','cargo'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//fecha en que dejo el cargo
$pdf->SetXY(109, $yConstCuadrado1 + ($yCuadrado1 * 8) - 3);
//echo "3,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'fecha en que dejo el cargo','','fecha en que dejo el cargo'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));


/*************** IMPORTANTE: lo resulevo yo *********************************************************************/
//SECCION cobro bancario
//cobro bancario (si)
$pdf->SetXY(35, $yConstCuadrado1 + ($yCuadrado1 * 9) - 1 );
////echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//cobro bancario (no)
$pdf->SetXY(64, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
////echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));


//SECCION forma de pago
//forma de pago (anual)
$pdf->SetXY(109.5, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
////echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//forma de pago (semestral)
$pdf->SetXY(129.5, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
////echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//forma de pago (trimestral)
$pdf->SetXY(154, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
////echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//forma de pago (mensual)
$pdf->SetXY(178, $yConstCuadrado1 + ($yCuadrado1 * 9) -1 );
////echo "3,'cobro bancario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));


//SECCION seleccione debito y credito
//banco
$pdf->SetXY(17, $yConstCuadrado1 + ($yCuadrado1 * 11) );
////echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//nro tarjeta
$pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 11) + 0.2);
////echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//fecha vencimiento
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 11) );
////echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("20/05/2020",0,10));

//cuenta cheques banco
$pdf->SetXY(42, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4);
////echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,45));

//nro cuenta cheques
$pdf->SetXY(116, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4);
////echo "3,'seleccione debito y credito',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,18));

/*************** FIN IMPORTANTE: lo resulevo yo *********************************************************************/

//SECCION tipo de seguro a contratar
/*
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
*/



/////////////////////////////////////// pagina 4 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 25.5;

$pdf->Image('F20926_0004.png' , 0 ,0, 210 , 0,'PNG');


//SECCION tipo de seguro a contratar
/*
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
*/

// FIJO
//enfermedades graves
$pdf->SetXY(11.6, $yConstCuadrado1 + ($yCuadrado1 * 8) + 3 );
//echo "4,'enfermedades graves SEVI',".$pdf->GetX().",".$pdf->GetY().",'enfermedades graves SEVI','x','enfermedades graves SEVI'".'<br>';
$pdf->Write(0, substr("x",0,1));

//suma asegurada
$pdf->SetXY(104, $yConstCuadrado1 + ($yCuadrado1 * 8) + 3 );
//echo "4,'SEVI suma asegurada',".$pdf->GetX().",".$pdf->GetY().",'SEVI suma asegurada','300.000','SEVI suma asegurada'".'<br>';
$pdf->Write(0, substr("300.000",0,10));

/*
//inburmedic star medica
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

//atension por accidente cubierto fuera de la red star medica
$pdf->SetXY(132.5, $yConstCuadrado1 + ($yCuadrado1 * 9) + 19.2 );
$pdf->Write(0, substr("x",0,1));


//christus murgerza
$pdf->SetXY(11.8, $yConstCuadrado1 + ($yCuadrado1 * 12) + 5  );
$pdf->Write(0, substr("x",0,1));

//a
$pdf->SetXY(53.5, $yConstCuadrado1 + ($yCuadrado1 * 12) + 8.5  );
$pdf->Write(0, substr("x",0,1));

//b
$pdf->SetXY(80.6, $yConstCuadrado1 + ($yCuadrado1 * 12) + 8.5  );
$pdf->Write(0, substr("x",0,1));

//c
$pdf->SetXY(109.2, $yConstCuadrado1 + ($yCuadrado1 * 12) + 8.5  );
$pdf->Write(0, substr("x",0,1));

//gastos financieros
$pdf->SetXY(132.6, $yConstCuadrado1 + ($yCuadrado1 * 12) + 10  );
$pdf->Write(0, substr("x",0,1));

//enfermedades graves (SEVI)
$pdf->SetXY(132.6, $yConstCuadrado1 + ($yCuadrado1 * 12) + 16  );
$pdf->Write(0, substr("x",0,1));

//reconocimiento de antigueadad fecha
$pdf->SetXY(70, $yConstCuadrado1 + ($yCuadrado1 * 15) + 5 );
$pdf->Write(0, substr("20/05/2020",0,10));

//tarifa por zona
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 15) + 5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,25));

//cuenta integral
$pdf->SetXY(74, $yConstCuadrado1 + ($yCuadrado1 * 16) + 3.5 );
$pdf->Write(0, substr("x",0,1));

//cuenta ct / efe / tarjeta de credito
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 16) + 3.5 );
$pdf->Write(0, substr("x",0,1));
*/

//SECCION beneficiario
//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'domicilio','','domicilio'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(136, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(156, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'nro ext','','nro ext'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(169, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'nro int','','nro int'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(183, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'cod postal','','cod postal'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 22) + 3);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 22) + 3);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'delegacion','','delegacion'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 23) + 2.5);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 23) + 2.5);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'estado','','estado'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 24) + 3.5);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 24) + 3.5);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 25) + 3);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 25) + 3);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

// FIJO // VER MAS ADELANTE
//porcentaje (simpre 100%)
$pdf->SetXY(26, $yConstCuadrado1 + ($yCuadrado1 * 26) );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'porcentaje (simpre 100%)','100','porcentaje (simpre 100%)'".'<br>';
$pdf->Write(0, substr("100",0,3));

// FIJO
//rebocable
$pdf->SetXY(75, $yConstCuadrado1 + ($yCuadrado1 * 26) -1 );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'rebocable','x','rebocable'".'<br>';
$pdf->Write(0, substr("x",0,1));

//irrebocable (nunca se eligira)
//$pdf->SetXY(26, $yConstCuadrado1 + ($yCuadrado1 * 26) );
//$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//genero (masculino)
$pdf->SetXY(16, $yConstCuadrado1 + ($yCuadrado1 * 27) );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//genero (femenino)
$pdf->SetXY(25.5, $yConstCuadrado1 + ($yCuadrado1 * 27) );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("x",0,1));

//fecha nacimiento
$pdf->SetXY(40, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5 );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("20/05/2020",0,10));

//parentesco
$pdf->SetXY(65, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5 );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,25));

//nacionalidad
$pdf->SetXY(115, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5);
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("MEXICANA",0,25));

//pais de nacimiento
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5 );
//echo "4,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'sector financiero','','sociedad mercantil'".'<br>';
$pdf->Write(0, substr("MEXICO",0,25));

/////////////////////////////////////// pagina 5 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 3.8;
$yConstCuadrado1 = 51.7;

$pdf->Image('F20926_0005.png' , 0 ,0, 210 , 0,'PNG');

//SECCION cuestionario

//padece alguna enfermedad (si)
$pdf->SetXY(140, $yConstCuadrado1 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','padece alguna enfermedad'".'<br>';
$pdf->Write(0, substr("x",0,1));

//padece alguna enfermedad (no)
$pdf->SetXY(145, $yConstCuadrado1 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','padece alguna enfermedad'".'<br>';
$pdf->Write(0, substr("x",0,1));

//esta sujeto a tratamiento medico (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 1));
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','esta sujeto a tratamiento medico'".'<br>';
$pdf->Write(0, substr("x",0,1));

//esta sujeto a tratamiento medico (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 1));
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','esta sujeto a tratamiento medico'".'<br>';
$pdf->Write(0, substr("x",0,1));

//tiene pruebas de laboratorio pendientes (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 2));
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','tiene pruebas de laboratorio pendientes'".'<br>';
$pdf->Write(0, substr("x",0,1));

//tiene pruebas de laboratorio pendientes (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 2));
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','tiene pruebas de laboratorio pendientes'".'<br>';
$pdf->Write(0, substr("x",0,1));

//le practicaron o tiene pendiente cirugia (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','le practicaron o tiene pendiente cirugia'".'<br>';
$pdf->Write(0, substr("x",0,1));

//le practicaron o tiene pendiente cirugia (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','le practicaron o tiene pendiente cirugia'".'<br>';
$pdf->Write(0, substr("x",0,1));

//ha estado bajo tratamiento por alguna adicion (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 4) + 0.8);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','ha estado bajo tratamiento por alguna adicion'".'<br>';
$pdf->Write(0, substr("x",0,1));

//ha estado bajo tratamiento por alguna adicion (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 4) + 0.8);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','ha estado bajo tratamiento por alguna adicion'".'<br>';
$pdf->Write(0, substr("x",0,1));

/********************************************************/
//tumores o neoplacias (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 9) );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','tumores o neoplacias'".'<br>';
$pdf->Write(0, substr("x",0,1));

//tumores o neoplacias (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 9) );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','tumores o neoplacias'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema circulatorio (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema circulatorio'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema circulatorio (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema circulatorio'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema endocrino (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 11) + 3.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema endocrino'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema endocrino (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 11) + 3.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema endocrino'".'<br>';
$pdf->Write(0, substr("x",0,1));


//congenitas y/o marformaciones de nacimiento (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','congenitas y/o marformaciones de nacimiento'".'<br>';
$pdf->Write(0, substr("x",0,1));

//congenitas y/o marformaciones de nacimiento (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','congenitas y/o marformaciones de nacimiento'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema hematopoyetico e inmune (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 13) + 5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema hematopoyetico e inmune'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema hematopoyetico e inmune (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 13) + 5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema hematopoyetico e inmune'".'<br>';
$pdf->Write(0, substr("x",0,1));


//infeccionsas (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 14) + 5.6);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','infeccionsas'".'<br>';
$pdf->Write(0, substr("x",0,1));

//infeccionsas (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 14) + 5.6);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','infeccionsas'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema nervioso (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 15) + 5.6);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema nervioso'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema nervioso (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 15) + 5.6);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema nervioso'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema respiratorio (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 17) + 5.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema respiratorio'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema respiratorio (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 17) + 5.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema respiratorio'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema digestivo (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 18) + 7.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema digestivo'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema digestivo (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 18) + 7.5);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema digestivo'".'<br>';
$pdf->Write(0, substr("x",0,1));


//hernias (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 19) + 8.2 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','hernias'".'<br>';
$pdf->Write(0, substr("x",0,1));

//hernias (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 19)+ 8.2 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','hernias'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema genitourinario (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 20) + 8.7);
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema genitourinario'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema genitourinario (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 20) + 8.7 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema genitourinario'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del sistema osteomuscular (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 21) + 8.9 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del sistema osteomuscular'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del sistema osteomuscular (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 21) + 8.9 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del sistema osteomuscular'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del ojo (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 22) + 8.7 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del ojo'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del ojo (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 22) + 8.7 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del ojo'".'<br>';
$pdf->Write(0, substr("x",0,1));


//del oido (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 23) + 9.8 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','del oido'".'<br>';
$pdf->Write(0, substr("x",0,1));

//del oido (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 23) + 9.8 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','del oido'".'<br>';
$pdf->Write(0, substr("x",0,1));


//ha sufrido algun accidente que ameritara tratamiento intrahospitalario (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 24) + 9.7 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','ha sufrido algun accidente que ameritara tratamiento intrahospitalario'".'<br>';
$pdf->Write(0, substr("x",0,1));

//ha sufrido algun accidente que ameritara tratamiento intrahospitalario (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 24) + 9.7 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','ha sufrido algun accidente que ameritara tratamiento intrahospitalario'".'<br>';
$pdf->Write(0, substr("x",0,1));


//practica algun deporte peligroso (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 25) + 10.4 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','practica algun deporte peligroso'".'<br>';
$pdf->Write(0, substr("x",0,1));

//practica algun deporte peligroso (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 25) + 10.4 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','practica algun deporte peligroso'".'<br>';
$pdf->Write(0, substr("x",0,1));


//utiliza algun tipo de protesis o ha perdido algun mienbro (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 26) + 11.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','utiliza algun tipo de protesis o ha perdido algun mienbro'".'<br>';
$pdf->Write(0, substr("x",0,1));

//utiliza algun tipo de protesis o ha perdido algun mienbro (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 26) + 11.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','utiliza algun tipo de protesis o ha perdido algun mienbro'".'<br>';
$pdf->Write(0, substr("x",0,1));


//otras enfermedades diferentes a las señaladas anteriormente (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 27) + 11.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','otras enfermedades diferentes a las señaladas anteriormente'".'<br>';
$pdf->Write(0, substr("x",0,1));

//otras enfermedades diferentes a las señaladas anteriormente (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 27) + 11.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','otras enfermedades diferentes a las señaladas anteriormente'".'<br>';
$pdf->Write(0, substr("x",0,1));


//--------------------- seccion 3 ------------------------//

//Ha consumido o ha estado bajo tratamiento por tabaquismo, alcoholismo, estupefacientes o sustancias psicotropicas (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 31) + 11.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','Ha consumido o ha estado bajo tratamiento por tabaquismo, alcoholismo, estupefacientes o sustancias psicotropicas'".'<br>';
$pdf->Write(0, substr("x",0,1));

//Ha consumido o ha estado bajo tratamiento por tabaquismo, alcoholismo, estupefacientes o sustancias psicotropicas (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 31) + 11.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','Ha consumido o ha estado bajo tratamiento por tabaquismo, alcoholismo, estupefacientes o sustancias psicotropicas'".'<br>';
$pdf->Write(0, substr("x",0,1));



//tiene conocimiento de ser esteril (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 32) + 12.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','tiene conocimiento de ser esteril'".'<br>';
$pdf->Write(0, substr("x",0,1));

//tiene conocimiento de ser esteril (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 32) + 12.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','tiene conocimiento de ser esteril'".'<br>';
$pdf->Write(0, substr("x",0,1));


//actualmente esta embarazada (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 33) + 12.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','actualmente esta embarazada'".'<br>';
$pdf->Write(0, substr("x",0,1));

//actualmente esta embarazada (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 33) + 12.6 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','actualmente esta embarazada'".'<br>';
$pdf->Write(0, substr("x",0,1));


//ha tenido complicaciones en el embarazo (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 34) + 13 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'si','x','ha tenido complicaciones en el embarazo'".'<br>';
$pdf->Write(0, substr("x",0,1));

//ha tenido complicaciones en el embarazo (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 34) + 13 );
//echo "5,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'no','x','ha tenido complicaciones en el embarazo'".'<br>';
$pdf->Write(0, substr("x",0,1));


/////////////////////////////////////// pagina 6 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 126;

$pdf->Image('F20926_0006.png' , 0 ,0, 210 , 0,'PNG');

//SECCION habitos generales
//peso
$pdf->SetXY(27, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'peso','','peso'".'<br>';
$pdf->Write(0, substr("999",0,3));

//altura
$pdf->SetXY(39, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'altura','','altura'".'<br>';
$pdf->Write(0, substr("999",0,3));

//fuma (si)
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'si','x','fuma'".'<br>';
$pdf->Write(0, substr("x",0,1));

//fuma (no)
$pdf->SetXY(60, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7);
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'no','x','fuma'".'<br>';
$pdf->Write(0, substr("x",0,1));

//desde que año
$pdf->SetXY(69, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.2 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'desde que año','','desde que año'".'<br>';
$pdf->Write(0, substr("9999",0,4));

//cantidad
$pdf->SetXY(89, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'cantidad','','cantidad'".'<br>';
$pdf->Write(0, substr("999",0,3));

//dia
$pdf->SetXY(100, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'dia','','dia'".'<br>';
$pdf->Write(0, substr("x",0,1));

//mes
$pdf->SetXY(106.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'mes','','mes'".'<br>';
$pdf->Write(0, substr("x",0,1));

//anio
$pdf->SetXY(112, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'anio','','anio'".'<br>';
$pdf->Write(0, substr("x",0,1));


//toma alcohol (si)
$pdf->SetXY(125, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'si','x','toma alcohol'".'<br>';
$pdf->Write(0, substr("x",0,1));

//toma alcohol (no)
$pdf->SetXY(131.5, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7);
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'no','x','toma alcohol'".'<br>';
$pdf->Write(0, substr("x",0,1));

//desde que año
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'desde que año','','desde que año'".'<br>';
$pdf->Write(0, substr("9999",0,4));


//cantidad
$pdf->SetXY(163, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.4 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'cantidad','','cantidad'".'<br>';
$pdf->Write(0, substr("999",0,3));

//dia
$pdf->SetXY(175.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'dia','','dia'".'<br>';
$pdf->Write(0, substr("x",0,1));

//mes
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'mes','','mes'".'<br>';
$pdf->Write(0, substr("x",0,1));

//anio
$pdf->SetXY(187.6, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
//echo "6,'habitos generales',".$pdf->GetX().",".$pdf->GetY().",'anio','','anio'".'<br>';
$pdf->Write(0, substr("x",0,1));

/////////////////////////////////////// pagina 7 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 112;

$pdf->Image('F20926_0007.png' , 0 ,0, 210 , 0,'PNG');

//SECCION declaracion contratante y solicitante

//lugar y fecha de solicitud
$pdf->SetXY(43, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "7,'declaracion contratante y solicitante',".$pdf->GetX().",".$pdf->GetY().",'lugar y fecha de solicitud','','lugar y fecha de solicitud'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//fecha
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 0) );
//echo "7,'declaracion contratante y solicitante',".$pdf->GetX().",".$pdf->GetY().",'fecha','','fecha'".'<br>';
$pdf->Write(0, substr("20/05/2020",0,10));

//SECCION para aspectos internos de la compania
//observaciones 1
$pdf->SetXY(12, $yConstCuadrado1 + ($yCuadrado1 * 5) + 6 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'observaciones 1','','observaciones 1'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//observaciones 2
$pdf->SetXY(12, $yConstCuadrado1 + ($yCuadrado1 * 6) + 4 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'observaciones 2','','observaciones 2'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//se realizo la visita al cliente (si)
$pdf->SetXY(59.4, $yConstCuadrado1 + ($yCuadrado1 * 7) + 2.2 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'si','x','se realizo la visita al cliente'".'<br>';
$pdf->Write(0, substr("x",0,1));

// FIJO
//se realizo la visita al cliente (no)
$pdf->SetXY(69, $yConstCuadrado1 + ($yCuadrado1 * 7)+ 2.2 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'no','x','se realizo la visita al cliente'".'<br>';
$pdf->Write(0, substr("x",0,1));

//resultado de la visita
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 7)+ 2.8 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'resultado de la visita','','resultado de la visita'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//clave del agente
$pdf->SetXY(12, $yConstCuadrado1 + ($yCuadrado1 * 10) - 2.5 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'clave del agente','','clave del agente'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));

//nombre
$pdf->SetXY(50, $yConstCuadrado1 + ($yCuadrado1 * 10) - 2.5 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'nombre','','nombre'".'<br>';
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));

// % comision cedida
$pdf->SetXY(150, $yConstCuadrado1 + ($yCuadrado1 * 10) - 2.5 );
//echo "7,'aspectos internos de la compania',".$pdf->GetX().",".$pdf->GetY().",'% comision cedida','0','% comision cedida'".'<br>';
$pdf->Write(0, substr("100",0,3));

//die();
/************************** fin ********************************************************/

$pdf->Output( 'F20926AC.pdf', 'I');


?>
