<?php

require_once '../../inc/Database.php';

$conductor=$_POST['conductor'];
$dep_id=$_POST['dep_id'];
$licencia=$_POST['licencia'];

$fecha=$_POST['fecha_cad'];
$date=date('Y-m-d', strtotime($fecha));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "UPDATE vp_conductor SET dep_id=?, licencia_num=?, licencia_cad=? WHERE user_id=?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($dep_id,$licencia,$date,$conductor));
Database::disconnect();

echo 'Piloto modificado';
 ?>
