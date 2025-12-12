<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('crearUsuario')):
          $id = null;
            $error_msg = '';
            $departamentos = array();
            $roles = array();
            $horas = array();
            $renglones = array();
            $nacionalidades = array();
            $persona = array();
            $genero = array();
            $estado_civil = array();

            $sueldo = array();
            if ( !empty($_GET['id'])) {
              $id = $_REQUEST['id'];
            }

            if ( !empty($_POST)){
                //User::usuarioNuevo();
                //User::update_empleado_datos_id($id);
                header("Location: index.php?ref=_35");
            }else{
                $persona = User::get_empleado_datos_id($id);


            }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                <title>Usuario Nueva</title>
                <script src="usuarios/js/show_panel.js"></script>
                <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

                <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>
                <script src="../herramientas/assets/js/plugins/jspdf/kardex_empleado.js"></script>
                <script type="text/javascript" src="../herramientas/assets/js/plugins/file_style/bootstrap-filestyle.min.js"> </script>
                <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

                <script>
                $('#foto').filestyle({});
              </script>



            </head>
            <body>
                <div class="block block-themed card remove-margin-b">
                  <div class="content-boxed" style="width:98%">
                    <div class="row">
                      <div class="col-sm-2">
                        <div class="img-contenedor_profile">
                          <?php if($persona['fotografia']!='')
                          {
                            echo '<img class="" src="usuarios/fotos/'.$persona['fotografia'].'"></img>';
                          }
                          else{
                            echo '<img class="img_foto_user_profile2" src="usuarios/fotos/avatar6.png"></img>';
                          }?>
                        </div>
                      </div>

                      <div class="col-sm-10 empleado_datos"  style="height:80px; margin-top:45px">
                        <div class="panel-body">
                          <div class="row">

                            <div class="col-sm-5" style="margin-left:120px">
                              <h1><?php echo $persona['user_nm1']. ' '.$persona['user_nm2']. ' '. $persona['user_ap1']. ' '.$persona['user_ap2']?></h1>
                              <?php if($persona['user_status']==0){
                                echo '<span class="label label-danger-footer">Inactivo</span>';
                              }else if($persona['user_status']==1){
                                echo '<span class="label label-success">Activo</span>';
                              }else if($persona['user_status']==2){
                                echo '<span class="label label-warning">Activar</span>';
                              }
                              ?>
                            </div>
                            <div class="col-sm-4 data_uss" style="margin-left:-40px">
                              <h2><i class="fa fa-envelope"></i> <?php if($persona['user_mail']!=''){ echo $persona['user_mail'];}?></h2>
                              <h2><i class="fa fa-phone"></i> <?php if($persona['ext_id']!=0){echo '<span> </span>'.$persona['ext_id'];}?></h2>

                            </div>
                            <div class="col-sm-1 data_uss">
                              <h3><?php /*if($persona['renglon']!='000'){echo $persona['renglon'];}*/?></h3>
                            </div>
                          </div>

                        </div>
                      </div>

                    </div>

                    <div class="">
                      <ul id="controles" class="" style="margin-top:-40px; margin-right:2px;z-index:999999;float:right">
                        <div class="btn-group" data-toggle="buttons">
                          <!-- class="input-group-addon" -->
                          <label class="btn btn-third btn-sm " id="xyx">
                            <input type="radio" name="options" id="option1" onchange="cargar_panel(<?php echo $id?>)" >Perfil
                          </label>
                          <?php if ($persona['renglon']=='029' || $persona['renglon']=='011' || $persona['renglon']=='022'){?>
                          <label class="btn btn-third btn-sm">
                            <input type="radio" name="options" id="option2" onchange="cargar_panel_ascensos(<?php echo $id?>)" >
                            <?php if($persona['renglon']=='029'){
                              echo 'Contratos';
                            }
                            else
                              if($persona['renglon']=='011' ){
                                echo 'Ascensos';
                              }
                              else
                                if($persona['renglon']=='022' ){
                                  echo '022';
                                }
                            ?>
                          </label>
                          <?php }?>
                          <button type="button" data-dismiss="modal" class="btn btn-third btn-sm">Salir</button>
                        </div>








                      </ul>


                  </div>
                  </div>



                  <br>

                <div id="template" class="block-content">

                </div>
                <script>
                $( document ).ready(function() {
                  cargar_panel(<?php echo $id?>);
                  $('#controles').fadeOut(0).fadeIn(2000);
                  $('#xyx').addClass('contorno2');
                });
                </script>
            </body>
        </html>
        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
        echo "<script type='text/javascript'> window.location='inicio.php'; </script>";
endif;
?>
