<?php
    include_once '../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
            $id = null;
            $vid = null;
            $persona = array();
            $sus = array();
            $user_id =$_SESSION['user_id'];
            include_once 'php/funciones.php';
            include_once 'inc/Driver.php';
            $persona = User::get_empleado_datos_id($user_id);

           
            
            $vehiculos = get_carros($persona['dep_id']);



             $drivers = User::getAllDrivers_s($persona['dep_id']);



            date_default_timezone_set('America/Guatemala');

        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Solicitar Cupones</title>
            <link rel="stylesheet" href="../herramientas/administrador/css/build.css">
            <script src="../herramientas/assets/js/plugins/chosen/chosen.jquery.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/prism.js"></script>
            <script src="../herramientas/assets/js/plugins/chosen/docsupport/init.js"></script>
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/chosen/chosen.css">
            <script src="combustible/js/operacion.js"></script>

            <script src="combustible/js/crear_solicitud_cupones.js"></script>
           
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">



            <style>

            @media print {
              .panel-heading {display:none}
              .tag-green { display:none }
              .block-options2 { display:none }
              .page-heading{display: none;}
              #tabla{ display: none;}
              #tabla1{ display: none; }
              #d{ display: none; }
              #de{display: none; }
              button{ display: none }
              #suspenciones {transform: scale(0.9);padding-top: 0.5cm;}
              #datos_emp{transform: scale(0.9);padding-top: 1cm; padding-left: -10cm}
              #page-footer{display: none}
              #datos_emp{font-size: 16px;}
              #printe{display: none;}

            }
            </style>

        </head>

        <body>
   
         
                   
       

   
               
            
          <div class="block block-themed block-transparent remove-margin-b">


            <div class="block-content">
              <div class="tag-green">Solicitar Cupones</div>
              <div class="">
                  <ul class="block-options2" style="margin-top:-40px;">
                      <li>
                          <button data-dismiss="modal" type="button" ><i class="btn-circle"></i></button>
                      </li>
                  </ul>


              </div>

              <div class="">
                <br>
                <table id="tb_solicitar_cupones" class="table  display nowrap" cellspacing="0" width="100%" >
                  <thead >
                          <tr>
                              <th class="text-center">PLACA</th>
                              <th class="text-center" >MARCA</th>
                              <th class="text-center" >LINEA</th>

                              <th class="text-center">TIPO</th>
                              <th class="text-center">CILINDROS</th>
                              <th class="text-center">COMBUSTIBLE</th>
                               <th class="text-center">RENDIMIENTO</th>
                             

                              <th class="text-center">ENCARGADO</th>
                               <th class="text-center">MONTO</th> 
                              <th class="text-center"><!--<div style="margin-top:-20px;margin-left:20px" class='checkbox checkbox-circle checkbox-success'>    <input name='showhide' onchange="checkAll(this)" type='checkbox'/>    <label></label>    </div>--></th>

                          </tr>
                      </thead>
                      <tbody>
                        <?php
                        
                                       
                                                                    
                        
                     //   echo '<p><label>Distancia:<input type="number" name="n1"> </label></p>';
                        // echo '<p><label>retorno:<input type="number" name="n2"> </label></p>';
                                                                   
                       // <p><label>Contraseña: <input type="password" name="pass"></label></p>
                        
                              foreach ($vehiculos as $vehiculo){

                                  echo '<tr id="tr'.$vehiculo['vehiculo_id'].'">';
                                  //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                  echo '<td class="text-center tabla-personalizada-text" style="white-space: nowrap;"><strong>'.$vehiculo['placa'].'</strong></td>';
                                  echo '<td class="text-center tabla-personalizada-text" style="white-space: nowrap;">'.$vehiculo['nombre'].'</td>';
                                  echo '<td class="text-center tabla-personalizada-text" style="white-space: nowrap;">'.$vehiculo['linea'].'</td>';

                                  echo '<td class="text-center tabla-personalizada-text">'.$tipo_vehiculo[$vehiculo['tipo']].'</td>';
                                  echo '<td class="text-center tabla-personalizada-text">'.$vehiculo['cilindraje'].'</td>';
                                  echo '<td class="text-center tabla-personalizada-text">'.$combustible[$vehiculo['combustible_id']].'</td>';
                                 echo '<td class="text-center tabla-personalizada-text">'.$vehiculo['rendimiento'].'</td>';


                                    echo '<td class="text-center">';

                                    echo '<select class ="chosen-select-width" id="conductor_id'.$vehiculo['vehiculo_id'].'"  style="width: 100%;" data-placeholder="-- Seleccionar Conductor --" required>
                                      <option></option>';

                                      foreach ($drivers as $driver){
                                          echo '<option value="'.$driver["user_id"].'" '.(($driver["user_id"] == $vehiculo['user_id'])? 'selected':'').' '.(($driver['status'] == 0)?'disabled': '').'>'.$driver["nombre"].'</option>';
                                      }

                                    echo '</select>';
                                    echo'</td>';
                                    echo '<td class="text-right">';
                                    echo '<span id="message'.$vehiculo['vehiculo_id'].'" class="bar"></span>';
                                    echo '<input name="texto" id="'.$vehiculo['vehiculo_id'].'" class="form-control input-sm price" style="width:60px;" required disabled onkeypress="return justNumbers(event);"></input>';
                                    echo '</td>';

                                    echo '<td class="text-center" valign="middle">';

                                    echo '<div style="margin-top:-10px;" class="checkbox checkbox-circle checkbox-success">
                                    <input name="check" data-id='. $vehiculo['vehiculo_id']. ' type="checkbox"/>
                                    <label></label>
                                    </div>';
                                    echo'</td>';





                                  echo '</tr>';
                              }

                    echo '  </tbody>';
                    ?>
                </table>

                <div>
                  <button class="btn btn-block btn-sm btn-success" id="save_solicitud_cupones"><i id="loading_soli_cu" style="display:none" class="fa fa-refresh fa-spin"  > ></i> Generar Solicitud   </button>
                  <p></p>
                </div>

              </div>


            </div>

          </div>
          <div  class="notificacion_alerta">
            <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
            <i id="icono_n"></i><h1 id="message_notificacion"></h1>
          </div>

          <!-- Page JS Code -->
          
          
          <script>
 
   </script>
  
   
  


        </body>
        </html>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
        
        // echo $gal=$_POST['galones'];
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
