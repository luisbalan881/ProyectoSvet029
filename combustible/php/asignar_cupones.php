<?php
require_once '../../inc/Database.php';
$pdo = Database::connect();
$vehiculo=$_POST['vehiculo_id'];
$cupon=$_POST['cupon_id'];
$creador=$_POST['creador'];
$f=$_POST['fecha_asi'];
$fecha = date('Y-m-d', strtotime($f));





$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT IGNORE INTO vp_cupon_vehiculo (vehiculo_id, cupon_id,fecha_entregado,status,creado_por)
        VALUES (?,?,?,?,?)";
$p = $pdo->prepare($sql);
    $p->execute(array($vehiculo,$cupon,$fecha,1,$creador));


    $sql2 = "UPDATE vp_cupon SET cupon_status=? WHERE cupon_id=?";
    $p2 = $pdo->prepare($sql2);
        $p2->execute(array(1,$cupon));

Database::disconnect();
?>
