<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
$id = $_POST['id'];
$pi = $_POST['pi'];
$pf = $_POST['pf'];
$jefe = $_POST['jefe'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT  T1.periodo_inicio, T1.periodo_final, T1.user_id, T1.resolucion, T1.dias_solicitados,
              T2.fecha_ini, T2.fecha_fin,T2.fecha_regreso
        FROM vp_user_periodo_resolucion AS T1
        LEFT JOIN vp_user_suspenciones AS T2 ON T1.resolucion = T2.resolucion
        WHERE T1.user_id=? AND T1.periodo_inicio=? AND T1.periodo_final=? AND T2.tipo_suspencion=?
        GROUP BY T1.resolucion
        ORDER BY T2.fecha_ini, T2.fecha_fin";
$q = $pdo->prepare($sql);
$q->execute(array($id,$pi,$pf,6));
$sus = $q->fetchAll();
Database::disconnect();

$conteo = 0;

foreach ($sus as $s):
  $conteo++;
endforeach;

if($conteo > 0)
{
  echo '<br><br><br>';
 echo '<table  class="print table-bordered table-condensed table-striped js-dataTable-usuariosH-general dt-responsive display nowrap" cellspacing="0" width="100%" style="margin-left:auto; margin-right:auto;">
   <thead >
           <tr>
             <th colspan="2" scope="colgroup" class="text-center">Período</th>
             <th class="text-center" >Resolución</th>
             <th class="text-center" >Dias Solicitados</th>
             <th class="text-center" >Del</th>
             <th class="text-center" >Al</th>
             <th class="text-center" >Regresa <span id="regresar" class="btn-circle"  onclick="load_periodo_list('.$id.','.$jefe.')"  style="margin-top:-20px;margin-right:-15px;"></span></th>
           </tr>
       </thead>
       <tbody>';


           foreach ($sus as $s){
             echo '<tr>';

               //echo '<td class="text-center">'.$p['NOMBRE'].'</td>';

               echo '<td class="text-center" >'.fecha_dmy($s['periodo_inicio']).'</td>';
               echo '<td class="text-center">'.fecha_dmy($s['periodo_final']).'</td>';
               echo '<td class="text-center">'.$s['resolucion'].'</td>';
               echo '<td class="text-center">'.$s['dias_solicitados'].'</td>';
               echo '<td class="text-center">';if(fecha_dmy($s['fecha_ini']) == "01-01-1970"){ echo ' -- '; }else{echo fecha_dmy($s['fecha_ini']);} echo'</td>';
               echo '<td class="text-center">';if(fecha_dmy($s['fecha_fin']) == "01-01-1970"){ echo ' -- '; }else{echo fecha_dmy($s['fecha_fin']);} echo'</td>';
               echo '<td class="text-center">';if(fecha_dmy($s['fecha_regreso']) == "01-01-1970" || ($s['fecha_regreso']) == "0000-00-00"){ echo ' -- '; }else{echo fecha_dmy($s['fecha_regreso']);} echo'</td>';
               echo '<span  title="Editar"></span>';
               echo'</td>';
               /*echo '<td class="text-center">'.(($p['S'] == '1')? '<span class="label label-danger">Se fue temprano</span>':'<span class="label label-info"></span>').'</td>';*/

               echo '</tr>';
           }

   echo '</tbody>

 </table>';
}
else {
  echo '<br><br>';
  echo 'El período no tiene movimientos <span id="regresar" class="btn-circle"  onclick="load_periodo_list('.$id.','.$jefe.')"  style="margin-top:0px;margin-right:0px;"></span>';
}
?>
