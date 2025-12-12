<?php
require_once '../../inc/Database.php';
$empleado = $_POST['emp'];
$user = $_POST['user'];//usuario del sistema
$estado = 1;
$verificacion = 2;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user SET user_status=?, verificacion=?, user_mod=? WHERE user_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($estado,$verificacion,$user,$empleado));
Database::disconnect();
echo 'ok';
?>
