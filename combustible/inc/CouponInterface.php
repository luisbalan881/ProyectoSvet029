<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 10:58 AM
 */

interface CouponInterface
{
    public static function create(PrivilegedUser $u,$application_id,$start,$end,$issue_date,$expiration_date,$ammount,$user_id);
    public static function update(PrivilegedUser $u,$application_id,$issue_date,$expiration_date,$number,$ammount,$status,$user_id,$coupon_id);
    public static function getByID(PrivilegedUser $u,$coupon_id);
    public static function getByApplication(PrivilegedUser $u,$application_id);
    public static function getAll(PrivilegedUser $u);
}