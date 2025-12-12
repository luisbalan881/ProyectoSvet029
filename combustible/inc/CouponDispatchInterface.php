<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 10:58 AM
 */

interface CouponDispatchInterface
{
    public static function create(PrivilegedUser $u,$date,$coupon_key,$vehicle_id,$driver_id,$user,$km_start,$km_end,$consumed_fuel,$quantity,$user_id);
    public static function update(PrivilegedUser $u,$date,$coupon_id,$vehicle_id,$driver_id,$user,$km_start,$km_end,$consumed_fuel,$status,$user_id,$coupon_dispatch_id);
    public static function getByID(PrivilegedUser $u,$coupon_dispatch_id);
    public static function getByVehicleID(PrivilegedUser $u,$vehicle_id,$date_start,$date_end);
    public static function getNextGroup(PrivilegedUser $u);
    public static function getNextAll(PrivilegedUser $u);
    public static function getAll(PrivilegedUser $u);
}