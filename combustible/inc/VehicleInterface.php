<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 24/11/2016
 * Time: 10:58 AM
 */

interface VehicleInterface
{
    public static function create(PrivilegedUser $u,$name,$line,$plate,$model,$cylinder,$fuel_id,$color,$user_id);
    public static function update(PrivilegedUser $u,$name,$line,$plate,$model,$cylinder,$fuel_id,$color,$status,$user_id,$vehicle);
    public static function getByID(PrivilegedUser $u,$vehicle_id);
    public static function getAll(PrivilegedUser $u);
}