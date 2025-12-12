<?php
if (function_exists('login_check') && login_check() == true):
    if (isset($u) && $u->hasPrivilege('leerSolicitudTransporte')):
      $user_id = $_SESSION['user_id'];
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">

            <script src="transporte/js/list.js"></script>
            <script src="transporte/js/ver_solicitud.js"></script>


            <script src="transporte/js/notificaciones_solicitudes.js"></script>



        </head>
        <body >
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="col-sm-7">
                      <h1 class="page-heading">
                          CONTROL DE TRANSPORTE
                      </h1>
                  </div>

              </div>
          </div>
          <div class="content content-boxed">
            <div class="block block-themed block-rounded">
              <div class=" block-header bg-muted ">
                <ul class="block-options">
				<?php if ($u->hasPrivilege('autorizarSolicitudTransporte') ) :?>
                  <li>
                    <span id="ns" class=" label-danger-count1 contar"></span>
                    <button type="button"><i class="fa fa-bell"></i></button>
                  </li>
                  <!--<li>
                      <button type="button" title="comisiones" data-toggle="modal" data-target="#modal-remoto-lgg" href="transporte/calendario_comisiones.php"><i class="fa fa-calendar-check-o"></i></button>
                  </li>-->
                  <li>
                      <button type="button" data-toggle="modal" data-target="#modal-remoto-lgg" href="transporte/solicitar_transporte_manual.php" ><i class="fa fa-plus"></i></button>
                  </li>
				  <?php endif ?>
                  <li>
                      <button type="button" onclick="get_solicitudes_list()" ><i id="loading" class="fa fa-refresh"></i></button>
                  </li>
                    <li>
                        <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                    </li>
                </ul>
                <h3 class="block-title">Control de Solicitud de Vehículos</h3>
              </div>
              <div id="tablaaa" class="block-content">
              </div>


            </div>
          </div>



        <script>



</script>






        </body>


        </html>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
  echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
