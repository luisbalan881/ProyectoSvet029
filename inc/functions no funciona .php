<?php
require_once 'Database.php';
require_once 'User.php';
require_once 'Role.php';
require_once 'PrivilegedUser.php';

function sec_session_start() {
    $session_name = 'vicesis_sec_session';   // Set a custom session name
    $secure = false;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
                              $cookieParams["path"],
                              $cookieParams["domain"],
                              $secure,
                              $httponly);
    // Sets the session name to the one set above.
    session_name($session_name);
    session_start();            // Start the PHP session
    //session_regenerate_id(true);    // regenerated the session, delete the old one.
}


function login($email, $password) {
    // Using prepared statements means that SQL injection is not possible.
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT user_id, user_nm, user_pass, user_salt, role_id,user_mail
            FROM vp_user
            WHERE user_mail = ? and user_status like 1
            LIMIT 1';
    $u = $pdo->prepare($sql);
    if ($u) {
        $u->execute(array($email));
        $persona = $u->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        $user_id = $persona['user_id'];
        $username = $persona['user_nm'];
        $db_password = $persona['user_pass'];
        $salt = $persona['user_salt'];
        $user_role = $persona['role_id'];
        $user_email = $persona['user_mail'];
        // hash the password with the unique salt.
        $password = hash('sha512', $password . $salt);
        if ($u->rowCount() == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts

            if (checkbrute($user_id) == true) {
                // Account is locked
                // Send an email to user saying their account is locked
                return false;
            } else {
                // Check if the password in the database matches
                // the password the user submitted.
                if ($db_password == $password) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    // XSS protection as we might print this value
                    $username = preg_replace("/[^a-zA-Z0-9_\-]+/",
                                             "",
                                             $username);
                    $_SESSION['username'] = $username;
                    $_SESSION['username'] = $username;
                    $_SESSION['login_string'] = hash('sha512',
                              $password . $user_browser);
                    $_SESSION['role'] = $user_role;
                    $_SESSION['email'] = $user_email;
                    // Login successful.
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $login_computer = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO vp_login(user_id, login_computer,login_ip)
                            VALUES (?, ?,?)";
                    $log = $pdo->prepare($sql);
                    $log->execute(array($user_id,$login_computer,$ip));
                    Database::disconnect();
                    return true;
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    date_default_timezone_set('America/Guatemala');
                    $now = time();
                    $pdo = Database::connect();
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $sql = "INSERT INTO vp_loginhistorial(user_id, login_fecha)
                                    VALUES (?, ?)";
                    $log = $pdo->prepare($sql);
                    $log->execute(array($user_id,$now));
                    Database::disconnect();
                    return false;
                }
            }
        } else {
            // No user exists.
            return false;
        }
    }
}

function checkbrute($user_id) {
    // Get timestamp of current time
    date_default_timezone_set('America/Guatemala');
    $now = time();
    // All login attempts are counted from the past 2 hours.
    $valid_attempts = $now - (2 * 60 * 60);
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = 'SELECT login_fecha
            FROM vp_loginhistorial
            WHERE user_id = ?
            AND login_fecha > ?';
    $u = $pdo->prepare($sql);
    $sql2 = 'SELECT user_fechahora, user_status
             FROM vp_user
             WHERE user_id = ?';
    $user = $pdo->prepare($sql2);
    $user->execute(array($user_id));
    $lastUpdate = $user->fetch(PDO::FETCH_ASSOC);
    if ($lastUpdate['user_status'] == 1 ){
        ((strtotime($lastUpdate['user_fechahora']) > $valid_attempts)? ($valid_attempts = strtotime($lastUpdate['user_fechahora'])):null);
    }
    if ($u) {
        $u->execute(array($user_id,$valid_attempts));
        $checkBrute = $u->fetchAll();
        // If there have been more than 5 failed logins
        if (count($checkBrute) >= 5) {
            $sql3 = 'UPDATE vp_user SET user_status = 0 WHERE user_id = ?';
            $disable = $pdo->prepare($sql3);
            $disable->execute(array($user_id));
            return true;
        } else {
            return false;
        }
    }
    Database::disconnect();
}

function login_check() {
    $password = '';
    // Check if all session variables are set
    if (isset($_SESSION['user_id'],
              $_SESSION['username'],
              $_SESSION['login_string'],
              $_SESSION['role'],
              $_SESSION['email'])) {

        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $username = $_SESSION['username'];
        $user_role = $_SESSION['role'];

        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'SELECT user_pass
                FROM vp_user
                WHERE user_id = ? and user_status like 1
                LIMIT 1';
        $u = $pdo->prepare($sql);
        if ($u) {
            // Bind "$user_id" to parameter.
            $u->execute(array($user_id));
            $persona = $u->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
            if ($u->rowCount() == 1) {
                // If the user exists get variables from result.
                $password = $persona['user_pass'];
                $login_check = hash('sha512', $password . $user_browser);

                if ($login_check == $login_string) {
                    // Logged In!!!!
                    return true;
                } else {
                    // Not logged in
                    return false;
                }
            } else {
                // Not logged in
                return false;
            }
        } else {
            // Not logged in
            return false;
        }
    } else {
        // Not logged in
        return false;
    }
}

function esc_url($url) {

    if ('' == $url) {
        return $url;
    }

    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);

    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;

    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }

    $url = str_replace(';//', '://', $url);

    $url = htmlentities($url);

    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);

    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

//funciones de personal
function personas(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,user_vid,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,user_cui,T1.dep_id,dep_nm,user_puesto,user_nom,user_status,T1.role_id,role_nm,verificacion,
            CONCAT(grupo_id,subgrupo_id,renglon_Id)as renglon,fotografia
            FROM vp_user AS T1
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
            LEFT JOIN vp_user_datos_laborales AS T4 ON T1.user_id=T4.user_id
            order by user_status DESC, user_nm1 ASC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}
function personas_por_renglon_029(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,user_vid,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,user_cui,T1.dep_id,dep_nm,user_puesto,user_nom,user_status,T1.role_id,role_nm,verificacion,
            CONCAT(grupo_id,subgrupo_id,renglon_Id)as renglon,fotografia
            FROM vp_user AS T1
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
            LEFT JOIN vp_user_datos_laborales AS T4 ON T1.user_id=T4.user_id
            WHERE CONCAT(grupo_id,subgrupo_id,renglon_Id) = ?
            order by user_status DESC";
    $p = $pdo->prepare($sql);
    $p->execute(array('029'));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}
function personas_por_renglon_011_022(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,user_vid,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,user_cui,T1.dep_id,dep_nm,user_puesto,user_nom,user_status,T1.role_id,role_nm,verificacion,
            CONCAT(grupo_id,subgrupo_id,renglon_Id)as renglon,fotografia
            FROM vp_user AS T1
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
            LEFT JOIN vp_user_datos_laborales AS T4 ON T1.user_id=T4.user_id
            WHERE CONCAT(grupo_id,subgrupo_id,renglon_Id) = ? OR CONCAT(grupo_id,subgrupo_id,renglon_Id) = ?
            order by user_status DESC";
    $p = $pdo->prepare($sql);
    $p->execute(array('011','022'));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}

function personas_depto($dep_id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,user_vid,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,user_cui,T1.dep_id,dep_nm,user_puesto,user_nom,user_status,T1.role_id,role_nm
            FROM vp_user AS T1
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
            WHERE T1.dep_id = ? AND user_status = 1
            order by user_nm1,user_ap1";
    $p = $pdo->prepare($sql);
    $p->execute(array($dep_id));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}


function personas_por_mes($fechai, $fechaf){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id,user_vid,user_mail,ext_id,user_pref,user_nm1,user_nm2,user_ap1,user_ap2,user_cui,T1.dep_id,dep_nm,user_puesto,user_nom,T1.user_status,T1.role_id,role_nm
            FROM vp_user AS T1
            LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
            LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
            LEFT JOIN vp_user_status AS T4 ON T1.user_id = T4.user_id

            WHERE (T4.fecha_status BETWEEN ? AND ?)
            order by user_nm1,user_ap1";
    $p = $pdo->prepare($sql);
    $p->execute(array($fechai, $fechaf));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}

function personas_por_mes_horarios_copia($fechai, $fechaf){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT DISTINCT T1.user_id, user_vid, user_mail, ext_id, user_pref, user_nm1, user_nm2, user_ap1, user_ap2, T1.dep_id, dep_nm, user_puesto, user_nom, T1.role_id, role_nm
FROM vp_user AS T1
LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
INNER JOIN vp_user_horario AS T4 ON T1.user_vid = T4.user_id_huella
WHERE T4.horario
BETWEEN  ?
AND  ?
GROUP BY DATE( T4.horario ) , T1.user_id";
    $p = $pdo->prepare($sql);
    $p->execute(array($fechai, $fechaf));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}

function personas_por_mes_horarios($fechai, $fechaf){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT DISTINCT T1.user_id, T1.user_vid, user_mail, ext_id, user_pref, user_nm1, user_nm2, user_ap1, user_ap2, T1.dep_id, dep_nm, user_puesto, user_nom, T1.role_id, role_nm
FROM vp_user AS T1
LEFT JOIN vp_deptos AS T2 ON T1.dep_id = T2.dep_id
LEFT JOIN vp_roles AS T3 ON T1.role_id = T3.role_id
LEFT JOIN vp_user_horario_general AS T4 ON T1.user_vid = T4.user_vid
WHERE MONTH(T4.fecha_laboral) = ? AND YEAR(T4.fecha_laboral)=?
GROUP BY T4.fecha_laboral , T1.user_id";
    $p = $pdo->prepare($sql);
    $p->execute(array($fechai, $fechaf));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}
function personas_por_semana_horario_especial($semana,$year){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT CONCAT(T1.user_nm1, ' ', T1.user_nm2, ' ', T1.user_ap1, ' ', T1.user_ap2) as nombre,T1.user_id,T1.user_vid
            FROM vp_user AS T1
            INNER JOIN vp_user_horario_especial_grupo AS T2 ON T2.user_id=T1.user_id
            INNER JOIN vp_user_horario_semana_detalle AS T3 ON T3.grupo=T2.horario_especial_id

            WHERE T3.semana=? AND T3.year=?
            GROUP BY T1.user_id";
    $p = $pdo->prepare($sql);
    $p->execute(array($semana,$year));
    $personas = $p->fetchAll();
    Database::disconnect();
    return $personas;
}

function personas_por_grupo_horario_especial()
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT CONCAT( T1.user_nm1,  ' ', T1.user_nm2,  ' ', T1.user_ap1,  ' ', T1.user_ap2 ) AS nombre, T1.user_id, T1.user_vid, T1.user_status, T3.horario_especial_desc
          FROM vp_user AS T1
          INNER JOIN vp_user_horario_especial_grupo AS T2 ON T2.user_id = T1.user_id
          INNER JOIN vp_horario_especial_grupo AS T3 ON T2.horario_especial_id = T3.horario_especial_id";
  $p = $pdo->prepare($sql);
  $p->execute(array());
  $personas = $p->fetchAll();
  Database::disconnect();
  return $personas;
}

function get_semanas_por_year($year,$user_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM vp_user_horario_semana AS T1";
  $p = $pdo->prepare($sql);
  $p->execute(array());
  $personas = $p->fetchAll();
  Database::disconnect();
  return $personas;
}

function departamentos(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.dep_id, dep_nm,dep_encargado as encargado_id,concat(T2.user_nm1,' ',T2.user_ap1) as dep_encargado, dep_status
            FROM vp_deptos as T1
            LEFT JOIN vp_user as T2 on T1.dep_encargado = T2.user_id
            order by dep_nm ASC ";
    $r = $pdo->prepare($sql);
    $r->execute();
    $departamentos = $r->fetchAll();
    Database::disconnect();
    return $departamentos;
}

// fechas de bloqueo
function fechas_bloqueada1(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM da_fechas where id_fecha=1";
    $r = $pdo->prepare($sql);
    $r->execute();
    $departamentos = $r->fetch();
    Database::disconnect();
    return $departamentos;
}


function fechas_bloqueada2(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM da_fechas where id_fecha=2";
    $r = $pdo->prepare($sql);
    $r->execute();
    $departamentos = $r->fetch();
    Database::disconnect();
    return $departamentos;
}


function fechas_bloqueada3(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM da_fechas where id_fecha=3";
    $r = $pdo->prepare($sql);
    $r->execute();
    $departamentos = $r->fetch();
    Database::disconnect();
    return $departamentos;
}

function fechas(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM da_fechas";
    $r = $pdo->prepare($sql);
    $r->execute();
    $fechas = $r->fetchAll();
    Database::disconnect();
    return $fechas;
}
// usuarios
function usuarios(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_user order by user_nm ASC ";
    $r = $pdo->prepare($sql);
    $r->execute();
    $usuarios = $r->fetchAll();
    Database::disconnect();
    return $usuarios;
}


function vehiculos(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT vehiculo_id , nombre, linea, placa,color  FROM vp_vehiculo WHERE status = 1";
    
        
    
    $r = $pdo->prepare($sql);
    $r->execute();
    $vehiculos = $r->fetchAll();
    Database::disconnect();
    return $vehiculos;
}


function get_departamento_by_id($dep_id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_deptos WHERE dep_id=? ";
    $r = $pdo->prepare($sql);
    $r->execute(array($dep_id));
    $departamento = $r->fetch();
    Database::disconnect();
    return $departamento;
}

function get_nacionalidad_by_id($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_nacionalidad WHERE nac_id=? ";
    $r = $pdo->prepare($sql);
    $r->execute(array($id));
    $nac = $r->fetch();
    Database::disconnect();
    return $nac;
}

function tipos_dias_laborales(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_catalogo_dia_laboral
            where dia_laboral_id <> 0 AND dia_laboral_id <> 1 AND dia_laboral_id <> 3
            AND dia_laboral_id <> 5";
    $r = $pdo->prepare($sql);
    $r->execute();
    $dias = $r->fetchAll();
    Database::disconnect();
    return $dias;
}

function tipos_dias_laborales_suspencion(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_catalogo_dia_laboral
            where dia_laboral_id = 2 OR dia_laboral_id = 5 OR dia_laboral_id = 6 ";
    $r = $pdo->prepare($sql);
    $r->execute();
    $dias = $r->fetchAll();
    Database::disconnect();
    return $dias;
}

function tipos_dias_laborales_suspencion_igss(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_catalogo_dia_laboral
            where dia_laboral_id <> 0 AND dia_laboral_id <> 1 AND dia_laboral_id <> 3 AND dia_laboral_id <> 7 AND dia_laboral_id <> 50";
    $r = $pdo->prepare($sql);
    $r->execute();
    $dias = $r->fetchAll();
    Database::disconnect();
    return $dias;
}


function roles(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT role_id, role_nm
            FROM vp_roles AS T1
            order by role_id";
    $p = $pdo->prepare($sql);
    $p->execute();
    $roles = $p->fetchAll();
    Database::disconnect();
    return $roles;
}

//arreglar

function permisos(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT perm_id, perm_desc
            FROM vp_permisos AS T1
            order by perm_id";
    $p = $pdo->prepare($sql);
    $p->execute();
    $permisos = $p->fetchAll();
    Database::disconnect();
    return $permisos;
}

//VERIFICAR ROL Y PERMISO
function verificar_per_rol($rol, $per){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT count(*) as conteo from vp_role_perm WHERE role_id=? and perm_id=?";
    $p = $pdo->prepare($sql);
    $p->execute(array($rol, $per));
    $per_rol = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    $conteo = $per_rol['conteo'];
    return $conteo;
}
// usuarios sub permisos por departamentos

function get_sub_permiso_dep($dep_id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT sub_perm_id, dep_id, sub_perm_nm
            FROM vp_sub_perm_dep AS T1
            WHERE dep_id=?
            order by sub_perm_id";
    $p = $pdo->prepare($sql);
    $p->execute(array($dep_id));
    $subperm = $p->fetchAll();
    Database::disconnect();
    return $subperm;
}

function get_permisos_por_permiso($permiso){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.permiso_por_permiso_id,T1.permiso_por_permiso_nm
            FROM vp_permiso_por_permiso AS T1
            INNER JOIN vp_permisos AS T2 ON T1.perm_id=T2.perm_id
            WHERE T2.perm_desc=?";
    $p = $pdo->prepare($sql);
    $p->execute(array($permiso));
    $subperm = $p->fetchAll();
    Database::disconnect();
    return $subperm;
}

function get_personas_por_permiso($permiso){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.user_id, CONCAT(T1.user_nm1, ' ', T1.user_nm2,' ',T1.user_ap1,' ', T1.user_ap2) AS NOMBRE
            FROM vp_user AS T1
            INNER JOIN vp_roles AS T2 ON T1.role_id=T2.role_id
            INNER JOIN vp_role_perm AS T3 ON T3.role_id=T2.role_id
            INNER JOIN vp_permisos AS T4 ON T4.perm_id=T3.perm_id
            WHERE T4.perm_desc=? AND T1.user_status=? AND T1.dep_id<>?";
    $p = $pdo->prepare($sql);
    $p->execute(array($permiso,1,9));
    $subperm = $p->fetchAll();
    Database::disconnect();
    return $subperm;
}


//VERIFICAR ROL Y PERMISO
function verificar_subperm_user($subper, $user){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT count(*) as conteo from vp_sub_perm_user WHERE sub_perm_id=? and user_id=?";
    $p = $pdo->prepare($sql);
    $p->execute(array($subper, $user));
    $subper_user = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    $conteo = $subper_user['conteo'];
    return $conteo;
}

function verificar_permiso_por_permiso_user($permiso, $user){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT count(*) as conteo from vp_permiso_por_permiso_user WHERE permiso_por_permiso_id=? and user_id=?";
    $p = $pdo->prepare($sql);
    $p->execute(array($permiso, $user));
    $subper_user = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    $conteo = $subper_user['conteo'];
    return $conteo;
}

function verificar_exist_sub_perm($dep_id){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT count(*) as conteo from vp_sub_perm_dep WHERE dep_id=?";
  $p = $pdo->prepare($sql);
  $p->execute(array($dep_id));
  $veri = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  $conteo = $veri['conteo'];
  return $conteo;
}


//VERIFICAR SI USUARIO ES EL DIRECTOR DEL DEPARTAMENTO

function verificar_director($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT COUNT(*) as conteo from vp_deptos where dep_encargado = ?";
    $p = $pdo->prepare($sql);
    $p->execute(array($id));
    $per_rol = $p->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();

    $conteo = $per_rol['conteo'];
    return $conteo;
}


function tipo_de_horarios(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT hora_id, HOUR(hora_inicio) AS h_i, HOUR(hora_final) AS h_f
            FROM vp_catalogo_horario AS T1
            order by hora_id";
    $p = $pdo->prepare($sql);
    $p->execute();
    $permisos = $p->fetchAll();
    Database::disconnect();
    return $permisos;
}

function get_renglones($grupo)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT CONCAT(r1.grupo_id, r2.subgrupo_id, r3.renglon_id) AS renglon, r3.renglon_nm
FROM vp_catalogo_grupo_gasto r1
INNER JOIN vp_catalogo_subgrupo_gasto r2 ON r2.grupo_id=r1.grupo_id INNER JOIN vp_renglon r3 ON r3.subgrupo_id=r2.subgrupo_id
WHERE r3.grupo_id=?";
  $p = $pdo->prepare($sql);
  $p->execute(array($grupo));
  $renglones = $p->fetchAll();
  Database::disconnect();
  return $renglones;
}
function get_renglones_011_022($grupo)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT CONCAT(r1.grupo_id, r2.subgrupo_id, r3.renglon_id) AS renglon, r3.renglon_nm
FROM vp_catalogo_grupo_gasto r1
INNER JOIN vp_catalogo_subgrupo_gasto r2 ON r2.grupo_id=r1.grupo_id INNER JOIN vp_renglon r3 ON r3.subgrupo_id=r2.subgrupo_id
WHERE r3.grupo_id=? AND CONCAT(r1.grupo_id, r2.subgrupo_id, r3.renglon_id)=? OR CONCAT(r1.grupo_id, r2.subgrupo_id, r3.renglon_id)=?";
  $p = $pdo->prepare($sql);
  $p->execute(array($grupo,'011','022'));
  $renglones = $p->fetchAll();
  Database::disconnect();
  return $renglones;
}
function get_renglones_029($grupo)
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT CONCAT(r1.grupo_id, r2.subgrupo_id, r3.renglon_id) AS renglon, r3.renglon_nm
FROM vp_catalogo_grupo_gasto r1
INNER JOIN vp_catalogo_subgrupo_gasto r2 ON r2.grupo_id=r1.grupo_id INNER JOIN vp_renglon r3 ON r3.subgrupo_id=r2.subgrupo_id
WHERE r3.grupo_id=? AND CONCAT(r1.grupo_id, r2.subgrupo_id, r3.renglon_id)=?";
  $p = $pdo->prepare($sql);
  $p->execute(array($grupo,'029'));
  $renglones = $p->fetchAll();
  Database::disconnect();
  return $renglones;
}

function get_nacionalidades()
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT nac_id, gentilicio FROM vp_nacionalidad";
  $p = $pdo->prepare($sql);
  $p->execute();
  $n = $p->fetchAll();
  Database::disconnect();
  return $n;
}

function get_genero()
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM vp_catalogo_genero";
  $p = $pdo->prepare($sql);
  $p->execute();
  $n = $p->fetchAll();
  Database::disconnect();
  return $n;
}

function get_renglon_by_id($g,$s,$r)
{

    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM vp_renglon WHERE grupo_id=? AND subgrupo_id=? AND renglon_id=?";
    $p = $pdo->prepare($sql);
    $p->execute(array($g,$s,$r));
    $n = $p->fetch();
    Database::disconnect();
    return $n;

}

function get_estado_civil()
{
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM vp_catalogo_estado_civil";
  $p = $pdo->prepare($sql);
  $p->execute();
  $n = $p->fetchAll();
  Database::disconnect();
  return $n;
}


//fin

function usuarioPrivilegiado(){
    $u = PrivilegedUser::getByUserId($_SESSION["user_id"]);
    return $u;
}

function permiso_dep($permiso){
  $us = $_SESSION["user_id"];
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT count(*) as conteo from vp_sub_perm_user WHERE sub_perm_id=? and user_id=?";
  $p = $pdo->prepare($sql);
  $p->execute(array($permiso, $us));
  $p_u = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  $conteo = $p_u['conteo'];
  if($conteo > 0)
  {
    return true;
  }
  else {
    return false;
  }
}

function permiso_perm($permiso){
  $us = $_SESSION["user_id"];
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT count(*) as conteo from vp_permiso_por_permiso_user WHERE permiso_por_permiso_id=? and user_id=?";
  $p = $pdo->prepare($sql);
  $p->execute(array($permiso, $us));
  $p_u = $p->fetch(PDO::FETCH_ASSOC);
  Database::disconnect();

  $conteo = $p_u['conteo'];
  if($conteo > 0)
  {
    return true;
  }
  else {
    return false;
  }
}

function get_literales_029(){
  $pdo = Database::connect();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $sql = "SELECT * FROM vp_catalogo_literal_029";
  $p = $pdo->prepare($sql);
  $p->execute();
  $l= $p->fetchAll();
  Database::disconnect();
  return $l;
}

function tipo_viaticos()   // agregar esto
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM vs_tipo_viatico where dia<=2";

$p = $pdo->prepare($sql);
$p->execute();
$lista1 = $p->fetchAll();
Database::disconnect();
return $lista1;
}


function tipo_viaticos2()   // agregar esto
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM vs_tipo_viatico where  dia>2";

$p = $pdo->prepare($sql);
$p->execute();
$lista1 = $p->fetchAll();
Database::disconnect();
return $lista1;
}

function periodo_user($id)   // periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$sql = "SELECT rrhh_periodo_usuario.id_periodo_user,rrhh_periodo_usuario.status, rrhh_periodo_usuario.dias_consumidos, rrhh_periodo.año, (20-rrhh_periodo_usuario.dias_consumidos) as dias_pendientes FROM `rrhh_periodo_usuario`  
//join rrhh_periodo
//on rrhh_periodo_usuario.id_periodo=rrhh_periodo.id_periodo
//where rrhh_periodo_usuario.id_usuario=?  order by rrhh_periodo_usuario.fecha_inicial ASC" ;

$sql = " SELECT status,id_periodo_user, dias_consumidos, año FROM `rrhh_periodo_usuario`  
where id_usuario=?  order by fecha_inicial ASC" ;

$p = $pdo->prepare($sql);
$p->execute(array($id));
$lista1 = $p->fetchAll();
Database::disconnect();
return $lista1;
}


function periodo_user1($id)   // periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$sql = "SELECT rrhh_periodo_usuario.id_periodo_user,rrhh_periodo_usuario.status, rrhh_periodo_usuario.dias_consumidos, rrhh_periodo.año, (20-rrhh_periodo_usuario.dias_consumidos) as dias_pendientes FROM `rrhh_periodo_usuario`  
//join rrhh_periodo
//on rrhh_periodo_usuario.id_periodo=rrhh_periodo.id_periodo
//where rrhh_periodo_usuario.id_usuario=?  order by rrhh_periodo_usuario.fecha_inicial ASC" ;

$sql = " SELECT MAX(id_solicitud), status FROM `rrhh_solicitud`  
where id_user_solicita=? and status=1" ;

$p = $pdo->prepare($sql);
$p->execute(array($id));
$lista1 = $p->fetch(PDO::FETCH_ASSOC);  //$lista1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $lista1;
}




function solicitudes_pases($id)   // periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM `rrhh_solicitud_salida` where id_solicitud_salida=?";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$lista1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $lista1;


}





function periodo_user_dias_consumidos($id)   // periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT dias_consumidos FROM `rrhh_periodo_usuario` where id_usuario=? and status =1 order by fecha_inicial ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$lista1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $lista1;


}

function periodo_user_dias_restantes($id)   // periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT (20 - dias_consumidos) as dias_restantes FROM `rrhh_periodo_usuario` where id_usuario=? and status =1 order by fecha_inicial ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$restantes = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $restantes;


}


function periodo_user_fecha_inicio($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT fecha_inicial FROM `rrhh_periodo_usuario` where id_usuario=? and status =1 order by fecha_inicial ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f1;


}


function periodo_user_fecha_fin($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT fecha_final_periodo FROM `rrhh_periodo_usuario` where id_usuario=? and status =1 order by fecha_inicial ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f1;


}

// cuery para llevar el conteo de dias que 
// SELECT (DATEDIFF( now(),fecha_inicial)*0.055) as dias FROM rrhh_periodo_usuario where id_usuario=189 and status=1 ORDER BY fecha_inicial DESC


function año_periodo_user($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT año, id_periodo_user FROM `rrhh_periodo_usuario` where id_usuario=? and status =1 order by fecha_inicial ASC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f1;


}



function periodo_calculo_dia_permitido($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT ROUND(((DATEDIFF( now(),fecha_inicial))*0.0549)) as dias FROM rrhh_periodo_usuario where id_usuario=? and status=1 ORDER BY fecha_inicial DESC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f1;


}

function periodo_calculo_dia_permitido2($id)   // calculo de dias acumulados menos los dias ya emitidos
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT ((DATEDIFF( now(),fecha_inicial))*0.0549)-dias_consumidos as dias FROM rrhh_periodo_usuario where id_usuario=? and status=1 ORDER BY fecha_inicial DESC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f1;


}



function periodo_calculo_periodo($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT ROUND(((DATEDIFF( fecha_final_periodo,fecha_inicial))*0.0549)) as dias2 FROM rrhh_periodo_usuario where id_usuario=? and status=1 ORDER BY fecha_inicial DESC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f1 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f1;


}

function periodo_calculo_pendientes($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$sql = "SELECT ROUND((((DATEDIFF( fecha_final_periodo,fecha_inicial)+1)*0.0547945205479452)-dias_consumidos)) as pendientes FROM rrhh_periodo_usuario where id_usuario=? and status=1 ORDER BY fecha_inicial DESC";
//$sql = "SELECT (((DATEDIFF( fecha_final_periodo,fecha_inicial)+1)*0.0548)-dias_consumidos) as pendientes FROM rrhh_periodo_usuario where id_usuario=? and status=1 ORDER BY fecha_inicial DESC";
$sql = "SELECT (((DATEDIFF( fecha_final_periodo,fecha_inicial))*0.0549)-dias_consumidos) as pendientes FROM rrhh_periodo_usuario where id_usuario=? and status=1 ORDER BY fecha_inicial DESC";

$p = $pdo->prepare($sql);
$p->execute(array($id));
$f3 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f3;


}


function ver_status_solicitud($id)   // fecha de inicio de periodos disponibles por usuario con status 1
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//$sql = "SELECT max(id_solicitud) , status FROM `rrhh_solicitud` where id_user_solicita = ?  ORDER BY `id_solicitud`  ASC";
$sql = "SELECT id_solicitud, status FROM rrhh_solicitud WHERE  id_solicitud= (SELECT max(id_solicitud)  FROM `rrhh_solicitud` where id_user_solicita = ?  ORDER BY `id_solicitud`  ASC)";

$p11 = $pdo->prepare($sql);
$p11->execute(array($id));
$f11 = $p11->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $f11;


}

/*

function get_sub_permiso_dep($dep_id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT sub_perm_id, dep_id, sub_perm_nm
            FROM vp_sub_perm_dep AS T1
            WHERE dep_id=?
            order by sub_perm_id";
    $p = $pdo->prepare($sql);
    $p->execute(array($dep_id));
    $subperm = $p->fetchAll();
    Database::disconnect();
    return $subperm;
}
*/



function tipo_viaticos3()   // agregar esto
{
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM vs_tipo_viatico where tipo=1 ";
$p = $pdo->prepare($sql);
$p->execute();
$lista1 = $p->fetchAll();
Database::disconnect();
return $lista1;
}

//

function get_solicitud_by_id_t($solicitud){   
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT sum(vs_tipo_viatico.valor2) as total from vs_tipo_viatico join vs_detalle on vs_detalle.id_tipo = vs_tipo_viatico.id_tipo where vs_detalle.id_nombramiento = ? AND vs_detalle.dia <3 ";

$p = $pdo->prepare($sql);
$p->execute(array($solicitud));
$solicitud8 = $p->fetch(PDO::FETCH_ASSOC);
Database::disconnect();
return $solicitud8;

}


//





function periodos()   // rrh periodos de  vacaciones 
{


$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "SELECT * FROM rh_periodo_laboral";

$p = $pdo->prepare($sql);
$p->execute();
$lista1 = $p->fetchAll();
Database::disconnect();
return $lista1;
}



function pathRoot(){
    $pathRoot = '/herramientas';
    return $pathRoot;
}

function unauthorized(){
    $unauthorized = '/inc/401.php';
    return $unauthorized;
}

function unauthorizedModal(){
    $unauthorized = '../inc/401.php';
    return $unauthorized;
}

function fecha_dmy($fecha){
    $fecha = date("d-m-Y",strtotime($fecha));
    return $fecha;
}

function fecha_ymd($fecha){
    $fecha = date("Y-m-d",strtotime($fecha));
    return $fecha;
}

function sanear_string($string)
{

    $string = trim($string);

    $string = str_replace(
        array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );

    $string = str_replace(
        array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );

    $string = str_replace(
        array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );

    $string = str_replace(
        array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );

    $string = str_replace(
        array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );

    $string = str_replace(
        array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );

    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "<code>", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":"),
        '',
        $string
    );


    return $string;
}
