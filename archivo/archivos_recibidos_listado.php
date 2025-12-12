<?php
if (function_exists('login_check') && login_check()):
    if (isset($u) && $u->hasPrivilege('leerArchivo')):
        include_once 'funciones_archivo.php';
        $user = User::getByUserId($_SESSION['user_id']);
        $instituciones = instituciones();
        $archivoTipos = archivoTipos();
        $archivos = array();
        if ($u->hasPrivilege('leerArchivoCompleto')){
            $archivos = archivosRecibidosCompleto();
        }else{
            $archivos = archivosRecibidosDepto($user->persona['dep_id']);
        }
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
                      ARCHIVOS RECIBIDOS
                  </h1>
              </div>
              <div class="col-sm-5 text-right hidden-xs">
                  <ol class="breadcrumb push-10-t">
                      <li>Sistema de Archivo</li>
                      <li><a class="link-effect" href="#">Archivos Recibidos</a></li>
                  </ol>
              </div>
          </div>
        </div>
        <!-- FIN Encabezado de Pagina -->
        <!-- INICIO Contenido de pagina -->
        <div class="content content-boxed">
            <!-- Archivo nuevo -->
            <div class="row">
                <?php if ($u->hasPrivilege('crearArchivo')): ?>
                    <!-- Ingreso ARchivo -->
                    <div class="block block-themed block-rounded">
                        <div class="block-header bg-success">
                            <ul class="block-options">
                                <li>
                                    <button type="button" data-toggle="block-option" data-action="content_toggle">
                                        <i class="si si-arrow-up"></i>
                                    </button>
                                </li>
                            </ul>
                            <h3 class="block-title">+ Nuevo Archivo Recibido</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <form class="js-validation-documento-recibido form-horizontal push-10-t push-10" action="archivo/archivo_recibido_nuevo.php" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <!--<input class="js-tags-input form-control" type="text" id="remitentes" name="remitentes" value="" required>-->
                                            <select name="a_recibidos[]" multiple="multiple" data-placeholder="Seleccione una o mas instituciones" class="chosen-select col-xs-12" multiple tabindex="6" >
                                              <?php
                                              foreach ($instituciones as $tipo):
                                                  if ($tipo['inst_status'] == 1){
                                                      echo '<option value="'.$tipo["inst_id"].'">'.$tipo["inst_nombre"].'</option>';
                                                  }
                                              endforeach
                                              ?>
                                            </select>
                                            <label for="remitentes">Remitente(s)*</label>

                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4">
                                        <div class="form-material">
                                            <select class ="js-select2 form-control" name="tipo_id" id="tipo_id"  style="width: 100%;" data-placeholder="-- Seleccionar Tipo --" required>
                                                <option></option>
                                                <?php
                                                foreach ($archivoTipos as $tipo):
                                                    if ($tipo['tipo_status'] == 1){
                                                        echo '<option value="'.$tipo["tipo_id"].'">'.$tipo["tipo_nombre"].'</option>';
                                                    }
                                                endforeach
                                                ?>
                                            </select>
                                            <label for="tipo_id">Tipo de Archivo*</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-material">
                                            <input class="js-datepicker form-control" type="text" id="arch_fecha" name="arch_fecha" data-date-language="es-ES" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                                            <label for="arch_fecha">Fecha*</label>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="arch_correlativo" name="arch_correlativo" required>
                                            <label for="arch_correlativo">Correlativo*</label>
                                            <div class="help-block text-right">Ingresar correlativo único.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control"  type="text" id="arch_titulo" name="arch_titulo" required>
                                            <label for="arch_titulo">Título*</label>
                                            <div class="help-block text-right"> Ingresar título o descripción del archivo.</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12">
                                        <div class="form-material">
                                            <input class="form-control"  type="file" id="arch_recibido" name="arch_recibido" accept="application/pdf" required>
                                            <label for="arch_recibido">Archivo Recibido*</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-12 text-center">
                                        <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Agregar Archivo Recibido</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END Ingreso archivo -->
                <?php endif; ?>
            </div>
            <!-- END nuevo archivo -->
            <!-- Todos los archivos -->
            <div class="block block-themed block-rounded">
              <div class="block-header  bg-muted">
                  <ul class="block-options">
                      <li>
                          <button type="button" data-toggle="block-option" data-action="fullscreen_toggle">
                              <i class="si si-size-fullcreen"></i>
                          </button>
                      </li>
                  </ul>
                  <h3 class="block-title text-white">Listado de Archivos Recibidos</h3>
              </div>
              <div class="block-content">
                      <table class="table table-bordered table-condensed table-striped js-dataTable-documentos-recibidos dt-responsive display nowrap" cellspacing="0" width="100%">
                          <thead>
                          <tr>
                              <th class="text-center">Fecha</th>
                              <th class="text-center">Remitente</th>
                              <th class="text-center">Tipo</th>
                              <th class="text-center">Correlativo</th>
                              <th class="text-center">Título</th>
                              <th class="text-ceneter">Archivo</th>
                              <th class="text-center">Departamento</th>
                              <th class="text-center">Usuario</th>
                              <th class="text-center">Última modificación</th>
                              <th class="text-center">Modificado por</th>
                              <?php echo (($u->hasPrivilege("modificarArchivo"))?'<th class="text-center">Acción</th>':'') ?>
                          </tr>
                          </thead>
                          <tbody>
                          <?php
                          foreach ($archivos as $archivo){
                              $dir_recibido = sanear_string($archivo['depto_nombre']).'/recibido/'.$archivo['arch_recibido'];
                              echo '<tr>';
                              echo '<td class="text-center" style="white-space: nowrap;">'.fecha_dmy($archivo['arch_fecha']).'</td>';
                              $remitentes = explode(';',$archivo['arch_remitente']);
                              $remitentesTotal = count($remitentes);
                              echo '<td class="text-left">';
                              echo (($remitentesTotal > 1)?'<ul style="padding:0;">':'');
                              foreach ($remitentes as $remitente) {
                                  if ($remitente != '') {
                                      echo (($remitentesTotal > 1)?'<li style="list-style: none;"><br>':'');
                                      echo $remitente;
                                      echo (($remitentesTotal > 1)?'</li>':'');
                                  }
                              }
                              echo (($remitentesTotal > 1)?'</ul>':'');
                              echo '</td>';
                              echo '<td class="text-center" style="white-space: nowrap;">'.$archivo['tipo_nombre'].'</td>';
                              echo '<td class="text-left" style="white-space: nowrap;">'.$archivo['arch_correlativo'].'</td>';
                              echo '<td class="text-left">'.$archivo['arch_titulo'].'</td>';
                              echo '<td class="text-left" style="white-space: nowrap;">';
                              echo '<strong>Recibido: </strong>'.(($archivo['arch_recibido'] != '')?'<a target="_blank" href="archivo/adjuntos/'.$dir_recibido.'"><button class="btn btn-xs btn-default outline" type="button" data-toggle="tooltip" title="Ver Recibido"><i class="fa fa-file"></i> Ver Recibido</button></a>':' No Disponible');
                              echo '</td>';
                              echo '<td class="text-center">'.$archivo['depto_nombre'].'</td>';
                              echo '<td class="text-left">'.$archivo['arch_user_nombre'].'</td>';
                              echo '<td class="text-left" style="white-space: nowrap">';
                              $modificado_en = date('d-m-Y H:i:s',strtotime($archivo['mod_fecha']));
                              echo '<small>'.$modificado_en.'</small><br>';
                              echo'</td>';
                              echo '<td class="text-left" style="white-space: nowrap;">';
                              echo '<small>'.$archivo['arch_user_nombre'].'</small>';
                              echo'</td>';
                              if($u->hasPrivilege('modificarArchivo')) {
                                  echo '<td class="text-center" style="white-space: nowrap;>';
                                  echo '<div class="btn-group">';
                                  if ($archivo['user_id'] == $user->persona['user_id'] || $archivo['dep_encargado'] == $user->persona['user_id']){
                                      echo '<span  title="Editar"><a class="btn btn-default outline" data-toggle="modal" data-target="#modal-remoto-lg" href="archivo/archivo_recibido_modificar.php?id=' . $archivo['arch_id'] . '"><i class="fa fa-pencil "></i></a></span>';
                                      echo ' ';
                                      echo '<span  title="Eliminar"><a class="btn btn-default outline" data-toggle="modal" data-target="#modal-remoto-lg" href="archivo/archivo_recibido_eliminar.php?id=' . $archivo['arch_id'] . '"><i class="fa fa-trash "></i></a></span>';
                                  }
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
    else:
        echo include(unauthorized());
    endif;
else:
    header("Location: index.php");
endif;
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.js" type="text/javascript"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chosen/chosen.jquery.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chosen/docsupport/prism.js"></script>
<script src="<?php echo $one->assets_folder; ?>/js/plugins/chosen/docsupport/init.js"></script>

<link rel="stylesheet" href="<?php echo $one->assets_folder; ?>/js/plugins/chosen/chosen.css">
