<?php
require_once '../../inc/Database.php';
$emp = $_POST['emp'];
$pii = $_POST['pi'];
$pff = $_POST['pf'];

$pi=date('Y-m-d', strtotime($pii));
$pf=date('Y-m-d', strtotime($pff));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "DELETE FROM vp_user_periodo WHERE user_id=? AND periodo_inicio=? AND periodo_final=?";
$q = $pdo->prepare($sql);
$q->execute(array($emp,$pi,$pf));
Database::disconnect();
echo 'Periodo Eliminado';
?>
