<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
include_once '../proveedores/funciones_proveedores.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearAlmacen')):
        $proveedores = proveedores();
        if ( !empty($_POST)) {
            $id = factura_nueva();
            header("Location: index.php?ref=_6&id=".$id);
        }
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Crear Nueva Factura</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-success">
                    <ul class="block-options">
                      <li>
                          <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                      </li>
                    </ul>
                    <h3 class="block-title">Crear Nueva Factura</h3>
                </div>
                <div class="block-content">
                    <form class="js-validation-factura form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                        <div class="form-group">
                            <div class="col-xs-12">
                                <div class="form-material">
                                    <select class ="js-select2 form-control" name="prov_id" id="prov_id" style="width: 100%;" data-placeholder="-- Seleccionar Proveedor --" required>
                                        <option></option>
                                        <?php foreach ($proveedores as $proveedor): ?>
                                        <option value="<?=$proveedor["prov_id"]?>"><?=$proveedor["prov_nit"]," / ",$proveedor["prov_nm"]?></option>
                                        <?php endforeach ?>
                                    </select>
                                    <label for="prov_id">Proveedor*</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control" type="text"  id="fac_serie" name="fac_serie"  required>
                                    <label for="fac_serie">Factura Serie*</label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control" type="number"  id="fac_num" name="fac_num"  required>
                                    <label for="fac_num">Factura Número*</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="fac_control" name="fac_control" value="<?php echo nuevo_control() ?>" required>
                                    <label for="fac_control">Número de Control*</label>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-material">
                                    <input class="form-control"  type="number"  id="fac_1h" name="fac_1h" value="<?php echo nuevo_1h() ?>" required>
                                    <label for="fac_1h">Factura 1-H*</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-4">
                              <div class="form-material">
                                  <input class="js-datepicker form-control" type="text" id="fac_fecha" name="fac_fecha" data-date-format="dd-mm-yyyy"  data-date-language="es-ES" placeholder="dd-mm-yyyy" required>
                                  <label for="fac_fecha">Fecha*</label>
                              </div>
                          </div>
                          <div class="col-xs-4">
                                <div class="form-material form-material-success  input-group">
                                    <span class="input-group-addon"><strong>Q</strong></span>
                                    <input class="form-control"  type="number"  id="fac_descuento" name="fac_descuento" >
                                    <label for="fac_descuento">Descuento</label>
                                </div>
                          </div>
                          <div class="col-xs-4">
                              <div class="form-material">
                                  <input class="form-control"  type="text"  id="orden_id" name="orden_id" >
                                  <label for="orden_id">Forma de Pago</label>
                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-12">
                              <div class="form-material">
                                  <textarea class="form-control" id="fac_obs" name="fac_obs" rows="3" ></textarea>
                                  <label for="fac_obs">Observaciones</label>
                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-12 text-center">
                                <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Factura</button>
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

