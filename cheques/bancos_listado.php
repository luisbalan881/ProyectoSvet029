<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCheques')):
        include_once 'inc/Bank.php';
        $bancos = Bank::getBankAll();
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
         <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        BANCOS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Cheques</li>
                        <li><a class="link-effect" href="#">Bancos</a></li>
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
                            <a class="text-success" <?php echo (($u->hasPrivilege("crearCheques"))?'data-toggle="modal" data-target="#modal-remoto" href="cheques/banco_nuevo.php" ':'href="#" disabled') ?> >
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
                  <h3 class="block-title">Listado de Bancos</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-bancos">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-left ">Nombre del Banco</th>
                                <?php echo (($u->hasPrivilege("modificarCheques"))?'<th class="text-center">Acción</th>':'') ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($bancos as $banco){
                                    echo '<tr '.(($banco['bc_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="text-center">'.$banco['bc_id'].'</td>';
                                    echo '<td class="text-left">'.$banco['bc_nombre'].'</td>';
                                    if($u->hasPrivilege('modificarCheques')){
                                        echo '<td class="text-center">';
                                        echo '<div data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="cheques/banco_modificar.php?id='.$banco['bc_id'].'"><i class="fa fa-pencil text-warning"></i></a></div>';
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
