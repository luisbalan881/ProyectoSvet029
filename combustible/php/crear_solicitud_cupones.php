<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
sec_session_start();
date_default_timezone_set('America/Guatemala');
$solicitante=$_SESSION['user_id'];
$year = date('Y');
$mes = date('m');


$date = date('Y-m-d H:i:s');
$correlativo;
$dias= $_POST["dias2"];
$des= $_POST["des"];
$persona = array();
$persona = User::get_empleado_datos_id($solicitante);

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql0 = "SELECT COUNT(*)as conteo FROM vp_solicitud_cupon WHERE year=? AND dep_id=?";
$q0 = $pdo->prepare($sql0);
$q0->execute(array($year,$persona['dep_id']));
$conteo = $q0->fetch(PDO::FETCH_ASSOC);

if($conteo['conteo']==0)
{
  $correlativo = 1;
}
else{
  $sql1 = "SELECT MAX(solicitud_id) as si FROM vp_solicitud_cupon WHERE year=? AND dep_id=?";
  $q1 = $pdo->prepare($sql1);
  $q1->execute(array($year,$persona['dep_id']));
  $si = $q1->fetch(PDO::FETCH_ASSOC);
  $correlativo = $si['si'] +1;
}

 if (isset($_POST["des"])){
$des= $_POST["des"];
$dias= $_POST["dias2"];
$interno= $_POST["interno"];
$rendimiento= $_POST["rendimiento"];
$p_galon= $_POST["p_galon"];
$res_calculo= $_POST["res_calculo"];





$sql2 = "INSERT INTO vp_solicitud_cupon (year,mes,solicitud_id,solicitante_id,dep_id, fecha_solicitud,dis,km_interno,dias,rendimiento,p_galon,res_calculo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($year,$mes,$correlativo,$solicitante,$persona['dep_id'],$date,$des,$interno,$dias,$rendimiento,$p_galon,$res_calculo));


$sql3 = "SELECT MAX(year) as ye, MAX(mes) as me, MAX(solicitud_id) as si FROM vp_solicitud_cupon WHERE year=? AND dep_id=?";
$q3 = $pdo->prepare($sql3);
$q3->execute(array($year,$persona['dep_id']));
$datos_s = $q3->fetch(PDO::FETCH_ASSOC);

Database::disconnect();
 }
$return_arr = array(
                    'year'=> $datos_s['ye'],
                    'mes'=> $datos_s['me'],
                    'solicitud_id'=>$datos_s['si']
                  );

echo json_encode($return_arr);

 ?>











