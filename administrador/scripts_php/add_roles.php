

<?php
require_once '../../inc/Database.php';

$role=$_POST['role'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = " INSERT IGNORE INTO vp_roles(role_nm) VALUES(?)";
$q = $pdo->prepare($sql);
$q->execute(array($role));
Database::disconnect();





 ?>
