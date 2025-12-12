<?php
require_once '../../inc/Database.php';
$pdo = Database::connect();
$vehiculo=$_POST['vehiculo_id'];
$f=$_POST['fecha_asi'];
$conductor=$_POST['conductor_id'];
$creador=$_POST['creador'];

$fecha = date('Y-m-d', strtotime($f));



$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT IGNORE INTO vp_cupon_entregado (vehiculo_id, fecha_entregado,conductor_id,user_id)
        VALUES (?,?,?,?)";
$p = $pdo->prepare($sql);
    $p->execute(array($vehiculo,$fecha,$conductor,$creador));

Database::disconnect();
?>
