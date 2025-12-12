<?php
require_once '../../inc/Database.php';


$solicitud = $_POST['comision'];
$status=0;
$statusf=3;


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "UPDATE vp_solicitud_transporte SET status_tiempo_finalizado = ?, status_solicitud = ? where solicitud_id = ?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($statusf,2,$solicitud));

$sql = "SELECT vehiculo_id FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($solicitud));
$vehiculos = $q->fetchAll();

foreach($vehiculos as $c){
$sql2 = "UPDATE vp_vehiculo SET status_uso = ?, comision_id=? where vehiculo_id=?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($status,0,$c['vehiculo_id']));
}


$sql4 = "UPDATE vp_solicitud_transporte_destino_motivo SET status = ? where solicitud_id=?";
$q4 = $pdo->prepare($sql4);
$q4->execute(array($status,$solicitud));

$sql4 = "UPDATE vp_solicitud_transporte_vehiculo SET estado_entregado = ? where solicitud_id=?";
$q4 = $pdo->prepare($sql4);
$q4->execute(array(3,$solicitud));



Database::disconnect();

//echo 'Solicitud Cancelada';

?>
