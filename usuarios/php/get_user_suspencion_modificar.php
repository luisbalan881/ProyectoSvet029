<?php
require_once '../../inc/Database.php';
$emp=$_POST['emp'];
$resolucion=$_POST['resolucion'];
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT user_id,resolucion,descripcion,fecha_ini,fecha_fin,fecha_regreso,fecha_notificacion,tipo_suspencion
        FROM vp_user_suspenciones WHERE user_id=? AND resolucion=?";
$q = $pdo->prepare($sql);
$q->execute(array($emp,$resolucion));
$re = $q->fetch();
Database::disconnect();

$fi = date('d-m-Y', strtotime($re['fecha_ini']));
$ff = date('d-m-Y', strtotime($re['fecha_fin']));
$fr='';
if($re['fecha_regreso']!='0000-00-00')
{
  $fr = date('d-m-Y', strtotime($re['fecha_regreso']));
}

$fn='';
if($re['fecha_notificacion']!='0000-00-00')
{
  $fn = date('d-m-Y', strtotime($re['fecha_notificacion']));
}


$return_arr = array(
  'empleado'=>$re['user_id'],
  'resolucion'=>$re['resolucion'],
  'tipo_suspencion'=>$re['tipo_suspencion'],
  'descripcion'=>$re['descripcion'],
  'fecha_ini'=>$fi,
  'fecha_fin'=>$ff,
  'fecha_regreso'=>$fr,
  'fecha_notificacion'=>$fn
);

echo json_encode($return_arr);
?>
