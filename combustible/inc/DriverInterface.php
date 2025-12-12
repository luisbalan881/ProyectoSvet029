<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 10:58 AM
 */

interface DriverInterface
{
    public static function create(PrivilegedUser $u,$user,$license,$expiration_date,$user_update);
    public static function update(PrivilegedUser $u,$user,$license,$expiration_date,$status,$user_update,$driver_id);
    public static function getByID(PrivilegedUser $u,$driver_id);
    public static function getAll(PrivilegedUser $u);
}