<?php
require_once '../../inc/Database.php';
$user_mod = $_POST['jefe'];


$user_id = $_POST['id'];
$user_vid = $_POST['vid'];
$resolucion = $_POST['resolucion'];
$tipo_sus = $_POST['tipo'];

$fecha_ini = $_POST['fi'];
$date1 = date('Y-m-d', strtotime($fecha_ini));
$fecha_fin = $_POST['ff'];
$date2 = date('Y-m-d', strtotime($fecha_fin));


$pdo = Database::connect();


if($tipo_sus ==6)
{
  $sql3 = "SELECT periodo_inicio, periodo_final, dias_solicitados
           FROM vp_user_periodo_resolucion WHERE user_id=? AND resolucion=?";
  $q3 = $pdo->prepare($sql3);
  $q3->execute(array($user_id,$resolucion));
  $periodo = $q3->fetch(PDO::FETCH_ASSOC);

  $dias_solicitados = $periodo['dias_solicitados'];
  $fi = $periodo['periodo_inicio'];
  $ff = $periodo['periodo_final'];


  $sql5 = "UPDATE vp_user_periodo SET dias_gozados = dias_gozados - ?, dias_pendiente = dias_pendiente + ?
  WHERE periodo_inicio=? AND periodo_final = ? AND user_id=?";
  $q5 = $pdo->prepare($sql5);
  $q5->execute(array($dias_solicitados,$dias_solicitados,$fi,$ff,$user_id));

  $sql6 = "DELETE FROM vp_user_periodo_resolucion
           WHERE periodo_inicio=? AND periodo_final=? AND user_id=? AND resolucion=?";
  $q6 = $pdo->prepare($sql6);
  $q6->execute(array($fi,$ff,$user_id,$resolucion));
}

  $sql2 = "UPDATE vp_user_horario_general SET tipo_dia_laboral = ?
  WHERE fecha_laboral BETWEEN ? AND ? and user_vid = ? AND tipo_dia_laboral <> 3 AND tipo_dia_laboral <> 1 AND tipo_dia_laboral <> 50";
  $q2 = $pdo->prepare($sql2);
  $q2->execute(array(0,$date1,$date2,$user_vid));

  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "DELETE FROM vp_user_suspenciones WHERE user_id=? AND resolucion=?";
  $q = $pdo->prepare($sql);
  $q->execute(array($user_id,$resolucion));


Database::disconnect();
//echo $date1 .' '. $date2 .' '. $user_vid .' '.  $dias_gozados;
?>
