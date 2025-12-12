<?php
require_once '../../inc/Database.php';
$user_nm1 = $_POST['user_nm1'];
$user_nm2 = $_POST['user_nm2'];
$user_ap1 = $_POST['user_ap1'];
$user_ap2 = $_POST['user_ap2'];
$fecha1 = $_POST['fecha_nac'];
$fecha_nac = date('Y-m-d', strtotime($fecha1));

$user_lugar_nac = $_POST['user_lugar_nac'];
$user_genre = $_POST['user_genre'];
$user_civil = $_POST['user_civil'];
$user_cui = $_POST['user_cui'];
$user_movil = $_POST['user_movil'];
$user_profesion = $_POST['user_prof'];
$user_direccion = $_POST['user_direccion'];

$dep_id = $_POST['dep_id'];
$user_puesto = $_POST['user_puesto'];
$user_cargo = $_POST['user_cargo'];
$nacionalidad = $_POST['nacionalidad'];

$user_mod = $_POST['user_id'];
$user_rev = 1;
$user_status = 2;


$user_acuerdo = $_POST['user_acuerdo'];
$fecha2 = $_POST['fecha_acuerdo'];
$fecha_acuerdo = date('Y-m-d', strtotime($fecha2));

$r = $_POST['renglon'];

$grupo = substr($r, -3, 1);
$subgrupo = substr($r, -2, 1);
$renglon = substr($r, -1, 1);

$user_igss = $_POST['user_igss'];
$user_nit = $_POST['user_nit'];
$user_partida = $_POST['user_partida'];
/*$fecha3 = $_POST['fecha_posesion'];
$fecha_posesion = date('Y-m-d', strtotime($fecha3));*/
$fecha4 = $_POST['fecha_inicio'];
$fecha_inicio = date('Y-m-d', strtotime($fecha4));
$foto = '';

$contrato_num=$_POST['contrato_num'];
$contrato_fecha=$_POST['contrato_fecha'];
$c_f = date('Y-m-d', strtotime($contrato_fecha));
$fianza=$_POST['fianza'];
$contrato_ini=$_POST['contrato_ini'];
$c_i = date('Y-m-d', strtotime($contrato_ini));
$contrato_fin=$_POST['contrato_fin'];
$c_f = date('Y-m-d', strtotime($contrato_fin));



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO vp_user (user_nm1,user_nm2,user_ap1,user_ap2,fecha_nac,
  user_lugar_nac,user_genero,user_estado_civil,user_cui,user_movil,user_profesion,user_direccion,
  dep_id,user_puesto,user_nom,user_nacionalidad,user_nit,user_igss,user_mod,user_rev,user_status,user_horario_id)
  values(?,?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?)";
$q = $pdo->prepare($sql);
$q->execute(array($user_nm1,$user_nm2,
$user_ap1,$user_ap2,$fecha_nac,$user_lugar_nac,$user_genre,$user_civil,$user_cui,$user_movil,$user_profesion,
$user_direccion,$dep_id,$user_puesto,$user_cargo,$nacionalidad,$user_nit,$user_igss,$user_mod,$user_rev,$user_status,4));
$Id = $pdo->lastInsertId();

$sql2 = "INSERT INTO vp_user_datos_laborales (user_id,acuerdo_vice,fecha_acuerdo,grupo_id,subgrupo_id,
  renglon_id,user_igss,user_nit,partida,fecha_posesion,inicio_laboral,fotografia) values(?,?,?,?,?,?,?,?,?,?,?,?)";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($Id,$user_acuerdo,$fecha_acuerdo,
$grupo,$subgrupo,$renglon,$user_igss,$user_nit,$user_partida,$fecha_inicio,$fecha_inicio,$foto));

if($r=='029')
{
  $sql3 = "INSERT IGNORE INTO vp_user_011_029_historial (user_id,acuerdo_vice,fecha_acuerdo,grupo_id,subgrupo_id,
    renglon_id,partida,inicio_laboral,user_puesto,user_nom,contrato_num,contrato_fecha,fianza,contrato_ini,contrato_fin) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
  $q3 = $pdo->prepare($sql3);
  $q3->execute(array($Id,$user_acuerdo,$fecha_acuerdo,
  $grupo,$subgrupo,$renglon,$user_partida,$fecha_inicio,$user_puesto,$user_cargo,$contrato_num,$c_f,$fianza,$c_i,$c_f));
}
else{
  $sql4 = "INSERT IGNORE INTO vp_user_011_029_historial (user_id,acuerdo_vice,fecha_acuerdo,grupo_id,subgrupo_id,
    renglon_id,partida,inicio_laboral,user_puesto,user_nom) values(?,?,?,?,?,?,?,?,?,?)";
  $q4 = $pdo->prepare($sql4);
  $q4->execute(array($Id,$user_acuerdo,$fecha_acuerdo,
  $grupo,$subgrupo,$renglon,$user_partida,$fecha_inicio,$user_puesto,$user_cargo));
}
Database::disconnect();

echo $r;

?>
