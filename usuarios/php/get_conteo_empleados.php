<?php
require_once '../../inc/Database.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT user_status FROM vp_user";
$q = $pdo->prepare($sql);
$q->execute();
$emps = $q->fetchAll();
Database::disconnect();

$total_personas = 0;
$personas_inactivas = 0;
$personas_pendientes = 0;

foreach ($emps as $persona):
  $total_personas++;
  if ($persona['user_status'] == 0){ $personas_inactivas++;}
  if ($persona['user_status'] == 2){ $personas_pendientes++;}
endforeach;

$return_arr = array('a'=>$total_personas,'b'=>$personas_inactivas,'c'=>$personas_pendientes);

echo json_encode($return_arr);
?>
