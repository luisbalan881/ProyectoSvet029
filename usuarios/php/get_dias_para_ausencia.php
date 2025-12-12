<?php
require_once '../../inc/functions.php';
require_once '../../inc/Database.php';
$user_vid=$_POST['user_vid'];
$from=$_POST['from'];
$to=$_POST['to'];
$fi = date('Y-m-d', strtotime($from));
$ff = date('Y-m-d', strtotime($to));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT CONCAT(t4.user_nm1, ' ', t4.user_nm2, ' ', t4.user_ap1, ' ' , t4.user_ap2) as NOMBRE,
        t1.fecha_laboral as FECHA,
        t1.tipo_dia_laboral AS LABOR, t3.dia_nm AS DIAN
        FROM vp_user_horario_general t1
        INNER JOIN vp_user  t4 ON t1.user_vid = t4.user_vid
        INNER JOIN vp_catalogo_dia_laboral t3 ON t1.tipo_dia_laboral = t3.dia_laboral_id
        INNER JOIN vp_catalogo_horario t5 ON t4.user_horario_id=t5.hora_id



WHERE t1.user_vid = ?  AND t1.fecha_laboral BETWEEN ? AND ?

ORDER BY t1.user_vid, t1.fecha_laboral ASC";

$p = $pdo->prepare($sql);
$p->execute(array($user_vid, $fi, $ff));
$persona = $p->fetchAll();
Database::disconnect();

$conteo = 0;

foreach ($persona as $s):
  if($s['LABOR']==0){
    $conteo++;
  }
endforeach;
echo '<table class="table table-sm mi_tabla">';
echo '<thead>';
echo '<th class="text-center">Dia</th>';
echo '<th class="text-center">Fecha</th>';
echo '<th class="text-center">Tipo Dia</th>';

echo '</thead>';
echo '<tbody>';
foreach($persona as $p){

  echo '<tr>';
  echo '<td class="text-center">';
  echo User::get_nombre_dia($p['FECHA']);
  echo '</td>';
  echo '<td class="text-center">';
  echo fecha_dmy($p['FECHA']);
  echo '</td>';
  echo '<td class="text-center">';
  if($p['LABOR'] == '0'){ echo '<span  id="'.$p['FECHA'].'" class="label label-danger">Ausente</span> ';}
  else if($p['LABOR'] == '1'){ echo '<span id="'.$p['FECHA'].'" class="label label-success" disabled></span>';}
  else if($p['LABOR'] == '2'){ echo '<span id="'.$p['FECHA'].'" class="label label-warning">Permiso</span>';}
  else if($p['LABOR'] == '3'){ echo '<span id="'.$p['FECHA'].'" class="label label-success" disabled>Feriado</span>';}
  else if($p['LABOR'] == '4'){ echo '<span id="'.$p['FECHA'].'" class="label label-info">No Laboraba</span>';}
  else if($p['LABOR'] == '6'){ echo '<span id="'.$p['FECHA'].'" class="label label-vacaciones">Vacaciones</span>';}
  else if($p['LABOR'] == '7'){ echo '<span id="'.$p['FECHA'].'" class="label label-warning"><i class="fa fa-hand-o-up"/>  Aún no marcaba</span>';}
  else if($p['LABOR'] == '5'){ echo '<span id="'.$p['FECHA'].'" class="label label-primary"><i class="fa fa-heartbeat"/> -   Suspendido IGSS</span';}
  else if($p['LABOR'] == '50'){ echo '<span id="'.$p['FECHA'].'" class="label label-warning">Permiso VP</span>';}
  else{
    echo '<span  id="'.$p['FECHA'].'" class="label label-secondary">'.$p['DIAN'].'</span>';
  }

  echo'</td>';
  echo '<tr>';

}
echo '</tbody>';

echo '</table>';
echo '<p>';
echo 'Dias que se podrá ausentar: '.$conteo;
echo '</p>';
//echo $user_vid. ' ** '.$fi . ' ****** '.$ff;
?>

<style>
.mi_tabla table {
width: 100%;
}

.mi_tabla thead,.mi_tabla  tbody,.mi_tabla  tr,.mi_tabla  td,.mi_tabla  th { display: block; }

.mi_tabla tr:after {
content: ' ';
display: block;
visibility: hidden;
clear: both;
}

.mi_tabla thead th {
height: 50px;

/*text-align: left;*/
}

.mi_tabla tbody {
height: 350px;
overflow-y: auto;
}

.mi_tabla thead {
/* fallback */
}


.mi_tabla tbody td,.mi_tabla  thead th {
width: 33.3%;
float: left;
}
</style>
