<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 23/11/2016
 * Time: 6:44 PM
 */

interface CouponApplicationInterface
{
    public static function create(PrivilegedUser $u,$account,$date,$fac_serie,$fac_num,$number,$code,$provider,$user_id);
    public static function validate(PrivilegedUser $u,$account,$date,$fac_serie,$fac_num,$number,$code,$provider,$user_id,$application_id);
    public static function invalidate(PrivilegedUser $u,$comment,$user_id,$application_id);
    public static function update(PrivilegedUser $u,$account,$date,$fac_serie,$fac_num,$number,$code,$provider,$comment,$user_id,$application_id);
    public static function getByID(PrivilegedUser $u,$application_id);
    public static function getAll(PrivilegedUser $u);
}