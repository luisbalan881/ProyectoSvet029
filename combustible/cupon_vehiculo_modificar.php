<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearCupon')) :
          $id=$_SESSION['user_id'];
          $fecha=null;
          $vehiculo=null;
          if ( !empty($_GET['fecha'])) {
            $fecha = $_REQUEST['fecha'];
          }

          if ( !empty($_GET['vehiculo_id'])) {
            $vehiculo = $_REQUEST['vehiculo_id'];
          }
          //$date = date('Y-m-d', strtotime($fecha));
          include_once 'php/funciones.php';
          $cupones = get_cupones_utilizados_by_id($fecha,$vehiculo);
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">
            <div class="block-content">
              <div class="tag-green">Actualizar Kilometraje</div>
            <div class="">
                <ul class="block-options2" style="margin-top:-40px;">
                    <li>
                        <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                    </li>
                </ul>
                <br>
            </div>
            <form class="js-validation-kilometros form-horizontal push-10-t push-10">
              <div class="form-group">
                <div class="col-xs-5">
                  <div class="">
                    <label for="ext_id">Vehículo</label>
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" disabled><span class="fa fa-car"></span></span>
                      <input class="form-control " type="text" value="<?php echo /*$cupones['placa']. ' - '.*/$cupones['nombre']. ' '.$cupones['linea'] ?>" disabled>
                    </div>

                  </div>
                </div>
                <div class="col-xs-7">
                    <div class="">
                      <label for="ext_id">Conductor</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" disabled><span class="fa fa-user"></span></span>
                        <input class="form-control" type="text" value="<?php echo $cupones['NOMBRE'] ?>" disabled>
                      </div>

                    </div>
                  </div>
                </div>

              <div class="form-group">
                <div class="col-xs-5">
                    <div class="">
                      <label for="ext_id">Fecha</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" disabled><span class="fa fa-calendar-check-o"></span></span>
                        <input class="form-control" type="text" id="fecha_en" name="fecha_en" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" value="<?php echo $fecha ?>" required disabled>
                      </div>

                    </div>
                  </div>
                  <div class="col-xs-7">
                    <div class="">

                        <label for="destinatarios">Cupon (es)</label>


                          <?php
                          $tickets=explode(",",$cupones['cupones']);

                          $x = 1;
                            foreach($tickets as $t)
                            {
                              echo '<div class="input-group has-personalizado" ><span class="input-group-addon" disabled ><span class="fa fa-ticket"></span></span>
                              <div class=" form-control" type="text" id="cupones" name="cupones" required disabled>';
                              echo '<span class="label ">Cupon '.$x.'</span>  ';
                              $va=explode("-",$t);
                              foreach($va as $v)
                              {
                                echo '<span class="label label-danger label-pesonalizado" style="float:right; width:60px; margin-left:3px;margin-top:2px;">'.$v.'</span>  ';

                              }
                              echo '';
                              $x++;
                              echo'</div></div>';
                            }
                          ?>



                    </div>
                  </div>
              </div>
              <div class="form-group">
                <div class="col-xs-5">
                </div>
                <div class="col-xs-7">
                    <div class="">
                      <label for="ext_id">Total</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" disabled><span class="">Q</span></span>
                        <input class="form-control valor_d" type="text" value="<?php echo $cupones['montos'] ?>" disabled>
                      </div>

                    </div>
                  </div>
                </div>

              <div class="form-group">
                <div class="col-xs-12">
                  <div class="form-material">
                    <div class="input-group has-personalizado">


                      <input class="form-control"  type="number"  id="km_ini" name="km_ini" value="<?php echo $cupones['km_inicio'] ?>" placeholder="Kilometraje Inicial"  enabled required>
                      <span class="input-group-addon" ><span>a</span></span>
                      <input class="form-control"  type="number"  id="km_fin" name="m_fin" value="<?php echo $cupones['km_final'] ?>" placeholder="Kilometraje Final" enabled required>
                    </div>
                      <label for="user_mail">Kilometraje*</label>
                  </div>
                </div>
              </div>


                <div class="form-group">
                  <div class="col-xs-12 text-center">
                      <button class="btn btn-sm btn-success btn-block" onclick="asignar_kilometros(<?php echo $id ?>,<?php echo $cupones['vehiculo_id'] ?>)" id="boton_a_u" ><i style="display:none;" id="loading_cu" class="fa fa-refresh fa-spin"></i> Asignar Kilómetros</button>
                  </div>
                </div>
            </form>



          <!-- Page JS Code -->
          <script src="combustible/js/kilometros_form_validate.js"></script>

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
