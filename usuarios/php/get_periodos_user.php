<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
$id = $_POST['id'];
$jefe = $_POST['jefe'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT periodo_inicio, periodo_final, user_id, dias_total, dias_gozados, dias_pendiente
        FROM vp_user_periodo WHERE user_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($id));
$sus = $q->fetchAll();
Database::disconnect();
$conteo = 0;

foreach ($sus as $s):
  $conteo++;
endforeach;

$f = date('Y-m-d');

if($conteo > 0)
{
  echo '<br><br><br>';
 echo '<table id="peri" class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
   <thead >
           <tr>
           <th colspan="2" scope="colgroup" class="text-center"><span id="printe" class="label label-warning outline" onclick="imprimir()" style="float:left; padding-top:-5px;cursor:pointer">Imprimir</span> Período</th>
             <th class="text-center" >Total de Dias</th>
             <th class="text-center" >Dias gozados</th>
             <th class="text-center" >Dias pendientes</th>
             <th class="text-center" >Estado</th>
             <th class="text-center" id="d">Detalle';
             if(permiso_dep(7)|| usuarioPrivilegiado()->hasPrivilege('Configuracion'))
             {
               echo '<span  title="Agregar Período" class="btn-add" onclick="generar_periodos('.$id.','.$jefe.')"  style="margin-top:-20px;margin-right:-15px;""></span>';
             }
             echo '</th>';
           echo '</tr>
       </thead>
       <tbody>';


           foreach ($sus as $s){
             echo '<tr>';

               //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';

               echo '<td class="text-center">'.fecha_dmy($s['periodo_inicio']).'</td>';
               echo '<td class="text-center">'.fecha_dmy($s['periodo_final']).'</td>';
               echo '<td class="text-center">'.$s['dias_total'].'</td>';
               echo '<td class="text-center">'.$s['dias_gozados'].'</td>';
               echo '<td class="text-center">'.$s['dias_pendiente'].'</td>';

               $fi = "'".($s['periodo_inicio'])."'";
               $ff = "'".($s['periodo_final'])."'";
               echo '<td class="text-center">';

               if($s['dias_pendiente']==0)
               {
                 echo '<span class="label label-secondary">Periodo Utilizado</span>';
               }
               if($s['dias_pendiente']==20)
               {
                 echo '<span class="label label-warning">Periodo Pendiente</span>';
               }
               else
               if($s['dias_pendiente']>0 && $s['dias_pendiente']<20){
                 echo '<span class="label label-success">Periodo en uso</span>';
               }

               echo '</td>';
               echo '<td class="text-center" id="de">';
               echo '<span  title="Editar"><a class="btn btn-success outline" onclick="load_vacaciones_por_periodo('.$id.','.$fi.','.$ff.','.$jefe.')" title="Detalle"><i class="fa fa-info-circle"></i></a></span>';
               if(($s['periodo_final'])>$f)
               {
                 if(permiso_dep(7)|| usuarioPrivilegiado()->hasPrivilege('Configuracion'))
                 {
                   echo '<span class="btn-delete" onclick="delete_periodo_from_user('.$id.','.$fi.','.$ff.','.$jefe.')"></span>';
                 }
               }
               echo'</td>';
               /*echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

               echo '</tr>';
           }

   echo '
   </tbody>
 </table>';

}
else {
  echo '<br><br>';
  echo 'El empleado no tiene períodos generados';
  if(permiso_dep(7) || usuarioPrivilegiado()->hasPrivilege('Configuracion') )
  {

    echo'<span  title="Agregar Período" onclick="generar_periodos('.$id.','.$jefe.')" class="btn-add" style="margin-top:-5px;margin-right:-7px;"></span>';
  }
}

?>
