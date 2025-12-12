

<?php
require_once '../../inc/Database.php';

$perm=$_POST['perm'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = " INSERT IGNORE INTO vp_permisos(perm_desc) VALUES(?)";
$q = $pdo->prepare($sql);
$q->execute(array($perm));
Database::disconnect();





 ?>
