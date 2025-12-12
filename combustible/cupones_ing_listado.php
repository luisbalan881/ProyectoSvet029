<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
        include_once 'inc/CouponApplication.php';
        include_once 'inc/Coupon.php';
        $id = null;
        $application = array();
        $application_total = 0.00;
        $coupons = array();
        $pedido = array();
        if (!empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $pedido = CouponApplication::getByID($u,$id);
            $coupons = Coupon::getByApplication($u,$id);
        }
        if (null==$id ){
            //echo "<script type='text/javascript'> window.location='index.php?ref=_40'; </script>";
        }
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
                        Ingreso de Cupones
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Control de Cupones</li>
                        <li><a class="link-effect" href="?ref=_40">Cupones</a></li>
                        <li><a class="link-effect" href="#">Ingreso de Cupones</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Pedido -->
            <div class="row">
                <div class="col-lg-3">
                    <!-- Información Pedido -->
                    <div class="block block-themed block-rounded">
                        <div class="block-header bg-primary">
                            <h3 class="block-title">Pedido</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="h4 push-5"><?php echo $pedido->application['provider_nm'];?></div>
                            <article>
                                <?php
                                    echo '<span style="font-weight:bold;">NIT: </span>'.$pedido->application['provider_nit'].'<br>';
                                    echo '<span style="font-weight:bold;">Factura: </span>'.$pedido->application['fac_serie'].' '.$pedido->application['fac_num'].'<br>';
                                    echo '<span style="font-weight:bold;">Fecha: </span>'.fecha_dmy($pedido->application['date']).'<br>';
                                    echo '<span style="font-weight:bold;">Número de Pedido: </span>'.$pedido->application['number'].'<br>';
                                    echo '<span style="font-weight:bold;">Código de Cliente: </span>'.$pedido->application['code'].'<br>';
                                ?>
                            </article>
                            <?php
                                if($pedido->application['status'] == 2 && $u->hasPrivilege('modificarCupon')){
                                echo '<br><a class="btn btn-rounded btn-primary btn-block" '.(($pedido->application['status'] != 2 )?'href="#" disabled':'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupones_pedido_congelar.php?id='.$pedido->application['application_id'].'" ').'><i class="fa fa-check"></i> Congelar Pedido</a>';
                                }else if($pedido->application['status'] == 1 && $u->hasPrivilege('modificarCupon')){
                                echo '<br><a class="btn btn-rounded btn-warning btn-block" '.(($pedido->application['status'] != 1 )?'href="#" disabled':'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupones_pedido_modificar.php?id='.$pedido->application['application_id'].'" ').'><i class="fa fa-check"></i> Modificar Pedido</a>';
                                }
                            ?>
                        </div>
                    </div>
                    <!-- END Información Pedido -->
                </div>
                <div class="col-lg-9">
                    <!-- Ingreso Cupones -->
                    <?php if ($pedido->application['status'] == 2 && $u->hasPrivilege('crearCupon')): ?>
                  <div class="block block-themed block-rounded">
                      <div class="block-header bg-success">
                          <h3 class="block-title">Nuevo Ingreso</h3>
                      </div>
                      <div class="block-content block-content-full">
                        <form class="js-validation-cupones-ing form-horizontal push-10-t push-10" action="combustible/cupon_ing_nuevo.php?id=<?php echo $id;?>" method="post">
                            <input type="text"  id="cupon_pedido_id" name="cupon_pedido_id"  value="<?php echo $pedido->application['application_id']; ?>" title="cupon_pedido_id" hidden>
                            <div class="form-group">
                                <div class="col-xs-4">
                                    <div class="form-material form-material-success  input-group">
                                        <input class="form-control"  type="number"  id="cupon_inicio" name="cupon_inicio"  min="0"  required onchange="document.getElementById('cupon_fin').min=this.value;">
                                        <label for="cupon_inicio">Cupón No. Inicial*</label>
                                        <span class="input-group-addon"><i class=""></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-material form-material-success  input-group">
                                        <input class="form-control"  type="number"  id="cupon_final" name="cupon_fin"  required  onchange="document.getElementById('cupon_inicio').max=this.value;">
                                        <label for="cupon_final">Cupón No. Final*</label>
                                        <span class="input-group-addon"><i class=""></i></span>
                                    </div>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-material form-material-success  input-group">
                                        <span class="input-group-addon"><strong>Q</strong></span>
                                        <input class="form-control"  type="number"  id="costo" name="costo" min="0" required>
                                        <label for="costo">Costo unitario*</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-xs-6">
                                    <div class="form-material">
                                        <input class="js-datepicker form-control" type="text" id="fecha_inicio" name="fecha_inicio"   data-date-language="es-ES" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                        <label for="fecha_inicio">Fecha Emisión</label>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-material">
                                        <input class="js-datepicker form-control" type="text" id="fecha_fin" name="fecha_fin"   data-date-language="es-ES" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                        <label for="fecha_fin">Fecha Vencimiento</label>
                                    </div>
                                </div>
                            </div>
                          <div class="form-group">
                              <div class="col-xs-12 text-center">
                                  <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Agregar Cupones</button>
                              </div>
                          </div>
                        </form>
                      </div>
                  </div>
                    <?php endif; ?>
                <!-- END Ingreso Cupones -->
                </div>
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
                  <h3 class="block-title">Listado de Cupones</h3>
              </div>
              <div class="block-content">
                  <table class="table table-bordered table-striped js-dataTable-cupones-ing display nowrap dt-responsive" cellspacing="0" width="100%">
                      <thead>
                          <tr>
                              <th class="text-center">Cupón No.</th>
                              <th class="text-center">Emisión</th>
                              <th class="text-center">Vencimiento</th>
                              <th class="text-center" style="white-space: nowrap;">Valor Q</th>
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Vehículo</th>
                              <th class="text-center">Placa</th>
                              <th class="text-center">Conductor</th>
                              <th class="text-center">Usuario</th>
                              <?php
                                if($pedido->application['status'] == 2 && $u->hasPrivilege('modificarCupon')){
                                    echo '<th class="text-center">Acción</th>';
                                }
                              ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                            $index = 0;
                            $total_cupones = 0.00;
                            $subtotal_cupones = 0.00;
                            foreach ($coupons as $key=>$coupon){
                                if ($coupon['status'] == 1){
                                    $total_cupones += $coupon['monto'];
                                    $subtotal_cupones += $coupon['monto'];

                                        echo '<tr>';
                                        echo '<td class="text-center">' . $coupon['num'] . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . fecha_dmy($coupon['fecha_emision']) . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . fecha_dmy($coupon['fecha_cad']) . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . number_format($coupon['monto'], 2) . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . (($coupon['egr_status'] == 1) ? fecha_dmy($coupon['fecha']) : '') . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . $coupon['vehiculo_nombre'] . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . $coupon['placa'] . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . $coupon['conductor_nombre'] . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . $coupon['usuario_nombre'] . '</td>';
                                        if ($pedido->application['status'] == 2 && $u->hasPrivilege('modificarCupon')) {
                                            echo '<td class="text-center" style="white-space: nowrap;">';
                                            echo '<span data-toggle="tooltip" title="Editar"><a  class="btn btn-default" ' . (($coupon['status'] == 0 || $coupon['egr_status'] == 1 || $pedido->application['status'] != 2) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupon_ing_modificar.php?id=' . $coupon['cupon_ing_id'] . '"') . '><i class="fa fa-edit text-warning"></i></a></span>';
                                            echo ' ';
                                            echo '<span data-toggle="tooltip" title="Borrar"><a class="btn btn-default" ' . (($coupon['status'] == 0 || $coupon['egr_status'] == 1 || $pedido->application['status'] != 2) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupon_ing_borrar.php?id=' . $coupon['cupon_ing_id'] . '"') . '><i class="fa fa-trash  text-danger"></a></span>';
                                            echo '</td>';
                                        }
                                        echo '</tr>';
                                    if (!isset($coupons[$key+1]['monto']) || $coupons[$key+1]['monto'] != $coupon['monto']) {
                                        echo '<tr>';
                                        echo '<td class="text-center" style="white-space: nowrap;"><strong>SUB TOTAL</strong></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">' . number_format($subtotal_cupones, 2) . '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"></td>';
                                        if ($pedido->application['status'] == 2 && $u->hasPrivilege('modificarCupon')) {
                                            echo '<td class="text-center" style="white-space: nowrap;">';
                                            echo '</td>';
                                        }
                                        echo '</tr>';
                                        $subtotal_cupones = 0.00;
                                    }

                                }
                            }
                        ?>
                      </tbody>
                      <tfoot>
                        <tr>
                            <td class="text-center"><h4>Total</h4></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center" style="white-space: nowrap;"><strong>Q <?php echo number_format($total_cupones,2); ?></strong></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <td class="text-center"></td>
                            <?php if($pedido->application['status'] == 2 && $u->hasPrivilege('modificarCupon')){ echo '<td class="text-center"></td>'; } ?>
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
//header("Location: index.php");
endif;
?>
