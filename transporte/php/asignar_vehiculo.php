<?php
require_once '../../inc/Database.php';
date_default_timezone_set('America/Guatemala');
$carro = $_POST['carro'];
$conductor = $_POST['conductor'];
$solicitud = $_POST['comision'];
$status=1;
$user=$_POST['user'];
$fecha = date('Y-m-d H:i:s');
$tipo_d_t=$_POST['tipo_d_t'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "UPDATE vp_solicitud_transporte SET status_tiempo_finalizado = ?, status_solicitud = ? where solicitud_id = ?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($status,$status,$solicitud));


$sql3 = "INSERT INTO vp_solicitud_transporte_vehiculo VALUES (?,?,?,?,?,?)";
$q3 = $pdo->prepare($sql3);
$q3->execute(array($solicitud,$carro,$conductor,0,$tipo_d_t,$fecha));


/*$sql2 = "UPDATE vp_vehiculo SET status_uso = ?, comision_id=? where vehiculo_id=?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($status,$solicitud,$carro));*/


$sql4 = "INSERT INTO vp_solicitud_transporte_vitacora VALUES (?,?,?,?,?)";
$q4 = $pdo->prepare($sql4);
$q4->execute(array($solicitud,$carro,$user,1,date("Y/m/d H:i:s")));



Database::disconnect();

echo 'Vehículo Asignado';

?>
