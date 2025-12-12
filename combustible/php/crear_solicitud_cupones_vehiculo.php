<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
date_default_timezone_set('America/Guatemala');
$solicitante=$_SESSION['user_id'];
$persona = User::get_empleado_datos_id($solicitante);

$year = $_POST['year'];
$mes = $_POST['mes'];
$solicitud=$_POST['solicitud'];
$vehiculo=$_POST['vehiculo_id'];
$monto=$_POST['monto'];
$conductor = $_POST['conductor_id'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "INSERT INTO vp_solicitud_cupon_vehiculo (year,mes,solicitud_id,vehiculo_id,dep_id,monto,conductor_id)VALUES(?,?,?,?,?,?,?)";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($year,$mes,$solicitud,$vehiculo,$persona['dep_id'],$monto,$conductor));
Database::disconnect();

echo 'Solicitud Generada';
 ?>
