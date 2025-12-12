<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 3:35 PM
 */

interface VoucherInterface
{
    public static function create(PrivilegedUser $u,$account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve);
    public static function update(PrivilegedUser $u,$account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve,$check_file,$voucher_file,$status,$voucher_id);
    public static function invalidate(PrivilegedUser $u,$account_id,$date,$number,$amount,$desc,$provider,$user_id,$approve,$status,$voucher_id);
    public static function getById(PrivilegedUser $u,$voucher_id);
    public static function getAll(PrivilegedUser $u);
    public static function nuevoVoucherNum();
    public static function duplicadoVoucherNum(PrivilegedUser $u,$validar_num,$id);
    public static function upload($file,$new_file_name,$path);
    public static function checkPath($vchr_num);
}
