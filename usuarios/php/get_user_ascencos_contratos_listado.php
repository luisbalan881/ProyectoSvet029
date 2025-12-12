<?php
include_once '../../inc/functions.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
  if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

    $id= $_POST['id'];
    $historial = User::get_empleado_ascensos_contratos_historial_id($id);
    $persona = User::get_empleado_datos_id($id);
    $pendientes = User::verificar_partidas_vigente($id);

    $r = "'".$persona['renglon']."'";
?>

  <!DOCTYPE html>
  <html>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title></title>
      <script src="../herramientas/assets/js/plugins/jspdf/jspdf.js"></script>
      <script src="../herramientas/assets/js/plugins/jspdf/kardex_por_partida.js"></script>

  </head>
  <body>
    <div style="width: 1040px"class=" form-horizontal push-10-t push-10">

    <table id="historial" class="table table-bordered table-condensed table-striped dt-responsive display nowrp" cellspacing="0" width="100%">
      <thead>
        <th class="text-center">Acuerdo</th>
        <th class="text-center">Partida</th>
        <th class="text-center">Fecha</th>
        <th class="text-center">Renglon</th>


        <th class="text-center">Contrato</th>
        <th class="text-center">Fianza</th>
        <th class="text-center">Estado</th>


        <th class="text-center">Acción
          <?php if($pendientes){?><span class="btn-add" onclick="nueva_partida(<?php echo $id ?>,<?php echo $r ?>)" style="margin-top:-30px;margin-right:-42px;"></span><?php }?></th>
      </thead>
      <tbody>
        <?php
        foreach($historial as $h){
          echo '<tr>';
          echo '<td class="text-center">'.$h['acuerdo_vice'].'</td>';
          $resultado = substr($h['partida'], -17);
          echo '<td class="text-center">'.$resultado.'</td>';
          echo '<td class="text-center">'.$h['fecha_acuerdo'].'</td>';
          echo '<td class="text-center">'.$h['grupo_id'].$h['subgrupo_id'].$h['renglon_id'].'</td>';
          /*echo '<td class="text-center">'.$h['user_puesto'].'</td>';
          echo '<td class="text-center">'.$h['user_nom'].'</td>';*/
          echo '<td class="text-center">'.$h['contrato_num'].'</td>';
          echo '<td class="text-center">';
          if($h['fianza']==0){
            echo '';
          }
          else {
            echo $h['fianza'];
          }
          echo '</td>';
          echo '<td class="text-center">';
          if($h['fecha_destitucion']!='0000-00-00')
          {
            echo '<span class="label label-danger">Finalizado</span>';
          }
          else {
            echo '<span class="label label-success">Vigente</span>';
          }
          echo '</td>';
          echo '<td class="text-center">';
          echo '<div class="btn-group btn-group-sm" role="group">
                <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                <div class="btn-group mr-2" role="group" aria-label="Second group">';
          echo '<span class="btn btn-personalizado outline" onclick="HTMLtoPDF('.$id.','.$h['correlativo'].')"><i class="fa fa-download"></i></span>';

          $renglon ="'".$h['grupo_id'].$h['subgrupo_id'].$h['renglon_id']."'";
          echo '<span class="btn btn-personalizado outline" onclick="finalizar_partida('.$id.','.$h['correlativo'].','.$renglon.')"><i class="fa fa-times"></i></span>';
          echo '<span class="btn btn-personalizado outline" onclick="editar_partida('.$id.','.$h['correlativo'].','.$renglon.')"><i class="si si-pencil"></i></span>';
          echo '</div></div></div></td>';
          echo '</tr>';
        }
        ?>
      </tbody>
    </table>
  </div>
 <script>
 $('#historial').DataTable( {
   dom: 'Bfrtip',
   "paging":   false,
   "ordering": false,
   "info":     true,
   "search": true,
   "searching": true,
   buttons:[]
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
