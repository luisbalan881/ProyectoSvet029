<?php

require_once '../../inc/Database.php';

$id=$_POST['id'];
$marca=$_POST['marca'];
$linea=$_POST['linea'];
$modelo=$_POST['modelo'];
$combustible=$_POST['combustible'];
$placa=$_POST['placa'];
$cilindros=$_POST['cilindros'];
$cilindraje=$_POST['cilindraje'];
$chasis=$_POST['chasis'];
$motor=$_POST['motor'];
$color=$_POST['color'];
$capacidad=$_POST['capacidad'];
$conductor=$_POST['conductor'];
$dep_id=$_POST['departamento'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "UPDATE vp_vehiculo SET nombre=?,linea=?,modelo=?,combustible_id=?,placa=?,cilindraje=?,c_c=?,chasis_no=?,motor_no=?,color=?,capacidad=?,user_id=?,dep_id=? WHERE vehiculo_id=?";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($marca,$linea,$modelo,$combustible,$placa,$cilindros,$cilindraje,$chasis,$motor,$color,$capacidad,$conductor,$dep_id,$id));
Database::disconnect();

echo 'Vehiculo Creado';
 ?>
