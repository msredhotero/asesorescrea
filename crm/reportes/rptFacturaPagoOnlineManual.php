<?php


date_default_timezone_set('America/Mexico_City');
/*
include ('../includes/funcionesUsuarios.php');
include ('../includes/funciones.php');
include ('../includes/funcionesHTML.php');
include ('../includes/funcionesReferencias.php');
include ('../includes/funcionesComercio.php');


$serviciosUsuarios  		= new ServiciosUsuarios();
$serviciosFunciones 		= new Servicios();
$serviciosHTML				= new ServiciosHTML();
$serviciosReferencias 			= new ServiciosReferencias();
$serviciosComercio      = new serviciosComercio();

$fecha = date('Y-m-d-H-i-s');
*/

require('fpdf.php');



//$token         =  $_GET['token'];

$resComercio = $serviciosComercio->traerComercioinicioPorToken($token);

if (mysql_num_rows($resComercio)>0) {
	$idCotizacion = mysql_result($resComercio,0,'comorderid');

	$resCotizaciones = $serviciosReferencias->traerCotizacionesPorIdCompleto($idCotizacion);

	$recibo = mysql_result($resComercio,0,'nrocomprobante');

	$cliente = mysql_result($resCotizaciones,0,'clientesolo');

	$fecha = mysql_result($resComercio,0,'fechamodi');

	$folio = mysql_result($resCotizaciones,0,'folio');

	$producto = mysql_result($resCotizaciones,0,'producto');

	$precio = mysql_result($resComercio,0,'comtotal') / 100;

	$pdf = new FPDF();

	//$pdfi = new FPDI();

	/* desarrollo   ****************************************/
	$directorio = $_SERVER['DOCUMENT_ROOT']."desarrollo/crm";
	//die(var_dump($directorio));

	/////////////////////////////////////// pagina 1 ///////////////////////////////////
	$pdf->AddPage();

	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);


	$pdf->SetXY(10, 10);
	$pdf->Write(0, "Grupo Foncerray y Javelly SA de CV");

	$pdf->SetFont('Arial','',9);

	$pdf->SetXY(10, 20);
	$pdf->Write(0, "Periferico Sur 4302, Oficina 212");
	$pdf->SetXY(10, 24);
	$pdf->Write(0, "Colonia Jardines del Pedregal");
	$pdf->SetXY(10, 28);
	$pdf->Write(0, "Código Postal 04500");
	$pdf->SetXY(10, 32);
	$pdf->Write(0, "(55) 5135.0259 - Email: consulta@asesorescrea.com");

	$pdf->SetFont('Arial','',12);
	$pdf->SetTextColor(0,0,0);


	$pdf->SetXY(82, 40);
	$pdf->Write(0, "COMPROBANTE DE PAGO");


	$pdf->SetFont('Arial','',9);

	$pdf->SetXY(10, 50);
	$pdf->Write(0, "CLIENTE: ".$cliente);

	$pdf->SetXY(80, 50);
	$pdf->Write(0, "FECHA: ".$fecha);


	$pdf->SetXY(130, 50);
	$pdf->Write(0, "FOLIO: ".$folio);


	$pdf->SetXY(10, 70);
	$pdf->Cell(20,10,'CANTIDAD',1,0,'C');
	$pdf->Cell(120,10,'PRODUCTO',1,0,'C');
	$pdf->Cell(40,10,'MONTO',1,0,'C');
	$pdf->Ln();
	$pdf->Cell(20,10,'1',1,0,'C');
	$pdf->Cell(120,10,$producto,1,0,'L');
	$pdf->Cell(40,10,'MX '.number_format($precio,2,'.',','),1,0,'R');

	$pdf->Ln();
	$pdf->Cell(20,10,'',1,0,'C');
	$pdf->Cell(120,10,'TOTAL: ',1,0,'R');
	$pdf->Cell(40,10,'MX '.number_format($precio,2,'.',','),1,0,'R');



	$pdf->Image(__DIR__.'/'.'../imagenes/AClogo.png' , 160 ,5, 40 , 0,'PNG');


	/************************** fin ********************************************************/

	if (!file_exists(__DIR__.'/'.'../archivos/pagosonline/'.$idCotizacion.'/')) {
		mkdir(__DIR__.'/'.'../archivos/pagosonline/'.$idCotizacion.'/', 0777);
	}

	$pdf->Output( __DIR__.'/'.'../archivos/pagosonline/'.$idCotizacion.'/ReciboPago.pdf', 'F');

} else {
	return false;

}



?>
