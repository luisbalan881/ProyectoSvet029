<?php
/**
 * Created by PhpStorm.
 * User: usuario
 * Date: 11/10/2016
 * Time: 2:56 PM
 */

interface BankInterface
{
    public static function getBankById($bank_id);
    public static function getBankAll();
    public static function createBank(PrivilegedUser $u,$bank_name,$user_id);
    public static function updateBank(PrivilegedUser $u,$bank_name,$bank_status,$user_id,$bank_id);
    public static function countBankByStatus($bank_status);
}