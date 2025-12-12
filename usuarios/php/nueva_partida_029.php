<?php
require_once '../../inc/functions.php';


$user_id = $_POST['emp'];
$persona = User::get_empleado_datos_id($user_id);


$a = $_POST['salario_base'];

$user_puesto = $_POST['user_puesto'];
$user_cargo = $_POST['user_cargo'];
$user_acuerdo = $_POST['user_acuerdo'];
$fecha2 = $_POST['fecha_acuerdo'];
$fecha_acuerdo = date('Y-m-d', strtotime($fecha2));
$user_partida = $_POST['user_partida'];
$fecha4 = $_POST['fecha_inicio'];
$fecha_inicio = date('Y-m-d', strtotime($fecha4));

$contrato_num=$_POST['contrato_num'];
$fecha7=$_POST['contrato_fecha'];
$contrato_fecha = date('Y-m-d', strtotime($fecha7));
$fianza=$_POST['fianza'];
$fecha5=$_POST['contrato_ini'];
$contrato_ini = date('Y-m-d', strtotime($fecha5));
$fecha6=$_POST['contrato_fin'];
$contrato_fin = date('Y-m-d', strtotime($fecha6));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql0 = "SELECT MAX(correlativo) AS maximo FROM vp_user_011_029_historial
                WHERE user_id = ? ";
$q0 = $pdo->prepare($sql0);
$q0->execute(array($user_id));
$corr = $q0->fetch();
$correlativo = $corr['maximo']+1;

$sql ="INSERT INTO vp_user_011_029_historial(salario_base,
 acuerdo_vice,
 fecha_acuerdo,
 partida,
 inicio_laboral,
 user_puesto,
 user_nom,
 contrato_num,
 contrato_fecha,
 fianza,
 contrato_ini,
 contrato_fin,
 user_id,
 correlativo,
 grupo_id,
 subgrupo_id,
 renglon_id)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


$q = $pdo->prepare($sql);
$q->execute(array($a,$user_acuerdo,
                  $fecha_acuerdo,$user_partida,$fecha_inicio,
                  $user_puesto,$user_cargo,$contrato_num,$contrato_fecha,
                  $fianza,$contrato_ini,$contrato_fin,$user_id,
                  $correlativo,$persona['grupo_id'],$persona['subgrupo_id'],$persona['renglon_id']));
Database::disconnect();
echo $fecha_inicio;
?>
