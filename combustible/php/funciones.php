<?php

function cupones_list($inicio,$fin)
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT cupon_id, fecha_emision, fecha_caducidad, monto, cupon_status FROM vp_cupon
WHERE cupon_id BETWEEN ? AND ?";

$p = $pdo->prepare($sql);
$p->execute(array($inicio,$fin));
$cupones = $p->fetchAll();
Database::disconnect();
return $cupones;
}

function get_nombre_dia($fecha){
$fechats = strtotime($fecha); //pasamos a timestamp

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch (date('w', $fechats)){
case 0: return "Domingo"; break;
case 1: return "Lunes"; break;
case 2: return "Martes"; break;
case 3: return "Miercoles"; break;
case 4: return "Jueves"; break;
case 5: return "Viernes"; break;
case 6: return "Sabado"; break;
}
}

function get_nombre_mes($n){

//el parametro w en la funcion date indica que queremos el dia de la semana
//lo devuelve en numero 0 domingo, 1 lunes,....
switch ($n){
case 1: return "enero"; break;
case 2: return "febrero"; break;
case 3: return "marzo"; break;
case 4: return "abril"; break;
case 5: return "mayo"; break;
case 6: return "junio"; break;
case 7: return "julio"; break;
case 8: return "agosto"; break;
case 9: return "septiembre"; break;
case 10: return "octubre"; break;
case 11: return "noviembre"; break;
case 12: return "diciembre"; break;
}
}


function cupones_disponibles()
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT cupon_id, fecha_emision, fecha_caducidad, monto, cupon_status FROM vp_cupon
        WHERE cupon_status=?";

$p = $pdo->prepare($sql);
$p->execute(array(0));
$cupones = $p->fetchAll();
Database::disconnect();
return $cupones;
}

function cupones_utilizados()
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.vehiculo_id,T1.fecha_entregado, T2.nombre,T2.linea,T4.cupones,T4.montos,T4.monto,
T2.placa,T3.conductor_id,T1.km_inicio,T1.km_final,T1.galones_consumidos,T5.NOMBRE,
(T1.km_final - T1.km_inicio) AS km_re
FROM vp_cupon_entregado T1
LEFT JOIN vp_vehiculo AS T2 ON T1.vehiculo_id=T2.vehiculo_id
LEFT JOIN vp_conductor AS T3 ON T1.conductor_id=T3.conductor_id

LEFT JOIN (SELECT DISTINCT GROUP_CONCAT(T2.cupon_id  SEPARATOR ',') AS cupones,
GROUP_CONCAT('Q ', T3.monto SEPARATOR ',') AS monto,
           sum(T3.monto) AS montos,T4.fecha_entregado,
           T2.vehiculo_id

FROM vp_cupon_vehiculo AS T2
           INNER JOIN vp_cupon AS T3 ON T3.cupon_id=T2.cupon_id
           INNER JOIN vp_cupon_entregado AS T4 ON T4.vehiculo_id=T2.vehiculo_id AND T4.fecha_entregado=T2.fecha_entregado
           WHERE T2.cupon_status=1
           GROUP BY T2.fecha_entregado
    ) AS T4 ON T4.vehiculo_id=T1.vehiculo_id AND T4.fecha_entregado=T1.fecha_entregado


    LEFT JOIN (SELECT T5.user_id, CONCAT(T5.user_nm1,' ',T5.user_nm2,' ',T5.user_ap1,' ',T5.user_ap2) AS NOMBRE
               FROM vp_user AS T5


    ) AS T5 ON T3.user_id=T5.user_id

    GROUP BY T1.fecha_entregado, T1.vehiculo_id, T4.cupones";

$p = $pdo->prepare($sql);
$p->execute(array(0));
$cupones = $p->fetchAll();
Database::disconnect();
return $cupones;
}

function cupones_utilizados_mes($mes, $mes2, $year)
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T2.placa, T2.nombre, T2.linea, T2.modelo, T1.vehiculo_id,
        T1.year, T1.mes,T1.solicitud_id, T1.dep_id, T3.cupones,T3.monto1,
		T4.km_ini,T4.km_fin,(T4.km_fin-T4.km_ini) AS km_re,T4.monto,
		T5.NOMBRE,T6.montos,
		T7.fecha_autorizado
        FROM vp_solicitud_cupon_vehiculo AS T1
        LEFT JOIN vp_vehiculo AS T2 ON T1.vehiculo_id=T2.vehiculo_id
        LEFT JOIN (SELECT GROUP_CONCAT(T1.cupon_id SEPARATOR ',') AS cupones, T1.vehiculo_id, T1.year, T1.mes, T1.solicitud_id, T1.dep_id,
                   GROUP_CONCAT(T2.monto,'-',T1.cupon_status SEPARATOR ',') AS monto1
                   FROM vp_cupon_vehiculo_entregado AS T1
                   INNER JOIN vp_cupon AS T2 ON T1.cupon_id=T2.cupon_id
                   GROUP BY T1.year, T1.mes, T1.solicitud_id,T1.dep_id,T1.vehiculo_id) AS T3 ON T3.vehiculo_id=T1.vehiculo_id AND T3.year=T1.year AND T3.mes=T1.mes AND T3.solicitud_id=T1.solicitud_id AND T3.dep_id=T1.dep_id

    		LEFT JOIN vp_solicitud_cupon_vehiculo AS T4 ON T4.vehiculo_id=T1.vehiculo_id AND T4.year=T1.year AND T4.mes=T1.mes AND T4.solicitud_id=T1.solicitud_id AND T4.dep_id=T1.dep_id
    		LEFT JOIN (SELECT user_id, CONCAT(user_nm1, ' ', user_nm2, ' ',user_ap1,' ',user_ap2) AS NOMBRE FROM vp_user) AS T5 ON T4.conductor_id=T5.user_id

    		LEFT JOIN (SELECT sum(T2.monto) AS montos, T1.vehiculo_id, T1.year, T1.mes, T1.solicitud_id, T1.dep_id

                       FROM vp_cupon_vehiculo_entregado AS T1
                       INNER JOIN vp_cupon AS T2 ON T1.cupon_id=T2.cupon_id
                       WHERE T1.cupon_status=1
                       GROUP BY T1.year, T1.mes, T1.solicitud_id,T1.dep_id,T1.vehiculo_id) AS T6 ON T6.vehiculo_id=T1.vehiculo_id AND T6.year=T1.year AND T6.mes=T1.mes AND T6.solicitud_id=T1.solicitud_id AND T6.dep_id=T1.dep_id

       LEFT JOIN vp_solicitud_cupon AS T7 ON T7.year=T1.year AND T7.mes=T1.mes AND T7.solicitud_id=T1.solicitud_id AND T7.dep_id=T1.dep_id

        WHERE T1.mes BETWEEN ? AND ? AND T1.year=?
        GROUP BY T1.year, T1.mes, T1.solicitud_id, T1.dep_id, T1.vehiculo_id, T3.cupones";

$p = $pdo->prepare($sql);
$p->execute(array($mes,$mes2,$year));
$cupones = $p->fetchAll();
Database::disconnect();
return $cupones;
}



function get_cupones_utilizados_by_id($year,$mes,$solicitud,$carro,$dep_id)
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.cupon_id, T1.monto,T2.cupon_status
FROM vp_cupon AS T1 INNER JOIN vp_cupon_vehiculo_entregado AS T2 ON T2.cupon_id=T1.cupon_id
WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND vehiculo_id=? AND dep_id=?";

$p = $pdo->prepare($sql);
$p->execute(array($year,$mes,$solicitud,$carro,$dep_id));
$cupones = $p->fetchAll();
Database::disconnect();
return $cupones;
}


$combustible = array(1 => 'Gasolina', 2 => 'Diesel');
$tipo_vehiculo = array(1 => 'Camioneta', 2 => 'Vehículo',3=>'Pick up',4=>'Microbus',5=>'Motocicleta');

function get_carros($dep){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,
T1.cilindraje,T1.rendimiento,T1.combustible_id,T1.color,T1.status,T1.user_id, T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,T1.tipo,
CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS NOMBRE
FROM vp_vehiculo AS T1

INNER JOIN vp_user AS T3 ON T3.user_id=T1.user_id WHERE T1.vice_id=1 AND T1.status=1 AND T1.dep_id=? ORDER BY T1.placa ASC";

$p = $pdo->prepare($sql);
$p->execute(array($dep));
$vehiculos = $p->fetchAll();
Database::disconnect();

return $vehiculos;
}


/*
SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,
T1.cilindraje,T1.rendimiento,T1.combustible_id,T1.color,T1.status,T1.user_id, T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,T1.tipo,
 MAX(T3.contador_km_mantenimiento) AS NOMBRE
FROM vp_vehiculo AS T1

INNER JOIN vp_bitacora_vehiculo AS T3 ON T3.vehiculo_id=T1.vehiculo_id
where T1.vehiculo_id = 7
*/
// query para nissan


function get_carros7($dep){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,
T1.cilindraje,T1.rendimiento,T1.combustible_id,T1.color,T1.status,T1.user_id, T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,T1.tipo,
CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS NOMBRE
FROM vp_vehiculo AS T1

INNER JOIN vp_user AS T3 ON T3.user_id=T1.user_id WHERE T1.vice_id=1 AND T1.status=1 AND T1.dep_id=? ORDER BY T1.placa ASC";

$p = $pdo->prepare($sql);
$p->execute(array($dep));
$vehiculos = $p->fetchAll();
Database::disconnect();

return $vehiculos;
}



function get_solicitudes_cupones(){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.year,T1.mes,LPAD(T1.solicitud_id, 3,'0') AS IDX,
        T1.solicitud_id,T1.estado_solicitud,DATE(T1.fecha_solicitud)as fecha,
        T2.dep_nm,T2.dep_id,T1.comision_status
        FROM vp_solicitud_cupon AS T1
        INNER JOIN vp_deptos AS T2 ON T1.dep_id= T2.dep_id
        WHERE T1.year = '2020'       
        ORDER BY T1.fecha_solicitud DESC";

$p = $pdo->prepare($sql);
$p->execute();
$solicitudes = $p->fetchAll();
Database::disconnect();

return $solicitudes;
}
function get_solicitudes_cupones_by_id($dep_id){

$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT T1.year,T1.mes,LPAD(T1.solicitud_id, 3,'0') AS IDX,
        T1.solicitud_id,T1.estado_solicitud,DATE(T1.fecha_solicitud)as fecha,
        T2.dep_nm,T2.dep_id,T1.comision_status
        FROM vp_solicitud_cupon AS T1
        INNER JOIN vp_deptos AS T2 ON T1.dep_id= T2.dep_id
        WHERE T1.dep_id=?
        ORDER BY T1.fecha_solicitud DESC";

$p = $pdo->prepare($sql);
$p->execute(array($dep_id));
$solicitudes = $p->fetchAll();
Database::disconnect();

return $solicitudes;
}

function get_carros_por_solicitud($year,$mes,$solicitud,$dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,
  T1.cilindraje,T1.combustible_id,T1.color,T1.status,T1.user_id, T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,
  T2.monto,T2.estado_solicitud,T2.dep_id,T3.user_id,
  CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS NOMBRE
  FROM vp_vehiculo AS T1
  INNER JOIN vp_solicitud_cupon_vehiculo AS T2 ON T2.vehiculo_id=T1.vehiculo_id
  INNER JOIN vp_user AS T3 ON T3.user_id=T2.conductor_id
  WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.dep_id=? ORDER BY T1.placa ASC, T1.vehiculo_id ASC";

  $p = $pdo->prepare($sql);
  $p->execute(array($year,$mes,$solicitud,$dep_id));
  $vehiculos = $p->fetchAll();
  Database::disconnect();

  return $vehiculos;
}

function get_fecha_autorizado_por_solicitud_by_id($year,$mes,$solicitud,$dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT DATE(T2.fecha_autorizado) as fecha_autorizado
          FROM vp_solicitud_cupon AS T2
          WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.dep_id=?";
  $q = $pdo->prepare($sql);
  $q->execute(array($year,$mes,$solicitud,$dep_id));
  $fecha = $q->fetch(PDO::FETCH_ASSOC);

  return $fecha;

}

function get_carro_por_solicitud_by_id($year,$mes,$solicitud,$vehiculo,$dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT T1.vehiculo_id,T1.nombre,T1.linea,T1.placa,T1.modelo,T1.c_c,T1.tipo,
          T1.cilindraje,T1.combustible_id,T1.color,T1.status,T1.user_id, T1.vice_id, T1.capacidad, T1.status_uso, T1.comision_id,
          T2.monto,T2.estado_solicitud,T2.km_ini,T2.km_fin,T2.galones_consumidos,T2.destino,
          DATE(T4.fecha_autorizado) AS fecha_autorizado,T1.dep_id,
          CONCAT(T3.user_nm1, ' ', T3.user_nm2,' ',T3.user_ap1, ' ',T3.user_ap2)AS NOMBRE
          FROM vp_vehiculo AS T1
          INNER JOIN vp_solicitud_cupon_vehiculo AS T2 ON T2.vehiculo_id=T1.vehiculo_id
          INNER JOIN vp_user AS T3 ON T3.user_id=T2.conductor_id
          INNER JOIN vp_solicitud_cupon AS T4 ON T2.year=T4.year AND T2.mes=T4.mes AND T2.solicitud_id=T4.solicitud_id AND T2.dep_id=T4.dep_id
          WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.vehiculo_id=? AND T2.dep_id=?";
  $q = $pdo->prepare($sql);
  $q->execute(array($year,$mes,$solicitud,$vehiculo,$dep_id));
  $vehiculo = $q->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  return $vehiculo;
  /*$return_arr = array(
                      'placa'=>$vehiculo['placa'],
                      'marca'=>$vehiculo['nombre'],
                      'linea'=>$vehiculo['linea'],
                      'modelo'=>$vehiculo['modelo'],
                      'color'=>$vehiculo['color'],
                      'cilindraje'=>$vehiculo['c_c'],
                      'responsable'=>$vehiculo['NOMBRE'],
                      'cilindros'=>$vehiculo['cilindraje']
                    );

  echo json_encode($return_arr);*/
}

function get_cupones_grupos()
{

  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT MIN(T1.cupon_id) AS c_ini, MAX(T1.cupon_id) AS c_fin, T1.fecha_emision, T1.fecha_caducidad,
  COUNT(SUBSTRING(T1.cupon_id,0,4))AS todos,T1.monto, (COUNT(SUBSTRING(T1.cupon_id,0,4)) * T1.monto) as total
FROM vp_cupon AS T1 GROUP BY SUBSTRING(T1.cupon_id,0,4), T1.monto,T1.fecha_emision,T1.fecha_caducidad";

  $p = $pdo->prepare($sql);
  $p->execute(array());
  $cupones_grupo = $p->fetchAll();
  Database::disconnect();

  return $cupones_grupo;

}

function get_cupones_disponibles($inicio,$fin)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT COUNT(cupon_status) AS disponibles
  FROM vp_cupon  WHERE cupon_status=? AND cupon_id BETWEEN ? AND ?";

  $p = $pdo->prepare($sql);
  $p->execute(array(0,$inicio,$fin));
  $cd = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  return $cd;


}
function get_cupones_ocupados($inicio,$fin){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT COUNT(cupon_status) AS ocupados
  FROM vp_cupon  WHERE cupon_status=? AND cupon_id BETWEEN ? AND ?";

  $p = $pdo->prepare($sql);
  $p->execute(array(1,$inicio,$fin));
  $co = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();
  return $co;
}

function get_comision_by_solicitud_id($year,$mes,$solicitud,$dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT LPAD(T1.solicitud_id, 8,'0') AS IDX, T1.solicitud_id, T1.destino, T1.motivo,T1.status
          FROM vp_solicitud_transporte_destino_motivo AS T1
          INNER JOIN vp_solicitud_cupon_comision AS T2 ON T2.comision_id=T1.solicitud_id
          WHERE T2.year=? AND T2.mes=? AND T2.solicitud_c_id=? AND T2.dep_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($year,$mes,$solicitud,$dep_id));
  $comision = $p->fetchAll();
  Database::disconnect();

  return $comision;
}

function get_destino_y_motivos_by_solicitud_id($year,$mes,$solicitud,$dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT GROUP_CONCAT('Destino :', T1.destino, ' Motivo: ', T1.motivo SEPARATOR "/") AS Destination,
  T1.solicitud_id, T1.destino, T1.motivo,T1.status,T2.year,T2.mes,T2.solicitud_c_id, T2.dep_id
            FROM vp_solicitud_transporte_destino_motivo AS T1
             INNER JOIN vp_solicitud_cupon_comision AS T2 ON T2.comision_id=T1.solicitud_id


          WHERE T2.year=? AND T2.mes=? AND T2.solicitud_c_id=? AND T2.dep_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($year,$mes,$solicitud,$dep_id));
  $comision = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  return $comision;
}

function get_estado_solicitud($year,$mes,$solicitud,$dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT T2.estado_solicitud FROM vp_solicitud_cupon AS T2


          WHERE T2.year=? AND T2.mes=? AND T2.solicitud_id=? AND T2.dep_id=?";

  $p = $pdo->prepare($sql);
  $p->execute(array($year,$mes,$solicitud,$dep_id));
  $comision = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  return $comision;
}




?>
