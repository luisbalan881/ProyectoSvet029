<?php
    include_once '../inc/functions.php';


    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('crearSolicitudTransporte') ) :
            $id = $_SESSION['user_id'];
            //$fee = $_POST['fee'];
            $departamentos = departamentos();
            
            
             if ( !empty($_GET['id'])) {
            $id2 = $_REQUEST['id'];
            //$renglon = renglon_info($id);
        }

        if ( null==$id2 ) {
            header("Location: index.php?ref=_2");
        }

            
            
            //$departamentos = nom();
            $tipo = tipo_viaticos3();
            $tipo2 = tipo_viaticos();
            $persona = User::getByUserId($id);


               
             
                                //  foreach ($tipo as $dept):
                                     // if ($dept['dep_status'] == 1){
                                  //        echo '<option value="'.$dept["id_tipo"].'">'.$dept["descripcion"].'</option>';
                                     // }
                                  //endforeach
            
                                     
        
         // echo '<b> Ultimo Kilometraje registrado: </b> ';
            //echo $dias['0']; 

                                  



        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Ampliación</title>

            <script src="assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">





            <script src="assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">

            <script src="assets/js/pages/solicitud_form_validate_liquidacion_ampliacion1.js"></script>
            <script src="transporte/js/funciones.js"></script>

            <script src="assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML1.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML2.js"></script>
             <script src="assets/js/plugins/jspdf/pdfFromHTML3.js"></script>
              <script src="assets/js/plugins/jspdf/pdfFromHTML4.js"></script>
            
            <script src="assets/js/plugins/jspdf/hoja_cupones.js"></script>
            <script src="assets/js/plugins/jspdf/hoja_cupones5.js"></script>
            <script src="assets/js/plugins/jspdf/solicitud_cupones.js"></script>
             <script src="viaticos/js/validarentradas.js"></script>

            
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
              
              
 

<div class="form-group">
                      <div class="col-xs-12">
                          <div class="form-material">
                              <!--<input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="" required>-->

                              <label for="destinatarios">Ampliación de viáticos(s)*</label>
                              <div class="input-group has-personalizado">
                                <span class="input-group-addon" ><span class="fa fa-bank"></span></span>
                                <select name="d_solicitantes2" id="d_solicitantes2"  multiple="multiple" data-placeholder="Seleccione uno o más opciones" class="chosen-select-width col-xs-12 form-control" multiple tabindex="6" required>
                                  <?php
                                  foreach ($tipo as $dept):
                                     // if ($dept['dep_status'] == 1){
                                          echo '<option value="'.$dept["id_tipo"].'">'.$dept["descripcion"]."--dia-".$dept["dia"].'</option>';
                                     // }
                                  endforeach
                                  ?>
                                  </select>
                              </div>
                          </div>
                      </div>
                  </div>

              
            <div class="block-content ">
              <form id="SolicitudForm" class="js-validation-solicitud form-horizontal form-style-10" method="POST" enctype="multipart/form-data">
                <h1>Formulario de Liquidación <span> Instrucciones generales: 1) Seleccione las opciones a ampliar omitiendo los datos solicitados en la primera solicitud 2) realizar una pequeña justificación de la ampliación.  3)Enviar para su respectiva aprobación por la Dirección de finaciera 4)cuando ya sea aprobado la solicitud de ampliación le aparesera la opción liquidar con ampliación</span> </h1>
                 
                                     
                 
                    <h3> <center>Justificación de la ampliación </center></h3>
                              
                    <div class="form-group">
                    <div class="col-xs-12">

                          <div class="has-personalizado">
                            <label for="justificacion">justificación (Campo obligatorio)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="justificacion" name="justificacion" maxlength="380" rows="2" required ></textarea>
                            </div>


                          </div>

                    </div>
                  </div>
                  
                      

                  <div class="form-group">
                    <div class="col-sm-12 text-center">  
                        <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="add_formulario_ampliacion1(<?php echo $id ?>,<?php echo $persona->persona['dep_id']?>, <?php   echo $id2 ?>)" ><i id="loading1" class="fa fa-refresh fa-spin" style="display:none;"></i> Solicitar Ampliación</button>
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
