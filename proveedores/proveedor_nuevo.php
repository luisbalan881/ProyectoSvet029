<?php
include_once '../inc/functions.php';
include_once 'funciones_proveedores.php';
sec_session_start();
if (function_exists('login_check') && login_check()):
    if (usuarioPrivilegiado()->hasPrivilege('crearProveedor')):
        if ( !empty($_POST)) {
            proveedor_nuevo();
            header("Location: index.php?ref=_18");
        }
    ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Proveedor Nuevo</title>
        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-header bg-success">
                <ul class="block-options">
                    <li>
                        <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                    </li>
                </ul>
                <h3 class="block-title">Crear Nuevo Proveedor</h3>
            </div>
            <div class="block-content">
                <form class="js-validation-proveedor form-horizontal push-10-t push-10" action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST">
                    <div class="form-group">
                        <div class="col-xs-12">
                          <div class="form-material">
                              <input class="form-control focus"  type="text"  id="prov_nm" name="prov_nm"  required>
                              <label for="prov_nm">Nombre*</label>
                          </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="prov_desc" name="prov_desc" rows="3"></textarea>
                                <label for="prov_desc">Descripción del Proveedor</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="prov_nit" name="prov_nit"  required>
                                <label for="prov_nit">Número de Identificación Tributaria (NIT)*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="prov_direccion" name="prov_direccion">
                                <label for="prov_direccion">Dirección</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="prov_tel" name="prov_tel">
                                <label for="prov_tel">Teléfono</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="email"  id="prov_email" name="prov_email">
                                <label for="prov_email">Correo electrónico</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-12 text-center">
                          <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Proveedor</button>
                      </div>
                    </div>
                </form>
            </div>
          </div>
          <!-- Page JS Code -->
          <script src="assets/js/pages/proveedor_forms_validation.js"></script>
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
