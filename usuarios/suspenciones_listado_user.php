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

            <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="usuarios/js/update_resolucion.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_ausencia.js"></script>

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

              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span  class="input-group-addon" disabled><strong id="titulo" class="">Ausencias </strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo $persona->persona['user_nm1'] . ' '.$persona->persona['user_nm2'].' '.$persona->persona['user_ap1'].' '.$persona->persona['user_ap2'] ?> </span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" style="">

                      <div class="btn-group" data-toggle="buttons">
                        <!-- class="input-group-addon" -->
                        <label class="btn btn-secondary btn-sm " id="xx">
                          <input type="radio" name="options" id="option1" onchange="get_suspenciones_list(<?php echo $persona->persona['user_id'] ?>, <?php echo $_SESSION['user_id']?>);" >Ausencias
                        </label>
                        <label class="btn btn-secondary btn-sm">
                          <input type="radio" name="options" id="option2" onchange="load_periodo_list(<?php echo $persona->persona['user_id'] ?>,<?php echo $_SESSION['user_id']?>);" >Períodos
                        </label>
                        <button type="button" data-dismiss="modal" class="btn btn-secondary btn-sm">Salir</button>
                      </div>
                    </ul>


              </div>
              

              <div class=" form-horizontal push-10-t push-10" >
                <br>



                <div class="form-group">
                    <div class="col-xs-12" id="lista">




                    </div>

                </div>

              </div>
            </div>

          </div>

          <!-- Page JS Code -->
          <script>



              $(document).ready(function(){
                get_suspenciones_list(<?php echo $persona->persona['user_id'] ?>, <?php echo $_SESSION['user_id']?>);
                $('#xx').addClass('contorno');
              });
              function imprimir() {
                  print();
              }
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
