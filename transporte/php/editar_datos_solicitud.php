<?php
    include_once '../../inc/functions.php';
    include_once 'get_solicitud.php';

    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('autorizarSolicitudTransporte') ) :
            $id = null;
            $user = $_SESSION['user_id'];
            //$solicitud = $_POST['id'];
            //$fee = $_POST['fee'];

              $id = $_POST['id'];
              $conteo = verificar_vehiculo($id);
              $conteo2 = verificar_vehiculo_asignado($id);
              $veri_devueltos = verificar_vehiculo_devueltos($id);


           include_once 'funciones.php';
            $solicitud = get_solicitud_by_id($id);

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
            <script src="../herramientas/assets/js/plugins/push/push.min.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">
            <script src="../herramientas/assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="../herramientas/assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">
            <script src="../herramientas/transporte/js/funciones.js"></script>
            <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="../herramientas/assets/js/plugins/jspdf/pdfFromHTML.js"></script>



        </head>

        <body>

          <div class="">
              <ul class="block-options2" style="margin-top:-64px;margin-right:-2px">
                  <li>
                      <button onclick="load_solicitud_id(<?php echo $id?>)" type="button" ><i class="btn-regresar"></i></button>
                  </li>
              </ul>


          </div>



              <div  class=" form-horizontal " >


                <div class="form-group">
                    <div class="col-xs-2 col-sm-25">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                            <input class="js-datepicker form-control" value="<?php echo fecha_dmy($solicitud['FECHA']) ?>" type="text" id="soli_fecha" name="soli_fecha" data-date-language="es-ES" data-date-days-of-week-disabled="0,6" data-provide="datepicker" data-date-format="dd-mm-yyyy" placeholder="dd-mm-yyyy"  >
                          </div>

                            <label for="soli_fecha">Fecha</label>
                        </div>
                    </div>
                    <div class="col-xs-2 col-sm-25">
                        <div class="form-material">
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                            <input class="form-control" value="<?php echo $solicitud['SALIDA'] ?>"   id="soli_salida" name="soli_salida" >
                          </div>

                            <label for="soli_horas">Salida</label>
                        </div>
                    </div>


                  <div class="col-xs-2 col-sm-25">
                      <div class="form-material ">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                          <input class="form-control"  type="number" value="<?php echo $solicitud['DURACION'] ?>"  id="soli_tiempo" name="soli_tiempo" min="1" >
                        </div>


                          <label for="soli_tiempo">Duración</label>
                      </div>
                  </div>
                  <div class="col-xs-2 col-sm-25">
                      <div class="form-material">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                          <select class="form-control" name="horas_dias" id="horas_dias"data-placeholder="Seleccione uno o mas Departamentos" >
                            <option value="3"> Minuto(s)</option>
                            <option value="1"> Hora(s)</option>
                            <option value="2"> Dia(s)</option>
                            <?php
                            if($solicitud['TIPO_D']==3)
                            {
                              echo '<option value="3" disabled selected hidden >Minuto(s)</option>';
                            }
                            else if($solicitud['TIPO_D']==1)
                            {
                              echo '<option value="1" disabled selected hidden>Hora(s)</option>';
                            }
                            else if($solicitud['TIPO_D']==2)
                            {
                              echo '<option value="1" disabled selected hidden >Dia(s)</option>';
                            }
                            ?>
                          </select>
                        </div>
                      </div>
                    </div>





                  <div class="col-xs-2 col-sm-25">
                      <div class="form-material ">
                        <div class="input-group has-personalizado">
                          <span class="input-group-addon" ><span class="fa fa-calendar-check-o"></span></span>
                          <input class="form-control"  type="number"  id="soli_cantidad" value="<?php echo $solicitud['CANT'] ?>" name="soli_cantidad" min="1" >
                        </div>
                          <label for="soli_cantidad">No. de Personas</label>
                      </div>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-xs-12">

                        <div class="has-personalizado">
                          <label for="soli_desc">Personas que asisten a Comisión</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                            <textarea class="form-control" id="soli_desc" name="soli_desc" rows="3" ></textarea>
                          </div>


                        </div>

                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-12 text-center">
                    <?php if($solicitud['FINALIZADO']==0 || $solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3 || ($conteo2-$veri_devueltos)>0 || $conteo==0){?>
                      <button class="btn btn-sm btn-success btn-block" onclick="update_solicitud(<?php echo $solicitud['ID'] ?>, <?php echo $user ?>)" ><i id="loading_ed_so" class="fa fa-refresh fa-spin" style="display:none;"></i> Guardar Cambios</button>
                    <?php } else {
                      echo 'No puede cambiar los datos de esta solicitud, ya se llevó a cabo.';
                    }
                    ?>
                  </div>
                </div>


            </div>

            <div  class="notificacion_alerta">
              <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
              <i id="icono_n"></i><h1 id="message_notificacion"></h1>
            </div>

          <!-- Page JS Code -->
          <script>
              jQuery(function(){
                  // Init page helpers (BS  Select2 Inputs plugins)
                  App.initHelpers(['datepicker','select2','tags-inputs']);
              });

              $('#soli_salida').timepicki();
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
