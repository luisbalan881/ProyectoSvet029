<?php
    include_once '../../inc/functions.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearUsuario')) :
          $id=$_POST['id'];
          $c = $_POST['correlativo'];
          $persona = User::get_empleado_datos_id_por_correlativo($id,$c);
          $persona1 = User::get_empleado_sueldo_byId_por_correlativo($id,$c);

          $horas = tipo_de_horarios();

          $nacionalidades = get_nacionalidades();
          $estado_civil = get_estado_civil();
          $genero = get_genero();
          $sueldo = User::get_empleado_sueldo_byId($id);

          if(verificar_director($_SESSION['user_id'])==1 || usuarioPrivilegiado()->hasPrivilege('Configuracion') || (permiso_dep(8)&&permiso_dep(9)))
          {
            $renglones = get_renglones(0);
          }
          else if(permiso_dep(8)){
            $renglones = get_renglones_011_022(0);
          }
          else if(permiso_dep(9)){
            $renglones = get_renglones_029(0);
          }
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


        </head>
        <body>
          <div class=" block block-themed  remove-margin-b">
            <span data-dismiss="modal" style="position:absolute;margin-left:1025px;z-index:5555" onclick="cargar_panel_ascensos(<?php echo $id?>)" type="button"><i class="btn-circle"></i></span>
            <div class="">

              <form class="js-validation-empleado-011-m form-horizontal push-10-t push-10" action="" method="" id="em_form">

                <!-- DATOS PERSONALES -->
                <div class="row">


                <!-- FIN DATOS PERSONALES -->




                <div class="col-xs-12">
                  <span class="numberr">1</span><strong class=""> Datos Laborales</strong><br>
                  <br>
                  <div class="form-group">
                    <div class="col-xs-3">
                        <div class="form-material">
                            <label for="user_acuerdo">Acuerdo No.*</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-newspaper-o"></span></span>
                              <input class="form-control"  type="text"  id="user_acuerdo22" name="user_acuerdo22"  value="<?php echo $persona['acuerdo_vice'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                      <div class="form-material">
                        <label for="fecha_acuerdo">Fecha Acuerdo*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                          <input class="js-datepicker form-control" type="text" id="fecha_acuerdo22" name="fecha_acuerdo22" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                          value = "<?php if(($persona['fecha_acuerdo'])=='0000-00-00'){ echo '';}
                          else

                          {echo fecha_dmy( $persona['fecha_acuerdo']); }?>" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="user_partida">Partida*</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                              <input class="form-control"  type="text"  id="user_partida22" name="user_partida22"  value="<?php echo $persona['partida'] ?>" required>
                            </div>
                        </div>
                    </div>


                  </div>

                  <div class="form-group">

                    <div class="col-xs-3">
                        <div class="form-material">
                            <label for="user_puesto">Puesto Funcional</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                              <input class="form-control"  type="text"  id="user_puesto22" name="user_puesto22"  value="<?php echo $persona['user_puesto'] ?>"required>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <div class="form-material">
                            <label for="user_cargo">Cargo* (Puesto Nominal)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                              <input class="form-control"  type="text"  id="user_cargo22" name="user_cargo22"   value="<?php echo $persona['user_nom'] ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                      <div class="form-material">
                        <label for="fecha_posesion">Fecha Toma Posesión*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                          <input class="js-datepicker form-control" type="text" id="fecha_inicio22" name="fecha_inicio22" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                          value = "<?php if(($persona['inicio_laboral'])=='0000-00-00'){ echo '';}
                          else

                          {echo fecha_dmy( $persona['inicio_laboral']); }?>"required>
                        </div>
                      </div>
                    </div>


                    <div class="col-xs-3">
                      <div class="form-material">
                        <label for="fecha_fin">Fecha Destitución</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                          <input class="js-datepicker form-control" type="text" id="fecha_fin22" name="fecha_fin22" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                          value = "<?php if(($persona['fecha_destitucion'])=='0000-00-00'){ echo '';}
                          else

                          {echo fecha_dmy( $persona['fecha_destitucion']); }?>" >
                        </div>
                      </div>
                    </div>

                </div>
                <br>
                <div class="col-sm-6" style="margin-top:-10px;"><span style="margin-top:-30px; margin-left:-15px" class="numberr">2</span><strong class=""> Sueldos</strong></div><div class="col-sm-6 text-right"><input class="text_money2 valor_d"  type="text"  value="<?php echo $persona['liquido'] ?>" id="liquido" disabled></div><br>
                <br>
                <div class="form-group">
                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="salario_base ">Salario Base*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="salario_base" name="salario_base" value="<?php echo $persona1['salario_base'] ?>" required>
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="complemento_personal">Complemento Personal</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="complemento_personal" name="complemento_personal" value="<?php echo $persona1['complemento_personal'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="bono_antiguedad">Bono por Antigüedad</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="bono_antiguedad" name="bono_antiguedad" value="<?php echo $persona1['bono_antiguedad'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="bono_profesional">Bono Profesional</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="bono_profesional" name="bono_profesional" value="<?php echo $persona1['bono_profesional'] ?>" >
                          </div>
                        </div>
                    </div>

                </div>
                <div class="form-group">
                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="bono_vicepresidencial">Bono Vicepresidencial</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="bono_vicepresidencial" name="bono_vicepresidencial" value="<?php echo $persona1['bono_vicepresidencial'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="bono_66_2000">Bono 66-2000</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="bono_66_2000" name="bono_66_2000" value="<?php echo $persona1['bono_66_2000'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="gastos_de_representacion">Gastos de Representación</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="gastos_de_representacion" name="gastos_de_representacion" value="<?php echo $persona1['gastos_de_representacion'] ?>" >
                          </div>
                        </div>
                    </div>


                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="viaticos">Viáticos</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control  valor_d"  type="text"  id="viaticos" name="viaticos" value="<?php echo $persona1['viaticos'] ?>" >
                          </div>
                        </div>
                    </div>

                </div>

              </div>
            </div>




                  <div class="form-group">
                          <div class="col-xs-6">

                          </div>



                    <div class="col-xs-6 text-right">
                        <!--<a class="btn btn-sm btn-primary btn-block " onclick="HTMLtoPDF()"  id="boton_kardex"><i class="fa fa-file-o"></i> Generar Kardex</a>-->
                        <div class="btn-group btn-group-sm" role="group">
                          <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                          <div class="btn-group mr-2" role="group" aria-label="Second group">
                            <button class="btn btn-secondary btn-sm">Kardex</button>
                            <?php if($persona['fecha_destitucion']=='0000-00-00'){?>
                            <button class="btn btn-secondary btn-sm" onclick="modificar_011(<?php echo $id ?>,<?php echo $c?>)"><i id="loading_me_011" style="display:none;" class="fa fa-refresh fa-spin"></i> Guardar</button>
                          <?php }else{
                            echo 'Este documento ya fue finalizado';
                          }?>

                          </div>
                        </div>

                        </div>
                    </div>
                  </div>

              </form>
            <!-- Page JS Code -->
          </div>
        </div>
          <script>
              jQuery(function(){
                  // Init page helpers (Select2 Inputs plugins)
                  App.initHelpers(['select2']);
              });
          </script>
          <script>
          $(document).ready(function() {
          //this calculates values automatically

            sum2();
            $("#salario_base, #complemento_personal, #bono_antiguedad, #bono_profesional,#bono_vicepresidencial,#bono_66_2000,#gastos_de_representacion,#viaticos").on("keydown keyup", function() {
            sum2();
            });


          });

          </script>
          <script src="usuarios/js/empleado_modificar_form_validate.js"></script>

        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       //echo "<script type='text/javascript'> window.location='../index.ph'; </script>";
    endif;
?>
