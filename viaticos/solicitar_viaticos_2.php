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
            $tipo = tipo_viaticos();
            $tipo2 = tipo_viaticos2();
			$tsolicitado=get_solicitud_by_id_t($id2);
            $persona = User::getByUserId($id);


               
             
                                //  foreach ($tipo as $dept):
                                     // if ($dept['dep_status'] == 1){
                                  //        echo '<option value="'.$dept["id_tipo"].'">'.$dept["descripcion"].'</option>';
                                     // }
                                  //endforeach
                                  



        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Transporte</title>

            <script src="assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="assets/js/plugins/chosen/chosen.css">
            <link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">





            <script src="assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">

            <script src="assets/js/pages/solicitud_form_validate3.js"></script>
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
			 
			 <script src="transporte/js/load_solicitud.js"></script>
            
            <link href="https://fonts.googleapis.com/css?family=Chau+Philomene+One|Fredoka+One" rel="stylesheet">
			<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
              
              
                      
<form  oninput="(dest.value=((parseFloat(des.value))+(parseFloat(des2.value))+(parseFloat(des3.value))+(parseFloat(des4.value))+(parseFloat(des5.value)))) (almt.value=((parseFloat(alm.value))+(parseFloat(alm2.value))+(parseFloat(alm3.value))+(parseFloat(alm4.value))+(parseFloat(alm5.value))))" onChange="validarTotales(this.value);"  value="0">

    <br>

 <br>    
 
  <div class="form-group">
                <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="des"  onChange="validarpordia1(this.value);"  value="0">  

                    </div>
                                            
                      <label for="user_mail">Desayuno1 </label>
                  </div>
                </div>
      
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="des2"  onChange="validarpordia2(this.value);"  value="0">  

                    </div>
                                            
                      <label for="user_mail">Desayuno2 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="des3"  onChange="validarpordia3(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Desayuno3 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="des4"   onChange="validarpordia4(this.value);"  value="0">
                    </div>
                                            
                      <label for="user_mail">Desayuno4 </label>
                  </div>
                </div>
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="des5"   onChange="validarpordia5(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Desayuno5 </label>
                  </div>
                </div>
       
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="number" id="dest" onChange="validarTotales(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="tota1">TOTAL 1 </label>
                  </div>
          
                </div>
      
      
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="alm"   onChange="validarpordia1(this.value);"  value="0">  

                    </div>
                                            
                      <label for="user_mail">Almuerzo1 </label>
                  </div>
                </div>
      
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="alm2"   onChange="validarpordia2(this.value);"  value="0">  

                    </div>
                                            
                      <label for="user_mail">Almuerzo2 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="alm3"  onChange="validarpordia3(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Almuerzo3 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="alm4"  onChange="validarpordia4(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Almuerzo4 </label>
                  </div>
                </div>
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="alm5"  onChange="validarpordia5(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Almuerzo5 </label>
                  </div>
                </div>
       
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="number" id="almt" onChange="validarTotales(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">TOTAL 2 </label>
                  </div>
          
                </div>
      
     

         </div>
      
    
      
      
        
</form>

<form method="POST" oninput="(cent.value=((parseFloat(cen.value))+(parseFloat(cen2.value))+(parseFloat(cen3.value))+(parseFloat(cen4.value))+(parseFloat(cen5.value)))) (host.value=((parseFloat(hos.value))+(parseFloat(hos2.value))+(parseFloat(hos3.value))+(parseFloat(hos4.value))+(parseFloat(hos5.value))))" onChange="validarTotales(this.value);"  value="0">
<br>
 <br>    
 
  <div class="form-group">
                <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="cen"  onChange="validarpordia1(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">Cena1 </label>
                      
                  </div>
                </div>
      
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="cen2"  onChange="validarpordia2(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Cena2 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="cen3"  onChange="validarpordia3(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Cena3 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="cen4"   onChange="validarpordia4(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Cena4 </label>
                  </div>
                </div>
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="cen5"  onChange="validarpordia5(this.value);"  value="0">

                    </div>
                                            
                      <label for="user_mail">Cena5 </label>
                  </div>
                </div>
       
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="number" id="cent" onChange="validarTotales(this.value);"  value="0"> 


                    </div>
                                            
                      <label for="user_mail">TOTAL 3 </label>
                  </div>
          
                </div>
      
      
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="hos"   onChange="validarHospedajes(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">Hospedaje1 </label>
                  </div>
                </div>
      
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="hos2" onChange="validarHospedajes(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">Hospedaje2 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="hos3"   onChange="validarHospedajes(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">Hospedaje3 </label>
                  </div>
                </div>
      
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="hos4" onChange="validarHospedajes(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">Hospedaje4 </label>
                  </div>
                </div>
       <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="text" SIZE=10 id="hos5"  onChange="validarHospedajes(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">Hospedaje5 </label>
                  </div>
                </div>
       
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="number" id="host" onChange="validarTotales(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="user_mail">TOTAL 4 </label>
                  </div>
          
                </div>
      
     

         </div>
    
    
      
       
      <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="number" id="total" value="<?php echo $tsolicitado['total']; ?>" disabled> 

                    </div>
                                            
                      <label for="user_mail">viaticos solicitados </label>
                  </div>
          
                </div>
				
				
				 <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
<input class="form-control input-sm" type="number" id="totalgt"  readonly> 

                    </div>
                                            
                      <label for="user_mail">Total</label>
                  </div>
          
                </div>
				
				
				
     

         </div>
      
              
      
      
      
      
        
</form>


<div id="contenido"> </div>

              
            <div class="block-content ">
              <form id="SolicitudForm" class="js-validation-solicitud form-horizontal form-style-10" method="POST" enctype="multipart/form-data">
               
                              
                    <div class="form-group">
                    <div class="col-xs-12">

                          <div class="has-personalizado">
                            <label for="objetivo">Objetivo (Campo obligatorio)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="objetivo" name="objetivo" maxlength="380" rows="2" required ></textarea>
							    <span class="error" id="nameError"></span>
                            </div>


                          </div>

                    </div>
                  </div>
                  
                      <div class="form-group">
                    <div class="col-xs-12">

                          <div class="has-personalizado">
                            <label for="actividades">Actividades realizadas (Campo obligatorio)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="actividades" name="actividades" maxlength="2000" rows="2" required ></textarea>
                            </div>


                          </div>

                    </div>
                  </div>
                                
                
                <div class="form-group">
                    <div class="col-xs-12">

                          <div class="has-personalizado">
                            <label for="logros">Logros (Campo obligatorio)</label>
                            <div class="input-group has-personalizado">
                              <span class="input-group-addon" ><span class="si si-pencil"></span></span>
                              <textarea class="form-control" id="logros" name="logros" maxlength="1000" rows="2" required></textarea>
                            </div>


                          </div>

                    </div>
                  </div>
                  
                

                  
                

                  <div class="form-group">
                    <div class="col-sm-12 text-center">  
                        <button id="boton_s_t" class="btn btn-sm btn-primary btn-block" onclick="add_formulario2(<?php echo $id ?>,<?php echo $persona->persona['dep_id']?>, <?php   echo $id2 ?>)" ><i id="loading1" class="fa fa-refresh fa-spin" style="display:none;"></i> Liquidar  </button>
                    </div>
                  </div>
				  
				
                
                
               
                
                
                </form>

            </div>
                      
              
          </div>
          <!-- Page JS Code -->
          <script>
             /* jQuery(function(){
                  // Init page helpers (BS  Select2 Inputs plugins)
                  App.initHelpers(['datepicker','select2']);
              });

              $('#soli_salida1').timepicki();
              
               const btnDelete = document.getElementById("btn-Delete");
        const inputId = document.getElementById("dest");
		
		 const inputId2 = document.getElementById("almt");
		  const inputId3 = document.getElementById("cent");
		   const inputI4 = document.getElementById("host");


        btnDelete.addEventListener("click", function () {
          
			 inputId.value = "0";
		  inputId2.value = "0";
		  inputId3.value = "0";
		  inputId4.value = "0";
		 // boton_s_t.disabled = false;
        });*/
		
		 document.getElementById('SolicitudForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evita que la página se recargue

            // Limpia los mensajes de error
            document.getElementById('nameError').textContent = '';
            document.getElementById('emailError').textContent = '';

            var isValid = true;

            // Validación del nombre
            var name = document.getElementById('name').value;
            if (name.trim() === '') {
                document.getElementById('nameError').textContent = 'El nombre es obligatorio.';
                isValid = false;
            }

            // Validación del correo electrónico
            var email = document.getElementById('email').value;
            if (email.trim() === '') {
                document.getElementById('emailError').textContent = 'El correo electrónico es obligatorio.';
                isValid = false;
            } else if (!validateEmail(email)) {
                document.getElementById('emailError').textContent = 'El correo electrónico no es válido.';
                isValid = false;
            }

            if (isValid) {
                alert('El formulario es válido y ha sido enviado correctamente.');
                // Aquí puedes enviar el formulario usando AJAX o realizar alguna acción adicional
            }
        });

        function validateEmail(email) {
            var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }
              
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
