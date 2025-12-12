<?php
require_once '../../inc/Database.php';
$empleado = $_POST['emp'];
$user = $_POST['user'];//usuario del sistema
$estado = $_POST['estado'];
if($estado == 2)
{
  $estado=1;
}
/*else if($estado == 0) {
  $estado=0;
}*/
$verificacion = 1;

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user SET user_status=?, verificacion=?, user_mod=? WHERE user_id=?";
$q = $pdo->prepare($sql);
$q->execute(array($estado,$verificacion,$user,$empleado));
Database::disconnect();
echo 'ok';
?>
