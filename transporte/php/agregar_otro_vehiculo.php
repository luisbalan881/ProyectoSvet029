<?php
    include_once '../../inc/functions.php';
    include_once 'get_solicitud.php';
    include_once 'funciones.php';

    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('autorizarSolicitudTransporte') ) :
            $id = null;
            $user = $_SESSION['user_id'];
            $persona = User::get_empleado_datos_id($user);
              $id = $_POST['id'];
              $conteo = verificar_vehiculo($id);
              $vehiculos = get_vehiculos($persona['dep_id']);
              $drivers = User::getAllDrivers($persona['dep_id']);
              $solicitud = get_solicitud_by_id($id);

      ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Transporte</title>
            <script src="transporte/js/funciones.js"></script>
            <script src="assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="assets/js/plugins/chosen/chosen.css">



        </head>

        <body>





              <div class="">
                  <ul class="block-options2" style="margin-top:-64px;margin-right:-2px">
                      <li>
                          <button onclick="load_solicitud_id(<?php echo $id?>)" type="button" ><i class="btn-regresar"></i></button>
                      </li>
                  </ul>


              </div>

              <div class="block block-themed block-transparent remove-margin-b">
                <div class="form-horizontal push-10-t push-10">


                  <br>
                <div class="form-group">
                    <div class="col-xs-5">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-car"></span></span>
                            <select class ="chosen-select-width form-control" name="vehiculo" id="vehiculo"  style="width: 100%;" data-placeholder="-- Seleccionar Vehículo --" >
                              <option></option>
                              <?php

                              foreach ($vehiculos as $vehiculo):
                                  echo '<option value="'.$vehiculo["vehiculo_id"].'" >'.$tipo_vehiculo[$vehiculo['tipo']].' -  -  - '.$vehiculo['placa'].'-- -- --'.$vehiculo["nombre"].' '.$vehiculo['linea'].'</option>';
                              endforeach

                              ?>
                            </select>

                          </div>

                          <label for="destino">Asignar Vehículo*</label>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-user"></span></span>
                              <select class ="chosen-select-width" name="conductor_id" id="conductor_id"  style="width: 100%;" data-placeholder="-- Seleccionar Conductor --" required>
                                <option></option>
                                <?php
                                foreach ($drivers as $driver):
                                    echo '<option value="'.$driver["user_id"].'" '.(($driver["conductor_id"] == $driver_asig["conductor_id"])? 'selected':'').' '.(($driver['status'] == 0)?'disabled': '').'>'.$driver["nombre"].'</option>';
                                endforeach
                                ?>
                              </select>
                            </div>
                            <label for="conductor_id">Conductor*</label>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-user"></span></span>
                              <select class ="chosen-select-width" name="tipo_de_transporte" id="tipo_de_transporte"  style="width: 100%;" data-placeholder="-- Seleccionar Motivo --" required>
                                <option></option>
                                <option value="1">LLevar y traer</option>
                                <option value="2">LLevar</option>
                                <option value="3">Traer</option>

                              </select>
                            </div>
                            <label for="tipo_de_transporte">Especificar*</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-sm-12 text-center">
                      <button class="btn btn-sm btn-success btn-block" onclick="add_car(<?php echo $solicitud['ID'] ?>, <?php echo $user ?>)" ><i id="loading_ag_ve" class="fa fa-refresh fa-spin" style="display:none;"></i> Agregar este vehículo</button>
                  </div>
                </div>

              </div>
            </div>

            <div  class="notificacion_alerta">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              <i id="icono_n"></i><h1 id="message_notificacion"></h1>
            </div>



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
