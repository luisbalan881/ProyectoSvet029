<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 3:35 PM
 */

interface TransactionInterface
{
    public static function create(PrivilegedUser $u,$account_id,$date,$amount,$desc,$user_id);
    public static function update(PrivilegedUser $u,$account_id,$date,$amount,$desc,$status,$user_id,$transaction_id);
    public static function getById(PrivilegedUser $u,$transaction_id);
    public static function getAll(PrivilegedUser $u);
}