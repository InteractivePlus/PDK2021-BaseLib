<?php
namespace InteractivePlus\PDK2021Core\Communication\VerificationCode;
class VeriCodeFormat{
    const VERI_CODE_BYTE_LENGTH = 16;
    const VERI_CODE_PARTIAL_PHONE_LENGTH = 6;
    public static function getVeriCodeByteLength() : int{
        return self::VERI_CODE_BYTE_LENGTH;
    }
    public static function getVeriCodeStringLength() : int{
        return (self::VERI_CODE_BYTE_LENGTH * 2);
    }
    public static function generateVerificationCode() : string{
        return self::formatVerificationCode(bin2hex(random_bytes(self::getVeriCodeByteLength())));
    }
    public static function isValidVerificationCode(string $code) : bool{
        return strlen($code) === self::getVeriCodeStringLength();
    }
    public static function isValidPartialPhoneVerificationCode(string $code) : bool{
        return strlen($code) === self::VERI_CODE_PARTIAL_PHONE_LENGTH;
    }
    public static function getPartialPhoneCode(string $code) : string{
        return substr($code,0,self::VERI_CODE_PARTIAL_PHONE_LENGTH);
    }
    public static function formatVerificationCode(string $code) : string{
        return strtoupper($code);
    }
    public static function isVeriCodeStringEqual(string $code1, string $code2) : bool{
        return self::formatVerificationCode($code1) === self::formatVerificationCode($code2);
    }

    public static function formatPartialPhoneCode(string $code) : string{
        return strtoupper($code);
    }

    public static function isPartialPhoneCodeEqual(string $code1, string $code2) : bool{
        return self::formatPartialPhoneCode($code1) === self::formatPartialPhoneCode($code2);
    }
}