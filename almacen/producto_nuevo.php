<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()) :
    if (usuarioPrivilegiado()->hasPrivilege("crearAlmacen")) :
        if ( !empty($_POST)) {

          producto_nuevo($_POST['renglon_id'],$_POST['codigo'],$_POST['nombre'],$_POST['caracteristicas'],$_POST['minimo'],$_POST['maximo'],$_POST['nombre_presentacion'],$_POST['cantidad_unidad'],$_POST['codigo_presentacion'],1,$_SESSION['user_id']);
          header("Location: index.php?ref=_1");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Producto Nuevo</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Crear Nuevo Producto</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-producto form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="post">
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <select class ="js-select2 form-control" name="renglon_id" id="renglon_id" style="width: 100%;" data-placeholder="-- Seleccionar Renglón --" required >
                                  <option value=""></option>
                                  <?php
                                    foreach (renglones() as $renglon){
                                        if ($renglon['renglon_status'] == 1){
                                            echo '<option value="'.$renglon["renglon_id"].'">'.$renglon['renglon_id']." - ".$renglon['renglon_nm'].'</option>';
                                        }
                                    }
                                  ?>
                              </select>
                              <label for="renglon_id">Renglón Presupuestario*</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="codigo" name="codigo" min="0" required>
                                <label for="codigo">Código de Insumo*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control focus"  type="text"  id="nombre" name="nombre"  required>
                              <label for="nombre">Nombre*</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                            <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3" required></textarea>
                            <label for="caracteristicas">Características del Producto*</label>
                        </div>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="nombre_presentacion" name="nombre_presentacion"  required>
                                <label for="nombre_presentacion">Nombre de la presentación*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="cantidad_unidad" name="cantidad_unidad"  required>
                                <label for="cantidad_unidad">Cantidad y Unidad de Medida*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="codigo_presentacion" name="codigo_presentacion" min="0" required>
                                <label for="codigo_presentacion">Código de Presentación*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control"  type="number"  id="maximo" name="maximo" required onchange="document.getElementById('minimo').max=this.value;">
                              <label for="maximo">Cantidad Maxima*</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control"  type="number"  id="minimo" name="minimo"  required onchange="document.getElementById('maximo').min=this.value;">
                              <label for="minimo">Cantidad Mínima*</label>
                          </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Producto</button>
                      </div>
                    </div>
                </form>
            </div>
            </div>
            <!-- Page JS Code -->
            <script>
              jQuery(function(){
                  // Init page helpers (Select2)
                  App.initHelpers('select2');
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
