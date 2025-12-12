<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $id = null;
        $renglon = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $renglon = renglon_info($id);
        }

        if ( null==$id ) {
            header("Location: index.php?ref=_2");
        }

        if ( !empty($_POST)) {
            renglon_modificar($id);
            header("Location: index.php?ref=_2");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Renglón Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Renglón</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-renglon form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="renglon_id" name="renglon_id" value="<?php echo $renglon['renglon_id'] ?>" disabled>
                                <label for="renglon_id">Renglón ID*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control focus"  type="text"  id="renglon_nm" name="renglon_nm"  value="<?php echo $renglon['renglon_nm'] ?>" required>
                              <label for="renglon_nm">Título del Renglón*</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-success">
                                <input name="renglon_status" type="checkbox"  <?php echo (($renglon['renglon_status'] == 1)?'checked':""); ?> value="1"><span></span>Renglón Activo
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
          <script src="assets/js/pages/almacen_forms_validation.js"></script>
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
