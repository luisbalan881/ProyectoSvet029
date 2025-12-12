<?php
include_once '../inc/functions.php';
include_once 'inc/Bank.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarCheques')):
        $id = null;
        $banco = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
          $banco = Bank::getBankById($id);
        }

        if ( null==$id ) {
          header("Location: index.php?ref=_16");
        }

        if ( !empty($_POST)) {
            Bank::updateBank(usuarioPrivilegiado(),$_POST['bc_nombre'],$_POST['bc_status'],$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_16");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Banco Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Banco</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-banco form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="bc_nombre" name="bc_nombre"  value="<?php echo $banco->bank['name']; ?>" required>
                                <label for="bc_nombre">Nombre</label>
                                <div class="help-block text-right">Ingresar nombre del banco.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                          <label class="css-input switch switch-success">
                            <input name="bc_status" type="checkbox"  <?php echo (($banco->bank['status'] == 1)?'checked':''); ?> value="1"><span></span>Banco Activo
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
          <script src="assets/js/pages/cheque_forms_validation.js"></script>
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
