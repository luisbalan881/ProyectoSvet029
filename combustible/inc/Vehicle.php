<?php

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 11:03 AM
 */
require_once ('VehicleInterface.php');
class Vehicle implements VehicleInterface
{
    public static function create(PrivilegedUser $u,$name,$line,$plate,$model,$cylinder,$fuel_id,$color,$user_id){
        if($u->hasPrivilege('crearCupon')){
            if($name != '' && $line != '' && $plate != '' && $model > 0 && $cylinder > 0 && $fuel_id > 0 && $color != '' && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO vp_vehiculo(nombre,linea,placa,modelo,cilindraje,combustible_id,color,user_id) VALUES (?,?,?,?,?,?,?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($name,$line,$plate,$model,$cylinder,$fuel_id,$color,$user_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$name,$line,$plate,$model,$cylinder,$fuel_id,$color,$status,$user_id,$vehicle_id){
        if($u->hasPrivilege('modificarCupon')){
            if($name != '' && $line != '' && $plate != '' && $model > 0 && $cylinder > 0 && $fuel_id > 0 && $color != '' && $user_id > 0 && $vehicle_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE vp_vehiculo SET nombre = ?,linea = ?,placa = ?,modelo = ?,cilindraje = ?,combustible_id = ?,color = ?,status = ?,user_id = ?
                        WHERE vehiculo_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($name,$line,$plate,$model,$cylinder,$fuel_id,$color,$status,$user_id,$vehicle_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
    public static function getByID(PrivilegedUser $u,$vehicle_id){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT vehiculo_id,T1.nombre,linea,placa,modelo,cilindraje,T1.combustible_id,T2.nombre as combustible,color,T1.status,T1.user_id
                    FROM vp_vehiculo AS T1
                    LEFT JOIN vp_combustible_tipo AS T2 on T1.combustible_id = T2.combustible_id
                    WHERE  vehiculo_id = ?";
            $p = $pdo->prepare($sql);
            $p->execute(array($vehicle_id));
            $vehicle = $p->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
            return $vehicle;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getAll(PrivilegedUser $u){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT vehiculo_id,nombre,linea,placa,modelo,cilindraje,combustible_id,color,status,user_id
                    FROM vp_vehiculo
                    ORDER BY vehiculo_id ASC";
            $p = $pdo->prepare($sql);
            $p->execute();
            $vehicles = $p->fetchAll();
            Database::disconnect();
            return $vehicles;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
}