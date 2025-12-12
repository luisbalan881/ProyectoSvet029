<?php
require_once '../../inc/Database.php';
$user_mod = 158;


//$user_vid = $_POST['codigo'];
$fecha_ini = $_POST['fi'];
$date1 = date('Y-m-d', strtotime($fecha_ini));
$fecha_fin = $_POST['ff'];
$date2 = date('Y-m-d', strtotime($fecha_fin));
$fecha_re = $_POST['fr'];
$date3 = date('Y-m-d', strtotime($fecha_re));
$fecha_no = $_POST['fn'];
$date4 = date('Y-m-d', strtotime($fecha_no));
$resolucion = $_POST['r'];
$tipo_sus = $_POST['t'];
$desc = $_POST['d'];
$user_id=$_POST['id'];



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user_suspenciones SET fecha_ini=?, fecha_fin=?, descripcion=?,
tipo_suspencion=?, realizado_por=?, fecha_regreso=?,fecha_notificacion=?
        WHERE user_id=? and resolucion=?";
$q = $pdo->prepare($sql);
$q->execute(array($date1,$date2,$desc,$tipo_sus,$user_mod,$date3,$date4,$user_id,$resolucion));

$sql1= "SELECT user_vid FROM vp_user_suspenciones WHERE user_id=? AND resolucion=?";
$p1 = $pdo->prepare($sql1);
$p1->execute(array($user_id,$resolucion));
$obtener = $p1->fetch(PDO::FETCH_ASSOC);


$user_vid = $obtener['user_vid'];

$sql2 = "UPDATE vp_user_horario_general SET tipo_dia_laboral = ?
WHERE fecha_laboral BETWEEN ? AND ? and user_vid = ? AND tipo_dia_laboral <> 3 AND tipo_dia_laboral <> 1 ";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($tipo_sus,$date1,$date2,$user_vid));

Database::disconnect();
echo 'Resolución modificada';


?>
