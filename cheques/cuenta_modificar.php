<?php
include_once '../inc/functions.php';
include_once 'inc/Bank.php';
include_once 'inc/Account.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarCheques')):
        $id = null;
        $cuenta = array();
        $bancos = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $cuenta = Account::getByID($id);
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_17");
        }
        if ( !empty($_POST)) {
            Account::update(usuarioPrivilegiado(),$_POST['cta_titular'],$_POST['cta_num'],$_POST['bc_id'],$_POST['cta_status'],$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_17");
        }else{
            $bancos = Bank::getBankAll();
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Cuenta Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Crear Nueva Cuenta</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-banco form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="bc_id" id="bc_id"  style="width: 100%;" data-placeholder="-- Seleccionar Banco --" required>
                                    <option></option>
                                    <?php
                                    foreach ($bancos as $banco):
                                            echo '<option value="'.$banco["bc_id"].'" '.(($banco["bc_id"] == $cuenta->account['bank_id'])? 'selected':'').' '.(($banco["bc_status"] == 0)? 'disabled':'').'>'.$banco["bc_nombre"].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="bc_id">Banco*</label>
                                <div class="help-block text-right">Seleccionar banco.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control focus"  type="text"  id="cta_titular" name="cta_titular" value="<?php echo $cuenta->account['title']?>" required>
                              <label for="cta_titular">Titular*</label>
                              <div class="help-block text-right">Ingrese nombre titular de la cuenta.</div>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="cta_num" name="cta_num"  value="<?php echo $cuenta->account['number']?>" required>
                                <label for="cta_num">Número de Cuenta*</label>
                                <div class="help-block text-right">Ingrese número de cuenta.</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <label class="css-input switch switch-success">
                                <input name="cta_status" type="checkbox"  <?php echo (($cuenta->account['status'] == 1)?'checked':''); ?> value="1"><span></span>Cuenta Activa
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
                  App.initHelpers(['select2']);
              });
          </script>
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
