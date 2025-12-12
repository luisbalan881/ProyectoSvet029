

<?php
require_once '../../inc/Database.php';
set_time_limit(0);

$sb=$_POST['sb'];
$us=$_POST['us'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = " INSERT IGNORE INTO vp_permiso_por_permiso_user(permiso_por_permiso_id, user_id) VALUES(?,?)";
$q = $pdo->prepare($sql);
$q->execute(array($sb,$us));
Database::disconnect();




 ?>
