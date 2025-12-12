<?php

if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
      $user_id = $_SESSION['user_id'];
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title></title>
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
            <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
            <script src="combustible/js/list.js"></script>



        </head>
        <body >
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="content content-boxed">
                    <ol class="breadcrumb breadcrumb-arrow">
                <li><a><i class="fa fa-ticket"></i> Control de Cupones</a></li>
                <li><a><i class="fa fa-file-text"></i> Reportes</a></li>
                <li><a><i class="fa fa-arrow-right"></i> Despacho</a></li>

              </ol>
                  </div>

              </div>
          </div>
          <div class="content content-boxed">
            <div class="block block-themed block-rounded">
              <div class=" block-header bg-muted ">
                <ul class="block-options">
                  <!--<li>
                      <button title="Cupones Asignados" type="button" onclick="get_cupones_usados_list()" ><i id="loading" class="fa fa-car"></i></button>
                  </li>
                  <li>
                      <button title="Cupones" type="button" onclick="get_cupones_list()" ><i  class="fa fa-ticket"></i></button>
                  </li>-->
                  <li>
                      <button title="Reportes" type="button" onclick="get_cupones_usados_mensual_list()" ><i  class="fa fa-file-text"></i></button>
                  </li>
                  <!--<li>
                      <button title="Reportes por Cupones" type="button" onclick="get_reporte_por_cupones()" ><i  class="fa fa-ticket"></i></button>
                  </li>
                  <li>
                      <button title="Dashboard" type="button" onclick="get_dashboard()" ><i  class="fa fa-bar-chart"></i></button>
                  </li>-->



                    <li>
                        <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                    </li>
                </ul>
                <h3 class="block-title">Control de cupones</h3>
              </div>
              <div id="tablaaa" class="block-content">
              </div>


            </div>
          </div>



        <script>



    </script>






        </body>


        </html>
<?php
else :
    echo include(unauthorized());
endif;
else:
header("Location: index.php");
endif;
?>
