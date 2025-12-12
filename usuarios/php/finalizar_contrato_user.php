<?php
require_once '../../inc/Database.php';
$user_id = $_POST['emp'];
$corr = $_POST['correlativo'];
$ff1='';

$f1= $_POST['resolucion_fecha'];
if($f1!=''){

  $ff1 = date('Y-m-d', strtotime($f1));
}
$resolucion=$_POST['resolucion_no'];
$tipo=$_POST['tipo_cancelacion_c'];
$f2=$_POST['fecha_fin'];
$ff2 = date('Y-m-d', strtotime($f2));

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "UPDATE vp_user_011_029_historial SET

              resolucion_no=?, resolucion_fecha=?, tipo_cancelacion_c=?,fecha_destitucion=?
                WHERE user_id = ? AND correlativo=?";
$q = $pdo->prepare($sql);
$q->execute(array($resolucion,$ff1,$tipo,$ff2,$user_id,$corr));
Database::disconnect();
echo $fecha_inicio;
?>
