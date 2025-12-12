<?php
include_once '../inc/functions.php';
include_once 'funciones_proveedores.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('modificarProveedor')):
        $id = null;
        $bitacora = array();
        if ( !empty($_GET['id'])) {
          $id = $_REQUEST['id'];
          $bitacora = bitacora_info($id);
        }

        if ( null==$id ) {
          header("Location: index.php?ref=_18");
        }

        if ( !empty($_POST)) {
          proveedor_modificar($id);
          header("Location: index.php?ref=_18");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
          <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <script src="proveedores/js/validarentradas.js"></script>
          <title>Kilometraje Modificar</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-warning">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Modificar kilometro</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-proveedor form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['REQUEST_URI']);?>" method="POST">
                    <input type="text"  id="prov_id" name="prov_id"  value="<?php echo $bitacora['id_bitacora']; ?>" hidden title="id_bitacora">
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="prov_nm" name="Destino"  value="<?php echo $bitacora['Destino']; ?>" required>
                                <label for="Destino">Destino*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="prov_desc" name="motivo" rows="3"><?php echo $bitacora['motivo']; ?></textarea>
                                <label for="motivo">Motivo</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="km_inicial" name="km_inicial"  value="<?php echo $bitacora['km_inicial']; ?>" disabled>
                                <label for="km_inicial">Kilometraje inical*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="prov_direccion" name="km_final" value="<?php echo $bitacora['km_final']; ?>" onChange="validarDesayunos(this.value);">
                                <label for="km_final">Registra kilometraje final</label>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="form-group">
                        <div class="col-xs-12">
                          <label class="css-input switch switch-success">
                            <input name="status" type="status"  <?php echo (($bitacora['status'] == 1)?'checked':''); ?> value="1"><span></span> Activo
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
          <script src="assets/js/pages/kmfin_forms_validation.js"></script>
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
