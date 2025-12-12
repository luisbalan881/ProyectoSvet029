<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 3:38 PM
 */

require_once ('TransactionInterface.php');

class Debit implements TransactionInterface
{
    public static function create(PrivilegedUser $u,$account_id,$date,$amount,$desc,$user_id)
    {
        if ($u->hasPrivilege('crearCheques')){
            if ($account_id > 0 && $date != '' && $amount > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO df_debito (cta_id,dbto_fecha,dbto_monto,dbto_desc,user_id) VALUES (?,?,?,?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date,$amount,$desc,$user_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$account_id,$date,$amount,$desc,$status,$user_id,$transaction_id){
        if ($u->hasPrivilege('modificarCheques')){
            if ($account_id > 0 && $date != '' && $amount > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_debito SET cta_id = ?,dbto_fecha = ?,dbto_monto = ?,dbto_desc = ?, dbto_status = ?, user_id = ? WHERE dbto_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date,$amount,$desc,$status,$user_id,$transaction_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getById(PrivilegedUser $u,$transaction_id){
        if ($u->hasPrivilege('leerCheques')){
            if ($transaction_id > 0 && $u->persona['user_id'] > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT dbto_id,T1.cta_id,cta_titular,cta_num,T2.bc_id,bc_nombre,T1.dbto_fecha,dbto_monto,dbto_desc,dbto_status,T1.user_id 
                        FROM vicepresidencia.df_debito AS T1
                        LEFT JOIN df_cuenta AS T2 on T1.cta_id = T2.cta_id
                        LEFT JOIN df_banco AS T3 on T2.bc_id = T3.bc_id
                        WHERE dbto_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($transaction_id));
                $debit = $p->fetch(PDO::FETCH_ASSOC);
                Database::disconnect();
                return $debit;
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getAll(PrivilegedUser $u){
        if ($u->hasPrivilege('leerCheques')){
            if ($u->persona['user_id'] > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT dbto_id,T1.cta_id,cta_titular,cta_num,T2.bc_id,bc_nombre,dbto_fecha,dbto_monto,dbto_desc,dbto_status,T1.user_id 
                        FROM vicepresidencia.df_debito AS T1
                        LEFT JOIN df_cuenta AS T2 on T1.cta_id = T2.cta_id
                        LEFT JOIN df_banco AS T3 on T2.bc_id = T3.bc_id
                        ORDER BY dbto_fecha DESC, dbto_id DESC";
                $p = $pdo->prepare($sql);
                $p->execute();
                $debits = $p->fetchAll();
                Database::disconnect();
                return $debits;
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

}