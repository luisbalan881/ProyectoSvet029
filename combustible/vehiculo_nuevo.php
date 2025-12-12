<?php
include_once '../inc/functions.php';
include_once 'inc/Vehicle.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):
        if ( !empty($_POST)) {
            Vehicle::create(usuarioPrivilegiado(),$_POST['nombre'],$_POST['linea'],$_POST['placa'],$_POST['modelo'],$_POST['cilindraje'],$_POST['combustible'],$_POST['color'],$_SESSION['user_id']);
            header("Location: index.php?ref=_43");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Vehículo Nuevo</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Agregar Nuevo Vehículo</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-vehiculo form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control focus"  type="text"  id="nombre" name="nombre"  required>
                                <label for="nombre">Nombre*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="linea" name="linea"  required>
                                <label for="linea">Línea*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="placa" name="placa"  required>
                                <label for="placa">Placa*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control" type="number" id="modelo" name="modelo"  placeholder="yyyy" minlength="4" maxlength="4" required>
                                <label for="modelo">Modelo*</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="cilindraje" name="cilindraje"  required>
                                <label for="cilindraje">Cilindraje*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="combustible" id="combustible"  style="width: 100%;" data-placeholder="-- Seleccionar Combustible --" required>
                                    <option value="1" selected>Gasolina</option>
                                    <option value="2">Diesel</option>
                                </select>
                                <label for="combustible">Combustible*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="color" name="color"  required>
                                <label for="color">Color*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Vehículo</button>
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
