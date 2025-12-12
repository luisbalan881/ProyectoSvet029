<?php

require_once '../../inc/functions.php';


sec_session_start();

$destino=$_POST['value'];
//$motivo=$_POST['motivo'];
$solicitud=$_POST['pk'];
$correlativo=$_POST['name'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "UPDATE vp_solicitud_transporte_destino_motivo SET destino=?
        WHERE solicitud_id=? AND correlativo=?";
$q = $pdo->prepare($sql);
$q->execute(array($destino,$solicitud,$correlativo));
echo 'Updated successfully.';

Database::disconnect();


 ?>
