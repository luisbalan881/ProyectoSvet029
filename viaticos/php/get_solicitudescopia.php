<?php

function get_solicitud_by_id1($solicitud){



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT vp_user.user_nm1, vp_user.user_ap1, vp_user.user_nm2, vp_user.user_ap2,vs_nombramiento.cod_nombramiento,vs_nombramiento.objetivo,vs_nombramiento.lugar, vs_nombramiento.fecha , vs_nombramiento.fecha_inicio, vs_nombramiento.fecha_fin
FROM vs_nombramiento
join vp_user
on vs_nombramiento.id_funcionario = vp_user.user_id
where id_nombramiento = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud;

}

//get_comision_by_solicitud_id2
function get_solicitud_by_id_solicitante($solicitud){



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT id_nombramiento, CONCAT(vp_user.user_nm1,' ', vp_user.user_nm2,' ', vp_user.user_ap1,' ', vp_user.user_ap2) as nombre,vs_nombramiento.cod_nombramiento,vs_nombramiento.objetivo,vs_nombramiento.lugar, vs_nombramiento.fecha , vs_nombramiento.fecha_inicio, vs_nombramiento.fecha_fin, vp_deptos.dep_nm , vp_user.user_puesto, vp_user.user_nit
FROM vs_nombramiento 
join vp_user 
on vs_nombramiento.id_funcionario = vp_user.user_id 
join vp_deptos
on vs_nombramiento.dep_f1 = vp_deptos.dep_id
where id_nombramiento = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud1;

}
function get_solicitud_by_id_encargado($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT CONCAT(vp_user.user_nm1,' ', vp_user.user_nm2,' ', vp_user.user_ap1,' ', vp_user.user_ap2) as encargado , vp_user.user_puesto
FROM vs_nombramiento 
join vp_user 
on vs_nombramiento.id_funcionario2 = vp_user.user_id 
join vp_deptos
on vs_nombramiento.dep_f1 = vp_deptos.dep_id
where id_nombramiento = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud2 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud2;

}

function get_formulario($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT vs_nombramiento.id_nombramiento, CONCAT(vp_user.user_nm1,' ', vp_user.user_nm2,' ', vp_user.user_ap1,' ', vp_user.user_ap2) as nombre,
    vs_nombramiento.cod_nombramiento,vs_nombramiento.objetivo,vs_nombramiento.lugar, vs_nombramiento.fecha , vs_nombramiento.fecha_inicio, vs_nombramiento.fecha_fin, vs_nombramiento.fecha_liquidacion, vp_deptos.dep_nm , vp_user.user_puesto, vp_user.user_nit, vs_viaticos.id_viatico , vs_viaticos.fecha
    FROM vs_nombramiento 
    join vp_user 
    on vs_nombramiento.id_funcionario = vp_user.user_id join vp_deptos 
    on vs_nombramiento.dep_f1 = vp_deptos.dep_id join vs_viaticos 
    on vs_nombramiento.id_nombramiento = vs_viaticos.id_nombramiento 
 where vs_nombramiento.id_nombramiento = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud9 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud9;

}

function get_solicitud_by_id_total($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT sum(vs_tipo_viatico.valor2) as total from vs_tipo_viatico join vs_detalle on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo where vs_detalle.id_nombramiento = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud3 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud3;

}

function get_solicitud_by_id_dia($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT sum(vs_tipo_viatico.valo1) as totald from vs_tipo_viatico join vs_detalle on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo where vs_detalle.id_nombramiento = ?";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud6 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud6;

}



function get_solicitud_by_id_descripcion($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT  vs_tipo_viatico.descripcion, vs_tipo_viatico.dia 
from vs_tipo_viatico
join vs_detalle
on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo
where vs_detalle.id_nombramiento = ? ";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud4 = $p->fetch(PDO::FETCH_ASSOC);
//var_dump ($solicitud4);
Database::disconnect();
return $solicitud4;

}

function get_solicitud_by_id_descripcion2($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT  vs_tipo_viatico.descripcion, vs_tipo_viatico.dia 
from vs_tipo_viatico
join vs_detalle
on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo
where vs_detalle.id_nombramiento = ? ";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud5 = $p->fetch(PDO::FETCH_ASSOC);
//var_dump ($solicitud4);
Database::disconnect();
return $solicitud5;

}
//get_comision_by_solicitud_id2

function get_solicitud_by_id_descripcion3($solicitud){
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT tdesayunos, talmuerzos, tcenas, thospedaje, (tdesayunos+talmuerzos+tcenas+thospedaje) as total_liq FROM vs_nombramiento where id_nombramiento = ? ";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud8 = $p->fetch(PDO::FETCH_ASSOC);
//var_dump ($solicitud4);
Database::disconnect();
return $solicitud8;

}

function get_solicitud_by_id2($id){



$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM vs_nombramiento where id_nombramiento = ?";
$p = $pdo->prepare($sql);
$p->execute(array($id));
$solicitud = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud;

}



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




function get_solicitud_by_id3($id1){



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
$p->execute(array($id1,$id1,$id1));
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

function get_comision_by_solicitud_id2($id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT  vs_tipo_viatico.descripcion, vs_tipo_viatico.dia, vs_tipo_viatico.valor2 
from vs_tipo_viatico
join vs_detalle
on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo
where vs_detalle.id_nombramiento = ? ORDER by vs_tipo_viatico.id_tipo";

  $p = $pdo->prepare($sql);
  $p->execute(array($id));
  $comision = $p->fetchAll();
  Database::disconnect();

  return $comision;
}

function get_totales($id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT (sum(vs_tipo_viatico.valor2) - (vs_nombramiento.tdesayunos+vs_nombramiento.talmuerzos+vs_nombramiento.tcenas+vs_nombramiento.thospedaje)) as total
from vs_tipo_viatico 
join vs_detalle 
on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo 
join vs_nombramiento
on vs_nombramiento.id_nombramiento=vs_detalle.id_nombramiento
where vs_detalle.id_nombramiento  = ? ";

  $p = $pdo->prepare($sql);
  $p->execute(array($id));
  $comision = $p->fetchAll();
  Database::disconnect();

  return $comision;
}

function get_reitegro($id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT (sum(vs_tipo_viatico.valor2) - (vs_nombramiento.tdesayunos+vs_nombramiento.talmuerzos+vs_nombramiento.tcenas+vs_nombramiento.thospedaje)) as total
from vs_tipo_viatico 
join vs_detalle 
on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo 
join vs_nombramiento
on vs_nombramiento.id_nombramiento=vs_detalle.id_nombramiento
where vs_detalle.id_nombramiento  = ? ";

  $p = $pdo->prepare($sql);
  $p->execute(array($id));
  $reitegro = $p->fetch();
  Database::disconnect();

  return $reitegro;
}




 ?>
