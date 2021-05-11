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




//------------------            pagina 1            ------------------------------------------------------ 
//------------------ datos generales del solicitante ------------------------------------------------------

//emisor
$pdf->SetXY(183.2, 56.2);
$pdf->Write(0, "SAUPURE");

//producto contratado
$pdf->SetXY(41.7, 62);
$pdf->Write(0, "SAUPUREIN SAFAR MARCOS DANIEL");


//cliente inbursa
$pdf->SetXY(8.2, 113);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'','','cliente inbursa'".'<br>';

//identificador comercial
$pdf->SetXY(84.1, 113);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'datos generales del solicitante','','identificador comercialm'".'<br>';

//RFC
$pdf->SetXY(153.2, 113);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'datos generales del solicitante','','RFC'".'<br>';

//primer nombre
$pdf->SetXY(8.2, 123);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'datos generales del solicitante','','primer nombre'".'<br>';
//segundo nombre
$pdf->SetXY(58.8, 123);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'datos generales del solicitante','','segundo nombre'".'<br>';
//apellido paterno
$pdf->SetXY(106.6, 123);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'datos generales del solicitante','','apellido paterno'".'<br>';
//apellido materno
$pdf->SetXY(155.4, 123);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'datos generales del solicitante','','apellido materno'".'<br>';


//fecha nacimiento
$pdf->SetXY(8.2, 142);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';
//entidad federativa
$pdf->SetXY(54.4, 142);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
//pais nacimiento
$pdf->SetXY(133.8, 142);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'pais nacimiento','','pais nacimiento'".'<br>';

//femenino
$pdf->SetXY(7.9, 151);
$pdf->Write(0, "x");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'genero','x','femenino'".'<br>';
//masculino
$pdf->SetXY(7.9, 156);
$pdf->Write(0, "x");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'genero','x','masculino'".'<br>';

//casado
$pdf->SetXY(30.4, 151);
$pdf->Write(0, "x");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'estado civil','x','casado'".'<br>';
//soltero
$pdf->SetXY(30.4, 156);
$pdf->Write(0, "x");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'estado civil','x','soltero'".'<br>';

//nacionalidad
$pdf->SetXY(57.6, 151.7);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'nacionalidad','','nacionalidad'".'<br>';

//tipo identificacion
$pdf->SetXY(8.2, 166);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'tipo identificacion','','tipo identificacion'".'<br>';
//nro identificacion
$pdf->SetXY(89.4, 166);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'nro identificacion','','nro identificacion'".'<br>';

//curp
$pdf->SetXY(8.2, 176);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'1.1 generales',".$pdf->GetX().",".$pdf->GetY().",'curp','','curp'".'<br>';


//calle
$pdf->SetXY(8.2, 192);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'calle','','calle'".'<br>';
//num exterior
$pdf->SetXY(129, 192);
$pdf->Write(0, "SAUPUR");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'num exterior','','num exterior'".'<br>';
//edificio
$pdf->SetXY(151, 192);
$pdf->Write(0, "SAUPU");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
//num interior
$pdf->SetXY(183, 192);
$pdf->Write(0, "SAUPUR");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'num interior','','num interior'".'<br>';


//entre calle1
$pdf->SetXY(8.2, 201.6);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'entre calle1','','entre calle1'".'<br>';
//entre calle2
$pdf->SetXY(96, 201.6);
$pdf->Write(0, "SAUPUREIN SAFAR");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'entre calle2','','entre calle2'".'<br>';
//cp
$pdf->SetXY(183, 201.6);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'cp','','cp'".'<br>';

//colonia
$pdf->SetXY(8.2, 211.9);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';
//municipio
$pdf->SetXY(113, 211.9);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'municipio','','municipio'".'<br>';


//ciudad
$pdf->SetXY(8.2, 221.9);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
//entidad federativa
$pdf->SetXY(87.3, 221.9);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
//pais
$pdf->SetXY(159.6, 221.9);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'pais','','pais'".'<br>';


//tel fijo
$pdf->SetXY(8.2, 236.8);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'tel fijo','','tel fijo'".'<br>';
//tel movil
$pdf->SetXY(50.6, 236.8);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'tel movil','','tel movil'".'<br>';
//email
$pdf->SetXY(93.6, 236.8);
$pdf->Write(0, "123456");
//echo "3,1,'domicilio y contacto',".$pdf->GetX().",".$pdf->GetY().",'email','','email'".'<br>';


//funcion publica si
$pdf->SetXY(36, 252.5);
$pdf->Write(0, "x");
//echo "3,1,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'funcion publica','','no'".'<br>';


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


//cargo
$pdf->SetXY(8.2, 36.1);
$pdf->Write(0, "SAUPUREIN MARCOS");
//echo "3,2,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'cargo','','cargo'".'<br>';
//fecha en que dejo el cargo
$pdf->SetXY(159, 36.1);
$pdf->Write(0, "SAUPUREIN MARCOS");
//echo "3,2,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'fecha en que dejo el cargo','','fecha en que dejo el cargo'".'<br>';

//nombre y apellido funcion publica
$pdf->SetXY(8.2, 46.7);
$pdf->Write(0, "SAUPUREIN MARCOS");
//echo "3,2,'informacion adicional',".$pdf->GetX().",".$pdf->GetY().",'nombre y apellido funcion publica','','nombre y apellido funcion publica'".'<br>';

//nombre de la empresa
$pdf->SetXY(8.2, 60.6);
$pdf->Write(0, "SAUPUREIN MARCOS");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'nombre de la empresa','','nombre de la empresa'".'<br>';

//puesto
$pdf->SetXY(8.2, 71);
$pdf->Write(0, "SAUPUREIN MARCOS");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'puesto','','puesto'".'<br>';
//antiguedad
$pdf->SetXY(80.2, 71);
$pdf->Write(0, "SAUPURE");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'antiguedad','','antiguedad'".'<br>';
//ingresos brutos
$pdf->SetXY(104.6, 71);
$pdf->Write(0, "123456");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'ingresos brutos','','ingresos brutos'".'<br>';
//telefono
$pdf->SetXY(144.1, 71);
$pdf->Write(0, "123456");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'puesto','','puesto'".'<br>';
//extension
$pdf->SetXY(183.6, 71);
$pdf->Write(0, "12345");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'extension','','extension'".'<br>';

//ocupacion
$pdf->SetXY(8.2, 80.6);
$pdf->Write(0, "SAUPUREIN MARCOS");
//echo "3,2,'datos del empleo actual',".$pdf->GetX().",".$pdf->GetY().",'ocupacion','','ocupacion'".'<br>';


//moneda
$pdf->SetXY(91.5, 102.8);
$pdf->Write(0, "x");
//echo "3,2,'informacion seguro a contratar',".$pdf->GetX().",".$pdf->GetY().",'moneda','','moneda'".'<br>';

//suma asegurada fallecimiento
$pdf->SetXY(8.2, 113.2);
$pdf->Write(0, "x123123");
//echo "3,2,'informacion seguro a contratar',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada fallecimiento','','suma asegurada fallecimiento'".'<br>';
//suma asegurada supervivencia
$pdf->SetXY(62, 113.2);
$pdf->Write(0, "123123");
//echo "3,2,'informacion seguro a contratar',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada supervivencia','','suma asegurada supervivencia'".'<br>';

//plazo del seguro
$pdf->SetXY(138.1, 113.2);
$pdf->Write(0, "11");
//echo "3,2,'informacion seguro a contratar',".$pdf->GetX().",".$pdf->GetY().",'plazo del seguro','','plazo del seguro'".'<br>';
//plazo del pago
$pdf->SetXY(165.2, 113.2);
$pdf->Write(0, "11");
//echo "3,2,'informacion seguro a contratar',".$pdf->GetX().",".$pdf->GetY().",'plazo del pago','','plazo del pago'".'<br>';



//peso
$pdf->SetXY(29.6, 207.9);
$pdf->Write(0, "95");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'peso','','peso'".'<br>';
//estatura
$pdf->SetXY(68.3, 207.9);
$pdf->Write(0, "95");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'estatura','','estatura'".'<br>';


//bajo tratamiento - si
$pdf->SetXY(192, 212.2);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'diagnosticado o bajo tratamiento de alguna enfermedad','','si'".'<br>';
//bajo tratamiento - no
$pdf->SetXY(196.5, 212.2);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'diagnosticado o bajo tratamiento de alguna enfermedad','','no'".'<br>';

//padece alguna enfermedad solo para mujeres - si
$pdf->SetXY(192, 247.1);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'padece alguna enfermedad solo para mujeres','','si'".'<br>';
//padece alguna enfermedad solo para mujeres - no
$pdf->SetXY(196.5, 247.1);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'padece alguna enfermedad solo para mujeres','','no'".'<br>';

//padece alguna enfermedad no mencionada - si
$pdf->SetXY(192, 256.6);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'padece alguna enfermedad no mencionada','','si'".'<br>';
//padece alguna enfermedad no mencionada - no
$pdf->SetXY(196.5, 256.6);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'padece alguna enfermedad no mencionada','','no'".'<br>';


//participa en eventos de buceo,motociclismo,etc - si
$pdf->SetXY(192, 261.3);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'participa en eventos de buceo,motociclismo,etc','','si'".'<br>';
//participa en eventos de buceo,motociclismo,etc - no
$pdf->SetXY(196.5, 261.3);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'participa en eventos de buceo,motociclismo,etc','','no'".'<br>';

//fuma - si
$pdf->SetXY(192, 266.1);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'fuma','','si'".'<br>';
//fuma - no
$pdf->SetXY(196.5, 266.1);
$pdf->Write(0, "x");
//echo "3,2,'cuestionario',".$pdf->GetX().",".$pdf->GetY().",'fuma','','no'".'<br>';


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


//beneficiario irrevocable
$pdf->SetXY(57.6, 104.2);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'beneficiario irrevocable','','beneficiario irrevocable'".'<br>';

//primer nombre
$pdf->SetXY(8.2, 114.8);
$pdf->Write(0, "SAUPUREIN");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
//segundo nombre
$pdf->SetXY(56.2, 114.8);
$pdf->Write(0, "SAUPUREIN");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';
//apellido paterno
$pdf->SetXY(105, 114.8);
$pdf->Write(0, "SAUPUREIN");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
//apellido materno
$pdf->SetXY(153.6, 114.8);
$pdf->Write(0, "SAUPUREIN");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//fecha nacimiento
$pdf->SetXY(8.2, 125);
$pdf->Write(0, "2021-10-10");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';

//genero femenino
$pdf->SetXY(63.3, 119);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'genero','','femenino'".'<br>';
//genero masculino
$pdf->SetXY(63.3, 124);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'genero','','masculino'".'<br>';

//parentesco
$pdf->SetXY(91, 125);
$pdf->Write(0, "SAUPUREIN");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'parentesco','','parentesco'".'<br>';

//otros seguros
$pdf->SetXY(36.1, 207.9);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'otros seguros','','no'".'<br>';

//ha sido rechazado en alguna solicitud
$pdf->SetXY(33.6, 235.8);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'ha sido rechazado en alguna solicitud','','no'".'<br>';

//cobro bancario
$pdf->SetXY(47.4, 245.3);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'cobro bancario','','no'".'<br>';
//periodo de pago
$pdf->SetXY(185.7, 245.3);
$pdf->Write(0, "x");
//echo "3,3,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'periodo de pago','','anual'".'<br>';


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


//via correo
$pdf->SetXY(12.1, 55.5);
$pdf->Write(0, "x");
//echo "3,4,'entrega de la documentacion contractual',".$pdf->GetX().",".$pdf->GetY().",'via correo','','via correo'".'<br>';

//lugar
$pdf->SetXY(8.2, 164.2);
$pdf->Write(0, "x");
//echo "3,4,'declaracion de solicitudes',".$pdf->GetX().",".$pdf->GetY().",'lugar','','lugar'".'<br>';
//fecha
$pdf->SetXY(163.8, 164.2);
$pdf->Write(0, "x");
//echo "3,4,'declaracion de solicitudes',".$pdf->GetX().",".$pdf->GetY().",'fecha','','fecha'".'<br>';


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


//clave
$pdf->SetXY(18.1, 86.6);
$pdf->Write(0, "x");
//echo "3,4,'comisiones',".$pdf->GetX().",".$pdf->GetY().",'clave','','clave'".'<br>';


//participacion = 100%
//clave
$pdf->SetXY(27.6, 92.2);
$pdf->Write(0, "x");
//echo "3,4,'comisiones',".$pdf->GetX().",".$pdf->GetY().",'clave','','clave'".'<br>';



//nombre =  Javier A. Foncerrada
//nombre y firma
$pdf->SetXY(45.6, 92.2);
$pdf->Write(0, "x");
//echo "3,4,'comisiones',".$pdf->GetX().",".$pdf->GetY().",'nombre y firma','','nombre y firma'".'<br>';


//dia
$pdf->SetXY(138.8, 258.9);
$pdf->Write(0, "20");
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'dia','','dia'".'<br>';
//condusef
$pdf->SetXY(152.9, 258.9);
$pdf->Write(0, "12");
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'mes','','mes'".'<br>';
//condusef
$pdf->SetXY(163.4, 258.9);
$pdf->Write(0, "2021");
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'anio','','anio'".'<br>';

// numero condusef = 'falta'
//condusef
$pdf->SetXY(7, 262,6);
$pdf->Write(0, "x");
//echo "3,4,'fin pagina',".$pdf->GetX().",".$pdf->GetY().",'condusef','','condusef'".'<br>';



//------------------            fin pagina 5            ------------------------------------------------------


$pdf->Output('Vida500AC.pdf', 'I');





?>
