<?php
    include_once '../inc/functions.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('Configuracion') || verificar_director($user->persona['user_id'])==1) :
            $id = $_POST['id'];
            $fee = $_POST['fee'];





                $dias = tipos_dias_laborales();



        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <script src="administrador/js/fechas.js"></script>
        </head>
        <body>
          <div class="modal-r-little block block-themed remove-margin-b">
            <div class="block-header">
              <h3 class="">Actualizar Dia</h3>
            </div>

            <div class="block-content ">

              <div class="col-xs-13 ">
                                  <select class="form-control miselect" name="dia" id="dia"  style="width: 100%;" >

                                      <?php
                                      foreach ($dias as $dia) {

                                              echo '<option value="' . $dia["dia_laboral_id"] . '">'.$dia["dia_nm"] .'</option>';

                                      }
                                      ?>
                                  </select>

                              </div>
                              <br>


              <div class="form-group">

                <div class="col-xs-13 text-center">
                    <button id="btnGuardar" name="btnGuardar" onclick="update_tipo_date(<?php echo $id ?>, '<?php echo $fee ?>')"
                    class="btn btn-sm btn-success btn-block" type="submit">
                    <i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i> Actualizar</button>

                </div>
              </div>
              <div class="form-group">
                <div id="message"></div>
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
       //echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
    endif;
?>
