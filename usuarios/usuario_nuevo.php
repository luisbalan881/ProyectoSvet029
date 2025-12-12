<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true):
        if (usuarioPrivilegiado()->hasPrivilege('crearUsuario')):
            $error_msg = '';
            $departamentos = array();
            $roles = array();
            $horas = array();
            $renglones = array();
            $nacionalidades = array();
            $genero = array();
            $estado_civil = array();
            if ( !empty($_POST)){
                //User::usuarioNuevo();
                User::empleado_nuevo();
                header("Location: index.php?ref=_35");
            }else{
                $departamentos = departamentos();
                $roles = roles();
                $horas = tipo_de_horarios();

                $nacionalidades = get_nacionalidades();
                $estado_civil = get_estado_civil();
                $genero = get_genero();

                if(verificar_director($_SESSION['user_id'])==1 || usuarioPrivilegiado()->hasPrivilege('Configuracion')  || (permiso_dep(8)&&permiso_dep(9)))
                {
                  $renglones = get_renglones(0);
                }
                else if(permiso_dep(8)){
                  $renglones = get_renglones_011_022(0);
                }
                else if(permiso_dep(9)){
                  $renglones = get_renglones_029(0);
                }

            }
        ?>
        <!DOCTYPE html>
        <html>
            <head>
                <meta http-equiv="content-type" content="text/html; charset=UTF-8">
                <title>Usuario Nueva</title>
                <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

            </head>
            <body>
                <div class="block block-themed card remove-margin-b">

                <div class="block-content">
                  <div class="tag-green" style="z-index:66;">Empleado Nuevo</div>
                <div class="">
                    <ul class="block-options2" style="margin-top:-40px;">
                        <li>
                            <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                        </li>
                    </ul>


                </div>
                    <form class="js-validation-empleado form-horizontal push-10-t push-10" action="" method="" id="en_form">
                      <!-- DATOS PERSONALES -->
                      <br>
                      <div class="row" >
                        <div class="col-xs-6" >
                        <span class="numberr">1</span><strong class=""> Datos Personales</strong><br>
                        <br>
                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_nm1">Primer Nombre*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="si si-user"></span></span>
                                  <input class="form-control"  type="text"  id="user_nm1" name="user_nm1" required >
                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_nm2">Segundo Nombre</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="si si-user"></span></span>
                                    <input class="form-control"  type="text"  id="user_nm2" name="user_nm2" >
                                  </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_ap1">Primer Apellido*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="si si-user"></span></span>
                                    <input class="form-control"  type="text"  id="user_ap1" name="user_ap1"  required>
                                  </div>
                              </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_ap2">Segundo Apellido</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="si si-user"></span></span>
                                    <input class="form-control"  type="text"  id="user_ap2" name="user_ap2" >
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
                                <input class="js-datepicker form-control" type="text" id="fecha_nac" name="fecha_nac" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_lugar_nac">Lugar Nacimiento*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                    <input class="form-control"  type="text"  id="user_lugar_nac" name="user_lugar_nac" required >
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
                                  <select class ="form-control" name="user_genre"  id="user_genre" style="width: 100%;" data-placeholder="-- Seleccionar género" >
                                    <option value="" disabled selected hidden>Seleccionar Género</option>
                                    <?php
                                        foreach ($genero as $n):
                                            echo '<option value="'.$n['genero_id'].'">'.$n['genero_nm'].'</option>';
                                        endforeach
                                    ?>
                                    </select>

                                  </select>
                                </div>
                              </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_civil">Estado Civil*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                  <select class ="form-control" name="user_civil"  id="user_civil" style="width: 100%;" data-placeholder="-- Seleccionar estado civil"  required>
                                    <option value="" disabled selected hidden>Estado Civil</option>
                                    <?php
                                        foreach ($estado_civil as $n):
                                            echo '<option value="'.$n['estado_civil_id'].'">'.$n['estado_civil_nm'].'</option>';
                                        endforeach
                                    ?>
                                    </select>
                                  </select>
                                </div>
                              </div>
                          </div>
                        </div>

                        <div class="form-group">

                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_cui">CUI*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-user"></span></span>
                                  <input class="form-control"  type="text"  id="user_cui" name="user_cui" required type="number">
                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_movil">Móvil*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-phone"></span></span>
                                  <input class="form-control"  type="text"  id="user_movil" name="user_movil" required  type="number" >
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
                                  <input <select class ="form-control" name="user_prof"  id="user_prof" style="width: 100%;" data-placeholder="-- Seleccionar Horario E / S --" >
                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_direccion">Dirección de residencia*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-map-marker"></span></span>
                                  <input class="form-control"  type="text"  id="user_direccion" name="user_direccion" required >
                                </div>
                              </div>
                          </div>



                        </div>

                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="nacionalidad">Nacionalidad*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-flag-o"></span></span>
                                  <select name="nacionalidad"  id="nacionalidad" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar --">
                                    <option value="" disabled selected hidden>Seleccionar Nacionalidad</option>
                                    <?php
                                        foreach ($nacionalidades as $n):
                                            echo '<option value="'.$n['nac_id'].'">'.$n['gentilicio'].'</option>';
                                        endforeach
                                    ?>
                                    </select>

                                </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="dep_id">Dependencia* (Departamento)</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="si si-home"></span></span>
                                  <select name="dep_id"  id="dep_id" style="width: 100%;" class="chosen-select-width" data-placeholder="-- Seleccionar --" required>
                                    <option value="" disabled selected hidden>Seleccionar Dependencia</option>
                                    <?php
                                        foreach ($departamentos as $n):
                                            echo '<option value="'.$n['dep_id'].'">'.$n['dep_nm'].'</option>';
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
                                  <input class="form-control"  type="text"  id="user_nit" name="user_nit" required >
                                </div>
                              </div>
                          </div>



                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="user_igss">IGSS*</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                                  <input class="form-control"  type="text"  id="user_igss" name="user_igss"  >
                                </div>
                              </div>
                          </div>
                        </div>

                      </div>


                      <!-- FIN DATOS PERSONALES -->



                      <div class="col-xs-6" >
                        <span class="numberr">2</span><strong class=""> Datos Laborales</strong><br>
                        <br>
                        <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_acuerdo">Acuerdo No.*</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-newspaper-o"></span></span>
                                    <input class="form-control"  type="text"  id="user_acuerdo" name="user_acuerdo" required >
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_acuerdo">Fecha Acuerdo*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_acuerdo" name="fecha_acuerdo" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" required>
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
                                    <input class="form-control"  type="text"  id="user_partida" name="user_partida" required >
                                  </div>
                              </div>
                          </div>
                          <div class="col-xs-6">
                            <div class="form-material">
                              <label for="fecha_inicio">Fecha Inicio Laboral*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-calendar-o"></span></span>
                                <input class="js-datepicker form-control" type="text" id="fecha_inicio" name="fecha_inicio" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
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
                                    <input class="form-control"  type="text"  id="user_cargo" name="user_cargo">
                                  </div>
                              </div>
                          </div>

                          <div class="col-xs-6">
                              <div class="form-material">
                                  <label for="user_puesto">Puesto Funcional</label>
                                  <div class="input-group has-personalizado">
                                    <span class="input-group-addon" ><span class="fa fa-check"></span></span>
                                    <input class="form-control"  type="text"  id="user_puesto" name="user_puesto"  >
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

                                      echo '<option value="'.$renglon['renglon'].'">'.$renglon['renglon'].' - '.$renglon['renglon_nm'].'</option>';

                                  endforeach


                                  ?>
                                </select>
                              </div>
                            </div>
                        </div>

                      </div>

                      <?php if(permiso_dep(9)){?>
                      <div class="form-group">
                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="salario_base ">Contrato No.</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                                  <input class="form-control "  type="text"  id="contrato_num" name="contrato_num"  >                                </div>
                              </div>
                          </div>


                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="complemento_personal">Fecha del Contrato</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                                  <input class="form-control js-datepicker"  type="text"  id="contrato_fecha" name="contrato_fecha"  data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy" >
                                </div>
                              </div>
                          </div>

                        </div>
                        <div class="form-group">


                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="bono_antiguedad">Fianza</label>
                                <div class="input-group has-personalizado">
                                  <span class="input-group-addon" ><span class="fa fa-edit"></span></span>
                                  <input class="form-control  "  type="text"  id="fianza" name="fianza" >
                                </div>
                              </div>
                          </div>


                          <div class="col-xs-6">
                              <div class="form-material">
                                <label for="bono_profesional">Inicio y Final del Contrato</label>
                                <div class="input-group has-personalizado">
                                  <input class="form-control  js-datepicker"  type="text"  id="contrato_ini" name="contrato_ini" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                                  <span class="input-group-addon" ><span class="">a</span></span>
                                  <input class="form-control js-datepicker"  type="text"  id="contrato_fin" name="contrato_fin" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy">
                                </div>
                              </div>
                          </div>

                      </div>
                    <?php }?>





                      </div>
                    </div>








                        <div class="form-group">
                          <div class="col-xs-12 text-center">
                              <button class="btn btn-sm btn-success btn-block" id="boton_a_u" onclick="crear_empleado(<?php echo $_SESSION['user_id']?>)"><i style="display:none;" id="loading_ne" class="fa fa-refresh fa-spin"></i> Crear Empleado</button>
                          </div>
                        </div>
                      </div>
                    </form>
                </div>
                </div>
                <!-- Page JS Code -->
                <script>

                </script>
                <script src="usuarios/js/empleado_nuevo_form_validate.js"></script>
            </body>
        </html>
        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
        echo "<script type='text/javascript'> window.location='index.php'; </script>";
endif;
?>

<script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
<script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
<script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
<link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">
