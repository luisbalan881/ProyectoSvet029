<?php
    include_once '../inc/functions.php';
    include_once 'php/get_solicitud.php';

    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('leerSolicitudTransporte') ) :
            $id = null;
            $user = $_SESSION['user_id'];
            //$solicitud = $_POST['id'];
            //$fee = $_POST['fee'];
            if ( !empty($_GET['id'])) {
              $id = $_REQUEST['id'];
            }

            $solicitud = get_solicitud_by_id($id);

                //$dias = tipos_dias_laborales();



        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Transporte</title>
            <script src="transporte/js/funciones.js"></script>




        </head>

        <body>
          <div class=" ">
            <div class="block-header">

              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Solicitud No.</strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo $solicitud['IDX']?> </span>
                  </div>
              </div>

              <div class="">
                  <ul class="block-options2" style="margin-top:00px;">
                      <li>
                          <button id="cerrar_esto" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <div  class="notificacion_alerta">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <i id="icono_n"></i><h1 id="message_notificacion"></h1>
              </div>

              <div  class="notificacion_alerta_success_modal">
                <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                <i id="icono_n11"></i><h1 id="message_notificacion11"></h1>
              </div>


              <div class="col-xs-6">
                <div class="car_move">
                  <!--<img src="assets/img/vehicle/car-trip.png">-->
                </div>
              </div>
            </div>

            <div class="block-content " id="tabla">

            </div>




        </body>


        </html>
        <script>
          $(document).ready(function(){
            load_solicitud_id(<?php echo $id?>);
          });
        </script>

        <?php
      else :
            echo include(unauthorizedModal());
        endif;
    else:
       //echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
    endif;
?>
