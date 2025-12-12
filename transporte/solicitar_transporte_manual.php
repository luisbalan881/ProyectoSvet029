<?php
    include_once '../inc/functions.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('crearSolicitudTransporte') ) :
            $id = $_SESSION['user_id'];
            //$fee = $_POST['fee'];

            $departamentos = departamentos();
            $persona = User::getByUserId($id);
            $personas = personas();


                //$dias = tipos_dias_laborales();



        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Transporte</title>

            <script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">





            <script src="../herramientas/assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="../herramientas/assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">

            <script src="../herramientas/assets/js/pages/solicitud_form_validate.js"></script>
            <script src="transporte/js/funciones.js"></script>

        </head>
        <body>
          <div class="">
            <div class="block-header">

              <div class="tag-green">Solicitar Transporte</div>
              <div class="">
                  <ul class="block-options2" style="margin-top:-40px;">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>


            </div>
            <div class="block-content ">
              <form id="SolicitudForm" class="js-validation-solicitud1 form-horizontal " method="POST" enctype="multipart/form-data">
                  <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <!--<input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="" required>-->

                              <label for="destinatarios">Departamento(s)*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-bank"></span></span>
                                <select name="d_solicitantes" id="d_solicitantes"  multiple="multiple" data-placeholder="Seleccione uno o mas Departamentos" class="chosen-select-width col-xs-12" multiple tabindex="6" required>
                                  <?php
                                  foreach ($departamentos as $dept):
                                      if ($dept['dep_status'] == 1){
                                          echo '<option value="'.$dept["dep_id"].'">'.$dept["dep_nm"].'</option>';
                                      }
                                  endforeach
                                  ?>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <!--<input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="" required>-->

                              <label for="d_responsable">Empleado(s)*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="si si-user"></span></span>
                                <select name="responsable" id="responsable" class="chosen-select-width"  data-placeholder="-- Seleccionar empleado --" required>
                                  <option></option>
                                  <?php
                                  foreach ($personas as $persona):
                                      if ($persona['user_status'] == 1){
                                          echo '<option value="'.$persona["user_id"].'">'.$persona["user_nm1"].' '.$persona["user_nm2"].' '.$persona["user_ap1"].' '.$persona["user_ap2"].'</option>';
                                      }
                                  endforeach
                                  ?>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="form-group">
                      <div class="col-xs-2 col-sm-25">
                          <div class="form-material">
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                              <input class="js-datepicker form-control" type="text" id="soli_fecha" name="soli_fecha" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  required>
                            </div>

                              <label for="soli_fecha">Fecha*</label>
                          </div>
                      </div>
                      <div class="col-xs-2 col-sm-25">
                          <div class="form-material">
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-clock-o"></span></span>
                              <input class="form-control"    id="soli_salida1" name="soli_salida1" required>
                            </div>
                              <label for="soli_horas">Salida*</label>
                          </div>
                      </div>

                      <div class="col-xs-2 col-sm-25">
                          <div class="form-material ">
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-clock-o"></span></span>
                              <input class="form-control"  type="number"  id="soli_tiempo" name="soli_tiempo" min="1" required>
                            </div>
                            <label for="soli_tiempo">Duración*</label>
                          </div>
                      </div>
                      <div class="col-xs-2 col-sm-25">
                          <div class="form-material">
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                              <select class="form-control" name="horas_dias" id="horas_dias"data-placeholder="Seleccione uno o mas Departamentos" required>
                                <option value="" disabled selected hidden>Seleccionar</option>
                                <option value="3"> Minuto(s)</option>
                                <option value="1"> Hora(s)</option>
                                <option value="2"> Dia(s)</option>
                              </select>
                            </div>
                            <label for="destinatarios">Tiempo en*</label>
                          </div>
                      </div>
                      <div class="col-xs-2 col-sm-25">
                          <div class="form-material ">
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="fa fa-users"></span></span>
                              <input class="form-control"  type="number"  id="soli_cantidad" name="soli_cantidad" min="1" required>
                            </div>
                              <label for="soli_cantidad">No. de Personas*</label>
                          </div>
                      </div>
                  </div>


                  <div class="form-group">
                    <div class="">

                      <div class="table-responsive">

                        <table class="table" width="100%" id="crud_table">
                         <thead>
                          <th width="40%" style="border:1px solid transparent" ><strong class="ticket-title">Motivo (s)</strong></th>
                          <th width="60%" style="border:1px solid transparent" ></th>
                          <th width="" style="border:1px solid transparent" class="text-center"></th>

                         </thead>
                         <tbody>
                           <tr>
                            <td class="" style="border:1px solid transparent">


                                          <div class='input-group has-personalizado'>
                                            <span class='input-group-addon' ><span class='fa fa-map-marker'></span></span>
                                            <input  type='text' class='form-control item_destino' id='txtd1' required></input>
                                          </div>



                            </td>
                            <td  class="" style="border:1px solid transparent">


                                          <div class='input-group has-personalizado'>
                                            <span class='input-group-addon' ><span class='fa fa-edit'></span></span>
                                            <input  type='text' class='form-control item_motivo' id='txtm1' required></input>
                                          </div>



                            </td>

                            <td><span style="margin-top:5px;" name="add" id="add" class="btn-add"></span></td>
                           </tr>
                         </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-xs-12">

                          <div class="has-personalizado">
                            <label for="soli_desc">Anotaciones*</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="soli_desc" name="soli_desc" rows="3" ></textarea>
                            </div>


                          </div>

                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-sm-12 text-center">
                        <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="add_solicitud_manual()" ><i id="loading1" class="fa fa-refresh fa-spin" style="display:none;"></i> Crear Solicitud</button>
                    </div>
                  </div>
                </form>

            </div>
          </div>
          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (BS  Select2 Inputs plugins)
                  App.initHelpers(['datepicker','select2']);
              });

              $('#soli_salida1').timepicki();
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
