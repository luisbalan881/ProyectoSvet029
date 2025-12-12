<?php
include_once '../inc/functions.php';
include_once 'inc/CouponDispatch.php';
include_once 'inc/Vehicle.php';
include_once 'inc/Driver.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearCupon')):
        $id = null;
        $coupon = array();
        $vehicles = Vehicle::getAll(usuarioPrivilegiado());
        $drivers = Driver::getAll(usuarioPrivilegiado());
        $users = personas();
        $coupons_next = CouponDispatch::getNextAll(usuarioPrivilegiado());
        if(!empty($_GET['id'])){
            $id = $_REQUEST['id'];
            $coupon = CouponDispatch::getByID(usuarioPrivilegiado(),$id);
            array_unshift($coupons_next,array(
               'cupon_ing_id' => $coupon['cupon_ing_id'],
                'num' => $coupon['num'],
                'monto' => $coupon['monto'],
                'status' => '1'

            ));
        }
        if(null == $id){
            header("Location: index.php?ref=_42");
        }
        if ( !empty($_POST)) {
            CouponDispatch::update(usuarioPrivilegiado(),fecha_ymd($_POST['fecha']),$_POST['cupon_ing_id'],$_POST['vehiculo_id'],$_POST['conductor_id'],$_POST['usuario_id'],$_POST['km_inicio'],$_POST['km_fin'],$_POST['galones'],1,$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_42");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Cupón Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Cupón</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-cupones-ing-update form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="fecha" name="fecha" data-date-language="es-ES"  data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($coupon['fecha']) ?>" required>
                                <label for="cdto_fecha">Fecha*</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="cupon_ing_id" id="cupon_ing_id"  style="width: 100%;" data-placeholder="-- Seleccionar Cupón --" required>
                                    <?php
                                    foreach ($coupons_next as $next):
                                        echo '<option value="'.$next["cupon_ing_id"].'" '.(($next["cupon_ing_id"] == $coupon['cupon_ing_id'])? 'selected':'').'> No. '.$next["num"].' - Q '.number_format($next['monto'],2).'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="cupon_ing_id">Cupón*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="vehiculo_id" id="vehiculo_id"  style="width: 100%;" data-placeholder="-- Seleccionar Vehículo --" required>
                                    <option></option>
                                    <?php
                                    foreach ($vehicles as $vehicle):
                                        echo '<option value="'.$vehicle["vehiculo_id"].'" '.(($vehicle["vehiculo_id"] == $coupon["vehiculo_id"])? 'selected':'').' '.(($vehicle['status'] == 0)?'disabled': '').'>'.$vehicle["placa"].' - '.$vehicle["nombre"].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="vehiculo_id">Vehículo*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="conductor_id" id="conductor_id"  style="width: 100%;" data-placeholder="-- Seleccionar Conductor --" required>
                                    <option></option>
                                    <?php
                                    foreach ($drivers as $driver):
                                        echo '<option value="'.$driver["conductor_id"].'" '.(($driver["conductor_id"] == $coupon["conductor_id"])? 'selected':'').' '.(($driver['status'] == 0)?'disabled': '').'>'.$driver["nombre"].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="conductor_id">Conductor*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="usuario_id" id="usuario_id"  style="width: 100%;" data-placeholder="-- Seleccionar Usuario --" required>
                                    <option></option>
                                    <?php
                                    foreach ($users as $user):
                                        echo '<option value="'.$user['user_id'].'" '.(($user["user_id"] == $coupon["usuario_id"])? 'selected':'').' '.(($user['user_status'] == 0)?'disabled': '').'>'.$user['user_nm1'].' '.$user['user_nm2'].' '.$user['user_ap1'].' '.$user['user_ap2'].'</option>';
                                    endforeach
                                    ?>
                                </select>
                                <label for="usuario_id">Usuario*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="km_inicio" name="km_inicio" value="<?php echo number_format($coupon['km_inicial'],2) ?>" onchange="document.getElementById('km_fin').min=this.value;">
                                <label for="km_inicio">KM Inicial</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="km_fin" name="km_fin" value="<?php echo number_format($coupon['km_final'],2) ?>" onchange="document.getElementById('km_inicio').max=this.value;">
                                <label for="km_fin">KM Final</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                        <div class="col-xs-4">
                            <div class="form-material form-material-success  input-group">
                                <input class="form-control"  type="number"  id="galones" name="galones" value="<?php echo number_format($coupon['galones_consumidos'],2) ?>">
                                <label for="galones">Galones Consumidos</label>
                                <span class="input-group-addon"><i class=""></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-warning btn-block" type="submit"><i class=""></i>Guardar cambios</button>
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
