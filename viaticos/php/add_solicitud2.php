<?php

require_once '../../inc/Database.php';

$dia1=1;
$id=$_POST['codigo'];
$inst_id=$_POST['inst'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




/*
$sql= "SELECT MAX(solicitud_id) as codigo from vp_solicitud_transporte WHERE solicitante_id=?";
$p = $pdo->prepare($sql);
$p->execute(array($id));
$solicitud = $p->fetch(PDO::FETCH_ASSOC);

$sql2= "SELECT MAX(contador)+1 AS con from vs_nombramiento where dep_f1=?";
$p2 = $pdo->prepare($sql2);
$p2->execute(array($persona['dep_id']));
$per_rol2 = $p2->fetch(PDO::FETCH_ASSOC);
$con1 = $per_rol2['con']; //perosona autoriza



$codigo_soli = $solicitud['codigo'];

*/



/*$sql1 = "UPDATE vs_nombramiento SET status=?
        WHERE id_nombramiento=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($status,$id));
*/
$sql2= "SELECT MAX(id_viatico)+1 AS con from vs_viaticos";
$p2 = $pdo->prepare($sql2);
$p2->execute();
$per_rol2 = $p2->fetch(PDO::FETCH_ASSOC);
$con1 = $per_rol2['con']; //perosona autoriza




$sql3 = "INSERT INTO vs_viaticos (id_viatico,id_nombramiento) VALUES (?,?)";
$q2 = $pdo->prepare($sql3);
$q2->execute(array($con1,$id));
Database::disconnect();

echo 'Solicitud Generada';
 ?>