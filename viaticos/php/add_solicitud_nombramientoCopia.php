<?php
require_once '../../inc/functions.php';
require_once '../../inc/User.php';

$fecha=$_POST['fecha'];// esta atrapando fecha sin formato soli_fecha
$date1 = date('Y-m-d', strtotime($fecha));   // fecha inicio
$fecha2=$_POST['fecha2'];// esta atrapando fecha sin formato soli_fecha
$date2 = date('Y-m-d', strtotime($fecha2));   // fecha fin
$objetivos=$_POST['objetivo'];  /// ya no usar
//$duracion=$_POST['duracion'];  // duracion
$especificacion=$_POST['especificacion'];  // tiempo en 
$departamento=$_POST['dep'];  // cod nombramiento
$lugares=$_POST['lugar'];  // lugares
$year1=$_POST['year'];  // A;o del sistema
$status="-1";

$id=$_POST['id'];   // persona peticion 
$persona = User::get_empleado_datos_id($id);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




$sql1= "SELECT dep_encargado, dep from vp_deptos WHERE dep_id=?";
$p1 = $pdo->prepare($sql1);
$p1->execute(array($persona['dep_id']));
$per_rol = $p1->fetch(PDO::FETCH_ASSOC);
$enc = $per_rol['dep_encargado']; //perosona autoriza
$dep1 = $per_rol['dep'];



$sql2= "SELECT MAX(contador)+1 AS con from vs_nombramiento where dep_f1=?";
$p2 = $pdo->prepare($sql2);
$p2->execute(array($persona['dep_id']));
$per_rol2 = $p2->fetch(PDO::FETCH_ASSOC);
$con1 = $per_rol2['con']; //perosona autoriza

$codigo5=$dep1.$con1."-".$year1;

$sql = "INSERT INTO vs_nombramiento (cod_nombramiento,id_funcionario,id_funcionario2,fecha_inicio,fecha_fin,lugar,objetivo,contador,dep_f1,status) VALUES (?,?,?,?,?,?,?,?,?,?)";

$q = $pdo->prepare($sql);
$q->execute(array($codigo5,$id,$enc,$date1,$date2,$lugares,$objetivos,$con1,$departamento,$status));
$Id = $pdo->lastInsertId();
Database::disconnect();

echo $Id;
 ?>
