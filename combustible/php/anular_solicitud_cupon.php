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






$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_cupon_vehiculo_entregado SET cupon_status=?
        WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=? AND entregado_por=?";
$p = $pdo->prepare($sql);
$p->execute(array(2,$year,$mes,$solicitud,$dep_id,$responsable));




$sql3 = "SELECT cupon_id FROM vp_cupon_vehiculo_entregado
        WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=? AND cupon_status=?";
$p3 = $pdo->prepare($sql3);
$p3->execute(array($year,$mes,$solicitud,$dep_id,2));
$cupones = $p3->fetchAll();

foreach($cupones as $c){
  $sql2 = "UPDATE vp_cupon SET cupon_status=? WHERE cupon_id=?";
  $p2 = $pdo->prepare($sql2);
  $p2->execute(array(0,$c['cupon_id']));
}


  $sql4 = "UPDATE vp_solicitud_cupon SET estado_solicitud=?
          WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=?";
  $p4 = $pdo->prepare($sql4);
  $p4->execute(array(3,$year,$mes,$solicitud,$dep_id));




Database::disconnect();
?>
