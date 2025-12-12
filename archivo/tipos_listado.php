<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerTipoArchivo')):
        include_once 'funciones_archivo.php';
        $archivoTipos = archivoTipos();
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/bootstrap-datepicker/bootstrap-datepicker3.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
          <div class="row items-push">
              <div class="col-sm-7">
                  <h1 class="page-heading">
                      TIPOS DE ARCHIVO
                  </h1>
              </div>
              <div class="col-sm-5 text-right hidden-xs">
                  <ol class="breadcrumb push-10-t">
                      <li>Sistema de Archivo</li>
                      <li><a class="link-effect" href="#">Tipo de Archivo</a></li>
                  </ol>
              </div>
          </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Tipo nuevo -->
            <div class="row">
                <?php if ($u->hasPrivilege('crearTipoArchivo')): ?>
                    <!-- Ingreso Tipo -->
                    <div class="block block-themed block-rounded">
                        <div class="block-header bg-success">
                            <h3 class="block-title">+ Nuevo tipo de archivo</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <form class="js-validation-documento form-horizontal push-10-t push-10" action="archivo/tipo_nuevo.php" method="POST">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_nombre" name="tipo_nombre" required>
                                            <label for="inst_nombre">Nombre*</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Agregar Tipo de Archivo</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Ingreso Tipo -->
                <?php endif; ?>
            </div>
            <!-- END nuevo archivo -->
            <!-- Todos los tipos -->
            <div class="block">
              <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                  </ul>
                  <h3 class="block-title">Listado de Tipos de Archivo</h3>
              </div>
              <div class="block-content">
                  <table class="table table-bordered table-condensed table-striped js-dataTable-full-25">
                      <thead>
                          <tr>
                              <th class="hidden-xs text-center" style="width: 25px;">ID</th>
                              <th class="text-left" style="white-space: nowrap;">Nombre</th>
                              <?php echo (($u->hasPrivilege("modificarTipoArchivo"))?'<th class="text-center" width="50px">Acción</th>':'') ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($archivoTipos as $tipo){
                            echo '<tr '.(($tipo['tipo_status'] == 0)?'class="warning"':'').'>';
                            echo '<td class="hidden-xs text-center">'.$tipo['tipo_id'].'</td>';
                            echo '<td class="text-left">'.$tipo['tipo_nombre'].'</td>';
                            if($u->hasPrivilege('modificarTipoArchivo')) {
                                echo '<td class="text-center">';
                                echo '<div class="btn-group">';
                                echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default" data-toggle="modal" data-target="#modal-remoto" href="archivo/tipo_modificar.php?id='.$tipo['tipo_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
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
            <!-- Final Todos los archivos -->
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
