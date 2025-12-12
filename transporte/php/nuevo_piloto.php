<?php

require_once '../../inc/Database.php';

$conductor=$_POST['conductor'];
$dep_id=$_POST['dep_id'];
$licencia=$_POST['licencia'];

$fecha=$_POST['fecha_cad'];
$date=date('Y-m-d', strtotime($fecha));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "INSERT INTO vp_conductor (user_id, dep_id, licencia_num, licencia_cad, status) VALUES(?,?,?,?,?)";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($conductor,$dep_id,$licencia,$date,1));
Database::disconnect();

echo 'Piloto Creado';
 ?>
