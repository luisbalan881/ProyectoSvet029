<?php
include_once '../inc/functions.php';
include_once 'inc/Driver.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):
        $personas = personas();
        if ( !empty($_POST)) {
            Driver::create(usuarioPrivilegiado(),$_POST['user_id'],$_POST['licencia_num'],fecha_ymd($_POST['licencia_cad']),$_SESSION['user_id']);
            header("Location: index.php?ref=_44");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Conductor Nuevo</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Agregar Nuevo Conductor</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-conductor form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="user_id" id="user_id" style="width: 100%;" data-placeholder="-- Seleccionar Usuario --" required>
                                    <option></option>
                                    <?php
                                        foreach ($personas as $persona):
                                            if ($persona['user_status'] == 1){
                                                echo '<option value="'.$persona['user_id'].'" '.(($persona['user_status']== 0)? 'disabled':'').'>'.$persona['user_nm1'],' ',$persona['user_ap1'],' - ',$persona['dep_nm'],' / ',$persona['user_puesto'].'</option>';
                                            }
                                        endforeach
                                    ?>
                                </select>
                                <label for="user_id">Conductor*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control focus"  type="number"  id="licencia_num" name="licencia_num"  required>
                                <label for="licencia_num">Número de Licencia*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="licencia_cad" name="licencia_cad" data-date-format="dd-mm-yyyy"  placeholder="dd-mm-yyyy" required>
                                <label for="req_fecha">Licencia Vencimiento*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Conductor</button>
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
