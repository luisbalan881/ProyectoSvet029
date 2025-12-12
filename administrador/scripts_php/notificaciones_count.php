<?php

require_once '../../inc/Database.php';

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT COUNT(*) as conteo FROM vp_user where verificacion = 0 OR verificacion = 2";

$p = $pdo->prepare($sql);
$p->execute(array());
$notify = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

$conteo = $notify['conteo'];
echo $conteo;


?>
