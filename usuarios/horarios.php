
<?php
if (function_exists('login_check') && login_check() == true):
    if (isset($u) && $u->hasPrivilege('leerUsuario')):
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">

        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
        <script src="../herramientas/usuarios/js/load_horarios_list.js"></script>
      </head>
         <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        CONTROL DE HORARIOS
                    </h1>
                    <div class="col-sm-2 menu-heading" style="margin-top:6.5px">
                        <ul class="block-options2" style="">

                            <div class="btn-group" data-toggle="buttons">
                              <!-- class="input-group-addon" -->
                              <label class="btn btn-secondary btn-sm " id="xx">
                                <input type="radio" name="options" id="option1" onchange="load_horarios_8()" >Horario 8 Horas
                              </label>
                              <label class="btn btn-secondary btn-sm">
                                <input type="radio" name="options" id="option2" onchange="load_horarios_8_dias()" >Horario 8X8 días
                              </label>

                            </div>
                          </ul>


                    </div>
                </div>


            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->



        <!-- INICIO Contenido de pagina -->
        <div id="pantalla" class="content content-boxed">

            <!-- Final Todos los Productos -->
        </div>
        <!-- FIN Contenido de Pagina -->
        <script>
        $(document).ready(function(){
          load_horarios_8();
          $('#xx').addClass('contorno');
        });
        function imprimir() {
            print();
        }
        </script>
      </body>
      </html>
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
    echo "<script type='text/javascript'> window.location='../directorio/index.php'; </script>";
endif;
?>
