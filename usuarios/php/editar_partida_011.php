<?php
require_once '../../inc/Database.php';
$user_id = $_POST['emp'];
$corr = $_POST['correlativo'];
$a = $_POST['salario_base'];
$b = $_POST['complemento_personal'];
$c = $_POST['bono_antiguedad'];
$d = $_POST['bono_profesional'];
$f = $_POST['bono_vicepresidencial'];
$g = $_POST['bono_66_2000'];
$h = $_POST['gastos_de_representacion'];
$i = $_POST['viaticos'];

$user_puesto = $_POST['user_puesto'];
$user_cargo = $_POST['user_cargo'];
$user_acuerdo = $_POST['user_acuerdo'];
$fecha2 = $_POST['fecha_acuerdo'];
$fecha_acuerdo = date('Y-m-d', strtotime($fecha2));
$user_partida = $_POST['user_partida'];
$fecha4 = $_POST['fecha_inicio'];
$fecha_inicio = date('Y-m-d', strtotime($fecha4));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user_011_029_historial SET

              salario_base=?,complemento_personal=?,bono_antiguedad=?,bono_profesional=?,
               bono_vicepresidencial=?, bono_66_2000 =?,
               gastos_de_representacion=?,viaticos=?,
               acuerdo_vice=?,fecha_acuerdo=?,
               partida=?,
               inicio_laboral=?,
               user_puesto=?,user_nom=?
                WHERE user_id = ? AND correlativo=?";
$q = $pdo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$f,$g,$h,$i,$user_acuerdo,$fecha_acuerdo,$user_partida,$fecha_inicio,$user_puesto,$user_cargo,$user_id,$corr));
Database::disconnect();
echo $fecha_inicio;
?>
