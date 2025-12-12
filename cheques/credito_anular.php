<?php
include_once '../inc/functions.php';
include_once 'inc/Account.php';
include_once 'inc/Credit.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('anularCheques')):
        $id = null;
        $cuentas = array();
        $credito = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $credito = Credit::getById(usuarioPrivilegiado(),$id);
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_19");
        }

        if ( !empty($_POST)) {
            Credit::update(usuarioPrivilegiado(),$credito['cta_id'],$credito['cdto_fecha'],$credito['cdto_monto'],$credito['cdto_desc'],0,$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_19");
        }else{
            $cuentas = Account::getAll();
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Crédito Anular</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Anular Crédito</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-credito form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="cta_id" id="cta_id"  style="width: 100%;" data-placeholder="-- Seleccionar Cuenta --" readonly>
                                    <option></option>
                                    <?php
                                    foreach ($cuentas as $cuenta):
                                            echo '<option value="'.$cuenta["cta_id"].'" '.(($cuenta["cta_status"] == 0)? 'disabled':'').' '.(($cuenta["cta_id"] == $credito['cta_id'])? 'selected':'').'>'.$cuenta["cta_num"].' - '.$cuenta['cta_titular'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="cta_id">Cuenta</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="cdto_fecha" name="cdto_fecha" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($credito['cdto_fecha']) ?>" readonly>
                                <label for="cdto_fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <span class="input-group-addon"><strong>Q</strong></span>
                                <input class="form-control"  type="number"  id="cdto_monto" name="cdto_monto" value="<?php echo $credito['cdto_monto'] ?>" readonly>
                                <label for="cdto_monto">Monto</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="cdto_desc" name="cdto_desc" rows="3" readonly><?php echo $credito['cdto_desc'] ?></textarea>
                                <label for="cdto_desc">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <p class="text_center">¿Esta seguro de <span class="text-danger">ANULAR</span> el crédito? Esta acción no es reversible.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 text-center">
                            <a href="?ref=_19"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
                        </div>
                        <div class="col-xs-6 text-center">
                            <button class="btn btn-sm btn-danger btn-block" type="submit"><i class=""></i>SI, ANULAR</button>
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
