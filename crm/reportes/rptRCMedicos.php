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
$pdf->setSourceFile('solRC.pdf');
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
$pdf->setSourceFile('solRC.pdf');
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
$pdf->SetXY(28, 239.5);
//$pdf->Write(0, "x");
echo "5,2,'informacion adicioanl contratante en caso que sea distinto del solicitante',".$pdf->GetX().",".$pdf->GetY().",'desempenie funcion publica','','si'".'<br>';
//desempeñe funcion publica
$pdf->SetXY(38, 239.5);
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
$pdf->setSourceFile('solRC.pdf');
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


//especialidad 1
$pdf->SetXY(8, 97);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'especialidad 1','','especialidad 1'".'<br>';

//institucion 1
$pdf->SetXY(8, 107.3);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'institucion 1','','institucion 1'".'<br>';

//numero cedula 1
$pdf->SetXY(8, 117.3);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'numero cedula 1','','numero cedula 1'".'<br>';

//numero secretaria de salud 1
$pdf->SetXY(140, 117.3);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'numero secretaria de salud 1','','numero secretaria de salud 1'".'<br>';

//anios 1
$pdf->SetXY(80, 122.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'anios 1','','anios 1'".'<br>';

//meses 1
$pdf->SetXY(100, 122.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'meses 1','','meses 1'".'<br>';



//especialidad 2
$pdf->SetXY(8, 134.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'especialidad 2','','especialidad 2'".'<br>';

//institucion 2
$pdf->SetXY(8, 145);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'institucion 2','','institucion 2'".'<br>';

//numero cedula 2
$pdf->SetXY(8, 155);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'numero cedula 2','','numero cedula 2'".'<br>';

//numero secretaria de salud 2
$pdf->SetXY(140, 155);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'numero secretaria de salud 2','','numero secretaria de salud 2'".'<br>';

//anios 2
$pdf->SetXY(80, 160.4);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'anios 2','','anios 2'".'<br>';

//meses 2
$pdf->SetXY(100, 160.4);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'meses 2','','meses 2'".'<br>';



//especialidad 3
$pdf->SetXY(8, 172.4);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'especialidad 3','','especialidad 3'".'<br>';

//institucion 3
$pdf->SetXY(8, 182.3);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'institucion 3','','institucion 3'".'<br>';

//numero cedula 3
$pdf->SetXY(8, 192.2);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'numero cedula 3','','numero cedula 3'".'<br>';

//numero secretaria de salud 3
$pdf->SetXY(140, 192.2);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'numero secretaria de salud 3','','numero secretaria de salud 3'".'<br>';

//anios 3
$pdf->SetXY(80, 197.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'anios 3','','anios 3'".'<br>';

//meses 3
$pdf->SetXY(100, 197.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'meses 3','','meses 3'".'<br>';


//cuenta con consultorio
$pdf->SetXY(9.2, 205.5);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'cuenta con consultorio','','cuenta con consultorio'".'<br>';

//ejerce sus act en su consultorio
$pdf->SetXY(9.2, 209.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'ejerce sus act en su consultorio','','ejerce sus act en su consultorio'".'<br>';

//otros lugares de trabajo
$pdf->SetXY(63.2, 214.9);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'clinica','','otros lugares de trabajo'".'<br>';
//otros lugares de trabajo
$pdf->SetXY(77.7, 214.9);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'hospital','','otros lugares de trabajo'".'<br>';
//otros lugares de trabajo
$pdf->SetXY(95.7, 214.9);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'sanatorio','','otros lugares de trabajo'".'<br>';
//otros lugares de trabajo
$pdf->SetXY(115.4, 214.9);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'otro','','otros lugares de trabajo'".'<br>';
//otros lugares de trabajo
$pdf->SetXY(129.3, 214.9);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'indique otro','','otros lugares de trabajo'".'<br>';

//aparatos de radiologia
$pdf->SetXY(9.2, 219.6);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'aparatos de radiologia','','aparatos de radiologia'".'<br>';
//reclamos de rc
$pdf->SetXY(9.2, 224.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'reclamos de rc','','reclamos de rc'".'<br>';

//reclamos de rc describir
$pdf->SetXY(13.5, 234.7);
//$pdf->Write(0, "x");
echo "5,3,'caracteristicas del asegurado',".$pdf->GetX().",".$pdf->GetY().",'reclamos de rc describir','','reclamos de rc describir'".'<br>';



//------------------           fin pagina 3            ------------------------------------------------------


//------------------            pagina 4            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('solRC.pdf');
// import page 1
$tplIdx = $pdf->importPage(4);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


//suma asegurada
$pdf->SetXY(172.4, 32.5);
//$pdf->Write(0, "x");
echo "5,4,'coberturas',".$pdf->GetX().",".$pdf->GetY().",'suma asegurada','','suma asegurada'".'<br>';

//cobro bancario
$pdf->SetXY(34, 61);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'si','','cobro bancario'".'<br>';
//cobro bancario
$pdf->SetXY(34, 66.2);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'no','','cobro bancario'".'<br>';

//periodo pago mensual
$pdf->SetXY(72.2, 61);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo pago mensual','','periodo pago mensual'".'<br>';
//periodo pago trimestral
$pdf->SetXY(93.2, 61);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo pago trimestral','','periodo pago trimestral'".'<br>';
//periodo pago semestral
$pdf->SetXY(116.2, 61);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo pago semestral','','periodo pago semestral'".'<br>';
//periodo pago anual
$pdf->SetXY(139, 61);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo pago anual','','periodo pago anual'".'<br>';
//periodo pago unico
$pdf->SetXY(154.9, 61);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'periodo pago unico','','periodo pago unico'".'<br>';


//moneda nacional
$pdf->SetXY(72.2, 66.2);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'moneda nacional','','moneda nacional'".'<br>';
//moneda dolares
$pdf->SetXY(93.2, 66.2);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'moneda dolares','','moneda dolares'".'<br>';

//recibo individual
$pdf->SetXY(72.2, 71.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'recibo individual','','recibo individual'".'<br>';
//recibo global
$pdf->SetXY(93.2, 71.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'recibo global','','recibo global'".'<br>';
//recibo filial
$pdf->SetXY(148, 71.3);
//$pdf->Write(0, "x");
echo "5,4,'forma de pago',".$pdf->GetX().",".$pdf->GetY().",'recibo filial','','recibo filial'".'<br>';




//------------------           fin pagina 4            ------------------------------------------------------


//------------------            pagina 5            ------------------------------------------------------

// add a page
$pdf->AddPage();
// set the sourcefile
$pdf->setSourceFile('solRC.pdf');
// import page 1
$tplIdx = $pdf->importPage(5);
// use the imported page as the template
$pdf->useTemplate($tplIdx, 0, 0);


//lugar
$pdf->SetXY(8, 37.5);
//$pdf->Write(0, "x");
echo "5,5,'lugar',".$pdf->GetX().",".$pdf->GetY().",'lugar','','lugar'".'<br>';

//fecha
$pdf->SetXY(170, 37.5);
//$pdf->Write(0, "x");
echo "5,5,'lugar',".$pdf->GetX().",".$pdf->GetY().",'fecha','','fecha'".'<br>';

//nombre solicitante
$pdf->SetXY(19, 46.95);
//$pdf->Write(0, "x");
echo "5,5,'lugar',".$pdf->GetX().",".$pdf->GetY().",'nombre solicitante','','nombre solicitante'".'<br>';
//nombre contratante
$pdf->SetXY(121, 46.95);
//$pdf->Write(0, "x");
echo "5,5,'lugar',".$pdf->GetX().",".$pdf->GetY().",'nombre contratante','','nombre contratante'".'<br>';

//nombre solicitante consentimiento
$pdf->SetXY(19, 97.95);
//$pdf->Write(0, "x");
echo "5,5,'lugar',".$pdf->GetX().",".$pdf->GetY().",'nombre solicitante consentimiento','','nombre solicitante consentimiento'".'<br>';
//nombre contratante consentimiento
$pdf->SetXY(121, 97.95);
//$pdf->Write(0, "x");
echo "5,5,'lugar',".$pdf->GetX().",".$pdf->GetY().",'nombre contratante consentimiento','','nombre contratante consentimiento'".'<br>';


//clave
$pdf->SetXY(18.6, 176.5);
//$pdf->Write(0, "x");
echo "5,5,'clave',".$pdf->GetX().",".$pdf->GetY().",'clave','','clave'".'<br>';

//nombre asesor
$pdf->SetXY(47.6, 176.5);
//$pdf->Write(0, "x");
echo "5,5,'nombre asesor',".$pdf->GetX().",".$pdf->GetY().",'nombre asesor','','nombre asesor'".'<br>';

//participacion
$pdf->SetXY(29.3, 181.9);
//$pdf->Write(0, "x");
echo "5,5,'participacion',".$pdf->GetX().",".$pdf->GetY().",'participacion','','participacion'".'<br>';



//------------------           fin pagina 5            ------------------------------------------------------



//$pdf->Output('Vida500AC.pdf', 'I');





?>
