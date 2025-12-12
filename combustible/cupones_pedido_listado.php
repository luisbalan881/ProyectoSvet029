<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
        include_once 'inc/CouponApplication.php';
        $cupones_pedido = CouponApplication::getAll($u);

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
                        PEDIDOS DE CUPONES
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Control de cupones</li>
                        <li><a class="link-effect" href="#">Pedidos</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Todas las cuentas -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                        <button type="button">
                            <a class="text-success" <?php echo (($u->hasPrivilege("crearCupon"))?'data-toggle="modal" data-target="#modal-remoto" href="combustible/cupones_pedido_nuevo.php" ':'href="#" disabled') ?> >
                                <i class="fa fa-plus"></i> Agregar nuevo
                            </a>
                        </button>
                      </li>
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle">
                              <i class="si si-size-fullscreen"></i>
                          </button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Pedidos</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-cupones-pedido display nowrap dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center ">CUENTA</th>
                                <th class="text-center">FECHA</th>
                                <th class="text-center">FACTURA</th>
                                <th class="text-center">PROVEEDOR</th>
                                <th class="text-center">NIT</th>
                                <th class="text-center">CÓDIGO</th>
                                <th class="text-center">PEDIDO No.</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($cupones_pedido as $pedido){
                                    echo '<tr '.(($pedido['status'] == 0)?'class="danger"':(($pedido['status'] == 2)?'class="warning"':'')).'>';
                                    echo '<td class="text-center">'.$pedido['cupon_pedido_id'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$pedido['cta_num'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($pedido['fac_fecha']).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$pedido['fac_serie'].'-'.$pedido['fac_num'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$pedido['prov_nm'].'</td>';
                                    echo '<td class="text-center">'.str_replace('-','&#8209;',$pedido['prov_nit']).'</td>';
                                    echo '<td class="text-center">'.$pedido['codigo'].'</td>';
                                    echo '<td class="text-center">'.$pedido['pedido_num'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">Q '.number_format($pedido['monto'],2).'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">';
                                    echo '<div class="btn-group">';
                                    echo '<span data-toggle="tooltip" title="Ver"><a class="btn btn-default"  title="ver" href="?ref=_41&id='.$pedido['cupon_pedido_id'].'"><i class="fa fa-eye text-info"></i></a></span>';
                                    echo ' ';
                                    if($u->hasPrivilege('modificarCupon')){
                                        echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="combustible/cupones_pedido_modificar.php?id='.$pedido['cupon_pedido_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                        echo '<br> ';
                                        echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" ' . (($pedido['egresos'] > 0 || $pedido['status'] == 0) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto"  href="combustible/cupones_pedido_anular.php?id=' . $pedido['cupon_pedido_id'] . '" ') . ' ><i class="fa fa-times text-danger"></i></a></span>';
                                        echo ' ';
                                    }
                                    echo '<span data-toggle="tooltip" title="Generar Reporte"><a class="btn btn-default" '.(($pedido['egresos'] > 0 && $pedido['status'] == 1 )?' href="combustible/cupones_pedido_reporte_imprimir.php?id='.$pedido['cupon_pedido_id'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                                    echo '</div>';
                                    echo '</td>';
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Final Todos los Productos -->
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
