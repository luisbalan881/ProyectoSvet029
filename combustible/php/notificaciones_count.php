<?php

require_once '../../inc/Database.php';

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT COUNT(*) as conteo FROM vp_solicitud_cupon where estado_solicitud = 0 ";

$p = $pdo->prepare($sql);
$p->execute(array());
$notify = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

$conteo = $notify['conteo'];
echo $conteo;


?>
