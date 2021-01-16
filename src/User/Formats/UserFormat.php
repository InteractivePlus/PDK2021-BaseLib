<?php
namespace InteractivePlus\PDK2021Core\User\Formats;
class UserFormat{
    /** 
     * https://stackoverflow.com/questions/2240973/how-long-is-the-sha256-hash
     * using a hexidecimal representation, each character represents 4 bits.
     * since SHA256 gives 256 bits, we should have a string with length 256/4 = 64
     */
    const PASSWORD_HASH_LEN = 64;
    public static function isPasswordHashValid(string $hash) : bool{
        return strlen($hash) === self::PASSWORD_HASH_LEN;
    }
    public static function formatPasswordHash(string $hash) : string{
        return strtoupper($hash);
    }
    public static function encryptPassword(string $password, ?string $encryptionSalt) : string{
        if(empty($encryptionSalt)){
            return self::formatPasswordHash(hash('sha256',$password));
        }else{
            return self::formatPasswordHash(hash('sha256',$password . $encryptionSalt));
        }
    }
    public static function checkPasswordMatch(string $passwordToBeChecked, string $passwordHash, ?string $encryptionSalt){
        if(empty($encryptionSalt)){
            $encryptionSalt = '';
        }
        return self::encryptPassword($passwordToBeChecked,$encryptionSalt) === self::formatPasswordHash($passwordHash);
    }
}