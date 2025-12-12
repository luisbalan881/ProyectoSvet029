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

                <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>-->



            </head>
            <body>
              <div class="block block-themed block-transparent remove-margin-b panel panel-default">
                <div class="panel-heading ">

                    <h3 class="">Estado del Servidor</h3>
                    <ul class="block-options2" style="margin-top:-30px;">
                        <li>
                            <button id="back" onclick="cargar('administrador/scripts_php/en_blanco.php')" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                        </li>
                    </ul>
                </div>
                <div class="block-content">
                  <?php include('/scripts_php/server_status.php');?>

                </div>
                <br>
                </div>
                <!-- Page JS Code -->

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
