<?php
require_once '../../inc/Database.php';
$user_mod = $_POST['user_id'];


$user_id = $_POST['codigo'];
$user_vid = $_POST['vid'];
$fecha_ini = $_POST['from'];
$date1 = date('Y-m-d', strtotime($fecha_ini));
$fecha_fin = $_POST['to'];
$date2 = date('Y-m-d', strtotime($fecha_fin));
$resolucion = $_POST['resolucion'];
$tipo_sus = $_POST['dia'];
$desc = $_POST['sus_desc'];



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO vp_user_suspenciones (user_id, user_vid, fecha_ini, fecha_fin, resolucion, descripcion, tipo_suspencion, realizado_por) VALUES (?,?,?,?,?,?,?,?) ";
$q = $pdo->prepare($sql);
$q->execute(array($user_id,$user_vid,$date1,$date2,$resolucion,$desc,$tipo_sus,$user_mod));

if($tipo_sus ==6)
{
  $sql3 = "SELECT min(periodo_inicio) as p_i, min(periodo_final) as p_f FROM vp_user_periodo where user_id=? AND dias_pendiente > ?";
  $q3 = $pdo->prepare($sql3);
  $q3->execute(array($user_id,0));
  $periodo = $q3->fetch(PDO::FETCH_ASSOC);

  $fi = $periodo['p_i'];
  $ff = $periodo['p_f'];

  $sql4 = "SELECT COUNT(*) as conteo FROM vp_calendario_general
              WHERE fecha_laboral BETWEEN ? AND ?
               AND tipo_dia_laboral <> 3 AND tipo_dia_laboral <> 50 AND tipo_dia_laboral <> 1";
  $q4 = $pdo->prepare($sql4);
  $q4->execute(array($date1,$date2));
  $dias = $q4->fetch(PDO::FETCH_ASSOC);

  $dias_gozados = $dias['conteo'];



  $sql5 = "UPDATE vp_user_periodo SET dias_gozados = dias_gozados + ?, dias_pendiente = dias_pendiente - ?
  WHERE periodo_inicio=? AND periodo_final = ? AND user_id=?";
  $q5 = $pdo->prepare($sql5);
  $q5->execute(array($dias_gozados,$dias_gozados,$fi,$ff,$user_id));

  $sql6 = "INSERT INTO vp_user_periodo_resolucion (periodo_inicio,periodo_final,user_id,resolucion,dias_solicitados,creado_por)VALUES(?,?,?,?,?,?)";
  $q6 = $pdo->prepare($sql6);
  $q6->execute(array($fi,$ff,$user_id,$resolucion,$dias_gozados,$user_mod));
}

if($tipo_sus ==49)
{

}
else {
  $sql2 = "UPDATE vp_user_horario_general SET tipo_dia_laboral = ?
  WHERE fecha_laboral BETWEEN ? AND ? and user_vid = ? AND tipo_dia_laboral <> 3 AND tipo_dia_laboral <> 1 AND tipo_dia_laboral <> 50";
  $q2 = $pdo->prepare($sql2);
  $q2->execute(array($tipo_sus,$date1,$date2,$user_vid));
}
Database::disconnect();
//echo $date1 .' '. $date2 .' '. $user_vid .' '.  $dias_gozados;
?>
