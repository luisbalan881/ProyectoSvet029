<?php 
require_once '../../inc/Database.php';
$solicitud=$_POST['solicitud'];
$vehiculo = $_POST['vehiculo'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "UPDATE vp_solicitud_transporte_vehiculo SET estado_entregado=? WHERE solicitud_id=? AND vehiculo_id=?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array(3,$solicitud,$vehiculo));
Database::disconnect();
echo 'Vehiculo Devuelto';
?>