<?php
namespace InteractivePlus\PDK2021\User;
class UserFormat{
    public static function encryptPassword(string $password, ?string $encryptionSalt){
        if(empty($encryptionSalt)){
            $encryptionSalt = '';
        }
        return strtoupper(hash('sha256',$password . $encryptionSalt));
    }
    public static function checkPasswordMatch(string $passwordToBeChecked, string $passwordHash, ?string $encryptionSalt){
        if(empty($encryptionSalt)){
            $encryptionSalt = '';
        }
        return self::encryptPassword($passwordToBeChecked,$encryptionSalt) === strtoupper($passwordHash);
    }
}