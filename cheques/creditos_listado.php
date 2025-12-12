<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCheques')):
        include_once 'inc/Credit.php';
        $creditos = Credit::getAll($u);

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
                        CRÉDITOS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Cheques</li>
                        <li><a class="link-effect" href="#">Créditos</a></li>
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
                            <a class="text-success" <?php echo (($u->hasPrivilege("crearCheques"))?'data-toggle="modal" data-target="#modal-remoto" href="cheques/credito_nuevo.php" ':'href="#" disabled') ?> >
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
                  <h3 class="block-title">Listado de Créditos</h3>
                </div>
                <div class="block-content">
                        <table class="table table-bordered table-condensed table-striped js-dataTable-creditos dt-responsive display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-left ">Cuenta</th>
                                    <th class="text-center">Monto</th>
                                    <th class="text-left">Descripción</th>
                                    <?php echo (($u->hasPrivilege("modificarCheques"))?'<th class="text-center">Acción</th>':'') ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($creditos as $credito){
                                        echo '<tr '.(($credito['cdto_status'] == 0)?'class="danger"':"").'>';
                                        echo '<td class="text-center">'.$credito['cdto_id'].'</td>';
                                        echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($credito['cdto_fecha']).'</td>';
                                        echo '<td class="text-left" style="white-space: nowrap;">'.$credito['cta_num'].' <br>'.$credito['cta_titular'].'</td>';
                                        echo '<td class="text-right" style="white-space: nowrap;">Q '.number_format($credito['cdto_monto'],2).'</td>';
                                        echo '<td class="text-left">'.$credito['cdto_desc'].'</td>';
                                        if($u->hasPrivilege('modificarCheques')){
                                            echo '<td class="text-center" width="30">';
                                            echo '<div class="btn-group">';
                                            echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar" '.(($credito['cdto_status'] == 1) ? 'data-toggle="modal" data-target="#modal-remoto" href="cheques/credito_modificar.php?id='.$credito['cdto_id'].'"':'href="#" disabled').'><i class="fa fa-pencil text-warning"></i></a></span>';
                                            echo '<br>';
                                            echo '<span data-toggle="tooltip" title="Anular"><a class="btn btn-default"  title="Anular" '.(($credito['cdto_status'] == 1) ?  'data-toggle="modal" data-target="#modal-remoto" href="cheques/credito_anular.php?id='.$credito['cdto_id'].'"':'href="#" disabled').'><i class="fa fa-times text-danger"></i></a></span>';
                                            echo '</div>';
                                            echo '</td>';
                                        }
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
