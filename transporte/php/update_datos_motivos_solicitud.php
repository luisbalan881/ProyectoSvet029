<?php

require_once '../../inc/functions.php';
require_once '../../inc/User.php';

sec_session_start();

$solicitud=$_POST['solicitud'];
$correlativo=$_POST['correlativo'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "UPDATE vp_solicitud_transporte_destino_motivo SET status=?
        WHERE solicitud_id=? AND correlativo=?";
$q = $pdo->prepare($sql);
$q->execute(array(0,$solicitud,$correlativo));

Database::disconnect();


 ?>
