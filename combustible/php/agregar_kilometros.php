<?php
require_once '../../inc/Database.php';
$pdo = Database::connect();
$year=$_POST['year'];
$mes=$_POST['mes'];
$solicitud=$_POST['solicitud_id'];
$vehiculo=$_POST['vehiculo_id'];
$gal=$_POST['galones'];
$des=$_POST['destino'];
$ki=$_POST['kilometro_i'];
$kf=$_POST['kilometro_f'];
$dep_id=$_POST['dep_id'];

date_default_timezone_set('America/Guatemala');
$date = date('Y-m-d H:i:s');




$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_solicitud_cupon_vehiculo SET km_ini=?, km_fin=?,galones_consumidos=?,destino=?,fecha_asignacion=?
      WHERE year=? AND mes=? AND solicitud_id=? AND vehiculo_id=? AND dep_id=?";
$p = $pdo->prepare($sql);
    $p->execute(array($ki,$kf,$gal,$des,$date,$year,$mes,$solicitud,$vehiculo,$dep_id));

Database::disconnect();
?>
