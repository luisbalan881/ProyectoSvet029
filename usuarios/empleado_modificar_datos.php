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

              $id = $_POST['id'];



                $persona = User::get_empleado_datos_id($id);
                $departamentos = departamentos();
                $roles = roles();
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
                <title>Usuario Nueva</title>
                <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

                <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>
                <script src="../herramientas/assets/js/plugins/jspdf/kardex_empleado.js"></script>
                <script type="text/javascript" src="../herramientas/assets/js/plugins/file_style/bootstrap-filestyle.min.js"> </script>

                <script>
                $('#foto').filestyle({});
              </script>



            </head>
            <body>


                <div class="">


                    <form class="js-validation-empleado form-horizontal push-10-t push-10" action="" method="" id="em_form">

                      <!-- DATOS PERSONALES -->
                      <div class="row">
                      <div class="col-xs-6">
                        <span class="numberr">1</span><strong class=""> Datos Personales</strong><br>
                        <br>
                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_nm11">Primer Nombre*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="si si-user"></span></span>
                                  <input class="form-control"  type="text"  id="user_nm11" name="user_nm11"  value="<?php echo $persona['user_nm1'] ?>" required>
                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_nm22">Segundo Nombre</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="si si-user"></span></span>
                                    <input class="form-control"  type="text"  id="user_nm22" name="user_nm22" value="<?php echo $persona['user_nm2'] ?>" >
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_ap11">Primer Apellido*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="si si-user"></span></span>
                                    <input class="form-control"  type="text"  id="user_ap11" name="user_ap11" value="<?php echo $persona['user_ap1'] ?>" required>
                                  </div>
                              </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_ap22">Segundo Apellido</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="si si-user"></span></span>
                                    <input class="form-control"  type="text"  id="user_ap22" name="user_ap22" value="<?php echo $persona['user_ap2'] ?>">
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">

                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_nac">Fecha Nacimiento*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_nac" name="fecha_nac" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                                value = "<?php if(($persona['f_n'])=='0000-00-00'){ echo '';}
                                else

                                {echo fecha_dmy( $persona['f_n']); }?>" required>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_lugar_nac">Lugar Nacimiento*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                    <input class="form-control"  type="text"  id="user_lugar_nac" name="user_lugar_nac"  value="<?php echo $persona['user_lugar_nac'] ?>"required>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_genre">Género</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                  <select class ="form-control" name="user_genre"  id="user_genre" style="width: 100%;" data-placeholder="-- Seleccionar género" required>
                                    <option value="" disabled selected hidden>Seleccionar Género</option>
                                    <?php
                                        foreach ($genero as $n):
                                            ?>
                                            <option value="<?=$n['genero_id']?>" <?php echo (($n['genero_id'] == $persona['user_genero'])?'selected':""); ?>><?=$n['genero_nm'];?></option>
                                            <?php
                                        endforeach
                                    ?>
                                  </select>
                                </div>
                              </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_civil">Estado Civil*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                  <select class ="form-control" name="user_civil"  id="user_civil" style="width: 100%;" data-placeholder="-- Seleccionar estado civil" required>
                                    <option value="" disabled selected hidden>Estado Civil</option>
                                    <?php
                                        foreach ($estado_civil as $n):
                                            ?>
                                            <option value="<?=$n['estado_civil_id']?>" <?php echo (($n['estado_civil_id'] == $persona['user_estado_civil'])?'selected':""); ?>><?=$n['estado_civil_nm'];?></option>
                                            <?php
                                        endforeach
                                    ?>
                                  </select>
                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">

                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_direccion">CUI*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-user"></span></span>
                                  <input class="form-control"  type="text"  id="user_cui" name="user_cui"  type="number" value="<?php echo $persona['user_cui'] ?>"required>
                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_movil">Móvil*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-phone"></span></span>
                                  <input class="form-control"  type="text"  id="user_movil" name="user_movil"   type="number" value="<?php echo $persona['user_movil'] ?>"required>
                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_prof">Profesión u Oficio*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-briefcase"></span></span>
                                  <input <select class ="form-control" name="user_prof"  id="user_prof" style="width: 100%;" value="<?php echo $persona['user_profesion'] ?>"required>
                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_direccion">Dirección de residencia*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                  <input class="form-control"  type="text"  id="user_direccion" name="user_direccion"  value="<?php echo $persona['user_direccion'] ?>"required>
                                </div>
                              </div>
                          </div>



                        </div>
                        <div class="form-group">
                          <div class="col-xs-12">
                              <div class="" >

                                <div class=""style="margin-top:-14px;">
                                  <label for="foto">Fotografía </label> <span class="fa fa-camera"></span> <label id="fotografia"><?php echo (($persona['fotografia'] != '')?''.$persona['fotografia'].'':'No posee Fotografía');?></label>
                                  <input class="form-control" id="foto" name="foto" type="file" accept="image/jpeg,image/png"
                                  value="hola.php"
                                  ></input>

                                </div>

                              </div>
                          </div>
                        </div>







                      </div>

                      <!-- FIN DATOS PERSONALES -->




                      <div class="col-xs-6">
                        <span class="numberr">2</span><strong class=""> Datos Laborales</strong><br>
                        <br>
                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_acuerdo">Acuerdo No.*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-newspaper-o"></span></span>
                                    <input class="form-control"  type="text"  id="user_acuerdo" name="user_acuerdo"  value="<?php echo $persona['acuerdo_vice'] ?>" required>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_acuerdo">Fecha Acuerdo*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_acuerdo" name="fecha_acuerdo" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                                value = "<?php if(($persona['fecha_acuerdo'])=='0000-00-00'){ echo '';}
                                else

                                {echo fecha_dmy( $persona['fecha_acuerdo']); }?>" required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_partida">Partida*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                                    <input class="form-control"  type="text"  id="user_partida" name="user_partida"  value="<?php echo $persona['partida'] ?>" required>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="nacionalidad">Nacionalidad*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-flag-o"></span></span>
                                  <select name="nacionalidad"  id="nacionalidad" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar --" >
                                    <option value="" disabled selected hidden>Seleccionar Nacionalidad</option>
                                    <?php
                                        foreach ($nacionalidades as $n):
                                          ?>
                                          <option value="<?=$n['nac_id']?>" <?php echo (($n['nac_id'] == $persona['user_nacionalidad'])?'selected':""); ?>><?=$n['gentilicio'];?></option>
                                          <?php

                                        endforeach
                                    ?>
                                    </select>

                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">


                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_nit">Nit*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                                  <input class="form-control"  type="text"  id="user_nit" name="user_nit"  value="<?php echo $persona['user_nit'] ?>" required>
                                </div>
                              </div>
                          </div>



                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_igss">IGSS*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                                  <input class="form-control"  type="text"  id="user_igss" name="user_igss"  value="<?php echo $persona['user_igss'] ?>" >
                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="dep_id">Dependencia* (Departamento)</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="si si-home"></span></span>
                                  <select name="dep_id"  id="dep_id" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar --"required>
                                    <option value="" disabled selected hidden>Seleccionar Dependencia</option>
                                    <?php
                                        foreach ($departamentos as $n):
                                          ?>
                                          <option value="<?=$n['dep_id']?>" <?php echo (($n['dep_id'] == $persona['dep_id'])?'selected':""); ?>><?=$n['dep_nm'];?></option>
                                          <?php

                                        endforeach
                                    ?>
                                    </select>

                                </div>
                              </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_puesto">Puesto Funcional</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                                    <input class="form-control"  type="text"  id="user_puesto" name="user_puesto"  <input class="form-control"  type="text"  id="user_partida" name="user_partida"  value="<?php echo $persona['user_puesto'] ?>"required>
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_cargo">Cargo* (Puesto Nominal)</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                                    <input class="form-control"  type="text"  id="user_cargo" name="user_cargo"   value="<?php echo $persona['user_nom'] ?>" required>
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_posesion">Fecha Toma Posesión*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_posesion" name="fecha_posesion" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                                value = "<?php if(($persona['fecha_posesion'])=='0000-00-00'){ echo '';}
                                else

                                {echo fecha_dmy( $persona['fecha_posesion']); }?>"required>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_inicio">Fecha Inicio Laboral*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_inicio" name="fecha_inicio" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                                value = "<?php if(($persona['inicio_laboral'])=='0000-00-00'){ echo '';}
                                else

                                {echo fecha_dmy( $persona['inicio_laboral']); }?>"
                                required>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_fin">Fecha Destitución</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_fin" name="fecha_fin" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"
                                value = "<?php if(($persona['fecha_destitucion'])=='0000-00-00'){ echo '';}
                                else

                                {echo fecha_dmy( $persona['fecha_destitucion']); }?>" >
                              </div>
                            </div>
                          </div>

                      </div>
                      <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                              <label for="renglon">Renglón*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-list"></span></span>
                                <select name="renglon"  id="renglon" class="chosen-select-width"  data-placeholder="-- Seleccionar renglón --">
                                  <option value="" disabled selected hidden>Seleccionar Renglón</option>
                                  <?php
                                      foreach ($renglones as $renglon):
                                        ?>
                                        <option value="<?=$renglon["renglon"]?>" <?php echo (($renglon['renglon'] == $persona['renglon'])?'selected':""); ?>><?=$renglon['renglon'].' - '.$renglon['renglon_nm'];?></option>
                                        <?php

                                      endforeach
                                  ?>
                                </select>
                              </div>
                            </div>
                        </div>

                      </div>
                    </div>
                  </div>




                        <div class="form-group">
                                <div class="col-xs-3">
                                  <!--<label class="css-input switch <?php if($persona['user_status']==0) { echo 'switch-danger';} else if($persona['user_status']==1) { echo 'switch-success';} else if($persona['user_status']==2) { echo 'switch-warning';} ?>">
                                    <input id="user_status" name="user_status" type="checkbox"  checked value="<?php echo $persona['user_status']?>"><span></span>
                                    <!--<button title="Guardar Cambios" class="btn btn-primary outline "><i class="fa fa-save"></i>  </button>
                                    <button title="Generar Kardex" onclick="HTMLtoPDF()" class="btn  btn-success outline " ><i class="fa fa-download"></i>  </button>-->

                                  <!--</label>-->

                                </div>

                                <div class="col-xs-3">

                                </div>
                          <div class="col-xs-3 text-center">
                              <!--<button class="btn btn-sm btn-success btn-block" id="boton_a_u" type="submit"><i class="fa fa-check"></i> Guardar Cambios</button>-->
                              <input type="text" id="empleado" name="empleado" value="<?php echo $persona['user_id'] ?>" style="display:none">
                          </div>
                          <div class="col-xs-3 text-right">
                              <!--<a class="btn btn-sm btn-primary btn-block " onclick="HTMLtoPDF()"  id="boton_kardex"><i class="fa fa-file-o"></i> Generar Kardex</a>-->
                              <div class="btn-group btn-group-sm" role="group">
                                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                  <?php if(permiso_dep(3) || usuarioPrivilegiado()->hasPrivilege('Configuracion')){ ?><button type="button" class="btn btn-secondary  btn-sm" onclick="HTMLtoPDF()">Kardex</button><?php }?>
                                  <button class="btn btn-secondary btn-sm "  onclick="modificar_empleado(<?php echo $_SESSION['user_id']?>, <?php echo $persona['user_id'] ?>)"><i style="display:none;" id="loading_me" class="fa fa-refresh fa-spin"></i> Guardar</button>
                                  <?php if(verificar_director($_SESSION['user_id'])==1){ ?>
                                  <?php if($persona['user_status']==1){ ?><button type="button" class="btn btn-secondary  btn-sm" onclick="desactivar_user(<?php echo $_SESSION['user_id']?>, <?php echo $persona['user_id'] ?>)"><i style="display:none;" id="loading_de" class="fa fa-refresh fa-spin"></i> Desactivar</button><?php }?>
                                  <?php if($persona['user_status']==0){ ?><button type="button" class="btn btn-secondary  btn-sm" onclick="reactivar_user(<?php echo $_SESSION['user_id']?>, <?php echo $persona['user_id'] ?>)"><i style="display:none;" id="loading_re_e" class="fa fa-refresh fa-spin"></i> Reactivar</button><?php }?>
                                  <?php }?>
                                </div>
                              </div>

                              </div>
                          </div>
                        </div>

                    </form>
                    <div id="respuesta"></div>

                </div>
                </div>
                <!-- Page JS Code -->

                <script src="usuarios/js/empleado_modificar_form_validate.js"></script>
                <script>

    </script>
            </body>
        </html>
        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
        echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>

<script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
<script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
<link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">

<div style="display:none">
  <input type="text" id="sb" value="<?php echo $sueldo['salario_base'] ?>">
  <input type="text" id="cp" value="<?php echo $sueldo['complemento_personal'] ?>">
  <input type="text" id="ba" value="<?php echo $sueldo['bono_antiguedad'] ?>">
  <input type="text" id="bp" value="<?php echo $sueldo['bono_profesional'] ?>">
  <input type="text" id="bv" value="<?php echo $sueldo['bono_vicepresidencial'] ?>">
  <input type="text" id="b66" value="<?php echo $sueldo['bono_66_2000'] ?>">
  <input type="text" id="gr" value="<?php echo $sueldo['gastos_de_representacion'] ?>">
  <input type="text" id="vi" value="<?php echo $sueldo['viaticos'] ?>">
  <input type="text" id="to" value="<?php echo $sueldo['sueldo'] ?>">
  <input type="text" id="ig" value="<?php echo $sueldo['igss'] ?>">
  <input type="text" id="mo" value="<?php echo $sueldo['montepio'] ?>">
  <input type="text" id="d81" value="<?php echo $sueldo['decreto_81_70'] ?>">
  <input type="text" id="li" value="<?php echo $sueldo['liquido'] ?>">
  <input type="text" id="sg" value="<?php echo $sueldo['gastos'] ?>">

</div>
