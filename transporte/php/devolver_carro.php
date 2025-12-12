<?php
require_once '../../inc/Database.php';
date_default_timezone_set('America/Guatemala');

$solicitud = $_POST['solicitud'];
$fecha=$_POST['fecha'];
$status=0;
$car=$_POST['car'];
//$user=$_POST['user'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


/*$sql1 = "SELECT vehiculo_id FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($solicitud));
$vehiculos = $q1->fetchAll();


foreach($vehiculos as $c){*/
  $sql2 = "UPDATE vp_vehiculo SET status_uso = ?, comision_id=? where vehiculo_id=?";
  $q2 = $pdo->prepare($sql2);
  $q2->execute(array($status,0,$car));

  $sql2 = "UPDATE vp_solicitud_transporte_vehiculo SET estado_entregado = ? where solicitud_id=? AND vehiculo_id=? AND fecha_asignado=?";
  $q2 = $pdo->prepare($sql2);
  $q2->execute(array(2,$solicitud,$car,$fecha));
/*}



/**/





Database::disconnect();

echo 'Vehículo Asignado';

?>
