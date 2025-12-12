<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege("leerAlmacen")):
        include_once 'funciones_almacen.php';
        $productos = array();
        $productos = productos();
        $productos_total = 0;
        $productos_inactivos = 0;
        $productos_cero = 0;
        foreach ($productos as $producto):
            $productos_total++;
            if ($producto['prod_status'] == 0){
                $productos_inactivos++;
            }
            if ($producto['existencia'] == 0){
                $productos_cero++;
            }
        endforeach;
    ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

         <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        PRODUCTOS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="#">Productos</a></li>
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
                        <a class="block block-link-hover3 text-center" <?php echo (($u->hasPrivilege("crearAlmacen"))?'data-toggle="modal" data-target="#modal-remoto" href="almacen/producto_nuevo.php" ':'href="#" disabled') ?>>
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 <?php echo (($u->hasPrivilege("crearAlmacen"))?'text-success':'') ?>"><i class="fa fa-plus"></i></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter font-w600 <?php echo (($u->hasPrivilege("crearAlmacen"))?'text-success':'') ?>">Nuevo Producto</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo $productos_inactivos; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Inactivos</div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-info" data-toggle="countTo" data-to="<?php echo $productos_total ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-info font-w600">Todos los Productos</div>
                        </a>
                    </div>
                </div>
            <!-- END Header Tiles -->
            <!-- Todos los Productos -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Productos</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-productos dt-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center">Renglón</th>
                                <th class="text-center" style="white-space: nowrap;">Código Interno</th>
                                <th class="text-center">Código de Insumo</th>
                                <th>Nombre</th>
                                <th>Caracteristicas</th>
                                <th>Presentación</th>
                                <th>Cantidad y Unidad</th>
                                <th>Código de Presentación</th>
                                <th class="text-center">Min/Max</th>
                                <th class="text-center">Estado</th>
                                <?php echo (($u->hasPrivilege("modificarAlmacen"))?'<th class="text-center">Acción</th>':'') ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($productos as $producto){
                                    echo '<tr '.(($producto['prod_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="text-center">'.$producto['prod_id'].'</td>';
                                    echo '<td class="text-center">'.$producto['renglon_id'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$producto['renglon_codigo'].'</td>';
                                    echo '<td class="text-center">'.$producto['prod_cod'].'</td>';
                                    echo '<td>'.$producto['prod_nm'].'</td>';
                                    echo '<td>'.$producto['prod_desc'].'</td>';
                                    echo '<td>'.$producto['nombre_presentacion'].'</td>';
                                    echo '<td style="white-space: nowrap;">'.$producto['med_nm'].'</td>';
                                    echo '<td>'.$producto['codigo_presentacion'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$producto['prod_min'].'/'.$producto['prod_max'].'</td>';
                                    echo '<td class="text-center">';
                                    echo (($producto['prod_status'] == 1)?'<span class="label label-info">Activo</span>':'<span class="label label-warning">Inactivo</span>');
                                    echo '</td>';
                                    if($u->hasPrivilege("modificarAlmacen")) {
                                        echo '<td class="text-center">';
                                        echo '<div data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="almacen/producto_modificar.php?id=' . $producto['prod_id'] . '"><i class="fa fa-pencil text-warning"></i></a></div>';
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
