<?php
include_once '../inc/functions.php';
include_once 'funciones_archivo.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarTipoArchivo')):
        $id = null;
        $archivoTipo = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
          $archivoTipo = archivoTipoById($id);
        }

        if ( null==$id ) {
          header("Location: index.php?ref=_30");
        }

        if ( !empty($_POST)) {
          archivoTipoModificar($id);
          header("Location: index.php?ref=_30");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Tipo de Archivo Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Tipo de Archivo</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-documento form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                    <input type="text"  id="tipo_id" name="tipo_id"  value="<?php echo $archivoTipo['tipo_id']; ?>" hidden title="tipo_id">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text" id="tipo_nombre" name="tipo_nombre" value="<?php echo $archivoTipo['tipo_nombre']; ?>" required>
                                <label for="tipo_nombre">Nombre*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-success">
                                <input name="tipo_status" type="checkbox"  <?php echo (($archivoTipo['tipo_status'] == 1)?'checked':''); ?> value="1"><span></span>Tipo de Archivo Activo
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
