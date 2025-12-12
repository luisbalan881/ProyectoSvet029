<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearVehiculo')) :
          $id=$_SESSION['user_id'];

          $vehiculo = null;

          if ( !empty($_GET['vehiculo_id'])) {
            $vehiculo = $_REQUEST['vehiculo_id'];
          }
          include_once 'php/funciones.php';

          $carro = get_carro_by_id($vehiculo);
          $drivers = get_pilotos();
          $departamentos = departamentos();
          //echo $carro['vehiculo_id'];
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
              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Modificar Vehículo :</strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo $carro['placa']; ?> </span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" style="">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br><br><br>
              <form class="js-validation-vehiculo-modificar form-horizontal push-10-t push-10">

                <div class="form-group">
                  <div class="col-xs-6">
                      <div class="form-material">
                        <label for="tipo">Tipo vehículo*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-car"></span></span>
                          <input class="form-control" name="tipo"  id="tipo" style="width: 100%;"  value="<?php echo $tipo_vehiculo[$carro['tipo']] ?>" required></input>
                        </div>
                      </div>
                  </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="marca">Marca*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><img src="assets/img/vehicle/brand-new-car.png"></span></span>
                            <input class="form-control" name="marca"  id="marca" style="width: 100%;"  value="<?php echo $carro['nombre'] ?>" required></input>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-material ">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-pencil"></span></span>
                            <input class="form-control"    id="linea" name="linea" value="<?php echo $carro['linea'] ?>" required>
                          </div>
                          <label for="soli_tiempo">Línea*</label>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-pencil"></span></span>
                            <input class="form-control" type="number"   id="modelo" name="modelo" min="1990" value="<?php echo $carro['modelo'] ?>" required>
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
                            <option value="" selected disabled></option>
                            <option value="1" <?php if($carro['combustible_id']==1){ echo 'selected';} ?> >Gasolina</option>
                            <option value="2" <?php if($carro['combustible_id']==2){ echo 'selected';} ?> >Diesel</option>

                          </select>

                        </div>
                      </div>
                  </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="marca">Placa*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><img src="assets/img/vehicle/license-plate.png"></span>
                            <input class="form-control" type="text"  id="placa" name="placa" value="<?php echo $carro['placa'] ?>" required>
                          </div>
                        </div>
                    </div>
                  </div>

                <div class="form-group">
                  <div class="col-xs-2 col-sm-6">
                      <div class="form-material ">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><img src="assets/img/vehicle/piston.png"></span>
                          <input class="form-control"  type="number"  id="cilindros" name="cilindros" value="<?php echo $carro['cilindraje'] ?>" required>
                        </div>
                        <label for="soli_tiempo">Cilindros*</label>
                      </div>
                  </div>
                  <div class="col-xs-2 col-sm-6">
                      <div class="form-material">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><img src="assets/img/vehicle/belt.png"></span>
                          <input class="form-control" type="number"   id="cilindraje" name="cilindraje" min="0" value="<?php echo $carro['c_c'] ?>" required>
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
                        <input class="form-control"  id="chasis_no" name="chasis_no" value="<?php echo $carro['chasis_no'] ?>" required>
                      </div>
                      <label for="soli_tiempo">Chasis No.*</label>
                    </div>
                </div>
                <div class="col-xs-2 col-sm-6">
                    <div class="form-material">
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><img src="assets/img/vehicle/engine.png"></span>
                        <input class="form-control" id="motor_no" name="motor_no" value="<?php echo $carro['motor_no'] ?>" required>
                      </div>
                      <label for="modelo">Moto No.*</label>
                    </div>
                </div>
            </div>

            <div class="form-group">
              <div class="col-xs-2 col-sm-6">
                  <div class="form-material ">
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-paint-brush"></span></span>
                      <input class="form-control"    id="color" name="color" value="<?php echo $carro['color'] ?>" required>
                    </div>
                    <label for="soli_tiempo">Color*</label>
                  </div>
              </div>
              <div class="col-xs-2 col-sm-6">
                  <div class="form-material">
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-pencil"></span></span>
                      <input class="form-control" type="number"   id="capacidad" name="capacidad" min="1" value="<?php echo $carro['capacidad'] ?>" required>
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
                                echo '<option value="'.$driver["user_id"].'"';
                                if($carro['user_id']==$driver['user_id']){
                                  echo 'selected';
                                }
                                echo ' >'.$driver["NOMBRE"].'</option>';
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
                                      echo '<option value="'.$n['dep_id'].'"';
                                      if($carro['dep_id']==$n['dep_id']){
                                        echo 'selected';
                                      }
                                      echo '>'.$n['dep_nm'].'</option>';
                                  endforeach
                              ?>

                              </select>

                          </div>
                        </div>
                    </div>
                  </div>
                <div class="form-group">
                  <div class="col-sm-12 text-center">
                      <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="editar_vehiculo(<?php echo $carro['vehiculo_id'] ?>)" ><i id="loading_ve_mo" class="fa fa-refresh fa-spin" style="display:none;"></i> Guardar Cambios</button>
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
