<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 3:38 PM
 */

require_once ('VoucherInterface.php');

class Voucher implements VoucherInterface
{
    public static function create(PrivilegedUser $u,$account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve)
    {
        if ($u->hasPrivilege('crearCheques')){
            if ($account_id > 0 && $date != '' && $number > 0 && $amount > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO vicepresidencia.df_voucher (cta_id,vchr_fecha,vchr_num,vchr_monto,vchr_desc,prov_id,user_id,vchr_autoriza) VALUES (?,?,?,?,?,?,?,?)";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function update(PrivilegedUser $u,$account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve,$check_file,$voucher_file,$status,$voucher_id){
        if ($u->hasPrivilege('modificarCheques')){
            if ($account_id > 0 && $date != '' && $number > 0 && $amount > 0 && $user_id > 0){
                $path = self::checkPath($number);
                date_default_timezone_set('America/Guatemala');
                $time = time();
                $voucher = self::getById($u,$voucher_id);
                $vchr_cheque_file = $voucher['vchr_cheque_file'];
                $vchr_voucher_file = $voucher['vchr_cheque_file'];
                if($check_file){
                    $new_file_name = $number.' - CHEQUE '.$time.'.'.strtolower(pathinfo($check_file['name'],PATHINFO_EXTENSION));
                    if (self::upload($check_file,$new_file_name,$path)){
                        $vchr_cheque_file = $new_file_name;
                    }
                }
                if($voucher_file){
                    $new_file_name = $time.' - VOUCHER.'.strtolower(pathinfo($voucher_file['name'],PATHINFO_EXTENSION));
                    if (self::upload($voucher_file,$new_file_name,$path)){
                        $vchr_voucher_file = $new_file_name;
                    }
                }
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE vicepresidencia.df_voucher SET cta_id = ?,vchr_fecha = ?,vchr_num = ?,vchr_monto = ?,vchr_desc = ?,prov_id = ?,user_id = ?,vchr_autoriza = ?,vchr_cheque_file = ?,vchr_voucher_file = ?,vchr_status = ? WHERE vchr_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve,$vchr_cheque_file,$vchr_voucher_file,$status,$voucher_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function invalidate(PrivilegedUser $u,$account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve,$status,$voucher_id){
        if ($u->hasPrivilege('modificarCheques')){
            if ($account_id > 0 && $date != '' && $number > 0 && $amount > 0 && $user_id > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE vicepresidencia.df_voucher SET cta_id = ?,vchr_fecha = ?,vchr_num = ?,vchr_monto = ?,vchr_desc = ?,prov_id = ?,user_id = ?,vchr_autoriza = ?,vchr_status = ? WHERE vchr_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve,$status,$voucher_id));
                Database::disconnect();
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function getById(PrivilegedUser $u,$voucher_id){
        if ($u->hasPrivilege('leerCheques')){
            if ($voucher_id > 0 && $u->persona['user_id'] > 0){
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT vchr_id,T1.cta_id,cta_titular,cta_num,T2.bc_id,bc_nombre,T1.vchr_fecha,vchr_num,vchr_monto,vchr_desc,T1.prov_id,prov_nm,prov_nit,T1.user_id,concat(T5.user_nm1,' ',T5.user_ap1) AS user_nombre,T5.user_puesto,vchr_autoriza,vchr_cheque_file,vchr_voucher_file,vchr_status
                        FROM vicepresidencia.df_voucher AS T1
                        LEFT JOIN df_cuenta AS T2 on T1.cta_id = T2.cta_id
                        LEFT JOIN df_banco AS T3 on T2.bc_id = T3.bc_id
                        LEFT JOIN df_proveedor AS T4 on T1.prov_id = T4.prov_id
                        LEFT JOIN vp_user AS T5 on T1.user_id = T5.user_id
                        WHERE vchr_id = ?";
                $p = $pdo->prepare($sql);
                $p->execute(array($voucher_id));
                $voucher = $p->fetch(PDO::FETCH_ASSOC);
                Database::disconnect();
                return $voucher;
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
                $sql = "SELECT vchr_id,T1.cta_id,cta_titular,cta_num,T2.bc_id,bc_nombre,T1.vchr_fecha,vchr_num,vchr_monto,vchr_desc,T1.prov_id,prov_nm,prov_nit,T1.user_id,concat(T5.user_nm1,' ',T5.user_ap1) AS user_nombre,T5.user_puesto,vchr_autoriza,vchr_cheque_file,vchr_voucher_file,vchr_status
                        FROM vicepresidencia.df_voucher AS T1
                        LEFT JOIN df_cuenta AS T2 on T1.cta_id = T2.cta_id
                        LEFT JOIN df_banco AS T3 on T2.bc_id = T3.bc_id
                        LEFT JOIN df_proveedor AS T4 on T1.prov_id = T4.prov_id
                        LEFT JOIN vp_user AS T5 on T1.user_id = T5.user_id
                        ORDER BY vchr_fecha DESC, vchr_id DESC";
                $p = $pdo->prepare($sql);
                $p->execute();
                $vouchers = $p->fetchAll();
                Database::disconnect();
                return $vouchers;
            }else{
                throw new Exception('No se proporcionaron todos los datos necesarios.');
            }
        }else{
            throw new Exception('Usuario no tiene privilegios suficientes.');
        }
    }

    public static function nuevoVoucherNum() {
        $pdo = Database::connect();
        $sql ='SELECT T1.vchr_id,COALESCE(T1.vchr_num,0) AS ultimo_voucher,  (COALESCE(T1.vchr_num,0) + 1) AS nuevo_voucher
           FROM vicepresidencia.df_voucher AS T1
           ORDER BY vchr_id DESC
           LIMIT 1';
        $f = $pdo->prepare($sql);
        $f->execute();
        $voucher= $f->fetch(PDO::FETCH_ASSOC);
        $voucher_num = $voucher['nuevo_voucher'];
        Database::disconnect();
        if (number_format($voucher_num) == 0){$voucher_num = 1;}
        return $voucher_num;
    }

    public static function duplicadoVoucherNum(PrivilegedUser $u,$validar_num,$id){
        $duplicado = false;
        foreach (self::getAll($u) as $voucher){
            $vchr_id = $voucher['vchr_id'];
            $vchr_num = $voucher['vchr_num'];
            if ($vchr_num == $validar_num && $vchr_id != $id){
                $duplicado=true;
            }
        }
        return $duplicado;
    }

    public static function upload($file,$new_file_name,$path){
        if($file['error'] == 0)
        {
            //moverlo a la carpeta deseada
            move_uploaded_file($file['tmp_name'], $path.'/'.$new_file_name);
            //echo $message = 'El archivo se proceso correctamente.';
            return true;
        }else{
            //echo $message = 'Lo sentimos, se produjo un error al procesar el archivo.'.$file['error'];
            return false;
        }
    }

    public static function checkPath($vchr_num){
        $path = 'adjuntos/'.sanear_string($vchr_num);
        $path = iconv("UTF-8","Windows-1252",$path);
        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }
        return $path;
    }

}
