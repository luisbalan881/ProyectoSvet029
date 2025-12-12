<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
  if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :

$personas=personas_por_grupo_horario_especial();
?>
  <!DOCTYPE html>
  <html>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title></title>


  </head>
  <body>
    <?php echo '
 <table id="users_grupo_h" class="table-sm table-bordered table-condensed table-striped   display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
   <thead >
           <tr>
           <th class="text-center">NOMBRE</th>
           <th class="text-center">GRUPO</th>
           <th class="text-center">ESTADO</th>
           <th class="text-center">DETALLE</th>
           </tr>
       </thead>
       <tbody>';


           foreach ($personas as $p){
             echo '<tr>';
             echo '<td class="text-center">'.$p['nombre'].'</td>';
             echo '<td class="text-center">'.$p['horario_especial_desc'].'</td>';
             echo '<td class="text-center">';
                  if($p['user_status']==0){
                    echo '<span class="label label-danger">Inactivo</span>';
                  }
                  else
                  if($p['user_status']==1){
                    echo '<span class="label label-success">Activo</span>';
                  }
             echo '</td>';
             echo '<td class="text-center"><span class="btn btn-personalizado outline" onclick="load_usuario_detalle_por_grupo_list('.$p['user_id'].')"><i class="fa fa-calendar-check-o"></i></span></td>';
             echo '</tr>';
           }

   echo '</tbody>

 </table>';
 ?>
 <script>
 $(document).ready(function() {
   $('#users_grupo_h').DataTable( {
     dom: 'Bfrtip',
     "paging":   false,
     "ordering": false,
     "info":     true,
     "search": true,
     "searching": true,
     buttons:[]
   } );
 });
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
