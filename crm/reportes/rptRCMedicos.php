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
$pdf->setSourceFile('RCMEDICOS.pdf');
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

// now write some text above the imported page
$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);



//------------------            pagina 1            ------------------------------------------------------ 
//------------------ datos generales del solicitante ------------------------------------------------------


//emisor
$pdf->SetXY(188, 45);
//$pdf->Write(0, "SAFAR");
echo "5,1,'emisor',".$pdf->GetX().",".$pdf->GetY().",'emisor','','emisor'".'<br>';

//cliente inbursa
$pdf->SetXY(8, 95);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'cliente inbursa','','cliente inbursa'".'<br>';
//identificador comercial
$pdf->SetXY(49, 95);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'identificador comercial','','identificador comercial'".'<br>';
//rfc
$pdf->SetXY(92, 95);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'rfc','','rfc'".'<br>';
//tipo persona
$pdf->SetXY(181, 90);
//$pdf->Write(0, "x");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'tipo persona','','fisica'".'<br>';
//tipo persona
$pdf->SetXY(181, 94.5);
//$pdf->Write(0, "x");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'tipo persona','','moral'".'<br>';

//razon social
$pdf->SetXY(8, 105.6);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'razon social','','razon social'".'<br>';

//primer nombre
$pdf->SetXY(8, 114.6);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
//segundo nombre
$pdf->SetXY(112.4, 114.6);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';

//apellido paterno
$pdf->SetXY(8, 124.9);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
//apellido materno
$pdf->SetXY(112.4, 124.9);
//$pdf->Write(0, "SAFAR");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//fecha nacimiento
$pdf->SetXY(8, 139.4);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';

//entidad federativa
$pdf->SetXY(57.6, 139.4);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';

//pais nacimiento
$pdf->SetXY(136.4, 139.4);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'pais nacimiento','','pais nacimiento'".'<br>';


//genero
$pdf->SetXY(8, 150);
//$pdf->Write(0, "x");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'genero','','femenino'".'<br>';
//genero
$pdf->SetXY(8, 154.5);
//$pdf->Write(0, "x");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'genero','','masculino'".'<br>';

//estado civil
$pdf->SetXY(31, 150);
//$pdf->Write(0, "x");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','casado'".'<br>';
//estado civil
$pdf->SetXY(31, 154.5);
//$pdf->Write(0, "x");
echo "5,1,'datos generales contratante',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','soltero'".'<br>';

//nacionalidad
$pdf->SetXY(57.6, 149.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'nacionalidad','','nacionalidad'".'<br>';


//tipo identificacion
$pdf->SetXY(8, 164.3);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'tipo identificacion','','tipo identificacion'".'<br>';

//nro identifiacion
$pdf->SetXY(90.6, 164.3);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'nro identifiacion','','nro identifiacion'".'<br>';

//curp
$pdf->SetXY(8, 174);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'curp','','curp'".'<br>';


//ocupacion
$pdf->SetXY(8, 184.2);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'ocupacion','','ocupacion'".'<br>';

//folio mercantil
$pdf->SetXY(144.6, 184.2);
//$pdf->Write(0, "SAFAR");
echo "5,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'folio mercantil','','folio mercantil'".'<br>';


//calle
$pdf->SetXY(8, 199.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'calle','','calle'".'<br>';
//nro exterior
$pdf->SetXY(142.9, 199.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'nro exterior','','nro exterior'".'<br>';
//edificio
$pdf->SetXY(162.6, 199.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
//nro interior
$pdf->SetXY(187.9, 199.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'nro interior','','nro interior'".'<br>';

//entre calle1
$pdf->SetXY(8, 209.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'entre calle1','','entre calle1'".'<br>';
//entre calle2
$pdf->SetXY(67.9, 209.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'entre calle2','','entre calle2'".'<br>';
//cp
$pdf->SetXY(127.9, 209.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'cp','','cp'".'<br>';
//colonia
$pdf->SetXY(148, 209.5);
//$pdf->Write(0, "SAFAR22");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';

//ciudad
$pdf->SetXY(8, 219.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
//municipio
$pdf->SetXY(58, 219.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'municipio','','municipio'".'<br>';
//entidad federativa
$pdf->SetXY(108, 219.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
//pais
$pdf->SetXY(158, 219.5);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'pais','','pais'".'<br>';

//telefono fijo
$pdf->SetXY(8, 234);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'telefono fijo','','telefono fijo'".'<br>';
//telefono movil
$pdf->SetXY(49, 234);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'telefono movil','','telefono movil'".'<br>';
//email
$pdf->SetXY(89.7, 234);
//$pdf->Write(0, "SAFAR");
echo "5,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'email','','email'".'<br>';

//------------------            fin pagina 1            ------------------------------------------------------


//------------------            pagina 2            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('RCMEDICOS.pdf');
// import page 1
$tplIdx = $pdf->importPage(2);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);

//desempeñe funcion publica
$pdf->SetXY(27.6, 38.5);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante',".$pdf->GetX().",".$pdf->GetY().",'desempenie funcion publica','','si'".'<br>';
//desempeñe funcion publica
$pdf->SetXY(37.9, 38.5);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante',".$pdf->GetX().",".$pdf->GetY().",'desempenie funcion publica','','no'".'<br>';

//quien
$pdf->SetXY(64, 37.9);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante',".$pdf->GetX().",".$pdf->GetY().",'quien','','quien'".'<br>';

//cargo
$pdf->SetXY(8, 48.2);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante',".$pdf->GetX().",".$pdf->GetY().",'cargo','','cargo'".'<br>';

//fecha que dejo cargo
$pdf->SetXY(167.7, 48.2);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante',".$pdf->GetX().",".$pdf->GetY().",'fecha que dejo cargo','','fecha que dejo cargo'".'<br>';

//nombre completo
$pdf->SetXY(8, 57.6);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante',".$pdf->GetX().",".$pdf->GetY().",'nombre completo','','nombre completo'".'<br>';


//tipo persona
$pdf->SetXY(35, 68);
//$pdf->Write(0, "x");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'tipo persona','','fisica'".'<br>';
//tipo persona
$pdf->SetXY(35, 72.5);
//$pdf->Write(0, "x");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'tipo persona','','moral'".'<br>';

//rfc
$pdf->SetXY(52.5, 73);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'rfc','','rfc'".'<br>';

//razon social
$pdf->SetXY(8, 83.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'razon social','','razon social'".'<br>';

//primer nombre
$pdf->SetXY(8, 93.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
//segundo nombre
$pdf->SetXY(112.4, 93.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';

//apellido paterno
$pdf->SetXY(8, 103.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
//apellido materno
$pdf->SetXY(112.4, 103.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//fecha nacimiento
$pdf->SetXY(8, 113.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';

//entidad federativa
$pdf->SetXY(57.2, 113.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';

//pais nacimiento
$pdf->SetXY(136, 113.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'pais nacimiento','','pais nacimiento'".'<br>';




//genero
$pdf->SetXY(8, 123.7);
//$pdf->Write(0, "x");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'genero','','femenino'".'<br>';
//genero
$pdf->SetXY(8, 129);
//$pdf->Write(0, "x");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'genero','','masculino'".'<br>';

//estado civil
$pdf->SetXY(31, 123.7);
//$pdf->Write(0, "x");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','casado'".'<br>';
//estado civil
$pdf->SetXY(31, 129);
//$pdf->Write(0, "x");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','soltero'".'<br>';

//nacionalidad
$pdf->SetXY(57.2, 123.2);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'nacionalidad','','nacionalidad'".'<br>';


//tipo identificacion
$pdf->SetXY(8, 138.2);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'tipo identificacion','','tipo identificacion'".'<br>';

//nro identifiacion
$pdf->SetXY(89.7, 138.2);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'nro identifiacion','','nro identifiacion'".'<br>';

//curp
$pdf->SetXY(8, 148.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'curp','','curp'".'<br>';


//ocupacion
$pdf->SetXY(8, 158.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'ocupacion','','ocupacion'".'<br>';

//folio mercantil
$pdf->SetXY(143.7, 158.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'folio mercantil','','folio mercantil'".'<br>';


//calle
$pdf->SetXY(8, 173.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'calle','','calle'".'<br>';
//nro exterior
$pdf->SetXY(142.9, 173.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'nro exterior','','nro exterior'".'<br>';
//edificio
$pdf->SetXY(162.6, 173.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
//nro interior
$pdf->SetXY(187.8, 173.3);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'nro interior','','nro interior'".'<br>';

//entre calle1
$pdf->SetXY(8, 183.6);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'entre calle1','','entre calle1'".'<br>';
//entre calle2
$pdf->SetXY(67.9, 183.6);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'entre calle2','','entre calle2'".'<br>';
//cp
$pdf->SetXY(127.9, 183.6);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'cp','','cp'".'<br>';
//colonia
$pdf->SetXY(148.5, 183.6);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';

//ciudad
$pdf->SetXY(8, 193.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
//municipio
$pdf->SetXY(57.6, 193.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'municipio','','municipio'".'<br>';
//entidad federativa
$pdf->SetXY(108.2, 193.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
//pais
$pdf->SetXY(157.9, 193.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'pais','','pais'".'<br>';

//telefono fijo
$pdf->SetXY(8, 208.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'telefono fijo','','telefono fijo'".'<br>';
//telefono movil
$pdf->SetXY(49, 208.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'telefono movil','','telefono movil'".'<br>';
//email
$pdf->SetXY(90.2, 208.4);
//$pdf->Write(0, "SAFAR");
echo "5,2,'datos generales contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'email','','email'".'<br>';


//desempeñe funcion publica
$pdf->SetXY(28, 240.2);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'desempenie funcion publica','','si'".'<br>';
//desempeñe funcion publica
$pdf->SetXY(38, 240.2);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'desempenie funcion publica','','no'".'<br>';

//quien
$pdf->SetXY(64, 240);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'quien','','quien'".'<br>';

//cargo
$pdf->SetXY(8, 249.6);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'cargo','','cargo'".'<br>';

//fecha que dejo cargo
$pdf->SetXY(168.6, 249.6);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'fecha que dejo cargo','','fecha que dejo cargo'".'<br>';

//nombre completo
$pdf->SetXY(8, 260);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'nombre completo','','nombre completo'".'<br>';


//------------------           fin pagina 2            ------------------------------------------------------


//------------------            pagina 3            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('RCMEDICOS.pdf');
// import page 1
$tplIdx = $pdf->importPage(3);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


//primer nombre
$pdf->SetXY(8, 31.6);
//$pdf->Write(0, "x");
echo "5,3,'representante legal del solicitante - contratente',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';
//segundo nombre
$pdf->SetXY(112, 31.6);
//$pdf->Write(0, "x");
echo "5,3,'representante legal del solicitante - contratente',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';

//apellido paterno
$pdf->SetXY(8, 41.7);
//$pdf->Write(0, "x");
echo "5,3,'representante legal del solicitante - contratente',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';
//apellido materno
$pdf->SetXY(112, 41.7);
//$pdf->Write(0, "x");
echo "5,3,'representante legal del solicitante - contratente',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//tipo identificacion
$pdf->SetXY(8, 52);
//$pdf->Write(0, "x");
echo "5,3,'representante legal del solicitante - contratente',".$pdf->GetX().",".$pdf->GetY().",'tipo identificacion','','tipo identificacion'".'<br>';
//nro identificacion
$pdf->SetXY(90.2, 52);
//$pdf->Write(0, "x");
echo "5,3,'representante legal del solicitante - contratente',".$pdf->GetX().",".$pdf->GetY().",'nro identificacion','','nro identificacion'".'<br>';


//desde las 12:00
$pdf->SetXY(72.6, 62.3);
//$pdf->Write(0, "x");
echo "5,3,'informacion del seguro',".$pdf->GetX().",".$pdf->GetY().",'desde las 12:00','','desde las 12:00'".'<br>';

//hasta las 12:00
$pdf->SetXY(147.2, 62.3);
//$pdf->Write(0, "x");
echo "5,3,'informacion del seguro',".$pdf->GetX().",".$pdf->GetY().",'hasta las 12:00','','hasta las 12:00'".'<br>';

//poliza anterior numero
$pdf->SetXY(35.3, 71.7);
//$pdf->Write(0, "x");
echo "5,3,'informacion del seguro',".$pdf->GetX().",".$pdf->GetY().",'poliza anterior numero','','poliza anterior numero'".'<br>';

//poliza anterior fechavencimiento
$pdf->SetXY(71.7, 71.7);
//$pdf->Write(0, "x");
echo "5,3,'informacion del seguro',".$pdf->GetX().",".$pdf->GetY().",'poliza anterior fechavencimiento','','poliza anterior fechavencimiento'".'<br>';


//calle
$pdf->SetXY(8, 96.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'calle','','calle'".'<br>';
//no exterior
$pdf->SetXY(67, 96.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'no exterior','','no exterior'".'<br>';
//edificio
$pdf->SetXY(85, 96.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
//no interior
$pdf->SetXY(109.9, 96.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'no interior','','no interior'".'<br>';
//cp
$pdf->SetXY(128.3, 96.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'cp','','cp'".'<br>';
//colonia
$pdf->SetXY(150, 96.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';

//ciudad
$pdf->SetXY(8, 106.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
//entidad federativa
$pdf->SetXY(58.9, 106.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
//municipio
$pdf->SetXY(109.9, 106.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'municipio','','municipio'".'<br>';
//pais
$pdf->SetXY(160, 106.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'pais','','pais'".'<br>';

//actividad
$pdf->SetXY(8, 116.4);
//$pdf->Write(0, "x");
echo "5,3,'ubicaion del bien asegurado',".$pdf->GetX().",".$pdf->GetY().",'actividad','','actividad'".'<br>';

//suma asegurada
$pdf->SetXY(171.6, 131.4);
//$pdf->Write(0, "x");
echo "5,3,'coberturas',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada','','suma asegurada'".'<br>';

//arrendatario
$pdf->SetXY(13.5, 151);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'arrendatario','','arrendatario'".'<br>';

//adicional
$pdf->SetXY(43.5, 151);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'adicional','','adicional'".'<br>';

//suma asegurada adicional
$pdf->SetXY(68.7, 151);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada adicional','','suma asegurada adicional'".'<br>';

//sublimite
$pdf->SetXY(43.5, 157);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'sublimite','','sublimite'".'<br>';

//suma asegurada sublimite
$pdf->SetXY(68.7, 155.7);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada sublimite','','suma asegurada sublimite'".'<br>';

//asumida
$pdf->SetXY(13.5, 161.4);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'asumida','','asumida'".'<br>';

//suma asegurada asumida
$pdf->SetXY(68.7, 160.9);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada asumida','','suma asegurada asumida'".'<br>';

//contaminacion
$pdf->SetXY(13.5, 166.6);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'contaminacion','','contaminacion'".'<br>';

//suma asegurada contaminacion
$pdf->SetXY(68.7, 166);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada contaminacion','','suma asegurada contaminacion'".'<br>';

//contaminacion en el predio
$pdf->SetXY(13.5, 171.8);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'contaminacion en el predio','','contaminacion en el predio'".'<br>';
//explosivos
$pdf->SetXY(13.5, 177);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'explosivos','','explosivos'".'<br>';
//maniobras de carga
$pdf->SetXY(13.5, 181.7);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'maniobras de carga','','maniobras de carga'".'<br>';
//productos en el extrangero
$pdf->SetXY(13.5, 186.5);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'productos en el extrangero','','productos en el extrangero'".'<br>';

//suma asegurada extrangero
$pdf->SetXY(68.7, 185.7);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada extrangero','','suma asegurada extrangero'".'<br>';


//productos territorio nacional
$pdf->SetXY(13.5, 191.5);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'productos territorio nacional','','productos territorio nacional'".'<br>';
//profesional
$pdf->SetXY(13.5, 196.8);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'profesional','','profesional'".'<br>';

//profesional - profesion
$pdf->SetXY(43.5, 200.7);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'profesional - profesion','','profesional - profesion'".'<br>';
//profesional - no cedula
$pdf->SetXY(128.3, 200.7);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales',".$pdf->GetX().",".$pdf->GetY().",'profesional - no cedula','','profesional - no cedula'".'<br>';


//principal
$pdf->SetXY(13.5, 212);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'principal','','principal'".'<br>';

//accesorio
$pdf->SetXY(58.4, 212);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'accesorio','','accesorio'".'<br>';

//estacionamiento con acomodador
$pdf->SetXY(13.5, 217.2);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'estacionamiento con acomodador','','estacionamiento con acomodador'".'<br>';
//estacionamiento sin acomodador
$pdf->SetXY(13.5, 222.2);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'estacionamiento sin acomodador','','estacionamiento sin acomodador'".'<br>';


//suma asegurada
$pdf->SetXY(60.6, 226);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada','','suma asegurada'".'<br>';
//sublimita por unidad
$pdf->SetXY(60.6, 231);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'sublimita por unidad','','sublimita por unidad'".'<br>';
//numero cajones
$pdf->SetXY(60.6, 236.3);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil estacionamiento',".$pdf->GetX().",".$pdf->GetY().",'numero cajones','','numero cajones'".'<br>';


//prueba
$pdf->SetXY(108.4, 212.2);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil taller',".$pdf->GetX().",".$pdf->GetY().",'prueba','','prueba'".'<br>';

//recoleccion y entrega
$pdf->SetXY(108.4, 217.2);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil taller',".$pdf->GetX().",".$pdf->GetY().",'recoleccion y entrega','','recoleccion y entrega'".'<br>';

//suma asegurada
$pdf->SetXY(168.2, 221.3);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil taller',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada','','suma asegurada'".'<br>';
//sublimita por unidad
$pdf->SetXY(168.2, 226.4);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil taller',".$pdf->GetX().",".$pdf->GetY().",'sublimita por unidad','','sublimita por unidad'".'<br>';
//radio de accion para talleres
$pdf->SetXY(168.2, 231.6);
//$pdf->Write(0, "x");
echo "5,3,'coberturas adicionales - responsabilidad civil taller',".$pdf->GetX().",".$pdf->GetY().",'radio de accion para talleres','','radio de accion para talleres'".'<br>';



//------------------           fin pagina 3            ------------------------------------------------------


//------------------            pagina 4            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('RCMEDICOS.pdf');
// import page 1
$tplIdx = $pdf->importPage(4);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


//guaradarropa
$pdf->SetXY(13.8, 32.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'guaradarropa','','guaradarropa'".'<br>';
//sublimite suma asegurada guaradarropa
$pdf->SetXY(112, 32.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada guaradarropa','','sublimite suma asegurada guaradarropa'".'<br>';
//sublimite por evento guaradarropa
$pdf->SetXY(161.3, 32.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento guaradarropa','','sublimite por evento guaradarropa'".'<br>';

//equipaje
$pdf->SetXY(13.8, 37.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'equipaje','','equipaje'".'<br>';
//sublimite suma asegurada equipaje
$pdf->SetXY(112, 37.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada equipaje','','sublimite suma asegurada equipaje'".'<br>';
//sublimite por evento equipaje
$pdf->SetXY(161.3, 37.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento equipaje','','sublimite por evento equipaje'".'<br>';

//caja de seguridad administracion
$pdf->SetXY(13.8, 42.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'caja de seguridad administracion','','caja de seguridad administracion'".'<br>';
//sublimite suma asegurada caja de seguridad administracion
$pdf->SetXY(112, 42.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada caja de seguridad administracion','','sublimite suma asegurada caja de seguridad administracion'".'<br>';
//sublimite por evento caja de seguridad administracion
$pdf->SetXY(161.3, 42.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento caja de seguridad administracion','','sublimite por evento caja de seguridad administracion'".'<br>';

//caja de seguridad habitacion
$pdf->SetXY(13.8, 47.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'caja de seguridad habitacion','','caja de seguridad habitacion'".'<br>';
//sublimite suma asegurada caja de seguridad habitacion
$pdf->SetXY(112, 47.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada caja de seguridad habitacion','','sublimite suma asegurada caja de seguridad habitacion'".'<br>';
//sublimite por evento caja de seguridad habitacion
$pdf->SetXY(161.3, 47.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento caja de seguridad habitacion','','sublimite por evento caja de seguridad habitacion'".'<br>';

//sublimite habitacion
$pdf->SetXY(13.8, 52.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite habitacion','','sublimite habitacion'".'<br>';
//sublimite suma asegurada sublimite habitacion
$pdf->SetXY(112, 52.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada equipsublimite habitacionaje','','sublimite suma asegurada sublimite habitacion'".'<br>';
//sublimite por evento sublimite habitacion
$pdf->SetXY(161.3, 52.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento sublimite habitacion','','sublimite por evento sublimite habitacion'".'<br>';

//tintoreria
$pdf->SetXY(13.8, 57.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'tintoreria','','tintoreria'".'<br>';
//sublimite suma asegurada tintoreria
$pdf->SetXY(112, 57.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada tintoreria','','sublimite suma asegurada tintoreria'".'<br>';
//sublimite por evento tintoreria
$pdf->SetXY(161.3, 57.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento tintoreria','','sublimite por evento tintoreria'".'<br>';

//sublimite prenda
$pdf->SetXY(13.8, 62.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite prenda','','sublimite prenda'".'<br>';
//sublimite suma asegurada sublimite prenda
$pdf->SetXY(112, 62.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite suma asegurada sublimite prenda','','sublimite suma asegurada sublimite prenda'".'<br>';
//sublimite por evento sublimite prenda
$pdf->SetXY(161.3, 62.7);
//$pdf->Write(0, "x");
echo "5,4,'coberturas adicionales - responsabilidad civil hotel',".$pdf->GetX().",".$pdf->GetY().",'sublimite por evento sublimite prenda','','sublimite por evento sublimite prenda'".'<br>';



//cobro bancario
$pdf->SetXY(34, 77.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'cobro bancario','','si'".'<br>';
//cobro bancario
$pdf->SetXY(34, 82.4);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'cobro bancario','','no'".'<br>';

//periodo de pago
$pdf->SetXY(71.7, 77.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo de pago','','mensual'".'<br>';
//periodo de pago
$pdf->SetXY(92.7, 77.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo de pago','','trimestral'".'<br>';
//periodo de pago
$pdf->SetXY(115.9, 77.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo de pago','','semestral'".'<br>';
//periodo de pago
$pdf->SetXY(139, 77.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo de pago','','anual'".'<br>';
//periodo de pago
$pdf->SetXY(154.4, 77.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo de pago','','unico'".'<br>';

//moneda
$pdf->SetXY(71.7, 82.4);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'moneda','','nacional'".'<br>';
//moneda
$pdf->SetXY(92.7, 82.4);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'moneda','','dolares'".'<br>';

//recibo
$pdf->SetXY(71.7, 87.2);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'recibo','','individual'".'<br>';
//recibo
$pdf->SetXY(92.7, 87.2);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'recibo','','global'".'<br>';
//recibo
$pdf->SetXY(147.6, 87.2);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'recibo','','filial'".'<br>';

//lugar
$pdf->SetXY(8, 178.4);
//$pdf->Write(0, "x");
echo "5,4,'declaraciones del solicitante',".$pdf->GetX().",".$pdf->GetY().",'lugar','','lugar'".'<br>';
//fecha
$pdf->SetXY(168.6, 178.4);
//$pdf->Write(0, "x");
echo "5,4,'declaraciones del solicitante',".$pdf->GetX().",".$pdf->GetY().",'lugar','','fecha'".'<br>';





//------------------           fin pagina 4            ------------------------------------------------------


//------------------            pagina 5            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('RCMEDICOS.pdf');
// import page 1
$tplIdx = $pdf->importPage(5);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


//------------------           fin pagina 5            ------------------------------------------------------



//$pdf->Output('Vida500AC.pdf', 'I');





?>
