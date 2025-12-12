<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCheques')):
        include_once 'inc/Account.php';
        $cuentas = Account::getAll();

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
                        CUENTAS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Cheques</li>
                        <li><a class="link-effect" href="#">Cuentas</a></li>
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
                            <a class="text-success" <?php echo (($u->hasPrivilege("crearCheques"))?'data-toggle="modal" data-target="#modal-remoto" href="cheques/cuenta_nueva.php" ':'href="#" disabled') ?> >
                                <i class="fa fa-plus"></i> Agregar nueva
                            </a>
                        </button>
                      </li>
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle">
                              <i class="si si-size-fullscreen"></i>
                          </button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Cuentas</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-cuentas dt-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-left">TITULAR</th>
                                <th class="text-center">NÚMERO</th>
                                <th class="text-center">BANCO</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($cuentas as $cuenta){
                                    echo '<tr '.(($cuenta['cta_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="text-center">'.$cuenta['cta_id'].'</td>';
                                    echo '<td class="text-left">'.$cuenta['cta_titular'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$cuenta['cta_num'].'</td>';
                                    echo '<td class="text-center">'.$cuenta['bc_nombre'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">';
                                    echo '<div class="btn-group">';
                                    echo '<span data-toggle="tooltip" title="Ver"><a class="btn btn-default"  title="ver"  data-toggle="modal" data-target="#modal-remoto" href="cheques/cuenta_rango.php?id='.$cuenta['cta_id'].'"><i class="fa fa-eye text-info"></i></a></span>';
                                    echo ' ';
                                    if($u->hasPrivilege('modificarCheques')){
                                        echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="cheques/cuenta_modificar.php?id='.$cuenta['cta_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
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
