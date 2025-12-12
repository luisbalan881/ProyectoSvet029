<?php
require_once '../../inc/Database.php';
$fecha = $_POST['fecha_per'];
$date1 = date('Y-m-d', strtotime($fecha));


$pdo = Database::connect();
set_time_limit(0);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user_horario_general set tipo_dia_laboral=? WHERE fecha_laboral=?";
$q = $pdo->prepare($sql);
$q->execute(array(50,$date1));

$sql55 = "UPDATE vp_calendario_general set tipo_dia_laboral=? WHERE fecha_laboral=?";
$q55 = $pdo->prepare($sql55);
$q55->execute(array(50,$date1));

$sql2 = "SELECT user_id FROM vp_user_suspenciones WHERE fecha_ini <=? AND fecha_fin>=? AND tipo_suspencion=?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($date1,$date1,6));
$empleados = $q2->fetchAll();

foreach ($empleados as $e){


  $sql3 = "SELECT max(periodo_inicio) as p_i, max(periodo_final) as p_f
  FROM vp_user_periodo_resolucion where user_id=?";
  $q3 = $pdo->prepare($sql3);
  $q3->execute(array($e['user_id']));
  $periodo = $q3->fetch(PDO::FETCH_ASSOC);

  $fi = $periodo['p_i'];
  $ff = $periodo['p_f'];


  $sql4 = "SELECT resolucion
  FROM vp_user_periodo_resolucion
  WHERE user_id=? AND periodo_inicio=? AND periodo_final=? ORDER BY resolucion DESC LIMIT 1";
  $q4 = $pdo->prepare($sql4);
  $q4->execute(array($e['user_id'],$fi,$ff));
  $resolucion = $q4->fetch(PDO::FETCH_ASSOC);

  $r = $resolucion['resolucion'];


  $sql5 = "UPDATE vp_user_periodo SET dias_gozados=dias_gozados-1, dias_pendiente=dias_pendiente+1
  WHERE periodo_inicio=? AND periodo_final=? AND user_id=?";
  $q5 = $pdo->prepare($sql5);
  $q5->execute(array($fi,$ff,$e['user_id']));

  $sql6 = "UPDATE vp_user_periodo_resolucion SET dias_solicitados=dias_solicitados-1
  WHERE periodo_inicio=? AND periodo_final=? AND user_id=? AND resolucion=?";
  $q6 = $pdo->prepare($sql6);
  $q6->execute(array($fi,$ff,$e['user_id'],$r));
}





Database::disconnect();
?>
