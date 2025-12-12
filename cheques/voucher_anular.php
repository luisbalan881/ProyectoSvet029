<?php
include_once '../inc/functions.php';
include_once '../proveedores/funciones_proveedores.php';
include_once 'funciones_cheques.php';
include_once 'inc/Account.php';
include_once 'inc/Voucher.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    $u = usuarioPrivilegiado();
    if ($u->hasPrivilege('anularCheques')):
        $id = null;
        $cuentas = array();
        $proveedores = array();
        $voucher = array();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $voucher = Voucher::getById(usuarioPrivilegiado(),$id);
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_21");
        }
        if ( !empty($_POST)) {
            Voucher::invalidate(usuarioPrivilegiado(),$voucher['cta_id'],$voucher['vchr_fecha'],$voucher['vchr_num'],$voucher['vchr_monto'],$voucher['vchr_desc'],$voucher['prov_id'],$_SESSION['user_id'],$voucher['vchr_autoriza'],0,$id);
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
            <title>Voucher Anular</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Anular Voucher</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-voucher form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <input type="number"  id="vchr_id" name="vchr_id" value="<?php echo $voucher['vchr_id'] ?>" title="vchr_id" hidden readonly>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="cta_id" id="cta_id"  style="width: 100%;" data-placeholder="-- Seleccionar Cuenta --" disabled>
                                    <option></option>
                                    <?php
                                    foreach ($cuentas as $cuenta):
                                            echo '<option value="'.$cuenta["cta_id"].'" '.(($cuenta["cta_status"] == 0)? 'disabled':'').' '.(($cuenta["cta_id"] == $voucher["cta_id"])?'selected':'').'>'.$cuenta["cta_num"].' - '.$cuenta['cta_titular'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="cta_id">Cuenta</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="prov_id" id="prov_id"  style="width: 100%;" data-placeholder="-- Seleccionar Proveedor --" disabled>
                                    <option></option>
                                    <?php
                                    foreach ($proveedores as $proveedor):
                                        echo '<option value="'.$proveedor["prov_id"].'" '.(($proveedor["prov_status"] == 0)? 'disabled':'').' '.(($proveedor["prov_id"] == $voucher["prov_id"])?'selected':'').'>'.$proveedor["prov_nm"].' / NIT: '.$proveedor['prov_nit'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="prov_id">Proveedor</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="vchr_fecha" name="vchr_fecha" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($voucher['vchr_fecha']) ?>" disabled>
                                <label for="vchr_fecha">Fecha</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material">
                                <input class="form-control"  type="number"  id="vchr_num" name="vchr_num" value="<?php echo $voucher['vchr_num'] ?>" readonly>
                                <label for="vchr_num">No. Cheque</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material input-group">
                                <span class="input-group-addon"><strong>Q</strong></span>
                                <input class="form-control"  type="number"  id="vchr_monto" name="vchr_monto" value="<?php echo $voucher['vchr_monto'] ?>" readonly>
                                <label for="vchr_monto">Monto</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="vchr_desc" name="vchr_desc" rows="3" readonly><?php echo $voucher['vchr_desc'] ?></textarea>
                                <label for="vchr_desc">Descripción</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text"  id="vchr_realiza" name="vchr_realiza" value="<?php echo $u->persona['user_nm']; ?>" readonly>
                                <label for="vchr_realiza">Realizado por</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="text"  id="vchr_autoriza" name="vchr_autoriza" value="<?php echo $voucher['vchr_autoriza'] ?>" readonly>
                                <label for="vchr_autoriza">Autorizado por</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <p class="text_center">¿Esta seguro de <span class="text-danger">ANULAR</span> el <i>voucher</i>? Esta acción no es reversible.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 text-center">
                            <a href="?ref=_21"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
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
