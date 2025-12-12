<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerAlmacen')):
        include_once 'funciones_almacen.php';
        $facturas = facturas();
        $facturas_total = 0.00;
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
                        FACTURAS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="#">Facturas</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Header Tiles -->
            <div class="row">
                <div class="col-sm-6 col-lg-3">
                    <a class="block block-link-hover3 text-center" <?php if(facturas_temporales() == 0 && $u->hasPrivilege('crearAlmacen')){echo 'data-toggle="modal" data-target="#modal-remoto" href="almacen/factura_nueva.php"';} ?>>
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 <?php if(facturas_temporales() == 0 && $u->hasPrivilege('crearAlmacen')){echo 'text-success';} ?>" ><i class="fa fa-plus"></i></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter font-w600" <?php if(facturas_temporales() == 0 && $u->hasPrivilege('crearAlmacen')){echo 'text-success';} ?>>Nueva Factura</div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 text-success" data-toggle="countTo" data-to="<?php echo facturas_validadas(); ?>"></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600 text-success">Facturas Validas</div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo facturas_anuladas(); ?>"></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600 text-danger">Facturas Anuladas</div>
                    </a>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="h1 font-w700 text-info" data-toggle="countTo" data-to="<?php echo facturas_total(); ?>"></div>
                        </div>
                        <div class="block-content block-content-full block-content-mini bg-gray-lighter text-muted font-w600 text-info">Total de Facturas</div>
                    </a>
                </div>
            </div>
            <!-- END Header Tiles -->
            <!-- Todas las Facturas -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                    <ul class="block-options">
                        <li>
                            <button type="button" data-toggle="block-option" data-action="print_toggle"><a href="almacen/facturas_resumen_1h.php" target="_blank"><i class="fa fa-print"> Resumen 1-H</i></a></button>
                        </li>
                        <li>
                            <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Listado de Facturas</h3>
                </div>
                <div class="block-content">
                        <table class="table table-bordered table-condensed table-striped table-vcenter js-dataTable-facturas dt-responsive display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="white-space: nowrap;">Fecha</th>
                                    <th class="text-center" style="white-space: nowrap;">Factura</th>
                                    <th class="text-left">Proveedor</th>
                                    <th class="text-center">NIT</th>
                                    <th class="text-center">Control No.</th>
                                    <th class="text-center" style="white-space: nowrap;">Forma 1-H</th>
                                    <th class="text-center">Orden de C.Y.P. No.</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($facturas as $factura){
                                        echo '<tr '.(($factura['fac_status'] == 0)?'class="danger"':' ').(($factura['fac_status'] == 2)?'class="warning"':' ').'>';
                                        echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($factura['fac_fecha']).'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">'.$factura['fac_serie'].' '.$factura['fac_num'].'</td>';
                                        echo '<td class="text-left">'.$factura['prov_nm'].'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">'.$factura['prov_nit'].'</td>';
                                        echo '<td class="text-center">'.sprintf('%05d',$factura['fac_control']).'</td>';
                                        echo '<td class="text-center">'.sprintf('%05d',$factura['fac_1h']).'</td>';
                                        echo '<td class="text-center">'.sprintf('%05d',$factura['orden_id']).'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;"> Q '.number_format($factura['factura_total'],2).'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<div class="btn-group">';
                                        echo '<span data-toggle="tooltip" title="Revisar"><a class="btn btn-default" href="?ref=_6&id='.$factura['fac_id'].'"><i class="fa fa-eye text-info"></i></a></span>';
                                        echo ' ';
                                        if($u->hasPrivilege('modificarAlmacen')) {
                                            echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default" ' . (($factura['fac_status'] == 0) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto"  href="almacen/factura_modificar.php?id=' . $factura['fac_id'] . '" ') . ' ><i class="fa fa-pencil text-warning"></i></a></span>';
                                            echo '<br> ';
                                            echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default" ' . (($factura['egresos'] > 0 || $factura['fac_status'] == 0) ? 'href="#" disabled' : 'data-toggle="modal" data-target="#modal-remoto"  href="almacen/factura_anular.php?id=' . $factura['fac_id'] . '" ') . ' ><i class="fa fa-times text-danger"></i></a></span>';
                                            echo ' ';
                                        }
                                        echo '<span data-toggle="tooltip" title="Imprimir"><a class="btn btn-default" '.(($factura['fac_status'] == 1 )?' href="almacen/factura_1h.php?id='.$factura['fac_id'].'" target="_blank" ':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                                        echo '</div>';
                                        echo '</td>';
                                        echo '</tr>';
                                        $facturas_total += $factura['factura_total'];
                                    }
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>

                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-center"></td>
                                    <td class="text-right"><h4>Total</h4></td>
                                    <td class="text-center" style="white-space: nowrap;"><strong>Q <?php echo number_format($facturas_total,2); ?></strong></td>
                                    <td class="text-center"></td>
                                </tr>
                            </tfoot>
                        </table>
                </div>
            </div>
            <!-- Final Todas las Facturas -->
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
