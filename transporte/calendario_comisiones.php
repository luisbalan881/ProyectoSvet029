<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearPiloto')) :
          $id=$_SESSION['user_id'];

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <link rel="stylesheet" href="assets\js\plugins\caleandar_master\css\demo.css"/>
            <link rel="stylesheet" href="assets\js\plugins\caleandar_master\css\theme3.css"/>

            <script type="text/javascript" src="assets\js\plugins\caleandar_master\js\caleandar.js"></script>
            <script type="text/javascript" src="assets\js\plugins\caleandar_master\js\comisiones.js"></script>




        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">
              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Calendario de Comisiones</strong></span>
                    <span class="input-group-addon span-personalizado" type="text">Comisiones</span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" >
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br>
              <div id="caleandar">
              </div>



            </div>


          </div>



          <!-- Page JS Code -->


        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
