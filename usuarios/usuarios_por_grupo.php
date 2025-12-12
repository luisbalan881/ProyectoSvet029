<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>




        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">

              <div class="col-xs-3">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span  class="input-group-addon" disabled><i class="fa fa-calendar-check-o"></i></span>
                    <span class="input-group-addon span-personalizado" id="este_titulo" type="text">Seleccionar Empleado</span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" style="margin-top:0px;">
                      <li>
                          <button id="close_this_group" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br>


              <div class=" form-horizontal push-10-t push-10" >




                <div class="form-group">
                    <div class="col-xs-12" id="cuadro">




                    </div>

                </div>

              </div>
            </div>

          </div>

          <!-- Page JS Code -->
          <script>
          $(document).ready(function() {
            load_usuarios_por_grupo_list();
          });
          </script>



        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
