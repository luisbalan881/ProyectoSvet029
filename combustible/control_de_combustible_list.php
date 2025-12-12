<?php
include_once '../inc/functions.php';
sec_session_start();
    if (function_exists('login_check') && login_check() == true) :
        if (usuarioPrivilegiado()->hasPrivilege('leerCupon')):
      include_once 'php/funciones.php';
      $cupones = cupones_utilizados();

        ?>

        <!-- INICIO Contenido de pagina -->


        <html>
        <head>
            <meta http-equiv="content-type" content="text/html; charset=UTF-8">
            <title>Usuario Horario</title>




        </head>
        <body >



                    <table id="cupones_us_listado" class="table table-bordered table-condensed table-striped ">
                      <thead >
                              <tr>
                                  <th class="text-center" style="width:100px;">Cupon</th>
                                  <th class="text-center" style="width:100px;">Monto</th>
                                <!--<th class="text-center" >Dia</th>-->
                                <th class="text-center" style="width:140px;">Fecha</th>
                                  <th class="text-center" >Vechiculo</th>
                                  <th class="text-center" >Línea</th>
                                  <th class="text-center">Placa</th>
                                  <th class="text-center">Conductor</th>
                                  <th class="text-center" style="width:150px;">K_I / K_F</th>
                                  <th class="text-center">KILOMETROS</th>
                                  <th class="text-center">TOTAL</th>
                                  <th class="text-right" style="width:150px;">Acción <span id="" title="Asignar Cupones" class="btn-add"  style="margin-top:-25px;margin-right:-40px;" data-toggle="modal" data-target="#modal-remoto" href="combustible/asignar_cupones_vehiculo.php"></span></th>




                              </tr>
                          </thead>
                          <tbody>
                            <?php


                                  foreach ($cupones as $s){

                                    $tickets=explode(",",$s['cupones']);


                                      echo '<tr>';
                                      //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
                                      echo '<td class="text-right">';
                                      foreach($tickets as $t)
                                      {
                                        //echo '<i class="fa fa-ticket">';

                                          echo '</i><span class="label label-vacaciones label-personalizado" style="float:right; width:65px; margin-left:3px;margin-top:2px;">'.$t.'</span>  ';
                                          echo '<br>';



                                      }
                                      echo '</td>';
                                      echo '<td class="text-right">';
                                      $monto=explode(",",$s['monto']);
                                        foreach($monto as $t)
                                        {
                                          //echo '<i class="fa fa-ticket">';

                                            echo '</i><span class="label label-vacaciones label-personalizado" style="float:right; width:65px; margin-left:3px;margin-top:2px;">'.$t.'</span>  ';
                                            echo '<br>';
                                        }

                                      echo '</td>';
                                      //echo '<td class="text-center">'.get_nombre_dia($s['FECHA']).'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.date('d-m-Y', strtotime($s['fecha_entregado'])).'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['nombre'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['linea'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['placa'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['NOMBRE'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['km_inicio'].' / '.$s['km_final'].'</td>';
                                      $fi = "".fecha_dmy($s['fecha_entregado'])."";
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['km_re'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text">'.$s['montos'].'</td>';
                                      echo '<td class="text-center tabla-personalizada-text"><span class="btn btn-xs  btn-personalizado outline" data-toggle="modal" data-target="#modal-remoto" href="combustible/cupon_vehiculo_modificar.php?fecha='.$fi.'&vehiculo_id='.$s['vehiculo_id'].'"><i class="fa fa-pencil"></i></span></td>';





                                      echo '</tr>';
                                    }

                                  ?>
                        </tbody>
                    </table>
                    <script>
                    $(document).ready(function() {
                      var table = $('#cupones_us_listado').DataTable({
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
