<?php
    include_once '../../inc/functions.php';
    include_once 'get_solicitud.php';

    sec_session_start();
    $u = usuarioPrivilegiado();
    if (function_exists('login_check') && login_check() == true) :
        if ($u->hasPrivilege('leerSolicitudTransporte') ) :
            $id = null;
            $user = $_SESSION['user_id'];
            //$solicitud = $_POST['id'];
            //$fee = $_POST['fee'];

              $id = $_POST['id'];

            $persona = User::get_empleado_datos_id($user);

           //$departamentos = departamentos();
           include_once '../../combustible/inc/Driver.php';
           include_once 'funciones.php';
            $solicitud = get_solicitud_by_id($id);
            $vehiculos = get_vehiculos($persona['dep_id']);
            $vehiculo_asig = get_vehiculo_by_id($id);
            $conteo = verificar_vehiculo($id);
            $conteo2 = verificar_vehiculo_asignado($id);
            $drivers = User::getAllDrivers($persona['dep_id']);
            $driver_asig = get_conductor_by_id($id);

            $veri_devueltos = verificar_vehiculo_devueltos($id);

            $d_m = get_destinos_motivos_por_solicitud_transporte($id);

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
            <script src="assets/js/plugins/push/push.min.js"></script>
            <link rel="stylesheet" href="assets/js/plugins/bootstrap-datepicker/datepicker33.min.css">
            <script src="assets/js/plugins/timepicker/js/timepicki.js"></script>
            <link href="assets/js/plugins/timepicker/css/timepicki.css" rel="stylesheet">
            <script src="transporte/js/funciones.js"></script>
            <script src="assets/js/plugins/jspdf/jspdf.js"></script>
            <script src="assets/js/plugins/jspdf/pdfFromHTML.js"></script>



        </head>

        <body>




              <div id="SolicitudForm" class=" form-horizontal " >
                <div class="form-group">
                  <div class="col-xs-6">
                    <div class="">

                        <label for="destinatarios">Departamento(s)</label>
                        <div class="input-group has-personalizado" >
                          <span class="input-group-addon" disabled ><span class="fa fa-home"></span></span>
                          <input class=" form-control" type="text" id="departamentos" name="departamentos" value="<?php echo $solicitud['DEP']?>" required disabled>
                        </div>

                    </div>
                  </div>

                    <div class="col-xs-6">
                        <div class=" ">
                          <label for="soli_cantidad">Autorizado por:</label>
                          <div class="input-group has-personalizado">
                            <span class="input-group-addon" disabled ><span class="fa fa-check"></span></span>
                            <input class="form-control"    id="soli_autorizacion" value="<?php echo $solicitud['ID_JEFE'] ?>" name="soli_autorizacion"  disabled>
                          </div>
                        </div>
                    </div>


                  </div>

                  <div class="form-group"><div class="col-xs-3"> <small class="text-muted">Fecha de la Comisión: </small>
                  <h5><?php echo fecha_dmy($solicitud['FECHA']) ?></h5> <small class="text-muted p-t-30 db">Hora de Salida</small>
                  <h5><?php echo $solicitud['SALIDA'] ?></h5> <small class="text-muted p-t-30 db">Duración de la Comisión:</small>
                  <h5><?php echo $solicitud['DURACION'] ?>
                    <?php
                    if($solicitud['TIPO_D']==3)
                    {
                      echo 'Minuto(s)';
                    }
                    else if($solicitud['TIPO_D']==1)
                    {
                      echo 'Hora(s)';
                    }
                    else if($solicitud['TIPO_D']==2)
                    {
                      echo 'Dia(s)';
                    }
                    ?>
                  </h5>
                    <small class="text-muted">Número de personas a viajar: </small>
                   <h5><?php echo $solicitud['CANT'] ?></h5>
                 </h5>
                   <small class="text-muted">Solicitante: </small>
                  <h5><?php echo $solicitud['NOMBRE'] ?></h5>

                </div>
                <div class="col-xs-5">
                  <div class="map-box" style="border-left: 2px dashed #F2F1EF;">
                      <!--<iframe src="https://www.google.com/maps/embed/v1/place?q=Guatemala&key=AIzaSyDAPeu374M0blM0pcqvAccuWxOyelA0S-I" width="100%" height="150" frameborder="0" style="border:0" allowfullscreen=""></iframe>-->
                      <div class="" style="height:190px">

                            <h4 style="margin:10px 10px"><i class="fa fa-pencil"></i> Personas que asisten a comisión</h4>

                        <div class="panel-body">
                          <p><?php if($solicitud['DESCRIPCION']!='' && $solicitud['DESCRIPCION']!='.'){
                            echo $solicitud['DESCRIPCION'];}
                            else{echo 'No hay anotaciones para esta comisión.';} ?></p>
                        </div>
                      </div>
                  </div>


              </div>
              <div class="col-xs-4">
                <div class="map-box" style="border-left: 2px dashed #F2F1EF;">
                  <div class="" style="height:190px">
                    <?php
                    echo '<h4 style="margin:10px 10px"';
                    if($solicitud['FINALIZADO']==2){
                      echo 'class="text-success"><i class="fa fa-check-circle "></i> Comisión Finalizada';
                    }else if($solicitud['FINALIZADO']==3){
                      echo 'class="text-danger"><i class="fa fa-times-circle"></i> Comisión Cancelada';
                    }
                    else if($solicitud['FINALIZADO']==1){
                      echo 'class="text-primary">Comisión en transcurso';
                    }
                    else if($solicitud['FINALIZADO']==0){
                        echo 'class="text-warning"><i class="fa fa-warning"></i> Comisión pendiente';
                    }
                    echo ' </h4>';
                    ?>

                <div class="panel-body">


                  <p>Para cualquier cambio de esta comisión, contacte al responsable de dicho evento</p>
                </div>
                  </div>
                </div>
              </div>
              <?php
              if($solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3){
              }else{
                if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {
                ?>
              <span class="btn-edit" onclick="editar_datos_solicitud(<?php echo $id?>)"></span>
            <?php } }?>
              </div>


                <div class="col-xs-12" style="border-bottom: 2px dashed #F2F1EF;opacity:0.4;margin-top:-12px">
                </div>
                <br>



                  <div class="form-group">

                      <div class="col-xs-12">
                        <ol class="breadcrumb breadcrumb-arrow">

                        <li ><a>Destino (s)</a></li>
                        <?php
                        if($solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3){
                        }else{
                          if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {
                          ?>
                        <span class="btn-edit" onclick="editar_motivos_solicitud(<?php echo $id?>)" style="margin-top:10px; margin-left:2%"></span>
                      <?php } }?>

                      </ol>

                      <br>

                  <?php
                  foreach($d_m as $dm)
                  {
                    ?>

                    <div class="tickets-container">
                      <ul class="tickets-list">
                          <li class="ticket-item">
                              <div class="row">
                                  <div class="ticket-time col-md-5 col-sm-12">
                                      <i class="fa fa-map-marker"></i>
                                      <span class="user-name">Destino</span>
                                      <span><strong><?php echo $dm['destino'] ?></strong></span>
                                  </div>
                                  <div class="ticket-time  col-md-7 col-sm-12 col-xs-12">
                                      <div class="divider hidden-md hidden-sm hidden-xs"></div>

                                      <textarea ><?php echo $dm['motivo']?></textarea>
                                  </div>

                                  <div class="ticket-state <?php if($dm['status']==1){echo 'bg-palegreen';}else if($dm['status']==0){echo 'bg-palered';}?> ">
                                    <img src="assets/img/<?php if($dm['status']==1){echo 'tick.png';}else if($dm['status']==0){echo 'equis.png';}?> "/>
                                      <!--<i class="fa fa-check"></i>-->
                                  </div>
                              </div>
                          </li>
                        </ul>
                      </div>


                    <?php

                  }
                ?>
                <br>
              </div>
          </div>

                  <?php if($conteo2==0){
                    if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {?>

                    <label class="label label-secondary">Agregar Vehículo</label> <span title="Agregar Vehículo" onclick="agregar_otro_vehiculo(<?php echo $solicitud['ID']?>)" class="btn-add"></span>
                    <br><br><br>


                <?php }else{echo 'No se le ha asignado vehículo';}}
                else {

                  $cars = get_carros_por_solicitud_transporte($solicitud['ID']);
                  ?>


                  <ol class="breadcrumb breadcrumb-arrow">

                  <li ><a>Vehículo (s)</a></li>
                  <?php
                  if($solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3){
                  }else{
                    if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {
                    ?>
                  <span class="btn-edit" onclick="editar_vehiculos_solicitud(<?php echo $id?>)" style="margin-top:10px; margin-left:2%"></span>
                <?php }} ?>
                </ol>
                <br>

                  <?php
                  foreach($cars as $car)
                  {
                    ?>
                    <div class="tickets-container">
                      <ul class="tickets-list">
                          <li class="ticket-item">
                              <div class="row">
                                  <div class="ticket-time col-md-5 col-sm-12  col-xs-12">
                                      <i class="fa fa-car"></i>
                                      <strong>  <?php echo $car['placa'] ?> - <?php echo $car['nombre'] ?> - <?php echo $car['linea'] ?></strong>
                                  </div>
                                  <div class="ticket-time  col-md-5 col-sm-12 col-xs-12">
                                      <div class="divider hidden-md hidden-sm hidden-xs"></div>
                                      <i class="fa fa-user"></i>
                                      <span ><?php echo $car['CONDUCTOR'] ?></span>
                                  </div>
                                  <div class="ticket-time  col-md-1 col-sm-12 col-xs-12">

                                      <?php if($car['tipo_de_transporte']==1){
                                        echo '<span class="label label-success">Llevar y traer</span>';
                                      }
                                      else  if($car['tipo_de_transporte']==2){
                                        echo '<span class="label label-success">Llevar</span>';
                                      }
                                      else
                                      if($car['tipo_de_transporte']==3){
                                        echo '<span class="label label-success">Traer</span>';
                                     }?>

                                  </div>
                                  <div class="ticket-time col-md-1 col-sm-12 col-xs-12">
                                    <?php $ver = verificar_vehiculo_entregado($solicitud['ID'],$car['vehiculo_id'], $car['fecha_asignado']);
                                    $f = "'".$car['fecha_asignado']."'";
                                    if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {
                                      if($solicitud['FINALIZADO']==1 && $ver['estado_entregado']==0){
                                        echo '<span title="Entregar Vehículo" onclick="establecer_ocupado_carro('.$solicitud['ID'].','.$car['vehiculo_id'].','.$f.')" class="btn-ok" ></span>';
                                      }else {
                                        if($solicitud['FINALIZADO']==1 && $ver['estado_entregado']==1){
                                          echo '<span title="Regresar Vehículo" class="btn-devolver" onclick="devolver_ocupado_carro('.$solicitud['ID'].','.$car['vehiculo_id'].','.$f.')"></span>';
                                        }
                                      }
                                    }
                                    ?>
                                  </div>

                                  <?php if($car['estado_entregado']==1){ ?>
                                    <div class="ticket-state bg-paleaqua">
                                      <img src="assets/img/tick.png"/>
                                    </div>
                                  <?php }?>

                                  <?php if($car['estado_entregado']==2){ ?>
                                    <div class="ticket-state bg-palegreen">
                                      <img src="assets/img/tick.png"/>
                                    </div>
                                  <?php }?>

                                  <?php if($car['estado_entregado']==3){ ?>
                                    <div class="ticket-state bg-palered">
                                      <img src="assets/img/equis.png"/>
                                    </div>
                                  <?php }?>




                              </div>

                          </li>

                        </ul>
                      </div>



                    <?php

                  }
                  echo '';
                  if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {
                      if($solicitud['FINALIZADO']==0 || $solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3)
                      { } else{
                        echo '<label class="label label-secondary">Agregar Vehículo</label> <span title="Agregar Vehículo" onclick="agregar_otro_vehiculo('.$solicitud['ID'].')" class="btn-add"></span>';}
                      echo '<br><br>';
                      //echo '<p>Ya tiene piloto y vehículo asignado</p>';
                    }
                  }?>



                  <div class="form-group">
                    <div class="col-xs-6 text-left">

                    </div>


                    <div class="col-xs-6 text-right">

                      <div class="btn-group btn-group-sm">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-2" role="group" aria-label="Second group">

                          <!--<button title="Asignar Vehículo" class="btn  btn-personalizado  outline "  <?php if($conteo==0 && $solicitud['FINALIZADO']==0){ echo 'onclick="add_car('.$id.','.$user.')"'; } else{ echo 'disabled';} ?> ><i class="fa fa-car"></i>  </button>
                          <!--<button title="Cambiar Vehículo" class="btn  btn-personalizado  outline"  <?php if($conteo==1 && $solicitud['FINALIZADO']==1){ echo 'onclick="delete_car('.$id.','.$user.')"';} else{ echo 'disabled';} ?> ><i class="fa fa-car"></i>  </button>-->
                          <?php if (usuarioPrivilegiado()->hasPrivilege('autorizarSolicitudTransporte')) {?>
                            <button title="Cancelar Solicitud" class="btn btn-personalizado outline"  <?php if( $solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3){ echo 'disabled';} else{ echo 'onclick="cancelar_solicitud('.$id.')"';} ?> ><i class="fa fa-times"></i> </button>
                            <button title="Finalizar Solicitud" class="btn btn-personalizado outline"  <?php if($solicitud['FINALIZADO']==0 || $solicitud['FINALIZADO']==2 || $solicitud['FINALIZADO']==3 || ($conteo2-$veri_devueltos)>0){ echo 'disabled';} else{ echo 'onclick="finalizar_solicitud('.$id.')"';} ?>  ><i class="fa fa-check"></i>  </button>
                          <?php }?>
                          <!--<button title="Imprimir" class="btn btn-personalizado outline"  <?php if($conteo==1){ echo 'enabled';} else{ echo 'onclick="HTMLtoPDF('.$id.')"';} ?>  ><i class="fa fa-print"></i></button>-->
                          <button title="Imprimir" class="btn btn-personalizado outline"  onclick="HTMLtoPDF(<?php echo $id ?>)"  ><i class="fa fa-print"></i></button>
                        </div>
                      </div>
                    </div>
                    </div>
                    <div>
                    <div style="margin-left:13px;">


                  </div>
                </div>
                </div>
              </div>





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
       echo "<script type='text/javascript'> window.location='../index.php'; </script>";
    endif;
?>
