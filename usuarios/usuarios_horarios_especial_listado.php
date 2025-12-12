
<?php
include_once '../inc/functions.php';
sec_session_start();
$u=usuarioPrivilegiado();

if (function_exists('login_check') && login_check() == true):
    if (isset($u) && $u->hasPrivilege('leerUsuario')):
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <!-- Page JS Plugins CSS -->


      </head>
         <!-- INICIO Encabezado de Pagina -->

        <!-- FIN Encabezado de Pagina -->



        <!-- INICIO Contenido de pagina -->
        <div class="">
            <!-- Header Tiles -->

            <!-- END Header Tiles -->

            <!-- Todos los Productos -->
            <div class="block">
              <div class="block block-themed block-rounded" id="block_hide">
              <div class="block-header bg-muted">
                  <ul class="block-options">
                    <li>
                       <button data-toggle="modal" data-target="#modal-remoto-lgg" href="usuarios/usuarios_por_grupo.php" ><i class="fa fa-users"></i> Horario por Usuario</button>
                    </li>
                      <li>
                         <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <span id="block_show" class="text-white"><h3 class="block-title">CONTROL DE HORARIO DE EMPLEADOS</h3></span>
              </div>
              <div class="block-header bg-gray-lighter">
              <div class="-horizontal push-10-t push-10" action="" method="">
                <div class="form-group">

                  <div class="col-xs-2">
                      <div class="">
                  <label > Seleccione el Año para Generar Reporte</label>

                </div>
              </div>

              <div class="col-xs-2">
                  <div class="">
                  <select id="year" name="year"  class=" form-control">
                    <?php
                    for($i=date('o'); $i>=2018; $i--){
                      if ($i == date('o'))
                      echo '<option value="'.$i.'" selected>'.$i.'</option>';
                      else
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                  </select>

                </div>
              </div>
                  <button class="btn btn-sm btn-success " onclick="cargar_horarios_especial()"><i class=""></i>Generar Reporte</button>
                  <?php
                  /*echo 'REPORTE DEL : '. $fechi . '  AL   ';
                  echo $fechf;*/
                  ?>
                  <i id="car_t" class="fa fa-refresh" style="margin-left:5px; display:none;"></i>
                </div>
                <div>



                </div>
              </div>


              </div>


              <div id="tabla11" class="block-content">
                <p>Mostrar Datos</p>
              </div>
















            </div>
            <!-- Final Todos los Productos -->
        </div>
        <!-- FIN Contenido de Pagina -->
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
