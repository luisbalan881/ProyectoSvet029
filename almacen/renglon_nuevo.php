<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen')):
        if ( !empty($_POST)) {
          renglon_nuevo();
          header("Location: index.php?ref=_2");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Renglón Nuevo</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Crear Nuevo Renglón</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-renglon form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="renglon_id" name="renglon_id"  required>
                                <label for="renglon_id">Renglón ID*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="renglon_nm" name="renglon_nm"  required>
                                <label for="renglon_nm">Título del Renglón*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Renglón</button>
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
