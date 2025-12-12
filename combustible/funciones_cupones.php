<?php
/**
 * User: stuart.carazo
 * Date: 2/11/2016
 * Time: 2:37 AM
 */

//funciones de personal
function cupones_usuarios(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,user_vid,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,T1.dep_id,dep_nm,user_puesto,user_nom,user_status,T1.role_id,role_nm
            FROM vp_user AS T1 
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
            LEFT JOIN vp_conductor AS T4 on T1.user_id = T4.user_id
            WHERE T1.user_status like 1
            order by T4.status DESC,user_nm1,user_ap1";
    $p = $pdo->prepare($sql);
    $p->execute();
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}
// funcion listado bitacora por usuario
function list_bitacora_por_usuario($user_id){
    $pdo = Database::connect();
    $sql = "SELECT vp_bitacora_vehiculo.id_bitacora, vp_bitacora_vehiculo.fecha,vp_bitacora_vehiculo.km_inicial,vp_bitacora_vehiculo.km_final ,vp_bitacora_vehiculo.status,vp_vehiculo.nombre,vp_vehiculo.placa,vp_vehiculo.linea,vp_vehiculo.modelo,vp_vehiculo.color,vp_bitacora_vehiculo.id_solicitud, vp_bitacora_vehiculo.Destino, vp_user.user_nm1, vp_user.user_ap1
FROM vp_bitacora_vehiculo
INNER JOIN vp_user
ON vp_bitacora_vehiculo.id_user = vp_user.user_id
INNER JOIN vp_vehiculo
ON vp_bitacora_vehiculo.vehiculo_id=vp_vehiculo.vehiculo_id
where vp_bitacora_vehiculo.id_user = ? ORDER BY vp_bitacora_vehiculo.id_bitacora  DESC";
    $p = $pdo->prepare($sql);
    $p->execute(array($user_id));
    $nombramientos = $p->fetchAll();
    Database::disconnect();
    return $nombramientos;
    
    
    
}

// funcion listado bitacora por usuario
function list_bitacora_por_usuario_admin($user_id){
    $pdo = Database::connect();
    $sql = "SELECT vp_bitacora_vehiculo.id_bitacora, vp_bitacora_vehiculo.fecha,vp_bitacora_vehiculo.km_inicial,vp_bitacora_vehiculo.km_final,vp_bitacora_vehiculo.km_recorrido ,vp_bitacora_vehiculo.status,vp_bitacora_vehiculo.contador_km_mantenimiento,vp_vehiculo.nombre,vp_vehiculo.placa,vp_vehiculo.linea,vp_vehiculo.modelo,vp_vehiculo.color,vp_bitacora_vehiculo.id_solicitud, vp_bitacora_vehiculo.Destino, vp_bitacora_vehiculo.motivo, vp_user.user_nm1, vp_user.user_ap1
FROM vp_bitacora_vehiculo
INNER JOIN vp_user
ON vp_bitacora_vehiculo.id_user = vp_user.user_id
INNER JOIN vp_vehiculo
ON vp_bitacora_vehiculo.vehiculo_id=vp_vehiculo.vehiculo_id
ORDER BY vp_bitacora_vehiculo.id_bitacora  DESC";
    $p = $pdo->prepare($sql);
    $p->execute(array($user_id));
    $nombramientos = $p->fetchAll();
    Database::disconnect();
    return $nombramientos;
    
    
    
}


// funcion iformacion bitacora por id
function bitacora_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_bitacora, Destino,motivo,km_inicial, km_final, status, vehiculo_id FROM vp_bitacora_vehiculo where id_bitacora = ? ORDER BY id_bitacora";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $bitacora = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $bitacora;
}

function bitacora_info2($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT vp_bitacora_vehiculo.id_bitacora, vp_vehiculo.nombre, vp_vehiculo.placa, vp_bitacora_vehiculo.Destino,vp_bitacora_vehiculo.motivo,vp_bitacora_vehiculo.contador_km_mantenimiento, vp_bitacora_vehiculo.km_final, vp_bitacora_vehiculo.status, vp_bitacora_vehiculo.vehiculo_id FROM vp_bitacora_vehiculo
join vp_vehiculo
on vp_bitacora_vehiculo.vehiculo_id=vp_vehiculo.vehiculo_id
where id_bitacora = ?
ORDER BY id_bitacora";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $bitacora = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $bitacora;
}


function monthToString($date){
    $mes= date('m',strtotime($date));
    switch ($mes){
        case 1:
            $month = 'Enero';
        break;
        case 2:
            $month = 'Febrero';
        break;
        case 3:
            $month = 'Marzo';
        break;
        case 4:
            $month = 'Abril';
        break;
        case 5:
            $month = 'Mayo';
        break;
        case 6:
            $month = 'Junio';
        break;
        case 7:
            $month = 'Julio';
        break;
        case 8:
            $month = 'Agosto';
        break;
        case 9:
            $month = 'Septiembre';
            break;
        case 10:
            $month = 'Octubre';
        break;
        case 11:
            $month = 'Noviembre';
        break;
        case 12:
            $month = 'Diciembre';
        break;
        default:
            $month = '';
        break;
    }
    return $month;
}
