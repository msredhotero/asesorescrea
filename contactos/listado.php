<?php


include ('../crm/includes/funciones.php');

include ('../crm/includes/funcionesHTML.php');
include ('../crm/includes/funcionesContactos.php');

$serviciosFunciones 	= new Servicios();

$serviciosHTML 			= new ServiciosHTML();
$serviciosContactos 	= new ServiciosContactos();

$resultado = $serviciosContactos->Resultados();

if (mysql_num_rows($resultado)>0) {
   $cantSI = mysql_result($resultado,0,0) == '' ? 0 : mysql_result($resultado,0,0);
   $cantMI = mysql_result($resultado,0,1) == '' ? 0 : mysql_result($resultado,0,1);
   $cantNO = mysql_result($resultado,0,2) == '' ? 0 : mysql_result($resultado,0,2);
} else {
   $cantSI = 0;
   $cantMI = 0;
   $cantNO = 0;
}

$lstContactos = $serviciosContactos->traerContactosCompleto();


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Acceder | ASESORES CREA</title>
    <!-- Favicon-->
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../crm/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../crm/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../crm/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Sweetalert Css -->
    <link href="../crm/plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../crm/css/style.css" rel="stylesheet">

    <link href="../crm/plugins/morrisjs/morris.css" rel="stylesheet" />

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

    <link href="../crm/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css" rel="stylesheet">


	<link rel="stylesheet" href="../crm/DataTables/DataTables-1.10.18/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="../crm/DataTables/DataTables-1.10.18/css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="../crm/DataTables/DataTables-1.10.18/css/dataTables.jqueryui.min.css">
	<link rel="stylesheet" href="../crm/DataTables/DataTables-1.10.18/css/jquery.dataTables.css">

</head>

<body class="login-page" style="max-width: 66% !important;">
   <div class="row clearfix">
      <div class="row">
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card ">
               <div class="header bg-blue">
                  <h2>
                     RESULTADOS ASESORES CREA
                  </h2>
                  <ul class="header-dropdown m-r--5">
                     <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                           <i class="material-icons">more_vert</i>
                        </a>
                        <ul class="dropdown-menu pull-right">
                           <li><a href="index.php">VOLVER</a></li>
                        </ul>
                     </li>
                  </ul>

               </div>
               <div class="body table-responsive">
                  <div class="row">
                     <div id="donut-example"></div>
                  </div>
                  <div class="row">
                     <table id="example" class="table table-striped">
                        <thead>
                           <th>Nombre</th>
                           <th>Apellido</th>
                           <th>Agencia</th>
                           <th>Respuesta</th>
                           <th>Observaciones</th>
                           <th>Objeto de Interes</th>
                        </thead>
                        <tbody>
                           <?php while ($row = mysql_fetch_array($lstContactos)) { ?>
                           <tr>
                              <td><?php echo $row['nombre']; ?></td>
                              <td><?php echo $row['apellido']; ?></td>
                              <td><?php echo $row['nombreagencia']; ?></td>
                              <td><?php echo $row['respuesta']; ?></td>
                              <td><?php echo $row['observaciones']; ?></td>
                              <td><?php echo $row['producto']; ?></td>
                           </tr>
                        <?php } ?>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div> <!-- fin del container entrevistas -->

    <!-- Jquery Core Js -->
    <script src="../crm/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../crm/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../crm/plugins/node-waves/waves.js"></script>


    <!-- Custom Js -->


    <!-- SweetAlert Plugin Js -->
    <script src="../crm/plugins/sweetalert/sweetalert.min.js"></script>

    <script src="../crm/js/pages/ui/dialogs.js"></script>

    <!-- Morris Plugin Js -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <script src="../crm/DataTables/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>


    <script type="text/javascript">

        $(document).ready(function(){
           Morris.Donut({
              element: 'donut-example',
              data: [
                {label: "Si me interesa", value: <?php echo $cantSI; ?>},
                {label: "Me gustaria recibir mas informacion", value: <?php echo $cantMI; ?>},
                {label: "No me interesa", value: <?php echo $cantNO; ?>}
              ]
            });

            $('#example').DataTable({
               "language": {
      				"emptyTable":     "No hay datos cargados",
      				"info":           "Mostrar _START_ hasta _END_ del total de _TOTAL_ filas",
      				"infoEmpty":      "Mostrar 0 hasta 0 del total de 0 filas",
      				"infoFiltered":   "(filtrados del total de _MAX_ filas)",
      				"infoPostFix":    "",
      				"thousands":      ",",
      				"lengthMenu":     "Mostrar _MENU_ filas",
      				"loadingRecords": "Cargando...",
      				"processing":     "Procesando...",
      				"search":         "Buscar:",
      				"zeroRecords":    "No se encontraron resultados",
      				"paginate": {
      					"first":      "Primero",
      					"last":       "Ultimo",
      					"next":       "Siguiente",
      					"previous":   "Anterior"
      				},
      				"aria": {
      					"sortAscending":  ": activate to sort column ascending",
      					"sortDescending": ": activate to sort column descending"
      				}
               }
            });
        });/* fin del document ready */

    </script>
</body>

</html>
