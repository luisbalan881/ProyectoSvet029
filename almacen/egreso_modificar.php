<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')):
        $id = null;
        $egreso = array();
        $requisicion = array();
        $disponible = 0;
        $req_id = 0;
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $egreso = egreso_info($id);
            $requisicion = requisicion_info($egreso['req_id']);
            $disponible = $egreso['existencia'] + $egreso['egr_cant'];
        }
        if ( null==$id ) {
            header("Location: index.php?ref=_7");
        }
        if ( !empty($_POST)) {
            if ( !empty($_GET['req'])) {
                $req_id = $_REQUEST['req'];
            }
            if ( null==$req_id ) {
                header("Location: ../inicio.php?ref=_7");
            }
            egreso_modificar($id);
            header("Location: ../inicio.php?ref=_8&id=".$req_id);
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Actualizar Egreso de Producto</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Egreso</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-egreso_modificar form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                  <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control"  type="text"  id="prod_id" value="<?php echo 'Renglon: '.$egreso['renglon_id'].', Código: '.$egreso["prod_cod"].', Nombre: '.$egreso["prod_nm"].', Presentación: '.$egreso["med_nm"].' '.$egreso['nombre_presentacion'].', Disponible: '.number_format($disponible,2); ?>" name="prod_id" disabled>
                              <label for="prod_id">Producto</label>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-6">
                          <div class="form-material">
                              <input class="form-control"  type="number"  id="egr_cant" value="<?php echo number_format($egreso['egr_cant'],2); ?>" min= "0" max="<?php echo number_format($disponible,2); ?>" name="egr_cant" autofocus>
                              <label for="egr_cant">Cantidad</label>
                          </div>
                      </div>
                      <div class="col-xs-6">
                          <div class="form-material">
                              <input class="js-datepicker form-control" type="text" id="egr_fecha" name="egr_fecha" data-date-language="es-ES"  data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo fecha_dmy($egreso['egr_fecha']) ?>"  data-date-start-date="<?php echo fecha_dmy($egreso['fac_fecha']) ?>" data-date-end-date="<?php echo fecha_dmy($requisicion['req_fecha']) ?>" readonly>
                              <label for="egr_fecha">Fecha</label>
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
                  // Init page helpers (BS Datepicker + Select2 Tags Inputs plugins)
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