<?php
include_once '../inc/functions.php';
include_once 'inc/CouponApplication.php';
include_once 'funciones_cupones.php';
include_once '../proveedores/funciones_proveedores.php';
include_once '../cheques/inc/Account.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):
        $id = null;
        $application = array();
        $cuentas = array();
        $proveedores = array();
        if(!empty($_GET['id'])){
            $id = $_REQUEST['id'];
            $application = CouponApplication::getByID(usuarioPrivilegiado(),$id);
        }
        if(null == $id){
            header("Location: index.php?ref=_40");
        }
        if ( !empty($_POST)) {
            CouponApplication::validate(usuarioPrivilegiado(),$_POST['cta_id'],fecha_ymd($_POST['fecha']),$_POST['fac_serie'],$_POST['fac_num'],$_POST['pedido_num'],$_POST['codigo'],$_POST['prov_id'],$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_41&id=".$id);
        }else{
            $cuentas = Account::getAll();
            $proveedores = proveedores();
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Cupones Pedido Congelar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-primary">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Congelar Pedido de Cupones</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-pedido form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <input type="text"  id="cupon_pedido_id" name="cupon_pedido_id"  value="<?php echo $application->application['application_id']; ?>" title="cupon_pedido_id" hidden>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="cta_id" id="cta_id"  style="width: 100%;" data-placeholder="-- Seleccionar Cuenta --" required>
                                    <option></option>
                                    <?php
                                    foreach ($cuentas as $cuenta):
                                        echo '<option value="'.$cuenta["cta_id"].'" '.(($cuenta["cta_status"] == 0)? 'disabled':'').' '.(($cuenta["account"] == $application->application["cta_id"])?'selected':'').'>'.$cuenta["cta_num"].' - '.$cuenta['cta_titular'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="cta_id">Número de cuenta*</label>
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
                                        echo '<option value="'.$proveedor["prov_id"].'" '.(($proveedor["prov_status"] == 0)? 'disabled':'').' '.(($proveedor["prov_id"] == $application->application["provider"])?'selected':'').'>'.$proveedor["prov_nm"].' / NIT: '.$proveedor['prov_nit'].'</option>';
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
                                <input class="js-datepicker form-control" type="text" id="fecha" name="fecha"  data-date-language="es-ES" data-date-format="dd-mm-yyyy"  placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($application->application['date']) ?>" required>
                                <label for="fecha">Fecha*</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="fac_serie" name="fac_serie"  value="<?php echo $application->application['fac_serie'] ?>" required>
                                <label for="fac_serie">Factura Serie*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="fac_num" name="fac_num"  value="<?php echo $application->application['fac_num'] ?>" required>
                                <label for="fac_num">Factura Número*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="codigo" name="codigo"  value="<?php echo $application->application['code'] ?>" required>
                                <label for="pedido_num">Código*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="pedido_num" name="pedido_num"  value="<?php echo $application->application['number'] ?>" required>
                                <label for="pedido_num">Pedido Número*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-primary btn-block" type="submit"><i class=""></i>Congelar Pedido</button>
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
          <script src="assets/js/pages/coupons_forms_validation.js"></script>
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
