<?php
if (function_exists('login_check') && login_check()) :
    if (isset($u) && $u->hasPrivilege('leerAlmacen')) :
        include_once 'funciones_almacen.php';
        $renglones = array();
        $renglones = renglones();
        $total_renglones = count($renglones);
        $renglones_inactivos = 0;
        foreach ($renglones as $renglon):
            if ($renglon['renglon_status'] == 0){ $renglones_inactivos++;}
        endforeach;
    ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">

        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        RENGLONES
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="#">Renglones</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Header Tiles -->
            <div class="row">
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" <?php echo ($u->hasPrivilege('crearAlmacen')? 'data-toggle="modal" data-target="#modal-remoto" href="almacen/renglon_nuevo.php"':'href="#" disabled') ?>>
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 <?php echo (($u->hasPrivilege("crearAlmacen"))?'text-success':'') ?>"><i class="fa fa-plus"></i></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter font-w600 <?php echo (($u->hasPrivilege("crearAlmacen"))?'text-success':'') ?>">Nuevo Renglón</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo $renglones_inactivos; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Inactivos</div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-info" data-toggle="countTo" data-to="<?php echo $total_renglones; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-info font-w600">Todos los Renglones</div>
                        </a>
                    </div>
                </div>
            <!-- END Header Tiles -->
            <!-- Todos los Productos -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                          <button type="button">
                            <a class="text-info"  title="Generar Reporte"  data-toggle="modal" data-target="#modal-remoto" href="almacen/renglon_rango.php"><i class="fa fa-print"> Resumen Renglón</i></a>
                          </button>
                      </li>
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Renglones</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-renglones" >
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Título del Renglón</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($renglones as $renglon){
                                    echo '<tr '.(($renglon['renglon_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="text-center">'.$renglon['renglon_id'].'</td>';
                                    echo '<td class="text-left">'.$renglon['renglon_nm'].'</td>';
                                    echo '<td class="text-center">';
                                    echo '<div class="btn-group">';
                                    if($u->hasPrivilege('modificarAlmacen')){
                                        echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="almacen/renglon_modificar.php?id='.$renglon['renglon_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                        echo ' ';
                                    }
                                    echo '<span data-toggle="tooltip" title="Generar Reporte"><a class="btn btn-default"  title="Generar Reporte"  data-toggle="modal" data-target="#modal-remoto" href="almacen/renglon_reporte.php?id='.$renglon['renglon_id'].'"><i class="fa fa-print text-info"></i></a></span>';
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
