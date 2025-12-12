<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
$pdo = Database::connect();

$cadena = $_POST['pk'];
$segmentos = explode("/",$cadena);

$mm = $_POST['name'];
$ss = explode("/",$mm);

$year=$segmentos[0];
$mes=$segmentos[1];
$solicitud=$segmentos[2];
$vehiculo=$ss[0];
$monto=$ss[1]
$dep_id=$segmentos[3];

$responsable=$_SESSION['user_id'];


$sql3 = "UPDATE vp_solicitud_cupon_vehiculo SET monto=?
         WHERE year=? AND mes=? AND solicitud_id=? AND vehiculo_id=? AND dep_id=?";
$p3 = $pdo->prepare($sql3);
$p3->execute(array($monto,$year,$mes,$solicitud,$vehiculo,$dep_id));

Database::disconnect();
?>
