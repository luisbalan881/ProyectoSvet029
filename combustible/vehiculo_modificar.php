<?php
include_once '../inc/functions.php';
include_once 'inc/Vehicle.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarCupon')):
        $id = null;
        $vehiculo = array();
        if(!empty($_GET['id'])){
            $id = $_REQUEST['id'];
            $vehiculo = Vehicle::getByID(usuarioPrivilegiado(),$id);
        }
        if(null == $id){
            header("Location: index.php?ref=_43");
        }
        if ( !empty($_POST)) {
            Vehicle::update(usuarioPrivilegiado(),$_POST['nombre'],$_POST['linea'],$_POST['placa'],$_POST['modelo'],$_POST['cilindraje'],$_POST['combustible'],$_POST['color'],$_POST['status'],$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_43");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Vehículo Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Vehículo</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-vehiculo form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <input type="text"  id="vehiculo_id" name="vehiculo_id" value="<?php echo $vehiculo['vehiculo_id'] ?>" hidden title="vehiculo_id">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control focus"  type="text"  id="nombre" name="nombre" value="<?php echo $vehiculo['nombre'] ?>" required>
                                <label for="nombre">Nombre*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="linea" name="linea" value="<?php echo $vehiculo['linea'] ?>" required>
                                <label for="linea">Línea*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="placa" name="placa" value="<?php echo $vehiculo['placa'] ?>" required>
                                <label for="placa">Placa*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control" type="number" id="modelo" name="modelo"  placeholder="yyyy" minlength="4" maxlength="4" value="<?php echo $vehiculo['modelo'] ?>" required>
                                <label for="modelo">Modelo*</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="cilindraje" name="cilindraje"  value="<?php echo $vehiculo['cilindraje'] ?>" required>
                                <label for="cilindraje">Cilindraje*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="combustible" id="combustible"  style="width: 100%;" data-placeholder="-- Seleccionar Combustible --" required>
                                    <option value="1" <?php echo (($vehiculo["combustible_id"] == 1)? 'selected':''); ?>>Gasolina</option>
                                    <option value="2" <?php echo (($vehiculo["combustible_id"] == 2)? 'selected':''); ?>>Diesel</option>
                                </select>
                                <label for="combustible">Combustible*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="color" name="color" value="<?php echo $vehiculo['color'] ?>"  required>
                                <label for="color">Color*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-success">
                                <input name="status" type="checkbox"  <?php echo (($vehiculo['status'] == 1)?'checked':''); ?> value="1"><span></span>Vehículo Activo
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-warning btn-block" type="submit"><i class=""></i>Guardar Cambios</button>
                      </div>
                    </div>
                </form>
            </div>
          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (BS  Select2 Inputs plugins)
                  App.initHelpers(['datepicker','select2']);
              });
          </script>
          <script src="assets/js/pages/coupons_forms_validation.js"></script>
        </body>
        </html>
    <?php
    else :
        echo include(unauthorizedModal());
    endif;
else:
    header("Location: index.php");
endif;
?>
