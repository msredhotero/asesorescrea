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

$pdf->SetMargins(0,0,0);

//$pdfi = new FPDI();

/* desarrollo   ****************************************/
$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";

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

//folio VI
$pdf->SetXY(184, 43.9);
//$pdf->Write(0, "SAUPUREIN");
echo "4,1,'folio VI',".$pdf->GetX().",".$pdf->GetY().",'folio VI','','folio VI'".'<br>';

//id cliente
$pdf->SetXY(7, 58.8);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'id cliente','','id cliente'".'<br>';
//rfc
$pdf->SetXY(45, 58.8);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'rfc','','rfc'".'<br>';
//tipo persona moral
$pdf->SetXY(190, 54.4);
//$pdf->Write(0, "x");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'tipo persona','','moral'".'<br>';
//tipo persona fisica
$pdf->SetXY(190, 58);
//$pdf->Write(0, "x");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'tipo persona','','fisica'".'<br>';

//razon social
$pdf->SetXY(7, 66.6);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'razon social','','razon social'".'<br>';

//primer nombre
$pdf->SetXY(7, 77);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';

//segundo nombre
$pdf->SetXY(111.8, 77);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';

//apellido paterno
$pdf->SetXY(7, 87);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';

//apellido materno
$pdf->SetXY(111.8, 87);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'datos generales del solicitante',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//fecha nacimiento
$pdf->SetXY(7, 102);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';

//genero femenino
$pdf->SetXY(61, 96.5);
//$pdf->Write(0, "x");
echo "4,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'genero','','femenino'".'<br>';
//genero masculino
$pdf->SetXY(61, 100.5);
//$pdf->Write(0, "x");
echo "4,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'genero','','masculino'".'<br>';

//estado civil
$pdf->SetXY(99.5, 96.5);
//$pdf->Write(0, "x");
echo "4,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','casado'".'<br>';
//estado civil
$pdf->SetXY(99.5, 100.5);
//$pdf->Write(0, "x");
echo "4,1,'generales',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','soltero'".'<br>';

//calle
$pdf->SetXY(7, 117.2);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'calle','','calle'".'<br>';
//num exterior
$pdf->SetXY(97.3, 117.2);
//$pdf->Write(0, "SAUPUR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'num exterior','','num exterior'".'<br>';
//edificio
$pdf->SetXY(123.6, 117.2);
//$pdf->Write(0, "SAUPURE");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'edificio','','edificio'".'<br>';
//num interior
$pdf->SetXY(163.4, 117.2);
//$pdf->Write(0, "SAUPUR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'num interior','','num interior'".'<br>';
//cp
$pdf->SetXY(189.4, 117.2);
//$pdf->Write(0, "SAUPUR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'cp','','cp'".'<br>';

//colonia
$pdf->SetXY(7, 127.9);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'colonia','','colonia'".'<br>';
//municipio
$pdf->SetXY(116.4, 127.9);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'municipio','','municipio'".'<br>';

//ciudad
$pdf->SetXY(7, 137);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'ciudad','','ciudad'".'<br>';
//entidad federativa
$pdf->SetXY(92.4, 137);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'entidad federativa','','entidad federativa'".'<br>';
//pais
$pdf->SetXY(166.4, 137);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'domicilio',".$pdf->GetX().",".$pdf->GetY().",'pais','','pais'".'<br>';

//telefono fijo
$pdf->SetXY(7, 153.8);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'contacto',".$pdf->GetX().",".$pdf->GetY().",'telefono fijo','','telefono fijo'".'<br>';
//telefono movil
$pdf->SetXY(89.4, 153.8);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'contacto',".$pdf->GetX().",".$pdf->GetY().",'telefono movil','','telefono movil'".'<br>';
//compañia celular
$pdf->SetXY(169.4, 153.8);
//$pdf->Write(0, "SAUPUREIN");
echo "4,1,'contacto',".$pdf->GetX().",".$pdf->GetY().",'compañia celular','','compañia celular'".'<br>';

//email
$pdf->SetXY(7, 164);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'contacto',".$pdf->GetX().",".$pdf->GetY().",'email','','email'".'<br>';



//titular adquire - si
$pdf->SetXY(39.4, 210);
//$pdf->Write(0, "x");
echo "4,1,'informacion tarjeta',".$pdf->GetX().",".$pdf->GetY().",'titular adquire','','si'".'<br>';
//titular adquire - no
$pdf->SetXY(39.4, 214);
//$pdf->Write(0, "x");
echo "4,1,'informacion tarjeta',".$pdf->GetX().",".$pdf->GetY().",'titular adquire','','no'".'<br>';

//tipo tarjeta
$pdf->SetXY(55.4, 214);
//$pdf->Write(0, "SAUPUREIN SAFAR2");
echo "4,1,'informacion tarjeta',".$pdf->GetX().",".$pdf->GetY().",'tipo tarjeta','','tipo tarjeta'".'<br>';
//codigo de producto
$pdf->SetXY(111.4, 214);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'informacion tarjeta',".$pdf->GetX().",".$pdf->GetY().",'codigo de producto','','codigo de producto'".'<br>';


//primer nombre
$pdf->SetXY(7, 230);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';

//segundo nombre
$pdf->SetXY(114.4, 230);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';

//apellido paterno
$pdf->SetXY(7, 240);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';

//apellido materno
$pdf->SetXY(114.4, 240);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//fecha nacimiento
$pdf->SetXY(7, 250);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';

//parentesco
$pdf->SetXY(114.4, 250);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,1,'beneficiario',".$pdf->GetX().",".$pdf->GetY().",'parentesco','','parentesco'".'<br>';

///********************* fin pagina 1 **********************************************/


///********************* pagina 2 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-2.png' , 0 ,0, 210 , 0,'PNG');


//primer nombre
$pdf->SetXY(5, 29);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'primer nombre','','primer nombre'".'<br>';

//segundo nombre
$pdf->SetXY(110.4, 29);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'segundo nombre','','segundo nombre'".'<br>';

//apellido paterno
$pdf->SetXY(5, 39);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'apellido paterno','','apellido paterno'".'<br>';

//apellido materno
$pdf->SetXY(110.4, 39);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'apellido materno','','apellido materno'".'<br>';

//fecha nacimiento
$pdf->SetXY(5, 51);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'fecha nacimiento','','fecha nacimiento'".'<br>';

//genero femenino
$pdf->SetXY(58.3, 46);
//$pdf->Write(0, "x");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'genero','','femenino'".'<br>';

//genero masculino
$pdf->SetXY(58.3, 50);
//$pdf->Write(0, "x");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'genero','','masculino'".'<br>';

//estado civil 
$pdf->SetXY(96.4, 46);
//$pdf->Write(0, "x");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','casado'".'<br>';

//estado civil
$pdf->SetXY(96.4, 50);
//$pdf->Write(0, "x");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'estado civil','','soltero'".'<br>';

//tipo tarjeta
$pdf->SetXY(120.4, 50);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'tipo tarjeta','','tipo tarjeta'".'<br>';

//codigo producto
$pdf->SetXY(175.4, 50);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'codigo producto','','codigo producto'".'<br>';

//email
$pdf->SetXY(5, 61);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,2,'tarjetahabientes 1',".$pdf->GetX().",".$pdf->GetY().",'email','','email'".'<br>';

///********************* fin pagina 2 **********************************************/


///********************* pagina 3 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image('SolicitudAfiliacionVrim-3.png' , 0 ,0, 210 , 0,'PNG');

//tipo emision
$pdf->SetXY(29, 24);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'tipo emision','','express'".'<br>';

//tipo emision
$pdf->SetXY(29, 28.5);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'tipo emision','','ordinaria'".'<br>';


//requiere factura
$pdf->SetXY(29, 32.7);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'requiere factura','','si'".'<br>';

//requiere factura
$pdf->SetXY(29, 37.2);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'requiere factura','','no'".'<br>';

//tipo de pago
$pdf->SetXY(50.5, 28.5);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'tipo de pago','','credito'".'<br>';

//tipo de pago
$pdf->SetXY(50.5, 32.7);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'tipo de pago','','contado'".'<br>';

//forma de pago
$pdf->SetXY(73, 28.5);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'forma de pago','','cheque'".'<br>';

//forma de pago
$pdf->SetXY(73, 33);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'forma de pago','','transferencia'".'<br>';

//forma de pago
$pdf->SetXY(73, 37.5);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'forma de pago','','deposito'".'<br>';

//forma de pago
$pdf->SetXY(73, 42.5);
//$pdf->Write(0, "x");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'forma de pago','','tarjeta credito'".'<br>';

//banco
$pdf->SetXY(141.4, 28.5);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'banco','','banco'".'<br>';

//nro autorizacion
$pdf->SetXY(141.4, 37.4);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'nro autorizacion','','nro autorizacion'".'<br>';

//nro convenio
$pdf->SetXY(25, 50);
//$pdf->Write(0, "SAUPUREIN ");
echo "4,3,'condiciones de venta',".$pdf->GetX().",".$pdf->GetY().",'nro convenio','','nro convenio'".'<br>';

//'emisor sucursal venta
$pdf->SetXY(7, 67);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'emisor sucursal venta','','emisor sucursal venta'".'<br>';

//emisor sucursal entrega
$pdf->SetXY(7, 78);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'emisor sucursal entrega','','emisor sucursal entrega'".'<br>';

//ac inbursa
$pdf->SetXY(112.4, 63);
//$pdf->Write(0, "x");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'ac inbursa','','ac inbursa'".'<br>';

//ac vrim
$pdf->SetXY(141.4, 63);
//$pdf->Write(0, "x");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'ac vrim','','ac vrim'".'<br>';


//clave asesor
$pdf->SetXY(112.4, 75.5);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'clave asesor','','clave asesor'".'<br>';

//tipo tarjeta
$pdf->SetXY(7, 99.5);
//$pdf->Write(0, "SAUPUREIN ");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'tipo tarjeta','','tipo tarjeta'".'<br>';

//codigo producto
$pdf->SetXY(48.4, 99.5);
//$pdf->Write(0, "SAUPUREIN ");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'codigo producto','','codigo producto'".'<br>';

//cantidad
$pdf->SetXY(64.4, 99.5);
//$pdf->Write(0, "SAUPUREIN ");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'cantidad','','cantidad'".'<br>';

//importe
$pdf->SetXY(82.4, 99.5);
//$pdf->Write(0, "SAUPUREIN ");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'importe','','importe'".'<br>';

//sub total
$pdf->SetXY(117.4, 99.5);
//$pdf->Write(0, "SAUPUREIN ");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",'sub total','','sub total'".'<br>';

// total
$pdf->SetXY(117.4, 122.5);
//$pdf->Write(0, "SAUPUREIN SAFAR");
echo "4,3,'datos de venta',".$pdf->GetX().",".$pdf->GetY().",' total','','su total'".'<br>';


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





?>
