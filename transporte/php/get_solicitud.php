<?php



function get_solicitud_by_id($solicitud){



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.solicitud_id AS ID, LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.fecha_solicitud AS FECHA,
T1.hora_salida AS SALIDA, T1.duracion AS DURACION,T1.tipo_duracion AS TIPO_D,T1.cantidad_personas AS CANT,
CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1, ' ', T2.user_ap2) as NOMBRE,
TJ.JEFE AS ID_JEFE,T1.status_solicitud AS STATUS_SOL, T1.entregado_por_id AS ENTREGADO_POR,
T1.destino AS DESTINO, T1.motivo AS MOTIVO, T1.status_tiempo_finalizado AS FINALIZADO,
T4.DEP,T1.fecha_creacion AS FECHA_C,T1.soli_desc AS DESCRIPCION
FROM vp_solicitud_transporte T1 INNER JOIN
vp_user T2 on T1.solicitante_id=T2.user_id
LEFT JOIN (SELECT GROUP_CONCAT(T3.dep_nm SEPARATOR ',      ') AS DEP,
           T1.solicitud_id
FROM vp_deptos AS T3
           LEFT JOIN vp_solicitud_transporte_departamento AS T5
           ON T5.dep_id = T3.dep_id
           LEFT JOIN vp_solicitud_transporte AS T1

ON T1.solicitud_id = T5.solicitud_id
          WHERE T5.solicitud_id= ?) AS T4 ON T1.solicitud_id =T4.solicitud_id


          LEFT JOIN (SELECT CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1, ' ', T2.user_ap2) AS JEFE,
           T1.solicitud_id
FROM vp_user AS T2
           LEFT JOIN vp_solicitud_transporte AS T1
           ON T1.autorizacion_id = T2.user_id

          WHERE T1.solicitud_id= ?) AS TJ ON T1.solicitud_id =TJ.solicitud_id


 WHERE T1.solicitud_id = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud,$solicitud,$solicitud));
$solicitud = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud;

}


function get_vehiculo_by_id($solicitud){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT vehiculo_id, conductor_id FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  return $solicitud;
}

function get_nombre_vehiculo($vehiculo_id)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT CONCAT(nombre, ' - ', linea, ' - ', placa) as VEHICULO FROM vp_vehiculo WHERE vehiculo_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($vehiculo_id));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  return $solicitud;
}

function get_nombre_conductor($user_id)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT CONCAT(T1.user_nm1, ' ', T1.user_nm1, ' ', T1.user_ap1, ' ',T1.user_ap2) as NOMBRE
          FROM vp_user AS T1
          INNER JOIN vp_conductor AS T2 ON T2.user_id=T1.user_id
          WHERE T2.user_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($user_id));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  return $solicitud;
}

function get_conductor_by_id($solicitud){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT conductor_id FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  return $solicitud;
}

function get_vehiculos($dep_id)
{
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT vehiculo_id,nombre,linea,placa,modelo,
cilindraje,combustible_id,status,vice_id, capacidad, status_uso, comision_id,tipo
FROM vp_vehiculo WHERE vice_id=1 AND dep_id<>? ORDER BY placa ASC, vehiculo_id ASC";

$p = $pdo->prepare($sql);
$p->execute(array(1));
$vehiculos = $p->fetchAll();
Database::disconnect();
return $vehiculos;
}

function verificar_vehiculo($solicitud){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT count(*) as conteo FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=? AND estado_entregado=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud,1));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  $conteo = $solicitud['conteo'];
  return $conteo;
}

function verificar_vehiculo_asignado($solicitud){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT count(*) as conteo FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  $conteo = $solicitud['conteo'];
  return $conteo;
}

function verificar_vehiculo_entregado($solicitud,$vehiculo,$fecha){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT estado_entregado FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=? AND vehiculo_id=? AND fecha_asignado=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud,$vehiculo,$fecha));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  return $solicitud;
}

function verificar_vehiculo_devueltos($solicitud){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT count(*) as conteo FROM vp_solicitud_transporte_vehiculo WHERE solicitud_id=? AND estado_entregado=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud,2));
  $solicitud = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  $conteo = $solicitud['conteo'];
  return $conteo;
}

function get_comision_by_solicitud_id($id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.solicitud_id, T1.destino, T1.motivo,T1.status
          FROM vp_solicitud_transporte_destino_motivo AS T1
          WHERE T1.solicitud_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($id));
  $comision = $p->fetchAll();
  Database::disconnect();

  return $comision;
}





 ?>
