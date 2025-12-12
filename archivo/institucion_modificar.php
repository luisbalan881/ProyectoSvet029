<?php
include_once '../inc/functions.php';
include_once 'funciones_archivo.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarInstitucion')):
        $id = null;
        $institucion = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
          $institucion = institucionById($id);
        }

        if ( null==$id ) {
          header("Location: index.php?ref=_29");
        }

        if ( !empty($_POST)) {
          institucion_modificar($id);
          header("Location: index.php?ref=_29");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Institución Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Institución</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-documento form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                    <input type="text"  id="inst_id" name="inst_id"  value="<?php echo $institucion['inst_id']; ?>" hidden title="inst_id">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text" id="inst_nombre" name="inst_nombre" value="<?php echo $institucion['inst_nombre']; ?>" required>
                                <label for="inst_nombre">Nombre de la institución*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control"  type="text" id="inst_abrev" name="inst_abrev" value="<?php echo $institucion['inst_abrev']; ?>" >
                                <label for="inst_abrev">Abreviatura</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control"  type="text" id="inst_direccion" name="inst_direccion" value="<?php echo $institucion['inst_direccion']; ?>" >
                                <label for="inst_direccion">Dirección</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control"  type="text" id="inst_tel" name="inst_tel" value="<?php echo $institucion['inst_tel']; ?>" >
                                <label for="inst_tel">Teléfono</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control"  type="text" id="inst_web" name="inst_web" value="<?php echo $institucion['inst_web']; ?>" >
                                <label for="inst_web">Página web</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-success">
                                <input name="inst_status" type="checkbox"  <?php echo (($institucion['inst_status'] == 1)?'checked':''); ?> value="1"><span></span>Institución Activo
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
          <script src="assets/js/pages/archivo_forms_validation.js"></script>
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
