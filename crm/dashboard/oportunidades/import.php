<?php
include ('../../includes/funciones.php');
include ('../../includes/funcionesUsuarios.php');
include ('../../includes/funcionesHTML.php');
include ('../../includes/funcionesReferencias.php');
include ('../../includes/base.php');

$serviciosFunciones 	= new Servicios();
$serviciosUsuario 		= new ServiciosUsuarios();
$serviciosHTML 			= new ServiciosHTML();
$serviciosReferencias 	= new ServiciosReferencias();
$baseHTML = new BaseHTML();

$sql = '';

$archivo = $_FILES['name'];

array_map('unlink', glob("../../archivos/excel/*.*"));

$templocation = $archivo['tmp_name'];

$imagen_subida = '../../archivos/excel/Libro1.xlsx';

$i=0;
$error = 0;
if(isset($_FILES["name"])){

	//die(var_dump($_FILES["name"]));

	if (move_uploaded_file($templocation, $imagen_subida)) {
            /// leer el archivo excel

            require_once 'PHPExcel/Classes/PHPExcel.php';
            $archivo = "../../archivos/excel/Libro1.xlsx";
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
            for ($row = 2; $row <= $highestRow; $row++){
                $x_despacho 			= $sheet->getCell("A".$row)->getValue();
                $x_apellidopaterno 	= $sheet->getCell("B".$row)->getValue();
                $x_apellidomaterno 	= $sheet->getCell("C".$row)->getValue();
                $x_nombre 				= $sheet->getCell("D".$row)->getValue();
                $x_telefonomovil 	= $sheet->getCell("E".$row)->getValue();
                $x_telefonotrabajo 	= $sheet->getCell("F".$row)->getValue();
					 $x_email			 	= $sheet->getCell("G".$row)->getValue();
					 $x_usuario			 	= $sheet->getCell("H".$row)->getValue();

					 $resUsuario = $serviciosUsuario->traerUsuario($x_usuario);

					 if (mysql_num_rows($resUsuario) > 0) {
						$resOportunidad = $serviciosReferencias->insertarOportunidades($x_despacho,$x_apellidopaterno,$x_apellidomaterno,$x_nombre,$x_telefonomovil,$x_telefonotrabajo,$x_email,mysql_result($resUsuario,0,0),6,1, '',0,'',1,2);
						die(var_dump($resOportunidad));
						if ((integer)$resOportunidad>0) {
							$i += 1;
						}



					} else {
						$error += 1;
					}

               //$con->query($sql);
            }


	}
}
//die(var_dump($sql));
echo "<script>
alert('Correcto $i, Error $resOportunidad !!!');
window.location = './index.php';
</script>
";
?>
