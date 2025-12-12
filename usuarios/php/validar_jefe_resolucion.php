<?php
require_once '../../inc/Database.php';

$resolucion = $_POST['resolucion'];
$jefe = $_POST['jefe'];
$pdo = Database::connect();

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user_suspenciones set rrhh_autorizado=? WHERE resolucion=?";
$q = $pdo->prepare($sql);
$q->execute(array($jefe,$resolucion));

Database::disconnect();

?>
