<?php
    include_once '../../inc/functions.php';
    include_once 'funciones.php';
    include_once '../../transporte/php/funciones.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
          $id=$_SESSION['user_id'];
          $year=null;
          $mes=null;
          $solicitud=null;
          $correlativo=null;
          $dep_id=null;
          $comision_status=null;
          $estado_solicitud=null;

          $comisiones=array();
          if ( !empty($_GET['year'])) {
            $year = $_REQUEST['year'];
          }

          if ( !empty($_GET['mes'])) {
            $mes = $_REQUEST['mes'];
          }
          if ( !empty($_GET['solicitud_id'])) {
            $solicitud = $_REQUEST['solicitud_id'];
          }
          if ( !empty($_GET['correlativo'])) {
            $correlativo = $_REQUEST['correlativo'];
          }
          if ( !empty($_GET['dep_id'])) {
            $dep_id = $_REQUEST['dep_id'];
          }

            $comision_status = $_REQUEST['comision_status'];


            $estado_solicitud = $_REQUEST['estado_solicitud'];


          $comisiones=solicitudes_list();

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title></title>

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="col-xs-4">
                <div class="input-group has-personalizado" style="margin-left:-15px">
                  <span class="input-group-addon" disabled><strong class="">
                    <?php
                    if($comision_status!=0)
                    {
                      echo 'Comisión Vicepresidencial';
                    }
                    else{
                      echo 'Establecer Comisión';
                    }
                    ?>
                  </strong></span>
                  <span class="input-group-addon span-personalizado" type="text"><?php echo '#'. $correlativo .' del mes de '. get_nombre_mes($mes) .' de '.$year?> </span>
                </div>
              </div>
              <div class="">
                <ul class="block-options2" style="margin-top:0px;">
                  <li>
                    <button id="retornar_1" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                  </li>
                </ul>
              </div>
              <br>
              <br>
              <br>
              <div id="tema" >
              </div>
            </div>
          </div>



          <!-- Page JS Code -->


        </body>
        </html>
        <script src="combustible/js/establecer_comision_solicitud_form_validate.js"></script>
        <script>
        $(document).ready(function(){
          get_transporte_por_cupones(<?php echo $year?>,<?php echo '"'.$mes.'"'?>,<?php echo $solicitud ?>,<?php echo $dep_id?>,<?php echo $estado_solicitud?>,<?php echo $comision_status ?>);

        });
        </script>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
