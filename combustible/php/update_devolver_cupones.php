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
date_default_timezone_set('America/Guatemala');
$responsable=$_SESSION['user_id'];



$fecha = date('Y-m-d H:i:s');


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_cupon_vehiculo_entregado SET cupon_status=?, fecha_devuelto=?, devuelto_por=?
        WHERE year=? AND mes=? AND solicitud_id=? AND vehiculo_id=? AND dep_id=? AND cupon_id=?";
$p = $pdo->prepare($sql);
$p->execute(array(2,$fecha,$responsable,$year,$mes,$solicitud,$vehiculo,$dep_id,$cupon));


$sql2 = "UPDATE vp_cupon SET cupon_status=? WHERE cupon_id=?";
$p2 = $pdo->prepare($sql2);
$p2->execute(array(0,$cupon));

$sql3 = "SELECT COUNT(*) AS CONTEO FROM vp_cupon_vehiculo_entregado
        WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=? AND cupon_status=?";
$p3 = $pdo->prepare($sql3);
$p3->execute(array($year,$mes,$solicitud,$dep_id,1));
$conteo = $p3->fetch(PDO::FETCH_ASSOC);

if($conteo['CONTEO']==0){
  $sql4 = "UPDATE vp_solicitud_cupon SET estado_solicitud=?
          WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=?";
  $p4 = $pdo->prepare($sql4);
  $p4->execute(array(3,$year,$mes,$solicitud,$dep_id));

}


Database::disconnect();
?>
