<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
    if (usuarioPrivilegiado()->hasPrivilege('leerSolicitudTransporte')) :
      $user_id = $_SESSION['user_id'];
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">

            <script src="../herramientas/transporte/js/list.js"></script>
            <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>

            <script src="../herramientas/assets/js/plugins/jspdf/pdfFromHTML.js"></script>



        </head>
        <body >

            <div class="block block-themed block-rounded">
              <div class=" block-header bg-muted ">

                <h3 class="block-title">Mis Solicitudes</h3>
              </div>
              <div id="t_p_solicitudes" class="block-content">
              </div>


            </div>






        </body>


        </html>
        <script>
        $(document).ready(function(){
          get_solicitudes_list_perfil(<?php echo $user_id ?>);
        });
        </script>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
  echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
