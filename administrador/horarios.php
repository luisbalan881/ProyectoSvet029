<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('Configuracion')):
            $error_msg = '';
            $departamentos = array();
            $roles = array();
            if ( !empty($_POST)){
                User::subir_horarios();
                header("Location: index.php?ref=_100");
            }else{

            }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                <title>Usuario Nueva</title>
                <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->
                <script src="administrador/js/upload_horarios.js"></script>
                <script type="text/javascript" src="../herramientas/assets/js/plugins/file_style/bootstrap-filestyle.min.js"> </script>
                <script>
                $('#archivo').filestyle();

                </script>

            </head>
            <body>
              <div class="block block-themed block-transparent remove-margin-b panel panel-default">
                <div class="panel-heading ">

                    <h3 class="">Subir archivo de Horarios</h3>
                    <ul class="block-options2" style="margin-top:-30px;">
                        <li>
                            <button id="back" onclick="cargar('administrador/scripts_php/en_blanco.php')" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="block-content">
                  <form class="form-horizontal push-10-t push-10" id="upload_csv" method="post" enctype="multipart/form-data">
                    <p id="message"></p>
                        <div class="form-group">
                          <div class="col-xs-12">
                              <div class="">
                                  <label for="user_vid">Archivo .csv*</label>

                                    <input id="archivo" accept=".csv" name="archivo" type="file" class="form-control"/>
                                    <input name="MAX_FILE_SIZE" type="hidden" value="20000" />

                              </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <div class="col-xs-12 text-center">
                              <button class="btn btn-sm btn-success btn-block" name="upload" id="upload" type="submit"><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i>  Crear Horarios</button>
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
