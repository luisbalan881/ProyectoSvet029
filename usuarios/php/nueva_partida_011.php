<?php
require_once '../../inc/functions.php';
$user_id = $_POST['emp'];
$persona = User::get_empleado_datos_id($user_id);

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
$sql0 = "SELECT MAX(correlativo) AS maximo FROM vp_user_011_029_historial
                WHERE user_id = ? ";
$q0 = $pdo->prepare($sql0);
$q0->execute(array($user_id));
$corr = $q0->fetch();
$correlativo = $corr['maximo']+1;

$sql ="INSERT INTO vp_user_011_029_historial(
  salario_base,
 complemento_personal,
bono_antiguedad,
bono_profesional,
bono_vicepresidencial,
bono_66_2000,
gastos_de_representacion,
viaticos,
 acuerdo_vice,
 fecha_acuerdo,
 partida,
 inicio_laboral,
 user_puesto,
 user_nom,
 user_id,
 correlativo,
 grupo_id,
 subgrupo_id,
 renglon_id)VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";


$q = $pdo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$f,$g,$h,$i,$user_acuerdo,$fecha_acuerdo,$user_partida,$fecha_inicio,$user_puesto,$user_cargo,$user_id,$correlativo,$persona['grupo_id'],$persona['subgrupo_id'],$persona['renglon_id']));
Database::disconnect();
echo $fecha_inicio;
?>
