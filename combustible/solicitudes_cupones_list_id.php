<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
          $year=null;
          $mes=null;
          $solicitud=null;
          $correlativo=null;
          $dep_id=null;
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
            include_once 'php/funciones.php';

            $es = $estado= get_estado_solicitud($year,$mes,$solicitud,$dep_id);



            date_default_timezone_set('America/Guatemala');

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Cupones</title>
            <link rel="stylesheet" href="../herramientas/administrador/css/build.css">

            <script src="combustible/js/load_solicitud_by_id.js"></script>
            <script src="combustible/js/asignar_fecha_autorizado.js"></script>
            <script src="assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_cupones.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

            <?php if($es['estado_solicitud']==0 && permiso_perm(1)) {?>
              <link href="assets/js/plugins/x-editable/bootstrap-editable.css" rel="stylesheet"/>
              <script src="assets/js/plugins/x-editable/bootstrap-editable.min.js"></script>
              <script>
              var options = [
              {value: '50.00', text: '. 50.00'},
              {value: '100.00', text: '100.00'},
              {value: '150.00', text: '150.00'},
              {value: '200.00', text: '200.00'},
              {value: '250.00', text: '250.00'},
              {value: '300.00', text: '300.00'},
              {value: '350.00', text: '350.00'},
              {value: '400.00', text: '400.00'},
              {value: '450.00', text: '450.00'},
              {value: '500.00', text: '500.00'},
              {value: '550.00', text: '550.00'},
              {value: '600.00', text: '600.00'},
              {value: '650.00', text: '650.00'},
              {value: '700.00', text: '700.00'},
			  {value: '2000.00', text: '2000.00'},
              {value: '2500.00', text: '2500.00'},
              {value: '3000.00', text: '3000.00'}
              ];
              </script>
            <?php }?>


            <style>

            @media print {
              .panel-heading {display:none}
              .tag-green { display:none }
              .block-options2 { display:none }
              .page-heading{display: none;}
              #tabla{ display: none;}
              #tabla1{ display: none; }
              #d{ display: none; }
              #de{display: none; }
              button{ display: none }
              #suspenciones {transform: scale(0.9);padding-top: 0.5cm;}
              #datos_emp{transform: scale(0.9);padding-top: 1cm; padding-left: -10cm}
              #page-footer{display: none}
              #datos_emp{font-size: 16px;}
              #printe{display: none;}

            }
            </style>

        </head>

        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="col-xs-4">
                  <div class="input-group has-personalizado" style="margin-left:-15px">
                    <span class="input-group-addon" disabled><strong class="">Solicitud </strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo '#'. $correlativo .' del mes de '. get_nombre_mes($mes) .' de '.$year?> </span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" style="margin-top:0px;">
                      <li>
                          <button id="cerrar_this" data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>
              </div>
              <br><br><br>
              <div class="form-material" id="lista">
                <div>
                  <!--<button class="btn btn-block btn-sm btn-success" id="save_solicitud_cupones"><i id="loading_soli_cu" style="display:none" class="fa fa-refresh fa-spin"></i> Generar Solicitud</button>-->
                  <p></p>
                </div>
              </div>
            </div>

          </div>
          <div  class="notificacion_alerta">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <i id="icono_n"></i><h1 id="message_notificacion"></h1>
          </div>

          <!-- Page JS Code -->
          <script>
          $(document).ready(function(){
            load_solicitud_id(<?php echo $year?>,<?php echo '"'.$mes.'"'?>,<?php echo $solicitud ?>,<?php echo $dep_id?>);

          });



          </script>


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
