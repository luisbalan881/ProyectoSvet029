<?php

require_once '../../inc/Database.php';

$status=3;
//$f="";
$id=$_POST['c'];
$km_fin=$_POST['dest']; //kmInicial
$destino=$_POST['kmInicial'];
//$recorrido=($km_fin - $km_inicial);
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "UPDATE vp_bitacora_vehiculo SET status=?, Destino=?
        WHERE id_bitacora=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($status,$destino,$id));
//Database::disconnect();

$Id = $pdo->lastInsertId();
Database::disconnect();
echo $Id;

//echo 'Updated successfully.';
 ?>
