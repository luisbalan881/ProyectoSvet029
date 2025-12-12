<?php
require_once '../../inc/Database.php';
$pdo = Database::connect();
$start=$_POST['cupon_i'];
$end=$_POST['cupon_f'];
$f1=$_POST['fecha_emi'];
$f2=$_POST['fecha_ven'];
$monto=$_POST['monto'];
$creador=$_POST['creador'];

$date1 = date('Y-m-d', strtotime($f1));
$date2 = date('Y-m-d', strtotime($f2));


$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO vp_cupon (cupon_id, cupon_pedido_id,fecha_emision,fecha_caducidad,monto,cupon_status,user_id)
        VALUES (?,?,?,?,?,?,?)";
$p = $pdo->prepare($sql);
for($number = $start;$number <= $end; $number++){
    $p->execute(array($number,1,$date1,$date2,$monto,0,$creador));
}
Database::disconnect();
?>
