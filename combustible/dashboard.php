<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
      include_once 'php/funciones.php';
      /*$fechm= $_POST['mm'];
      $fechm2= $_POST['mm2'];
      $fecha= $_POST['yy'];
      $cupones = cupones_utilizados_mes($fechm,$fechm2,$fecha);*/

        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title> Reporte de Cupones Mensual</title>
            <script src="combustible/js/funciones_reporte.js"></script>
            <style>
            
            </style>
        </head>
        <body >

        </body>
        </html>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        //echo include(unauthorized());
    endif;
else:
  //echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
