<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
$pdo = Database::connect();

$year=$_POST['year'];
$mes=$_POST['mes'];
$solicitud=$_POST['solicitud_id'];
$vehiculo=$_POST['vehiculo_id'];
$cupon=$_POST['cupon_id'];
$dep_id=$_POST['dep_id'];

$responsable=$_SESSION['user_id'];






$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT IGNORE INTO vp_cupon_vehiculo_entregado (year,mes,solicitud_id,vehiculo_id,dep_id,cupon_id,cupon_status,entregado_por)
        VALUES (?,?,?,?,?,?,?,?)";
$p = $pdo->prepare($sql);
$p->execute(array($year,$mes,$solicitud,$vehiculo,$dep_id,$cupon,1,$responsable));


$sql2 = "UPDATE vp_cupon SET cupon_status=? WHERE cupon_id=?";
$p2 = $pdo->prepare($sql2);
$p2->execute(array(1,$cupon));

$sql3 = "UPDATE vp_solicitud_cupon_vehiculo SET estado_solicitud=?
         WHERE year=? AND mes=? AND solicitud_id=? AND vehiculo_id=? AND dep_id=?";
$p3 = $pdo->prepare($sql3);
$p3->execute(array(1,$year,$mes,$solicitud,$vehiculo,$dep_id));

$sql3 = "UPDATE vp_solicitud_cupon SET estado_solicitud=?
         WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=?";
$p3 = $pdo->prepare($sql3);
$p3->execute(array(1,$year,$mes,$solicitud,$dep_id));


Database::disconnect();
?>
