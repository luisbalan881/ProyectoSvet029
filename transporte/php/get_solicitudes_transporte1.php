
<?php

require_once '../../inc/Database.php';


$return_arr = array();

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.solicitud_id as ID, T1.fecha_solicitud AS FECHA
FROM vp_solicitud_transporte T1 ORDER BY T1.status_tiempo_finalizado";

$p = $pdo->prepare($sql);
$p->execute();
$solicitudes = $p->fetchAll();


Database::disconnect();


              foreach ($solicitudes as $s){
								$idx = $s['IDX'];
    $id = $s['ID'];
    $fecha = $s['FECHA'];


    $return_arr[] = array("idx" => $idx,
                    "id" => $id,
                    "fecha" => $fecha);

              }


echo json_encode($return_arr);









?>
