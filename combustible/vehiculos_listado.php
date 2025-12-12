<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerCupon')):
        include_once 'inc/Vehicle.php';
        $vehiculos = Vehicle::getAll($u);
        $combustible = array(1 => 'Gasolina', 2 => 'Diesel');
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
                        VEHÍCULOS
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Control de cupones</li>
                        <li><a class="link-effect" href="#">Vehículos</a></li>
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
                            <a class="text-success" <?php echo (($u->hasPrivilege("crearCupon"))?'data-toggle="modal" data-target="#modal-remoto" href="combustible/vehiculo_nuevo.php" ':'href="#" disabled') ?> >
                                <i class="fa fa-plus"></i> Agregar nuevo
                            </a>
                        </button>
                      </li>
                      <li>
                          <button type="button">
                              <a class="text-info" <?php echo (($u->hasPrivilege("leerCupon"))?'data-toggle="modal" data-target="#modal-remoto" href="combustible/vehiculos_reporte.php" ':'href="#" disabled') ?> >
                                  <i class="fa fa-print"></i> Reporte General
                              </a>
                          </button>
                      </li>
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle">
                              <i class="si si-size-fullscreen"></i>
                          </button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Vehículos</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-cupones-vehiculos display nowrap dt-responsive" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th class="text-center">ID</th>
                                <th class="text-center ">NOMBRE</th>
                                <th class="text-center">LINEA</th>
                                <th class="text-center">PLACA</th>
                                <th class="text-center">MODELO</th>
                                <th class="text-center">CILINDRAJE</th>
                                <th class="text-center">COMBUSTIBLE</th>
                                <th class="text-center">COLOR</th>
                                <th class="text-center">ACCIÓN</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach ($vehiculos as $vehiculo){
                                    echo '<tr '.(($vehiculo['status'] == 0)?'class="warning"':"").'>';
                                    echo '<td class="text-center">'.$vehiculo['vehiculo_id'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$vehiculo['nombre'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$vehiculo['linea'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$vehiculo['placa'].'</td>';
                                    echo '<td class="text-center">'.$vehiculo['modelo'].'</td>';
                                    echo '<td class="text-center">'.$vehiculo['cilindraje'].'</td>';
                                    echo '<td class="text-center">'.$combustible[$vehiculo['combustible_id']].'</td>';
                                    echo '<td class="text-center">'.$vehiculo['color'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">';
                                    if($u->hasPrivilege('modificarCupon')){
                                        echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="combustible/vehiculo_modificar.php?id='.$vehiculo['vehiculo_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                        echo ' ';
                                    }
                                    echo '<span data-toggle="tooltip" title="Generar Reporte"><a class="btn btn-default"  title="Generar Reporte"  data-toggle="modal" data-target="#modal-remoto" href="combustible/vehiculo_reporte.php?id='.$vehiculo['vehiculo_id'].'"><i class="fa fa-print text-info"></i></a></span>';
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
