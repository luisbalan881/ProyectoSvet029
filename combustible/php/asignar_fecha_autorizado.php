<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
$pdo = Database::connect();

$year=$_POST['year'];
$mes=$_POST['mes'];
$solicitud=$_POST['solicitud_id'];
$dep_id=$_POST['dep_id'];



$responsable=$_SESSION['user_id'];

date_default_timezone_set('America/Guatemala');
$date = date('Y-m-d H:i:s');




$sql3 = "UPDATE vp_solicitud_cupon SET estado_solicitud=?,fecha_autorizado=?, autorizado=?
         WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=?";
$p3 = $pdo->prepare($sql3);
$p3->execute(array(2,$date,$responsable,$year,$mes,$solicitud,$dep_id));




Database::disconnect();
?>
