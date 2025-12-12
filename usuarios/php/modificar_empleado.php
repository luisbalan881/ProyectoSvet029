<?php
require_once '../../inc/Database.php';
$empleado = $_POST['emp'];
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
//$user_status = $_POST['user_status'];


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
$fecha3 = $_POST['fecha_posesion'];
$fecha_posesion = date('Y-m-d', strtotime($fecha3));
$fecha4 = $_POST['fecha_inicio'];
$fecha_inicio = date('Y-m-d', strtotime($fecha4));
//$foto = 'user.png';



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user SET user_nm1=?,user_nm2=?,user_ap1=?,user_ap2=?,fecha_nac=?,
  user_lugar_nac=?,user_genero=?,user_estado_civil=?,user_cui=?,user_movil=?,user_profesion=?,user_direccion=?,
  dep_id=?,user_puesto=?,user_nom=?,user_nacionalidad=?,user_nit=?,user_igss=?,user_mod=?,user_rev=?,user_horario_id=?
WHERE user_id=?";

$q = $pdo->prepare($sql);
$q->execute(array($user_nm1,$user_nm2,
$user_ap1,$user_ap2,$fecha_nac,$user_lugar_nac,$user_genre,$user_civil,$user_cui,$user_movil,$user_profesion,
$user_direccion,$dep_id,$user_puesto,$user_cargo,$nacionalidad,$user_nit,$user_igss,$user_mod,$user_rev,4,$empleado));
//$Id = $pdo->lastInsertId();

$sql2 = "UPDATE vp_user_datos_laborales SET acuerdo_vice=?,fecha_acuerdo=?,grupo_id=?,subgrupo_id=?,
  renglon_id=?,user_igss=?,user_nit=?,partida=?,fecha_posesion=?,inicio_laboral=?WHERE user_id=?";
$q2 = $pdo->prepare($sql2);
$q2->execute(array($user_acuerdo,$fecha_acuerdo,
$grupo,$subgrupo,$renglon,$user_igss,$user_nit,$user_partida,$fecha_posesion,$fecha_inicio,$empleado));

$sql3 = "INSERT IGNORE INTO vp_user_partida_presupuestaria (user_id,acuerdo_vice,fecha_acuerdo,grupo_id,subgrupo_id,
  renglon_id,partida,fecha_posesion,inicio_laboral) values(?,?,?,?,?,?,?,?,?)";
$q3 = $pdo->prepare($sql3);
$q3->execute(array($empleado,$user_acuerdo,$fecha_acuerdo,
$grupo,$subgrupo,$renglon,$user_partida,$fecha_posesion,$fecha_inicio));

Database::disconnect();

?>
