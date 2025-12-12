<?php
require_once '../../inc/Database.php';
require_once 'funciones.php';
$pdo = Database::connect();
$year=$_POST['year'];
$mes=$_POST['mes'];
$solicitud=$_POST['solicitud_id'];
$dep_id=$_POST['dep_id'];
$comision=$_POST['comision_id'];
$status=1;

date_default_timezone_set('America/Guatemala');
$date = date('Y-m-d H:i:s');




$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_solicitud_cupon SET comision_status=?
        WHERE year=? AND mes=? AND solicitud_id=? AND dep_id=?";
$p = $pdo->prepare($sql);
$p->execute(array(1,$year,$mes,$solicitud,$dep_id));

$sql1 = "INSERT INTO vp_solicitud_cupon_comision (year,mes,solicitud_c_id,dep_id,comision_id,estado_comision)
         VALUES (?,?,?,?,?,?)";
$p1 = $pdo->prepare($sql1);
$p1->execute(array($year,$mes,$solicitud,$dep_id,$comision,1));


$sql2 = "UPDATE vp_solicitud_transporte SET status_tiempo_finalizado = ?, status_solicitud = ? where solicitud_id = ?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($status,$status,$comision));


$carros = get_carros_por_solicitud($year,$mes,$solicitud,$dep_id);

foreach ($carros as $c) {
  $sql2 = "INSERT INTO vp_solicitud_transporte_vehiculo (solicitud_id, vehiculo_id, conductor_id,tipo_de_transporte) VALUES (?,?,?,?)";
  $q2 = $pdo->prepare($sql2);
  $q2->execute(array($comision,$c['vehiculo_id'],$c['user_id'],1));
}


Database::disconnect();
?>
