<?php

require_once '../../inc/functions.php';
require_once '../../inc/User.php';


$fecha=$_POST['fecha'];
$date1 = date('Y-m-d', strtotime($fecha));
$salida=$_POST['salida'];
$duracion=$_POST['duracion'];
$especificacion=$_POST['especificacion'];
$cantidad=$_POST['cantidad'];
$desc=$_POST['desc'];

$id=$_POST['id'];
$persona = User::get_empleado_datos_id($id);
//$dep=$_POST['dep'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




$sql1= "SELECT dep_encargado from vp_deptos WHERE dep_id=?";
$p1 = $pdo->prepare($sql1);
$p1->execute(array($persona['dep_id']));
$per_rol = $p1->fetch(PDO::FETCH_ASSOC);


$enc = $per_rol['dep_encargado'];




$sql = "INSERT INTO vp_solicitud_transporte (fecha_solicitud, hora_salida, duracion, tipo_duracion,
  cantidad_personas, solicitante_id, autorizacion_id,soli_desc  ) VALUES (?,?,?,?,?,?,?,?)";
$q = $pdo->prepare($sql);
$q->execute(array($date1,$salida,$duracion,$especificacion,$cantidad,$id,$enc,$desc));
$Id = $pdo->lastInsertId();
Database::disconnect();

echo $Id;
 ?>
