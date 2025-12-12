<?php if (login_check($mysqli) == true) : ?>
    <?php
        if ($_SESSION['role'] == 'almacen') :
        include_once 'funciones_almacen.php';
    ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">

         <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        MEDIDAS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="#">Medidas</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->

        <?php
            $medidas = medidas();
            $total_medidas = count($medidas);
            $medidas_inactivas = 0;
            foreach ($medidas as $medida):
                if ($medida['med_status'] == 0){ $medidas_inactivas++;}
            endforeach;

         ?>
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Header Tiles -->
            <div class="row">
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" data-toggle="modal" data-target="#modal-medida" href="almacen/medida_nueva.php">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-success"><i class="fa fa-plus"></i></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-success font-w600">Nueva Medida</div>
                        </a>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-danger" data-toggle="countTo" data-to="<?php echo $medidas_inactivas; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-danger font-w600">Inactivas</div>
                        </a>
                    </div>
                    <div class="col-xs-12 col-sm-4">
                        <a class="block block-link-hover3 text-center" href="javascript:void(0)">
                            <div class="block-content block-content-full">
                                <div class="h1 font-w700 text-info" data-toggle="countTo" data-to="<?php echo $total_medidas; ?>"></div>
                            </div>
                            <div class="block-content block-content-full block-content-mini bg-gray-lighter text-info font-w600">Todas las Medidas</div>
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
                  <h3 class="block-title">Listado de Medidas</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-full" >
                        <thead>
                            <tr>
                                <th class="hidden-xs text-center" style="width: 100px;">ID</th>
                                <th class="text-center">Unidad de Medida</th>
                                <th class="hidden-xs text-center">Categoría de unidades de medida</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($medidas as $medida){
                                    echo '<tr '.(($medida['med_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="hidden-xs text-center">'.$medida['med_id'].'</td>';
                                    echo '<td class="text-center">'.$medida['med_nm'].'</td>';
                                    echo '<td class="hidden-xs ">'.$medida['med_cat_nm'].'</td>';
                                    echo '<td class="text-center">';
                                    echo '<div data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-medida" href="almacen/medida_modificar.php?id='.$medida['med_id'].'"><i class="fa fa-pencil text-warning"></i></a></div>';
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

        <!-- INICIO Producto Modal -->
        <div class="modal fade" id="modal-medida" tabindex="-1" role="dialog" aria-hidden="true">
          <div class="modal-dialog modal-dialog-popout">
              <div class="modal-content">
                  <!-- Contenido Remoto -->
              </div>
          </div>
        </div>
        <!-- FIN Producto Modal -->



    <?php else :
        echo "<script type='text/javascript'> window.location='/almacen'; </script>";
    endif; ?>
<?php else:
       echo "<script type='text/javascript'> window.location='/almacen'; </script>";
endif; ?>
