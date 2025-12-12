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
            CouponApplication::invalidate(usuarioPrivilegiado(),$_POST['comentario'],$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_40");
        }else{
            $cuentas = Account::getAll();
            $proveedores = proveedores();
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Cupones Pedido Anular</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Pedido Anular</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-pedido form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="cta_id" id="cta_id"  style="width: 100%;" data-placeholder="-- Seleccionar Cuenta --" disabled>
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
                                <select class ="js-select2 form-control" name="prov_id" id="prov_id"  style="width: 100%;" data-placeholder="-- Seleccionar Proveedor --" disabled>
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
                                <input class="js-datepicker form-control" type="text" id="fecha" name="fecha" data-date-format="dd-mm-yyyy"  placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($application->application['date']) ?>" disabled>
                                <label for="fecha">Fecha*</label>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="text"  id="fac_serie" name="fac_serie"  value="<?php echo $application->application['fac_serie'] ?>" disabled>
                                <label for="fac_serie">Factura Serie*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="fac_num" name="fac_num"  value="<?php echo $application->application['fac_num'] ?>" disabled>
                                <label for="fac_num">Factura Número*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="codigo" name="codigo"  value="<?php echo $application->application['code'] ?>" disabled>
                                <label for="pedido_num">Código*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="pedido_num" name="pedido_num"  value="<?php echo $application->application['number'] ?>" disabled>
                                <label for="pedido_num">Pedido Número*</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="comentario" name="comentario" rows="3" required></textarea>
                                <label for="comentario">Comentario de Anulación</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <p class="text_center">¿Esta seguro de <span class="text-danger">ANULAR</span> el pedido? Esta acción no es reversible.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 text-center">
                            <a href="?ref=_40"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
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
