<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 10:58 AM
 */
require_once ('DriverInterface.php');

class Driver implements DriverInterface
{
    public static function create(PrivilegedUser $u,$user,$license,$expiration_date,$user_update){
        if($u->hasPrivilege('crearCupon')){
            if($user > 0 && $license > 0 && $expiration_date != '' && $user_update > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO vp_conductor(user_id,licencia_num,licencia_cad,user_mod) VALUES (?,?,?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($user,$license,$expiration_date,$user_update));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$user,$license,$expiration_date,$status,$user_update,$driver_id){
        if($u->hasPrivilege('modificarCupon')){
            if($user > 0 && $license > 0 && $expiration_date != '' && $status >= 0 && $user_update > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE vp_conductor SET user_id = ?,licencia_num = ?,licencia_cad = ?,status = ?,user_mod = ?
                        WHERE conductor_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($user,$license,$expiration_date,$status,$user_update,$driver_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
    public static function getByID(PrivilegedUser $u,$driver_id){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT conductor_id,T1.user_id,user_nm1,user_nm2,user_ap1,user_ap2,user_puesto,licencia_num,licencia_cad,status
                    FROM vp_conductor AS T1
                    LEFT JOIN vp_user AS T2 ON T1.user_id = T2.user_id
                    WHERE  conductor_id = ?";
            $p = $pdo->prepare($sql);
            $p->execute(array($driver_id));
            $driver = $p->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
            return $driver;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
    public static function getAll(PrivilegedUser $u){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT conductor_id,T1.user_id,concat(user_nm1,' ',user_nm2,' ',user_ap1,' ',user_ap2) as nombre,user_puesto,licencia_num,licencia_cad,status
                    FROM vp_conductor AS T1
                    LEFT JOIN vp_user AS T2 ON T1.user_id = T2.user_id";
            $p = $pdo->prepare($sql);
            $p->execute();
            $drivers = $p->fetchAll();
            Database::disconnect();
            return $drivers;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
}
