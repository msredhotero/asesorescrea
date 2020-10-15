
/////////////////////////////////////// pagina 2 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 148.5;

$pdf->Image(__DIR__.'/'.'F20926-2.jpg' , 0 ,0, 210 , 0,'JPG');

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

$pdf->Image(__DIR__.'/'.'F20926-3.jpg' , 0 ,0, 210 , 0,'JPG');


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

$pdf->Image(__DIR__.'/'.'F20926-4.jpg' , 0 ,0, 210 , 0,'JPG');

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



//domicilio
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//edificio
$pdf->SetXY(136, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro ext
$pdf->SetXY(156, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//nro int
$pdf->SetXY(169, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//cod postal
$pdf->SetXY(183, $yConstCuadrado1 + ($yCuadrado1 * 21) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,5));

//colonia
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 22) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//delegacion
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 22) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//ciudad
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 23) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//estado
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 23) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));


//apellido paterno
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 24) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//apellido materno
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 24) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//primer nombre
$pdf->SetXY(13, $yConstCuadrado1 + ($yCuadrado1 * 25) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//segundo nombre
$pdf->SetXY(106, $yConstCuadrado1 + ($yCuadrado1 * 25) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//porcentaje (simpre 100%)
$pdf->SetXY(26, $yConstCuadrado1 + ($yCuadrado1 * 26) );
$pdf->Write(0, substr("100",0,3));

//rebocable
$pdf->SetXY(75, $yConstCuadrado1 + ($yCuadrado1 * 26) -1 );
$pdf->Write(0, substr("x",0,1));

//irrebocable (nunca se eligira)
//$pdf->SetXY(26, $yConstCuadrado1 + ($yCuadrado1 * 26) );
//$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,3));

//genero (masculino)
$pdf->SetXY(16, $yConstCuadrado1 + ($yCuadrado1 * 27) );
$pdf->Write(0, substr("x",0,1));

//genero (femenino)
$pdf->SetXY(25.5, $yConstCuadrado1 + ($yCuadrado1 * 27) );
$pdf->Write(0, substr("x",0,1));

//fecha nacimiento
$pdf->SetXY(40, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5 );
$pdf->Write(0, substr("20/05/2020",0,10));

//parentesco
$pdf->SetXY(65, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,25));

//nacionalidad
$pdf->SetXY(115, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5);
$pdf->Write(0, substr("MEXICANA",0,25));

//pais de nacimiento
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 27) + 0.5 );
$pdf->Write(0, substr("MEXICO",0,25));

/////////////////////////////////////// pagina 5 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 3.8;
$yConstCuadrado1 = 51.7;

$pdf->Image(__DIR__.'/'.'F20926-5.jpg' , 0 ,0, 210 , 0,'JPG');

//padece alguna enfermedad (si)
$pdf->SetXY(140, $yConstCuadrado1 );
$pdf->Write(0, substr("x",0,1));

//padece alguna enfermedad (no)
$pdf->SetXY(145, $yConstCuadrado1 );
$pdf->Write(0, substr("x",0,1));

//esta sujeto a tratamiento medico (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("x",0,1));

//esta sujeto a tratamiento medico (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 1));
$pdf->Write(0, substr("x",0,1));

//tiene pruebas de laboratorio pendientes (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("x",0,1));

//tiene pruebas de laboratorio pendientes (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 2));
$pdf->Write(0, substr("x",0,1));

//le practicaron o tiene pendiente cirugia (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
$pdf->Write(0, substr("x",0,1));

//le practicaron o tiene pendiente cirugia (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 3) + 0.8);
$pdf->Write(0, substr("x",0,1));

//ha estado bajo tratamiento por alguna adicion (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 4) + 0.8);
$pdf->Write(0, substr("x",0,1));

//ha estado bajo tratamiento por alguna adicion (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 4) + 0.8);
$pdf->Write(0, substr("x",0,1));

/********************************************************/
//tumores o neoplacias (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 9) );
$pdf->Write(0, substr("x",0,1));

//tumores o neoplacias (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 9) );
$pdf->Write(0, substr("x",0,1));


//del sistema circulatorio (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
$pdf->Write(0, substr("x",0,1));

//del sistema circulatorio (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 10) + 1.5);
$pdf->Write(0, substr("x",0,1));


//del sistema endocrino (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 11) + 3.5);
$pdf->Write(0, substr("x",0,1));

//del sistema endocrino (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 11) + 3.5);
$pdf->Write(0, substr("x",0,1));


//congenitas y/o marformaciones de nacimiento (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4.5);
$pdf->Write(0, substr("x",0,1));

//congenitas y/o marformaciones de nacimiento (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 12) + 4.5);
$pdf->Write(0, substr("x",0,1));


//del sistema hematopoyetico e inmune (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 13) + 5);
$pdf->Write(0, substr("x",0,1));

//del sistema hematopoyetico e inmune (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 13) + 5);
$pdf->Write(0, substr("x",0,1));


//infeccionsas (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 14) + 5.6);
$pdf->Write(0, substr("x",0,1));

//infeccionsas (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 14) + 5.6);
$pdf->Write(0, substr("x",0,1));


//del sistema nervioso (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 15) + 5.6);
$pdf->Write(0, substr("x",0,1));

//del sistema nervioso (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 15) + 5.6);
$pdf->Write(0, substr("x",0,1));


//del sistema respiratorio (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 17) + 5.5);
$pdf->Write(0, substr("x",0,1));

//del sistema respiratorio (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 17) + 5.5);
$pdf->Write(0, substr("x",0,1));


//del sistema digestivo (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 18) + 7.5);
$pdf->Write(0, substr("x",0,1));

//del sistema digestivo (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 18) + 7.5);
$pdf->Write(0, substr("x",0,1));


//hernias (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 19) + 8.2 );
$pdf->Write(0, substr("x",0,1));

//hernias (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 19)+ 8.2 );
$pdf->Write(0, substr("x",0,1));


//del sistema genitourinario (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 20) + 8.7);
$pdf->Write(0, substr("x",0,1));

//del sistema genitourinario (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 20) + 8.7 );
$pdf->Write(0, substr("x",0,1));


//del sistema osteomuscular (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 21) + 8.9 );
$pdf->Write(0, substr("x",0,1));

//del sistema osteomuscular (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 21) + 8.9 );
$pdf->Write(0, substr("x",0,1));


//del ojo (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 22) + 8.7 );
$pdf->Write(0, substr("x",0,1));

//del ojo (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 22) + 8.7 );
$pdf->Write(0, substr("x",0,1));


//del oido (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 23) + 9.8 );
$pdf->Write(0, substr("x",0,1));

//del oido (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 23) + 9.8 );
$pdf->Write(0, substr("x",0,1));


//ha sufrido algun accidente que ameritara tratamiento intrahospitalario (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 24) + 9.7 );
$pdf->Write(0, substr("x",0,1));

//ha sufrido algun accidente que ameritara tratamiento intrahospitalario (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 24) + 9.7 );
$pdf->Write(0, substr("x",0,1));


//practica algun deporte peligroso (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 25) + 10.4 );
$pdf->Write(0, substr("x",0,1));

//practica algun deporte peligroso (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 25) + 10.4 );
$pdf->Write(0, substr("x",0,1));


//utiliza algun tipo de protesis o ha perdido algun mienbro (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 26) + 11.6 );
$pdf->Write(0, substr("x",0,1));

//utiliza algun tipo de protesis o ha perdido algun mienbro (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 26) + 11.6 );
$pdf->Write(0, substr("x",0,1));


//otras enfermedades diferentes a las señaladas anteriormente (si)
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 27) + 11.6 );
$pdf->Write(0, substr("x",0,1));

//otras enfermedades diferentes a las señaladas anteriormente (no)
$pdf->SetXY(145, $yConstCuadrado1 + ($yCuadrado1 * 27) + 11.6 );
$pdf->Write(0, substr("x",0,1));


/////////////////////////////////////// pagina 6 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 126;

$pdf->Image(__DIR__.'/'.'F20926-6.jpg' , 0 ,0, 210 , 0,'JPG');

//peso
$pdf->SetXY(27, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("999",0,3));

//altura
$pdf->SetXY(39, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("999",0,3));

//fuma (si)
$pdf->SetXY(52, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7 );
$pdf->Write(0, substr("x",0,1));

//fuma (no)
$pdf->SetXY(60, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7);
$pdf->Write(0, substr("x",0,1));

//desde que año
$pdf->SetXY(69, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.2 );
$pdf->Write(0, substr("9999",0,4));

//cantidad
$pdf->SetXY(89, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("999",0,3));

//dia
$pdf->SetXY(100, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("x",0,1));

//mes
$pdf->SetXY(106.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("x",0,1));

//anio
$pdf->SetXY(112, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("x",0,1));


//toma alcohol (si)
$pdf->SetXY(125, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7 );
$pdf->Write(0, substr("x",0,1));

//toma alcohol (no)
$pdf->SetXY(131.5, $yConstCuadrado1 + ($yCuadrado1 * 0) - 0.7);
$pdf->Write(0, substr("x",0,1));

//desde que año
$pdf->SetXY(140, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("9999",0,4));


//cantidad
$pdf->SetXY(163, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.4 );
$pdf->Write(0, substr("999",0,3));

//dia
$pdf->SetXY(175.5, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("x",0,1));

//mes
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("x",0,1));

//anio
$pdf->SetXY(187.6, $yConstCuadrado1 + ($yCuadrado1 * 0) + 0.8 );
$pdf->Write(0, substr("x",0,1));

/////////////////////////////////////// pagina 7 ///////////////////////////////////
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 8;
$yConstCuadrado1 = 112;

$pdf->Image(__DIR__.'/'.'F20926-7.jpg' , 0 ,0, 210 , 0,'JPG');

//lugar y fecha de solicitud
$pdf->SetXY(43, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//fecha
$pdf->SetXY(165, $yConstCuadrado1 + ($yCuadrado1 * 0) );
$pdf->Write(0, substr("20/05/2020",0,10));

//observaciones 1
$pdf->SetXY(12, $yConstCuadrado1 + ($yCuadrado1 * 5) + 6 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//observaciones 2
$pdf->SetXY(12, $yConstCuadrado1 + ($yCuadrado1 * 6) + 4 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//se realizo la visita al cliente (si)
$pdf->SetXY(59.4, $yConstCuadrado1 + ($yCuadrado1 * 7) + 2.2 );
$pdf->Write(0, substr("x",0,1));

//se realizo la visita al cliente (no)
$pdf->SetXY(69, $yConstCuadrado1 + ($yCuadrado1 * 7)+ 2.2 );
$pdf->Write(0, substr("x",0,1));

//resultado de la visita
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 7)+ 2.8 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,40));

//clave del agente
$pdf->SetXY(12, $yConstCuadrado1 + ($yCuadrado1 * 10) - 2.5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));

//nombre
$pdf->SetXY(50, $yConstCuadrado1 + ($yCuadrado1 * 10) - 2.5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,12));

// % comision cedida
$pdf->SetXY(150, $yConstCuadrado1 + ($yCuadrado1 * 10) - 2.5 );
$pdf->Write(0, substr("100",0,3));


/************************** fin ********************************************************/



///********************* pagina 1 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image(__DIR__.'/'.'FVRIM-1.png' , 0 ,0, 210 , 0,'PNG');

//fecha de solicitud
$pdf->SetXY(144, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("20/05/1985",0,20));

//folio VI
$pdf->SetXY(179, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//tipo de tarjeta
$pdf->SetXY(62, $yConstCuadrado1 + ($yCuadrado1 * 6) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//cantidad
$pdf->SetXY(112.5, $yConstCuadrado1 + ($yCuadrado1 * 6) + 3);
$pdf->Write(0, substr("1",0,1));

//importe
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 6) + 3);
$pdf->Write(0, substr("MX 9.999,99",0,12));

//importe
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 10) + 3);
$pdf->Write(0, substr("MX 9.999,99",0,12));


//dia
$pdf->SetXY(103, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("31",0,2));
//mes
$pdf->SetXY(122, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("Septiembre",0,15));
//anio
$pdf->SetXY(156, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("2020",0,4));

//clave del asesor
$pdf->SetXY(93, $yConstCuadrado1 + ($yCuadrado1 * 24));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

/************************** fin ********************************************************/
///********************* pagina 2 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 180;

$pdf->Image(__DIR__.'/'.'FVRIM-2.png' , 0 ,0, 210 , 0,'PNG');

//dia
$pdf->SetXY(113, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("31",0,2));
//mes
$pdf->SetXY(121, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("Septiembre",0,15));
//anio
$pdf->SetXY(143, $yConstCuadrado1 + ($yCuadrado1 * 14) + 4);
$pdf->Write(0, substr("2020",0,4));

//autorizo a enviarme informacion (si)
$pdf->SetXY(170, $yConstCuadrado1 + ($yCuadrado1 * 14) - 0.5);
$pdf->Write(0, substr("X",0,1));
//autorizo a enviarme informacion (no)
$pdf->SetXY(180, $yConstCuadrado1 + ($yCuadrado1 * 14) - 0.5);
$pdf->Write(0, substr("X",0,1));

/************************** fin ********************************************************/
///********************* pagina 3 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 42;

$pdf->Image(__DIR__.'/'.'FVRIM-3.png' , 0 ,0, 210 , 0,'PNG');

//fecha de solicitud
$pdf->SetXY(144, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("20/05/1985",0,20));

//folio VI
$pdf->SetXY(179, $yConstCuadrado1 + ($yCuadrado1 * 0));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//cliente inbursa
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 2) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,10));

//rfc
$pdf->SetXY(45, $yConstCuadrado1 + ($yCuadrado1 * 2) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,13));

//persona fisica
$pdf->SetXY(184.6, $yConstCuadrado1 + ($yCuadrado1 * 2) - 1.5 );
$pdf->Write(0, substr("x",0,1));

//persona moral
$pdf->SetXY(184.6, $yConstCuadrado1 + ($yCuadrado1 * 2) + 2.5);
$pdf->Write(0, substr("x",0,1));

//denominacion o razon social
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 4) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//primer nombre
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 5) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 5) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido paterno
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 7) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 7) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//fecha nacimiento
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 10) );
$pdf->Write(0, substr("20/05/1985",0,10));

//genero femenino
$pdf->SetXY(60.3, $yConstCuadrado1 + ($yCuadrado1 * 10) - 4 );
$pdf->Write(0, substr("x",0,1));

//genero masculino
$pdf->SetXY(60.3, $yConstCuadrado1 + ($yCuadrado1 * 10) );
$pdf->Write(0, substr("x",0,1));

//estado civil casado
$pdf->SetXY(97.3, $yConstCuadrado1 + ($yCuadrado1 * 10) - 4 );
$pdf->Write(0, substr("x",0,1));

//estado civil soltero
$pdf->SetXY(97.3, $yConstCuadrado1 + ($yCuadrado1 * 10) );
$pdf->Write(0, substr("x",0,1));

//calle
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//num exterior
$pdf->SetXY(92, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//edificio
$pdf->SetXY(119, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//num interior
$pdf->SetXY(157, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//cp
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 12) + 2.5);
$pdf->Write(0, substr("12345",0,5));

//colonia
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 14)+ 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//munucipio
$pdf->SetXY(112, $yConstCuadrado1 + ($yCuadrado1 * 14) + 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//ciudad
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 15) + 4);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//entidad federativa
$pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 15) + 4 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//pais
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 15) + 4 );
$pdf->Write(0, substr("MEXICO",0,20));

//TELEFONO FIJO
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 17) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//TELEFONO celular
$pdf->SetXY(87, $yConstCuadrado1 + ($yCuadrado1 * 17) + 3);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

//email
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 19) );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,100));

//calle
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//num exterior
$pdf->SetXY(92, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//edificio
$pdf->SetXY(119, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//num interior
$pdf->SetXY(157, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//cp
$pdf->SetXY(182, $yConstCuadrado1 + ($yCuadrado1 * 21) + 3.5);
$pdf->Write(0, substr("12345",0,5));

//colonia
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 23)+ 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//munucipio
$pdf->SetXY(112, $yConstCuadrado1 + ($yCuadrado1 * 23) + 2);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//ciudad
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 24) + 5);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//entidad federativa
$pdf->SetXY(90, $yConstCuadrado1 + ($yCuadrado1 * 24) + 5 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,30));

//pais
$pdf->SetXY(160, $yConstCuadrado1 + ($yCuadrado1 * 24) + 5 );
$pdf->Write(0, substr("MEXICO",0,20));

//primer nombre
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 30) );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//segundo nombre
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 30));
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido paterno
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 32) - 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//apellido materno
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 32) - 1);
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,60));

//fecha nacimiento
$pdf->SetXY(9, $yConstCuadrado1 + ($yCuadrado1 * 34) - 3 );
$pdf->Write(0, substr("20/05/1985",0,10));

//parentesco
$pdf->SetXY(110, $yConstCuadrado1 + ($yCuadrado1 * 34) - 3 );
$pdf->Write(0, substr("SAUPUREIN SAFAR MARCOS DANIEL",0,15));

/************************** fin ********************************************************/
///********************* pagina 4 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image(__DIR__.'/'.'FVRIM-4.png' , 0 ,0, 210 , 0,'PNG');


/************************** fin ********************************************************/
///********************* pagina 5 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image(__DIR__.'/'.'FVRIM-5.png' , 0 ,0, 210 , 0,'PNG');



/************************** fin ********************************************************/
///********************* pagina 6 **********************************************/
$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image(__DIR__.'/'.'FVRIM-6.png' , 0 ,0, 210 , 0,'PNG');



/************************** fin ********************************************************/
///********************* pagina 7 **********************************************/

$pdf->AddPage();

$pdf->SetFont('Arial','',8);
$pdf->SetTextColor(0,0,0);

$yCuadrado1 = 5;
$yConstCuadrado1 = 20;

$pdf->Image(__DIR__.'/'.'FVRIM-7.png' , 0 ,0, 210 , 0,'PNG');



/************************** fin ********************************************************/
