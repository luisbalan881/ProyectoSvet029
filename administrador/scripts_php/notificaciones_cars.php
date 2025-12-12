<?php


include_once '../../inc/functions.php';

sec_session_start();

      $id=$_SESSION['user_id'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT COUNT(T1.vehiculo_id) as conteo FROM vp_solicitud_transporte_vehiculo AS T1
        INNER JOIN vp_solicitud_transporte AS T2 ON T2.solicitud_id=T1.solicitud_id
        WHERE T2.solicitante_id=? AND T2.status_tiempo_finalizado=?";

$p = $pdo->prepare($sql);
$p->execute(array($id,1));
$notify = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();

$conteo = $notify['conteo'];
echo $conteo;


?>
