<?php

require_once '../../inc/Database.php';

$status=2;
//$f="";
$id=$_POST['c'];
$descripcion=$_POST['descripcion']; //kmInicial
$control_km_mantenimiento=$_POST['control_km_mantenimiento'];
$vehiculo_id=$_POST['vehiculo_id'];
$reiniciar_contador = 0;
//$recorrido=($km_fin - $km_inicial);
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/*
$sql0= "SELECT contador_km_mantenimiento FROM `vp_bitacora_vehiculo` where id_bitacora=?";// quitar eststus
$p0 = $pdo->prepare($sql0);
$p0->execute(array($id));
$per_rol0 = $p0->fetch(PDO::FETCH_ASSOC);
    $contador = $per_rol0['contador_km_mantenimiento']; //ultima solicitud dada de vehiculo
//$contador1=($contador + $recorrido);*/
//
// 
// 
// 

/*
$sql2= "SELECT MAX(contador_km_mantenimiento) as cont, km_recorrido FROM `vp_bitacora_vehiculo` where vehiculo_id=?";
$p1 = $pdo->prepare($sql2);
$p1->execute(array($placa));
$per_rol = $p1->fetch(PDO::FETCH_ASSOC);


$enc = $per_rol['cont'];

//   
//
$contador2=$enc+$recorrido;
$sql1 = "UPDATE vp_bitacora_vehiculo SET status=?, km_final=?,km_recorrido=?, contador_km_mantenimiento=?
        WHERE id_bitacora=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($status,$km_fin,$recorrido,$contador2,$id));
//Database::disconnect();

$Id = $pdo->lastInsertId();
*/
// insertar en tabla de mantenimiento
$sql = "INSERT INTO  vp_mantenimiento_vehiculo (id_vehiculo, km_recorrido, descripcion) VALUES (?,?,?)";

$q = $pdo->prepare($sql);
$q->execute(array($vehiculo_id,$control_km_mantenimiento,$descripcion));
$Id = $pdo->lastInsertId();

$sql1 = "UPDATE vp_bitacora_vehiculo SET contador_km_mantenimiento=?
        WHERE vehiculo_id=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($reiniciar_contador,$vehiculo_id));


Database::disconnect();
echo $Id;

//echo 'Updated successfully.';
 ?>

