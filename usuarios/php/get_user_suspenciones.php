<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
if (function_exists('login_check') && login_check() == true) :
  if (usuarioPrivilegiado()->hasPrivilege('modificarUsuario')) :
$jefe = $_POST['jefe'];
$id = $_POST['id'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT t1.fecha_ini as d, t1.fecha_fin as e, t1.resolucion as a, t1.descripcion as b,
        t2.dia_nm as c,t1.tipo_suspencion as f,t1.rrhh_autorizado as g, t1.user_vid FROM vp_user_suspenciones t1
        INNER JOIN vp_catalogo_dia_laboral t2 ON t1.tipo_suspencion = t2.dia_laboral_id
        WHERE t1.user_id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$sus = $q->fetchAll();
Database::disconnect();
$conteo = 0;

foreach ($sus as $s):
  $conteo++;
endforeach;

if($conteo > 0)
{?>
  <!DOCTYPE html>
  <html>
  <head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8">
      <title></title>


  </head>
  <body>
    <?php echo '
 <table id="suspencions_tbl" class="table-sm table-bordered table-condensed table-striped   display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
   <thead >
           <tr>
             <th class="text-center" style="width:110px">Resolución</th>
             <th class="text-center" style="width:400px">Descripción</th>
             <th class="text-center" >Ausencia</th>
             <th class="text-center" style="width:115px">Fecha Inicial</th>
             <th class="text-center"style="width:115px">Fecha Final</th>
             <th class="text-center" width:"15px">Acción';
             if (permiso_dep(2) || usuarioPrivilegiado()->hasPrivilege('Configuracion')) :
               echo '<span id="" title="Crear nueva ausencia" class="btn-add" onclick="cargar_forumulario_nueva_ausencia('.$id.')"  style="margin-top:-18px;margin-right:-40px;"></span>';
             endif;
             echo '</th>
           </tr>
       </thead>
       <tbody>';


           foreach ($sus as $s){
             echo '<tr>';

               //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';
               echo '<td class="text-center">'.$s['a'].'</td>';
               echo '<td class="text-center">'.$s['b'].'</td>';
               //echo '<td class="text-center">'.$s['c'].'</td>';
               echo '<td class="text-center">';
               if($s['f'] == '0'){ echo '<span class="label label-danger">Ausente</span> ';}
               else if($s['f'] == '1'){ echo '<span class="label label-success" disabled></span>';}
               else if($s['f'] == '2'){ echo '<span class="label label-warning">Permiso</span>';}
               else if($s['f'] == '3'){ echo '<span class="label label-success" disabled>Feriado</span>';}
               else if($s['f'] == '4'){ echo '<span class="label label-info">No Laboraba</span>';}
               else if($s['f'] == '6'){ echo '<span class="label label-vacaciones">Vacaciones</span>';
                 echo '<span id="regresar"';
                 if($s['g']==0)
                 {
                   echo 'class="btn-checkk-no"';
                 }
                 else {
                   echo 'class="btn-checkk"';
                 }
                  echo' ></span>' ;
               }
               else if($s['f'] == '7'){ echo '<span class="label label-warning"><i class="fa fa-hand-o-up"/>  Aún no marcaba</span>';}
               else if($s['f'] == '5'){ echo '<span class="label label-primary"><i class="fa fa-heartbeat"/> -   Suspendido IGSS</span';}
               else if($s['f'] == '50'){ echo '<span class="label label-warning">Permiso VP</span>';}
               else{
                 echo '<span class="label label-secondary">'.$s['c'].'</span>';
               }


               echo'</td>';
               echo '<td class="text-center">'.fecha_dmy($s['d']).'</td>';
               echo '<td class="text-center">'.fecha_dmy($s['e']).'</td>';
               $r = "'".$s['a']."'";
               $d = "'".$s['b']."'";
               $c = "'".$s['f']."'";
               $fi = "'".fecha_dmy($s['d'])."'";
               $ff = "'".fecha_dmy($s['e'])."'";


               echo '<td class="text-center">';
               echo '';
               echo '';
               echo '';
               echo '<div class="btn-group btn-group-sm" role="group">
                 <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                 <div class="btn-group mr-2" role="group" aria-label="Second group">
                   <button  title="Generar Informe" class="btn btn-personalizado outline" onclick="menu('.$s['f'].','.$id.','.$r.','.$s['g'].')"  title="Descargar" ><i class="fa fa-download"></i></button>
                   <button  title="Editar" class="btn btn-personalizado outline"  title="Editar"
                   onclick="cargar_formulario('.$r.','.$id.')" ><i class="fa fa-pencil"></i></button>
                   <button  title="Validar Informe" class="btn btn-personalizado outline" ';
                   if(permiso_dep(7))
                   {
                     echo 'onclick="validar_resolucion('.$id.','.$r.','.$jefe.','.$s['g'].')"  title="Descargar"';
                   }
                   else {
                     echo 'disabled onclick(alert("hola"))';
                   }
                   echo ' ><i class="fa fa-check"></i></button>
                   <button  title="Eliminar Resolución" class="btn btn-personalizado outline" ';
                   if(permiso_dep(10))
                   {
                     echo 'onclick="eliminar_resolucion('.$id.','.$r.','.$jefe.','.$s['g'].','.$s['user_vid'].','.$s['f'].','.$fi.','.$ff.')"  title="Descargar"';
                   }
                   else {
                     echo 'disabled )';
                   }
                   echo ' ><i class="fa fa-times"></i></button>

                 </div>
               </div>

               </div>';
               echo'</td>';
               /*echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

               echo '</tr>';
           }

   echo '</tbody>

 </table>';
 ?>
 <script>
 $(document).ready(function() {
   $('#suspencions_tbl').DataTable( {
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
}
else {
  echo '<br><br>';
  echo 'El empleado no tiene ausencias';
  if (permiso_dep(2) || usuarioPrivilegiado()->hasPrivilege('Configuracion')) :

    echo '<span id="" title="Crear nueva ausencia" class="btn-add" onclick="cargar_forumulario_nueva_ausencia('.$id.')"  style="margin-top:-5px;margin-right:-7px;"></span>';
  endif;
}
else:
    echo include(unauthorized());
endif;
else:
    echo "<script type='text/javascript'> window.location='../herramientas/inicio.php'; </script>";
endif;

?>
