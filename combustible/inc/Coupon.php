<?php

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 11:03 AM
 */
require_once ('CouponInterface.php');
class Coupon implements CouponInterface
{
    public static function create(PrivilegedUser $u,$application_id,$start,$end,$issue_date,$expiration_date,$ammount,$user_id){
        if($u->hasPrivilege('crearCupon')){
            if($application_id > 0 && $issue_date != '' && $expiration_date != '' && $ammount > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO df_cupon_ing(cupon_pedido_id,fecha_emision,fecha_cad,num,monto,user_id) VALUES (?,?,?,?,?,?)";
                $p = $pdo->prepare($sql);
                for($number = $start;$number <= $end; $number++){
                    $p->execute(array($application_id,$issue_date,$expiration_date,$number,$ammount,$user_id));
                }
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$application_id,$issue_date,$expiration_date,$number,$ammount,$status,$user_id,$coupon_id){
        if($u->hasPrivilege('modificarCupon')){
            if($application_id > 0 && $issue_date != '' && $expiration_date != '' && $number > 0 && $ammount > 0 && $user_id > 0 && $coupon_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_cupon_ing SET cupon_pedido_id = ?,fecha_emision = ?,fecha_cad = ?,num = ?,monto = ?,status = ?,user_id = ?
                        WHERE cupon_ing_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($application_id,$issue_date,$expiration_date,$number,$ammount,$status,$user_id,$coupon_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getByID(PrivilegedUser $u,$coupon_id){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT cupon_ing_id,cupon_pedido_id,fecha_emision,fecha_cad,num,monto,status,user_id
                    FROM df_cupon_ing
                    WHERE  cupon_ing_id = ?";
            $p = $pdo->prepare($sql);
            $p->execute(array($coupon_id));
            $coupon = $p->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
            return $coupon;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getByApplication(PrivilegedUser $u,$application_id){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT T1.cupon_ing_id,cupon_pedido_id,fecha_emision,fecha_cad,num,monto,T1.status,T1.user_id,fecha,T2.vehiculo_id,nombre as vehiculo_nombre,placa,T2.conductor_id,concat(T5.user_nm1,' ',T5.user_nm2,' ',T5.user_ap1,' ',T5.user_ap2) as conductor_nombre,T2.usuario_id,concat(T6.user_nm1,' ',T6.user_nm2,' ',T6.user_ap1,' ',T6.user_ap2) as usuario_nombre,km_inicial,km_final,(km_final-km_inicial) AS km_recorridos,galones_consumidos,(galones_consumidos/(km_final-km_inicial)) as km_galon,T2.status as egr_status
                    FROM df_cupon_ing AS T1
                    LEFT JOIN df_cupon_egr AS T2 ON T1.cupon_ing_id = T2.cupon_ing_id and T2.status = 1
                    LEFT JOIN vp_vehiculo AS T3 on T2.vehiculo_id = T3.vehiculo_id
                    LEFT JOIN vp_conductor AS T4 on T2.conductor_id = T4.conductor_id
                    LEFT JOIN vp_user AS T5 on T4.user_id = T5.user_id
                    LEFT JOIN vp_user AS T6 on T2.usuario_id = T6.user_id
                    WHERE  T1.status like 1 and cupon_pedido_id = ?";
            $p = $pdo->prepare($sql);
            $p->execute(array($application_id));
            $coupons = $p->fetchAll();
            Database::disconnect();
            return $coupons;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getByApplicationByYearMonth(PrivilegedUser $u,$application_id,$year,$month){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT T1.cupon_ing_id,cupon_pedido_id,fecha_emision,fecha_cad,num,monto,T1.status,T1.user_id,fecha,T2.vehiculo_id,nombre as vehiculo_nombre,placa,T2.conductor_id,concat(T5.user_nm1,' ',T5.user_nm2,' ',T5.user_ap1,' ',T5.user_ap2) as conductor_nombre,T2.usuario_id,concat(T6.user_nm1,' ',T6.user_nm2,' ',T6.user_ap1,' ',T6.user_ap2) as usuario_nombre,coalesce(km_inicial,0) as km_inicial,coalesce(km_final,0) as km_final,coalesce((km_final-km_inicial),0) AS km_recorridos,coalesce(galones_consumidos,0) as galones_consumidos,coalesce((galones_consumidos/(km_final-km_inicial)),0) as km_galon,T2.status as egr_status
                    FROM df_cupon_ing AS T1
                    LEFT JOIN df_cupon_egr AS T2 ON T1.cupon_ing_id = T2.cupon_ing_id and T2.status = 1
                    LEFT JOIN vp_vehiculo AS T3 on T2.vehiculo_id = T3.vehiculo_id
                    LEFT JOIN vp_conductor AS T4 on T2.conductor_id = T4.conductor_id
                    LEFT JOIN vp_user AS T5 on T4.user_id = T5.user_id
                    LEFT JOIN vp_user AS T6 on T2.usuario_id = T6.user_id
                    WHERE  T1.status like 1 and cupon_pedido_id = ? and YEAR(fecha) like ? and MONTH(fecha) like ?
                    ORDER BY  usuario_id asc, placa asc, fecha asc";
            $p = $pdo->prepare($sql);
            $p->execute(array($application_id,$year,$month));
            $coupons = $p->fetchAll();
            Database::disconnect();
            return $coupons;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getGroupByApplication(PrivilegedUser $u,$application_id){
        if($u->hasPrivilege('leerCupon')){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT T1.cupon_ing_id,T1.cupon_pedido_id,T5.pedido_num,sum(monto) as monto,concat(YEAR(fecha),'-',MONTH(fecha)) as fecha,T2.vehiculo_id,nombre as vehiculo_nombre,placa,T2.usuario_id,concat(T6.user_nm1,' ',T6.user_nm2,' ',T6.user_ap1,' ',T6.user_ap2) as usuario_nombre
                    FROM df_cupon_ing AS T1
                    INNER JOIN df_cupon_egr AS T2 ON T1.cupon_ing_id = T2.cupon_ing_id and T2.status = 1
                    LEFT JOIN vp_vehiculo AS T3 on T2.vehiculo_id = T3.vehiculo_id
                    LEFT JOIN vp_conductor AS T4 on T2.conductor_id = T4.conductor_id
                    LEFT JOIN df_cupon_pedido AS T5 on T1.cupon_pedido_id = T5.cupon_pedido_id
                    LEFT JOIN vp_user AS T6 on T2.usuario_id = T6.user_id 
                    WHERE  T1.status like 1 and T1.cupon_pedido_id = ?
                    GROUP BY concat(YEAR(fecha),MONTH(fecha),T2.usuario_id,placa)
                    ORDER BY YEAR(fecha) asc, MONTH(fecha) asc,usuario_id asc, placa asc";
            $p = $pdo->prepare($sql);
            $p->execute(array($application_id));
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
            $sql = "SELECT cupon_ing_id,cupon_pedido_id,fecha_emision,fecha_cad,num,monto,status,user_id
                    FROM df_cupon_ing
                    ORDER BY  monto ASC, num ASC";
            $p = $pdo->prepare($sql);
            $p->execute();
            $coupons = $p->fetchAll();
            Database::disconnect();
            return $coupons;
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
}