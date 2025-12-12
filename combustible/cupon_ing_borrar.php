<?php
include_once '../inc/functions.php';
include_once 'inc/Coupon.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):
        $id = null;
        $coupon = array();
        if(!empty($_GET['id'])){
            $id = $_REQUEST['id'];
            $coupon = Coupon::getByID(usuarioPrivilegiado(),$id);
        }
        if(null == $id){
            header("Location: index.php?ref=_40");
        }
        if ( !empty($_POST)) {
            Coupon::update(usuarioPrivilegiado(),$coupon['cupon_pedido_id'],fecha_ymd($_POST['fecha_inicio']),fecha_ymd($_POST['fecha_fin']),$_POST['numero'],$_POST['costo'],0,$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_41&id=".$coupon['cupon_pedido_id']);
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Cupón Eliminar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Eliminar Cupón</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-ing-update form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="numero" name="numero" value="<?php echo $coupon['num']; ?>" readonly>
                                <label for="numero">Cupón No.</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material form-material-success  input-group">
                                <span class="input-group-addon"><strong>Q</strong></span>
                                <input class="form-control"  type="number"  id="costo" name="costo" min="0" value="<?php echo number_format($coupon['monto']); ?>" readonly>
                                <label for="costo">Costo unitario</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="fecha_inicio">Fecha validez de cupones</label>
                        <div class="col-md-8">
                            <div class="input-daterange input-group" data-date-format="dd-mm-yyyy">
                                <input class="form-control" type="text" id="fecha_inicio" name="fecha_inicio" value="<?php echo fecha_dmy($coupon['fecha_emision']); ?>" placeholder="Desde" disabled>
                                <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                                <input class="form-control" type="text" id="fecha_fin" name="fecha_fin" value="<?php echo fecha_dmy($coupon['fecha_cad']); ?>" placeholder="A" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <p class="text_center">¿Esta seguro de <span class="text-danger">BORRAR</span> el cupón? Esta acción no es reversible.</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6 text-center">
                            <a href="?ref=_41&id=<?php echo $coupon['cupon_pedido_id'] ?>"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
                        </div>
                        <div class="col-xs-6 text-center">
                            <button class="btn btn-sm btn-danger btn-block" type="submit"><i class=""></i>SI, BORRAR</button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
          <!-- Page JS Code -->
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
