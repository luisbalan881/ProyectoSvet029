<?php
require_once '../../inc/functions.php';
require_once '../../inc/User.php';

$id=$_POST['codigo'];
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

//$id=$_POST['id'];   // persona peticion 
//$persona = User::get_empleado_datos_id($id);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);



$sql1 = "UPDATE vs_nombramiento SET  lugar =?, objetivo=?,  fecha_inicio=?, fecha_fin=? WHERE id_nombramiento=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($lugares,$objetivos,$date1,$date2,$id));
Database::disconnect();



echo $Id;
 ?>
