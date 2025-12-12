
<?php
include_once '../inc/functions.php';
sec_session_start();
$u=usuarioPrivilegiado();
if (function_exists('login_check') && login_check() == true):
    if (isset($u) && usuarioPrivilegiado()->hasPrivilege('leerUsuario')):
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
                      <button type="button">
                          <a class="text-white" <?php echo (($u->hasPrivilege("leerUsuario"))?'onclick="cargar_horarios_todos()"':'" disabled') ?> >
                              <img src="assets/img/file.png"/> Informe General
                          </a>
                      </button>
                    </li>
                    <li>
                      <a class="fa fa-wrench"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="usuarios/asignar_dia_permiso.php"></a>
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
                  <label > Seleccione Mes y Año para Generar Reporte</label>

                </div>
              </div>
                  <div class="col-xs-2">
                      <div class="">
                  <select id="mes" name="mes" class=" form-control " >
                    <?php
                    for ($x=1; $x<=12; $x++) {
                      if ($x == date('m'))
                      echo '<option value="'.$x.'" selected>'.User::get_nombre_mes($x).'</option>';
                      else
                      echo '<option value="'.$x.'">'.User::get_nombre_mes($x).'</option>';
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-2">
                  <div class="">
                  <select id="anio" name="anio"  class=" form-control">
                    <?php
                    for($i=date('o'); $i>=2015; $i--){
                      if ($i == date('o'))
                      echo '<option value="'.$i.'" selected>'.$i.'</option>';
                      else
                      echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                    ?>
                  </select>

                </div>
              </div>
                  <button class="btn btn-sm btn-success " onclick="cargar_horarios()"><i class=""></i>Generar Reporte</button>
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


              <div id="tabla1" class="block-content">
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
