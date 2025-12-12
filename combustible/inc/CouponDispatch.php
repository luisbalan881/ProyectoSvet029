<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 10:58 AM
 */
require_once ('CouponDispatchInterface.php');
class CouponDispatch implements CouponDispatchInterface
{
    public static function create(PrivilegedUser $u,$date,$coupon_key,$vehicle_id,$driver_id,$user,$km_start,$km_end,$consumed_fuel,$quantity,$user_id){
        if($u->hasPrivilege('crearCupon')){
            if($date != '' && $coupon_key >= 0 &&  $vehicle_id > 0 && $driver_id > 0 && $user_id > 0 && $quantity >= 1){
                $coupons_next = CouponDispatch::getNextAll($u);
                $coupon_end = $coupon_key + $quantity;
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO df_cupon_egr(fecha,cupon_ing_id,vehiculo_id,conductor_id,usuario_id,km_inicial,km_final,galones_consumidos,user_id) VALUES (?,?,?,?,?,?,?,?,?)";
                $p = $pdo->prepare($sql);
                for($id = $coupon_key; $id < $coupon_end;$id++ ){
                    $p->execute(array($date,$coupons_next[$id]['cupon_ing_id'],$vehicle_id,$driver_id,$user,$km_start,$km_end,$consumed_fuel,$user_id));
                }
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$date,$coupon_id,$vehicle_id,$driver_id,$user,$km_start,$km_end,$consumed_fuel,$status,$user_id,$coupon_dispatch_id){
        if($u->hasPrivilege('modificarCupon')){
            if($date != '' && $coupon_id > 0 &&  $vehicle_id > 0 && $driver_id > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_cupon_egr SET fecha = ?,cupon_ing_id = ?,vehiculo_id = ?,conductor_id = ?,usuario_id = ?,km_inicial = ?,km_final = ?,galones_consumidos = ?,status = ?,user_id = ?
                        WHERE cupon_egr_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($date,$coupon_id,$vehicle_id,$driver_id,$user,$km_start,$km_end,$consumed_fuel,$status,$user_id,$coupon_dispatch_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
    public static function getByID(PrivilegedUser $u,$coupon_dispatch_id){
        if($u->hasPrivilege('leerCupon')){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT cupon_egr_id,fecha,T1.cupon_ing_id,vehiculo_id,conductor_id,usuario_id,coalesce(km_inicial,0) as km_inicial,coalesce(km_final,0) as km_final,coalesce(galones_consumidos,0),(km_final-km_inicial) AS km_recorridos,galones_consumidos,(galones_consumidos/(km_final-km_inicial)) as km_galon,T1.status,num,monto,T1.user_id
                        FROM df_cupon_egr AS T1
                        LEFT JOIN df_cupon_ing AS T2 ON T1.cupon_ing_id = T2.cupon_ing_id
                        WHERE cupon_egr_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($coupon_dispatch_id));
                $coupon_dispatch = $p->fetch(PDO::FETCH_ASSOC);
                Database::disconnect();
                return $coupon_dispatch;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getByVehicleID(PrivilegedUser $u,$vehicle_id,$date_start,$date_end){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT cupon_egr_id,fecha,T1.cupon_ing_id,num,monto,vehiculo_id,conductor_id,usuario_id,dep_nm,concat(T3.user_nm1,' ',T3.user_nm2,' ',T3.user_ap1,' ',T3.user_ap2) as usuario_nombre,coalesce(km_inicial,0) as km_inicial,coalesce(km_final,0) as km_final,coalesce(galones_consumidos,0) as galones_consumidos,(km_final-km_inicial) AS km_recorridos,COALESCE((galones_consumidos/(km_final-km_inicial)),0) as km_galon,T1.status,T1.user_id
                        FROM df_cupon_egr AS T1
                        LEFT JOIN df_cupon_ing AS T2 ON T1.cupon_ing_id = T2.cupon_ing_id
                        LEFT JOIN vp_user AS T3 on T1.usuario_id = T3.user_id
                        LEFT JOIN vp_deptos AS T4 on T3.dep_id = T4.dep_id
                        WHERE vehiculo_id = ? and T1.status like 1 and T1.fecha >= ? and T1.fecha <= ?
                        ORDER BY YEAR(fecha) desc, MONTH(fecha) desc, usuario_id asc, num asc";
            $p = $pdo->prepare($sql);
            $p->execute(array($vehicle_id,$date_start,$date_end));
            $coupon_dispatch = $p->fetchAll();
            Database::disconnect();
            return $coupon_dispatch;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getByDate(PrivilegedUser $u,$date_start,$date_end){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT cupon_egr_id,fecha,T1.cupon_ing_id,num,monto,vehiculo_id,conductor_id,usuario_id,dep_nm,concat(T3.user_nm1,' ',T3.user_nm2,' ',T3.user_ap1,' ',T3.user_ap2) as usuario_nombre,coalesce(km_inicial,0) as km_inicial,coalesce(km_final,0) as km_final,coalesce(galones_consumidos,0) as galones_consumidos,(km_final-km_inicial) AS km_recorridos,COALESCE((galones_consumidos/(km_final-km_inicial)),0) as km_galon,T1.status,T1.user_id
                        FROM df_cupon_egr AS T1
                        LEFT JOIN df_cupon_ing AS T2 ON T1.cupon_ing_id = T2.cupon_ing_id
                        LEFT JOIN vp_user AS T3 on T1.usuario_id = T3.user_id
                        LEFT JOIN vp_deptos AS T4 on T3.dep_id = T4.dep_id
                        WHERE  T1.status like 1 and T1.fecha >= ? and T1.fecha <= ?
                        ORDER BY YEAR(fecha) desc, MONTH(fecha) desc, usuario_id asc,vehiculo_id asc, num asc";
            $p = $pdo->prepare($sql);
            $p->execute(array($date_start,$date_end));
            $coupon_dispatch = $p->fetchAll();
            Database::disconnect();
            return $coupon_dispatch;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getNextGroup(PrivilegedUser $u){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT min(T1.cupon_ing_id) as cupon_ing_id,num,monto,T1.status,coalesce(T2.status,0) as egr_status, T3.status as pedido_status
                    FROM df_cupon_ing AS T1
                    LEFT JOIN (SELECT egr.cupon_ing_id as cupon_ing_id, sum(egr.status) as status FROM df_cupon_egr as egr GROUP BY cupon_ing_id) AS T2 ON  T1.cupon_ing_id = T2.cupon_ing_id
                    LEFT JOIN df_cupon_pedido AS T3 on T1.cupon_pedido_id = T3.cupon_pedido_id
                    WHERE T1.status like 1 and (coalesce(T2.status,0) like 0) and T3.status like 1
                    GROUP BY monto
                    ORDER BY  monto ASC";
            $p = $pdo->prepare($sql);
            $p->execute();
            $coupons = $p->fetchAll();
            Database::disconnect();
            return $coupons;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getNextAll(PrivilegedUser $u){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT T1.cupon_ing_id, num,monto,T1.status,coalesce(T2.status,0) as egr_status, T3.status as pedido_status
                    FROM df_cupon_ing AS T1
                    LEFT JOIN (SELECT egr.cupon_ing_id as cupon_ing_id, sum(egr.status) as status FROM df_cupon_egr as egr GROUP BY cupon_ing_id) AS T2 ON  T1.cupon_ing_id = T2.cupon_ing_id
                    LEFT JOIN df_cupon_pedido AS T3 on T1.cupon_pedido_id = T3.cupon_pedido_id
                    WHERE T1.status like 1 and (coalesce(T2.status,0) like 0)  and T3.status like 1";
            $p = $pdo->prepare($sql);
            $p->execute();
            $coupons = $p->fetchAll();
            Database::disconnect();
            return $coupons;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getAll(PrivilegedUser $u){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT cupon_egr_id,T1.fecha,T1.cupon_ing_id,num,monto,T1.vehiculo_id,nombre,placa,T1.conductor_id,concat(T5.user_nm1,' ',T5.user_nm2,' ',T5.user_ap1,' ',T5.user_ap2) as conductor_nombre,T1.usuario_id,concat(T6.user_nm1,' ',T6.user_nm2,' ',T6.user_ap1,' ',T6.user_ap2) as usuario_nombre,km_inicial,km_final,(km_final-km_inicial) AS km_recorridos,galones_consumidos,(galones_consumidos/(km_final-km_inicial)) as km_galon,T1.status
                        FROM df_cupon_egr AS T1
                        LEFT JOIN df_cupon_ing AS T2 on T1.cupon_ing_id = T2.cupon_ing_id
                        LEFT JOIN vp_vehiculo AS T3 on T1.vehiculo_id = T3.vehiculo_id
                        LEFT JOIN vp_conductor AS T4 on T1.conductor_id = T4.conductor_id
                        LEFT JOIN vp_user AS T5 on T4.user_id = T5.user_id
                        LEFT JOIN vp_user AS T6 on T1.usuario_id = T6.user_id
                        ORDER BY cupon_egr_id ASC";
            $p = $pdo->prepare($sql);
            $p->execute();
            $coupons_dispatch = $p->fetchAll();
            Database::disconnect();
            return $coupons_dispatch;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
}