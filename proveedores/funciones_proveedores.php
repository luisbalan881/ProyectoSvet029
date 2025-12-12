<?php
/**
 * User: stuart.carazo
 * Date: 2/11/2016
 * Time: 2:37 AM
 */

//funciones de proveedores
function proveedores() {
    $pdo = Database::connect();
    $sql = "SELECT prov_id,prov_nm,prov_nit,prov_direccion,prov_tel,prov_email,prov_desc,prov_status 
            FROM df_proveedor
            order by prov_status DESC,prov_id ASC";
    $p = $pdo->prepare($sql);
    $p->execute();
    $proveedores = $p->fetchAll();
    Database::disconnect();
    return $proveedores;
}

function proveedor_info($id){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT prov_id,prov_nm,prov_nit,prov_direccion,prov_tel,prov_email,prov_desc,prov_status 
            FROM df_proveedor
            WHERE prov_id = ?
            order by prov_id";
    $q = $pdo->prepare($sql);
    $q->execute(array($id));
    $proveedor = $q->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $proveedor;
}

function proveedor_duplicado($prov_nit,$prov_id){
    $duplicado = false;
    foreach (proveedores() as $proveedor){
        if ($proveedor['prov_nit'] == $prov_nit && $proveedor['prov_id'] != $prov_id){$duplicado=true;}
    }
    return $duplicado;
}

function proveedores_total() {
    $pdo = Database::connect();
    $sql ='SELECT count(prov_id) AS total FROM df_proveedor';
    $f = $pdo->prepare($sql);
    $f->execute();
    $proveedores_total = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $proveedores_total['total'];
}

function proveedores_inactivos(){
    $pdo = Database::connect();
    $sql ='SELECT count(prov_id) AS total FROM df_proveedor WHERE prov_status = 0';
    $f = $pdo->prepare($sql);
    $f->execute();
    $proveedores_inactivos = $f->fetch(PDO::FETCH_ASSOC);
    Database::disconnect();
    return $proveedores_inactivos['total'];
}

function proveedor_nuevo(){
    $prov_nm = $_POST['prov_nm'];
    $prov_desc = $_POST['prov_desc'];
    $prov_nit = $_POST['prov_nit'];
    $prov_direccion = $_POST['prov_direccion'];
    $prov_tel = $_POST['prov_tel'];
    $prov_email = $_POST['prov_email'];
    $user_id = $_SESSION['user_id'];
    $prov_status = 1;
    $duplicado = proveedor_duplicado($prov_nit,0);
    if (!$duplicado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO df_proveedor (prov_nm,prov_desc,prov_nit,prov_direccion,prov_tel,prov_email,user_id,prov_status) values(?, ?, ?, ?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($prov_nm,$prov_desc,$prov_nit,$prov_direccion,$prov_tel,$prov_email,$user_id,$prov_status));
        Database::disconnect();
    }

}

function proveedor_modificar($id){
    $prov_id = $_POST['prov_id'];
    $prov_nm = $_POST['prov_nm'];
    $prov_desc = $_POST['prov_desc'];
    $prov_nit = $_POST['prov_nit'];
    $prov_direccion = $_POST['prov_direccion'];
    $prov_tel = $_POST['prov_tel'];
    $prov_email = $_POST['prov_email'];
    $user_id = $_SESSION['user_id'];
    $prov_status = $_POST['prov_status'];
    $duplicado = proveedor_duplicado($prov_nit,$prov_id);
    if (!$duplicado){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE df_proveedor SET prov_nm = ?, prov_desc = ?, prov_nit = ?, prov_direccion = ?, prov_tel = ?, prov_email = ?, user_id = ?, prov_status = ? WHERE prov_id = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($prov_nm,$prov_desc,$prov_nit,$prov_direccion,$prov_tel,$prov_email,$user_id,$prov_status,$id));
        Database::disconnect();
    }
}
