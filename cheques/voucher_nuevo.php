<?php
include_once '../inc/functions.php';
include_once '../proveedores/funciones_proveedores.php';
include_once 'funciones_cheques.php';
include_once 'inc/Account.php';
include_once 'inc/Voucher.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    $u = usuarioPrivilegiado();
    if ($u->hasPrivilege('crearCheques')):
        $cuentas = array();
        $proveedores = array();
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d-m-Y',time());
        if ( !empty($_POST)) {
            Voucher::create(usuarioPrivilegiado(),$_POST['cta_id'],fecha_ymd($_POST['vchr_fecha']),$_POST['vchr_num'],$_POST['vchr_monto'],$_POST['vchr_desc'],$_POST['prov_id'],$_SESSION['user_id'],$_POST['vchr_autoriza']);
            header("Location: index.php?ref=_21");
        }else{
            $cuentas = Account::getAll();
            $proveedores = proveedores();
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Voucher Nuevo</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Crear Nuevo Voucher</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-voucher form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="cta_id" id="cta_id"  style="width: 100%;" data-placeholder="-- Seleccionar Cuenta --" required>
                                    <option></option>
                                    <?php
                                    foreach ($cuentas as $cuenta):
                                            echo '<option value="'.$cuenta["cta_id"].'" '.(($cuenta["cta_status"] == 0)? 'disabled':'').'>'.$cuenta["cta_num"].' - '.$cuenta['cta_titular'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="cta_id">Cuenta*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="prov_id" id="prov_id"  style="width: 100%;" data-placeholder="-- Seleccionar Proveedor --" required>
                                    <option></option>
                                    <?php
                                    foreach ($proveedores as $proveedor):
                                        echo '<option value="'.$proveedor["prov_id"].'" '.(($proveedor["prov_status"] == 0)? 'disabled':'').'>'.$proveedor["prov_nm"].' / NIT: '.$proveedor['prov_nit'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="prov_id">Proveedor*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="vchr_fecha" name="vchr_fecha" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $fecha ?>" required>
                                <label for="vchr_fecha">Fecha*</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material">
                                <input class="form-control"  type="number"  id="vchr_num" name="vchr_num" min="1" value="<?php echo Voucher::nuevoVoucherNum() ?>" required>
                                <label for="vchr_num">No. Cheque*</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material input-group">
                                <span class="input-group-addon"><strong>Q</strong></span>
                                <input class="form-control"  type="number"  id="vchr_monto" name="vchr_monto" min="0.01" required>
                                <label for="vchr_monto">Monto*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="vchr_desc" name="vchr_desc" rows="3" ></textarea>
                                <label for="vchr_desc">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text"  id="vchr_realiza" name="vchr_realiza" value="<?php echo $u->persona['user_nm']; ?>" disabled>
                                <label for="vchr_realiza">Realizado por</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text"  id="vchr_autoriza" name="vchr_autoriza" value="Secretario General" required>
                                <label for="vchr_autoriza">Autorizado por*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Voucher</button>
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
