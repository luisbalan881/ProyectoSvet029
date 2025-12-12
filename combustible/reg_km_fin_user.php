<?php
    include_once '../inc/functions.php';
     include_once 'funciones_cupones.php';


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
          //  echo  $id2;
        }

        if ( null==$id2 ) {
            header("Location: index.php?ref=_2");
        }

            
            
            //$departamentos = nom();
            $tipo = tipo_viaticos();
            $tipo2 = tipo_viaticos2();
            $persona = User::getByUserId($id);


               
             
                                //  foreach ($tipo as $dept):
                                     // if ($dept['dep_status'] == 1){
                                  //        echo '<option value="'.$dept["id_tipo"].'">'.$dept["descripcion"].'</option>';
                                     // }
                                  //endforeach
          //  
                     /*                
         $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "select max(t1.km_fin) from vp_solicitud_cupon_vehiculo as t1 join vp_vehiculo as t2 where t2.placa= '0214BBT' and t1.vehiculo_id=t2.vehiculo_id";
  
  $q = $pdo->prepare($sql);
  $q->execute(array());
  $kilo = $q->fetch(PDO::FETCH_NUM);
  
  
  
  Database::disconnect();
  
  echo '<b> Ultimo Kilometraje registrado: </b> ';
  echo $kilo['0']; */
         // echo '<b> Ultimo Kilometraje registrado: </b> ';
            //echo $dias['0']; 

                                  

 $bitacora = bitacora_info($id2);

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

<link rel="stylesheet" type="text/css" href="../alertify/css/alertify.css">
	<link rel="stylesheet" type="text/css" href="../alertify/css/themes/default.css">

	<script src="../alertify/jquery/jquery-3.2.1.min.js"></script>
	<script src="../alertify/js/alertify.js"></script>



            <script src="assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">

            <script src="assets/js/pages/solicitud_form_km_fin.js"></script>
            <script src="transporte/js/funciones.js"></script>

            
            <script src="assets/js/plugins/jspdf/hoja_cupones5.js"></script>
            <script src="assets/js/plugins/jspdf/solicitud_cupones.js"></script>
             <script src="combustible/js/validarentradas.js"></script>

            
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
                <h1>Formulario de registro de km final </h1>
                 
                                 
              
               


    <br>

 <br>    
 
 
 <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="text"  id="prov_nm" name="Destino"  value="<?php echo $bitacora['Destino']; ?>" disabled>
                                <label for="Destino">Destino*</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <textarea class="form-control" id="prov_desc" name="motivo" rows="3" disabled><?php echo $bitacora['motivo']; ?></textarea >
                                <label for="motivo">Motivo</label>
                            </div>
                        </div>
                    </div>
 <div class="form-group">
                        <div class="col-xs-12">
                            <div class="form-material">
                                <input class="form-control focus"  type="number"  id="km_inicial" name="km_inicial"  value="<?php echo $bitacora['km_inicial']; ?>" disabled>
                                <label for="km_inicial">Kilometraje inical*</label>
                            </div>
                        </div>
                    </div>
 
  <div class="form-group">
                <div class="col-xs-2">
                  <div class="form-material">
                    
                      
                      <div class="input-group has-personalizado">

    
                          <input class="form-control input-sm" type="text"  id="km_fin" onChange="validarKilometrosFinales(this.value);"  value="0"> 

                    </div>
                                            
                      <label for="km_fin">kilometraje final</label>
                  </div>
                </div>
      
    
   
      
      
      
       
     
     

         </div>
  
 
      
              
      
      
      
  

              
            
                 <?php $placa=$bitacora['vehiculo_id']; ?>
                  
        
                

                  <div class="form-group">
                    <div class="col-sm-12 text-center">  
                        <button id="boton_s_t" class="btn btn-sm btn-success btn-block" onclick="add_formulario_km_fin( <?php   echo $id2?> , <?php   echo $placa?> )" disabled><i id="loading1" class="fa fa-refresh fa-spin" style="display:none;"></i> Registrar kilometraje final</button>
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
