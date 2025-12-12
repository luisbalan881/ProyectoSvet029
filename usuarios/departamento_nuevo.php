<?php
include_once '../inc/functions.php';
include_once 'funciones_usuarios.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearUsuario')):
        if (!empty($_POST)){
            departamento_nuevo();
            header("Location: index.php?ref=_36");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Departamento Nuevo</title>
        </head>
        <body>
        <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Crear Nuevo Departamento</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-material form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text" id="dep_nm" name="dep_nm"  required>
                                <label for="dep_nm">Nombre*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="dep_encargado" id="dep_encargado"  style="width: 100%;" data-placeholder="-- Seleccionar Director --">
                                    <option></option>
                                    <?php
                                    foreach (personas() as $persona) {
                                        if ($persona['user_status'] == 1) {
                                            echo '<option value="' . $persona["user_id"] . '">'.$persona["user_nm1"] .' '.$persona['user_nm2'].' '. $persona['user_ap1'].' '.$persona['user_ap2'].' ('.$persona["user_puesto"].')'.'</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="dep_encargado">Director/Jefe de Departamento</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Departamento</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Page JS Code -->
        <script>
            jQuery(function(){
                // Init page helpers (Select2)
                App.initHelpers('select2');
            });
        </script>
        <script src="assets/js/pages/base_forms_validation.js"></script>
        </body>
        </html>
        <?php
        else:
        echo include(unauthorizedModal());
    endif;
else:
    header("Location: index.php");
endif;
?>
