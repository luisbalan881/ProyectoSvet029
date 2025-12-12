<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
        include_once 'inc/CouponDispatch.php';
        include_once 'inc/Vehicle.php';
        include_once 'inc/Driver.php';
        include_once 'funciones_cupones.php';
        $vehicles = Vehicle::getAll($u);
        $drivers = Driver::getAll($u);
        $users = cupones_usuarios();
        $coupons_next = CouponDispatch::getNextAll($u);
        $coupons_egr = CouponDispatch::getAll($u);
        date_default_timezone_set('America/Guatemala');
        $fecha = date('d-m-Y',time());
    ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        Egreso de Cupones
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Control de Cupones</li>
                        <li><a class="link-effect" href="#">Egreso de Cupones</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Pedido -->
            <div class="row">
                <!-- Ingreso Producto -->
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-success">
                          <h3 class="block-title">Nuevo Egreso</h3>
                      </div>
                      <div class="block-content block-content-full">
                        <form class="js-validation-cupones-egr form-horizontal push-10-t push-10" action="combustible/cupon_egr_nuevo.php" method="post">
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <div class="form-material">
                                        <input class="js-datepicker form-control" type="text" id="fecha" name="fecha" data-date-language="es-ES"  data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $fecha ?>" required>
                                        <label for="cdto_fecha">Fecha*</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-material">
                                        <select class ="js-select2 form-control" name="cupon_key" id="cupon_key"  style="width: 100%;" data-placeholder="-- Seleccionar Cupón --" required>
                                            <option></option>
                                            <?php
                                            foreach ($coupons_next as $key => $coupon):
                                                echo '<option value="'.$key.'">No. '.$coupon["num"].' - Q '.number_format($coupon['monto'],2).'</option>';
                                            endforeach
                                            ?>
                                        </select>
                                        <label for="cupon_key">Cupón*</label>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-material">
                                        <input class="form-control" type="number" id="cantidad" name="cantidad"  value="1" required>
                                        <label for="cantidad">Cantidad*</label>
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
                                                echo '<option value="'.$vehicle['vehiculo_id'].'" '.(($vehicle['status'] == 0)?'disabled': '').'>'.$vehicle['placa'].' - '.$vehicle['nombre'].' '.$vehicle['linea'].'</option>';
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
                                                echo '<option value="'.$driver["conductor_id"].'" '.(($driver['status'] == 0 || new DateTime() > new DateTime ($driver['licencia_cad']))?'disabled': '').'>'.$driver["nombre"].' - '.$driver["licencia_num"].' / '.fecha_dmy($driver["licencia_cad"]).'</option>';
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
                                                echo '<option value="'.$user['user_id'].'" '.(($user['user_status'] == 0)?'disabled': '').'>'.$user['user_nm1'].' '.$user['user_nm2'].' '.$user['user_ap1'].' '.$user['user_ap2'].' - '.$user["dep_nm"].' / '.$user["user_puesto"].'</option>';
                                            endforeach
                                            ?>
                                        </select>
                                        <label for="usuario_id">Usuario*</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                              <div class="col-xs-12 text-center">
                                  <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Entregar Cupones</button>
                              </div>
                            </div>
                        </form>
                      </div>
                  </div>
                <!-- END Ingreso Producto -->
            </div>
            <!-- END Factura -->
            <!-- Todos los Ingresos -->
            <div class="block">
              <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <h3 class="block-title">Cupones Entregados</h3>
              </div>
              <div class="block-content">
                  <table class="table table-bordered table-condensed table-striped table-vcenter js-dataTable-cupones-despacho display nowrap dt-responsive" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th class="text-center">Cupón No.</th>
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Valor</th>
                              <th class="text-center">Vehículo</th>
                              <th class="text-center">Placa</th>
                              <th class="text-center">Conductor</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">KM Inicial/Final</th>
                              <th class="text-center">KM Recorridos</th>
                              <th class="text-center">Galones Consumidos</th>
                              <th class="text-center">KM por Galón</th>
                              <?php
                                if($u->hasPrivilege('modificarCupon')){
                                    echo '<th class="text-center">Acción</th>';
                                }
                              ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                            $index = 0;
                            $total_cupones = 0.00;
                            foreach ($coupons_egr as $coupon){
                                (($coupon['status'] == 1)? $total_cupones += $coupon['monto']: $total_cupones);
                                    echo '<tr '.(($coupon['status'] == 0)? 'class="danger"':'').'>';
                                    echo '<td class="text-left"><strong>'.$coupon['num'].'</strong></td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($coupon['fecha']).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($coupon['monto'],2).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$coupon['nombre'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$coupon['placa'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$coupon['conductor_nombre'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$coupon['usuario_nombre'].'</td>';
                                    echo '<td class="text-center">'.number_format($coupon['km_inicial'],2).'/'.number_format($coupon['km_final'],2).'</td>';
                                    echo '<td class="text-center">'.number_format($coupon['km_recorridos'],2).'</td>';
                                    echo '<td class="text-center">'.number_format($coupon['galones_consumidos'],2).'</td>';
                                    echo '<td class="text-center">'.number_format($coupon['km_galon'],2).'</td>';
                                    if($u->hasPrivilege('modificarCupon')) {
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<span data-toggle="tooltip" title="Editar"><a  class="btn btn-default" '.(($coupon['status'] == 0) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupon_egr_modificar.php?id='.$coupon['cupon_egr_id'].'"') . '><i class="fa fa-edit text-warning"></i></a></span>';
                                        echo ' ';
                                        echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" '.(($coupon['status'] == 0) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupon_egr_borrar.php?id='. $coupon['cupon_egr_id'].'"') . '><i class="fa fa-trash  text-danger"></a></span>';
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                            }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                            <td class="text-right"><h4>Total</h4></td>
                            <td></td>
                            <td class="text-center" style="white-space: nowrap;"><strong>Q <?php echo number_format($total_cupones,2); ?></strong></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <?php if($u->hasPrivilege('modificarCupon')){ echo '<td class="text-center"></td>'; } ?>
                        </tr>
                      </tfoot>
                  </table>
              </div>
            </div>
            <!-- Final Todos los Ingresos -->
        </div>
        <!-- FIN Contenido de Pagina -->
    <?php
    else :
        echo include(unauthorized());
    endif;
else:
header("Location: index.php");
endif;
?>