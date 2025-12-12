
<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">

        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">
        <script src="combustible/js/load_cupones_mes_list.js"></script>

      </head>
         <!-- INICIO Encabezado de Pagina -->

        <!-- FIN Encabezado de Pagina -->

<body>
        <!-- INICIO Contenido de pagina -->


              <div class="block-header " id="buscador">


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
              <select id="mes2" name="mes2" class=" form-control " >
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
                  <button class="btn btn-sm btn-success " onclick="cargar_cupones_mes_listado()" ><i class=""></i>Generar Reporte</button>
                  <?php
                  /*echo 'REPORTE DEL : '. $fechi . '  AL   ';
                  echo $fechf;*/
                  ?>
                  <i id="car_t" class="fa fa-refresh" style="margin-left:5px; display:none;"></i>

              </div>


              <div id="tabla1" class=""style="border-top:0.5px solid #eee">
                <br>
              </div>

















        <!-- FIN Contenido de Pagina -->
      </body>
      </html>
        <?php
    else:
        //echo include(unauthorized());
    endif;
else:
    //echo "<script type='text/javascript'> window.location='../directorio/index.php'; </script>";
endif;
?>
