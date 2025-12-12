<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
            $id = null;
            $vid = null;
            $persona = array();
            $user_rol = null;
            $roles = array();
            $departamentos = array();
            $dias = array();

$user_mod = $_SESSION['user_id'];
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

                User::suspencion_nueva($id);
                header("Location: index.php?ref=_35");

            }else{

                $persona = User::getByUserId($id);
                $user_rol = User::userRole($id);

                $dias = tipos_dias_laborales_suspencion_igss();
            }





        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">
            <link rel="stylesheet" href="assets\js\plugins\caleandar_master\css\demo.css"/>
            <link rel="stylesheet" href="assets\js\plugins\caleandar_master\css\theme3.css"/>

            <script type="text/javascript" src="assets\js\plugins\caleandar_master\js\caleandar.js"></script>
            <script type="text/javascript" src="assets\js\plugins\caleandar_master\js\demo.js"></script>



        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">

              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Ausencias </strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo $persona->persona['user_nm1'] . ' '.$persona->persona['user_nm2'].' '.$persona->persona['user_ap1'].' '.$persona->persona['user_ap2'] ?> </span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" style="margin-top:0px;">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br>


              <div id="caleandar">

              </div>

              <form class="js-validation-iggss form-horizontal push-10-t push-10" action="" method="" id="s_form">
                <input style="visibility:hidden" type="text" id="codigo" name="codigo" value="<?php echo $persona->persona['user_vid'] ?>" style=""></input>




                <div class="form-group">
                  <div class="col-xs-12">
                    <br>
                    <div class="">

                      <label for="from ">Fecha de Suspención*</label>
                      <div class="input-daterange r input-group  has-personalizado" data-date-format="dd-mm-yyyy">
                        <input type="text" class="js-datepicker input-sm form-control r" id="from" name="from" placeholder="Fecha Inicial" required data-date-days-of-week-disabled="0,6"/>
                        <span class="input-group-addon">a</span>
                        <input type="text" class="js-datepicker input-sm form-control r" id="to" name="to" placeholder="Fecha Final" data-date-days-of-week-disabled="0,6" />
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="">
                          <label for="resolucion ">Resolución*</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                              <input class="form-control altura"  type="text"  id="resolucion" name="resolucion" value="" required>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                  <div class="col-xs-12">
                    <label for="resolucion ">Seleccione el tipo de suspención*</label>
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-arrow-circle-left"></span></span>
                      <select class="form-control miselect altura altura" name="dia" id="dia"  style="width: 100%;" required>
                        <option value="" disabled selected hidden>Seleccionar Ausencia</option>
                          <?php
                          foreach ($dias as $dia) {

                                  echo '<option value="' . $dia["dia_laboral_id"] . '">'.$dia["dia_nm"] .'</option>';

                          }
                          ?>
                      </select>
                    </div>
                  </div>
                </div>





                <!--DPI USUARIO -->
                <div class="form-group">
                  <div class="col-xs-12">

                        <div class="has-personalizado">
                          <label for="vchr_desc">Descripción</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                            <textarea class="form-control" id="sus_desc" name="sus_desc" rows="3" required></textarea>
                          </div>


                        </div>

                  </div>
                </div>

                <!-- FIN DPI -->





                <div class="form-group">
                    <div class="col-xs-12 text-center">
                        <button class="btn btn-sm btn-success btn-block" onclick="insertData(<?php echo $persona->persona['user_id'] ?>, <?php echo $user_mod?>)" ><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i> Guardar Cambios</button>
                    </div>
                </div>
              </form>
            </div>

          </div>
          <!-- Page JS Code -->
          <script>
            jQuery(function(){
                // Init page helpers (BS Datepicker plugin)
                App.initHelpers(['datepicker']);
            });
          </script><script src="usuarios/js/suspencion_form_validate.js"></script>

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
