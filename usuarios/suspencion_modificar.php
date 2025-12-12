<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
  if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

    $jefe=$_SESSION['user_id'];

    $resolucion = $_POST['resolucion'];
    $vid = $_POST['vid'];
    $r = "'".$resolucion."'";
    $dias = array();
    $dias = tipos_dias_laborales_suspencion_igss();
    if ( !empty($_POST)) {
      //User::suspencion_modificar();
      //header("Location: index.php?ref=_35");
    }
    date_default_timezone_set('America/Guatemala');
    ?>

    <html >
    <head>
      <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

    </head>
    <br><br><br>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4>Modificar Resolución</h4>
          <span class="btn-circle"  onclick="get_suspenciones_list(<?php echo $vid?>,<?php echo $jefe?>)" style="margin-top:-20px;margin-right:5px;"></span>

        </div>
        <div class="block-content">
          <form action="" method="" class="js-validation-suspencion_modificar" id="sm_form">
            <input  type="text"  id="codigo_u" name="codigo_u" value="<?php echo $vid?>" style="visibility:hidden">
            <input  type="text"  id="codigo_jefe" name="codigo_jefe" value="<?php echo $_SESSION['user_id'] ?>"  style="visibility:hidden">
        <div class="form-group"  >
          <div class="col-xs-3">
            <div class="">
              <label for="resolucion1">Resolución</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" disabled><span class="fa fa-calendar-check-o" ></span></span>
                <input class="form-control altura"  type="text"  id="resolucion1" name="resolucion1"  disabled>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="">
              <label for="from1">Fecha Notificación*</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                <input class="js-datepicker form-control input-sm" type="text" id="fecha_no" name="fecha_no" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  required>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="">
              <label for="descripcion">Descripción</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                <textarea class="form-control altura"  type="text"  id="descripcion1" name="descripcion1" ></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="form-group"  >
          <div class="col-xs-3">
            <div class="">
              <label for="dia1">Seleccione el tipo de suspención*</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="fa fa-arrow-circle-left"></span></span>
                <select class="form-control miselect altura altura" name="dia1" id="dia1"  style="width: 100%;" required>
                  <option value="" disabled selected hidden>Seleccionar Ausencia</option>
                    <?php
                    foreach ($dias as $dia) {

                            echo '<option value="' . $dia["dia_laboral_id"] . '">'.$dia["dia_nm"] .'</option>';

                    }
                    ?>
                </select>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="">
              <label for="from1">Fecha Inicio*</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                <input class="js-datepicker form-control input-sm" type="text" id="from1" name="from1" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  required>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="">
              <label for="to1">Fecha Fin*</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                <input class="js-datepicker form-control input-sm" type="text" id="to1" name="to1" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  required>
              </div>
            </div>
          </div>
          <div class="col-xs-3">
            <div class="">
              <label for="to1">Fecha Regreso</label>
              <div class="input-group has-personalizado">
                <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                <input class="js-datepicker form-control input-sm" type="text" id="regreso" name="regreso" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  required>
              </div>
            </div>
          </div>

        </div>
        <div class="form-group"  >
          <div class="col-xs-12 text-center">
              <button class="btn btn-sm btn-success btn-block" onclick="actualizar_resolucion()"><i style="display:none;" id="loading5" class="fa fa-refresh fa-spin"></i> Guardar Cambios</button>
          </div>
        </div>
      </div>

    </form>


      </div>


    </html>
    <script>

    </script>


    <?php
    else :
      echo include(unauthorizedModal());
    endif;
  else:
    //echo "<script type='text/javascript'> window.location='../index.php?ref=_35.php'; </script>";
  endif;
  ?>
