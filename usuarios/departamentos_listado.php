<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerUsuario')):
        include_once 'funciones_usuarios.php';
        $departamentos = departamentos();
        ?>
        <!-- Page JS Plugins CSS -->
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/datatables/jquery.dataTables.min.css">
        <link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/select2/select2.min.css">

        <!-- INICIO Encabezado de Pagina -->
        <div class="content bg-gray-lighter">
          <div class="row items-push">
              <div class="col-sm-7">
                  <h1 class="page-heading">
                      DEPARTAMENTO
                  </h1>
              </div>
              <div class="col-sm-5 text-right hidden-xs">
                  <ol class="breadcrumb push-10-t">
                      <li>Control de Usuarios</li>
                      <li><a class="link-effect" href="#">Departamentos</a></li>
                  </ol>
              </div>
          </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Todos los departamentos -->
            <div class="block">
              <div class="block-header bg-gray-lighter">
                  <ul class="block-options">
                      <?php
                      if ($u->hasPrivilege('crearUsuario')){
                          echo '<li>';
                          echo '<button type="button">';
                          echo '<a class="text-success" data-toggle="modal" data-target="#modal-remoto" href="usuarios/departamento_nuevo.php"><i class="fa fa-plus"> Nuevo Departamento</i></a>';
                          echo '</button>';
                          echo '</li>';
                      }
                      ?>
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle">
                              <i class="si si-size-fullcreen"></i>
                          </button>
                      </li>
                  </ul>
                  <h3 class="block-title">Listado de Departamentos</h3>
              </div>
              <div class="block-content">
                  <table class="table table-bordered table-condensed table-striped js-dataTable-departamentos">
                      <thead>
                          <tr>
                              <th class="hidden-xs text-center" style="width: 100px;">ID</th>
                              <th class="text-center" style="width: 100px;">Nombre</th>
                              <th class="text-center">Director/Jefe</th>
                              <?php echo (($u->hasPrivilege("modificarUsuario"))?'<th class="text-center">Acción</th>':'') ?>
                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        foreach ($departamentos as $departamento){
                            echo '<tr '.(($departamento['dep_status'] == 0)?'class="warning"':'').'>';
                            echo '<td class="hidden-xs text-center">'.$departamento['dep_id'].'</td>';
                            echo '<td class="text-left">'.$departamento['dep_nm'].'</td>';
                            echo '<td class="text-center">'.$departamento['dep_encargado'].'</td>';
                            if($u->hasPrivilege('modificarUsuario')) {
                                echo '<td class="text-center">';
                                echo '<div class="btn-group">';
                                echo '<span data-toggle="tooltip" title="Editar"><a class="btn btn-default" data-toggle="modal" data-target="#modal-remoto" href="usuarios/departamento_modificar.php?id='.$departamento['dep_id'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
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
            <!-- Final Todos los departamentos -->
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
