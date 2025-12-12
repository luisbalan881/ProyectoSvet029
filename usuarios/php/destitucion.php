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
          $literales = get_literales_029();

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

              <form class="js-validation-empleado-destitucion-m form-horizontal push-10-t push-10" action="" method="" id="em_form">

                <!-- DATOS PERSONALES -->
                <div class="row">


                <!-- FIN DATOS PERSONALES -->




                <div class="col-xs-12">

                <br>
            <span class="numberr">1</span><strong class=""> Destituir empleado</strong><br>
            <br>



            <div class="form-group">
              <?php if($persona['renglon']=='029'){?>
                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="salario_base ">Resolución No.</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                        <input class="form-control "  type="text"  id="resolucion_num" name="resolucion_num" value="<?php echo $persona['resolucion_no'] ?>" >
                      </div>
                    </div>
                </div>


                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="complemento_personal">Fecha de la Resolución</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                        <input class="form-control js-datepicker"  type="text"  id="resolucion_fecha" name="resolucion_fecha"  data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                        value = "<?php if(($persona['resolucion_fecha'])=='0000-00-00'){ echo '';}
                        else

                        {echo fecha_dmy( $persona['resolucion_fecha']); }?>">
                      </div>
                    </div>
                </div>


                <div class="col-xs-3">
                    <div class="form-material">
                      <label for="bono_antiguedad">Tipo de Cancelación</label>
                      <div class="input-group has-personalizado">
                        <span class="input-group-addon" ><span class="fa fa-times"></span></span>
                        <select class="chosen-select-width" size="3" id="tipo_cancelacion_c" name="tipo_cancelacion_c" data-placeholder="-- Seleccionar renglón --">
                          <option value="" disabled selected hidden>Seleccionar </option>
                          <?php foreach($literales as $l){
                            ?>
                            <option value="<?=$l['literal_id']?>" <?php echo (($l['literal_id'] == $persona['tipo_cancelacion_c'])?'selected':""); ?>><?=$l['literal_id'].' - '.$l['literal_desc'];?></option>
                            <?php
                          }?>
                        </select>
                      </div>
                    </div>
                </div>
              <?php }?>

                <div class="col-xs-3">
                  <div class="form-material">
                    <label for="fecha_fin">Fecha Destitución</label>
                    <div class="input-group has-personalizado">
                      <span class="input-group-addon" ><span class="fa fa-calendar-times-o"></span></span>
                      <input class="js-datepicker form-control" type="text" id="fecha_fin" name="fecha_fin" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required
                      value = "<?php if(($persona['fecha_destitucion'])=='0000-00-00'){ echo '';}
                      else

                      {echo fecha_dmy( $persona['fecha_destitucion']); }?>" >
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

                            <?php if($persona['fecha_destitucion']=='0000-00-00'){?>
                            <button class="btn btn-secondary btn-sm" onclick="destitucion_user(<?php echo $id ?>,<?php echo $c?>)"><i id="loading_me_cont" style="display:none;" class="fa fa-refresh fa-spin"></i> Guardar</button>
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
