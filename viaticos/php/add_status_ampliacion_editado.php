<?php

require_once '../../inc/Database.php';

$status=7;
//$f="";
$id=$_POST['codigo'];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "UPDATE vs_nombramiento SET status=?
        WHERE id_nombramiento=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($status,$id));
Database::disconnect();

echo 'Updated successfully.';
 ?>

