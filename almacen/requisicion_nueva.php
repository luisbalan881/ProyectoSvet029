<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen')):
        if ( !empty($_POST)) {
            $id = requisicion_nueva();
            header("Location: index.php?ref=_8&id=".$id);
        }
        $personas = personas();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Crear Nueva Requisición</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
              <div class="block-header bg-success">
                  <ul class="block-options">
                      <li>
                          <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                      </li>
                  </ul>
                  <h3 class="block-title">Crear Nueva Requisición</h3>
              </div>
              <div class="block-content">
                  <form class="js-validation-requisicion form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                              <select class ="js-select2 form-control" name="req_user" id="req_user" style="width: 100%;" data-placeholder="-- Seleccionar Usuario --" required>
                              <option></option>
                            <?php foreach ($personas as $persona): ?>
                                <option value="<?=$persona['user_id']?>" <?php echo (($persona['user_status']== 0)? 'disabled':'');?>><?=$persona['user_nm1']," ",$persona['user_ap1']," - ",$persona['dep_nm']," / ",$persona['user_puesto']," - Ext: ",$persona["ext_id"]?></option>
                            <?php endforeach ?>
                          </select>
                                <label for="req_user">Usuario*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="form-control"  type="number"  id="req_num" name="req_num" value="<?php echo sprintf('%05d',nuevo_req()); ?>" required>
                                <label for="req_num">No. de Requisición*</label>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-material">
                                <input class="js-datepicker form-control" type="text" id="req_fecha" name="req_fecha" data-date-format="dd-mm-yyyy" data-date-language="es-ES" placeholder="dd-mm-yyyy" required>
                                <label for="req_fecha">Fecha*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <textarea class="form-control" id="req_obs" name="req_obs" rows="3"></textarea>
                              <label for="req_obs">Observaciones</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12 text-center">
                            <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Requisición</button>
                        </div>
                    </div>
                  </form>
              </div>
            </div>
            <!-- Page JS Code -->
            <script>
                jQuery(function(){
                    // Init page helpers (BS Datepicker Select2 Inputs plugins)
                    App.initHelpers(['datepicker', 'select2']);
                });
            </script>
            <script src="assets/js/pages/almacen_forms_validation.js"></script>
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
