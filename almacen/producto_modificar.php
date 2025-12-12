<?php
include_once '../inc/functions.php';
include_once 'funciones_almacen.php';
sec_session_start();
if (function_exists('login_check') && login_check()) :
    if (usuarioPrivilegiado()->hasPrivilege('modificarAlmacen')) :
        $id = null;
        $producto = array();
        $productoRenglonCodigo = null;
        if ( !empty($_GET['id'])) {
            $id = $_REQUEST['id'];
            $producto = producto_info($id);
            $productoRenglonCodigo = $producto['renglon_codigo'];
        }

        if ( null==$id ) {
            header("Location: index.php?ref=_1");
        }

        if ( !empty($_POST)) {
            producto_modificar($_POST['renglon_id'],$_POST['codigo'],$_POST['nombre'],$_POST['caracteristicas'],$_POST['minimo'],$_POST['maximo'],$_POST['nombre_presentacion'],$_POST['cantidad_unidad'],$_POST['codigo_presentacion'],$_POST['status'],$_SESSION['user_id'],$id);
            header("Location: index.php?ref=_1");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
          <title>Producto Modificar</title>
        </head>
        <body>
            <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar Producto</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-producto form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']); ?>" method="POST">
                    <input type="text"  id="prod_id" name="prod_id"  value="<?php echo $producto['prod_id']; ?>" hidden title="prod_id">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <select class ="js-select2 form-control" name="renglon_id" id="renglon_id" style="width: 100%;" data-placeholder="-- Seleccionar Renglón --" required >
                                    <option value=""></option>
                                    <?php
                                    foreach (renglones() as $renglon){
                                        if ($renglon['renglon_status'] == 1){
                                            echo '<option value="'.$renglon["renglon_id"].'" '.(($renglon['renglon_id'] == $producto['renglon_id'])?'selected':'').'>'.$renglon['renglon_id']." - ".$renglon['renglon_nm'].'</option>';
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
                                <input class="form-control"  type="text"  id="renglon_codigo" name="renglon_codigo"  value="<?php echo $productoRenglonCodigo ?>" readonly>
                                <label for="renglon_codigo">Código interno</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="codigo" name="codigo"  value="<?php echo (($producto['prod_cod'] != "N/A")? $producto['prod_cod']:0); ?>" min="0" required>
                                <label for="codigo">Código de Insumo*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="nombre" name="nombre"  value="<?php echo $producto['prod_nm']; ?>" required>
                                <label for="nombre">Nombre*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="caracteristicas" name="caracteristicas" rows="3" required><?php echo $producto['prod_desc']; ?></textarea>
                                <label for="caracteristicas">Características del Producto*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="nombre_presentacion" name="nombre_presentacion"  value="<?php echo $producto['nombre_presentacion']; ?>" required>
                                <label for="nombre_presentacion">Nombre de la presentación*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="cantidad_unidad" name="cantidad_unidad"  value="<?php echo $producto['med_nm']; ?>" required>
                                <label for="cantidad_unidad">Cantidad y Unidad de Medida*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="codigo_presentacion" name="codigo_presentacion"  value="<?php echo (($producto['med_id'] != "N/A")? $producto['med_id']:0); ?>" min="0" required>
                                <label for="codigo_presentacion">Código de Presentación*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="number"  id="maximo" name="maximo" value="<?php echo $producto['prod_max']; ?>" required onchange="document.getElementById('minimo').max=this.value;">
                                <label for="maximo">Cantidad Maxima*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control"  type="number"  id="minimo" name="minimo"  value="<?php echo $producto['prod_min']; ?>" required onchange="document.getElementById('maximo').min=this.value;">
                                <label for="minimo">Cantidad Mínima*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                          <label class="css-input switch switch-success">
                            <input name="status" type="checkbox"  <?php echo (($producto['prod_status'] == 1)?'checked':""); ?> value="1"><span></span>Producto Activo
                          </label>
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
