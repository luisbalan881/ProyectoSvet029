<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearPiloto')) :
          $id=$_SESSION['user_id'];
          $driver = null;

          if ( !empty($_GET['conductor_id'])) {
            $driver = $_REQUEST['conductor_id'];
          }
          include_once 'php/funciones.php';

          $piloto = get_piloto_by_id($driver);
          $personas = personas();
          $departamentos = departamentos();
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>
            <script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">



        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">
              <div class="col-xs-6">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Modificar Piloto :</strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo $piloto['NOMBRE']; ?> </span>
                  </div>
              </div>
              <div class="">
                  <ul class="block-options2" >
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>
              <br><br><br>
              <form class="js-validation-piloto-modificar form-horizontal push-10-t push-10">

                <div class="form-group">
                  <div class="col-xs-6">
                      <div class=""style="margin-top:-15px">
                        <label for="tipo">Crear Piloto*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" disabled><span class="si si-user"></span></span>
                          <input class="form-control"    id="co" name="co" value="<?php echo $piloto['NOMBRE'] ?>" disabled required>


                        </div>
                      </div>
                  </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="marca">Departamento a Asignar*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="si si-home"></span></span>
                            <select name="dep_id"  id="dep_id" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar Departamento --" required>
                              <option value"" selected disabled></option>
                              <?php
                                  foreach ($departamentos as $n):
                                      echo '<option value="'.$n['dep_id'].'"';
                                      if($piloto['dep_id']==$n['dep_id']){ echo 'selected';}
                                      echo '>'.$n['dep_nm'].'</option>';
                                  endforeach
                              ?>

                              </select>

                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-material ">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-credit-card"></span></span>
                            <input class="form-control"  type="number"  id="licencia" name="licencia" value="<?php echo $piloto['licencia_num'] ?>" required>
                          </div>
                          <label for="soli_tiempo">Licencia No.*</label>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-6">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                            <input class="form-control js-datepicker"    id="fecha_cad" name="fecha_cad" value="<?php echo fecha_dmy($piloto['licencia_cad'])?>" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  required>
                          </div>
                          <label for="modelo">Fecha Caducidad*</label>
                        </div>
                    </div>
                </div>






                <div class="form-group">
                  <div class="col-sm-12 text-center">
                      <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="editar_conductor(<?php echo $piloto['user_id'] ?>)" ><i id="loading_pi_mo" class="fa fa-refresh fa-spin" style="display:none;"></i> Guardar Cambios</button>
                  </div>
                </div>



              </form>
            </div>
          </div>



          <!-- Page JS Code -->
          <script src="transporte/js/piloto_form_validate.js"></script>

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
