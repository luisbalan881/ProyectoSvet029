<?php


require_once '../../inc/Database.php';
$fe = $_POST['fe'];
$us = $_POST['us'];
$di = $_POST['di'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "  UPDATE vp_user_horario_general SET tipo_dia_laboral = :di
WHERE user_vid = :us AND fecha_laboral = :fe

";
$q = $pdo->prepare($sql);
$q->execute(array(
  'di' => $di,
  'us' => $us,
  'fe' => $fe

));
Database::disconnect();

echo 'correcto';





 ?>
