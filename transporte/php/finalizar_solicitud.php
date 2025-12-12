<?php
require_once '../../inc/Database.php';

//$carro = $_POST['carro'];
$solicitud = $_POST['comision'];
$status=0;
$statusf=2;


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "SELECT vehiculo_id FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($solicitud));
$vehiculos = $q->fetchAll();


$sql1 = "UPDATE vp_solicitud_transporte SET status_tiempo_finalizado = ?where solicitud_id = ?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($statusf,$solicitud));

/*foreach($vehiculos as $c){
$sql2 = "UPDATE vp_vehiculo SET status_uso = ?, comision_id=? where vehiculo_id=?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($status,0,$c['vehiculo_id']));
}*/


Database::disconnect();

echo 'Solicitud Finalizada';

?>
