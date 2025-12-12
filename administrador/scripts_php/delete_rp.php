

<?php
require_once '../../inc/Database.php';
set_time_limit(0);

$rol_id=$_POST['role_id'];
$perm_id=$_POST['perm_id'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = " DELETE FROM vp_role_perm WHERE role_id = :r_id AND perm_id = :p_id";
$q = $pdo->prepare($sql);
$q->execute(array(
  'r_id' => $rol_id,
  'p_id' => $perm_id

));
Database::disconnect();





 ?>
