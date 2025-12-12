<?php

require_once '../../inc/Database.php';


$id=$_POST['codigo'];
$inst_id2=$_POST['inst2'];
$dia=3;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




/*
$sql= "SELECT MAX(solicitud_id) as codigo from vp_solicitud_transporte WHERE solicitante_id=?";
$p = $pdo->prepare($sql);
$p->execute(array($id));
$solicitud = $p->fetch(PDO::FETCH_ASSOC);


$codigo_soli = $solicitud['codigo'];

*/

$sql12 = "INSERT INTO vs_detalle (id_nombramiento, id_tipo,dia) VALUES (?,?,?)";
$q12 = $pdo->prepare($sql12);
$q12->execute(array($id,$inst_id2,$dia));
Database::disconnect();

echo 'Solicitud Generada';
 ?>
