<?php

require_once '../../inc/Database.php';


$id=$_POST['codigo'];
$inst_id=$_POST['inst'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


/*
$sql= "SELECT MAX(solicitud_id) as codigo from vp_solicitud_transporte WHERE solicitante_id=?";
$p = $pdo->prepare($sql);
$p->execute(array($id));
$solicitud = $p->fetch(PDO::FETCH_ASSOC);


$codigo_soli = $solicitud['codigo'];

*/

$sql1 = "INSERT INTO vp_solicitud_transporte_departamento (solicitud_id, dep_id) VALUES (?,?)";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($id,$inst_id));
Database::disconnect();

echo 'Solicitud Generada';
 ?>
