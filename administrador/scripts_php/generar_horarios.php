<?php
require_once '../../inc/Database.php';
$f = $_POST['f'];
$u = $_POST['u'];

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "  INSERT IGNORE INTO vp_user_horario_general( user_vid, fecha_laboral, tipo_dia_laboral, horas_requeridas )
SELECT t1.user_vid, :f, :u, 8
FROM vp_user t1
INNER JOIN vp_user_datos_laborales t2 ON t1.user_id=t2.user_id
WHERE t1.user_status =1
AND t1.user_vid >0
AND CONCAT(t2.grupo_id,t2.subgrupo_id,t2.renglon_id)='011' OR CONCAT(t2.grupo_id,t2.subgrupo_id,t2.renglon_id)='022'
AND t1.user_horario_especial_id =0
AND t1.user_marcaje<>5



";
$q = $pdo->prepare($sql);
$q->execute(array(
  'f' => $f,
  'u' => $u
));

$sql1 = "  INSERT IGNORE INTO vp_calendario_general VALUES (?,?,? )";
$q1 = $pdo->prepare($sql1);
$q1->execute(array($f,$u,8));
Database::disconnect();



 ?>
