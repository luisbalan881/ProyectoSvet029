<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 10/10/2016
 * Time: 11:57 AM
 */
require_once ('BankInterface.php');

class Bank implements BankInterface
{
    public $bank;

    protected function __construct(){
        $this->bank= array();
    }

    public static function getBankById($bank_id)
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT bc_id, bc_nombre,bc_status
                FROM df_banco 
                WHERE  bc_id = ?";
        $p = $pdo->prepare($sql);
        $p->execute(array($bank_id));
        $banco = $p->fetch(PDO::FETCH_ASSOC);
        Database::disconnect();

        if(!empty($banco)) {
            $bank = new Bank();
            $bank->bank['id'] = $banco['bc_id'];
            $bank->bank['name'] = $banco['bc_nombre'];
            $bank->bank['status'] = $banco['bc_status'];
            return $bank;
        }else{
            return false;
        }
    }

    public static function getBankAll()
    {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT bc_id, bc_nombre,bc_status
                FROM df_banco 
                ORDER BY bc_id";
        $p = $pdo->prepare($sql);
        $p->execute();
        $banks = $p->fetchAll();
        Database::disconnect();
        return $banks;
    }

    public static function createBank(PrivilegedUser $u,$bank_name,$user_id)
    {
        if ($u->hasPrivilege('crearCheques')){
            if ($bank_name != ''){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO df_banco (bc_nombre,user_id) VALUES (?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($bank_name,$user_id));
                Database::disconnect();
            }else{
                throw new Exception('El nombre no puede ser una cadena vacía.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function updateBank(PrivilegedUser $u,$bank_name,$bank_status,$user_id,$bank_id)
    {
        if ($u->hasPrivilege('modificarCheques')){
            if($bank_name != ''){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE df_banco SET bc_nombre = ?, bc_status = ?, user_id = ?
                        WHERE bc_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($bank_name,$bank_status,$user_id,$bank_id));
                Database::disconnect();
            }else{
                throw new Exception('El nombre no puede ser una cadena vacía.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function countBankByStatus($bank_status)
    {
        if ($bank_status > 0){
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT count(bc_id) AS total 
                    FROM df_banco
                    WHERE bc_status = ?";
            $p = $pdo->prepare($sql);
            $p->execute(array($bank_status));
            $count = $p->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
            return $count['total'];
        }else{
            throw new Exception('Ingrese un estado de banco valido.');
        }
    }

}