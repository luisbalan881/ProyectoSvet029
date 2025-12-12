<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearCupon')) :
          include_once 'php/funciones.php';
          include_once 'inc/Driver.php';
          include_once 'inc/Vehicle.php';

          $drivers = Driver::getAll(usuarioPrivilegiado());
          $vehiculos = Vehicle::getAll(usuarioPrivilegiado());
          $id=$_SESSION['user_id'];
          $cupones = cupones_disponibles();
          $fecha = date('d-m-Y',time());
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="tag-green">Asignar Cupones a Vehículo</div>
            <div class="">
                <ul class="block-options2" style="margin-top:-40px;">
                    <li>
                        <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                    </li>
                </ul>
                <br>
            </div>
            <form class="js-validation-asignar-cupones form-horizontal push-10-t push-10">
              <div class="form-group">
                  <div class="col-xs-12">
                      <div class="form-material">
                          <!--<input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="" required>-->

                          <label for="cupones">Cupon(es)*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-ticket"></span></span>
                            <select name="cupones" id="cupones"  multiple="multiple" data-placeholder="Seleccione uno o mas Cupones" class="chosen-select-width col-xs-12" multiple tabindex="6" required>
                              <?php
                              foreach ($cupones as $c):

                                      echo '<option value="'.$c["cupon_id"].'">'.$c["cupon_id"].' - '.$c['monto'].'</option>';

                              endforeach
                              ?>
                              </select>
                          </div>
                      </div>
                  </div>
              </div>



              <div class="form-group">
                <div class="col-xs-4">
                    <div class="form-material">
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                        <input class="js-datepicker form-control" type="text" id="fecha_asi" name="fecha_asi" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $fecha ?>" required>
                      </div>
                        <label for="ext_id">Fecha*</label>
                    </div>
                </div>
                <div class="col-xs-8">
                    <div class="form-material">
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-user"></span></span>
                          <select class ="chosen-select-width" name="conductor_id" id="conductor_id"  style="width: 100%;" data-placeholder="-- Seleccionar Conductor --" required>
                            <option></option>
                            <?php
                            foreach ($drivers as $driver):
                                echo '<option value="'.$driver["conductor_id"].'" '.(($driver["conductor_id"] == $driver_asig["conductor_id"])? 'selected':'').' '.(($driver['status'] == 0)?'disabled': '').'>'.$driver["nombre"].'</option>';
                            endforeach
                            ?>
                          </select>
                        </div>
                        <label for="conductor_id">Conductor*</label>
                    </div>
                </div>

                </div>

                <!--conductor y vehiculo -->


                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-car"></span></span>
                            <select class ="chosen-select-width altura" name="vehiculo" id="vehiculo"  style="width: 100%;" data-placeholder="-- Seleccionar Vehículo --" required>
                              <option></option>
                              <?php

                                foreach ($vehiculos as $vehiculo)
                                {
                                  echo '<option value="'.$vehiculo["vehiculo_id"].'">'.$vehiculo["placa"].' - '.$vehiculo["nombre"].' - '.$vehiculo["linea"].' </option>';
                                }

                              ?>
                            </select>

                          </div>

                          <label for="vehiculo">Seleccionar Vehículo*</label>
                        </div>
                    </div>
                </div>


                <!-- final -->


                <div class="form-group">
                  <div class="col-xs-12 text-center">
                      <button class="btn btn-sm btn-success btn-block" onclick="asignar_cupones(<?php echo $id ?>)"  id="boton_a_v" ><i style="display:none;" id="loading_ascv" class="fa fa-refresh fa-spin"></i> Asignar Cupon (es)</button>
                  </div>
                </div>
            </form>



          <!-- Page JS Code -->


        </body>
        </html>
        <script src="combustible/js/asignar_cupones_form_validate.js"></script>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
