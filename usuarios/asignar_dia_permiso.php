<?php
    include_once '../inc/functions.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('Configuracion') || verificar_director($user->persona['user_id'])==1) :

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">
            <script src="usuarios/js/asignar_permiso_todos.js"></script>
        </head>
        <body>
          <div class=" block block-themed card remove-margin-b">
            <div class="block-content">
              <div class="tag-green" style="z-index:66;">Asignar Permiso a todos</div>
            <div class="">
                <ul class="block-options2" style="margin-top:-40px;">
                    <li>
                        <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                    </li>
                </ul>


            </div>
            <br>
            <br>

            <form class="js-validation-asignar form-horizontal">
              <div class="form-group">
                <div class="col-xs-6 ">
                  <div class="form-material">
                    <label for="fecha_per">Fecha Permiso</label>
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                      <input class="input-sm js-datepicker form-control" type="text" id="fecha_per" name="fecha_per" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                    </div>
                  </div>
                </div>


                <div class="col-xs-6 text-center">
                  <div class="form-material">
                    <button id="btnGuardar" name="btnGuardar" onclick="asignar()"  class="btn btn-sm btn-success btn-block" type="submit"><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i> Actualizar</button>
                  </div>
                </div>
              </div>
            </form>
            <!-- Page JS Code -->
          </div>
        </div>
          <script>
              jQuery(function(){
                  // Init page helpers (Select2 Inputs plugins)
                  App.initHelpers(['select2']);
              });
          </script>

        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       //echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
    endif;
?>
