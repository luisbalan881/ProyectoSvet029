<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 11:41 AM
 */

interface AccountInterface
{
    public static function getByID($account_id);
    public static function getAll();
    public static function create(PrivilegedUser $u,$account_title,$account_num,$bank_id,$user_id);
    public static function update(PrivilegedUser $u,$account_title,$account_num,$bank_id,$account_status,$user_id,$account_id);
    public static function balance(PrivilegedUser $u,$account_id,$date_start,$date_end);
    public static function balanceTotalToDate(PrivilegedUser $u,$account_id,$date);
}