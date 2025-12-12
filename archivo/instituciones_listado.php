<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerInstitucion')):
        include_once 'funciones_archivo.php';
        $instituciones = instituciones();
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
                      INSTITUCIONES
                  </h1>
              </div>
              <div class="col-sm-5 text-right hidden-xs">
                  <ol class="breadcrumb push-10-t">
                      <li>Sistema de Archivo</li>
                      <li><a class="link-effect" href="#">Instituciones</a></li>
                  </ol>
              </div>
          </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Institución nueva -->
            <div class="row">
                <?php if ($u->hasPrivilege('crearInstitucion')): ?>
                    <!-- Ingreso Institución -->
                    <div class="block block-themed block-rounded">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Nueva institución</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <form class="js-validation-documento form-horizontal push-10-t push-10" action="archivo/institucion_nueva.php" method="POST">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_nombre" name="inst_nombre" required>
                                            <label for="inst_nombre">Nombre de la institución*</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_abrev" name="inst_abrev">
                                            <label for="inst_abrev">Abreviatura</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_direccion" name="inst_direccion">
                                            <label for="inst_direccion">Dirección</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_tel" name="inst_tel">
                                            <label for="inst_tel">Teléfono</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="inst_web" name="inst_web">
                                            <label for="inst_web">Página web</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Agregar Institución</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Ingreso Institución -->
                <?php endif; ?>
            </div>
            <!-- END nuevo archivo -->
            <!-- Todos los archivos -->
            <div class="block">
              <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                  </ul>
                  <h3 class="block-title">Listado de Instituciones</h3>
              </div>
              <div class="block-content">
                  <table class="table table-bordered table-condensed table-striped js-dataTable-full-25">
                      <thead>
                          <tr>
                              <th class="hidden-xs text-center" style="width: 100px;">ID</th>
                              <th class="text-center" style="width: 100px;">Nombre</th>
                              <th class="text-center">Abreviatura</th>
                              <th class="hidden-xs text-left">Dirección</th>
                              <th class="text-center">Teléfono</th>
                              <th class="text-center">WEB</th>
                              <?php echo (($u->hasPrivilege("modificarInstitucion"))?'<th class="text-center">Acción</th>':'') ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($instituciones as $institucion){
                            echo '<tr '.(($institucion['inst_status'] == 0)?'class="warning"':'').'>';
                            echo '<td class="hidden-xs text-center">'.$institucion['inst_id'].'</td>';
                            echo '<td class="text-left">'.$institucion['inst_nombre'].'</td>';
                            echo '<td class="text-center">'.$institucion['inst_abrev'].'</td>';
                            echo '<td class="hidden-xs text-left">'.$institucion['inst_direccion'].'</td>';
                            echo '<td class="text-center">'.$institucion['inst_tel'].'</td>';
                            echo '<td class="text-center"><a target="_blank" href="https://'.$institucion['inst_web'].'">'.$institucion['inst_web'].'</a></td>';
                            if($u->hasPrivilege('modificarInstitucion')) {
                                echo '<td class="text-center">';
                                echo '<div class="btn-group">';
                                echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default" data-toggle="modal" data-target="#modal-remoto" href="archivo/institucion_modificar.php?id='.$institucion['inst_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
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
