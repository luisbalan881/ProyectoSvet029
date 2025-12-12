<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerSolicitudTransporte')) :

      include_once 'php/funciones.php';
      $solicitudes = array();
        $solicitudes = solicitudes_list();

        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>




        </head>
        <body >



                    <table id="solicitudes_list" class="table table-bordered table-condensed table-striped ">
                      <thead >
					  <tr>
                                    <td colspan="9">
                                        <form id="fechas" action="" method="POST">
                                            <label>Fecha inicial: </label><input type="date" id="fecha1" name="fecha1" placeholder='<?php echo $date1 ?>' style="margin:5px"/>
                                            <label>Fecha final: </label><input type="date" id="fecha2" name="fecha2" placeholder='<?php echo $date2 ?>' style="margin:5px"/>
                                            <input type="submit" value="Ver"/>
                                        </form>
                                    </td>
                                </tr>
                              <tr>
                                  <th class="text-center">Solicitud</th>
                                <!--<th class="text-center" >Dia</th>-->
                                <th class="text-center" >Fecha</th>
                                  <th class="text-center" >Salida</th>
                                  <th class="text-center">Duración</th>
                                  <th class="text-center">No. Personas</th>
                                  <th class="text-center">Solicitante</th>
                                  <th class="text-center">Ext.</th>
								  <th class="text-center">Hora </th>
                                  <th class="text-center">Status</th>
                                <th class="text-center">Destino</th>
								<!--<th class="text-center" >Dia</th>
                                
                                //<th class="text-center">motivo</th>
                      echo '-->


                                  <th class="text-center">Finalizado</th>
                                  <th class="text-center">Acción</th>




                              </tr>
                          </thead>
                          <tbody>
                            <?php


                                  foreach ($solicitudes as $s){

                                      echo '<tr '.(($s['STATUS_SOL'] == 0)?'class="warning"':'"class="warning"').'>';
                                      //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                      echo '<td class="text-center">'.$s['IDX'].'</td>';
                                      //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                      echo '<td class="text-center">'.date('d-m-Y', strtotime($s['FECHA'])).'</td>';
                                      echo '<td class="text-center">'.$s['SALIDA'].'</td>';
                                      echo '<td class="text-center">'.$s['DURACION'].' ';
                                      if($s['TIPO_D'] == 1){
                                        echo  ' Hora(s)</td>';
                                      }else {
                                        echo  ' Dia(s)</td>';
                                      }

                                      echo '<td class="text-center">'.$s['CANT'].'</td>';
                                      echo '<td class="text-center">'.$s['NOMBRE'].'</td>';
                                      echo '<td class="text-center">'.$s['EXT'].'</td>';
									  echo '<td class="text-center">'.$s['Creacion'].'</td>';
                                      echo '<td class="text-center">';
                                      if($s['STATUS_SOL']==0)
                                      {
                                        echo '<span class="label label-warning">Pendiente</span> </td>';
                                      }
                                      else if($s['STATUS_SOL']==1){
                                        echo '<span class="label label-success">Aprobado</span> </td>';
                                      }
                                      else if($s['STATUS_SOL']==2){
                                        echo '<span class="label label-danger">Cancelado</span> </td>';
                                      }

                                      echo '<td class="text-center">'.$s['DESTINO'].'</td>';
                                      //echo '<td class="text-center">'.$s['MOTIVO'].'</td>';

                                      echo '<td class="text-center">';
                                      if($s['FINALIZADO']==0)
                                      {
                                        echo '<span class="label label-warning">Sin Vehículo</span> </td>';
                                      }
                                      else if($s['FINALIZADO']==1){
                                        echo '<span class="label label-primary">En curso</span> </td>';
                                      }
                                      else if($s['FINALIZADO']==2){
                                        echo '<span class="label label-success">Finalizado</span> </td>';
                                      }
                                      else if($s['FINALIZADO']==3){
                                        echo '<span class="label label-danger">Cancelado</span> </td>';
                                      }

                                          echo '<td class="text-center" style="white-space: nowrap;">';

                                          echo '<span title="Editar"><a class="btn btn-warning outline"  title="Actualizar" data-toggle="modal" data-target="#modal-remoto-lgg" href="transporte/ver_solicitud.php?id='.$s['ID'].'" ><i class="fa fa-pencil-square-o "></i></a></span>';

                                          echo '</td>';




                                      echo '</tr>';
                                  }
                                  ?>
                        </tbody>
                    </table>
                    <script>
                    $(document).ready(function() {
                      var table = $('#solicitudes_list').DataTable({
                        "pageLength": 50,

                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Todos"]],
                        buttons: [],
                        columnDefs: [
                            {responsivePriority:0, targets: [0,2,-1]},
                            {responsivePriority:1, targets: [8,9]},
                            {responsivePriority:2, targets: [3,4]},
                            {responsivePriority:3, targets: [1]},
                            {responsivePriority:4, targets: [5,6,7]}
                        ],

                         "ordering": false,
                        "columnDefs": [
                          //{ "visible": false, "targets": 0 }
                        ],
                        "order": [[ 0, 'asc' ]],
                        "displayLength": 25
                      } );

                      // Order by the grouping

                    } );
              </script>


        </body>



        </html>
        <!-- FIN Contenido de Pagina -->
        <?php
    else:
        echo include(unauthorized());
    endif;
else:
  echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
