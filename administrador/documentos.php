
<?php
if (function_exists('login_check') && login_check() == true):
    if (isset($u) && $u->hasPrivilege('DescargarDocumento')):
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
            <script src="../herramientas/transporte/js/list.js"></script>
        </head>
        <body >
          <div class="content bg-gray-lighter">
              <div class="row items-push">
                  <div class="col-sm-7">
                      <h1 class="page-heading">
                        <i class="fa fa-download"></i>
                          Documentos
                      </h1>
                  </div>

              </div>
          </div>


          <div class="content content-boxed">
            <div class="block block-themed block-rounded" id="block_hide">
              <div class=" block-header bg-muted ">
                <ul class="block-options">
                  <li>
                      <button type="button" onclick="get_solicitudes_list()" ><i id="loading" class="fa fa-refresh"></i></button>
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
                      <table id="vehiculos_list" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
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
