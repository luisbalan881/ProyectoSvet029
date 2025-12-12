<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearVehiculo')) :
          $id=$_SESSION['user_id'];
          /*$year=$_POST['year'];
          $mes=$_POST['mes'];
          $solicitud=$_POST['solicitud_id'];
          $vehiculo=$_POST['vehiculo_id'];*/
          include_once 'php/funciones.php';

          $drivers = get_pilotos();
          $departamentos = departamentos();
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



        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">
              <div class="tag-green">Agregar Vehículo</div>
              <div class="">
                  <ul class="block-options2" style="margin-top:-40px;">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br>
              <form class="js-validation-vehiculo-nuevo form-horizontal push-10-t push-10">

                <div class="form-group">
                  <div class="col-xs-6">
                      <div class="form-material">
                        <label for="tipo">Tipo vehículo*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-car"></span></span>

                          <select name="tipo"  id="tipo" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar Tipo Vehículo --" required>
                            <option value="" selected disabled></option>
                            <option value="1">Camioneta</option>
                            <option value="2">Vehículo</option>
                            <option value="3">Pick up</option>
                            <option value="4">Microbus</option>
                            <option value="5">Motocicleta</option>
                          </select>

                        </div>
                      </div>
                  </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="marca">Marca*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><img src="assets/img/vehicle/brand-new-car.png"></span></span>
                            <select name="marca"  id="marca" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar Marca --" required>
                              <option value="" selected disabled></option>
                              <option value="TOTOYA">TOTOYA</option>
                              <option value="NISSAN">NISSAN</option>
                              <option value="MITSUBISHI">MITSUBISHI</option>
                              <option value="MAZDA">MAZDA</option>
                              <option value="HONDA">HONDA</option>
                              <option value="YAMAHA">YAMAHA</option>
                              <option value="SUZUKI">SUZUKI</option>

                              </select>

                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-material ">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-pencil"></span></span>
                            <input class="form-control"    id="linea" name="linea" required>
                          </div>
                          <label for="soli_tiempo">Línea*</label>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-pencil"></span></span>
                            <input class="form-control" type="number"   id="modelo" name="modelo" min="1990" required>
                          </div>
                          <label for="modelo">Modelo*</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <div class="col-xs-6">
                      <div class="form-material">
                        <label for="tipo">Tipo Combustible*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><img src="assets/img/vehicle/gas-station.png"></span>
                          <select name="combustible"  id="combustible" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar Tipo Combustible --" required>
                            <option value"" selected disabled></option>
                            <option value="1">Gasolina</option>
                            <option value="2">Diesel</option>

                          </select>

                        </div>
                      </div>
                  </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="marca">Placa*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><img src="assets/img/vehicle/license-plate.png"></span>
                            <input class="form-control" type="text"  id="placa" name="placa" required>
                          </div>
                        </div>
                    </div>
                  </div>

                <div class="form-group">
                  <div class="col-xs-2 col-sm-6">
                      <div class="form-material ">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><img src="assets/img/vehicle/piston.png"></span>
                          <input class="form-control"  type="number"  id="cilindros" name="cilindros" required>
                        </div>
                        <label for="soli_tiempo">Cilindros*</label>
                      </div>
                  </div>
                  <div class="col-xs-2 col-sm-6">
                      <div class="form-material">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><img src="assets/img/vehicle/belt.png"></span>
                          <input class="form-control" type="number"   id="cilindraje" name="cilindraje" min="100" required>
                        </div>
                        <label for="modelo">Cilindraje*</label>
                      </div>
                  </div>
              </div>

              <div class="form-group">
                <div class="col-xs-2 col-sm-6">
                    <div class="form-material ">
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><img src="assets/img/vehicle/chassis.png"></span>
                        <input class="form-control"  id="chasis_no" name="chasis_no" required>
                      </div>
                      <label for="soli_tiempo">Chasis No.*</label>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-6">
                    <div class="form-material">
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><img src="assets/img/vehicle/engine.png"></span>
                        <input class="form-control" id="motor_no" name="motor_no" required>
                      </div>
                      <label for="modelo">Motor No.*</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
              <div class="col-xs-2 col-sm-6">
                  <div class="form-material ">
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-paint-brush"></span></span>
                      <input class="form-control"    id="color" name="color" required>
                    </div>
                    <label for="soli_tiempo">Color*</label>
                  </div>
              </div>
              <div class="col-xs-2 col-sm-6">
                  <div class="form-material">
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-pencil"></span></span>
                      <input class="form-control" type="number"   id="capacidad" name="capacidad" min="1" required>
                    </div>
                    <label for="modelo">Capacidad de pasajeros.*</label>
                  </div>
              </div>
          </div>



                <div class="form-group">
                  <div class="col-xs-6">
                      <div class="form-material">
                        <label for="tipo">Conductor Responsable*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="si si-user"></span></span>
                          <select name="conductor"  id="conductor" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar Conductor --" required>
                            <option value"" selected disabled></option>
                            <?php
                            foreach ($drivers as $driver):
                                echo '<option value="'.$driver["user_id"].'" >'.$driver["NOMBRE"].'</option>';
                            endforeach
                            ?>
                          </select>

                        </div>
                      </div>
                  </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="marca">Departamento a Asignar*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-bank"></span></span>
                            <select name="dep_id"  id="dep_id" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar Departamento --" required>
                              <option value"" selected disabled></option>
                              <?php
                                  foreach ($departamentos as $n):
                                      echo '<option value="'.$n['dep_id'].'">'.$n['dep_nm'].'</option>';
                                  endforeach
                              ?>

                              </select>

                          </div>
                        </div>
                    </div>
                  </div>
                <div class="form-group">
                  <div class="col-sm-12 text-center">
                      <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="crear_vehiculo()" ><i id="loading_ve_nu" class="fa fa-refresh fa-spin" style="display:none;"></i> Crear Vehículo</button>
                  </div>
                </div>



              </form>
            </div>
          </div>
          <script src="transporte/js/vehiculo_form_validate.js"></script>

          <!-- Page JS Code -->


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
