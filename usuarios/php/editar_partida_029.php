<?php
require_once '../../inc/Database.php';
$user_id = $_POST['emp'];
$corr = $_POST['correlativo'];
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
$sql = "UPDATE vp_user_011_029_historial SET

              salario_base=?,
               acuerdo_vice=?,fecha_acuerdo=?,
               partida=?,
               inicio_laboral=?,
               user_puesto=?,user_nom=?,
               contrato_num=?,contrato_fecha=?,
               fianza=?,contrato_ini=?,contrato_fin=?
                WHERE user_id = ? AND correlativo=?";
$q = $pdo->prepare($sql);
$q->execute(array($a,$user_acuerdo,$fecha_acuerdo,$user_partida,$fecha_inicio,$user_puesto,$user_cargo,$contrato_num,$contrato_fecha,$fianza,$contrato_ini,$contrato_fin,$user_id,$corr));
Database::disconnect();
echo $user_puesto. ' '. $user_cargo;
?>
