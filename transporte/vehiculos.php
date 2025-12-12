
<?php
if (function_exists('login_check') && login_check() == true):
    if (isset($u) && $u->hasPrivilege('autorizarSolicitudTransporte')):
    ?>
        <!-- Page JS Plugins CSS -->



         <!-- INICIO Encabezado de Pagina -->

        <!-- FIN Encabezado de Pagina -->

        <?php


        ?>

        <!-- INICIO Contenido de pagina -->
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>
            <script src="transporte/js/list.js"></script>
        </head>
        <body >
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="col-sm-7">
                      <h1 class="page-heading">
                          CONTROL DE VEHICULOS
                      </h1>
                  </div>

              </div>
          </div>


          <div class="content content-boxed">
            <div class="block block-themed block-rounded" id="block_hide">
              <div class=" block-header bg-muted ">
                <ul class="block-options">
                  <li>
                      <button type="button" title="Vehículos" onclick="get_vehiculos_list()" ><i id="loading_1" class="fa fa-car"></i></button>
                  </li>
                   <li>
                      <button type="button" title="Mantenimiento Vehículos" onclick="get_vehiculos_list2()" ><i id="loading_1" class="fa fa-car"></i></button>
                  </li>
                  <li>
                      <button type="button" title="Pilotos" onclick="get_drivers_list()" ><i class="fa fa-user"></i></button>
                  </li>
                  <li>
                        <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                    </li>
                </ul>
                <h3 class="block-title" >Vehículos para comisiones de la Vicepresidencia</h3>
              </div>
              <div class="block-content">


                  <div class="form-group">
                    <div class="form-material">
                      <table id="vehiculos_list" class="print table-bordered table-condensed table-striped  dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
                      </table>
                    </div>
                  </div>



              </div>

            </div>
          </div>









        </body>


        </html>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='../directorio/index.php'; </script>";
endif;
?>
