<?php
    include_once '../inc/functions.php';
       include_once 'funciones_cupones.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('crearSolicitudTransporte') ) :
            $id = $_SESSION['user_id'];
            //$fee = $_POST['fee'];

            $vehiculo = vehiculos();
            $persona = User::getByUserId($id);
            $list_bitacora = list_bitacora_por_usuario($id);

 


        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Control de vehiculo</title>

            <script src="assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">





            <script src="assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">

            <script src="assets/js/pages/solicitud_form_bitacora.js"></script>
            <script src="transporte/js/funciones.js"></script>
            <script src="combustible/js/validarentradas2.js"></script>  
            <script src="combustible/js/validarkmregistrado.js"></script>
            <script src="assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML.js"></script>
            <link href="https://fonts.googleapis.com/css?family=Chau+Philomene+One|Fredoka+One" rel="stylesheet">

        </head>
        <body>
          <div class="">
            <div class="">

              <!--<div class="tag-green">Solicitar Transporte</div>-->
              <div class="">
                  <ul class="block-options2" style="margin-top:10px; margin-right:9px;">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>


            </div>
            <div class="block-content ">
              <form id="SolicitudForm" class="js-validation-solicitud form-horizontal form-style-10" method="POST" enctype="multipart/form-data">
                <h1>Control de Vehiculo <span>Formulario para control de retorno de vehículo para comisiones</span></h1>
                
                

                <div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <!--<input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="" required>-->

                              <label for="destinatarios">Vehiculo(s)*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-bank"></span></span>
                                
                                 <?php
                                  
                                  foreach ($list_bitacora as $list_bitacora1){
                //$dias = tipos_dias_laborales();
 if ($list_bitacora1['status'] == 1 )
                                {
    // echo "tiene una kilometraje aun no registrado ";
    // echo validarKilometrosFinales2();
     echo "<script> validarStatus1(); </script>";
                                // echo '<span data-toggle="tooltip" title="registra KM final"><a class="btn btn-default"  title="Registrar Km final"  data-toggle="modal" data-target="#modal-remoto" href="combustible/reg_km_fin_user.php?id='.$list_bitacora1['id_bitacora'].'"><i class="fa fa-pencil text-warning"></i></a></span>';
                                  }
 
                                   }
                                  
                                     ?>
                                <select name="d_solicitantes" id="d_solicitantes"  multiple="multiple" data-placeholder="Seleccione uno vehiculo" class="chosen-select-width col-xs-12 form-control" multiple tabindex="6" required>
                                 
                                  
                                   <?php
                                  foreach ($vehiculo as $vehicu):
                                     // if ($vehicu['status'] == 1){
                                          echo '<option value="'.$vehicu["vehiculo_id"].'">'.$vehicu["placa"].''." ".''.$vehicu["nombre"].''." ".''.$vehicu["linea"].''." ".''.$vehicu["color"].'</option>';
                                      //}
                                  
                                
                                  endforeach
                                  ?>
                                    
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>
                  
                       
                      
                      
                      <div class="form-group">
                    <div class="col-xs-5">

                          <div class="has-personalizado">
                            <label for="soli_lugar">lugares (Campo obligatorio)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="soli_lugar" name="soli_lugar" maxlength="40" rows="1"  required></textarea>
                            </div>


                          </div>

                    </div>
                  </div>
                
                <div class="form-group">
                    <div class="col-xs-5">

                          <div class="has-personalizado">
                            <label for="motivo">Motivo</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="motivo" name="motivo" maxlength="40" rows="1"  required></textarea>
                            </div>


                          </div>

                    </div>
                  </div>
                  


                 

                  <div class="form-group">
                    <div class="col-sm-12 text-center">
                        
                         <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="add_solicitud_bitacora(<?php echo $id ?>,<?php echo $persona->persona['dep_id']?>)"><i id="loading" class="fa fa-refresh fa-spin" style="display:none;"></i> Crear registro de KM inicial</button>
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
