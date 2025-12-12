<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerSolicitudTransporte')) :
          $emp = $_POST['emp'];
          include_once 'php/funciones.php';
          include_once 'php/get_solicitud.php';
          $solicitudes = array();
          $solicitudes = solicitudes_list_por_usuario($emp);



          ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>




        </head>
        <body >



                    <table id="solicitudes_list" class="table  table-condensed  ">
                      <thead >
                              <tr>
                                  <th class="text-center">Solicitud</th>
                                <!--<th class="text-center" >Dia</th>-->
                                <th class="text-center" >Fecha</th>
                                  <th class="text-center">Status</th>
                                  <th class="text-center">Finalizado</th>
                                  <th class="text-center">Imprimir</th>




                              </tr>
                          </thead>
                          <tbody>
                            <?php


                                  foreach ($solicitudes as $s){

                                      echo '<tr '.(($s['STATUS_SOL'] == 0)?'class="danger"':'"class="danger"').'>';

                                      echo '<td class="text-center">'.$s['IDX'].'</td>';

                                      echo '<td class="text-center">'.date('d-m-Y', strtotime($s['FECHA'])).'</td>';

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

                                      //echo '<td class="text-center">'.$s['DESTINO'].'</td>';
                                      //echo '<td class="text-center">'.$s['MOTIVO'].'</td>';

                                      echo '<td class="text-center">';
                                      echo '<div class=" progress">';
                                      if($s['FINALIZADO']==0)
                                      {
                                        echo '<div class="progress progress-striped skill-bar ">
                                                <div class="progress-bar progress-bar-striped progress-bar-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="max-width: 10%">

                                                </div>
                                              </div>';
                                      }
                                      else if($s['FINALIZADO']==1){
                                        echo '<div class="progress progress-striped skill-bar ">
                                                <div class="progress-bar progress-bar-striped progress-bar-primary " role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="60%" style="max-width: 60%">

                                                </div>
                                              </div>';
                                      }
                                      else if($s['FINALIZADO']==2){
                                        echo '<div class="progress progress-striped skill-bar ">
                                                <div class="progress-bar progress-bar-striped progress-bar-success " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">

                                                </div>
                                              </div>';
                                      }
                                      else if($s['FINALIZADO']==3){
                                        echo '<div class="progress progress-striped skill-bar ">
                                                <div class="progress-bar progress-bar-striped progress-bar-danger " role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">

                                                </div>
                                              </div>';
                                      }

                                      echo '
                                      </div>

                                      </td>';

                                          echo '<td class="text-center" style="white-space: nowrap;">';
                                          echo '<span title="Editar"><a class="btn btn-warning outline"  title="Actualizar" data-toggle="modal" data-target="#modal-remoto-lgg" href="transporte/ver_solicitud.php?id='.$s['ID'].'" ><i class="fa fa-pencil-square-o "></i></a></span>';
                                          $vehiculo = get_vehiculo_by_id($s['ID']);
                                          $conductor = get_conductor_by_id($s['ID']);

                                          echo '<button class="btn btn-warning outline"  title="Generar Solcitud"';
                                          echo ' onclick="HTMLtoPDF('.$s['ID'].')" enabled>';
                                            echo '<i class="fa fa-download "></i></button>';
                                          if($conductor['conductor_id']=="" || $vehiculo['vehiculo_id']=="")
                                          {

                                          }
                                          else
                                          {

                                              echo '<span class="btn-checkk"></span>';
                                          }



                                          echo '</td>';

                                      echo '</tr>';
                                  }
                                  ?>
                        </tbody>
                    </table>


                    <script>

                    $(document).ready(function() {
                      setTimeout(function(){
                                      $('.progress-bar').addClass('progress-bar active');
                                 }, 1300);
                      var table = $('#solicitudes_list').DataTable({
                        "pageLength": 10,

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
                        "displayLength": 10
                      } );

                      // Order by the grouping

                    } );

                    $(document).ready(function() {
     $('.progress .progress-bar').css("width",
               function() {
                   return $(this).attr("aria-valuenow") + "%";
               }
       )
   });


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
