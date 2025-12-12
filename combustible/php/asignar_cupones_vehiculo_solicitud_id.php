<?php
    include_once '../../inc/functions.php';
    sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')) :
          include_once 'funciones.php';


          $year=$_POST['year'];
          $mes=$_POST['mes'];
          $m = "'".$mes."'";
          $solicitud=$_POST['solicitud_id'];
          $vehiculo=$_POST['vehiculo_id'];
          $dep_id=$_POST['dep_id'];
          $cupones_utilizados = array();

          $carro = get_carro_por_solicitud_by_id($year,$mes,$solicitud,$vehiculo,$dep_id);
          $fecha = get_fecha_autorizado_por_solicitud_by_id($year,$mes,$solicitud,$dep_id);

          $cupones_utilizados=get_cupones_utilizados_by_id($year,$mes,$solicitud,$vehiculo,$dep_id);


          $id=$_SESSION['user_id'];
          $cupones = cupones_disponibles();
                      
                    
          $fecha = date('d-m-Y',time());
          
          
          //echo $carro['placa'];
          $km=$carro['placa'];
        //  echo $km;
          
          //$km2 = "0207BBT";
          ///
          
         $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "select max(t1.km_fin) from vp_solicitud_cupon_vehiculo as t1 join vp_vehiculo as t2 where t2.placa= '$km' and t1.vehiculo_id=t2.vehiculo_id";
  
  $q = $pdo->prepare($sql);
  $q->execute(array());
  $kilo = $q->fetch(PDO::FETCH_NUM);
  
  
  
  Database::disconnect();
  
  echo '<b> Ultimo Kilometraje registrado: </b> ';
  echo $kilo['0']; 
  
  //echo $kilo [0]->km_fin; 
  
//print_r ($kilo);
  
 
            
           // echo 'xxxxxxxxxxxxxxxxx:';
             //  echo $kilo['km_fin'];
          //echo $kilo;
          ///
          
          //
          
          
          
          
          //
          
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
            <link rel="stylesheet" href="../herramientas/assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">

        </head>
        <body>
          <div class="">
              <ul class="block-options2" style="margin-top:-70px;">
                  <li>
                      <button id="return" onclick="load_solicitud_id(<?php echo $year ?>,<?php echo $m ?>,<?php echo $solicitud?>,<?php echo $dep_id ?>)" type="button" ><i class="btn-regresar"></i></button>
                  </li>
              </ul>


          </div>
          <div class="block block-themed block-transparent remove-margin-b">
            <form class="js-validation-asignar-cupones form-horizontal push-10-t push-10">
              <div class="form-group">
                <div class=" col-sm-8">
                  <div class="info "style=" margin-left:auto; margin-right:auto;" >
                    <article class="card1 fl-left">
                      <section class="date">
                        <time >
                          <span>Q. <?php echo $carro['monto']?></span><span>Monto</span>
                        </time>
                      </section>
                      <section class="card-cont">
                        <br>
                        <h3>Datos del Vehículo</h3>
                        <br>
                        <div class="even-info">
                          <table class="">
                            <thead>
                              <th style="width:150px"></th>
                              <th style="width:400px"></th>
                            </thead>
                            <tbody>
                              <tr><td>Placa:</td><td><?php echo $carro['placa'] ?></td></tr>
                              <tr><td>Marca:</td><td><?php echo $tipo_vehiculo[$carro['tipo']].' - '. $carro['nombre'] ?></td></tr>
                              <tr><td>Línea:</td><td><?php echo $carro['linea'] ?></td></tr>
                              <tr><td>Modelo:</td><td><?php echo $carro['modelo'] ?></td></tr>
                              <tr><td>Color:</td><td><?php echo $carro['color'] ?></td></tr>
                              <tr><td>Cilindraje:</td><td><?php echo $carro['c_c'] ?></td></tr>
                              <tr><td>Cilindros:</td><td><?php echo $carro['cilindraje'] ?></td></tr>
                              <tr><td>Combustible:</td><td><?php echo $combustible[$carro['combustible_id']] ?></td></tr>
                            </tbody>
                          </table>
                        </div>
                      </section>
                    </article>
                  </div>
                </div><!--/col-->
                <div class=" col-sm-4 text-center" >

                  <div class="panel panel-default" >
                  <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="" class="center-block img-circle img-responsive profile-img" style="margin-top:15px">
                  <p></p>
                  <strong><?php echo $carro['NOMBRE']?></strong></div>
                </div><!--/col-->
              </div>
              <div class="form-group"></div>

              <?php

              if(count($cupones_utilizados)>0)
              {
                ?>
                <table id="cupones_asignados_list_id" class="table  table-condensed " width="100%">
                  <thead >
                          <tr>

                             <th class="text-left">Estado</th>
                              <th class="text-right">Cupon</th>
                              <th class="text-right">Monto
                                <?php if (usuarioPrivilegiado()->hasPrivilege('crearCupon') && permiso_perm(10)  || usuarioPrivilegiado()->hasPrivilege('Configuracion')){?>
                                  <span class="btn-edit" onclick="load_devolver_vehiculo(<?php echo $year?>,<?php echo $m ?>,<?php echo $solicitud ?>,<?php echo $vehiculo?>,<?php echo $dep_id?>)" style="margin-top:-10px; margin-left:0.2%"></span>
                                <?php }?></th>


                          </tr>
                      </thead>
                      <tbody>
                        <?php


                              foreach ($cupones_utilizados as $cu){


                                  //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                  echo '<td class="text-left"><strong>';
                                  if($cu['cupon_status']==1)
                                  {
                                    echo '<span class="label label-success">Cupon Asignado</span>';
                                  }
                                  else {

                                    echo '<span class="label label-danger">Cupon Devuelto</span>';
                                  }

                                  echo '</strong></td>';
                                  echo '<td class="text-right"><strong>'.$cu['cupon_id'].'</strong></td>';
                                  echo '<td class="text-right"><strong>'.$cu['monto'].'</strong></td>';




                                  echo '</tr>';
                                }

                              ?>
                    </tbody>
                </table>
                <?php
              }
              else {
                if($carro['estado_solicitud']== 0){
                  if (usuarioPrivilegiado()->hasPrivilege('crearCupon') && permiso_perm(3) || usuarioPrivilegiado()->hasPrivilege('Configuracion')) :


                  ?>

                <div class="form-group">
                  <div class="col-sm-8">
                    <div class="form-material">
                      <!--<input class="js-tags-input form-control" type="text" id="destinatarios" name="destinatarios" value="" required>-->
                      <label for="cupones">Asignar Cupon(es)*</label>
                      <div class="input-group">
                        <span class="input-group-addon" ><span class="fa fa-ticket"></span></span>
                        <select name="cupones" id="cupones"  multiple="multiple" data-placeholder="Seleccione uno o mas Cupones" class="chosen-select-width col-xs-12" multiple tabindex="6" required>
                          <?php
                          foreach ($cupones as $c):
                            echo '<option value="'.$c["cupon_id"].'">'.$c["cupon_id"].' - '.$c['monto'].'</option>';
                            endforeach
                            ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-material">
                      <button class="btn btn-sm btn-success btn-block" onclick="asignar_cupones(<?php echo $year ?>,<?php echo $m?>,<?php echo $solicitud?>,<?php echo $carro['vehiculo_id'] ?>,<?php echo $carro['monto'] ?>,<?php echo $carro['dep_id'] ?>)"  id="boton_a_v" ><i style="display:none;" id="loading_ascv" class="fa fa-refresh fa-spin"></i> Asignar Cupon (es)</button>
                    </div>
                  </div>
                </div>
              <?php
            else:
              ?>
              <p>No se le han asignados cupones</p>
              <?php
              endif;
            }
              }
              ?>

              <?php if($carro['km_ini']==0.00 && $carro['km_fin']==0.00 && $carro['fecha_autorizado']!='0000-00-00' && permiso_perm(6) && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
              {
                  
                  echo 'Registrar kilometros';
                ?>
                <div id="kilometrajes">
                </div>

                <?php


              }
              
               else
                if($carro['km_ini']==0.00 && $carro['km_fin']!=0.00 && $carro['fecha_autorizado']!='0000-00-00' && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
                {
                    
                     echo 'Formulario de Llenado de kilometraje de nueva solicitud : "llenar kilometrajes " : ';
                     //echo 'Ultimo kilometraje inicial registradoooooo: ';
                              //echo $carro['km_ini'];
                    
                  ?>
              
              
               <div id="kilometrajes">
                </div>

                <?php
               }
               
               else
                if($carro['km_ini']!=0.00 && $carro['km_fin']==0.00 && $carro['fecha_autorizado']!='0000-00-00' && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
                {
                    
                     echo 'Instrucciones: "llenar  nuevo kilometraje final" : ';
                     //echo 'Ultimo kilometraje inicial registradoooooo: ';
                              //echo $carro['km_ini'];
                    
                  ?>
              
              
               <div id="kilometrajes">
                </div>

                <?php
               }
              
              else
                if($carro['km_ini']!=0.00 && $carro['km_fin']!=0.00 && $carro['fecha_autorizado']!='0000-00-00' && usuarioPrivilegiado()->hasPrivilege('leerCupon'))
                {
                  ?>
                  <div class="form-group"></div>
                  <div class="form-group">
                    <div class="col-xs-8">
                      <div class="">

                          <div class="block-header bg-gray-lighter" >
                            <div class="col-sm-4">
                              <span class=""  ><strong>Kilometraje Inicial: </strong></span>
                            </div>
                            <div class="col-xs-2">
                              <span class="" ><?php echo $carro['km_ini']?></span>
                            </div>
                            <div class="col-xs-4">
                              <span class=""  ><strong> Kilometraje Final: </strong></span>
                            </div>
                            <div class="col-xs-2">
                              <span class="" ><?php echo $carro['km_fin']?></span>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-xs-4">
                      <div class="">

                          <div class="block-header bg-gray-lighter " >
                            <div class="col-xs-8">
                              <span class=""  ><strong>Galones Consumidos </strong></span>
                            </div>
                            <div class="col-xs-2">
                              <span class=""  ><?php echo $carro['galones_consumidos']?></span>
                            </div>
                          </div>
                      </div>
                    </div>
                      
                       <div class="col-xs-4">
                      <div class="">

                          <div class="block-header bg-gray-lighter " >
                            <div class="col-xs-8">
                              <span class=""  ><strong>Destino </strong></span>
                            </div>
                            <div class="col-xs-2">
                              <span class=""  ><?php echo $carro['destino']?></span>
                            </div>
                          </div>
                      </div>
                    </div>
                      
                  </div>
                  
                  <?php
                   echo '<b> Kilometrajes Registrados </b> ';
                  //recordatorio modificado...........
              }
             // else if(count($cupones_utilizados)>0 && $carro['fecha_autorizado']!='0000-00-00'){
             //   echo '<p>No se han asignados los kilómetros inicial y final</p>';
                
             // else if($carro['km_fin']>$carro['km_ini'] && $carro['fecha_autorizado']!='0000-00-00' && permiso_perm(6) && usuarioPrivilegiado()->hasPrivilege('leerCupon')) {
                
                
             // }?>

              <!-- final -->



        </form>



          <!-- Page JS Code -->


        </body>
        </html>

        <?php
         {
            
                  
                                      
                            
          ?>
          <script>
          $(document).ready(function(){
            get_kilometraje_vehiculo_by_id(<?php echo $year?>,<?php echo $m ?>,<?php echo $solicitud ?>,<?php echo $vehiculo?>,<?php echo $dep_id?>)
          });
          </script>
          <?php

        }?>

        <script src="combustible/js/asignar_cupones_solicitud_vehiculo_form_validate.js"></script>

        <?php
        else :
            echo include(unauthorizedModal());
        endif;
    else:
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
