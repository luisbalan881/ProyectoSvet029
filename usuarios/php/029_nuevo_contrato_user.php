<?php
    include_once '../../inc/functions.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('crearUsuario')) :
          $id=$_POST['id'];

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
            <style>
            #tipo_cancelacion_c{
              width:150px;
            }

            #tipo_cancelacion_c option{
              width:100px;
            }

            </style>


        </head>
        <body>
          <div class=" block block-themed  remove-margin-b">
            <span data-dismiss="modal" style="position:absolute;margin-left:1025px;z-index:5555" onclick="cargar_panel_ascensos(<?php echo $id?>)" type="button"><i class="btn-circle"></i></span>
            <div class="">

              <form class="js-validation-empleado-029-n form-horizontal push-10-t push-10" action="" method="" id="em_form">

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
                              <input class="form-control"  type="text"  id="user_acuerdo222" name="user_acuerdo222" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                      <div class="form-material">
                        <label for="fecha_acuerdo">Fecha Acuerdo*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                          <input class="js-datepicker form-control" type="text" id="fecha_acuerdo222" name="fecha_acuerdo222" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                        </div>
                      </div>
                    </div>

                    <div class="col-xs-6">
                        <div class="form-material">
                          <label for="user_partida">Partida*</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                              <input class="form-control"  type="text"  id="user_partida222" name="user_partida222" required>
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
                              <input class="form-control"  type="text"  id="user_puesto222" name="user_puesto222"  required>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-3">
                        <div class="form-material">
                            <label for="user_cargo">Cargo* (Puesto Nominal)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                              <input class="form-control"  type="text"  id="user_cargo222" name="user_cargo22"    required>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                      <div class="form-material">
                        <label for="fecha_posesion">Fecha Toma Posesión*</label>
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                          <input class="js-datepicker form-control" type="text" id="fecha_inicio222" name="fecha_inicio222" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-material">
                          <label for="salario_base ">Honorarios*</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="">Q</span></span>
                            <input class="form-control altura valor_d"  type="text"  id="salario_base11" name="salario_base11"  required>
                          </div>
                        </div>
                    </div>




                </div>
                <br>
            <span class="numberr">2</span><strong class=""> Datos del Contrato</strong><br>
            <br>
            <div class="form-group">
                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="salario_base ">Contrato No.</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                        <input class="form-control "  type="text"  id="contrato_num1" name="contrato_num1" required>
                      </div>
                    </div>
                </div>


                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="complemento_personal">Fecha del Contrato</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                        <input class="form-control js-datepicker"  type="text"  id="contrato_fecha1" name="contrato_fecha1"  data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                      </div>
                    </div>
                </div>


                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="bono_antiguedad">Fianza</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                        <input class="form-control "  type="text"  id="fianza1" name="fianza1" >
                      </div>
                    </div>
                </div>


                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="bono_profesional">Inicio y Final del Contrato</label>
                      <div class="input-group has-personalizado">
                        <input class="form-control  datepicker js-datepicker"  type="text"  id="contrato_ini1" name="contrato_ini1" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                        <span class="input-group-addon" ><span class="">a</span></span>
                        <input class="form-control  datepicker js-datepicker"  type="text"  id="contrato_fin1" name="contrato_fin1" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                      </div>
                    </div>
                </div>

            </div>









                  <div class="form-group">
                          <div class="col-xs-6">
                            <!--<label class="css-input switch <?php if($persona['user_status']==0) { echo 'switch-danger';} else if($persona['user_status']==1) { echo 'switch-success';} else if($persona['user_status']==2) { echo 'switch-warning';} ?>">
                              <input id="user_status" name="user_status" type="checkbox"  checked value="<?php echo $persona['user_status']?>"><span></span>
                              <!--<button title="Guardar Cambios" class="btn btn-primary outline "><i class="fa fa-save"></i>  </button>
                              <button title="Generar Kardex" onclick="HTMLtoPDF()" class="btn  btn-success outline " ><i class="fa fa-download"></i>  </button>-->

                            <!--</label>-->

                          </div>



                    <div class="col-xs-6 text-right">
                        <!--<a class="btn btn-sm btn-primary btn-block " onclick="HTMLtoPDF()"  id="boton_kardex"><i class="fa fa-file-o"></i> Generar Kardex</a>-->
                        <div class="btn-group btn-group-sm" role="group">
                          <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                          <div class="btn-group mr-2" role="group" aria-label="Second group">


                            <button class="btn btn-secondary btn-sm" onclick="nuevo_029(<?php echo $id?>)"><i id="loading_ne_029" style="display:none;" class="fa fa-refresh fa-spin"></i> Guardar</button>

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
