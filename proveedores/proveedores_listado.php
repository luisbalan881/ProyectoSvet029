<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerProveedor')):
        include_once 'funciones_proveedores.php';
    ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/responsive/2.1.1/css/responsive.dataTables.min.css">
        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        PROVEEDORES
                    </h1>
                </div>
                <div class="col-sm-5 text-right hidden-xs">
                    <ol class="breadcrumb push-10-t">
                        <li>Sistema de Almacén</li>
                        <li><a class="link-effect" href="#">Proveedores</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Todos los Proveedores -->
            <div class="block">
                <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <li>
                          <button type="button">
                              <a class="text-success" <?php echo (($u->hasPrivilege("crearProveedor"))?'data-toggle="modal" data-target="#modal-remoto" href="proveedores/proveedor_nuevo.php" ':'href="#" disabled') ?> >
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
                  <h3 class="block-title">Listado de Proveedores</h3>
                </div>
                <div class="block-content">
                    <table class="table table-bordered table-condensed table-striped js-dataTable-proveedores dt-responsive display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th class="text-left ">Descripción</th>
                                <th class="text-center">NIT</th>
                                <th class="text-center">Dirección</th>
                                <th class="text-center">Teléfono</th>
                                <th class="text-center">Correo Electrónico</th>
                                <?php echo (($u->hasPrivilege("modificarProveedor"))?'<th class="text-center">Acción</th>':'') ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach (proveedores() as $proveedor){
                                    echo '<tr '.(($proveedor['prov_status'] == 0)?'class="warning"':"").'>';
                                    echo '<td>'.$proveedor['prov_nm'].'</td>';
                                    echo '<td class="text-left">'.$proveedor['prov_desc'].'</td>';
                                    echo '<td class="text-center" style="white-space: nowrap;">'.$proveedor['prov_nit'].'</td>';
                                    echo '<td class="text-left">'.$proveedor['prov_direccion'].'</td>';
                                    echo '<td class="text-center">'.(($proveedor['prov_tel'] != 0)?$proveedor['prov_tel']:'').'</td>';
                                    echo '<td class="text-center ">'.$proveedor['prov_email'].'</td>';
                                    if($u->hasPrivilege('modificarProveedor')){
                                        echo '<td class="text-center">';
                                        echo '<div data-toggle="tooltip" title="Editar"><a class="btn btn-default"  title="Editar"  data-toggle="modal" data-target="#modal-remoto" href="proveedores/proveedor_modificar.php?id='.$proveedor['prov_id'].'"><i class="fa fa-pencil text-warning"></i></a></div>';
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- Final Todos los Proveedores -->
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
