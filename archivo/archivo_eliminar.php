<?php
include_once '../inc/functions.php';
include_once 'funciones_archivo.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('eliminarArchivo')):
        $id = null;
        $archivo = array();
        $instituciones = instituciones();
        $archivoTipos = archivoTipos();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $archivo = archivoById($id);
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_25");
        }
        if ( !empty($_POST)) {
            archivo_eliminar($id);
            header("Location: index.php?ref=_25");
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Eliminar Archivo</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-danger">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Eliminar Archivo</h3>
            </div>
            <div class="block-content">
                  <form class="js-validation-documento form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="<?php echo $archivo['arch_destinatario']?>" disabled>
                                  <label for="destinatarios">Destinatario(s)*</label>
                                  <div class="help-block text-right"> Ej: Nombre Apellido (Institución). Ingresar múltiples destinatarios separados por punto y coma (";").</div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <input class="js-tags-input form-control" type="text" id="destinatarios_cc" name="destinatarios_cc" value="<?php echo $archivo['arch_destinatario_cc']?>" disabled>
                                  <label for="destinatarios_cc">CC*</label>
                                  <div class="help-block text-right">Ej: Nombre Apellido (Institución). Ingresar múltiples destinatarios CC separados por punto y coma (";"). </div>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <select class ="js-select2 form-control" name="tipo_id" id="tipo_id"  style="width: 100%;" data-placeholder="-- Seleccionar Tipo --" disabled>
                                      <option></option>
                                      <?php
                                      foreach ($archivoTipos as $tipo):
                                          if ($tipo['tipo_status'] == 1){
                                              echo '<option value="'.$tipo["tipo_id"].'"'.(($archivo['tipo_id'] == $tipo['tipo_id'])? 'selected':'').'>'.$tipo["tipo_nombre"].'</option>';
                                          }
                                      endforeach
                                      ?>
                                  </select>
                                  <label for="tipo_id">Tipo de Archivo*</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <input class="js-datepicker form-control" type="text" id="arch_fecha" name="arch_fecha" value="<?php echo fecha_dmy($archivo['arch_fecha']); ?>" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" disabled>
                                  <label for="arch_fecha">Fecha</label>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <input class="form-control"  type="text" id="arch_correlativo" name="arch_correlativo" value="<?php echo $archivo['arch_correlativo']; ?>" readonly>
                                  <label for="arch_correlativo">Correlativo</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <input class="form-control"  type="text" id="arch_titulo" name="arch_titulo" value="<?php echo $archivo['arch_titulo']; ?>" readonly>
                                  <label for="arch_titulo">Título</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <a target="_blank" href="archivo/adjuntos/<?php echo sanear_string($archivo['depto_nombre']).'/'.$archivo['arch_original']?>"><i class="fa fa-eye text-info"></i> <?php echo $archivo['arch_original']; ?></a>
                                  <label for="arch_original">Archivo Original</label>

                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <?php echo (($archivo['arch_firmado'] != '')?'<p><a target="_blank" href="archivo/adjuntos/'.sanear_string($archivo['depto_nombre']).'/'.$archivo['arch_firmado'].'"><i class="fa fa-eye text-info"></i> '.$archivo['arch_firmado'].'</a></p>':'NO DISPONIBLE');?>
                                  <label for="arch_firmado">Archivo Firmado</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <?php echo (($archivo['arch_recibido'] != '')?'<a target="_blank" href="archivo/adjuntos/'.sanear_string($archivo['depto_nombre']).'/'.$archivo['arch_recibido'].'"><i class="fa fa-eye text-info"></i> '.$archivo['arch_recibido'].'</a>':'NO DISPONIBLE');?>
                                  <label for="arch_recibido">Archivo Recibido</label>
                              </div>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-12 text-center">
                              <p class="text_center">¿Esta seguro de <span class="text-danger">ELIMINAR</span> el archivo? Esta acción no es reversible.</p>
                          </div>
                      </div>
                      <div class="form-group">
                          <div class="col-xs-6 text-center">
                              <a href="?ref=_25"> <button type="button" class="btn btn-primary btn-block" >No, regresar</button></a>
                          </div>
                          <div class="col-xs-6 text-center">
                              <button class="btn btn-sm btn-danger btn-block" type="submit"><i class=""></i>SI, ELIMINAR</button>
                          </div>
                      </div>
                  </form>
            </div>
          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (BS Datepicker + Select2 Inputs plugins)
                  App.initHelpers(['datepicker','select2','tags-inputs']);
              });
          </script>
          <script src="assets/js/pages/archivo_forms_validation.js"></script>
        </body>
        </html>
        <?php
    else :
        echo include(unauthorizedModal());
    endif;
else:
    header("Location: index.php");
endif;
?>
