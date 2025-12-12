

<?php
require_once '../../inc/Database.php';
set_time_limit(0);

$sb=$_POST['sb'];
$us=$_POST['us'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = " DELETE FROM vp_sub_perm_user WHERE sub_perm_id = ? AND user_id = ?";
$q = $pdo->prepare($sql);
$q->execute(array($sb,$us));
Database::disconnect();





 ?>
