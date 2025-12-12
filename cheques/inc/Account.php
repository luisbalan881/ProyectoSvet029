<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 2:53 PM
 */
require_once ('AccountInterface.php');

class Account implements AccountInterface
{
    public $account;

    protected function __construct(){
        $this->account = array();
    }

    public static function getByID($account_id)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT cta_id, cta_titular, cta_num, T2.bc_id, bc_nombre, cta_status, T1.user_id
                FROM df_cuenta AS T1
                LEFT JOIN df_banco AS T2
                ON T1.bc_id = T2.bc_id 
                WHERE  cta_id = ?";
        $p = $pdo->prepare($sql);
        $p->execute(array($account_id));
        $cuenta = $p->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if(!empty($cuenta)) {
            $account = new Account();
            $account->account['id'] = $cuenta['cta_id'];
            $account->account['title'] = $cuenta['cta_titular'];
            $account->account['number'] = $cuenta['cta_num'];
            $account->account['bank_id'] = $cuenta['bc_id'];
            $account->account['bank_name'] = $cuenta['bc_nombre'];
            $account->account['status'] = $cuenta['cta_status'];
            $account->account['user'] = $cuenta['user_id'];
            return $account;
        }else{
            throw new Exception('No se encontro la cuenta.');
        }
    }

    public static function getAll()
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT cta_id, cta_titular, cta_num, T2.bc_id, bc_nombre, cta_status, T1.user_id
                FROM df_cuenta AS T1
                LEFT JOIN df_banco AS T2
                ON T1.bc_id = T2.bc_id 
                ORDER BY cta_id";
        $p = $pdo->prepare($sql);
        $p->execute();
        $accounts = $p->fetchAll();
        Database::disconnect();
        return $accounts;

    }

    public static function create(PrivilegedUser $u,$account_title,$account_num,$bank_id,$user_id)
    {
        if ($u->hasPrivilege('crearCheques')){
            if ($account_title != '' && $account_num != '' && $bank_id > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO df_cuenta (cta_titular,cta_num,bc_id,user_id) VALUES (?,?,?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_title,$account_num,$bank_id,$user_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$account_title,$account_num,$bank_id,$account_status,$user_id,$account_id)
    {
        if ($u->hasPrivilege('crearCheques')){
            if ($account_title != '' && $account_num != '' && $bank_id > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_cuenta SET cta_titular = ?, cta_num = ?, bc_id = ?, cta_status = ?, user_id = ?
                        WHERE cta_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_title,$account_num,$bank_id,$account_status,$user_id,$account_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function balance(PrivilegedUser $u,$account_id,$date_start,$date_end){
        if ($u->hasPrivilege('leerCheques')){
            if ($u->persona['user_id'] > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT T1.cta_id,cta_titular,cta_num,T1.bc_id,bc_nombre,mov_tipo,mov_prioridad,mov_fecha,mov_monto,mov_desc,mov_status,mov_user
                        FROM df_cuenta AS T1
                        LEFT JOIN df_banco AS T2 on T1.bc_id = T2.bc_id
                        LEFT JOIN(SELECT cta_id AS mov_cuenta,'credito' AS mov_tipo, 1 as mov_prioridad,cdto_fecha AS mov_fecha,cdto_monto AS mov_monto,cdto_desc AS mov_desc,cdto_status AS mov_status,user_id AS mov_user 
                                  FROM vicepresidencia.df_credito 
                                  UNION 
                                  SELECT cta_id AS mov_cuenta,'debito' AS mov_tipo, 2 as mov_prioridad,dbto_fecha AS mov_fecha,dbto_monto AS mov_monto,dbto_desc AS mov_desc,dbto_status AS mov_status,user_id AS mov_user 
                                  FROM vicepresidencia.df_debito
                                  UNION 
                                  SELECT cta_id AS mov_cuenta,'voucher' AS mov_tipo, 3 as mov_prioridad,vchr_fecha AS mov_fecha,vchr_monto AS mov_monto,concat('Voucher Num. ',vchr_num,', Proveedor: ',prov_nm,', NIT: ',prov_nit,', Descripción: ',vchr_desc) AS mov_desc,vchr_status AS mov_status,T1.user_id AS mov_user 
                                  FROM vicepresidencia.df_voucher AS T1
                                  LEFT JOIN vicepresidencia.df_proveedor AS T2 on T1.prov_id = T2.prov_id) as movimiento on T1.cta_id = movimiento.mov_cuenta
                        WHERE T1.cta_id = ? AND mov_fecha <= ? AND mov_fecha >= ?
                        ORDER BY mov_fecha,mov_prioridad ASC";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date_end,$date_start));
                $balance = $p->fetchAll();
                Database::disconnect();
                return $balance;
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function balanceTotalToDate(PrivilegedUser $u,$account_id,$date){
        if ($u->hasPrivilege('leerCheques')){
            if ($u->persona['user_id'] > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT T1.cta_id,cta_titular,cta_num,T1.bc_id,bc_nombre,mov_prioridad,mov_fecha,sum(mov_credito) as mov_credito,sum(mov_debito) as mov_debito
                        FROM df_cuenta AS T1
                        LEFT JOIN df_banco AS T2 on T1.bc_id = T2.bc_id
                        LEFT JOIN(SELECT cta_id AS mov_cuenta, 1 as mov_prioridad,cdto_fecha AS mov_fecha,cdto_monto AS mov_credito, 0 as mov_debito,cdto_desc AS mov_desc,cdto_status AS mov_status,user_id AS mov_user 
                                  FROM vicepresidencia.df_credito
                                  WHERE cdto_status = 1
                                  UNION 
                                  SELECT cta_id AS mov_cuenta, 2 as mov_prioridad,dbto_fecha AS mov_fecha,0 as mov_credito,dbto_monto AS mov_debito,dbto_desc AS mov_desc,dbto_status AS mov_status,user_id AS mov_user 
                                  FROM vicepresidencia.df_debito
                                  WHERE dbto_status = 1
                                  UNION 
                                  SELECT cta_id AS mov_cuenta, 3 as mov_prioridad,vchr_fecha AS mov_fecha,0 as mov_credito,vchr_monto AS mov_debito,concat('Voucher Num. ',vchr_num,', Proveedor: ',prov_nm,', NIT: ',prov_nit,', Descripción: ',vchr_desc) AS mov_desc,vchr_status AS mov_status,T1.user_id AS mov_user 
                                  FROM vicepresidencia.df_voucher AS T1
                                  LEFT JOIN vicepresidencia.df_proveedor AS T2 on T1.prov_id = T2.prov_id
                                  WHERE vchr_status = 1) as movimiento on T1.cta_id = movimiento.mov_cuenta
                        WHERE T1.cta_id = ? AND mov_fecha < ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date));
                $balance = $p->fetch(PDO::FETCH_ASSOC);
                Database::disconnect();
                return $balance;
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }
}