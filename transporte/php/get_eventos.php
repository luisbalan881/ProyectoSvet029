<?php

require_once '../../inc/Database.php';




$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql1 = "SELECT T1.solicitud_id, T1.fecha_solicitud, year(T1.fecha_solicitud) as year,
        month(T1.fecha_solicitud) as mes, day(T1.fecha_solicitud) as dia, T2.motivo,
         T2.destino,T2.status
         FROM vp_solicitud_transporte AS T1 INNER JOIN vp_solicitud_transporte_destino_motivo AS T2 ON T2.solicitud_id=T1.solicitud_id";
$q1 = $pdo->prepare($sql1);
$q1->execute(array());
$eventos = $q1->fetchAll();
Database::disconnect();

foreach($eventos as $e){
  $sub_array = array(
                      'solicitud'=>$e['solicitud_id'],
                      'fecha'=>$e['fecha_solicitud'],
                      'year'=>$e['year'],
                      'mes'=>$e['mes'],
                      'dia'=>$e['dia'],
                      'destino'=>$e['destino'],
                      'motivo'=>$e['motivo']
                    );
  $data[]=$sub_array;
}

$output = array(
  "data"    => $data
);

echo json_encode($output); ?>
