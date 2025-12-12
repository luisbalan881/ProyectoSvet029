<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 12/10/2016
 * Time: 4:11 PM
 */

function instituciones(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT inst_id,inst_nombre,inst_abrev,inst_direccion,inst_tel,inst_web,inst_tipo,inst_status
            FROM vp_institucion AS T1
            order by inst_nombre";
    $p = $pdo->prepare($sql);
    $p->execute();
    $instituciones = $p->fetchAll();
    Database::disconnect();
    return $instituciones;
}

function institucion_nueva(){
    $inst_nombre = $_POST['inst_nombre'];
    $inst_abrev = $_POST['inst_abrev'];
    $inst_direccion = $_POST['inst_direccion'];
    $inst_tel = $_POST['inst_tel'];
    $inst_web = $_POST['inst_web'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $sql = "INSERT INTO vp_institucion (inst_nombre,inst_abrev,inst_direccion,inst_tel,inst_web,user_id) values(?, ?, ?, ?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($inst_nombre,$inst_abrev,$inst_direccion,$inst_tel,$inst_web,$user_id));
    Database::disconnect();
}

function institucionById($inst_id){
    $pdo = Database::connect();
    $sql = "SELECT inst_id,inst_nombre,inst_abrev,inst_direccion,inst_tel,inst_web,inst_status,T1.user_id,T2.user_nm1,T2.user_ap2
            FROM vp_institucion AS T1
            left join vp_user AS T2 on T1.user_id = T2.user_id
            WHERE T1.inst_id = ?
            order by inst_nombre asc";
    $p = $pdo->prepare($sql);
    $p->execute(array($inst_id));
    $archivo = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $archivo;
}

function institucion_modificar($inst_id){
    $inst_nombre = $_POST['inst_nombre'];
    $inst_abrev = $_POST['inst_abrev'];
    $inst_direccion = $_POST['inst_direccion'];
    $inst_tel = $_POST['inst_tel'];
    $inst_web = $_POST['inst_web'];
    $inst_status = $_POST['inst_status'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $sql = "UPDATE vp_institucion SET inst_nombre = ?,inst_abrev = ?,inst_direccion = ?,inst_tel = ?,inst_web = ?, inst_status = ?,user_id = ? WHERE inst_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($inst_nombre,$inst_abrev,$inst_direccion,$inst_tel,$inst_web,$inst_status,$user_id,$inst_id));
    Database::disconnect();
}

function archivoTipos(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT tipo_id,tipo_nombre,tipo_status
            FROM arch_tipo AS T1
            order by tipo_id";
    $p = $pdo->prepare($sql);
    $p->execute();
    $archivoTipos = $p->fetchAll();
    Database::disconnect();
    return $archivoTipos;
}

function archivoTipoNuevo(){
    $tipo_nombre = $_POST['tipo_nombre'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $sql = "INSERT INTO arch_tipo (tipo_nombre,user_id) values(?,?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($tipo_nombre,$user_id));
    Database::disconnect();
}

function archivoTipoModificar($tipo_id){
    $tipo_nombre = $_POST['tipo_nombre'];
    $tipo_status = $_POST['tipo_status'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $sql = "UPDATE arch_tipo SET tipo_nombre = ?, tipo_status = ?,user_id = ?
            WHERE tipo_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($tipo_nombre,$tipo_status,$user_id,$tipo_id));
    Database::disconnect();
}

function archivoTipoById($tipo_id){
    $pdo = Database::connect();
    $sql = "SELECT tipo_id,tipo_nombre,tipo_status,T1.user_id,T2.user_nm1,T2.user_ap2
            FROM arch_tipo AS T1
            left join vp_user AS T2 on T1.user_id = T2.user_id
            WHERE T1.tipo_id = ?";
    $p = $pdo->prepare($sql);
    $p->execute(array($tipo_id));
    $archivoTipo = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $archivoTipo;
}


  /*function archivo_nuevo(){

              $insti = $_POST['a_destinatarios'];
                $nombre = 'nombre';
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                foreach ($insti as $c) {
                  $sql = "INSERT INTO tabla_de_prueba (codigo,nombre) values(?,?)";
                  $q = $pdo->prepare($sql);
                  $q->execute(array($c,$nombre));
                }



                Database::disconnect();

}*/

function archivo_nuevo(){
    if (usuarioPrivilegiado()->hasPrivilege('crearArchivo')){
        $user = User::getByUserId($_SESSION['user_id']);
        $dirname = verificar_carpeta($user->persona['dep_nm']);
        date_default_timezone_set('America/Guatemala');
        $date = date('Ymd H.i.s',time());
        if($_FILES['arch_original']['name']){
            //cabiar nombre del archivo que se va guardar
            $ext = strtolower(pathinfo($_FILES['arch_original']['name'],PATHINFO_EXTENSION));
            $allowed = array('csv','txt','pub','xls','xlsx','doc','docx','ppt','pptx','pdf','jpeg','png');
            $arch_original = $date.' - ORIGINAL '.substr(strtolower($_FILES['arch_original']['name']),-120); //renombrar archivo ORIGINAL
            $arch_original = sanear_string($arch_original);
            if(subir_archivo($_FILES['arch_original'],$arch_original,$allowed,$ext,$dirname)){
                $allowed = array('pdf');
                if($_FILES['arch_firmado']['name']){
                    $ext = pathinfo($_FILES['arch_firmado']['name'],PATHINFO_EXTENSION);
                    $arch_firmado = $date.' - FIRMADO '.substr(strtolower($_FILES['arch_firmado']['name']),-120); //renombrar archivo FIRMADO
                    $arch_firmado = sanear_string($arch_firmado);
                    if(subir_archivo($_FILES['arch_firmado'],$arch_firmado,$allowed,$ext,$dirname)){}else{$arch_firmado = '';};
                }else{
                    $arch_firmado = '';
                }
                if($_FILES['arch_recibido']['name']){
                    $ext = pathinfo($_FILES['arch_recibido']['name'],PATHINFO_EXTENSION);
                    $arch_recibido = $date.' - RECIBIDO '.substr(strtolower($_FILES['arch_recibido']['name']),-120); //renombrar archivo RECIBIDO
                    $arch_recibido = sanear_string($arch_recibido);
                    if(subir_archivo($_FILES['arch_recibido'],$arch_recibido,$allowed,$ext,$dirname)){}else{$arch_recibido = '';};
                }else{
                    $arch_recibido = '';
                }
                $arch_user = $user->persona['user_id'];
                $arch_depto = $user->persona['dep_id'];
                $arch_tipo = $_POST['tipo_id'];
                $arch_fecha = fecha_ymd($_POST['arch_fecha']);
                $arch_correlativo = $_POST['arch_correlativo'];
                $arch_titulo = $_POST['arch_titulo'];
                $user_id = $user->persona['user_id'];

                $insti = $_POST['a_destinatarios'];
                $insti_c = $_POST['a_destinatarios_c'];
                $n='n';



                $pdo = Database::connect();
                $sql = "INSERT INTO vp_archivo (arch_user,depto_id,tipo_id,arch_fecha,arch_correlativo,arch_titulo,arch_original,arch_firmado,arch_recibido,user_id) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($arch_user,$arch_depto,$arch_tipo,$arch_fecha,$arch_correlativo,$arch_titulo,$arch_original,$arch_firmado,$arch_recibido,$user_id));
                $arch_id = $pdo->lastInsertId();

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                foreach ($insti as $c) {
                  $sql2 = "INSERT INTO vp_archivo_destinatario (inst_id,tipo,arch_id) values(?,?,?)";
                  $q2 = $pdo->prepare($sql2);
                  $q2->execute(array($c,1,$arch_id));
                }

                foreach ($insti_c as $c) {
                  $sql3 = "INSERT INTO vp_archivo_destinatario (inst_id,tipo,arch_id) values(?,?,?)";
                  $q3 = $pdo->prepare($sql3);
                  $q3->execute(array($c,2,$arch_id));
                }





                Database::disconnect();
            }
        }
    }
}


function archivo_modificar($arch_id){
    if (usuarioPrivilegiado()->hasPrivilege('crearArchivo')){
        $user = User::getByUserId($_SESSION['user_id']);
        $dirname = verificar_carpeta($user->persona['dep_nm']);
        date_default_timezone_set('America/Guatemala');
        $date = date('Ymd H.i.s',time());
        $archivo = archivoById($arch_id);
        $original_update = $archivo['arch_original'];
        $firmado_update = $archivo['arch_firmado'];
        $recibido_update = $archivo['arch_recibido'];

        //$archivoDestinatarios = explode(';',$archivo['arch_destinatario']);
        $archivoDestinatarios = explode(';',$archivo['inst_nombre']);



            //fin modificación


        $archivoDestinatariosCC = explode( ';',$archivo['arch_destinatario_cc']);
        $destinatarios = explode(';',$_POST['destinatarios']);
        $destinatariosCC = explode(';',$_POST['destinatarios_cc']);

        
        $insertarDestinatarios = array_diff($destinatarios,$archivoDestinatarios);
        $eliminarDestinatarios = array_diff($archivoDestinatarios,$destinatarios);
        $insertarDestinatariosCC = array_diff($destinatariosCC,$archivoDestinatariosCC);
        $eliminarDestinatariosCC = array_diff($archivoDestinatariosCC,$destinatariosCC);
        if($_FILES['arch_original']['name']){
            //cabiar nombre del archivo que se va guardar
            $ext = strtolower(pathinfo($_FILES['arch_original']['name'],PATHINFO_EXTENSION));
            $allowed = array('csv','txt','pub','xls','xlsx','doc','docx','ppt','pptx','pdf','jpeg','png');
            $arch_original = $date.' - ORIGINAL '.substr(strtolower($_FILES['arch_original']['name']),-120); //renombrar archivo ORIGINAL
            $arch_original = sanear_string($arch_original);
            if(subir_archivo($_FILES['arch_original'],$arch_original,$allowed,$ext,$dirname)){
               $original_update = $arch_original;
            }
        }
        $allowed = array('pdf');
        if($_FILES['arch_firmado']['name']){
            $ext = pathinfo($_FILES['arch_firmado']['name'],PATHINFO_EXTENSION);
            $arch_firmado = $date.' - FIRMADO '.substr(strtolower($_FILES['arch_firmado']['name']),-120); //renombrar archivo FIRMADO
            $arch_firmado = sanear_string($arch_firmado);
            if(subir_archivo($_FILES['arch_firmado'],$arch_firmado,$allowed,$ext,$dirname)){
                $firmado_update = $arch_firmado;
            }
        }

        if($_FILES['arch_recibido']['name']){
            $ext = pathinfo($_FILES['arch_recibido']['name'],PATHINFO_EXTENSION);
            $arch_recibido = $date.' - RECIBIDO '.substr(strtolower($_FILES['arch_recibido']['name']),-120); //renombrar archivo RECIBIDO
            $arch_recibido = sanear_string($arch_recibido);
            if(subir_archivo($_FILES['arch_recibido'],$arch_recibido,$allowed,$ext,$dirname)){
                $recibido_update = $arch_recibido;
            }
        }
        $arch_user = $user->persona['user_id'];
        $arch_depto = $user->persona['dep_id'];
        $tipo_id = $_POST['tipo_id'];
        $arch_fecha = fecha_ymd($_POST['arch_fecha']);
        $arch_correlativo = $_POST['arch_correlativo'];
        $arch_titulo = $_POST['arch_titulo'];
        $pdo = Database::connect();
        $sql = "UPDATE vp_archivo SET arch_user = ?,depto_id = ?,tipo_id = ?,arch_fecha = ?,arch_correlativo = ?,arch_titulo = ?,arch_original = ?,arch_firmado = ?,arch_recibido = ? WHERE arch_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($arch_user,$arch_depto,$tipo_id,$arch_fecha,$arch_correlativo,$arch_titulo,$original_update,$firmado_update,$recibido_update,$arch_id));
        $sql3 = "UPDATE vp_archivo_destinatario SET status = 0 WHERE nombre = ? and tipo = ? and arch_id = ?";
        $s = $pdo->prepare($sql3);
        foreach ($eliminarDestinatarios AS $destinatario){
            if ($destinatario != ''){
                $s->execute(array($destinatario,1,$arch_id));
            }
        }
        foreach ($eliminarDestinatariosCC AS $destinatario){
            if ($destinatario != ''){
                $s->execute(array($destinatario,2,$arch_id));
            }
        }
        /*$sql2 = "INSERT INTO vp_archivo_destinatario (nombre,tipo,arch_id) values (?,?,?)";
        $r = $pdo->prepare($sql2);
        foreach ($insertarDestinatarios  AS $destinatario){
            if ($destinatario != ''){
                $r->execute(array($destinatario,1,$arch_id));
            }
        }
        foreach ($insertarDestinatariosCC AS $destinatario){
            if ($destinatario != ''){
                $r->execute(array($destinatario,2,$arch_id));
            }
        }*/
        Database::disconnect();
    }
}

function archivo_eliminar($arch_id){
    $user = User::getByUserId($_SESSION['user_id']);
    $user_id = $user->persona['user_id'];
    $pdo = Database::connect();
    $sql = "UPDATE vp_archivo SET user_id = ?, arch_status = 0 WHERE arch_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($user_id,$arch_id));
    Database::disconnect();
}

function archivos_depto($dep_id){
    $pdo = Database::connect();
    $sql = "SELECT T1.arch_id,
    arch_user,
    concat(T2.user_nm1,' ',T2.user_ap1) AS arch_user_nombre,
    depto_id,
    T3.dep_encargado,
    T3.dep_nm AS depto_nombre,
    T4.arch_destinatario,
    T5.arch_destinatario_cc,
    T1.tipo_id,
    T7.tipo_nombre,
    arch_fecha,
    arch_correlativo,
    arch_titulo,
    arch_original,
    arch_firmado,
    arch_recibido,
    arch_status,
    arch_rev,
    T1.user_id AS user_id,
    concat(T6.user_nm1,' ',T6.user_ap1) AS mod_user_nombre,
    arch_actualizadoEn AS mod_fecha


            FROM vp_archivo AS T1
            LEFT JOIN vp_user AS T2 ON T1.arch_user = T2.user_id
            LEFT JOIN vp_deptos AS T3 ON T1.depto_id = T3.dep_id


            LEFT JOIN (SELECT GROUP_CONCAT(T4.inst_nombre SEPARATOR ';') AS arch_destinatario,
                       T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_destinatario AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T4
                       ON T4.inst_id = T2.inst_id
                       WHERE T2.tipo LIKE 1 and T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T4 ON T1.arch_id = T4.arch_id

                       LEFT JOIN (SELECT GROUP_CONCAT(T4.inst_nombre SEPARATOR ';') AS arch_destinatario_cc, T2.arch_id
                                  FROM vp_archivo AS T1
                                  LEFT JOIN vp_archivo_destinatario AS T2
                                  ON T1.arch_id = T2.arch_id
                                  LEFT JOIN vp_institucion AS T4
                                  ON T4.inst_id = T2.inst_id

                                  WHERE T2.tipo LIKE 2 and T2.status LIKE 1
                                  GROUP BY T1.arch_id) AS T5 ON T1.arch_id = T5.arch_id

            left join vp_user AS T6 ON T1.user_id = T6.user_id
            LEFT JOIN arch_tipo AS T7 ON T1.tipo_id = T7.tipo_id
            WHERE T1.depto_id = ? AND arch_status = 1
            ORDER BY arch_fecha DESC, arch_id DESC";
    $p = $pdo->prepare($sql);
    $p->execute(array($dep_id));
    $archivos = $p->fetchAll();
    Database::disconnect();
    return $archivos;
}

function archivos_completo(){
    $pdo = Database::connect();
    $sql = "SELECT T1.arch_id,
    arch_user,
    concat(T2.user_nm1,' ',T2.user_ap1) AS arch_user_nombre,
    depto_id, T3.dep_encargado,
    T3.dep_nm AS depto_nombre,
    T4.arch_destinatario,
    T5.arch_destinatario_cc,
    T1.tipo_id,
    T7.tipo_nombre,
    arch_fecha,
    arch_correlativo,
    arch_titulo,
    arch_original,
    arch_firmado,
    arch_recibido,
    arch_status,
    arch_rev,
    T1.user_id AS user_id,
    concat(T6.user_nm1,' ',T6.user_ap1) AS mod_user_nombre,
    arch_actualizadoEn AS mod_fecha

            FROM vp_archivo AS T1
            LEFT JOIN vp_user AS T2 ON T1.arch_user = T2.user_id
            LEFT JOIN vp_deptos AS T3 ON T1.depto_id = T3.dep_id

            LEFT JOIN (SELECT GROUP_CONCAT(T4.inst_nombre SEPARATOR ';') AS arch_destinatario,
                       T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_destinatario AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T4
                       ON T4.inst_id = T2.inst_id
                       WHERE T2.tipo LIKE 1 and T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T4 ON T1.arch_id = T4.arch_id


            LEFT JOIN (SELECT GROUP_CONCAT(T4.inst_nombre SEPARATOR ';') AS arch_destinatario_cc, T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_destinatario AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T4
                       ON T4.inst_id = T2.inst_id

                       WHERE T2.tipo LIKE 2 and T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T5 ON T1.arch_id = T5.arch_id

            left join vp_user AS T6 ON T1.user_id = T6.user_id
            LEFT JOIN arch_tipo AS T7 ON T1.tipo_id = T7.tipo_id
            WHERE arch_status = 1
            ORDER BY arch_fecha DESC, arch_id DESC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $archivos = $p->fetchAll();
    Database::disconnect();
    return $archivos;
}



function archivoById($arch_id){
    $pdo = Database::connect();
    $sql = "SELECT T1.arch_id, arch_user, concat(T2.user_nm1,' ',T2.user_ap1) AS arch_user_nombre, depto_id, T3.dep_encargado, T3.dep_nm AS depto_nombre,T4.arch_destinatario,T5.arch_destinatario_cc, T1.tipo_id,T7.tipo_nombre, arch_fecha, arch_correlativo,arch_titulo,arch_original,arch_firmado,arch_recibido,arch_status,arch_rev, T1.user_id AS user_id,  concat(T6.user_nm1,' ',T6.user_ap1) AS mod_user_nombre, arch_actualizadoEn AS mod_fecha
            FROM vp_archivo AS T1
            LEFT JOIN vp_user AS T2 ON T1.arch_user = T2.user_id
            LEFT JOIN vp_deptos AS T3 ON T1.depto_id = T3.dep_id
            LEFT JOIN (SELECT GROUP_CONCAT(T4.inst_nombre SEPARATOR ';') AS arch_destinatario,
                       T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_destinatario AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T4
                       ON T4.inst_id = T2.inst_id
                       WHERE T2.tipo LIKE 1 and T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T4 ON T1.arch_id = T4.arch_id


            LEFT JOIN (SELECT GROUP_CONCAT(T4.inst_nombre SEPARATOR ';') AS arch_destinatario_cc, T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_destinatario AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T4
                       ON T4.inst_id = T2.inst_id

                       WHERE T2.tipo LIKE 2 and T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T5 ON T1.arch_id = T5.arch_id


            left join vp_user AS T6 ON T1.user_id = T6.user_id
            LEFT JOIN arch_tipo AS T7 ON T1.tipo_id = T7.tipo_id
            WHERE T1.arch_id = ?";
    $p = $pdo->prepare($sql);
    $p->execute(array($arch_id));
    $archivo = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $archivo;
}

function archivoRecibidoNuevo(){
    if (usuarioPrivilegiado()->hasPrivilege('crearArchivo')){
        $user = User::getByUserId($_SESSION['user_id']);
        $dirname = verificar_carpeta($user->persona['dep_nm']);
        date_default_timezone_set('America/Guatemala');
        $date = date('Ymd H.i.s',time());
        if($_FILES['arch_recibido']['name']){
            //cabiar nombre del archivo que se va guardar
            $ext = strtolower(pathinfo($_FILES['arch_recibido']['name'],PATHINFO_EXTENSION));
            $allowed = array('pdf');
            $arch_recibido = $date.' - RECIBIDO '.substr(strtolower($_FILES['arch_recibido']['name']),-120); //renombrar archivo RECIBIDO
            $arch_recibido = sanear_string($arch_recibido);
            $dirname = $dirname.'/recibido';
            if(subir_archivo($_FILES['arch_recibido'],$arch_recibido,$allowed,$ext,$dirname)){
                $arch_user = $user->persona['user_id'];
                $arch_depto = $user->persona['dep_id'];
                $arch_tipo = $_POST['tipo_id'];
                $arch_fecha = fecha_ymd($_POST['arch_fecha']);
                $arch_correlativo = $_POST['arch_correlativo'];
                $arch_titulo = $_POST['arch_titulo'];
                $user_id = $user->persona['user_id'];
                $pdo = Database::connect();
                $sql = "INSERT INTO vp_archivo_recibido (arch_user,depto_id,tipo_id,arch_fecha,arch_correlativo,arch_titulo,arch_recibido,user_id) values(?, ?, ?, ?, ?, ?, ?, ?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($arch_user,$arch_depto,$arch_tipo,$arch_fecha,$arch_correlativo,$arch_titulo,$arch_recibido,$user_id));
                $arch_id = $pdo->lastInsertId();
                $remitentes = $_POST['a_recibidos'];
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                foreach ($remitentes as $c) {
                  $sql2 = "INSERT INTO vp_archivo_remitente (inst_id,arch_id) values(?,?)";
                  $q2 = $pdo->prepare($sql2);
                  $q2->execute(array($c,$arch_id));
                }

                Database::disconnect();
            }
        }
    }
}

function archivoRecibidoModificar($arch_id){
    if (usuarioPrivilegiado()->hasPrivilege('crearArchivo')){
        $user = User::getByUserId($_SESSION['user_id']);
        $dirname = verificar_carpeta($user->persona['dep_nm']);
        date_default_timezone_set('America/Guatemala');
        $date = date('Ymd H.i.s',time());
        $archivo = archivoRecibidoById($arch_id);
        $recibido_update = $archivo['arch_recibido'];
        $allowed = array('pdf');
        if($_FILES['arch_recibido']['name']){
            $ext = pathinfo($_FILES['arch_recibido']['name'],PATHINFO_EXTENSION);
            $arch_recibido = $date.' - RECIBIDO '.substr(strtolower($_FILES['arch_recibido']['name']),-120); //renombrar archivo RECIBIDO
            $arch_recibido = sanear_string($arch_recibido);
            $dirname = $dirname.'/recibido';
            if(subir_archivo($_FILES['arch_recibido'],$arch_recibido,$allowed,$ext,$dirname)){
                $recibido_update = $arch_recibido;
            }
        }
        $arch_user = $user->persona['user_id'];
        $arch_depto = $user->persona['dep_id'];
        $tipo_id = $_POST['tipo_id'];
        $arch_fecha = fecha_ymd($_POST['arch_fecha']);
        $arch_correlativo = $_POST['arch_correlativo'];
        $arch_titulo = $_POST['arch_titulo'];
        $archivoRemitentes = explode(';',$archivo['inst_nombre']);
        $remitentes = explode(';',$_POST['remitentes']);


        $insertarRemitentes = array_diff($remitentes,$archivoRemitentes);
        $eliminarRemitentes = array_diff($archivoRemitentes,$remitentes);
        $pdo = Database::connect();
        $sql = "UPDATE vp_archivo_recibido SET arch_user = ?,depto_id = ?,tipo_id = ?,arch_fecha = ?,arch_correlativo = ?,arch_titulo = ?,arch_recibido = ? WHERE arch_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($arch_user,$arch_depto,$tipo_id,$arch_fecha,$arch_correlativo,$arch_titulo,$recibido_update,$arch_id));
        $sql3 = "UPDATE vp_archivo_remitente SET status = 0 WHERE nombre = ?  and arch_id = ?";
        $s = $pdo->prepare($sql3);
        foreach ($eliminarRemitentes AS $remitente){
            if ($remitente != ''){
                $s->execute(array($remitente,$arch_id));
            }
        }
        $sql2 = "INSERT INTO vp_archivo_remitente (nombre,arch_id) values (?,?)";
        $r = $pdo->prepare($sql2);
        foreach ($insertarRemitentes  AS $remitente){
            if ($remitente != ''){
                $r->execute(array($remitente,$arch_id));
            }
        }
        Database::disconnect();
    }
}

function archivoRecibidoEliminar($arch_id){
    $user = User::getByUserId($_SESSION['user_id']);
    $user_id = $user->persona['user_id'];
    $pdo = Database::connect();
    $sql = "UPDATE vp_archivo_recibido SET user_id = ?, arch_status = 0 WHERE arch_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($user_id,$arch_id));
    Database::disconnect();
}

function archivosRecibidosDepto($dep_id){
    $pdo = Database::connect();
    $sql = "SELECT T1.arch_id, arch_user, concat(T2.user_nm1,' ',T2.user_ap1) as arch_user_nombre, depto_id, T3.dep_encargado, T3.dep_nm as depto_nombre,T4.arch_remitente, T1.tipo_id,T7.tipo_nombre, arch_fecha, arch_correlativo,arch_titulo,arch_recibido,arch_status,arch_rev, T1.user_id as user_id,  concat(T6.user_nm1,' ',T6.user_ap1) as mod_user_nombre, arch_actualizadoEn as mod_fecha
            FROM vp_archivo_recibido AS T1
            left join vp_user AS T2 on T1.arch_user = T2.user_id
            left join vp_deptos AS T3 on T1.depto_id = T3.dep_id
            LEFT JOIN (SELECT GROUP_CONCAT(T55.inst_nombre SEPARATOR ';') AS arch_remitente, T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_remitente AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T55
                       ON T2.inst_id = T55.inst_id

                       WHERE T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T4 ON T1.arch_id = T4.arch_id
            left join vp_user AS T6 on T1.user_id = T6.user_id
            LEFT JOIN arch_tipo AS T7 on T1.tipo_id = T7.tipo_id
            WHERE T1.depto_id = ? and arch_status = 1
            order by arch_fecha desc, arch_id ASC ";
    $p = $pdo->prepare($sql);
    $p->execute(array($dep_id));
    $archivos = $p->fetchAll();
    Database::disconnect();
    return $archivos;
}

function archivosRecibidosCompleto(){
    $pdo = Database::connect();
    $sql = "SELECT T1.arch_id, arch_user, concat(T2.user_nm1,' ',T2.user_ap1) as arch_user_nombre, depto_id, T3.dep_encargado, T3.dep_nm as depto_nombre,T4.arch_remitente,T1.tipo_id,T7.tipo_nombre, arch_fecha, arch_correlativo,arch_titulo,arch_recibido,arch_status,arch_rev, T1.user_id as user_id,  concat(T6.user_nm1,' ',T6.user_ap1) as mod_user_nombre, arch_actualizadoEn as mod_fecha
            FROM vp_archivo_recibido AS T1
            left join vp_user AS T2 on T1.arch_user = T2.user_id
            left join vp_deptos AS T3 on T1.depto_id = T3.dep_id
            LEFT JOIN (SELECT GROUP_CONCAT(T55.inst_nombre SEPARATOR ';') AS arch_remitente, T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_remitente AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T55
                       ON T2.inst_id = T55.inst_id


                       WHERE T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T4 ON T1.arch_id = T4.arch_id
            left join vp_user AS T6 on T1.user_id = T6.user_id
            LEFT JOIN arch_tipo AS T7 on T1.tipo_id = T7.tipo_id
            WHERE arch_status = 1
            order by arch_fecha desc, arch_id ASC ";
    $p = $pdo->prepare($sql);
    $p->execute();
    $archivos = $p->fetchAll();
    Database::disconnect();
    return $archivos;
}

function archivoRecibidoById($arch_id){
    $pdo = Database::connect();
    $sql = "SELECT T1.arch_id, arch_user, concat(T2.user_nm1,' ',T2.user_ap1) as arch_user_nombre, depto_id, T3.dep_nm as depto_nombre,T4.arch_remitente, T1.tipo_id,T7.tipo_nombre,arch_fecha, arch_correlativo,arch_titulo,arch_recibido,arch_status,arch_rev, T1.user_id,  concat(T6.user_nm1,' ',T6.user_ap1) as mod_user_nombre, arch_actualizadoEn as mod_fecha
            FROM vp_archivo_recibido AS T1
            left join vp_user AS T2 on T1.arch_user = T2.user_id
            left join vp_deptos AS T3 on T1.depto_id = T3.dep_id
            LEFT JOIN (SELECT GROUP_CONCAT(T55.inst_nombre SEPARATOR ';') AS arch_remitente, T2.arch_id
                       FROM vp_archivo AS T1
                       LEFT JOIN vp_archivo_remitente AS T2
                       ON T1.arch_id = T2.arch_id
                       LEFT JOIN vp_institucion AS T55
                       ON T2.inst_id = T55.inst_id
                       WHERE T2.status LIKE 1
                       GROUP BY T1.arch_id) AS T4 ON T1.arch_id = T4.arch_id
            left join vp_user AS T6 on T1.user_id = T6.user_id
            LEFT JOIN arch_tipo AS T7 on T1.tipo_id = T7.tipo_id
            WHERE T1.arch_id = ?
            order by arch_fecha desc, arch_id ASC ";
    $p = $pdo->prepare($sql);
    $p->execute(array($arch_id));
    $archivo = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $archivo;
}

function subir_archivo($file,$new_file_name,$allowed,$ext,$dirname){
    $file_valid = true;

    //Verificar que no hayan errores
    if(!$file['error'])
    {
        /*
         //definir tamaño maximo de archivos
        if($file['size'] > (10024000)) //can't be larger than 1 MB
        {
            echo $message = 'Tu archivo es demasiado grande.';
            $file_valid = false;
        }
        */

        //Verificar extension del archivo

        if(!in_array($ext,$allowed)){
            echo $message = 'Debe adjuntarse un archivo de tipo valido.';
            $file_valid = false;
        }

        if($file_valid){
            //moverlo a la carpeta deseada
            move_uploaded_file($file['tmp_name'], $dirname.'/'.$new_file_name);
            echo $message = 'El archivo se proceso correctamente.';
            return true;
        }else{
            return false;
        }
    }else{
        //set that to be the returned message
        echo $message = 'Lo sentimos, se produjo un error al procesar el archivo.'.$file['error'];
        return false;
    }

}

function subir_archivo_copia($file,$dirname){
    $file_valid = true;
    $allowed = array('pdf');
    if($file['name'])
    {
        //Verificar que no hayan errores
        if(!$file['error'])
        {
            //cambiar nombre del archivo que se va guardar
            date_default_timezone_set('America/Guatemala');
            $date = date('Ymd H.i.s',time());
            $ext = pathinfo($file['name'],PATHINFO_EXTENSION);
            $new_file_name = $date.' - '.substr(strtolower($file['name']),-100); //rename file
            if($file['size'] > (10024000)) //can't be larger than 1 MB
            {
                $message = 'Tu archivo es demasiado grande.';
                $file_valid = false;
            }

            //Verificar extension del archivo
            if(!in_array($ext,$allowed)){
                $message = 'Debe adjuntarse un archivo tipo pdf.';
                $file_valid = false;
            }

            if($file_valid){
                //moverlo a la carpeta deseada
                move_uploaded_file($file['tmp_name'], $dirname.'/'.$new_file_name);
                $message = 'El archivo se proceso correctamente.';
                return true;
            }else{
                return false;
            }
        }else{
            //set that to be the returned message
            $message = 'Lo sentimos, se produjo un error al procesar el archivo.';
            return false;
        }
    }else{
        echo $message = 'Debe adjuntarse el archivo original.';
        return false;
    }
}

function verificar_carpeta($dep_nm){
    $dirname = 'adjuntos/'.sanear_string($dep_nm);
    $dirname = iconv("UTF-8","Windows-1252",$dirname);
    if (!file_exists($dirname)) {
        mkdir($dirname, 0777, true);
    }
    $enviado = $dirname.'/enviado';
    $enviado = iconv("UTF-8","Windows-1252",$enviado);
    if (!file_exists($enviado)) {
        mkdir($enviado, 0777, true);
    }
    $recibido = $dirname.'/recibido';
    $recibido = iconv("UTF-8","Windows-1252",$recibido);
    if (!file_exists($recibido)) {
        mkdir($recibido, 0777, true);
    }
    return $dirname;
}


function correlativo_duplicado($arch_correlativo,$arch_id){
    $duplicado = false;
    $user = User::getByUserId($_SESSION['user_id']);
    $dep_id = $user->persona['dep_id'];
    foreach (archivos_depto($dep_id) as $archivo){
        if (strtolower($archivo['arch_correlativo']) == strtolower($arch_correlativo) && $archivo['arch_id'] != $arch_id){$duplicado=true;}
    }
    return $duplicado;
}

function correlativoRecibidoDuplicado($arch_correlativo,$arch_id){
    $duplicado = false;
    $user = User::getByUserId($_SESSION['user_id']);
    $dep_id = $user->persona['dep_id'];
    foreach (archivosRecibidosDepto($dep_id) as $archivo){
        if (strtolower($archivo['arch_correlativo']) == strtolower($arch_correlativo) && $archivo['arch_id'] != $arch_id){$duplicado=true;}
    }
    return $duplicado;
}
