<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
            $id = null;
            $vid = null;
            $persona = array();


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
                User::update_sueldos_empleado($id);
                header("Location: index.php?ref=_35");

            }else{

                $persona = User::get_empleado_sueldo_byId($id);
            }





        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Modificar</title>

        </head>
        <body>
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">

              <div class="col-xs-8">
                  <div id="datos_emp" class="input-group has-personalizado" style="margin-left:-15px">
                    <span id="titulo"  class="input-group-addon" disabled><strong class="">Sueldos y Bonificaciones </strong></span>
                    <span class="input-group-addon span-personalizado" type="text"><?php echo $persona['user_nm1'] . ' '.$persona['user_nm2'].' '.$persona['user_ap1'].' '.$persona['user_ap2'] ?> </span>
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

              <form class="js-validation-sueldos form-horizontal push-10-t push-10" action="" method="" id="su_form">
                <input style="visibility:hidden" type="text" id="codigo" name="codigo" value="<?php echo $persona['user_id'] ?>" style=""></input>




                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="">
                          <label for="salario_base ">Salario Base*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="salario_base" name="salario_base" value="<?php echo $persona['salario_base'] ?>" required>
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="">
                          <label for="complemento_personal">Complemento Personal</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="complemento_personal" name="complemento_personal" value="<?php echo $persona['complemento_personal'] ?>" >
                          </div>
                        </div>
                    </div>

                </div>

                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="">
                          <label for="bono_antiguedad">Bono por Antigüedad</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="bono_antiguedad" name="bono_antiguedad" value="<?php echo $persona['bono_antiguedad'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="">
                          <label for="bono_profesional">Bono Profesional</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="bono_profesional" name="bono_profesional" value="<?php echo $persona['bono_profesional'] ?>" >
                          </div>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="">
                          <label for="bono_vicepresidencial">Bono Vicepresidencial</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="bono_vicepresidencial" name="bono_vicepresidencial" value="<?php echo $persona['bono_vicepresidencial'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="">
                          <label for="bono_66_2000">Bono 66-2000</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="bono_66_2000" name="bono_66_2000" value="<?php echo $persona['bono_66_2000'] ?>" >
                          </div>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-xs-6">
                        <div class="">
                          <label for="gastos_de_representacion">Gastos de Representación</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="gastos_de_representacion" name="gastos_de_representacion" value="<?php echo $persona['gastos_de_representacion'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-6">
                        <div class="">
                          <label for="viaticos">Viáticos</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="viaticos" name="viaticos" value="<?php echo $persona['viaticos'] ?>" >
                          </div>
                        </div>
                    </div>

                </div>
                <?php

                if (($persona['renglon']=='011') || ($persona['renglon']=='022')){
                ?>
                <br>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="">

                          <div class="">

                            <input class=" valor_d text_money"  type="text"  value="<?php echo $persona['sueldo'] ?>" id="totaly" disabled>
                          </div>
                        </div>
                    </div>
                  </div>
                <div class="form-group">
                    <div class="col-xs-4">
                        <div class="">
                          <label for="igss">I.G.S.S.</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="igss" name="igss" value="<?php echo $persona['igss'] ?>" type="number">
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-4">
                        <div class="">
                          <label for="montepio">Montepio</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="montepio" name="montepio" value="<?php echo $persona['montepio'] ?>" type="number">
                          </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="">
                          <label for="decreto_81_70">Decreto 81-70</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="decreto_81_70" name="decreto_81_70" value="<?php echo $persona['decreto_81_70'] ?>" type="number">
                          </div>
                        </div>
                    </div>

                </div>
                <?php
              }
                ?>
                <br>
                <div class="form-group">
                    <div class="col-xs-12">
                        <div class="">
                          <div class="">

                            <input class="text_money  valor_d"  type="text"  value="<?php echo $persona['liquido'] ?>" id="liquido" disabled>
                          </div>
                        </div>
                    </div>
                  </div>


                <div class="form-group">
                  <div class="col-xs-6">
                  </div>
                    <div class="col-xs-6 text-center">
                        <button class="btn btn-sm btn-secondary btn-block" onclick="update_sueldo_user(<?php echo $persona['user_id']; ?>)"><i style="display:none;" id="loading" class="fa fa-refresh fa-spin"></i> </i>Guardar Cambios</button>
                    </div>
                </div>
              </form>
            </div>

          </div>
          <!-- Page JS Code -->
          <script>

          </script>
          <script src="usuarios/js/sueldo_form_validate.js"></script>
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
