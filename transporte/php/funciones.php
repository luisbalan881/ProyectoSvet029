<?php
//require_once '../../inc/Database.php';

function solicitudes_list()
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.solicitud_id as ID, T1.fecha_solicitud AS FECHA,
T1.hora_salida AS SALIDA, T1.duracion AS DURACION,T1.tipo_duracion AS TIPO_D,T1.cantidad_personas AS CANT,
CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1, ' ', T2.user_ap2) as NOMBRE, T2.ext_id AS EXT,
T1.autorizacion_id AS ID_JEFE,T1.status_solicitud AS STATUS_SOL, T1.entregado_por_id AS ENTREGADO_POR,
T3.destino AS DESTINO, T1.motivo AS MOTIVO, T1.status_tiempo_finalizado AS FINALIZADO, T1.fecha_creacion as Creacion
FROM vp_solicitud_transporte T1 INNER JOIN vp_user T2 on T1.solicitante_id=T2.user_id 
INNER JOIN vp_solicitud_transporte_destino_motivo T3 on T1.solicitud_id = T3.solicitud_id
ORDER BY T1.solicitud_id DESC";

$p = $pdo->prepare($sql);
$p->execute();
$solicitudes = $p->fetchAll();
Database::disconnect();
return $solicitudes;
}


function solicitudes_list_por_usuario($id)
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.solicitud_id as ID, T1.fecha_solicitud AS FECHA,
T1.hora_salida AS SALIDA, T1.duracion AS DURACION,T1.tipo_duracion AS TIPO_D,T1.cantidad_personas AS CANT,
CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1, ' ', T2.user_ap2) as NOMBRE, T2.ext_id AS EXT,
T1.autorizacion_id AS ID_JEFE,T1.status_solicitud AS STATUS_SOL, T1.entregado_por_id AS ENTREGADO_POR,
T1.destino AS DESTINO, T1.motivo AS MOTIVO, T1.status_tiempo_finalizado AS FINALIZADO
FROM vp_solicitud_transporte T1 INNER JOIN
vp_user T2 on T1.solicitante_id=T2.user_id
WHERE T1.solicitante_id=?ORDER BY T1.solicitud_id DESC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$solicitudes = $p->fetchAll();
Database::disconnect();
return $solicitudes;
}

function get_pilotos(){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.conductor_id,T1.user_id,T1.licencia_num,T1.licencia_cad,T1.status,T1.rev,
        CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1,' ', T2.user_ap2)AS NOMBRE,
        T3.dep_nm
        FROM vp_conductor AS T1
        INNER JOIN vp_user AS T2 ON T1.user_id=T2.user_id
        INNER JOIN vp_deptos AS T3 ON T1.dep_id=T3.dep_id
        ORDER BY T1.conductor_id ASC";

$p = $pdo->prepare($sql);
$p->execute();
$drivers = $p->fetchAll();
Database::disconnect();

return $drivers;
}

function get_carros_por_solicitud_transporte($solicitud){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,T2.estado_entregado,T2.fecha_asignado,
          T2.tipo_de_transporte,T1.tipo,
  CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS CONDUCTOR
  FROM vp_vehiculo AS T1
  INNER JOIN vp_solicitud_transporte_vehiculo AS T2 ON T2.vehiculo_id=T1.vehiculo_id
  INNER JOIN vp_user AS T3 ON T3.user_id=T2.conductor_id
  WHERE T2.solicitud_id=?ORDER BY T2.fecha_asignado ASC ,T1.placa ASC, T1.vehiculo_id ASC";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud));
  $vehiculos = $p->fetchAll();
  Database::disconnect();

  return $vehiculos;
}

function get_destinos_motivos_por_solicitud_transporte($solicitud)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT correlativo,destino, motivo,status FROM vp_solicitud_transporte_destino_motivo
          WHERE solicitud_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($solicitud));
  $d_m = $p->fetchAll();
  Database::disconnect();

  return $d_m;
}

function get_carro_by_id($id){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT vehiculo_id,nombre,linea,placa,modelo,tipo,
cilindraje,combustible_id,color,status,user_id, vice_id, capacidad, status_uso, comision_id,c_c,chasis_no,motor_no,user_id,dep_id
FROM vp_vehiculo WHERE vice_id=1 AND vehiculo_id=? ORDER BY placa ASC, vehiculo_id ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$vehiculo = $p->fetch();
Database::disconnect();

return $vehiculo;
}

function get_piloto_by_id($id){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.conductor_id,T1.user_id,T1.licencia_num,T1.licencia_cad,T1.status,T1.rev,T1.dep_id,
        CONCAT(T2.user_nm1, ' ', T2.user_nm2, ' ', T2.user_ap1,' ', T2.user_ap2)AS NOMBRE,
        T3.dep_nm
        FROM vp_conductor AS T1
        INNER JOIN vp_user AS T2 ON T1.user_id=T2.user_id
        INNER JOIN vp_deptos AS T3 ON T1.dep_id=T3.dep_id
        WHERE T1.user_id=?
        ORDER BY T1.conductor_id ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$driver = $p->fetch();
Database::disconnect();

return $driver;
}


$combustible = array(1 => 'Gasolina', 2 => 'Diesel');
$tipo_vehiculo = array(1 => 'Camioneta', 2 => 'Vehículo',3=>'Pick up',4=>'Microbus',5=>'Motocicleta');

?>
