<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
      include_once 'php/funciones.php';
      $id=$_SESSION['user_id'];
      $cupones = get_cupones_grupos();

        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>




        </head>
        <body >



                    <table id="cupones_listado_grupo" class="table table-bordered table-condensed table-striped ">
                      <thead >
                              <tr>
                                  <th class="text-center">Cupon Inicial</th>
                                  <th class="text-center">Cupon Final</th>
                                <!--<th class="text-center" >Dia</th>-->
                                <th class="text-center" >Emisión</th>
                                  <th class="text-center" >Caducan</th>

                                  <th class="text-center">Cupones</th>
                                  <th class="text-center">Disponibles</th>
                                  <th class="text-center">Utilizados</th>
                                  <th class="text-center">Monto</th>
                                  <th class="text-center">Total</th>


                                  <th class="text-center">Acción
                                    <?php if (usuarioPrivilegiado()->hasPrivilege('crearCupon')) :?>
                                      <span id="" title="Agregar Cupones" class="btn-add"  style="margin-top:-25px;margin-right:-40px;" data-toggle="modal" data-target="#modal-remoto" href="combustible/cupones_nuevos.php"></span>
                                    <?php endif; ?>
                                  </th>




                              </tr>
                          </thead>
                          <tbody>
                            <?php


                                  foreach ($cupones as $s){

                                      echo '<tr>';
                                      //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                      echo '<td class="text-center">';

                                      echo '<strong> '.$s['c_ini'].'</strong>';

                                      echo '</td>';
                                      echo '<td class="text-center">';

                                      echo '<strong> '.$s['c_fin'].'</strong>';

                                      echo '</td>';
                                      //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                      echo '<td class="text-center">'.date('d-m-Y', strtotime($s['fecha_emision'])).'</td>';
                                      echo '<td class="text-center">'.date('d-m-Y', strtotime($s['fecha_caducidad'])).'</td>';

                                      echo '<td class="text-center">'.$s['todos']. '</td>';
                                      echo '<td class="text-center">'; $cd = get_cupones_disponibles($s['c_ini'],$s['c_fin']); echo $cd['disponibles']; echo '</td>';
                                      echo '<td class="text-center">'; $co = get_cupones_ocupados($s['c_ini'],$s['c_fin']); echo $co['ocupados']; echo '</td>';
                                      echo '<td class="text-center">'.$s['monto'].'</td>';
                                      echo '<td class="text-center">'.$s['total']. '</td>';

                                          echo '<td class="text-center" style="white-space: nowrap;">';

                                          echo '<span title="Ver cupones"class="btn btn-personalizado outline"  title="Ver Cupones" data-toggle="modal" data-target="#modal-remoto-lgg" href="combustible/control_de_cupones_list.php?inicio='.$s['c_ini'].'&fin='.$s['c_fin'].'"><i class="fa fa-ticket"></i></span>';

                                          echo '</td>';




                                      echo '</tr>';
                                  }
                                  ?>
                        </tbody>
                    </table>
                    <script>
                    $(document).ready(function() {
                      var table = $('#cupones_listado_grupo').DataTable({
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
        //echo include(unauthorized());
    endif;
else:
  echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
