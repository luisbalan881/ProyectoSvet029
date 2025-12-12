<?php

require_once '../../inc/Database.php';

//$status=3;
$id=$_POST['codigo'];
$t1=$_POST['total'];
$t2=$_POST['total2'];
$t3=$_POST['total3'];
$t4=$_POST['total4'];
$objetivos=$_POST['objetivo'];
$actividades=$_POST['actividades'];
$logros=$_POST['logros'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql1 = "UPDATE vs_nombramiento SET  tdesayunos =?, talmuerzos=?, tcenas=?, thospedaje=?, actividades=? , logros=?,  objetivod=?
        WHERE id_nombramiento=?";  
$q1 = $pdo->prepare($sql1);
$q1->execute(array($t1,$t2,$t3,$t4,$actividades,$logros,$objetivos,$id));
Database::disconnect();

echo 'Updated successfully.';
 ?>