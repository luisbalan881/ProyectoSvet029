<?php

require_once '../../inc/Database.php';

//$status=3;
$id=$_POST['codigo'];

$justificacions=$_POST['justificacion'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "UPDATE vs_nombramiento SET  justificacion_ampliacion=?
        WHERE id_nombramiento=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($justificacions,$id));
Database::disconnect();

echo 'Updated successfully.';
 ?>