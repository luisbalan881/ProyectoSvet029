<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('crearUsuario')):
            $error_msg = '';
            $departamentos = array();
            $roles = array();
            if ( !empty($_POST)){
                User::subir_horarios();
                header("Location: index.php?ref=_39");
            }else{
                $departamentos = departamentos();
                $roles = roles();
            }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                <title>Usuario Nueva</title>
            </head>
            <body>
                <div class="block block-themed block-transparent remove-margin-b">
                <div class="block-header bg-success">
                    <ul class="block-options">
                        <li>
                            <button data-dismiss="modal" type="button"><i class="si si-close"></i></button>
                        </li>
                    </ul>
                    <h3 class="block-title">Subir archivo de Horarios</h3>
                </div>
                <div class="block-content">
                    <form class="form-horizontal push-10-t push-10" action="usuarios/subir_horarios.php" enctype="multipart/form-data" method="post">
                        <div class="form-group">
                          <div class="col-xs-5">
                              <div class="form-material">
                                  <input id="archivo" accept=".txt" name="archivo" type="file" />
                                  <input name="MAX_FILE_SIZE" type="hidden" value="20000" />
                                  <label for="user_vid">Archivo txt*</label>
                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-12 text-center">
                              <button class="btn btn-sm btn-success btn-block" type="submit"><i class=""></i>Crear Horarios</button>
                          </div>
                        </div>
                    </form>
                </div>
                </div>
                <!-- Page JS Code -->
                <script>
                    jQuery(function(){
                      // Init page helpers (Select2 Inputs plugins)
                      App.initHelpers(['select2']);
                    });
                </script>
                <script src="assets/js/pages/usuarios_forms_validation.js"></script>
            </body>
        </html>
        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
        echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>
