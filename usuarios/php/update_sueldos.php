<?php
require_once '../../inc/Database.php';
$user_id = $_POST['id'];
$a = $_POST['salario_base'];
$b = $_POST['complemento_personal'];
$c = $_POST['bono_antiguedad'];
$d = $_POST['bono_profesional'];
$f = $_POST['bono_vicepresidencial'];
$g = $_POST['bono_66_2000'];
$h = $_POST['gastos_de_representacion'];
$i = $_POST['viaticos'];
$j = $_POST['igss'];
$k = $_POST['montepio'];
$l = $_POST['decreto_81_70'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user_datos_laborales SET salario_base=?,complemento_personal=?,bono_antiguedad=?,bono_profesional=?,
               bono_vicepresidencial=?, bono_66_2000 =?,
               gastos_de_representacion=?,viaticos=?,igss=?,montepio=?,decreto_81_70=? WHERE user_id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($a,$b,$c,$d,$f,$g,$h,$i,$j,$k,$l,$user_id));
Database::disconnect();
echo 'ok';
?>
