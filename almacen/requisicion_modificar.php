<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $id = null;
        $requisicion = array();
        $personas = personas();
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $requisicion = requisicion_info($id);
        }

        if ( null==$id ) {
            header("Location: index.php?ref=_7");
        }

        if ( !empty($_POST)) {
            requisicion_modificar($id);
            header("Location: index.php?ref=_8&id=".$id);
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Actualizar Ingreso de Requisición</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Requisición</h3>
            </div>
            <div class="block-content">
                  <form class="js-validation-requisicion form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI'])?>" method="POST">
                    <input type="text"  id="req_id" name="req_id"  value="<?php echo $requisicion['req_id'] ?>" hidden title="req_id">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="req_user" id="req_user" style="width: 100%;"  data-placeholder="-- Seleccionar Usuario --" required>
                                  <option></option>
                                  <?php foreach ($personas as $persona): ?>
                                  <option value="<?=$persona['user_id']?>" <?php if($persona['user_id'] == $requisicion['req_user']){ echo 'selected';} ?> <?php if($persona['user_status']== 0 && $persona['user_id'] != $requisicion['req_user']){ echo 'disabled';}?>><?=$persona['user_nm1']," ",$persona['user_ap1']," - ",$persona['dep_nm']," / ",$persona['user_puesto']," - Ext: ",$persona["ext_id"]?></option>
                                  <?php endforeach ?>
                                </select>
                                <label for="req_user">Usuario*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control"  type="number"  id="req_num" name="req_num" value="<?php echo $requisicion['req_num']; ?>"  required>
                                <label for="req_num">No. de Requisición*</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="req_fecha" name="req_fecha" data-date-format="dd-mm-yyyy"  data-date-language="es-ES" placeholder="dd-mm-yyy" <?php if($requisicion['egr_fecha'] == NULL){echo 'value="'.fecha_dmy($requisicion['req_fecha']).'"';}else{ echo 'value="'.fecha_dmy($requisicion['egr_fecha']).'" data-date-start-date="'.fecha_dmy($requisicion['egr_fecha']).'"';} ?> required>
                                <label for="req_fecha">Fecha*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <textarea class="form-control" id="req_obs" name="req_obs" rows="3" required><?php echo $requisicion['req_obs']; ?></textarea>
                              <label for="req_obs">Observaciones</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-warning btn-block" type="submit"><i class=""></i>Guardar Cambios</button>
                        </div>
                    </div>
                  </form>
              </div>
          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (BS Datepicker + BS Datetimepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins)
                  App.initHelpers(['datepicker', 'select2']);
              });
          </script>
          <script src="assets/js/pages/almacen_forms_validation.js"></script>
        </body>
        </html>
        <?php
    else:
        echo include(unauthorizedModal());
    endif;
else:
    header("Location: index.php");
endif;
?>

