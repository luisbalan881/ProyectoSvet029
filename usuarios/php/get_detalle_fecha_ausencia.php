<?php
include_once '../../inc/functions.php';
require_once '../../inc/Database.php';
$emp = $_POST['id'];
$fecha = $_POST['fecha'];


$segmentos = explode("/",$fecha);


$f=$segmentos[0];
$t=$segmentos[1];


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT descripcion FROM vp_user_suspenciones WHERE user_vid=? AND ? BETWEEN fecha_ini AND fecha_fin AND tipo_suspencion=?";
$q = $pdo->prepare($sql);
$q->execute(array($emp,$f,$t));
$descripcion = $q->fetch();


$html='<p>'.$descripcion['descripcion'].'</p>';

Database::disconnect();

echo $html;

 ?>
