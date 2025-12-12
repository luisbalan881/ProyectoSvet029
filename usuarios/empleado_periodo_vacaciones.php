<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
            $id = null;
            $vid = null;
            $persona = array();
            $sus = array();


            date_default_timezone_set('America/Guatemala');


            if ( !empty($_GET['id'])) {
              $id = $_REQUEST['id'];
            }

            if ( !empty($_GET['vid'])) {
              $vid = $_REQUEST['vid'];
            }

            if ( null==$id ) {
              header("Location: index.php?ref=_35");
            }

            if ( !empty($_POST)) {

                //User::suspencion_nueva($id);
                header("Location: index.php?ref=_35");

            }else{

                $persona = User::getByUserId($id);
                $sus = User::get_user_suspenciones($id);
            }





        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>

            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">
            <script type='text/javascript' src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.min.js"></script>
            <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="usuarios/js/update_resolucion.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_ausencia.js"></script>

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">

              <div class="tag-green">Suspenciones</div>
              <div class="">
                  <ul class="block-options" style="margin-top:-40px;">
                      <li>
                          <button id="cerrar" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>

              <div class=" form-horizontal push-10-t push-10" >
                <br>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="form-material">
                          <label for="user_nm1">Empleado</label>
                          <input class="form-control altura"  type="text"  id="user_nm1" name="user_nm1" value="<?php echo $persona->persona['user_nm1'] . ' '.$persona->persona['user_nm2'].' '.$persona->persona['user_ap1'].' '.$persona->persona['user_ap2'] ?>" disabled>
                        </div>
                    </div>
                </div>

                <?php
                require_once('suspencion_modificar.php');
                ?>
                <div class="form-group" id="suspenciones" name="suspenciones">
                    <div class="col-xs-12" id="lista">




                    </div>

                </div>

              </div>
            </div>

          </div>
          <!-- Page JS Code -->
          <script>

$(document).ready(function(){

            get_suspenciones_list(<?php echo $persona->persona['user_id'] ?>);

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
       echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
    endif;
?>
