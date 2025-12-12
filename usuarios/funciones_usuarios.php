<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 17/10/2016
 * Time: 5:24 PM
 */

function departamento_nuevo(){
    $dep_nm = $_POST['dep_nm'];
    $dep_encargado = $_POST['dep_encargado'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $sql = "INSERT INTO vp_deptos (dep_nm,dep_encargado,user_id) values(?, ?, ?)";
    $q = $pdo->prepare($sql);
    $q->execute(array($dep_nm,$dep_encargado,$user_id));
    Database::disconnect();
}

function departamento_modificar($dep_id){
    $dep_nm = $_POST['dep_nm'];
    $dep_encargado = $_POST['dep_encargado'];
    $dep_status = $_POST['dep_status'];
    $user_id = $_SESSION['user_id'];
    $pdo = Database::connect();
    $sql = "UPDATE vp_deptos SET dep_nm = ?,dep_encargado = ?,dep_status = ?,user_id = ? WHERE dep_id = ?";
    $q = $pdo->prepare($sql);
    $q->execute(array($dep_nm,$dep_encargado,$dep_status,$user_id,$dep_id));
    Database::disconnect();
}

function departamentoById($dep_id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT T1.dep_id, dep_nm,dep_encargado as encargado_id, concat(T2.user_nm1,' ',T2.user_ap1) as dep_encargado, dep_status
            FROM vp_deptos as T1
            LEFT JOIN vp_user as T2 on T1.dep_encargado = T2.user_id
            WHERE T1.dep_id = ?";
    $r = $pdo->prepare($sql);
    $r->execute(array($dep_id));
    $departamento = $r->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $departamento;
}
