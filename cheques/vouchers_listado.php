<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCheques')):
        include_once 'inc/Voucher.php';
        $vouchers = Voucher::getAll($u);
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
                        <i>VOUCHERS</i>
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Cheques</li>
                        <li><a class="link-effect" href="#">Vouchers</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Todos los Productos -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                        <button type="button">
                            <a class="text-success" <?php echo (($u->hasPrivilege("crearCheques"))?'data-toggle="modal" data-target="#modal-remoto" href="cheques/voucher_nuevo.php" ':'href="#" disabled') ?> >
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
                  <h3 class="block-title">Listado de Vouchers</h3>
                </div>
                <div class="block-content">
                        <table class="table table-bordered table-condensed table-striped js-dataTable-vouchers dt-responsive display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">No.</th>
                                    <th class="text-left">Cuenta</th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-left">Proveedor</th>
                                    <th class="text-center">NIT</th>
                                    <th class="text-left">Descripción</th>
                                    <th class="text-center">Cheque</th>
                                    <th class="text-center"><i>Voucher</i></th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($vouchers as $voucher){
                                        echo '<tr '.(($voucher['vchr_status'] == 0)?'class="danger"':"").'>';
                                        echo '<td class="text-center" width="40">'.$voucher['vchr_id'].'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($voucher['vchr_fecha']).'</td>';
                                        echo '<td class="text-center">'.$voucher['vchr_num'].'</td>';
                                        echo '<td class="text-left" style="white-space: nowrap;">'.$voucher['cta_num'].'</td>';
                                        echo '<td class="text-right" style="white-space: nowrap;">Q '.number_format($voucher['vchr_monto'],2).'</td>';
                                        echo '<td class="text-left">'.$voucher['prov_nm'].'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">'.$voucher['prov_nit'].'</td>';
                                        echo '<td class="text-left">'.$voucher['vchr_desc'].'</td>';
                                        echo '<td class="text-left">';
                                        echo (($voucher['vchr_cheque_file'] != '')?'<br><a target="_blank" href="cheques/adjuntos/'.$voucher['vchr_num'].'/'.$voucher['vchr_cheque_file'].'"><button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Ver Cheque"><i class="fa fa-eye text-info"></i>&nbsp;Ver&nbsp;Cheque</button></a>':'<br>No&nbsp;Disponible').'<br>';
                                        echo '</td>';
                                        echo '<td class="text-left">';
                                        echo (($voucher['vchr_voucher_file'] != '')?'<br><a target="_blank" href="cheques/adjuntos/'.$voucher['vchr_num'].'/'.$voucher['vchr_voucher_file'].'"><button class="btn btn-xs btn-default" type="button" data-toggle="tooltip" title="Ver Voucher"><i class="fa fa-eye text-info"></i>&nbsp;Ver&nbsp;<i>Voucher</i></button></a>':'<br>No&nbsp;Disponible');
                                        echo '</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">';
                                        echo '<div class="btn-group">';
                                        echo '<span data-toggle="tooltip" title="Imprimir"><a class="btn btn-default"  title="Imprimir" '.(($voucher['vchr_status'] == 1) ? 'href="cheques/voucher_impresion.php?id='.$voucher['vchr_id'].'" target="_blank"':'href="#" disabled').'><i class="fa fa-print text-info"></i></a></span>';
                                        echo '&nbsp;';
                                        echo '<span data-toggle="tooltip" title="Descargar"><a class="btn btn-default"  title="Descargar" '.(($voucher['vchr_status'] == 1) ? 'href="cheques/voucher_download.php?id='.$voucher['vchr_id'].'" target="_blank"':'href="#" disabled').'><i class="fa fa-download text-success"></i></a></span>';
                                        if($u->hasPrivilege('modificarCheques')){
                                            echo '<br>';
                                            echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar" '.(($voucher['vchr_status'] == 1) ? 'data-toggle="modal" data-target="#modal-remoto-lg" href="cheques/voucher_modificar.php?id='.$voucher['vchr_id'].'"':'href="#" disabled').'><i class="fa fa-pencil text-warning"></i></a></span>';
                                            echo '&nbsp;';
                                            echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default"  title="Anular" '.(($voucher['vchr_status'] == 1) ?  'data-toggle="modal" data-target="#modal-remoto-lg" href="cheques/voucher_anular.php?id='.$voucher['vchr_id'].'"':'href="#" disabled').'><i class="fa fa-times text-danger"></i></a></span>';
                                        }
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
