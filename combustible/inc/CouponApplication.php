<?php

/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 23/11/2016
 * Time: 6:48 PM
 */
require_once ('CouponApplicationInterface.php');
class CouponApplication implements CouponApplicationInterface
{
    public $application;

    protected function __construct(){
        $this->application = array();
    }

    public static function create(PrivilegedUser $u,$account,$date,$fac_serie,$fac_num,$number,$code,$provider,$user_id){
        if($u->hasPrivilege('crearCupon')){
            if($account != '' && $date != '' && $fac_serie != '' && $fac_num != '' && $number > 0 && $code != '' && $provider > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO df_cupon_pedido(cta_id,fac_fecha,fac_serie,fac_num,pedido_num,codigo,prov_id,user_id) VALUES (?,?,?,?,?,?,?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($account,$date,$fac_serie,$fac_num,$number,$code,$provider,$user_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function validate(PrivilegedUser $u,$account,$date,$fac_serie,$fac_num,$number,$code,$provider,$user_id,$application_id){
        if($u->hasPrivilege('modificarCupon')){
            if($account != '' && $date != '' && $fac_serie != '' && $fac_num != '' && $number > 0 && $code != '' && $provider > 0 && $user_id > 0 && $application_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_cupon_pedido SET cta_id = ?,fac_fecha = ?,fac_serie = ?,fac_num = ?,pedido_num = ?,codigo = ?,prov_id = ?,status = 1,user_id = ?
                        WHERE cupon_pedido_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account,$date,$fac_serie,$fac_num,$number,$code,$provider,$user_id,$application_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function invalidate(PrivilegedUser $u,$comment,$user_id,$application_id){
        if($u->hasPrivilege('modificarCupon')){
            if($comment != '' && $user_id > 0 && $application_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_cupon_pedido SET comentario = ?,status = 0,user_id = ?
                        WHERE cupon_pedido_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($comment,$user_id,$application_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$account,$date,$fac_serie,$fac_num,$number,$code,$provider,$comment,$user_id,$application_id){
        if($u->hasPrivilege('modificarCupon')){
            if($account != '' && $date != '' && $fac_serie != '' && $fac_num != '' && $number > 0 && $code != '' && $provider > 0 && $user_id > 0 && $application_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_cupon_pedido SET cta_id = ?,fac_fecha = ?,fac_serie = ?,fac_num = ?,pedido_num = ?,codigo = ?,prov_id = ?,comentario = ?,status = 2,user_id = ?
                        WHERE cupon_pedido_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account,$date,$fac_serie,$fac_num,$number,$code,$provider,$comment,$user_id,$application_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getByID(PrivilegedUser $u,$application_id){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT T1.cupon_pedido_id,T1.cta_id,cta_num,fac_fecha,fac_serie,fac_num,pedido_num,codigo,T3.prov_id,prov_nm,prov_nit,comentario,sum(monto) as monto,sum(T5.status) as egresos,T1.status,T1.user_id
                FROM df_cupon_pedido AS T1
                LEFT JOIN df_cuenta AS T2 on T1.cta_id = T2.cta_id
                LEFT JOIN df_proveedor AS T3 on T1.prov_id = T3.prov_id
                LEFT JOIN (SELECT cupon_pedido_id,cupon_ing_id,monto FROM df_cupon_ing WHERE status like 1) AS T4 on T1.cupon_pedido_id = T4.cupon_pedido_id
                 LEFT JOIN (SELECT egr.cupon_ing_id as cupon_ing_id, sum(egr.status) as status FROM df_cupon_egr as egr WHERE egr.status like 1 GROUP BY cupon_ing_id) AS T5 ON  T4.cupon_ing_id = T5.cupon_ing_id
                WHERE  T1.cupon_pedido_id = ?";
        $p = $pdo->prepare($sql);
        $p->execute(array($application_id));
        $couponApplication = $p->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if(!empty($couponApplication)) {
            $application = new CouponApplication();
            $application->application['application_id'] = $couponApplication['cupon_pedido_id'];
            $application->application['account'] = $couponApplication['cta_id'];
            $application->application['account_num'] = $couponApplication['cta_num'];
            $application->application['date'] = $couponApplication['fac_fecha'];
            $application->application['fac_serie'] = $couponApplication['fac_serie'];
            $application->application['fac_num'] = $couponApplication['fac_num'];
            $application->application['invoice'] = $couponApplication['fac_serie'].'&#8209;'.$couponApplication['fac_num'];
            $application->application['number'] = $couponApplication['pedido_num'];
            $application->application['code'] = $couponApplication['codigo'];
            $application->application['provider'] = $couponApplication['prov_id'];
            $application->application['provider_nm'] = $couponApplication['prov_nm'];
            $application->application['provider_nit'] = $couponApplication['prov_nit'];
            $application->application['comment'] = $couponApplication['comentario'];
            $application->application['amount'] = $couponApplication['monto'];
            $application->application['status'] = $couponApplication['status'];
            $application->application['user'] = $couponApplication['user_id'];
            return $application;
        }else{
            throw new Exception('No se encontro el pedido.');
        }
    }
    public static function getAll(PrivilegedUser $u){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT T1.cupon_pedido_id,T1.cta_id,cta_num,fac_fecha,fac_serie,fac_num,pedido_num,codigo,T3.prov_id,prov_nm,prov_nit,sum(monto) as monto,sum(T5.status) as egresos,T1.status,T1.user_id
                FROM df_cupon_pedido AS T1
                LEFT JOIN df_cuenta AS T2 on T1.cta_id = T2.cta_id
                LEFT JOIN df_proveedor AS T3 on T1.prov_id = T3.prov_id
                LEFT JOIN (SELECT cupon_pedido_id,cupon_ing_id,monto FROM df_cupon_ing WHERE status like 1) AS T4 on T1.cupon_pedido_id = T4.cupon_pedido_id
                 LEFT JOIN (SELECT egr.cupon_ing_id as cupon_ing_id, sum(egr.status) as status FROM df_cupon_egr as egr WHERE egr.status like 1 GROUP BY cupon_ing_id) AS T5 ON  T4.cupon_ing_id = T5.cupon_ing_id
                GROUP BY T1.cupon_pedido_id
                ORDER BY cupon_pedido_id ASC";
        $p = $pdo->prepare($sql);
        $p->execute();
        $couponApplications = $p->fetchAll();
        Database::disconnect();
        return $couponApplications;
    }
}