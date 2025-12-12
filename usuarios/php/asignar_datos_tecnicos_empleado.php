<?php
require_once '../../inc/Database.php';
$empleado = $_POST['emp'];
$user_vid = $_POST['user_vid'];
$ext_id = $_POST['ext_id'];
$user_mail ="";
$role_id = $_POST['role_id'];
$user_mod = $_POST['creador'];


if($_POST['user_mail']!= "")
{
$user_mail = $_POST['user_mail']."@svet.gob.gt";
}




$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user SET user_vid=?, ext_id=?, user_mail=?, role_id=?, user_mod=?
WHERE user_id=?";

$q = $pdo->prepare($sql);
$q->execute(array($user_vid,$ext_id,$user_mail,$role_id,$user_mod,$empleado));
//$Id = $pdo->lastInsertId();



Database::disconnect();

?>
