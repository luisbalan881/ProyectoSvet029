<?php
include_once '../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
  if (usuarioPrivilegiado()->hasPrivilege('leerUsuario')) :
    $id = null;
    $vid = null;
    date_default_timezone_set('America/Guatemala');
    $year= $_POST['year'];
    ?>
    <!DOCTYPE html>
    <html>
    <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title>Usuario Modificar</title>
    </head>
    <body>
      <table id="horarios_semana"class="table dt-responsive display nowrap" width="100%">
        <thead>
          <th class="text-center">Semana</th>
          <th class="text-center">Grupo</th>
          <th class="text-center">Entrada</th>
          <th class="text-center">Salida</th>
          <th class="text-center">Acción</th>
        </thead>
        <tbody>
          <?php

          define('NL', "\n");

          //$year           = 2018;
          $firstDayOfYear = mktime(0, 0, 0, 1, 1, $year);
          $nextMonday     = strtotime('monday', $firstDayOfYear);
          $nextSunday     = strtotime('sunday', $nextMonday);
          $x = 1;

          while (date('Y', $nextMonday) == $year) {

            $fecha_1 = strtotime('+1 day', $nextMonday);
            $fecha_2 = strtotime('+2 day', $nextMonday);
            $fecha_3 = strtotime('+3 day', $nextMonday);
            $fecha_4 = strtotime('+4 day', $nextMonday);
            $fecha_5 = strtotime('+5 day', $nextMonday);
            $fecha_6 = strtotime('+6 day', $nextMonday);
            $fecha_7 = strtotime('+7 day', $nextMonday);

            ?>
              <?php







          if (User::check_in_range(date('Y-m-d', $nextMonday), date('Y-m-d',$fecha_7), date('Y-m-d')))
          {
            echo '<tr class="gray">';
          } else {
            echo '<tr>';
          }


            echo '<td class="text-center" valing="middle"><strong>Semana '.$x.'</strong></td>';
            $name = User::get_nombre_grupo_por_semana_year($x,$year);
            echo '<td class="text-center" valing="middle">'.$name['horario_especial_desc'].'</td>';
            echo '<td class="text-center" valing="middle">'.fecha_dmy(date('Y-m-d', $nextMonday)).'</td>';

            echo '<td class="text-center" valing="middle">'.fecha_dmy(date('Y-m-d',$fecha_7)).'</td>';
            echo '<td class="text-center">';?>
              <div class="btn-group btn-group-sm">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="Second group">


                  <?php
                  echo '<button  title="Detalle de la semana" class="btn btn-personalizado outline"  title="Listado de Suspenciones" data-toggle="modal" data-target="#modal-remoto-lgg1" href="usuarios/empleados_horarios_especial_list_detalle.php?year='.$year.'&semana='.$x.'"  ><i class="fa fa-calendar-check-o"></i></button>';
                  ?>
                </div>
              </div>
            </div>
            <?php
            echo '</td>';




            echo '</tr>';




    $nextMonday = strtotime('+1 week', $nextMonday);
    $nextSunday = strtotime('+1 week', $nextSunday);
    $x++;
}
/*echo '</tbody>';
echo '</table>';*/
          ?>
        </tbody>
      </table>
      <br>


<script>
$('#horarios_semana').DataTable( {
  dom: 'Bfrtip',
  "paging":   true,
  "ordering": false,
  "info":     true,
  "search": true,
  "searching": true,
  buttons:[],
  renderer: 'bootstrap',
  oLanguage: {
      /*sLengthMenu: "_MENU_",
       sInfo: "Showing <strong>_START_</strong>-<strong>_END_</strong> of <strong>_TOTAL_</strong>",
       oPaginate: {
       sPrevious: '<i class="fa fa-angle-left"></i>',
       sNext: '<i class="fa fa-angle-right"></i>'
       }*/
      sProcessing:     "Procesando...",
      sLengthMenu:     "Mostrar _MENU_ registros",
      sZeroRecords:    "No se encontraron resultados",
      sEmptyTable:     "Ningún dato disponible en esta tabla",
      sInfo:           "Mostrando semanas de la _START_ a la _END_ de un total de _TOTAL_ semanas",
      sInfoEmpty:      "Mostrando semanas de la 0 a la 0 de un total de 0 semanas",
      sInfoFiltered:   "(filtrado de un total de _MAX_ semanas)",
      sInfoPostFix:    "",
      sSearch:         "Buscar:",
      sUrl:            "",
      sInfoThousands:  ",",
      sLoadingRecords: "Cargando...",
      oPaginate: {
          sFirst:    "Primero",
          sLast:     "Último",
          sNext:     "<i class='fa fa-chevron-right'></i>",
          sPrevious: "<i class='fa fa-chevron-left'></i>"
      },
      oAria: {
          sSortAscending:  ": Activar para ordenar la columna de manera ascendente",
          sSortDescending: ": Activar para ordenar la columna de manera descendente"
      }
  }
} );
</script>
</body>
</html>
    <?php
else:
    echo include(unauthorized());
endif;
else:
echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;
?>
