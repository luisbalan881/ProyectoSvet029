<?php
/**
 * User: Marvin.Garcia
 * Date: 20/05/2020
 * Time: 3:53 PM
 * @param $fecha
 * @return bool|string
 */
// 


function persona_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,role_id,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,T1.dep_id,dep_nm,user_puesto 
            FROM vp_user AS T1 
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            WHERE T1.user_id = ?
            order by user_nm1,user_ap1";
    $p = $pdo->prepare($sql);
    $p->execute(array($id));
    $persona = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $persona;
}

//funciones de Nombramientos

function Todos_nombramientos(){
    $pdo = Database::connect();
    $sql = "SELECT vs_nombramiento.id_nombramiento, vs_nombramiento.id_funcionario2 ,vs_nombramiento.fecha,vs_nombramiento.fecha_inicio, vs_nombramiento.fecha_fin, vp_user.user_nm1, vp_user.user_ap1, vs_nombramiento.cod_nombramiento, vs_nombramiento.lugar, vs_nombramiento.objetivo, vs_nombramiento.status
FROM vs_nombramiento
INNER JOIN vp_user
ON vs_nombramiento.id_funcionario = vp_user.user_id where vs_nombramiento.status <= 0  ORDER BY fecha_inicio DESC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $nombramientos = $p->fetchAll();
    Database::disconnect();
    return $nombramientos;
}

function nombramientos(){
    $pdo = Database::connect();
    $sql = "SELECT vs_nombramiento.id_nombramiento, vs_nombramiento.id_funcionario2 ,vs_nombramiento.fecha,vs_nombramiento.fecha_inicio, vs_nombramiento.fecha_fin, vp_user.user_nm1, vp_user.user_ap1, vs_nombramiento.cod_nombramiento, vs_nombramiento.lugar, vs_nombramiento.objetivo, vs_nombramiento.status
FROM vs_nombramiento
INNER JOIN vp_user
ON vs_nombramiento.id_funcionario = vp_user.user_id ORDER BY fecha_inicio DESC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $nombramientos = $p->fetchAll();
    Database::disconnect();
    return $nombramientos;
}



function nombramientos2($user_id){
    $pdo = Database::connect();
    $sql = " SELECT vs_nombramiento.id_nombramiento, vs_nombramiento.id_funcionario2 ,vs_nombramiento.fecha,vs_nombramiento.fecha_inicio, vs_nombramiento.fecha_fin, vp_user.user_nm1, vp_user.user_ap1, vs_nombramiento.cod_nombramiento, vs_nombramiento.lugar, vs_nombramiento.objetivo, vs_nombramiento.status
FROM vs_nombramiento
INNER JOIN vp_user
ON vs_nombramiento.id_funcionario = vp_user.user_id  where vs_nombramiento.id_funcionario = ? ORDER BY vs_nombramiento.id_nombramiento  DESC";
    $p = $pdo->prepare($sql);
    $p->execute(array($user_id));
    $nombramientos = $p->fetchAll();
    Database::disconnect();
    return $nombramientos;
	
	
}

function ReporteNombramientos(){
    $pdo = Database::connect();
    $sql = "SELECT vs_nombramiento.fecha_inicio as FechaSalida, vs_nombramiento.fecha_fin as FechaRetorno, CONCAT(vp_user.user_nm1,' ',vp_user.user_nm2 ,' ', vp_user.user_ap1,' ',vp_user.user_ap2) as NombreServidorPublico, vs_nombramiento.lugar as Destino, vs_nombramiento.objetivo as ObjetivoDelViaje, (vs_nombramiento.tdesayunos+vs_nombramiento.talmuerzos+vs_nombramiento.tcenas+vs_nombramiento.thospedaje) as CostoDeViaje, vs_viaticos.id_viatico as FormularioAsignado
FROM vs_nombramiento
INNER JOIN vp_user
ON vs_nombramiento.id_funcionario = vp_user.user_id
INNER JOIN vs_viaticos 
ON vs_nombramiento.id_nombramiento = vs_viaticos.id_nombramiento
WHERE vs_nombramiento.status>=3 
ORDER BY vs_viaticos.id_viatico ASC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $reportenombramientos = $p->fetchAll();
    Database::disconnect();
    return $reportenombramientos;
}


function detalleComision_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT tdesayunos, talmuerzos, tcenas,thospedaje,actividades, logros, objetivod, ampliacion_cantidad, ampliacion_tiempo  FROM vs_nombramiento where id_nombramiento = ? ORDER BY id_nombramiento";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $bitacora = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $bitacora;
}



function detallenombramieto_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT lugar, objetivo, fecha_fin, fecha_inicio  FROM vs_nombramiento where id_nombramiento = ? ORDER BY id_nombramiento";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $bitacora = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $bitacora;
}


function nombramiento_nueva(){
    $cod_nombramiento = $_POST['cod_nombramiento'];
    $fecha_inicio = fecha_ymd($_POST['fecha_inicio']);
    $fecha_fin = fecha_ymd($_POST['fecha_fin']);
    $lugar = $_POST['lugar'];
    $objetivo = $_POST['objetivo'];
    $id_funcionario = $_SESSION['id_funcionario'];
    $id_funcionario2 = $_SESSION['id_funcionario2'];
    //$dep_id = persona_info($req_user)['dep_id'];
    $pdo = Database::connect();
    $sql = "INSERT INTO vs_nombramiento (cod_nombramiento,id_funcionario,id_funcionario2,fecha_inicio,fecha_fin,lugar,objetivo) values(?, ?, ?, ?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($cod_nombramiento,$id_funcionario,$id_funcionario2,$fecha_inicio,$fecha_fin,$lugar,$objetivo));
    $id = $pdo->lastInsertId();
    Database::disconnect();
    return $id;
}



