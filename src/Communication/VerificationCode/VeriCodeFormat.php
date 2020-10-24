<?php
namespace InteractivePlus\PDK2021\Communication\VerificationCode;
class VeriCodeFormat{
    const VERI_CODE_BYTE_LENGTH = 16;
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
    public static function formatVerificationCode(string $code) : string{
        return strtoupper($code);
    }
    public static function isVeriCodeStringEqual(string $code1, string $code2) : bool{
        return self::formatVerificationCode($code1) === self::formatVerificationCode($code2);
    }
}